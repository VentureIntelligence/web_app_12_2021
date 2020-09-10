<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<SCRIPT LANGUAGE="JavaScript">

function checkFields()
{

	missinginfo = "";

	if (document.jurylogin.companyloginemail.value == "") {

	missinginfo += "\n     -  Email";
	}

	if (document.jurylogin.companyloginpassword.value == "") {

	missinginfo += "\n     -  Password";

	}


	if (missinginfo != "")
	{

		missinginfo ="\n" +

		"Following fields are mandatory:\n" +

		missinginfo + "\n" +

		"\nPlease re-enter and submit again!";

		alert(missinginfo);

		return false;
	}
	else
	{
		 return true;
	}


}

</SCRIPT>

<link href="style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>

<body>
<form name="jurylogin" onSubmit="return checkFields();" method="post"  action="juryvotes.php">

<div id="containerproductjurylogin">

<!-- Starting Left Panel -->
  <div id="leftpanel">
    <div><a href="index.htm"><img src="images/logo.jpg" width="183" height="98" border="0"></a></div>

    <div id="vertbgprojurylogin">

      <div id="vertMenu">
        <div><img src="images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;<a href="products.htm">Products</a></span></div>
      </div>
      <div id="eventslinkabt1">
        <div><img src="images/dot1.gif" />&nbsp;&nbsp;<span class="linkhover">Events</span></div>
      </div>
      <div id="linksnone"><a href="events.htm">Upcoming Events</a><br />
          <span id="visitlink"><a href="pastevents.htm">Past Events</a><br />
        </span> </div>
      <div id="eventslinkbotom">
        <div></div>
      </div>

	<div id="eventslinkabt1">
			          <div><img src="images/dot1.gif" />&nbsp;&nbsp;<a href="news.htm">News</a></div>
	      </div>

    </div>
  </div>
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="js/top.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>

	<div style="width:565px; float:left; padding-left:2px;">
	  <div style="width:565px; margin-top:8px;"><img src="images/event-top.jpg" width="566" height="121"></div>
	  <div style="background-color:#FFF; width:565px; height:250px; margin-top:5px;"><div id="navpro">
        <div class="links">
          <!--<ul>
            <li><img src="images/arrow.gif" /> <a href="subscribe.htm">Subscribe</a> </li>
            <li><img src="images/arrow.gif" /> <a href="advertise.htm">Advertise </a> </li>
            <li><img src="images/arrow.gif" /> <a href="sponsor.htm">Sponsor</a></li>
          </ul>-->
        </div>
	  </div>
	    <div id="maintextpro">
          <div id="headingtextpro">

          <div id="headingtextprobold">  Venture Intelligence Awards for Private Equity Excellence (APEX) <br /> <br /></div>

          <div id="headingtextprobold"> Login for Jury Members <br /> <br /> <br /></div>

		 			<div id="headingtextprobold">Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  			<img src="images/arrow.gif" />
		  			<input name="companyloginemail" size=39>  <br /> <br /></div>
		  			<div id="headingtextprobold">Password &nbsp;&nbsp;
		  			<img src="images/arrow.gif" />
		  			<input type="password" name="companyloginpassword" size=39>  <br /> <br /></div>

					<div style="float:center ">
		  			<input name="submit" type="submit" value="Login"> </div>


          </div> <!-- End of headingtextpro -->


        </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="js/bottom.js"></SCRIPT>
   </form>

   <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
  </script>
</body>
</html>
