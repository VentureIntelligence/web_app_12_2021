<?php

require_once("../dbconnectvi.php");
$Db = new dbInvestments();
if(!isset($_SESSION['UserNames']))
{
        header('Location:../pelogin.php');
}
else
{?>
<style>
    .select2-container{box-sizing:border-box;display:inline-block;margin:0;position:relative;vertical-align:middle}.select2-container .select2-selection--single{box-sizing:border-box;cursor:pointer;display:block;height:28px;user-select:none;-webkit-user-select:none}.select2-container .select2-selection--single .select2-selection__rendered{display:block;padding-left:8px;padding-right:20px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.select2-container .select2-selection--single .select2-selection__clear{position:relative}.select2-container[dir="rtl"] .select2-selection--single .select2-selection__rendered{padding-right:8px;padding-left:20px}.select2-container .select2-selection--multiple{box-sizing:border-box;cursor:pointer;display:block;min-height:32px;user-select:none;-webkit-user-select:none}.select2-container .select2-selection--multiple .select2-selection__rendered{display:inline-block;overflow:hidden;padding-left:8px;text-overflow:ellipsis;white-space:nowrap}.select2-container .select2-search--inline{float:left}.select2-container .select2-search--inline .select2-search__field{box-sizing:border-box;border:none;font-size:100%;margin-top:5px;padding:0}.select2-container .select2-search--inline .select2-search__field::-webkit-search-cancel-button{-webkit-appearance:none}.select2-dropdown{background-color:white;border:1px solid #aaa;border-radius:4px;box-sizing:border-box;display:block;position:absolute;left:-100000px;width:100%;z-index:1051}.select2-results{display:block}.select2-results__options{list-style:none;margin:0;padding:0}.select2-results__option{padding:6px;user-select:none;-webkit-user-select:none}.select2-results__option[aria-selected]{cursor:pointer}.select2-container--open .select2-dropdown{left:0}.select2-container--open .select2-dropdown--above{border-bottom:none;border-bottom-left-radius:0;border-bottom-right-radius:0}.select2-container--open .select2-dropdown--below{border-top:none;border-top-left-radius:0;border-top-right-radius:0}.select2-search--dropdown{display:block;padding:4px}.select2-search--dropdown .select2-search__field{padding:4px;width:100%;box-sizing:border-box}.select2-search--dropdown .select2-search__field::-webkit-search-cancel-button{-webkit-appearance:none}.select2-search--dropdown.select2-search--hide{display:none}.select2-close-mask{border:0;margin:0;padding:0;display:block;position:fixed;left:0;top:0;min-height:100%;min-width:100%;height:auto;width:auto;opacity:0;z-index:99;background-color:#fff;filter:alpha(opacity=0)}.select2-hidden-accessible{border:0 !important;clip:rect(0 0 0 0) !important;-webkit-clip-path:inset(50%) !important;clip-path:inset(50%) !important;height:1px !important;overflow:hidden !important;padding:0 !important;position:absolute !important;width:1px !important;white-space:nowrap !important}.select2-container--default .select2-selection--single{background-color:#fff;border:1px solid #aaa;border-radius:4px}.select2-container--default .select2-selection--single .select2-selection__rendered{color:#444;line-height:28px}.select2-container--default .select2-selection--single .select2-selection__clear{cursor:pointer;float:right;font-weight:bold}.select2-container--default .select2-selection--single .select2-selection__placeholder{color:#999}.select2-container--default .select2-selection--single .select2-selection__arrow{height:26px;position:absolute;top:1px;right:1px;width:20px}.select2-container--default .select2-selection--single .select2-selection__arrow b{border-color:#888 transparent transparent transparent;border-style:solid;border-width:5px 4px 0 4px;height:0;left:50%;margin-left:-4px;margin-top:-2px;position:absolute;top:50%;width:0}.select2-container--default[dir="rtl"] .select2-selection--single .select2-selection__clear{float:left}.select2-container--default[dir="rtl"] .select2-selection--single .select2-selection__arrow{left:1px;right:auto}.select2-container--default.select2-container--disabled .select2-selection--single{background-color:#eee;cursor:default}.select2-container--default.select2-container--disabled .select2-selection--single .select2-selection__clear{display:none}.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b{border-color:transparent transparent #888 transparent;border-width:0 4px 5px 4px}.select2-container--default .select2-selection--multiple{background-color:white;border:1px solid #aaa;border-radius:4px;cursor:text}.select2-container--default .select2-selection--multiple .select2-selection__rendered{box-sizing:border-box;list-style:none;margin:0;padding:0 5px;width:100%}.select2-container--default .select2-selection--multiple .select2-selection__rendered li{list-style:none}.select2-container--default .select2-selection--multiple .select2-selection__placeholder{color:#999;margin-top:5px;float:left}.select2-container--default .select2-selection--multiple .select2-selection__clear{cursor:pointer;float:right;font-weight:bold;margin-top:5px;margin-right:10px}.select2-container--default .select2-selection--multiple .select2-selection__choice{background-color:#e4e4e4;border:1px solid #aaa;border-radius:4px;cursor:default;float:left;margin-right:5px;margin-top:5px;padding:0 5px}.select2-container--default .select2-selection--multiple .select2-selection__choice__remove{color:#999;cursor:pointer;display:inline-block;font-weight:bold;margin-right:2px}.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover{color:#333}.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice,.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__placeholder,.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-search--inline{float:right}.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice{margin-left:5px;margin-right:auto}.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice__remove{margin-left:2px;margin-right:auto}.select2-container--default.select2-container--focus .select2-selection--multiple{border:solid black 1px;outline:0}.select2-container--default.select2-container--disabled .select2-selection--multiple{background-color:#eee;cursor:default}.select2-container--default.select2-container--disabled .select2-selection__choice__remove{display:none}.select2-container--default.select2-container--open.select2-container--above .select2-selection--single,.select2-container--default.select2-container--open.select2-container--above .select2-selection--multiple{border-top-left-radius:0;border-top-right-radius:0}.select2-container--default.select2-container--open.select2-container--below .select2-selection--single,.select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple{border-bottom-left-radius:0;border-bottom-right-radius:0}.select2-container--default .select2-search--dropdown .select2-search__field{border:1px solid #aaa}.select2-container--default .select2-search--inline .select2-search__field{background:transparent;border:none;outline:0;box-shadow:none;-webkit-appearance:textfield}.select2-container--default .select2-results>.select2-results__options{max-height:200px;overflow-y:auto}.select2-container--default .select2-results__option[role=group]{padding:0}.select2-container--default .select2-results__option[aria-disabled=true]{color:#999}.select2-container--default .select2-results__option[aria-selected=true]{background-color:#ddd}.select2-container--default .select2-results__option .select2-results__option{padding-left:1em}.select2-container--default .select2-results__option .select2-results__option .select2-results__group{padding-left:0}.select2-container--default .select2-results__option .select2-results__option .select2-results__option{margin-left:-1em;padding-left:2em}.select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option{margin-left:-2em;padding-left:3em}.select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option{margin-left:-3em;padding-left:4em}.select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option{margin-left:-4em;padding-left:5em}.select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option{margin-left:-5em;padding-left:6em}.select2-container--default .select2-results__option--highlighted[aria-selected]{background-color:#5897fb;color:white}.select2-container--default .select2-results__group{cursor:default;display:block;padding:6px}.select2-container--classic .select2-selection--single{background-color:#f7f7f7;border:1px solid #aaa;border-radius:4px;outline:0;background-image:-webkit-linear-gradient(top, #fff 50%, #eee 100%);background-image:-o-linear-gradient(top, #fff 50%, #eee 100%);background-image:linear-gradient(to bottom, #fff 50%, #eee 100%);background-repeat:repeat-x;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFFFFFFF', endColorstr='#FFEEEEEE', GradientType=0)}.select2-container--classic .select2-selection--single:focus{border:1px solid #5897fb}.select2-container--classic .select2-selection--single .select2-selection__rendered{color:#444;line-height:28px}.select2-container--classic .select2-selection--single .select2-selection__clear{cursor:pointer;float:right;font-weight:bold;margin-right:10px}.select2-container--classic .select2-selection--single .select2-selection__placeholder{color:#999}.select2-container--classic .select2-selection--single .select2-selection__arrow{background-color:#ddd;border:none;border-left:1px solid #aaa;border-top-right-radius:4px;border-bottom-right-radius:4px;height:26px;position:absolute;top:1px;right:1px;width:20px;background-image:-webkit-linear-gradient(top, #eee 50%, #ccc 100%);background-image:-o-linear-gradient(top, #eee 50%, #ccc 100%);background-image:linear-gradient(to bottom, #eee 50%, #ccc 100%);background-repeat:repeat-x;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFEEEEEE', endColorstr='#FFCCCCCC', GradientType=0)}.select2-container--classic .select2-selection--single .select2-selection__arrow b{border-color:#888 transparent transparent transparent;border-style:solid;border-width:5px 4px 0 4px;height:0;left:50%;margin-left:-4px;margin-top:-2px;position:absolute;top:50%;width:0}.select2-container--classic[dir="rtl"] .select2-selection--single .select2-selection__clear{float:left}.select2-container--classic[dir="rtl"] .select2-selection--single .select2-selection__arrow{border:none;border-right:1px solid #aaa;border-radius:0;border-top-left-radius:4px;border-bottom-left-radius:4px;left:1px;right:auto}.select2-container--classic.select2-container--open .select2-selection--single{border:1px solid #5897fb}.select2-container--classic.select2-container--open .select2-selection--single .select2-selection__arrow{background:transparent;border:none}.select2-container--classic.select2-container--open .select2-selection--single .select2-selection__arrow b{border-color:transparent transparent #888 transparent;border-width:0 4px 5px 4px}.select2-container--classic.select2-container--open.select2-container--above .select2-selection--single{border-top:none;border-top-left-radius:0;border-top-right-radius:0;background-image:-webkit-linear-gradient(top, #fff 0%, #eee 50%);background-image:-o-linear-gradient(top, #fff 0%, #eee 50%);background-image:linear-gradient(to bottom, #fff 0%, #eee 50%);background-repeat:repeat-x;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFFFFFFF', endColorstr='#FFEEEEEE', GradientType=0)}.select2-container--classic.select2-container--open.select2-container--below .select2-selection--single{border-bottom:none;border-bottom-left-radius:0;border-bottom-right-radius:0;background-image:-webkit-linear-gradient(top, #eee 50%, #fff 100%);background-image:-o-linear-gradient(top, #eee 50%, #fff 100%);background-image:linear-gradient(to bottom, #eee 50%, #fff 100%);background-repeat:repeat-x;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFEEEEEE', endColorstr='#FFFFFFFF', GradientType=0)}.select2-container--classic .select2-selection--multiple{background-color:white;border:1px solid #aaa;border-radius:4px;cursor:text;outline:0}.select2-container--classic .select2-selection--multiple:focus{border:1px solid #5897fb}.select2-container--classic .select2-selection--multiple .select2-selection__rendered{list-style:none;margin:0;padding:0 5px}.select2-container--classic .select2-selection--multiple .select2-selection__clear{display:none}.select2-container--classic .select2-selection--multiple .select2-selection__choice{background-color:#e4e4e4;border:1px solid #aaa;border-radius:4px;cursor:default;float:left;margin-right:5px;margin-top:5px;padding:0 5px}.select2-container--classic .select2-selection--multiple .select2-selection__choice__remove{color:#888;cursor:pointer;display:inline-block;font-weight:bold;margin-right:2px}.select2-container--classic .select2-selection--multiple .select2-selection__choice__remove:hover{color:#555}.select2-container--classic[dir="rtl"] .select2-selection--multiple .select2-selection__choice{float:right}.select2-container--classic[dir="rtl"] .select2-selection--multiple .select2-selection__choice{margin-left:5px;margin-right:auto}.select2-container--classic[dir="rtl"] .select2-selection--multiple .select2-selection__choice__remove{margin-left:2px;margin-right:auto}.select2-container--classic.select2-container--open .select2-selection--multiple{border:1px solid #5897fb}.select2-container--classic.select2-container--open.select2-container--above .select2-selection--multiple{border-top:none;border-top-left-radius:0;border-top-right-radius:0}.select2-container--classic.select2-container--open.select2-container--below .select2-selection--multiple{border-bottom:none;border-bottom-left-radius:0;border-bottom-right-radius:0}.select2-container--classic .select2-search--dropdown .select2-search__field{border:1px solid #aaa;outline:0}.select2-container--classic .select2-search--inline .select2-search__field{outline:0;box-shadow:none}.select2-container--classic .select2-dropdown{background-color:#fff;border:1px solid transparent}.select2-container--classic .select2-dropdown--above{border-bottom:none}.select2-container--classic .select2-dropdown--below{border-top:none}.select2-container--classic .select2-results>.select2-results__options{max-height:200px;overflow-y:auto}.select2-container--classic .select2-results__option[role=group]{padding:0}.select2-container--classic .select2-results__option[aria-disabled=true]{color:grey}.select2-container--classic .select2-results__option--highlighted[aria-selected]{background-color:#3875d7;color:#fff}.select2-container--classic .select2-results__group{cursor:default;display:block;padding:6px}.select2-container--classic.select2-container--open .select2-dropdown{border-color:#5897fb}

   
.select2-dropdown{
    border-radius: 0px;
}
.search-area input[type="text"] {
    width: 290px !important;
    margin-right: -1px;
}
.search-area input[type="button"], .search-area input[type="submit"]{
    height: 27px;
}
.select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #e0d9c4;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #a2743a;
    color: white;
}
.select2-container--default .select2-selection--single{
    border: 1px solid #a2743a;
    border-radius: 0px;
}
.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b{
    border-color: #a2743a transparent transparent transparent;
}
.select2-container--default .select2-selection--single .select2-selection__arrow b{
    border-color: #000 transparent transparent transparent;
}
.select2-container--default .select2-selection--single .select2-selection__placeholder {
    color: #999;
    font-size: 13px;
}
.select2-container--default .select2-results__option--highlighted[aria-selected]:first-letter, .select2-results__option::first-letter, .select2-selection__rendered::first-letter {
    text-transform: uppercase;
}


</style>
<script>
$(document).ready(function(){ 
        $("#firstrefineipo select, #firstrefineipo input").on('change',function(){
            localStorage.removeItem("pageno");
            $("#tagsearch").val("");
            $('#tagsearch_auto').val("");
        }); 
        $("#industry, #invType,#invhead, #invSale, #exitstatus, #txtmultipleReturnFrom, #txtmultipleReturnTo").on('change',function(){
          $("#tagsearch").val("");
          $('#tagsearch_auto').val("");
          localStorage.removeItem("pageno");
          $("#pesearch").submit();
        });
    });
  $(function() {
     ////////////// investor search start //////////////////////
    
      $( "#investorauto" ).keyup(function() {
             
             var investorauto = $("#investorauto").val();
              
             if(investorauto.length > 1 ) {
                    $.ajax({
                       type: "post",
                     url: "ajaxInvestorDetails.php",
                     data: {
                         vcflag: '<?php echo $VCFlagValue; ?>',
                         showallcompInvFlag: '<?php echo $showallcompInvFlag; ?>',
                        search: investorauto
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
                                
                               multiselect+="<label style='clear: both;'><input type='checkbox' name='investor_multi[]' value='"+item['id']+"' class='investor_slt' data-title='"+item['value']+"' >"+item['value']+"</label></br>";

                            });
                            
                            multiselect+="</br></br>"; 
                            
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

           clear_companysearch();
           $('#companysearch').val("");
           $('#companyauto').val("");
            
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
                  $("#investorsearch").val(sltinvestor_multi); 
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
           
           $('#companysearch').val("");
           $('#companyauto').val("");
                      
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
                    $("#investorsearch").val(sltinvestor_multi); 
                    
                    
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
              
             if(companyauto.length > 1 ) {
                    $.ajax({
                       type: "post",
                     url: "ajaxCompanyDetails.php",
                     data: {
                        vcflag: '<?php echo $VCFlagValue; ?>',
                        showallcompInvFlag: '<?php echo $showallcompInvFlag; ?>',
                        search: companyauto
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
                                
                               multiselect+="<label style='clear: both;'><input type='checkbox' name='company_multi[]' value='"+item['id']+"' class='company_slt' data-title='"+item['value']+"' >"+item['value']+"</label></br>";

                            });
                            
                            multiselect+="</br></br>"; 
                            
                            $("#companyauto_load").fadeIn();
                            $("#companyauto_load").html(multiselect);
                            disableFileds();
                            $("#tagsearch").val("");
                            $('#tagsearch_auto').val("");
                            }
                            else{
                            $("#companyauto_load").fadeout();
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
    
             $("#investorauto_sug").tokenInput("clear",{focus:false});
             $('#keywordsearch_sug').val("");
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
                  $("#companyauto").attr('readonly','readonly'); 
                  $("#companyauto").val(sltholder);
                  $("#companysearch").val(sltcompany_multi); 
                  $("#com_clearall").fadeIn();
                    disableFileds();
             }
             else{
                    enableFileds();
               //  sltcount=0;sltholder='';
                   $("#com_clearall").fadeOut(); 
                   $("#companyauto").removeAttr('readonly');
                   $("#companyauto").val('');
             }
        });
    
     $('.company_slt').live("click", function() {  //on click 
                    var sltcompany_multi = $("#companysearch").val(); 
                    if(sltcompany_multi ==''){
                        $("#companyauto").val('');
                    }
                    var sltholder = $("#companyauto").val();  
                    if(this.checked) {                              
                          var holder = $(this).data("title");
                          var slt_comp_id = $(this).val(); 
                          var commma = '';
                          if(sltholder != ''){
                              commma = ',';                                    
                          }
                          sltholder += commma+holder;
                          sltcompany_multi += commma+slt_comp_id;
                          $("#companyauto").attr('readonly','readonly');  
                          $("#companyauto").val(sltholder); 
                          $("#companysearch").val(sltcompany_multi); 
                      }
                      
                       $("#investorauto_sug").tokenInput("clear",{focus:false});
            clear_searchallfield();
                       $('#keywordsearch_sug').val("");
                       $('#investorauto,#searchallfield').val("");
                      
                     /* var sltcount=0;
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
                     
                    $("#companyauto").attr('readonly','readonly');  
                    $("#companyauto").val(sltholder); 
                    $("#companysearch").val(sltcompany_multi); */
                    
                    disableFileds();
                    
                    
                    if(sltholder==''){  $("#com_clearall").fadeOut(); $("#companyauto").removeAttr('readonly');   }
                    else {   $("#com_clearall").fadeIn();  }
                        
        if($(".company_slt").length==$(".company_slt:checked").length){
            $("#com_selectall").attr("checked","checked");
        }else{
            $("#com_selectall").removeAttr("checked");
        }
                     
                 
    });

    function submitfilter() {
localStorage.removeItem("pageno");

document.pesearch.action = 'ipoindex.php?value=<?php echo $VCFlagValue ?>';
document.pesearch.submit();

return true;
}
    
    ////////////// company search end //////////////////////  

  //   $( "#tagsearch_auto" ).autocomplete({
    
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
    
    $("#resetall").click(function(){
        
        $("#investorauto_sug").tokenInput("clear",{focus:false});
       clear_companysearch();
    });
    
    });
     
    </script>
 <?php 
  $showdealsbyflag=0;
 if(($keyword!=" " && $keyword!=NULL)  || ($advisorsearch!="" && $advisorsearch!=NULL)  ||($companysearch!=" " && $companysearch!=NULL))
  { 
      $showdealsbyflag=1; 
         $disable_flag = "1";
    $background = "#dddddd  !important"; 
    }else{
    $disable_flag = "0";
    $background = "#ffffff";          
}
?>
<?php   $currentyear = date("Y"); ?>
  <!-- Tag Search -->
  <h2 class="acc_trigger helptag" style="width: 100%;" >
            <a href="#" style="display: inline-block;">Tag Search</a>
            <!-- <span class="helplineTag helplinetagicon" style="margin-top: -24px !important;"> 
                <a  class="help-icon1 tooltip tagpopup"><i class="far fa-question-circle" style="color: #fff;background-image: none;"></i>
                    <span style="right: 18% !important;">
                        <img class="showtextlarge" src="images/callout.gif" style="left: 50px;" />
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
        <i class="far fa-question-circle" style="color: #fff;background-image: none;font-size: 16px;"></i>
            <span style="right: 0% !important;width: 55px;box-shadow: 2px 1px 3px 0px rgba(255, 255, 255, 0.5);padding-right: 10px;">
                <img class="showtextlarge" src="images/callout.gif" style="left: 40px;">
                    TAG LIST
            </span>
        </a>
    </span> 

        <!-- Tag Search -->
 <h2 class="acc_trigger"><a href="#">Refine Search</a></h2>
  <div class="acc_container">
    <div class="block" id="firstrefineipo">
      <ul >
<li class="even"><h4>Industry</h4>

  

<div class="selectgroup">  
    <select name="industry[]" multiple="multiple"  id="sltindustry" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
    <!--<OPTION id=0 value="--" selected> Select an Industry </option>-->
    <?php
                    if($compId==$companyId)
                    { $hideIndustry = " and display_in_page=1 "; }
                    elseif($compId==$companyIdDel)
                    {
                      $hideIndustry = " and display_in_page=2 ";
                    }
                    elseif($compId==$companyIdSGR)
                    {
                      $hideIndustry = " and (industryid=3 or industryid=24) ";
                    }
                    elseif($compId==$companyIdVA)
                    {
                      $hideIndustry = " and (industryid=1 or industryid=3) ";
                    }
                    elseif($compId==$companyIdGlobal)
                    {
                      $hideIndustry = " and (industryid=24)";
                    }
                    else
                    { $hideIndustry=""; }
                    $industrysql_search="select industryid,industry from industry where industryid IN (".$_SESSION['PE_industries'].") " . $hideIndustry ." order by industry";
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
                                    $isselected = (in_array($id,$_POST['industry'])) ? 'SELECTED' : '';
                                    echo "<OPTION id='industry_".$id. "' value=".$id." ".$isselected.">".$name."</OPTION> \n";
                            }
                            mysql_free_result($industryrs);
                    }
                
                
                
      ?>
    </select>
</div>

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
    
<li class="odd"><h4>Investor Type <span ><a href="#popup3" class="help-icon1 tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
                                             <span>
                                             <img class="callout1" src="images/callout.gif">
                                             Definitions
                                             </span>
     </a></span></h4>
                <SELECT NAME="invType" id="invType" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                 <OPTION id=5 value="--" selected> ALL </option>
                 <?php
                        /* populating the incubator status from the incstatus table */
                        $invtypesql = "select InvestorType,InvestorTypeName from investortype where Hide=0";
                            if ($invtypers = mysql_query($invtypesql))
                            {
                       $invtype_cnt = mysql_num_rows($invtypers);
                            }
                              if($invtype_cnt >0)
                            {
                             While($myrow=mysql_fetch_array($invtypers, MYSQL_BOTH))
                            {
                                    $id = $myrow["InvestorType"];
                                    $name = $myrow["InvestorTypeName"];
                                    $isselcted = ($id==$_POST['invType']) ? 'SELECTED' : '';
                                     echo "<OPTION id=".$id. " value=".$id." ".$isselcted." >".$name."</OPTION> \n";
                            }
                 mysql_free_result($invtypers);
                }
        ?>
             </SELECT>
</li>
<li class="odd "><h4>Investor Headquarters
    </h4>
    <SELECT NAME="invhead" id="invhead" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
       <OPTION id="5" value="--" selected> ALL </option>
         <?php
            /* populating the investortype from the investortype table */
            $countrysql = "SELECT DISTINCT (peinvestors.countryid),country.country from peinvestors JOIN country on country.countryid=peinvestors.countryid and country.country!='' and country.country!='--' ORDER BY country ASC";
            if ($countryquery = mysql_query($countrysql)){
               $country_cnt = mysql_num_rows($countryquery);
            }
            if($country_cnt >0){
                While($myrow=mysql_fetch_array($countryquery, MYSQL_BOTH)){
                    $id = $myrow["countryid"];
                    $countryname = $myrow["country"];
                       /* if($regionId!='')
                        {
                              $isselcted = ($investorType==$id) ? 'SELECTED' : "";
                              echo "<OPTION id=".$id. " value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                        }
                        else
                        {
                               $isselcted = ($getinv==$name) ? 'SELECTED' : "";
                              echo "<OPTION id=".$id. " value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                        }*/
                              $isselcted = ($investor_head==$id) ? 'SELECTED' : "";
                              echo "<OPTION id=".$id. " value='".$id."' ".$isselcted.">".$countryname."</OPTION> \n";
                }
                mysql_free_result($countryquery);
            }
    ?>
</SELECT>
  </li>
    
<li class="even"><h4>Investor Sale in IPO?</h4>
                 <?php $invSale=$_POST["invSale"]; ?>
                  <SELECT NAME="invSale"  id="invSale" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                         <OPTION  value="--" selected> Select </option>
                         <OPTION VALUE="1"  <?php if($invSale=="1") echo "selected" ?>>Yes</OPTION>
                         <OPTION VALUE="0" <?php if($invSale==="0") echo "selected" ?>> No </OPTION>
                  </SELECT>
      <span >(Select Yes to include only IPOs in which the PE investors sold shares)</span>
 <!--<label><input name="investor" type="checkbox" value="" /> Foreign</label> 
 <label><input name="investor" type="checkbox" value="" /> India</label> 
 <label><input name="investor" type="checkbox" value="" /> Investment</label>-->
</li>


<li class="odd"><h4>Exit Status</h4>
    <?php $exitstatus=$_POST["exitstatus"]; ?>
    <SELECT NAME="exitstatus" id="exitstatus" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                    <OPTION  value="--" selected> Both </option>
                    <OPTION  value="0" <?php if($exitstatus=="0") echo "selected" ?>> Partial </option>
                    <OPTION  value="1" <?php if($exitstatus=="1") echo "selected" ?>> Complete </option>
                </SELECT>
</li>

    <li class="odd range-to"><h4>Return Multiple</h4>

        <?php $txtmultipleReturnFrom=($_POST['txtmultipleReturnFrom']!="")? $_POST['txtmultipleReturnFrom']:"";
        $txtmultipleReturnTo=($_POST['txtmultipleReturnTo']!="")? $_POST['txtmultipleReturnTo'] :"";
        ?>
        
        <input type="text" name="txtmultipleReturnFrom" id="txtmultipleReturnFrom" onkeypress="return isNumberKey(event)" value="<?php echo $txtmultipleReturnFrom ?>" size="11" <?php if($disable_flag == "1"){ echo "disabled"; } ?>> to
        <input type="text" name="txtmultipleReturnTo" id="txtmultipleReturnTo" value="<?php echo $txtmultipleReturnTo ?>" size="11"  onkeypress="return isNumberKey(event)" onblur="isless();" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>

</li>
  <li>
        <input type="button" name="fliter_stage" class="fliter_stage" value="Filter" onclick="submitfilter();" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
    </li>
</ul></div>
  </div>
  
  <h2 class="acc_trigger <?php if($showdealsbyflag==1){ ?> showdeal <?php } ?>"><a href="#">Show deals by</a></h2>
  <div  class="acc_container" style="display: none;">
    <div class="block">
<ul >
<?php if($_POST['investorauto_sug_other'] != ''){
            $isearch = $_POST['keywordsearch_other'];
            $iauto = $investorauto;
        }else{
            $isearch = $_POST['keywordsearch'];
            $iauto = $_POST['investorauto_sug'];
            
        } ?>        
<li class="ui-widget"><h4>Investor</h4>
    <input type="text" id="investorauto_sug" name="investorauto_sug" value="<?php if($iauto!='') echo  $iauto;  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($isearch!='') echo "readonly='readonly'";  ?>>
     <input type="hidden" id="keywordsearch_sug" name="keywordsearch_sug" value="<?php if(isset($isearch)) echo  $isearch;  ?>" placeholder="" style="width:220px;">
 <?php 
//        $addVCFlagqry="";
//        $searchString="Undisclosed";
//  $searchString=strtolower($searchString);
//
//  $searchString1="Unknown";
//  $searchString1=strtolower($searchString1);
//
//  $searchString2="Others";
//  $searchString2=strtolower($searchString2);
//         if($VCFlagValue==0)
//        {
//                $addVCFlagqry="";
//        }
//        elseif($VCFlagValue==1)
//        {
//                //$addVCFlagqry="";
//                $addVCFlagqry = " and VCFlag=1 ";
//        }
//        $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
//                FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
//                WHERE pe.PECompanyId = pec.PEcompanyId
//                AND pec.industry !=15
//                AND peinv.IPOId = pe.IPOId
//                AND inv.InvestorId = peinv.InvestorId
//                AND pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
     ?>
     <span id="inv_clearall" title="Clear All" onclick="clear_keywordsearch();" style="<?php if($_POST['investorsearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>
     
     <div id="investorauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
     
</li>
<?php 
        if($_POST['companyauto_other'] != ''){
            $csearch = $_POST['companysearch_other'];
            $cauto = $_POST['companyauto_other'];
        }else if($_POST['companysearch'] !=''){
            $csearch = $_POST['companysearch'];
            $cauto = $_POST['companyauto'];            
        }else{
            $csearch = $companysearch;
            $cauto = $company_filter;
            
        } ?>
<li class="ui-widget" style="position: relative"><h4>Company</h4>
    <input type="text" id="companyauto" name="companyauto" value="<?php if($cauto!='') echo $cauto;  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['companysearch']!='') echo "readonly='readonly'";  ?>>
     <input type="hidden" id="companysearch" name="companysearch" value="<?php if(isset($csearch)) echo $csearch;  ?>" placeholder="" style="width:220px;">
     
    <span id="com_clearall" title="Clear All" onclick="clear_companysearch1();" style="<?php if($csearch=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>
     
    <div id="companyauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
</li>

    <li>
      <input name="reset" id="resetall" class="reset-btn" type="button" value="Reset" style="float: left;" />
        <input type="button" name="fliter_stage" value="Filter" onclick="submitfilter();" style="float: right;">
    </li>
</ul>
    </div>
        </div>
        <!-- <h2 class="acc_trigger helptag" ><a href="#" style="display: inline-block;">Tag Search</a>
               <span class="helplineTag helplinetagicon" style=""> 
                        <a  class="help-icon1 tooltip tagpopup"><i class="far fa-question-circle" style="color: #fff;background-image: none;"></i>
                            <span >
                                
                                <img class="showtextlarge" src="images/callout.gif" style="left: 50px;">
                                    Tag List
                            </span>
                        </a>
                </span> 
                </h2>
    <div  class="acc_container " style="display: none;">
        <div class="block">

            <ul > 

            <?php //if($_POST['tagsearch']){
              //  $tagauto = $_POST['tagsearch'];            
           // } ?>
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
    </div> -->
<?php if($investorsug_response!=''){
            
            $prepopulate='prePopulate :  '.$investorsug_response;
        } ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript" >
   $('#invhead').select2();
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
            $("#investorauto_sug").tokenInput("ajaxipoinvestorDetails.php?ipovcf=<?php echo $vcflagValue; ?>", {
                    theme: "facebook",
                    minChars:2,
                    queryParam: "ipo_q",
                    hintText: "",
                    noResultsText: "No Result Found",
                    preventDuplicates: true,
                    onAdd: function (item) {

                        clear_companysearch();
                        clear_searchallfield();
                        disableFileds();
                        $("#tagsearch").val("");
                        $('#tagsearch_auto').val("");
                    },
                onDelete: function (item) {
                    var selectedValues = $('#investorauto_sug').tokenInput("get");
                    var inputCount = selectedValues.length;
                    if(inputCount==0){ 
                       // reloadPage();
                       enableFileds();
                    }
        },
                    <?php echo $prepopulate; ?>

            });


    });   
    
    function clear_keywordsearch(){
        $("#investorauto").removeAttr('readonly');  
        val='';
        $("#investorauto, #keywordsearch").val(val); 
        $("#investorauto_load").fadeOut();
        $("#inv_clearall").fadeOut(); 
    }  
    function clear_companysearch(){
        $("#companyauto").removeAttr('readonly');  
        val='';
        $("#companyauto,#companysearch").val(val); 
        $("#companyauto_load").fadeOut();
        $("#com_clearall").fadeOut(); 
    } 
    
    function clear_searchallfield(){
     $("#searchallfieldHide").val('remove');
     $("#searchallfield").val('');
     $("#searchallfield").fadeOut();
} 

  function clear_companysearch1(){
        $("#companyauto").removeAttr('readonly');  
        var val='';
        $("#companyauto,#companysearch").val(val); 
        $("#companyauto_load").fadeOut();
        $("#com_clearall").fadeOut(); 
     enableFileds();
} 

function disableFileds(){
    $("#sltindustry").val('');
    $("#sltindustry").prop("disabled", true);   
    $("#invType").val('--');
    $("#invType").prop("disabled", true);
    $("#invhead").val('--');
    $("#invhead").prop("disabled", true);
    $("#txtmultipleReturnFrom").val('');
    $("#txtmultipleReturnFrom").prop("disabled", true);
    $("#txtmultipleReturnTo").val('');
    $("#txtmultipleReturnTo").prop("disabled", true);
    $("#invSale").val('--');
    $("#invSale").prop("disabled", true);
    $("#exitstatus").val('--');
    $("#exitstatus").prop("disabled", true);
    $(".fliter_stage").prop("disabled", true);
    $("#tagsearch_auto").prop("disabled", true);
    $('#invType,#invhead,#invSale,#exitstatus').attr('style', 'background-color: #dddddd !important');
    $('.selectgroup button').attr('style', 'width: 223px; background-color: #dddddd !important');
}
function enableFileds(){ 
    $("#sltindustry").prop("disabled", false);
    $("#invType").prop("disabled", false);
    $("#invhead").prop("disabled", false);
    $("#txtmultipleReturnFrom").prop("disabled", false);
    $("#txtmultipleReturnTo").prop("disabled", false);
    $("#invSale").prop("disabled", false);
    $("#exitstatus").prop("disabled", false);
    $(".fliter_stage").prop("disabled", false);
    $("#tagsearch_auto").prop("disabled", false);
    $('#invType,#invhead,#invSale,#exitstatus').attr('style', 'background-color: #ffffff !important');
    $('.selectgroup button').attr('style', 'width: 223px; background-color: #ffffff !important');
}
    $( "#searchallfield" ).keyup(function() {
            $("#sltindustry").val('');  
            $("#invType").val('--');
            $("#invhead").val('--');
            $("#txtmultipleReturnFrom").val('');
            $("#txtmultipleReturnTo").val('');
            $("#invSale").val('--');
            $("#exitstatus").val('--');
            $("#investorauto_sug").val('');
            $("#companyauto,#companysearch").val('');
            $("#yearafter").val('');
            $("#yearbefore").val('');
    });
</script>
<?php } ?>