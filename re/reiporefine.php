<SCRIPT  type="text/javascript">  
    $( "#searchallfield" ).keyup(function() {
            $("#searchallfieldHide").val('');     
            $("#sltindustry").val('');  
            $("#exitstatus").val('--'); 
            $('#investorauto_multiple').val();
            $('#companyauto').val();
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
                     url: "ajaxMultiAutosuggest.php?getinvestor",
                     data: {
                          getReInvestorsByValue: '2',
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
                                
                               multiselect+="<label style='clear: both;'><input type='checkbox' name='investor_multi[]' value='"+item['investorid']+"' class='investor_slt' data-title='"+item['investorname']+"' >"+item['investorname']+"</label></br>";

                            });
                            
                            multiselect+="</br></br>"; 
                            
                            $("#investorauto_load").fadeIn();
                            $("#investorauto_load").html(multiselect);
                            disableFileds();
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
             enableFileds();
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
                  $("#investorauto_multiple").attr('readonly','readonly'); 
                  $("#investorauto_multiple").val(sltholder);
                  $("#keywordsearch_multiple").val(sltinvestor_multi); 
                  $("#inv_clearall").fadeIn();
                    disableFileds();
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
                     
                    $("#investorauto_multiple").attr('readonly','readonly');  
                    $("#investorauto_multiple").val(sltholder); 
                    $("#keywordsearch_multiple").val(sltinvestor_multi); 
                    disableFileds();
                    
                    
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
                        getAllReCompanies: '1',
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
                  $("#companyauto").attr('readonly','readonly'); 
                  $("#companyauto").val(sltholder);
                  $("#companysearch").val(sltcompany_multi); 
                  $("#com_clearall").fadeIn();
                    disableFileds();
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

  function clear_keywordsearch1(){
     $("#investorauto_multiple").removeAttr('readonly');  
     val='';
     $("#investorauto_multiple, #keywordsearch_multiple").val(val); 
     $("#investorauto_load").fadeOut();
     $("#inv_clearall").fadeOut();
     enableFileds(); 
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
    $("#exitstatus").val('--');
    $("#exitstatus").prop("disabled", true);
    $(".fliter_stage").prop("disabled", true);
    $('#sltindustry,#exitstatus').attr('style', 'background-color: #dddddd !important');
}
function enableFileds(){ 
    $("#sltindustry").prop("disabled", false);
    $("#exitstatus").prop("disabled", false);
    $(".fliter_stage").prop("disabled", false);
    $('#sltindustry,#exitstatus').attr('style', 'background-color: #ffffff !important');
}
  </script>
  
<?php 
$industrysql_search="select industryid,industry from reindustry";
      
$showdealsbyflag=0;
if($keyword!="" || $companysearch!="" || $sectorsearch!="" || $advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
{ 
    $showdealsbyflag=1;
    $disable_flag = "1";
    $background = "#dddddd  !important";       
}else{
    $disable_flag = "0";
    $background = "#ffffff";          
}  ?>

<h2 class="acc_trigger"><a href="#">Refine Search</a></h2>
<div class="acc_container" id="firstrefine">
		<div class="block">
			<ul >
<li class="even"><h4>Industry</h4>
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
</li>


<li class="odd"><h4>Exit Status</h4>

   <select NAME="exitstatus" onchange="this.form.submit();" id="exitstatus" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
       <option  value="--" selected>All</option>
       <option value="0" <?php if(isset($exitstatusvalue) && $exitstatusvalue=="0"){ echo 'selected="selected"'; } ?> >Partial</option>
       <option value="1" <?php if(isset($exitstatusvalue) && $exitstatusvalue=="1"){ echo 'selected="selected"'; } ?> >Complete</option>
   </select>
    
    
</li>

</ul>
                </div>
	</div>
	
	<h2 class="acc_trigger <?php if($showdealsbyflag==1){ ?> showdeal <?php } ?>"><a href="#">Show deals by</a></h2>
	<div  class="acc_container " style="display: none;">
		<div class="block">
<ul >
<li class="ui-widget" style="position: relative"><h4>Investor</h4>
  <!--  
<SELECT id="keywordsearch" NAME="investorsearch">
       <OPTION id="5" value=" " selected></option>
         <?php
                 include ('reinvestors_model.php');
                
                        
             $getInvestorSql=getReInvestorsByValue(2);
				
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
						$investorId = $myrow["InvestorId"];
						//echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
						$isselcted = (trim($_POST['investorsearch'])==trim($investor)) ? 'SELECTED' : '';
						// echo "<OPTION value='".$investor."' ".$isselcted.">".$investor."</OPTION> \n";
					}
            	}
         		mysql_free_result($rsinvestors);
        	}
    ?>
</SELECT>
 -->
 
    <input type="text" id="investorauto_multiple" name="investorauto" value="<?php if($_POST['investorsearch']!='') echo  $_POST['investorauto'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['investorsearch']!='') echo "readonly='readonly'";  ?>>
    <input type="hidden" id="keywordsearch_multiple" name="investorsearch" value="<?php if(isset($_POST['investorsearch'])) echo  $_POST['investorsearch'];  ?>" placeholder="" style="width:220px;">
     
     <span id="inv_clearall" title="Clear All" onclick="clear_keywordsearch1();" style="<?php if($_POST['investorsearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>
     <div id="investorauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
 
</li>


<li class="ui-widget" style="position: relative"><h4>Company</h4>
    <!--
<select id="combobox" name="companysearch" >
		<OPTION value=" " selected></option>
		<?php
                         $getcompaniesSql_search =  getAllReCompanies(1);
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
						$isselected = (trim($_POST['companysearch'])==trim($compName)) ? 'SELECTED' : '';
						//echo '<OPTION value="'.$compName.'" '.$isselected.'>'.$compName.'</OPTION> \n';
				 		//$totalCount=$totalCount+1;
					}
//	
				}
                                 mysql_free_result($rscompanies);
			}
    	?>
   </select>	
 -->   
    
      <input type="text" id="companyauto" name="companyauto" value="<?php if($_POST['companysearch']!='') echo  $_POST['companyauto'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['companysearch']!='') echo "readonly='readonly'";  ?>>
    <input type="hidden" id="companysearch" name="companysearch" value="<?php if(isset($_POST['companysearch'])) echo  $_POST['companysearch'];  ?>" placeholder="" style="width:220px;">
     
    <span id="com_clearall" title="Clear All" onclick="clear_companysearch1();" style="<?php if($_POST['companysearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>
     
    <div id="companyauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
    
    
</li>
    <li><input name="reset" id="resetall" class="refine reset-btn" type="button" value="Reset" style="float: left;" />
        <input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();" style="float: right;">
    </li>
    
</ul></div>
	</div>



