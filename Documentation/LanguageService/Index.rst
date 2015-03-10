.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _language-service:

Language Service
----------------

Crystalis actively supports you in creating multilingual websites. Basically you just have to define available 
languages and domains – the Language Service will care about everything else.

To get this to work, the third-party extension Static Info Tables (extension key: "static_info_tables") has to 
be present. However, if you wave this requirement Crystalis won't break in total but the Language Service won't 
be exucuted at all.

In addition it is highly recommended to install RealUrl (extension key: "realurl") as well. Crystalis will take 
care of configuring RealUrl depeding on available languages and domains. If you already are familiar with 
RealUrl and want to inject you own configurations you can simply write your own base configuration and the 
Language Service will complete it with domain and language settings. If you're interested in how this exactly 
works, please see chapter :ref:`lang-custom-realurl`.


.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   Preparation/Index
   HandlingDomains/Index
   CustomizingRealurl/Index
   RecommendedStructure/Index
   Deactivating/Index