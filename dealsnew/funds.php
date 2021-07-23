<?php include_once("../globalconfig.php"); ?>
<?php
       
        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
        $vcflagValue = isset($_REQUEST['value']) ? $_REQUEST['value'] : 0; 
        include ('checklogin.php');
        if(!isset($_REQUEST['investorauto'])){
            $investorId = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        }  else {
            $investorId="";
        }
        
        //-----------------------------------Filter exit code---------------------------------------
        $resetfield=$_POST['resetfield'];
        if($resetfield=="investor")
        { 
            // $_REQUEST['investorauto']="";
            // $_REQUEST['investorsearch']="";
            // $investorId="";
            // $filterinvtext="";
            $_REQUEST['investorsearch'] = explode(',', $_REQUEST['investorsearch']);
            $pos = array_search($_POST['resetfieldid'], $_REQUEST['investorsearch']);
            $investorId = $_REQUEST['investorsearch'];
            unset($investorId[$pos]);
            $investorId = implode(',', $investorId);
            
            $_REQUEST['investorsearch']=$investorId;
            if($investorId !='')
            {
                $investorsql="pi.InvestorId IN(".$investorId.") ";
                $filterinvsql="select Investor from peinvestors pi where ".$investorsql;

                $filterinvtext="";
                $c=1;
                if ($filterinvrs = mysql_query($filterinvsql))
                {

                    While($myrow7=mysql_fetch_array($filterinvrs, MYSQL_BOTH))
                    {
                            
                       if($c==1) { $filterinvtext.= $myrow7["Investor"]; }
                       else { $filterinvtext.= ", ".$myrow7["Investor"]; }
                       $c++;
                    }

                }
                $_REQUEST['investorauto']=$filterinvtext;
            } else {
                $filterinvtext="";
                $_REQUEST['investorauto']=$filterinvtext;
            }
        }
        
        if($resetfield=="searchallfield"){
            $_REQUEST['searchallfield']="";$searchallfieldsql="";$searchallfieldstext="";
        }
        
        if($resetfield=="date"){ 
            $_REQUEST['month1']="";$_REQUEST['year1']="";$_REQUEST['month2']="";$_REQUEST['year2']="";$filterdatetext="";
        }
        
        if($resetfield=="type"){ 
            $_REQUEST['type']="";$typesql="";$filtertypetext="";
        }
        
        if($resetfield=="type2"){ 
            //$_REQUEST['type2']="";$type2sql="";$filtertype2text="";
            $pos = array_search($_POST['resetfieldid'], $_REQUEST['type2']);
            $type2 = $_REQUEST['type2'];
            unset($type2[$pos]);
            $_REQUEST['type2'] = $type2;

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
        
    
        
        if($_REQUEST['searchallfield']!="")
        {
            $searchallfield = $_REQUEST['searchallfield'];
                 
                $searchallfieldsql=" ( fn.fundName LIKE '%$searchallfield%'   OR      pi.Investor LIKE '%$searchallfield%'    OR      fd.moreInfo LIKE '%$searchallfield%' )";
                $searchallfieldstext=$searchallfield;
           
        }else if($_REQUEST['investorsearch']!="")
        {
            
            $investorid = $_REQUEST['investorsearch'];
            $filterinvtext = $_REQUEST['investorauto'];
            $investorsql=" pi.InvestorId IN(".$investorid.") ";
       /*
            if($investorid !='')
            {
                $investorsql="pi.InvestorId IN(".$investorid.") ";
                $filterinvsql="select Investor from peinvestors pi where ".$investorsql;

                $filterinvtext="";
                $c=1;
                if ($filterinvrs = mysql_query($filterinvsql))
                {
                    While($myrow7=mysql_fetch_array($filterinvrs, MYSQL_BOTH))
                    {
                            
                       if($c==1) { $filterinvtext.= $myrow7["Investor"]; }
                       else { $filterinvtext.= ", ".$myrow7["Investor"]; }
                       $c++;
                    }

                }

            }
            else{
                $investorsql='';
            }
        * */
            
                }
//        else if($investorId !='')
//        {
//            $investorsql="pi.InvestorId=".$investorId;
//            $filterinvsql="select Investor from peinvestors pi where ".$investorsql;
//            
//            $filterinvtext="";
//            if ($filterinvrs = mysql_query($filterinvsql))
//            {
//                While($myrow7=mysql_fetch_array($filterinvrs, MYSQL_BOTH))
//                {
//                        $filterinvtext=$myrow7["Investor"];
//                        $_REQUEST['investorauto']=$filterinvtext;
//                        $_REQUEST['investorsearch']=$investorId;
//                }
//                 
//            }
//           
//        }
                 
           
       //------------------------------------------Date code----------------------------------------
        //echo $_REQUEST['month2'];
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
            $type = $_REQUEST['type'];
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
                $type2sql = $type2sql."fti.id = ".$type2id." or ";
            }
            $type2sql = substr($type2sql, 0, -3);
            $filtertype2sql="select fundTypeName,id from fundType fti where ".$type2sql;
            $filtertype2text="";
            $filtertype2id="";
            if ($filtertype2rs = mysql_query($filtertype2sql))
            {
                While($myrow2=mysql_fetch_array($filtertype2rs, MYSQL_BOTH))
                {
                        $filtertype2text=$filtertype2text.$myrow2["fundTypeName"].",";
                        $filtertype2id=$filtertype2id.$myrow2["id"].",";
                }
            }
        }
        else{
            $type2sql = '';
        }
        $filtertype2text= substr($filtertype2text, 0, -1);
        $filtertype2id= substr($filtertype2id, 0, -1);
        
        //---------------------------------size code--------------------------------
        if($_REQUEST['sizestart']!="" && $_REQUEST['sizeend']!="")
        {
            if(($_POST['sizestart'] == $_POST['sizeend']) || ($_POST['sizestart'] > $_POST['sizeend']) ){
            $sizestart= $_REQUEST['sizestart'];
                 $sizeend= 2000;
            }
            else {
            $sizestart= $_REQUEST['sizestart'];
            $sizeend= $_REQUEST['sizeend'];
           
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
        else if($_REQUEST['sizestart']=="" && $_REQUEST['sizeend']>0)
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
     /*   if($_REQUEST['status']!="")
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
        }*/
        
        if($_REQUEST['status']!="")
        {
            $status= $_REQUEST['status'];
            
            if($status==1){
                
                $statussql = "frs.id = ".$status;

                $filterstatus="";
                $filterstatussql="select fundStatus from fundRaisingStatus frs where ".$statussql;
                if ($filterstatusrs = mysql_query($filterstatussql))
                {
                    While($myrow4=mysql_fetch_array($filterstatusrs, MYSQL_BOTH))
                    {
                       $filterstatus=$filterstatus.$myrow4["fundStatus"].",";
                    }
                }
                 
                $filterstatustext= substr($filterstatus, 0, -1);
            }else{
                
                $statussql = "frs.id = ".$status;
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
                
                if($_REQUEST['cstatus']!="")
                {
                    $cstatus= $_REQUEST['cstatus'];
                    foreach($cstatus as $cstatusid)
                    {
                        $cstatussql = $cstatussql."fes.id = ".$cstatusid." or ";
                    }
                }
                $cstatussql = substr($cstatussql, 0, -3);
                //$cstatussql = "fes.id = 1 or fes.id = 2 or fes.id=3 ";
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
        
        
        if($searchallfieldsql !='')
            $filters.= $searchallfieldsql." and ";
        if($investorsql !='')
            $filters.= $investorsql." and ";
        
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
        if($filters !='')
            $filters= " and ".$filters;
        //------------------------------ All Quries-------------------------------------------
        $sqltype = "select * from fundType where focus='Stage'  AND dbtype='PE' "; 
        $sqltype2 = "select * from fundType where focus='Industry'";
        $sqlfundstatus = "select * from fundRaisingStatus";
        $sqlfundClosed = "select * from fundCloseStatus";
        $sqlcapitalsrc = "select * from fundCapitalSource";
        $sql="SELECT pi.InvestorId,pi.Investor,fn.fundName,fn.fundId,fd.fundManager,fd.id,DATE_FORMAT( fd.fundDate, '%b-%Y' )as fundDate,fd.size,fts.fundTypeName as stage,fti.fundTypeName as industry,frs.fundStatus,fd.fundClosedStatus,fes.closeStatus,fcs.source, fd.amount_raised, fd.hideaggregate FROM fundRaisingDetails as fd
                LEFT JOIN peinvestors pi ON fd.investorId = pi.InvestorId
                LEFT JOIN fundNames fn ON fd.fundName = fn.fundId
                LEFT JOIN fundType fts ON  fd.fundTypeStage=fts.id 
                LEFT JOIN fundType fti ON  fd.fundTypeIndustry=fti.id 
                LEFT JOIN fundRaisingStatus frs ON fd.fundStatus = frs.id
                LEFT JOIN fundCloseStatus fes ON fd.fundClosedStatus = fes.id
                LEFT JOIN fundCapitalSource fcs ON fd.capitalSource = fcs.id WHERE fd.dbtype='PE' ";
        $sql=$sql.$filters;
        $sqlAmount = "SELECT SUM( fd.amount_raised ) as AmountRaisedTotal FROM fundRaisingDetails as fd
                LEFT JOIN peinvestors pi ON fd.investorId = pi.InvestorId
                LEFT JOIN fundNames fn ON fd.fundName = fn.fundId
                LEFT JOIN fundType fts ON  fd.fundTypeStage=fts.id 
                LEFT JOIN fundType fti ON  fd.fundTypeIndustry=fti.id 
                LEFT JOIN fundRaisingStatus frs ON fd.fundStatus = frs.id
                LEFT JOIN fundCloseStatus fes ON fd.fundClosedStatus = fes.id
                LEFT JOIN fundCapitalSource fcs ON fd.capitalSource = fcs.id WHERE fd.dbtype='PE' and fd.hideaggregate !='1' ";
        $sqlAmount = $sqlAmount . $filters;
        $sqlTotal ="select count(fd.fundClosedStatus) as count FROM fundRaisingDetails as fd
                LEFT JOIN peinvestors pi ON fd.investorId = pi.InvestorId
                LEFT JOIN fundNames fn ON fd.fundName = fn.fundId
                LEFT JOIN fundType fts ON  fd.fundTypeStage=fts.id 
                LEFT JOIN fundType fti ON  fd.fundTypeIndustry=fti.id 
                LEFT JOIN fundRaisingStatus frs ON fd.fundStatus = frs.id
                LEFT JOIN fundCloseStatus fes ON fd.fundClosedStatus = fes.id
                LEFT JOIN fundCapitalSource fcs ON fd.capitalSource = fcs.id WHERE fd.dbtype='PE' and fd.hideaggregate !='1' ".$filters;
        $orderby="fundDate";
        $ordertype="desc";
        
        $ajaxsql=  urlencode($sql);
        if($sql!="" && $orderby!="" && $ordertype!="")
           $sql = $sql . " order by fd.fundDate desc";
    
        $defpage=$vcflagValue;
        $investdef=1;
        $stagedef=1;
        $topNav='Funds';
        
    include_once('funds_header_search.php');
        
        
          $exportToExcel = 0;
    $TrialSql = "select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
                where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
    
    //echo "<br>---" .$TrialSql;
    if ($trialrs = mysql_query($TrialSql)) {
        while ($trialrow = mysql_fetch_array($trialrs, MYSQL_BOTH)) {
            $exportToExcel = $trialrow["TrialLogin"];
        }
    }
           
?>

<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>

<td class="left-td-bg" >
    <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
    
    <div id="panel" style="display:block; overflow:visible; clear:both;">
<?php include_once('funds_refine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>
     <input type="hidden" name="resetfieldid" value="" id="resetfieldid"/>  
</div>
    </div>
</td>
            <?php 
                     //echo $sql;
                        if($sqlrsall = mysql_query($sql))
                        {
                            $sql_cntall = mysql_num_rows($sqlrsall);
                        } 
                        $totalResult = $sql_cntall;
                        
                        if($sql_cntall > 0)
                        {
                            $rec_limit = 50;
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
                            // echo "<div style='display:none'><br> query final-----" .$sqlwithlimit."</div>";
                           //  echo "<br> query final-----" .$sqlwithlimit;
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

<td class="profile-view-left" style="width:100%;">
    

<div class="result-cnt funds-tab">
    <?php if ($accesserror==1){?>
        <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm">Click here</a></b></div>
            <?php
    exit; 
    }
    $sqlRes = mysql_query( $sqlAmount );
    $resultTotl = mysql_fetch_array( $sqlRes );
    ?>
                       
    <div class="result-title">
     <div class="filter-key-result">  
        <div class="lft-cn">
            <ul class="result-select">
                <li class="result-select-close"><a id="overall-close" href="funds.php"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
                <?php if($filterinvtext !=''){ ?>
                <!-- <li><?php echo $filterinvtext; ?><a  onclick="resetinput('investor');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li> -->
                <?php $industryarray = explode(",",$filterinvtext); 
                                    $industryidarray = explode(",",$investorid); 
                                    foreach ($industryarray as $key=>$value){  ?>
                                      <li>
                                          <?php echo $value; ?><a  onclick="resetmultipleinput('investor',<?php echo $industryidarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                    <?php } ?>

                <?php }  if($filtertypetext !=''){ ?>
                <li><?php echo $filtertypetext; ?><a  onclick="resetinput('type');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php } if($filtertype2text !=''){ ?>
                <!-- <li><?php echo $filtertype2text; ?><a  onclick="resetinput('type2');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li> -->
                <?php $filtertype2array = explode(",",$filtertype2text); 
                                    $filtertype2idarray = explode(",",$filtertype2id); 
                                    foreach ($filtertype2array as $key=>$value){  ?>
                                      <li>
                                          <?php echo $value; ?><a  onclick="resetmultipleinput('type2',<?php echo $filtertype2idarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                    <?php } ?>
                <?php }if($filtersizetext !=''){ ?>
                <li><?php echo $filtersizetext; ?><a  onclick="resetinput('size');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php } if($filterstatustext !=''){ ?>
                <li><?php echo $filterstatustext; ?><a  onclick="resetinput('status');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php } if($filtercapitaltext !=''){ ?>
                <li><?php echo $filtercapitaltext; ?><a  onclick="resetinput('capital');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php } if($filterdatetext !=''){ ?>
                <li><?php echo $filterdatetext; ?><a  onclick="resetinput('date');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php }if($searchallfieldstext !=''){ ?>
                <li><?php echo $searchallfieldstext; ?><a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                <?php } ?>
                
            </ul>
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
        <div class='result-rt-cnt'>
            <?php   if(($exportToExcel==1)) {  ?>    
            <div class="fund-export title-links" id="exportbtn">
                <a class="export_new" id="expshowdeals" name="showdeals">Export</a>
            </div>
            <?php } ?>
            <div class="filterresult-count">
                <span class="result-no" id="show-total-deal"><?php echo $_SESSION['totresu']=$totalResult;?> Results found</span> 
                <span class="result-amount-no" id="show-total-amount"></span> 
            </div>  
        </div>
     
     <div class="alert-note"><div class="alert-para"> </div>
     <!-- <div class="title-links " id="exportbtn"> -->
         <?php   if(($exportToExcel==1)) {  ?>
         <!-- <br> <input class="export" type="button" id="expshowdeals" value="Export" name="showdeals"></div> -->
         <?php } ?>
    </div>
        
    </div>    
     
               
    <div class="list-tab"><ul>
    <li class="active"><a class="postlink" href="funds.php"  id="icon-grid-view"><i></i> List  View</a></li>
    <li><a id="icon-detailed-view" class="postlink" href="fundinvestordetails.php?value=<?php echo $investorid;?>" ><i></i> Detail View</a></li> 
    </ul>
    </div>
       
    </div>
</div>
</div>    
<?php

        if($notable==false)
        {
        ?>    
          
            <a id="detailpost" class="postlink"></a>
            <div class="view-table view-table-list ">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
                    <thead><tr>
                         <tr>
                             
                            <th style="width: 242px;" class="header <?php echo ($orderby=="Investor")?$ordertype:""; ?>" id="Investor">Investor Name</th>
                            <!--th style="width: 300px;" style="border-top: 1px solid #999;">Manager</th-->
                            <th style="width: 248px;" class="header <?php echo ($orderby=="fundName")?$ordertype:""; ?>" id="fundName">Fund Name</th>
                            <th style="width: 253px;" class="header <?php echo ($orderby=="industry")?$ordertype:""; ?>" style="border-top: 1px solid #999;" id="industry">Type</th>
                            <th style="width: 230px;" class="header <?php echo ($orderby=="size")?$ordertype:""; ?>" style="border-top: 1px solid #999;" id="size">Target Size ($USM)</th>
                            <th style="width: 230px;" class="header <?php echo ($orderby=="amount_raised")?$ordertype:""; ?>" style="border-top: 1px solid #999;" id="amount_raised">Amount raised ($USM)</th>
                            <th style="width: 237px;" class="header <?php echo ($orderby=="fundStatus")?$ordertype:""; ?>" style="border-top: 1px solid #999;" id="fundStatus">Status</th>
                            <th style="width: 238px;" class="header <?php echo ($orderby=="source")?$ordertype:""; ?>" style="border-top: 1px solid #999;" id="source">Capital Source</th>
                            <th style="width: 241px;" class="header <?php echo ($orderby=="fundDate")?$ordertype:""; ?>" id="fundDate">Date</th>
                        </tr>
                    </thead>
                    <tbody id="movies">
                <?php
                if ($sql_cnt > 0)
                  {
                    $ah=1; // 
                    
                        $hidecount=0; 
                        mysql_data_seek($sqlrs,0);

                        //Code to add PREV /NEXT
                        $count=0;
                        $investorarray = array();
                        $totalamount=0;
                        $investorId="";
                        While($myrow=mysql_fetch_array($sqlrs, MYSQL_BOTH))
                        {
                            
                            
                            $VCFlagValue='funds';
                            $dealuv=0;
                            $investorId=$myrow['InvestorId'];
                            $fundId=$myrow['fundId'];
                            
                            $isfinalclose= claculateAmount($sqlTotal,$investorId,$fundId);
                            if ($myrow["hideaggregate"] == 1) {
                                $openBracket = "(";
                                $closeBracket = ")";
                            } else {
                                $openBracket = "";
                                $closeBracket = "";
                            }
                            if($isfinalclose!=0){
                                if($myrow['fundClosedStatus']==3){
                                    $totalamount+=$myrow['amount_raised'];
                                }else{
                                    $totalamount=$totalamount;
                                }
                            }else{
                                $totalamount+=$myrow['amount_raised'];
                            }


                         
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
                         
                         
                                <tr class="details_link" valueId="<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv;?>">
                                        <!-- <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>"><?php if($myrow["Investor"]){ echo $myrow["Investor"]; } else { echo $myrow["fundManager"];  }?></a> </td> -->
                                         <td style="width: 300px;"><?php echo $openBracket; ?><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>"><?php if($myrow["Investor"]){ echo $myrow["Investor"]; } else { echo $myrow["fundManager"];  }?></a> <?php echo $closeBracket; ?></td>
                                        <!--td style="width: 300px;"><a class="postlink" href="" ><?php echo $myrow["fundManager"];?></a></td-->
                                        <td style="width: 300px;"> <a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" ><?php echo $myrow["fundName"];?> </a></td>
                                        <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" > <?php if($myrow["stage"]!=""){ ?><span class="fund-badge"><?php echo $myrow["stage"]?></span> <?php } ?> <?php echo $myrow["industry"];?></a></td>
                                        <td style="width: 300px;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" ><?php echo ($myrow["size"]!=0) ? $myrow["size"] : "-";?></a></td>
                                        <td style="width: 300px; text-align: left;"><a class="postlink" href="fund_details.php?value=<?php echo $in_ve_id."/".$VCFlagValue."/".$dealuv."/".$myrow["id"]."/".$ah;?>" ><?php echo ($myrow["amount_raised"]!=0) ? $myrow["amount_raised"] : "-";?></a></td>
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
}
else{
    
?>
   
            <br><div class="view-table view-table-list "> <?php echo "No Result Found";?></div>
    <?php
}

if($notable==false)
        {
    ?>
            <!-- <center> -->
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
                        &nbsp;

                        
                        
                    </div> 
                </div>  
          
            <!-- </div> -->
            <!-- </center> -->


                <!-- Pagination Section -->
                <center>
                <div class="pagination-section">
                    <input type="text" name = "paginaitoninput" id = "paginationinput" class = "paginationtextbox" placeholder = "P.no" onkeyup = "paginationfun(this.value)">
                    <button class = "jp-page1 button pagevalue" name="pagination"  id="pagination" type="submit" onclick = "validpagination()">Go</button>
                </div> 
                </center>


         <br /><br />
        <?php } ?>
</td>

</tr>
</table>
 
</div>
<script type="text/javascript" >
        
        $("#show-total-amount").html('<h2>Amount (US$ M) <?php 
         if($resultTotl[ 'AmountRaisedTotal' ] >0)
            {
                echo number_format(round($resultTotl[ 'AmountRaisedTotal' ]));
            }
            else
            {
                echo "--";
            }?></h2>');
</script>
<div class=""></div>
</form>
           
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
                  //alert(pageno);
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
                else
                {
                    loadhtml(1,orderby,ordertype)
 
                }
                });       
               function loadhtml(pageno,orderby,ordertype)
               {
                localStorage.setItem("pageno", pageno);
                $('#paginationinput').val(pageno);

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
                                   
                                hrefval= 'ajax_funds_export.php';
                                $("#pesearch").attr("action", hrefval);
                                $("#pesearch").submit();
                                jQuery('#preloading').fadeOut();
                                $("#pesearch").attr("action",' ');
                                  
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
                

        function initExport2(){
                  //  $.post($('#pesearch').attr('action')+"ajax_funds_export.php",$('#pesearch').attr('target','_blank'), $('#pesearch').submit());
                $('#pesearch').submit();                
                jQuery('#preloading').fadeOut();
                $('#pesearch').attr('action','');
                $('#pesearch').attr('target','');
                return false;
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
                function resetmultipleinput(fieldname,fieldid)
                {
                  $("#resetfield").val(fieldname);
                  $("#resetfieldid").val(fieldid);
                  
                  //alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }
                
            $(document).on('click', 'tr .details_link', function(){ 
                
                idval=$(this).attr("valueId");
                //$("#detailpost").attr("href","<?php echo GLOBAL_BASE_URL; ?>dealsnew/investordetails.php?value="+idval).trigger("click");
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
</body>
</html>
<?php
    function returnMonthname($mth){
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
 <script language="javascript">
     /*$(document).ready(function(){
            $("#ldtrend").click(function () {
                    if($(".show_hide").attr('class')!='show_hide'){

                     //$('.list-tab').css('position', 'relative');
                     //$('.view-table table thead').css('position', 'relative');
                     $('.view-table table thead').css('z-index', '1000');
                    }
                    else
                    {
                         //$('.list-tab').css('position', 'fixed');
                         $('.view-table table thead').css('position', 'fixed');
                         $('.view-table table thead').css('z-index', '1000');
                    }
            });
    });*/
    </script>


 <script type="text/javascript" >
                                     
    
              var containerWidth = $('#container').width();  
              var refineWidth = $('#panel').width();                                                                                
             var searchkeyWidth = $('.result-rt-cnt').width();
             var searchTitleWidth = $('.result-title').width();
             
             var filtersHeight = $('.filter-key-result').height();
             var tabHeight = $('.list-tab').height();
             var alertHeight = $('.alert-note').height();
             
            
             
           /*  alert(filtersHeight+","+tabHeight+","+alertHeight);
             
             var searchTitleHeight = filtersHeight + tabHeight + alertHeight + 14;
             alert(searchTitleHeight);
             alert(window.innerWidth);*/
             //var searchTitleHeight = $('.result-cnt').height(); 
            if (window.innerWidth > 1700)
            {
                var searchTitleHeight = filtersHeight + tabHeight + alertHeight + 10;
                $('.result-select').css({"max-width":1190});
                 //var resultcntHeight = $('.result-cnt').height()-13; 
            }
            else if (window.innerWidth > 1024 )
            {
                var searchTitleHeight = filtersHeight + tabHeight + alertHeight + 15;
                $('.result-select').css({"max-width":530});
                 //var resultcntHeight = $('.result-cnt').height()-18; 
             }
            else
            {
                var searchTitleHeight = filtersHeight + tabHeight + alertHeight + 45;
                $('.result-select').css({"max-width":390});
                 //var resultcntHeight = $('.result-cnt').height()-21; 
            }
            
            
            $('.result-cnt').width(containerWidth-refineWidth+188);
            var resultcntHeight = $('.result-cnt').height(); 
            //alert(resultcntHeight);
            //$('.view-table').css({"margin-top":resultcntHeight});
            $('.expand-table').css({"margin-top":0});
           
            //$('.view-table').css({"margin-top":window.innerHeight-826});
             
            $('.btn-slide').click(function(){ 
                
                var containerWidth = $('#container').width();  
                var refineWidth = $('#panel').width();      
                var searchkeyWidth = $('.result-rt-cnt').width();
                var searchTitleWidth = $('.result-title').width();
                var searchTitleHeight = $('.result-cnt').height(); 
              
                $('.result-cnt').width(containerWidth-refineWidth-40);
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
                    //$('.result-select').width(searchTitleWidth-searchkeyWidth);

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
                         
        <?php  if(($vcflagValue==0 && $_SERVER['REQUEST_METHOD']=="GET" )||($_POST)|| $vcflagValue==1)
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
                })
            

    </script>

    <style>

.paginationtextbox{
        width:2.5%;
        padding: 3px;
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


    input[type='text']::placeholder

{   

text-align: center;      /* for Chrome, Firefox, Opera */

}
       

    .pageinationManual{
        display: flex;
        /* margin: auto;
        width: 50%; */
        position: absolute;

left: 38%;
    }


    </style>