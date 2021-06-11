<?php include_once("../globalconfig.php"); ?>
<?php
ini_set('max_execution_time', '600');
include_once('../PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php');
require("../dbconnectvi.php");
$Db = new dbInvestments();
$uploadOk = 1;

//$username=$_REQUEST['username'];
if(isset($_FILES['companyFilePath']))
{
     $file_array = explode(".", $_FILES["companyFilePath"]["name"]); 
    //echo json_encode($file_array);exit();
      if($file_array[1] == "xls" || $file_array[1] == "xlsx" || $file_array[1] == "csv" )  
      {  
       $inputFile=$_FILES["companyFilePath"]["tmp_name"];
        //echo $inputFile;exit();
       try {
         
       // PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);

        $inputFileType = PHPExcel_IOFactory::identify($inputFile);
        
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
       
        $objPHPExcel = $objReader->load($inputFile);
    } catch(Exception $e) {
      die($e->getMessage());
    }
                            $data = $objPHPExcel->getActiveSheet()->toArray();

for($i=1;$i< count($data);$i++){
  $val.=$data[$i][0];
  $val.=",";
  
}
       generateExcelinCompanyname(rtrim($val , ','));
}
};


function generateExcelinCompanyname($companyname)
{
    $companyname=explode(',',$companyname);

      $companysql="SELECT `cprofile`.`Company_Id`, `cprofile`.`SCompanyName`, `cprofile`.`FCompanyName`, `cprofile`.`CIN`, `cprofile`.`Old_CIN`, `cprofile`.`CEO` AS `ContactName`, `cprofile`.`CFO` AS `Designation`, `cprofile`.`auditor_name` AS `AuditorName`, `cprofile`.`Phone`, `cprofile`.`Email`, `cprofile`.`Website`, `cprofile`.`AddressHead` AS `Address`, `cprofile`.`BusinessDesc` AS `BusinessDescription`, `cprofile`.`Permissions1` AS `TransactionStatus`, `cprofile`.`IncorpYear` AS `Year`, `city`.`city_id` AS `city.city_id`, `city`.`city_name` AS `city.city_name`, `bi_industry`.`industries_industry_id` AS `bi_industry.industries_industry_id`, `bi_industry`.`industry` AS `bi_industry.industry`, `sector`.`Sector_Id` AS `sector.Sector_Id`, `sector`.`SectorName` AS `sector.SectorName` FROM `cprofile` AS `cprofile` LEFT OUTER JOIN `city` AS `city` ON `cprofile`.`City` = `city`.`city_id` LEFT OUTER JOIN `bi_industry` AS `bi_industry` ON `cprofile`.`Industry` = `bi_industry`.`industries_industry_id` LEFT OUTER JOIN `sectors` AS `sector` ON `cprofile`.`Sector` = `sector`.`Sector_Id` WHERE (`cprofile`.`ListingStatus` IN (1, 2, 3, 4) AND `cprofile`.`Permissions1` IN (0, 1) AND `cprofile`.`UserStatus` = 0 AND `cprofile`.`Industry` IS NOT NULL AND `cprofile`.`Industry` != '' AND `cprofile`.`State` IS NOT NULL AND `cprofile`.`State` != '' AND `cprofile`.`FCompanyName` IN  ('". implode("','", $companyname) ."'))";
       
      $sql=$companysql;

      $result = @mysql_query($sql)
          or die("Error in connection");
          function movetabs($fytabs){
            $rval = "";
            for($i=0;$i<$fytabs;$i++){
                 
                 $rval .= ""."\t";
                 $rval .= ""."\t";
                 $rval .= ""."\t";
                 $rval .= ""."\t";
                 $rval .= ""."\t";
                 $rval .= ""."\t";
                 $rval .= ""."\t";
                 
                 
                 $rval .= ""."\t";
                 $rval .= ""."\t";
                 $rval .= ""."\t";
                 $rval .= ""."\t";
                 $rval .= ""."\t";
                 $rval .= ""."\t";
                 $rval .= ""."\t";
                 $rval .= ""."\t";
                 $rval .= ""."\t";
                 $rval .= ""."\t";
                 $rval .= ""."\t";
                 $rval .= ""."\t";
                 $rval .= ""."\t";
                 
                 $rval .= ""."\t";
                   if($i>10){  break; }
            }
            
            return $rval;
                    
        }
      header("Content-type: application/octet-stream");
      header("Content-Disposition: attachment; filename=cfsexport.xls");
      header("Pragma: no-cache");
      header("Expires: 0");
          
        $sep = "\t"; //tabbed character
        $currency=="INR";
        //print("\n");
        $currFY = Date('y')-1;
        //echo $currFY;exit();
        echo "SCompanyName"."\t";
        echo "FCompanyName"."\t";
        echo "CIN"."\t";
        echo "Old_CIN"."\t";
        for($i=$currFY;$i>=14;$i--){
        echo "Resulttype"."\t";
        echo "FY"."\t";
        echo "CashflowFromOperation"."\t";
        echo "NetcashUsedInvestment"."\t";
        echo "NetcashFromFinance"."\t";
        }
        

        echo "ContactName"."\t";
        echo "Designation"."\t";
        echo "AuditorName"."\t";
        echo "Phone"."\t";
        echo "Email"."\t";
        echo "Website"."\t";
        echo "Address"."\t";
        echo "BusinessDescription"."\t";
        echo "TransactionStatus"."\t";
        echo "Year"."\t";
        echo "City"."\t";
        echo "Industry"."\t";
        echo "Sector"."\t";
        for($i=$currFY;$i>=14;$i--){
            
             
                echo "ResultType"."\t";
                echo "FY".$i."\t";


                echo "EBITDA (cr)"."\t";
                echo "PAT(cr)"."\t";
                echo "TotalIncome(cr)"."\t";

                echo "NonCurrentAssets "."\t";
                echo "CurrentAssets"."\t";
                echo "TotalAssets"."\t";
                echo "TotalShareholdersFund"."\t";
                echo "NonCurrentLiabilities"."\t";
                echo "CurrentLiabilities"."\t";
                echo "TotalEquityLiabilities"."\t";
        
    }

        print("\n");

        $flag = false; 
        $schema_insert = "";
       
        while($row = mysql_fetch_row($result))
        { 
            $schema_insert .= ""."\n";

                $SCompanyName = preg_replace("/\s+/", " ", $row[1]);
                $schema_insert .= trim($SCompanyName).$sep; //SCompanyName

                $FCompanyName = preg_replace("/\s+/", " ", $row[2]);
                $schema_insert .= trim($FCompanyName).$sep; //FCompanyName

                $CIN = preg_replace("/\s+/", " ", $row[3]);
                $schema_insert .= trim($CIN).$sep; //CIN

                $Old_CIN = preg_replace("/\s+/", " ", $row[4]);
                $schema_insert .= trim($Old_CIN).$sep; //Old_CIN

                $compid =$row[0];

                $c="SELECT cash_flow.CashflowFromOperation,cash_flow.NetcashUsedInvestment,cash_flow.NetcashFromFinance,cash_flow.ResultType,cash_flow.FY from cash_flow as cash_flow WHERE cash_flow.CId_FK ='$compid' and cash_flow.Resulttype in (0,1) group BY cash_flow.FY ORDER BY cash_flow.FY DESC LIMIT 9";
                //echo $c;exit();
                $cashflow = @mysql_query($c)
                or die("Error in connection");
                while ($cl = mysql_fetch_row($cashflow)){
                    //echo $cl[3].'hai';exit();
                    if($cl[3].$sep == 0)
                    {
                        $schema_insert .= "Standalone".$sep; //Resulttype
                    }
                    else
                    {
                        $schema_insert .= "Consolidated".$sep; //Resulttype

                    }


                    $schema_insert .= $cl[4].$sep; //fy

                    $schema_insert .= $cl[0].$sep; //CashflowFromOperation


                    $schema_insert .= $cl[1].$sep; //NetcashUsedInvestment


                    $schema_insert .= $cl[2].$sep; //NetcashFromFinance

                    $currentFYr--;


                }


                $ContactName = preg_replace("/\s+/", " ", $row[5]);
                $schema_insert .= trim($ContactName).$sep; //ContactName

                $Designation = preg_replace("/\s+/", " ", $row[6]);
                $schema_insert .= trim($Designation).$sep; //Designation

                $AuditorName = preg_replace("/\s+/", " ", $row[7]);
                $schema_insert .= trim($AuditorName).$sep; //AuditorName

                $Phone = preg_replace("/\s+/", " ", $row[8]);
                $schema_insert .= trim($Phone).$sep; //Phone

                $Email = preg_replace("/\s+/", " ", $row[9]);
                $schema_insert .= trim($Email).$sep; //Email    

                $Website = preg_replace("/\s+/", " ", $row[10]);
                $schema_insert .= trim($Website).$sep; //Website

                $Address = preg_replace("/\s+/", " ", $row[11]);
                $schema_insert .= trim($Address).$sep; //Address

                $BusinessDescription = preg_replace("/\s+/", " ", $row[12]);
                $schema_insert .= trim($BusinessDescription).$sep; //BusinessDescription

                $TransactionStatus = preg_replace("/\s+/", " ", $row[13]);
                $schema_insert .= trim($TransactionStatus).$sep; //TransactionStatus

                $Year = preg_replace("/\s+/", " ", $row[14]);
                $schema_insert .= trim($Year).$sep; //Year

                $City = preg_replace("/\s+/", " ", $row[16]);
                $schema_insert .= trim($City).$sep; //City

                $Industry = preg_replace("/\s+/", " ", $row[18]);
                $schema_insert .= trim($Industry).$sep; //Industry

                $Sector = preg_replace("/\s+/", " ", $row[20]);
                $schema_insert .= trim($Sector).$sep; //Sector

               
                $q="SELECT p.EBITDA,p.PAT,p.TotalIncome,p.FY, p.ResultType,b.N_current_assets,b.Current_assets,b.Total_assets,b.TotalFunds,b.N_current_liabilities,b.Current_liabilities,b.T_equity_liabilities,b.FY,b.ResultType FROM plstandard p  LEFT JOIN balancesheet_new b  ON b.CID_FK=p.CID_FK  WHERE p.FY = b.FY and p.CId_FK ='$compid' and b.Resulttype in (0,1) group BY p.FY ORDER BY p.FY DESC LIMIT 9";
                
                $financial = @mysql_query($q)
                or die("Error in connection");

                    $currency="INR";
                    $currentFYr = Date('y')-1;
                    $skipnextyear = false;
                    $a=1;
                    $currentFormatedYear=0;
                   // echo $q;exit();
                    while ($pl = mysql_fetch_row($financial)){ 
                        if($pl[4].$sep == 0)
                        {
                            $schema_insert .= "Standalone".$sep; //Resulttype
                        }
                        else
                        {
                            $schema_insert .= "Consolidated".$sep; //Resulttype

                        }

                    $schema_insert .= $pl[3].$sep; //fy


                    // ebitda
                        if ($pl[0]=='' || $pl[0] == 0){
                        $schema_insert .= $sep;
                        }else{
                            $EBIDTA = $pl[0];
                            $schema_insert .= $EBIDTA.$sep;
                        }

                        //pat
                        $PAT=$pl[1];
                        if ($pl[1]=="" || $pl[1]==0){
                            $schema_insert .= $sep;
                        }else{
                            $schema_insert .= $PAT.$sep;
                        
                        }

                        // total income
                        $total_income=$pl[2];

                        if($total_income=="")
                        {
                            $schema_insert .= $sep;
                        }
                        else
                        {
                            $schema_insert .= $total_income.$sep;
                        }





                          //////////////////balance sheet/////////////////////////////
                        // /*


                            // NonCurrentAssets
                            $TCL=$pl[5];
                            if ($pl[5]=="" || $pl[5]==0){
                            $schema_insert .= $sep;
                            }else{
                            $schema_insert .= $TCL.$sep;
                            }

                            // CurrentAssets
                            $CL=$pl[6];
                            if ($pl[6]=="" || $pl[6]==0){
                            $schema_insert .= $sep;
                            }else{
                            $schema_insert .= $CL.$sep;
                            }


                            // TotalAssets
                            $TA=$pl[7];
                            if ($pl[7]=="" || $pl[7]==0){
                            $schema_insert .= $sep;
                            }else{
                            $schema_insert .= $TA.$sep;
                            }


                            // TotalShareholdersFund
                            $TST=$pl[8];
                            if ($pl[8]=="" || $pl[8]==0){
                            $schema_insert .= $sep;
                            }else{
                            $schema_insert .= $TST.$sep;
                            }


                            // NonCurrentLiabilities
                            $NCL=$pl[9];
                            if ($pl[9]=="" || $pl[9]==0){
                            $schema_insert .= $sep;
                            }else{
                            $schema_insert .= $NCL.$sep;
                            }


                            // CurrentLiabilities
                            $CurrentLiabilities=$pl[10];
                            if ($pl[10]=="" || $pl[10]==0){
                            $schema_insert .= $sep;
                            }else{
                            $schema_insert .= $CurrentLiabilities.$sep;
                            }

                            // TotalEquityLiabilities
                            $TotalEquityLiabilities=$pl[11];
                            if ($pl[11]=="" || $pl[11]==0){
                            $schema_insert .= $sep;
                            }else{
                            $schema_insert .= $TotalEquityLiabilities.$sep;
                            }




                       
                    }
            }

        print(trim($schema_insert));
        print "\n";
        mysql_close();

        }
?>
