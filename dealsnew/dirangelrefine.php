<?php
	require("../dbconnectvi.php");
    $Db = new dbInvestments();
    if(!isset($_SESSION['UserNames']))
{
         header('Location:../pelogin.php');
}
else
{
?>
<script>
  $(function() {
    
      
    ////////////// investor search start //////////////////////


      $( "#investorauto" ).keyup(function() {
             
             var investorauto = $("#investorauto").val();
              
             if(investorauto.length > 2 ) {
                    $.ajax({
                       type: "post",
                      url: "autoinvestors.php",
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
                                
                               multiselect+="<label style='clear: both;'><input type='checkbox' name='investor_multi[]' value='"+item['investorid']+"' class='investor_slt' data-title='"+item['investorname']+"' >"+item['investorname']+"</label></br>";

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
    
    ////////////// investor search end  //////////////////////
    
    
    
    ////////////// Company search start //////////////////////
    
          $( "#companyauto" ).keyup(function() {
             
             var companyauto = $("#companyauto").val();
              
             if(companyauto.length > 2 ) {
                    $.ajax({
                       type: "post",
                      url: "autocompanies.php",
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
                                
                               multiselect+="<label style='clear: both;'><input type='checkbox' name='company_multi[]' value='"+item['companyid']+"' class='company_slt' data-title='"+item['companyname']+"' >"+item['companyname']+"</label></br>";

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
             //clear_keywordsearch();
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
                 enableFileds();
               //  sltcount=0;sltholder='';
                   $("#com_clearall").fadeOut(); 
                   $("#companyauto").removeAttr('readonly');
                   $("#companyauto").val('');
             }
        });
    
          $('.company_slt').live("click", function() {  //on click 
                      
                $("#investorauto_sug").tokenInput("clear",{focus:false});

                // clear_keywordsearch();
                      
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
    
    ////////////// Company search start //////////////////////
    
    $("#resetall").click(function(){
        
        $('#investors,#company').val("");
       $('#autokeyword,#autocompany').val("");
       $("#investorauto_sug").tokenInput("clear",{focus:false});

    });
    
    
    
    
  });
  
  </script>

<?php 
 $showdealsbyflag=0; 
 
 if(($keyword!="" && $keyword!=" ") || ($companysearch!="" && $companysearch!=" "))
 {
 $showdealsbyflag=1;    
 }
  if($companysearch != "" || $keyword !="") {
      $disable_flag = "1";
      $background = "#dddddd  !important";
  } else{
      $disable_flag = "0";
      $background = "#ffffff";
  }  
?>

<h2 class="acc_trigger"><a href="#">Refine Search</a></h2>
	<div class="acc_container">
		<div class="block">
			<ul >

<!--<li class="even"><h4>Industry
     <span ><a href="#popup4" class="help-icon1 tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
        <span>
        <img class="callout1" src="images/callout.gif">
        Definitions
        </span>
     </a></span></h4>
 input type="text" value="" name="industries" id="industries"  class=""  autocomplete=off  style="width:220px;"/>
 <input type="hidden" name="industry" id="industry" value="" /
<div class="selectgroup">
 <SELECT name="industry"  id="industry" style="font-family: Arial; color: #004646;font-size: 8pt; background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
    <OPTION id=0 value="--" selected> ALL </option>
        <?php
                $industrysql="select industryid,industry from industry where industryid !=15 ".$hideIndustry." order by industry";
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
                                if($industry!='')
                                        {
                                            $isselected = (in_array($id,$industry))?'selected':''; 
                                            echo "<OPTION id=".$id. " value=".$id." ".$isselected.">".$name."</OPTION> \n";
                        }
                                        else
                                        {
                                            $isselected = ($getindus==$name) ? 'SELECTED' : '';
                                            echo "<OPTION id=".$id. " value=".$id." ".$isselected.">".$name."</OPTION> \n";
                                        }
                        }
                        mysql_free_result($industryrs);
                }
         ?></select>
</div>
</li>-->
<li class="even"><h4>Industry</h4>
<select name="industry" onchange="industrypesearch();"    id="sltindustry">
  		<OPTION id=0 value="" selected> ALL  </option>
		<?php
			 $industrysql="select industryid,industry from industry where industryid IN (".$_SESSION['PE_industries'].")   " . $hideIndustry ." order by industry";
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
                                                $isselcted = ($_POST['industry']==$id) ? 'SELECTED' : "";
						echo "<OPTION id=".$id. " value=".$id." ".$isselcted.">".$name."</OPTION> \n";
					}
				 	mysql_free_result($industryrs);
				}
    		?>
</SELECT></li>
<li class="odd"><h4>Follow on Funding Status</h4>
    <SELECT NAME="followonVCFund" id="followonVCFund" style=" background: <?php echo $background; ?>;" onchange="this.form.submit();" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
        <?php $followonVCFund=$followonVC; ?>
			 <OPTION id=1 value="--" selected> All </option>
			 <OPTION VALUE=1  <?php if($followonVCFund==1) echo "selected" ?> >Obtained</OPTION>
			 <OPTION VALUE=2 <?php if($followonVCFund==2) echo "selected" ?>>None</OPTION>
			</SELECT>
</li>

<li class="even"><h4>Exited</h4>   
    <SELECT NAME="exitedstatus" style=" background: <?php echo $background; ?>;" id="exitedstatus" <?php if($disable_flag == "1"){ echo "disabled"; } ?>  onchange="this.form.submit();">
     <?php  $exitedstatus=$exitvalue; ?>
			 <OPTION value="--" selected> All </option>
			 <OPTION VALUE=1 <?php if($exitedstatus==1) echo "selected" ?>>Exited</OPTION>
			 <OPTION VALUE=2 <?php if($exitedstatus==2) echo "selected" ?>>Not Exited</OPTION>               
</SELECT>
</li>
<li class="odd"><h4>Region</h4>
    <div class="selectgroup">
    <SELECT NAME="txtregion[]" multiple="multiple" id="txtregion" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?> onchange="this.form.submit();">
	<!--<OPTION id=5 value="" selected> ALL </option>-->
     <?php
        /* populating the region from the Region table */
        $regionsql = "select RegionId,Region from region where Region !='' order by RegionId";
        if ($regionrs = mysql_query($regionsql)){
        	$region_cnt = mysql_num_rows($regionrs);
        }
        if($region_cnt >0){
        	While($myregionrow=mysql_fetch_array($regionrs, MYSQL_BOTH)){
            	$id = $myregionrow["RegionId"];
            	$name = $myregionrow["Region"];
                $isselcted = (in_array($id,$txtregion))?'selected':''; 
             	echo "<OPTION id='".$id. "' value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
        	}
    		mysql_free_result($regionrs);
    	}
?>
</SELECT>
    </div>                  
</li>
<li class="odd range-to"><h4>Dates Between</h4>
    <SELECT NAME=month1 id="tour_month1" style="font-family: Arial; color: #004646;font-size: 8pt">
			 <OPTION id=1 value="--" selected> Month </option>
			 <OPTION VALUE=1 <?php echo ($_POST['month1']=='1') ? 'Selected' : ''; ?>>Jan </OPTION>
			 <OPTION VALUE=2 <?php echo ($_POST['month1']=='2') ? 'Selected' : ''; ?>>Feb</OPTION>
			 <OPTION VALUE=3 <?php echo ($_POST['month1']=='3') ? 'Selected' : ''; ?>>Mar</OPTION>
			 <OPTION VALUE=4 <?php echo ($_POST['month1']=='4') ? 'Selected' : ''; ?>>Apr</OPTION>
			 <OPTION VALUE=5 <?php echo ($_POST['month1']=='5') ? 'Selected' : ''; ?>>May</OPTION>
			 <OPTION VALUE=6 <?php echo ($_POST['month1']=='6') ? 'Selected' : ''; ?>>Jun</OPTION>
			 <OPTION VALUE=7 <?php echo ($_POST['month1']=='7') ? 'Selected' : ''; ?>>Jul</OPTION>
			 <OPTION VALUE=8 <?php echo ($_POST['month1']=='8') ? 'Selected' : ''; ?>>Aug</OPTION>
			 <OPTION VALUE=9 <?php echo ($_POST['month1']=='9') ? 'Selected' : ''; ?>>Sep</OPTION>
			 <OPTION VALUE=10 <?php echo ($_POST['month1']=='10') ? 'Selected' : ''; ?>>Oct</OPTION>
			 <OPTION VALUE=11 <?php echo ($_POST['month1']=='11') ? 'Selected' : ''; ?>>Nov</OPTION>
			<OPTION VALUE=12 <?php echo ($_POST['month1']=='12') ? 'Selected' : ''; ?>>Dec</OPTION>
			</SELECT>
				<SELECT NAME=year1 id="tour_year1" style="font-family: Arial; color: #004646;font-size: 8pt">
				<OPTION id=2 value="--" selected> Year </option>
				<?php
                                $currentyear = date("Y");
				$i=1998;
				While($i<= $currentyear )
				{
                                    $id = $currentyear;
                                    $name = $currentyear;
                                    if ($_POST['year1'])
                                        $selected = ($_POST['year1']==$currentyear) ? 1 : 0;

                                    if ($selected)
                                    {
                                            echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."</OPTION>\n";
                                    }
                                    else
                                    {
                                            echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION>\n";
                                    }
                                    $currentyear--;
				}
				?> </SELECT>
			<SELECT NAME=month2 id="tour_month2" style="font-family: Arial; color: #004646;font-size: 8pt">
			 <OPTION id=3 value="--" selected> Month </option>
			 <OPTION VALUE=1 <?php echo ($_POST['month2']=='1') ? 'Selected' : ''; ?>>Jan</OPTION>
			 <OPTION VALUE=2 <?php echo ($_POST['month2']=='2') ? 'Selected' : ''; ?>>Feb</OPTION>
			 <OPTION VALUE=3 <?php echo ($_POST['month2']=='3') ? 'Selected' : ''; ?>>Mar</OPTION>
			 <OPTION VALUE=4 <?php echo ($_POST['month2']=='4') ? 'Selected' : ''; ?>>Apr</OPTION>
			 <OPTION VALUE=5 <?php echo ($_POST['month2']=='5') ? 'Selected' : ''; ?>>May</OPTION>
			 <OPTION VALUE=6 <?php echo ($_POST['month2']=='6') ? 'Selected' : ''; ?>>Jun</OPTION>
			 <OPTION VALUE=7 <?php echo ($_POST['month2']=='7') ? 'Selected' : ''; ?>>Jul</OPTION>
			 <OPTION VALUE=8 <?php echo ($_POST['month2']=='8') ? 'Selected' : ''; ?>>Aug</OPTION>
			 <OPTION VALUE=9 <?php echo ($_POST['month2']=='9') ? 'Selected' : ''; ?>>Sep</OPTION>
			 <OPTION VALUE=10 <?php echo ($_POST['month2']=='10') ? 'Selected' : ''; ?>>Oct</OPTION>
			 <OPTION VALUE=11 <?php echo ($_POST['month2']=='11') ? 'Selected' : ''; ?>>Nov</OPTION>
			 <OPTION VALUE=12 <?php echo ($_POST['month2']=='12') ? 'Selected' : ''; ?>>Dec</OPTION>
			</SELECT>
			<SELECT name=year2 id="tour_year2" style="font-family: Arial; color: #004646;font-size: 8pt">
			<OPTION id=4 value="--" selected> Year </option>

			<?php
                        $currentyear2 = date("Y");
			$endYear=1998;
			While($endYear<= $currentyear2 )
			{
				$ids=$currentyear2;
                                if ($_POST['year2'])
                                    $selected = ($_POST['year2']==$currentyear2) ? 1 : 0;
                                

                                if ($selected)
				{
					echo "<OPTION id=". $currentyear2. "value=". $currentyear2." selected>".$currentyear2."</OPTION>\n";
				}
				else
				{
					echo "<OPTION id=". $currentyear2. "value=". $currentyear2." >".$currentyear2."</OPTION>\n";
				}

			$currentyear2--;
			}
			?> 
                        </SELECT>
</li>
<li class="ui-widget" style="position: relative"><h4>City (OF TARGET COMPANY)</h4>
    <input type="hidden" id="cityauto" name="cityauto" value="<?php if($city!='') echo  $_POST['cityauto'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($city!='') echo "readonly='readonly'";  ?>>
    <input type="text" id="citysearch" <?php if($disable_flag == "1"){ echo "disabled"; } ?> name="citysearch" value="<?php if(isset($city)) echo  $city;  ?>" placeholder="" style="width:220px;">
     
    <!-- <span id="com_clearall" title="Clear All" onclick="clear_companysearch();" style="<?php if($_POST['citysearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span> -->
     
    <div id="cityauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
     
</li>
<li>
    <input type="button" <?php if($disable_flag == "1"){ echo "disabled"; } ?> class="fliter_stage" name="fliter_stage" value="Filter" onclick="this.form.submit();">
</li>
</ul>
       </div>
	</div>  

<?php  if($dealvalue  != 110){  ?>
    
    <h2 class="acc_trigger <?php if($showdealsbyflag==1){ ?> showdeal <?php } ?> "><a href="#">Show deals by</a></h2>
	<div  class="acc_container">
            <div class="block">
                <ul>
    
                <?php if($dealvalue  != 101 && $dealvalue  != 110){ ?>
    
                    <li class="ui-widget" style="position: relative" id="invMulti_autosuggest"><h4>Investor</h4>

                    <!-- <input type="text" id="investorauto" name="investorauto" value="<?php if($_POST['keywordsearch']!='') echo  $_POST['investorauto'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['keywordsearch']!='') echo "readonly='readonly'";  ?>>
                     <input type="hidden" id="keywordsearch_multiple" name="keywordsearch" value="<?php if(isset($_POST['keywordsearch'])) echo  $_POST['keywordsearch'];  ?>" placeholder="" style="width:220px;">-->

                     <input type="text"  id="investorauto_sug" name="investorauto_sug" value="<?php if($_POST['keywordsearch']!='') echo  $_POST['investorauto_sug'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['keywordsearch']!='') echo "readonly='readonly'";  ?>>
                     <input type="hidden" id="keywordsearch_multiple" name="keywordsearch" value="<?php if(isset($_POST['keywordsearch'])) echo  $_POST['keywordsearch'];  ?>" placeholder="" style="width:220px;">

                   <!--  <span id="inv_clearall" title="Clear All" onclick="clear_keywordsearch();" style="<?php if($_POST['keywordsearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>

                     <div id="investorauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">-->



                    </li>
                <?php }
                if($dealvalue != 102 && $dealvalue  != 110){ ?>
                    
                    <li class="ui-widget" style="position: relative"><h4>Angel-backed Co</h4>   
                    <!--    <input type="text" value="<?php echo $_POST['companysearch']?$_POST['companysearch']:''?>" name="company" id="company"  class=""  style="width:220px;"/>
                        <input type="hidden" name="companysearch" id="autocompany" value="" />	-->    

                        <input type="text" id="companyauto" name="companyauto" value="<?php if($_POST['companysearch']!='') echo  $_POST['companyauto'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['companysearch']!='') echo "readonly='readonly'";  ?>>
                         <input type="hidden" id="companysearch" name="companysearch" value="<?php if(isset($_POST['companysearch'])) echo $_POST['companysearch'];?>" placeholder="" style="width:220px;">

                        <span id="com_clearall" title="Clear All" onclick="clear_companysearch1();" style="<?php if($_POST['companysearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>

                        <div id="companyauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">

                        </div>
                    </li>
                    
                <?php } ?>
                    
                    <li>
                        <input name="reset" id="resetall" class="reset-btn" type="button" value="Reset" style="float: left;" />
                        <input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();" style="float: right;">
                    </li>
                </ul>
            </div>
        </div>
    <?php } ?>
<?php if($investorsug_response!=''){
	
           $prepopulate='prePopulate :  '.$investorsug_response;
       } ?>
   <script type="text/javascript" >
            
   $(document).ready(function(){ 
   
/*$("#investorauto_sug").tokenInput("ajaxInvestorDetails_auto.php?vcf=6", {
                   theme: "facebook",
                   minChars:2,
                   queryParam: "angel_q",
                   hintText: "",
                   noResultsText: "No Result Found",
                    preventDuplicates: true,
                     onAdd: function (item) {
                        clear_keywordsearch();
                        clear_companysearch();
                        disableFileds();
                },
                onDelete: function (item) {
                    var selectedValues = $('#investorauto_sug').tokenInput("get");
                    var inputCount = selectedValues.length;
                    if(inputCount==0){ 
                       enableFileds();
                    }
                },
                  <?php echo $prepopulate; ?>
                  
               });*/
      }); 
      
     
     function clear_keywordsearch(){
     $("#investorauto").removeAttr('readonly');  
     var val='';
     $("#investorauto, #keywordsearch_multiple").val(val); 
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

  function clear_companysearch1(){
     $("#companyauto").removeAttr('readonly');  
     val='';
     $("#companyauto,#companysearch").val(val); 
     $("#companyauto_load").fadeOut();
     $("#com_clearall").fadeOut(); 
     enableFileds();
} 
     
      
function disableFileds(){
    $("#industry").val('--');
    $("#industry").prop("disabled", true);    
    $("#followonVCFund").val('--');
    $("#followonVCFund").prop("disabled", true);
    $("#exitedstatus").val('--');
    $("#exitedstatus").prop("disabled", true);
    $("#txtregion").val('--');
    $("#txtregion").prop("disabled", true);
    $("#cityauto").val('');
    $("#citysearch").val('');
    $("#citysearch").prop("disabled", true);
    $(".fliter_stage").prop("disabled", true);
    $('#followonVCFund, #exitedstatus').attr('style', 'background-color: #dddddd !important');
    $('.selectgroup button').attr('style', 'width: 223px; background-color: #dddddd !important');
}
function enableFileds(){ 
    $("#industry").prop("disabled", false);
    $("#followonVCFund").prop("disabled", false);
    $("#exitedstatus").prop("disabled", false);
    $("#txtregion").prop("disabled", false);
    $("#citysearch").prop("disabled", false);
    $(".fliter_stage").prop("disabled", false);
    $('#followonVCFund, #exitedstatus').attr('style', 'background-color: #ffffff !important');
    $('.selectgroup button').attr('style', 'width: 223px; background-color: #ffffff !important');
}      
    
    $( "#searchallfield" ).keyup(function() {
            $("#industry").val('--');  
            $("#followonVCFund").val('--');
            $("#exitedstatus").val('--');
            $("#txtregion").val('--');
            $("#cityauto").val('');
            $("#citysearch").val('');  
            $("#investorauto_sug").val('');
            $("#companyauto").val('');
    });
     </script>
<?php } ?>	