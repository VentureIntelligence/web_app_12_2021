<?php include_once("../globalconfig.php");
 require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
    if(!isset($_SESSION['UserNames']))
    {
            header('Location:../pelogin.php');
    }
    else
    {?>
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
<title>Venture Intelligence</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link href="css/skin.css" rel="stylesheet" type="text/css" />  
<link href="css/popstyle.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" type="text/css" href="css/detect800.css" />
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
<!--<script type="text/javascript" src="js/jquery.tablesorter.js"></script>-->
<script type="text/javascript" src="js/popup.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<!--<link rel="stylesheet" href="/resources/demos/style.css" />-->

<script type="text/javascript" src="js/jquery.multiselect.js"></script> 
  <script type="text/javascript" src="js/expand.js"></script>
 <script src="js/showHide.js" type="text/javascript"></script>
 <script src="js/jquery.flexslider.js"></script>
<script src="js/jquery.masonry.min.js"></script>
<!--  <script src="js/switch.min.js" type="text/javascript"></script>-->
<!-- <link href="css/switch.css" type="text/css" rel="stylesheet">-->

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
<script src="js/jquery.icheck.min.js?v=0.9.1"></script>
<script src="js/jquery.flexslider.js"></script>
<!-- Masonry -->
<script src="js/jquery.masonry.min.js"></script>
<script type="text/javascript" src="js/jquery.responsivetable.js"></script>
<script>
    $(document).ready(function() {
    $('.testTable1').responsiveTable( {scrollRight: false, scrollHintEnabled: false} );
});
</script>

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
      $('input').iCheck({
        checkboxClass: 'icheckbox_flat-red',
        radioClass: 'iradio_flat-red'
      });
     
    });
    
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
          }
         
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
   $(function() {
    $( "#investorauto_old" ).autocomplete({
    
      source: function( request, response ) {  
      
        $('#investorsearch').val('');
        $.ajax({
          type: "POST",
          url: "ajaxFundInvDetails.php",
          dataType: "json",
          data: {
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
      minLength: 2,
      select: function( event, ui ) {
          
       $("#month1").val('1');
       $("#month2").val('1');
       $("#year1").val('2006');
       $("#year2").val('<?php echo date('Y')?>');
       
       
       $('#investorauto').val(ui.item.value);
       $('#investorsearch').val(ui.item.id);
       this.form.submit();
      },
      open: function() {
            $( this ).autocomplete('widget').css('z-index',2000);
//        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
          if(  $('#investorsearch').val()=="")
             $( "#investorauto" ).val('');  
      }
    });
    });
    
    
    
    
        ////////////// investor search start //////////////////////
   $(document).ready(function() {  
    
      $( "#investorauto" ).keyup(function() {
             
             var investorauto = $("#investorauto").val();
              
             if(investorauto.length > 2 ) {
                    $.ajax({
                       type: "POST",
                        url: "ajaxFundInvDetails.php",
                        dataType: "json",
                     data: {                       
                        search: investorauto
                     },
                     success: function(data) {
                         
                          var innerdata=data;
                         var datacount = innerdata.length;   
                          
                         
                          
                          if(datacount>0) {
                              var multiselect='';
                              
                              if(datacount>1){
                          
                           multiselect+='<label  style="clear: both;  padding: 1px 5px;"> <input type="checkbox" id="inv_selectall"> SELECT ALL</label><br>';
                            }
                            $.each(innerdata, function (key, item) {
                                
                               multiselect+="<label style='clear: both;  padding: 1px 5px;'><input type='checkbox' name='investor_multi[]' value='"+item['id']+"' class='investor_slt' data-title='"+item['value']+"' >"+item['value']+"</label>";

                            });
                            
                            multiselect+="</br></br>"; 
                            
                            $("#sec-header, .sec-header-fix").css('overflow','inherit');
                            $("#investorauto_load").fadeIn();
                            $("#investorauto_load").html(multiselect);
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
                  
                  $("#multi_invSearch").show();
                  
                  $("#investorauto").attr('readonly','readonly'); 
                  $("#investorauto").val(sltholder);
                  $("#investorsearch").val(sltinvestor_multi); 
                  $("#inv_clearall").fadeIn();
             }
             else{
               //  sltcount=0;sltholder='';
                   $("#inv_clearall, #multi_invSearch").fadeOut(); 
                   $("#investorauto").removeAttr('readonly');
                   $("#investorauto").val('');
             }
//                $("#investorauto").attr('readonly','readonly');  
//                $("#investorauto").val(sltholder); 
//                $("#investorauto_load").show();
        });    
    
      $('.investor_slt').live("click", function() {  //on click 
                      
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
                             
                             $("#multi_invSearch").show();
                             $("#investorauto_load").show();
                              //sltuserscout++;
                          }
                          
                     });
                     
                    $("#investorauto").attr('readonly','readonly');  
                    $("#investorauto").val(sltholder); 
                    $("#investorsearch").val(sltinvestor_multi); 
                    
                    
                    if(sltcount==0){  $("#inv_clearall, #multi_invSearch").fadeOut(); $("#investorauto").removeAttr('readonly');   }
                    else {   $("#inv_clearall").fadeIn();  }
                        
        if($(".investor_slt").length==$(".investor_slt:checked").length){
            
            $("#inv_selectall").attr("checked","checked");
        }else{
            $("#inv_selectall").removeAttr("checked");
        }
                     
                 
             });
             
             
             

        $('#multi_invSearch').live("click", function() {
             $("#month1").val('1');
            $("#month2").val('<?php echo date('n'); ?>');
            $("#year1").val('2006');
            $("#year2").val('<?php echo date('Y')?>');     
         }); 
         
         
         
          $("#container").mouseup(function (e){ 
                $("#investorauto_load").hide();
            });


      }); 
      
    


function clear_keywordsearch(){
     $("#investorauto").removeAttr('readonly');  
     val='';
     $("#investorsearch, #investorauto").val(val); 
      $("#investorauto_load, #multi_invSearch").fadeOut();
     $("#inv_clearall").fadeOut(); 
 }
 



     ////////////// investor search end //////////////////////       
    
    
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
$(document).ready(function() {
 
  $(".datesubmit").click(function() {
      
    var year1=$('#year1').val();
    var year2=$('#year2').val();
     
    var month1=$('#month1').val();
    var month2=$('#month2').val();
        
	if(year1 > year2)
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


     $('.investment-nav').on('ifChecked', function(event){
         
        var navvalue=$(this).val();
        
        if(navvalue==1){
            
            var hrefval = 'funds.php?status='+$(this).val();
            window.location.href = hrefval;
        }else{
            var hrefval = 'funds.php?status='+$(this).val();
            window.location.href = hrefval;
        }
});
});
function checkForAggregates()
{
	document.manda.hiddenbutton.value='Aggregate';
	document.manda.submit();
}
function checkForDate()
{
	var year1=$('#year1').val();
	var year2=$('#year2').val();
        
        var month1=$('#month1').val();
        var month2=$('#month2').val();
	
	if(year1 > year2)
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
<script type="text/javascript" src="//www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
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
<body class="page-funds"> 
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
    <?php include_once('definitions.php');?>
    <?php include_once('refinedef.php');?>
<!--Header-->
<?php 
    $actionlink="funds.php";
?>

<form name="searchall" action="<?php echo $actionlink; ?>" method="post" id="searchall">    
<div id="header">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="left-box"> <div class="logo-img"> <a href="index.php"><img src="images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></td>


<td class="right-box">
     <?php include('top_menu.php'); ?>
<!--<ul>
<li <?php echo ($topNav=='Dashboard') ? 'class="active"' : '' ; ?>><a href="dashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li <?php echo ($topNav=='Deals') ? 'class="active"' : '' ; ?>><a href="index.php"><i class="i-data-deals"></i>Deals</a></li>
<li <?php echo ($topNav=='Directory') ? 'class="active"' : '' ; ?>><a href="pedirview.php?value=0"><i class="i-directory"></i>Directory</a></li>
<li <?php echo ($topNav=='Funds') ? 'class="active"' : '' ; ?>><a href="funds.php"><i class="i-directory"></i>Funds <span class="betaversion">Beta</span></a></li>
<!--li <?php echo ($topNav=='Report') ? 'class="active"' : '' ; ?>><a href="report.php"><i class="i-directory"></i>Report</a></li
</ul>-->
    
<ul class="fr">
    <!-- <li class="classic-btn"><a href="<?php echo GLOBAL_BASE_URL; ?>deals/dealhome.php" >Classic View</a></li> -->
    <?php //include('TourStartbtn.php'); ?>
    
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
<?php } ?>
</li>
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
    <!--div id="sec-header" class="sec-header-fix"-->
<div id="sec-header" class="sec-header-fix">
<table cellpadding="0" cellspacing="0">
<tr>

         <td class="investment-form" style="position:relative;width:460px !important;">
            <h3>INVESTOR</h3>
          
            <input type="text" id="investorauto" autocomplete="off" name="investorauto" value="<?php if(isset($_REQUEST['investorauto'])) echo  $_REQUEST['investorauto'];  ?>" placeholder="" style="width:220px;height:25px;z-index:1111;"  <?php if($_REQUEST['investorauto']!='') echo 'readonly="readonly"';  ?> >
            <input type="hidden" id="investorsearch" name="investorsearch" value="<?php if(isset($_REQUEST['investorsearch'])) echo  $_REQUEST['investorsearch'];  ?>" placeholder="" style="width:220px;z-index:1111;">
                <input name="multi_invSearch" type="submit" value="Search" id="multi_invSearch" style="padding: 5px 5px;  margin-top: -1px; display: none">    
            <span id="inv_clearall" title="Clear All" onclick="clear_keywordsearch();" style="<?php if($_REQUEST['investorsearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 6px;  left: 315px;  padding: 7px;">(X)</span>
            <div id="investorauto_load" style=" position: absolute;  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;margin-left:106px;color:black;">

            </div>
            
        </td>
            <?php /*if($_REQUEST['cstatus']!='') {*/ 

            if($_REQUEST['status']==2){
                
                $display="block";
                if(count($_REQUEST['cstatus']) == 0){
                    $_REQUEST['cstatus'] = array(1,2,3);
                }
                $width = "275px";
            }
            else{
                $display="none";
                $width = "125px";
            }
            ?>
        <td class="investment-form" style="position:relative;width:<?php echo $width; ?>">
            <h3 class="ttl3">Status</h3>
            <div class="investmentlabel frmDropDown" style="padding: 0px 25px 5px 0px;">
                <label   id="petour2"><input class="investment-nav" name="status" type="radio" value=1  <?php if($status==1) { ?> checked="checked" <?php } ?>/>Raising</label>
                <label   id="petour3"><input class="investment-nav" name="status" type="radio" value=2  <?php if($status==2) { ?> checked="checked" <?php } ?>/>Closed</label>
            </div>
  

           
          
            <div class="selectgroup" id="selectcstatus" style="display:<?php echo $display; ?>;float: right;margin-top: 5px;">
                    <?php

                $sqlfundClosed = "select * from fundCloseStatus";
                        if ($closedstatusrs = mysql_query($sqlfundClosed)){
                                $closedst_cnt = mysql_num_rows($closedstatusrs);
                } ?>
                
                
                    <select name="cstatus[]" multiple="multiple" size="3" id='cstatus' style="width:100px;">
                    <?php

                       
                        if($closedst_cnt > 0){
                            $i=1;
                            While($myrow=mysql_fetch_array($closedstatusrs, MYSQL_BOTH)){
                                $id = $myrow[0];
                                $name = $myrow[1];
                                $isselect='';
                                if($_REQUEST['cstatus']!='')
                                {
                                    for($i=0;$i<count($_REQUEST['cstatus']);$i++){
                                        $isselect = ($_REQUEST['cstatus'][$i]==$id) ? "SELECTED" : $isselect;
                                    }
                                    echo '<OPTION value="'.$id.'" '.$isselect.'>'.$name.'</OPTION> \n';
                                }
                                else
                                {
                                     //$isselected = ($getstage==$name) ? 'SELECTED' : '';
                                    echo "<OPTION id=".$id. " value=".$id." >".$name."</OPTION> \n";
                                }
                            }
                            mysql_free_result($type2rs);
                        }

                     ?>
                    </select> 
                    <input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();" style="vertical-align: -webkit-baseline-middle;">
                </div>
                
            <?php // } ?>
        </td>
<td class="vertical-form">
        <!-- <h3>DATE</h3> -->
        <div style="float: right;">
<div class="period-date">
<label>From</label>
<SELECT NAME="month1" id="month1">
     <OPTION id=1 value=""> Month </option>
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
		$yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates desc";
		if($yearSql=mysql_query($yearsql))
		{
                        if($type == 1)  
                        {
                            if($_POST['year1']=='')
                            {
                                $year1;
                            }
                        }
                        else
                        {
                            if($_POST['year1']=='')
                            {
                                $year1;
                            }
                        }
                        
                        $currentyear = date("Y");
                        if($topNav == 'Funds') { 
                            $start_yr=2006;                             
                        } else { 
                            $start_yr=1998;                             
                        }
                        $i = $currentyear;
                                While($i>= $start_yr )
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
      <OPTION id=1 value=""> Month </option>
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
                        $yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates desc";
                 if($_POST['year2']=='')
                {
                    $year2=date("Y");
                }
		if($yearSql=mysql_query($yearsql))
		{
			/*While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$id = $myrow["Year"];
				$name = $myrow["Year"];
				$isselcted = ($year2== $id) ? 'SELECTED' : '';
				echo "<OPTION id=". $id. " value='". $id."' ".$isselcted.">".$name."</OPTION>\n";
			}*/
                    $currentyear = date("Y");
                        if($topNav == 'Funds') { 
                            $start_yr=2006;                             
                        } else { 
                            $start_yr=1998;                             
                        }
                        $i = $currentyear;
                        While($i>= $start_yr )
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
  <div class="search-btn"  > <input name="searchpe" type="submit" value="Search" class="datesubmit" /></div>
        </div>
</td>
 
</tr>
</table>
</div>
<?php
}
?>
<script>
 $(document).ready(function(){
 
    $('#selectcstatus').find('button').css("width", "100px");
    $('#selectcstatus').find('button').css("vertical-align","-webkit-baseline-middle");
});
<?php if($vcflagValue==0 || $vcflagValue==4 || $vcflagValue==5) { ?> 
    $("#investmentspe").show();  
     $("#investmentsvc").hide();
     $("#investmentsspecialised").show();
     $("#invspecialisedsocial").hide();
     
    
<?php } else if($vcflagValue==2 || $vcflagValue==1 || $vcflagValue==6 || $vcflagValue==3) { 
    ?>
     $("#investmentspe").hide();  
     $("#investmentsvc").show();
      $("#invspecialisedsocial").show();
     $("#investmentsspecialised").hide();
    
<?php } ?>

//$('.investment-form select, .exit-form select').switchify();
      
//    $('.ui-switch-middle').removeClass('ui-switch-middle');  	
	
/*     $('.investmentlabel .ui-switch-off').click(function() {   
        $("#investmentspe").show();  
        $("#investmentsvc").hide();
        $("#investmentsspecialised").show();
        $("#invspecialisedsocial").hide();
    });	 
        $('.investmentlabel .ui-switch-on').click(function() {   
        $("#investmentspe").hide();  
        $("#investmentsvc").show();
        $("#invspecialisedsocial").show();
        $("#investmentsspecialised").hide();
    }); */
    
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
                window.location.href = 'ipoindex.php?value=0';
                break;
           case '0':
                window.location.href = 'ipoindex.php?value=1';
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

    $(".ttl3").click(function() {
        $(this).toggleClass('active').next('.frmDropDown').toggleClass("active");
     });
</script> 
<?php } ?>