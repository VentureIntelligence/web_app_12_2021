<?php
session_start();
	require("dbconnectvi.php");
	$Db = new dbConnect();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence - Private Equity, Venture Capital, M&A data, analysis and news</title>
<SCRIPT LANGUAGE="JavaScript">
var seriesoption;
function keycheck(str)
{
          keycode = window.event.keyCode;
          if (str=='Fullname')
          {
            if ((keycode>=97 && keycode<=122)||(keycode>=65 && keycode<=90)||(keycode==32)||(keycode==46))
            {
               return true;
            }
            else
            {
               window.event.keyCode=0;
            }
          }
          if (str=='Postal')
          {
            if ((keycode>=48 && keycode<=57)||(keycode==32))
            {
               return true;
            }
            else
            {
               window.event.keyCode=0;
            }
          }
          if (str=='Telephone')
          {
            if ((keycode>=48 && keycode<=57)||(keycode==32)||(keycode==45))
            {
               return true;
            }
            else
            {
               window.event.keyCode=0;
            }
          }
}
function CurrencyValue(str)
{

	document.submitOnline.VC_BC.checked=false;
	document.submitOnline.VC_ABC.checked=false;
	document.submitOnline.VIAmt_noCFS[0].checked=false;
        document.submitOnline.VIAmt_noCFS[1].checked=false;
        document.submitOnline.VIAmt_noCFS[2].checked=false;
        document.submitOnline.VIAmt_noCFS[3].checked=false;
        document.submitOnline.VIAmt_noCFS[4].checked=false;
	//document.submitOnline.VC_ABC[1].checked=false;
	if((document.submitOnline.VIAmt[0].checked==true) || (document.submitOnline.VIAmt[3].checked==true) || (document.submitOnline.VIAmt[4].checked==true) )
	{
		document.submitOnline.VC_BC.checked=false;
	}
	if((document.submitOnline.VIAmt[2].checked==true) || (document.submitOnline.VIAmt[3].checked==true) || (document.submitOnline.VIAmt[4].checked==true) )
	{
		document.submitOnline.LoginVIAmt[0].checked=false;
		document.submitOnline.LoginVIAmt[1].checked=false;
	}

	document.submitOnline.hidProduct.value ='Deal Digest - Series ' + str.substring(0,1)
	document.submitOnline.hidREProduct.value = str.substring(0,1)
	//alert(str);
    document.submitOnline.currencymode.value=str.substring(1,3)
    seriesoption=str.substring(0,1);

}

function CurrencyValue_noCFS(str)
{

	document.submitOnline.VC_BC.checked=false;
	document.submitOnline.VC_ABC.checked=false;
	document.submitOnline.VIAmt[0].checked=false;
        document.submitOnline.VIAmt[1].checked=false;
        document.submitOnline.VIAmt[2].checked=false;
        document.submitOnline.VIAmt[3].checked=false;
        document.submitOnline.VIAmt[4].checked=false;
	//document.submitOnline.VC_ABC[1].checked=false;
	if((document.submitOnline.VIAmt_noCFS[0].checked==true) || (document.submitOnline.VIAmt_noCFS[3].checked==true) || (document.submitOnline.VIAmt_noCFS[4].checked==true) )
	{
		document.submitOnline.VC_BC.checked=false;
	}
	if((document.submitOnline.VIAmt_noCFS[0].checked==true) || (document.submitOnline.VIAmt_noCFS[3].checked==true) || (document.submitOnline.VIAmt_noCFS[4].checked==true) )
	{
		document.submitOnline.LoginVIAmt[0].checked=false;
		document.submitOnline.LoginVIAmt[1].checked=false;
	}

	document.submitOnline.hidProduct.value ='Deal Digest - Series ' + str.substring(0,1)
	document.submitOnline.hidREProduct.value = str.substring(0,1)
	//alert(str);
    document.submitOnline.currencymode.value=str.substring(1,3)
    seriesoption=str.substring(0,1);

}

function addon(repvalue)
{
	//alert("----");
	document.submitOnline.addonRep.value=repvalue;
	if((document.submitOnline.VIAmt[0].checked==true) || (document.submitOnline.VIAmt[1].checked==true)|| (document.submitOnline.VIAmt_noCFS[0].checked==true) || (document.submitOnline.VIAmt_noCFS[1].checked==true))
   {
   		alert("Series D & E subscribers will get this report automatically");
	    document.submitOnline.VC_ABC.checked=false;

    }
	if((document.submitOnline.VC_BC.checked==true) || (document.submitOnline.VC_BC_noCFS.checked==true) )
	{
		document.submitOnline.VC_ABC.checked=false;
	}
}

function REaddon(repvalue)
{
	//alert("----");
	document.submitOnline.addonRep.value=repvalue;
	if((document.submitOnline.VIAmt[0].checked==true) || (document.submitOnline.VIAmt[1].checked==true) )
   {
   		alert("Series D & E subscribers will get this report automatically");
	    document.submitOnline.VC_ABC.checked=false;

    }
	if((document.submitOnline.VC_BC.checked==true) )
	{
		document.submitOnline.VC_ABC.checked=false;
	}
}

function loginshow(txt)
{
	document.submitOnline.showlogins.value=txt;
	if((document.submitOnline.VIAmt[2].checked==true) || (document.submitOnline.VIAmt[3].checked==true) || (document.submitOnline.VIAmt[4].checked==true)
           (document.submitOnline.VIAmt_noCFS[2].checked==true) || (document.submitOnline.VIAmt_noCFS[3].checked==true) || (document.submitOnline.VIAmt_noCFS[4].checked==true) )
	{

		document.submitOnline.VIAmt[2].checked=false;
		document.submitOnline.VIAmt[3].checked=false;
		document.submitOnline.VIAmt[4].checked=false;
		document.submitOnline.VIAmt_noCFS[2].checked=false;
		document.submitOnline.VIAmt_noCFS[3].checked=false;
		document.submitOnline.VIAmt_noCFS[4].checked=false;
	}

}
function ltrim(str){
                return str.replace(/^\s+/, '');
            }
            function rtrim(str) {
                return str.replace(/\s+$/, '');
            }
            function alltrim(str) {
                return str.replace(/^\s+|\s+$/g, '');
            }

function optionforseriesE()
{

	//document.submitOnline.VC_ABC.checked=false;
	if((seriesoption=="D") || (seriesoption=="A"))
		{
			if(document.submitOnline.VC_BC_E.checked==true)
			{
				alert("Applicable only for Seires B & C subscribers");
				document.submitOnline.VC_BC_E.checked=false;
			//	return false;
			}
		}

}

function optionforbc()
{
	//document.submitOnline.VC_ABC.checked=false;
	if((seriesoption=="D") || (seriesoption=="A"))
		{
			if(document.submitOnline.VC_BC.checked==true)
			{
				alert("Applicable only for Seires B & C subscribers");
				document.submitOnline.VC_BC.checked=false;
			//	return false;
			}
		}

}


function checkFields()
{
	var namestr;
	var members;

//	alert(seriesoption);
    //alert(document.submitOnline.txtminus.value);
        if (document.submitOnline.txtminus.value!=99)
        { return false };
	if(document.submitOnline.chkTerm.checked==false)
	{
	alert("Please accept the Terms and Conditions");
		return false;
	}


	for(i=0;i<10;i++)
	{
	if (((document.submitOnline.Names[i].value!="") && (document.submitOnline.Mails[i].value=="")) ||
		((document.submitOnline.Names[i].value=="") && (document.submitOnline.Mails[i].value!="")))
	{
	        alert("Both Name(s) and Email Id(s) are required");
	        document.submitOnline.Names[i].focus();
	        return false;
	}
	}

	for(i=0;i<10;i++)
	{
		if (document.submitOnline.Mails[i].value.length != 0)
		{
		if(document.submitOnline.Mails[i].value.match(/[a-zA-Z0-9]+\@[a-zA-Z0-9-]+(\.([a-zA-Z0-9]{2}|[a-zA-Z0-9]{2}))+/)==null)
		{
		alert("Please enter a valid E-mail ID (eg: info@ventureintelligence.com)");
		document.submitOnline.Mails[i].focus();
		return false;
		}
		}

	}
namestr="";
members="";
var onlineproceed="";

for (i=0;i<10;i++)
{
  if(document.submitOnline.Names[i].value.length != 0)
  {
      if (namestr=="")
      {
        namestr = document.submitOnline.Names[i].value + "|" + document.submitOnline.Mails[i].value;
        members =  document.submitOnline.Names[i].value + "/" + document.submitOnline.Mails[i].value;
      }
      else
      {
        namestr = namestr + "~" + document.submitOnline.Names[i].value + "|" + document.submitOnline.Mails[i].value;
        members = members + "," + document.submitOnline.Names[i].value + "/" + document.submitOnline.Mails[i].value;
      }
  }
}
document.submitOnline.hidNames.value=namestr;
document.submitOnline.hidMembers.value=members;

document.submitOnline.VIAmt[0].checked==false
document.submitOnline.VIAmt[1].checked==false
document.submitOnline.VIAmt[2].checked==false
document.submitOnline.VIAmt[3].checked==false
document.submitOnline.VIAmt[4].checked==false
document.submitOnline.VIAmt_noCFS[0].checked==false
document.submitOnline.VIAmt_noCFS[1].checked==false
document.submitOnline.VIAmt_noCFS[2].checked==false
document.submitOnline.VIAmt_noCFS[3].checked==false
document.submitOnline.VIAmt_noCFS[4].checked==false
document.submitOnline.Paymode[0].checked==false
document.submitOnline.Paymode[1].checked==false
//document.submitOnline.Paymode[2].checked==false

missinginfo = "";

if( ltrim(document.submitOnline.Fullname.value) == "") {
	missinginfo += "\n     -  Full Name";
}
if (ltrim(document.submitOnline.FirmName.value) == "") {
	missinginfo += "\n     -  Firm Name";
}
if(ltrim (document.submitOnline.Address1.value) == "") {
	missinginfo += "\n     -  Address";
}
if(ltrim (document.submitOnline.City.value) == "") {
	missinginfo += "\n     -  City";
}
if(ltrim (document.submitOnline.State.value) == "") {
	missinginfo += "\n     -  State";
}
if(ltrim (document.submitOnline.Postal.value) == "") {
	missinginfo += "\n     -  Postal Code";
}
if(ltrim (document.submitOnline.Telephone.value )== "") {
	missinginfo += "\n     -  Telephone";
}
if(ltrim (document.submitOnline.YourMail.value) == "") {
	missinginfo += "\n     -  Email Id";
}
if (document.submitOnline.YourMail.value.length != 0){
	if(document.submitOnline.YourMail.value.match(/[a-zA-Z0-9]+\@[a-zA-Z0-9-]+(\.([a-zA-Z0-9]{2}|[a-zA-Z0-9]{2}))+/)==null)
	{
	alert("Please enter a valid E-mail ID (eg: info@ventureintelligence.com)");
	document.submitOnline.YourMail.focus();
	return false;
	}
}
if ((document.submitOnline.VIAmt[0].checked==false) && (document.submitOnline.VIAmt[1].checked==false) && (document.submitOnline.VIAmt[2].checked==false) && (document.submitOnline.VIAmt[3].checked==false) && (document.submitOnline.VIAmt[4].checked==false)
&& (document.submitOnline.VIAmt_noCFS[0].checked==false) && (document.submitOnline.VIAmt_noCFS[1].checked==false) && (document.submitOnline.VIAmt_noCFS[2].checked==false) && (document.submitOnline.VIAmt_noCFS[3].checked==false) && (document.submitOnline.VIAmt_noCFS[4].checked==false))
{
	missinginfo += "\n     -  Pricing";
}
if ((document.submitOnline.Paymode[0].checked==false) && (document.submitOnline.Paymode[1].checked==false) )
{
	//&& (document.submitOnline.Paymode[2].checked==false))
	missinginfo += "\n      - Payment Mode";
}


//	if((document.submitOnline.VIAmt[0].checked) || (document.submitOnline.VIAmt[1].checked) || (document.submitOnline.VIAmt[2].checked))
//	{
		if(document.submitOnline.Paymode[0].checked)
		{
				if (confirm("Online credit card payment in Indian Rupees involves an additional 5% processing charge"))
				{
					onlineproceed=1;
				}
				else
				{
					onlineproceed=0
				}
		}
		else
			onlineproceed=1;
//	}
//	else
//	onlineproceed=1;


	if (missinginfo != "")
	{
		missinginfo ="\n" +
		"You failed to correctly fill in your:\n" +
		missinginfo + "\n" +
		"\nPlease re-enter and submit again!";
		alert(missinginfo);

		return false;
	}
	else
	{
		if (onlineproceed==1)
		{	return true;}
		else
		{	return false;}

	}




	}

</SCRIPT>

<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<form name="submitOnline" onSubmit="return checkFields();" method="post" action="1onSubmitdd-subscribe.php" >
<input type="hidden" name="currencymode">
<input type="hidden" name="hidNames">
<input type="hidden" name="hidMembers">
<input type="hidden" name="hidProduct" value="">
<input type="hidden" name="hidREProduct" value="">
<input type="hidden" name="addonRep" value="">
<input type="hidden" name="showlogins" value="">
<div id="containerproductddsubscribe_E1">

<!-- Starting Left Panel -->
<?php include_once('leftpanel.php'); ?>
<!--  <div id="leftpanel">
    <div><a href="index.htm"><img src="images/logo.jpg" width="183" height="98" border="0"></a></div>

    <div id="vertbgproddsubscribemain_E1">

      <div id="vertMenu">
       <div><img src="images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Products</span></div>
	         </div>
	         <div id="linksnone"><a href="newsletters.htm">Newsletters</a><br />
	             <span id="visitlink"><a href="peroundup.htm">PE Reports</a><br />
	             </span>
	             <a href="vcroundup.htm">VC Reports</a><br />
			   <a href="directories.htm">Directories</a><br />
			   <a href="peimpact.htm">PE Impact Report </a> <br />
          	             <a href="sector.htm">Sector Reports</a><br />
	             <a href="db.htm">Databases</a><br />
	             </div>
	       	 <div id="eventslinkabt">
	              <div><img src="images/dot1.gif" />&nbsp;&nbsp;<a href="events.htm">Events</a></div>
	            </div>

	   			 <div id="eventslinkabt1">
	   				          <div><img src="images/dot1.gif" />&nbsp;&nbsp;<a href="news.htm">News</a></div>
	   			      </div>

    </div>

  </div>-->
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/top.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>

	<div style="width:565px; float:left; padding-left:2px;">
	  <div style="width:565px; margin-top:8px;"><img src="images/product-top.jpg" width="566" height="121"></div>
	  <div style="background-color:#FFF; width:566px; height:2363px; margin-top:5px;"><div id="navpro">
        <div class="links">
       <!--   <ul>
            <li><img src="images/arrow.gif" /> <a href="subscribe.htm">Subscribe</a> </li>
            <li><img src="images/arrow.gif" /> <a href="advertise.htm">Advertise </a> </li>
            <li><img src="images/arrow.gif" /> <a href="sponsor.htm">Sponsor</a></li>
          </ul>
          -->
        </div>
	  </div>
	    <div id="maintextpro">
          <div id="headingtextpro">

		  	<!--<div id="headingtextprobold">Please click on the product names in the table below to view more details.<br /> <br /></div>-->

			<!--The Deal Digest provides a summary of venture capital, private equity, IPO and M&A deals in India.
			 The newsletter is delivered
			by email on Wednesdays. <br /> <Br />-->

			<div id="headingtextprobold">Subscription Options - For more details on each product, please click on their names in the table below. <a href="trialrequest.php">Click Here</a> to request a trial.<br /> <br /></div>

			<table border=1 width="500" cellpadding=0 cellspacing=0>

			<tr> <td align=center width="175">
			<div id="headingtextprobold">Benefits</div> </td>
			<td align=center width="65">
			<div id="headingtextprobold">Series E</div></td>
			<td align=center width="65">
			<div id="headingtextprobold">Series D</div></td>
			<td align=center width="65">
			<div id="headingtextprobold">Series C</div></td>
			<td align=center width="65">
			<div id="headingtextprobold">Series B</div></td>
			<td align=center width="65">
			<div id="headingtextprobold">Series A</div></td> </tr>


			<tr><td>
			<div id="headingtextpro"> &nbsp;<a target="_blank" href="pelogin.php"><u>PE Deal Database</u></a> (deals since 1998)
			</div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold">-</div></td>
			<td align=center><div id="headingtextprobold">-</div></td>
			<td align=center><div id="headingtextprobold">-</div></td></tr>

			<tr><td>
			<div id="headingtextpro"> &nbsp;<a target="_blank" href="malogin.php"><u>M&A Deal Database</u></a> (deals since ’04)
			</div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold">-</div></td>
			<td align=center><div id="headingtextprobold">-</div></td>
			<td align=center><div id="headingtextprobold">-</div></td>
			<td align=center><div id="headingtextprobold">-</div></td></tr>

                        	<tr><td>
			<div id="headingtextpro"> &nbsp; <a target="_blank" href="/cfs/login.php"> <u>Private Company Financials Search Database </u></a> <sup>** </sup>
			</div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td></tr>


			<tr><td>
			<div id="headingtextpro"> &nbsp;Annual M&A Report summarizing all inbound, outbound and domestic deals.
			</div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold">-</div></td>
			<td align=center><div id="headingtextprobold">-</div></td>
			<td align=center><div id="headingtextprobold">-</div></td>
			<td align=center><div id="headingtextprobold">-</div></td></tr>


			<tr><td>
			<div id="headingtextpro"> &nbsp;50 Issues of the <a target="_blank" href="Deal_Digest.htm"><u>Deal Digest</u></a> Weekly newsletter <b></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td></tr>

			<tr><td>
			<div id="headingtextpro"> &nbsp;Deal Digest Daily newsletter published on all working weekdays.</div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td></tr>

			<tr><td>
			<div id="headingtextpro"> &nbsp;Roundup-Annual report summarizing PE investments
			 during the previous year. </div></td>
			 <td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold">-</div></td></tr>

			<tr><td>
			<div id="headingtextpro"> &nbsp;4 <a target="_blank"href="peroundup.htm"> Roundup-Quarterly </a> reports
			summarizing PE investments during the immediate previous quarter. </div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold">-</div></td>
			<td align=center><div id="headingtextprobold">-</div></td></tr>

                        	<tr><td>
			<div id="headingtextpro"> &nbsp;Fund Raising InfoSheet Information on PE/VC fund raising
                        </div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /></div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /> <br />
			Qtly Update
                        </div></td>
			<td align=center><div id="headingtextprobold"><img src="images/tick.JPG" /><br />
                        Annual
                        </div></td>
			<td align=center><div id="headingtextprobold">-</div></td></tr>

			<tr>
			<td align=center>
			<div id="headingtextprobold"> Pricing (in INR per  month) </td>
			<td align=top>
			<div id="headingtextprosmallfont">
			<input type="radio" value="95000" name="VIAmt" onclick="CurrencyValue('ERs')">7,917 * </div>

			</td>
			<td align=top>
			<div id="headingtextprosmallfont">
			<input type="radio" value="80000" name="VIAmt" onclick="CurrencyValue('DRs')">6,667 * </div>

			</td>
			<td align=top>
			<div id="headingtextprosmallfont">
			<input type="radio" value="62000" name="VIAmt" onclick="CurrencyValue('CRs')">5,167 *
			<td align=top>
			<div id="headingtextprosmallfont">
			<input type="radio" value="57000" name="VIAmt" onclick="CurrencyValue('BRs')">4,750
			</div></td>
			<td align=top>
			<div id="headingtextprosmallfont">
		        <input type="radio" value="50000" name="VIAmt" onclick="CurrencyValue('ARs')">4,167</div></td> </tr>


			<tr>
			<td align=center>
			<div id="headingtextprobold">Pricing (in INR per month) Excluding Company Financials Search Database (CFS) </td>
			<td align=top>
			<div id="headingtextprosmallfont">
			<input type="radio" value="80000" name="VIAmt_noCFS" onclick="CurrencyValue_noCFS('ERs')">6,667 * </div>

			</td>
			<td align=top>
			<div id="headingtextprosmallfont">
			<input type="radio" value="60000" name="VIAmt_noCFS" onclick="CurrencyValue_noCFS('DRs')">5,000 * </div>

			</td>
			<td align=top>
			<div id="headingtextprosmallfont">
			<input type="radio" value="32000" name="VIAmt_noCFS" onclick="CurrencyValue_noCFS('CRs')">2,667
			<td align=top>
			<div id="headingtextprosmallfont">
			<input type="radio" value="22000" name="VIAmt_noCFS" onclick="CurrencyValue_noCFS('BRs')">1,834
			</div></td>
			<td align=top>
			<div id="headingtextprosmallfont">
		       <input type="radio" value="10000" name="VIAmt_noCFS" onclick="CurrencyValue_noCFS('ARs')">834</div></td> </tr>


					<tr>

					<td align=center>
					<div id="headingtextprobold"> &nbsp; </td>
					<td align=center>
					<div id="headingtextprobold"> &nbsp; </td>
					<td align=center>
					<div id="headingtextprobold"> &nbsp; </td>
					<td align=top>
					<div id="headingtextprosmallfont">
					<input name="VC_BC" type="checkbox" value="1" onclick="optionforbc()">Send VC &nbsp;instead of PE &nbsp;Report</div></td>

					<td align=top>
					<div id="headingtextprosmallfont">
					<input name="VC_BC_E" type="checkbox" value="1" onclick="optionforseriesE()">Send VC &nbsp;instead of PE &nbsp;Report</div></td>
					<td align=top>
					<div id="headingtextprosmallfont">&nbsp;</div></td>
					</tr>


                      </table>

                      <b>Note: Min. billing is for 12 months</b><br />
                      <sup> ** </sup> Default subscription to CFS includes up to 5,000 downloads of company financials. <br/> <br />

			<!--<div id="headingtextprobold">
			<input type="radio" value="10000" name="REVIAmt" onclick="REaddon('RE-ERs')">10,000
			<input type="radio" value="15000" name="REVIAmt" onclick="REaddon('RE-DRs')">15,000
			<input type="radio" value="20000" name="REVIAmt" onclick="REaddon('RE-ABCRs')">20,000
		</div> -->

		<div id="headingtextprobold">Add-on <a target="_blank" href="relogin.php">PE Real Estate Database</a> *
		<input name="VIREAmt" type="checkbox" value="1" onclick="optionforseriesE()">

		<br /></div>
			<table border=1 width="500" cellpadding=0 cellspacing=0>

			<tr>
			<td align=center width="65" rowspan=2>
			<div id="headingtextprobold">Added Cost</div> </td>
			<td align=center width="65">
			<div id="headingtextprobold">For Series E</div> </td>
			<td align=center width="65">
			<div id="headingtextprobold">For Series D </div></td>
			<td align=center width="65">
			<div id="headingtextprobold">For Series A,B,C</div></td>
			</tr>
			<tr>

			<td align=center width="65">
			<div id="headingtextprobold">
			10,000 per year
			</div> </td>
			<td align=center width="65">
			<div id="headingtextprobold">
			15,000 per year
			</div></td>
			<td align=center width="65">
			<div id="headingtextprobold">
			20,000 per year
			</div></td>
			</table>
			<div id="headingtextprosmallfont">* No extra charges for up to 20 user logins per subscribing entity <br /> <br /></div>
                        	<div id="headingtextprobold"> <a target="_blank" href="vcroundup.htm"> VC Reports </a> (Add On/Alternative Option)<br/> </div>
			Venture Intelligence also provides an expanded coverage of the Venture Capital segment in the form of quarterly
			and annual reports. Series B and Series C Subscribers can choose to receive these reports
			either in lieu of the India Roundup reports or in addition to them.<br /><br />

			<div id="headingtextprobold">Add-on Option (for Series A, B & C subscribers) <br /></div>
			<input name="VC_ABC" type="radio" value="15000" onclick="addon('Quarterly_Annual_Rep')" >
			Send us the Quarterly & Annual VC Reports
			:  Rs.15,000 &nbsp; Extra Per Year<br />
				<!--<div id="headingtextprosmallfont">(Instead of PE Reports)--></div><br />


			<div id="headingtextprobold">Subscription Period: &nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="subYear" value="1" checked> 1 Yr &nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="subYear" value="2" > 2 Yrs (Save 10%) &nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="subYear" value="3" > 3 Yrs (Save 20%)<br /><br />
			 </div>



                        <div id="headingtextprobold"> Service Tax @12.36%. Service Tax Registration No.: AAACF5176DSD001 </div> <br />


			<div id="headingtextprobold"> Payment &nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="Paymode" value="Online" > Online Credit Card &nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="Paymode" value="Check" >  Cheque (Check) &nbsp;&nbsp;&nbsp;&nbsp;
			<!--<input type="radio" name="Paymode" value="WireTransfer" >  Wire Transfer --><br /> <br />
			 </div>

		<!--	<div id="headingtextprobold">Refund Policy <br /></div>
			You can cancel your subscription at any time, and get a full refund on all unmailed issues
			of the newsletter. So, you can subscribe in complete confidence. <br /><br /> -->


			<div id="headingtextprobold">Contact Details <br /><br /></div>


			<div id="headingtextprobold">Full Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="images/arrow.gif" />
			<input name="Fullname" onkeypress=keycheck('Fullname') size=39>  <br /><br /> </div>

			<div id="headingtextprobold">Position &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="images/arrow.gif" />
			<input name="Position" size=39>  <br /><br /> </div>

			<div id="headingtextprobold">Firm Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="images/arrow.gif" />
			<input name="FirmName" size=39>  <br /><br /></div>

			<div id="headingtextprobold">Address Line 1 &nbsp;
			<img src="images/arrow.gif" />
			<input name="Address1"size=39> <br /><br /></div>

			<div id="headingtextprobold"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="images/arrow.gif" />
			<input name="Address2" size=39><br /><br /></div>

			<div id="headingtextprobold">City &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="images/arrow.gif" />
			<input name="City" size=39> <br /><br /> </div>

			<div id="headingtextprobold">State &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;
			<img src="images/arrow.gif" />
			<input name="State" size=39> <br /><br /> </div>

			<?php
				$csql= "select countryid,country from country";
				$crs=mysql_query($csql);
				//filling country
				if (!$crs) {
					echo 'Error has occured in the connectivity: ' . mysql_error();
					exit;
				 }
				 else    {
					$crow_cnt = mysql_num_rows($crs);//  $rs->num_rows;
				  }
				 ?>
				 <div id="headingtextprobold">Country &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 <img src="images/arrow.gif" />
				 <SELECT name="Country">
				  <?php
				   if ($crow_cnt > 0)
				   {
					while ($crow = mysql_fetch_array($crs))
					{
						$id = $crow["countryid"];
						$name = $crow["country"];
						echo " <OPTION id=". $crow["countryid"]."  value=". $crow["countryid"]." >".$name."  </OPTION>  \n";
					}
					mysql_free_result($crs);
				   }
   		?>		</SELECT><br /><br /></div>



			<div id="headingtextprobold">Postal Code &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="images/arrow.gif" />
			<input name="Postal" onkeypress=keycheck('Postal') size=39> <br /><br /></div>

			<div id="headingtextprobold">Telephone &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="images/arrow.gif" />
			<input name="Telephone" onkeypress=keycheck('Telephone') size=39> <br /> <br /></div>

			<div id="headingtextprobold">Fax &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="images/arrow.gif" />
			<input name="Fax" size=39> <br /><br /></div>

			<div id="headingtextprobold">Website &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;
			<img src="images/arrow.gif" />
			<input name="Website" size=39> <br /><br /></div>

			<div id="headingtextprobold">Your Email *
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<img src="images/arrow.gif" />
			 <input name="YourMail" size=39><br /></div>
			 <div id="headingtextprosmallfont">
			 (* In the case of individual subscribers, the newsletter issues will be mailed to this Email ID) <br /> <br />
			 </div>

			<div id="headingtextprobold">How did you learn about us ? &nbsp;
			<img src="images/arrow.gif" />
			<input name="learntthrough" size=39> <br /><br /></div>


			Please specify the Email IDs of the members of your firm to be included in the Venture Intelligence
			mailing list in the table below. (You can make changes to the list anytime by sending us an email.) <br /><br />

			<div id="headingtextprobold"> Please Note:<br/> </div>
			1. All the members from your organization to be included in our mailing list must have the
			same email domain name  i.e., @company.com.<br/> <br />
			2. Rights to the Venture Intelligence service are limited to each legal entity (i.e., company/organization)
			that purchases a subscription. They cannot be extended to affiliates (like subsidiaries, parent companies,
			group companies, investors, portfolio companies and partner organizations).
			<br/><br/><div id="headingtextprobold">  List Of Members &nbsp;&nbsp;&nbsp; ( Name | Email ) <br /></div>


			<?php
			$attendee=10;
			for ( $i=0; $i<$attendee; $i++)
			{
					echo "<div id=\"eventholder2\">";
					echo "<div class=\"eventcolor2\">
					<input type=text name=\"Names\" value=\"\" size=\"21\" >
					</div>" ;
					echo " <div style=\"float:left\"><img src=\"images/dotvert.gif\" /></div> ";
					echo "<div class=\"topic2\">
					<input type=text name=\"Mails\" value=\"\"  size=\"25\">
					</div>" ;
					echo "</div>";
				}
			include "dbclose.php";

			?>
			<br />



                        * All Database Packages by Default includes 20 user licenses per subscribing entity.
			<div id="headingtextprobold"> <p> * Options for Series D & E subscribers </p></div>
			<div id="headingtextprosmallfont">1-20 user logins
			<input type="radio" value="0" name="LoginVIAmt" onclick="loginshow('1-20 logins')"> No Extra Charge &nbsp;</div>
			<div id="headingtextprosmallfont">Additional user logins (for total of 21-50 users)
			<input type="radio" value="10000" name="LoginVIAmt" onclick="loginshow('21-50 logins')">Rs. 10,000 &nbsp; Extra &nbsp;</div>
			<div id="headingtextprosmallfont">Additional user  logins (for total of 51-100 users)
			<input type="radio" value="25000" name="LoginVIAmt" onclick="loginshow('51-100 logins')" >Rs. 25,000  &nbsp; Extra &nbsp; </div> <br />


		 <div id="headingtextprobold">Refund Policy: <br /></div>
			In case you are not satisfied with our publications (i.e., the newsletters and reports),
			you can cancel your subscription any time and receive a refund on the unmailed newsletters and
			reports. <br />

			Note: Refund requests for packages including a database have to be exercised within 7 days of purchase.
			Refunds on the database portion of the subscription are not possible once the subscriber chooses to download data from the database as a spreadsheet.
			Discounts for multi-year subscriptions will be adjusted before a refund is made.<br /><br />
			
                        <img id="captcha" src="../securimage/securimage_show.php" alt="CAPTCHA Image" />
                        <input type="text" name="captcha_code" size="10" maxlength="6" />
                       <a href="#" onclick="document.getElementById('captcha').src = '../securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a> 



			<input name="chkTerm" type="checkbox" >
		       We have read and agreed to the <a href="terms.htm" target="_blank">Terms & Conditions</a>  <br />
		       




			<br /><input name="submit" type="submit" value="Submit"> <br />
          </div>  <!-- End if headingtextpro -->

        </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
  <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom.js"></SCRIPT>
  </form>

     <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
   </script>
</body>
</html>
