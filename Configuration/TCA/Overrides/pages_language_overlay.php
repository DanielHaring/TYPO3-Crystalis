<?php

\defined('TYPO3_MODE') or die('Access denied.');

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