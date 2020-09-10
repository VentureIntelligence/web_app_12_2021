<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{$pageTitle}</title>
<meta  name="description" content="{$pageDescription}" />
<meta name="keywords" content="{$pageKeyWords}" />
<link href="css/screen.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/foundation.css" />
<link href="css/popstyle.css" rel="stylesheet" type="text/css" /> 
    
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.js"></script>  
<script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>

<script type="text/javascript" src="js/ui.dropdownchecklist.js"></script>
<script type="text/javascript" src="js/popup.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<!--<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>-->



 
      
{literal}
    
     <script>
  $(function() {
        $( "#chargefromdate" ).datepicker({
        dateFormat: "yy-mm-dd"
        });

        $( "#chargetodate" ).datepicker({
        dateFormat: "yy-mm-dd"
        });
  });
  </script>  
    
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
                                        <option value="2">2</option>\n\
                                        <option value="3">3</option>\n\
                                        <option value="4">4</option>\n\
                                        <option value="5">5</option></select></td></tr>';
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
    function validate()
    {
        var conval=$('#country').val();
        document.location.href='home.php?searchv='+conval;
        return false;
    }
    
  $(function() {
       $('#fsubmit').click(function() { 
           
            if($('#country').val()=="")
            {
                    alert("Please enter to search");
            }
            else
            {
                var conval=$('#country').val();
                document.location.href='home.php?searchv='+conval;
            }
        });
    $( "#country" ).autocomplete({
        
      source: function( request, response ) {
          $("#autosuggest_loading").show(); 
        $.ajax({
            type: "POST",
          url: "autosuggest1.php",
          dataType: "json",
          data: {
            queryString: request.term
          },
          success: function( data ) {
              $("#autosuggest_loading").hide(); 
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
      // $('#form').submit();
       if($('#vcid').val(ui.item.id)!='')
        {
             $('#form').submit();
        }
        else
        {
            var conval=$('#country').val();
            document.location.href='home.php?searchv='+conval;
        }
      },
      open: function() {
        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
      
    });
      
    
    
    
    
    
    
    
    
    $( "#chargeholder" ).autocomplete({
      
      source: function( request, response ) {
           $("#autosuggest_loading2").show(); 
        $.ajax({
            type: "POST",
          url: "chargefilter_autosuggest.php",
          dataType: "json",
          data: {
            chargeholder_str: request.term
          },
          success: function( data ) {
               $("#autosuggest_loading2").hide(); 
            response( $.map( data, function( item ) {
              return {
                label: item.chargeholder,
                value: item.chargeholder,
                 id: item.cin
              }
            }));
          }
  });
      },
      minLength: 3,
      select: function( event, ui ) {
      },
      open: function() {
        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }

    });
    
    
     $( "#chargeaddress" ).autocomplete({
      
      source: function( request, response ) {
           $("#autosuggest_loading3").show(); 
        $.ajax({
            type: "POST",
          url: "chargefilter_autosuggest.php",
          dataType: "json",
          data: {
            chargeaddress_str: request.term
          },
          success: function( data ) {
               $("#autosuggest_loading3").hide(); 
            response( $.map( data, function( item ) {
              return {
                label: item.cityname,
                value: item.cityname,
                 id: item.cityid
              }
            }));
          }
        });
      },
      minLength: 3,
      select: function( event, ui ) {
      },
      open: function() {
        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
      
    });
 
  });
   
      
  
  $(document).ready(function() {
  
  
          $( "#chargeholdertest" ).keyup(function() {
             
             var chargeholder = $("#chargeholdertest").val();
              
             if(chargeholder.length > 3 ) {
                    $.ajax({
                       type: "post",
                     url: "chargeholder_autosuggest.php",
                     data: {
                       chargeholder: chargeholder
                     },
                     success: function(data) {
                         $("#testholder").fadeIn();
                         $("#testholder").html(data);
                     }
  });

                 /*  $.post('chargefilter_autosuggest_test.php',{chargeholder:'test',xcxzc:'asdas'},function(data){
                       console.log(data);
                   }); */
        }
        else{
             $("#testholder").fadeOut();
        }

    });
    
    $("#selectall").live("click", function() {
    
            $('.ch_holder').attr('checked',this.checked);
            if(this.checked) 
            {                              
                var holder = $(this).val();                             
                var sltholder='';
                var sltcount=0;
                $('.ch_holder').each(function() { //loop through each checkbox

                       if(this.checked) {                              
                          var holder = $(this).val();                             

                             if(sltcount==0) { sltholder+=holder; }
                             else { sltholder+=","+holder; }

                          sltcount++;
                          
                           //sltuserscout++;
                       }

                  });
             }
             else{
                 sltcount=0;sltholder='';
                 if(sltcount==0){  $("#charge_clearall").fadeOut(); $("#chargeholdertest").removeAttr('readonly');   }
                    else {   $("#charge_clearall").fadeIn();  }
             }
                $("#chargeholdertest").attr('readonly','readonly');  
                $("#chargeholdertest").val(sltholder); 
                $("#testholder").show();
        });
    
      $('.ch_holder').live("click", function() {  //on click 
                      
                      var sltholder='';
                      var sltcount=0;
                      $('.ch_holder').each(function() { //loop through each checkbox
                          
                          if(this.checked) {                              
                             var holder = $(this).val();                             
                             
                                if(sltcount==0) { sltholder+=holder; }
                                else { sltholder+=","+holder; }
                             
                             sltcount++;
                             $("#testholder").show();
                              //sltuserscout++;
                          }
                          
                     });
                     
                    $("#chargeholdertest").attr('readonly','readonly');  
                    $("#chargeholdertest").val(sltholder); 
                    
                    
                    if(sltcount==0){  $("#charge_clearall").fadeOut(); $("#chargeholdertest").removeAttr('readonly');   }
                    else {   $("#charge_clearall").fadeIn();  }
                        
        if($(".ch_holder").length==$(".ch_holder:checked").length){
            
            $("#selectall").attr("checked","checked");
        }else{
            $("#selectall").removeAttr("checked");
        }
                     
                 
             });
           
   });
   
   
$(document).mouseup(function (e){
 
    $("#testholder").hide();
});

   
function clear_chholder(){
     $("#chargeholdertest").removeAttr('readonly');  
     sltholder='';
     $("#chargeholdertest").val(sltholder); 
     $("#testholder").fadeOut();
     $("#charge_clearall").fadeOut(); 
}   


function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
  </script>
    
    
    
{/literal}
{literal}
<script type="text/javascript" language="javascript1.2">

        function changeregion(region) {
                    
                    if(region=='') 
                    { return false }
                    
                        get_citybyregion(region);
                     
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
                                document.getElementById("statedisplay").innerHTML=xmlhttp.responseText;
                                $(document).foundation();
                                //alert(xmlhttp.responseText);
                                }
                          }
                        xmlhttp.open("GET","auto-regionstatecity.php?getstate&region="+region,true);
                        xmlhttp.send();

               };
               
               
               
               
                function get_citybyregion(region) {
                      
                                          
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
                                document.getElementById("citydisplay").innerHTML=xmlhttp.responseText;
                                $(document).foundation();
                                //alert(xmlhttp.responseText);
                                }
                          }
                        xmlhttp.open("GET","auto-regionstatecity.php?getcitybyregion&region="+region,true);
                        xmlhttp.send();

               };
               
               
               
               function changestate(state) {
                      
                      
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
                                document.getElementById("citydisplay").innerHTML=xmlhttp.responseText;
                                $(document).foundation();
                                //alert(xmlhttp.responseText);
                                }
                          }
                        xmlhttp.open("GET","auto-regionstatecity.php?getcity&state="+state,true);
                        xmlhttp.send();

               };
               
               
               
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
        function sectorsonload(str)
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
    
    <style type="text/css">
    #lastrefine .acc_container_active
    {
        padding-bottom: 14% !important;
        }
    </style>
    
{/literal}

</head>

{*<body ondragstart="return false" onselectstart="return false" oncontextmenu="return false" oncopy="return false" onpaste="return false" oncut="return false">*}

<body ondragstart="return false"  oncontextmenu="return false" >
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

<li class="search-company"  style="position:relative">
    <form id="form" action="details.php" method="get" onsubmit="return validate();">
    <input type="text" value="" id="country"  class=""  autocomplete=off  /> <img  id="autosuggest_loading"  src="images/autosuggest_loading.gif" style="position: absolute;right: 4%;top: 27%; display:none;">
    <span id="viewfinance" style="display:none;">&nbsp;</span>
    <div class="suggestionsBox" id="suggestions" style="display: none;"> <!--<img src="images/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />-->
    <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
    </div>
    <input type="hidden" name="vcid" id="vcid" value="" placeholder="Enter to Search" />
    <!--input name="fsubmit" id="fsubmit" type="button" /--></form></li>

<!--<li class="avt-user"><a href="javascript:;"><i></i> Welcome {$authAdmin.user.elements.username}{if $authAdmin.user_id}{$authAdmin.firstname}{else}Guest{/if}</a></li>-->


<!--<font style="font-family: arial,helvetica,sans-serif;font-size:12px">Welcome {$authAdmin.user.elements.username}{if $authAdmin.user_id}{$authAdmin.firstname}{else}Guest{/if}<br/><br/>
		<div><a href="home.php">Database Home</a></div><br/>
		<div><a href="changepassword.php">Change Password</a></div><br/>
		{if $authAdmin.user_id}<div><a href="logout.php">Logout</a></div>{else}Already Registered User Please Click <a href="login.php">Login</a>{/if}<br/>
		</font>-->
                
    <li class="avt-user"  data-dropdown="drop1"><a href="#" ><i></i> Welcome {$authAdmin.user.elements.username}{if $authAdmin.user_id}{$authAdmin.firstname}{else}Guest{/if}</a></li>
 
    <ul id="drop1" class="f-dropdown" data-dropdown-content>  
                        <li class="o_link"><a href="../pelogin.php" target="_blank">PE/VC Deals Database</a></li>
                        <li class="o_link"><a href="../relogin.php" target="_blank">PE in Real Estate Database</a></li>
                        <li class="o_link"><a href="../malogin.php" target="_blank">M&A Deals Database</a></li> 
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
                <select id="answer_Year" name="answer_Year"  class="" style="" forError="Year" {if ! isset($CompareResults)}  {/if} onchange="submitselect(this.value);">
                    {html_options options=$BYearArry selected=$comparecompanyyear}
                </select>
            </span>
        </li>
        
    </ul>
     {if isset($CompareResults)}
      <ul class="compare-new"> 
        <li id="add-company-btn"> <input name="" type="button" value="ADD COMPANY" id="add-company" /></li> 
        <li id="compare-btn" style="display:none;float: right;"> <input name="company3" id="company3" type="text" placeholder="Enter Company Name here" />
        <input name="compare" type="submit" value="Compare" id="compare" /></li> 
        </ul>
     {/if}
    </div> 
    <div class="container">
{else} 
<form name="Frm_HmeSearch" id="Frm_HmeSearch" action="home.php" method="post" class="custom"   enctype="multipart/form-data" >
<div class="search-main">
<ul>
<li><label>INDUSTRY</label> 
    <select id="answer[Industry]" name="answer[Industry]"  class="" forError="Industry" onload="suggestsectors(this.value);" onchange="suggestsectors(this.value);" style="width: 210px;">
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
<!--<li class="findcom"><label>Dont find a Company ?</label><a href="mailto:cfs@ventureintelligence.com?subject=Request for latest financials&body=Please add to the database the financials for the company" >Click here to request for financials</a></li>-->
</ul>
    <ul class="compare-new" style="top:95px;">
        <li class="findcom"><label>Dont find a Company ?</label><a href="mailto:cfs@ventureintelligence.com?subject=Request for latest financials&body=Please add to the database the financials for the company" >Click here to request for financials</a></li>
    </ul>
<!--ul>
 <li style="float:right;">Dont find a Company?<a>Click here to request for financials</a></li>
</ul-->
</div>
<div class="container slide-bg {if $pageName eq 'home.php'} container-bg {/if}">
{/if}


