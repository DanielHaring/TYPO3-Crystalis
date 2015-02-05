.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _html5video:

HTML5 Video Content Element
===========================

If :ref:`HTML5 doctype <contentrendering-htmldoctype>` is selected (which is by default) Crystalis automatically 
substitutes the Media content element with the new HTML5 Video content element.

This new element lets you define various sources easily and apply settings without having to know about the 
exact commands.


.. _html5video-disable:

Disable HTML5 Video Content Element
-----------------------------------

If you do not want Crystalis to substitute the Media element for whatever reason, you can deactivate it in 
extension configuration.

To achieve this, head to "Extension Manager" module and select "Crystalis". Switch to "Frontend Rendering" tab 
and check "Disable HTML5 video". The HTML5 Video Content Element won't be available any longer.

.. figure:: ../../Images/Html5VideoCE/Disable.jpg
   :alt: Disable HTML5 Video Content Element

If you, however, absolutely want to make use of the new element but do not want the Media element to disappear, 
you have to configure this by yourself. Technically the Media element is not substitued but deactivated – the 
HTML5 Video element is a separate element. Therefore you have to edit pageTS (e.g. of your root page) and 
activate the Media element again. To achieve this, you have to add the following line of code:

:typoscript:`mod.wizards.newContentElement.wizardItems.special.show := addToList(media)`

That's it. Now you can make use of both – the HTMl5 Video and the Media content elements.


.. _html5video-add:

Add a new element
-----------------

You're curious about how the new element works? Nothing easier than that! Just create a new content element as 
usual. When asked about the content type, switch to "Special elements" tab and select "HTML5 Video".

.. figure:: ../../Images/Html5VideoCE/CEWiz.jpg
   :alt: Add a new HTML5 Video Content Element

The new form you will be confronted with won't differ much from what you're used to. Just the "Video" tab will 
be some kind of new – but self-explanatory. To make the element displaying anything in Frontend, you have to add 
one video file at least (mp4, WebM, Ogg).

In addition it is hingly recommended to set "width" and "height" in "Settings" sub-tab. If dimensions are omitted 
and couldn't been detected automatically, width will be set to 720 and height to 576.

**Please note:** Poster images and Flash videos do not count as source. For example specifiying Flash video only, 
will coax the element to actually display nothing.


.. _html5video-typoscript:

The TypoScript way
------------------

Crystalis introduces a whole new content object, simply called "VIDEO". This renderer is used when a HTML5 Video 
content element should be displayed in Frontend. However, if you want to, you can make use of this content object 
with pure TypoScript only – with no need to refer to any existing content element. This is useful if you want to 
display static HTML5 videos which never should be maintained by backend users.

Like the content element, inserting HTML5 video via TypoScript requires at least one video source (mp4, WebM, Ogg) 
to be set. If none was specified, nothing will be generated.


.. _cobj-video:

VIDEO
^^^^^


.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         .. _video-if:

         if

   Data type
         :ref:`->if <t3tsref:if>`

   Description
         If "if" returns false, the video element is not generated.


.. container:: table-row

   Property
         .. _video-flexparams:

         flexParams

   Data type
         string / :ref:`stdWrap <t3tsref:stdWrap>`

   Description
         The FlexForm configuration of the content element.

         If this is set, the parameter array will be ignored.

   Default
         flexParams.field = pi\_flexform


.. container:: table-row

   Property
         .. _video-mimeconf:

         mimeConf.flash

   Data type
         array

   Description
         Configuration for specific formats.

         At present property *player* is the only supported one.

         **Example:** ::

            mimeConf.flash.player = typo3/contrib/flashmedia/flvplayer.swf


.. container:: table-row

   Property
         .. _video-parameter:

         parameter

   Data type
         :ref:`->parameter <data-type-videoparameter>`

   Description
         Configuration of video sources and player options.

         If FlexForm is filled with values this array will be ignored.


.. container:: table-row

   Property
         .. _video-stdwrap:

         stdWrap

   Data type
         :ref:`stdWrap <t3tsref:stdwrap>`


.. ###### END~OF~TABLE ######


.. _data-type-videoparameter:

parameter
"""""""""


.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         .. _videoparameter-mp4:

         mp4

   Data type
         :ref:`resource <t3tsref:data-type-resource>`

   Description
         mp4 video source.

         Can be either a relative path or a sys_file ID. The latter one has to be prepended with *file:*.

         **Example:** ::

            mp4 = fileadmin/videos/myvideo.mp4


.. container:: table-row

   Property
         .. _videoparameter-webm:

         webm

   Data type
         :ref:`resource <t3tsref:data-type-resource>`

   Description
         WebM video source.

         Can be either a relative path or a sys_file ID. The latter one has to be prepended with *file:*.

         **Example:** ::

            webm = file:1


.. container:: table-row

   Property
         .. _videoparameter-ogg:

         ogg

   Data type
         :ref:`resource <t3tsref:data-type-resource>`

   Description
         Ogg video source.

         Can be either a relative path or a sys_file ID. The latter one has to be prepended with *file:*.

         **Example:** ::

            ogg = EXT:myext/Resources/Public/Videos/myvideo.ogg


.. container:: table-row

   Property
         .. _videoparameter-flash:

         flash

   Data type
         :ref:`resource <t3tsref:data-type-resource>`

   Description
         Adobe Flash fallback. Will be rendered as *object* tag.

         Can be either a relative path or a sys_file ID. The latter one has to be prepended with *file:*.

         **Example:** ::

            flash = fileadmin/videos/myvideo.swf


.. container:: table-row

   Property
         .. _videoparameter-poster:

         poster

   Data type
         :ref:`resource <t3tsref:data-type-resource>`

   Description
         Poster image.

         Can be either a relative path or a sys_file ID. The latter one has to be prepended with *file:*.

         **Example:** ::

            poster = fileadmin/videos/myvideo-poster.jpg


.. container:: table-row

   Property
         .. _videoparameter-width:

         width

   Data type
         :ref:`pixels <t3tsref:data-type-pixels>`

   Description
         The width of the generated video element.

   Default
         720


.. container:: table-row

   Property
         .. _videoparameter-height:

         height

   Data type
         :ref:`pixels <t3tsref:data-type-pixels>`

   Description
         The height of the generated video element.

   Default
         576


.. container:: table-row

   Property
         .. _videoparameter-preload:

         preload

   Data type
         boolean

   Description
         Forces the browser to preload the video.

   Default
         0


.. container:: table-row

   Property
         .. _videoparameter-autoplay:

         autoplay

   Data type
         boolean

   Description
         Starts the video as soon as the page has loaded.

   Default
         0


.. container:: table-row

   Property
         .. _videoparameter-loop:

         loop

   Data type
         boolean

   Description
         Tries to restart the video as soon as it finishes.

   Default
         0


.. container:: table-row

   Property
         .. _videoparameter-controls:

         controls

   Data type
         boolean

   Description
         Shows default player controls (depending on operating system and video player).

   Default
         0


.. ###### END~OF~TABLE ######