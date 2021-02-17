<?php 
 require_once("../dbconnectvi.php");
 $Db = new dbInvestments();
 if(!isset($_SESSION['UserNames']))
 {
     header('Location:../pelogin.php');
 }
 else
 {	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Venture Intelligence</title>
<link href="css/skin.css" rel="stylesheet" type="text/css" />   

  <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
  <script type="text/javascript" src="js/jquery.tablesorter.js"></script>
  <script src="js/showHide.js" type="text/javascript"></script>
  <script src="js/jPages.js"></script>
  <script src="js/jquery.icheck.min.js?v=0.9.1"></script>
  
  <script type="text/javascript" src="js/expand.js"></script>
  <script type="text/javascript" src="js/popup.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" />
  <script type="text/javascript" src="js/jquery.multiselect.js"></script>
  <script src="js/jquery.flexslider.js"></script>
<script src="js/jquery.masonry.min.js"></script>
  
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
        
      $(window).scroll(function(){
                            if ($(this).scrollTop() > 100) {
                                $('.scrollup').fadeIn();
                               // alert("Adsasd");
                            } else {
                                $('.scrollup').fadeOut();
                            }
                        }); 

                        $('.scrollup').click(function(){
                           // alert("asda");
                            $("html, body").animate({ scrollTop: 0 }, 600);
                            return false;
                        });
 
        
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
	  perPage : 20,
	  delay : 20
	});
});

$(document).ready(function(){
    
    
   $('.show_hide').showHide({			 
		speed: 1000,  // speed you want the toggle to happen	
		easing: '',  // the animation effect you want. Remove this line if you dont want an effect and if you haven't included jQuery UI
		changeText: 1, // if you dont want the button text to change, set this to 0
		showText: 'View Table',// the button text to show when a div is closed
		hideText: 'Close Table' // the button text to show when a div is open
					 
	}); 
     $("#slidingDataTable").show();
     $('.show_hide').addClass("active");

	$(".btn-slide").click(function(){
		$("#panel").animate({width: 'toggle'});
		$(this).removeClass("active"); return false; 
	});
	
 
  $('input').iCheck({
	checkboxClass: 'icheckbox_flat-red',
	radioClass: 'iradio_flat-red'
  });
  
  	$(".popup").LePopup({

		skin : "big-shadow"
           });


$('.typeoff-nav').on('ifChecked', function(event){
     
     var value = $(this).val();
      if (value == 1) {
            var hrefval = 'dashboard.php?type=1';
            $("#pesearch").attr("action", hrefval);
            $("#pesearch").submit();
            return false;
                    //window.location.assign("dashboard.php?type=1");
    }
    else if (value == 2) {
        var hrefval = 'dashboard.php?type=2';
        $("#pesearch").attr("action", hrefval);
        $("#pesearch").submit();
        return false;
        //window.location.assign("dashboard.php?type=2");
    }
    else if (value == 3) {
        var hrefval = 'dashboard.php?type=3';
        $("#pesearch").attr("action", hrefval);
        $("#pesearch").submit();
        return false;
       // window.location.assign("dashboard.php?type=3");
    }
    else if (value == 4) {
        var hrefval = 'dashboard.php?type=4';
        $("#pesearch").attr("action", hrefval);
        $("#pesearch").submit();
        return false;
        //window.location.assign("dashboard.php?type=4");
    }
    else if (value == 5) {
        var hrefval = 'dashboard.php?type=5';
        $("#pesearch").attr("action", hrefval);
        $("#pesearch").submit();
        return false;
        //window.location.assign("dashboard.php?type=5");
    }
    else if (value == 6) {
        var hrefval = 'dashboard.php?type=6';
        $("#pesearch").attr("action", hrefval);
        $("#pesearch").submit();
        return false;
        //window.location.assign("dashboard.php?type=6");
    }
});

});

function checkForAggregates()
{
	document.manda.hiddenbutton.value='Aggregate';
	document.manda.submit();
}
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

             var num1 = document.manda.txtmultipleReturnFrom.value;
             var num2 = document.manda.txtmultipleReturnTo.value;

             var x  = parseInt( num1  ,  10  )
             var y  = parseInt( num2  ,  10  )
             if(x > y)
                { 
                  alert("Please enter valid range");
                  return false;
                }

           }

</script>

   <script type="text/javascript">
$(function(){
	$(".selectgroup select").multiselect();
});
$(function () {
            $('.expander').simpleexpand();
          
        });
</script>
   <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
<style type="text/css">
                
                .scrollup{
                        width:58px;
                        height:58px;
                        opacity:0.3;
                        position:fixed;
                        cursor: pointer;
                        bottom:80px;
                        right:30px;
                        display:none;
                        text-indent:-9999px;
                        background: url(images/up_arrow.png) no-repeat;
                        z-index: 8000;
                    }
                    .scrollup:hover{opacity:1;}
                
/*                .mylist{margin: 5px;padding: 0;display: block;}
                .mylist li{border-right:#867979 solid thin;padding: 1px;}
                */
                
            </style>
</head>

<body> 
    <a href="#" class="scrollup">Scroll</a>
     <div id="popup1" style="width:800px;display: none;" class="popup">

    <h3>For the purpose of this database:</h3>
    <ul class="def-list">
        <li>In general, only investments by firms structured as PE/VC funds are INCLUDED<li>
        <li>Real Estate deals - both entity level and project-level are EXCLUDED<li>
        <li>In general, hedge funds / sovereign wealth funds investments into listed cos. are EXCLUDED<li>
        <li>Pre-IPO deals (6-months within IPO-filing date) by hedge funds / sovereign wealth funds / family offices / individuals / public market investors are EXCLUDED<li>
        <li>Strategic Investments and Barter Deals are EXCLUDED<li>
        <li>Follow-on investments by the same investor(s) into a company are included as separate transactions as long as the investments fall in different months. Newer investments in the same month (for example, multiple investments via the public markets) are updated as part of the same transaction.</li>
    </ul>
    <h2>Definitions of Stages-of-company-development used (Private Equity):  </h2>
    <h3>Private Equity investments are classified into the following categories: </h3>
    <h4>Venture Capital: </h4>
   
      <ul class="def-list">
          <li>First to Fourth Round of institutional investments into companies that are:</li>
          <li>Less than <10 years old, AND</li>
          <li>Investment amount is less than $20 M</li>
      </ul>
    <h4 >Growth-PE: </h4>
    <ul class="def-list">
        <li>First-to-Fourth Round Investments >$20 M into companies <10 years old, OR </li>
        <li>Fifth / Sixth rounds of institutional investments into companies <10 years old</li>
    </ul>
    <h4 >Late Stage: </h4>
    <ul class="def-list">
        <li>Investment into companies that are over 10 years old, OR <li>
        <li>Seventh or later rounds of institutional investments<li>
    </ul>
    <h4>PIPEs: </h4>
    <ul class="def-list">
       <li> PE investments in publicly-listed companies via preferential allotments / private  placements, OR<li>
       <li>	Acquisition of shares by PE firms via the secondary market<li>
    </ul>
    <h4 >Buyout: </h4>
    <ul class="def-list">
        <li>Acquisition of controlling stake via purchase of stakes of existing shareholders  </li>
    </ul>
    
</div>
<!--Header-->
<form name="searchall" action="" method="post" id="searchall">
<div id="header">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="left-box"> <div class="logo-img"> <a href="index.php"><img src="images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></td>
<td class="right-box">
<ul>
<li class="active"><a href="dashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li ><a href="index.php"><i class="i-data-deals"></i>Deals</a></li>
<li ><a href="pedirview.php?value=0"><i class="i-directory"></i>Directory</a></li>
</ul>
<ul class="fr">
<li class="user-avt"><span class="example" data-dropdown="#myaccount"> Welcome  Team</span> 
<div id="myaccount" class="dropdown">
		
                <ul class="dropdown-menu">
                <li><a href="changepassword.php?value=P">Change Password</a></li>
                <li><a href="logoff.php?value=P">Logout</a></li>
		</ul>
	</div></li>
</ul>
</td>
</tr>
</table>

</div>
</form>
<form name="pesearch" action="" method="post" id="pesearch">
<div id="sec-header" class="sec-header-fix">
<table cellpadding="0" cellspacing="0">
<tr>

<td class="investment-form">
<h3>Types</h3>
<label><input class="typeoff-nav" name="typeoff" type="radio"  value="1"   checked="checked" /> Year On year</label>
<label><input class="typeoff-nav" name="typeoff" type="radio"  value="2"  />Industry</label>
<label><input class="typeoff-nav" name="typeoff" type="radio"  value="3" />Stage</label>
<label><input class="typeoff-nav" name="typeoff" type="radio" value="4" />Range</label>
<label><input class="typeoff-nav" name="typeoff" type="radio" value="5" />Investor Type</label>
<label><input class="typeoff-nav" name="typeoff" type="radio" value="6" />Region</label>

</td>
</tr>
</table>
</div>


<div id="container">

<table cellpadding="0" cellspacing="0" width="100%" class="dashboard-table">
<tr>
 
<td width="100%" class="profile-view-left" colspan="2">

<div class="result-cnt">
 <div class="profile-view-title"> 
     <h2>PE - Year on Year</h2>
     <span class="title-links " id="exportbtn"></span>
 </div>
<div class="refine">
    <br> <h4>From <span style="margin-left: 125px;"> To</span></h4>
    <SELECT NAME="month1" id="month1">
     <OPTION id=1 value="--"> Month </option>
     <OPTION VALUE='1' SELECTED >Jan</OPTION>
     <OPTION VALUE='2' >Feb</OPTION>
     <OPTION VALUE='3' >Mar</OPTION>
     <OPTION VALUE='4' >Apr</OPTION>
     <OPTION VALUE='5' >May</OPTION>
     <OPTION VALUE='6' >Jun</OPTION>
     <OPTION VALUE='7' >Jul</OPTION>
     <OPTION VALUE='8' >Aug</OPTION>
     <OPTION VALUE='9' >Sep</OPTION>
     <OPTION VALUE='10' >Oct</OPTION>
     <OPTION VALUE='11' >Nov</OPTION>
    <OPTION VALUE='12' >Dec</OPTION>
</SELECT>
<SELECT NAME="year1" id="year1">
    <OPTION id=2 value="--"> Year </option>
    <OPTION id=1998 value='1998' SELECTED>1998</OPTION>
<OPTION id=1999 value='1999' >1999</OPTION>
<OPTION id=2000 value='2000' >2000</OPTION>
<OPTION id=2001 value='2001' >2001</OPTION>
<OPTION id=2002 value='2002' >2002</OPTION>
<OPTION id=2003 value='2003' >2003</OPTION>
<OPTION id=2004 value='2004' >2004</OPTION>
<OPTION id=2005 value='2005' >2005</OPTION>
<OPTION id=2006 value='2006' >2006</OPTION>
<OPTION id=2007 value='2007' >2007</OPTION>
<OPTION id=2008 value='2008' >2008</OPTION>
<OPTION id=2009 value='2009' >2009</OPTION>
<OPTION id=2010 value='2010' >2010</OPTION>
<OPTION id=2011 value='2011' >2011</OPTION>
<OPTION id=2012 value='2012' >2012</OPTION>
<OPTION id=2013 value='2013' >2013</OPTION>
 
</SELECT>
<SELECT NAME="month2" id='month2'>
      <OPTION id=1 value="--"> Month </option>
     <OPTION VALUE='1'  >Jan</OPTION>
     <OPTION VALUE='2' >Feb</OPTION>
     <OPTION VALUE='3' >Mar</OPTION>
     <OPTION VALUE='4' >Apr</OPTION>
     <OPTION VALUE='5' >May</OPTION>
     <OPTION VALUE='6' >Jun</OPTION>
     <OPTION VALUE='7' >Jul</OPTION>
     <OPTION VALUE='8' >Aug</OPTION>
     <OPTION VALUE='9' >Sep</OPTION>
     <OPTION VALUE='10' >Oct</OPTION>
     <OPTION VALUE='11' >Nov</OPTION>
    <OPTION VALUE='12' SELECTED>Dec</OPTION>
</SELECT>
<SELECT NAME="year2" id="year2" >
    <OPTION id=2 value="--"> Year </option>
    <OPTION id=1998 value='1998' >1998</OPTION>
<OPTION id=1999 value='1999' >1999</OPTION>
<OPTION id=2000 value='2000' >2000</OPTION>
<OPTION id=2001 value='2001' >2001</OPTION>
<OPTION id=2002 value='2002' >2002</OPTION>
<OPTION id=2003 value='2003' >2003</OPTION>
<OPTION id=2004 value='2004' >2004</OPTION>
<OPTION id=2005 value='2005' >2005</OPTION>
<OPTION id=2006 value='2006' >2006</OPTION>
<OPTION id=2007 value='2007' >2007</OPTION>
<OPTION id=2008 value='2008' >2008</OPTION>
<OPTION id=2009 value='2009' >2009</OPTION>
<OPTION id=2010 value='2010' >2010</OPTION>
<OPTION id=2011 value='2011' >2011</OPTION>
<OPTION id=2012 value='2012' >2012</OPTION>
<OPTION id=2013 value='2013' SELECTED>2013</OPTION>
 
</SELECT>
    <input type="submit" name="fliter_stage" value="Go">
   
      <div class="title-links"><a href="#Table">View Table</a></div>
    </div>
</div>
  
    
          <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization2").offsetWidth;
  
  divheight=  document.getElementById("visualization2").offsetHight;
  
        // Create and populate the data table.
          var data = google.visualization.arrayToDataTable([
            ['Year', 'No of Deals', 'Amount($m)']
                        ,['1998',  17,  169]
                    ,['1999',  46,  410]
                    ,['2000',  125,  732]
                    ,['2001',  80,  806]
                    ,['2002',  60,  553]
                    ,['2003',  63,  729]
                    ,['2004',  100,  1870]
                    ,['2005',  195,  2505]
                    ,['2006',  391,  7140]
                    ,['2007',  532,  14911]
                    ,['2008',  489,  10122]
                    ,['2009',  288,  4069]
                    ,['2010',  396,  8292]
                    ,['2011',  510,  10554]
                    ,['2012',  482,  9178]
                    ,['2013',  365,  7029]
                  ]);
          
          // Create and draw the visualization.
          var chart=new google.visualization.LineChart(document.getElementById('visualization2'));
           function selectHandler() {
             
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var query_string = 'value=0&y='+topping;
             window.location.href = 'index.php?'+query_string;
          }
        }
        google.visualization.events.addListener(chart, 'select', selectHandler);
              chart.draw(data,
                   {
                    title:" By Year on Year Chart",
                    width:divwidth, height:400,is3D:true,
                    smoothLine: true, 
                    hAxis: {title: "Year"},
                    vAxes: {
                            0: {
                                title: 'No of Deals',
                            },
                            1: {
                                title: 'Amount'
                            }
                        },
//                    colors: ["#FCCB05","#a2753a"],
                   
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "bars"}
                            }
                }
              );
      }
      google.setOnLoadCallback(drawVisualization);
    </script>
    
      </td></tr>
<tr>
 <td width="100%" class="profile-view-left">
<div id="visualization2" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;"></div>   
</td>

</tr> 

<tr>
    <td class="profile-view-left" colspan="2">
    <A NAME="Table">     
    <div  class="table-year-deals"  style="width:100%; overflow:hidden; position:absolute;">
    <div class="showhide-link">
        <a href="#" class="show_hide active" rel="#slidingDataTable">Close Table</a>
    </div>
    <div class="view-table" id="slidingDataTable" style="padding:0 20px;display:block; overflow:hidden;">
    <div class="restable" >
            
              
</div> 
         <!--div class="showhide-link"><a href="#" class="show_hide" rel="#slidingTable">View  Table</a></div-->
    </div>
        </div>
</td>

</tr>
</table>
</div>
 </form>

 
<div class=""></div>
<div>

            <!--input class="postlink" type="hidden" name="numberofcom" value=""-->
            <form name="pelisting" id="pelisting"  method="post" action="expdashboardPE.php">
                                         <input type="hidden" name="txttype" value=1 >
        	        <input type="hidden" name="txtstartdate" value=1998-01-01 >
			<input type="hidden" name="txtenddate" value=2013-12-12 >
                         <input type="hidden" name="txtfixstart" value=1998 >
			<input type="hidden" name="txtfixend" value=2013 >
                                               <div class="title-links" id="exportbtn"></div>
                        <script type="text/javascript">
                              $('#exportbtn').html('<input class ="export" type="button" id="expshowdeals"  value="Export" name="showdeals">');
                        </script>
                    </form>
</div>
 <script type="text/javascript">
                $("a.postlink").click(function(){
                  
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    
                });
                function resetinput(fieldname)
                {
                    
                  $("#resetfield").val(fieldname);
                  $("#pesearch").submit();
                    return false;
                }
                 $('#expshowdeals').click(function(){ 
                    hrefval= 'expdashboardPE.php';
            $("#pelisting").attr("action", hrefval);
            $("#pelisting").submit();
            return false;
            });
            </script>
</body>
</html>
<?php } ?>






