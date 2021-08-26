<?php include_once("../globalconfig.php");
 require_once("../dbconnectvi.php");
 $Db = new dbInvestments();
include ('checklogin.php');
?>
<SCRIPT  type="text/javascript">   
    $( "#searchallfield" ).keyup(function() {
            $("#searchallfieldHide").val('');     
            $("#sltindustry").val('');  
            $("#stage").val('');
            $("#txtregion").val('--');
            $("#citysearch").val('');
            $("#cityauto").val('');
            $("#EntityProjectType").val('--');
            $("#comptype").val('--');
            $("#invType").val('--');
            $("#invrangestart").val('--');
            $("#invrangeend").val('--');
            $("#exitstatus").val('--'); 
    });
  $(function() {
    
    $( "#advisorsearch_legal" ).change(function() {
        var val = $("#advisorsearch_legal").val();
        if(val.length < 1){
            enableFileds();
        }else{
            //disableFileds();            
        }
    });
   /* $( "#popup_keyword" ).keyup(function() {
        var popup_select = $('#popup_select').val();
        var advisor_type = $('#advisor_type').val();
        if(popup_select !=''){
            if(popup_select == 'legal_advisor' || popup_select == 'transaction_advisor'){
                var tokenLimit = 1;
            }else{
                var tokenLimit = 100;
            }
            var request_url = "ajaxPopupSearch.php?select_type="+popup_select+"&test= ";
            $("#popup_keyword").tokenInput(request_url, {
                theme: "facebook",
                minChars:1,
                queryParam: "search",
                hintText: "",
                noResultsText: "No Result Found",
                preventDuplicates: true,
                tokenLimit:tokenLimit,
                onAdd: function (item) {
                      clear_keywordsearch()
                      clear_companysearch();
                      clear_sectorsearch();
            clear_searchallfield();

                },
                onResult: null
            });
                $('#token-input-popup_keyword').focus();
        }
    });
    $( "#popup_select" ).change(function() {
            var popup_select = $('#popup_select').val();
            var advisor_type = '';
            if(popup_select !=''){
                if(popup_select == 'legal_advisor'){
                    advisor_type = 'L';
                }else if(popup_select == 'transaction_advisor'){
                    advisor_type = 'T';
                }
                $('#advisor_type').val(advisor_type);
               // $('#popup_keyword').tokenInput("clear");
               // $('.token-input-list').remove();
                $(".token-input-list-facebook").remove();
                var popup_select = $('#popup_select').val();
                var advisor_type = $('#advisor_type').val();
                if(popup_select == 'legal_advisor' || popup_select == 'transaction_advisor'){
                    var tokenLimit = 1;
                }else{
                    var tokenLimit = 100;
                }
                var request_url = "ajaxPopupSearch.php?select_type="+popup_select+"&test= ";
                $("#popup_keyword").tokenInput(request_url, {
                    theme: "facebook",
                    minChars:1,
                    queryParam: "search",
                    hintText: "",
                    noResultsText: "No Result Found",
                    preventDuplicates: true,
                    tokenLimit:tokenLimit,
                    onAdd: function (item) {
                          clear_keywordsearch()
                          clear_companysearch();
                          clear_sectorsearch();
            clear_searchallfield();

                    },
                    onResult: null
                });
                $('#token-input-popup_keyword').focus();
            }else{
                $('#popup_keyword').tokenInput("clear");
                $('.token-input-list').remove();
                $(".token-input-list-facebook").remove();
                $('#popup_keyword').show();
            }
    });*/
    
    $( "#popup_select" ).change(function() {
        
        $('#popup_keyword').val('');
        $('#search_load').html('');
        $("#popup_keyword").removeAttr('readonly');
    });
        
    $( "#popup_keyword" ).keyup(function() {
    
        var popup_select = $('#popup_select').val();
        var advisor_type = $('#advisor_type').val();
        var search = $(this).val();
        var vcflag = '<?php echo $VCFlagValue; ?>';

        if(popup_select !='' && popup_select != "tags"){
            
            if(popup_select == 'legal_advisor' || popup_select == 'transaction_advisor'){
                var tokenLimit = 1;
            }else{
                var tokenLimit = 100;
            }
             
            $.ajax({
                type: "post",
                url: "ajaxPopupSearch.php",
                data: {
                    type: advisor_type,
                    search: search,
                    select_type:popup_select,
                    vcflag : vcflag
                },
                success: function(data) {
            
                    var innerdata=$.parseJSON(data);

                    if(innerdata != null)
                    {
                         
                        var datacount = innerdata.length;   
                       

                        if(datacount > 0) {

                            var multiselect='';

                            if(datacount>1){

                                multiselect+='<label> <input style="width:auto !important;" type="checkbox" id="search_selectall"> SELECT ALL</label><br>';
                            }
                            $.each(innerdata, function (key, item) {

                                multiselect+="<label style='clear: both;'><input type='checkbox' name='search_multi[]' value='"+item['id']+"' class='search_slt' data-title='"+item['name']+"' >"+item['name']+"</label></br>";

                            });

                            multiselect+="</br></br>"; 

                            $("#search_load").fadeIn();
                            $("#search_load").html(multiselect);
                            //disableFileds();
                        }
                        else{
                            //$("#search_load").fadeOut();
                            $("#search_load").html('<div>No Result Found</div>');
                        }
                    }
                    else{
                            $("#search_load").html('<div>No Result Found</div>');
                    }
                }
            });
        
        }
        
    });
    
    $('.search_slt').live("click", function() {  //on click 
          
        var sltholder='';
        var sltsector_multi ='';
        
        var allChecked = $('.search_slt:checked').length === $('.search_slt').length;
        $('#search_selectall').prop('checked', allChecked);
        
       
        $('.search_slt').each(function() { //loop through each checkbox

            if(this.checked) {  
                
                var holder = $(this).data("title"); 
                var slt_sec_name = $(this).val(); 

                sltholder+=","+holder;   
                sltsector_multi+=",'"+slt_sec_name+"'";  

                $("#searchselector").show();
            }

        });
        if($('.search_slt:checked').length > 0){
            $("#popup_keyword").attr('readonly','readonly');  
        }else{
            $("#popup_keyword").removeAttr('readonly');
        }
        $("#popup_keyword").val(sltholder.substr(1));

    });
    
    $("#search_selectall").live("click", function() {
    

        $('.search_slt').attr('checked',this.checked);
        if(this.checked) 
        {                              
            var holder = $(this).val();                             
            var sltholder='';
            var sltsearch_multi ='';
            var sltcount=0;
            $('.search_slt').each(function() { //loop through each checkbox

                if(this.checked) {                              
                   var holder = $(this).data("title"); 
                   var slt_search_name = $(this).val(); 

                      /*if(sltcount==0) { sltholder+=holder; sltcompany_multi+=slt_comp_id; }
                      else { sltholder+=","+holder;   sltcompany_multi+=","+slt_comp_id; }*/
                    sltholder+=","+holder;   
                    sltsearch_multi+=",'"+slt_search_name+"'";
                   sltcount++;
                }
              });
              $("#popup_keyword").attr('readonly','readonly'); 
              $("#popup_keyword").val(sltholder.substr(1));
              //$("#popup_keyword").val(sltsearch_multi); 
              $("#popup_keyword").fadeIn();
            //disableFileds();
        }
        else{
            enableFileds();
            //$("#search_load").fadeOut(); 
            $("#popup_keyword").removeAttr('readonly');
            $("#popup_keyword").val('');
        }
    });
    
    $(document).on("click",function(e) {
        
        if(e.target.id == "popup_keyword"  || e.target.id == "search_load" || $(e.target).parents('#search_load').length){
            $('#search_load').show();
        } else {
            $('#search_load').hide();
        }
    });
});
function checkForAggregates()
{
	//alert("---");
	document.peinvestment.hiddenbutton.value='Aggregate';
	document.peinvestment.submit();
}

function indchange(list)
{
	//alert(list);
	//alert("---");
	//alert(list.options[list.selectedIndex].value);
	if(list.options[list.selectedIndex].value==15)
 	{
		document.reinvestment.stage.selectedIndex=0;
		document.reinvestment.stage.disabled=false;
                
	}
	else if(list.options[list.selectedIndex].value=="--" )
	{
		document.reinvestment.stage.selectedIndex=0;
		document.reinvestment.stage.disabled=false;
	}
	else if (list.options[list.selectedIndex].value!=15 )
	{
		document.reinvestment.stage.selectedIndex=0;
		document.reinvestment.stage.disabled=true;
	}
}




</SCRIPT>

<script>
  $(function() {
    
  
    
    
    
    ////////////// investor search start //////////////////////
    
      $( "#investorauto_multiple" ).keyup(function() {
             
             var investorauto = $("#investorauto_multiple").val();
              
             if(investorauto.length > 2 ) {
                    $.ajax({
                       type: "post",
                     url: "ajaxFundInvDetails.php",
                     data: {
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
                    //disableFileds();
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
             //enableFileds();
        }
        
    });    
    
      $("#inv_selectall").live("click", function() {
            // T993
            // clear_companysearch();
            // clear_sectorsearch();
            clear_Legal_Trans();
            clear_searchallfield();
            
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
                  $("#investorauto_multiple").attr('readonly','readonly'); 
                  $("#investorauto_multiple").val(sltholder);
                  $("#keywordsearch_multiple").val(sltinvestor_multi); 
                  $("#inv_clearall").fadeIn();
                            //disableFileds();
             }
             else{
               //  sltcount=0;sltholder='';
                   $("#inv_clearall").fadeOut(); 
                   $("#investorauto_multiple").removeAttr('readonly');
                   $("#investorauto_multiple").val('');
                            enableFileds();
             }
//                $("#investorauto").attr('readonly','readonly');  
//                $("#investorauto").val(sltholder); 
//                $("#investorauto_load").show();
        });    
    
      $('.investor_slt').live("click", function() {  //on click 
                      // T993
                    //   clear_companysearch();
                    //   clear_sectorsearch();
                      clear_Legal_Trans();
            clear_searchallfield();
                      
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
                     
                    $("#investorauto_multiple").attr('readonly','readonly');  
                    $("#investorauto_multiple").val(sltholder); 
                    $("#keywordsearch_multiple").val(sltinvestor_multi); 
                           // disableFileds();
                    
                    
                    if(sltcount==0){  $("#inv_clearall").fadeOut(); $("#investorauto_multiple").removeAttr('readonly');   }
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
                     url: "ajaxMultiAutosuggest.php?getcompany",
                     data: {
                        getAllReCompanies: '0',
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
                                
                               multiselect+="<label style='clear: both;'><input type='checkbox' name='company_multi[]' value='"+item['companyid']+"' class='company_slt' data-title='"+item['companyname']+"' >"+item['companyname']+"</label></br>";

                            });
                            
                            multiselect+="</br></br>"; 
                            
                            $("#companyauto_load").fadeIn();
                            $("#companyauto_load").html(multiselect);
                            //disableFileds();
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
            clear_sectorsearch();
            clear_Legal_Trans();
            clear_searchallfield();
           
            
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
                   // disableFileds();
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
                      // T993
                    //    clear_keywordsearch();
                    //    clear_sectorsearch();
                        clear_Legal_Trans();
            clear_searchallfield();
                     
                      
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
                     
            
                    //disableFileds();
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
    
    
    
    
      ////////////// sector search start //////////////////////
    
      $( "#sectorauto" ).keyup(function() {
             
             var sectorauto = $("#sectorauto").val();
              
             if(sectorauto.length > 2 ) {
                    $.ajax({
                       type: "post",
                      url: "ajaxMultiAutosuggest.php?getsector",
                     data: {
                        getAllReSector:'0',
                        search: sectorauto
                     },
                     success: function(data) {
                         
                          var innerdata=$.parseJSON(data);
                         var datacount = innerdata.length;   
                          
                          if(datacount>0) {
                              var multiselect='';
                              
                              if(datacount>1){
                          
                         //   multiselect+='<label> <input style="width:auto !important;" type="checkbox" id="sec_selectall"> SELECT ALL</label><br>';
                            }
                            $.each(innerdata, function (key, item) {
                                
                               multiselect+="<label style='clear: both;'><input type='checkbox' name='sector_multi[]' value='"+item['sectorname']+"' class='sector_slt' data-title='"+item['sectorname']+"' >"+item['sectorname']+"</label></br>";

                            });
                            
                            multiselect+="</br></br>"; 
                            
                            $("#sectorauto_load").fadeIn();
                            $("#sectorauto_load").html(multiselect);
                            //disableFileds();
                            }
                            else{
                                $("#sectorauto_load").fadeOut();
                                $("#sectorauto_load").html('');
                            }
                     }
                   });

                 /*  $.post('chargefilter_autosuggest_test.php',{chargeholder:'test',xcxzc:'asdas'},function(data){
                       console.log(data);
                   }); */
        }
        else{
             $("#sectorauto_load").fadeOut();
        }
        
    });    
    
      $("#sec_selectall").live("click", function() {
    
            clear_keywordsearch();
            clear_companysearch();
            clear_Legal_Trans();
            clear_searchallfield();
          
        
            
            $('.sector_slt').attr('checked',this.checked);
            if(this.checked) 
            {                              
                var holder = $(this).val();                             
                var sltholder='';
                var sltsector_multi ='';
                var sltcount=0;
                $('.sector_slt').each(function() { //loop through each checkbox

                       if(this.checked) {                              
                          var holder = $(this).data("title"); 
                          var slt_sec_name = $(this).val(); 

                             if(sltcount==0) { sltholder+=holder; sltsector_multi+="'"+slt_sec_name+"'"; }
                             else { sltholder+=","+holder;   sltsector_multi+=", '"+slt_sec_name+"'"; }

                          sltcount++;
                         
                       }

                  });
                  $("#sectorauto").attr('readonly','readonly'); 
                  $("#sectorauto").val(sltholder);
                  $("#sectorsearch_multiple").val(sltsector_multi); 
                  $("#sec_clearall").fadeIn();
                   // disableFileds();
             }
             else{
               //  sltcount=0;sltholder='';
                   $("#sec_clearall").fadeOut(); 
                   $("#sectorauto").removeAttr('readonly');
                   $("#sectorauto").val('');
                    enableFileds();
             }
        });
    
      $('.sector_slt').live("click", function() {  //on click 
         
        
         if($(".sector_slt:checked").length >  10){
            
             this.checked = false;
             alert('Please select only 10 Sectors');
             return false;
        }
                      
           clear_keywordsearch();
            clear_companysearch();
            clear_Legal_Trans();
            clear_searchallfield();
                      
                      var sltholder='';
                      var sltsector_multi ='';
                      var sltcount=0;
                      $('.sector_slt').each(function() { //loop through each checkbox
                          
                          if(this.checked) {                              
                                var holder = $(this).data("title"); 
                                var slt_sec_name = $(this).val(); 
                               
                                if(sltcount==0) { sltholder+=holder; sltsector_multi+="'"+slt_sec_name+"'";  }
                                else { sltholder+=","+holder;   sltsector_multi+=", '"+slt_sec_name+"'";  }
                             
                             sltcount++;
                             $("#sectorauto_load").show();
                              //sltuserscout++;
                          }
                          
                     });
                     
                    $("#sectorauto").attr('readonly','readonly');  
                    $("#sectorauto").val(sltholder); 
                    $("#sectorsearch_multiple").val(sltsector_multi); 
                    //disableFileds();
                    
                    if(sltcount==0){  $("#sec_clearall").fadeOut(); $("#sectorauto").removeAttr('readonly');   }
                    else {   $("#sec_clearall").fadeIn();  }
                        
//        if($(".sector_slt").length==$(".sector_slt:checked").length){
//            
//            $("#sec_selectall").attr("checked","checked");
//        }else{
//            $("#sec_selectall").removeAttr("checked");
//        }
                     
                 
             });
     
    ////////////// sector search end //////////////////////

    
  });
  
  
  function clear_keywordsearch(){
     $("#investorauto_multiple").removeAttr('readonly');  
     val='';
     $("#investorauto_multiple, #keywordsearch_multiple").val(val); 
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

  function clear_sectorsearch(){
     $("#sectorauto").removeAttr('readonly');  
     val='';
     $("#sectorauto,#sectorsearch_multiple").val(val); 
     $("#sectorauto_load").fadeOut();
     $("#sec_clearall").fadeOut(); 
} 


function clear_Legal_Trans(){
    
    var advisorsearch_legalbox = $("#advisorsearch_legal").combobox();
	var advisorsearch_transbox = $("#advisorsearch_trans").combobox();
    
     advisorsearch_legalbox.combobox("destroy") ;
     advisorsearch_transbox.combobox("destroy") ;
     
           $("#advisorsearch_legal option:eq(0)").attr('selected','selected');
           $("#advisorsearch_trans option:eq(0)").attr('selected','selected');
           
           advisorsearch_legalbox.combobox() ;
           advisorsearch_transbox.combobox() ;
}

  function clear_searchallfield(){
     $("#searchallfieldHide").val('remove');
     $("#searchallfield").val('');
     $("#searchallfield").fadeOut();
} 
  </script>
  
<?php 
$vCFlagValue=1;
$VCFlagValue=1;
$pagetitle="PE Investments - Real Estate -> Search";
$stagesql_search="select RETypeId,REType from realestatetypes order by REType";
$industrysql_search="select industryid,industry from reindustry";
                 
             //   $regionsql="select RegionId,Region from region where Region!='' order by RegionId";

$showdealsbyflag=0;
// if($keyword!="" || $companysearch!="" || $sectorsearch!="" || $advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
// { 
//     $showdealsbyflag=1;
//     $disable_flag = "1";
//     $background = "#dddddd  !important";       
// }else{
//     $disable_flag = "0";
//     $background = "#ffffff";          
// }  ?>

<h2 class="acc_trigger">
    <a href="#">Refine Search</a></h2>
<div class="acc_container" >
		<div class="block">
			<ul >
<li class="even" style="display:none;"><h4>Industry</h4>

  

    <div class="selectgroup">
                    <select name="industry[]" multiple="multiple"  id="sltindustry" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
		<?php
			if ($industryrs = mysql_query($industrysql_search))
			{
                            $ind_cnt = mysql_num_rows($industryrs);
			}
                       
			if($ind_cnt>0)
			{
                            While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                            {
                                //print_r($myrow);
                               $id = $myrow[0];
                               $name = $myrow[1];
                               if(count($industry)>0)
                               {
                                   $indSel = (in_array($id,$industry))?'selected':''; 
                                   echo "<OPTION id='industry_".$id. "' value=".$id." ".$indSel.">".$name."</OPTION> \n";
                               }
                               else
                               {
                                       if($id==15){
                                           echo "<OPTION id='industry_".$id. "' value=".$id." selected>".$name."</OPTION> \n";
                                        
                                       }else{
                                            echo "<OPTION id='industry_".$id. "' value=".$id.">".$name."</OPTION> \n";
                                       }
                               }

                            }
                            mysql_free_result($industryrs);
			}
    	?>
    </select>
                </div>

<!--<div class="selectgroup">
                    <select name="industry[]" multiple="multiple"  id="sltindustry" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
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
                                    if(count($industry)>0)
                                    {
                                        $indSel = (in_array($id,$industry))?'selected':''; 
                                        echo "<OPTION id='industry_".$id. "' value=".$id." ".$indSel.">".$name."</OPTION> \n";
                                    }
                                    else
                                    {
                                        if($getindus==$name){
                                            $isselected =  'selected';
                                        }elseif($id==15){
                                            $isselected = 'selected';
                                        }else{
                                            $isselected = '';
                                        }
                                        echo "<OPTION id=".$id. " value=".$id." ".$isselected.">".$name."</OPTION> \n";
                                    }
                                }
                                mysql_free_result($industryrs);
                            }
                        ?>
                    </select>
                </div>-->
</li>


<li class="odd"><h4>Sector
 </h4>
<div class="selectgroup">
 <select name="stage[]" multiple="multiple" size="5" id='stage' style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?> >
<?php
	
	if ($stagers = mysql_query($stagesql_search)){
  		$stage_cnt = mysql_num_rows($stagers);
	}
	if($stage_cnt > 0){
            $i=1;
		While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH)){
			$id = $myrow[0];
			$name = $myrow[1];
			$isselect='';
                        if($industry!='')
                        {
                            
			for($i=0;$i<count($stageval);$i++){
				$isselect = ($stageval[$i]==$id && $stageval[$i]!='') ? "SELECTED" : $isselect;
			}
                        $name=($name!="")?$name:"Other";
			echo '<OPTION value="'.$id.'" '.$isselect.'>'.$name.'</OPTION> \n';
                        }
                        else
                        {
                             $isselected = ($getstage==$name && $getstage!='' ) ? 'SELECTED' : '';
                             $name=($name!="")?$name:"Other";
                            echo "<OPTION id=".$id. " value=".$id." ".$isselected.">".$name."</OPTION> \n";
                        }
		}
		 mysql_free_result($stagers);
	}
	
 ?>
</select> </div>
    
<input type="button" name="fliter_stage" class="fliter_stage" value="Filter" onclick="submitfilter();">
 
</li>		


<li class="odd"><h4>Region</h4>
    <SELECT NAME="txtregion" id="txtregion" onchange="submitfilter();" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
	<OPTION id=5 value="--" selected> ALL </option>
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
                 if($regionId!='')
                  {
                        $isselcted = ($regionId==$id) ? 'SELECTED' : "";
                        echo "<OPTION id='".$id. "' value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                  }
                  else
                  {
                      $isselcted = ($getreg==$name) ? 'SELECTED' : "";
                       echo "<OPTION id='".$id. "' value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                      
                  }
        	}
    		mysql_free_result($regionrs);
    	}
?>
</SELECT>
</li>
<li class="ui-widget" style="position: relative"><h4>City</h4>
    <input type="hidden" id="cityauto" name="cityauto" value="<?php if($city!='') echo  $_POST['cityauto'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($city!='') echo "readonly='readonly'";  ?>>
    <input type="text" id="citysearch" name="citysearch" value="<?php if(isset($city)) echo  $city;  ?>" placeholder="" style="width:220px;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
     
    <!-- <span id="com_clearall" title="Clear All" onclick="clear_companysearch();" style="<?php if($_POST['citysearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span> -->
     
    <div id="cityauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
     
</li>

<li class="odd"><h4>Type</h4>
<!-- <label><input name="comptype[]" type="checkbox" value="L" />  Listed</label> 
 <label><input name="comptype[]" type="checkbox" value="U" /> Un-Listed</label>  -->

 <SELECT NAME="EntityProjectType" onchange="submitfilter();" id="EntityProjectType" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
    <OPTION  value="--" selected> ALL </option>
    <OPTION value="1" <?php echo ($entityProject=="1") ? 'SELECTED' : ""; ?>> Entity </option>
    <OPTION  value="2" <?php echo ($entityProject=="2") ? 'SELECTED' : ""; ?>> Project </option>
</SELECT>

</li>

<li class="odd"><h4>Company Type</h4>

 <SELECT NAME="comptype" onchange="submitfilter();" id="comptype" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
    <OPTION  value="--" selected> Both </option>
    <OPTION value="L" <?php echo ($companyType=="L") ? 'SELECTED' : ""; ?>> Listed </option>
    <OPTION  value="U" <?php echo ($companyType=="U") ? 'SELECTED' : ""; ?>> Unlisted </option>
</SELECT>

</li>




<li class="even"><h4>Investor Type
    <span ><a href="#popup3" class="help-icon1 tooltip"><img width="18" height="18" border="0" src="<?php echo $refUrl; ?>images/help.png" alt="" style="vertical-align:middle">
    <span>
    <img class="callout1" src="<?php echo $refUrl; ?>images/callout.gif">
    Definitions
    </span>
           </a>
    </span>
                                        </h4>
    <SELECT NAME="invType" id="invType" onchange="submitfilter();" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
       <OPTION id="5" value="--" selected> ALL </option>
         <?php
            /* populating the investortype from the investortype table */
            $invtypesql = "select InvestorType,InvestorTypeName from investortype where Hide=0";
            if ($invtypers = mysql_query($invtypesql)){
               $invtype_cnt = mysql_num_rows($invtypers);
            }
            if($invtype_cnt >0){
             	While($myrow=mysql_fetch_array($invtypers, MYSQL_BOTH)){
                	$id = $myrow["InvestorType"];
                	$name = $myrow["InvestorTypeName"];
                        if($regionId!='')
                        {
                              $isselcted = ($investorType==$id) ? 'SELECTED' : "";
                              echo "<OPTION id=".$id. " value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                        }
                        else
                        {
                               $isselcted = ($getinv==$name) ? 'SELECTED' : "";
                              echo "<OPTION id=".$id. " value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                        }
            	}
         		mysql_free_result($invtypers);
        	}
    ?>
</SELECT>
  </li>
<li class="odd range-to"><h4>Deal Range (US $ M)</h4>

    <SELECT name="invrangestart" id="invrangestart" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>><OPTION id=4 value="--" selected>ALL  </option>
	<?php
                $counter=0;
                for ( $counter = 0; $counter <= 1000; $counter += 50){
                    
                    if($startRangeValue!='')
                    {
			$isselcted = (($startRangeValue==$counter."")) ? 'SELECTED' : "";             
                	echo "<OPTION id=".$counter. " value=".$counter." ".$isselcted.">".$counter."</OPTION> \n";
                    }
                    else
                    {
                        $exprg = explode("-", $getrg);
                        $strg = $exprg[0];
                        $isselcted = (($strg==$counter."")) ? 'SELECTED' : "";             
                	echo "<OPTION id=".$counter. " value=".$counter." ".$isselcted.">".$counter."</OPTION> \n";
                    }
		}
          
        ?> 
</select>
<span class="range-text"> to</span>
<SELECT name="invrangeend" id="invrangeend" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?> onchange="submitfilter();"><OPTION id=5 value="--" selected>ALL  </option>
	<?php
        $counter=0;
        $endRangeValue=$endRangeValue+0.01;
                for ( $counterto = 50; $counterto <= 5000; $counterto += 50){
                   
                    
                    if($endRangeValue!='')
                    {
			$isselcted = (($endRangeValue==$counterto."")) ? 'SELECTED' : "";             
                	echo "<OPTION id=".$counterto. " value=".$counterto." ".$isselcted.">".$counterto."</OPTION> \n";
                    }
                    else
                    {
                        $exprg = explode("-", $getrg);
                        $erg = $exprg[1];
                        $isselcted = (($strg==$counterto."")) ? 'SELECTED' : "";             
                	echo "<OPTION id=".$counterto. " value=".$counterto." ".$isselcted.">".$counterto."</OPTION> \n";
                    }
				}
            
        ?> 
</select>

</li>

<li class="odd"><h4>Exit Status</h4>

   
    <select NAME="exitstatus" id="exitstatus" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?> onchange="submitfilter();">
       <OPTION  value="--" selected>All</option>
        <?php
            $exitstatusSql = "select id,status from exit_status";
            if ($exitstatusrs = mysql_query($exitstatusSql))
            {
              $exitstatus_cnt = mysql_num_rows($exitstatusrs);
            }
            if($exitstatus_cnt > 0)
            {
                    While($myrow=mysql_fetch_array($exitstatusrs, MYSQL_BOTH))
                    {
                            $id = $myrow[0];
                            $name = $myrow[1];
                            if($exitstatusValue==$id){

                                echo "<OPTION id=".$id. " value=".$id." selected>".$name."  </OPTION>\n";
                            }
                            else{
                                echo "<OPTION id=".$id. " value=".$id." >".$name."  </OPTION>\n";
                            }
                    }
            }
        ?>
   </select>
    
    
</li>

<li><input type="button" name="fliter_stage" class="fliter_stage" value="Filter" <?php if($disable_flag == "1"){ echo "disabled"; } ?> onclick="submitfilter();"></li>
</ul></div>
	</div>
	
	<h2 class="acc_trigger <?php if($showdealsbyflag==1){ ?> showdeal <?php } ?>"><a href="#">Show deals by</a></h2>
	<div  class="acc_container " style="display: none;">
		<div class="block">
<ul >
    <li class="ui-widget" style="position: relative"><h4>Investor</h4>
    <?php if($_POST['popup_select'] == 'investor'){
            //$isearch = $_POST['popup_keyword'];
            $isearch=trim(implode(',', $_POST['search_multi']));
            $iauto = $invester_filter;
        }else{
            $isearch = $_POST['keywordsearch'];
            $iauto = $_POST['investorauto'];
            
        } ?>
    <!--
<SELECT id="keywordsearch" NAME="keywordsearch">
       <OPTION id="5" value=" " selected></option>
         <?php
                 include ('reinvestors_model.php');
                
                        
             $getInvestorSql=getReInvestorsByValue(1);
				
            if ($rsinvestors = mysql_query($getInvestorSql)){
                $investor_cnt = mysql_num_rows($rsinvestors);
            }
			
            if($investor_cnt >0){
             	 While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH)){
                	$Investorname=trim($myrow["Investor"]);
					$Investorname=strtolower($Investorname);

					$invResult=substr_count($Investorname,$searchString);
					$invResult1=substr_count($Investorname,$searchString1);
					$invResult2=substr_count($Investorname,$searchString2);
					
					if(($invResult==0) && ($invResult1==0) && ($invResult2==0) && ( $myrow["Investor"]!='') ){
						$investor = $myrow["Investor"];
						//$investorId = $myrow["InvestorId"];
						//echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
						$isselcted = (trim($isearch)==trim($investor)) ? 'SELECTED' : '';
					//	echo "<OPTION value='".$investor."' ".$isselcted.">".$investor."</OPTION> \n";
					}
            	}
         		mysql_free_result($rsinvestors);
        	}
    ?>
</SELECT>
    
  -->
  
  
    <input type="text" id="investorauto_multiple" name="investorauto" value="<?php if($isearch!='') echo  $iauto;  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($isearch!='') echo "readonly='readonly'";  ?>>
    <input type="hidden" id="keywordsearch_multiple" name="keywordsearch" value="<?php if(isset($isearch)) echo  $isearch;  ?>" placeholder="" style="width:220px;">
     
     <span id="inv_clearall" title="Clear All" onclick="clear_keywordsearch1();" style="<?php if($isearch=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>
     <div id="investorauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
    
    
</li>


<li class="ui-widget" style="position: relative"><h4>Company</h4>
    <?php if($_POST['popup_select'] == 'company'){
            //$csearch = $_POST['popup_keyword'];
            $cauto = $company_filter;
            $csearch=trim(implode(',', $_POST['search_multi']));
        }else{
            $csearch = $_POST['companysearch'];
            $cauto = $_POST['companyauto'];
            
        } ?>
    <!--
<select id="combobox" name="companysearch" >
		<OPTION value=" " selected></option>
		<?php
                         $getcompaniesSql_search =  getAllReCompanies(0);
			if ($rscompanies = mysql_query($getcompaniesSql_search))
			{ 
				While($myrow1=mysql_fetch_array($rscompanies, MYSQL_BOTH))
				{
                                    
					$companyname=trim($myrow1["companyname"]);
					$companyname=strtolower($companyname);
	
					$invResult=substr_count($companyname,$searchString);
					$invResult1=substr_count($companyname,$searchString1);
					$invResult2=substr_count($companyname,$searchString2);
//	
					if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
					{
						$compName = $myrow1["companyname"];
						$isselected = (trim($csearch)==trim($compName)) ? 'SELECTED' : '';
					//	echo '<OPTION value="'.$compName.'" '.$isselected.'>'.$compName.'</OPTION> \n';
				 		//$totalCount=$totalCount+1;
					}
//	
				}
                                 mysql_free_result($rscompanies);
			}
    	?>
   </select>	
    -->
    
    <input type="text" id="companyauto" name="companyauto" value="<?php if($csearch!='') echo $cauto;  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($csearch!='') echo "readonly='readonly'";  ?>>
    <input type="hidden" id="companysearch" name="companysearch" value="<?php if(isset($csearch)) echo  $csearch;  ?>" placeholder="" style="width:220px;">
     
    <span id="com_clearall" title="Clear All" onclick="clear_companysearch1();" style="<?php if($csearch=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>
     
    <div id="companyauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
    
</li>

    <?php if($_POST['popup_select'] == 'sector'){
            $ssearch = $_POST['popup_keyword'];
            $sauto = $sectors_filter;
        }else{
            $ssearch = $_POST['sectorsearch'];
            $sauto = $_POST['sectorauto'];
            
        } ?>
<li class="ui-widget"  style="position: relative"><h4>Sub Sector</h4>
    <!--
<select id="sectorsearch" NAME="sectorsearch" >
		<OPTION value=' ' selected></option>
		<?php
                $getsectorSql_search =  getAllReSector(0);
			if ($rssector = mysql_query($getsectorSql_search))
			{
				While($myrow=mysql_fetch_array($rssector, MYSQL_BOTH))
				{
					$sectorname=trim($myrow["sector_business"]);
					$sectorname=strtolower($sectorname);
	
					$invResult=substr_count($sectorname,$searchString);
					$invResult1=substr_count($sectorname,$searchString1);
					$invResult2=substr_count($sectorname,$searchString2);
	
					if(($invResult==0) && ($invResult1==0) && ($invResult2==0) && ($sectorname!=""))
					{
						$sectorName = ($myrow["sector_business"]!="")?$myrow["sector_business"]:"Other";
						$isselected = (trim($ssearch) == trim($sectorName)) ? 'SELECTED' : ' ';
					//	echo '<OPTION value='.$sectorName.' '.$isselected.'>'.$sectorName.'</OPTION> \n';
				 		//$totalCount=$totalCount+1;
					}
				}
                                mysql_free_result($rssector);
			}
    	?>
   </select>	
    -->
    
      <input type="text" id="sectorauto" name="sectorauto" value="<?php if($ssearch!='') echo  $sauto;  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($ssearch!='') echo "readonly='readonly'";  ?>>
    <input type="hidden" id="sectorsearch_multiple" name="sectorsearch" value="<?php if(isset($ssearch)) echo  stripslashes($ssearch);  ?>" placeholder="" style="width:220px;">
     
     <span id="sec_clearall" title="Clear All" onclick="clear_sectorsearch1();" style="<?php if($ssearch=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>
     <div id="sectorauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
     
</li>
<li class="ui-widget"><h4>Legal Advisor</h4>
    <?php if($_POST['popup_select'] == 'legal_advisor'){
            $lauto = $legal_filter;
        }else{
            $lauto = $_POST['advisorsearch_legal'];            
        } ?>
<?php
           $advisorsql=getReAdvisorsByValue("L1");
	
	
	if ($rsadvisor = mysql_query($advisorsql)){
		$advisor_cnt = mysql_num_rows($rsadvisor);
	}

?>
	<SELECT id="advisorsearch_legal" NAME="advisorsearch_legal">
       <OPTION id="5" value=" " selected></option>
         <?php
            /* populating the investortype from the investortype table */
			$searchString="Undisclosed";
			$searchString=strtolower($searchString);
		
			$searchString1="Unknown";
			$searchString1=strtolower($searchString1);
		
			$searchString2="Others";
			$searchString2=strtolower($searchString2);

            if($advisor_cnt >0){
             	 While($myrow=mysql_fetch_array($rsadvisor, MYSQL_BOTH)){
                	$adviosrname=trim($myrow["Cianame"]);
					$adviosrname=strtolower($adviosrname);

					$invResult=substr_count($adviosrname,$searchString);
					$invResult1=substr_count($adviosrname,$searchString1);
					$invResult2=substr_count($adviosrname,$searchString2);

					if(($invResult==0) && ($invResult1==0) && ($invResult2==0)){ 
						$ladvisor = $myrow["Cianame"];
						$ladvisorid = $myrow["CIAId"];
						//echo "<OPTION value=".$ladvisorid.">".$ladvisor."</OPTION> \n";
						$isselcted = (trim($lauto)==trim($ladvisor)) ? 'SELECTED' : '';
						echo "<OPTION value='".$ladvisor."' ".$isselcted.">".$ladvisor."</OPTION> \n";
					}
            	}
         		mysql_free_result($rsadvisor);
        	}
    ?>
	</SELECT>
</li>

<li class="ui-widget"><h4>Transaction Advisor</h4>
<?php
	$advisorsql=getReAdvisorsByValue("T1");
        
	if ($rsadvisor = mysql_query($advisorsql)){
		$advisor_cnt = mysql_num_rows($rsadvisor);
	}

?>
    <SELECT id="advisorsearch_trans" NAME="advisorsearch_trans" class="advisorsearch_trans">
       <OPTION id="5" value=" " selected></option>
       <?php if($_POST['popup_select'] == 'transaction_advisor'){
            $tauto = $transaction_filter;
        }else{
            $tauto = $_POST['advisorsearch_trans'];
            
        } ?>
         <?php
            /* populating the investortype from the investortype table */
			$searchString="Undisclosed";
			$searchString=strtolower($searchString);
		
			$searchString1="Unknown";
			$searchString1=strtolower($searchString1);
		
			$searchString2="Others";
			$searchString2=strtolower($searchString2);

            if($advisor_cnt >0){
             	 While($myrow=mysql_fetch_array($rsadvisor, MYSQL_BOTH)){
                	$adviosrname=trim($myrow["Cianame"]);
					$adviosrname=strtolower($adviosrname);

					$invResult=substr_count($adviosrname,$searchString);
					$invResult1=substr_count($adviosrname,$searchString1);
					$invResult2=substr_count($adviosrname,$searchString2);

					if(($invResult==0) && ($invResult1==0) && ($invResult2==0)){ 
						$ladvisor = $myrow["Cianame"];
						$ladvisorid = $myrow["CIAId"];
						//echo "<OPTION value=".$ladvisorid.">".$ladvisor."</OPTION> \n";
						$isselcted = (trim($tauto)==trim($ladvisor)) ? 'SELECTED' : '';
						echo "<OPTION value='".$ladvisor."' ".$isselcted.">".$ladvisor."</OPTION> \n";
					}
            	}
         		mysql_free_result($rsadvisor);
        	}
    ?>
	</SELECT>
    </li>
    <li><input name="reset" id="resetall" class="refine reset-btn" type="button" value="Reset" style="float: left;" />
        <input type="button" name="fliter_stage" value="Filter" onclick="submitfilter();" style="float: right;">
    </li>
    
</ul></div>
	</div>


	
	<h2 class="acc_trigger"><a href="#">Search All Fields</a></h2>
	<div  class="acc_container " style="display: none;">
		<div class="block">
<form name="searchallleftmenu" action="<?php echo $actionlink; ?>" method="post" id="searchallleftmenu">   
<ul > 
<li class="ui-widget">
    <input type="text" id="searchKeywordLeft" name="searchKeywordLeft" value="<?php //if(isset($searchallfield)) echo  $searchallfield;  ?>" placeholder="" style="width:220px;">
</li>
    <li>
        <input type="button" name="fliter_stage" value="Search" onclick="submitfilter();" style="float: right;">
    </li>
    
</ul>
</form></div>
	</div>

        <script>


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
    
    
    ////////////// city search autocomplete ends /////////
    
  function clear_sectorsearch1(){
     $("#sectorauto").removeAttr('readonly');  
     val='';
    //  $("#sectorauto,#sectorsearch").val(val); 
    $("#sectorauto,#sectorsearch,#sectorsearch_multiple").val(val); 
     $("#sectorauto_load").fadeOut();
     $("#sec_clearall").fadeOut(); 
     enableFileds();
    // reloadPage();
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
     $("#investorauto_multiple").removeAttr('readonly');  
     val='';
     $("#investorauto_multiple, #keywordsearch_multiple").val(val); 
     $("#investorauto_load").fadeOut();
     $("#inv_clearall").fadeOut(); 
     enableFileds();
}  

function disableFileds(){
    $("#sltindustry").val('--');
    $("#sltindustry").prop("disabled", true);    
    $("#stage").val('');
    $("#stage").prop("disabled", true);
    $("#EntityProjectType").val('--');
    $("#EntityProjectType").prop("disabled", true);
    $("#comptype").val('--');
    $("#comptype").prop("disabled", true);
    $("#txtregion").val('--');
    $("#txtregion").prop("disabled", true);
    $("#cityauto").val('');
    $("#citysearch").val('');
    $("#citysearch").prop("disabled", true);
    $("#invType").val('--');
    $("#invType").prop("disabled", true);
    $("#invrangestart").val('--');
    $("#invrangestart").prop("disabled", true);
    $("#invrangeend").val('--');
    $("#invrangeend").prop("disabled", true);
    $("#exitstatus").val('--');
    $("#exitstatus").prop("disabled", true);
    $(".fliter_stage").prop("disabled", true);
  //  $('#sltindustry, #stage, #round, #comptype, #dealtype_debtequity, #Syndication,#citysearch,#invType,#invrangestart,#invrangeend,#exitstatus,#valuations').css('background-color', "#dddddd !important");
    $('#sltindustry,#EntityProjectType, #comptype,#invType,#invrangestart,#invrangeend,#exitstatus,#txtregion').attr('style', 'background-color: #dddddd !important');
    $('.selectgroup button').attr('style', 'width: 223px; background-color: #dddddd !important');
}
function enableFileds(){ 
    $("#sltindustry").prop("disabled", false);
    $("#stage").prop("disabled", false);
    $("#EntityProjectType").prop("disabled", false);
    $("#comptype").prop("disabled", false);
    $("#txtregion").prop("disabled", false);
    $("#citysearch").prop("disabled", false);
    $("#invType").prop("disabled", false);
    $("#invrangestart").prop("disabled", false);
    $("#invrangeend").prop("disabled", false);
    $("#exitstatus").prop("disabled", false);
    $(".fliter_stage").prop("disabled", false);
    //$('#sltindustry, #stage, #round, #comptype, #dealtype_debtequity, #Syndication,#citysearch,#invType,#invrangestart,#invrangeend,#exitstatus,#valuations').css('background-color', "#ffffff !important");
    $('#sltindustry, #EntityProjectType, #comptype,#invType,#invrangestart,#invrangeend,#exitstatus,#txtregion').attr('style', 'background-color: #ffffff !important');
    $('.selectgroup button').attr('style', 'width: 223px; background-color: #ffffff !important');
}

function submitfilter() {

localStorage.removeItem("pageno");

document.reinvestment.action = 'reindex.php';
document.reinvestment.submit();

return true;
}
            </script>