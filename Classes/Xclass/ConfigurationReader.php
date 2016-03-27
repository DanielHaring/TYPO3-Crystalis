<?php

namespace DanielHaring\Crystalis\Xclass;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;





/**
 * Description of ConfigurationReader
 *
 * @since 8.0.0
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ConfigurationReader extends \DmitryDulepov\Realurl\Configuration\ConfigurationReader {





    /**
     * Sets the current host name.
     */
    protected function setHostnames() {

        $this->alternativeHostName = $this->hostName = $this->utility->getCurrentHost();

        if(isset($this->urlParameters['id'])) {

            /* @var $rootLineUtility \TYPO3\CMS\Core\Utility\RootlineUtility */
            $rootLineUtility = GeneralUtility::makeInstance(
                'TYPO3\\CMS\\Core\\Utility\\RootlineUtility',
                $this->urlParameters['id'],
                $this->urlParameters['MP'] ?: '');

            $rootline = $rootLineUtility->get();

            $domains = $this->getDatabaseConnection()->exec_SELECTgetRows(
                'pid,domainName',
                'sys_domain',
                'hidden=0 AND redirectTo=\'\' AND pid IN ('
                . \implode(',', \array_column($rootline, 'uid')) . ')',
                '',
                'sorting DESC',
                '',
                'pid');

            foreach($rootline as $page) {

                if(isset($domains[$page['uid']])) {

                    $this->alternativeHostName = $this->hostName = $domains[$page['uid']]['domainName'];
                    break;

                }

            }

        }

        if (substr($this->hostName, 0, 4) === 'www.') {

            $this->alternativeHostName = substr($this->hostName, 4);

        } elseif (substr_count($this->hostName, '.') === 1) {

            $this->alternativeHostName = 'www.' . $this->hostName;

        }

    }





    /**
     * Returns the current Database Connection.
     *
     * @return \TYPO3\CMS\Core\Database\DatabaseConnection
     */
    protected function getDatabaseConnection() {

        return $GLOBALS['TYPO3_DB'];

    }





}