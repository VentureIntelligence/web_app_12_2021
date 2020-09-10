<?php

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

$image_extensions_notallowed = array('php', 'phtml', 'php3', 'php4','js','shtml','pl','py','exe','ppt');

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

?>