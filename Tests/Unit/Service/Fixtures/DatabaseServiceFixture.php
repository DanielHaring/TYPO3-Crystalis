<?php

namespace DanielHaring\Crystalis\Tests\Unit\Service\Fixtures;

/**
 * Copyright notice
 *
 * (c) 2016 Daniel Haring <development@haring.co.at>
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
 */

use DanielHaring\Crystalis\Service\DatabaseService;





/**
 * Database Service Fixture.
 *
 * @since 7.6.1
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class DatabaseServiceFixture extends DatabaseService {





    /**
     * @return array
     */
    protected function retrieveDomainInformation() {

        return [
            'example.org' => [
                'host' => 'example.org',
                'rootPage' => '1',
                'languages' => '1',
                'useDefaultLanguage' => '1',
                'priority' => '128',
                'initialLanguage' => '0',
                'protocol' => 'http'
            ],
            'www.example.org' => [
                'host' => 'www.example.org',
                'rootPage' => '1',
                'languages' => '1',
                'useDefaultLanguage' => '1',
                'priority' => '256',
                'initialLanguage' => '',
                'protocol' => 'http'
            ]
        ];

    }





    /**
     * @param string $defaultLanguage
     * @return array
     */
    protected function retrieveSystemLanguageInformation($defaultLanguage = '') {

        return [
            [
                'uid' => 0,
                'isoCode' => 'en',
                'locale' => 'en_GB',
                'name' => 'LLL:EXT:core/Resources/Private/Language/db.xlf:sys_language.language_isocode.en'
            ],
            [
                'uid' => '1',
                'isoCode' => 'de',
                'locale' => 'de_DE',
                'name' => 'LLL:EXT:core/Resources/Private/Language/db.xlf:sys_language.language_isocode.de'
            ]
        ];

    }





}