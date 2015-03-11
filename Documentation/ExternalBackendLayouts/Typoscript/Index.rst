.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _be-lay-ts:

Accessing via TypoScript
^^^^^^^^^^^^^^^^^^^^^^^^

When building templates for different backend layouts you may come to that point where you want to differ between 
specific backend layouts on TypoScript side. When TYPO3 handles external backend layouts, it will set the respective 
array key within PageTS as layout ID and prefixes it with "\file__" (please mind the double underscore).

For example, if you have the following configuration inside your PageTS ::

    1:  tx_crystalis.includeBackendLayouts{
    2:      test = fileadmin/backend_layouts/test.ts
    3:      test{
    4:          title = Some Backend Layout
    5:      }
    6:  }

the name of your backend layout when accessed via TypoScript will be "file__test". See the following example setup 
fragment for accessing external backend layouts via TypoScript ::

     1:  10 = TEXT
     2:  10{
     3:      value = A headline
     4:      wrap = <h2>|</h2>
     5:      append{
     6:          if{
     7:              equals{
     8:                  data = PAGE:backend_layout
     9:                  ifEmpty.data = LEVELFIELD:-1,backend_layout_next_level,slide
    10:              }
    11:              value = file__test
    12:          }
    13:          value = Subheader
    14:          wrap = <h3>|</h3>
    15:      }
    16:  }

This code will create a H2-heading and adds a subheading (H3) if an external backend layout called "test" is active.

Of course you can make use of external backend layouts inside FLUID too:

*TypoScript* ::

     1:  10 = FLUIDTEMPLATE
     2:  10{
     3:      template = FILE
     4:      template.file = fileadmin/templates/page.html
     5:      variables.backendLayout = TEXT
     6:      variables.backendLayout{
     7:          data = PAGE:backend_layout
     8:          ifEmpty.data = LEVELFIELD:-1,backend_layout_next_level,slide
     9:      }
    10:  }

*FLUID* ::

    1:  <f:if condition="{0: backendLayout} == {0: 'file__test'}">
    2:      Do something
    3:  </f:if>