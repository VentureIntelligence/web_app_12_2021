<?php
	require("../dbconnectvi.php");
	$Db = new dbInvestments();
    require("checkaccess.php");
  checkaccess( 'faq' );
 //session_save_path("/tmp");
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
        
            
        if(document.addlist.repQuestion.value =='')
		missinginfo += "\n     -  Please enter Question";
            
         if(document.addlist.repAnswer.value =='')
		missinginfo += "\n     -  Please enter Answer"; 
            
       /* if(document.addlist.repAssert.value =='')
            missinginfo += "\n     -  Please enter Assert";*/

        if(document.addlist.repDBtype.selectedIndex =='')
        missinginfo += "\n     -  Please select DB type";
            
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
<style>
    .txt-center{
        text-align: center;
    }
</style>

<body>
 <form name=addlist enctype="multipart/form-data" onSubmit="return checklist();" method=post action="newfaqlist.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=55%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">

   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Add FAQ</b></td></tr>


							
                                                        <tr>
                                                            <td class="txt-center">Question</td>
								<td>
								<input type="text" name="repQuestion" value="" style="width: 100%;"> </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="txt-center">Answer</td>
                                <td>
                                <textarea name="repAnswer" value="" style="width: 100%;"></textarea> </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="txt-center">Assert</td>
                                <td>
                                <input type="text" name="repAssert" value="" style="width: 100%;"> </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="txt-center">DB Type</td>
                                <td>
                                <SELECT NAME="repDBtype">
                                                             <OPTION value="" selected>Select DB Type </option>
                                                             <OPTION VALUE='CFS'>CFS</OPTION>
                                                             <OPTION VALUE='PE'>PE</OPTION>
                                                             <OPTION VALUE='M&A'>M&A</OPTION>
                                                             <OPTION VALUE='RE'>RE</OPTION>
                                                            </SELECT> </td>
                                                        </tr>


	<tr> <td colspan=2> &nbsp;</td></tr>
	<tr><td align=left> <a href="admin.php">Admin Home</a></td><td align=right>  </td></tr>
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
 	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>