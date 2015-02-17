.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _language-service:

Language Service
================

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


.. _lang-preparation:

Preparation
-----------

The Language Service was designed to keep your effort as low as possible. In spite of that you have to tell 
Crystalis about the languages and domains available on your site.


.. _lang-preparation-default:

The default language of your site
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

At first you should set the default language of your site. To do this, head to Extension Manager module and 
select Crystalis. Switch to "Language handling" tab and set the "Default Language" of your site. Since you are 
here, make sure the Language Service is activated (which it is by default).


.. _lang-preparation-iso:

Make use of official language codes
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Static Info Tables extends language records to contain informations about the official language code (ISO 3166).
The Language Service depends on this information so please make sure this is properly set for all languages. To 
specify the language code, please switch to List module, select the very root page of your site (grey TYPO3 logo) 
and edit the language of your choice. Select the respective language beneath "Select Official Language (ISO code)" 
section and save your changes.


Specify your head domains
^^^^^^^^^^^^^^^^^^^^^^^^^

For proper url handling RealUrl needs to know about the head domain of each site. For more informations please 
see chapter :ref:`preset-rendering-domains`.


.. _lang-domains:

Handling domains
----------------

When making use of the Language Service, a proper handling of domains becomes more important. Every domain which 
should be handled by TYPO3 should be catched by exactly one domain record within the whole site.

Creating domain records works as follows:

.. figure:: ../Images/LanguageService/PageRecord.jpg
   :alt: Create a new record

Switch to List module **(1)** and select the supposed root page for your domain **(2)**. Press the "Create new 
record" **(3)** button at the top and choose "Domain" **(4)**. The domain record itself consits of two important 
fields: 

.. figure:: ../Images/LanguageService/DomainRecord.jpg
   :alt: Create a new Domain record

Of course the most important one is the domain itself **(5)**. Please enter the domain name only (no 'http' or 
slashes) – including subdomain if any (e.g. 'www.example.org').

If you want the domain to load a specific language when called, please select an "Allocated language" **(6)**.

Don't forget to save and repeat those steps with all domains you want to handle via TYPO3 CMS.

**Note:** RealUrl has got some issues when alternative ports are used. If you're using non-standard ports (unlike 
'80', '8080' or '443') you have to create two records – one containing the port inside the domain name (e.g. 
'www.example.org:8888') and one not. Some further informations about this issue can be found in chapter 
:ref:`Known Problems <problems-domain-ports>`.


.. _lang-custom-realurl:

Customizing RealUrl configuration
---------------------------------

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


.. _lang-page-structure:

Recommended page structure
--------------------------

There's more than one way to skin a cat, and if you just need a handful of languages your page structure is not that 
important. This topic gains more in importance the more complex your language involments become. For example, if 
you're panning a site which should supply different versions for various countries and languages (e.g. a german page 
which privodes german language and a swiss one which is localized in german, french and italian), your site should 
be structured very well beforehand.

In this case it's recommended to mix the multi-tree- and the single-tree-concepts. This means that you have a separate 
page tree for every country you should supply (multi-tree-concept) and each tree provides one or more languages 
(single-tree-concept). To come back to the example above this would mean you finally would face a german page tree 
with one language and a swiss page tree with a total of three languages.

When mixing up things this way, it would be you best bet to define your language IDs (sys_language_uid) once for your 
whole site and stick to them on every page tree – even if you did specify a default language which is not available at 
a specific page tree. By setting a particular language for a domain (see :ref:`lang-domains`) you actually can 
prevent the default language from ever being hit in frontend.


.. _lang-deactivate:

Deactivating Language Service
-----------------------------

There may be situations where you don't want Crystalis to manage your language- and domain-configurations. Maybe you 
don't even need alternative languages or you want to write your own configurations. To prevent Crystalis from calling 
Language Service, switch to Extension Manager module, select Crystalis and und uncheck "Activate" inside "Language 
handling" tab.