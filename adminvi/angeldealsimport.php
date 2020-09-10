<?php

    include_once('../PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php');
    
    require("../dbconnectvi.php");  
    $Db = new dbInvestments();
    //session_save_path("/tmp");
    session_start();
    if (session_is_registered("SessLoggedAdminPwd"))
    {
//        echo "dddddddddddddddddddddddddddd";
//        print_r( $filename  = $_FILES['angeldealsfilepath']['tmp_name']);
//        exit();
        
        if(isset($_FILES['angeldealsfilepath'])){
            
            if($_FILES['angeldealsfilepath']['tmp_name']){
               
                if(!$_FILES['angeldealsfilepath']['error'])
                {
                    
                    $inputFile = $_FILES['angeldealsfilepath']['tmp_name'];
                    $inputFilename = $_FILES['angeldealsfilepath']['name'];
                    
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
                                    
                        <?  
                      
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
                        $highestColumn = 'Q';
                        $rowData = array();
                        //Loop through each row of the worksheet in turn
                        for ($row = 2; $row <= $highestRow; $row++){ 
                                //  Read a row of data into an array
                            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, "", TRUE, TRUE);
                            /*echo '<pre>';
                                 print_r($rowData);
                            echo '</pre>';*/
                            $portfoliocompany = $rowData[0][0];//$_POST['txtcompanyname'];
                            
                            $industry_name = $rowData[0][1];
                            $industrysql = "select industryid,industry from industry where industryid !=15 and industry='".trim($industry_name)."'order by industry";
                            $industryid = 0;
                            if ($industryrs = mysql_query($industrysql))
                            {
                                $ind_cnt = mysql_num_rows($industryrs);
                            }
                            if($ind_cnt>0)
                            {
                                $myrow = mysql_fetch_row($industryrs, MYSQL_BOTH);

                                $indid = $myrow['industryid'];
                                mysql_free_result($industryrs);
                            }else{
                                $indid = '';
                            }
                            
                            $sector = $rowData[0][2];

                            $col6 = $rowData[0][3];
                            $investorString=str_replace('"','',$col6);
                            $investorString=explode(",",$investorString);
                            
                            $monthtoAdd = $rowData[0][4]; 
                            $yeartoAdd = $rowData[0][5];
                            $IPODate=returnDate($monthtoAdd,$yeartoAdd);
                           
                            if($rowData[0][6]=='Yes')
                            {
                                $multipleround=1;
                            }
                            else
                            {
                                $multipleround=0;
                            }
                            
                            if($rowData[0][7]=='Yes')
                            {
                                $followonfund=1;
                            }
                            else
                            {
                                $followonfund=0;
                            }
                            
                            if($rowData[0][8]=='Yes')
                            {
                                $exitedvalue=1;
                            }
                            else
                            {
                                $exitedvalue=0;
                            }
                            
                            $website = $rowData[0][9];
                            $city = $rowData[0][10];
                           
                            $txtregion = $rowData[0][11]; //$_POST['txtregion'];
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
                            //$regionId = return_insert_get_RegionId($regionId);
                            
                            $comment = $rowData[0][12];
                            $comment=str_replace('"','',$comment);
                            
                            $moreinfor = $rowData[0][13];
                            $moreinfor=str_replace('"','',$moreinfor);
                            
                            $validation = $rowData[0][14];
                            
                            $link = $rowData[0][15];
                            
                            if($rowData[0][16]=='Yes')
                            {
                                    
                                $hideAggregatetoUpdate=1;
                            }
                            else
                            {   
                                $hideAggregatetoUpdate=0;
                            
                            }
                            
                            $fullDateAfter=$IPODate;
                            
                            if (trim($portfoliocompany) !="")
                            {

                                $companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$txtregion,$regionId);
                                //echo "<bR>####---------------------";
                                if($companyId==0)
                                {
                                    $companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$txtregion,$regionId);
                                    echo "<bR>CompanyInserted".$companyId;
                                }
                                
                                if ($companyId > 0 )
                                {
                                    $pegetInvestmentsql = "select c.PECompanyId,ma.InvesteeId,DealDate from pecompanies as c,
                                    angelinvdeals as ma where ma.InvesteeId = c.PECompanyId and ma.DealDate = '$fullDateAfter' and c.PECompanyId = $companyId ";

                                    //echo "<br>checking pe record***" .$pegetInvestmentsql;
                                    //echo "<br>Company id--" .$companyId;
                                    if ($rsInvestment = mysql_query($pegetInvestmentsql))
                                    {
                                        $investment_cnt = mysql_num_rows($rsInvestment);
                                        // echo "<br>Count**********-- " .$investment_cnt ;
                                    }
                                    if($investment_cnt>=0)
                                    {
                                        $PEId= rand();
                                        //echo "<br>random MandAId--" .$PEId;
                                        $insertcompanysql="";
                                        $insertcompanysql= "INSERT INTO angelinvdeals (AngelDealId,InvesteeId,DealDate,MultipleRound,FollowonVCFund,Exited,Comment,MoreInfor,Validation,Link,AggHide)
                                        VALUES ($PEId,$companyId,'$fullDateAfter',$multipleround,$followonfund,$exitedvalue,'$comment','$moreinfor', '$validation','$link',$hideAggregatetoUpdate)";

                                        if ($rsinsert = mysql_query($insertcompanysql))
                                        {
                                            //echo "<br>Insert angel Inv-" .$insertcompanysql;
                                            //print_r($investorString);
                                            foreach ($investorString as $inv)
                                            {
                                                //echo "<br>~~~~~~~~~~~~~~~~~~~~".$inv;
                                                if(trim($inv)!="")
                                                {
                                                    $investorIdtoInsert=return_insert_get_Investor(trim($inv));
                                                    //echo "<br>***".$investorIdtoInsert;
                                                    if($investorIdtoInsert==0)
                                                    {
                                                        $investorIdtoInsert= return_insert_get_Investor(trim($inv));
                                                    }
                                                    $insDeal_investors= insert_Investment_Investors($PEId,$investorIdtoInsert);
                                                }
                                            }

                                            $datedisplay =  $fullDateAfter; //(date("Y F", $fullDateAfter));
                                        ?>
                                        <Br>
                                        <tr bgcolor="#00CC66"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $datedisplay . " - " .$portfoliocompany ; ?>&nbsp; --> Angel Deal Inserted</td> </tr>
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
                                    // elseif($investment_cnt>= 1)
                                    // {
                                    ?>
                                    <!-- <tr bgcolor="C0C0C0"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; Angel Deal already exists</td> </tr><br> -->
                                    <?php
                                    // }
                                }//if companyid >0 loop ends
                            }else{ ?>
                                
                                    <br>   <tr bgcolor="C0C0C0"> <td colspan=2 width=20% style="font-family: Verdana; font-size: 8pt">Not found any company name in excel. Please check.<a href="admin.php">Back to Home</a></td></tr> 
                <?php      }
                    }
                ?>
                                            
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
    
    
    
    //function to get RegionId
    function return_insert_get_RegionId($regionid)
    {
        $dbregionlink = new dbInvestments();
        $getRegionIdSql = "select Region from region where RegionId=$regionid";
        if ($rsgetInvestorId = mysql_query($getRegionIdSql))
        {
            $regioncnt=mysql_num_rows($rsgetInvestorId);
            //echo "<br>Investor count-- " .$investor_cnt;

            if($regioncnt==1)
            {
                While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
                {
                    $regionId = $myrow[0];
                    //echo "<br>Insert return investor id--" .$invId;
                    return $regionId;
                }
            }
        }
        $dbregionlink.close();
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
    /* function to insert the companies and return the company id if exists */
    function insert_company($companyname,$industryId,$sector,$web,$city,$region,$regionId)
    {
        $dbpecomp = new dbInvestments();
        $getPECompanySql = "select PECompanyId from pecompanies where companyname= '$companyname'";
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
                    $updateCityCountrySql="Update pecompanies set industry='$industryId',sector_business='$sector',website='$web',city='$city',AdCity='$city',RegionId=$regionId,region='$region' where PECompanyId=$companyId";
                    //echo "<br>Insert return industry id--" .$companyId;
                    if($rscityCountrySql=mysql_query($updateCityCountrySql))
                    {
                        //echo "<br>Update Company- " .$updateCityCountrySql;
                    }
                    //echo "<br>Insert return industry id--" .$companyId;
                    return $companyId;
                }
            }
            //echo "<br>----****".$companyId;
        }
        $dbpecomp.close();
    }

    //function to insert investors
    function return_insert_get_incubator($incubatorname)
    {
        $incubator=trim($incubatorname);
        $incubator=ltrim($incubatorname);
        $incubator=rtrim($incubatorname);
        $dblink = new dbInvestments();
        $getInvestorIdSql = "select IncubatorId from incubators where Incubator like '$incubator'";
        //	echo "<br>select--" .$getInvestorIdSql;
        if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
        {
            $investor_cnt=mysql_num_rows($rsgetInvestorId);
            if ($investor_cnt==0)
            {
                //echo "<br>----insert Investor ";
                $insAcquirerSql="insert into incubators(Incubator) values('$incubatorname')";
                if($rsInsAcquirer = mysql_query($insAcquirerSql))
                {
                    $IncubatorId=0;
                    return $IncubatorId;
                }
            }
            elseif($investor_cnt>=1)
            {
                While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
                {
                    $IncubatorId = $myrow[0];
                    //echo "<br>Insert return investor id--" .$IncubatorId;
                    return $IncubatorId;
                }
            }
        }
        $dblink.close();
    }
    
    /* function to insert the advisor_cias table */
    function insert_get_CIAs($cianame)
    {
        $dblink = new dbInvestments();
        $cianame=trim($cianame);
        $getInvestorIdSql = "select CIAId from advisor_cias where cianame= '$cianame'";
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
        $dblink.close();

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
                        return true;
                }
            }
        }
        $DbAdvInv.close();
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
                        //echo "<br>---".$insDealInvSql;
                        return true;
                    }
            }
        }
        $DbAdvComp.close();
    }


    /* inserts and return the investor id */
    function return_insert_get_Investor($investor)
    {
        $dblink= new dbInvestments();
        $investor=trim($investor);
        $getInvestorIdSql = "select InvestorId from peinvestors where Investor= '$investor'";
        //echo "<br>select--" .$getInvestorIdSql;
        if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
        {
            $investor_cnt=mysql_num_rows($rsgetInvestorId);
            //echo "<br>Investor count-- " .$investor_cnt;
            if ($investor_cnt==0)
            {
                //insert acquirer
                $insAcquirerSql="insert into peinvestors(Investor) values('$investor')";
                //echo $insAcquirerSql;
                if($rsInsAcquirer = mysql_query($insAcquirerSql))
                {
                        $InvestorId=0;
                        return $InvestorId;
                }
            }
            elseif($investor_cnt==1)
            {
                While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
                {
                        $InvestorId = $myrow[0];
                        //	echo "<br>Insert return investor id--" .$InvestorId;
                        return $InvestorId;
                }
            }else{
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


    // the following function inserts investor and the peid in the peinvestments_investors table
    function insert_Investment_Investors($dealId,$investorId)
    {
        $DbInvestInv = new dbInvestments();
        //$dbslink = mysqli_connect("ventureintelligence.ipowermysql.com", "root",  "", "peinvestmentdeals");
        $getDealInvSql="Select AngelDealId,InvestorId from angel_investors where AngelDealId=$dealId and InvestorId=$investorId";
        //echo "<br>@@^^^^@@@@--" .$getDealInvSql;
        if($rsgetdealinvestor = mysql_query($getDealInvSql))
        {
            $deal_invcnt=mysql_num_rows($rsgetdealinvestor);
            if($deal_invcnt==0)
            {
                $insDealInvSql="insert into angel_investors values($dealId,$investorId)";
                if($rsinsdealinvestor = mysql_query($insDealInvSql))
                {
                        return true;
                }
            }
        }
        $DbInvestInv.close();
    }
?>
