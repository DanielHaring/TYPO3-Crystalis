# Rendering of content element "swfobject"
tt_content.swfobject = COA
tt_content.swfobject{

    10 = < lib.stdheader

    20 = SWFOBJECT
    20{

        file =
        width =
        height =

        flexParams{
            field = pi_flexform
        }

        alternativeContent{
            field = bodytext
        }

        layout = ###SWFOBJECT###

        video{

            player = {$content.videoPlayer}
            defaultWidth = 720
            defaultHeight = 576

            default{

                params{

                    quality = high
                    menu = false
                    allowScriptAccess = sameDomain
                    allowFullScreen = true

                }

            }

        }

        audio{

            player = {$content.audioPlayer}
            defaultWidth = 300
            defaultHeight = 30

            default{

                params{

                    quality = high
                    allowScriptAccess = sameDomain
                    menu = false

                }

            }

            mapping{

                flashvars{

                    file = soundFile

                }

            }

        }

        stdWrap{

            editIcons = tt_content:multimedia,imagewidth,imageheight,pi_flexform,bodytext
            editIcons{

                iconTitle{

                    data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:eIcon.multimedia

                }

            }

            prefixComment = 2 | SWFobject element:

        }

    }

}