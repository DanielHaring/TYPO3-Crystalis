# Rendering of content element "uploads"
tt_content.uploads = COA
tt_content.uploads{

    10 = < lib.stdheader

    20 = FILES
    20{

        references{

            table = tt_content
            fieldName = media

            uid{
                field = uid
            }

        }

        renderObj = TEXT
        renderObj{

            data = FILE:current:publicUrl

            filelink{

                icon = 1
                icon_link = 1

                labelStdWrap{

                    override{

                        data = FILE:current:title
                        htmlSpecialChars = 1
                        trim = 1

                    }

                }

                file{

                    prepend = TEXT
                    prepend{
                        char = 32
                    }

                }

                size = 1
                size{

                    bytes = 1
                    bytes{
                        labels = " Bytes| kB| MB| GB| TB"
                    }

                    wrap = (|)

                    prepend = TEXT
                    prepend{
                        char = 32
                    }

                }

                jumpurl = 1
                jumpurl{

                    secure = 1
                    secure{

                        mimeTypes = pdf=application/pdf,doc=application/msword

                    }

                }

            }

            wrap = <li>|</li>

        }

        stdWrap{

            stdWrap{

                required = 1
                wrap = <ul class="downloads">|</ul>

            }

            editIcons = tt_content:media,layout
            editIcons{

                iconTitle{

                    data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:eIcon.filelist

                }

            }

            prefixComment = 2 | File list:

        }

    }

}