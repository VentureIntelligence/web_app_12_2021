<?php include_once("../globalconfig.php"); ?>
<?php 
//other database
    $all_keyword_other = trim($_POST['all_keyword_other']);
    $searchallfield_other = $_POST['searchallfield_other'];
    $investorauto_sug_other = $_POST['investorauto_sug_other'];
    $keywordsearch_other = $_POST['keywordsearch_other'];
    $companyauto_other =$_POST['companyauto_other'];
    $companysearch_other =$_POST['companysearch_other'];
    $sectorsearch_other =$_POST['sectorsearch_other'];
    $advisorsearch_legal_other =$_POST['advisorsearch_legal_other'];
    $advisorsearch_trans_other =$_POST['advisorsearch_trans_other'];
    if($all_keyword_other !=''){
        if(isset($keywordsearch_other) && $keywordsearch_other !=''){
            $ex_keywordsearch_other = explode(',', $keywordsearch_other);
            $ex_investorauto_sug_other = explode(',', $investorauto_sug_other);
            if(!in_array($all_keyword_other, $ex_keywordsearch_other)){
                if(!in_array($all_keyword_other, $ex_investorauto_sug_other)){
                $_POST['keywordsearch_other'] ='';
                $_POST['investorauto_sug_other'] = '';
            }else{
                $key = array_search($all_keyword_other, $ex_keywordsearch_other);
                $_POST['keywordsearch_other'] =$ex_investorauto_sug_other[$key];
                $_POST['investorauto_sug_other'] = $all_keyword_other;   
                $incubation_from = "yes";
            }
            }else{
                $key = array_search($all_keyword_other, $ex_keywordsearch_other);
                $_POST['keywordsearch_other'] =$all_keyword_other;
                $_POST['investorauto_sug_other'] = $ex_investorauto_sug_other[$key]; 
            }
        }
        else if(isset($companyauto_other) && $companyauto_other !=''){
            $ex_companyauto_other = explode(',', $companyauto_other);
            $ex_companysearch_other = explode(',', $companysearch_other);
            if(!in_array($all_keyword_other, $ex_companyauto_other)){
                $_POST['companyauto_other'] ='';
                $_POST['companysearch_other'] = '';
            }else{
                $key = array_search($all_keyword_other, $ex_companyauto_other);
                $_POST['companyauto_other'] =$all_keyword_other;
                $_POST['companysearch_other'] = $ex_companysearch_other[$key]; 
            }
        }
        else if(isset($sectorsearch_other) && $sectorsearch_other !=''){
            $ex_sectorsearch_other = explode(',', $sectorsearch_other);
            if(!in_array($all_keyword_other, $ex_sectorsearch_other)){
                $_POST['sectorsearch_other'] = '';
            }else{
                $_POST['sectorsearch_other'] =$all_keyword_other;
            }
        }
        else if(isset($advisorsearch_legal_other) && $advisorsearch_legal_other !=''){
            if($all_keyword_other != $advisorsearch_legal_other){
                $_POST['advisorsearch_legal_other'] = '';
            }else{
                $_POST['advisorsearch_legal_other'] =$all_keyword_other;
            }
        }
        else if(isset($advisorsearch_trans_other) && $advisorsearch_trans_other !=''){
            if($all_keyword_other != $advisorsearch_trans_other){
                $_POST['advisorsearch_trans_other'] = '';
            }else{
                $_POST['advisorsearch_trans_other'] =$all_keyword_other;
            }
        }
        else if(isset($searchallfield_other) && $searchallfield_other !=''){
            $ex_searchallfield_other = explode(',', $searchallfield_other);
        }
    }
        $drilldownflag=0;
        $companyId=632270771;
        $companyIdDel=1718772497;
        $companyIdSGR=390958295;//688981071;//
        $companyIdVA=38248720;
        $companyIdGlobal=730002984;
        $compId=0;
        require_once("../dbconnectvi.php");
        $Db = new dbInvestments(); 
        $VCFlagValue = isset($_REQUEST['value']) ? $_REQUEST['value'] : '3';
        if($VCFlagValue==3)
        {
         $videalPageName="SVInv";
        }
       elseif($VCFlagValue==4)
        {
          $videalPageName="CTech";
        }
        elseif($VCFlagValue==5)
        {
          $videalPageName="IfTech";
        }
        include ('checklogin.php');
       
        $type=isset($_REQUEST['type']) ? $_REQUEST['type'] :1;
        
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
                $month1= date('n');
                $year1 = date('Y', strtotime(date('Y')." -1  Year"));
                $month2= date('n');
                $year2 = date('Y');
            }
            $fixstart=$year1;
            $startyear =  $fixstart."-".$month1."-01";
            $fixend=$year2;
            $endyear =  $fixend."-".$month2."-31";
            
            
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            
            if($resetfield=="period")
            {
             $month1= date('n'); 
             $year1 = date('Y', strtotime(date('Y')." -1  Year"));
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
        }elseif (($resetfield=="searchallfield")||($resetfield=="keywordsearch")||($resetfield=="companysearch")||($resetfield=="sectorsearch")||($resetfield=="advisorsearch_legal")||($resetfield=="advisorsearch_trans"))
            {
             $month1= date('n'); 
             $year1 = date('Y', strtotime(date('Y')." -1  Year"));
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
             $_POST['searchallfield']="";
            }
            else if(trim($_POST['searchallfield'])!="" || trim($_POST['searchTagsField'])!="" || trim($_POST['investorauto_sug'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['sectorsearch'])!="" || trim($_POST['advisorsearch_legal'])!="" || trim($_POST['advisorsearch_trans'])!="" ){
//             $month1=01; 
//             $year1 = date('Y', strtotime(date('Y')." -1  Year"));
//             $month2= date('n');
//             $year2 = date('Y');
             //   if(trim($_POST['searchallfield'])!=""){
                    if(($_POST['month1']==date('n')) && $_POST['year1']==date('Y', strtotime(date('Y')." -1  Year")) && $_POST['month2']==date('n') && $_POST['year2']==date('Y')){
                        $month1=01; 
                        $year1 = 1998;
                        $month2= date('n');
                        $year2 = date('Y');
                               }else{
                                   $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
                                   $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
                                   $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
                                   $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
                    }
               // }
//                if(trim($_POST['keywordsearch'])!="" || trim($_POST['sectorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!=""){
//                    $month1=01; 
//                    $year1 = 1998;
//                    $month2= date('n');
//                    $year2 = date('Y');
//                }
                }
            else
            {
             $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] :date('n');
             $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
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
            $startyear = $getdt1;
            $endyear = $getdt2;
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
        
        if($VCFlagValue==3)
        {
          $dbtype='SV';
          $pagetitle="Social Venture Investments -> Search";
          $showallcompInvFlag=8;
          $stagesql_search =  "SELECT DISTINCT pe.StageId, Stage
                              FROM peinvestments AS pe, peinvestments_dbtypes AS pedb, stage AS s
                              WHERE pedb.PEId = pe.PEId
                              AND pe.Deleted =0
                              AND pedb.DBTypeId = '$dbtype'
                              AND s.StageId = pe.StageId
                              ORDER BY DisplayOrder";
       }
       elseif($VCFlagValue==4)
        {
          $dbtype='CT';
          $showallcompInvFlag=9;
          $pagetitle="Cleantech Investments -> Search";
          $stagesql_search="select StageId,Stage from stage order by DisplayOrder";
        }
        elseif($VCFlagValue==5)
        {
          $dbtype='IF';
          $showallcompInvFlag=10;
          $pagetitle="Infrastructure Investments -> Search";
          $stagesql_search="select StageId,Stage from stage order by DisplayOrder";
        }

        $getTotalQuery= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
        FROM peinvestments AS pe, stage AS s ,pecompanies as pec,peinvestments_dbtypes as pedb
        WHERE  pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and
        pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0";
        
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
        
        if($compId==$companyId)
        { 
           $hideIndustry = " and display_in_page=1 "; 

        }
        elseif($compId==$companyIdDel)
        {
          $hideIndustry = " and display_in_page=2 ";
        }
        elseif($compId==$companyIdSGR)
        {
          $hideIndustry = " and (industryid=3 or industryid=24) ";
        }
        elseif($compId==$companyIdVA)
        {
          $hideIndustry = " and (industryid=1 or industryid=3) ";
        }
        else if($compId==$companyIdGlobal){
            $hideIndustry = " and (industryid=24) ";
        }
        else
        {
           $hideIndustry="";     
        }

        $industrysql_search="select distinct pec.industry,i.Industry from industry as i ,pecompanies as pec,
        peinvestments as pe,peinvestments_dbtypes as pedb
        where i.IndustryId !=15 " . $hideIndustry ." and pedb.PEId=pe.PEId and pec.PECompanyId=pe.PECompanyId and pe.Deleted=0
        and i.IndustryId=pec.Industry order by i.Industry";

        if ($totalrs = mysql_query($getTotalQuery))
        {
         While($myrow=mysql_fetch_array($totalrs, MYSQL_BOTH))
           {
                $totDeals = $myrow["totaldeals"];
                $totDealsAmount = $myrow["totalamount"];
           }
        }
        $addDelind="";
        
        if($compId==$companyIdDel)
        {
          $addDelind = " and (pec.industry=9 or pec.industry=24)";
        }
        if($compId==$companyIdSGR)
        {
          $addDelind = " and (pec.industry=3 or pec.industry=24)";
        }
        if($compId==$companyIdVA)
        {
          $addDelind = " and (pec.industry=1 or pec.industry=3)";
        }
         if($compId==$companyIdGlobal)
        {
          $addDelind = " and (pec.industry=24)";
        }
        
        $searchString="Undisclosed";
        $searchString=strtolower($searchString);

        $searchString1="Unknown";
        $searchString1=strtolower($searchString1);

        $buttonClicked=$_POST['hiddenbutton'];
        $fetchRecords=true;
        $totalDisplay="";
         $resetfield=$_POST['resetfield'];

        if($resetfield=="searchallfield")
        { 
         $_POST['searchallfield']="";
         $_POST['searchKeywordLeft']="";
         $searchallfield="";
        }
        else 
        {
         $searchallfield=trim($_POST['searchallfield']);
         if(isset($_POST['searchKeywordLeft']) && $_POST['searchKeywordLeft'] !=''){
            $searchallfield=trim($_POST['searchKeywordLeft']);             
         }
         if(isset($_POST['searchTagsField']) && $_POST['searchTagsField'] !=''){
            $searchallfield=trim($_POST['searchTagsField']);             
         }
            if($searchallfield != "")
            {
                $_POST['keywordsearch'] = ""; 
                $_POST['companysearch'] = ""; 
                $_POST['sectorsearch'] = "";
                $_POST['advisorsearch_legal'] = ""; 
                $_POST['advisorsearch_trans'] = ""; 
            }
        }
        $searchallfieldhidden=preg_replace('/\s+/', '_', $searchallfield);
        if($resetfield=="keywordsearch")
        { 
         $_POST['keywordsearch']="";
         $keyword="";
         $keywordhidden="";
          $investorauto='';
        }
        else 
        {
         //$keyword=trim($_POST['keywordsearch']);
         
        if(isset($_POST['investorauto_sug_other'])){
            $investorauto=$_POST['investorauto_sug_other'];
            $keyword=trim($_POST['investorauto_sug_other']);
            $keywordhidden=preg_replace('/\s+/', '_', $keyword);
                        $month1=01; 
                        $year1 = 1998;
                        $month2= date('n');
                        $year2 = date('Y');
                        $dt1 = $startyear =  $year1."-".$month1."-01";
            $keywordsearch = $_POST['keywordsearch_other'];
        }else{
            $investorauto = $keyword=trim($_POST['investorauto_sug']);            
            $keywordhidden=trim($_POST['investorauto_sug']);    
            $keywordsearch = $_POST['keywordsearch'];        
        }
            if($incubation_from == "yes"){
                $sql_investorauto_sug = "select  InvestorId as id,Investor as name from peinvestors where Investor like '$keyword' order by InvestorId";                
            }else{
         $sql_investorauto_sug = "select  InvestorId as id,Investor as name from peinvestors where InvestorId IN($keyword) order by InvestorId";
            }
            
                   $sql_investorauto_sug_Exe=mysql_query($sql_investorauto_sug);
      // print_r($getInvestorSql_Exe);
       $response =array(); 
       $invester_filter="";
      $i = 0;
       While($myrow = mysql_fetch_array($sql_investorauto_sug_Exe,MYSQL_BOTH)){
                    if($incubation_from == "yes"){
                        $investorauto = $myrow['id'];
                    }
         $response[$i]['id']= $myrow['id'];
         $response[$i]['name']= $myrow['name'];
         if($i!=0){
         
             $invester_filter.=",";
         }
            $invester_filter.=$myrow['name'];
        $i++;
        
       }
      if($response != '')
      {
        $investorsug_response= json_encode($response);
      }
      else{
          $investorsug_response= 'null';
      }
         
         if($keyword!=''){
                $searchallfield='';
        }
          //  $investorauto=$_POST['investorauto_sug'];
        }
        $keywordhidden =preg_replace('/\s+/', '_', $keywordhidden);

        //echo "<br>--" .$keywordhidden;

         if($resetfield=="companysearch")
        { 
         $_POST['companysearch']="";
         $companysearch="";
         $companyauto='';
        }
        else 
        {
            if(isset($_POST['companyauto_other']) && $_POST['companyauto_other'] !=''){
            $companyauto=$_POST['companyauto_other'];
            $companysearch=trim($_POST['companysearch_other']);
            $companysearchhidden=preg_replace('/\s+/', '_', $companysearch);
      //  $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);
                        $month1=01; 
                        $year1 = 1998;
                        $month2= date('n');
                        $year2 = date('Y');
            }else{
                $companysearch=trim($_POST['companysearch']);
                if($companysearch!=''){
                       $searchallfield='';
               }
            $companyauto=$_POST['companyauto'];
            }
        }
        $companysearchhidden=preg_replace('/\s+/', '_', $companysearch);

         if($resetfield=="sectorsearch")
        { 
         $_POST['sectorsearch']="";
         $sectorsearch="";
        }
        else 
        {
            if(isset($_POST['sectorsearch_other']) && $_POST['sectorsearch_other'] !=''){
                $sectorsearch=$_POST['sectorsearch_other'];
                $sectorsearchhidden=preg_replace('/\s+/', '_', $sectorsearch);
                            $month1=01; 
                            $year1 = 1998;
                            $month2= date('n');
                            $year2 = date('Y');
                            $dt1 = $startyear =  $year1."-".$month1."-01";
            }else{
                $sectorsearch=stripslashes(trim($_POST['sectorsearch']));
                if($sectorsearch!=''){
                       $searchallfield='';
               }
            }
        }
        $sectorsearchhidden=preg_replace('/\s+/', '_', $sectorsearch);
         if($resetfield=="advisorsearch_legal")
        { 
         $_POST['advisorsearch_legal']="";
          $advisorsearchstring_legal="";
        }
        else 
        {
            if(isset($_POST['advisorsearch_legal_other']) && $_POST['advisorsearch_legal_other'] !=''){
                $advisorsearchstring_legal=$_POST['advisorsearch_legal_other'];
                            $month1=01; 
                            $year1 = 1998;
                            $month2= date('n');
                            $year2 = date('Y');
                            $dt1 = $startyear =  $year1."-".$month1."-01";
            }else{
                $advisorsearchstring_legal=trim($_POST['advisorsearch_legal']);
                if($advisorsearchstring_legal!=''){
                       $searchallfield='';
               }
            }
        }
        $advisorsearchhidden_legal=preg_replace('/\s+/', '_', $advisorsearchstring_legal);

         if($resetfield=="advisorsearch_trans")
        { 
         $_POST['advisorsearch_trans']="";
          $advisorsearchstring_trans="";
        }
        else 
        {
            if(isset($_POST['advisorsearch_trans_other']) && $_POST['advisorsearch_trans_other'] !=''){
                $advisorsearchstring_trans=$_POST['advisorsearch_trans_other'];
                            $month1=01; 
                            $year1 = 1998;
                            $month2= date('n');
                            $year2 = date('Y');
                            $dt1 = $startyear =  $year1."-".$month1."-01";
            }else{
                $advisorsearchstring_trans=trim($_POST['advisorsearch_trans']);
                if($advisorsearchstring_trans!=''){
                       $searchallfield='';
               }
            }
        }
        $advisorsearchhidden_trans=preg_replace('/\s+/', '_', $advisorsearchstring_trans);

        //echo "<br>Key word ---" .$keyword;
        //$region=$_POST['region'];
         if($resetfield=="industry")
        { 
         $_POST['industry']="";
         $industry=array();
        }
        else 
        {
            $industry=$_POST['industry'];
            if(count($industry) >0 ){
                $searchallfield='';
            }
        }
         if($resetfield=="stage")
        { 
         $_POST['stage']="";
         $stageval=array();
        }
        else 
        {
         $stageval=$_POST['stage'];
         if(count($stageval) > 0){
                $searchallfield='';
        }
        }

        if(count($stageval) && $stageval!="")
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
            $round=array();
        }
        else 
        {
            $round=$_POST['round'];
            if(count($round) > 0 && $round != ''){
                $searchallfield='';
            }
        }
         //valuation
        if($resetfield=="valuations")
        { 
            $_POST['valuations']="";
            $valuations="--";
            
        }
        else 
        {
            $valuations=$_POST['valuations'];
            $c=1;
            foreach($valuations as $v)
            {
                if($c > 1) { $coa=','; }
                $valuationstxt.= "$coa $v";
                $c++;
            }
            if($valuations!=''){
                $searchallfield='';
        }
        }

        if($_POST['valuations'] && $valuations!="" && $valuations!="--")
        {
            $boolvaluations=true;
            //foreach($stageval as $stage)
            //	echo "<br>----" .$stage;
        }
        else
        {
            $valuations="--";
            $boolvaluations=false;
        }


        //
        if($resetfield=="invType")
        { 
         $_POST['invType']="";
         $investorType="";
        }
        else 
        {
         $investorType=trim($_POST['invType']);
          if($investorType!='--' && $investorType!=''){
                $searchallfield='';
        }
        }

        if($resetfield=="dealtype_debtequity")
        { 
            $_POST['dealtype_debtequity']="";
            $debt_equity="--";
        }
        else 
        {
            $debt_equity=trim($_POST['dealtype_debtequity']);
            if($debt_equity!='--' && $debt_equity!=''){
                $searchallfield='';
            }
        }
        if($resetfield=="syndication")
        { 
            
            $_POST['Syndication']="";
            $syndication="--";
        }
        else 
        {
            $syndication=$_POST['Syndication'];
            if($syndication!='--' && $syndication!=''){
                $searchallfield='';
            }
        }
         
        if($resetfield=="txtregion")
        { 
         $_POST['txtregion']="";
         $regionId=array();
        }
        else 
        {
            $regionId=$_POST['txtregion'];
            if(count($regionId)>0){
                $searchallfield='';
        }
        }
        if($resetfield=="city")
        { 
            $_POST['citysearch']="";
            $city="";
        }
        else 
        {
            $city=trim($_POST['citysearch']);
            if($city != NULL && $city !=''){
                $searchallfield='';
            }
        }
        if($resetfield=="range")
        { 
        $_POST['invrangestart']="";
        $_POST['invrangeend']="";
        $startRangeValue="--";
        $endRangeValue="--";
        $regionId=array();
        }
        else 
        {
         $startRangeValue=$_POST['invrangestart'];
         $endRangeValue=$_POST['invrangeend'];
         if($startRangeValue!="--" && $endRangeValue!="--" && $startRangeValue!="" && $endRangeValue!=""){
                $searchallfield='';
        }
        }
        $endRangeValueDisplay =$endRangeValue;
        
        
/*         if($resetfield=="invType")
        { 
         $_POST['invType']="";
         $invType="--";
        }
        else 
        {
         $invType=trim($_POST['invType']);
         if($invType!= NULL && $invType!="--" && $invType!="--"){
                $searchallfield='';
        }
        }*/
        
        if($resetfield=="exitstatus")
        { 
            $_POST['exitstatus']="";
            $exitstatusValue=array();
        }
        else 
        {
            $exitstatusValue = $_POST['exitstatus'];
            if($exitstatusValue != '' && count($exitstatusValue) > 0){
                $searchallfield='';
            }
        }
        
        $whereind="";
        $whereregion="";
        $whereinvType="";
        $wherestage="";
        $wheredates="";
        $whererange="";
        $wherelisting_status="";
        $whereexitstatus="";

        
        if(isset($_POST['searchallfield_other']) && $_POST['searchallfield_other'] !=''){
        $searchallfield=$_POST['searchallfield_other'];
        $searchallfieldhidden=preg_replace('/\s+/', '_', $searchallfield);
                        $month1=01; 
                        $year1 = 1998;
                        $month2= date('n');
                        $year2 = date('Y');
        }
        
        $notable=false;
        $vcflagValue=$_POST['txtvcFlagValue'];

        $datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
        $splityear1=(substr($year1,2));
        $splityear2=(substr($year2,2));

         if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
        {
            $sdatevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
            $edatevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
            $fixstart=$year1;
            $fixend=$year2;
            $startyear=$year1."-".$month1."-01";
            $endyear=$year2."-".$month2."-01";
            $dt1 = $year1."-".$month1."-01";
            $dt2 = $year2."-".$month2."-01";
            $wheredates1= "";
        }
        if(isset($_POST['searchTagsField'])){
        $searchallfield=$_POST['searchTagsField'];
        $searchallfieldhidden=preg_replace('/\s+/', '_', $searchallfield);
                        $month1=01; 
                        $year1 = 1998;
                        $month2= date('n');
                        $year2 = date('Y');
        }
        $datevalueDisplay1= $sdatevalueDisplay1;
        $datevalueDisplay2= $edatevalueDisplay2;
        $whereaddHideamount="";

        if(count($industry) >0)
        {
            $indusSql = $industryvalue = '';
            foreach($industry as $industrys)
            {
                $indusSql .= " IndustryId=$industrys or ";
            }
            $indusSql = trim($indusSql,' or ');
            $industrysql= "select industry from industry where $indusSql";

                if ($industryrs = mysql_query($industrysql))
                {
                        While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                        {
                        $industryvalue.=$myrow["industry"].',';
                        }
                }
            $industryvalue=  trim($industryvalue,',');
            $industry_hide = implode($industry,',');
        }
        // Round Value
        if(count($round) > 0 || $round != null)
        {
            $roundSql = $roundTxtVal = '';
            foreach($round as $rounds)
            {
                $roundSql .= " `round` like '".$rounds."%' or ";
                $roundTxtVal .= $rounds.',';
            }
            $roundTxtVal=  trim($roundTxtVal,',');
            $roundSqlStr = trim($roundSql,' or ');
            $roundSql="SELECT * FROM `peinvestments` where $roundSqlStr group by `round`";
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
		$stageCnt=0;
                $cnt=0;
                $stageCntSql="select count(StageId) as cnt from stage";
                if($rsStageCnt=mysql_query($stageCntSql))
                {
                  while($mystagecntrow=mysql_fetch_array($rsStageCnt,MYSQL_BOTH))
                   {
                     $stageCnt=$mystagecntrow["cnt"];
                   }
                }
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
                                                $cnt=$cnt+1;
						$stagevaluetext= $stagevaluetext. ",".$myrow["Stage"] ;
					}
				}
			}
			$stagevaluetext =substr_replace($stagevaluetext, '', 0,1);
			if($cnt==$stageCnt)
			{      $stagevaluetext="All Stages";}
       		}
		else
                    $stagevaluetext="";
                $stageval_hide = implode($stageval,',');
                
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
                //valuations
        if($boolvaluations==true)
        {
           $valuationsql='';
                
           $count = count($valuations);
            
           
           
            if($count==1) { $valuationsql= "pe.$valuations[0]!=0 AND "; }
            else if ($count==2) { $valuationsql= "pe.$valuations[0]!=0  AND  pe.$valuations[1]!=0   AND "; }
            else if ($count==3) { $valuationsql= "pe.$valuations[0]!=0  AND  pe.$valuations[1]!=0  AND  pe.$valuations[2]!=0  AND "; }   
            else if ($count==4) { $valuationsql= "pe.$valuations[0]!=0  AND  pe.$valuations[1]!=0  AND  pe.$valuations[2]!=0  AND   pe.$valuations[3]!=0  AND "; }   
//            $valuattext =substr_replace($valuattext, '', 0,1);
            //echo $valuationsql; exit();
       }
       else { $valuationsql='';}
        //valuations
        
        
       
                if($debt_equity == 0)
                    $debt_equityDisplay="Equity only";
                elseif($debt_equity == 1)
                    $debt_equityDisplay="Debt only";
                elseif($debt_equity == "--")
                    $debt_equityDisplay="Both";
        
                if($syndication == 0)
                    $syndication_Display="Yes";
                elseif($syndication == 1)
                    $syndication_Display="No";
                elseif($syndication == "--")
                    $syndication_Display="Both";
                
		if(count($regionId) >0)
			{
                    $region_Sql = $regionvalue = '';
                    foreach($regionId as $regionIds)
                    {
                        $region_Sql .= " RegionId=$regionIds or ";
                    }
                    $roundSqlStr = trim($region_Sql,' or ');
                    
                      $regionSql= "select Region from region where $roundSqlStr";
					if ($regionrs = mysql_query($regionSql))
					{
						While($myregionrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
						{
                            $regionvalue .= $myregionrow["Region"].', ';
						}
					}
                    $regionvalue = trim($regionvalue,', ');
                    $region_hide = implode($regionId, ',');
		}


		$invtypesql = "select InvestorType,InvestorTypeName from investortype where Hide=0";

				$vcflagValue = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
				
                                if($vcflagValue==3)
				{
					$addVCFlagqry = " and pec.industry!=15 ";

					$checkForStage = '&& ('.'$stage'.'=="--") ';
					//$checkForStage = " && (" .'$stage'."=='--') ";
					$checkForStageValue =  " || (" .'$stage'.">0) ";
					$searchTitle = "List of Social Venture Investments ";
					$dbtype="SV";
					//$searchAggTitle = "Aggregate Data - VC Investments ";
					//$aggsql= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
					//FROM peinvestments AS pe,pecompanies as pec,industry as i,stage as s  where pe.StageID=s.StageId and s.VCView=1 and  " ;
				//	echo "<br>Check for stage** - " .$checkForStage;
				}
                                if($vcflagValue==4)
				{
					$addVCFlagqry = " and pec.industry!=15 ";

					$checkForStage = '&& ('.'$stage'.'=="--") ';
					//$checkForStage = " && (" .'$stage'."=='--') ";
					$checkForStageValue =  " || (" .'$stage'.">0) ";
					$searchTitle = "List of CleanTech Investments ";
					$dbtype="CT";
					//$searchAggTitle = "Aggregate Data - VC Investments ";
					//$aggsql= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
					//FROM peinvestments AS pe,pecompanies as pec,industry as i,stage as s  where pe.StageID=s.StageId and s.VCView=1 and  " ;
				//	echo "<br>Check for stage** - " .$checkForStage;
				}
				if($vcflagValue==5)
				{
					$addVCFlagqry = " and pec.industry!=15 ";

					$checkForStage = '&& ('.'$stage'.'=="--") ';
					//$checkForStage = " && (" .'$stage'."=='--') ";
					$checkForStageValue =  " || (" .'$stage'.">0) ";
					$searchTitle = "List of Infrastructure Investments ";
					$dbtype="IF";
					//$searchAggTitle = "Aggregate Data - VC Investments ";
					//$aggsql= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
					//FROM peinvestments AS pe,pecompanies as pec,industry as i,stage as s  where pe.StageID=s.StageId and s.VCView=1 and  " ;
				//	echo "<br>Check for stage** - " .$checkForStage;
				}
                               // print_r($_POST);	
                        $orderby=""; $ordertype="";        
                        if(!$_POST || $companysearch != "" || $sectorsearch !='' || $keyword !="" || $advisorsearchstring_legal !='' || $advisorsearchstring_trans !='') {
                            $industry = array();
                            $stageval =array();
                            $debt_equity = '--';
                            $syndication ='--';
                            $regionId = array();
                            $city='';
                            $investorType = $investorType = '--';
                            $startRangeValue = '--';
                            $endRangeValue = '--';
                            $round = array();
                        }
                        if($getyear !='' || $getindus !='' || $getstage !='' || $getinv !='' || $getreg!='' || $getrg!='')
                        {
                            $companysql = "SELECT pe.PECompanyId as companyid, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,
                                                amount, round, s.stage,  stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pec.website, pec.city,
                                                pec.region,pe.PEId,pe.comment,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId ,pe.SPV ,pe.AggHide,pe.dates as dates
                                                ,GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor
                                                FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes  as pedb,
                                                peinvestments_investors as peinv_inv,peinvestors as inv
                                                WHERE dates between '" . $getdt1. "' and '" . $getdt2 . "' AND i.industryid=pec.industry 
                                                AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                                ".$getind." ".$getst." ".$getinvest." ".$getregion." ".$getrange." and pe.Deleted=0" .$addVCFlagqry. " 
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId ";
                            $orderby="companyname";
                            $ordertype="asc";
                             
                            /*$companysql = "SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				 amount, round, s.stage,  stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pec.website, pec.city,
				 pec.region,PEId,comment,MoreInfor,hideamount,hidestake,pe.StageId ,SPV,AggHide
						 FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s
						 WHERE dates between '" . $getdt1. "' and '" . $getdt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
						  ".$getind." ".$getst." ".$getinvest." ".$getregion." ".$getrange." and pe.Deleted=0" .$addVCFlagqry. " AND pe.PEId NOT
                                                  IN (
                                                    SELECT PEId
                                                    FROM peinvestments_dbtypes AS db
                                                    WHERE hide_pevc_flag =1
                                                    ) order by dates DESC";*/
                                // echo "<br>all dashboard" .$companysql;
                        }
                  
                        
                        else if(!$_POST){
                        $yourquery=0;
                        $industry=array();
                        $stagevaluetext="";
                       $month1=($_POST['month1']) ?  $_POST['month1'] : date('n');
                       $year1 = ($_POST['year1']) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
                       $month2=($_POST['month2']) ?  $_POST['month2'] : date('n');
                       $year2 = ($_POST['year2']) ?  $_POST['year2'] : date('Y');
                       $dt1 = $year1."-".$month1."-01";
                       $dt2 = $year2."-".$month2."-01";
                        $companysql = "SELECT pe.PECompanyId as companyid, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,
                         amount, round, s.stage,  stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pec.website, pec.city,
                         pec.region,pe.PEId,pe.comment,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId ,pe.SPV ,pe.AggHide,pe.dates as dates,
                                 GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor
                                         FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes  as pedb,
                                         peinvestments_investors as peinv_inv,peinvestors as inv
                                         WHERE dates between '" . $dt1. "' and '" . $dt2 . "' AND i.industryid=pec.industry
                                         AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                         and pe.Deleted=0" .$addVCFlagqry. " ".$addDelind."  
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId";
                        $orderby="companyname";
                        $ordertype="asc";




//                	     echo "<br>all records" .$companysql;
                        }
                              elseif($searchallfield!="")
                        {
                                $yourquery=1;
                                $industry=array();
                                $stagevaluetext="";
                                $datevalueDisplay1="";
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
                                
                                $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%'";                                    
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
                                
                                $companysql="SELECT pe.PECompanyId as companyid, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,
                                pe.amount, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod,
                                pec.website, pec.city, pec.region, pe.PEId,
                                pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,SPV,AggHide,pe.dates as dates,
                                 GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor
                                                                 FROM peinvestments AS pe, industry AS i,
                                pecompanies AS pec,stage as s,peinvestments_dbtypes as pedb,
                                         peinvestments_investors as peinv_inv,peinvestors as inv
                                WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( $tagsval ) 
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId ";
                                
                                $orderby="companyname";
                                $ordertype="asc";
//                       	echo "<bR>---" .$companysql;
                        }
                        elseif ($companysearch != "")
			{
				$yourquery=1;
        			$industry=array();
				$stagevaluetext="";
				$datevalueDisplay1="";
                                 $datevalueCheck1="";
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
				
                                $companysql="SELECT pe.PECompanyId as companyid, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,
				pe.amount, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,
				pec.website, pec.city, pec.region,pe.PEId,
				pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,SPV,AggHide,pe.dates as dates,
                                 GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor FROM peinvestments AS pe, industry AS i,
				pecompanies AS pec,stage as s,peinvestments_dbtypes as pedb,
                                         peinvestments_investors as peinv_inv,peinvestors as inv
				WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and
                                pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND  pec.PECompanyId IN ($companysearch) 
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId ";
                                $orderby="companyname";
                                $ordertype="asc";
                                
			//	echo "<br>Query for company search";
	//	 echo "<br> Company search--" .$companysql;
			}
			
			elseif ($sectorsearch != "")
			{
                            
                            $sectorsearchArray = explode(",", str_replace("'","",$sectorsearch)); 
                            $sector_sql = array(); // Stop errors when $words is empty
                            $sectors_filter = '';

                            foreach($sectorsearchArray as $word){
                                $word =trim($word);
//                                $sector_sql[] = " sector_business LIKE '$word%' ";
                                                $sector_sql[] = " sector_business = '$word' ";
                                                $sector_sql[] = " sector_business LIKE '$word(%' ";
                                                $sector_sql[] = " sector_business LIKE '$word (%' ";
                                $sectors_filter.= $word.',';
                            }
                            $sectors_filter = trim($sectors_filter,',');
                            $sector_filter = implode(" OR ", $sector_sql);
                            
                            
				$yourquery=1;
        			$industry=array();
				$stagevaluetext="";
				$datevalueDisplay1="";
                                 $datevalueCheck1="";
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
                                
				 $companysql="SELECT pe.PECompanyId as companyid, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,
				pe.amount, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,
				pec.website, pec.city, pec.region,pe.PEId,
				pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,SPV,AggHide,dates as dates,
                                 GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor FROM peinvestments AS pe, industry AS i,
				pecompanies AS pec,stage as s,peinvestments_dbtypes as pedb,
                                         peinvestments_investors as peinv_inv,peinvestors as inv
				WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and
                                pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND  ($sector_filter)
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId  ";
                                $orderby="sector_business";
                                $ordertype="asc";
                                
                                
			//	echo "<br>Query for company search";
		// echo "<br> Company search--" .$companysql;
			}
			elseif($keyword!="")
			{
                            $yourquery=1;
                            $industry=array();
                            $stagevaluetext="";
                            $datevalueDisplay1="";
                            $datevalueCheck1="";
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";

                            /*$companysql="select peinv.PEId,peinv.PECompanyId,peinv.StageId,pec.countryid,pec.industry,
                            peinv_inv.InvestorId,peinv_inv.PEId,
                            pec.companyname,i.industry,sector_business,peinv.amount,peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
                            DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,pec.website,pec.city,r.Region,MoreInfor,
                            hideamount,hidestake,c.country, GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor,Link,pec.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status
                            from peinvestments_investors as peinv_inv,peinvestors as inv,
                            peinvestments as peinv,pecompanies as pec,industry as i,stage as s,country as c,investortype as it,region as r ,peinvestments_dbtypes  as pedb
                            where dates between '" . $dt1. "' and '" . $dt2 . "' and  inv.InvestorId=peinv_inv.InvestorId and pec.industry = i.industryid and
                             s.StageId=peinv.StageId and c.countryid=pec.countryid and it.InvestorType=peinv.InvestorType and AggHide=0 and peinv.Deleted=0  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                            and peinv.PEId=peinv_inv.PEId and r.RegionId=pec.RegionId
                            and pec.PECompanyId=peinv.PECompanyId " .$addVCFlagqry." ".$addDelind." AND inv.InvestorId IN($keyword)
                                            and peinv_inv.PEId=peinv.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY peinv.PEId ";*/
                                if($incubation_from == "yes"){
                                $companysql="select peinv.PEId,peinv.PECompanyId,peinv.StageId,pec.countryid,pec.industry,
                            peinv_inv.InvestorId,peinv_inv.PEId,
                            pec.companyname,i.industry,sector_business,peinv.amount,peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
                            DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,pec.website,pec.city,r.Region,MoreInfor,
                            hideamount,hidestake,c.country, (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv 
                                            WHERE peinv_inv.PEId=peinv.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor FROM peinvestments AS peinv, pecompanies as pec,industry AS i,stage as s,country as c,investortype as it,region as r , 
                                    peinvestments_dbtypes as pedb, peinvestments_investors as peinv_inv,peinvestors as inv WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and  inv.InvestorId=peinv_inv.InvestorId and pec.industry = i.industryid and
                             s.StageId=peinv.StageId and c.countryid=pec.countryid and it.InvestorType=peinv.InvestorType and AggHide=0 and peinv.Deleted=0  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                            and peinv.PEId=peinv_inv.PEId and r.RegionId=pec.RegionId
                            and pec.PECompanyId=peinv.PECompanyId " .$addVCFlagqry." ".$addDelind." AND inv.Investor like '$keyword'
                                            and peinv_inv.PEId=peinv.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY peinv.PEId ";
                            $orderby="companyname";
                                }else{
                                $companysql="select peinv.PEId,peinv.PECompanyId,peinv.StageId,pec.countryid,pec.industry,
                            peinv_inv.InvestorId,peinv_inv.PEId,
                            pec.companyname,i.industry,sector_business,peinv.amount,peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
                            DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,pec.website,pec.city,r.Region,MoreInfor,
                            hideamount,hidestake,c.country, (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv 
                                            WHERE peinv_inv.PEId=peinv.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor FROM peinvestments AS peinv, pecompanies as pec,industry AS i,stage as s,country as c,investortype as it,region as r , 
                                    peinvestments_dbtypes as pedb, peinvestments_investors as peinv_inv,peinvestors as inv WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and  inv.InvestorId=peinv_inv.InvestorId and pec.industry = i.industryid and
                             s.StageId=peinv.StageId and c.countryid=pec.countryid and it.InvestorType=peinv.InvestorType and AggHide=0 and peinv.Deleted=0  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                            and peinv.PEId=peinv_inv.PEId and r.RegionId=pec.RegionId
                            and pec.PECompanyId=peinv.PECompanyId " .$addVCFlagqry." ".$addDelind." AND inv.InvestorId IN($keyword)
                                            and peinv_inv.PEId=peinv.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY peinv.PEId ";
                            $orderby="companyname";
                                    
                                }
                            $ordertype="asc";
			//echo "<br> Investor search- ".$companysql;
			}
			elseif($advisorsearchstring_legal!="")
			{
				$yourquery=1;
				$industry=array();
				$stagevaluetext="";
				$datevalueDisplay1="";
                                 $datevalueCheck1="";
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
			$companysql="(
				SELECT pe.PEId,pe.PECompanyId, pec.companyname, i.industry, pec.sector_business as sector_business, pe.amount, cia.CIAId, cia.Cianame,
                                 adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,
                                 GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor
				FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac,stage as s ,peinvestments_dbtypes as pedb,
                                peinvestments_investors as peinv_inv,peinvestors as inv
				WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and  pe.Deleted=0 and pec.industry = i.industryid
				AND pec.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
				and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND adac.PEId = pe.PEId " .$addVCFlagqry. " ".$addDelind." 
				AND cia.cianame LIKE '%$advisorsearchstring_legal%' and AdvisorType='L'  
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId 
				)
				UNION (
				SELECT pe.PEId,pe.PECompanyId, pec.companyname, i.industry, pec.sector_business as sector_business, pe.amount, cia.CIAId, cia.Cianame,
                                 adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,
                                 GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor
				FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac,stage as s,peinvestments_dbtypes as pedb,
                                peinvestments_investors as peinv_inv,peinvestors as inv
				WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and pe.Deleted=0 and pec.industry = i.industryid
				AND pec.PECompanyId = pe.PECompanyId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
				AND adac.PEId = pe.PEId " .$addVCFlagqry. " ".$addDelind." 
				AND cia.cianame LIKE '%$advisorsearchstring_legal%' and AdvisorType='L' 
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId 
				)  ";
                        $orderby="companyname";
                        $ordertype="asc";
			
			}
			elseif($advisorsearchstring_trans!="")
			{
				$yourquery=1;
				$industry=array();
				$stagevaluetext="";
                                 $datevalueCheck1="";
				$datevalueDisplay1="";
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
			$companysql="(
				SELECT pe.PEId,pe.PECompanyId, pec.companyname, i.industry, pec.sector_business as sector_business, pe.amount, cia.CIAId, cia.Cianame,
                                 adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,
                                 GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor
				FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac,stage as s ,peinvestments_dbtypes as pedb,
                                peinvestments_investors as peinv_inv,peinvestors as inv
				WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and  pe.Deleted=0 and pec.industry = i.industryid
				AND pec.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
				and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND adac.PEId = pe.PEId " .$addVCFlagqry. " ".$addDelind." 
				AND cia.cianame LIKE '%$advisorsearchstring_trans%' and AdvisorType='T'
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId 
				)
				UNION (
				SELECT pe.PEId,pe.PECompanyId, pec.companyname, i.industry, pec.sector_business as sector_business, pe.amount, cia.CIAId, cia.Cianame,
                                 adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,
                                 GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor
				FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac,stage as s,peinvestments_dbtypes as pedb,
                                peinvestments_investors as peinv_inv,peinvestors as inv
				WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and pe.Deleted=0 and pec.industry = i.industryid
				AND pec.PECompanyId = pe.PECompanyId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
				AND adac.PEId = pe.PEId " .$addVCFlagqry. " ".$addDelind." 
				AND cia.cianame LIKE '%$advisorsearchstring_trans%' and AdvisorType='T'  and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId 
				)  ";
                        $orderby="companyname";
                        $ordertype="asc";
//                        	echo "<br>-".$companysql;
			}
                elseif ((count($industry) > 0) || (count($round) > 0) || ($city != "") || ($debt_equity!="--") || ($investorType != "--") || ($syndication!="--") || (count($regionId)>0)  || ($startRangeValue == "--") || ($endRangeValue == "--") || ( ($exitstatusValue!='' && count($exitstatusValue) > 0)) || (($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--")) .$checkForStageValue)
                        {
                                $yourquery=1;

                                if(($year1<2004) && ($year2>=2004))
                                {
                                   $exportdt1="2004-".$month1."-01";
                                   $exportdt2 = $year2."-".$month2."-01";
                                }
                                elseif(($year1<2004)&&($year2< 2004))
                                {
                                   //$exportFlag="N";
                                   $exportdt1 = "--------";
                                   $exportdt2= "--------";
                                }
                                elseif(($year1>=2004)&&($year2>=2004))
                                {

                                        $exportdt1 = $year1."-".$month1."-01";
                                        $exportdt2 = $year2."-".$month2."-01";
                                }
                                elseif(($year1>=2004)&&($year2<2004))
                                {

                                   $exportdt1 = "------01";
                                   $exportdt2= "------01";
                                }
                                // if($year2<2004)
                                //   $exportdt2="2004-".$month2."-01";
                               // else
                                //   $exportdt2 = $year2."-".$month2."-01";
                                //echo "<BR>DATE1---" .$dt1;
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-01";
                                $companysql = "select pe.PECompanyID as companyid,pec.companyname,pec.industry,i.industry,
                                pec.sector_business as sector_business,amount,round,s.stage,stakepercentage,DATE_FORMAT(dates,'%b-%Y') as dealperiod,
                                pec.website,pec.city,pec.region,pe.PEId,pe.comment,MoreInfor,hideamount,hidestake,pe.StageId,SPV,pec.RegionId,AggHide,dates as dates,
                                GROUP_CONCAT( inv.Investor ORDER BY Investor='others') AS Investor,count(inv.Investor) AS Investorcount
                                from peinvestments as pe, industry as i,pecompanies as pec,stage as s,peinvestments_dbtypes as pedb,
                                peinvestments_investors as peinv_inv,peinvestors as inv where ".$valuationsql;
                        //	echo "<br> individual where clauses have to be merged ";

                //	echo "<br> WHERE IND--" .$whereind;
                               if (count($industry) > 0)
                               {
                                    $indusSql = '';
                                    foreach($industry as $industrys)
                                    {
                                        $indusSql .= " pec.industry=$industrys or ";
                                    }
                                    $indusSql = trim($indusSql,' or ');
                                    if($indusSql !=''){
                                        $whereind = ' ( '.$indusSql.' ) ';
                                    }
                                       $qryIndTitle="Industry - ";
                               }
                               
                                // Round
                                    if(count($round) > 0 && $round !="")
                                    {
                                    $roundSql = '';
                                    foreach($round as $rounds)
                                    {
                                        $roundSql .= " pe.round LIKE '".$rounds."%' or ";
                                    }
                                    if($roundSql !=''){
                                        $whereRound=  '('.trim($roundSql,' or ').')';
                                        //$whereRound="pe.round LIKE '".$round."'";
                                    }
                                }
                                //$debt_equity
                                
                                if($debt_equity!="--" && $debt_equity!="")
                                {  $whereSPVdebt=" pe.SPV='".$debt_equity."'"; }
                                
                               if($syndication!="--" && $syndication!="" ){
                                                    
                                        if($syndication==0){
                                            $wheresyndication=" Having Investorcount > 1";
                                        }
                                        else{
                                            $wheresyndication=" Having Investorcount <= 1";
                                        }


                                    }
                               if (count($regionId) > 0)
                               {
                                    $region_Sql = '';
                                    foreach($regionId as $regionIds)
                                    {
                                        $region_Sql .= " pec.RegionId =$regionIds or ";
                                    }
                                    $roundSqlStr = trim($region_Sql,' or ');
                                       $qryRegionTitle="Region - ";
                                    if($roundSqlStr !=''){
                                        $whereregion = ' ( '.$roundSqlStr.' ) ';
                                       }
                                }
                       //	echo " <bR> where REGION--- " .$whereregion;
                                // City
                                if($city != "")
                                {
                                    $whereCity=" pec.city LIKE '".$city."%'";
                                }
                                
                       
                               if ($investorType!= "--")
                               {
                                       $qryInvType="Investor Type - " ;
                                       $whereInvType = " pe.InvestorType = '".$investorType."'";
                               }
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
                       //	echo "<br>Where stge---" .$wherestage;
                               
                                  if( ($startRangeValue>0 && $endRangeValue=="--") || ($startRangeValue > $endRangeValue) || ($startRangeValue == $endRangeValue) )
                                                {
                                                     $endRangeValue=$endRangeValueDisplay=2000;
                                                }
                                                
                               
                               
                               
                               if (($startRangeValue!= "--") && ($endRangeValue != ""))
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
                               else if($startRangeValue== "--" && $endRangeValue >0 )
                                                {
                                                    $startRangeValue=0;
                                                    $endRangeValue=$endRangeValue-0.01;
                                                    $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";                                     
                                                }
                                if($exitstatusValue!='' && count($exitstatusValue) >0){
                                            foreach($exitstatusValue as $exitstatusValues)
                                            {
                                                $exitstatusSql .= " Exit_Status  = '".$exitstatusValues."' or ";
                                            }
                                            $whereexitstatus = trim($exitstatusSql,' or ');
                                            if($whereexitstatus !=''){
                                                $whereexitstatus = '('.$whereexitstatus.')';
                                            }
                                            $exitstatusValue_hide = implode($exitstatusValue,',');
                                        }                
                               if(($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                               {
                                       $qryDateTitle ="Period - ";
                                       $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";

                               }
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
                                if (($whereregion != "") )
                                        {
                                //		echo "<br>TRUE";
                                        $companysql=$companysql . $whereregion . " and " ;
                                                $aggsql=$aggsql . $whereregion ." and ";
                                //	echo "<br>----comp sql after region-- " .$companysql;
                                        $bool=true;
                                        }
                                if (($wherestage != ""))
                                        {
                                        //	echo "<BR>--STAGE" ;
                                                $companysql=$companysql . $wherestage . " and " ;
                                                $aggsql=$aggsql . $wherestage ." and ";
                                                $bool=true;
                                        //	echo "<br>----comp sql after stage-- " .$companysql;
                                        }
                                
                                // moorthi
                                if($whereRound !="")
                                {
                                    $companysql=$companysql.$whereRound." and ";
                                }

                                if($whereCity !="")
                                {
                                    $companysql=$companysql.$whereCity." and ";
                                }
                                //
                                if($whereSPVdebt!="")
                                { 
                                    $companysql=$companysql .$whereSPVdebt ." and "; 

                                }
                                        
                                if (($whereInvType != "") )
                                        {
                                                $companysql=$companysql .$whereInvType . " and ";
                                                $aggsql = $aggsql . $whereInvType ." and ";
                                                $bool=true;
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
                                if($whereexitstatus!=""){
                                            
                                            $companysql=$companysql .$whereexitstatus . " and ";
                                            $aggsql=$aggsql .$whereexitstatus . " and ";
                                            $bool=true;
                                            
                                }

                                //the foll if was previously checked for range
                                if($whererange  !="")
                                {       //pe.hideamount=0
                                        $companysql = $companysql . " i.industryid=pec.industry and
                                        pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                        and pe.Deleted=0 " . $addVCFlagqry . " ".$addDelind." and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId ";
                                        $orderby="companyname";
                                        $ordertype="asc";
                                //	echo "<br>----" .$whererange;
                                }
                                elseif($whererange="--")
                                {
                                        $companysql = $companysql . "  i.industryid=pec.industry and
                                        pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                        and pe.Deleted=0 " .$addVCFlagqry. " ".$addDelind." and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId ";
                                        $orderby="companyname";
                                        $ordertype="asc";
                                //	echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
                                }
                                if($wheresyndication!=''){
                                            
                                    $companysql = $companysql .$wheresyndication;
                                }
                        }
			
			else
				{
					echo "<br> INVALID DATES GIVEN ";
					$fetchRecords=false;
				}
         $ajaxcompanysql=  urlencode($companysql);
       if($companysql!="" && $orderby!="" && $ordertype!="")
          $companysql = $companysql . " order by  dates desc,companyname asc "; 
	
	//END OF POST
       
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

       echo "<div style='display:none'>".$companysql;
       echo "</div>";
	$topNav = 'Deals';
        $defpage=$VCFlagValue;
        $investdef=3;
        $stagedef=3;
        $indef=1;
	include_once('tvheader_search.php');
?>
<div id="container">
  
    <table cellpadding="0" cellspacing="0" width="100%">


    <td class="left-td-bg" >
        <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
    
    <div id="panel" style="display:block; overflow:visible; clear:both;">
 <?php include_once('svrefine.php'); ?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>	
</div>
        </div>
</td>        
 <?php
                        $exportToExcel=0;
                        $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,dealmembers as dm
										where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
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
                                if ($companyrsall = mysql_query($companysql))
                                {
                                    $company_cntall = mysql_num_rows($companyrsall);
                                }
                                
                                if($company_cntall > 0)
                                {
                                 $rec_limit = 50;
                                 $rec_count = $company_cntall;

                                if( isset($_GET{'page'} ) )
                                {
                                   $currentpage=$page;
                                   $page = $_GET{'page'} + 1;
                                   $offset = $rec_limit * $page ;
                                }
                                else
                                {
                                    $currentpage=1;
                                   $page = 1;
                                   $offset = 0;
                                }
                                 $companysqlwithlimit=$companysql." limit $offset, $rec_limit";
                                 if ($companyrs = mysql_query($companysqlwithlimit))
                                 {
                                     $company_cnt = mysql_num_rows($companyrs);
                                 }
                                             //$searchTitle=" List of Deals";
                                }
                                else
                                {
                                     $searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
                                     $notable=true;
                                     writeSql_for_no_records($companysqlall,$emailid);
                                }

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
            <div class="filter-key-result">  
                <div style="float: left; margin: 20px 10px 0px 0px;font-size: 20px;">
                    <a  class="help-icon tooltip"><strong>Note</strong>
                        <span>
                        <img class="showtextlarge" src="images/callout.gif">
                        Target/Company in () indicates the deal is not to be used for calculating aggregate data owing to the it being a tranche / not meeting Venture Intelligence definitions for PE.
                          Target/Company in [] indicates a debt investment. Not included in aggregate data.

                        </span>
                    </a> 
                </div>
                <div class="lft-cn">          
                <?php   if(!$_POST)
                        { ?> 
                                        
                            <ul class="result-select" style="border: 1px solid #BFA074;">  
                                <?php
                                 if($datevalueDisplay1!=""){  
                                ?>
                                <li> 
                                <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                else if($datevalueCheck1 !="")
                                {
                                ?>
                                <li style="padding:1px 10px 1px 10px;"> 
                                <?php echo $datevalueCheck1. "-" .$datevalueCheck2;?>
                                </li>
                                <?php 
                                }
                                ?>
                                <?php
                                if($valuationstxt!=""){  ?>

                                <li> 
                                <?php echo str_replace('_', ' ', $valuationstxt);?><a  onclick="resetinput('valuations');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>

                                <?php } ?>
                            </ul>
                        <?php  
                        }else 
                        { ?>
                    
                        <div class="title-links " id="export-btn"></div>
                            <ul class="result-select" style="border: 1px solid #BFA074;">
                                <?php
                                 //echo $queryDisplayTitle;
                                if(count($industry) >0 && $industry!=null && $industry!=""){ $drilldownflag=0; ?>
                                <li>
                                <?php echo $industryvalue; ?><a  onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                if($stagevaluetext!="" && $stagevaluetext!=null) { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $stagevaluetext ?><a  onclick="resetinput('stage');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                 <!-- Round -->
                                <?php }  
                                if(count($round) > 0 && $round!=null && $roundTxtVal !=''){ $drilldownflag=0; ?>
                                <li> 
                                <?php echo $roundTxtVal; ?><a  onclick="resetinput('round');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <!-- -->
                                <?php }  
                                if($investorType !="--" && $investorType!=null && $investorType!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $invtypevalue; ?><a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 

                                if($debt_equity!="--" && $debt_equity!=null) { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo  $debt_equityDisplay;?><a  onclick="resetinput('dealtype_debtequity');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($syndication!="--" && $syndication!=null) { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo  $syndication_Display;?><a  onclick="resetinput('syndication');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if(count($regionId)>0 && $regionId!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $regionvalue; ?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                 <!-- City -->
                                <?php }    
                                if($city!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $city; ?><a  onclick="resetinput('city');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <!-- -->
                                <?php }    
                                if (($startRangeValue!= "--" && $endRangeValue != "") || ($startRangeValue== "--" && $endRangeValue >0 ) ){$drilldownflag=0; ?>
                                <li> 
                                    <?php echo "(USM)".$startRangeValue ."-" .$endRangeValueDisplay ?><a  onclick="resetinput('range');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 

                                if($valuationstxt!=""){  ?>

                                <li> 
                                <?php echo str_replace('_', ' ', $valuationstxt);?><a  onclick="resetinput('valuations');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>

                                <?php }
                                if($datevalueDisplay1!=""){  
                                         ?>
                                        <li> 
                                          <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                <?php }
                                else if($datevalueCheck1 !="")
                                {
                                ?>
                                    <li style="padding:1px 10px 1px 10px;"> 
                                      <?php echo $datevalueCheck1. "-" .$datevalueCheck2;?>
                                    </li>
                                <?php 
                                }
                                else if(trim($_POST['searchallfield'])!="" || trim($_POST['searchKeywordLeft'])!="" || trim($_POST['keywordsearch'])!="" || trim($_POST['sectorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="" )
                                 {

                                 ?>
                                 <li style="padding:1px 10px 1px 10px;"> 
                                    <?php echo $sdatevalueDisplay1. "-" .$edatevalueDisplay2;?>
                                </li>
                                <?php
                                }
                                if($keyword!=" " && $keyword!="") { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $invester_filter;?><a  onclick="resetinput('keywordsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($companysearch!=" " && $companysearch!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $companyauto?><a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($sectorsearch!=" " && $sectorsearch!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo  str_replace("'","",trim($sectorsearch))?><a  onclick="resetinput('sectorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  
                                if($advisorsearchstring_legal!=" " && $advisorsearchstring_legal!="") { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $advisorsearchstring_legal?><a  onclick="resetinput('advisorsearch_legal');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($advisorsearchstring_trans!=" " && $advisorsearchstring_trans!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $advisorsearchstring_trans?><a  onclick="resetinput('advisorsearch_trans');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  if($searchallfield!="" && $searchallfield!=" "){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $searchallfield?><a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                if(count($exitstatusValue) > 0){
                                    foreach($exitstatusValue as $exitstatusValues)
                                    {
                                        if($exitstatusValues==1){

                                            $exitstatusfilter .= 'Unexited, ';

                                        }
                                        else if($exitstatusValues==2){

                                            $exitstatusfilter .= 'Partially Exited, ';

                                        }
                                        else if($exitstatusValues==3){

                                            $exitstatusfilter .= 'Fully Exited, ';

                                        }else {
                                            $exitstatusfilter = '';
                                        }
                                    }
                                    $exitstatusfilter = trim($exitstatusfilter,', ');
                                }
                                if($exitstatusfilter!=''){ ?>
                                <li> 
                                   <?php echo $exitstatusfilter; ?><a  onclick="resetinput('exitstatus');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php  } 
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
                                if($cl_count ==1 || $cl_count ==3 || $cl_count >= 6)
                                {
                                ?>
                                <li class="result-select-close"><a href="svindex.php?value=<?php echo $VCFlagValue; ?>"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
                                <?php
                                }
                                ?>
                            </ul>
                           
                    <?php } ?>
                           <!-- <div class="alert-note">Note: Target/Company in () indicates tranche rather than a new round. Target/Company in [] indicates a debt investment.        
                            </div>-->
                            
                </div>
                <div class='result-rt-cnt'>     
                    <div class="result-count">
                    <?php if(!$_POST)
                            { ?> 
                                <h2>
                            <?php  
                                if($studentOption==1)
                                {
                                ?>
                                 <span class="result-no" id="resultcount"> Results Found</span>  
                                 <?php
                                }
                                else
                                {
                            ?> 
                                       <span class="result-no" id="resultcount">  Results Found</span> 
                            <?php
                                     
                                }
                            ?>  
                            <?php  if($VCFlagValue==3)
                                    {
                            ?>     
                                    <span class="result-for" >  for Social Venture Investments</span>

                            <?php   }
                                elseif($VCFlagValue==4)
                                {?>
                                       <span class="result-for">  for Cleantech Investments</span>
                            <?php }
                                else
                                {?>
                                       <span class="result-for">  for Infrastructure Investments</span>

                            <?php } ?>
                                    <span class="result-amount"></span>
                                        <span class="result-amount-no" id="show-total-amount"></span> 
                                </h2>
                                <?php if($VCFlagValue==3 || $VCFlagValue==5) {?>
                                 <a href="#popup1" class="help-icon tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
                                      <span>
                                      <img class="callout" src="images/callout.gif">
                                      <strong>Definitions
                                      </strong>
                                      </span>
                                </a> <?php } ?>
                        
                                <div class="title-links " id="export-btn"></div>
                                        
                                <?php  
                            }
                                
                                   else 
                                   { ?>           
                                       <h2>
                                       <?php  
                                        if($studentOption==1)
                                        {
                                        ?>
                                         <span class="result-no" id="resultcount"> Results Found</span>  
                                         <?php
                                        }
                                        else
                                        {
                                             ?> 
                                               <span class="result-no" id="resultcount"> Results Found</span> 
                                             <?php
                                            
                                        }
                                        ?>    
                                      <?php if($VCFlagValue==3)
                                       {
                                         ?>    
                                               <span class="result-for">  for Social Venture Investments</span>
                                                <span class="result-amount"></span>
                                             <span class="result-amount-no" id="show-total-amount"></span>
                                               </h2>
                                  <?php }
                                        elseif($VCFlagValue==4)
                                        {?>
                                               <span class="result-for">  for Cleantech Investments</span>
                                                <span class="result-amount"></span>
                                             <span class="result-amount-no" id="show-total-amount"></span>
                                            </h2>
                                  <?php }
                                  else
                                          {?>
                                               <span class="result-for">  for Infrastructure Investments</span>
                                                <span class="result-amount"></span>
                                             <span class="result-amount-no" id="show-total-amount"></span>
                                            </h2>
<!--                                            <a href="#popup1" class="help-icon tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
                                                 <span>
                                                 <img class="callout" src="images/callout.gif">
                                                 <strong>Definitions
                                                 </strong>
                                                 </span>
                                            </a>-->
                                  <?php }    ?>   
                                       
                                            <?php if($VCFlagValue==3 || $VCFlagValue==5) {?>
                                            <a href="#popup1" class="help-icon tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
                                                 <span>
                                                 <img class="callout" src="images/callout.gif">
                                                 <strong>Definitions
                                                 </strong>
                                                 </span>
                                           </a> <?php } ?> 
                           
                                  <?php } ?>
                    
                </div>
            </div>
            </div>
            <?php
                if($notable==false)
                { 
            ?>
                       <!-- <div class="veiw-tab"><ul>
                              <li class="active"><a href="svtrendview.php?type=1&value=0"><i class="i-trend-view"></i>Trend View</a></li>
                        <li ><a  href="index.php?value=<?php echo $vcflagValue; ?>"><i class="i-list-view"></i>List View</a></li> 
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
                        </ul></div>	-->
    	
        
          <!--<div class="list-tab">
                       
                       
                       
                       <ul>
                        <li class="active"><a class="postlink"   href="svindex.php?type=<?php echo $type; ?>&value=<?php echo $VCFlagValue; ?>"  id="icon-grid-view"><i></i> List  View</a></li>
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
                        <li><a id="icon-detailed-view" class="postlink" href="dealdetails.php?value=<?php echo $comid;?>/<?php echo $VCFlagValue;?>/<?php echo $searchallfield;?>" ><i></i> Detail  View</a></li> 
                        </ul></div>-->
                        <?php  // echo "count - $company_cntall"; exit;
                                $cos_array = $cos_withdebt_array = array();
                                 if($_SESSION['coscount']){ unset($_SESSION['coscount']); }
                                 if($_SESSION['totalcount']){ unset($_SESSION['totalcount']); }
                                 
						if ($company_cntall>0)
						  {
						  	$hidecount=0;
							//Code to add PREV /NEXT
							$icount = 0;
							if ($_SESSION['resultId']){ 
                                                        unset($_SESSION['resultId']); }
                                                        
                                                         if ($_SESSION['resultCompanyId']) {
                                                         unset($_SESSION['resultCompanyId']); }
                                                         
							mysql_data_seek($companyrsall,0);
						   While($myrow=mysql_fetch_array($companyrsall, MYSQL_BOTH))
							{
                                                               //SPV changed to AggHide
                                                               if($myrow["AggHide"]==0 && $myrow["SPV"]==0){
                                                                    $cos_array[]=$myrow["companyid"];
                                                               }
                                                               $amtTobeDeductedforAggHide=0;
                                                               $prd=$myrow["dealperiod"];
                                                                $cos_withdebt_array[]=$myrow["companyid"];
								if($myrow["AggHide"]==1)
								{
									$amtTobeDeductedforAggHide=$myrow["amount"];
									$NoofDealsCntTobeDeducted=1;
								}
								else
								{
									$amtTobeDeductedforAggHide=0;
									$NoofDealsCntTobeDeducted=0;
								}
                                                                if($myrow["SPV"]==1)          //Debt
								{
									$amtTobeDeductedforDebt=$myrow["amount"];
									$amtTobeDeductedforAggHide= $myrow["amount"];
									$NoofDealsCntTobeDeductedDebt=1;
									$NoofDealsCntTobeDeducted=1;
								}
								else
								{
									$amtTobeDeductedforDebt=0;
									$NoofDealsCntTobeDeductedDebt=0;
								}
								if($myrow["hideamount"]==1)
								{
									$hideamount="--";
									$hidecount=$hidecount+1;
								}
								else
								{
									$hideamount=$myrow["amount"];
								}
								if($myrow["hideamount"]==1)
								{
									$hideamount="--";
									$hidecount=$hidecount+1;
								}
								else
								{
									$hideamount=$myrow["amount"];
								}
								$companyName=trim($myrow["companyname"]);
								$companyName=strtolower($companyName);
								$compResult=substr_count($companyName,$searchString);
								$compResult1=substr_count($companyName,$searchString1);
								if(($compResult==0) && ($compResult1==0))
								{
                                                                    //Session Variable for storing Id. To be used in Previous / Next Buttons
                                                                    $_SESSION['resultId'][$icount] = $myrow["PEId"];

                                                                    $_SESSION['resultCompanyId'][$icount] = $myrow["companyid"];

                                                                    $icount++;
								}
								$industryAdded = $myrow[2];
								/*$totalInv=$totalInv+1-$NoofDealsCntTobeDeducted;
								$totalAmount=$totalAmount+ $myrow["amount"]-$amtTobeDeductedforAggHide;*/
                                                                if($debt_equity == 1){
                                                                    $totalInv=$totalInv+1;   
                                                                //    print_r($cos_withdebt_array);
                                                                    $cos_array = $cos_withdebt_array;
                                                                    $totalAmount=$totalAmount+ $myrow["amount"];
                                                                }else{
                                                                    $totalInv=$totalInv+1-$NoofDealsCntTobeDeducted;
                                                                    $totalAmount=$totalAmount+ $myrow["amount"]-$amtTobeDeductedforAggHide;
                                                                }

							}
                                                       
						}
                                               
                                               $_SESSION['coscount'] = $total_cos = count(array_count_values($cos_array));
                                               $_SESSION['totalcount'] = $totalInv;
                                        ?>
    
          <a id="detailpost" class="postlink"></a>               
        <div class="view-table view-table-list">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
              <thead><tr>
                <th class="header <?php echo ($orderby=="companyname")?$ordertype:""; ?>" id="companyname">Company</th>
                <th class="header <?php echo ($orderby=="sector_business")?$ordertype:""; ?>" id="sector_business">Sector</th>
                 <th style="width: 260px;" class="header <?php echo ($orderby=="investor")?$ordertype:""; ?>" id="investor">Investor</th>
                <th style="width: 180px;" class="header <?php echo ($orderby=="dates")?$ordertype:""; ?>" id="dates">Date</th>
                <th class="alignr header asc <?php echo ($orderby=="amount")?$ordertype:""; ?>" id="amount">Amount(US$M)</th>
                </tr></thead>
              <tbody id="movies">
						<?php
						if ($company_cnt>0)
						  {
						  	$hidecount=0;
							mysql_data_seek($companyrs,0);
						   While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                                                    {
                                                           //SPV changed to AggHide
                                                           $amtTobeDeductedforAggHide=0;
                                                           $prd=$myrow["dealperiod"];
                                                            if($myrow["AggHide"]==1)
                                                            {
                                                                    $openBracket="(";
                                                                    $closeBracket=")";
                                                                    $amtTobeDeductedforAggHide=$myrow["amount"];
                                                                    $NoofDealsCntTobeDeducted=1;
                                                            }
                                                            else
                                                            {
                                                                    $openBracket="";
                                                                    $closeBracket="";
                                                                    $amtTobeDeductedforAggHide=0;
                                                                    $NoofDealsCntTobeDeducted=0;
                                                            }
                                                            if($myrow["SPV"]==1)          //Debt
                                                            {
                                                                    $openDebtBracket="[";
                                                                    $closeDebtBracket="]";
                                                                    $amtTobeDeductedforDebt=$myrow["amount"];
                                                                    $amtTobeDeductedforAggHide= $myrow["amount"];
                                                                    $NoofDealsCntTobeDeductedDebt=1;
                                                                    $NoofDealsCntTobeDeducted=1;
                                                            }
                                                            else
                                                            {
                                                                    $openDebtBracket="";
                                                                    $closeDebtBracket="";
                                                                    $amtTobeDeductedforDebt=0;
                                                                    $NoofDealsCntTobeDeductedDebt=0;
                                                            }

                                                            if(trim($myrow[17])=="")
                                                            {
                                                                    $compDisplayOboldTag="";
                                                                    $compDisplayEboldTag="";
                                                            }
                                                            else
                                                            {
                                                                    $compDisplayOboldTag="<b><i>";
                                                                    $compDisplayEboldTag="</b></i>";
                                                            }
                                                            if($myrow["hideamount"]==1)
                                                            {
                                                                    $hideamount="--";
                                                                    $hidecount=$hidecount+1;
                                                            }
                                                            else
                                                            {
                                                                    $hideamount=$myrow["amount"];
                                                            }
                                                            if($myrow["hideamount"]==1)
                                                            {
                                                                    $hideamount="--";
                                                                    $hidecount=$hidecount+1;
                                                            }
                                                            else
                                                            {
                                                                    $hideamount=$myrow["amount"];
                                                            }
                                                            //if(($vcflagValue==0)||($vcflagValue==1))
                                                            //{
                                                                    if(trim($myrow["sector_business"])=="")
                                                                            $showindsec=$myrow["industry"];
                                                                    else
                                                                            $showindsec=$myrow["sector_business"];
                                                            //}

                                                            $companyName=trim($myrow["companyname"]);
                                                            $companyName=strtolower($companyName);
                                                            $compResult=substr_count($companyName,$searchString);
                                                            $compResult1=substr_count($companyName,$searchString1);

                                       ?>  
                                                    <tr class="details_link" valueId="<?php echo $myrow["PEId"];?>/<?php echo $vcflagValue;?>">

                                            <?php
                                                            if(($compResult==0) && ($compResult1==0))
                                                            {
                                            ?>
                                                            <td ><?php  echo $openDebtBracket;?><?php echo $openBracket ; ?><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?> "><?php echo trim($myrow["companyname"]);?> </a> <?php echo $closeBracket ; ?><?php echo $closeDebtBracket;?></td>
                                            <?php
                                                            }
                                                            else
                                                            {
                                            ?>
                                                            <td><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?> "><?php echo ucfirst("$searchString");?></a></td>
                                            <?php
                                                            }
                                            ?>

                                                                            <td><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?> "><?php echo trim($showindsec);?></a></td>
                                                                            <td><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?> "><?php echo $myrow["Investor"];?></a></td>
                                                                            <td><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?> "><?php echo $prd; ?></a></td>
                                                                            <td><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?> "><?php echo $hideamount; ?>&nbsp;</a></td>

                                                    </tr>
                                                    <?php

                                                    }
						}
						?>
                        </tbody>
                  </table>
            
                </div>	
            <div class="holder">
                 <?php
                    $totalpages=  ceil($company_cntall/$rec_limit);
                    $firstpage=1;
                    $lastpage=$totalpages;
                    $prevpage=(( $currentpage-1)>0)?($currentpage-1):1;
                    $nextpage=(($currentpage+1)<$totalpages)?($currentpage+1):$totalpages;
                 ?>
                 
                  <?php
                    $pages=array();
                    $pages[]=1;
                    $pages[]=$currentpage-2;
                    $pages[]=$currentpage-1;
                    $pages[]=$currentpage;
                    $pages[]=$currentpage+1;
                    $pages[]=$currentpage+2;
                    $pages[]=$totalpages;
                    $pages =  array_unique($pages);
                    sort($pages);
                 if($currentpage<2){
                 ?>
                 <a class="jp-previous jp-disabled" >&#8592; Previous</a>
                 <?php } else { ?>
                 <a class="jp-previous" >&#8592; Previous</a>
                 <?php } for($i=0;$i<count($pages);$i++){ 
                     if($pages[$i] > 0 && $pages[$i] <= $totalpages){
                ?>
                 <a class='<?php echo ($pages[$i]==$currentpage)? "jp-current":"jp-page" ?>'  ><?php echo $pages[$i]; ?></a>
                 <?php } 
                     }
                     if($currentpage<$totalpages){
                     ?>
                 <a class="jp-next">Next &#8594;</a>
                     <?php } else { ?>
                  <a class="jp-next jp-disabled">Next &#8594;</a>
                     <?php  } ?>
             </div>
            <?php
                }
                if($hidecount > 0)
                {
                        $totalAmount="--";
                }                                                    
		if($studentOption==1)
		{
		?>
                    <script type="text/javascript" >
                        $(document).ready(function(){
                       $("#resultcount").html('<?php echo $totalInv; ?> Results Found (across <?php echo $total_cos; ?> cos)');
                        $("#show-total-amount").html('<h2> Amount (US$ M) <?php  
                        if($totalAmount >0)
                        {
                            echo number_format(round($totalAmount));
                        }
                        else
                        {
                            echo "--";
                        } ?></h2>');
                        });
                    </script>
                    <?php

                    if($exportToExcel==1)
                    {
                    ?>
                        <script type="text/javascript" >
                             //$(document).ready(function(){
                             $("#export-btn").html(' <input type="button" class="export"  id="expshowdeals" value="Export" name="showdeals">');
                             //});
                         </script>
                        <span style="float:right" class="one">
                           <input type="button" class="export" id="expshowdealsbtn"  value="Export" name="showdeals">
                        </span>
                    <?php
                    }
		}
		else
		{
                    /*if($exportToExcel==1)
                    {*/
                    ?>
                        <script type="text/javascript" >
                            $(document).ready(function(){
                            $("#resultcount").html('<?php echo $totalInv; ?> Results Found (across <?php echo $total_cos; ?> cos)');
                            $("#show-total-amount").html('<h2> Amount (US$ M) <?php
                            if($totalAmount >0)
                            {
                                echo number_format(round($totalAmount));
                            }
                            else
                            {
                                echo "--";
                            }?></h2>');
                            });
                        </script>
                    <?php
                    /*}
                    else
                    {
                    ?>
                        <script type="text/javascript" >
                         $("#result-no").html('XXX Results found ');
                         $("#show-total-amount").html('<h2> Amount (US$ M) YYY</h2>');
                        </script>
                        <br><div><p>Aggregate data for each search result is displayed here for Paid Subscribers </p></div>
                    <?php
                    }*/

                    if(($totalInv>0) &&  ($exportToExcel==1))
                    {
            ?>
                        <script type="text/javascript" >
                            //$(document).ready(function(){
                            $("#export-btn").html(' <input type="button" class="export"  id="expshowdeals" value="Export" name="showdeals">');
                            //});
                        </script>
                        <span style="float:right" class="one">
                          <input type="button" class="export" id="expshowdealsbtn"  value="Export" name="showdeals">
                        </span>
            <?php
                    }
                    elseif(($totalInv>0) && ($exportToExcel==0))
                    {
            ?>
                           <span>
                            <p><b>Note:</b> Only paid subscribers will be able to export data on to Excel.Clicking Sample Export button for a sample spreadsheet containing PE investments.  </p>
                            <span style="float:right" class="one">
                                 <!--a class ="export" type="submit"  value="Export" name="showdeals"></a-->
                            <a class ="export" target="_blank" href="../Social_Inv_Sample.xls">Sample Export</a>
                            </span>
                            <script type="text/javascript">
                                        $('#export-btn').html('<a class="export"  href="../Social_Inv_Sample.xls">Export Sample</a>');
                            </script>
                            </span>
            <?php

                    }
		}
				?>
		</div>
                                                        
				<?php }
                elseif($buttonClicked=='Aggregate')
                {

                        $aggsql= $aggsql. " i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                        and  pe.Deleted=0 " .$addVCFlagqry.
                                                 " order by pe.amount desc,dates desc";
                        //	echo "<br>Agg SQL--" .$aggsql;
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
                                         if($stage!="")
                                   {
                                          $stageSql= "select Stage from stage where StageId=$stage";
                                          if($rsStage=mysql_query($stageSql))
                                          {
                                                  while($mystageRow=mysql_fetch_array($rsStage,MYSQL_BOTH))
                                                  {
                                                        $stageqryValue=$mystageRow["Stage"];
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
                                                $rangeqryValue= $rangeText;
                                        }
                                        if($wheredates !== "")
                                        {
                                                $dateqryValue= returnMonthname($month1) ." ".$year1 ." - ". returnMonthname($month2) ." " .$year2;
                                        }
                                        $searchsubTitle="";
                                        if(count($industry) > 0 && ($stage=="--") && ($range=="--") && ($wheredates==""))
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
                        if($stage !="")
                        {
                ?>
                                <?php echo $qryDealTypeTitle; ?><?php echo $stageqryValue; ?> <?php echo $spacing; ?>
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


 <div class="other_db_search">
            
         <div class="other_db_searchresult">
            <p class="other_loading">Please wait while we search for results in other databases<br><img  src="images/other_loading.gif"></p>
        </div>     
        </div>
 <div class="overview-cnt mt-trend-tab">
         
              <div class="showhide-link"><a href="#" class="show_hide <?php echo ($_GET['type']!='') ? '' : ''; ?>" rel="#slidingTable" id='ldtrend'><i></i>Trend View</a></div>
              
              <div  id="slidingTable" style="display: none;overflow:hidden;">  
                  
              <?php
              //include_once('svtrendview1.php');?> 
              <table width="100%">
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
                                            <td width="100%" class="profile-view-left" colspan="2">
                                        <div id="visualization2" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;"></div>   
                                        </td>
                                        </tr> 
                                        <?php
                                        }
                                        ?>
                            
                            <tr>
                             <td class="profile-view-left" colspan="2">
                                 <div class="showhide-link link-expand-table">
                                    <a href="#" class="show_hide" rel="#slidingDataTable">View Table</a>
                                 </div>
                                 <div class="view-table expand-table" id="slidingDataTable" style="display:none; overflow:hidden;">
                                    <div class="restable">
                                    	<table class="testTable1" cellpadding="0" cellspacing="0" id="restable">
											<tr><td>&nbsp;</td></tr>
                                        </table>
                                    </div>
                                 </div>
                             </td>
                            </tr>
                       </table>
            </div>
    	<?php  ?>
         </div>
</td>
</tr>
</table>
</div>
<div class=""></div>
</form> 
<?php if($_POST)
{
?>
<form name="pelisting" id="pelisting" method="post" action="exportsvinvdeals.php">
    <input type="hidden" name="txtsearchon" value="1" >
    <input type="hidden" name="txttitle" value=<?php echo $vcflagValue; ?> >
    <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
    <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
    <input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
    <input type="hidden" name="txthideinvestor" value=<?php echo $keywordhidden; ?> >
    <input type="hidden" name="txthidecompany" value=<?php echo $companysearchhidden; ?> >
    <input type="hidden" name="txthidesector" value="<?php echo $sectorsearchhidden; ?>" >
    <input type="hidden" name="txthideadvisor_legal" value=<?php echo $advisorsearchhidden_legal; ?> >
    <input type="hidden" name="txthideadvisor_trans" value=<?php echo $advisorsearchhidden_trans; ?> >
    <input type="hidden" name="txthideindustryid" value="<?php echo $industry_hide; ?>" >
    <input type="hidden" name="txthidestageval" value="<?php echo $stageval_hide; ?>" >
    <input type="hidden" name="txthideround" value="<?php echo $roundTxtVal; ?>">
                        <input type="hidden" name="txthidevaluation" value="<?php echo $valuationsql; ?> ">
    <input type="hidden" name="txthideregionid" value="<?php echo $region_hide; ?>" >
    <input type="hidden" name="txthidecity" value="<?php echo $city; ?>">
    <input type="hidden" name="txthidedateStartValue" value=<?php echo $startyear; ?> >
    <input type="hidden" name="txthidedateEndValue" value=<?php echo $endyear; ?> >
                        <input type="hidden" name="txthidedebt_equity" value=<?php echo $debt_equity; ?> >
    <input type="hidden" name="txthideinvestor" value=<?php echo $keywordhidden; ?> >
    <input type="hidden" name="txthideinvtypeid" value=<?php echo $investorType; ?> >
    <input type="hidden" name="txthiderangeStartValue" value=<?php echo $startRangeValue; ?>>
    <input type="hidden" name="txthiderangeEndValue" value=<?php echo $endRangeValueDisplay-0.01; ?> >
                        <input type="hidden" name="txthideexitstatusValue" value=<?php echo $exitstatusValue_hide; ?> >
    <input type="hidden" name="txthidesearchallfield" value=<?php echo $searchallfield; ?> >
</form>
<?php }
else
{
    
?>
<form name="pelisting" id="pelisting" method="post" action="exportsvinvdeals.php">
    <input type="hidden" name="txtsearchon" value="1" >
    <input type="hidden" name="txttitle" value=<?php echo $vcflagValue; ?> >
    <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
    <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
    <input type="hidden" name="txthidedateStartValue" value=<?php echo $startyear; ?> >
    <input type="hidden" name="txthidedateEndValue" value=<?php echo $endyear; ?> >
                        <input type="hidden" name="txthidedebt_equity" value='' >
    <input type="hidden" name="txthideindustry" value="" >
    <input type="hidden" name="txthideindustryid" value="" >
    <input type="hidden" name="txthidestage" value="">
    <input type="hidden" name="txthidestageid" value="">
    <input type="hidden" name="txthideround" value="--">
    <input type="hidden" name="txthideinvtype" value="">
    <input type="hidden" name="txthideinvtypeid" value="">
    <input type="hidden" name="txthideregionvalue" value="">
    <input type="hidden" name="txthideregionid" value="">
    <input type="hidden" name="txthidecity" value="">
    <input type="hidden" name="txthiderange" value="" >
    <input type="hidden" name="txthiderangeStartValue" value="">
    <input type="hidden" name="txthiderangeEndValue" value="" >
    <input type="hidden" name="txthidedate" value="" >
    <input type="hidden" name="txthideinvestor" value="" >
    <input type="hidden" name="txthidecompany" value="">
    <input type="hidden" name="txthideadvisor_legal" value="" >
    <input type="hidden" name="txthideadvisor_trans" value="" >
    <input type="hidden" name="txthidesearchallfield" value="" >
</form>
<?php
}
?>

   
             <form id="other_db_submit" method="post">
                <input type="hidden" name="searchallfield_other" id="other_searchallfield" value="<?php echo $searchallfield;?>">
                <input type="hidden" name="companyauto_other" id="companyauto_other" value="<?php echo $companyauto;?>">
                <input type="hidden" name="companysearch_other" id="companysearch_other" value="<?php echo $companysearch;?>">
                <input type="hidden" name="investorauto_sug_other" id="investorauto_sug_other" value="<?php echo $investorauto;?>">
                <input type="hidden" name="keywordsearch_other" id="keywordsearch_other" value="<?php echo $keywordsearch;?>">
                <input type="hidden" name="sectorsearch_other" id="sectorsearch_other" value="<?php echo $sectors_filter;?>">
                <input type="hidden" name="advisorsearch_legal_other" id="advisorsearch_legal_other" value="<?php echo $advisorsearchstring_legal;?>">
                <input type="hidden" name="advisorsearch_trans_other" id="advisorsearch_trans_other" value="<?php echo $advisorsearchstring_trans;?>">
                <input type="hidden" name="all_keyword_other" id="all_keyword_other" value="">
            </form> 

</body>
            <input type="hidden" id="prev" value="<?php echo $prevpage; ?>"/>
            <input type="hidden" id="current" value="<?php echo $currentpage; ?>"/>
            <input type="hidden" id="next" value="<?php echo $nextpage; ?>"/>
            <script src="js/listviewfunctions.js"></script>
             <script type="text/javascript">
               var  orderby='<?php echo $orderby; ?>';
               var  ordertype='<?php echo $ordertype; ?>';
                $(".jp-next").live("click",function(){
                    if(!$(this).hasClass('jp-disabled')){
                  var  pageno=$("#next").val();
                    loadhtml(pageno,orderby,ordertype);}
                    return  false;
                });
                $(".jp-page").live("click",function(){
                   var pageno=$(this).text();
                    loadhtml(pageno,orderby,ordertype);
                    return  false;
                });
                $(".jp-previous").live("click",function(){
                    if(!$(this).hasClass('jp-disabled')){
                   var  pageno=$("#prev").val();
                    loadhtml(pageno,orderby,ordertype);
                    }
                    return  false;
                });
                $(".header").live("click",function(){
                    orderby=$(this).attr('id');
                    if($(this).hasClass("asc"))
                        ordertype="desc";
                    else
                        ordertype="asc";
                    loadhtml(1,orderby,ordertype);
                    return  false;
                });    
		$(document).ready(function(){ 
           
     
          });              
               function loadhtml(pageno,orderby,ordertype)
               {
                jQuery('#preloading').fadeIn(1000);   
                $.ajax({
                type : 'POST',
                url  : 'ajaxListview_sv.php',
                data: {

                        sql : '<?php echo addslashes($ajaxcompanysql); ?>',
                        totalrecords : '<?php echo addslashes($company_cntall); ?>',
                        page: pageno,
                        vcflagvalue:'<?php echo $vcflagValue; ?>',
                        orderby:orderby,
                        ordertype:ordertype
                },
                success : function(data){
                        $(".view-table-list").html(data);
                        $(".jp-current").text(pageno);
                       var prev=parseInt(pageno)-1
                        if(prev>0)
                        $("#prev").val(pageno-1);
                        else
                        {
                        $("#prev").val(1);
//                        $(".jp-previous").addClass('.jp-disabled').removeClass('.jp-previous');
                        }
                        $("#current").val(pageno);
                      var  next=parseInt(pageno)+1;
                        if(next < <?php echo $totalpages ?> )
                         $("#next").val(next);
                        else
                        {
                        $("#next").val(<?php echo $totalpages ?>);
//                        $(".jp-next").addClass('.jp-disabled').removeClass('.jp-next');
                        }
                        drawNav(<?php echo $totalpages ?>,parseInt(pageno))
                        jQuery('#preloading').fadeOut(500); 
                       
                        return  false;
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                        jQuery('#preloading').fadeOut(500);
                        alert('There was an error');
                }
            });
               }
         
            </script>
           
<script type="text/javascript">
            /*$('#expshowdeals').live('click',function(){ 
                   $("#pelisting").submit();
                   return false;
            });
            $(".export").click(function(){
                $("#pelisting").submit();
            });*/
    
            $('#expshowdeals').click(function(){ 
        jQuery('#preloading').fadeIn();   
        initExport();
        return false;
    });

    $('#expshowdealsbtn').click(function(){ 
        jQuery('#preloading').fadeIn();   
        initExport();
        return false;
    });
            
    function initExport(){ 
            $.ajax({
                url: 'ajxCheckDownload.php',
                dataType: 'json',
                success: function(data){
                    var downloaded = data['recDownloaded'];
                    var exportLimit = data.exportLimit;
                    var currentRec = <?php echo $totalInv; ?>;

                    //alert(currentRec + downloaded);
                    var remLimit = exportLimit-downloaded;

                    if (currentRec < remLimit){
                        hrefval= 'exportsvinvdeals.php';
                        $("#pelisting").attr("action", hrefval);
                        $("#pelisting").submit();
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
    
    
    
    
            $("a.postlink").live('click',function(){
               $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
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
            $(document).on('click', 'tr .details_link', function(){ 
                
                idval=$(this).attr("valueId");
                $("#detailpost").attr("href","<?php echo GLOBAL_BASE_URL; ?>dealsnew/dealdetails.php?value="+idval).trigger("click");
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

?>

<?php 
//ech
if($type==1 && $vcflagValue==4)
{ 
    ?>
    
    <script language="javascript">
	$(document).ready(function(){
		$("#ldtrend").click(function () {
			if($(".show_hide").attr('class')!='show_hide'){
				var htmlinner = $(".profile-view-title").html();
				$(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');
				//Execute SQL
				$.ajax({
					type : 'POST',
					url  : 'ajxQuery.php',
					dataType : 'json',
					data: {
						sql : '<?php echo addslashes($companysql); ?>',
					},
					success : function(data){
						drawVisualization(data);
						$(".profile-view-title").html(htmlinner);
					},
					error : function(XMLHttpRequest, textStatus, errorThrown) {
						alert('There was an error');
					}
				});
			}
		});
	});
	</script>

	
	<script type="text/javascript">
      function drawVisualization(dealdata) {
		
		var data = new google.visualization.DataTable();
		data.addColumn('string','Year');
		data.addColumn('number', 'No of Deals');
		data.addColumn('number', 'Amount($m)');
		data.addRows(dealdata.length);
		for (var i=0; i< dealdata.length ;i++){
			for(var j=0; j< dealdata[i].length ;j++){
				if (j!=0)
					data.setValue(i, j,Math.round(dealdata[i][j]-0));
				else
					data.setValue(i, j,dealdata[i][j]);
			}			
		}
				
		// Create and draw the visualization.
        var chart = new google.visualization.LineChart(document.getElementById('visualization2'));
		
		divwidth  =  document.getElementById("visualization2").offsetWidth;
		divheight =  document.getElementById("visualization2").offsetHight;
		
       function selectHandler() {
          var selectedItem = chart.getSelection()[0];
         if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var query_string = 'value=4&y='+topping;
             <?php if($drilldownflag==1){ ?>
              window.location.href = 'svindex.php?'+query_string;
            <?php } ?>
            
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
                                title: 'No of Deals',
                            },
                            1: {
                                title: 'Amount'
                            }
                        },
//                    colors: ["#FCCB05","#a2753a"],
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "bars",curveType: "function"}
                            }
                  });
             
			 //Fill table
			 var pintblcnt = '';
			 var tblCont = '';
			 			 
			 pintblcnt = '<table>';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">Year</th><tr>';
			 //pintblcnt = pintblcnt + '</thead>';
			 //pintblcnt = pintblcnt + '<tbody>';
			 
			 tblCont = '';
			 tblCont = tblCont + '<tr><th style="text-align:center">Year</th><th style="text-align:center">No. of Deals</th><th style="text-align:center">Amount($m)</th></tr>';
//			 tblCont = tblCont + '</thead>';
//			 tblCont = tblCont + '<tbody>';
			 for (var i=0; i< dealdata.length ;i++){
				tblCont = tblCont + '<tr>';
				for(var j=0; j< dealdata[i].length ;j++){
					if (j==0){
						pintblcnt = pintblcnt + '<tr><th style="text-align:center">'+ dealdata[i][j] + '</th><tr>';
					}
					tblCont = tblCont + '<td style="text-align:center">'+ dealdata[i][j] + '</td>';
				}
				tblCont = tblCont + '</tr>';
								
			 }
			 pintblcnt = pintblcnt + '</table>';
//			 tblCont = tblCont + '</tbody>';
			 $('#restable').html(tblCont);
			 $('.pinned').html(pintblcnt);
			 
			 //updateTables();
      }
      //google.setOnLoadCallback(drawVisualization);
    </script>
      <?php
    }
else if($type==1 && $vcflagValue==5)
{ ?>
    
	<script language="javascript">
	$(document).ready(function(){
		$("#ldtrend").click(function () {
			if($(".show_hide").attr('class')!='show_hide'){
				var htmlinner = $(".profile-view-title").html();
				$(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');
				//Execute SQL
				$.ajax({
					type : 'POST',
					url  : 'ajxQuery.php',
					dataType : 'json',
					data: {
						sql : '<?php echo addslashes($companysql); ?>',
					},
					success : function(data){
						drawVisualization(data);
						$(".profile-view-title").html(htmlinner);
					},
					error : function(XMLHttpRequest, textStatus, errorThrown) {
						alert('There was an error');
					}
				});
			}
		});
	});
	</script>
    
    
    <script type="text/javascript">
      function drawVisualization(dealdata) 
      {
         
		var data = new google.visualization.DataTable();
		data.addColumn('string','Year');
		data.addColumn('number', 'No of Deals');
		data.addColumn('number', 'Amount($m)');
		data.addRows(dealdata.length);
		for (var i=0; i< dealdata.length ;i++)
                {
			for(var j=0; j< dealdata[i].length ;j++)
                        {
				if (j!=0)
					data.setValue(i, j,Math.round(dealdata[i][j]-0));
				else
					data.setValue(i, j,dealdata[i][j]);
			}			
		}
		// Create and draw the visualization.
		var chart = new google.visualization.LineChart(document.getElementById('visualization2'));
		divwidth=  document.getElementById("visualization2").offsetWidth;
		divheight=  document.getElementById("visualization2").offsetHight;
		  
       function selectHandler() {
             
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var query_string = 'value=3&y='+topping;
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
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
                                title: 'No of Deals',
                            },
                            1: {
                                title: 'Amount'
                            }
                        },
//                    colors: ["#FCCB05","#a2753a"],
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "bars",curveType: "function"}
                            }
                  });
              
		 	//Fill table
			 var pintblcnt = '';
			 var tblCont = '';
			 
			 pintblcnt = '<table> ';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">Year</th><tr>';
			 
			 tblCont = ' ';
			 tblCont = tblCont + '<tr><th style="text-align:center">Year</th><th style="text-align:center">No. of Deals</th><th style="text-align:center">Amount($m)</th></tr>';
//			 tblCont = tblCont + '</thead>';
//			 tblCont = tblCont + '<tbody>';
			 for (var i=0; i< dealdata.length ;i++){
				tblCont = tblCont + '<tr>';
				for(var j=0; j< dealdata[i].length ;j++){
					if (j==0){
						pintblcnt = pintblcnt + '<tr><th style="text-align:center">'+ dealdata[i][j] + '</th><tr>';
					}
					tblCont = tblCont + '<td style="text-align:center">'+ dealdata[i][j] + '</td>';
				}
				tblCont = tblCont + '</tr>';
								
			 }
			  pintblcnt = pintblcnt + '</table>';
//			 tblCont = tblCont + '<tbody>';
			 $('#restable').html(tblCont);
			 $('.pinned').html(pintblcnt);
      }
      
    </script>
      <?php
        
    }
else if($type==1 && $vcflagValue==3)
{ ?>
    
	<script language="javascript">
	$(document).ready(function(){
		$("#ldtrend").click(function () {
			if($(".show_hide").attr('class')!='show_hide'){
				var htmlinner = $(".profile-view-title").html();
				$(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');
				//Execute SQL
				$.ajax({
					type : 'POST',
					url  : 'ajxQuery.php',
					dataType : 'json',
					data: {
						sql : '<?php echo addslashes($companysql); ?>',
					},
					success : function(data){
						drawVisualization(data);
						$(".profile-view-title").html(htmlinner);
					},
					error : function(XMLHttpRequest, textStatus, errorThrown) {
						alert('There was an error');
					}
				});
			}
		});
	});
	</script>
    
    
    <script type="text/javascript">
      function drawVisualization(dealdata) {
         
		var data = new google.visualization.DataTable();
		data.addColumn('string','Year');
		data.addColumn('number', 'No of Deals');
		data.addColumn('number', 'Amount($m)');
		data.addRows(dealdata.length);
		for (var i=0; i< dealdata.length ;i++){
			for(var j=0; j< dealdata[i].length ;j++){
				if (j!=0)
					data.setValue(i, j,Math.round(dealdata[i][j]-0));
				else
					data.setValue(i, j,dealdata[i][j]);
			}			
		}
		// Create and draw the visualization.
		var chart = new google.visualization.LineChart(document.getElementById('visualization2'));
		divwidth=  document.getElementById("visualization2").offsetWidth;
		divheight=  document.getElementById("visualization2").offsetHight;
		  
       function selectHandler() {
             
          var selectedItem = chart.getSelection()[0];
         if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var industry = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
            var query_string = 'value=4&y='+topping+'&i='+encodeURIComponent(industry);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
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
                                title: 'No of Deals',
                            },
                            1: {
                                title: 'Amount'
                            }
                        },
//                    colors: ["#FCCB05","#a2753a"],
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "bars",curveType: "function"}
                            }
                  }
              );
              
		 	//Fill table
			 var pintblcnt = '';
			 var tblCont = '';
			 
			 pintblcnt = '<table>';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">Year</th><tr>';
			 
			 tblCont = '';
			 tblCont = tblCont + '<tr><th style="text-align:center">Year</th><th style="text-align:center">No. of Deals</th><th style="text-align:center">Amount($m)</th></tr>';
//			 tblCont = tblCont + '</thead>';
//			 tblCont = tblCont + '<tbody>';
			 for (var i=0; i< dealdata.length ;i++){
				tblCont = tblCont + '<tr>';
				for(var j=0; j< dealdata[i].length ;j++){
					if (j==0){
						pintblcnt = pintblcnt + '<tr><th style="text-align:center">'+ dealdata[i][j] + '</th><tr>';
					}
					tblCont = tblCont + '<td style="text-align:center">'+ dealdata[i][j] + '</td>';
				}
				tblCont = tblCont + '</tr>';
								
			 }
			  pintblcnt = pintblcnt + '</table>';
//			 tblCont = tblCont + '<tbody>';
			 $('#restable').html(tblCont);
			 $('.pinned').html(pintblcnt);
      }
      //google.setOnLoadCallback(drawVisualization);
    </script>
      <?php
        
    }
else if($type==2 && $vcflagValue==4) 
{  //  print_r($deal);   ?>

    <script language="javascript">
	$(document).ready(function(){
		$("#ldtrend").click(function () {
                   
			if($(".show_hide").attr('class')!='show_hide'){
				var htmlinner = $(".profile-view-title").html();
				$(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');
				//Execute SQL
				$.ajax({
					type : 'POST',
					url  : 'ajxQuery.php',
					dataType : 'json',
					data: {
						sql : '<?php echo addslashes($companysql); ?>',
					},
					success : function(data){
						drawVisualization(data);
						$(".profile-view-title").html(htmlinner);
					},
					error : function(XMLHttpRequest, textStatus, errorThrown) {
						alert('There was an error');
					}
				});
			}
		});
	});
	</script>
    
    
	 <script type="text/javascript">
	 	function in_array(array, id) {
			for(var i=0;i<array.length;i++) {
				if(array[i] == id) {
					return true;
				}
			}
			return false;
		}	 
	 
      	function drawVisualization(dealdata) {  
		
			var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][2]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				var arrval = [];
				arrval.push(Years[j]);
				for (var i=1;i<arrhead.length;i++){
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			//Graph 1
			var data1 = google.visualization.arrayToDataTable(dataArray);
			
        	// Create and populate the data table.       
       		var chart1 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
			divwidth=  document.getElementById("visualization1").offsetWidth;
        	divheight=  document.getElementById("visualization1").offsetHight;
			
       		function selectHandler() {
          		var selectedItem = chart1.getSelection()[0];
          		if (selectedItem) {
            		var topping = data1.getValue(selectedItem.row, 0);
            		var industry = data1.getColumnLabel(selectedItem.column).toString();
            		//alert('The user selected ' + topping +industry);
           
					var query_string = 'value=0&y='+topping+'&i='+encodeURIComponent(industry);
					<?php if($drilldownflag==1){ ?>
					 window.location.href = 'svindex.php?'+query_string;
					<?php } ?>
				  }
        	}
    
       		google.visualization.events.addListener(chart1, 'select', selectHandler);
          	chart1.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                 /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true,
              });
			  
			  
			//Graph 2
			var data = new google.visualization.DataTable();
			data.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][3]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				var arrval = [];
				arrval.push(Years[j]);
				for (var i=1;i<arrhead.length;i++){
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			var data = google.visualization.arrayToDataTable(dataArray);
			//var data = new google.visualization.DataTable();
			
			var chart2= new google.visualization.ColumnChart(document.getElementById('visualization'));
		 
			 function selectHandler2() {
			  var selectedItem = chart2.getSelection()[0];
			  if (selectedItem) {
				var topping = data.getValue(selectedItem.row, 0);
				var industry = data.getColumnLabel(selectedItem.column).toString();
				//alert('The user selected ' + topping +industry);
			   
				var query_string = 'value=0&y='+topping+'&i='+encodeURIComponent(industry);
				<?php if($drilldownflag==1){ ?>
				 window.location.href = 'svindex.php?'+query_string;
				<?php } ?>
			  }
			}
			 google.visualization.events.addListener(chart2, 'select', selectHandler2);
			  chart2.draw(data,
				   {
					title:"Amount",
					width:500, height:700,
					hAxis: {title: "Year"},
					vAxis: {title: "Amount"},
					/*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
					isStacked : true
				  }
			  );   
			  
			  
			//Graph 3			
			var data3 = new google.visualization.DataTable();
			data3.addColumn('string','Industry');
			data3.addColumn('number', 'No of Deals');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(dealdata[i][2]-0);
					dataArray.push(temArray);
				}
			}
			
			data3.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data3.setValue(i,0,dataArray[i][0]);
				data3.setValue(i,1,dataArray[i][1]-0);			
			}
			
			
			
			// Create and draw the visualization.
			new google.visualization.PieChart(document.getElementById('visualization2')).
			  draw(data3, {title:"No of Deals"/*,
			   colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
			
			
			//Graph 4
		
			var data4 = new google.visualization.DataTable();
			data4.addColumn('string','Industry');
			data4.addColumn('number', 'Amount');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(Math.round(dealdata[i][3]-0));
					dataArray.push(temArray);
				}
			}
			
			//console.log(dataArray);
			//console.log(dealdata);
			
			data4.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data4.setValue(i,0,dataArray[i][0]);
				data4.setValue(i,1,dataArray[i][1]-0);			
			}
    
			// Create and draw the visualization.
			new google.visualization.PieChart(document.getElementById('visualization3')).
			  draw(data4, {title:"Amount"/*,
			   colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
			
			
			//Fill table
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			
			for(var i=0;i<arrhead.length;i++){
				var tempArr = [];
				for (var j=0; j< dealdata.length ;j++){
					var values = [];
					if (dealdata[j][0]==arrhead[i]){
						if (dealdata[j][2])
							values.push(dealdata[j][2]);
						else
							values.push('0');
							
						if (dealdata[j][3])
							values.push(dealdata[j][3]);
						else
							values.push('0');
							
						tempArr[dealdata[j][1]] =  values;
					}
				}
				dataArray[arrhead[i]] = tempArr;
			}
			
			//console.log(dataArray);
			
			 var tblCont = '';
			 var pintblcnt = '';
			 
			 pintblcnt = '<table> ';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">INDUSTRY</th><tr>';
			 
          	 tblCont = '';
			 tblCont = tblCont + '<tr><th style="text-align:center">INDUSTRY</th>';
			 for (var i=0; i< Years.length ;i++){
				tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  tblCont = tblCont + '<tr><th style="text-align:center"></th>';
			 for (var i=0; i< Years.length ;i++){
				 if (i==0){
					 pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
				 }
				tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  
			 
//			 tblCont = tblCont + '</thead>';
//			 tblCont = tblCont + '<tbody>';
			 
			 /*for(i=0;i<dataArray.length;i++){
				 console.log(dataArray[i]);
			 }*/
			var val= [];
			
			for(var i=0;i<arrhead.length;i++){
				tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
				pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
				
				//var flag =0;
				for(var j=0;j<Years.length;j++){
					var deal = '';
					var amt  = '';
					val = dataArray[arrhead[i]][Years[j]];
					if (val){
							deal = val['0'];
							amt = val['1'];
					}
					/*if(flag==1)
						tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
					else*/
						tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
					//flag =1;
				}
				tblCont = tblCont + '<tr>';
				//console.log(dataArray[arrhead[i]]);
			}
			
			 pintblcnt = pintblcnt + '</table>';
			 tblCont = tblCont + '';

			 $('#restable').html(tblCont);
			 $('.pinned').html(pintblcnt);
		}
		
		function dealcount(ind,dataArray,dlCnt){
			var dealcount = 0;
			for(i=0;i<dataArray.length;i++){
				if(dataArray[i][0]==ind){
					dealcount = dataArray[i][1];
					dataArray[i][1] = (dealcount-0) + (dlCnt-0);
				}
			}
			return dealcount;
		}
    </script>
    
       
    <? 
     }
else if($type==2 && $vcflagValue==5)
{
   ?>
		<script language="javascript">
            $(document).ready(function(){
                $("#ldtrend").click(function () {
                    if($(".show_hide").attr('class')!='show_hide'){
                        var htmlinner = $(".profile-view-title").html();
                        $(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');
                        //Execute SQL
                        $.ajax({
                            type : 'POST',
                            url  : 'ajxQuery.php',
                            dataType : 'json',
                            data: {
                                sql : '<?php echo addslashes($companysql); ?>',
                            },
                            success : function(data){
                                drawVisualization(data);
                                $(".profile-view-title").html(htmlinner);
                            },
                            error : function(XMLHttpRequest, textStatus, errorThrown) {
                                alert('There was an error');
                            }
                        });
                    }
                });
            });
        </script>
        
        <script type="text/javascript">
			//Graph 1
		function in_array(array, id) {
			for(var i=0;i<array.length;i++) {
				if(array[i] == id) {
					return true;
				}
			}
			return false;
		}	 
	 
      	function drawVisualization(dealdata) {  
		
			var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][2]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				var arrval = [];
				arrval.push(Years[j]);
				for (var i=1;i<arrhead.length;i++){
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			//Graph 1
			var data1 = google.visualization.arrayToDataTable(dataArray);
			
        	// Create and populate the data table.       
       		var chart1 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
			divwidth=  document.getElementById("visualization1").offsetWidth;
        	divheight=  document.getElementById("visualization1").offsetHight;
			
       		function selectHandler() {
          		var selectedItem = chart1.getSelection()[0];
          		if (selectedItem) {
            		var topping = data1.getValue(selectedItem.row, 0);
            		var industry = data1.getColumnLabel(selectedItem.column).toString();
            		//alert('The user selected ' + topping +industry);
           
					var query_string = 'value=0&y='+topping+'&i='+encodeURIComponent(industry);
					<?php if($drilldownflag==1){ ?>
					 window.location.href = 'svindex.php?'+query_string;
					<?php } ?>
				  }
        	}
    
       		google.visualization.events.addListener(chart1, 'select', selectHandler);
          	chart1.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true,
              });
			  
			  
			//Graph 2
			var data = new google.visualization.DataTable();
			data.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][3]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				var arrval = [];
				arrval.push(Years[j]);
				for (var i=1;i<arrhead.length;i++){
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			var data = google.visualization.arrayToDataTable(dataArray);
			//var data = new google.visualization.DataTable();
			
			var chart2= new google.visualization.ColumnChart(document.getElementById('visualization'));
		 
			 function selectHandler2() {
			  var selectedItem = chart2.getSelection()[0];
			  if (selectedItem) {
				var topping = data.getValue(selectedItem.row, 0);
				var industry = data.getColumnLabel(selectedItem.column).toString();
				//alert('The user selected ' + topping +industry);
			   
				var query_string = 'value=0&y='+topping+'&i='+encodeURIComponent(industry);
				<?php if($drilldownflag==1){ ?>
				 window.location.href = 'svindex.php?'+query_string;
				<?php } ?>
			  }
			}
			 google.visualization.events.addListener(chart2, 'select', selectHandler2);
			  chart2.draw(data,
				   {
					title:"Amount",
					width:500, height:700,
					hAxis: {title: "Year"},
					vAxis: {title: "Amount"},
					 /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
					isStacked : true
				  }
			  );   
			  
			  
			//Graph 3			
			var data3 = new google.visualization.DataTable();
			data3.addColumn('string','Industry');
			data3.addColumn('number', 'No of Deals');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(dealdata[i][2]-0);
					dataArray.push(temArray);
				}
			}
			
			data3.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data3.setValue(i,0,dataArray[i][0]);
				data3.setValue(i,1,dataArray[i][1]-0);			
			}
			
			
			
			// Create and draw the visualization.
			new google.visualization.PieChart(document.getElementById('visualization2')).
			  draw(data3, {title:"No of Deals"/*,
			   colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
			
			
			//Graph 4
		
			var data4 = new google.visualization.DataTable();
			data4.addColumn('string','Industry');
			data4.addColumn('number', 'Amount');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(Math.round(dealdata[i][3]-0));
					dataArray.push(temArray);
				}
			}
			
			//console.log(dataArray);
			//console.log(dealdata);
			
			data4.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data4.setValue(i,0,dataArray[i][0]);
				data4.setValue(i,1,dataArray[i][1]-0);			
			}
    
			// Create and draw the visualization.
			new google.visualization.PieChart(document.getElementById('visualization3')).
			  draw(data4, {title:"Amount"/*,
			   colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
			
			
			//Fill table
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			
			for(var i=0;i<arrhead.length;i++){
				var tempArr = [];
				for (var j=0; j< dealdata.length ;j++){
					var values = [];
					if (dealdata[j][0]==arrhead[i]){
						if (dealdata[j][2])
							values.push(dealdata[j][2]);
						else
							values.push('0');
							
						if (dealdata[j][3])
							values.push(dealdata[j][3]);
						else
							values.push('0');
							
						tempArr[dealdata[j][1]] =  values;
					}
				}
				dataArray[arrhead[i]] = tempArr;
			}
			
			//console.log(dataArray);
			
			 var tblCont = '';
			 var pintblcnt = '';
			 
			 pintblcnt = '<table>';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">INDUSTRY</th><tr>';
			 
          	 tblCont = ' ';
			 tblCont = tblCont + '<tr><th style="text-align:center">INDUSTRY</th>';
			 for (var i=0; i< Years.length ;i++){
				tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  tblCont = tblCont + '<tr><th style="text-align:center"></th>';
			 for (var i=0; i< Years.length ;i++){
				if (i==0){
					 pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
				 }
				tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  
			 
			 tblCont = tblCont ;
			 tblCont = tblCont ;
			 
			 /*for(i=0;i<dataArray.length;i++){
				 console.log(dataArray[i]);
			 }*/
			var val= [];
			
			for(var i=0;i<arrhead.length;i++){
				tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
				pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
				//var flag =0;
				for(var j=0;j<Years.length;j++){
					var deal = '';
					var amt  = '';
					val = dataArray[arrhead[i]][Years[j]];
					if (val){
							deal = val['0'];
							amt = val['1'];
					}
					/*if(flag==1)
						tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
					else*/
					tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
					//flag =1;
				}
				tblCont = tblCont + '<tr>';
				
				//console.log(dataArray[arrhead[i]]);
			}
			
			 pintblcnt = pintblcnt ;
			 tblCont = tblCont ;

			 $('#restable').html(tblCont);	 
			 $('.pinned').html(pintblcnt);
          
		}
		
		function dealcount(ind,dataArray,dlCnt){
			var dealcount = 0;
			for(i=0;i<dataArray.length;i++){
				if(dataArray[i][0]==ind){
					dealcount = dataArray[i][1];
					dataArray[i][1] = (dealcount-0) + (dlCnt-0);
				}
			}
			return dealcount;
		}
		</script> 
    
       
    <? 
     }
else if($type==2 && $vcflagValue==3)
{
   ?>
		<script language="javascript">
            $(document).ready(function(){
                $("#ldtrend").click(function () {
                    if($(".show_hide").attr('class')!='show_hide'){
                        var htmlinner = $(".profile-view-title").html();
                        $(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');
                        //Execute SQL
                        $.ajax({
                            type : 'POST',
                            url  : 'ajxQuery.php',
                            dataType : 'json',
                            data: {
                                sql : '<?php echo addslashes($companysql); ?>',
                            },
                            success : function(data){
                                drawVisualization(data);
                                $(".profile-view-title").html(htmlinner);
                            },
                            error : function(XMLHttpRequest, textStatus, errorThrown) {
                                alert('There was an error');
                            }
                        });
                    }
                });
            });
        </script>
        
        <script type="text/javascript">
			//Graph 1
		function in_array(array, id) {
			for(var i=0;i<array.length;i++) {
				if(array[i] == id) {
					return true;
				}
			}
			return false;
		}	 
	 
      	function drawVisualization(dealdata) {  
		
			var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][2]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				var arrval = [];
				arrval.push(Years[j]);
				for (var i=1;i<arrhead.length;i++){
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			//Graph 1
			var data1 = google.visualization.arrayToDataTable(dataArray);
			
        	// Create and populate the data table.       
       		var chart1 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
			divwidth=  document.getElementById("visualization1").offsetWidth;
        	divheight=  document.getElementById("visualization1").offsetHight;
			
       		function selectHandler() {
          		var selectedItem = chart1.getSelection()[0];
          		if (selectedItem) {
            		var topping = data1.getValue(selectedItem.row, 0);
            		var industry = data1.getColumnLabel(selectedItem.column).toString();
            		//alert('The user selected ' + topping +industry);
           
					var query_string = 'value=0&y='+topping+'&i='+encodeURIComponent(industry);
					<?php if($drilldownflag==1){ ?>
					 window.location.href = 'svindex.php?'+query_string;
					<?php } ?>
				  }
        	}
    
       		google.visualization.events.addListener(chart1, 'select', selectHandler);
          	chart1.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"}
               /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
              });
			  
			  
			//Graph 2
			var data = new google.visualization.DataTable();
			data.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][3]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				var arrval = [];
				arrval.push(Years[j]);
				for (var i=1;i<arrhead.length;i++){
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			var data = google.visualization.arrayToDataTable(dataArray);
			//var data = new google.visualization.DataTable();
			
			var chart2= new google.visualization.ColumnChart(document.getElementById('visualization'));
		 
			 function selectHandler2() {
			  var selectedItem = chart2.getSelection()[0];
			  if (selectedItem) {
				var topping = data.getValue(selectedItem.row, 0);
				var industry = data.getColumnLabel(selectedItem.column).toString();
				//alert('The user selected ' + topping +industry);
			   
				var query_string = 'value=0&y='+topping+'&i='+encodeURIComponent(industry);
				<?php if($drilldownflag==1){ ?>
				 window.location.href = 'svindex.php?'+query_string;
				<?php } ?>
			  }
			}
			 google.visualization.events.addListener(chart2, 'select', selectHandler2);
			  chart2.draw(data,
				   {
					title:"Amount",
					width:500, height:700,
					hAxis: {title: "Year"},
					vAxis: {title: "Amount"},
					/*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
					isStacked : true
				  }
			  );   
			  
			  
			//Graph 3			
			var data3 = new google.visualization.DataTable();
			data3.addColumn('string','Industry');
			data3.addColumn('number', 'No of Deals');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(dealdata[i][2]-0);
					dataArray.push(temArray);
				}
			}
			
			data3.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data3.setValue(i,0,dataArray[i][0]);
				data3.setValue(i,1,dataArray[i][1]-0);			
			}
			
			
			
			// Create and draw the visualization.
			new google.visualization.PieChart(document.getElementById('visualization2')).
			  draw(data3, {title:"No of Deals"/*,
			  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
			
			
			//Graph 4
		
			var data4 = new google.visualization.DataTable();
			data4.addColumn('string','Industry');
			data4.addColumn('number', 'Amount');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(Math.round(dealdata[i][3]-0));
					dataArray.push(temArray);
				}
			}
			
			//console.log(dataArray);
			//console.log(dealdata);
			
			data4.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data4.setValue(i,0,dataArray[i][0]);
				data4.setValue(i,1,dataArray[i][1]-0);			
			}
    
			// Create and draw the visualization.
			new google.visualization.PieChart(document.getElementById('visualization3')).
			  draw(data4, {title:"Amount"/*,
			 colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
			
			
			//Fill table
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			
			for(var i=0;i<arrhead.length;i++){
				var tempArr = [];
				for (var j=0; j< dealdata.length ;j++){
					var values = [];
					if (dealdata[j][0]==arrhead[i]){
						if (dealdata[j][2])
							values.push(dealdata[j][2]);
						else
							values.push('0');
							
						if (dealdata[j][3])
							values.push(dealdata[j][3]);
						else
							values.push('0');
							
						tempArr[dealdata[j][1]] =  values;
					}
				}
				dataArray[arrhead[i]] = tempArr;
			}
			
			//console.log(dataArray);
			
			 var tblCont = '';
			 var pintblcnt = '';
			 
			 pintblcnt = '<table>';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">INDUSTRY</th><tr>';
			 
          	        tblCont = '';
			 tblCont = tblCont + '<tr><th style="text-align:center">INDUSTRY</th>';
			 for (var i=0; i< Years.length ;i++){
				tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  tblCont = tblCont + '<tr><th style="text-align:center"></th>';
			 for (var i=0; i< Years.length ;i++){
				if (i==0){
					 pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
				 }
				tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  
			 
			 tblCont = tblCont ;
			 tblCont = tblCont ;
			 
			 /*for(i=0;i<dataArray.length;i++){
				 console.log(dataArray[i]);
			 }*/
			var val= [];
			
			for(var i=0;i<arrhead.length;i++){
				tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
				pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
				//var flag =0;
				for(var j=0;j<Years.length;j++){
					var deal = '';
					var amt  = '';
					val = dataArray[arrhead[i]][Years[j]];
					if (val){
							deal = val['0'];
							amt = val['1'];
					}
					/*if(flag==1)
						tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
					else*/
					tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
					//flag =1;
				}
				tblCont = tblCont + '<tr>';
				
				//console.log(dataArray[arrhead[i]]);
			}
			
			 pintblcnt = pintblcnt;
			 tblCont = tblCont ;

			 $('#restable').html(tblCont);	 
			 $('.pinned').html(pintblcnt);
          
		}
		
		function dealcount(ind,dataArray,dlCnt){
			var dealcount = 0;
			for(i=0;i<dataArray.length;i++){
				if(dataArray[i][0]==ind){
					dealcount = dataArray[i][1];
					dataArray[i][1] = (dealcount-0) + (dlCnt-0);
				}
			}
			return dealcount;
		}
		</script> 
    
       
    <? 
     }
else if($type==3 && $vcflagValue==4)
{
?>
    
    <script language="javascript">
            $(document).ready(function(){
                $("#ldtrend").click(function () {
                    if($(".show_hide").attr('class')!='show_hide'){
                        var htmlinner = $(".profile-view-title").html();
                        $(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');
                        //Execute SQL
                        $.ajax({
                            type : 'POST',
                            url  : 'ajxQuery.php',
                            dataType : 'json',
                            data: {
                                sql : '<?php echo addslashes($companysql); ?>',
                            },
                            success : function(data){
                                drawVisualization(data);
                                $(".profile-view-title").html(htmlinner);
                            },
                            error : function(XMLHttpRequest, textStatus, errorThrown) {
                                alert('There was an error');
                            }
                        });
                    }
                });
            });
        </script>
            
    <script type="text/javascript">
		function in_array(array, id) {
			for(var i=0;i<array.length;i++) {
				if(array[i] == id) {
					return true;
				}
			}
			return false;
		}	
		
		function dealcount(ind,dataArray,dlCnt){
			var dealcount = 0;
			for(i=0;i<dataArray.length;i++){
				if(dataArray[i][0]==ind){
					dealcount = dataArray[i][1];
					dataArray[i][1] = (dealcount-0) + (dlCnt-0);
				}
			}
			return dealcount;
		}
		
     	function drawVisualization(dealdata) {
			
						
						
		var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][2]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				for (var i=1;i<arrhead.length;i++){
					if (datayear[j][arrhead[i]])
						totalDeals += datayear[j][arrhead[i]]; 
				}
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]]){
						//alert((((datayear[j][arrhead[i]]/totalDeals)*100).toFixed(2))-0);
						arrval.push((((datayear[j][arrhead[i]]/totalDeals)*100).toFixed(2))-0);					
					}else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			
			//Graph 1
			var data1 = google.visualization.arrayToDataTable(dataArray);				
						
						
        var chart4 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart4.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var stage = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&s='+encodeURIComponent(stage);
              <?php if($drilldownflag==1){ ?>
             window.location.href = 'svindex.php?'+query_string;
            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart4, 'select', selectHandler);
         chart4. draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
           /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );
		  
			//Garaph 2
			var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][3]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				var totalamt = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal amount of the year
				for (var i=1;i<arrhead.length;i++){
					if(datayear[j][arrhead[i]])
						totalamt += datayear[j][arrhead[i]]; 
				}
				
				for (var i=1;i<arrhead.length;i++){
                                        
					if (datayear[j][arrhead[i]]){
						arrval.push((((datayear[j][arrhead[i]]/totalamt)*100).toFixed(2))-0); }
					else
						arrval.push(0)
				}
                               
				dataArray.push(arrval);	
			}
			
			//Graph 1
			var data = google.visualization.arrayToDataTable(dataArray);	
			 var chart5 = new google.visualization.ColumnChart(document.getElementById('visualization'));
           function selectHandler2() {
			  var selectedItem = chart5.getSelection()[0];
			  if (selectedItem) {
				var topping = data.getValue(selectedItem.row, 0);
				var stage = data.getColumnLabel(selectedItem.column).toString();
				//alert('The user selected ' + topping +industry);
			   
			   var query_string = 'value=0&y='+topping+'&s='+encodeURIComponent(stage);
				 <?php if($drilldownflag==1){ ?>
				 window.location.href = 'svindex.php?'+query_string;
				<?php } ?>
			  }
			}
			 google.visualization.events.addListener(chart5, 'select', selectHandler2);
			 chart5.draw(data,
				   {
					title:"Amount",
					width:500, height:700,
					hAxis: {title: "Year"},
					vAxis: {title: "Amount"},
				  /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
					isStacked : true
				  }
			  );
			  
			  
			  //Graph 3
			  var data3 = new google.visualization.DataTable();
			  data3.addColumn('string','Stage');
				data3.addColumn('number', 'No of Deals');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(dealdata[i][2]-0);
					dataArray.push(temArray);
				}
			}
			
			data3.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data3.setValue(i,0,dataArray[i][0]);
				data3.setValue(i,1,dataArray[i][1]-0);			
			}
			// Create and draw the visualization.
			new google.visualization.PieChart(document.getElementById('visualization2')).
			  draw(data3, {title:"No of Deal"/*,
      colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
			  
			  
			 //Graph 4
			var data4 = new google.visualization.DataTable();
			data4.addColumn('string','Stage');
			data4.addColumn('number', 'Amount');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(Math.round(dealdata[i][3]-0));
					dataArray.push(temArray);
				}
			}
			
			//console.log(dataArray);
			//console.log(dealdata);
			
			data4.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data4.setValue(i,0,dataArray[i][0]);
				data4.setValue(i,1,dataArray[i][1]-0);			
			}
			 // Create and draw the visualization.
			var chart=new google.visualization.PieChart(document.getElementById('visualization3'));
			chart.draw(data4, {title:"Amount"/*,colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
			google.visualization.events.addListener(chart, 'select', function() {
				var selection = chart.getSelection();
				//console.log(selection);  
			}); 
			
			
			//Fill table
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			
			for(var i=0;i<arrhead.length;i++){
				var tempArr = [];
				for (var j=0; j< dealdata.length ;j++){
					var values = [];
					if (dealdata[j][0]==arrhead[i]){
						if (dealdata[j][2])
							values.push(dealdata[j][2]);
						else
							values.push('0');
							
						if (dealdata[j][3])
							values.push(dealdata[j][3]);
						else
							values.push('0');
							
						tempArr[dealdata[j][1]] =  values;
					}
				}
				dataArray[arrhead[i]] = tempArr;
			}
			
			//console.log(dataArray);
			
			 var tblCont = '';
			 var pintblcnt = '';
			 
			 pintblcnt = '<table>';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">STAGE</th><tr>';
			 
          	 tblCont = '';
			 tblCont = tblCont + '<tr><th style="text-align:center">STAGE</th>';
			 for (var i=0; i< Years.length ;i++){
				tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  tblCont = tblCont + '<tr><th style="text-align:center"></th>';
			 for (var i=0; i< Years.length ;i++){
				if (i==0){
					 pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
				 }
				tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  
			 
			 tblCont = tblCont;
			 tblCont = tblCont;
			 
			 /*for(i=0;i<dataArray.length;i++){
				 console.log(dataArray[i]);
			 }*/
			var val= [];
			
			for(var i=0;i<arrhead.length;i++){
				tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
				pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
				//var flag =0;
				for(var j=0;j<Years.length;j++){
					var deal = '';
					var amt  = '';
					val = dataArray[arrhead[i]][Years[j]];
					if (val){
							deal = val['0'];
							amt = val['1'];
					}
					/*if(flag==1)
						tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
					else*/
					tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
					//flag =1;
				}
				tblCont = tblCont + '<tr>';
				//console.log(dataArray[arrhead[i]]);
			}
			
			 pintblcnt = pintblcnt ; 
			 tblCont = tblCont ;

			 $('#restable').html(tblCont);	 
			 $('.pinned').html(pintblcnt);
		}
    </script>    
    
       
    <? 
     }
else if($type==3 && $vcflagValue==5)
{
   ?>
         <script language="javascript">
            $(document).ready(function(){
                $("#ldtrend").click(function () {
                    if($(".show_hide").attr('class')!='show_hide'){
                        var htmlinner = $(".profile-view-title").html();
                        $(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');
                        //Execute SQL
                        $.ajax({
                            type : 'POST',
                            url  : 'ajxQuery.php',
                            dataType : 'json',
                            data: {
                                sql : '<?php echo addslashes($companysql); ?>',
                            },
                            success : function(data){
                                drawVisualization(data);
                                $(".profile-view-title").html(htmlinner);
                            },
                            error : function(XMLHttpRequest, textStatus, errorThrown) {
                                alert('There was an error');
                            }
                        });
                    }
                });
            });
        </script>
    
    <script type="text/javascript">
		function in_array(array, id) {
			for(var i=0;i<array.length;i++) {
				if(array[i] == id) {
					return true;
				}
			}
			return false;
		}	
		
		function dealcount(ind,dataArray,dlCnt){
			var dealcount = 0;
			for(i=0;i<dataArray.length;i++){
				if(dataArray[i][0]==ind){
					dealcount = dataArray[i][1];
					dataArray[i][1] = (dealcount-0) + (dlCnt-0);
				}
			}
			return dealcount;
		}
		
     	function drawVisualization(dealdata) {
			
						
						
		var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][2]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				for (var i=1;i<arrhead.length;i++){
					if (datayear[j][arrhead[i]])
						totalDeals += datayear[j][arrhead[i]]; 
				}
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]]!=null && datayear[j][arrhead[i]]!="")
						arrval.push((((datayear[j][arrhead[i]]/totalDeals)*100).toFixed(2))-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			//Graph 1
			var data1 = google.visualization.arrayToDataTable(dataArray);				
						
						
        var chart4 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart4.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var stage = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&s='+encodeURIComponent(stage);
              <?php if($drilldownflag==1){ ?>
             window.location.href = 'svindex.php?'+query_string;
            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart4, 'select', selectHandler);
         chart4. draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );
		  
			//Garaph 2
			var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][3]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				var totalamt = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal amount of the year
				for (var i=1;i<arrhead.length;i++){
					if(datayear[j][arrhead[i]])
						totalamt += datayear[j][arrhead[i]]; 
				}
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push((((datayear[j][arrhead[i]]/totalamt)*100).toFixed(2))-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			//Graph 1
			var data = google.visualization.arrayToDataTable(dataArray);	
			 var chart5 = new google.visualization.ColumnChart(document.getElementById('visualization'));
           function selectHandler2() {
			  var selectedItem = chart5.getSelection()[0];
			  if (selectedItem) {
				var topping = data.getValue(selectedItem.row, 0);
				var stage = data.getColumnLabel(selectedItem.column).toString();
				//alert('The user selected ' + topping +industry);
			   
			   var query_string = 'value=0&y='+topping+'&s='+encodeURIComponent(stage);
				<?php if($drilldownflag==1){ ?>
					window.location.href = 'svindex.php?'+query_string;
				<?php } ?>
			  }
			}
			 google.visualization.events.addListener(chart5, 'select', selectHandler2);
			 chart5.draw(data,
				   {
					title:"Amount",
					width:500, height:700,
					hAxis: {title: "Year"},
					vAxis: {title: "Amount"},
				  /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
					isStacked : true
				  }
			  );
			  
			  
			  //Graph 3
			  var data3 = new google.visualization.DataTable();
			  data3.addColumn('string','Stage');
				data3.addColumn('number', 'No of Deals');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(dealdata[i][2]-0);
					dataArray.push(temArray);
				}
			}
			
			data3.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data3.setValue(i,0,dataArray[i][0]);
				data3.setValue(i,1,dataArray[i][1]-0);			
			}
			// Create and draw the visualization.
			new google.visualization.PieChart(document.getElementById('visualization2')).
			  draw(data3, {title:"No of Deal"/*,
      colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
			  
			  
			 //Graph 4
			var data4 = new google.visualization.DataTable();
			data4.addColumn('string','Stage');
			data4.addColumn('number', 'Amount');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(Math.round(dealdata[i][3]-0));
					dataArray.push(temArray);
				}
			}
			
			//console.log(dataArray);
			//console.log(dealdata);
			
			data4.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data4.setValue(i,0,dataArray[i][0]);
				data4.setValue(i,1,dataArray[i][1]-0);			
			}
			 // Create and draw the visualization.
			var chart=new google.visualization.PieChart(document.getElementById('visualization3'));
			chart.draw(data4, {title:"Amount"/*,colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
			google.visualization.events.addListener(chart, 'select', function() {
				var selection = chart.getSelection();
				//console.log(selection);  
			}); 
			
			
			//Fill table
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			
			for(var i=0;i<arrhead.length;i++){
				var tempArr = [];
				for (var j=0; j< dealdata.length ;j++){
					var values = [];
					if (dealdata[j][0]==arrhead[i]){
						if (dealdata[j][2])
							values.push(dealdata[j][2]);
						else
							values.push('0');
							
						if (dealdata[j][3])
							values.push(dealdata[j][3]);
						else
							values.push('0');
							
						tempArr[dealdata[j][1]] =  values;
					}
				}
				dataArray[arrhead[i]] = tempArr;
			}
			
			//console.log(dataArray);
			
			 var tblCont = '';
			 var pintblcnt = '';
			 
			 pintblcnt = '<table>';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">STAGE</th><tr>';
			 
          	 tblCont = '';
			 tblCont = tblCont + '<tr><th style="text-align:center">STAGE</th>';
			 for (var i=0; i< Years.length ;i++){
				tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  tblCont = tblCont + '<tr><th style="text-align:center"></th>';
			 for (var i=0; i< Years.length ;i++){
				if (i==0){
					 pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
				 }
				tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  
//			 
//			 tblCont = tblCont ;
//			 tblCont = tblCont ;
			 
			 /*for(i=0;i<dataArray.length;i++){
				 console.log(dataArray[i]);
			 }*/
			var val= [];
			
			for(var i=0;i<arrhead.length;i++){
				tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
				pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
				//var flag =0;
				for(var j=0;j<Years.length;j++){
					var deal = '';
					var amt  = '';
					val = dataArray[arrhead[i]][Years[j]];
					if (val){
							deal = val['0'];
							amt = val['1'];
					}
					/*if(flag==1)
						tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
					else*/
					tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
					//flag =1;
				}
				tblCont = tblCont + '<tr>';
				//console.log(dataArray[arrhead[i]]);
			}
			
//			 pintblcnt = pintblcnt + '</thead></table>'; 
//			 tblCont = tblCont + '</tbody>';

			 $('#restable').html(tblCont);	 
			 $('.pinned').html(pintblcnt);
		}
    </script>        
    <? 
     }
else if($type==3 && $vcflagValue==3)
{
   ?>
         <script language="javascript">
            $(document).ready(function(){
                $("#ldtrend").click(function () {
                    if($(".show_hide").attr('class')!='show_hide'){
                        var htmlinner = $(".profile-view-title").html();
                        $(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');
                        //Execute SQL
                        $.ajax({
                            type : 'POST',
                            url  : 'ajxQuery.php',
                            dataType : 'json',
                            data: {
                                sql : '<?php echo addslashes($companysql); ?>',
                            },
                            success : function(data){
                                drawVisualization(data);
                                $(".profile-view-title").html(htmlinner);
                            },
                            error : function(XMLHttpRequest, textStatus, errorThrown) {
                                alert('There was an error');
                            }
                        });
                    }
                });
            });
        </script>
    
    <script type="text/javascript">
		function in_array(array, id) {
			for(var i=0;i<array.length;i++) {
				if(array[i] == id) {
					return true;
				}
			}
			return false;
		}	
		
		function dealcount(ind,dataArray,dlCnt){
			var dealcount = 0;
			for(i=0;i<dataArray.length;i++){
				if(dataArray[i][0]==ind){
					dealcount = dataArray[i][1];
					dataArray[i][1] = (dealcount-0) + (dlCnt-0);
				}
			}
			return dealcount;
		}
		
     	function drawVisualization(dealdata) {
			
						
						
		var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][2]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				for (var i=1;i<arrhead.length;i++){
					if (datayear[j][arrhead[i]])
						totalDeals += datayear[j][arrhead[i]]; 
				}
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push((((datayear[j][arrhead[i]]/totalDeals)*100).toFixed(2))-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			//Graph 1
			var data1 = google.visualization.arrayToDataTable(dataArray);				
						
						
        var chart4 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart4.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var stage = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&s='+encodeURIComponent(stage);
              <?php if($drilldownflag==1){ ?>
             window.location.href = 'svindex.php?'+query_string;
            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart4, 'select', selectHandler);
         chart4. draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );
		  
			//Garaph 2
			var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][3]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				var totalamt = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal amount of the year
				for (var i=1;i<arrhead.length;i++){
					if (datayear[j][arrhead[i]])
						totalamt += datayear[j][arrhead[i]]; 
				}
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push((((datayear[j][arrhead[i]]/totalamt)*100).toFixed(2))-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			//Graph 1
			var data = google.visualization.arrayToDataTable(dataArray);	
			 var chart5 = new google.visualization.ColumnChart(document.getElementById('visualization'));
           function selectHandler2() {
			  var selectedItem = chart5.getSelection()[0];
			  if (selectedItem) {
				var topping = data.getValue(selectedItem.row, 0);
				var stage = data.getColumnLabel(selectedItem.column).toString();
				//alert('The user selected ' + topping +industry);
			   
			   var query_string = 'value=0&y='+topping+'&s='+encodeURIComponent(stage);
				 <?php if($drilldownflag==1){ ?>
				 window.location.href = 'svindex.php?'+query_string;
				<?php } ?>
			  }
			}
			 google.visualization.events.addListener(chart5, 'select', selectHandler2);
			 chart5.draw(data,
				   {
					title:"Amount",
					width:500, height:700,
					hAxis: {title: "Year"},
					vAxis: {title: "Amount"},
				 /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
					isStacked : true
				  }
			  );
			  
			  
			  //Graph 3
			  var data3 = new google.visualization.DataTable();
			  data3.addColumn('string','Stage');
				data3.addColumn('number', 'No of Deals');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(dealdata[i][2]-0);
					dataArray.push(temArray);
				}
			}
			
			data3.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data3.setValue(i,0,dataArray[i][0]);
				data3.setValue(i,1,dataArray[i][1]-0);			
			}
			// Create and draw the visualization.
			new google.visualization.PieChart(document.getElementById('visualization2')).
			  draw(data3, {title:"No of Deal"/*,
      colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
			  
			  
			 //Graph 4
			var data4 = new google.visualization.DataTable();
			data4.addColumn('string','Stage');
			data4.addColumn('number', 'Amount');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(Math.round(dealdata[i][3]-0));
					dataArray.push(temArray);
				}
			}
			
			//console.log(dataArray);
			//console.log(dealdata);
			
			data4.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data4.setValue(i,0,dataArray[i][0]);
				data4.setValue(i,1,dataArray[i][1]-0);			
			}
			 // Create and draw the visualization.
			var chart=new google.visualization.PieChart(document.getElementById('visualization3'));
			chart.draw(data4, {title:"Amount"/*,colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
			google.visualization.events.addListener(chart, 'select', function() {
				var selection = chart.getSelection();
				//console.log(selection);  
			}); 
			
			
			//Fill table
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			
			for(var i=0;i<arrhead.length;i++){
				var tempArr = [];
				for (var j=0; j< dealdata.length ;j++){
					var values = [];
					if (dealdata[j][0]==arrhead[i]){
						if (dealdata[j][2])
							values.push(dealdata[j][2]);
						else
							values.push('0');
							
						if (dealdata[j][3])
							values.push(dealdata[j][3]);
						else
							values.push('0');
							
						tempArr[dealdata[j][1]] =  values;
					}
				}
				dataArray[arrhead[i]] = tempArr;
			}
			
			//console.log(dataArray);
			
			 var tblCont = '';
			 var pintblcnt = '';
			 
			 pintblcnt = '<table> ';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">STAGE</th><tr>';
			 
          	 tblCont = ' ';
			 tblCont = tblCont + '<tr><th style="text-align:center">STAGE</th>';
			 for (var i=0; i< Years.length ;i++){
				tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  tblCont = tblCont + '<tr><th style="text-align:center"></th>';
			 for (var i=0; i< Years.length ;i++){
				if (i==0){
					 pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
				 }
				tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  
			 
//			 tblCont = tblCont + '</thead>';
//			 tblCont = tblCont + '<tbody>';
			 
			 /*for(i=0;i<dataArray.length;i++){
				 console.log(dataArray[i]);
			 }*/
			var val= [];
			
			for(var i=0;i<arrhead.length;i++){
				tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
				pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
				//var flag =0;
				for(var j=0;j<Years.length;j++){
					var deal = '';
					var amt  = '';
					val = dataArray[arrhead[i]][Years[j]];
					if (val){
							deal = val['0'];
							amt = val['1'];
					}
					/*if(flag==1)
						tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
					else*/
					tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
					//flag =1;
				}
				tblCont = tblCont + '<tr>';
				//console.log(dataArray[arrhead[i]]);
			}
			
//			 pintblcnt = pintblcnt + '</thead></table>'; 
//			 tblCont = tblCont + '</tbody>';

			 $('#restable').html(tblCont);	 
			 $('.pinned').html(pintblcnt);
		}
    </script>        
    <? 
     }
else if($type==4 && $vcflagValue==4)
{
?>
    <script language="javascript">
		$(document).ready(function(){
			$("#ldtrend").click(function () {
				if($(".show_hide").attr('class')!='show_hide'){
					var htmlinner = $(".profile-view-title").html();
					$(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');

					//Execute SQL
					$.ajax({
						type : 'POST',
						url  : 'ajxQuery.php',
						dataType : 'json',
						data: {
							sql : '<?php echo addslashes($compRangeSql); ?>',
							typ : '4',
							rng : '<?php echo implode('#',$range);?>',
						},
						success : function(data){
							drawVisualization(data);
							$(".profile-view-title").html(htmlinner);
						},
						error : function(XMLHttpRequest, textStatus, errorThrown) {
							alert('There was an error');
						}
					});
				}
			});
		});
	</script>
   <script type="text/javascript">
		function in_array(array, id) {
			for(var i=0;i<array.length;i++) {
				if(array[i] == id) {
					return true;
				}
			}
			return false;
		}	
		
		function dealcount(ind,dataArray,dlCnt){
			var dealcount = 0;
			for(i=0;i<dataArray.length;i++){
				if(dataArray[i][0]==ind){
					dealcount = dataArray[i][1];
					dataArray[i][1] = (dealcount-0) + (dlCnt-0);
				}
			}
			return dealcount;
		}
		
     	function drawVisualization(dealdata) {
			
		//alert(dealdata.length);
						
		var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][2]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				//var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				/*for (var i=1;i<arrhead.length;i++){
					totalDeals += datayear[j][arrhead[i]]; 
				}*/
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			//Graph 1
			var data1 = google.visualization.arrayToDataTable(dataArray);  
			
			var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
			  var selectedItem = chart6.getSelection()[0];
			  if (selectedItem) {
				var topping = data1.getValue(selectedItem.row, 0);
				var range = data1.getColumnLabel(selectedItem.column).toString();
				//alert('The user selected ' + topping +industry);
			   
			   var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
				 <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
			  }
			}
			 google.visualization.events.addListener(chart6, 'select', selectHandler);
			  chart6.draw(data1,
				   {
					title:"No of Deals",
					width:500, height:700,
					hAxis: {title: "Year"},
					vAxis: {title: "No of Deals"},
					/*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
					isStacked : true
				  }
	
			  );  
			  
			  
			  
			//Graph 2
			var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][3]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				//var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				/*for (var i=1;i<arrhead.length;i++){
					totalDeals += datayear[j][arrhead[i]]; 
				}*/
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			var data = google.visualization.arrayToDataTable(dataArray);  
			
			var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
            function selectHandler2() {
			  var selectedItem = chart7.getSelection()[0];
			  if (selectedItem) {
				var topping = data.getValue(selectedItem.row, 0);
				var range = data.getColumnLabel(selectedItem.column).toString();
				//alert('The user selected ' + topping +industry);
			   
			   var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
				 <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
			  }
			}
			 google.visualization.events.addListener(chart7, 'select', selectHandler2);
			  chart7.draw(data,
				   {
					title:"Amount",
					width:500, height:700,
					hAxis: {title: "Year"},
					vAxis: {title: "Amount"},
					/*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
					isStacked : true
				  }
			  );
			
			//Graph 3
			 var data3 = new google.visualization.DataTable();
			  data3.addColumn('string','Stage');
				data3.addColumn('number', 'No of Deals');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(dealdata[i][2]-0);
					dataArray.push(temArray);
				}
			}
			
			data3.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data3.setValue(i,0,dataArray[i][0]);
				data3.setValue(i,1,dataArray[i][1]-0);			
			}
			
			// Create and draw the visualization.
			  new google.visualization.PieChart(document.getElementById('visualization2')).
				  draw(data3, {title:"No of Deals"/*,
				  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
			
			
			
			//Graph 4
			var data4 = new google.visualization.DataTable();
			data4.addColumn('string','Stage');
			data4.addColumn('number', 'Amount');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(Math.round(dealdata[i][3]-0));
					dataArray.push(temArray);
				}
			}
			
			//console.log(dataArray);
			//console.log(dealdata);
			
			data4.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data4.setValue(i,0,dataArray[i][0]);
				data4.setValue(i,1,dataArray[i][1]-0);			
			}
			
			// Create and draw the visualization.
			  new google.visualization.PieChart(document.getElementById('visualization3')).
				  draw(data4, {title:"Amount"/*,
				  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
			
			
			
			//Fill table
			//Create Head
			var dataArray = [];
			var arrhead = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			
			for(var i=0;i<arrhead.length;i++){
				var tempArr = [];
				for (var j=0; j< dealdata.length ;j++){
					var values = [];
					if (dealdata[j][0]==arrhead[i]){
						if (dealdata[j][2])
							values.push(dealdata[j][2]);
						else
							values.push('0');
							
						if (dealdata[j][3])
							values.push(dealdata[j][3]);
						else
							values.push('0');
							
						tempArr[dealdata[j][1]] =  values;
					}
				}
				dataArray[arrhead[i]] = tempArr;
			}
			
			//console.log(dataArray);
			
			 var tblCont = '';
			 var pintblcnt = '';
			 
			 pintblcnt = '<table>';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">RANGE</th><tr>';
			 
          	 tblCont = ' ';
			 tblCont = tblCont + '<tr><th style="text-align:center">RANGE</th>';
			 for (var i=0; i< Years.length ;i++){
				if (i==0){
					 pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
				 }
				tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  tblCont = tblCont + '<tr><th style="text-align:center"></th>';
			 for (var i=0; i< Years.length ;i++){
				tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  
			 
//			 tblCont = tblCont + '</thead>';
//			 tblCont = tblCont + '<tbody>';
			 
			 /*for(i=0;i<dataArray.length;i++){
				 console.log(dataArray[i]);
			 }*/
			var val= [];
			
			for(var i=0;i<arrhead.length;i++){
				tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
				pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
				//var flag =0;
				for(var j=0;j<Years.length;j++){
					var deal = '';
					var amt  = '';
					val = dataArray[arrhead[i]][Years[j]];
					if (val){
							deal = val['0'];
							amt = val['1'];
					}
					/*if(flag==1)
						tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
					else*/
					tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
					//flag =1;
				}
				
				//console.log(dataArray[arrhead[i]]);
			}
			
			 
//			 tblCont = tblCont + '</tbody>';
//			 pintblcnt = pintblcnt + '</thead></table>';

			 $('#restable').html(tblCont);	 
			 $('.pinned').html(pintblcnt);
	
		}
	</script>
       
    <? 
     }
else if($type==4 && $vcflagValue==5) 
{   ?> 
    	
        <script language="javascript">
		$(document).ready(function(){
			$("#ldtrend").click(function () {
				if($(".show_hide").attr('class')!='show_hide'){
					var htmlinner = $(".profile-view-title").html();
					$(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');

					//Execute SQL
					$.ajax({
						type : 'POST',
						url  : 'ajxQuery.php',
						dataType : 'json',
						data: {
							sql : '<?php echo addslashes($compRangeSql); ?>',
							typ : '4',
							rng : '<?php echo implode('#',$range);?>',
						},
						success : function(data){
							drawVisualization(data);
							$(".profile-view-title").html(htmlinner);
						},
						error : function(XMLHttpRequest, textStatus, errorThrown) {
							alert('There was an error');
						}
					});
				}
			});
		});
	</script>
   <script type="text/javascript">
		function in_array(array, id) {
			for(var i=0;i<array.length;i++) {
				if(array[i] == id) {
					return true;
				}
			}
			return false;
		}	
		
		function dealcount(ind,dataArray,dlCnt){
			var dealcount = 0;
			for(i=0;i<dataArray.length;i++){
				if(dataArray[i][0]==ind){
					dealcount = dataArray[i][1];
					dataArray[i][1] = (dealcount-0) + (dlCnt-0);
				}
			}
			return dealcount;
		}
		
     	function drawVisualization(dealdata) {
			
		//alert(dealdata.length);
						
		var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][2]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				//var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				/*for (var i=1;i<arrhead.length;i++){
					totalDeals += datayear[j][arrhead[i]]; 
				}*/
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			//Graph 1
			var data1 = google.visualization.arrayToDataTable(dataArray);  
			
			var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
			  var selectedItem = chart6.getSelection()[0];
			  if (selectedItem) {
				var topping = data1.getValue(selectedItem.row, 0);
				var range = data1.getColumnLabel(selectedItem.column).toString();
				//alert('The user selected ' + topping +industry);
			   
			   var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
				 <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
			  }
			}
			 google.visualization.events.addListener(chart6, 'select', selectHandler);
			  chart6.draw(data1,
				   {
					title:"No of Deals",
					width:500, height:700,
					hAxis: {title: "Year"},
					vAxis: {title: "No of Deals"},
					/*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
					isStacked : true
				  }
	
			  );  
			  
			  
			  
			//Graph 2
			var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][3]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				//var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				/*for (var i=1;i<arrhead.length;i++){
					totalDeals += datayear[j][arrhead[i]]; 
				}*/
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			var data = google.visualization.arrayToDataTable(dataArray);  
			
			var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
            function selectHandler2() {
			  var selectedItem = chart7.getSelection()[0];
			  if (selectedItem) {
				var topping = data.getValue(selectedItem.row, 0);
				var range = data.getColumnLabel(selectedItem.column).toString();
				//alert('The user selected ' + topping +industry);
			   
			   var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
				 <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
			  }
			}
			 google.visualization.events.addListener(chart7, 'select', selectHandler2);
			  chart7.draw(data,
				   {
					title:"Amount",
					width:500, height:700,
					hAxis: {title: "Year"},
					vAxis: {title: "Amount"},
					/*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
					isStacked : true
				  }
			  );
			
			//Graph 3
			 var data3 = new google.visualization.DataTable();
			  data3.addColumn('string','Stage');
				data3.addColumn('number', 'No of Deals');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(dealdata[i][2]-0);
					dataArray.push(temArray);
				}
			}
			
			data3.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data3.setValue(i,0,dataArray[i][0]);
				data3.setValue(i,1,dataArray[i][1]-0);			
			}
			
			// Create and draw the visualization.
			  new google.visualization.PieChart(document.getElementById('visualization2')).
				  draw(data3, {title:"No of Deals"/*,
				 colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
			
			
			
			//Graph 4
			var data4 = new google.visualization.DataTable();
			data4.addColumn('string','Stage');
			data4.addColumn('number', 'Amount');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));

				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(Math.round(dealdata[i][3]-0));
					dataArray.push(temArray);
				}
			}
			
			//console.log(dataArray);
			//console.log(dealdata);
			
			data4.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data4.setValue(i,0,dataArray[i][0]);
				data4.setValue(i,1,dataArray[i][1]-0);			
			}
			
			// Create and draw the visualization.
			  new google.visualization.PieChart(document.getElementById('visualization3')).
				  draw(data4, {title:"Amount"/*,
				  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
			
		
			//Fill table
			//Create Head
			var dataArray = [];
			var arrhead = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			
			for(var i=0;i<arrhead.length;i++){
				var tempArr = [];
				for (var j=0; j< dealdata.length ;j++){
					var values = [];
					if (dealdata[j][0]==arrhead[i]){
						if (dealdata[j][2])
							values.push(dealdata[j][2]);
						else
							values.push('0');
							
						if (dealdata[j][3])
							values.push(dealdata[j][3]);
						else
							values.push('0');
							
						tempArr[dealdata[j][1]] =  values;
					}
				}
				dataArray[arrhead[i]] = tempArr;
			}
			
			//console.log(dataArray);
			
			 var tblCont = '';
			 var pintblcnt = '';
			 
			 pintblcnt = '<table> ';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">RANGE</th><tr>';
			 
          	 tblCont = ' ';
			 tblCont = tblCont + '<tr><th style="text-align:center">RANGE</th>';
			 for (var i=0; i< Years.length ;i++){
				 if (i==0){
					 pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
				 }
				tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  tblCont = tblCont + '<tr><th style="text-align:center"></th>';
			 for (var i=0; i< Years.length ;i++){
				tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  
			 
//			 tblCont = tblCont + '</thead>';
//			 tblCont = tblCont + '<tbody>';
			 
			 /*for(i=0;i<dataArray.length;i++){
				 console.log(dataArray[i]);
			 }*/
			var val= [];
			
			for(var i=0;i<arrhead.length;i++){
				tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
				pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
				//var flag =0;
				for(var j=0;j<Years.length;j++){
					var deal = '';
					var amt  = '';
					val = dataArray[arrhead[i]][Years[j]];
					if (val){
							deal = val['0'];
							amt = val['1'];
					}
					/*if(flag==1)
						tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
					else*/
					tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
					flag =1;
				}
				
				//console.log(dataArray[arrhead[i]]);
			}
			
			 
//			 tblCont = tblCont + '</tbody>';
//			 pintblcnt = pintblcnt + '</thead></table>';
			 
			 $('#restable').html(tblCont);	 
			 $('.pinned').html(pintblcnt);
			
			  
		}
	</script>
       
    <? 
     }
else if($type==4 && $vcflagValue==3) 
{   ?> 
    	
        <script language="javascript">
		$(document).ready(function(){
			$("#ldtrend").click(function () {
				if($(".show_hide").attr('class')!='show_hide'){
					var htmlinner = $(".profile-view-title").html();
					$(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');

					//Execute SQL
					$.ajax({
						type : 'POST',
						url  : 'ajxQuery.php',
						dataType : 'json',
						data: {
							sql : '<?php echo addslashes($compRangeSql); ?>',
							typ : '4',
							rng : '<?php echo implode('#',$range);?>',
						},
						success : function(data){
							drawVisualization(data);
							$(".profile-view-title").html(htmlinner);
						},
						error : function(XMLHttpRequest, textStatus, errorThrown) {
							alert('There was an error');
						}
					});
				}
			});
		});
	</script>
   <script type="text/javascript">
		function in_array(array, id) {
			for(var i=0;i<array.length;i++) {
				if(array[i] == id) {
					return true;
				}
			}
			return false;
		}	
		
		function dealcount(ind,dataArray,dlCnt){
			var dealcount = 0;
			for(i=0;i<dataArray.length;i++){
				if(dataArray[i][0]==ind){
					dealcount = dataArray[i][1];
					dataArray[i][1] = (dealcount-0) + (dlCnt-0);
				}
			}
			return dealcount;
		}
		
     	function drawVisualization(dealdata) {
			
		//alert(dealdata.length);
						
		var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][2]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				//var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				/*for (var i=1;i<arrhead.length;i++){
					totalDeals += datayear[j][arrhead[i]]; 
				}*/
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			//Graph 1
			var data1 = google.visualization.arrayToDataTable(dataArray);  
			
			var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
			  var selectedItem = chart6.getSelection()[0];
			  if (selectedItem) {
				var topping = data1.getValue(selectedItem.row, 0);
				var range = data1.getColumnLabel(selectedItem.column).toString();
				//alert('The user selected ' + topping +industry);
			   
			   var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
				 <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
			  }
			}
			 google.visualization.events.addListener(chart6, 'select', selectHandler);
			  chart6.draw(data1,
				   {
					title:"No of Deals",
					width:500, height:700,
					hAxis: {title: "Year"},
					vAxis: {title: "No of Deals"},
					/*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
					isStacked : true
				  }
	
			  );  
			  
			  
			  
			//Graph 2
			var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][3]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				//var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				/*for (var i=1;i<arrhead.length;i++){
					totalDeals += datayear[j][arrhead[i]]; 
				}*/
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			var data = google.visualization.arrayToDataTable(dataArray);  
			
			var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
            function selectHandler2() {
			  var selectedItem = chart7.getSelection()[0];
			  if (selectedItem) {
				var topping = data.getValue(selectedItem.row, 0);
				var range = data.getColumnLabel(selectedItem.column).toString();
				//alert('The user selected ' + topping +industry);
			   
			   var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
				 <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
			  }
			}
			 google.visualization.events.addListener(chart7, 'select', selectHandler2);
			  chart7.draw(data,
				   {
					title:"Amount",
					width:500, height:700,
					hAxis: {title: "Year"},
					vAxis: {title: "Amount"},
					/*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
					isStacked : true
				  }
			  );
			
			//Graph 3
			 var data3 = new google.visualization.DataTable();
			  data3.addColumn('string','Stage');
				data3.addColumn('number', 'No of Deals');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(dealdata[i][2]-0);
					dataArray.push(temArray);
				}
			}
			
			data3.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data3.setValue(i,0,dataArray[i][0]);
				data3.setValue(i,1,dataArray[i][1]-0);			
			}
			
			// Create and draw the visualization.
			  new google.visualization.PieChart(document.getElementById('visualization2')).
				  draw(data3, {title:"No of Deals"/*,
				  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
			
			
			
			//Graph 4
			var data4 = new google.visualization.DataTable();
			data4.addColumn('string','Stage');
			data4.addColumn('number', 'Amount');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));

				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(Math.round(dealdata[i][3]-0));
					dataArray.push(temArray);
				}
			}
			
			//console.log(dataArray);
			//console.log(dealdata);
			
			data4.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data4.setValue(i,0,dataArray[i][0]);
				data4.setValue(i,1,dataArray[i][1]-0);			
			}
			
			// Create and draw the visualization.
			  new google.visualization.PieChart(document.getElementById('visualization3')).
				  draw(data4, {title:"Amount"/*,
				  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
			
		
			//Fill table
			//Create Head
			var dataArray = [];
			var arrhead = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			
			for(var i=0;i<arrhead.length;i++){
				var tempArr = [];
				for (var j=0; j< dealdata.length ;j++){
					var values = [];
					if (dealdata[j][0]==arrhead[i]){
						if (dealdata[j][2])
							values.push(dealdata[j][2]);
						else
							values.push('0');
							
						if (dealdata[j][3])
							values.push(dealdata[j][3]);
						else
							values.push('0');
							
						tempArr[dealdata[j][1]] =  values;
					}
				}
				dataArray[arrhead[i]] = tempArr;
			}
			
			//console.log(dataArray);
			
			 var tblCont = '';
			 var pintblcnt = '';
			 
			 pintblcnt = '<table> ';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">RANGE</th><tr>';
			 
          	 tblCont = ' ';
			 tblCont = tblCont + '<tr><th style="text-align:center">RANGE</th>';
			 for (var i=0; i< Years.length ;i++){
				 if (i==0){
					 pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
				 }
				tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  tblCont = tblCont + '<tr><th style="text-align:center"></th>';
			 for (var i=0; i< Years.length ;i++){
				tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  
			 
//			 tblCont = tblCont + '</thead>';
//			 tblCont = tblCont + '<tbody>';
			 
			 /*for(i=0;i<dataArray.length;i++){
				 console.log(dataArray[i]);
			 }*/
			var val= [];
			
			for(var i=0;i<arrhead.length;i++){
				tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
				pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
				//var flag =0;
				for(var j=0;j<Years.length;j++){
					var deal = '';
					var amt  = '';
					val = dataArray[arrhead[i]][Years[j]];
					if (val){
							deal = val['0'];
							amt = val['1'];
					}
					/*if(flag==1)
						tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
					else*/
					tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
					flag =1;
				}
				
				//console.log(dataArray[arrhead[i]]);
			}
			
			 
//			 tblCont = tblCont + '</tbody>';
//			 pintblcnt = pintblcnt + '</thead></table>';
			 
			 $('#restable').html(tblCont);	 
			 $('.pinned').html(pintblcnt);
			
			  
		}
	</script>
       
    <? 
     }
else if($type==5 && $vcflagValue==4)  
{   ?>
    
    	<script language="javascript">
		$(document).ready(function(){
			$("#ldtrend").click(function () {
				if($(".show_hide").attr('class')!='show_hide'){
					var htmlinner = $(".profile-view-title").html();
					$(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');

					//Execute SQL
					$.ajax({
						type : 'POST',
						url  : 'ajxQuery.php',
						dataType : 'json',
						data: {
							sql : '<?php echo addslashes($companysql); ?>',
						},
						success : function(data){
							drawVisualization(data);
							$(".profile-view-title").html(htmlinner);
						},
						error : function(XMLHttpRequest, textStatus, errorThrown) {
							alert('There was an error');
						}
					});
				}
			});
		});
	</script>
   	<script type="text/javascript">
		function in_array(array, id) {
			for(var i=0;i<array.length;i++) {
				if(array[i] == id) {
					return true;
				}
			}
			return false;
		}	
		
		function dealcount(ind,dataArray,dlCnt){
			var dealcount = 0;
			for(i=0;i<dataArray.length;i++){
				if(dataArray[i][0]==ind){
					dealcount = dataArray[i][1];
					dataArray[i][1] = (dealcount-0) + (dlCnt-0);
				}
			}
			return dealcount;
		}
		
     	function drawVisualization(dealdata) {
			
		var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][2]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				//var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				/*for (var i=1;i<arrhead.length;i++){
					totalDeals += datayear[j][arrhead[i]]; 
				}*/
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			

			var data1 = google.visualization.arrayToDataTable(dataArray);  
			
		var chart8=new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart8.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var invtype = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );
		  
		  //Graph 2
		  		var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][3]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				//var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				/*for (var i=1;i<arrhead.length;i++){
					totalDeals += datayear[j][arrhead[i]]; 
				}*/
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			
			var data = google.visualization.arrayToDataTable(dataArray);  
		  
		  var chart9=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart9.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var invtype = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );
		  
		  
		  //Graph 3
		    var data3 = new google.visualization.DataTable();
			data3.addColumn('string','Stage');
			data3.addColumn('number', 'No of Deals');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(dealdata[i][2]-0);
					dataArray.push(temArray);
				}
			}
			
			data3.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data3.setValue(i,0,dataArray[i][0]);
				data3.setValue(i,1,dataArray[i][1]-0);			
			}
		  
		  // Create and draw the visualization.
		  new google.visualization.PieChart(document.getElementById('visualization2')).
			  draw(data3, {title:"By Deal"/*,
			  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
		
		
		//Graph 4
		var data4 = new google.visualization.DataTable();
		data4.addColumn('string','Stage');
		data4.addColumn('number', 'Amount');
		
		//Remove Duplicate and make sum
		var dataArray = [];
		for (var i=0; i< dealdata.length ;i++){
			dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));

			if (dealcnt==0){
				var temArray = [];
				temArray.push(dealdata[i][0]);
				temArray.push(Math.round(dealdata[i][3]-0));
				dataArray.push(temArray);
			}
		}
		
		//console.log(dataArray);
		//console.log(dealdata);
		
		data4.addRows(dataArray.length);
		for (var i=0; i< dataArray.length ;i++){
			data4.setValue(i,0,dataArray[i][0]);
			data4.setValue(i,1,dataArray[i][1]-0);			
		}
	// Create and draw the visualization.
	  new google.visualization.PieChart(document.getElementById('visualization3')).
		  draw(data4, {title:"Amount"/*,
		 colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
		  
		  
		  //Fill table
			//Create Head
			var dataArray = [];
			var arrhead = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			
			for(var i=0;i<arrhead.length;i++){
				var tempArr = [];
				for (var j=0; j< dealdata.length ;j++){
					var values = [];
					if (dealdata[j][0]==arrhead[i]){
						if (dealdata[j][2])
							values.push(dealdata[j][2]);
						else
							values.push('0');
							
						if (dealdata[j][3])
							values.push(dealdata[j][3]);
						else
							values.push('0');
							
						tempArr[dealdata[j][1]] =  values;
					}
				}
				dataArray[arrhead[i]] = tempArr;
			}
			
			//console.log(dataArray);
			
			 var tblCont = '';
			 var pintblcnt = '';
			 
			 pintblcnt = '<table> ';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">INVESTOR</th><tr>';
			 
          	 tblCont = ' ';
			 tblCont = tblCont + '<tr><th style="text-align:center">INVESTOR</th>';
			 for (var i=0; i< Years.length ;i++){
				tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  tblCont = tblCont + '<tr><th style="text-align:center"></th>';
			 for (var i=0; i< Years.length ;i++){
				if (i==0){
					 pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
				 }
				tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  
			 
//			 tblCont = tblCont + '</thead>';
//			 tblCont = tblCont + '<tbody>';
			 
			 /*for(i=0;i<dataArray.length;i++){
				 console.log(dataArray[i]);
			 }*/
			var val= [];
			
			for(var i=0;i<arrhead.length;i++){
				tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
				pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
				//var flag =0;
				for(var j=0;j<Years.length;j++){
					var deal = '';
					var amt  = '';
					val = dataArray[arrhead[i]][Years[j]];
					if (val){
							deal = val['0'];
							amt = val['1'];
					}
					/*if(flag==1)
						tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
					else*/
					tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
					//flag =1;
				}
				tblCont = tblCont + '<tr>';
				//console.log(dataArray[arrhead[i]]);
			}
			
//			 pintblcnt = pintblcnt + '</thead></table>';
//			 tblCont = tblCont + '</tbody>';

			 $('#restable').html(tblCont);	 
			 $('.pinned').html(pintblcnt);
			
		  
		}
		
		</script>
       
    <? 
     }
else if($type==5 && $vcflagValue==5)
{
        ?>
    <script language="javascript">
		$(document).ready(function(){
			$("#ldtrend").click(function () {
				if($(".show_hide").attr('class')!='show_hide'){
					var htmlinner = $(".profile-view-title").html();
					$(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');

					//Execute SQL
					$.ajax({
						type : 'POST',
						url  : 'ajxQuery.php',
						dataType : 'json',
						data: {
							sql : '<?php echo addslashes($companysql); ?>',
						},
						success : function(data){
							drawVisualization(data);
							$(".profile-view-title").html(htmlinner);
						},
						error : function(XMLHttpRequest, textStatus, errorThrown) {
							alert('There was an error');
						}
					});
				}
			});
		});
	</script>
   	<script type="text/javascript">
		function in_array(array, id) {
			for(var i=0;i<array.length;i++) {
				if(array[i] == id) {
					return true;
				}
			}
			return false;
		}	
		
		function dealcount(ind,dataArray,dlCnt){
			var dealcount = 0;
			for(i=0;i<dataArray.length;i++){
				if(dataArray[i][0]==ind){
					dealcount = dataArray[i][1];
					dataArray[i][1] = (dealcount-0) + (dlCnt-0);
				}
			}
			return dealcount;
		}
		
     	function drawVisualization(dealdata) {
			
		var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][2]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				//var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				/*for (var i=1;i<arrhead.length;i++){
					totalDeals += datayear[j][arrhead[i]]; 
				}*/
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			

			var data1 = google.visualization.arrayToDataTable(dataArray);  
			
		var chart8=new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart8.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var invtype = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );
		  
		  //Graph 2
		  		var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][3]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				//var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				/*for (var i=1;i<arrhead.length;i++){
					totalDeals += datayear[j][arrhead[i]]; 
				}*/
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			
			var data = google.visualization.arrayToDataTable(dataArray);  
		  
		  var chart9=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart9.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var invtype = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
               /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );
		  
		  
		  //Graph 3
		    var data3 = new google.visualization.DataTable();
			data3.addColumn('string','Stage');
			data3.addColumn('number', 'No of Deals');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(dealdata[i][2]-0);
					dataArray.push(temArray);
				}
			}
			
			data3.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data3.setValue(i,0,dataArray[i][0]);
				data3.setValue(i,1,dataArray[i][1]-0);			
			}
		  
		  // Create and draw the visualization.
		  new google.visualization.PieChart(document.getElementById('visualization2')).
			  draw(data3, {title:"By Deal"/*,
			  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
		
		
		//Graph 4
		var data4 = new google.visualization.DataTable();
		data4.addColumn('string','Stage');
		data4.addColumn('number', 'Amount');
		
		//Remove Duplicate and make sum
		var dataArray = [];
		for (var i=0; i< dealdata.length ;i++){
			dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));

			if (dealcnt==0){
				var temArray = [];
				temArray.push(dealdata[i][0]);
				temArray.push(Math.round(dealdata[i][3]-0));
				dataArray.push(temArray);
			}
		}
		
		//console.log(dataArray);
		//console.log(dealdata);
		
		data4.addRows(dataArray.length);
		for (var i=0; i< dataArray.length ;i++){
			data4.setValue(i,0,dataArray[i][0]);
			data4.setValue(i,1,dataArray[i][1]-0);			
		}
	// Create and draw the visualization.
	  new google.visualization.PieChart(document.getElementById('visualization3')).
		  draw(data4, {title:"Amount"/*,
		  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
		  
		  //Fill table
			//Create Head
			var dataArray = [];
			var arrhead = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			
			for(var i=0;i<arrhead.length;i++){
				var tempArr = [];
				for (var j=0; j< dealdata.length ;j++){
					var values = [];
					if (dealdata[j][0]==arrhead[i]){
						if (dealdata[j][2])
							values.push(dealdata[j][2]);
						else
							values.push('0');
							
						if (dealdata[j][3])
							values.push(dealdata[j][3]);
						else
							values.push('0');
							
						tempArr[dealdata[j][1]] =  values;
					}
				}
				dataArray[arrhead[i]] = tempArr;
			}
			
			//console.log(dataArray);
			
			 var tblCont = '';
			 var pintblcnt = '';
			 
			 pintblcnt = '<table> ';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">INVESTOR</th><tr>';
			 
          	 tblCont = ' ';
			 tblCont = tblCont + '<tr><th style="text-align:center">INVESTOR</th>';
			 for (var i=0; i< Years.length ;i++){
				tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  tblCont = tblCont + '<tr><th style="text-align:center"></th>';
			 for (var i=0; i< Years.length ;i++){
				if (i==0){
					 pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
				 }
				tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  
			 
//			 tblCont = tblCont + '</thead>';
//			 tblCont = tblCont + '<tbody>';
			 
			 /*for(i=0;i<dataArray.length;i++){
				 console.log(dataArray[i]);
			 }*/
			var val= [];
			
			for(var i=0;i<arrhead.length;i++){
				tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
				pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
				
				//var flag =0;
				for(var j=0;j<Years.length;j++){
					var deal = '';
					var amt  = '';
					val = dataArray[arrhead[i]][Years[j]];
					if (val){
							deal = val['0'];
							amt = val['1'];
					}
					/*if(flag==1)
						tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
					else*/
					tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
					//flag =1;
				}
				tblCont = tblCont + '<tr>';
				//console.log(dataArray[arrhead[i]]);
			}
			
//			 pintblcnt = pintblcnt + '</thead></table>';
//			 tblCont = tblCont + '</tbody>';

			 $('#restable').html(tblCont);	 
			 $('.pinned').html(pintblcnt);
		}
		
		</script>
       
    <? 
     }
else if($type==5 && $vcflagValue==3)
{
        ?>
    <script language="javascript">
		$(document).ready(function(){
			$("#ldtrend").click(function () {
				if($(".show_hide").attr('class')!='show_hide'){
					var htmlinner = $(".profile-view-title").html();
					$(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');

					//Execute SQL
					$.ajax({
						type : 'POST',
						url  : 'ajxQuery.php',
						dataType : 'json',
						data: {
							sql : '<?php echo addslashes($companysql); ?>',
						},
						success : function(data){
							drawVisualization(data);
							$(".profile-view-title").html(htmlinner);
						},
						error : function(XMLHttpRequest, textStatus, errorThrown) {
							alert('There was an error');
						}
					});
				}
			});
		});
	</script>
   	<script type="text/javascript">
		function in_array(array, id) {
			for(var i=0;i<array.length;i++) {
				if(array[i] == id) {
					return true;
				}
			}
			return false;
		}	
		
		function dealcount(ind,dataArray,dlCnt){
			var dealcount = 0;
			for(i=0;i<dataArray.length;i++){
				if(dataArray[i][0]==ind){
					dealcount = dataArray[i][1];
					dataArray[i][1] = (dealcount-0) + (dlCnt-0);
				}
			}
			return dealcount;
		}
		
     	function drawVisualization(dealdata) {
			
		var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][2]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				//var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				/*for (var i=1;i<arrhead.length;i++){
					totalDeals += datayear[j][arrhead[i]]; 
				}*/
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			

			var data1 = google.visualization.arrayToDataTable(dataArray);  
			
		var chart8=new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart8.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var invtype = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );
		  
		  //Graph 2
		  		var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][3]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				//var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				/*for (var i=1;i<arrhead.length;i++){
					totalDeals += datayear[j][arrhead[i]]; 
				}*/
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			
			var data = google.visualization.arrayToDataTable(dataArray);  
		  
		  var chart9=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart9.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var invtype = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );
		  
		  
		  //Graph 3
		    var data3 = new google.visualization.DataTable();
			data3.addColumn('string','Stage');
			data3.addColumn('number', 'No of Deals');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(dealdata[i][2]-0);
					dataArray.push(temArray);
				}
			}
			
			data3.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data3.setValue(i,0,dataArray[i][0]);
				data3.setValue(i,1,dataArray[i][1]-0);			
			}
		  
		  // Create and draw the visualization.
		  new google.visualization.PieChart(document.getElementById('visualization2')).
			  draw(data3, {title:"By Deal"/*,
			  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
		
		
		//Graph 4
		var data4 = new google.visualization.DataTable();
		data4.addColumn('string','Stage');
		data4.addColumn('number', 'Amount');
		
		//Remove Duplicate and make sum
		var dataArray = [];
		for (var i=0; i< dealdata.length ;i++){
			dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));

			if (dealcnt==0){
				var temArray = [];
				temArray.push(dealdata[i][0]);
				temArray.push(Math.round(dealdata[i][3]-0));
				dataArray.push(temArray);
			}
		}
		
		//console.log(dataArray);
		//console.log(dealdata);
		
		data4.addRows(dataArray.length);
		for (var i=0; i< dataArray.length ;i++){
			data4.setValue(i,0,dataArray[i][0]);
			data4.setValue(i,1,dataArray[i][1]-0);			
		}
	// Create and draw the visualization.
	  new google.visualization.PieChart(document.getElementById('visualization3')).
		  draw(data4, {title:"Amount"/*,
		  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
		  
		  //Fill table
			//Create Head
			var dataArray = [];
			var arrhead = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			
			for(var i=0;i<arrhead.length;i++){
				var tempArr = [];
				for (var j=0; j< dealdata.length ;j++){
					var values = [];
					if (dealdata[j][0]==arrhead[i]){
						if (dealdata[j][2])
							values.push(dealdata[j][2]);
						else
							values.push('0');
							
						if (dealdata[j][3])
							values.push(dealdata[j][3]);
						else
							values.push('0');
							
						tempArr[dealdata[j][1]] =  values;
					}
				}
				dataArray[arrhead[i]] = tempArr;
			}
			
			//console.log(dataArray);
			
			 var tblCont = '';
			 var pintblcnt = '';
			 
			 pintblcnt = '<table> ';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">INVESTOR</th><tr>';
			 
          	 tblCont = ' ';
			 tblCont = tblCont + '<tr><th style="text-align:center">INVESTOR</th>';
			 for (var i=0; i< Years.length ;i++){
				tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  tblCont = tblCont + '<tr><th style="text-align:center"></th>';
			 for (var i=0; i< Years.length ;i++){
				if (i==0){
					 pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
				 }
				tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  
			 
//			 tblCont = tblCont + '</thead>';
//			 tblCont = tblCont + '<tbody>';
			 
			 /*for(i=0;i<dataArray.length;i++){
				 console.log(dataArray[i]);
			 }*/
			var val= [];
			
			for(var i=0;i<arrhead.length;i++){
				tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
				pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
				
				//var flag =0;
				for(var j=0;j<Years.length;j++){
					var deal = '';
					var amt  = '';
					val = dataArray[arrhead[i]][Years[j]];
					if (val){
							deal = val['0'];
							amt = val['1'];
					}
					/*if(flag==1)
						tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
					else*/
					tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
					//flag =1;
				}
				tblCont = tblCont + '<tr>';
				//console.log(dataArray[arrhead[i]]);
			}
			
//			 pintblcnt = pintblcnt + '</thead></table>';
//			 tblCont = tblCont + '</tbody>';

			 $('#restable').html(tblCont);	 
			 $('.pinned').html(pintblcnt);
		}
		
		</script>
       
    <? 
     }
else if($type==6 && $vcflagValue==4)  
{    
	?>
    	<script language="javascript">
		$(document).ready(function(){
			$("#ldtrend").click(function () {
				if($(".show_hide").attr('class')!='show_hide'){
					var htmlinner = $(".profile-view-title").html();
					$(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');

					//Execute SQL
					$.ajax({
						type : 'POST',
						url  : 'ajxQuery.php',
						dataType : 'json',
						data: {
							sql : '<?php echo addslashes($companysql); ?>',
						},
						success : function(data){
							drawVisualization(data);
							$(".profile-view-title").html(htmlinner);
						},
						error : function(XMLHttpRequest, textStatus, errorThrown) {
							alert('There was an error');
						}
					});
				}
			});
		});
	</script>
   	<script type="text/javascript">
		function in_array(array, id) {
			for(var i=0;i<array.length;i++) {
				if(array[i] == id) {
					return true;
				}
			}
			return false;
		}	
		
		function dealcount(ind,dataArray,dlCnt){
			var dealcount = 0;
			for(i=0;i<dataArray.length;i++){
				if(dataArray[i][0]==ind){
					dealcount = dataArray[i][1];
					dataArray[i][1] = (dealcount-0) + (dlCnt-0);
				}
			}
			return dealcount;
		}
		
     	function drawVisualization(dealdata) {
		//Grpah 1
		var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][2]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				//var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				/*for (var i=1;i<arrhead.length;i++){
					totalDeals += datayear[j][arrhead[i]]; 
				}*/
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			

		var data1 = google.visualization.arrayToDataTable(dataArray);  
			
		chart11= new google.visualization.ColumnChart(document.getElementById('visualization1'));
        function selectHandler() {
          var selectedItem = chart11.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var reg = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=0&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart11, 'select', selectHandler);
          chart11.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
              /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );
		  
		  
		  //Graph 2
		   var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][3]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				//var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				/*for (var i=1;i<arrhead.length;i++){
					totalDeals += datayear[j][arrhead[i]]; 
				}*/
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			

			var data = google.visualization.arrayToDataTable(dataArray);  
		
		  var chart12=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart12.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var reg = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=0&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart12, 'select', selectHandler2);
         chart12.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );
		  
		  
		  //Graph 3
		    var data3 = new google.visualization.DataTable();
			data3.addColumn('string','Stage');
			data3.addColumn('number', 'No of Deals');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(dealdata[i][2]-0);
					dataArray.push(temArray);
				}
			}
			
			data3.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data3.setValue(i,0,dataArray[i][0]);
				data3.setValue(i,1,dataArray[i][1]-0);			
			}
			
		  // Create and draw the visualization.
		  new google.visualization.PieChart(document.getElementById('visualization2')).
			  draw(data3, {title:"No of Deals"/*,colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
		
		
		//Graph 4
		var data4 = new google.visualization.DataTable();
		data4.addColumn('string','Stage');
		data4.addColumn('number', 'Amount');
		
		//Remove Duplicate and make sum
		var dataArray = [];
		for (var i=0; i< dealdata.length ;i++){
			dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));

			if (dealcnt==0){
				var temArray = [];
				temArray.push(dealdata[i][0]);
				temArray.push(Math.round(dealdata[i][3]-0));
				dataArray.push(temArray);
			}
		}
		
		//console.log(dataArray);
		//console.log(dealdata);
		
		data4.addRows(dataArray.length);
		for (var i=0; i< dataArray.length ;i++){
			data4.setValue(i,0,dataArray[i][0]);
			data4.setValue(i,1,dataArray[i][1]-0);			
		}
		
		// Create and draw the visualization.
		  new google.visualization.PieChart(document.getElementById('visualization3')).
			  draw(data4, {title:"Amount"/*,
			  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
		  
		  
		  //Fill table
			//Create Head
			var dataArray = [];
			var arrhead = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			
			for(var i=0;i<arrhead.length;i++){
				var tempArr = [];
				for (var j=0; j< dealdata.length ;j++){
					var values = [];
					if (dealdata[j][0]==arrhead[i]){
						if (dealdata[j][2])
							values.push(dealdata[j][2]);
						else
							values.push('0');
							
						if (dealdata[j][3])
							values.push(dealdata[j][3]);
						else
							values.push('0');
							
						tempArr[dealdata[j][1]] =  values;
					}
				}
				dataArray[arrhead[i]] = tempArr;
			}
			
			//console.log(dataArray);
			
			 var tblCont = '';
			 var pintblcnt = '';
			 
			 pintblcnt = '<table>';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">REGION</th><tr>';
			 
          	 tblCont = '';
			 tblCont = tblCont + '<tr><th style="text-align:center">REGION</th>';
			 for (var i=0; i< Years.length ;i++){
				tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  tblCont = tblCont + '<tr><th style="text-align:center"></th>';
			 for (var i=0; i< Years.length ;i++){
				if (i==0){
					 pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
				 }
				tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  
			 
//			 tblCont = tblCont + '</thead>';
//			 tblCont = tblCont + '<tbody>';
			 
			 /*for(i=0;i<dataArray.length;i++){
				 console.log(dataArray[i]);
			 }*/
			var val= [];
			
			for(var i=0;i<arrhead.length;i++){
				tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
				pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
				
				//var flag =0;
				for(var j=0;j<Years.length;j++){
					var deal = '';
					var amt  = '';
					val = dataArray[arrhead[i]][Years[j]];
					if (val){
							deal = val['0'];
							amt = val['1'];
					}
					/*if(flag==1)
						tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
					else*/
					tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
					flag =1;
				}
				tblCont = tblCont + '<tr>';
				//console.log(dataArray[arrhead[i]]);
			}
			
//			 pintblcnt = pintblcnt + '</thead></table>';
//			 tblCont = tblCont + '</tbody>';

			 $('#restable').html(tblCont);	 
			 $('.pinned').html(pintblcnt);
		  
		}
      </script>
       
    <? } 
else if($type==6 && $vcflagValue==5) 
{  ?>
    
     	<script language="javascript">
		$(document).ready(function(){
			$("#ldtrend").click(function () {
				if($(".show_hide").attr('class')!='show_hide'){
					var htmlinner = $(".profile-view-title").html();
					$(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');

					//Execute SQL
					$.ajax({
						type : 'POST',
						url  : 'ajxQuery.php',
						dataType : 'json',
						data: {
							sql : '<?php echo addslashes($companysql); ?>',
						},
						success : function(data){
							drawVisualization(data);
							$(".profile-view-title").html(htmlinner);
						},
						error : function(XMLHttpRequest, textStatus, errorThrown) {
							alert('There was an error');
						}
					});
				}
			});
		});
	</script>
   	<script type="text/javascript">
		function in_array(array, id) {
			for(var i=0;i<array.length;i++) {
				if(array[i] == id) {
					return true;
				}
			}
			return false;
		}	
		
		function dealcount(ind,dataArray,dlCnt){
			var dealcount = 0;
			for(i=0;i<dataArray.length;i++){
				if(dataArray[i][0]==ind){
					dealcount = dataArray[i][1];
					dataArray[i][1] = (dealcount-0) + (dlCnt-0);
				}
			}
			return dealcount;
		}
		
     	function drawVisualization(dealdata) {
		//Grpah 1
		var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][2]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				//var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				/*for (var i=1;i<arrhead.length;i++){
					totalDeals += datayear[j][arrhead[i]]; 
				}*/
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			

		var data1 = google.visualization.arrayToDataTable(dataArray);  
			
		chart11= new google.visualization.ColumnChart(document.getElementById('visualization1'));
        function selectHandler() {
          var selectedItem = chart11.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var reg = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=0&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart11, 'select', selectHandler);
          chart11.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );
		  
		  
		  //Graph 2
		   var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][3]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				//var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				/*for (var i=1;i<arrhead.length;i++){
					totalDeals += datayear[j][arrhead[i]]; 
				}*/
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			

			var data = google.visualization.arrayToDataTable(dataArray);  
		
		  var chart12=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart12.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var reg = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=0&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart12, 'select', selectHandler2);
         chart12.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );
		  
		  
		  //Graph 3
		    var data3 = new google.visualization.DataTable();
			data3.addColumn('string','Stage');
			data3.addColumn('number', 'No of Deals');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(dealdata[i][2]-0);
					dataArray.push(temArray);
				}
			}
			
			data3.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data3.setValue(i,0,dataArray[i][0]);
				data3.setValue(i,1,dataArray[i][1]-0);			
			}
			
		  // Create and draw the visualization.
		  new google.visualization.PieChart(document.getElementById('visualization2')).
			  draw(data3, {title:"No of Deals"/*,colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
		
		
		//Graph 4
		var data4 = new google.visualization.DataTable();
		data4.addColumn('string','Stage');
		data4.addColumn('number', 'Amount');
		
		//Remove Duplicate and make sum
		var dataArray = [];
		for (var i=0; i< dealdata.length ;i++){
			dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));

			if (dealcnt==0){
				var temArray = [];
				temArray.push(dealdata[i][0]);
				temArray.push(Math.round(dealdata[i][3]-0));
				dataArray.push(temArray);
			}
		}
		
		//console.log(dataArray);
		//console.log(dealdata);
		
		data4.addRows(dataArray.length);
		for (var i=0; i< dataArray.length ;i++){
			data4.setValue(i,0,dataArray[i][0]);
			data4.setValue(i,1,dataArray[i][1]-0);			
		}
		
		// Create and draw the visualization.
		  new google.visualization.PieChart(document.getElementById('visualization3')).
			  draw(data4, {title:"Amount"/*,
			  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
		  
		  //Fill table
			//Create Head
			var dataArray = [];
			var arrhead = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			
			for(var i=0;i<arrhead.length;i++){
				var tempArr = [];
				for (var j=0; j< dealdata.length ;j++){
					var values = [];
					if (dealdata[j][0]==arrhead[i]){
						if (dealdata[j][2])
							values.push(dealdata[j][2]);
						else
							values.push('0');
							
						if (dealdata[j][3])
							values.push(dealdata[j][3]);
						else
							values.push('0');
							
						tempArr[dealdata[j][1]] =  values;
					}
				}
				dataArray[arrhead[i]] = tempArr;
			}
			
			//console.log(dataArray);
			
			 var tblCont = '';
			 var pintblcnt = '';
			 
			 pintblcnt = '<table>';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">REGION</th><tr>';
			 
          	 tblCont = '';
			 tblCont = tblCont + '<tr><th style="text-align:center">REGION</th>';
			 for (var i=0; i< Years.length ;i++){
				tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  tblCont = tblCont + '<tr><th style="text-align:center"></th>';
			 for (var i=0; i< Years.length ;i++){
				if (i==0){
					 pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
				 }
				tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  
			 
//			 tblCont = tblCont + '</thead>';
//			 tblCont = tblCont + '<tbody>';
			 
			 /*for(i=0;i<dataArray.length;i++){
				 console.log(dataArray[i]);
			 }*/
			var val= [];
			
			for(var i=0;i<arrhead.length;i++){
				tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
				pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
				//var flag =0;
				for(var j=0;j<Years.length;j++){
					var deal = '';
					var amt  = '';
					val = dataArray[arrhead[i]][Years[j]];
					if (val){
							deal = val['0'];
							amt = val['1'];
					}
					/*if(flag==1)
						tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
					else*/
					tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
					flag =1;
				}
				tblCont = tblCont + '<tr>';
				
				//console.log(dataArray[arrhead[i]]);
			}
			
//			 pintblcnt = pintblcnt + '</thead></table>';
//			 tblCont = tblCont + '</tbody>';

			 $('#restable').html(tblCont);	 
			 $('.pinned').html(pintblcnt);
		}
      </script>
    <? 
     }
else if($type==6 && $vcflagValue==3) 
{  ?>
    
     	<script language="javascript">
		$(document).ready(function(){
			$("#ldtrend").click(function () {
				if($(".show_hide").attr('class')!='show_hide'){
					var htmlinner = $(".profile-view-title").html();
					$(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');

					//Execute SQL
					$.ajax({
						type : 'POST',
						url  : 'ajxQuery.php',
						dataType : 'json',
						data: {
							sql : '<?php echo addslashes($companysql); ?>',
						},
						success : function(data){
							drawVisualization(data);
							$(".profile-view-title").html(htmlinner);
						},
						error : function(XMLHttpRequest, textStatus, errorThrown) {
							alert('There was an error');
						}
					});
				}
			});
		});
	</script>
   	<script type="text/javascript">
		function in_array(array, id) {
			for(var i=0;i<array.length;i++) {
				if(array[i] == id) {
					return true;
				}
			}
			return false;
		}	
		
		function dealcount(ind,dataArray,dlCnt){
			var dealcount = 0;
			for(i=0;i<dataArray.length;i++){
				if(dataArray[i][0]==ind){
					dealcount = dataArray[i][1];
					dataArray[i][1] = (dealcount-0) + (dlCnt-0);
				}
			}
			return dealcount;
		}
		
     	function drawVisualization(dealdata) {
		//Grpah 1
		var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][2]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				//var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				/*for (var i=1;i<arrhead.length;i++){
					totalDeals += datayear[j][arrhead[i]]; 
				}*/
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			

		var data1 = google.visualization.arrayToDataTable(dataArray);  
			
		chart11= new google.visualization.ColumnChart(document.getElementById('visualization1'));
        function selectHandler() {
          var selectedItem = chart11.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var reg = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=0&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart11, 'select', selectHandler);
          chart11.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );
		  
		  
		  //Graph 2
		   var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][3]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				//var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				/*for (var i=1;i<arrhead.length;i++){
					totalDeals += datayear[j][arrhead[i]]; 
				}*/
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			

			var data = google.visualization.arrayToDataTable(dataArray);  
		
		  var chart12=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart12.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var reg = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=0&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart12, 'select', selectHandler2);
         chart12.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );
		  
		  
		  //Graph 3
		    var data3 = new google.visualization.DataTable();
			data3.addColumn('string','Stage');
			data3.addColumn('number', 'No of Deals');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(dealdata[i][2]-0);
					dataArray.push(temArray);
				}
			}
			
			data3.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data3.setValue(i,0,dataArray[i][0]);
				data3.setValue(i,1,dataArray[i][1]-0);			
			}
			
		  // Create and draw the visualization.
		  new google.visualization.PieChart(document.getElementById('visualization2')).
			  draw(data3, {title:"No of Deals"/*,colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
		
		
		//Graph 4
		var data4 = new google.visualization.DataTable();
		data4.addColumn('string','Stage');
		data4.addColumn('number', 'Amount');
		
		//Remove Duplicate and make sum
		var dataArray = [];
		for (var i=0; i< dealdata.length ;i++){
			dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));

			if (dealcnt==0){
				var temArray = [];
				temArray.push(dealdata[i][0]);
				temArray.push(Math.round(dealdata[i][3]-0));
				dataArray.push(temArray);
			}
		}
		
		//console.log(dataArray);
		//console.log(dealdata);
		
		data4.addRows(dataArray.length);
		for (var i=0; i< dataArray.length ;i++){
			data4.setValue(i,0,dataArray[i][0]);
			data4.setValue(i,1,dataArray[i][1]-0);			
		}
		
		// Create and draw the visualization.
		  new google.visualization.PieChart(document.getElementById('visualization3')).
			  draw(data4, {title:"Amount"/*,
			  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
		  
		  //Fill table
			//Create Head
			var dataArray = [];
			var arrhead = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			
			for(var i=0;i<arrhead.length;i++){
				var tempArr = [];
				for (var j=0; j< dealdata.length ;j++){
					var values = [];
					if (dealdata[j][0]==arrhead[i]){
						if (dealdata[j][2])
							values.push(dealdata[j][2]);
						else
							values.push('0');
							
						if (dealdata[j][3])
							values.push(dealdata[j][3]);
						else
							values.push('0');
							
						tempArr[dealdata[j][1]] =  values;
					}
				}
				dataArray[arrhead[i]] = tempArr;
			}
			
			//console.log(dataArray);
			
			 var tblCont = '';
			 var pintblcnt = '';
			 
			 pintblcnt = '<table> ';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">REGION</th><tr>';
			 
          	 tblCont = '';
			 tblCont = tblCont + '<tr><th style="text-align:center">REGION</th>';
			 for (var i=0; i< Years.length ;i++){
				tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  tblCont = tblCont + '<tr><th style="text-align:center"></th>';
			 for (var i=0; i< Years.length ;i++){
				if (i==0){
					 pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
				 }
				tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  
			 
//			 tblCont = tblCont + '</thead>';
//			 tblCont = tblCont + '<tbody>';
			 
			 /*for(i=0;i<dataArray.length;i++){
				 console.log(dataArray[i]);
			 }*/
			var val= [];
			
			for(var i=0;i<arrhead.length;i++){
				tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
				pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
				//var flag =0;
				for(var j=0;j<Years.length;j++){
					var deal = '';
					var amt  = '';
					val = dataArray[arrhead[i]][Years[j]];
					if (val){
							deal = val['0'];
							amt = val['1'];
					}
					/*if(flag==1)
						tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
					else*/
					tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
					flag =1;
				}
				tblCont = tblCont + '<tr>';
				
				//console.log(dataArray[arrhead[i]]);
			}
			
//			 pintblcnt = pintblcnt + '</thead></table>';
//			 tblCont = tblCont + '</tbody>';

			 $('#restable').html(tblCont);	 
			 $('.pinned').html(pintblcnt);
		}
      </script>
    <? 
     }
if($type == 14 && $vcflagValue==0 && $_POST)
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
           
           var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
            <?php if($drilldownflag==1){ ?>
             window.location.href = 'svindex.php?'+query_string;
            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
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
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
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
           
           var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
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
      draw(data3, {title:"No of Deals"/*,
      colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount"/*,
     colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
//$('#slidingTable').hide();
<?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
    <? 
    }
    else if($type == 14 && $vcflagValue==1 && $_POST)
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
           
           var query_string = 'value=1&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
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
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
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
           
           var query_string = 'value=1&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
               /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
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
      draw(data3, {title:"No of Deals"/*,
      /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount"/*,
      colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
//$('#slidingTable').hide();
<?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
    <? 
    }
    if($_GET['type']!="")
    { ?>
        <script language="javascript">
		$(document).ready(function(){
                    setTimeout(function (){
                      $( "#ldtrend" ).trigger( "click" );
                    },1000);

                });
        </script>
    <?php }
    mysql_close();
    ?>

    <script type="text/javascript" >
        <?php  /*if($_POST || $vcflagValue==3 || $vcflagValue==4 || $vcflagValue==5)
        { ?>
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
        <?php } */?>
                                        
    </script> 
    
    
    
    
    <style>
        .result-title h2{
            margin-bottom: 0px;
        }
        .other_db_search{
            display: none;            
            width: 100%;
            float: left;
            margin-bottom: 50px;
        }                                
        .other_db_searchresult a{
            margin-left: 5px;
        }
        .other_db_searchresult{
            background: #F2EDE1;
            padding: 10px;
            margin: 0 17px;
            font-weight: bold;
            font-size: 14px;
                                
        }
        .other_loading{
            margin: 0;
            text-align: center;
            font-weight: bold;
        }
        .other_db_link{
            background: #a2753a;
            padding: 2px 5px;
            color: #fff;
            text-decoration: none;
            border-radius: 2px;
        }
         .other_db_link:hover{
            background:#413529;
            color: #fff;
        }
    </style>
    
    <script>
    <?php 
    
     if($VCFlagValue==4)
        {
             $section="PE-Inv-Cleantech";  
        }
        elseif($VCFlagValue==5)
        {
             $section="PE-Inv-Infrastructure";  
        }
        elseif($VCFlagValue==3)
        {
             $section="VC-Inv-Social";  
        }
    
    if($searchallfield!=''){ ?>
        $(document).ready(function(){
            
            <?php if ($company_cnt==0){ ?>
                              $('.other_db_search').css('margin-top','100px');
            <?php } ?>
                
            $('.other_db_search').fadeIn();            
           $.get( "gmail_like_search.php?section=<?php echo $section;?>&search=<?php echo$searchallfield;?>", function( data ) {          
           
            var data = jQuery.parseJSON(data);
            console.log(data);
            
            var html='';            
            html += data.message+' ';
            
            if(data.result ==1){
                 var count=1;
                 $.each( data.sections, function( key, value ) {                   
                        //if(count>1){html +=',';}
                        html += value.html; 
                   count++;
                  });                  
                  //html +='.';
                  $('.other_db_searchresult').html(html);
                  $('.other_db_search').fadeIn();
            }else{
                 $('.other_db_searchresult').html('<p class="other_loading">No matching results found in other database.</p>');
                 $('.other_db_search').fadeOut(10000);
            }            
            
          });
          
          
           $(".other_db_link").live( "click", function() {
              var href = $(this).attr('href');
              $('#other_db_submit').attr('action',href);
              $('#other_db_submit').submit();
              
               return false;
           });
          
          
        });
    <?php } ?>






  $(document).ready(function(){
 <?php if(  ($company_cnt==0) &&    ( trim($invester_filter)!='' || trim($companyauto)!='' ||  trim($sectorsearch)!='' ||  trim($advisorsearchstring_legal)!='' ||  trim($advisorsearchstring_trans)!='' )){
     
     $searchList=$invester_filter.$companyauto.str_replace("'","",trim($sectorsearch)).$advisorsearchstring_legal.$advisorsearchstring_trans;
     if($invester_filter !=''){
         $filed_name = 'investor';
     }else if($companyauto !=''){
         $filed_name = 'company';
     }else if($sectorsearch !=''){
         $filed_name = 'sector';
     }else if($advisorsearchstring_legal !=''){
         $filed_name = 'alegal';
     }else if($advisorsearchstring_trans !=''){
         $filed_name = 'atrans';
     }
     $searchList = explode(',', $searchList);
     $count=0;
     ?>   
       $('.other_db_search').css('margin-top','100px');                                      
       $('.other_db_search').fadeIn();   
       $('.other_db_searchresult').html('');
       var href='';
     <?php  
     foreach ($searchList as $searchtext) {
         $searchallfield = trim($searchtext);
     
         $count++;
  ?>    
       console.log('<?php echo$searchallfield;?>');                                   
       var link ="gmail_like_search.php?section=<?php echo $section;?>-not&search=<?php echo $searchallfield;?>&filed_name=<?php echo $filed_name; ?>";                                   
       var text = 'Click here to search';  
       
        href += '<div class="refine_to_global"> "<?php echo $searchallfield?>" - <a class="refine_to_global_link" style="text-decoration: none;font-family: sans-serif" href="'+link+'" id="refinesearch_<?php echo$count?>" >'+text+'</a><div class="other_db_searchresult refinesearch_<?php echo$count?>" style="font-weight: normal;"></div><div>';
     
 <?php } ?> 

  $('.other_db_searchresult').html('<b style="font-size:15px">Search in other databases</b><br><br><br>'+href);
  
  
   $(".refine_to_global_link").click(function() {
       var getLink = $(this).attr('href');
       var classname = this.id;
       
       $('.'+classname).html('<p class="other_loading">Please wait while we search for results in other databases<br><img  src="images/other_loading.gif"></p>');
        
      // alert(getLink);
       
       $.get(getLink, function( data ) {          
           
            var data = jQuery.parseJSON(data);
            console.log(data);
            
            var html='';            
            html += data.message+' ';
            
            if(data.result ==1){
                 var count=1;
                 $.each( data.sections, function( key, value ) {                   
                        //if(count>1){html +=',';}
                        html += value.html; 
                   count++;
                  });                  
                  //html +='.';
                  $('.'+classname).html(html);
                  $('.other_db_search').fadeIn();
            }else{
                 $('.'+classname).html('<p class="other_loading">No matching results found in other database.</p>');
                 //$('.other_db_search').fadeOut(10000);
            }            
            
          });
          
       return false;
   });
  
  
    $(".other_db_link").live( "click", function() {
    
              var href = $(this).attr('href');
              var searchValue = $(this).attr('data-value');
              
              $('#other_searchallfield').val(searchValue);
              $('#other_db_submit').attr('action',href);
              $('#other_db_submit').submit();
              
               return false;
           });
  
 <?php    } ?>
  });

   
 
 
 
$(".other_db_search").on('click', '.other_db_link', function() {

        var search_val = $(this).attr('data-search_val');
        $('#all_keyword_other').val(search_val);
       });
 
    </script>