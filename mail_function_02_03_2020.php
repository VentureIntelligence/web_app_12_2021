<?php 
error_reporting(0);
require("dbconnectvi.php");
$Db = new dbInvestments();



if(isset($_GET['directory'])){
    $industrysql="select industryid,industry from industry order by industry";
    
    $directory=array();
    if ($industryrs = mysql_query($industrysql))
    {
     $ind_cnt = mysql_num_rows($industryrs);
    }
    if($ind_cnt>0)
    {
             While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
            {
                    $id = $myrow[0];
                    $name = $myrow[1];
                    echo "<OPTION value=".$name.">".$name."</OPTION> \n";
                    //$directory[] = array('id'=>$id, 'name'=>$name);
            }
            mysql_free_result($industryrs);
    }
    
  //  print_r(json_encode($directory));
    exit;
}



if($_POST){
    
if( isset($_REQUEST['vcdirectory'])) {
    $name = $_POST['name'];
    $firmname = $_POST['firmname'];
    $designation = $_POST['designation'];
    $emailid = $_POST['emailid'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];
    $firmtype = $_POST['firmtype'];
    $about_our_service = $_POST['about_our_service'];
    
    $industry = $_POST['industry'];
    $range = $_POST['range'];
    
    $RegDate=date("M-d-Y"); 
    
    
     //Send Email
    $to    = 'weekly@ventureintelligence.com'; 
    //$to    = 'mathan@kutung.com'; 
   	
    $from 	= 'info@ventureintelligence.com';               
    $subject 	= "VC Directory download -" .$firmname;;
    
 
    
    
    $message 	= '<br><br>';
    
    $message  .= '<table width="80%" cellspacing="0" cellpadding="0" style="border: solid 1px #ccc;">';
    
    $message  .= '<tr><td colspan="2"  style="background-color: #EFEFEF;"> <h3 style="text-align:center">VC Handbook & Directory</h3> <br></td></tr>';
         
    
    if($RegDate)
    $message 	.= "<tr><td width='30%' style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Reg Date</td> <td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$RegDate."</td></tr>";
    
     if($name)
    $message 	.= "<tr><td width='30%' style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Name</td> <td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$name."</td></tr>";
    
    
    if($firmname)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Firm Name</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$firmname."</td></tr>";
    
    
    if($designation)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Designation</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$designation."</td></tr>";
    
    
    if($emailid)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Email Id</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$emailid."</td></tr>";
    
    
    if($city)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>City</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$city."</td></tr>";
    
    
    if($country)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Country</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$country."</td></tr>";
    
    
    if($phone)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Phone</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$phone."</td></tr>";
    
    
    if($firmtype)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Firm Type</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$firmtype."</td></tr>";
    
    
    if($about_our_service)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Learnt through</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$about_our_service."</td></tr>";
    
   
    if($industry)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Industry</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$industry."</td></tr>";
    
     
     
    if($range)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Revenue Range</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$range."</td></tr>";
    
    
      
    $message .= "</table>";
    

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: $from\r\n"; 
    $headers .= "Reply-To: $to\r\n"; 
   // $headers .= 'Cc: subscription@ventureintelligence.com,fidelis@kutung.com' . "\r\n";
    $headers .= 'Cc: arun.natarajan@gmail.com' . "\r\n";

    if (@mail($to, $subject, $message, $headers)){
        $Status=1;
    }else{
        $Status=0;
    }
    
    echo $Status;
    
    
    
    
    
    $file="txt/vcdirectory.txt";
				$schema_insert="";
				//TRYING TO WRIRE IN EXCEL
							 //define separator (defines columns in excel & tabs in word)
								 $sep = "\t"; //tabbed character
								 $cr = "\n"; //new line

								 //start of printing column names as names of MySQL fields

									//print("\n");
									// print("\n");
								 //end of printing column names
								 		$schema_insert .=$cr;
										$schema_insert .=$RegDate.$sep; //Reg Date
										$schema_insert .=$name.$sep; //Namek
									$schema_insert .=$designation.$sep; //desgination
									$schema_insert .=$city.$sep; //city
									$schema_insert .=$emailid.$sep; //emailid
									$schema_insert .=$country.$sep; //emailid
									$schema_insert .=$phone.$sep; //phone
									$schema_insert .=$firmname.$sep; //firmname
									$schema_insert .=$firmtype.$sep; //FirmType
									$schema_insert .=$industry.$sep;  //Industry
									$schema_insert .=$range.$sep; //RevenueRange
									$schema_insert .=$about_our_service;  //Learntthrough
									$schema_insert = str_replace($sep."$", "", $schema_insert);
								    $schema_insert .= ""."\n";

								 	//	$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
								       //  $schema_insert .= "\t";

										if (file_exists($file))
										{
											//echo "<br>break 1--" .$file;
											 $fp = fopen($file,"a+"); // $fp is now the file pointer to file
												 if($fp)
												 {//echo "<Br>-- ".$schema_insert;
													fwrite($fp,$schema_insert);    //    Write information to the file
													  fclose($fp);  //    Close the file
													 //echo "File saved successfully";
												 }
												 else
													{
													//echo "Error saving file!"; 
                                                                                                     
                                                                                                 }
										}
                                                                                
                                                                                
                                                                                
}





if( isset($_REQUEST['weeklynewsletter'])) {
   
    $name = $_POST['name'];
    $organization = $_POST['organization'];
    $email = $_POST['email'];
    $ref = $_POST['ref'];
    
    
    
    $firmtype = $_POST['firmtype'];
    
    $profile_url = $_POST['profile_url'];
    
    $designation = $_POST['designation'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
        
     
    $RegDate=date("M-d-Y");
    
     //Send Email
    $to    = 'weekly@ventureintelligence.com'; 
    //$to    = 'junaid@kutung.com';
   	
    $from 	= 'info@ventureintelligence.com';               
    $subject 	= "Weekly Newsletter - " .$organization;;
    
    $message 	= '<br><br>';
    
    $message  .= '<table width="80%" cellspacing="0" cellpadding="0" style="border: solid 1px #ccc;">';
    
    $message  .= '<tr><td colspan="2" style="background-color: #EFEFEF;"> <h3 style="text-align:center"> Weekly Newsletter</h3> <br></td></tr>';
        
    if($RegDate)
    $message 	.= "<tr><td width='30%' style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Reg Date</td> <td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$RegDate."</td></tr>";
    
    if($name)
    $message 	.= "<tr><td width='30%' style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Name</td> <td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$name."</td></tr>";
    
    if($organization)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Organization</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$organization."</td></tr>";
    
    if($email)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Email Id</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$email."</td></tr>";
    
    if($ref)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Learnt through</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$ref."</td></tr>";
    
    if($profile_url)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Profile URL</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$profile_url."</td></tr>";
    
    if($designation)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Designation</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$designation."</td></tr>";
    
    if($phone)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Phone</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$phone."</td></tr>";    
    
    if($city)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>City</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$city."</td></tr>";
    
    $message .= "</table>";
    

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: $from\r\n"; 
    $headers .= "Reply-To: $to\r\n"; 
   // $headers .= 'Cc: subscription@ventureintelligence.com,fidelis@kutung.com' . "\r\n";
    $headers .= 'Cc: arun.natarajan@gmail.com' . "\r\n";

    if (@mail($to, $subject, $message, $headers)){
        $Status=1;
    }else{
        $Status=0;
    }
    
    echo $Status;
    
    
   
    
    $file="weeklynewsletter.txt";
    $schema_insert="";
    //TRYING TO WRIRE IN EXCEL
    //define separator (defines columns in excel & tabs in word)
    $sep = "\t"; //tabbed character
    $cr = "\n"; //new line

    //start of printing column names as names of MySQL fields

           //print("\n");
           // print("\n");
    //end of printing column names
    $schema_insert .=$cr;
    $schema_insert .=$RegDate.$sep; //Reg Date
    $schema_insert .=$name.$sep; //Name
    $schema_insert .=$organization.$sep; //firmname
    $schema_insert .=$email.$sep; //emailid
    $schema_insert .=$ref;  //Learntthrough\

    $schema_insert .=$designation.$sep; //desgination
    $schema_insert .=$city.$sep; //city
    $schema_insert .=$phone.$sep; //phone

    $schema_insert .=$profile_url;
    $schema_insert = str_replace($sep."$", "", $schema_insert);
    $schema_insert .= ""."\n";

									 	//	$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
									       //  $schema_insert .= "\t";

											if (file_exists($file))
											{
												//echo "<br>break 1--" .$file;
												 $fp = fopen($file,"a+"); // $fp is now the file pointer to file
													 if($fp)
													 {//echo "<Br>-- ".$schema_insert;
														fwrite($fp,$schema_insert);    //    Write information to the file
														  fclose($fp);  //    Close the file
														 //echo "File saved successfully";
													 }
													 else
														{
														//echo "Error saving file!"; 
                                                                                                                
                                                                                                                }
											}
}




}
//$response = array('Status'=>$Status);
//print_r(json_encode($response));





if(isset($_REQUEST['filedownload'])){
    
    //download.php
$filename="pdf/vc-handbook.pdf";

$path = BASE_URL."/pdf/"; 
$filename= $path.basename($filename);

header("Cache-Control: public");
header("Content-Description: File Transfer");
header('Content-disposition: attachment; 
filename='.basename($filename));
header("Content-Type: application/pdf");
header("Content-Transfer-Encoding: binary");
header('Content-Length: '. filesize($filename));
readfile($filename);
exit;
}



?>