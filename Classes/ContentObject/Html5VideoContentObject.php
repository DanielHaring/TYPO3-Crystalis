<?php

namespace HARING\Crystalis\ContentObject;

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
 * Renders the VIDEO content object.
 *
 * @since 1.5.0
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Html5VideoContentObject extends \HARING\Crystalis\ContentObject\AbstractContentObject {
    
    
    
    
    
    /**
     * MIME-type of mp4 files.
     * 
     * @since 2.0.0
     */
    const MIME_TYPE_MP4 = 'video/mp4';
    
    /**
     * MIME-type of WebM files.
     * 
     * @since 2.0.0
     */
    const MIME_TYPE_WEBM = 'video/webm';
    
    /**
     * MIME-type of ogg files.
     * 
     * @since 2.0.0
     */
    const MIME_TYPE_OGG = 'video/ogg';
    
    
    
    
    
    /**
     * Renders content object and returns its HTML output.
     * 
     * @since 1.5.0
     * @param array $conf The TypoScript configuration of this specific object
     * @return string The rendered HTML output
     * @access public
     */
    public function render($conf = []) {
        
            // Check if the element should be rendered at all
        if(\is_array($conf['if.']) && !$this->cObj->checkIf($conf['if.'])) {
            
            return '';
            
        }
        
            // Load FlexForm
        $this->substituteFlexForm($conf, 'flexParams', 'parameter');
        
        
            // Collect video sources
        $sources = $this->translatePropertiesAsFileFormats($conf['parameter.'], ['mp4', 'webm', 'ogg']);
        
        if(!\count($sources)) {
            
            return '';
            
        }
        
            // Get poster image
        $poster = \array_shift($this->resolveFileObjects('poster', $conf['parameter.']));
        
            // Get dimensions
        $width = $conf['parameter.']['width'] ?: ($poster->hasProperty('width') ? $poster->getProperty('width') : \NULL) ?: 720;
        $height = $conf['parameter.']['height'] ?: ($poster->hasProperty('height') ? $poster->getProperty('height') : \NULL) ?: 576;
        
            // Get flash data
        list($flash, $flashVars) = $this->extractFlashProperties($conf);
        
            // Render template
        $view = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                'TYPO3\\CMS\\Fluid\\View\\StandaloneView', 
                $this->cObj);
        
        $view->setTemplatePathAndFileName(
                \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('crystalis') 
                . 'Resources/Private/Templates/ContentObject/Html5Video.html');
        
        $view->setPartialRootPath(
                \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('crystalis') 
                . 'Resources/Private/Partials/');
        
        $view->assignMultiple([
            'attributes' => [
                'width' => $width,
                'height' => $height,
                'preload' => !!$conf['parameter.']['preload'],
                'autoplay' => !!$conf['parameter.']['autoplay'],
                'loop' => !!$conf['parameter.']['loop'],
                'controls' => !!$conf['parameter.']['controls']
            ],
            'poster' => $poster,
            'sources' => $sources,
            'flash' => $flash,
            'flashVars' => $flashVars
        ]);
        
        $html = $view->render();
        
        return \is_array($conf['stdWrap.']) 
                ? $this->cObj->stdWrap($html, $conf['stdWrap.']) 
                : $html;
        
    }
    
    
    
    
    
    /**
     * Extracts file resources out of the given TypoScript configuration and returns them
     * as array. The array holds the MIME-type as key and the respective file path as value.
     * Expects properties to be named after their respective file format.
     * 
     * @since 2.0.0
     * @param array $conf The TypoScript configuration of which to extract file resources from
     * @param array $formats An array which holds keys of TypoScript properties to identify as file resource
     * @return array An array containing the extracted file resources
     * @access protected
     */
    protected function translatePropertiesAsFileFormats(array $conf, array $formats) {
        
        $sources = [];
        
        foreach($formats as $format) {
            
            if(($fileResource = \array_shift($this->resolveFileObjects($format, $conf))) 
                    && \is_callable([$fileResource, 'getPublicUrl']) 
                    && \defined($mimeType = __CLASS__ . '::MIME_TYPE_' . \strtoupper($format))) {
                
                $sources[\constant($mimeType)] = $fileResource->getPublicUrl();
                
            }
            
        }
        
        return $sources;
        
    }
    
    
    
    
    
    /**
     * Builds object and variable array for flash content.
     * 
     * @since 2.0.0
     * @param array $conf The TypoScript configuration array holding flash setup
     * @param string $flexForm (Optional) The name of the flexform sub array
     * @param string $propertyName (Optional) Alternative name of flash property
     * @return array An array holding created object and variables
     * @access protected
     */
    protected function extractFlashProperties(array $conf, $flexForm = 'parameter', $propertyName = 'flash') {
        
        $flashVars = [];
        $parameter = (array) $conf[$flexForm . '.'];
        
        if(!$flash = \array_shift(
                $this->resolveFileObjects(
                        (string) $propertyName, 
                        $parameter))) {
            
            return [];
            
        }
        
            // FLV Player
        if($flash->getMimeType() === 'video/x-flv') {
            
            $flashVars[] = 'file=' . \rawurlencode($flash->getPublicUrl());
            
            $flash = $this->fileFactory->retrieveFileOrFolderObject(
                    $conf['mimeConf.']['flash.']['player']);
            
        }
        
            // Loop
        if(!!$parameter['loop']) {
            
            $flashVars[] = 'loop=true';
            
        }
        
            // Autoplay
        if(!!$parameter['autoplay']) {
            
            $flashVars[] = 'autoPlay=true';
            
        }
        
        return [$flash, $flashVars];
        
    }
    
    
    
    
    
}




