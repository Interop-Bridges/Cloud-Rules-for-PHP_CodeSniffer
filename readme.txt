Cloud-Rules-for-PHP_CodeSniffer
===============================
The cloud rules for PHP_CodeSniffer assist the PHP developer in developing new application 
designed to scale when hosted in the cloud. It can also be used for analyzing existing on 
premises code that needs to be refactored for scalability. 

A cloud platform supporting PaaS is able to scale a PHP application designed to be scalable 
based on its traffic needs and makes the overall administration easier by shielding the 
developer from hardware failures and infrastructure management. These applications should 
not maintain their state themselves between requests. All the PHP functions that work with 
local file system, session memory and DB should use instead the storage capabilities offered 
by the cloud platform to ensure that applications are stateless and therefore scalable.  

In the same way a scalable Windows Azure application should not create an affinity with a 
particular role instance as there’s no guarantee that multiple requests from the same user 
will be sent to the same instance. Instead, any client-specific state should be written 
to Windows Azure storage, stored in SQL Azure Database, or maintained externally in some other way. 

This package contains:
-	A set of generic Platform as a Service rules for PHP_CodeSniffer located in the CloudPaaS folder.
-	A set of Windows Azure rules for PHP_CodeSniffer that takes into consideration the custom storage 
        offered by Windows Azure and located in the WindowsAzure folder.
-	A PHP sample application that uses local file system and the correspondent redesigned for scalability 
        version located in the Samples\DemoGallery folder. 
-	A PHP sample application that is stateless Samples\DemoWindowsAzureGallery folder. 

The advantage of the static analysis is that developer gets feedback the earliest coding phase 
without having to deploy the code in the cloud. On the other side static analysis is not 
identifying the whole code stack and the rules may generate false positives or may as well 
miss issues due to usage of reflection or usage of file paths as URIs in stream functions or 
usage of other PECL extensions. To control the false positives the sniffs provide different error 
messages, severity or warning/error level depending on the PHP community needs or the targeted 
Cloud Provider.

We are hoping that the Cloud PHP_CodeSniffer rules will be extended with new custom rules from other 
cloud providers. 

How to run the PHP_CodeSniffer rules
===============================
Installation
------------
Please refer to the readme.txt files for installing CloudPaaS or WindowsAzure sniffs and additional examples.

Run the sniffs against generic Cloud Provider rules:
----------------------------------------------------
    phpcs --standard=CloudPaaS  <your PHP application root >

Download demoGallery from https://github.com/Interop-Bridges/Cloud-Rules-for-PHP_CodeSniffer/Samples/DemoGallerySample into <Your Project folder >
    phpcs --standard=CloudPaaS demoGallery

Scoping the analysis to selected sniffs:
    phpcs --standard=CloudPaaS --sniffs=CloudPaaS.Functions.Session demoGallery
    phpcs --standard=CloudPaaS --sniffs=CloudPaaS.Functions.LocalFileSystem,CloudPaaS.Functions.Session demoGallery 

Run the sniffs against Windows Azure rules:
-------------------------------------------
    phpcs --standard=CloudPaaS  <your PHP application root >

Download demoGallery from https://github.com/Interop-Bridges/Cloud-Rules-for-PHP_CodeSniffer/Samples/DemoGallerySample into <Your Project folder >

    phpcs --standard=WindowsAzure  demoGallery 

Both CloudPaaS and WindowsAzure sniff sets cover the PHP functions that work with local file 
system and DB and store session information into memory. The only difference between the 
two sets is the error message and the severity of the errors as well as what is 
considered error versus what is considered warning.

The PHP developer targeting a cloud platform with support for certain databases could exclude 
those databases from the analysis either by updating the ruleset.xml file either by filtering 
the sniffs from command line.
