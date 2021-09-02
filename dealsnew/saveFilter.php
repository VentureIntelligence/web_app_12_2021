<?php include_once("../globalconfig.php"); ?>
<?php
   require("../dbconnectvi.php");
   $Db = new dbInvestments();
   $dlogUserEmail = $_SESSION['UserEmail'];
   $username=$_SESSION['UserNames'];
     $companyIdsession=$_SESSION['DcompanyId'];
   //print_r($_SESSION);
   if($_POST['mode'] == 'saveFilter')
   {
        $sql="SELECT * FROM `saved_filter` ";
        //echo $sql;exit();
        $sqlSelResult = mysql_query($sql) or die(mysql_error());
        $InvestorArray=array();
        while ($row = mysql_fetch_assoc($sqlSelResult)) {
        array_push($InvestorArray,$row);
        }
        echo json_encode($InvestorArray);
   
   }

   else if($_POST['mode'] == 'A')
   {
            $investorval = json_decode(stripslashes($_POST['investorval']));
            
            $filtername = $_POST['filtername'];
            $EditFilter=$_POST['EditFilter'];
            $filterDesc=$_POST['filterDesc'];
            $checkboxName=$_POST['checkboxName'];
            $investorvalArray = implode (",", $investorval); 
            
            $companytype = implode(",",$_POST['companytype']);
            $industry=implode(",",$_POST['Industry']);
            $dealType=implode(",",$_POST['dealType']);
            $Intype=implode(",",$_POST['Intype']);
            
            $city=implode(",",$_POST['city']);
            $state=implode(",",$_POST['state']);
            $region=implode(",",$_POST['region']);
            $round=implode(",",$_POST['round']);
            $stage=implode(",",$_POST['stage']);
            $investorType=implode(",",$_POST['investorType']);
            $filterType=$_POST['filterType'];
            $companyName=$_POST['companyName'];
            $filterQuery=$_POST['filterQuery'];
            
            if($companyIdsession == 1470326532)
            {
               $filter_active='active';
            }
            else
            {
            $filter_active=$_POST['filter_active'];
            }
            $vi_filter=0;

            $startDate=$_POST['start_date'];
            $endDate=$_POST['end_date'];
            $startYear=$_POST['start_year'];
            $endYear=$_POST['end_year'];

            //echo $filterType;exit();

            $exitStatus=implode(",",$_POST['exitStatus']);
            
            //echo json_encode($_POST['state']);exit();
            $sqlSelCount = "SELECT *  FROM `saved_filter` WHERE `id` = '" . $EditFilter . "' ";
            //echo $sqlSelCount;exit();
            $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
            $rowSelCount = mysql_num_rows($sqlSelResult);
          //   echo $rowSelCount;exit();
            if($rowSelCount > 0)
            {
               $query = "UPDATE `saved_filter` SET `company_name`='".$companyName."',`start_date`='".$startDate."',`end_date`='".$endDate."',`start_year`='".$startYear."',`end_year`='".$endYear."', `filter_active`='".$filter_active."',`query`='".$filterQuery."',`vi_filter`='".$vi_filter."',`dealtype`='".$dealType."',`intype`='".$Intype."',`company_type`='".$companytype."',`industry`='".$industry."',`city`='".$city."',`state` ='".$state."',`region` ='".$region."',`exit_status` ='".$exitStatus."',`round`='".$round."',`stage`='".$stage."',`investor_type`='".$investorType."',`filter_name`='".$filtername."',`filter_desc`='".$filterDesc."',`investor_name`='" . $investorvalArray . "',`column_name`='" . $checkboxName . "',`modefied_by`='" . $dlogUserEmail . "',`modefied_on`=CURDATE()  WHERE `id` = '" . $EditFilter . "' ";
            // echo $filtername;
            }
            else
            {
               $query = "INSERT INTO `saved_filter`(`id`, `investor_name`, `column_name`, `filter_name`,`filter_type`,`filter_desc`,`company_type`,`company_name`,`industry`,`city`,`state`,`region`,`exit_status`,`round`,`stage`,`investor_type`,`dealtype`,`intype`,`filter_active`,`query`,`vi_filter`,`start_date`,`start_year`,`end_date`,`end_year`,`created_by`, `created_on`) VALUES (default,'".$investorvalArray."','".$checkboxName."','".$filtername."','".$filterType."','".$filterDesc."','".$companytype."','".$companyName."','".$industry."','".$city."','".$state."','".$region."','".$exitStatus."','".$round."','".$stage."','".$investorType."','".$dealType."','".$Intype."','".$filter_active."','".$query."','".$vi_filter."','".$startDate."','".$startYear."','".$endDate."','".$endYear."','".$dlogUserEmail."',CURDATE())";
            
            }
          
           //echo "query = $query";exit(); // for debugging purposes, remove this once it is working
           mysql_query($query) or die(mysql_error());
            
   }
   else if($_POST['mode'] == 'D')
   {
        $filtername = $_POST['filterName'];
        
        $sql="Delete from saved_filter where  id='$filtername'";
        
        mysql_query($sql) or die(mysql_error());
   
   
   }
   
   else if($_POST['mode'] == 'E')
   {
        $filtername = $_POST['filterName'];

        $sql="SELECT `investor_name` FROM `saved_filter` where id='".$filtername."' ";

        $sqlSelResult = mysql_query($sql) or die(mysql_error());

        while ($row = mysql_fetch_assoc($sqlSelResult)) {

               if($row['investor_name'] != ""){
                    $investor_id= $row['investor_name']  ;

               }else{
                    $sql="SELECT `InvestorId` FROM `peinvestors`";

                    $sqlSelResult = mysql_query($sql) or die(mysql_error());

                    while ($row = mysql_fetch_assoc($sqlSelResult)) {
               
                         $investor_id= $row['InvestorId']  ;
                              
                    }
               }
        }

        $inv_investor_id=explode(',',$investor_id);

     //    echo '<pre>';  print_r( $inv_investor_id);   echo '</pre>'; exit;

        
        $returndata=array();
        $InvestorArray=array();
        if(isset($inv_investor_id))
        {
        $sqlquery='SELECT * FROM `peinvestors`,`saved_filter` WHERE `InvestorId` IN ("'. implode('","', $inv_investor_id) .'") and id="'. $filtername.'"';

     //    echo $sqlquery;exit();

        $sqllResultquery = mysql_query($sqlquery) or die(mysql_error());
        
        while ($row = mysql_fetch_assoc($sqllResultquery)) {
        
        array_push($InvestorArray,$row);
        }
        //$InvestorArray=$filtername;
        echo json_encode($InvestorArray);exit();
        //$returndata["data"] = $InvestorArray;
   
   
   }
   
   
   }
   
   else if($_POST['mode'] == 'export')
   {
   $filterNameId = $_POST['filterNameId'];
   $filtername = $_POST['filterName'];
   $filterType =$_POST['filterType'];
   $companyName=$_POST['companyName'];

   // echo $filterType;exit();
     //    if($filtername != "")
     //    {
     //    $query="INSERT INTO `advance_export_filter_log`(`id`, `name`, `filter_name`, `filter_type`,`company_name`,`created_date`)VALUES (default,'".$username."','".$filtername."','".$filterType."','".$companyName."',NOW())";
     //    $queryResult = mysql_query($query) or die(mysql_error());
     //    }
     //    else
     //    {
     //    $query="INSERT INTO `advance_export_filter_log`(`id`, `name`, `filter_name`, `filter_type`,`company_name`,`created_date`)VALUES (default,'".$username."','anonymous','".$filterType."','".$companyName."',NOW())";
     //    //echo $query;exit();
     //    $queryResult = mysql_query($query) or die(mysql_error());
     //    }
   //echo $queryResult;exit();

   $sql="SELECT `investor_name` FROM `saved_filter` where id='".$filterNameId."' ";
   $sqlSelResult = mysql_query($sql) or die(mysql_error());
   
     //    while ($row = mysql_fetch_assoc($sqlSelResult)) {
     
     //    $investor_id= $row['investor_name']  ;
     
     //    }


   while ($row = mysql_fetch_assoc($sqlSelResult)) {

          if($row['investor_name'] != ""){
               $investor_id= $row['investor_name']  ;

          }else{
               $sql="SELECT `InvestorId` FROM `peinvestors`";

               $sqlSelResult = mysql_query($sql) or die(mysql_error());

               while ($row = mysql_fetch_assoc($sqlSelResult)) {
          
                    $investor_id= $row['InvestorId']  ;
                         
               }
          }
     }




   
   $inv_investor_id=explode(',',$investor_id);
   
   $InvestorArray=array();
   if(isset($inv_investor_id))
   {
   $sqlquery='SELECT * FROM `peinvestors`,`saved_filter` WHERE `InvestorId` IN ("'. implode('","', $inv_investor_id) .'") and id="'. $filterNameId.'"';
//    echo $sqlquery;exit();
   $sqllResultquery = mysql_query($sqlquery) or die(mysql_error());
   
   while ($row = mysql_fetch_assoc($sqllResultquery)) {
   
   array_push($InvestorArray,$row);
   }
   echo json_encode($InvestorArray);exit();
   
   
   }
   
   
   }
   
   else if($_POST['mode'] == 'getInvestorId')
   {
   $investor_id = $_POST['investorName'];
   $type = $_POST['type'];
     //    echo $investor_id;exit();
     // echo $type; exit();
   $inv_investor_id=explode(',',$investor_id);

     // echo '<pre>'; print_r($inv_investor_id); echo '</pre>'; exit;

   $InvestorArray=array();
   if(isset($inv_investor_id))
   {
     // SELECT DISTINCT inv.* FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, stage AS s WHERE pe.PECompanyId = pec.PEcompanyId 
     // AND inv.InvestorId = peinv.InvestorId 
     // AND pe.Deleted=0 
     // AND inv.`Investor` IN ("2 AM Ventures","8i Ventures","ABC World Asia","ADQ","Ananta Capital","Antara Capital","Antler India","Aroa Ventures","Augment Infrastructure","Blue Ashva Capital","Blue Impact Ventures","Cactus Venture Partners","Comvest Partners","Copenhagen Infrastructure Partners","Corinth Group","D1 Capital Partners","Eight Road Ventures","Exor","Good Fashion Fund","Griffin Gaming Partners","GrowthStory","GSV Ventures","M Venture Partners","N+1 Capital","Novo Tellus","Potencia Ventures","Starfish Growth Partners","Valar Ventures") order by inv.Investor

        if($type="Investments"){
          // $sqlquery='SELECT DISTINCT inv.*
          // FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, stage AS s
          // WHERE pe.PECompanyId = pec.PEcompanyId
          // AND s.StageId = pe.StageId
          // AND pec.industry !=15
          // AND peinv.PEId = pe.PEId
          // AND inv.InvestorId = peinv.InvestorId
          // AND pe.Deleted=0 AND inv.`Investor` IN ("'. implode('","', $inv_investor_id) .'") order by inv.Investor';


          $sqlquery='SELECT DISTINCT inv.*
          FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, stage AS s
          WHERE pe.PECompanyId = pec.PEcompanyId
          AND peinv.PEId = pe.PEId
          AND inv.InvestorId = peinv.InvestorId
          AND pe.Deleted=0 AND inv.`Investor` IN ("'. implode('","', $inv_investor_id) .'") order by inv.Investor';

        }else{
          $sqlquery='SELECT  DISTINCT inv.* 
          FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv
          WHERE pe.PECompanyId = pec.PEcompanyId
          AND pec.industry !=15
          AND peinv.MandAId = pe.MandAId
          AND inv.InvestorId = peinv.InvestorId
          AND pe.Deleted=0 and inv.Investor IN ("'. implode('","', $inv_investor_id) .'") order by inv.Investor';    
        }
//    echo $sqlquery;exit();
   $sqllResultquery = mysql_query($sqlquery) or die(mysql_error());
   
   while ($row = mysql_fetch_assoc($sqllResultquery)) {
   
   array_push($InvestorArray,$row);
   }
   echo json_encode($InvestorArray);exit();
   }
   }
   
   else if($_POST['mode'] == 'adminExport')
   {
        $filterNameId=$_POST['filterid'];
     $filtername = $_POST['filterName'];
     $filterType =$_POST['filterType'];
     // echo $filterType;exit();
     // if($filtername != "")
     // {
     // $query="INSERT INTO `advance_export_filter_log`(`id`, `name`, `filter_name`, `filter_type`,`created_date`)VALUES (default,'".$username."','".$filtername."','".$filterType."',NOW())";
     // $queryResult = mysql_query($query) or die(mysql_error());
     // }
     // else
     // {
     // $query="INSERT INTO `advance_export_filter_log`(`id`, `name`, `filter_name`, `filter_type`,`created_date`)VALUES (default,'".$username."','anonymous','".$filterType."',NOW())";
     // //echo $query;exit();
     // $queryResult = mysql_query($query) or die(mysql_error());
     // }
    $InvestorArray=array();

    $sqlquery='SELECT * FROM `saved_filter` WHERE id="'.$filterNameId.'"';
    //echo $sqlquery;exit();
    $sqllResultquery = mysql_query($sqlquery) or die(mysql_error());

    while ($row = mysql_fetch_assoc($sqllResultquery)) {
   
        array_push($InvestorArray,$row);
        }
        echo json_encode($InvestorArray);exit();
        
   }

   elseif($_POST['mode'] == 'getData')
   {
     $filtername = $_POST['filtername'];
     $getTypeMode=$_POST['getTypeMode'];
     $editfiltername=$_POST['editfiltername'];
     if( $getTypeMode == 'A')
     {
        $sql="SELECT filter_name FROM `saved_filter` ";
        //echo $sql;exit();
        $query = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_assoc($query)) {
          if($row['filter_name'] == $filtername)
          {
               echo 'failure';
               return;
          }

         
        }
     }
     elseif( $getTypeMode == 'E')
     {
          // echo 'Hi'; exit;
          // echo $editfiltername; exit;

          if($filtername != $editfiltername)
          {
               $sql="SELECT filter_name FROM `saved_filter` where filter_name='".$filtername."'";
               //echo $sql;exit();
               $query = mysql_query($sql) or die(mysql_error());
               while ($row = mysql_fetch_assoc($query)) {
                 if($row['filter_name'] == $filtername)
                 {
                      echo 'failure';
                      return;
                 }
                 else{
                     echo 'success';
                 }
               }
          }
          else
          {
               echo 'success';
          }
     }

   }

   
   ?>