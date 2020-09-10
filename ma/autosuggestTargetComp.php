<?php
require_once("../dbconnectvi.php");//including database connectivity file
$Db = new dbInvestments();

$searchTerm = $_REQUEST['queryString'];
$jsonarray=array();
if($_SESSION['MA_industries']!=''){

    $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['MA_industries'].') ';
}
if ($searchTerm!=''){
    $companysql_search="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business FROM mama AS pe, industry AS i, pecompanies AS pec";
    $companysql_search.=" WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 $comp_industry_id_where and pec.companyname like '%".$searchTerm."%' order by pec.companyname";

    $searchString="Undisclosed";
    $searchString=strtolower($searchString);

    $searchString1="Unknown";
    $searchString1=strtolower($searchString1);

    $searchString2="Others";
    $searchString2=strtolower($searchString2);

    if ($rsinvestors = mysql_query($companysql_search) or die(mysql_error()))
    {    
            While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
            {
                    $companyname=trim($myrow["companyname"]);
                    $companyname=strtolower($companyname);

                    $invResult=substr_count($companyname,$searchString);
                    $invResult1=substr_count($companyname,$searchString1);
                    $invResult2=substr_count($companyname,$searchString2);

                    if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                    {
                            $compName = $myrow["companyname"];
                            $compid = $myrow["PECompanyId"];
                           // $isselected = (trim($_POST['companysearch'])==trim($compName)) ? 'SELECTED' : '';
                           // echo '<OPTION value="'.$compName.'" '.$isselected.'>'.$compName.'</OPTION> \n';
                           //$totalCount=$totalCount+1;

                           $jsonarray[]=array('companyname'=>addslashes($compName),'companyid'=>addslashes($compid)); 
                    }

            }
    }
}
echo json_encode($jsonarray);
mysql_close();