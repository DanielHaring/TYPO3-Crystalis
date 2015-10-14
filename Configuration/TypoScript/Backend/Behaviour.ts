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

            removeItems := addToList(swfobject, qtobject, multimedia, bullets, table, html, div)

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

        imageorient{

            types{

                image{

                    removeItems := addToList(8,9,10,17,18,25,26)

                }

            }

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