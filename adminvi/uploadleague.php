<?php include_once("../globalconfig.php"); ?>
<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
require("checkaccess.php");
  checkaccess( 'upload_league' );
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
function overrideImport(value){
    if(value == "Yes"){
        $(".loader").show();
        $("#popup_main").hide();
        var formData = new FormData($('#leaguefile')[0]);
        $.ajax({
            url: 'leaguetableimport.php?override=true',
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data){
                $(".loader").hide();
                $("#popup_main").show();
                $('#fileexists').hide();
                $('.ip-file').val('');
                $('#textsucess').html("League Table is Updated Successfully !!!");
            },
            error:function(){
                $(".loader").hide();
                $("#popup_main").hide();
                alert("There was some problem ...");
            }
        });
    } else {
        $('.ip-file').val('');
        $("#popup_main").hide();
    }
    
}
function closepopup(){
    $('.ip-file').val('');
    $('.ip-file-test').val('');
    $(".popup_main").hide();
}
function getLeagueImport()
{
    if (document.dealsupload.leaguefilepath.value == "")
    {
        alert("Please choose the file League Table .xlsx to import");
        return false;
    }
    else
    {
        var formData = new FormData($('#leaguefile')[0]);
        //$(".popup_main").show();
        $(".loader").show();
        
        $.ajax({
            url: 'leaguetableimport.php',
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data){
                $(".loader").hide();
                $("#popup_main").show();
                if(data == "File exists"){
                    $('#fileexists').show();
                } 
                if(data == "File Format"){
                    $('#fileexists').hide();
                    $('#textsucess').html("File Format issue . Please upload the file .xlsx to import");
                }
                if(data == "Success"){
                    $('#fileexists').hide();
                    $('.ip-file').val('');
                    $('#textsucess').html("League Table is Updated Successfully !!!");
                }
            },
            error:function(){
                $(".loader").hide();
                $("#popup_main").hide();
                alert("There was some problem ...");
            }

        });
    }
}
function overrideTestImport(value){
    if(value == "Yes"){
        $(".loader").show();
        $("#popup_main_test").hide();
        var formData = new FormData($('#leaguefiletest')[0]);
        $.ajax({
            url: 'leaguetabletestimport.php?override=true',
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data){
                $(".loader").hide();
                $("#popup_main_test").show();
                $('#fileexiststest').hide();
                $('.ip-file-test').val('');
                $('#textsucesstest').html("League Table is Updated Successfully !!!");
            },
            error:function(){
                $(".loader").hide();
                $("#popup_main_test").hide();
                alert("There was some problem ...");
            }
        });
    } else {
        $('.ip-file-test').val('');
        $("#popup_main_test").hide();
    }
    
}
function getLeagueTestImport()
{
    if (document.dealsuploadtest.leaguefilepathtest.value == "")
    {
        alert("Please choose the file League Table .xlsx to import");
        return false;
    }
    else
    {
        var formData = new FormData($('#leaguefiletest')[0]);
        //$(".popup_main").show();
        $(".loader").show();
        
        $.ajax({
            url: 'leaguetabletestimport.php',
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data){
                $(".loader").hide();
                $("#popup_main_test").show();
                if(data == "File exists"){
                    $('#fileexiststest').show();
                } 
                if(data == "File Format"){
                    $('#fileexiststest').hide();
                    $('#textsucesstest').html("File Format issue . Please upload the file .xlsx to import");
                }
                if(data == "Success"){
                    $('#fileexiststest').hide();
                    $('.ip-file-test').val('');
                    $('#textsucesstest').html("League Table is Updated Successfully !!!");
                }
            },
            error:function(){
                $(".loader").hide();
                $("#popup_main_test").hide();
                alert("There was some problem ...");
            }

        });
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
<div class="popup_main" id="popup_main" style="display:none;">    
    <div class="popup_box">
        <span class="popup_close"><a href="javascript: void(0);" onClick="closepopup();">X</a></span>
        <div class="popup_content" id="popup_content">
          <p id="textsucess"></p>
          <div id="fileexists">
              <p>Filename already exists is the server . Do you want to override the same file.</p> 
              <input type="button" class="btn" value="Yes" onClick="overrideImport(this.value);">
              <input type="button" class="btn" value="No" onClick="overrideImport(this.value);">
          </div>
        </div>
    </div>  
</div>

<div class="popup_main" id="popup_main_test" style="display:none;">    
    <div class="popup_box">
        <span class="popup_close"><a href="javascript: void(0);" onClick="closepopup();">X</a></span>
        <div class="popup_content" id="popup_content">
          <p id="textsucesstest"></p>
          <div id="fileexiststest">
              <p>Filename already exists is the server . Do you want to override the same file.</p> 
              <input type="button" class="btn" value="Yes" onClick="overrideTestImport(this.value);">
              <input type="button" class="btn" value="No" onClick="overrideTestImport(this.value);">
          </div>
        </div>
    </div>  
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
                                        <form name="dealsupload" enctype="multipart/form-data" id="leaguefile" method="post" >
                                            <div class="accordian">
                                                <h3 class="acc-title"><span>League Table</span> <i class="zmdi zmdi-chevron-down"></i></h3>
                                                <div class="acc-content">
                                                    <p>Upload and .xlsx file through the window:</p>
                                                    <div class="upload-sec">
                                                        <input type="file" name="leaguefilepath" class="ip-file">
                                                    </div>
                                                    <div class="btn-sec text-right">
                                                        <input type="button" class="btn" value="Upload" onClick="getLeagueImport();">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <form name="dealsuploadtest" enctype="multipart/form-data" id="leaguefiletest" method="post" >
                                            <div class="accordian">
                                                <h3 class="acc-title"><span>League Table Test</span> <i class="zmdi zmdi-chevron-down"></i></h3>
                                                <div class="acc-content">
                                                    <p>Upload and .xlsx file through the window:</p>
                                                    <div class="upload-sec">
                                                        <input type="file" name="leaguefilepathtest" class="ip-file-test">
                                                    </div>
                                                    <div class="btn-sec text-right">
                                                        <input type="button" class="btn" value="Upload" onClick="getLeagueTestImport();">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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