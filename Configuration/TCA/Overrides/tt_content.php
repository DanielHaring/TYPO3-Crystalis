<?php

\defined('TYPO3_MODE') or die('Access denied.');

$_EXTCONF = \unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['crystalis']);
$_EXTKEY = 'crystalis';





    // Add TCA columns
$extraContentColumns = [
    'section_frame' => [
        'exclude' => \TRUE,
        'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:section_frame',
        'config' => [
            'type' => 'select',
            'items' => [
                [
                    'LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:tt_content.sectionFrame0',
                    '0'
                ]
            ],
            'default' => '0'
        ]
    ],
    'spaceAfter' => [
        'exclude' => \TRUE,
        'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:spaceAfter',
        'config' => [
            'type' => 'input',
            'size' => '5',
            'max' => '5',
            'eval' => 'int',
            'range' => [
                'lower' => '0'
            ],
            'default' => 0
        ]
    ],
    'spaceBefore' => [
        'exclude' => \TRUE,
        'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:spaceBefore',
        'config' => [
            'type' => 'input',
            'size' => '5',
            'max' => '5',
            'eval' => 'int',
            'range' => [
                'lower' => '0'
            ],
            'default' => 0
        ]
    ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
        'tt_content', 
        $extraContentColumns);





    // Additional content elements
$GLOBALS['TCA']['tt_content']['ctrl']['typeicons'] = \array_merge(
        $GLOBALS['TCA']['tt_content']['ctrl']['typeicons'], 
        [
            'textpic' => 'tt_content_textpic.gif',
            'image' => 'tt_content_image.gif',
            'text' => 'tt_content.gif'
        ]);

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes'] = \array_merge(
        $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes'], 
        [
            'textpic' => 'mimetypes-x-content-text-picture',
            'image' => 'mimetypes-x-content-image',
            'text' => 'mimetypes-x-content-text'
        ]);

\array_splice(
        $GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'], 
        2, 
        0, 
        [
            [
                'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:CType.I.1',
                'text',
                'content-text'
            ],
            [
                'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:CType.I.2',
                'textpic',
                'content-textpic'
            ],
            [
                'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:CType.I.3',
                'image',
                'content-image'
            ]
        ]);





    // Alter palettes
$GLOBALS['TCA']['tt_content']['palettes'] = \array_replace(
        $GLOBALS['TCA']['tt_content']['palettes'], 
        [
            'header' => [
                'showitem' => '
                    header;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_formlabel,
                    --linebreak--,
                    header_layout;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_layout_formlabel,
                    date;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:date_formlabel,
                    --linebreak--,
                    header_link;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_link_formlabel
                ',
                'canNotCollapse' => 1
            ],
            'headers' => [
                'showitem' => '
                    header;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_formlabel,
                    --linebreak--,
                    header_layout;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_layout_formlabel,
                    date;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:date_formlabel,
                    --linebreak--,
                    header_link;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_link_formlabel,
                    --linebreak--,
                    subheader;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:subheader_formlabel
                ',
                'canNotCollapse' => 1
            ],
            'image_settings' => [
                'showitem' => '
                    imagewidth;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:imagewidth_formlabel,
                    imageheight;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:imageheight_formlabel
                ',
                'canNotCollapse' => 1
            ],
            'imageblock' => [
                'showitem' => '
                    imageorient;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:imageorient_formlabel,
                ',
                'canNotCollapse' => 1
            ],
            'visibility' => [
                'showitem' => '
                    hidden;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:hidden_formlabel,
                    sectionIndex;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:sectionIndex_formlabel,
                    linkToTop;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:linkToTop_formlabel
                ',
                'canNotCollapse' => 1
            ],
            'frames' => [
                'showitem' => '
                    layout;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:layout_formlabel,
                    spaceBefore;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:spaceBefore_formlabel,
                    spaceAfter;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:spaceAfter_formlabel,
                    section_frame;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:section_frame_formlabel
                ',
                'canNotCollapse' => 1
            ]
        ]);





    // Field arrangement for header content element
$GLOBALS['TCA']['tt_content']['types']['header']['showitem'] = '
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers;headers,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
';

    // Field arrangement for text content element
$GLOBALS['TCA']['tt_content']['types']['text']['showitem'] = '
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.header;header,
                bodytext;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext_formlabel,
                rte_enabled;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:rte_enabled_formlabel,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
';

if(!\is_array($GLOBALS['TCA']['tt_content']['types']['text']['columnsOverrides'])) {
    
    $GLOBALS['TCA']['tt_content']['types']['text']['columnsOverrides'] = [];
    
}

if(!\is_array($GLOBALS['TCA']['tt_content']['types']['text']['columnsOverrides']['bodytext'])) {
    
    $GLOBALS['TCA']['tt_content']['types']['text']['columnsOverrides']['bodytext'] = [];
    
}

if(!empty($GLOBALS['TCA']['tt_content']['columns']['bodytext']['defaultExtras'])) {
    
    $bodytextDefaultBaseExtras = $GLOBALS['TCA']['tt_content']['columns']['bodytext']['defaultExtras'] . ':';
    
}

$GLOBALS['TCA']['tt_content']['types']['text']['columnsOverrides']['bodytext']['defaultExtras'] = 
        $bodytextDefaultBaseExtras . 'richtext:rte_transform[flag=rte_enabled|mode=ts_css]';

    // Field arrangement for textpic content element
$GLOBALS['TCA']['tt_content']['types']['textpic']['showitem'] = '
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.header;header,
                bodytext;Text,
                rte_enabled;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:rte_enabled_formlabel,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.images,
                image,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.imagelinks;imagelinks,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.image_settings;image_settings,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.imageblock;imageblock,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
';

if(!\is_array($GLOBALS['TCA']['tt_content']['types']['textpic']['columnsOverrides'])) {
    
    $GLOBALS['TCA']['tt_content']['types']['textpic']['columnsOverrides'] = [];
    
}

if(!\is_array($GLOBALS['TCA']['tt_content']['types']['textpic']['columnsOverrides']['bodytext'])) {
    
    $GLOBALS['TCA']['tt_content']['types']['textpic']['columnsOverrides']['bodytext'] = [];
    
}

$GLOBALS['TCA']['tt_content']['types']['textpic']['columnsOverrides']['bodytext']['defaultExtras'] = 
        $bodytextDefaultBaseExtras . 'richtext:rte_transform[flag=rte_enabled|mode=ts_css]';

    // Field arrangement for image content element
$GLOBALS['TCA']['tt_content']['types']['image']['showitem'] = '
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.header;header,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.images,
                image,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.imagelinks;imagelinks,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.image_settings;image_settings,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.imageblock;imageblock,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
';

    // Field arrangement for uploads content element
$GLOBALS['TCA']['tt_content']['types']['uploads']['showitem'] = '
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.header;header,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:media;uploads,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.uploads_layout;uploadslayout,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
';

    // Field arrangement for menu content element
$GLOBALS['TCA']['tt_content']['types']['menu']['showitem'] = '
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.header;header,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.menu;menu,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
';

    // Field arrangement for shortcut content element
$GLOBALS['TCA']['tt_content']['types']['shortcut']['showitem'] = '
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                header;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header.ALT.shortcut_formlabel,
                records;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:records_formlabel,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
';

    // Field arrangement for list content element
$GLOBALS['TCA']['tt_content']['types']['list']['showitem'] = '
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.header;header,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin,
                list_type;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:list_type_formlabel,
                select_key;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:select_key_formlabel,
                pages;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:pages.ALT.list_formlabel,
                recursive,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
';





    // Register HTML5 Video content element
if(
        (\in_array($_EXTCONF['doctype'], ['html5']) && !$_EXTCONF['disableHtml5Video']) 
        || !$_EXTCONF) {
    
    \array_splice(
            $GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'], 
            13, 
            0, 
            [
                [
                    'LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:tt_content.CType_Video',
                    'video',
                    'EXT:crystalis/Resources/Public/Icons/html5.png'
                ]
            ]);
    
    $GLOBALS['TCA']['tt_content']['types']['video'] = [
        'showitem' => '
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.header;header,
            --div--;LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:div.video,pi_flexform;;,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended'
    ];
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
            '*',
            'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForm/Content_Video.xml',
            'video');
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'tt_content.pi_flexform..video',
            'EXT:crystalis/Resources/Private/Language/locallang_csh_flexform_video.xlf');
    
    $GLOBALS['TCA']['tt_content']['ctrl']['typeicons']['video'] = 
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/html5.png';
    
    $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['video'] = 'extensions-' . $_EXTKEY . '-video';
    
}