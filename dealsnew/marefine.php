<?php include_once("../globalconfig.php"); require_once("../dbconnectvi.php");
$Db = new dbInvestments();
if(!isset($_SESSION['UserNames']))
{
        header('Location:../pelogin.php');
}
else
{?>
<?php /*$showdealsbyflag=0;
if($keyword!="" || $companysearch!="" || $sectorsearch!="" || $advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
{ 
    $showdealsbyflag=1; 
    
}  */?>




<h2 class="acc_trigger">
    <a href="#">Refine Search</a></h2>
<div class="acc_container" >
		<div class="block">
			<ul >
<li class="even"><h4>Industry</h4>

	<select name="industry" onchange="this.form.submit();">
		<OPTION id=0 value="--" selected> Select an Industry </option>
		<?php
                 $industrysql="select industryid,industry from industry where industryid !=15 " . $hideIndustry ." order by industry";
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
<li class="even"><h4>Deal Type</h4>
 <!--<label><input name="dealtype[]" type="checkbox" value="0" /> Equity</label> 
 <label><input name="dealtype[]" type="checkbox" value="1" /> Debt</label>  </li>-->
  
 <SELECT NAME="dealtype" onchange="this.form.submit();">
    <OPTION  value="--" selected>ALL</option>
    <?php
        /* populating the madealtypes from the madealtypes table */
        $invtypesql = "select MADealTypeId,MADealType from madealtypes order by MADealTypeId ";
        if ($invtypers = mysql_query($invtypesql))
        {
             $invtype_cnt = mysql_num_rows($invtypers);
        }
        if($invtype_cnt > 0)
        {
            While($myrow=mysql_fetch_array($invtypers, MYSQL_BOTH))
           {
                   $id = $myrow["MADealTypeId"];
                   $name = $myrow["MADealType"];
                    if($_POST['dealtype']!='')
                    {
                        $isselected = ($_POST['dealtype']==$id) ? 'SELECTED' : '';
                        echo "<OPTION id=".$id. " value=".$id." ".$isselected.">".$name."</OPTION> \n";
                    }
                  /*  else
                    {
                        $isselected = ($getindus==$name) ? 'SELECTED' : '';
                        echo "<OPTION id=".$id. " value=".$id." ".$isselected.">".$name."</OPTION> \n";
                    }
                    echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";*/
           }
           mysql_free_result($invtypers);
        }
?>
</SELECT>
</li>

<li class="odd"><h4>Target Company Type</h4>

 <SELECT NAME="targetcompanytype" onchange="this.form.submit();" id="comptype">
    <OPTION  value="--" selected> Both </option>
    <OPTION value="L" <?php echo ($_POST['targetcompanytype']=="L") ? 'SELECTED' : ""; ?>> Listed </option>
    <OPTION  value="U" <?php echo ($_POST['targetcompanytype']=="U") ? 'SELECTED' : ""; ?>> Unlisted </option>
</SELECT>

</li>
<li class="odd"><h4>Acquirer Company Type</h4>

 <SELECT NAME="acquirercompanytype" onchange="this.form.submit();" id="comptype">
    <OPTION  value="--" selected> Both </option>
    <OPTION value="L" <?php echo ($_POST['acquirercompanytype']=="L") ? 'SELECTED' : ""; ?>> Listed </option>
    <OPTION  value="U" <?php echo ($_POST['acquirercompanytype']=="U") ? 'SELECTED' : ""; ?>> Unlisted </option>
</SELECT>

</li>
<li class="odd range-to"><h4>Deal Range (US $ M)</h4>

<SELECT name="invrangestart"><OPTION  value="--" selected>ALL  </option>
	<?php
                $intialValue=1;
                //$counter=5;
                     $isselected = ($_POST['invrangestart']==1) ? 'SELECTED' : '';
                    echo "<OPTION id=".$intialValue. " value=".$intialValue." ".$isselected.">".$intialValue."</OPTION> \n";
                   for ( $counter = 5; $counter <= 100; $counter += 5)
                   {
                       $isselected = ($_POST['invrangestart']==$counter) ? 'SELECTED' : '';
                    echo "<OPTION id=".$counter. " value=".$counter." ".$isselected.">".$counter."</OPTION> \n";
                   }
                    for ( $counter = 150; $counter <= 1000; $counter += 50)
                    {
                        $isselected = ($_POST['invrangestart']==$counter) ? 'SELECTED' : '';
                    echo "<OPTION id=".$counter. " value=".$counter." ".$isselected.">".$counter."</OPTION> \n";
                    }
                   for ( $counter = 2000; $counter <= 10000; $counter += 1000)
                   {
                       $isselected = ($_POST['invrangestart']==$counter) ? 'SELECTED' : '';
                    echo "<OPTION id=".$counter." value=".$counter." ".$isselected.">".$counter."</OPTION> \n";
                   }
        ?> 
</select>
<span class="range-text"> to</span>
<SELECT name="invrangeend" onchange="this.form.submit();"><OPTION  value="--" selected>ALL  </option>
	<?php
                for ($counterTo = 5; $counterTo <= 100; $counterTo += 5)
                {
                    $isselected = ($_POST['invrangeend']==$counterTo) ? 'SELECTED' : '';
                    echo "<OPTION id=".$counterTo." value=".$counterTo." ".$isselected.">".$counterTo."</OPTION> \n";
                }
                for ($counterTo = 150; $counterTo <= 1000; $counterTo += 50)
                {
                    $isselected = ($_POST['invrangeend']==$counterTo) ? 'SELECTED' : '';
                    echo "<OPTION id=".$counterTo." value=".$counterTo." ".$isselected.">".$counterTo."</OPTION> \n";
                }
                for ($counterTo = 2000; $counterTo <= 10000; $counterTo += 1000)
                {
                    $isselected = ($_POST['invrangeend']==$counterTo) ? 'SELECTED' : '';
                    echo "<OPTION id=".$counterTo." value=".$counterTo." ".$isselected.">".$counterTo."</OPTION> \n";
                }
                for ($counterTo = 20000; $counterTo <= 50000; $counterTo += 10000)
                {
                    $isselected = ($_POST['invrangeend']==$counterTo) ? 'SELECTED' : '';
                    echo "<OPTION id=".$counterTo." value=".$counterTo." ".$isselected.">".$counterTo."</OPTION> \n";
                }
        ?> 
</select>
</li>
<li class="odd"><h4>Country Target</h4>
<SELECT NAME="targetCountry" onchange="this.form.submit();">
	<OPTION  value="--" selected> ALL </option>
        <?php
        $countrysql="select countryid,country from country where countryid !=11 ";
               if ($countryrs = mysql_query($countrysql))
               {
                $ind_cnt = mysql_num_rows($countryrs);
               }
               if($ind_cnt>0)
               {
                       While($myrow=mysql_fetch_array($countryrs, MYSQL_BOTH))
                       {
                               $id = $myrow[0];
                               $name = $myrow[1];
                               $isselected = ($_POST['targetCountry']==$id) ? 'SELECTED' : '';
                               echo "<OPTION id=".$id." value=".$id.">".$name."</OPTION> \n";
                       }
                       mysql_free_result($countryrs);
               }
        ?>
</SELECT>
</li>

<li class="even"><h4>Country Acquirer </h4>
  
<SELECT NAME="acquirerCountry" onchange="this.form.submit();">
       <OPTION  value="--" selected> ALL </option>
       <?php
            $countrysql="select countryid,country from country where countryid !=11 ";
            if ($countryrs = mysql_query($countrysql))
            {
             $ind_cnt = mysql_num_rows($countryrs);
            }
            if($ind_cnt>0)
            {
                     While($myrow=mysql_fetch_array($countryrs, MYSQL_BOTH))
                    {
                            $id = $myrow[0];
                            $name = $myrow[1];
                            //$isselected = ($_POST['acquirerCountry']==$id) ? 'SELECTED' : '';
                            echo "<OPTION id=".$id." value=".$id.">".$name."</OPTION> \n";
                    }
                    mysql_free_result($countryrs);
            }
       ?>
</SELECT>
<input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();">
</li>
</ul></div>
	</div>
	
	<h2 class="acc_trigger <?php if($showdealsbyflag==1){ ?> showdeal <?php } ?>"><a href="#">Show deals by</a></h2>
	<div  class="acc_container " style="display: none;">
		<div class="block">
<ul >
<li class="ui-widget"><h4>Target Company/Sector</h4>
    <input type=text name="companysearch" id="companysearch" style="width: 97%;">
    </li>
<li class="ui-widget"><h4>Acquirers</h4>
<?php
	$acquirersql="SELECT distinct peinv.AcquirerId, ac.Acquirer
                    FROM acquirers AS ac, mama AS peinv
                    WHERE ac.AcquirerId = peinv.AcquirerId and
                    peinv.Deleted=0 order by Acquirer";
	
	if ($rsacquire = mysql_query($acquirersql))
        {
             $acquire_cnt = mysql_num_rows($rsacquire);
	}

?>
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

            if($acquire_cnt >0){
                While($myrow=mysql_fetch_array($rsacquire, MYSQL_BOTH))
                {
                        $adviosrname=trim($myrow["Acquirer"]);
                        $adviosrname=strtolower($adviosrname);

                        $invResult=substr_count($adviosrname,$searchString);
                        $invResult1=substr_count($adviosrname,$searchString1);
                        $invResult2=substr_count($adviosrname,$searchString2);

                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                        {
                            $ladvisor = $myrow["Acquirer"];
                            $ladvisorid = $myrow["AcquirerId"];
                            //echo "<OPTION value=".$ladvisorid.">".$ladvisor."</OPTION> \n";
                            //$isselcted = (trim($_POST['keywordsearch'])==trim($ladvisor)) ? 'SELECTED' : '';
                            echo "<OPTION value='".$ladvisor."'>".$ladvisor."</OPTION> \n";
                        }
                }
         		mysql_free_result($rsadvisor);
        	}
    ?>
	</SELECT>
</li>
<li class="ui-widget"><h4>Legal Advisor</h4>
<?php
	$advisorsql="(
                    SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                    FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisoracquirer AS adac
                    WHERE Deleted =0
                    AND c.PECompanyId = peinv.PECompanyId
                    AND adac.CIAId = cia.CIAID and AdvisorType='L'
                    AND adac.MAMAId = peinv.MAMAId " .$addVCFlagqry.
                    " )
                    UNION (
                    SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                    FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisorcompanies AS adcomp, acquirers AS ac
                    WHERE Deleted =0
                    AND c.PECompanyId = peinv.PECompanyId
                    AND adcomp.CIAId = cia.CIAID  and AdvisorType='L'
                    AND adcomp.MAMAId = peinv.MAMAId " .$addVCFlagqry.
                    " )	ORDER BY Cianame";
	
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
                    SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                    FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisoracquirer AS adac
                    WHERE Deleted =0
                    AND c.PECompanyId = peinv.PECompanyId
                    AND adac.CIAId = cia.CIAID and AdvisorType='T'
                    AND adac.MAMAId = peinv.MAMAId " .$addVCFlagqry.
                    " )
                    UNION (
                    SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                    FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisorcompanies AS adcomp, acquirers AS ac
                    WHERE Deleted =0
                    AND c.PECompanyId = peinv.PECompanyId
                    AND adcomp.CIAId = cia.CIAID  and AdvisorType='T'
                    AND adcomp.MAMAId = peinv.MAMAId " .$addVCFlagqry.
                    " )	ORDER BY Cianame";
	
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



