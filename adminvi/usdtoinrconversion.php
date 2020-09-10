<?php include_once("../globalconfig.php"); ?>
<?php
    require("../dbconnectvi.php");
    $Db = new dbInvestments();
    require("checkaccess.php");
    checkaccess( 'currency_conversion' );
    session_save_path("/tmp");
    session_start();

    $inrvalue = "SELECT value FROM configuration WHERE purpose='USD_INR'";
    $inramount = mysql_query($inrvalue);
    while($inrAmountRow = mysql_fetch_array($inramount,MYSQL_BOTH))
    {
        $usdtoinramount = $inrAmountRow['value'];
    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="language" content="en-us" />
    <title>Venture Intelligence - Investor</title>

    <script type="text/javascript">
    function updateusdtoinr(){
        if($("#usd").val() == ''){
            alert("Please enter current INR value");
        } else {
            $(".loader").show();
            var formData = $("#getusdtoinr").serialize();
            $.ajax({
                url: 'updateinramount.php',
                type: "POST",
                data: formData,
                success: function(data){
                    $(".loader").hide();
                    $(".popup_main").show();
                    $("#textsucess").text(data);
                },
                error:function(){
                    $(".loader").hide();
                    $(".popup_main").hide();
                    alert("There was some problem ...");
                }

            });
        }
    }
    
    function closepopup(){
        $(".popup_main").hide();
    }
    </script>

    <style type="text/css">
    .acc-section {
        padding: 30px 20px;
    }
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
    <link href="../css/style_root.css" rel="stylesheet" type="text/css">

</head><body>

<form name="getusdtoinr"  method="post" id="getusdtoinr">
    <div id="containerproductpeview">
        <?php include_once('leftpanel.php'); ?>
        <div style="width:570px; float:right; ">
	        <div style="width:565px; float:left; padding-left:2px;">
	            <div style="background-color:#FFF; width:565px; /*height:482px;*/ " class="main_content_container">
                    <div id="maintextpro">
                        <div id="headingtextpro">
                            <div class="acc-section">
                                <lable>1 USD = </lable>
                                <input type="text" name="usd" id="usd" style="width:60px;" value="<?php echo $usdtoinramount; ?>" required/>
                                <lable> INR</lable><br><br>
                                <input type="button" value="Update" id="usdtoinr" onClick="updateusdtoinr();" />
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</form>
<div class="loader" style="display: none;">
    <div id="preloading"></div>
</div>
<div class="popup_main" id="popup_main" style="display:none;">    
	<div class="popup_box">
  		<span class="popup_close"><a href="javascript: void(0);" onClick="closepopup();">X</a></span>
  		<div class="popup_content" id="popup_content">
          <p id="textsucess"></p>
        </div>
	</div>	
</div>
    <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom1.js"></SCRIPT>
    <script src="../js/jquery.min.js"></script>
    <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
    </script>
    <script>
    $("#usd").keypress(function(e){
        if(e.which == 46 || e.which > 47 && e.which < 58){
            return true;
        } else {
            alert("Only Numbers is accepted");
            return false;
        }
    });
    </script>
    <script type="text/javascript">
        _uacct = "UA-1492351-1";
        urchinTracker();
    </script>

</body>
</html>
