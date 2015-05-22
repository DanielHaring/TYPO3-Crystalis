.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _lang-custom-realurl:

Customizing RealUrl configuration
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

As mentioned before, the Language Service will configure RealUrl to properly handle your domains and languages. For 
this purpose, it will adopt the present RealUrl configuration and alteres it to fit your site structure. The 
present configuration is defined inside the extension configuration of RealUrl (*Extension Manager* > *RealUrl* > 
*"Path to configuration file"*) – if enabled the automatic configuration also will be taken into account. However, 
if there isn't any configuration file present and automatic configuration is disabled (what is receommended, but not 
set by default), Crystalis provides its own RealUrl base configuration to which it will fall back. This file is 
located in *"Configuration/PHP/RealUrl/FallbackTemplate.php"* inside Crystalis' extension directory.

Now if you want to configure RealUrl by yourself but still want to make use of the Language Service, all you have 
to do is to write your own RealUrl base configuration and register that file in RealUrl extension configuration.
The Language Service will automatically adopt your configuration and adds all missing domains and languages.

Please desist from configuring domains and languages by yourself as this may lead to conflicts with the Language 
Service. If Crystalis finds an entry for a specific domain it will leave it untouched – adding no language specific
configurations.

The best practice for providing custom RealUrl configurations is to add a single entry for a domain called 
*'localhost'*.


Example
"""""""

.. code-block:: php

     1 <?php
     2 
     3 $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl'] = [
     4 
     5     'localhost' => [
     6 
     7         'init' => [
     8             'useCHashCache' => 1,
     9             'enableCHashCache' => 1,
    10             'respectSimulateStaticURLs' => 'TRUE',
    11             'appendMissingSlash' => 'ifNotFile',
    12             'enableUrlDecodeCache' => 1,
    13             'enableUrlEncodeCache' => 1
    14         ],
    15 
    16         'preVars' => [
    17 
    18              'GETvar' => 'no_cache',
    19              'valueMap' => [
    20                  'nc' => 1
    21              ],
    22              'noMatch' => 'bypass'
    23 
    24          ],
    25
    26          'pagePath' => [
    27              'type' => 'user',
    28              'userFunc' => 'EXT:realurl/class.tx_realurl_advanced.php:&tx_realurl_advanced->main',
    29              'spaceCharacter' => '-',
    30              'segTitleFieldList' => 'tx_realurl_pathsegment,nav_title,title',
    31              'languageGetVar' => 'L',
    32              'expireDays' => 7,
    33              'disablePathCache' => 1,
    34              'rootpage_id' => 1
    35          ],
    36 
    37          'fixedPostVars' => [
    38 
    39              'news' => [
    40 
    41                  [
    42                      'GETvar' => 'tx_ttnews[tt_news]',
    43                      'lookUpTable' => [
    44                          'table' => 'tt_news',
    45                          'id_field' => 'uid',
    46                          'alias_field' => 'title',
    47                          'addWhereClause' => 'AND NOT hidden AND NOT deleted',
    48                          'useUniqueCache' => 1,
    49                          'useUniqueCache_conf' => [
    50                              'strtolower' => 1,
    51                              'spaceCharacter' => '-'
    52                          ],
    53                          'languageGetVar' => 'L',
    54                          'languageField' => 'sys_language_uid',
    55                          'transOrigPointerField' => 'l18n_parent'
    56                      ]
    57                  ]
    58 
    59              ]
    60 
    61              '1' => 'news'
    62 
    63          ],
    64 
    65          'fileName' => [
    66 
    67              'index' => [
    68 
    69                  'ajax.js' => [
    70 
    71                      'keyValues' => [
    72                          'type' => 1019
    73                      ]
    74 
    75                  ]
    76 
    77              ]
    78 
    79          ]
    80 
    81     ]
    82 
    83 ];

**Note:** To speed things up, the Language Service makes use of the TYPO3 Caching Framework when the configuration 
is computed. If you did integrate a custom RealUrl configuration and altered it afterwards, you have to clear TYPO3 
caches to force Crystalis to recalculate it's configuration.