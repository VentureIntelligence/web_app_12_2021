<?php include_once("../globalconfig.php"); ?>
<?php
    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
    $tagandor=$_POST['tagandor'];
    $tagradio=$_POST['tagradio'];
     $invandor=$_POST['invandor'];
  $invradio=$_POST['invradio'];
    $yearafter=trim($_POST['yearafter']);
    $yearbefore=trim($_POST['yearbefore']);
    $investor_head=$_POST['invhead'];
    $companyauto_sug=$_POST['companyauto_sug'];

        include('checklogin.php');
        $mailurl= curPageURL();
        
        $searchString="Undisclosed";
    $searchStringDisplay="Undisclosed";
    $searchString=strtolower($searchString);

    $searchString1="Unknown";
    $searchString1=strtolower($searchString1);

    $searchString2="Others";
    $searchString2=strtolower($searchString2);

    $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';

    //$SelCompRef=$value;
        $strvalue = explode("/", $value);
        $SelCompRef=$strvalue[0];
        $flagvalue=$strvalue[1];
        $searchstring=$strvalue[2];
        if($_POST['filtersector'] != ''){
            $filtersector = $_POST['filtersector'];
        } else {
            $filtersector = '';
        }
        
        if($_POST['filtersubsector'] != ''){
            $filtersubsector = $_POST['filtersubsector'];
        } else {
            $filtersubsector = '';
        }
        
        if($_POST['filtersector'] != ''){
            $sectorsql = "select sector_id,sector_name from pe_sectors where sector_id IN ($filtersector) order by sector_name ";
        }
        if($_POST['filtersubsector'] != ''){
            $subsectorsql = "select DISTINCT(subsector_name) from pe_subsectors where subsector_id IN ($filtersubsector) AND subsector_name != '' order by subsector_name";
        }
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
        
    if( isset( $_POST[ 'pe_checkbox_disbale' ] ) ) {
        $pe_checkbox = $_POST[ 'pe_checkbox_disbale' ];
    } else {
        $pe_checkbox = '';
    }

    if( isset( $_POST[ 'pe_checkbox_amount' ] ) ) {
        $pe_amount = $_POST[ 'pe_checkbox_amount' ];
    } else {
        $pe_amount = '';
    }
       
   //==================================junaid================================================
    if( isset( $_POST[ 'pe_checkbox_company' ] ) ) {
        $pe_company = $_POST[ 'pe_checkbox_company' ];
    } else {
            $pe_company = 0;
    }    
        
        
        if( isset( $_POST[ 'hide_company_array' ] ) ) {
            $hideCompanyFlag = $_POST[ 'hide_company_array' ];
        } else {
            $hideCompanyFlag = '';
        }
        if( !empty( $companyauto_sug ) ) {

    
            $sql_company_new = "select  PECompanyId as id,companyname as name from pecompanies where PECompanyId IN($companyauto_sug)";
            $sql_company_Exe=mysql_query($sql_company_new);
            $company_filter="";
            $i = 0;
            While( $myrow_new = mysql_fetch_array($sql_company_Exe,MYSQL_BOTH)){
                $response_new[$i]['id']= $myrow_new['id'];
                $response_new[$i]['name']= $myrow_new['name'];
                if($i!=0){
                    $company_filter.=",";
                }
                $company_filter.=$myrow_new['name'];
                $i++;

            }
            if( $response_new != '' ) {
                $companysug_response= json_encode($response_new);
            } else{
                $companysug_response= 'null';
            }
        }
        //echo $company_filter;
               
//==================================================================================     
    $sql="SELECT pe.PECompanyId, pe.price_to_book, pe.book_value_per_share, pe.price_per_share, pec.companyname, pec.industry, i.industry, pec.sector_business,
                 DealAmount, DATE_FORMAT( DealDate, '%M-%Y' ) as dt, pec.website,
                 pe.MandAId,pe.Comment,MoreInfor,type,hideamount,hidemoreinfor,
                pe.DealTypeId,dt.DealType,pe.InvestmentDeals,pe.Link,pe.EstimatedIRR,pe.MoreInfoReturns,it.InvestorTypeName,
                pec.uploadfilename,pe.source,pe.Valuation,pe.FinLink,pe.Company_Valuation,pe.Revenue_Multiple,pe.EBITDA_Multiple,pe.PAT_Multiple,pe.ExitStatus,pe.Revenue,pe.EBITDA,pe.PAT,pe.stakeSold
                         FROM manda AS pe, industry AS i, pecompanies AS pec,
                         dealtypes as dt,investortype as it
                         WHERE  i.industryid=pec.industry
                         AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.MandAId=$SelCompRef
                         and dt.DealTypeId=pe.DealTypeId and it.InvestorType=pe.InvestorType";
    //echo "<br>".$sql;

        $AcquirerSql= "select peinv.MandAId,peinv.AcquirerId,ac.Acquirer from manda as peinv,acquirers as ac
        where peinv.MandAId=$SelCompRef and ac.AcquirerId=peinv.AcquirerId";

        $investorSql="select peinv.MandAId,peinv.InvestorId,inv.Investor,peinv.MultipleReturn,InvMoreInfo,IRR from manda_investors as peinv,
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
                $VCFlagValueStringdet = explode("/", $VCFlagValueString);
                if($VCFlagValueStringdet[1] == "0-0" || $VCFlagValueStringdet[1] == "0-1"){
                    $vcflagValue = 0;
                } else {
                    $vcflagValue = 1;
                }
                //$vcflagValue=$VCFlagValue_exit[0];
                $hide_pms=trim($VCFlagValue_exit[1],'/');
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
                // }

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
             $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n', strtotime(date('Y-m')." -2     month"));
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

                if($resetfield=="searchallfield")
                { 
                 $_POST['searchallfield']="";
                 $searchallfield="";
                }
                else 
                {
                 $searchallfield=trim($_POST['searchallfield']);
                 if($searchallfield != "")
                        {
                            $_POST['investorsearch'] = "";  $_REQUEST['investorauto']="";
                            $_POST['acquirersearch'] = "";  $_REQUEST['acquirerauto']=""; 
                            $_POST['companysearch'] = "";   $_REQUEST['companyauto']="";
                            $_POST['sectorsearch'] = "";    $_REQUEST['sectorauto']="";
                            $_POST['advisorsearch_legal'] = "";
                            $_POST['advisorsearch_trans'] = "";
                        }
                }
                $searchallfieldhidden = preg_replace('/\s+/', '_', trim($searchallfield));
                  if($resetfield=="yearfounded")
        { 
            $_POST['yearafter']="";
            $_POST['yearbefore']="";
            $yearafter="";
            $yearbefore="";
           
        }
        else 
        {
            $yearafter=trim($_POST['yearafter']);
            $yearbefore=trim($_POST['yearbefore']);
            if($yearafter != NULL && $yearafter !='' && $yearbefore != NULL && $yearbefore !=''){
                $searchallfield='';
            }

        }
                if($resetfield=="acquirersearch")
                { 
                $_POST['acquirersearch']="";
                $acquirersearch="";
                 $acquirerauto='';
                
                }
                else 
                {
                $acquirersearch=trim($_POST['acquirersearch']);
                       
                         $acquirerauto=$_REQUEST['acquirerauto'];
                }


                if($resetfield=="tagsearch") {
                        $arrayval=explode(",",$_POST['tagsearch']);
                        $pos = array_search($_POST['resetfieldid'], $arrayval);
                        $tagsearch = $arrayval;
                        unset($tagsearch[$pos]);
                        $tagsearch = implode(",",$tagsearch);
                        if($tagsearch == ""){
                        $tagandor = 0;
                        }else{
                             $tagsearcharray = explode(',', $tagsearch);
                        $response = array();
                        $tag_filter = "";
                        $i = 0;

                        foreach ($tagsearcharray as $tagsearchnames) {
                            $response[$i]['name'] = $tagsearchnames;
                            $response[$i]['id'] = $tagsearchnames;
                            $i++;
                        }

                        if ($response != '') {
                            $tag_response = json_encode($response);
                        } else {
                            $tag_response = 'null';
                        }
                        }
                   /* $_POST['tagsearch']="";
                    $_POST['tagsearch_auto'] = "";
                    $tagsearch = "";
                    $tagkeyword = "";*/
                    
                } else if($_POST['tagsearch']  && $_POST['tagsearch'] !='') {
                    
                    
                    $tagsearch = $_POST['tagsearch'];
                    $tagkeyword = $_POST['tagsearch'];
                    $tagsearcharray = explode(',',$tagsearch);
                    $response =array(); 
                    $tag_filter="";
                    $i = 0;

                    foreach ($tagsearcharray as $tagsearchnames){ 
                        $response[$i]['name']= $tagsearchnames;
                        $i++;
                    } 

                    if($response != '')
                    {
                        $tag_response = json_encode($response);
                    }
                    else{
                        $tag_response = 'null';
                    }
                }

                if($resetfield=="companysearch")
                { 
                     $arrayval=explode(",",$_POST['companyauto_sug']);
                    $pos = array_search($_POST['resetfieldid'], $arrayval);
                    $companysearch = $arrayval;
                    unset($companysearch[$pos]);
                    $companysearch=implode(",",$companysearch);
                    $_POST['companysearch'] = $companysearch;
                   
                 /*$_POST['companysearch']="";
                 $companysearch="";
                  $companyauto='';*/
                   $sql_company = "select  PECompanyId as id,companyname as name from pecompanies where PECompanyId IN($companysearch)";
                    $sql_company_Exe=mysql_query($sql_company);
                    $company_filter="";
                    $response =array();
                    $i = 0;
                    While($myrow = mysql_fetch_array($sql_company_Exe,MYSQL_BOTH)){

                        $response[$i]['id']= $myrow['id'];
                        $response[$i]['name']= $myrow['name'];
                        if($i!=0){

                            $company_filter.=",";
                            $company_id .=",";
                        }
                            $company_filter.=$myrow['name'];
                            $company_id .= $myrow['id'];
                        $i++;
                    }

                    if($response != '')
                    {
                        $companysug_response= json_encode($response);
                    }
                    else{
                        $companysug_response= 'null';
                    }

                    if($companysearch!=''){
                        
                        $searchallfield='';
                    }
                             /*$_POST['companysearch']="";
                 $companysearch="";
                 $companyauto='';*/
                }
                else 
                {
                 $companysearch=trim($_POST['companysearch']);
                 $companyauto=$_POST['companyauto'];
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
                 // $_POST['investorsearch']="";
                 // $investorsearch="";
                 //  $investorauto='';

                    $investorarray = explode(',', $_POST['investorauto_sug']);
                    $pos = array_search($_POST['resetfieldid'], $investorarray);
                    $keyword = $investorarray;
                    unset($keyword[$pos]);
                    $keyword = implode(',', $keyword);
                    $_POST['investorauto_sug']=$keyword;
                    $investorsearch=$keyword;
                    $investorauto=$keyword;

                    $sql_investorauto_sug = "select  InvestorId as id,Investor as name from peinvestors where InvestorId IN($investorsearch) order by InvestorId";

                    $sql_investorauto_sug_Exe=mysql_query($sql_investorauto_sug);
                    // print_r($getInvestorSql_Exe);
                    $response =array(); 
                    $invester_filter="";
                    $i = 0;
                    While($myrow = mysql_fetch_array($sql_investorauto_sug_Exe,MYSQL_BOTH)){

                        $response[$i]['id']= $myrow['id'];
                        $response[$i]['name']= $myrow['name'];
                        if($i!=0){

                            $invester_filter.=",";
                            $invester_filter_id .= ",";
                        }
                        $invester_filter.=$myrow['name'];
                        $invester_filter_id .= $myrow['id'];
                        $i++;

                     }

                    $investorsug_response= json_encode($response);

                }
                else 
                {
                 $investorsearch=trim($_POST['investorsearch']);
                  $investorauto=$_POST['investorauto'];
                }
                
                 if($resetfield=="sectorsearch") 
                { 
                    $_POST['sectorsearch']="";
                    $sectorsearch="";
                }
                else 
                {
                    $sectorsearch=stripslashes(trim($_POST['sectorsearch']));
                    if($sectorsearch!=''){
                        $searchallfield='';
                }
                }
                $sectorsearchhidden=ereg_replace(" ","_",$sectorsearch);
                
                if($resetfield=="investorsearch")
                {
                    $_POST['investorauto_sug']="";
                    $investorsearch="";
                    $investorauto='';
                }
                else 
                {
                    $investorsearch=trim($_POST['investorauto_sug']);
                    $investorsearchhidden=trim($_POST['investorauto_sug']);
                    if($investorsearch!=''){
                        $searchallfield='';
                }
                    $investorauto = $_POST['investorauto_sug'];

                    $sql_investorauto_sug = "select  InvestorId as id,Investor as name from peinvestors where InvestorId IN($investorsearch) order by InvestorId";
                
                    $sql_investorauto_sug_Exe=mysql_query($sql_investorauto_sug);
                    // print_r($getInvestorSql_Exe);
                    $response =array(); 
                    $invester_filter="";
                    $i = 0;
                    While($myrow = mysql_fetch_array($sql_investorauto_sug_Exe,MYSQL_BOTH)){

                       $response[$i]['id']= $myrow['id'];
                       $response[$i]['name']= $myrow['name'];
                       if($i!=0){

                           $invester_filter.=",";
                           $invester_filter_id .= ",";
                       }
                          $invester_filter.=$myrow['name'];
                          $invester_filter_id .= $myrow['id'];
                      $i++;

                     }

                    $investorsug_response= json_encode($response);
                
                }
//                if($investorsearch!=="")
//                {
//                    $splitStringInvestor=explode(" ", trim($investorsearch));
//                    $splitString1Investor=$splitStringInvestor[0];
//                    $splitString2Investor=$splitStringInvestor[1];
//                    $stringToHideInvestor=$splitString1Investor. "+" .$splitString2Investor;
//                }

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
                 // $_POST['industry']="";
                 // $industry="";
                    $pos = array_search($_POST['resetfieldid'], $_POST['industry']);
        $industry = $_POST['industry'];
        unset($industry[$pos]);
                }
                else 
                {
            $industry=$_POST['industry'];
            $filtersector = $_POST['filtersector'];
        $filtersubsector = $_POST['filtersubsector'];
        $sector=$_POST['sector'];
        $subsector=$_POST['subsector'];
            if($industry!='--' && count($industry) >0){
                        $searchallfield='';
                }
                }
                if ($resetfield == "sector") {
                    $pos = array_search($_POST['resetfieldid'], $_POST['sector']);
                    $sector = $_POST['sector'];
                    unset($sector[$pos]);
                    //$_POST['sector'] = "";
                    $_POST['subsector'] = "";
                    $_POST['filtersubsector'] = "";
                    $filtersubsector = '';
                } else {
                    $sector = $_POST['sector'];
                    if ($sector != '--' && count($sector) > 0) {
                        $searchallfield = '';
                    }
                }
                 if ($resetfield == "subsector") {
                     $pos = array_search($_POST['resetfieldid'], $_POST['subsector']);
                 $subsector = $_POST['subsector'];
                 unset($subsector[$pos]);
                   // $_POST['subsector'] = "";
                } else {
                    $subsector = $_POST['subsector'];
                    if ($subsector != '--' && count($subsector) > 0) {
                        $searchallfield = '';
                    }
                }           
   
    
                
                 if($resetfield=="dealtype")
                { 
                    $pos = array_search($_POST['resetfieldid'], $_POST['dealtype']);
                    $dealtype = $_POST['dealtype'];
                    unset($dealtype[$pos]);
                 /*$_POST['dealtype']="";
                 $dealtype="--";*/
                }
                else 
                {
                 $dealtype=$_POST['dealtype'];
                 if($dealtype!='--' && $dealtype!=''){
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
                $month1=($_POST['month1']) ?  $_POST['month1'] : date('n', strtotime(date('Y-m'))); ;
                $year1 = ($_POST['year1']) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
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
        {   $datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
            $datevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
                        $fixstart=$year1;
                        $fixend=$year2;
                        $startyear=$year1."-".$month1."-01";
                        $endyear=$year2."-".$month2."-01";
                        $dt1 = $year1."-".$month1."-01";
                        $dt2 = $year2."-".$month2."-01";
                        $wheredates1= "";
        }
               
                if($industry !='' && (count($industry) > 0))
                {
                    $indusSql = $industryvalue = '';
                    foreach($industry as $industrys)
                    {
                        $indusSql .= " IndustryId=$industrys or ";
                    }
                    $indusSql = trim($indusSql,' or ');
                    $industrysql= "select industry,industryid from industry where $indusSql";

                    if ($industryrs = mysql_query($industrysql))
                    {
                            While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                            {
                                $industryvalue.=$myrow["industry"].',';
                                $industryvalueid .= $myrow["industryid"] . ',';
                            }
                    }
                    $industryvalue=  trim($industryvalue,',');
                    $industryvalueid = trim($industryvalueid, ',');
                    $industry_hide = implode($industry,',');
                }
                 if ($sector != '' && (count($sector) > 0)) {
                        $sectorvalue = '';
                        $sectorstr = implode(',',$sector); 
                        $sectorssql = "select sector_name from pe_sectors where sector_id IN ($sectorstr)";
                       
                        if ($sectors = mysql_query($sectorssql)) {
                            while ($myrow = mysql_fetch_array($sectors, MYSQL_BOTH)) {
                                $sectorvalue .= $myrow["sector_name"] . ',';
                            }
                        }
                       
                        $sectorvalue = trim($sectorvalue, ',');
                        // $industry_hide = implode($industry, ',');
                    }
                    
                    if ($subsector != '' && (count($subsector) > 0)) {
                        $subsectorvalue = '';
                        $subsectorvalue = implode(',',$subsector); 
                    }
                if(count($dealtype) >0){
                    $dealSql = $dealtypevalue = '';
                    foreach($dealtype as $dealtypes)
                    {
                        $dealSql .= " DealTypeId=$dealtypes or ";
                    }
                    $dealSql = trim($dealSql,' or ');
                    $dealtypesql= "select DealType from dealtypes where $dealSql";
                }
                elseif(($dealtype=="--") && ($hide_pms==1)){
                    $dealtypesql= "select DealType from dealtypes where hide_for_exit=".$hide_pms;
                }
                //echo "<Br>***** ".$dealtypesql;
                    if ($dealtypers = mysql_query($dealtypesql))
                    {
                            While($myrow=mysql_fetch_array($dealtypers, MYSQL_BOTH))
                            {
                                $dealtypevalue.=$myrow["DealType"].',';
                            }
                        $dealtypevalue=  trim($dealtypevalue,',');
                        $dealtype_hide = implode($dealtype,',');
                    }

                    //echo "<bR>%%%%%%".$dealtypevalue;
                if($investorType !="--" && $investorType !="")
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
                if ($investor_head != "--") {
                    $invheadSql = "select country from country where countryid='$investor_head'";
                    if ($invrs = mysql_query($invheadSql)) {
                        while ($myrow = mysql_fetch_array($invrs, MYSQL_BOTH)) {
                            $invheadvalue = $myrow["country"];
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
                                        // $month1=($_POST['month1']) ?  $_POST['month1'] : date('n', strtotime(date('Y-m')." -2     month")); ;
                                        // $year1 = ($_POST['year1']) ?  $_POST['year1'] : date('Y');
                                        // $month2=($_POST['month2']) ?  $_POST['month2'] : date('n');
                                        // $year2 = ($_POST['year2']) ?  $_POST['year2'] : date('Y');

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
                                    //  echo "<br>Query for company search";
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
                                    //  echo "<br>Query for company search";
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

?>

<?php
    
        $tour='Allow';
    
        if($strvalue[3]=='Directory'){
            
            $dealvalue=$strvalue[2];
            $topNav = 'Directory'; 
            include_once('dirnew_header.php');
        }else{
            $topNav = 'Deals'; 
            include_once('mandadeal_header.php');
        }
?>

<div class="mandadealdetails" id="container" >
<table cellpadding="0" cellspacing="0" width="100%" style="margin-top:-10px;">
<tr>

 <td class="left-td-bg">
      <div class="acc_main" style="margin-top:10px;">
          <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div> 
<div id="panel" style="display:block; overflow:visible; clear:both;">
<?php include_once('mandarefine.php');?>
 <input type="hidden" name="resetfield" value="" id="resetfield"/>
 <input type="hidden" name="resetfieldid" value="" id="resetfieldid"/>
 
 <input type="hidden" name="tourlistview" value="" id="tourlistview"/>
<!--<input type="hidden" name="pe_checkbox" id="pe_checkbox" value="<?php echo $pe_checkbox; ?>" />-->
  <input type="hidden" name="pe_amount" id="pe_amount" value="<?php echo $pe_amount; ?>" />
<input type="hidden" name="pe_hide_companies" id="pe_hide_companies" value="<?php echo $hideCompanyFlag; ?>" />
<?php if($_POST['all_checkbox_search']==1){ ?>
    <input type="hidden" name="pe_company" id="pe_company" value="" />
    
<?php }else{ ?>
    
    <input type="hidden" name="pe_company" id="pe_company" value="<?php if($pe_company!=''){ echo $pe_company; }else{ echo ""; } ?>" />
<?php } ?>
<input type="hidden" name="hide_pe_company" id="hide_pe_company" value="<?php if($pe_company!=''){ echo $pe_company; }else{ echo ""; } ?>" />
<input type="hidden" name="uncheckRows" id="uncheckRows" value="<?php echo $_POST['pe_checkbox_disbale']; ?>" /> 
<input type="hidden" name="full_uncheck_flag" id="full_uncheck_flag" value="<?php echo $_POST['all_checkbox_search']; ?>" />

<?php if($_POST['real_total_inv_deal']!=''){ ?>
    <input type="hidden" name="real_total_inv_deal" id="real_total_inv_deal" value="<?php echo $_POST['real_total_inv_deal']; ?>" />
<?php }
if($_POST['real_total_inv_amount']!='') { ?>
    <input type="hidden" name="real_total_inv_amount" id="real_total_inv_amount" value="<?php echo $_POST['real_total_inv_amount']; ?>" />
<?php } 
if($_POST['real_total_inv_company']!='') { ?>
    <input type="hidden" name="real_total_inv_company" id="real_total_inv_company" value="<?php echo $_POST['real_total_inv_company']; ?>" />
<?php }

/*if($_POST['all_checkbox_search']==1){ */?>
    
<input type="hidden" name="total_inv_deal" id="total_inv_deal" value="<?php echo $_POST['total_inv_deal']; ?>">
<input type="hidden" name="total_inv_amount" id="total_inv_amount" value="<?php echo $_POST['total_inv_amount']; ?>">
<input type="hidden" name="total_inv_company" id="total_inv_company" value="<?php echo $_POST['total_inv_company']; ?>">

<?php //} 

if($_POST['pe_checkbox_enable']!=''){ ?>
    <input type="hidden" name="pe_checkbox_enable" id="pe_checkbox_enable" value="<?php echo $_POST['pe_checkbox_enable']; ?>">
<?php }
?>
</div>
      </div>
</td>

     <?php
     //GET PREV NEXT ID
    $prevNextArr = array();
    $prevNextArr = $_SESSION['resultId'];
        $coscount = $_SESSION['coscount'];
    
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
        
                ////////////
                if($myrow["price_to_book"]<=0)
                        $price_to_book=0.00;
                else
                        $price_to_book=$myrow["price_to_book"];
        /////////////               
                
                
               /* if($myrow["Revenue"]<=0)
                    $dec_revenue=0.00;
                else*/
                    $dec_revenue=$myrow["Revenue"];

               /* if($myrow["EBITDA"]<=0)
                    $dec_ebitda=0.00;
                else*/
                    $dec_ebitda=$myrow["EBITDA"];
                /*if($myrow["PAT"]<=0)
                    $dec_pat=0.00;
                else*/
                    $dec_pat=$myrow["PAT"];
        ///////////         
                if($myrow["book_value_per_share"]<=0)
                        $book_value_per_share=0.00;
                else
                        $book_value_per_share=$myrow["book_value_per_share"];


                if($myrow["price_per_share"]<=0)
                        $price_per_share=0.00;
                else
                        $price_per_share=$myrow["price_per_share"];
                ///////////////                        
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
<div class="result-title" style="padding: 35px 0px 5px 0px;">

                <?php
                if ($companylistrs = mysql_query($companysql))
                     {
                        $company_cnt = mysql_num_rows($companylistrs);
                     }
                if(!$_POST)
                    { ?>
                        <h2>
                                  <span class="result-no"><?php echo count($prevNextArr); ?> Results Found (across <?php echo $coscount; ?> cos) </span>  
                     <?php 
                    if($flagvalue=="0-1")
                       {
                       ?>   <span class="result-for">  for Exit Via Public Market Sales</span>  
                       <?php }
                       elseif($flagvalue=="0-0") {
                           ?>
                            <span class="result-for">  for PE Exits - M&A</span> 
                       <?php } 
                      elseif ($flagvalue=="1-0") { ?>
                            <span class="result-for">  for  VC Exits - M&A</span> 
                      <?php }
                      ?> </h2>
                              
                    <div class="title-links">
                                
                        <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                        <?php 

                        if(($exportToExcel==1))
                             {
                             ?>
                                 <input type="button"  id="export-btn" class="export_new exlexport" value="Export" name="showmandadeal">
                             <?php
                             }
                         ?>
                    </div>
                        <ul class="result-select">  <?php  if($datevalueDisplay1!="" && $datevalueDisplay1!=NULL ) {?>
                      
                      <li><?php  echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li>
                                 <?php  } ?> </ul>    
                  <?php 
                  }
                   else 
                   { ?>
                       <h2>
                       <span class="result-no"><?php echo count($prevNextArr); ?> Results Found (across <?php echo $coscount; ?> cos) </span>                    
                       <?php  if($flagvalue=="0-1")
                       {
                       ?>
                              <span class="result-for">  for Exit Via Public Market Sales</span>  
                       <?php }
                       elseif($flagvalue=="0-0") {
                           ?>
                              <span class="result-for">  for PE Exits - M&A</span>  
                       <?php } 
                         elseif ($flagvalue=="1-0") { ?>
                              <span class="result-for">  for  VC Exits - M&A</span>  
                         <?php }
               ?>
                       </h2>
                <div class="title-links">
                                
                        <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                        <?php 

                        if(($exportToExcel==1))
                             {
                             ?>
                                  <input type="button"  id="export-btn" class="export_new exlexport" value="Export" name="showmandadeal">
                             <?php
                             }
                         ?>
                </div>
                <ul class="result-select">
                <?php
                if($industry >0 && $industry!=null){ ?>
                <!-- <li title="Industry">
                                    <?php echo $industryvalue; ?><a   onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li> -->
                                <?php $industryarray = explode(",",$industryvalue); 
                                    $industryidarray = explode(",",$industryvalueid); 
                                    foreach ($industryarray as $key=>$value){  ?>
                                      <li>
                                          <?php echo $value; ?><a  onclick="resetmultipleinput('industry',<?php echo $industryidarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                    <?php } ?>

                                <?php } 
                              if ($sector > 0 && $sector != null) {$drilldownflag = 0;?>
              <?php
               $sectorarray = explode(",",$sectorvalue); 
                               $sectoridarray = explode(",",$sectorvalueid); 
                                    foreach ($sectorarray as $key=>$value){  ?>
                                      <li>
                                         <?php echo $value; ?><a  onclick="resetmultipleinput('sector',<?php echo $sectoridarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
             </li>
                                    <?php } ?>
                                <?php }
                                
                                if ($subsector > 0 && $subsector != null) { $drilldownflag = 0;?>
                                 <!--  <li>
                                      <?php echo $subsectorvalue; ?><a  onclick="resetinput('subsector');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                  </li> -->
                                   <?php
               //$subsectorarray = explode(",",$subsector); 
                              // $stageidarray = explode(",",$stagevalueid); 
                                    foreach ($subsector as $key=>$value){  ?>
                                      <li>
                                         <?php echo $value; ?><a  onclick="resetmultipleinput('subsector','<?php echo $subsector[$key]; ?>');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
             </li>
                                    <?php } ?>
                                  <?php }

                                     if (($yearafter!= "" || $yearbefore != "")){$drilldownflag=0; ?>
                                      <li> 
                                         <?php echo $yearafter ."-" .$yearbefore ?><a  onclick="resetinput('yearfounded');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                    <?php }  
                                    
                                if($dealtype!="--" && $dealtypevalue !=''){ ?>
                                <!-- <li title="Dealtype">
                                    <?php echo $dealtypevalue; ?><a  onclick="resetinput('dealtype');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li> -->
                                  <?php
                                 $dealarray = explode(",",$dealtypevalue); 
                               $dealidarray = explode(",",$dealtype_hide); 
                                    foreach ($dealarray as $key=>$value){  ?>
                                      <li>
                                         <?php echo $value; ?><a  onclick="resetmultipleinput('dealtype',<?php echo $dealidarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
             </li>
                                    <?php } ?>
                              <?php } 
                               
                                if($investorType !="--" && $investorType!=null){ ?>
                                <li title="Investor type"> 
                                    <?php echo $invtypevalue; ?><a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                 if ($investor_head != "--" && $investor_head != null) {$drilldownflag = 0;?>
                                  <li>
                                      <?php echo $invheadvalue; ?><a  onclick="resetinput('invhead');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                  </li>
                                  <?php }
                                 if($exitstatusdisplay1!="") { ?>
                                <li title="Exit Display "> 
                                    <?php echo $exitstatusdisplay1;?><a  onclick="resetinput('exitstatus');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  
                                if(trim($advisorsearchstring_legal)!="") { ?>
                                <li title="Legal Advisor"> 
                                    <?php echo $advisorsearchstring_legal?><a  onclick="resetinput('advisorsearch_legal');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if(trim($advisorsearchstring_trans)!=""){ ?>
                                <li title="Transatactional Advisor"> 
                                    <?php echo $advisorsearchstring_trans?><a  onclick="resetinput('advisorsearch_trans');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } if($datevalueDisplay1!=""){ ?>
                                <li title="Period"> 
                                    <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } if(($txtfrm>=0) && ($txtto>0)) { ?>
                                <li title="Return Multiple"> 
                                    <?php echo $txtfrm. "-" .$txtto?><a  onclick="resetinput('returnmultiple');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } if(trim($companysearch)!=""){ ?>
                               <!--  <li title="Company Search"> 
                                    <?php echo $company_filter;?><a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li> -->
                                 <?php $companyarray = explode(",",$company_filter); 

                                $companyidarray = explode(",",$company_id); 
                                    foreach ($companyarray as $key=>$value){  ?>
                                      <li>
                                          <?php echo $value; ?><a  onclick="resetmultipleinput('companysearch',<?php echo $companyidarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                    <?php } ?> 
                                <?php } if(trim($investorsearch)!="" && $invester_filter !=''){ ?>
                               <!--  <li title="Investor" > 
                                    <?php echo $invester_filter;?><a  onclick="resetinput('investorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li> -->
                                 <?php 
                                    $investerarray = explode(",",$invester_filter); 
                                    $investeridarray = explode(",",$invester_filter_id); 
                                    foreach ($investerarray as $key=>$value){  ?>
                                      <li>
                                          <?php echo $value; ?><a  onclick="resetmultipleinput('investorsearch',<?php echo $investeridarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                    <?php } ?>
                                <?php } 
                                if($sectorsearch!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo  stripslashes(str_replace("'","",trim($sectorsearch)));?><a  onclick="resetinput('sectorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }   if($acquirersearch!=" " && $acquirersearch!=""){$drilldownflag=0; ?>
                                <li  > 
                                    <?php echo $acquirerauto;?><a  onclick="resetinput('acquirersearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } if($searchallfield!=""){ ?>
                                <li title="Others"> 
                                <?php echo $searchallfield ; ?><a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } if($tagsearch!=""){ ?>
                                <!-- <li title="tagsearch"> 
                                <?php echo "tag:".$tagsearch ; ?><a  onclick="resetinput('tagsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li> -->
                                 <?php $tagarray = explode(",",$tagsearch); 

                                 foreach ($tagarray as $key=>$value){  ?>
                                  <li>
                                      <?php echo "tag:".$value; ?><a  onclick="resetmultipleinput('tagsearch','<?php echo $tagarray[$key]; ?>');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                  </li>
                                <?php } ?>
                                <?php } ?>
             </ul>        
             <?php } ?>             
        </div>
        <div class="list-tab mt-list-tab"><ul>
            <li><a class="postlink" href="mandaindex.php?value=<?php echo $flagvalue;?>"  id="icon-grid-view"><i></i> List  View</a></li>
            <li class="active"><a id="icon-detailed-view" class="postlink" href="mandadealdetails.php?value=<?php echo $SelCompRef;?>/<?php echo $flagvalue;?>/<?php echo $searchstring;?>" ><i></i> Detail  View</a></li> 
            </ul>
        </div> 
        
        <div class="lb" id="popup-box">
            <div class="title">Send this to your Colleague</div>
            <form>
                <div class="entry">
                        <label> To*</label>
                        <input type="text" name="toaddress" id="toaddress"  />
                </div>
                <div class="entry">
                        <h5>Subject*</h5>
                        <p>Checkout this deal - <?php echo rtrim($myrow["companyname"]);?> - in Venture Intelligence</p>
                        <input type="hidden" name="subject" id="subject" value="Checkout this deal - <?php echo rtrim($myrow["companyname"]);?> - in Venture Intelligence"  />
                        <input type="hidden" name="basesubject" id="basesubject" value="Deal" />
                </div>
                <div class="entry">
                        <h5>Link</h5>
                        <p><?php  echo curPageURL(); ?>   <input type="hidden" name="message" id="message" value="<?php  echo curPageURL(); ?>" />   <input type="hidden" name="useremail" id="useremail" value="<?php echo $_SESSION['UserEmail']; ?>"  /> </p>
                </div>
                <div class="entry">
                    <h5>Your Message</h5><span style='float:right;'>Words left: <span id="word_left">200</span></span>
                    <textarea name="ymessage" id="ymessage" style="width: 374px; height: 57px;" placeholder="Enter your text here..." val=''></textarea>
                </div>
                <div class="entry">
                    <input type="button" value="Submit" id="mailbtn" />
                    <input type="button" value="Cancel" id="cancelbtn" />
                </div>

            </form>
        </div>
        <div class="view-detailed">
            <div class="detailed-title-links"><h2> <A class="" target="_blank" href='companydetails.php?value=<?php echo $myrow["PECompanyId"];?>/<?php echo $flagvalue;?>/<?php echo $searchstring;?>' ><?php echo rtrim($myrow["companyname"]);?></a></h2>
                <?php if ($prevKey!='-1') {?> <a  class="postlink" id="previous" href="mandadealdetails.php?value=<?php echo $prevNextArr[$prevKey]; ?>/<?php echo $flagvalue;?>/">< Previous</a><?php } ?> 
                <?php if ($nextKey < count($prevNextArr)) { ?><a class="postlink" id="next" href="mandadealdetails.php?value=<?php echo $prevNextArr[$nextKey]; ?>/<?php echo $flagvalue;?>/"> Next > </a>  <?php } ?>
            </div> 

        <div class="profilemain" id="profilemain">
             <h2>Deal Info  </h2>
             <div class="profiletable">
                  <ul>
                    <?php if($hideamount!="") { ?><li><h4>Deal Size (US $M)</h4><p><?php echo $hideamount;?></p></li><?php } ?>
                    <?php if($myrow["stakeSold"]!="" && $myrow["stakeSold"] > 0) { ?><li><h4>Stake Sold</h4><p><?php echo $myrow["stakeSold"];?> %</p></li><?php } ?>
                    <?php if($myrow["DealType"]!="") { ?><li><h4>Deal Type </h4><p><?php echo $myrow["DealType"];?></p></li><?php } ?>
                    <?php if($myrow["DealTypeId"]==4) { 
                        if($myrow["type"] == 1){ $type_val = "IPO"; } else if($myrow["type"] == 2){ $type_val = "Open Market Transaction"; }else if($myrow["type"] == 3){ $type_val = "Reverse Merger";}else{ $type_val = "Open Market Transaction"; }
                        ?><li><h4>Type </h4><p><?php echo$type_val;?></p></li><?php } ?>
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
                    <p><A class="" target="_blank" href='companydetails.php?value=<?php echo $myrow["PECompanyId"];?>/<?php echo $flagvalue;?>/<?php echo $searchstring;?>' ><?php echo rtrim($myrow["companyname"]);?></a>
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
                <td><h4>Exiting Investors</h4><p style="word-break: break-all;">
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
                                         if($myInvrow["MultipleReturn"]>0 || $myInvrow["IRR"]>0)
                                          {  $bool_returnFlag=1;}
                                          $invReturnString[]=$myInvrow["Investor"].",".$myInvrow["MultipleReturn"].",".$myInvrow["IRR"];
                                          $invMoreInfoString[]=$myInvrow["InvMoreInfo"];
                ?>

                    <a class="" target="_blank" href='dirdetails.php?value=<?php echo $myInvrow["InvestorId"].'/'.$VCFlagValue.'/';?>' ><?php echo $myInvrow["Investor"]; ?></a><br />
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
                <td><h4>Type</h4><p><?php echo $myrow["InvestorTypeName"] ;?></p></td>
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

                    <A class="postlink" href='advisor.php?value=<?php echo $myadcomprow["CIAId"];?>/2/<?php echo $flagvalue?>' >
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

                    <A class="postlink" href='advisor.php?value=<?php echo $myadinvrow["CIAId"];?>/2/<?php echo $flagvalue?>' >
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
              <tr><td ><h4 id="moredetails">More Details</h4><p><?php print nl2br($hidemoreinfor);?></p></td></tr> <?php } ?>
        
            </tbody>
            </table>
        </div>
        <?php 
      /* $company_link_Sql =mysql_query("select * from pecompanies_links where PECompanyId='".$myrow['PECompanyId']."'"); 
        if($myrow["uploadfilename"]!="" || mysql_num_rows($company_link_Sql)>0 )
        {   
        ?>
        
        <div  class="work-masonry-thumb  col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>FINANCIALS INFO</h2>
        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
        <tbody>
<!--             <?php

              //  if($finlink!="")
              //  {
                ?>
                    <tr><td ><h4>Link for Financials
                            </h4><p style="word-break: break-all;"><a target="_blank" href=<?php //echo $finlink; ?> ><?php //echo $finlink; ?></a></p></td></tr>

                <?php
              //  } 
                ?>-->
                
                
<?php                 
if($myrow["uploadfilename"]!="")
{
        ?>
                <?php
                if($exportToExcel==1)
                 {
                 ?>
                <tr>
                    <td class="txtBold"><a href="<?php echo $file;?>" target="_blank" > Download Excel File </a></td>
                </tr>
                <tr>
                    <td class="txtBold"><a href="<?php echo GLOBAL_BASE_URL; ?>cfsnew/comparers.php" target="_blank">View in CFS Database</a></td>
                </tr>
                 <?php
                 }
                else
                 {
                 ?>
                <tr>
                             <td>&nbsp;Paid Subscribers can view a link to the co. financials here </td> </tr>
                 <?php
                  }
                 ?>
               
        <?php
} 
        ?>
        
        
        
        <!-- pecompany links -->
         <?php if(mysql_num_rows($company_link_Sql)>0){ ?>
        <tr> <td><h4> Links & Comments </h4></td><td>
  
         <?php while($com_links_com = mysql_fetch_array($company_link_Sql)) { ?>
         <p style="font-weight: normal;margin:2px  0 8px;line-height: 20px;"><a href='<?php echo $com_links_com['Link']?> ' target="_blank" style="font-weight: bold;"> <?php echo $com_links_com['Link']?>  </a> <br> <?php echo $com_links_com['Comment']?>  </p> 
        <?php } ?>
         </td></tr>
        <?php } ?>
        <!-- end pecompany links -->
        
     </tbody>
        </table> 
        </div>   
        <?php
        }*/
      ?>
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
                    <tr><td colspan="3" ><h4>&nbsp;Company Valuation - Equity - Post Money (INR Cr) </h4><p><?php echo $dec_company_valuation ;?></p></td></tr>
                         <?php
                        }
                        if( $dec_revenue_multiple >0 || $dec_ebitda_multiple >0 || $dec_pat_multiple>0) {  ?>
                            <tr>
                          <?php  if($dec_revenue_multiple >0)
                        {
                        ?>
                                <td style='width:30%' ><h4>&nbsp;Revenue Multiple (based on Equity Value / Market Cap) </h4><p><?php echo $dec_revenue_multiple ;?></p></td>
                         <?php
                            }else{
                                echo "<td style='width:30%'></td>";
                        }

                        if($dec_ebitda_multiple >0)
                        {
                        ?>
                            <td style='width:30%'><h4>&nbsp;EBITDA Multiple (based on Equity Value) </h4><p><?php echo $dec_ebitda_multiple ;?></p></td>
                         <?php
                            }else{
                                echo "<td style='width:30%'></td>";
                        }

                        if($dec_pat_multiple >0)
                        {
                        ?>
                            <td style='width:30%'><h4>PAT Multiple (based on Equity Value) </h4><p><?php echo $dec_pat_multiple ;?></p></td>
                         <?php
                            }else{
                                echo "<td style='width:30%'></td>";
                        } ?>
                        </tr>
                        <?php
                        }?>
                        
                        
                        <!-- New Feature 08 - 08 - 2016 start -->
                
                        <tr>
                            
                            <?php if($price_to_book >0) { ?>
                                <td>
                                    <h4> Price to Book </h4>
                                    <p> <?php echo $price_to_book; ?> </p>
                                </td>
                            <?php } ?>
                        
                        </tr>
                        
                        <!-- New Feature 08 - 08 - 2016 end -->
                        
                         <?php
            
            if(trim($myrow["Valuation"])!="")
            {
            ?>
            <tr><td colspan="3" ><h4>&nbsp;Valuation (More Info)</h4><p>

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
                        <tr>
                        <?php
                        
                        if($dec_revenue > 0 || $dec_revenue < 0)
                        {
                        ?>
                        <td  style='width:30%'><h4>Revenue (INR Cr)</h4><p><?php echo $dec_revenue ;?></p></td>
                         <?php
                        }
                        else{
                            if($dec_company_valuation >0 && $dec_revenue_multiple >0){
                           ?>      
                            <td  style='width:30%'><h4>Revenue (INR Cr)</h4><p><?php echo  number_format($dec_company_valuation/$dec_revenue_multiple, 2, '.', ''); ?></p></td>
                         <?php       
                            }else{
                                echo "<td style='width:30%'></td>";
                            }

                        }

                        if($dec_ebitda > 0 || $dec_ebitda < 0)
                        {
                        ?>
                        <td  style='width:30%'><h4>EBITDA (INR Cr)</h4><p><?php echo $dec_ebitda ;?></p></td>
                         <?php
                        }
                        else{
                            if($dec_company_valuation >0 && $dec_ebitda_multiple >0){
                           ?>      
                           <td  style='width:30%'><h4>EBITDA (INR Cr)</h4><p><?php echo  number_format($dec_company_valuation/$dec_ebitda_multiple, 2, '.', '');
                            ?></p></td>
                         <?php       
                            }else{
                                echo "<td style='width:30%'></td>";
                            }

                        }
                        if($dec_pat > 0 || $dec_pat < 0)
                        {
                        ?>
                        <td  style='width:30%'><h4>PAT (INR Cr)</h4><p><?php echo $dec_pat ;?></p></td>
                         <?php
                        } 
                        else{
                            if($dec_company_valuation >0 && $dec_pat_multiple >0){
                        ?>      
                           <td  style='width:30%'><h4>PAT (INR Cr) </h4><p><?php echo number_format($dec_company_valuation/$dec_pat_multiple, 2, '.', ''); ?></p></td>
                         <?php       
                        }else{
                                echo "<td style='width:30%'></td>";
                            }

                        }?>
                        </tr> 
                        
                        <tr>            
                            <?php if($book_value_per_share >0) { ?>
                                    <td>
                                            <h4> Book Value Per Share </h4>
                                            <p> <?php echo $book_value_per_share; ?> </p>
                                    </td>
                            <?php } ?>

                            <?php if($price_per_share >0) { ?>
                                    <td>
                                            <h4> Price Per Share </h4>
                                            <p> <?php echo $price_per_share; ?> </p>
                                    </td>
                            <?php } ?>
                        </tr>
                     <?PHP  if($finlink!="")
            {
            ?>
                        <tr><td colspan="3" ><h4>&nbsp;Link for Financials</h4><p><a target="_blank" href=<?php echo $finlink; ?> ><?php echo $finlink; ?></a></p></td>

            <?php
            }
                      if($myrow["uploadfilename"]!="")
            {

                ?>

                    <!-- <tr><td colspan="3" ><h4>&nbsp;Financials</h4> -->
                                        <?php
                                         if($exportToExcel==1)
                                         {
                                         ?>
                                               <!--  <p><a href=<?php echo $file;?> target="_blank" > Click here </a> </p> </td> </tr> -->
                                         <?php
                                         }
                                         else
                                         {
                                         ?>
                                               <!--  <p>Paid Subscribers can view a link to the co. financials here </p> </td> </tr> -->
                                         <?php
                                          }

            } ?>
        <?php 
       if(sizeof($linkstring)>0) 
       { 
       ?> 
         <tr>
             
         <?php  
         $link=1;
         foreach ($linkstring as $linkstr)
                { 
                    if(trim($linkstr)!=="")
                    {
                        if($link==1) { echo "<td colspan='3' > <b>Link</b><p>"; }
                ?>
          <a href=<?php echo $linkstr; ?> target="_blank"><?php print nl2br($linkstr); ?></a><br/>
          
                    <?php $link++;
                    
                        } } 
         if($link==2) { echo "</p></td>"; }               
                        ?>
                
          
        </tr>
        
          <?php } ?> 
        
        
        <?php
                 if($estimatedirrvalue!="")
                 {
                             ?>
                   <tr colspan="3" ><td><h4>Estimated Returns </h4><p><?php echo $myrow["EstimatedIRR"];?></p></tr>
                    <?php
                    }
                         $invStringArrayCount=count($invReturnString);
                         //echo "<Br>***" .$bool_returnFlag;
            if($bool_returnFlag==1)  //to display the title ifandonlyif atleast one investor has mutliplereturn value >0
                         {
                        ?>
                            <tr  ><td colspan="3"><h4 id="tour_returnmultiple">Returns</h4><p>
                
                            <?php
                  for($i=0;$i<$invStringArrayCount;$i++)
                  {
                              $invStringToSplit=$invReturnString[$i];
                               $invString  =explode(",",$invStringToSplit);
                               $investorName=$invString[0];
                               $returnValue=$invString[1];
                               $returnIRR=$invString[2];
                               $investormoreinfo=$invMoreInfoString[$i];
                           //echo "<br>****".$invMoreInfoString[$i];

                                if($returnValue>0 || $returnIRR>0)
                                {
                          ?>
                                
                                 <b><?php echo $investorName;?> </b> <?php if($returnValue!='0') {echo", " .$returnValue."x "; }?><?php if($returnIRR!='0'){echo", ".$returnIRR."% (IRR)";}  ?> 
                                 <br />
                                 <?php
                                   if ($investormoreinfo!="")
                                   {
                                    echo ($investormoreinfo) ;
                                    echo "<br/>";
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
                                <tr><td colspan="3" ><h4>More Info (Returns) </h4><p><?php print nl2br($moreinfo_returns);?></p></td></tr>
                        <?php
                         } ?>
        </tbody>
        </table> 
        
        
        </div>
        <?php
        }
        ?>
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/tac-3/">
                 <h2 id="moreinfo">More Info</h2>
                                                               
                  <table class="tablelistview" cellpadding="0" cellspacing="0">
                      <tr>  <td class="more-info"><p><?php print nl2br($moreinfor); ?></p>
                              <p><a id="clickhere" href="mailto:research@ventureintelligence.com?subject=Request for more deal data-<?php echo $pageTitlemail;?>&body=<?php echo $mailurl;?> ">
                                      Click Here</a> to request more details for this deal. Please specify what details you would like - financials, valuations, etc. - and we will revert with the data points as available. Note: For recent transactions (say within last 6 months), additional information availablity is typically less than for older ones.
                              </p></td></tr></table>
                                                                 
                                                                 </div>
        
    </div>
<?php include('dealcompanydetails.php'); ?>
  <?php
                                if(($exportToExcel==1))
                                {
                                ?>
        <input type="button"  style="float: right;" class="export_new exlexport" value="Export" name="showmandadeal">

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

<div class="popup_main" id="popup_main" style="display:none;">
    
    <div class="popup_box">
    <!--  <h1 class="popup_header">Financial Details</h1>-->
      <span class="popup_close"><a href="javascript: void(0);">X</a></span>
      <div class="popup_content" id="popup_content">
    
    </div>
    
    </div>  
    </div>

</body>
 <script type="text/javascript">
      $(document).ready(function(){
        
        $('.popup_close a').click(function(){
            $(".popup_main").hide();
            $('body').css('overflow', 'scroll');
         });
         
         
         var cin = '<?php echo $cinno; ?>';
         $.ajax({
            url: 'pecfs_financial.php',
             type: "POST",
            data: { cin : cin,queryString:'INR' },
            success: function(data){
                $('#popup_content').html($.parseJSON(data))
                        
            },
            error:function(){
                jQuery('#preloading').fadeOut();
                alert("There was some problem sending mail...");
            }

        });
        
         
    });  
    $(document).on('click','#pop_menu li',function(){
           window.open('<?php echo BASE_URL;?>cfsnew/details.php?vcid='+$(this).attr("data-row")+'&pe=1', '_blank');
    });
    $(document).on('click','#allfinancial',function(){
             
             $(".popup_main").show();
             $('body').css('overflow', 'hidden');
     });
      $(document).ready(function() {
        $("#ymessage").on('keydown', function() {
            var words = this.value.match(/\S+/g).length;
            var character = this.value.length;
            
            if (words == 201) {
                
                $("#ymessage").attr('maxlength',character);
            }
            if(words > 200){
                 alert("Text reached above 200 words");
            }
            else {
                $('#word_left').text(200-words);
            }
        });
     });
     
//                $("a.postlink").click(function(){
//                  
//                    hrefval= $(this).attr("href");
//                    $("#pesearch").attr("action", hrefval);
//                    $("#pesearch").submit();
//                    return false;
//                    
//                });
                $("a.postlink").click(function(){
                  
                    $('<input>').attr({
                    type: 'hidden',
                    id: 'foo',
                    name: 'searchallfield',
                    value:'<?php echo $searchallfield; ?>'
                    }).appendTo('#pesearch');
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

                function resetmultipleinput(fieldname,fieldid)
                {
                  $("#resetfield").val(fieldname);
                  $("#resetfieldid").val(fieldid);
                  
                  //alert( $("#resetfield").val());
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
                            data: { to : $("#toaddress").val(),subject : $("#subject").val(), basesubject : $("#basesubject").val(), message : $("#message").val() , ymessage : $("#ymessage").val() , userMail : $("#useremail").val() },
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



<style>
     .result-title ul {
    margin: 0 20px;
    float: left;
   /* width: 78%;*/
}
 .result-title{
    width: 78%;
 }
.result-title .title-links {
    position: fixed;
    right: 20px;
    top: 89px;
}
.popup_content ul.token-input-list-facebook{
    height: 39px !important;
    width: 537px !important;
}
.popup_main
{
        position: fixed;
        left:0;
        top:0px;
        bottom:0px;
        right:0px;
        background: rgba(2,2,2,0.5);
        z-index: 999;
}
.popup_box
{
    width:70%;
    height: 0;
    position: relative;
    left:0px;
    right:0px;
    bottom:0px;
    top:35px;
    margin: auto;
    
}

.pop_menu ul li {
    margin-right: 0;
    background: #413529;
    margin-bottom: 10px;
    width: 10%;
    cursor: pointer;
    text-align: center;
    color: rgba(255,255,255,1);
    display: table-cell;
    vertical-align: middle;
    height: 60px;
    font-size: 14px;
}

.pop_menu ul li:first-child {
    margin-right: 0;
    background: #ffffff;
    margin-bottom: 10px;
    width: 10%;
    cursor: pointer;
    text-align: center;
    color: #413529;
    display: table-cell;
    vertical-align: middle;
    height: 60px;
    font-size: 14px;
    border:1px solid #413529;
}
.table-view{
    max-height: 600px!important;
    overflow-y: scroll;
    width: 100%;
    font-size: 16px;
}
.popup_content {
    background: #ececec;
    border: 3px solid #211B15;
    margin: auto;
}
.popup_form
{
    width:700px;
    border:1px solid #d5d5d5;
    background: #fff;
    height: 40px;
}
.popup_dropdown
{
     width: 155px;
     margin:0px;
     border: none;
     height: 40px;
     -webkit-appearance: none;
     -moz-appearance: none;
     appearance: none;
     background: url("images/polygon1.png") no-repeat 95% center;
     padding-left: 17px;
     cursor: pointer;
     font-size: 14px;
}
.popup_text
{
    width:538px;
    border: none;
    border-left:1px solid #d5d5d5;
    padding-left: 17px;
    box-sizing: border-box;
    height: 40px;
    font-size: 16px;
    float: right;
}
.auto_keywords
{
    position: absolute;
    top: 106px;
    width:537px;
    background: #fff;
        border:1px solid #d5d5d5;
        border-top: none;
        display: none;
}
.auto_keywords ul
{
    line-height: 25px;
    font-size: 16px;
}

.auto_keywords ul li
{
 padding-left: 20px; 
 cursor:pointer;
}
.auto_keywords ul li a
{
  text-decoration: none;
  color: #414141;
}
.auto_keywords ul li:hover
{
   background: #f2f2f2;                                 
}
.popup_btn
{
    text-align: center;
    padding: 33px 0 50px;
    
}
.popup_cancel
{
    background: #d5d5d5;
    cursor: pointer;
    padding:10px 27px;
    text-align: center;
    color: #767676;
    text-decoration: none;
    margin-right: 16px;
    font-size: 16px;
    display: none;
    
}
.popup_btn input[type="button"]
{
    background: #a27639;
    cursor: pointer;
    padding:10px 27px;
    text-align: center;
    color: #fff;
    text-decoration: none;
    font-size: 16px;
    float: right;

}
.popup_close
{
    color: #fff;
    right: 0px;
    font-size: 20px;
    position: absolute;
    top: 1px;
    width: 15px;
    background: #413529;
    text-align: center;
}
.popup_close a
{
    color: #fff;
    text-decoration: none;
    cursor: pointer;
}
.popup_searching
{
    width:538px;
    float: right;
        position: relative;
}
div.token-input-dropdown{
        z-index: 999 !important;
}

.detail-table-div { display:block; float:left; overflow:hidden;border:1px solid #B3B3B3;}
.detail-table-div table{ border-top:0 !important; border-bottom:0 !important; width:auto !important; margin:0 !important;  }
.detail-table-div th{background:#E5E5E5; text-align:right !important;}
.detail-table-div td{ background:#fff; min-width:130px; text-align:right !important;}
/*.detail-table-div th:first-child {    max-width: 280px; text-align:left !important;
    min-width: 280px;  background:#C9C2AF;}*/
.detail-table-div th:first-child {    max-width: 240px; text-align:left !important;min-width: 240px;  background:#C9C2AF;padding:8px;}
.detail-table-div td:first-child {    max-width: 260px; text-align:left !important;min-width: 260px; background:#E0D8C3;}
.detail-table-div td { padding:8px;}
    
.tab-res {
    display: block;
    overflow-x: visible !important;
    border: 1px solid #B3B3B3;
    margin-left: 280px !important;
}
.tab-res table {
    border-top: 0 !important;
    border-right: 1px solid #B3B3B3;
    width: auto !important;
    margin: 0 !important;
}
.tab-res th{background:#E5E5E5; text-align:right !important;}
.tab-res td{ background:#fff; min-width:150px; text-align:right !important;padding:8px; border-right: 1px solid #b3b3b3;}
.tab-res table thead th {
    border-bottom: 1px solid #b3b3b3;
    border-right: 1px solid #b3b3b3;
    text-align: left;
    padding: 8px;
    font-weight: bold;
}

.tab-res th {
    background: #E5E5E5;
    text-align: right !important;
}
detail-table-div table thead th:last-child {
    border-right: 0 !important;
}

.tab-res table thead th {
    border-bottom: 1px solid #b3b3b3;
}

#allfinancial {
    display: inline-block; 
    font-size: 17px;
    color:#804040;
    font-weight: bolder;
    cursor:pointer;
    float:right;
}

@media (min-width:1366px) and (max-width: 2559px) {
    #allfinancial {
        margin-right: 5px;
    }
}

@media (max-width:1500px){
    .popup_content {
        background: #ececec;
        height: 500px;
    }
    .table-view{
        height: 400px;
        overflow-y: auto;
    }
    .popup_main {
        top: 45px;
    }
    
}

@media (max-width:1025px){
       .popup_content {
            height: 500px;
        }
        .table-view{
            height: 400px;
        }
        .popup_main {
            top: 80px;
        }
        
}
@media (min-width:780px){
       
    .list_companyname{
        margin-left:160px !important;
    }
}
@media (min-width:1280px){
       
    .list_companyname{
        margin-left:250px !important;
    }
}
@media (min-width:1439px){
       
    .list_companyname{
        margin-left:340px !important;
    }
}
@media (min-width:1639px){
       
    .list_companyname{
        margin-left:520px !important;
    }
}

@media (min-width:1921px){
    
    .popup_content
    {
        background: #ececec;
        height: 600px;
        overflow-y: auto;
    }
    
}
.popup-button{
    
    text-decoration: none;
    font-size: 14px;
    cursor: pointer;
    text-transform: uppercase;
    padding: 5px 0px 6px 5px;
    color: #fff;
    background-color: #A2753A;
    width: 85px;
    float: right;
    text-align: center;
   
}
.popup-export{
    width: 100%;
    float: right;
    padding: 0px 5px 5px 0px;
}
       

/* Styles */

</style>



<script src="hopscotch.js"></script>
<?php if(isset($_SESSION['currenttour'])) { echo ' <script src="'.$_SESSION['currenttour'].'.js?16feb"></script> '; } ?>
<script src="TourStart.js"></script>     
<script type="text/javascript">         
       $(document).ready(function(){
           
       <?php if(isset($_SESSION["EXITSdemoTour"]) && $_SESSION["EXITSdemoTour"]=='1') { ?>
            EXITSdemotour=1;            
                            
                        <?php if($SelCompRef=='1080927690') { ?>
                           $('body,html').animate({ scrollTop: $(document).height()   }, 6000);
                           
                            setTimeout(function() {
                                if(EXITSdemotour==1){ $('body,html').animate({scrollTop:0}, 6000);  }                                  
                            },6000); 
                            
                            setTimeout(function() {
                                if(EXITSdemotour==1){ hopscotch.startTour(tour, 16); }                                  
                            },13000); 
                        
                        <?php } else { ?>
                        hopscotch.startTour(tour, 8);     
                        <?php } ?>  
            
      <?php } ?>
       
       });
</script>
<?php
mysql_close();
    mysql_close($cnx);
    ?>