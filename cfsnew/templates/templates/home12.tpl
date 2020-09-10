{include file="header.tpl"}

{literal}
<script type="text/javascript" language="javascript1.2">


	function suggest(inputString){
			$('#submitbtn').hide();
			$('#viewfinance').hide();
			if(inputString.length == 0) {
				$('#suggestions').fadeOut();
			} else {
			$('#country').addClass('load');
				$.post("autosuggest.php", {queryString: ""+inputString+""}, function(data){
					if(data.length >0) {
						$('#suggestions').fadeIn();
						$('#suggestionsList').html(data);
						$('#country').removeClass('load');
					}
				});
			}
	}
	function suggestsectors(str)
	{
		var xmlhttp;
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
			document.getElementById("sectordisplay").innerHTML=xmlhttp.responseText;
			//alert(xmlhttp.responseText);
			}
		  }
		xmlhttp.open("GET","autosector.php?queryString1="+str,true);
		xmlhttp.send();
	}

	
	/*function fill(thisValue) {
		$('#country').val(thisValue);
		setTimeout("$('#suggestions').fadeOut();", 300);
	}*/
        function fill(thisValue) {
		$('#country').val(thisValue);
		setTimeout(function(){
                   $('#suggestions').fadeOut(); 
                   $('#suggestionsList').html("");	
                }, 400);
               
	}
	function fillHidden(thisid) {
		$('#cid').val(thisid);
		$('#submitbtn').show();
		$('.suggestionsBox').hide();
                $('#country').addClass('load');
                $('#viewfinance').html('<a href="viewannual.php?vcid='+thisid+'" target="_blank"><img src="images/cfs/vfinancial.jpg" style="width:87px; height:25px;" /></a>');
		$('#viewfinance').show();
		setTimeout(function(){
                   $('#suggestions').fadeOut();
                    $('#suggestionsList').html("");	
                }, 400);
               
}
</script>
{/literal}

{include file="leftpanel.tpl"}

<div class="container-right">

<h1><span>128</span> Companies found</h1>

<div class="filter-selected">
<ul>
<li> <span>Unlisted</span> <a href="javascript:;"><img src="images/close-selected.gif" width="14" height="14" alt="" /></a></li>

<li class="result-select-close"><a href="#">
                                             <img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
</ul>
</div>

<div class="list-tab">
<ul>
<li><a href="javascript:;" class="active"><i></i> LIST VIEW</a></li>
<li><a href="javascript:;"><i></i> DETAIL VIEW</a></li>
</ul>
</div>

<div class="companies-list">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tHead> <tr>
    <th>Company Name</th>
<th> Revenue</th>
<th> EBITDA</th>
<th> PAT</th>
<th> Detailed</th>
<th> Filings	</th></tr></thead>
<tbody>  <tr><td class="name-list"> <span class="list-tip">UL</span>   M K Shipping And   Allied Industries</td>
    <td>3.56</td>
    <td>3.56</td>
    <td>3.56</td> <td><a href="javascript:;">FY13</a></td> <td><a href="javascript:;">View</a></td>
  </tr>
   <tr><td class="name-list"> <span class="list-tip">UL</span> New Mount Trading &amp; Investment   Co </td>
    <td>19.23</td>
    <td>19.23</td>
    <td>19.23</td> <td><a href="javascript:;">FY13</a></td> <td><a href="javascript:;">View</a></td>
  </tr>
   <tr><td class="name-list"> <span class="list-tip">UL</span> Raghuvanshi Cotton Ginning And   Pressing </td>
    <td>34.1</td>
    <td>34.1</td>
    <td>34.1</td> <td><a href="javascript:;">FY13</a></td> <td><a href="javascript:;">View</a></td>
  </tr>
   <tr><td class="name-list"> <span class="list-tip">UL</span> Attano Media And Education </td>
    <td>13.3</td>
    <td>13.3</td>
    <td>13.3</td> <td><a href="javascript:;">FY13</a></td> <td><a href="javascript:;">View</a></td>
  </tr>
   <tr><td class="name-list"> <span class="list-tip">UL</span> Digi Raigadh Network </td>
    <td>65.62</td>
    <td>65.62</td>
    <td>65.62</td> <td><a href="javascript:;">FY13</a></td> <td><a href="javascript:;">View</a></td>
  </tr>
   <tr><td class="name-list"> <span class="list-tip">UL</span> Kotak Power </td>
    <td>232.23</td>
    <td>232.23</td>
    <td>232.23</td> <td><a href="javascript:;">FY13</a></td> <td><a href="javascript:;">View</a></td>
  </tr>
   <tr><td class="name-list"> <span class="list-tip">UL</span> Lucky Star Jewellery Exports </td>
    <td>1355.43</td>
    <td>1355.43</td>
    <td>1355.43</td> <td><a href="javascript:;">FY13</a></td> <td><a href="javascript:;">View</a></td>
  </tr>
   <tr><td class="name-list"> <span class="list-tip">UL</span> M. Sons Gems N Jewellery </td>
    <td>2143.4</td>
    <td>2143.4</td>
    <td>2143.4</td> <td><a href="javascript:;">FY13</a></td> <td><a href="javascript:;">View</a></td>
  </tr>
   <tr><td class="name-list"> <span class="list-tip">UL</span> Mape Admisi Commodities </td>
    <td>234.56</td>
    <td>234.56</td>
    <td>234.56</td> <td><a href="javascript:;">FY13</a></td> <td><a href="javascript:;">View</a></td>
  </tr>
   <tr><td class="name-list"> <span class="list-tip">UL</span> Mape Finserve</td>
    <td>566.75</td>
    <td>566.75</td>
    <td>566.75</td> <td><a href="javascript:;">FY13</a></td> <td><a href="javascript:;">View</a></td>
  </tr>
   <tr><td class="name-list"> <span class="list-tip">UL</span> Lucky Star Jewellery Exports </td>
    <td>566.75</td>
    <td>234.56</td>
    <td>2143.4</td> <td><a href="javascript:;">FY13</a></td> <td><a href="javascript:;">View</a></td>
  </tr>
   <tr><td class="name-list"> <span class="list-tip">UL</span> M. Sons Gems N Jewellery  </td>
    <td>1355.43</td>
    <td>525.43</td>
    <td>525.43</td> <td><a href="javascript:;">FY13</a></td> <td><a href="javascript:;">View</a></td>
  </tr>
   <tr><td class="name-list"> <span class="list-tip">UL</span> Raghuvanshi Cotton Ginning And   Pressing </td>
    <td>34.1</td>
    <td>34.1</td>
    <td>34.1</td> <td><a href="javascript:;">FY13</a></td> <td><a href="javascript:;">View</a></td>
  </tr>
   <tr><td class="name-list"> <span class="list-tip">L</span> Attano Media And Education </td>
    <td>13.3</td>
    <td>13.3</td>
    <td>13.3</td> <td><a href="javascript:;">FY13</a></td> <td><a href="javascript:;">View</a></td>
  </tr>
   <tr><td class="name-list"> <span class="list-tip">PA</span> Digi Raigadh Network </td>
    <td>65.62</td>
    <td>65.62</td>
    <td>65.62</td> <td><a href="javascript:;">FY13</a></td> <td><a href="javascript:;">View</a></td>
  </tr>
   <tr><td class="name-list"> <span class="list-tip">PA</span> Kotak Power </td>
    <td>232.23</td>
    <td>232.23</td>
    <td>232.23</td> <td><a href="javascript:;">FY13</a></td> <td><a href="javascript:;">View</a></td>
  </tr>
  </tbody>
  </table>
</div>

</div>
<!-- End of container-right -->

</div>
<!-- End of Container -->
</form>
{literal}
<script type="text/javascript">


  
$(".acc_container").hide();
  $(".firstdiv").show();
$("h2").click(function () {
    $(this).next(".acc_container").slideToggle("fast");
    var text = $(this).find('span').text();
    $(this).find('span').text(text == " [-] " ? " [+] " : " [-] ");
});

$(document).ready( function(){
    $(".cb-enable").click(function(){
        var parent = $(this).parents('.switch-and-or');
        $('.cb-disable',parent).removeClass('selected');
        $(this).addClass('selected');
        $('.checkbox',parent).attr('checked', true);
    });
    $(".cb-disable").click(function(){
        var parent = $(this).parents('.switch-and-or');
        $('.cb-enable',parent).removeClass('selected');
        $(this).addClass('selected');
        $('.checkbox',parent).attr('checked', false);
    });
});

</script>

 <script src="http://foundation.zurb.com/docs/assets/docs.js"></script>
    <script>
      $(document)
      
        .foundation();
      
  
    </script>
{/literal}
</body>
</html>