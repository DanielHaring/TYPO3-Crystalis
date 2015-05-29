# Backend forms
TCEFORM{

    tt_content{

        layout{
            removeItems = 1,2,3
        }

        header_layout{

            removeItems = 5

            altLabels{

                0 = LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:tt_content.headerLabel0
                1 = LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:tt_content.headerLabel1
                2 = LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:tt_content.headerLabel2
                3 = LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:tt_content.headerLabel3
                4 = LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:tt_content.headerLabel4

            }

        }

        CType{

            removeItems := addToList(swfobject, qtobject, multimedia, bullets, table, html, div, mailform)

        }

        header_position{
            disabled = 1
        }

        section_frame{

            removeItems = 1,5,6,10,11,12,20,21

            altLabels{

                0 = LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:tt_content.sectionFrame0

            }

        }

        menu_type{
            removeItems = 3,4,5,6,7
        }

        imagecols{
            disabled = 1
        }

        imageborder{
            disabled = 1
        }

        image_frames{
            disabled = 1
        }

        image_noRows{
            disabled = 1
        }

        table_bgColor{
            disabled = 1
        }

        table_border{
            disabled = 1
        }

        table_cellspacing{
            disabled = 1
        }

        table_cellpadding{
            disabled = 1
        }

        text_properties{
            disabled = 1
        }

        text_align{
            disabled = 1
        }

        text_color{
            disabled = 1
        }

        text_face{
            disabled = 1
        }

        text_size{
            disabled = 1
        }

    }

    pages{

        layout{
            removeItems = 1,2,3
        }

    }

}



# Default values
TCAdefaults{

    tt_content{

        section_frame = 0

    }

    pages{

        l18n_cfg = 2

    }

    fe_users{

        tx_extbase_type = Tx_Extbase_Domain_Model_FrontendUser

    }

    fe_groups{

        tx_extbase_type = Tx_Extbase_Domain_Model_FrontendUserGroup

    }

}



# Behaviour
TCEMAIN{

    table{

        pages{

            disablePrependAtCopy = 1

        }

    }

}