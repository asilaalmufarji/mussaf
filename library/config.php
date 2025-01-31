<?php
@ob_start();
session_start();
ini_set('display_errors', 'On');
//ob_start("ob_gzhandler");
error_reporting(E_ALL);
// start the session


/*$dsn = "mysql:host=localhost;dbname=sabamarket";
$user = "sabamarket";
$pass = "dania1984";*/
$dsn = "mysql:host=localhost;dbname=ticket;charset=utf8mb4";
$user = "root";
$pass = "";

$option = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);



//========================pdo
try {


	$con = new PDO($dsn, $user, $pass, $option);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//echo "Connect";
} catch (PDOException $e) {
	echo 'Failed To Connect ' . $e->getMessage();
}
//=======================================

// setting up the web root and server root for
// this shopping cart application
$thisFile = str_replace('\\', '/', __FILE__);
$docRoot = $_SERVER['DOCUMENT_ROOT'];
$AdminPath = "admin_employee";
$webRoot  = str_replace(array($docRoot, 'library/config.php'), '', $thisFile);
$srvRoot  = str_replace('library/config.php', '', $thisFile);

define('ADMIN_PATH', $AdminPath);
define('WEB_ROOT', $webRoot);
define('SRV_ROOT', $srvRoot);

ini_set('upload_max_filesize', '200M');
// some size limitation for the category
// and product images

// all category image width must not 
// exceed 75 pixels
define('MAX_CATEGORY_IMAGE_WIDTH', 75);

// do we need to limit the product image width?
// setting this value to 'true' is recommended
define('LIMIT_PRODUCT_WIDTH',     true);

// maximum width for all product image
define('MAX_PRODUCT_IMAGE_WIDTH', 300);

// the width for product thumbnail
define('THUMBNAIL_WIDTH',         75);
/*
if (!get_magic_quotes_gpc()) {
	if (isset($_POST)) {
		foreach ($_POST as $key => $value) {
			$_POST[$key] =  trim(addslashes($value));
		}
	}
	
	if (isset($_GET)) {
		foreach ($_GET as $key => $value) {
			$_GET[$key] = trim(addslashes($value));
		}
	}	
}
*/
// since all page will require a database access
// and the common library is also used by all
// it's logical to load these library here
require_once 'database.php';
require_once 'common.php';

// get the shop configuration ( name, addres, etc ), all page need it
