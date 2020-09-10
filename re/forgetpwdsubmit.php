<?php
include "../onlineaccount.php";
$pwdemail=$_POST['forgotpwdemailid'];
$pwdForDB=$_POST['txtpwdforDB'];
$displayMessage="";
require_once("reconfig.php");
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
if(trim($pwdemail)!="")
{
	$checkForUnknownLoginSql="select * from dealmembers where EmailId='$pwdemail'";
	if($rsRandom=mysql_query($checkForUnknownLoginSql))
	{
		$random_cnt= mysql_num_rows($rsRandom);
	}
	//echo "<br>----" .$random_cnt;
	if($random_cnt==1)
	{
		if($pwdForDB=="P")
			$DBPwd= "PE";
		elseif($pwdForDB=="M")
			$DBPwd="M&A";
		elseif($pwdForDB=="R")
			$DBPwd="Real Estate";
		$displayMessage=$forgotpwdMessage;
		$headers  = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html;
		charset=iso-8859-1;Content-Transfer-Encoding: 7bit\n";

		/* additional headers
		$headers .= "Cc: sow_ram@yahoo.com\r\n"; */

		$RegDate=date("M-d-Y");
		$to="arun.natarajan@gmail.com,subscription@ventureintelligence.in";
                $subject="Send Pwd to -" .$pwdemail ;
		$message="<html><center><b><u>Password has to be sent to</u></b></center><br>
		<head>
		</head>
		<body>$DBPwd Password has to be sent to - $pwdemail
					</body>
				 	</html>";
		mail($to,$subject,$message,$headers);
	}
	else
	{
		$displayMessage=$UnauthorisedLoginMessage;

	}
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<title>Venture Intelligence</title>
<link href="<?php echo $refUrl; ?>css/skin.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" type="text/css" href="<?php echo $refUrl; ?>css/detect800.css" />

<!--<script src="http://code.jquery.com/jquery-1.9.1.js"></script> 

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
 
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


<script src="js/jPages.js"></script>
<script src="js/jquery.icheck.min.js?v=0.9.1"></script>-->
<!--<link rel="stylesheet" href="/resources/demos/style.css" /> -->

<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery-1.8.2.min.js"></script> 
<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.tablesorter.js"></script>
<script src="<?php echo $refUrl; ?>js/jPages.js"></script>

<script src="<?php echo $refUrl; ?>js/jquery.icheck.min.js?v=0.9.1"></script>




<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo $refUrl; ?>/resources/demos/style.css" />

<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.multiselect.js"></script> 
  
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
	  previous : "â†? Previous",
	  next : "Next â†’",
	  perPage : 20,
	  delay : 20
	});
});

/*$(function(){
	$("#myTable").tablesorter(); 
	$("div.holder").jPages({
	  containerID : "movies",
	  previous : "â†? Previous",
	  next : "Next â†’",
	  perPage : 20,
	  delay : 20
	});
});*/
 
$(document).ready(function(){
 
  $('input').iCheck({
	checkboxClass: 'icheckbox_flat-red',
	radioClass: 'iradio_flat-red'
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


</script>

<SCRIPT LANGUAGE="JavaScript">
function checkFields()
 {
  	if((document.forgotpwd.forgotpwdemailid.value == "") )
    {
		alert("Please enter your Email Id");
		return false
 	}
}
</SCRIPT>
</head>

<body> 
 
<!--Header-->

<div class="login-screen">

<div class="header"><img src="<?php echo $refUrl; ?>images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></div>


<div class="login-cnt">

    <ul>
  
        
            <li><?php echo $displayMessage; ?> <a href="../relogin.php">Login >></a></li>            
        
    </ul>

</div>

</body>
</html>
<?php  mysql_close();   ?>




