.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _introduction:

Introduction
------------


.. _what-it-does:

What does it do?
^^^^^^^^^^^^^^^^

This extension was made to lower the effort when building websites, keep the output code maximum clean and still 
remain as flexible as possible.

To achieve this, Crystalis has its own content rendering written in pure TypoScript, which avoids outputting of 
annoying CSS classes whenever possible.

A slightly optimized backend increases usability and the Language Service takes the main part of configuring 
alternative languages by collaborating with extensions Static Info Tables and RealURL.

Furthermore a HTML5 Video content element will be available when working with HTML5 doctype and various smaller 
improvements are making TYPO3-life a lot easier.

The whole extension is subdivided into components which can be deactivated individually, thus your sever won't be 
loaded with code you are not interested in.


.. _requirements:

System requirements
^^^^^^^^^^^^^^^^^^^

At present Crystalis requires **TYPO3 CMS 6.2** and **PHP 5.4**. Although not completely debarred, a compatibility 
layer is not being planned at the moment.

The language service requires the third party extension *Static Info Tables (static_info_tables)* to be present and 
in addition it pre configures *RealURL (realurl)*. If you're planning to make use of it, please make sure those 
extensions are installed as well.


.. _about-doc:

About this documentation
^^^^^^^^^^^^^^^^^^^^^^^^

This documentation may differ from what you're used to. Each component got its own chapter allowing yo to jump to 
those particular sections you are interested in.

You would have written things differently? Feel free to :ref:`contact me <credits-contact>` and just let me know.