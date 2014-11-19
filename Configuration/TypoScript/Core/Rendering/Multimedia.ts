# Rendering of content element "multimedia"
tt_content.multimedia = COA
tt_content.multimedia{

    10 = < lib.stdheader

    20 = MULTIMEDIA
    20{

        file{

            field = multimedia
            wrap = uploads/media/
            listNum = 0

        }

        params{
            field = bodytext
        }

        stdWrap{

            editIcons = tt_content:multimedia,bodytext
            editIcons{

                iconTitle{

                    data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:eIcon.multimedia

                }

            }

            prefixComment = 2 | Multimedia element:

        }

    }

}