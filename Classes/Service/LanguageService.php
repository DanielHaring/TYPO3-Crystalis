<?php

namespace DanielHaring\Crystalis\Service;

/**
 * Copyright notice
 *
 * (c) 2016 Daniel Haring <development@haring.co.at>
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
 */

use DanielHaring\Crystalis\Configuration\UrlRewriting\ConfiguratorInterface;
use DanielHaring\Crystalis\Configuration\UrlRewriting\RealurlConfigurator;
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
     * @var \DanielHaring\Crystalis\Service\DatabaseService
     */
    protected $databaseService;
    
    /**
     * Iso Code Service Instance.
     * 
     * @since 7.5.0
     * @var \DanielHaring\Crystalis\Service\IsoCodeService
     */
    protected $isoCodeService;
    
    /**
     * Holds available languages.
     * 
     * @since 7.2.0
     * @var array
     */
    protected $languages;

    /**
     * Holds available Rewrite Configurators.
     *
     * @since 7.6.1
     * @var array
     * @internal
     */
    protected static $rewriteConfigurators;
    
    /**
     * Buffer for language PageTS configuration.
     * 
     * @since 6.2.0
     * @var string
     */
    private $pageTSConfig;
    
    /**
     * Buffer for language TypoScript setup.
     * 
     * @since 6.2.0
     * @var string
     */
    private $typoScriptSetup;
    
    
    
    
    
    /**
     * Constructor.
     * 
     * @since 7.2.0
     * @access public
     */
    public function __construct() {
        
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
     * Returns language TypoScript setup and constructs it if necessary.
     * API method.
     * 
     * @since 6.2.0
     * @return string The constructed or stored TypoScript setup
     * @access public
     */
    public function getTypoScriptSetup() {
        
        if(!\strcmp((string)$this->typoScriptSetup, '')) {
            
            $setup = [];
        
            foreach($this->getDatabaseService()->getSystemLanguages() as $language) {

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
            
            $defaultLanguage = \reset(\array_filter(
                $this->getDatabaseService()->getSystemLanguages(),
                function($language) {

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

        foreach($this->getRewriteConfigurators() as $classRef) {

            GeneralUtility::makeInstance($classRef)->configure();

        }
        
    }





    /**
     * Returns available Rewrite Configurators.
     *
     * @since 7.6.1
     * @return array All available Rewrite Configurators
     */
    final public function getRewriteConfigurators() {

        if(!\is_array(static::$rewriteConfigurators)) {

            $this->loadRewriteConfigurators();

        }

        return static::$rewriteConfigurators;

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





    /**
     * Returns the Database Service
     *
     * @since 7.6.1
     * @return \DanielHaring\Crystalis\Service\DatabaseService|object The Database Service
     */
    public function getDatabaseService() {

        if(!$this->databaseService instanceof DatabaseService) {

            $this->databaseService = GeneralUtility::makeInstance(DatabaseService::class);

        }

        return $this->databaseService;

    }





    /**
     * Sets the Database Service
     *
     * @since 7.6.1
     * @param \DanielHaring\Crystalis\Service\DatabaseService $databaseService The Database Service to set
     */
    public function setDatabaseService(DatabaseService $databaseService) {

        $this->databaseService = $databaseService;

    }





    /**
     * Loads available Rewrite Configurators.
     *
     * @since 7.6.1
     */
    final protected function loadRewriteConfigurators() {

        $registry = ['realurl' => RealurlConfigurator::class];

            // Hook for registering additional extensions to be prepared
        if(\is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['crystalis']['LanguageService']['registerRewriteConfigurator'])) {

            foreach($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['crystalis']['LanguageService']['registerRewriteConfigurator'] as $fn) {

                    // Make a copy of the registry to prevent it being altered directly
                $registrySnapshot = $registry;

                if($additionalConfigurators = GeneralUtility::callUserFunction($fn, $registrySnapshot, $this)) {

                    $registry = \array_merge(
                        $registry,
                        \array_filter((array)$additionalConfigurators, 'is_string'));

                }

            }

        }

        static::$rewriteConfigurators = [];

            // Validate registered configurators
        foreach($registry as $extKey => $classRef) {

            if(!ExtensionManagementUtility::isLoaded($extKey)) {

                continue;

            }

            if(!\in_array(ConfiguratorInterface::class, \class_implements($classRef, \TRUE))) {

                throw new \RuntimeException('Class ' . $classRef
                    . ' must implement ' . ConfiguratorInterface::class . '.');

            }

            static::$rewriteConfigurators[$extKey] = $classRef;

        }

    }
    
    
    
    
    
}




