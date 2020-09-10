<?
/********************************************************************************************************************
*	SCRIPT TYPE: Class  																							*											
*	SCRIPT NAME: ThumbNail Image Cropper																			*	
*	DESCRIPTION: Image Cropper Functions                                                                            *
*	AUTHOR: phpAshok			                                                                                   	*			
*	WRITTEN ON: 26-Jul-2006                                                                                      	*	
*	LAST MODIFIED ON: 26-Jul-2006                                                                                	*	
*   COPYRIGHT: http://www.securenext.com																			*	
********************************************************************************************************************/
class CropThumbNail {
	var $errmsg;				//error message to parse
	var $error;					//flag for whether there is an error
	var $format;				//file format of image
	var $currentDimensions;		//current dimensions of working image
	var $newDimensions;			//new dimensions after manipulation
	var $newImage;				//final image to be displayed/saved
	var $oldImage;				//original image to be manipulated
	var $workingImage;			//working image being manipulated
	var $fileName;				//filename of image, can include directory
	var $cropW;					//maximum width of the crop image
	var $cropH;					//maximum height of the crop image
	var $percent;				//percentage of the original image size
	var $quality;				//image quality of jpeg images
	var $cropSize;				//size in px to crop from the center of the image (crop is always square)
	var $cropX;					
	var $cropY;
	var $maxWidth;
	var $maxHeight;
	
	function CropThumbNail() {
		$this->errmsg 				= '';
		$this->error 				= false;
		$this->format 				= '';
		$this->currentDimensions 	= array();
		$this->newDimensions 		= array();
		$this->fileName 			= '';
		$this->maxWidth 			= 0;
		$this->maxHeight 			= 0;
		$this->percent 				= 0;
		$this->quality 				= 60;
		$this->cropSize 			= 0;
		$this->cropX 				= 0;
		$this->cropY 				= 0;
		$this->cropW 				= 0;
		$this->cropH				= 0;
	}
	
	function init() {
		//initialize function that does basic error checking and determines file type
		//check to see if file exists
		if(!file_exists($this->fileName)) {
			$this->errmsg = "File not found";
			$this->error = true;
		}
		//check to see if file is readable
		elseif(!is_readable($this->fileName)) {
			$this->errmsg = "File is not readable";
			$this->error = true;
		}
		//determine file extension
		if($this->error == false) {
			//check if gif
			if(stristr(strtolower($this->fileName),'.gif')) 
				$this->format = 'GIF';
			//check if jpeg
			elseif(stristr(strtolower($this->fileName),'.jpg') || stristr(strtolower($this->fileName),'.jpeg')) 
				$this->format = "JPG";
			//check if png
			elseif(stristr(strtolower($this->fileName),'.png')) 
				$this->format = 'PNG';
			//unknown file format
			else {
				$this->errmsg = "Unknown file format";
				$this->error = true;
			}
		}
		//catch user forgetting to specify size paramenters
		if($this->cropW == 0 && $this->cropH == 0 && $this->percent == 0) 
			$this->percent = 100;
		if($this->error == false) {
			switch($this->format) {
				case "GIF":
					$this->oldImage = ImageCreateFromGif($this->fileName);
					break;
				case "JPG":
					$this->oldImage = ImageCreateFromJpeg($this->fileName);
					break;
				case "PNG":
					$this->oldImage = ImageCreateFromPng($this->fileName);
					break;
			}
			$size = GetImageSize($this->fileName);
			$this->currentDimensions = array("width"=>$size[0],"height"=>$size[1]);
			$this->newImage = $this->oldImage;
		}
		if($this->error) {
			$this->showErrorImage();
			break;
		}
	}
	
	function calcWidth($width,$height) {
		$newWP = (100 * $this->maxWidth) / $width;
		$newHeight = ($height * $newWP) / 100;
		return array("newWidth"=>intval($this->maxWidth),"newHeight"=>intval($newHeight));
	}
	
	function calcHeight($width,$height) {
		$newHP = (100 * $this->maxHeight) / $height;
		$newWidth = ($width * $newHP) / 100;
		return array("newWidth"=>intval($newWidth),"newHeight"=>intval($this->maxHeight));
	}

	function calcPercent($width,$height) {
		$newWidth = ($width * $this->percent) / 100;
		$newHeight = ($height * $this->percent) / 100;
		return array("newWidth"=>intval($newWidth),"newHeight"=>intval($newHeight));
	}	

    function calcImageSize($width,$height) {
		$newSize = array("newWidth"=>$width,"newHeight"=>$height);
		
		if($this->maxWidth > 0 && $width > $this->maxWidth) {
			$newSize = $this->calcWidth($width,$height);
			
			if($this->maxHeight > 0 && $newSize['newHeight'] > $this->maxHeight)
				$newSize = $this->calcHeight($newSize['newWidth'],$newSize['newHeight']);
			
			$this->newDimensions = $newSize;
		}
		
		if($this->maxHeight > 0 && $height > $this->maxHeight) {
			$newSize = $this->calcHeight($width,$height);
			
			if($this->maxWidth > 0 && $newSize['newWidth'] > $this->maxWidth) {
				$newSize = $this->calcWidth($newSize['newWidth'],$newSize['newHeight']);
			}
			
			$this->newDimensions = $newSize;
		}
		
		//if($this->percent > 0) {
			$newSize = $this->calcPercent($width,$height);
			$this->newDimensions = $newSize;
		//}
	}
	
	#######################################
	#----- Show Error Image Function -----#
	#######################################
	function showErrorImage() {
		//output an error image to the user
		header("Content-type: image/png");
		$errImg = ImageCreate(220,25);
		$bgColor = ImageColorAllocate($errImg,0,0,0);
		$fgColor1 = ImageColorAllocate($errImg,255,255,255);
		$fgColor2 = ImageColorAllocate($errImg,255,0,0);
		ImageString($errImg,3,6,6,"ERROR:",$fgColor2);
		ImageString($errImg,3,55,6,$this->errmsg,$fgColor1);
		ImagePng($errImg);
		ImageDestroy($errImg);
	}
	
	##########################################
	#----- Image Manipulation Functions -----#
	##########################################
	function crop() {
		$cropX = $this->cropX;
		$cropY = $this->cropY;
		if(function_exists("ImageCreateTrueColor")) {
			$this->workingImage = ImageCreateTrueColor($this->cropW,$this->cropH);
		}
		else {
			$this->workingImage = ImageCreate($this->cropW,$this->cropH);
		}
		
		ImageCopy($this->workingImage,$this->oldImage,0,0,$this->cropX,$this->cropY,$this->cropW,$this->cropH);
		
		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $this->cropX;
		$this->currentDimensions['height'] = $this->cropY;
	}
	
	##########################################
	#----- Image Display/Save Functions -----#
	##########################################
	function save($name) {
		$this->show($name);
	}
	
	function show($name='') {
		
		switch($this->format) {
			case "GIF":
				if($name != '') {
					ImageGif($this->newImage,$name);
				}
				else {
					header("Content-type: image/gif");
					ImageGif($this->newImage);
				}
				break;
			case "JPG":
				if($name != '') {
					ImageJpeg($this->newImage,$name,$this->quality);
				}
				else {
					header("Content-type: image/jpeg");
					ImageJpeg($this->newImage,'',$this->quality);
				}
				break;
			case "PNG":
				if($name != '') {
					ImagePng($this->newImage,$name);
				}
				else {
					header("Content-type: image/png");
					ImagePng($this->newImage,$name);
				}
				break;
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////						******************* Create Thumb Image **********************	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function create_thumbnail($infile,$outfile,$maxw,$maxh,$stretch = FALSE) {
		clearstatcache();
		if (!is_file($infile)) {
			@trigger_error("Cannot open file: $infile",E_USER_WARNING);
			return FALSE;
		}
		if(is_file($outfile)) {
			@trigger_error("Output file already exists: $outfile",E_USER_WARNING);
			return FALSE;
		}
		$functions = array(
		'image/png' => 'ImageCreateFromPng',
		'image/jpeg' => 'ImageCreateFromJpeg',
		);
		// Add GIF support if GD was compiled with it
		if (function_exists('ImageCreateFromGif')){ 
			$functions['image/gif'] = 'ImageCreateFromGif'; 
		}
		$size = getimagesize($infile);
		// Check if mime type is listed above
		if (!$function = $functions[$size['mime']]) {
		  	trigger_error("MIME Type unsupported: {$size['mime']}",E_USER_WARNING);
			return FALSE;
		}
		// Open source image
		if (!$source_img = @$function($infile)) {
		  	@trigger_error("Unable to open source file: $infile",E_USER_WARNING);
			return FALSE;
		}
		$save_function = "image" . strtolower(substr(strrchr($size['mime'],'/'),1));
		// Scale dimensions
		list($neww,$newh) = $this->scale_dimensions($size[0],$size[1],$maxw,$maxh,$stretch);
		if ($size['mime'] == 'image/png') {
			// Check if this PNG image is indexed
			$temp_img = imagecreatefrompng($infile);
			if (imagecolorstotal($temp_img) != 0) {
		  		// This is an indexed PNG
		  		$indexed_png = TRUE;
			}else{
		  		$indexed_png = FALSE;
			}
			imagedestroy($temp_img);
		}
		// Create new image resource
		if ($size['mime'] == 'image/gif' || ($size['mime'] == 'image/png' && $indexed_png)) {
			// Create indexed 
			$new_img = imagecreate($neww,$newh);
			// Copy the palette
			imagepalettecopy($new_img,$source_img);
			$color_transparent = imagecolortransparent($source_img);
			if ($color_transparent >= 0) {
		  		// Copy transparency
		  		imagefill($new_img,0,0,$color_transparent);
		  		imagecolortransparent($new_img, $color_transparent);
			}
		}else{
			$new_img = imagecreatetruecolor($neww,$newh);
		}
		// Copy and resize image
		imagecopyresampled($new_img,$source_img,0,0,0,0,$neww,$newh,$size[0],$size[1]);
		// Save output file
		if ($save_function == 'imagejpeg') {
			// Change the JPEG quality here
		  	if (!$save_function($new_img,$outfile,75)) {
				trigger_error("Unable to save output image",E_USER_WARNING);
			  	return FALSE;
		  	}
		}else{
		  	if (!$save_function($new_img,$outfile)) {
			  	trigger_error("Unable to save output image",E_USER_WARNING);
			  	return FALSE;
		  	}
		}
		// Cleanup
		imagedestroy($source_img);
		imagedestroy($new_img);
		return TRUE;
	}
	
	function show_thumbnail($infile,$maxw="",$maxh="",$stretch = FALSE) {
		clearstatcache();
		ob_end_clean();
		if (!is_file($infile)) {
			@trigger_error("Cannot open file: $infile",E_USER_WARNING);
			return FALSE;
		}
		$functions = array(
		'image/png' => 'ImageCreateFromPng',
		'image/jpeg' => 'ImageCreateFromJpeg',
		);
		// Add GIF support if GD was compiled with it
		if (function_exists('ImageCreateFromGif')){ 
			$functions['image/gif'] = 'ImageCreateFromGif'; 
		}
		$size = getimagesize($infile);
		// Check if mime type is listed above
		if (!$function = $functions[$size['mime']]) {
		  	trigger_error("MIME Type unsupported: {$size['mime']}",E_USER_WARNING);
			return FALSE;
		}
		// Open source image
		if (!$source_img = @$function($infile)) {
		  	@trigger_error("Unable to open source file: $infile",E_USER_WARNING);
			return FALSE;
		}
		$save_function = "image" . strtolower(substr(strrchr($size['mime'],'/'),1));
		// Scale dimensions
		list($neww,$newh) = $this->scale_dimensions($size[0],$size[1],$maxw,$maxh,$stretch);
		if ($size['mime'] == 'image/png') {
			// Check if this PNG image is indexed
			$temp_img = imagecreatefrompng($infile);
			if (imagecolorstotal($temp_img) != 0) {
		  		// This is an indexed PNG
		  		$indexed_png = TRUE;
			}else{
		  		$indexed_png = FALSE;
			}
			imagedestroy($temp_img);
		}
		// Create new image resource
		if ($size['mime'] == 'image/gif' || ($size['mime'] == 'image/png' && $indexed_png)) {
			// Create indexed 
			$new_img = imagecreate($neww,$newh);
			// Copy the palette
			imagepalettecopy($new_img,$source_img);
			$color_transparent = imagecolortransparent($source_img);
			if ($color_transparent >= 0) {
		  		// Copy transparency
		  		imagefill($new_img,0,0,$color_transparent);
		  		imagecolortransparent($new_img, $color_transparent);
			}
		}else{
			$new_img = imagecreatetruecolor($neww,$newh);
		}
		// Copy and resize image
		imagecopyresampled($new_img,$source_img,0,0,0,0,$neww,$newh,$size[0],$size[1]);
		header("Content-type:image/png");
		//$image1 = imagecreatefromgif($image);
		imagePNG($new_img);

		// Cleanup
		imagedestroy($source_img);
		imagedestroy($new_img);
		return TRUE;
	}
	
	// Scales dimensions
	function scale_dimensions($w,$h,$maxw,$maxh,$stretch = FALSE) {
		if (!$maxw && $maxh){
			// Width is unlimited, scale by width
			$newh = $maxh;
			if ($h < $maxh && !$stretch){
				$newh = $h;
			}else{
				$newh = $maxh; 
			}
			$neww = ($w * $newh / $h);
		}elseif (!$maxh && $maxw){
			// Scale by height
			if ($w < $maxw && !$stretch){ 
				$neww = $w; 
			}else{ 
				$neww = $maxw; 
			}
			$newh = ($h * $neww / $w);
		}elseif (!$maxw && !$maxh){
			return array($w,$h);
		}else{
			if ($w / $maxw > $h / $maxh){
				// Scale by height
				if ($w < $maxw && !$stretch){ 
					$neww = $w; 
				}else{ 
					$neww = $maxw; 
				}
				$newh = ($h * $neww / $w);
			}elseif ($w / $maxw <= $h / $maxh){
				// Scale by width
				if ($h < $maxh && !$stretch){ 
					$newh = $h; 
				}else{ 
					$newh = $maxh; 
				}
				$neww = ($w * $newh / $h);
			}
		}
		return array(round($neww),round($newh));
	}	
	 function cropImage($nw, $nh, $source,  $dest = '') {
          $size = getimagesize($source);
          $w = $size[0];
          $h = $size[1];
          switch($size['mime']) {
			case 'image/gif':
				$simg = imagecreatefromgif($source);
				break;
			case 'image/jpeg':
				$simg = imagecreatefromjpeg($source);
				break;
			case 'image/png':
				$simg = imagecreatefrompng($source);
				break;
          } 
		  
          $dimg = imagecreatetruecolor($nw, $nh);
		 
          $wm = $w/$nw;
 
          $hm = $h/$nh;
 
           $h_height = $nh/2;
 
          $w_height = $nw/2;
 
          if($w> $h) {
              $adjusted_width = $w / $hm;
              $half_width = $adjusted_width / 2;
              $int_width = $half_width - $w_height;
              imagecopyresampled($dimg,$simg,-$int_width,0,0,0,$adjusted_width,$nh,$w,$h);
          } elseif(($w <$h) || ($w == $h)) {
              $adjusted_height = $h / $wm;
              $half_height = $adjusted_height / 2;
              $int_height = $half_height - $h_height;
              imagecopyresampled($dimg,$simg,0,0,0,0,$nw,$adjusted_height,$w,$h);
          } else {
              imagecopyresampled($dimg,$simg,0,0,0,0,$nw,$nh,$w,$h);
          }
		
	    imagecopyresampled($dimg,$simg,0,0,0,0,$neww,$newh,$size[0],$size[1]);
		header("Content-type:image/png");
		imagePNG($dimg);
		// Cleanup
		imagedestroy($simg);
		imagedestroy($dimg);
		return TRUE;
      }
}//End Class
?>