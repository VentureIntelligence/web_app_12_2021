<?php 
 require_once("../dbconnectvi.php");
 $Db = new dbInvestments();
 if(!isset($_SESSION['UserNames']))
 {
     header('Location:../pelogin.php');
 }
 else
 {?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Private Equity Deal Database</title>
<link href="css/skin.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" type="text/css" href="css/detect800.css" />

<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script src="js/jPages.js"></script>

<script src="js/jquery.icheck.min.js?v=0.9.1"></script>
<script type="text/javascript" src="js/popup.js"></script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />

<script type="text/javascript" src="js/jquery.multiselect.js"></script> 
<script type="text/javascript" src="js/expand.js"></script>
<script src="js/showHide.js" type="text/javascript"></script>     

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
	var advisorsearch_legalbox = $("#advisorsearch_legal").combobox();
	var advisorsearch_transbox = $("#advisorsearch_trans").combobox();
        var sectorsearchbox = $("#sectorsearch").combobox();
        
           keywordsearchbox.on( "comboboxselect", function( event, ui ) {
           companysearchbox.combobox("destroy") ;
           advisorsearch_legalbox.combobox("destroy") ;
           advisorsearch_transbox.combobox("destroy") ;
           sectorsearchbox.combobox("destroy") ; 
           $("#combobox option:eq(0)").attr('selected','selected');
           $("#advisorsearch_legal option:eq(0)").attr('selected','selected');
           $("#advisorsearch_trans option:eq(0)").attr('selected','selected');
           $("#sectorsearch option:eq(0)").attr('selected','selected');
           companysearchbox.combobox() ;
           advisorsearch_legalbox.combobox() ;
           advisorsearch_transbox.combobox() ;
           sectorsearchbox.combobox() ; 
        } );
       companysearchbox.on( "comboboxselect", function( event, ui ) {
           keywordsearchbox.combobox("destroy") ;
           advisorsearch_legalbox.combobox("destroy") ;
           advisorsearch_transbox.combobox("destroy") ;
           sectorsearchbox.combobox("destroy") ; 
           $("#keywordsearch option:eq(0)").attr('selected','selected');
           $("#advisorsearch_legal option:eq(0)").attr('selected','selected');
           $("#advisorsearch_trans option:eq(0)").attr('selected','selected');
           $("#sectorsearch option:eq(0)").attr('selected','selected');
           keywordsearchbox.combobox() ;
           advisorsearch_legalbox.combobox() ;
           advisorsearch_transbox.combobox() ;
           sectorsearchbox.combobox() ; 
        } );
         sectorsearchbox.on( "comboboxselect", function( event, ui ) {
           keywordsearchbox.combobox("destroy") ;
           companysearchbox.combobox("destroy") ;
           advisorsearch_legalbox.combobox("destroy") ;
           advisorsearch_transbox.combobox("destroy") ; 
           $("#combobox option:eq(0)").attr('selected','selected');
           $("#advisorsearch_legal option:eq(0)").attr('selected','selected');
           $("#advisorsearch_trans option:eq(0)").attr('selected','selected');
           $("#sectorsearch option:eq(0)").attr('selected','selected');
           keywordsearchbox.combobox() ;
           companysearchbox.combobox() ;
           advisorsearch_legalbox.combobox() ;
           advisorsearch_transbox.combobox() ;
        } );
       advisorsearch_legalbox.on( "comboboxselect", function( event, ui ) {
           keywordsearchbox.combobox("destroy") ;
           companysearchbox.combobox("destroy") ;
           advisorsearch_transbox.combobox("destroy") ;
           sectorsearchbox.combobox("destroy") ; 
           $("#keywordsearch option:eq(0)").attr('selected','selected');
           $("#combobox option:eq(0)").attr('selected','selected');
           $("#advisorsearch_trans option:eq(0)").attr('selected','selected');
           $("#sectorsearch option:eq(0)").attr('selected','selected');
           keywordsearchbox.combobox() ;
           companysearchbox.combobox() ;
           advisorsearch_transbox.combobox() ;
           sectorsearchbox.combobox() ; 
        } );
         advisorsearch_transbox.on( "comboboxselect", function( event, ui ) {
           keywordsearchbox.combobox("destroy") ;
           companysearchbox.combobox("destroy") ;
           advisorsearch_legalbox.combobox("destroy") ;
           sectorsearchbox.combobox("destroy") ; 
            $("#keywordsearch option:eq(0)").attr('selected','selected');
           $("#combobox option:eq(0)").attr('selected','selected');
           $("#advisorsearch_legal option:eq(0)").attr('selected','selected');
           $("#sectorsearch option:eq(0)").attr('selected','selected');
           keywordsearchbox.combobox() ;
           companysearchbox.combobox() ;
           advisorsearch_legalbox.combobox() ;
           sectorsearchbox.combobox() ; 
        } );
	
        $("#resetall").click(function (){
           keywordsearchbox.combobox("destroy") ;
           companysearchbox.combobox("destroy") ;
           advisorsearch_legalbox.combobox("destroy") ;
           advisorsearch_transbox.combobox("destroy") ;
           sectorsearchbox.combobox("destroy") ; 
           
           $("#keywordsearch option:eq(0)").attr('selected','selected');
           $("#combobox option:eq(0)").attr('selected','selected');
           $("#advisorsearch_legal option:eq(0)").attr('selected','selected');
           $("#advisorsearch_trans option:eq(0)").attr('selected','selected');
           $("#sectorsearch option:eq(0)").attr('selected','selected');
           
           keywordsearchbox.combobox();
           companysearchbox.combobox() ;
           advisorsearch_legalbox.combobox() ;
           advisorsearch_transbox.combobox() ;
           sectorsearchbox.combobox() ; 
        });
    
	/*$( ".custom-combobox" ).autocomplete({
	  change: function( event, ui ) { this.form.submit(); }
	});*/
        
        
 
        
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
	$("#myTable").tablesorter({widthFixed: true}); 
	$("div.holder").jPages({
	  containerID : "movies",
	  previous : "�? Previous",
	  next : "Next →",
	  perPage : 50,
	  delay : 20
	});
});

/*$(function(){
	$("#myTable").tablesorter(); 
	$("div.holder").jPages({
	  containerID : "movies",
	  previous : "�? Previous",
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
                   window.location.href = 'index.php?value='+$(this).val();
                    break;
           case '1':
                    window.location.href = 'index.php?value='+$(this).val();
                    break;
           case '2':
                   window.location.href = 'angelindex.php';
                   break;
           case '3':
                    var hrefval = 'svindex.php?value='+$(this).val();
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                   //window.location.href = 'svtrendview.php?value='+$(this).val();
                   break;
           case '4':
                   var hrefval = 'svindex.php?value='+$(this).val();
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    // window.location.href = 'svindex.php?value='+$(this).val();
                    break;
           case '5':
                    var hrefval = 'svindex.php?value='+$(this).val();
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    //window.location.href = 'svtrendview.php?value='+$(this).val();
                   break;
            case '6':
                   window.location.href = 'incindex.php';
                   break;
            
       }
       

});

$('.typeoff-nav').on('ifChecked', function(event){
     
     var value = $(this).val();
      if (value == 1) {
        window.location.assign("svindex.php?type=1");
    }
    else if (value == 2) {
        window.location.assign("svindex.php?type=2");
    }
    else if (value == 3) {
        window.location.assign("svindex.php?type=3");
    }
    else if (value == 4) {
        window.location.assign("svindex.php?type=4");
    }
    else if (value == 5) {
        window.location.assign("svindex.php?type=5");
    }
    else if (value == 6) {
        window.location.assign("svindex.php?type=6");
    }
});

 $('.exist-nav').on('ifChecked', function(event){
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
           case 'PE-EXIST':
                   window.location.href = 'mandaindex.php?value=0-0';
                   break;
           case 'VC-EXIST':
                   window.location.href = 'mandaindex.php?value=1-0';
                   break;
               
       }
       

});

});


</script>

   <script type="text/javascript">
$(function(){
	$(".selectgroup select").multiselect();
});
$(function () {
            $('.expander').simpleexpand();
            prettyPrint();
        });
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
jQuery('#preloading').fadeOut(3000);
jQuery('#maskscreen').fadeOut(3000);
});
</script>
    <?php 
     $defpage=$VCFlagValue."";
     include_once('definitions.php');?>
 <?php 
$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        //echo "<br>*".$value;
        $strvalue = explode("/", $value);
        //$SelCompRef=$strvalue[0];
        //$pe_re=$strvalue[1];
        if(sizeof($strvalue)>1)
        {   
            $vcflagValue=$strvalue[1];
            $VCFlagValue=$strvalue[1];
        }
        else
        {
                $vcflagValue=$value;
            $VCFlagValue=$value;
        }
        
        if($VCFlagValue==3)
        {
          $dbtype='SV';
          $pagetitle="Social Venture Investments -> Search";
          $showallcompInvFlag=8;
          $stagesql_search =  "SELECT DISTINCT pe.StageId, Stage
                              FROM peinvestments AS pe, peinvestments_dbtypes AS pedb, stage AS s
                              WHERE pedb.PEId = pe.PEId
                              AND pe.Deleted =0
                              AND pedb.DBTypeId = '$dbtype'
                              AND s.StageId = pe.StageId
                              ORDER BY DisplayOrder";
       }
       elseif($VCFlagValue==4)
        {
          $dbtype='CT';
          $showallcompInvFlag=9;
          $pagetitle="Cleantech Investments -> Search";
          $stagesql_search="select StageId,Stage from stage order by DisplayOrder";
        }
        elseif($VCFlagValue==5)
        {
          $dbtype='IF';
          $showallcompInvFlag=10;
          $pagetitle="Infrastructure Investments -> Search";
          $stagesql_search="select StageId,Stage from stage order by DisplayOrder";
        }

       $getTotalQuery= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
            FROM peinvestments AS pe, stage AS s ,pecompanies as pec,peinvestments_dbtypes as pedb
            WHERE  pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and
            pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0";


        $industrysql_search="select distinct pec.industry,i.Industry from industry as i ,pecompanies as pec,
            peinvestments as pe,peinvestments_dbtypes as pedb
            where i.IndustryId !=15 and pedb.PEId=pe.PEId and pec.PECompanyId=pe.PECompanyId and pe.Deleted=0
            and i.IndustryId=pec.Industry and pedb.DBTypeId='$dbtype' order by i.Industry";
?>
<!--Header-->
<form name="searchall" id="searchall" action="" method="post">
<div id="header">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="left-box"> <div class="logo-img"> <a href="#"><img src="images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></td>


<td class="right-box">
<ul>
<li><a href="javascript:;"><i class="i-dashboard"></i>Dashboard</a></li>
<li <?php echo ($topNav=='Deals') ? 'class="active"' : '' ; ?>><a href="index.php"><i class="i-data-deals"></i>Deals</a></li>
<li <?php echo ($topNav=='Directory') ? 'class="active"' : '' ; ?>><a href="pedirview.php?value=0"><i class="i-directory"></i>Directory</a></li>
<li <?php echo ($topNav=='Funds') ? 'class="active"' : '' ; ?>><a href="funds.php"><i class="i-directory"></i>Funds <span class="betaversion">Beta</span></a></li>
</ul>
<ul class="fr">
<li class="search-box">
	<input  autofocus="autofocus" type="text" name="searchallfield" placeholder=" Keyword Search" <?php if($searchallfield!="") echo "value=".$searchallfield ;?> /> 
</li>
<li class="user-avt"><span class="example" data-dropdown="#myaccount">Welcome <?php echo $_SESSION['UserNames']; ?></span> 
<div id="myaccount" class="dropdown">
		<ul class="dropdown-menu">
			<li><a href="javascript:;">Tutorial</a></li>
			<li><a href="changepassword.php?value=P">Change Password</a></li>
            <li><a href="logoff.php?value=P">Logout</a></li>
            <li><a href="logoff.php?value=P"></a></li> 
		</ul>
	</div></li>
</ul>
<!--<ul class="fr">
<li ><div style="float:right;padding: 15px" class="key-search"><b></b> 
<input  autofocus="autofocus" type="text" name="searchallfield" placeholder=" Keyword Search" <?php if($searchallfield!="") echo "value=".$searchallfield ;?> style="padding:5px;"/> 
        <input type="button" name="fliter_stage" value="Go" onclick="this.form.submit();" style="padding: 5px;"/>
    </div></li>
<li class="logout"><a href="logoff.php?value=P"><i class="i-logout"></i>Logout</a></li>
</ul>-->
</td>
</tr>
</table>

</div>
</form>
<form name="pesearch" id="pesearch" action="" method="post">


<div id="sec-header">
<table cellpadding="0" cellspacing="0">
<tr>

 
<td class="investment-form">
<h3>INVESTMENTS</h3>
<label><input class="investment-nav" name="investments" type="radio" value='0' <?php if($vcflagValue==0) { ?> checked="checked" <?php } ?> /> PE</label>

<label><input class="investment-nav" name="investments" type="radio" value=1 <?php if($vcflagValue==1) { ?> checked="checked" <?php } ?> /> VC</label>

<label><input class="investment-nav" name="investments" type="radio" value=2 <?php if($vcflagValue==2) { ?> checked="checked" <?php } ?> />Angel</label>

<label><input class="investment-nav" name="investments" type="radio" value=6 <?php if($vcflagValue==6) { ?> checked="checked" <?php } ?> />Incubation</label>

<label><input class="investment-nav" name="investments" type="radio" value=4 <?php if($vcflagValue==4) { ?> checked="checked" <?php } ?> />Cleantech</label>

<label><input class="investment-nav" name="investments" type="radio" value=5 <?php if($vcflagValue==5) { ?> checked="checked" <?php } ?> />Infrastructure</label>

<label><input class="investment-nav" name="investments" type="radio" value=3 <?php if($vcflagValue==3) { ?> checked="checked" <?php } ?> />Social</label>

</td>



<td class="exit-form">
<h3>EXITS VIA</h3>

<label><input class="exist-nav" name="investments" type="radio" value="PE-BACKED-IPO" />IPO(PE)</label>

<label><input class="exist-nav" name="investments" type="radio" value="VC-BACKED-IPO" />IPO(VC)</label>

<label><input class="exist-nav" name="investments" type="radio" value="PMS" /> Public Market</label>

<label><input class="exist-nav" name="investments" type="radio" value="PE-EXIST" />M&A(PE) </label>

<label><input class="exist-nav" name="investments" type="radio" value="VC-EXIST" />M&A(VC) </label>


</td>




<td class="vertical-form ">
<h3>PERIOD</h3>

<div class="period-date">
<label>From</label>
<SELECT NAME="month1">
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


<SELECT NAME="year1"  onchange="this.form.submit();">
    <OPTION id=2 value="--"> Year </option>
    <?php 
		$yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates asc";
		if($yearSql=mysql_query($yearsql))
		{
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
<SELECT NAME="month2">
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

<SELECT NAME="year2" onchange="this.form.submit();">
    <OPTION id=2 value="--"> Year </option>
    <?php 
		$yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates asc";
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

<div class="search-btn"> <input name="searchpe" type="submit" value="Search" /></div>
</td>



 
 
</tr>
</table>
</div>
<?php } ?>