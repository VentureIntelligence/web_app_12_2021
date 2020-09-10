<?php
        
                $companyId=632270771;
                $compId=0;
                require_once("../dbconnectvi.php");
                $Db = new dbInvestments();
                include ('checklogin.php');
                $notable=false;
                $VCFlagValueString = isset($_REQUEST['value']) ? $_REQUEST['value'] : '0-1';
                $VCFlagValue_exit = explode("-", $VCFlagValueString);
                $vcflagValue=$VCFlagValue_exit[0];
                $hide_pms=$VCFlagValue_exit[1];
                $flagvalue=$VCFlagValueString;
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
                if($vcflagValue==1)
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
                {$exitstatusdisplay="Partial Exit"; }
                //echo "<bR>111";}
                elseif($exitstatusvalue=="1")
                {$exitstatusdisplay="Complete Exit";}
                //echo "<bR>222";}
                elseif($exitstatusvalue=="--")
                {$exitstatusdisplay=""; }
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
                             
                           else if(!$_POST)
                                    {
                                        $iftest=1;
                                            //echo "<br>Query for all records";
                                            $yourquery=0;

                                            $dt1 = $year1."-".$month1."-01";
                                            $dt2 = $year2."-".$month2."-01";

                                            $companysql = "SELECT DISTINCT pe.MandAId,pe.PECompanyId, pec.companyname, pec.industry, i.industry,
                                            sector_business, pe.DealAmount, i.industry, hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period
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
                                        echo "pppppppppppppppppppppppppppppppppppppppppp";
                                         $iftest=2;
                                            $yourquery=1;

                                            $dt1 = $year1."-".$month1."-01";
                                            $dt2 = $year2."-".$month2."-01";

                                            $companysql = "SELECT DISTINCT pe.MandAId,pe.PECompanyId, pec.companyname, pec.industry, i.industry,
                                            sector_business, pe.DealAmount, i.industry, hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period
                                            FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,manda_investors as mandainv where";

                                            if ($industry > 0)
                                            {
                                                     $iftest=$iftest.".1";
                                                    $whereind = " pec.industry=" .$industry ;
                                                    $qryIndTitle="Industry - ";
                                            }
                                            if ($dealtype!= "--")
                                            {
                                                 $iftest=$iftest.".2";
                                                    $wheredealtype = " pe.DealTypeId =" .$dealtype;
                                                    $qryDealTypeTitle="Deal Type - ";
                                            }
                                             if ($invType!= "--")
                                            {
                                                  $iftest=$iftest.".3";
                                                $qryInvType="Investor Type - " ;
                                                $whereInvType = " pe.InvestorType = '".$investorType."'";
                                            }
                                            if($exitstatusvalue!="--")
                                            {     $iftest=$iftest.".4";
                                                $whereexitstatus=" pe.ExitStatus=".$exitstatusvalue;  }
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
                                           $whereReturnMultiple=" ipoinv.MultipleReturn > " .$txtfrm  ;
                                    }
                                    elseif(trim($txtfrm=="") && trim($txtto>0))
                                    {
                                           $qryReturnMultiple="Return Multiple - ";
                                           $whereReturnMultiple=" ipoinv.MultipleReturn < " .$txtto  ;
                                    }
                                    elseif(trim($txtfrm>  0) && trim($txtto >0))
                                    {
                                           $qryReturnMultiple="Return Multiple - ";
                                           $whereReturnMultiple=" ipoinv.MultipleReturn > " .$txtfrm . " and  ipoinv.MultipleReturn <".$txtto;
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
                                    elseif ($companysearch != "")
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

                                    elseif($investorsearch!="")
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
                                    elseif($acquirersearch!="")
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
                                    elseif($advisorsearchstring_legal!="")
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

                                    elseif($advisorsearchstring_trans!="")
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
                ?>

    <?php 
    $topNav = 'Deals';
    include_once('kmandaheader_search.php');
    ?>



<div id="container">
    <table cellpadding="0" cellspacing="0" width="100%">

  <td class="left-td-bg"><div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide">Slide Panel</a></div> 
 <div  id="panel">
<div class="left-box">

    <?php include_once('kmandarefine.php');?>

    </td>
           <input type="hidden" name="resetfield" value="" id="resetfield"/>

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
						 //	echo "<br> query final-----" .$companysql."/".$iftest;
						 	      /* Select queries return a resultset */
								 if ($companyrs = mysql_query($companysql))
								 {
								    $company_cnt = mysql_num_rows($companyrs);
								 }

						           if($company_cnt > 0)
						           {

						           }
						           else
						           {
						              	$searchTitle= " No Exit(s) found for this search ";
						              	$notable=true;
						           }

				           ?>

    <td class="result-cnt" style="margin-bottom: 30px;">
        
        </form>
    <div>
                        <div class="result-title">

                <?php if(!$_POST)
                    {
                    if($value=="0-1")
                       {
                       ?>
                           <h3><?php echo @mysql_num_rows($companyrs); ?> Results found </h3> <h2> for Exit Via Public Market Sales </h2> <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a>
                       <?php }
                       elseif($value=="0-0") {
                           ?>
                           <h3><?php echo @mysql_num_rows($companyrs); ?> Results found </h3> <h2> for PE Exits - M&A </h2> <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a> 
                       <?php } 
                      elseif ($value="1-0") { ?>
                           <h3><?php echo @mysql_num_rows($companyrs); ?> Results found </h3> <h2> for  VC Exits - M&A </h2> <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a> 
                      <?php }
               ?>
                  <?php 
                  }
                   else 
                   {
                        if($value=="0-1")
                       {
                       ?>
                               <h3><?php echo @mysql_num_rows($companyrs); ?> Results found </h3> <h2> for Exit Via Public Market Sales </h2> <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a>
                       <?php }
                       elseif($value=="0-0") {
                           ?>
                             <h3><?php echo @mysql_num_rows($companyrs); ?> Results found </h3> <h2> for PE Exits - M&A </h2> <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a> 
                       <?php } 
                         elseif ($value="1-0") { ?>
                             <h3><?php echo @mysql_num_rows($companyrs); ?> Results found </h3> <h2> for  VC Exits - M&A </h2> <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a> 
                         <?php }
               ?>
            <ul>
                <?php
                if($industry >0 && $industry!=null){ ?>
                <li title="Industry">
                                    <?php echo $industryvalue; ?> <a   onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } if($dealtype!="--"){ ?>
                                <li title="Dealtype">
                                    <?php echo $dealtypevalue; ?> <a  onclick="resetinput('dealtype');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($investorType !="--" && $investorType!=null){ ?>
                                <li title="Investor type"> 
                                    <?php echo $invtypevalue; ?> <a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  if($exitstatusdisplay!="") { ?>
                                <li title="Exit Display "> 
                                    <?php echo $exitstatusdisplay;?> <a  onclick="resetinput('exitstatus');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  
                                if($advisorsearchstring_legal!=" ") { ?>
                                <li title="Legal Advisor"> 
                                    <?php echo $advisorsearchstring_legal?> <a  onclick="resetinput('advisorsearch_legal');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($advisorsearchstring_trans!=" "){ ?>
                                <li title="Transatactional Advisor"> 
                                    <?php echo $advisorsearchstring_trans?> <a  onclick="resetinput('advisorsearch_trans');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } if($datevalueDisplay1!=""){ ?>
                                <li title="Period"> 
                                    <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?> <a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } if(($txtfrm>=0) && ($txtto>0)) { ?>
                                <li title="Return Multiple"> 
                                    <?php echo $txtfrm. "-" .$txtto?> <a  onclick="resetinput('returnmultiple');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } if($companysearch!=" "){ ?>
                                <li title="Company Search"> 
                                    <?php echo $companysearch;?> <a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } if($investorsearch!=" "){ ?>
                                <li title="Investor" > 
                                    <?php echo $investorsearch;?> <a  onclick="resetinput('investorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  if($searchallfield!=""){ ?>
                                <li title="Others"> 
                                <?php echo $searchallfield ; ?> <a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } ?>
             </ul>
             <?php } ?>
        </div>


                        <?php
                                if($notable==false)
                                { 
                        ?>
        <div class="overview-cnt">
                <div class="showhide-link"><a href="#" class="show_hide" rel="#slidingTable"><i></i><span>Trends View</span></a></div>

              <div  id="slidingTable" style="display:block; overflow:hidden;">  
               <?php
               include_once("kmandatrendview.php");
               ?>     
                </div>
        </div>
        <div class="list-tab">
                       
                       
                       
                       <ul>
                        <li class="active"><a class="postlink"   href="<?php echo $pageTitle; ?>"  id="icon-grid-view"><i></i> List  View</a></li>
                        <?php
                            $count=0;
                             While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                            {
                                    if($count == 0)
                                    {
                                             $comid = $myrow["MandAId"];
                                            $count++;
                                    }
                            }
                            ?>
                        <li><a id="icon-detailed-view" class="postlink" href="kmandadealdetails.php?value=<?php echo $comid;?>/<?php echo $VCFlagValue;?>/<?php echo $searchallfield;?>" ><i></i> Detailed  View</a></li> 
                        </ul></div>
        
                        <form name="mandaview"  method="post" >
                        <?php if($_POST) { ?>
                        <input type="hidden" name="txtsearchon" value="3" >
                        <input type="hidden" name="txttitle" value=<?php echo $vcflagValue; ?> >
                        <input type="hidden" name="txthide_pms" value=<?php echo $hide_pms;?> >
			<input type="hidden" name="txthidename" value=<?php echo $username; ?> >
			<input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
			<input type="hidden" name="txthideindustry" value=<?php echo $industryvalue; ?> >
			<input type="hidden" name="txthideindustryid" value=<?php echo $industry; ?> >

			<input type="hidden" name="txthidedealtype" value=<?php echo $dealtypevalue; ?> >
			<input type="hidden" name="txthidedealtypeid" value=<?php echo $dealtype; ?> >
                        <input type="hidden" name="txthideinvtype" value=<?php echo $invtypevalue; ?> >
		        <input type="hidden" name="txthideinvtypeid" value=<?php echo $investorType; ?> >
		        <input type="hidden" name="txthideexitstatusvalue" value=<?php echo $exitstatusvalue; ?> >
			<input type="hidden" name="txthiderange" value=<?php echo $rangeText; ?> >

			<input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
			<input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
			<input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >

                        <input type="hidden" name="txthideReturnMultipleFrm" value=<?php echo $txtfrm; ?> >
                        <input type="hidden" name="txthideReturnMultipleTo" value=<?php echo $txtto; ?> >

			<input type="hidden" name="txthideinvestor" value=<?php echo $investorsearch; ?> >
			<input type="hidden" name="txthideInvestorString" value=<?php echo $stringToHideInvestor; ?> >
			<input type="hidden" name="txthidecompany" value=<?php echo $companysearch; ?> >
			<input type="hidden" name="txthideCompanyString" value=<?php echo $stringToHideCompany; ?> >

			<input type="hidden" name="txthideadvisor_legal" value=<?php echo $advisorsearchhidden_legal; ?> >
			<input type="hidden" name="txthideadvisor_trans" value=<?php echo $advisorsearchhidden_trans; ?> >
			<input type="hidden" name="txthideacquirer" value=<?php echo $acquirersearch; ?> >
			<input type="hidden" name="txthidesearchallfield" value=<?php echo $searchallfieldhidden; ?> >
                        <?php } else { ?>
                             <input type="hidden" name="txtsearchon" value="3" >
                        <input type="hidden" name="txttitle" value=<?php echo $vcflagValue; ?> >
                        <input type="hidden" name="txthide_pms" value=<?php echo $hide_pms;?> >
			<input type="hidden" name="txthidename" value=<?php echo $username; ?> >
			<input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
                        <input type="hidden" name="txthideindustry" value="">
			<input type="hidden" name="txthideindustryid" value="--">
                        <input type="hidden" name="txthidedealtype" value=<?php echo $dealtypevalue; ?> >
                        
                        <input type="hidden" name="txthidedealtypeid" value="--">
                        <input type="hidden" name="txthideinvtype" value="">
		        <input type="hidden" name="txthideinvtypeid" value="--">
		        <input type="hidden" name="txthideexitstatusvalue" value="--">
			<input type="hidden" name="txthiderange" value="">
                        
                        <input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
			<input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
			<input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >

                         <input type="hidden" name="txthideReturnMultipleFrm" value="">
                        <input type="hidden" name="txthideReturnMultipleTo" value="">

			
                        <input type="hidden" name="txthideReturnMultipleFrm" value="">
                        <input type="hidden" name="txthideReturnMultipleTo" value="">

			<input type="hidden" name="txthideinvestor" value="">
			<input type="hidden" name="txthideInvestorString" value="+">
			<input type="hidden" name="txthidecompany" value="">
			<input type="hidden" name="txthideCompanyString" value="+">

			<input type="hidden" name="txthideadvisor_legal" value="">
			<input type="hidden" name="txthideadvisor_trans" value="">
			<input type="hidden" name="txthideacquirer" value="">
			<input type="hidden" name="txthidesearchallfield" value="">
                        
                        
                            
                        <?php } ?>
        <div class="view-table">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
              <thead><tr>
                <th>Company</th>
                <th>Sector</th>
                <th>Date</th>
                <th>Amount (US$M)</th>
               </tr></thead>
              
              <tbody id="movies">
                <?php
                        if ($company_cnt>0)
                        {
                                $hidecount=0;
								//Code to add PREV /NEXT
								$icount = 0;
								if ($_SESSION['resultId']) 
									unset($_SESSION['resultId']); 
									
                                mysql_data_seek($companyrs,0);
                           While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                                {
									
									//Session Variable for storing Id. To be used in Previous / Next Buttons
									$_SESSION['resultId'][$icount++] = $myrow["MandAId"];

                                $prd=$myrow["period"];
                                        if($myrow["hideamount"]==1)
                                        {
                                                $hideamount="--";
                                                $hidecount=$hidecount+1;
                                        }
                                        else
                                        {
                                                $hideamount=$myrow["DealAmount"];
                                        }

                                        if(trim($myrow["sector_business"])=="")
                                                $showindsec=$myrow["industry"];
                                        else
                                                $showindsec=$myrow["sector_business"];
                       ?>         <tr>
                                <?php

                                ?>
                           <td ><a class="postlink" href="mandadealdetails.php?value=<?php echo $myrow["MandAId"];?>/<?php echo $flagvalue;?>/<?php echo $searchallfield;?>"><?php echo trim($myrow["companyname"]);?> </a> <?php echo $closeBracket ; ?><?php echo $closeDebtBracket;?></td>
                                                <td><?php echo trim($showindsec); ?></td>
                                                <td><?php echo $prd;?> </td>
                                                <td align=right><?php echo $hideamount; ?>&nbsp;</td>
                                        </tr>
                                        <?php
                                          $industryAdded = $myrow["industry"];
                                          $totalInv=$totalInv+1;
                                          $totalAmount=$totalAmount+ $myrow["DealAmount"];    

                            }
                     }
                                ?>
        </tbody>
    </table>
    <div class="holder"></div>
    <div>&nbsp;</div>
    <div>&nbsp;</div>
    </div>			
        <?php
                        }
                        if($hidecount==1)
                        {
                                $totalAmount="--";
                        } ?>
                        
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
        			        To Export the above deals into a Spreadsheet,&nbsp;<input type="button"  value="Click Here" name="showdeals" onClick="onClick_MandAExport();"> &nbsp;&nbsp;
        			        <input type="button"  value="Click Here with Investments" name="showdeals" onClick="onClick_MandAExport_withInv();" >
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
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;
						Amount (US$ Million) <?php echo $totalAmount; ?> <br /></div>					<?php
					}
					else
					{
					?>
						<div id="headingtextproboldbcolor">&nbsp;No. of Deals - XX &nbsp;&nbsp;&nbsp;&nbsp;Value (US$ M) - YYY <br />Aggregate data for each search result is displayed here for Paid Subscribers <br /></div>

					<?php
					}
				?>

				<?php
					if(($totalInv>0)  &&  ($exportToExcel==1))
					{
				?>
						<span style="float:left" class="one">
							To Export the above deals into a Spreadsheet,&nbsp;<input type="button"  value="Click Here" name="showmandadeals" onClick="onClick_MandAExport();" >
							&nbsp;&nbsp;
        			        <input type="button"  value="Export Exits with Investment details" name="showdeals" onClick="onClick_MandAExport_withInv();" >
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
       							<a target="_blank" href=<?php echo $samplexls;?> ><u>Click Here</u> </a> for a sample spreadsheet containing Exits via M&A

							</span>
					<?php
					}
			} //end of student if
				?>
                                                
                                                <?php
					}
					elseif($buttonClicked=='Aggregate')
					{

						$aggsql= $aggsql. " i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
								and pec.industry != 15 and pe.Deleted=0 " .$addVCFlagqry.
									 " order by pe.DealAmount desc,DealDate desc";
						//	echo "<br>--" .$aggsql;
							 if ($rsAgg = mysql_query($aggsql))
							 {
								$agg_cnt = mysql_num_rows($rsAgg);
							 }
							   if($agg_cnt > 0)
							   {
									//$searchTitle=" Aggregate Deal Data";

									 While($myrow=mysql_fetch_array($rsAgg, MYSQL_BOTH))
									   {
											$totDeals = $myrow["totaldeals"];
											$totDealsAmount = $myrow["totalamount"];
										}
							   }
							   else
							   {
									$searchTitle= " No Exit(s) found for this search";
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
									$dealSql= "select DealType from dealtypes where DealTypeId=$dealtype";
								  	if($rsDealType=mysql_query($dealSql))
								  	{
									  while($mydealRow=mysql_fetch_array($rsDealType,MYSQL_BOTH))
									  {
										$dealqryValue=$mydealRow["DealType"];
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
								if(($industry==0) && ($dealtype=="--") && ($range=="--") && ($wheredates==""))
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
						if($dealtype !="")
						{
					?>
							<?php echo $qryDealTypeTitle; ?><?php echo $dealqryValue; ?> <?php echo $spacing; ?>
					<?php
						}
						if($range!="--")
						{
					?>
							<?php echo $qryRangeTitle; ?><?php echo $rangeqryValue; ?> <?php echo $spacing; ?>
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
    <div class=""></div>

    </div>
    </form>
        <script type="text/javascript">
function onClick_MandAExport()
{

	document.mandaview.action="exportmandadeals.php";
	document.mandaview.submit();

}
function onClick_MandAExport_withInv()
{

	document.mandaview.action="exportmandaexit_invdeals.php";
	document.mandaview.submit();

}
</script>

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
