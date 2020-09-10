<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>{$pageTitle}</title>
<meta  name="description" content="{$pageDescription}" />
<meta name="keywords" content="{$pageKeyWords}" />
<link href="css/screen.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/doc.css" />
    
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.js"></script>  
<script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
{* <script src="js/jquery.customforms.js"></script>*}


<script type="text/javascript" src="js/ui.dropdownchecklist.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
{literal}
    <script type="text/javascript">
        $(document).ready(function() {
        	$returnS5 = $('#returnS5');
			var ckb=$(".multi-select").dropdownchecklist({emptyText: "Please select ...",
        onItemClick: function(checkbox, selector){
	var justChecked = checkbox.prop("checked");
	var checkCount = (justChecked) ? 1 : -1;
	for( i = 0; i < selector.options.length; i++ ){
		if ( selector.options[i].selected ) checkCount += 1;
	}
      if ( checkCount > 3 ) {
		alert( "Limit is 3" );
		throw "too many";
	}
}
});
 
			//$('select option').removeProp('selected');
			//for jquery < 1.6
			//$('select option').removeAttr('selected');
                        
             $("#addfinance").click(function(){
                  var str="";
                   $('#fintable > tbody').html("");
                    var selectedOptions = $("#financesearchfieds option:selected").length;
                    i=0;
                    $("#financesearchfieds option:selected").each(function() {
                        
                        str+='<tr ><th>'+$( this ).text()+'<input  type="hidden"  name="answer[SearchFieds][]" id="answer[SearchFieds][]" value="'+this.value+'" /></th><td> <input  type="text" name="Grtr_'+i+'" id="Grtr_'+i+'" />  </td><td><input  type="text" name="Less_'+i+'" id="Less_'+i+'" />  </td></tr>';
                       i++;
                        //str += $( this ).text() + " ";
                    });
                     $('#fintable > tbody:last').append(str);
               //  var countOfSelected = selectedOptions.size();
                
                 
             });
             $("#addgrowth").click(function(){
                  var str="";
                   $('#growth-table > tbody').html("");
                    var selectedOptions = $("#growthsearchfieds option:selected").length;
                    i=0;
                    $("#growthsearchfieds option:selected").each(function() {
                        
                        str+='<tr ><th>'+$( this ).text()+'<input  type="hidden"  name="answer[GrowthSearchFieds][]" id="answer[GrowthSearchFieds][]" value="'+this.value+'" /></th>\n\
                                   <td> <input  type="text" name="GrothPerc_'+i+'" id="GrothPerc_'+i+'"  /></td><td><select id="NumYears_'+i+'" name="NumYears_'+i+'">\n\
                                        <option value="1">1</option>\n\
                                        <option value="2">2</option>\n\
                                        <option value="3">3</option>\n\
                                        <option value="4">4</option>\n\
                                        <option value="5">5</option>\n\
                                        <option value="6">6</option></select></td></tr>';
                       i++;
                        //str += $( this ).text() + " ";
                    });
                     $('#growth-table > tbody:last').append(str);
                    //  var countOfSelected = selectedOptions.size();
                    $(document).foundation();
                    $(".multi-select").dropdownchecklist('destroy');
                    $(".multi-select").dropdownchecklist({emptyText: "Please select ...",
        onItemClick: function(checkbox, selector){
	var justChecked = checkbox.prop("checked");
	var checkCount = (justChecked) ? 1 : -1;
	for( i = 0; i < selector.options.length; i++ ){
		if ( selector.options[i].selected ) checkCount += 1;
	}
      if ( checkCount > 3 ) {
		alert( "Limit is 3" );
		throw "too many";
	}
}
});
                 
             });
       });
       
    </script> 
{/literal}

{literal}
<script>
  $(function() {
    $( "#country" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
            type: "POST",
          url: "autosuggest1.php",
          dataType: "json",
          data: {
            queryString: request.term
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.countryname,
                value: item.countryname,
                 id: item.countryid
              }
            }));
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
       $('#vcid').val(ui.item.id);
       $('#form').submit();
      },
      open: function() {
        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    });
  });
  </script>
    
    
    
{/literal}
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
                        $(document).foundation.customForms;
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

</head>

<body>
<div id='pgLoading' style=" z-index:99999; position:fixed; width:100%; height:100%; display:none; overflow:hidden;
background:#fff;
opacity: .75;
-ms-filter: alpha(opacity=75);
filter: alpha(opacity=75);
-khtml-opacity: .75;
-moz-opacity: .75;">

<div style="position:absolute; left:50%; top:50%; margin:-250px 0 0 -250px;">
<img src="images/loading_page1.gif" width="508" height="381" alt=""/> </div>
</div>
<div class="header">
<div class="logo"> <a href="index.php"><img src="images/logo.gif" width="149" height="41" alt="Venture Intelligence" /></a></div>
<div class="header-right">

<ul class="nav">
<li {if $pageName neq 'comparers.php'} class="active" {/if}><a href="home.php"><i class="companies"></i> COMPANIES</a></li>
<li {if $pageName eq 'comparers.php'} class="active" {/if}><a href="comparers.php"><i class="compare"></i> COMPARE</a></li></ul>

<ul class="search-user">

<li class="search-company">
    <form id="form" action="details.php" method="get"   >
    <input type="text" value="" id="country"  class=""  autocomplete=off  />
    <span id="viewfinance" style="display:none;">&nbsp;</span>
    <div class="suggestionsBox" id="suggestions" style="display: none;"> <!--<img src="images/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />-->
    <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
    </div>
    <input type="hidden" name="vcid" id="vcid" value="" />
    <input name="" type="submit" /></form></li>

<!--<li class="avt-user"><a href="javascript:;"><i></i> Welcome {$authAdmin.user.elements.username}{if $authAdmin.user_id}{$authAdmin.firstname}{else}Guest{/if}</a></li>-->


<!--<font style="font-family: arial,helvetica,sans-serif;font-size:12px">Welcome {$authAdmin.user.elements.username}{if $authAdmin.user_id}{$authAdmin.firstname}{else}Guest{/if}<br/><br/>
		<div><a href="home.php">Database Home</a></div><br/>
		<div><a href="changepassword.php">Change Password</a></div><br/>
		{if $authAdmin.user_id}<div><a href="logout.php">Logout</a></div>{else}Already Registered User Please Click <a href="login.php">Login</a>{/if}<br/>
		</font>-->
                
    <li class="avt-user"><a href="#" data-dropdown="drop1"><i></i> Welcome {$authAdmin.user.elements.username}{if $authAdmin.user_id}{$authAdmin.firstname}{else}Guest{/if}</a></li>
 
    <ul id="drop1" class="f-dropdown" data-dropdown-content>  
                            <!--<li><a href="javascript:;">Tutorial</a></li>-->
                            <li><a href="changepassword.php">Change Password</a></li>
                            <li><a href="logout.php">Logout</a></li> 
    </ul>            
                
</ul></div>


</div>
             
{if $pageName eq 'comparers.php'} 
      <form name="Frm_HmeSearch" id="Frm_HmeSearch" action="comparers.php" method="post" class="custom"   enctype="multipart/form-data" >
    <div class="search-main">
    <ul>
        <li>
            <input type="radio" name="CompareType" id="Absolute" value="0" checked="checked" onchange="comaparepercen('Absolute')" />&nbsp;Absolute Difference
            <input type="radio" name="CompareType" id="Percentage" value="1" onchange="comaparepercen('Percentage')"/>&nbsp;Percentage Difference
        </li>

        <li>
            <label>YEAR</label> 
            <span style="float:left;" id="sectordisplay">
                <select id="answer_Year" name="answer_Year"  class="" style="" forError="Year" onchange="submitselect(this.value);">
                    {html_options options=$BYearArry selected=$comparecompanyyear}
                </select>
            </span>
        </li>
        
    </ul>
                  {if $CompareResults}
     <ul class="compare-new"> 
        <li id="add-company-btn"> <input name="" type="button" value="ADD COMPANY" id="add-company" /></li> 
        <li id="compare-btn" style="display:none"> <input name="company3" id="company3" type="text" placeholder="Enter Company Name here" />
        <input name="compare" type="submit" value="Compare" id="compare" /></li> 
        </ul>
     {/if}
    </div> 
    <div class="container">
{else} 
<form name="Frm_HmeSearch" id="Frm_HmeSearch" action="home1.php" method="post" class="custom"   enctype="multipart/form-data" >
<div class="search-main">
<ul>
<li><label>INDUSTRY</label> 
    <select id="answer[Industry]" name="answer[Industry]"  class="" forError="Industry" onchange="suggestsectors(this.value);" style="width: 210px;">
            <option value="" >Please Select an Industry</option>
            {html_options options=$industries selected=$REQUEST_Answer.Industry}
    </select></li>
    
    <li><label>SECTOR  </label> <span style="float:left;" id="sectordisplay">
    <select id="answer[Sector]" name="answer[Sector]"  class="" forError="Sector">
                <option value="" >Please Select a Sector</option>
             
                {html_options options=$sectors selected=$REQUEST_Answer.Sector}
    </select></span></li>
    
<li><label><input type="checkbox" name="ListingStatus" id="Listed" value="1" {if $REQUEST.ListingStatus eq 1} checked {/if}/> <span>Listed</span></label>
    <label>  <input type="checkbox" name="ListingStatus1" id="Unlisted" value="2" {if $REQUEST.ListingStatus1 eq 2 or count($REQUEST) eq 0} checked {/if}/> <span>Privately held(Ltd)</span></label>
    <label>  <input type="checkbox" name="ListingStatus2" id="Partnership" value="3" {if $REQUEST.ListingStatus2 eq 3} checked {/if}/> <span>Partnership</span></label>
    <label><input type="checkbox" name="ListingStatus3" id="Proprietorship" value="4" {if $REQUEST.ListingStatus3 eq 4} checked {/if}/> <span>Proprietorship</span></label></li>

<li> <input name="" type="submit" value="SEARCH"  /></li>
</ul>
 
</div>
<div class="container slide-bg {if $pageName eq 'home.php'} container-bg {/if}">
{/if}


