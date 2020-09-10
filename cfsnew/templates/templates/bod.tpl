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
                        $(document).foundation();
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

{literal}
<script type="text/javascript" language="javascript1.2">

function passwordcheck(){
    var Password = $('#Password').val();
    var Password1 = $('#Password1').val();
    if(Password!=Password1){
           alert("Password not match");
    }
}

function validate(){
    var Password = $('#Password').val();
    var Password1 = $('#Password1').val();
    if(Password=='' || Password1==''){
           alert("Please enter password");
           return false;
    }
    return true;
}
</script>
{/literal}

{include file="leftpanel.tpl"}
</form>
<form name="Frm_HmeSearch" id="Frm_HmeSearch" action="changepassword.php" method="post" onsubmit='return validate();'>
<div class="container-right">
    <div class="companies-details">
<div class="detailed-title-links"> <h2>{$nod}</h2>   <a class="back" href="details.php?vcid={$VCID}">BACK</a> </div>


<div class="filing-cnt">

 

 

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tHead> <tr> 
    <th>Company Name </th>
    <th> Date of Appointment</th>
    <th>Date of Cessation  </th> 
</tr></thead>
<tbody> 
 {section name=dirname loop=$dir}
      <tr><td style="alt"><!--a href='details.php?vcid={$dir[dirname].Company_Id}' -->{$dir[dirname][6]}</td> <td>{$dir[dirname][9]}</td><td>{$dir[dirname][10]}</td></tr>
 {sectionelse}
  <tr><td colspan="5">No Companies Found</td></tr>
{/section}
</tbody>
  </table>
  
 
 </div>
 
  
  
  
</div>
</div>
<!-- End of Container -->
</form>


</body>
</html>