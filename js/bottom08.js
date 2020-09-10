var a=window.location;
var myArray;
var splitword;
str=new String(a)
//alert(str);
//split similar to explode in php
myArray = str.split("/");
//taking checking for the first 2 characters in the split word [eg.07media9.htm is the split word,07 is checked ]
splitword=(myArray[3].slice(0,2));

pageNoCheck = myArray[3];
//eg. 09media4.htm is the myArray[3]; spilt the .htm outsidem, then leave out first 7 characters of the string,
// thereby getting the page no integer
split_PageNoCheck = pageNoCheck.split(".");

splitwordInteger=(split_PageNoCheck[0].slice(7));
//alert(splitwordInteger);

//alert(splitword);
if(splitword==09)
{
	if(splitwordInteger==1)
		{document.write('<div class="rightboxtxtmore1"><a href="09media10.htm">&nbsp;10 &nbsp;</a><a href="09media9.htm">&nbsp;9 &nbsp;</a><a href="09media8.htm">&nbsp;8 &nbsp;</a><a href="09media7.htm">&nbsp;7 &nbsp;</a><a href="09media6.htm">&nbsp;6 &nbsp;</a><a href="09media5.htm">&nbsp;5 &nbsp; </a><a href="09media4.htm" >&nbsp;4 &nbsp;</a><a href="09media3.htm" >&nbsp;3 &nbsp;</a><a href="09media2.htm">&nbsp;2 &nbsp;</a>	&nbsp;1 &nbsp; </div>');}
	if(splitwordInteger==2)
		{document.write('<div class="rightboxtxtmore1"><a href="09media10.htm">&nbsp;10 &nbsp;</a><a href="09media9.htm">&nbsp;9 &nbsp;</a><a href="09media8.htm">&nbsp;8 &nbsp;</a><a href="09media7.htm">&nbsp;7 &nbsp;</a><a href="09media6.htm">&nbsp;6 &nbsp;</a><a href="09media5.htm">&nbsp;5 &nbsp; </a> <a href="09media4.htm" >&nbsp;4 &nbsp;</a><a href="09media3.htm" >&nbsp;3 &nbsp;</a> &nbsp;2 &nbsp; <a href="09media1.htm"> &nbsp;1 &nbsp; </a> </div>');}
	if(splitwordInteger==3)
		{document.write('<div class="rightboxtxtmore1"><a href="09media10.htm">&nbsp;10 &nbsp;</a><a href="09media9.htm">&nbsp;9 &nbsp;</a><a href="09media8.htm">&nbsp;8 &nbsp;</a><a href="09media7.htm">&nbsp;7 &nbsp;</a><a href="09media6.htm">&nbsp;6 &nbsp;</A><a href="09media5.htm">&nbsp;5 &nbsp; </a> <a href="09media4.htm" >&nbsp;4 &nbsp;</a> &nbsp;3 &nbsp; <a href="09media2.htm" >&nbsp;2 &nbsp;</a>  <a href="09media1.htm"> &nbsp;1 &nbsp; </a> </div>');}
	if(splitwordInteger==4)
		{document.write('<div class="rightboxtxtmore1"><a href="09media10.htm">&nbsp;10 &nbsp;</a><a href="09media9.htm">&nbsp;9 &nbsp;</a><a href="09media8.htm">&nbsp;8 &nbsp;</a><a href="09media7.htm">&nbsp;7 &nbsp;</a><a href="09media6.htm">&nbsp;6 &nbsp;</a><a href="09media5.htm">&nbsp;5 &nbsp; </a>  &nbsp;4 &nbsp; <a href="09media3.htm" >&nbsp;3 &nbsp;</a> <a href="09media2.htm" >&nbsp;2 &nbsp;</a>  <a href="09media1.htm"> &nbsp;1 &nbsp; </a> </div>');}
	if(splitwordInteger==5)
		{document.write('<div class="rightboxtxtmore1"><a href="09media10.htm">&nbsp;10 &nbsp;</a><a href="09media9.htm">&nbsp;9 &nbsp;</a><a href="09media8.htm">&nbsp;8 &nbsp;</a><a href="09media7.htm">&nbsp;7 &nbsp;</a><a href="09media6.htm">&nbsp;6 &nbsp;</a> &nbsp;5 &nbsp;<a href="09media4.htm">&nbsp;4 &nbsp; </a><a href="09media3.htm" >&nbsp;3 &nbsp;</a> <a href="09media2.htm" >&nbsp;2 &nbsp;</a>  <a href="09media1.htm"> &nbsp;1 &nbsp; </a> </div>');}
	if(splitwordInteger==6)
		{document.write('<div class="rightboxtxtmore1"><a href="09media10.htm">&nbsp;10 &nbsp;</a><a href="09media9.htm">&nbsp;9 &nbsp;</a><a href="09media8.htm">&nbsp;8 &nbsp;</a><a href="09media7.htm">&nbsp;7 &nbsp;</a> &nbsp;6 &nbsp;<a href="09media5.htm">&nbsp;5 &nbsp;</a> <a href="09media4.htm">&nbsp;4 &nbsp; </a><a href="09media3.htm" >&nbsp;3 &nbsp;</a> <a href="09media2.htm" >&nbsp;2 &nbsp;</a>  <a href="09media1.htm"> &nbsp;1 &nbsp; </a> </div>');}
	if(splitwordInteger==7)
		{document.write('<div class="rightboxtxtmore1"><a href="09media10.htm">&nbsp;10 &nbsp;</a><a href="09media9.htm">&nbsp;9 &nbsp;</a><a href="09media8.htm">&nbsp;8 &nbsp;</a>&nbsp;7 &nbsp;<a href="09media6.htm">&nbsp;6 &nbsp;</a> <a href="09media5.htm">&nbsp;5 &nbsp;</a> <a href="09media4.htm">&nbsp;4 &nbsp; </a><a href="09media3.htm" >&nbsp;3 &nbsp;</a> <a href="09media2.htm" >&nbsp;2 &nbsp;</a>  <a href="09media1.htm"> &nbsp;1 &nbsp; </a> </div>');}
	if(splitwordInteger==8)
		{document.write('<div class="rightboxtxtmore1"><a href="09media10.htm">&nbsp;10 &nbsp;</a><a href="09media9.htm">&nbsp;9 &nbsp;</a>&nbsp;8 &nbsp;<a href="09media7.htm">&nbsp;7 &nbsp;</a> <a href="09media6.htm">&nbsp;6 &nbsp;<a href="09media5.htm">&nbsp;5 &nbsp;</a> <a href="09media4.htm">&nbsp;4 &nbsp; </a><a href="09media3.htm" >&nbsp;3 &nbsp;</a> <a href="09media2.htm" >&nbsp;2 &nbsp;</a>  <a href="09media1.htm"> &nbsp;1 &nbsp; </a> </div>');}
	if(splitwordInteger==9)
		{document.write('<div class="rightboxtxtmore1"><a href="09media10.htm">&nbsp;10 &nbsp;</a>&nbsp;9 &nbsp;<a href="09media8.htm">&nbsp;8 &nbsp;</a><a href="09media7.htm">&nbsp;7 &nbsp;</a> <a href="09media6.htm">&nbsp;6 &nbsp;<a href="09media5.htm">&nbsp;5 &nbsp;</a> <a href="09media4.htm">&nbsp;4 &nbsp; </a><a href="09media3.htm" >&nbsp;3 &nbsp;</a> <a href="09media2.htm" >&nbsp;2 &nbsp;</a>  <a href="09media1.htm"> &nbsp;1 &nbsp; </a> </div>');}
	if(splitwordInteger==10)
		{document.write('<div class="rightboxtxtmore1">&nbsp;10 &nbsp;<a href="09media9.htm">&nbsp;9 &nbsp;</a><a href="09media8.htm">&nbsp;8 &nbsp;</a><a href="09media7.htm">&nbsp;7 &nbsp;</a> <a href="09media6.htm">&nbsp;6 &nbsp;<a href="09media5.htm">&nbsp;5 &nbsp;</a> <a href="09media4.htm">&nbsp;4 &nbsp; </a><a href="09media3.htm" >&nbsp;3 &nbsp;</a> <a href="09media2.htm" >&nbsp;2 &nbsp;</a>  <a href="09media1.htm"> &nbsp;1 &nbsp; </a> </div>');}
		
}	
if(splitword==09)
	{document.write('<br /><br /> <div class="rightboxtxtmoremedia"><a> &nbsp;2009 &nbsp; </a> <a href="08media17.htm"> &nbsp;2008 &nbsp;</a>  <a href="07media14.htm"> &nbsp;2007 &nbsp;</a>    <a href="06media9.htm"> &nbsp;2006 &nbsp; </a> <a href="media12.htm">&nbsp;2005 &nbsp; </a> <a href="media13.htm"> &nbsp;2004 &nbsp;</a> <a href="media14.htm">&nbsp;2003 &nbsp;</a>	</div>');}
if(splitword==08)
	{document.write('<br /> <br /><div class="rightboxtxtmoremedia"><a href="09media1.htm"> &nbsp;2009 &nbsp; </a> <a> &nbsp;2008 &nbsp; </a>  <a href="07media14.htm"> &nbsp;2007 &nbsp;</a>    <a href="06media9.htm"> &nbsp;2006 &nbsp; </a> <a href="media12.htm">&nbsp;2005 &nbsp; </a> <a href="media13.htm"> &nbsp;2004 &nbsp;</a> <a href="media14.htm">&nbsp;2003 &nbsp;</a>	</div>');}
if(splitword==07)
	{document.write('<br /> <br /><div class="rightboxtxtmoremedia"><a href="09media1.htm"> &nbsp;2009 &nbsp; </a> <a href="08media17.htm"> &nbsp;2008 &nbsp;</a>  <a> &nbsp;2007 &nbsp; </a>     <a href="06media9.htm"> &nbsp;2006 &nbsp; </a> <a href="media12.htm">&nbsp;2005 &nbsp; </a> <a href="media13.htm"> &nbsp;2004 &nbsp;</a> <a href="media14.htm">&nbsp;2003 &nbsp;</a>	</div>');}
if(splitword==06)
	{document.write('<br /> <br /><div class="rightboxtxtmoremedia"><a href="09media1.htm"> &nbsp;2009 &nbsp; </a> <a href="08media17.htm"> &nbsp;2008 &nbsp;</a>  <a href="07media14.htm"> &nbsp;2007 &nbsp; </a> <a> &nbsp;2006 &nbsp; </a>    <a href="media12.htm">&nbsp;2005 &nbsp; </a> <a href="media13.htm"> &nbsp;2004 &nbsp;</a> <a href="media14.htm">&nbsp;2003 &nbsp;</a>	</div>');}