<?php

/**
 * CloudPaaS_Sniffs_Functions_SessionSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer_CloudPaaS
 * @author    Gaurav Deshmukh <v-gadesh@microsoft.com>
 * @copyright 2011 Copyright © Microsoft Corporation. All Rights Reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version   Release: 1.0.0
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
 

/**
 * CloudPaaS_Sniffs_Functions_SessionSniff.
 *
 * Find Out the PHP-Session API.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer_CloudPaaS
 * @author    Gaurav Deshmukh <v-gadesh@microsoft.com>
 * @copyright 2011 Copyright © Microsoft Corporation. All Rights Reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version   Release: 1.0.0
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

class CloudPaaS_Sniffs_Functions_SessionSniff extends
CloudPaaS_Sniffs_GenericRuleParser
{
    /**
     * Constructor.
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
        $this->message  = "Please register custom session handler that ";
        $this->message .= "stores session data to a persistent storage offered ";
        $this->message .= "by the cloud provider.";
        $this->message .= " Found Function %s";
        
        // Set function Type.//
        $this->functionType = 'Session';
        
        // Set process data flag to 0.//
        $this->functionData['processFlag'] = 0;
    } 
}
?>
