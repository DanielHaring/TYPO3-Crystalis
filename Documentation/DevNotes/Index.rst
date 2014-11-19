.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _devnotes:

Developer Notes
===============


.. _note-issue-1:

27.10.2014 by Daniel Haring
---------------------------

PHP version requirement was raised from 5.3.7 to 5.4.0. Crystalis makes use of the new short array creation 
syntax and quick item access of arrays returned by functions. This littue raise should'nt affect many 
installations but increases code quality.


07.10.2014 by Daniel Haring
---------------------------

Compatibility layer should not been added for TYPO3 CMS lower version 6.1. The lack of feature support is
too big and further it is not recommended to use lower versions any more.

The main reason for this decision is the fact that TCA does not support multiple display conditions at once 
in TYPO3 CMS 6.0 or lower.


12.09.2014 by Daniel Haring
---------------------------

By now, crystalis requires TYPO3 CMS 6.2. The issues which are responsible for that, may be solved with 
additional compatibility layers. This will be checked as soon as the extension reaches feature stop state.

Here's a list of all spotted issues:
 - cObject "FILES" doesn't provide REGISTER variables "FILES_COUNT" and "FILE_NUM_CURRENT" until TYPO3 
   CMS 6.2 (used in tt_content.image)
 - Utility function array_merge_with_overrule was renamed and its behaviour has changed (used in 
   AuonomousLanguageService.php)