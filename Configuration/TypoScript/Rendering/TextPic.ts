# Rendering of content element "textpic"
tt_content.textpic = COA
tt_content.textpic{

    1 = < tt_content.image.1

    10 = < lib.stdheader

    20 < tt_content.image.20
    20{

        stdWrap{

            prepend = < tt_content.text.20
            prepend{

                if{

                    isInList{
                        field = imageorient
                    }

                    value = 8,9,10

                }

                outerWrap =
                outerWrap{

                    override = <div class="text-box">|</div>
                    override{

                        if{

                            isGreaterThan{
                                field = imageorient
                            }

                            value = 24

                        }

                    }

                }

            }

            append  < .prepend
            append{

                if{
                    negate = 1
                }

            }

        }

    }

    99 = < tt_content.image.99

}