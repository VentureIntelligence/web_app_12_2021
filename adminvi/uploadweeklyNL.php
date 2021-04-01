<?php include_once("../globalconfig.php"); ?>
<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
require("checkaccess.php");
  checkaccess( 'upload_weeklyNL' );
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
<link rel="stylesheet" href="/resources/demos/style.css">
<link rel="stylesheet" href="../css/jquery-ui.css">
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<link href="../css/vistyle.css" rel="stylesheet" type="text/css">
<link href="../css/material-design-iconic-font.min.css" rel="stylesheet" type="text/css">
</head>
<style>
.popup_main
{
        position: fixed;
        left:0;
        top:0px;
        bottom:0px;
        right:0px;
        background: rgba(2,2,2,0.5);
        z-index: 999;
}
.popup_box
{
    width:30%;
    height: 0;
    position: relative;
    left:0px;
    right:0px;
    bottom:0px;
    top:35px;
    margin: auto;
    
}
.popup_content {
    background: #ececec;
    margin: auto;
    min-height: 150px;
    padding: 50px;
    box-sizing: border-box;
    text-align: center;
    font-size: 18px;
    color: #9a722c;
}
.popup_btn
{
    text-align: center;
    padding: 33px 0 50px;
    
}
.popup_cancel
{
    background: #d5d5d5;
    cursor: pointer;
    padding:10px 27px;
    text-align: center;
    color: #767676;
    text-decoration: none;
    margin-right: 16px;
    font-size: 16px;
    display: none;
    
}
.popup_btn input[type="button"]
{
    background: #a27639;
    cursor: pointer;
    padding:10px 27px;
    text-align: center;
    color: #fff;
    text-decoration: none;
    font-size: 16px;
    float: right;

}
.popup_close
{
    color: #fff;
    right: 0px;
    font-size: 20px;
    position: absolute;
    top: 1px;
    width: 15px;
    background: #413529;
    text-align: center;
}
.popup_close a
{
    color: #fff;
    text-decoration: none;
    cursor: pointer;
}
.popup_main .btn {
    background: transparent;
    border: 1px solid #9a722c;
    padding: 7px 25px;
    color: #9a722c;
    border-radius: 4px;
    outline: none;
    cursor: pointer;
}
.loader{
    position: fixed;
    left: 0;
    top: 0px;
    bottom: 0px;
    right: 0px;
    background: rgba(2,2,2,0.5);
    z-index: 999;
}
#preloading {
    background: url('<?php echo GLOBAL_BASE_URL; ?>dealsnew/images/linked-in.gif') no-repeat center center;
    height: 100px;
    width: 100px;
    position: fixed;
    left: 50%;
    top: 50%;
    margin: -25px 0 0 -25px;
    z-index: 1000;
}
</style>
<body>
<div class="loader" style="display: none;">
    <div id="preloading"></div>
</div>
   
        <div id="containerproductproducts">
            <!-- Starting Left Panel -->
            <?php include_once('leftpanel.php'); ?>
            <!-- Ending Left Panel -->
            <!-- Starting Work Area -->


                  <div style="width:570px; float:right; ">
                   
                         <div style="width:565px; float:left;">
                           <div style=" width:565px;">

                             <div id="maintextpro" style="background-color: #ffffff;width:100%; " class="main_content_container">
                                <div id="headingtextpro">
                                    <div class="acc-section">
                                       <?php if (isset($_FILES['upload'])) {
                                            $uploadDir = '/home/venture/public_html/ddw/'; //path you wish to store you uploaded files
                                            $uploadedFile = $uploadDir . basename($_FILES['upload']['name']);
                                               if(move_uploaded_file($_FILES['upload']['tmp_name'], $uploadedFile)) {
                                                    echo 'File was uploaded successfully.';
                                                } else {
                                                    echo 'There was a problem saving the uploaded file';
                                                }
                                                echo '<br/><br/><a href="uploadweeklyNL.php">Back to Uploader</a>'; 
                                            } else {
                                        ?>
                                        <form name="dealsupload" enctype="multipart/form-data" id="leaguefile" method="post" action="uploadweeklyNL.php">
                                            <div class="accordian">
                                                <h3 class="acc-title"><span>Weekly NL</span> <i class="zmdi zmdi-chevron-down"></i></h3>
                                                <div class="acc-content">
                                                    <p>Upload file through the window:</p>
                                                    <div class="upload-sec">
                                                        <input type="file" name="upload" class="ip-file">
                                                    </div>
                                                    <div class="btn-sec text-right">
                                                        <input type="submit" class="btn" value="upload" >
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    <?php }?>
                                    <!--  <?php if (isset($_FILES['uploadimage'])) {
                                            //$uploadDir = '/var/www/html/ventureintelligence/images/'; //path you wish to store you uploaded files
                                            $uploadedFile = $uploadDir . basename($_FILES['uploadimage']['name']);
                                              /* if(move_uploaded_file($_FILES['uploadimage']['tmp_name'], $uploadedFile)) {
                                                    echo 'Image was uploaded successfully.';
                                                } else {
                                                    echo 'There was a problem saving the uploaded file';
                                                }
                                                echo '<br/><br/><a href="uploadweeklyNL.php">Back to Uploader</a>'; 
                                            } else {*/
                                        ?> -->
                                       <!--  <form name="dealsupload" enctype="multipart/form-data" id="leaguefile" method="post" action="uploadweeklyNL.php">
                                            <div class="accordian">
                                                <h3 class="acc-title"><span>Image</span> <i class="zmdi zmdi-chevron-down"></i></h3>
                                                <div class="acc-content">
                                                    <p>Upload image for html through the window:</p>
                                                    <div class="upload-sec">
                                                        <input type="file" name="uploadimage" class="ip-file">
                                                    </div>
                                                    <div class="btn-sec text-right">
                                                        <input type="submit" class="btn" value="upload" >
                                                    </div>
                                                </div>
                                            </div>
                                        </form> -->
                                    <!-- <?php }?> -->


                                       
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
  <!-- Ending Work Area -->
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom1.js"></SCRIPT>
   

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
