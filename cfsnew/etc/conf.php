<?php
//this configuration file only for areapedia
//ini_set("display_errors", true);
//Increase the memory size
ini_set('memory_limit', '1024M');
//ini_set("max_execution_time", 1000);

//error_reporting(E_ALL ^ E_NOTICE);


error_reporting(1);


$path_parts = pathinfo(__FILE__);
//print_r($path_parts);
$DIR_PATH =  dirname($path_parts['dirname']);

$WRK_HTTP_HOST=$_SERVER["HTTP_HOST"];
//$DIR_PATH =  dirname($path_parts['basename']);
//$DIR_PATH =  $path_parts['basename'];
//$DIR_PATH = '.';
//echo $DIR_PATH;

$SITE_NAME = '/dev/cfs-old/';
$COMMON_SITE_PATH = '//'.$WRK_HTTP_HOST.$SITE_NAME;
$CDN_PATH = '//'.$WRK_HTTP_HOST.$SITE_NAME;
$PUBLICHTML_PATH = $DIR_PATH;


$DB_DATABASE_TYPE = "mysql"; //db type
//$DB_SERVER = "66.96.131.34"; //your ip
$DB_SERVER = "localhost";
$DB_USER = "venturei_admin16";
$DB_PASSWORD = "%KTbNCJ@mO^iM9#c";
//$DB_SERVER = "localhost";
//$DB_USER = "venture_admin"; //your db user name
//$DB_PASSWORD = "Admin2014"; // your db password


//$DB_USER = "venture_admin16"; //your db user name
//$DB_PASSWORD = "V@dm!n2016"; // your db password
/* For local DB
$DB_SERVER = "localhost";
$DB_USER = "root"; 
$DB_PASSWORD = "root@123"; */


$DB_DATABASE_NAME = "venturei_dev_new"; //your db name

switch ($WRK_HTTP_HOST) 
{
case "www.ventureintelligence.in":
case "ventureintelligence.in":
case "www.ventureintelligence.com":
case "ventureintelligence.com":
case "ventureintelligence.asia":
case "www.ventureintelligence.asia":
case "localhost":
	// If we are not using Virtual Hosts
	define('WEB_ROOT','/');
	define('WEB_DIR',WEB_ROOT.'cfsnew/');
	define('WEB_ADMIN_DIR',WEB_DIR.'admin/'); 

	define('SITE_PATH','//'.$WRK_HTTP_HOST.$SITE_NAME);
	define('MEDIA_PATH','//'.$WRK_HTTP_HOST.$SITE_NAME.'media/');
	define('MAIN_SITE_ROOT','//'.$WRK_HTTP_HOST.'/');//http path
	define('APP_NAME','');
	define('MAIN_PATH',$PUBLICHTML_PATH);
	define('ROOT_FOLDER_CREATE_PATH',$PUBLICHTML_PATH); 
	define('FOLDER_CREATE_PATH',$_SERVER['DOCUMENT_ROOT']."/dev/cfs-old/media/"); 
	define('DOMAIN',$WRK_HTTP_HOST);
	define('SITE_IMAGES_PATH',SITE_PATH.'images/');
	
	define('ADMIN_SITE_PATH','//'.$WRK_HTTP_HOST.$SITE_NAME.'admin/');
	define('ADMIN_JS_PATH','//'.$WRK_HTTP_HOST.$SITE_NAME.'admin/js/');
	define('ADMIN_CSS_PATH','//'.$WRK_HTTP_HOST.$SITE_NAME.'admin/css/');
	
/*Webulb Paths Starts*/ //Site name can dynamic...changable
	define('COMMON_SITE_PATH',$CDN_PATH);
	define('COMMON_IMAGE_PATH',$CDN_PATH);//'http://clawdigital-background.webulb.netdna-cdn.com/backgrounds/');
	define('COMMON_CSS_PATH',$CDN_PATH.'/css/');
	define('COMMON_JS_PATH',$CDN_PATH.'/js/');
/*Webulb Paths Ends*/
	
	break;


default:
	// If we are using Virtual Hosts
	define('WEB_ROOT','/');
	define('WEB_DIR',WEB_ROOT.'');
	define('WEB_ADMIN_DIR',WEB_DIR.'areaAdmin/');
	break;
}

define('DEFAULT_LANGUAGE','en'); 
define('DEFAULT_EMAIL','testingmail@gmail.com');
define('WEB_TITLE_HEADER','Header ');

/*Database Conectivity Starts*/
define('DB_DATABASE_TYPE',$DB_DATABASE_TYPE);
define('DB_SERVER',$DB_SERVER);
define('DB_USER',$DB_USER);
define('DB_PASSWORD',$DB_PASSWORD);
define('DB_DATABASE_NAME',$DB_DATABASE_NAME);
/*Database Conectivity Ends*/

//set_include_path($DIR_PATH);
require_once MAIN_PATH.APP_NAME."/etc/conf.d/05_paths.php";
require_once MAIN_PATH.APP_NAME."/etc/conf.d/15_smarty.php";
require_once MAIN_PATH.APP_NAME."/etc/conf.d/20_logs.php";
require_once MAIN_PATH.APP_NAME."/etc/conf.d/30_authSession.php";
require_once MAIN_PATH.APP_NAME."/etc/conf.d/35_phpmailer.php";

define('BASE_URL','//www.ventureintelligence.asia/dev/');
define('ADMIN_BASE_URL','//www.ventureintelligence.asia/dev/cfsnew/admin/');

$UploadImageSizes = array(
					"medium" => array("Width"=>"600","Height"=>"300","Crop"=>true),
					"thumb"  => array("Width"=>"160","Height"=>"75","Crop"=>true),												
					);

?>
