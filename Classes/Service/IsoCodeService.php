<?php

namespace HARING\Crystalis\Service;

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
 * Description of IsoCodeService
 *
 * @since 7.5.0
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class IsoCodeService extends \TYPO3\CMS\Core\Service\IsoCodeService {





    /**
     * Renders the language array for building selectors.
     * 
     * @since 7.5.0
     * @param array $conf (optional) Pre-configured language configuration
     * @access public
     */
    public function renderIsoCodeSelectDropdown(array $conf = array()) {
        
        $LanguageService = $this->getLanguageService();
        $isoCodes = $this->getIsoCodes();
        $languages = [];
        
        foreach($isoCodes as $isoCode) {
            
            $languages[$isoCode] = 'LLL:EXT:core/Resources/Private/Language/db.xlf:sys_language.language_isocode.' . $isoCode;
            
            if($LanguageService instanceof \TYPO3\CMS\Lang\LanguageService) {
                
                $languages[$isoCode] = $LanguageService->sL($languages[$isoCode]);
                
            }
            
        }
        
        \asort($languages);
            
        $items = [];

        foreach($languages as $isoCode => $name) {

            $items[] = [$name, $isoCode];

        }

        $conf['items'] = \array_merge((array)$conf['items'], $items);

        return $conf;
        
    }





}




