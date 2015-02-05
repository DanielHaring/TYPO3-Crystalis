.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _backendconfig:

Backend Configuration
=====================

Crystalis provides configurations to increase usability and portability. These settings will be loaded automatically 
by default. If you want to disable some of this features or just want to know how things work, go on reading.


.. _basicbackendconf:

Basic Settings
--------------

By default, Crystalis embeds user- and page-TS configurations to enhance backend usability. It pre-configures 
Rich Text Editor, removes obsolete table fields, sets various default values and fine tunes rights and options 
for backend users.

If you do not want Crystalis to load those setups, you can deactivate them by changing extension configuration.
For this purpose head to the module "Extension Manager" and select "Crystalis". In "General" tab deactivate 
"Page TypoScript" and/or "User TypoScript".

.. figure:: ../../Images/BackendConfig/Extconf.jpg
   :alt: Extension configuration


.. _backendlayouts:

Backend Layouts
---------------

Crystalis adds support of including backend layouts using files.

The content a backend layout file must contain is equal to backend layouts saved in databases. Of course you 
can use the backend_layout wizard if in doubt.

.. figure:: ../../Images/BackendConfig/BELayoutWizard.jpg
   :alt: TYPO3 Backend Layout Wizard

To register one or multiple files which should be loaded as backend layout, edit the page you want to contain 
the layouts. Switch to "Resources" tab and edit Page TSConfig as follows:


tx_crystalis
^^^^^^^^^^^^

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         .. _pagets-plugin-crystalis-includebackendlayouts:

         includeBackendLayouts.[array]

   Data type
         resource

   Description
         Inserts one or more backend layouts.

         The file definition must be a valid "resource" data type, otherwise nothing is inserted. This means that remote files cannot be referenced.

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