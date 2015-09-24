page{

    headerData{

        # Canonical tag
        10 = TEXT
        10{

            field = tx_crystalis_canonical
            required = 1

            stdWrap{

                setContentToCurrent = 1

                typolink{

                    parameter{
                        current = 1
                    }

                    returnLast = url
                    forceAbsoluteUrl = 1

                }

            }

            innerWrap = <link rel="canonical" href="|">
            innerWrap{

                override = <link rel="canonical" href="|" />
                override{

                    if{

                        isTrue{
                            data = TSFE:xhtmlDoctype
                        }

                    }

                }

            }

            append = TEXT
            append{
                char = 10
            }

        }

        # Page title
        20{

            stdWrap{

                override{

                    field = tx_crystalis_pagetitle
                    trim = 1
                    htmlSpecialChars = 1

                }

            }

        }

    }

}