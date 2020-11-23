<?php
 //session_save_path("/tmp");
	session_start();       
        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
        
         //Check Session Id 
        $sesID=session_id();
        $emailid=$_SESSION['UserEmail'];
        $sqlUserLogSel = "SELECT `sessionId` FROM `user_log` WHERE `emailId`='".$emailid."' AND `dbTYpe`='PE'";
        $resUserLogSel = mysql_query($sqlUserLogSel);
        $cntUserLogSel = mysql_num_rows($resUserLogSel);
        if ($cntUserLogSel > 0){
            $resUserLogSel = mysql_fetch_array($resUserLogSel);
            $logSessionId = $resUserLogSel['sessionId'];
            if ($logSessionId != $sesID){
                header( 'Location: logoff.php?value=caccess' ) ;
            }
        }
       
        function updateDownload($res){
            //Added By JFR-KUTUNG - Download Limit
            $recCount = mysql_num_rows($res);
            $dlogUserEmail = $_SESSION['UserEmail'];
            $today = date('Y-m-d');

            //Check Existing Entry
           $sqlSelCount = "SELECT `recDownloaded`  FROM `user_downloads` WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='PE' AND `downloadDate` = CURRENT_DATE";
           $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
           $rowSelCount = mysql_num_rows($sqlSelResult);
           $rowSel = mysql_fetch_object($sqlSelResult);
           $downloads = $rowSel->recDownloaded;

           if ($rowSelCount > 0){
               $upDownloads = $recCount + $downloads;
               $sqlUdt = "UPDATE `user_downloads` SET `recDownloaded`='".$upDownloads."' WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='PE' AND `downloadDate` = CURRENT_DATE";
               $resUdt = mysql_query($sqlUdt) or die(mysql_error());
           }else{
               $sqlIns = "INSERT INTO `user_downloads` (`user_id`,`emailId`,`downloadDate`,`dbType`,`recDownloaded`) VALUES ('0','".$dlogUserEmail."','".$today."','PE','".$recCount."')";
               mysql_query($sqlIns) or die(mysql_error());
           }
        }
        
        
        //$vcflagValue = isset($_POST['value']) ? $_POST['value'] : 0; 
        //include ('checklogin.php');
        
        
        if(!isset($_POST['investorauto'])){
            $investorId = isset($_POST['value']) ? $_POST['value'] : '';
        }  else {
            $investorId="";
        }
        
        //-----------------------------------Filter exit code---------------------------------------
        $resetfield=$_POST['resetfield'];
        if($resetfield=="investor")
        { 
            $_POST['investorauto']="";
            $_POST['investorsearch']="";
            $investorId="";
            $filterinvtext="";
        }
        
         if($resetfield=="searchallfield"){
            $_REQUEST['searchallfield']="";$searchallfieldsql="";$searchallfieldstext="";
        }
        
        if($resetfield=="date"){ 
            $_POST['month1']="";$_POST['year1']="";$_POST['month2']="";$_POST['year2']="";$filterdatetext="";
        }
        
        if($resetfield=="type"){ 
            $_POST['type']="";$typesql="";$filtertypetext="";
        }
        
        if($resetfield=="type2"){ 
            $_POST['type2']="";$type2sql="";$filtertype2text="";
        }
        
        if($resetfield=="size"){
            $_POST['sizestart']="";$_POST['sizeend']="";$sizesql="";$filtersizetext="";
        }
        
        if($resetfield=="status"){
            $_POST['status']="";$_POST['cstatus']="";$statussql="";$filterstatustext="";
        }
        
        if($resetfield=="capital"){
            $_POST['capital']="";$capitalsql="";$filtercapitaltext="";
        }
       
        //----------------------------------------Investor code--------------------------------------
        
     
        
        
         if($_REQUEST['searchallfield']!="")
        {
            $searchallfield = $_REQUEST['searchallfield'];
                 
                $searchallfieldsql=" ( fn.fundName LIKE '%$searchallfield%'   OR      pi.Investor LIKE '%$searchallfield%'    OR      fd.moreInfo LIKE '%$searchallfield%' )";
                $searchallfieldstext=$searchallfield;
           
        }else if($_POST['investorsearch']!="")
        {
            $investorid = $_POST['investorsearch'];
       
            if($investorid !='')
            {
                $investorsql="pi.InvestorId IN(".$investorid.") ";
                $filterinvsql="select Investor from peinvestors pi where ".$investorsql;

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
            $investorsql="pi.InvestorId IN(".$investorid.") ";
            $filterinvsql="select Investor from peinvestors pi where ".$investorsql;
            
            $filterinvtext="";
            if ($filterinvrs = mysql_query($filterinvsql))
            {
                While($myrow7=mysql_fetch_array($filterinvrs, MYSQL_BOTH))
                {
                        $filterinvtext=$myrow7["Investor"];
                        $_POST['investorauto']=$filterinvtext;
                        $_POST['investorsearch']=$investorId;
                }
                 
            }
           
        }
        
       
        //------------------------------------------Date code----------------------------------------
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
        $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
        $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
        $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
        $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
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
        if($_POST['type']!="")
        {
            $typ = $_POST['type'];
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
        if($_POST['type2']!="")
        {
            $type2= $_POST['type2'];
            foreach($type2 as $type2id)
            {
                $type2sql = $type2sql."fti.id = ".$type2id." or ";
            }
            $type2sql = substr($type2sql, 0, -3);
            $filtertype2sql="select fundTypeName from fundType fti where ".$type2sql;
            $filtertype2text="";
            if ($filtertype2rs = mysql_query($filtertype2sql))
            {
                While($myrow2=mysql_fetch_array($filtertype2rs, MYSQL_BOTH))
                {
                        $filtertype2text=$filtertype2text.$myrow2["fundTypeName"].",";
                }
            }
        }
        else{
            $type2sql = '';
        }
        $filtertype2text= substr($filtertype2text, 0, -1);
        
        //---------------------------------size code--------------------------------
        if($_POST['sizestart']!="" && $_POST['sizeend']!="")
        {
            if(($_POST['sizestart'] == $_POST['sizeend']) || ($_POST['sizestart'] > $_POST['sizeend']) ){
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
        
        if($_POST['status']!="")
        {
            $status= $_POST['status'];
            
           
                $statussql = $statussql."frs.id = ".$status." or ";
                if($status==2)
                {
                    if($_POST['cstatus']!="")
                    {
                        $cstatus= $_POST['cstatus'];
                        foreach($cstatus as $cstatusid)
                        {
                            $cstatussql = $cstatussql."fes.id = ".$cstatusid." or ";
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
        if($_POST['capital']!="")
        {
            $capital= $_POST['capital'];
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
        $sql="SELECT pi.InvestorId,pi.Investor,fn.fundName,fn.fundId,fd.fundManager,fd.id,DATE_FORMAT( fd.fundDate, '%b-%Y' )as fundDate,fd.size,fd.amount_raised,fts.fundTypeName as stage,fti.fundTypeName as industry,frs.fundStatus,fd.fundClosedStatus,fes.closeStatus,fcs.source,fd.moreInfo,fd.source as frdsource,fd.hideaggregate FROM fundRaisingDetails as fd
                LEFT JOIN peinvestors pi ON fd.investorId = pi.InvestorId
                LEFT JOIN fundNames fn ON fd.fundName = fn.fundId
                LEFT JOIN fundType fts ON  fd.fundTypeStage=fts.id 
                LEFT JOIN fundType fti ON  fd.fundTypeIndustry=fti.id 
                LEFT JOIN fundRaisingStatus frs ON fd.fundStatus = frs.id
                LEFT JOIN fundCloseStatus fes ON fd.fundClosedStatus = fes.id
                LEFT JOIN fundCapitalSource fcs ON fd.capitalSource = fcs.id WHERE fd.dbtype='PE' ";
        $sql=$sql.$filters;
        $sqlTotal ="select count(fd.fundClosedStatus) as count FROM fundRaisingDetails as fd
                LEFT JOIN peinvestors pi ON fd.investorId = pi.InvestorId
                LEFT JOIN fundNames fn ON fd.fundName = fn.fundId
                LEFT JOIN fundType fts ON  fd.fundTypeStage=fts.id 
                LEFT JOIN fundType fti ON  fd.fundTypeIndustry=fti.id 
                LEFT JOIN fundRaisingStatus frs ON fd.fundStatus = frs.id
                LEFT JOIN fundCloseStatus fes ON fd.fundClosedStatus = fes.id
                LEFT JOIN fundCapitalSource fcs ON fd.capitalSource = fcs.id WHERE fd.dbtype='PE' ".$filters;
        $orderby="fundDate";
        $ordertype="desc";
        
        $ajaxsql=  urlencode($sql);
        if($sql!="" && $orderby!="" && $ordertype!="")
           $sql = $sql . " order by fd.fundDate desc";
	 
        $exp_query = mysql_query($sql);
        
        updateDownload($exp_query);
        
   if(mysql_num_rows($exp_query)>0){      
       
       /// export
        
        
        //if parameter is not included, file returned will be in excel format ('.xls')
 	if (isset($w) && ($w==1))
 	{
 		$file_type = "msword";
 		$file_ending = "doc";
 	}
 	else
 	{
 		$file_type = "vnd.ms-excel";
 		$file_ending = "xls";
	}
 //header info for browser: determines file type ('.doc' or '.xls')
 header("Content-Type: application/$file_type");
 header("Content-Disposition: attachment; filename=pe_funds.$file_ending");
 header("Pragma: no-cache");
 header("Expires: 0");


 	
 	      print("\n");
 	      print("\n");



	echo "Investor Name "."\t";
	echo "Fund Name "."\t";
	//echo "Fund Manager "."\t";
	echo "Fund Date "."\t";
	echo 'Target Size ($USM)'."\t";
    echo 'Amount Raised ($USM)'."\t";
	echo "Stage"."\t";
	echo "Industry"."\t";
	echo "Fund Status"."\t";
	echo "Capital Source"."\t";
        echo "More Info"."\t";
         echo "Source"."\t";

 print("\n");

 /*print("\n");*/
	
  

     
     $exportrows='';
     while($fund = mysql_fetch_array($exp_query)){

        if ($fund["hideaggregate"] == 1) {
            $openBracket = "(";
            $closeBracket = ")";
        } else {
            $openBracket = "";
            $closeBracket = "";
        }
            
         $exportrows.=$openBracket.$fund['Investor']. $closeBracket."\t";
         $exportrows.=$fund['fundName']."\t";
         //$exportrows.=$fund['fundManager']."\t";
         $exportrows.=$fund['fundDate']."\t";
         $exportrows.=$fund['size']."\t";
         if($fund['amount_raised']==0){$raisedValue="";}else{$raisedValue=$fund['amount_raised'];}
         $exportrows.=$raisedValue."\t";
         $exportrows.=$fund['stage'];
             if($fund['stage']) { $stagebr="-"; } else { $stagebr="";}
             if($fund['industry']) { $exportrows.= " $stagebr ". $fund['industry']."\t"; } else { $exportrows.="\t";}
         
         $exportrows.=$fund['industry']."\t";
         $exportrows.=$fund['fundStatus'];   
            if($fund["fundStatus"]) { $fundbr="-"; } else { $fundbr="";}
            if($fund['fundStatus']=='Closed' && $fund['closeStatus']!='') { $exportrows.= " $fundbr ". $fund['closeStatus']."\t"; } else { $exportrows.="\t";}
         
         $exportrows.=$fund['source']."\t";
         // $exportrows.=trim(preg_replace('/\s\s+/', ' ', $fund['moreInfo']))."\t";
         // $exportrows.=trim(preg_replace('/\s\s+/', ' ', $fund['frdsource']))."\t";
         // For MI5-T490
         $exportrows.=trim(preg_replace('/\s\s+/', ' ', str_replace('"',"",$fund['moreInfo'])))."\t";
         $exportrows.=trim(preg_replace('/\s\s+/', ' ', str_replace('"',"",$fund['frdsource'])))."\t";
         
         $exportrows.="\n";
         
     }
     
     print trim($exportrows);
     exit;
     
 }
        
        
        
        
?>