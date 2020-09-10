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
function getDealImport()
{
    if (document.dealsupload.mamadealsfilepath.value == "")
    {
	alert("Please choose the file (MAMA Deals) .xls to import");
	return false;
    }
    else
    {
        //	return true;
	document.dealsupload.action="madealsimport.php";
	document.dealsupload.submit();
    }
}

function getincDealImport()
{
    if (document.dealsupload.incdealsfilepath.value == "")
    {
	alert("Please choose the file (Incubation Deals) .xlxs to import");
	return false;
    }
    else
    {
        //	return true;
	document.dealsupload.action="incdealsimport.php";
	document.dealsupload.submit();
    }
}

function getangelDealImport()
{
    if (document.dealsupload.angeldealsfilepath.value == "")
    {
	alert("Please choose the file (Angel Deals) .xlxs to import");
	return false;
    }
    else
    {
        //	return true;
	document.dealsupload.action="angeldealsimport.php";
	document.dealsupload.submit();
    }
}

function getpeDealImport()
{
    if (document.dealsupload.pedealsfilepath.value == "")
    {
	alert("Please choose the file (PE Deals) .xlxs to import");
	return false;
    }
    else
    {
        //	return true;
	document.dealsupload.action="pedealsimport.php";
	document.dealsupload.submit();
    }
}
function getLPDirImport()
{
    if (document.dealsupload.lpdirfilepath.value == "")
    {
    alert("Please choose the file (LP Directory) .xlxs to import");
    return false;
    }
    else
    {
        //  return true;
    document.dealsupload.action="lpdirimport.php";
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
            <!-- Starting Work Area -->

<!--            <div style="width:570px; float:right; ">
                <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/top1.js"></SCRIPT>
                <SCRIPT>
                call()
                </script>

                <div style="width:565px; float:left; padding-left:2px;">
                    <div style="background-color:#FFF; width:565px; height:542px; margin-top:4px;">
                        <div id="maintextpro">
                            <div id="headingtextpro">
                                <div style="margin-top: 20px;border: 1px solid;padding: 15px;">
                                    <span style="padding: 17px 15px 28px 15px;font-size: 16px;margin-top: 20px;">Upload <b>M&A deals </b> as .xlxs file through this window:</span>
                                    <INPUT NAME="mamadealsfilepath" TYPE="file" size=50 style="padding:15px 15px 15px 15px;font-size: 16px;"><br />
                                    <div style="width:500px;padding: 10px 0px 0px 15px;">
                                        <input type="button" value="Upload MAMA Deals" name="btnimportredeals" onClick="getDealImport();" >
                                    </div> <br />
                                </div>

                                <div style="margin-top: 20px;border: 1px solid;padding: 15px;">
                                    <span style="padding: 17px 15px 28px 15px;font-size: 16px;margin-top: 20px;">Upload <b>Incubation deals </b> as .xlxs file through this window:</span>
                                    <INPUT NAME="incdealsfilepath" TYPE="file" size=50 style="padding:15px 15px 15px 15px;font-size: 16px;"><br />
                                    <div style="width:500px;padding: 10px 0px 0px 15px;">
                                        <input type="button" value="Upload Incubation Deals" name="btnimportredeals" onClick="getincDealImport();" >
                                    </div> <br />
                                </div>

                                <div style="margin-top: 20px;border: 1px solid;padding: 15px;">
                                    <span style="padding: 17px 15px 28px 15px;font-size: 16px;margin-top: 20px;">Upload <b>Angel deals </b> as .xlxs file through this window:</span>
                                    <INPUT NAME="angeldealsfilepath" TYPE="file" size=50 style="padding:15px 15px 15px 15px;font-size: 16px;"><br />
                                    <div style="width:500px;padding: 10px 0px 0px 15px;">
                                        <input type="button" value="Upload Angel Deals" name="btnimportredeals" onClick="getangelDealImport();" >
                                    </div> <br />
                                </div>
                                
                                <div style="margin-top: 20px;border: 1px solid;padding: 15px;">
                                    <span style="padding: 17px 15px 28px 15px;font-size: 16px;margin-top: 20px;">Upload <b>PE deals </b> as .xlxs file through this window:</span>
                                    <INPUT NAME="pedealsfilepath" TYPE="file" size=50 style="padding:15px 15px 15px 15px;font-size: 16px;"><br />
                                    <div style="width:500px;padding: 10px 0px 0px 15px;">
                                        <input type="button" value="Upload PE Deals" name="btnimportredeals" onClick="getpeDealImport();" >
                                    </div> <br />
                                </div>

                            </div> end of headingtextpro
                        </div>  end of maintext pro
                    </div>
                </div>
            </div>-->
                  <div style="width:570px; float:right; ">
                   
                         <div style="width:565px; float:left; padding-left:2px;">
                           <div style=" width:565px;">

                             <div id="maintextpro" style="background-color: #ffffff;width:100%; " class="main_content_container">
                                <div id="headingtextpro">
                                    <div class="acc-section">
                                        <div class="accordian">
                                            <h3 class="acc-title"><span>M&A Deals</span> <i class="zmdi zmdi-chevron-down"></i></h3>
                                            <div class="acc-content">
                                                <p>Upload and .xls file through the window:</p>
                                                <div class="upload-sec">
                                                    <input type="file" NAME="mamadealsfilepath" class="ip-file">
                                                </div>
                                                <div class="btn-sec text-right">
                                                    <input type="button" class="btn" value="Upload" onClick="getDealImport();">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordian">
                                            <h3 class="acc-title"><span>Angel Deals</span> <i class="zmdi zmdi-chevron-down"></i></h3>
                                            <div class="acc-content">
                                                <p>Upload and .xls file through the window:</p>
                                                <div class="upload-sec">
                                                    <input type="file" NAME="angeldealsfilepath" class="ip-file">
                                                </div>
                                                <div class="btn-sec text-right">
                                                    <input type="button" class="btn" value="Upload"  onClick="getangelDealImport();">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordian">
                                            <h3 class="acc-title"><span>Incubation Deals</span> <i class="zmdi zmdi-chevron-down"></i></h3>
                                            <div class="acc-content">
                                                <p>Upload and .xls file through the window:</p>
                                                <div class="upload-sec">
                                                    <input type="file" NAME="incdealsfilepath" class="ip-file">
                                                </div>
                                                <div class="btn-sec text-right">
                                                    <input type="button" class="btn" value="Upload" onClick="getincDealImport();">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordian">
                                            <h3 class="acc-title"><span>PE Deals</span> <i class="zmdi zmdi-chevron-down"></i></h3>
                                            <div class="acc-content">
                                                <p>Upload and .xls file through the window:</p>
                                                <div class="upload-sec">
                                                    <input type="file" NAME="pedealsfilepath" class="ip-file">
                                                </div>
                                                <div class="btn-sec text-right">
                                                    <input type="button" class="btn" value="Upload" onClick="getpeDealImport();">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordian">
                                            <h3 class="acc-title"><span>LP Directory</span> <i class="zmdi zmdi-chevron-down"></i></h3>
                                            <div class="acc-content">
                                                <p>Upload and .xls file through the window:</p>
                                                <div class="upload-sec">
                                                    <input type="file" NAME="lpdirfilepath" class="ip-file">
                                                </div>
                                                <div class="btn-sec text-right">
                                                    <input type="button" class="btn" value="Upload" onClick="getLPDirImport();">
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