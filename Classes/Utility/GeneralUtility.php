<?php

namespace DanielHaring\Crystalis\Utility;

/*
 * **************************************************************
 * Copyright notice
 *
 * (c) 2015 Daniel Haring <development@haring.co.at>
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

use TYPO3\CMS\Core\Database\DatabaseConnection;





/**
 * Various helper functions.
 *
 * @since 6.2.0
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class GeneralUtility {
    
    
    
    
    
    /**
     * Returns the TYPO3 database connection or establishes a new one if it doesn't exist.
     * Basically a static version of \TYPO3\CMS\Core\Core->InitializeTypo3DbGlobal.
     * 
     * @since 6.2.0
     * @return \TYPO3\CMS\Core\Database\DatabaseConnection The TYPO3 database object
     * @access public
     * @static
     */
    public static function obtainDatabaseConnection() {
        
        $fqcn = DatabaseConnection::class;

        if($GLOBALS['TYPO3_DB'] instanceof $fqcn) {

            return $GLOBALS['TYPO3_DB'];

        }
        
        /** @var $DatabaseConnection \TYPO3\CMS\Core\Database\DatabaseConnection */
        $DatabaseConnection = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance($fqcn);
        $DatabaseConnection->setDatabaseName(\TYPO3_db);
        $DatabaseConnection->setDatabaseUsername(\TYPO3_db_username);
        $DatabaseConnection->setDatabasePassword(\TYPO3_db_password);
        
        $databaseHost = \TYPO3_db_host;
        
        if(isset($GLOBALS['TYPO3_CONF_VARS']['DB']['port'])) {
            
            $DatabaseConnection->setDatabasePort($GLOBALS['TYPO3_CONF_VARS']['DB']['port']);
            
        } elseif (\strpos($databaseHost, ':') > 0) {
            
            /**
             * @todo Monitor if something is changed here in versions after TYPO3 CMS 6.2.5
             */
            list($databaseHost, $databasePort) = explode(':', $databaseHost);
            $DatabaseConnection->setDatabasePort($databasePort);
            
        }
        
        if(isset($GLOBALS['TYPO3_CONF_VARS']['DB']['socket'])) {
            
            $DatabaseConnection->setDatabaseSocket($GLOBALS['TYPO3_CONF_VARS']['DB']['socket']);
            
        }
        
        $DatabaseConnection->setDatabaseHost($databaseHost);
        
        if(isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['no_pconnect']) 
                && !$GLOBALS['TYPO3_CONF_VARS']['SYS']['no_pconnect']) {
            
            $DatabaseConnection->setPersistentDatabaseConnection(\TRUE);
            
        }
        
        if(!!$GLOBALS['TYPO3_CONF_VARS']['SYS']['dbClientCompress'] 
                && ($databaseHost === 'localhost' || $databaseHost === '127.0.0.1' || $databaseHost === '::1')) {
            
            $DatabaseConnection->setConnectionCompression(\TRUE);
            
        }
        
        if(!empty($GLOBALS['TYPO3_CONF_VARS']['SYS']['setDBinit'])) {
            
            $cmd = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(
                    \LF, 
                    \str_replace('\' . LF . \'', \LF, $GLOBALS['TYPO3_CONF_VARS']['SYS']['setDBinit']), 
                    \TRUE);
            
            $DatabaseConnection->setInitializeCommandsAfterConnect($cmd);
            
        }
        
        $DatabaseConnection->initialize();
        
        return $DatabaseConnection;
        
    }
    
    
    
    
    
}




