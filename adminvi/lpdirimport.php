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
        
        if(isset($_FILES['lpdirfilepath'])){


            
            if($_FILES['lpdirfilepath']['tmp_name']){
               
                if(!$_FILES['lpdirfilepath']['error'])
                {
                    
                    $inputFile = $_FILES['lpdirfilepath']['tmp_name'];
                    $inputFilename = $_FILES['lpdirfilepath']['name'];
                    
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
                           /* echo '<pre>';
                            print_r($rowData);
                            echo '</pre>';*/
                            $institution = $rowData[0][0];
                            $contactperson = $rowData[0][1];
                            $designation = $rowData[0][2];
                            $email = $rowData[0][3];
                            $address1 = $rowData[0][4];
                            $address2 = $rowData[0][5];
                            $city = $rowData[0][6];
                            $pincode = $rowData[0][7];
                            $country = $rowData[0][8];
                            $phone = $rowData[0][9];
                            $fax = $rowData[0][10];
                            $website = $rowData[0][11];
                            $typeofinstitution = $rowData[0][12];
                                                        
                            
                            $institution=trim($institution);
                            $contactperson =trim($contactperson);
                            $address1 =trim($address1);  
                            $address2 = trim($address2);
                            /*if (trim($portfoliocompany) !="")
                            {*/
                                    //echo "<br>-------------------------";
                                    
                                   
                                    //$companyId=0;
                                    //echo "<br>Company id--" .$companyId;
                                    
                                        // echo $pegetInvestmentsql = "select c.PECompanyId,ma.PECompanyId,dates from pecompanies as c,
                                        // peinvestments as ma where ma.PECompanyId = c.PECompanyId and   Deleted=0 and
                                        // ma.dates = '$fullDateAfter' and c.PECompanyId = $companyId ";
                                        // echo '<br>';
                                        //echo "<br>checking pe record***" .$pegetInvestmentsql;
                                        //echo "<br>Company id--" .$companyId;
                                       
                                              

                                                               $insertcompanysql= "INSERT INTO limited_partners (InstitutionName,ContactPerson,Designation,Email,Address1,Address2,City,PinCode,Country,Phone,Fax,Website,TypeOfInstitution)
                                            VALUES ('".addslashes($institution)."','".addslashes($contactperson)."','$designation','$email','".addslashes($address1)."','".addslashes($address2)."','$city', '$pincode','$country','$phone','$fax','$website','$typeofinstitution')";

                                                                //echo "<br>@@@@ :".$insertcompanysql;
                                                                if ($rsinsert = mysql_query($insertcompanysql))
                                                                {
                                                                 //   echo "<br>Insert PE-" .$insertcompanysql;
                                                                   

                                                                   
                                                       
                                                        }
                                                        else
                                                        {
                                                        ?>
                                                        <tr bgcolor="red"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; --> Insert failed</td> </tr>
                                                        <?php
                                                        }
                                        //  echo "<br> insert-".$insertcompanysql;
                                        
                                        //elseif($investment_cnt>= 1)
                                        //{
                                        ?>
                                            <!-- <tr bgcolor="C0C0C0"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php //echo $portfoliocompany; ?>&nbsp; PE Deal already exists</td> </tr> -->
                                       
                                        
                               
                <?php      
                    }
                ?>
                    <tr bgcolor="C0C0C0"> <td colspan=2 width=20% ><p style="font-size: 18pt;text-align: center;color: green;font-weight: 600;">Successfully Added <?php echo $rowcount - 1; ?> Records</p></td></tr> 
                    <tr bgcolor="C0C0C0"> <td colspan=2 width=20% style="font-family: Verdana; font-size: 8pt"><a href="admin.php">Back to Home</a></td></tr>            
                             <?php //header( "refresh:3;url=uploaddeals.php" );//header("Location: uploaddeals.php"); ?>                
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
                            
                        if($rscityCountrySql=mysql_query($updateCityCountrySql))
                        {
                //      echo "<br>Update Company- " .$updateCityCountrySql;
                        }
                        //echo "<br>Insert return industry id--" .$companyId;
                        return $companyId;
                    }
                }
                //echo "<br>----****".$companyId;
            }
            $dbpecomp.close();
        }


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
                elseif($sector_cnt==1)
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
                elseif($sector_cnt==1)
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
    //  echo "<Br>DealSql--" .$getDealIdSql;
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
                                //  echo "<br>Insert return investor id--" .$invId;
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
                //  echo "<bR>---Advisor Investors ";
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
                //  echo "<br>---Advisor Companies ";
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
       // echo "<br>select--" .$getInvestorIdSql;
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
                //  echo "<br>Insert return investor id--" .$InvestorId;
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
       window.location.href= '<?php echo GLOBAL_BASE_URL; ?>adminvi/uploaddeals.php'; // the redirect goes here

    },3000);
</script>