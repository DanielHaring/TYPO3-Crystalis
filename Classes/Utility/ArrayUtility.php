<?php

namespace HARING\Crystalis\Utility;

/*
 * **************************************************************
 * Copyright notice
 *
 * (c) 2014 Daniel Haring <development@haring.co.at>
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
 * @since 2.0.0
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ArrayUtility {
    
    
    
    
    
    /**
     * Return the values from a single column in the input array.
     * Polyfill of \array_column for PHP prior v5.5.
     * 
     * @since 2.0.0
     * @param array $array A multi-dimensional array (record set) from which to pull a column of values.
     * @param mixed $columnKey The column of values to return. This value may be the integer key of the column 
     *                         you wish to retrieve, or it may be the string key name for an associative array. 
     *                         It may also be NULL to return complete arrays (useful together with indexKey 
     *                         to reindex the array).
     * @param mixed $indexKey The column to use as the index/keys for the returned array. This value may be the 
     *                        integer key of the column, or it may be the string key name.
     * @return array An array of values representing a single column from the input array.
     * @access public
     * @static
     */
    public static function column(array $array, $columnKey, $indexKey = \NULL) {
        
        if(\function_exists('array_column')) {
            
            return \array_column($array, $columnKey, $indexKey);
            
        }
        
        $columns = [];
        
        foreach($array as $key => $value) {
            
            $columns[$indexKey ? $value[$indexKey] : $key] = $value[$columnKey];
            
        }
        
        return $columns;
        
    }
    
    
    
    
    
}




