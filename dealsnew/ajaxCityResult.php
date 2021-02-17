<?php
    
    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
    $VCFlagValue=$_REQUEST['vcflag'];
    $stateval=$_REQUEST['state'];
    //print_r($stateval);exit();
    if(!isset($_SESSION['UserNames']))
    {
            header('Location:../pelogin.php');
    }
    else
    {
    if($VCFlagValue == 4){
        $dbtype="and peinvestments_dbtypes.DBTypeId='CT'";
    }elseif($VCFlagValue == 5){
        $dbtype="and peinvestments_dbtypes.DBTypeId='IF'"; 
    }
    elseif($VCFlagValue == 3){
        $dbtype="and peinvestments_dbtypes.DBTypeId='SV'";
    }
    if($stateval!=""){
        $string = implode(',', $stateval);
       
      if($VCFlagValue == 0 || $VCFlagValue ==1)

        {
            $getcitySql=" SELECT DISTINCT city.city_id,city.city_name from city,pecompanies,peinvestments where pecompanies.PEcompanyID = peinvestments.PECompanyID and pecompanies.city=city.city_name and city.city_name!='' and city.city_name!='Not Identified - City' and city.city_name!='undefined' and city.city_StateID_FK IN (".$string.") ORDER BY city.city_name ASC  ";
        }
        else{
            $getcitySql = " SELECT DISTINCT city.city_id,city.city_name from city,pecompanies,peinvestments,peinvestments_dbtypes where pecompanies.PEcompanyID = peinvestments.PECompanyID and pecompanies.city=city.city_name and city.city_name!='' and city.city_name!='Not Identified - City' and city.city_name!='undefined' and city.city_StateID_FK IN (".$string.") and peinvestments_dbtypes.PEId=peinvestments.PEId ".$dbtype."  ORDER BY city.city_name ASC  ";
        }
    }else{
            if($VCFlagValue==0 || $VCFlagValue == 1)
            {
                 $getcitySql=" SELECT DISTINCT city.city_id,city.city_name from city,pecompanies,peinvestments where pecompanies.PEcompanyID = peinvestments.PECompanyID and pecompanies.city=city.city_name and city.city_name!='' and city.city_name!='Not Identified - City' and city.city_name!='undefined' ORDER BY city.city_name ASC  ";
            }
            else{
                $getcitySql = " SELECT DISTINCT city.city_id,city.city_name from city,pecompanies,peinvestments,peinvestments_dbtypes where pecompanies.PEcompanyID = peinvestments.PECompanyID and pecompanies.city=city.city_name and city.city_name!='' and city.city_name!='Not Identified - City' and city.city_name!='undefined' and peinvestments_dbtypes.PEId=peinvestments.PEId ".$dbtype."  ORDER BY city.city_name ASC   ";
            }
        }
    
    /*echo $getcitySql;
    exit();*/
    $jsonarray=array();

    if ($rscity = mysql_query($getcitySql))
    {
        While($myrow=mysql_fetch_array($rscity, MYSQL_BOTH))
        {
            //print_r($myrow);
            $cityId=$myrow["city_id"];
            $cityName=trim($myrow["city_name"]);
            $cityNamelower=ucwords(strtolower($cityName));

            $jsonarray[]=array('id'=>$cityId,'label'=>$cityName,'value'=>$cityNamelower);

        }
    }
    
    echo json_encode($jsonarray);
}       
               
?>
