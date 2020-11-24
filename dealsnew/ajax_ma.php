<?php
require_once("../dbconnectvi.php");
$Db = new dbInvestments();

$pe_data='';

if($_POST['cin']!=''){
    
    // get company by CIN
    $getcompanysql = "select PECompanyId,companyname from pecompanies where CINNo ='".$_POST['cin']."'";
    $companyrs = mysql_query($getcompanysql);          
    $myrow=mysql_fetch_array($companyrs);
    
    $acquirersql ="SELECT AcquirerId FROM acquirers WHERE Acquirer LIKE '".trim($myrow['companyname'])."%'";
    $acquirer= mysql_query($acquirersql);
    while($myacq=mysql_fetch_array($acquirer)){
    $acqarr[]=$myacq['AcquirerId'];
    }
    
    $acqval=implode(",",$acqarr);
   
    
    $orderby=$_POST['orderby'];
    
    // Order by code
    if($orderby=='companyname')
    {
        $order_query = 'companyname';
        if($_POST['order'] == 'asc'){
            
            $order_status = $order_company = 'desc';
        }else{
            $order_status = $order_company ='asc';
        }
        
    }else{
        $order_company = 'asc';
    }
    
    if($orderby=='sector_business'){
        
        $order_query = 'sector_business';
        if($_POST['order']=='asc'){
            
            $order_status = $order_sector = 'desc';
        }else{
            $order_status = $order_sector = 'asc';
        }
    }else{
        $order_sector = 'asc';
    }
    
    if($orderby=='acquirer'){
        
        $order_query = 'acquirer';
        if($_POST['order']=='asc'){
            
            $order_status = $order_acquirer = 'desc';
        }else{
            $order_status = $order_acquirer = 'asc';
        }
    }else{
        $order_acquirer = 'asc';
    }
    
    if($orderby=='dates'){
        
        $order_query = 'dates';
        if($_POST['order'] =='desc'){
            $order_status = $order_dates = 'asc';
            
        }else{
            $order_status = $order_dates = 'desc';
        }
    }else{
        $order_dates = 'desc';
    }
    
   
    
    if($orderby=='amount'){
        
        $order_query = 'amount';
        if($_POST['order'] == 'asc'){
            
            $order_status = $order_amount = 'desc';
        }else{
            $order_status = $order_amount = 'asc';
        }
    }else{
        $order_amount =  'asc';
    }
//     echo $order_query;
    //echo $_POST['order'];
    $order = $order_status ? $order_status:'asc';
    $query_orderby = $order_query?$order_query : 'companyname';
            
    if(count($myrow) > 0 && $myrow['PECompanyId']!=''){
        if($order_query == "acquirer" || $order_query == "companyname" || $order_query == "sector_business"  || $order_query =="amount" ){
            $order1 ='ORDER  BY '.$query_orderby.' '. $order .',dealdate DESC';
        }elseif($order_query == "dates" ){
            $order1 ='ORDER  BY dealdate '.$order;
        }else{
            $order1 ='ORDER  BY dealdate DESC,'.$query_orderby.' '.$order;
        }
        if($acqval !=""){
            $acqvar=" ac.acquirerid IN ( ".$acqval." )";
        }else{
            $acqvar="";
        }
        if($acqval !="" && $myrow['PECompanyId'] !=''){
            $orcond=" or ";
        }else{
            $orcond="";
        }
        if($myrow['PECompanyId'] !=''){
        $companyvar="  c.pecompanyid =".$myrow['PECompanyId'];
        }else{
            $companyvar="";
        }
        $sql = "SELECT peinv.pecompanyid, 
        peinv.mamaid, 
        c.companyname, 
        c.industry, 
        i.industry, 
        sector_business                AS sector_business, 
        peinv.amount, 
        peinv.acquirerid, 
        ac.acquirer, 
        peinv.asset, 
        peinv.hideamount, 
        agghide, 
        Date_format(dealdate, '%b-%Y') AS dates, 
        dealdate                       AS DealDate 
 FROM   acquirers AS ac, 
        mama AS peinv, 
        pecompanies AS c, 
        industry AS i 
 WHERE  dealdate BETWEEN '2004-1-01' AND '2020-10-31' 
        AND ac.acquirerid = peinv.acquirerid 
        AND c.industry = i.industryid 
        AND c.pecompanyid = peinv.pecompanyid 
        AND peinv.deleted = 0 
        AND c.industry != 15 
        AND ( $acqvar $orcond $companyvar )
        AND c.industry IN ( 49, 14, 9, 25, 
                            24, 7, 4, 16, 
                            17, 23, 3, 21, 
                            1, 2, 10, 54, 
                            18, 11, 66, 106, 
                            8, 12, 22 ) ".$order1;
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

      
        $inrvalue = "SELECT value FROM configuration WHERE purpose='USD_INR'";
                    $inramount = mysql_query($inrvalue);
                    while($inrAmountRow = mysql_fetch_array($inramount,MYSQL_BOTH))
                    {
                        $usdtoinramount = $inrAmountRow['value'];
                    }
        if($hideinrcount > 0){
            $totalINRAmount = $totalAmount * 1000000 * $usdtoinramount / 10000000;
        } 
     
        // Table to show the companies with count at the top
        if(count($pedata) > 0){
            
                
                $pe_data.='<div class="view-table view-table-list ">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
                    <thead><tr>
                        <th style="width: 530px;" class="headertbma" data-cin="'.$_POST['cin'].'" data-order="'.$order_company.'" id="companyname">Company</th>
                        <th style="width: 850px;" class="headertbma" data-cin="'.$_POST['cin'].'" data-order="'.$order_sector.'" id="sector_business">Sector</th>
                        <th style="width: 260px;" class="headertbma" data-cin="'.$_POST['cin'].'" data-order="'.$order_acquirer.'" id="acquirer">Acquirer</th>
                        <th style="width: 200px;" class="headertbma" data-cin="'.$_POST['cin'].'" data-order="'.$order_dates.'" id="dates">Date</th>
                        <th style="width: 200px;" class="headertbma" data-cin="'.$_POST['cin'].'" data-order="'.$order_amount.'" id="amount">Amount</th>
                    </tr></thead>
                    <tbody id="movies">';
                    
                foreach($pedata as $ped){ 
                    $searchString4="PE Firm(s)";
                    $searchString4=strtolower($searchString4);
                    $searchString4ForDisplay="PE Firm(s)";
                    $searchString="Undisclosed";
                    $searchString=strtolower($searchString);
                    $searchString3="Individual";
                    $searchString3=strtolower($searchString3);
                    $companyName=trim($ped["companyname"]);
                    $companyName=strtolower($companyName);
                    $compResult=substr_count($companyName,$searchString);
                    $compResult4=substr_count($companyName,$searchString4);

                    $acquirerName=$ped["acquirer"];
                    $acquirerName=strtolower($acquirerName);

                    $compResultAcquirer=substr_count($acquirerName,$searchString4);
                    $compResultAcquirerUndisclosed=substr_count($acquirerName,$searchString);
                    $compResultAcquirerIndividual=substr_count($acquirerName,$searchString3);

                    if($compResult==0)
                            $displaycomp=$ped["companyname"];
                    elseif($compResult4==1)
                            $displaycomp=ucfirst("$searchString4");
                    elseif($compResult==1)
                            $displaycomp=ucfirst("$searchString");

                    if(($compResultAcquirer==0) && ($compResultAcquirerUndisclosed==0) && ($compResultAcquirerIndividual==0))
                            $displayAcquirer=$ped["acquirer"];
                    elseif($compResultAcquirer==1)
                            $displayAcquirer=ucfirst("$searchString4ForDisplay");
                    elseif($compResultAcquirerUndisclosed==1)
                            $displayAcquirer=ucfirst("$searchString");
                    elseif($compResultAcquirerIndividual==1)
                            $displayAcquirer=ucfirst("$searchString3");

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

                        // if($ped["hideamount"]==1)
                        // {
                        //         $hideamount="--";
                        // }
                        // else
                        // {
                        //         $hideamount=$ped["amount"];
                        // }
                        if($ped["amount"]==0)
                         {
                                 $hideamount="-";
                                 $amountobeAdded=0;
                         }
                         elseif($ped["hideamount"]==1)
                         {
                                 $hideamount="-";
                                 $amountobeAdded=0;

                         }
                         else
                         {
                                 $hideamount=$ped["amount"];
                                // $acrossDealsCnt=$acrossDealsCnt+1;
                                 $amountobeAdded=$ped["Amount"];
                         }
                        if($ped["asset"]==1)
                                                         {
                                                                $openBracket="(";
                                                                $closeBracket=")";
                                                         }
                                                         else
                                                         {
                                                                $openBracket="";
                                                                $closeBracket="";
                                                          }
                                                          if($ped["agghide"]==1)
                                                        {
                                                                $opensquareBracket="{";
                                                                $closesquareBracket="}";
                                                                $hideFlagset = 1;
                                                                $amtTobeDeductedforAggHide=$ped["amount"];
                                                                $NoofDealsCntTobeDeducted=1;

                                                                //$acrossDealsCnt=$acrossDealsCnt-1;
                                                         }
                                                        else
                                                        {
                                                                $opensquareBracket="";
                                                                $closesquareBracket="";
                                                                $amtTobeDeductedforAggHide=0;
                                                                $NoofDealsCntTobeDeducted=0;
                                                                $cos_array = $cos_withdebt_array;
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
                        $pe_data.='<tr class="details_linkma" data-row="'.$ped["mamaid"].'" >

                                <td style="width: 530px;"><b>'.$openBracket.$openDebtBracket.$opensquareBracket.trim($ped["companyname"]).$closesquareBracket.$closeDebtBracket.$closeBracket.'</b></td>
                                <td style="width: 850px;"><b>'.trim($ped["sector_business"]).'</b></td>
                                <td style="width: 260px;"><b>'.$displayAcquirer.'</b></td>
                                <td style="width: 200px;"><b>'.$ped["dates"].'</b></td>
                                <td style="width: 200px;"><b>'.$hideamount.'</b></td>

                        </a></tr>';
                    }

                    $pe_data.='</tbody></table></div>';

        
        }else{
            // Show text when deals not found for this given company in PE
            
                $pe_data .= '<h2>M&A</h2>
                                <div class="data-ext-load">
                                    <div id="mca_data2">
                                    <b>No M&A activity found for this company <a id="deals_data" style="font-weight:bold;cursor:pointer;">Click Here</a> to double check with Venture Intelligence on this.</b>
                                    </div>
                                </div>';
                /*$pe_data .= '<div style="font-size:20px;text-align:center;margin-top:80px;color:#000000;font-weight:bold;margin-bottom: 10px;"><span display: inline-block;vertical-align: middle;line-height: normal;> This does not seem to be PE backed company. Please <a id="deals_data" style="font-weight:bold;cursor:pointer;text-decoration: underline;color: #000000;">Click Here</a> to alert us if you would like us to double check</span></div>';*/
            
        }
    }else{
         // Show text when company by CIN not found in the PE  companies  table
       
                $pe_data .= '<h2>M&A</h2>
                                <div class="data-ext-load">
                                     <div id="mca_data2">
                                     <b>No M&A activity found for this company <a id="deals_data" style="font-weight:bold;cursor:pointer;">Click Here</a> to double check with Venture Intelligence on this.</b>
                                    </div>
                                </div>';
                //$pe_data .= '<div style="font-size:20px;text-align:center;margin-top:80px;color:#000000;font-weight:bold;margin-bottom: 10px;"><span display: inline-block;vertical-align: middle;line-height: normal;> This does not seem to be PE backed company. Please <a id="deals_data" style="font-weight:bold;cursor:pointer;text-decoration: underline;color: #000000;">Click Here</a> to alert us if you would like us to double check</span></div>';
            
    }
}else{
    // Show text when  CIN not found in the CFS
  
                $pe_data .= '<h2>M&A</h2>
                                <div class="data-ext-load">
                                     <div id="mca_data2">
                                        <b>No M&A activity found for this company <a id="deals_data" style="font-weight:bold;cursor:pointer;">Click Here</a> to double check with Venture Intelligence on this.</b>
                                    </div>
                                </div>';
                //$pe_data .= '<div style="font-size:20px;text-align:center;margin-top:80px;color:#000000;font-weight:bold;margin-bottom: 10px;"><span display: inline-block;vertical-align: middle;line-height: normal;> This does not seem to be PE backed company. Please <a id="deals_data" style="font-weight:bold;cursor:pointer;text-decoration: underline;color: #000000;">Click Here</a> to alert us if you would like us to double check</span></div>';
            
}
echo json_encode(array( 'count'=> count($pedata), 'html' => $pe_data ,'sql'=> $sql) );
?>