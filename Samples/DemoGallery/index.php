<?php
/**
 * Index.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   DemoGallery
 * @author    Sourabh Kulkarni <v-sokulk@microsoft.com>
 * @copyright 2011 Copyright © Microsoft Corporation. All Rights Reserved
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD Licence
 * @version   SVN: 1.0
 * @link      https://github.com/Interop-Bridges/Cloud-Rules-for-PHP_CodeSniffer
 */
session_start();

//load the Gallery class
require_once 'gallery.php';

//create new gallery
$demoGallery = new DemoGallery();
$images  = $demoGallery->setupGallery();

//set UI configuration
$currentPage = @$PHP_SELF ;

// number of items in list
$totalImages = count($images);

// Number of items to show per page
$imagesPerPage = 1;

// Number of items to show either side of selected page
$showPerSide = 5 ;

$message = null; 
$error = null;

$startPage = @$_GET['start'];
if (empty($startPage)) {
    $startPage=0;  // Current start position
}

$maxPages = ceil($totalImages / $imagesPerPage); // Number of pages
$currentPageNo = ceil($startPage / $imagesPerPage)+1; // Current page number

//admin information password md5'ed
$admin = array('admin'=>'21232f297a57a5a743894a0e4a801fc3'); //password is 'admin'

//Authonticate user
if (isset($_POST['login'])) {
    if (@$admin[@$_POST['login']] == md5(@$_POST['password'])) {
        @$_SESSION['login'] = $_POST['login'];
    } else {         //Login Failed
        $error = "Login failed";
    }
}
//process logoff
if (isset($_GET['logoff'])) {
    session_destroy();   //destroy session
    header('Location:  ' . $_SERVER['PHP_SELF']);
}

//handle picture upload
if (isset($_POST['uploadPic'])) {
    if (@$_POST['overwrite']=='yes') {
        $demoGallery->setOverritePic(true);
    }
    $message =  $demoGallery->addToGallery($_FILES['picture']);
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Demo Gallery</title>
<link href="gallery.css" type="text/css" rel="stylesheet" media="screen" />
</head>
<body>
<?php if (@$_SESSION['login']) { ?>
    <p align="left">
        You are logged in as <b><?php echo $_SESSION['login'];?> </b> | <a
            href="?logoff=1">Logoff</a>
    </p>
    <!-- Show form to upload pictures -->
    <span class="curpage"><?php echo $message; ?></span>
    <form encType=multipart/form-data method=post 
    action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type=file name=picture> <br /> 
    <input value="Upload Picture" type="submit" name="uploadPic"> 
    Overwrite <input type="checkbox" name="overwrite" value="yes"> <br /> 
    **Upload picture with extension "jpg" or "jpeg" or "gif" or "png"
    </form>
    <?php 
} else {
    ?>
    <p align="left">
        <a href="?goadmin=1">Admin Area</a>
    </p>
    <?php
}
if (isset($_GET['goadmin']) && !isset($_SESSION['login'])) {
    ?>
    <!-- show login form -->
    <p align="left">
        <span class="curpage"><?php echo $error; ?> </span>
        <form name="login" action="" method="post">
        Username: <input type="text" name="login" value="" /><br /> 
        Password:&nbsp;<input type="password" name="password" value="" /><br /> 
        <input type="submit" name="submit" value="Login" />
        </form>
    </p>
    <?php
}//end of login form
?>
<h1 align="center">Demo Gallery</h1>
<table width="400" border="0" align="center" cellpadding="0"
    cellspacing="0">
    <tr>
        <td width="80" align="center" valign="middle" bgcolor="#EAEAEA">
<?php
if (($startPage-$imagesPerPage) >= 0) {
    $next = $startPage-$imagesPerPage;
    ?> 
    <a href="<?php print("$currentPage".($next>0?("?start=").$next:""));?>">
    Previous
    </a>
    <?php
}
?>  
        </td>
        <td width="271" align="center" valign="middle">
        Page <?php print($currentPageNo);?>
        of <?php print($maxPages);?><br>
        ( <?php print($totalImages);?> pictures )</td>
        <td width="50" align="center" valign="middle" bgcolor="#EAEAEA">
        <?php 
if ($startPage+$imagesPerPage<$totalImages) {
    ?> 
    <a 
    href="<?php print("$currentPage?start=".max(0, $startPage+$imagesPerPage));?>">
    Next
    </a>
    <?php
}
?>
        </td>
    </tr>
    <tr>
        <td colspan="3" align="center" valign="middle">&nbsp;</td>
    </tr>

    <tr>
        <td colspan="3" align="center">
<?php
for ($x=$startPage; $x<min($totalImages, ($startPage+$imagesPerPage)); $x++) {
    print ("<img src='".$images[$x]."' border='0' width='510' height='380'><br>");
};
?>
        </td>
    </tr>
    <tr>
        <td colspan="3" align="center" valign="middle">&nbsp;</td>
    </tr>
    <tr>
        <tr>
            <td colspan="3" align="center" valign="middle">
<?php 
$bothSide = ($showPerSide * $imagesPerPage);
if ($startPage+1 > $bothSide) {
    print (" .... ");
}
$pg=1;
for ($y=0; $y<$totalImages; $y+=$imagesPerPage) {
    $class=($y==$startPage)?"curpage":"";
    if (($y > ($startPage - $bothSide)) && ($y < ($startPage + $bothSide))) {
        ?> &nbsp;
        <a class="<?php print($class);?>"
                href="<?php print("$currentPage".($y>0?("?start=").$y:""));?>">
        <?php print($pg);?>
        </a>
        &nbsp;
        <?php
    }
    $pg++;
}
if (($startPage+$bothSide)<$totalImages) {
    print (" .... ");
}
?>
            </td>
        </tr>

</table>
</body>
</html>
