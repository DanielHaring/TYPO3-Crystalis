<?php

\defined('TYPO3_MODE') or die('Access denied.');

$_EXTCONF = \unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['crystalis']);
$_EXTKEY = 'crystalis';





    // Provide render templates
switch($_EXTCONF['doctype']) {
    
    case 'xhtml_strict':
        
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
                $_EXTKEY, 
                'Configuration/TypoScript/Controller/XHtmlStrict', 
                'Frontend Rendering');
        
        break;
    
    case 'html5': // fallthrough
    default:
        
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
                $_EXTKEY, 
                'Configuration/TypoScript/Controller/Html5', 
                'Frontend Rendering');
        
        break;
    
}