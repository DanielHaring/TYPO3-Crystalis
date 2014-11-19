  #customcategory=server=LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:constants.category_Server
  #customsubcategory=uri=LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:constants.subcategory_Uri

server{

    scheme = http

      #cat=server/uri/d1; type=; label=LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:constants.label_Host
    host = www.example.org

      #cat=server/uri/d2; type=; label=LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:constants.label_Port
    port =

      #cat=server/uri/d3; type=; label=LLL:EXT:crystalis/Resources/Private/Language/locallang_be.xlf:constants.label_Path
    path = /

}

[globalString = ENV:HTTPS=on]
server.scheme = https
[global]