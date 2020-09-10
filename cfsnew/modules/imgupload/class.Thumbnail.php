<?
	/****************************************************************************************************************
	*	SCRIPT TYPE: Class  																						*											
	*	SCRIPT NAME: ThumbNail																						*	
	*	DESCRIPTION: ThumbNail manipulation											                                *		
	*	AUTHOR: Keyar																								*			
	*	WRITTEN ON: 03-Jan-2006                                                                                     *	
	*	LAST MODIFIED ON: 03-Jan-2006                                                                               *	
	*   COPYRIGHT: http://www.securenext.com																		*	
	*****************************************************************************************************************/
	
	class ThumbNail 
	{
		var $ModelsTable;
		var $Basement;
		function ThumbNail()
		{
			$this->Basement = "h";
			global $config;
		}
		
		function MakeThumb($Limit="",$Start="")
		{
			$rsModels = $this->getModels($Limit,$Start);
			for($i=0;$i<count($rsModels);$i++)
			{
				ob_implicit_flush(1);
				flush();
				ob_end_flush();
			
				$strSourcePath  = $this->ImagesLocalPath."original/".$rsModels[$i]["ModCode"];
				$strFiles 		= $this->getFiles($strSourcePath);
				$strPath1		= $this->ImagesFTPPath."thumb/".$rsModels[$i]["ModCode"]."/";
				$strPath2		= $this->ImagesFTPPath."medium/".$rsModels[$i]["ModCode"]."/";
				if(count($strFiles["Names"]) > 0)
				{
					for($j=0;$j<count($strFiles["Names"]);$j++)
					{
						$this->CreateThumb("temp.jpg",$strFiles["Paths"][$j],$this->ImagesTempPath,75,75,$ver,false);
						$this->objFTP->makeDir($rsModels[$i]["ModCode"],$this->ImagesFTPPath."thumb/");
						$this->objFTP->uploadFile($strPath1.$strFiles["Names"][$j],$this->ImagesTempPath."temp.jpg");
						$this->CreateThumb("temp.jpg",$strFiles["Paths"][$j],$this->ImagesTempPath,330,220,$ver,false);
						$this->objFTP->makeDir($rsModels[$i]["ModCode"],$this->ImagesFTPPath."medium/");
						$this->objFTP->uploadFile($strPath2.$strFiles["Names"][$j],$this->ImagesTempPath."temp.jpg");
					}
				}
				flush();
			}
		}
		
		function getFiles($strPath)
		{
			if(is_dir($strPath))
			{
				if ($dirs = @opendir($strPath))
					while (($file = readdir($dirs)) !== false)
					{
						if($pos = strrpos($file,"."))
						{
							$ext = substr($file,$pos+1);
							if($ext=="jpg")
							{
								$Files["Names"][] = $file;
								$Files["Paths"][] = $strPath."/".$file;
							}
						}
					}
				closedir($dirs);
			}
			return $Files;
		}
		
		function getThumbNail($SourceImage,$Width,$Height,$Unique = false)
		{
			$image_info = $this->resize_img($SourceImage,$Width,$Height,$ver,$Unique);
			 
			return $image_info;
			 
		}
		
		function CreateThumb($userimagename, $source_path, $destination_path, $new_width,$new_height,$ver,$unique)
		{ 
			$image_dir_file_location=$source_path;        // image location and file name
			$image_dir_file_save=$destination_path.$userimagename;                // image save location and file name
			$image_info= $this->resize_img($image_dir_file_location,$new_width,$new_height,$ver,$unique);			
			imagejpeg($image_info,$image_dir_file_save);
		}

		function ImageCopyResampleBicubic($dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) 
		{ 
			for ($i = 0; $i < 256; $i++) { // get pallete. Is this algoritm correct? 
				$colors = @ImageColorsForIndex ($src_img, $i); 
				@ImageColorAllocate ($dst_img, $colors['red'], $colors['green'], $colors['blue']); 
			} 
		
			$scaleX = ($src_w - 1) / $dst_w; 
			$scaleY = ($src_h - 1) / $dst_h; 
		
			$scaleX2 = $scaleX / 2.0; 
			$scaleY2 = $scaleY / 2.0; 
		
			for ($j = $src_y; $j < $dst_h; $j++) { 
				$sY = $j * $scaleY; 
				
				for ($i = $src_x; $i < $dst_w; $i++) { 
					$sX = $i * $scaleX; 
					
					$c1 = @ImageColorsForIndex ($src_img, ImageColorAt ($src_img, (int) $sX, (int) $sY + $scaleY2)); 
					$c2 = @ImageColorsForIndex ($src_img, ImageColorAt ($src_img, (int) $sX, (int) $sY)); 
					$c3 = @ImageColorsForIndex ($src_img, ImageColorAt ($src_img, (int) $sX + $scaleX2, (int) $sY + $scaleY2)); 
					$c4 = @ImageColorsForIndex ($src_img, ImageColorAt ($src_img, (int) $sX + $scaleX2, (int) $sY)); 
					
					$red = (int) (($c1['red'] + $c2['red'] + $c3['red'] + $c4['red']) / 4); 
					$green = (int) (($c1['green'] + $c2['green'] + $c3['green'] + $c4['green']) / 4); 
					$blue = (int) (($c1['blue'] + $c2['blue'] + $c3['blue'] + $c4['blue']) / 4); 
					
					$color = @ImageColorClosest ($dst_img, $red, $green, $blue); 
					$aa = @ImageSetPixel ($dst_img, $i + $dst_x, $j + $dst_y, $color); 
				} 
			} 
		}
		
		function resize_img($image_name,$new_width,$new_height,$gdversion,$unique)
		{	
			$new_size=0;							
			list($width, $height, $type, $attr) = @getimagesize($image_name);
			switch($type)
			{
				case 1:
					$image_source = @imagecreatefromgif($image_name);
					break;
				case 2:
					$image_source = @ImageCreateFromJpeg($image_name);
					break;
				case 3:
					$image_source = @imagecreatefrompng($image_name);
					break;
			}				
			if($new_height<=0) 
				$new_size = $new_width;
			if($new_width<=0)
				$new_size = $new_height;
		
			$actual_width   = @imagesx($image_source);
			$actual_height  = @imagesy($image_source);
			
			
			if($actual_width <= $new_width && $actual_height <= $new_height)
			{
				$new_width  = $actual_width;
				$new_height = $actual_height;
			}
			else
			{
				if(!$unique)
				{
						
					if ($actual_width >= $actual_height)
					{
						if($actual_width>$new_width)
						{
							$width  = $new_width;
							$height = ($width/$actual_width)*$actual_height;
							
						}
						else
						{
							$height = $new_height;
							$width = $new_width;
						}
					 }
					 else
					 {
						if ($actual_height > $new_height) {
							$height  = $new_height;
							$width   = ($height/$actual_height)*$actual_width;
						}
						else
						{
							$height = $new_height;
							$width = $new_width;
						}
					 }
				}
				else
				{
					if ($actual_width >= $actual_height)
					{
						if($actual_width>$new_width)
						{
							$height  = $new_height;
							$width   = ($height/$actual_height)*$actual_width;
						}
						else
						{
							$height = $new_height;
							$width = $new_width;
						}						
					}
					else
					{
						if ($actual_height > $new_height) {
							$width  = $new_width;							
							$height = ($width/$actual_width) * ($actual_height);
						}
						else
						{
							$height = $new_height;
							$width = $new_width;
						}
					}
				}
			 }
			if($gdversion)
			{
				$image_info = @ImageCreate($width,$height);
				$this->imagecopyresamplebicubic($image_info, $image_source, 0, 0, 0, 0,$width, $height, $actual_width, $actual_height);
				if($unique)
				{
					$newimage_info = @ImageCreate($new_width,$new_height);
					$this->imagecopyresamplebicubic($newimage_info, $image_info, 0, 0, 0, 0,$new_width, $new_height, $width, $height);
					$image_info = $newimage_info;
				}
			}
			else
			{
				$image_info = @imagecreatetruecolor($width,$height);
				@imagecopyresampled($image_info, $image_source, 0, 0, 0, 0,$width, $height, $actual_width, $actual_height);
				if($unique)
				{
					$newimage_info = @imagecreatetruecolor($new_width,$new_height);
					@imagecopy($newimage_info, $image_info, 0, 0, 0, 0,$new_width, $new_height);
					$image_info = $newimage_info;
				}
			}
						
			return $image_info;
			
		}
		
		function CreateIcon($Iconname, $source_path, $destination_path, $need_width,$need_height,$ver,$unique)
		{
			 
			$image_dir_file_save=$destination_path.$Iconname;
			$size = @getimagesize ($source_path);
		    $actual_width  = $size[0];
			$actual_height = $size[1];
			$new_X 	= ($actual_width - $need_width)/2;
			$new_Y	= ($actual_height - $need_height)/2;

			if($actual_width > $actual_height)
				$width_x = ($actual_width - $need_width)/2;
				
			$image_info 	= ImageCreate($width,$height);
			$final_image	= ImageCreate($new_width,$new_height);	
			
			$int = imagecopy($image_dir_file_save,$source_path,0,0,0,0,80,80);

		}
	}
		
?>