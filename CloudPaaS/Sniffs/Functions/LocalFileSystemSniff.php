<?php

/**
 * CloudPaaS_Sniffs_Functions_LocalFileSystemSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer_CloudPaaS
 * @author    Gaurav Deshmukh <v-gadesh@microsoft.com>
 * @copyright 2011 Copyright © Microsoft Corporation. All Rights Reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version   Release: 1.0.0
 * @link      https://github.com/Interop-Bridges/Cloud-Rules-for-PHP_CodeSniffer
 */

/**
 * CloudPaaS_Sniffs_Functions_LocalFileSystemSniff.
 *
 * Find out the PHP-LocalFileSystem API.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer_CloudPaaS
 * @author    Gaurav Deshmukh <v-gadesh@microsoft.com>
 * @copyright 2011 Copyright © Microsoft Corporation. All Rights Reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version   Release: 1.0.0
 * @link      https://github.com/Interop-Bridges/Cloud-Rules-for-PHP_CodeSniffer
 */

class CloudPaaS_Sniffs_Functions_LocalFileSystemSniff extends
    CloudPaaS_Sniffs_GenericRuleParser
{
    /**
     * Constructor.
     * 
     * Set the default values.
     */
    function __construct()
    {
        // Default function list for FileSystem.//
        // Format: Severity-ErrorType(Error/Warning)-ErrorCode-Function Name.//
        $this->functionList= array (
            '5-error-1001-dio_close',
            '5-error-1002-dio_fcntl',
            '5-error-1003-dio_open',
            '5-error-1004-dio_read',
            '5-error-1005-dio_seek',
            '5-error-1006-dio_stat',
            '5-error-1007-dio_tcsetattr',
            '5-error-1008-dio_truncate',
            '5-error-1009-dio_write',
            '5-error-1010-chdir',
            '5-error-1011-chroot',
            '5-error-1012-dir',
            '5-error-1013-closedir',
            '5-error-1014-getcwd',
            '5-error-1015-opendir',
            '5-error-1016-readdir',
            '5-error-1017-rewinddir',
            '5-error-1018-scandir',
            '5-error-1019-finfo_buffer',
            '5-error-1020-finfo_close',
            '5-error-1021-finfo_file',
            '5-error-1022-finfo_open',
            '5-error-1023-finfo_set_flags',
            '5-error-1024-mime_content_type',
            '5-error-1025-chgrp',
            '5-error-1026-chmod',
            '5-error-1027-chown',
            '5-error-1028-clearstatcache',
            '5-error-1029-copy',
            '5-error-1030-delete',
            '5-error-1031-disk_free_space',
            '5-error-1032-disk_total_space',
            '5-error-1033-diskfreespace',
            '5-error-1034-fclose',
            '5-error-1035-feof',
            '5-error-1036-fflush',
            '5-error-1037-fgetc',
            '5-error-1038-fgetcsv',
            '5-error-1039-fgets',
            '5-error-1040-fgetss',
            '5-error-1041-file_exists',
            '5-error-1042-file_get_contents',
            '5-error-1043-file_put_contents',
            '5-error-1044-file',
            '5-error-1045-fileatime',
            '5-error-1046-filectime',
            '5-error-1047-filegroup',
            '5-error-1048-fileinode',
            '5-error-1049-filemtime',
            '5-error-1050-fileowner',
            '5-error-1051-fileperms',
            '5-error-1052-filesize',
            '5-error-1053-filetype',
            '5-error-1054-flock',
            '5-error-1055-fnmatch',
            '5-error-1056-fopen',
            '5-error-1057-fpassthru',
            '5-error-1058-fputcsv',
            '5-error-1059-fputs',
            '5-error-1060-fread',
            '5-error-1061-fscanf',
            '5-error-1062-fseek',
            '5-error-1063-fstat',
            '5-error-1064-ftell',
            '5-error-1065-ftruncate',
            '5-error-1066-fwrite',
            '5-error-1067-glob',
            '5-error-1068-is_dir',
            '5-error-1069-is_executable',
            '5-error-1070-is_file',
            '5-error-1071-is_link',
            '5-error-1072-is_readable',
            '5-error-1073-is_uploaded_file',
            '5-error-1074-is_writable',
            '5-error-1075-is_writeable',
            '5-error-1076-lchgrp',
            '5-error-1077-lchown',
            '5-error-1078-link',
            '5-error-1079-linkinfo',
            '5-error-1080-lstat',
            '5-error-1081-mkdir',
            '5-error-1082-move_uploaded_file',
            '5-error-1083-parse_ini_file',
            '5-error-1084-parse_ini_string',
            '5-error-1085-pclose',
            '5-error-1086-popen',
            '5-error-1087-readfile',
            '5-error-1088-readlink',
            '5-error-1089-realpath_cache_get',
            '5-error-1090-realpath_cache_size',
            '5-error-1091-realpath',
            '5-error-1092-rename',
            '5-error-1093-rewind',
            '5-error-1094-rmdir',
            '5-error-1095-set_file_buffer',
            '5-error-1096-stat',
            '5-error-1097-symlink',
            '5-error-1098-tempnam',
            '5-error-1099-tmpfile',
            '5-error-1100-touch',
            '5-error-1101-umask',
            '5-error-1102-unlink',
            '5-error-1103-inotify_add_watch',
            '5-error-1104-inotify_init',
            '5-error-1105-inotify_queue_len',
            '5-error-1106-inotify_read',
            '5-error-1107-inotify_rm_watch',
            '5-error-1108-xattr_get',
            '5-error-1109-xattr_list',
            '5-error-1110-xattr_remove',
            '5-error-1111-xattr_set',
            '5-error-1112-xattr_supported',
            '5-error-1113-xdiff_file_bdiff_size',
            '5-error-1114-xdiff_file_bdiff',
            '5-error-1115-xdiff_file_bpatch',
            '5-error-1116-xdiff_file_diff_binary',
            '5-error-1117-xdiff_file_diff',
            '5-error-1118-xdiff_file_merge3',
            '5-error-1119-xdiff_file_patch_binary',
            '5-error-1120-xdiff_file_patch',
            '5-error-1121-xdiff_file_rabdiff',
            '5-error-1122-xdiff_string_bdiff_size',
            '5-error-1123-xdiff_string_bdiff',
            '5-error-1124-xdiff_string_bpatch',
            '5-error-1125-xdiff_string_diff_binary',
            '5-error-1126-xdiff_string_diff',
            '5-error-1127-xdiff_string_merge3',
            '5-error-1128-xdiff_string_patch_binary',
            '5-error-1129-xdiff_string_patch',
            '5-error-1130-xdiff_string_rabdiff',
        );

        $this->message  = "Please consider storing local files data to a ";
        $this->message .= "persistent storage offered by the cloud provider.";
        $this->message .= " Found Function %s";

        // Set function Type.//
        $this->functionType = 'LocalFileSystem';
        
        // Set process data flag to 0.//
        $this->functionData['processFlag'] = 0;
    }
}
?>
