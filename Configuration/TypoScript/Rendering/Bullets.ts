# Rendering of content element "bullets"
tt_content.bullets = COA
tt_content.bullets{

    10 = < lib.stdheader

    20 = TEXT
    20{

        field = bodytext
        required = 1
        trim = 1

        split{

            token{
                char = 10
            }

            cObjNum = |*| 1 || 2 |*|

            1{

                current = 1
                parseFunc = < lib.parseFunc
                wrap = <li class="odd">|</li>

            }

            2 < .1
            2{
                wrap = <li class="even">|</li>
            }

        }

        innerWrap = <ul>|</ul>

        editIcons = tt_content:bodytext,[layout]
        editIcons{

            beforeLastTag = 1

            iconTitle{

                data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:eIcon.bullets

            }

        }

        prefixComment = 2 | Bullet list:

    }

}