.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _lang-page-structure:

Recommended page structure
^^^^^^^^^^^^^^^^^^^^^^^^^^

There's more than one way to skin a cat, and if you just need a handful of languages your page structure is not that 
important. This topic gains more in importance the more complex your language involments become. For example, if 
you're panning a site which should supply different versions for various countries and languages (e.g. a german page 
which privodes german language and a swiss one which is localized in german, french and italian), your site should 
be structured very well beforehand.

In this case it's recommended to mix the multi-tree- and the single-tree-concepts. This means that you have a separate 
page tree for every country you should supply (multi-tree-concept) and each tree provides one or more languages 
(single-tree-concept). To come back to the example above this would mean you finally would face a german page tree 
with one language and a swiss page tree with a total of three languages.

When mixing up things this way, it would be you best bet to define your language IDs (sys_language_uid) once for your 
whole site and stick to them on every page tree – even if you did specify a default language which is not available at 
a specific page tree. By setting a particular language for a domain (see :ref:`lang-domains`) you actually can 
prevent the default language from ever being hit in frontend.