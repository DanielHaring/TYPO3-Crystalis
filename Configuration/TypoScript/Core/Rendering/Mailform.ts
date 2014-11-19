# Rendering of content element "mailform"
tt_content.mailform = COA
tt_content.mailform{

    10 < lib.stdheader

    20 = FORM
    20{

        accessibility = 1
        noWrapAttr = 1
        formName = mailform
        fontMd5FieldNames = 1
        layout = <p>###LABEL### ###FIELD###</p>

        labelWrap{
            wrap = |
        }

        commentWrap{
            wrap = |
        }

        radioWrap{

            wrap = |<br>
            accessibilityWrap = <fieldset###RADIO_FIELD_ID###><legend>###RADIO_GROUP_LABEL###</legend>|</fieldset>

        }

        REQ = 1
        REQ{

            labelWrap{
                wrap = |
            }

        }

        COMMENT{
            layout = <p>###LABEL###</p>
        }

        RADIO{
            layout = <p>###FIELD### ###LABEL###</p>
        }

        LABEL{
            layout = <p>###LABEL### ###FIELD###</p>
        }

        goodMess =
        badMess =

        redirect{
            field = pages
            listNum = 0
        }

        recipient{
            field = subheader
        }

        data{
            field = bodytext
        }

        locationData = 1

        hiddenFields{

            stdWrap{
                wrap = <div style="display: none;">|</div>
            }

        }

        params{

            radio = class="radio"
            check = class="check"
            submit = class="submit"

        }

        stdWrap{

            wrap = <fieldset>|</fieldset>

            editIcons = tt_content:bodytext,pages,subheader
            editIcons{

                iconTitle{

                    data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:eIcon.form

                }

            }

            prefixComment = 2 | Mail form inserted:

        }

    }

}