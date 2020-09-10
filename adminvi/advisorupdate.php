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
                  $websitetoUpdate=  addslashes($_POST["txtwebsite"]);
                  $advisortypetoUpdate=addslashes($_POST["txtadvsiortype"]);
                  $address=addslashes($_POST["txtaddress"]);
                  $city=addslashes($_POST["txtcity"]);
                  $country=addslashes($_POST["txtcountry"]);
                  $phoneno=addslashes($_POST["txtphoneno"]);
                  $contactperson=addslashes($_POST["txtcontactperson"]);
                  $designation=addslashes($_POST["txtdesignation"]);
                  $email=addslashes($_POST["txtemail"]);
                  $linkedin=addslashes($_POST["txtlinkedin"]);
                  
                /*  $updateAdvisorSql= "Update advisor_cias set sector_business='$sectortoUpdate',
                   	website='$websitetoUpdate', Advisortype='$advisortypetoUpdate' where CIAId=$advisorIdtoUpdate";*/
                  $updateAdvisorSql= "Update advisor_cias set website='$websitetoUpdate', Advisortype='$advisortypetoUpdate', address='$address', city='$city', country='$country', phoneno='$phoneno', contactperson='$contactperson', designation='$designation', email='$email', linkedin='$linkedin' where CIAId=$advisorIdtoUpdate";
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