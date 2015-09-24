# Rendering of content element "image"
tt_content.image = COA
tt_content.image{

    1 = LOAD_REGISTER
    1{

        IMAGE_POSITIONING{

            cObject = CASE
            cObject{

                key{
                    field = imageorient
                }

                0 = TEXT
                0{
                    value = center
                }

                1 = TEXT
                1{
                    value = right
                }

                8 < .0
                9 < .1

                17 = TEXT
                17{
                    value = intext right
                }

                18 = TEXT
                18{
                    value = intext left
                }

                25 < .1

                26 = TEXT
                26{
                    value = left
                }

            }

        }

    }

    10 = < lib.stdheader

    20 = FILES
    20{

        references{

            table = tt_content
            fieldName = image

            uid{
                field = uid
            }

        }

        renderObj = IMAGE
        renderObj{

            file{

                import{
                    data = FILE:current:publicUrl
                }

                width{

                    override{

                        field = imagewidth
                        required = 1

                        append = TEXT
                        append{

                            fieldRequired = imageheight
                            value = c

                        }

                    }

                }

                height < .width
                height{

                    override{

                        field = imageheight

                        append{

                            fieldRequired = imagewidth

                        }

                    }

                }

                maxW = {$content.maxImageWidth}

            }

            altText{

                data = FILE:current:alternative
                htmlSpecialChars = 1
                trim = 1

            }

            titleText < .altText
            titleText{

                data = FILE:current:title

            }

            imageLinkWrap = 1
            imageLinkWrap{

                enable{

                    field = image_zoom

                    ifEmpty{

                        typolink{

                            parameter{
                                data = FILE:current:link
                            }

                            returnLast = url

                        }

                    }

                }

                directImageLink = 1

                linkParams{
                    ATagParams = rel="zoom"
                }

                typolink{

                    parameter{
                        data = FILE:current:link
                    }

                }

            }

            params{

                if{

                    isFalse{
                        data = FILE:current:description
                    }

                    isLessThan{
                        data = REGISTER:FILES_COUNT
                    }

                    value = 2

                }

                append = TEXT
                append{

                    data = REGISTER:IMAGE_POSITIONING
                    required = 1
                    trim = 1
                    wrap = class="|"

                }

            }

            stdWrap{

                required = 1

                prepend = COA
                prepend{

                    if{

                        isTrue{
                            data = FILE:current:description
                        }

                    }

                    10 = COA
                    10{

                        10 = TEXT
                        10{

                            if{

                                equals{
                                    data = TSFE:config|config|doctype
                                }

                                value = html5
                                negate = 1

                            }

                            value = image-block

                            append = TEXT
                            append{
                                char = 32
                            }

                        }

                        20 = TEXT
                        20{

                            if{

                                isLessThan{
                                    data = REGISTER:FILES_COUNT
                                }

                                value = 2

                            }

                            data = REGISTER:IMAGE_POSITIONING

                            append = TEXT
                            append{
                                char = 32
                            }

                        }

                        stdWrap{

                            required = 1
                            trim = 1
                            wrap = class="|"

                            prepend = TEXT
                            prepend{
                                char = 32
                            }

                        }

                    }

                    stdWrap{

                        required = 1

                        outerWrap = <div|>
                        outerWrap{

                            override = <figure|>
                            override{

                                if{

                                    equals{
                                        data = TSFE:config|config|doctype
                                    }

                                    value = html5

                                }

                            }

                        }

                    }

                }

                append = COA
                append{

                    if{

                        isTrue{
                            data = FILE:current:description
                        }

                    }

                    10 = TEXT
                    10{

                        data = FILE:current:description
                        required = 1
                        htmlSpecialChars = 1
                        trim = 1

                        outerWrap = <div class="caption">|</div>
                        outerWrap{

                            override = <figcaption>|</figcaption>
                            override{

                                if{

                                    equals{
                                        data = TSFE:config|config|doctype
                                    }

                                    value = html5

                                }

                            }

                        }

                    }

                    stdWrap{

                        required = 1

                        outerWrap = |</div>
                        outerWrap{

                            override = |</figure>
                            override{

                                if{

                                    equals{
                                        data = TSFE:config|config|doctype
                                    }

                                    value = html5

                                }

                            }

                        }

                    }

                }

            }

        }

        stdWrap{

            required = 1

            innerWrap = |
            innerWrap{

                override = |</div>
                override{

                    if{

                        isFalse{

                            data = REGISTER:FILES_COUNT

                            stdWrap{
                                wrap = |-1
                            }

                            prioriCalc = 1

                        }

                        isLessThan{
                            field = imageorient
                        }

                        value = 25
                        negate = 1

                    }

                    prepend = COA
                    prepend{

                        10 = COA
                        10{

                            10 = TEXT
                            10{

                                value = image-box

                                append = TEXT
                                append{
                                    char = 32
                                }

                            }

                            20 = TEXT
                            20{

                                data = REGISTER:IMAGE_POSITIONING

                                append = TEXT
                                append{
                                    char = 32
                                }

                            }

                            stdWrap{

                                required = 1
                                trim = 1
                                wrap = class="|"

                                prepend = TEXT
                                prepend{
                                    char = 32
                                }

                            }

                        }

                        wrap = <div|>

                    }

                }

            }

            editIcons = tt_content:image[imageorient|imagewidth|imageheight], [image_zoom], [image_compression|image_effects]
            editIcons{

                iconTitle{

                    data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:eIcon.images

                }

            }

            prefixComment = 2 | Image block:

        }

    }

    99 = RESTORE_REGISTER

}