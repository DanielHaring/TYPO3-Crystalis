<?php

namespace HARING\Crystalis\Configuration\UrlRewriting;

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

use TYPO3\CMS\Core\Cache\Backend\SimpleFileBackend;
use TYPO3\CMS\Core\Cache\CacheFactory;
use TYPO3\CMS\Core\Cache\Frontend\VariableFrontend;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;





/**
 * Auto configuration for extension RealUrl.
 *
 * @since 6.2.0
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class RealurlConfigurator implements ConfiguratorInterface {
    
    
    
    
    
    /**
     * TYPO3 Cache identifier.
     * 
     * @since 6.2.0
     */
    const CACHE_IDENTIFIER = 'crystalis';
    
    /**
     * Key within TYPO3 Cache.
     * 
     * @since 6.2.0
     */
    const CACHE_KEY = 'realurl';
    
    
    
    
    
    /**
     * TYPO3 Cache Manager.
     * 
     * @since 6.2.0
     * @var \TYPO3\CMS\Core\Cache\CacheManager
     * @inject
     * @access protected
     */
    protected $CacheManager;
    
    /**
     * Computed configuration.
     * 
     * @since 6.2.0
     * @var array
     * @access protected
     */
    protected $configuration;
    
    /**
     * DatabaseService Instance.
     * 
     * @since 6.2.0
     * @var \HARING\Crystalis\Service\DatabaseService
     * @inject
     * @access protected
     */
    protected $DatabaseService;
    
    /**
     * TYPO3 Object Manager
     * 
     * @since 6.2.0
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     * @inject
     * @access protected
     */
    protected $ObjectManager;
    
    /**
     * Head domain buffer
     * 
     * @since 6.2.0
     * @var array
     * @access private
     */
    private $headDomains;
    
    
    
    
    
    /**
     * Configures RealUrl to properly handle languages and domains.
     * API method.
     * 
     * @since 6.2.0
     * @access public
     */
    public function configure() {
        
        if(!$this->Cache()->has(self::CACHE_KEY)) {
            
            $this->configuration = $this->computeBaseConfiguration();
            
                // Traverse registered domains
            foreach($this->configuration as $host => &$conf) {
                
                if(!$domainConf = $this->DatabaseService->getDomainAssignments()[$host]) {
                    
                    continue;
                    
                }
                
                    // Define root page ID
                $conf['pagePath']['rootpage_id'] = $domainConf['rootPage'];
                
                    // Override language preVars
                $this->completePreVars($host);
                
                    // Register domain for encoding and decoding
                $this->registerDomainCodec($domainConf);
                
            }
            
            $this->Cache()->set(self::CACHE_KEY, $this->configuration);
            
        } else {
            
            $this->configuration = $this->Cache()->get(self::CACHE_KEY);
            
        }
        
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl'] = $this->configuration;

    }
    
    
    
    
    
    /**
     * Returns local cache manager or creates a new one if none is present.
     * 
     * @since 6.2.0
     * @return \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface|\TYPO3\CMS\Core\Cache\Backend\BackendInterface Local cache manager
     * @access protected
     */
    protected function Cache() {

        return $this->CacheManager->hasCache(self::CACHE_IDENTIFIER) 
                ? $this->CacheManager->getCache(self::CACHE_IDENTIFIER) 
                : GeneralUtility::makeInstance(CacheFactory::class)->create(
                        self::CACHE_IDENTIFIER, 
                        VariableFrontend::class,
                        SimpleFileBackend::class);
        
    }
    
    
    
    
    
    /**
     * Extracts existing RealUrl configuration and pads required basic settings.
     * 
     * @since 6.2.0
     * @return array Prepared RealUrl configuration array
     * @access protected
     */
    protected function computeBaseConfiguration() {
        
        $RealUrlConf = (array)$this->getRealurlConfiguration();
        
            // Ensure base configuration is set
        if(empty($RealUrlConf)) {
            
            $RealUrlConf['localhost'] = include(GeneralUtility::getFileAbsFileName(
                    'EXT:crystalis/Configuration/PHP/RealUrl/FallbackTemplate.php'));
            
        }
        
        if(!isset($RealUrlConf['localhost'])) {
            
            $RealUrlConf['localhost'] = \reset($RealUrlConf);
            
        }
        
            // Define default preVars
        $RealUrlConf['localhost']['preVars'][$this->determineLangPreVarsIndex($RealUrlConf['localhost'])] = [
            'GETvar' => 'L',
            'noMatch' => 'bypass',
            'valueMap' => \array_combine(
                    \array_map(
                            'strtolower', 
                            \array_column(
                                    $this->DatabaseService->getSystemLanguages(), 
                                    'isoCode')), 
                    \array_column(
                            $this->DatabaseService->getSystemLanguages(), 
                            'uid'))
        ];
        
            // Register missing domains
        return \array_merge(
                $RealUrlConf, 
                \array_fill_keys(
                        \array_keys(\array_diff_key(
                                $this->DatabaseService->getDomainAssignments(), 
                                $RealUrlConf)), 
                        $RealUrlConf['localhost']));
        
    }
    
    
    
    
    
    /**
     * Completes preVars of a specific domain configuration.
     * 
     * @since 6.2.0
     * @param string $host The domain the configuration relates to
     * @access protected
     */
    protected function completePreVars($host) {
        
        $domainConf = $this->DatabaseService->getDomainAssignments()[$host];
        $index = $this->determineLangPreVarsIndex($this->configuration[$host]);
        
        if(!!\count(\array_filter($domainConf['languages'], function($lang) use ($domainConf) {
            
            return (int)$lang['uid'] !== (int)$domainConf['initialLanguage'];
            
        }))) {
            
            $this->configuration[$host]['preVars'][$index] = [
                'GETvar' => 'L',
                'noMatch' => 'bypass',
                'valueMap' => \array_combine(
                        \array_column($domainConf['languages'], 'isoCode'), 
                        \array_column($domainConf['languages'], 'uid'))
            ];
            
        } elseif(isset($this->configuration[$host]['preVars'][$index])) {
            
            unset($this->configuration[$host]['preVars'][$index]);
            
        }
        
    }
    
    
    
    
    
    /**
     * Registers encoding end decoding for '_DOMAINS' configuration.
     * 
     * @since 6.2.0
     * @param array $domainConf Configuration of the specific domain to register
     * @access protected
     */
    protected function registerDomainCodec(array $domainConf) {
        
        if(!MathUtility::canBeInterpretedAsInteger($domainConf['initialLanguage'])) {
            
            return /* void */;
            
        }
        
            // Decoding
        $this->configuration['_DOMAINS']['decode'][$domainConf['host']] = [
            'GETvars' => [
                'L' => (int)$domainConf['initialLanguage']
            ],
            'useConfiguration' => $domainConf['host']
        ];
        
            // Encoding
        if(!\array_key_exists($domainConf['host'], $this->getHeadDomains())) {
            
            return /* void */;
            
        }
        
        $this->configuration['_DOMAINS']['encode'] = \array_merge(
                (array)$this->configuration['_DOMAINS']['encode'], 
                $this->computeDomainEncoding($domainConf));
        
    }
    
    
    
    
    
    /**
     * Reads and returns RealUrl configuration. Takes auto configuration into account if enabled.
     * 
     * @since 6.2.0
     * @return array RealUrl configuration
     * @access protected
     */
    protected function getRealurlConfiguration() {
        
        $RealUrlExtConf = (array)@\unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['realurl']);
        
        if(empty($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']) && !!$RealUrlExtConf['enableAutoConf']) {
            
            while(!@include_once(\PATH_site . \TX_REALURL_AUTOCONF_FILE)) {
                
                if(isset($Generator)) {
                    break;
                }
                
                $Generator = $this->ObjectManager->get('tx_realurl_autoconfgen');
                $Generator->generateConfiguration();
                
            }
            
            unset($Generator);
            
        }
        
        return (array)$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl'];
        
    }
    
    
    
    
    
    /**
     * Returns buffered head domains or computes them if no respective buffer was found.
     * 
     * @since 6.2.0
     * @return array Head domain array
     * @access protected
     */
    protected function getHeadDomains() {
        
        if(!\is_array($this->headDomains)) {
            
                // Get all domains with usable initial language and compute identifier hash
            $eligibleDomains = \array_reverse(\array_map(function($domain) {
                
                $domain['key'] = md5((string)$domain['rootPage'] . '.' . (string)$domain['initialLanguage']);
                
                return $domain;
                
            }, \array_filter($this->DatabaseService->getDomainAssignments(), function($domain) {
                
                return MathUtility::canBeInterpretedAsInteger($domain['initialLanguage']);
                
            })));
            
                // Remove duplicates
            $headDomains = \array_combine(\array_column($eligibleDomains, 'key'), $eligibleDomains);
            unset($eligibleDomains);
            
                // Rebuild array structure of origin
            $this->headDomains = \array_combine(\array_column($headDomains, 'host'), $headDomains);
            unset($headDomains);
            
        }
        
        return $this->headDomains;
        
    }
    
    
    
    
    
    /**
     * Builds domain encoding entries for a specific domain.
     * 
     * @since 6.2.0
     * @param array $domainConf Configuration of the specific domain
     * @return array The built encoding entries as multidimensional array
     * @access protected
     */
    protected function computeDomainEncoding(array $domainConf) {
        
        $langConf = [
            [
                'GETvar' => 'L',
                'value' => (int)$domainConf['initialLanguage'],
                'ifDifferentToCurrent' => \TRUE,
                'useConfiguration' => $domainConf['host'],
                'urlPrepend' => $domainConf['protocol'] . '://' . $domainConf['host']
            ]
        ];
        
        if((int)$domainConf['initialLanguage'] === 0) {
            
            $langConf[] = \reset($langConf);
            \end($langConf);
            $langConf[\key($langConf)]['value'] = '';
            \reset($langConf);
            
        }
        
        return $langConf;
        
    }
    
    
    
    
    
    /**
     * Determines the index which to use for language preVars within RealUrl configuration array.
     * 
     * @since 6.2.0
     * @param array $config The RealUrl configuration array of which to determine index for
     * @return string|integer The index to use
     * @access protected
     */
    protected function determineLangPreVarsIndex(array $config) {
        
        if(!isset($config['preVars'])) {
            
            return 0;
            
        }
        
        return !!\count($lang = \array_filter($config['preVars'], function($section) {
            
            return isset($section['GETvar']) && $section['GETvar'] === 'L';
            
        })) ? key($lang) : \count($config['preVars']);
        
    }
    
    
    
    
    
}




