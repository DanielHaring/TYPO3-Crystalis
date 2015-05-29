# Content Rendering
tt_content >
tt_content = CASE
tt_content{

    key{
        field = CType
    }

    default = TEXT
    default{

        field = CType
        wrap = <p style="background-color:yellow;"><b>ERROR:</b> Content Element type "|" has no rendering definition!</p>
        prefixComment = 2 | Unknown element message:

    }

    # Post Processing
    stdWrap{

        # Anchors
        innerWrap = |
        innerWrap{

            # To Top anchor
            append = TEXT
            append{

                fieldRequired = linkToTop
                data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:anchors.toTop

                innerWrap = |</a>
                innerWrap{

                    prepend = TEXT
                    prepend{

                        typolink{

                            parameter{
                                data = TSFE:id
                            }
                            returnLast = url

                        }

                        wrap = <a href="|#">

                    }

                }

                wrap = <p>|</p>

            }

        }

        # Wrapping
        innerWrap2{

            cObject = COA
            cObject{

                # Space before
                10 = TEXT
                10{

                    fieldRequired = spaceBefore
                    field = spaceBefore

                    innerWrap = <br style="line-height: |px;">
                    innerWrap{

                        override = <br style="line-height: |px;" />
                        override{

                            if{
                                isInList{
                                    data = TSFE:config|config|doctype
                                }
                                value = xhtml,xhtml_strict
                            }

                        }

                    }

                }

                # Section Frame
                20 = CASE
                20{

                    key{
                        field = section_frame
                    }

                    default = TEXT
                    default{
                        value = |
                    }

                }

                # Space after
                30 < .10
                30{

                    fieldRequired = spaceAfter
                    field = spaceAfter

                }

            }

        }

        editPanel = 1
        editPanel{

            allow = move,new,edit,hide,delete
            line = 5
            label = %s
            onlyCurrentPid = 1
            previewBorder = 4

            edit{
                displayRecord = 1
            }

        }

        prefixComment = 1 | CONTENT ELEMENT, uid:{field:uid}/{field:CType}

    }

}

# Content Elements
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/Rendering/Header.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/Rendering/Text.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/Rendering/Image.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/Rendering/TextPic.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/Rendering/Bullets.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/Rendering/Table.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/Rendering/Uploads.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/Rendering/Multimedia.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/Rendering/ShockwaveFlash.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/Rendering/QuickTime.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/Rendering/Media.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/Rendering/Video.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/Rendering/Menu.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/Rendering/Shortcut.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/Rendering/Plugin.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/Rendering/Divider.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:crystalis/Configuration/TypoScript/Core/Rendering/RawHtml.ts">