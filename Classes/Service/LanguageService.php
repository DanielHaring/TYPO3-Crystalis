<?php

namespace HARING\Crystalis\Service;

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

use HARING\Crystalis\Configuration\UrlRewriting\ConfiguratorInterface;
use HARING\Crystalis\Configuration\UrlRewriting\RealurlConfigurator;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;





/**
 * Service for automated language handling.
 *
 * @since 6.2.0
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class LanguageService implements SingletonInterface {
    
    
    
    
    
    /**
     * DatabaseService Instance.
     * 
     * @since 6.2.0
     * @var \HARING\Crystalis\Service\DatabaseService
     * @access private
     */
    private $databaseService;
    
    /**
     * Iso Code Service Instance.
     * 
     * @since 7.5.0
     * @var \HARING\Crystalis\Service\IsoCodeService
     * @access protected
     */
    protected $isoCodeService;
    
    /**
     * Holds available languages.
     * 
     * @since 7.2.0
     * @var array
     * @access protected
     */
    protected $languages;
    
    /**
     * Buffer for language PageTS configuration.
     * 
     * @since 6.2.0
     * @var string
     * @access private
     */
    private $pageTSConfig;
    
    /**
     * Buffer for language TypoScript setup.
     * 
     * @since 6.2.0
     * @var string
     * @access private
     */
    private $typoScriptSetup;
    
    
    
    
    
    /**
     * Constructor.
     * 
     * @since 7.2.0
     * @access public
     */
    public function __construct() {
        
        $this->databaseService = GeneralUtility::makeInstance(
                DatabaseService::class);
        
        $this->isoCodeService = GeneralUtility::makeInstance(
                IsoCodeService::class);
        
        $this->languages = \array_column(
                $this->isoCodeService->renderIsoCodeSelectDropdown(['items' => []])['items'], 
                0, 
                1);
        
        \array_walk($this->languages, function(&$label, $isoCode) {
            
            $label = [
                'isoCode' => $isoCode,
                'locale' => (string)$this->isoCodeService->getLocale($isoCode),
                'name' => $label
            ];
            
        });

    }
    
    
    
    
    
    /**
     * Returns language TypoScript setup and constructs it if neccessary.
     * API method.
     * 
     * @since 6.2.0
     * @return string The constructed or stored TypoScript setup
     * @access public
     */
    public function getTypoScriptSetup() {
        
        if(!\strcmp((string)$this->typoScriptSetup, '')) {
            
            $setup = [];
        
            foreach($this->databaseService->getSystemLanguages() as $language) {

                $ts = 'page.config.htmlTag_langKey = ' . \strtolower($language['isoCode']) . \chr(10) 
                        . 'page.config.sys_language_uid = ' . $language['uid'] . \chr(10) 
                        . 'page.config.sys_language_isocode' . ((int)$language['uid'] < 1 
                                ? '_default' 
                                : '') . ' = ' . \strtolower($language['isoCode']) . \chr(10) 
                        . 'page.config.language = ' . \strtolower($language['isoCode']) . \chr(10) 
                        . 'page.config.lang = ' . \strtolower($language['isoCode']) . \chr(10) 
                        . 'page.config.locale_all = ' . $language['locale'];

                if((int)$language['uid'] > 0) {

                    $ts = \sprintf('[globalVar = GP:L=' . $language['uid'] . "]\n%s\n[global]", $ts);

                }

                $setup[] = $ts;

            }

            $this->typoScriptSetup = \implode(\chr(10), $setup);
            
        }
        
        return $this->typoScriptSetup;
        
    }
    
    
    
    
    
    /**
     * Returns language PageTS configuration and constructs it if neccessary.
     * API method.
     * 
     * @since 6.2.0
     * @return string The constructed or stored PageTS configuration
     * @access public
     */
    public function getPageTSConfig() {
        
        if(!\strcmp((string)$this->pageTSConfig, '')) {
            
            $pageTs = '';
            
            $defaultLanguage = \reset(\array_filter($this->databaseService->getSystemLanguages(), function($language) {
                
                return (int)$language['uid'] === 0;
                
            }));
            
            if(\is_array($defaultLanguage)) {
                
                /* @var $LanguageService \TYPO3\CMS\Lang\LanguageService */
                $LanguageService = GeneralUtility::makeInstance(
                        \TYPO3\CMS\Lang\LanguageService::class);
                
                $LanguageService->init($defaultLanguage['isoCode']);
                
                $pageTs .= 'mod.SHARED.defaultLanguageFlag = ' . (isset($defaultLanguage['locale']) 
                        ? \strtolower(\end(\explode('_', $defaultLanguage['locale']))) 
                        : \strtolower($defaultLanguage['isoCode'])) . '.gif' 
                    . chr(10) . 'mod.SHARED.defaultLanguageLabel = ' . $LanguageService->sL($defaultLanguage['name']);
                
            }
            
            $this->pageTSConfig = $pageTs;
            
        }
        
        return $this->pageTSConfig;
        
    }
    
    
    
    
    
    /**
     * Prepares URL rewriting extensions. Extension realurl is the only one supported by default.
     * API method.
     * 
     * @since 6.2.0
     * @access public
     */
    public function prepareUrlRewriting() {
        
        $Registry = ['realurl' => RealurlConfigurator::class];
        
        /* @var $ObjectManager \TYPO3\CMS\Extbase\Object\ObjectManager */
        $ObjectManager = GeneralUtility::makeInstance(
                ObjectManager::class);
        
            // Hook for registering addtitional extensions to be prepared.
        if(\is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['crystalis']['LanguageService']['registerRewriteConfigurator'])) {
            
            foreach($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['crystalis']['LanguageService']['registerRewriteConfigurator'] as $fn) {
                
                if($additionalConfigurators = GeneralUtility::callUserFunction($fn, $Registry, $this)) {
                    
                    $Registry = \array_merge($Registry, \array_filter((array)$additionalConfigurators, 'is_string'));
                    
                }
                
            }
            
        }
        
        foreach($Registry as $extKey => $classRef) {
            
            if(!ExtensionManagementUtility::isLoaded($extKey)) {
                continue;
            }
            
            $userObj = $ObjectManager->get($classRef);
            
            if(!\is_a($userObj, ConfiguratorInterface::class)) {
                
                throw new \RuntimeException('Class \'' . \get_class($userObj) . 
                        '\' must implement \'HARING\\Crystalis\\Configuration\\UrlRewriting\\ConfiguratorInterface\'.');
                
            }
            
            $userObj->configure();
            
        }
        
    }
    
    
    
    
    
    /**
     * Returns available languages.
     * 
     * @since 7.2.0
     * @return array Available languages
     * @access public
     */
    public function getLanguages() {
        
        return $this->languages;
        
    }
    
    
    
    
    
}




