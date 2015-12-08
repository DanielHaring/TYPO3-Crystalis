<?php

\defined('TYPO3_MODE') or die('Access denied.');

$_EXTCONF = \unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['crystalis']);
$_EXTKEY = 'crystalis';





    // Provide page TSconfig
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
        $_EXTKEY, 
        'Configuration/TypoScript/Controller/PageTS/Main.ts', 
        'Base Configuration');





    // Provide SEO functionality
if(!$_EXTCONF['disableSeo'] || !$_EXTCONF) {
    
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
                        'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_link.gif',
                        'module' => [
                            'name' => 'wizard_link'
                        ],
                        'params' => [
                            'blindLinkOptions' => 'file, mail, folder'
                        ],
                        'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
                    ]
                ],
                'softref' => 'typolink'
            ]
        ],
        'tx_crystalis_pagetitle' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:pages.tx_crystalis_pagetitle',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'max' => 256,
                'eval' => 'trim'
            ]
        ]
    ]);
    
    $GLOBALS['TCA']['pages']['palettes']['seo'] = [
        'showitem' => '
            tx_crystalis_pagetitle;LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:pages.tx_crystalis_pagetitle_formlabel,
            --linebreak--,
            tx_crystalis_canonical;LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:pages.tx_crystalis_canonical_formlabel
        ',
        'canNotCollapse' => 1
    ];
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
            'pages', 
            '--palette--;LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:pages.palette_seo;seo', 
            '1,7', 
            'after:abstract');
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'pages', 
            'EXT:crystalis/Resources/Private/Language/locallang_csh_pages.xlf');
    
}