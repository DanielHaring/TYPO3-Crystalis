<?php

\defined('TYPO3_MODE') or die('Access denied.');

$_EXTCONF = \unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['crystalis']);
$_EXTKEY = 'crystalis';





    // Provice render templates
switch($_EXTCONF['doctype']) {
    
    case 'xhtml_strict':
        
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
                $_EXTKEY, 
                'Configuration/TypoScript/XHtmlStrict', 
                'Frontend Rendering');
        
        break;
    
    case 'html5': // fallthrough
    default:
        
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
                $_EXTKEY, 
                'Configuration/TypoScript/Html5', 
                'Frontend Rendering');
        
        break;
    
}





    // Add TCA columns
$extraContentColumns = [
    'section_frame' => [
        'exclude' => \TRUE,
        'label' => 'LLL:EXT:cms/locallang_ttc.xlf:section_frame',
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
        'label' => 'LLL:EXT:cms/locallang_ttc.xlf:spaceAfter',
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
        'label' => 'LLL:EXT:cms/locallang_ttc.xlf:spaceBefore',
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
                'LLL:EXT:cms/locallang_ttc.xlf:CType.I.1',
                'text',
                'i/tt_content.gif'
            ],
            [
                'LLL:EXT:cms/locallang_ttc.xlf:CType.I.2',
                'textpic',
                'i/tt_content_textpic.gif'
            ],
            [
                'LLL:EXT:cms/locallang_ttc.xlf:CType.I.3',
                'image',
                'i/tt_content_image.gif'
            ]
        ]);





    // Alter palettes
$GLOBALS['TCA']['tt_content']['palettes'] = \array_replace(
        $GLOBALS['TCA']['tt_content']['palettes'], 
        [
            'header' => [
                'showitem' => '
                    header;LLL:EXT:cms/locallang_ttc.xlf:header_formlabel,
                    --linebreak--,
                    header_layout;LLL:EXT:cms/locallang_ttc.xlf:header_layout_formlabel,
                    date;LLL:EXT:cms/locallang_ttc.xlf:date_formlabel,
                    --linebreak--,
                    header_link;LLL:EXT:cms/locallang_ttc.xlf:header_link_formlabel
                ',
                'canNotCollapse' => 1
            ],
            'headers' => [
                'showitem' => '
                    header;LLL:EXT:cms/locallang_ttc.xlf:header_formlabel,
                    --linebreak--,
                    header_layout;LLL:EXT:cms/locallang_ttc.xlf:header_layout_formlabel,
                    date;LLL:EXT:cms/locallang_ttc.xlf:date_formlabel,
                    --linebreak--,
                    header_link;LLL:EXT:cms/locallang_ttc.xlf:header_link_formlabel,
                    --linebreak--,
                    subheader;LLL:EXT:cms/locallang_ttc.xlf:subheader_formlabel
                ',
                'canNotCollapse' => 1
            ],
            'image_settings' => [
                'showitem' => '
                    imagewidth;LLL:EXT:cms/locallang_ttc.xlf:imagewidth_formlabel,
                    imageheight;LLL:EXT:cms/locallang_ttc.xlf:imageheight_formlabel
                ',
                'canNotCollapse' => 1
            ],
            'imageblock' => [
                'showitem' => '
                    imageorient;LLL:EXT:cms/locallang_ttc.xlf:imageorient_formlabel,
                ',
                'canNotCollapse' => 1
            ],
            'visibility' => [
                'showitem' => '
                    hidden;LLL:EXT:cms/locallang_ttc.xlf:hidden_formlabel,
                    sectionIndex;LLL:EXT:cms/locallang_ttc.xlf:sectionIndex_formlabel,
                    linkToTop;LLL:EXT:cms/locallang_ttc.xlf:linkToTop_formlabel
                ',
                'canNotCollapse' => 1
            ],
            'frames' => [
                'showitem' => '
                    layout;LLL:EXT:cms/locallang_ttc.xlf:layout_formlabel,
                    spaceBefore;LLL:EXT:cms/locallang_ttc.xlf:spaceBefore_formlabel,
                    spaceAfter;LLL:EXT:cms/locallang_ttc.xlf:spaceAfter_formlabel,
                    section_frame;LLL:EXT:cms/locallang_ttc.xlf:section_frame_formlabel
                ',
                'canNotCollapse' => 1
            ]
        ]);





    // Field arrangement for header content element
$GLOBALS['TCA']['tt_content']['types']['header']['showitem'] = '
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.headers;headers,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.frames;frames,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.visibility;visibility,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended
';

    // Field arrangement for text content element
$GLOBALS['TCA']['tt_content']['types']['text']['showitem'] = '
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.header;header,
                bodytext;LLL:EXT:cms/locallang_ttc.xlf:bodytext_formlabel;;richtext:rte_transform[flag=rte_enabled|mode=ts_css],
                rte_enabled;LLL:EXT:cms/locallang_ttc.xlf:rte_enabled_formlabel,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.frames;frames,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.visibility;visibility,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended
';

    // Field arrangement for textpic content element
$GLOBALS['TCA']['tt_content']['types']['textpic']['showitem'] = '
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.header;header,
                bodytext;Text;;richtext:rte_transform[flag=rte_enabled|mode=ts_css],
                rte_enabled;LLL:EXT:cms/locallang_ttc.xlf:rte_enabled_formlabel,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.images,
                image,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.imagelinks;imagelinks,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.frames;frames,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.image_settings;image_settings,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.imageblock;imageblock,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.visibility;visibility,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended
';

    // Field arrangement for image content element
$GLOBALS['TCA']['tt_content']['types']['image']['showitem'] = '
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.header;header,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.images,
                image,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.imagelinks;imagelinks,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.frames;frames,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.image_settings;image_settings,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.imageblock;imageblock,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.visibility;visibility,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended
';

    // Field arrangement for uploads content element
$GLOBALS['TCA']['tt_content']['types']['uploads']['showitem'] = '
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.header;header,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:media;uploads,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.frames;frames,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.uploads_layout;uploadslayout,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.visibility;visibility,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended
';

    // Field arrangement for menu content element
$GLOBALS['TCA']['tt_content']['types']['menu']['showitem'] = '
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.header;header,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.menu;menu,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.frames;frames,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.visibility;visibility,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended
';

    // Field arrangement for shortcut content element
$GLOBALS['TCA']['tt_content']['types']['shortcut']['showitem'] = '
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
                header;LLL:EXT:cms/locallang_ttc.xlf:header.ALT.shortcut_formlabel,
                records;LLL:EXT:cms/locallang_ttc.xlf:records_formlabel,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.frames;frames,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.visibility;visibility,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended
';

    // Field arrangement for list content element
$GLOBALS['TCA']['tt_content']['types']['list']['showitem'] = '
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.header;header,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.plugin,
                list_type;LLL:EXT:cms/locallang_ttc.xlf:list_type_formlabel,
                select_key;LLL:EXT:cms/locallang_ttc.xlf:select_key_formlabel,
                pages;LLL:EXT:cms/locallang_ttc.xlf:pages.ALT.list_formlabel,
                recursive,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.frames;frames,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.visibility;visibility,
                --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
        --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended
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
            --palette--;LLL:EXT:cms/locallang_ttc.xml:palette.general;general,
            --palette--;LLL:EXT:cms/locallang_ttc.xml:palette.header;header,
            --div--;LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:div.video,pi_flexform;;,
            --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.appearance,
            --palette--;LLL:EXT:cms/locallang_ttc.xml:palette.frames;frames,
            --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,
            --palette--;LLL:EXT:cms/locallang_ttc.xml:palette.visibility;visibility,
            --palette--;LLL:EXT:cms/locallang_ttc.xml:palette.access;access,
            --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.extended'
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