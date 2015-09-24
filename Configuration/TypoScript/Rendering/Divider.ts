# Rendering of content element "div"
tt_content.div = TEXT
tt_content.div{

    value = <hr>

    override = <hr />
    override{

        if{

            isTrue{
                data = TSFE:xhtmlDoctype
            }

        }

    }

    prefixComment = 2 | Divider element:

}