<?php

namespace HARING\Crystalis\View\BackendLayout;

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





/**
 * Injects backend layouts using external files.
 * 
 * @deprecated since version 7.4.0, will be removed in Crystalis 7.5. Use mod.web_layout.BackendLayouts instead.
 * @since 1.6.0
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class FileDataProvider implements \TYPO3\CMS\Backend\View\BackendLayout\DataProviderInterface {
    
    
    
    
    
    /**
     * Specifies valid icon formats.
     * 
     * @deprecated since version 7.4.0, will be removed in Crystalis 7.5. Use mod.web_layout.BackendLayouts instead.
     * @since 1.6.0
     * @var array
     * @access protected
     */
    protected $validIconFormats;
    
    
    
    
    
    /**
     * Constructor.
     * 
     * @deprecated since version 7.4.0, will be removed in Crystalis 7.5. Use mod.web_layout.BackendLayouts instead.
     * @since 1.6.0
     * @access public
     */
    public function __construct() {
        
        $this->validIconFormats = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(
                ',', 
                (string) $GLOBALS['TCA']['backend_layout']['columns']['icon']['config']['allowed'] ?: 'jpg, gif, png');

    }
    
    
    
    
    
    /**
     * Extends the given backend layout collection.
     * 
     * @deprecated since version 7.4.0, will be removed in Crystalis 7.5. Use mod.web_layout.BackendLayouts instead.
     * @since 1.6.0
     * @param \TYPO3\CMS\Backend\View\BackendLayout\DataProviderContext $dataProviderContext The context where this data privider was called
     * @param \TYPO3\CMS\Backend\View\BackendLayout\BackendLayoutCollection $backendLayoutCollection The collection where to add additional layouts
     * @access public
     */
    public function addBackendLayouts( 
            \TYPO3\CMS\Backend\View\BackendLayout\DataProviderContext $dataProviderContext, 
            \TYPO3\CMS\Backend\View\BackendLayout\BackendLayoutCollection $backendLayoutCollection ) {
        
        $pageTS = $dataProviderContext->getPageTsConfig();
        $backendLayouts = (array) $pageTS['tx_crystalis.']['includeBackendLayouts.'];
        
        \array_walk(\array_filter($backendLayouts, 'is_string'), function($file, $identifier) use ($backendLayouts, $backendLayoutCollection) {
            
            if(!\is_null($backendLayout = $this->buildBackendLayout($identifier, $file, (array) $backendLayouts[$identifier . '.']))) {
                
                $backendLayoutCollection->add($backendLayout);
                
            }
            
        });

    }
    
    
    
    
    
    /**
     * Gets a backend layout by (regular) identifier.
     * 
     * @deprecated since version 7.4.0, will be removed in Crystalis 7.5. Use mod.web_layout.BackendLayouts instead.
     * @since 1.6.0
     * @param string $identifier The (regular) identifier of the backend layout to fetch
     * @param integer $pageId The uid of the page requesting the specified backend layout
     * @return \NULL|\TYPO3\CMS\Backend\View\BackendLayout\BackendLayout The requested backend layout or NULL if an error occures
     * @access public
     */
    public function getBackendLayout($identifier, $pageId) {
        
        $pageTS = \TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig((int) $pageId);
        
        return $this->buildBackendLayout(
                $identifier, 
                (string) $pageTS['tx_crystalis.']['includeBackendLayouts.'][$identifier], 
                (array) $pageTS['tx_crystalis.']['includeBackendLayouts.'][$identifier . '.']);
        
    }
    
    
    
    
    
    /**
     * Builds a backend layout object from configuration file.
     * 
     * @deprecated since version 7.4.0, will be removed in Crystalis 7.5. Use mod.web_layout.BackendLayouts instead.
     * @since 1.6.0
     * @param string $identifier The identifier within configuration array
     * @param string $file The path to the configuration file
     * @param array $config (Optional.) The configuration array of this specific backend layout
     * @return \NULL|\TYPO3\CMS\Backend\View\BackendLayout\BackendLayout The built backend layout or NULL on error
     * @access protected
     */
    protected function buildBackendLayout($identifier, $file, array $config = []) {
        
        if(!\file_exists($path = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName((string) $file))) {
            
            return \NULL;
            
        }
        
        $backendLayout = \TYPO3\CMS\Backend\View\BackendLayout\BackendLayout::create(
                (string) $identifier, 
                (string) $GLOBALS['LANG']->sL($config['title']) ?: \pathinfo($path, \PATHINFO_FILENAME), 
                \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl($path));
        
        $backendLayout->setDescription((string) $GLOBALS['LANG']->sL($config['description']));
        
        if(\array_key_exists('icon', $config) 
                && \file_exists($iconResource = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($iconPath = $config['icon'])) 
                && \in_array(\pathinfo($iconResource, \PATHINFO_EXTENSION), $this->validIconFormats)) {
            
            $backendLayout->setIconPath($iconPath);
            
        }
        
        return $backendLayout;
        
    }
    
    
    
    
    
}




