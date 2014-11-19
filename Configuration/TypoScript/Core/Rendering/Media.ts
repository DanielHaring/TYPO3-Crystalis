# Rendering of content element "media"
tt_content.media = COA
tt_content.media{

    10 = < lib.stdheader

    20 = MEDIA
    20{

        flexParams{
            field = pi_flexform
        }

        alternativeContent = < tt_content.text.20
        alternativeContent{
            field = bodytext
        }

        type = video
        renderType = auto
        allowEmptyUrl = 0
        forcePlayer = 1

        fileExtHandler{

            default = MEDIA
            avi = MEDIA
            asf = MEDIA
            class = MEDIA
            wmv = MEDIA
            mp3 = SWF
            mp4 = SWF
            m4v = SWF
            swa = SWF
            flv = SWF
            swf = SWF
            mov = QT
            m4v = QT
            m4a = QT

        }

        mimeConf{

            swfobject = < tt_content.swfobject.20
            qtobject = < tt_content.qtobject.20

            flowplayer = < tt_content.swfobject.20
            flowplayer{

                audio{
                    player = {$content.flowPlayer}
                }

                video{
                    player = {$content.flowPlayer}
                }

            }

        }

        stdWrap{

            editIcons = tt_content:pi_flexform,bodytext
            editIcons{

                iconTitle{

                    data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:eIcon.multimedia

                }

            }

            prefixComment = 2 | Media element:

        }

    }

}