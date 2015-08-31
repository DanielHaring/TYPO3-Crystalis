# Rich Text Editor configuration
RTE{


    default{

        useCSS = 0
        contentCSS = EXT:crystalis/Resources/Public/Styles/rte.min.css
        hideButtons := addToList(blockstyle,toggleborders)
        showButtons := addToList(small)

        buttons{

            link{

                targetSelector.disabled = 1
                popupSelector.disabled = 1

            }

            formatblock{

                removeItems = h1,blockquote,div
                orderItems = p,h2,h3,h4,h5,h6

                items{

                    h2.label = LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:tt_content.headerLabel0
                    h3.label = LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:tt_content.headerLabel1
                    h4.label = LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:tt_content.headerLabel2
                    h5.label = LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:tt_content.headerLabel3
                    h6.label = LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:tt_content.headerLabel4

                }

            }

        }

        proc{

            overrideMode = css_transform
            allowedClasses := addToList(tel)

            exitHTMLparser_db = 1
            exitHTMLparser_db{

                tags{

                    b{
                        remap = strong
                    }

                    i{
                        remap = em
                    }

                }

            }


        }

        classes{

            Character := addToList(tel)

        }

    }


    classes{

        tel{

            name = LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:rte.charClassTel

        }

    }


    classesAnchor{

        mail.type >
        download.type >
        internalLink.type >
        internalLinkInNewWindow.type >
        externalLink.type >
        externalLinkInNewWindow.type >

    }


}