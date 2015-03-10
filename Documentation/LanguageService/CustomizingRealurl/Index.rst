.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _lang-custom-realurl:

Customizing RealUrl configuration
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

As mentioned above, the Language Service will configure RealUrl to properly handle your domains and languages. For 
this purpose, it will adopt the present RealUrl configuration and alteres it to fit your site structure. The 
present configuration is defined inside the extension configuration of RealUrl (Extension Manager > RealUrl > 
"Path to configuration file") – if enabled the automatic configuration also will be taken into account. However, if 
there isn't any configuration file present and automatic configuration is disabled (what is receommended, but not 
set by default), Crystalis provides its own RealUrl base configuration to which it will fall back. This file is 
located in "Configuration/PHP/RealUrl/FallbackTemplate.php" inside Crystalis' extension directory.

Now if you want to configure RealUrl by yourself but still want to make use of the Language Service, all you have 
to do is write your own RealUrl base configuration and register that file in RealUrl extension configuration.
The Language Service will automatically adopt your configuration and adds all missing domains and languages.

Please desist from configuring domains and languages by yourself as this may lead to conflicts with the Language 
Service. If Crystalis finds an entry for a specific domain it will leave it untouched – adding no language specific
configurations.

The best practice for providing custom RealUrl configurations is to add a single entry for a domain called 
'localhost'.

**Note:** To speed things up, the Language Service makes use of the TYPO3 Caching Framework when the configuration 
is computed. If you did integrate a custom RealUrl configuration and altered it afterwards, you have to clear TYPO3 
caches to force Crystalis to recalculate it's configuration.