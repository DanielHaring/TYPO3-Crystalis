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

use DanielHaring\Crystalis\Service\IsoCodeService;
use TYPO3\CMS\Core\Tests\UnitTestCase;





/**
 * Test Case.
 *
 * @since 7.6.1
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class IsoCodeServiceTest extends UnitTestCase {





    /**
     * @var \DanielHaring\Crystalis\Service\IsoCodeService
     */
    protected $subject;





    protected function setUp() {

        $this->subject = new IsoCodeService();

    }





    /**
     * @test
     */
    public function renderIsoCodeSelectDropdownReturnsCorrectResult() {

        $result = $this->subject->renderIsoCodeSelectDropdown(['items' => [[
            'Foo',
            'bar'
        ]]]);

        $this->assertArraySubset([0 => ['Foo', 'bar']], $result['items']);

        $this->assertCount(185, $result['items']);

    }





    /**
     * @test
     * @dataProvider getLocaleReturnsCorrectResultDataProvider
     *
     * @param string $isoCode
     * @param mixed $expectedResult
     */
    public function getLocaleReturnsCorrectResult($isoCode, $expectedResult) {

        $this->assertSame($expectedResult, $this->subject->getLocale($isoCode));

    }





    /**
     * @return array
     */
    public function getLocaleReturnsCorrectResultDataProvider() {

        return[
            'finds existing locale' => [
                'de',
                'de_DE'
            ],
            'returns false if locale is empty' => [
                'zu',
                \FALSE
            ],
            'returns false if iso code not found' => [
                'at',
                \FALSE
            ]
        ];

    }





}