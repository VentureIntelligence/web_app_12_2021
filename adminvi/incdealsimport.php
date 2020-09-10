<?php

    include_once('../PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php');
    
    require("../dbconnectvi.php");  
    $Db = new dbInvestments();
    //session_save_path("/tmp");
    session_start();
    if (session_is_registered("SessLoggedAdminPwd"))
    {
//        echo "dddddddddddddddddddddddddddd";
//        print_r( $filename  = $_FILES['incdealsfilepath']['tmp_name']);
//        exit();
        
        if(isset($_FILES['incdealsfilepath'])){
            
            if($_FILES['incdealsfilepath']['tmp_name']){
               
                if(!$_FILES['incdealsfilepath']['error'])
                {
                    
                    $inputFile = $_FILES['incdealsfilepath']['tmp_name'];
                    $inputFilename = $_FILES['incdealsfilepath']['name'];
                    
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
                        $highestColumn = 'O';
                        
                        
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
                            $incubatorId=return_insert_get_incubator($investorString);
                            if($incubatorId==0)
                            { 
                                $incubatorId= return_insert_get_incubator($investorString); 
                                
                            }
                            
                            if($rowData[0][4]=='Yes')
                            {
                                $followonfund=1;
                            }
                            else
                            {
                                $followonfund=0;
                            }
                            
                            $yearfounded=0;
                            
                            $mthtoUpdate = date('m',strtotime($rowData[0][5]));
                            $YrtoUpdate=$rowData[0][6];
                            if(($mthtoUpdate=="") && ($YrtoUpdate==""))
                                $fulldate="0000-00-00";
                            else
                                $fulldate= $YrtoUpdate."-".$mthtoUpdate."-01";
                            
                            $website = $rowData[0][7];
                            $city = $rowData[0][8];
                           
                            $txtregion = $rowData[0][9]; //$_POST['txtregion'];
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
                            
                            $comment = $rowData[0][10];
                            $comment=str_replace('"','',$comment);
                            
                            $moreinfor = $rowData[0][11];
                            $moreinfor=str_replace('"','',$moreinfor);
                            
                            $status = $rowData[0][12];
                            $statusid = '';
                            $stageSql = "select StatusId,Status from incstatus where Status='".$status."'";
                            if ($rsStage = mysql_query( $stageSql))
                            {
                                $stage_cnt = mysql_num_rows($rsStage);
                            }
                            if($stage_cnt > 0)
                            {
                                While($myrow=mysql_fetch_array($rsStage, MYSQL_BOTH))
                                {
                                    $statusid = $myrow[0];
                                }
                                mysql_free_result($rsStage);
                            }

                            
                             if($rowData[0][13]=='Yes')
                            {
                                    
                                $defunctflag=1;
                            }
                            else
                            {   
                                $defunctflag=0;
                            
                            }
                            
                            if($rowData[0][14]=='Yes')
                            {
                                    
                                $indiflag=1;
                            }
                            else
                            {
                                $indiflag=0;
                            }
                            
                            
                            if (trim($portfoliocompany) !="")
                            {
                                $companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$txtregion,$regionId);
                                        //echo "<bR>####---------------------";
                                if($companyId==0)
                                {
                                    $companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$txtregion,$regionId);
                                }
                               // $companyId=0;
                                //echo "<br>Company id--" .$companyId;
                                if ($companyId >0)
                                {
                                    $pegetInvestmentsql= "select IncubateeId from incubatordeals where IncubateeId=$companyId  and Deleted=0";

                                    //echo "<br>checking pe record***" .$pegetInvestmentsql;
                                    //echo "<br>Company id--" .$companyId;
                                    if ($rsInvestment = mysql_query($pegetInvestmentsql))
                                    {
                                       $investment_cnt = mysql_num_rows($rsInvestment);
                                    // echo "<br>Count**********-- " .$investment_cnt ;
                                    }
                                    if($investment_cnt>=0)
                                    {
                                        $IncDealId= rand();
                                        //echo "<br>random MandAId--" .$PEId;
                                       $insertcompanysql="INSERT INTO incubatordeals (IncDealId,IncubateeId,IncubatorId,Comment,MoreInfor,StatusId,Deleted,Individual,FollowonFund,Defunct,date_month_year)
                                            VALUES ($IncDealId,$companyId,$incubatorId,'$comment','$moreinfor',$statusid,0,$indiflag,$followonfund,$defunctflag,'$fulldate')";

                                        if ($rsinsert = mysql_query($insertcompanysql))
                                        {
                                                echo "<br>@@@@ :".$insertcompanysql;
                                        ?>
                                            <Br>
                                            <tr bgcolor="#00CC66"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany ; ?>&nbsp; --> Inserted</td> </tr>
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
                                        <!-- <tr bgcolor="C0C0C0"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; Incubator Deal already exists</td> </tr> -->
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
                echo $insPECompanySql="insert into pecompanies(companyname,industry,sector_business,website,city,AdCity,region,RegionId)
                values('$companyname',$industryId,'$sector','$web','$city','$city','$region',$regionId)";
                echo "<br>Ins company sql=" .$insPECompanySql;
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
//function to get RegionId
    function return_insert_get_RegionId($regionId)
    {
        $dbregionlink = new dbInvestments();
        $getRegionIdSql = "select Region from region where RegionId=$regionId";
        if ($rsgetInvestorId = mysql_query($getRegionIdSql))
        {
            $regioncnt=mysql_num_rows($rsgetInvestorId);
            //echo "<br>Investor count-- " .$investor_cnt;

            if($regioncnt>=1)
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
?>
