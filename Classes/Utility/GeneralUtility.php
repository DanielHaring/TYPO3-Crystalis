<?php

namespace DanielHaring\Crystalis\Utility;

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

use TYPO3\CMS\Core\Database\DatabaseConnection;





/**
 * Various helper functions.
 *
 * @since 6.2.0
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class GeneralUtility {
    
    
    
    
    
    /**
     * Returns the TYPO3 database connection or establishes a new one if it doesn't exist.
     * Basically a static version of \TYPO3\CMS\Core\Core\Bootstrap->InitializeTypo3DbGlobal.
     * 
     * @since 6.2.0
     * @return \TYPO3\CMS\Core\Database\DatabaseConnection The TYPO3 database object
     * @access public
     * @static
     */
    public static function obtainDatabaseConnection() {
        
        $fqcn = DatabaseConnection::class;

        if($GLOBALS['TYPO3_DB'] instanceof $fqcn) {

            return $GLOBALS['TYPO3_DB'];

        }
        
        /** @var $databaseConnection \TYPO3\CMS\Core\Database\DatabaseConnection */
        $databaseConnection = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance($fqcn);
        $databaseConnection->setDatabaseName(
            $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['dbname'] ?? '');
        $databaseConnection->setDatabaseUsername(
            $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['user'] ?? '');
        $databaseConnection->setDatabasePassword(
            $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['password'] ?? '');
        
        $databaseHost = $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['host'] ?? '';
        
        if(isset($GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['port'])) {
            
            $databaseConnection->setDatabasePort(
                $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['port']);
            
        } elseif (\strpos($databaseHost, ':') > 0) {
            
            /**
             * @todo Monitor if something is changed here in versions after TYPO3 CMS 8.1.0
             */
            list($databaseHost, $databasePort) = explode(':', $databaseHost);
            $databaseConnection->setDatabasePort($databasePort);
            
        }
        
        if(isset($GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['unix_socket'])) {
            
            $databaseConnection->setDatabaseSocket(
                $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['unix_socket']);
            
        }
        
        $databaseConnection->setDatabaseHost($databaseHost);

        $databaseConnection->debugOutput = $GLOBALS['TYPO3_CONF_VARS']['SYS']['sqlDebug'];

        if(isset($GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['persistentConnection'])
            && $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['persistentConnection']) {

            $databaseConnection->setPersistentDatabaseConnection(\TRUE);

        }

        if(isset($GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['driverOptions'])
            && $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['driverOptions'] & \MYSQLI_CLIENT_COMPRESS
            && !\in_array($databaseHost, ['localhost', '127.0.0.1', '::1'], \TRUE)) {

            $databaseConnection->setConnectionCompression(\TRUE);

        }

        if(!empty($GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['initCommands'])) {

            $commandsAfterConnect = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(
                \LF,
                \str_replace(
                    '\' . LF . \'',
                    \LF,
                    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['initCommands']),
                \TRUE);

            $databaseConnection->setInitializeCommandsAfterConnect($commandsAfterConnect);

        }

        $GLOBALS['TYPO3_DB'] = $databaseConnection;
        $GLOBALS['TYPO3_DB']->initialize();

        return $GLOBALS['TYPO3_DB'];
        
    }
    
    
    
    
    
}




