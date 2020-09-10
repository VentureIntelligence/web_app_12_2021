<?php include_once("../globalconfig.php"); ?>
<?php  
        $companyId=632270771;
        $compId=0;
        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
      // print_r($_POST);
        $vcflagValue = isset($_REQUEST['value']) ? $_REQUEST['value'] :0;
        if($vcflagValue=="")
        {
            $vcflagValue=0;
        }
        if($vcflagValue==3 || $vcflagValue==3 || $vcflagValue==4){
            $peorvcflg=3;
            $showallcompInvFlag=9;
        }
        elseif($vcflagValue==9 || $vcflagValue==10 || $vcflagValue==11 || $vcflagValue==12){
            $peorvcflg=2;
        }
        
        if($resetfield=="autocomplete")
        { 
         $_POST['autocomplete']="";
         $dirsearch="";
        }
        else 
        {
         $dirsearch=trim($_POST['autocomplete']);
        }
        
        if($vcflagValue !=6)
        {
            $dealvalue = (isset($_POST['showdeals']) && $_POST['showdeals']!=105 && $_POST['showdeals']!=106) ? $_POST['showdeals'] :101;
        }
        else
        {
            $dealvalue = isset($_POST['showdeals']) ? $_POST['showdeals'] :105;
        }
        
        if ($vcflagValue==0)
        {
                $videalPageName="PEDir";
                $defvalue=41;
        }
        else if ($vcflagValue==1)
        {
                $videalPageName="VCDir";
                $defvalue=42;
        }
        include('checklogin.php');
        
       /* if($dealvalue!=101)
        {
            $search= isset($_REQUEST['s']) ? $_REQUEST['s'] : 'a';
            $_REQUEST['s']=isset($_REQUEST['s']) ? $_REQUEST['s'] : 'a';
        }
        else
        {*/
//            if($_REQUEST['industry']!='' || $_REQUEST['stage']!='' || $_REQUEST['invType']!='' || ($_REQUEST['invrangestart']!="" && $_REQUEST['invrangestart']!="--") || ($_REQUEST['invrangeend']!="" && $_REQUEST['invrangeend']!="--") 
//                    || ($_REQUEST['month1']!="" && $_REQUEST['month1']!="--" && $_REQUEST['year1']!="--" && $_REQUEST['year1']!="" && $_REQUEST['month2']!="" && $_REQUEST['month2']!="--" && $_REQUEST['year2']!="--" && $_REQUEST['year2']!=""))
//            {
//                $search= isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
//                $_REQUEST['s']=isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
//            }
//            else
//            {
//                $search= isset($_REQUEST['s']) ? $_REQUEST['s'] : 'a';
//                $_REQUEST['s']=isset($_REQUEST['s']) ? $_REQUEST['s'] : 'a';
//            }
            
       // }
        if($dirsearch !='')
        {
            if($dealvalue ==101)
            {
                $dirsearchall=" and Investor like '$dirsearch%'";
            }
            else if($dealvalue ==102 || $dealvalue ==106)
            {
                $dirsearchall=" and  pec.companyname like '$dirsearch%'";
            }
            else if($dealvalue ==103 || $dealvalue ==104)
            {
                $dirsearchall=" and  cia.Cianame like '$dirsearch%'";
            }
            else if($dealvalue ==105)
            {
                $dirsearchall=" and  inc.Incubator like '$dirsearch%'";
            }
            $search="";
            $_REQUEST['s']="";
            $_POST['industry']="";
            $_POST['invType']="";
            $_POST['stage']="";
            $_POST['invrangestart']="";
            $_POST['invrangeend']="";
        }

        $totalCount=0;

        $resetfield=$_POST['resetfield'];
        if($resetfield=="period")
        {
         $month1= 01; 
         $year1 = date('Y', strtotime(date('Y')." -1  Year"));
         $month2= date('n');
         $year2 = date('Y');
         $_POST['month1']="";
         $_POST['year1']="";
         $_POST['month2']="";
         $_POST['year2']="";
        } 
        else if(trim($_POST['keywordsearch']) !='' || trim($_POST['companysearch']) !='' || trim($_POST['advisorsearch_legal']) !='' || trim($_POST['advisorsearch_trans']) !='')
        {
            $_POST['industry']="";
            $_POST['invType']="";
            $_POST['stage']="";
            $_POST['round']="--";
            $_POST['invrangestart']="";
            $_POST['invrangeend']="";
            $_POST['month1']="";
            $_POST['year1']="";
            $_POST['month2']="";
            $_POST['year2']="";
        }
        if($resetfield=="keywordsearch")
        { 
        $_POST['keywordsearch']="";
        $keyword="";
        }
        else 
        {
            $keyword=trim($_POST['keywordsearch']);
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
        if($resetfield=="sectorsearch")
        { 
        $_POST['sectorsearch']="";
        $sectorsearch="";
        }
        else 
        {
            $sectorsearch=trim($_POST['sectorsearch']);
        }
        if($resetfield=="advisorsearch_trans")
        { 
        $_POST['advisorsearch_trans']="";
        $advisorsearch_trans="";
        }
        else 
        {
            $advisorsearch_trans=trim($_POST['advisorsearch_trans']);
        }
        if($resetfield=="advisorsearch_legal")
        { 
            $_POST['advisorsearch_legal']="";
            $advisorsearch_legal="";
        }
        else 
        {
            $advisorsearch_legal=trim($_POST['advisorsearch_legal']);
        }
        if($resetfield=="industry")
        { 
         $_POST['industry']="";
         $industry="";
        }
        else 
        {
         $industry=trim($_POST['industry']);
        }
         if($resetfield=="stage")
            { 
             $_POST['stage']="";
             $stageval="";
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
            // Round
            if($resetfield=="round")
            { 
                $_POST['round']="";
                $round="--";
            }
            else 
            {
                $round=trim($_POST['round']);
                if($round != '--'){
                    $searchallfield='';
                }
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
             if($resetfield=="range")
            { 
            $_POST['invrangestart']="";
            $_POST['invrangeend']="";
            $startRangeValue="--";
            $endRangeValue="--";
            $regionId="";
            }
            else 
            {
             $startRangeValue=$_POST['invrangestart'];
             $endRangeValue=$_POST['invrangeend'];
            }
            $endRangeValueDisplay =$endRangeValue;
            $whereind="";
            $whereinvType="";
            $wherestage="";
            $whereRound="";
            $wheredates="";
            $whererange="";
         
               if($resetfield=="searchallfield")
               { 
                $_POST['searchallfield']="";
                $searchallfield="";
               }
               else 
               {
                $searchallfield=trim($_POST['searchallfield']);
               }
               
                $searchString="Undisclosed";
                $searchString=strtolower($searchString);

                $searchString1="Unknown";
                $searchString1=strtolower($searchString1);

                $searchString2="Others";
                $searchString2=strtolower($searchString2);
 
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
                // Round Value
        if($round!="--" || $round != null)
        {
            $roundSql="SELECT * FROM `peinvestments` where `round` like '".$round."%'  group by `round`";
            if ($roundQuery = mysql_query($roundSql))
            {   
                $roundtxt='';
                While($myrow=mysql_fetch_array($roundQuery, MYSQL_BOTH))
                {
                        $roundtxt.=$myrow["round"].",";
                }
                $roundtxt=  trim($roundtxt,',');
            }
        }
        //
		if($boolStage==true)
		{
			foreach($stageval as $stageid)
			{
				$stagesql= "select Stage from stage where StageId=$stageid";
			//	echo "<br>**".$stagesql;
				if ($stagers = mysql_query($stagesql))
				{
					While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH))
					{
						$stagevaluetext= $stagevaluetext. ",".$myrow["Stage"] ;
					}
				}
			}
			$stagevaluetext =substr_replace($stagevaluetext, '', 0,1);
		}
		else
                {
			$stagevaluetext="";
			
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
                }
		//echo "<br>*************".$stagevaluetext;
		if($companyType=="L")
		        $companyTypeDisplay="Listed";
		elseif($companyType=="U")
                        $companyTypeDisplay="UnListed";
 	        elseif($companyType=="--")
                        $companyTypeDisplay="";

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

		if($regionId >0)
		{
			$regionSql= "select Region from region where RegionId=$regionId";
                        if ($regionrs = mysql_query($regionSql))
                        {
                                While($myregionrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
                                {
                                        $regionvalue=$myregionrow["Region"];
                                }
                        }
		}
                
            if($_POST['searchallfield']!='' || $_POST['keywordsearch']!='' || $_POST['advisorsearch_trans']!='' || $_POST['companysearch']!='' || $_POST['industry']!='' || $_POST['stage']!='' || $_POST['invType']!='' || ($_POST['invrangestart']!="" && $_POST['invrangestart']!="--") || ($_POST['invrangeend']!="" && $_POST['invrangeend']!="--") 
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
                    else if($dealvalue ==102 || $dealvalue ==106)
                    {
                        $search=" and  pec.companyname like '$search%'";
                    }
                    else if($dealvalue ==103 || $dealvalue ==104)
                    {
                        $search=" and  cia.Cianame like '$search%'";
                    }
                     else if($dealvalue ==105)
                    {
                        $search=" and  inc.Incubator like '$search%'";
                    }
                }
                if($vcflagValue==0)
                {
                        $addVCFlagqry="";
                        $pagetitle="PE Investors";
                }
                elseif($vcflagValue==1)
                {
                        //$addVCFlagqry="";
                        $addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
                        $pagetitle="VC Investors";
                }
                else if($vcflagValue==2)
                {
                       $addVCFlagqry="";
			$pagetitle="Angel Investments - Investors";
                }
                elseif($vcflagValue==3)
                {
                        $addVCFlagqry = "";
			$dbtype="SV";
                        $showallcompInvFlag=8;
                        $peorvcflg=3;
			$pagetitle="Social Venture Investments - Investors";
                }
                else if($vcflagValue==4)
                {
                        $addVCFlagqry = "";
			$dbtype="CT";
                        $showallcompInvFlag=9;
                        $peorvcflg=3;
			$pagetitle="CleanTech Investments - Investors";
                }
                elseif($vcflagValue==5)
                {
                        $addVCFlagqry = "";
			$dbtype="IF";
                        $showallcompInvFlag=10;
                        $peorvcflg=3;
			$pagetitle="Infrastructure Investments - Investors";
                }
                elseif($vcflagValue==7)
                {
                        $addVCFlagqry="";
                        $showallcompInvFlag=3;
                        $peorvcflg=2;
			$pagetitle="PE Backed IPOs - Investors";
                }
                else if($vcflagValue==8)
                {
                        $addVCFlagqry = " and VCFlag=1 ";
                        $showallcompInvFlag=4;
                        $peorvcflg=2;
                        $pagetitle="VC Backed IPOs - Investors";
                }
                else if($vcflagValue==9)
                {
                        $addVCFlagqry = "";
                        $showallcompInvFlag=11;
                        $peorvcflg=4;
                        $pagetitle="PMS - Investors";
                }
                else if($vcflagValue==10)
                {
                        $addVCFlagqry="";
                        $showallcompInvFlag=5;
                        $peorvcflg=4;
                        $pagetitle="PE Exits M&A - Investors";
                }
                elseif($vcflagValue==11)
                {
                        $addVCFlagqry = " and VCFlag=1 ";
                        $showallcompInvFlag=6;
                        $peorvcflg=4;
			$pagetitle="VC Exits M&A - Investors";
                }
                elseif($vcflagValue==12)
                {
                        $addVCFlagqry = " and VCFlag=1 ";
                        $showallcompInvFlag=11;
                        $peorvcflg=4;
			$pagetitle="VCPMS - Investors";
                }
                if($dealvalue == 103)
                {
                    $adtype = "L";
                }
                else
                {
                    $adtype = "T";
                }
                
                $month1=$_POST['month1'];
                $year1 = $_POST['year1'];
                $month2=$_POST['month2'];
                $year2 = $_POST['year2'];


                $datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
                $splityear1=(substr($year1,2));
                $splityear2=(substr($year2,2));
                $sdatevalueCheck1 = returnMonthname($month1) ." ".$splityear1;
                $edatevalueCheck2 = returnMonthname($month2) ."  ".$splityear2;
               
               /* if($sdatevalueDisplay1 == $sdatevalueCheck1)
                {
                    $datevalueCheck1=$sdatevalueCheck1;
                    $datevalueCheck2=$edatevalueCheck2;
                    $datevalueDisplay1=="";
                    $datevalueDisplay2=="";
                }
                else
                {
                    $datevalueCheck1=="";
                    $datevalueCheck2=="";
                    $datevalueDisplay1= $sdatevalueDisplay1;
                    $datevalueDisplay2= $edatevalueDisplay2;
                }*/
                   
                if($vcflagValue==0 || $vcflagValue==1)
                {
                       if($dealvalue==101)
                       {
                            if($keyword!="")
                            {
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec
                                    where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and
                                    pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%' order by inv.Investor ";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br> Investor search 0 or 1- ".$showallsql;
                            }
                            elseif($companysearch!="")
                            {
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec
                                    where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and
                                    pe.Deleted=0 " .$addVCFlagqry. " and pec.companyname like '%$companysearch%' order by inv.Investor ";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br> company search-0 or 1 ".$showallsql;
                            }
                            elseif($sectorsearch!="")
                            {
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec
                                    where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and
                                    pe.Deleted=0 " .$addVCFlagqry. " and pec.sector_business like '%$sectorsearch%' order by inv.Investor ";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br> sector search 0 or 1- ".$showallsql;
                            }
                            elseif($advisorsearch_legal!="")
                            {
                                    $showallsql="(select distinct peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorinvestors AS adac where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and pe.Deleted=0 
                                        " .$addVCFlagqry. " and cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' order by inv.Investor )
                                        UNION(select distinct peinv.InvestorId,inv.Investor 
                                        from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, advisor_cias AS cia,
                                        peinvestments_advisorcompanies AS adac where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.StageId=s.StageId and 
                                        pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and pe.Deleted=0 " .$addVCFlagqry. "
                                        and cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='L' order by inv.Investor )";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br>advisor_legal search 0 or 1- ".$showallsql;
                            }
                            elseif($advisorsearch_trans!="")
                            {
                                    $showallsql="(select distinct peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorinvestors AS adac where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and pe.Deleted=0 
                                        " .$addVCFlagqry. " and cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' order by inv.Investor )
                                        UNION(select distinct peinv.InvestorId,inv.Investor 
                                        from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, advisor_cias AS cia,
                                        peinvestments_advisorcompanies AS adac where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.StageId=s.StageId and 
                                        pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and pe.Deleted=0 " .$addVCFlagqry. "
                                        and cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='T' order by inv.Investor )";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br> $advisor_trans search 0 or 1- ".$showallsql;
                            }elseif($searchallfield!=""){
                                $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%' or pec.tags like '%$searchallfield%'";                                    
                                }else{
                                    $tags = '';
                                    $ex_tags = explode(',',$searchallfield);
                                    if(count($ex_tags) > 0){
                                        for($l=0;$l<count($ex_tags);$l++){
                                            if($ex_tags[$l] !=''){
                                                $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                $tags .= "pec.tags like '%:$value%' or ";
                                            }
                                        }
                                    }
                                    $tagsval = trim($tags,' or ');
                                }
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, country as c
                                    where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and inv.countryid= c.countryid and 
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and
                                    pe.Deleted=0 " .$addVCFlagqry. " and ( $tagsval ) $search order by inv.Investor ";
                                    
                                    $totalallsql=$showallsql;                                
                            }
                            else
                            {
                            $showallsql = "select distinct peinv.InvestorId,inv.Investor
                                from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv
                                where ";

                        	//echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                                if ($boolStage==true)
                                {
                                        $stagevalue="";
                                        $stageidvalue="";
                                        foreach($stageval as $stage)
                                        {
                                                //echo "<br>****----" .$stage;
                                                $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                                $stageidvalue=$stageidvalue.",".$stage;
                                        }

                                        $wherestage = $stagevalue ;
                                        $qryDealTypeTitle="Stage  - ";
                                        $strlength=strlen($wherestage);
                                        $strlength=$strlength-3;
                                //echo "<Br>----------------" .$wherestage;
                                $wherestage= substr ($wherestage , 0,$strlength);
                                $wherestage ="(".$wherestage.")";
                                //echo "<br>---" .$stringto;

                                }
                                 //
                                            if($round != "--" && $round !="")
                                            {
                                                $whereRound="pe.round LIKE '".$round."'";
                                            }
                                        //
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.amount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                               }
                                if ($whereind != "")
                                {
                                        $showallsql=$showallsql . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($wherestage != ""))
                                {
                                        $showallsql=$showallsql. $wherestage . " and " ;
                                        $bool=true;
                                }
                                if($whereRound !="")
                                        {
                                            $showallsql=$showallsql.$whereRound." and ";
                                        }
                                if (($whereInvType != "") )
                                {
                                        $showallsql=$showallsql.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                                if(($wheredates !== "") )
                                {
                                        $showallsql = $showallsql . $wheredates ." and ";
                                        $bool=true;
                                }
                               
                                $totalallsql = $showallsql. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.StageId and pec.industry!=15 and
                                pe.Deleted=0 " .$addVCFlagqry. " ".$dirsearchall."  order by inv.Investor ";
                                
                                $showallsql = $showallsql. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.StageId and pec.industry!=15 and
                                pe.Deleted=0 " .$addVCFlagqry. " " .$search." ".$dirsearchall."  order by inv.Investor ";
                                
                                
                                        
                                //echo $showallsql;
                            }
                                
                       }
                       elseif($dealvalue==102)
                       {
                           if($companysearch!="")
                            {
                                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                          FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                          WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                          AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                          AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and pec.companyname LIKE '%$companysearch%'
                                          ORDER BY pec.companyname";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br> Investor search 0 or 1- ".$showallsql;
                            }
                            else if($keyword!="")
                            {
                                
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                          FROM peinvestments_investors as peinv,pecompanies AS pec, peinvestments AS pe,peinvestors as inv, industry AS i, region AS r , stage AS s
                                          WHERE peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                          AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                          AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and Investor like '%$keyword%'
                                          ORDER BY pec.companyname";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br> Investor search 0 or 1- ".$showallsql;
                            }
                            elseif($sectorsearch!="")
                            {
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                          FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                          WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                          AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                          AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and pec.sector_business like '%$sectorsearch%'
                                          ORDER BY pec.companyname";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br> sector search 0 or 1- ".$showallsql;
                            }
                            elseif($advisorsearch_legal!="")
                            {
                                
                                $showallsql="(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, advisor_cias AS cia,
                                            peinvestments_advisorinvestors AS adac, industry AS i, region AS r , stage AS s
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. " AND adac.CIAId = cia.CIAID AND 
                                            cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='L' AND adac.PEId = pe.PEId)
                                            UNION (SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, advisor_cias AS cia,
                                            peinvestments_advisorcompanies AS adac, industry AS i, region AS r , stage AS s
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. " AND adac.CIAId = cia.CIAID AND 
                                            cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='L' AND adac.PEId = pe.PEId) 
                                            ORDER BY companyname";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br>advisor_legal search 0 or 1- 102l".$showallsql;
                            }
                            elseif($advisorsearch_trans!="")
                            {
                                    $showallsql="(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, advisor_cias AS cia,
                                            peinvestments_advisorinvestors AS adac, industry AS i, region AS r , stage AS s
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. " AND adac.CIAId = cia.CIAID AND 
                                            cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='T' AND adac.PEId = pe.PEId)
                                            UNION (SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, advisor_cias AS cia,
                                            peinvestments_advisorcompanies AS adac, industry AS i, region AS r , stage AS s
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. " AND adac.CIAId = cia.CIAID AND 
                                            cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='T' AND adac.PEId = pe.PEId) 
                                            ORDER BY companyname";
                                    
                                    $totalallsql=$showallsql;
                               //echo "<br> $advisor_trans search 0 or 1-102t ".$showallsql;
                            }
                           elseif($searchallfield!="")
                            {
                               $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "i.industry LIKE '$searchallfield%' or pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                            OR pec.sector_business LIKE '%$searchallfield%' or pec.AdditionalInfor like '%$searchallfield%' or pec.website like '$searchallfield%' or pec.linkedIn like '%$searchallfield%' or pec.yearfounded like '$searchallfield%' or pec.Address1 like '%$searchallfield%' or pec.Address2 like '%$searchallfield%' or pec.AdCity like '$searchallfield%' or pec.Zip like '$searchallfield%' or pec.OtherLocation like '%$searchallfield%' or pec.Country like '$searchallfield%' or pec.Telephone like '$searchallfield%' or pec.Fax like '$searchallfield%' or pec.Email like '%$searchallfield%' or pec.stockcode like '%$searchallfield%' or pec.tags like '%$searchallfield%'";                                    
                                }else{
                                    $tags = '';
                                    $ex_tags = explode(',',$searchallfield);
                                    if(count($ex_tags) > 0){
                                        for($l=0;$l<count($ex_tags);$l++){
                                            if($ex_tags[$l] !=''){
                                                $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                $tags .= "pec.tags like '%:$value%' or ";
                                            }
                                        }
                                    }
                                    $tagsval = trim($tags,' or ');
                                }
                                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                          FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                          WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                          AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                          AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and
                                             ( $tagsval )  $search
                                          ORDER BY pec.companyname";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br> Investor search 0 or 1- ".$showallsql;
                            }
                            else
                            {
                            $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                          FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                          WHERE ";
                            
                            if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                                if ($boolStage==true)
                                {
                                        $stagevalue="";
                                        $stageidvalue="";
                                        foreach($stageval as $stage)
                                        {
                                                //echo "<br>****----" .$stage;
                                                $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                                $stageidvalue=$stageidvalue.",".$stage;
                                        }

                                        $wherestage = $stagevalue ;
                                        $qryDealTypeTitle="Stage  - ";
                                        $strlength=strlen($wherestage);
                                        $strlength=$strlength-3;
                                //echo "<Br>----------------" .$wherestage;
                                $wherestage= substr ($wherestage , 0,$strlength);
                                $wherestage ="(".$wherestage.")";
                                //echo "<br>---" .$stringto;

                                }
                                 //
                                            if($round != "--" && $round !="")
                                            {
                                                $whereRound="pe.round LIKE '".$round."'";
                                            }
                                        //
                                
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.amount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                               }
                                if ($whereind != "")
                                {
                                        $showallsql=$showallsql . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($wherestage != ""))
                                {
                                        $showallsql=$showallsql. $wherestage . " and " ;
                                        $bool=true;
                                }
                                if($whereRound !="")
                                        {
                                            $showallsql=$showallsql.$whereRound." and ";
                                        }
                                if (($whereInvType != "") )
                                {
                                        $showallsql=$showallsql.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                                if(($wheredates !== "") )
                                {
                                        $showallsql = $showallsql . $wheredates ." and ";
                                        $bool=true;
                                }
                                
                                $totalallsql = $showallsql. "pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                          AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                          AND r.RegionId = pec.RegionId " .$addVCFlagqry. " ".$dirsearchall."
                                          ORDER BY pec.companyname";
                                
                                $showallsql = $showallsql. " pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                          AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                          AND r.RegionId = pec.RegionId " .$addVCFlagqry. " " .$search." ".$dirsearchall."
                                          ORDER BY pec.companyname";
                            }
                       }
                       else if($dealvalue==103 || $dealvalue==104)
                       {
                           if($advisorsearch_trans!="")
                           {
                               $showallsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s
				WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
				" AND c.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='".$adtype ."'
				AND adac.PEId = pe.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s
				WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='".$adtype ."'
				AND adac.PEId = pe.PEId ) order by Cianame";
                               
                               $totalallsql=$showallsql;
                               
                               //echo "0 or 1".$showallsql;
                           }
                            else if($advisorsearch_legal!="")
                           {
                               $showallsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s
				WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
				" AND c.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='".$adtype ."'
				AND adac.PEId = pe.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s
				WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='".$adtype ."'
				AND adac.PEId = pe.PEId ) order by Cianame";
                               
                               $totalallsql=$showallsql;
                               
                               //echo "0 or 1".$showallsql;
                           }
                           elseif($companysearch!="")
                            {
                               $showallsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s
				WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
				" AND c.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and c.companyname LIKE '%$companysearch%' and AdvisorType='".$adtype ."'
				AND adac.PEId = pe.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s
				WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and c.companyname LIKE '%$companysearch%' and AdvisorType='".$adtype ."'
				AND adac.PEId = pe.PEId ) order by Cianame";
                                    
                                    $totalallsql=$showallsql;
                                //echo "0 or 1".$showallsql;
                            }
                            else if($keyword!="")
                            {
                                 $showallsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments_investors as peinv, peinvestments AS pe, pecompanies AS c,peinvestors as inv, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s
				WHERE peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry." 
                                AND c.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and Investor like '%$keyword%' and AdvisorType='".$adtype ."'
				AND adac.PEId = pe.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments_investors as peinv,peinvestments AS pe, pecompanies AS c,peinvestors as inv,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s
				WHERE peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and Investor like '%$keyword%' and AdvisorType='".$adtype ."'
				AND adac.PEId = pe.PEId ) order by Cianame";
                                    
                                    $totalallsql=$showallsql;
                                //echo "0 or 1".$showallsql;
                            }
                            elseif($sectorsearch!="")
                            {
                                 $showallsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s
				WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
				" AND c.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and c.sector_business LIKE '%$sectorsearch%' and AdvisorType='".$adtype ."'
				AND adac.PEId = pe.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s
				WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and c.sector_business LIKE '%$sectorsearch%' and AdvisorType='".$adtype ."'
				AND adac.PEId = pe.PEId ) order by Cianame";
                                    
                                    $totalallsql=$showallsql;
                               //echo "0 or 1".$showallsql;
                            }
                                
                           elseif($searchallfield!="")
                            {
                               $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "cia.cianame LIKE '%$searchallfield%' or cia.website LIKE '%$searchallfield%' or cia.address LIKE '%$searchallfield%' or cia.city LIKE '$searchallfield%' or cia.country LIKE '$searchallfield%' or cia.phoneno LIKE '$searchallfield%' or cia.contactperson LIKE '%$searchallfield%' or cia.designation LIKE '%$searchallfield%' or cia.email LIKE '%$searchallfield%' or cia.linkedin LIKE '%$searchallfield%' or c.tags like '%$searchallfield%'";                                    
                                }else{
                                    $tags = '';
                                    $ex_tags = explode(',',$searchallfield);
                                    if(count($ex_tags) > 0){
                                        for($l=0;$l<count($ex_tags);$l++){
                                            if($ex_tags[$l] !=''){
                                                $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                $tags .= "c.tags like '%:$value%' or ";
                                            }
                                        }
                                    }
                                    $tagsval = trim($tags,' or ');
                                }
                               $showallsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s
				WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
				" AND c.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and 
                                ( $tagsval ) $search
                                and AdvisorType='".$adtype ."'
				AND adac.PEId = pe.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s
				WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and 
                                ( $tagsval ) $search and AdvisorType='".$adtype ."'
				AND adac.PEId = pe.PEId ) order by Cianame";
                                    
                                    $totalallsql=$showallsql;
                            }
                           else{
                               
                            $companysql= "(SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId from peinvestments as pe, industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorinvestors AS adac,stage as s where c.RegionId=re.RegionId and";
                            $companysql2= "SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId from peinvestments as pe, industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adac,stage as s where c.RegionId=re.RegionId and";
                        
                         
                            if ($industry > 0)
                                $whereind = " c.industry=" .$industry ;
                                
                            if ($investorType!= "")
                                $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                            if ($boolStage==true)
                            {
                                    $stagevalue="";
                                    $stageidvalue="";
                                    foreach($stageval as $stage)
                                    {
                                            //echo "<br>****----" .$stage;
                                            $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                            $stageidvalue=$stageidvalue.",".$stage;
                                    }

                                    $wherestage = $stagevalue ;
                                    $qryDealTypeTitle="Stage  - ";
                                    $strlength=strlen($wherestage);
                                    $strlength=$strlength-3;
                            //echo "<Br>----------------" .$wherestage;
                            $wherestage= substr ($wherestage , 0,$strlength);
                            $wherestage ="(".$wherestage.")";
                            //echo "<br>---" .$stringto;

                            }
                              //
                                            if($round != "--" && $round !="")
                                            {
                                                $whereRound="pe.round LIKE '".$round."'";
                                            }
                                        //   
                            if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                            {
                                    $startRangeValue=$startRangeValue;
                                    $endRangeValue=$endRangeValue-0.01;
                                    $qryRangeTitle="Deal Range (M$) - ";
                                    if($startRangeValue < $endRangeValue)
                                    {
                                            $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                    }
                                    elseif($startRangeValue = $endRangeValue)
                                    {
                                            $whererange = " pe.amount >= ".$startRangeValue ."";
                                    }
                            }
                               
                            if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                 $dt1 = $year1."-".$month1."-01";
                                 $dt2 = $year2."-".$month2."-01";
                                 $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                            }
                              
                           
                            
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
                                        
                            if (($wherestage != ""))
                            {
                                    $companysql=$companysql . $wherestage . " and " ;
                                    $companysql2=$companysql2 . $wherestage . " and " ;

                            }
                                       
                                if($whereRound !="")
                                        {
                                            $companysql=$companysql.$whereRound." and ";
                                            $companysql2=$companysql2.$whereRound." and ";
                                        }       
                            if (($whererange != "") )
                            {
                                    $companysql=$companysql .$whererange . " and ";
                                    $companysql2=$companysql2 .$whererange . " and ";
                            }
                                       
                                        
                            if(($wheredates !== "") )
                            {
                                    $companysql = $companysql.$wheredates ." and ";
                                    $companysql2 = $companysql2.$wheredates ." and ";
                            }
                                
                            $companysqltot = $companysql ." pe.Deleted=0 and c.industry = i.industryid and c.PEcompanyId = pe.PECompanyId and pe.StageId=s.StageId " . $addVCFlagqry . " 
                                AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' ".$dirsearchall."
				AND adac.PEId = pe.PEId ";
                            $companysqltot2 = $companysql2 ." pe.Deleted=0 and c.industry = i.industryid and c.PEcompanyId = pe.PECompanyId and pe.StageId=s.StageId " . $addVCFlagqry . " 
                                AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' ".$dirsearchall."
				AND adac.PEId = pe.PEId ";
                            
                            $companysql = $companysql ." pe.Deleted=0 and c.industry = i.industryid and c.PEcompanyId = pe.PECompanyId and pe.StageId=s.StageId " . $addVCFlagqry . " 
                                AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall."
				AND adac.PEId = pe.PEId ";
                            $companysql2 = $companysql2 ." pe.Deleted=0 and c.industry = i.industryid and c.PEcompanyId = pe.PECompanyId and pe.StageId=s.StageId " . $addVCFlagqry . " 
                                AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall."
				AND adac.PEId = pe.PEId ";
                            
                             
                            
                            $showallsql=$companysql.") UNION (".$companysql2.") ";
                             $totalallsql=$companysqltot.") UNION (".$companysqltot2.") ";
       
                            $orderby="order by Cianame";       
					
                            $showallsql=$showallsql.$orderby;
                            $totalallsql=$totalallsql.$orderby;
                            
                            //echo $showallsql;
                           
                            }
                       
                        }
                }
                else if($vcflagValue==2)
                {
                       if($dealvalue==101)
                       {
                           if($keyword!="")
                            {
                                    $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                        FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                        WHERE pe.InvesteeId = pec.PEcompanyId
                                        AND pec.industry !=15
                                        AND peinv.AngelDealId = pe.AngelDealId
                                        AND inv.InvestorId = peinv.InvestorId
                                        AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%' order by inv.Investor ";
                                    
                                    $totalallsql = $showallsql;
                                //echo "<br> Investor search- ".$showallsql;
                            }
                           elseif($searchallfield!="")
                            {
                               $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%' or pec.tags like '%$searchallfield%'";                                    
                                }else{
                                    $tags = '';
                                    $ex_tags = explode(',',$searchallfield);
                                    if(count($ex_tags) > 0){
                                        for($l=0;$l<count($ex_tags);$l++){
                                            if($ex_tags[$l] !=''){
                                                $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                $tags .= "pec.tags like '%:$value%' or ";
                                            }
                                        }
                                    }
                                    $tagsval = trim($tags,' or ');
                                }
                               $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                        FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv, country as c
                                        WHERE pe.InvesteeId = pec.PEcompanyId and inv.countryid= c.countryid  
                                        AND pec.industry !=15
                                        AND peinv.AngelDealId = pe.AngelDealId
                                        AND inv.InvestorId = peinv.InvestorId
                                        AND pe.Deleted=0 " .$addVCFlagqry. " and ( $tagsval ) order by inv.Investor ";
                                    
                                    $totalallsql = $showallsql; 
                            }
                            else
                            {
                                    $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                        FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                        WHERE pe.InvesteeId = pec.PEcompanyId
                                        AND pec.industry !=15
                                        AND peinv.AngelDealId = pe.AngelDealId
                                        AND inv.InvestorId = peinv.InvestorId
                                        AND pe.Deleted=0 " .$addVCFlagqry. " " .$search." ".$dirsearchall." order by inv.Investor ";
                                    
                                    $totalallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                        FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                        WHERE pe.InvesteeId = pec.PEcompanyId
                                        AND pec.industry !=15
                                        AND peinv.AngelDealId = pe.AngelDealId
                                        AND inv.InvestorId = peinv.InvestorId
                                        AND pe.Deleted=0 " .$addVCFlagqry. " ".$dirsearchall." order by inv.Investor ";
                            }
                       }
                       else if($dealvalue==102)
                       {
                           if($searchallfield!="")
                            {
                               $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "i.industry LIKE '$searchallfield%' or pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                            OR pec.sector_business LIKE '%$searchallfield%' or pec.AdditionalInfor like '%$searchallfield%' or pec.website like '$searchallfield%' or pec.linkedIn like '%$searchallfield%' or pec.yearfounded like '$searchallfield%' or pec.Address1 like '%$searchallfield%' or pec.Address2 like '%$searchallfield%' or pec.AdCity like '$searchallfield%' or pec.Zip like '$searchallfield%' or pec.OtherLocation like '%$searchallfield%' or pec.Country like '$searchallfield%' or pec.Telephone like '$searchallfield%' or pec.Fax like '$searchallfield%' or pec.Email like '%$searchallfield%' or pec.stockcode like '%$searchallfield%' or pec.tags like '%$searchallfield%' or";                                    
                                }else{
                                    $tags = '';
                                    $ex_tags = explode(',',$searchallfield);
                                    if(count($ex_tags) > 0){
                                        for($l=0;$l<count($ex_tags);$l++){
                                            if($ex_tags[$l] !=''){
                                                $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                $tags .= "pec.tags like '%:$value%' or ";
                                            }
                                        }
                                    }
                                    $tagsval = trim($tags,' or ');
                                }
                            $showallsql="SELECT DISTINCT pe.InvesteeId, pec. * , i.industry, r.Region
                                        FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r
                                        WHERE pec.PECompanyId = pe.InvesteeId 
                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId and ( $tagsval )  " .$addVCFlagqry. " " .$search." ".$dirsearchall."
                                            ORDER BY pec.companyname";

                                $totalallsql="SELECT DISTINCT pe.InvesteeId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r
                                            WHERE pec.PECompanyId = pe.InvesteeId 
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId and ( $tagsval )  " .$addVCFlagqry. " ".$dirsearchall."
                                            ORDER BY pec.companyname";
                            }else{
                                $showallsql="SELECT DISTINCT pe.InvesteeId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r
                                            WHERE pec.PECompanyId = pe.InvesteeId 
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                        AND r.RegionId = pec.RegionId " .$addVCFlagqry. " " .$search." ".$dirsearchall."
                                        ORDER BY pec.companyname";
                            
                            $totalallsql="SELECT DISTINCT pe.InvesteeId, pec. * , i.industry, r.Region
                                        FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r
                                        WHERE pec.PECompanyId = pe.InvesteeId 
                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                        AND r.RegionId = pec.RegionId " .$addVCFlagqry. " ".$dirsearchall."
                                        ORDER BY pec.companyname";
                                
                       }
                       }
                       
                        else if($dealvalue==110)
                       {
                           $Angelfilter='';
                           
                        
                           if(isset($_POST['angelsearchtype'])){
                             $Angelfilter='';
                              
                               if($_POST['angelsearchtype']==1 && $_REQUEST['company_location'] !=''){
                                   
                                    $loc = $_REQUEST['company_location'];
                                    $Angelfilter .= "  a.company_name LIKE '$loc%' OR a.location LIKE '$loc%' ";
                                   
                               }else if($_POST['angelsearchtype']==2 && $_REQUEST['raising_amount'] !=''){
                                    $raising_amount = $_REQUEST['raising_amount']*1000;
                                    
                                    $Angelfilter .= "  a.raising_amount >= '$raising_amount'  ";
                               }
                           }
                         
                           
                           
                           
                           
                            if( isset($_GET['s'])){
                               
                                $Angelfilter='';
                                $_REQUEST['company_location']=$_REQUEST['raising_amount']=$raising_amount='';
                                $char =  $_GET['s'];
                              
                                if($char!=''){
                                    
                                    
                                       if($Angelfilter=='')
                                             $Angelfilter .= "  a.company_name LIKE '$char%'  AND a.raising_amount >= 10000  ";                                        
//                                       else
//                                             $Angelfilter .= "  AND  a.company_name LIKE '$char%'  ";  
                                       
                                       
                                }

                            }
                            
                                  
                            
                            if($raising_amount>0){
                                $raising = " AND a.raising_amount >= $raising_amount ";
                            }else{
                                 $raising = "";
                            }
                                  
                             
                           // echo $Angelfilter; exit;
                            
                            if($searchallfield != ''){
                            if(!isset($_GET['s']) && $Angelfilter==''){
                                           $Angelfilter = " a.raising_amount >= 10000   ";
                                }
                            }else{
                                if(!isset($_GET['s']) && $Angelfilter==''){
                                       $Angelfilter = " a.company_name LIKE 'a%'  AND a.raising_amount >= 10000   ";
                            }
                            }
                            
                            if($Angelfilter!=''){
                                  $Angelfilter = " WHERE ". $Angelfilter. " $raising";
                            }      
                                   
                            if($searchallfield!="")
                            {
                                $angelCosql="SELECT a.*,p.PECompanyId FROM angelco_fundraising_cos   a LEFT JOIN  pecompanies p ON p.angelco_compID=a.angel_id   $Angelfilter and ( p.city LIKE '$searchallfield%' or a.company_name LIKE '$searchallfield%'
                                            OR p.sector_business LIKE '%$searchallfield%' or p.AdditionalInfor like '%$searchallfield%' )  ORDER BY a.company_name";
                            }else{
                             $angelCosql="SELECT a.*,p.PECompanyId FROM angelco_fundraising_cos   a LEFT JOIN  pecompanies p ON p.angelco_compID=a.angel_id   $Angelfilter  ORDER BY a.company_name";
                       }
                       }
                       
                }
                elseif($vcflagValue==3 || $vcflagValue==4 || $vcflagValue==5)
                {
                       if($dealvalue==101)
                       {
                           if($keyword!="")
                            {
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,
                                    peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%' order by inv.Investor ";
                                //echo "<br> Investor search- ".$showallsql;
                                    $totalallsql=$showallsql;
                                    
                            }
                            elseif($companysearch!="")
                            {
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,
                                    peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 " .$addVCFlagqry. " and pec.companyname like '%$companysearch%' order by inv.Investor ";
                                    
                                    $totalallsql=$showallsql;
                               // echo "<br> company search- ".$showallsql;
                            }
                            elseif($sectorsearch!="")
                            {
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,
                                    peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 " .$addVCFlagqry. " and pec.sector_business like '%$sectorsearch%' order by inv.Investor ";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br> sector search- ".$showallsql;
                            }
                            elseif($advisorsearch_legal!="")
                            {
                                    $showallsql="(select distinct peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorinvestors AS adac,peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and
                                        pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 
                                        " .$addVCFlagqry. " and cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' order by inv.Investor)
                                        UNION(select distinct peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorcompanies AS adac,peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and
                                        pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 
                                        " .$addVCFlagqry. " and cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' order by inv.Investor)";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br>advisor_legal search- ".$showallsql;
                            }
                            elseif($advisorsearch_trans!="")
                            {
                                   $showallsql="(select distinct peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorinvestors AS adac,peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and
                                        pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 
                                        " .$addVCFlagqry. " and cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' order by inv.Investor)
                                        UNION(select distinct peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorcompanies AS adac,peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and
                                        pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 
                                        " .$addVCFlagqry. " and cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' order by inv.Investor)";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br> $advisor_trans search- ".$showallsql;
                            }
                            elseif($searchallfield!="")
                            {
                                $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%' or pec.tags like '%$searchallfield%'";                                    
                                }else{
                                    $tags = '';
                                    $ex_tags = explode(',',$searchallfield);
                                    if(count($ex_tags) > 0){
                                        for($l=0;$l<count($ex_tags);$l++){
                                            if($ex_tags[$l] !=''){
                                                $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                $tags .= "pec.tags like '%:$value%' or ";
                                            }
                                        }
                                    }
                                    $tagsval = trim($tags,' or ');
                                }
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, country as c,
                                    peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and inv.countryid= c.countryid and 
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 " .$addVCFlagqry. " and ( $tagsval ) $search order by inv.Investor ";
                                    
                                    $totalallsql=$showallsql;
                               // echo "<br> company search- ".$showallsql;
                            }
                            else
                            {
                              $showallsql = "select distinct peinv.InvestorId,inv.Investor
                                from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv,
                                peinvestments_dbtypes as pedb where ";

                        	//echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                                if ($boolStage==true)
                                {
                                        $stagevalue="";
                                        $stageidvalue="";
                                        foreach($stageval as $stage)
                                        {
                                                //echo "<br>****----" .$stage;
                                                $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                                $stageidvalue=$stageidvalue.",".$stage;
                                        }

                                        $wherestage = $stagevalue ;
                                        $qryDealTypeTitle="Stage  - ";
                                        $strlength=strlen($wherestage);
                                        $strlength=$strlength-3;
                                //echo "<Br>----------------" .$wherestage;
                                $wherestage= substr ($wherestage , 0,$strlength);
                                $wherestage ="(".$wherestage.")";
                                //echo "<br>---" .$stringto;

                                }
                                 //
                                            if($round != "--" && $round !="")
                                            {
                                                $whereRound="pe.round LIKE '".$round."'";
                                            }
                                        //
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.amount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                               }
                               
                               if(($wheredates != "") )
                               {
                                        $showallsql = $showallsql . $wheredates ." and ";
                                        $bool=true;
                               }
             
                                if ($whereind != "")
                                {
                                        $showallsql=$showallsql . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($wherestage != ""))
                                {
                                        $showallsql=$showallsql. $wherestage . " and " ;
                                        $bool=true;
                                }
                                if($whereRound !="")
                                        {
                                            $showallsql=$showallsql.$whereRound." and ";
                                        }     
                                if (($whereInvType != "") )
                                {
                                        $showallsql=$showallsql.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                               
                                $totalallsql = $showallsql. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.StageId and pec.industry!=15  and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                pe.Deleted=0 " .$addVCFlagqry. " ".$dirsearchall."  order by inv.Investor ";
                                 
                                $showallsql = $showallsql. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.StageId and pec.industry!=15  and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                pe.Deleted=0 " .$addVCFlagqry. " " .$search." ".$dirsearchall."  order by inv.Investor ";
                                
                               
                            }
                    }
                    else if($dealvalue==102)
                    {

                        if($companysearch!="")
                        {
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and pec.companyname LIKE '%$companysearch%' ORDER BY pec.companyname";

                                $totalallsql=$showallsql;
                            //echo "<br> Investor search- ".$showallsql;
                        }
                        elseif($keyword!="")
                            {
                                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM peinvestments_investors as peinv,pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestors as inv,peinvestments_dbtypes as pedb
                                            WHERE peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. "  and Investor like '%$keyword%'  ORDER BY pec.companyname";
                              
                                    $totalallsql=$showallsql;
                                      //echo "<br> Investor search- ".$showallsql;
                                    
                            }
                            elseif($sectorsearch!="")
                            {
                                     $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and pec.sector_business LIKE '%$sectorsearch%' ORDER BY pec.companyname";
                                    
                                    $totalallsql=$showallsql;
                               // echo "<br> sector search- ".$showallsql;
                            }
                            elseif($advisorsearch_legal!="")
                            {
                                     $showallsql="(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb, advisor_cias AS cia,peinvestments_advisorinvestors AS adac 
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. "  and cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' ORDER BY pec.companyname
                                            )
                                        UNION(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb, advisor_cias AS cia,peinvestments_advisorcompanies AS adac 
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. "  and cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' ORDER BY pec.companyname
                                            )";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br>advisor_legal search- ".$showallsql;
                            }
                            elseif($advisorsearch_trans!="")
                            {
                                    $showallsql="(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb, advisor_cias AS cia,peinvestments_advisorinvestors AS adac 
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. "  and cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' ORDER BY pec.companyname
                                            )
                                        UNION(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb, advisor_cias AS cia,peinvestments_advisorcompanies AS adac 
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. "  and cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' ORDER BY pec.companyname
                                            )";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br> $advisor_trans search- ".$showallsql;
                            }else if($searchallfield !=''){
                                $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "i.industry LIKE '$searchallfield%' or pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                            OR pec.sector_business LIKE '%$searchallfield%' or pec.AdditionalInfor like '%$searchallfield%' or pec.website like '$searchallfield%' or pec.linkedIn like '%$searchallfield%' or pec.yearfounded like '$searchallfield%' or pec.Address1 like '%$searchallfield%' or pec.Address2 like '%$searchallfield%' or pec.AdCity like '$searchallfield%' or pec.Zip like '$searchallfield%' or pec.OtherLocation like '%$searchallfield%' or pec.Country like '$searchallfield%' or pec.Telephone like '$searchallfield%' or pec.Fax like '$searchallfield%' or pec.Email like '%$searchallfield%' or pec.stockcode like '%$searchallfield%' or pec.tags like '%$searchallfield%'";                                    
                                }else{
                                    $tags = '';
                                    $ex_tags = explode(',',$searchallfield);
                                    if(count($ex_tags) > 0){
                                        for($l=0;$l<count($ex_tags);$l++){
                                            if($ex_tags[$l] !=''){
                                                $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                $tags .= "pec.tags like '%:$value%' or ";
                                            }
                                        }
                                    }
                                    $tagsval = trim($tags,' or ');
                                }
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and ( $tagsval ) $search ORDER BY pec.companyname";

                                $totalallsql=$showallsql;
                            }
                        else
                        {
                            $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb
                                            WHERE ";
                            if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                                if ($boolStage==true)
                                {
                                        $stagevalue="";
                                        $stageidvalue="";
                                        foreach($stageval as $stage)
                                        {
                                                //echo "<br>****----" .$stage;
                                                $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                                $stageidvalue=$stageidvalue.",".$stage;
                                        }

                                        $wherestage = $stagevalue ;
                                        $qryDealTypeTitle="Stage  - ";
                                        $strlength=strlen($wherestage);
                                        $strlength=$strlength-3;
                                //echo "<Br>----------------" .$wherestage;
                                $wherestage= substr ($wherestage , 0,$strlength);
                                $wherestage ="(".$wherestage.")";
                                //echo "<br>---" .$stringto;

                                }
                                 //
                                            if($round != "--" && $round !="")
                                            {
                                                $whereRound="pe.round LIKE '".$round."'";
                                            }
                                        //
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.amount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                               }
                               
                               if(($wheredates != "") )
                               {
                                        $showallsql = $showallsql . $wheredates ." and ";
                                        $bool=true;
                               }
             
                                if ($whereind != "")
                                {
                                        $showallsql=$showallsql . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($wherestage != ""))
                                {
                                        $showallsql=$showallsql. $wherestage . " and " ;
                                        $bool=true;
                                }
                                if($whereRound !="")
                                        {
                                            $showallsql=$showallsql.$whereRound." and ";
                                        }  
                                if (($whereInvType != "") )
                                {
                                        $showallsql=$showallsql.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                               
                                $totalallsql = $showallsql. " pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. " ".$dirsearchall."
                                            ORDER BY pec.companyname";
                                 
                                $showallsql = $showallsql. " pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. " " .$search." ".$dirsearchall."
                                            ORDER BY pec.companyname";
                        }
                     }
                    else if($dealvalue==104 || $dealvalue==103)
                    {
                            if($advisorsearch_trans!="")
                            {
                                $showallsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId ) order by Cianame";
                                //echo "<br> Investor search- ".$showallsql;
                                $totalallsql=$showallsql;
                                
                            }
                            elseif($advisorsearch_legal!="")
                            {
                                
                                $showallsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId ) order by Cianame";
                                //echo "<br> Investor search- ".$showallsql;
                                $totalallsql=$showallsql;
                                
                            }
                            elseif($companysearch!="")
                            {
                                 $showallsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID  and c.companyname LIKE '%$companysearch%' and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID  and c.companyname LIKE '%$companysearch%' and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId ) order by Cianame";

                                    $totalallsql=$showallsql;
                                //echo "<br> Investor search- ".$showallsql;
                            }
                            elseif($keyword!="")
                            {
                                 $showallsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments_investors as pe,peinvestments AS peinv, pecompanies AS c,peinvestors as inv, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
				WHERE pe.PEId=peinv.PEId and inv.InvestorId=pe.InvestorId and peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID  and Investor like '%$keyword%' and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments_investors as pe,peinvestments AS peinv, pecompanies AS c,peinvestors as inv,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
				WHERE  pe.PEId=peinv.PEId and inv.InvestorId=pe.InvestorId and peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID  and Investor like '%$keyword%' and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId ) order by Cianame";
                              
                                    $totalallsql=$showallsql;
                                     // echo "<br> Investor search- ".$showallsql;
                                    
                            }
                            elseif($sectorsearch!="")
                            {
                                 $showallsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID  and c.sector_business LIKE '%$sectorsearch%' and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID  and c.sector_business LIKE '%$sectorsearch%' and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId ) order by Cianame";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br> sector search- ".$showallsql;
                            }
                            elseif($searchallfield!="")
                            {
                                $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "cia.cianame LIKE '%$searchallfield%' or cia.website LIKE '%$searchallfield%' or cia.address LIKE '%$searchallfield%' or cia.city LIKE '$searchallfield%' or cia.country LIKE '$searchallfield%' or cia.phoneno LIKE '$searchallfield%' or cia.contactperson LIKE '%$searchallfield%' or cia.designation LIKE '%$searchallfield%' or cia.email LIKE '%$searchallfield%' or cia.linkedin LIKE '%$searchallfield%' or c.tags like '%$searchallfield%'";                                    
                                }else{
                                    $tags = '';
                                    $ex_tags = explode(',',$searchallfield);
                                    if(count($ex_tags) > 0){
                                        for($l=0;$l<count($ex_tags);$l++){
                                            if($ex_tags[$l] !=''){
                                                $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                $tags .= "c.tags like '%:$value%' or ";
                                            }
                                        }
                                    }
                                    $tagsval = trim($tags,' or ');
                                }
                               $showallsql="(SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID  and ( $tagsval ) and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId  and AdvisorType='".$adtype ."' $search
				AND adac.PEId = peinv.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID  and ( $tagsval ) and AdvisorType='".$adtype ."' $search
				AND adac.PEId = peinv.PEId ) order by Cianame";
                                    $totalallsql=$showallsql;
                            }
                            else
                            {
                             
                                $companysql= "(SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId FROM peinvestments AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia,peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb WHERE c.RegionId=re.RegionId and";
                                $companysql2= "SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId FROM peinvestments AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia,peinvestments_advisorcompanies AS adac, stage as s,peinvestments_dbtypes as pedb WHERE c.RegionId=re.RegionId and";

                        	//echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " c.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " peinv.InvestorType = '".$investorType."'";
                                
                                if ($boolStage==true)
                                {
                                        $stagevalue="";
                                        $stageidvalue="";
                                        foreach($stageval as $stage)
                                        {
                                                //echo "<br>****----" .$stage;
                                                $stagevalue= $stagevalue. " peinv.StageId=" .$stage." or ";
                                                $stageidvalue=$stageidvalue.",".$stage;
                                        }

                                        $wherestage = $stagevalue ;
                                        $qryDealTypeTitle="Stage  - ";
                                        $strlength=strlen($wherestage);
                                        $strlength=$strlength-3;
                                //echo "<Br>----------------" .$wherestage;
                                $wherestage= substr ($wherestage , 0,$strlength);
                                $wherestage ="(".$wherestage.")";
                                //echo "<br>---" .$stringto;

                                }
                                //
                                            if($round != "--" && $round !="")
                                            {
                                                $whereRound="pe.round LIKE '".$round."'";
                                            }
                                        // 
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " peinv.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " peinv.amount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                               }
                               
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
                                        
                            if (($wherestage != ""))
                            {
                                    $companysql=$companysql . $wherestage . " and " ;
                                    $companysql2=$companysql2 . $wherestage . " and " ;

                            }
                                       
                                if($whereRound !="")
                                        {
                                            $companysql=$companysql . $whereRound . " and " ;
                                    $companysql2=$companysql2 . $whereRound . " and " ;
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
                               
                            $companysqltot = $companysql ." peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' ".$dirsearchall." 
				AND adac.PEId = peinv.PEId ";
                            $companysqltot2 = $companysql2 ." peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' ".$dirsearchall." 
				AND adac.PEId = peinv.PEId ";
                            
                            $companysql = $companysql ." peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
				AND adac.PEId = peinv.PEId ";
                            $companysql2 = $companysql2 ." peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
				AND adac.PEId = peinv.PEId ";
                            
                            
                            
                            $showallsql=$companysql.") UNION (".$companysql2.") ";
                            $totalallsql=$companysqltot.") UNION (".$companysqltot2.") ";
       
                            $orderby="order by Cianame"; 
                            $showallsql=$showallsql.$orderby;
                            $totalallsql=$totalallsql.$orderby;
                            
                            //echo $showallsql;
                            
                            }
                        }
                        
                }
                else if($vcflagValue==6)
                {
                       if($dealvalue==105)
                       {
                           
                            if($searchallfield !=''){
                               $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "inc.Incubator like '$searchallfield%' or inc.City LIKE '$searchallfield%'
                                            OR inc.AdditionalInfor like '%$searchallfield%' or inc.Address1 like '%$searchallfield%' or inc.Address2 like '%$searchallfield%' or inc.Zip like '%$searchallfield%' or inc.Telephone like '%$searchallfield%' or inc.Fax like '%$searchallfield%' or inc.Email like '%$searchallfield%' or inc.website like '%$searchallfield%' or inc.Management like '%$searchallfield%' or pec.tags like '%$searchallfield%'";                                    
                                }else{
                                    $tags = '';
                                    $ex_tags = explode(',',$searchallfield);
                                    if(count($ex_tags) > 0){
                                        for($l=0;$l<count($ex_tags);$l++){
                                            if($ex_tags[$l] !=''){
                                                $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                $tags .= "pec.tags like '%:$value%' or ";
                                            }
                                        }
                                    }
                                    $tagsval = trim($tags,' or ');
                                }
                           $showallsql="SELECT DISTINCT pe.IncubatorId, inc.Incubator
				FROM incubatordeals AS pe,  incubators as inc, pecompanies AS pec
                                    WHERE inc.IncubatorId=pe.IncubatorId and pec.PECompanyId = pe.IncubateeId and pe.Deleted=0 and ( $tagsval ) ".$search." ".$dirsearchall."
				 order by inc.Incubator ";
                           
                           $totalallsql="SELECT DISTINCT pe.IncubatorId, inc.Incubator
                                     FROM incubatordeals AS pe,  incubators as inc, pecompanies AS pec
                                     WHERE inc.IncubatorId=pe.IncubatorId and pec.PECompanyId = pe.IncubateeId and pe.Deleted=0 and ( $tagsval ) ".$dirsearchall."
                                      order by inc.Incubator ";
                                
                            }else{
                                $showallsql="SELECT DISTINCT pe.IncubatorId, inc.Incubator
                                     FROM incubatordeals AS pe,  incubators as inc
                                     WHERE inc.IncubatorId=pe.IncubatorId and pe.Deleted=0 ".$search." ".$dirsearchall."
                                      order by inc.Incubator ";
                                $totalallsql="SELECT DISTINCT pe.IncubatorId, inc.Incubator
                                     FROM incubatordeals AS pe,  incubators as inc
				WHERE inc.IncubatorId=pe.IncubatorId and pe.Deleted=0 ".$dirsearchall."
				 order by inc.Incubator ";
                       }
                       }
                       else if($dealvalue==106)
                       {
                           if($searchallfield !=''){
                               $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "i.industry LIKE '$searchallfield%' or pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                            OR pec.sector_business LIKE '%$searchallfield%' or pec.AdditionalInfor like '%$searchallfield%' or pec.website like '$searchallfield%' or pec.linkedIn like '%$searchallfield%' or pec.yearfounded like '$searchallfield%' or pec.Address1 like '%$searchallfield%' or pec.Address2 like '%$searchallfield%' or pec.AdCity like '$searchallfield%' or pec.Zip like '$searchallfield%' or pec.OtherLocation like '%$searchallfield%' or pec.Country like '$searchallfield%' or pec.Telephone like '$searchallfield%' or pec.Fax like '$searchallfield%' or pec.Email like '%$searchallfield%' or pec.stockcode like '%$searchallfield%' or pec.tags like '%$searchallfield%' ";                                    
                                }else{
                                    $tags = '';
                                    $ex_tags = explode(',',$searchallfield);
                                    if(count($ex_tags) > 0){
                                        for($l=0;$l<count($ex_tags);$l++){
                                            if($ex_tags[$l] !=''){
                                                $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                $tags .= "pec.tags like '%:$value%' or ";
                                            }
                                        }
                                    }
                                    $tagsval = trim($tags,' or ');
                                }
                            $showallsql="SELECT DISTINCT pe.IncubateeId, pec. *
				FROM pecompanies AS pec, incubatordeals AS pe,industry as i
				WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry
                                     and pe.Deleted=0 ".$search." ".$dirsearchall." and pec.industry!=15 and ( $tagsval )
                                    ORDER BY pec.companyname";

                                $totalallsql="SELECT DISTINCT pe.IncubateeId, pec. *
                                    FROM pecompanies AS pec, incubatordeals AS pe,industry as i
                                    WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry
                                     and pe.Deleted=0 ".$dirsearchall." and pec.industry!=15 and ( $tagsval )
                                    ORDER BY pec.companyname";
                           }else{
                                $showallsql="SELECT DISTINCT pe.IncubateeId, pec. *
                                 FROM pecompanies AS pec, incubatordeals AS pe,industry as i
                                 WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry
				 and pe.Deleted=0 ".$search." ".$dirsearchall." and pec.industry!=15
				ORDER BY pec.companyname";
                            
                            $totalallsql="SELECT DISTINCT pe.IncubateeId, pec. *
				FROM pecompanies AS pec, incubatordeals AS pe,industry as i
				WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry
				 and pe.Deleted=0 ".$dirsearchall." and pec.industry!=15
				ORDER BY pec.companyname";
                       }
                }
                }
                elseif($vcflagValue==7 || $vcflagValue==8)
                {
                        if($dealvalue==101)
                       {
                            
                            if($keyword!="")
                            {
                                $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND pec.industry !=15
				AND peinv.IPOId = pe.IPOId
				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%' order by inv.Investor ";
                                
                                $totalallsql=$showallsql;
                                 //echo "<br> sector search- ".$showallsql;
                            }
                            elseif($companysearch!="")
                            {
                                $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND pec.industry !=15
				AND peinv.IPOId = pe.IPOId
				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " and pec.companyname like '%$companysearch%' order by inv.Investor ";
                                
                                $totalallsql=$showallsql;
                                 //echo "<br> sector search- ".$showallsql;
                            }
                            elseif($sectorsearch!="")
                            {
                                $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND pec.industry !=15
				AND peinv.IPOId = pe.IPOId
				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " and pec.sector_business like '%$sectorsearch%' order by inv.Investor ";
                                
                                $totalallsql=$showallsql;
                                 //echo "<br> sector search- ".$showallsql;
                            }
                            elseif($searchallfield!="")
                            {
                                $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv, country as c
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND pec.industry !=15
				AND peinv.IPOId = pe.IPOId
				AND inv.InvestorId = peinv.InvestorId
                                and  inv.countryid= c.countryid 
				AND pe.Deleted=0 " .$addVCFlagqry. " and ( inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%' ) order by inv.Investor ";
                                
                                $totalallsql=$showallsql;
                                 //echo "<br> sector search- ".$showallsql;  
                            }
                            else
                            {
                             $showallsql = "SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
				WHERE ";

                        	//echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.IPOAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.IPOAmount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " IPODate between '" . $dt1. "' and '" . $dt2 . "'";
                               }
                               
                               if(($wheredates != "") )
                               {
                                        $showallsql = $showallsql . $wheredates ." and ";
                                        $bool=true;
                               }
             
                                if ($whereind != "")
                                {
                                        $showallsql=$showallsql . $whereind ." and ";
                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($whereInvType != "") )
                                {
                                        $showallsql=$showallsql.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                               
                                $totalallsql = $showallsql. " pe.PECompanyId = pec.PEcompanyId
				AND pec.industry !=15
				AND peinv.IPOId = pe.IPOId
				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " ".$dirsearchall."  order by inv.Investor ";
                                 
                                $showallsql = $showallsql. " pe.PECompanyId = pec.PEcompanyId
				AND pec.industry !=15
				AND peinv.IPOId = pe.IPOId
				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " " .$search." ".$dirsearchall."  order by inv.Investor ";
                                
                                
                            }
                               // echo $showallsql;
                            
                       }
                       else if($dealvalue==102)
                       {
                            if($companysearch!="")
                            {
                                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                        FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                                        WHERE pec.PECompanyId = pe.PEcompanyId 
                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                        AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and pec.companyname LIKE '%$companysearch%' 
                                        ORDER BY pec.companyname";

                                    $totalallsql=$showallsql;
                                //echo "<br> Investor search- ".$showallsql;
                            }
                            else if($keyword!="")
                            {
                                 $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                        FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r, ipo_investors AS peinv, peinvestors AS inv
                                        WHERE pec.PECompanyId = pe.PEcompanyId
                                        AND peinv.IPOId = pe.IPOId
                                        AND inv.InvestorId = peinv.InvestorId
                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                        AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and Investor like '%$keyword%'
                                        ORDER BY pec.companyname";
                                
                                $totalallsql=$showallsql;
                                // echo "<br> sector search- ".$showallsql;
                            }
                            elseif($sectorsearch!="")
                            {
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                        FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                                        WHERE pec.PECompanyId = pe.PEcompanyId 
                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                        AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and pec.sector_business LIKE '%$sectorsearch%' 
                                        ORDER BY pec.companyname";
                                
                                $totalallsql=$showallsql;
                                // echo "<br> sector search- ".$showallsql;
                            }else if($searchallfield !=''){
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                        FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                                        WHERE pec.PECompanyId = pe.PEcompanyId 
                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                        AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and ( i.industry LIKE '$searchallfield%' or pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                            OR pec.sector_business LIKE '%$searchallfield%' or pec.AdditionalInfor like '%$searchallfield%' or pec.website like '$searchallfield%' or pec.linkedIn like '%$searchallfield%' or pec.yearfounded like '$searchallfield%' or pec.Address1 like '%$searchallfield%' or pec.Address2 like '%$searchallfield%' or pec.AdCity like '$searchallfield%' or pec.Zip like '$searchallfield%' or pec.OtherLocation like '%$searchallfield%' or pec.Country like '$searchallfield%' or pec.Telephone like '$searchallfield%' or pec.Fax like '$searchallfield%' or pec.Email like '%$searchallfield%' or pec.stockcode like '%$searchallfield%') $search
                                        ORDER BY pec.companyname";

                                    $totalallsql=$showallsql;
                            }
                            else
                            {
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                      FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                                      WHERE ";
                                
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.IPOAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.IPOAmount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " IPODate between '" . $dt1. "' and '" . $dt2 . "'";
                               }
                               
                               if(($wheredates != "") )
                               {
                                        $showallsql = $showallsql . $wheredates ." and ";
                                        $bool=true;
                               }
             
                                if ($whereind != "")
                                {
                                        $showallsql=$showallsql . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($wherestage != ""))
                                {
                                        $showallsql=$showallsql. $wherestage . " and " ;
                                        $bool=true;
                                }
                                
                                if($whereRound !="")
                                        {
                                            $showallsql=$showallsql . $whereRound . " and " ;
                                        }      
                                if (($whereInvType != "") )
                                {
                                        $showallsql=$showallsql.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                               
                                $totalallsql = $showallsql. " pec.PECompanyId = pe.PEcompanyId 
                                      AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                      AND r.RegionId = pec.RegionId " .$addVCFlagqry. " ".$dirsearchall." 
                                      ORDER BY pec.companyname";
                                 
                                $showallsql = $showallsql. " pec.PECompanyId = pe.PEcompanyId 
                                      AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                      AND r.RegionId = pec.RegionId " .$addVCFlagqry. " " .$search." ".$dirsearchall." 
                                      ORDER BY pec.companyname";
                                //echo $showallsql;
                            }
                       
                         }
                }
                else if($vcflagValue==9 ||$vcflagValue==10 || $vcflagValue==11 || $vcflagValue==12)
                {
                     
                    $dealtype=' , dealtypes as dt '; 
                   
                        if($dealvalue==101)
                       {
                             if($vcflagValue==9 || $vcflagValue==12) { $dealcond='AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1'; }
                            else if($vcflagValue==10 || $vcflagValue==11) { $dealcond='AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0'; }
                    
                            
                            if($keyword!="")
                            {
                                $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv  ".$dealtype." 
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%'   ".$dealcond."  order by inv.Investor";
                                
                                $totalallsql=$showallsql;
                            }
                            elseif($companysearch!="")
                            {
                                $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv   ".$dealtype." 
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " and pec.companyname like '%$companysearch%'   ".$dealcond."  order by inv.Investor";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br> company search- ".$showallsql;
                            }
                            elseif($sectorsearch!="")
                            {
                                    $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv  ".$dealtype." 
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND pec.industry !=15
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId
                                    AND pe.Deleted=0 " .$addVCFlagqry. " and pec.sector_business like '%$sectorsearch%'   ".$dealcond."  order by inv.Investor";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br> sector search- ".$showallsql;
                            }
                            elseif($advisorsearch_legal!="")
                            {
                                    $showallsql="(SELECT DISTINCT inv.InvestorId, inv.Investor
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisoracquirer AS adac  ".$dealtype."
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND pec.industry !=15
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId
                                    AND pe.Deleted=0 AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'   ".$dealcond."  and AdvisorType='L'
                                         AND adac.PEId = pe.MandAId)
                                         UNION(SELECT DISTINCT inv.InvestorId, inv.Investor
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisorcompanies AS adac  ".$dealtype."
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND pec.industry !=15
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId
                                    AND pe.Deleted=0 AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'   ".$dealcond."  and AdvisorType='L'
                                         AND adac.PEId = pe.MandAId)";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br>advisor_legal search- ".$showallsql;
                            }
                            elseif($advisorsearch_trans!="")
                            {
                                    $showallsql="(SELECT DISTINCT inv.InvestorId, inv.Investor
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisoracquirer AS adac  ".$dealtype."
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND pec.industry !=15
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId
                                    AND pe.Deleted=0 AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'   ".$dealcond."  and AdvisorType='T'
                                         AND adac.PEId = pe.MandAId)
                                         UNION(SELECT DISTINCT inv.InvestorId, inv.Investor
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisorcompanies AS adac  ".$dealtype."
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND pec.industry !=15
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId
                                    AND pe.Deleted=0 AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'   ".$dealcond."  and AdvisorType='T'
                                         AND adac.PEId = pe.MandAId)";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br> $advisor_trans search- ".$showallsql;
                            }
                            elseif($searchallfield!="")
                            {
                                $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, country as c   ".$dealtype." 
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
                                and  inv.countryid= c.countryid 
				AND pe.Deleted=0 " .$addVCFlagqry. " and ( inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%' )   ".$dealcond."  order by inv.Investor";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br> company search- ".$showallsql;
                                    
                            }
                            else
                            {
                              $showallsql = "SELECT DISTINCT inv.InvestorId, inv.Investor
							FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv   ".$dealtype." WHERE ";

                        	//echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.DealAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.DealAmount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                               }
                               
                               if(($wheredates != "") )
                               {
                                        $showallsql = $showallsql . $wheredates ." and ";
                                        $bool=true;
                               }
             
                                if ($whereind != "")
                                {
                                        $showallsql=$showallsql . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($whereInvType != "") )
                                {
                                        $showallsql=$showallsql.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                               
                                $totalallsql = $showallsql. " pe.PECompanyId = pec.PEcompanyId
							AND pec.industry !=15
							AND peinv.MandAId = pe.MandAId
							AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " ".$dirsearchall."    ".$dealcond."  order by inv.Investor ";  
                                
                                $showallsql = $showallsql. " pe.PECompanyId = pec.PEcompanyId
							AND pec.industry !=15
							AND peinv.MandAId = pe.MandAId
							AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " " .$search." ".$dirsearchall."    ".$dealcond."  order by inv.Investor ";  
                                
                                 
                                //echo $showallsql;
                            }
                       }
                       else if($dealvalue==102)
                       {
                            if($vcflagValue==9 || $vcflagValue==12) { $dealcond='AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1'; }
                             else if($vcflagValue==10 || $vcflagValue==11) { $dealcond='AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0'; }
                             
                            if($companysearch!="")
                            {
                                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                    FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r ".$dealtype."
                                    WHERE pec.PECompanyId = pe.PEcompanyId 
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId " .$addVCFlagqry." and pec.companyname LIKE '%$companysearch%'   ".$dealcond."
                                    ORDER BY pec.companyname";

                                    $totalallsql=$showallsql;
                                //echo "<br> Investor search- ".$showallsql;
                            }
                            elseif($keyword!="")
                            {
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, industry AS i, region AS r ".$dealtype."
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                AND r.RegionId = pec.RegionId 
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId " .$addVCFlagqry. " and Investor like '%$keyword%'   ".$dealcond."  order by inv.Investor";
                                
                                $totalallsql=$showallsql;
                            }
                            
                            elseif($sectorsearch!="")
                            {
                                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                    FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r ".$dealtype."
                                    WHERE pec.PECompanyId = pe.PEcompanyId 
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId " .$addVCFlagqry." and pec.sector_business LIKE '%$sectorsearch%'    ".$dealcond."
                                    ORDER BY pec.companyname";
                                    
                                    $totalallsql=$showallsql;
                               // echo "<br> sector search- ".$showallsql;
                            }
                            elseif($advisorsearch_legal!="")
                            {
                                    $showallsql="(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisoracquirer AS adac,
                                    industry AS i, region AS r  ".$dealtype."
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'    ".$dealcond."  and AdvisorType='L'
                                         AND adac.PEId = pe.MandAId)
                                         UNION(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region 
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisorcompanies AS adac,
                                    industry AS i, region AS r ".$dealtype."
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'   ".$dealcond."  and AdvisorType='L'
                                         AND adac.PEId = pe.MandAId)";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br>advisor_legal search- ".$showallsql;
                            }
                            elseif($advisorsearch_trans!="")
                            {
                                    $showallsql="(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region 
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisoracquirer AS adac,
                                    industry AS i, region AS r ".$dealtype."
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'   ".$dealcond."  and AdvisorType='T'
                                         AND adac.PEId = pe.MandAId)
                                         UNION(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region ".$dealtype."
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisorcompanies AS adac,
                                    industry AS i, region AS r ".$dealtype."
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'   ".$dealcond."  and AdvisorType='T'
                                         AND adac.PEId = pe.MandAId)";
                                    
                                    $totalallsql=$showallsql;
                               // echo "<br> $advisor_trans search- ".$showallsql;
                            }
                            else if($searchallfield!="")
                            {
                                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                    FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r ".$dealtype."
                                    WHERE pec.PECompanyId = pe.PEcompanyId 
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId " .$addVCFlagqry." and ( i.industry LIKE '$searchallfield%' or pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                            OR pec.sector_business LIKE '%$searchallfield%' or pec.AdditionalInfor like '%$searchallfield%' or pec.website like '$searchallfield%' or pec.linkedIn like '%$searchallfield%' or pec.yearfounded like '$searchallfield%' or pec.Address1 like '%$searchallfield%' or pec.Address2 like '%$searchallfield%' or pec.AdCity like '$searchallfield%' or pec.Zip like '$searchallfield%' or pec.OtherLocation like '%$searchallfield%' or pec.Country like '$searchallfield%' or pec.Telephone like '$searchallfield%' or pec.Fax like '$searchallfield%' or pec.Email like '%$searchallfield%' or pec.stockcode like '%$searchallfield%') ".$dealcond."
                                    ORDER BY pec.companyname";

                                    $totalallsql=$showallsql;
                                //echo "<br> Investor search- ".$showallsql;
                            }
                            else
                            {
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r  ".$dealtype."
                                WHERE ";
                                
                                //echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.DealAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.DealAmount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                               }
                               
                               if(($wheredates != "") )
                               {
                                        $showallsql = $showallsql . $wheredates ." and ";
                                        $bool=true;
                               }
             
                                if ($whereind != "")
                                {
                                        $showallsql=$showallsql . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($whereInvType != "") )
                                {
                                        $showallsql=$showallsql.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                               
                                $totalallsql = $showallsql. "  pec.PECompanyId = pe.PEcompanyId 
                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                AND r.RegionId = pec.RegionId " .$addVCFlagqry. " ".$dirsearchall."     ".$dealcond."
                                ORDER BY pec.companyname";  
                                
                                $showallsql = $showallsql. "  pec.PECompanyId = pe.PEcompanyId 
                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                AND r.RegionId = pec.RegionId " .$addVCFlagqry. " " .$search." ".$dirsearchall."    ".$dealcond."
                                ORDER BY pec.companyname ";
                            }
                         }
                         elseif($dealvalue==104 || $dealvalue==103){
                             
                             
                              if($vcflagValue==9 || $vcflagValue==12) { $dealcond='AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1'; }
                              else if($vcflagValue==10 || $vcflagValue==11) { $dealcond='AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0'; }
                    
                              
                            if($advisorsearch_trans!="")
                            {
                                 $showallsql="(
                                         SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                                         FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac      ".$dealtype." 
                                         WHERE Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'   ".$dealcond."  and AdvisorType='".$adtype ."'
                                         AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
                                         " )
                                         UNION (
                                         SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS CompCIAId
                                         FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp   ".$dealtype."
                                         WHERE Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adcomp.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'   ".$dealcond."  and AdvisorType='".$adtype ."'
                                         AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
                                         " )	ORDER BY Cianame";
                                //echo "<br> Investor search- ".$showallsql;
                                 $totalallsql=$showallsql;
                                 
                            }
                            else if($advisorsearch_legal!="")
                            {
                                 $showallsql="(
                                         SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                                         FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac   ".$dealtype."
                                         WHERE Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'   ".$dealcond."  and AdvisorType='".$adtype ."'
                                         AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
                                         " )
                                         UNION (
                                         SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS CompCIAId
                                         FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp   ".$dealtype."
                                         WHERE Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adcomp.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'   ".$dealcond."  and AdvisorType='".$adtype ."'
                                         AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
                                         " )	ORDER BY Cianame";
                                //echo "<br> Investor search- ".$showallsql;
                                 $totalallsql=$showallsql;
                                 
                            }
                            elseif($companysearch!="")
                            {
                                $showallsql="(
                                         SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                                         FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac   ".$dealtype."
                                         WHERE Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adac.CIAId = cia.CIAID and c.companyname LIKE '%$companysearch%'   ".$dealcond."  and AdvisorType='".$adtype ."'
                                         AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
                                         " )
                                         UNION (
                                         SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS CompCIAId
                                         FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp    ".$dealtype."
                                         WHERE Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adcomp.CIAId = cia.CIAID and c.companyname LIKE '%$companysearch%'   ".$dealcond."  and AdvisorType='".$adtype ."'
                                         AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
                                         " )	ORDER BY Cianame";
                                
                                    $totalallsql=$showallsql;
                                //echo "<br> Investor search- ".$showallsql;
                            }
                            elseif($keyword!="")
                            {
                                $showallsql="(
                                         SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                                         FROM manda AS peinv, pecompanies AS c,manda_investors AS pe, peinvestors AS inv,
                                         advisor_cias AS cia, peinvestments_advisoracquirer AS adac    ".$dealtype."
                                         WHERE Deleted =0 AND pe.MandAId = peinv.MandAId
                                        AND inv.InvestorId = pe.InvestorId 
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adac.CIAId = cia.CIAID and Investor like '%$keyword%'   ".$dealcond."  and AdvisorType='".$adtype ."'
                                         AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
                                         " )
                                         UNION (
                                         SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS CompCIAId
                                         FROM manda AS peinv, pecompanies AS c,manda_investors AS pe, peinvestors AS inv, 
                                         advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp ".$dealtype."
                                         WHERE Deleted =0 AND pe.MandAId = peinv.MandAId
                                        AND inv.InvestorId = pe.InvestorId 
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adcomp.CIAId = cia.CIAID and Investor like '%$keyword%'   ".$dealcond."  and AdvisorType='".$adtype ."'
                                         AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
                                         " )	ORDER BY Cianame"; 
                                
                                    $totalallsql=$showallsql;
                                 //echo "<br> Investor search- ".$showallsql;
                            }
                            
                            elseif($sectorsearch!="")
                            {
                                    $showallsql="(
                                         SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                                         FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac    ".$dealtype."
                                         WHERE Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adac.CIAId = cia.CIAID and c.sector_business LIKE '%$sectorsearch%'   ".$dealcond."  and AdvisorType='".$adtype ."'
                                         AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
                                         " )
                                         UNION (
                                         SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS CompCIAId
                                         FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp ".$dealtype."
                                         WHERE Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adcomp.CIAId = cia.CIAID and c.sector_business LIKE '%$sectorsearch%'   ".$dealcond."  and AdvisorType='".$adtype ."'
                                         AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
                                         " )	ORDER BY Cianame";
                                    
                                    $totalallsql=$showallsql;
                                //echo "<br> sector search- ".$showallsql;
                            }
                            elseif($searchallfield!="")
                            {
                                $showallsql="(
                                         SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                                         FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac   ".$dealtype."
                                         WHERE Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adac.CIAId = cia.CIAID and ( cia.cianame LIKE '%$searchallfield%' or cia.website LIKE '%$searchallfield%' or cia.address LIKE '%$searchallfield%' or cia.city LIKE '$searchallfield%' or cia.country LIKE '$searchallfield%' or cia.phoneno LIKE '$searchallfield%' or cia.contactperson LIKE '%$searchallfield%' or cia.designation LIKE '%$searchallfield%' or cia.email LIKE '%$searchallfield%' or cia.linkedin LIKE '%$searchallfield%') ".$dealcond."  and AdvisorType='".$adtype ."'
                                         AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
                                         " )
                                         UNION (
                                         SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS CompCIAId
                                         FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp ".$dealtype."
                                         WHERE Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adcomp.CIAId = cia.CIAID and ( cia.cianame LIKE '%$searchallfield%' or cia.website LIKE '%$searchallfield%' or cia.address LIKE '%$searchallfield%' or cia.city LIKE '$searchallfield%' or cia.country LIKE '$searchallfield%' or cia.phoneno LIKE '$searchallfield%' or cia.contactperson LIKE '%$searchallfield%' or cia.designation LIKE '%$searchallfield%' or cia.email LIKE '%$searchallfield%' or cia.linkedin LIKE '%$searchallfield%') ".$dealcond."  and AdvisorType='".$adtype ."'
                                         AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
                                         " )	ORDER BY Cianame";
                                
                                    $totalallsql=$showallsql;
                                //echo "<br> Investor search- ".$showallsql;
                            }
                            else
                            {
                             
                                $companysql= "(SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac    ".$dealtype."    WHERE c.RegionId=re.RegionId and";
                                $companysql2= "SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS AcqCIAId FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp  ".$dealtype."   WHERE c.RegionId=re.RegionId and";

                        	//echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " c.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " peinv.InvestorType = '".$investorType."'";
                                
                                
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " peinv.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " peinv.amount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                               }
                               
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
                              
                             $companysqltot = $companysql ." Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' ".$dirsearchall." 
                                         AND adac.PEId = peinv.MandAId " .$addVCFlagqry.   "$dealcond"  ;
                            $companysqltot2 = $companysql2 ." Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adcomp.CIAId = cia.CIAID and AdvisorType='".$adtype ."' ".$dirsearchall." 
                                         AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.  "$dealcond"  ;
                            
                            $companysql = $companysql ." Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
                                         AND adac.PEId = peinv.MandAId " .$addVCFlagqry.  "$dealcond"  ;
                            $companysql2 = $companysql2 ." Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adcomp.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
                                         AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.  "$dealcond"  ;
                            
                           
                            
                            $showallsql=$companysql.") UNION (".$companysql2.") ";
                            $totalallsql=$companysqltot.") UNION (".$companysqltot2.") ";
       
                            $orderby="order by Cianame"; 
                            $showallsql=$showallsql.$orderby;
                            $totalallsql=$totalallsql.$orderby;
                            
                            //echo $showallsql;
                            
                            }
                             
                         }
                      
                }
               
	$topNav = 'Directory';
        $defpage=$defvalue;
        $stagedef=1;
        $tour='Allow';
        echo "<div style='display:none'>$showallsql</div>";
        //echo 'flag='.$vcflagValue; exit;
	include_once('dirnew_header.php');
?>
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>
<?php if($vcflagValue !=2 && $vcflagValue !=6)
{
    ?>

<td class="left-td-bg" id="tdfilter">
    <div class="acc_main" id="acc_main">
        <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active" id="openRefine">Slide Panel</a></div>    
        <div id="panel" style="display:block; overflow:visible; clear:both;">
<?php include_once('newdirrefine1.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/> 
    </div>	
</div>

</td>
 <?php
}
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
			
                            $totalDisplay="Total";
                            $industryAdded ="";
                            $totalAmount=0.0;
                            $totalInv=0;
                            $compDisplayOboldTag="";
                            $compDisplayEboldTag="";
                   
                            if ($rsinvestortot = mysql_query($totalallsql))
                            {
                                 $investor_cnt = mysql_num_rows($rsinvestortot);
                            }
                            if($investor_cnt > 0 || $dealvalue==110)
                            {
                                         //$searchTitle=" List of Deals";
                            }
                            else
                            {
                                 $searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
                                 $notable=true;
                                 writeSql_for_no_records($companysql,$emailid);
                            }
                            $rsinvestor = mysql_query($showallsql);
                            

		           ?>
<td class="profile-view-left" style="width:100%;">
<div class="result-cnt">
<?php if ($accesserror==1){?>
            <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo GLOBAL_BASE_URL; ?>dd-subscribe.php" target="_blank">Click here</a></b></div>
        <?php
        exit; 
        } 
        ?>  
<div class="result-title"> 
    
                                            
                        	<?php if(!$_POST){
                                    ?>
                                      
                                  <?php  if($vcflagValue==0)
                                   {
                                     ?>    <h2>
                                           <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                           <?php
                                            if($dealvalue==101)
                                          {
                                           ?>
                                               <span class="result-for">for PE Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for PE-backed Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for PE Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for PE Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>  
                                           <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                           </h2>
    
                              <?php }
                                    else if($vcflagValue==1)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                             <?php
                                            if($dealvalue==101)
                                          {
                                           ?>
                                               <span class="result-for">for VC Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for VC Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for VC Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for VC Transaction Advisors</span>
                                      <?php
                                          }
                                          ?> 
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php }
                                else if($vcflagValue==2)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                           
                                        <?php
                                       if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for Angel Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for  Funded Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==110)
                                          {
                                      ?>
                                              <span class="result-for">for  Fundraising Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for Angel Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for Angel Transaction Advisors</span>
                                      <?php
                                          }
                                          ?> 
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==3)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                             <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for Social Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for Social Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for Social Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for Social Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==4)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                              <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for Cleantech Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for Cleantech Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for Cleantech Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for Cleantech Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <!--span class="result-for">for Cleantech Directory</span-->
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==5)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                    <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for Infrastructure Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for Infrastructure Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for Infrastructure Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for Infrastructure Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <!-- <span class="result-for">for Infrastructure Directory</span> -->
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==6)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                    <?php
                                    if($dealvalue==105)
                                     {
                                      ?>
                                               <span class="result-for">for Incubation Incubator</span>
                                      <?php
                                          }
                                          else if($dealvalue==106)
                                          {
                                      ?>
                                              <span class="result-for">for Incubation Incubatee</span>
                                      <?php
                                          }
                                          ?>
                                            <!-- <span class="result-for">for Infrastructure Directory</span> -->
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php }
                               else if($vcflagValue==7)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                             <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for IPO(PE) Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(PE) Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(PE) Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(PE) Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                           <!-- <span class="result-for">for IPO(PE) Directory</span>  -->
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==8)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                               <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for IPO(VC) Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(VC) Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(VC) Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(VC) Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                          <!--  <span class="result-for">for IPO(VC) Directory</span> -->
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==9)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                               <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for PMS Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for PMS Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for PMS Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for PMS Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                           <!-- <span class="result-for">for PMS Directory</span> -->
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==10)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                               <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for M&A(PE) Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(PE) Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(PE) Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(PE) Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                           <!--  <span class="result-for">for M&A(PE) Directory</span>-->
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==11 )
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                               <?php
                                    if($dealvalue==101 && $vcflagValue==11)
                                     {
                                      ?>
                                               <span class="result-for">for M&A(VC) Investors</span>
                                      <?php
                                          }
                                     else if($dealvalue==101 && $vcflagValue==12)
                                     {
                                      ?>
                                               <span class="result-for">for VC PMS Investors</span>
                                      <?php
                                          }    
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(VC) Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(VC) Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(VC) Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                           <!--  <span class="result-for">for M&A(VC) Directory</span>-->
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php }
                              else if($vcflagValue==12)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                             <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for VC PMS Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for VC PMS Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for VC PMS Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for VC PMS Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php }
                              ?>
    
                                    <div class="title-links " id="exportbtn"></div>
                                    
                                    
                               <?php }
                                   else 
                                   {
                                   if($vcflagValue==0)
                                   {
                                       ?>    <h2 id="tour_result_title">
                                           <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <?php
                                            if($dealvalue==101)
                                          {
                                           ?>
                                               <span class="result-for">for PE Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for PE-backed Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for PE Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for PE Transaction Advisors</span>
                                      <?php
                                          }
                                          ?> 
                                           <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                           </h2>
    
                              <?php }
                                    else if($vcflagValue==1)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                             <?php
                                            if($dealvalue==101)
                                          {
                                           ?>
                                               <span class="result-for">for VC Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for VC Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for VC Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for VC Transaction Advisors</span>
                                      <?php
                                          }
                                          ?> 
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php }
                                else if($vcflagValue==2)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <?php
                                       if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for Angel Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for  Funded Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==110)
                                          {
                                      ?>
                                              <span class="result-for">for  Fundraising Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for Angel Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for Angel Transaction Advisors</span>
                                      <?php
                                          }
                                          ?> 
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==3)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for Social Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for Social Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for Social Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for Social Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==4)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for Cleantech Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for Cleantech Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for Cleantech Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for Cleantech Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==5)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for Infrastructure Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for Infrastructure Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for Infrastructure Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for Infrastructure Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php }
                              else if($vcflagValue==6)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                    <?php
                                    if($dealvalue==105)
                                     {
                                      ?>
                                               <span class="result-for">for Incubation Incubator</span>
                                      <?php
                                          }
                                          else if($dealvalue==106)
                                          {
                                      ?>
                                              <span class="result-for">for Incubation Incubatee</span>
                                      <?php
                                          }
                                          ?>
                                            <!-- <span class="result-for">for Infrastructure Directory</span> -->
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php }
                              else if($vcflagValue==7)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                             <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for IPO(PE) Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(PE) Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(PE) Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(PE) Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==8)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for IPO(VC) Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(VC) Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(VC) Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(VC) Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==9)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                             <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for PMS Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for PMS Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for PMS Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for PMS Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==10)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                             <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for M&A(PE) Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(PE) Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(PE) Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(PE) Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==11 || $vcflagValue==12)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                             <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for M&A(VC) Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(VC) Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(VC) Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(VC) Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } ?>
                                    
                             <div class="title-links " id="exportbtn"></div>
                             
                              <?php  
                               
                             //if($dealvalue==101 || $dealvalue==104 || $dealvalue==102){?>
                             
                             <ul class="result-select">
                                <?php
                               if($industry >0 && $industry!=null){ ?>
                                <li title="Industry">
                                    <?php echo $industryvalue; ?><a   onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }   
                                if($stagevaluetext!="" && $stagevaluetext!=null) { ?>
                                <li> 
                                    <?php echo $stagevaluetext ?><a  onclick="resetinput('stage');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  
                                    if($round!="--" && $round!=null){ $drilldownflag=0; ?>
                                    <li> 
                                        <?php echo $round; ?><a  onclick="resetinput('round');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <!-- -->
                                    <?php } 
                                if($investorType !="--" && $investorType!=null){ ?>
                                <li> 
                                    <?php echo $invtypevalue; ?><a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($regionId>0){ ?>
                                <li> 
                                    <?php echo $regionvalue; ?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }   
                                if (($startRangeValue!= "--") && ($endRangeValue != "")){ ?>
                                <li> 
                                    <?php echo "(USM)".$startRangeValue ."-" .$endRangeValueDisplay ?><a  onclick="resetinput('range');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if (trim($sdatevalueCheck1) !=''){ ?>
                                <li> 
                                    <?php echo $sdatevalueCheck1. "-" .$edatevalueCheck2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($keyword!="") { ?>
                                <li> 
                                    <?php echo $keyword;?><a  onclick="resetinput('keywordsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($companysearch!="") { ?>
                                <li> 
                                    <?php echo $companysearch;?><a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($sectorsearch!="") { ?>
                                <li> 
                                    <?php echo $sectorsearch;?><a  onclick="resetinput('sectorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                if($advisorsearch_trans!="") { ?>
                                <li> 
                                    <?php echo $advisorsearch_trans;?><a  onclick="resetinput('advisorsearch_trans');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($advisorsearch_legal!="") { ?>
                                <li> 
                                    <?php echo $advisorsearch_legal;?><a  onclick="resetinput('advisorsearch_trans');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                 if($dirsearch!="") { ?>
                                <li> 
                                    <?php echo $dirsearch;?><a  onclick="resetinput('autocomplete');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
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
                                //print_r($_POST);
                                $cl_count = count($_POST);
                                if($cl_count > 4)
                                {
                                ?>
                                <li class="result-select-close"><a href="pedirview.php?value=<?php echo $vcflagValue; ?>"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
                                <?php
                                }
                                ?>
                             </ul>
                             <?php 
                             
                                } ?>
                                            
                        </div>
            <br><br><br><br><br>
                       <div class="list-tab"><ul>
                        <li class="active"><a class="postlink"  href="pedirview.php?value=<?php echo $_GET['value'];?>"  id="icon-grid-view"><i></i> List  View</a></li>
                         <?php
                            $count=0;
                            if($vcflagValue!=6)
                            {
                                
                                if($dealvalue==101)
                                {
                                    While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                    {
                                            if($count == 0)
                                            {
                                                     $comid = $myrow["InvestorId"];
                                                    $count++;
                                            }
                                    }
                                }
                                else if($dealvalue==102)
                                {
                                    While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                    {
                                            if($count == 0)
                                            {
                                                     $comid = $myrow["PECompanyId"];
                                                    $count++;
                                            }
                                    }
                                }
                                else if($dealvalue==103 || $dealvalue==104)
                                {
                                     While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                    {
                                            if($count == 0)
                                            {
                                                     $comid = $myrow["CIAId"];
                                                    $count++;
                                            }
                                    }
                                }
                            }
                            else
                            {  
                                if($dealvalue==105)
                                {
                                    While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                    {
                                            if($count == 0)
                                            {
                                                    $comid = $myrow["IncubatorId"];
                                                    $count++;
                                            }
                                    }
                                }
                                else if($dealvalue==106){
                                    While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                    {
                                            if($count == 0)
                                            {
                                                    $comid = $myrow["IncubateeId"];
                                                    $count++;
                                            }
                                    }
                                    
                                }
                            }
                            if($vcflagValue!=6)
                            {
                                if($dealvalue==101)
                                {
                                    $href="dirdetails.php?value=".$comid;
                                }
                                else if($dealvalue==102){
                                    
                                    $href="dircomdetails.php?value=".$comid;
                                }
                                else if($dealvalue==103)
                                {
                                    $href="diradvisor.php?value=".$comid;
                                }
                                else if($dealvalue==104)
                                {
                                    $href="diradvisor.php?value=".$comid;
                                }
                        ?>
                        <li><a id="icon-detailed-view" class="postlink" href="<?php echo $href;?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>" ><i></i> Detail  View</a></li> 
                        <?php
                            }
                            else
                            {
                                if($dealvalue==105)
                                {
                                    $href="dirincdetails.php?value=".$comid;
                                }
                                else if($dealvalue==106){
                                    
                                    $href="dircomdetails.php?value=".$comid;
                                }
                               ?>
                        <li><a id="icon-detailed-view" class="postlink" href="<?php echo $href;?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>" ><i></i> Detail  View</a></li> 
                        <?php 
                            }
                            ?>
                        
                        
                        <?php if($dealvalue == 110) { ?>
                         <li style="float:right"><img src="img/angle-list.png" alt="angle-list" style="padding:5px;float:right"></li>
                        <?php } ?>
                        
                           </ul></div>
				<?php  $rowlimit=25;
                                $offset=0;
                                $i=1;
                                $j=1;
                                $newrowflag=1;
                                $newcolumnflag=1;
                                $columncount=1;
                                 $columnlimit=4;?>

       
<div class="directory-cnt">  
    
    <?php if($dealvalue != 110){?>
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
		if($dealvalue==101)	
                {
                        if($vcflagValue==2)
                        {
                            if($searchallfield !=''){
                             $getInvestorSqls="SELECT DISTINCT inv.InvestorId, inv.Investor
                                        FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                        WHERE pe.InvesteeId = pec.PEcompanyId
                                        AND pec.industry !=15
                                        AND peinv.AngelDealId = pe.AngelDealId
                                        AND inv.InvestorId = peinv.InvestorId
                                        AND pe.Deleted=0 " .$addVCFlagqry. " ( MoreInfor LIKE '%$searchallfield%' or inv.investor like '%$searchallfield%' or Description like '%$searchallfield%') $search "
                                     . " order by inv.Investor ";
                            }else{
                             $getInvestorSqls="SELECT DISTINCT inv.InvestorId, inv.Investor
                                        FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                        WHERE pe.InvesteeId = pec.PEcompanyId
                                        AND pec.industry !=15
                                        AND peinv.AngelDealId = pe.AngelDealId
                                        AND inv.InvestorId = peinv.InvestorId
                                        AND pe.Deleted=0 " .$addVCFlagqry. "  $search "
                                     . " order by inv.Investor ";
                        }
                        }
                        else if($vcflagValue==7 || $vcflagValue==8)
                        {
                             /*$getInvestorSqls="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND pec.industry !=15
				AND peinv.IPOId = pe.IPOId
				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";*/
                            $getInvestorSqls = "SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
				WHERE ";

                        	//echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.IPOAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.IPOAmount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " IPODate between '" . $dt1. "' and '" . $dt2 . "'";
                               }
                               
                               if(($wheredates !== "") )
                               {
                                        $getInvestorSqls = $getInvestorSqls . $wheredates ." and ";
                                        $bool=true;
                               }
             
                                if ($whereind != "")
                                {
                                        $getInvestorSqls=$getInvestorSqls . $whereind ." and ";
                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($whereInvType != "") )
                                {
                                        $getInvestorSqls=$getInvestorSqls.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $getInvestorSqls=$getInvestorSqls.$whererange . " and ";
                                        $bool=true;
                                }
                               
                                $getInvestorSqls = $getInvestorSqls. " pe.PECompanyId = pec.PEcompanyId
				AND pec.industry !=15
				AND peinv.IPOId = pe.IPOId
				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
                          
                        }
                        else if($vcflagValue==9 ||$vcflagValue==10 || $vcflagValue==11)
                        {
                              /*$getInvestorSqls="SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";*/
                            $getInvestorSqls = "SELECT DISTINCT inv.InvestorId, inv.Investor
							FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv WHERE ";

                        	//echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.DealAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.DealAmount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                               }
                               
                               if(($wheredates !== "") )
                               {
                                        $getInvestorSqls = $getInvestorSqls . $wheredates ." and ";
                                        $bool=true;
                               }
             
                                if ($whereind != "")
                                {
                                        $getInvestorSqls=$getInvestorSqls . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($whereInvType != "") )
                                {
                                        $getInvestorSqls=$getInvestorSqls.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $getInvestorSqls=$getInvestorSqls.$whererange . " and ";
                                        $bool=true;
                                }
                               
                                $getInvestorSqls = $getInvestorSqls. " pe.PECompanyId = pec.PEcompanyId
							AND pec.industry !=15
							AND peinv.MandAId = pe.MandAId
							AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
                        }
                        elseif($vcflagValue==3 ||$vcflagValue==4 || $vcflagValue==5)
                        {
                            $getInvestorSqls = "select distinct peinv.InvestorId,inv.Investor
                                from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv,
                                peinvestments_dbtypes as pedb where ";

                        	//echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                        //
                                            if($round != "--" && $round !="")
                                            {
                                                $whereRound="pe.round LIKE '".$round."'";
                                            }
                                        //
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                                if ($boolStage==true)
                                {
                                        $stagevalue="";
                                        $stageidvalue="";
                                        foreach($stageval as $stage)
                                        {
                                                //echo "<br>****----" .$stage;
                                                $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                                $stageidvalue=$stageidvalue.",".$stage;
                                        }

                                        $wherestage = $stagevalue ;
                                        $qryDealTypeTitle="Stage  - ";
                                        $strlength=strlen($wherestage);
                                        $strlength=$strlength-3;
                                //echo "<Br>----------------" .$wherestage;
                                $wherestage= substr ($wherestage , 0,$strlength);
                                $wherestage ="(".$wherestage.")";
                                //echo "<br>---" .$stringto;

                                }
                                 //
                                            if($round != "--" && $round !="")
                                            {
                                                $whereRound="pe.round LIKE '".$round."'";
                                            }
                                        //
                                
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.amount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                               }
                               
                               if(($wheredates !== "") )
                               {
                                        $getInvestorSqls = $getInvestorSqls . $wheredates ." and ";
                                        $bool=true;
                               }
             
                                if ($whereind != "")
                                {
                                        $getInvestorSqls=$getInvestorSqls . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               if($whereRound !="")
                                        {
                                            $getInvestorSqls=$getInvestorSqls.$whereRound." and ";
                                        }
                                if (($wherestage != ""))
                                {
                                        $getInvestorSqls=$getInvestorSqls. $wherestage . " and " ;
                                        $bool=true;
                                }
                                if($whereRound !="")
                                        {
                                            $getInvestorSqls=$getInvestorSqls . $whereRound . " and " ;
                                        }  
                                if (($whereInvType != "") )
                                {
                                        $getInvestorSqls=$getInvestorSqls.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $getInvestorSqls=$getInvestorSqls.$whererange . " and ";
                                        $bool=true;
                                }
                               
                                $getInvestorSqls = $getInvestorSqls. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.StageId and pec.industry!=15  and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
                            
                        }
                        else {
                              /*$getInvestorSqls="SELECT DISTINCT inv.InvestorId, inv.Investor,pec.sector_business
				FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, stage AS s
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND s.StageId = pe.StageId
				AND pec.industry !=15
				AND peinv.PEId = pe.PEId
				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " group by inv.Investor ";*/
                            $getInvestorSqls = "select distinct peinv.InvestorId,inv.Investor
                                from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv
                                where ";

                        	//echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                                if ($boolStage==true)
                                {
                                        $stagevalue="";
                                        $stageidvalue="";
                                        foreach($stageval as $stage)
                                        {
                                                //echo "<br>****----" .$stage;
                                                $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                                $stageidvalue=$stageidvalue.",".$stage;
                                        }

                                        $wherestage = $stagevalue ;
                                        $qryDealTypeTitle="Stage  - ";
                                        $strlength=strlen($wherestage);
                                        $strlength=$strlength-3;
                                //echo "<Br>----------------" .$wherestage;
                                $wherestage= substr ($wherestage , 0,$strlength);
                                $wherestage ="(".$wherestage.")";
                                //echo "<br>---" .$stringto;

                                }
                                
                                        //
                                            if($round != "--" && $round !="")
                                            {
                                                $whereRound="pe.round LIKE '".$round."'";
                                            }
                                        //
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.amount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                               }
                                if ($whereind != "")
                                {
                                        $getInvestorSqls=$getInvestorSqls . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($wherestage != ""))
                                {
                                        $getInvestorSqls=$getInvestorSqls. $wherestage . " and " ;
                                        $bool=true;
                                }
                                
                               if($whereRound !="")
                                        {
                                            $getInvestorSqls=$getInvestorSqls.$whereRound." and ";
                                        }
                                if (($whereInvType != "") )
                                {
                                        $getInvestorSqls=$getInvestorSqls.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $getInvestorSqls=$getInvestorSqls.$whererange . " and ";
                                        $bool=true;
                                }
                                if(($wheredates !== "") )
                                {
                                        $getInvestorSqls = $getInvestorSqls . $wheredates ." and ";
                                        $bool=true;
                                }
                               
                                $getInvestorSqls = $getInvestorSqls. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.StageId and pec.industry!=15 and
                                pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
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

                                                    if(($invResults==0) && ($invResults1==0) && ($invResults2==0)){
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
                else if($dealvalue==102)
                {
                     if($vcflagValue==2)
                        {
                            $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                        FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r
                                        WHERE pec.PECompanyId = pe.InvesteeId 
                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                        AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
                                        ORDER BY pec.companyname";
                        }
                        else if($vcflagValue==3 ||$vcflagValue==4 || $vcflagValue==5)
                        {
                            $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
                                            ORDER BY pec.companyname";
                        }
                        else if($vcflagValue==7 || $vcflagValue==8)
                        {
                            $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
				FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
				WHERE pec.PECompanyId = pe.PEcompanyId 
				AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
				AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
				ORDER BY pec.companyname";
                          
                        }
                        else if($vcflagValue==9 ||$vcflagValue==10 || $vcflagValue==11)
                        {
                            $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
			    FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r
			    WHERE pec.PECompanyId = pe.PEcompanyId 
			    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
			    AND r.RegionId = pec.RegionId " .$addVCFlagqry. " 
			    ORDER BY pec.companyname";
                        }
                        else {
                             $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                        FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                        WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                        AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
                                        ORDER BY pec.companyname";
                        }
                  
                        if ($rsinvestors = mysql_query($getcompaniesSql)){
                                $companies_cnts = mysql_num_rows($rsinvestors);
                        }
			
                        if( $companies_cnts >0){
                             mysql_data_seek($rsinvestor ,0);
                               $commacount=0;
                                While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
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
                else if($dealvalue==103)
                {     
                    
                        $adtype="L";
                   
                     
                        if($vcflagValue==9 ||$vcflagValue==10 || $vcflagValue==11)
                        {
                           $advisorsql="(
                                         SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                                         FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac
                                         WHERE Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adac.CIAId = cia.CIAID  and AdvisorType='".$adtype ."' 
                                         AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
                                         " )
                                         UNION (
                                         SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                                         FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp
                                         WHERE Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adcomp.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
                                         AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
                                         " )	ORDER BY Cianame";
                           // echo $advisorsql;
                        }
                        elseif($vcflagValue==3 || $vcflagValue==4 || $vcflagValue==5)
                        {
                            $advisorsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID  and AdvisorType='".$adtype ."' 
				AND adac.PEId = peinv.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' 
				AND adac.PEId = peinv.PEId ) order by Cianame";
                             
                             
                             //echo $advisorsql;
                        }
                        else{
                             $advisorsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s
				WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
				" AND c.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
				AND adac.PEId = pe.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s
				WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
				"  AND c.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
				AND adac.PEId = pe.PEId ) order by Cianame";
                             
                             
                            // echo $advisorsql;
                        }
                        if ($rsinvestors = mysql_query($advisorsql)){
                                $advisor_cnts = mysql_num_rows($rsinvestors);
                        }
			
                        if($advisor_cnts >0){
                             mysql_data_seek($rsinvestor ,0);
                             $commacount=0;
                                While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
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
                else if($dealvalue==104)
                {  
                        $adtype="T";
                    
                     
                        if($vcflagValue==9 ||$vcflagValue==10 || $vcflagValue==11)
                        {
                           $advisorsql="(
                                         SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                                         FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac
                                         WHERE Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adac.CIAId = cia.CIAID  and AdvisorType='".$adtype ."' 
                                         AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
                                         " )
                                         UNION (
                                         SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                                         FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp
                                         WHERE Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adcomp.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
                                         AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
                                         " )	ORDER BY Cianame";
                            //echo $advisorsql;
                        }
                        elseif($vcflagValue==3 || $vcflagValue==4 || $vcflagValue==5)
                        {
                            $advisorsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID  and AdvisorType='".$adtype ."' 
				AND adac.PEId = peinv.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' 
				AND adac.PEId = peinv.PEId ) order by Cianame";
                             
                             
                             //echo $advisorsql;
                        }
                        else{
                             $advisorsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s
				WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
				" AND c.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
				AND adac.PEId = pe.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s
				WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
				"  AND c.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
				AND adac.PEId = pe.PEId ) order by Cianame";
                             
                             
                             //echo $advisorsql;
                        }
                        if ($rsinvestors = mysql_query($advisorsql)){
                                $advisor_cnts = mysql_num_rows($rsinvestors);
                        }
			
                        if($advisor_cnts >0){
                             mysql_data_seek($rsinvestor ,0);
                             $commacount=0;
                                While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
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
                else if($dealvalue==105)
                {
                     if($vcflagValue==6)
                        {
                            if($searchallfield !=''){
                            $getcompaniesSql="SELECT DISTINCT pe.IncubatorId, inc.Incubator
				FROM incubatordeals AS pe,  incubators as inc
                                    WHERE inc.IncubatorId=pe.IncubatorId and pe.Deleted=0 and ( inc.Incubator like '$searchallfield%' or inc.City LIKE '$searchallfield%'
                                            OR inc.AdditionalInfor like '%$searchallfield%' or pe.MoreInfor like '%$searchallfield%')
                                     order by inc.Incubator ";
                                
                            }else{
                                $getcompaniesSql="SELECT DISTINCT pe.IncubatorId, inc.Incubator
                                    FROM incubatordeals AS pe,  incubators as inc
				WHERE inc.IncubatorId=pe.IncubatorId and pe.Deleted=0
				 order by inc.Incubator ";
                            }
                            
                        }
                        if ($rsinvestors = mysql_query($getcompaniesSql)){
                                $companies_cnts = mysql_num_rows($rsinvestors);
                        }
			
                        if( $companies_cnts >0){
                             mysql_data_seek($rsinvestor ,0);
                             $commacount=0;
                                While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                                {
                                        $companyname=trim($myrow["Incubator"]);
                                        $companyname=strtolower($companyname);

                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            if($commacount>0)
                                                echo ",";
                                            $companies = $myrow["Incubator"];
                                            $incubatorId = $myrow["IncubatorId"];
                                            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                            $isselcted = (trim($_POST['keywordsearchmain'])==trim($companies)) ? 'SELECTED' : '';
                                            echo "{value : '".$companies."',id : ".$incubatorId."}" ;
                                            //echo "'".$companies."'";
                                            $commacount++;
                                        }
                                }                          
                    }
                }
                else if($dealvalue==106)
                {
                     if($vcflagValue==6)
                        {
                            if($searchallfield !=''){
                            $getcompaniesSql="SELECT DISTINCT pe.IncubateeId, pec. *
				FROM pecompanies AS pec, incubatordeals AS pe,industry as i
				WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry
                                     and pe.Deleted=0 and pec.industry!=15 and ( pec.companyname like '%$searchallfield%' or pec.city LIKE '$searchallfield%'
                                            OR pec.AdditionalInfor like '%$searchallfield%' or pe.MoreInfor like '%$searchallfield%')
                                    ORDER BY pec.companyname";                                
                            }else{
                                $getcompaniesSql="SELECT DISTINCT pe.IncubateeId, pec. *
                                    FROM pecompanies AS pec, incubatordeals AS pe,industry as i
                                    WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry
				 and pe.Deleted=0 and pec.industry!=15
				ORDER BY pec.companyname";
                        }
                        }
                  
                        if ($rsinvestors = mysql_query($getcompaniesSql)){
                                $companies_cnts = mysql_num_rows($rsinvestors);
                        }
			
                        if( $companies_cnts >0){
                             mysql_data_seek($rsinvestor ,0);
                               $commacount=0;
                                While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                                {
                                        $companyname=trim($myrow["companyname"]);
                                        $companyname=strtolower($companyname);

                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            if($commacount>0)
                                                echo ",";
                                            $companies = $myrow["companyname"];
                                            $incubateeId = $myrow["IncubateeId"];
                                            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                            $isselcted = (trim($_POST['keywordsearchmain'])==trim($companies)) ? 'SELECTED' : '';
                                            echo "{value : '".$companies."',id : ".$incubateeId."}" ;
                                            
                                            //echo "'".$companies."'";
                                             $commacount++;
                                        }
                                }                          
                    }
                }
                
                 else if($dealvalue==110)
                {
                    $angelCoAutosql="SELECT a.*,p.PECompanyId FROM angelco_fundraising_cos a LEFT JOIN  pecompanies p ON p.angelco_compID=a.angel_id   ORDER BY a.company_name";
                            
                     
                     $angelcoQuery = mysql_query($angelCoAutosql);
                                         
                        $totalAngelcount = mysql_num_rows($angelcoQuery);
                        $countComma=0;
                       While($myrow=mysql_fetch_array($angelcoQuery, MYSQL_BOTH))
                       {
                          
                                   if($myrow['PECompanyId']!='' && $myrow['PECompanyId']>0){
                                       $data = "value=".$myrow['PECompanyId']."/$vcflagValue/110"; 
                                   }
                                   elseif($myrow['angel_id']!='' && $myrow['angel_id']>0){
                                       $data = "value=".$myrow['angel_id']."/$vcflagValue/110&angelco_only"; 
                                   }

                            if($countComma > 0){
                                echo ", ";
                            } 
                            $company_name = addslashes($myrow['company_name']);
                           
                         //  $isselcted = (trim($_POST['keywordsearchmain'])==trim($companies)) ? 'SELECTED' : '';
                           echo "{value : '".$company_name."', id:'"."$data"."'}" ;
                           
                           
                           $countComma++;


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
            
            
             if(Directorydemotour==1) {
               
                        if(idval==42){
                         $("#detailpost").attr("href","<?php echo GLOBAL_BASE_URL; ?>/dealsnew/dirdetails.php?value="+idval+"/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>").trigger("click");
                        }
                        else {
                             showErrorDialog(warmsg);
                             $("#detailpost").attr("href","javascript:").trigger("click"); 
                             $("#autocomplete").val(''); 
                        }
            }
            else
                {
          
                    if(<?php echo $dealvalue;?>==101)
                    {
                        $("#detailpost").attr("href","<?php echo GLOBAL_BASE_URL; ?>/dealsnew/dirdetails.php?value="+idval+"/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>").trigger("click");
                    }
                    else if(<?php echo $dealvalue;?>==102)
                    {
                        $("#detailpost").attr("href","<?php echo GLOBAL_BASE_URL; ?>dealsnew/dircomdetails.php?value="+idval+"/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>").trigger("click");
                    }
                    else if(<?php echo $dealvalue;?>==103)
                    {
                        $("#detailpost").attr("href","<?php echo GLOBAL_BASE_URL; ?>dealsnew/diradvisor.php?value="+idval+"/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>").trigger("click");
                    }
                    else if(<?php echo $dealvalue;?>==104)
                    {
                        $("#detailpost").attr("href","<?php echo GLOBAL_BASE_URL; ?>dealsnew/diradvisor.php?value="+idval+"/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>").trigger("click");
                    }
                    else if(<?php echo $dealvalue;?>==105)
                    {
                        $("#detailpost").attr("href","<?php echo GLOBAL_BASE_URL; ?>dealsnew/dirincdetails.php?value="+idval+"/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>").trigger("click");
                    }
                     else if(<?php echo $dealvalue;?>==110)
                    {
                        $("#detailpost").attr("href","<?php echo GLOBAL_BASE_URL; ?>dealsnew/dircomdetails.php?"+idval).trigger("click");
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
    <input type="button" id="searchsub" name="fliter_dir" value="" onclick="this.form.submit();"><br><br>
 
    <?php if($vcflagValue==0 && $dealvalue==101){ ?>
        <div style="float:left;margin-top:30px;"><a href="investorreport.php?flag=<?php echo $vcflagValue; ?>"><h3>Most Active Investors</h3></a></div>
    <?php }else if($vcflagValue==1 && $dealvalue==101){ ?>
        
        <div style="float:left;margin-top:30px;"><a href="investorreport.php?flag=<?php echo $vcflagValue; ?>"><h3>Most Active Investors</h3></a></div>  
    <?php } ?>
    </div>
    <?php } else{ ?>
    <div class="search-area">
        <?php  if(!isset($_POST['angelsearchtype'])){ ?>
        <label style="float: left;" ><input type="radio" name="angelsearchtype" class="angelfilter" value="1" >Company/Location Search</label>
        <label style="float: left; margin-left: 15px;"  ><input type="radio" name="angelsearchtype" class="angelfilter"  value="2" checked="checked">Raising Amount (US $ K)</label>
        <br><br>
        <input type="text" id="company_location"   name="company_location" type="text" placeholder="Company/Location Search"  style="display: none"  > 
        <input type="text" id="raising_amount" value="10" name="raising_amount" type="text" placeholder="Raising Amount From"> 
        <?php } else { ?>
        <label style="float: left;" ><input type="radio" name="angelsearchtype" class="angelfilter" value="1" <?php if($_REQUEST['angelsearchtype']==1){ echo 'checked'; } ?> >Company/Location Search</label>
        <label style="float: left; margin-left: 15px;"  ><input type="radio" name="angelsearchtype" class="angelfilter"  value="2" <?php if($_REQUEST['angelsearchtype']==2){ echo 'checked'; } ?> >Raising Amount (US $ K)</label>
        <br><br>
        <input type="text" id="company_location"   value="<?php  echo $_REQUEST['company_location']; ?>"  name="company_location" type="text" placeholder="Company/Location Search"  <?php if($_REQUEST['angelsearchtype']==2){ echo 'style="display: none"'; } ?>    > 
        <input type="text" id="raising_amount" value="<?php  echo $_REQUEST['raising_amount']; ?>" name="raising_amount" type="text" placeholder="Raising Amount From"  <?php if($_REQUEST['angelsearchtype']==1){ echo 'style="display: none"'; } ?>  >      
       <?php } ?>
        
        <input type="hidden" value="<?php  echo $_GET['s']; ?>" name="ss">
    <input type="button" id="searchsub" name="angelco_filter" value="" onclick="this.form.submit();">
    
    <div style="float:right;"><a href="investorreport"><h4>Most Active Investors</h4></a></div>
    </div>
    <?php } ?>
    
    
<h3 id="showbylist_tour">Show by:</h3>
<div class="show-by-list" >
        <ul><li>
    <a href="pedirview.php?value=<?php echo $_GET['value']?>&s=&sv=<?php echo $dealvalue;?>" class="postlink <?php if($_REQUEST['s']==''){?> active<?php } ?>" >All</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=a&sv=<?php echo $dealvalue;?>" class="postlink <?php if('a'==$_REQUEST['s']){?> active<?php }?>">A</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=b&sv=<?php echo $dealvalue;?>" class="postlink <?php if('b'==$_REQUEST['s']){?> active<?php }?>">B</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=c&sv=<?php echo $dealvalue;?>" class="postlink <?php if('c'==$_REQUEST['s']){?> active<?php }?>">C</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=d&sv=<?php echo $dealvalue;?>" class="postlink <?php if('d'==$_REQUEST['s']){?> active<?php }?>">D</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=e&sv=<?php echo $dealvalue;?>" class="postlink <?php if('e'==$_REQUEST['s']){?> active<?php }?>">E</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=f&sv=<?php echo $dealvalue;?>" class="postlink <?php if('f'==$_REQUEST['s']){?> active<?php }?>">F</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=g&sv=<?php echo $dealvalue;?>" class="postlink <?php if('g'==$_REQUEST['s']){?> active<?php }?>">G</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=h&sv=<?php echo $dealvalue;?>" class="postlink <?php if('h'==$_REQUEST['s']){?> active<?php }?>">H</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=i&sv=<?php echo $dealvalue;?>" class="postlink <?php if('i'==$_REQUEST['s']){?> active<?php }?>">I</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=j&sv=<?php echo $dealvalue;?>" class="postlink <?php if('j'==$_REQUEST['s']){?> active<?php }?>">J</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=k&sv=<?php echo $dealvalue;?>" class="postlink <?php if('k'==$_REQUEST['s']){?> active<?php }?>">K</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=l&sv=<?php echo $dealvalue;?>" class="postlink <?php if('l'==$_REQUEST['s']){?> active<?php }?>">L</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=m&sv=<?php echo $dealvalue;?>" class="postlink <?php if('m'==$_REQUEST['s']){?> active<?php }?>">M</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=n&sv=<?php echo $dealvalue;?>" class="postlink <?php if('n'==$_REQUEST['s']){?> active<?php }?>">N</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=o&sv=<?php echo $dealvalue;?>" class="postlink <?php if('o'==$_REQUEST['s']){?> active<?php }?>">O</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=p&sv=<?php echo $dealvalue;?>" class="postlink <?php if('p'==$_REQUEST['s']){?> active<?php }?>">P</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=q&sv=<?php echo $dealvalue;?>" class="postlink <?php if('q'==$_REQUEST['s']){?> active<?php }?>">Q</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=r&sv=<?php echo $dealvalue;?>" class="postlink <?php if('r'==$_REQUEST['s']){?> active<?php }?>">R</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=s&sv=<?php echo $dealvalue;?>" class="postlink <?php if('s'==$_REQUEST['s']){?> active<?php }?>">S</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=t&sv=<?php echo $dealvalue;?>" class="postlink <?php if('t'==$_REQUEST['s']){?> active<?php }?>">T</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=u&sv=<?php echo $dealvalue;?>" class="postlink <?php if('u'==$_REQUEST['s']){?> active<?php }?>">U</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=v&sv=<?php echo $dealvalue;?>" class="postlink <?php if('v'==$_REQUEST['s']){?> active<?php }?>">V</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=w&sv=<?php echo $dealvalue;?>" class="postlink <?php if('w'==$_REQUEST['s']){?> active<?php }?>">W</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=x&sv=<?php echo $dealvalue;?>" class="postlink <?php if('x'==$_REQUEST['s']){?> active<?php }?>">X</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=y&sv=<?php echo $dealvalue;?>" class="postlink <?php if('y'==$_REQUEST['s']){?> active<?php }?>">Y</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=z&sv=<?php echo $dealvalue;?>" class="postlink <?php if('z'==$_REQUEST['s']){?> active<?php }?>">Z</a></li>
</ul></div>  
	
                        <?php
                        if($notable==false)
                        { 
                        ?>
			<div class="list-view-table">
                            
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTables">
                              <thead><tr>
                                      <?php
                                      if($vcflagValue == 0)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of PE Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of PE Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of PE Advisors</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 1)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of VC Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of VC Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of VC Advisors</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 2)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Angel Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of  Funded Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==110)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of  Fundraising Companies</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 3)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Social Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Social Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Social Advisors</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 4)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of CleanTech Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of CleanTech Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of CleanTech Advisors</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 5)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Infrastructure Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Infrastructure Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Infrastructure Advisors</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 6)
                                      {
                                          if($dealvalue==105)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Incubator</th>
                                      <?php
                                          }
                                          else if($dealvalue==106)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Incubatee</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 7)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of IPO(PE) Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of IPO(PE) Companies</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 8)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of IPO(VC) Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of IPO(VC) Companies</th>
                                      <?php
                                          }
                                          
                                      }
                                      else if($vcflagValue == 9)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Public Market Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Public Market Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Public Market Advisors</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 10)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of M&A(PE) Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of M&A(PE) Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of M&A(PE) Advisors</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 11)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of M&A(VC) Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of M&A(VC) Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of M&A(VC) Advisors</th>
                                      <?php
                                          }
                                      }
                                      ?>
                              </tr></thead>
                              <tbody id="movies">
                                <?php
                                        //Code to add PREV /NEXT
                                        $icount = 0;
                                        if ($_SESSION['investeeId']) 
                                            unset($_SESSION['investeeId']);
                                        if ($_SESSION['resultCompanyId']) 
                                            unset($_SESSION['resultCompanyId']); 
                                        if ($_SESSION['resultCompanyId']) 
                                            unset($_SESSION['resultCompanyId']);
                                        if ($_SESSION['IncubatorId'])
                                             unset($_SESSION['IncubatorId']);
                                        if ($_SESSION['advisorId'])
                                             unset($_SESSION['advisorId']);
                                        
                                        mysql_data_seek($rsinvestor ,0);
                                        $count=mysql_num_rows($rsinvestor);
                                if($dealvalue==101)
                                {
                                    While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                    {
                                            $Investorname=trim($myrow["Investor"]);
                                            $Investorname=strtolower($Investorname);

                                            $invResult=substr_count($Investorname,$searchString);
                                            $invResult1=substr_count($Investorname,$searchString1);
                                           $invResult2=substr_count($Investorname,$searchString2);
                                           if($newrowflag==1)
                                               echo "<tr><td  width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";

                                            if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                            {
                                             $_SESSION['investeeId'][$icount++] = $myrow["InvestorId"];
                                           //  $_SESSION['resultCompanyId'][$icount++] = $myrow["InvestorId"];
                                            if($dealvalue==6)
                                             {
                            ?><tr>
                                <td ><a class="postlink" href="dirinvdetails.php?value=<?php echo $myrow["InvestorId"];?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>"><?php echo $myrow["Investor"];?> </a></td></tr>
                            <?php
                                            $totalCount=$totalCount+1;
                                            }
                                            else
                                            {
                                            ?><tr>
                                <td ><a class="postlink" href="dirdetails.php?value=<?php echo $myrow["InvestorId"];?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>"><?php echo $myrow["Investor"];?> </a></td></tr>
                            <?php    
                                            } 
                                            }
                                            
                                            $newrowflag=0;
                                            if($i==$rowlimit)
                                            {  
                                               $i=1;
                                               echo "</table></td>";
                                               if($count>$i && $columncount<$columnlimit)
                                               {

                                                   echo "<td width=".(100/4)."%><table cellspacing='0' cellpadding='0' border='0'>";                                                           
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
                                       
                                       
                                                if($columncount >= 4){
                                                 echo "</table></td></tr>";
                                                }
                                     
                                                
                                                
                                                
                                    }  
                                     else if($dealvalue==102)
                                     {
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
                                       <td ><a class="postlink" href="dircomdetails.php?value=<?php echo $myrow["PECompanyId"];?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?> "><?php echo $myrow["companyname"];?> </a></td></tr>
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

                                                       echo "<td width=".(100/4)."%><table cellspacing='0' cellpadding='0' border='0'>";                                                           
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
                                     else if($dealvalue==110)
                                     {
                                         $angelcoQuery = mysql_query($angelCosql);
                                         
                                         $totalAngelcount = mysql_num_rows($angelcoQuery);
                                         $Angelcount=0;
                                        While($myrow=mysql_fetch_array($angelcoQuery, MYSQL_BOTH))
                                        {
                                                $icount++;
                                                $Angelcount++;
                                                
                                               if($icount==1){
                                                   echo "<tr><td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";
                                               }
                                                    $_SESSION['resultCompanyId'][$icount] = $myrow["angel_id"];
                                                    
                                                    
                                                    
                                                    if($myrow['PECompanyId']!='' && $myrow['PECompanyId']>0){
                                                        $data = "value=".$myrow['PECompanyId']."/$vcflagValue/110"; 
                                                    }
                                                    elseif($myrow['angel_id']!='' && $myrow['angel_id']>0){
                                                        $data = "value=".$myrow['angel_id']."/$vcflagValue/110&angelco_only"; 
                                                    }
                                                    
                                                    
                                                    if($Angelcount==1){
                                                        $detailurl = "dircomdetails.php?".$data;
                                                    }
                                                    
                                                    
                                                    if($myrow['angel_id']>0 )
                                                {
                                                   
                                   ?><tr>
                                    <td ><a class="postlink" href="dircomdetails.php?<?php echo $data;?> "><?php echo $myrow["company_name"];?> </a></td></tr>
                                   <?php
                                                   $totalCount=$totalCount+1;
                                                  
                                                }
                                                
                                                if (($icount % 25) == 0)
                                                    { 
                                                     echo "</table></td> <td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";
                                                    }
                                                
                                                    if(($icount % 100) == 0 ){
                                                         echo "</table></td>";
                                                         $icount=0;
                                                       
                                                        
                                                       // break;
                                                    }
                                                    if( $totalCount==$totalAngelcount){
                                                        
                                                         echo "</table></td></tr></td></tr>";   
                                                    }
                                                   
						/*
                                                $newrowflag=0;
                                                if($i==$rowlimit)
                                                {  
                                                   $i=1;
                                                   echo "</table></td>";
                                                   if($count>$i && $columncount<$columnlimit)
                                                   {

                                                       echo "<td width=".(100/4)."%><table cellspacing='0' cellpadding='0' border='0'>";                                                           
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
                                                else { 
                                                    $i++;
                                                }
                                                        $j++;
                                                 * 
                                                 */
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
                                                echo "<tr><td width=".(100/4)."%><table cellspacing='0' cellpadding='0' border='0'>";
                                                
                                                if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                                {
                                                        $_SESSION['advisorId'][$icount++] = $myrow["CIAId"];
                                                        $querystrvalue= $myrow["CIAId"];
                                         ?>
                                                        <tr><td>
                                                        <a style="text-decoration: none" href='diradvisor.php?value=<?php echo $querystrvalue;?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>' >
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
                                     else if($dealvalue==105)
                                     {
                                        While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                        {
                                                $adviosrname=trim($myrow["Incubator"]);
                                                $adviosrname=strtolower($adviosrname);

                                                $invResult=substr_count($adviosrname,$searchString);
                                                $invResult1=substr_count($adviosrname,$searchString1);
                                                $invResult2=substr_count($adviosrname,$searchString2);
                                                if($newrowflag==1)
                                                echo "<tr><td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";
                                                
                                                if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                                {
                                                        $_SESSION['IncubatorId'][$icount++] = $myrow["IncubatorId"];
                                         ?>
                                                        <tr><td>
                                                        <a style="text-decoration: none" href='dirincdetails.php?value=<?php echo $myrow["IncubatorId"];?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>' >
                                                        <?php echo $myrow["Incubator"]; ?></a></td></tr>
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
                                     else if($dealvalue==106)
                                     {
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
                                       <td ><a class="postlink" href="dircomdetails.php?value=<?php echo $myrow["PECompanyId"];?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?> "><?php echo $myrow["companyname"];?> </a></td></tr>
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
        </div>
	    	
             
             
		
    </div>
<?php
					}
                                        else
                                        {
                                            echo "NO DATA FOUND";
                                        }
				 
			?>
    
    

   

            <?php  if($notable==false)  {  ?> 
             <div style="padding: 0 1%; margin-top: 20px">
             <div class="holder"></div>
             <?php
                    if(($exportToExcel==1))
                    {
                    ?>
                                    <span style="float:right" class="one">
                                    <input class="export exlexport" id="expshowdeals" type="button"  value="Export" name="showprofile">
                                    </span>
                                     <script type="text/javascript">
                            $('#exportbtn').html('<input class ="export" type="button" id="expshowdeals"  value="Export" name="showprofile">');
                     </script>
                    <?php
                    } ?>
             </div>                
           <?php 
           }
           ?>
    
    
</td>




</tr>
</table>
    

  
                     
</div>
</form>
    <?php if($dealvalue==101)
    {
      
    if($keyword!="" || $companysearch!="" || $sectorsearch!="" || $advisorsearch_legal!="" || $advisorsearch_trans!="" || $industry!="" || ($startRangeValue!="--" && $endRangeValue!="--") || $investorType!="" ||  ($dt1!="" && $dt2!="") || $stageidvalue!="" || (($round != "--") && ($round != ""))){
        
            if($vcflagValue!=2){ ?>
                <form name="pegetdata" id="pegetdata"  method="post" action="exportinvestorprofile.php" >
                <input type="hidden" name="hiddenSearchKey" value="<?php echo $_GET['s']; ?>" >
           <?php  }else{  ?>
                <form name="pegetdata" id="pegetdata"  method="post" action="angelallinvestorexport.php">
                <input type="hidden" name="hiddenexportall" value="1" >
           <?php  } ?>
             
            <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >
            <input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
            <input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?>>
            <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
            <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
            <input type="hidden" name="txthideindustryid" value="<?php echo $industry;?>" >
            <input type="hidden" name="txthidekeyword" value="<?php echo $keyword;?>" >
            <input type="hidden" name="txthidecompany" value="<?php echo $companysearch;?>" >
            <input type="hidden" name="txthidesector" value="<?php echo $sectorsearch;?>" >
            <input type="hidden" name="txthideadvisorlegal" value="<?php echo $advisorsearch_legal;?>" >
            <input type="hidden" name="txthideadvisortrans" value="<?php echo $advisorsearch_trans;?>" >
            <input type="hidden" name="txthidestageid" value="<?php echo $stageidvalue;?>" >
                        <input type="hidden" name="txthideround" value="<?php echo $round; ?>">
            <input type="hidden" name="txthiderange" value="<?php echo $startRangeValue;?>" >
            <input type="hidden" name="txthiderangeEnd" value="<?php echo $endRangeValue;?>" >
            <input type="hidden" name="txthideinvestorTypeid" value="<?php echo $investorType;?>" >
            <input type="hidden" name="hidepeipomandapage" value="<?php echo $vcflagValue;?>" >
            <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>">
       <?php
       }
       else{
           if($vcflagValue!=2){ ?>
                <form name="pegetdata" id="pegetdata"  method="post" action="exportinvestorprofile.php" >
                <input type="hidden" name="hiddenSearchKey" value="<?php echo $_GET['s']; ?>" >
           <?php  }else{  ?>
                <form name="pegetdata" id="pegetdata"  method="post" action="angelallinvestorexport.php">
                <input type="hidden" name="hiddenexportall" value="1" >
           <?php  } ?>
            <input type="hidden" name="hideShowAll" value="ShowAll" >
            <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >
            <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
            <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
            <input type="hidden" name="hidepeipomandapage" value="<?php echo $vcflagValue;?>" >
            <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" >
            
      <?php 
       }
    }
       else if($dealvalue==102)
       {
           if($keyword!="" || $companysearch!="" || $sectorsearch!="" || $advisorsearch_legal!="" || $advisorsearch_trans!="" || $industry!="" || ($startRangeValue!="--" && $endRangeValue!="--") || $investorType!="" ||  ($dt1!="" && $dt2!="") || $stageidvalue!=""){
        ?>
                <form name="pegetdata" id="pegetdata"  method="post" action="exportcompaniesprofile.php">
                <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >
                <input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
                <input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?>>
                <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
                <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
                <input type="hidden" name="txthideindustryid" value="<?php echo $industry;?>" >
                <input type="hidden" name="txthidekeyword" value="<?php echo $keyword;?>" >
                <input type="hidden" name="txthidecompany" value="<?php echo $companysearch;?>" >
                <input type="hidden" name="txthidesector" value="<?php echo $sectorsearch;?>" >
                <input type="hidden" name="txthideadvisorlegal" value="<?php echo $advisorsearch_legal;?>" >
                <input type="hidden" name="txthideadvisortrans" value="<?php echo $advisorsearch_trans;?>" >
                <input type="hidden" name="txthidestageid" value="<?php echo $stageidvalue;?>" >
                        <input type="hidden" name="txthideround" value="<?php echo $round; ?>">
                <input type="hidden" name="txthiderange" value="<?php echo $startRangeValue;?>" >
                <input type="hidden" name="txthiderangeEnd" value="<?php echo $endRangeValue;?>" >
                <input type="hidden" name="txthideinvestorTypeid" value="<?php echo $investorType;?>" >
                <input type="hidden" name="hidepeipomandapage" value="<?php echo $vcflagValue;?>" >
                <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>">
                <input type="hidden" name="hideadvisortype" value="<?php echo $adtype;?>" >
   <?php
       }
       else{
          ?>
            <form name="pegetdata" id="pegetdata"  method="post" action="exportcompaniesprofile.php" >
            <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> > 
            <input type="hidden" name="hidepeipomandapage" value="<?php echo $vcflagValue;?>" >
            <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" >
            <input type="hidden" name="hideShowAll" value="ShowAll" >
            <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
    <?php
        }
    }
    else if($dealvalue==104 || $dealvalue==103)
    { 
        if($keyword!="" || $companysearch!="" || $sectorsearch!="" || $advisorsearch_legal!="" || $advisorsearch_trans!=""  || $industry!="" || ($startRangeValue!="--" && $endRangeValue!="--") || $investorType!="" ||  ($dt1!="" && $dt2!="") || $stageidvalue!=""){
        ?>

            <form name="pegetdata" id="pegetdata"  method="post" action="exportadvisortrans.php" >
            <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >
            <input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
            <input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?>>
            <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
            <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
            <input type="hidden" name="txthideindustryid" value="<?php echo $industry;?>" >
            <input type="hidden" name="txthidekeyword" value="<?php echo $keyword;?>" >
            <input type="hidden" name="txthidecompany" value="<?php echo $companysearch;?>" >
            <input type="hidden" name="txthidesector" value="<?php echo $sectorsearch;?>" >
            <input type="hidden" name="txthideadvisor" value="<?php echo $advisorsearch_trans;?>" >
            <input type="hidden" name="txthideadvisorlegal" value="<?php echo $advisorsearch_legal;?>" >
            <input type="hidden" name="txthidestageid" value="<?php echo $stageidvalue;?>" >
                        <input type="hidden" name="txthideround" value="<?php echo $round; ?>">
            <input type="hidden" name="txthiderange" value="<?php echo $startRangeValue;?>" >
            <input type="hidden" name="txthiderangeEnd" value="<?php echo $endRangeValue;?>" >
            <input type="hidden" name="txthideinvestorTypeid" value="<?php echo $investorType;?>" >
            <input type="hidden" name="hidepeipomandapage" value="<?php echo $vcflagValue;?>" >
            <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>">
            <input type="hidden" name="hideadvisortype" value="<?php echo $adtype;?>" >
       <?php
       }
       else{
          ?>
            <form name="pegetdata" id="pegetdata"  method="post" action="exportadvisortrans.php" >
            <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >     
            <!--input type="hidden" name="hidepeipomandapage" value="<?php echo $dealvalue;?>" -->
            <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" >
            <input type="hidden" name="hideadvisortype" value="<?php echo $adtype;?>" >
            <input type="hidden" name="hideShowAll" value="ShowAll" >
            <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
    <?php
        }
        
    }
    else if($dealvalue==105 || $dealvalue==106)
    {?>
            <form name="pegetdata" id="pegetdata"  method="post" action="exportincubation.php" >
            <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> > 
            <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" >
            <input type="hidden" name="hideShowAll" value="ShowAll" >
            <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
   <?php }
    ?>
            <input type="hidden" name="searchallfield" value="<?php echo $searchallfield;?>" >
            </form>

       <script type="text/javascript">
           
           
           
           
                $("a.postlink").click(function(){
                 
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval); 
                    $("#pesearch").submit();
                    
                    return false;
                    
                });
                /*$('#expshowdeals,.exlexport').click(function(){ 
                    hrefval= 'exportinvestorprofile.php';
                    $("#pegetdata").submit();
                    return false;
		});*/
           
            
                $('#expshowdeals,.exlexport').click(function(){ 
                    jQuery('#preloading').fadeIn();   
                    initExport();
                    return false;
                });

          /*      $('#expshowdealsbtn').click(function(){ 
                    jQuery('#preloading').fadeIn();   
                    initExport();
                    return false;
                });*/

                function initExport(){ 
                    
                        url = ($("#pegetdata").attr('action')=='exportinvestorprofile.php') ? 'exportinvestorprofilecnt.php' : '';
                        if (url=='')
                            url = ($("#pegetdata").attr('action')=='angelallinvestorexport.php') ? 'exportinvestorprofilecnt.php' : '';
                        if (url=='')
                            url = ($("#pegetdata").attr('action')=='exportcompaniesprofile.php') ? 'exportcompaniesprofilecnt.php' : '';
                        if (url=='')
                            url = ($("#pegetdata").attr('action')=='exportadvisorsprofile.php') ? 'exportadvisorsprofilecnt.php' : '';
                        if (url=='')
                            url = ($("#pegetdata").attr('action')=='exportadvisortrans.php') ? 'exportadvisortranscnt.php' : '';
                        if (url=='')
                            url = ($("#pegetdata").attr('action')=='exportincubation.php') ? 'exportincubationcnt.php' : '';
                        $.ajax({
                            url: url ,
                            data: $("#pegetdata").serialize(),
                            type: 'POST',
                            success: function(data){
                                var currentRec = data;
                                
                                 if (currentRec > 0){
                                    $.ajax({
                                        url: 'ajxCheckDownload.php',
                                        dataType: 'json',
                                        success: function(data){
                                            var downloaded = data['recDownloaded'];
                                            var exportLimit = data.exportLimit;
                                            var remLimit = exportLimit-downloaded;
                                
                                            if (currentRec < remLimit){
                                                //hrefval= 'exportinvestorprofile.php';
                                                //$("#pegetdata").attr("action", hrefval);
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
                                }else{
                                    jQuery('#preloading').fadeOut();
                                    alert("There was some problem exporting...");
                                }
                            },
                            error: function(){
                                jQuery('#preloading').fadeOut();
                                alert("There was some problem exporting...");
                            }
                        });
                    }
                
                
                function resetinput(fieldname)
                {
                 
                //alert($('[name="'+fieldname+'"]').val());
                  $("#resetfield").val(fieldname);
                  //alert( $("#resetfield").val(fieldname));
                  $("#pesearch").submit();
                    return false;
                }
                
                 
                 
                 
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
                
            </script>
<div id="dialog-confirm" title="Guided tour Alert" style="display: none;">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span id="alertSpan"></span></p>
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




<?php if($angelCosql) { ?>
<script type="text/javascript"> 
$(document).ready(function(){
    $("#exportbtn, #expshowdeals").hide();
    $("#icon-detailed-view").attr('href','<?php echo $detailurl?>');
    
    
   
          $('.angelfilter').on('ifChecked', function(event){
              // alert('sdfdsds');
              
              $("#company_location, #raising_amount").val('');
              
              val = $('input[name=angelsearchtype]:checked').val();
              if(val==1){
                  $("#company_location").show();
                  $("#raising_amount").hide();
              }
               else if(val==2){
                  $("#raising_amount").show();
                  $("#company_location").hide();
              }
           });
           
    
    
    });
</script>
<?php } ?>







<script src="hopscotch.js"></script>
<?php if(isset($_SESSION['currenttour'])) { echo ' <script src="'.$_SESSION['currenttour'].'.js?24feb"></script> '; } ?>

<script type="text/javascript"> 
$(document).ready(function(){

   <?php if(isset($_SESSION["DirectorydemoTour"]) && $_SESSION["DirectorydemoTour"]=='1') { ?>
        Directorydemotour=1;

         <?php if($_GET["value"]=='10'  && ($dealvalue=='103')  ){?>
               hopscotch.startTour(tour, 13);                            
         <?php }
         else if($_GET["value"]=='10' ){?>
               hopscotch.startTour(tour, 12);                            
         <?php } 
         else if($_GET["value"]=='0' && ($_POST["industry"]=='14')  ){?>
               hopscotch.startTour(tour, 9);                            
         <?php } 
         else if($_GET["value"]=='0'){?>
                 
               hopscotch.startTour(tour, 6);
                $(".hopscotch-bubble").hide();
                 
                        $('body,html').animate({  scrollTop: $(document).height()   }, 6000);
                           
                            setTimeout(function() {                              
                                if(Directorydemotour==1){ $('body,html').animate({scrollTop:0}, 6000);}                                  
                            },4000); 
                            
                            setTimeout(function() {
                                if(Directorydemotour==1)
                                {
                                    hopscotch.startTour(tour, 6); 
                                    var tourshake =  setInterval(function(){  
                                       if(hopscotch.getCurrStepNum()==6) { $(".tourboxshake").effect( "shake",{times:1}, 2000 ); }
                                   },5000); 
                                             
                                }                                   
                            },8000);                                            
         <?php }         
         else { ?>
                     
                hopscotch.startTour(tour,0); 
            <?php } ?>  


  <?php } ?>
      
      
        $('.ui-multiselect').attr('id','uimultiselect');    

           $("#uimultiselect, #uimultiselect span").click(function() {
                if(Directorydemotour==1)
                        {  showErrorDialog(warmsg); $('.ui-multiselect-menu').hide(); }     
            });
            
            
            
            


   });
</script>
<?php
mysql_close();
    mysql_close($cnx);
    ?>