<?php 
 require_once("../dbconnectvi.php");
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
    $( "#investorauto" ).autocomplete({
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
       $('#companysearch').val(ui.item.value);
//       $('#form').submit();
      },
      open: function() {
//        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
          if(  $('#keywordsearch').val()=="")
             $( "#investorauto" ).val('');  
//        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    });
    
    
    
    
    
    
    
    
    
      $( "#companyauto" ).autocomplete({
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
//       $('#form').submit();
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
    
    
    
    
    $( "#sectorauto" ).autocomplete({
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
//       $('#form').submit();
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
    
  });
  </script>



<?php $showdealsbyflag=0;
if($keyword!="" || $companysearch!="" || $sectorsearch!="" || $advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
{ 
    $showdealsbyflag=1; }  ?>

<h2 class="acc_trigger">
    <a href="#">Refine Search</a></h2>
<div class="acc_container" >
		<div class="block">
			<ul >
<li class="even"><h4>Industry</h4>

  

	<select name="industry" onchange="this.form.submit();">
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
                                        if($_POST['industry']!='')
                                        {
                                            $isselected = ($_POST['industry']==$id) ? 'SELECTED' : '';
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
    	?>
    </select>


</li>


<li class="odd"><h4>Stage
 <span ><a href="#popup2" class="help-icon1 tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
    <span>
    <img class="callout1" src="images/callout.gif">
    Definitions
    </span>
     </a></span></h4>
<div class="selectgroup">
   
<select name="stage[]" multiple="multiple" size="5" id='stage'>
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
                        if($_POST['industry']!='')
                        {
			for($i=0;$i<count($_POST['stage']);$i++){
				$isselect = ($_POST['stage'][$i]==$id) ? "SELECTED" : $isselect;
			}
			echo '<OPTION value="'.$id.'" '.$isselect.'>'.$name.'</OPTION> \n';
                        }
                        else
                        {
                             $isselected = ($getstage==$name) ? 'SELECTED' : '';
                            echo "<OPTION id=".$id. " value=".$id." ".$isselected.">".$name."</OPTION> \n";
                        }
		}
		 mysql_free_result($stagers);
	}
	
 ?>
</select> </div>
    
<input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();">
 
</li>		

<li class="odd"><h4>Company Type</h4>
<!-- <label><input name="comptype[]" type="checkbox" value="L" />  Listed</label> 
 <label><input name="comptype[]" type="checkbox" value="U" /> Un-Listed</label>  -->

 <SELECT NAME="comptype" onchange="this.form.submit();" id="comptype">
    <OPTION  value="--" selected> Both </option>
    <OPTION value="L" <?php echo ($_POST['comptype']=="L") ? 'SELECTED' : ""; ?>> Listed </option>
    <OPTION  value="U" <?php echo ($_POST['comptype']=="U") ? 'SELECTED' : ""; ?>> Unlisted </option>
</SELECT>


<li class="even"><h4>Deal Type</h4>
 <!--<label><input name="dealtype[]" type="checkbox" value="0" /> Equity</label> 
 <label><input name="dealtype[]" type="checkbox" value="1" /> Debt</label>  </li>-->
  
 <SELECT NAME="dealtype_debtequity" onchange="this.form.submit();">
    <OPTION  value="--" selected>Equity & Debt</option>
    <OPTION value="0" <?php echo ($_POST['dealtype_debtequity']=="0") ? 'SELECTED' : ""; ?>>Equity Only</option>
    <OPTION  value="1" <?php echo ($_POST['dealtype_debtequity']=="1") ? 'SELECTED' : ""; ?>>Debt Only</option>
</SELECT>
<!--<input type="radio" value="--" name="dealtype_debtequity" checked >Equity & Debt
			  <input type="radio" value="0" name="dealtype_debtequity" >Equity Only
                          <input type="radio" value="1" name="dealtype_debtequity" >Debt Only-->


<li class="odd"><h4>Region</h4>
<SELECT NAME="txtregion" onchange="this.form.submit();">
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
                 if($_POST['txtregion']!='')
                  {
                        $isselcted = ($_POST['txtregion']==$id) ? 'SELECTED' : "";
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
<li class="even"><h4>Investor Type
    <span ><a href="#popup3" class="help-icon1 tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
        <span>
        <img class="callout1" src="images/callout.gif">
        Definitions
        </span>
     </a></span></h4>
<SELECT NAME="invType" onchange="this.form.submit();">
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
                        if($_POST['txtregion']!='')
                        {
                              $isselcted = ($_POST['invType']==$id) ? 'SELECTED' : "";
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

<SELECT name="invrangestart"><OPTION id=4 value="--" selected>ALL  </option>
	<?php
        $counter=0;
            if($VCFlagValue==0 )
            {
                for ( $counter = 0; $counter <= 1000; $counter += 5){
                    
                    if($_POST['invrangestart']!='')
                    {
			$isselcted = (($_POST['invrangestart']==$counter."")) ? 'SELECTED' : "";             
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
                        if($_POST['invrangestart']!='')
                        {
                            $isselcted = (($_POST['invrangestart']==$counter."")) ? 'SELECTED' : "";             
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
<SELECT name="invrangeend" onchange="this.form.submit();"><OPTION id=5 value="--" selected>ALL  </option>
	<?php
        $counter=0;
            if($VCFlagValue==0 )
            {
                for ( $counterto = 5; $counterto <= 2000; $counterto += 5){
                    
                    if($_POST['invrangeend']!='')
                    {
			$isselcted = (($_POST['invrangeend']==$counterto."")) ? 'SELECTED' : "";             
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
                for ( $counterto = 1; $counterto <= 20; $counterto += 1){
                        if($_POST['invrangeend']!='')
                        {
                            $isselcted = (($_POST['invrangeend']==$counterto."")) ? 'SELECTED' : "";             
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
<li>
<input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();">
</li>

</ul></div>
	</div>
	
	<h2 class="acc_trigger <?php if($showdealsbyflag==1){ ?> showdeal <?php } ?>"><a href="#">Show deals by</a></h2>
	<div  class="acc_container " style="display: none;">
		<div class="block">
<ul >
<li class="ui-widget"><h4>Investor</h4>
    <input type="text" id="investorauto" name="investorauto" value="<?php if(isset($_POST['keywordsearch'])) echo  $_POST['keywordsearch'];  ?>" placeholder="">
     <input type="hidden" id="keywordsearch" name="keywordsearch" value="<?php if(isset($_POST['keywordsearch'])) echo  $_POST['keywordsearch'];  ?>" placeholder="">
</li>
<li class="ui-widget"><h4>Company</h4>
    <input type="text" id="companyauto" name="companyauto" value="<?php if(isset($_POST['companysearch'])) echo  $_POST['companysearch'];  ?>" placeholder="">
     <input type="hidden" id="companysearch" name="companysearch" value="<?php if(isset($_POST['companysearch'])) echo  $_POST['companysearch'];  ?>" placeholder="">
</li>
<li class="ui-widget"><h4>Sector</h4>
    <input type="text" id="sectorauto" name="sectorauto" value="<?php if(isset($_POST['sectorsearch'])) echo  $_POST['sectorsearch'];  ?>" placeholder="">
     <input type="hidden" id="sectorsearch" name="sectorsearch" value="<?php if(isset($_POST['sectorsearch'])) echo  $_POST['sectorsearch'];  ?>" placeholder="">
</li>

<li class="ui-widget"><h4>Legal Advisor</h4>
<?php
	$advisorsql="(
	SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
	FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
	peinvestments_advisorinvestors AS adac, stage as s
	WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
	" AND c.PECompanyId = peinv.PECompanyId
	AND adac.CIAId = cia.CIAID and AdvisorType='L'
	AND adac.PEId = peinv.PEId)
	UNION (
	SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
	FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
	peinvestments_advisorcompanies AS adac, stage as s
	WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
	" AND c.PECompanyId = peinv.PECompanyId
	AND adac.CIAId = cia.CIAID and AdvisorType='L'
	AND adac.PEId = peinv.PEId ) order by Cianame	";
	
	if ($rsadvisor = mysql_query($advisorsql)){
		$advisor_cnt = mysql_num_rows($rsadvisor);
	}

?>
	<SELECT id="advisorsearch_legal" NAME="advisorsearch_legal">
       <OPTION id="5" value=" " selected> ALL </option>
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
						$isselcted = (trim($_POST['advisorsearch_legal'])==trim($ladvisor)) ? 'SELECTED' : '';
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
	$advisorsql="(
	SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
	FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
	peinvestments_advisorinvestors AS adac, stage as s
	WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
	" AND c.PECompanyId = peinv.PECompanyId
	AND adac.CIAId = cia.CIAID and AdvisorType='T'
	AND adac.PEId = peinv.PEId)
	UNION (
	SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
	FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
	peinvestments_advisorcompanies AS adac, stage as s
	WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
	" AND c.PECompanyId = peinv.PECompanyId
	AND adac.CIAId = cia.CIAID and AdvisorType='T'
	AND adac.PEId = peinv.PEId ) order by Cianame	";
	
	if ($rsadvisor = mysql_query($advisorsql)){
		$advisor_cnt = mysql_num_rows($rsadvisor);
	}

?>
	<SELECT id="advisorsearch_trans" NAME="advisorsearch_trans">
       <OPTION id="5" value=" " selected> ALL </option>
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
						$isselcted = (trim($_POST['advisorsearch_trans'])==trim($ladvisor)) ? 'SELECTED' : '';
						echo "<OPTION value='".$ladvisor."' ".$isselcted.">".$ladvisor."</OPTION> \n";
					}
            	}
         		mysql_free_result($rsadvisor);
        	}
    ?>
	</SELECT>
    </li>
    <li><input name="reset" id="resetall" class="refine reset-btn" type="button" value="Reset" style="float: left;" />
        <input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();" style="float: right;">
    </li>
    
</ul></div>
	</div>
  <?php } ?>



