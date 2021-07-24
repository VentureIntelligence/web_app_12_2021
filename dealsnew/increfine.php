<?php 
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
if(!isset($_SESSION['UserNames']))
{
        header('Location:../pelogin.php');
}
else
{
 $showdealsbyflag=0; 
 
 if(($keyword!="" && $keyword!=" ") || ($companysearch!="" && $companysearch!=" "))
 {
 $showdealsbyflag=1;    
        $disable_flag = "1";
        $background = "#dddddd  !important";    
 }else{
        $disable_flag = "0";
        $background = "#ffffff";       
 }
     
?>
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
            vcflag: '<?php echo $VCFlagValue; ?>',
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
            prePopulate :<?php if($tag_response!=''){echo   $tag_response; }else{ echo 'null'; } ?>
    });
    
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
          <?php if($_POST['tagsearch']){
                $tagauto = $_POST['tagsearch'];            
            } ?>
            <li class="ui-widget">
            <input type="hidden" id="tagsearch" name="tagsearch" value="<?php echo  $tagsearch;  ?>" placeholder="" style="width:220px;">
            <input type="text" id="tagsearch_auto" name="tagsearch_auto" value="<?php echo  $tagsearch;  ?>" placeholder="" style="width:220px;"> 
            <input type="hidden" id="tagradio" name="tagradio" value="<?php if($tagandor!=''){echo $tagandor;}else {echo 0;}?>" placeholder="" style="width:220px;"> 
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
        <select name="industry" id="industry" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
    <OPTION id=0 value="--" selected> Select an Industry </option>
    <?php
      if ($industryrs = mysql_query($industrysql_search))
      {
       $ind_cnt = mysql_num_rows($industryrs);
      }
      if($ind_cnt>0)
      {
         While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
        {
          $id = $myrow[0];
          $name = $myrow[1];
          $isselected = ($industry==$id) ? 'SELECTED' : '';
          echo "<OPTION id=".$id. " value=".$id." ".$isselected.">".$name."</OPTION> \n";
        }
        mysql_free_result($industryrs);
      }
      ?>
    </select>
    </li>
    <li class="odd range-to"><h4>Year Founded</h4>
                <select name="yearafter" id="yearafter"  style=" background: <?php echo $background; ?>; " <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                           <option value=''></option>
                           <!-- <?php //for($i=1920; $i<=date("Y"); $i++){?> -->
                           <?php for($i=date("Y"); $i>=1920; $i--){?>
                              <option value='<?php echo $i ?>' <?php if($yearafter == $i) echo 'selected'; ?>><?php echo $i ?></option>
                           <?php } 
                           ?>
                           </select>
                <span class="range-text"> to</span> 
                <select name="yearbefore" id="yearbefore"  style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                            <option value=''></option>
                            <!-- <?php //for($i=1920; $i<=date("Y"); $i++){?> -->
                            <?php for($i=date("Y"); $i>=1920; $i--){?>
                              <option value='<?php echo $i ?>' <?php if($yearbefore == $i) echo 'selected'; ?>><?php echo $i ?></option>
                           <?php } 
                           ?>
                           </select>
            </li>
<li class="odd"><h4>Status</h4>
    <SELECT NAME="statusid" id="statusid" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                 <OPTION id=5 value="--" selected> ALL </option>
                 <?php
                        /* populating the incubator status from the incstatus table */
                        $invtypesql = "select StatusId,Status from incstatus order by Status";
                        if ($invtypers = mysql_query($invtypesql))
                        {
                           $invtype_cnt = mysql_num_rows($invtypers);
                        }
                        if($invtype_cnt >0)
                        {
                             While($myrow=mysql_fetch_array($invtypers, MYSQL_BOTH))
                            {
                                    $id = $myrow["StatusId"];
                                    $name = $myrow["Status"];
                                    $isselected = ($status==$id) ? 'SELECTED' : '';
                                     echo "<OPTION id=".$id. " value=".$id." ".$isselected.">".$name."</OPTION> \n";
                            }
                 mysql_free_result($invtypers);
                }
        ?>
             </SELECT>
</li>


<li class="even"><input name="chkDefunct" id="chkDefunct" type="checkbox" value="1" <?php if($defunctflag == "1")
                { echo "checked"; } ?> style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>> Exclude Defunct Cos</li>

<li>
    <input type="button" name="fliter_stage" class="fliter_stage" value="Filter" onclick="submitfilter();" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
    </li>

<li class="odd"><h4>Firm Type</h4>
    <SELECT NAME="txtfirmtype" id="txtfirmtype" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
        <OPTION id=6 value="0" selected> All </option>
        <?php
               /* populating the incubator firm type from incfirmtypes table*/
               $incfirmtypesql = "select IncFirmTypeId,IncTypeName from incfirmtypes where IncTypeName!='' order by IncFirmTypeId";
                       if ($incfirmrs = mysql_query($incfirmtypesql))
                       {
                  $incfirm_cnt = mysql_num_rows($incfirmrs);
                       }
                 if($incfirm_cnt >0)
               {
                While($myfirmrow=mysql_fetch_array($incfirmrs, MYSQL_BOTH))
               {
                       $id = $myfirmrow["IncFirmTypeId"];
                       $name = $myfirmrow["IncTypeName"];
                       $isselcted = ($incfirmtype==$id) ? 'SELECTED' : "";
                        echo "<OPTION id='".$id. "' value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
               }
        mysql_free_result($incfirmrs);
       }
?>
        </SELECT>
                
</li>

<li class="even"><h4>Follow on Funding Status </h4>
                 <?php //$followonFund=$incfirmtype; ?>
    <SELECT NAME="followonFund" id="followonFund"  style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                         <OPTION  value="--" selected> All </option>
                         <OPTION VALUE=1  <?php if($followon==1) echo "selected" ?>>Obtained</OPTION>
                         <OPTION VALUE=2 <?php if($followon==2) echo "selected" ?>>None</OPTION>
                  </SELECT>
      
 <!--<label><input name="investor" type="checkbox" value="" /> Foreign</label> 
 <label><input name="investor" type="checkbox" value="" /> India</label> 
 <label><input name="investor" type="checkbox" value="" /> Investment</label>-->
</li>
<li class="odd"><h4>Region</h4>
    <SELECT NAME="txtregion" id="txtregion" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
  <OPTION id=5 value="" selected> ALL </option>
     <?php
        /* populating the region from the Region table */
        $regionsql = "select RegionId,Region from region where Region!='' order by RegionId";
        if ($regionrs = mysql_query($regionsql)){
          $region_cnt = mysql_num_rows($regionrs);
        }
        if($region_cnt >0){
          While($myregionrow=mysql_fetch_array($regionrs, MYSQL_BOTH)){
              $id = $myregionrow["RegionId"];
              $name = $myregionrow["Region"];
        $isselcted = ($regionId==$id) ? 'SELECTED' : "";
              echo "<OPTION id='".$id. "' value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
          }
        mysql_free_result($regionrs);
      }
?>
</SELECT>
                
</li>
<li class="ui-widget" style="position: relative"><h4>City</h4>
    <input type="hidden" id="cityauto" name="cityauto" value="<?php if($_POST['citysearch']!='') echo  $_POST['cityauto'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['citysearch']!='') echo "readonly='readonly'";  ?>>
    <input type="text" id="citysearch" name="citysearch" value="<?php if(isset($_POST['citysearch'])) echo  $_POST['citysearch'];  ?>" placeholder="" style="width:220px;">
     
    <!-- <span id="com_clearall" title="Clear All" onclick="clear_companysearch();" style="<?php if($_POST['citysearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span> -->
     
    <div id="cityauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
     
</li>
</ul></div>
  </div>
  
  <h2 class="acc_trigger <?php if($showdealsbyflag==1){ ?> showdeal <?php } ?>"><a href="#">Show deals by</a></h2>
  <div  class="acc_container">
    <div class="block">
<ul >


<li class="ui-widget" style="position: relative"><h4>Incubator/Accelerator</h4>
<!-- <input type="text" value="<?php echo $_POST['keywordsearch']; ?>" name="keywordsearch" id="askeywordsearch"  class=""  autocomplete=off  style="width:220px;"/>-->
    <?php if($_POST['investorauto_sug_other'] != ''){ 
            $isearch = $_POST['investorauto_sug_other'];
            $iauto = $_POST['keywordsearch_other'];
        }else{ 
            $isearch = $_POST['keywordsearch'];
            $iauto = $_POST['investorauto'];
            
        } ?> 
    <input type="text" id="investorauto" name="investorauto" value="<?php if($iauto!='') echo  $iauto;  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['keywordsearch']!='') echo "readonly='readonly'";  ?>>
    
    
    <input type="hidden" id="keywordsearch_multiple" name="keywordsearch" value="<?php if(isset($isearch)) echo  $isearch;  ?>" placeholder="" style="width:220px;">
     
     <span id="inv_clearall" title="Clear All" onclick="clear_keywordsearch1();" style="<?php if($isearch=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>
     <div id="investorauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
</li>
<?php 

    if($_POST['companyauto_other'] != ''){
            $csearch = $_POST['companysearch_other'];
            $cauto = $_POST['companyauto_other'];
             $sql_company = "select  PECompanyId as id,companyname as name from pecompanies where PECompanyId IN($csearch)";

        $sql_company_Exe = mysql_query($sql_company);
        $company_filter = "";
        $response = array();
        $i = 0;
        while ($myrow = mysql_fetch_array($sql_company_Exe, MYSQL_BOTH)) {

            $response[$i]['id'] = $myrow['id'];
            $response[$i]['name'] = $myrow['name'];
            if ($i != 0) {

                $company_filter .= ",";
            }
            $company_filter .= $myrow['name'];
            $i++;

        }
        
        }else if($_POST['companysearch'] !=''){
          if($_POST['companyauto_sug']!=''){
          $csearch = $_POST['companyauto_sug'];
            $cauto = $_POST['companysearch'];
          }else{
            $csearch = $_POST['companysearch'];
            $cauto = $_POST['companyauto'];
            }    
            $sql_company = "select  PECompanyId as id,companyname as name from pecompanies where PECompanyId IN($csearch)";

            $sql_company_Exe = mysql_query($sql_company);
            $company_filter = "";
            $response = array();
            $i = 0;
            while ($myrow = mysql_fetch_array($sql_company_Exe, MYSQL_BOTH)) {

                $response[$i]['id'] = $myrow['id'];
                $response[$i]['name'] = $myrow['name'];
                if ($i != 0) {

                    $company_filter .= ",";
                }
                $company_filter .= $myrow['name'];
                $i++;

          }        
         
        }else{
            $csearch = $companysearch;
            $cauto = $company_filter;
           
        }?>
<li class="ui-widget" style="position: relative"><h4>Incubatee</h4>
    <input type="text" id="companyauto" name="companyauto" value="<?php echo $company_filter;?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($csearch!='') echo "readonly='readonly'";  ?>>
     <input type="hidden" id="companysearch" name="companysearch" value="<?php echo $csearch;  ?>" placeholder="" style="width:220px;">
     
    <span id="com_clearall" title="Clear All" onclick="clear_companysearch1();" style="<?php if($csearch=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>
     
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
    <?php } ?>