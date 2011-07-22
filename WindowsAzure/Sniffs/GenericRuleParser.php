<?php
/**
 * WindowsAzure_Sniffs_GenericRuleParser.
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
 * WindowsAzure_Sniffs_GenericRuleParser.
 *
 * Process the function list data defined in sniff classes.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer_WindowsAzure
 * @author    Gaurav Deshmukh <v-gadesh@microsoft.com>
 * @copyright 2011 Copyright © Microsoft Corporation. All Rights Reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version   Release: 1.0.0
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */


class WindowsAzure_Sniffs_GenericRuleParser implements PHP_CodeSniffer_Sniff
{
    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = array('PHP');

    /**
     * A list of function with severity & type cancatenated with '-'.
     *
     * @var array
     */
    public $functionList = array();

    /**
     * Associated array.
     *
     * @var array
     */
    public $functionData = array();

    /**
     * A list of functions to ignore from default list.
     *
     * @var array
     */
    public $ignoreFunctions = array();

    /**
     * A list of function to add.
     *
     * @var array
     */
    public $addFunctions = array();

    /**
     * Flag for regular expresiion.
     *
     * @var boolean
     */
    public $regxFlag = false;

    /**
     * A list of Error Codes to ignore from default list.
     *
     * @var array
     */
    public $ignoreCodes = array();

    /**
     * A list of Error Codes for filtering the messages.
     *
     * @var array
     */
    public $errorCodes = array();

    /**
     * Error messages.
     *
     * @var array
     */
    public $message = '';

    /**
     * Show the line of code.
     *
     *  @var boolean.
     */
    public $showLineOfCode = true;


    /**
     * Igonore Tokens.
     * @var Array.
     */
    public $ignoreTokens =   array(
                                    T_DOUBLE_COLON,
                                    T_OBJECT_OPERATOR,
                                    T_FUNCTION,
                                    T_CONST,
                                );

    /**
     * Constructor.
     */
    function __construct()
    {
        $this->functionData['processFlag'] = 0;

    }

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_STRING);
    }



    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param integer              $stackPtr  The position of the current token
     *                                        in the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        if ($this->functionData['processFlag'] != 1) {
            $this->createList();
        }
        $this->processToken($phpcsFile, $stackPtr);
    }

    /**
     * Create Associated array with key severity,
     * type & function name.
     *
     * @return void.
     */
    function createList()
    {
        $this->functionData['severity']   = array();
        $this->functionData['errorType']  = array();
        $this->functionData['function']   = array();
        $this->functionData['errorCodes'] = array();
        // If $this->addFunction list is not empty then merge it with defalut one.//
        if (sizeof($this->addFunctions) > 0 ) {
            /*
             * Append all functionList array with addFunctions array.
             */
            $this->functionList
                = array_merge($this->addFunctions, $this->functionList);
        }
        foreach ($this->functionList as $functionVal) {
            $expldVal = explode("-", trim($functionVal));
            $functionName = $expldVal[3];
            // Check if function is already in the processed list or not.//
            if (sizeof($this->functionData['function']) > 0 ) {
                if (in_array($functionName, $this->functionData['function'])) {
                    // If found, then skip the level.//
                    continue;
                }
            }
            $errorCodes   = $expldVal[2];
            $severityVal  = $expldVal[0];
            $errorType    = $expldVal[1];

            // Do not consider the ignore funtion.//
            if (sizeof($this->ignoreFunctions) > 0 ) {
                if (in_array($functionName, $this->ignoreFunctions)) {
                    //Skip the loop.//
                    continue;
                }
            }

            // Do not consider the Error codes present $this->ignoreCodes.//
            if (sizeof($this->ignoreCodes) > 0 ) {
                if (in_array($errorCodes, $this->ignoreCodes)) {
                    //Skip the loop.//
                    continue;
                }
            }
            /*
             * If $this->errorCodes is not null, then consider only
             * functions having errorCode matched to passed errorCodes.
             */
            if (sizeof($this->errorCodes) > 0 ) {
                if (!in_array($errorCodes, $this->errorCodes)) {
                    //Skip the loop.//
                    continue;
                }
            }
            $this->functionData['severity'][]   = $severityVal;
            $this->functionData['errorType'][]  = $errorType;
            $this->functionData['function'][]   = $functionName;
            $this->functionData['errorCodes'][] = $errorCodes;
        }

        /*
         * Set the processFlag to 1.
         * Indicates process for sniff array is completed.
         */
        $this->functionData['processFlag'] = 1;
    }


    /**
     * Process the token to find out the function from php files.
     *
     * @param Object-Array $phpcsFile Object of PHP_CodeSniffer_File.
     *
     * @param int          $stackPtr  position of the current token
     *                                 in the stack passed in $tokens.
     *
     * @return void.
     */

    function processToken($phpcsFile, $stackPtr)
    {
        $error = "";

        // get the tokens in array format. //
        $tokens = $phpcsFile->getTokens();

        // Get the function name. //
        $funcName = $this->getFunction($phpcsFile, $tokens, $stackPtr);
        if ($funcName) {
            $matches = array();
            // Check the function name in Pattern Array using regular expression //
            $matches
                = $this->inPatternMatch($funcName, $this->functionData['function']);
            //Check if match array is greater than Zero & contain value.
            if (sizeof($matches)>0 && $matches[0]) {
                $key = -1;
                // Get the Index.//
                $key=$this->getKeyIndex($matches[0], $funcName);
                // Check if value is set to key or not. //
                if ($key > -1) {
                    // Check if this is type of T_NEW.//
                    $prevToken 
                        = $phpcsFile->findPrevious(
                            T_WHITESPACE, 
                            ($stackPtr - 1), 
                            null, 
                            true
                        );
                    // If previous token is T_NEW, then override the function name.//
                    if ($tokens[$prevToken]['code'] == T_NEW) {
                        $funcName = $funcName."() construct";
                    } else {
                        $funcName = $funcName."()";
                    }
                    // Get the severity from parsed XML data array //
                    $severity  = $this->functionData['severity'][$key];
                    $type      = $this->functionData['errorType'][$key];
                    $errorCode = $this->functionData['errorCodes'][$key];
                    //$message   = $errorCode.":".$this->message."-".$funcName;

                    $message   = $errorCode.":".$this->message;

                    if ($this->showLineOfCode == true) {
                        $lineCode = $this->getLineOfCode($tokens, $stackPtr);
                        $message .= " in the line '".$lineCode."'";
                    }
                    $message .= ".";

                    // Check if type is error or warning.//
                    if ($type == 'error') {
                        // Add this As a Error.//
                        $phpcsFile->addError(
                            $message, $stackPtr, $code = "",
                            $funcName, $severity
                        );
                    } else {
                        // Add this As a Warning.//
                        $phpcsFile->addWarning(
                            $message, $stackPtr, $code = "",
                            $funcName, $severity
                        );
                    }
                }
            }
        }
    }

    /**
     * For Match with Pattterns.
     *
     *@param String $needle   Function name.
     *
     *@param Array  $haystack Array of patterns.
     *
     *@return Array
     */

    function inPatternMatch ($needle, $haystack)
    {
        $matches=array();
        if ($this->regxFlag==true) {
            // For Regular Expression pattern.//
            $master_pattern = "/^(".implode("|", $haystack).")/";
        } else {
            // For Exact Match Pattern.//
            $master_pattern = "/^(".implode("|", $haystack).")$/";
        }
        preg_match($master_pattern, $needle, $matches);
        return $matches;
    }

    /**
     * Get the line of code.
     *
     * @param Array $tokens   Token Array.
     *
     * @param Int   $stackPtr Position of the current token
     *                        in the stack passed in $tokens.
     *
     * @return String.
     */
    function getLineOfCode($tokens,$stackPtr)
    {
        $key = -1;
        // Get the line Start position.//
        $startPos=$stackPtr;
        while ($tokens[$startPos]['line'] == $tokens[$stackPtr]['line']) {
            $startPos--;
        }
        //Get the line ending position.//
        $endPos=$stackPtr;
        while ($tokens[$endPos]['line'] == $tokens[$stackPtr]['line']) {
            $endPos++;
        }
        $lineCode='';
        //Get the line content from startPosition to EndPosition.//
        for ($i=$startPos+1; $i < $endPos-1; $i++) {
            $lineCode .= $tokens[$i]['content'];
            // Remove the WhiteSpace for first content only.//
            if ($i == $startPos+1) {
                $lineCode = trim($lineCode);
            }
        }
        $lineCode = str_replace("%", "%%", $lineCode);
        return $lineCode;
    }

    /**
     * Get the function name from token array.
     *
     * @param Object-Array $phpcsFile Object of PHP_CodeSniffer_File.
     * 
     * @param Array        $tokens    Parsed Token list array.
     *
     * @param Integer      $stackPtr  Stack pointer.
     *
     * @return integer.
     */
    function getFunction($phpcsFile , $tokens, $stackPtr)
    {
        // Find the Next Token.//
        $nextToken = $phpcsFile->findNext(T_WHITESPACE, ($stackPtr + 1), null, true);
        // Check the code of nextToken with ignoreList codes.//
        if (in_array($tokens[$nextToken]['code'], $this->ignoreTokens) === true) {
            // Ignore the PHP function.//
            return;
        }
        $funcName = '';
        // Get the function name.//
        $funcName = trim($tokens[$stackPtr]['content']);
        return $funcName;
    }

    /**
     * Get the key index of matched function from functionlist.
     * 
     * @param String $matchVal Pattern match value.
     *
     * @param String $funcName Function name.
     *
     * @return integer.
     */
    function getKeyIndex($matchVal, $funcName)
    {
        $key = -1;
        if ($this->regxFlag=='true') {
            //For appended with '_'//
            if (in_array(
                $matchVal.'*',
                $this->functionData['function']
            )) {
                /* Check  for pattern in function array */
                $key = array_search(
                    $matchVal.'*',
                    $this->functionData['function']
                );
            }
        } else {
            if (in_array($funcName, $this->functionData['function'])) {
                /* Check  for name in function array */
                $key = array_search(
                    $funcName,
                    $this->functionData['function']
                );
            }
        }
        return $key;
    }

}

?>