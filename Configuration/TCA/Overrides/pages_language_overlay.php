<?php

\defined('TYPO3_MODE') or die('Access denied.');

$_EXTCONF = \unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['crystalis']);

if(!$_EXTCONF['disableSeo'] || !$_EXTCONF) {
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages_language_overlay', [
        'tx_crystalis_canonical' => [
            'exclude' => 1,
            'label' => $GLOBALS['TCA']['pages']['columns']['tx_crystalis_canonical']['label'],
            'config' => $GLOBALS['TCA']['pages']['columns']['tx_crystalis_canonical']['config']
        ],
        'tx_crystalis_pagetitle' => [
            'exclude' => 1,
            'label' => $GLOBALS['TCA']['pages']['columns']['tx_crystalis_pagetitle']['label'],
            'config' => $GLOBALS['TCA']['pages']['columns']['tx_crystalis_pagetitle']['config']
        ]
    ]);
    
    $GLOBALS['TCA']['pages_language_overlay']['palettes']['seo'] = [
        'showitem' => '
            tx_crystalis_pagetitle;LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:pages.tx_crystalis_pagetitle_formlabel,
            --linebreak--,
            tx_crystalis_canonical;LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:pages.tx_crystalis_canonical_formlabel
        ',
        'canNotCollapse' => 1
    ];
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
            'pages_language_overlay', 
            '--palette--;LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:pages.palette_seo;seo', 
            '1,7', 
            'after:abstract');
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'pages_language_overlay', 
            'EXT:crystalis/Resources/Private/Language/locallang_csh_pages.xlf');
    
}