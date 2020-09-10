<?php include_once("../globalconfig.php"); ?>
<?php

 require("../dbconnectvi.php");
     $Db = new dbInvestments();
 session_save_path("/tmp");
session_start();
if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
{

	$currentdir=getcwd();
	$target = $currentdir . "/importfiles/" . basename($_FILES['txtincubatorfilepath']['name']);

	$file = "importfiles/" . basename($_FILES['txtincubatorfilepath']['name']);
	if (!(file_exists($file)))
	{

		if(move_uploaded_file($_FILES['txtincubatorfilepath']['tmp_name'], $target))
		{
			//echo "<Br>The file ". basename( $_FILES['txtincubatorfilepath']['name']). " has been uploaded";
			echo "<br>File is getting uploaded . Please wait..";
			$file = "importfiles/" . basename($_FILES['txtincubatorfilepath']['name']);
		//	echo "<br>----------------" .$file;

		}
		else
		{
			echo "<br>Sorry, there was a problem uploading the file.";
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
				foreach ($values as $i)
				{
				//	echo "<br>****full string- " .$i;
					//$i="";
					if($i != "")
					{
					//echo "<br>full string- " .$i;
					$fstring = explode("\t", $i);
					$portfoliocompany = $fstring[0];
					//echo "<br><br>*****company. ".$portfoliocompany;
					$address1 =$fstring[1];
					$address1=str_replace('"','',$address1);
					$address2=$fstring[2];
					$address2=str_replace('"','',$address2);
					$adcity=trim($fstring[3]);
					$adcity=str_replace('"','',$adcity);
					$zip=$fstring[4];
					$zip=str_replace('"','',$zip);
					$telephone=trim($fstring[5]);
					$telephone=str_replace('"','',$telephone);
					$fax=trim($fstring[6]);
					$fax=str_replace('"','',$fax);
					$email=trim($fstring[7]);
					$email=str_replace('"','',$email);
   					$website=trim($fstring[8]);
   					$website=str_replace('"','',$website);
   					$mgmtString=trim($fstring[9]);
					$mgmtString=str_replace('"','',$mgmtString);
     				$fundsavailable=trim($fstring[10]);
					$fundsavailable=str_replace('"','',$fundsavailable);

        			$addinfor=trim($fstring[11]); 				//additional information in the excel
					$addinfor=str_replace('"','',$addinfor);

					if(trim($portfoliocompany)!="")
					{
						$incubatorId=inst_incubator($portfoliocompany,$address1,$address2,$adcity,$zip,$telephone,$fax,$email,$website,$mgmtString,$fundsavailable,$addinfor);
						if($incubatorId>0)
						?>
						     	<Br><tr bgcolor="C0C0C0"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany ; ?>&nbsp; --> Imported & Update done</td> </tr>
						<?php
     					$importTotal=$importTotal+1;
						//	echo "<br>".$importTotal. " " .$portfoliocompany;
					} // $portfoliocompany != " loop ends
				} //if $i loop ends
			} //for each loop ends
		} // if $file loop ends
	}   //file exists condition
	else
	{
	?>
		<table align="center" border="1" cellpadding="0" cellspacing="0" width="765">
		<tr> <Td><b> File dont exists to read </b> </td></tR>
		</table>
	<?php
	}

} // if resgistered loop ends
else
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>
<table align="center" border="1" cellpadding="0" cellspacing="0" width="765">
<tr> <Td><b> Import count - <?php echo $importTotal; ?> </b> </td></tR>
</table>

	<?php
/* function to insert executives in a common table */

/* function to insert the companies and return the company id if exists */
	function inst_incubator($investor,$add1,$add2,$adcity,$zip,$tel,$fax,$email,$website,$mgmt,$fundsavailable,$addinfor)
	{
		$dbpecomp = new dbInvestments();
		$incubatorname=trim($investor);
		$getPECompanySql = "select IncubatorId from incubators where Incubator like '$incubatorname'";
		//echo "<br>select Investor--" .$getPECompanySql;
		if ($rsgetPECompanyId = mysql_query($getPECompanySql))
		{
			$pecomp_cnt=mysql_num_rows($rsgetPECompanyId);

   		 if($pecomp_cnt==1)
			{
				While($myrow=mysql_fetch_array($rsgetPECompanyId, MYSQL_BOTH))
				{
					$incubatorId = $myrow[0];
					$updatePECompanySql="Update incubators set Incubator='$incubatorname',Address1='$add1',Address2='$add2', City='$adcity',Zip='$zip',Telephone='$tel',Fax='$fax',Email='$email',website='$web',  FundsAvailable='$fundsavailable', AdditionalInfor='$addinfor',Management='$mgmt' where IncubatorId=$incubatorId";
				//echo "<br>Update Investor sql=" .$updatePECompanySql;
					if($rsupdatePECompany = mysql_query($updatePECompanySql))
					{
						return  $incubatorId;

					}

				}
			}
		}
	//	$dbpecomp.close();
	}
?>
