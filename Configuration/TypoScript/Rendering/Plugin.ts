# Rendering of content element "list"
tt_content.list = COA
tt_content.list{

    10 = < lib.stdheader

    20 = CASE
    20{

        key{
            field = list_type
        }

        stdWrap{

            editIcons = tt_content:list_type,layout,select_key,pages[recursive]
            editIcons{

                iconTitle{

                    data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:eIcon.plugin

                }

            }

            prefixComment = 2 | Plugin inserted:

        }

    }

}