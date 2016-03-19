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

use DanielHaring\Crystalis\Configuration\UrlRewriting\RealurlConfigurator;
use DanielHaring\Crystalis\Service\LanguageService;
use DanielHaring\Crystalis\Tests\Unit\Service\AccessibleProxies\ExtensionManagementUtilityAccessibleProxy;
use DanielHaring\Crystalis\Tests\Unit\Service\AccessibleProxies\LanguageServiceAccessibleProxy;
use DanielHaring\Crystalis\Tests\Unit\Service\Fixtures\LanguageServiceHookFixture;
use DanielHaring\Crystalis\Tests\Unit\Service\Fixtures\RewriteConfiguratorFixture;
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
     * @var \TYPO3\CMS\Core\Package\PackageManager
     */
    protected $backupPackageManager;

    /**
     * @var \DanielHaring\Crystalis\Service\LanguageService
     */
    protected $subject;





    protected function setUp() {

        $this->subject = new LanguageService();
        $this->backupPackageManager = ExtensionManagementUtilityAccessibleProxy::getPackageManager();

    }





    protected function tearDown() {

        ExtensionManagementUtility::clearExtensionKeyMap();
        ExtensionManagementUtilityAccessibleProxy::setPackageManager($this->backupPackageManager);
        $GLOBALS['TYPO3_LOADED_EXT'] = new LoadedExtensionsArray($this->backupPackageManager);
        LanguageServiceAccessibleProxy::resetRewriteConfigurators();

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





    /**
     * @test
     */
    public function getRewriteConfiguratorsThrowsExceptionIfInterfaceNotImplemented() {

        $this->setExpectedException('RuntimeException');

        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['crystalis']['LanguageService']['registerRewriteConfigurator'][]
            = LanguageServiceHookFixture::class . '->provideInvalidConfigurator';

        ExtensionManagementUtilityAccessibleProxy::setPackageManager(
            $this->createMockPackageManagerWithMockPackage('foobar'));

        $this->subject->getRewriteConfigurators();

    }





    /**
     * @test
     */
    public function getRewriteConfiguratorsSkipsDisabledExtension() {

        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['crystalis']['LanguageService']['registerRewriteConfigurator'][]
            = LanguageServiceHookFixture::class . '->provideValidConfigurator';

        if(ExtensionManagementUtility::isLoaded('realurl')) {

            $this->assertSame(
                ['realurl' => RealurlConfigurator::class],
                $this->subject->getRewriteConfigurators());

        } else {

            $this->assertSame(
                [],
                $this->subject->getRewriteConfigurators());

        }

    }





    /**
     * @test
     */
    public function getRewriteConfiguratorsReturnsCorrectResult() {

        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['crystalis']['LanguageService']['registerRewriteConfigurator'][]
            = LanguageServiceHookFixture::class . '->provideValidConfigurator';

        ExtensionManagementUtilityAccessibleProxy::setPackageManager(
            $this->createMockPackageManagerWithMockPackage('foobar'));

        $this->assertSame(
            ['foobar' => RewriteConfiguratorFixture::class],
            $this->subject->getRewriteConfigurators());

    }





}