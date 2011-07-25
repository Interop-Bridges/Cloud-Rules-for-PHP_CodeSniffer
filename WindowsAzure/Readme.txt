copyright 2011 Copyright © Microsoft Corporation. All Rights Reserved.
license   http://www.opensource.org/licenses/bsd-license.php BSD License
version   Release: 1.0.0
link      https://github.com/Interop-Bridges/Cloud-Rules-for-PHP_CodeSniffer


CONTENTS OF THIS FILE
---------------------
 * WindowsAzure Functions Sniff
 * Requirement
 * Installation
 * How to Run    
 * Customization


WindowsAzure Functions Sniff    
-----------------------------

WindowsAzure contains the 3 sniff classes each for Local FileSystem, Session and Database API.

1) WindowsAzure.Functions.LocalFileSystem
   This sniff find out PHP-Local FileSystem API which are not stateless and scalable on WindowsAzure platform.


2) WindowsAzure.Functions.Session
   This sniff find out PHP-Session API which are not stateless and scalable on WindowsAzure platform.

3) WindowsAzure.Functions.Database
   This sniff find out PHP-Database API which are not stateless and scalable on WindowsAzure platform.


These are defined in following format.

     Severity-ErrorType-ErrorCode-Function Name

Severity         Integer    Severity for function.(between 0-5)
ErrorType       String     Error Type can be Error or Warning.
ErrorCode        Integer    Error Code for function.(eg.2001,2002)
Function Name    String    This can be either full function name or regular expression for finding match pattern function. (eg.fwrite,mysql_*);

eg. 5-warning-2014-mysql_*,5-error-1026-chmod.

Requirements
------------

Note that the WindowsAzure requires the PHP_CodeSniffer package to be installed in PEAR enviorment. Install the PHP_CodeSniffer using following command.
     pear install PHP_CodeSniffer-1.3.0
or visit the following link for installation.
     http://pear.php.net/package/PHP_CodeSniffer


Installation
------------

1) Download https://github.com/downloads/Interop-Bridges/Cloud-Rules-for-PHP_CodeSniffer/WindowsAzure.zip

2) Unzip WindowsAzure.zip.

3) Copy the WindowsAzure folder and place it under the CodeSniffer/Standard folder of PHP_CodeSniffer installed directory.
 

How to run
----------
If you want to check an entire directory against all WindowsAzure Standard sniff, simply specify the directory path along with standard to phpcs as follows.

phpcs --standard=WindowsAzure /path/to/code

This will run all sniff included in WindowsAzure.

 a) Individual sniff
If you want to check an entire directory against individual sniff, specify sniff name along with standard and directory path as follows.

 phpcs --standard=WindowsAzure --sniff=sniff-name /path/to/code


eg.- To find out only Database function

 phpcs --standard=WindowsAzure --sniff=WindowsAzure.Functions.Database /path/to/code

This will run the only database sniff and find out the PHP-Database API.

For Local FileSystem use WindowsAzure.Functions.LocalFileSystem
For Session use WindowsAzure.Functions.Session.

 b) Multiple sniff
If you want to check an entire directory against multiple sniff, specify sniff names along with standard and directory path as follows.

 phpcs --standard=WindowsAzure --sniff=sniff1,sniff2 /path/to/code


eg.- To find out Database and Session API

 phpcs --standard=WindowsAzure --sniff=WindowsAzure.Functions.Database,WindowsAzure.Functions.Session  /path/to/code


Customization
-------------
You can include WindowsAzure Sniffs in your own standard and override the properties for each sniff in ruleset.xml as follows.

1) Define new function list.
    You can override the default function list defined in sniffs as follows.

<property name="functionList" type="array" value="5-error-2003-fopen,5-warning-2004-fread,5-error-2005-fwrite">
 
 *Value passed to property should be in "Severity-ErrorType-ErrorCode-Function Name" format.

2) Add new functions to the default function list.
    You can add new functions to the default list defined in sniffs using 'addFunctions' property in ruleset.xml as follows,

<property name="addFunctions" type="array" value="5-error-2111-fopen">

 *Value passed to property should be in "Severity-ErrorType-ErrorCode-Function Name" format.

3) Ignore function execution.
    You can ignore the function execution using 'ignoreFunctions' property in ruleset.xml as follows,

<property name="ignoreFunctions" type="array" value="fopen,fwrite">
 
 *Value passed to property should be only Function Name.

4) Find out the functions of particular error codes.
    You can find out the functions with particular error codes using 'errorCodes' property in ruleset.xml as follows,

<property name="errorCodes" type="array" value="2001,2002">

 *Value passed to property should be only Error Codes.

5) Ignore error codes from execution.
    You can ignore the error codes from  execution using 'ignoreCodes' property in ruleset.xml as follows,

<property name="ignoreCodes" type="array" value="fopen,fwrite">

 *Value passed to property should be only Function Name.

6) Show/hide line of code in the error message.
    You can show/hide the line of code in error message output using 'showLineOfCode' property as follows,
    
<property name="showLineOfCode" value="true/false">

By default the value is 'true'.

7) Regular expression match.
    If you want to find the functions using regular expression, then set the 'regxFlag' property value to 'true'.
    
<property name="regxFlag" value="true/false">

By default for LocalFileSystem ,'regxFlag' value is false.
For Database and Session , 'regxFlag' value is true.


Example how to override the Properties
--------------------------------------
You can include the WindowsAzure sniffs into your standards and override the properties for each sniff as follows.

<!-- Include the WindowsAzure.Functions.LocalFileSystem sniff and override the properties--->

<rule ref="WindowsAzure.Functions.LocalFileSystem">
  <properties>

   <!-- Override the default function list.-->    
   <property name="functionList"  type="array" value="5-error-2001-fopen,5-error-2002-fwrite,5-warning-2003-dirname" />

   <!-- Ignore functions from execution.-->    
   <property name="ignoreFunctions"  type="array" value="fopen,dirname" />
    
   <!-- Add new functions to the default function list.-->    
   <property name="addFunctions"  type="array"  value="5-error-2005-fgets" /> 
    
   <!-- Ignore Error Codes from execution.-->    
   <property name="ignoreCodes"  type="array" value="2001,2005" />

   <!--Find out the functions of perticular error codes.-->    
   <property name="errorCodes"  type="array" value="2002" />
    
   <!--Regular expression match.-->    
   <property name="regxFlag" value="false" />

   <!--Show/hide line of code in the error message.-->    
   <property name="showLineOfCode" value="true" />

  </properties>
</rule>
