<?php
require("../dbconnectvi.php");
	$Db = new dbInvestments();
require("checkaccess.php");
checkaccess( 'import' );
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

function getTimeDataImport()
{
    if (document.dealsinput.txttimefilepath.value == "")
    {
	alert("Please choose the file (time sheet) to import");
	return false;
    }
    else
    {
    //	return true;
	document.dealsinput.action="importtimedim.php";
	document.dealsinput.submit();
    }
}
function getCFSImport()
{
  if (document.dealsinput.txtcfs.value == "")
    {
	alert("Please choose the financial structure to import");
	return false;
    }
    else
    {
    //	return true;
	document.dealsinput.action="importfs.php";
	document.dealsinput.submit();
    }
}




</SCRIPT>

<link href="../css/vistyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="dealsinput" enctype="multipart/form-data"  method="post" >
<div id="containerproductproducts">
<!-- Starting Left Panel -->
  <?php include_once('leftpanel.php'); ?>
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/top1.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>

	<div style="width:565px; float:left; padding-left:2px;">
	  <div style="background-color:#FFF; width:565px; /*height:542px;*/ margin-top:4px;" class="main_content_container">
	    <div id="maintextpro">

        <div id="headingtextpro">

                        Import <b> Time Data </b> as .txt file through this window:
			<br />

			<INPUT NAME="txttimefilepath" TYPE="file" size=50>
			<br / >

				<span style="float:right" class="one">
					<input type="button" value=" Import Time Sheet " name="btntimeimporttxt" onClick="getTimeDataImport();" >
				</span> <br />

 		        Import <b> Financial Structure </b> as .txt file through this window:
			<br />

			<INPUT NAME="txtcfs" TYPE="file" size=50>
			<br / >

				<span style="float:right" class="one">
					<input type="button" value="Import Financial  " name="btnfinancial" onClick="getCFSImport();" >
				</span> <br />








		</div><!-- end of headingtextpro-->
        </div> <!-- end of maintext pro-->
	  </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom1.js"></SCRIPT>
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