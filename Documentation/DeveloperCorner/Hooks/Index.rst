.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _dev-hooks:

Hooks
^^^^^

.. _dev-hooks-language-register:

Language Service: Register Rewrite Configurator
"""""""""""""""""""""""""""""""""""""""""""""""

This hook allows you to register a PHP class which is responsible for preparing URL rewriting for a specific 
extension (if you're using CoolUri for example).


.. _dev-hooks-language-register-register:

Registering a hook
~~~~~~~~~~~~~~~~~~

To register a Rewrite Configurator the class name inside TYPO3_CONF_VARS should be *LanguageService* and the 
function name is *registerRewriteConfigurator*. The implementation doesn't expect a specific funtion name so 
you have to specify it by yourself.

**Example:** ::

    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['crystalis']['LanguageService']['registerRewriteConfigurator'] = 
        'VENDOR\\ExtKey\\Hooks\\ClassName->functionName';


.. _dev-hooks-language-register-parameters:

Prameters
~~~~~~~~~

When the hook is called, two parameters will be passed:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Registry

   Data type
         array

   Description
         An array containing all registered configurators.

         By default the array would look like this: ::

             array(
                 'realurl' => 'HARING\\Crystalis\\Configuration\\UrlRewriting\\RealurlConfigurator'
             );


.. container:: table-row

   Property
         LanguageService

   Data type
         \\HARING\\Crystalis\\Service\\LanguageService

   Description
         The singleton instance of the Language Service.


.. ###### END~OF~TABLE ######

Therefore your implementation should look like the following: ::

    <?php

    namespace VENDOR\ExtKey\Hooks;

    class ClassName {

        public function functionName($Registry, $LanguageService) {
            // do something
        }

    }


.. _dev-hooks-language-register-returns:

Expected return value
~~~~~~~~~~~~~~~~~~~~~

The value returned by your function must be of type array and basically should look like the Registry parameter.
This means you should provide the extension key to which the configurator belongs as array key and the fully 
qualified class name which is responsible for configuration as value.

Of course, you are allowed to pass multiple allocations (key => value) at once.

**Example:** ::

    return ['cooluri' => 'VENDOR\\ExtKey\\Configuration\\UrlRewriting\\CoolUriConfigurator'];

**Important Notice:** The classes responsible for configuring URL rewriting must implement the Interface 
\\HARING\\Crystalis\\Configuration\\UrlRewriting\\ConfiguratorInterface. Otherwise your configurator will be ignored.