# Default page configuration
page = PAGE
page{

    typeNum = 0

    config{

        simulateStaticDocuments = 0
        removeDefaultJS = external
        disablePrefixComment = 1
        linkVars = L
        inlineStyle2TempFile = 1
        spamProtectEmailAddresses = ascii
        baseURL = {$server.scheme}://{$server.host}{$server.port}{$server.path}
        noPageTitle = 2
        tx_realurl_enable = 1

    }

    meta{

        description{
            ifEmpty{
                field = description
            }
        }

        keywords{
            ifEmpty{
                field = keywords
            }
        }

        robots = index,follow
        robots{

            override = noindex,follow
            override{

                if{

                    isTrue{
                        data = PAGE:no_search
                    }

                }

            }

        }

        revisit-after = 7 days

    }

    headerData{

        # Page Title
        20 = COA
        20{

            # Current page
            10 = TEXT
            10{

                if{

                    isTrue{
                        data = LEVEL:1
                    }

                }

                field = title
                trim = 1
                htmlSpecialChars = 1
                wrap = |:

                override{
                    field = subtitle
                }

                append = TEXT
                append{
                    char = 32
                }

            }

            # Website title
            20 = TEXT
            20{

                data = LEVELFIELD:0,nav_title
                trim = 1
                htmlSpecialChars = 1

                append = TEXT
                append{

                    if{

                        isFalse{
                            data = LEVEL:1
                        }

                    }

                    char = 32

                    append = TEXT
                    append{
                        value = -
                    }

                }

            }

            # Website claim
            30 = TEXT
            30{

                if{

                    isFalse{
                        data = LEVEL:1
                    }

                }

                data = LEVELFIELD:0,subtitle
                trim = 1
                htmlSpecialChars = 1

                prepend = TEXT
                prepend{
                    char = 32
                }

            }

            stdWrap{

                wrap = <title>|</title>

            }

        }

    }

    stdWrap{

        HTMLparser = 1
        HTMLparser{

            keepNonMatchedTags = 1

            tags{

                a{

                    fixAttrib{

                        target{
                            unset = 1
                        }

                    }

                }

                table{

                    fixAttrib{

                        summary{
                            unset = 1
                        }

                        height{
                            unset = 1
                        }

                        width{
                            unset = 1
                        }

                    }

                }

            }

        }

    }

}