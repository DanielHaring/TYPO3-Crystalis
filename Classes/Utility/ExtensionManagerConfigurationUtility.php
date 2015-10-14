<?php

namespace HARING\Crystalis\Utility;

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

use \TYPO3\CMS\Core\Messaging\FlashMessage;
use \HARING\Crystalis\Utility\ArrayUtility;





/**
 * Procides extension manager configurations.
 *
 * @since 7.2.0
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ExtensionManagerConfigurationUtility {
    
    
    
    
    
    /**
     * The field name of the form element.
     * 
     * @since 7.3.0
     * @var string
     * @access protected
     */
    protected $fieldName;
    
    
    
    
    
    /**
     * Renders a select box of all available languages.
     * To be called within ext_conf_template.txt.
     * 
     * @since 7.2.0
     * @param array $params Parameteres of the respective extension configuration field
     * @return string HTML output of the rendered select box
     * @access public
     */
    public function buildLanguageSelector(array $params) {
        
        return $this->renderSelect(
                \array_column(
                        \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                                \TYPO3\CMS\Core\Service\IsoCodeService::class)
                            ->renderIsoCodeSelectDropdown(['items' => []])['items'], 
                        0, 
                        1), 
                $params['fieldValue']);
        
    }
    
    
    
    
    
    /**
     * Checks wheter the Language Service is configured properly and works as expected.
     * To be called within ext_conf_template.txt.
     * 
     * @since 7.3.0
     * @param array $params Parameters of the respective extension configuration field
     * @return string HTML output of the rendered status message
     * @access public
     */
    public function checkLanguageService(array $params) {
        
        $this->fieldName = $params['fieldName'];
        
        if(!\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('realurl')) {
            
            return self::externalLanguageConfiguratorLoadable() 
                    ? $this->renderPanel(
                            'LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:extconf.label_CheckLanguageService_AlternativeConfigurator', 
                            FlashMessage::INFO, 
                            'LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:extconf.label_CheckLanguageService_Heading_Info') 
                    : $this->renderPanel(
                            'LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:extconf.label_CheckLanguageService_NoConfigurator', 
                            FlashMessage::WARNING, 
                            'LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:extconf.label_CheckLanguageService_Heading_Warning');
            
        }
        
        /* @var $CacheManager \TYPO3\CMS\Core\Cache\CacheManager */
        $CacheManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                'TYPO3\\CMS\\Core\\Cache\\CacheManager');
        
        return $CacheManager->hasCache('crystalis') 
                ? $this->renderPanel(
                        'LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:extconf.label_CheckLanguageService_Ok', 
                        FlashMessage::OK, 
                        'LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:extconf.label_CheckLanguageService_Heading_Ok') 
                : $this->renderPanel(
                        'LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:extconf.label_CheckLanguageService_NoCache', 
                        FlashMessage::NOTICE, 
                        'LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:extconf.label_CheckLanguageService_Heading_Info');
        
    }
    
    
    
    
    
    /**
     * Renders a generic select box.
     * 
     * @since 7.2.0
     * @param array $options An array holding available values.
     * @param mixed $selected (Optional) The key of the item which should marked as 'selected'
     * @param integer $maxItems (Optional) Number of selectable items
     * @return string HTML output of the rendered select box
     * @access protected
     */
    protected function renderSelect(array $options, $selected = \NULL, $maxItems = 1) {
        
        $useValue = ArrayUtility::isAssociative($options);
        
        \array_walk($options, function(&$label, $value) use($useValue, $selected) {
            
            $value = $useValue ? $value : $label;
            
            $label = '<option value="' . $value . '"' 
                    . ($selected === $value ? ' selected="selected"' : '') 
                    . '>' . $label . '</option>';
            
        });
        
        return '<select name="' . (string)$this->fieldName . '" size="' 
                . (string)\max([1, $maxItems]) . '">' 
                . \implode('', $options) . '</select>';
        
    }
    
    
    
    
    
    /**
     * Renders a generic panel.
     * 
     * @since 7.3.0
     * @param string $message The message to be shown
     * @param integer $severity The severity of the panel (should be one out of the FlashMessage constants)
     * @param string $heading (Optional) The header to set for the panel
     * @param boolean $avoidInput (Optional) If set to TRUE, no hidden input field will be rendered
     * @return string HTML output of the rendered panel
     * @access protected
     */
    protected function renderPanel($message, $severity, $heading = '', $avoidInput = \FALSE) {
        
        switch($severity) {
            
            case FlashMessage::OK:
                
                $panelClass = 'success';
                $inputValue = '1';
                
                break;
            
            case FlashMessage::INFO:
                
                $panelClass = 'info';
                $inputValue = '1';
                
                break;
            
            case FlashMessage::NOTICE:
                
                $panelClass = 'notice';
                $inputValue = '1';
                
                break;
            
            case FlashMessage::WARNING:
                
                $panelClass = 'warning';
                $inputValue = '0';
                
                break;
            
            case FlashMessage::ERROR:
            default:
                
                $panelClass = 'danger';
                $inputValue = '0';
                
                break;
            
        }
        
        $panel = [
            '<div class="panel-body">' . $GLOBALS['LANG']->sL((string)$message) . (!$avoidInput 
                ? '<input type="hidden" name="' . $this->fieldName . '" value="' . $inputValue . '">' 
                : '') . '</div>'
        ];
        
        if(\strcmp($heading, '')) {
            
            \array_unshift($panel, '<div class="panel-heading">' . $GLOBALS['LANG']->sL((string)$heading) . '</div>');
            
        }
        
        return '<div class="panel panel-' . $panelClass . '">' 
                . \implode('', $panel) . '</div>';
        
    }
    
    
    
    
    
    /**
     * Checks wheter an external Language Service configurator could be loaded.
     * 
     * @since 7.3.0
     * @return boolean TRUE if an external configurator could be loaded, FALSE otherwise
     * @access public
     * @static
     */
    static public function externalLanguageConfiguratorLoadable() {
        
        $externalConfigurator = \FALSE;
        
        foreach((array)$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['crystalis']['LanguageService']['registerRewriteConfigurator'] as $fn) {
            
            if($additionalConfigurators = \TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction($fn, $configurators ?: [], $this)) {
                
                $configurators = \array_merge($configurators ?: [], \array_filter((array)$additionalConfigurators, 'is_string'));
                
            }
            
        }
        
        foreach((array)$configurators as $extKey => $fqcn) {
            
            if(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded($extKey) 
                    && \is_a($fqcn, 'HARING\\Crystalis\\Configuration\\UrlRewriting\\ConfiguratorInterface', \TRUE)) {
                
                $externalConfigurator = \TRUE;
                break;
                
            }
            
        }
        
        return !!$externalConfigurator;
        
    }
    
    
    
    
    
}




