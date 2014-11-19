# Rendering of content element "text"
tt_content.text = COA
tt_content.text{

    # Header
    10 = < lib.stdheader

    # Bodytext
    20 = TEXT
    20{

        field = bodytext
        required = 1
        parseFunc = < lib.parseFunc_RTE

        editIcons = tt_content:bodytext,rte_enabled
        editIcons{

            beforeLastTag = 1

            iconTitle{

                data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:eIcon.bodytext

            }

        }

        prefixComment = 2 | Text:

    }

}