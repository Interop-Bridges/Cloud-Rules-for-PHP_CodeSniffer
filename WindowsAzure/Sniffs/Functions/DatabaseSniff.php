<?php

/**
 * WindowsAzure_Sniffs_Functions_DatabaseSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer_WindowsAzure
 * @author    Gaurav Deshmukh <v-gadesh@microsoft.com>
 * @copyright 2011 Copyright © Microsoft Corporation. All Rights Reserved
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version   Release: 1.0.0
 * @link      https://github.com/Interop-Bridges/Cloud-Rules-for-PHP_CodeSniffer
 */

/**
 * WindowsAzure_Sniffs_Functions_DatabaseSniff.
 *
 * Find out the PHP-Database API.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer_WindowsAzure
 * @author    Gaurav Deshmukh <v-gadesh@microsoft.com>
 * @copyright 2011 Copyright © Microsoft Corporation. All Rights Reserved
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version   Release: 1.0.0
 * @link      https://github.com/Interop-Bridges/Cloud-Rules-for-PHP_CodeSniffer
 */

class WindowsAzure_Sniffs_Functions_DatabaseSniff extends
WindowsAzure_Sniffs_GenericRuleParser
{
    /**
     * Constructor
     * 
     * Set the default values.
     */
    function __construct()
    {
        // Default function list for database.//
        // Format: Severity-ErrorType(Error/Warning)-ErrorCode-Function Name.//
        $this->functionList= array (
            '5-error-2001-cubrid_*',
            '5-error-2002-dbase_*',
            '5-error-2003-dbplus_*',
            '5-error-2004-fbsql_*',
            '5-error-2005-filepro_*',
            '5-error-2006-ibase_*',
            '5-error-2007-ifx_*',
            '5-error-2008-db2_*',
            '5-error-2009-ingres_*',
            '5-error-2010-maxdb_*',
            '5-error-2011-bson_*',
            '5-error-2012-msql_*',
            '5-error-2013-mssql_*',
            '5-error-2014-mysql_*',
            '5-error-2015-mysqli*',
            '5-error-2016-mysqlnd_*',
            '5-error-2017-mysqlnd_ms_*',
            '5-error-2018-mysqlnd_qc_*',
            '5-error-2019-oci*',
            '5-error-2020-ovrimos*',
            '5-error-2021-px_*',
            '5-error-2022-pg_*',
            '5-error-2023-sqlite_*',
            '5-error-2024-SQLite3*',
            '5-error-2025-sybase_*',
            '5-error-2026-TokyoTyrant*'
            );

           $this->regxFlag=true;

           $this->message  = "Windows Azure platform does not support this ";
           $this->message .= "database.Please use PHP PDO and migrate to SQL Azure.";
           $this->message .= " Found Function %s";

           // Set process data flag to 0.//
           $this->functionData['processFlag'] = 0;

    }

}
?>
