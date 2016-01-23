.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _preset-user-ts:

User TypoScript
^^^^^^^^^^^^^^^

The user configuration is injected by default and makes some smaller adjustments to backend users. The 
configurations herein aren't very extensive and allow backend users to clear global cache for example. What 
may should taken into account is the circumstance, that Crystalis deactivates uploading of files directly 
inside content element forms, thus forcing users to make use of the filelist module.


.. _preset-user-ts-deactivate:

Refrain from User TypoScript
""""""""""""""""""""""""""""

If you don't want Crystalis to inject its backend user configuration, you can disable this feature inside TYPO3 
Extension Manager – thus requiring you to have administrator rights.

To deactivate User TypoScript, head to Extension Manager module and select Crystalis. In General tab uncheck 
*"User TypoScript"* in *"Preset configurations"* section and save your changes.

After this, the backend user configuration won't being touched by Crystalis anymore.