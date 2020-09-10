<?php include_once("../../globalconfig.php"); ?>
<?php
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	{
		$currentyear = date("Y");
                
?>
<html><head>
<title>Add PE Investment Deal Info</title>
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
<!--<link href="../style.css" rel="stylesheet" type="text/css">-->
</head>

<body>
 <form name=addlist enctype="multipart/form-data" onSubmit="return checklist();" method=post action="newaddlist.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=55%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
	require("../dbconnectvi.php");
	$Db = new dbInvestments();
?>

   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Add List</b></td></tr>


							<tr>
                                                            <td> Type of Report </td>
                                                            <Td width=5% align=left> <SELECT NAME="repType">
                                                             <OPTION id=1 value=""  selected>Select Report Type </option>
                                                             <OPTION VALUE='PE'>PE</OPTION>
                                                             <OPTION VALUE='VC'>VC</OPTION>
                                                             <OPTION VALUE='Earlystage'>Early Stage</OPTION>
                                                             <OPTION VALUE='M&A'>M&A</OPTION>
                                                             <OPTION VALUE='RE'>RE</OPTION>
                                                             <OPTION VALUE='Infra'>Infra</OPTION>
                                                             <OPTION VALUE='Social'>Social</OPTION>
                                                             <OPTION VALUE='Cleantech'>Cleantech</OPTION>
                                                             <OPTION VALUE='Other'>Other</OPTION>
                                                            </SELECT></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Title of Report</td>
								<td>
								<input type="text" name="repTitle" size="50" value=""> </td>
                                                        </tr>
                                                        <tr>
                                                            <td> Period of Report </td>
                                                            <Td width=5% align=left> <SELECT NAME="repPeriod">
                                                             <OPTION id=1 value="" selected>Select Report Period </option>
                                                             <OPTION VALUE='Annual'>Annual</OPTION>
                                                             <OPTION VALUE='Half_Yearly'>Half Yearly</OPTION>
                                                             <OPTION VALUE='Quarterly'>Quarterly</OPTION>
                                                             <OPTION VALUE='Monthly'>Monthly</OPTION>
                                                             <OPTION VALUE='Other'>Other</OPTION>
                                                            </SELECT></td>
                                                        </tr>
                                                        <tr >
                                                            <td >Access Right</td>
                                                            <td>

                                                            <input type=checkbox name="txtPE" value="1"> PE
                                                            &nbsp;&nbsp;
                                                            <input type=checkbox name="txtVC" value="1" > VC
                                                            &nbsp;&nbsp;
                                                            <input type=checkbox name="txtES" value="1" >Early Stage
                                                             &nbsp;&nbsp;
                                                            <input type=checkbox name="txtMA" value="1" >M&A
                                                             &nbsp;&nbsp;
                                                             <input type=checkbox name="txtRE" value="1"> RE
                                                            &nbsp;&nbsp;
                                                            <input type=checkbox name="txtInfra" value="1"> Infra
                                                            &nbsp;&nbsp;
                                                            <input type=checkbox name="txtSocial" value="1">Social
                                                             &nbsp;&nbsp;
                                                            <input type=checkbox name="txtClean" value="1">Cleantech
                                                             &nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr><td >Date</td>
                                                            <td>
                                                            <input type="date" name="date" size="50" value="<?php echo date('Y-m-d');?>" > </td>
                                                        </tr>
                                                        <tr>
                                                            <td >Past Nanobi Embeded code</td>
                                                            <td >
                                                            <textarea name="txtcode" rows="3" cols="40" value=""></textarea> </td>
                                                        </tr>
                                                        <tr>
                                                            <td >Definition</td>
                                                            <td >
                                                            <textarea name="txtdef" rows="3" cols="40" value=""></textarea> </td>
                                                        </tr>



	<tr> <td colspan=2> &nbsp;</td></tr>
	<tr><td align=left> <a href="admin.php">Admin Home</a></td><td align=right> <a href="viewlist.php">Report List</a> </td></tr>
</table>

<table align=center>
<tr> <Td> <input type="submit" value="add" name="actionlist" > </td></tr></table>




     </form>
 <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
   </script>

 </body>
 </html>
 <?php

 } // if resgistered loop ends
 else
 	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>