<?php

\defined('TYPO3_MODE') or die('Access denied.');

$_EXTCONF = \unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['crystalis']);

if(!!$_EXTCONF['enableLanguageHandling'] || !$_EXTCONF) {
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_domain', [
        'tx_crystalis_language' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:sys_domain.tx_crystalis_language',
            'displayCond' => 'EXT:realurl:LOADED:true',
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