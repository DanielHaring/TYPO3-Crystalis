.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _contentrendering:

Content Rendering
=================

Crystalis provides a complete content rendering logic and therefore is intended for completely replacing 
system extension "css_styled_content". To stay as compatible as possible with third party extensions and 
foreign setups, the main structure was adopted. Implementing plugins the old fashioned way should be as easy 
as usual.


.. _contentrendering-htmldoctype:

HTML Doctype
------------

The rendered HTML output depends on which HTML doctype you are using (e.g. using time-tags only if working on 
HTML5). Crystalis supports "XHTML 1.0 Strict" and "HTML5" where the latter one is used by default. If you want 
to use XHTML instead, you have to tell Crystalis about that. For this head to module "Extensin Manager" and 
select "Crystalis". Switch to tab "Frontend Rendering" and select your desired "HTML Doctype".

.. figure:: ../../Images/ContentRendering/Doctype.jpg
   :alt: Selecting your doctype

**Note:** Changing doctype does not affect frontend rendering only. For example the HTML5 video element will 
be available only when working with HTML5.


.. _contentrendering-deactivatecssstyledcontent:

Deactivating CSS Styled Content
-------------------------------

Although Crystalis works fine beside CSS Styled Content, it is recommendet to uninstall this system extension 
(extkey: "css_styled_content"). When consequently using Crystalis, CSS Styled Content only hogs performance.

To uninstall CSS Styled Content, head to module "Extension Manager". Search for "CSS Styled Content" and finally 
uninstall it by klicking the "Deactivate" button on the left.

.. figure:: ../../Images/ContentRendering/ExtMgm.jpg
   :alt: Extension Manager


.. _contentrendering-embedding:

Embedding rendering
-------------------

Including content rendering is done the same way CSS Styled Contend does.

To achieve this, firstly head to "Template" module. Select the root page of your website – or any other page 
where you want to include the setup. If the selected page doesn't contain a template already, create a new 
"Template for a new site" or an "Extension template". At the bottom click "Edit the whole template record" and 
switch to tab "Includes". In section "Include static (from extensions)" add "Frontend Rendering (crystalis)" 
to "Selected items". After saving your changes the render setup will take up employment.

.. figure:: ../../Images/ContentRendering/Includes.jpg
   :alt: Include static setups


.. _contentrendering-domainsettings:

Basic domain settings
---------------------

As soon as the setup is included, Crystalis needs to know about the main domain which is used for the current page. 
This information is needed for setting baseURL and to get language handling to work properly.

Domain settings are stored as constants, so head to module "Template" first. Choose the page where your template 
is located at and select "Constant Editor" at the very top. Select category "SERVER" and fill out all 3 fields as 
described there.

.. figure:: ../../Images/ContentRencering/DomainConst.jpg
   :alt: Setting domain constants

**Note:** Server protocol (http or https) will be detected automatically. There's no need to configure it properly.