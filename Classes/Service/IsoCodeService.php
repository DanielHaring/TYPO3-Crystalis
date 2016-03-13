<?php

namespace DanielHaring\Crystalis\Service;

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

use TYPO3\CMS\Lang;





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
     * @return array The configuration of the rendered selector
     * @access public
     */
    public function renderIsoCodeSelectDropdown(array $conf = array()) {
        
        $LanguageService = $this->getLanguageService();
        $isoCodes = $this->getIsoCodes();
        $languages = [];
        
        foreach($isoCodes as $isoCode) {
            
            $languages[$isoCode] = 'LLL:EXT:core/Resources/Private/Language/db.xlf:sys_language.language_isocode.' . $isoCode;
            
            if($LanguageService instanceof Lang\LanguageService) {
                
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
    
    
    
    
    
    /**
     * Returns mapping for locales.
     * 
     * @since 7.5.0
     * @return array Mapping for locales
     * @access public
     */
    public function getLocales() {
        
        return [
            'ab' => '',
            'aa' => '',
            'af' => '',
            'ak' => '',
            'sq' => 'sq',
            'am' => '',
            'ar' => 'ar_SA',
            'an' => '',
            'hy' => '',
            'as' => '',
            'av' => '',
            'ae' => '',
            'ay' => '',
            'az' => '',
            'bm' => '',
            'ba' => '',
            'eu' => 'eu_ES',
            'be' => '',
            'bn' => '',
            'bh' => '',
            'bi' => '',
            'bs' => 'bs_BA',
            'br' => '',
            'bg' => 'bg_BG',
            'my' => 'my_MM',
            'ca' => 'ca_ES',
            'ch' => '',
            'ce' => '',
            'ny' => '',
            'zh' => 'zh_CN',
            'cv' => '',
            'kw' => '',
            'co' => '',
            'cr' => '',
            'hr' => 'hr_HR',
            'cs' => 'cs_CZ',
            'da' => 'da_DK',
            'dv' => '',
            'nl' => 'nl_NL',
            'dz' => '',
            'en' => 'en_GB',
            'eo' => '',
            'et' => 'et_EE',
            'ee' => '',
            'fo' => 'fo_FO',
            'fj' => '',
            'fi' => 'fi_FI',
            'fr' => 'fr_FR',
            'ff' => '',
            'gl' => 'gl_ES',
            'ka' => 'ka',
            'de' => 'de_DE',
            'el' => 'el_GR',
            'gn' => '',
            'gu' => '',
            'ht' => '',
            'ha' => '',
            'he' => 'he_IL',
            'hz' => '',
            'hi' => 'hi_IN',
            'ho' => '',
            'hu' => 'hu_HU',
            'ia' => '',
            'id' => '',
            'ie' => '',
            'ga' => '',
            'ig' => '',
            'ik' => '',
            'io' => '',
            'is' => 'is_IS',
            'it' => 'it_IT',
            'iu' => '',
            'ja' => 'ja_JP',
            'jv' => '',
            'kl' => 'kl_DK',
            'kn' => '',
            'kr' => '',
            'ks' => '',
            'kk' => '',
            'km' => 'km',
            'ki' => '',
            'rw' => '',
            'ky' => '',
            'kv' => '',
            'kg' => '',
            'ko' => 'ko_KR',
            'ku' => '',
            'kj' => '',
            'la' => '',
            'lb' => '',
            'lg' => '',
            'li' => '',
            'ln' => '',
            'lo' => '',
            'lt' => 'lt_LT',
            'lu' => '',
            'lv' => 'lv_LV',
            'gv' => '',
            'mk' => '',
            'mg' => '',
            'ms' => '',
            'ml' => '',
            'mt' => 'mt_MT',
            'mi' => '',
            'mr' => '',
            'mh' => '',
            'mn' => '',
            'na' => '',
            'nv' => '',
            'nd' => '',
            'ne' => '',
            'ng' => '',
            'nb' => '',
            'nn' => '',
            'no' => 'no_NO',
            'ii' => '',
            'nr' => '',
            'oc' => '',
            'oj' => '',
            'cu' => '',
            'om' => '',
            'or' => '',
            'os' => '',
            'pa' => '',
            'pi' => '',
            'fa' => 'fa_IR',
            'pl' => 'pl_PL',
            'ps' => '',
            'pt' => 'pt_PT',
            'qu' => '',
            'rm' => '',
            'rn' => '',
            'ro' => 'ro_RO',
            'ru' => 'ru_RU',
            'sa' => '',
            'sc' => '',
            'sd' => '',
            'se' => '',
            'sm' => '',
            'sg' => '',
            'sr' => 'sr_YU',
            'gd' => '',
            'sn' => '',
            'si' => '',
            'sk' => 'sk_SK',
            'sl' => 'sl_SL',
            'so' => '',
            'st' => '',
            'es' => 'es_ES',
            'su' => '',
            'sw' => '',
            'ss' => '',
            'sv' => 'sv_SE',
            'ta' => '',
            'te' => '',
            'tg' => '',
            'th' => 'th_TH',
            'ti' => '',
            'bo' => '',
            'tk' => '',
            'tl' => 'fil',
            'tn' => '',
            'to' => '',
            'tr' => 'tr_TR',
            'ts' => '',
            'tt' => '',
            'tw' => '',
            'ty' => '',
            'ug' => '',
            'uk' => 'uk_UA',
            'ur' => '',
            'uz' => '',
            've' => '',
            'vi' => 'vi_VN',
            'vo' => '',
            'wa' => '',
            'cy' => '',
            'wo' => '',
            'fy' => '',
            'xh' => '',
            'yi' => '',
            'yo' => '',
            'za' => '',
            'zu' => ''
        ];
        
    }
    
    
    
    
    
    /**
     * Returns a locale for a specific ISO code.
     * 
     * @since 7.5.0
     * @param string $isoCode The ISO code for which to return its locale for
     * @return string|boolean The locale as string of FALSE on error
     * @access public
     */
    public function getLocale($isoCode) {
        
        return $this->getLocales()[$isoCode] ?: \FALSE;
        
    }





}




