<?php
require_once("../dbconnectvi.php");//including database connectivity file
$Db = new dbInvestments();
include ('machecklogin.php');
$searchTerm = $_REQUEST['queryString'];
$jsonarray=array();

if ($searchTerm!=''){
    $sectorsql_search="SELECT distinct sector_business FROM mama AS pe, industry AS i, pecompanies AS pec";
    $sectorsql_search .= " WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 AND pec.industry IN (".$_SESSION['MA_industries'].") and sector_business like '".$searchTerm."%'  order by pec.companyname"; 

    $searchString="Undisclosed";
    $searchString=strtolower($searchString);

    $searchString1="Unknown";
    $searchString1=strtolower($searchString1);

    $searchString2="Others";
    $searchString2=strtolower($searchString2);
    mysql_query('SET CHARACTER SET utf8');
    if ($rssector = mysql_query($sectorsql_search) or die(mysql_error()))
    {   
        $temp_array=array();
            While($myrow=mysql_fetch_array($rssector, MYSQL_BOTH))
            {
                    $sectorname=trim($myrow["sector_business"]);
                    $sectorname=strtolower($sectorname);

                    $invResult=substr_count($sectorname,$searchString);
                    $invResult1=substr_count($sectorname,$searchString1);
                    $invResult2=substr_count($sectorname,$searchString2);
                    

                    if(($invResult==0) && ($invResult1==0) && ($invResult2==0) && ($sectorname!="") && ($sectorname!= null) && ($sectorname!= 'null'))
                    {
                            //$sectorName = $myrow["sector_business"];
                            
                                            $sector = trim($myrow["sector_business"]);
                                            $pos = strpos($sector, '(');

                                            if ($pos == false) {
                                                $sectorName = $sector;                                        
                                            } else {
                                                $sectorName = substr_replace($sector, '', $pos);

                                            }
                                            
                                            $sectorName = trim($sectorName);

                                                if (in_array($sectorName, $temp_array)) {
                                                    continue;
                                                }
                                                $temp_array[] = $sectorName;
                                                
                            $jsonarray[]=array('sectorname'=> $sectorName); 
                            //$isselected = (trim($_POST['sectorsearch']) == trim($sectorName)) ? 'SELECTED' : ' ';
                            //echo '<OPTION value='.$sectorName.' '.$isselected.'>'.$sectorName.'</OPTION> \n';
                            //$totalCount=$totalCount+1;
                    }
            }
    }
}

echo json_encode($jsonarray);
mysql_close();
