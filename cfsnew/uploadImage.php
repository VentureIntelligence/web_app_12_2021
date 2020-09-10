<?php
		// DEFINE VARIABLES
		$maxWidth = 540;
		$maxHeight = 580;
		$tWidth = 120;

		$imageFileName = GetImageName($GetImageFileName);
		$target_path = "precropimages/rand123/";
		$target_path = $target_path . $imageFileName;
		$strOriginalPath = $target_path;



		// DELETE FILE IF EXISTING
		if(file_exists($imageLocation)) { chmod($imageLocation, 0777);  unlink($imageLocation); }
		if(file_exists($imageThumbLocation)) { chmod($imageThumbLocation, 0777);  unlink($imageThumbLocation); }


		if(move_uploaded_file($uploadedFile, $strOriginalPath)) {

			include_once MODULES_DIR."imgupload/class.Thumbnail.php";
			$objThumb = new ThumbNail();

			include_once MODULES_DIR."imgupload/class.GalleryGDResizer.php";
			$generatorClassObject = new GalleryGDResizer();
			
			include_once MODULES_DIR."imgupload/class.CropThumbNail.php";
			$objCropThumbNail = new CropThumbNail();

			foreach($UploadImageSizes as $Key => $Value){
				$SubPath =  $ImageDir.'/'.$Key;
				if(!is_dir($SubPath)){
					mkdir($SubPath,0777);chmod($SubPath, 0777);
				}
				$strDestinationPath 		= getImgPath($Key,$imageFileName,$LowerCase,$FolderName);

				if($Value["Crop"])
					$imgThumb = $generatorClassObject->generate($strOriginalPath,$strDestinationPath,$Value["Width"],$Value["Height"]);
				else
					$objThumb->CreateThumb("",$strOriginalPath,$strDestinationPath,$Value["Width"],$Value["Height"],false,false);
			}
		/*Delete Image Temp Resource after uploads the file*/
		if(file_exists("precropimages/rand123/".$imageFileName)) { @chmod("precropimages/rand123/".$imageFileName, 0777); unlink("precropimages/rand123/".$imageFileName); }			
	
			return true;
		}
?>