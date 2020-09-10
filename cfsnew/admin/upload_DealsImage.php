<?


		// DEFINE VARIABLES
		$maxWidth = 540;
		$maxHeight = 580;
		$tWidth = 120;
		$uploadedFile = $_FILES['Upload_Image']['tmp_name'];

		$target_path = "precropimages/rand123/";
		$target_path = $target_path . $imageFileName;
		$strOriginalPath = $target_path;


		if(move_uploaded_file($uploadedFile, $strOriginalPath)) {

			include_once MODULES_DIR."imgupload/class.Thumbnail.php";
			$objThumb = new ThumbNail();

			include_once MODULES_DIR."imgupload/class.GalleryGDResizer.php";
			$generatorClassObject = new GalleryGDResizer();
			
			include_once MODULES_DIR."imgupload/class.CropThumbNail.php";
			$objCropThumbNail = new CropThumbNail();

			foreach($Deal_Images as $Key => $Value)
			{
				$strDestinationPath 		= $groupon_deals->getDealsPath($Key,$imageFileName);
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