<?php
   /* include_once 'LeagueTables/db.php';*/
     require("dbconnectvi.php"); 
 $Db = new dbInvestments();
    session_start();
    if($_REQUEST['value']!=''){

        $value=$_REQUEST['value'];
    }else{

        $value=1;
    }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="Unicorn Startups in India" content="The Complete list of Indian Startups valued at $1 Billion or more." />
<meta name="keywords" content="India, Unicorns, Unicorns in India, India Unicorns, Indian Unicorns, Indian Unicorn Startups, Indian Startup Unicorns, Biggest Startups in India, Most Valuable Startups in India, Indian Unicorns List, List of Indian Unicorns, Unicorns in India 2019, unicorns in India 2018" />
<title>Unicorn Startups in India | Venture Intelligence </title>
<link rel="shortcut icon" href="img/fave-icon.png">
<link rel="stylesheet" href="css/home-page-style.css">
<link rel="stylesheet" href="css/owl.carousel.css" >
<link rel="stylesheet" href="css/owl.theme.css" >
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<!-- <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
 --><script type="text/javascript" src="js/ios-reorient.js"></script>
<script type="text/javascript" src="js/ui.js"></script>
<!--   -->
<script src='js/jquery.min.js'></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-168374697-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-168374697-1');
</script>
<style>
#maskscreen {
    position: fixed;
    left: 0;
    top: 0;
    background: #000;
    z-index: 8000;
    overflow: hidden;
}
.lb {
    width: 400px;
    border: 1px solid #ccc;
    box-shadow: 0 0 2px #eaeaea;
    overflow: hidden;
    margin: 0 auto;
    z-index: 9000;
    left: 25%;
    top: 40%;
    position: fixed;
    background-color: #fff;
    display: none;
}
.copyright-body {
    padding: 25px 10px 10px 20px;
    line-height: 24px;
    font-size: 16px;
    color: #000;
}
.opne-nav-fix{ position:fixed; top:0;width:100%;background:none repeat scroll 0 0 hsla(0, 0%, 98%, 0.97);border-bottom:1px solid #E0E0E0}
.opne-nav-fix span{display:none}

img.fixed-logo{display:none}
.opne-nav-fix .site-nav ul li a{color:#000000}
.opne-nav-fix .site-nav ul li a:hover{color:#F2AB11}
/*unicorn page css*/
.export-unicorn{
  background: #a37635;
    padding: 5px 27px;
    color: #fff;
    margin: 8px 0px;
    float: right;
}
.unicorn-header{
  height: 175px !important;
}
.unicorn{
      /*background: url(../img/unicorn.jpg) no-repeat;*/
       background: linear-gradient(0deg,rgba(0,0,0,0.5),rgba(0,0,0,0.5)),url(./img/unicorn.jpg) no-repeat;
    background-position: center;
    background-size: cover;
    display: block;
    height: 300px;
    margin-top: 40px;
    position: relative;
}
.unicorn h2{
  position: absolute;
    top: 32%;
    font-size: 52px;
    color: #FFF;
    display: block;
    width: 1170px;
    font-weight: 600;
    text-align: center;
}
.unicorn p{
  position: absolute;
    top: 55%;
    font-size: 30px;
    color: #FFF;
    display: block;
    width: 1170px;
    text-align: center;
}
.unicornhead{
    text-align: left;
    color:#fff;
    background-color: #bf9e62;
}
.unicorndata{
  line-height: 40px;
    border-bottom: 1px solid #ccc !important;
    }
   .unicorndata .valuation{
    text-align: center;
   }
   .unicornhead th,.unicorndata td{padding:10px;}
.unicorn-inner-page{
  margin: 20px 0 60px 0 !important; 
}
.unicorn-content-2 {
  margin-bottom: 25px;
}
.unicorn-content-2 p{
  line-height: 25px;
}
.unicorn-space{
white-space: nowrap;
}.unicorn-content {
  max-width: 1170px;
  margin: 0 auto;
  padding: 0 25px
}

#myTable th.headerval:before {
   content: "\f0dc";
  font: normal normal normal 14px/1 FontAwesome;
      padding-right: 5px;
}
#myTable th.headerval:hover {
  cursor:pointer;
  }
  .tooltip4 span {
    display: none;
    line-height: 20px;
    margin-left: 5px;
    padding: 10px 15px 7px 10px;
    z-index: 10;
    margin-top: 6px;
    right:0px;margin-top: 25px;
}
.tooltip4:hover span {
    font-size: 12px !important;
    font-weight: normal !important;
    display: inline;
    position: absolute;
    color: #111;
    border: 1px solid #DCA;
    background: #fffAF0;
    padding: 5px;
}
 #selectInvestor{
    position:relative;
  }
  @media screen and (max-width: 1024px) and (min-width: 768px){
    .unicorn-inner-page{
      width: 100% !important;
    }
    .unicorn h2{
    
    width: 100%;
    left: 0;
  }
  .unicorn p{
      
      width: 100%;
      left: 0;
  }
  .tooltip4 span {right:0px;margin-top: 25px;}
  }
@media screen and (width:768px) {
  .unicorn-inner-page{
    overflow-x: scroll;
    width: 100% !important;
  }
  .unicorn h2{
    font-size: 35px;
    width: 100%;
    left: 0;
  }
  .unicorn p{
      font-size: 25px;
      width: 100%;
      left: 0;
  }
  .unicorndata{
      line-height: 20px;
  }
  .unicorn-content {
    width: 100%;
    margin: 0 auto;
    padding: 0 0px;
}
.unicorn-content-2{
    padding: 0px 5px;
  }
   #selectInvestor{
    display:inline-flex;
   }
  .tooltip4 span {right:0px;margin-top: 25px;}
}
@media screen and (min-width:320px) and (max-width:480px) {
  .unicorn h2{
    font-size: 25px;
    width: 100%;
    left: 0;
  }
  .unicorn p{
      font-size: 15px;
      width: 100%;
      left: 0;
  }
  .unicorn-inner-page{
    overflow-x: scroll;
    width: 100% !important;
  }
  .unicorn{
    margin-top: 20px;
  }
  .unicornhead th, .unicorndata td {
    padding: 10px;
    font-size: 14px;
}
.unicorn-content{
padding: 0 0px !important;
}
.unicorndata{
      line-height: 20px;
  }
  .unicorn-content-2{
    padding: 0px 5px;
  }
  .export-unicorn{
    padding: 5px 12px;
    font-size:14px;
  }
  #selectInvestor{
    display:inline-flex;
    position:relative;
  }
.tooltip4 span {right:0px;margin-top: 25px;}
}
/*unicorn page css*/
</style>
<!-- Table Sort -->
<script type="text/javascript" language="javascript" src="LeagueTables/media/js/jquery.dataTables.js"></script>

<!-- Sort End -->

<!-- Tooltip Srarts -->
<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />
<script type="text/javascript" src="js/jquery.tooltipster.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.tooltip').tooltipster({
      animation: 'grow',
      trigger: 'hover',
      position: 'right'
    });

  });
</script>
<!-- Tooltip Ends -->



</head>

<body>
      

<div class="wrapper">
  <header class="fd-header">
    <div class="top-nav-strip">
      <div class="l-page">
        <nav class="top-site-nav">
          <ul>
            <!--<li><a href="pricing.htm">Pricing</a></li>-->
            <li><a class="redirect" href="#" data-href="trial.htm">Request Trial</a></li>
            <li><a class="redirect" href="#" data-href="entrepreneurs.htm">For Entrepreneurs</a></li>
            <li><a class="redirect" href="#" data-href="events.htm">Events</a></li>
           <!-- <li><a href="news.htm">News</a></li>-->
            <li><a class="redirect" href="#" data-href="db.htm">Login</a></li>
          </ul>
        </nav>
      </div>
    </div>
    <div class="header fd-sticky fc">
    <div class="sticky-wrapper">
        <section class="fd-home-sticky">
          <div class="l-page">
          <div class="logo-sec">
          <a class="redirect" href="#" data-href="index.htm" class="fd-logo"><img class="default" src="img/logo.png" alt="vi"> <img class="fixed-logo" src="img/logo-b.png" alt="vi">

          </a>
          <span>Private Company Financials, Transactions & Valuations.</span>
          </div>
            <nav class="site-nav">
              <ul>
                <li><a class="redirect" href="#" data-href="index.htm">Home</a></li>
                <li><a class="redirect" href="#" data-href="products.htm" >Products</a></li>
                <li><a class="redirect" href="#" data-href="leagues.php"  >League Tables</a></li>
                <li><a class="redirect" href="#" data-href="index.htm#sec-new" >What's New</a></li>
                <li class="por-hide"><a class="redirect" href="#" data-href="aboutus.htm" >About Us</a></li>
                <li class="por-hide"><a class="redirect" href="#" data-href="contactus.htm" >Contact</a></li>
              </ul>
            </nav>
          </div>
        </section>

      </div>
    </div>
  </header>

  <!-- inner page header -->
  <div class="inner-header unicorn-header league-tables"></div>

  <div class="clearfix"></div>
  <div class="unicorn">
        <div class="container-01">
      <div class="content">
          <div class="row">
                <h2>Venture Intelligence Unicorn Tracker</h2>
                <p>List of Indian Startups valued at $1 Billion or more.</p>
            </div>
        </div>
    </div>
      </div>
  <div class="container-01">
    <div class="unicorn-content">
      
      <div class="row">
        <div class="new-sec" id="sec-new">
           <?php $unicornmediapath=BASE_URL.'adminvi/importfiles/Unicorntable.xlsx';?>
              <!-- <a  href=" <?php echo $unicornmediapath;?>" class="export-unicorn" >Export Unicorn</a> -->
          <div class="unicorn-inner-page inner-page view-table-list">
           
             
           <table  cellspacing="0" cellpadding="0" style="border-collapse: collapse;width:100%; " id="myTable">
             <thead>
               <tr class="unicornhead">
                 <th class="unicorn-space headerval <?php echo ($orderby == "id") ? $ordertype : ""; ?>" id="id" >No</th>
                 <th class="unicorn-space headerval <?php echo ($orderby == "company") ? $ordertype : ""; ?>" id="company" >Company</th>
                 <th class="unicorn-space headerval <?php echo ($orderby == "sector") ? $ordertype : ""; ?>" id="sector" >Sector</th>
                 <th class="unicorn-space headerval <?php echo ($orderby == "valuation") ? $ordertype : ""; ?>" id="valuation" >Valuation ($B)</th>
                 <th class="unicorn-space headerval <?php echo ($orderby == "entry") ? $ordertype : ""; ?>" id="entry" >Entry</th>
                 <th class="unicorn-space headerval <?php echo ($orderby == "location") ? $ordertype : ""; ?>" id="location" >Location</th>
                 <th class="unicorn-space  <?php echo ($orderby == "selectInvestor") ? $ordertype : ""; ?>" id="selectInvestor" >Select Investors  <a  href=" <?php echo $unicornmediapath;?>" class="tooltip4" style="color:#fff;float:right;padding-left: 10px;"><i class="fa fa-download" aria-hidden="true"></i><span class=" " >
                   
                    <strong>Download</strong>
                    </span></a></th>
               </tr>
             </thead>
             <?php 
             $orderby = " id";
             $ordertype = " desc";
             $sqlquery="select * from unicorn_table_data order by ";
             $ajaxcompanysql = urlencode($sqlquery);
             $sqlquery=$sqlquery." id desc";
                    $result=mysql_query($sqlquery);
                    while($row=mysql_fetch_array($result))
                    {

             ?>
             <tr class="unicorndata">
               <td><?php echo $row[0];?></td>
               <td class="unicorn-space"><?php echo $row[1];?></td>
               <td class="unicorn-space"><?php echo $row[2];?></td>
               <td class="valuation "><?php echo $row[3];?></td>
               <td><?php echo $row[4];?></td>
               <td class="unicorn-space"><?php echo $row[5];?></td>
               <td><?php echo $row[6];?></td>

             </tr>
           <?php } ?>
           <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td style="text-align: right;
    padding-top: 20px;">* Former Unicorns</td>
           </tr>
           </table> 
          </div>
              

        </div>
      </div>
      <div class="unicorn-content-2">
        <p>
          Interested in more information of Unicorns - including investment and valuation details, financials, return multiples, etc?
        </p>
        <p><a href="trial.htm" style="color:#bf9e62;text-decoration: underline; " target="_blank">Click Here</a> to request a trial to our Databases.</p>
      </div>
    </div>
  </div>

  <div class="clearfix"></div>
 
  <div class="clearfix"></div>
  <footer>
    <div class="footer-sec"> <span class="fl">© 2018 TSJ Media Pvt Ltd. All rights reserved. </span> <!--<a href="http://kutung.com/" class="fr">it's a kutung</a>--> </div>
  </footer>
</div>
<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 100% !important; display: none;"></div>
 <div class="lb" id="popup-box-copyrights-filter" style="width:750px !important;padding:5px;">
  <div style="border: 4px solid #000;border-radius: 10px;">
   <a id="expcancelbtn-filter" class="expcancelbtn" style="cursor: pointer;float:right;font-size: 22px;font-weight: 700; margin-right: 10px; margin-top: 3px;">x</a>
    <div class="copyright-body">Interested in more information of Unicorns - including investment and valuation details, financials, return multiples, etc?
    <p style="margin: 10px 0px;"><a href="trial.htm">Click Here</a> to request a trial to our Databases.</p>
    </div>
  </div>   
</div>



<script>
$(document).ready(function(){
  $(document).on("click",".headerval",function(){
                    orderby=$(this).attr('id');

                    if($(this).hasClass("asc")){
                        ordertype=" desc";
                        $(this).removeClass("asc");
                        $(this).addClass("desc");
                       
                    }
                    else
                    {
                        ordertype=" asc";
                        $(this).removeClass("desc");
                        $(this).addClass("asc");
                        
                    }
                    loadhtml(1,orderby,ordertype);
                    return  false;
                });
  function loadhtml(pageno,orderby,ordertype)
                {
                    jQuery('#preloading').fadeIn(1000);
                    $.ajax({
                        type : 'POST',
                        url  : 'ajaxunicorntable.php',
                        data: {
                            sql : '<?php echo addslashes($ajaxcompanysql); ?>',
                            orderby:orderby,
                            ordertype:ordertype,
                        },
                        success : function(data){
                                $(".view-table-list").html(data);
                               
                                jQuery('#preloading').fadeOut(500);

                                return  false;
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                                jQuery('#preloading').fadeOut(500);
                                alert('There was an error');
                        }
                    });
                }

        

});
</script>
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

      var owl = $("#owl-demo");

      owl.owlCarousel({

      items : 2,
      itemsDesktop : [1000,2], //5 items between 1000px and 901px
      itemsDesktopSmall : [900,1], // betweem 900px and 601px
      itemsTablet: [600,1], //2 items between 600 and 0
      itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option

      });

      // Custom Navigation Events
      $(".next").click(function(){
        owl.trigger('owl.next');
      })
      $(".prev").click(function(){
        owl.trigger('owl.prev');
      })
      $(".play").click(function(){
        owl.trigger('owl.play',1000);
      })
      $(".stop").click(function(){
        owl.trigger('owl.stop');
      })




    });

    $('#expcancelbtn-filter').click(function(){

jQuery('#popup-box-copyrights-filter').fadeOut();
jQuery('#maskscreen').fadeOut(1000);

});
$('a.redirect').on("click",function(){
    jQuery('#maskscreen').fadeIn();
    $('#popup-box-copyrights-filter').fadeIn();
    $hrefval=$(this).attr("data-href");
    $('#expcancelbtn-filter').attr('href',$hrefval);
});

    </script>
</body>
</html>
