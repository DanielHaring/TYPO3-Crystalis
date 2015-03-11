<?php

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
 * Fallback RealUrl configuration template. Will be used if no configuration was found.
 * The returning configuration array defines the configuration for a single domain only, 
 * not the whole configuration as you might expect.
 *
 * @since 6.2.0
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @return array Fallback RealUrl configuration
 */
return [
    
        // Behaviour
    'init' => [
        'useCHashCache' => 1,
        'enableCHashCache' => 1,
        'respectSimulateStaticURLs' => 'TRUE',
        'appendMissingSlash' => 'ifNotFile',
        'enableUrlDecodeCache' => 1,
        'enableUrlEncodeCache' => 1
    ],
    
        // Static initial parts
    'preVars' => [
        [
            'GETvar' => 'no_cache',
            'valueMap' => [
                'live' => 1
            ],
            'noMatch' => 'bypass'
        ]
    ],
    
        // Directory path
    'pagePath' => [
        'type' => 'user',
        'userFunc' => 'EXT:realurl/class.tx_realurl_advanced.php:&tx_realurl_advanced->main',
        'spaceCharacter' => '-',
        'segTitleFieldList' => 'tx_realurl_pathsegment,nav_title,title',
        'languageGetVar' => 'L',
        'expireDays' => 7,
        'disablePathCache' => 1,
        'rootpage_id' => 1
    ],
    
        // Prefixed variable sets
    'postVarSets' => [
        '_DEFAULT' => [
            // None
        ]
    ],
    
        // Static trailing parts
    'fixedPostVars' => [
        // None
    ],
    
        // Files
    'fileName' => [
        'index' => [
            // None
        ]
    ]
    
];




