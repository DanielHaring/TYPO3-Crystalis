.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _preset-page-ts:

Page TypoScript
^^^^^^^^^^^^^^^

The page configuration is automatically injected by default and supports you with an optimized Rich Text Editor 
configuration, purged backend forms and some preset values you may won't have to remember any more.

Do not worry about Crystalis changing the default style of your content elements. The preset values do not affect 
layouts, stylings or any kind of content – they preselect options which mainly are of technical nature. For 
example the default Extbase Frontend User Domain Model is allocated to frontend users. If this option is not set 
properly you may experience issues when trying to access frontent users using Extbase.


.. _preset-page-ts-deactivate:

Prevent injection of Page TypoScript
""""""""""""""""""""""""""""""""""""

If you still aren't comfortable with that or just want to write your own configurations from scratch, you simply 
can disable injection of Page TypoScript inside the TYPO3 Extension Manager – thus requiring you to have 
administrator rights.

To deactivate Page TypoScript, head to Extension Manager and select Crystalis. In General tab uncheck 
*"Page TypoScript"* in *"Preset configurations"* section and save your changes.

From now on, Crystalis will desist from loading Page TypoScript automatically.