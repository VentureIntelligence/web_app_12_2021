<script>
$(document).ready(function(){ 
       
    $( "#searchallfield" ).keyup(function() {
        
        $("#searchallfieldHide").val('content_exit');        
        $("#searchKeywordLeft").val('');   
        $("#sltindustry").val('');  
        $("#stage").val('');
        $("#round").val('');
        $("#comptype").val('--');
        $("#dealtype_debtequity").val('');
        $("#Syndication").val('--');
        $("#txtregion").val('--');
        $("#cityauto").val('');
        $("#citysearch").val('');
        $("#invType").val('--');
        $("#invrangestart").val('--');
        $("#invrangeend").val('--');
        $("#exitstatus").val('--');
        $("#valuations").val('');     
    });
    
    $( "#searchKeywordLeft" ).keyup(function() {
        
        $("#searchallfieldHide").val('content_exit');        
    });
    
    var popup_select = $('#popup_select').val();
    var advisor_type = $('#advisor_type').val();
    /*if(popup_select !='' && popup_select != "tags"){
        
        if(popup_select == 'legal_advisor' || popup_select == 'transaction_advisor'){
            var tokenLimit = 1;
        }else{
            var tokenLimit = 100;
        }
        var request_url = "ajaxPopupSearch.php?vcflag=<?php echo $VCFlagValue; ?>&type="+advisor_type+"&select_type="+popup_select+"&test= ";
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
    
    $( "#popup_keyword" ).keyup(function() {
    
        var popup_select = $('#popup_select').val();
        var advisor_type = $('#advisor_type').val();
        if(popup_select !='' && popup_select != "tags"){
            
            if(popup_select == 'legal_advisor' || popup_select == 'transaction_advisor'){
                var tokenLimit = 1;
            }else{
                var tokenLimit = 100;
            }
            var request_url = "ajaxPopupSearch.php?vcflag=<?php echo $VCFlagValue; ?>&type="+advisor_type+"&select_type="+popup_select+"&test= ";
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
        if(popup_select !='' && popup_select != "tags"){
                
            if(popup_select == 'legal_advisor'){
                advisor_type = 'L';
            }else if(popup_select == 'transaction_advisor'){
                advisor_type = 'T';
            }
            $('#advisor_type').val(advisor_type);
         //  $('#popup_keyword').tokenInput("clear");
        //    $('.token-input-list').remove();
            $(".token-input-list-facebook").remove();
            var popup_select = $('#popup_select').val();
            var advisor_type = $('#advisor_type').val();
            if(popup_select == 'legal_advisor' || popup_select == 'transaction_advisor'){
                var tokenLimit = 1;
            }else{
                var tokenLimit = 100;
            }
            var request_url = "ajaxPopupSearch.php?vcflag=<?php echo $VCFlagValue; ?>&type="+advisor_type+"&select_type="+popup_select+"&test= ";
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
                    var datacount = innerdata.length;   
                   // console.log(innerdata);
                    
                    if(datacount>0) {
                        
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
                        disableFileds();
                    }
                    else{
                        $("#search_load").fadeOut();
                        $("#search_load").html('');
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
            disableFileds();
        }
        else{
            enableFileds();
            //$("#search_load").fadeOut(); 
            $("#popup_keyword").removeAttr('readonly');
            $("#popup_keyword").val('');
        }
    });
    
    $(document).on("click",function(e) {
        
//        console.log(e);
//        if ($("#search_load").is(':visible')) {
//            $("#search_load").fadeOut(); 
//        }
        if(e.target.id == "popup_keyword"  || e.target.id == "search_load" || $(e.target).parents('#search_load').length){
            $('#search_load').show();
        } else {
            $('#search_load').hide();
        }
    });
    
});


$(function() {

    $( "#investorauto_old" ).autocomplete({
        
        source: function( request, response ) {
            $('#keywordsearch').val('');
            $.ajax({
                type: "POST",
              url: "ajaxInvestorDetails.php",
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
      minLength: 2,
      select: function( event, ui ) {
            $('#keywordsearch').val(ui.item.value);
            $('#companysearch,#sectorsearch,#advisorsearch_legal,#advisorsearch_trans').val("");
            $('#companyauto,#sectorauto,#advisorsearch_legalauto,#advisorsearch_transauto').val("");
      },
      open: function() {
//        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
          if(  $('#keywordsearch').val()=="")
             $( "#investorauto" ).val('');
      }
    });
    
    $( "#companyauto_old" ).autocomplete({
        
        source: function( request, response ) {
          
            $('#companysearch').val('');
            $.ajax({
                type: "POST",
              url: "ajaxCompanyDetails.php",
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
        minLength: 2,
        select: function( event, ui ) {
            $('#companysearch').val(ui.item.value);
            $('#keywordsearch,#sectorsearch,#advisorsearch_legal,#advisorsearch_trans').val("");
            $('#investorauto,#sectorauto,#advisorsearch_legalauto,#advisorsearch_transauto').val("");
        },
        open: function() {
  //        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
        },
        close: function() {
            if( $('#companysearch').val()=="")
               $( "#companyrauto" ).val('');  
  //        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
        }
    });
    
    $( "#sectorauto_old" ).autocomplete({
        
        source: function( request, response ) {
          
            $('#sectorsearch').val('');
            $.ajax({
                type: "POST",
                url: "ajaxSectorDetails.php",
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
        minLength: 2,
        select: function( event, ui ) {
            $('#sectorsearch').val(ui.item.value);
            $('#keywordsearch,#companysearch,#advisorsearch_legal,#advisorsearch_trans').val("");
            $('#investorauto,#companyauto,#advisorsearch_legalauto,#advisorsearch_transauto').val("");
            clear_keywordsearch();
            clear_companysearch();
        },
        open: function() {
  //        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
        },
        close: function() {
            if( $('#sectorsearch').val()=="") 
                $( "#sectorauto" ).val('');  
//        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
        }
    });
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
    
    ////////////// investor search start //////////////////////
    
    $( "#investorauto" ).keyup(function() {
             
        var investorauto = $("#investorauto").val();
              
        if(investorauto.length > 1 ) {
            
            $.ajax({
                type: "post",
                url: "ajaxInvestorDetails.php",
                data: {
                    vcflag: '<?php echo $VCFlagValue; ?>',
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
        clear_sectorsearch();
        clear_searchallfield();
        $('#companysearch,#sectorsearch,#advisorsearch_legal,#advisorsearch_trans,#searchallfield').val("");
        $('#companyauto,#sectorauto,#advisorsearch_legalauto,#advisorsearch_transauto').val("");
    
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
            $("#keywordsearch").val(sltinvestor_multi); 
            $("#inv_clearall").fadeIn();
        }
        else{
          //  sltcount=0;sltholder='';
              $("#inv_clearall").fadeOut(); 
              $("#investorauto").removeAttr('readonly');
              $("#investorauto").val('');
        }
    });    
    
    $('.investor_slt').live("click", function() {  //on click 
                      
        clear_companysearch();
        clear_sectorsearch();
        clear_searchallfield();
        $('#companysearch,#sectorsearch,#advisorsearch_legal,#advisorsearch_trans,#searchallfield').val("");
        $('#companyauto,#sectorauto,#advisorsearch_legalauto,#advisorsearch_transauto').val("");
                      
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
        $("#keywordsearch").val(sltinvestor_multi); 

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
                    }
                    else{
                        $("#companyauto_load").fadeOut();
                        $("#companyauto_load").html('');
                    }
                }
            });
        }
        else{
             $("#companyauto_load").fadeOut();
        }
        
    });
    
    $("#com_selectall").live("click", function() {
    
        $("#investorauto_sug").tokenInput("clear",{focus:false});
        clear_sectorsearch();
        clear_searchallfield();
        $('#keywordsearch,#sectorsearch,#advisorsearch_legal,#advisorsearch_trans,#searchallfield').val("");
        $('#investorauto,#sectorauto,#advisorsearch_legalauto,#advisorsearch_transauto').val("");

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
            $("#com_clearall").fadeOut(); 
            $("#companyauto").removeAttr('readonly');
            $("#companyauto").val('');
        }
    });
    
    $('.company_slt').live("click", function() {  //on click 
    
        $("#investorauto_sug").tokenInput("clear",{focus:false});
        $("#investorauto_sug").tokenInput("clear",{focus:false});
        clear_sectorsearch();
        clear_searchallfield();
        $('#keywordsearch,#sectorsearch,#advisorsearch_legal,#advisorsearch_trans,#searchallfield').val("");
        $('#investorauto,#sectorauto,#advisorsearch_legalauto,#advisorsearch_transauto').val("");
                      
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
    
    ////////////// sector search start //////////////////////
    
    $( "#sectorauto" ).keyup(function() {
             
        var sectorauto = $("#sectorauto").val();
              
        if(sectorauto.length > 1 ) {
            $.ajax({
                type: "post",
                url: "ajaxSectorDetails.php",
                data: {
                 vcflag: '<?php echo $VCFlagValue; ?>',
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

                         multiselect+="<label style='clear: both;'><input type='checkbox' name='sector_multi[]' value='"+item['value']+"' class='sector_slt' data-title='"+item['value']+"' >"+item['value']+"</label></br>";

                        });

                        multiselect+="</br></br>"; 

                        $("#sectorauto_load").fadeIn();
                        $("#sectorauto_load").html(multiselect);
                        disableFileds();
                    }
                    else{
                        $("#sectorauto_load").fadeOut();
                        $("#sectorauto_load").html('');
                    }
                }
            });
        }
        else{
             $("#sectorauto_load").fadeOut();
        }
        
    });    
    
    $("#sec_selectall").live("click", function() {
    
        $("#investorauto_sug").tokenInput("clear",{focus:false});
        clear_companysearch();
        $('#keywordsearch,#companysearch,#advisorsearch_legal,#advisorsearch_trans,#searchallfield').val("");
        $('#investorauto,#companyauto,#advisorsearch_legalauto,#advisorsearch_transauto').val("");
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
              $("#sectorsearch").val(sltsector_multi); 
              $("#sec_clearall").fadeIn();
                disableFileds();
        }
        else{
    
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
        $("#investorauto_sug").tokenInput("clear",{focus:false});
                     
        clear_companysearch();
        $('#keywordsearch,#companysearch,#advisorsearch_legal,#advisorsearch_trans,#searchallfield').val("");
        $('#investorauto,#companyauto,#advisorsearch_legalauto,#advisorsearch_transauto').val("");
                      
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
            $("#sectorsearch").val(sltsector_multi); 
            disableFileds();

            if(sltcount==0){  $("#sec_clearall").fadeOut(); $("#sectorauto").removeAttr('readonly');   }
            else {   $("#sec_clearall").fadeIn();  }
                          
    });
     
    ////////////// sector search end //////////////////////
    
    $( "#advisorsearch_legalauto" ).autocomplete({
        source: function( request, response ) {
            $('#advisorsearch_legal').val('');
            $.ajax({
                type: "POST",
                url: "ajaxAdvisorDetails.php",
                dataType: "json",
                data: {
                vcflag: '<?php echo $VCFlagValue; ?>',
                search: request.term,
                type :'L'
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
        
            $('#advisorsearch_legal').val(ui.item.value);
            $('#keywordsearch,#companysearch,#sectorsearch,#advisorsearch_trans,#searchallfield').val("");
            $('#investorauto,#companyauto,#sectorsearchauto,#advisorsearch_transauto').val("");
            $("#investorauto_sug").tokenInput("clear",{focus:false});
            //clear_keywordsearch();
            clear_companysearch();
            clear_sectorsearch();
            clear_searchallfield();
            disableFileds();
        },
        open: function() {
  //        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
        },
        close: function() {
            if( $('#advisorsearch_legal').val()=="") 
            $( "#advisorsearch_legalauto" ).val('');
        }
    });
    
    $( "#advisorsearch_transauto" ).autocomplete({
        source: function( request, response ) {
            
            $('#advisorsearch_trans').val('');
            $.ajax({
                type: "POST",
                url: "ajaxAdvisorDetails.php",
                dataType: "json",
                data: {
                    vcflag: '<?php echo $VCFlagValue; ?>',
                    search: request.term,
                    type :'T'
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
            $('#advisorsearch_trans').val(ui.item.value);
            $('#keywordsearch,#companysearch,#sectorsearch,#advisorsearch_legal,#searchallfield').val("");
            $('#investorauto,#companyauto,#sectorauto,#advisorsearch_legalauto').val("");
            $("#investorauto_sug").tokenInput("clear",{focus:false}); 
            clear_companysearch();
            clear_sectorsearch();
            clear_searchallfield();
            disableFileds();
        },
        open: function() {
  //        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
        },
        close: function() {
            if( $('#advisorsearch_trans').val()=="") 
              $( "#advisorsearch_transauto" ).val('');
        }
    });
    
    $("#resetall").click(function(){
        $('#keywordsearch,#companysearch,#sectorsearch,#advisorsearch_legal,#advisorsearch_trans').val("");
        $('#investorauto,#companyauto,#sectorauto,#advisorsearch_legalauto,#advisorsearch_transauto').val("");
        $("#investorauto_sug").tokenInput("clear",{focus:false});

        //clear_keywordsearch();
        clear_companysearch();
        clear_sectorsearch();
        clear_searchallfield();
    });
    
});

</script>

<?php 
    $showdealsbyflag=0;
    if($keyword!="" || $companysearch!="" || $sectorsearch!="" || $advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
    { 
        $showdealsbyflag=1;
        $disable_flag = "1";
        $background = "#dddddd  !important";       
    }else{
        $disable_flag = "0";
        $background = "#ffffff";          
    }  
?>

<h2 class="acc_trigger"><a href="#">Refine Search</a></h2>
<div class="acc_container"  id="firstrefine">
    <div class="block">
        <ul>
            <li class="even"><h4>Industry</h4>
                <div class="selectgroup">
                    <select name="industry[]" multiple="multiple"  id="sltindustry" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>
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
                                        $isselected = ($getindus==$name) ? 'SELECTED' : '';
                                        echo "<OPTION id='industry_".$id. "' value=".$id." ".$isselected.">".$name."</OPTION> \n";
                                    }

                                }
                                mysql_free_result($industryrs);
                        }
                    ?>
                    </select>
                </div>
            </li>

            <li class="odd"><h4>Stage</h4>
                <span><a href="#popup2" class="help-icon1 tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
                <span><img class="callout1" src="images/callout.gif">Definitions</span></a></span>
                <div class="selectgroup">
                    <select name="stage[]" multiple="multiple" size="5" id='stage' style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                    <?php
	
                        if ($stagers = mysql_query($stagesql_search)){
                                $stage_cnt = mysql_num_rows($stagers);
                        }
                        if($stage_cnt > 0){
                            $i=1;
                            While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH)){
                                $id = $myrow[0];
                                $name = $myrow[1];
                                if(count($stageval) > 0){
                                    $isselect = (in_array($id,$stageval))?'selected':''; 
                                }else{
                                    $isselect = ''; 
                                }
                                
                                echo '<OPTION value="'.$id.'" '.$isselect.'>'.$name.'</OPTION> \n';
                                
                            }
                            mysql_free_result($stagers);
                        }
                    ?>
                    </select> 
                </div>
            </li>
            
            <li class="old"><h4>Round</h4>
                <div class="selectgroup">
                    <select name="round[]" multiple="multiple" id="round" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                        
                        <?php if(count($round) > 0){ ?>
                            <option id="round_1" value="seed" <?php if(in_array("seed",$round)) echo 'selected'; ?>>Seed</option>
                        <?php }else{ ?>
                            <option id="round_1" value="seed">Seed</option>
                        <?php } ?>
                        
                        <?php
                        $j=1;
                        if($vcflagValue==0){
                            $seed=13;
                        }else{
                            $seed=5;
                        }
                        for($i=1; $i<$seed; $i++) {
                            $j++;
                            if(count($round) > 0){
                                $roundSel = (in_array($id,$stageval))?'selected':''; 
                            }else{
                                $roundSel = ''; 
                            }
                      
                            echo '<option id="round_'.$j.'" value="'.$i.'" '.$roundSel.'>'.$i.'</option>';
                            
                            
                        }
                        if($vcflagValue==0){ ?>
                
                        <option id="round_Open" value="Open Market Transaction" <?php if($round == "Open Market Transaction") echo 'selected'; ?>>Open Market Transaction</option>
                        <option id="round_Preferential" value="Preferential Allotment" <?php if($round == "Preferential Allotment") echo 'selected'; ?>>Preferential Allotment</option>
                        <option id="round_Special" value="Special Situation" <?php if($round == "Special Situation") echo 'selected'; ?>>Special Situation</option> 
                        
                        <?php   } ?>
                    </select>
                </div>
            </li>
            
            <li>
                <input type="button" name="fliter_stage" class="fliter_stage" value="Filter" onclick="this.form.submit();" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
            </li>		
            <?php if($vcflagValue != 1 ){ ?>
            <li class="odd"><h4>Company Type</h4>

                <SELECT NAME="comptype" onchange="this.form.submit();" id="comptype" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                <OPTION  value="--" selected> Both </option>
                <OPTION value="L" <?php echo ($companyType=="L") ? 'SELECTED' : ""; ?>> Listed </option>
                <OPTION  value="U" <?php echo ($companyType=="U") ? 'SELECTED' : ""; ?>> Unlisted </option>
                </SELECT>
            </li>
            <?php } ?>
            <li class="even"><h4>Deal Type</h4>

                <SELECT NAME="dealtype_debtequity" onchange="this.form.submit();" id="dealtype_debtequity" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                <OPTION  value="--" selected>All</option>
                <OPTION value="0" <?php echo ($debt_equity=="0") ? 'SELECTED' : ""; ?>>Equity Only</option>
                <OPTION  value="1" <?php echo ($debt_equity=="1") ? 'SELECTED' : ""; ?>>Debt Only</option>
                </SELECT>
            </li>

            <li class="odd"><h4>Syndication</h4>

                <SELECT NAME="Syndication" onchange="this.form.submit();" id="Syndication" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                   <OPTION  value="--" selected>Both</option>
                   <OPTION value="0" <?php echo ($syndication=="0") ? 'SELECTED' : ""; ?>>Yes</option>
                   <OPTION  value="1" <?php echo ($syndication=="1") ? 'SELECTED' : ""; ?>>No</option>
               </SELECT>
            </li>
<!--<input type="radio" value="--" name="dealtype_debtequity" checked >Equity & Debt
			  <input type="radio" value="0" name="dealtype_debtequity" >Equity Only
                          <input type="radio" value="1" name="dealtype_debtequity" >Debt Only-->


<li class="even"><h4>Region</h4>
    <div class="selectgroup">
    <SELECT NAME="txtregion[]" id="txtregion" multiple="multiple" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
	<!--<OPTION id=5 value="--" selected> ALL </option>-->
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
                 if(count($regionId)>0)
                  {
                        $isselcted = (in_array($id,$regionId))?'selected':''; 
                        echo "<OPTION id='region_".$id. "' value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                  }
                  else
                  {
                      $isselcted = ($getreg==$name) ? 'SELECTED' : "";
                       echo "<OPTION id='region_".$id. "' value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                      
                  }
        	}
    		mysql_free_result($regionrs);
    	}
?>
</SELECT>
    </div>
</li>
<li class="ui-widget" style="position: relative"><h4>City</h4>
    <input type="hidden" id="cityauto" name="cityauto" value="<?php if($city!='') echo  $_POST['cityauto'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($city!='') echo "readonly='readonly'";  ?>>
    <input type="text" id="citysearch" name="citysearch" value="<?php if(isset($city)) echo  $city;  ?>" placeholder="" style="width:220px;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
     
    <!-- <span id="com_clearall" title="Clear All" onclick="clear_companysearch();" style="<?php if($_POST['citysearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span> -->
     
    <div id="cityauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
     
</li>
<li class="even"><h4>Investor Type
    <span ><a href="#popup3" class="help-icon1 tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
        <span>
        <img class="callout1" src="images/callout.gif">
        Definitions
        </span>
     </a></span></h4>
    <SELECT NAME="invType" onchange="this.form.submit();"  id="invType" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
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
                              $isselcted = ($investorType==$id) ? 'SELECTED' : "";
                              echo "<OPTION id=".$id. " value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
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
            if($VCFlagValue==0 )
            {
                for ( $counter = 0; $counter <= 1000; $counter += 5){
                    
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
            }
            if($VCFlagValue==1)
            {
                for ( $counter = 0; $counter <= 20; $counter += 1){
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
            }
        ?> 
</select>
<span class="range-text"> to</span>
<SELECT name="invrangeend" onchange="this.form.submit();" id="invrangeend" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>><OPTION id=5 value="--" selected>ALL  </option>
	<?php
        $counter=0;
            if($VCFlagValue==0 )
            {
                for ( $counterto = 5; $counterto <= 5000; $counterto += 5){
                    
                    if($endRangeValue!='')
                    {
			$isselcted = ((round($endRangeValue)==$counterto."")) ? 'SELECTED' : "";             
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
            }
            if($VCFlagValue==1)
            {
                for ( $counterto = 1; $counterto <= 21; $counterto += 1){
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
            }
        ?> 
</select>
</li>
<li class="odd"><h4>Exit Status</h4>
<div class="selectgroup">
    <SELECT NAME="exitstatus[]" id="exitstatus" multiple="multiple" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
       <!--<OPTION  value="--" selected>All</option>-->
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
                    
                    if(count($exitstatusValue) > 0){
                        $isselcted = (in_array($id,$exitstatusValue))?'selected':''; 
                    }else{
                        $isselcted ='';
                    }
                    echo "<OPTION id='exitstatus_".$id. "' value=".$id." $isselcted>".$name."  </OPTION>\n";
                }
            }
        ?>
<!--       <OPTION value="1" <?php echo ($exitstatusValue=="1") ? 'SELECTED' : ""; ?>>Unexited</option>
       <OPTION  value="2" <?php echo ($exitstatusValue=="2") ? 'SELECTED' : ""; ?>>Partially Exited</option>
       <OPTION  value="3" <?php echo ($exitstatusValue=="3") ? 'SELECTED' : ""; ?>>Fully Exited</option>-->
   </SELECT>
    </div>
</li>
    
<!-- -->

<li class="odd"><h4>Valuations</h4>
<div class="selectgroup">
   
    <select name="valuations[]" multiple="multiple" size="4" id='valuations' style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
    <option value="Company_Valuation"  <?php if($boolvaluations==true && ( $valuations[0]=='Company_Valuation' || $valuations[1]=='Company_Valuation' || $valuations[2]=='Company_Valuation'  || $valuations[3]=='Company_Valuation' )) { echo 'selected';} ?> >Company Valuation</option>
    <option value="Revenue_Multiple"  <?php if($boolvaluations==true && ( $valuations[0]=='Revenue_Multiple' || $valuations[1]=='Revenue_Multiple' || $valuations[2]=='Revenue_Multiple' || $valuations[3]=='Revenue_Multiple' )) { echo 'selected';} ?> >Revenue Multiple</option>
    <option value="EBITDA_Multiple"   <?php if($boolvaluations==true && ($valuations[0]=='EBITDA_Multiple' || $valuations[1]=='EBITDA_Multiple' || $valuations[2]=='EBITDA_Multiple' || $valuations[3]=='EBITDA_Multiple' )) { echo 'selected';} ?>>EBITDA Multiple</option>
    <option value="PAT_Multiple"   <?php if($boolvaluations==true && ($valuations[0]=='PAT_Multiple' || $valuations[1]=='PAT_Multiple' || $valuations[2]=='PAT_Multiple' || $valuations[3]=='PAT_Multiple') ) { echo 'selected';} ?>>PAT Multiple</option>
</select> </div>
</li>
<!-- -->    

<li>
<input type="button" name="fliter_stage"  class="fliter_stage" value="Filter" onclick="this.form.submit();" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
</li>

</ul></div>
	</div>
	
	<h2 class="acc_trigger <?php if($showdealsbyflag==1){ ?> showdeal <?php } ?>"><a href="#">Show deals by</a></h2>
	<div  class="acc_container " style="display: none;">
		<div class="block">
<ul >
    <li class="ui-widget" style="position: relative"><h4>Investor</h4>
   
        
   <!-- <input type="text" id="investorauto" name="investorauto" value="<?php if($_POST['keywordsearch']!='') echo  $_POST['investorauto'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['keywordsearch']!='') echo "readonly='readonly'";  ?>>
     <input type="hidden" id="keywordsearch" name="keywordsearch" value="<?php if(isset($_POST['keywordsearch'])) echo  $_POST['keywordsearch'];  ?>" placeholder="" style="width:220px;">-->
        <?php if($_POST['popup_select'] == 'investor'){
            $isearch = $_POST['popup_keyword'];
            $iauto = $invester_filter;
        }else  if($_POST['investorauto_sug_other'] != ''){
            $isearch = $_POST['keywordsearch_other'];
            $iauto = $investorauto;
        }else{
            $isearch = $_POST['keywordsearch'];
            $iauto = $_POST['investorauto_sug'];
            
        } ?>   
        <input type="text" id="investorauto_sug" name="investorauto_sug" value="<?php if($iauto!='') echo  $iauto;  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['keywordsearch']!='') echo "readonly='readonly'";  ?>>
     <input type="hidden" id="keywordsearch" name="keywordsearch" value="<?php if(isset($isearch)) echo  $isearch;  ?>" placeholder="" style="width:220px;">
     
    <!-- <span id="inv_clearall" title="Clear All" onclick="clear_keywordsearch();" style="<?php if($_POST['keywordsearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>-->
     <div id="investorauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
     
     
</li>
<li class="ui-widget" style="position: relative"><h4>Company</h4>
    <?php 
    if($_POST['popup_select'] == 'company'){
            $csearch = $_POST['popup_keyword'];
            $cauto = $company_filter;
        }else if($_POST['companyauto_other'] != ''){
            $csearch = $_POST['companysearch_other'];
            $cauto = $_POST['companyauto_other'];
        }else if($_POST['companysearch'] !=''){
            $csearch = $_POST['companysearch'];
            $cauto = $_POST['companyauto'];            
        }else{
            $csearch = $companysearch;
            $cauto = $company_filter;
            
        } ?>
    <input type="text" id="companyauto" name="companyauto" value="<?php echo $cauto;  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($csearch!='') echo "readonly='readonly'";  ?>>
     <input type="hidden" id="companysearch" name="companysearch" value="<?php echo $csearch;  ?>" placeholder="" style="width:220px;">
     
    <span id="com_clearall" title="Clear All" onclick="clear_companysearch1();" style="<?php if($csearch=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>
     
    <div id="companyauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
     
</li>
<li class="ui-widget" style="position: relative"><h4>Sector</h4>
    <?php if($_POST['popup_select'] == 'sector'){
            $ssearch = $_POST['popup_keyword'];
            $sauto = $sectors_filter;
        }else if($_POST['sectorsearch_other'] != ''){
            $ssearch = $_POST['sectorsearch_other'];
            $sauto = $_POST['sectorsearch_other'];
        }else{
            $ssearch = $_POST['sectorsearch'];
            $sauto = $_POST['sectorauto'];
            
        } ?>
     
    <input type="text" id="sectorauto" name="sectorauto" value="<?php if($ssearch!='') echo  $sauto;  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($ssearch!='') echo "readonly='readonly'";  ?>>
    <input type="hidden" id="sectorsearch" name="sectorsearch" value="<?php if(isset($ssearch)) echo  stripslashes($ssearch);  ?>" placeholder="" style="width:220px;">
     
     <span id="sec_clearall" title="Clear All" onclick="clear_sectorsearch1();" style="<?php if($ssearch=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>
     <div id="sectorauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
</li>

    <?php if($_POST['popup_select'] == 'legal_advisor'){
            $lauto = $legal_filter;
        }else if($_POST['advisorsearch_legal_other'] != ''){
            $lauto = $_POST['advisorsearch_legal_other'];
        }else{
            $lauto = $_POST['advisorsearch_legal'];            
        } ?>
<li class="ui-widget"><h4>Legal Advisor</h4>
    <input type="text" id="advisorsearch_legalauto" name="advisorsearch_legalauto" value="<?php if(isset($lauto)) echo  $lauto;  ?>" placeholder="" style="width:220px;">
     <input type="hidden" id="advisorsearch_legal" name="advisorsearch_legal" value="<?php if(isset($lauto)) echo  $lauto;  ?>" placeholder="" style="width:220px;">
</li>
    <?php 
        if($_POST['popup_select'] == 'transaction_advisor'){
            $tauto = $transaction_filter;
        }else if($_POST['advisorsearch_trans_other'] != ''){
            $tauto = $_POST['advisorsearch_trans_other'];
        }else{
            $tauto = $_POST['advisorsearch_trans'];            
        } ?>
<li class="ui-widget"><h4>Transaction Advisor</h4>
    <input type="text" id="advisorsearch_transauto" name="advisorsearch_transauto" value="<?php if(isset($tauto)) echo  $tauto;  ?>" placeholder="" style="width:220px;">
     <input type="hidden" id="advisorsearch_trans" name="advisorsearch_trans" value="<?php if(isset($tauto)) echo  $tauto;  ?>" placeholder="" style="width:220px;">
</li>




    <li><input name="reset" id="resetall" class="refine reset-btn" type="button" value="Reset" style="float: left;" />
        <input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();" style="float: right;">
    </li>
    
</ul></div>
	</div>
	<h2 class="acc_trigger"><a href="#">Search All Fields</a></h2>
	<div  class="acc_container " style="display: none;">
		<div class="block">
<form name="searchallleftmenu" action="<?php echo $actionlink; ?>" method="post" id="searchallleftmenu">   
<ul > 
<li class="ui-widget">
    <input type="text" id="searchKeywordLeft" name="searchKeywordLeft" value="<?php //if(isset($_POST['searchKeywordLeft'])) echo  $_POST['searchKeywordLeft'];  ?>" placeholder="" style="width:220px;">
</li>
    <li>
        <input type="button" name="fliter_stage" class="fliter_stage fliter_stage1" value="Search"  style="float: right;">
    </li>
    
</ul>
</form></div>
	</div>
<script type="text/javascript" >

   $(document).ready(function(){ 

        $("#investorauto_sug").tokenInput("ajaxInvestorDetails_auto.php?vcf=<?php echo $VCFlagValue; ?>",{
            theme: "facebook",
            minChars:2,
            queryParam: "pe_q",
            hintText: "",
            noResultsText: "No Result Found",
            preventDuplicates: true,
                onAdd: function (item) {
                      clear_keywordsearch()
                      clear_companysearch();
                      clear_sectorsearch();
            clear_searchallfield();
                        disableFileds();
                      $('#keywordsearch,#companysearch,#sectorsearch,#advisorsearch_trans,#searchallfield,#advisorsearch_legal').val("");
                    $('#investorauto,#companyauto,#sectorsearchauto,#advisorsearch_transauto,#advisorsearch_legalauto').val("");

                },
                onDelete: function (item) {
                    var selectedValues = $('#investorauto_sug').tokenInput("get");
                    var inputCount = selectedValues.length;
                    if(inputCount==0){ 
                       // reloadPage();
                       enableFileds();
                    }
        },
            prePopulate : <?php if($investorsug_response!=''){echo   $investorsug_response; }else{ echo 'null'; } ?>
        });
    }); 
    $( "#advisorsearch_transauto,#advisorsearch_legalauto" ).keyup(function() {
        var val_trans = $("#advisorsearch_transauto").val();
        var val_legal = $("#advisorsearch_legalauto").val();
        if(val_legal.length < 1 && val_trans.length < 1){
            enableFileds();
        }else{
            disableFileds();            
        }
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

        function clear_sectorsearch(){
            $("#sectorauto").removeAttr('readonly');  
            val='';
            $("#sectorauto,#sectorsearch").val(val); 
            $("#sectorauto_load").fadeOut();
            $("#sec_clearall").fadeOut(); 
        } 
  function clear_searchallfield(){
     $("#searchallfieldHide").val('remove');
     $("#searchallfield").val('');
     $("#searchallfield").fadeOut();
} 
  function reloadPage(){ 
        var url      = window.location.href;
        window.location.href = url;
  }
    
  function clear_sectorsearch1(){
     $("#sectorauto").removeAttr('readonly');  
     val='';
     $("#sectorauto,#sectorsearch").val(val); 
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


function disableFileds(){
    $("#sltindustry").val('--');
    $("#sltindustry").prop("disabled", true);    
    $("#stage").val('');
    $("#stage").prop("disabled", true);
    $("#round").val('--');
    $("#round").prop("disabled", true);
    $("#comptype").val('--');
    $("#comptype").prop("disabled", true);
    $("#dealtype_debtequity").val('');
    $("#dealtype_debtequity").prop("disabled", true);
    $("#Syndication").val('--');
    $("#Syndication").prop("disabled", true);
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
    $("#valuations").val('');
    $("#valuations").prop("disabled", true);
    $(".fliter_stage").prop("disabled", true);
  //  $('#sltindustry, #stage, #round, #comptype, #dealtype_debtequity, #Syndication,#citysearch,#invType,#invrangestart,#invrangeend,#exitstatus,#valuations').css('background-color', "#dddddd !important");
    $(' #comptype, #dealtype_debtequity, #Syndication,#invType,#invrangestart,#invrangeend').attr('style', 'background-color: #dddddd !important');
    $('.selectgroup button').attr('style', 'width: 223px; background-color: #dddddd !important');
}
function enableFileds(){ 
    $("#sltindustry").prop("disabled", false);
    $("#stage").prop("disabled", false);
    $("#round").prop("disabled", false);
    $("#comptype").prop("disabled", false);
    $("#dealtype_debtequity").prop("disabled", false);
    $("#Syndication").prop("disabled", false);
    $("#txtregion").prop("disabled", false);
    $("#citysearch").prop("disabled", false);
    $("#invType").prop("disabled", false);
    $("#invrangestart").prop("disabled", false);
    $("#invrangeend").prop("disabled", false);
    $("#exitstatus").prop("disabled", false);
    $("#valuations").prop("disabled", false);
    $(".fliter_stage").prop("disabled", false);
    //$('#sltindustry, #stage, #round, #comptype, #dealtype_debtequity, #Syndication,#citysearch,#invType,#invrangestart,#invrangeend,#exitstatus,#valuations').css('background-color', "#ffffff !important");
    $('#comptype, #dealtype_debtequity, #Syndication,#invType,#invrangestart,#invrangeend').attr('style', 'background-color: #ffffff !important');
    $('.selectgroup button').attr('style', 'width: 223px; background-color: #ffffff !important');
}

$( ".fliter_stage1" ).click(function() {
    clear_searchallfield();
    var searchKeywordLeft = $("#searchKeywordLeft").val();
     $("#searchallfield").val(searchKeywordLeft);
    this.form.submit();
});
    </script>
