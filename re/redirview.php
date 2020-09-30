<?php
    require_once("reconfig.php");
    $companyId=632270771;
    $compId=0;
    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
    include('checklogin.php');
    $totalCount=0;
    $searchString="Undisclosed";
    $searchString=strtolower($searchString);
    $searchString1="Unknown";
    $searchString1=strtolower($searchString1);
    $searchString2="Others";
    $searchString2=strtolower($searchString2);
    
    $vcflagValue = isset($_REQUEST['value']) ? $_REQUEST['value'] :0;
    if($vcflagValue==3){
        $dealvalue = isset($_POST['showdeals']) ? $_POST['showdeals'] :102;
    }
    else{
        $dealvalue = isset($_POST['showdeals']) ? $_POST['showdeals'] :101;
    }
    
    $resetfield=$_POST['resetfield'];
    // Filter exit
    if($resetfield=="allfilterexit") {
        $_POST['industry']="15";
        $_POST['stage']="";
        $_POST['invType']="";
        $_POST['invrange']="";
        $_POST['dealtype']="";
        $_POST['keywordsearch']="";
        $_POST['sectorsearch']="";
        $_POST['companysearch']="";
        $_POST['advisorsearch_legal']="";
        $_POST['advisorsearch_trans']="";
        $_POST['month1']=$_POST['month2']=$_POST['year1']=$_POST['year2']="";
    }
        
    if(trim($_POST['keywordsearch'])!="" || trim($_POST['sectorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="") {
        //$_POST['industry']="";
        $_POST['stage']="";
        $_POST['invType']="";
        $_POST['invrange']="";
        $_POST['dealtype']="";
    }
       
    if($resetfield=="autocomplete") {
        $_POST['autocomplete']="";
        $dirsearch="";
    } else {
        $dirsearch=trim($_POST['autocomplete']);
    }
       
    if($dirsearch !='') {
        if($dealvalue ==101) {
            $dirsearchall=" and Investor like '$dirsearch%'";
        } else if($dealvalue ==102) {
            $dirsearchall=" and  pec.companyname like '$dirsearch%'";
        } else if($dealvalue ==103 || $dealvalue ==104) {
            $dirsearchall=" and  cia.Cianame like '$dirsearch%'";
        }
        $search="";
        $_REQUEST['s']="all";
        $_POST['industry']="";
        $_POST['invType']="";
        $_POST['stage']="";
        $_POST['invrangestart']="";
        $_POST['invrangeend']="";
    }
           
    if($resetfield=="keywordsearch") {
        $_POST['keywordsearch']="";
        $keyword="";
    } else {
        $keyword=trim($_POST['keywordsearch']);
    }
    
    if($resetfield=="companysearch") { 
        $_POST['companysearch']="";
        $companysearch="";
    } else {
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
        $splitStringAcquirer=explode(" ", $advisorsearchstring_legal);
        $splitString1Acquirer=$splitStringAcquirer[0];
        $splitString2Acquirer=$splitStringAcquirer[1];
        $stringToHideAcquirer_legal=$splitString1Acquirer. "+" .$splitString2Acquirer;
    }
    $advisorsearchhidden_trans=ereg_replace(" ","_",$advisorsearchstring_trans);
    
    if($resetfield=="industry")
    {
        $_POST['industry']="";
        $industry="15";
    }
    else
    {
        if( isset( $_POST['industry'] ) ) {
            $industry=trim($_POST['industry']);    
        } else {
            $industry=15;
        }        
    }
    
    if($resetfield=="stage")
    {
        $_POST['stage']="";
        $stageval="--";
    }
    else
    {
        $stageval=$_POST['stage'];
    }
    
    if($_POST['stage'] && $stageval!="")
    {
        $boolStage=true;
    }
    else
    {
        $stage="--";
        $boolStage=false;
    }
    $stageCnt=0;$cnt=0;
    
    $stageCntSql="select count(RETypeId) as cnt from realestatetypes";
    if($rsStageCnt=mysql_query($stageCntSql))
    {
        while($mystagecntrow=mysql_fetch_array($rsStageCnt,MYSQL_BOTH))
        {
            $stageCnt=$mystagecntrow["cnt"];
        }
    }
    if ($boolStage==true)
    {
        $stagevaluehide="";
        foreach($stageval as $stage)
        {
            if($dealvalue==103 || $dealvalue==104)
            {
                $stagevaluehide= $stagevaluehide. " peinv.StageId=" .$stage." or ";
            }
            else{
                $stagevaluehide= $stagevaluehide. " pe.StageId=" .$stage." or ";
            }
        }

        $wherestagehide = $stagevaluehide ;
        $qryDealTypeTitle="Stage  - ";
        $strlength=strlen($wherestagehide);
        $strlength=$strlength-3;
        //echo "<Br>----------------" .$wherestage;
        $wherestagehide= substr ($wherestagehide , 0,$strlength);
        $wherestagehide ="(".$wherestagehide.")";
        //echo "<br>---" .$wherestagehide;
    }
    if($boolStage==true)
    {
        foreach($stageval as $stageid)
        {
            $stagesql= "select REType from realestatetypes where RETypeId=$stageid";
            //	echo "<br>**".$stagesql;
            if ($stagers = mysql_query($stagesql))
            {
                While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH))
                {
                    $cnt=$cnt+1;
                    $name=($myrow["REType"]!="")?$myrow["REType"]:"Other";
                    $stagevaluetext= $stagevaluetext. ",".$name ;
                }
            }
        }
        $stagevaluetext = substr($stagevaluetext, 1);
        if($cnt == $stageCnt)
        {      $stagevaluetext=" All Stages";

        }
    }
    else
    {
        $stagevaluetext="";
    }
    if($getstage !='')
    {
        $stagevaluetext = $getstage;
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
        
    if($resetfield=="dealType")
    {
        $_POST['dealtype']="";
        $dealtype="";
    }
    else
    {
        $dealtype=trim($_POST['dealtype']);
    }

    if($resetfield=="range")
    {
        $_POST['invrange']="";
        $range="--";
    }
    else
    {
        $range=$_POST['invrange'];
    }
    
    $whereind="";
    $whereinvType="";
    $wherestage="";
    $wheredates="";
    $whererange="";
    
    if($resetfield=="period" && !$_GET)
    {
        
        $_POST['month1']=$_POST['month2']=$_POST['year1']=$_POST['year2']="";
        $month1=01;
        $year1 = 2005;
        $month2=date('n');
        $year2 = date('Y');
    }
    else
    {
        $month1=($_POST['month1']) ?  $_POST['month1'] : 01;
        $year1 = ($_POST['year1']) ?  $_POST['year1'] : 2005;
        $month2=($_POST['month2']) ?  $_POST['month2'] : date('n');
        $year2 = ($_POST['year2']) ?  $_POST['year2'] : date('Y');
    }
    $datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
    $splityear1=(substr($year1,2));
    $splityear2=(substr($year2,2));
    if(($month1!="") && ($month2!=="") && ($year1!="") &&($year2!=""))
    {	
        $datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
        $datevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
        $wheredates1= "";
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
    
    if($range != "--")
    {
        $rangesql= "select startRange,EndRange,RangeText from investmentrange where InvestRangeId=". $range ." ";
        if ($rangers = mysql_query($rangesql))
        {
            While($myrow=mysql_fetch_array($rangers, MYSQL_BOTH))
            {
                $startRangeValue=$myrow["startRange"];
                $endRangeValue=$myrow["EndRange"];
                $RangeText=$myrow["RangeText"];
            }
        }
    }
    
    if($industry >0)
    {
        $industrysql= "select industry from reindustry where IndustryId=$industry";
        if ($industryrs = mysql_query($industrysql))
        {
            While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
            {
                $industryvalue=$myrow["industry"];
            }
        }
    }

    if($investorType !="")
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
    
    //        if($boolStage==true)
//        {
//                foreach($stageval as $stageid)
//                {
//                         $stagesql= "select REType from realestatetypes where RETypeId=$stage";
//                //	echo "<br>**".$stagesql;
//                        if ($stagers = mysql_query($stagesql))
//                        {
//                                While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH))
//                                {
//                                        $stagevaluetext= $stagevaluetext. ",".$myrow["Stage"] ;
//                                }
//                        }
//                }
//                $stagevaluetext =substr_replace($stagevaluetext, '', 0,1);
//        }
//        else
//        {
//                $stagevaluetext="";
//        }
//        //echo "<br>*************".$stagevaluetext;
    if($vcflagValue!=3)
    {
        if($dealtype !="")
        {
            $dealtypesql = "select DealTypeId,DealType from dealtypes where DealTypeId='$dealtype'";
            if ($dealrs = mysql_query($dealtypesql))
            {
                While($myrow=mysql_fetch_array($dealrs, MYSQL_BOTH))
                {
                    $dealtypevalue=$myrow["DealType"];
                }
            }
        }
    }
    else{
        if($dealtype !="")
        {

            $dealtypesql = "select MADealTypeId,MADealType from madealtypes where MADealTypeId='$dealtype'";
            if ($dealrs = mysql_query($dealtypesql))
            {
                While($myrow=mysql_fetch_array($dealrs, MYSQL_BOTH))
                {
                    $dealtypevalue=$myrow["MADealType"];
                }
            }
        }
    }

    if($vcflagValue==1 || $_POST['keywordsearch']!='' || $_POST['sectorsearch']!='' || $_POST['advisorsearch_legal']!='' || $_POST['advisorsearch_trans']!='' || $_POST['companysearch']!='' || $_POST['industry']!='' || $_POST['stage']!='' || $_POST['invType']!='' || $_POST['invrange']!=""
    || ($_POST['month1']!="" && $_POST['month1']!="--" && $_POST['year1']!="--" && $_POST['year1']!="" && $_POST['month2']!="" && $_POST['month2']!="--" && $_POST['year2']!="--" && $_POST['year2']!=""))  
    {
        $search= isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
        $_REQUEST['s']=isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
    }
    else
    {
        $search= isset($_REQUEST['s']) ? $_REQUEST['s'] : 'a';
        $_REQUEST['s']=isset($_REQUEST['s']) ? $_REQUEST['s'] : 'a';
    }

    if($search !='')
    {
        if($dealvalue ==101)
        {
            $search=" and Investor like '$search%'";
        }
        else if($dealvalue ==102)
        {
            $search=" and  pec.companyname like '$search%'";
        }
        else if($dealvalue ==103 || $dealvalue ==104)
        {
            $search=" and  cia.Cianame like '$search%'";
        }
    }
    
//----------------------------------------Query starts-----------------------------------------------------------------
    if($vcflagValue==0){
        
        if($dealvalue==101){
            
            if($keyword!="")
            {
                $whereind = " and pe.IndustryId=15 ";
                if ($industry > 0) {
                    if( $industry != '15' ) {
                        $whereind = " and pe.IndustryId=" .$industry. " ";
                    }
                }
                $showallsql="select distinct peinv.InvestorId,inv.Investor
                from REinvestments_investors as peinv,REinvestments as pe,realestatetypes as s,REinvestors as inv,REcompanies as pec
                where peinv.PEId=pe.PEId " . $whereind . "
                and inv.InvestorId=peinv.InvestorId 
                and pe.StageId=s.REtypeId 
                and pe.PECompanyId=pec.PECompanyId 
                and pe.Deleted=0  
                and Investor like '%$keyword%' 
                and Investor !='' 
                order by inv.Investor ";
                
                $totalallsql=$showallsql;
            }
            else if($companysearch!="")
            {
                $whereind = " and pe.IndustryId=15 ";
                if ($industry > 0) {
                    if( $industry != '15' ) {
                        $whereind = " and pe.IndustryId=" .$industry. " ";
                    }
                }
                $showallsql="select distinct peinv.InvestorId,inv.Investor
                from REinvestments_investors as peinv,REinvestments as pe,realestatetypes as s,REinvestors as inv,REcompanies as pec
                where peinv.PEId=pe.PEId " . $whereind . "
                and inv.InvestorId=peinv.InvestorId 
                and pe.StageId=s.REtypeId 
                and pe.PECompanyId=pec.PECompanyId 
                and pe.Deleted=0  
                and pec.companyname like '%$companysearch%' and inv.Investor !='' 
                order by inv.Investor ";

                $totalallsql=$showallsql;
            }
            else if($sectorsearch!="")
            {
                $whereind = " and pe.IndustryId=15 ";
                if ($industry > 0) {
                    if( $industry != '15' ) {
                        $whereind = " and pe.IndustryId=" .$industry. " ";
                    }
                }
                $showallsql="select distinct peinv.InvestorId,inv.Investor
                from REinvestments_investors as peinv,REinvestments as pe,realestatetypes as s,REinvestors as inv,REcompanies as pec
                where peinv.PEId=pe.PEId " . $whereind . "
                and inv.InvestorId=peinv.InvestorId 
                and pe.StageId=s.REtypeId 
                and pe.PECompanyId=pec.PECompanyId 
                and pe.Deleted=0  
                and pec.sector_business like '%$sectorsearch%'  and inv.Investor !=''
                order by inv.Investor ";

                $totalallsql=$showallsql;
            }
            elseif($advisorsearchstring_legal!="")
            {
                $whereind = " and peinv.IndustryId=15 ";
                if ($industry > 0) {
                    if( $industry != '15' ) {
                        $whereind = " and peinv.IndustryId=" .$industry. " ";
                    }
                }   
                $showallsql="(SELECT REinvi.InvestorId, ras.Investor ,
                (SELECT GROUP_CONCAT( REinvoinv.InvestorId ) FROM REinvestments_investors AS REinvoinv, REinvestors AS REinv WHERE REinvoinv.PEId = peinv.PEId AND REinv.InvestorId = REinvoinv.InvestorId ) AS InvestorId
                FROM REinvestments AS peinv, REcompanies AS c, REinvestments_investors AS REinvi, REinvestors AS ras, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                WHERE peinv.Deleted =0 " . $whereind . "
                AND peinv.IndustryId = i.industryid
                AND c.PECompanyId = peinv.PECompanyId
                AND adac.CIAId = cia.CIAID
                AND adac.PEId = peinv.PEId
                AND REinvi.PEId = peinv.PEId
                AND ras.InvestorId = REinvi.InvestorId
                AND AdvisorType = 'L'
                AND cia.cianame LIKE '$advisorsearchstring_legal%' and ras.Investor !=''
                GROUP BY peinv.PEId)
                UNION 
                (SELECT REinvi.InvestorId, ras.Investor ,
                (SELECT GROUP_CONCAT( REinvoinv.InvestorId ) FROM REinvestments_investors AS REinvoinv, REinvestors AS REinv WHERE REinvoinv.PEId = peinv.PEId AND REinv.InvestorId = REinvoinv.InvestorId ) AS InvestorId
                FROM REinvestments AS peinv, REcompanies AS c, REinvestments_investors AS REinvi, REinvestors AS ras, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                WHERE peinv.Deleted =0 " . $whereind . "
                AND peinv.IndustryId = i.industryid
                AND c.PECompanyId = peinv.PECompanyId
                AND adac.CIAId = cia.CIAID
                AND adac.PEId = peinv.PEId
                AND REinvi.PEId = peinv.PEId
                AND ras.InvestorId = REinvi.InvestorId
                AND AdvisorType = 'L'
                AND cia.cianame LIKE '$advisorsearchstring_legal%' and ras.Investor !=''
                GROUP BY peinv.PEId)";
                        
                $totalallsql=$showallsql;
            }
            elseif($advisorsearchstring_trans!="")
            {
                $whereind = " and peinv.IndustryId=15 ";
                if ($industry > 0) {
                    if( $industry != '15' ) {
                        $whereind = " and peinv.IndustryId=" .$industry. " ";
                    }
                }
                $showallsql="(SELECT REinvi.InvestorId, ras.Investor ,
                (SELECT GROUP_CONCAT( REinvoinv.InvestorId ) FROM REinvestments_investors AS REinvoinv, REinvestors AS REinv WHERE REinvoinv.PEId = peinv.PEId AND REinv.InvestorId = REinvoinv.InvestorId) AS InvestorId
                FROM REinvestments AS peinv, REcompanies AS c, REinvestments_investors AS REinvi, REinvestors AS ras, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                WHERE peinv.Deleted =0 " . $whereind . "
                AND peinv.IndustryId = i.industryid
                AND c.PECompanyId = peinv.PECompanyId
                AND adac.CIAId = cia.CIAID
                AND adac.PEId = peinv.PEId
                AND REinvi.PEId = peinv.PEId
                AND ras.InvestorId = REinvi.InvestorId
                AND AdvisorType = 'T'
                AND cia.cianame LIKE '$advisorsearchstring_trans%' and ras.Investor !=''
                GROUP BY peinv.PEId)
                UNION 
                (SELECT REinvi.InvestorId, ras.Investor ,
                (SELECT GROUP_CONCAT( REinvoinv.InvestorId ) FROM REinvestments_investors AS REinvoinv, REinvestors AS REinv WHERE REinvoinv.PEId = peinv.PEId AND REinv.InvestorId = REinvoinv.InvestorId) AS InvestorId
                FROM REinvestments AS peinv, REcompanies AS c, REinvestments_investors AS REinvi, REinvestors AS ras, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                WHERE peinv.Deleted =0 " . $whereind . "
                AND peinv.IndustryId = i.industryid
                AND c.PECompanyId = peinv.PECompanyId
                AND adac.CIAId = cia.CIAID
                AND adac.PEId = peinv.PEId
                AND REinvi.PEId = peinv.PEId
                AND ras.InvestorId = REinvi.InvestorId
                AND AdvisorType = 'T'
                AND cia.cianame LIKE '$advisorsearchstring_trans%' and ras.Investor !=''
                GROUP BY peinv.PEId)";

                $totalallsql=$showallsql;
            }
            elseif($searchallfield!="")
            {
                $whereind = " and pe.IndustryId=15 ";
                if ($industry > 0) {
                    if( $industry != '15' ) {
                        $whereind = " and pe.IndustryId=" .$industry. " ";
                    }
                }
                $showallsql="select distinct peinv.InvestorId,inv.Investor
                from REinvestments_investors as peinv,REinvestments as pe,realestatetypes as s,REinvestors as inv,REcompanies as pec
                where peinv.PEId=pe.PEId " . $whereind . "
                and inv.InvestorId=peinv.InvestorId 
                and pe.StageId=s.REtypeId 
                and pe.PECompanyId=pec.PECompanyId 
                and pe.Deleted=0  
                and Investor like '%$searchallfield%'  and inv.Investor !=''
                order by inv.Investor ";

                $totalallsql=$showallsql;
            }
            else{
                
                $yourquery=1;
                $dt1 = $year1."-".$month1."-01";
                $dt2 = $year2."-".$month2."-01";

                $getInvestorSqlreal = "select distinct peinv.InvestorId,inv.Investor
                from REinvestments_investors as peinv,REinvestments as pe,REcompanies as pec,realestatetypes as s,REinvestors as inv,industry as i
                where ";
                //echo "<br> individual where clauses have to be merged ";
                $whereind = " pe.IndustryId=15";
                if ($industry > 0)
                    if( $industry != '15' ) {
                        $whereind = " pe.IndustryId=" .$industry ;
                    }
                if ($investorType!= "" && $investorType!= "--")
                    $whereInvType = " pe.InvestorType = '".$investorType."'";

                if (($startRangeValue!= "") && ($endRangeValue != ""))
                if ($range!= "--" && $range!= "" )
                {
                   if($startRangeValue < $endRangeValue)
                        $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                   elseif($startRangeValue == $endRangeValue)
                        $whererange = " pe.amount >= ".$startRangeValue ."";
                }
                
                if(($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                    $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                
                if ($whereind != "")
                {
                    $getInvestorSqlreal=$getInvestorSqlreal . $whereind ." and ";
                    $bool=true;
                }
                else
                {
                    $bool=false;
                }
                
                if (($wherestagehide != ""))
                {
                    $getInvestorSqlreal=$getInvestorSqlreal . $wherestagehide . " and " ;
                    $bool=true;
                }
                
                if (($whereInvType != "") )
                {
                    $getInvestorSqlreal=$getInvestorSqlreal .$whereInvType . " and ";
                    $bool=true;
                }
                                    
                if (($whererange != "") )
                {
                    $getInvestorSqlreal=$getInvestorSqlreal .$whererange . " and ";
                    $bool=true;
                }
                                    
                if(($wheredates != "") )
                {
                    $getInvestorSqlreal = $getInvestorSqlreal . $wheredates ." and ";
                    $bool=true;
                }
                
                $totalallsql=$getInvestorSqlreal . " pe.PECompanyId=pec.PECompanyId 
                and peinv.PEId=pe.PEId and 
                inv.InvestorId=peinv.InvestorId 
                and pe.StageId=s.REtypeId 
                and pe.IndustryId=i.IndustryId 
                and pe.Deleted=0 and inv.Investor !='' " .$addVCFlagqry. " ".$dirsearchall." 
                order by inv.Investor ";

                $getInvestorSqlreal = $getInvestorSqlreal . " pe.PECompanyId=pec.PECompanyId 
                and peinv.PEId=pe.PEId 
                and inv.InvestorId=peinv.InvestorId 
                and pe.StageId=s.REtypeId 
                and pe.IndustryId=i.IndustryId 
                and pe.Deleted=0 and inv.Investor !='' " .$addVCFlagqry. " " .$search." ".$dirsearchall." 
                order by inv.Investor ";
                	
                 $showallsql= $getInvestorSqlreal; 
            }
            //echo "<br><br>WHERE CLAUSE SQL---" .$getInvestorSqlreal;
        }
        elseif($dealvalue==102){
                   
                if($keyword!="")
		{
                    $whereind = " and pe.IndustryId=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pe.IndustryId=" .$industry. " ";
                        }
                    }
			
                    $showallsql=" SELECT pe.PECompanyId  as PECompanyId, pec.* FROM REinvestments_investors as peinv,REinvestments as pe,realestatetypes as s,REinvestors as inv,
                        REcompanies AS pec, reindustry AS i WHERE peinv.PEId=pe.PEId " . $whereind . " and inv.InvestorId=peinv.InvestorId and
                     pe.StageId=s.REtypeId and pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 and Investor like '%$keyword%' and inv.Investor !='' group by pe.PECompanyId ORDER BY pec.companyname";

                    $totalallsql=$showallsql; 
		}
                else if($companysearch!="")
		{
                    $whereind = " and pe.IndustryId=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pe.IndustryId=" .$industry. " ";
                        }
                    }
                    $showallsql="SELECT pe.PECompanyId  as PECompanyId, pec.* FROM REinvestments AS pe,REcompanies AS pec, reindustry AS i
                            WHERE pe.IndustryId = i.industryid " . $whereind . " AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 and pec.companyname like '%$companysearch%' 
                            group by pe.PECompanyId ORDER BY pec.companyname";
                    $totalallsql=$showallsql; 
		}
                else if($sectorsearch!="")
		{
                    $whereind = " and pe.IndustryId=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pe.IndustryId=" .$industry. " ";
                        }
                    }
			$showallsql=" SELECT pe.PECompanyId  as PECompanyId, pec.* FROM REinvestments_investors as peinv,REinvestments as pe,realestatetypes as s,REinvestors as inv,
                           REcompanies AS pec, reindustry AS i WHERE peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
			pe.StageId=s.REtypeId and pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 and pec.sector_business like '%$sectorsearch%' and inv.Investor !='' group by pe.PECompanyId ORDER BY pec.companyname";

                        $totalallsql=$showallsql;
		}
                elseif($advisorsearchstring_legal!="")
                {
                    $whereind = " and peinv.IndustryId=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and peinv.IndustryId=" .$industry. " ";
                        }
                    }
                       $showallsql="(
                        SELECT peinv.PECompanyId  as PECompanyId, c.*
                        FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                        WHERE peinv.Deleted=0 " . $whereind . " and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='L'
                        AND cia.cianame LIKE '$advisorsearchstring_legal%' GROUP BY peinv.PEId
                        )
                        UNION (
                        SELECT peinv.PECompanyId  as PECompanyId, c.*
                        FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                        WHERE peinv.Deleted=0 " . $whereind . " and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='L'
                        AND cia.cianame LIKE '$advisorsearchstring_legal%' GROUP BY peinv.PEId
                        )";
                       $totalallsql=$showallsql;
                }
                elseif($advisorsearchstring_trans!="")
                {
                    $whereind = " and peinv.IndustryId=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and peinv.IndustryId=" .$industry. " ";
                        }
                    }
                   $showallsql="(
                        SELECT peinv.PECompanyId  as PECompanyId, c.* 
                        FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                        WHERE peinv.Deleted=0 " . $whereind . " and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='T'
                        AND cia.cianame LIKE '$advisorsearchstring_trans%' GROUP BY peinv.PEId
                        )
                        UNION (
                        SELECT peinv.PECompanyId  as PECompanyId, c.*
                        FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                        WHERE peinv.Deleted=0 " . $whereind . " and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='T'
                        AND cia.cianame LIKE '$advisorsearchstring_trans%' GROUP BY peinv.PEId
                        )";
                   $totalallsql=$showallsql;
               }
                elseif($searchallfield!="")
		{
                    $whereind = " and pe.IndustryId=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pe.IndustryId=" .$industry. " ";
                        }
                    }
			 $showallsql="SELECT pe.PECompanyId  as PECompanyId, pec.* FROM REinvestments AS pe,REcompanies AS pec, reindustry AS i
                                WHERE pe.IndustryId = i.industryid " . $whereind . " AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 and pec.companyname like '%$searchallfield%' 
                                group by pe.PECompanyId ORDER BY pec.companyname";
                         $totalallsql=$showallsql;
		}
                else{
                    $dt1 = $year1."-".$month1."-01";
                $dt2 = $year2."-".$month2."-01";
                   $getcompanysqlreal="SELECT pe.PECompanyId  as PECompanyId, pec.* FROM REinvestments AS pe,REcompanies AS pec, reindustry AS i
				WHERE";
                        $whereind = " pe.IndustryId=15";
                        if ($industry > 0)
                            if( $industry != 15 ) {
                                $whereind = " pe.IndustryId=" .$industry ;    
                            }
                        if ($investorType!= "")
                            $whereInvType = " pe.InvestorType = '".$investorType."'";
                        
                        if (($startRangeValue!= "") && ($endRangeValue != "")){
                               if ($range!= "--" && $range!= "" )
                                {
                                                if($startRangeValue < $endRangeValue)
                                                        $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                                elseif($startRangeValue == $endRangeValue)
                                                        $whererange = " pe.amount >= ".$startRangeValue ."";
                                }
                        }
                        if($dt1!='' && $dt2!='')
                               $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                        if ($whereind != "")
                        {
                                $getcompanysqlreal=$getcompanysqlreal . $whereind ." and ";

                                $bool=true;
                        }
                        else
                        {
                                $bool=false;
                        }
                               
                        if (($wherestagehide != ""))
                        {
                                $getcompanysqlreal=$getcompanysqlreal . $wherestagehide . " and " ;
                                $bool=true;
                        }
                        if (($whereInvType != "") )
                        {
                                $getcompanysqlreal=$getcompanysqlreal .$whereInvType . " and ";
                                $bool=true;
                        }
                        if (($whererange != "") )
                        {
                                $getcompanysqlreal=$getcompanysqlreal .$whererange . " and ";
                                $bool=true;
                        }
                        if(($wheredates != "") )
                        {
                                $getcompanysqlreal = $getcompanysqlreal . $wheredates ." and ";
                                $bool=true;
                        }
                        $totalallsql=$getcompanysqlreal." pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 " .$addVCFlagqry. " 
                                    ".$dirsearchall." group by pe.PECompanyId ORDER BY pec.companyname";
                        $getcompanysqlreal = $getcompanysqlreal." pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 " .$addVCFlagqry. "
                                            " .$search." ".$dirsearchall." group by pe.PECompanyId ORDER BY pec.companyname";
                                            
                        $showallsql= $getcompanysqlreal;
                }
                //echo "<br><br>WHERE CLAUSE SQL---" .$getcompanysqlreal;
            }
            elseif($dealvalue==103 || $dealvalue==104){
                   
                if($dealvalue == 103)
                {
                    $adtype = "L";
                }
                else
                {
                    $adtype = "T";
                }
                
                if($keyword!="")
		{
                    $whereind = " and peinv.IndustryId=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and peinv.IndustryId=" .$industry. " ";
                        }
                    }
                    $showallsql="(
                     SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId 
                     FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac,REinvestors as inv,REinvestments_investors AS REinvi
                     WHERE peinv.Deleted=0 " . $whereind . " and peinv.IndustryId = i.industryid and peinv.PEId=REinvi.PEId and REinvi.InvestorId=inv.InvestorId AND c.PECompanyId = peinv.PECompanyId
                     AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                     AND Investor like '%$keyword%'  and inv.Investor !='' GROUP BY peinv.PEId
                     )
                     UNION (
                     SELECT  cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                     FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac,REinvestors as inv,REinvestments_investors AS REinvi
                     WHERE peinv.Deleted=0 " . $whereind . " and peinv.IndustryId = i.industryid and peinv.PEId=REinvi.PEId and REinvi.InvestorId=inv.InvestorId AND c.PECompanyId = peinv.PECompanyId
                     AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                     AND Investor like '%$keyword%' and inv.Investor !='' GROUP BY peinv.PEId
                     )";  
                    $totalallsql=$showallsql;
		}
                else if($companysearch!="")
		{
                    $whereind = " and peinv.IndustryId=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and peinv.IndustryId=" .$industry. " ";
                        }
                    }
                        $showallsql="(
                        SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId 
                        FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                        WHERE peinv.Deleted=0 " . $whereind . " and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                        AND c.companyname like '%$companysearch%' GROUP BY peinv.PEId
                        )
                        UNION (
                        SELECT  cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                        FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                        WHERE peinv.Deleted=0 " . $whereind . " and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                        AND c.companyname like '%$companysearch%' GROUP BY peinv.PEId
                        )";
                        $totalallsql=$showallsql;
		}
                else if($sectorsearch!="")
		{ 
                    $whereind = " and peinv.IndustryId=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and peinv.IndustryId=" .$industry. " ";
                        }
                    }
                        $showallsql="(
                        SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId 
                        FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                        WHERE peinv.Deleted=0 " . $whereind . " and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                        AND c.sector_business like '%$sectorsearch%' GROUP BY peinv.PEId
                        )
                        UNION (
                        SELECT  cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                        FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                        WHERE peinv.Deleted=0 " . $whereind . " and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                        AND c.sector_business like '%$sectorsearch%' GROUP BY peinv.PEId
                        )";
                        $totalallsql=$showallsql;
		}
                elseif($advisorsearchstring_legal!="")
                {
                    $whereind = " and peinv.IndustryId=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and peinv.IndustryId=" .$industry. " ";
                        }
                    }
                $showallsql="(
                        SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId 
                        FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                        WHERE peinv.Deleted=0 " . $whereind . " and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                        AND cia.cianame LIKE '$advisorsearchstring_legal%'  GROUP BY peinv.PEId
                        )
                        UNION (
                        SELECT  cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                        FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                        WHERE peinv.Deleted=0 " . $whereind . " and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                        AND cia.cianame LIKE '$advisorsearchstring_legal%' GROUP BY peinv.PEId
                        )";
//			echo "<Br>ADvisor search--" . $companysql;
                    $totalallsql=$showallsql;
                    
                }
                elseif($advisorsearchstring_trans!="")
                {
                    $whereind = " and peinv.IndustryId=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and peinv.IndustryId=" .$industry. " ";
                        }
                    }
                $showallsql="(
                        SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId 
                        FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                        WHERE peinv.Deleted=0 " . $whereind . " and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                        AND cia.cianame LIKE '$advisorsearchstring_trans%'  GROUP BY peinv.PEId
                        )
                        UNION (
                        SELECT  cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                        FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                        WHERE peinv.Deleted=0 " . $whereind . " and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                        AND cia.cianame LIKE '$advisorsearchstring_trans%' GROUP BY peinv.PEId
                        )";
//				echo "<Br>Trans search--" . $companysql;
                    $totalallsql=$showallsql;
               }
                elseif($searchallfield!="")
		{
                    $whereind = " and peinv.IndustryId=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and peinv.IndustryId=" .$industry. " ";
                        }
                    }
			$showallsql="(
                        SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId 
                        FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                        WHERE peinv.Deleted=0 " . $whereind . " and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                        AND cia.cianame LIKE '$searchallfield%'  GROUP BY peinv.PEId
                        )
                        UNION (
                        SELECT  cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                        FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                        WHERE peinv.Deleted=0 " . $whereind . " and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                        AND cia.cianame LIKE '$searchallfield%' GROUP BY peinv.PEId
                        )";
                        
                        $totalallsql=$showallsql;

		//echo "<br> allsearchfield search- ".$InvestorSqlreal;
		}
                else{
                    $dt1 = $year1."-".$month1."-01";
                    $dt2 = $year2."-".$month2."-01";
                    $companysql= "(SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac WHERE";
                    $companysql2= "SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac WHERE";

                    //echo "<br> individual where clauses have to be merged ";
                    $whereind = " peinv.IndustryId=15";
                    if ($industry > 0)
                        if( $industry != 15 ) {
                            $whereind = " peinv.IndustryId=" .$industry ;    
                        }
                    if ($investorType!= "")
                        $whereInvType = " peinv.InvestorType = '".$investorType."'";
                    
                    if (($startRangeValue!= "") && ($endRangeValue != "")){
                        if ($range!= "--" && $range!= "" )
                         {
                             if($startRangeValue < $endRangeValue)
                                     $whererange = " peinv.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                             elseif($startRangeValue == $endRangeValue)
                                     $whererange = " peinv.amount >= ".$startRangeValue ."";
                         }
                    }
                    if($dt1!='' && $dt2!='')
                        $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                    
                        if ($whereind != "")
                        {
                                $companysql=$companysql . $whereind ." and ";
                                $companysql2=$companysql2 . $whereind ." and ";
                        }

                        if ($whereInvType != "")
                        {
                                $companysql=$companysql . $whereInvType ." and ";
                                $companysql2=$companysql2 . $whereInvType ." and ";
                        }
                        if (($wherestagehide != ""))
                        {
                                 $companysql=$companysql .$wherestagehide . " and ";
                                $companysql2=$companysql2 .$wherestagehide . " and ";
                        }          
                        if (($whererange != "") )
                        {
                                $companysql=$companysql .$whererange . " and ";
                                $companysql2=$companysql2 .$whererange . " and ";
                        }


                        if(($wheredates != "") )
                        {
                                $companysql = $companysql.$wheredates ." and ";
                                $companysql2 = $companysql2.$wheredates ." and ";
                        }
                        
                        $companysqltot = $companysql ." peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                    AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='".$adtype ."' ".$dirsearchall."  GROUP BY peinv.PEId";


                        $companysqltot2 = $companysql2 ." peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                    AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='".$adtype ."' ".$dirsearchall."  GROUP BY peinv.PEId";
                        
                         $companysql = $companysql ." peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                    AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall."  GROUP BY peinv.PEId";


                        $companysql2 = $companysql2 ." peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                    AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall."  GROUP BY peinv.PEId";


                        $showallsql=$companysql.") UNION (".$companysql2.") ";
                        $totalallsql=$companysqltot.") UNION (".$companysqltot2.") ";

                        $orderby="order by Cianame"; 
                        $showallsql=$showallsql.$orderby;
                }
            }
        }
        elseif($vcflagValue==1){
            
            if($dealvalue==101){
                if($keyword!="")
		{
                    $whereind = " and pec.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pec.industry=" .$industry. " ";
                        }
                    }
                        $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                        FROM REipos AS pe, REcompanies AS pec, REipo_investors AS peinv, REinvestors AS inv
                        WHERE pe.PECompanyId = pec.PEcompanyId " . $whereind . "
                        AND peinv.IPOId = pe.IPOId
                        AND inv.InvestorId = peinv.InvestorId
                        AND pe.Deleted=0 and Investor like '%$keyword%'
                        and Investor !=''  order by inv.Investor ";
                        
                        $totalallsql=$showallsql;
		}
                else if($companysearch!="")
		{ 
                    $whereind = " and pec.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pec.industry=" .$industry. " ";
                        }
                    }
                        $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                        FROM REipos AS pe, REcompanies AS pec, REipo_investors AS peinv, REinvestors AS inv
                        WHERE pe.PECompanyId = pec.PEcompanyId " . $whereind . "
                        AND peinv.IPOId = pe.IPOId
                        AND inv.InvestorId = peinv.InvestorId
                        AND pe.Deleted=0 and pec.companyname like '%$companysearch%' and inv.Investor !='' order by inv.Investor ";
                        
                         $totalallsql=$showallsql;
		}
                elseif($searchallfield!="")
		{
                    $whereind = " and pec.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pec.industry=" .$industry. " ";
                        }
                    }
                       $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                        FROM REipos AS pe, REcompanies AS pec, REipo_investors AS peinv, REinvestors AS inv
                        WHERE pe.PECompanyId = pec.PEcompanyId " . $whereind . "
                        AND peinv.IPOId = pe.IPOId
                        AND inv.InvestorId = peinv.InvestorId
                        AND pe.Deleted=0 and Investor like '%$searchallfield%' and inv.Investor !='' order by inv.Investor ";
                        
                         $totalallsql=$showallsql;
		}
                else{
                        $yourquery=1;
                        $dt1 = $year1."-".$month1."-01";
                        //echo "<BR>DATE1---" .$dt1;
                        $dt2 = $year2."-".$month2."-01";

                        $getInvestorSqlreal = "SELECT DISTINCT inv.InvestorId, inv.Investor
                        FROM REipos AS pe, REcompanies AS pec, REipo_investors AS peinv, REinvestors AS inv
                        WHERE";

                        //echo "<br> individual where clauses have to be merged ";
                        $whereind = " pec.industry=15";
                       if ($industry > 0)
                       {
                            if( $industry != 15 ) {
                                $whereind = " pec.industry=" .$industry;    
                            }
                       }

                        if(($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                            $wheredates= " IPODate between '" . $dt1. "' and '" . $dt2 . "'";

                        if ($whereind != "")
                        {
                                $getInvestorSqlreal=$getInvestorSqlreal . $whereind ." and ";
                                $bool=true;
                        }
                        else
                        {
                                $bool=false;
                        }
                        if(($wheredates != "") )
                        {
                                $getInvestorSqlreal = $getInvestorSqlreal . $wheredates ." and ";
                                $bool=true;
                        }
                        
                        $totalallsql = $getInvestorSqlreal . " pe.PECompanyId = pec.PEcompanyId
                        AND peinv.IPOId = pe.IPOId AND inv.InvestorId = peinv.InvestorId AND pe.Deleted=0 and inv.Investor !='' ".$dirsearchall." order by inv.Investor";
                        
                        $getInvestorSqlreal = $getInvestorSqlreal . " pe.PECompanyId = pec.PEcompanyId
                        AND peinv.IPOId = pe.IPOId AND inv.InvestorId = peinv.InvestorId AND pe.Deleted=0 and inv.Investor !='' " .$search." ".$dirsearchall."  order by inv.Investor";

                        //	echo "<br><br>WHERE CLAUSE SQL---" .$getInvestorSqlreal;
                         $showallsql= $getInvestorSqlreal; 
                    }
                        
                        
               }
               elseif($dealvalue==102){
                   
                if($keyword!="")
		{
                    $whereind = " and pec.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pec.industry=" .$industry. " ";
                        }
                    }
                    
                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec.*
                    FROM REipos AS pe, REcompanies AS pec, REipo_investors AS peinv, REinvestors AS inv
                    WHERE pe.PECompanyId = pec.PEcompanyId " . $whereind . "
                    AND peinv.IPOId = pe.IPOId
                    AND inv.InvestorId = peinv.InvestorId
                    AND pe.Deleted=0 and Investor like '%$keyword%' and inv.Investor !='' order by inv.Investor ";
                    $totalallsql=$showallsql; 
		}
                else if($companysearch!="")
		{
                    $whereind = " and pec.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pec.industry=" .$industry. " ";
                        }
                    }
                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec.* FROM REcompanies AS pec, REipos AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId " . $whereind . " and pe.Deleted=0 and pec.companyname like '%$companysearch%' ORDER BY pec.companyname";
                    $totalallsql=$showallsql; 
		}
                elseif($searchallfield!="")
		{
                    $whereind = " and pec.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pec.industry=" .$industry. " ";
                        }
                    }
                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec.* FROM REcompanies AS pec, REipos AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId " . $whereind . " and pe.Deleted=0 and pec.companyname like '%$searchallfield%' ORDER BY pec.companyname";
                    
                    $totalallsql=$showallsql;
		}
                else{
                    $dt1 = $year1."-".$month1."-01";
                    $dt2 = $year2."-".$month2."-01";
                   $getcompanysqlreal="SELECT DISTINCT pe.PECompanyId, pec.* FROM REcompanies AS pec, REipos AS pe, reindustry AS i WHERE";
                        $whereind = " pec.industry=15";
                        if ($industry > 0)
                            if( $industry != 15 ) {
                                $whereind = " pec.industry=" .$industry ;    
                            }                        
                        if($dt1!='' && $dt2!='')
                               $wheredates= " IPODate between '" . $dt1. "' and '" . $dt2 . "'";
                        if ($whereind != "")
                        {
                                $getcompanysqlreal=$getcompanysqlreal . $whereind ." and ";
                                $bool=true;
                        }
                        else
                        {
                                $bool=false;
                        }
                        
                        if(($wheredates != "") )
                        {
                                $getcompanysqlreal = $getcompanysqlreal . $wheredates ." and ";
                                $bool=true;
                        }
                        $totalallsql=$getcompanysqlreal." pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 
                                    ".$dirsearchall."  ORDER BY pec.companyname";
                        $getcompanysqlreal = $getcompanysqlreal." pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 
                                            " .$search." ".$dirsearchall."  ORDER BY pec.companyname";
                                            
                        $showallsql= $getcompanysqlreal;
                }
            }
        }
        elseif($vcflagValue==2){
            if($dealvalue==101){
                if($keyword!="")
		{
                    $whereind = " and pec.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pec.industry=" .$industry. " ";
                        }
                    }
                        $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                        FROM REmanda AS pe, REcompanies AS pec, REmanda_investors AS peinv, REinvestors AS inv
                        WHERE pe.PECompanyId = pec.PEcompanyId " . $whereind . "
                        AND peinv.MandAId = pe.MandAId
                        AND inv.InvestorId = peinv.InvestorId
                        AND pe.Deleted=0  and Investor like '%$keyword%'
                        and Investor !=''  order by inv.Investor ";
                        
                        $totalallsql=$showallsql;
		}
                else if($companysearch!="")
		{
                    $whereind = " and pec.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pec.industry=" .$industry. " ";
                        }
                    }
                        $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                        FROM REmanda AS pe, REcompanies AS pec, REmanda_investors AS peinv, REinvestors AS inv
                        WHERE pe.PECompanyId = pec.PEcompanyId " . $whereind . "
                        AND peinv.MandAId = pe.MandAId
                        AND inv.InvestorId = peinv.InvestorId
                        AND pe.Deleted=0  and pec.companyname like '%$companysearch%' and inv.Investor !='' order by inv.Investor ";
                        
                        $totalallsql=$showallsql;
		}
                else if($sectorsearch!="")
		{
                    $whereind = " and pec.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pec.industry=" .$industry. " ";
                        }
                    }
                        $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                        FROM REmanda AS pe, REcompanies AS pec, REmanda_investors AS peinv, REinvestors AS inv
                        WHERE pe.PECompanyId = pec.PEcompanyId " . $whereind . "
                        AND peinv.MandAId = pe.MandAId
                        AND inv.InvestorId = peinv.InvestorId
                        AND pe.Deleted=0  and pec.sector_business like '%$sectorsearch%' and inv.Investor !='' order by inv.Investor ";
                        
                        $totalallsql=$showallsql;
		}
                elseif($advisorsearchstring_legal!="")
                {
                    $whereind = " and c.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and c.industry=" .$industry. " ";
                        }
                    }
                        
                        $showallsql="( SELECT Reinvi.InvestorId, ras.Investor , (SELECT GROUP_CONCAT( inv.Investor ) FROM REmanda_investors as peinv_inv,REinvestors as inv WHERE peinv_inv.MandAId = peinv.MandAId AND inv.InvestorId = peinv_inv.InvestorId) AS Investor 
                        FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s,REmanda_investors as Reinvi,REinvestors as ras
                        WHERE c.industry = i.industryid " . $whereind . "
                        AND ac.AcquirerId = peinv.AcquirerId 
                        AND peinv.Deleted =0 
                        AND peinv.StageId = s.RETypeId 
                        AND c.PECompanyId = peinv.PECompanyId 
                        AND adac.CIAId = cia.CIAID
                        AND Reinvi.MandAId  =peinv.MandAId 
                        AND ras.InvestorId = Reinvi.InvestorId
                        AND adac.PEId = peinv.MandAId  and AdvisorType='L' 
                        AND cia.cianame LIKE '%$advisorsearchstring_legal%'  and ras.Investor !=''
                        GROUP BY peinv.MandAId 
                        )
                        UNION (

                         SELECT Reinvi.InvestorId, ras.Investor , (SELECT GROUP_CONCAT( inv.Investor ) FROM REmanda_investors as peinv_inv,REinvestors as inv WHERE peinv_inv.MandAId = peinv.MandAId AND inv.InvestorId = peinv_inv.InvestorId) AS Investor  
                        FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s,REmanda_investors as Reinvi,REinvestors as ras
                        WHERE c.industry = i.industryid " . $whereind . "
                        AND ac.AcquirerId = peinv.AcquirerId
                        AND peinv.Deleted =0
                        AND peinv.StageId = s.RETypeId
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adcomp.CIAId = cia.CIAID
                        AND Reinvi.MandAId  =peinv.MandAId 
                        AND ras.InvestorId = Reinvi.InvestorId 
                        AND adcomp.PEId = peinv.MandAId  and AdvisorType='L'
                        AND cianame LIKE '%$advisorsearchstring_legal%'  and ras.Investor !=''
                        GROUP BY peinv.MandAId 
                        ) ";
                         $totalallsql=$showallsql;
                }
                elseif($advisorsearchstring_trans!="")
                {
                    $whereind = " and c.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and c.industry=" .$industry. " ";
                        }
                    }
                     $showallsql="( SELECT Reinvi.InvestorId, ras.Investor , (SELECT GROUP_CONCAT( inv.Investor ) FROM REmanda_investors as peinv_inv,REinvestors as inv WHERE peinv_inv.MandAId = peinv.MandAId AND inv.InvestorId = peinv_inv.InvestorId) AS Investor 
                        FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s,REmanda_investors as Reinvi,REinvestors as ras
                        WHERE c.industry = i.industryid " . $whereind . "
                        AND ac.AcquirerId = peinv.AcquirerId 
                        AND peinv.Deleted =0 
                        AND peinv.StageId = s.RETypeId 
                        AND c.PECompanyId = peinv.PECompanyId 
                        AND adac.CIAId = cia.CIAID
                        AND Reinvi.MandAId  =peinv.MandAId 
                        AND ras.InvestorId = Reinvi.InvestorId
                        AND adac.PEId = peinv.MandAId  and AdvisorType='T' 
                        AND cia.cianame LIKE '%$advisorsearchstring_trans%'  and ras.Investor !=''
                        GROUP BY peinv.MandAId 
                        )
                        UNION (

                         SELECT Reinvi.InvestorId, ras.Investor , (SELECT GROUP_CONCAT( inv.Investor ) FROM REmanda_investors as peinv_inv,REinvestors as inv WHERE peinv_inv.MandAId = peinv.MandAId AND inv.InvestorId = peinv_inv.InvestorId) AS Investor  
                        FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s,REmanda_investors as Reinvi,REinvestors as ras
                        WHERE c.industry = i.industryid " . $whereind . "
                        AND ac.AcquirerId = peinv.AcquirerId
                        AND peinv.Deleted =0
                        AND peinv.StageId = s.RETypeId
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adcomp.CIAId = cia.CIAID
                        AND Reinvi.MandAId  =peinv.MandAId 
                        AND ras.InvestorId = Reinvi.InvestorId 
                        AND adcomp.PEId = peinv.MandAId  and AdvisorType='T'
                        AND cianame LIKE '%$advisorsearchstring_trans%'  and ras.Investor !=''
                        GROUP BY peinv.MandAId 
                        ) ";
                         $totalallsql=$showallsql;
                }
                elseif($searchallfield!="")
		{
                    $whereind = " and pec.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pec.industry=" .$industry. " ";
                        }
                    }
                        $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                        FROM REmanda AS pe, REcompanies AS pec, REmanda_investors AS peinv, REinvestors AS inv
                        WHERE pe.PECompanyId = pec.PEcompanyId " . $whereind . "
                        AND peinv.MandAId = pe.MandAId
                        AND inv.InvestorId = peinv.InvestorId
                        AND pe.Deleted=0  and Investor like '%$searchallfield%' and inv.Investor !='' order by inv.Investor ";
                        
                         $totalallsql=$showallsql;
		}
                else{
                                $yourquery=1;
                                $dt1 = $year1."-".$month1."-01";
                                //echo "<BR>DATE1---" .$dt1;
                                $dt2 = $year2."-".$month2."-01";
                                
                                $getInvestorSqlreal = "SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM REmanda AS pe, REcompanies AS pec, REmanda_investors AS peinv, REinvestors AS inv,industry as i
                                where ";

                        	//echo "<br> individual where clauses have to be merged ";
                                $whereind = " pec.industry=15";
                                if ($industry > 0)
                                {
                                    if( $industry != 15 ) {
                                     $whereind = " pec.industry=" .$industry;
                                    }
                                } 
                                if ($dealtype!= "")
                                {
                                    $wheredealtype = " pe.DealTypeId =" .$dealtype;
                                }
                                
                                if (($startRangeValue!= "") && ($endRangeValue != ""))
                                if ($range!= "--" && $range!= "" )
                                {
                                    if($startRangeValue < $endRangeValue)
                                            $whererange = " pe.DealAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                    elseif($startRangeValue == $endRangeValue)
                                            $whererange = " pe.DealAmount >= ".$startRangeValue ."";
                                }
                                if(($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                                        $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                                if ($whereind != "")
                                {
                                        $getInvestorSqlreal=$getInvestorSqlreal . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                                if (($wherestagehide != ""))
                                {
                                        $getInvestorSqlreal=$getInvestorSqlreal . $wherestagehide . " and " ;
                                        $bool=true;
                                }
                                if (($wheredealtype != "") )
                                {
                                        $getInvestorSqlreal=$getInvestorSqlreal .$wheredealtype . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $getInvestorSqlreal=$getInvestorSqlreal .$whererange . " and ";
                                        $bool=true;
                                }
                                if(($wheredates != "") )
                                {
                                        $getInvestorSqlreal = $getInvestorSqlreal . $wheredates ." and ";
                                        $bool=true;
                                }
                                $totalallsql = $getInvestorSqlreal . " pe.PECompanyId = pec.PEcompanyId 
                                AND peinv.MandAId = pe.MandAId AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 ".$dirsearchall." and inv.Investor !='' order by inv.Investor";
                                
                                $getInvestorSqlreal = $getInvestorSqlreal . " pe.PECompanyId = pec.PEcompanyId
                                AND peinv.MandAId = pe.MandAId AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 " .$search." ".$dirsearchall." and inv.Investor !='' order by inv.Investor";
                                //	echo "<br><br>WHERE CLAUSE SQL---" .$getInvestorSqlreal;
                                 $showallsql= $getInvestorSqlreal; 
                        }
                        
                        
               }
               elseif($dealvalue==102){
                   
                if($keyword!="")
		{
                    $whereind = " and pec.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pec.industry=" .$industry. " ";
                        }
                    }
                     $showallsql="SELECT pe.PECompanyId  as PECompanyId, pec.*
                        FROM REmanda AS pe, REcompanies AS pec, REmanda_investors AS peinv, REinvestors AS inv
                        WHERE pe.PECompanyId = pec.PEcompanyId " . $whereind . "
                        AND peinv.MandAId = pe.MandAId
                        AND inv.InvestorId = peinv.InvestorId
                        AND pe.Deleted=0  and Investor like '%$keyword%' and inv.Investor !='' order by inv.Investor ";
                        $totalallsql=$showallsql; 
		}
                else if($companysearch!="")
		{
                    $whereind = " and pec.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pec.industry=" .$industry. " ";
                        }
                    }
                        $showallsql="SELECT DISTINCT pe.PECompanyId, pec.* FROM REcompanies AS pec, REmanda AS pe
                        WHERE pec.PECompanyId = pe.PEcompanyId " . $whereind . " and pe.Deleted=0 and pec.companyname like '%$companysearch%' ORDER BY pec.companyname";
                        $totalallsql=$showallsql; 
		}
                else if($sectorsearch!=""){
                    $whereind = " and pec.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pec.industry=" .$industry. " ";
                        }
                    }
                        $showallsql="SELECT DISTINCT pe.PECompanyId, pec.* FROM REcompanies AS pec, REmanda AS pe
                        WHERE pec.PECompanyId = pe.PEcompanyId " . $whereind . " and pe.Deleted=0 and pec.sector_business like '%$sectorsearch%' ORDER BY pec.companyname";
                        $totalallsql=$showallsql;
		}
                elseif($advisorsearchstring_legal!="")
                {
                    $whereind = " and c.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and c.industry=" .$industry. " ";
                        }
                    }
                        $showallsql="(SELECT peinv.PECompanyId as PECompanyId, c.* 
                        FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s
                        WHERE c.industry = i.industryid " . $whereind . "
                        AND ac.AcquirerId = peinv.AcquirerId 
                        AND peinv.Deleted =0 
                        AND peinv.StageId = s.RETypeId 
                        AND c.PECompanyId = peinv.PECompanyId 
                        AND adac.CIAId = cia.CIAID 
                        AND adac.PEId = peinv.MandAId  and AdvisorType='L' 
                        AND cia.cianame LIKE '%$advisorsearchstring_legal%' 
                        GROUP BY peinv.MandAId 
                        )
                        UNION (

                        SELECT peinv.PECompanyId as PECompanyId, c.*
                        FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s
                        WHERE c.industry = i.industryid " . $whereind . "
                        AND ac.AcquirerId = peinv.AcquirerId
                        AND peinv.Deleted =0
                        AND peinv.StageId = s.RETypeId
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adcomp.CIAId = cia.CIAID
                        AND adcomp.PEId = peinv.MandAId  and AdvisorType='L'
                        AND cianame LIKE '%$advisorsearchstring_legal%' 
                        GROUP BY peinv.MandAId 
                        ) ";
                       $totalallsql=$showallsql;
                }
                elseif($advisorsearchstring_trans!="")
                {
                    $whereind = " and c.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and c.industry=" .$industry. " ";
                        }
                    }
                    $showallsql="(SELECT peinv.PECompanyId as PECompanyId, c.*
                    FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s
                    WHERE c.industry = i.industryid " . $whereind . "
                    AND ac.AcquirerId = peinv.AcquirerId 
                    AND peinv.Deleted =0 
                    AND peinv.StageId = s.RETypeId 
                    AND c.PECompanyId = peinv.PECompanyId 
                    AND adac.CIAId = cia.CIAID 
                    AND adac.PEId = peinv.MandAId  and AdvisorType='T' 
                    AND cia.cianame LIKE '%$advisorsearchstring_trans%' 
                    GROUP BY peinv.MandAId 
                    )
                    UNION (

                    SELECT peinv.PECompanyId as PECompanyId, c.* 
                    FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s
                    WHERE c.industry = i.industryid " . $whereind . "
                    AND ac.AcquirerId = peinv.AcquirerId
                    AND peinv.Deleted =0
                    AND peinv.StageId = s.RETypeId
                    AND c.PECompanyId = peinv.PECompanyId
                    AND adcomp.CIAId = cia.CIAID
                    AND adcomp.PEId = peinv.MandAId  and AdvisorType='T'
                    AND cianame LIKE '%$advisorsearchstring_trans%' 
                    GROUP BY peinv.MandAId 
                    ) ";
                    $totalallsql=$showallsql;
               }
                elseif($searchallfield!="")
		{
                    $whereind = " and pec.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pec.industry=" .$industry. " ";
                        }
                    }
			 $showallsql="SELECT DISTINCT pe.PECompanyId, pec.* FROM REcompanies AS pec, REmanda AS pe
                        WHERE pec.PECompanyId = pe.PEcompanyId " . $whereind . " and pe.Deleted=0 and pec.companyname like '%$searchallfield%' ORDER BY pec.companyname";
                        $totalallsql=$showallsql; 
		}
                else{
                    $dt1 = $year1."-".$month1."-01";
                                //echo "<BR>DATE1---" .$dt1;
                                $dt2 = $year2."-".$month2."-01";
                   $getcompanysqlreal="SELECT DISTINCT pe.PECompanyId, pec.* FROM REcompanies AS pec, REmanda AS pe WHERE";
                    $whereind = " pec.industry=15";
                        if ($industry > 0)
                        {
                            if( $industry != 15 ) {
                             $whereind = " pec.industry=" .$industry;
                            }
                        }
                        if ($dealtype!= "")
                        {
                            $wheredealtype = " pe.DealTypeId =" .$dealtype;
                        }
                        
                        if (($startRangeValue!= "") && ($endRangeValue != "")){
                            if ($range!= "--" && $range!= "" )
                             {
                                if($startRangeValue < $endRangeValue)
                                        $whererange = " pe.DealAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                elseif($startRangeValue == $endRangeValue)
                                        $whererange = " pe.DealAmount >= ".$startRangeValue ."";
                             }
                        }
                        if($dt1!='' && $dt2!='')
                               $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                        if ($whereind != "")
                        {
                                $getcompanysqlreal=$getcompanysqlreal . $whereind ." and ";

                                $bool=true;
                        }
                        else
                        {
                                $bool=false;
                        }
                               
                        if (($wherestagehide != ""))
                        {
                                $getcompanysqlreal=$getcompanysqlreal . $wherestagehide . " and " ;
                                $bool=true;
                        }
                        if (($wheredealtype != "") )
                        {
                                $getcompanysqlreal=$getcompanysqlreal .$wheredealtype . " and ";
                                $bool=true;
                        }
                        if (($whererange != "") )
                        {
                                $getcompanysqlreal=$getcompanysqlreal .$whererange . " and ";
                                $bool=true;
                        }
                        if(($wheredates != "") )
                        {
                                $getcompanysqlreal = $getcompanysqlreal . $wheredates ." and ";
                                $bool=true;
                        }
                        $totalallsql=$getcompanysqlreal." pec.PECompanyId = pe.PEcompanyId and pe.Deleted=0 ".$dirsearchall."  ORDER BY pec.companyname";
                        $getcompanysqlreal = $getcompanysqlreal." pec.PECompanyId = pe.PEcompanyId and pe.Deleted=0 " .$search." ".$dirsearchall." ORDER BY pec.companyname";
                                            
                        $showallsql= $getcompanysqlreal;
                }
            }
            elseif($dealvalue==103 || $dealvalue==104){
                   
                if($dealvalue == 103)
                {
                    $adtype = "L";
                }
                else
                {
                    $adtype = "T";
                }
                
                if($keyword!="")
		{ 
                    $whereind = " and c.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and c.industry=" .$industry. " ";
                        }
                    }
                    $showallsql="( SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId , (SELECT GROUP_CONCAT( inv.Investor ) FROM REmanda_investors as peinv_inv,REinvestors as inv WHERE peinv_inv.MandAId = peinv.MandAId AND inv.InvestorId = peinv_inv.InvestorId) AS Investor 
                    FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s,REmanda_investors as Reinvi,REinvestors as ras
                    WHERE c.industry = i.industryid " . $whereind . "
                    AND ac.AcquirerId = peinv.AcquirerId 
                    AND peinv.Deleted =0 
                    AND peinv.StageId = s.RETypeId 
                    AND c.PECompanyId = peinv.PECompanyId 
                    AND adac.CIAId = cia.CIAID
                    AND Reinvi.MandAId  =peinv.MandAId 
                    AND ras.InvestorId = Reinvi.InvestorId
                    AND adac.PEId = peinv.MandAId  and AdvisorType='$adtype' 
                    AND Investor like '%$keyword%' and inv.Investor !=''
                    GROUP BY peinv.MandAId 
                    )
                    UNION (

                     SELECT cia.CIAId, cia.Cianame,adcomp.CIAId AS AcqCIAId  , (SELECT GROUP_CONCAT( inv.Investor ) FROM REmanda_investors as peinv_inv,REinvestors as inv WHERE peinv_inv.MandAId = peinv.MandAId AND inv.InvestorId = peinv_inv.InvestorId) AS Investor  
                    FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s,REmanda_investors as Reinvi,REinvestors as ras
                    WHERE c.industry = i.industryid " . $whereind . "
                    AND ac.AcquirerId = peinv.AcquirerId
                    AND peinv.Deleted =0
                    AND peinv.StageId = s.RETypeId
                    AND c.PECompanyId = peinv.PECompanyId
                    AND adcomp.CIAId = cia.CIAID
                    AND Reinvi.MandAId  =peinv.MandAId 
                    AND ras.InvestorId = Reinvi.InvestorId 
                    AND adcomp.PEId = peinv.MandAId  and AdvisorType='$adtype'
                    AND Investor like '%$keyword%' and inv.Investor !=''
                    GROUP BY peinv.MandAId 
                    ) ";
                    $totalallsql=$showallsql;
		}
                else if($companysearch!="")
		{
                    $whereind = " and c.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and c.industry=" .$industry. " ";
                        }
                    }
                        $showallsql="(SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId  
                        FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s
                        WHERE c.industry = i.industryid " . $whereind . "
                        AND ac.AcquirerId = peinv.AcquirerId 
                        AND peinv.Deleted =0 
                        AND peinv.StageId = s.RETypeId 
                        AND c.PECompanyId = peinv.PECompanyId 
                        AND adac.CIAId = cia.CIAID 
                        AND adac.PEId = peinv.MandAId  and AdvisorType='$adtype' 
                        AND c.companyname like '%$companysearch%' 
                        GROUP BY peinv.MandAId 
                        )
                        UNION (

                        SELECT cia.CIAId, cia.Cianame,adcomp.CIAId AS AcqCIAId 
                        FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s
                        WHERE c.industry = i.industryid " . $whereind . "
                        AND ac.AcquirerId = peinv.AcquirerId
                        AND peinv.Deleted =0
                        AND peinv.StageId = s.RETypeId
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adcomp.CIAId = cia.CIAID
                        AND adcomp.PEId = peinv.MandAId  and AdvisorType='$adtype'
                        AND c.companyname like '%$companysearch%'
                        GROUP BY peinv.MandAId 
                        ) ";
                       $totalallsql=$showallsql;
		}
                else if($sectorsearch!="")
		{
                    $whereind = " and c.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and c.industry=" .$industry. " ";
                        }
                    } 
                        $showallsql="(SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId  
                        FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s
                        WHERE c.industry = i.industryid " . $whereind . "
                        AND ac.AcquirerId = peinv.AcquirerId 
                        AND peinv.Deleted =0 
                        AND peinv.StageId = s.RETypeId 
                        AND c.PECompanyId = peinv.PECompanyId 
                        AND adac.CIAId = cia.CIAID 
                        AND adac.PEId = peinv.MandAId  and AdvisorType='$adtype' 
                        AND c.sector_business like '%$sectorsearch%'
                        GROUP BY peinv.MandAId 
                        )
                        UNION (

                        SELECT cia.CIAId, cia.Cianame,adcomp.CIAId AS AcqCIAId 
                        FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s
                        WHERE c.industry = i.industryid " . $whereind . "
                        AND ac.AcquirerId = peinv.AcquirerId
                        AND peinv.Deleted =0
                        AND peinv.StageId = s.RETypeId
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adcomp.CIAId = cia.CIAID
                        AND adcomp.PEId = peinv.MandAId  and AdvisorType='$adtype'
                        AND c.sector_business like '%$sectorsearch%'
                        GROUP BY peinv.MandAId 
                        ) ";
                       $totalallsql=$showallsql;
		}
                elseif($advisorsearchstring_legal!="")
                {
                        $whereind = " and c.industry=15 ";
                        if ($industry > 0) {
                            if( $industry != '15' ) {
                                $whereind = " and c.industry=" .$industry. " ";
                            }
                        }
                    
                        $showallsql="(SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId
                        FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s
                        WHERE c.industry = i.industryid " . $whereind . "
                        AND ac.AcquirerId = peinv.AcquirerId 
                        AND peinv.Deleted =0 
                        AND peinv.StageId = s.RETypeId 
                        AND c.PECompanyId = peinv.PECompanyId 
                        AND adac.CIAId = cia.CIAID 
                        AND adac.PEId = peinv.MandAId  and AdvisorType='$adtype' 
                        AND cia.cianame LIKE '%$advisorsearchstring_legal%' 
                        GROUP BY peinv.MandAId 
                        )
                        UNION (

                        SELECT cia.CIAId, cia.Cianame,adcomp.CIAId AS AcqCIAId
                        FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s
                        WHERE c.industry = i.industryid " . $whereind . "
                        AND ac.AcquirerId = peinv.AcquirerId
                        AND peinv.Deleted =0
                        AND peinv.StageId = s.RETypeId
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adcomp.CIAId = cia.CIAID
                        AND adcomp.PEId = peinv.MandAId  and AdvisorType='$adtype'
                        AND cianame LIKE '%$advisorsearchstring_legal%' 
                        GROUP BY peinv.MandAId 
                        ) ";
                        $totalallsql=$showallsql;
                    
                }
                elseif($advisorsearchstring_trans!="")
                {
                    $whereind = " and c.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and c.industry=" .$industry. " ";
                        }
                    }
                    
                        $showallsql="(SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId
                        FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s
                        WHERE c.industry = i.industryid " . $whereind . "
                        AND ac.AcquirerId = peinv.AcquirerId
                        AND peinv.Deleted =0
                        AND peinv.StageId = s.RETypeId
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID
                        AND adac.PEId = peinv.MandAId  and AdvisorType='$adtype'
                        AND cia.cianame LIKE '%$advisorsearchstring_trans%'
                        GROUP BY peinv.MandAId 
                        )
                        UNION (

                        SELECT cia.CIAId, cia.Cianame,adcomp.CIAId AS AcqCIAId
                        FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s
                        WHERE c.industry = i.industryid " . $whereind . "
                        AND ac.AcquirerId = peinv.AcquirerId
                        AND peinv.Deleted =0
                        AND peinv.StageId = s.RETypeId
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adcomp.CIAId = cia.CIAID
                        AND adcomp.PEId = peinv.MandAId  and AdvisorType='$adtype'
                        AND cianame LIKE '%$advisorsearchstring_trans%' 
                        GROUP BY peinv.MandAId 
                        ) ";
                    $totalallsql=$showallsql;
               }
                elseif($searchallfield!="")
		{
                    $whereind = " and c.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and c.industry=" .$industry. " ";
                        }
                    }
                        $showallsql="(SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId
                        FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s
                        WHERE c.industry = i.industryid " . $whereind . "
                        AND ac.AcquirerId = peinv.AcquirerId
                        AND peinv.Deleted =0
                        AND peinv.StageId = s.RETypeId
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID
                        AND adac.PEId = peinv.MandAId  and AdvisorType='$adtype'
                        AND cia.cianame LIKE '%$searchallfield%'
                        GROUP BY peinv.MandAId 
                        )
                        UNION (

                        SELECT cia.CIAId, cia.Cianame,adcomp.CIAId AS AcqCIAId
                        FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s
                        WHERE c.industry = i.industryid " . $whereind . "
                        AND ac.AcquirerId = peinv.AcquirerId
                        AND peinv.Deleted =0
                        AND peinv.StageId = s.RETypeId
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adcomp.CIAId = cia.CIAID
                        AND adcomp.PEId = peinv.MandAId  and AdvisorType='$adtype'
                        AND cianame LIKE '%$searchallfield%' 
                        GROUP BY peinv.MandAId 
                        ) ";
                        $totalallsql=$showallsql;

		//echo "<br> allsearchfield search- ".$InvestorSqlreal;
		}
                else{
                    $dt1 = $year1."-".$month1."-01";
                    $dt2 = $year2."-".$month2."-01";
                    $companysql= "(SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s where";
                    $companysql2= "SELECT cia.CIAId, cia.Cianame,adcomp.CIAId AS AcqCIAId FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s where";

                    //echo "<br> individual where clauses have to be merged ";
                    $whereind = " c.industry=15";
                    if ($industry > 0)
                        if( $industry != 15 ) {
                            $whereind = " c.industry=" .$industry ;    
                        }
                    if ($dealtype!= "")
                    {
                        $wheredealtype = " peinv.DealTypeId =" .$dealtype;
                    }
                    
                    if (($startRangeValue!= "") && ($endRangeValue != "")){
                        if ($range!= "--" && $range!= "" )
                         {
                             if($startRangeValue < $endRangeValue)
                                     $whererange = " peinv.DealAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                             elseif($startRangeValue == $endRangeValue)
                                     $whererange = " peinv.DealAmount >= ".$startRangeValue ."";
                         }
                    }
                    if($dt1!='' && $dt2!='')
                        $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                    
                        if ($whereind != "")
                        {
                                $companysql=$companysql . $whereind ." and ";
                                $companysql2=$companysql2 . $whereind ." and ";
                        }

                        if ($wheredealtype != "")
                        {
                                $companysql=$companysql . $wheredealtype ." and ";
                                $companysql2=$companysql2 . $wheredealtype ." and ";
                        }
                        if (($wherestagehide != ""))
                        {
                                 $companysql=$companysql .$wherestagehide . " and ";
                                $companysql2=$companysql2 .$wherestagehide . " and ";
                        }          
                        if (($whererange != "") )
                        {
                                $companysql=$companysql .$whererange . " and ";
                                $companysql2=$companysql2 .$whererange . " and ";
                        }

                        if(($wheredates != "") )
                        {
                                $companysql = $companysql.$wheredates ." and ";
                                $companysql2 = $companysql2.$wheredates ." and ";
                        }
                        
                        $companysqltot = $companysql ." c.industry = i.industryid AND ac.AcquirerId = peinv.AcquirerId
                        AND peinv.Deleted =0 AND peinv.StageId = s.RETypeId AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.MandAId  and AdvisorType='".$adtype ."' ".$dirsearchall."
                        GROUP BY peinv.MandAId";
                        
                        
                        $companysqltot2 = $companysql2 ." c.industry = i.industryid AND ac.AcquirerId = peinv.AcquirerId
                        AND peinv.Deleted =0 AND peinv.StageId = s.RETypeId AND c.PECompanyId = peinv.PECompanyId
                        AND adcomp.CIAId = cia.CIAID AND adcomp.PEId = peinv.MandAId  and AdvisorType='".$adtype ."' ".$dirsearchall."
                        GROUP BY peinv.MandAId ";
                        
                        $companysql = $companysql ." c.industry = i.industryid AND ac.AcquirerId = peinv.AcquirerId
                        AND peinv.Deleted =0 AND peinv.StageId = s.RETypeId AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.MandAId  and AdvisorType='".$adtype ."' " .$search."  ".$dirsearchall."
                        GROUP BY peinv.MandAId";
                        
                        $companysql2 = $companysql2 ." c.industry = i.industryid AND ac.AcquirerId = peinv.AcquirerId
                        AND peinv.Deleted =0 AND peinv.StageId = s.RETypeId AND c.PECompanyId = peinv.PECompanyId
                        AND adcomp.CIAId = cia.CIAID AND adcomp.PEId = peinv.MandAId  and AdvisorType='".$adtype ."' " .$search."  ".$dirsearchall."
                        GROUP BY peinv.MandAId ";
                        
                        $showallsql=$companysql.") UNION (".$companysql2.") ";
                        $totalallsql=$companysqltot.") UNION (".$companysqltot2.") ";

                        $orderby="order by Cianame"; 
                        $showallsql=$showallsql.$orderby;
                }
            }
        } elseif($vcflagValue==3){
            
            if($dealvalue==102){
                   
                if($companysearch!="")
		{
                    $whereind = " and pec.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pec.industry=" .$industry. " ";
                        }
                    }
                        $showallsql="SELECT DISTINCT pe.PECompanyId, pec.*
                        FROM REcompanies AS pec, REmama AS pe WHERE pec.PECompanyId = pe.PEcompanyId " . $whereind . "
                        and pe.Deleted=0 and pec.companyname like '%$companysearch%' ORDER BY pec.companyname";
                        $totalallsql=$showallsql; 
		}
                else if($sectorsearch!=""){
                    $whereind = " and pec.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pec.industry=" .$industry. " ";
                        }
                    }
                        $showallsql="SELECT DISTINCT pe.PECompanyId, pec.*
                        FROM REcompanies AS pec, REmama AS pe WHERE pec.PECompanyId = pe.PEcompanyId " . $whereind . "
                        and pe.Deleted=0 and pec.sector_business like '%$sectorsearch%' ORDER BY pec.companyname";
                        $totalallsql=$showallsql;
		}
                elseif($advisorsearchstring_legal!="")
                {
                    $whereind = " and c.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and c.industry=" .$industry. " ";
                        }
                    } 
                        $showallsql="(
                        SELECT DISTINCT peinv.PECompanyId,c.*
                        FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisoracquirer AS adac
                        WHERE Deleted =0 " . $whereind . "
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID
                        AND adac.MAMAId = peinv.MAMAId  and AdvisorType='L'
                         AND cia.cianame LIKE '%$advisorsearchstring_legal%'
                        )
                        UNION (
                        SELECT DISTINCT peinv.PECompanyId,c.*
                        FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisorcompanies AS adcomp
                        WHERE Deleted =0 " . $whereind . "
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adcomp.CIAId = cia.CIAID
                        AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='L'
                         AND cia.cianame LIKE '%$advisorsearchstring_legal%'
                        )";
                        $totalallsql=$showallsql;
                }
                elseif($advisorsearchstring_trans!="")
                {
                    $whereind = " and c.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and c.industry=" .$industry. " ";
                        }
                    }
                    $showallsql="(
                        SELECT DISTINCT peinv.PECompanyId,c.*
                        FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisoracquirer AS adac
                        WHERE Deleted =0 " . $whereind . "
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID
                        AND adac.MAMAId = peinv.MAMAId  and AdvisorType='T'
                         AND cia.cianame LIKE '%$advisorsearchstring_trans%'
                        )
                        UNION (
                        SELECT DISTINCT peinv.PECompanyId,c.*
                        FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisorcompanies AS adcomp
                        WHERE Deleted =0 " . $whereind . "
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adcomp.CIAId = cia.CIAID
                        AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='T'
                         AND cia.cianame LIKE '%$advisorsearchstring_trans%'
                        )";
                    $totalallsql=$showallsql;
               }
                elseif($searchallfield!="")
		{
                    $whereind = " and pec.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and pec.industry=" .$industry. " ";
                        }
                    }
			 $showallsql="SELECT DISTINCT pe.PECompanyId, pec.*
                        FROM REcompanies AS pec, REmama AS pe WHERE pec.PECompanyId = pe.PEcompanyId " . $whereind . "
                        and pe.Deleted=0 and pec.companyname like '%$searchallfield%' ORDER BY pec.companyname";
                        $totalallsql=$showallsql; 
		}
                else{
                        $dt1 = $year1."-".$month1."-01";
                                //echo "<BR>DATE1---" .$dt1;
                        $dt2 = $year2."-".$month2."-01";
                        $getcompanysqlreal="SELECT DISTINCT pe.PECompanyId, pec.* FROM REcompanies AS pec, REmama AS pe WHERE";
                        $whereind = " pec.industry=15";
                        if ($industry > 0)
                        {
                            if( $industry != 15 ) {
                                $whereind = " pec.industry=" .$industry;
                            }
                        }
                        if ($dealtype!= "")
                        {
                            $wheredealtype = " pe.MADealTypeId =" .$dealtype;
                        }
                        
                        if (($startRangeValue!= "") && ($endRangeValue != "")){
                            if ($range!= "--" && $range!= "" )
                             {
                                if($startRangeValue < $endRangeValue)
                                        $whererange = " pe.Amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                elseif($startRangeValue == $endRangeValue)
                                        $whererange = " pe.Amount >= ".$startRangeValue ."";
                             }
                        }
                        if($dt1!='' && $dt2!='')
                               $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                        if ($whereind != "")
                        {
                                $getcompanysqlreal=$getcompanysqlreal . $whereind ." and ";

                                $bool=true;
                        }
                        else
                        {
                                $bool=false;
                        }
                        if (($wheredealtype != "") )
                        {
                                $getcompanysqlreal=$getcompanysqlreal .$wheredealtype . " and ";
                                $bool=true;
                        }
                        if (($whererange != "") )
                        {
                                $getcompanysqlreal=$getcompanysqlreal .$whererange . " and ";
                                $bool=true;
                        }
                        if(($wheredates != "") )
                        {
                                $getcompanysqlreal = $getcompanysqlreal . $wheredates ." and ";
                                $bool=true;
                        }
                        $totalallsql=$getcompanysqlreal." pec.PECompanyId = pe.PEcompanyId and pe.Deleted=0 ".$dirsearchall."  ORDER BY pec.companyname";
                        $getcompanysqlreal = $getcompanysqlreal." pec.PECompanyId = pe.PEcompanyId and pe.Deleted=0 " .$search." ".$dirsearchall." ORDER BY pec.companyname";
                                            
                        $showallsql= $getcompanysqlreal;
                }
            }
            elseif($dealvalue==103 || $dealvalue==104){
                   
                if($dealvalue == 103)
                {
                    $adtype = "L";
                }
                else
                {
                    $adtype = "T";
                }
                
               if($companysearch!="")
		{
                    $whereind = " and c.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and c.industry=" .$industry. " ";
                        }
                    }
                        $showallsql="(
                        SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                        FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisoracquirer AS adac
                        WHERE Deleted =0 " . $whereind . "
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID
                        AND adac.MAMAId = peinv.MAMAId  and AdvisorType='$adtype'
                        AND c.companyname like '%$companysearch%'
                        )
                        UNION (
                        SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS AcqCIAId
                        FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisorcompanies AS adcomp
                        WHERE Deleted =0 " . $whereind . "
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adcomp.CIAId = cia.CIAID
                        AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='$adtype'
                        AND c.companyname like '%$companysearch%'
                        )";
                        $totalallsql=$showallsql;
		}
                else if($sectorsearch!="")
		{
                    $whereind = " and c.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and c.industry=" .$industry. " ";
                        }
                    } 
                       $showallsql="(
                        SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                        FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisoracquirer AS adac
                        WHERE Deleted =0 " . $whereind . "
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID
                        AND adac.MAMAId = peinv.MAMAId  and AdvisorType='$adtype'
                        AND c.sector_business like '%$sectorsearch%'
                        )
                        UNION (
                        SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS AcqCIAId
                        FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisorcompanies AS adcomp
                        WHERE Deleted =0 " . $whereind . "
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adcomp.CIAId = cia.CIAID
                        AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='$adtype'
                        AND c.sector_business like '%$sectorsearch%'
                        )";
                        $totalallsql=$showallsql;
		}
                elseif($advisorsearchstring_legal!="")
                {
                    $whereind = " and c.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and c.industry=" .$industry. " ";
                        }
                    }
                        $showallsql="(
                        SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                        FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisoracquirer AS adac
                        WHERE Deleted =0 " . $whereind . "
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID
                        AND adac.MAMAId = peinv.MAMAId  and AdvisorType='".$adtype ."'
                        AND cia.cianame LIKE '%$advisorsearchstring_legal%'
                        )
                        UNION (
                        SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                        FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisorcompanies AS adcomp
                        WHERE Deleted =0 " . $whereind . "
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adcomp.CIAId = cia.CIAID
                        AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='".$adtype ."'
                        AND cia.cianame LIKE '%$advisorsearchstring_legal%'
                        )
                        ORDER BY Cianame";
                        
                        $totalallsql=$showallsql;
                        
                    
                }
                elseif($advisorsearchstring_trans!="")
                {
                    $whereind = " and c.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and c.industry=" .$industry. " ";
                        }
                    }
                    $showallsql="(
                        SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                        FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisoracquirer AS adac
                        WHERE Deleted =0 " . $whereind . "
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID
                        AND adac.MAMAId = peinv.MAMAId  and AdvisorType='".$adtype ."'
                        AND cia.cianame LIKE '%$advisorsearchstring_trans%'
                        )
                        UNION (
                        SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                        FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisorcompanies AS adcomp
                        WHERE Deleted =0 " . $whereind . "
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adcomp.CIAId = cia.CIAID
                        AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='".$adtype ."'
                        AND cia.cianame LIKE '%$advisorsearchstring_trans%'
                        )
                        ORDER BY Cianame";
                        
                        $totalallsql=$showallsql;
               }
                elseif($searchallfield!="")
		{
                    $whereind = " and c.industry=15 ";
                    if ($industry > 0) {
                        if( $industry != '15' ) {
                            $whereind = " and c.industry=" .$industry. " ";
                        }
                    }
                   $showallsql="(
                        SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                        FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisoracquirer AS adac
                        WHERE Deleted =0 " . $whereind . "
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID
                        AND adac.MAMAId = peinv.MAMAId  and AdvisorType='".$adtype ."'
                        AND cia.cianame LIKE '%$searchallfield%'
                        )
                        UNION (
                        SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                        FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisorcompanies AS adcomp
                        WHERE Deleted =0 " . $whereind . "
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adcomp.CIAId = cia.CIAID
                        AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='".$adtype ."'
                        AND cia.cianame LIKE '%$searchallfield%'
                        )
                        ORDER BY Cianame";
                        
                        $totalallsql=$showallsql;

		//echo "<br> allsearchfield search- ".$InvestorSqlreal;
		}
                else{
                    $dt1 = $year1."-".$month1."-01";
                    $dt2 = $year2."-".$month2."-01";
                    $companysql= "(SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId FROM REmama AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REmama_advisoracquirer AS adac WHERE";
                    $companysql2= "SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId FROM REmama AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REmama_advisorcompanies AS adcomp WHERE ";

                    //echo "<br> individual where clauses have to be merged ";
                    $whereind = " c.industry=15";
                    if ($industry > 0)
                        if( $industry != 15 ) {
                            $whereind = " c.industry=" .$industry ;    
                        }
                    if ($dealtype!= "")
                    {
                        $wheredealtype = " peinv.MADealTypeId =" .$dealtype;
                    }
                    
                    if (($startRangeValue!= "") && ($endRangeValue != "")){
                        if ($range!= "--" && $range!= "" )
                         {
                             if($startRangeValue < $endRangeValue)
                                     $whererange = " peinv.Amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                             elseif($startRangeValue == $endRangeValue)
                                     $whererange = " peinv.Amount >= ".$startRangeValue ."";
                         }
                    }
                    if($dt1!='' && $dt2!='')
                        $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                    
                        if ($whereind != "")
                        {
                                $companysql=$companysql . $whereind ." and ";
                                $companysql2=$companysql2 . $whereind ." and ";
                        }

                        if ($wheredealtype != "")
                        {
                                $companysql=$companysql . $wheredealtype ." and ";
                                $companysql2=$companysql2 . $wheredealtype ." and ";
                        }
                        if (($wherestagehide != ""))
                        {
                                 $companysql=$companysql .$wherestagehide . " and ";
                                $companysql2=$companysql2 .$wherestagehide . " and ";
                        }          
                        if (($whererange != "") )
                        {
                                $companysql=$companysql .$whererange . " and ";
                                $companysql2=$companysql2 .$whererange . " and ";
                        }

                        if(($wheredates != "") )
                        {
                                $companysql = $companysql.$wheredates ." and ";
                                $companysql2 = $companysql2.$wheredates ." and ";
                        }
                        
                        $companysqltot = $companysql ." c.industry = i.industryid and Deleted =0 AND c.PECompanyId = peinv.PECompanyId AND adac.CIAId = cia.CIAID
                        AND adac.MAMAId = peinv.MAMAId  and AdvisorType='".$adtype ."' ".$dirsearchall." ";
                        
                        
                         $companysqltot2 = $companysql2 ." c.industry = i.industryid and Deleted =0 AND c.PECompanyId = peinv.PECompanyId AND adcomp.CIAId = cia.CIAID
                        AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='".$adtype ."' ".$dirsearchall." ";
                      
                         $companysql = $companysql ." c.industry = i.industryid and Deleted =0 AND c.PECompanyId = peinv.PECompanyId AND adac.CIAId = cia.CIAID
                        AND adac.MAMAId = peinv.MAMAId  and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." ";
                        
                        
                         $companysql2 = $companysql2 ." c.industry = i.industryid and Deleted =0 AND c.PECompanyId = peinv.PECompanyId AND adcomp.CIAId = cia.CIAID
                        AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='".$adtype ."' " .$search."  ".$dirsearchall." ";
                        
                        $showallsql=$companysql.") UNION (".$companysql2.") ";
                        $totalallsql=$companysqltot.") UNION (".$companysqltot2.") ";

                        $orderby="order by Cianame"; 
                        $showallsql=$showallsql.$orderby;
                }
            }
        }
?>

<?php
	$topNav = 'Directory';
        $defpage=$defvalue;
        $stagedef=1;
	include_once('redirectory_header.php');
?>
<style>
.result-cnt {
    padding: 10px 20px 20px 20px;
}
.result-title{
    padding: 10px 0px 10px 0px;
} 
.overview-cnt {
    
    margin-bottom: 10px;
}
.search-area,.list-view-table {
    padding: 0 0 0px;
}
</style>
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>
<td class="left-td-bg" >
    <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
    <div id="panel" style="display:block; overflow:visible; clear:both;">
<?php include_once('redirrefine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>
    </div>
</div>

</td>
 <?php
		//echo "<br><br>WHERE CLAUSE SQL---" .$getInvestorSqlreal;
        $exportToExcel=0;
        $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,RElogin_members as dm
        where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
//	echo "<br>---" .$TrialSql;
        if($trialrs=mysql_query($TrialSql))
        {
                while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                {
                        $exportToExcel=$trialrow["TrialLogin"];
                }
        }

        if($yourquery==1)
                 $queryDisplayTitle="Query:";
        elseif($yourquery==0)
                 $queryDisplayTitle="";
        /* Select queries return a resultset */
//        echo $showallsql;
        if ($rsinvestor = mysql_query($totalallsql))
        {
           $investor_cnt = mysql_num_rows($rsinvestor);
        }
        if($investor_cnt > 0)
        {
                    $notable=false;
        }
        else
        {
             $searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
             $notable=true;
             writeSql_for_no_records($companysql,$emailid);
        }
        $_SESSION['numberofcom']= $investor_cnt;
        $rsinvestor = mysql_query($showallsql);
?>


<td class="profile-view-left" style="width:100%;">
<div class="result-cnt">
<?php if ($accesserror==1 && $accessdirectory==1){?>
            <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htmp" target="_blank">Click here</a></b></div>
        <?php
        exit;
        }
        ?>
<div class="result-title result-title-nofix">
<div style="display: inline-flex;float: left;width: 100%;">

                        	<?php if(!$_POST){//id=>show-total-deal
                                    if($vcflagValue==0){
                                    ?>

                                        <h2>
                                        <span class="result-no" id=""> <?php echo $investor_cnt; ?>  Results found</span>
                                        <span class="result-for">for PE-RE Directory</span>
                                        <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                        </h2>
                                        <div class="title-links result-title-nofix" id="exportbtn"></div>
                                    <?php
                                    }
                                    elseif($vcflagValue==1){?>
                                        
                                        <h2>
                                        <span class="result-no" id=""> <?php echo $investor_cnt; ?>  Results found</span>
                                        <span class="result-for">for PE-IPO Directory</span>
                                        <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                        </h2>
                                        <div class="title-links result-title-nofix" id="exportbtn"></div>
                                    <?php }
                                    elseif($vcflagValue==2){?>
                                        
                                        <h2>
                                        <span class="result-no" id=""> <?php echo $investor_cnt; ?>  Results found</span>
                                        <span class="result-for">for PE-M&A Directory</span>
                                        <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                        </h2>
                                        <div class="title-links result-title-nofix" id="exportbtn"></div>
                                    <?php }
                                    elseif($vcflagValue==3){?>
                                        
                                        <h2>
                                        <span class="result-no" id=""> <?php echo $investor_cnt; ?>  Results found</span>
                                        <span class="result-for">for Other M&A Directory</span>
                                        <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                        </h2>
                                        <div class="title-links result-title-nofix" id="exportbtn"></div>
                                    <?php }
                                    ?>
                                    </div>
                                        <ul class="result-select closetagspace closetagspacedir">
                                            <?php
                                           if($industry >0 && $industry!=null){?>
                                            <li title="Industry">
                                                <?php echo $industryvalue; ?><a   onclick="resetinput('industry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                            </li>
                                            <?php }
                                            if($stagevaluetext!="" && $stagevaluetext!=null) { ?>
                                            <li>
                                                <?php echo $stagevaluetext ?><a  onclick="resetinput('stage');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                            </li>
                                            <?php }
                                            if($investorType !="--" && $investorType!=null){ ?>
                                            <li>
                                                <?php echo $invtypevalue; ?><a  onclick="resetinput('invType');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                            </li>
                                            <?php }
                                            if($dealtypevalue !="--" && $dealtypevalue!=null){ ?>
                                            <li>
                                                <?php echo $dealtypevalue; ?><a  onclick="resetinput('dealType');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                            </li>
                                            <?php }
                                            if (($range!= "--") && ($range != "")){ ?>
                                            <li>
                                                <?php echo "(USM)".$startRangeValue ."-" .$endRangeValue ?><a  onclick="resetinput('range');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                            </li>
                                            <?php }
                                            if($datevalueDisplay1!=""){ ?>
                                            <li>
                                                <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                            </li>
                                            <?php }
                                            if($keyword!="") { ?>
                                            <li>
                                                <?php echo $keyword;?><a  onclick="resetinput('keywordsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                            </li>
                                            <?php }
                                            if($companysearch!="") { ?>
                                            <li>
                                                <?php echo $companysearch;?><a  onclick="resetinput('companysearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                            </li>
                                            <?php }
                                            if($sectorsearch!="") { ?>
                                            <li>
                                                <?php echo $sectorsearch;?><a  onclick="resetinput('sectorsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                            </li>
                                            <?php }
                                            if($advisorsearchstring_legal!="") { ?>
                                            <li>
                                                <?php echo $advisorsearchstring_legal;?><a  onclick="resetinput('advisorsearch_legal');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                            </li>
                                            <?php }
                                            if($advisorsearchstring_trans!="") { ?>
                                            <li>
                                                <?php echo $advisorsearchstring_trans;?><a  onclick="resetinput('advisorsearch_trans');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                            </li>
                                            <?php }
                                             if($dirsearch!="") { ?>
                                            <li>
                                                <?php echo $dirsearch;?><a  onclick="resetinput('autocomplete');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                            </li>
                                            <?php }
                                            $_POST['resetfield']="";
                                    foreach($_POST as $value => $link)
                                    {
                                        if($link == "" || $link == "--" || $link == " ")
                                        {
                                            unset($_POST[$value]);
                                        }
                                    }
                                   // print_r($_POST);
                                    $cl_count = count($_POST);
                                    if($cl_count > 5)
                                    {
                                    ?>
                                    <li class="result-select-close"><a  onclick="resetinput('allfilterexit');"><img width="7" height="7" border="0" alt="" src="<?php echo $refUrl; ?>images/icon-close-ul.png"> </a></li>
                                    <?php
                                    }
                                    ?>
                                 </ul>
                                    <?php
                                    }
                                   else
                                   { 
                                       if($vcflagValue==0){
                                    ?>

                                        <h2>
                                        <span class="result-no" id=""> <?php echo $investor_cnt; ?>  Results found</span>
                                        <span class="result-for">for PE-RE Directory</span>
                                        <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                        </h2>
                                        <div class="title-links result-title-nofix" id="exportbtn"></div>
                                    <?php
                                    }
                                    elseif($vcflagValue==1){?>
                                        
                                        <h2>
                                        <span class="result-no" id=""> <?php echo $investor_cnt; ?>  Results found</span>
                                        <span class="result-for">for PE-IPO Directory</span>
                                        <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                        </h2>
                                        <div class="title-links result-title-nofix" id="exportbtn"></div>
                                    <?php }
                                    elseif($vcflagValue==2){?>
                                        
                                        <h2>
                                        <span class="result-no" id=""> <?php echo $investor_cnt; ?>  Results found</span>
                                        <span class="result-for">for PE-M&A Directory</span>
                                        <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                        </h2>
                                        <div class="title-links result-title-nofix" id="exportbtn"></div>
                                    <?php }
                                    elseif($vcflagValue==3){?>
                                        
                                        <h2>
                                        <span class="result-no" id=""> <?php echo $investor_cnt; ?>  Results found</span>
                                        <span class="result-for">for Other M&A Directory</span>
                                        <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                        </h2>
                                        <div class="title-links result-title-nofix" id="exportbtn"></div>
                                    <?php }
                                    ?>
                                    </div>
                                        <div class="title-links result-title-nofix" id="exportbtn"></div>
                                        <ul class="result-select closetagspace closetagspacedir">
                                        <?php
                                       if($industry >0 && $industry!=null){?>
                                        <li title="Industry">
                                            <?php echo $industryvalue; ?><a   onclick="resetinput('industry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                        <?php }
                                        if($stagevaluetext!="" && $stagevaluetext!=null) { ?>
                                        <li>
                                            <?php echo $stagevaluetext ?><a  onclick="resetinput('stage');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                        <?php }
                                        if($investorType !="--" && $investorType!=null){ ?>
                                        <li>
                                            <?php echo $invtypevalue; ?><a  onclick="resetinput('invType');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                        <?php }
                                        if($dealtypevalue !="--" && $dealtypevalue!=null){ ?>
                                        <li>
                                            <?php echo $dealtypevalue; ?><a  onclick="resetinput('dealType');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                        <?php }
                                        if (($range!= "--") && ($range != "")){ ?>
                                        <li>
                                            <?php echo "(USM)".$startRangeValue ."-" .$endRangeValue ?><a  onclick="resetinput('range');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                        <?php }
                                        if($datevalueDisplay1!=""){ ?>
                                        <li>
                                            <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                        <?php }
                                        if($keyword!="") { ?>
                                        <li>
                                            <?php echo $keyword;?><a  onclick="resetinput('keywordsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                        <?php }
                                        if($companysearch!="") { ?>
                                        <li>
                                            <?php echo $companysearch;?><a  onclick="resetinput('companysearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                        <?php }
                                        if($sectorsearch!="") { ?>
                                        <li>
                                            <?php echo $sectorsearch;?><a  onclick="resetinput('sectorsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                        <?php }
                                        if($advisorsearchstring_legal!="") { ?>
                                        <li>
                                            <?php echo $advisorsearchstring_legal;?><a  onclick="resetinput('advisorsearch_legal');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                        <?php }
                                        if($advisorsearchstring_trans!="") { ?>
                                        <li>
                                            <?php echo $advisorsearchstring_trans;?><a  onclick="resetinput('advisorsearch_trans');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                        <?php }
                                         if($dirsearch!="") { ?>
                                        <li>
                                            <?php echo $dirsearch;?><a  onclick="resetinput('autocomplete');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                        <?php }
                                        $_POST['resetfield']="";
                                foreach($_POST as $value => $link)
                                {
                                    if($link == "" || $link == "--" || $link == " ")
                                    {
                                        unset($_POST[$value]);
                                    }
                                }
                               // print_r($_POST);
                                $cl_count = count($_POST);
                                if($cl_count > 5)
                                {
                                ?>
                                <li class="result-select-close"><a  onclick="resetinput('allfilterexit');"><img width="7" height="7" border="0" alt="" src="<?php echo $refUrl; ?>images/icon-close-ul.png"> </a></li>
                                <?php
                                }
                                ?>
                             </ul>
                             <?php } ?>

                        </div>


                        <div class="overview-cnt"></div>
                       <div class="list-tab"><ul>
                        <li class="active"><a class="postlink"  href="redirview.php"  id="icon-grid-view"><i></i> List  View</a></li>
                         <?php
                            $count=0;
                             While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                            {
                               
                                if($dealvalue==101){
                                    if($count == 0)
                                    {
                                             $comid = $myrow["InvestorId"];
                                            $count++;
                                    }
                                }
                                    elseif($dealvalue==102){ 
                                        if($count == 0)
                                        {
                                                 $comid = $myrow["PECompanyId"];
                                                $count++;
                                        }
                                    }
                                    elseif($dealvalue==103 || $dealvalue==104){ 
                                        if($count == 0)
                                        {
                                                 $comid = $myrow["CIAId"];
                                                $count++;
                                        }
                                    }
                                    
                                
                            }
                        
                        if($count >0){ 
                            if($dealvalue==101){
                            ?>
                        <li><a id="icon-detailed-view" class="postlink" href="redirdetails.php?value=<?php echo $comid;?>/<?php echo $vcflagValue; ?>/<?php echo $dealvalue; ?>" ><i></i> Detail  View</a></li>
                        <?php  } elseif($dealvalue==102){ 
                            ?>
                        <li><a id="icon-detailed-view" class="postlink" href="redircomdetails.php?value=<?php echo $comid;?>/<?php echo $vcflagValue; ?>/<?php echo $dealvalue; ?>" ><i></i> Detail  View</a></li>
                        <?php
                          }elseif($dealvalue==103 || $dealvalue==104 ){ 
                            ?>
                        <li><a id="icon-detailed-view" class="postlink" href="rediradvisor.php?value=<?php echo $comid;?>/<?php echo $vcflagValue; ?>/<?php echo $dealvalue; ?>" ><i></i> Detail  View</a></li>
                        <?php
                          }
                    }   ?>
                        </ul></div>
				<?php  $rowlimit=25;
                                $offset=0;
                                $i=1;
                                $j=1;
                                $newrowflag=1;
                                $newcolumnflag=1;
                                $columncount=1;
                                 $columnlimit=4;
                ?>

<div class="directory-cnt">
    <div class="search-area">
        <script>
            $(function() {
            var autodata = [
            <?php
                /* populating the investortype from the investortype table */
                    $searchStrings="Undisclosed";
                    $searchStrings=strtolower($searchStrings);

                    $searchStrings1="Unknown";
                    $searchStrings1=strtolower($searchStrings1);

                    $searchStrings2="Others";
                    $searchStrings2=strtolower($searchStrings2);
                                
                        if($dealvalue==101){
                            if($vcflagValue==0){
                                
                                $getInvestorSqls="SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM REinvestments AS pe, REcompanies AS pec, REinvestments_investors AS peinv,
                                REinvestors AS inv, realestatetypes AS s
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND s.RETypeId = pe.StageId
                                AND peinv.PEId = pe.PEId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 and inv.Investor !='' order by inv.Investor ";
                            }
                            elseif($vcflagValue==1){
                                
                                $getInvestorSqls="SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM REipos AS pe, REcompanies AS pec, REipo_investors AS peinv, REinvestors AS inv
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND peinv.IPOId = pe.IPOId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 and inv.Investor !=''  order by inv.Investor ";
                                
                            }
                            elseif($vcflagValue==2){
                               
                                $getInvestorSqls="SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM REmanda AS pe, REcompanies AS pec, REmanda_investors AS peinv, REinvestors AS inv
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry =15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 and inv.Investor !='' order by inv.Investor ";
                                
                            }
                            if ($rsinvestors = mysql_query($getInvestorSqls)){
                               $investors_cnts = mysql_num_rows($rsinvestors);
                            }

                            if($investors_cnts >0){
                                 mysql_data_seek($rsinvestor ,0);
                                  $commacount=0;
                                 While($myrows=mysql_fetch_array($rsinvestors, MYSQL_BOTH)){

                                        $Investornames=trim($myrows["Investor"]);
                                                        $Investornames=strtolower($Investornames);

                                                        $invResults=substr_count($Investornames,$searchStrings);
                                                        $invResults1=substr_count($Investornames,$searchStrings1);
                                                        $invResults2=substr_count($Investornames,$searchStrings2);

                                                        if(($invResults==0) && ($invResults1==0) && ($invResults2==0) && $myrows["Investor"]!=""){
                                                                $investors = $myrows["Investor"];
                                                                $investorsId = $myrows["InvestorId"];
                                                                 if($commacount>0)
                                                                echo ",";
                                                                //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                                                $isselcted = (trim($_POST['keywordsearchmain'])==trim($investors)) ? 'SELECTED' : '';
                                                                 echo "{value : '".$investors."',id : ".$investorsId."}" ;
                                                                //echo "'".$investors."'";
                                                                 $commacount++;
                                                        }
                                }
                            }
                        }
                        elseif($dealvalue==102){
                            
                            if($vcflagValue==0){
                                
                                $getcompaniesSql="SELECT pe.PECompanyId  as PECompanyId, pec.* FROM REinvestments AS pe,REcompanies AS pec, reindustry AS i
                                WHERE pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 and pec.companyname like '%$companysearch%' 
                                group by pe.PECompanyId ORDER BY pec.companyname";
                            }
                            elseif($vcflagValue==1){
                                
                                $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec.companyname FROM REcompanies AS pec, REipos AS pe
                                WHERE pec.PECompanyId = pe.PEcompanyId and pe.Deleted=0 ORDER BY pec.companyname";
                            }
                            elseif($vcflagValue==2){
                                
                                $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec.companyname FROM REcompanies AS pec, REmanda AS pe
                                WHERE pec.PECompanyId = pe.PEcompanyId and pe.Deleted=0 ORDER BY pec.companyname";
                            }
                            elseif($vcflagValue==3){
                                
                                $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec.companyname FROM REcompanies AS pec, REmama AS pe
                                WHERE pec.PECompanyId = pe.PEcompanyId  and pe.Deleted=0 ORDER BY pec.companyname";
                            }
                            
                            if ($rscompany = mysql_query($getcompaniesSql)){
                                $companies_cnts = mysql_num_rows($rscompany);
                        }
			
                        if( $companies_cnts >0){
                             mysql_data_seek($rscompany ,0);
                               $commacount=0;
                                While($myrow=mysql_fetch_array($rscompany, MYSQL_BOTH))
                                {
                                        $companyname=trim($myrow["companyname"]);
                                        $companyname=strtolower($companyname);

                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            $companies = $myrow["companyname"];
                                            $companyId= $myrow["PECompanyId"];
                                            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                              if($commacount>0)
                                                echo ",";
                                            $isselcted = (trim($_POST['keywordsearchmain'])==trim($companies)) ? 'SELECTED' : '';
                                            echo '{value : "'.$companies.'",id : '.$companyId.'}' ;
                                            //echo "'".$companies."'";
                                            $commacount++;
                                        }
                                }                          
                        }
                    }
                    elseif($dealvalue==103){
                        if($vcflagValue==0){
                            $advisorsql="(
                            SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId 
                            FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                            WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='L'  GROUP BY peinv.PEId
                            )
                            UNION (
                            SELECT  cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                            FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                            WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='L' GROUP BY peinv.PEId
                            )";
                        }
                        elseif($vcflagValue==2){
                            $advisorsql="(SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                            FROM REmanda AS peinv, REcompanies AS c, REadvisor_cias AS cia,
                            REinvestments_advisoracquirer AS adac
                            WHERE peinv.Deleted=0
                             AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID   and AdvisorType='L'
                            AND adac.PEId = peinv.MandAId)
                            UNION (
                            SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                            FROM REmanda AS peinv, REcompanies AS c,  REadvisor_cias AS cia,
                            REinvestments_advisorcompanies AS adac
                            WHERE peinv.Deleted=0
                             AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID and AdvisorType='L'
                            AND adac.PEId = peinv.MandAId ) order by Cianame";
                        }
                        elseif($vcflagValue==3){
                            $advisorsql="(
                            SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                            FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisoracquirer AS adac
                            WHERE Deleted =0
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID
                            AND adac.MAMAId = peinv.MAMAId  and AdvisorType='L'
                            )
                            UNION (
                            SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                            FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisorcompanies AS adcomp
                            WHERE Deleted =0
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adcomp.CIAId = cia.CIAID
                            AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='L'
                            )
                            ORDER BY Cianame";
                        }
                        if ($rsadvisor = mysql_query($advisorsql)){
                                $advisor_cnts = mysql_num_rows($rsadvisor);
                        }
			
                        if($advisor_cnts >0){
                             mysql_data_seek($rsadvisor ,0);
                             $commacount=0;
                                While($myrow=mysql_fetch_array($rsadvisor, MYSQL_BOTH))
                                {
                                        $companyname=trim($myrow["Cianame"]);
                                        $companyname=strtolower($companyname);

                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            if($commacount>0)
                                                echo ",";
                                            $advisors = $myrow["Cianame"] ;
                                            $advisorId = $myrow["CIAId"] ;
                                            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                            $isselcted = (trim($_POST['keywordsearchmain'])==trim($advisors)) ? 'SELECTED' : '';
                                            echo "{value : '".$advisors."',id : ".$advisorId."}" ;
                                            //echo "'".$advisors."'";
                                            $commacount++;
                                        }
                                }                          
                        }
                    }
                    elseif($dealvalue==104){
                        
                        if($vcflagValue==0){
                         $showallsql="(
                        SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId 
                        FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                        WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='T' GROUP BY peinv.PEId
                        )
                        UNION (
                        SELECT  cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                        FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                        WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='T' GROUP BY peinv.PEId
                        )";
                        }
                        elseif($vcflagValue==2){
                            $advisorsql="(SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                            FROM REmanda AS peinv, REcompanies AS c, REadvisor_cias AS cia,
                            REinvestments_advisoracquirer AS adac
                            WHERE peinv.Deleted=0
                             AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID   and AdvisorType='T'
                            AND adac.PEId = peinv.MandAId)
                            UNION (
                            SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                            FROM REmanda AS peinv, REcompanies AS c,  REadvisor_cias AS cia,
                            REinvestments_advisorcompanies AS adac
                            WHERE peinv.Deleted=0
                             AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID and AdvisorType='T'
                            AND adac.PEId = peinv.MandAId ) order by Cianame";
                        } 
                        elseif($vcflagValue==3){
                            
                            $advisorsql="(
                            SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                            FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisoracquirer AS adac
                            WHERE Deleted =0
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID
                            AND adac.MAMAId = peinv.MAMAId  and AdvisorType='T'
                            )
                            UNION (
                            SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                            FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisorcompanies AS adcomp
                            WHERE Deleted =0
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adcomp.CIAId = cia.CIAID
                            AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='T'
                            )
                            ORDER BY Cianame";
                        }
                        if ($rsadvisor = mysql_query($advisorsql)){
                                $advisor_cnts = mysql_num_rows($rsadvisor);
                        }
			
                        if($advisor_cnts >0){
                             mysql_data_seek($rsadvisor ,0);
                             $commacount=0;
                                While($myrow=mysql_fetch_array($rsadvisor, MYSQL_BOTH))
                                {
                                        $companyname=trim($myrow["Cianame"]);
                                        $companyname=strtolower($companyname);

                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            if($commacount>0)
                                                echo ",";
                                            $advisors = $myrow["Cianame"] ;
                                            $advisorId = $myrow["CIAId"] ;
                                            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                            $isselcted = (trim($_POST['keywordsearchmain'])==trim($advisors)) ? 'SELECTED' : '';
                                            echo "{value : '".$advisors."',id : ".$advisorId."}" ;
                                            //echo "'".$advisors."'";
                                            $commacount++;
                                        }
                                }                          
                        }
                    }
                
                
                ?>
            ];
            $( "#autocomplete" ).autocomplete({
            minLength: 0,
            source: autodata,
            focus: function( event, ui ) {
            $( "#autocomplete" ).val( ui.item.value );
            return false;
            },
            select: function( event, ui ) {
            $( "#autocomplete" ).val( ui.item.value);
            $( "#compid" ).val( ui.item.id);
            idval=$("#compid").val();
             if(demotour==1) {
               
                        if(idval==69){
                        $("#detailpost").attr("href","<?php echo BASE_URL; ?>re/redirdetails.php?value="+idval).trigger("click");
                        }
                        else {
                             showErrorDialog(warmsg);
                             $("#detailpost").attr("href","javascript:").trigger("click"); 
                             $("#autocomplete").val(''); 
                        }
            }
            else
                {
                    //$("#detailpost").attr("href","<?php echo BASE_URL; ?>dev/re/redirdetails.php?value="+idval).trigger("click");
                    if(<?php echo $dealvalue;?>==101)
                    {
                        $("#detailpost").attr("href","<?php echo BASE_URL; ?>re/redirdetails.php?value="+idval+"/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>").trigger("click");
                    }
                    else if(<?php echo $dealvalue;?>==102)
                    {
                        $("#detailpost").attr("href","<?php echo BASE_URL; ?>re/redircomdetails.php?value="+idval+"/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>").trigger("click");
                    }
                    else if(<?php echo $dealvalue;?>==103)
                    {
                        $("#detailpost").attr("href","<?php echo BASE_URL; ?>re/rediradvisor.php?value="+idval+"/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>").trigger("click");
                    }
                    else if(<?php echo $dealvalue;?>==104)
                    {
                        $("#detailpost").attr("href","<?php echo BASE_URL; ?>re/rediradvisor.php?value="+idval+"/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>").trigger("click");
                    }
            }
            return false;
            }
            })
            });
    </script>
    <a id="detailpost" class="postlink"></a> 
    <input type="text" id="autocomplete"  name="autocomplete" type="text" placeholder="Directory Search" >
    <a type="text" id="compid" ></a>
    <input type="button" id="searchsub" name="fliter_dir" value="" onclick="this.form.submit();">
</div>
<!--input type="text" id="autocomplete"  name="autocomplete" type="text" placeholder="Directory Search" >
<script>
$( "#autocomplete" ).autocomplete({
   // source: [ 'c++', 'java', 'php', 'coldfusion', 'javascript', 'asp', 'ruby' ]
   source: [<?php
            /* populating the investortype from the investortype table */
		$searchStrings="Undisclosed";
			$searchStrings=strtolower($searchStrings);

			$searchStrings1="Unknown";
			$searchStrings1=strtolower($searchStrings1);

			$searchStrings2="Others";
			$searchStrings2=strtolower($searchStrings2);

            $getInvestorSqls="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM REinvestments AS pe, REcompanies AS pec, REinvestments_investors AS peinv,
				REinvestors AS inv, realestatetypes AS s
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND s.RETypeId = pe.StageId
				AND peinv.PEId = pe.PEId
				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 and inv.Investor !='' order by inv.Investor ";

            if ($rsinvestors = mysql_query($getInvestorSqls)){
               $investors_cnts = mysql_num_rows($rsinvestors);
            }

            if($investors_cnts >0){
                 mysql_data_seek($rsinvestor ,0);
                  $commacount=0;
             	 While($myrows=mysql_fetch_array($rsinvestors, MYSQL_BOTH)){
                	$Investornames=trim($myrows["Investor"]);
					$Investornames=strtolower($Investornames);

					$invResults=substr_count($Investornames,$searchStrings);
					$invResults1=substr_count($Investornames,$searchStrings1);
					$invResults2=substr_count($Investornames,$searchStrings2);

					if(($invResults==0) && ($invResults1==0) && ($invResults2==0) && $myrows["Investor"]!=""){
						$investors = $myrows["Investor"];
						$investorsId = $myrows["InvestorId"];
                                                 if($commacount>0)
                                                echo ",";
						//echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
						$isselcted = (trim($_POST['keywordsearchmain'])==trim($investors)) ? 'SELECTED' : '';
						echo "'".$investors."'";
                                                 $commacount++;
					}
            	}
        	}
    ?>]
});
</script>
<input type="button" name="fliter_dir" value="" onclick="this.form.submit();" -->
</div>


<h3>Show by:</h3>
        <div class="show-by-list">
        <ul><li>
        <a href="redirview.php?s=" class="postlink <?php if($_REQUEST['s']==""){?> active<?php } ?>" >All</a></li>
    <li><a href="redirview.php?s=a" class="postlink <?php if(a==$_REQUEST['s']){?> active<?php }?>">A</a></li><li><a href="redirview.php?s=b" class="postlink <?php if(b==$_REQUEST['s']){?> active <?php }?>">B</a></li>
    <li><a href="redirview.php?s=c" class="postlink <?php if(c==$_REQUEST['s']){?> active<?php }?>">C</a></li><li><a href="redirview.php?s=d" class="postlink <?php if(d==$_REQUEST['s']){?> active <?php }?>">D</a></li>
    <li><a href="redirview.php?s=e" class="postlink <?php if(e==$_REQUEST['s']){?> active<?php }?>">E</a></li><li><a href="redirview.php?s=f" class="postlink <?php if(f==$_REQUEST['s']){?> active <?php }?>">F</a></li>
    <li><a href="redirview.php?s=g" class="postlink <?php if(g==$_REQUEST['s']){?> active<?php }?>">G</a></li><li><a href="redirview.php?s=h" class="postlink <?php if(h==$_REQUEST['s']){?> active <?php }?>">H</a></li>
    <li><a href="redirview.php?s=i" class="postlink <?php if(i==$_REQUEST['s']){?> active<?php }?>">I</a></li><li><a href="redirview.php?s=j" class="postlink <?php if(j==$_REQUEST['s']){?> active <?php }?>">J</a></li>
    <li><a href="redirview.php?s=k" class="postlink <?php if(k==$_REQUEST['s']){?> active<?php }?>">K</a></li><li><a href="redirview.php?s=l" class="postlink <?php if(l==$_REQUEST['s']){?> active <?php }?>">L</a></li>
    <li><a href="redirview.php?s=m" class="postlink <?php if(m==$_REQUEST['s']){?> active<?php }?>">M</a></li><li><a href="redirview.php?s=n" class="postlink <?php if(n==$_REQUEST['s']){?> active <?php }?>">N</a></li>
    <li><a href="redirview.php?s=o" class="postlink <?php if(o==$_REQUEST['s']){?> active<?php }?>">O</a></li><li><a href="redirview.php?s=p" class="postlink <?php if(p==$_REQUEST['s']){?> active <?php }?>">P</a></li>
    <li><a href="redirview.php?s=q" class="postlink <?php if(q==$_REQUEST['s']){?> active<?php }?>">Q</a></li><li><a href="redirview.php?s=r" class="postlink <?php if(r==$_REQUEST['s']){?> active <?php }?>">R</a></li>
    <li><a href="redirview.php?s=s" class="postlink <?php if(s==$_REQUEST['s']){?> active<?php }?>">S</a></li><li><a href="redirview.php?s=t" class="postlink <?php if(t==$_REQUEST['s']){?> active <?php }?>">T</a></li>
    <li><a href="redirview.php?s=u" class="postlink <?php if(u==$_REQUEST['s']){?> active<?php }?>">U</a></li><li><a href="redirview.php?s=v" class="postlink <?php if(v==$_REQUEST['s']){?> active <?php }?>">V</a></li>
    <li><a href="redirview.php?s=w" class="postlink <?php if(w==$_REQUEST['s']){?> active<?php }?>">W</a></li><li><a href="redirview.php?s=x" class="postlink <?php if(x==$_REQUEST['s']){?> active <?php }?>">X</a></li>
    <li><a href="redirview.php?s=y" class="postlink <?php if(y==$_REQUEST['s']){?> active<?php }?>">Y</a></li><li><a href="redirview.php?s=z" class="postlink <?php if(z==$_REQUEST['s']){?> active <?php }?>">Z</a></li>
</ul></div>

                    <?php
                    if($notable==false)
                    {
                    ?>
                    <div class="list-view-table">

                    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTables">
                        <thead>
                            <tr>
                            <?php 
                                if($dealvalue==101){
                                    if($vcflagValue==0){?>
                                        <th colspan="<?php echo $columnlimit; ?>">List of PE-RE Investors</th>
                                    <?php }
                                    elseif($vcflagValue==1){?>
                                        <th colspan="<?php echo $columnlimit; ?>">List of PE-IPO Investors</th>
                                    <?php }
                                    elseif($vcflagValue==2){?>
                                        <th colspan="<?php echo $columnlimit; ?>">List of PE-EXIT-M&A Investors</th>
                                    <?php }
                                    elseif($vcflagValue==3){?>
                                        <th colspan="<?php echo $columnlimit; ?>">List of Other M&A Investors</th>
                                    <?php } 
                                 }
                                 elseif($dealvalue==102){
                                   if($vcflagValue==0){?>
                                        <th colspan="<?php echo $columnlimit; ?>">List of PE-RE Companies</th>
                                    <?php }
                                    elseif($vcflagValue==1){?>
                                        <th colspan="<?php echo $columnlimit; ?>">List of PE-IPO Companies</th>
                                    <?php }
                                    elseif($vcflagValue==2){?>
                                        <th colspan="<?php echo $columnlimit; ?>">List of PE-EXIT-M&A Companies</th>
                                    <?php }
                                    elseif($vcflagValue==3){?>
                                        <th colspan="<?php echo $columnlimit; ?>">List of Other M&A Companies</th>
                                    <?php } 
                                 } 
                                  elseif($dealvalue==103){
                                   if($vcflagValue==0){?>
                                        <th colspan="<?php echo $columnlimit; ?>">List of PE-RE Legal Advisor</th>
                                    <?php }
                                    elseif($vcflagValue==1){?>
                                        <th colspan="<?php echo $columnlimit; ?>">List of PE-IPO Legal Advisor</th>
                                    <?php }
                                    elseif($vcflagValue==2){?>
                                        <th colspan="<?php echo $columnlimit; ?>">List of PE-EXIT-M&A Legal Advisor</th>
                                    <?php }
                                    elseif($vcflagValue==3){?>
                                        <th colspan="<?php echo $columnlimit; ?>">List of Other M&A Legal Advisor</th>
                                    <?php } 
                                 } 
                                 elseif($dealvalue==104){
                                   if($vcflagValue==0){?>
                                        <th colspan="<?php echo $columnlimit; ?>">List of PE-RE Transaction Advisor</th>
                                    <?php }
                                    elseif($vcflagValue==1){?>
                                        <th colspan="<?php echo $columnlimit; ?>">List of PE-IPO Transaction Advisor</th>
                                    <?php }
                                    elseif($vcflagValue==2){?>
                                        <th colspan="<?php echo $columnlimit; ?>">List of PE-EXIT-M&A Transaction Advisor</th>
                                    <?php }
                                    elseif($vcflagValue==3){?>
                                        <th colspan="<?php echo $columnlimit; ?>">List of Other M&A Transaction Advisor</th>
                                    <?php } 
                                 } 
                                 ?>
                            </tr>
                        </thead>
                        <tbody id="movies">
                        <?php
                            //Code to add PREV /NEXT
                            $icount = 0;
                            if ($_SESSION['investeeId'])
                                unset($_SESSION['investeeId']);
                            if ($_SESSION['resultCompanyId'])
                                unset($_SESSION['resultCompanyId']);
                            if($_SESSION['advisorId'])
                                unset($_SESSION['advisorId']);

                            mysql_data_seek($rsinvestor ,0);
                            $count=mysql_num_rows($rsinvestor);
                            if($dealvalue==101){
                                While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                {
                                    $Investorname=trim($myrow["Investor"]);
                                    $Investorname=strtolower($Investorname);

                                    $invResult=substr_count($Investorname,$searchString);
                                    $invResult1=substr_count($Investorname,$searchString1);
                                    $invResult2=substr_count($Investorname,$searchString2);
                                    if($newrowflag==1)
                                        echo "<tr><td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            $_SESSION['investeeId'][$icount++] = $myrow["InvestorId"];
                                       //  $_SESSION['resultCompanyId'][$icount++] = $myrow["InvestorId"];

                                            $investor=($myrow["Investor"]!="")?$myrow["Investor"]:"&nbsp";

                                            if($investor)
                                            ?>
                                                <tr>
                                                    <td ><a class="postlink" href="redirdetails.php?value=<?php echo $myrow["InvestorId"];?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>"> <?php  echo $investor;?> </a></td>
                                                </tr>
                                            <?php
                                                $totalCount=$totalCount+1;
                                        }

                                        $newrowflag=0;
                                        if($i==$rowlimit)
                                        {
                                            $i=1;
                                            echo "</table></td>"; 
                                            
                                            if($count>$i && $columncount<$columnlimit && $j!=$count)
                                            {
                                                echo "<td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";

                                            }
                                            elseif ($j==$count)
                                            {
                                               echo "</table></td></tr>";
                                            }
                                           
                                            if($columncount==$columnlimit)
                                            {

                                                $columncount=1;
                                                $newrowflag=1;
                                            }
                                            else
                                            {
                                                $columncount++;
                                            }
                                        }
                                        elseif ($j==$count)
                                        {
                                              echo "</table></td></tr>";
                                        }
                                        
                                        else if(($invResult==0) && ($invResult1==0) && ($invResult2==0)) {
                                            $i++;
                                        }
                                      
                                        $j++;
                                    }
                                }
                                elseif($dealvalue==102){
                                    
                                    While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                    {
                                            $companyname=trim($myrow["companyname"]);
                                            $companyname=strtolower($companyname);

                                            $invResult=substr_count($companyname,$searchString);
                                            $invResult1=substr_count($companyname,$searchString1);
                                            $invResult2=substr_count($companyname,$searchString2);
                                           if($newrowflag==1)
                                               echo "<tr><td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";

                                            if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                            {
                                                $_SESSION['resultCompanyId'][$icount++] = $myrow["PECompanyId"];

                               ?><tr>
                                   <td ><a class="postlink" href="redircomdetails.php?value=<?php echo $myrow["PECompanyId"];?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?> "><?php echo $myrow["companyname"];?> </a></td></tr>
                               <?php
                                               $totalCount=$totalCount+1;

                                            }

                                            $newrowflag=0;
                                            if($i==$rowlimit)
                                            {  
                                               $i=1;
                                               echo "</table></td>";
                                               if($count>$i && $columncount<$columnlimit)
                                               {

                                                   echo "<td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";                                                           
                                               }
                                               elseif ($j==$count) 
                                               {

                                                  echo "</table></td></tr>";
                                               }
                                            if($columncount==$columnlimit)
                                            {
                                                $columncount=1;
                                                $newrowflag=1;
                                            }
                                            else
                                            {

                                            $columncount++;
                                            }
                                            }
                                            elseif ($j==$count) 
                                            {
                                                  echo "</table></td></tr>";
                                            }
                                            else if(($invResult==0) && ($invResult1==0) && ($invResult2==0)) { 
                                                $i++;
                                            }
                                                    $j++;
                                       }
                                }
                                else if($dealvalue==103 || $dealvalue==104)
                                {
                                   While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                   {
                                           $adviosrname=trim($myrow["Investor"]);
                                           $adviosrname=strtolower($adviosrname);

                                           $invResult=substr_count($adviosrname,$searchString);
                                           $invResult1=substr_count($adviosrname,$searchString1);
                                           $invResult2=substr_count($adviosrname,$searchString2);
                                           if($newrowflag==1)
                                           echo "<tr><td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";

                                           if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                           {
                                                   $_SESSION['advisorId'][$icount++] = $myrow["CIAId"];
                                                   $querystrvalue= $myrow["CIAId"];
                                    ?>
                                                   <tr><td>
                                                   <a class="postlink" style="text-decoration: none" href='rediradvisor.php?value=<?php echo $querystrvalue;?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>' >
                                                   <?php echo $myrow["Cianame"]; ?></a></td></tr>
                                           <?php
                                                   $totalCount=$totalCount+1;
                                           }
                                            $newrowflag=0;
                                           if($i==$rowlimit)
                                           {  
                                              $i=1;
                                              echo "</table></td>";
                                              if($count>$i && $columncount<$columnlimit)
                                              {

                                                  echo "<td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";                                                           
                                              }
                                              elseif ($j==$count) 
                                              {

                                                 echo "</table></td></tr>";
                                              }
                                           if($columncount==$columnlimit)
                                           {
                                               $columncount=1;
                                               $newrowflag=1;
                                           }
                                           else
                                           {

                                           $columncount++;
                                           }
                                           }
                                           elseif ($j==$count) 
                                           {
                                                 echo "</table></td></tr>";
                                           }
                                           else if(($invResult==0) && ($invResult1==0) && ($invResult2==0)) { 
                                               $i++;
                                           }
                                                   $j++;
                                   }
                                }
                                ?>
                        </tbody>
                  </table>
                </div>
<!--</div>-->
<?php 
if($count > 0){ ?>
             <div class="holder"></div>
<?php }else{ echo "No Data Found"; 
}?>

		<?php
		if(($exportToExcel==1) && ($totalCount >=1))
		{
		?>
				<span style="float:right" class="one">
				<input class="export" id="expshowdealsbtn" type="button"  value="Export" name="showprofile">
				</span>
				 <script type="text/javascript">

                        $('#exportbtn').html('<input class ="export" type="button" id="expshowdeals"  value="Export" name="showprofile">');
                 </script>
		<?php
		}
		?>
    </div>
<?php
					}
                                        else
                                        {
                                            echo "NO DATA FOUND";
                                        }

			?>
</td>

</tr>
</table>

</div>
<div class=""></div>
<input type='hidden' name='value' value='<?php echo $vcflagValue; ?>' />
</form>
<?php if($dealvalue==101)
  {

  if($keyword!="" || $companysearch!="" || $sectorsearch!="" || $advisorsearchstring_legal!="" || $advisorsearchstring_trans!="" || $industry!="" || ($startRangeValue!="--" && $endRangeValue!="--") || $investorType!="" ||  ($dt1!="" && $dt2!="") || $stageval!="" || $dealtype!=""){
      ?>

    <form name="pegetdata" id="pegetdata"  method="post" action="exportreinvestors.php" >

           <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >
           <input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
           <input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >
           <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
           <input type="hidden" name="txthideemail" value=<?php echo $emailid; ?> >
           <input type="hidden" name="txthideindustryid" value="<?php echo $industry;?>" >
           <input type="hidden" name="txthidekeyword" value="<?php echo $keyword;?>" >
           <input type="hidden" name="txthidecompany" value="<?php echo $companysearch;?>" >
           <input type="hidden" name="txthidesector" value="<?php echo $sectorsearch;?>" >
           <input type="hidden" name="txthideadvisorlegal" value="<?php echo $advisorsearchstring_legal;?>" >
           <input type="hidden" name="txthideadvisortrans" value="<?php echo $advisorsearchstring_trans;?>" >
           <input type="hidden" name="txthidestageid" value="<?php echo $wherestagehide;?>" >
           <input type="hidden" name="txthidestartrange" value="<?php echo $startRangeValue;?>" >
           <input type="hidden" name="txthideendrange" value="<?php echo $endRangeValue;?>" >
           <input type="hidden" name="txthideinvestorTypeid" value="<?php echo $investorType;?>" >
           <input type="hidden" name="txthidedealTypeid" value="<?php echo $dealtype;?>" >
           <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" >
   </form>
   <?php
   }
   else
   {
   ?>
   <form name="pegetdata" id="pegetdata"  method="post" action="exportreinvestors.php" >

           <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >
               <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
               <input type="hidden" name="txthideemail" value=<?php echo $emailid; ?> >
               <input type="hidden" name="hidepeipomandapage" value="<?php echo $vcflagValue;?>" >
               <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" >
   </form>
   <?php
   }
}
elseif($dealvalue==102){
    
     if($keyword!="" || $companysearch!="" || $sectorsearch!="" || $advisorsearchstring_legal!="" || $advisorsearchstring_trans!="" || $industry!="" || ($startRangeValue!="--" && $endRangeValue!="--") || $investorType!="" ||  ($dt1!="" && $dt2!="") || $stageval!="" || $dealtype!=""){
      ?>

    <form name="pegetdata" id="pegetdata"  method="post" action="exportrecompany.php" >

           <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >
           <input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
           <input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >
           <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
           <input type="hidden" name="txthideemail" value=<?php echo $emailid; ?> >
           <input type="hidden" name="txthideindustryid" value="<?php echo $industry;?>" >
           <input type="hidden" name="txthidekeyword" value="<?php echo $keyword;?>" >
           <input type="hidden" name="txthidecompany" value="<?php echo $companysearch;?>" >
           <input type="hidden" name="txthidesector" value="<?php echo $sectorsearch;?>" >
           <input type="hidden" name="txthideadvisorlegal" value="<?php echo $advisorsearchstring_legal;?>" >
           <input type="hidden" name="txthideadvisortrans" value="<?php echo $advisorsearchstring_trans;?>" >
           <input type="hidden" name="txthidestageid" value="<?php echo $wherestagehide;?>" >
           <input type="hidden" name="txthidestartrange" value="<?php echo $startRangeValue;?>" >
           <input type="hidden" name="txthideendrange" value="<?php echo $endRangeValue;?>" >
           <input type="hidden" name="txthideinvestorTypeid" value="<?php echo $investorType;?>" >
           <input type="hidden" name="txthidedealTypeid" value="<?php echo $dealtype;?>" >
           <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" >
   </form>
   <?php
   }
   else
   {
   ?>
   <form name="pegetdata" id="pegetdata"  method="post" action="exportrecompany.php" >

           <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >
               <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
               <input type="hidden" name="txthideemail" value=<?php echo $emailid; ?> >
               <input type="hidden" name="hidepeipomandapage" value="<?php echo $vcflagValue;?>" >
               <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" >
   </form>
   <?php
   }
    
}
elseif($dealvalue==103 || $dealvalue==104){
    
     if($keyword!="" || $companysearch!="" || $sectorsearch!="" || $advisorsearchstring_legal!="" || $advisorsearchstring_trans!="" || $industry!="" || ($startRangeValue!="--" && $endRangeValue!="--") || $investorType!="" ||  ($dt1!="" && $dt2!="") || $stageval!=""){
      ?>

    <form name="pegetdata" id="pegetdata"  method="post" action="exportreadvisor.php" >

           <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >
           <input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
           <input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >
           <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
           <input type="hidden" name="txthideemail" value=<?php echo $emailid; ?> >
           <input type="hidden" name="txthideindustryid" value="<?php echo $industry;?>" >
           <input type="hidden" name="txthidekeyword" value="<?php echo $keyword;?>" >
           <input type="hidden" name="txthidecompany" value="<?php echo $companysearch;?>" >
           <input type="hidden" name="txthidesector" value="<?php echo $sectorsearch;?>" >
           <input type="hidden" name="txthideadvisorlegal" value="<?php echo $advisorsearchstring_legal;?>" >
           <input type="hidden" name="txthideadvisortrans" value="<?php echo $advisorsearchstring_trans;?>" >
           <input type="hidden" name="txthidestageid" value="<?php echo $wherestagehide;?>" >
           <input type="hidden" name="txthidestartrange" value="<?php echo $startRangeValue;?>" >
           <input type="hidden" name="txthideendrange" value="<?php echo $endRangeValue;?>" >
           <input type="hidden" name="txthideinvestorTypeid" value="<?php echo $investorType;?>" >
           <input type="hidden" name="txthidedealTypeid" value="<?php echo $dealtype;?>" >
           <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" >
   </form>
   <?php
   }
   else
   {
   ?>
   <form name="pegetdata" id="pegetdata"  method="post" action="exportreadvisor.php" >

           <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >
               <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
               <input type="hidden" name="txthideemail" value=<?php echo $emailid; ?> >
               <input type="hidden" name="hidepeipomandapage" value="<?php echo $vcflagValue;?>" >
               <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" >
   </form>
   <?php
   }
    
}
?>
<script type="text/javascript">
            $('#show-total-deal').html('<?php echo $totalCount; ?> Results found');
</script>
       <script type="text/javascript">
              /* $(".export").click(function(){
        $("#pegetdata").submit();
    });*/
                $("a.postlink").click(function(){

                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();

                    return false;

                });
                /*$('#expshowdeals').click(function(){
                     hrefval= 'exportreinvestors.php';
                     $("#pegetdata").submit();
                     return false;
                 });*/
    
            $('#expshowdeals').click(function(){ 
                jQuery('#maskscreen').fadeIn();
                jQuery('#popup-box-copyrights').fadeIn();   
                return false;
            });

            $('#expshowdealsbtn').click(function(){ 
                jQuery('#maskscreen').fadeIn();
                jQuery('#popup-box-copyrights').fadeIn();   
                return false;
            });

            function initExport(){ 
                
                url = ($("#pegetdata").attr('action')=='exportreinvestors.php') ? 'exportreinvestors.php' : '';
                        if (url=='')
                            url = ($("#pegetdata").attr('action')=='exportrecompany.php') ? 'exportrecompany.php' : '';
                        if (url=='')
                            url = ($("#pegetdata").attr('action')=='exportadvisorsprofile.php') ? 'exportadvisorsprofilecnt.php' : '';
                        if (url=='')
                            url = ($("#pegetdata").attr('action')=='exportadvisortrans.php') ? 'exportadvisortranscnt.php' : '';
                    $.ajax({
                        url: 'ajxCheckDownload.php',
                        dataType: 'json',
                        success: function(data){
                            var downloaded = data['recDownloaded'];
                            var exportLimit = data.exportLimit;
                            var currentRec = <?php echo $totalCount; ?>;

                            //alert(currentRec + downloaded);
                            var remLimit = exportLimit-downloaded;

                            if (currentRec < remLimit){
//                                hrefval= 'exportreinvestors.php';
//                                $("#pegetdata").attr("action", hrefval);
                                $("#pegetdata").submit();
                            }else{
                                jQuery('#preloading').fadeOut();
                                //alert("You have downloaded "+ downloaded +" records of allowed "+ exportLimit +" records(within 48 hours). You can download "+ remLimit +" more records.");
                                alert("Currently your export action is crossing the limit of "+ exportLimit +" records. You can download "+ remLimit +" more records. To increase the limit please contact info@ventureintelligence.com");
                            }
                            jQuery('#preloading').fadeOut();
                        },
                        error:function(){
                            jQuery('#preloading').fadeOut();
                            alert("There was some problem exporting...");
                        }

                    });
                }
                 
    
                function resetinput(fieldname)
                {

               // alert($('[name="'+fieldname+'"]').val());
                  $("#resetfield").val(fieldname);
                //  alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }
            </script>
                        
<div id="dialog-confirm" title="Guided tour Alert" style="display: none;">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span id="alertSpan"></span></p>
</div>
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



<!--  <script src="hopscotch.js"></script>
 <script src="demo.js"></script> -->
    
     <script type="text/javascript" >
    $(document).ready(function(){       
    
     <?php
    if(isset($_SESSION["demoTour"]) && $_SESSION["demoTour"]=='1'){ ?> 
     hopscotch.startTour(tour,19);     
     <?php }  ?>
           
          
    
    
    
    
    //// multi select checkbox hide
    $('.ui-multiselect').attr('id','uimultiselect');    
    $("#uimultiselect, #uimultiselect span").click(function() {
        if(demotour==1)
                {  showErrorDialog(warmsg); $('.ui-multiselect-menu').hide(); }     
    });
           
           });
           
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
        <?php  mysql_close();   ?>