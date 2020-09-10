<?php
require("../dbconnectvi.php");
	$Db = new dbInvestments();
    require("checkaccess.php");
  checkaccess( 'admin_report' );
 session_save_path("/tmp");
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
</head>
<style>
    .txt-center{
        text-align: center;
    }
</style>
<body>
 <form name=addlist enctype="multipart/form-data" onSubmit="return checklist();" method=post action="addfaqlistupdate.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=55%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
		<?php


			//echo "<br>*******-".$_SESSION['SessLoggedAdminPwd'];
		
			 $id= isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
                        
			if($id<>"")
			{
				 $nanoSql="select * from faq where id=".$id;

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
                                                            <td class="txt-center">Question</td>
                                <td>
                                <input type="text" name="repQuestion" value="<?php echo $myrow['question'];?>" style="width: 97%"> </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="txt-center">Answer</td>
                                <td>
                                <textarea name="repAnswer" value="" style="width: 97%"><?php echo $myrow['answer'];?></textarea> </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="txt-center">Assert</td>
                                <td>
                                <input type="text" name="repAssert" value="<?php echo $myrow['assert'];?>" style="width: 97%"> </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="txt-center">DB Type</td>
                                <td>
                                <SELECT NAME="repDBtype">
                                                             <OPTION value="" <?php if($myrow['DBtype']==''){echo "selected";}?>>Select DB Type </option>
                                                             <OPTION VALUE='CFS' <?php if($myrow['DBtype']=='CFS'){echo "selected";}?>>CFS</OPTION>
                                                             <OPTION VALUE='PE' <?php if($myrow['DBtype']=='PE'){echo "selected";}?>>PE</OPTION>
                                                             <OPTION VALUE='M&A' <?php if($myrow['DBtype']=='M&A'){echo "selected";}?>>M&A</OPTION>
                                                             <OPTION VALUE='RE' <?php if($myrow['DBtype']=='RE'){echo "selected";}?>>RE</OPTION>
                                                            </SELECT> </td>
                                                        </tr>
                                                


	<tr> <td colspan=2> &nbsp;</td></tr>
	<tr><td align=left> <a href="admin.php">Admin Home</a> </td><td align=right> <a href="viewfaqlist.php">Report List</a> </td></tr>
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
	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>