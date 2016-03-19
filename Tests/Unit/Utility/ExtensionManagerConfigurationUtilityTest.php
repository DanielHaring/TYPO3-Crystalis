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

use DanielHaring\Crystalis\Tests\Unit\Utility\AccessibleProxies\ExtensionManagementUtilityAccessibleProxy;
use DanielHaring\Crystalis\Tests\Unit\Utility\Fixtures\LanguageServiceHooksFixture;
use DanielHaring\Crystalis\Utility\ExtensionManagerConfigurationUtility;
use TYPO3\CMS\Core\Compatibility\LoadedExtensionsArray;
use TYPO3\CMS\Core\Package\Package;
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
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
     * @var \TYPO3\CMS\Core\Package\PackageManager
     */
    protected $backupPackageManager;

    /**
     * @var \DanielHaring\Crystalis\Utility\ExtensionManagerConfigurationUtility
     */
    protected $subject;





    protected function setUp() {

        $this->subject = new ExtensionManagerConfigurationUtility();
        $this->backupPackageManager = ExtensionManagementUtilityAccessibleProxy::getPackageManager();

    }





    protected function tearDown() {

        ExtensionManagementUtility::clearExtensionKeyMap();
        ExtensionManagementUtilityAccessibleProxy::setPackageManager($this->backupPackageManager);
        $GLOBALS['TYPO3_LOADED_EXT'] = new LoadedExtensionsArray($this->backupPackageManager);

        parent::tearDown();

    }





    /**
     * @param $packageKey
     * @return \TYPO3\CMS\Core\Package\PackageManager|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockPackageManagerWithMockPackage($packageKey) {

        $packagePath = \PATH_site . 'typo3temp/' . $packageKey . '/';

        GeneralUtility::mkdir_deep($packagePath);

        $this->testFilesToDelete[] = $packagePath;

        /* @var $package \TYPO3\CMS\Core\Package\Package|\PHPUnit_Framework_MockObject_MockObject */
        $package = $this->getMockBuilder(Package::class)
            ->disableOriginalConstructor()
            ->setMethods(['getPackagePath', 'getPackageKey'])
            ->getMock();

        /* @var $packageManager \TYPO3\CMS\Core\Package\PackageManager|\PHPUnit_Framework_MockObject_MockObject */
        $packageManager = $this->getMock(
            PackageManager::class,
            ['isPackageActive', 'getPackage', 'getActivePackages']);

        $package->expects($this->any())
            ->method('getPackagePath')
            ->will($this->returnValue($packagePath));

        $package->expects($this->any())
            ->method('getPackageKey')
            ->will($this->returnValue($packageKey));

        $packageManager->expects($this->any())
            ->method('isPackageActive')
            ->will($this->returnValueMap([
                [\NULL, \FALSE],
                [$packageKey, \TRUE]
            ]));

        $packageManager->expects($this->any())
            ->method('getPackage')
            ->with($this->equalTo($packageKey))
            ->will($this->returnValue($package));

        $packageManager->expects($this->any())
            ->method('getActivePackages')
            ->will($this->returnValue([$packageKey => $package]));

        return $packageManager;

    }





    /**
     * @test
     */
    public function getLanguageServiceReturnsCorrectInstance() {

        $this->assertInstanceOf(LanguageService::class, $this->subject->getLanguageService());

    }





    /**
     * @test
     * @dataProvider externalLanguageConfiguratorLoadableReturnsCorrectResultDataProvider
     *
     * @param string $userFunc
     * @param boolean $activateExtension
     * @param boolean $expectedResult
     */
    public function externalLanguageConfiguratorLoadableReturnsCorrectResult(
        $userFunc,
        $activateExtension,
        $expectedResult) {

        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['crystalis']['LanguageService']['registerRewriteConfigurator'][] = $userFunc;

        if($activateExtension) {

            ExtensionManagementUtilityAccessibleProxy::setPackageManager(
                $this->createMockPackageManagerWithMockPackage('foobar'));

        }

        $this->assertSame($expectedResult, $this->subject->externalLanguageConfiguratorLoadable());

    }





    /**
     * @return array
     */
    public function externalLanguageConfiguratorLoadableReturnsCorrectResultDataProvider() {

        return [
            'detects available configurator' => [
                LanguageServiceHooksFixture::class . '->provideValidConfigurator',
                \TRUE,
                \TRUE
            ],
            'fails if interface is not implemented' => [
                LanguageServiceHooksFixture::class . '->provideInvalidConfigurator',
                \TRUE,
                \FALSE
            ],
            'fails if extension is not loaded' => [
                LanguageServiceHooksFixture::class . '->provideValidConfigurator',
                \FALSE,
                \FALSE
            ]
        ];

    }





}