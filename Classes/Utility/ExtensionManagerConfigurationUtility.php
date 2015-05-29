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
     * Renders a select box of all available languages.
     * To be called within ext_conf_template.txt.
     * 
     * @since 7.2.0
     * @param array $params Parameteres of the respective extension configuration field
     * @return string HTML output of the rendered select box
     * @access public
     */
    public function buildLanguageSelector(array $params) {
        
        $options = \array_map(
                [$GLOBALS['LANG'], 'sL'], 
                ArrayUtility::column(
                        $GLOBALS['TCA']['sys_language']['columns']['language_isocode']['config']['items'], 
                        0, 
                        1));
        
        \asort($options);
        
        return $this->renderSelect(
                $params['fieldName'], 
                $options, 
                $params['fieldValue']);
        
    }
    
    
    
    
    
    /**
     * Renders a generic select box.
     * 
     * @since 7.2.0
     * @param string $name The name attribute to set
     * @param array $options An array holding available values. If an assoziative array will be passed, 
     *                       the keys will be used as value and the values will be displayed as label.
     * @param mixed $selected (Optional) The key of the item which should marked as 'selected'
     * @param integer $maxItems (Optional) Number of selectable items
     * @return string HTML output of the rendered select box
     * @access protected
     */
    protected function renderSelect($name, array $options, $selected = \NULL, $maxItems = 1) {
        
        $useValue = ArrayUtility::isAssociative($options);
        
        \array_walk($options, function(&$label, $value) use($useValue, $selected) {
            
            $value = $useValue ? $value : $label;
            
            $label = '<option value="' . $value . '"' 
                    . ($selected === $value ? ' selected="selected"' : '') 
                    . '>' . $label . '</option>';
            
        });
        
        return '<select name="' . (string)$name . '" size="' 
                . (string)\max([1, $maxItems]) . '">' 
                . \implode('', $options) . '</select>';
        
    }
    
    
    
    
    
}




