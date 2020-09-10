<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
        include('checklogin.php');
        $mailurl= curPageURL();

	$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';

	//$SelCompRef=$value;
        $strvalue = explode("/", $value);
        $SelCompRef=$strvalue[0];
        $flagvalue=$strvalue[1];
        $vcflagValue=$strvalue[1];
        $searchstring=$strvalue[2];
        $dealvalue=$strvalue[2];
        if($flagvalue=="0-0")
        {
                $videalPageName="PEMa";
                 $pageTitle="PE Exits-M&A";
                 $pageTitlemail="PE Exits-MandA";
        }
        elseif($flagvalue=="1-0")
        {
               $videalPageName="VCMa";
               $pageTitle="VC Exits-M&A";
               $pageTitlemail="VC Exits-MandA";
        }
        elseif($flagvalue=="0-1")
        {
                $videalPageName="PMS";
               $pageTitle=" Exit Via Public Market Sales ";
               $pageTitlemail="Public Market Sales-MandA";
        }    

        $lgDealCompId = $_SESSION['DcompanyId'];
        $usrRgsql = "SELECT * FROM `dealcompanies` WHERE `DCompId`='".$lgDealCompId."'";
        $usrRgres = mysql_query($usrRgsql) or die(mysql_error());
        $usrRgs = mysql_fetch_array($usrRgres);

        if($usrRgs['PEMa'] == 0){
            $accesserror = 1;
        } else if($usrRgs['VCMa'] == 0){
            $accesserror = 1;
        }
        
  	$sql="SELECT pe.PECompanyId, pec.companyname, pec.industry as industryId, i.industry, pec.sector_business,
				 DealAmount, DATE_FORMAT( DealDate, '%M-%Y' ) as dt, pec.website,
				 pe.MandAId,pe.Comment,MoreInfor,hideamount,hidemoreinfor,
				pe.DealTypeId,dt.DealType,pe.InvestmentDeals,pe.Link,pe.EstimatedIRR,pe.MoreInfoReturns,it.InvestorTypeName,
				pe.uploadfilename,pe.source,pe.Valuation,pe.FinLink,pe.Company_Valuation,pe.Revenue_Multiple,pe.EBITDA_Multiple,pe.PAT_Multiple,pe.ExitStatus
				 		 FROM manda AS pe, industry AS i, pecompanies AS pec,
						 dealtypes as dt,investortype as it
					  	 WHERE  i.industryid=pec.industry
						 AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.MandAId=$SelCompRef
						 and dt.DealTypeId=pe.DealTypeId and it.InvestorType=pe.InvestorType";
	//echo "<br>".$sql;

		$AcquirerSql= "select peinv.MandAId,peinv.AcquirerId,ac.Acquirer from manda as peinv,acquirers as ac
		where peinv.MandAId=$SelCompRef and ac.AcquirerId=peinv.AcquirerId";

		$investorSql="select peinv.MandAId,peinv.InvestorId,inv.Investor,peinv.MultipleReturn,InvMoreInfo from manda_investors as peinv,
		peinvestors as inv where peinv.MandAId=$SelCompRef and inv.InvestorId=peinv.InvestorId";
		//echo "<br>".$investorSql;


	$advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame,AdvisorType from peinvestments_advisorcompanies as advcomp,
	advisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
	//echo "<Br>".$advcompanysql;

	$adacquirersql="select advinv.PEId,advinv.CIAId,cia.cianame,AdvisorType from peinvestments_advisoracquirer as advinv,
	advisor_cias as cia where advinv.PEId=$SelCompRef and advinv.CIAId=cia.CIAId";
	//echo "<Br>".$adacquirersql;
        
                $notable=false;
                $VCFlagValueString = isset($_REQUEST['value']) ? $_REQUEST['value'] : '0-1';
                $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 1;
                $VCFlagValue_exit = explode("-", $VCFlagValueString);
                $vcflagValues=$VCFlagValue_exit[0];
                $hide_pms=$VCFlagValue_exit[1];
                $getyear = $_REQUEST['y'];
                $getindus = $_REQUEST['i'];
                $getstage = $_REQUEST['s'];
                $getinv = $_REQUEST['inv'];
                $getreg = $_REQUEST['reg'];
                $getrg = $_REQUEST['rg'];
                  $resetfield=$_POST['resetfield'];
       if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {   
           // echo "1";
            if($getyear!="")
            {
                $month1= 01;
                $year1 = $getyear;
                $month2= 12;
                $year2 = $getyear;
                $fixstart=$year1;
                $startyear =  $fixstart."-".$month1."-01";
                $fixend=$year2;
                $endyear =  $fixend."-".$month2."-31";
            }
            else if($getsy !='' && $getey !='')
            {
                $month1= 01;
                $year1 = $getsy;
                $month2= 12;
                $year2 = $getey;
                $fixstart=$year1;
                $startyear =  $fixstart."-".$month1."-01";
                $fixend=$year2;
                $endyear =  $fixend."-".$month2."-31";
                //$getdate=" dates between '" . $getdt1. "' and '" . $getdt2 . "'";
            }
            else
            {
                // $month1= date('n', strtotime(date('Y-m')." -2   month")); 
                // $year1 = date('Y');
                // $month2= date('n');
                // $year2 = date('Y'); 
                // if($type==1)
                // {
                //     $fixstart=1998;
                //     $startyear =  $fixstart."-01-01";
                //     $fixend=date("Y");
                //     $endyear = $endyear = date("Y-m-d");
                // }
                // else 
                // {
                //     $fixstart=2009;
                //     $startyear =  $fixstart."-01-01";
                //     $fixend=date("Y");
                //     $endyear = date("Y-m-d");
                //  }

                if($type == 1)
                {
                    $month1= date('n');
                    $year1 = date('Y', strtotime(date('Y')." -1  Year"));
                    $month2= date('n');
                    $year2 = date('Y');
                    $fixstart=date('Y', strtotime(date('Y')." -1  Year"));
                    $startyear =  $fixstart."-".$month1."-01";
                    $fixend=date("Y");
                    $endyear = date("Y-m-d");
                }
                else 
                {
                   
                    $month1= date('n');
                    $year1 = date('Y', strtotime(date('Y')." -1  Year"));
                    $month2= date('n');
                    $year2 = date('Y');
                    $fixstart=date('Y', strtotime(date('Y')." -1  Year"));
                    $startyear =  $fixstart."-".$month1."-01";
                    $fixend=date("Y");
                    $endyear = date("Y-m-d"); 
                }

            }
            
            
            
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            
            if($resetfield=="period")
            {
             $month1= date('n', strtotime(date('Y-m')." -2   month")); 
             $year1 = date('Y');
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
            }elseif (($resetfield=="searchallfield")||($resetfield=="investorsearch")||($resetfield=="companysearch")||($resetfield=="acquirersearch")||($resetfield=="advisorsearch_legal")||($resetfield=="advisorsearch_trans"))
            {
             $month1= date('n', strtotime(date('Y-m')." -2   month")); 
             $year1 = date('Y');
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
             $_POST['searchallfield']="";
            }
            //else if(trim($_POST['searchallfield'])!="")
            else if(trim($_POST['searchallfield'])!="" || trim($_POST['investorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['acquirersearch'])!="" || trim($_POST['advisorsearch_legal'])!="" || trim($_POST['advisorsearch_trans'])!="" ){
             $month1=01; 
             $year1 = 1998;
             $month2= date('n');
             $year2 = date('Y');
            }
            else
            {
             $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n', strtotime(date('Y-m')." -2	 month"));
             $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y');
             $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
             $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
            }
            
            $fixstart=$year1;
            $startyear =  $fixstart."-".$month1."-01";
            $fixend=$year2;
            $endyear =  $fixend."-".$month2."-31";
            
        }
        
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
                if($vcflagValues==1)
                {
                    $addVCFlagqry = " and VCFlag=1 ";
                    $searchTitle = "List of VC Exits - M&A";
                    $searchAggTitle = "Aggregate Data - VC Exits - M&A";
                }
                else
                {
                    $addVCFlagqry = "";
                    $searchTitle = "List of PE Exits - M&A";
                    $searchAggTitle = "Aggregate Data - PE Exits - M&A";
                }

                if($hide_pms==0)
                { $var_hideforexit=0;
                $samplexls="../sample-exits-via-m&a.xls";
                }
                elseif($hide_pms==1)
                { $var_hideforexit=1;
                $searchTitle = "List of Public Market Sales - Exits";
                $samplexls="../sample-exits-via-m&a(publicmarketsales).xls";
                }
                
                 
                
                
                $addhide_pms_qry=" and pe.DealTypeId= dt.DealTypeId and dt.hide_for_exit=".$var_hideforexit;
                //echo "<br>1 --". $addhide_pms_qry;
                                            $buttonClicked=$_POST['hiddenbutton'];
                                            //echo "<br>--" .$buttonClicked;
                                            //$fetchRecords=true;
                $aggsql="";
                $totalDisplay="";
                $resetfield=$_POST['resetfield'];

                if($resetfield=="acquirersearch")
                { 
                $_POST['acquirersearch']="";
                $acquirersearch="";
                }
                else 
                {
                $acquirersearch=trim($_POST['acquirersearch']);
                }

                if($resetfield=="companysearch")
                { 
                 $_POST['companysearch']="";
                 $companysearch="";
                }
                else 
                {
                 $companysearch=trim($_POST['companysearch']);
                }
                if($companysearch!=="")
                {
                    $splitStringCompany=explode(" ", trim($companysearch));
                    $splitString1Company=$splitStringCompany[0];
                    $splitString2Company=$splitStringCompany[1];
                    $stringToHideCompany=$splitString1Company. "+" .$splitString2Company;
                }

                if($resetfield=="investorsearch")
                { 
                 $_POST['investorsearch']="";
                 $investorsearch="";
                }
                else 
                {
                 $investorsearch=trim($_POST['investorsearch']);
                }
                if($investorsearch!=="")
                {
                    $splitStringInvestor=explode(" ", trim($investorsearch));
                    $splitString1Investor=$splitStringInvestor[0];
                    $splitString2Investor=$splitStringInvestor[1];
                    $stringToHideInvestor=$splitString1Investor. "+" .$splitString2Investor;
                }
                 if($resetfield=="searchallfield")
                { 
                 $_POST['searchallfield']="";
                 $searchallfield="";
                }
                else 
                {
                 $searchallfield=trim($_POST['searchallfield']);
                }
                $searchallfieldhidden=ereg_replace(" ","-",trim($searchallfield));

                
                if($resetfield=="advisorsearch_legal")
                { 
                 $_POST['advisorsearch_legal']="";
                  $advisorsearchstring_legal="";
                }
                else 
                {
                 $advisorsearchstring_legal=$_POST['advisorsearch_legal'];
                }
                $advisorsearchhidden_legal=ereg_replace(" ","_",$advisorsearchstring_legal);

                 if($resetfield=="advisorsearch_trans")
                { 
                 $_POST['advisorsearch_trans']="";
                  $advisorsearchstring_trans="";
                }
                else 
                {
                 $advisorsearchstring_trans=$_POST['advisorsearch_trans'];
                }
                $advisorsearchhidden_trans=ereg_replace(" ","_",$advisorsearchstring_trans);

                if($resetfield=="industry")
                { 
                 $_POST['industry']="";
                 $industry="";
                }
                else 
                {
                 $industry=trim($_POST['industry']);
                }
                
                 if($resetfield=="dealtype")
                { 
                 $_POST['dealtype']="";
                 $dealtype="--";
                }
                else 
                {
                 $dealtype=trim($_POST['dealtype']);
                }
                
               
                if($resetfield=="invType")
                { 
                 $_POST['invType']="";
                 $investorType="";
                }
                else 
                {
                 $investorType=trim($_POST['invType']);
                }

                if($resetfield=="exitstatus")
                { 
                 $_POST['exitstatus']="";
                 $exitstatusvalue="";
                }
                else 
                {
                 $exitstatusvalue=trim($_POST['exitstatus']);
                }
                
                
                $startRangeValue="--";
                $endRangeValue="--";
                
                if($resetfield=="period" && !$_GET)
                { 
                $month1="--";
                $year1 = "--";
                $month2="--";
                $year2 = "--";
                $_POST['month1']=$_POST['month2']=$_POST['year1']=$_POST['year2']="";
                }
                else 
                {
                $month1=($_POST['month1']) ?  $_POST['month1'] : date('n', strtotime(date('Y-m')." -2	 month")); ;
                $year1 = ($_POST['year1']) ?  $_POST['year1'] : date('Y');
                $month2=($_POST['month2']) ?  $_POST['month2'] : date('n');
                $year2 = ($_POST['year2']) ?  $_POST['year2'] : date('Y');
                }


                if($resetfield=="returnmultiple")
                { 
                 $_POST['txtmultipleReturnFrom']="";
                 $txtfrm=""; 
                 $_POST['txtmultipleReturnTo']="";
                 $txtto="";
                }
                else 
                {
                 $txtfrm=trim($_POST['txtmultipleReturnFrom']);
                 $txtto=trim($_POST['txtmultipleReturnTo']);
                }
                $whereind="";
                $wheredealtype="";
                $wheredates="";
                $whererange="";
                $whereReturnMultiple="";
                
                $datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
                $splityear1=(substr($year1,2));
                $splityear2=(substr($year2,2));

               if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
		{	$datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
			$datevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
                        $fixstart=$year1;
                        $fixend=$year2;
                        $startyear=$year1."-".$month1."-01";
                        $endyear=$year2."-".$month2."-01";
                        $dt1 = $year1."-".$month1."-01";
                        $dt2 = $year2."-".$month2."-01";
                        $wheredates1= "";
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
                if($dealtype >0)
                    $dealtypesql= "select DealType from dealtypes where DealTypeId=$dealtype";
                elseif(($dealtype=="--") && ($hide_pms==1))
                    $dealtypesql= "select DealType from dealtypes where hide_for_exit=".$hide_pms;
                //echo "<Br>***** ".$dealtypesql;
                    if ($dealtypers = mysql_query($dealtypesql))
                    {
                            While($myrow=mysql_fetch_array($dealtypers, MYSQL_BOTH))
                            {
                                    $dealtypevalue=$myrow["DealType"];
                            }
                    }

                    //echo "<bR>%%%%%%".$dealtypevalue;
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
                //echo "<br>**".$exitstatusvalue;
                if($exitstatusvalue=="0")
                {$exitstatusdisplay1="Partial Exit"; }
                //echo "<bR>111";}
                elseif($exitstatusvalue=="1")
                {$exitstatusdisplay1="Complete Exit";}
                //echo "<bR>222";}
                elseif($exitstatusvalue=="--")
                {$exitstatusdisplay1=""; }
                //echo "<bR>333";}
                if(($startRangeValue != "--")&& ($endRangeValue != ""))
                {
                $startRangeValue=$startRangeValue;
                $endRangeValue=$endRangeValue-0.01;
                }

                            $aggsql= "select count(pe.MandAId) as totaldeals,sum(pe.DealAmount)
                                    as totalamount from manda as pe,industry as i,pecompanies as pec where";
                                   
                            //if (($acquirersearch == "") && ($companysearch=="") && ($searchallfield=="") && ($investorsearch=="") && ($advisorsearchstring_legal=="")  && ($advisorsearchstring_trans=="")&& ($industry =="--") &&  ($dealtype == "--")  && ($invType == "--")  && ($exitstatusvalue=="--") &&  ($range == "--") && ($month1 == "--")  && ($year1 == "--") && ($month2 == "--") && ($year2 == "--"))
                        if($getyear !='' || $getindus !='' || $getstage !='' || $getinv !='' || $getreg!='' || $getrg!='')
                        {
                            $companysql = "SELECT DISTINCT pe.MandAId,pe.PECompanyId, pec.companyname, pec.industry, i.industry,
                                            sector_business, pe.DealAmount, i.industry, hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period
                                            FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,manda_investors as mandainv where DealDate between '" . $getdt1. "' and '" . $getdt2 . "' AND 
                                                  i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                            and  mandainv.MandAId=pe.MandAId
                                            and pec.industry != 15 and pe.Deleted=0 " .$addVCFlagqry . $addhide_pms_qry.
                                                             " order by companyname";
                                // echo "<br>all ddddddddddddddddashboard" .$companysql;
                        }
                             
                           else if(count($_POST)==0)
                                {       
                                  // $month1=($_POST['month1']) ?  $_POST['month1'] : date('n', strtotime(date('Y-m')." -2	 month")); ;
                                  //       $year1 = ($_POST['year1']) ?  $_POST['year1'] : date('Y');
                                  //       $month2=($_POST['month2']) ?  $_POST['month2'] : date('n');
                                  //       $year2 = ($_POST['year2']) ?  $_POST['year2'] : date('Y');

                                  $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
                                        $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
                                        $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
                                        $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');


                                        $dt1 = $year1."-".$month1."-01";
                                        $dt2 = $year2."-".$month2."-01";
                                        $iftest=1;
                                      //     echo "<br>Query for all records";
                                            $yourquery=0;

                                            $dt1 = $year1."-".$month1."-01";
                                            $dt2 = $year2."-".$month2."-01";

                                            $companysql = "SELECT DISTINCT pe.MandAId,pe.PECompanyId, pec.companyname, pec.industry, i.industry,
                                            sector_business, pe.DealAmount,pe.ExitStatus, i.industry, hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period
                                            FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,manda_investors as mandainv where";

                                            if(($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                                            {
                                                    $qryDateTitle ="Period - ";
                                                    $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                                            }
                                            if(($wheredates !== "") )
                                            {
                                                    $companysql = $companysql . $wheredates ." and ";
                                                    $aggsql = $aggsql . $wheredates ." and ";
                                                    $bool=true;
                                            }
                                            $companysql = $companysql . "  i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                            and  mandainv.MandAId=pe.MandAId
                                            and pec.industry != 15 and pe.Deleted=0 " .$addVCFlagqry . $addhide_pms_qry.
                                                             " order by companyname ";
                                            $fetchRecords=true;
                                            $fetchAggregate==false;
                                            //echo "<br>all records" .$companysql;
                                    }
                                    elseif (($industry > 0) || ($dealtype != "--") || ($invType != "--") || ($exitstatusvalue!="--") || ($range != "--") || (($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--")) ||(($txtfrm>=0) && ($txtto>0)) )
                                    {   
                                       // echo "pppppppppppppppppppppppppppppppppppppppppp";
                                         $iftest=2;
                                            $yourquery=1;

                                            $dt1 = $year1."-".$month1."-01";
                                            $dt2 = $year2."-".$month2."-01";

                                            $companysql = "SELECT DISTINCT pe.MandAId,pe.PECompanyId, pec.companyname, pec.industry, i.industry,
                                            sector_business,pe.ExitStatus, pe.DealAmount, i.industry, hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period
                                            FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,manda_investors as mandainv where";

                                            if ($industry > 0)
                                            {
                                                     $iftest=$iftest.".1";
                                                    $whereind = " pec.industry='" .$industry."'"  ;
                                                    $qryIndTitle="Industry - ";
                                            }
                                            if ($dealtype!= "--" && $dealtype!='')
                                            {
                                                 $iftest=$iftest.".2";
                                                    $wheredealtype = " pe.DealTypeId ='" .$dealtype."'" ;
                                                    $qryDealTypeTitle="Deal Type - ";
                                            }
                                             if ($invType!= "--" && $invType!= "")
                                            {
                                                  $iftest=$iftest.".3";
                                                $qryInvType="Investor Type - " ;
                                                $whereInvType = " pe.InvestorType = '".$investorType."'";
                                            }
                                            if($exitstatusvalue!="--" && ($exitstatusvalue!=""))
                                            {     $iftest=$iftest.".4";
                                                $whereexitstatus=" pe.ExitStatus='".$exitstatusvalue."'" ;  }
                                            if(($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                                            {
                                                         $iftest=$iftest.".6";
                                                    $qryDateTitle ="Period - ";
                                                    $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                                            }
                                            //echo "<bR>--" .$wheredates;
                                           if(trim($txtfrm>0) && trim($txtto==""))
                                    {
                                                 $iftest=$iftest.".7";
                                           $qryReturnMultiple="Return Multiple - ";
                                           $whereReturnMultiple=" ipoinv.MultipleReturn > '" .$txtfrm ."'"   ;
                                    }
                                    elseif(trim($txtfrm=="") && trim($txtto>0))
                                    {
                                           $qryReturnMultiple="Return Multiple - ";
                                           $whereReturnMultiple=" ipoinv.MultipleReturn < '" .$txtto ."'"   ;
                                    }
                                    elseif(trim($txtfrm>  0) && trim($txtto >0))
                                    {
                                           $qryReturnMultiple="Return Multiple - ";
                                           $whereReturnMultiple=" ipoinv.MultipleReturn > '" .$txtfrm ."'"  . " and  ipoinv.MultipleReturn <'".$txtto."'" ;
                                    }


                                            if ($whereind != "")
                                            {
                                                    $companysql=$companysql . $whereind ." and ";
                                                    $aggsql=$aggsql . $whereind ." and ";
                                                    $bool=true;
                                            }
                                            if (($wheredealtype != ""))
                                            {
                                                    $companysql=$companysql . $wheredealtype . " and " ;
                                                    $aggsql=$aggsql . $wheredealtype . " and " ;
                                                    $bool=true;
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
                                            if (($whererange != "") )
                                            {
                                                    $companysql=$companysql .$whererange . " and ";
                                                    $aggsql=$aggsql .$whererange . " and ";
                                                    $bool=true;
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

                                            $companysql = $companysql . "  i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                            and  mandainv.MandAId=pe.MandAId
                                            and pec.industry != 15 and pe.Deleted=0 " .$addVCFlagqry . $addhide_pms_qry.
                                                             " order by companyname ";
                                            $fetchRecords=true;
                                            $fetchAggregate==false;
                                            //echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
                                    }
                                    elseif (trim($companysearch) != "")
                                    {
                                         $iftest=3;
                                            $yourquery=1;
                                            $datevalueDisplay1="";
                                            $companysql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business,
                                            pe.DealAmount,website, MandAId,Comment,MoreInfor,hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period FROM
                                            manda AS pe, industry AS i, pecompanies AS pec ,dealtypes dt
                                            WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID
                                            AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry . $addhide_pms_qry .
                                            " AND ( pec.companyname LIKE '%$companysearch%'
                                            OR sector_business LIKE '%$companysearch%')
                                            order by companyname";
                                            $fetchRecords=true;
                                            $fetchAggregate==false;
                                    //	echo "<br>Query for company search";
                                    // echo "<br> Company search--" .$companysql;
                                    }
                                    elseif ($searchallfield != "")
                                    {
                                         $iftest=4;
                                            $yourquery=1;
                                            $datevalueDisplay1="";
                                            $companysql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business,
                                            pe.DealAmount,website, MandAId,Comment,MoreInfoReturns,hideamount,InvestmentDeals,DATE_FORMAT(DealDate,'%b-%Y') as period FROM
                                            manda AS pe, industry AS i, pecompanies AS pec ,dealtypes as dt
                                            WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID
                                            AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry . $addhide_pms_qry.
                                            " AND ( pec.companyname LIKE '%$searchallfield%'
                                            OR sector_business LIKE '%$searchallfield%' or  MoreInfoReturns LIKE '%$searchallfield%' or  InvestmentDeals LIKE '%$searchallfield%')
                                            order by companyname";
                                            $fetchRecords=true;
                                            $fetchAggregate==false;
                                    //	echo "<br>Query for company search";
                                    // echo "<br> Company search--" .$companysql;
                                    }

                                    elseif(trim($investorsearch)!="")
                                    {
                                         $iftest=5;
                                            $yourquery=1;
                                            $datevalueDisplay1="";
                                            $companysql="select pe.PECompanyId,c.companyname,c.industry,i.industry,
                                            pe.DealAmount,pe.MandAId,peinv_inv.InvestorId,
                                            inv.Investor,hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period from
                                            manda_investors as peinv_inv,
                                            peinvestors as inv,
                                            manda as pe,
                                            pecompanies as c,industry as i,dealtypes as dt where
                                            pe.MandAId=peinv_inv.MandAId and Deleted =0 and
                                            inv.InvestorId=peinv_inv.InvestorId and c.industry = i.industryid and
                                             c.PECompanyId=pe.PECompanyId and c.industry != 15 " .$addVCFlagqry . $addhide_pms_qry.
                                            " AND inv.investor like '%$investorsearch%' order by companyname";
                                            $fetchRecords=true;
                                            $fetchAggregate==false;
                                            //echo "<br> Investor search- ".$companysql;


                                    }
                                    elseif(trim($acquirersearch)!="")
                                    {
                                         $iftest=6;
                                            $yourquery=1;
                                            $datevalueDisplay1="";
                                            $companysql="SELECT pe.MandAId,pe.PECompanyId, c.companyname, c.industry, i.industry, sector_business,
                                            pe.DealAmount, hideamount, pe.AcquirerId, ac.Acquirer,DATE_FORMAT(DealDate,'%b-%Y') as period
                                            FROM acquirers AS ac, manda AS pe, pecompanies AS c, industry AS i ,dealtypes as dt
                                            WHERE ac.AcquirerId = pe.AcquirerId
                                            AND c.industry = i.industryid
                                            AND c.PECompanyId = pe.PECompanyId and Deleted=0
                                            AND c.industry !=15 " .$addVCFlagqry . $addhide_pms_qry.
                                            " AND ac.Acquirer LIKE '%$acquirersearch%'
                                            order by companyname ";
                                            $fetchRecords=true;
                                            $fetchAggregate==false;
                                            //echo "<br> Acquirer search- ".$companysql;
                                    }
                                    elseif(trim($advisorsearchstring_legal)!="")
                                    {

                                         $iftest=7;
                                            $yourquery=1;
                                            $datevalueDisplay1="";
                                            $companysql="(select pe.MandAId,pe.PECompanyId,c.companyname,i.industry,c.sector_business,pe.DealAmount,
                                            cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,pe.AcquirerId, ac.Acquirer,hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period
                                            from manda AS pe, pecompanies AS c, industry AS i,advisor_cias AS cia,peinvestments_advisoracquirer AS adac,acquirers as ac,
                                            dealtypes as dt
                                            where
                                            Deleted=0 and c.industry=i.industryid and ac.AcquirerId=pe.AcquirerId  " .$addVCFlagqry . $addhide_pms_qry.
                                            " and c.PECompanyId=pe.PECompanyId and adac.CIAId=cia.CIAID and  AdvisorType='L' and 
                                            adac.PEId=pe.MandAId and cia.cianame LIKE '%$advisorsearchstring_legal%')
                                            UNION
                                            (SELECT pe.MandAId, pe.PECompanyId, c.companyname, i.industry, c.sector_business, pe.DealAmount, cia.CIAId,
                                            cia.cianame, adcomp.CIAId AS CompCIAId, pe.AcquirerId, ac.Acquirer,hideamount ,DATE_FORMAT(DealDate,'%b-%Y') as period
                                            FROM manda AS pe, pecompanies AS c, industry AS i, advisor_cias AS cia,
                                            peinvestments_advisorcompanies AS adcomp, acquirers AS ac ,dealtypes as dt
                                            WHERE Deleted=0 and c.industry = i.industryid
                                            AND ac.AcquirerId = pe.AcquirerId " .$addVCFlagqry . $addhide_pms_qry .
                                            " AND c.PECompanyId = pe.PECompanyId
                                            AND adcomp.CIAId = cia.CIAID  and AdvisorType='L'
                                            AND adcomp.PEId = pe.MandAId
                                            AND cianame LIKE '%$advisorsearchstring_legal%')
                                            ORDER BY companyname";
                                            $fetchRecords=true;
                                            $fetchAggregate==false;
                                    //echo "<br> Advisor Acquirer search- ".$companysql;
                                    }

                                    elseif(trim($advisorsearchstring_trans)!="")
                                    {
                                             $iftest=8;
                                            $yourquery=1;
                                            $datevalueDisplay1="";
                                            $companysql="(select pe.MandAId,pe.PECompanyId,c.companyname,i.industry,c.sector_business,pe.DealAmount,
                                            cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,pe.AcquirerId, ac.Acquirer,hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period
                                            from manda AS pe, pecompanies AS c, industry AS i,advisor_cias AS cia,peinvestments_advisoracquirer AS adac,acquirers as ac,
                                            dealtypes as dt
                                            where
                                            Deleted=0 and c.industry=i.industryid and ac.AcquirerId=pe.AcquirerId  " .$addVCFlagqry  .$addhide_pms_qry.
                                            " and c.PECompanyId=pe.PECompanyId and adac.CIAId=cia.CIAID and  AdvisorType='T' and
                                            adac.PEId=pe.MandAId and cia.cianame LIKE '%$advisorsearchstring_trans%')
                                            UNION
                                            (SELECT pe.MandAId, pe.PECompanyId, c.companyname, i.industry, c.sector_business, pe.DealAmount, cia.CIAId,
                                            cia.cianame, adcomp.CIAId AS CompCIAId, pe.AcquirerId, ac.Acquirer,hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period
                                            FROM manda AS pe, pecompanies AS c, industry AS i, advisor_cias AS cia,
                                            peinvestments_advisorcompanies AS adcomp, acquirers AS ac,dealtypes as dt
                                            WHERE Deleted=0 and c.industry = i.industryid
                                            AND ac.AcquirerId = pe.AcquirerId " .$addVCFlagqry . $addhide_pms_qry.
                                            " AND c.PECompanyId = pe.PECompanyId
                                            AND adcomp.CIAId = cia.CIAID  and AdvisorType='T'
                                            AND adcomp.PEId = pe.MandAId
                                            AND cianame LIKE '%$advisorsearchstring_trans%')
                                            ORDER BY companyname";
                                            $fetchRecords=true;
                                            $fetchAggregate==false;
                                    //echo "<br> Advisor Acquirer search- ".$companysql;
                                    }


                                    else
                                    {
                                            echo "<br> INVALID DATES GIVEN ";
                                            $fetchRecords=false;
                                            $fetchAggregate==false;
                                    }
                                     $industrysql = $industrysql_search = "select industryid,industry from industry where industryid IN (".$_SESSION['PE_industries'].")" . $hideIndustry . " order by industry";
          
    if($strvalue[3]=='Directory'){

        $dealvalue=$strvalue[2];
	$topNav = 'Directory';
	include_once('dirnew_header.php');
    }else{
        $topNav = 'Deals'; 
        include_once('tvheader_search_detail.php');
    }
?>
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr><?php
if($dealvalue==101)
{
 ?>

<td class="left-td-bg" >
    <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
    
    <div id="panel" style="display:block; overflow:visible; clear:both;"> 
<?php //include_once('newdirrefine.php');?>
        <?php
            if($VCFlagValue==0){

                $pageUrl="index.php?value=0";
                $pageTitle="VC Investment";
                $refineUrl="refine.php";
            }elseif($VCFlagValue==1){

                $pageTitle="PE Investment";
                $pageUrl="index.php?value=1";
                $refineUrl="refine.php";
            }elseif($VCFlagValue==3){

                $pageTitle="Social Venture Investment";
                $pageUrl="svindex.php?value=3";
                $refineUrl="svrefine.php";
            }elseif($VCFlagValue==4){

                $pageUrl="CleanTech Investment";
                $pageUrl="svindex.php?value=4";
                $refineUrl="svrefine.php";
            }elseif($VCFlagValue==5) {

                $pageTitle="Infrastructure Investment";
                $pageUrl="svindex.php?value=5";
                $refineUrl="svrefine.php";
            }
            include_once($refineUrl); 
            ?>

     <input type="hidden" name="resetfield" value="" id="resetfield"/>
</div>
    </div>
</td>
    <?php
}

	 //GET PREV NEXT ID
	$prevNextArr = array();
	$prevNextArr = $_SESSION['resultId'];
	
	$currentKey = array_search($SelCompRef,$prevNextArr);
	$prevKey = ($currentKey == 0) ?  '-1' : $currentKey-1; 
	$nextKey = $currentKey+1;
	 
  	if ($companyrs = mysql_query($sql))
        {      
	?>
		
                <?php
                $exportToExcel=0;
                $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
                where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
                //echo "<br>---" .$TrialSql;
                if($trialrs=mysql_query($TrialSql))
                {
                        while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                        {
                                $exportToExcel=$trialrow["TrialLogin"];
                        }
                }
                $hideamount="";
                $hidemoreinfor="";
		if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
		{
			if($myrow["hideamount"]==1)
			{
				$hideamount="--";
			}
			else
			{
				$hideamount=$myrow["DealAmount"];
			}

			if($myrow["hidemoreinfor"]==1)
			{
				$hidemoreinfor="--";
			}
			else
			{
				$hidemoreinfor=$myrow["MoreInfor"];
	      	        }

			if($hidemoreinfor!="--")
			{
				$string = $hidemoreinfor;
				/*** an array of words to highlight ***/
				$words = array($searchstring);
				//$words="warrants convertible";
				/*** highlight the words ***/
				$hidemoreinfor =  highlightWords($string, $words);
			}
			$moreinfo_returns=$myrow["MoreInfoReturns"];
                        
			if(trim($moreinfo_returns=="") || trim($moreinfo_returns==" "))
                        {
                           $moreinfo_returns="";
                        }

			$investmentdeals=$myrow["InvestmentDeals"];
			if($investmentdeals!="")
			{
				$words = array($searchstring);
				$investmentdeals =  highlightWords($investmentdeals, $words);
			}


                $col6=$myrow["Link"];
                $linkstring=str_replace('"','',$col6);
                $linkstring=explode(";",$linkstring);
                $estimatedirrvalue=$myrow['EstimatedIRR'];

                $finlink=$myrow["FinLink"];
                $valuation=$myrow["Valuation"];
		if($valuation!="")
		{
		    $valuationdata = explode("\n", $valuation);
		}

		if($myrow["Company_Valuation"]<=0)
                    $dec_company_valuation=0.00;
                else
                    $dec_company_valuation=$myrow["Company_Valuation"];
                if($myrow["Revenue_Multiple"]<=0)
                    $dec_revenue_multiple=0.00;
                else
                    $dec_revenue_multiple=$myrow["Revenue_Multiple"];

               	if($myrow["EBITDA_Multiple"]<=0)
                    $dec_ebitda_multiple=0.00;
                else
                    $dec_ebitda_multiple=$myrow["EBITDA_Multiple"];
               	if($myrow["PAT_Multiple"]<=0)
                    $dec_pat_multiple=0.00;
                else
                    $dec_pat_multiple=$myrow["PAT_Multiple"];
                    $exitstatusvalue=$myrow["ExitStatus"];

                if($exitstatusvalue==0)
                    $exitstatusdisplay="Partial";
                elseif($exitstatusvalue==1)
                    $exitstatusdisplay="Complete";
                else
                    $exitstatusdisplay="";

                $uploadname=$myrow["uploadfilename"];
                $currentdir=getcwd();
                $target = $currentdir . "../uploadmamafiles/" . $uploadname;
                $file = "../uploadmamafiles/" . $uploadname;

            if ($getAcquirerSql = mysql_query($AcquirerSql))
                    {
                        While($myAcquirerrow=mysql_fetch_array($getAcquirerSql, MYSQL_BOTH))
                            {
                                  $AcquirerDisplay=$myAcquirerrow["Acquirer"];
                                  $Acquirer=$myAcquirerrow["Acquirer"];
                                  $AcquirerId=$myAcquirerrow["AcquirerId"];
                                  $Acquirer=strtolower($Acquirer);
                                  $AcqResult=substr_count($Acquirer,$searchString);
                                  $AcqResult1=substr_count($Acquirer,$searchString1);
                                  $AcqResult2=substr_count($Acquirer,$searchString2);
                            }
                    } ?>
<td class="profile-view-left" style="width:100%;">

<div class="result-cnt">


     <?php if ($accesserror == 1){?>
            <div class="alert-note"><b style="font-size: 16px;">You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm" target="_blank">Click here</a></b></div>
        <?php
        exit; 
        } 
        ?> 

        
        <?php

            $pe_industries = explode(',', $_SESSION['PE_industries']);
            if(!in_array($myrow["industryId"],$pe_industries)){
                
                echo '<div style="font-size:20px;padding:10px 10px 10px 10px;"><b> You dont have access to this information!</b></div>';
                exit;
            } 
            
        if ($companylistrs = mysql_query($companysql))
             {
                $company_cnt = mysql_num_rows($companylistrs);
             }
             ?>
         <div class="title-links">
                                
                        <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                        <?php 

                        if(($exportToExcel==1))
                             {
                             ?>
                                  <input type="button"  id="export-btn" class="export exlexport" value="Export" name="showmandadeal">
                             <?php
                             }
                         ?>
                </div>
    
 <div class="list-tab mt-list-tab"><ul>
            <li><a class="postlink" href="mandaindex.php?value=<?php echo $flagvalue;?>"  id="icon-grid-view"><i></i> List  View</a></li>
            <li class="active"><a id="icon-detailed-view" class="postlink" href="dirmandadetails.php?value=<?php echo $SelCompRef;?>/<?php echo $flagvalue;?>/<?php echo $searchstring.'/'.$topNav;?>" ><i></i> Detail  View</a></li> 
            </ul>
        </div>   

        <div class="lb" id="popup-box">
            <div class="title">Send this to your Colleague</div>
            <form>
                <div class="entry">
                        <label> To</label>
                        <input type="text" name="toaddress" id="toaddress"  />
                </div>
                <div class="entry">
                        <h5>Subject</h5>
                        <p>Checkout this deal - <?php echo rtrim($myrow["companyname"]);?> - in Venture Intelligence</p>
                        <input type="hidden" name="subject" id="subject" value="Checkout this deal - <?php echo rtrim($myrow["companyname"]);?> - in Venture Intelligence"  />
                </div>
                <div class="entry">
                        <h5>Message</h5>
                        <p><?php  echo curPageURL(); ?>   <input type="hidden" name="message" id="message" value="<?php  echo curPageURL(); ?>" />   <input type="hidden" name="useremail" id="useremail" value="<?php echo $_SESSION['UserEmail']; ?>"  /> </p>
                </div>
                <div class="entry">
                    <input type="button" value="Submit" id="mailbtn" />
                    <input type="button" value="Cancel" id="cancelbtn" />
                </div>
                </form>
        </div>

<div class="view-detailed">
        <div class="detailed-title-links"><h2> <A  href='companydetails.php?value=<?php echo $myrow["PECompanyId"];?>/<?php echo $flagvalue;?>/<?php echo $searchstring.'/'.$topNav;?>' ><?php echo rtrim($myrow["companyname"]);?></a></h2>
             <a  class="postlink" id="previous" href="javascript:history.back(-1)">< Back</a> </div> 
        </div> 

        <div class="profilemain">
             <h2>Deal Info  </h2>
             <div class="profiletable">
                  <ul>
                    <?php if($hideamount!="") { ?><li><h4>Deal Size (US $M)</h4><p><?php echo $hideamount;?></p></li><?php } ?>
                    <?php if($myrow["DealType"]!="") { ?><li><h4>Deal Type </h4><p><?php echo $myrow["DealType"];?></p></li><?php } ?>
                    <?php if($exitstatusdisplay!="") { ?><li><h4>Exit Status</h4><p><?php echo $exitstatusdisplay ;?></p></li><?php } ?>
                    <?php if($myrow["dt"]!="") { ?><li><h4>Deal Period</h4><p><?php echo  $myrow["dt"];?></p></li><?php } ?>
                    <li><h4>Acquirer</h4>
                        <p><?php
                                if(($AcqResult==0) && ($AcqResult1==0) && ($AcqResult2==0))
                                                 echo  $AcquirerDisplay;
                                else
                                                 echo $searchStringDisplay;
                                ?>
                        </p>
                    </li>
                 </ul>
             </div>
        </div>
    
    <div class="postContainer postContent masonry-container">
        <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
            <h2>Company Info</h2>
            <table cellpadding="0" cellspacing="0" width="100%"  class="tableview">
            <tbody>
            <tr><td ><h4>Company</h4>
                    <p><A class="postlink" href='companydetails.php?value=<?php echo $myrow["PECompanyId"];?>/<?php echo $flagvalue;?>/<?php echo $searchstring.'/'.$topNav;?>' ><?php echo rtrim($myrow["companyname"]);?></a>
                    </p></td>
            </tr>
            <?php if($myrow["sector_business"]!="") { ?> <tr><td><h4>Sector </h4><p><?php echo $myrow["sector_business"];?></p></td></tr><?php } ?>
             <?php if($myrow["industry"]!="") { ?><tr><td><h4>Industry</h4><p><?php echo $myrow["industry"];?></p></td></tr><?php } ?>
             <?php if($myrow["website"]!="") { ?><tr><td><h4>Website</h4><p style="word-break: break-all;"><a  href=<?php echo $myrow["website"]; ?> target="_blank"><?php echo $myrow["website"]; ?></a></p></td></tr><?php } ?></tbody>
            </table>
        </div>
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
        <h2>Investor & Advisor Info</h2>
        <table cellpadding="0" cellspacing="0" width="100%" class="tableview">
        <tbody>
            <tr>
                <td><h4>Investors</h4><p style="word-break: break-all;">
                    <?php
				if ($getcompanyrs = mysql_query($investorSql))
				{
					$AddOtherAtLast="";
					$AddUnknowUndisclosedAtLast="";
				While($myInvrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
				{
					$Investorname=trim($myInvrow["Investor"]);
					$Investorname=strtolower($Investorname);
                        		$invResult=substr_count($Investorname,$searchString);
					$invResult1=substr_count($Investorname,$searchString1);
					$invResult2=substr_count($Investorname,$searchString2);

					if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
					{
                                          if($myInvrow["MultipleReturn"]>0)
                                          {  $bool_returnFlag=1;}
                                          $invReturnString[]=$myInvrow["Investor"].",".$myInvrow["MultipleReturn"];
                                          $invMoreInfoString[]=$myInvrow["InvMoreInfo"];
	      		?>

                    <a class="" target="_blank" href='dirdetails.php?value=<?php echo $myInvrow["InvestorId"];?>/<?php echo $flagvalue;?>/<?php echo $searchstring.'/'.$topNav;?>' ><?php echo $myInvrow["Investor"]; ?></a><br />
                    <?php
                                    }
                                    elseif(($invResult==1) || ($invResult1==1))
                                            $AddUnknowUndisclosedAtLast=$myInvrow["Investor"];
                                    elseif($invResult2==1)
                                    {
                                            $AddOtherAtLast=$myInvrow["Investor"];
                                    }
                            }
                            }
                    ?>
                         
					<?php echo $AddUnknowUndisclosedAtLast."<BR/>"; ?>
					<?php echo $AddOtherAtLast; ?>
                    </p>
                </td>
            </tr>
            <?php if($myrow["sector_business"]!="") { ?>
            <tr>
                <td><h4>Investor Type</h4><p><?php echo $myrow["InvestorTypeName"] ;?></p></td>
            </tr>
            <?php } ?>
            <?php if( mysql_num_rows(mysql_query($advcompanysql))>0){ ?>
            <tr>
                <td ><h4>Advisor - Seller</h4>
                    <p>
                   <?php
					if ($getcompanyrs = mysql_query($advcompanysql))
					{
					While($myadcomprow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
					{
				?>

                    <A class="postlink" href='diradvisor.php?value=<?php echo $myadcomprow["CIAId"];?>/<?php echo $flagvalue;?>/<?php echo $searchstring;?>' >
					<?php echo $myadcomprow["cianame"]; ?></a>  (<?php echo $myadcomprow["AdvisorType"];?>)<br />
                    <?php
                                    
                            }
                            }
                    ?>
                         
					<?php echo $AddUnknowUndisclosedAtLast."<BR/>"; ?>
					<?php echo $AddOtherAtLast; ?>
                    </p>
                </td>
            </tr>
            <?php } ?>
              <?php if( mysql_num_rows(mysql_query($adacquirersql))>0){ ?>
               <tr>
              
                <td ><h4>Advisor - Buyer</h4><p>
                   <?php
					if ($getinvestorrs = mysql_query($adacquirersql))
					{
					While($myadinvrow=mysql_fetch_array($getinvestorrs, MYSQL_BOTH))
					{
				?>

                    <A class="postlink" href='diradvisor.php?value=<?php echo $myadinvrow["CIAId"];?>/<?php echo $flagvalue;?>/<?php echo $searchstring;?>' >
					<?php echo $myadinvrow["cianame"]; ?></a>  (<?php echo $myadinvrow["AdvisorType"];?>)<br />
                    <?php
                                    
                            }
                            }
                    ?>
                         
					<?php echo $AddUnknowUndisclosedAtLast."<BR/>"; ?>
					<?php echo $AddOtherAtLast; ?>
                                        </p>
                </td>
            </tr>
              <?php } ?>
              <?php if(nl2br($hidemoreinfor)!=""){ ?>
              <tr><td ><h4>More Details</h4><p><?php print nl2br($hidemoreinfor);?></p></td></tr> <?php } ?>
           
            <?php 
       if(sizeof($linkstring)>0) 
       { 
       ?> 
        <tr>
            <td><b>Link</b><p>
         <?php  foreach ($linkstring as $linkstr)
                { 
                    if(trim($linkstr)!=="")
                    {
                ?>
          <a href=<?php echo $linkstr; ?> target="_blank"><?php print nl2br($linkstr); ?></a><br/>
          
                    <?php } } ?>
                </p>
          </td>
        </tr>
        
          <?php } ?> 
        
        
        <?php
			     if($estimatedirrvalue!="")
			     {
                             ?>
			       <tr><td><h4>Estimated Returns </h4><p><?php echo $myrow["EstimatedIRR"];?></p></tr>
			        <?php
       			    }
                         $invStringArrayCount=count($invReturnString);
                         //echo "<Br>***" .$bool_returnFlag;
			if($bool_returnFlag==1)  //to display the title ifandonlyif atleast one investor has mutliplereturn value >0
                         {
                        ?>
                           	<tr><td ><h4>&nbsp;Return Multiple</h4><p>
				
                            <?php
			      for($i=0;$i<$invStringArrayCount;$i++)
			      {
                              $invStringToSplit=$invReturnString[$i];
                               $invString  =explode(",",$invStringToSplit);
                               $investorName=$invString[0];
                               $returnValue=$invString[1];
                               $investormoreinfo=$invMoreInfoString[$i];
                           //echo "<br>****".$invMoreInfoString[$i];

                                if($returnValue>0)
                                {
                          ?>
                             	
  				<b><?php echo $investorName;?> </b>, <?php echo $returnValue;?>x
                                 <br />
                                 <?php
                                   if ($investormoreinfo!="")
                                   {
                                    echo ($investormoreinfo) ;
                                   }
                                 ?>
                                
                               <?php
                              }
                              }
                          ?>
                        </td></tr>
                  <?php
                         }
                      if(trim($moreinfo_returns!=" ") && trim($moreinfo_returns!=""))
			{
			?>
                                <tr><td ><h4>More Info (Returns) </h4><p><?php print nl2br($moreinfo_returns);?></p></td></tr>
                        <?php
                         } ?>
        
            </tbody>
            </table>
        </div>
        
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
            <h2>Investment Details</h2>
            <table cellpadding="0" cellspacing="0" width="100%" class="tableview">
            <tbody>
            <tr>
                <td colspan="2"><p><?php print nl2br($investmentdeals) ;?></p></td>
            </tr>
            </tbody>
            </table> 
        </div>
         <?php
        if($dec_company_valuation >0 || $dec_revenue_multiple >0 || $dec_ebitda_multiple >0 || $dec_pat_multiple >0 || $finlink!="" || count($valuationdata)>1 || sizeof($linkstring)>0 || $estimatedirrvalue!="" || $bool_returnFlag==1 || trim($moreinfo_returns)!="")
        {
        ?>
        
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
        <h2>Exit Details</h2>
        <table cellpadding="0" cellspacing="0" width="100%" class="tableview">
        <tbody>
        <?php
                        if($dec_company_valuation >0)
                        {
                        ?>
                        <tr><td ><h4>&nbsp;Company Valuation (INR Cr) </h4><p><?php echo $dec_company_valuation ;?></p></td></tr>
                         <?php
                        }

                        if($dec_revenue_multiple >0)
                        {
                        ?>
                        <tr><td><h4>&nbsp;Revenue Multiple </h4><p><?php echo $dec_revenue_multiple ;?></p></td></tr>
                         <?php
                        }

                        if($dec_ebitda_multiple >0)
                        {
                        ?>
                        <tr><td ><h4>&nbsp;EBITDA Multiple </h4><p><?php echo $dec_ebitda_multiple ;?></p></td></tr>
                         <?php
                        }

                        if($dec_pat_multiple >0)
                        {
                        ?>
                        <tr><td><h4>&nbsp;PAT Multiple </h4><p><?php echo $dec_pat_multiple ;?></p></td></tr>
                         <?php
                        } ?>
                        
                         <?php
            
            if(trim($myrow["Valuation"])!="")
			{
			?>
			<tr><td ><h4>&nbsp;Valuation (More Info)</h4><p>

			<?php
			    foreach($valuationdata as $valdata)
			    {
				if($valdata!="")
				{
			?>
			  <?php print nl2br($valdata);?> <br/>
			<?php
				}
			    }
                            ?></p> </td></tr> <?php
			}
                      ?>
                        
                     <?PHP  if($finlink!="")
			{
			?>
                        <tr><td ><h4>&nbsp;Link for Financials</h4><p><a target="_blank" href=<?php echo $finlink; ?> ><?php echo $finlink; ?></a></p></td>

			<?php
			}
                      if($myrow["uploadfilename"]!="")
			{

				?>

					<tr><td ><h4>&nbsp;Financials</h4>
                                        <?php
                                         if($exportToExcel==1)
                                         {
                                         ?>
                                                <p><a href=<?php echo $file;?> target="_blank" > Click here </a> </p> </td> </tr>
                                         <?php
                                         }
                                         else
                                         {
                                         ?>
                                                <p>Paid Subscribers can view a link to the co. financials here </p> </td> </tr>
                                         <?php
                                          }

			} ?>
        <?php 
       if(sizeof($linkstring)>0) 
       { 
       ?> 
        <tr>
            <td><b>Link</b><p>
         <?php  foreach ($linkstring as $linkstr)
                { 
                    if(trim($linkstr)!=="")
                    {
                ?>
          <a href=<?php echo $linkstr; ?> target="_blank"><?php print nl2br($linkstr); ?></a><br/>
          
                    <?php } } ?>
                </p>
          </td>
        </tr>
        
          <?php } ?> 
        
        
        <?php
			     if($estimatedirrvalue!="")
			     {
                             ?>
			       <tr><td><h4>Estimated Returns </h4><p><?php echo $myrow["EstimatedIRR"];?></p></tr>
			        <?php
       			    }
                         $invStringArrayCount=count($invReturnString);
                         //echo "<Br>***" .$bool_returnFlag;
			if($bool_returnFlag==1)  //to display the title ifandonlyif atleast one investor has mutliplereturn value >0
                         {
                        ?>
                           	<tr><td ><h4>&nbsp;Return Multiple</h4><p>
				
                            <?php
			      for($i=0;$i<$invStringArrayCount;$i++)
			      {
                              $invStringToSplit=$invReturnString[$i];
                               $invString  =explode(",",$invStringToSplit);
                               $investorName=$invString[0];
                               $returnValue=$invString[1];
                               $investormoreinfo=$invMoreInfoString[$i];
                           //echo "<br>****".$invMoreInfoString[$i];

                                if($returnValue>0)
                                {
                          ?>
                             	
  				<b><?php echo $investorName;?> </b>, <?php echo $returnValue;?>x
                                 <br />
                                 <?php
                                   if ($investormoreinfo!="")
                                   {
                                    echo ($investormoreinfo) ;
                                   }
                                 ?>
                                
                               <?php
                              }
                              }
                          ?>
                        </td></tr>
                  <?php
                         }
                      if(trim($moreinfo_returns)!="")
			{
			?>
                                <tr><td ><h4>More Info (Returns) </h4><p><?php print nl2br($moreinfo_returns);?></p></td></tr>
                        <?php
                         } ?>
        </tbody>
        </table> 
        
        
        </div>
        <?php
        }
        ?>
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/tac-3/">
                 <h2>More Info</h2>
                                                               
                  <table class="tablelistview" cellpadding="0" cellspacing="0">
                      <tr>  <td class="more-info"><p><?php print nl2br($moreinfor); ?></p>
                              <p><a href="mailto:research@ventureintelligence.com?subject=Request for more deal data-<?php echo $pageTitlemail;?>&body=<?php echo $mailurl;?> ">
                                      Click Here</a> to request more details for this deal. Please specify what details you would like - financials, valuations, etc. - and we will revert with the data points as available. Note: For recent transactions (say within last 6 months), additional information availablity is typically less than for older ones.
                              </p></td></tr></table>
                                                                 
                                                                 </div>
        
    </div>
  <?php
                                if(($exportToExcel==1))
                                {
                                ?>
        <input type="button"  style="float: right;" class="export exlexport" value="Export" name="showmandadeal">

                                <?php
                                }
                                ?>  
   
</div>
      </div>
</td>
</tr>
</tbody>
                </table> 
        <?php }} ?>
    </div>
</form>
<form name="mandadealinfo" id="mandadealinfo" method="post" action="exportmanda.php">
  <input type="hidden" name="txthideMandAId" value="<?php echo $SelCompRef;?>" >
		<input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >  
</form>

 
<div class=""></div>
<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 632px; display: none;"></div>
<div class="lb" id="popup-box-copyrights" style="width:650px !important;">
   <span id="expcancelbtn" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <div class="copyright-body" style="text-align: center;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
    </div>
    <div class="cr_entry" style="text-align:center;">
        
        <input type="button" value="I Agree" id="agreebtn" />
    </div>

</div>
</body>
 <script type="text/javascript">
                $("a.postlink").click(function(){
                  
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    
                });
                 function resetinput(fieldname)
                {
                 
               // alert($('[name="'+fieldname+'"]').val());
                  $("#resetfield").val(fieldname);
                //  alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }
                /* $('.exlexport').click(function(){ 
             
            $("#mandadealinfo").submit();
            return false;
                });*/
    
                $('.exlexport').click(function(){ 
                    jQuery('#maskscreen').fadeIn();
                    jQuery('#popup-box-copyrights').fadeIn();   
                    return false;
            });

                $('#senddeal').click(function(){ 
                    jQuery('#maskscreen').fadeIn(1000);
                    jQuery('#popup-box').fadeIn();   
                    return false;
                });
                 $('#cancelbtn').click(function(){ 
                     
                    jQuery('#popup-box').fadeOut();   
                     jQuery('#maskscreen').fadeOut(1000);
                    return false;
                });
                 function validateEmail(field) {
                    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    return (regex.test(field)) ? true : false;
                }
                function checkEmail() {

                    var email = $("#toaddress").val();
                        if (email != '') {
                            var result = email.split(",");
                            for (var i = 0; i < result.length; i++) {
                                if (result[i] != '') {
                                    if (!validateEmail(result[i])) {

                                        alert('Please check, `' + result[i] + '` email addresses not valid!');
                                        email.focus();
                                        return false;
                                    }
                                }
                            }
                    }
                    else
                    {
                        alert('Please enter email address');
                        email.focus();
                        return false;
                    }
                    return true;
                }
                function initExport(){
                        $.ajax({
                            url: 'ajxCheckDownload.php',
                            dataType: 'json',
                            success: function(data){
                                var downloaded = data['recDownloaded'];
                                var exportLimit = data.exportLimit;
                                var currentRec = 1;

                                //alert(currentRec + downloaded);
                                var remLimit = exportLimit-downloaded;

                                if (currentRec <= remLimit){
                                    //hrefval= 'exportinvdeals.php';
                                    //$("#pelisting").attr("action", hrefval);
                                    $("#mandadealinfo").submit();
                                    jQuery('#preloading').fadeOut();
                                }else{
                                    jQuery('#preloading').fadeOut();
                                    //alert("You have downloaded "+ downloaded +" records of allowed "+ exportLimit +" records(within 48 hours). You can download "+ remLimit +" more records.");
                                    alert("Currently your export action is crossing the limit of "+ exportLimit +" records. You can download "+ remLimit +" more records. To increase the limit please contact info@ventureintelligence.com");
                                }
                            },
                            error:function(){
                                jQuery('#preloading').fadeOut();
                                alert("There was some problem exporting...");
                            }

                        });
                    }
                $('#mailbtn').click(function(){ 
                        
                        if(checkEmail())
                        {
                            
                        
                        $.ajax({
                            url: 'ajaxsendmail.php',
                             type: "POST",
                            data: { to : $("#toaddress").val(),subject : $("#subject").val(), message : $("#message").val() , userMail : $("#useremail").val() },
                            success: function(data){
                                    if(data=="1"){
                                         alert("Mail Sent Successfully");
                                        jQuery('#popup-box').fadeOut();   
                                        jQuery('#maskscreen').fadeOut(1000);
                                   
                                }else{
                                    jQuery('#popup-box').fadeOut();   
                                    jQuery('#maskscreen').fadeOut(1000);
                                    alert("Try Again");
                                }
                            },
                            error:function(){
                                jQuery('#preloading').fadeOut();
                                alert("There was some problem sending mail...");
                            }

                        });
                        }
                        
                    });
    
            </script>
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
 function highlightWords($text, $words)
 {

         /*** loop of the array of words ***/
         foreach ($words as $worde)
         {

                 /*** quote the text for regex ***/
                 $word = preg_quote($worde);
                 /*** highlight the words ***/
                 $text = preg_replace("/\b($worde)\b/i", '<span class="highlight_word">\1</span>', $text);
         }
         /*** return the text ***/
         return $text;
 }

 	function return_insert_get_RegionIdName($regionidd)
	{
		$dbregionlink = new dbInvestments();
		$getRegionIdSql = "select Region from region where RegionId=$regionidd";

                if ($rsgetInvestorId = mysql_query($getRegionIdSql))
		{
			$regioncnt=mysql_num_rows($rsgetInvestorId);
			//echo "<br>Investor count-- " .$investor_cnt;

			if($regioncnt==1)
			{
				While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
				{
					$regionIdname = $myrow[0];
					//echo "<br>Insert return investor id--" .$invId;
					return $regionIdname;
				}
			}
		}
		$dbregionlink.close();
	}
function curPageURL() {
 $URL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $URL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $URL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $URL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 $pageURL=$URL."&scr=EMAIL";
 return $pageURL;
}
?>
<script type="text/javascript" >

    $("#panel").animate({width: 'toggle'}, 200); 
    $(".btn-slide").toggleClass("active"); 

    if ($('.left-td-bg').css("min-width") == '264px') {
    $('.left-td-bg').css("min-width", '36px');
    $('.acc_main').css("width", '35px');
    }
    else {
    $('.left-td-bg').css("min-width", '264px');
    $('.acc_main').css("width", '264px');
    }                      
    
     $(document).on('click','#agreebtn',function(){
    
        $('#popup-box-copyrights').fadeOut();   
        $('#maskscreen').fadeOut(1000);
        $('#preloading').fadeIn();   
        initExport();
        return false; 
     });
    
     $(document).on('click','#expcancelbtn',function(){

        jQuery('#popup-box-copyrights').fadeOut();   
        jQuery('#maskscreen').fadeOut(1000);
        return false;
    });
</script>
<?php
mysql_close();
    mysql_close($cnx);
    ?>