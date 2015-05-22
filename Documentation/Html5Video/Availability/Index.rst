.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _html5-video-availability:

Availability
^^^^^^^^^^^^

As mentioned before, the HTML5 Video Content Element automatically will be available if HTML5 
:ref:`doctype <preset-rendering-doctype>` was chosen. However, if you don't want to make use of this element 
(maybe because you're already using another third-party extension for this purpose), head to Extension Manager 
module, select *Crystalis* and check *"Disable HTML5 Video"* in *"Frontend Rendering"* tab.

If the system extension *"Media Content Element (mediace)"* is activated, Crystalis basically substitutes the 
Media Content Element. However, if you still need the Media element to be available (to embed flash-only 
content for example) you have to reactivate the Media Content Element inside your PageTS configuration:

:typoscript:`mod.wizards.newContentElement.wizardItems.special.show := addToList(media)`

After this, you are able to make use of both – the HTML5 Video Content Element as well as the Media Element.

**Note:** If you're adding your configuration using a custom extension, please ensure it will be loaded after 
Crystalis by making it dependend on Crystalis in *ext_emconf.php*. Otherwise your settings won't have any effect 
on available content elements.