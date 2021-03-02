 <?php 
 require_once("../dbconnectvi.php");
 $Db = new dbInvestments();
 if(!isset($_SESSION['UserNames']))
 {
     header('Location:../pelogin.php');
 }
 else
 {	
 if($vcflagValue==0 || $vcflagValue==3 || $vcflagValue==4 || $vcflagValue==5)
        {
            $stagesql_search = "select StageId,Stage from stage ";
        }
        elseif( $vcflagValue ==1)
        {
                 $stagesql_search = "select StageId,Stage from stage where VCview=1 ";
        }
        ?>
<h2 class="acc_trigger"><a href="#">Refine Search</a></h2>
	<div class="acc_container">
		<div class="block">
			<ul >
<li class="even"><h4>Industry</h4>
<SELECT name="industry" onchange="this.form.submit();">
  		<OPTION id=0 value="" selected> ALL  </option>
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
                                                $isselcted = ($_POST['industry']==$id) ? 'SELECTED' : "";
						echo "<OPTION id=".$id. " value=".$id." ".$isselcted.">".$name."</OPTION> \n";
					}
				 	mysql_free_result($industryrs);
				}
    		?>
</SELECT></li>
<?php
if($vcflagValue==0 || $vcflagValue==1 ||$vcflagValue==3 || $vcflagValue==4 || $vcflagValue==5)
{
?>

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
			for($i=0;$i<count($_POST['stage']);$i++){
				$isselect = ($_POST['stage'][$i]==$id) ? "SELECTED" : $isselect;
			}
			echo '<OPTION value="'.$id.'" '.$isselect.'>'.$name.'</OPTION> \n';
		}
		 mysql_free_result($stagers);
	}
	
 ?>
</select> </div>
<input type="button" name="fliter_stage" value="Filter" onclick="document.pesearch.submit();">
</li>
<?php
}
?>
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
</SELECT>
<li class="odd range-to"><h4>Deal Range (US $ M)</h4>
<SELECT name="invrangestart"><OPTION id=4 value="--" selected>ALL  </option>
	<?php
        $counter=0;
            
            if($vcflagValue==1)
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
           else
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
        ?> 
</select>
<span class="range-text"> to</span>
<SELECT name="invrangeend" onchange="this.form.submit();"><OPTION id=5 value="--" selected>ALL  </option>
	<?php
        $counter=0;
           
            if($vcflagValue==1)
            {
                for ( $counterto = 5; $counterto <= 20; $counterto += 1){
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
            else
            {
                for ( $counterto = 5; $counterto <= 1000; $counterto += 5){
                    
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

<!--</ul>


 

<div class="showhide-link"><a rel="#slidingrefine" class="show_hide active" href="#"><i></i>Show deals by</a></div>
<ul class="refine content" id="slidingrefine" style="display:none;">-->
<li class="ui-widget"><h4>Investor</h4>
<SELECT id="keywordsearch" NAME="keywordsearch">
       <OPTION id="5" value="" selected> ALL </option>
         <?php
            /* populating the investortype from the investortype table */
		$searchStrings="Undisclosed";
			$searchStrings=strtolower($searchStrings);
		
			$searchStrings1="Unknown";
			$searchStrings1=strtolower($searchStrings1);
		
			$searchStrings2="Others";
			$searchStrings2=strtolower($searchStrings2);
			
            $getInvestorSqls="SELECT DISTINCT inv.InvestorId, inv.Investor,pec.sector_business
				FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, stage AS s
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND s.StageId = pe.StageId
				AND pec.industry !=15
				AND peinv.PEId = pe.PEId
				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " group by inv.Investor ";
            echo $getInvestorSqls;
				
            if ($rsinvestors = mysql_query($getInvestorSqls)){
               $investors_cnts = mysql_num_rows($rsinvestors);
            }
			
            if($investors_cnts >0){
                 mysql_data_seek($rsinvestor ,0);
             	 While($myrows=mysql_fetch_array($rsinvestors, MYSQL_BOTH)){
                	$Investornames=trim($myrows["Investor"]);
					$Investornames=strtolower($Investornames);

					$invResults=substr_count($Investornames,$searchStrings);
					$invResults1=substr_count($Investornames,$searchStrings1);
					$invResults2=substr_count($Investornames,$searchStrings2);
					
					if(($invResults==0) && ($invResults1==0) && ($invResults2==0)){
						$investors = $myrows["Investor"];
						$investorsId = $myrows["InvestorId"];
						//echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
						$isselcted = (trim($_POST['keywordsearch'])==trim($investors)) ? 'SELECTED' : '';
						echo "<OPTION value='".$investors."' ".$isselcted.">".$investors."</OPTION> \n";
					}
            	}
         		mysql_free_result($invtypers);
        	}
    ?>
</SELECT>
</li>
    
    <li>
    	<input type="button" name="fliter_stage" value="Filter" onclick="document.pesearch.submit();">
    </li>
</ul>
<?php } ?>