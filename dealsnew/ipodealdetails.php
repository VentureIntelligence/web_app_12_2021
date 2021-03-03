<?php
    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
    $tagandor=$_POST['tagandor'];
    $tagradio=$_POST['tagradio'];
    $yearafter=trim($_POST['yearafter']);
  $yearbefore=trim($_POST['yearbefore']);
  $investor_head=$_POST['invhead'];
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '0';
        //echo "<br>*".$value;
        $strvalue = explode("/", $value);
        
        if(sizeof($strvalue)>1)
        {   
            $vcflagValue=$strvalue[1];
            $VCFlagValue=$strvalue[1];
        }
        else
        {
            $vcflagValue=$strvalue[0];
            $VCFlagValue=$strvalue[0];
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
//==================================================================================
    if($vcflagValue==0)
        {$videalPageName="PEIpo";}
        else {$videalPageName="VCIpo";}
        include('checklogin.php');
        $mailurl= curPageURL();
        $getyear = $_REQUEST['y'];
        $getindus = $_REQUEST['i'];
        $getstage = $_REQUEST['s'];
        $getinv = $_REQUEST['inv'];
        $getreg = $_REQUEST['reg'];
        $getrg = $_REQUEST['rg'];
        
         $fetchRecords=true;
        $totalDisplay="";

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
                //     $fixstart=2000;
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
            }elseif (($resetfield=="searchallfield")||($resetfield=="investorsearch")||($resetfield=="sectorsearch")||($resetfield=="companysearch")||($resetfield=="advisorsearch"))
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
            else if(trim($_POST['searchallfield'])!="" || trim($_POST['investorauto_sug'])!=""  || trim($_POST['companysearch'])!="")
            {
            
             $month1=01; 
             $year1 = 2000;
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
        
       if($resetfield=="investorsearch")
        { 
            // $_POST['investorauto_sug']="";
            // $keywordhidden="";
            // $investorsearch="";
            // $investorauto='';

            $investorarray = explode(',', $_POST['investorauto_sug']);
        $pos = array_search($_POST['resetfieldid'], $investorarray);
        $keyword = $investorarray;
        unset($keyword[$pos]);
        $keyword = implode(',', $keyword);
        $_POST['investorauto_sug']=$keyword;
        $investorsearch=$keyword;
        $investorauto=$keyword;

            $_POST['invSale']="--";
            $investorSale="--";
            $_POST['exitstatus']="--";
            $exitstatusvalue="--";

            $sql_investorauto_sug = "select  InvestorId as id,Investor as name from peinvestors where InvestorId IN($keyword) order by InvestorId";

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
                $keyword1=trim($_POST['keywordsearch']);
            if(isset($_POST['investorauto_sug_other'])){
                $investorauto=$_POST['keywordsearch_other'];
                $keyword=trim($_POST['investorauto_sug_other']);
                $keywordsearch = $_POST['investorauto_sug_other'];
                $keywordhidden=ereg_replace(" ","_",$keyword);
                $month1=01; 
                $year1 = 2000;
                $month2= date('n');
                $year2 = date('Y');
            } else if(isset($_POST['investorauto_sug'])){
                
                $keyword=trim($_POST['investorauto_sug']);
                if($keyword != ""){
                    $month1=01; 
                    $year1 = 2000;
                    $month2= date('n');
                    $year2 = date('Y');
                }
            } else if(isset($_POST['investorauto'])){
                $investorauto=$_POST['investorauto'];
                $keywordsearch = $keyword=trim($_POST['keywordsearch']);
                $keywordhidden=trim($_POST['investorauto']);
            }else{
                $keywordsearch = $investorauto = $keyword=$keywordhidden='';
        }
            $sql_investorauto_sug = "select  InvestorId as id,Investor as name from peinvestors where InvestorId IN($keyword) order by InvestorId";

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
        $keywordhidden =ereg_replace(" ","_",$keywordhidden);
        if($resetfield=="companysearch")
        { 
         $_POST['companysearch']="";
         $companysearch="";
         $companyauto='';
        }
        else 
        {
         $companysearch=trim($_POST['companysearch']);
         if($companysearch!=''){
                $searchallfield='';
        }
            $companyauto=$_REQUEST['companyauto'];
        }
        $companysearchhidden=ereg_replace(" ","_",$companysearch);
        
        if($resetfield=="advisorsearch")
        { 
         $_POST['advisorsearch']="";
         $advisorsearch="";
        }
        else 
        {
         $advisorsearch=trim($_POST['advisorsearch']);
        }
        $advisorsearchhidden= trim($advisorsearch);
        $advisorsearch="";
        
        
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
        
        if($resetfield=="industry")
        { 
         // $_POST['industry']="";
         // $industry="";
            $pos = array_search($_POST['resetfieldid'], $_POST['industry']);
            //print_r($_POST['industry']);
            $industry = $_POST['industry'];
            unset($industry[$pos]);
            $_POST['industry'] = $industry; //print_r($industry);exit();

        }
        else 
        {
            $industry=$_POST['industry'];
            if($industry!='--' && count($industry) >0){
                        $searchallfield='';
            }
        }

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
          // echo "<br>___".$exitstatusvalue;
            if($resetfield=="investorSale")
            { 
             $_POST['invSale']="";
             $investorSale="";
            }
            else 
            {
             $investorSale=trim($_POST['invSale']);
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
            

            $notable=false;
            $vcflagValue=$_POST['txtvcFlagValue'];

            $searchallfield=$_POST['searchallfield'];
            $searchallfieldhidden=ereg_replace(" ","-",$searchallfield);

            //  echo "<br>FLAG VALIE--" .$vcflagValue;
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

             if($resetfield=="tagsearch") {

                    /*$_POST['tagsearch']="";
                    $_POST['tagsearch_auto'] = "";
                    $tagsearch = "";
                    $tagkeyword = "";*/
                    $arrayval=explode(",",$_REQUEST['tagsearch_auto']);
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
         if ($investor_head != "--") {
            $invheadSql = "select country from country where countryid='$investor_head'";
            if ($invrs = mysql_query($invheadSql)) {
                while ($myrow = mysql_fetch_array($invrs, MYSQL_BOTH)) {
                    $invheadvalue = $myrow["country"];
                }
            }
        }
                
        $datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
        $splityear1=(substr($year1,2));
        $splityear2=(substr($year2,2));

        if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
        {   $datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
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

    $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';

        $strvalue = explode("/", $value);
        $SelCompRef=$strvalue[0];
        $searchstring=$strvalue[1];
    //$SelCompRef=$value;

    $sql="SELECT pe.PECompanyId, pe.price_to_book, pe.book_value_per_share, pe.price_per_share, pec.companyname, pec.industry, i.industry, pec.sector_business,
    pe.IPOSize,pe.IPOAmount, pe.IPOValuation, DATE_FORMAT( IPODate, '%M-%Y' ) as IPODate ,
    pec.website, pec.city, pec.region,pe.IPOId,Comment,MoreInfor,hideamount,hidemoreinfor,pe.InvestmentDeals,
          pe.Link,pe.EstimatedIRR,pe.MoreInfoReturns,pe.InvestorType, its.InvestorTypeName,Valuation,FinLink,
          Company_Valuation,Sales_Multiple,EBITDA_Multiple,Netprofit_Multiple,InvestorSale,SellingInvestors,ExitStatus,Revenue,EBITDA,PAT,pec.uploadfilename,pe.stakeSold
    FROM ipos AS pe, industry AS i, pecompanies AS pec,investortype as its
    WHERE pec.industry = i.industryid and pe.IPOId=$SelCompRef  and
    pec.PEcompanyId = pe.PECompanyId     and its.InvestorType=pe.InvestorType
    and pe.Deleted=0 order by IPOSize desc,i.industry";
    //echo "<br>".$sql;

    $investorSql="SELECT peinv.IPOId, peinv.InvestorId, inv.Investor,MultipleReturn,InvMoreInfo,IRR
    FROM ipo_investors AS peinv, peinvestors AS inv
    WHERE peinv.IPOId =$SelCompRef
    AND inv.InvestorId = peinv.InvestorId";

    //echo "<Br>Investor".$investorSql;

    $advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame from peinvestments_advisorcompanies as advcomp,
    advisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
    //echo "<Br>".$advcompanysql;



?>

<?php   
        if($strvalue[3]=='Directory'){
            
            $dealvalue=$strvalue[2];
            $topNav = 'Directory'; 
            include_once('dirnew_header.php');
        }else{
            $topNav = 'Deals'; 
            include_once('ipoheader_search.php');
        }
?>
<style>
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
       
.result-cnt {
    padding: 18px;
    /* position: fixed; */
    z-index: 8 !important;
    width: auto;
}
/* Styles */

</style>

<div class="popup_main" id="popup_main" style="display:none;">
  <div class="popup_box">
      <span class="popup_close"><a href="javascript: void(0);">X</a></span>
      <div class="popup_content" id="popup_content">
      </div>
  </div>  
</div>

<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>

 <td class="left-td-bg">
    <div class="acc_main">
     <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div> 
          <div id="panel" style="display:block; overflow:visible; clear:both;">


          <?php include_once('iporefine.php');?>
           <input type="hidden" name="resetfield" value="" id="resetfield"/>
           <input type="hidden" name="resetfieldid" value="" id="resetfieldid"/>
           
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
                                        $studentOption=$trialrow["Student"];
                }
            }
            $hideamount="";
            $hidemoreinfor="";
            $moreinfo_returns="";
            $selling_investors_value="";
        if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
        {
                        $investor_sale_value=$myrow["InvestorSale"];
                        if($investor_sale_value==1)
                           $investor_sale_display="Yes";
                        else
                           $investor_sale_display="No";
                        if($myrow["Company_Valuation"]<=0)
                           $dec_company_valuation=0.00;
                        else
                           $dec_company_valuation=$myrow["Company_Valuation"];
                        if($myrow["Sales_Multiple"]<=0)
                            $dec_sales_multiple=0.00;
                        else
                            $dec_sales_multiple=$myrow["Sales_Multiple"];

                        if($myrow["EBITDA_Multiple"]<=0)
                            $dec_ebitda_multiple=0.00;
                        else
                            $dec_ebitda_multiple=$myrow["EBITDA_Multiple"];
                        if($myrow["Netprofit_Multiple"]<=0)
                            $dec_netprofit_multiple=0.00;
                        else
                            $dec_netprofit_multiple=$myrow["Netprofit_Multiple"];
                            
                            
                        // New Feature 08-08-2016 start 
                
                            if($myrow["price_to_book"]<=0)
                                $price_to_book=0.00;
                            else
                                $price_to_book=$myrow["price_to_book"];
                                
                            
                            if($myrow["book_value_per_share"]<=0)
                                $book_value_per_share=0.00;
                            else
                                $book_value_per_share=$myrow["book_value_per_share"];
                                
                                
                            if($myrow["price_per_share"]<=0)
                                $price_per_share=0.00;
                            else
                                $price_per_share=$myrow["price_per_share"];
                        
                        // New Feature 08-08-2016 end
                
                
                       /* if($myrow["Revenue"]<=0)
                            $dec_revenue=0.00;
                        else*/
                            $dec_revenue=$myrow["Revenue"];

                        /*if($myrow["EBITDA"]<=0)
                            $dec_ebitda=0.00;
                        else*/
                            $dec_ebitda=$myrow["EBITDA"];
                        /*if($myrow["PAT"]<=0)
                            $dec_pat=0.00;
                        else*/
                            $dec_pat=$myrow["PAT"];
                        if(($myrow["SellingInvestors"]!=""))
                        { 
                          //echo "<br>**";
                          $selling_investors_value=$myrow["SellingInvestors"];}
                        else
                        {$selling_investors_value=""; }
                       $valuation=$myrow["Valuation"];
               if($valuation!="")
               {      $valuationdata = explode("\n", $valuation);      }
                        $finlink=$myrow["FinLink"];
                        //echo "<bR>--" .$finlink;
            if($myrow["hideamount"]==1)
            {
                $hideamount="--";
            }
            else
            {
                $hideamount=$myrow["IPOSize"];
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
                        if(($moreinfo_returns=="")&& ($moreinfo_returns==" "))
                        {
                          $moreinfo_returns="";
                        }

            $investmentdeals=$myrow["InvestmentDeals"];
            if($investmentdeals!="")
            {
                $words = array($searchstring);
                $investmentdeals =  highlightWords($investmentdeals, $words);
            }
                        $iposize=$myrow["IPOAmount"];
                        if($iposize<=0)
                        { $iposize="";}
                        $ipovaluation=$myrow["IPOValuation"];
                        if($ipovaluation<=0)
                        {  $ipovaluation="";}
                        if($myrow["stakeSold"]<=0)
                        {  
                            $stakeSold="";
                        } else {
                            $stakeSold = $myrow["stakeSold"];
                        }
                        $exitstatus=$myrow["ExitStatus"];
                        if($exitstatus==0)
                        {
                           $exitsdisplay ="Partial";
                        }
                        else if($exitstatus==1)
                        {
                            $exitsdisplay="Complete";
                        }
                        else
                        {
                            $exitsdisplay="";
                        }
                    $col6=$myrow["Link"];
            $linkstring=str_replace('"','',$col6);
            $linkstring=explode(";",$linkstring);

            $estimatedirrvalue=$myrow['EstimatedIRR'];
            $estimatedirrvalue=trim($estimatedirrvalue);
            
            
             ?>
<td class="profile-view-left" style="width:100%;">

<div class="result-cnt">

<div class="result-title" style="margin-top: 20px;"> 
               <?php 
               if ($companylistrs = mysql_query($companysql))
                     {
                        $company_cnt = mysql_num_rows($companylistrs);
                     }
                    if(!$_POST)
                    {?> 
                         <h2>
                             <?php
                                 /*if($studentOption==1 || $exportToExcel==1)
                                        {*/
                                     ?>
                                          <span class="result-no"><?php echo count($prevNextArr); ?> Results Found (across <?php echo $coscount; ?> cos) </span> 
                                <?php   /*} 
                                        else 
                                        {
                                      ?>
                                             <span class="result-no"> XXX Results Found</span> 
                                   <?php
                                        }*/  
                                     if($VCFlagValue==0)
                                   {
                                   ?>
                                    <span class="result-for">  for PE-backed IPO</span>  
                             <?php }
                                 elseif($VCFlagValue==1) {
                                   ?>
                                    <span class="result-for">  for VC-backed IPO</span>  
                             <?php } ?>        
                         </h2>     
                    <div class="title-links">
                                
                        <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                        <?php 

                        if(($exportToExcel==1))
                             {
                             ?>
                                <input style="margin-left: 5px;" type="button" id="export-btn" class="export_new exlexport"  value="Export" name="showdeal">
                             <?php
                             }
                         ?>
                    </div>
                        <ul class="result-select">  <?php  if($datevalueDisplay1!="" && $datevalueDisplay1!=NULL ) {?>
                          <li><?php  echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li>
                             <?php  } ?> 
                        </ul>
               <?php 
                  }
                  else 
                   { ?> <h2>
                         <?php
                        /*if($studentOption==1 || $exportToExcel==1)
                               {*/
                            ?>
                                 <span class="result-no"><?php echo count($prevNextArr); ?> Results Found (across <?php echo $coscount; ?> cos)</span> 
                       <?php   /*} 
                               else 
                               {
                             ?>
                                    <span class="result-no"> XXX Results Found</span> 
                          <?php
                               }*/  
                  
                       if($VCFlagValue=="0")
                       {
                       ?>
                       <span class="result-for">  for VC-backed IPO</span>  
                       <?php }
                       elseif($VCFlagValue=="1")
                       {
                           ?>
                       <span class="result-for">  for VC-backed IPO</span>  
                       <?php } ?> 
                        </h2>
                          
                <div class="title-links">
                                
                        <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                        <?php 

                        if(($exportToExcel==1))
                             {
                             ?>
                                <input style="margin-left: 5px;" type="button" id="export-btn" class="export_new exlexport"  value="Export" name="showdeal">
                             <?php
                             }
                         ?>
                    </div> 
                <ul class="result-select">
                <?php
                if($industry >0 &&  $industry!=NULL ) {?>
                   <!-- <li> <?php echo $industryvalue; ?><a  onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li> -->
                   <?php $industryarray = explode(",",$industryvalue); 
                                    $industryidarray = explode(",",$industryvalueid); 
                                    foreach ($industryarray as $key=>$value){  ?>
                                      <li>
                                          <?php echo $value; ?><a  onclick="resetmultipleinput('industry',<?php echo $industryidarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                    <?php } ?>
                <?php } if($investorType !="--" && $investorType !=""&& $investorType!=null){ ?>
                <li> 
                    <?php echo $invtypevalue; ?> <a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
                <?php }  
                if ($investor_head != "--" && $investor_head != null) {$drilldownflag = 0;?>
                <li>
                      <?php echo $invheadvalue; ?><a  onclick="resetinput('invhead');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
                <?php } 
                if (($yearafter!= "" || $yearbefore != "")){$drilldownflag=0; ?>
                  <li> 
                     <?php echo $yearafter ."-" .$yearbefore ?><a  onclick="resetinput('yearfounded');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                  </li>
                <?php } 
                if($investorSale==1 && $investorSale!=NULL ){ ?>
                
                       <li>Investor Sale <a  onclick="resetinput('investorSale');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php } if($exitstatusdisplay!="" && $exitstatusdisplay!=NULL ) { ?>
                       
                      <li><?php  echo $exitstatusdisplay; ?><a  onclick="resetinput('investorSale');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php  } if($datevalueDisplay1!="" && $datevalueDisplay1!=NULL ) {?>
                      
                      <li><?php  echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li>
                <?php  }  if(($txtfrm>=0) && ($txtto>0) && ($txtfrm!=NULL) && ($txtto!=NULL)  ) { ?>
                      
                      <li> <?php   echo $txtfrm. "-" .$txtto; ?> <a  onclick="resetinput('returnmultiple');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php } if($keyword!=" " && $keyword!=NULL) { ?>
                      <!-- <li> <?php  echo $invester_filter; ?> <a  onclick="resetinput('investorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li>
                       -->
                       <?php 
                                    $investerarray = explode(",",$invester_filter); 
                                    $investeridarray = explode(",",$invester_filter_id); 
                                    foreach ($investerarray as $key=>$value){  ?>
                                      <li>
                                          <?php echo $value; ?><a  onclick="resetmultipleinput('investorsearch',<?php echo $investeridarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                    <?php } ?>
                <?php } if($advisorsearch!="" && $advisorsearch!=NULL) { ?>
                      <li> <?php echo $advisorsearch; ?> <a  onclick="resetinput('advisorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li>
                <?php } if($companysearch!=" " && $companysearch!=NULL){ ?>
                      <li>  <?php echo $companyauto; ?> <a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                
                <?php }if($searchallfield!="" && $searchallfield!=NULL) {?>
                    <li> <?php echo $searchallfield; ?> <a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php } ?>

                <?php if($tagsearch!="") {?>
                   <!--  <li> <?php echo "tag:".$tagsearch; ?> <a  onclick="resetinput('tagsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li> -->
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
            <li><a class="postlink"  href="ipoindex.php?value=<?php echo $VCFlagValue; ?>"  id="icon-grid-view"><i></i> List  View</a></li>
            <li class="active"><a id="icon-detailed-view" class="postlink" href="ipodealdetails.php?value=<?php echo $SelCompRef;?>/<?php echo $VCFlagValue;?>/<?php echo $searchstring;?>" ><i></i> Detail  View</a></li> 
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
                        <p> <?php  echo curPageURL(); ?>   <input type="hidden" name="message" id="message" value="<?php  echo curPageURL(); ?>" />   <input type="hidden" name="useremail" id="useremail" value="<?php echo $_SESSION['UserEmail']; ?>"  /> </p>
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
        <?php 
        if( $vcflagValue!=10)
        {
        ?>
           
        <div class="detailed-title-links"><h2 style="margin-bottom: -15px;"> <A class="" target="_blank" href='companydetails.php?value=<?php echo $myrow["PECompanyId"];?>/<?php echo ($VCFlagValue==0)?10:11;?>' ><?php echo rtrim($myrow["companyname"]);?></a></h2>
            <?php if ($prevKey!='-1') {?> <a  class="postlink" id="previous" href="ipodealdetails.php?value=<?php echo $prevNextArr[$prevKey]; ?>/<?php echo $VCFlagValue;?>/">< Previous</a><?php } ?> 
            <?php if ($nextKey < count($prevNextArr)) { ?><a class="postlink" id="next" href="ipodealdetails.php?value=<?php echo $prevNextArr[$nextKey]; ?>/<?php echo $VCFlagValue;?>/"> Next > </a>  <?php } ?>
        </div> 
        <?php
        }
        else
        {
        ?>
        <div class="detailed-title-links"><h2 style="margin-bottom: -15px;"> <A class="postlink" href='dircomdetails.php?value=<?php echo $myrow["PECompanyId"];?>/<?php echo ($VCFlagValue==0)?10:11;?>' ><?php echo rtrim($myrow["companyname"]);?></a></h2>
            </div> 
       <?php 
        }
        ?>
        <div class="profilemain">
             <h2>Deal Info  </h2>
             <div class="profiletable">
                <ul>
                    <?php if($hideamount!="") { ?> <li><h4>IPO Size (US $M)</h4><p><?php echo $hideamount;?></p></li> <?php } ?>
                    <?php if($iposize!="") { ?> <li><h4>IPO Price (Rs.)</h4><p><?php echo $iposize;?></p></li> <?php } ?>
                    <?php if($ipovaluation!="") { ?> <li><h4>IPO Valuation (US $M)</h4><p><?php echo $ipovaluation;?></p></li>   <?php } ?>
                    <?php if($stakeSold!="") { ?> <li><h4>Stake Sold</h4><p><?php echo $stakeSold;?> %</p></li>   <?php } ?>
                    <?php if($myrow["IPODate"]!="") { ?> <li><h4>Deal Period</h4><p><?php echo  $myrow["IPODate"];?></p></li>  <?php } ?>
                    <?php if($exitsdisplay!="") { ?><li><h4>Exit Status</h4><p><?php echo $exitsdisplay ;?></p></li><?php } ?>
                  <!--  <li><h4></h4><p></p></li> -->
                    
                </ul>
            </div>
        </div>
    
    
    
      <div class="postContainer postContent masonry-container"> 
       <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
        <h2>Company Info</h2>
        <table cellpadding="0" cellspacing="0" width="100%" class="tableview">
        <tbody>
        <tr>
            <?php
                $companyName=trim($myrow["companyname"]);
                $companyName=strtolower($companyName);
                $compResult=substr_count($companyName,$searchString);
                $compResult1=substr_count($companyName,$searchString1);
                $webdisplay="";
                if(($compResult==0) && ($compResult1==0))
                {
                    $webdisplay=$myrow["website"];
            ?>
                <td><h4>Company</h4>
                    <p><A class="" target="_blank" href='companydetails.php?value=<?php echo $myrow["PECompanyId"];?>/<?php echo ($VCFlagValue==0)?10:11;?>' ><?php echo rtrim($myrow["companyname"]);?></a></p>
                </td>
            <?php
                }
                else
                {
                    $webdisplay="";
            ?>
                <td><h4>Company</h4><p><?php echo ucfirst("$searchString") ;?></p>
                </td>
            <?php
                }
            ?></tr>
          <?php if($myrow["industry"]!="") { ?> <tr><td><h4>Industry</h4><p><?php echo $myrow["industry"];?></p></td></tr> <?php } ?>
        <?php if($webdisplay!="") { ?> <tr><td><h4>Website</h4><p><a href=<?php echo $webdisplay; ?> target="_blank"><?php echo $webdisplay; ?></a></p></td></tr> <?php } ?>
        </tbody>
        </table>
        </div>
        <?php if(nl2br($investmentdeals)!="") { ?>
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
        <h2>Investment Details</h2>    
        <table cellpadding="0" cellspacing="0" width="100%" class="tableview">
        <tbody>
        <tr>
            <td><p style="word-break: break-all;"><?php print nl2br($investmentdeals) ;?></p></td>
        </tr>
        </tbody>
        </table> 
        </div>
        <?php } ?>
          <?php if(nl2br($hidemoreinfor)!="") { ?>
       <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
        <h2>More Details(Overall IPO)</h2>
        <table cellpadding="0" cellspacing="0" width="100%" class="tableview">
        <tbody>
        <tr>
           <td><p><?php print nl2br($hidemoreinfor) ;?></p></td>
        </tr>
        </tbody>
        </table>
        </div>
           <?php } ?>
          
        <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
        <h2>More Info</h2>    
        <table cellpadding="0" cellspacing="0"  class="tableview">
        <tbody> 
            
            <tr>
            <?php
            if($dec_company_valuation >0)
            {
            ?>
                <td colspan="3"><h4>Company Valuation (INR Cr) </h4><p><?php echo $dec_company_valuation ;?></p></td>
             <?php
            } ?>
             </tr>

             
            <tr>
            <?php
            
            if($dec_sales_multiple >0)
            {
            ?>
              <td style='width:30%'><h4>Revenue Multiple </h4><p><?php echo $dec_sales_multiple ;?></p></td>
             <?php
            }else{ echo "<td style='width:30%'></td>"; }

            if($dec_ebitda_multiple >0)
            {
            ?>
              <td style='width:30%'><h4>EBITDA Multiple </h4><p><?php echo $dec_ebitda_multiple ;?></p></td>
             <?php
            }else{ echo "<td style='width:30%'></td>"; }

            if($dec_netprofit_multiple >0)
            {
            ?>
              <td style='width:30%'><h4>PAT Multiple </h4><p ><?php echo $dec_netprofit_multiple ;?></p></td>
             <?php
            }else{ echo "<td style='width:30%'></td>"; }
            ?>
            </tr>
            
            <!-- New Feature 08 - 08 - 2016 start -->
                
            <tr>
                
                <?php if($price_to_book >0) { ?>
                    <td>
                        <h4> Price to Book </h4>
                        <p> <?php echo $price_to_book; ?> </p>
                    </td>
                <?php } ?>
            
            </tr>

            <?php
            if(trim($myrow["Valuation"])!="")
            {
              $valdata=$myrow["Valuation"];
            ?>
            <tr><td colspan="3"><b>Valuation (More Info)</b>
                       <p><?php print nl2br($valdata);?></p>
                </td>
            </tr>
                
        <?php
        }
?>
            <tr>  <td class="more-info" colspan="3">
                              <p><a href="mailto:research@ventureintelligence.com?subject=Request for more deal data-<?php echo $pageTitlemail;?>&body=<?php echo $mailurl;?> ">
                                      Click Here</a> to request more details for this deal. Please specify what details you would like and we will revert with the data points as available.
                              </p></td></tr>
            
            <tr>
            <?php
           
            if($dec_revenue > 0 || $dec_revenue < 0)
            {
            ?>
            <td style='width:30%'><h4>&nbsp;Revenue (INR Cr) </h4><p><?php echo $dec_revenue ;?></p></td>
             <?php
            }
            else{
                if($dec_company_valuation >0 && $dec_sales_multiple >0){
               ?>      
                <td style='width:30%'><h4>&nbsp;Revenue (INR Cr)</h4><p><?php echo  number_format($dec_company_valuation/$dec_sales_multiple, 2, '.', ''); ?></p></td>
             <?php       
                }else{ echo "<td style='width:30%'></td>"; }
            
            }

            
            
            ////////////
            if($dec_ebitda > 0 || $dec_ebitda < 0)
            {
            ?>
            <td style='width:30%'><h4>&nbsp;EBITDA (INR Cr) </h4><p><?php echo $dec_ebitda ;?></p></td>
             <?php
            }
            else{
                if($dec_company_valuation >0 && $dec_ebitda_multiple >0){
               ?>      
               <td style='width:30%'><h4>&nbsp;EBITDA (INR Cr)</h4><p><?php echo  number_format($dec_company_valuation/$dec_ebitda_multiple, 2, '.', '');?></p></td>
             <?php       
                }else{ echo "<td style='width:30%'></td>"; }
            
            }
            
            /////////////
            if($dec_pat > 0 || $dec_pat < 0)
            {
            ?>
            <td style='width:30%'><h4>&nbsp;PAT (INR Cr)</h4><p><?php echo $dec_pat ;?></p></td>
             <?php
            } 
            else{
                if($dec_company_valuation >0 && $dec_netprofit_multiple >0){
            ?>      
               <td style='width:30%'><h4>&nbsp;PAT (INR Cr) </h4><p><?php echo number_format($dec_company_valuation/$dec_netprofit_multiple, 2, '.', ''); ?></p></td>
             <?php       
            }else{ echo "<td style='width:30%'></td>"; }
            
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
        </tbody>
        </table>
    </div>
        <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
        <h2>Investor Info</h2>    
        <table cellpadding="0" cellspacing="0"  class="tableview">
        <tbody>
            <tr>
                <td ><h4>Investors<h4>
                     <p>
                    <?php
                            if ($getcompanyrs = mysql_query($investorSql))
                            {
                                    $AddOtherAtLast="";
                                    $AddUnknowUndisclosedAtLast="";
                                    $bool_returnFlag=0;
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
                    </p>
                </td>
            </tr>
              <?php if($myrow["InvestorTypeName"]!="") { ?><tr><td><h4>Investor Type</h4><p><?php echo $myrow["InvestorTypeName"] ;?></p></td></tr><?php } ?>
              <?php if($exitstatusdisplay!="") { ?><tr><td><h4>Exit Status </h4><p><?php echo $exitstatusdisplay ;?></p></td></tr><?php } ?>
              <?php if($investor_sale_display!="") { ?><tr><td><h4>Investor Sale in IPO?</h4><p><?php echo $investor_sale_display ;?></p></td></tr><?php } ?>
            <?php
             if(($selling_investors_value!="") && ($selling_investors_value!="  "))
             {
             ?>
            <tr><td><h4>Selling Investors</h4><p><?php print nl2br($selling_investors_value);?></p></td></tr>
            <?php
             } ?>
            <?php 
       if(sizeof($linkstring)>0) 
       { 
       ?> 
            <tr><td><h4>Link</h4>
                    <p style="word-break: break-all;">
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
        </tbody>
        </table>
        </div>
      <?php 
     /*  $company_link_Sql =mysql_query("select * from pecompanies_links where PECompanyId='".$myrow['PECompanyId']."'"); 
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
                    <td class="txtBold"><a href="<?php echo BASE_URL; ?>cfsnew/comparers.php" target="_blank">View in CFS Database</a></td>
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
        <h2>Return Info</h2>    
        <table cellpadding="0" cellspacing="0" width="100%" class="tableview">
        <tbody>
        <?php
        if(($estimatedirrvalue!=" ") && ($estimatedirrvalue!=""))
        {
        ?>
            <tr><td ><h4>Estimated Returns </h4><p><?php echo $estimatedirrvalue;?></p></td></tr>
        <?php
        } ?>
        
        <?php
        $invStringArrayCount=count($invReturnString);
        if($bool_returnFlag==1)  //to display the title ifandonlyif atleast one investor has mutliplereturn value >0
         {
        ?>
            <tr ><td><h4>Returns</h4>
                 <p> 
                    <?php
                      for($i=0;$i<$invStringArrayCount;$i++)
                      {
                      //echo "<br>^^^^^".$invReturnString;
                      $invStringToSplit=$invReturnString[$i];
                       $invString  =explode(",",$invStringToSplit);
                       $investorName=$invString[0];
                       $returnValue=$invString[1];
                       $returnIRR=$invString[2];
                       $investormoreinfo=$invMoreInfoString[$i];
                   //echo "<br>****".$invString[1];

                         if($returnValue>0 || $returnIRR>0)
                        {
                  ?>
                          <b><?php echo $investorName;?> </b><?php if($returnValue!='0') {echo", " .$returnValue."x "; }?><?php if($returnIRR!='0'){echo", ".$returnIRR."% (IRR)";}  ?>
                         <br />
                          <?php
                           if( trim($investormoreinfo!="") && ($investormoreinfo!=" "))
                           {
                            echo ($investormoreinfo) ;
                           }
                         ?>

                        

                  <?php echo "<br/>";
                      }
                      }
                  ?>
                 </p>
                 </td>
              </tr>                 
          <?php
                 } 
                 if(trim($moreinfo_returns!="") && ($moreinfo_returns!=" "))
                {
                ?>
                <tr><td ><h4>More Info (Returns)</h4><p><?php print nl2br($moreinfo_returns);?></p></td></tr>
                <?php
                 } ?>

                
                
                
        </tbody>
        </table>
        </div>
      </div>
         </div>
<?php include('dealcompanydetails.php'); ?>
    
    
   </div>  
        <?php }} ?> </td> 
</tr>

</table>
       
    </div>
</form>
<form name=ipodealinfo id="ipodealinfo" method="post" action="exportipo.php">
    <input type="hidden" name="txthideIPOId" value="<?php echo $SelCompRef;?>" >
    <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
</form>

<div class=""></div>

</div>

    <script type="text/javascript">


function BseLinkLoop(DealDate) {
    var CheckDate = new Date(DealDate);
    var Tday = new Date();
    if (((Tday - CheckDate) / (60 * 60 * 1000 * 24)) > 90) {
        var BseLinks = document.getElementsByTagName('a');
        for (var i = 0; i < BseLinks.length; i++) {
            if (BseLinks[i].href.includes('/AttachLive/')) {
                var newLink = BseLinks[i].href.replace('/AttachLive/', '/AttachHis/');
                BseLinks[i].href = newLink;
            }
        }
    }
}


function BseLinkUpdate() {
    var PageURL = window.location.pathname;

    if (PageURL == "/ma/madealdetails.php") {
        var DealDate = document.getElementsByClassName('tablelistview3')[0].getElementsByTagName('td')[7].textContent;
    }
    else if (PageURL == "/dealsnew/dealdetails.php"){
	var DealDate = document.getElementsByClassName('tablelistview3')[1].getElementsByTagName('td')[7].textContent;
    }
    else if (PageURL == "/dealsnew/mandadealdetails.php"){
	var DealDate = document.getElementsByClassName('tablelistview3')[1].getElementsByTagName('td')[5].textContent;
    }
    else if (PageURL == "/dealsnew/ipodealdetails.php" || PageURL == "/dealsnew/angeldealdetails.php"){
	var DealDate = document.getElementsByClassName('profiletable')[0].getElementsByTagName('li')[4].getElementsByTagName('p')[0].textContent
    }

    BseLinkLoop(DealDate);

}


window.onload = BseLinkUpdate()

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

                function resetmultipleinput(fieldname,fieldid)
                {
                  $("#resetfield").val(fieldname);
                  $("#resetfieldid").val(fieldid);
                  
                  //alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }
           /* $('.exlexport').click(function(){ 
             
            $("#ipodealinfo").submit();
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
                                    $("#ipodealinfo").submit();
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
<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 632px; display: none;"></div>
<div class="lb" id="popup-box-copyrights" style="width:650px !important;">
   <span id="expcancelbtn" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <div class="copyright-body" style="text-align: center;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
    </div>
    <div class="cr_entry" style="text-align:center;">
        
        <input type="button" value="I Agree" id="agreebtn" />
    </div>

</div>
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


<?php
mysql_close();
    mysql_close($cnx);
    ?>

