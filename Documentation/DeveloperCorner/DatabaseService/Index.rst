.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _dev-database-service:

Using Database Service
^^^^^^^^^^^^^^^^^^^^^^

The Language Service performs several database queries which are bundled within the Database Service. This class allows
you to obtain various information about languages and domains of your website more effectively.

Because it's able to establish a database connection on it's own, the *TYPO3_DB* class doesn't have to be present when
queries are made, allowing you to access information from nearly every point.


.. _dev-database-service-instantiation:

Instantiation
"""""""""""""

The database service was designed to be of type singleton. Therefore it's highly recommended to instantiate this Service
using the *makeInstance* method of *GeneralUtility* instead of using the *"new"* keyword (whereby classes should never
been instantiated via *"new"*, please make us of *makeInstance* or the *ObjectManager* instead). This will ensure the
Database Service will exist only once, what may increase processing speed significantly:

.. code-block:: php

    $DatabaseService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \DanielHaring\Crystalis\Service\DatabaseService::class);


.. _dev-database-service-accessing:

Accessing database
""""""""""""""""""

You may come to that point where you want to have database access before the *TYPO3_DB* class was initiated. For this
purpose the Database Service is able to establish it's own database connection, which is done automatically if a query
was sent and the *TYPO3_DB* class is not present. You can get this connection by simply calling the following:

.. code-block:: php

    \DanielHaring\Crystalis\Service\DatabaseService::getDatabaseConnection();

The returning object behaves exactly the same as *TYPO3_DB* does, thus allowing you to make familiar queries:

.. code-block:: php

    $result = \DanielHaring\Crystalis\Service\DatabaseService::getDatabaseConnection()
        ->exec_SELECTquery('foo,bar,baz', 'tx_foobar_baz', 'foo=\'bar\'');

A new database connection will be established using the Crystalis General Utility class. If you do not need all the 
specific functions provided by the Database Service, you can obtain a database connection by directly calling the 
respective method:

.. code-block:: php

    $DB = \DanielHaring\Crystalis\Utility\GeneralUtility::obtainDatabaseConnection();
    $DB->exec_SELECTquery('foo,bar,bat', 'tx_foobar_baz', 'foo=\'bar\'');

No matter which way you choose when accessing the database, a new connection only will be established if it is really
necessary. Meaning if *TYPO3_DB* already was initiated or a new connection was established previously, the existing one 
will be used instead of creating a new one.


.. _dev-database-service-functions:

Public member functions
"""""""""""""""""""""""

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Method
         *static* **getDatabaseConnection**

   Returns
         \\TYPO3\\CMS\\Dbal\\Database\\DatabaseConnection

   Description
         Returns an existing database connection (e.g. $GLOBALS['TYPO3_DB']) or establishes a new one.


.. container:: table-row

   Method
         **getDomainAssignments**

   Parameters
         *boolean* **$noBuffer:** If set to TRUE, no buffering will be enforced.

   Returns
         array

   Description
         Retrieves "domain => language" assignments from database or returns the buffered result if a respective entry 
         entry was found.


.. container:: table-row

   Method
         **getSystemLanguages**

   Parameters
         *boolean* **$noBuffer:** If set to TRUE, no buffering will be enforced.

   Returns
         array

   Description
         Retrieves defined system languages from database or returns the buffered result if a respective entry was
         found.


.. ###### END~OF~TABLE ######