<?php include_once("globalconfig.php"); ?>
<?php
error_reporting(0);

    require("dbconnectvi.php");
    $Db = new dbInvestments();

    if($_REQUEST['id']!='')
    {
        $value = $_REQUEST['id'];

        $SQL = "select * from feedback where id=".$value;
        $sqlres= mysql_query($SQL) or die(mysql_error());

        $result = "";
        $result .= "<div class='login-right'>
                <h3>Give us your feedback</h3>"; 
        $result .= "<div id='display'>";
        while($row = mysql_fetch_assoc($sqlres)){
        $result .= "<p>{$row['feedback']}</p>";
        }
        $result .= "</div></div><br>";
    }
   ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Venture Intelligence Private Equity & Venture Capital database</title>
<meta  name="description" content="" />
<meta name="keywords" content="" />
<link rel="stylesheet" href="css/login.css" />
    
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.js"></script>  
<script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="js/ui.dropdownchecklist.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "5cb56486-feb9-4357-8585-f22677ecbd8d", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
<!--script>
    $(document).ready(function(){

        $("#socialmedia").hide();
        });
</script-->

</head>

<body class="loginpage"> 
 
<!--Header-->

<div class="login-screen">

<div class="headerlg">
<div class="cnt-left"><div class="logo"><a href="<?php echo GLOBAL_BASE_URL; ?>"><img src="img/logo-b.png" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></div>

<ul>
<li><a href="<?php echo GLOBAL_BASE_URL; ?>index.htm" class="active">Home</a></li>
<li><a href="<?php echo GLOBAL_BASE_URL; ?>products.htm" >Products</a></li>
<li><a href="<?php echo GLOBAL_BASE_URL; ?>events.htm">Events</a></li>
<li><a href="<?php echo GLOBAL_BASE_URL; ?>news.htm">News</a></li>
<li><a href="<?php echo GLOBAL_BASE_URL; ?>aboutus.htm">About Us</a></li>
<li class="last"><a href="<?php echo GLOBAL_BASE_URL; ?>contactus.htm">Contact Us</a></li>
</ul>
</div>
    
<div class="login-container">
<div   class="login-left"></div>
<div class="login-right" id="refer-right">
    <h3>Give us your feedback</h3>
    <div>
        <form>
            <ul>
                <li>
                    <div class="feedalign"><input type="radio" name="referer1" id="referer"  value="1"/>
                    <p>Using Venture Intelligence for several years now. Very exhaustive Indian #PrivateEquity, #VentureCapital & #M&A related data.<?php echo GLOBAL_BASE_URL;trialrequest.php</p></div> 
                </li>
                <li>
                    <div class="feedalign"><input type="radio" name="referer2" id="referer"  value="2"/>
                    <p >Found some really interesting undisclosed PE –VC deals on Venture Intelligence. <?php echo GLOBAL_BASE_URL; ?> /products.htm</p></div>
                </li>
                <li>
                    
                    <div class="feedalign"><input type="radio" name="referer3" id="referer"  value="3"/>
                     <p>Very exhaustive valuation coverage on Indian PE deals. Quite Interesting. <?php echo GLOBAL_BASE_URL; ?> lpdirectory.htm</p></div>
                </li>
                
            </ul>
        </form>
    </div>
      
    </div>
    <div><?php if($result!='')
    {
        echo $result;
    }?></div>
      <?php if($result!='')
    { ?>
        <div id='socialmedia' style='margin-left:305px;'> 
            <span class='st_facebook_large' displayText='Facebook'></span>
            <span class='st_twitter_large' displayText='Tweet'></span>
            <span class='st_linkedin_large' displayText='LinkedIn'></span>
            <span class='st_googleplus_large' displayText='Google +'></span>
        </div>
    <?php } ?>

</div>
    
</div>

</div> 
<script>
    <?php if($result != ""){?>
        
        $("#refer-right").hide();
        
        <?php } ?>  
</script> 
<script>
    
        $('#referer').live('click', function() {  
	var temp = $(this).val();
        window.location.href = "<?php echo GLOBAL_BASE_URL; ?>feedback.php?id=" + temp;
      //  window.location(url);
	/*$.post('ajaxfeed.php', {id:temp}, function(data){
	$('#display').html(data);
	});*/
        
       /* $.ajax({
            url: 'ajaxfeed.php',
             type: "POST",
            data: { id : temp },
            success: function(data){
                    if(data!=""){
                         $('#display').html(data);
                         $('#refer-right').hide();
                         $('#socialmedia').show();

                }else{
                    $('#display').hide();
                }
            },
            error:function(){
                jQuery('#preloading').fadeOut();
                alert("There was some problem sending mail...");
            }

        });*/
    });
    </script>
</body>
</html>
