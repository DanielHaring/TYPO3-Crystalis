.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _html5-video-availability:

Availability
^^^^^^^^^^^^

As mentioned before, the HTML5 Video content element automatically will substitute the Media element if HTML5 
:ref:`doctype <preset-rendering-doctype>` was chosen. However, if you don't want to make use of this element 
(maybe because you're already using another third-party extension for this purpose), head to Extension Manager 
module, select *Crystalis* and check "Disable HTML5 video" in "Frontend Rendering" tab. After this the Media 
element will be back again.

But what to do if you absolutely want to make use of the HTML5 content element, but still need the Media element 
to be available (to embed flash-only videos for example)? Well, of course that's possible too, but you have 
to write a little TypoScript to achieve this. Technically the Media element won't be overwritten in any way, 
but it will be hidden instead. To reactivate the Media content element just add this line of TypoScript to 
your PageTS configuration:

:typoscript:`mod.wizards.newContentElement.wizardItems.special.show := addToList(media)`

That's it. Now you are able to make use of the HTML5 video element and the Media element as well.

**Note:** If you're adding your configuration using a custom extension, please ensure it will be loaded after 
Crystalis by making it dependend on Crystalis in *ext_emconf.php*. Otherwise your settings won't have any effect 
on available content elements.