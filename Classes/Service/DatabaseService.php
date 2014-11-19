<?php

namespace HARING\Crystalis\Service;

/*
 * **************************************************************
 * Copyright notice
 *
 * (c) 2014 Daniel Haring <development@haring.co.at>
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 * **************************************************************
 */

use \HARING\Crystalis\Utility\GeneralUtility;





/**
 * Service for accessing database from any point.
 *
 * @since 2.0.0
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class DatabaseService implements \TYPO3\CMS\Core\SingletonInterface {
    
    
    
    
    
    /**
     * Buffer for already processed queries.
     * 
     * @since 2.0.0
     * @var array
     * @access private
     */
    private $Buffer;
    
    
    
    
    
    /**
     * Fetches "domain => language" assignments from database or returns buffered result if a respecitve entry was found.
     * API method.
     * 
     * @since 2.0.0
     * @param boolean $noBuffer (Optional) If set to TRUE the result won't be buffered. This may be useful if you 
     *                          are certain that this specific call won't be done additional times.
     * @return array Retrieved assignements
     * @access public
     */
    public function getDomainAssignments($noBuffer = \FALSE) {
        
        $bufferIdentifier = 'domainAssignments';
        
        if($this->isBuffered($bufferIdentifier)) {
            
            return $this->getBufferedResult($bufferIdentifier);
            
        }
        
        $result = \array_map(function($site) {
                    
                    $site['languages'] = \array_map(function($language) {
                        
                        return [
                            'uid' => $language,
                            'isoCode' => \strtolower($this->getSystemLanguages()[$language]['isoCode'])
                        ];
                        
                    }, \array_filter(\explode(',', $site['languages'])));
                    
                    if(!!$site['useDefaultLanguage']) {
                        
                        $site['languages'][] = [
                            'uid' => 0,
                            'isoCode' => \strtolower($this->getSystemLanguages()[0]['isoCode'])
                        ];
                        
                    }
                    
                    return $site;
                    
                }, $this->getDatabaseConnection()->exec_SELECTgetRows(
                        'domain.domainName AS host, page.uid AS rootPage, ' 
                                . '(SELECT GROUP_CONCAT(overlay.sys_language_uid) FROM pages_language_overlay overlay ' 
                                . 'WHERE pid=page.uid AND overlay.deleted=0 AND overlay.hidden=0) AS languages, ' 
                                . 'IF(page.l18n_cfg=1||page.l18n_cfg=3,0,1) AS useDefaultLanguage, domain.sorting AS priority, ' 
                                . 'domain.tx_crystalis_language AS initialLanguage, ' 
                                . 'CASE page.url_scheme WHEN \'2\' THEN \'https\' ELSE \'http\' END protocol', 
                        'sys_domain domain INNER JOIN pages page ON (domain.pid = page.uid)', 
                        'domain.redirectTo=\'\' AND domain.hidden=0 ' 
                                . 'AND page.is_siteroot=1 AND page.deleted=0 AND page.hidden=0', 
                        '', 
                        'domain.sorting ASC', 
                        '', 
                        'host'));
        
        if(!$noBuffer) {
            
            $this->buffer($result, $bufferIdentifier);
            
        }
        
        return $result;
        
    }
    
    
    
    
    
    /**
     * Fetches defined system languages from database or returns buffered result if a respective entry was found.
     * API method.
     * 
     * @since 2.0.0
     * @param boolean $noBuffer (Optional) If set to TRUE the result won't be buffered. This may be useful if you
     *                          are certain that this specific call won't be done additional times.
     * @return array Retrieved system languages
     * @access public
     */
    public function getSystemLanguages($noBuffer = \FALSE) {
        
        $bufferIdentifier = 'systemLanguages';
        
        if($this->isBuffered($bufferIdentifier)) {
            
            return $this->getBufferedResult($bufferIdentifier);
            
        }
        
        $extConf = \array_merge(
                    ['defaultLanguage' => 30],
                    (array)@\unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['crystalis']));
        
        $result = $this->getDatabaseConnection()->exec_SELECTgetRows(
                '0 AS uid, static.lg_iso_2 AS isoCode, static.lg_collate_locale AS locale, ' 
                        . 'static.lg_name_local AS localName', 
                'static_languages AS static', 
                'uid=' . (int)$extConf['defaultLanguage'] 
                        . ' UNION SELECT sys.uid, static.lg_iso_2 AS isoCode, ' 
                        . 'static.lg_collate_locale AS locale, static.lg_name_local AS localName ' 
                        . 'FROM static_languages static INNER JOIN sys_language sys ON ' 
                        . '(sys.static_lang_isocode = static.uid) WHERE sys.pid=0 AND sys.hidden=0', 
                'static.lg_iso_2', 
                '', 
                '', 
                'uid');
        
        if(!$noBuffer) {
            
            $this->buffer($result, $bufferIdentifier);
            
        }
        
        return $result;
        
    }
    
    
    
    
    
    /**
     * Returns active database connection or establishes a new one if none is active.
     * If a new database connection was established it will be saved to $GLOBALS['TYPO3_DB']. This behaviour 
     * may look kind of unclean but is quite intended. Because realurl also needs a database connection and 
     * askes for TYPO3_DB to be set, the established connection can be reused and therefore there won't be 
     * an additional one.
     * 
     * @since 2.0.0
     * @return \TYPO3\CMS\Core\Database\DatabaseConnection The current database connection
     * @access public
     */
    public function getDatabaseConnection() {
        
        if(!\is_a($GLOBALS['TYPO3_DB'], 'TYPO3\\CMS\\Core\\Database\\DatabaseConnection')) {
            
            $GLOBALS['TYPO3_DB'] = GeneralUtility::obtainDatabaseConnection();
            
        }
        
        return $GLOBALS['TYPO3_DB'];
        
    }
    
    
    
    
    
    /**
     * Bufferes a specific query result.
     * 
     * @since 2.0.0
     * @param mixed $result The query result to buffer
     * @param string $identifier Internal identifier for this specific entry
     * @param string $hash (Optional) Hash to differ arguments from multiple calls
     * @access protected
     */
    protected function buffer($result, $identifier, $hash = '_DEFAULT') {
        
        $this->Buffer[(string)$identifier][(string)$hash] = $result;
        
    }
    
    
    
    
    
    /**
     * Returns a buffered result.
     * 
     * @since 2.0.0
     * @param string $identifier Internal buffer identifier of the result to return.
     * @param string $hash (Optional) The arguments hash of which to return the result for.
     * @return mixed The buffered entry
     * @access protected
     */
    protected function getBufferedResult($identifier, $hash = '_DEFAULT') {
        
        return $this->Buffer[(string)$identifier][(string)$hash];
        
    }
    
    
    
    
    
    /**
     * Checks wheter a specific result was buffered.
     * 
     * @since 2.0.0
     * @param string $identifier Internal buffer identifier of the result to check.
     * @param string $hash (Optional) The arguments hash which to take into account.
     * @return boolean TRUE if the result was buffered, FALSE otherwise
     * @access protected
     */
    protected function isBuffered($identifier, $hash = '_DEFAULT') {
        
        return isset($this->Buffer[(string)$identifier]) && isset($this->Buffer[(string)$identifier][(string)$hash]);
        
    }
    
    
    
    
    
}




