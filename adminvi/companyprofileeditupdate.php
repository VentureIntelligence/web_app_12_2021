<?php include_once("../globalconfig.php"); ?>
<?php
 require("../dbconnectvi.php");
	$Db = new dbInvestments();
 //session_save_path("/tmp");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	{
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Update Investment data : : Contact TSJ Media : :</title>

<SCRIPT LANGUAGE="JavaScript">
function delUploadFile()
{
	document.editdeal.action="delpeuploadfile.php";
	document.editdeal.submit();
}
function delREUploadFile(str)
{
         document.editdeal.hiddenfile.value=str;
	document.editdeal.action="delpereuploadfile.php";
	document.editdeal.submit();
}

</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
<form name="companyprofileeditupdate" >

<p > <b><center> <font style="font-family: Verdana; font-size: 10pt">Edit Company Profile</font> </b></center></p>
<p></p><p></p>
<table width=60% align=center border=1 cellpadding=2>

<?php
   


        $AngelApi_compID = $_POST['angelco_compID'];
        
        
        if($AngelApi_compID=='' || $AngelApi_compID==0){
            $angelco_compID='';
        }else if($AngelApi_compID>0){
            $angelco_compID=$AngelApi_compID;
            $angelco_compID_inc = ', angelco_compID='.$angelco_compID;
        }
       
        
        
    	 $companyIdtoUpdate = $_POST['txtcompanyid'];
    	 $companyNameToUpdate =  $_POST['txtname'];
    	$companyNameToUpdate=str_replace('"','',$companyNameToUpdate);

            $cinnotoUpdate=$_POST['txtcinno'];
    	 $industryIdtoUpdate=$_POST['industry'];
    	 $sectorToUpdate=$_POST['txtsector'];
    	 $sectorToUpdate=str_replace('"','',$sectorToUpdate);
    	 $tagsToUpdate=trim($_POST['txttags']);

    	 $stockToUpdate=$_POST['txtstockcode'];
    	 $stocktoUpdate=str_replace('"','',$stockToUpdate);
    	// echo "<Br>--------".$stockToUpdate;
    	 $yearfoundedToUpdate=$_POST['txtyearfounded'];
    	 $yearfoundedToUpdate=str_replace('"','',$yearfoundedToUpdate);
    	 $address1ToUpdate=$_POST['txtaddress1'];
    	 $address1ToUpdate=str_replace('"','',$address1ToUpdate);
    	 $address2ToUpdate=$_POST['txtaddress2'];
    	 $address2ToUpdate=str_replace('"','',$address2ToUpdate);
    	 $adCityToUpdate=$_POST['txtadcity'];
    	 $adCityToUpdate=str_replace('"','',$adCityToUpdate);
    	 $zipToUpdate=$_POST['txtzip'];
    	 $zipToUpdate=str_replace('"','',$zipToUpdate);
    	 $regionIdtoUpdatee=$_POST['txtregion'];


    	 $countryToUpdate=$_POST['txtcountry'];
    	 $countryToUpdate=str_replace('"','',$countryToUpdate);
    	 //$countryToUpdate="IN";
    	 $otherLocationToUpdate=$_POST['txtotherlocation'];
    	 $otherLocationToUpdate=str_replace('"','',$otherLocationToUpdate);
    	 $telToUpdate=$_POST['txttelephone'];
    	 $telToUpdate=str_replace('"','',$telToUpdate);
    	 $urlToUpdate=$_POST['txtwebsite'];
    	 $urlToUpdate=str_replace('"','',$urlToUpdate);
         $liToUpdate=$_POST['txtlinkedin'];
         $liToUpdate=str_replace('"','',$liToUpdate);
         $liToUpdate=rtrim($liToUpdate,'/');
         $liToUpdate=str_replace('/company-beta/','/company/',$liToUpdate);
    	 $faxToUpdate=$_POST['txtfax'];
    	 $faxToUpdate=str_replace('"','',$faxToUpdate);
    	 $emailToUpdate=$_POST['txtemail'];
    	 $emailToUpdate=str_replace('"','',$emailToUpdate);
    	 $addinforToUpdate=$_POST['txtaddinfor'];
    	 $addinforToUpdate=str_replace('"','',$addinforToUpdate);


        $brdExecutiveId=$_POST['txtbrdExecutiveId'];
        $brdExecutiveIdArray= count($brdExecutiveId);
        $brdExecutiveName=$_POST['txtbrdExecutiveName'];

        $mgmtExecutiveId=$_POST['txtmgmtExecutiveId'];
        $mgmtExecutiveIdArray= count($mgmtExecutiveId);
        //echo "<br>%%%%%%%%%%%".$mgmtExecutiveIdArray;
        $mgmtExecutiveName=$_POST['txtmgmtExecutiveName'];

        $compLinkhidden=$_POST['txtCompanyLinkhidden'];
        $compLink=$_POST['txtCompanyLink'];
        $compLinkArray=count($compLink);
        $compComment=$_POST['txtCompanyComment'];
         
        $upload_txtfile=$_POST['txtfile'];

        $uploadname=$_POST['txtfilepath'];
        $currentdir=getcwd();
        //echo "<br>Current Diretory=" .$currentdir;
        $curdir =  str_replace("adminvi","",$currentdir);
        //echo "<br>*****************".$curdir;
        $target = $curdir . "/uploadmamafiles/" . basename($_FILES['txtfilepath']['name']);
        $file = "uploadmamafiles/" . basename($_FILES['txtfilepath']['name']);
        $filename= basename($_FILES['txtfilepath']['name']);
         //echo "<Br>Target Directory=" .$target;
         //echo "<bR>FILE NAME---" .$filename;
        $StateIdtoUpdate= $_POST['txtstate'];
              $state='';
              $stateSql = "select state_id,state_name from state where state_id=".$StateIdtoUpdate;
                                if ($staters = mysql_query($stateSql))
                                                        {
                                                          $state_cnt = mysql_num_rows($staters);
                                                        }
                                                        if($state_cnt > 0)
                                                        {
                                                            $myrow=mysql_fetch_row($staters, MYSQL_BOTH);
                                                            {
                                                                $id = $myrow[0];
                                                                $name = $myrow[1];

                                                                $state = $name;
                                                            }
                                                        } 
         if($regionIdtoUpdatee>0)
         {
                 $getRegionSql="select Region from region where RegionId=$regionIdtoUpdatee";
                 if ($rsregion = mysql_query($getRegionSql))
                 {
                         While($regionrow=mysql_fetch_array($rsregion, MYSQL_BOTH))
                         {
                                 $regiontext=$regionrow["Region"];
                         }
                 }
         }
         

        if($filename!="")
        {
           if (!(file_exists($file)))
           {
              if( move_uploaded_file($_FILES['txtfilepath']['tmp_name'], $target))
              {

                //echo "<Br>The file ". basename( $_FILES['txtfilepath']['name']). " has been uploaded";
                echo "<br>File is getting uploaded . Please wait..";
                $file = "uploadmamafiles/" . basename($_FILES['txtfilepath']['name']);
                echo "<br>----------------" .$file;
              }
              else
              {
                 echo "<br>Sorry, there was a problem in uploading the file.";
              }
           }
          else
             echo "<br>FILE ALREADY EXISTS IN THE SAME NAME";
         }
  
        if($upload_txtfile==NULL || $filename!=NULL)
        {
            
            $filepath_inc = " , uploadfilename= '".$filename."'";
        }
      
       for($i = 0; $i < count($_FILES["txtfilingpath"]["name"]); $i++){
            
           if($_FILES['txtfilingpath']['name'][$i]!=''){ 
           
                $currentdir=getcwd();
                //echo "<br>Current Diretory=" .$currentdir;
                $curdir =  str_replace("adminvi","",$currentdir);
                //echo "<br>*****************".$curdir;
                $target = $curdir . "/uploadfilingfiles/" . basename($_FILES['txtfilingpath']['name'][$i]);
                $file = "uploadfilingfiles/" . basename($_FILES['txtfilingpath']['name'][$i]);
                $filingfilename= basename($_FILES['txtfilingpath']['name'][$i]);
                //echo "<Br>Target Directory=" .$target;
                //echo "<bR>FILE NAME---" .$filename;
                if($filingfilename!="")
                {
                      if( move_uploaded_file($_FILES['txtfilingpath']['tmp_name'][$i], $target))
                      {

                        //echo "<Br>The file ". basename( $_FILES['txtfilepath']['name']). " has been uploaded";
                        echo "<br>File is getting uploaded . Please wait..";
                        $file = "uploadfilingfiles/" . basename($_FILES['txtfilingpath']['name'][$i]);
                        echo "<br>----------------" .$file;
                      }
                      else
                      {
                         echo "<br>Sorry, there was a problem in uploading the file.";
                      }
                }
                if($filingfilename!=NULL)
                {
                    echo "insert into companies_filing_files (company_id,file_name) values(".$companyIdtoUpdate." ,'".$filingfilename."')";
                    mysql_query("insert into companies_filing_files (company_id,file_name) values(".$companyIdtoUpdate." ,'".$filingfilename."')");
                }
           }
       }
     
        /*$UpdatecompanySql="update pecompanies set companyname='$companyNameToUpdate',CINNo='$cinnotoUpdate',industry=$industryIdtoUpdate,
        sector_business='$sectorToUpdate',website='$urlToUpdate',linkedIn='$liToUpdate',stockcode='$stockToUpdate',
        yearfounded='$yearfoundedToUpdate',
        Address1='$address1ToUpdate',Address2='$address2ToUpdate',AdCity='$adCityToUpdate',Zip='$zipToUpdate',
        OtherLocation='$otherLocationToUpdate',countryid='$countryToUpdate',Telephone='$telToUpdate',Fax='$faxToUpdate', tags='$tagsToUpdate',
        Email='$emailToUpdate',AdditionalInfor='$addinforToUpdate',RegionId='$regionIdtoUpdatee' $filepath_inc $angelco_compID_inc where PECompanyId=$companyIdtoUpdate";*/
       
            $UpdatecompanySql='update pecompanies set companyname="'.$companyNameToUpdate.'",CINNo="'.$cinnotoUpdate.'",industry='.$industryIdtoUpdate.',
            sector_business="'.$sectorToUpdate.'",website="'.$urlToUpdate.'",linkedIn="'.$liToUpdate.'",city="'.$adCityToUpdate.'",stockcode="'.$stockToUpdate.'",
            yearfounded="'.$yearfoundedToUpdate.'", Address1="'.$address1ToUpdate.'",Address2="'.$address2ToUpdate.'",AdCity="'.$adCityToUpdate.'",Zip="'.$zipToUpdate.'",
            OtherLocation="'.$otherLocationToUpdate.'",countryid="'.$countryToUpdate.'",Telephone="'.$telToUpdate.'",Fax="'.$faxToUpdate.'", tags="'.$tagsToUpdate.'",
            Email="'.$emailToUpdate.'",AdditionalInfor="'.$addinforToUpdate.'",stateid="'.$StateIdtoUpdate.'",state="'.$state.'",region="'.$regiontext.'",RegionId='.$regionIdtoUpdatee. $filepath_inc . $angelco_compID_inc .' where PECompanyId='.$companyIdtoUpdate;

//        else 
//        {
//            $UpdatecompanySql="update pecompanies set companyname='$companyNameToUpdate',CINNo='$cinnotoUpdate',industry=$industryIdtoUpdate,
//            sector_business='$sectorToUpdate',website='$urlToUpdate',linkedIn='$liToUpdate',stockcode='$stockToUpdate',
//            yearfounded='$yearfoundedToUpdate',
//            Address1='$address1ToUpdate',Address2='$address2ToUpdate',AdCity='$adCityToUpdate',Zip='$zipToUpdate',
//            OtherLocation='$otherLocationToUpdate',countryid='$countryToUpdate',Telephone='$telToUpdate',Fax='$faxToUpdate',
//            Email='$emailToUpdate',AdditionalInfor='$addinforToUpdate',RegionId='$regionIdtoUpdatee', angelco_compID='$angelco_compID'  where PECompanyId=$companyIdtoUpdate";    
//        }
          
    	// $arraylength=$_POST['txtmgmtExecutiveId'];
		// 			$arraylengthcount=count($arraylength);
		// 			echo "<br>**********--Count--".$arraylengthcount;


    	
				echo "<br>company update Query-- " .$UpdatecompanySql;
                                $added_date = date('Y-m-d H:i:s');
                                $tags_details = mysql_query("select tags from pecompanies where PECompanyId=$companyIdtoUpdate");
                                $tags_detail = mysql_fetch_array($tags_details);
                                if($tagsToUpdate != $tags_detail['tags']){
                                    $ex_tags = explode(',',$tagsToUpdate);
                                    $ex_tags_db = explode(',',$tags_detail['tags']);
                                    if(count($ex_tags) > 0){
                                        for($l=0;$l<count($ex_tags);$l++){
                                            if($ex_tags[$l] !=''){ 
                                                $tag_name = trim($ex_tags[$l]);
                                                $tag_check = mysql_query("SELECT id FROM tags WHERE tag_name='$tag_name'" );
                                                $tag_check_count = mysql_num_rows($tag_check);
                                                if($tag_check_count == 0){
                                                    $ex_tag_name = explode(':',$tag_name);
                                                    $tag_type = $ex_tag_name[0];
                                                    if($tag_type == 'i'){
                                                        $tagType = 'Industry Tags';
                                                    }else if($tag_type == 's'){
                                                        $tagType = 'Sector Tags';
                                                    }else if($tag_type == 'c'){
                                                        $tagType = 'Competitor Tags';
                                                    }
                                                    $sql_insert_pl = "INSERT INTO tags ( tag_name,tag_type,created_date  )  VALUES ('$tag_name','$tagType','$added_date')";
                                                    $result_insert_pl = mysql_query($sql_insert_pl) or die(mysql_error());
                                                }
                                            }
                                        }
                                    }
                                    if(count($ex_tags_db) > 0){
                                        for($l=0;$l<count($ex_tags_db);$l++){
                                            if($ex_tags_db[$l] !=''){ 
                                                $tag_name = trim($ex_tags_db[$l]);
                                                if(!in_array($tag_name, $ex_tags) && !in_array($ex_tags_db[$l], $ex_tags)){
                                                    $tags_chck = mysql_query("select tags from pecompanies where (tags like '$tag_name,%' or tags like '%,$tag_name' or tags like '%,$tag_name,%' or tags like '$tag_name' or tags like '%, $tag_name' or tags like '%, $tag_name,%') and PECompanyId != $companyIdtoUpdate");
                                                    if(mysql_num_rows($tags_chck) == 0){
                                                        mysql_query("delete from tags where tag_name ='$tag_name'");
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
			if($updaters=mysql_query($UpdatecompanySql))
			{
				//board

				for ($j=0;$j<=$brdExecutiveIdArray-1;$j++)
				{
					echo "<br>---".$brdExecutiveIdArray[$j];
					if(trim($brdExecutiveName[$j])!="")
					{
						$splitbrd=explode(",",$brdExecutiveName[$j]);
						$bexeId=$brdExecutiveId[$j];
						$bexeName=trim($splitbrd[0]);
						$bexeDesig=trim($splitbrd[1]);
						$bexeCompany=trim($splitbrd[2]);
						$updateExeSql="Update executives set ExecutiveName='$bexeName',Designation='$bexeDesig',Company='$bexeCompany' where ExecutiveId=$bexeId";

						if($updateboardrs=mysql_query($updateExeSql))
						{
							echo "<br>Board.".$updateExeSql;
							//echo "<br>Board Executive Changed--".$bexeName;
						}


					}
					else
					{
						$bexeId=$brdExecutiveId[$j];
						$DeleteExeSql="Delete from executives where ExecutiveId=$bexeId";
						$DeleteMgmtSql="Delete from pecompanies_board where ExecutiveId=$bexeId and PECompanyId=$companyIdtoUpdate";
						if($rsdeleteMgmt=mysql_query($DeleteMgmtSql))
						{
							if($rsdeleteExe =mysql_query($DeleteExeSql))
								echo "<br>Delete Board & Executive--" .$DeleteMgmtSql;
						}
					}
				}

				//managment
				for ($i=0;$i<=$mgmtExecutiveIdArray-1;$i++)
				{
					if(trim($mgmtExecutiveName[$i])!="")
					{
						$splitmgmt=explode(",",$mgmtExecutiveName[$i]);
						$exeId=trim($mgmtExecutiveId[$i]);
						$exeName=trim($splitmgmt[0]);
						$exeDesig=trim($splitmgmt[1]);
						$exeCompany=trim($splitmgmt[2]);
						$updatemgmtSql="Update executives set ExecutiveName='$exeName',Designation='$exeDesig',Company='$exeCompany' where ExecutiveId=$exeId";

						if($updatemgmtrs=mysql_query($updatemgmtSql))
						{
							echo "<br>*.".$updatemgmtSql;
							//echo "<br>Managment Executive Changed".$exeName;
						}
						//echo "<br>--".$updateExeSql;
					}
					else
					{
						$exeId=$mgmtExecutiveId[$i];
						$DeleteExeSql="Delete from executives where ExecutiveId=$exeId";
						$DeleteMgmtSql="Delete from pecompanies_management where ExecutiveId=$exeId and PECompanyId=$companyIdtoUpdate";
						if($rsdeleteMgmt=mysql_query($DeleteMgmtSql))
						{
							if($rsdeleteExe =mysql_query($DeleteExeSql))
								echo "<br>Delete Mgmt & Executive--" .$DeleteMgmtSql;
						}
					}
				}
				

				for ($k=0;$k<=$compLinkArray-1;$k++)
				{
					//echo "<br>---".$compLinkhidden[$k];
					if(trim($compLink[$k])!="")
					{
						$companyLink=$compLink[$k];
						$companyComment=$compComment[$k];
						$companyLinkToUpdate=$compLinkhidden[$k];
						$updateCompLinkSql="Update pecompanies_links set Link=trim('$companyLink'),Comment='$companyComment' where PECompanyId=$companyIdtoUpdate and Link=trim('$companyLinkToUpdate')";
                                                //echo "<bR>--" .$updateCompLinkSql;
						if($rsupdateComp=mysql_query($updateCompLinkSql))
						{
                                                        //echo "<Br>**".$updateCompLinkSql;
                                                        echo "<br>" .$k+1 ."- Link, Comment Updated";
							//echo "<br>Board Executive Changed--".$bexeName;
						}
                               		}
                               		elseif((trim($compLink[$k])=="") && trim($compComment[$k]==""))
                               		{
                                              echo "<Br>---";
                                              $companyLinkToUpd=trim($compLinkhidden[$k]);
                                              $delCompLinkSql="delete from pecompanies_links  where PECompanyId=$companyIdtoUpdate and Link='$companyLinkToUpd'";
                                              echo "<Br>^^^^^^^^^^^^^^^^^^^".$delCompLinkSql;
                                              if($rsdelComp=mysql_query($delCompLinkSql))
						{

                                                         echo "<br><br>- Link, Comment Deleted";
							//echo "<br>Board Executive Changed--".$bexeName;
						}
                                        }
                               	}
		?>
				<tr><td>
				 <font style="font-family: Verdana; font-size: 8pt"><?php echo $companyNameToUpdate; ?> -- Profile updated</font>
				</td></tr>
		<?php
			}
		?>

</table>



<?php

} // if resgistered loop ends
else
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>
</form>
</body></html>