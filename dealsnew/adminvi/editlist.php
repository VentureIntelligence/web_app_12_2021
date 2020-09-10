<?php include_once("../../globalconfig.php"); ?>
<?php
require("../dbconnectvi.php");
	$Db = new dbInvestments();
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
 	{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<SCRIPT LANGUAGE="JavaScript">
function checklist()
{
	//alert(document.adddeal.txtregion.selectedIndex)
	missinginfo = "";
	/*var compname="Undisclosed";
	var usercompname;
	usercompname=document.adddeal.txtcompanyname.value;*/
	//alert(usercompname);
        if(document.addlist.repType.selectedIndex =='')
		missinginfo += "\n     -  Please select Type of Report";
            
        if(document.addlist.repTitle.value =='')
		missinginfo += "\n     -  Please enter Title of Report";
            
         if(document.addlist.repPeriod.selectedIndex =='')
		missinginfo += "\n     -  Please select Period of Report"; 
            
        if(document.addlist.date.value =='')
            missinginfo += "\n     -  Please enter Date";
            
	 if(document.addlist.txtcode.value =='')
            missinginfo += "\n     -  Please enter Nonobi Code";
        
	if (missinginfo != "")
	{
		alert(missinginfo);
		return false;
	}
	else
		return true;
}
</SCRIPT>
</head>
<body>
 <form name=addlist enctype="multipart/form-data" onSubmit="return checklist();" method=post action="addlistupdate.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=55%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
		<?php


			//echo "<br>*******-".$_SESSION['SessLoggedAdminPwd'];
		
			 $id= isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
                        
			if($id<>"")
			{
				 $nanoSql="select * from nanotool where id=".$id;
				if ($reportrs = mysql_query($nanoSql))
				 {
					$report_cnt = mysql_num_rows($reportrs);
				 }
			}
			else
			{
				$report_cnt=0;
			}
                        if ($report_cnt>0)
                        {
                                While($myrow=mysql_fetch_array($reportrs, MYSQL_BOTH))
                                {      
		?>
      <tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Add List</b></td></tr>

                                                <input type=hidden name="listid"  value="<?php echo $myrow["id"]; ?>" >
                                                <tr>
                                                    <td> Type of Report </td>
                                                    <Td width=5% align=left> <SELECT NAME="repType">
                                                     <OPTION id=1 value=""  <?php if($myrow['typeofReport']==''){echo "selected";}?>>Select Report Type </option>
                                                     <OPTION VALUE='PE' <?php if($myrow['typeofReport']=='PE'){echo "selected";}?>>PE</OPTION>
                                                     <OPTION VALUE='VC' <?php if($myrow['typeofReport']=='VC'){echo "selected";}?>>VC</OPTION>
                                                     <OPTION VALUE='Early_Stage' <?php if($myrow['typeofReport']=='Earlystage'){echo "selected";}?>>Early Stage</OPTION>
                                                     <OPTION VALUE='M&A' <?php if($myrow['typeofReport']=='M&A'){echo "selected";}?>>M&A</OPTION>
                                                     <OPTION VALUE='RE' <?php if($myrow['typeofReport']=='RE'){echo "selected";}?>>RE</OPTION>
                                                     <OPTION VALUE='Infra' <?php if($myrow['typeofReport']=='Infra'){echo "selected";}?>>Infra</OPTION>
                                                     <OPTION VALUE='Social' <?php if($myrow['typeofReport']=='Social'){echo "selected";}?>>Social</OPTION>
                                                     <OPTION VALUE='Cleantech' <?php if($myrow['typeofReport']=='Cleantech'){echo "selected";}?>>Cleantech</OPTION>
                                                     <OPTION VALUE='Other' <?php if($myrow['typeofReport']=='Other'){echo "selected";}?>>Other</OPTION>
                                                    </SELECT></td>
                                                </tr>
                                                <tr>
                                                    <td>Title of Report</td>
                                                        <td>
                                                        <input type="text" name="repTitle" size="50" value="<?php echo $myrow['titleofReport'];?>"> </td>
                                                </tr>
                                                <tr>
                                                    <td> Period of Report </td>
                                                    <Td width=5% align=left> <SELECT NAME="repPeriod">
                                                     <OPTION id=1 value="" <?php if($myrow['periodofReport']==''){echo "selected";}?>>Select Report Period </option>
                                                     <OPTION VALUE='Annual' <?php if($myrow['periodofReport']=='Annual'){echo "selected";}?>>Annual</OPTION>
                                                     <OPTION VALUE='Half_Yearly' <?php if($myrow['periodofReport']=='Half_Yearly'){echo "selected";}?>>Half Yearly</OPTION>
                                                     <OPTION VALUE='Quarterly' <?php if($myrow['periodofReport']=='Quarterly'){echo "selected";}?>>Quarterly</OPTION>
                                                     <OPTION VALUE='Monthly' <?php if($myrow['periodofReport']=='Monthly'){echo "selected";}?>>Monthly</OPTION>
                                                     <OPTION VALUE='Other' <?php if($myrow['periodofReport']=='Other'){echo "selected";}?>>Other</OPTION>
                                                    </SELECT></td>
                                                </tr>
                                                <tr >
                                                    <td >Access Right</td>
                                                    <td>

                                                    <input type=checkbox name="txtPE" value="1" <?php if($myrow['ar_PE']==1){echo "checked";}?>> PE
                                                    &nbsp;&nbsp;
                                                    <input type=checkbox name="txtVC" value="1" <?php if($myrow['ar_VC']==1){echo "checked";}?>> VC
                                                    &nbsp;&nbsp;
                                                    <input type=checkbox name="txtES" value="1" <?php if($myrow['ar_Earlystage']==1){echo "checked";}?>>Early Stage
                                                     &nbsp;&nbsp;
                                                    <input type=checkbox name="txtMA" value="1" <?php if($myrow['ar_MA']==1){echo "checked";}?>>M&A
                                                     &nbsp;&nbsp;
                                                     <input type=checkbox name="txtRE" value="1" <?php if($myrow['ar_RE']==1){echo "checked";}?>> RE
                                                    &nbsp;&nbsp;
                                                    <input type=checkbox name="txtInfra" value="1" <?php if($myrow['ar_Infra']==1){echo "checked";}?>> Infra
                                                    &nbsp;&nbsp;
                                                    <input type=checkbox name="txtSocial" value="1" <?php if($myrow['ar_Social']==1){echo "checked";}?>>Social
                                                     &nbsp;&nbsp;
                                                    <input type=checkbox name="txtClean" value="1" <?php if($myrow['ar_Cleantech']==1){echo "checked";}?>>Cleantech
                                                     &nbsp;&nbsp;</td>
                                                </tr>
                                                <tr><td >Date</td>
                                                    <td>
                                                    <input type="date" name="date" size="50" value="<?php if($myrow['date']!=""){echo $myrow['date'];}else{echo date('Y-m-d');}?>"> </td>
                                                </tr>
                                                <tr>
                                                    <td >Past Nanobi Embeded code</td>
                                                    <td >
                                                        <textarea name="txtcode" rows="3" cols="40" ><?php if($myrow['nanobi_EC']!=""){echo file_get_contents("./nanofolder/".$myrow['nanobi_EC']);}?></textarea> </td>
                                                </tr>
                                                <tr>
                                                    <td >Definition</td>
                                                    <td >
                                                    <textarea name="txtdef" rows="3" cols="40" ><?php if($myrow['definitions']!=""){echo $myrow['definitions'];}?></textarea> </td>
                                                </tr>



	<tr> <td colspan=2> &nbsp;</td></tr>
	<tr><td align=left> <a href="admin.php">Admin Home</a> </td><td align=right> <a href="viewlist.php">Report List</a> </td></tr>
</table>
   <table align=center>
<tr> <Td> <input type="submit" value="update" name="actionlist" > </td></tr></table>

     </form>
 <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
   </script>
<?php
                                }
                        }
                                else
                                {
                                    ?>
                                      <table border=1 align=center cellpadding=0 cellspacing=0 width=55%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
                                        <tr> <Td> No data found for this id.Please check </td></tr></table>
                                       <table align=center>
<tr> <Td> <input type="submit" value="Add" name="AddDeal" > </td></tr></table>
    <?php
                                }
                                ?>
 </body>
 </html>
<?php

} // if resgistered loop ends
else
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>