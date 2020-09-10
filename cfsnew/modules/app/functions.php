<?php

function ddmmyyyy($date) {

	$pieces = explode('/',$date);
	$newDate = $pieces[2].'-'.$pieces[1].'-'.$pieces[0];
	return $newDate;
}

function yyyymmdd($date) {

	$pieces = explode('-',$date);
	$newDate = $pieces[2].'/'.$pieces[1].'/'.$pieces[0];
	return $newDate;
}

function pr($array) {
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}

function pager($page,$rows,$totalItems) {
	$totalPages = ceil($totalItems/$rows);
	$pages = array();
	$pages['first'] = 1;
	$pages['last'] = $totalPages;
	if($totalPages == 1) {
		$pages['next'] = 0 ;
		$pages['previous'] = 0;
		$pages['first'] = 0;
		$pages['last'] = 0;
	} else if($page == 1) {
		$pages['next'] = ($page+1) ;
		$pages['previous'] = 0;
		$pages['first'] = 0;
	} else if($page == $totalPages) {
		$pages['next'] = 0;
		$pages['previous'] = ($page - 1) ;
		$pages['last'] = 0;
	} else {
		$pages['next'] = ($page + 1);
		$pages['previous'] = ($page - 1) ;
	}	
	return $pages;
}

function scaleImage($image,$width,$height,$scale) {
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	$source = imagecreatefromjpeg($image);
	imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
	imagejpeg($newImage,$image,90);
	chmod($image, 0777);
	return $image;
}

function getHeight($image) {
	$size = array_values(getimagesize($image));
	list($width,$height,$type,$attr) = $size;
	return $height;
}

function getWidth($image) {
	$size = array_values(getimagesize($image));
	list($width,$height,$type,$attr) = $size;
	return $width;
}


function createRandomString($len){
		$str= NULL;
		$seed="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		$seed_len = strlen($seed);
		for ($i=0;$i<$len;$i++){
			$e = rand(0, $seed_len-1);
			$str .= $seed[$e];
		}
		
		return $str;
	}
function is_valid_email($email) 
	{
  			return preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si', $email);
	}
	

function ImageValid($file_name,$fileTempName){

$mime = array('image/gif' => 'gif',
                  'image/jpeg' => 'jpeg',
                  'image/png' => 'png',
                  'application/x-shockwave-flash' => 'swf',
                  'image/psd' => 'psd',
                  'image/bmp' => 'bmp',
                  'image/tiff' => 'tiff',
                  'image/tiff' => 'tiff',
                  'image/jp2' => 'jp2',
                  'image/iff' => 'iff',
                  'image/vnd.wap.wbmp' => 'bmp',
                  'image/xbm' => 'xbm',
                  'image/vnd.microsoft.icon' => 'ico');

$image_extensions_notallowed = array('php', 'phtml', 'php3', 'php4','js','shtml','pl','py','exe','ppt','bmp','ico','xbm','jp2','iff','tiff','swf');

	$RsMIME = mimiCheck($file_name,$fileTempName,$mime);
	$RSAEXTChceck = AllowedExtCheck($file_name,$image_extensions_notallowed);
	if($RsMIME == 0 || $RSAEXTChceck == 0){
		return	$Token = 0;//0=>false;
	}else{
		return  $Token = 1;//1=>true;
	}
}

function ExcelValid($file_name,$fileTempName){

$mime = array('application/vnd.ms-excel' => 'xls');

$image_extensions_notallowed = array('php', 'phtml', 'php3', 'php4','js','shtml','pl','py','exe','ppt','bmp','ico','xbm','jp2','iff','tiff','swf');

	$RsMIME = mimiCheck($file_name,$fileTempName,$mime);
	$RSAEXTChceck = AllowedExtCheck($file_name,$image_extensions_notallowed);
	if($RsMIME == 0 || $RSAEXTChceck == 0){
		return	$Token = 0;//0=>false;
	}else{
		return  $Token = 1;//1=>true;
	}
}



function mimiCheck($file_name,$fileTempName,$mime){
		if(!empty($file_name)){
			$file_name = $file_name;
			$file_info = getimagesize($fileTempName);
			$ext = strtolower(substr(strrchr($file_name, "."), 1));

				if(!empty($file_info)){
					  $Token = "1"; //1=>True
					  return $Token;
				}else{
					$Token = "0"; //0=>false
					return $Token;
				}
		}else{
		    $Token = "0"; //0=>false
			return $Token;
		}

}

function AllowedExtCheck($file_name,$image_extensions_notallowed){
	if(!empty($file_name)){
		$ext = strtolower(substr(strrchr($file_name, "."), 1));
			 if(!in_array($ext, $image_extensions_notallowed)){
  				  $Token = "1"; //1=>True
				  return $Token;
			 }else{
  				  $Token = "0"; //0=>false
				  return $Token;
			 }
	}else{
  				  $Token = "0"; //0=>false
				  return $Token;
	}
}
	
function GetImageName($imageFileName) {
	$imageFileName = basename($imageFileName);
	$imageFileName = str_replace(" ","",$imageFileName);
	$imageFileName = str_replace("'","",$imageFileName);
	$imageFileName = explode(".",$imageFileName);
	$md = md5($imageFileName[0]);
	$Enc = time().$md;
	$Expsplit = ".".$imageFileName[1];
	$ImageName = $Enc.$Expsplit;
	return $ImageName;
}


function getImgPath($Key,$imageFileName,$LowerCase,$FolderName) {
			$strDynamicPath = FOLDER_CREATE_PATH.$LowerCase.'/'.$FolderName."/";
			$strDynamicPath = $strDynamicPath.$Key."/".$imageFileName;
			return $strDynamicPath;
}
	

$GroupCStaus = array("1" =>"Parent Company",
					 "2" =>"Group Company",
					);
$ListingStatus = array(//"1" =>"Listed",
					  "2" =>"UnListed",
					);

	
?>