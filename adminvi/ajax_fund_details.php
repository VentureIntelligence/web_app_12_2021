<?php

    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
    // $data=trim($_REQUEST['data']);
   
    $jsonData=json_decode($_REQUEST['data']);
    $req = $_REQUEST['opt'];
    $dbtype = $_REQUEST['dbtype'];
    $type = $_REQUEST['type'];

    $peid = $_REQUEST['peid'];
    $ipo_mandaflag = $_REQUEST['ipo_mandaflag'];
    $companyid = $_REQUEST['companyid'];
  // exit();
    
    if (mysql_query("delete from peinvestments_investors where PEId=$peid ")){
       // echo "<br>PE Investor deleted" ;
        
        }
    if (mysql_query("delete from peinvestment_funddetail where PEId=$peid ")){
            //echo "<br>PE Fund deleted" ;
            
            }
     
    
    if ($dbtype=='PE') {
        // $peid = $_REQUEST['peId'];
        if ($req=="investor"){
            // if ($type=="add"){
                foreach ($jsonData as $index => $row) {
                    $data=$row;
                    
                    $investor= $data->{'investor_value'};
                    $fundnameval = $data->{'fund'};
                    // $fundM = $data->{'fundM'};
                    // $fundinr = $data->{'fundinr'};
                    $invReturnMultiple = $data->{'amountm'};
                    $invReturnMultipleINR = $data->{'amountinr'};
                    $invHideAmount = $data->{'hideamount'};
                    $invexp_dp = $data->{'excludry'};
                    $leadinvestor = $data->{'leadinvestor'};
                    $newinvestor = $data->{'newinvestor'};
                    $invMoreInfo = $data->{'returnmultiple'};
                    $investorOrder = $data->{'investorOrder'};
                    $existinvestor = $data->{'existinvestor'};
                   if($investor !=""){
                       
                    foreach($fundnameval as $index => $rowval) {
                        $fundname1= $rowval->{'fundname'};
                        $fundM= $rowval->{'fundamount'};
                        $fundinr= $rowval->{'fundamountinr'};
                        if($fundname1!="")
                        {
                            $fundname=$fundname1;
                        }
                        $investorIdval=return_insert_get_Investor($investor);  
                        $investorId=return_insert_get_Investor_edit_update($investor,$investorIdval);
                    
                        if($fundname!=""){
                            $fundId=return_insert_get_fundid($investorIdval,$fundname);
                        }
                        
                        if($investorIdval !='' && $fundId !=''){
                        $ciaIdToInsert=insert_fund_Investors($peid,$investorIdval,$fundId,$fundM,$fundinr);
                        }
                    }
                
                    
                    $investorId=return_insert_get_Investor_edit_update($investor,$investorIdval);
                    if($investorId !=''){
                        $ciaIdToInsert=insert_Investment_Investors($ipo_mandaflag,$peid,$investorId,$invReturnMultiple,$invReturnMultipleINR,$invHideAmount,$invexp_dp,$invMoreInfo,$investorOrder,$leadinvestor,$newinvestor,$existinvestor,$companyid);
                    }else{
                        $investorId=return_insert_get_Investor($investor);
                        if($investorId !=''){
                            $ciaIdToInsert=insert_Investment_Investors($ipo_mandaflag,$peid,$investorId,$invReturnMultiple,$invReturnMultipleINR,$invHideAmount,$invexp_dp,$invMoreInfo,$investorOrder,$leadinvestor,$newinvestor,$existinvestor,$companyid);
                        }
                    }
                }
                }
                
                echo "details Inserted" ;  
                exit();  
               
            // }        
        } 
               
    }
    function return_insert_get_Investor($investor)
	{
        
		$dblink= new dbInvestments();
		$investor=trim($investor);
		$getInvestorIdSql = "select InvestorId from peinvestors where Investor = '$investor'";
		//echo "<br>select--" .$getInvestorIdSql;
		if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
		{
			$investor_cnt=mysql_num_rows($rsgetInvestorId);
			//echo "<br>Investor count-- " .$investor_cnt;
			if ($investor_cnt==0)
			{
					//insert acquirer
					$insAcquirerSql="insert into peinvestors(Investor) values('$investor')";
					if($rsInsAcquirer = mysql_query($insAcquirerSql))
					{
                                            $InvestorId = mysql_insert_id();
						return $InvestorId;
					}
			}
			elseif($investor_cnt>=1)
			{
				While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
				{
					$InvestorId = $myrow[0];
				//	echo "<br>Insert return investor id--" .$InvestorId;
					return $InvestorId;
				}
			}
		}
		$dblink.close();
    }
    /* insert and return the fundid */
function return_insert_get_fundid($investorid,$fundname)
{
    $dblink= new dbInvestments();
    $fundname=trim($fundname);
    $getfundIdSql = "select fundId from fundNames where fundName = '$fundname'";
    //echo "<br>select--" .$getInvestorIdSql;
    if ($rsgetfundId = mysql_query($getfundIdSql))
    {
        $fund_cnt=mysql_num_rows($rsgetfundId);
        //echo "<br>Investor count-- " .$investor_cnt;
        if ($fund_cnt==0)
        {
                //insert acquirer
                $insfundSql="insert into fundNames(InvestorId,fundName,dbtype) values('$investorid','$fundname','PE')";
                if($rsfund = mysql_query($insfundSql))
                {
                                        $fundId = mysql_insert_id();
                    return $fundId;
                }
        }
        elseif($fund_cnt>=1)
        {
            While($myrow=mysql_fetch_array($rsgetfundId, MYSQL_BOTH))
            {
                $fundId = $myrow[0];
            //	echo "<br>Insert return investor id--" .$InvestorId;
                return $fundId;
            }
        }
    }
    $dblink.close();
}
function insert_fund_Investors($dealId,$investorId,$fundId,$amountDollar,$amountInr)
{
	$dbexecmgmt = new dbInvestments();
    if($amountDollar=='' && $amountInr=='')
    {
        $amountDollar=$amountInr=0.00;
    }
        //  echo "<br>-***--- ".$insDealInvSql;
          /*$getDealInvSql="Select PEId,InvestorId from peinvestments_investors where PEId=$dealId and InvestorId=$investorId";*/
           $getfundInvSql="Select PEId,InvestorId,fundId from peinvestment_funddetail where  InvestorId=$investorId and fundId = $fundId and PEId=$dealId";
          if($rsgetfund = mysql_query($getfundInvSql))
	  {
		$deal_fundcnt=mysql_num_rows($rsgetfund);
		if($deal_fundcnt==0)
		{
                    /*$insDealInvSql="insert into peinvestments_investors (PEId,InvestorId,Amount_M,Amount_INR,hide_amount,exclude_dp,InvMoreInfo) values($dealId,$investorId,$returnValue,$returnValueINR,$returnHideAmount,$invexp_dp,'$moreinfo')";*/
                    $insfundSql="insert into peinvestment_funddetail(PEId,InvestorId,fundId,Amount_M,Amount_INR) values($dealId,$investorId,$fundId,$amountDollar,$amountInr)";
                    if ($rsinsfund = mysql_query($insfundSql))
                    {
                        
                        return true;
                    }
                }
                
          }
          mysql_free_result($rsinsfund);
         
}


function insert_Investment_Investors($exit_flag,$dealId,$investorId,$returnValue,$returnValueINR,$returnHideAmount,$invexp_dp,$moreinfo,$investorOrder,$leadinvestor,$newinvestor,$existinvestor,$companyid)
{
	$dbexecmgmt = new dbInvestments();
	if($exit_flag=="PE")
	{
        //  echo "<br>-***--- ".$insDealInvSql;
          /*$getDealInvSql="Select PEId,InvestorId from peinvestments_investors where PEId=$dealId and InvestorId=$investorId";*/
           $getDealInvSql="Select PEId,InvestorId,investorOrder from peinvestments_investors where PEId=$dealId and InvestorId=$investorId";
          if($rsgetdealinvestor = mysql_query($getDealInvSql))
	  {
		$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
		if($newinvestor!=0|| $existinvestor !=0)
       {
       
                if($deal_invcnt==0)
                {
                    /*$insDealInvSql="insert into peinvestments_investors (PEId,InvestorId,Amount_M,Amount_INR,hide_amount,exclude_dp,InvMoreInfo) values($dealId,$investorId,$returnValue,$returnValueINR,$returnHideAmount,$invexp_dp,'$moreinfo')";*/
                    $insDealInvSql="insert into peinvestments_investors (PEId,InvestorId,Amount_M,Amount_INR,hide_amount,exclude_dp,InvMoreInfo,investorOrder,leadinvestor,newinvestor,existinvestor) values($dealId,$investorId,$returnValue,$returnValueINR,$returnHideAmount,$invexp_dp,'$moreinfo','$investorOrder','$leadinvestor','$newinvestor','$existinvestor')";
                    if ($rsinsmgmt = mysql_query($insDealInvSql))
                    {
                      //  echo "<br>PE Investor Inserted" ;
                        return true;
                    }
                }
                /*else{
                    $update_query = "update peinvestments_investors set Amount_M='$returnValue', Amount_INR='$returnValueINR', InvMoreInfo = '$moreinfo' where PEId=$dealId and InvestorId=$investorId";
                    if (mysql_query($update_query)){
                        echo "<br>PE Investor updated" ;
                        return true;
                    }
                }*/
        }else{
           
           
            if($companyid!="")
            {
                $existsql="SELECT * FROM `peinvestments_investors` as peinv,pecompanies as pec,peinvestments as pe WHERE pe.PEId=peinv.PEId and pec.PECompanyId=pe.PECompanyId and peinv.`InvestorId`=$investorId and pec.PECompanyId=$companyid";
                
                if($existinvestorsql = mysql_query($existsql))
                {
                    $exist_invcnt=mysql_num_rows($existinvestorsql);
                    if($exist_invcnt==0)
                    {
                        $insDealInvSql="insert into peinvestments_investors (PEId,InvestorId,Amount_M,Amount_INR,hide_amount,exclude_dp,InvMoreInfo,investorOrder,leadinvestor,newinvestor,existinvestor) values($dealId,$investorId,$returnValue,$returnValueINR,$returnHideAmount,$invexp_dp,'$moreinfo','$investorOrder','$leadinvestor','1','$existinvestor')";
                        if ($rsinsmgmt = mysql_query($insDealInvSql))
                        {
                          //  echo "<br>PE Investor Inserted" ;
                            return true;
                        }
                    }else{
                        $insDealInvSql="insert into peinvestments_investors (PEId,InvestorId,Amount_M,Amount_INR,hide_amount,exclude_dp,InvMoreInfo,investorOrder,leadinvestor,newinvestor,existinvestor) values($dealId,$investorId,$returnValue,$returnValueINR,$returnHideAmount,$invexp_dp,'$moreinfo','$investorOrder','$leadinvestor','$newinvestor','1')";
                        if ($rsinsmgmt = mysql_query($insDealInvSql))
                        {
                          //  echo "<br>PE Investor Inserted" ;
                            return true;
                        }
                    }
                }
            
            }else{
                
               
            if($deal_invcnt==0)
                {
                    $insDealInvSql="insert into peinvestments_investors (PEId,InvestorId,Amount_M,Amount_INR,hide_amount,exclude_dp,InvMoreInfo,investorOrder,leadinvestor,newinvestor,existinvestor) values($dealId,$investorId,$returnValue,$returnValueINR,$returnHideAmount,$invexp_dp,'$moreinfo','$investorOrder','$leadinvestor','$newinvestor','$existinvestor')";
                    if ($rsinsmgmt = mysql_query($insDealInvSql))
                    {
                       // echo "<br>PE Investor Inserted" ;
                        return true;
                    }
                }
            }
        }
      }
          mysql_free_result($rsinsmgmt);
   }
}



    function return_insert_get_Investor_edit($investor,$investor_id)
    {
        $dblink= new dbInvestments();
        $investor=trim($investor);
        $getInvestorIdSql = "select InvestorId from peinvestors where Investor = '$investor' and InvestorId != '$investor_id'";
        //echo "<br>select--" .$getInvestorIdSql;
        if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
        {
            $investor_cnt=mysql_num_rows($rsgetInvestorId);
            //echo "<br>Investor count-- " .$investor_cnt;
            if ($investor_cnt==0)
            {
                $insAcquirerSql="UPDATE peinvestors set Investor='$investor' where InvestorId ='$investor_id'";
                if($rsInsAcquirer = mysql_query($insAcquirerSql))
                {
                    return $investor_id;
                }
            }else{
                $rsgetInvestorId1 = mysql_fetch_array($rsgetInvestorId);
                return $rsgetInvestorId1['InvestorId'];
            }
        }
        $dblink.close();
    }
    function return_insert_get_Investor_edit_update($investor,$investor_id)
    {
        $dblink= new dbInvestments();
        $investor=trim($investor);
        $getInvestorIdSql = "select InvestorId from peinvestors where Investor = '$investor' and InvestorId = '$investor_id'";
        //echo "<br>select--" .$getInvestorIdSql;
        if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
        {
            $investor_cnt=mysql_num_rows($rsgetInvestorId);
            //echo "<br>Investor count-- " .$investor_cnt;
            if ($investor_cnt==1)
            {
                return $investor_id;
            }else{
                return '';
            }
        }else{
            return '';
        }
        $dblink.close();
    }
?>
