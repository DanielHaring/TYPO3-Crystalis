# Rendering of content element "search"
tt_content.search = COA
tt_content.search{

    10 = < lib.stdheader

    20 = SEARCHRESULT
    20{

        allowedCols = pages.title-subtitle-keywords-description:tt_content.header-bodytext-imagecaption:tt_address.name-title-address-email-company-city-country:tt_links.title-note-note2-url:tt_boad.subject-message-author-email:tt_calendar.title-note:tt_products.title-note-itemnumber

        languageField{

            tt_content = sys_language_uid

        }

        renderObj = COA
        renderObj{

            10 = TEXT
            10{

                field = pages_title
                htmlSpecialChars = 1

                typolink{

                    parameter{
                        field = uid
                    }

                    additionalParams{

                        data = REGISTER:SWORD_PARAMS
                        required = 1
                        wrap = &no_cache=1

                    }

                }

                wrap = <h3>|</h3>

            }

            20 = TEXT
            20{

                field = tt_content_bodytext
                stripHtml = 1
                htmlSpecialChars = 1

                stdWrap{

                    crop = 150 | …
                    wrap = <p>|</p>

                }

            }

        }

        layout = COA
        layout{

            10 = TEXT
            10{

                data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:form.search_resultRange
                wrap = <span class="range">|</span>

            }

            20 = TEXT
            20{

                value = ###PREV### ###NEXT###
                wrap = <span class="browse">|</span>

            }

            wrap = <p>|</p> ###RESULT###

        }

        noResultObj = TEXT
        noResultObj{

            data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:form.search_emptySearch
            wrap = <h3>|</h3>

        }

        next = TEXT
        next{
            data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:form.search_resultNext
        }

        prev = TEXT
        prev{
            data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:form.search_resultPrev
        }

        range = 20

        stdWrap{

            prefixComment = 2 | Search result:

        }

    }

    30 = < tt_content.mailform.20
    30{

        goodMess =
        redirect >
        recipient >
        data >
        formName = searchform

        dataArray{

            10{

                label{
                    data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:form.search_searchWord
                }

                type = sword=input

            }

            20{

                type = scols=hidden
                value = pages.title-subtitle-keywords-description:tt_content.header-bodytext-imagecaption

            }

            30{

                type = stype=hidden
                value = L0

            }

            40{

                type = submit=submit

                value{
                    data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:form.search_submit
                }

            }

        }

        type{

            field = pages
            listNum = 0

        }

        locationData = HTTP_POST_VARS
        no_cache = 1

        stdWrap{

            innerWrap = |</fieldset>
            innerWrap{

                prepend = TEXT
                prepend{

                    data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:form.search_legend
                    required = 1
                    wrap = <legend>|</legend>

                }

                outerWrap = <fieldset>|

            }

            editIcons{

                iconTitle{

                    data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:eIcon.search

                }

            }

            prefixComment = 2 | Search form inserted:

        }

    }

}