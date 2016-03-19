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

use DanielHaring\Crystalis\Utility\ArrayUtility;
use TYPO3\CMS\Core\Tests\UnitTestCase;





/**
 * Test Case.
 *
 * @since 7.6.1
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ArrayUtilityTest extends UnitTestCase {





    /**
     * @test
     * @dataProvider isAssociativeReturnsCorrectResultDataProvider
     *
     * @param array $testArray
     * @param $expectedResult
     */
    public function isAssociativeReturnsCorrectResult(array $testArray, $expectedResult) {

        $this->assertSame($expectedResult, ArrayUtility::isAssociative($testArray));

    }





    /**
     * @return array
     */
    public function isAssociativeReturnsCorrectResultDataProvider() {

        return [
            'recognizes indexed arrays' => [
                ['foo', 'bar', 'baz', 'qux'],
                \FALSE
            ],
            'treats explicitly indexed arrays as indexed' => [
                [0 => 'foo', 1 => 'bar', 2 => 'baz', 3 => 'qux'],
                \FALSE
            ],
            'treats inconsistent numeric keys as associative' => [
                [1 => 'foo', 2 => 'bar', 4 => 'baz', 9 => 'qux'],
                \TRUE
            ],
            'allows consistent indexes to be of type string' => [
                ['0' => 'foo', 1 => 'bar', '2' => 'baz', 3 => 'qux'],
                \FALSE
            ],
            'treats mixed keys as associative' => [
                [0 => 'foo', 1 => 'bar', 'baz' => 'qux'],
                \TRUE
            ],
            'recognizes definite associative arrays' => [
                ['foo' => 'bar', 'baz' => 'qux'],
                \TRUE
            ]
        ];

    }





}