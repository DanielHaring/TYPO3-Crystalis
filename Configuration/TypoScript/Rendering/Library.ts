# The volatile styles object
styles{

    # Returns the backend layout of the current page
    backendLayout{

        data = PAGE:backend_layout

        ifEmpty{

            data = LEVELFIELD:-1,backend_layout_next_level,slide

        }

    }

}


# TypoScript library object
lib{


    # Rendering of non-HTML content
    parseFunc{

        allowTags = a, abbr, acronym, address, article, aside, b, bdo, big, blockquote, br, caption, center, cite, code, col, colgroup, dd, del, dfn, dl, div, dt, em, font, footer, header, h1, h2, h3, h4, h5, h6, hr, i, img, ins, kbd, label, li, link, meta, nav, ol, p, pre, q, samp, sdfield, section, small, span, strike, strong, style, sub, sup, table, thead, tbody, tfoot, td, th, tr, title, tt, u, ul, var
        denyTags = *
        sword = <span class="sword">|</span>
        constants = 1

        makelinks = 1
        makelinks{

            http{
                keep = path
            }

            mailto{
                keep = path
            }

        }

        tags{

            link = TEXT
            link{

                current = 1

                typolink{

                    parameter{
                        data = parameters:allParams
                    }

                }

                parseFunc{
                    constants = 1
                }

            }

        }

        nonTypoTagStdWrap{

            HTMLparser = 1
            HTMLparser{

                keepNonMatchedTags = 1
                htmlSpecialChars = 2

            }

        }

    }


    # Rendering of RTE content (HTML based)
    parseFunc_RTE < lib.parseFunc
    parseFunc_RTE{

        externalBlocks = article, aside, blockquote, div, dd, dl, footer, header, nav, ol, section, table, ul
        externalBlocks{

            blockquote{

                stripNL = 1

                callRecursive = 1
                callRecursive{

                    tagStdWrap{

                        HTMLparser = 1
                        HTMLparser{

                            tags{

                                blockquote{
                                    overrideAttribs = style="margin-bottom:0;margin-top:0;"
                                }

                            }

                        }

                    }

                }

            }

            ol{

                stripNL = 1

                stdWrap{
                    parseFunc = < lib.parseFunc
                }

            }

            ul{

                stripNL = 1

                stdWrap{
                    parseFunc = < lib.parseFunc
                }

            }

            table{

                stripNL = 1

                stdWrap{

                    HTMLparser = 1
                    HTMLparser{
                        keepNonMatchedTags = 1
                    }

                }

                HTMLtableCells = 1
                HTMLtableCells{

                    addChr10BetweenParagraphs = 1

                    default{

                        stdWrap{

                            parseFunc =< lib.parseFunc_RTE
                            parseFunc{

                                nonTypoTagStdWrap{

                                    encapsLines{
                                        nonWrappedTag =
                                    }

                                }

                            }

                        }

                    }

                }

            }

            div{
                stripNL = 1
                callRecursive = 1
            }

            article < .div
            aside < .div
            footer < .div
            header < .div
            nav < .div
            section < .div
            dl < .div
            dd < .div

        }

        nonTypoTagStdWrap{

            encapsLines{

                encapsTagList = p,pre,h1,h2,h3,h4,h5,h6,h4,dt

                remapTag{
                    DIV = P
                }

                nonWrappedTag = P

                innerStdWrap_all{
                    ifBlank = &nbsp;
                }

            }

            HTMLparser = 1
            HTMLparser{

                keepNonMatchedTags = 1
                htmlSpecialChars = 2

            }

        }

    }


    # Default content header
    stdheader = COA
    stdheader{

        # Main title
        10 = CASE
        10{

            setCurrent{

                field = header
                htmlSpecialChars = 1

                typolink{

                    parameter{
                        field = header_link
                    }

                }

            }

            key{
                field = header_layout
            }

            default = TEXT
            default{
                current = 1
                dataWrap = <h2>|</h2>
            }

            1 < .default
            1{
                dataWrap = <h3>|</h3>
            }

            2 < .default
            2{
                dataWrap = <h4>|</h4>
            }

            3 < .default
            3{
                dataWrap = <h5>|</h5>
            }

            4 < .default
            4{
                dataWrap = <h6>|</h6>
            }

            # Post processing
            stdWrap{

                # Date
                append = CASE
                append{

                    key{
                        data = TSFE:config|config|doctype
                    }

                    default = TEXT
                    default{

                        fieldRequired = date
                        field = date
                        strftime = %d.%m.%Y
                        innerWrap = <small class="date">|</small>
                        outerWrap = <p>|</p>
                        prefixComment = 2 | Header date:

                    }

                    html5 = TEXT
                    html5{

                        fieldRequired = date

                        setCurrent{
                            field = date
                        }

                        current = 1
                        strftime = %d.%m.%Y

                        innerWrap = |</time>
                        innerWrap{

                            prepend = TEXT
                            prepend{

                                current = 1
                                strftime = %d-%m-%Y
                                wrap = <time datetime="|">

                            }

                        }

                        outerWrap = <p>|</p>

                    }

                }

            }

        }

        # Subtitle
        20 = CASE
        20{

            setCurrent{

                field = subheader
                htmlSpecialChars = 1

            }

            key{
                field = header_layout
            }

            default = TEXT
            default{

                current = 1
                dataWrap = <h3>|</h3>

            }

            1 < .default
            1{
                dataWrap = <h4>|</h4>
            }

            2 < .default
            2{
                dataWrap = <h5>|</h5>
            }

            3 < .default
            3{
                dataWrap = <h6>|</h6>
            }

            4 < .default
            4{
                dataWrap = <p><strong>|</strong></p>
            }

            stdWrap{
                fieldRequired = subheader
            }

        }

        # Post processing
        stdWrap{

            fieldRequired = header

            if{

                equals{
                    field = header_layout
                }

                value = 100
                negate = 1

            }

            editIcons = tt_content : header, [header_layout], [header_link|date]
            editIcons{

                beforeLastTag = 1

                iconTitle{

                    data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:eIcon.header

                }

            }

            prefixComment = 2 | Header:

        }

    }


}