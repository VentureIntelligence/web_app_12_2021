<?php require_once("dbconnectvi.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Venture Intelligence Private Equity & Venture Capital databasesssss</title>
<meta  name="description" content="" />
<meta name="keywords" content="" />
<link rel="stylesheet" href="css/login.css" />
    
<script type="text/javascript" src="//code.jquery.com/jquery-1.7.js"></script>  
<!-- <script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="js/ui.dropdownchecklist.js"></script> -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script type="text/javascript" src="//ws.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">
    stLight.options({publisher: "5cb56486-feb9-4357-8585-f22677ecbd8d"});
   /* function fun1(event,service){
		alert("event called is:"+event);
		alert("service called is:"+service);
	}
	
	stLight.subscribe("click",fun1);*/
    
</script>
<!--script>
    $(document).ready(function(){

        $("#socialmedia").hide();
        });
</script-->

<style>
#socialmedia1 .stButton {
    pointer-events: none;
    opacity: 0.4;
}
</style>

</head>

<body class="loginpage"> 
 
<!--Header-->

<div class="login-screen">

<div class="headerlg">
<div class="cnt-left"><div class="logo"><a href="<?php echo BASE_URL; ?>"><img src="img/logo-b.png" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></div>

<ul>
<li><a href="<?php echo BASE_URL; ?>index.htm" class="active">Home</a></li>
<li><a href="<?php echo BASE_URL; ?>products.htm" >Products</a></li>
<li><a href="<?php echo BASE_URL; ?>events.htm">Events</a></li>
<li><a href="<?php echo BASE_URL; ?>news.htm">News</a></li>
<li><a href="<?php echo BASE_URL; ?>aboutus.htm">About Us</a></li>
<li class="last"><a href="<?php echo BASE_URL; ?>contactus.htm">Contact Us</a></li>
</ul>
</div>
    
<div class="login-container">
<div   class="login-left"></div>
<div class="login-right" id="refer-right" style="border: 2px solid #232323;">
    <h3>Recommend Venture Intelligence to your Network</h3>
    <div><h4>Sample referral messages <span style="font-size: 13px;"><small>(you can edit it on the next page)</small></span></h4></div>
    <div>
        <form>
            <ul>
                <li>
                    <div class="feedalign"><input type="radio" name="referer" id="referer"  value="1" />
                    <p>Using Venture Intelligence for several years now. Exhaustive Indian Private Equity, Venture Capital & M&A related data. <a href="http://bit.ly/1lMJvmL" target="_blank">http://bit.ly/1lMJvmL</a></p></div> 
                </li>
                <li>
                    <div class="feedalign"><input type="radio" name="referer" id="referer"  value="2"/>
                    <p >Found some really interesting undisclosed PE –VC deals on Venture Intelligence. <a href="http://bit.ly/1skO6kZ" target="_blank">http://bit.ly/1skO6kZ</a></p></div>
                </li>
                <li>
                    
                    <div class="feedalign"><input type="radio" name="referer" id="referer"  value="3"/>
                     <p>Very exhaustive valuation coverage on Indian PE deals. Quite Interesting. <a href="http://bit.ly/T3yd2j" target="_blank">http://bit.ly/T3yd2j</a></p></div>
                </li>
                
            </ul>
        </form>
    </div>
      <div id='socialmedia1'> 
            <span class='st_facebook_large' st_url='<?php echo BASE_URL; ?>trialrequest.php?msg=1&src=FB' st_title="Using @Venture Intelligence﻿ for several years now. Exhaustive Indian @Private equity﻿ @ Venture capital﻿ and @Mergers and acquisitions﻿ related data. http://bit.ly/1lMJvmL"  displayText='Facebook' st_via="ventureindia"></span>
            <span class='st_twitter_large' st_url='<?php echo BASE_URL; ?>trialrequest.php?msg=1&src=TW'  st_title="Using @ventureindia for several years now.Exhaustive Indian #PrivateEquity,#VentureCapital & @MandAindia related data http://bit.ly/1lMJvmL" displayText='Tweet' st_via="ventureindia"></span>
            <span class='st_linkedin_large' st_url='<?php echo BASE_URL; ?>trialrequest.php?msg=1&src=LN' st_title="Using @Venture Intelligence for several years now. Exhaustive Indian @Venture Capital & Private Equity and @Mergers and Acquisitions related data. http://bit.ly/1lMJvmL" displayText='LinkedIn' st_via="ventureindia"></span>
            <span class='st_googleplus_large' st_url='<?php echo BASE_URL; ?>trialrequest.php?msg=1&src=GP' st_title="Using @Venture Intelligence VI for several years now. Exhaustive Indian Private Equity, Venture Capital & M&A related data. http://bit.ly/1lMJvmL" displayText='Google' st_via="ventureindia"></span>
      </div>

      <div id='socialmedia2'> 
            <span class='st_facebook_large' st_url='<?php echo BASE_URL; ?>trialrequest.php?msg=2&src=FB' st_title="Found some really interesting undisclosed @Private equity﻿  @Venture capital﻿  deals on @Venture Intelligence﻿.  http://bit.ly/1skO6kZ" displayText='Facebook' st_via="ventureindia"></span>
            <span class='st_twitter_large' st_url='<?php echo BASE_URL; ?>trialrequest.php?msg=2&src=TW'  st_title="Found some really interesting undisclosed #PrivateEquity,#VentureCapital deals on @ventureindia. http://bit.ly/1skO6kZ" displayText='Tweet' st_via="ventureindia"></span>
            <span class='st_linkedin_large' st_url='<?php echo BASE_URL; ?>trialrequest.php?msg=2&src=LN' st_title="Found some really interesting undisclosed @Venture Capital & Private Equity deals on @Venture Intelligence. http://bit.ly/1skO6kZ"  displayText='LinkedIn' st_via="ventureindia"></span>
            <span class='st_googleplus_large' st_url='<?php echo BASE_URL; ?>trialrequest.php?msg=2&src=GP' st_title="Found some really interesting undisclosed PE –VC deals on @Venture Intelligence VI. http://bit.ly/1skO6kZ"  displayText='Google +' st_via="ventureindia"></span>
      </div>

      <div id='socialmedia3'> 
            <span class='st_facebook_large' st_url='<?php echo BASE_URL; ?>trialrequest.php?msg=3&src=FB' st_title="Very exhaustive valuation coverage on Indian @Private equity﻿  @Venture capital﻿  deals. Quite Interesting @Venture Intelligence. http://bit.ly/T3yd2j" displayText='Facebook' st_via="ventureindia"></span>
            <span class='st_twitter_large' st_url='<?php echo BASE_URL; ?>trialrequest.php?msg=3&src=TW' st_title="Very exhaustive valuation coverage on Indian #PrivateEquity,#VentureCapital deals. Quite Interesting @ventureindia . http://bit.ly/T3yd2j" displayText='Tweet' st_via="ventureindia"></span>
            <span class='st_linkedin_large' st_url='<?php echo BASE_URL; ?>trialrequest.php?msg=3&src=LN' st_title="Very exhaustive valuation coverage on Indian @Venture Capital & Private Equity deals. Quite Interesting @Venture Intelligence. http://bit.ly/T3yd2j"  displayText='LinkedIn' st_via="ventureindia"></span>
            <span class='st_googleplus_large' st_url='<?php echo BASE_URL; ?>trialrequest.php?msg=3&src=GP' st_title="Very exhaustive valuation coverage on Indian PE deals. Quite Interesting @Venture Intelligence VI. http://bit.ly/T3yd2j" displayText='Google +'></span>
      </div>
    </div>


</div>
    
</div>

</div>
<div style="clear: both;"></div> 
<footer class="footer-container">
    <div class="footer-sec"> <span>© 2018 TSJ Media Pvt Ltd. All rights reserved. </span> <!--<a href="http://kutung.com/" class="fr">it's a kutung</a>--> </div>
</footer> 
<script>
    <?php if($result != ""){?>
        
        $("#refer-right").hide();
        
        <?php } ?>  
</script> 
<script>
        //$('#socialmedia1').hide();
        $('#socialmedia2').hide();
        $('#socialmedia3').hide();
    
        $('#referer').live('click', function() {  
	var temp = $(this).val();
        if (temp==1){
            $('#socialmedia1').show();
            $('#socialmedia2').hide();
            $('#socialmedia3').hide();
            $( '#socialmedia1 .stButton' ).css({'opacity':1,'pointer-events':'auto'});
        }
        if (temp==2){
            $('#socialmedia1').hide();
            $('#socialmedia2').show();
            $('#socialmedia3').hide();
            $( '#socialmedia1 .stButton' ).css({'opacity':1,'pointer-events':'auto'});
        }
        if (temp==3){
            $('#socialmedia1').hide();
            $('#socialmedia2').hide();
            $('#socialmedia3').show();
            $( '#socialmedia1 .stButton' ).css({'opacity':1,'pointer-events':'auto'});
        }
        //window.location.href = "<?php echo BASE_URL; ?>refer.php?id=" + temp;
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
