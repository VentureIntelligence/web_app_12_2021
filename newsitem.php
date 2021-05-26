<!doctype html>
<html>
<head>
   <!-- Global site tag (gtag.js) - Google Analytics -->
   <script async src="https://www.googletagmanager.com/gtag/js?id=UA-168374697-1"></script>
   <script>
     window.dataLayer = window.dataLayer || [];
     function gtag(){dataLayer.push(arguments);}
     gtag('js', new Date());
   
     gtag('config', 'UA-168374697-1');
   </script>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>News Items | Venture Intelligence</title>
<link rel="shortcut icon" href="img/fave-icon.png">
<link rel="stylesheet" href="css/home-page-style.css">
<link rel="stylesheet" href="css/owl.carousel.css" >
<link rel="stylesheet" href="css/owl.theme.css" >
<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/ios-reorient.js"></script>
<script type="text/javascript" src="js/ui.js"></script>
<script type="text/javascript" src="js/owl.carousel.js"></script>
<script src='js/jquery.min.js'></script>
<script type="text/javascript" src="js/jquery.tooltipster.js"></script>
<script language="JavaScript" type="text/javascript" src="rotact1.js"></script>
<SCRIPT LANGUAGE="JavaScript">
    function rotateImage(place) {
		//alert(place);
		var new_image = getNextImage();
		document[place].src = new_image;
		var recur_call = "rotateImage('"+place+"')";
		setTimeout(recur_call, interval);
	}
</SCRIPT>
</head>

<body OnLoad="rotateImage('rImage')">
<div class="wrapper">
  <header class="fd-header">
    <div class="top-nav-strip">
      <div class="l-page">
        <nav class="top-site-nav">
          <ul>
           <!--<li><a href="pricing.htm">Pricing</a></li>-->
            <li><a href="trial.htm">Request Demo</a></li>
            <li><a href="entrepreneurs.htm">For Entrepreneurs</a></li>
            <li><a href="events.htm">Events</a></li>
            <!--<li><a href="news.htm">News</a></li>-->
            <li><a href="db.htm">Login</a></li>
          </ul>
        </nav>
      </div>
    </div>
    <div class="header fd-sticky fc">
      <div class="sticky-wrapper">
        <section class="fd-home-sticky">
          <div class="l-page">
            <div class="logo-sec"> <a href="index.htm" class="fd-logo"><img class="default" src="img/logo.png" alt="vi"> <img class="fixed-logo" src="img/logo-b.png" alt="vi"> </a> <span>Private Company Financials, Transactions & Valuations.</span> </div>
            <nav class="site-nav">
              <ul>
                <li><a href="index.htm" >Home</a></li>
                <li><a href="products.htm" >Products</a></li>
                <li><a href="leagues.php" >League Tables</a></li>
                <li><a href="index.htm#sec-new" >What's New</a></li>
                <li class="por-hide"><a href="aboutus.htm"  >About Us</a></li>
                <li class="por-hide"><a href="contactus.htm" >Contact</a></li>
              </ul>
            </nav>
          </div>
        </section>
      </div>
    </div>
  </header>

  <!-- inner page header -->
  <div class="inner-header league-tables">
    <div class="container-01">
      <div class="content">
        <div class="row">
          <h2>News Item</h2>
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="container-01">
    <div class="content">
      <div class="row">
        <div class="about-us">
          <div  class="right-section">
            <div class="event-content">
                        
          <?php 

            require("dbconnectvi.php");
            $Db = new dbInvestments();
            $slugvalue = $_GET['slug'];
            $sel = "SELECT * FROM newsletter LEFT JOIN sources ON newsletter.id = sources.news_id WHERE newsletter.slug = '".$slugvalue."'";

            $res = mysql_query( $sel ) or die( mysql_error() );
            $numrows = mysql_num_rows( $res );
        
            if( $numrows > 0 ) {
        
                while( $result = mysql_fetch_array( $res ) ) {
        
                    ?>
                    <div style="margin:0 auto; padding:0; max-width:698px;">

                      <div style="width:100%; float:left; color:#C39B44; font-size:24px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; padding:4% 4% 4% 0;">
                      <?php echo $result['category'];?></div>
          
                      <p align="justify">
                      <font size="4" face="Calibri"><b><?php echo $result['heading']; ?></b></font><font face="Calibri" style="font-size: 11pt"><br>
                      <br>

                      <a href="<?php echo $result['url']; ?>"> 
                      <font color="#C48600"><?php echo $result['name']; ?></font></a><font color="#C48600"><br>
                      </font><br>

                      <font><?php $string = strip_tags($result['summary']); echo $string; ?> </font><br /><br />

                      <font> <b>Tags : </b> <?php echo $result['tags']; ?> </font>

                      </p>
                    </div>
                    <?php
        
                }
           
            }
         

          ?>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="container-02">
      <div class="content">
        <div class="row">
          <div class="col-1-2 address-sec" id="add-sec">
            <address>
            <a href="javascript:;"> <img src="img/foot_logo.png" width="170" height="46" alt="vi" title="vi"></a> <a href="mailto:bizdev@ventureintelligence.com" class="email-li">bizdev@ventureintelligence.com </a> <a href="javascript:;" class="mob-no">+91-44-4218-5180 </a>
            <p>Venture Intelligence (TSJ Media Pvt. Ltd.) <br />
              1, Maharani Chinnamba Road; Alwarpet; Chennai - 600018. India.</p>
            </address>
            <!-- <a href="https://www.google.co.in/maps/place/Venture+Intelligence/@13.0363719,80.2549934,17z/data=!3m1!4b1!4m5!3m4!1s0x3a5266352a0fcfb9:0x73791623f88292ab!8m2!3d13.0363719!4d80.2571821?hl=en" class="directions">Directions</a>  -->
          </div>
          <div class="col-1-2">
            <div class="social-sec">
              <h4>Follow us on</h4>
              <nav> <a href="http://ventureintelligence.blogspot.in/" class="icon-block"></a> <a href="https://in.linkedin.com/in/ventureintelligence" class="icon-linkedin"></a> <a href="https://twitter.com/ventureindia" class="icon-twitter"></a> <a href="https://www.facebook.com/ventureintelligence" class="icon-fb"></a> <a href="https://plus.google.com/104062335450225242195" class="icon-gplues"></a> <a href="https://www.youtube.com/VentureIntelligence" class="you-tube"></a> </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <footer>
      <div class="footer-sec"> <span class="fl">© 2018 TSJ Media Pvt Ltd. All rights reserved. </span> <!--<a href="http://kutung.com/" class="fr">it's a kutung</a>--> </div>
    </footer>
  </div>
</div>
<script>

    $(document).ready(function() {
     $(window).scroll(function(){
            if ($(this).scrollTop() > 100) {

                $('.header').addClass("opne-nav-fix");
                $('img.fixed-logo').show();
                $('img.default').hide();

            } else {
                $('.header').removeClass("opne-nav-fix");
             $('img.default').show();
           $('img.fixed-logo').hide();

            }
        });


    });

    //get Particular news items
    // $(document).ready(function() {

    //     alert();
    //     $.ajax({
    //         type: 'POST',
    //         url: '../vi_webapp/newsitem.php',
           
    //         success: function(data) {
    //             console.log(data);
    //             $('#appendnewsitemvalue').html(data);
    //         }

    //     });
    // });


    </script>
</body>
</html>
