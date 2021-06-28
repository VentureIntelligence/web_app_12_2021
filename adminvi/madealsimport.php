<?php

    include_once('../PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php');
    
    require("../dbconnectvi.php");  
    $Db = new dbInvestments();
    //session_save_path("/tmp");
    session_start();
    if (session_is_registered("SessLoggedAdminPwd"))
    {
//        echo "dddddddddddddddddddddddddddd";
//        print_r( $filename  = $_FILES['mamadealsfilepath']['tmp_name']);
//        exit();
        
        if(isset($_FILES['mamadealsfilepath'])){
            
            if($_FILES['mamadealsfilepath']['tmp_name']){
               
                if(!$_FILES['mamadealsfilepath']['error'])
                {
                    
                    $inputFile = $_FILES['mamadealsfilepath']['tmp_name'];
                    $inputFilename = $_FILES['mamadealsfilepath']['name'];
                    
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
                        foreach($data[0] as $da){

                            if($da['A'] !=''){
                                $rowcount++;
                            }
                        }
                        
                       // $highestColumn = "AL";
                       
                        //Get worksheet dimensions
                        $sheet = $objPHPExcel->getSheet(0); 
                        $highestRow = $rowcount; 
                        $highestColumn = 'AN';
                        
                        
                        $rowData = array();
                        //Loop through each row of the worksheet in turn
                        for ($row = 2; $row <= $highestRow; $row++){ 
                                //  Read a row of data into an array
                            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, "", TRUE, TRUE);
                            /*echo '<pre>';
                                 print_r($rowData);
                            echo '</pre>';*/

                            $portfoliocompany = $rowData[0][0];//$_POST['txtcompanyname'];

                            $tct = $rowData[0][1];
                            if($tct=='Listed'){
                                $targettype= 'L';
                            }else if($tct=='Unlisted'){

                                $targettype = 'U';
                            }else{
                                $targettype = '';
                            }
                            //echo "<br>company. ".$portfoliocompany;
                            $target_listingstatusvalue = $targettype; //$_POST['target_listingstatus'];

                            $industry_name = $rowData[0][2];
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

                            $sector = $rowData[0][3]; //$_POST['txtsector'];

                            $amount = $rowData[0][4]; //$_POST['txtsize'];
                            if($amount <= 0)
                            {	
                                $amount = 0;
                            }
                            //echo $amount;

                            $amount_h = $rowData[0][5]; //$_POST['txtsize'];
                            if($amount_h == 'Yes')
                            {	
                                $hideamountFlag = 1;
                            }else{
                                $hideamountFlag = 0;
                            }
                            //echo $hideamountFlag;

                            $stake = $rowData[0][6]; //$_POST['txtstake'];
                            if($stake <= 0)
                            {	
                                $stake = 0;
                            }
                            //echo $stake;

                            $period = explode("-",$rowData[0][7]);
                            $monthtoAdd = $period[0]; //$_POST['month1'];
                            $yeartoAdd = $period[1]; //$_POST['year1'];
                            $MandADate=returnDate($monthtoAdd,$yeartoAdd);

                            $dealtype = $rowData[0][8];
                            if($dealtype == 'Outbound'){

                                $dealTypeId=1;
                            }elseif($dealtype == 'Inbound'){

                                $dealTypeId=2;
                            }elseif($dealtype == 'Domestic'){

                                $dealTypeId=3;
                            }
                            //echo $dealTypeId;

                            $col6 = $rowData[0][9]; //$_POST['txtAdvTargetCompany'];
                            $TargetAdvisorString = str_replace('"','',$col6);
                            //echo "<Br>Advisor String- ".$TargetAdvisorString;
                            $TargetAdvisorString = explode(",",$TargetAdvisorString);

                            $targetcity = $rowData[0][10]; //$_POST['txtTargetCity'];
                    //	$targetcityId=insert_city($targetcity);

                            $region = $rowData[0][11]; //$_POST['txtregion'];
                            $regionId= '';
                            $regionSql = "select RegionId,Region from region where Region='".$region."'";
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

                           //echo $regionId;

                           $country_name = $rowData[0][12];
                           $countrysql="select CountryId,Country from country where Country ='".trim($country_name)."'";
                            $targetCountryId = '';
                            if ($rsdealtypes = mysql_query($countrysql))
                            {
                             $dealtype_cnt = mysql_num_rows($rsdealtypes);
                            }
                            if($dealtype_cnt>0)
                            {
                                While($myrow=mysql_fetch_array($rsdealtypes, MYSQL_BOTH))
                                {
                                       $targetCountryId = $myrow[0];
                                }
                                mysql_free_result($rsdealtypes);
                            }
                            //echo $targetCountryId;

                            $website = $rowData[0][13];

                            $acquirer = $rowData[0][14];//$_POST['txtacquirer'];
                            $acquirer=str_replace('"','',$acquirer);
                            $AcquirerId=0;

                            $act = $rowData[0][15];
                            if($act=='Listed'){

                                $acquirer_listingstatusvalue= 'L';
                            }else if($act=='Unlisted'){

                                $acquirer_listingstatusvalue = 'U';
                            }else{

                                $acquirer_listingstatusvalue = '';
                            }
                            
                            $acq_industry_name = $rowData[0][16];

                            // echo $acq_industry_name; exit;

                            $industrysql = "select industryid,industry from industry where industryid !=15 and industry='".trim($acq_industry_name)."'order by industry";
                            
                            $industryid = 0;
                            if ($industryrs = mysql_query($industrysql))
                            {
                                $ind_cnt = mysql_num_rows($industryrs);
                            }
                            if($ind_cnt>0)
                            {
                                $myrow = mysql_fetch_assoc($industryrs, MYSQL_BOTH);

                                // echo '<pre>'; print_r($myrow); echo '</pre>'; exit;

                                $acqindid = $myrow['industryid'];
                                $acqindustryid = $myrow['industry'];

                                mysql_free_result($industryrs);
                            }else{
                                $acqindid = '';
                                $acqindustryid = '';
                            }

                            $Acquirorgroup = $rowData[0][17];
                            
                            $Acquirorcity = $rowData[0][18];

                            $acq_country_name = $rowData[0][19];
                            $acqcountrysql="select CountryId,Country from country where Country ='".trim($acq_country_name)."'";
                            $AcquirorCountryId='';
                            if ($rsacqtypes = mysql_query($acqcountrysql))
                            {
                                $acq_cnt = mysql_num_rows($rsacqtypes);
                            }
                            if($acq_cnt>0)
                            {
                                While($myrow=mysql_fetch_array($rsacqtypes, MYSQL_BOTH))
                                {
                                    $AcquirorCountryId = $myrow[0];
                                }
                                mysql_free_result($rsacqtypes);
                            }

                            if(trim($acquirer)!="")
                            {
                                $AcquirerId=returnAcquirerId($acquirer,$Acquirorcity,$AcquirorCountryId,$acqindid,$Acquirorgroup);
                               // echo "<br>Acquirer Id if not zero- ".$AcquirerId;
                                /*if($AcquirerId==0)
                                {
                                    $AcquirerId=returnAcquirerId($acquirer,$Acquirorcity,$AcquirorCountryId);
                                    //	echo "<br>Acquirer Id-".$AcquirerId ."-" .$acquirer;
                                }*/
                            }
                            
                            $col7 = $rowData[0][20];
                            $AcquirorString=str_replace('"','',$col7);
                            //echo "<bR>Acquiror String-" .$AcquirorString;
                            $AcquirorString=explode(",",$AcquirorString);

                            $comment = $rowData[0][21];
                            $comment = str_replace('"','',$comment);

                            $moreinfor = $rowData[0][22];
                            $moreinfor = str_replace('"','',$moreinfor);

                            $validation= $rowData[0][23];//$_POST['txtvalidation'];

                            if($rowData[0][24]=='Yes')
                            {
                                //echo"<br>***************";
                                $assetFlag=1;
                            }
                            else
                            {
                                $assetFlag=0;
                            }

                            $link = $rowData[0][25]; //$_POST['txtlink'];

                            if($rowData[0][26]!=""){

                                $company_valuation = $rowData[0][26];
                            }else{
                                $company_valuation = 0;
                            }

                            if($rowData[0][27]!=""){

                                $revenue_multiple = $rowData[0][27];
                            }else{
                                $revenue_multiple = 0;
                            }

                            if($rowData[0][28]!=""){

                                $ebitda_multiple = $rowData[0][28];
                            }else{
                                $ebitda_multiple = 0;
                            }

                            if($rowData[0][29]!=""){

                                $pat_multiple = $rowData[0][29];
                            }else{
                                $pat_multiple = 0;
                            }

                            $valuation = $rowData[0][30];

                            $fullDateAfter = $MandADate;

                            $flagdeletion=0;

                            $getrevenue_value = $rowData[0][31];

                            if($getrevenue_value == 'Yes'){

                                $revenue = $rowData[0][27];
                                if($revenue==""){
                                    $revenue=0;
                                }

                                $ebitda = $rowData[0][28];
                                if($ebitda==""){
                                    $ebitda=0;
                                }

                                $pat = $rowData[0][29];
                                if($pat==""){
                                    $pat=0;
                                }

                            }else{

                                $revenue = $rowData[0][32];
                                if($revenue==""){
                                    $revenue=0;
                                }

                                $ebitda = $rowData[0][33];
                                if($ebitda==""){
                                    $ebitda=0;
                                }

                                $pat = $rowData[0][34];
                                if($pat==""){
                                    $pat=0;
                                }

                            }

                            $finlink = $rowData[0][35]; //$POST['txtfinlink'];

                            $uploadname= $rowData[0][37]; // $_POST['txtfilepath'];

                            $sourcename= $rowData[0][38]; // $_POST['txtsource'];

                            $chkhideAgg = $rowData[0][39];
                            if($chkhideAgg == 'Yes'){

                                $hideAggregatetoUpdate=1;
                            }else{

                                $hideAggregatetoUpdate=0;
                            }

                            if (trim($portfoliocompany) !="")
                            {

                                $companyId=insert_company($portfoliocompany,$indid,$sector,$website,$targetCountryId,$targetcity,$regionId,$region);
                                if($companyId==0)
                                {
                                    $companyId=insert_company($portfoliocompany,$indid,$sector,$website,$targetCountryId,$targetcity,$regionId,$region);
                                }

                                if ($companyId >0)
                                {
                                    $pegetInvestmentsql = "select ma.MAMAId,c.PECompanyId,ma.PECompanyId,DealDate from pecompanies as c,
                                    mama as ma where ma.PECompanyId = c.PECompanyId and
                                    ma.DealDate = '$fullDateAfter' and c.PECompanyId = $companyId and Deleted=0 ";
                                    //	echo "<br>checking pe record***" .$pegetInvestmentsql;
                                    //echo "<br>Company id--" .$companyId;
                                    if ($rsInvestment = mysql_query($pegetInvestmentsql))
                                    {
                                        $investment_cnt = mysql_num_rows($rsInvestment);
                                        //echo "<br>Count**********-- " .$investment_cnt ;
                                    }
                                    // if($investment_cnt==0)
                                    // {
                                        $MAMAId= rand();
                                        //echo "<br>random MandAId--" .$MAMAId;
                                        $insertcompanysql="";
                                        $createddate=date("Y-m-d")." ".date("H:i:s");
                                        $modifieddate=$createddate;

                                        $insertcompanysql= "INSERT INTO mama (MAMAId,PECompanyId,Amount,Stake,DealDate,MADealTypeId,AcquirerId,Comment,MoreInfor,Validation,Asset,Deleted,CreatedDate,ModifiedDate,hideamount,Link,uploadfilename,source,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status,AggHide,Revenue,EBITDA,PAT)
                                        VALUES ($MAMAId,$companyId,$amount,$stake,'$fullDateAfter',$dealTypeId,$AcquirerId,'$comment','$moreinfor', '$validation',$assetFlag,$flagdeletion,'$createddate','$modifieddate',$hideamountFlag,'$link','$filename','$sourcename','$valuation','$finlink',$company_valuation,$revenue_multiple,$ebitda_multiple,$pat_multiple,'$target_listingstatusvalue','$acquirer_listingstatusvalue',$hideAggregatetoUpdate,$revenue,$ebitda,$pat)";
                                        //echo "<br>@@@@ :".$insertcompanysql;
                                        if ($rsinsert = mysql_query($insertcompanysql))
                                        {
                                            //echo "<br>Advisor String-" .$TargetAdvisorString;
                                            foreach ($TargetAdvisorString as $targetadvisor)
                                            {
                                                if(trim($targetadvisor)!="")
                                                {
                                                    echo "<br>)))--" .$targetadvisor;
                                                    $TargetAdvisorIdtoInsert=insert_get_CIAs(trim($targetadvisor));
                                                    if($TargetAdvisorIdtoInsert==0)
                                                    {
                                                            $TargetAdvisorIdtoInsert=insert_get_CIAs(trim($targetadvisor));
                                                    }
                                                    $insadvcompany=insert_Investment_AdvisorCompany($MAMAId,$TargetAdvisorIdtoInsert);
                                                }
                                            }
                                            foreach ($AcquirorString as $acquiroradvisor)
                                            {
                                                if(trim($acquiroradvisor)!="")
                                                {

                                                    $AcquirorAdvisorIdtoInsert=insert_get_CIAs(trim($acquiroradvisor));
                                                    if($AcquirorAdvisorIdtoInsert==0)
                                                    {
                                                        $AcquirorAdvisorIdtoInsert=insert_get_CIAs(trim($acquiroradvisor));
                                                    }
                                                    $insadvcompany=insert_Investment_AdvisorAcquiror($MAMAId,$AcquirorAdvisorIdtoInsert);

                                                }
                                            }

                                            $datedisplay =  $fullDateAfter; //(date("Y F", $fullDateAfter));
                                            ?>
                                            <Br>
                                            <tr bgcolor="#00CC66"> <td colspan=2width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $datedisplay . " - " .$portfoliocompany ; ?>&nbsp; --> Inserted</td> <br></tr>
                                            <?php
                                        }
                                        else
                                        {
                                        ?><Br>
                                            <tr bgcolor="red"> <td colspan=2 width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; --> Insert failed</td> <br></tr>
                                        <?php
                                        }
                                            //	echo "<br> insert-".$insertcompanysql;
                                //     }
                                //     elseif($investment_cnt >= 1)
                                //     {
                                //         While($myrow=mysql_fetch_array($rsInvestment, MYSQL_BOTH))
                                //         {
                                //             $fullDateAfter;
                                //             $updatecompanysql= "Update mama set PECompanyId='$companyId',Amount='$amount',Stake='$stake',DealDate='$fullDateAfter',
                                //             MADealTypeId='$dealTypeId',AcquirerId='$AcquirerId',Comment='$comment',MoreInfor='$moreinfor',Validation='$validation',Asset='$assetFlag',
                                //             Deleted='$flagdeletion',CreatedDate='$createddate',ModifiedDate='$modifieddate',hideamount='$hideamountFlag',Link='$link',
                                //             uploadfilename='$filename',source='$sourcename',Valuation='$valuation',FinLink='$finlink',Company_Valuation='$company_valuation',
                                //             Revenue_Multiple='$revenue_multiple',EBITDA_Multiple='$ebitda_multiple',PAT_Multiple='$pat_multiple',target_listing_status='$target_listingstatusvalue',
                                //             acquirer_listing_status='$acquirer_listingstatusvalue',AggHide='$hideAggregatetoUpdate',Revenue='$revenue',EBITDA='$ebitda',PAT='$pat' where MAMAId=".$myrow['MAMAId'];
                                      
                                //             if ($rsupdate = mysql_query($updatecompanysql))
                                //         { ?>
                                            
                                            <Br>
                                         <!-- <tr bgcolor="C0C0C0"> <td colspan=2 width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp;MA_MA Deal already exists and deals has been updated</td> <br> </tr>
                                     -->
                                      <?php // } 
                                 
                                //     }
                                    
                                 
                                // }

                                }

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
    
    function returnDate($mth,$yr)
    {
        //this function returns the date
        $fulldate= $yr ."-" .date("m", strtotime($mth)) ."-01";
       
            return date('Y-m-d',  strtotime($fulldate));
        
        
    }

    function returnAcquirerId($acquirername,$cityid,$countryid,$industryid,$group)
    {
	$acquirername=trim($acquirername);
	//echo "<br>Acquirer- " .$acquirername;
	$dbaclinkss = new dbInvestments();
        
	$getAcquirerSql="select * from acquirers where Acquirer like '$acquirername'";


    // echo '<pre>'; print_r($seperate_field); echo '</pre>';  exit;
        
	if($rsgetAcquirer=mysql_query($getAcquirerSql))
	{
            $acquirer_cnt=mysql_num_rows($rsgetAcquirer);
            //echo "<br>-- ".$acquirer_cnt;
            if($acquirer_cnt==0)
            {
                //insert acquirer
                $insAcquirerSql="insert into acquirers(Acquirer,CityId,countryid,IndustryId,Acqgroup) values('$acquirername','$cityid','$countryid','$industryid','$group')";
                //echo "<br>Insert Acquirer--" .$insAcquirerSql;
                if($rsInsAcquirer = mysql_query($insAcquirerSql))
                {
                    $acquirerId=0;
                    return mysql_insert_id();
                }
            }
            elseif($acquirer_cnt >= 1)
            {
                While($myrow=mysql_fetch_array($rsgetAcquirer, MYSQL_BOTH))
                {
                    $acquirerId = $myrow["AcquirerId"];

                    $rsgetPECompanyId = mysql_query($getAcquirerSql);
                    $seperate_field = mysql_fetch_assoc($rsgetPECompanyId);

                    // echo '<pre>'; print_r($seperate_field); echo '</pre>'; 

                    // echo '<pre>'; print_r($seperate_field['CityId']); echo '</pre>'; 
                    // echo '<pre>'; print_r($seperate_field['IndustryId']); echo '</pre>'; 


                    // echo 'City__'.$cityid.'<br />';
                    // echo 'Industry__'.$industryid.'<br />';
                  
                   
                    // exit;

                    if($seperate_field['CityId'] == $cityid && $seperate_field['IndustryId'] == $industryid)
                    {
                        // $updateAcqCityCountrySql="Update acquirers set CityId='$cityid',countryid='$countryid',IndustryId='$industryid',Acqgroup='$group' where AcquirerId=$acquirerId";

                        $updateAcqCityCountrySql="Update acquirers set CityId='$cityid',IndustryId='$industryid' where AcquirerId=$acquirerId";

                        echo 'Successfully Added';

                        if($rsAcqcityCountrySql = mysql_query($updateAcqCityCountrySql))
                        {
                            //	/echo "<br>Acquirer Update-- ".$updateAcqCityCountrySql;
                        }
                        return $acquirerId;

                    }else{
                        // echo 'Mismatch Records...';
                        return $acquirerId;
                    }
                    // exit;
                    
                }
            }
	}
	$dbaclinkss.close();
    }

/* function to insert the companies and return the company id if exists */
	function insert_company($companyname,$industryId,$sector,$web,$countryid,$city,$regionId,$region)
	{
		$dbpecomp = new dbInvestments();
		$getPECompanySql = "select PECompanyId,industry,sector_business,website,city from pecompanies where companyname= '$companyname'";

		// echo "<br>select--" .$getPECompanySql; exit;

        // echo '<pre>'; print_r($getPECompanySql); echo '</pre>'; 

        $rsgetPECompanyId = mysql_query($getPECompanySql);
                    $seperate_field = mysql_fetch_assoc($rsgetPECompanyId);

                    //  echo '<pre>'; print_r($seperate_field); echo '</pre>';  exit;



		if ($rsgetPECompanyId = mysql_query($getPECompanySql))
		{
            $pecomp_cnt=mysql_num_rows($rsgetPECompanyId);
            if ($pecomp_cnt==0)
            {
                
                //insert pecompanies
                $insPECompanySql="insert into pecompanies(companyname,industry,sector_business,website,countryid,city,AdCity,RegionId,region)
                values('$companyname','$industryId','$sector','$web','$countryid','$city','$city',$regionId,'$region')";
                //echo "<br>Ins company sql=" .$insPECompanySql;
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

                    // echo $companyId; exit;

                    $rsgetPECompanyId = mysql_query($getPECompanySql);
                    $seperate_field = mysql_fetch_assoc($rsgetPECompanyId);
            
                    // echo '<pre>'; print_r($seperate_field); echo '</pre>'; 

                    // echo 'Industry__'.$industryId.'<br />';
                    // echo 'City__'.$city.'<br />';
                    // echo 'Sector__'.$sector.'<br />';
                    // echo 'Web__'.$web.'<br />';
                    //  exit;

                    if($seperate_field['city'] == $city && $seperate_field['sector_business'] == $sector && $seperate_field['industry'] == $industryId &&  $seperate_field['website'] == $web)
                    {
                        // echo 'Changes ila';
                        $updateCityCountrySql="Update pecompanies set industry='$industryId',sector_business='$sector',website='$web',city='$city',AdCity='$city' where PECompanyId=$companyId";

                        echo 'Successfully Added';

                        if($rscityCountrySql=mysql_query($updateCityCountrySql))
                        {
                            //		echo "<br>Update Company- " .$updateCityCountrySql;
                        }
                            //	echo "<br>Insert return industry id--" .$companyId;
                            return $companyId;

                    }else{
                        return $companyId;
                    }
                    // exit;

                   
                }
            }
		}
		$dbpecomp.close();
	}

/* function to insert the industry and return the industry id if exists
	function insert_industry($industryname)
	{
		$dbindustrylink = new dbInvestments();
		$getIndustrySql = "select IndustryId from industry where industry like '$industryname%'";
		//echo "<br>select--" .$getIndustrySql;
		if ($rsgetIndustryId = mysql_query($getIndustrySql))
		{
			$ind_cnt=mysql_num_rows($rsgetIndustryId);
			//echo "<br>Investor count-- " .$ind_cnt;
			if ($ind_cnt==0)
			{
					//insert industry
					$insIndustrySql="insert into industry(industry) values('$industryname')";
					if($rsInsIndustry = mysql_query($insIndustrySql))
					{
						$IndustryId=0;
						return $IndustryId ;
					}
			}
			elseif($ind_cnt==1)
			{
				While($myrow=mysql_fetch_array($rsgetIndustryId, MYSQL_BOTH))
				{
					$IndustryId = $myrow[0];
				//	echo "<br>Insert return industry id--" .$IndustryId;
					return $IndustryId;
				}
			}
		}
		$dbindustrylink.closeDB();
	}
*/


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
				//echo "<br>Insert return investor id--" .$ciaInvestorId;
				return $ciaInvestorId;
			}
		}
	}
	$dblink.close();

}

// the following function inserts advisor_PEIds in the peinvestments_advisor table
	function insert_Investment_AdvisorCompany($dealId,$ciaid)
	{
		$DbAdvComp= new dbInvestments();
		$getDealInvSql="Select MAMAId,CIAId from mama_advisorcompanies where MAMAId=$dealId and CIAId=$ciaid";

		//echo "<br>@@@@@@--" .$getDealInvSql;
		if($rsgetdealinvestor = mysql_query($getDealInvSql))
		{
			$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
			if($deal_invcnt==0)
			{
				$insDealInvSql="insert into mama_advisorcompanies values($dealId,$ciaid)";
				if($rsinsdealinvestor = mysql_query($insDealInvSql))
				{
					return true;
				}
			}
		}
		$DbAdvComp.close();
}
// the following function inserts advisor_PEIds in the peinvestments_advisor table
	function insert_Investment_AdvisorAcquiror($dealId,$ciaid)
	{
		$DbAdvComp= new dbInvestments();
		$getDealInvSql="Select MAMAId,CIAId from mama_advisoracquirer where MAMAId=$dealId and CIAId=$ciaid";

		//echo "<br>@@@@@@--" .$getDealInvSql;
		if($rsgetdealinvestor = mysql_query($getDealInvSql))
		{
			$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
			if($deal_invcnt==0)
			{
				$insDealInvSql="insert into mama_advisoracquirer values($dealId,$ciaid)";
				if($rsinsdealinvestor = mysql_query($insDealInvSql))
				{
					return true;
				}
			}
		}
		$DbAdvComp.close();
}


function insert_city($cityname)
{
	$dbcity = new dbInvestments();
	$getCitySql="select CityId from city where city like '$cityname'";
	if($rscity=mysql_query($getCitySql))
	{
		$city_cnt=mysql_num_rows($rscity);
		//echo "<br>Count---" .$city_cnt;
		if($city_cnt==0)
		{
			//insert city
			$idcity=rand();
			$insCitySql="insert into city(CityId,City) values($idcity,'$cityname')";
			if($rsinsCity=mysql_query($insCitySql))
			{
				$cityId=$idcity;
				return $cityId;
			}
		}
		elseif($city_cnt>=1)
		{
			While($myrow=mysql_fetch_array($rscity, MYSQL_BOTH))
			{
				$cityId = $myrow[0];
			//	echo "<br>Insert return industry id--" .$companyId;
				return $cityId;
			}
		}
	//	echo "<br>Return CityId----" .$cityId;

	}

	$dbcity.close();
}
?>
