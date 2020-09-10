<?php
 session_save_path("/tmp");
	session_start();       
        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
  
        $videalPageName="REInv";
        include ('checklogin.php');
        
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
        
        
        //$vcflagValue = isset($_POST['value']) ? $_POST['value'] : 0; 
        //include ('checklogin.php');
        
        
        
        
        
       if ($_SERVER['REQUEST_METHOD'] === 'POST')
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
        
          
        
        
        
        //----------------------------------------Investor code--------------------------------------
        
    
               
        if($_POST['searchinvestorid']!="")
        {
            
            $investorid = $_POST['searchinvestorid'];       
           
                $investorsql="re.InvestorId=".$investorid;               
           
        }
        
        
             
            //------------------------------------------Date code----------------------------------------
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
        if($_POST['sizestart']!="" && $_POST['sizeend']!="")
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
         elseif($_POST['sizestart']!="" && $_POST['sizeend']=="")
        {
            $sizestart= $_POST['sizestart'];
            $sizeend= 2000;
            $sizesql = "fd.size between '" .$sizestart. "' and '" .$sizeend. "'";
            $filtersizetext="(USM)".$sizestart."-".$sizeend;
        }
        elseif($_POST['sizestart']=="" && $_POST['sizeend']>0)
        {
            $sizestart= 0;
            $sizeend= $_POST['sizeend'];
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
            
            foreach($status as $statusid)
            {
               
                $statussql = $statussql."frs.id = ".$statusid." or ";
                if($statusid==2)
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
        
        
             
             
             
        $orderby="fundDate";
        $ordertype="desc";
        
      
        
        $ajaxsql=  urlencode($sql);
        
        if($sql!="" && $orderby!="" && $ordertype!="")
        { $sql = $sql." order by fd.fundDate desc"; }
             
         
//	echo $sql;
//        exit;
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
 header("Content-Disposition: attachment; filename=re_funds.$file_ending");
 header("Pragma: no-cache");
 header("Expires: 0");


 	
 	      print("\n");
 	      print("\n");



	echo "Investor Name "."\t";
	echo "Fund Name "."\t";
	//echo "Fund Manager "."\t";
	echo "Fund Date "."\t";
	echo 'Size ($USM)'."\t";
	echo "Fund Type"."\t";
	echo "Fund Status"."\t";
	echo "Capital Source"."\t";

 print("\n");

 print("\n");
	
  

     
     $exportrows='';
     while($fund = mysql_fetch_array($exp_query)){
            
         $exportrows.=$fund['Investor']."\t";
         $exportrows.=$fund['fundName']."\t";
         //$exportrows.=$fund['fundManager']."\t";
         $exportrows.=$fund['fundDate']."\t";
         $exportrows.=$fund['size']."\t";
         
         if($fund['sector']){$exportrows.=$fund['sector']."\t"; } else { $exportrows.='Others'."\t"; }
         
         $exportrows.=$fund['fundStatus'];
         
            if($fund["fundStatus"]) { $fundbr="-"; } else { $fundbr="";}
            if($fund['fundStatus']=='Closed' && $fund['closeStatus']!='') { $exportrows.= " $fundbr ". $fund['closeStatus']."\t"; } else { $exportrows.="\t";}
         
         $exportrows.=$fund['source']."\t";
         
         
         $exportrows.="\n";
         
     }
     
     print trim($exportrows);
     exit;
     
 }
        mysql_close();
        
        
        
?>