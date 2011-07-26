<?php

/**
 * CloudPaaS_Sniffs_Functions_DatabaseSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer_CloudPaaS
 * @author    Gaurav Deshmukh <v-gadesh@microsoft.com>
 * @copyright 2011 Copyright © Microsoft Corporation. All Rights Reserved
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version   Release: 1.0.0
 * @link      https://github.com/Interop-Bridges/Cloud-Rules-for-PHP_CodeSniffer
 */

/**
 * CloudPaaS_Sniffs_Functions_DatabaseSniff.
 *
 * Find out the PHP-Database API.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer_CloudPaaS
 * @author    Gaurav Deshmukh <v-gadesh@microsoft.com>
 * @copyright 2011 Copyright © Microsoft Corporation. All Rights Reserved
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version   Release: 1.0.0
 * @link      https://github.com/Interop-Bridges/Cloud-Rules-for-PHP_CodeSniffer
 */

class CloudPaaS_Sniffs_Functions_DatabaseSniff extends
CloudPaaS_Sniffs_GenericRuleParser
{
    /**
     * Constructor.
     * 
     * Set the default values.
     */
    function __construct()
    {
        // Default function list for database.//
        // Format: Severity-ErrorType(Error/Warning)-ErrorCode-Function Name.//
        $this->functionList= array (
            '5-warning-2001-cubrid_*',
            '5-warning-2002-dbase_*',
            '5-warning-2003-dbplus_*',
            '5-warning-2004-fbsql_*',
            '5-warning-2005-filepro_*',
            '5-warning-2006-ibase_*',
            '5-warning-2007-ifx_*',
            '5-warning-2008-db2_*',
            '5-warning-2009-ingres_*',
            '5-warning-2010-maxdb_*',
            '5-warning-2011-bson_*',
            '5-warning-2012-msql_*',
            '5-warning-2013-mssql_*',
            '5-warning-2014-mysql_*',
            '5-warning-2015-mysqli*',
            '5-warning-2016-mysqlnd_*',
            '5-warning-2017-mysqlnd_ms_*',
            '5-warning-2018-mysqlnd_qc_*',
            '5-warning-2019-oci*',
            '5-warning-2020-ovrimos*',
            '5-warning-2021-px_*',
            '5-warning-2022-pg_*',
            '5-warning-2023-sqlite_*',
            '5-warning-2024-SQLite3*',
            '5-warning-2025-sybase_*',
            '5-warning-2026-TokyoTyrant*'
        );
            
        $this->regxFlag=true;
        
        $this->message  = "Please consider using PHP PDO for database access.";
        $this->message .= " Found Function %s";
        
        // Set process data flag to 0.//
        $this->functionData['processFlag'] = 0;
        
    }
    
}
?>
