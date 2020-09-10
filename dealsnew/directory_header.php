<?php  $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '0';
        $strvalue = explode("/", $value);
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
        
        
        $search= isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
        $totalCount=0;
        
        $keyword= $_POST['keywordsearch'];
        $industry=$_POST['industry'];
        $stageval=$_POST['stage'];
        if($_POST['stage'])
        {
                $boolStage=true;
                //foreach($stageval as $stage)
                //	echo "<br>----" .$stage;
        }
        else
        {
                $stage="--";
                $boolStage=false;
        }
        $investorType=$_POST['invType'];
        $startRangeValue=$_POST['invrangestart'];
        $endRangeValue=$_POST['invrangeend'];
        $endRangeValueDisplay =$endRangeValue;
                //echo "<bR>---" .$startRangeValue;
                //echo "<bR>***".$endRangeValue;

        $whereind="";
        //$whereregion="";
        $whereinvType="";
        $wherestage="";
        $wheredates="";
        $whererange="";
        $month1=($_POST['month1']) ?  $_POST['month1'] : date('n', strtotime(date('Y-m')." -2	 month")); ;
        $year1 = ($_POST['year1']) ?  $_POST['year1'] : date('Y');
        $month2=($_POST['month2']) ?  $_POST['month2'] : date('n');
        $year2 = ($_POST['year2']) ?  $_POST['year2'] : date('Y');


        $datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
        $splityear1=(substr($year1,2));
        $splityear2=(substr($year2,2));

        if(($month1!="") && ($month2!=="") && ($year1!="") &&($year2!=""))
        {	$datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
                $datevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
                $wheredates1= "";
        }

        $searchString="Undisclosed";
        $searchString=strtolower($searchString);

        $searchString1="Unknown";
        $searchString1=strtolower($searchString1);

        $searchString2="Others";
        $searchString2=strtolower($searchString2);
                        
        if($vcflagValue==0)
          {

                  $addVCFlagqry="";
                  $checkForStage = ' && ('.'$stage'.' =="")';
                  //$checkForStage = " && (" .'$stage'."=='--') ";
                  $checkForStageValue = " || (" .'$stage'.">0) ";
                  $searchTitle = "List of PE Investors ";

          }
          elseif($vcflagValue==1)
          {
                  $addVCFlagqry="";
                  $addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
                  $checkForStage = '&& ('.'$stage'.'=="") ';
                  //$checkForStage = " && (" .'$stage'."=='--') ";
                  $checkForStageValue =  " || (" .'$stage'.">0) ";
                  $searchTitle = "List of VC Investors ";
                  //	echo "<br>Check for stage** - " .$checkForStage;
          }
        
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

        if($boolStage==true)
        {
                foreach($stageval as $stageid)
                {
                        $stagesql= "select Stage from stage where StageId=$stageid";
                //	echo "<br>**".$stagesql;
                        if ($stagers = mysql_query($stagesql))
                        {
                                While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH))
                                {
                                        $stagevaluetext= $stagevaluetext. ",".$myrow["Stage"] ;
                                }
                        }
                }
                $stagevaluetext =substr_replace($stagevaluetext, '', 0,1);
        }
        else
        {
                $stagevaluetext="";

                if($investorType !="")
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
        }
        //echo "<br>*************".$stagevaluetext;
        if($companyType=="L")
                $companyTypeDisplay="Listed";
        elseif($companyType=="U")
                $companyTypeDisplay="UnListed";
        elseif($companyType=="--")
                $companyTypeDisplay="";

        
        ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Venture Intelligence</title>
<link href="css/skin.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" type="text/css" href="css/detect800.css" />

<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script src="js/jPages.js"></script>

<script src="js/jquery.icheck.min.js?v=0.9.1"></script>

<script type="text/javascript" src="js/popup.js"></script>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />

<script type="text/javascript" src="js/jquery.multiselect.js"></script> 
  
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

 $('.section-nav').on('ifChecked', function(event){
       
 navvalue=$(this).val();
       switch(navvalue)
       {
           case '0':
                   window.location.href = 'pedirview.php?value='+$(this).val();
                   break;
           case '1':
                   window.location.href = 'pedirview.php?value='+$(this).val();
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
</script>
</head>

<body> 
    <?php include_once('definitions.php');?>
<!--Header-->
<form name="pesearch" id="pesearch" action="pedirview.php?value=<?php echo $vcflagValue; ?>" method="post">
<div id="header">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="left-box"> <div class="logo-img"> <a href="#"><img src="images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></td>


<td class="right-box">
<ul>
<li><a href="javascript:;"><i class="i-dashboard"></i>Dashboard</a></li>
<li <?php echo ($topNav=='Deals') ? 'class="active"' : '' ; ?>><a href="index.php"><i class="i-data-deals"></i>Data/Deals</a></li>
<li <?php echo ($topNav=='Directory') ? 'class="active"' : '' ; ?>><a href="pedirview.php?value=0"><i class="i-directory"></i>Directory</a></li>
<li class="logout"><a href="logoff.php?value=P"><i class="i-logout"></i>Logout</a></li>
</ul>
</td>
</tr>
</table>

</div>

<div id="sec-header" class="sec-header-fix dealsindex">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="left-box">

<h3>Welcome <span><?php echo $_SESSION['UserNames']; ?></span></h3>
<p>last login - <?php echo $_SESSION['LoginTime']; ?> hrs</p>

<div class="links"><a href="changepassword.php?value=P" class="fl">Change Password</a>        <!--<a href="#popup1" class="fr">Definition</a>--></div> 
    
</td>
    
<td class="exit-form">
<h3>EXITS</h3>

<label><input class="section-nav" name="investments" type="radio" value="0" <?php if($vcflagValue==0) { ?> checked="checked" <?php } ?>/>PE Directory    </label>

<label><input class="section-nav" name="investments" type="radio" value="1" <?php if($vcflagValue==1) { ?> checked="checked" <?php } ?>/>VC Directory     </label>

</td>




<!--td class="vertical-form">
<h3>VERTICAL</h3>
<label> 

	<select name="industry">
		<OPTION id=0 value="--" selected> Select an Industry </option>
		<?php
                
                        
                
			if ($industryrs = mysql_query($industrysql))
			{
			 $ind_cnt = mysql_num_rows($industryrs);
			}
			if($ind_cnt>0)
			{
				 While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
				{
					$id = $myrow[0];
					$name = $myrow[1];
					$isselected = ($_POST['industry']==$id) ? 'SELECTED' : '';
					echo "<OPTION id=".$id. " value=".$id." ".$isselected.">".$name."</OPTION> \n";
				}
				mysql_free_result($industryrs);
			}
    	?>
    </select>
</label>

</td>


<td class="search-btn"> <input name="searchpe" type="submit" value="Search" /></td-->
 
 
</tr>
</table>
</div>
