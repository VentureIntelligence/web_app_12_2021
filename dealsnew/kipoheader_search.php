
<?php       $buttonClicked=$_POST['hiddenbutton'];
            $fetchRecords=true;
            $totalDisplay="";
            $keyword= $_POST['investorsearch'];
            $keywordhidden= trim($keyword);
            $companysearch=$_POST['companysearch'];
            $companysearchhidden= trim($companysearch);
            $advisorsearch=$_POST['advisorsearch'];
            $advisorsearchhidden= trim($advisorsearch);
            
            $advisorsearch="";
            
            $industry=$_POST['industry'];
            $investorType=$_POST['invType'];
            $exitstatusvalue=$_POST['exitstatus'];
          // echo "<br>___".$exitstatusvalue;
            $investorSale=$_POST['invSale'];

            $txtfrm=$_POST['txtmultipleReturnFrom'];
            $txtto=$_POST['txtmultipleReturnTo'];
            //  echo "<bR>***". $txtto;
            //echo "<br>--" .$txtfrm ."-" .$txtto;
            $whereind="";
            $whereinvType="";
            $whereinvestorSale="";
            $wheredates="";
            $wheredates1="";
            $whereexitstatus="";
            $whereReturnMultiple="";

            $month1=($_POST['month1']) ?  $_POST['month1'] : date('n', strtotime(date('Y-m')." -2	 month")); ;
            $year1 = ($_POST['year1']) ?  $_POST['year1'] : date('Y');
            $month2=($_POST['month2']) ?  $_POST['month2'] : date('n');
            $year2 = ($_POST['year2']) ?  $_POST['year2'] : date('Y');

            $notable=false;
            $vcflagValue=$_POST['txtvcFlagValue'];

            $searchallfield=$_POST['searchallfield'];
            $searchallfieldhidden=ereg_replace(" ","-",$searchallfield);

            //	echo "<br>FLAG VALIE--" .$vcflagValue;
            if($vcflagValue==0)
            {
                    $addVCFlagqry = "" ;
                    $searchTitle = "List of PE-backed IPOs ";
                    $searchAggTitle = "Aggregate Data - PE-backed IPOs ";
            }
            elseif($vcflagValue==1)
            {
                    $addVCFlagqry = " and VCFlag=1 ";
                    $searchTitle = "List of VC-backed IPOs ";
                    $searchAggTitle = "Aggregate Data - VC-backed IPOs ";
            }
             //echo "<br> InvestorType=". $investorType;
            //echo "<br>Investor search*- ". $keyword ;
            /*echo "<br>Company search*- " .$companysearch;
            echo "<br>Advisor search*- " .$advisorsearch;
            echo "<br>Industry*- " .$industry;
            echo "<br>Dates- " .$month1 ." ** " .$year1. " ** " .$month2. " ** " .$year2 ; */


		if($industry >0)
		{
			$industrysql= "select industry from industry where IndustryId=$industry";
			if ($industryrs = mysql_query($industrysql))
			{
				While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
				{
					$industryvalue=$myrow["industry"];
				}
			}
		}
		if($investorType !="--")
		{
		       $invTypeSql= "select InvestorTypeName from investortype where InvestorType='$investorType'";
		       if ($invrs = mysql_query($invTypeSql))
		       {
		          While($myrow=mysql_fetch_array($invrs, MYSQL_BOTH))
		          {
		             $invtypevalue=$myrow["InvestorTypeName"];
		          }
		       }
		}

		$datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
		$splityear1=(substr($year1,2));
		$splityear2=(substr($year2,2));

		if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
		{	$datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
			$datevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
                        $dt1 = $year1."-".$month1."-01";
                        $dt2 = $year2."-".$month2."-01";
                        $wheredates1= "";
		}

			$aggsql= "select count(pe.IPOId) as totaldeals,sum(pe.IPOSize) as totalamount from ipos as pe,industry as i,pecompanies as pec where";

		if($range != "--")
		{
			$rangesql= "select startRange,EndRange from investmentrange where InvestRangeId=". $range ." ";
			if ($rangers = mysql_query($rangesql))
			{
				While($myrow=mysql_fetch_array($rangers, MYSQL_BOTH))
				{
					$startRangeValue=$myrow["startRange"];
					$endRangeValue=$myrow["EndRange"];
					$rangeText=$myrow["RangeText"];

				}
			}
		}
		if($exitstatusvalue=="0")
		  $exitstatusdisplay="Partial Exit";
		elseif($exitstatusvalue=="1")
                  $exitstatusdisplay="Complete Exit";
                else
                  $exitstatusdisplay="";
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<title>Venture Intelligence</title>
<link href="css/skin.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" type="text/css" href="css/detect800.css" />
<link rel="stylesheet" href="/resources/demos/style.css" />

<!--<script src="http://code.jquery.com/jquery-1.9.1.js"></script> 

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
 
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


<script src="js/jPages.js"></script>
<script src="js/jquery.icheck.min.js?v=0.9.1"></script>-->
<!--<link rel="stylesheet" href="/resources/demos/style.css" /> -->

<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script src="js/jPages.js"></script>

<script src="js/jquery.icheck.min.js?v=0.9.1"></script>

<script type="text/javascript" src="js/responsive-tables.js"></script>
<script type="text/javascript" src="js/popup.js"></script>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
<script type="text/javascript" src="js/jquery.multiselect.js"></script> 
<script type="text/javascript" src="js/expand.js"></script>
<script src="js/showHide.js" type="text/javascript"></script>
<script src="js/jquery.flexslider.js"></script>
<script src="js/jquery.masonry.min.js"></script>
<script type="text/javascript">

    $(document).ready(function(){
       $('.show_hide').showHide({			 
		speed: 500,  // speed you want the toggle to happen	
		easing: '',  // the animation effect you want. Remove this line if you dont want an effect and if you haven't included jQuery UI
		changeText: 1 // if you dont want the button text to change, set this to 0
		
					 
	}); 
	$(".btn-slide").click(function(){
		$("#panel").animate({width: 'toggle'});
		$(this).toggleClass("active"); return false; 
	});
    });
</script>
<script type="text/javascript" >
    $(document).ready(function()
    {
        $(".account").click(function()
        {

        $('.submenu').toggle();
        });

        //Mouseup textarea false
        $(".submenu").mouseup(function()
        {
        return false
        });
        $(".account").mouseup(function()
        {
        return false
        });
        //Textarea without editing.
        $(document).mouseup(function()
        {
        $(".submenu").hide();
        });

    }); 
	
</script> 
<script type="text/javascript" src="js/tytabs.jquery.min.js"></script>
<script type="text/javascript">
<!--
$(document).ready(function(){
	 
	$("#tabsholder2").tytabs({
                prefixtabs:"tabz",
                prefixcontent:"contentz",
                classcontent:"tabscontent",
                tabinit:"1",
                catchget:"tab2",
                fadespeed:"normal"
                });
});
-->
</script>
<script>
  (function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) { 
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
			//( ".selector" ).on( "autocompletechange", function( event, ui ) {} );
          },
         /*  autocompletechange: "_removeIfInvalid",*/
		   
   			/*autocompletechange: function( event, ui ) { 
				$("form").submit();
			}*/
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.data( "ui-autocomplete" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
  $(function() {
	$("#keywordsearch").combobox();
    $("#combobox").combobox();
	$("#advisorsearch_legal").combobox();
	$("#advisorsearch_trans").combobox();
        $("#sectorsearch").combobox();
	/*$( ".custom-combobox" ).autocomplete({
	  change: function( event, ui ) { this.form.submit(); }
	});*/
        
        
 
        
  });
 

/*$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);*/ 
   
 jQuery(window).load(function() {
                    jQuery('.flexslider').flexslider({ directionNav: false });
                    jQuery(function(){
                            jQuery('.masonry-container').masonry({
                                    itemSelector: '.work-masonry-thumb',
                                    columnWidth: 159 
                            });
                    });

    });
</script>
            
  <script>
  
  $(document).ready(function() {

	if ((screen.width>=1280) && (screen.height>=720))
	{
		//alert('Screen size: 1280x720 or larger');
		//$("link[rel=stylesheet]:not(:first)").attr({href : "css/detect1024.css"});
	}
	else
	{
		//alert('Screen size: less than 1280x720, 1024x768, 800x600 maybe?');
		$("link[rel=stylesheet]:not(:first)").attr({href : "css/detect800.css"});
	}
});


$(document).ready(function(){ 
	$("#myTable").tablesorter({widthFixed: true}); 
	$("div.holder").jPages({
	  containerID : "movies",
	  previous : "← Previous",
	  next : "Next →",
	  perPage : 50,
	  delay : 20
	});
});

/*$(function(){
	$("#myTable").tablesorter(); 
	$("div.holder").jPages({
	  containerID : "movies",
	  previous : "← Previous",
	  next : "Next →",
	  perPage : 20,
	  delay : 20
	});
});*/
 
$(document).ready(function(){
 
          $('input').iCheck({
                checkboxClass: 'icheckbox_flat-red',
                radioClass: 'iradio_flat-red'
          });
          $(".popup").LePopup({

		skin : "big-shadow"
           });
           
     $('.investment-nav').on('ifChecked', function(event){
       
 navvalue=$(this).val();
       switch(navvalue)
       {
           case '0':
                     window.location.href = 'trendviewlatest.php?value='+$(this).val();
                    break;
           case '1':
                     window.location.href = 'trendviewlatest.php?value='+$(this).val();
                    break;
           case '2':
                   window.location.href = 'angelindex.php';
                   break;
           case '3':
                   
                   window.location.href = 'svtrendview.php?value='+$(this).val();
                   break;
           case '4':
                  
                     window.location.href = 'svtrendview.php?value='+$(this).val();
                    break;
           case '5':
                    window.location.href = 'svtrendview.php?value='+$(this).val();
                   break;
            case '6':
                   window.location.href = 'incindex.php';
                   break;
            
       }
});


 $('.exist-nav').on('ifChecked', function(event){
       navvalue=$(this).val();
       switch(navvalue)
       {
           case 'PE-BACKED-IPO':
                    var hrefval = 'ipotrendview.php?value=0';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                   break;
           case 'VC-BACKED-IPO':
                    var hrefval = 'ipotrendview.php?value=1';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                   break;
           case 'PMS':
                   window.location.href = 'mtrendview.php?value=0-1';
                   break;
           case 'PE-EXIST':
                   window.location.href = 'mtrendview.php?value=0-0';
                   break;
           case 'VC-EXIST':
                   window.location.href = 'mtrendview.php?value=1-0';
                   break;
               
       }
       

});

$('.typeoff-nav').on('ifChecked', function(event){
     
     var value = $(this).val();
      if (value == 1) {
        window.location.assign("trendview.php?type=1");
    }
    else if (value == 2) {
        window.location.assign("trendview.php?type=2");
    }
    else if (value == 3) {
        window.location.assign("trendview.php?type=3");
    }
    else if (value == 4) {
        window.location.assign("trendview.php?type=4");
    }
    else if (value == 5) {
        window.location.assign("trendview.php?type=5");
    }
    else if (value == 6) {
        window.location.assign("trendview.php?type=6");
    }
});

$('.typeoff-nav20').on('ifChecked', function(event){
     
     var value = $(this).val();
      if (value == 1) {
           var hrefval = 'kipoindex.php?type=1&value=0';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("ipotrendview.php?type=1&value=0");
    }
    else if (value == 2) {
         var hrefval = 'kipoindex.php?type=2&value=0';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("ipotrendview.php?type=2&value=0");
    }
    else if (value == 4) {
         var hrefval = 'kipoindex.php?type=4&value=0';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("ipotrendview.php?type=4&value=0");
    }
    else if (value == 5) {
         var hrefval = 'kipoindex.php?type=5&value=0';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("ipotrendview.php?type=5&value=0");
    }
});
$('.typeoff-nav21').on('ifChecked', function(event){
     
     var value = $(this).val();
      if (value == 1) {
          var hrefval = 'kipoindex.php?type=1&value=1';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("ipotrendview.php?type=1&value=1");
    }
    else if (value == 2) {
        var hrefval = 'kipoindex.php?type=2&value=1';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("ipotrendview.php?type=2&value=1");
    }
    else if (value == 4) {
        var hrefval = 'kipoindex.php?type=4&value=1';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
       // window.location.assign("ipotrendview.php?type=4&value=1");
    }
    else if (value == 5) {
        var hrefval = 'kipoindex.php?type=5&value=1';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
       // window.location.assign("ipotrendview.php?type=5&value=1");
    }
});
});




function checkForAggregates()
{
	document.ipo.hiddenbutton.value='Aggregate';
	document.ipo.submit();
}
  //' Allow user to enter only numbers  , - (minus) and .(dot) eg. -1.2    45- mindus
 function isNumberKey(evt)
          {
             var charCode = (evt.which) ? evt.which : event.keyCode

             if (((charCode > 47) && (charCode < 58 ) ) || (charCode == 8) || (charCode==46))
              {     return true;}
             else {  return false; }
          }
function isless()
//' do not submit if to < than from
           {

             var num1 = document.pesearch.txtmultipleReturnFrom.value;
             var num2 = document.pesearch.txtmultipleReturnTo.value;
             var x  = parseInt( num1  ,  10  )
             var y  = parseInt( num2  ,  10  )
             if(x > y)
                { 
                  alert("Please enter valid range");
                  document.pesearch.txtmultipleReturnTo.focus();
                  return false;
                }
               

           }

function checkFields()
 {
 	var selection = false;
 	var keyselection=false;
 //alert(document.ipo.industry.selectedIndex);
  if ((document.ipo.keywordsearch.value  != '') || (document.ipo.companysearch.value != ''))
    	  keyselection=true;
if (!keyselection)
{
  if (document.ipo.industry[document.ipo.industry.selectedIndex].value > 0)
   {
   	//alert ("comapny selected index > 0");
  	selection=true;
   }

 }
 	if((keyselection == true ) || (selection==true))
 		  {
 		  //	alert ("insie true");
 		   return true;
 		  // alert (selection);
 		  }
 	else
 		{
 		  alert("Search using keyword or choose inputs");
 		        return false;
		}
}

$('#pesearch').submit(function() {
  alert('Handler for .submit() called.');
  return false;
});
</script>
     <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
     <style type="text/css">
         .restable div.table-wrapper div.scrollable { overflow: auto; overflow-y: hidden; }	
     </style>
</head>

<body> 
    
 <?php 
           
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '0';
        //echo "<br>*".$value;
        $strvalue = explode("/", $value);
        $SelCompRef=$strvalue[0];
        $pe_re=$strvalue[1];
        if(sizeof($strvalue)>1)
        {   
            $vcflagValue=$strvalue[1];
            $VCFlagValue=$strvalue[1];
        }
        else
        {
            $vcflagValue=$strvalue[0];
            $VCFlagValue=$strvalue[0];
        }
        
	if($VCFlagValue==0)
	{
		$addVCFlagqry = "";
		$pagetitle="PE-backed IPOs-> Search";
		$companyFlag=3;
	}
	elseif($VCFlagValue==1)
	{
		$addVCFlagqry = " and VCFlag=1";
		$pagetitle="VC-backed IPOs-> Search";
		$companyFlag=4;
	}
        
            $getTotalQuery = "select count(IPOId) as totaldeals,sum(IPOSize)as totalamount from ipos where Deleted=0" .$addVCFlagqry ;
            if ($totalrs = mysql_query($getTotalQuery))
            {
             While($myrow=mysql_fetch_array($totalrs, MYSQL_BOTH))
               {
                            $totDeals = $myrow["totaldeals"];
                            $totDealsAmount = $myrow["totalamount"];
                    }
            }

		$TrialSql="select dm.DCompId as compid,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
					where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
				//	echo "<br>---" .$TrialSql;
			if($trialrs=mysql_query($TrialSql))
			{
				while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
				{
					$exportToExcel=$trialrow["TrialLogin"];
					$compId=$trialrow["compid"];
				}
			}
			if($compId==$companyId)
                       { $hideIndustry = " and display_in_page=1 "; }
                       else
                       { $hideIndustry=""; }
?>
     <?php 
    $defpage=$VCFlagValue."ipo";
    include_once('definitions.php');?>
<!--Header-->
<form name="pesearch" id="pesearch" action="" method="post"  >
<div id="header">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="left-box"> <div class="logo-img"> <a href="#"><img src="images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></td>


<td class="right-box">
<ul>
<li <?php echo ($topNav=='Dashboard') ? 'class="active"' : '' ; ?>><a href="dashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li <?php echo ($topNav=='Deals') ? 'class="active"' : '' ; ?>><a href="trendviewlatest.php"><i class="i-data-deals"></i>Data/Deals</a></li>
<li <?php echo ($topNav=='Directory') ? 'class="active"' : '' ; ?>><a href="pedirview.php?value=0"><i class="i-directory"></i>Directory</a></li>
</ul>
<ul class="fr">
<li ><div style="float:right;padding: 9px 15px" class="key-search"><b></b> <input  autofocus="autofocus" type="text" name="searchallfield" placeholder=" Keyword Search"
                                                                                      <?php if($searchallfield!="") echo "value=".$searchallfield ;?>
                                                                                       style="padding:5px;"  /> 
        <input type="button" name="fliter_stage" value="Go" onclick="this.form.submit();" style="padding: 5px;"/>
    </div></li>
<li class="user-avt"><span class="example" data-dropdown="#myaccount"> Welcome  <?php echo $_SESSION['UserNames']; ?></span> 
<div id="myaccount" class="dropdown">
		<ul class="dropdown-menu">
			<li><a href="javascript:;">Tutorial</a></li>
			<li><a href="changepassword.php?value=P">Change Password</a></li>
                        <li><a href="logoff.php?value=P">Logout</a></li>
                        <li><a href="logoff.php?value=P"></a></li> 
		</ul>
	</div></li>
</ul>
</td>
</tr>
</table>

</div>

<div id="sec-header">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="investment-form">
<h3>INVESTMENTS</h3>
<label><input class="investment-nav" name="investments" type="radio" value=0  onclick="alert(10);"  onchange="alert(120);"/> PE</label>

<label><input class="investment-nav" name="investments" type="radio" value=1  /> VC</label>

<label><input class="investment-nav" name="investments" type="radio" value=2  />Angel</label>

<label><input class="investment-nav" name="investments" type="radio" value=6  />Incubation</label>

<label><input class="investment-nav" name="investments" type="radio" value=4 />Cleantech</label>

<label><input class="investment-nav" name="investments" type="radio" value=5  />Infrastructure</label>

<label><input class="investment-nav" name="investments" type="radio" value=3  />Social</label>
</td>



<td class="exit-form">
<h3>EXITS</h3>

<label><input class="exist-nav" name="investments" type="radio" value="PE-BACKED-IPO" <?php if($VCFlagValue==0) { ?> checked="checked" <?php } ?>/>IPO(PE)</label>

<label><input class="exist-nav" name="investments" type="radio" value="VC-BACKED-IPO" <?php if($VCFlagValue==1) { ?> checked="checked" <?php } ?>/>IPO(VC)</label>

<label><input class="exist-nav" name="investments" type="radio" value="PMS" /> Public Market Sale</label>

<label><input class="exist-nav" name="investments" type="radio" value="PE-EXIST" />M&A(PE) </label>

<label><input class="exist-nav" name="investments" type="radio" value="VC-EXIST" />M&A(VC) </label>




</td>


<td class="vertical-form">
<h3>PERIOD</h3>

<div class="period-date">
<label>From</label>
<SELECT NAME="month1" id="month1">
     <OPTION id=1 value="--"> Month </option>
     <OPTION VALUE='1' <?php echo ($month1 == '1') ? 'SELECTED' : ''; ?> >Jan</OPTION>
     <OPTION VALUE='2' <?php echo ($month1 == '2') ? 'SELECTED' : ''; ?>>Feb</OPTION>
     <OPTION VALUE='3' <?php echo ($month1 == '3') ? 'SELECTED' : ''; ?>>Mar</OPTION>
     <OPTION VALUE='4' <?php echo ($month1 == '4') ? 'SELECTED' : ''; ?>>Apr</OPTION>
     <OPTION VALUE='5' <?php echo ($month1 == '5') ? 'SELECTED' : ''; ?>>May</OPTION>
     <OPTION VALUE='6' <?php echo ($month1 == '6') ? 'SELECTED' : ''; ?>>Jun</OPTION>
     <OPTION VALUE='7' <?php echo ($month1 == '7') ? 'SELECTED' : ''; ?>>Jul</OPTION>
     <OPTION VALUE='8' <?php echo ($month1 == '8') ? 'SELECTED' : ''; ?>>Aug</OPTION>
     <OPTION VALUE='9' <?php echo ($month1 == '9') ? 'SELECTED' : ''; ?>>Sep</OPTION>
     <OPTION VALUE='10' <?php echo ($month1 == '10') ? 'SELECTED' : ''; ?>>Oct</OPTION>
     <OPTION VALUE='11' <?php echo ($month1 == '11') ? 'SELECTED' : ''; ?>>Nov</OPTION>
    <OPTION VALUE='12' <?php echo ($month1 == '12') ? 'SELECTED' : ''; ?>>Dec</OPTION>
</SELECT>

<SELECT NAME="year1" id="year1"  id="year1">
    <OPTION id=2 value=""> Year </option>
    <?php 
		$yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates asc";
		if($yearSql=mysql_query($yearsql))
		{
                        if($type == 1)  
                        {
                            if($_POST['year1']=='')
                            {
                                $year1=1998;
                            }
                        }
                        else
                        {
                            if($_POST['year1']=='')
                            {
                                $year1=2009;
                            }
                        }
			While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$id = $myrow["Year"];
				$name = $myrow["Year"];
				$isselected = ($year1==$id) ? 'SELECTED' : '';
				echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
			}		
		}
	?> 
</SELECT>
</div>
<div class="period-date">
<label>To</label>

<SELECT NAME="month2" id='month2'>
      <OPTION id=1 value="--"> Month </option>
     <OPTION VALUE='1' <?php echo ($month2 == '1') ? 'SELECTED' : ''; ?> >Jan</OPTION>
     <OPTION VALUE='2' <?php echo ($month2 == '2') ? 'SELECTED' : ''; ?>>Feb</OPTION>
     <OPTION VALUE='3' <?php echo ($month2 == '3') ? 'SELECTED' : ''; ?>>Mar</OPTION>
     <OPTION VALUE='4' <?php echo ($month2 == '4') ? 'SELECTED' : ''; ?>>Apr</OPTION>
     <OPTION VALUE='5' <?php echo ($month2 == '5') ? 'SELECTED' : ''; ?>>May</OPTION>
     <OPTION VALUE='6' <?php echo ($month2 == '6') ? 'SELECTED' : ''; ?>>Jun</OPTION>
     <OPTION VALUE='7' <?php echo ($month2 == '7') ? 'SELECTED' : ''; ?>>Jul</OPTION>
     <OPTION VALUE='8' <?php echo ($month2 == '8') ? 'SELECTED' : ''; ?>>Aug</OPTION>
     <OPTION VALUE='9' <?php echo ($month2 == '9') ? 'SELECTED' : ''; ?>>Sep</OPTION>
     <OPTION VALUE='10' <?php echo ($month2 == '10') ? 'SELECTED' : ''; ?>>Oct</OPTION>
     <OPTION VALUE='11' <?php echo ($month2 == '11') ? 'SELECTED' : ''; ?>>Nov</OPTION>
    <OPTION VALUE='12' <?php echo ($month2 == '12') ? 'SELECTED' : ''; ?>>Dec</OPTION>
</SELECT>

<SELECT NAME="year2" id="year2" onchange="this.form.submit();" id='year2'>
    <OPTION id=2 value=""> Year </option>
    <?php 
		$yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates asc";
                 if($_POST['year2']=='')
                {
                    $year2=date("Y");
                }
		if($yearSql=mysql_query($yearsql))
		{
			While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$id = $myrow["Year"];
				$name = $myrow["Year"];
				$isselcted = ($year2== $id) ? 'SELECTED' : '';
				echo "<OPTION id=". $id. " value='". $id."' ".$isselcted.">".$name."</OPTION>\n";
			}		
		}
	?> 
</SELECT>
</div>


</td>
<td class="search-btn"> <input name="searchpe" type="submit" value="Search" /></td>
</tr>
</table>
</div>
