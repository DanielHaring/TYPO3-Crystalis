<?php

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

if(!\defined('TYPO3_MODE')) {
    die('Access denied.');
}

$_EXTCONF = \unserialize($_EXTCONF);




    // Inject TypoScript files
if($_EXTCONF['setPageTSconfig'] || !$_EXTCONF) {
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/Backend/Behaviour.ts">' . "\n" 
            . '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/Backend/RichTextEditor.ts">');
    
}

if($_EXTCONF['setUserTSconfig'] || !$_EXTCONF) {
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/Backend/UserRights.ts">');
    
}

switch($_EXTCONF['doctype']) {
    
    case 'xhtml_strict':
        
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
                $_EXTKEY, 
                'Configuration/TypoScript/XHtmlStrict', 
                'Frontend Rendering');
        
        break;
    
    case 'html5': // fallthrough
    default:
        
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
                $_EXTKEY, 
                'Configuration/TypoScript/Html5', 
                'Frontend Rendering');
        
        break;
    
}





    // Register HTML5 video element
if(
        (\in_array($_EXTCONF['doctype'], ['html5']) && !$_EXTCONF['disableHtml5Video']) 
        || !$_EXTCONF) {
    
    if(\TYPO3_MODE === 'BE') {
        
        \TYPO3\CMS\Backend\Sprite\SpriteManager::addSingleIcons([
            'video' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) 
                . 'Resources/Public/Icons/html5.png'
        ], $_EXTKEY);
        
    }
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/ContentElements/Html5Video.ts">');
    
}