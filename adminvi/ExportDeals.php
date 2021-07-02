<?php include_once("../globalconfig.php"); ?>
<style>
    .ui-multiselect-menu.ui-widget.ui-widget-content.ui-corner-all {
        position: absolute;
        overflow: auto;
        display: none;
    }
    
    .selectgroup .ui-icon,
    .ui-helper-reset .ui-icon{
        display: inline-block;
    }
    
    .ui-multiselect-close {
        position: absolute;
        top: 5px;
        right: 3px;
        z-index: 1;
    }
    
    .ui-widget-header .ui-helper-reset {
        padding: 6px;
    }
    
    .ui-helper-reset li {
        display: inline-block;
        padding: 0 6px 0 0;
    }
    
    .ui-multiselect-checkboxes li {
        display: block;
    }
    
    .ui-helper-reset li a {
        font-size: 10px;
    }
    
    .ui-state-default .ui-icon {
        float: right;
        margin: 2px;
    }
    
    .ui-multiselect-checkboxes .ui-corner-all {
        padding: 4px;
        line-height: 28px;
    }
     .f-type.export-sec i{
        margin-top: 3px;
        margin-right: 10px;
    }
    .f-type.export-sec i b{
        margin:0px 6px;
    }
    .f-type.export-sec span:before{
        /*margin-top:3px;*/
        background:none !important;
    }

    input[type=button] {
        /* width: 20%; */
    border-radius: 5px;
    height: 30px;
    background-color: 413529;
    color: white;
    border: 2px solid;
    font-size: 14px;
    padding:0px 75px;
    margin-top:15px;
}


input[type=text], textarea {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  font-size: 14px;
}

input[type="radio"],input[type="checkbox"]
{
    font-size: 14px;
    float: left;
      clear: none;
      margin: 0px 0 0 2px;
}
label {
      /* float: left; */
      clear: none;
      display: block;
      padding: 0px 1em 0px 20px;
    }
    
</style>
<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
require("checkaccess.php");
    //checkaccess( 'subscribers' );
//session_save_path("/tmp");
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
<!-- calendar stylesheet -->
<link rel="stylesheet" href="../css/jquery-ui.css">
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<script src="../js/jquery.validate.min.js"></script>
<link href="../css/vistyle.css" rel="stylesheet" type="text/css">
<link href="../css/material-design-iconic-font.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" /> 
        <script type="text/javascript" src="js/jquery.multiselect.js"></script> 
        <link rel="stylesheet" type="text/css" href="css/token-input.css" />
      <link rel="stylesheet" type="text/css" href="css/token-input-facebook.css" />
        <script type="text/javascript" src="js/jquery.tokeninput.js"></script> 

</head>

<body>
    <form name="adminFilter" id="adminFilter" method="post" action="exportcompanydeals.php" >
        <div id="containerproductproducts">
        <!-- Starting Left Panel -->
        <?php include_once 'leftpanel.php'; ?>
        <!-- Ending Left Panel -->
        <div style="width:570px; float:right; background-color:#FFF; ">
                <div style="width:565px; float:left; padding-left:2px;">
                    <div style="padding:0px 15px">
                        <div id="maintextpro">
                            <div id="headingtextpro">
                                <h3 style="margin-bottom:15px;float:left;">Export PE Companies</h3>
                                <!-- <a href="EditAdminFilter.php" style="padding: 15px;;float: right;text-decoration:underline">Back to filters list</a> -->
                            </div>
                        </div>
                        <div id="formtextpro" >
                        <div class="display:flex">
                          <h3 style="float:left;    padding: 5px;">Company:</h3>
 
                        <input type="text" name="companyauto_sug" id="companyauto_sug" autocomplete="off">
                        </div> 
                        <div class="display:flex">
 
                        <h3 style="float:left;    padding: 5px;">All:</h3>

                        <input type="checkbox" name="allcompanyauto_sug" id="allcompanyauto_sug" value=0 style="    margin: 19px;">
                        </div>
                        <input type="submit" value="Export" style="float:right"><br><br><br><br>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Starting Work Area -->
            
  <!-- Ending Work Area -->

</div>
<script>
$('#allcompanyauto_sug').change(function() {
        if(this.checked) {
            $('#allcompanyauto_sug').val(1)
        }
        else
        {
            $('#allcompanyauto_sug').val(0)
   
        }
    });
 $("#companyauto_sug").tokenInput("ajaxCompanyDetails_auto.php?vcflag=0",{
            theme: "facebook",
            minChars:2,
            queryParam: "pe_cq",
            hintText: "",
            noResultsText: "No Result Found",
            preventDuplicates: true,
                onAdd: function (item) {
                   // $("#companyauto_sug").tokenInput("add", {id: item.id, name: item.name});

                },
                onDelete: function (item) {
                    var selectedValues = $('#companyauto_sug').tokenInput("get");
                    var inputCount = selectedValues.length;
                    if(inputCount==0){ 
                       // reloadPage();
                      // enableFileds();
                    }
        },
            prePopulate : <?php if($companysug_response!=''){echo   $companysug_response; }else{ echo 'null'; } ?>
        });
     
</script>

</body>
</html>
<?php

} // if resgistered loop ends
else
	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>



