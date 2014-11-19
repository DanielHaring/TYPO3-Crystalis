# Rendering of content element "shortcut"
tt_content.shortcut = COA
tt_content.shortcut{

    20 = RECORDS
    20{

        source{
            field = records
        }

        tables = tt_content,tt_address,tt_links,tt_guest,tt_board,tt_calendar,tt_products,tt_news,tt_rating,tt_poll

        stdWrap{

            editIcons = tt_content:records
            editIcons{

                iconTitle{

                    data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:eIcon.recordList

                }

            }

            prefixComment = 2 | Inclusion of other records (by reference):

        }

    }

}