# Rendering of content element "video"
tt_content.video = COA
tt_content.video{

    10 = < lib.stdheader

    20 = VIDEO
    20{

        flexParams{
            field = pi_flexform
        }

        mimeConf{

            flash{
                player = {$content.videoPlayer}
            }

        }

        stdWrap{

            editIcons = tt_content:pi_flexform
            editIcons{

                iconTitle{
                    data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:eIcon.video
                }

            }

            prefixComment = 2 | HTML5 video element:

        }

    }

}