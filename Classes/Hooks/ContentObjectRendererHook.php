<?php

namespace DanielHaring\Crystalis\Hooks;

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
 * Hook for content object renderer.
 * 
 * @since 1.5.0
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ContentObjectRendererHook implements \TYPO3\CMS\Frontend\ContentObject\ContentObjectGetSingleHookInterface {
    
    
    
    
    
    /**
     * The content object requesting the renderer.
     * 
     * @since 6.2.0
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     * @access protected
     */
    protected $parentObject;
    
    /**
     * Translates TypoScript key to class name.
     * 
     * @since 6.2.0
     * @var array
     * @access protected
     */
    protected $contentObjectClassMapping = [
        'VIDEO' => 'Html5Video'
    ];
    
    
    
    
    
    /**
     * Tries to render a specific content object.
     * 
     * @since 1.5.0
     * @param string $contentObjectName TypoScript key of the object to render
     * @param array $conf TypoScript configuration of this specific content object
     * @param string $TypoScriptKey Name of the corresponding TypoScript node
     * @param \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $parentObject The object requesting the renderer
     * @return mixed The rendered content if any
     * @access public
     */
    public function getSingleContentObject(
            $contentObjectName, 
            array $conf, 
            $TypoScriptKey, 
            \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer &$parentObject) {
        
        $this->parentObject =& $parentObject;
        
        return \is_callable([$this, $contentObjectName]) ? $this->{$contentObjectName}($conf) : NULL;
    
    }
    
    
    
    
    
    /**
     * Returns the appropriate content object renderer of a specific type.
     * 
     * @since 6.2.0
     * @param string $name TypoScript key of the object to render
     * @return \TYPO3\CMS\Frontend\ContentObject\AbstractContentObject The appropriate content object renderer
     * @access public
     */
    public function getContentObject($name) {
        
        if(!\array_key_exists($name, $this->contentObjectClassMapping)) {
            
            return \NULL;
            
        }
        
        $fqcn = 'DanielHaring\\Crystalis\\ContentObject\\'
                . $this->contentObjectClassMapping[$name] 
                . 'ContentObject';
        
        return \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance($fqcn, $this->parentObject);
        
    }
    
    
    
    
    
    /**
     * Renders content object of type "VIDEO".
     * 
     * @since 6.2.0
     * @param array $conf TypoScript configuration of this specific content object
     * @return mixed The rendered HTML output if any
     * @access public
     */
    public function VIDEO(array $conf) {
        
        return $this->getContentObject('VIDEO')->render($conf);
        
    }
    
    
    
    
    
}




