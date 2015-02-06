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





/**
 * Service for automated language handling.
 *
 * @since 2.0.0
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class LanguageService implements \TYPO3\CMS\Core\SingletonInterface {
    
    
    
    
    
    /**
     * DatabaseService Instance.
     * 
     * @since 2.0.0
     * @var \HARING\Crystalis\Service\DatabaseService
     * @access private
     */
    private $DatabaseService;
    
    /**
     * Buffer for language PageTS configuration.
     * 
     * @since 2.0.0
     * @var string
     * @access private
     */
    private $pageTSConfig;
    
    /**
     * Buffer for language TypoScript setup.
     * 
     * @since 2.0.0
     * @var string
     * @access private
     */
    private $typoScriptSetup;
    
    
    
    
    
    /**
     * Returns language TypoScript setup and constructs it if neccessary.
     * API method.
     * 
     * @since 2.0.0
     * @return string The constructed or stored TypoScript setup
     * @access public
     */
    public function getTypoScriptSetup() {
        
        if(\is_array($this->typoScriptSetup)) {
            
            return $this->typoScriptSetup;
            
        }
        
        $setup = [];
        
        foreach($this->getDatabaseService()->getSystemLanguages() as $language) {
            
            $ts = 'page.config.htmlTag_langKey = ' . \strtolower($language['isoCode']) . \chr(10)
                    . 'page.config.sys_language_uid = ' . $language['uid'] . \chr(10) 
                    . 'page.config.language = ' . \strtolower($language['isoCode']) . \chr(10) 
                    . 'page.config.lang = ' . \strtolower($language['isoCode']) . \chr(10) 
                    . 'page.config.locale_all = ' . $language['locale'];
            
            if((int)$language['uid'] > 0) {
                
                $ts = \sprintf('[globalVar = GP:L=' . $language['uid'] . "]\n%s\n[global]", $ts);
                
            }
            
            $setup[] = $ts;
            
        }
        
        return \implode(\chr(10), $setup);
        
    }
    
    
    
    
    
    /**
     * Returns language PageTS configuration and constructs it if neccessary.
     * API method.
     * 
     * @since 2.0.0
     * @return string The constructed or stored PageTS configuration
     * @access public
     */
    public function getPageTSConfig() {
        
        if(\is_array($this->pageTSConfig)) {
            
            return $this->pageTSConfig;
            
        }
        
        $pageTs = '';
        
        $defaultLanguage = \reset(\array_filter($this->getDatabaseService()->getSystemLanguages(), function($language) {
            
            return (int)$language['uid'] === 0;
            
        }));
        
        if(\is_array($defaultLanguage)) {
            
            $pageTs .= 'mod.SHARED.defaultLanguageFlag = ' . (isset($defaultLanguage['locale']) 
                    ? \strtolower(\end(\explode('_', $defaultLanguage['locale']))) 
                    : \strtolower($defaultLanguage['isoCode'])) 
                . chr(10) . 'mod.SHARED.defaultLanguageLabel = ' . $defaultLanguage['localName'];
            
        }
        
        return $pageTs;
        
    }
    
    
    
    
    
    /**
     * Prepares URL rewriting extensions. Extension realurl is the only one supported by default.
     * API method.
     * 
     * @since 2.0.0
     * @access public
     */
    public function prepareUrlRewriting() {
        
        $Registry = ['realurl' => 'HARING\\Crystalis\\Configuration\\UrlRewriting\\RealurlConfigurator'];
        $ObjectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        
            // Hook for registering addtitional extensions to be prepared.
        if(\is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['crystalis']['LanguageService']['registerRewriteConfigurator'])) {
            
            foreach($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['crystalis']['LanguageService']['registerRewriteConfigurator'] as $fn) {
                
                if($additionalConfigurators = \TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction($fn, $Registry, $this)) {
                    
                    $Registry = \array_merge($Registry, \array_filter((array)$additionalConfigurators, 'is_string'));
                    
                }
                
            }
            
        }
        
        foreach($Registry as $extKey => $classRef) {
            
            if(!\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded($extKey)) {
                continue;
            }
            
            $userObj = $ObjectManager->get($classRef);
            
            if(!\is_a($userObj, 'HARING\\Crystalis\\Configuration\\UrlRewriting\\ConfiguratorInterface')) {
                
                throw new \RuntimeException('Class \'' . \get_class($userObj) . 
                        '\' must implement \'HARING\\Crystalis\\Configuration\\UrlRewriting\\ConfiguratorInterface\'.');
                
            }
            
            $userObj->configure();
            
        }
        
    }
    
    
    
    
    
    /**
     * Extracts available languages and renders a select box.
     * For use in ext_conf_template.txt
     * 
     * @since 2.0.0
     * @param array $params Parameters of the respective Extconf field
     * @return string The rendered select box as HTML
     * @access public
     * @static
     */
    public static function getFormFieldForExtconf(array $params) {
        
        if(!\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('static_info_tables')) {
            
            return '<p class="typo3-message message-warning" style="margin-top: 0;">' 
                    . $GLOBALS['LANG']->sL(
                            'LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:extconf.label_DefaultLanguage_NoSit') 
                    . '</p>';
            
        }
        
        $ObjectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $LanguageRepository = $ObjectManager->get('SJBR\\StaticInfoTables\\Domain\\Repository\\LanguageRepository');
        
        $languages = [];
        
        $query = $LanguageRepository->createQuery();
        $query->setOrderings(['lg_iso_2' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING]);
        
        foreach($query->execute() as $language) {
            
            $languages[] = [
                'value' => \strtolower($language->getUid()),
                'name' => \strtolower($language->getIsoCodeA2()) . ' – ' . $language->getNameEn()
            ];
            
        }
        
        $selected = [$params['fieldValue']];
        
        return \SJBR\StaticInfoTables\Utility\HtmlElementUtility::selectConstructor(
                $languages, 
                $selected, 
                $selected, 
                $params['fieldName']);
        
    }
    
    
    
    
    
    /**
     * Returns active DatabaseService instance or creates a new one.
     * 
     * @since 2.0.0
     * @return \HARING\Crystalis\Service\DatabaseService Active DatabaseService
     * @access protected
     */
    protected function getDatabaseService() {
        
        $fqcn = 'HARING\Crystalis\Service\DatabaseService';
        
        if(!\is_a($this->DatabaseService, $fqcn)) {
            
            $this->DatabaseService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance($fqcn);
            
        }
        
        return $this->DatabaseService;
        
    }
    
    
    
    
    
}



