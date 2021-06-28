 <style>
	/*Added due to the dashboard*/
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
		.subnav li:hover {
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

.subnav-content a:hover {
  /* background-color: #eee; */
  color: black;
}
.subnav-content ul>li>a,.subnav-content1 ul>li>a{
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

$lgDealCompId = $_SESSION['DcompanyId'];
$usrRgsql = "SELECT * FROM `dealcompanies` WHERE `DCompId`='".$lgDealCompId."'";
$usrRgres = mysql_query($usrRgsql) or die(mysql_error());
$usrRgs = mysql_fetch_array($usrRgres);

 if($_SESSION['peonly']==1){ ?>
<li <?php echo ($topNav=='Dashboard') ? 'class="active"' : '' ; ?>><a href="dashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li <?php echo ($topNav=='Deals') ? 'class="active subnav"' : 'class="subnav"' ; ?>><a id="dealhover" href="javascript:void(0)" class="popup_call" data-url="index.php"><i class="i-data-deals"></i>
Deals</a>
<div class="subnav-content">
    <ul style="display:grid">
      <li class="subnav1 border-btm-head"><a id="pevchover" class="index" href="index.php?value=0" >PE-VC Investments</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                            aria-hidden="true"></i>
    <div class="subnav-content1">
        <ul style="display:grid">
            <li class="border-btm-head"><a class="index" href="index.php?value=1" >Venture Capital Only</a></li>
            <li class="border-btm-head"><a class="svindex" id="svhover" href="svindex.php?value=3">Social VC / Impact</a></li>
            <li class="border-btm-head"><a class="svindex" href="svindex.php?value=5">Infrastructure</a></li>
            <li><a class="svindex" href="svindex.php?value=4">Cleantech</a></li>
        </ul>
    </div>
</li>
      <li class="subnav2 border-btm-head"><a class="mandaindex" href="mandaindex.php?value=0-2">PE-VC Exits</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
            <div class="subnav-content2">
                <ul style="display:grid">
                    <li class="subnav3 border-btm-head"><a class="mandaindex" id="mapevchover" href="mandaindex.php?value=0-0" >via M&A (PE-VC)</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
                                    <div class="subnav-content3">
                                        <ul style="display:grid">
                                            <li><a  class="mandaindex" href="mandaindex.php?value=1-0">M&A (VC)</a></li>
                                        </ul>
                                    </div>
                    </li>
                    <li class="subnav4"><a class="mandaindex" href="mandaindex.php?value=0-1">via Public Market (PE-VC)</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
                                    <div class="subnav-content4">
                                        <ul style="display:grid">
                                            <li><a class="mandaindex" href="mandaindex.php?value=1-1">via Public Market (VC)</a></li>
                                        </ul>
                                    </div>
                    </li>
        </ul>
    </div></li>
      <li class="subnav5 border-btm-head"><a class="ipoindex" href="ipoindex.php?value=0">PE-VC Backed IPOs</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
                                    <div class="subnav-content5">
                                        <ul style="display:grid">
                                            <li><a class="ipoindex" href="ipoindex.php?value=1">VC Backed IPOs</a></li>
                                        </ul>
                                    </div>
      </li>
      <li  class="border-btm-head"><a id="angelindex" href="angelindex.php">Angel Investments</a></li>
      <li><a id="incindex" href="incindex.php">Incubation / Acceleration</a></li>
 </ul>
    </div>
</li>
<li <?php echo ($topNav=='Directory') ? 'class="active"' : '' ; ?> id="tour_directory"><a href="pedirview.php"><i class="i-directory"></i>Directory</a></li>
<li <?php echo ($topNav=='Funds') ? 'class="active"' : '' ; ?>><a <?php if($usrRgs['PEInv'] == 0){ echo "style=pointer-events:none"; } ?> id="funds" href="funds.php"><i class="i-directory"></i>Funds <span class="betaversion">Beta</span></a></li>
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

 <?php } 
 else if($_SESSION['vconly']==1){ ?>
<li <?php echo ($topNav=='Dashboard') ? 'class="active"' : '' ; ?>><a href="dashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li <?php echo ($topNav=='Deals') ? 'class="active subnav"' : 'class="subnav"' ; ?>><a id="dealhover" href="javascript:void(0)" class="popup_call" data-url="index.php?value=1"><i class="i-data-deals"></i>Deals</a>
<div class="subnav-content">
    <ul style="display:grid">
      <li class="subnav1 border-btm-head"><a id="pevchover" class="index" href="index.php?value=0" >PE-VC Investments</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                            aria-hidden="true"></i>
    <div class="subnav-content1">
        <ul style="display:grid">
            <li class="border-btm-head"><a class="index" href="index.php?value=1" >Venture Capital Only</a></li>
            <li class="border-btm-head"><a id="svhover" class="svindex" href="svindex.php?value=3">Social VC / Impact</a></li>
            <li class="border-btm-head"><a class="svindex" href="svindex.php?value=5">Infrastructure</a></li>
            <li><a class="svindex" href="svindex.php?value=4">Cleantech</a></li>
        </ul>
    </div>
</li>
      <li class="subnav2 border-btm-head"><a id="pevcexit" class="mandaindex" href="mandaindex.php?value=0-2">PE-VC Exits</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
            <div class="subnav-content2">
                <ul style="display:grid">
                    <li class="subnav3 border-btm-head"><a class="mandaindex" id="mapevchover" href="mandaindex.php?value=0-0" >via M&A (PE-VC)</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
                                    <div class="subnav-content3">
                                        <ul style="display:grid">
                                            <li><a class="mandaindex" href="mandaindex.php?value=1-0">M&A (VC)</a></li>
                                        </ul>
                                    </div>
                    </li>
                    <li class="subnav4"><a class="mandaindex" href="mandaindex.php?value=0-1">via Public Market (PE-VC)</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
                                    <div class="subnav-content4">
                                        <ul style="display:grid">
                                            <li><a class="mandaindex" href="mandaindex.php?value=1-1">via Public Market (VC)</a></li>
                                        </ul>
                                    </div>
                    </li>
        </ul>
    </div></li>
      <li class="subnav5 border-btm-head"><a class="ipoindex" href="ipoindex.php?value=0">PE-VC Backed IPOs</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
                                    <div class="subnav-content5">
                                        <ul style="display:grid">
                                            <li><a class="ipoindex" href="ipoindex.php?value=1">VC Backed IPOs</a></li>
                                        </ul>
                                    </div>
      </li>
      <li class="border-btm-head"><a id="angelindex" href="angelindex.php">Angel Investments</a></li>
      <li><a id="incindex" href="incindex.php">Incubation / Acceleration</a></li>
 </ul>
    </div>
</li>
<li <?php echo ($topNav=='Directory') ? 'class="active"' : '' ; ?> id="tour_directory"><a href="pedirview.php?value=1"><i class="i-directory"></i>Directory</a></li>
<li <?php echo ($topNav=='Funds') ? 'class="active"' : '' ; ?>><a <?php if($usrRgs['VCInv'] == 0){ echo "style=pointer-events:none"; } ?> id="funds" href="funds.php"><i class="i-directory"></i>Funds <span class="betaversion">Beta</span></a></li>
<script>
$(document).ready(function() {    
    $(".peonly").hide();
    $(".peonly").attr('disabled','disabled');
    $(".vconly").attr('selected','selected');
    $(".peonly").remove();
    
    $("#exitsviape").hide();
    $("#exitsviavc").show();
});
</script>

 <?php } else {?>  
<li <?php echo ($topNav=='Dashboard') ? 'class="active "' : '' ; ?>><a href="dashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li  <?php echo ($topNav=='Deals') ? 'class="active subnav"' : 'class="subnav"' ; ?>><a id="dealhover" href="javascript:void(0)" class="popup_call" data-url="index.php"><i class="i-data-deals"></i>Deals</a>
<div class="subnav-content">
    <ul style="display:grid">
      <li class="subnav1 border-btm-head"><a id="pevchover" class="index" href="index.php?value=0" >PE-VC Investments</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
														aria-hidden="true"></i>
    <div class="subnav-content1">
        <ul style="display:grid">
            <li class="border-btm-head"><a class="index" href="index.php?value=1" >Venture Capital Only</a></li>
            <li class="border-btm-head"><a id="svhover" class="svindex" href="svindex.php?value=3">Social VC / Impact</a></li>
            <li class="border-btm-head"><a class="svindex" href="svindex.php?value=5">Infrastructure</a></li>
            <li><a  class="svindex" href="svindex.php?value=4">Cleantech</a></li>
        </ul>
    </div>
</li>
      <li class="subnav2 border-btm-head"><a id="pevcexit" class="mandaindex"  href="mandaindex.php?value=0-2">PE-VC Exits</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
            <div class="subnav-content2">
                <ul style="display:grid">
                    <li class="subnav3 border-btm-head"><a id="mapevchover" class="mandaindex" href="mandaindex.php?value=0-0" >via M&A (PE-VC)</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
                                    <div class="subnav-content3">
                                        <ul style="display:grid">
                                            <li><a class="mandaindex" href="mandaindex.php?value=1-0">M&A (VC)</a></li>
                                        </ul>
                                    </div>
                    </li>
                    <li class="subnav4"><a class="mandaindex" href="mandaindex.php?value=0-1">via Public Market (PE-VC)</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
                                    <div class="subnav-content4">
                                        <ul style="display:grid">
                                            <li><a class="mandaindex" href="mandaindex.php?value=1-1">via Public Market (VC)</a></li>
                                        </ul>
                                    </div>
                    </li>
        </ul>
    </div></li>
      <li class="subnav5 border-btm-head"><a class="ipoindex" href="ipoindex.php?value=0">PE-VC Backed IPOs</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
                                    <div class="subnav-content5">
                                        <ul style="display:grid">
                                            <li><a class="ipoindex" href="ipoindex.php?value=1">VC Backed IPOs</a></li>
                                        </ul>
                                    </div>
      </li>
      <li class="border-btm-head"><a id="angelindex" href="angelindex.php">Angel Investments</a></li>
      <li><a  id="incindex" href="incindex.php">Incubation / Acceleration</a></li>
 </ul>
    </div>
 </li>
<li <?php echo ($topNav=='Directory') ? 'class="active"' : '' ; ?> id="tour_directory"><a href="pedirview.php?value=0"><i class="i-directory"></i>Directory</a></li>
<li <?php echo ($topNav=='Funds') ? 'class="active"' : '' ; ?>><a <?php if($usrRgs['PEInv'] == 0 && $usrRgs['VCInv'] == 0){ echo "style=pointer-events:none"; } ?> id="funds" href="funds.php"><i class="i-directory"></i>Funds <span class="betaversion">Beta</span></a></li>
 <?php } ?>
</ul>
<script>
    $(".tour-lock").on('click', '.popup_call', function(e) {
        e.preventDefault();
        var url = $(this).attr('data-url'); 
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
</script>

