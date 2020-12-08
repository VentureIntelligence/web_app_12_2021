<?php
            $companyId=632270771;
            $compId=0;
            require_once("../dbconnectvi.php");
            $Db = new dbInvestments();
            include ('checklogin.php');
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
             $getyear = $_REQUEST['y'];
       $getindus = $_REQUEST['i'];
       $getstage = $_REQUEST['s'];
       $getinv = $_REQUEST['inv'];
       $getreg = $_REQUEST['reg'];
       $getrg = $_REQUEST['rg'];
       
        if($getyear !='')
        {
            $getdt1 = $getyear.'-01-01';
            $getdt2 = $getyear.'-12-31';
            //$getdate=" dates between '" . $getdt1. "' and '" . $getdt2 . "'";
        }
        if($getindus !='')
        { 
            $isql="select industryid,industry from industry where industry='".$getindus."'" ;
            $irs=mysql_query($isql);
            $irow=mysql_fetch_array($irs);
            $geti = $irow['industryid'];
            $getind=" and pec.industry=".$geti;
        }
         if($getstage !='')
        { 
            $ssql="select StageId,Stage from stage where Stage='".$getstage."'" ;
            $srs=mysql_query($ssql);
            $srow=mysql_fetch_array($srs);
            $gets = $srow['StageId'];
            $getst=" and pe.StageId=" .$gets;
        }
        if($getinv !='')
        {
            $invsql = "select InvestorType,InvestorTypeName from investortype where Hide=0 and InvestorTypeName='".$getinv."'" ;
            $invrs = mysql_query($invsql);
            $invrow=mysql_fetch_array($invrs);
            $getinv = $invrow['InvestorType'];
            $getinvest = " and pe.InvestorType = '".$getinv ."'";
        }
        if($getreg!='')
        {
            if($getreg =='empty')
            {
                $getreg='';
            }
            else
            {
                $getreg;
            }
            $regsql = "select RegionId,Region from region where Region='".$getreg."'" ;
            $regrs = mysql_query($regsql);
            $regrow=mysql_fetch_array($regrs);
            $getreg = $regrow['RegionId'];
            $getregion = " and pec.RegionId  =".$getreg." and pec.RegionId IS NOT NULL";
        }
        if($getrg!='')
        {
            if($getrg == '200+')
            {
                $getrange = " and pe.amount > 200";
            }
            else
            {
                $range = explode("-", $getrg);
                $getrange = " and pe.amount > ".$range[0]." and pe.amount <= ".$range[1]."";
            }
           
        }
            $industry=$_POST['industry'];
            $investorType=$_POST['invType'];
            $exitstatusvalue=$_POST['exitstatus'];
          // echo "<br>___".$exitstatusvalue;
            $investorSale=$_POST['invSale'];

            $txtfrm=$_POST['txtmultipleReturnFrom'];
            $txtto=$_POST['txtmultipleReturnTo'];
            //  echo "<bR>***". $txtto;
            //echo "<br>--" .$txtfrm ."-" .$txtto;
            $whereind="";
            $whereinvType="";
            $whereinvestorSale="";
            $wheredates="";
            $wheredates1="";
            $whereexitstatus="";
            $whereReturnMultiple="";

            $month1=($_POST['month1']) ?  $_POST['month1'] : date('n', strtotime(date('Y-m')." -2	 month")); ;
            $year1 = ($_POST['year1']) ?  $_POST['year1'] : date('Y');
            $month2=($_POST['month2']) ?  $_POST['month2'] : date('n');
            $year2 = ($_POST['year2']) ?  $_POST['year2'] : date('Y');

            $notable=false;
            $vcflagValue=$_POST['txtvcFlagValue'];

            $searchallfield=$_POST['searchallfield'];
            $searchallfieldhidden=ereg_replace(" ","-",$searchallfield);

            //	echo "<br>FLAG VALIE--" .$vcflagValue;
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
             //echo "<br> InvestorType=". $investorType;
            //echo "<br>Investor search*- ". $keyword ;
            /*echo "<br>Company search*- " .$companysearch;
            echo "<br>Advisor search*- " .$advisorsearch;
            echo "<br>Industry*- " .$industry;
            echo "<br>Dates- " .$month1 ." ** " .$year1. " ** " .$month2. " ** " .$year2 ; */


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

		$datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
		$splityear1=(substr($year1,2));
		$splityear2=(substr($year2,2));

		if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
		{	$datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
			$datevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
                        $dt1 = $year1."-".$month1."-01";
                        $dt2 = $year2."-".$month2."-01";
                        $wheredates1= "";
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

              //  if ((trim($keyword)=="") && (trim($companysearch)=="")  && ($searchallfield=="") && ($industry =="--") && ($investorType == "--") && ($exitstatusvalue=="--") && ($investorSale == "--")&& ($month1 == "--")  && ($year1 == "--") && ($month2 == "--") && ($year2 == "--")  )
		 if($getyear !='' || $getindus !='' || $getstage !='' || $getinv !='' || $getreg!='' || $getrg!='')
                        {
                            $companysql = "select DISTINCT pei.IPOId,pei.PECompanyID,pec.companyname,pec.industry,i.industry,
				pec.sector_business,pei.IPOSize,IPOAmount,IPOValuation,DATE_FORMAT(IPODate,'%b-%Y') as IPODate,
				pec.website,pec.city,pei.IPOId,Comment,MoreInfor,hideamount,hidemoreinfor
				from ipos as pei, industry as i,pecompanies as pec, ipo_investors as ipoinv where IPODate between '" . $getdt1. "' and '" . $getdt2 . "' AND i.industryid=pec.industry and
					pec.PEcompanyID = pei.PECompanyID  and  ipoinv.IPOId=pei.IPOId  and
					pei.Deleted=0 " .$addVCFlagqry. " order by companyname";
                                 //echo "<br>all dashboard" .$companysql;
                        }
                else if(!$_POST)	
                {
                                $iftest=1;
				$yourquery=0;
                                $dt1 = $year1."-".$month1."-01";
				$dt2 = $year2."-".$month2."-01";
				$companysql = "select DISTINCT pei.IPOId,pei.PECompanyID,pec.companyname,pec.industry,i.industry,
				pec.sector_business,pei.IPOSize,IPOAmount,IPOValuation,DATE_FORMAT(IPODate,'%b-%Y') as IPODate,
				pec.website,pec.city,pei.IPOId,Comment,MoreInfor,hideamount,hidemoreinfor
				from ipos as pei, industry as i,pecompanies as pec, ipo_investors as ipoinv where";
                                
                                if(($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                                {
                                        $qryDateTitle ="Period - ";
                                        $wheredates= " IPODate between '" . $dt1. "' and '" . $dt2 . "'";
                                }
                                if(($wheredates != "") )
                                {
                                        $companysql = $companysql . $wheredates ." and ";
                                        $aggsql = $aggsql . $wheredates ." and ";
                                        $bool=true;
                                }
                                $companysql = $companysql . "  i.industryid=pec.industry and
					pec.PEcompanyID = pei.PECompanyID  and  ipoinv.IPOId=pei.IPOId  and
					pei.Deleted=0 " .$addVCFlagqry. " order by companyname ";
                                
			}
                        elseif (($industry > 0) || ($exitstatusvalue!="--") ||  ($investorType != "--") || ($investorSale!="--" ) || (($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--")) || (($txtfrm>=0) && ($txtto>0)) )
				{
                                         $iftest=2;
					$yourquery=1;

					$dt1 = $year1."-".$month1."-01";
					$dt2 = $year2."-".$month2."-01";
					$companysql = "select DISTINCT pei.IPOId,pei.PECompanyID,pec.companyname,pec.industry,i.industry,
					pec.sector_business,pei.IPOSize,IPOAmount,IPOValuation,DATE_FORMAT(IPODate,'%b-%Y') as IPODate,
					pec.website,pec.city,pei.IPOId,Comment,MoreInfor,hideamount,hidemoreinfor
					from ipos as pei, industry as i,pecompanies as pec, ipo_investors as ipoinv where";
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
                                            if(($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                                            {
                                                    $qryDateTitle ="Period - ";
                                                    $wheredates= " IPODate between '" . $dt1. "' and '" . $dt2 . "'";
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
					if(($wheredates !== "") )
					{
						$companysql = $companysql . $wheredates ." and ";
						$aggsql = $aggsql . $wheredates ." and ";
						$bool=true;
					}
					if($whereReturnMultiple!= "")
                                        {
                                         $companysql = $companysql . $whereReturnMultiple ." and ";
                                        }
					$companysql = $companysql . "  i.industryid=pec.industry and
					pec.PEcompanyID = pei.PECompanyID  and  ipoinv.IPOId=pei.IPOId  and
					pei.Deleted=0 " .$addVCFlagqry. " order by companyname ";
				//	echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
				}
			elseif ($companysearch != "")
			{
                                 $iftest=3;
				$yourquery=1;
				$datevalueDisplay1="";
				$companysql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				pe.IPOSize,pe.IPOAmount, pe.IPOValuation, DATE_FORMAT( IPODate, '%b-%Y' ) as IPODate,
				pec.website,pec.city, pec.region, IPOId,
				Comment,MoreInfor,hideamount,hidemoreinfor FROM ipos AS pe, industry AS i,
				pecompanies AS pec
				WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID " .$wheredates1.
				" AND pe.Deleted =0 " .$addVCFlagqry. " AND ( pec.companyname LIKE '%$companysearch%'
				OR sector_business LIKE '%$companysearch%' )
				order by companyname";
			//	echo "<br>Query for company search";
		 	 //echo "<br> Company search--" .$companysql;
			}
			elseif($keyword!="")
			{
                                 $iftest=4;
				$yourquery=1;
				$datevalueDisplay1="";
				$companysql="select peinv.PECompanyId,c.companyname,c.industry,i.industry,sector_business,peinv.IPOSize,
				peinv_inv.InvestorId,peinv_inv.IPOId,inv.Investor,
				DATE_FORMAT( peinv.IPODate, '%b-%Y' )as IPODate,i.industry,hideamount
			from ipo_investors as peinv_inv,peinvestors as inv,
			ipos as peinv,pecompanies as c,industry as i
			where inv.InvestorId=peinv_inv.InvestorId and c.industry = i.industryid " .$wheredates1.
			" and peinv.IPOId=peinv_inv.IPOId and c.PECompanyId=peinv.PECompanyId  and peinv.Deleted=0
			and " .$addVCFlagqry."  inv.investor like '%$keyword%' order by companyname";
		//		echo "<br> Investor search- ".$companysql;
			}
			elseif ($searchallfield != "")
			{
                                 $iftest=5;
				$yourquery=1;
				$datevalueDisplay1="";
				$companysql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				pe.IPOSize,pe.IPOAmount, pe.IPOValuation, DATE_FORMAT( IPODate, '%b-%Y' ) as IPODate,
				pec.website,pec.city, pec.region, IPOId,
				Comment,MoreInfor,hideamount,hidemoreinfor FROM ipos AS pe, industry AS i,
				pecompanies AS pec
				WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID " .$wheredates1.
				" AND pe.Deleted =0 " .$addVCFlagqry. " AND ( pec.companyname LIKE '%$searchallfield%'
				OR sector_business LIKE '%$searchallfield%' or  MoreInfor LIKE '%$searchallfield%' or  InvestmentDeals LIKE '%$searchallfield%' )
				order by companyname";
			//	echo "<br>Query for company search";
			 //echo "<br> Company search--" .$companysql;
			}

			elseif($advisorsearch!="")
			{
                                 $iftest=6;
				$yourquery=1;
				$datevalueDisplay1="";
				$companysql="SELECT peinv.IPOId, peinv.PECompanyId, c.companyname, i.industry,
				c.sector_business,peinv.IPOSize,DATE_FORMAT( peinv.IPODate, '%b-%Y' )as IPODate,
				cia.CIAId, cia.cianame, adac.CIAId AS AcqCIAId,
				 hideamount
				FROM advisor_cias AS cia, ipos AS peinv, pecompanies AS c, industry AS i,
				peinvestments_advisorcompanies AS adac
				WHERE peinv.Deleted=0 and c.industry = i.industryid
				AND c.PECompanyId = peinv.PECompanyId " .$addVCFlagqry.
				" AND adac.CIAId=cia.CIAId and adac.PEId=peinv.IPOId and
				cia.cianame LIKE '%$advisorsearch%'
				AND c.industry !=15
				order by companyname";
				$fetchRecords=true;
				$fetchAggregate==false;
			//echo "<br> Advisor Acquirer search- ".$companysql;
			}
			
				else
				{
					echo "<br> INVALID DATES GIVEN ";
					$fetchRecords=false;
				}

    ?>

    <?php 
    $topNav = 'Deals';
    include_once('kipoheader_search.php');
    ?>




    <div id="container">
    <table cellpadding="0" cellspacing="0" width="100%">
  <td class="left-td-bg"> <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide">Slide Panel</a></div> 
 <div  id="panel">
<div class="left-box">

    <?php include_once('kiporefine.php');?>

    </td>
    <?php

            $exportToExcel=0;;
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
              // echo "<br> query final-----" .$companysql."/".$iftest;
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
               }
           ?>


    <td>
       
        </form>
    <div class="result-cnt" style="margin-bottom: 30px;">
                        <div class="result-title">

                <?php if(!$_POST)
                    {
                    if($VCFlagValue==0)
                       {
                       ?>
                               <h2><?php echo @mysql_num_rows($companyrs); ?> results for PE-backed IPO <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a></h2>
                       <?php }
                       elseif($VCFlagValue==1) {
                           ?>
                           <h2><?php echo @mysql_num_rows($companyrs); ?> results for VC-backed IPO <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a></h2>
                       <?php }
               ?>
                  <?php 
                  }
                   else 
                   {
                       if($VCFlagValue=="0")
                       {
                       ?>
                               <h2><?php echo @mysql_num_rows($companyrs); ?> results for PE-backed IPO <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a></h2>
                       <?php }
                       elseif($VCFlagValue=="1") {
                           ?>
                           <h2><?php echo @mysql_num_rows($companyrs); ?> results for VC-backed IPO <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a></h2>
                       <?php }
               ?>
            <ul>
                <?php
                // echo "<bR>--**" .$followonVCFund."adsasd".$followonVCFundText;
                 //echo $queryDisplayTitle;
                if($industry >0 )
                    echo "<li>".$industryvalue."</li>";
                if($investorType !="--" && $investorType !="")
                    echo "<li>".$invtypevalue."</li>";
                if($investorSale==1)
                        echo "<li>Investor Sale</li>";
                if($exitstatusdisplay!="")
                         echo  "<li>".$exitstatusdisplay."</li>";
                if($datevalueDisplay1!="")
                        echo "<li>".$datevalueDisplay1. "-" .$datevalueDisplay2."</li>";
                if(($txtfrm>=0) && ($txtto>0))
                        echo "<li>".$txtfrm. "-" .$txtto."</li>";
                if($keyword!=" ")
                        echo "<li>".$keyword."</li>";
                if($advisorsearch!="")
                        echo "<li>".$advisorsearch."</li>";
                if($companysearch!=" ")
                    echo "<li>".$companysearch."</li>";
                
                if($searchallfield!="")
                    echo "<li>".$searchallfield."</li>";



                
                
                
                ?>
             </ul>
             <?php } ?>
        </div>


        <?php
                if($notable==false)
                { 
        ?>
                    <div class="overview-cnt">
                      <div class="showhide-link"><a href="#" class="show_hide" rel="#slidingTable"><i></i>Trends View</a></div>

                      <div  id="slidingTable" style="display:block; overflow:hidden;">  
                       <?php
                       include_once("kipotrendview.php");
                       ?>     
                    </div>
                    </div>
                   <div class="list-tab">
                       
                       
                       
                       <ul>
                        <li class="active"><a class="postlink"   href="kipoindex.php?value=<?php echo $VCFlagValue; ?>"  id="icon-grid-view"><i></i> List  View</a></li>
                        <?php
                            $count=0;
                             While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                            {
                                    if($count == 0)
                                    {
                                             $comid = $myrow["IPOId"];
                                            $count++;
                                    }
                            }
                            ?>
                        <li><a id="icon-detailed-view" class="postlink" href="ipodealdetails.php?value=<?php echo $comid;?>/<?php echo $VCFlagValue;?>/<?php echo $searchallfield;?>" ><i></i> Detailed  View</a></li> 
                        </ul></div>	
        <form name="pelisting"  method="post" action="exportipodeals.php">
        <?php if($_POST) { ?>
        
        <input type="hidden" name="txtsearchon" value="2" >
        <input type="hidden" name="txttitle" value=<?php echo $vcflagValue; ?> >
        <input type="hidden" name="txthidename" value=<?php echo $UserNames; ?> >
        <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
        <input type="hidden" name="txthideindustry" value=<?php echo $industryvalue; ?> >
        <input type="hidden" name="txthideindustryid" value=<?php echo $industry; ?> >
        <input type="hidden" name="txthideinvtype" value=<?php echo $invtypevalue; ?> >
        <input type="hidden" name="txthideinvtypeid" value=<?php echo $investorType; ?> >
        <input type="hidden" name="txthideexitstatusvalue" value=<?php echo $exitstatusvalue; ?> >
        <input type="hidden" name="txthideinvestorSale" value=<?php echo $investorSale; ?> >
        <input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
        <input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
        <input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >
        <input type="hidden" name="txthideReturnMultipleFrm" value=<?php echo $txtfrm; ?> >
        <input type="hidden" name="txthideReturnMultipleTo" value=<?php echo $txtto; ?> >
        <input type="hidden" name="txthideinvestor" value=<?php echo $keywordhidden; ?> >
        <input type="hidden" name="txthidecompany" value=<?php echo $companysearchhidden; ?> >
        <input type="hidden" name="txthideadvisor" value=<?php echo $advisorsearchhidden; ?> >
        <input type="hidden" name="txthidesearchallfield" value=<?php echo $searchallfieldhidden; ?> >
        
        <?php } else { ?>
        
        <input type="hidden" name="txttitle" value=<?php echo $vcflagValue; ?> >
        <input type="hidden" name="txthidename" value=<?php echo $UserNames; ?> >
        <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
        <input type="hidden" name="txthideindustry" value="">
        <input type="hidden" name="txthideindustryid" value="--">
        <input type="hidden" name="txthideinvtype" value="">
        <input type="hidden" name="txthideinvtypeid" value="--">
        <input type="hidden" name="txthideexitstatusvalue" value="--">
        <input type="hidden" name="txthideinvestorSale" value="--">
        <input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
        <input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
        <input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >
        <input type="hidden" name="txthideReturnMultipleFrm" value="">
        <input type="hidden" name="txthideReturnMultipleTo" value="">
        <input type="hidden" name="txthideinvestor" value="">
        <input type="hidden" name="txthidecompany" value="">
        <input type="hidden" name="txthideadvisor" value="">
        <input type="hidden" name="txthidesearchallfield" value="">
        
        <?php } ?>
        
        <div class="view-table">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
              <thead><tr>
                <th>Company</th>
                <th>Sector</th>
                <th>Date</th>
                <th>Size(US$M)</th>
                </tr></thead>
              
              <tbody id="movies">
                     <?php
                        if ($company_cnt>0)
                          {
                             mysql_data_seek($companyrs,0);
                             While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                             {
                                    $prd=$myrow["IPODate"];
                                    if($myrow["hideamount"]==1)
                                    {
                                            $hideamount="--";
                                    }
                                    else
                                    {
                                            $hideamount=$myrow[6];
                                    }
                                    if(trim($myrow["sector_business"])=="")
                                            $showindsec=$myrow["industry"];
                                    else
                                            $showindsec=$myrow["sector_business"];
                           ?>           
                          <tr>
                                <td ><a class="postlink" href="kipodealdetails.php?value=<?php echo $myrow["IPOId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?>"><?php echo trim($myrow["companyname"]);?> </a> <?php echo $closeBracket ; ?><?php echo $closeDebtBracket;?></td>
                                <td><?php echo trim($showindsec); ?></td>
                                <td><?php echo $prd; ?></td>
                                <td align=right><?php echo $hideamount; ?>&nbsp;</td>
                          </tr>
                        <?php
                            $industryAdded = $myrow[2];
                            $totalInv=$totalInv+1;
                            $totalAmount=$totalAmount+$myrow[6];
                            }
                         } ?>

            </tbody>
            </table>

    </div>  
    <div class="holder"></div>
    <div>&nbsp;</div>
    <div>&nbsp;</div>			
        <?php
                        }?>
    
    <?php
		if($studentOption==1)
		{
		?>
		<div id="headingtextproboldbcolor">&nbsp; No. of Deals  - <?php echo $totalInv; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;
									Amount (US$ M)
					<?php echo $totalAmount; ?> <br /></div>
				<?php
			
			if($exportToExcel==1)
			{
                        ?>
                          <span style="float:left" class="one">
			        To Export the above deals into a Spreadsheet,&nbsp;<input type="submit"  value="Click Here" name="showdeals">
			        </span>
			<?php
			}
		}
		else
		{
				if($exportToExcel==1)
				{
				?>
					<div id="headingtextproboldbcolor">&nbsp; No. of Deals  - <?php echo $totalInv; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;
					Amount (US$ Million)
					<?php echo $totalAmount; ?> <br /></div>
				<?php
				}
				else
				{
				?>
					<div id="headingtextproboldbcolor">&nbsp;No. of Deals - XX &nbsp;&nbsp;&nbsp;&nbsp;Value (US$ M) - YYY <br />Aggregate data for each search result is displayed here for Paid Subscribers <br /></div>

				<?php
				}
		?>

		<?php
					if(($totalInv>0) &&  ($exportToExcel==1))
					{
		?>
		<span style="float:left" class="one">
			To Export the above deals into a Spreadsheet,&nbsp;<input type="submit"  value="Click Here" name="showipodeals">
		</span>
		<?php
					}

			elseif(($totalInv<=0) &&  ($exportToExcel==1))
			{
			}
			elseif(($totalInv>0) && ($exportToExcel==0))
			{
					?>
							<span style="float:left" class="one">
							<b>Note:</b> Only paid subscribers will be able to export data on to Excel.
							<a target="_blank" href="../xls/sample-pe-backed-IPOs.xls"><u>Click Here</u> </a> for a sample spreadsheet containing PE-backed IPOs
							</span>
					<?php
					}
		} //end of student if
		?>
    
    
                <?php } elseif($buttonClicked=='Aggregate')
					{

						$aggsql= $aggsql. " i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
								and  pe.Deleted=0 " .$addVCFlagqry.
									 " order by pe.IPOSize desc,IPODate desc";
							//echo "<br>Agg SQL--" .$aggsql;
							 if ($rsAgg = mysql_query($aggsql))
							 {
								$agg_cnt = mysql_num_rows($rsAgg);
							 }
							   if($agg_cnt > 0)
							   {
									 While($myrow=mysql_fetch_array($rsAgg, MYSQL_BOTH))
									   {
											$totDeals = $myrow["totaldeals"];
											$totDealsAmount = $myrow["totalamount"];
										}
							   }
							   else
							   {
									$searchTitle= $searchTitle ." -- No Investments found for this search";
							   }
							   if($industry >0)
							   {
							   	  $indSql= "select industry from industry where industryid=$industry";
							   	  if($rsInd=mysql_query($indSql))
							   	  {
								   	  while($myindRow=mysql_fetch_array($rsInd,MYSQL_BOTH))
								   	  {
								   	  	$indqryValue=$myindRow["industry"];
								   	  }
								   }
								}
								if($dealtype!= "--")
								{
									$dealSql= "select Stage from dealtypes where StageId=$stage";
								  	if($rsDealType=mysql_query($dealSql))
								  	{
									  while($mydealRow=mysql_fetch_array($rsDealType,MYSQL_BOTH))
									  {
										$stageqryValue=$mydealRow["Stage"];
									  }
								   	}
								 }
								if($range!= "--")
								{
									$rangeqryValue= $range;
								}
								if($wheredates !== "")
								{
									$dateqryValue= returnMonthname($month1) ." ".$year1 ." - ". returnMonthname($month2) ." " .$year2;
								}
								$searchsubTitle="";
								if(($industry==0) && ($wheredates==""))
								{
									$searchsubTitle= "All";
								}

					?>
						<div id="headingtextpro">
						<div id="headingtextproboldfontcolor"> <?php echo $searchAggTitle; ?> <br />  <br /> </div>
						<div id="headingtextprobold"> Search By :  <?php echo $searchsubTitle; ?> <br /> <br /></div>
					<?php
						$spacing="<Br />";
						if ($industry > 0)
						{

					?>
							<?php echo $qryIndTitle; ?><?php echo $indqryValue; ?> <?php echo $spacing; ?>
					<?php
						}

						if($wheredates!="--")
						{
					?>
							<?php echo $qryDateTitle; ?><?php echo $dateqryValue; ?> <?php echo $spacing; ?>
					<?php
						}
					?>
						<div id="headingtextprobold"> <br />No of Deals : <?php echo $totDeals; ?>  <br /> <br/></div>
						<div id="headingtextprobold"> Value (US $M) : <?php echo $totDealsAmount; ?>   <br /></div>
						</div>
					<?php
					} 
        ?>
  
    




    </div>

    </td>

    </tr>
    </table>

    </div>
     <div class=" " ></div>

    </div>
    </form>
        <script type="text/javascript">
                $("a.postlink").click(function(){
                  
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    
                });
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


    ?>
