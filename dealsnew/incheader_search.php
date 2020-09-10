<?php include_once("../globalconfig.php"); ?>
<?php $searchString1="Unknown";
                $searchString1=strtolower($searchString1);
                $totalDisplay="";
                $keyword=$_POST['keywordsearch'];
                $keywordhidden=trim($_POST['keywordsearch']);
                
                $keywordhidden =ereg_replace(" ",":",$keywordhidden);
                $companysearch=$_POST['companysearch'];
                $companysearchhidden=ereg_replace(" ","-",trim($companysearch));
              /*  $searchallfield=$_POST['searchallfield'];
                $searchallfieldhidden=ereg_replace(" ","-",$searchallfield);

                
                
                
                if(isset($_REQUEST['searchallfield_other'])){
                $searchallfield=$_REQUEST['searchallfield_other'];
               $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);
                }*/

                //$region=$_POST['region'];
              //  $industry=$_POST['industry'];
             //   $status=$_POST['statusid'];
               // $incfirmtype=$_POST['txtfirmtype'];
                //echo "<br>~~".$_POST['chkDefunct'];
                 if($defunctflag == 0)
                {
                    $addDefunctqry=" and Defunct=0 ";
                }
                else
                {
                    $addDefunctqry="";
                }
             //   $followon=$_POST['followonFund'];
              //  $regionId=$_POST['txtregion'];
           /* if($followon=="--")
                $followonFund="--";
            if($followon==1)
                $followonFund=1;
            elseif($followon==2)
                $followonFund=0;*/
                $whereind="";
                $wherestatus="";
                if($industry >0 && $industry !='--')
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
   		if($status >0)
		{
		$statussql= "select StatusId,Status from incstatus where StatusId=$status";
    		if ($stagers = mysql_query($statussql))
			{
				While($mysrow=mysql_fetch_array($stagers, MYSQL_BOTH))
				{
					$statusvalue=$mysrow["Status"];
				}
			}
		}
		if($incfirmtype >0)
		{
			$incfirmsql= "select IncFirmTypeId,IncTypeName from incfirmtypes where IncFirmTypeId=$incfirmtype";
    		if ($incrs = mysql_query($incfirmsql))
                {
                        While($myincrow=mysql_fetch_array($incrs, MYSQL_BOTH))
                        {
                                $inctype=$myincrow["IncTypeName"];
                        }
                }
		}
		if($defunctflag==1)
                {   $defunctText= "Excluded Defunct Cos"; }
                else
                {     $defunctText= "Included Defunct Cos"; }
		 if($regionId >0)
		{
			$regionSql= "select RegionId,Region from region where RegionId=$regionId";
                        if ($regionrs = mysql_query($regionSql))
			{
				While($myrrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
				{
					$regionvalue=$myrrow["Region"];
				}
			}
		}
              /*  if($followonFund =="--")
                {
                    $followonFundText="";
                }
                elseif($followonFund=="1")
                {
                    $followonFundText="Follow on Funding";
                }
                elseif($followonFund=="0")
                {
                    $followonFundText="No Funding";
                }*/

 				$addVCFlagqry = " and pec.industry !=15 ";

   				$searchTitle = "Incubated Companies";
   				 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-168374697-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-168374697-1');
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- <title>Venture Intelligence</title> -->
<title>Private Equity Deal Database</title>
<link rel="shortcut icon" href="../img/fave-icon.png">
<link href="css/skin_1.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" type="text/css" href="css/detect800.css" />
<link rel="stylesheet" type="text/css" href="css/token-input.css" />
<link rel="stylesheet" type="text/css" href="css/token-input-facebook.css" />
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/popup.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<!--<link rel="stylesheet" href="/resources/demos/style.css" />-->
<script type="text/javascript" src="js/jquery.multiselect.js"></script> 
<script type="text/javascript" src="js/jquery.tokeninput.js"></script> 
 <script type="text/javascript" src="js/expand.js"></script>
 <script src="js/showHide.js" type="text/javascript">
 </script>
   <script src="js/jquery.flexslider.js"></script>
<script src="js/jquery.masonry.min.js"></script>
<!--  <script src="js/switch.min.js" type="text/javascript"></script>
 <link href="css/switch.css" type="text/css" rel="stylesheet">-->

<script src="TourStart.js"></script>  


 <script type="text/javascript">
     

$(document).ready(function(){


   $('.show_hide').showHide({			 
		speed: 800,  // speed you want the toggle to happen	
		easing: '',  // the animation effect you want. Remove this line if you dont want an effect and if you haven't included jQuery UI
		changeText: 1 // if you dont want the button text to change, set this to 0
		
					 
	}); 
	$(".btn-slide").click(function(){
            $("#panel").animate({width: 'toggle'}, 200); 
            $(this).toggleClass("active"); 

            if ($('.left-td-bg').css("min-width") == '264px') {
            $('.left-td-bg').css("min-width", '36px');
            $('.acc_main').css("width", '35px');
            }
            else {
            $('.left-td-bg').css("min-width", '264px');
            $('.acc_main').css("width", '264px');
            } 
            return false; //Prevent the browser jump to the link anchor
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
<script src="js/jPages.js"></script>
<script src="js/jquery.icheck.min.js?v=0.9.1"></script>
<script src="js/jquery.flexslider.js"></script>

<!-- Masonry -->
<script src="js/jquery.masonry.min.js"></script>
<script type="text/javascript" src="js/responsive-tables.js"></script>
<script type="text/javascript">
	
    jQuery(window).load(function() {
                    jQuery('.flexslider').flexslider({ directionNav: false });
                    jQuery(function(){
                            jQuery('.masonry-container').masonry({
                                    itemSelector: '.work-masonry-thumb',
                                    columnWidth: 159 
                            });
                    });

    });
    
  $(document).ready(function(){ 
//	$("#myTable").tablesorter({widthFixed: true}); 
//	$("div.holder").jPages({
//	  containerID : "movies",
//	  previous : "?? Previous",
//	  next : "Next ?",
//	  perPage : 50,
//	  delay : 20
//	});
});
    $(document).ready(function(){
      $('input').iCheck({
        checkboxClass: 'icheckbox_flat-red',
        radioClass: 'iradio_flat-red'
      });
    });
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
        var keywordsearchbox = $("#keywordsearch").combobox();
        var companysearchbox = $("#combobox").combobox();
        
         keywordsearchbox.on( "comboboxselect", function( event, ui ) {
           companysearchbox.combobox("destroy") ;
           $("#combobox option:eq(0)").attr('selected','selected');
           companysearchbox.combobox() ;
        } );
       companysearchbox.on( "comboboxselect", function( event, ui ) {
           keywordsearchbox.combobox("destroy") ;
           $("#keywordsearch option:eq(0)").attr('selected','selected');
           keywordsearchbox.combobox() ;
        } );
        
        $("#resetall").click(function (){
           keywordsearchbox.combobox("destroy") ;
           companysearchbox.combobox("destroy") ;
           
           $("#keywordsearch option:eq(0)").attr('selected','selected');
           $("#combobox option:eq(0)").attr('selected','selected');
           
           keywordsearchbox.combobox();
           companysearchbox.combobox() ;
        });
    
        
 
        
  });
 
     jQuery(window).load(function() {
                    jQuery('.flexslider').flexslider({ directionNav: false });
                    jQuery(function(){
                            jQuery('.masonry-container').masonry({
                                    itemSelector: '.work-masonry-thumb',
                                    columnWidth: 159 
                            });
                    });

    });

/*$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);*/ 
   

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
 
  $(".popup").LePopup({

		skin : "big-shadow"
           });

     $(document).on('ifChecked', '.investment-nav', function(event){
       navvalue=$(this).val();
       switch(navvalue)
       {
            case '0':
                   window.location.href = 'index.php?value='+$(this).val();
                   break;
           case '1':
                   window.location.href = 'index.php?value='+$(this).val();
                   break;
           case '2':
                   window.location.href = 'angelindex.php';
                   break;
           case '3':
                   window.location.href = 'svindex.php?value='+$(this).val();
                   break;
           case '4':
                   window.location.href = 'svindex.php?value='+$(this).val();
                   break;
           case '5':
                   window.location.href = 'svindex.php?value='+$(this).val();
                   break;
            case '6':
                   window.location.href = 'incindex.php';
                   break;
       }
       

});

$(document).on('ifChecked', '.typeoff-nav', function(event){
     
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

 $(document).on('ifChecked', '.exist-nav', function(event){
       navvalue=$(this).val();
       switch(navvalue)
       {
           case 'PE-BACKED-IPO':
                   window.location.href = 'ipoindex.php?value=0';
                   break;
           case 'VC-BACKED-IPO':
                   window.location.href = 'ipoindex.php?value=1';
                   break;
           case 'PMS':
                   window.location.href = 'mandaindex.php?value=0-1';
                   break;
            case 'VMS':
                   window.location.href = 'mandaindex.php?value=1-1';
                   break;       
           case 'PE-EXIST':
                   window.location.href = 'mandaindex.php?value=0-0';
                   break;
           case 'VC-EXIST':
                   window.location.href = 'mandaindex.php?value=1-0';
                   break;
               
       }
       

});

});

$(function () {
            $('.expander').simpleexpand();
        });
        
          $(function() {
    $( "#industries" ).autocomplete({
        
      source: function( request, response ) {
        $.ajax({
            type: "POST",
          url: "autoindustries.php",
          dataType: "json",
          data: {
            queryString1: request.term
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.industryname,
                value: item.industryname,
                 id: item.industryid
              }
            }));
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
       $('#industry').val(ui.item.id);
       //$('#form').submit();
      },
      open: function() {
        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    });
  }); 
  
   $(function() {
    $( "#incubator" ).autocomplete({
        
      source: function( request, response ) {
        $.ajax({
            type: "POST",
          url: "autoincubator.php",
          dataType: "json",
          data: {
            queryString: request.term
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.incubatorname,
                value: item.incubatorname,
                 id: item.incubatorid
              }
            }));
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
       $('#autoincubator').val(ui.item.id);
       //$('#form').submit();
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


<script>
         $(document).ready(function() {
  $(".datesubmit").click(function() {
      
    var year1=$('#year1').val();
    var year2=$('#year2').val();
     
    var month1=$('#month1').val();
    var month2=$('#month2').val();
        
	if(month1=='--' || month2=='--'){
            alert("Error: Please Select the month");
		return false;
        }
        else if(year1 > year2)
	{
		alert("Error: 'To' Year cannot be before 'From' Year");
		return false;
	}
        else if(year1 == year2)
        {
            if(parseInt(month1) > parseInt(month2))
            {
                alert("Error: 'To' Month cannot be before 'From' Month");
		return false;
            } 
            else
                {
                    $("#pesearch").submit();
                }
        }
	else
	{
		$("#pesearch").submit();
	}
  
});
});

function checkForDate()
{
	var year1=$('#year1').val();
	var year2=$('#year2').val();
        
        var month1=$('#month1').val();
        var month2=$('#month2').val();
	
	if(month1=='--' || month2=='--'){
            alert("Error: Please Select the month");
		return false;
        }
        else if(year1 > year2)
	{
		alert("Error: 'To' date cannot be before 'From' date");
		return false;
	}
        else if(year1 == year2)
        {
            if(parseInt(month1) > parseInt(month2))
            {
                alert("Error: 'To' Month cannot be before 'From' Month");
		return false;
            } 
            else
                {
                    $("#pesearch").submit();
                }
        }
	else
	{
		$("#pesearch").submit();
	}
	
}      
                                                   

</script>

<style type="text/css">

#preloading {
background:url(images/linked-in.gif) no-repeat center center;
height: 100px;
width: 100px;
position: fixed;
left: 50%;
top: 50%;
margin: -25px 0 0 -25px;
z-index: 1000;
}

#maskscreen
{
position: fixed;
left: 0;
top: 0;
background: #000;
z-index: 8000;
overflow: hidden;
}
.exit-form h3{
  opacity: 0.5;
}
.exit-form h3:hover{
  opacity: 1;
}

</style>
</head>

<?php if($_SESSION['PE_TrialLogin']==1){ ?>
<body > 
<?php }else { ?>
<body ondragstart="return false" onselectstart="return false" oncontextmenu="return false" oncopy="return false" onpaste="return false" oncut="return false"> 
<?php } ?>
     <div id="maskscreen" ></div>
<div id="preloading"></div>
<script type="text/javascript" >
$('#maskscreen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
jQuery(window).load(function(){
jQuery('#preloading').fadeOut(1000);
jQuery('#maskscreen').fadeOut(1000);
});
</script>
    <?php //oncontextmenu="return false;" oncopy="return false" oncut="return false" onpaste="return false"
     $defpage=6;
     $indef=1;
     include_once('definitions.php');
     include_once('refinedef.php');
           
            $getTotalQuery= "SELECT count( pe.IncDealId ) AS totaldeals
            FROM incubatordeals  AS pe, pecompanies AS pec
            WHERE pe.Deleted =0
            AND pec.PECompanyId = pe.IncubateeId
            AND pec.industry !=15";
            $industrysql_search="select industryid,industry from industry where industryid IN (".$_SESSION['PE_industries'].") ".$hideIndustry." order by industry";


            if ($totalrs = mysql_query($getTotalQuery))
            {
             While($myrow=mysql_fetch_array($totalrs, MYSQL_BOTH))
               {
                            $totDeals = $myrow["totaldeals"];
                    }
            }

            $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
            where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
            //echo "<br>---" .$TrialSql;
            if($trialrs=mysql_query($TrialSql))
            {
                    while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                    {
                            $exportToExcel=$trialrow["TrialLogin"];
                    }
            }
?>
<!--Header-->
<form name="searchall" id="searchall" action="incindex.php" method="post">
<div id="header">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="left-box"> <div class="logo-img"> <a href="index.php"><img src="images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></td>

<td class="right-box">
     <?php include('top_menu.php'); ?>
<!--<ul>
<li <?php echo ($topNav=='Dashboard') ? 'class="active"' : '' ; ?>><a href="dashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li <?php echo ($topNav=='Deals') ? 'class="active"' : '' ; ?>><a href="incindex.php"><i class="i-data-deals"></i>Deals</a></li>
<li <?php echo ($topNav=='Directory') ? 'class="active"' : '' ; ?>><a href="pedirview.php"><i class="i-directory"></i>Directory</a></li>
<li <?php echo ($topNav=='Funds') ? 'class="active"' : '' ; ?>><a href="funds.php"><i class="i-directory"></i>Funds <span class="betaversion">Beta</span></a></li>
<!--li <?php echo ($topNav=='Report') ? 'class="active"' : '' ; ?>><a href="report.php"><i class="i-directory"></i>Report</a></li
</ul>-->
<ul class="fr">
      <!-- <li class="classic-btn"><a href="http://www.ventureintelligence.info/deals/dealhome.php" >Classic View</a></li> -->
      <?php //include('TourStartbtn.php'); ?>
      
<li ><div style="float:right;padding: 9px 15px" class="key-search"><b></b> <input type="text" name="searchallfield" placeholder="Search"
                                                                                      <?php if($searchallfield!="") echo "value=".$searchallfield ;?>
                                                                                       style="padding:5px;"  /> 
        <input type="button" name="fliter_stage" value="Go" onclick="this.form.submit();" style="padding: 5px;"/>
    </div></li>
 <?php if($_SESSION['student']!="1") { ?>   
<li class="user-avt"><span class="example" data-dropdown="#myaccount"> Welcome  <?php echo $_SESSION['UserNames']; ?></span> 
    <?php } 
 else {
 ?>       
 <li class="user-avt"><span class="studentlogin" data-dropdown="#myaccount"> Welcome  <?php echo $_SESSION['UserNames']; ?></span> 
 <?php    
 }?>
<?php if($_SESSION['student']!="1") { ?>
<div id="myaccount" class="dropdown" style="left:inherit !important; max-width: 250px !important;">
		<ul class="dropdown-menu">
                        <li class="o_link"><a href="../relogin.php" target="_blank">PE in Real Estate Database</a></li>
                        <li class="o_link"><a href="../malogin.php" target="_blank">M&A Deals Database</a></li>
                        <li class="o_link"><a href="../cfsnew/login.php" target="_blank">Company Financials Database</a></li>
                        
                        
			<li><a href="javascript:;">Tutorial</a></li>
			<li><a href="changepassword.php?value=P">Change Password</a></li>
                        <li><a href="logoff.php?value=P">Logout</a></li> 
		</ul>
	</div>
<?php } ?></li>
</ul>
</td>
</tr>
</table>

</div>
</form>
<form name="pesearch" id="pesearch" action="incindex.php" method="post">
<div id="sec-header" class="sec-header-fix incindex">
<table cellpadding="0" cellspacing="0">
<tr>
 
    
    
    
<!--<td class="investment-form">
<h3>INVESTMENTS</h3>

<label><input class="investment-nav" name="investments" type="radio" value=0  onclick="alert(10);"  onchange="alert(120);"/> PE</label>

<label><input class="investment-nav" name="investments" type="radio" value=1  /> VC</label>

<label><input class="investment-nav" name="investments" type="radio" value=2  />Angel</label>

<label><input class="investment-nav" name="investments" type="radio" value=6 checked="checked" />Incubation</label>

<label><input class="investment-nav" name="investments" type="radio" value=4 />Cleantech</label>

<label><input class="investment-nav" name="investments" type="radio" value=5  />Infrastructure</label>

<label><input class="investment-nav" name="investments" type="radio" value=3  />Social</label>

</td>-->
    
<!-- <td class="investment-form">
<h3 class="ttl3">INVESTMENTS</h3>
<div class="investmentlabel frmDropDown" style="padding: 5px 30px 5px 0px;">
<div>
<label><input class="investment-nav" name="investments" type="radio" value=0  <?php if($VCFlagValue==0) { ?> checked="checked" <?php } ?>/> PE</label>
<label><input class="investment-nav" name="investments" type="radio" value=4  <?php if($VCFlagValue==4) { ?> checked="checked" <?php } ?>/>Cleantech</label>
<label><input class="investment-nav" name="investments" type="radio" value=5  <?php if($VCFlagValue==5) { ?> checked="checked" <?php } ?>/>Infrastructure</label></div>
<label><input class="investment-nav" name="investments" type="radio" value=1  <?php if($VCFlagValue==1) { ?> checked="checked" <?php } ?>/> VC</label>
<label><input class="investment-nav" name="investments" type="radio" value=2  <?php if($VCFlagValue==2) { ?> checked="checked" <?php } ?>/>Angel</label>
<label><input class="investment-nav" name="investments" type="radio" value=6  <?php if($VCFlagValue==6) { ?> checked="checked" <?php } ?> />Incubation</label>
<label><input class="investment-nav" name="investments" type="radio" value=3  <?php if($VCFlagValue==3) { ?> checked="checked" <?php } ?>/>Social</label>



</td> -->
    
    

<!-- <td class="exit-form">
<h3 class="ttl3">EXITS</h3>
<div class="exitslabel frmDropDown">    
<div >

<label><input class="exist-nav" name="investments" type="radio" value="PE-EXIST" <?php if($VCFlagValue=="0-0") { ?> checked="checked" <?php } ?>/>M&A(PE) </label>
<label><input class="exist-nav" name="investments" type="radio" value="PMS" <?php if($VCFlagValue=="0-1") { ?> checked="checked" <?php } ?>/> Public Market(PE)</label>
<label><input class="exist-nav" name="investments" type="radio" value="PE-BACKED-IPO" <?php if($VCFlagValue=="7") { ?> checked="checked" <?php } ?>/>IPO(PE)</label>
<label><input class="exist-nav" name="investments" type="radio" value="VC-EXIST" <?php if($VCFlagValue=="1-0") { ?> checked="checked" <?php } ?>/>M&A(VC) </label>
<label><input class="exist-nav" name="investments" type="radio" value="VMS" <?php if($VCFlagValue=="1-1") { ?> checked="checked" <?php } ?>/> Public Market(VC)</label>
<label><input class="exist-nav" name="investments" type="radio" value="VC-BACKED-IPO" <?php if($VCFlagValue=="8") { ?> checked="checked" <?php } ?>/>IPO(VC)</label>
</div>
</div>

</td> -->
    
        
<td class="vertical-form">    
<h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> Incubation</h3>
<div style="float: right;" class="sort-by-date">
<?php 
    // if($_POST['year1']!='')
    //     {
    //         $year1 = $_POST['year1'];
    //     }
    //     if($_POST['year2']!='')
    //    {
    //        $year2 = $_POST['year2'];
    //    }
    //     if($_POST['month1']!='')
    //    {
    //        $month1 = $_POST['month1'];
    //    }
    //     if($_POST['month2']!='')
    //    {
    //        $month2 = $_POST['month2'];
    //    }
    //     $getdt1 =  $year1."-".$month1."-01";
    //     $getdt2 =  $year2."-".$month2."-31";   
    //     $sdatevalueDisplay1 = returnMonthname($month1) ." ".date('y', strtotime($getdt1));
    //    $edatevalueDisplay2 = returnMonthname($month2) ."  ".date('y', strtotime($getdt2));
?>
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
		$yearsql="select distinct DATE_FORMAT( date_month_year, '%Y') as Year from incubatordeals  order by date_month_year desc";
		if($yearSql=mysql_query($yearsql))
		{
			/*While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$id = $myrow["Year"];
				$name = $myrow["Year"];
				$isselected = ($year1==$id) ? 'SELECTED' : '';
				echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
			}	*/
                        $currentyear = date("Y");
                        $i=$currentyear;
                        While($i>= 1998 )
                        {
                            $id = $i;
                            $name = $i;
                            $isselected = ($year1==$id) ? 'SELECTED' : '';
                            echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                        $i--;
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

<SELECT NAME="year2" id="year2" onchange="checkForDate();" id='year2'>
    <OPTION id=2 value=""> Year </option>
    <?php 
		$yearsql="select distinct DATE_FORMAT( date_month_year, '%Y') as Year from incubatordeals order by date_month_year desc";
		if($yearSql=mysql_query($yearsql))
		{
			/*While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$id = $myrow["Year"];
				$name = $myrow["Year"];
				$isselcted = ($year2== $id) ? 'SELECTED' : '';
				echo "<OPTION id=". $id. " value='". $id."' ".$isselcted.">".$name."</OPTION>\n";
			}	*/
                        $currentyear = date("Y");
                        $i=$currentyear;
                        While($i>= 1998 )
                        {
                        $id = $i;
                        $name = $i;
                        $isselected = ($year2==$id) ? 'SELECTED' : '';
                        echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                        $i--;
                        }
		}
	?> 
</SELECT>
</div>

<div class="search-btn"> <input name="searchpe" type="submit" value="Search" class="datesubmit" id="datesubmit"/></div>
</div>
</td>

</tr>
</table>
</div>
<script>

     $("#investmentspe").hide();  
     $("#investmentsvc").show();
      $("#invspecialisedsocial").show();
     $("#investmentsspecialised").hide();

        $('#investmentswitch').change(function() {
        thisvalue= $(this).val();
        if(thisvalue=="investmentspe")
        {
        $("#investmentspe").show();  
        $("#investmentsvc").hide();
        $("#investmentsspecialised").show();
        $("#invspecialisedsocial").hide();
        }
        else {
        $("#investmentspe").hide();  
        $("#investmentsvc").show();
        $("#invspecialisedsocial").show();
        $("#investmentsspecialised").hide();
        }
    });
	
	
        $('#exitswitch').change(function() { 
             thisvalue= $(this).val();
        if(thisvalue=="1")
        {
            $("#exitsviape").show();  
            $("#exitsviavc").hide();
        }
        else{ 
            $("#exitsviape").hide();  
            $("#exitsviavc").show();
        }
        });	

         $('#investmentswitch').change(function(event){
       
       navvalue=$(this).val();
       switch(navvalue)
       {
           case 'investmentspe':
                    var hrefval = 'index.php?value=0';
                    window.location.href = hrefval;
//                  $("#pesearch").attr("action", hrefval);
//                  $("#pesearch").submit();
                    return false;
                    break;
           case 'investmentsvc':
                    var hrefval = 'index.php?value=1';
                    window.location.href = hrefval;
//                    $("#pesearch").attr("action", hrefval);
//                    $("#pesearch").submit();
                    return false;
                    break;
            
       }
    });
    
    $('#exitswitch').change(function(event){
       
       navvalue=$(this).val();
       switch(navvalue)
       {
           case '1':
                window.location.href = 'mandaindex.php?value=0-0';
                break;
           case '0':
                window.location.href = 'mandaindex.php?value=1-0';
                break;
            
       } 

    });
// available options:
// 
// .switchify()
// => default (builds new switch widget)
// .switchify('update')
// => update the cached position of the widget
// .switchify({ on: "1", off: "0" })
// => specify the vals for "on" and "off"

    <?php if($_SESSION['peonly']==1){ ?>
          $(document).ready(function(){  
          $("#investmentsvc").hide();                
          $("#investmentsspecialised").show();
          $("#investmentspe").show();
          });
   <?php } 
   else if($_SESSION['vconly']==1){ ?>
                $(document).ready(function(){  
                $("#investmentspe").hide();                
                $("#investmentsspecialised").hide();
                $("#investmentsvc").show();
                });
   <?php } ?> 
   $( document ).ready( function() {
      meta();
    });
    function meta() {
      if( $(window).width() < 768 ) {
        $("meta[name='viewport']").attr("content", "width=device-width, initial-scale=0");
      }
      else {
         $("meta[name='viewport']").attr("content", "width=device-width, initial-scale=1.0"); 
      }
    }        

 $("#fliter_stage").click(submitSearchRemove);
               
    $('#searchallfield').on('keyup', function(e){
        if(e.which == 13) {
            e.preventDefault();
            $("#fliter_stage").trigger('click');
        }

    });

    function submitSearchRemove(){

          $('#hide_company_array').val('');
        $('#pe_checkbox_disbale').val('');
        $('#pe_checkbox_enable').val('');
        $('#all_checkbox_search').val('');

        $('#total_inv_deal').val('');
        $('#total_inv_company').val('');

        $('#real_total_inv_deal').val('');
        $('#real_total_inv_company').val('');
        this.form.submit();
    }
    $(".ttl3").click(function() {
        $(this).toggleClass('active').next('.frmDropDown').toggleClass("active");
     });
</script> 