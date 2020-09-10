<?php include_once("../globalconfig.php"); ?>
<?php
 //require("../dbconnectvi.php");
 require ("../dbConnect_cfs.php");
 require_once('calendar_cfs/calendar/classes/tc_calendar.php');
 header ( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
header ("Pragma: no-cache");

    //$Db = new dbInvestments();
    $dbconn = new db_connection();
    $currentyear=date('Y');

  session_save_path("/tmp");
	session_start();
		if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
 	{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"">
<meta name="description" content="" />
<meta name="keywords"    content="" />
<title>Venture Intelligence</title>
<script language="javascript" src="calendar_cfs/calendar/calendar.js"></script>
<script type="text/javascript" src="../autocomp_cfs/jquery-1.2.1.pack.js"></script>

<link href="calendar_cfs/calendar/calendar.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="tabs/tab-view.css" />

<SCRIPT LANGUAGE="JavaScript">
function calculate_op(opvalue)
{
  document.companycfs.operatingprofit.value = ( Number(document.companycfs.operationalincome.value) - Number(document.companycfs.opadminotherexp.value));
  document.companycfs.EBITDA.value = (Number(document.companycfs.operationalincome.value) + Number(document.companycfs.otherincome.value) - Number(document.companycfs.opadminotherexp.value));
}
function calculate_EBDT(opvalue)
{
  document.companycfs.EBDT.value = (Number(document.companycfs.EBITDA.value) - Number(document.companycfs.interest.value));
}
function calculate_EBT(opvalue)
{
  var ebtvalue;
  ebtvalue=  (Number(document.companycfs.EBDT.value) - Number(document.companycfs.depreciation.value));
  document.companycfs.EBTpreextraitems.value = ebtvalue.toFixed(2);
}
function calculate_PAT(opvalue)
{
  var patvalue;
  patvalue = (Number(document.companycfs.EBTpreextraitems.value) - Number(document.companycfs.tax.value));
  document.companycfs.PAT.value= patvalue.toFixed(2);
}
function checkFields()
{
	if((document.companycfs.txtfullcompanyname.value=="") || (document.companycfs.companyid.value==""))
	{
	  alert("Please enter the Full Company Name and its Id ");
	  return false;
	}
}
function enabledisable(list) {
 //alert(list.options[list.selectedIndex].value);
    if(list.options[list.selectedIndex].value=="G")
 	{
         document.companycfs.parentcompany.disabled=false;
         document.companycfs.parentcompany_id.disabled=false;
       }
       else
       {
         document.companycfs.parentcompany.disabled=true;
         document.companycfs.parentcompany_id.disabled=true;
       }
}
function enabledisableState(countrylist) {
 //alert(list.options[list.selectedIndex].value);
    if(countrylist.options[countrylist.selectedIndex].value=="IN")
 	{
         document.companycfs.state.disabled=false;
        }
       else
       {
         document.companycfs.state.disabled=true;
         document.companycfs.state.selectedIndex=0;
       }
}

</SCRIPT>
<script type="text/javascript">
	function lookup(inputString) {

		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions').hide();
		} else {
                  //alert('66666666');
			$.post("../autocomp_cfs/autofillcompanies.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').show();
					$('#autoSuggestionsList').html(data);
				}
			});
		}
	} // lookup
	
	function fill(thisValue) {
		$('#inputString').val(thisValue);
		setTimeout("$('#suggestions').hide();", 200);
		

	}
</script>

<style type="text/css">
	body {
		font-family: Helvetica;
		font-size: 11px;
		color: #000;
	}
	
	h3 {
		margin: 0px;
		padding: 0px;	
	}

	.suggestionsBox {
		position: relative;
		top: 162px;
		left: 140px;
		margin: 10px 0px 0px 0px;
		width: 200px;
		background-color: #212427;
		-moz-border-radius: 7px;
		-webkit-border-radius: 7px;
		border: 2px solid #000;	
		color: #fff;
	}
	
	.suggestionList {
		margin: 5px;
		padding: 0px;
	}
	
	.suggestionList li {
		
		margin: 0px 0px 3px 0px;
		padding: 3px;
		cursor: pointer;
	}
	
	.suggestionList li:hover {
		background-color: #659CD8;
	}
</style>



<link href="../css/style_root.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php $id = isset($_GET['id']) ? $_GET['id'] : 1; ?>
<form name="companycfs" enctype="multipart/form-data"  method="post"  action="insert_cfs.php"  onSubmit="return checkFields();">
<div id="containerproductcfs">
<!-- Starting Left Panel -->
  <?php include_once('leftpanel.php'); ?>
<!--  <div id="leftpanel">
    <div><a href="index.htm"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>
    <div id="vertbgprocfs">

		<div id="vertMenu">
		        	<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Import</span></div>
		      	</div>
		      	<div id="linksnone"><a href="dealsinput.php">Investment Deals </a> |  <a href="companyinput.php">Profiles</a><br />


				</div>
		<div id="vertMenu">
			<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Edit</span></div>
		</div>
		<div id="linksnone"><a href="pegetdatainput.php">Deals / Profile</a><br />
							<a href="peadd.php">Add PE Inv </a> | <a href="ipoadd.php">IPO </a> | <a href="mandaadd.php">MandA  </a> |  <a href="mamaadd.php">MA  </a><br />
		</div>

				<div id="vertMenu">
					<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Subscribers</span></div>
				</div>
				<div id="linksnone"><a href="admin.php">Subscriber List</a><br />
			<a href="addcompany.php">Add Subscriber / Members</a><br />
			<a href="delcompanylist.php">List of Deleted Companies</a><br />
			<a href="delmemberlist.php">List of Deleted Emails</a><br />
			<a href="deallog.php">Log</a><br />

				</div>

				<div id="vertMenu">
					<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Exit</span></div>
				</div>
				<div id="linksnone"><a href="../adminlogoff.php">Logout</a><br />
		</div>

    </div>
   </div>-->
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/top1.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>

	<div style="width:565px; float:left; padding-left:2px;">
	  <div style="background-color:#FFF; width:565px; height:492px; margin-top:0px;">
	    <div id="maintextpro">  
            <a href="showfincompanies.php"> Edit Company </a> <br /><br />
           
            <div class="TabView" id="TabView">
               <div class="Tabs" style="width: 452px;">
                <a <?=($id == 1) ? 'class="Current"' : 'href="ui_insert_comp_cfs.php?id=1"';?>>Company Profile</a>
                <a <?=($id == 2) ? 'class="Current"' : 'href="ui_insert_comp_cfs.php?id=2"';?>>Contact Info</a>
                <a <?=($id == 3) ? 'class="Current"' : 'href="ui_insert_comp_cfs.php?id=3"';?>>Other Details</a>
                <a <?=($id == 4) ? 'class="Current"' : 'href="ui_insert_comp_cfs.php?id=4"';?>>FLS-Annl</a>
              </div>

          <div class="Pages" style="width:480px; height: 375px;">
               <div class="Page" style="display: <?=($id == 1) ? 'block' : 'none';?>">
               <div class="Pad">
                  <div id="headingtextpro">
                <table border=0 cellspacing=1 cellpadding=1>
                <tr>
                <td> Full Company Name</td><td > <INPUT NAME="txtfullcompanyname" TYPE="text" size=40>  <input type="text" name="companyid"  size="5">  </td></tr>
                <tr> <td> Brand Name </td><td> <input name="brandname" type="text" size=50 > </td></tr>

                 <tr><td rowspan=2> Company Status </td>
                <td> <SELECT name="companystatus" onclick="enabledisable(this)" style="font-family: Arial; color: #004646;font-size: 8pt">
                  <OPTION value="P" selected> Parent Co. </option>
                  <OPTION  value="G">Group Co. </option>

                 </td> </tr>
                 <tr>     <td  <input type="text" name="parentcompany" size="40" disabled value="" id="inputString"  onkeyup="lookup(this.value);" onblur="fill();"  > 
                  <input type="text" name="parentcompanyid" disabled size="5"> </td>  </tr>
                  <div class="suggestionsBox" id="suggestions" style="display: none;">
				<img src="../autocomp_cfs/upArrow.png" style="position: relative; top: -12px; left: 30px;"  />
				<div class="suggestionList" id="autoSuggestionsList">
					&nbsp;
				</div>

                  <tr> <td> Formerly Called </td><td> <input name="formername" type="text" size=50 > </td></tr>
                <tr><td> Listing Status </td>
                <td> <SELECT name="listingstatus" style="font-family: Arial; color: #004646;font-size: 8pt"> 
                  <OPTION id=0 value="0" selected> -- </option>
                  <OPTION id=0 value="L">Listed </option>
                  <OPTION id=0 value="U"> Unlisted </option>
                 </td> </tr>

                     <tr> <td> Stock Code (BSE) </td><td> <input name="stockcodebse" type="text" size=50 > </td></tr>
                   <tr> <td> Stock Code (NSE) </td><td> <input name="stockcodense" type="text" size=50 > </td></tr>
                 <tr><td>Industry </td>
                 <td><SELECT name="industry" style="font-family: Arial; color: #004646;font-size: 8pt">
        		  		<OPTION id=0 value="0" selected> -- </option>
                                  <?php
                                  	$industrysql="select industry_id,industry from industry_dim where industry_flag=0 AND industry!=''";
        				if ($industryrs = mysql_query($industrysql))
        				{
        				 $ind_cnt = mysql_num_rows($industryrs);
        				}
        				if($ind_cnt>0)
        				{
        					 While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
        					{
        						$id = $myrow[0];
        						$name = $myrow[1];
        						echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
        					}
        				 	mysql_free_result($industryrs);
        				}
            		  ?></select>  </td></tr>
                 <tr><td>Sector </td>
                 <td><SELECT name="sector" style="font-family: Arial; color: #004646;font-size: 8pt">
    		  		<OPTION id=0 value="1" selected> ALL </option>
                          <?php
                          	$sector_sql="select sector_id,sector_name from sector_dim where  sector_name!=''";
				if ($sectorrs = mysql_query($sector_sql))
				{
				 $sector_cnt = mysql_num_rows($sectorrs);
				}
				if($sector_cnt>0)
				{
					 While($mysectorrow=mysql_fetch_array($sectorrs, MYSQL_BOTH))
					{
						$id = $mysectorrow[0];
						$name = $mysectorrow[1];
						echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
					}
				 	mysql_free_result($sectorrs);
				}
    		  ?></select>
                  <input type="text" name="txtnewsector" value="Type Sector to add new" size=40>
                       </td></tr>
                 <tr> <td> Sub Sectors </td><td> <input name="subsector" type="text" size=50 > </td></tr>
                <tr> <td> Brands </td><td> <textarea name="brandtag" row=2 cols=40> </textarea> </td></tr>
                <tr><td >Business Description</td>
               <td><textarea name="txtbusinessdesc" rows="3" cols="40"> </textarea> </td></tr>

                       <tr><td>Region </td>
                       <td><SELECT name="region" style="font-family: Arial; color: #004646;font-size: 8pt">
		  		<OPTION value="0" selected> -- </option>
                          <?php
                          	$region_sql="select region_id,region_name from region_dim where region_name!=''";
				if ($regionrs = mysql_query($region_sql))
				{
				 $region_cnt = mysql_num_rows($regionrs);
				}
				if($region_cnt>0)
				{
					 While($myregionrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
					{
						$id = $myregionrow[0];
						$name = $myregionrow[1];
						echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
					}
				 	mysql_free_result($regionrs);
				}
    		  ?></select>

                 <tr> <td> Incorporation Year </td><td> <input name="yearfounded" type="text" size=3 > </td></tr>

                 <tr>
                  <td>IPO Date (y-m-d)</td>
                  <td><?php
                   $myCalendar = new tc_calendar("ipodate", true, false);
                  $myCalendar->setIcon("calendar_cfs/calendar/images/iconCalendar.gif");
                  $myCalendar->setPath("calendar_cfs/calendar/");
                  $myCalendar->setYearInterval(1998, $currentyear);
                  $myCalendar->dateAllow('1998-11-01', '2049-12-31');
                  $myCalendar->setDateFormat('Y-m-d');
                  $myCalendar->writeScript();
                  ?></td>  </tr>

         </table>
         	</div> <!-- end of headingtextpro-->
         </div > </div> <!--end of Pad,Page Div-->
         
        <!-- Tab for contact info starts -->
        <div class="Page" style="display: <?=($id == 2) ? 'block' : 'none';?>">
               <div class="Pad">
                  <div id="headingtextpro">

        <table border=0 cellspacing=1 cellpadding=1>
        <tr> <td rowspan=2> Address <br>(Headquarters) </td><td> <input name="address1" type="text" size=50 > </td></tr>
        <tr> <td> <input name="address2" type="text" size=50 > </td></tr>
        <tr> <td > City  </td><td> <input name="city" type="text" size=50 > </td></tr>
        <tr><td>Country </td>
                       <td><SELECT name="country" onclick="enabledisableState(this)" style="font-family: Arial; color: #004646;font-size: 8pt">
		  		<OPTION value="NL" selected> -- </option>
                          <?php
                          	$country_sql="select country_id,country_name from country_dim where country_name!=''";
				if ($countryrs = mysql_query($country_sql))
				{
				 $country_cnt = mysql_num_rows($countryrs);
				}
				if($country_cnt>0)
				{
					 While($mycountryrow=mysql_fetch_array($countryrs, MYSQL_BOTH))
					{
						$id = $mycountryrow[0];
						$name = $mycountryrow[1];
						echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
					}
				 	mysql_free_result($regionrs);
				}
    		  ?></select>  </td></tr>
    		  <tr><td>State </td>
                       <td><SELECT name="state" disabled="disabled" style="font-family: Arial; color: #004646;font-size: 8pt">
		  		<OPTION value="0" selected> -- </option>
                          <?php
                          	$state_sql="select state_id,state_name from state_dim where state_name!=''";
				if ($staters = mysql_query($state_sql))
				{
				 $state_cnt = mysql_num_rows($staters);
				}
				echo "<br>State cnt- ".$state_cnt;
				if($state_cnt>0)
				{
					 While($mystaterow=mysql_fetch_array($staters, MYSQL_BOTH))
					{
						$id = $mystaterow[0];
						$name = $mystaterow[1];
						echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
					}
				 	mysql_free_result($staters);
				}
    		  ?></select>  </td></tr>


        <tr> <td > Pincode  </td><td> <input name="pincode" type="text" size=50 > </td></tr>


        <tr> <td > Telephone  </td><td> <input name="telephone" type="text" size=v > </td></tr>
        <tr> <td > Fax  </td><td> <input name="fax" type="text" size=50 > </td></tr>
        <tr> <td > Email  </td><td> <input name="email" type="text" size=50 > </td></tr>
        <tr> <td > Website  </td><td> <input name="website" type="text" size=50 > </td></tr>
        <tr> <td > CEO  </td><td> <input name="ceo" type="text" size=50 > </td></tr>
        <tr> <td> CFO  </td><td> <input name="cfo" type="text" size=50 > </td></tr>


        </table>	</div> <!-- end of headingtextpro-->
        </div></div>
        <!--Contact info tab ends-->
         


          <!-- Tab for Other details starts -->
        <div class="Page" style="display: <?=($id == 3) ? 'block' : 'none';?>">
               <div class="Pad">
                  <div id="headingtextpro">
        <table border=0 cellspacing=1 cellpadding=1>
         <tr> <td rowspan=5> Listed Competiors  </td><td> <input name="listed_competitor_1" type="text" size=50 > </td></tr>
          <tr><td>  <input name="listed_competitor_2" type="text" size=50 > </td></tr>
          <tr><td>  <input name="listed_competitor_3" type="text" size=50 > </td></tr>
          <tr><td>  <input name="listed_competitor_4" type="text" size=50 > </td></tr>
          <tr><td>  <input name="listed_competitor_5" type="text" size=50 > </td></tr>
          <tr> <td colspan=2> <hr> </td></tr>
           <tr> <td rowspan=5> Unlisted Competiors  </td><td> <input name="unlisted_competitor_1" type="text" size=50 > </td></tr>
          <tr><td>  <input name="unlisted_competitor_2" type="text" size=50 > </td></tr>
          <tr><td>  <input name="unlisted_competitor_3" type="text" size=50 > </td></tr>
          <tr><td>  <input name="unlisted_competitor_4" type="text" size=50 > </td></tr>
          <tr><td>  <input name="unlisted_competitor_5" type="text" size=50 > </td></tr>
         <tr> <td colspan=2> <hr> </td></tr>
         <tr> <td rowspan=5> Listed Comparables  </td><td> <input name="listed_comparable_1" type="text" size=50 > </td></tr>
          <tr><td>  <input name="listed_comparable_2" type="text" size=50 > </td></tr>
          <tr><td>  <input name="listed_comparable_3" type="text" size=50 > </td></tr>
          <tr><td>  <input name="listed_comparable_4" type="text" size=50 > </td></tr>
          <tr><td>  <input name="listed_comparable_5" type="text" size=50 > </td></tr>
          <tr> <td colspan=2> <hr> </td></tr>
           <tr> <td rowspan=5> Unlisted Comparables  </td><td> <input name="unlisted_comparable_1" type="text" size=50 > </td></tr>
          <tr><td>  <input name="unlisted_comparable_2" type="text" size=50 > </td></tr>
          <tr><td>  <input name="unlisted_comparable_3" type="text" size=50 > </td></tr>
          <tr><td>  <input name="unlisted_comparable_4" type="text" size=50 > </td></tr>
          <tr><td>  <input name="unlisted_comparable_5" type="text" size=50 > </td></tr>
             <tr> <td colspan=2> <hr> </td></tr>

          <tr> <td> Share Holder Name </td><td> <input name="shareholdername" type="text" size=50 > </td></tr>
          <tr> <td>  Type </td>
                           <td><SELECT name="shtype" style="font-family: Arial; color: #004646;font-size: 8pt">
		  		<OPTION  value="0" selected> -- </option>
                          <?php
                          	$sh_type_sql="select shtype_id,shtype_name from shareholdertype_dim where shtype_name!=''";
				if ($rssh_type = mysql_query($sh_type_sql))
				{
				 $shtype_cnt = mysql_num_rows($rssh_type);
				}
				if($shtype_cnt>0)
				{
					 While($mysh_typerow=mysql_fetch_array($rssh_type, MYSQL_BOTH))
					{
						$id = $mysh_typerow[0];
						$name = $mysh_typerow[1];
						echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
					}
				 	mysql_free_result($rssh_type);
				}
    		          ?></select>   </td>   </tr>
            <tr> <td> No. Shares </td><td> <input name="noshares" type="text" size=5 > </td></tr>
             <tr> <td> Stake (%) </td><td> <input name="stakepercentage" type="text" size=5 > </td></tr>


        </table>	</div> <!-- end of headingtextpro-->
        </div></div>
        <!--Other details tab ends-->


         <!-- Tab for FLS starts -->
        <div class="Page" style="display: <?=($id == 4) ? 'block' : 'none';?>">
               <div class="Pad">
                  <div id="headingtextpro">

        <table border=0 cellspacing=1 cellpadding=1>
        
                  <tr> <td>Financial Year (y-m-d)</td>
                  <td><?php

                  $myCalendar = new tc_calendar("finyear", true, false);
                  $myCalendar->setIcon("calendar_cfs/calendar/images/iconCalendar.gif");
                  $myCalendar->setPath("calendar_cfs/calendar/");
                  $myCalendar->setYearInterval(1998, $currentyear);
                  $myCalendar->dateAllow('1998-11-01', '2049-12-31');
                  $myCalendar->setDateFormat('Y-m-d');
                  $myCalendar->writeScript();
                  ?> &nbsp;&nbsp;&nbsp;
                  <select name="currencyflag">
                  <option value=0 SELECTED>INR Crore </option>
                  <option value=1>INR Lakhs</option>
                  <option value=2>INR </option>
                  </select>
                   <select name="fintype">
                  <option value=0 SELECTED>STANDALONE </option>
                  <option value=1>CONSOLIDATED</option>
                  </select>

                  </td>  </tr>
        <tr> <td> Operational Income</td><td> <input name="operationalincome" type="text" size=15 style="text-align: right"> </td></tr>
        <tr> <td> Other Income </td>  <td> <input name="otherincome" type="text" size=15 style="text-align: right" > </td></tr>
        <tr> <td > Operational, Admin & Other Exp  </td><td> <input name="opadminotherexp" onChange="calculate_op(this.value)" type="text" size=15 style="text-align: right" > </td></tr>
        <tr> <td > Operating Profit  </td><td> <input name="operatingprofit" type="text"  size=15 style="text-align: right" > </td></tr>
        <tr> <td > EBITDA  </td><td> <input name="EBITDA" type="text" size=15 style="text-align: right"> </td></tr>
        <tr> <td > Interest  </td><td> <input name="interest" type="text" onChange="calculate_EBDT(this.value)" size=15 style="text-align: right"> </td></tr>
        <tr> <td > EBDT  </td><td> <input name="EBDT" type="text"  size=15 style="text-align: right"> </td></tr>
        <tr> <td > Depreciation  </td><td> <input name="depreciation" type="text"  onChange="calculate_EBT(this.value)" size=15 style="text-align: right" > </td></tr>
        <tr> <td > EBT   </td><td> <input name="EBTpreextraitems" type="text" size=15 style="text-align: right"> </td></tr>
        <!--<tr> <td > Extra Ordinary Items  </td><td> <input name="extraitems" type="text" size=15 style="text-align: right"> </td></tr>
        <tr> <td > EBT (Post Extra Ordinary Items  </td><td> <input name="EBTpostextraitems" type="text" size=15 style="text-align: right"> </td></tr>-->
        <tr> <td> Tax  </td><td> <input name="tax" type="text" onChange="calculate_PAT(this.value)"size=15 style="text-align: right"> </td></tr>
         <tr> <td> PAT  </td><td> <input name="PAT" type="text" size=15 style="text-align: right"> </td></tr>
         <!--<tr> <td> PAT after Minority Interest  </td><td> <input name="PATafterminorityinterest" type="text" size=15 style="text-align: right"> </td></tr>-->
           <tr> <td> EPS (Basic in INR)  </td><td> <input name="eps" type="text" size=15 style="text-align: right"> </td></tr>


        </table>	</div> <!-- end of headingtextpro-->
        </div></div>
        <!--FLS tab ends-->


       </div></div>  <!-- end of the new class Pages , Tabview tags -->

       <p align=center> <input type="submit" value="Insert CFS" name="insertcfs"> </p>
        </div> <!-- end of maintext pro-->
	  </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>

    <script type="text/javascript" src="tabs/tab-view.js"></script>
  <script type="text/javascript">
  tabview_initialize('TabView');
</script>

<SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom1.js"></SCRIPT>


   </form>

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
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>