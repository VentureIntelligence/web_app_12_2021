<?php
//16 jul 2011
//formname: importcfs.php
//invoked directly through admin interface 
//imports time sheet from xls into dev db
      session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
     session_start();
     require ("../dbConnect_cfs.php");
    $dbconn = new db_connection();

     //echo "<br>-----1";

	 	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	 	{
		//$file ="importfiles/peinvestmentsexport.txt";
			$currentdir=getcwd();
			$target = $currentdir . "/importfiles/" . basename($_FILES['txttimefilepath']['name']);
			$file = "importfiles/" . basename($_FILES['txttimefilepath']['name']);
		}
               	if (!(file_exists($file)))
			{
                                if(move_uploaded_file($_FILES['txttimefilepath']['tmp_name'], $target))
				{
					//echo "<Br>The file ". basename( $_FILES['txttimefilepath']['name']). " has been uploaded";
					echo "<br>Time data file is getting uploaded . Please wait..";
					$file = "importfiles/" . basename($_FILES['txttimefilepath']['name']);
					//echo "<br>----------------" .$file;
				}
				else
				{
					echo "<br>Sorry, there was a problem in uploading the file.";
				}
			}
                  
                $importTotal=0;
	if (file_exists($file))
	{
		echo "<br>File is being read. ";
		if ($file !="")
		{
			echo "<Br>File is being read. It will take time to import all data. Please wait....";
			$fp = fopen($file, "r") or die("Couldn't open file");
			while(!feof($fp))
			{		$data .= fgets($fp, 1024);
			}
			fclose($fp);
			$values = explode("\n", $data);
			 $cnt=1;
				foreach ($values as $i)
				{
					//echo "<br>****full string- " .$i;
					//$i="";
					if($i != "")
					{
                                              $cfsstring = explode("\t", $i);
					      $timeid = trim($cfsstring[0]);
                                              $calendardate = trim($cfsstring[1]);
					      $calhalf=$cfsstring[2];
					      $calmonth=$cfsstring[3];
					      $calqtr=$cfsstring[4];
					      $calyear=$cfsstring[5];
					      $fishalf=$cfsstring[6];
					      $fismonth=$cfsstring[7];
					      $fisqtr=$cfsstring[8];
					      $fisyear=$cfsstring[9];


                                             $insertTimeSql="insert into time_dim(time_id,calendar_date,cal_half,cal_month,cal_qtr,cal_year,fis_half,fis_month,fis_qtr,fis_year)
                                             values ($timeid,'$calendardate',$calhalf,$calmonth,$calqtr,$calyear,$fishalf,$fismonth,$fisqtr,$fisyear)";
                                             //echo "<br>Insert Time Sql" .$insertTimeSql;
                                             if($rsInsertTimeDim=mysql_query($insertTimeSql))
                                             {
                                               echo "<br>Row " .$cnt ." * " . $calendardate ." inserted ";
                                               $cnt=$cnt+1;
                                             }
                                             else
                                             {
                                               echo "<br>" .$calendardate. " - FAILED";

                                             }

                                         }  //end of i loop
                                 }//end of foreach loop
                 } //end of file check
     }//end of file exists loop
$dbconn.close();
?>

