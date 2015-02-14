<?php

\defined('TYPO3_MODE') or die('Access denied.');

$_EXTCONF = \unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['crystalis']);
$_EXTKEY = 'crystalis';

// Register HTML5 Video content element
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
    
}