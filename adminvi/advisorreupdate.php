<?php
require("../dbconnectvi.php");
  $Db = new dbInvestments();
 session_save_path("/tmp");
     	session_start();
	 	if (session_is_registered("SessLoggedAdminPwd"))
	 	{
                  $advisorIdtoUpdate=$_POST["txtadvisorId"];
                  $advisornametoUpdate= $_POST["txtadvisor"];
                 // $sectortoUpdate=$_POST["txtsector"];
                  $websitetoUpdate=  trim(addslashes($_POST["txtwebsite"]));
                  $advisortypetoUpdate=trim(addslashes($_POST["txtadvsiortype"]));
                  $address=trim(addslashes($_POST["txtaddress"]));
                  $city=trim(addslashes($_POST["txtcity"]));
                  $country=trim(addslashes($_POST["txtcountry"]));
                  $phoneno=trim(addslashes($_POST["txtphoneno"]));
                  $contactperson=trim(addslashes($_POST["txtcontactperson"]));
                  $designation=trim(addslashes($_POST["txtdesignation"]));
                  $email=trim(addslashes($_POST["txtemail"]));
                  $linkedin=trim(addslashes($_POST["txtlinkedin"]));
                  
                /*  $updateAdvisorSql= "Update REadvisor_cias set sector_business='$sectortoUpdate',
                   	website='$websitetoUpdate', Advisortype='$advisortypetoUpdate' where CIAId=$advisorIdtoUpdate";*/
                  $updateAdvisorSql= "Update REadvisor_cias set website='$websitetoUpdate', Advisortype='$advisortypetoUpdate', address='$address', city='$city', country='$country', phoneno='$phoneno', contactperson='$contactperson', designation='$designation', email='$email', linkedin='$linkedin' where CIAId=$advisorIdtoUpdate";
                  if ($advisorIdtoUpdate >0)
                  {
                    echo "<br>--" .$updateAdvisorSql;
                        if($updaters=mysql_query($updateAdvisorSql))
      	          {    echo "<br>DEAL UPDATED" ; }
      	          else
      	          {  echo "<br> Update failed " ; }
      	          }
                 }
?>