<?php include_once("../globalconfig.php");
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
include ('checklogin.php');
?>
 <style>
	/*Added due to the dashboard*/
  .acc_main{
    margin-top:0px !important;
  }
  .period-date select {
    margin-top:4px;
  }
  .period-date + .search-btn input{
    line-height:18px !important;
  }
    .sec-header-fix {
    z-index: 9;
    background: #413529;
    color: #fff;
    display: block;
    position: fixed;
    width: 100%;
    top: 48px;
    margin-bottom: 0 !important;
    height: 40px !important;
}
#header .right-box {
    border-bottom: 1px solid #fff;
}
#sec-header td{
    padding: 5px 10px !important;
}
#container{
    margin-top:90px;
}
#sec-header table{
    background: #413529;
}
#sec-header td{
    border-right:1px solid transparent;
}
#sec-header label {
    color:#fff;
}
#sec-header h3{
    padding: 8px 12px 5px 5px !important;
    color: #fff;
}
.period-date{
    padding: 2px 0px;
}
.subnav-content{
	left: 350px !important;
}
.subnav-content1,.subnav-content2,.subnav-content5{
left: 538px !important;
}
.subnav-content3,.subnav-content4{
left: 765px !important;
}
/*Added due to the dashboard*/
		.arrow-weight {
			font-weight: bolder;
		}

	
		.arrow-pe-vc {
			margin-left: 4px;
		}

	
        .border-btm-head:after {
			content: "";
			display: block;
			margin: 0 auto;
			width: 86%;
			/* padding-top: 0px; */
			border-bottom: 1px solid #E0D8C3;
            padding-top: 42px;
		}
		.subnav li:hover,.subnavdir li:hover {
    background-color: #98630a !important;
}

.subnav,.subnav1, .subnav2, .subnav3,, .subnav4, .subnav5 {
  float: left;
  overflow: hidden;
}

.subnav .subnavbtn {
  font-size: 16px;  
  border: none;
  outline: none;
  color: white; 
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}
.subnav li:hover i, .active.subnav li i{
    color:#fff;
}
.navbar a:hover, .subnav:hover .subnavbtn {
  background-color: red;
}
.subnav:hover .subnav-content {
  display: grid;
}
.subnav li a{
  font-size:14px !important;
}
.subnav-content {
  /* display: none;
  position: absolute;
  left: 0;
  background-color: red;
  width: 100%;
  z-index: 1; */
  display: none;
    position: fixed;
    background-color: #413529;
    width: auto;
    z-index: 999;
    top: 45px;
    left: 232px;
}
.subnav-contentdir {
  display: none;
    position: fixed;
    background-color: #413529;
    width: auto;
    z-index: 999;
    top: 45px;
    left: 428px;
}
.subnav:hover .subnav-content {
  display: grid;
}
.subnavdir:hover .subnav-contentdir {
  display: grid;
}
.subnav1:hover .subnav-content1 {
  display: grid;
}
.subnav2:hover .subnav-content2 {
  display: grid;
}
.subnav3:hover .subnav-content3 {
  display: grid;
}
.subnav4:hover .subnav-content4 {
  display: grid;
}
.subnav5:hover .subnav-content5 {
  display: grid;
}
.subnav-content1 {
  /* display: none;
  position: absolute;
  left: 0;
  background-color: red;
  width: 100%;
  z-index: 1; */
  /* display: none; */
  display: none;
  position: fixed;
    background-color: #413529;
    width: auto;
    z-index: 999;
    top: 45px;
    left: 420px;
    border-left: 1px solid #fff;
}
.subnav-content2 {
    display: none;
    position: fixed;
    background-color: #413529;
    width: auto;
    z-index: 999;
    top: 88px;
    left: 420px;
    border-left: 1px solid #fff;
}

.subnav-content3 {
    display: none;
    position: fixed;
    background-color: #413529;
    width: auto;
    z-index: 999;
    top: 88px;
    left: 648px;
    border-left: 1px solid #fff;
}
.subnav-content4 {
    display: none;
    position: fixed;
    background-color: #413529;
    width: auto;
    z-index: 999;
    top: 130px;
    left: 648px;
    border-left: 1px solid #fff;
}
.subnav-content5 {
    display: none;
    position: fixed;
    background-color: #413529;
    width: auto;
    z-index: 999;
    top: 130px;
    left: 420px;
    border-left: 1px solid #fff;
}

.subnav-content a {
  float: left;
  color: white;
  text-decoration: none;
}
.subnav-contentdir a {
  float: left;
  color: white;
  text-decoration: none;
}

.subnav-content a:hover {
  /* background-color: #eee; */
  color: black;
}
.subnav-contentdir a:hover {
  /* background-color: #eee; */
  color: black;
}
.subnav-content ul>li>a,.subnav-content1 ul>li>a{
 padding:13px 15px 13px 15px !important;
}
.subnav-contentdir ul>li>a,.subnav-content1 ul>li>a{
 padding:13px 15px 13px 15px !important;
}
.subnav1 i,.subnav2 i,.subnav3 i,.subnav4 i,.subnav5 i{
    background-image: none;
    margin-top: 12px;
    float: right;
}
.subnav1 li,.subnav2 li,.subnav3 li,.subnav4 li,.subnav5 li{
    border-right: 1px solid #fff;
}


	</style> 

<ul class="tour-lock">

 <?php
$vcflagValue = isset($_REQUEST['value']) ? $_REQUEST['value'] : 0;
$curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
?>
<?php 
 if($vcflagValue==0 || $vcflagValue==1 || $vcflagValue==3){ ?>

<li <?php echo ($topNav=='Dashboard') ? 'class="active"' : '' ; ?>><a href="dashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li <?php echo ($topNav=='Deals') ? 'class="active subnav"' : 'class="subnav"' ; ?>><a href="javascript:void(0)" class="popup_call" data-url="reindex.php"><i class="i-data-deals"></i>Deals</a>
<div class="subnav-content">
    <ul style="display:grid">
      <li class="subnav1 border-btm-head"><a id="pevchover" href="reindex.php" >PE Investments - Real Estate</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                            aria-hidden="true"></i>
    </li>
      <li class="subnav2 border-btm-head"><a id="pevcexit" href="reipoindex.php?value=1">PE backed IPO</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
    </li>
      <li class="subnav5 border-btm-head"><a id="remandaindex" href="remandaindex.php?value=2">PE Exits via M&A </a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
      </li>
      <li class=""><a id="remaindex" href="remaindex.php?value=3">Other M&A</a></li>
 </ul>
    </div>
</li>
<li <?php echo ($topNav=='Directory') ? 'class="active subnavdir"' : 'class="subnavdir"' ; ?>><a href="redirview.php"  id="redirectorytour"><i class="i-directory"></i>Directory</a>
<div class="subnav-contentdir">
    <ul style="display:grid">
      <li class="subnav1 border-btm-head"><a id="pevchover" href="redirview.php?value=0" >PE Investments - Real Estate</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                            aria-hidden="true"></i>
    </li>
      <li class="subnav2 border-btm-head"><a id="pevcexit" href="redirview.php?value=1">PE backed IPO</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
    </li>
      <li class="subnav5 border-btm-head"><a href="redirview.php?value=2">PE Exits via M&A </a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
      </li>
      <li class=""><a href="redirview.php?value=3">Other M&A</a></li>
 </ul>
    </div>
</li>
<li <?php echo ($topNav=='Funds') ? 'class="active"' : '' ; ?>><a id="refunds" href="refunds.php"><i class="i-directory"></i>Funds <span class="betaversion">Beta</span></a></li>
<script>
$(document).ready(function() {    
    $(".vconly").hide();
    $(".vconly").attr('disabled','disabled');
    $(".peonly").attr('selected','selected');
    $(".vconly").remove();
    
    $("#exitsviavc").hide();
    $("#exitsviape").show();
});
</script>

 <?php } elseif($vcflagValue==2 || $curPageName == "remandadealdetails.php") {?>  
    
<li <?php echo ($topNav=='Dashboard') ? 'class="active"' : '' ; ?>><a href="dashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li <?php echo ($topNav=='Deals') ? 'class="active subnav"' : 'class="subnav"' ; ?>><a href="javascript:void(0)" class="popup_call" data-url="reindex.php"><i class="i-data-deals"></i>Deals</a>
<div class="subnav-content">
    <ul style="display:grid">
      <li class="subnav1 border-btm-head"><a id="pevchover" href="reindex.php?value=0" >PE Investments - Real Estate</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                            aria-hidden="true"></i>
    </li>
      <li class="subnav2 border-btm-head"><a id="pevcexit" href="reipoindex.php?value=1">PE backed IPO</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
    </li>
      <li class="subnav5 border-btm-head"><a id="remandaindex" href="remandaindex.php?value=2">PE Exits via M&A </a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
      </li>
      <li class=""><a id="remaindex" href="remaindex.php?value=3">Other M&A</a></li>
 </ul>
    </div>
</li>
<li <?php echo ($topNav=='Directory') ? 'class="active subnavdir"' : 'class="subnavdir"' ; ?>><a href="redirview.php"  id="redirectorytour"><i class="i-directory"></i>Directory</a>
<div class="subnav-contentdir">
    <ul style="display:grid">
      <li class="subnav1 border-btm-head"><a id="pevchover" href="redirview.php?value=0" >PE Investments - Real Estate</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                            aria-hidden="true"></i>
    </li>
      <li class="subnav2 border-btm-head"><a id="pevcexit" href="redirview.php?value=1">PE backed IPO</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
    </li>
      <li class="subnav5 border-btm-head"><a href="redirview.php?value=2">PE Exits via M&A </a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
      </li>
      <li class=""><a href="redirview.php?value=3">Other M&A</a></li>
 </ul>
    </div>
</li>
<?php if($topNav=='Directory'){?>
  <li <?php echo ($topNav=='Funds') ? 'class="active"' : '' ; ?>><a id="refunds" href="refunds.php"><i class="i-directory"></i>Funds <span class="betaversion">Beta</span></a></li>
<?php } ?>
 <?php } else{ ?>

<li <?php echo ($topNav=='Dashboard') ? 'class="active"' : '' ; ?>><a href="dashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li <?php echo ($topNav=='Deals') ? 'class="active subnav"' : 'class="subnav"' ; ?>><a href="javascript:void(0)" class="popup_call" data-url="reindex.php"><i class="i-data-deals"></i>Deals</a>
<div class="subnav-content">
    <ul style="display:grid">
      <li class="subnav1 border-btm-head"><a id="pevchover" href="reindex.php" >PE Investments - Real Estate</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                            aria-hidden="true"></i>
    </li>
      <li class="subnav2 border-btm-head"><a id="pevcexit" href="reipoindex.php?value=1">PE backed IPO</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
    </li>
      <li class="subnav5 border-btm-head"><a id="remandaindex" href="remandaindex.php?value=2">PE Exits via M&A </a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
      </li>
      <li class=""><a id="remaindex" href="remaindex.php?value=3">Other M&A</a></li>
 </ul>
    </div>
</li>
<li <?php echo ($topNav=='Directory') ? 'class="active subnavdir"' : 'class="subnavdir"' ; ?>><a href="redirview.php"  id="redirectorytour"><i class="i-directory"></i>Directory</a>
<div class="subnav-contentdir">
    <ul style="display:grid">
      <li class="subnav1 border-btm-head"><a id="pevchover" href="redirview.php?value=0" >PE Investments - Real Estate</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                            aria-hidden="true"></i>
    </li>
      <li class="subnav2 border-btm-head"><a id="pevcexit" href="redirview.php?value=1">PE backed IPO</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
    </li>
      <li class="subnav5 border-btm-head"><a href="redirview.php?value=2">PE Exits via M&A </a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
      </li>
      <li class=""><a href="redirview.php?value=3">Other M&A</a></li>
 </ul>
    </div>
</li>
<li <?php echo ($topNav=='Funds') ? 'class="active"' : '' ; ?>><a  id="refunds" href="refunds.php"><i class="i-directory"></i>Funds <span class="betaversion">Beta</span></a></li>
 <?php }?>
</ul>
<script>
    $(".tour-lock").on('click', '.popup_call', function(e) {
        e.preventDefault();
        var url = $(this).attr('data-url'); 
        localStorage.removeItem("pageno");

        $.ajax({
            url: 'ajax_set_session.php',
            type: 'POST',
            timeout: 30000, // in milliseconds
            success: function(data) { 
                window.location.href=url;
                return true;
            }
        });
    });
    $(".tour-lock").on('click', function(e) {
        //alert('hello');
        localStorage.removeItem("pageno");


    });
</script>

