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





    // Extend pages table
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', [
    'tx_crystalis_canonical' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:pages.tx_crystalis_canonical',
        'config' => [
            'type' => 'input',
            'size' => 40,
            'max' => 256,
            'eval' => 'trim',
            'wizards' => [
                '_PADDING' => 2,
                'link' => [
                    'type' => 'popup',
                    'title' => 'LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:pages.tx_crystalis_canonical_formlabel',
                    'icon' => 'link_popup.gif',
                    'module' => [
                        'name' => 'wizard_element_browser',
                        'urlParameters' => [
                            'mode' => 'wizard'
                        ]
                    ],
                    'params' => [
                        'blindLinkOptions' => 'file, mail, folder'
                    ],
                    'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
                ]
            ],
            'softref' => 'typolink'
        ]
    ]
]);

$GLOBALS['TCA']['pages']['palettes']['references'] = [
    'showitem' => 'tx_crystalis_canonical;LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:pages.tx_crystalis_canonical_formlabel',
    'canNotCollapse' => 1
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'pages', 
        '--palette--;LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:pages.palette_references;references', 
        '1,7', 
        'after:abstract');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
        'pages', 
        'EXT:crystalis/Resources/Private/Language/locallang_csh_pages.xlf');





    // Extend pages language overlay table
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages_language_overlay', [
    'tx_crystalis_canonical' => [
        'exclude' => 1,
        'label' => $GLOBALS['TCA']['pages']['columns']['tx_crystalis_canonical']['label'],
        'config' => $GLOBALS['TCA']['pages']['columns']['tx_crystalis_canonical']['config']
    ]
]);

$GLOBALS['TCA']['pages_language_overlay']['palettes']['references'] = $GLOBALS['TCA']['pages']['palettes']['references'];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'pages_language_overlay', 
        '--palette--;LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:pages.palette_references;references', 
        '1,7', 
        'after:abstract');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
        'pages_language_overlay', 
        'EXT:crystalis/Resources/Private/Language/locallang_csh_pages.xlf');





    // Extend sys_domain table
if(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('static_info_tables') 
        && (!!$_EXTCONF['enableLanguageHandling'] || !$_EXTCONF)) {
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_domain', [
        'tx_crystalis_language' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:sys_domain.tx_crystalis_language',
            'displayCond' => [
                'AND' => [
                    'EXT:static_info_tables:LOADED:true',
                    'EXT:realurl:LOADED:true'
                ]
            ],
            'config' => [
                'type' => 'select',
                'items' => [
                    ['', '']
                ],
                'default' => '',
                'special' => 'languages',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1
            ]
        ]
    ]);
    
    $GLOBALS['TCA']['sys_domain']['palettes']['languages'] = [
        'showitem' => 'tx_crystalis_language;LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:sys_domain.tx_crystalis_language_formlabel',
        'canNotCollapse' => 1
    ];
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'sys_domain', 
        '--palette--;LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:sys_domain.palette_language;languages', 
        '', 
        'before:prepend_params');
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
        'sys_domain', 
        'EXT:crystalis/Resources/Private/Language/locallang_csh_sys_domain.xlf');

}





    // Register HTML5 video element
if(
        (\in_array($_EXTCONF['doctype'], ['html5']) && !$_EXTCONF['disableHtml5Video']) 
        || !$_EXTCONF) {
    
    $GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'][] = [
        'LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:tt_content.CType_Video',
        'video',
        'EXT:crystalis/Resources/Public/Icons/html5.png'
    ];
    
    $GLOBALS['TCA']['tt_content']['types']['video'] = [
        'showitem' => '--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.general;general,
            --palette--;LLL:EXT:cms/locallang_ttc.xml:palette.header;header,
            --div--;LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:div.video,pi_flexform;;,
            --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.appearance,
            --palette--;LLL:EXT:cms/locallang_ttc.xml:palette.frames;frames,
            --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,
            --palette--;LLL:EXT:cms/locallang_ttc.xml:palette.visibility;visibility,
            --palette--;LLL:EXT:cms/locallang_ttc.xml:palette.access;access,
            --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.extended'
    ];
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
            '*',
            'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForm/Content_Video.xml',
            'video');
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'tt_content.pi_flexform..video',
            'EXT:crystalis/Resources/Private/Language/locallang_csh_flexform_video.xlf');
    
    $GLOBALS['TCA']['tt_content']['ctrl']['typeicons']['video'] = 
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/html5.png';
    
    $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['video'] = 'extensions-' . $_EXTKEY . '-video';
    
    if(\TYPO3_MODE === 'BE') {
        
        \TYPO3\CMS\Backend\Sprite\SpriteManager::addSingleIcons([
            'video' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) 
                . 'Resources/Public/Icons/html5.png'
        ], $_EXTKEY);
        
    }
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/ContentElements/Html5Video.ts">');
    
}