.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _lang-preparation:

Preparation
^^^^^^^^^^^

The Language Service was designed to keep your effort as low as possible. In spite of that you have to tell 
Crystalis about the languages and domains available on your site.


.. _lang-preparation-default:

The default language of your site
"""""""""""""""""""""""""""""""""

At first you should set the default language of your site. To do this, head to Extension Manager module and 
select Crystalis. Switch to "Language handling" tab and set the "Default Language" of your site. Since you are 
here, make sure the Language Service is activated (which it is by default).


.. _lang-preparation-iso:

Make use of official language codes
"""""""""""""""""""""""""""""""""""

Static Info Tables extends language records to contain informations about the official language code (ISO 3166).
The Language Service depends on this information so please make sure this is properly set for all languages. To 
specify the language code, please switch to List module, select the very root page of your site (grey TYPO3 logo) 
and edit the language of your choice. Select the respective language beneath "Select Official Language (ISO code)" 
section and save your changes.


Specify your head domains
"""""""""""""""""""""""""

For proper url handling RealUrl needs to know about the head domain of each site. For more informations please 
see chapter :ref:`preset-rendering-domains`.