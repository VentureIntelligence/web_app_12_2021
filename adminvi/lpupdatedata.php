<?php include_once("../globalconfig.php"); ?>
<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();

session_save_path("/tmp");
session_start();
//echo '<pre>';
//print_r($_POST);
//echo '</pre>';
if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
{
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Update Investment data : : Contact TSJ Media : :</title>

<SCRIPT LANGUAGE="JavaScript">

</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
<form name="peupdatedata" method=post action="peupdatedata.php">

<p > <b><center> <font style="font-family: Verdana; font-size: 10pt">Investement deal list</font> </b></center></p>
<p></p><p></p>
<table width=60% align=center border=1 cellpadding=2>

<?php
        $LPIdtoUpdate = $_POST['txtLPId'];
        $institution = $_POST['txtinstitutionname'];
              $contactperson = $_POST['txtcontactperson'];
                            $designation = $_POST['txtdesignation'];
              $email= $_POST['txtemail'];  //industry id directly
              $address1=$_POST['txtaddress1'];
              $address2=$_POST['txtaddress2'];
              $city=ucfirst($_POST['citysearch']);
              $pincode= $_POST['txtpincode'];
              $countryIdtoUpdate= $_POST['txtstate'];
              $country='';
              $countrySql = "select countryid,country from country where countryid='".$countryIdtoUpdate."'";
              //echo $countrySql;

                                if ($staters = mysql_query($countrySql))
                                                        {
                                                          $state_cnt = mysql_num_rows($staters);
                                                        }
                                                        if($state_cnt > 0)
                                                        {
                                                            $myrow=mysql_fetch_row($staters, MYSQL_BOTH);
                                                            {
                                                              $id = $myrow[0];
                                                                $name = $myrow[1];
                                                                $country = $name;
                                                            }
                                                        } 
              $phone=$_POST['txtphone'];
              $fax=$_POST['txtfax'];
              $website=$_POST['txtwebsite'];
              $typeofinstitution=$_POST['txttypeofinstitution'];
              $institution=trim($institution);
              $contactperson =trim($contactperson);
              $address1 =trim($address1);  
              $address2 = trim($address2);
            //
      

      //echo "<br>company update Query-- " .$UpdatecompanySql;
      
        
          // $UpdateInvestmentSql="update limited_partners set InstitutionName='$institution',ContactPerson='$contactperson',Designation='$designation', Email='$email',Address1='$address1', Address2='$address2',City='$city',PinCode='$pincode',
          // Country='$country',Phone='$phone',Fax='$fax',Website='$website',TypeOfInstitution='$typeofinstitution' where LPId=$LPIdtoUpdate";
          $UpdateInvestmentSql="update limited_partners set InstitutionName='".addslashes($institution)."',ContactPerson='".addslashes($contactperson)."',Designation='$designation', Email='$email',Address1='".addslashes($address1)."', Address2='".addslashes($address2)."',City='$city',PinCode='$pincode',
          Country='$country',Phone='$phone',Fax='$fax',Website='$website',TypeOfInstitution='$typeofinstitution' where LPId=$LPIdtoUpdate";
           // echo "<br>Existing file--**-- " .$UpdateInvestmentSql;
          
          

               
        
       
        //exit();
                               // echo $UpdateInvestmentSql;
                                

        if($updatersinvestment=mysql_query($UpdateInvestmentSql))
          {
           
            echo "<br>LP Directory UPDATED";
           }


        ?>
        <tr><td>
         <font style="font-family: Verdana; font-size: 8pt"> Directory has been updated</font>

        </td></tr>

</table>



<?php

} // if resgistered loop ends
else
  header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>
</form>
</body></html>
<?php
/* function to insert the advisor_cias table */
function insert_get_CIAs($cianame,$adType)
{
  $cianame=trim($cianame);
  $dbcialink = new dbInvestments();
  $getInvestorIdSql = "select CIAId,AdvisorType from advisor_cias where cianame like '$cianame%'";
  echo "<br>select--" .$getInvestorIdSql;
  if ($rsgetInvestorId=mysql_query($getInvestorIdSql))
  {

    $investor_cnt=mysql_num_rows($rsgetInvestorId);
    //echo "<br>Advisor cia table count-- " .$investor_cnt;
    if ($investor_cnt==0)
    {
        //insert acquirer
        $insAcquirerSql="insert into advisor_cias(cianame,AdvisorType) values('$cianame','$adType')";
        if($rsInsAcquirer = mysql_query($insAcquirerSql))
        {
          $AdInvestorId=0;
          return $AdInvestorId;
        }
    }
    elseif($investor_cnt>=1)
    {
                    While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
      {
        $AdInvestorId = $myrow[0];
        //echo "<bR>&&&&".$AdInvestorId;
        $adtypestr=$myrow[1];
        echo "<br>Id - ".$AdInvestorId ." - " .$adtypestr;
        if($adtypestr!=$adType)
        {
                $updateAdTypeSql="Update advisor_cias set AdvisorType='$adType' where CIAId=$AdInvestorId";
                //echo "<Br>^^^".$updatAdTypeSql;
                if($rsupdate=mysql_query($updateAdTypeSql))
                {
                                    }
                                }
        return $AdInvestorId;
      }
    }
  }
  $dbcialink.close();
}


//function to get RegionId
  function return_insert_get_RegionId($region)
  {
    $dbregionlink = new dbInvestments();
    $getRegionIdSql = "select RegionId from region where region like '$region%'";
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
  function return_insert_get_Investor($investor)
  {
    $investor=trim($investor);
    $investor=ltrim($investor);
    $investor=rtrim($investor);
    $dblink = new dbInvestments();
    $getInvestorIdSql = "select InvestorId from peinvestors where Investor = '$investor'";
    //echo "<br>select--" .$getInvestorIdSql;
    if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
    {
      $investor_cnt=mysql_num_rows($rsgetInvestorId);
      //echo "<br>Investor count-- " .$investor_cnt;
      if ($investor_cnt==0)
      {
          //echo "<br>----insert Investor ";
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
          //echo "<br>Return investor id--" .$invId;
          return $InvestorId;
        }
      }
    }
    $dblink.close();
  }
  function insert_mainsector($mainsector,$industryIdtoUpdate)
  {
    $dbpemainsector = new dbInvestments();
    $peMainSectorSql= "select sector_id from pe_sectors where sector_name = '$mainsector' AND industry=$industryIdtoUpdate";
    if($getPEMainSector = mysql_query($peMainSectorSql))
    {
      $mainsector_count=mysql_num_rows($getPEMainSector);
      if($mainsector_count==0)
      {
        $insMainSectorSql="insert into pe_sectors(sector_name,industry) values('$mainsector',$industryIdtoUpdate)";
        if($rsinsdealmainsector = mysql_query($insMainSectorSql))
        {
          $mainsectorid=0;
          return $mainsectorid;
                   
          
        }
      }
      elseif($mainsector_count>=1)
      {
        While($myrow=mysql_fetch_array($getPEMainSector, MYSQL_BOTH))
        {
          $mainsectorid = $myrow[0];
          return $mainsectorid;
        }
      }

    }
    $dbpemainsector.closeDB();

  }
  function insert_subsector($sectorId,$companyIdtoUpdate,$subsectorname,$addsubsectorname){
            
            $subsectorname=trim($subsectorname);
            $dbslinkss = new dbInvestments();
            $getsectorIdSql="select subsector_id from pe_subsectors where subsector_name='$subsectorname' AND sector_id=$sectorId AND PECompanyId=$companyIdtoUpdate";
            
            if($rsgetsector=mysql_query($getsectorIdSql))
            {
                $sector_cnt=mysql_num_rows($rsgetsector);
               
                if($sector_cnt==0)
                {
                    //insert deal ..mostly it wont get inserted as new..only standard 9 stages already exists
                    $inssectorIdSql ="insert into pe_subsectors(sector_id,PECompanyId,subsector_name,Additional_subsector) values($sectorId,$companyIdtoUpdate,'$subsectorname','$addsubsectorname')";
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
?>