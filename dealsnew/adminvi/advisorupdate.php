<?php

require("../dbconnectvi.php");
  $Db = new dbInvestments();
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
     	session_start();
	 	if (session_is_registered("SessLoggedAdminPwd"))
	 	{
                  $advisorIdtoUpdate=$_POST["txtadvisorId"];
                  $advisornametoUpdate= $_POST["txtadvisor"];
                 // $sectortoUpdate=$_POST["txtsector"];
                  $websitetoUpdate=$_POST["txtwebsite"];
                  $advisortypetoUpdate=$_POST["txtadvsiortype"];
                  
                  $updateAdvisorSql= "Update advisor_cias set sector_business='$sectortoUpdate',
                   	website='$websitetoUpdate', Advisortype='$advisortypetoUpdate' where CIAId=$advisorIdtoUpdate";
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