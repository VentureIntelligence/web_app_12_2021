
<SCRIPT LANGUAGE="JavaScript">
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
</SCRIPT>

<h3>Refine Search</h3>

<ul class="refine">
<li class="odd"><h4>Industry Type</h4>
<SELECT name="industry" onchange="this.form.submit();">
  		<OPTION id=0 value="--" selected> ALL  </option>
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
						echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
					}
				 	mysql_free_result($industryrs);
				}
    		?>
</SELECT></li>
<?php  if($hide_pms==0)
 {
 
echo "select DealTypeId,DealType from dealtypes where hide_for_exit=".$hide_pms;
?>
<li class="even"><h4>Deal Type</h4>

 <SELECT NAME="dealtype" onchange="this.form.submit();">
     <OPTION id=1 value="--" selected> ALL  </option>
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
                        echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
                }
         mysql_free_result($rsdealtype);
}
?>
</SELECT></li>
<?php
  }?>
<li class="odd"><h4>Investor Type</h4>
    
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
					$isselcted = ($_POST['invType']==$id) ? 'SELECTED' : "";
                 	echo "<OPTION id=".$id. " value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
            	}
         		mysql_free_result($invtypers);
        	}
    ?>
</SELECT></li>
 <!--<label><input name="investor" type="checkbox" value="" /> Foreign</label> 
 <label><input name="investor" type="checkbox" value="" /> India</label> 
 <label><input name="investor" type="checkbox" value="" /> Investment</label></li>-->
<li class="even"><h4>Exit Status</h4>
    
<SELECT NAME="exitstatus" onchange="this.form.submit();" >
<OPTION  value="--" selected> Select </option>
<OPTION  value="0"> Partial </option>
<OPTION  value="1"> Complete </option>
</SELECT> 
</li>
<li class="odd"><h4>Return Multiple </h4>
From <input type"text" name="txtmultipleReturnFrom" onkeypress="return isNumberKey(event)" value="" size=9 > &nbsp; To
     <input type"text" name="txtmultipleReturnTo" value="" size=9 onkeypress="return isNumberKey(event)">
</li>
<li class="even period-to"><h4>Period</h4>
<div class="label-range">
<h5>From</h5>
<SELECT NAME="month1">
     <OPTION id=1 value="--"> Month </option>
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

<SELECT NAME="year1">
    <OPTION id=2 value="--"> Year </option>
    <?php 
		$yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates asc";
		if($yearSql=mysql_query($yearsql))
		{
			While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$id = $myrow["Year"];
				$name = $myrow["Year"];
				$isselected = ($year1==$id) ? 'SELECTED' : '';
				echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
			}		
		}
	?> 
</SELECT>
</div>
<div class="label-range pr0">
<h5>To</h5>
<SELECT NAME="month2">
      <OPTION id=1 value="--"> Month </option>
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

<SELECT NAME="year2" onchange="this.form.submit();">
    <OPTION id=2 value="--"> Year </option>
    <?php 
		$yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates asc";
		if($yearSql=mysql_query($yearsql))
		{
			While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$id = $myrow["Year"];
				$name = $myrow["Year"];
				$isselcted = ($year2== $id) ? 'SELECTED' : '';
				echo "<OPTION id=". $id. " value='". $id."' ".$isselcted.">".$name."</OPTION>\n";
			}		
		}
	?> 
</SELECT>
</div>


</li>


<h3>Show deals by</h3>
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
			
            $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor,pec.sector_business
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
<li class="ui-widget"><h4>Acquirer</h4>
   <input type=text name="acquirersearch" size=31>
</li>
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
	
					if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
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
    <li>
    	<input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();">
    </li>
</ul>