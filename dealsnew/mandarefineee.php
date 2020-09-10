<script>
 // Company
 $(function() {
   
   $( "#asinvestorsearch" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
            type: "POST",
            url: "autosuggestmanda.php",
            dataType: "json",
          data: {
            queryString: request.term,
            searchopt: 'investor',
            VCFlagValue: <?php echo $vcflagValue; ?>
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.investor,
                value: item.investor,
                 id: item.investor
              };
            }));
          }
        });
      },
      minLength: 2
      
    });
    
   $( "#ascompanysearch" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
            type: "POST",
            url: "autosuggestmanda.php",
            dataType: "json",
          data: {
            queryString: request.term,
            searchopt: 'company',
            companyFlag: '<?php echo $companyFlag; ?>'
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
      minLength: 1
      
    }); 
    
    $( "#assectorsearch" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
            type: "POST",
            url: "autosuggestmanda.php",
            dataType: "json",
          data: {
            queryString: request.term,
            searchopt: 'sector'
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.sectorName,
                value: item.sectorName,
                 id: item.sectorName
              }
            }));
          }
        });
      },
      minLength: 1
      
    }); 
    
    $( "#asadvisorsearch_legal" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
            type: "POST",
            url: "autosuggestmanda.php",
            dataType: "json",
          data: {
            queryString: request.term,
            searchopt: 'lgadvisor',
            VCFlagValue: <?php echo $vcflagValue; ?>
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.ladvisor,
                value: item.ladvisor,
                 id: item.ladvisor
              }
            }));
          }
        });
      },
      minLength: 1
      
    }); 
    
    
    $( "#asadvisorsearch_trans" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
            type: "POST",
            url: "autosuggestmanda.php",
            dataType: "json",
          data: {
            queryString: request.term,
            searchopt: 'trsadvisor',
            VCFlagValue: <?php echo $vcflagValue; ?>
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.tadvisor,
                value: item.tadvisor,
                 id: item.tadvisor
              }
            }));
          }
        });
      },
      minLength: 1
      
    }); 
    
     
  });
 </script>
<?php 
      $showdealsbyflag=0;
    if(($advisorsearchstring_legal!=" " && $advisorsearchstring_legal!="")  || ($advisorsearchstring_trans!=" " && $advisorsearchstring_trans!="") || ($companysearch!=" " && $companysearch!="") || 
        ($investorsearch!=" " && $investorsearch!="") || ($sectorrsearch!=" " && $sectorsearch!="")){
        $showdealsbyflag=1; 
    } ?>

<h2 class="acc_trigger"><a href="#">Refine Search</a></h2>
	<div class="acc_container">
		<div class="block">
			<ul >
 <li class="even"><h4>Industry</h4>

  

	<select name="industry" onchange="this.form.submit();">
		<OPTION id=0 value="--" selected> Select an Industry </option>
		<?php
			 $industrysql="select industryid,industry from industry where industryid !=15  " . $hideIndustry ." order by industry";
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
                                    $isselected = ($_POST['industry']==$id) ? 'SELECTED' : '';
                                    echo "<OPTION id=".$id. " value=".$id." ".$isselected.">".$name."</OPTION> \n";
                            }
				 	mysql_free_result($industryrs);
				}
    		?>
    </select>


</li>

<?php  if($hide_pms==0)
                  { ?>
<li class="even"><h4>Deal Type
      <span ><a href="#popup5" class="help-icon1 tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
                                             <span>
                                             <img class="callout1" src="images/callout.gif">
                                             Definitions
                                             </span>
     </a></span></h4>
    
    <SELECT name="dealtype" onchange="this.form.submit();">
	  				<OPTION id=1 value="--" selected>ALL </option>
				<?php
	 				$dealtypesql = "select DealTypeId,DealType from dealtypes where hide_for_exit=".$hide_pms;
						if ($rsdealtype = mysql_query($dealtypesql))
						{
						  $stage_cnt = mysql_num_rows($rsdealtype);
						}
						if($stage_cnt > 0)
					  	 {
							 While($myrow=mysql_fetch_array($rsdealtype, MYSQL_BOTH))
							{
								$id = $myrow[0];
								$name = $myrow[1];
                                                                $isselcted = ($id==$_POST['dealtype']) ? 'SELECTED' : '';
								echo "<OPTION id=".$id. " value=".$id." ".$isselcted.">".$name."</OPTION> \n";
							}
						 mysql_free_result($rsdealtype);
	    		}
		    ?></select>
</li>
                  <?php } ?>

<li class="odd"><h4>Investor Type<span ><a href="#popup3" class="help-icon1 tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
                                             <span>
                                             <img class="callout1" src="images/callout.gif">
                                             Definitions
                                             </span>
     </a></span></h4>
                <SELECT NAME="invType" onchange="this.form.submit();">
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
    


<li class="odd"><h4>Exit Status</h4>
    <?php $exitstatus=$_POST["exitstatus"]; ?>
                <SELECT NAME="exitstatus" onchange="this.form.submit();">
                    <OPTION  value="--" selected> Select </option>
                    <OPTION  value="0" <?php if($exitstatus=="0") echo "selected" ?>> Partial </option>
                    <OPTION  value="1" <?php if($exitstatus=="1") echo "selected" ?>> Complete </option>
                </SELECT>
</li>

    <li class="odd range-to"><h4>Return Multiple</h4>

        <?php $txtmultipleReturnFrom=($_POST['txtmultipleReturnFrom']!="")? $_POST['txtmultipleReturnFrom']:"";
        $txtmultipleReturnTo=($_POST['txtmultipleReturnTo']!="")? $_POST['txtmultipleReturnTo'] :"";
        ?>
        
<input type="text" name="txtmultipleReturnFrom" onkeypress="return isNumberKey(event)" value="<?php echo $txtmultipleReturnFrom ?>" size="11"> to
<input type=="text" name="txtmultipleReturnTo" value="<?php echo $txtmultipleReturnTo ?>" size="11"  onkeypress="return isNumberKey(event)" onblur="isless();">

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
    <input type="text" value="<?php echo $_POST['investorsearch']; ?>" name="investorsearch" id="asinvestorsearch"  class=""  autocomplete=off  style="width:220px;"/>
</li>
<li class="ui-widget"><h4>Acquirer</h4>
    <input type=text name="acquirersearch" id="acquirersearch" style="width: 97%;">
    </li>
<li class="ui-widget"><h4>Company</h4>
    <input type="text" value="<?php echo $_POST['companysearch']; ?>" name="companysearch" id="ascompanysearch"  class=""  autocomplete=off  style="width:220px;"/>
</li>

<li class="ui-widget"><h4>Sector</h4>
    <input type="text" value="<?php echo $_POST['sectorsearch']; ?>" name="sectorsearch" id="assectorsearch"  class=""  autocomplete=off  style="width:220px;"/>	
</li>
<li class="ui-widget"><h4>Legal Advisor</h4>
    <input type="text" value="<?php echo $_POST['advisorsearch_legal']; ?>" name="advisorsearch_legal" id="asadvisorsearch_legal"  class=""  autocomplete=off  style="width:220px;"/>
</li>
<li class="ui-widget"><h4>Transaction Advisor</h4>
    <input type="text" value="<?php echo $_POST['advisorsearch_trans']; ?>" name="advisorsearch_trans" id="asadvisorsearch_trans"  class=""  autocomplete=off  style="width:220px;"/>
</li>




    <li>
        <input name="reset" id="resetall" class="reset-btn" type="button" value="Reset" style="float: left;" />
        <input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();" style="float: right;">
    </li>
</ul>
</div>
        </div>

<!--div  class="acc_container " style="display: none;">
		<div class="block">
<ul >
<li class="ui-widget"><h4>Investor</h4>
<SELECT id="keywordsearch" NAME="keywordsearch">
       <OPTION id="5" value=" " selected> ALL </option>
         <?php
            /* populating the investortype from the investortype table */
			$searchString="Undisclosed";
			$searchString=strtolower($searchString);
		
			$searchString1="Unknown";
			$searchString1=strtolower($searchString1);
		
			$searchString2="Others";
			$searchString2=strtolower($searchString2);
			$addVCFlagqry="";
                        if($VCFlagValue==0)
			{
				$addVCFlagqry="";
				$pagetitle="PE Investors";
			}
			elseif($VCFlagValue==1)
			{
				//$addVCFlagqry="";
				$addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
				$pagetitle="VC Investors";
			}
			/*$getInvestorSql="select distinct peinv.InvestorId,inv.Investor
							from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv
							where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
							pe.StageId=s.StageId and
							pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
			*/

				$getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, stage AS s
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND s.StageId = pe.StageId
				AND pec.industry !=15
				AND peinv.PEId = pe.PEId
				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
                        
         
				
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
					
					if(($invResult==0) && ($invResult1==0) && ($invResult2==0)){
						$investor = $myrow["Investor"];
						$investorId = $myrow["InvestorId"];
						//echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
						$isselcted = (trim($_POST['keywordsearch'])==trim($investor)) ? 'SELECTED' : '';
						echo "<OPTION value='".$investor."' ".$isselcted.">".$investor."</OPTION> \n";
					}
            	}
         		mysql_free_result($invtypers);
        	}
    ?>
</SELECT>
</li>
                        <?php $addVCFlagqry="";
                        //0- pecompanies,1-vccompanies
			if($VCFlagValue==0)
			{
				$addVCFlagqry="";
				$pagetitle="PE-backed Companies";

				$getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
								FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
								WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
								AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
								AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
				ORDER BY pec.companyname";

			}
			elseif($VCFlagValue==1)
			{
				$addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
				$pagetitle="VC-backed Companies";

				$getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
								FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
								WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
								AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
								AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
				ORDER BY pec.companyname";
			} ?>
<li class="ui-widget"><h4>Company</h4>
<select id="combobox" name="companysearch" >
		<OPTION value=" " selected>ALL</option>
		<?php
			if ($rsinvestors = mysql_query($getcompaniesSql))
			{
				While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
				{
					$companyname=trim($myrow["companyname"]);
					$companyname=strtolower($companyname);
	
					$invResult=substr_count($companyname,$searchString);
					$invResult1=substr_count($companyname,$searchString1);
					$invResult2=substr_count($companyname,$searchString2);
	
					if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
					{
						$compName = $myrow["companyname"];
						$isselected = (trim($_POST['companysearch'])==trim($compName)) ? 'SELECTED' : '';
						echo '<OPTION value="'.$compName.'" '.$isselected.'>'.$compName.'</OPTION> \n';
				 		//$totalCount=$totalCount+1;
					}
	
				}
			}
    	?>
   </select>	
</li>
<?php $addVCFlagqry="";
                        //0- pecompanies,1-vccompanies
			if($VCFlagValue==0)
			{
				$addVCFlagqry="";
				$pagetitle="PE-backed Companies";

				 $getcompaniesSql="SELECT DISTINCT pec.sector_business
								FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
								WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
								AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
								AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
				ORDER BY pec.sector_business";

			}
			elseif($VCFlagValue==1)
			{
				$addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
				$pagetitle="VC-backed Companies";

				$getcompaniesSql="SELECT DISTINCT pec.sector_business FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
								WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
								AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
								AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
				ORDER BY pec.sector_business";
			} ?>
<li class="ui-widget"><h4>Sector</h4>
<select id="sectorsearch" NAME="sectorsearch" >
		<OPTION value=' ' selected>ALL</option>
		<?php
			if ($rssector = mysql_query($getcompaniesSql))
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
						$sectorName = $myrow["sector_business"];
						$isselected = (trim($_POST['sectorsearch']) == trim($sectorName)) ? 'SELECTED' : ' ';
						echo '<OPTION value='.$sectorName.' '.$isselected.'>'.$sectorName.'</OPTION> \n';
				 		//$totalCount=$totalCount+1;
					}
				}
			}
    	?>
   </select>	
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
	</div-->