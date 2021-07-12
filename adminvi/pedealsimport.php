<?php include_once("../globalconfig.php"); ?>
<?php

    include_once('../PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php');
    
    require("../dbconnectvi.php");  
    $Db = new dbInvestments();
    //session_save_path("/tmp");
    session_start();
    if (session_is_registered("SessLoggedAdminPwd"))
    {
//        echo "dddddddddddddddddddddddddddd";
//        print_r( $filename  = $_FILES['pedealsfilepath']['tmp_name']);
//        exit();
        
        if(isset($_FILES['pedealsfilepath'])){
            
            if($_FILES['pedealsfilepath']['tmp_name']){
               
                if(!$_FILES['pedealsfilepath']['error'])
                {
                    
                    $inputFile = $_FILES['pedealsfilepath']['tmp_name'];
                    $inputFilename = $_FILES['pedealsfilepath']['name'];
                    
                    $extension = strtoupper(pathinfo($inputFilename, PATHINFO_EXTENSION));
                   
                    if($extension == 'XLS' || $extension == 'XLSX'){

                        //Read spreadsheeet workbook
                        try {
                            $inputFileType = PHPExcel_IOFactory::identify($inputFile);
                            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                            $objPHPExcel = $objReader->load($inputFile);
                        } catch(Exception $e) {
                            die($e->getMessage());
                        }
                       
                        $data = array($objPHPExcel->getActiveSheet()->toArray(null,true,true,true));
                        $rowcount=0;
                        if(count($data) <= 0){ ?>
                            <Br>
                            <div style="font-family: Verdana; font-size: 8pt">Problem in uploaded Excel as data not in proper format or no row has been added. Please check and uplaod again <a href="uploaddeals.php">Back to Upload</a></td></div>
                                    
                        <?php
                      
                            exit();
                        }
                      
                        foreach($data[0] as $da){

                            if($da['A'] !=''){
                                $rowcount++;
                            }
                        }
                       
                        //Get worksheet dimensions
                        $sheet = $objPHPExcel->getSheet(0); 
                        $highestRow = $rowcount; 
                        $highestColumn = 'BE';
                        
                        $rowData = array();
                        //Loop through each row of the worksheet in turn
                        for ($row = 2; $row <= $highestRow; $row++){ 
                                //  Read a row of data into an array
                            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, "", TRUE, TRUE);
                            /*echo '<pre>';
                            print_r($rowData);
                            echo '</pre>';*/
                            $portfoliocompany = $rowData[0][0];
                                                        
                            $monthtoAdd = $rowData[0][1];
                            $yeartoAdd = $rowData[0][2];
                            $IPODate = returnDate($monthtoAdd,$yeartoAdd);
                            
                            if($rowData[0][3] == 'Listed'){
                                $listingstatusvalue = 'L'; //3
                            }else{
                                $listingstatusvalue = 'U'; //3
                            }
                            
                            if($rowData[0][4] == 'Unexited'){
                                $exitstatusvalue = 1; //3
                            }elseif($rowData[0][4] == 'Partially Exited'){
                                $exitstatusvalue = 2; //3
                            }elseif($rowData[0][4] == 'Fully Exited'){
                                $exitstatusvalue = 3; //3
                            }
                            
                            $industry_name = $rowData[0][5];
                            $industrysql = "select industryid,industry from industry where industryid !=15 and industry='".trim($industry_name)."'order by industry";
                            $industryid = 0;
                            if ($industryrs = mysql_query($industrysql))
                            {
                                $ind_cnt = mysql_num_rows($industryrs);
                            }
                            if($ind_cnt > 0)
                            {
                                $myrow = mysql_fetch_row($industryrs, MYSQL_BOTH);
                                $indid = $myrow['industryid'];
                                mysql_free_result($industryrs);
                                
                            }else{
                                $indid = '';
                            }

                            $sector = $rowData[0][6];

                            $sectors = explode("(" , $sector);
                            $sectorname = $sectors[0];
                            preg_match('#\((.*?)\)#', $rowData[0][6], $match);
                            $subsectorname = $match[1];
                            $addsubsectorname = substr($subsectorname, strpos($subsectorname, " - ")+3 ); 
                            $subsectorname = explode(" - " , $subsectorname);
                            $subsectorname = $subsectorname[0];

                            $DealAmount = $rowData[0][7];
                            
                            if($rowData[0][8] == 'Yes')
                            {
                                $hideamount = 1;
                            }
                            else
                            {
                                $hideamount = 0;
                            }

                            $amounttoUpdate_INR = $rowData[0][9];
                            if($DealAmount <= 0){
                                
                                $DealAmount = 0;
                            }

                            $Round = $rowData[0][10];

                            $Stage = $rowData[0][11];
                            $stageSql = "select StageId,Stage from stage where Stage='".$Stage."' order by StageId";

                            $StageId='';
                            if ($rsStage = mysql_query( $stageSql))
                            {
                              $stage_cnt = mysql_num_rows($rsStage);
                            }
                            if($stage_cnt > 0)
                            {
                                While($myrow=mysql_fetch_array($rsStage, MYSQL_BOTH))
                                {
                                        $StageId = $myrow['StageId'];
                                }
                                mysql_free_result($rsStage);
                            }                  

                        //----------- Investor Not in user-------------------------------------------------------------
                            $col6 = $rowData[0][12];
                            $investorString = str_replace('"','',$col6);
                            $investorString = explode(",",$investorString);
                        //-------------------------------------------------------------------------------------------//
                            
                            if($rowData[0][13] == 'Foreign'){
                                $investortype = 'F'; 
                            }elseif($rowData[0][13] == 'India-dedicated'){
                                $investortype = 'I'; 
                            }elseif($rowData[0][13] == 'Co-Investment'){
                                $investortype = 'C'; 
                            }elseif($rowData[0][13] == 'Unknown'){
                                $investortype = 'U'; 
                            }

                            $stakepercentage = $rowData[0][14];
                            if(trim($stakepercentage)<=0)
                            {
                                $stakepercentage=0;
                            }
                            
                            /*  if($_POST['chkhidestake'])
                            {
                                $hidestakevalue = 1;
                            }
                            else
                            {
                                $hidestakevalue = 0;
                            }*/
                            
                            $hidestakevalue = 0;
                            
                            $website = $rowData[0][15];

                            $city = $rowData[0][16];

                            $txtregion = $rowData[0][17];
                            $regionId= '';
                            $regionSql = "select RegionId,Region from region where Region='".$txtregion."'";
                            if ($regionrs = mysql_query($regionSql))
                            {
                              $region_cnt = mysql_num_rows($regionrs);
                            }
                            if($region_cnt > 0)
                            {
                                While($myregionrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
                                {
                                    $regionId = $myregionrow[0];
                                }
                            }

                            $Advisor_company = $rowData[0][18];
                            $advisor_companyString = str_replace('"','',$Advisor_company);
                            $advisor_companyString = explode(",",$advisor_companyString);

                            $Advisor_investor = $rowData[0][19];
                            $advisor_investorString = str_replace('"','',$Advisor_investor);
                            $advisor_investorString = explode(",",$advisor_investorString);

                            $comment = $rowData[0][20];
                            $comment = str_replace('"','',$comment);

                            $moreinfor = $rowData[0][21];
                            $moreinfor = str_replace('"','',$moreinfor);

                            $validation = $rowData[0][22];

                            $link = $rowData[0][23];

                            $flagdeletion = 0;
                            $company_valuation = 0;
                            $revenue_multiple = 0;
                            $ebitda_multiple = 0;
                            $pat_multiple = 0;

                            $company_valuation = $rowData[0][24];
                            if($company_valuation == "")
                                $company_valuation = 0;
                            
                            $company_valuation1 = $rowData[0][28];
                            if($company_valuation1 == "")
                                $company_valuation1 = 0;
                            
                            $company_valuation2 = $rowData[0][32];
                            if($company_valuation2 == "")
                                $company_valuation2 = 0;

                            $revenue_multiple = $rowData[0][25];
                            if($revenue_multiple == "")
                                $revenue_multiple = 0;

                            $revenue_multiple1 = $rowData[0][29];
                            if($revenue_multiple1 == "")
                                $revenue_multiple1 = 0;

                            $revenue_multiple2 = $rowData[0][33];
                            if($revenue_multiple2 == "")
                                $revenue_multiple2 = 0;

                            $ebitda_multiple = $rowData[0][26];
                            if($ebitda_multiple == "")
                                $ebitda_multiple = 0;

                            $ebitda_multiple1 = $rowData[0][30];
                            if($ebitda_multiple1 == "")
                                $ebitda_multiple1 = 0;

                            $ebitda_multiple2 = $rowData[0][34];
                            if($ebitda_multiple2 == "")
                                $ebitda_multiple2 = 0;

                            $pat_multiple = $rowData[0][27];
                            if($pat_multiple == "")
                                $pat_multiple = 0;

                            $pat_multiple1 = $rowData[0][31];
                            if($pat_multiple1 == "")
                                $pat_multiple1 = 0;

                            $pat_multiple2 = $rowData[0][35];
                            if($pat_multiple2 == "")
                                $pat_multiple2 = 0;

                            // New feature 08-08-2016 start

                            $price_to_book = $rowData[0][36];
                            if($price_to_book == "")
                                $price_to_book = 0;

                            $valuation = $rowData[0][37];
                            
                            if($rowData[0][37] == 'Yes'){
                                
                                $revenue = floor($rowData[0][24]/$rowData[0][25]);
                                $ebitda = floor($rowData[0][24]/$rowData[0][26]);
                                $pat = floor($rowData[0][24]/$rowData[0][27]);
                                
                            }else{
                                
                                $revenue = $rowData[0][40];
                                if($revenue == "")
                                    $revenue = 0;
                                
                                $ebitda = $rowData[0][41];
                                if($ebitda == "")
                                    $ebitda = 0;
                                
                                $pat = $rowData[0][42];
                                if($pat == "")
                                    $pat = 0;
                            }

                            $financial_year = $rowData[0][39];
                            
                            $txttot_debt = $rowData[0][43];
                            
                            $txtcashequ = $rowData[0][44];
              
                            $book_value_per_share = $rowData[0][45];
                            if($book_value_per_share == "")
                                $book_value_per_share = 0;
                           
                            $price_per_share = $rowData[0][46];
                            if($price_per_share == "")
                                $price_per_share = 0;
                            
                            $finlink = $rowData[0][47];

                            $sourcename = $rowData[0][48];

                            if($rowData[0][49] == 'Yes')
                            { 
                                $hideAggregatetoUpdate=1;
                            }
                            else
                            { 
                                $hideAggregatetoUpdate=0;
                            }

                            if($rowData[0][50] == 'Yes')
                            { 
                                $spvdebt=1;
                            }
                            else
                            { 
                                $spvdebt=0;
                            }

                            $dbtypearray = [];
                          //  $showaspevcarray = [];
                            if($rowData[0][51] == 'Yes')
                            {
                                $dbtypearray[] = 'SV';
                            }
                            if($rowData[0][52] == 'Yes')
                            {
                                $dbtypearray[] = 'IF';
                            }
                            if($rowData[0][53] == 'Yes')
                            {
                                $dbtypearray[] = 'CT';
                            }
                            
                            /*if($rowData[0][52] == 'Yes')
                            {
                                $showaspevcarray[] = 'SV';
                            }*/
                            /*if($rowData[0][54] == 'Yes')
                            {
                                $showaspevcarray[] = 'IF';
                            }
                            if($rowData[0][56] == 'Yes')
                            {
                                $showaspevcarray[] = 'CT';
                            }*/

                  

                            $fullDateAfter=$IPODate;
                            //echo "<br>**" .$fulldate ."--".$fullDateAfter;

                            if (trim($portfoliocompany) !="")
                            {
                                    //echo "<br>-------------------------";
                                    
                                    $companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$txtregion,$regionId);
                                    if($companyId==0)
                                    {
                                        $companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$txtregion,$regionId);
                                    }
                                    // echo $companyId; echo $sectorname;
                                    $sectorId = insert_sector($sectorname,$indid);

                                    if($sectorId==0)
                                    {
                                        $sectorId=insert_sector($sectorname,$indid);
                                    }
                                    
                                    insert_subsector($sectorId,$companyId,$subsectorname,$addsubsectorname);
                                   

                                    //$companyId=0;
                                    //echo "<br>Company id--" .$companyId;
                                    if ($companyId >0)
                                    {
                                        /*echo $pegetInvestmentsql = "select c.PECompanyId,ma.PECompanyId,dates from pecompanies as c,
                                        peinvestments as ma where ma.PECompanyId = c.PECompanyId and   Deleted=0 and
                                        ma.dates = '$fullDateAfter' and c.PECompanyId = $companyId ";
                                        echo '<br>';*/
                                        //echo "<br>checking pe record***" .$pegetInvestmentsql;
                                        //echo "<br>Company id--" .$companyId;
                                        if ($rsInvestment = mysql_query($pegetInvestmentsql))
                                        {
                                                $investment_cnt = mysql_num_rows($rsInvestment);
                                                // echo "<br>Count**********-- " .$investment_cnt ;
                                                }
                                                if($investment_cnt>=0)
                                                {
                                                        if($_POST['hideIPOId']!='' && $_POST['hideIPOId']>0 ){
                                                            $PEId   = $_POST['hideIPOId'];
                                                           }else{
                                                                $PEId= rand();
                                                           }
                                                                //echo "<br>random MandAId--" .$PEId;
                                                                $insertcompanysql="";

                                                                $insertcompanysql= "INSERT INTO peinvestments (PEId,PECompanyId,dates,amount,Amount_INR,round,StageId,stakepercentage,comment,MoreInfor,Validation,InvestorType,Deleted,hideamount,hidestake,SPV,Link,uploadfilename,source,Valuation,FinLink,AggHide,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,Exit_Status,Revenue,EBITDA,PAT,price_to_book,book_value_per_share,price_per_share,Company_Valuation_pre,Company_Valuation_EV,Revenue_Multiple_pre,Revenue_Multiple_EV,EBITDA_Multiple_pre,EBITDA_Multiple_EV,PAT_Multiple_pre,PAT_Multiple_EV,Total_Debt,Cash_Equ,financial_year)VALUES ($PEId,$companyId,'$fullDateAfter','$DealAmount','$amounttoUpdate_INR','$Round','$StageId',$stakepercentage,'$comment','$moreinfor', '$validation','$investortype',$flagdeletion,$hideamount,$hidestakevalue,$spvdebt,'$link','','$sourcename','$valuation','$finlink',$hideAggregatetoUpdate,$company_valuation1,$revenue_multiple1,$ebitda_multiple1,$pat_multiple1,'$listingstatusvalue',$exitstatusvalue,$revenue,$ebitda,$pat,$price_to_book,$book_value_per_share,$price_per_share,'$company_valuation','$company_valuation2','$revenue_multiple','$revenue_multiple2','$ebitda_multiple','$ebitda_multiple2','$pat_multiple','$pat_multiple2','$txttot_debt','$txtcashequ','$financial_year')";

                                                                // echo "<br>@@@@ :".$insertcompanysql; exit;
                                                                if ($rsinsert = mysql_query($insertcompanysql))
                                                                {
                                                                    //echo "<br>Insert PE-" .$insertcompanysql;
                                                                    foreach ($investorString as $inv)
                                                                    {
                                                                        $newInvestor = 0;
                                                                        $leadInvestor = 0;
                                                                        if(trim($inv)!="")
                                                                        {
                                                                            if(strpos(trim($inv), '(L)') !== false){
                                                                                $leadInvestor = 1;
                                                                                $inv = str_replace('(L)', '', trim($inv));
                                                                            } else if(strpos(trim($inv), '(N)') !== false) {
                                                                                $newInvestor = 1;
                                                                                $inv = str_replace('(N)', '', trim($inv));
                                                                            }

                                                                            $investorIdtoInsert=return_insert_get_Investor(trim($inv));

                                                                            if($investorIdtoInsert==0)
                                                                            {
                                                                                    $investorIdtoInsert= return_insert_get_Investor(trim($inv));
                                                                            }
                                                                            $insDeal_investors= insert_Investment_Investors($PEId,$investorIdtoInsert,$leadInvestor,$newInvestor);

                                                                        }
                                                                    }

                                                                    foreach($advisor_companyString as $advisorcompany)
                                                                    {
                                                                        if(trim($advisorcompany)!="")
                                                                        {
                                                                            $CIAIdtoInsert=insert_get_CIAs(trim($advisorcompany));
                                                                            if($CIAIdtoInsert==0)
                                                                            {
                                                                                    $CIAIdtoInsert= insert_get_CIAs(trim($advisorcompany));
                                                                            }
                                                                            $insDeal_Advisorcompany= insert_Investment_AdvisorCompany($PEId,$CIAIdtoInsert);

                                                                        }
                                                                    }

                                                                    foreach($advisor_investorString as $advisorinvestor)
                                                                    {
                                                                        if(trim($advisorinvestor)!="")
                                                                        {
                                                                            $CIAIdtoInsert=insert_get_CIAs(trim($advisorinvestor));
                                                                            if($CIAIdtoInsert==0)
                                                                            {
                                                                                $CIAIdtoInsert= insert_get_CIAs(trim($advisorinvestor));
                                                                            }
                                                                            $insDeal_Advisorcompany= insert_Investment_AdvisorInvestors($PEId,$CIAIdtoInsert);

                                                                        }
                                                                    }

                                                                   /* for ( $i =0; $i < count($dbtypearray); $i +=1)
                                                                    {
                                                                        if(in_array($dbtypearray[$i],$showaspevcarray)==false)
                                                                        {  // echo "<Br>1 " .$dbtypearray[$i];
                                                                           echo  $insertTypesql="insert into peinvestments_dbtypes values($PEId,'$dbtypearray[$i]',1)";
                                                                        }
                                                                        else
                                                                        {  
                                                                           //echo "<br>0 " .$dbtypearray[$i];    }
                                                                            echo $insertTypesql="insert into peinvestments_dbtypes values($PEId,'$dbtypearray[$i]',0)";
                                                                        }
                                                                        echo "<bR>***".$insertTypesql;
                                                                        if($rsupdateType = mysql_query($insertTypesql))
                                                                        {
                                                                        }
                                                                    }*/
                                                                   /* 
                                                                    for ( $i =0; $i < count($dbtypearray); $i +=1)
                                                                    {
                                                                        
                                                                        if(in_array($dbtypearray[$i],$showaspevcarray)==true)
                                                                        {  // echo "<Br>1 " .$dbtypearray[$i];
                                                                            $insertTypesql="insert into peinvestments_dbtypes values($PEId,'$dbtypearray[$i]',1)";
                                                                        }
                                                                        else
                                                                        {  
                                                                           //echo "<br>0 " .$dbtypearray[$i];    }
                                                                            $insertTypesql="insert into peinvestments_dbtypes values($PEId,'$dbtypearray[$i]',0)";
                                                                        }
                                                                        echo "<bR>***".$insertTypesql;
                                                                        if($rsupdateType = mysql_query($insertTypesql))
                                                                        {
                                                                        }
                                                                    }*/
                                                                     for ( $i =0; $i < count($dbtypearray); $i +=1){
                                                                            $insertTypesql1="insert into peinvestments_dbtypes values($PEId,'$dbtypearray[$i]',0)";
                                                                            // echo "<bR>***".$insertTypesql1;
                                                                            if($rsupdateType = mysql_query($insertTypesql1))
                                                                            {
                                                                            }
                                                                       }
                                                                      /* for ( $i =0; $i < count($showaspevcarray); $i +=1){
                                                                            if($showaspevcarray[$i]!="")
                                                                            {
                                                                                $showvalue=1;
                                                                            }
                                                                            else{
                                                                                $showvalue=0;
                                                                            }
                                                                            $insertTypesql2="insert into peinvestments_dbtypes values($PEId,'$showaspevcarray[$i]','$showvalue')";
                                                                             //echo "<bR>***".$insertTypesql2;
                                                                            if($rsupdateType = mysql_query($insertTypesql2))
                                                                            {
                                                                            }
                                                                        }*/

                                                                $datedisplay =  $fullDateAfter; //(date("Y F", $fullDateAfter));
                                                        ?>
                                                        <!-- <Br>
                                                        <tr bgcolor="#00CC66"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $PEId. " : " .$datedisplay . " - " .$portfoliocompany ; ?>&nbsp;  Inserted</td> </tr> -->
                                                        <?php
                                                        }
                                                        else
                                                        {
                                                        ?>
                                                        <tr bgcolor="red"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; --> Insert failed</td> </tr>
                                                        <?php
                                                        }
                                        //	echo "<br> insert-".$insertcompanysql;
                                        }
                                        //elseif($investment_cnt>= 1)
                                        //{
                                        ?>
                                            <!-- <tr bgcolor="C0C0C0"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php //echo $portfoliocompany; ?>&nbsp; PE Deal already exists</td> </tr> -->
                                        <?php
                                        //}
								}//if companyid >0 loop ends
                                }else{ ?>
                                
                                    <br>   <tr bgcolor="C0C0C0"> <td colspan=2 width=20% style="font-family: Verdana; font-size: 8pt">Not found any company name in excel. Please check.<a href="admin.php">Back to Home</a></td></tr> 
                <?php      }
                    }
                ?>
                      <!-- <tr bgcolor="C0C0C0"> <td colspan=2 width=20% ><p style="font-size: 18pt;text-align: center;color: green;font-weight: 600;">Successfully Added <?php echo $rowcount - 1; ?> Records</p></td></tr>                         -->
                    <br><tr bgcolor="C0C0C0"> <td colspan=2 width=20% style="font-family: Verdana; font-size: 8pt"><a href="admin.php">Back to Home</a></td></tr>            
                                            
                <?php                       
               }
               else{

                  ?> <br>   <tr bgcolor="C0C0C0"> <td colspan=2 width=20% style="font-family: Verdana; font-size: 8pt">Please upload an XLSX <a href="uploaddeals.php">Back to Upload</a></td></tr>
                  <?php
                  }
            }
            else{
                    echo $_FILES['mamadealsfilepath']['error'];
            }
        }
    }
}
    

        function returnDate($mth,$yr)
        {
            //this function returns the date
           $fulldate= $yr ."-" .date("m", strtotime($mth)) ."-01";

            if (checkdate (date("m", strtotime($mth)), 01, $yr))
            {
                return date('Y-m-d',  strtotime($fulldate));
            }

        }
 
        /* function to insert the companies and return the company id if exists */
        function insert_company($companyname,$industryId,$sector,$web,$city,$region,$regionId)
        {
            $dbpecomp = new dbInvestments();
            $getPECompanySql = "select PECompanyId,industry,sector_business,RegionId,city from pecompanies where companyname= '$companyname'";
            //echo "<br>select--" .$getPECompanySql;

            
            if ($rsgetPECompanyId = mysql_query($getPECompanySql))
            {
                $pecomp_cnt=mysql_num_rows($rsgetPECompanyId);
                //echo "<br>%%%%%".$pecomp_cnt;
                if ($pecomp_cnt==0)
                {
                    //insert pecompanies
                    $insPECompanySql="insert into pecompanies(companyname,industry,sector_business,website,city,AdCity,region,RegionId)
                    values('$companyname',$industryId,'$sector','$web','$city','$city','$region',$regionId)";
                   // echo "<br>Ins company sql=" .$insPECompanySql;
                    if($rsInsPECompany = mysql_query($insPECompanySql))
                    {
                        $companyId=0;
                        return $companyId;
                    }
                }
                elseif($pecomp_cnt>=1)
                {
                    While($myrow=mysql_fetch_array($rsgetPECompanyId, MYSQL_BOTH))
                    {
                        $companyId = $myrow[0];

                        $rsgetPECompanyId = mysql_query($getPECompanySql);
                        $seperate_field = mysql_fetch_assoc($rsgetPECompanyId);



                    // echo '<pre>'; print_r($seperate_field); echo '</pre>'; 
                    // echo 'Industry__'.$industryId.'<br />';
                    // echo 'City__'.$city.'<br />';
                    // echo 'Sector__'.$sector.'<br />';
                    // echo 'Region__'.$regionId.'<br />';
                    //  exit;


                        if($seperate_field['city'] == $city && $seperate_field['sector_business'] == $sector && $seperate_field['industry'] == $industryId && $seperate_field['RegionId'] == $regionId)
                        {
                            
                            $updateCityCountrySql="Update pecompanies set industry='$industryId',sector_business='$sector',website='$web',city='$city',AdCity='$city',RegionId=$regionId,region='$region' where PECompanyId=$companyId";

                            echo 'Successfully Added';
                                
                            if($rscityCountrySql=mysql_query($updateCityCountrySql))
                            {
                                //		echo "<br>Update Company- " .$updateCityCountrySql;
                            }
                                //echo "<br>Insert return industry id--" .$companyId;
                            return $companyId;

                        }else{
                          echo "Mismatch Records";
                        }

                        // exit;
                        
                    }
                }
                //echo "<br>----****".$companyId;
            }
            $dbpecomp.close();
        }

        /*sector and subsector*/

         function insert_sector($sector,$indid){
            
            $sector=trim($sector);
            $dbslinkss = new dbInvestments();
            $getsectorIdSql="select sector_id from pe_sectors where sector_name='$sector' AND industry=$indid";
            
            if($rsgetsector=mysql_query($getsectorIdSql))
            {
                $sector_cnt=mysql_num_rows($rsgetsector);
               
                if($sector_cnt==0)
                {
                    //insert deal ..mostly it wont get inserted as new..only standard 9 stages already exists
                    $inssectorIdSql ="insert into pe_sectors(sector_name,industry) values('$sector',$indid)";
                    if($rsInsSector = mysql_query($inssectorIdSql))
                    {
                        $sectorId=0;
                        return $sectorId;
                    }
                }
                elseif($sector_cnt>=1)
                {
                    While($myrow=mysql_fetch_array($rsgetsector, MYSQL_BOTH))
                    {
                        $sectorId = $myrow[0];
                        //echo "<br>Insert return investor id--" .$invId;
                        return $sectorId;
                    }
                }
            }
            $dbslinkss.close();
        
        }

        function insert_subsector($sectorId,$companyId,$subsectorname,$addsubsectorname){
            
            // $subsectorname=trim($subsectorname);

            // $dbslinkss = new dbInvestments();
            // $getsubsectorsSql="insert into pe_subsectors(sector_id,PECompanyId,subsector_name,Additional_subsector) values($sectorId,$companyId,'$subsectorname','$addsubsectorname')";
            
            // if($rsInssubsectors = mysql_query($getsubsectorsSql))
            // {
            //     return true;
            // }
            // $dbslinkss.close();

            $subsectorname=trim($subsectorname);
            $dbslinkss = new dbInvestments();
            $getsectorIdSql="select subsector_id from pe_subsectors where subsector_name='$subsectorname' AND sector_id=$sectorId AND PECompanyId=$companyId";
            
            if($rsgetsector=mysql_query($getsectorIdSql))
            {
                $sector_cnt=mysql_num_rows($rsgetsector);
               
                if($sector_cnt==0)
                {
                    //insert deal ..mostly it wont get inserted as new..only standard 9 stages already exists
                    $inssectorIdSql ="insert into pe_subsectors(sector_id,PECompanyId,subsector_name,Additional_subsector) values($sectorId,$companyId,'$subsectorname','$addsubsectorname')";
                    if($rsInsSector = mysql_query($inssectorIdSql))
                    {
                        return true;
                    }
                }
                elseif($sector_cnt>=1)
                {
                    While($myrow=mysql_fetch_array($rsgetsector, MYSQL_BOTH))
                    {
                        return true;
                    }
                }
            }
            $dbslinkss.close();
        
        }






        /* inserts and returns the StageId  */
	function returnStageId($stage)
	{
		$stage=trim($stage);
		$dbslinkss = new dbInvestments();
		$getDealIdSql="select StageId from stage where Stage='$stage'";
	//	echo "<Br>DealSql--" .$getDealIdSql;
		if($rsgetAcquirer=mysql_query($getDealIdSql))
		{
			$dealtype_cnt=mysql_num_rows($rsgetAcquirer);
			if($dealtype_cnt==0)
			{
				//insert deal ..mostly it wont get inserted as new..only standard 9 stages already exists
				$insAcquirerSql="insert into stage(Stage) values('$stage')";
				if($rsInsAcquirer = mysql_query($insAcquirerSql))
				{
					$stageId=0;
					return stageId;
				}
			}
			elseif($dealtype_cnt==1)
			{
				While($myrow=mysql_fetch_array($rsgetAcquirer, MYSQL_BOTH))
				{
					$stageId = $myrow[0];
					//echo "<br>Insert return investor id--" .$invId;
					return $stageId;
				}
			}
		}
		$dbslinkss.close();
	}

        /* function to insert the advisor_cias table */
        function insert_get_CIAs($cianame)
        {
                $dblink = new dbInvestments();
                $cianame=trim($cianame);
                $getInvestorIdSql = "select CIAId from advisor_cias where cianame like '$cianame'";
                //echo "<br>select--" .$getInvestorIdSql;
                if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
                {
                        $investor_cnt=mysql_num_rows($rsgetInvestorId);
                        //echo "<br>Investor count-- " .$investor_cnt;
                        if ($investor_cnt==0)
                        {
                                        //insert acquirer
                                        $insAcquirerSql="insert into advisor_cias(cianame) values('$cianame')";
                                        if($rsInsAcquirer = mysql_query($insAcquirerSql))
                                        {
                                                $ciaInvestorId=0;
                                                return $ciaInvestorId;
                                        }
                        }
                        elseif($investor_cnt>=1)
                        {
                                While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
                                {
                                        $ciaInvestorId = $myrow[0];
                                //	echo "<br>Insert return investor id--" .$invId;
                                        return $ciaInvestorId;
                                }
                        }
                }
                $dblink.closeDB();

        }

        // the following function inserts advisor_PEIds in the peinvestments_advisor table
	function insert_Investment_AdvisorInvestors($dealId,$ciaid)
	{
		$DbAdvInv = new dbInvestments();
		$getDealInvSql="Select PEId,CIAId from peinvestments_advisorinvestors where PEId=$dealId and CIAId=$ciaid";

		//echo "<br>@@@@@@--" .$getDealInvSql;
		if($rsgetdealinvestor = mysql_query($getDealInvSql))
		{
			$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
			if($deal_invcnt==0)
			{
				$insDealInvSql="insert into peinvestments_advisorinvestors values($dealId,$ciaid)";
				if($rsinsdealinvestor = mysql_query($insDealInvSql))
				{
				//	echo "<bR>---Advisor Investors ";
                                        return true;
				}
			}
		}
		$DbAdvInv.closeDB();
}

        // the following function inserts advisor_PEIds in the peinvestments_advisor table
	function insert_Investment_AdvisorCompany($dealId,$ciaid)
	{
		$DbAdvComp= new dbInvestments();
		$getDealInvSql="Select PEId,CIAId from peinvestments_advisorcompanies where PEId=$dealId and CIAId=$ciaid";

		//echo "<br>@@@@@@--" .$getDealInvSql;
		if($rsgetdealinvestor = mysql_query($getDealInvSql))
		{
			$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
			if($deal_invcnt==0)
			{
				$insDealInvSql="insert into peinvestments_advisorcompanies values($dealId,$ciaid)";
				if($rsinsdealinvestor = mysql_query($insDealInvSql))
				{
				//	echo "<br>---Advisor Companies ";
					return true;
				}
			}
		}
		$DbAdvComp.closeDB();
        }


        /* inserts and return the investor id */
	function return_insert_get_Investor($investor)
	{
		$dblink= new dbInvestments();
		$investor=trim($investor);
		$getInvestorIdSql = "select InvestorId from peinvestors where Investor like '$investor%'";
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
						$InvestorId=0;
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
		//$dblink.close();
		$dblink.closeDB();
		//mysql_close($dblink);
	}


	// the following function inserts investor and the peid in the peinvestments_investors table
	function insert_Investment_Investors($dealId,$investorId,$leadInvestor,$newInvestor)
    {
        $DbInvestInv = new dbInvestments();
        //$dbslink = mysqli_connect("ventureintelligence.ipowermysql.com", "root",  "", "peinvestmentdeals");
        $getDealInvSql="Select PEId,InvestorId from peinvestments_investors where PEId=$dealId and InvestorId=$investorId";

        //echo "<br>@@@@@@--" .$getDealInvSql;
        if($rsgetdealinvestor = mysql_query($getDealInvSql))
        {
            $deal_invcnt=mysql_num_rows($rsgetdealinvestor);
            if($deal_invcnt==0)
            {
                $insDealInvSql="insert into peinvestments_investors (PEId,InvestorId,leadinvestor,newinvestor) values($dealId,$investorId,$leadInvestor,$newInvestor)";
                
                if($rsinsdealinvestor = mysql_query($insDealInvSql))
                {
                                 // echo "<br> Insert into investments_investors ";
                    return true;
                }
            }
        }
        $DbInvestInv.closeDB();
        }
?>
<script type="text/javascript">
    setTimeout(function () {
       window.location.href= '<?php echo GLOBAL_BASE_URL; ?>/adminvi/uploaddeals.php'; // the redirect goes here

    },3000);
</script>
