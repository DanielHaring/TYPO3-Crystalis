mod{

    wizards{

        newContentElement{

            wizardItems{

                special{

                    show := removeFromList(media)

                    elements{

                        video{
                            iconIdentifier = content-plugin-video
                            title = LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:tt_content.CType_Video
                            description = LLL:EXT:crystalis/Resources/Private/Language/locallang_ttc.xlf:tt_content.CType_Video_Desc
                            tt_content_defValues{
                                CType = video
                            }
                        }

                    }

                    show := addToList(video)

                }

            }

        }

    }

}