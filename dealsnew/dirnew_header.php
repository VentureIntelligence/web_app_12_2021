<?php include_once("../globalconfig.php"); 
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
if(!isset($_SESSION['UserNames']))
{
header('Location:../pelogin.php');
}
else
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<title>Venture Intelligence</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link href="css/skin.css" rel="stylesheet" type="text/css" />  
<link href="css/popstyle.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" type="text/css" href="css/detect800.css" />
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/popup.js"></script>
 <!-- Global site tag (gtag.js) - Google Analytics -->
 <script async src="https://www.googletagmanager.com/gtag/js?id=UA-168374697-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-168374697-1');
</script>
<script src="TourStart.js"></script>     
<link href="hopscotch.min.css" rel="stylesheet"></link>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous"/> 
<link rel="stylesheet" type="text/css" href="css/token-input-facebook.css" />
<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<!-- <link rel="stylesheet" href="/resources/demos/style.css" /> -->
<script type="text/javascript" src="js/jquery.tokeninput.js"></script> 
<script type="text/javascript" src="js/jquery.multiselect.js"></script> 
<script type="text/javascript" src="js/jquery.tokeninput.js"></script> 
<link rel="stylesheet" type="text/css" href="css/jquery.multiselect.filter.css" />
<script type="text/javascript" src="js/jquery.multiselect.filter.js"></script>
  <script type="text/javascript" src="js/expand.js"></script>
 <script src="js/showHide.js" type="text/javascript"></script>
  <script src="js/jquery.flexslider.js"></script>
<script src="js/jquery.masonry.min.js"></script>
<!-- <script src="js/switch.min.js" type="text/javascript"></script>
 <link href="css/switch.css" type="text/css" rel="stylesheet">-->
 <script src="hopscotch.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript"> 
  $(document).ready(function() {
            <?php if($dealvalue == 101){ ?>
                $('#country').select2({ 
                    placeholder: "Search By Investor Location (Headquarters)",
                    minimumResultsForSearch: Infinity
                });
            <?php } else { ?>
                $('#country').select2({
                    placeholder: "Select Options",
                    minimumResultsForSearch: Infinity
                });
            <?php } ?>
           

            });
$(document).ready(function(){
$('#city').on("change",function(){
                    var citytotalcount = $('#city option').length; 
                      var citytotalcount_selected = $('#city option:selected').length;
                      
                          var allcityflag = 0;
                      if(citytotalcount == citytotalcount_selected)
                      {
                         
                         allcityflag = 0;
                          
                          
                          $("#cityflag").val(allcityflag);
                          
                      }
                      else{  allcityflag = 1;$("#cityflag").val(allcityflag);}
                    });
                    $('#countryNIN').on("change",function(){
                    var countryNINtotalcount = $('#countryNIN option').length; 
                      var countryNINtotalcount_selected = $('#countryNIN option:selected').length;
                      
                          var allcountryNINflag = 0;
                      if(countryNINtotalcount == countryNINtotalcount_selected)
                      {
                          
                         allcountryflag = 0;
                          
                          
                          $("#countryNINflag").val(allcountryNINflag);
                         
                          
                      }
                      else{  allcountryNINflag = 1;$("#countryNINflag").val(allcountryNINflag);
                       
                      }
                    });
                  //   $country_val_checked = $("#countryNINflag").val();
                  //   var countryNINtotalcount = $('#countryNIN option').length; 
                  //     var countryNINtotalcount_selected = $('#countryNIN option:selected').length;
                  //  if(($country_val_checked == 0 ) && (countryNINtotalcount_selected > 0)){
                  //       $('#countryNIN option').prop('selected', true);
                  //       $("#countryNIN").multiselect('refresh');
                  //       $("#countryNINflag").val(1);
                  //   }
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
.showdealsby{
  position: relative;
}
.request-for-lp{
      position: absolute;
    background: #41352999;
    right: 0px;
    padding: 7px 45px;
    background-image: none !important;
    cursor: pointer;
    top:0px;
}
</style>
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
            
            
            <?php if($tour=='Allow' && $_SESSION["DirectorydemoTour"]=='1'){ ?>
                      ///// tour 
                
                 if(Directorydemotour==1 )
                    {
                      $(".hopscotch-bubble").removeClass("tourboxshake");
                      $(".hopscotch-bubble").hide();
                      $('body').animate({scrollTop:0},500);  
                    
                   if(Directorydemotour==1){ setTimeout(function() { $(".hopscotch-bubble").show(); hopscotch.startTour(tour, 7); },1500); }
                     
                    $("#acc_main").animate({ scrollTop: $("#acc_main").height() }, 3000);  

                    var autoscroll = setTimeout(function() {                        
                       $('#acc_main').animate({scrollTop:0},3000);
                       $('body').animate({scrollTop:0}, 1000); 
//                       $('#firstrefine').show(); 
                    },3000);
                    
                    
                   var closefrefine = setTimeout(function() {
                       // clearTimeout(autoscroll);
                       //$( "#firstrefine" ).toggle(2000); 
                       $( "#firstrefine" ).animate({ "height": "0px" },2000);
                    },3000);
                    
                    
                   var openfrefine =  setTimeout(function() { 
                        // clearTimeout(closefrefine);
                        $( "#firstrefine" ).animate({ "height": "520px" },2000);
                      // $( "#firstrefine" ).toggle(2000);
                    },7000);
                    
                    $('.ui-corner-right').attr('id', 'tourclick');
                    $(".ui-autocomplete-input").attr('id', 'tourinvestortype');
                    
                    var intervel = setTimeout(function(){                        
                     
                    // clearTimeout(openfrefine);
                    // auto open    
                 
                    
               
                    
                    /* select box click - trigger 
                      function open(elem) {
                        if (document.createEvent) {
                            var e = document.createEvent("MouseEvents");
                            e.initMouseEvent("mousedown", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
                            elem[0].dispatchEvent(e);
                        } else if (element.fireEvent) {
                            elem[0].fireEvent("onmousedown");
                        }
                    }
                     open($('#sltindustry'));
                    */
                   

                  
                    var index = 0;                   
                    var type_this='5';
                    window.txtmultipleReturnfrom = function() { 
                        alert('test1');
                        if (index <= type_this.length) { 
                            alert('test2');
                            var txtmultipleReturnFrom = document.getElementsByClassName('custom-combobox-input');    
                            txtmultipleReturnFrom.value = type_this.substr(0, index++);                            
                            setTimeout("txtmultipleReturnfrom()", 200);
                        }
                    }
                    
                   
                    
                    var index2 = 0; 
                    var type_this2='2i';
                    window.txtmultipleReturnto = function() {                       
                        if (index2 <= type_this2.length) {                           
                            var txtmultipleReturnTo = document.getElementById('tourinvestortype');    
                            txtmultipleReturnTo.value = type_this2.substr(0, index2++);                            
                            setTimeout("txtmultipleReturnto()", 200);
                        }
                    }
                   
                    
                    function multislt() {
                       var offset = $('#sltindustry').offset();
                        var height = $('#stage').height();
                        var width = $('#stage').width();
                        var top = offset.top + height + "px";
                        var right = offset.left + width + "px";
                        $(".ui-multiselect-menu:first").css({
                        top: top,
                        left:'10px'
                    }).fadeIn();
                    $(".ui-multiselect").addClass('ui-state-active');
                    }

                    
                    var a = setTimeout(function(){  if(Directorydemotour==1){  $("#sltindustry").attr('size', 5).fadeIn(); } },2000);
                    var b = setTimeout(function(){  if(Directorydemotour==1){  $("#sltindustry").removeAttr('size');  multislt();   } },4000);
                    var c = setTimeout(function(){  if(Directorydemotour==1){  $(".ui-multiselect-menu:first").fadeOut();    $("#invType").attr('size', 2).fadeIn();    } },6000);
                    var d = setTimeout(function(){  if(Directorydemotour==1){  $("#invType").removeAttr('size');   $("#invrangestart,#invrangeend").attr('size', 5).fadeIn();   } },8000);
                    var e = setTimeout(function(){  if(Directorydemotour==1){  $("#invrangestart,#invrangeend").removeAttr('size');   $("#tour_month1,#tour_year1").attr('size', 5).fadeIn();  } },10000);
                    var f = setTimeout(function(){  if(Directorydemotour==1){  $("#tour_month1,#tour_year1").removeAttr('size');  } },11000);
                    var g = setTimeout(function(){  if(Directorydemotour==1){  $("#tour_month2,#tour_year2").attr('size', 5).fadeIn();   } },12000);
                    var h = setTimeout(function(){  if(Directorydemotour==1){  $("#tour_month2,#tour_year2").removeAttr('size'); } },13000);
                    var i = setTimeout(function(){  if(Directorydemotour==1){   txtmultipleReturnto();  $("#tourclick").trigger('click');  } },14000);
                    var j = setTimeout(function(){  if(Directorydemotour==1){   $("#tourclick").trigger('click'); $("#ui-id-1").fadeOut(); $("#tourinvestortype").removeAttr('value');    } },16000);
                    var k = setTimeout(function(){  if(Directorydemotour==1){   hopscotch.startTour(tour, 8);   } },17000);
                    // end auto open
                    
                                             
                    },8000);
                    
                    }
            
            <?php } ?>
            
            
            return false; //Prevent the browser jump to the link anchor
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
	$("#myTable").tablesorter({widthFixed: true}); 
	$("div.holder .paginate-wrapper").jPages({
	  containerID : "movies",
	  previous : "Previous",
	  next : "Next",
	  perPage : 1,
	  delay : 20
	});
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
  <?php if($dealvalue==101){ ?>
	$("#keywordsearch").combobox();
        $("#keywordsearchmain").combobox();
    $("#combobox").combobox();
	
	
         
	/*$( ".custom-combobox" ).autocomplete({
	  change: function( event, ui ) { this.form.submit(); }
	});*/
  <?php } 
  else if($dealvalue==102){
      ?>
      $("#companysearch").combobox();
      <?php
  }
  elseif($dealvalue==103){
      ?>
      $("#advisorsearch_legal").combobox();
      <?php
  }
  else if($dealvalue==104){
   ?>
       $("#advisorsearch_trans").combobox();    
<?php
  }
?>
    
 
        
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

 /*$('.showdealsby').each(function(){
    $('input[type=radio]:first', this).attr('checked', true);
});*/

       $("#disselect").find(':input').prop("disabled", true);  
       
        $('.show-nav').on('ifChecked', function(event){
            
           <?php if($_SESSION['vconly']!=1){ ?>
            if(Directorydemotour==1){
            var current_tour = hopscotch.getCurrStepNum();
            }
           <?php } else {?>  
            var current_tour = '';
           <?php } ?>
          
            var slt_shows = $("input[name=showdeals]:checked").val();
            
            if(Directorydemotour==1){
                    if(slt_shows==103 && current_tour==12){ 
            $("#pesearch").submit();
                     }
                     else {
                         showErrorDialog(warmsg);
                         return false;
                     }
                }            
            $("#pesearch").submit();
        });
        
       
     $('.investment-nav').on('ifChecked', function(event){
       
                if(Directorydemotour==1){
                    showErrorDialog(warmsg);
                     return false;
                }
       
 navvalue=$(this).val();
       switch(navvalue)
       {
           case '0':
                    var hrefval = 'pedirview.php?value='+$(this).val();
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    break;
           case '1':
                    var hrefval = 'pedirview.php?value='+$(this).val();
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    break;
           case '2':
                   window.location.href = 'pedirview.php?value='+$(this).val();
                   break;
           case '3':
                    var hrefval = 'pedirview.php?value='+$(this).val();
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                   //window.location.href = 'svtrendview.php?value='+$(this).val();
                   break;
           case '4':
                    var hrefval = 'pedirview.php?value='+$(this).val();
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                     //window.location.href = 'svtrendview.php?value='+$(this).val();
                    break;
           case '5':
                    var hrefval = 'pedirview.php?value='+$(this).val();
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                   // window.location.href = 'svtrendview.php?value='+$(this).val();
                   break;
            case '6':
                   window.location.href = 'pedirview.php?value='+$(this).val();
                   break;
            
       }
       

});


 $('.exist-nav').on('ifChecked', function(event){
       navvalue=$(this).val();
            
           <?php if($_SESSION['vconly']!=1){ ?>
            var current_tour = hopscotch.getCurrStepNum();
           <?php } else {?>  
            var current_tour = '';
           <?php } ?>
          
     
        
        if(Directorydemotour==1 && current_tour!=11){
                    showErrorDialog(warmsg);
                     return false;
                }                 
        else if(Directorydemotour==1 && current_tour==11){
            
            if(navvalue!='PE-EXIST') { showErrorDialog(warmsg); return false; }            
        }        
       
                
                      
       switch(navvalue)
       {
           case 'PE-BACKED-IPO':
                   window.location.href = 'pedirview.php?value=7';
                   break;
           case 'VC-BACKED-IPO':
                   window.location.href = 'pedirview.php?value=8';
                   break;
           case 'PMS':
                   window.location.href = 'pedirview.php?value=9';
                   break;
           case 'VCPMS':
                   window.location.href = 'pedirview.php?value=12';
                   break;  
           case 'PE-EXIST':
                   window.location.href = 'pedirview.php?value=10';
                   break;
           case 'VC-EXIST':
                   window.location.href = 'pedirview.php?value=11';
                   break;
               
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

<?php 
if($vcflagValue>=7){ ?>
.investment-form h3{
  opacity: 0.5;
}
.investment-form h3:hover{
  opacity: 1;
}
<?php } else { ?>
.exit-form h3{
  opacity: 0.5;
}
.exit-form h3:hover{
  opacity: 1;
}
<?php } ?>


</style>
<script type="text/javascript">
                                                        
function industrypesearch()
{
    var sltindustry = $("#sltindustry").val();
       
     if(Directorydemotour==1){
            if(sltindustry==14) {            
               $('#stage').attr("disabled","disabled");
               $("#pesearch").submit(); 
            }
            else {  showErrorDialog(warmsg); return false; }
       }
       else
           {
               $("#pesearch").submit();
           }
                    
}
</script>
</head>

<?php if($_SESSION['PE_TrialLogin']==1){ ?>
<body class="page-dir"> 
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
$(document).on('click','.request-for-lp,.request-lp',function(){
            
            jQuery('#maskscreen').fadeIn(1000);
            jQuery('#ymessage').val('');
            jQuery('#popup-box-lp').fadeIn();   
            return false;
           });
           $(document).on('click','#cancelbtn-lp',function(){
          
            jQuery('#maskscreen').fadeOut();
            jQuery('#popup-box-lp').fadeOut();   
            return false;
           });
</script>
    <?php include_once('definitions.php');
    include_once('refinedef.php');?>
<!--Header-->
<?php
   $actionlink="pedirview.php?value=".$vcflagValue;
?>
<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 632px; display: none;"></div>
<div class="lb" id="popup-box-lp" style="    width: 450px;">
    <div class="title" style="font-size: 16px;"> Request for - LP Directory </div>
        <form style="margin-bottom: 0px;">
            <div class="entry">
                    <h5>Add a note..</h5><span style='float:right;display: block;margin-top: -20px;'></span>
                    <textarea name="ymessage" id="ymessage" style="width: 420px; height: 57px;" placeholder="For example, enter your phone number and convenient time for a call" val=''></textarea>
                    <input type="hidden" id="useremail" value="<?php echo $_SESSION['UserEmail']; ?>"/>
            </div>
            <div class="entry">
                <input type="button" value="Submit" id="mailbtn-lp" />
                <input type="button" value="Cancel" id="cancelbtn-lp" />
                <span style="padding: 3px 0px;">(Alternatively please call us at +91 44 42185180)</span>
            </div>

        </form>
    </div>

 <form name="pesearchshowby" action="" method="post" id="pesearchshowby">
        <input type="hidden" value="<?php echo $dealvalue?>" name="showdeals" id="getdealvalue">           
 </form> 

<form name="searchall" action="<?php echo $actionlink; ?>" method="post" id="searchall">    
<div id="header">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="left-box"> <div class="logo-img"> <a href="index.php"><img src="images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></td>


<td class="right-box">
     <?php include('top_menu.php'); ?>
<!--<ul class="tour-lock">
<li <?php echo ($topNav=='Dashboard') ? 'class="active"' : '' ; ?>><a href="dashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li <?php echo ($topNav=='Deals') ? 'class="active"' : '' ; ?>><a href="index.php"><i class="i-data-deals"></i>Deals</a></li>
<li <?php echo ($topNav=='Directory') ? 'class="active"' : '' ; ?> id="tour_directory"><a href="pedirview.php?value=0"><i class="i-directory"></i>Directory</a></li>
<li <?php echo ($topNav=='Funds') ? 'class="active"' : '' ; ?>><a href="funds.php"><i class="i-directory"></i>Funds <span class="betaversion">Beta</span></a></li>
<!--li <?php echo ($topNav=='Report') ? 'class="active"' : '' ; ?>><a href="report.php"><i class="i-directory"></i>Report</a></li
</ul>-->
<ul class="fr">
    
    <!-- <li class="classic-btn tour-lock" id="classic-btn"><a href="http://www.ventureintelligence.com/deals/dealhome.php" >Classic View</a></li> -->
     <?php //include('TourStartbtn.php'); ?>
     <input type="hidden" value="<?php echo $dealvalue?>" name="showdeals" id="getdealvalue"> 
     <li class="classic-btn tour-lock"><a href="pefaq.php" id="faq-btn" style="opacity: 1;">FAQ</a></li> 
<li ><div style="float:right;padding: 9px 15px" class="key-search"><b></b> <input type="text" name="searchallfield" placeholder="Search" value="<?php if($searchallfield!="") echo $searchallfield; ?>" style="padding:5px;"  /> 
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
<form name="pesearch" action="<?php echo $actionlink; ?>" method="post" id="pesearch">  
 
<?php
$passwrd = $_GET['value'];
if($passwrd != 'P')
{
?>
<div id="sec-header" class="sec-header-fix dealsindex">
<table cellpadding="0" cellspacing="0">
<tr>
    <td class="investment-form">
<h3 class="ttl3">INVESTMENTS</h3>
<div class="investmentlabel frmDropDown">
<div>
<label><input class="investment-nav" name="investments" type="radio" value=0  <?php if($vcflagValue==0) { ?> checked="checked" <?php } ?>  /> PE</label>
<label><input class="investment-nav" name="investments" type="radio" value=4  <?php if($vcflagValue==4) { ?> checked="checked" <?php } ?>/>Cleantech</label>
<label><input class="investment-nav" name="investments" type="radio" value=5  <?php if($vcflagValue==5) { ?> checked="checked" <?php } ?>/>Infrastructure</label>
<label><input class="investment-nav" name="investments" type="radio" value=1  <?php if($vcflagValue==1) { ?> checked="checked" <?php } ?>/> VC</label>
<label><input class="investment-nav" name="investments" type="radio" value=2  <?php if($vcflagValue==2) { ?> checked="checked" <?php } ?>/>Angel</label>
<label><input class="investment-nav" name="investments" type="radio" value=6  <?php if($vcflagValue==6) { ?> checked="checked" <?php } ?>/>Incubation</label>
<label><input class="investment-nav" name="investments" type="radio" value=3  <?php if($vcflagValue==3) { ?> checked="checked" <?php } ?>/>Social VC</label>
</div>

</div>

<!--<div id="invspecialisedsocial" class="">
</div>-->

<!-- <div id="investmentsspecialised" class="">
<label><input class="investment-nav" name="investments" type="radio" value=4  <?php if($vcflagValue==4) { ?> checked="checked" <?php } ?>/>Cleantech</label>
<label><input class="investment-nav" name="investments" type="radio" value=5  <?php if($vcflagValue==5) { ?> checked="checked" <?php } ?>/>Infrastructure</label></div> -->
</td>



<td class="exit-form">
<h3 class="ttl3">EXITS <!--VIA--></h3>
<div class="exitslabel frmDropDown">
<div>
<label id="PEmaexits_tour"><input class="exist-nav" name="investments" type="radio" value="PE-EXIST" <?php if($vcflagValue==10) { ?> checked="checked" <?php } ?>/>M&A(PE) </label>
<label id="PEpublicexits_tour"><input class="exist-nav" name="investments" type="radio" value="PMS" <?php if($vcflagValue==9) { ?> checked="checked" <?php } ?>/> Public Market(PE)</label>
<label><input class="exist-nav" name="investments" type="radio" value="PE-BACKED-IPO" <?php if($vcflagValue==7) { ?> checked="checked" <?php } ?>/>IPO(PE)</label>
<label><input class="exist-nav" name="investments" type="radio" value="VC-EXIST" <?php if($vcflagValue==11) { ?> checked="checked" <?php } ?> />M&A(VC) </label>
<label><input class="exist-nav" name="investments" type="radio" value="VCPMS" <?php if($vcflagValue==12) { ?> checked="checked" <?php } ?> />Public Market(VC) </label>
<label><input class="exist-nav" name="investments" type="radio" value="VC-BACKED-IPO" <?php if($vcflagValue==8) { ?> checked="checked" <?php } ?>/>IPO(VC)</label>

</div>
</div>
</td>
<td class="vertical-form">
<?php 

if($_GET['value']==0){ ?>
<h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> PE</h3>
<?php }elseif($_GET['value']==1 || $strvalue[1]==1){ ?>
<h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> VC</h3>
<?php }elseif($_GET['value']==2 || $strvalue[1]==2){ ?>
<h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> Angel</h3>
<?php }elseif($_GET['value']==3 || $strvalue[1]==3){ ?>
<h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> Social VC</h3>
<?php }elseif($_GET['value']==4 || $strvalue[1]==4){ ?>
<h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> Cleantech</h3>
<?php }elseif($_GET['value']==5 || $strvalue[1]==5){ ?>
<h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> Infrastructure</h3>
<?php }elseif($_GET['value']==6|| $strvalue[1]==6){ ?>
<h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> Incubation</h3>
<?php }elseif($_GET['value']==7 || $strvalue[1]==7){ ?>
<h3 id="investmenttype">Exits <span style="padding-left: 2px;padding-right: 2px;">></span> IPO(PE)</h3>
<?php }elseif($_GET['value']==8 || $strvalue[1]==8){ ?>
<h3 id="investmenttype">Exits <span style="padding-left: 2px;padding-right: 2px;">></span> IPO(VC)</h3>
<?php }elseif($_GET['value']==9 || $strvalue[1]==9){ ?>
<h3 id="investmenttype">Exits <span style="padding-left: 2px;padding-right: 2px;">></span> Public Market(PE)</h3>
<?php }elseif($_GET['value']==10 || $strvalue[1]==10){ ?>
<h3 id="investmenttype">Exits <span style="padding-left: 2px;padding-right: 2px;">></span> M&A(PE)</h3>
<?php }elseif($_GET['value']==11 || $strvalue[1]==11){ ?>
<h3 id="investmenttype">Exits <span style="padding-left: 2px;padding-right: 2px;">></span> M&A(VC)</h3>
<?php }elseif($_GET['value']==12 || $strvalue[1]==12){ ?>
<h3 id="investmenttype">Exits <span style="padding-left: 2px;padding-right: 2px;">></span> Public Market(VC)</h3>
<?php }
else{ ?>
    <h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> PE</h3>
<?php }    ?>
<div class="sort-by-date">
<div>    
<?php if($vcflagValue != 6){?>
<div class="showdealsby">
<label id="peinvestor_tour"><input  class="show-nav" name="showdeals" type="radio"  value=101  <?php if($dealvalue==101) { ?> checked="checked" <?php } ?>/> Investor</label>

<?php if($vcflagValue == 2){?>
<label id="peinvestor_tour1"><input  class="show-nav" name="showdeals" type="radio"  value=102  <?php if($dealvalue==102) { ?> checked="checked" <?php } ?>/> Funded Companies</label>
<label id="peinvestor_tour1"><input  class="show-nav" name="showdeals" type="radio"  value=110  <?php if($dealvalue==110) { ?> checked="checked" <?php } ?>/> Fundraising Companies 
<!--    <img src="img/angle-list.png" alt="angle-list" style=" width: 100px;float: right; margin-left: 5px;">-->
</label>
<?php }else {?> 
<label id="peinvestor_tour1"><input  class="show-nav" name="showdeals" type="radio"  value=102  <?php if($dealvalue==102) { ?> checked="checked" <?php } ?>/>Company</label>
<?php } ?>


<?php 
if($vcflagValue==0 || $vcflagValue==1 || $vcflagValue==3 || $vcflagValue==4 || $vcflagValue==5 || $vcflagValue==9 || $vcflagValue==10 || $vcflagValue==11 || $vcflagValue==12)
{  
?>
<label id="PElegalad_tour"><input  class="show-nav" name="showdeals" type="radio"  value=103  <?php if($dealvalue==103) { ?> checked="checked" <?php } ?>/>Legal Advisor</label>
<label  id="peinvestor_tour2"><input  class="show-nav" name="showdeals" type="radio"  value=104  <?php if($dealvalue==104) { ?> checked="checked" <?php } ?>/>Transaction Advisor</label>
<?php if($usrRgs['LPDir']!=0){?>
<label  id="peinvestor_tour3"><input  class="show-nav" name="showdeals" type="radio"  value=111  <?php if($dealvalue==111) { ?> checked="checked" <?php } ?>/>Limited Partners</label>
<?php
}else{
  ?>   <label disabled  id="peinvestor_tour3"><input   class="show-nav" name="showdeals" 
type="radio" disabled value=111 />
Limited Partners <span class="request-for-lp"><i class="fa fa-lock" aria-hidden="true" style="
    background-image: none;    font-size: 15px;
"></i></span> </label>  <?php
}
}
?></div>
    <?php
    }
    else
    {
    ?> 
<div class="showdealsby">
<label><input  class="show-nav" name="showdeals" type="radio"  value=105  <?php if($dealvalue==105) { ?> checked="checked" <?php } ?>/> Incubator/Accelerator</label>
<label><input  class="show-nav" name="showdeals" type="radio"  value=106  <?php if($dealvalue==106) { ?> checked="checked" <?php } ?>/>Incubatee</label>
</div>
    
    <?php 
    }
    ?>
</div>
</div>
</td>
</tr>
</table>
</div>
    <?php
}
}
?>
<script type="text/javascript">
 
<?php if($vcflagValue==0 || $vcflagValue==4 || $vcflagValue==5) { ?> 
    $("#investmentspe").show();  
     $("#investmentsvc").hide();
     $("#investmentsspecialised").show();
     $("#invspecialisedsocial").hide();
     
    
<?php } else if($vcflagValue==2 || $vcflagValue==1 || $vcflagValue==6 || $vcflagValue==3) { ?>
     $("#investmentspe").hide();  
     $("#investmentsvc").show();
      $("#invspecialisedsocial").show();
     $("#investmentsspecialised").hide();
    
<?php } ?>
    
    
    <?php if($vcflagValue==7 || $vcflagValue==9 || $vcflagValue==10) { ?> 
   $("#exitsviape").show();  
        $("#exitsviavc").hide();
     
    
<?php } else if($vcflagValue==8 || $vcflagValue==11   || $vcflagValue==12 ) { ?>
     $("#exitsviape").hide();  
        $("#exitsviavc").show();
<?php } ?>

//$('.investment-form select, .exit-form select').switchify();
//      
//    $('.ui-switch-middle').removeClass('ui-switch-middle');  	
	
         $('#investmentswitch').change(function() {
        thisvalue= $(this).val();
        if(thisvalue=="investmentspe")
        {
        
        $("#investmentspe").show();  
        $("#investmentsvc").hide();
        $("#investmentsspecialised").show();
        $("#invspecialisedsocial").hide(); 
        
        var getdealvalue = $("#getdealvalue").val();
       
        if(getdealvalue==101 || getdealvalue==102 || getdealvalue==103 || getdealvalue==104){
                $("#pesearchshowby").attr("action","pedirview.php?value=0");
                $("#pesearchshowby").submit();                    
        }
        else{
            window.location.href ='pedirview.php?value=0';
        }
        
        return false;
        
        }
        else {
        //window.location.href ='pedirview.php?value=1';    
        $("#investmentspe").hide();  
        $("#investmentsvc").show();
        $("#invspecialisedsocial").show();
        $("#investmentsspecialised").hide();
        
        var getdealvalue = $("#getdealvalue").val();
       
        if(getdealvalue==101 || getdealvalue==102 || getdealvalue==103 || getdealvalue==104){
                $("#pesearchshowby").attr("action","pedirview.php?value=1");
                $("#pesearchshowby").submit();                    
        }
        else{
            window.location.href ='pedirview.php?value=1';
        }
        
        return false;
        
        }
        });
	
	
        
        
	$('#exitswitch').change(function() { 
        thisvalue= $(this).val();
        if(thisvalue=="1")
        {
        //window.location.href ='pedirview.php?value=10';  
        $("#exitsviape").show();  
        $("#exitsviavc").hide();
        var getdealvalue = $("#getdealvalue").val();
       
        if(getdealvalue==101 || getdealvalue==102 || getdealvalue==103 || getdealvalue==104){
                $("#pesearchshowby").attr("action","pedirview.php?value=7");
                $("#pesearchshowby").submit();                    
        }
        else{
            window.location.href ='pedirview.php?value=7';
        }
        
        return false;
       
        }
        else{ 
       // window.location.href ='pedirview.php?value=11';      
        $("#exitsviape").hide();  
        $("#exitsviavc").show();
        var getdealvalue = $("#getdealvalue").val();
       
        if(getdealvalue==101 || getdealvalue==102 || getdealvalue==103 || getdealvalue==104){
                $("#pesearchshowby").attr("action","pedirview.php?value=8");
                $("#pesearchshowby").submit();                    
        }
        else{
            window.location.href ='pedirview.php?value=11';
        }
        
        return false;
       
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


$(document).ready(function(){  
$("#peinvestor_tour,#PElegalad_tour,#peinvestor_tour1,#peinvestor_tour2").click(function() {     
        if(Directorydemotour==1)
         { 
            
            var current_tour = hopscotch.getCurrStepNum(); 
            if(current_tour==12){
                 $('#peinvestor_tour div,#peinvestor_tour1 div,#peinvestor_tour2 div').removeClass("checked");  
            }
            else {
            $('#PElegalad_tour div,#peinvestor_tour1 div,#peinvestor_tour2 div').removeClass("checked");   
            $('#peinvestor_tour div').addClass("checked"); 
            }
         }
         }); 
         
 $("#PEmaexits_tour,#PEpublicexits_tour").click(function() {     
        if(Directorydemotour==1)
         { 
            var current_tour = hopscotch.getCurrStepNum(); 
            if(current_tour>=9 && current_tour<11){
            $('#PEmaexits_tour div,#PEpublicexits_tour div').removeClass("checked");
            }
            else if(current_tour==11){
            $('#PEpublicexits_tour div').removeClass("checked"); 
            }
         }
         });         
         
         
});
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
<style>
    .result-title li {
        margin: 0px 10px 10px 10px;
    }
</style>
    