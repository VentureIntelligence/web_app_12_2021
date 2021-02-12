<?php include_once("../globalconfig.php"); ?>
<?php
   require("../dbconnectvi.php");
   $Db = new dbInvestments();
   $dlogUserEmail = $_SESSION['UserEmail'];
   //echo $dlogUserEmail;exit();
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
            
            $companytype = $_POST['companytype'];
            $industry=implode(",",$_POST['Industry']);
            $dealType=implode(",",$_POST['dealType']);
            $Intype=$_POST['Intype'];
            
            $city=implode(",",$_POST['city']);
            $state=implode(",",$_POST['state']);
            $region=implode(",",$_POST['region']);
            $round=implode(",",$_POST['round']);
            $stage=implode(",",$_POST['stage']);
            $investorType=$_POST['investorType'];
            $filterType=$_POST['filterType'];
            
            $filterQuery=$_POST['filterQuery'];
            $filter_active=$_POST['filter_active'];
            $vi_filter=$_POST['vi_filter'];
            
            //echo $filterType;exit();
            if($filterType == "Exit")
            {
            $exitStatus=$_POST['exitStatus'];
            }
            else{
            $exitStatus=implode(",",$_POST['exitStatus']);
            }
            //echo json_encode($_POST['state']);exit();
            $sqlSelCount = "SELECT *  FROM `saved_filter` WHERE `filter_name` = '" . $EditFilter . "' ";
            //echo $sqlSelCount;exit();
            $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
            $rowSelCount = mysql_num_rows($sqlSelResult);
            //echo $rowSelCount;exit();
            if($rowSelCount > 0)
            {
            $query = "UPDATE `saved_filter` SET `filter_active`='".$filter_active."',`query`='".$filterQuery."',`vi_filter`='".$vi_filter."',`dealtype`='".$dealType."',`intype`='".$Intype."',`company_type`='".$companytype."',`industry`='".$industry."',`city`='".$city."',`state` ='".$state."',`region` ='".$region."',`exit_status` ='".$exitStatus."',`round`='".$round."',`stage`='".$stage."',`investor_type`='".$investorType."',`filter_name`='".$filtername."',`filter_desc`='".$filterDesc."',`investor_name`='" . $investorvalArray . "',`column_name`='" . $checkboxName . "',`modefied_by`='" . $dlogUserEmail . "',`modefied_on`=CURDATE()  WHERE `filter_name` = '" . $EditFilter . "' ";
            // echo $filtername;
            }
            else
            {
            $query = "INSERT INTO `saved_filter`(`id`, `investor_name`, `column_name`, `filter_name`,`filter_type`,`filter_desc`,`company_type`,`industry`,`city`,`state`,`region`,`exit_status`,`round`,`stage`,`investor_type`,`dealtype`,`intype`,`filter_active`,`query`,`vi_filter`,`created_by`, `created_on`) VALUES (default,'".$investorvalArray."','".$checkboxName."','".$filtername."','".$filterType."','".$filterDesc."','".$companytype."','".$industry."','".$city."','".$state."','".$region."','".$exitStatus."','".$round."','".$stage."','".$investorType."','".$dealType."','".$Intype."','".$filter_active."','".$query."','".$vi_filter."','".$dlogUserEmail."',CURDATE())";
            
            }
            //echo "query = $query";exit(); // for debugging purposes, remove this once it is working
            mysql_query($query) or die(mysql_error());
            
   }
   else if($_POST['mode'] == 'D')
   {
        $filtername = $_POST['filterName'];
        
        $sql="Delete from saved_filter where  filter_name='$filtername'";
        
        mysql_query($sql) or die(mysql_error());
   
   
   }
   
   else if($_POST['mode'] == 'E')
   {
        $filtername = $_POST['filterName'];
        $sql="SELECT `investor_name` FROM `saved_filter` where filter_name='".$filtername."' ";
        $sqlSelResult = mysql_query($sql) or die(mysql_error());
        
        while ($row = mysql_fetch_assoc($sqlSelResult)) {
        
        $investor_id= $row['investor_name']  ;
   
             
    }

        $inv_investor_id=explode(',',$investor_id);
        
        $returndata=array();
        $InvestorArray=array();
        if(isset($inv_investor_id))
        {
        $sqlquery='SELECT * FROM `peinvestors`,`saved_filter` WHERE `Investor` IN ("'. implode('","', $inv_investor_id) .'") and filter_name="'. $filtername.'"';
        // echo $sqlquery;exit();
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
   $filtername = $_POST['filterName'];
   $filterType =$_POST['filterType'];
   // echo $filterType;exit();
   if($filtername != "")
   {
   $query="INSERT INTO `advance_export_filter_log`(`id`, `name`, `filter_name`, `filter_type`,`created_date`)VALUES (default,'vijay','".$filtername."','".$filterType."',NOW())";
   $queryResult = mysql_query($query) or die(mysql_error());
   }
   else
   {
   $query="INSERT INTO `advance_export_filter_log`(`id`, `name`, `filter_name`, `filter_type`,`created_date`)VALUES (default,'vijay','anonymous','".$filterType."',NOW())";
   //echo $query;exit();
   $queryResult = mysql_query($query) or die(mysql_error());
   }
   //echo $queryResult;exit();
   $sql="SELECT `investor_name` FROM `saved_filter` where filter_name='".$filtername."' ";
   $sqlSelResult = mysql_query($sql) or die(mysql_error());
   
   while ($row = mysql_fetch_assoc($sqlSelResult)) {
   
   $investor_id= $row['investor_name']  ;
   
   }
   $inv_investor_id=explode(',',$investor_id);
   
   $InvestorArray=array();
   if(isset($inv_investor_id))
   {
   $sqlquery='SELECT * FROM `peinvestors`,`saved_filter` WHERE `Investor` IN ("'. implode('","', $inv_investor_id) .'") and filter_name="'. $filtername.'"';
   // echo $sqlquery;exit();
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
   //echo $investor_id;exit();
   $inv_investor_id=explode(',',$investor_id);
   
   $InvestorArray=array();
   if(isset($inv_investor_id))
   {
   $sqlquery='SELECT * FROM `peinvestors` WHERE `Investor` IN ("'. implode('","', $inv_investor_id) .'")';
   //echo $sqlquery;exit();
   $sqllResultquery = mysql_query($sqlquery) or die(mysql_error());
   
   while ($row = mysql_fetch_assoc($sqllResultquery)) {
   
   array_push($InvestorArray,$row);
   }
   echo json_encode($InvestorArray);exit();
   }
   }
   
   else if($_POST['mode'] == 'adminExport')
   {
    $InvestorArray=array();

    $sqlquery='SELECT * FROM `saved_filter` WHERE id="'.$_POST['filterid'].'"';
    //echo $sqlquery;exit();
    $sqllResultquery = mysql_query($sqlquery) or die(mysql_error());

    while ($row = mysql_fetch_assoc($sqllResultquery)) {
   
        array_push($InvestorArray,$row);
        }
        echo json_encode($InvestorArray);exit();
        
   }
   
   ?>