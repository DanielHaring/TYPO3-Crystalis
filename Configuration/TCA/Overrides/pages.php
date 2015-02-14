<?php

\defined('TYPO3_MODE') or die('Access denied.');

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