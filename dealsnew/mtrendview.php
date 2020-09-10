<?php
        
        $companyId=632270771;
        $compId=0;
        require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
        include ('checklogin.php');
        $VCFlagValueString = isset($_REQUEST['value']) ? $_REQUEST['value'] : '0-1';
        $VCFlagValue_exit = explode("-", $VCFlagValueString);
        $vcflagValue=$VCFlagValue_exit[0];
        $hide_pms=$VCFlagValue_exit[1];
        $flagvalue=$VCFlagValueString;
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 1;
       
               if($vcflagValue==1)
                {
                    $addVCFlagqry = "and VCFlag=1 and";
                    $searchTitle = "List of VC Exits - M&A";
                    $searchAggTitle = "Aggregate Data - VC Exits - M&A";
                }
                else
                {
                    $addVCFlagqry = " and ";
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
               if($resetfield=="investorsearch")
                { 
                 $_POST['investorsearch']="";
                 $keyword="";
                 $keywordhidden="";
                }
                else 
                {
                 $keyword=trim($_POST['investorsearch']);
                 $keywordhidden=trim($_POST['investorsearch']);
                }
                $keywordhidden =ereg_replace(" ","_",$keyword);

                //echo "<br>--" .$keywordhidden;
                 if($resetfield=="acquirersearch")
                { 
                 $_POST['acquirersearch']="";
                 $acquirersearch="";
                 $acquirersearchhidden="";
                }
                else 
                {
                 $acquirersearch=trim($_POST['acquirersearch']);
                 $acquirersearchhidden=trim($_POST['acquirersearch']);
                }
                $acquirersearchhidden =ereg_replace(" ","_", $acquirersearch);
                
                if($resetfield=="companysearch")
                { 
                 $_POST['companysearch']="";
                 $companysearch="";
                }
                else 
                {
                 $companysearch=trim($_POST['companysearch']);
                }
                 $companysearchhidden=ereg_replace(" ","_",$companysearch);

               if($resetfield=="sectorsearch")
                { 
                 $_POST['sectorsearch']="";
                 $sectorsearch="";
                }
                else 
                {
                 $sectorsearch=trim($_POST['sectorsearch']);
                }

                $sectorsearchhidden=ereg_replace(" ","_",$sectorsearch);

                if($resetfield=="advisorsearch_legal")
                { 
                 $_POST['advisorsearch_legal']="";
                 $advisorsearchstring_legal="";
                }
                else 
                {
                 $advisorsearchstring_legal=trim($_POST['advisorsearch_legal']);
                }
                $advisorsearchhidden_legal=ereg_replace(" ","_",$advisorsearchstring_legal);

                if($resetfield=="advisorsearch_trans")
                { 
                 $_POST['advisorsearch_trans']="";
                 $advisorsearchstring_trans="";
                }
                else 
                {
                 $advisorsearchstring_trans=trim($_POST['advisorsearch_trans']);
                }
                $advisorsearchhidden_trans=ereg_replace(" ","_",$advisorsearchstring_trans);

                if($resetfield=="searchallfield")
                { 
                 $_POST['searchallfield']="";
                 $searchallfield="";
                }
                else 
                {
                 $searchallfield=trim($_POST['searchallfield']);
                }

                $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);

                
                $acquirersearch=$_POST['acquirersearch'];

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
                   $dealtype ="";
                }
                else 
                {
                    $dealtype =trim($_POST['dealtype']);
                }
                if($resetfield=="invType")
                { 
                 $_POST['invType']="";
                 $invType="--";
                }
                else 
                {
                 $investorType=trim($_POST['invType']);
                }
                if($resetfield=="exitstatus")
                { 
                 $_POST['exitstatus']="";
                 $exitstatusvalue="--";
                }
                else 
                {
                $exitstatusvalue=trim($_POST['exitstatus']);
                }
                
              // echo "<br>___".$exitstatusvalue;
                
                if($resetfield=="txtmultipleReturnFrom")
                { 
                    $_POST['txtmultipleReturnFrom']="";
                    $_POST['txtmultipleReturnTo']="";
                    $txtfrm="";
                    $txtto="";
                }
                else 
                {
                    $txtfrm=$_POST['txtmultipleReturnFrom'];
                    $txtto=$_POST['txtmultipleReturnTo'];
                }
                $txttoDisplay = $txtto;
              

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
                                $endyear=$eyear."-12-31";
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

		if($exitstatusvalue=="0")
		  $exitstatusdisplay="Partial Exit";
		elseif($exitstatusvalue=="1")
                  $exitstatusdisplay="Complete Exit";
                else
                  $exitstatusdisplay="";
             // print_r($_POST);
                    if(!$_POST){
                          
				 //echo "not post";
				$yourquery=0;
				$stagevaluetext="";
				$industry=0;
                                //echo "<br>Query for all records";
                                if($type==1)
                                { 
                                    $companysql = "select year(pe.DealDate),count(pe.MandAId) as totaldeals,sum(pe.DealAmount)as totalamount from manda as pe, industry as i, pecompanies as pec where i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                            and pec.industry != 15 and pe.Deleted=0 " .$addVCFlagqry. " DealDate > '1997-01-01' and DealDate <='2013-12-31' group by year(pe.DealDate)"  ;
                                   //echo  $companysql;
                                    $resultcompany= mysql_query($companysql);
                                }
                                elseif ($type==2) 
                                {
                                   $companysql = "select  i.industry,year(pe.DealDate),count(pe.MandAId) as totaldeals,sum(pe.DealAmount)as totalamount from manda as pe, industry as i,pecompanies as pec where i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                             and pec.industry != 15 and pe.Deleted=0 " .$addVCFlagqry. " DealDate> '".$startyear."' and DealDate <= '".$endyear."' group by pec.industry,year(pe.DealDate)";
                                  //echo  $companysql;
                                   $resultcompany= mysql_query($companysql);
                                }
                                else if($type ==4)
                                {
                                    $range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200+");
                                    for($r=0;$r<count($range);$r++)
                                    {
                                        if($r == count($range)-1)
                                        {
                                            $companysql = "select year(pe.DealDate),count(pe.MandAId) as totaldeals,sum(pe.DealAmount)as totalamount from manda as pe, industry as i,pecompanies as pec where i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                            and pec.industry != 15 and pe.Deleted=0 " .$addVCFlagqry. " (pe.DealDate  > 200) and DealDate> '".$startyear."' and DealDate <= '".$endyear."' group by year(pe.DealDate)";
                                            
                                          //echo  $companysql;
                                             $resultcompany= mysql_query($companysql);
                                        }
                                        else
                                        {
                                            $limit=(string)$range[$r];
                                            $elimit=explode("-", $limit);
                                            $companysql  = "select year(pe.DealDate),count(pe.MandAId) as totaldeals,sum(pe.DealAmount)as totalamount from manda as pe, industry as i,pecompanies as pec where i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                            and pec.industry != 15 and pe.Deleted=0 " .$addVCFlagqry. " (pe.DealDate > ".$elimit[0]." and pe.DealDate <= ".$elimit[1].") and DealDate> '".$startyear."' and DealDate <= '".$endyear."' group by year(pe.DealDate)";                           
                                            //echo  $companysql;
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
                                   $companysql = "select inv.InvestorTypeName,year(pe.DealDate),count(pe.MandAId) as totaldeals,sum(pe.DealAmount)as totalamount from manda as pe, industry as i, investortype as inv ,pecompanies as pec where i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                            and pec.industry != 15 and pe.Deleted=0 " .$addVCFlagqry. " pe.InvestorType=inv.InvestorType and DealDate> '".$startyear."' and DealDate <= '".$endyear."' group by inv.InvestorTypeName,year(pe.DealDate)";
                                  //echo  $companysql;
                                  $resultcompany= mysql_query($companysql);
                                }
                               
			//	     echo "<br>all records" .$companysql;
			}
			else if($_POST)
                        {
                              
                              $dt1 =  $startyear;
                              $dt2 = $endyear;
                            if($type != 4)
                            {
                                if($keyword != "")
                                {
                                        $keybef=" ,manda_investors as peinv_inv, peinvestors as inv";
                                }
                                if($acquirersearch!= "")
                                    {
                                    $acqbef=", acquirers AS ac";
                                }
                                if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                {
                                        $albef=" ,advisor_cias as cia , peinvestments_advisorcompanies as adac";
                                }
                              
                                if($type==1)
                                {
                                    $companysql = "select year(pe.DealDate),count(pe.MandAId) as totaldeals,sum(pe.DealAmount)as totalamount from manda as pe,  pecompanies as pec, industry as i".$keybef.$albef." where";
                                }
                                else if($type==2)
                                {
                                   $companysql = "select  i.industry,year(pe.DealDate),count(pe.MandAId) as totaldeals,sum(pe.DealAmount)as totalamount from manda as pe, industry as i,pecompanies as pec ".$keybef.$albef." where "; 
                                
                                }
                                else if($type==5)
                                {
                                    $companysql = "select in.InvestorTypeName,year(pe.DealDate),count(pe.MandAId) as totaldeals,sum(pe.DealAmount)as totalamount from manda as pe,investortype as inv, industry as i,pecompanies as pec ".$keybef.$albef." where pe.InvestorType=inv.InvestorType";                                
                                }
                               
                            
				//echo "<br> individual where clauses have to be merged ";
                                            if ($industry > 0)
                                            {
                                                     $iftest=$iftest.".1";
                                                    $whereind = " pec.industry=" .$industry ;
                                                    $qryIndTitle="Industry - ";
                                            }
                                            if ($dealtype!= "--" && $dealtype!= "" )
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
                                        //echo "<Br>***".$whererange;
                                           if(trim($txtfrm>0) && trim($txtto==""))
                                            {
                                                         $iftest=$iftest.".7";
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" pe.MandAId=ipoinv.MandAId and ipoinv.MultipleReturn > " .$txtfrm  ;
                                            }
                                            elseif(trim($txtfrm=="") && trim($txtto>0))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" pe.MandAId=ipoinv.MandAId and ipoinv.MultipleReturn < " .$txtto  ;
                                            }
                                            elseif(trim($txtfrm>  0) && trim($txtto >0))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple="pe.MandAId=ipoinv.MandAId and ipoinv.MultipleReturn > " .$txtfrm . " and  ipoinv.MultipleReturn <".$txtto;
                                            }
                                            if( ($dt1 != "")  && ($dt2 != ""))
                                            {
                                                if($type==2)
                                                {
                                                    $addind="i.industry,";
                                                }
                                                else if($type==5)
                                                {
                                                    $addind="inv.InvestorTypeName,";
                                                }
                                                    
                                               $qryDateTitle ="Period - ";
                                               $wheredates= " DealDate  > '" . $dt1. "' and DealDate  <= '" . $dt2 . "' group by ".$addind." year(pe.DealDate)";
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

                                         if($whereReturnMultiple!= "")
                                         {
                                         $companysql = $companysql . $whereReturnMultiple ." and ";
                                         }
                                            
                                         if($keyword != "")
                                        {
                                                $keyaft=" pe.MandAId=peinv_inv.MandAId and inv.InvestorId=peinv_inv.InvestorId and inv.investor LIKE '%$keyword%'";
                                                $companysql=$companysql . $keyaft . " and ";
                                        }
                                        if($acquirersearch!= "")
                                        {
                                            $acqaft=" ac.AcquirerId = pe.AcquirerId and ac.Acquirer LIKE '%$acquirersearch%'";
                                            $companysql=$companysql . $acqaft . " and ";
                                        }
                                        if($companysearch != "")
                                        {

                                                $csaft=" (pec.companyname LIKE '%$companysearch%' or pec.sector_business LIKE '%$$sectorsearch%')";
                                                $companysql=$companysql . $csaft . " and ";

                                        }
                                        if($advisorsearchstring_legal!= "")
                                        {
                                                $alaft=" adac.CIAId = cia.CIAId AND adac.PEId = pe.MandAId AND cia.cianame LIKE '%$advisorsearchstring_legal%'";
                                                $companysql=$companysql . $alaft . " and ";
                                        }
                                        if($advisorsearchstring_trans!= "")
                                        {
                                                $ataft=" adac.CIAId = cia.CIAId AND adac.PEId = pe.MandAId AND cia.cianame LIKE '%$advisorsearchstring_trans%'";
                                                $companysql=$companysql . $ataft . " and ";
                                        }
                                       
                                        //the foll if was previously checked for range
                                        if(($wheredates !== "") )
                                            {
                                                $companysql = $companysql . " i.industryid=pec.industry and
                                                pec.PEcompanyID = pe.PECompanyID and
                                                pe.Deleted=0 " . $addVCFlagqry . "";
                                                    $companysql = $companysql . $wheredates ."";
                                                    $aggsql = $aggsql . $wheredates ."";
                                                    $bool=true;
                                            }
                                           
                                        //echo $companysql;
                                         $resultcompany= mysql_query($companysql);
                               }
                                        
                                else if($type == 4 && $_POST)
                                {
                                    
                                    $range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200");
                                    //print_r($range);
                                    for($r=0;$r<count($range);$r++)
                                    {
                                        if($keyword != "")
                                        {
                                                $keybef=" ,manda_investors as peinv_inv, peinvestors as inv";
                                        }
                                        if($acquirersearch!= "")
                                            {
                                            $acqbef=", acquirers AS ac";
                                        }
                                        if($advisorsearchstring_legal!= "" || $advisorsearchstring_trans!= "")
                                        {
                                                $albef=" ,advisor_cias as cia , peinvestments_advisorcompanies as adac";
                                        }
                                        $limit=(string)$range[$r];
                                        $elimit=explode("-", $limit);
                                         if( $elimit[0] !='' && $elimit[1] !='' && $elimit[0] != $elimit[1])
                                         {
                                             $whererange = " and (pe.DealAmount > ".$elimit[0]." and pe.DealAmount <= ".$elimit[1].")";
                                         }
                                         else
                                         {
                                             $whererange = " and (pe.DealAmount > ".$elimit[0].")";
                                         }
                                        $companysql = "select year(pe.DealDate),count(pe.MandAId) as totaldeals,sum(pe.DealAmount)as totalamount from manda as pe,  pecompanies as pec , manda_investors as ipoinv, industry as i ".$keybef.$albef." where";
                                        
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
                                        //echo "<Br>***".$whererange;
                                           if(trim($txtfrm>0) && trim($txtto==""))
                                            {
                                                         $iftest=$iftest.".7";
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" pe.MandAId=ipoinv.MandAId and ipoinv.MultipleReturn > " .$txtfrm  ;
                                            }
                                            elseif(trim($txtfrm=="") && trim($txtto>0))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" pe.MandAId=ipoinv.MandAId and ipoinv.MultipleReturn < " .$txtto  ;
                                            }
                                            elseif(trim($txtfrm>  0) && trim($txtto >0))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" pe.MandAId=ipoinv.MandAId and ipoinv.MultipleReturn > " .$txtfrm . " and  ipoinv.MultipleReturn <".$txtto;
                                            }
                                            if( ($dt1 != "")  && ($dt2 != ""))
                                            {
                                                if($type==2)
                                                {
                                                    $addind="pec.industry,";
                                                }
                                                    
                                               $qryDateTitle ="Period - ";
                                               $wheredates= " DealDate  > '" . $dt1. "' and DealDate  <= '" . $dt2 . "' group by ".$addind." year(pe.DealDate)";
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

                                         if($whereReturnMultiple!= "")
                                         {
                                         $companysql = $companysql . $whereReturnMultiple ." and ";
                                         }
                                            
                                         if($keyword != "")
                                        {
                                                $keyaft=" pe.MandAId=peinv_inv.MandAId and inv.InvestorId=peinv_inv.InvestorId and inv.investor LIKE '%$keyword%'";
                                                $companysql=$companysql . $keyaft . " and ";
                                        }
                                        if($acquirersearch!= "")
                                        {
                                            $acqaft=" ac.AcquirerId = pe.AcquirerId and ac.Acquirer LIKE '%$acquirersearch%'";
                                            $companysql=$companysql . $acqaft . " and ";
                                        }
                                        if($companysearch != "")
                                        {

                                                $csaft=" (pec.companyname LIKE '%$companysearch%' or pec.sector_business LIKE '%$$sectorsearch%')";
                                                $companysql=$companysql . $csaft . " and ";

                                        }
                                        if($advisorsearchstring_legal!= "")
                                        {
                                                $alaft=" adac.CIAId = cia.CIAId AND adac.PEId = pe.MandAId AND cia.cianame LIKE '%$advisorsearchstring_legal%'";
                                                $companysql=$companysql . $alaft . " and ";
                                        }
                                        if($advisorsearchstring_trans!= "")
                                        {
                                                $ataft=" adac.CIAId = cia.CIAId AND adac.PEId = pe.MandAId AND cia.cianame LIKE '%$advisorsearchstring_trans%'";
                                                $companysql=$companysql . $ataft . " and ";
                                        }
                                       
                                        //the foll if was previously checked for range
                                        if(($wheredates !== "") )
                                            {
                                                $companysql = $companysql . " i.industryid = pec.industry and
                                                pec.PEcompanyID = pe.PECompanyID and
                                                pe.Deleted=0 " . $addVCFlagqry . "";
                                                    $companysql = $companysql . $wheredates ."";
                                                    $aggsql = $aggsql . $wheredates ."";
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
	include_once('mandaheader_search.php');
?>


<div id="container">
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td class="left-box">

<?php include_once('mandarefine.php');?>
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
		           ?>


<td>
    
<div class="result-cnt">
                        <div class="veiw-tab"><ul>
                        <li class="active"><a href="mtrendview.php?type=1&value=<?php echo $VCFlagValueString;?>"><i class="i-trend-view"></i>Overview</a></li>
                        <li ><a  href="mandaindex.php?value=<?php echo $vcflagValue; ?>"><i class="i-list-view"></i>List View</a></li>
                        <?php
						/*$count=0;
						 While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
						{
							if($count == 0)
							{
								 $comid = $myrow["PEId"];
								$count++;
							}
						}*/
						?>
                       
                        </ul></div>	
<?php
    
if($VCFlagValueString == '0-1')
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
else if($VCFlagValueString == '0-0')
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
else if($VCFlagValueString == '1-0')
{
?>
<div id="sec-header">
 <table cellpadding="0" cellspacing="0">
 <tr>
<td class="investment-form">
<h3>Types</h3>
<label><input class="typeoff-nav22" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/> Year On year</label>
<label><input class="typeoff-nav22" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />Industry</label>
<label><input class="typeoff-nav22" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>Range</label>
<label><input class="typeoff-nav22" name="typeoff" type="radio" value="5" <?php if($type==5) { ?> checked="checked" <?php } ?>/>Investor Type</label>
</td></tr>
</table>
</div>
<?php     
}
?>
 <div class="profile-view-title"> 
 <?php 
 if($type==1 && $hide_pms==1)
 {
 ?>
    <h2>Public Market Sales - Year on Year</h2>
<?php
 }
 elseif($type==2 && $hide_pms==1)
 {
     ?>
     <h2>Public Market Sales - By Industry</h2>
 <?php
 }
 
  elseif($type==4 && $hide_pms==1)
 {
     ?>
     <h2>Public Market Sales - By Range</h2>
 <?php
 }
  elseif($type==5 && $hide_pms==1)
 {
     ?>
     <h2>Public Market Sales - By Investor</h2>
 <?php
 } 
 else if($type==1 && $vcflagValue==0)
 {
 ?>
    <h2>M&A(PE) - Year on Year</h2>
<?php
 }
 elseif($type==2 && $vcflagValue==0)
 {
     ?>
     <h2>M&A(PE) - By Industry</h2>
 <?php
 }
 
  elseif($type==4 && $vcflagValue==0)
 {
     ?>
     <h2>M&A(PE) - By Range</h2>
 <?php
 }
  elseif($type==5 && $vcflagValue==0)
 {
     ?>
     <h2>M&A(PE) - By Investor</h2>
 <?php
 } 
 else if($type==1 && $vcflagValue==1)
 {
 ?>
    <h2>M&A(VC) - Year on Year</h2>
<?php
 }
 elseif($type==2 && $vcflagValue==1)
 {
     ?>
     <h2>M&A(VC) - By Industry</h2>
 <?php
 }
 
  elseif($type==4 && $vcflagValue==1)
 {
     ?>
     <h2>M&A(VC) - By Range</h2>
 <?php
 }
  elseif($type==5 && $vcflagValue==1)
 {
     ?>
     <h2>M&A(VC) - By Investor</h2>
 <?php
 } 
 ?>
 </div><br>
 <div class="result-title">
                                            
                            <?php if($_POST)
                               {
                              ?>
                            <ul>
                                <?php
                                 //echo $queryDisplayTitle;
                                if($industry >0 && $industry != "--"){ ?>
                                <li>
                                    <?php echo $industryvalue; ?> <a  onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($invType !="--" && $invType!=null){ ?>
                                <li> 
                                    <?php echo $invtypevalue; ?> <a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                 if($exitstatusvalue!="--" && $exitstatusvalue!=null) { ?>
                                <li> 
                                    <?php echo  $exitstatusdisplay;?> <a  onclick="resetinput('exitstatus');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if (($txtfrm!= "--" && $txtfrm!=null) && ($txtto != "--" && $txtto!=null)){ ?>
                                <li> 
                                    <?php echo $txtfrm ."-" .$txtto?> <a  onclick="resetinput('txtmultipleReturnFrom');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($dealtype!="--" && $dealtype!=null) { ?>
                                <li> 
                                    <?php echo  $debt_equityDisplay;?> <a  onclick="resetinput('dealtype');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($keyword != "") { ?>
                                <li> 
                                    <?php echo $keyword;?> <a  onclick="resetinput('investorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($companysearch != "" && $companysearch != "--"){ ?>
                                <li> 
                                    <?php echo $companysearch?> <a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($acquirersearch != ""){ ?>
                                <li> 
                                    <?php echo  $acquirersearch?> <a  onclick="resetinput('acquirersearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($advisorsearchstring_legal != "" && $advisorsearchstring_legal != "--") { ?>
                                <li> 
                                    <?php echo $advisorsearchstring_legal?> <a  onclick="resetinput('advisorsearch_legal');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($advisorsearchstring_trans != "" && $advisorsearchstring_trans != "--"){ ?>
                                <li> 
                                    <?php echo $advisorsearchstring_trans?> <a  onclick="resetinput('advisorsearch_trans');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  if($searchallfield != ""){ ?>
                                <li> 
                                    <?php echo $searchallfield?> <a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                if($year2 !="" && $year1 != "" && $type !=1){ ?>
                                <li> 
                                    <?php echo $year1. "-" .$year2;?> <a  onclick="resetinput('year1,year2');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                ?>
                             </ul>
                             <?php } ?>
    </div>
 <table cellpadding="0" cellspacing="0">
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
?>
 </div>          		

</form>
   <?php
    if($type==1 && $hide_pms==1)
    { ?>
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization2").offsetWidth;
  
  divheight=  document.getElementById("visualization2").offsetHight;
  
        // Create and populate the data table.
          var data = google.visualization.arrayToDataTable([
            ['Year', 'Deals', 'Amount($m)']
            <?php   mysql_data_seek($resultcompany, 0);
            while($rowsyear = mysql_fetch_array($resultcompany))	
        { ?>
            ,['<?php echo $rowsyear[0]; ?>',  <?php echo $rowsyear[1]; ?>,  <?php echo $rowsyear[2]; ?>]
        <?php }?>
          ]);
          
          // Create and draw the visualization.
          var chart = new google.visualization.ColumnChart(document.getElementById('visualization2'));
                   function selectHandler() {
             
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var query_string = 'value=0-1&y='+topping;
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
        google.visualization.events.addListener(chart, 'select', selectHandler);
             chart.draw(data,
                   {
                    title:"<?php echo $charttitle ?>",
                    width:divwidth, height:400,
                    hAxis: {title: "Year"},
                     vAxes: {
                            0: {
                                title: 'Deals',
                            },
                            1: {
                                title: 'Amounts'
                            }
                        },
                    colors: ["#a2753a","#FCCB05"],
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "line",curveType: "function"}
                            }
                  }
              );
      }
      google.setOnLoadCallback(drawVisualization);
    </script>
      <?php
        
    }
    else if($type==1 && $vcflagValue==0)
    { ?>
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization2").offsetWidth;
  
  divheight=  document.getElementById("visualization2").offsetHight;
  
        // Create and populate the data table.
          var data = google.visualization.arrayToDataTable([
            ['Year', 'Deals', 'Amount($m)']
            <?php   mysql_data_seek($resultcompany, 0);
            while($rowsyear = mysql_fetch_array($resultcompany))	
        { ?>
            ,['<?php echo $rowsyear[0]; ?>',  <?php echo $rowsyear[1]; ?>,  <?php echo $rowsyear[2]; ?>]
        <?php }?>
          ]);
          
          // Create and draw the visualization.
          var chart = new google.visualization.ColumnChart(document.getElementById('visualization2'));
                   function selectHandler() {
             
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var query_string = 'value=5&y='+topping;
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
        google.visualization.events.addListener(chart, 'select', selectHandler);
             chart.draw(data,
                   {
                    title:"<?php echo $charttitle ?>",
                    width:divwidth, height:400,
                    hAxis: {title: "Year"},
                     vAxes: {
                            0: {
                                title: 'Deals',
                            },
                            1: {
                                title: 'Amounts'
                            }
                        },
                    colors: ["#a2753a","#FCCB05"],
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "line",curveType: "function"}
                            }
                  }
              );
      }
      google.setOnLoadCallback(drawVisualization);
    </script>
      <?php
        
    }
     else if($type==1 && $vcflagValue==1)
    { ?>
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization2").offsetWidth;
  
  divheight=  document.getElementById("visualization2").offsetHight;
  
        // Create and populate the data table.
          var data = google.visualization.arrayToDataTable([
            ['Year', 'Deals', 'Amount($m)']
            <?php   mysql_data_seek($resultcompany, 0);
            while($rowsyear = mysql_fetch_array($resultcompany))	
        { ?>
            ,['<?php echo $rowsyear[0]; ?>',  <?php echo $rowsyear[1]; ?>,  <?php echo $rowsyear[2]; ?>]
        <?php }?>
          ]);
          
          // Create and draw the visualization.
          var chart = new google.visualization.ColumnChart(document.getElementById('visualization2'));
                   function selectHandler() {
             
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var query_string = 'value=1-0&y='+topping;
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
        google.visualization.events.addListener(chart, 'select', selectHandler);
             chart.draw(data,
                   {
                    title:"<?php echo $charttitle ?>",
                    width:divwidth, height:400,
                    hAxis: {title: "Year"},
                     vAxes: {
                            0: {
                                title: 'Deals',
                            },
                            1: {
                                title: 'Amounts'
                            }
                        },
                    colors: ["#a2753a","#FCCB05"],
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "line",curveType: "function"}
                            }
                  }
              );
      }
      google.setOnLoadCallback(drawVisualization);
    </script>
      <?php
        
    }
    else if($type==2 && $hide_pms==1)
    {
        ?>
    
     <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $industry => $values)
                      { 
                          echo ",'".$industry."'";
                       }?>],
                       <?php
                         for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $industry => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);
         var chart1 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart1.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var industry = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
            var query_string = 'value=0-1&y='+topping+'&i='+encodeURIComponent(industry);
             window.location.href = 'svindex.php?'+query_string;
          }
        }

        google.visualization.events.addListener(chart1, 'select', selectHandler);
          chart1.draw(data1,
               {
                title:"By Industry - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Deals"},
                 colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $industry => $values)
                      { 
                          echo ",'".$industry."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $industry => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart2= new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart2.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var industry = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
            var query_string = 'value=4&y='+topping+'&i='+encodeURIComponent(industry);
             window.location.href = 'svindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart2, 'select', selectHandler2);
          chart2.draw(data,
               {
                title:"By Industry - Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                 colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $industry => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$industry."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"By Deal",
       colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $industry => $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$industry."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"By Amout",
       colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});

      }
      
      google.setOnLoadCallback(drawVisualization);
    </script>
    
       
    <? 
     }
      else if($type==2 && $vcflagValue==0)
    {
        ?>
    
     <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $industry => $values)
                      { 
                          echo ",'".$industry."'";
                       }?>],
                       <?php
                         for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $industry => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);
         var chart1 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart1.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var industry = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
            var query_string = 'value=0-0&y='+topping+'&i='+encodeURIComponent(industry);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }

        google.visualization.events.addListener(chart1, 'select', selectHandler);
          chart1.draw(data1,
               {
                title:"By Industry - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Deals"},
                 colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $industry => $values)
                      { 
                          echo ",'".$industry."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $industry => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart2= new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart2.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var industry = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
            var query_string = 'value=0-0&y='+topping+'&i='+encodeURIComponent(industry);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart2, 'select', selectHandler2);
          chart2.draw(data,
               {
                title:"By Industry - Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                 colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $industry => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$industry."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"By Deal",
       colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $industry => $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$industry."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"By Amout",
       colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});

      }
      
      google.setOnLoadCallback(drawVisualization);
    </script>
    
       
    <? 
     }
      else if($type==2 && $vcflagValue==1)
    {
        ?>
    
     <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $industry => $values)
                      { 
                          echo ",'".$industry."'";
                       }?>],
                       <?php
                         for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $industry => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);
         var chart1 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart1.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var industry = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
            var query_string = 'value=1-0&y='+topping+'&i='+encodeURIComponent(industry);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }

        google.visualization.events.addListener(chart1, 'select', selectHandler);
          chart1.draw(data1,
               {
                title:"By Industry - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Deals"},
                 colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $industry => $values)
                      { 
                          echo ",'".$industry."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $industry => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart2= new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart2.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var industry = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
            var query_string = 'value=1-0&y='+topping+'&i='+encodeURIComponent(industry);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart2, 'select', selectHandler2);
          chart2.draw(data,
               {
                title:"By Industry - Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                 colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $industry => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$industry."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"By Deal",
       colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $industry => $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$industry."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"By Amout",
       colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});

      }
      
      google.setOnLoadCallback(drawVisualization);
    </script>
    
       
    <? 
     }
    
    else if($type == 4 && $hide_pms==1 &&  !$_POST)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0-1&y='+topping+'&rg='+encodeURIComponent(range);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Deals"},
                colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0-1&y='+topping+'&rg='+encodeURIComponent(range);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"By Stage - Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $range => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"By Deal",
      colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"By Amout",
      colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});

      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
       
    <? 
     }
     else if($type == 4 && $vcflagValue==0 &&  !$_POST)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0-0&y='+topping+'&rg='+encodeURIComponent(range);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Deals"},
                colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0-0&y='+topping+'&rg='+encodeURIComponent(range);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"By Stage - Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $range => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"By Deal",
      colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"By Amout",
      colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});

      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
       
    <? 
     }
     else if($type == 4 && $vcflagValue==1 &&  !$_POST)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=1-0&y='+topping+'&rg='+encodeURIComponent(range);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Deals"},
                colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=1-0&y='+topping+'&rg='+encodeURIComponent(range);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"By Stage - Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $range => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"By Deal",
      colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"By Amout",
      colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});

      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
       
    <? 
     }
    else if($type==5 && $hide_pms==1)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $InvestorTypeName => $values)
                      { 
                          echo ",'".$InvestorTypeName."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $InvestorTypeName => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart8=new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart8.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var invtype = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0-1&y='+topping+'&inv='+encodeURIComponent(invtype);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Deals"},
                colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $InvestorTypeName => $values)
                      { 
                          echo ",'".$InvestorTypeName."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $InvestorTypeName => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart9=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart9.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var invtype = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0-1&y='+topping+'&inv='+encodeURIComponent(invtype);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
               {
                title:"By Stage - Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $InvestorTypeName => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$InvestorTypeName."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"By Deal",
      colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $InvestorTypeName=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$InvestorTypeName."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"By Amout",
      colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});

      }
      google.setOnLoadCallback(drawVisualization);
    </script>  
    
       
    <? 
     }
      else if($type==5 && $vcflagValue==0)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $InvestorTypeName => $values)
                      { 
                          echo ",'".$InvestorTypeName."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $InvestorTypeName => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart8=new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart8.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var invtype = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0-0&y='+topping+'&inv='+encodeURIComponent(invtype);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Deals"},
                colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $InvestorTypeName => $values)
                      { 
                          echo ",'".$InvestorTypeName."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $InvestorTypeName => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart9=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart9.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var invtype = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0-0&y='+topping+'&inv='+encodeURIComponent(invtype);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
               {
                title:"By Stage - Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $InvestorTypeName => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$InvestorTypeName."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"By Deal",
      colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $InvestorTypeName=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$InvestorTypeName."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"By Amout",
      colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});

      }
      google.setOnLoadCallback(drawVisualization);
    </script>  
    
       
    <? 
     }
      else if($type==5 && $vcflagValue==1)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $InvestorTypeName => $values)
                      { 
                          echo ",'".$InvestorTypeName."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $InvestorTypeName => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart8=new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart8.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var invtype = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=1-0&y='+topping+'&inv='+encodeURIComponent(invtype);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Deals"},
                colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $InvestorTypeName => $values)
                      { 
                          echo ",'".$InvestorTypeName."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $InvestorTypeName => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart9=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart9.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var invtype = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=1-0&y='+topping+'&inv='+encodeURIComponent(invtype);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
               {
                title:"By Stage - Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $InvestorTypeName => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$InvestorTypeName."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"By Deal",
      colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $InvestorTypeName=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$InvestorTypeName."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"By Amout",
      colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});

      }
      google.setOnLoadCallback(drawVisualization);
    </script>  
    
       
    <? 
     }
    if($type == 4 && $hide_pms==1 && $_POST)
    {
        ?>
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0-1&y='+topping+'&rg='+encodeURIComponent(range);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Deals"},
                colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0-1&y='+topping+'&rg='+encodeURIComponent(range);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"By Stage - Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $range => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"By Deal",
      colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"By Amout",
      colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});

      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
    <? 
    }
    else  if($type == 4 && $vcflagValue==0 && $_POST)
    {
        ?>
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0-0&y='+topping+'&rg='+encodeURIComponent(range);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Deals"},
                colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0-0&y='+topping+'&rg='+encodeURIComponent(range);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"By Stage - Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $range => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"By Deal",
      colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"By Amout",
      colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});

      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
    <? 
    }
    else  if($type == 4 && $vcflagValue==1 && $_POST)
    {
        ?>
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=1-0&y='+topping+'&rg='+encodeURIComponent(range);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Deals"},
                colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=1-0&y='+topping+'&rg='+encodeURIComponent(range);
             window.location.href = 'mandaindex.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"By Stage - Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $range => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"By Deal",
      colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"By Amout",
      colors: ["#C0A172","#BAA378","#382E1C","#453823","#2C2416","#FCFCD7","#FDFDC4","#FAFAA7","#FCFC92","#FCFC77","#FAFF5E","#FFF95E","#FFF25E","#FFE55E",
"#FFD85E","#BAA378"]});

      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
    <? 
    }
    ?>
<?php
if($type!=1)
{
 ?>
<tr>
<td width="50%" class="profile-view-left">
 <div id="visualization2" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;"></div>   
</td>
<td class="profile-view-rigth" width="50%" >
  <div id="visualization3" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;"></div>  
</td>
</tr> 

<tr>
<td width="50%" class="profile-view-left" id="chartbar">
    <div id="visualization1" style="max-width: 100%; height: 750px;overflow-x: auto;overflow-y: hidden;"></div>    
</td>
<td  id="chartbar" class="profile-view-rigth" width="50%" >
    <div id="visualization" style="max-width: 100%; height: 700px;overflow-x: auto;overflow-y: hidden;"></div> 
</td>
</tr>
<?php
}
else
{
?>
<tr>
 <td width="100%" class="profile-view-left">
<div id="visualization2" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;"></div>   
</td>
</tr> 
<?php
}
?>
<tr>
    <td class="profile-view-left" colspan="2">
   
 <div class="view-table"><div class="restable" ><table class="responsive" cellpadding="0" cellspacing="0">

   <thead>
   
    <?php
    if($type==1)
    {
        ?>
    
        <tr><th colspan="1" style="text-align:center">Year</th>
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
    ?></thead>
 <tbody>
      <?php
    if($type==1)
    {
        if(mysql_num_rows($resultcompany)>0)
        {
            mysql_data_seek($resultcompany, 0);
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
   
    if($type == 4 && $_POST)
    {
        // print_r($deal);
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
     <div class="showhide-link"><a href="#" class="show_hide" rel="#slidingTable">View  Table</a></div>
</div>
    </form>
    </div>
</td>
</tr>
</table>
 </td>
  <? 
    }
    ?>
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

?>
