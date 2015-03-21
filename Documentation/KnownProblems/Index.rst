.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _known-problems:

Known Problems
--------------


.. _problems-domain-ports:

Proper interaction between ports and domains
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

When using non-standard ports (e.g. '8888') you may experience the issue, that the Language Service won't act 
as expected. Actually this doesn't have anything to do with the Language Service itself but the difference 
between RealUrl and the TYPO3 CMS Core in handling domains. While TYPO3 CMS doesn't care about the port and 
therefore needs a domain-only record, RealUrl needs to know about the port for proper URL generation. To 
satisfy both of them, you have to create two domain records – one containing the port 
(e.g. 'www.example.org:8888') and the other containing the pure domain only (e.g. 'www.example.org').

If those two domain records are set, please ensure the option *"Always prepend this domain in links"* is 
unchecked for both of them. Otherwise there may occur conflicts when links are generated.