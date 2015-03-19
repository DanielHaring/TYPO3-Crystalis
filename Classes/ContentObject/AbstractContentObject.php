<?php

namespace HARING\Crystalis\ContentObject;

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
 * Abstract for content object rendered by Crystalis.
 *
 * @since 6.2.0
 * @author Daniel Haring <development@haring.co.at>
 * @package Crystalis
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
abstract class AbstractContentObject extends \TYPO3\CMS\Frontend\ContentObject\AbstractContentObject {
    
    
    
    
    
    /**
     * The TYPO3 File Repository
     * 
     * @since 6.2.0
     * @var \TYPO3\Core\CMS\Resource\FileRepository
     * @access private
     */
    private $FileRepository;
    
    
    
    
    
    /**
     * Builds TypoScript array out of FlexForm and stores it within the given configuration array.
     * 
     * @since 6.2.0
     * @param array $conf The configuration where to read out and store FlexForm
     * @param string $property The name of the property which holds FlexForm
     * @param string $storage (Optional) The name of the property where the created array should be stored.
     *                        If omitted, the FlexForm property will be overwritten.
     * @access protected
     */
    protected function substituteFlexForm(array &$conf, $property, $storage = FALSE) {
        
        $flexParams = \is_array($conf[$property . '.']) 
                ? $this->cObj->stdWrap((string) $conf[$property], $conf[$property . '.']) 
                : (string) $conf[$property];
        
        if($flexParams[0] === '<') {
            
            $flexParams = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($flexParams, 'T3');
            
            foreach($flexParams['data'] as $sheetData) {
                
                $this->cObj->readFlexformIntoConf($sheetData['lDEF'], $conf[($storage ?: $property) . '.'], TRUE);
                
            }
            
        }
        
    }
    
    
    
    
    
    /**
     * Interprets a configuration item as some kind of file identifier and tries to
     * build a respective file object.
     * 
     * Supports stdWrap.
     * 
     * There are basically 3 types of identifiers which can be resolved correctly:
     * 
     * Number: A simple number will be interpreted as FAL reference count and therefore FileRepository will be called
     * 
     * Number prefixed with "file:": If a number is prefixed with "file:" it will be interpreted as UID of a sys_file item
     * 
     * Regular string: Normal strings will be interpreted as Resource data type (e.g. "EXT:crystalis/path/to/file.jpg", or "path/to/file.jpg")
     * 
     * @since 6.2.0
     * @param string $field The name of the field which stores the identifier
     * @param array $conf The TypoScript configuration where identifier is stored
     * @return array The path to the file or FALSE if an error occured
     * @access protected
     */
    protected function resolveFileObjects($field, $conf) {
        
        if(!isset($conf[$field]) && !\is_array($conf[$field . '.'])) {
            
            return [];
            
        }
        
        $identifier = \is_array($conf[$field . '.']) 
                ? $this->cObj->stdWrap((string) $conf[$field], $conf[$field . '.']) 
                : (string) $conf[$field];
        
        if(\TYPO3\CMS\Core\Utility\MathUtility::canBeInterpretedAsInteger($identifier)) {
            
            $fileReferences = $this->retrieveFileReferences($field);
            
        } else {
            
            try{
                
                $fileReferences = \is_a(
                        $resource = $this->fileFactory->retrieveFileOrFolderObject($identifier), 
                        'TYPO3\\CMS\\Core\\Resource\\File') 
                            ? [$resource]
                            : \NULL;
                
            } catch (\TYPO3\CMS\Core\Resource\Exception\FolderDoesNotExistException $folderNotFoundException) {
            } catch (\TYPO3\CMS\Core\Resource\Exception\FileDoesNotExistException $fileNotFoundException) {}
            
        }
        
        return (array) $fileReferences;
        
    }
    
    
    
    
    
    /**
     * Retrieves FAL file references.
     * 
     * @since 6.2.0
     * @param string $field The field name of which to retrieve the file for
     * @return array The retrieved file references
     * @access protected
     */
    protected function retrieveFileReferences($field) {
        
        return (array) $this->getFileRepository()->findByRelation(
                $this->cObj->getCurrentTable(), 
                (string) $field, 
                $this->cObj->data['uid']);
        
    }
    
    
    
    
    
    /**
     * Returns the TYPO3 File Repository
     * 
     * @since 6.2.0
     * @return \TYPO3\CMS\Core\Resource\FileRepository The File Repository
     * @access protected
     * @final
     */
    final protected function getFileRepository() {
        
        if(!\is_a($this->FileRepository, 'TYPO3\\CMS\\Core\\Resource\\FileRepository')) {
            
            $this->FileRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                    'TYPO3\\CMS\\Core\\Resource\\FileRepository');
            
        }
        
        return $this->FileRepository;
        
    }
    
    
    
    
    
}




