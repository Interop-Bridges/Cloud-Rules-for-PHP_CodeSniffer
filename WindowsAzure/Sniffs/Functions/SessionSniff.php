<?php

/**
 * WindowsAzure_Sniffs_Functions_SessionSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer_WindowsAzure
 * @author    Gaurav Deshmukh <v-gadesh@microsoft.com>
 * @copyright 2011 Copyright © Microsoft Corporation. All Rights Reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version   Release: 1.0.0
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */


/**
 * WindowsAzure_Sniffs_Functions_SessionSniff.
 *
 * Checks for the PHP-Session API in file.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer_WindowsAzure
 * @author    Gaurav Deshmukh <v-gadesh@microsoft.com>
 * @copyright 2011 Copyright © Microsoft Corporation. All Rights Reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version   Release: 1.0.0
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

class WindowsAzure_Sniffs_Functions_SessionSniff extends
WindowsAzure_Sniffs_GenericRuleParser
{
    /**
     * Constructor
     * 
     * Set the default values.
     */
    function __construct()
    {
        // Default function list for session.//
        // Format: Severity-ErrorType(Error/Warning)-ErrorCode-Function Name.//
        $this->functionList= array (
            '5-error-3001-session_*',
        );

        $this->regxFlag=true;

        //Default messages.//
        $this->message  = "Please register custom session handler using ";
        $this->message .= "SQL Azure or Windows Azure Table.";
        $this->message .= " Found Function %s";

        // Set process data flag to 0.//
        $this->functionData['processFlag'] = 0;
    }
}
?>