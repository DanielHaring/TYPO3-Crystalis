<?php

namespace DanielHaring\Crystalis\Tests\Unit\Utility;

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

use DanielHaring\Crystalis\Utility\ExtensionManagerConfigurationUtility;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Lang\LanguageService;





/**
 * Test Case.
 *
 * @since 7.6.1
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ExtensionManagerConfigurationUtilityTest extends UnitTestCase {





    /**
     * @var \DanielHaring\Crystalis\Utility\ExtensionManagerConfigurationUtility
     */
    protected $subject;





    protected function setUp() {

        $this->subject = new ExtensionManagerConfigurationUtility();

    }





    /**
     * @test
     */
    public function getLanguageServiceReturnsCorrectInstance() {

        $this->assertInstanceOf(LanguageService::class, $this->subject->getLanguageService());

    }





}