<?php

namespace DanielHaring\Crystalis\Tests\Unit\Service;

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

use DanielHaring\Crystalis\Configuration\UrlRewriting\ConfiguratorInterface;
use DanielHaring\Crystalis\Service\LanguageService;
use DanielHaring\Crystalis\Tests\Unit\Utility\AccessibleProxies\ExtensionManagementUtilityAccessibleProxy;
use TYPO3\CMS\Core\Compatibility\LoadedExtensionsArray;
use TYPO3\CMS\Core\Package\Package;
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;





/**
 * Test Case.
 *
 * @since 7.6.1
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class LanguageServiceTest extends UnitTestCase {





    /**
     * @var \DanielHaring\Crystalis\Service\LanguageService
     */
    protected $subject;





    protected function setUp() {

        $this->subject = new LanguageService();

    }





    /**
     * @test
     */
    public function getLanguagesReturnsCorrectResult() {

        $result = $this->subject->getLanguages();

        $this->assertInternalType('array', $result);
        $this->assertCount(184, $result);

        $this->assertArraySubset(['de' => [
            'isoCode' => 'de',
            'locale' => 'de_DE',
            'name' => 'LLL:EXT:core/Resources/Private/Language/db.xlf:sys_language.language_isocode.de'
        ]], $result);

    }





}