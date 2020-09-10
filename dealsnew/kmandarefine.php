

<?php 	$currentyear = date("Y"); ?>
 <h3><a href="javascript:;" class="show_hide" rel="#searchTable">Refine Search</a></h3>
 <ul class="refine">
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
<li class="even"><h4>Deal Type</h4>
 <!--<label><input name="dealtype[]" type="checkbox" value="0" /> Equity</label> 
 <label><input name="dealtype[]" type="checkbox" value="1" /> Debt</label>  </li>-->
    
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

<li class="odd"><h4>Investor Type</h4>
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

        <?php $txtmultipleReturnFrom=$_POST['txtmultipleReturnFrom']? $_POST['txtmultipleReturnFrom']:"";
        $txtmultipleReturnTo=$_POST['txtmultipleReturnTo']? $_POST['txtmultipleReturnTo'] :"";
        ?>
        
<input type="text" name="txtmultipleReturnFrom" onkeypress="return isNumberKey(event)" value="<?php echo $txtmultipleReturnFrom ?>" size="12"> to
<input type=="text" name="txtmultipleReturnTo" value="<?php echo $txtmultipleReturnTo ?>" size="12"  onkeypress="return isNumberKey(event)" onblur="isless();">

</li>
    <li>
    	<input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();">
    </li>


</ul>
<div id="demo-with-image">
        <div class="showhide-link"><a rel="#slidingrefine" class="show_hide active" href="#"><i></i>SEARCH BY</a></div>
<ul class="refine content" id="slidingrefine" style="display:none;">

<li class="ui-widget"><h4>Investor</h4>
 <?php 
        $addVCFlagqry="";
        $searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);
        $getInvestorSql=  getallinvestors(3,$VCFlagValue);
        
      
?>
   <SELECT id="keywordsearch" NAME="investorsearch">
       <OPTION id="5" value=" " selected> ALL </option>
         <?php
         if ($rsinvestors = mysql_query($getInvestorSql))
		{
             While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
            {
                    $Investorname=trim($myrow["Investor"]);
                    $Investorname=strtolower($Investorname);

                    $invResult=substr_count($Investorname,$searchString);
                    $invResult1=substr_count($Investorname,$searchString1);
                    $invResult2=substr_count($Investorname,$searchString2);

                    if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                    {
                    $isselcted = (trim($_POST['investorsearch'])==trim($myrow["Investor"])) ? 'SELECTED' : '';
                    echo "<OPTION value='".$myrow["Investor"]."' ".$isselcted.">".$myrow["Investor"]."</OPTION> \n";
                    }
            }
                }	
        	
    ?>
</SELECT>
</li>
<li class="ui-widget"><h4>Acquirer</h4>
    <input type=text name="acquirersearch" style="width: 97%;">
    </li>
<li class="ui-widget"><h4>Company/Sector</h4>
    
  <select id="combobox" name="companysearch" >
		<OPTION value=" " selected>ALL</option>
		<?php
                        $searchString="Undisclosed";
                        $searchString=strtolower($searchString);

                        $searchString1="Unknown";
                        $searchString1=strtolower($searchString1);

                        $searchString2="Others";
                        $searchString2=strtolower($searchString2);
                            
                        $getcompaniesSql=  getallcompanies($companyFlag);
                        
			
                
                
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
<li class="ui-widget"><h4>Legal Advisor</h4>
<?php
	$advisorsql= getAllAdvisor("L",2,$VCFlagValue);
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
	

        $advisorsql= getAllAdvisor("T",2,$VCFlagValue);
	
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
</div>
<?php 

function getallinvestors($value0,$value1)
{

        $searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);
                if($value0==1)
		{
			if($value1==0)
			{
				$addVCFlagqry="";
				$pagetitle="PE Investors";
			}
			elseif($value1==1)
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

				//echo "<br>--" .$getInvestorSql;
		}

		if($value0==2)
		{
			if($value1==0)
			{
				$addVCFlagqry="";
				$pagetitle="PE Backed IPOs - Investors";
			}
			elseif($value1==1)
			{
				//$addVCFlagqry="";
				$addVCFlagqry = " and VCFlag=1 ";
				$pagetitle="VC Backed IPOs - Investors";
			}
			/*$getInvestorSql="select distinct peinv.InvestorId,inv.Investor
							from ipo_investors as peinv,ipos as pe,peinvestors as inv
							where peinv.IPOId=pe.IPOId and inv.InvestorId=peinv.InvestorId and
							pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
			echo "<Br>--" .$getInvestorSql;
	*/

			 $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND pec.industry !=15
				AND peinv.IPOId = pe.IPOId
				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
		}

		if($value0==3)
		{
			if($value1==0)
			{
				$addVCFlagqry="";
				$pagetitle="PE Exits M&A - Investors";
			}
			elseif($value1==1)
			{
				//$addVCFlagqry="";
				$addVCFlagqry = " and VCFlag=1 ";
				$pagetitle="VC Exits M&A - Investors";
			}
		/*	$getInvestorSql="select distinct peinv.InvestorId,inv.Investor
							from manda_investors as peinv,manda as pe,peinvestors as inv
							where peinv.MandAId=pe.MandAId and inv.InvestorId=peinv.InvestorId and
							pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
		*/
			$getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
							FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv
							WHERE pe.PECompanyId = pec.PEcompanyId
							AND pec.industry !=15
							AND peinv.MandAId = pe.MandAId
							AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";

		}
		if($value0==6)  //Angel investors
		{
		    if($value1==0)
		    {
			$addVCFlagqry="";
			$pagetitle="Angel Investments - Investors";
		    }
		    $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
		    FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
		    WHERE pe.InvesteeId = pec.PEcompanyId
		    AND pec.industry !=15
		    AND peinv.AngelDealId = pe.AngelDealId
		    AND inv.InvestorId = peinv.InvestorId
		    AND pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
		}
                if($value0==8)  //Social Venture Investments investors
		{
		    if($value1==3)
		    {
			$addVCFlagqry = "";
			$dbtype="SV";
			$pagetitle="Social Venture Investments - Investors";
		    }
              	    $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, 
                                stage AS s,peinvestments_dbtypes as pedb
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND s.StageId = pe.StageId
				AND pec.industry !=15
				AND peinv.PEId = pe.PEId
				AND inv.InvestorId = peinv.InvestorId  and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
		}
		 if($value0==9)  //CleanTech Investments investors
		{
		    if($value1==4)
		    {
			$addVCFlagqry = "";
			$dbtype="CT";
			$pagetitle="CleanTech Investments - Investors";
		    }
              	    $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, 
                                stage AS s,peinvestments_dbtypes as pedb
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND s.StageId = pe.StageId
				AND pec.industry !=15
				AND peinv.PEId = pe.PEId
				AND inv.InvestorId = peinv.InvestorId  and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
		}
		 if($value0==10)  //Social Venture Investments investors
		{
		    if($value1==5)
		    {
			$addVCFlagqry = "";
			$dbtype="IF";
			$pagetitle="Infrastructure Investments - Investors";
		    }
              	    $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, 
                                stage AS s,peinvestments_dbtypes as pedb
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND s.StageId = pe.StageId
				AND pec.industry !=15
				AND peinv.PEId = pe.PEId
				AND inv.InvestorId = peinv.InvestorId  and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
		}
                return $getInvestorSql;
    
}
function getallcompanies($value0)
{
    $searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);
	$addVCFlagqry="";
//0- pecompanies,1-vccompanies
        if($value0==0)
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
        elseif($value0==1)
        {
                $addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
                $pagetitle="VC-backed Companies";

                $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                                FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                                WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
                ORDER BY pec.companyname";
        }
        elseif($value0==2) // Incubatees
                {
                    $addVCFlagqry="";
                $pagetitle="Incubatee(s)";
                $getcompaniesSql="SELECT DISTINCT pe.IncubateeId, pec. *
                FROM pecompanies AS pec, incubatordeals AS pe,industry as i
                WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry
                 and pe.Deleted=0 and pec.industry!=15
                ORDER BY pec.companyname";
                }
        elseif($value0==3) //PE_ipos
        {
                $addVCFlagqry="";
                $pagetitle="PE-backed IPO Companies";

                $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                WHERE pec.PECompanyId = pe.PEcompanyId 
                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
                ORDER BY pec.companyname";
                //echo "<br>--" .$getcompaniesSql;
        }
        elseif($value0==4) //VC-ipos
        {
                $addVCFlagqry="and VCFlag=1";
                $pagetitle="VC-backed IPO Companies";

                $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                WHERE pec.PECompanyId = pe.PEcompanyId 
                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
                ORDER BY pec.companyname";
                //echo "<br>--" .$getcompaniesSql;
        }
        elseif($value0==5) //PE-EXits M&A Companies
        {
                $addVCFlagqry="";
                $pagetitle="PE-Exits M&A Companies";

                $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r
                WHERE pec.PECompanyId = pe.PEcompanyId 
                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
                ORDER BY pec.companyname";
                //echo "<br>--" .$getcompaniesSql;
        }
        elseif($value0==6) //VC-EXits M&A Companies
        {
            $addVCFlagqry="and VCFlag=1";
            $pagetitle="VC-Exits M&A Companies";

            $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
            FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r
            WHERE pec.PECompanyId = pe.PEcompanyId 
            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
            AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
            ORDER BY pec.companyname";
                //echo "<br>--" .$getcompaniesSql;
        }
        elseif($value0==7) //Angel Companies
        {
            $addVCFlagqry="";
            $pagetitle="Angel-backed Companies";
            $getcompaniesSql="SELECT DISTINCT pe.InvesteeId, pec. * , i.industry, r.Region
            FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r
            WHERE pec.PECompanyId = pe.InvesteeId 
            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
            AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
            ORDER BY pec.companyname";
        //	echo "<br>--" .$getcompaniesSql;

        }
        elseif($value0==8)     //social venture investment companies
        {
                $addVCFlagqry = " ";
                $pagetitle="SV-backed Companies";
                $dbtype="SV";

                $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                                FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                                stage AS s ,peinvestments_dbtypes as pedb
                                                WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                                and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
                ORDER BY pec.companyname";
                //echo"<BR>---" .$getcompaniesSql;
        }
        elseif($value0==9)     //cleantech investment companies
        {
                $addVCFlagqry = " ";
                $pagetitle="CleanTech-backed Companies";
                $dbtype="CT";

                $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                                FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                                stage AS s ,peinvestments_dbtypes as pedb
                                                WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                                and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
                ORDER BY pec.companyname";
                //echo"<BR>---" .$getcompaniesSql;
        }
        elseif($value0==10)     //Infrastructure investment companies
        {
                $addVCFlagqry = " ";
                $pagetitle="Infrastructure-backed Companies";
                $dbtype="IF";

                $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                                FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                                stage AS s ,peinvestments_dbtypes as pedb
                                                WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                                and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
                ORDER BY pec.companyname";
                //echo"<BR>---" .$getcompaniesSql;
        }
        return $getcompaniesSql;
}

?>

<?php function getAllAdvisor($adtype,$peorvcflg,$VCFlagValue) 
    {
                if($adtype=="L")
		{  
                    $adtitledisplay ="Legal";
                }
		elseif($adtype=="T")
                {  
                    $adtitledisplay="Transaction";
                }
                
                $addVCFlagqry="";
		//0- peinvestors,1-vcinvestors in the second parameter
 	    if($peorvcflg==1) //investment page
		{
			if($VCFlagValue==0)
			{
				$addVCFlagqry="";
				$pagetitle="PE Advisors - ".$adtitledisplay;
			}
			elseif($VCFlagValue==1)
			{
				//$addVCFlagqry="";
				$addVCFlagqry = "and s.VCview=1 and peinv.amount<=20 ";
				$pagetitle="VC Advisors - ".$adtitledisplay;
			}
			$advisorsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId
				AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId
				AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId ) order by Cianame	";
			//echo "<Br>PE - VC---" .$advisorsql;
		}

		if($peorvcflg==2) //manda
		{
			if($VCFlagValue==0)
			{
				$addVCFlagqry="";
				$pagetitle="PE Exits M&A - Advisors - ".$adtitledisplay;
			}
			elseif($VCFlagValue==1)
			{
				//$addVCFlagqry="";
				$addVCFlagqry = " and VCFlag=1 ";
				$pagetitle="VC Exits M&A - Advisors - ".$adtitledisplay;
			}
			$advisorsql="(SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
					FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac
					WHERE Deleted =0
					AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID  and AdvisorType='".$adtype ."'
					AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
					" )
					UNION (
					SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
					FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp, acquirers AS ac
					WHERE Deleted =0
					AND c.PECompanyId = peinv.PECompanyId
					AND adcomp.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
					AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
					" )	ORDER BY Cianame";
			//echo "<Br>M&A---" .$advisorsql;
                        }
                	if($peorvcflg==3) //social /cleantech / infrastructure investment page
		        {
        			if($VCFlagValue==3)
        			{
        				//$addVCFlagqry="";
        				$addVCFlagqry = "";
        				$pagetitle="Social Venture Investments-Advisors - ".$adtitledisplay;
        				$dbtype="SV";
        			}
        			elseif($VCFlagValue==4)
        			{
        				//$addVCFlagqry="";
        				$addVCFlagqry = "";
        				$pagetitle="CleanTech Investments-Advisors - ".$adtitledisplay;
        				$dbtype="CT";
        			}
        			elseif($VCFlagValue==5)
        			{
        				//$addVCFlagqry="";
        				$addVCFlagqry = "";
        				$pagetitle="Infrastructure Investments-Advisors - ".$adtitledisplay;
        				$dbtype="IF";
        			}
        			$advisorsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID  and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId ) order by Cianame";
			//echo "<Br>PE - VC---" .$advisorsql;
		      }
                // echo "<bR>--" .$peorvcflag[1];
		 if($peorvcflg==4) //mama
		{
			if($VCFlagValue==1)
			{
				$addVCFlagqry="";
				$pagetitle="M&A - Advisors - ".$adtitledisplay;
			}

			$advisorsql="(
					SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
					FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisoracquirer AS adac
					WHERE Deleted =0
					AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
					AND adac.MAMAId = peinv.MAMAId " .$addVCFlagqry.
					" )
					UNION (
					SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
					FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisorcompanies AS adcomp, acquirers AS ac
					WHERE Deleted =0
					AND c.PECompanyId = peinv.PECompanyId
					AND adcomp.CIAId = cia.CIAID  and AdvisorType='".$adtype ."'
					AND adcomp.MAMAId = peinv.MAMAId " .$addVCFlagqry.
					" )	ORDER BY Cianame";
			//echo "<Br>M&A---" .$advisorsql;
		}
                
                return $advisorsql;
    
    }
?>