

<?php 	$currentyear = date("Y"); ?>
 <h3><a href="javascript:;" class="show_hide" rel="#searchTable">Refine Search</a></h3>

<ul class="refine">
<li class="even"><h4>Industry</h4>

  

	<select name="industry" onchange="this.form.submit();">
		<OPTION id=0 value="--" selected> Select an Industry </option>
		<?php
                    $industrysql_search="select industryid,industry from industry where industryid !=15 " . $hideIndustry ." order by industry";
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
                                    $isselected = ($_POST['industry']==$id) ? 'SELECTED' : '';
                                    echo "<OPTION id=".$id. " value=".$id." ".$isselected.">".$name."</OPTION> \n";
                            }
                            mysql_free_result($industryrs);
                    }
                
                
                
    	?>
    </select>


</li>
    
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
    
<li class="even"><h4>Investor Sale in IPO?</h4>
                 <?php $invSale=$_POST["invSale"]; ?>
                  <SELECT NAME="invSale"  onchange="this.form.submit();">
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
                <SELECT NAME="exitstatus" onchange="this.form.submit();">
                    <OPTION  value="--" selected> Both </option>
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
  
<!--li class="odd"><h4>Firm Type</h4>
    <SELECT NAME="txtfirmtype" onchange="this.form.submit();">
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
								 echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
							}
						 mysql_free_result($incfirmrs);
						}
					?>
						 </SELECT>
                
</li-->
</ul>

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
         if($VCFlagValue==0)
        {
                $addVCFlagqry="";
        }
        elseif($VCFlagValue==1)
        {
                //$addVCFlagqry="";
                $addVCFlagqry = " and VCFlag=1 ";
        }
        $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
                FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
                WHERE pe.PECompanyId = pec.PEcompanyId
                AND pec.industry !=15
                AND peinv.IPOId = pe.IPOId
                AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
        
      
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

<li class="ui-widget"><h4>Company</h4>
    
  <select id="combobox" name="companysearch" >
		<OPTION value=" " selected>ALL</option>
		<?php
                        $searchString="Undisclosed";
                        $searchString=strtolower($searchString);

                        $searchString1="Unknown";
                        $searchString1=strtolower($searchString1);

                        $searchString2="Others";
                        $searchString2=strtolower($searchString2);
                            
                        if($VCFlagValue==0) //PE_ipos
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
			elseif($VCFlagValue==1) //VC-ipos
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






    <li>
    	<input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();">
    </li>
</ul>
