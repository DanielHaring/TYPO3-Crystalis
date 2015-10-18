# Rich Text Editor configuration
RTE{


    default{

        useCSS = 0
        contentCSS = EXT:crystalis/Resources/Public/Styles/rte.min.css
        hideButtons := addToList(blockstyle,toggleborders)
        showButtons := addToList(small)

        buttons{

            textstyle{

                tags{

                    span{
                        allowedClasses := addToList(tel)
                    }

                }

            }

            link{

                targetSelector.disabled = 1
                popupSelector.disabled = 1
                properties.class.allowedClasses = 
                page.properties.class.default = 
                url.properties.class.default = 
                file.properties.class.default = 
                mail.properties.class.default = 

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
            allowedClasses := removeFromList(external-link, external-link-new-window, internal-link, internal-link-new-window, download, mail)

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

    }


    classes := removeFromList(external-link, external-link-new-window, internal-link, internal-link-new-window, download, mail)
    classes{

        tel{

            name = LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:rte.charClassTel
            value = word-spacing: -0.1em;

        }

    }


}