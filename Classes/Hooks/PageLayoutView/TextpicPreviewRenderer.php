<?php

namespace DanielHaring\Crystalis\Hooks\PageLayoutView;

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

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface;





/**
 * Generates a preview for the 'textpic' content element.
 *
 * @since 7.2.0
 * @author COCO Communication Company GmbH <office@cocowerbung.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class TextpicPreviewRenderer implements PageLayoutViewDrawItemHookInterface {





    /**
     * Generates preview for the 'textpic' content element.
     * 
     * @since 7.2.0
     * @param PageLayoutView $parentObject Calling context
     * @param boolean $drawItem Determines if the item should be drawed using default functionality
     * @param string $headerContent Pre processed header content
     * @param string $itemContent Pre processed item content
     * @param array $row Data array of current content element
     * @access public
     */
    public function preProcess(
            PageLayoutView &$parentObject,
            &$drawItem, 
            &$headerContent, 
            &$itemContent, 
            array &$row) {
        
        if($row['CType'] === 'textpic') {
            
            if($row['bodytext']) {
                
                $itemContent .= $parentObject->linkEditContent($parentObject->renderText($row['bodytext']), $row) . '<br />';
                
            }
            
            if($row['image']) {
                
                $itemContent .= $parentObject->thumbCode($row, 'tt_content', 'image');
                
                $fileReferences = BackendUtility::resolveFileReferences(
                        'tt_content', 
                        'image', 
                        $row);
                
                if(!empty($fileReferences)) {
                    
                    $linkedContent = '';
                    
                    foreach($fileReferences as $fileReference) {
                        
                        $description = $fileReference->getDescription();
                        
                        if(!\is_null($description) && $description !== '') {
                            
                            $linkedContent .= \htmlspecialchars($description) . '<br />';
                            
                        }
                        
                    }
                    
                    $itemContent .= $parentObject->linkEditContent($linkedContent, $row);
                    
                    unset($linkedContent);
                    
                }
                
            }
            
            $drawItem = \FALSE;
            
        }

    }





}




