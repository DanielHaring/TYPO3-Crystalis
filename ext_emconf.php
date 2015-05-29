<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "crystalis".
 *
 * Auto generated 10-05-2014 16:30
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Crystalis',
        'description' => 'A flexible headstone for professional next generation TYPO3 CMS websites. ' 
                            . 'Crystalis provides content rendering, pre-configured setups, fully automatic language handling and many more. ',
	'category' => 'fe',
	'version' => '7.2.0-dev',
	'state' => 'beta',
	'uploadfolder' => 0,
	'createDirs' => '',
	'clearCacheOnLoad' => 1,
	'author' => 'Daniel Haring',
	'author_email' => 'development@haring.co.at',
	'author_company' => '',
	'constraints' => 
	array (
		'depends' => 
		array (
			'extbase' => '7.2.0-7.2.99',
			'fluid' => '7.2.0-7.2.99',
			'typo3' => '7.2.0-7.2.99',
		),
		'conflicts' => 
		array (
		),
		'suggests' => 
		array (
                        'realurl' => '1.13.3-0.0.0',
		),
	),
);

?>