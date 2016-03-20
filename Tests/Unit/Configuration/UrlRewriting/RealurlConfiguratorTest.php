<?php

namespace DanielHaring\Crystalis\Tests\Unit\Configuration\UrlRewriting;

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

use DanielHaring\Crystalis\Configuration\UrlRewriting\RealurlConfigurator;
use DanielHaring\Crystalis\Service\DatabaseService;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\VariableFrontend;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;





/**
 * Test Case.
 *
 * @since 7.6.1
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class RealurlConfiguratorTest extends UnitTestCase {





    /**
     * @var \DanielHaring\Crystalis\Configuration\UrlRewriting\RealurlConfigurator
     */
    protected $subject;





    protected function setUp() {

        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl'] = [];

        $this->subject = new RealurlConfigurator();
        $this->subject->disableRealurlAutoconf();
        $this->subject->disableCache();

    }





    /**
     * @test
     */
    public function configureGeneratesCorrectConfiguration() {

        /* @var $databaseMock \PHPUnit_Framework_MockObject_MockObject|\DanielHaring\Crystalis\Service\DatabaseService */
        $databaseMock = $this->getMock(DatabaseService::class, ['getSystemLanguages', 'getDomainAssignments']);

        $databaseMock->expects($this->atLeastOnce())
            ->method('getSystemLanguages')
            ->will($this->returnValue([
                [
                    'isoCode' => 'en',
                    'uid' => 0,
                    'locale' => 'en_GB',
                    'name' => 'LLL:EXT:core/Resources/Private/Language/db.xlf:sys_language.language_isocode.en'
                ],
                [
                    'isoCode' => 'de',
                    'uid' => 1,
                    'locale' => 'de_DE',
                    'name' => 'LLL:EXT:core/Resources/Private/Language/db.xlf:sys_language.language_isocode.de'
                ],
                [
                    'isoCode' => 'fr',
                    'uid' => 2,
                    'locale' => 'fr_FR',
                    'name' => 'LLL:EXT:core/Resources/Private/Language/db.xlf:sys_language.language_isocode.fr'
                ]
            ]));

        $databaseMock->expects($this->atLeastOnce())
            ->method('getDomainAssignments')
            ->will($this->returnValue([
                'example.org' => [
                    'host' => 'example.org',
                    'rootPage' => '1',
                    'languages' => [
                        [
                            'uid' => '1',
                            'isoCode' => 'de'
                        ],
                        [
                            'uid' => 0,
                            'isoCode' => 'en'
                        ]
                    ],
                    'useDefaultLanguage' => '1',
                    'priority' => '128',
                    'initialLanguage' => '0',
                    'protocol' => 'http'
                ],
                'www.example.org' => [
                    'host' => 'www.example.org',
                    'rootPage' => '1',
                    'languages' => [
                        [
                            'uid' => '1',
                            'isoCode' => 'de'
                        ],
                        [
                            'uid' => 0,
                            'isoCode' => 'en'
                        ]
                    ],
                    'useDefaultLanguage' => '1',
                    'priority' => '256',
                    'initialLanguage' => '',
                    'protocol' => 'http'
                ]
            ]));

        $this->subject->setDatabaseService($databaseMock);
        $this->subject->configure();

        $this->assertStringEqualsFile(
            GeneralUtility::getFileAbsFileName('EXT:crystalis/Tests/Unit/Configuration/UrlRewriting/realurl'),
            \serialize($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']));

    }





    /**
     * @test
     */
    public function getDatabaseServiceReturnsCorrectInstance() {

        $this->assertInstanceOf(DatabaseService::class, $this->subject->getDatabaseService());

    }





    /**
     * @test
     */
    public function setDatabaseServiceSetsInstance() {

        /* @var $mock \PHPUnit_Framework_MockObject_MockObject|\DanielHaring\Crystalis\Service\DatabaseService */
        $mock = $this->getMock(DatabaseService::class);

        $this->subject->setDatabaseService($mock);

        $this->assertSame($mock, $this->subject->getDatabaseService());

    }





    /**
     * @test
     */
    public function isCacheEnabledReturnsCorrectValue() {

        $this->subject->enableCache();

        $this->assertTrue($this->subject->isCacheEnabled());

        $this->subject->disableCache();

        $this->assertFalse($this->subject->isCacheEnabled());

    }





    /**
     * @test
     */
    public function getCacheManagerReturnsCorrectInstance() {

        $this->assertInstanceOf(CacheManager::class, $this->subject->getCacheManager());

    }





    /**
     * @test
     */
    public function getCacheReturnsCorrectInstance() {

        $this->assertInstanceOf(VariableFrontend::class, $this->subject->getCache());

    }





    /**
     * @test
     */
    public function isRealurlAutoconfEnabledReturnsCorrectResult() {

        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['realurl'] = \serialize(['enableAutoConf' => \TRUE]);

        $this->subject->detectRealurlAutoconf();

        $this->assertTrue($this->subject->isRealurlAutoconfEnabled());

        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['realurl'] = \serialize(['enableAutoConf' => \FALSE]);

        $this->subject->detectRealurlAutoconf();

        $this->assertFalse($this->subject->isRealurlAutoconfEnabled());

        $this->subject->enableRealurlAutoconf();

        $this->assertTrue($this->subject->isRealurlAutoconfEnabled());

        $this->subject->disableRealurlAutoconf();

        $this->assertFalse($this->subject->isRealurlAutoconfEnabled());

    }





}