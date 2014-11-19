# Rendering of content element "table"
tt_content.table = COA
tt_content.table{

        10 = < lib.stdheader

        20 = TEXT
        20{

            field = bodytext
            trim = 1

            split{

                token{
                    char = 10
                }

                cObjNum = |*| 1 || 2 |*|

                1{

                    current = 1
                    wrap = <tr class="odd">|</tr>

                    stdWrap{

                        split{

                            token = |
                            cObjNum = 1 |*| 2 |*| 3

                            1{

                                current = 1
                                parseFunc < lib.parseFunc
                                wrap = <td class="first">|</td>

                            }

                            2 < .1
                            2{
                                wrap = <td>|</td>
                            }

                            3 < .1
                            3{
                                wrap = <td class="last">|</td>
                            }

                        }

                    }

                }

                2 < .1
                2{
                    wrap = <tr class="even">|</tr>
                }

            }

            wrap = <table><tbody>|</tbody></table>

            editIcons = tt_content:bodytext,[layout]
            editIcons{

                beforeLastTag = 1

                iconTitle{

                    data = LLL:EXT:crystalis/Resources/Private/Language/locallang.xlf:eIcon.table

                }

            }

            prefixComment = 2 | Table:

        }

}