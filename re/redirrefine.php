<?php $dealtypesql = "select DealTypeId,DealType from dealtypes"; ?>

<h2 class="acc_trigger" <?php if($vcflagValue==1){ echo "style='display:none;'";}?>><a href="#">Refine Search</a></h2>
    <div class="acc_container">
        <div class="block">
            <ul >
                
                <li class="even" style="display:none;"><h4>Industry</h4>
                <SELECT name="industry" onchange="this.form.submit();">
                                <OPTION id=0 value="" selected> ALL  </option>
                                <?php
                                    $industrysql_search="select industryid,industry from reindustry";
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
                                                      if( !empty( $_POST[ 'industry' ] ) ) {
                                                        $isselcted = ($_POST['industry']==$id) ? 'SELECTED' : "";  
                                                      } else {
                                                        $isselcted = (15==$id) ? 'SELECTED' : "";
                                                      }
                                                      
                                                      echo "<OPTION id=".$id. " value=".$id." ".$isselcted.">".$name."</OPTION> \n";
                                              }
                                              mysql_free_result($industryrs);
                                      }
                                ?>
                </SELECT></li>
                <?php if($vcflagValue!=1){ ?>
                <?php if($vcflagValue!=3){ 
                    //echo "dddd".$_POST['stage'][1].",".$_POST['stage'][2].",".$_POST['stage'][3].",".$_POST['stage'][4];
                    ?>
                <li class="odd"><h4>Type</h4>

                    <div class="selectgroup">
                        <select name="stage[]" multiple="multiple" size="5" id='stage'>
                       <?php
                                $stagesql_search="select RETypeId,REType from realestatetypes order by REType";
                               if ($stagers = mysql_query($stagesql_search)){
                                       $stage_cnt = mysql_num_rows($stagers);
                               }
                               if($stage_cnt > 0){
                                   $i=1;
                                       While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH)){

                                               $id = $myrow[0];
                                               $name = $myrow[1];
                                               $isselect='';
                                               if($_POST['stage']!='')
                                               {

                                               for($i=0;$i<count($_POST['stage']);$i++){
                                                       $isselect = ($_POST['stage'][$i]==$id && $_POST['stage'][$i]!='') ? "SELECTED" : $isselect;
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
                    
                <input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();">
                </li>
                 <?php 
                }
                if($vcflagValue!=2 && $vcflagValue!=3){ ?>
                <li class="even"><h4>Investor Type</h4>

                    <SELECT NAME="invType" onchange="this.form.submit();">
                           <OPTION id="5" value="" selected> ALL </option>
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
                    <?php 
                }
                if($vcflagValue==2){ ?>
                    <li class="odd"><h4>Deal Type<span ><a href="#popup2" class="help-icon1 tooltip"><img width="18" height="18" border="0" src="<?php echo $refUrl; ?>images/help.png" alt="" style="vertical-align:middle">
                                             <span>
                                             <img class="callout1" src="<?php echo $refUrl; ?>images/callout.gif">
                                             Definitions
                                             </span>
                                </a></span></h4>
                           <SELECT NAME="dealtype" onchange="this.form.submit();">
                                   <OPTION id=5 value="" selected>ALL</option>
                                <?php

                                   if ($rsdealtype = mysql_query($dealtypesql)){
                                             $stage_cnt = mysql_num_rows($rsdealtype);
                                   }
                                   if($stage_cnt >0){

                                           While($myrow=mysql_fetch_array($rsdealtype, MYSQL_BOTH)){
                                           $id = $myrow[0];
                                           $name = $myrow[1];
                                            if($_POST['dealtype']!='')
                                             {
                                                   $isselcted = ($_POST['dealtype']==$id) ? 'SELECTED' : "";
                                                   echo "<OPTION id='".$id. "' value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                                             }
                                             else
                                             {
                                                 $isselcted = "";
                                                  echo "<OPTION id='".$id. "' value='".$id."' ".$isselcted.">".$name."</OPTION> \n";

                                             }
                                           }
                                           mysql_free_result($rsdealtype);
                                   }
                           ?>
                           </SELECT>
                        </li>
                    <?php }  
                    if($vcflagValue==3){ 
                    $invtypesql = "select MADealTypeId,MADealType from madealtypes order by MADealTypeId ";


                    ?>
                    <li class="odd"><h4>Deal Type<span ><a href="#popup2" class="help-icon1 tooltip"><img width="18" height="18" border="0" src="<?php echo $refUrl; ?>images/help.png" alt="" style="vertical-align:middle">
                    <span>
                    <img class="callout1" src="<?php echo $refUrl; ?>images/callout.gif">
                    Definitions
                    </span>
                         </a></span></h4>
                    <SELECT NAME="dealtype" onchange="this.form.submit();">
                            <OPTION id=5 value="" selected> ALL </option>
                         <?php

                            if ($invtypers = mysql_query($invtypesql))
                            {
                            $invtype_cnt = mysql_num_rows($invtypers);
                            }
                            if($invtype_cnt >0)
                            {
                            While($myrow=mysql_fetch_array($invtypers, MYSQL_BOTH))
                            {
                                    $id = $myrow["MADealTypeId"];
                                    $name = $myrow["MADealType"];
                                     if($_POST['dealtype']!='')
                                      {
                                            $isselcted = ($_POST['dealtype']==$id) ? 'SELECTED' : "";
                                            echo "<OPTION id='".$id. "' value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                                      }
                                      else
                                      {
                                          $isselcted = "";
                                           echo "<OPTION id='".$id. "' value='".$id."' ".$isselcted.">".$name."</OPTION> \n";

                                      }
                                    }
                                    mysql_free_result($invtypers);
                            }
                    ?>
                    </SELECT>
                    </li>
                    <?php } ?>
                    <li class="even"><h4>Deal Range (USM $)</h4>

                    <SELECT NAME="invrange" onchange="this.form.submit();">
                           <OPTION id="5" value="" selected> ALL </option>
                             <?php
                               /* investment range populate from investment range table*/
                                    $rangesql = "select InvestRangeId,RangeText from investmentrange order by InvestRangeId";
                                            if ($rangers = mysql_query($rangesql))
                                            {
                                       $range_cnt = mysql_num_rows($rangers);
                                            }
                                      if($range_cnt >0)
                                    {
                                     While($myrow=mysql_fetch_array($rangers, MYSQL_BOTH))
                                    {
                                            $id = $myrow["InvestRangeId"];
                                            $name = $myrow["RangeText"];
                                            $isselcted = ($_POST['invrange']==$id) ? 'SELECTED' : "";
                                            echo "<OPTION id=".$id. " value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                                    }
                                            mysql_free_result($rangers);
                                    }
                        ?>
                    </SELECT>
                    </li>
                <?php } ?>

</ul>
</div>
	</div>
	
	<h2 class="acc_trigger <?php if($showdealsbyflag==1){ ?> showdeal <?php } ?>"><a href="#">Show directory by</a></h2>
	<div  class="acc_container " style="display: none;">
		<div class="block">
<ul >
<?php  
include ('reinvestors_model.php');
if($vcflagValue!=3){ ?>
<li class="ui-widget"><h4>Investor</h4>
    <SELECT id="keywordsearch" NAME="keywordsearch">
        <OPTION id="5" value=" " selected></option>
        <?php
            /* populating the investortype from the investortype table */
            
            
            $searchString="Undisclosed";
            $searchString=strtolower($searchString);

            $searchString1="Unknown";
            $searchString1=strtolower($searchString1);

            $searchString2="Others";
            $searchString2=strtolower($searchString2);   
            
            if($vcflagValue==0){   
                 $getInvestorSql=getReInvestorsByValue(0);
            }
            elseif($vcflagValue==1){
                 $getInvestorSql=getReInvestorsByValue(2);
            }
            elseif($vcflagValue==2){
                $getInvestorSql=getReInvestorsByValue(3);
            }
            
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
                           // $investorId = $myrow["InvestorId"];
                            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                            $isselcted = (trim($_POST['keywordsearch'])==trim($investor)) ? 'SELECTED' : '';
                            echo "<OPTION value='".$investor."' ".$isselcted.">".$investor."</OPTION> \n";
                    }
                }
                mysql_free_result($rsinvestors);
            }
    ?>
</SELECT>
</li>
<?php }/*else{
 ?>   
<li ><h4>Acquirer</h4>
  <select id="keywordsearch" name="keywordsearch" >
        <OPTION value=" " selected></option>
            <?php
                $getacquirerSql_search ="select peinv.AcquirerId,ac.Acquirer from  REmama AS peinv,REacquirers as ac WHERE ac.AcquirerId = peinv.AcquirerId GROUP BY peinv.AcquirerId";
                if ($rsrequirer = mysql_query($getacquirerSql_search))
                { 
                        While($myrow1=mysql_fetch_array($rsrequirer, MYSQL_BOTH))
                        {

                                        $acqName = $myrow1["Acquirer"];
                                        $isselected = (trim($_POST['keywordsearch'])==trim($acqName)) ? 'SELECTED' : '';
                                        echo '<OPTION value="'.$acqName.'" '.$isselected.'>'.$acqName.'</OPTION> \n';
//	
                        }
                         mysql_free_result($rsrequirer);
                }
            ?>
   </select>
</li>

<?php    
} */?>
<li class="ui-widget"><h4>Company</h4>
    <select id="combobox" name="companysearch" >
        <OPTION value=" " selected></option>
        <?php
                
            if($vcflagValue==0){   
                $getcompaniesSql_search = getAllReCompanies(0);
            }
            elseif($vcflagValue==1){
                $getcompaniesSql_search = getAllReCompanies(1);
            }
            elseif($vcflagValue==2){
                $getcompaniesSql_search = getAllReCompanies(2);
            }
            elseif($vcflagValue==3){
                $getcompaniesSql_search = getAllReCompanies(3);
            }
            
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
                            echo '<OPTION value="'.$compName.'" '.$isselected.'>'.$compName.'</OPTION> \n';
                            //$totalCount=$totalCount+1;
                    }
        //	
                }
                mysql_free_result($rscompanies);
            }
        ?>
   </select>	
</li>
<?php if($vcflagValue!=1){ ?>
<!--li class="ui-widget"><h4>Sub Sector</h4>
<select id="sectorsearch" NAME="sectorsearch" >
		<OPTION value=' ' selected></option>
		<?php
                
                if($vcflagValue==2){   
                    $getsectorSql_search =  getAllReSector(2);
                }
                elseif($vcflagValue==0){
                    $getsectorSql_search =  getAllReSector(0);
                }
                elseif($vcflagValue==3){
                    $getsectorSql_search =  getAllReSector(3);
                }
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
                                $sectorName = ($myrow["sector_business"])?$myrow["sector_business"]:"Other";
                                $isselected = (trim($_POST['sectorsearch']) == trim($sectorName)) ? 'SELECTED' : ' ';
                                echo '<OPTION value='.$sectorName.' '.$isselected.'>'.$sectorName.'</OPTION> \n';
                                //$totalCount=$totalCount+1;
                        }
                    }
                    mysql_free_result($rssector);
                }
    	?>
   </select>	
</li-->
<li class="ui-widget"><h4>Sub Sector</h4>

<select id="sectorsearch" NAME="sectorsearch" >
		<OPTION value=' ' selected></option>
		<?php
                    if($vcflagValue==2){   
                        $getsectorSql_search =  getAllReSector(2);
                    }
                    elseif($vcflagValue==0){
                        $getsectorSql_search =  getAllReSector(0);
                    }
                    elseif($vcflagValue==3){
                        $getsectorSql_search =  getAllReSector(3);
                    }
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
                                                $sectorName = $myrow["sector_business"];
						$isselected = (trim($_POST['sectorsearch'])==trim($sectorName)) ? 'SELECTED' : '';
						echo '<OPTION value="'.$sectorName.'" '.$isselected.'>'.$sectorName.'</OPTION> \n';
				 		//$totalCount=$totalCount+1;
					}
				}
                                mysql_free_result($rssector);
			}
    	?>
   </select>	
</li>
<li class="ui-widget"><h4>Legal Advisor</h4>
<?php
        if($vcflagValue==0){
            $advisorsql=getReAdvisorsByValue("L1");
        }
        elseif($vcflagValue==2){
            $advisorsql=getReAdvisorsByValue("L2");
        }
        elseif($vcflagValue==3){
            $advisorsql=getReAdvisorsByValue("L3");
        }
           	
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
	
        if($vcflagValue==0){
            $advisorsql=getReAdvisorsByValue("T1");
        }
        elseif($vcflagValue==2){
            $advisorsql=getReAdvisorsByValue("T2");
        }
        elseif($vcflagValue==3){
            $advisorsql=getReAdvisorsByValue("T3");
        }
	if ($rsadvisor = mysql_query($advisorsql)){
		$advisor_cnt = mysql_num_rows($rsadvisor);
	}

?>
	<SELECT id="advisorsearch_trans" NAME="advisorsearch_trans">
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
						$isselcted = (trim($_POST['advisorsearch_trans'])==trim($ladvisor)) ? 'SELECTED' : '';
						echo "<OPTION value='".$ladvisor."' ".$isselcted.">".$ladvisor."</OPTION> \n";
					}
            	}
         		mysql_free_result($rsadvisor);
        	}
    ?>
	</SELECT>
    </li>
<?php } ?>
    <li><input name="reset" id="resetall" class="refine reset-btn" type="button" value="Reset" style="float: left;" />
        <input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();" style="float: right;">
    </li>
    
</ul></div>
	</div>
