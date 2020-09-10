function call()
{
var myArray;
var a=window.location;
str=new String(a);
myArray = str.split("/");

//taking checking for the first 2 characters in the split word [eg.07media9.htm is the split word,07 is checked ]
splitword=(myArray[3]);
//alert(splitword.substr(2,5));
//takes 5 characters from the 08media17.htm for eg.. if its media give a common header bar
if(splitword.substr(2,5)=="media")
{
    //<a href="aboutus.htm" class="topnav">&nbsp;</a>
document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
}

//if starts with league*.htm give a common header
splitwordforleague=(myArray[3]);
if(splitwordforleague.substr(0,6)=="league")
{
// document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
}

//for giving hyperlink to the trialrequest.php in the pelogin.php,malogin.php,relogin.php
//alert(splitwordforlink.substr(0,12));
splitwordforlink=(myArray[3]);
if(splitwordforlink.substr(0,12)=="trialrequest")
{

//document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
}
//alert(str);
if((str=="https://www.ventureintelligence.com/") )
{
// document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover">Home</span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
}

              var index = str.lastIndexOf("index.htm");
              var str1 = str.substring(index);
              if(str1 == "index.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover">Home</span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var index = str.lastIndexOf("products.htm");
              var str1 = str.substring(index) ;
              
              if(str1 == "products.htm")
              {
               // alert('sssss');
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("directories.htm");
              var str1 = str.substring(index);
              if(str1 == "directories.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("pedirectory.htm");
              var str1 = str.substring(index);
              if(str1 == "pedirectory.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("pedirectory.php");
              var str1 = str.substring(index);
              if(str1 == "pedirectory.php")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
                  var index = str.lastIndexOf("pedirectorysubmit.php");
              var str1 = str.substring(index);
              if(str1 == "peredirectorysubmit.php")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("peredirectory.htm");
              var str1 = str.substring(index);
              if(str1 == "peredirectory.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("peredirectory.php");
              var str1 = str.substring(index);
              if(str1 == "peredirectory.php")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
                  var index = str.lastIndexOf("peredirectorysubmit.php");
              var str1 = str.substring(index);
              if(str1 == "peredirectorysubmit.php")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }

              var index = str.lastIndexOf("vcdirectory.htm");
              var str1 = str.substring(index);
              if(str1 == "vcdirectory.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
                var index = str.lastIndexOf("peroundup.htm");
              var str1 = str.substring(index);
              if(str1 == "peroundup.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
                 var index = str.lastIndexOf("peimpact.htm");
              var str1 = str.substring(index);
              if(str1 == "peimpact.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("peimpactsubmit.php");
              var str1 = str.substring(index);
              if(str1 == "peimpactsubmit.php")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("India-Annual-2007.htm");
              var str1 = str.substring(index);
              if(str1 == "India-Annual-2007.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("terms.htm");
              var str1 = str.substring(index);
              if(str1 == "terms.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              
              var index = str.lastIndexOf("analysis.htm");
              var str1 = str.substring(index);
              if(str1 == "analysis.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("analysis_info.htm");
              var str1 = str.substring(index);
              if(str1 == "analysis_info.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("analysis_info.php");
              var str1 = str.substring(index);
              if(str1 == "analysis_info.php")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("sector.htm");
              var str1 = str.substring(index);
              if(str1 == "sector.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("db.htm");
              var str1 = str.substring(index);
              if(str1 == "db.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("aboutus.htm");
              var str1 = str.substring(index);
              if(str1 == "aboutus.htm")
              {
             // document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover">About Us<a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("customer.htm");
              var str1 = str.substring(index);
              if(str1 == "customer.htm")
              {
             // document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="news.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="news.htm">News&nbsp;</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover">About Us<a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("rereports.htm");
              var str1 = str.substring(index);
              if(str1 == "rereports.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("news.htm");
              var str1 = str.substring(index);
              if(str1 == "news.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("thankyou.php");
              var str1 = str.substring(index);
              if(str1 == "thankyou.php")
              {
             //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover">Contact Us</span></div></div>');
              }
              var index = str.lastIndexOf("thankyous.php");
              var str1 = str.substring(index);
              if(str1 == "thankyous.php")
              {
             document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover">Contact Us</span></div></div>');
              }
              var index = str.lastIndexOf("thankyounoadd.php");
              var str1 = str.substring(index);
              if(str1 == "thankyounoadd.php")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover">Contact Us</span></div></div>');
              }
              var index = str.lastIndexOf("contactus.htm");
              var str1 = str.substring(index);
              if(str1 == "contactus.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover">Contact Us</span></div></div>');
              }
              var index = str.lastIndexOf("events.htm");
              var str1 = str.substring(index);
              if(str1 == "events.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products</a><a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover">Events</span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("eventsmore.htm");
              var str1 = str.substring(index);
              if(str1 == "eventsmore.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products</a><a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover">Events</span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("investors.htm");
              var str1 = str.substring(index);
              if(str1 == "investors.htm")
              {
               //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              
              var index = str.lastIndexOf("entrepreneurs.htm");
              var str1 = str.substring(index);
              if(str1 == "entrepreneurs.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var index = str.lastIndexOf("serviceproviders.htm");
              var str1 = str.substring(index);
              if(str1 == "serviceproviders.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var index = str.lastIndexOf("sponsor.htm");
              var str1 = str.substring(index);
              if(str1 == "sponsor.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var index = str.lastIndexOf("advertisesubmit.php");
              var str1 = str.substring(index);
              if(str1 == "advertisesubmit.php");
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var index = str.lastIndexOf("advertise.htm");
              var str1 = str.substring(index);
              if(str1 == "advertise.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var index = str.lastIndexOf("advertise.php");
              var str1 = str.substring(index);
              if(str1 == "advertise.php")
              {
             // document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var index = str.lastIndexOf("subscribe.htm");
              var str1 = str.substring(index);
              if(str1 == "subscribe.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var index = str.lastIndexOf("privacy.htm");
              var str1 = str.substring(index);
              if(str1 == "privacy.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="products.htm">Products</a><a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><a href="events.htm" class="topnav">Events</a><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("legal.htm");
              var str1 = str.substring(index);
              if(str1 == "legal.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="products.htm">Products</a><a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><a href="events.htm" class="topnav">Events</a><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("testimonial.htm");
              var str1 = str.substring(index);
              if(str1 == "testimonial.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="products.htm">Products</a><a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><a href="events.htm" class="topnav">Events</a><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("sponsors.htm");
              var str1 = str.substring(index);
              if(str1 == "sponsors.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="products.htm">Products</a><a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><a href="events.htm" class="topnav">Events</a><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("pressrelease1.htm");
              var str1 = str.substring(index);
              if(str1 == "pressrelease1.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("pressrelease2.htm");
              var str1 = str.substring(index);
              if(str1 == "pressrelease2.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              
              
              var index = str.lastIndexOf("India-VC-Report-2006.htm");
              var str1 = str.substring(index);
              if(str1 == "India-VC-Report-2006.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              
              var index = str.lastIndexOf("PR_India-US_July-Sep-05.htm");
              var str1 = str.substring(index);
              if(str1 == "PR_India-US_July-Sep-05.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              
              var index = str.lastIndexOf("PR_India_July-Sep-05.htm");
              var str1 = str.substring(index);
              if(str1 == "PR_India_July-Sep-05.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              
              var index = str.lastIndexOf("PR_India-exits-2005.htm");
              var str1 = str.substring(index);
              if(str1 == "PR_India-exits-2005.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("PR_India-2005.htm");
              var str1 = str.substring(index);
              if(str1 == "PR_India-2005.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("IPR_PR1.htm");
              var str1 = str.substring(index);
              if(str1 == "IPR_PR1.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("PR_India-US_Apr-Jun-06.htm");
              var str1 = str.substring(index);
              if(str1 == "PR_India-US_Apr-Jun-06.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("PR_India-US_Jan-Mar-06.htm");
              var str1 = str.substring(index);
              if(str1 == "PR_India-US_Jan-Mar-06.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("PR_US-2005.htm");
              var str1 = str.substring(index);
              if(str1 == "PR_US-2005.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("PR_Investments_2006.htm");
              var str1 = str.substring(index);
              if(str1 == "PR_Investments_2006.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              
              var index = str.lastIndexOf("presscoverage.htm");
              var str1 = str.substring(index);
              if(str1 == "presscoverage.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              
              var index = str.lastIndexOf("register.php");
              var str1 = str.substring(index);
              if(str1 == "register.php")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products</a><a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover">Events</span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("newsletters.htm");
              var str1 = str.substring(index);
              if(str1 == "newsletters.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("investments.php");
              var str1 = str.substring(index);
              if(str1 == "investments.php")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var index = str.lastIndexOf("vcinvestmentsupdate.php");
              var str1 = str.substring(index);
              if(str1 == "vcinvestmentsupdate.php")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              
              var index = str.lastIndexOf("peauthenticate.php");
              var str1 = str.substring(index);
              if(str1 == "peauthenticate.php")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var index = str.lastIndexOf("admin.php");
              var str1 = str.substring(index);
              if(str1 == "admin.php")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var index = str.lastIndexOf("faq-re.htm");
              var str1 = str.substring(index);
              if(str1 == "faq-re.htm")
              
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var index = str.lastIndexOf("faq-pe.htm");
              var str1 = str.substring(index);
              if(str1 == "faq-pe.htm")
              
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var index = str.lastIndexOf("faq-ma.htm");
              var str1 = str.substring(index);
              if(str1 == "faq-ma.htm")
              
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var index = str.lastIndexOf("db-pe.htm");
              var str1 = str.substring(index);
              if(str1 == "db-pe.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("db-vc.htm");
              var str1 = str.substring(index);
              if(str1 == "db-vc.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("db-ma.htm");
              var str1 = str.substring(index);
              if(str1 == "db-ma.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("db-re.htm");
              var str1 = str.substring(index);
              if(str1 == "db-re.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              
              var index = str.lastIndexOf("pelogin.php");
              var str1 = str.substring(index);
              if(str1 == "pelogin.php")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var index = str.lastIndexOf("malogin.php");
              var str1 = str.substring(index);
              if(str1 == "malogin.php")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var index = str.lastIndexOf("relogin.php");
              var str1 = str.substring(index);
              if(str1 == "relogin.php")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var index = str.lastIndexOf("reloginip.php");
              var str1 = str.substring(index);
              if(str1 == "reloginip.php")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              
              var index = str.lastIndexOf("peloginip.php");
              var str1 = str.substring(index) ;
              if(str1 == "peloginip.php")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var index = str.lastIndexOf("maloginip.php");
              var str1 = str.substring(index);
              if(str1 == "maloginip.php")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var str1 = str.substring(34,47);
              //alert(str1);
              //var index = str.lastIndexOf("forgotpwd.php");
              //var str1 = str.substring(index)
              if(str1 == "forgotpwd.php")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var index = str.lastIndexOf("forgotpwdsubmit.php");
              var str1 = str.substring(index);
              if(str1 == "forgotpwdsubmit.php")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              
              var index = str.lastIndexOf("changepassword.php");
              var str1 = str.substring(index);
              if(str1 == "changepassword.php")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              var index = str.lastIndexOf("updatepwd.php");
              var str1 = str.substring(index);
              if(str1 == "updatepwd.php")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover"><a href="products.htm">Products&nbsp;</a></span><a href="products.htm">&nbsp;</a><a href="#" class="topnav">&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="aboutus.htm">About Us</a><a href="contactus.htm" class="topnav">&nbsp;</a></span><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class="linkhover"><a href="contactus.htm">Contact Us</a></span></div></div>');
              }
              
              var index = str.lastIndexOf("dd-subscribe.php");
              var str1 = str.substring(index);
              if(str1 == "dd-subscribe.php")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              
              var index = str.lastIndexOf("dd-subscribe_E.php");
              var str1 = str.substring(index);
              if(str1 == "dd-subscribe_E.php")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("vcmarket.htm");
              var str1 = str.substring(index);
              if(str1 == "vcmarket.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("vcroundup.htm");
              var str1 = str.substring(index);
              if(str1 == "vcroundup.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("showcase1.htm");
              var str1 = str.substring(index);
              if(str1 == "showcase1.htm")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("ipsubmit.php");
              var str1 = str.substring(index);
              if(str1 == "ipsubmit.php")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("vcmarket.php");
              var str1 = str.substring(index);
              if(str1 == "vcmarket.php")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("vcmarketsubmit.php");
              var str1 = str.substring(index);
              if(str1 == "vcmarketsubmit.php")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              
              var index = str.lastIndexOf("ipsubmission.php");
              var str1 = str.substring(index);
              if(str1 == "ipsubmission.php")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("vcannualreports.php");
              var str1 = str.substring(index);
              if(str1 == "vcannualreports.php")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("vcdirectory.php");
              var str1 = str.substring(index);
              if(str1 == "vcdirectory.php")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              
              var index = str.lastIndexOf("vcannualreportssubmit.php");
              var str1 = str.substring(index);
              if(str1 == "vcannualreportssubmit.php")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("roundup-subscribe.php");
              var str1 = str.substring(index);
              if(str1 == "roundup-subscribe.php")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("subscribe-dds.php");
              var str1 = str.substring(index);
              if(str1 == "subscribe-dds.php")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("vcreport-subscribe.php");
              var str1 = str.substring(index);
              if(str1 == "vcreport-subscribe.php")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("annual_reports.php");
              var str1 = str.substring(index);
              if(str1 == "annual_reports.php")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("onSubmit.php");
              var str1 = str.substring(index);
              if(str1 == "onSubmit.php")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("ibdirectory.htm");
              var str1 = str.substring(index);
              if(str1 == "ibdirectory.htm")
              {
              //document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("ibdirectorysubmit.php");
              var str1 = str.substring(index);
              if(str1 == "ibdirectorysubmit.php")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }
              var index = str.lastIndexOf("ibdirectory_submit.php");
              var str1 = str.substring(index);
              if(str1 == "ibdirectory_submit.php")
              {
              document.write('<div id="toplinksmain1"><div id="topnav"><span class="linkhover"><a href="index.htm">Home</a></span><a href="index.htm">&nbsp;</a>&nbsp;&nbsp;&nbsp; <a href="products.htm" class="topnav"><img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><sp><span class="linkhover">Products<a href="#" class="topnav">&nbsp;</a></span><a href="#" class="topnav">&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; </a><span class=" linkhover"><a href="events.htm">Events</a></span><a href="aboutus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; About Us</a><a href="contactus.htm" class="topnav">&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/topdot.gif" width="3" height="12" border="0" />&nbsp;&nbsp;&nbsp;&nbsp; Contact Us</a></div></div>');
              }

}