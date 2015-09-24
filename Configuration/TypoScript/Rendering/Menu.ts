# Rendering of content element "menu"
tt_content.menu = COA
tt_content.menu{

    10 = < lib.stdheader

    20 = CASE
    20{

        key{
            field = menu_type
        }

        # Custom selection of pages
        default = HMENU
        default{

            special = list
            special{

                value{
                    field = pages
                }

            }

            1 = TMENU
            1{

                NO = 1
                NO{

                    wrapItemAndSub = <li>|</li>

                    ATagTitle{
                        field = abstract // subtitle // nav_title
                    }

                    stdWrap{
                        htmlSpecialChars = 1
                    }

                }

            }

            stdWrap{

                required = 1

                prepend = CONTENT
                prepend{

                    table = tt_content

                    select{

                        pidInList = this
                        orderBy = sorting

                        andWhere{
                            dataWrap = sorting>{FIELD:sorting}
                        }

                        languageField = sys_language_uid
                        max = 1

                    }

                    renderObj = TEXT
                    renderObj{

                        required = 1
                        data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:anchors.bypassNavigation
                        trim = 1
                        htmlSpecialChars = 1

                        override{
                            field = accessibility_bypass_text
                        }

                        typolink{

                            parameter{
                                field = pid
                            }

                            section{
                                field = uid
                            }

                        }

                        wrap = <li class="bypass">|</li>

                    }

                    stdWrap{

                        if{

                            isTrue{
                                field = accessibility_bypass
                            }

                        }

                    }

                }

                outerWrap = <ul>|</ul>

            }

        }

        # Subpages of selected pages
        1 < .default
        1{

            special = directory

        }

        # Sitemap
        2 = HMENU
        2{

            1 = TMENU
            1{

                expAll = 1
                wrap = <ul>|</ul>

                NO = 1
                NO{

                    wrapItemAndSub = <li>|</li>

                    ATagTitle{
                        field = abstract // subtitle // nav_title
                    }

                    stdWrap{
                        htmlSpecialChars = 1
                    }

                }

            }

            2 < .1
            3 < .1
            4 < .1
            5 < .1
            6 < .1
            7 < .1

            stdWrap < tt_content.menu.20.default.stdWrap

        }

        # Section index
        3 < .default
        3{

            special{

                value{

                    override{

                        data = PAGE:uid

                        if{

                            isFalse{
                                field = pages
                            }

                        }

                    }

                }

            }

            1 = TMENU
            1{

                sectionIndex = 1
                sectionIndex{
                    type = header
                }

                NO{

                    wrapItemAndSub = <li class="section">|</li>

                }

            }

        }

        # Subpages of selected pages (with abstract)
        4 < .1
        4{

            1{

                NO{

                    wrapItemAndSub >
                    linkWrap = <dt>|</dt>

                    after{

                        data = FIELD:abstract // FIELD:description // FIELD:subtitle
                        htmlSpecialChars = 1
                        ifBlank = &nbsp;
                        wrap = <dd>|</dd>

                    }

                    ATagTitle{
                        field = description // subtitle // nav_title
                    }

                }

            }

        }

        # Recently updated pages
        5 < .default
        5{

            special = updated
            special{
                maxAge = 3600*24*7
                excludeNoSearchPages = 1
            }

        }

        # Related pages
        6 < .default
        6{

            special = keywords
            special{
                excludeNoSearchPages = 1
            }

        }

        # Subpages of selected pages (with sections)
        7 < .1
        7{

            1{
                expAll = 1
            }

            2 < .1
            2{

                sectionIndex = 1
                sectionIndex{
                    type = header
                }

                wrap = <ul>|</ul>

                NO{
                    wrapItemAndSub = <li class="section">|</li>
                }

            }

        }

        stdWrap{

            innerWrap = |</map>
            innerWrap{

                if{

                    isTrue{
                        field = accessibility_title
                    }

                }

                prepend = TEXT
                prepend{

                    field = accessibility_title
                    htmlSpecialChars = 1

                    dataWrap = <map id="map{FIELD:uid}" title="|">
                    dataWrap{

                        override = <map name="map{FIELD:uid}" title="|">
                        override{

                            if{

                                isFalse{
                                    data = TSFE:xhtmlDoctype
                                }

                            }

                        }

                    }

                }

            }

            editIcons = tt_content:menu_type,pages
            editIcons{

                iconTitle{

                    data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:eIcon.menuSitemap

                }

            }

            prefixComment = 2 | Menu/Sitemap element:

        }

    }

}