<?php
        
        $companyId=632270771;
        $compId=0;
        require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
    if(!isset($_SESSION['UserNames']))
    {
            header('Location:../pelogin.php');
    }
    else
    {
        include ('checklogin.php');
        $vcflagValue = isset($_REQUEST['value']) ? $_REQUEST['value'] : '0'; 
        $type=$_REQUEST['type'];
        
        
            if($vcflagValue==0)
            {
                    $addVCFlagqry = "" ;
                    $searchTitle = "List of PE-backed IPOs ";
                    $searchAggTitle = "Aggregate Data - PE-backed IPOs ";
            }
            elseif($vcflagValue==1)
            {
                    $addVCFlagqry = " and VCFlag=1 ";
                    $searchTitle = "List of VC-backed IPOs ";
                    $searchAggTitle = "Aggregate Data - VC-backed IPOs ";
            }
                $dbTypeSV="SV";
                $dbTypeIF="IF";
                $dbTypeCT="CT";

                $searchString="Undisclosed";
                $searchString=strtolower($searchString);

                $searchString1="Unknown";
                $searchString1=strtolower($searchString1);

                $searchString2="Others";
                $searchString2=strtolower($searchString2);

                $buttonClicked=$_POST['hiddenbutton'];
                $fetchRecords=true;
                $totalDisplay="";
                $keyword= $_POST['investorsearch'];
                $keywordhidden= trim($keyword);
                $companysearch=$_POST['companysearch'];
                $companysearchhidden= trim($companysearch);
                $advisorsearch=$_POST['advisorsearch'];
                $advisorsearchhidden= trim($advisorsearch);

                $advisorsearch="";

                $industry=$_POST['industry'];
                $investorType=$_POST['invType'];
                $exitstatusvalue=$_POST['exitstatus'];
              // echo "<br>___".$exitstatusvalue;
                $investorSale=$_POST['invSale'];

                $txtfrm=$_POST['txtmultipleReturnFrom'];
                $txtto=$_POST['txtmultipleReturnTo'];

                //echo "<br>--" .$keywordhidden;
                    if($_POST['year1'] !='')
                        {
                                $syear=$_POST['year1'];
                                $fixstart=$_POST['year1'];
                                $startyear=$syear."-01-01";
                        }
                        else
                        {
                            if($type==1)
                            {
                                 $fixstart=1998;
                                 $startyear="1998-01-01";
                            }
                            else 
                            {
                                $fixstart=2009;
                                $startyear="2009-01-01";
                             }   
                        }
                        if($_POST['year2'] =='')
                        {
                                $endyear=date("Y-m-d");
                                $fixend=date("Y-m-d"); 
                        }
                        else
                        {
                                $eyear=$_POST['year2'];
                                $fixend=$_POST['year2'];
                                $endyear=$eyear."-01-01";
                        } 

		if($industry >0)
		{
			$industrysql= "select industry from industry where IndustryId=$industry";
			if ($industryrs = mysql_query($industrysql))
			{
				While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
				{
					$industryvalue=$myrow["industry"];
				}
			}
		}
		if($investorType !="--")
		{
		       $invTypeSql= "select InvestorTypeName from investortype where InvestorType='$investorType'";
		       if ($invrs = mysql_query($invTypeSql))
		       {
		          While($myrow=mysql_fetch_array($invrs, MYSQL_BOTH))
		          {
		             $invtypevalue=$myrow["InvestorTypeName"];
		          }
		       }
		}

		$aggsql= "select count(pe.IPOId) as totaldeals,sum(pe.IPOSize) as totalamount from ipos as pe,industry as i,pecompanies as pec where";

		if($range != "--")
		{
			$rangesql= "select startRange,EndRange from investmentrange where InvestRangeId=". $range ." ";
			if ($rangers = mysql_query($rangesql))
			{
				While($myrow=mysql_fetch_array($rangers, MYSQL_BOTH))
				{
					$startRangeValue=$myrow["startRange"];
					$endRangeValue=$myrow["EndRange"];
					$rangeText=$myrow["RangeText"];

				}
			}
		}
		if($exitstatusvalue=="0")
		  $exitstatusdisplay="Partial Exit";
		elseif($exitstatusvalue=="1")
                  $exitstatusdisplay="Complete Exit";
                else
                  $exitstatusdisplay="";
                
              print_r($_POST);
                        if(!$_POST){
                            echo "not post";
				$yourquery=0;
				$stagevaluetext="";
				$industry=0;
                                //echo "<br>Query for all records";
                                 if($type==1)
                                { 
                                    $companysql = "select year(pei.IPODate),count(pei.IPOId),sum(pei.IPOAmount) from ipos as pei, industry as i,pecompanies as pec, ipo_investors as ipoinv where i.industryid=pec.industry and
					pec.PEcompanyID = pei.PECompanyID  and  ipoinv.IPOId=pei.IPOId  and pei.Deleted=0 " .$addVCFlagqry. " and IPODate > '1997-01-01' and IPODate <='2013-12-31' group by year(pei.IPODate)"  ;
                                   echo  $companysql;
                                    $resultcompany= mysql_query($companysql);
                                }
                                elseif ($type==2) 
                                {
                                   $companysql = "select  i.industry,year(pei.IPODate),count(pei.IPOId),sum(pei.IPOAmount) from ipos as pei, industry as i,pecompanies as pec, ipo_investors as ipoinv where i.industryid=pec.industry and
					pec.PEcompanyID = pei.PECompanyID  and  ipoinv.IPOId=pei.IPOId  and pei.Deleted=0 " .$addVCFlagqry. " and IPODate > '".$startyear."' and IPODate  <= '".$endyear."' group by pec.industry,year(pei.IPODate)";
                                  echo  $companysql;
                                   $resultcompany= mysql_query($companysql);
                                }
                                else if($type ==4)
                                {
                                    $range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200+");
                                    for($r=0;$r<count($range);$r++)
                                    {
                                        if($r == count($range)-1)
                                        {
                                            $companysql = "select year(pei.IPODate),count(pei.IPOId),sum(pei.IPOAmount) from ipos as pei, industry as i,pecompanies as pec, ipo_investors as ipoinv where i.industryid=pec.industry and
                                            pec.PEcompanyID = pei.PECompanyID  and  ipoinv.IPOId=pei.IPOId  and pei.Deleted=0 " .$addVCFlagqry. " and (pei.IPOAmount  > 200) and IPODate > '".$startyear."' and IPODate  <= '".$endyear."' group by year(pei.IPODate)";
                                            
                                          echo  $companysql;
                                             $resultcompany= mysql_query($companysql);
                                        }
                                        else
                                        {
                                            $limit=(string)$range[$r];
                                            $elimit=explode("-", $limit);
                                            $companysql  = "select year(pei.IPODate),count(pei.IPOId),sum(pei.IPOAmount) from ipos as pei, industry as i,pecompanies as pec, ipo_investors as ipoinv where i.industryid=pec.industry and
                                            pec.PEcompanyID = pei.PECompanyID  and  ipoinv.IPOId=pei.IPOId  and pei.Deleted=0 " .$addVCFlagqry. " and (pei.IPOAmount > ".$elimit[0]." and pei.IPOAmount <= ".$elimit[1].") and IPODate > '".$startyear."' and IPODate <= '".$endyear."' group by year(pei.IPODate)";                           
                                            echo  $companysql;
                                            $resultcompany= mysql_query($companysql);
                                        }
                                        if(mysql_num_rows($resultcompany)>0)
                                        {
                                            while ($rowrange = mysql_fetch_array($resultcompany))
                                            {
                                                $deal[$range[$r]][$rowrange[0]]['dealcount']=$rowrange[1];
                                                $deal[$range[$r]][$rowrange[0]]['sumamount']=$rowrange[2];   
                                            }
                                        }
                                        else
                                        {
                                            $deal='';
                                        }
                                     }
                                }
                                elseif($type==5)
                                {
                                   $companysql = "select inv.InvestorTypeName,year(pei.IPODate),count(pei.IPOId),sum(pei.IPOAmount) from ipos as pei, industry as i,pecompanies as pec, investortype as inv, ipo_investors as ipoinv where i.industryid=pec.industry and
                                            pec.PEcompanyID = pei.PECompanyID  and  ipoinv.IPOId=pei.IPOId  and pei.Deleted=0 " .$addVCFlagqry. " and pei.InvestorType=inv.InvestorType and IPODate > '".$startyear."' and IPODate <= '".$endyear."' group by inv.InvestorTypeName, year(pei.IPODate)";
                                  echo  $companysql;
                                  $resultcompany= mysql_query($companysql);
                                }
                               
			//	     echo "<br>all records" .$companysql;
			}
			
//if (($companyType!="--") || ($debt_equity!="--") || ($invType != "--") || ($regionId>0)  || ($startRangeValue == "--") || ($endRangeValue == "--") || (($year1 != "")  && ($year2 != "")) || ($advisorsearchstring_trans!= " ")||($advisorsearchstring_legal!=" ")||($sectorsearch != " ")||($companysearch != " ")||($keyword != " ").$checkForStageValue)
			else if($_POST)
                        {
                               echo "post";
                              $dt1 =  $startyear;
                              $dt2 = $endyear;
                              
                            if($type != 4)
                            {
                                if($keyword != " ")
                                {
                                        $keybef=", peinvestors as pinv";
                                }
                                if($type==1)
                                {
                                    $companysql = "select year(pei.IPODate),count(pei.IPOId),sum(pei.IPOAmount) from ipos as pei, industry as i,pecompanies as pec, ipo_investors as ipoinv ".$keybef." where";
                                }
                                else if($type==2)
                                {
                                   $companysql = "select i.industry,year(pei.IPODate),count(pei.IPOId),sum(pei.IPOAmount) from ipos as pei, industry as i,pecompanies as pec, ipo_investors as ipoinv ".$keybef."where "; 
                                
                                }
                                else if($type==5)
                                {
                                   $companysql = "select inv.InvestorTypeName,year(pei.IPODate),count(pei.IPOId),sum(pei.IPOAmount) from ipos as pei, industry as i,pecompanies as pec, investortype as inv, ipo_investors as ipoinv ".$keybef."where "; 
                                
                                }
                            
				//echo "<br> individual where clauses have to be merged ";
					
                                        if ($industry > 0)
                                        {
                                                $whereind = " pec.industry=" .$industry ;
                                                $qryIndTitle="Industry - ";
                                        }
                                        if (($investorType!= "--")  && ($investorType!=""))
                                        {
                                                $qryInvType="Investor Type - " ;
                                                $whereInvType = " pei.InvestorType = '".$investorType."'";
                                        }
                                          if($exitstatusvalue!="--")
                                          {    $whereexitstatus=" pei.ExitStatus=".$exitstatusvalue;  }

                                          if($investorSale!="--")
                                          {    $whereinvestorSale=" pei.InvestorSale=".$investorSale;

                                          }
                                            if ($region!= "--")
                                            {
                                                    $qryRegionTitle="Region - ";
                                                    $whereregion = " pei.region ='".$region."'";
                                            }
                                            if( ($dt1 != "")  && ($dt2 != ""))
                                            {
                                                    $qryDateTitle ="Period - ";
                                                    $wheredates= " IPODate between '" . $dt1. "' and '" . $dt2 . "' group by year(pei.IPODate)";
                                            }

                                            if(trim($txtfrm>0) && trim($txtto==""))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" ipoinv.MultipleReturn > " .$txtfrm  ;
                                            }
                                            elseif(trim($txtfrm=="") && trim($txtto>0))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" ipoinv.MultipleReturn < " .$txtto  ;
                                            }
                                            elseif(trim($txtfrm>0) && trim($txtto >0))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" ipoinv.MultipleReturn > " .$txtfrm . " and  ipoinv.MultipleReturn <".$txtto;
                                            }
                                               // echo "<bR>***" .$whereReturnMultiple;
                                           if ($whereind != "")
                                            {
                                                    $companysql=$companysql . $whereind ." and ";
                                                    $aggsql=$aggsql . $whereind ." and ";
                                                    $bool=true;
                                            }
                                            else
                                            {
                                                    $bool=false;
                                            }
                                        if (($whereInvType != "") )
                                        {
                                                $companysql=$companysql .$whereInvType . " and ";
                                                $aggsql = $aggsql . $whereInvType ." and ";
                                                $bool=true;
                                        }
                                        if($whereexitstatus!="")
                                        {
                                          $companysql=$companysql .$whereexitstatus . " and ";
                                        }
					if($whereinvestorSale!="")
                                        {
                                          $companysql=$companysql .$whereinvestorSale . " and ";
                                        }
                                                
                                        if($keyword != " ")
                                        {
                                                $keyaft=" pinv.InvestorId=ipoinv.InvestorId and pei.IPOId=ipoinv.IPOId and pinv.investor like '%$keyword%'";
                                                $companysql=$companysql . $keyaft . " and ";
                                        }
                                        if($companysearch != " ")
                                        {

                                                $csaft=" pec.companyname LIKE '%$companysearch%'";
                                                $companysql=$companysql . $csaft . " and ";
                                        }
                                        if($whereReturnMultiple!= "")
                                        {
                                         $companysql = $companysql . $whereReturnMultiple ." and ";
                                        }
                                        
                                        $companysql = $companysql . "  i.industryid=pec.industry and
					pec.PEcompanyID = pei.PECompanyID  and  ipoinv.IPOId=pei.IPOId  and
					pei.Deleted=0 " .$addVCFlagqry. " ";
                                        
					if(($wheredates !== "") )
					{
						$companysql = $companysql . $wheredates ." and ";
						$aggsql = $aggsql . $wheredates ." and ";
						$bool=true;
					}
                                         echo $companysql;
                                         $resultcompany= mysql_query($companysql);
                               }
                                        
                                        
                                        
                                if($type == 4 && $_POST)
                                {
                                    
                                    $range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200");
                                    //print_r($range);
                                    for($r=0;$r<count($range);$r++)
                                    {
                                         if($keyword != " ")
                                        {
                                                $keybef=", peinvestors as pinv";
                                        }
                                        $limit=(string)$range[$r];
                                        $elimit=explode("-", $limit);
                                        $companysql = "select year(pei.IPODate),count(pei.IPOId),sum(pei.IPOAmount) from ipos as pei, industry as i,pecompanies as pec, ipo_investors as ipoinv where i.industryid=pec.industry and
                                            pec.PEcompanyID = pei.PECompanyID  and  ipoinv.IPOId=pei.IPOId  and pei.Deleted=0 " .$addVCFlagqry. " and (pei.IPOAmount > ".$elimit[0]." and pei.IPOAmount <= ".$elimit[1].") and";
                                         if ($industry > 0)
                                        {
                                                $whereind = " pec.industry=" .$industry ;
                                                $qryIndTitle="Industry - ";
                                        }
                                        if (($investorType!= "--")  && ($investorType!=""))
                                        {
                                                $qryInvType="Investor Type - " ;
                                                $whereInvType = " pei.InvestorType = '".$investorType."'";
                                        }
                                          if($exitstatusvalue!="--")
                                          {    $whereexitstatus=" pei.ExitStatus=".$exitstatusvalue;  }

                                          if($investorSale!="--")
                                          {    $whereinvestorSale=" pei.InvestorSale=".$investorSale;

                                          }
                                            if ($region!= "--")
                                            {
                                                    $qryRegionTitle="Region - ";
                                                    $whereregion = " pei.region ='".$region."'";
                                            }
                                            if( ($dt1 != "")  && ($dt2 != ""))
                                            {
                                                    $qryDateTitle ="Period - ";
                                                    $wheredates= " IPODate between '" . $dt1. "' and '" . $dt2 . "' group by year(pei.IPODate)";
                                            }

                                            if(trim($txtfrm>0) && trim($txtto==""))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" ipoinv.MultipleReturn > " .$txtfrm  ;
                                            }
                                            elseif(trim($txtfrm=="") && trim($txtto>0))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" ipoinv.MultipleReturn < " .$txtto  ;
                                            }
                                            elseif(trim($txtfrm>0) && trim($txtto >0))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" ipoinv.MultipleReturn > " .$txtfrm . " and  ipoinv.MultipleReturn <".$txtto;
                                            }
                                               // echo "<bR>***" .$whereReturnMultiple;
                                           if ($whereind != "")
                                            {
                                                    $companysql=$companysql . $whereind ." and ";
                                                    $aggsql=$aggsql . $whereind ." and ";
                                                    $bool=true;
                                            }
                                            else
                                            {
                                                    $bool=false;
                                            }
                                        if (($whereInvType != "") )
                                        {
                                                $companysql=$companysql .$whereInvType . " and ";
                                                $aggsql = $aggsql . $whereInvType ." and ";
                                                $bool=true;
                                        }
                                        if($whereexitstatus!="")
                                        {
                                          $companysql=$companysql .$whereexitstatus . " and ";
                                        }
					if($whereinvestorSale!="")
                                        {
                                          $companysql=$companysql .$whereinvestorSale . " and ";
                                        }
                                                
                                        if($keyword != " ")
                                        {
                                                $keyaft=" pinv.InvestorId=ipoinv.InvestorId and pei.IPOId=ipoinv.IPOId and pinv.investor like '%$keyword%'";
                                                $companysql=$companysql . $keyaft . " and ";
                                        }
                                        if($companysearch != " ")
                                        {

                                                $csaft=" pec.companyname LIKE '%$companysearch%'";
                                                $companysql=$companysql . $csaft . " and ";
                                        }
                                        if($whereReturnMultiple!= "")
                                        {
                                         $companysql = $companysql . $whereReturnMultiple ." and ";
                                        }
                                        
                                        $companysql = $companysql . "  i.industryid=pec.industry and
					pec.PEcompanyID = pei.PECompanyID  and  ipoinv.IPOId=pei.IPOId  and
					pei.Deleted=0 " .$addVCFlagqry. " ";
                                        
					if(($wheredates !== "") )
					{
						$companysql = $companysql . $wheredates ." and ";
						$aggsql = $aggsql . $wheredates ." and ";
						$bool=true;
					}
                                         //echo $companysql;
                                              $resultcompany= mysql_query($companysql) or die(mysql_error());
                                        
                                        if(mysql_num_rows($resultcompany)>0)
                                        {
                                            while ($rowrange = mysql_fetch_array($resultcompany))
                                            {
                                                $deal[$range[$r]][$rowrange[0]]['dealcount']=$rowrange[1];
                                                $deal[$range[$r]][$rowrange[0]]['sumamount']=$rowrange[2];   
                                            }
                                        }
                                        else
                                        {
                                            $deal='';
                                        }
                                     }
                                }
                               
		}
			
			
				else
				{
					echo "<br> INVALID DATES GIVEN ";
					$fetchRecords=false;
				}
	//}
	//END OF POST
	
	
	
		$companyId=632270771;
	$compId=0;
	$currentyear = date("Y");
	
	$TrialSql="select dm.DCompId as compid,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
		where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
	
	if($trialrs=mysql_query($TrialSql))
	{
		while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
		{
			$exportToExcel=$trialrow["TrialLogin"];
			$compId=$trialrow["compid"];

		}
	}
	
   if($compId==$companyId){ 
   		$hideIndustry = " and display_in_page=1 "; 
	} else { 
		$hideIndustry=""; 
	}
	
	
	/*$getTotalQuery="SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
	FROM peinvestments AS pe, pecompanies AS pec
	WHERE pe.Deleted =0  and pe.PECompanyId=pec.PECompanyId
	AND pec.industry !=15 and pe.AggHide=0 and
				pe.PEId NOT
						IN (
						SELECT PEId
						FROM peinvestments_dbtypes AS db
						WHERE DBTypeId ='SV'
						AND hide_pevc_flag =1
						)";
	$pagetitle="PE Investments -> Search";
	$stagesql = "select StageId,Stage from stage ";*/
	
	//INDUSTRY
	$industrysql="select industryid,industry from industry where industryid !=15" . $hideIndustry ." order by industry";
	
	//Company Sector
	$searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);
	
	$addVCFlagqry="";
	$pagetitle="PE-backed Companies";

	$getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
					FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
					WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
					AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
					AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
	ORDER BY pec.companyname";
	
	//Stage
	$stagesql = "select StageId,Stage from stage ";
	

?>

<?php 
	$topNav = 'Deals';
	 include_once('ipoheader_search.php');
?>




<div id="container">
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td class="left-box">

<?php include_once('iporefine.php');?>
    <input type="hidden" name="resetfield" value="" id="resetfield"/>
</td>
 <?php

				$exportToExcel=0;
			 $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,dealmembers as dm
										where dm.EmailId='$UserEmail' and dc.DCompId=dm.DCompId";
			//echo "<br>---" .$TrialSql;
			if($trialrs=mysql_query($TrialSql))
			{
				while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
				{
					$exportToExcel=$trialrow["TrialLogin"];
					$studentOption=$trialrow["Student"];
				}
			}

			if($yourquery==1)
				$queryDisplayTitle="Query:";
			elseif($yourquery==0)
				$queryDisplayTitle="";
					if(trim($buttonClicked==""))
					{
						$totalDisplay="Total";
				    	$industryAdded ="";
				    	$totalAmount=0.0;
				    	$totalInv=0;
						$compDisplayOboldTag="";
						$compDisplayEboldTag="";
				 	  //echo "<br> query final-----" .$companysql;
				 	      /* Select queries return a resultset */
						 if ($companyrs = mysql_query($companysql))
						 {
						    $company_cnt = mysql_num_rows($companyrs);
						 }

				           if($company_cnt > 0)
				           {
				           		//$searchTitle=" List of Deals";
				           }
				           else
				           {
				              	$searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
				              	$notable=true;
				              	writeSql_for_no_records($companysql,$emailid);
				           }


		           ?>


<td>
    <div style="float:right;padding: 20px" class="key-search"><b></b> <input type="text" name="searchallfield" placeholder=" Keyword Search"> <input type="button" name="fliter_stage" value="Go" onclick="this.form.submit();"></div>

<div class="result-cnt">
					
					<?php
						if($notable==false)
						{ 
					?>
                        <div class="veiw-tab"><ul>
                        <li class="active"><a class="postlink" href="index.php"><i class="i-list-view"></i>List View</a></li>
                        <?php
						$count=0;
						 While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
						{
							if($count == 0)
							{
								 $comid = $myrow["PEId"];
								$count++;
							}
						}
						?>
                        <li><a class="postlink" href="dealdetails.php?value=<?php echo $comid;?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?>"><i class="i-profile-view"></i>Deal Details View</a></li>
                        <li><a class="postlink" href="trendview2.php?type=1&value=<?php echo $vcflagValue;?>"><i class="i-trend-view"></i>Trend View</a></li>
                        <li><a class="postlink" href="trendview3.php?type=1&value=<?php echo $vcflagValue;?>"><i class="i-trend-view"></i>Trend View2</a></li>
                        </ul></div>	
    <?php
if($vcflagValue==0)
{
?>
<div id="sec-header">
 <table cellpadding="0" cellspacing="0">
 <tr>
<td class="investment-form">
<h3>Types</h3>
<label><input class="typeoff-nav20" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/> Year On year</label>
<label><input class="typeoff-nav20" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />Industry</label>
<label><input class="typeoff-nav20" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>Range</label>
<label><input class="typeoff-nav20" name="typeoff" type="radio" value="5" <?php if($type==5) { ?> checked="checked" <?php } ?>/>Investor Type</label>
</td></tr>
</table>
</div>
<?php
}
else if($vcflagValue==1)
{
?>
<div id="sec-header">
 <table cellpadding="0" cellspacing="0">
 <tr>
<td class="investment-form">
<h3>Types</h3>
<label><input class="typeoff-nav21" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/> Year On year</label>
<label><input class="typeoff-nav21" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />Industry</label>
<label><input class="typeoff-nav21" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>Range</label>
<label><input class="typeoff-nav21" name="typeoff" type="radio" value="5" <?php if($type==5) { ?> checked="checked" <?php } ?>/>Investor Type</label>
</td></tr>
</table>
</div>
<?php     
}
?>
 <div class="profile-view-title"> 
 <?php 
 if($type==1)
 {
 ?>
    <h2>PE - Year on Year</h2>
<?php
 }
 elseif($type==2)
 {
     ?>
     <h2>PE - By Industry</h2>
 <?php
 }
  elseif($type==3)
 {
     ?>
     <h2>PE - By Stage</h2>
 <?php
 }
  elseif($type==4)
 {
     ?>
     <h2>PE - By Range</h2>
 <?php
 }
  elseif($type==5)
 {
     ?>
     <h2>PE - By Investor</h2>
 <?php
 } elseif($type==6)
 {
     ?>
     <h2>PE - By Region</h2>
 <?php
 }
 ?>
 </div>
    <?php
if($type==2 || $type==3 || $type==4 || $type==5 || $type==6)
{
?>
<div class="refine">
    <br> <h4>From <span style="margin-left: 35px;"> To</span></h4>
<SELECT NAME="year1" id="year1">
    <OPTION id=2 value=""> Year </option>
    <?php 
		$yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates asc";
		if($yearSql=mysql_query($yearsql))
		{
                        
                        if($_POST['year1']=='')
                        {
                            $year1=2009;
                        }
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

<SELECT NAME="year2" id="year2">
    <OPTION id=2 value=""> Year </option>
    <?php 
		$yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates asc";
                if($_POST['year2']=='')
                {
                    $year2=date("Y");
                }
		if($yearSql=mysql_query($yearsql))
		{
			While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$id = $myrow["Year"];
				$name = $myrow["Year"];
				$isselcted = ($year2 == $id) ? 'SELECTED' : '';
				echo "<OPTION id=". $id. " value='". $id."' ".$isselcted.">".$name."</OPTION>\n";
			}		
		}
	?> 
</SELECT>
    <input type="submit" name="fliter_stage" value="Go">
    </form></div>
<?php
}
?>

<div class="view-table"><div class="restable"><table class="responsive" cellpadding="0" cellspacing="0">

    <thead>
   
    <?php
    if($type==1)
    {
        ?>
    
        <tr>
            <th colspan="1" style="text-align:center">Year</th>
            <th colspan="1" style="text-align:center">No. of Deals</th>
            <th colspan="1" style="text-align:center">Amount($m)</th>
        </tr>
<?php
    }
    elseif($type==2)
    {
    ?>

   
    <tr><th rowspan="2"  style="text-align:center">Industry</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
            echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
            if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        
        ?>
    </tr>
  <?php   
    }
    elseif($type==3)
    {
        ?>
  <tr><th rowspan="2"  style="text-align:center">Stage</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
            echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
                 if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        ?>
    </tr>
    <?php
    }
    else if($type==5)
    {
        ?>
   
       <tr><th rowspan="2"  style="text-align:center">Investor</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
           echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
                if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        
        ?>
    </tr>
   <?php     
    }
    else if($type==4)
    {
        ?>
        <tr><th rowspan="2"  style="text-align:center">Range</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
            echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
                if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        ?>
    </tr>
    <?php
    }
    else if($type==6)
    {
        ?>
    <tr><th rowspan="2"  style="text-align:center">Region</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
             echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
                if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        
        ?>
    </tr>
   <?php
    }
    ?></thead>
 <?php
if($type==2)
{
    if(mysql_num_rows($resultcompany)>0)
    {
        while($rowindus = mysql_fetch_array($resultcompany))	
        {  
           $deal[$rowindus['industry']][$rowindus[1]]['dealcount']=$rowindus[2];
           $deal[$rowindus['industry']][$rowindus[1]]['sumamount']=$rowindus[3];  
        }  
    }
    else
    {
        $deal='';
    }
}
elseif($type==3)
{
    if(mysql_num_rows($resultcompany)>0)
    {
       while($rowstage = mysql_fetch_array($resultcompany))	
       {  
          $deal[$rowstage['Stage']][$rowstage[1]]['dealcount']=$rowstage[2];
          $deal[$rowstage['Stage']][$rowstage[1]]['sumamount']=$rowstage[3];  
       }
    }
    else
    {
        $deal='';
    }
}
else if($type==5)
{
    if(mysql_num_rows($resultcompany)>0)
    {
       while($rowinvestor = mysql_fetch_array($resultcompany))	
       {  
          $deal[$rowinvestor['InvestorTypeName']][$rowinvestor[1]]['dealcount']=$rowinvestor[2];
          $deal[$rowinvestor['InvestorTypeName']][$rowinvestor[1]]['sumamount']=$rowinvestor[3];  
       }
     }
    else
    {
        $deal='';
    }
}
else if($type==6)
{
    if(mysql_num_rows($resultcompany)>0)
    {
       while($rowregion = mysql_fetch_array($resultcompany))	
       {  
          $deal[$rowregion['Region']][$rowregion[1]]['dealcount']=$rowregion[2];
          $deal[$rowregion['Region']][$rowregion[1]]['sumamount']=$rowregion[3];  
       }
    }
    else
    {
        $deal='';
    }
}
?>
 <tbody>
     <tbody>
      <?php
    if($type==1)
    {
        if(mysql_num_rows($resultcompany)>0)
        {
            while($rowsyear = mysql_fetch_array($resultcompany))	
            {
                    echo "<tr style=\"text-align:center;\">
                    <td>".$rowsyear[0]."</td>
                    <td>".$rowsyear[1]."</td>
                    <td>".$rowsyear[2]."</td>
                    </tr>";		                                                                           
            }
        }
        else
        {
             echo "<tr style=\"text-align:center;\">
                    No Data Found
                    </tr>";
        }
    }
    else if($type==2)
    {
         if($deal !='')
        {
            $content ='';

            foreach($deal as $industry => $values){
                $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
                $content .= '<td>'.$industry.'</td>';
                 for($i=$fixstart;$i<=$fixend;$i++){
                     $content .= "<td>".$values[$i]['dealcount']."</td>";
                     $content .= "<td>".$values[$i]['sumamount']."</td>";
                 }
                 $content.= '</tr>';
            } 
            echo $content;
        }
        else
        {
            $content ='';
            $content = '<tr style=\"\&quot;text-align:center;\&quot;\">No Data Found</tr>';
            echo $content;
        }
    }
    else if($type==3)
    {
        if($deal !='')
        {
            $content ='';

            foreach($deal as $Stage => $values){
                $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
                $content .= '<td>'.$Stage.'</td>';
                 for($i=$fixstart;$i<=$fixend;$i++){
                     $content .= "<td>".$values[$i]['dealcount']."</td>";
                     $content .= "<td>".$values[$i]['sumamount']."</td>";
                 }
                 $content.= '</tr>';
            } 
            echo $content;
        }
        else
        {
            $content ='';
            $content = '<tr style=\"\&quot;text-align:center;\&quot;\">No Data Found</tr>';
            echo $content;
        }
    }
    else if($type == 4 &&  !$_POST)
    {
        if($deal!='')
        {
            $content ='';
            foreach($deal as $range => $values){
                $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
                $content .= '<td>'.$range.'</td>';
                 for($i=$fixstart;$i<=$fixend;$i++){
                     $content .= "<td>".$values[$i]['dealcount']."</td>";
                     $content .= "<td>".$values[$i]['sumamount']."</td>";
                 }
                 $content.= '</tr>';
            } 

            echo $content;
        }
        else
        {
            $content ='';
            $content = '<tr style=\"\&quot;text-align:center;\&quot;\">No Data Found</tr>';
            echo $content;
        }
    }
    else if($type==5)
    {
        if($deal !='')
        {
            $content ='';

           foreach($deal as $InvestorTypeName => $values){
               $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
               $content .= '<td>'.$InvestorTypeName.'</td>';
                for($i=$fixstart;$i<=$fixend;$i++){
                    $content .= "<td>".$values[$i]['dealcount']."</td>";
                    $content .= "<td>".$values[$i]['sumamount']."</td>";
                }
                $content.= '</tr>';
           } 

           echo $content; 
        }
        else
        {
            $content ='';
            $content = '<tr style=\"\&quot;text-align:center;\&quot;\">No Data Found</tr>';
            echo $content;
        }
    }
    else if($type==6)
    {
        if($deal !='')
        {
            $content ='';

            foreach($deal as $range => $values){
                $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
                $content .= '<td>'.$range.'</td>';
                 for($i=$fixstart;$i<=$fixend;$i++){
                     $content .= "<td>".$values[$i]['dealcount']."</td>";
                     $content .= "<td>".$values[$i]['sumamount']."</td>";
                 }
                 $content.= '</tr>';
            } 

            echo $content;
        }
        else
        {
            $content ='';
            $content = '<tr style=\"\&quot;text-align:center;\&quot;\">No Data Found</tr>';
            echo $content;
        }
    }
    if($type == 4 && $_POST)
    {
        if($deal!='')
        {
            $content ='';

            foreach($deal as $range => $values){
                $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
                $content .= '<td>'.$range.'</td>';
                 for($i=$fixstart;$i<=$fixend;$i++){
                     $content .= "<td>".$values[$i]['dealcount']."</td>";
                     $content .= "<td>".$values[$i]['sumamount']."</td>";
                 }
                 $content.= '</tr>';
            } 

            echo $content;
        }
        else
        {
            $content ='';
            $content = '<tr style=\"\&quot;text-align:center;\&quot;\">No Data Found</tr>';
            echo $content;
        }
    }
    ?>
    </tbody>

        </table></div>
 
          
</div>
    		
			<?php
					}
				} 
			?>
             <div class="holder"></div>
            <div>&nbsp;</div>
            <div>&nbsp;</div>
            </form>
            <form name="pelisting"  method="post" action="exportinvdeals.php">
                 <?php if($_POST) { ?>
                        <input type="hidden" name="txtsearchon" value="1" >
           	        <input type="hidden" name="txttitle" value=<?php echo $VCFlagValue; ?> >
        	        <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
			<input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
			<input type="hidden" name="txthideindustry" value=<?php echo ($industryvalue)?$industryvalue:""; ?> >
			<input type="hidden" name="txthideindustryid" value=<?php echo $industry; ?> >
			<input type="hidden" name="txthidestage" value=<?php echo $stagevaluetext; ?> >
			<input type="hidden" name="txthidestageid" value=<?php echo $stageidvalue; ?> >
                        <input type="hidden" name="txthidecomptype" value=<?php echo $companyType; ?> >
                        <input type="hidden" name="txthidedebt_equity" value=<?php echo $debt_equity; ?> >
			<input type="hidden" name="txthideinvtype" value=<?php echo $invtypevalue; ?> >
			<input type="hidden" name="txthideinvtypeid" value=<?php echo $investorType; ?> >
			<input type="hidden" name="txthideregionvalue" value=<?php echo $regionvalue; ?> >
			<input type="hidden" name="txthideregionid" value=<?php echo $regionId; ?> >

			<input type="hidden" name="txthiderange" value=<?php echo $startRangeValue; ?>-<?php echo $endRangeValue; ?> >
			<input type="hidden" name="txthiderangeStartValue" value=<?php echo $startRangeValue; ?>>
			<input type="hidden" name="txthiderangeEndValue" value=<?php echo $endRangeValue; ?> >

			<input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
			<input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
			<input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >

			<input type="hidden" name="txthideinvestor" value=<?php echo $keywordhidden; ?> >
			<input type="hidden" name="txthidecompany" value=<?php echo $companysearchhidden; ?> >
			<input type="hidden" name="txthideadvisor_legal" value=<?php echo $advisorsearchhidden_legal; ?> >
			<input type="hidden" name="txthideadvisor_trans" value=<?php echo $advisorsearchhidden_trans; ?> >
			<input type="hidden" name="txthidesearchallfield" value=<?php echo $searchallfieldhidden; ?> >
                        
                 <?php } else { ?> 
                        
                                               
                        <input type="hidden" name="txtsearchon" value="1" >
           	        <input type="hidden" name="txttitle" value=<?php echo $VCFlagValue; ?> >
        	        <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
			<input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
			<input type="hidden" name="txthideindustry" value="">
			<input type="hidden" name="txthideindustryid" value="--">
			<input type="hidden" name="txthidestage" value="">
			<input type="hidden" name="txthidestageid" value="">
                        <input type="hidden" name="txthidecomptype" value="--">
                        <input type="hidden" name="txthidedebt_equity" value="--">
			<input type="hidden" name="txthideinvtype" value="">
			<input type="hidden" name="txthideinvtypeid" value="--">
			<input type="hidden" name="txthideregionvalue" value="">
			<input type="hidden" name="txthideregionid" value="--">

			<input type="hidden" name="txthiderange" value="-----">
			<input type="hidden" name="txthiderangeStartValue" value="--">
			<input type="hidden" name="txthiderangeEndValue" value="--">

                        <input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
			<input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
			<input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >

			<input type="hidden" name="txthideinvestor" value="">
			<input type="hidden" name="txthidecompany" value="">
			<input type="hidden" name="txthideadvisor_legal" value="">
			<input type="hidden" name="txthideadvisor_trans" value="">
			<input type="hidden" name="txthidesearchallfield" value="">
                        
                        
                 <?php } ?>
						
                        
                        
                        
            <?php

				if($studentOption==1)

				{

			?>

					

					<div id="headingtextproboldbcolor">&nbsp; No. of Deals  - <?php echo $totalInv; ?> 	Amount (US$ M)

					<?php echo $totalAmount; ?>  <br /></div>

			<?php



			if($exportToExcel==1 )

			{

                        ?>

                          <span>

			        To Export the above deals into a Spreadsheet,&nbsp;<input type="submit"  value="Clik Here" name="showdeals">

			        </span>

			<?php

			}

		}

		else

		{



				if($exportToExcel==1)

				{

				?>

					<!--div id="headingtextproboldbcolor">&nbsp; No. of Deals  - <?php echo $totalInv; ?> Amount (US$ M)

				<?php echo $totalAmount; ?> <br /></div-->



				<?php

				}



				else

				{

				?>

					<div id="headingtextproboldbcolor">&nbsp;No. of Deals - XX &nbsp;&nbsp;&nbsp;&nbsp;Value (US$ M) - YYY <br />Aggregate data for each search result is displayed here for Paid Subscribers <br /></div>



				<?php

				}



					if(($totalInv>0) &&  ($exportToExcel==1))

					{

				?>

						<span>

								To Export the above deals into a Spreadsheet,&nbsp;<input type="submit"  value="Click Here" name="showdeals">

						</span>

				<?php

					}

					elseif(($totalInv<=0) &&  ($exportToExcel==1))

					{

					}

					elseif(($totalInv>0) && ($exportToExcel==0))

					{

				?>
                		<div>

						<span>

						<b>Note:</b> Only paid subscribers will be able to export data on to Excel.

						<a target="_blank" href="<?php echo $samplexls;?> "><u>Click Here</u> </a> for a sample spreadsheet containing PE investments

						</span>
                        </div>



				<?php



					}

		}

				?>

			
            
            
     
    </div>

</td>

</tr>
</table>
 
</div>
<div class=""></div>

</div>
</form>
            <script type="text/javascript">
                $("a.postlink").click(function(){
                  
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    
                });
                function resetinput(fieldname)
                {
                    
                  $("#resetfield").val(fieldname);
                  $("#pesearch").submit();
                    return false;
                }
            </script>
</body>
</html>

<?php
	function returnMonthname($mth)
		{
			if($mth==1)
				return "Jan";
			elseif($mth==2)
				return "Feb";
			elseif($mth==3)
				return "Mar";
			elseif($mth==4)
				return "Apr";
			elseif($mth==5)
				return "May";
			elseif($mth==6)
				return "Jun";
			elseif($mth==7)
				return "Jul";
			elseif($mth==8)
				return "Aug";
			elseif($mth==9)
				return "Sep";
			elseif($mth==10)
				return "Oct";
			elseif($mth==11)
				return "Nov";
			elseif($mth==12)
				return "Dec";
	}
function writeSql_for_no_records($sqlqry,$mailid)
 {
 $write_filename="pe_query_no_records.txt";
 //echo "<Br>***".$sqlqry;
					$schema_insert="";
					//TRYING TO WRIRE IN EXCEL
								 //define separator (defines columns in excel & tabs in word)
									 $sep = "\t"; //tabbed character
									 $cr = "\n"; //new line

									 //start of printing column names as names of MySQL fields

										print("\n");
										 print("\n");
									 //end of printing column names
									 		$schema_insert .=$cr;
									 		$schema_insert .=$mailid.$sep;
											$schema_insert .=$sqlqry.$sep;
										        $schema_insert = str_replace($sep."$", "", $schema_insert);
									    $schema_insert .= ""."\n";

									 		if (file_exists($write_filename))
											{
												//echo "<br>break 1--" .$file;
												 $fp = fopen($write_filename,"a+"); // $fp is now the file pointer to file
													 if($fp)
													 {//echo "<Br>-- ".$schema_insert;
														fwrite($fp,$schema_insert);    //    Write information to the file
														  fclose($fp);  //    Close the file
														// echo "File saved successfully";
													 }
													 else
														{
														echo "Error saving file!"; }
											}

							         print "\n";

 }
    }

    ?>
