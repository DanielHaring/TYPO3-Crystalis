.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _dev:

Developer Corner
================


.. _dev-hooks:

Hooks
-----

.. _dev-hooks-language-register:

Language Service: Register Rewrite Configurator
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

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
         HARING\Crystalis\Service\LanguageService

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
\HARING\Crystalis\Configuration\UrlRewriting\ConfiguratorInterface. Otherwise your configurator will be ignored.


.. _dev-database-service:

Using Database Service
----------------------

The Language Service performs several database queries which are bundled within the Database Service. This class 
allows you to obtain informations about languages and domains of your website more effectively.

Because it's able to establish a database connection on it's own, the TYPO3_DB class doesn't have to be present 
when queries are made, allowing you to access informations from nearly every point.


.. _dev-database-service-instantiation:

Instantiation
^^^^^^^^^^^^^

The database service was designed to be of type singleton. Therefore it's highly recommended to instantiate this 
Service using the makeInstance method of GeneralUtility instead of using the "new" keyword (whereby classes should 
never been instantiated via "new", please make us of makeInstance or the ObjectManager instead). This will ensure 
the Database Service will exist only once, what may increase processing speed siginficantly:

.. code-block:: php

    $DatabaseService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        'HARING\\Crystalis\\Service\\DatabaseService');


.. _dev-database-service-accessing:

Accessing database
^^^^^^^^^^^^^^^^^^

You may come to that point where you want to have database access before the TYPO3_DB class was initiated. For this 
purpose the Database Service is able to establish it's own database connection, which is done automatically if a 
query was sent and the TYPO3_DB class is not present. You can get this connection by simply calling the following:

.. code-block:: php

    $DatabaseService->getDatabaseConnection();

The returning object behaves exactly the same way as TYPO3_DB does, thus allowing you to to make familiar queries:

.. code-block:: php

    $Result = $DatabaseService->getDatabaseConnection()->exec_SELECTquery('field', 'table', 'where');

A new database connection will be established using the Crystalis General Utility class. If you do not need all the 
specific functions of the Database Service, you can obtain a database connection by directly calling the respective 
method:

.. code-block:: php

    $DB = \HARING\Crystalis\Utility\GeneralUtility::obtainDatabaseConnection();
    $DB->exec_SELECTquery('field', 'table', 'where');

No matter which way you chosse of accessing the database, a new connection only will be established if it is really 
necessary. Meaning if TYPO3_DB already was initiaded or a new connection was established previously, the existing one 
will be used instead of creating a new one.


.. _dev-database-service-functions:

Public member functions
^^^^^^^^^^^^^^^^^^^^^^^

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Method
         getDatabaseConnection

   Returns
         \TYPO3\CMS\Dbal\Database\DatabaseConnection

   Description
         Returns an existing database connection (e.g. $GLOBALS['TYPO3_DB']) or establishes a new one.


.. container:: table-row

   Method
         getDomainAssignments

   Parameters
         *boolean* **$noBuffer:** If set to TRUE, no buffering will be enforced.

   Returns
         array

   Description
         Retrieves "domain => language" assignments from database or returns the buffered result if a respective entry 
         entry was found.


.. container:: table-row

   Method
         getSystemLanguages

   Parameters
         *boolean* **$noBuffer:** If set to TRUE, no buffering will be enforced.

   Returns
         array

   Description
         Retrieves defined system languages from database or returns the buffered result if a respective entry was found.


.. ###### END~OF~TABLE ######


.. _dev-notes:

Developer notes
---------------


.. _dev-notes-issue-20141027:

27.10.2014 by Daniel Haring
^^^^^^^^^^^^^^^^^^^^^^^^^^^

PHP version requirement was raised from 5.3.7 to 5.4.0. Crystalis makes use of the new short array creation 
syntax and quick item access of arrays returned by functions. This little raise shouldn't affect many 
installations but significantly increases code quality.


.. _dev-notes-issue-20141007:

07.10.2014 by Daniel Haring
^^^^^^^^^^^^^^^^^^^^^^^^^^^

Compatibility layer should not been added for TYPO3 CMS lower version 6.1. The lack of feature support is
too big and further it is not recommended to use lower versions any more.

The main reason for this decision is the fact that TCA does not support multiple display conditions at once 
in TYPO3 CMS 6.0 or lower.


.. _dev-notes-issue-20140912:

12.09.2014 by Daniel Haring
^^^^^^^^^^^^^^^^^^^^^^^^^^^

By now, Crystalis requires at least TYPO3 CMS 6.2. The issues which are responsible for that, may be solved with 
additional compatibility layers. This will be checked as soon as the extension reaches feature stop state.

Here's a list of all spotted issues:

 - cObject "FILES" doesn't provide REGISTER variables "FILES_COUNT" and "FILE_NUM_CURRENT" until TYPO3 
   CMS 6.2 (used in tt_content.image)
 - Utility function array_merge_with_overrule was renamed and its behaviour has changed