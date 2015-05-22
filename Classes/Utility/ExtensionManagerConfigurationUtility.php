<?php

namespace HARING\Crystalis\Utility;

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





/**
 * Procides extension manager configurations.
 *
 * @since 7.2.0
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ExtensionManagerConfigurationUtility {
    
    
    
    
    
    /**
     * Renders a select box of all available languages.
     * To be called within ext_conf_template.txt.
     * 
     * @since 7.2.0
     * @param array $params Parameteres of the respective extension configuration field
     * @return string HTML output of the rendered select box or an error message if something went wrong
     * @access public
     * @static
     */
    public static function buildLanguageSelector(array $params) {
        
        if(!\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('static_info_tables')) {
            
            return '<div class="panel panel-warning"><div class="panel-heading">' 
                    . $GLOBALS['LANG']->sL(
                            'LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:extconf.title_Warning') 
                    . '</div><div class="panel-body">' . $GLOBALS['LANG']->sL(
                            'LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:extconf.label_DefaultLanguage_NoSit') 
                    . '</div></div>';
            
        }
        
        /* @var $ObjectManager \TYPO3\CMS\Extbase\Object\ObjectManager */
        $ObjectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                'TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        
        /* @var $LanguageRepository \SJBR\StaticInfoTables\Domain\Repository\LanguageRepository */
        $LanguageRepository = $ObjectManager->get(
                'SJBR\\StaticInfoTables\\Domain\\Repository\\LanguageRepository');
        
        $languages = [];
        
        $query = $LanguageRepository->createQuery();
        $query->setOrderings(['lg_iso_2' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING]);
        
        foreach($query->execute() as $language) {
            
            $languages[] = [
                'value' => \strtolower($language->getUid()),
                'name' => \strtolower($language->getIsoCodeA2()) . ' – ' . $language->getNameEn()
            ];
            
        }
        
        $selected = [$params['fieldValue']];
        
        return \SJBR\StaticInfoTables\Utility\HtmlElementUtility::selectConstructor(
                $languages,
                $selected,
                $selected,
                $params['fieldName']);
        
    }
    
    
    
    
    
}




