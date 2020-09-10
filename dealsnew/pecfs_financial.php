<?php include_once("../globalconfig.php"); ?>
<?php
require_once("../dbconnectvi.php");
$Db = new dbInvestments();

$financial_data='';

if($_POST['cin']!='' && ($_POST['cin']!='0' || $_POST['cin']!=0)){
    
    
    $getcompanysql = "select Company_Id from cprofile where CIN ='".$_POST['cin']."'";
    $companyrs = mysql_query($getcompanysql);          
    $myrow=mysql_fetch_array($companyrs);
    $ResultType1="SELECT MAX( ResultType ) AS ResultType FROM plstandard WHERE CId_FK =".$myrow['Company_Id']." AND FY !=  ''";
    $query=mysql_query($ResultType1);
    $resultType=mysql_fetch_array($query);
    
    if(count($myrow) > 0 && $myrow['Company_Id']!=''){

       /* $sql = "SELECT PLStandard_Id,CId_FK,IndustryId_FK,OptnlIncome,OtherIncome,OptnlAdminandOthrExp,OptnlProfit,EBITDA,Interest,EBDT,Depreciation,EBT,Tax,PAT,FY,TotalIncome,BINR,DINR,EmployeeRelatedExpenses,ForeignExchangeEarningandOutgo,EarninginForeignExchange,OutgoinForeignExchange FROM plstandard WHERE CId_FK =".$myrow['Company_Id']." and FY !='' and ResultType='0' ORDER BY FY";*/
       $sql = "SELECT PLStandard_Id,CId_FK,IndustryId_FK,OptnlIncome,OtherIncome,OptnlAdminandOthrExp,OptnlProfit,EBITDA,Interest,EBDT,Depreciation,EBT,Tax,PAT,FY,TotalIncome,BINR,DINR,EmployeeRelatedExpenses,ForeignExchangeEarningandOutgo,EarninginForeignExchange,OutgoinForeignExchange,EBT_before_Priod_period,Priod_period,CostOfMaterialsConsumed,PurchasesOfStockInTrade,ChangesInInventories,CSRExpenditure,OtherExpenses,CurrentTax,DeferredTax,total_profit_loss_for_period,profit_loss_of_minority_interest FROM plstandard WHERE CId_FK =".$myrow['Company_Id']." and FY !='' and ResultType=".$resultType['ResultType']." ORDER BY FY";
        $financialrs = mysql_query($sql);          
        //$FinanceAnnual = mysql_fetch_array($financialrs);
        $cont=0;$FinanceAnnual2 = array();$convalue = "10000000";
        while ($rs = mysql_fetch_array($financialrs)) {

            //print_r($rs);
            $FinanceAnnual2[$cont]=$rs;
            $cont++;
        }
        $FinanceAnnual = array_reverse($FinanceAnnual2);
//        echo '<pre>';
//        print_r($FinanceAnnual);
//        echo '</pre>';
        if(count($FinanceAnnual) > 0){
    //    exit();
                $financial_data .='<div>
                    <div class="pop_menu" id="pop_menu" style="border: 1px solid 000000;margin: 0px 4px 8px 4px;padding-top: 4px;">
                        <ul>
                            <li data-row="'.$myrow['Company_Id'].'">PROFIT &amp; LOSS</li>
                            <li data-row="'.$myrow['Company_Id'].'">BALANCE SHEET</li>
                            <li data-row="'.$myrow['Company_Id'].'">CASH FLOW</li>
                            <li data-row="'.$myrow['Company_Id'].'">RATIOS</li>
                            <li data-row="'.$myrow['Company_Id'].'">CO. PROFILE</li>
                            <li data-row="'.$myrow['Company_Id'].'">FILINGS</li>
                            <li data-row="'.$myrow['Company_Id'].'">FUNDING</li>
                            <li data-row="'.$myrow['Company_Id'].'">MASTER DATA</li>
                            

                        </ul>
                </div>';
                
                $filename = '../cfs-old/media/plstandard/PLStandard_'.$myrow['Company_Id'].'.xls';
                
                if (file_exists($filename)) {
                  if($resultType['ResultType']==0){   
                    $financial_data .='<div class="popup-export">
                        <div class="popup-button">
                            <a id="expshowdeals" name="showdeal" onClick=" window.open(\'https://www.ventureintelligence.com/cfs-old/media/plstandard/PLStandard_'.$myrow['Company_Id'].'.xls\',\'_blank\') ">Export</a>                                                              
                </div>
                    </div>';
                }else{
                  $financial_data .='<div class="popup-export">
                        <div class="popup-button">
                            <a id="expshowdeals" name="showdeal" onClick=" window.open(\'https://www.ventureintelligence.com/cfs-old/media/plstandard/PLStandard_'.$myrow['Company_Id'].'_1.xls\',\'_blank\') ">Export</a>                                                              
                </div>
                    </div>';
                } 
                }
                
                $financial_data .=' <div class="table-view"><div class="detail-table-div cfs-head" style="float: left;">
                    <table  width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tHead> 
                            <tr>
                                <th>OPERATIONS</th>
                            </tr>
                        </thead>
                        <tbody>  
                          <tr>
                            <td>Opertnl Income</td>
                          </tr>
                          <tr>
                            <td>Other Income</td>
                          </tr>
                          <tr>
                            <td>Total Income</td>
                          </tr>
                          <tr>
                            <td>Cost of materials consumed</td>
                          </tr>
                          
                          <tr>
                            <td>Purchases of stock-in-trade</td>
                          </tr>
                          
                          <tr>
                            <td>Changes in Inventories</td>
                          </tr>
                        
                          <tr>
                            <td>Employee benefit expense</td>
                          </tr>
                          
                          <tr>
                            <td>CSR expenditure</td>
                          </tr>
                          <tr>
                            <td>Other expenses</td>
                          </tr>
                          <tr>
                            <td><span  data-tooltip="" title="Operating,Admministrative & Other Expenses">Ope,Ad&Other</span></td>
                          </tr>
                          <tr>
                            <td>Operating Profit</td>
                          </tr>
                          <tr>
                            <td>EBITDA</td>
                          </tr>
                          <tr>
                            <td>Interest</td>
                           </tr>
                          <tr>
                            <td>EBDT</td>
                          </tr>
                          <tr>
                            <td>Depreciation</td>
                          </tr>
                          <tr>
                        <td>EBT before Exceptional Items </td>
                          </tr>
                          <tr>
                          <td >
                              Prior period/Exceptional /Extra Ordinary Items</td>
                          </tr>
                          <tr>
                            <td >EBT</td>
                          </tr>
                           <!-- Fields added - xbrl2 start-->
                          <tr>
                            <td>Current tax</td>
                          </tr>
                          <tr>
                            <td>Deferred tax</td>
                          </tr>
                            <!-- Fields added - xbrl2 end-->
                          <tr>
                            <td>Tax</td>
                          </tr>
                          <tr>
                            <td>PAT</td>
                          </tr>
                          <tr>
                            <td><b>EPS</b></td>
                          </tr>
                          <tr>
                            <td>EPS Basic (in INR)</td>
                          </tr>
                          <tr>
                            <td>EPS Diluted (in INR)</td>
                           </tr>
                          <tr>
                                <td>&nbsp;</td>
                          </tr>';

                           /* $EmpRelatedExp = '';
                            for($i=0;$i<count($FinanceAnnual);$i++){
                                if($_POST['queryString']!='INR'){
                                    if($FinanceAnnual[$i][EmployeeRelatedExpenses]!=0){
                                        $EmpRelatedExp .= '<td>'. $vale = currency_convert($FinanceAnnual[$i][EmployeeRelatedExpenses],'INR',$_POST['queryString']); $tot=$vale/$convalue; round($tot,2).'</td>';
                                    }
                                }
                                else {

                                    if($FinanceAnnual[$i][EmployeeRelatedExpenses]!=0){
                                        $EmpRelatedExp .= '<td>'. $tot= ($FinanceAnnual[$i][EmployeeRelatedExpenses]/$convalue);round($tot,2).'</td>';
                                    }
                                }
                            }
                            if($EmpRelatedExp!='')
                            {

                                $financial_data .='<tr> <td>Employee Related Expenses</td></tr>';

                            }*/

                            $frnExgEarnin = '';
                            for($i=0;$i<count($FinanceAnnual);$i++){
                                if($_POST['queryString']!='INR'){
                                    if($FinanceAnnual[$i][EarninginForeignExchange]!=0){
                                        $frnExgEarnin .= '<td>'. $vale = currency_convert($FinanceAnnual[$i][EarninginForeignExchange],'INR',$_POST['queryString']); $tot=$vale/$convalue;round($tot,2).'</td>';
                                    }
                                }
                                else {
                                    if($FinanceAnnual[$i][EarninginForeignExchange]!=0){
                                        $frnExgEarnin .= '<td>'. $tot= ($FinanceAnnual[$i][EarninginForeignExchange]/$convalue); round($tot,2).'</td>';
                                    }
                                }
                            }
                            $frnExgOutgoin = '';
                            for($i=0;$i<count($FinanceAnnual);$i++){
                                if($_POST['queryString']!='INR'){
                                    if($FinanceAnnual[$i][OutgoinForeignExchange]!=0){
                                        $frnExgOutgoin .= '<td>'. $vale = currency_convert($FinanceAnnual[$i][OutgoinForeignExchange],'INR',$_POST['queryString']); $tot=$vale/$convalue; round($tot,2).'</td>';
                                    }
                                }
                                else {
                                    if($FinanceAnnual[$i][OutgoinForeignExchange]!=0){
                                        $frnExgOutgoin .= '<td>'. $tot= ($FinanceAnnual[$i][OutgoinForeignExchange]/$convalue); round($tot,2).'</td>';
                                    }
                                }
                            }
                            if($frnExgEarnin!='' || $frnExgOutgoin!=''){

                                $financial_data .='<tr><td style="font-size:14px !important;"><b>Foreign Exchange EarningandOutgo</b></td></tr>';
                           }
                            if($frnExgEarnin!='')
                            {
                                $financial_data .='<tr><td>Earningin Foreign Exchange</td></tr>';
                            }
                            if($frnExgOutgoin!='')
                            {
                              $financial_data .='<tr><td>Outgoin Foreign Exchange</td></tr>';
                            }
                        $financial_data .='</tbody></table></div>';

            $financial_data .='<div class="tab-res cfs-value" style="overflow-x: auto;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tHead> <tr>';
                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    $str     = $FinanceAnnual[$i][FY];
                    $order   = array("(", ")");
                    $replace = ' '; 
                    $FY = str_replace($order, $replace, $str);
                    if($_POST['queryString']!='INR'){

                        $financial_data .='<th>FY'.$FY.'</th>';
                    }
                    else
                    {
                        $financial_data .='<th>FY'.$FY.'</th>';
                    }
                }

            $financial_data .='</tr></thead>
            <tbody><tr>';  

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';

                        if($FinanceAnnual[$i][OptnlIncome]==0)
                        {
                            echo '-';

                        }
                        else{
                            $vale = currency_convert($FinanceAnnual[$i][OptnlIncome],'INR',$_POST['queryString']); 
                            $tot=$vale/$convalue;
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';}

                        }
                        $financial_data .= $response.'</td>';

                    }
                    else
                    {

                        $financial_data .='<td>';

                        if($FinanceAnnual[$i][OptnlIncome]==0)
                        {
                            $response = '-';

                        }else{ 
                            $tot= $FinanceAnnual[$i][OptnlIncome]/$convalue; 
                            $response = round($tot,2);
                        } 
                    $financial_data .= $response.'</td>';
                    }
                }

            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][OtherIncome]==0)
                        {
                            $response =  '-';

                        }else{ 

                            $vale = currency_convert($FinanceAnnual[$i][OtherIncome],'INR',$_POST['queryString']);$tot=$vale/$convalue;  
                            $response = round($tot,2);
                            if($vale==''){
                                $response = '&nbsp';

                            }

                        } 
                        $financial_data .= $response.'</td>';
                    }
                    else
                    {
                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][OtherIncome]==0)
                        {
                            $response = '-';

                        }else{ 
                            $tot= $FinanceAnnual[$i][OtherIncome]/$convalue; 
                            $response = round($tot,2);
                        }
                        $financial_data .= $response.'</td>';
                    }
                }

            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][TotalIncome]==0){
                            $response = '-';

                        }else{
                            $vale = currency_convert($FinanceAnnual[$i][TotalIncome],'INR',$_POST['queryString']); $tot=$vale/$convalue; 
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';}

                        }
                       $financial_data .= $response.'</td>';
                    }
                    else
                    {
                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][TotalIncome]==0){
                            $response = '-';

                        }else{ 
                            $tot= $FinanceAnnual[$i][TotalIncome]/$convalue; 
                            $response = round($tot,2);
                        } 
                        $financial_data .= $response.'</td>';

                    }
                }
            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                        if($_POST['queryString']!='INR'){

                            $financial_data .='<td>';
                            if($FinanceAnnual[$i][CostOfMaterialsConsumed]==0){
                                $response = '-';

                            }else{
                                $vale = currency_convert($FinanceAnnual[$i][CostOfMaterialsConsumed],'INR',$_POST['queryString']); $tot=$vale/$convalue; 
                                $response = round($tot,2);
                                if($vale==''){$response = '&nbsp';}

                            }
                           $financial_data .= $response.'</td>';
                        }
                        else
                        {
                            $financial_data .='<td>';
                            if($FinanceAnnual[$i][CostOfMaterialsConsumed]==0){
                                $response = '-';

                            }else{ 
                                $tot= $FinanceAnnual[$i][CostOfMaterialsConsumed]/$convalue; 
                                $response = round($tot,2);
                            } 
                            $financial_data .= $response.'</td>';

                        }
                    }
            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][PurchasesOfStockInTrade]==0){
                            $response = '-';

                        }else{
                            $vale = currency_convert($FinanceAnnual[$i][PurchasesOfStockInTrade],'INR',$_POST['queryString']); $tot=$vale/$convalue; 
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';}

                        }
                       $financial_data .= $response.'</td>';
                    }
                    else
                    {
                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][PurchasesOfStockInTrade]==0){
                            $response = '-';

                        }else{ 
                            $tot= $FinanceAnnual[$i][PurchasesOfStockInTrade]/$convalue; 
                            $response = round($tot,2);
                        } 
                        $financial_data .= $response.'</td>';

                    }
                }

            $financial_data .='</tr><tr>';
            
                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][ChangesInInventories]==0){
                            $response = '-';

                        }else{
                            $vale = currency_convert($FinanceAnnual[$i][ChangesInInventories],'INR',$_POST['queryString']); $tot=$vale/$convalue; 
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';}

                        }
                       $financial_data .= $response.'</td>';
                    }
                    else
                    {
                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][ChangesInInventories]==0){
                            $response = '-';

                        }else{ 
                            $tot= $FinanceAnnual[$i][ChangesInInventories]/$convalue; 
                            $response = round($tot,2);
                        } 
                        $financial_data .= $response.'</td>';

                    }
                }

            $financial_data .='</tr><tr>';
            
                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){
                            $response = '-';

                        }else{
                            $vale = currency_convert($FinanceAnnual[$i][EmployeeRelatedExpenses],'INR',$_POST['queryString']); $tot=$vale/$convalue; 
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';}

                        }
                       $financial_data .= $response.'</td>';
                    }
                    else
                    {
                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){
                            $response = '-';

                        }else{ 
                            $tot= $FinanceAnnual[$i][EmployeeRelatedExpenses]/$convalue; 
                            $response = round($tot,2);
                        } 
                        $financial_data .= $response.'</td>';

                    }
                }
           
            $financial_data .='</tr><tr>';
            
                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][CSRExpenditure]==0){
                            $response = '-';

                        }else{
                            $vale = currency_convert($FinanceAnnual[$i][CSRExpenditure],'INR',$_POST['queryString']); $tot=$vale/$convalue; 
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';}

                        }
                       $financial_data .= $response.'</td>';
                    }
                    else
                    {
                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][CSRExpenditure]==0){
                            $response = '-';

                        }else{ 
                            $tot= $FinanceAnnual[$i][CSRExpenditure]/$convalue; 
                            $response = round($tot,2);
                        } 
                        $financial_data .= $response.'</td>';

                    }
                }

            $financial_data .='</tr><tr>';
            
                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][OtherExpenses]==0){
                            $response = '-';

                        }else{
                            $vale = currency_convert($FinanceAnnual[$i][OtherExpenses],'INR',$_POST['queryString']); $tot=$vale/$convalue; 
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';}

                        }
                       $financial_data .= $response.'</td>';
                    }
                    else
                    {
                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][OtherExpenses]==0){
                            $response = '-';

                        }else{ 
                            $tot= $FinanceAnnual[$i][OtherExpenses]/$convalue; 
                            $response = round($tot,2);
                        } 
                        $financial_data .= $response.'</td>';

                    }
                }

            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][OptnlAdminandOthrExp]==0){
                           $response =  '-';
                        }else{
                           $vale = currency_convert($FinanceAnnual[$i][OptnlAdminandOthrExp],'INR',$_POST['queryString']);$tot=$vale/$convalue;  
                           $response = round($tot,2);
                           if($vale==''){$response = '&nbsp';}

                        } 
                        $financial_data .= $response.'</td>';

                   }
                   else
                   {
                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][OptnlAdminandOthrExp]==0){
                            $response = '-';

                        }else{ 
                            $tot= $FinanceAnnual[$i][OptnlAdminandOthrExp]/$convalue; 
                            $response = round($tot,2);

                        } 
                        $financial_data .= $response.'</td>';

                    }
                }

            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                if($_POST['queryString']!='INR'){

                    $financial_data .='<td>';
                    if($FinanceAnnual[$i][OptnlProfit]==0){
                        $response = '-';

                    }else{ 
                        $vale = currency_convert($FinanceAnnual[$i][OptnlProfit],'INR',$_POST['queryString']); $tot=$vale/$convalue; 
                        $response = round($tot,2);
                        if($vale==''){$response = '&nbsp';}

                    } 
                    $financial_data .= $response.'</td>';

                }
                else
                {
                    $financial_data .='<td>';
                    if($FinanceAnnual[$i][OptnlProfit]==0){
                        $response = '-';

                    }else{
                        $tot= $FinanceAnnual[$i][OptnlProfit]/$convalue;
                        $response = round($tot,2);
                    }
                    $financial_data .= round($tot,2).'</td>';

                }
            }

            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][EBITDA]==0){
                            $response = '-';

                        }else{ 
                            $vale = currency_convert($FinanceAnnual[$i][EBITDA],'INR',$_POST['queryString']);$tot=$vale/$convalue;  
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';}

                        }
                        $financial_data .= $response.'</td>';
                    }
                    else
                    {
                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][EBITDA]==0){
                            $response = '-';

                        }else{ 
                            $tot=$FinanceAnnual[$i][EBITDA]/$convalue; 
                            $response = round($tot,2);
                        } 
                        $financial_data .= $response.'</td>';

                    }
                }

            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][Interest]==0){
                            $response = '-';

                        }else{ 
                            $vale = currency_convert($FinanceAnnual[$i][Interest],'INR',$_POST['queryString']);$tot=$vale/$convalue;  
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';}

                        }
                        $financial_data .= $response.'</td>';

                    }
                    else
                    {
                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][Interest]==0){
                            $response = '-';

                        }else{ 
                            $tot= $FinanceAnnual[$i][Interest]/$convalue; 
                            $response = round($tot,2);

                        } 
                        $financial_data .= $response.'</td>';

                    }
                }

            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>'; 
                        if($FinanceAnnual[$i][EBDT]==0){
                            $response =  '-';

                        }else{ 
                            $vale = currency_convert($FinanceAnnual[$i][EBDT],'INR',$_POST['queryString']);$tot=$vale/$convalue;  
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';}

                        }
                        $financial_data .= $response.'</td>';

                    }
                    else
                    {
                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][EBDT]==0){
                            $response = '-';

                        }else{ 
                            $tot= $FinanceAnnual[$i][EBDT]/$convalue;
                            $response = round($tot,2);

                        } 
                        $financial_data .= $response.'</td>';

                    }
                }

            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][Depreciation]==0){
                            $response = '-';

                        }else{ 
                            $vale = currency_convert($FinanceAnnual[$i][Depreciation],'INR',$_POST['queryString']); $tot=$vale/$convalue;
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';}

                        } 
                        $financial_data .= $response.'</td>';
                    }
                    else
                    {
                       $financial_data .='<td>';
                       if($FinanceAnnual[$i][Depreciation]==0){
                           $response = '-';

                       }else{
                           $tot= $FinanceAnnual[$i][Depreciation]/$convalue;
                           $response = round($tot,2);

                       }
                       $financial_data .= $response.'</td>';

                    }
                }

            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][EBT_before_Priod_period] == 0 && $FinanceAnnual[$i][Priod_period] == 0){ 

                            $vale = currency_convert($FinanceAnnual[$i][EBT],'INR',$_POST['queryString']); $tot=$vale/$convalue;
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';} 

                        }else if($FinanceAnnual[$i][EBT_before_Priod_period]==0 ) {

                            $response =  '-';
                        }else{ 

                            $vale = currency_convert($FinanceAnnual[$i][EBT_before_Priod_period],'INR',$_POST['queryString']);$tot=$vale/$convalue; 
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';}
                        }
                        $financial_data .= $response.'</td>';

                    }
                    else
                    {
                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][EBT_before_Priod_period] == 0 && $FinanceAnnual[$i][Priod_period] == 0){ 
                            $tot= ($FinanceAnnual[$i][EBT]/$convalue);  
                            $response = round($tot,2);

                        }else if($FinanceAnnual[$i][EBT_before_Priod_period]==0){
                            $response = '-';

                        }else{ 
                            $tot= ($FinanceAnnual[$i][EBT_before_Priod_period]/$convalue); 
                            $response = round($tot,2);
                        } 
                        $financial_data .= $response.'</td>';
                    }
                }

            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';
                        if($FinanceAnnual[$i][Priod_period]==0){
                            $response = '-';

                        }else{ 
                            $vale = currency_convert($FinanceAnnual[$i][Priod_period],'INR',$_POST['queryString']);$tot=$vale/$convalue;  
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';}

                        }
                        $financial_data .= $response.'</td>';
                    }
                    else
                    {
                        $financial_data .='<td>';  
                        if($FinanceAnnual[$i][Priod_period]==0){
                            $response = '-';

                        }else{ 
                            $tot= ($FinanceAnnual[$i][Priod_period]/$convalue);
                            $response = round($tot,2);

                        } 
                        $financial_data .= $response.'</td>';
                    }
                }

            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';  
                        if($FinanceAnnual[$i][EBT]==0){
                            $response = '-';

                        }else{ 
                            $vale = currency_convert($FinanceAnnual[$i][EBT],'INR',$_POST['queryString']);$tot=$vale/$convalue;  
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';}

                        }
                        $financial_data .= $response.'</td>';

                    }
                    else
                    {
                        $financial_data .='<td>';  
                        if($FinanceAnnual[$i][EBT]==0){
                            $response = '-';

                        }else{ 
                            $tot= $FinanceAnnual[$i][EBT]/$convalue;
                            $response = round($tot,2);

                        }
                        $financial_data .= $response.'</td>';
                    }
                }

            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';  
                        if($FinanceAnnual[$i][CurrentTax]==0){
                            $response = '-';

                        }else{ 
                            $vale = currency_convert($FinanceAnnual[$i][CurrentTax],'INR',$_POST['queryString']);$tot=$vale/$convalue;  
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';}

                        }
                        $financial_data .= $response.'</td>';

                    }
                    else
                    {
                        $financial_data .='<td>';  
                        if($FinanceAnnual[$i][CurrentTax]==0){
                            $response = '-';

                        }else{ 
                            $tot= $FinanceAnnual[$i][CurrentTax]/$convalue;
                            $response = round($tot,2);

                        }
                        $financial_data .= $response.'</td>';
                    }
                }

            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';  
                        if($FinanceAnnual[$i][DeferredTax]==0){
                            $response = '-';

                        }else{ 
                            $vale = currency_convert($FinanceAnnual[$i][DeferredTax],'INR',$_POST['queryString']);$tot=$vale/$convalue;  
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';}

                        }
                        $financial_data .= $response.'</td>';

                    }
                    else
                    {
                        $financial_data .='<td>';  
                        if($FinanceAnnual[$i][DeferredTax]==0){
                            $response = '-';

                        }else{ 
                            $tot= $FinanceAnnual[$i][DeferredTax]/$convalue;
                            $response = round($tot,2);

                        }
                        $financial_data .= $response.'</td>';
                    }
                }

            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';  
                        if($FinanceAnnual[$i][Tax]==0){
                            $response = '-';

                        }else{
                            $vale = currency_convert($FinanceAnnual[$i][Tax],'INR',$_POST['queryString']);$tot=$vale/$convalue;
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';}

                        }
                        $financial_data .= $response.'</td>';
                    }
                    else
                    {
                        $financial_data .='<td>';  
                        if($FinanceAnnual[$i][Tax]==0){
                            $response = '-';

                        }else{ 
                            $tot= $FinanceAnnual[$i][Tax]/$convalue;
                            $response = round($tot,2);
                        } 
                        $financial_data .= $response.'</td>';
                    }
                }

            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';  
                        if($FinanceAnnual[$i][PAT]==0){
                            $response = '-';

                        }else{
                            $vale = currency_convert($FinanceAnnual[$i][PAT],'INR',$_POST['queryString']); $tot=$vale/$convalue;
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';}

                        } 
                        $financial_data .= $response.'</td>';
                    }
                    else
                    {
                        $financial_data .='<td>';   
                        if($FinanceAnnual[$i][PAT]==0){
                            $response = '-';

                        }else{ 
                            $tot= $FinanceAnnual[$i][PAT]/$convalue;
                            $response = round($tot,2);
                        } 
                        $financial_data .= $response.'</td>';
                    }
                }

           

            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>&nbsp;</td>';
                    }
                    else
                    {
                         $financial_data .='<td>&nbsp;</td>';

                    }
                }

            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';  
                        if($FinanceAnnual[$i][BINR]==0){
                            $response = '-';

                        }else{
                            $vale = currency_convert($FinanceAnnual[$i][BINR],'INR',$_POST['queryString']); $tot=$vale/$convalue;
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';}

                        } 
                        $financial_data .= $response.'</td>';
                    }
                    else
                    {
                       $financial_data .='<td>';  
                       if($FinanceAnnual[$i][BINR]==0){
                           $response = '-';

                       }else{ 
                           $tot= $FinanceAnnual[$i][BINR]/$convalue;
                           $response = round($tot,2);
                       } 
                       $financial_data .= $response.'</td>';
                    }
                }

            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>';  
                        if($FinanceAnnual[$i][DINR]==0){
                            $response = '-';

                        }else{ 
                            $vale = currency_convert($FinanceAnnual[$i][DINR],'INR',$_POST['queryString']); $tot=$vale/$convalue; 
                            $response = round($tot,2);
                            if($vale==''){$response = '&nbsp';}

                        } 
                        $financial_data .= $response.'</td>';
                    }
                    else
                    {
                        $financial_data .='<td>';  
                        if($FinanceAnnual[$i][DINR]==0){
                            $response = '-';

                        }else{ 
                            $tot= $FinanceAnnual[$i][DINR]/$convalue;
                            $response = round($tot,2);
                        } 
                        $financial_data .= $response.'</td>'; 
                    }
                }

            $financial_data .='</tr><tr>';

                for($i=0;$i<count($FinanceAnnual);$i++){ 

                    if($_POST['queryString']!='INR'){

                        $financial_data .='<td>&nbsp;</td>';
                    }
                    else
                    {    
                         $financial_data .='<td>&nbsp;</td>';
                    }
                }

            

            $financial_data .='</tr><tr>';

                $frnExgEarnCont2 = '';
                for($i=0;$i<count($FinanceAnnual);$i++){

                    if($_POST['queryString']!='INR'){
                        if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]!=0){
                            $frnExgEarnCont2 .= '<td>'. $vale = currency_convert($FinanceAnnual[$i][ForeignExchangeEarningandOutgo],'INR',$_POST['queryString']); $tot=$vale/$convalue; round($tot,2).'</td>';
                        }
                    }
                    else{
                        if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]!=0){
                            $frnExgEarnCont2 .= '<td>'. $tot= ($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]/$convalue); round($tot,2).'</td>';
                        }
                    }

                }

            $financial_data .='</tr>';

                if($frnExgEarnCont2!='')
                {

                    $financial_data .='<tr>';
                    for($i=0;$i<count($FinanceAnnual);$i++){ 

                        if($_POST['queryString']!='INR'){

                            $financial_data .='<td>';
                            if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]==0){
                                $response = '&nbsp';

                            }else{
                                $vale = currency_convert($FinanceAnnual[$i][ForeignExchangeEarningandOutgo],'INR',$_POST['queryString']);$tot=$vale/$convalue; 
                                $response = round($tot,2);
                                if($vale==''){$response = '&nbsp';}

                            }
                            $financial_data .= $response.'</td>';

                        }
                        else
                        {
                            $financial_data .='<td>';
                            if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]==0){
                                $response = '&nbsp';

                            }else{ 
                                $tot= $FinanceAnnual[$i][ForeignExchangeEarningandOutgo]/$convalue; 
                                $response = round($tot,2);
                            } 
                            $financial_data .= $response.'</td>';
                        }
                    }
                    $financial_data .='</tr>';
                }

            $financial_data .='<tr>';

                $frnExgEarnin2 = '';
                for($i=0;$i<count($FinanceAnnual);$i++){

                    if($_POST['queryString']!='INR'){
                        if($FinanceAnnual[$i][EarninginForeignExchange]!=0){
                            $frnExgEarnin2 .= '<td>'. $vale = currency_convert($FinanceAnnual[$i][EarninginForeignExchange],'INR',$_POST['queryString']); $tot=$vale/$convalue;round($tot,2).'</td>';
                        }
                    }
                    else {
                        if($FinanceAnnual[$i][EarninginForeignExchange]!=0){
                            $frnExgEarnin2 .= '<td>'. $tot= ($FinanceAnnual[$i][EarninginForeignExchange]/$convalue); round($tot,2).'</td>';
                        }
                    }
                }

                $frnExgOutgoin2 = '';
                for($i=0;$i<count($FinanceAnnual);$i++){

                    if($_POST['queryString']!='INR'){

                        if($FinanceAnnual[$i][OutgoinForeignExchange]!=0){
                            $frnExgOutgoin2 .= '<td>'. $vale = currency_convert($FinanceAnnual[$i][OutgoinForeignExchange],'INR',$_POST['queryString']); $tot=$vale/$convalue; round($tot,2).'</td>';
                        }
                    }
                    else {
                        if($FinanceAnnual[$i][OutgoinForeignExchange]!=0){
                            $frnExgOutgoin2 .= '<td>'. $tot= ($FinanceAnnual[$i][OutgoinForeignExchange]/$convalue); round($tot,2).'</td>';
                        }
                    }
                }

                if($frnExgEarnin2!='' || $frnExgOutgoin2!='')
                { 
                    $financial_data .='<tr>';
                    for($i=0;$i<count($FinanceAnnual);$i++){ 

                        if($_POST['queryString']!='INR'){

                            $financial_data .='<td>';
                            if($FinanceAnnual[$i][EarninginForeignExchange]==0){
                                $response = '&nbsp';

                            }else{
                                $vale = currency_convert($FinanceAnnual[$i][EarninginForeignExchange],'INR',$_POST['queryString']); $tot=$vale/$convalue;
                                $response = round($tot,2);
                                if($vale==''){$response = '&nbsp';}

                            } 
                            $financial_data .= $response.'</td>';
                        }
                        else
                        {
                           $financial_data .='<td>';
                           if($FinanceAnnual[$i][EarninginForeignExchange]==0){
                               $response = '&nbsp';

                           }else{ 
                               $tot= $FinanceAnnual[$i][EarninginForeignExchange]/$convalue;
                               $response = round($tot,2);
                           } 
                           $financial_data .= $response.'</td>';
                        }
                    }
                    $financial_data .='</tr>';
                }

                if($frnExgEarnin2!='')
                {
                    $financial_data .='<tr>';
                            //echo $frnExgEarnin;
                    for($i=0;$i<count($FinanceAnnual);$i++){ 

                        if($_POST['queryString']!='INR'){

                            $financial_data .='<td>';
                            if($FinanceAnnual[$i][EarninginForeignExchange]==0){
                                $response = '-';

                            }else{

                                $vale = currency_convert($FinanceAnnual[$i][EarninginForeignExchange],'INR',$_POST['queryString']);$tot=$vale/$convalue; 
                                $response = round($tot,2);
                                if($vale==''){$response = '&nbsp';}

                            } 
                            $financial_data .= $response.'</td>';
                            $frnExgOutgoin .= '<td>'. $vale = currency_convert($FinanceAnnual[$i][OutgoinForeignExchange],'INR',$_POST['queryString']); $tot=$vale/$convalue; round($tot,2).'</td>';
                        }
                        else
                        {
                            $financial_data .='<td>';
                            if($FinanceAnnual[$i][EarninginForeignExchange]==0){
                                $response = '-';

                            }else{ 
                                $tot=($FinanceAnnual[$i][EarninginForeignExchange]/$convalue);
                                $response = round($tot,2);
                            } 
                            $financial_data .= $response.'</td>';
                        }
                    }

                    $financial_data .='</tr>';

                }

                if($frnExgOutgoin !='')
                { 
                    $financial_data .='<tr>';
                    //echo  $frnExgOutgoin ;
                    for($i=0;$i<count($FinanceAnnual);$i++){ 

                        if($_POST['queryString']!='INR'){

                            $financial_data .='<td>';
                            if($FinanceAnnual[$i][OutgoinForeignExchange]==0){
                                $response = '-';

                            }else{ 
                                $vale = currency_convert($FinanceAnnual[$i][OutgoinForeignExchange],'INR',$_POST['queryString']);$tot=$vale/$convalue; 
                                $response = round($tot,2);
                                if($vale==''){$response = '&nbsp';}

                            } 
                            $financial_data .= $response.'</td>';
                        }
                        else
                        {
                            $financial_data .='<td>';
                            if($FinanceAnnual[$i][OutgoinForeignExchange]==0){
                                $response = '-';

                            }else{ 
                                $tot= ($FinanceAnnual[$i][OutgoinForeignExchange]/$convalue);
                                $response = round($tot,2);
                            } 
                           $financial_data .= $response.'</td>';
                        }
                    }
                    $financial_data .='</tr>';
                }

                $financial_data .='</tbody></table></div></div></div>';
        
        }else{
            $financial_data .= '<div style="height:200px;font-size:16px;text-align:center;margin-top:200px;"><span display: inline-block;vertical-align: middle;line-height: normal;> Data not found. Please <a href="mailto:arun@ventureintelligence.in?subject=Request for financials linking&body='.GLOBAL_BASE_URL.'dealsnew/dealdetails.php?value=1829487383/0/&scr=EMAIL"  id="financial_data" style="font-weight:bold;cursor:pointer;text-decoration: underline;color: #624C34;">Click Here</a> to alert Venture Intelligence about this. Thanks.</span></div>';
        }
    }else{

        $financial_data .= '<div style="height:200px;font-size:16px;text-align:center;margin-top:200px;"><span display: inline-block;vertical-align: middle;line-height: normal;>Data not found. Please <a href="mailto:arun@ventureintelligence.in?subject=Request for financials linking&body='.GLOBAL_BASE_URL.'dealsnew/dealdetails.php?value=1829487383/0/&scr=EMAIL"  id="financial_data" style="font-weight:bold;cursor:pointer;text-decoration: underline;color: #624C34;">Click Here</a> to alert Venture Intelligence about this. Thanks. </span></div>'; //Company not found in CFS.
    }
}else{
    $financial_data .= '<div style="height:200px;font-size:16px;text-align:center;margin-top:200px;"><span display: inline-block;vertical-align: middle;line-height: normal;>Data not found. Please <a href="mailto:arun@ventureintelligence.in?subject=Request for financials linking&body='.GLOBAL_BASE_URL.'dealsnew/dealdetails.php?value=1829487383/0/&scr=EMAIL"  id="financial_data" style="font-weight:bold;cursor:pointer;text-decoration: underline;color: #624C34;">Click Here</a> to alert Venture Intelligence about this. Thanks.</span></div>'; //CIN number not found.
}
echo json_encode($financial_data);
?>