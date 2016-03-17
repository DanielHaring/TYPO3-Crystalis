<?php

namespace DanielHaring\Crystalis\Utility;

/*
 * **************************************************************
 * Copyright notice
 *
 * (c) 2015 Daniel Haring <development@haring.co.at>
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
 * **************************************************************
 */





/**
 * Helper functions concerning array handling.
 *
 * @since 6.2.0
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ArrayUtility {
    
    
    
    
    
    /**
     * Checks whether an array is associative or not.
     * 
     * @since 7.2.0
     * @param array $array The array to check
     * @return boolean TRUE if an associative array was given, FALSE otherwise
     * @access public
     * @static
     */
    public static function isAssociative(array $array) {
        
        return \count($array) && \array_keys($array) !== range(0, sizeof($array) - 1);
        
    }
    
    
    
    
    
}




