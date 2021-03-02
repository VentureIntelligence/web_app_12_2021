<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
require("checkaccess.php");
  checkaccess( 'upload_deals' );
  session_save_path("/tmp");
session_start();
if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<SCRIPT LANGUAGE="JavaScript">
function getuploadcinno()
{
    if (document.dealsupload.cinfilepath.value == "")
    {
	alert("Please choose the file (Cin Number) .xls to import");
	return false;
    }
    else
    {
        //	return true;
	document.dealsupload.action="generateCinnumber.php";
	document.dealsupload.submit();
    }
}




</SCRIPT>

<link rel="stylesheet" href="/resources/demos/style.css">
<link rel="stylesheet" href="../css/jquery-ui.css">
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<link href="../css/vistyle.css" rel="stylesheet" type="text/css">
<link href="../css/material-design-iconic-font.min.css" rel="stylesheet" type="text/css">
</head>
<body>
    <form name="dealsupload" enctype="multipart/form-data"  method="post" >
        <div id="containerproductproducts">
            <!-- Starting Left Panel -->
            <?php include_once('leftpanel.php'); ?>
            <!-- Ending Left Panel -->
                  <div style="width:570px; float:right; ">
                   
                         <div style="width:565px; float:left; padding-left:2px;">
                           <div style=" width:565px;">

                             <div id="maintextpro" style="background-color: #ffffff;width:100%; " class="main_content_container">
                                <div id="headingtextpro">
                                    <div class="acc-section">
                                        <div class="accordian">
                                            <h3 class="acc-title"><span>M&A Deals</span> <i class="zmdi zmdi-chevron-down"></i></h3>
                                            <div class="acc-content">
                                                <p>Upload CIN Number:</p>
                                                <div class="upload-sec">
                                                    <input type="file" NAME="cinfilepath" class="ip-file">
                                                </div>
                                                <div class="btn-sec text-right">
                                                    <input type="button" class="btn" value="Generate Report" onClick="getuploadcinno();">
                                                </div>
                                            </div>
                                        </div>
                                        
                                       
                                    </div>


                                    <script type="text/javascript">
                                        $(function(){

                                            $(".accordian:first-child").addClass("active");

                                            $(".accordian .acc-title").on('click', function(){
                                                $(".accordian").removeClass("active");
                                                $(this).parent().addClass("active");
                                            });

                                        })
                                    </script>


                                 </div><!-- end of headingtextpro-->

                             </div> <!-- end of maintext pro-->

                           </div>
                         </div>

                   </div>
        </div>
  <!-- Ending Work Area --->
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