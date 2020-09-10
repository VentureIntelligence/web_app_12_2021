<?php
		// DEFINE VARIABLES
		$maxWidth = 540;
		$maxHeight = 580;
		$tWidth = 120;
		//$imageFileName = GetImageName($GetImageFileName); 
		$target_path = "precropimages/rand123/";
		$target_path = $target_path . $GetImageFileName;
		$strOriginalPath = $target_path;



		// DELETE FILE IF EXISTING
		if(file_exists($imageLocation)) { chmod($imageLocation, 0777);  unlink($imageLocation); }
		if(file_exists($imageThumbLocation)) { chmod($imageThumbLocation, 0777);  unlink($imageThumbLocation); }
print $uploadedFile;
print "<br>";
print $strOriginalPath;

		if(move_uploaded_file($uploadedFile, $GetImageFileName)) {

		/*Delete Image Temp Resource after uploads the file*/
//		if(file_exists("precropimages/rand123/".$imageFileName)) { @chmod("precropimages/rand123/".$imageFileName, 0777); unlink("precropimages/rand123/".$imageFileName); }			
	
			return true;
		}
?>