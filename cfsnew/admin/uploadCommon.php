<?php
		// DELETE FILE IF EXISTING
		if(file_exists($DeleteHeaderImagePath)) { @chmod($DeleteHeaderImagePath, 0777); unlink($DeleteHeaderImagePath); }
		//if(file_exists($DeleteDynamicImagePath)) { @chmod($DeleteDynamicImagePath, 0777); unlink($DeleteDynamicImagePath); }
		
		if(move_uploaded_file($UploadedSourceFile, $strOriginalPath)) {
		}  else {
                }
?>