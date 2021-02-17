<?php
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
include "header.php";
include "sessauth.php";
$pe_data='';

if($_POST['cin']!=''){
    
    // get company by CIN
    $getcompanysql = "select PECompanyId from pecompanies where CINNo ='".$_POST['cin']."'";
    $companyrs = mysql_query($getcompanysql);          
    $myrow=mysql_fetch_array($companyrs);
    
    $orderby=$_POST['orderby'];
    
    // Order by code
    if($orderby=='companyname')
    {
        $order_query = 'companyname';
        if($_POST['order']=='asc'){
            
            $order_company = 'desc';
        }else{
            $order_company = 'asc';
        }
        
        
    }else{
        $order_company = 'asc';
    }
    
    if($orderby=='sector_business'){
        
        $order_query = 'sector_business';
        if($_POST['order']=='asc'){
            
            $order_sector = 'desc';
        }else{
            $order_sector = 'asc';
        }
    }else{
        $order_sector = 'asc';
    }
    
    if($orderby=='investor'){
        
        $order_query = 'Investor';
        if($_POST['order']=='asc'){
            
            $order_investor = 'desc';
        }else{
            $order_investor = 'asc';
        }
    }else{
        $order_investor = 'asc';
    }
    
    if($orderby=='dates'){
        
        $order_query = 'dates';
        if($_POST['order']=='asc'){
            
            $order_dates = 'desc';
        }else{
            $order_dates = 'asc';
        }
    }else{
        $order_dates = 'asc';
    }
    
    if($orderby=='Exit_Status'){
        
        $order_query = 'Exit_Status';
        if($_POST['order']=='asc'){
            
            $order_status = 'desc';
        }else{
            $order_status = 'asc';
        }
    }else{
        $order_status = 'asc';
    }
    
    if($orderby=='amount'){
        
        $order_query = 'amount';
        if($_POST['order']=='asc'){
            
            $order_amount = 'desc';
        }else{
            $order_amount = 'asc';
        }
    }else{
        $order_amount = 'asc';
    }
   
    $order = $_POST['order'] ? $_POST['order']:'desc';
    $query_orderby = $order_query?$order_query : 'dates';
            
    if(count($myrow) > 0 && $myrow['PECompanyId']!=''){
        
       //Main Query to get all the deal by company id
        $sql = "SELECT distinct pe.PECompanyId as PECompanyId,
                pec.companyname, 
                pec.industry, 
                i.industry as industry,
                pec.sector_business as sector_business, 
                pe.amount,pe.Amount_INR,
                DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , 
                pe.PEId, 
                pe.hideamount,
                pe.StageId,
                pe.SPV,
                pe.AggHide,
                pe.dates as dates,pe.Exit_Status, (SELECT GROUP_CONCAT( inv.Investor ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                FROM peinvestments AS pe, 
                industry AS i, 
                pecompanies AS pec,
                stage as s, 
                peinvestments_investors as peinv_invs,
                peinvestors as invs 
                WHERE 
                pec.industry = i.industryid 
                AND pec.PEcompanyID = pe.PECompanyID 
                and pe.StageId=s.StageId 
                AND invs.InvestorId=peinv_invs.InvestorId 
                and pe.PEId=peinv_invs.PEId 
                and pe.Deleted =0 
                and pec.industry !=15 
                and pec.PECompanyId=".$myrow['PECompanyId']."
                GROUP BY pe.PEId order by ".$query_orderby." ".$order;
        
        ///*AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 ) */
        
        $pers = mysql_query($sql);          
        //$FinanceAnnual = mysql_fetch_array($financialrs);
        $cont=0;$pedata = array();$totalInv=0;$totalAmount=0;$totalINRAmount=0;$hidecount=0;$hideinrcount=0;
        While($myrow=mysql_fetch_array($pers, MYSQL_BOTH)) // while process to count total deals and amount and data save in array
        {
            
            $amtTobeDeductedforAggHide=0;
            $inramtTobeDeductedforAggHide=0;
            $NoofDealsCntTobeDeducted=0;
            
            if($myrow["AggHide"]==1 && $myrow["SPV"]==0)
            {
                $NoofDealsCntTobeDeducted=1;
                $amtTobeDeductedforAggHide=$myrow["amount"];
                $inramtTobeDeductedforAggHide=$myrow["Amount_INR"];
                
            }elseif($myrow["SPV"]==1 && $myrow["AggHide"]==0){

                $NoofDealsCntTobeDeducted=1;
                $amtTobeDeductedforAggHide=$myrow["amount"];
                $inramtTobeDeductedforAggHide=$myrow["Amount_INR"];
            }elseif($myrow["SPV"]==1 && $myrow["AggHide"]==1){
                $NoofDealsCntTobeDeducted=1;
                $amtTobeDeductedforAggHide=$myrow["amount"];
                $inramtTobeDeductedforAggHide=$myrow["Amount_INR"];
            }
            if($myrow["hideamount"] == 1){
                $hidecount=$hidecount+1;
            }
            $totalInv=$totalInv+1-$NoofDealsCntTobeDeducted;
            $totalAmount=$totalAmount+ $myrow["amount"]-$amtTobeDeductedforAggHide;
            $totalINRAmount=$totalINRAmount+ $myrow["Amount_INR"]-$inramtTobeDeductedforAggHide;

            $pedata[$cont]=$myrow;
            $cont++;
            
        }
        if($hidecount==1){
            $totalAmount = "--";
            $totalINRAmount = "--";
        }

        // $ch = curl_init("https://free.currencyconverterapi.com/api/v6/convert?q=USD_INR&compact=ultra&apiKey=fbebe88b3c481204f2fd");
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $var = curl_exec($ch);
        // curl_close($ch);
        // $var = json_decode($var, true);
        $inrvalue = "SELECT value FROM configuration WHERE purpose='USD_INR'";
                    $inramount = mysql_query($inrvalue);
                    while($inrAmountRow = mysql_fetch_array($inramount,MYSQL_BOTH))
                    {
                        $usdtoinramount = $inrAmountRow['value'];
                    }
        if($hideinrcount > 0){
            $totalINRAmount = $totalAmount * 1000000 * $usdtoinramount / 10000000;
        } 
      /*  echo "ddddddddd".$totalInv;
        echo "cccccccccccc".$totalAmount;
        echo '<pre>';
        print_r($pedata);
        echo '</pre>';
        exit();*/
        // Table to show the companies with count at the top
        if(count($pedata) > 0){
            
                $pe_data.='<div class="result-cnt">             
                        <div class="result-title">
                            <div class="filter-key-result"> 
                                <div class="result-rt-cnt">
                                    <div class="result-count">
                                        <span class="result-no" id="show-total-deal">'.$totalInv.' Results found (across 1 cos)</span>
                                        <span class="result-amount"></span>
                                        <span class="result-amount-no" id="show-total-amount"><h2> Amount (US$ M) '.$totalAmount.'</h2></span> 
                                        <span class="result-amount-no" id="show-total-amount" style="margin-left:10px;"><h2> / (INR CR) '.$totalINRAmount.'</h2></span>
                                    </div>      
                                </div>
                            </div> 
                        </div>
                    </div>';
    
                
                $pe_data.='<div class="view-table view-table-list ">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
                    <thead><tr>
                        <th style="width: 530px;" class="headertb" data-order="'.$order_company.'" id="companyname">Company</th>
                        <th style="width: 850px;" class="headertb" data-order="'.$order_sector.'" id="sector_business">Sector</th>
                        <th style="width: 260px;" class="headertb" data-order="'.$order_investor.'" id="investor">investor</th>
                        <th style="width: 200px;" class="headertb" data-order="'.$order_dates.'" id="dates">Date</th>
                        <th style="width: 200px;" class="headertb" data-order="'.$order_status.'" id="Exit_Status">Exit Status</th>
                        <th style="width: 200px;" class="headertb" data-order="'.$order_amount.'" id="amount">Amount</th>
                    </tr></thead>
                    <tbody id="movies">';
                
                    foreach($pedata as $ped){ 

                         if(trim($ped["sector_business"])==""){

                            $showindsec=$ped["industry"];
                         }else{
                            $showindsec=$ped["sector_business"];
                         }

                        if($ped["Exit_Status"]==1){
                            $exitstatus_name = 'Unexited';
                        }
                        else if($ped["Exit_Status"]==2){
                             $exitstatus_name = 'Partially Exited';
                        }
                        else if($ped["Exit_Status"]==3){
                             $exitstatus_name = 'Fully Exited';
                        }
                        else{
                            $exitstatus_name = '--';
                        }

                        if($ped["hideamount"]==1)
                        {
                                $hideamount="--";
                        }
                        else
                        {
                                $hideamount=$ped["amount"];
                        }
                         if($ped["AggHide"]==1)
                        {
                               $openBracket="(";
                               $closeBracket=")";
                        }
                        else
                        {
                               $openBracket="";
                               $closeBracket="";
                        }
                         if($ped["SPV"]==1)
                        {
                               $openDebtBracket="[";
                               $closeDebtBracket="]";
                        }
                        else
                        {
                               $openDebtBracket="";
                               $closeDebtBracket="";
                        }
                        $pe_data.='<tr class="details_link" data-row="'.$ped["PEId"].'" >

                                <td style="width: 530px;"><b>'.$openBracket.$openDebtBracket.trim($ped["companyname"]).$closeDebtBracket.$closeBracket.'</b></td>
                                <td style="width: 850px;"><b>'.trim($showindsec).'</b></td>
                                <td style="width: 260px;"><b>'.$ped["Investor"].'</b></td>
                                <td style="width: 200px;"><b>'.$ped["dealperiod"].'</b></td>
                                <td style="width: 200px;"><b>'.$exitstatus_name.'</b></td>
                                <td style="width: 200px;"><b>'.$hideamount.'</b></td>

                        </a></tr>';
                    }

                    $pe_data.='</tbody></table></div>';

        
        }else{
            // Show text when deals not found for this given company in PE
            if($_POST['trans_status']==0){
                
                //$pe_data .= '<div style="font-size:20px;text-align:center;margin-top:80px;color:#000000;font-weight:bold;margin-bottom: 10px;"><span display: inline-block;vertical-align: middle;line-height: normal;> Data not found. Please <a id="deals_data" style="font-weight:bold;cursor:pointer;text-decoration: underline;color: #000000;">Click Here</a> to alert Venture Intelligence about this. Thanks.</span></div>';
                $pe_data .= '<h2>FUNDING</h2>
                                <div class="data-ext-load">
                                     <div id="mca_data2">
                                        <b>Data not found. Please <a id="deals_data" style="font-weight:bold;cursor:pointer;">Click Here</a> to alert Venture Intelligence about this. Thanks.</b>
                                    </div>
                                </div>';
            }else{
                $pe_data .= '<h2>FUNDING</h2>
                                <div class="data-ext-load">
                                     <div id="mca_data2">
                                        <b>This does not seem to be PE backed company. Please <a id="deals_data" style="font-weight:bold;cursor:pointer;">Click Here</a> to alert us if you would like us to double check</b>
                                    </div>
                                </div>';
                /*$pe_data .= '<div style="font-size:20px;text-align:center;margin-top:80px;color:#000000;font-weight:bold;margin-bottom: 10px;"><span display: inline-block;vertical-align: middle;line-height: normal;> This does not seem to be PE backed company. Please <a id="deals_data" style="font-weight:bold;cursor:pointer;text-decoration: underline;color: #000000;">Click Here</a> to alert us if you would like us to double check</span></div>';*/
            }
        }
    }else{
         // Show text when company by CIN not found in the PE  companies  table
        if($_POST['trans_status']==0){
                
                //$pe_data .= '<div style="font-size:20px;text-align:center;margin-top:80px;color:#000000;font-weight:bold;margin-bottom: 10px;"><span display: inline-block;vertical-align: middle;line-height: normal;> Data not found. Please <a id="deals_data" style="font-weight:bold;cursor:pointer;text-decoration: underline;color: #000000;">Click Here</a> to alert Venture Intelligence about this. Thanks.</span></div>';
                $pe_data .= '<h2>FUNDING</h2>
                                <div class="data-ext-load">
                                     <div id="mca_data2">
                                        <b>Data not found. Please <a id="deals_data" style="font-weight:bold;cursor:pointer;">Click Here</a> to alert Venture Intelligence about this. Thanks.</b>
                                    </div>
                                </div>';
            }else{
                $pe_data .= '<h2>FUNDING</h2>
                                <div class="data-ext-load">
                                     <div id="mca_data2">
                                        <b>This does not seem to be PE backed company. Please <a id="deals_data" style="font-weight:bold;cursor:pointer;">Click Here</a> to alert us if you would like us to double check</b>
                                    </div>
                                </div>';
                //$pe_data .= '<div style="font-size:20px;text-align:center;margin-top:80px;color:#000000;font-weight:bold;margin-bottom: 10px;"><span display: inline-block;vertical-align: middle;line-height: normal;> This does not seem to be PE backed company. Please <a id="deals_data" style="font-weight:bold;cursor:pointer;text-decoration: underline;color: #000000;">Click Here</a> to alert us if you would like us to double check</span></div>';
            }
    }
}else{
    // Show text when  CIN not found in the CFS
    if($_POST['trans_status']==0){
                
                //$pe_data .= '<div style="font-size:20px;text-align:center;margin-top:80px;color:#000000;font-weight:bold;margin-bottom: 10px;"><span display: inline-block;vertical-align: middle;line-height: normal;> Data not found. Please <a id="deals_data" style="font-weight:bold;cursor:pointer;text-decoration: underline;color: #000000;">Click Here</a> to alert Venture Intelligence about this. Thanks.</span></div>';
                $pe_data .= '<h2>FUNDING</h2>
                                <div class="data-ext-load">
                                     <div id="mca_data2">
                                        <b>Data not found. Please <a id="deals_data" style="font-weight:bold;cursor:pointer;">Click Here</a> to alert Venture Intelligence about this. Thanks.</b>
                                    </div>
                                </div>';
            }else{
                $pe_data .= '<h2>FUNDING</h2>
                                <div class="data-ext-load">
                                     <div id="mca_data2">
                                        <b>This does not seem to be PE backed company. Please <a id="deals_data" style="font-weight:bold;cursor:pointer;">Click Here</a> to alert us if you would like us to double check</b>
                                    </div>
                                </div>';
                //$pe_data .= '<div style="font-size:20px;text-align:center;margin-top:80px;color:#000000;font-weight:bold;margin-bottom: 10px;"><span display: inline-block;vertical-align: middle;line-height: normal;> This does not seem to be PE backed company. Please <a id="deals_data" style="font-weight:bold;cursor:pointer;text-decoration: underline;color: #000000;">Click Here</a> to alert us if you would like us to double check</span></div>';
            }
}
echo json_encode(array( 'count'=> count($pedata), 'html' => $pe_data ) );
?>