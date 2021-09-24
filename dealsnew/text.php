

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
<title>Venture Intelligence</title>
<link href="css/skin.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" type="text/css" href="css/detect800.css" />
<link rel="stylesheet" type="text/css" href="css/token-input.css" />
<link rel="stylesheet" type="text/css" href="css/token-input-facebook.css" />
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/popup.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
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
//	  previous : "�? Previous",
//	  next : "Next →",
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

<body > 
     <div id="maskscreen" ></div>
<div id="preloading"></div>
<script type="text/javascript" >
$('#maskscreen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
jQuery(window).load(function(){
jQuery('#preloading').fadeOut(1000);
jQuery('#maskscreen').fadeOut(1000);
});
</script>
    <style>.popup ol li{
    list-style-type: decimal; }
#lepopup-wrap{
    top:170px !important;
}</style>
<style>
    /* .tagSearch{
        padding: 5px 15px;
        font-size: 12px;
        font-weight: bold;
        background: #000;
        color: #fff;
        line-height: 35px;
        border-radius: 25px;
        margin-left: 5px;
        margin-right: 5px;
        white-space: nowrap;
        box-shadow: 2px 1px 2px 2px #ccc;
    }
    .sub-tag {
        font-weight: bold;
        font-size: 15px;
        text-align: center;
        text-transform: uppercase;
        margin-bottom:2px;
    }
    .helplineTag {
        float: right;
        padding-right: 5%;
        padding-bottom: 2%;
    } */
.listitem_ascolun{
    -webkit-column-width: 150px;
    -moz-column-width: 150px;
    -o-column-width: 150px;
    -ms-column-width: 150px;
    column-width: 150px;
    /* -webkit-column-rule-style: solid; */
    -moz-column-rule-style: solid;
    -o-column-rule-style: solid;
    -ms-column-rule-style: solid;
    /* column-rule-style: solid; */
}
.sub-tag {
    display: block;
    border-bottom: 1px solid;
    padding: 10px;
    text-align: center;
    margin:0px;
    font-weight: bold;
    font-size: 15px;
}
#popup6 ul.def-list {
    border: 1px solid;
    padding: 0;
    margin:2% 0 4% auto;
}
#popup6 ul.def-list li {
    padding: 0 8px;
    line-height: 30px;
   
}
.helplineTag {
        padding-right: 5%;
        padding-bottom: 2%;
}

.overlaydiv{
    position: absolute;
    /*left: 322.5px;
    top: 170px !important;*/
    min-width: 400px;
     display: none; 
    z-index: 100031;
    background-color: #fff;
    padding: 30px;
    padding-right: 0px;
        border-radius: 5px;
        top: 25%;
    left: 50%;
    margin-left: -400px; 
    margin-top: -40px; 
}

.overlayshowdow{
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background-color: #000000;
    zoom: 1 !important;
    filter: alpha(opacity=70) !important;
    opacity: 0.7 !important;
    display: none;
    z-index: 10000;
}
.overlayinner{
    height: 500px;
    overflow: auto;
    margin-top: 35px;

}
.close{
    background-image: url(../dealsnew/images/sprite-close.png);
    background-repeat: no-repeat;
    background-position: 0px -14px;
    width:15px;
    height: 15px;
    position: absolute;
        cursor: pointer;
            right: 2%;
}
.overlayheader{
position: absolute;
    left: 0;
    right: 0;
    padding: 20px 30px;
    top: 1%;
    background: #fff;
}
.tagpopup{
    cursor: pointer;
}
</style>
    <div id="popup4" style="width:800px;display: none;" class="popup">

    <h4>For the purpose of this database, the Industries included are:</h4>
    <ul class="def-list">
        <li>Energy (excluding equipment makers)</li>
        <li> Engg. & Construction</li>
        <li>Shipping & Logistics</li>
        <li> Mining & Minerals</li>
        <li> Telecom (excluding equipment vendors and VAS providers)</li>
        <li> Travel & Transport (excluding travel agencies, portals, etc.)</li>
        </ul>
    <p>At this point, we have NOT included Education, Healthcare and Hotels & Resorts in this database.</p>
</div>
 
<div class="overlayshowdow"></div>
<div class="overlaydiv">
    
<div class="overlayinner">
<div id="popup6" style="width:800px;    padding-right: 20px;" >
    <div class="overlayheader">
    <div class="close" title="Close Popup"></div>
    <h3 style="text-align: center;    font-size: 18px;">Tag List</h3>
    </div>
    <ul class="def-list">
        <p class="sub-tag">Industry Tags</p>
        <li class="listitem_ascolun">
             <ul>
                                        
                                <li>advertising</li>
                            
                                          
                                <li>agribiz</li>
                            
                                          
                                <li>auto</li>
                            
                                          
                                <li>bfsi</li>
                            
                                          
                                <li>education</li>
                            
                                          
                                <li>energy</li>
                            
                                          
                                <li>engineering</li>
                            
                                          
                                <li>entertainment</li>
                            
                                          
                                <li>fmcg</li>
                            
                                          
                                <li>food</li>
                            
                                          
                                <li>healthcare</li>
                            
                                          
                                <li>hotels</li>
                            
                                          
                                <li>jewelry</li>
                            
                                          
                                <li>logisitcs</li>
                            
                                          
                                <li>logistics</li>
                            
                                          
                                <li>manufacturing</li>
                            
                                          
                                <li>media</li>
                            
                                          
                                <li>mining</li>
                            
                                          
                                <li>real estate</li>
                            
                                          
                                <li>retail</li>
                            
                                          
                                <li>sports</li>
                            
                                          
                                <li>tech</li>
                            
                                          
                                <li>telecom</li>
                            
                                          
                                <li>textiles</li>
                            
                                          
                                <li>transport</li>
                            
                                          
                                <li>travel</li>
                            
                          </ul>
        </li>
    </ul>
    <ul class="def-list">
        <p class="sub-tag">Sector Tags</p>
        <li class="listitem_ascolun">
            <ul>
                                             <li>3D printing</li>
                                                 <li>ad tech</li>
                                                 <li>aerospace</li>
                                                 <li>agritech</li>
                                                 <li>analytics</li>
                                                 <li>analytics</li>
                                                 <li>artificial intelligence</li>
                                                 <li>b2b</li>
                                                 <li>b2b ecommerce</li>
                                                 <li>banking</li>
                                                 <li>beauty</li>
                                                 <li>big data</li>
                                                 <li>biotech</li>
                                                 <li>blockchain</li>
                                                 <li>bots</li>
                                                 <li>cleantech</li>
                                                 <li>cloud</li>
                                                 <li>consumer</li>
                                                 <li>consumer brand</li>
                                                 <li>CRM</li>
                                                 <li>cryptocurrency</li>
                                                 <li>dating</li>
                                                 <li>deep tech</li>
                                                 <li>deeptech</li>
                                                 <li>defence</li>
                                                 <li>digital media</li>
                                                 <li>ecommerce</li>
                                                 <li>ecommerce enablers</li>
                                                 <li>edtech</li>
                                                 <li>electric</li>
                                                 <li>enterprise</li>
                                                 <li>events</li>
                                                 <li>eye care chain</li>
                                                 <li>fashion</li>
                                                 <li>fintech</li>
                                                 <li>fitness</li>
                                                 <li>foodtech</li>
                                                 <li>gaming</li>
                                                 <li>handyman</li>
                                                 <li>hardware</li>
                                                 <li>healthtech</li>
                                                 <li>HR</li>
                                                 <li>HR tech</li>
                                                 <li>hyperlocal</li>
                                                 <li>insurance</li>
                                                 <li>insurtech</li>
                                                 <li>investment banking</li>
                                                 <li>invit</li>
                                                 <li>iot</li>
                                                 <li>legaltech</li>
                                                 <li>lending</li>
                                                 <li>logistics tech</li>
                                                 <li>medtech</li>
                                                 <li>mobility</li>
                                                 <li>mutual funds</li>
                                                 <li>nanotech</li>
                                                 <li>nbfc</li>
                                                 <li>neo bank</li>
                                                 <li>news</li>
                                                 <li>parenting</li>
                                                 <li>payments</li>
                                                 <li>personal finance</li>
                                                 <li>real estate tech</li>
                                                 <li>recommerce</li>
                                                 <li>regtech</li>
                                                 <li>rental</li>
                                                 <li>roads</li>
                                                 <li>robotics</li>
                                                 <li>saas</li>
                                                 <li>SCM</li>
                                                 <li>security</li>
                                                 <li>social</li>
                                                 <li>social commerce</li>
                                                 <li>solar</li>
                                                 <li>telematics</li>
                                                 <li>testing</li>
                                                 <li>traveltech</li>
                                                 <li>unicorn</li>
                                                 <li>vernacular</li>
                                                 <li>virtual reality</li>
                                                 <li>wallet</li>
                                                 <li>wealth management</li>
                                                 <li>wearables</li>
                                                 <li>wedding</li>
                                                 <li>wind</li>
                            </ul>
        </li>
    </ul>
    <ul class="def-list">
        <p class="sub-tag">Competitor Tags</p>
        <li class="listitem_ascolun">
            <ul>
                                             <li>1mg</li>
                                                 <li>acko</li>
                                                 <li>affordplan</li>
                                                 <li>Ally</li>
                                                 <li>Amul</li>
                                                 <li>antworks</li>
                                                 <li>Aquaconnect</li>
                                                 <li>arcil</li>
                                                 <li>ASG Eye Hospitals</li>
                                                 <li>ather</li>
                                                 <li>Avendus</li>
                                                 <li>bankbazaar</li>
                                                 <li>bigbasket</li>
                                                 <li>billdesk</li>
                                                 <li>blablacar</li>
                                                 <li>Bombay Shaving Company</li>
                                                 <li>bookmyshow</li>
                                                 <li>Browserstack</li>
                                                 <li>Bulbul</li>
                                                 <li>byju</li>
                                                 <li>caratLane</li>
                                                 <li>cars24</li>
                                                 <li>chaayos</li>
                                                 <li>Cleartax</li>
                                                 <li>Clevertap</li>
                                                 <li>CollegeDekho</li>
                                                 <li>Daawat</li>
                                                 <li>deepsource</li>
                                                 <li>delhivery</li>
                                                 <li>Digibank</li>
                                                 <li>dunzo</li>
                                                 <li>Equitas</li>
                                                 <li>Eurokids</li>
                                                 <li>faircent</li>
                                                 <li>firstcry</li>
                                                 <li>Fittr</li>
                                                 <li>flintobox</li>
                                                 <li>flipkart</li>
                                                 <li>FlyRobe</li>
                                                 <li>freshdesk</li>
                                                 <li>freshmenu</li>
                                                 <li>fundsindia</li>
                                                 <li>Grubox</li>
                                                 <li>happay</li>
                                                 <li>homelane</li>
                                                 <li>Hypertrack</li>
                                                 <li>Icertis</li>
                                                 <li>ICICI Bank</li>
                                                 <li>indiraivf</li>
                                                 <li>inshorts</li>
                                                 <li>Jain Irrigation</li>
                                                 <li>ketto</li>
                                                 <li>Khatabook</li>
                                                 <li>kobster</li>
                                                 <li>kredx</li>
                                                 <li>Kurlon</li>
                                                 <li>Lambda School</li>
                                                 <li>lendingkart</li>
                                                 <li>lenskart</li>
                                                 <li>Licious</li>
                                                 <li>madstreetden</li>
                                                 <li>meesho</li>
                                                 <li>Monsanto</li>
                                                 <li>mswipe</li>
                                                 <li>myntra</li>
                                                 <li>naukri</li>
                                                 <li>Nephroplus</li>
                                                 <li>nestaway</li>
                                                 <li>oyo rooms</li>
                                                 <li>paytm</li>
                                                 <li>pepperfry</li>
                                                 <li>placio</li>
                                                 <li>policybazaar</li>
                                                 <li>portea</li>
                                                 <li>power2sme</li>
                                                 <li>practo</li>
                                                 <li>printo</li>
                                                 <li>Procol</li>
                                                 <li>rentomojo</li>
                                                 <li>rivigo</li>
                                                 <li>sahajanand</li>
                                                 <li>setu</li>
                                                 <li>Shopify</li>
                                                 <li>shuttl</li>
                                                 <li>simility</li>
                                                 <li>sks</li>
                                                 <li>slicepay</li>
                                                 <li>smallcase</li>
                                                 <li>Sohan Lal</li>
                                                 <li>Spotify</li>
                                                 <li>storeking</li>
                                                 <li>Swiggy</li>
                                                 <li>Thomas Cook</li>
                                                 <li>thrasio</li>
                                                 <li>tiktok</li>
                                                 <li>tring</li>
                                                 <li>vahdam</li>
                                                 <li>Vogo</li>
                                                 <li>weddingz</li>
                                                 <li>wework</li>
                                                 <li>WhiteHatJr</li>
                                                 <li>zoomcar</li>
                            </ul>
        </li>
    </ul>
</div>
</div>
</div>
<!--Header-->
<form name="searchall" id="searchall" action="incindex.php" method="post">
<div id="header">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="left-box"> <div class="logo-img"> <a href="index.php"><img src="images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></td>

<td class="right-box">
      <style>
	/*Added due to the dashboard*/
.subnav-content{
	left: 350px !important;
}
.subnav-content1,.subnav-content2,.subnav-content5{
left: 538px !important;
}
.subnav-content3,.subnav-content4{
left: 765px !important;
}
/*Added due to the dashboard*/
		.arrow-weight {
			font-weight: bolder;
		}

	
		.arrow-pe-vc {
			margin-left: 4px;
		}

	
        .border-btm-head:after {
			content: "";
			display: block;
			margin: 0 auto;
			width: 86%;
			/* padding-top: 0px; */
			border-bottom: 1px solid #E0D8C3;
            padding-top: 42px;
		}
		.subnav li:hover {
    background-color: #98630a !important;
}

.subnav,.subnav1, .subnav2, .subnav3,, .subnav4, .subnav5 {
  float: left;
  overflow: hidden;
}

.subnav .subnavbtn {
  font-size: 16px;  
  border: none;
  outline: none;
  color: white; 
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}
.subnav li:hover i, .active.subnav li i{
    color:#fff;
}
.navbar a:hover, .subnav:hover .subnavbtn {
  background-color: red;
}
.subnav:hover .subnav-content {
  display: grid;
}
.subnav li a{
  font-size:14px !important;
}
.subnav-content {
  /* display: none;
  position: absolute;
  left: 0;
  background-color: red;
  width: 100%;
  z-index: 1; */
  display: none;
    position: fixed;
    background-color: #413529;
    width: auto;
    z-index: 999;
    top: 45px;
    left: 232px;
}
.subnav1:hover .subnav-content1 {
  display: grid;
}
.subnav2:hover .subnav-content2 {
  display: grid;
}
.subnav3:hover .subnav-content3 {
  display: grid;
}
.subnav4:hover .subnav-content4 {
  display: grid;
}
.subnav5:hover .subnav-content5 {
  display: grid;
}
.subnav-content1 {
  /* display: none;
  position: absolute;
  left: 0;
  background-color: red;
  width: 100%;
  z-index: 1; */
  /* display: none; */
  display: none;
  position: fixed;
    background-color: #413529;
    width: auto;
    z-index: 999;
    top: 45px;
    left: 420px;
    border-left: 1px solid #fff;
}
.subnav-content2 {
    display: none;
    position: fixed;
    background-color: #413529;
    width: auto;
    z-index: 999;
    top: 88px;
    left: 420px;
    border-left: 1px solid #fff;
}

.subnav-content3 {
    display: none;
    position: fixed;
    background-color: #413529;
    width: auto;
    z-index: 999;
    top: 88px;
    left: 648px;
    border-left: 1px solid #fff;
}
.subnav-content4 {
    display: none;
    position: fixed;
    background-color: #413529;
    width: auto;
    z-index: 999;
    top: 130px;
    left: 648px;
    border-left: 1px solid #fff;
}
.subnav-content5 {
    display: none;
    position: fixed;
    background-color: #413529;
    width: auto;
    z-index: 999;
    top: 130px;
    left: 420px;
    border-left: 1px solid #fff;
}

.subnav-content a {
  float: left;
  color: white;
  text-decoration: none;
}

.subnav-content a:hover {
  /* background-color: #eee; */
  color: black;
}
.subnav-content ul>li>a,.subnav-content1 ul>li>a{
 padding:13px 15px 13px 15px !important;
}
.subnav1 i,.subnav2 i,.subnav3 i,.subnav4 i,.subnav5 i{
    background-image: none;
    margin-top: 12px;
    float: right;
}
.subnav1 li,.subnav2 li,.subnav3 li,.subnav4 li,.subnav5 li{
    border-right: 1px solid #fff;
}


	</style> 

<ul class="tour-lock">

   
<li ><a href="dashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li  class="active subnav"><a id="dealhover" href="javascript:void(0)" class="popup_call" data-url="index.php"><i class="i-data-deals"></i>Deals</a>
<div class="subnav-content">
    <ul style="display:grid">
      <li class="subnav1 border-btm-head"><a id="pevchover" class="index" href="index.php?value=0" >PE-VC Investments</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
														aria-hidden="true"></i>
    <div class="subnav-content1">
        <ul style="display:grid">
            <li class="border-btm-head"><a class="index" href="index.php?value=1" >Venture Capital Only</a></li>
            <li class="border-btm-head"><a id="svhover" class="svindex" href="svindex.php?value=3">Social VC / Impact</a></li>
            <li class="border-btm-head"><a class="svindex" href="svindex.php?value=5">Infrastructure</a></li>
            <li><a  class="svindex" href="svindex.php?value=4">Cleantech</a></li>
        </ul>
    </div>
</li>
      <li class="subnav2 border-btm-head"><a id="pevcexit" class="mandaindex"  href="mandaindex.php?value=0-2">PE-VC Exits</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
            <div class="subnav-content2">
                <ul style="display:grid">
                    <li class="subnav3 border-btm-head"><a id="mapevchover" class="mandaindex" href="mandaindex.php?value=0-0" >via M&A (PE-VC)</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
                                    <div class="subnav-content3">
                                        <ul style="display:grid">
                                            <li><a class="mandaindex" href="mandaindex.php?value=1-0">M&A (VC)</a></li>
                                        </ul>
                                    </div>
                    </li>
                    <li class="subnav4"><a class="mandaindex" href="mandaindex.php?value=0-1">via Public Market (PE-VC)</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
                                    <div class="subnav-content4">
                                        <ul style="display:grid">
                                            <li><a class="mandaindex" href="mandaindex.php?value=1-1">via Public Market (VC)</a></li>
                                        </ul>
                                    </div>
                    </li>
        </ul>
    </div></li>
      <li class="subnav5 border-btm-head"><a class="ipoindex" href="ipoindex.php?value=0">PE-VC Backed IPOs</a><i class="fa fa-angle-right arrow-pe-vc arrow-weight"
                                                        aria-hidden="true"></i>
                                    <div class="subnav-content5">
                                        <ul style="display:grid">
                                            <li><a class="ipoindex" href="ipoindex.php?value=1">VC Backed IPOs</a></li>
                                        </ul>
                                    </div>
      </li>
      <li class="border-btm-head"><a id="angelindex" href="angelindex.php">Angel Investments</a></li>
      <li><a  id="incindex" href="incindex.php">Incubation / Acceleration</a></li>
 </ul>
    </div>
 </li>
<li  id="tour_directory"><a href="pedirview.php?value=0"><i class="i-directory"></i>Directory</a></li>
<li id="funds" ><a   href="funds.php"><i class="i-directory"></i>Funds <span class="betaversion">Beta</span></a></li>
 </ul>
<script>
    $(".tour-lock").on('click', '.popup_call', function(e) {
        e.preventDefault();
        localStorage.removeItem("pageno");
        var url = $(this).attr('data-url'); 
        $.ajax({
            url: 'ajax_set_session.php',
            type: 'POST',
            timeout: 30000, // in milliseconds
            success: function(data) { 
                window.location.href=url;
                return true;
            }
        });
    });
    $(".tour-lock").on('click', function(e) {
        //alert('hello');
        localStorage.removeItem("pageno");


    });
</script>

<!--<ul>
<li ><a href="dashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li class="active"><a href="incindex.php"><i class="i-data-deals"></i>Deals</a></li>
<li ><a href="pedirview.php"><i class="i-directory"></i>Directory</a></li>
<li ><a href="funds.php"><i class="i-directory"></i>Funds <span class="betaversion">Beta</span></a></li>
<!--li ><a href="report.php"><i class="i-directory"></i>Report</a></li
</ul>-->
<ul class="fr">
      <!-- <li class="classic-btn"><a href="http://www.ventureintelligence.info/deals/dealhome.php" >Classic View</a></li> -->
            
<li ><div style="float:right;padding: 9px 15px" class="key-search"><b></b> <input type="text" name="searchallfield" placeholder="Search"
                                                                                                                                                                             style="padding:5px;"  /> 
        <input type="button" name="fliter_stage" value="Go" onclick="this.form.submit();" style="padding: 5px;"/>
    </div></li>
        
 <li class="user-avt"><span class="studentlogin" data-dropdown="#myaccount"> Welcome  Vijay</span> 
 </li>
</ul>
</td>
</tr>
</table>

</div>
</form>
<form name="pesearch" id="pesearch" action="incindex.php" method="post">
<div id="sec-header" class="sec-header-fix">
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
<!--     
<td class="investment-form">
<h3 class="ttl3">INVESTMENTS</h3>
<div class="investmentlabel frmDropDown"  style="padding: 5px 30px 5px 0px;">
<div>
<label  id="definition_step" ><input class="investment-nav" name="investments" type="radio" data-name="INVESTMENT - PE" value=0   checked="checked"   /> PE</label>
<label   id="petour2"><input class="investment-nav" name="investments" type="radio" data-name="INVESTMENT - CLEANTECH" value=4  />Cleantech</label>
<label   id="petour3"><input class="investment-nav" name="investments" type="radio" data-name="INVESTMENT - INFRASTRUCTURE" value=5  />Infrastructure</label>
<label id="vc_definition_step" ><input class="investment-nav" name="investments" data-name="INVESTMENT - VC" type="radio" value=1  /> VC</label>
<label  id="vctour2"><input class="investment-nav" name="investments" type="radio" data-name="INVESTMENT - ANGEL" value=2  />Angel</label>
<label  id="vctour3"><input class="investment-nav" name="investments" type="radio" data-name="INVESTMENT - INCUBATION" value=6  />Incubation</label>
<label  id="vctour4"><input class="investment-nav" name="investments" type="radio" data-name="INVESTMENT - SOCIAL" value=3  />Social VC</label></div>
</div>
 -->
<!--<div id="invspecialisedsocial" class="">
</div>-->

<!-- <div id="investmentsspecialised" class="">
<label   id="petour2"><input class="investment-nav" name="investments" type="radio" value=4  />Cleantech</label>
<label   id="petour3"><input class="investment-nav" name="investments" type="radio" value=5  />Infrastructure</label></div> -->
<!-- </td>



<td class="exit-form">
<h3 class="ttl3">EXITS </h3>
<div class="exitslabel frmDropDown"> -->    
    <!-- <select id="exitswitch">
        <option value="1" class="peonly">PE</option>
        <option value="0" class="vconly">VC</option>
    </select> -->
<!--  
<div>



<label><input class="exist-nav" name="investments" type="radio" data-name="EXIST - M&A(PE)" value="PE-EXIST" />M&A(PE) </label>

<label><input class="exist-nav" name="investments" type="radio" value="PMS" data-name="EXIST - Public MARKET"/> Public Market(PE)</label>

<label><input class="exist-nav" name="investments" type="radio" data-name="EXIST - IPO" value="PE-BACKED-IPO" />IPO(PE)</label>

<label><input class="exist-nav" name="investments" type="radio" data-name="EXIST - M&A(VC)" value="VC-EXIST" />M&A(VC) </label>
 <label><input class="exist-nav" name="investments" type="radio" data-name="EXIST - Public MARKET(VC)" value="VCPMS" /> Public Market(VC)</label>
 <label><input class="exist-nav" name="investments" type="radio" data-name="EXIST - IPO(VC)" value="VC-BACKED-IPO" />IPO(VC)</label>

 </div>
</div>

</td>
 --><!--    <td class="vertical-form">-->

<td class="vertical-form">    

    <h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> Incubation</h3>

<div style="float: right;" class="sort-by-date">

  <div class="period-date">

<label>From</label>
<SELECT NAME="month1" id="month1">
     <OPTION id=1 value="--"> Month </option>
     <OPTION VALUE='1'  >Jan</OPTION>
     <OPTION VALUE='2' >Feb</OPTION>
     <OPTION VALUE='3' >Mar</OPTION>
     <OPTION VALUE='4' >Apr</OPTION>
     <OPTION VALUE='5' >May</OPTION>
     <OPTION VALUE='6' >Jun</OPTION>
     <OPTION VALUE='7' >Jul</OPTION>
     <OPTION VALUE='8' SELECTED>Aug</OPTION>
     <OPTION VALUE='9' >Sep</OPTION>
     <OPTION VALUE='10' >Oct</OPTION>
     <OPTION VALUE='11' >Nov</OPTION>
    <OPTION VALUE='12' >Dec</OPTION>
</SELECT>

<SELECT NAME="year1" id="year1"  id="year1">
    <OPTION id=2 value=""> Year </option>
    <OPTION id=2021 value='2021' >2021</OPTION>
<OPTION id=2020 value='2020' SELECTED>2020</OPTION>
<OPTION id=2019 value='2019' >2019</OPTION>
<OPTION id=2018 value='2018' >2018</OPTION>
<OPTION id=2017 value='2017' >2017</OPTION>
<OPTION id=2016 value='2016' >2016</OPTION>
<OPTION id=2015 value='2015' >2015</OPTION>
<OPTION id=2014 value='2014' >2014</OPTION>
<OPTION id=2013 value='2013' >2013</OPTION>
<OPTION id=2012 value='2012' >2012</OPTION>
<OPTION id=2011 value='2011' >2011</OPTION>
<OPTION id=2010 value='2010' >2010</OPTION>
<OPTION id=2009 value='2009' >2009</OPTION>
<OPTION id=2008 value='2008' >2008</OPTION>
<OPTION id=2007 value='2007' >2007</OPTION>
<OPTION id=2006 value='2006' >2006</OPTION>
<OPTION id=2005 value='2005' >2005</OPTION>
<OPTION id=2004 value='2004' >2004</OPTION>
<OPTION id=2003 value='2003' >2003</OPTION>
<OPTION id=2002 value='2002' >2002</OPTION>
<OPTION id=2001 value='2001' >2001</OPTION>
<OPTION id=2000 value='2000' >2000</OPTION>
<OPTION id=1999 value='1999' >1999</OPTION>
<OPTION id=1998 value='1998' >1998</OPTION>
 
</SELECT>
</div>
<div class="period-date">
<label>To</label>

<SELECT NAME="month2" id='month2'>
     <OPTION id=1 value="--"> Month </option>
     <OPTION VALUE='1'  >Jan</OPTION>
     <OPTION VALUE='2' >Feb</OPTION>
     <OPTION VALUE='3' >Mar</OPTION>
     <OPTION VALUE='4' >Apr</OPTION>
     <OPTION VALUE='5' >May</OPTION>
     <OPTION VALUE='6' >Jun</OPTION>
     <OPTION VALUE='7' >Jul</OPTION>
     <OPTION VALUE='8' SELECTED>Aug</OPTION>
     <OPTION VALUE='9' >Sep</OPTION>
     <OPTION VALUE='10' >Oct</OPTION>
     <OPTION VALUE='11' >Nov</OPTION>
    <OPTION VALUE='12' >Dec</OPTION>
</SELECT>

<SELECT NAME="year2" id="year2" onchange="checkForDate();" id='year2'>
    <OPTION id=2 value=""> Year </option>
    <OPTION id=2021 value='2021' SELECTED>2021</OPTION>
<OPTION id=2020 value='2020' >2020</OPTION>
<OPTION id=2019 value='2019' >2019</OPTION>
<OPTION id=2018 value='2018' >2018</OPTION>
<OPTION id=2017 value='2017' >2017</OPTION>
<OPTION id=2016 value='2016' >2016</OPTION>
<OPTION id=2015 value='2015' >2015</OPTION>
<OPTION id=2014 value='2014' >2014</OPTION>
<OPTION id=2013 value='2013' >2013</OPTION>
<OPTION id=2012 value='2012' >2012</OPTION>
<OPTION id=2011 value='2011' >2011</OPTION>
<OPTION id=2010 value='2010' >2010</OPTION>
<OPTION id=2009 value='2009' >2009</OPTION>
<OPTION id=2008 value='2008' >2008</OPTION>
<OPTION id=2007 value='2007' >2007</OPTION>
<OPTION id=2006 value='2006' >2006</OPTION>
<OPTION id=2005 value='2005' >2005</OPTION>
<OPTION id=2004 value='2004' >2004</OPTION>
<OPTION id=2003 value='2003' >2003</OPTION>
<OPTION id=2002 value='2002' >2002</OPTION>
<OPTION id=2001 value='2001' >2001</OPTION>
<OPTION id=2000 value='2000' >2000</OPTION>
<OPTION id=1999 value='1999' >1999</OPTION>
<OPTION id=1998 value='1998' >1998</OPTION>
 
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
     $(".ttl3").click(function() {
                  $(this).toggleClass('active').next('.frmDropDown').toggleClass("active");
               });
</script> 
<div id="container" >
    <table cellpadding="0" cellspacing="0" width="100%" style="margin-top:6px;">
<tr>
    <td class="left-td-bg">
 <div class="acc_main" style="margin-top:-10px;">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div> 
 <div id="panel" style="display:block; overflow:visible; clear:both;">

<style>
.showtextlarge {
    border: 0 none;
    left: 16px;
    position: absolute;
    top: -9px;
    z-index: 20;
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    transform: rotate(90deg);
}</style>
<script>
 // Company
 $(document).ready(function(){ 
        $("#firstrefineinc select, #firstrefineinc input").on('change',function(){
            $("#tagsearch").val("");
            $('#tagsearch_auto').val("");
        }); 
        $("#industry, #statusid, #txtfirmtype, #followonFund, #txtregion").on('change',function(){
          localStorage.removeItem("pageno");

          $("#tagsearch").val("");
          $('#tagsearch_auto').val("");
          $("#pesearch").submit();
        });
    });
 $(function() {
   
   $( "#companysearch_old" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
            type: "POST",
            url: "autosuggestincubatee.php",
            dataType: "json",
          data: {
            queryString: request.term
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.compName,
                value: item.compName,
                 id: item.compName
              }
            }));
          }
        });
      },
      minLength: 2
      
    });
    
   $( "#askeywordsearch_old" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
            type: "POST",
            url: "autosuggestincubator.php",
            dataType: "json",
          data: {
            queryString: request.term
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.investor,
                value: item.investor,
                 id: item.investor
              }
            }));
          }
        });
      },
      minLength: 1
      
    }); 
     
     
   
       
    ////////////// investor search start //////////////////////
    
      $( "#investorauto" ).keyup(function() {
             
             var investorauto = $("#investorauto").val();
              
             if(investorauto.length > 2 ) {
                    $.ajax({
                       type: "post",
                      url: "autosuggestincubator.php",
                     data: {                       
                        queryString: investorauto
                     },
                     success: function(data) {
                           var innerdata=$.parseJSON(data);
                           var datacount = innerdata.length;   
                          
                          if(datacount>0) {
                              var multiselect='';
                              
                              if(datacount>1){                           
                           multiselect+='<label> <input style="width:auto !important;" type="checkbox" id="inv_selectall"> SELECT ALL</label><br>';
                                }
                            $.each(innerdata, function (key, item) {
                                
                               multiselect+="<label style='clear: both;'><input type='checkbox' name='investor_multi[]' value='"+item['investorid']+"' class='investor_slt' data-title='"+item['investor']+"' >"+item['investor']+"</label></br>";

  });
                            
                            multiselect+="</br></br>"; 
                            
                            $("#investorauto_load").fadeIn();
                            $("#investorauto_load").html(multiselect);
                            $("#tagsearch").val("");
                            $('#tagsearch_auto').val("");
                            disableFileds();
                            clear_searchallfield();
                            }
                            else{
                            $("#investorauto_load").fadeOut();
                            $("#investorauto_load").html('');
                            }
                         
                     }
                   });

                 /*  $.post('chargefilter_autosuggest_test.php',{chargeholder:'test',xcxzc:'asdas'},function(data){
                       console.log(data);
                   }); */
        }
        else{
             $("#investorauto_load").fadeOut();
        }
        
    });    
    
      $("#inv_selectall").live("click", function() {
    
          
           clear_companysearch();
            
            $('.investor_slt').attr('checked',this.checked);
            if(this.checked) 
            {                              
                var holder = $(this).val();                             
                var sltholder='';
                var sltinvestor_multi ='';
                var sltcount=0;
                $('.investor_slt').each(function() { //loop through each checkbox

                       if(this.checked) {                              
                          var holder = $(this).data("title"); 
                          var slt_inves_id = $(this).val(); 

                             if(sltcount==0) { sltholder+=holder; sltinvestor_multi+=slt_inves_id; }
                             else { sltholder+=","+holder;   sltinvestor_multi+=","+slt_inves_id; }

                          sltcount++;
                          
                           //sltuserscout++;
                       }

                  });
                  $("#investorauto").attr('readonly','readonly'); 
                  $("#investorauto").val(sltholder);
                  $("#keywordsearch_multiple").val(sltinvestor_multi); 
                  $("#inv_clearall").fadeIn();
             }
             else{
               //  sltcount=0;sltholder='';
                   $("#inv_clearall").fadeOut(); 
                   $("#investorauto").removeAttr('readonly');
                   $("#investorauto").val('');
             }
//                $("#investorauto").attr('readonly','readonly');  
//                $("#investorauto").val(sltholder); 
//                $("#investorauto_load").show();
        });    
    
      $('.investor_slt').live("click", function() {  //on click 
                      
          
          clear_companysearch();
          
                      
                      var sltholder='';
                      var sltinvestor_multi ='';
                      var sltcount=0;
                      $('.investor_slt').each(function() { //loop through each checkbox
                          
                          if(this.checked) {                              
                                var holder = $(this).data("title"); 
                                var slt_inves_id = $(this).val(); 
                               
                                if(sltcount==0) { sltholder+=holder; sltinvestor_multi+=slt_inves_id;  }
                                else { sltholder+=","+holder;   sltinvestor_multi+=","+slt_inves_id;  }
                             
                             sltcount++;
                             $("#investorauto_load").show();
                              //sltuserscout++;
                          }
                          
                     });
                     
                    $("#investorauto").attr('readonly','readonly');  
                    $("#investorauto").val(sltholder); 
                    $("#keywordsearch_multiple").val(sltinvestor_multi); 
                    
                    
                    if(sltcount==0){  $("#inv_clearall").fadeOut(); $("#investorauto").removeAttr('readonly');   }
                    else {   $("#inv_clearall").fadeIn();  }
                        
        if($(".investor_slt").length==$(".investor_slt:checked").length){
            
            $("#inv_selectall").attr("checked","checked");
        }else{
            $("#inv_selectall").removeAttr("checked");
        }
                     
                 
             });
             
     ////////////// investor search end //////////////////////        
     
        
    
    
     ////////////// company search start //////////////////////    
    
     $( "#companyauto" ).keyup(function() {
             
             var companyauto = $("#companyauto").val();
              
             if(companyauto.length > 2 ) {
                    $.ajax({
                       type: "post",
                     url: "autosuggestincubatee.php",
                     data: {
                        queryString: companyauto
                     },
                     success: function(data) {
                           var innerdata=$.parseJSON(data);
                           var datacount = innerdata.length;   
                          
                          if(datacount>0) {
                              var multiselect='';                              
                              if(datacount>1){   
                           multiselect+='<label> <input style="width:auto !important;" type="checkbox" id="com_selectall"> SELECT ALL</label><br>';
                                }
                            $.each(innerdata, function (key, item) {
                                
                               multiselect+="<label style='clear: both;'><input type='checkbox' name='company_multi[]' value='"+item['companyid']+"' class='company_slt' data-title='"+item['compName']+"' >"+item['compName']+"</label></br>";

                            });
                            
                            multiselect+="</br></br>"; 
                            
                            $("#companyauto_load").fadeIn();
                            $("#companyauto_load").html(multiselect);
                            $("#tagsearch").val("");
                            $('#tagsearch_auto').val("");
                            disableFileds();
                            clear_searchallfield();
                            }
                            else{
                            $("#companyauto_load").fadeOut();
                            $("#companyauto_load").html('');
                            }
                     }
                   });

                 /*  $.post('chargefilter_autosuggest_test.php',{chargeholder:'test',xcxzc:'asdas'},function(data){
                       console.log(data);
                   }); */
        }
        else{
             $("#companyauto_load").fadeOut();
        }
        
    });
    
     $("#com_selectall").live("click", function() {
    
            clear_keywordsearch();
            
            $('.company_slt').attr('checked',this.checked);
            if(this.checked) 
            {                              
                var holder = $(this).val();                             
                var sltholder='';
                var sltcompany_multi ='';
                var sltcount=0;
                $('.company_slt').each(function() { //loop through each checkbox

                       if(this.checked) {                              
                          var holder = $(this).data("title"); 
                          var slt_comp_id = $(this).val(); 

                             if(sltcount==0) { sltholder+=holder; sltcompany_multi+=slt_comp_id; }
                             else { sltholder+=","+holder;   sltcompany_multi+=","+slt_comp_id; }

                          sltcount++;
                         
                       }

                  });
                    disableFileds();
                  $("#companyauto").attr('readonly','readonly'); 
                  $("#companyauto").val(sltholder);
                  $("#companysearch").val(sltcompany_multi); 
                  $("#com_clearall").fadeIn();
             }
             else{
               //  sltcount=0;sltholder='';
                   $("#com_clearall").fadeOut(); 
                   $("#companyauto").removeAttr('readonly');
                   $("#companyauto").val('');
                    enableFileds();
             }
        });
    
     $('.company_slt').live("click", function() {  //on click 
                      
                       clear_keywordsearch();
                      
                      var sltholder='';
                      var sltcompany_multi ='';
                      var sltcount=0;
                      $('.company_slt').each(function() { //loop through each checkbox
                          
                          if(this.checked) {                              
                                var holder = $(this).data("title"); 
                                var slt_comp_id = $(this).val(); 
                               
                                if(sltcount==0) { sltholder+=holder; sltcompany_multi+=slt_comp_id;  }
                                else { sltholder+=","+holder;   sltcompany_multi+=","+slt_comp_id;  }
                             
                             sltcount++;
                             $("#companyauto_load").show();
                              //sltuserscout++;
                          }
                          
                     });
                     
                    disableFileds();
                    $("#companyauto").attr('readonly','readonly');  
                    $("#companyauto").val(sltholder); 
                    $("#companysearch").val(sltcompany_multi); 
                    
                    
                    if(sltcount==0){  $("#com_clearall").fadeOut(); $("#companyauto").removeAttr('readonly');   }
                    else {   $("#com_clearall").fadeIn();  }
                        
        if($(".company_slt").length==$(".company_slt:checked").length){
            
            $("#com_selectall").attr("checked","checked");
        }else{
            $("#com_selectall").removeAttr("checked");
        }
                     
                 
             });
    
    ////////////// company search end //////////////////////
    
    ///////////// City Search autocomplete strats //////
    
     $( "#citysearch" ).autocomplete({
         
      source: function( request, response ) {
        //$('#citysearch').val('');
        $.ajax({
            type: "POST",
          url: "ajaxCitySearch.php",
          dataType: "json",
          data: {
            vcflag: '6',
            search: request.term
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.label,
                value: item.value,
                 id: item.id
              }
            }));
          }
        });
      },
      minLength: 1,
      select: function( event, ui ) {
       $('#citysearch').val(ui.item.value);
       $("#tagsearch").val("");
       $('#tagsearch_auto').val("");
       $(this).parents("form").submit();
      },
      open: function() {
//        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
          $('#citysearch').val()=="";
             //$( "#companyrauto" ).val('');  
//        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    });
    
  //       $( "#tagsearch_auto" ).autocomplete({
    
  //       source: function( request, response ) {
  //           $('#tagesearch').val('');
  //           $.ajax({
  //               type: "POST",
  //               url: "ajaxTagsearch.php",
  //               dataType: "json",
  //               data: {
  //                   search: request.term,
  //               },
  //               success: function( data ) {
  //                   response( $.map( data, function( item ) {
  //                     return {
  //                           label: item.label,
  //                           value: item.value,
  //                           id: item.id
  //                     }
  //                   }));
  //               }
  //           });
  //       },
  //       minLength: 2,
  //       select: function( event, ui ) {
        
  //           $('#tagsearch').val(ui.item.value);
  //           //clear_keywordsearch();
  //           clear_searchallfield();
           
  //           $(this).parents("form").submit();
  //       },
  //       open: function() {
  // //        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
  //       },
  //       close: function() {
  //           if( $('#tagsearch').val()=="") 
  //           $( "#tagsearch_auto" ).val('');
  //       }
  //   });

        $("#tagsearch_auto").tokenInput("ajaxTagsearch.php",{
            theme: "facebook",
            minChars:2,
            queryParam: "pe_cq",
            hintText: "",
            noResultsText: "No Result Found",
            preventDuplicates: true,
            onAdd: function (item) {
                var tags="";
                var selectedValues = $('#tagsearch_auto').tokenInput("get");
                for (let index = 0; index < selectedValues.length; index++) {
                    tags += selectedValues[index].name;
                    tags += ',';
                }
                $('#tagsearch').attr("value","");
                $('#tagsearch_auto').attr("value",tags.substring(0,tags.length - 1));
            },
            onDelete: function (item) {
                    var selectedValues = $('#tagsearch_auto').tokenInput("get");
                    var inputCount = selectedValues.length;
                    var tags="";
                    if(inputCount==0){ 
                        $('#tagsearch_auto').val("");
                        $('#tagsearch').val("");
                    } else {
                        for (let index = 0; index < selectedValues.length; index++) {
                           tags += selectedValues[index].name;
                           tags += ',';
                        }
                        $('#tagsearch').attr("value","");
                        $('#tagsearch_auto').attr("value",tags.substring(0,tags.length - 1));
                        //$('#tagsearch').attr("value",tags.substring(0,tags.length - 1));
                    }
        },
            prePopulate :null    });
    
    ////////////// city search autocomplete ends /////////
     
  });
 $(document).on("click","#filter-refine",function() {
    submitSearchRemove();
  });
  
      function clear_keywordsearch(){
     $("#investorauto").removeAttr('readonly');  
     val='';
     $("#investorauto, #keywordsearch_multiple").val(val); 
     $("#investorauto_load").fadeOut();
     $("#inv_clearall").fadeOut(); 
} 

function clear_searchallfield(){
     $("#searchallfieldHide").val('remove');
     $("#searchallfield").val('');
     $("#searchallfield").fadeOut();
} 

  function clear_companysearch(){
     $("#companyauto").removeAttr('readonly');  
     val='';
     $("#companyauto,#companysearch").val(val); 
     $("#companyauto_load").fadeOut();
     $("#com_clearall").fadeOut(); 
}  

  function clear_companysearch1(){
     $("#companyauto").removeAttr('readonly');  
     val='';
     $("#companyauto,#companysearch").val(val); 
     $("#companyauto_load").fadeOut();
     $("#com_clearall").fadeOut(); 
     enableFileds();
} 

      function clear_keywordsearch1(){
     $("#investorauto").removeAttr('readonly');  
     val='';
     $("#investorauto, #keywordsearch_multiple").val(val); 
     $("#investorauto_load").fadeOut();
     $("#inv_clearall").fadeOut(); 
     enableFileds();
} 


function disableFileds(){
    $("#industry").val('--');
    $("#industry").prop("disabled", true);    
    $("#statusid").val('--');
    $("#statusid").prop("disabled", true);
    $("#chkDefunct").val('');
    $("#chkDefunct").prop("disabled", true);
    $("#txtfirmtype").val('0');
    $("#txtfirmtype").prop("disabled", true);
    $("#followonFund").val('--');
    $("#followonFund").prop("disabled", true);
    $("#txtregion").val('--');
    $("#txtregion").prop("disabled", true);
    $('#chkDefunct').attr('checked', false);
    $("#cityauto").val('');
    $("#citysearch").val('');
    $("#citysearch").prop("disabled", true);
    $(".fliter_stage").prop("disabled", true);
    $("#tagsearch_auto").prop("disabled", true);
    $('#industry,#statusid, #chkDefunct, #txtfirmtype, #followonFund, #txtregion').attr('style', 'background-color: #dddddd !important');
}
function enableFileds(){ 
    $("#industry").prop("disabled", false);
    $("#statusid").prop("disabled", false);
    $("#chkDefunct").prop("disabled", false);
    $("#txtfirmtype").prop("disabled", false);
    $("#followonFund").prop("disabled", false);
    $("#txtregion").prop("disabled", false);
    $("#citysearch").prop("disabled", false);
    $(".fliter_stage").prop("disabled", false);
    $("#tagsearch_auto").prop("disabled", false);
    $('#industry, #statusid, #chkDefunct, #txtfirmtype, #followonFund, #txtregion').attr('style', 'background-color: #ffffff !important');
}   


 

   function submitSearchRemove(){
      $('#hide_company_array').val('');
      $('#pe_checkbox_disbale').val('');
      $('#pe_checkbox_enable').val('');
      $('#all_checkbox_search').val('');
                    
      $('#total_inv_deal').val('');
      $('#total_inv_amount').val('');
      $('#total_inv_inr_amount').val('');
      $('#total_inv_company').val('');

      $('#real_total_inv_deal').val('');
      $('#real_total_inv_amount').val('');
      $('#real_total_inv_inr_amount').val('');
      $('#real_total_inv_company').val('');
      localStorage.removeItem("pageno");

      $("#pesearch").submit();
  }

  function submitfilter() {
  localStorage.removeItem("pageno");

  document.pesearch.action = 'incindex.php';
  document.pesearch.submit();

  return true;
  }
 </script>
 <!-- Tag Search -->
 <h2 class="acc_trigger helptag" style="width: 100%;">
        <a href="#" style="display: inline-block;">Tag Search</a>
      <!-- <span class="helplineTag helplinetagicon" style="margin-top: -24px !important;"> 
        <a  class="help-icon1 tooltip tagpopup"><i class="far fa-question-circle" style="color: #fff;background-image: none;"></i>
            <span style="right: 18% !important;">
                <img class="showtextlarge" src="images/callout.gif" style="left: 50px;">
                    Tag List
            </span>
        </a>
      </span>  -->
    </h2>
    <div  class="acc_container " style="display: none;">
      <div class="block">
        <ul > 
                      <li class="ui-widget">
            <input type="hidden" id="tagsearch" name="tagsearch" value="" placeholder="" style="width:220px;">
            <input type="text" id="tagsearch_auto" name="tagsearch_auto" value="" placeholder="" style="width:220px;"> 
            <input type="hidden" id="tagradio" name="tagradio" value="0" placeholder="" style="width:220px;"> 
            </li>
            <li class="tagpadding">
              <div class="btn-cnt"> 
                <div class="switchtag-and-or"> 
                     <input type="radio" id="and" value="0" name="tagandor" class="hidden-field" checked="checked"/><span class="custom radio "></span>
                    <input type="radio" value="1" id="or" name="tagandor" class="hidden-field"/><span class="custom radio "></span>
                    <label for="and" class="cb-enable "><span>AND</span></label>
                    <label for="or" class="cb-disable"><span>OR</span></label>
                </div>
            </div>
            <input type="button" name="fliter_stage" value="Filter" onclick="submitfilter();" style="float: right;">
            </li>
        </ul>
        </div>
    </div>
    <span class="helplineTag helplinetagicon" style="margin-top: -24px !important;position: absolute;
    right: 40px;    top: 34px;"> 
        <a  class="help-icon1 tooltip tagpopup">
        <i class="far fa-question-circle" style="color: #fff;background-image: none;"></i>
            <span style="right: 0% !important;width: 55px;box-shadow: 2px 1px 3px 0px rgba(255, 255, 255, 0.5);padding-right: 10px;">
                <img class="showtextlarge" src="images/callout.gif" style="left: 40px;">
                    TAG LIST
            </span>
        </a>
    </span> 

    <!-- Tag Search -->
<h2 class="acc_trigger"><a href="#">Refine Search</a></h2>
  <div class="acc_container">
    <div class="block" id="firstrefineinc">
      <ul >

    <li class="even"><h4>Industry <!--<span ><a href="#popup4" class="help-icon1 tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
                                             <span>
                                             <img class="callout1" src="images/callout.gif">
                                             Definitions
                                             </span>-->
     </a></span></h4>
        <select name="industry" id="industry" style=" background: #ffffff;" >
    <OPTION id=0 value="--" selected> Select an Industry </option>
    <OPTION id=49 value=49 >Advertising & Marketing</OPTION> 
<OPTION id=14 value=14 >Agri-business</OPTION> 
<OPTION id=9 value=9 >BFSI</OPTION> 
<OPTION id=25 value=25 >Diversified</OPTION> 
<OPTION id=24 value=24 >Education</OPTION> 
<OPTION id=7 value=7 >Energy</OPTION> 
<OPTION id=4 value=4 >Engg. & Construction</OPTION> 
<OPTION id=16 value=16 >FMCG</OPTION> 
<OPTION id=17 value=17 >Food & Beverages</OPTION> 
<OPTION id=23 value=23 >Gems & Jewelry</OPTION> 
<OPTION id=3 value=3 >Healthcare & Life Sciences</OPTION> 
<OPTION id=21 value=21 >Hotels & Resorts</OPTION> 
<OPTION id=1 value=1 >IT & ITES</OPTION> 
<OPTION id=2 value=2 >Manufacturing</OPTION> 
<OPTION id=10 value=10 >Media & Entertainment</OPTION> 
<OPTION id=54 value=54 >Mining & Minerals</OPTION> 
<OPTION id=18 value=18 >Other Services</OPTION> 
<OPTION id=11 value=11 >Retail</OPTION> 
<OPTION id=66 value=66 >Shipping & Logistics</OPTION> 
<OPTION id=106 value=106 >Sports & Fitness</OPTION> 
<OPTION id=8 value=8 >Telecom</OPTION> 
<OPTION id=12 value=12 >Textiles & Garments</OPTION> 
<OPTION id=22 value=22 >Travel & Transport</OPTION> 
    </select>
    </li>
    <li class="odd range-to"><h4>Year Founded</h4>
                <select name="yearafter" id="yearafter"  style=" background: #ffffff; " >
                           <option value=''></option>
                           <!--  -->
                                                         <option value='2021' >2021</option>
                                                         <option value='2020' >2020</option>
                                                         <option value='2019' >2019</option>
                                                         <option value='2018' >2018</option>
                                                         <option value='2017' >2017</option>
                                                         <option value='2016' >2016</option>
                                                         <option value='2015' >2015</option>
                                                         <option value='2014' >2014</option>
                                                         <option value='2013' >2013</option>
                                                         <option value='2012' >2012</option>
                                                         <option value='2011' >2011</option>
                                                         <option value='2010' >2010</option>
                                                         <option value='2009' >2009</option>
                                                         <option value='2008' >2008</option>
                                                         <option value='2007' >2007</option>
                                                         <option value='2006' >2006</option>
                                                         <option value='2005' >2005</option>
                                                         <option value='2004' >2004</option>
                                                         <option value='2003' >2003</option>
                                                         <option value='2002' >2002</option>
                                                         <option value='2001' >2001</option>
                                                         <option value='2000' >2000</option>
                                                         <option value='1999' >1999</option>
                                                         <option value='1998' >1998</option>
                                                         <option value='1997' >1997</option>
                                                         <option value='1996' >1996</option>
                                                         <option value='1995' >1995</option>
                                                         <option value='1994' >1994</option>
                                                         <option value='1993' >1993</option>
                                                         <option value='1992' >1992</option>
                                                         <option value='1991' >1991</option>
                                                         <option value='1990' >1990</option>
                                                         <option value='1989' >1989</option>
                                                         <option value='1988' >1988</option>
                                                         <option value='1987' >1987</option>
                                                         <option value='1986' >1986</option>
                                                         <option value='1985' >1985</option>
                                                         <option value='1984' >1984</option>
                                                         <option value='1983' >1983</option>
                                                         <option value='1982' >1982</option>
                                                         <option value='1981' >1981</option>
                                                         <option value='1980' >1980</option>
                                                         <option value='1979' >1979</option>
                                                         <option value='1978' >1978</option>
                                                         <option value='1977' >1977</option>
                                                         <option value='1976' >1976</option>
                                                         <option value='1975' >1975</option>
                                                         <option value='1974' >1974</option>
                                                         <option value='1973' >1973</option>
                                                         <option value='1972' >1972</option>
                                                         <option value='1971' >1971</option>
                                                         <option value='1970' >1970</option>
                                                         <option value='1969' >1969</option>
                                                         <option value='1968' >1968</option>
                                                         <option value='1967' >1967</option>
                                                         <option value='1966' >1966</option>
                                                         <option value='1965' >1965</option>
                                                         <option value='1964' >1964</option>
                                                         <option value='1963' >1963</option>
                                                         <option value='1962' >1962</option>
                                                         <option value='1961' >1961</option>
                                                         <option value='1960' >1960</option>
                                                         <option value='1959' >1959</option>
                                                         <option value='1958' >1958</option>
                                                         <option value='1957' >1957</option>
                                                         <option value='1956' >1956</option>
                                                         <option value='1955' >1955</option>
                                                         <option value='1954' >1954</option>
                                                         <option value='1953' >1953</option>
                                                         <option value='1952' >1952</option>
                                                         <option value='1951' >1951</option>
                                                         <option value='1950' >1950</option>
                                                         <option value='1949' >1949</option>
                                                         <option value='1948' >1948</option>
                                                         <option value='1947' >1947</option>
                                                         <option value='1946' >1946</option>
                                                         <option value='1945' >1945</option>
                                                         <option value='1944' >1944</option>
                                                         <option value='1943' >1943</option>
                                                         <option value='1942' >1942</option>
                                                         <option value='1941' >1941</option>
                                                         <option value='1940' >1940</option>
                                                         <option value='1939' >1939</option>
                                                         <option value='1938' >1938</option>
                                                         <option value='1937' >1937</option>
                                                         <option value='1936' >1936</option>
                                                         <option value='1935' >1935</option>
                                                         <option value='1934' >1934</option>
                                                         <option value='1933' >1933</option>
                                                         <option value='1932' >1932</option>
                                                         <option value='1931' >1931</option>
                                                         <option value='1930' >1930</option>
                                                         <option value='1929' >1929</option>
                                                         <option value='1928' >1928</option>
                                                         <option value='1927' >1927</option>
                                                         <option value='1926' >1926</option>
                                                         <option value='1925' >1925</option>
                                                         <option value='1924' >1924</option>
                                                         <option value='1923' >1923</option>
                                                         <option value='1922' >1922</option>
                                                         <option value='1921' >1921</option>
                                                         <option value='1920' >1920</option>
                                                      </select>
                <span class="range-text"> to</span> 
                <select name="yearbefore" id="yearbefore"  style=" background: #ffffff;" >
                            <option value=''></option>
                            <!--  -->
                                                          <option value='2021' >2021</option>
                                                         <option value='2020' >2020</option>
                                                         <option value='2019' >2019</option>
                                                         <option value='2018' >2018</option>
                                                         <option value='2017' >2017</option>
                                                         <option value='2016' >2016</option>
                                                         <option value='2015' >2015</option>
                                                         <option value='2014' >2014</option>
                                                         <option value='2013' >2013</option>
                                                         <option value='2012' >2012</option>
                                                         <option value='2011' >2011</option>
                                                         <option value='2010' >2010</option>
                                                         <option value='2009' >2009</option>
                                                         <option value='2008' >2008</option>
                                                         <option value='2007' >2007</option>
                                                         <option value='2006' >2006</option>
                                                         <option value='2005' >2005</option>
                                                         <option value='2004' >2004</option>
                                                         <option value='2003' >2003</option>
                                                         <option value='2002' >2002</option>
                                                         <option value='2001' >2001</option>
                                                         <option value='2000' >2000</option>
                                                         <option value='1999' >1999</option>
                                                         <option value='1998' >1998</option>
                                                         <option value='1997' >1997</option>
                                                         <option value='1996' >1996</option>
                                                         <option value='1995' >1995</option>
                                                         <option value='1994' >1994</option>
                                                         <option value='1993' >1993</option>
                                                         <option value='1992' >1992</option>
                                                         <option value='1991' >1991</option>
                                                         <option value='1990' >1990</option>
                                                         <option value='1989' >1989</option>
                                                         <option value='1988' >1988</option>
                                                         <option value='1987' >1987</option>
                                                         <option value='1986' >1986</option>
                                                         <option value='1985' >1985</option>
                                                         <option value='1984' >1984</option>
                                                         <option value='1983' >1983</option>
                                                         <option value='1982' >1982</option>
                                                         <option value='1981' >1981</option>
                                                         <option value='1980' >1980</option>
                                                         <option value='1979' >1979</option>
                                                         <option value='1978' >1978</option>
                                                         <option value='1977' >1977</option>
                                                         <option value='1976' >1976</option>
                                                         <option value='1975' >1975</option>
                                                         <option value='1974' >1974</option>
                                                         <option value='1973' >1973</option>
                                                         <option value='1972' >1972</option>
                                                         <option value='1971' >1971</option>
                                                         <option value='1970' >1970</option>
                                                         <option value='1969' >1969</option>
                                                         <option value='1968' >1968</option>
                                                         <option value='1967' >1967</option>
                                                         <option value='1966' >1966</option>
                                                         <option value='1965' >1965</option>
                                                         <option value='1964' >1964</option>
                                                         <option value='1963' >1963</option>
                                                         <option value='1962' >1962</option>
                                                         <option value='1961' >1961</option>
                                                         <option value='1960' >1960</option>
                                                         <option value='1959' >1959</option>
                                                         <option value='1958' >1958</option>
                                                         <option value='1957' >1957</option>
                                                         <option value='1956' >1956</option>
                                                         <option value='1955' >1955</option>
                                                         <option value='1954' >1954</option>
                                                         <option value='1953' >1953</option>
                                                         <option value='1952' >1952</option>
                                                         <option value='1951' >1951</option>
                                                         <option value='1950' >1950</option>
                                                         <option value='1949' >1949</option>
                                                         <option value='1948' >1948</option>
                                                         <option value='1947' >1947</option>
                                                         <option value='1946' >1946</option>
                                                         <option value='1945' >1945</option>
                                                         <option value='1944' >1944</option>
                                                         <option value='1943' >1943</option>
                                                         <option value='1942' >1942</option>
                                                         <option value='1941' >1941</option>
                                                         <option value='1940' >1940</option>
                                                         <option value='1939' >1939</option>
                                                         <option value='1938' >1938</option>
                                                         <option value='1937' >1937</option>
                                                         <option value='1936' >1936</option>
                                                         <option value='1935' >1935</option>
                                                         <option value='1934' >1934</option>
                                                         <option value='1933' >1933</option>
                                                         <option value='1932' >1932</option>
                                                         <option value='1931' >1931</option>
                                                         <option value='1930' >1930</option>
                                                         <option value='1929' >1929</option>
                                                         <option value='1928' >1928</option>
                                                         <option value='1927' >1927</option>
                                                         <option value='1926' >1926</option>
                                                         <option value='1925' >1925</option>
                                                         <option value='1924' >1924</option>
                                                         <option value='1923' >1923</option>
                                                         <option value='1922' >1922</option>
                                                         <option value='1921' >1921</option>
                                                         <option value='1920' >1920</option>
                                                      </select>
            </li>
<li class="odd"><h4>Status</h4>
    <SELECT NAME="statusid" id="statusid" style=" background: #ffffff;" >
                 <OPTION id=5 value="--" selected> ALL </option>
                 <OPTION id=1 value=1 >Assisted</OPTION> 
<OPTION id=2 value=2 >Graduated</OPTION> 
<OPTION id=3 value=3 >Incubated</OPTION> 
             </SELECT>
</li>


<li class="even"><input name="chkDefunct" id="chkDefunct" type="checkbox" value="1"  style=" background: #ffffff;" > Exclude Defunct Cos</li>

<li>
    <input type="button" name="fliter_stage" class="fliter_stage" value="Filter" onclick="submitfilter();" >
    </li>

<li class="odd"><h4>Firm Type</h4>
    <SELECT NAME="txtfirmtype" id="txtfirmtype" style=" background: #ffffff;" >
        <OPTION id=6 value="0" selected> All </option>
        <OPTION id='1' value='1' >Educational Institution</OPTION> 
<OPTION id='2' value='2' >Private Incubator</OPTION> 
<OPTION id='3' value='3' >Accelerator</OPTION> 
        </SELECT>
                
</li>

<li class="even"><h4>Follow on Funding Status </h4>
                     <SELECT NAME="followonFund" id="followonFund"  style=" background: #ffffff;" >
                         <OPTION  value="--" selected> All </option>
                         <OPTION VALUE=1  >Obtained</OPTION>
                         <OPTION VALUE=2 >None</OPTION>
                  </SELECT>
      
 <!--<label><input name="investor" type="checkbox" value="" /> Foreign</label> 
 <label><input name="investor" type="checkbox" value="" /> India</label> 
 <label><input name="investor" type="checkbox" value="" /> Investment</label>-->
</li>
<li class="odd"><h4>Region</h4>
    <SELECT NAME="txtregion" id="txtregion" style=" background: #ffffff;" >
  <OPTION id=5 value="" selected> ALL </option>
     <OPTION id='2' value='2' >North</OPTION> 
<OPTION id='3' value='3' >South</OPTION> 
<OPTION id='4' value='4' >East</OPTION> 
<OPTION id='5' value='5' >West</OPTION> 
<OPTION id='6' value='6' >Central</OPTION> 
<OPTION id='7' value='7' >Overseas</OPTION> 
<OPTION id='8' value='8' >Unknown</OPTION> 
</SELECT>
                
</li>
<li class="ui-widget" style="position: relative"><h4>City</h4>
    <input type="hidden" id="cityauto" name="cityauto" value="" placeholder="" style="width:220px;" autocomplete="off" >
    <input type="text" id="citysearch" name="citysearch" value="" placeholder="" style="width:220px;">
     
    <!-- <span id="com_clearall" title="Clear All" onclick="clear_companysearch();" style="display:none;background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span> -->
     
    <div id="cityauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
     
</li>
</ul></div>
  </div>
  
  <h2 class="acc_trigger "><a href="#">Show deals by</a></h2>
  <div  class="acc_container">
    <div class="block">
<ul >


<li class="ui-widget" style="position: relative"><h4>Incubator/Accelerator</h4>
<!-- <input type="text" value="" name="keywordsearch" id="askeywordsearch"  class=""  autocomplete=off  style="width:220px;"/>-->
     
    <input type="text" id="investorauto" name="investorauto" value="" placeholder="" style="width:220px;" autocomplete="off" >
    
    
    <input type="hidden" id="keywordsearch_multiple" name="keywordsearch" value="" placeholder="" style="width:220px;">
     
     <span id="inv_clearall" title="Clear All" onclick="clear_keywordsearch1();" style="display:none;background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>
     <div id="investorauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
</li>
<li class="ui-widget" style="position: relative"><h4>Incubatee</h4>
    <input type="text" id="companyauto" name="companyauto" value="" placeholder="" style="width:220px;" autocomplete="off" >
     <input type="hidden" id="companysearch" name="companysearch" value="" placeholder="" style="width:220px;">
     
    <span id="com_clearall" title="Clear All" onclick="clear_companysearch1();" style="display:none;background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>
     
    <div id="companyauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
</li>






    <li>
        <input name="reset" id="resetall" class="reset-btn" type="button" value="Reset" style="float: left;" />
        <input type="button" name="fliter_stage" value="Filter" id="filter-refine" style="float: right;">
    </li>
</ul>
</div>
        </div>
        
    <script type="text/javascript" >
      $tagradio=$('#tagradio').val();
if($tagradio==0){
    $('#and').prop('checked', true);
    $('#or').prop('checked', false);
    $('.cb-enable').addClass('selected');
    $('.cb-disable').removeClass('selected');

   
}else{
    $('#or').prop('checked', true);
    $('#and').prop('checked', false);
    $('.cb-disable').addClass('selected');
    $('.cb-enable').removeClass('selected');
}
      $(document).ready(function(){ 

     $(".tagpopup").click(function(){
      $('.overlayshowdow').show();
      $('.overlaydiv').show();$("html, body").animate({ scrollTop: 0 }, "slow");
    });
    $(".close,.overlayshowdow").click(function(){
        $('.overlayshowdow').hide();
        $('.overlaydiv').hide();
    });
    $("#yearbefore").change(function(){
    
    if($("#yearafter").val() != ''){
        if($("#yearbefore").val() < $("#yearafter").val()){
            alert('Year Before is not lesser than year After');
            $("#yearbefore").val('');
        }
    }   

});
      $(".cb-enable").click(function(){
            var parent = $(this).parents('.switchtag-and-or');
            $('.cb-disable',parent).removeClass('selected');
            $(this).addClass('selected');
            $('.checkbox',parent).attr('checked', true);
        });
           $(".cb-disable").click(function(){
            var parent = $(this).parents('.switchtag-and-or');
            $('.cb-enable',parent).removeClass('selected');
            $(this).addClass('selected');
            $('.checkbox',parent).attr('checked', false);
        });  
         });

    </script>
         <input type="hidden" name="resetfield" value="" id="resetfield"/>
<!--     <input type="hidden" name="pe_checkbox" id="pe_checkbox" value="" />-->
     
<!--     <input type="hidden" name="pe_hide_companies" id="pe_hide_companies" value="" />-->
    
<!--    <input type="hidden" name="pe_company" id="pe_company" value="9889329,9889328,9889327,9883785,9889541,9889540,9889386,9889539,9889543,9889544,9889542,9889545,9883849,9885519,9889546,9889215,9889273,9889326,9885835,9889337,9889322,9889274,9887823,9889324,9883512,9887290,9888976,9889323,9889217,9887389,9889321,9889325,9888861,9888508,9889216,9887471,9889188,9889006,9889006,9889218,9884641,9887786,4443,9889320,9889001,9888856,9888857,9888492,9888778,9886195,9888955,9888834,9888591,9888771,9888720,9888700,9888559" />-->
<input type="hidden" name="hide_pe_company" id="hide_pe_company" value="9889329,9889328,9889327,9883785,9889541,9889540,9889386,9889539,9889543,9889544,9889542,9889545,9883849,9885519,9889546,9889215,9889273,9889326,9885835,9889337,9889322,9889274,9887823,9889324,9883512,9887290,9888976,9889323,9889217,9887389,9889321,9889325,9888861,9888508,9889216,9887471,9889188,9889006,9889006,9889218,9884641,9887786,4443,9889320,9889001,9888856,9888857,9888492,9888778,9886195,9888955,9888834,9888591,9888771,9888720,9888700,9888559" />
<input type="hidden" name="uncheckRows" id="uncheckRows" value="" /> 
<input type="hidden" name="full_uncheck_flag" id="full_uncheck_flag" value="" />

    <input type="hidden" name="real_total_inv_deal" id="real_total_inv_deal" value="57" />
    <input type="hidden" name="real_total_inv_company" id="real_total_inv_company" value="56" />
    
<input type="hidden" name="total_inv_deal" id="total_inv_deal" value="57">
<input type="hidden" name="total_inv_company" id="total_inv_company" value="56">

 </div></div>
</td>

 		
				
<td class="profile-view-left" style="width:100%;">
    <div class="result-cnt">
        
        <div class="result-title">

                            <h2>
                           <span class="result-no">57 Results Found (across 56 cos) </span> 
                        <span class="result-for">  for Incubation Investments</span>
            </h2>
             <div class="title-links">
                                
                <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                
                                         <input class="export_new exlexport" type="button"  value="Export" name="showdeal">
                                  </div>  
                        <ul class="result-select">
                                <li>
                    Aug 20-Aug  21 <a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
                                <li class="result-select-close"><a href="incindex.php"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
                             </ul>
                      </div>
        
    
    <div class="list-tab mt-list-tab" style="margin-top:93px !important;"><ul>
            <li><a class="postlink"  href="incindex.php"  id="icon-grid-view"><i></i> List  View</a></li>
            <li class="active"><a id="icon-detailed-view" class="postlink" href="incdealdetails.php?value=378239041/6/"><i></i> Detail View</a></li> 
            </ul></div> 
    <div class="lb" id="popup-box" style="top:100px;">
	<div class="title">Send this to your Colleague</div>
        <form>
            <div class="entry">
                    <label> To*</label>
                    <input type="text" name="toaddress" id="toaddress"  />
            </div>
            <div class="entry">
                    <h5>Subject*</h5>
                    <p>Checkout this deal - Asimov Global Technologies - in Venture Intelligence</p>
                    <input type="hidden" name="subject" id="subject" value="Checkout this deal - Asimov Global Technologies - in Venture Intelligence"  />
                    <input type="hidden" name="basesubject" id="basesubject" value="Deal" />
            </div>
            <div class="entry">
                    <h5>Link</h5>
                    <p>https://www.ventureintelligence.com/dealsnew/incdealdetails.php?value=378239041/6&scr=EMAIL   <input type="hidden" name="message" id="message" value="https://www.ventureintelligence.com/dealsnew/incdealdetails.php?value=378239041/6&scr=EMAIL"  />   <input type="hidden" name="useremail" id="useremail" value="vijayakumar.k@praniontech.com"  /> </p>
            </div>
            <div class="entry">
                    <h5>Your Message</h5><span style='float:right;'>Words left: <span id="word_left">200</span></span>
                    <textarea name="ymessage" id="ymessage" style="width: 374px; height: 57px;" placeholder="Enter your text here..." val=''></textarea>
            </div>
            <div class="entry">
                <input type="button" value="Submit" id="mailbtn" />
                <input type="button" value="Cancel" id="cancelbtn" />
            </div>

        </form>
    </div>
    <div class="lb" id="popup-box-financial">
	<div class="title">Send this to Venture</div>
        <form>
            <div class="entry">
                    <label> To*</label>
                    <input type="text" name="toaddress_fc" id="toaddress_fc"  value="database@ventureintelligence.com"/>
            </div>
            <div class="entry">
                    <h5>Subject*</h5>
                    <p>Request for financials linking</p>
                    <input type="hidden" name="subject_fc" id="subject_fc" value="Request for financials linking"  />
            </div>
            <div class="entry">
                    <h5>Link</h5>
                    <p>https://www.ventureintelligence.com/dealsnew/incdealdetails.php?value=378239041/6&scr=EMAIL   <input type="hidden" name="message_fc" id="message_fc" value="https://www.ventureintelligence.com/dealsnew/incdealdetails.php?value=378239041/6&scr=EMAIL"  />   <input type="hidden" name="useremail_fc" id="useremail_fc" value="vijayakumar.k@praniontech.com"  /> </p>
            </div>
            <div class="entry">
                <input type="button" value="Submit" id="mailfnbtn" />
                <input type="button" value="Cancel" id="cancelfnbtn" />
            </div>

        </form>
    </div>  
    <div class="view-detailed"> 
         <!--div class="detailed-title-links"> <h2>  Asimov Global Technologies</h2-->
             <div class="detailed-title-links"><h2> <A class="postlink" href='companydetails.php?value=9889326' >Asimov Global Technologies</a></h2>
		 <a  class="postlink" id="previous" href="incdealdetails.php?value=1612841570/6/">< Previous</a> 
        <a class="postlink" id="next" href="incdealdetails.php?value=578957683/6/"> Next > </a>                      </div>
        <div class="postContainer postContent masonry-container">
  <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
                    <h2>Company Info</h2>
                    <table cellpadding="0" cellspacing="0" class="tablelistview">
                    <tbody> 
                      <tr>  
                     				<td width="120"><h4>Company</h4> <p> <A class="postlink" href='companydetails.php?value=9889326/6/' >
				Asimov Global Technologies</a>				</p></td>
		                               <td><h4>Industry</h4> <p>Education</p></td>                          </tr>
                        <tr><td><h4>Sector</h4> <p>Equipment & Accessories (Lab & Workshops)</p></td><td><h4>City</h4> <p>Chennai</p></td>                        <tr><td><h4>Region</h4> <p>South</p></td><td colspan="2"><h4>Website</h4> <p style="word-break: break-all;"><a href=https://www.asimovglobaltechnologies.in target="_blank">https://www.asimovglobaltechnologies.in</a></p>	</td></tr>
                        <tr><td ><h4>Incubator</h4> <p><A href='incubatordetails.php?value=227/6' >
												AIIRF</a></p>	</td>                                                  <td colspan="2"><h4>Deal Date</h4> <p>January-2021</p>	</td></tr>
                                                         
                        <tr><td ><h4>Status</h4> <p>Graduated</p></td><td ><h4>Follow on Funding</h4> <p>No</p></td> </tr>
                       
                     
                    </table>
                    </div> 
        
        
        
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/tac-3/">
                 <h2>More Info</h2>
                                                               
                  <table class="tablelistview" cellpadding="0" cellspacing="0">
                      <tr>  <td class="more-info"><p>Annamalai Innovation and Incubation Research Foundation (AIIRF) has signed MoUs with 4 startups for virtual incubation and 3 startups for virtual pre-incubation. The companies are water and environmental technologies startup Watermin, edtech startup IINVTY, life sciences startup BioFocus Scientific Solutions, Fibtec Enterprises, BPMAN SAVVY Learning Solutions, INRO Labs and Asimov Global Technologies in the area of advanced manufacturing.<br />
<br />
AIIRF, located in the Annamalai University campus in Chidambaram, Tamil Nadu, and funded by the Entrepreneurship Development and Innovation Institute, focuses on three major thrust areas - advanced manufacturing, life sciences, and water and environmental technologies. It aims to help the startups to commercialize products and scale up business.<br />
<br />
Chennai-based Asimov Global Technologies is helping schools and colleges to equip their labs with advanced equipments for educating students and enabling them to research in fields like Robotics, Drones, AI, 3D Printing Technology, IoT & Aeromodelling.</p>
                              <p><a href="mailto:database@ventureintelligence.com?subject=Request for more deal data-&body=https://www.ventureintelligence.com/dealsnew/incdealdetails.php?value=378239041/6&scr=EMAIL ">
                                      Click Here</a> to request more details for this deal. Please specify what details you would like - financials, valuations, etc. - and we will revert with the data points as available. Note: For recent transactions (say within last 6 months), additional information availablity is typically less than for older ones.
                              </p></td></tr></table>
                                                                 
        </div>
   
    </div>
    </div>
<style>.companyProfile{ margin-top:0px !important; } .com-cnt-sec{margin-top:0px;} .view-detailed1{padding-top:0px;}</style>
    
<style>
    .relatedCompany .com-add-li, .tags .com-add-li{  min-height: 1px; }
    .tags .com-add-li{  width:140px; }
    .tags .bor-top-cnt{
        border-top:none;
    }
    .relatedCompany .com-address-cnt, .tags .com-address-cnt{ 
        border-bottom:none;  
        padding:0 30px;
    }
    .com-investment-profile{
        width: 33%;
    }
    .bor-top-cnt{
        border-top: 1px solid #e4e4e4;
        clear: both;
        padding-top: 10px;
    }
    .mar-top {
        margin: 0px 15px 10px;
    }
    .inv-lf-li{
        min-height: 100px;
    }
    
</style>
<span id="companyProfileBox">
<div id="container" class="companyProfile">
<form name="companyDisplay" method="post" action="exportcompanyprofile.php">
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>



<td class="profile-view-left" style="width:100%;">
<div class="result-cnt dealspage" style="position: relative;">
             
                            
   <div class="view-detailed view-detailed1"> 
           
       
    <!-- new -->
      
<div class="com-wrapper">
	<section class="com-cnt-sec">
    	<header>
            <h3 style="float:left">Company Profile</h3> 
                                                    <span style="float:right;margin-top: 5px;margin-right: 5px;" class="one">
                                             <input class ="export" type="button" id="expshowdealsbtn1"  value="Export Co. Profile" name="showdeals">
                                    </span>
                             </header>
            
                     
            
                        
         <div class="com-col">
             <img src="img/co-sec-logo.png" alt="vi" class="fr mar-top">
         	<div class="com-address-cnt bor-top-cnt">

                    <div>
                        <span style="float:right;text-decoration: underline;font-size: 18px;color:#624C34;font-weight: bolder;cursor:pointer;" id="allfinancial">Financials</span>
                    </div>

                    
                          <div class="com-add-li">
                              <h6>INDUSTRY</h6>
                          <span> Education</span>
                          </div>

                                            <div class="com-add-li">
                             <h6>SECTOR</h6>
                          <span>Equipment & Accessories (Lab & Workshops)</span>
                          </div>

                                                        <div class="com-add-li">
                                          <h6>CITY</h6>
                                      <span>Chennai</span>
                                  </div>


                                                        <div class="com-add-li">
                                          <h6>WEBSITE</h6>
                                      <span><a href="https://www.asimovglobaltechnologies.in" target="_blank"> Click Here  </a> </span>
                                  </div>

                                                       <div class="com-add-li">
                                          <h6>NEWS</h6>
                                      <span> <a href="https://www.google.co.in/search?q=asimov+global+technologies+site:ventureintelligence.com/ddw/"  target="_blank"> Click Here </a> </span>
                                  </div>

                      

                        <div class="com-add-li">
                            <h6>M&A Deals</h6>

                            <span> <a  href='https://www.ventureintelligence.com/malogin.php?search=Asimov Global Technologies'  target="_blank"> Click Here </a> </span>
                        </div>
                                        <div style="clear:both;"></div>
                    
                            
                           
            </div>
            
         </div>
         
                 
                  <!-- LINKED IN START -->
                  
                    <!--   -->
                 <!--  <img src="images/linked-in.gif" alt="Linked in loading..." id="loader" style="margin: 10px;position:absolute;left:50%;top:100px;"> -->
                 <!--  <div class="com-col linkedindiv"  style="display: none">
                      <div class="linked-com">
                  <div class="linkedin-bg">

                    <script type="text/javascript" > 

                    $(document).ready(function () {
                        $('#lframe,#lframe1').on('load', function () {
                //            $('#loader').hide();

                        });
                    });

                function autoResize(id){
                    var newheight;
                    var newwidth;

                    if(document.getElementById){
                        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
                        newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
                    }

                    document.getElementById(id).height= (newheight) + "px";
                    document.getElementById(id).width= (newwidth) + "px";
                }
                 </script>



                        <script type="text/javascript" src="//platform.linkedin.com/in.js"> 
                        api_key:65623uxbgn8l
                        authorize:true
                        onLoad: LinkedAuth
                        </script>
                        <script type="text/javascript" > 
                        var idvalue;
                         //document.getElementById("sa").textContent='asdasdasd'; 

                        function LinkedAuth() {
                            if(IN.User.isAuthorized()==1){
                               $("#viewlinkedin_loginbtn").hide();      
                            }
                            else {
                                 $("#viewlinkedin_loginbtn").show();   
                            }

                            IN.Event.on(IN, "auth", onLinkedInLoad);

                          } 

                        function onLinkedInLoad() {
                           $("#viewlinkedin_loginbtn").hide(); 
                           var profileDiv = document.getElementById("sample");

                               //var url = "/companies?email-domain=https:";
                               var url ="/company-search:(companies:(id,website-url))?keywords=Asimov Global Technologies";

                                console.log(url);

                                IN.API.Raw(url).result(function(response) {   

                                    console.log(response);  
                                    //console.log(response['companies']['values'].length);                  
                                    //console.log(response['companies']['values'][0]['id']);
                                    //console.log(response['companies']['values'][0]['websiteUrl']);
                                    var searchlength = response['companies']['values'].length;

                                    var domain='';
                                    var website = 'https:';

                                    for(var i=0; i<searchlength; i++){

                                        if(response['companies']['values'][i]['websiteUrl']){
                                            domain = response['companies']['values'][i]['websiteUrl'].replace('www.','');
                                            domain = domain.replace('http://','');
                                            domain = domain.replace('/','');
                                            if(domain == website){
                                                idvalue = response['companies']['values'][i]['id'];
                                                console.log(idvalue);
                                                break;
                                            }
                                        }
                                    }


                                    if(idvalue)
                                    {                          
                                        $("#lframe").css({"height": "220px"});
                                        $("#lframe1").css({"height": "300px"});

                                        var inHTML='loadlinkedin.php?data_id='+idvalue;
                                        var inHTML2='linkedprofiles.php?data_id='+idvalue;
                                        $('#lframe').attr('src',inHTML);
                                        $('#lframe1').attr('src',inHTML2);
                                         $('.linkedindiv').show();
                                    }
                                    else
                                    {
                                         $('#lframe').hide();
                                         $('#lframe1').hide();
                                         $('#loader').hide();
                                         $('.linkedindiv').hide();
                                    }

                                    //  profileDiv.innerHtml=inHTML;
                                    //document.getElementById('sa').innerHTML='<script type="IN/CompanyProfile" data-id="'+idvalue+'" data-format="inline"></'+'script>';
                                }).error( function(error){
                                   console.log(error);
                                   $('#lframe').hide();
                                   $('#lframe1').hide();
                                   $('#loader').hide(); 
                                    $('.linkedindiv').hide();
                               });
                          }


                        </script>

                    <div  id="sample" style="padding:10px 10px 0 0;">

                        <iframe src="" id="lframe"  scrolling="no" frameborder="no" align="center" width="400" height="0"></iframe>
                    </div>

                    <input type="hidden" name="dataId" id="dataId" >

                 </div>
                   <div class="fl" style="padding:10px 10px 0 0;">
                   <iframe src="" id="lframe1"  scrolling="no" frameborder="no" align="center" width="674" height="0" ></iframe></div> 
                    </div>
                      </div>
                  -->
                  
                  <!-- LINKED IN END -->
                  
                 
            
            
                        
    </section>
    
    <section class="com-cnt-sec">
        
        
                
    	<header>
        	<h3>INVESTMENTS</h3>
        </header>
        
                
        
        <div class="com-col" id="ventureInvestment">
           
            <div style="margin:0 15px">
            <div class="company-cnt-sec">
                 <span class="">INVESTMENTS from Our Database</span>
                 <img src="img/co-sec-logo.png" alt="vi" class="fr mar-top">
            <div class="vicomp-cnt">
            </div>
                
            </div>
            </div>
            
            
        <div class="postContainer postContent masonry-container " >  
    
  
    
       
    
   <div  class="work-masonry-thumb  com-inv-sec   col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
    <!-- <h2>Incubators</h2> -->
    <h2>Incubation</h2>
    <table width="100%" cellpadding="0" cellspacing="0" class="tableview">
      <thead><tr><th>Incubator Name</th><th>Deal Period</th></tr></thead>
      <tbody>
                <tr><td><a href='incubatordetails.php?value=227/6' title="Incubator Details"> AIIRF </a> </td>
            <td><a href='incubatordetails.php?value=227/6' > January-2021</a></td>
        </tr>
                   </tbody>
    </table>
    </div>                         
        
            
            
            
                        
         
         
         </div>
        
       
        </div>
        
        <!-- Angel Only Start -->
       
                        
       
            
        <!-- Angel Only Start -->
        
    </section>
    
    </div>
    
    
<!-- -->    
    
    
    
    

                                                        
                             
  </div>

</td></tr></table>
</form></div></span>
</div>
            <form action="" name="tagForm" id="tagForm"  method="post">
                <input type="hidden" value="" name="searchTagsField" id="searchTagsField" />
              </form>

<form name="companyDisplay"  id="companyDisplay" method="post" action="exportcompanyprofile.php">
 <input type="hidden" name="txthideCompanyId" value="9889326" >
			<input type="hidden" name="txthideemail" value="vijayakumar.k@praniontech.com" >
</form>  

<script type="text/javascript">
     
     
     $(document).ready(function() {
        var ventureInvestment =  $( "#ventureInvestment" ).has( "td" ).length ;
        if(ventureInvestment==0){ $( ".vicomp-cnt, #ventureInvestment" ).hide() ;   }
             
        
     });
     
     </script>
 <script type="text/javascript">
			
            $('.tags_link').click(function(){ 
                    $("#searchTagsField").val('tag:'+$(this).html());
                    $('#tagForm').submit();
                });	
           /* $('#expshowdeals,.exlexport').click(function(){ 
                    hrefval= 'exportcompanyprofile.php';
            $("#companyDisplay").attr("action", hrefval);
            $("#companyDisplay").submit();
            return false;
            });*/
            $(document).ready(function() {
                $("#ymessage").on('keydown', function() {
                    var words = this.value.match(/\S+/g).length;
                    var character = this.value.length;

                    if (words == 201) {

                        $("#ymessage").attr('maxlength',character);
                    }
                    if(words > 200){
                         alert("Text reached above 200 words");
                    }
                    else {
                        $('#word_left').text(200-words);
                    }
                });
             });
     
           /* $('#expshowdeals').click(function(){ 
                    jQuery('#preloading').fadeIn();   
                    initExport();
                    return false;
                });

                $('#expshowdealsbtn').click(function(){ 
                    jQuery('#preloading').fadeIn();  
                    initExport();
                    return false;
                });*/
            $('#expshowdeals').click(function(){ 
                
                jQuery('#maskscreen').fadeIn();
                jQuery('#popup-box-copyrights').fadeIn();   
                return false;
                
                });
               
            $('#expshowdealsbtn').click(function(){ 
                /*jQuery('#preloading').fadeIn();   
                initExport();
                return false;*/
                
                jQuery('#maskscreen').fadeIn();
                jQuery('#popup-box-copyrights').fadeIn();   
                return false;
            });
               
                $('#expshowdealsbtn1').click(function(){ 
                    jQuery('#preloading').fadeIn();   
                    initExport1();
                    return false;
                });
             $('#senddeal').click(function(){ 
                    jQuery('#maskscreen').fadeIn(1000);
                    jQuery('#popup-box').fadeIn();   
                    return false;
                });
                 $('#cancelbtn').click(function(){ 

                    jQuery('#popup-box').fadeOut();   
                     jQuery('#maskscreen').fadeOut(1000);
                    return false;
                });
                 function validateEmail(field) {
                    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    return (regex.test(field)) ? true : false;
                }
                function checkEmail() {

                    var email = $("#toaddress").val();
                        if (email != '') {
                            var result = email.split(",");
                            for (var i = 0; i < result.length; i++) {
                                if (result[i] != '') {
                                    if (!validateEmail(result[i])) {

                                        alert('Please check, `' + result[i] + '` email addresses not valid!');
                                        email.focus();
                                        return false;
                                    }
                                }
                            }
                    }
                    else
                    {
                        alert('Please enter email address');
                        email.focus();
                        return false;
                    }
                    return true;
                }  
               
                function initExport1(){
                        $.ajax({
                            url: 'ajxCheckDownload.php',
                            dataType: 'json',
                            success: function(data){
                                var downloaded = data['recDownloaded'];
                                var exportLimit = data.exportLimit;
                                var currentRec = 1;

                                //alert(currentRec + downloaded);
                                var remLimit = exportLimit-downloaded;

                                if (currentRec <= remLimit){
                                    //hrefval= 'exportinvdeals.php';
                                    //$("#pelisting").attr("action", hrefval);
                                    $("#companyDisplay").submit();
                                    jQuery('#preloading').fadeOut();
                                }else{
                                    jQuery('#preloading').fadeOut();
                                    //alert("You have downloaded "+ downloaded +" records of allowed "+ exportLimit +" records(within 48 hours). You can download "+ remLimit +" more records.");
                                    alert("Currently your export action is crossing the limit of "+ exportLimit +" records. You can download "+ remLimit +" more records. To increase the limit please contact info@ventureintelligence.com");
                                }
                            },
                            error:function(){
                                jQuery('#preloading').fadeOut();
                                alert("There was some problem exporting...");
                            }

                        });
                    }
              $('#mailbtn').click(function(){ 
                        
            if(checkEmail())
            {


            $.ajax({
                url: 'ajaxsendmail.php',
                 type: "POST",
                data: { to : $("#toaddress").val(),subject : $("#subject").val(), basesubject : $("#basesubject").val(), message : $("#message").val() , ymessage : $("#ymessage").val() , userMail : $("#useremail").val() },
                success: function(data){
                        if(data=="1"){
                             alert("Mail Sent Successfully");
                            jQuery('#popup-box').fadeOut();   
                            jQuery('#maskscreen').fadeOut(1000);

                    }else{
                        jQuery('#popup-box').fadeOut();   
                        jQuery('#maskscreen').fadeOut(1000);
                        alert("Try Again");
                    }
                },
                error:function(){
                    jQuery('#preloading').fadeOut();
                    alert("There was some problem sending mail...");
                }

            });
            }

        });
</script>
<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 632px; display: none;"></div>
<div class="lb" id="popup-box-copyrights" style="width:650px !important;">
   <span id="expcancelbtn" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <div class="copyright-body" style="text-align: center;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
    </div>
    <div class="cr_entry" style="text-align:center;">
        
        <input type="button" value="I Agree" id="agreebtn" />
    </div>

</div>

<script>
</body>
</html>
<script>
                                    
             $(document).on('click','#agreebtn',function(){
                
                $('#popup-box-copyrights').fadeOut();   
                $('#maskscreen').fadeOut(1000);
                $('#preloading').fadeIn();   
                initExport();
                return false; 
            });

            $(document).on('click','#expcancelbtn',function(){

               jQuery('#popup-box-copyrights').fadeOut();   
               jQuery('#maskscreen').fadeOut(1000);
               return false;
           });
        </script>

<script type="text/javascript" >
             $("#panel").animate({width: 'toggle'}, 200); 
             $(".btn-slide").toggleClass("active"); 

             if ($('.left-td-bg').css("min-width") == '264px') {
             $('.left-td-bg').css("min-width", '36px');
             $('.acc_main').css("width", '35px');
             }
             else {
             $('.left-td-bg').css("min-width", '264px');
             $('.acc_main').css("width", '264px');
             }                                        
</script> 
<style>
    .com-investment-profile{
        width: 33%
    }
    .bor-top-cnt{
        border-top: 1px solid #e4e4e4;
        clear: both;
        padding-top: 10px;
    }
    .mar-top {
        margin: 0px 15px 10px;
    }
    .inv-lf-li{
        min-height: 100px;
    }
    .note-nia{
        position: absolute;margin-top: 5px;font-size: 13px;margin-bottom: 0px;
    }
</style>
   
</td></tr></tbody>

</table>
 
</div>
    </form>
    <form name=incubatordeal id="incubatordeal" method="post" action="exportincdealinfo.php">
      <input type="hidden" name="txthideIncDealId" value="378239041" >
      <input type="hidden" name="txthideemail" value="vijayakumar.k@praniontech.com" > 
      <input type="hidden" name="txthidecompanyname" value="Asimov Global Technologies" >
      <input type="hidden" name="txthideDealdate" value="January-2021" > 
    </form>
<div class=""></div>

</div>

   <script type="text/javascript">
       
       $(document).ready(function() {
        $("#ymessage").on('keydown', function() {
            var words = this.value.match(/\S+/g).length;
            var character = this.value.length;
            
            if (words == 201) {
                
                $("#ymessage").attr('maxlength',character);
            }
            if(words > 200){
                 alert("Text reached above 200 words");
            }
            else {
                $('#word_left').text(200-words);
            }
        });
     });
     
                $("a.postlink").click(function(){
                   $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:''}).appendTo('#pesearch');
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    
                });
                  function resetinput(fieldname)
                {
               // alert($('[name="'+fieldname+'"]').val());
                  $("#resetfield").val(fieldname);
                  hrefval= 'incindex.php';
                  $("#pesearch").attr("action", hrefval);
                  $("#pesearch").submit();
                    return false;
                }
                function resetmultipleinput(fieldname,fieldid)
                {
                  $("#resetfield").val(fieldname);
                  $("#resetfieldid").val(fieldid);
                  
                  //alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }
                 
            /*$('.exlexport').click(function(){ 
                $("#incubatordeal").submit();
                return false;
            });*/

            $('.exlexport').click(function(){ 
                jQuery('#maskscreen').fadeIn();
                jQuery('#popup-box-copyrights').fadeIn();   
                    return false;
                });

           $('#senddeal').click(function(){ 
                    jQuery('#maskscreen').fadeIn(1000);
                    jQuery('#popup-box').fadeIn();   
                    return false;
                });
            $('#cancelbtn').click(function(){ 

               jQuery('#popup-box').fadeOut();   
                jQuery('#maskscreen').fadeOut(1000);
               return false;
           });
           function validateEmail(field) {
                    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    return (regex.test(field)) ? true : false;
                }
                function checkEmail() {
                    
                    var email = $("#toaddress").val();
                        if (email != '') {
                            var result = email.split(",");
                            for (var i = 0; i < result.length; i++) {
                                if (result[i] != '') {
                                    if (!validateEmail(result[i])) {
                                        
                                        alert('Please check, `' + result[i] + '` email addresses not valid!');
                                        email.focus();
                                        return false;
                                    }
                                }
                            }
                    }
                    else
                    {
                        alert('Please enter email address');
                        email.focus();
                        return false;
                    }
                    return true;
                }
                function initExport(){
                        $.ajax({
                            url: 'ajxCheckDownload.php',
                            dataType: 'json',
                            success: function(data){
                                var downloaded = data['recDownloaded'];
                                var exportLimit = data.exportLimit;
                                var currentRec = 1;

                                //alert(currentRec + downloaded);
                                var remLimit = exportLimit-downloaded;

                                if (currentRec <= remLimit){
                                    
                                    $("#incubatordeal").submit();
                                    jQuery('#preloading').fadeOut();
                                }else{
                                    jQuery('#preloading').fadeOut();
                                    //alert("You have downloaded "+ downloaded +" records of allowed "+ exportLimit +" records(within 48 hours). You can download "+ remLimit +" more records.");
                                    alert("Currently your export action is crossing the limit of "+ exportLimit +" records. You can download "+ remLimit +" more records. To increase the limit please contact info@ventureintelligence.com");
                                }
                            },
                            error:function(){
                                jQuery('#preloading').fadeOut();
                                alert("There was some problem exporting...");
                            }

                        });
                    }
                    
                $('#mailbtn').click(function(){ 
                        
                        if(checkEmail())
                        {
                            
                        
                        $.ajax({
                            url: 'ajaxsendmail.php',
                             type: "POST",
                            data: { to : $("#toaddress").val(),subject : $("#subject").val(), basesubject : $("#basesubject").val(), message : $("#message").val() , ymessage : $("#ymessage").val() , userMail : $("#useremail").val() },
                            success: function(data){
                                    if(data=="1"){
                                         alert("Mail Sent Successfully");
                                        jQuery('#popup-box').fadeOut();   
                                        jQuery('#maskscreen').fadeOut(1000);
                                   
                                }else{
                                    jQuery('#popup-box').fadeOut();   
                                    jQuery('#maskscreen').fadeOut(1000);
                                    alert("Try Again");
                                }
                            },
                            error:function(){
                                jQuery('#preloading').fadeOut();
                                alert("There was some problem sending mail..");
                            }

                        });
                        }
                        
                    });
                    $('#mailfnbtn').click(function(e){ 
                        e.preventDefault();
                        
                            $.ajax({
                                url: 'ajaxsendmail.php',
                                 type: "POST",
                                data: { to : $("#toaddress_fc").val(), subject : $("#subject_fc").val(), message : $("#message_fc").val() , userMail : $("#useremail_fc").val() , toventure : 1 },
                                success: function(data){
                                        if(data=="1"){
                                             alert("Mail Sent Successfully");
                                            jQuery('#popup-box-financial').fadeOut();   
                                            jQuery('#maskscreen').fadeOut(1000);

                                    }else{
                                        jQuery('#popup-box-financial').fadeOut();   
                                        jQuery('#maskscreen').fadeOut(1000);
                                        alert("Try Again");
                                    }
                                },
                                error:function(){
                                    jQuery('#preloading').fadeOut();
                                    alert("There was some problem sending mail...");
                                }

                    });

                        return false;
                    });
            </script>
<style>
div.token-input-dropdown-facebook{
    z-index: 999;
}
.popup_content ul.token-input-list-facebook{
    height: 39px !important;
    width: 537px !important;
}
.popup_main
{
        position: fixed;
        left:0;
        top:0px;
        bottom:0px;
        right:0px;
        background: rgba(2,2,2,0.5);
        z-index: 999;
}
.popup_box
{
	width:70%;
	height: 0;
	position: relative;
	left:0px;
	right:0px;
	bottom:0px;
	top:35px;
	margin: auto;
	
}

.pop_menu ul li {
    margin-right: 0;
    background: #413529;
    margin-bottom: 10px;
    width: 10%;
    cursor: pointer;
    text-align: center;
    color: rgba(255,255,255,1);
    display: table-cell;
    vertical-align: middle;
    height: 60px;
    font-size: 14px;
}

.pop_menu ul li:first-child {
    margin-right: 0;
    background: #ffffff;
    margin-bottom: 10px;
    width: 10%;
    cursor: pointer;
    text-align: center;
    color: #413529;
    display: table-cell;
    vertical-align: middle;
    height: 60px;
    font-size: 14px;
    border:1px solid #413529;
}
.popup_content
{
	background: #ececec;
        border:3px solid #211B15;
}
.popup_form
{
	width:700px;
	border:1px solid #d5d5d5;
	background: #fff;
	height: 40px;
}
.popup_dropdown
{
	 width: 155px;
	 margin:0px;
	 border: none;
	 height: 40px;
	 -webkit-appearance: none;
	 -moz-appearance: none;
	 appearance: none;
	 background: url("images/polygon1.png") no-repeat 95% center;
	 padding-left: 17px;
	 cursor: pointer;
	 font-size: 14px;
}
.popup_text
{
	width:538px;
	border: none;
	border-left:1px solid #d5d5d5;
	padding-left: 17px;
	box-sizing: border-box;
	height: 40px;
	font-size: 16px;
	float: right;
}
.auto_keywords
{
	position: absolute;
	top: 106px;
	width:537px;
	background: #fff;
        border:1px solid #d5d5d5;
        border-top: none;
        display: none;
}
.auto_keywords ul
{
	line-height: 25px;
	font-size: 16px;
}

.auto_keywords ul li
{
 padding-left: 20px; 
 cursor:pointer;
}
.auto_keywords ul li a
{
  text-decoration: none;
  color: #414141;
}
.auto_keywords ul li:hover
{
   background: #f2f2f2;                                 
}
.popup_btn
{
	text-align: center;
	padding: 33px 0 50px;
	
}
.popup_cancel
{
	background: #d5d5d5;
	cursor: pointer;
	padding:10px 27px;
	text-align: center;
	color: #767676;
	text-decoration: none;
	margin-right: 16px;
	font-size: 16px;
	display: none;
	
}
.popup_btn input[type="button"]
{
	background: #a27639;
	cursor: pointer;
	padding:10px 27px;
	text-align: center;
	color: #fff;
	text-decoration: none;
	font-size: 16px;
	float: right;

}
.popup_close
{
    color: #fff;
    right: 0px;
    font-size: 20px;
    position: absolute;
    top: 1px;
    width: 15px;
    background: #413529;
    text-align: center;
}
.popup_close a
{
	color: #fff;
	text-decoration: none;
	cursor: pointer;
}
.popup_searching
{
	width:538px;
	float: right;
        position: relative;
}
div.token-input-dropdown{
        z-index: 999 !important;
}

.detail-table-div { display:block; float:left; overflow:hidden;border:1px solid #B3B3B3;}
.detail-table-div table{ border-top:0 !important; border-bottom:0 !important; width:auto !important; margin:0 !important;  }
.detail-table-div th{background:#E5E5E5; text-align:right !important;}
.detail-table-div td{ background:#fff; min-width:130px; text-align:right !important;}
/*.detail-table-div th:first-child {    max-width: 280px; text-align:left !important;
    min-width: 280px;  background:#C9C2AF;}*/
.detail-table-div th:first-child {    max-width: 240px; text-align:left !important;min-width: 240px;  background:#C9C2AF;padding:8px;}
.detail-table-div td:first-child {    max-width: 240px; text-align:left !important;min-width: 240px; background:#E0D8C3;}
.detail-table-div td { padding:8px;}
    
.tab-res{ display:block; overflow-y:hidden !important; overflow:auto; border:1px solid #B3B3B3; margin:10px 0 !important;}
.tab-res table{ border-top:0 !important; border-bottom:1px solid #B3B3B3; border-right:1px solid #B3B3B3; width:auto !important; margin:0 !important;  }
.tab-res th{background:#E5E5E5; text-align:right !important;}
.tab-res td{ background:#fff; min-width:150px; text-align:right !important;padding:8px; border-right: 1px solid #b3b3b3;}
.tab-res table thead th {
    border-bottom: 1px solid #b3b3b3;
    border-right: 1px solid #b3b3b3;
    text-align: left;
    padding: 8px;
    font-weight: bold;
}

.tab-res th {
    background: #E5E5E5;
    text-align: right !important;
}
detail-table-div table thead th:last-child {
    border-right: 0 !important;
}

.tab-res table thead th {
    border-bottom: 1px solid #b3b3b3;
}

@media (max-width:1500px){
    .popup_content {
        background: #ececec;
        height: 500px;
        overflow-y: auto;
    }
    .popup_main {
        top: 45px;
    }
    
}

@media (max-width:1025px){
       .popup_content {
            height: 500px;
        }
        .popup_main {
            top: 80px;
        }
        
}
@media (min-width:780px){
       
    .list_companyname{
        margin-left:160px !important;
    }
}
@media (min-width:1280px){
       
    .list_companyname{
        margin-left:250px !important;
    }
}
@media (min-width:1439px){
       
    .list_companyname{
        margin-left:340px !important;
    }
}
@media (min-width:1639px){
       
    .list_companyname{
        margin-left:520px !important;
    }
}

@media (min-width:1921px){
    
    .popup_content
    {
        background: #ececec;
        height: 600px;
        overflow-y: auto;
    }
    
}
    

/* Styles */


</style>
<div class="popup_main" id="popup_main" style="display:none;">
    
<div class="popup_box">
<!--  <h1 class="popup_header">Financial Details</h1>-->
  <span class="popup_close"><a href="javascript: void(0);">X</a></span>
  <div class="popup_content" id="popup_content">

</div>

</div>	
<script>    
   
    $(document).ready(function(){
        
        $('.popup_close a').click(function(){
            $(".popup_main").hide();
            $('body').css('overflow', 'scroll');
         });
         
         
         var cin = '0';
         $.ajax({
            url: 'pecfs_financial.php',
             type: "POST",
            data: { cin : cin,queryString:'INR' },
            success: function(data){
                $('#popup_content').html($.parseJSON(data))
                        
            },
            error:function(){
                jQuery('#preloading').fadeOut();
                alert("There was some problem sending mail...");
            }

        });
        
         
    });
    $(document).on('click','#pop_menu li',function(){
           window.open('https://www.ventureintelligence.com/cfsnew/details.php?vcid='+$(this).attr("data-row")+'&pe=1', '_blank');
    });
   /* $(document).on('click','#popup_main',function(e) {
    
        var subject = $("#popup_content"); 
        //alert(e.target.id);
        
        if(e.target.id !== null || e.target.id !== '')
        {
            
            $(".popup_main").hide();
        }
    });*/
    $(document).on('click','#allfinancial',function(){
             
            $(".popup_main").show();
            $('body').css('overflow', 'hidden');
    });
    
    $(document).on('click','#financial_data',function(){
            jQuery('#maskscreen').fadeIn(1000);
            jQuery('#popup-box-financial').fadeIn();   
            return false;
        });
        $('#cancelfnbtn').click(function(){ 
                     
            jQuery('#popup-box-financial').fadeOut();   
            jQuery('#maskscreen').fadeOut(1000);
            return false;
        });
</script>
<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 632px; display: none;"></div>
<div class="lb" id="popup-box-copyrights" style="width:650px !important;">
   <span id="expcancelbtn" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <div class="copyright-body" style="text-align: center;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
    </div>
    <div class="cr_entry" style="text-align:center;">
        
        <input type="button" value="I Agree" id="agreebtn" />
    </div>

</div>
</body>
</html>

<script type="text/javascript" >

    $("#panel").animate({width: 'toggle'}, 200); 
    $(".btn-slide").toggleClass("active"); 
    if ($('.left-td-bg').css("min-width") == '264px') {
        $('.left-td-bg').css("min-width", '36px');
        $('.acc_main').css("width", '35px');
    }
    else {
        $('.left-td-bg').css("min-width", '264px');
        $('.acc_main').css("width", '264px');
    }                                  
    
    $(document).on('click','#agreebtn',function(){
         $('#popup-box-copyrights').fadeOut();   
        $('#maskscreen').fadeOut(1000);
        $('#preloading').fadeIn();   
        initExport();
        return false; 
     });
    
     $(document).on('click','#expcancelbtn',function(){

        jQuery('#popup-box-copyrights').fadeOut();   
        jQuery('#maskscreen').fadeOut(1000);
        return false;
    });

    
</script> 
