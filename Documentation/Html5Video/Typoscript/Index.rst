.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _html5-video-ts:

The TypoScript way
^^^^^^^^^^^^^^^^^^

After a HTML5 Video content element was placed onto a page, it will be rendered using the brand new 
:ref:`cobj-video` content object. You can take advantage of this circumstance to embed HTML5 videos with only a 
few lines of TypoScript – without the need of any content element. This is particularly beneficial if you want 
to display static videos which never should be maintained by backend users.

This method works in every environment, regardless of wheter the HTML5 Video content element is 
:ref:`available <html5-video-availability>` or not – allowing you to embed HTML5 videos even when working with 
XHTML 1.0 Strict :ref:`doctype <preset-rendering-doctype>`.

**Note:** Like the content element itself, the :ref:`cobj-video` content object requires at least one out of the 
three main video formats (MP4, WebM, Ogg) to be set. Otherwise nothing will be generated in frontend.