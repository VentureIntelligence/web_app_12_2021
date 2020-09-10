<?php
  require("dbconnectvi.php");
  session_start();
  if( $_SESSION[ 'type' ] == 'C' ) {
    $redirectLink = BASE_URL . "cfsnew/home.php";
  } else if( $_SESSION[ 'type' ] == 'P' ) {
    $redirectLink = BASE_URL . "dealsnew/index.php";
  } else if( $_SESSION[ 'type' ] == 'M' ) {
    $redirectLink = BASE_URL . "ma/index.php";
  } else if( $_SESSION[ 'type' ] == 'R' ) {
    $redirectLink = BASE_URL . "re/reindex.php";
  } else {
    $redirectLink = BASE_URL;
  }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>404 | Venture Intelligence</title>
<link rel="shortcut icon" href="img/fave-icon.png">
<link rel="stylesheet" href="css/home-page-style.css">
<link rel="stylesheet" href="css/owl.carousel.css" >
<link rel="stylesheet" href="css/owl.theme.css" >
<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />
<style type="text/css">
  .pnf-container { text-align: center; }
  .pnf-container h1 { font-weight: bold; font-size: 80px; }
  .pnf-messagepanel { font-size: 30px; color: #7b7575; margin-top: 30px; }
  .pnf-messagepanel .help-block { font-size: 16px; margin-top: 20px; }
  .pnf-messagepanel .action-trigger { font-size: 14px; margin-top: 20px; padding: 10px; }
  .pnf-messagepanel .action-trigger a { color: #fff; background-color: #a07925; padding: 10px; }
</style>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/ios-reorient.js"></script>
<script type="text/javascript" src="js/ui.js"></script>
<script type="text/javascript" src="js/owl.carousel.js"></script>
<script src='js/jquery.min.js'></script>
<script type="text/javascript" src="js/jquery.tooltipster.js"></script>
<script language="JavaScript" type="text/javascript" src="js/rotact1.js"></script>
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
      </div>
    </div>
    <div class="header fd-sticky fc">
      <div class="sticky-wrapper">
        <section class="fd-home-sticky">
          <div class="l-page">
            <div class="logo-sec"> <a href="<?php echo $redirectLink; ?>" class="fd-logo"><img class="default" src="img/logo.png" alt="vi"> <img class="fixed-logo" src="img/logo-b.png" alt="vi"> </a> <span>Private Company Financials, Transactions & Valuations.</span> </div>
          </div>
        </section>
      </div>
    </div>
  </header>

  <!-- inner page header -->
  <div class="inner-header league-tables"></div>
  <div class="clearfix"></div>
  <div class="container-01">
    <div class="content">
      <div class="row">
        <div class="about-us">
          <div class="pnf-container">
            <h1>404</h1>
            <div class="pnf-messagepanel">
              OOPS, Sorry We Can't Find The Page!
              <p class="help-block">Either something went wrong or the page doesn't exist anymore</p>
              <p class="action-trigger"><a href="<?php echo $redirectLink; ?>">HOME</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="container-02">
      <div class="content">
        <div class="row">
          <div class="col-1-2" style="width: 100%; text-align: center;">
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

    </script>
</body>
</html>
