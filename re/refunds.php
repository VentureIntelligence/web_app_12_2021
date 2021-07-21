<?php include_once("../globalconfig.php"); ?>
<?php
        require_once("reconfig.php");
        
        require_once("../dbconnectvi.php");
        error_reporting(1);
        $Db = new dbInvestments();
  
        $videalPageName="REInv";
        include ('checklogin.php');
       
        
        
    
        
        
        
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
                $month1= 01;
                $year1 = date('Y', strtotime(date('Y')." -1  Year"));
                $month2= date('n');
                $year2 = date('Y');
                $fixstart=date('Y', strtotime(date('Y')." -1  Year"));
                $startyear =  $fixstart."-01-01";
                $fixend=date("Y");
                $endyear = date("Y-m-d");
            }
            
            
            
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            
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
            }elseif (($resetfield=="searchallfield")||($resetfield=="keywordsearch")|| ($resetfield=="sectorsearch") ||($resetfield=="companysearch")||($resetfield=="advisorsearch_legal")||($resetfield=="advisorsearch_trans"))
            {
             $month1= 01; 
             $year1 =  date('Y', strtotime(date('Y')." -1  Year"));
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
             $_POST['searchallfield']="";
            }
            else if(trim($_POST['searchallfield'])!="" || trim($_POST['keywordsearch'])!="" || trim($_POST['sectorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="" )
            {
            
             $month1=01; 
             $year1 = 2005;
             $month2= date('n');
             $year2 = date('Y');
            }
            else
            {
             $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : 01;
             $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));;
             $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
             $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
            }
            
            $fixstart=$year1;
            $startyear =  $fixstart."-".$month1."-01";
            $fixend=$year2;
            $endyear =  $fixend."-".$month2."-31";
        }
        
      
  
      

       
        
      


            
       if($_POST)
       {
           
           
           //-----------------------------------Filter exit code---------------------------------------
        $resetfield=$_POST['resetfield'];
        if($resetfield=="investor")
        { 
            $_REQUEST['investorauto']="";
            $_REQUEST['investorsearch']="";
            $investorId="";
            $filterinvtext="";
        }
        
        if($resetfield=="date"){ 
            $_REQUEST['month1']="";$_REQUEST['year1']="";$_REQUEST['month2']="";$_REQUEST['year2']="";$filterdatetext="";
        }
        
        if($resetfield=="type"){ 
            $_REQUEST['type']="";$typesql="";$filtertypetext="";
        }
        
        if($resetfield=="type2"){ 
            $_REQUEST['type2']="";$type2sql="";$filtertype2text="";
        }
        
        if($resetfield=="size"){
            $_REQUEST['sizestart']="";$_REQUEST['sizeend']="";$sizesql="";$filtersizetext="";
        }
        
        if($resetfield=="status"){
            $_REQUEST['status']="";$_REQUEST['cstatus']="";$statussql="";$filterstatustext="";
        }
        
        if($resetfield=="capital"){
            $_REQUEST['capital']="";$capitalsql="";$filtercapitaltext="";
        }
       
        
        
        
        //----------------------------------------Investor code--------------------------------------
        
    
         
        
        
        if($_REQUEST['investorsearch']!="")
        {
            $investorid = $_REQUEST['investorsearch'];
       
            if($investorid !='')
            {
                $investorsql="re.InvestorId=".$investorid;
                $filterinvsql="select Investor from REinvestors re where ".$investorsql;

                $filterinvtext="";
                if ($filterinvrs = mysql_query($filterinvsql))
                {
                    While($myrow7=mysql_fetch_array($filterinvrs, MYSQL_BOTH))
                    {
                            $filterinvtext=$myrow7["Investor"];
                    }

                }

            }
            else{
                $investorsql='';
            }
        }else if($investorId !='')
        {
            $investorsql="re.InvestorId=".$investorId;
            $filterinvsql="select Investor from REinvestors re where ".$investorsql;
            
            $filterinvtext="";
            if ($filterinvrs = mysql_query($filterinvsql))
            {
                While($myrow7=mysql_fetch_array($filterinvrs, MYSQL_BOTH))
                {
                        $filterinvtext=$myrow7["Investor"];
                        $_REQUEST['investorauto']=$filterinvtext;
                        $_REQUEST['investorsearch']=$investorId;
                }
                 
            }
           
        }
        
        
                
            //------------------------------------------Date code----------------------------------------
        $month1=($_REQUEST['month1'] || ($_REQUEST['month1']!="")) ?  $_REQUEST['month1'] : date('n');
        $year1 = ($_REQUEST['year1'] || ($_REQUEST['year1']!="")) ?  $_REQUEST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
        $month2=($_REQUEST['month2'] || ($_REQUEST['month2']!="")) ?  $_REQUEST['month2'] : date('n');
        $year2 = ($_REQUEST['year2'] || ($_REQUEST['year2']!="")) ?  $_REQUEST['year2'] : date('Y');
        if($month1!='' && $year1!='')
            $startyear = $year1."-".$month1."-01";
            $filterfromdate = returnMonthname($month1)."".substr($year1,2);
        if($month2!='' && $year2!='')
            $endyear = $year2."-".$month2."-31";
            $filtertodate = returnMonthname($month2)."".substr($year2,2);
        if($startyear!='' && $endyear !='')
        {
            $datesql = "fd.fundDate between '" .$startyear. "' and '" .$endyear. "'";
            $filterdatetext = $filterfromdate."-".$filtertodate;
        } 
        else{
          
            $datesql ='';
        }
        
        
                     //------------------------------------type code ---------------------------       
        $typesql="";
        if($_REQUEST['type']!="")
        {
            $typ = $_REQUEST['type'];
            foreach($type as $typeid)
            {
                $typesql = $typesql."fts.id = ".$typeid." or ";
            }
            $typesql = substr($typesql, 0, -3);
            $filtertypesql="select fundTypeName from fundType fts where ".$typesql;
            $filtertypetext="";
            if ($filtertypers = mysql_query($filtertypesql))
            {
                While($myrow=mysql_fetch_array($filtertypers, MYSQL_BOTH))
                {
                        $filtertypetext=$filtertypetext.$myrow["fundTypeName"].",";
                }
            }
        }
        else{
            $typesql='';
        }
        $filtertypetext= substr($filtertypetext, 0, -1);
        
        //-------------------------------type2 code---------------------------------
        $type2sql="";
        if($_REQUEST['type2']!="")
        {
            $type2= $_REQUEST['type2'];
            foreach($type2 as $type2id)
            {
                $type2sql = $type2sql."fti.RETypeId = ".$type2id." or ";
            }
            $type2sql = substr($type2sql, 0, -3);
           // $filtertype2sql="select fundTypeName from fundType fti where ".$type2sql;
            $filtertype2sql= "SELECT `REType` FROM realestatetypes fti where ".$type2sql;
            $filtertype2text="";
            if ($filtertype2rs = mysql_query($filtertype2sql))
            {
                While($myrow2=mysql_fetch_array($filtertype2rs, MYSQL_BOTH))
                {
                      //  $filtertype2text=$filtertype2text.$myrow2["REType"].",";
                      $name = $myrow2["REType"];
                      $name=($name!="")?$name:"Other";
                       $filtertype2text=$filtertype2text.$name.",";
                }
            }
        }
        else{
            $type2sql = '';
        }
        $filtertype2text= substr($filtertype2text, 0, -1);
        
        
        //---------------------------------size code--------------------------------
        if($_REQUEST['sizestart']!="" && $_REQUEST['sizeend']!="")
        {
            
            if( ($_POST['sizestart'] > $_POST['sizeend']) || ($_POST['sizestart'] == $_POST['sizeend'])  ){
                 $sizestart= $_POST['sizestart'];
                 $sizeend= 2000;
            }
            else {
            $sizestart= $_POST['sizestart'];
            $sizeend= $_POST['sizeend'];
           
            }
            
            $sizesql = "fd.size between '" .$sizestart. "' and '" .$sizeend. "'";
            $filtersizetext="(USM)".$sizestart."-".$sizeend;
        }
        elseif($_REQUEST['sizestart']!="" && $_REQUEST['sizeend']=="")
        {
            $sizestart= $_REQUEST['sizestart'];
            $sizeend= 2000;
            $sizesql = "fd.size between '" .$sizestart. "' and '" .$sizeend. "'";
            $filtersizetext="(USM)".$sizestart."-".$sizeend;
        }
        elseif($_REQUEST['sizestart']=="" && $_REQUEST['sizeend']>0)
        {
            $sizestart= 0;
            $sizeend= $_REQUEST['sizeend'];
            $sizesql = "fd.size between '" .$sizestart. "' and '" .$sizeend. "'";
            $filtersizetext="(USM)".$sizestart."-".$sizeend;
        }
        else{
            $sizesql = '';
        }
        
        //----------------------------status code------------------------------------
        $statussql='';$cstatussql='';
        if($_REQUEST['status']!="")
        {
            $status= $_REQUEST['status'];
            
            foreach($status as $statusid)
            {
               
                $statussql = $statussql."frs.id = ".$statusid." or ";
                if($statusid==2)
                {
                    if($_REQUEST['cstatus']!="")
                    {
                        $cstatus= $_REQUEST['cstatus'];
                        foreach($cstatus as $cstatusid)
                        {
                            $cstatussql = $cstatussql."fes.id = ".$cstatusid." or ";
                        }
                    }
                }
            }
            
           $statussql = substr($statussql, 0, -3);
           $cstatussql = substr($cstatussql, 0, -3);
           $filterstatus="";
            $filterstatussql="select fundStatus from fundRaisingStatus frs where ".$statussql;
            if ($filterstatusrs = mysql_query($filterstatussql))
            {
                While($myrow4=mysql_fetch_array($filterstatusrs, MYSQL_BOTH))
                {
                        $filterstatus=$filterstatus.$myrow4["fundStatus"].",";
                }
            }
            $filterstatus= substr($filterstatus, 0, -1);
            $filtercstatus="";
            $filtercstatussql="select closeStatus from fundCloseStatus fes where ".$cstatussql;
            if ($filtercstatusrs = mysql_query($filtercstatussql))
            {
                While($myrow4=mysql_fetch_array($filtercstatusrs, MYSQL_BOTH))
                {
                        $filtercstatus=$filtercstatus.$myrow4["closeStatus"].",";
                }
            }
            $filtercstatus= substr($filtercstatus, 0, -1);
            $filterstatustext=$filterstatus."(".$filtercstatus.")";
           
        }
        else{
            $statussql='';
        }
        
        //--------------------capital code----------------------
        $capitalsql='';
        if($_REQUEST['capital']!="")
        {
            $capital= $_REQUEST['capital'];
            foreach($capital as $capitalid)
            {
                $capitalsql = $capitalsql."fcs.id = ".$capitalid." or ";
            }
            $capitalsql = substr($capitalsql, 0, -3);
            $filtercapitalsql="select source from  fundCapitalSource fcs where ".$capitalsql;
            $filtercapitaltext="";
            if ($filtercapitalrs = mysql_query($filtercapitalsql))
            {
                While($myrow3=mysql_fetch_array($filtercapitalrs, MYSQL_BOTH))
                {
                        $filtercapitaltext=$filtercapitaltext.$myrow3["source"].",";
                }
            }
        }
        else{
            $capitalsql='';
        }
        $filtercapitaltext= substr($filtercapitaltext, 0, -1);
        
        //-------------------------------------All filter sql combined code---------------------------
        $filters='';
       if($investorsql !='')
            $filters.= $investorsql." and ";
//        if($filterinvsql !='')
//            $filters.= $filterinvsql." and ";
        if($datesql !='')
            $filters.= "(".$datesql.") and ";
        if($typesql !='')
            $filters.="(". $typesql.") and ";
        if($type2sql !='')
            $filters.= "(".$type2sql.") and ";
        if($sizesql !='')
            $filters.= "(".$sizesql.") and ";
        if($statussql !='')
            $filters.= "(".$statussql.") and ";
        if($cstatussql !='')
            $filters.= "(".$cstatussql.") and ";
        if($capitalsql !='')
            $filters.= "(".$capitalsql.") and ";
            
        
        $filters = substr($filters, 0, -4);
             
       }
	
	else
        {
           //  $filters='';
           $startyear = $year1."-".$month1."-01";
            $endyear = $year2."-".$month2."-31";
         //  $filters = " and fd.fundDate between '" .$startyear. "' and '" .$endyear. "'";
            $filters = "   (fd.fundDate between '" .$startyear. "' and '" .$endyear. "')"; 
        }
               
               
              
                if($filters!=NULL) { $filters="AND ".$filters;}
                      
			
        
            /////////////////////////////////////////////////////////////////////////// refunds query
        $sqltype = "select * from fundType where focus='Stage' AND dbtype='RE' "; 
        $sqltype2 = "SELECT `RETypeId`,`REType` FROM realestatetypes";
        $sqlfundstatus = "select * from fundRaisingStatus";
        $sqlfundClosed = "select * from fundCloseStatus";
        $sqlcapitalsrc = "select * from fundCapitalSource";
        
       
         $sql="SELECT re.InvestorId,re.Investor,fn.fundName,fn.fundId,fd.fundManager,fd.id,DATE_FORMAT( fd.fundDate, '%b-%Y' )as fundDate,fd.size,fts.fundTypeName as stage,fti.REType as sector,frs.fundStatus,fd.fundClosedStatus,fes.closeStatus,fcs.source FROM fundRaisingDetails as fd
                LEFT JOIN REinvestors re ON fd.investorId = re.InvestorId
                LEFT JOIN fundNames fn ON fd.fundName = fn.fundId
                LEFT JOIN fundType fts ON  fd.fundTypeStage=fts.id 
                LEFT JOIN realestatetypes fti ON  fd.REsector=fti.RETypeId 
                LEFT JOIN fundRaisingStatus frs ON fd.fundStatus = frs.id
                LEFT JOIN fundCloseStatus fes ON fd.fundClosedStatus = fes.id
                LEFT JOIN fundCapitalSource fcs ON fd.capitalSource = fcs.id WHERE fd.dbtype='RE' ";
        
        $sql=$sql.$filters; 
     // exit();
         
         
                  
        if($filters!=NULL) {
         //echo $sql; exit();
        }
         
        $sqlTotal ="select count(fd.fundClosedStatus) as count FROM fundRaisingDetails as fd
                LEFT JOIN REinvestors re ON fd.investorId = re.InvestorId
                LEFT JOIN fundNames fn ON fd.fundName = fn.fundId
                LEFT JOIN fundType fts ON  fd.fundTypeStage=fts.id 
                LEFT JOIN realestatetypes fti ON  fd.REsector=fti.RETypeId 
                LEFT JOIN fundRaisingStatus frs ON fd.fundStatus = frs.id
                LEFT JOIN fundCloseStatus fes ON fd.fundClosedStatus = fes.id
                LEFT JOIN fundCapitalSource fcs ON fd.capitalSource = fcs.id WHERE fd.dbtype='RE' ".$filters;
        
        
//        if($_REQUEST['investorsearch']!="")
//        {
//             $investorsearch = $_REQUEST['investorsearch'];
//             empty($sql);
//             
//             $sql="SELECT re.InvestorId,re.Investor,fn.fundName,fn.fundId,fd.fundManager,fd.id,DATE_FORMAT( fd.fundDate, '%b-%Y' )as fundDate,fd.size,fts.fundTypeName as stage,fti.industry as industry,frs.fundStatus,fd.fundClosedStatus,fes.closeStatus,fcs.source FROM fundRaisingDetails as fd
//                LEFT JOIN REinvestors re ON fd.investorId = re.InvestorId
//                LEFT JOIN fundNames fn ON fd.fundName = fn.fundId
//                LEFT JOIN fundType fts ON  fd.fundTypeStage=fts.id 
//                LEFT JOIN reindustry fti ON  fd.fundTypeIndustry=fti.industryid 
//                LEFT JOIN fundRaisingStatus frs ON fd.fundStatus = frs.id
//                LEFT JOIN fundCloseStatus fes ON fd.fundClosedStatus = fes.id
//                LEFT JOIN fundCapitalSource fcs ON fd.capitalSource = fcs.id WHERE fd.dbtype='RE' AND re.Investor='%$investorsearch%' ";    
//             
//             empty($sqlTotal);
//              $sqlTotal ="select count(fd.fundClosedStatus) as count FROM fundRaisingDetails as fd
//                LEFT JOIN REinvestors re ON fd.investorId = re.InvestorId
//                LEFT JOIN fundNames fn ON fd.fundName = fn.fundId
//                LEFT JOIN fundType fts ON  fd.fundTypeStage=fts.id 
//                LEFT JOIN reindustry fti ON  fd.fundTypeIndustry=fti.industryid 
//                LEFT JOIN fundRaisingStatus frs ON fd.fundStatus = frs.id
//                LEFT JOIN fundCloseStatus fes ON fd.fundClosedStatus = fes.id
//                LEFT JOIN fundCapitalSource fcs ON fd.capitalSource = fcs.id WHERE fd.dbtype='RE' AND re.Investor='%$investorsearch%' ";    
//             }
             
             
             
        $orderby="fundDate";
        $ordertype="desc";
        
        $ajaxsql=  urlencode($sql);
        
        if($sql!="" && $orderby!="" && $ordertype!="")
           $sql = $sql . " order by fd.fundDate desc";
	
        $defpage=$vcflagValue;
        $investdef=1;
        $stagedef=1;
        $topNav='Funds';
        
	include_once('reindex_search.php');
        
         $exportToExcel = 0;
    $TrialSql = "select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
                where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
    //echo "<br>---" .$TrialSql;
    if ($trialrs = mysql_query($TrialSql)) {
        while ($trialrow = mysql_fetch_array($trialrs, MYSQL_BOTH)) {
            $exportToExcel = $trialrow["TrialLogin"];
        }
    }
        
   
        
      //  echo "<script>alert('$sql')</script>"
?>


 <?php 
                     //echo $sql;
                        if($sqlrsall = mysql_query($sql))
                        {
                            $sql_cntall = mysql_num_rows($sqlrsall);
                        } 
                        $totalResult = $sql_cntall;
                        
                        if($sql_cntall > 0)
                        {
                            $rec_limit = 20;
                            $rec_count = $sql_cntall;

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

                            $sqlwithlimit=$sql." limit $offset, $rec_limit";
                             //echo "<br> query final-----" .$sqlwithlimit;
                            if ($sqlrs = mysql_query($sqlwithlimit))
                            {
                                $sql_cnt = mysql_num_rows($sqlrs);
                            }
                                     //$searchTitle=" List of Deals";
                        }
                        else
                        {
                             $notable=true;
                        }
?>


<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>

<td class="left-td-bg" >
      <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
    
    <div id="panel" style="display:block; overflow:visible; clear:both;">
        <input type="hidden"  name="searchinvestorid" value="<?php if(isset($_REQUEST['investorsearch'])) echo  $_REQUEST['investorsearch'];  ?>" >
<?php include_once('funds_refine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/> 
    </div>
</div>
</td>

<td class="profile-view-left" style="width:100%;">
   <div class="result-cnt">
    <?php if ($accesserror==1){?>
        <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm">Click here</a></b></div>
            <?php
    exit; 
    }
    ?>
                       
    <div class="result-title">
     <div class="filter-key-result">  
        <div class="lft-cn">
            
            <?php if($filterinvtext !='' || $filtertypetext !='' || $filtertype2text !='' || $filtersizetext !='' || $filterstatustext || $filtercapitaltext || $filterdatetext) { ?>
            <ul class="result-select">
               
                <?php if($filterinvtext !=''){ ?>
                <li><?php echo $filterinvtext; ?><a  onclick="resetinput('investor');"><img src="../dealsnew/images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php }  if($filtertypetext !=''){ ?>
                <li><?php echo $filtertypetext; ?><a  onclick="resetinput('type');"><img src="../dealsnew/images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php } if($filtertype2text !=''){ ?>
                <li><?php echo $filtertype2text; ?><a  onclick="resetinput('type2');"><img src="../dealsnew/images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php }if($filtersizetext !=''){ ?>
                <li><?php echo $filtersizetext; ?><a  onclick="resetinput('size');"><img src="../dealsnew/images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php } if($filterstatustext !=''){ ?>
                <li><?php echo $filterstatustext; ?><a  onclick="resetinput('status');"><img src="../dealsnew/images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php } if($filtercapitaltext !=''){ ?>
                <li><?php echo $filtercapitaltext; ?><a  onclick="resetinput('capital');"><img src="../dealsnew/images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php } if($filterdatetext !=''){ ?>
                <li><?php echo $filterdatetext; ?><a  onclick="resetinput('date');"><img src="../dealsnew/images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php } ?>
                
            </ul>
            <?php } ?>
        </div>  
         <?php 
            $count=0;
            While($myrow=mysql_fetch_array($sqlrs, MYSQL_BOTH))
            {
                        if($count == 0)
                        {
                                $investorid = $myrow["InvestorId"];
                                $count++;
                        }
                        
            }
         ?>
        <div class='result-rt-cnt funds-sec'>
            <div class="filterresult-count">
                <span class="result-no" id="show-total-deal"><?php echo $_SESSION['totresu']=$totalResult;?> Results found</span> 
                <span class="result-amount-no" id="show-total-amount"></span> 
            </div>      
            <div class="alert-note"><div class="alert-para"> </div>
		     <div class="title-links " id="exportbtn">
		         <?php   if(($exportToExcel==1)) {  ?>
		         <br> <input class="export" type="button" id="expshowdeals" value="Export" name="showdeals"></div>
		         <?php } ?>
		    </div>
        </div>     
    </div>    
     
               
    <div class="list-tab"><ul>
    <li class="active"><a class="postlink" href="funds.php"  id="icon-grid-view"><i></i> List  View</a></li>
    <li><a id="icon-detailed-view" class="postlink" href="" ><i></i> Detail View</a></li> 
    </ul>
    </div>
       
    </div>
</div></div>
                      
                        <a id="detailpost" class="postlink"></a>
                        <div class="view-table view-table-list">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
                              
                                <thead><tr>
                         <tr>
                             
                            <th style="width: 242px;" class="header <?php echo ($orderby=="Investor")?$ordertype:""; ?>" id="Investor">Investor Name</th>
                            <!--th style="width: 300px;" style="border-top: 1px solid #999;">Manager</th-->
                            <th style="width: 248px;" class="header <?php echo ($orderby=="fundName")?$ordertype:""; ?>" id="fundName">Fund Name</th>
                            <th style="width: 253px;" style="border-top: 1px solid #999;">Type</th>
                            <th style="width: 230px;" style="border-top: 1px solid #999;">Size (US$M)</th>
                            <th style="width: 237px;" style="border-top: 1px solid #999;">Status</th>
                            <th style="width: 238px;" style="border-top: 1px solid #999;">Capital Source</th>
                            <th style="width: 241px;" class="header <?php echo ($orderby=="fundDate")?$ordertype:""; ?>" id="fundDate">Date</th>
                        </tr>
                    </thead>
                    
                      <tbody id="movies">
                <?php
                if (mysql_num_rows($sqlrs) > 0)
                  {
                     $ah=1; // 
                    
                        $hidecount=0; 
                        mysql_data_seek($sqlrs,0);

                        //Code to add PREV /NEXT
                        $count=0;
                        $investorarray = array();
                        $totalamount=0;
                        $investorId="";
                        
                        While($myrow=mysql_fetch_array($sqlrs))
                        {
                              $VCFlagValue='funds';
                            $dealuv=0;
                            $investorId=$myrow['InvestorId'];
                            $fundId=$myrow['fundId'];
                            
                            $isfinalclose= claculateAmount($sqlTotal,$investorId,$fundId);
                            if($isfinalclose!=0){
                                if($myrow['fundClosedStatus']==3){
                                    $totalamount+=$myrow['size'];
                                }else{
                                    $totalamount=$totalamount;
                                }
                            }else{
                                $totalamount+=$myrow['size'];
                            }
                            
                         
                                    ?>
                         
                           <?php  
                         
                         $in_ve_id_get = $myrow["InvestorId"]; 
                         if($in_ve_id_get) { $in_ve_id= $in_ve_id_get; } else { $in_ve_id=0; }
                         
                        if($ah==1) { ?> 
                         <script>
                        $(document).ready(function() {

                    $('#icon-detailed-view').attr('href' , 'fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/1";?>');

                    }); </script> 
                        <?php }   $_SESSION['fundfirsttolast'][$ah] = $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;
                    ?>
                         <?php
                         
                                    ?>
                         
                                <tr class="details_link"  valueId="<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv;?>">
                                        <td  style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>"><?php if($myrow["Investor"]){ echo $myrow["Investor"]; } else { echo $myrow["fundManager"];  }?></a> </td>
                                        <!--td style="width: 300px;"><a class="postlink" href="" ><?php echo $myrow["fundManager"];?></a></td-->
                                        <td style="width: 300px;" id="tdfundtour<?php echo $myrow["id"]?>" > <a  id="fundtour<?php echo $myrow["id"]?>" class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" ><?php echo $myrow["fundName"];?> </a></td>
                                        <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" >   <?php $name = $myrow["sector"];  $name=($name!="")?$name:"Other";  echo $name ; ?> </a></td>
                                        <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" ><?php echo ($myrow["size"]!=0) ? $myrow["size"] : "-";?></a></td>
                                        <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" ><?php echo ($myrow["fundStatus"]=="Closed") ? $myrow["closeStatus"] : $myrow["fundStatus"];?></a></td>
                                        <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" ><?php echo $myrow["source"];?></a></td>
                                        <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" ><?php echo $myrow["fundDate"];?> </a></td>
                                                   
                                </tr>
                       <?php
                       $ah++;
                        }
                    }     
                    
                ?>
                
                        </tbody>
                        
                        
                  </table>
                       
                </div>			
				
	<?php		
            if($notable==false)
        {
	?>
	 <!-- <div class="pageinationManual"> -->
             <div class="holder" style="float:none; text-align: center;">
             <div class="paginate-wrapper" style="display: inline-block;">
                 <?php
                    $totalpages=  ceil($sql_cntall/$rec_limit);
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
                 <a class="jp-previous jp-disabled" >&#8592;  Previous</a>
                 <?php } else { ?>
                 <a class="jp-previous" >&#8592;  Previous</a>
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
			 </div> 
			
			<!-- </div> -->

						<center>
			<div class="pagination-section"><input type="text" name = "paginaitoninput" id = "paginationinput" class = "paginationtextbox" placeholder = "P.no" onkeyup = "paginationfun(this.value)">
            <button class = "jp-page1 button pagevalue" name="pagination" id="pagination"  type="submit" onclick = "validpagination()">Go</button></div>
			</center>
        <?php } ?>
          
                        
                        
                        
                        
                        
                        <script type="text/javascript" >
        $("#show-total-deal").html('<h2> Total No. of Funds  <?php echo $totalResult; ?></h2>');
        $("#show-total-amount").html('<h2>Amount (US$M) <?php 
         if($totalamount >0)
            {
                echo number_format(round($totalamount));
            }
            else
            {
                echo "--";
            }?></h2>');
</script>

            
	
    </div>
<div class="overview-cnt mt-trend-tab">
        
                       <div class="showhide-link" id="trendnav" style="z-index: 100000">
                         </div>
                            
                       </div>
</td>

</tr>
</table>
 
</div>
</form>
           
           
            <input type="hidden" id="prev" value="<?php echo $prevpage; ?>"/>
            <input type="hidden" id="current" value="<?php echo $currentpage; ?>"/>
            <input type="hidden" id="next" value="<?php echo $nextpage; ?>"/>
            <script src="<?php echo $refUrl; ?>js/listviewfunctions.js"></script>
             
            <script type="text/javascript">
               var  orderby='<?php echo $orderby; ?>';
               var  ordertype='<?php echo $ordertype; ?>';
                $(".jp-next").live("click",function(){
                    
                    if(!$(this).hasClass('jp-disabled')){
                  var  pageno=$("#next").val();
				  $("#paginationinput").val('');
                    loadhtml(pageno,orderby,ordertype);}
                    return  false;
                });
                $(".jp-page").live("click",function(){
                   var pageno=$(this).text();
				   $("#paginationinput").val('');
                    loadhtml(pageno,orderby,ordertype);
                    return  false;
                });
				$(".jp-page1").live("click",function(){
                   var pageno=$(this).val();
                    loadhtml(pageno,orderby,ordertype);
                    return  false;
                });
                $(".jp-previous").live("click",function(){
                    if(!$(this).hasClass('jp-disabled')){
                    var pageno=$("#prev").val();
					$("#paginationinput").val('');
                    loadhtml(pageno,orderby,ordertype);
                    }
                    return  false;
                });
		$(".header").live("click",function(){
                    
                
                    orderby=$(this).attr('id');
                    if($(this).hasClass("asc"))
                    {
                        ordertype="desc";
                    }
                    else
                    {
                        ordertype="asc";
                    }
                    loadhtml(1,orderby,ordertype);
                    return  false;
                });        
				$( document ).ready(function() {

				var x = localStorage.getItem("pageno");
				//alert(x);
				if(x != 'null' && x != null)
				{
				loadhtml(x,orderby,ordertype)
				}
				}); 
               function loadhtml(pageno,orderby,ordertype)
               {
				localStorage.setItem("pageno", pageno);
				$('#paginationinput').val(pageno)


               //alert(pageno+","+orderby+","+ordertype);
                jQuery('#preloading').fadeIn(1000);   
                $.ajax({
                type : 'POST',
                url  : 'ajaxListView_funds.php',
                data: {

                        sql : '<?php echo addslashes($ajaxsql); ?>',
                        totalrecords : '<?php echo addslashes($sql_cntall); ?>',
                        page: pageno,
                        orderby:orderby,
                        ordertype:ordertype
                },
                success : function(data){
                        $(".view-table-list").html(data);
                        $(".jp-current").text(pageno);
                        var  prev=parseInt(pageno)-1
                        if(prev>0)
                        $("#prev").val(pageno-1);
                        else
                        {
                        $("#prev").val(1);
//                        $(".jp-previous").addClass('.jp-disabled').removeClass('.jp-previous');
                        }
                        $("#current").val(pageno);
                        var next=parseInt(pageno)+1;
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
               
               
            $('#expshowdeals').click(function(){ 
                jQuery('#maskscreen').fadeIn();
                jQuery('#popup-box-copyrights').fadeIn();   
                return false;
            });
            
            $('#expshowdealsbt').click(function(){ 
                jQuery('#maskscreen').fadeIn();
                jQuery('#popup-box-copyrights').fadeIn();   
                return false;
            });
               
               
            
               function initExport(){
                    $.ajax({
                        url: 'ajxCheckDownload.php',
                        dataType: 'json',
                        success: function(data){
                            var downloaded = data['recDownloaded'];
                            var exportLimit = data.exportLimit;
                            var currentRec = <?php echo $sql_cntall; ?>;

                            //alert(currentRec + downloaded);
                            var remLimit = exportLimit-downloaded;

                            if (currentRec < remLimit){
                                   
                                hrefval= 'ajax_refunds_export.php';
                                $("#pesearch").attr("action", hrefval);
                                $("#pesearch").submit();
                                jQuery('#preloading').fadeOut();
                                $("#pesearch").attr("action",'refunds.php');
                                  
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
               
                
            </script>
            
            <script type="text/javascript">
		
                $("a.postlink").live('click',function(){
                  
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
                  $("#resetfield").val(fieldname);
                  //alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }
                
            $(document).on('click', 'tr .details_link', function(){ 
                
                idval=$(this).attr("valueId");
                $("#detailpost").attr("href","<?php echo GLOBAL_BASE_URL; ?>dealsnew/investordetails.php?value="+idval).trigger("click");
            });
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

         function claculateAmount($sqlTotal,$investorId,$fundId){
        $sqlfundcheck= $sqlTotal." and fd.fundStatus=2 and fd.fundClosedStatus=3 and fd.investorId='".$investorId."' and fd.fundName='".$fundId."'";
        $fundres = mysql_query($sqlfundcheck) or die(mysql_error());
        $count = mysql_result($fundres, 0 );
        return $count;
    }
    
?>

<?php if($type==1 && $vcflagValue==0){ ?>
    
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
                data.addColumn('number', 'Total no. of Deals');
		data.addColumn('number', 'Announced no. of Deals');
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
            var query_string = 'value=0&y='+topping;
             <?php if($drilldownflag==1){ ?>             
			 	window.location.href = 'index.php?'+query_string;            
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
                                title: 'Total Deals and Announced Deals',
                            },
                            1: {
                                title: 'Amount'
                            }
                        },
//                    colors: ["#FCCB05","#a2753a"],
                     
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 0},
                                2: {targetAxisIndex: 1,type : "bars",curveType: "function"}
                            }
                  }
              );
             
			 //Fill table
			 var pintblcnt = '';
			 var tblCont = '';
			 			 
			 pintblcnt = '<table>';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">Year</th><tr>';
			 //pintblcnt = pintblcnt + '</thead>';
			 //pintblcnt = pintblcnt + '<tbody>';
			 
			 //tblCont = '<thead>';
			 tblCont = tblCont + '<tr><th style="text-align:center">Year</th><th style="text-align:center">Total No. of Deals</th><th style="text-align:center">Announced No. of Deals</th><th style="text-align:center">Amount($m)</th></tr>';
			 //tblCont = tblCont + '</thead>';
			 //tblCont = tblCont + '<tbody>';
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
			 //tblCont = tblCont + '</tbody>';
			 $('#restable').html(tblCont);
			 $('.pinned').html(pintblcnt);
			 
			 //updateTables();
      }
      //google.setOnLoadCallback(drawVisualization);
    </script>
      <?php
        
    } else if($type==2 && $vcflagValue==0) {  //  print_r($deal);   

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
					 window.location.href = 'index.php?'+query_string;
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
                /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
				 window.location.href = 'index.php?'+query_string;
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
			 
          	 //tblCont = '<thead>';
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
			  
			 
			 //tblCont = tblCont + '</thead>';
			// tblCont = tblCont + '<tbody>';
			 
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
			 //tblCont = tblCont + '</tbody>';

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
     }  else if($type == 4 && $vcflagValue==0){
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
				 <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
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
				 <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
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
			 
          	 //tblCont = '<thead>';
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
			  
			 
			 //tblCont = tblCont + '</thead>';
			 //tblCont = tblCont + '<tbody>';
			 
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
			
			 
			 //tblCont = tblCont + '</tbody>';
			 pintblcnt = pintblcnt + '</table>';

			 $('#restable').html(tblCont);	 
			 $('.pinned').html(pintblcnt);
	
		}
	</script>
       
    <?php } else if($type==5 && $vcflagValue==0)  {   ?>
    
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
                                           //console.log(data);
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
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
		  
		  var chart9=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart9.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var invtype = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
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
			 
			 pintblcnt = '<table>';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">INVESTOR</th><tr>';
			 
          	// tblCont = '<thead>';
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
			  
			 
			// tblCont = tblCont + '</thead>';
			// tblCont = tblCont + '<tbody>';
			 
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
			// tblCont = tblCont + '</tbody>';

			 $('#restable').html(tblCont);	 
			 $('.pinned').html(pintblcnt);
			
		  
		}
		
		</script>
       
    <? 
     } else if($type==6 && $vcflagValue==0)  {    
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart12, 'select', selectHandler2);
         chart12.draw(data,
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
			 
          	// tblCont = '<thead>';
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
			  
			 
			// tblCont = tblCont + '</thead>';
			// tblCont = tblCont + '<tbody>';
			 
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
			
			 pintblcnt = pintblcnt + '</table>';
			 //tblCont = tblCont + '</tbody>';

			 $('#restable').html(tblCont);	 
			 $('.pinned').html(pintblcnt);
		  
		}
      </script>
       
    <? }
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
 //mysql_close();
    ?>
 <script type="text/javascript" >
     var containerWidth = $('#container').width();  
        var refineWidth = $('#panel').width();                                                                                
       var searchkeyWidth = $('.result-rt-cnt').width();
       var searchTitleWidth = $('.result-title').width();

       var filtersHeight = $('.filter-key-result').height();
       var tabHeight = $('.list-tab').height();
       var alertHeight = $('.alert-note').height();
             
             
        if (window.innerWidth > 1700)
        {
            var searchTitleHeight = filtersHeight + tabHeight + alertHeight + 10;
            $('.result-select').css({"max-width":1190});
        }
        else if (window.innerWidth > 1024 )
        {
            var searchTitleHeight = filtersHeight + tabHeight + alertHeight-30;
            $('.result-select').css({"max-width":530}); 
         }
        else
        {
            var searchTitleHeight = filtersHeight + tabHeight + alertHeight;
            $('.result-select').css({"max-width":390});

        }
            
            
        $('.result-cnt').width(containerWidth-refineWidth+188);
        var resultcntHeight = $('.result-cnt').height();

        //$('.view-table').css({"margin-top":resultcntHeight});
        $('.expand-table').css({"margin-top":0});
        //$('.view-table').css({"margin-top":window.innerHeight-826});
			 
        $('.btn-slide').click(function(){ 

            var containerWidth = $('#container').width();  
            var refineWidth = $('#panel').width();      
            var searchkeyWidth = $('.result-rt-cnt').width();
            var searchTitleWidth = $('.result-title').width();
            var searchTitleHeight = $('.result-cnt').height(); 

            $('.result-cnt').width(containerWidth-refineWidth-40)
           // $('.result-select').width(searchTitleWidth-searchkeyWidth-250);
            if (window.innerWidth > 1700)
            {
                $('.result-select').css({"max-width":1190});
            }
            else if (window.innerWidth > 1024 )
            {
                $('.result-select').css({"max-width":530});
             }
            else
            {
                $('.result-select').css({"max-width":390});
            }

            if ($('.left-td-bg').width() < 264) {
                $('.result-cnt').width(containerWidth-refineWidth-40); 

                 var searchTitleHeight = $('.result-cnt').height(); 
                             //$('.view-table').css({"margin-top":searchTitleHeight});
                             $('.expand-table').css({"margin-top":0});
            } else {
                $('.result-cnt').width(containerWidth-refineWidth+188); 
                            $('.result-select').width(searchTitleWidth-searchkeyWidth);

                 var searchTitleHeight = $('.result-cnt').height(); 	
                             //$('.view-table').css({"margin-top":searchTitleHeight});
                             $('.expand-table').css({"margin-top":0});
            } 
        });		 
			 
			
        $(window).resize(function() { 		 

            var containerWidth = $('#container').width();   
            var refineWidth = $('#panel').width(); 
            var searchkeyWidth = $('.result-rt-cnt').width();
            var searchTitleWidth = $('.result-title').width();
            var searchTitleHeight = $('.result-cnt').height(); 

            //$('.view-table').css({"margin-top":searchTitleHeight});
            $('.expand-table').css({"margin-top":0});
            //$('.result-select').width(searchTitleWidth-searchkeyWidth);

             if (window.innerWidth > 1700)
            {
                $('.result-select').css({"max-width":1190});
            }
            else if (window.innerWidth > 1024 )
            {
                $('.result-select').css({"max-width":530});
             }
            else
            {
                $('.result-select').css({"max-width":390});
            }
            if ($('.left-td-bg').width() < 264) {
                $('.result-cnt').width(containerWidth-refineWidth+188);  
            } else {
                $('.result-cnt').width(containerWidth-refineWidth-40); 
            } 
        });	
        
        <?php  if(($_SERVER['REQUEST_METHOD']=="GET" )||($_POST))
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
        <?php } ?>
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
    
    
    
    
 <script src="hopscotch.js"></script>
    <script src="demo.js"></script>
      <script type="text/javascript" >
    $(document).ready(function(){       
    
     <?php
    if(isset($_SESSION["demoTour"]) && $_SESSION["demoTour"]=='1'){ ?> 
     hopscotch.startTour(tour, 17);   
     <?php }  ?>
           
           
           
            //// multi select checkbox hide
    $('.ui-multiselect').attr('id','uimultiselect');  
    
    $("#uimultiselect, #uimultiselect span").click(function() {
        if(demotour==1)
                {  showErrorDialog("To follow the guide"); $('.ui-multiselect-menu').hide(); }     
    });
    
             
           });
           
        </script>
         <?php  mysql_close();   ?>

		 <script>
        function paginationfun(val)
        {
            $(".pagevalue").val(val);
        }

		function validpagination()
        {
            var pageval = $("#paginationinput").val();
            if(pageval == "")
            {
                alert('Please enter the page Number...');
                location.reload();
            }else{
                
            }
        }
		var wage = document.getElementById("paginationinput");
        wage.addEventListener("keydown", function (e) {debugger;
            if (e.code === "Enter") {  //checks whether the pressed key is "Enter"
                //paginationForm();
                event.preventDefault();
                document.getElementById("pagination").click();

            }
        });
    </script>

<style>
        .paginationtextbox{
            width:2.6%;
			padding: 3px;
        }

		input[type='text']::placeholder
    {   
        text-align: center;      /* for Chrome, Firefox, Opera */
    }
        .button{
            background-color: #a2753a; /* Green */
            border: none;
            color: white;
            padding: 4px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
        }
        .pageinationManual{
            display: flex;
			position: absolute;
            left: 40%;
        }
    </style>