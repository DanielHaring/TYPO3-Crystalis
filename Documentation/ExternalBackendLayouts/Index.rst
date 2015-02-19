.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _backend-layouts:

External Backend Layouts
========================

Crystalis' Backend Layout File Data Provider allows you to outsource backend layouts as files, which increases 
flexibility and portability of your backend layouts. Every single layout is stored as a separate TypoScript file 
(*.ts) and will be registered via PageTS.


.. _be-lay-new:

Creating new layouts
--------------------

The configuration options of outsourced backend layouts are exactly the same as those from layouts saved in 
database, thus exporting existing backend layouts is fairly easy.

When creating new backend layouts you can take advantage of the respective wizard supplied by TYPO3 CMS:

.. figure:: ../Images/BackendLayouts/NewRecord.jpg
   :alt: Creating new backend layout record

First of all, switch to List module **(1)** and select any page inside the page tree **(2)** but the very root page. 
Because you don't want the layout to be stored in database, it does'nt matter which page you're choosing exactly – 
you won't save the record at all.

Next click the button "Create new record" **(3)** and choose "Backend Layout" **(4)** from the list. You can 
completely ignore all fields inside the displayed form except the last one: "Config":

.. figure:: ../Images/BackendLayouts/TceForm.jpg
   :alt: Backend layout input form

To make things a little easier, open the Backend Layout Wizard **(5)** and build up your layout as desired. After 
saving and closing the wizard, the "Config" field automatically will be filled with the configuration of your layout 
**(6)**.

Now what you have to do is to copy all the generated code and paste it into an empty TypoScript file. Abort the 
backend form for creating a new backend layout record to prevent it from being saved in database.

The TypoScript file you just created must be accessible for TYPO3 CMS, so please make sure it's located inside a 
directory on your server, which is reachable for PHP.


.. _be-lay-register:

Registering layouts to be loaded
--------------------------------

To tell TYPO3 CMS to load an external backend layout, it has to be registered within PageTS configuration. Edit the 
page with the lowest level where you want to include the layout – in most cases this would be the home page:

.. figure:: ../Images/BackendLayouts/RegisterPageConfig.jpg
   :alt: Register a backend layout

Switch to Resources tab **(1)** and edit Page TSConfig **(2)** as follows:


.. _be-lay-register-setup:

tx_crystalis
^^^^^^^^^^^^

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         .. _be-lay-register-includebackendlayouts:

         includeBackendLayouts.[array]

   Data type
         resource

   Description
         Inserts one or more backend layouts.

         The file definition must be a valid "resource" data type, otherwise nothing is inserted. This means that 
         remote files cannot be referenced.

         Each file has *optional properties:*

         **.title:** Sets the name appearing in select fields. You can enter a localization string here.

         **.description:** Sets the description of the backend layout. Localization strings are supported here too.

         **.icon:** Specify an icon which should be displayed. Icon must be a valid "resource" data type.

         **Example:** ::

            tx_crystalis.includeBackendLayouts{
                mylayout = fileadmin/backend_layouts/mylayout.ts
                mylayout{
                    title = LLL:fileadmin/lang/locallang_be.xml:be_layout.mylayout_title
                    description = LLL:fileadmin/lang/locallang_be.xml:be_layout.mylayout_description
                    icon = fileadmin/icons/be_layout_mylayout.png
                }
            }


.. ###### END~OF~TABLE ######


.. _be-lay-ts:

Accessing via TypoScript
------------------------

When building templates for different backend layouts you may come to that point where you want to differ between 
specific backend layouts on TypoScript side. When TYPO3 handles external backend layouts, it will set the respective 
array key within PateTS as layout ID and prefixes it with "file__" (please mind the double underscore).

For example, if you have the following configuration inside your PageTS ::

    1:  tx_crystalis.includeBackendLayouts{
    2:      test = fileadmin/backend_layouts/test.ts
    3:      test{
    4:          title = Some Backend Layout
    5:      }
    6:  }

the name of your backend layout when access via TypoScript will be "file__test". See the following example setup 
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