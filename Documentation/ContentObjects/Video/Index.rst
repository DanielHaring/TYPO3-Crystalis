.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _cobj-video:

VIDEO
^^^^^

Returns a video tag with the sources defined in the property "parameter".

Defined as PHP class *Html5VideoContentObject* in *typo3conf/ext/crystalis/Classes/ContentObject/Html5VideoContentObject.php*.


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


.. _cobj-video-examples:

Examples:
"""""""""


.. _cobj-video-examples-standard:

Standard rendering
~~~~~~~~~~~~~~~~~~

::

    1: 10 = VIDEO
    2: 10{
    3:      flexParams{
    4:           field = pi_flexform
    5:      }
    6:      mineConf{
    7:           flash{
    8:                player = typo3/contrib/flashmedia/flvplayer.swf
    9:           }
   10:      }
   11: }

This returns a video tag depending on the contents of the field pi_flexform.


.. _cobj-video-examples-autonomous:

Autonomous rendering
~~~~~~~~~~~~~~~~~~~~

::

    1: 10 = VIDEO
    2: 10{
    3:      mimeConf{
    4:           flash{
    5:                player = typo3/contrib/flashmedia/flvplayer.swf
    6:           }
    7:      }
    8:      parameter{
    9:           mp4 = fileadmin/name-of-mp4-source.mp4
   10:           webm = fileadmin/name-of-webm-source.webm
   11:           ogg = fileadmin/name-of-ogg-source.ogg
   12:           flash = fileadmin/name-of-flash-source.flv
   13:           poster = fileadmin/name-of-preview-image.jpg
   14:           width = 1920
   15:           height = 1080
   16:           preload = 1
   17:           autoplay = 1
   18:      }
   19: }

This returns:

.. code-block:: html

    <video width="1920" height="1080"  preload="auto" autoplay poster="fileadmin/name-of-preview-image.jpg">
        <source src="fileadmin/name-of-mp4-source.mp4" type="video/mp4">
        <source src="fileadmin/name-of-webm-source.webm" type="video/webm">
        <source src="fileadmin/name-of-ogg-source.ogg" type="video/ogg">
        <object width="1920" height="1080" type="application/x-shockwave-flash" data="typo3/contrib/flashmedia/flvplayer.swf">
            <param name="movie" value="typo3/contrib/flashmedia/flvplayer.swf">
            <param name="wmode" value="transparent">
            <param name="allowFullScreen" value="true">
            <param name="allowScriptAccess" value="sameDomain">
            <param name="flashvars" value="file=fileadmin/name-of-flash-source.flv&autoPlay=true">
            <img src="fileadmin/name-of-preview-image.jpg" width="1920" height="1080" alt="">
        </object>
    </video>