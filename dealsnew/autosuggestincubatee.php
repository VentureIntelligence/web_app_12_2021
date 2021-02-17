<?php
    require_once("../dbconnectvi.php");//including database connectivity file
    $Db = new dbInvestments();
    if(!isset($_SESSION['UserNames']))
    {
             header('Location:../pelogin.php');
    }
    else
    {  
    $searchTerm = $_REQUEST['queryString'];
    $jsonarray=array();

    if ($searchTerm!=''){
        
        $addVCFlagqry="";
        $pagetitle="Angel-backed Companies";
        $pagetitle="Incubatee(s)";
        $getcompaniesSql="SELECT DISTINCT pe.IncubateeId, pec. *
            FROM pecompanies AS pec, incubatordeals AS pe,industry as i
            WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry
             and pe.Deleted=0 and pec.industry!=15 and pec.companyname like '".$searchTerm."%'
            ORDER BY pec.companyname";


        if ($rsinvestors = mysql_query($getcompaniesSql))
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
                                $companyId=$myrow["PECompanyId"];
                                 
                                $jsonarray[]=array('compName'=>addslashes($compName),'companyid'=>$companyId);
                                //$isselected = (trim($_POST['companysearch'])==trim($compName)) ? 'SELECTED' : '';
                                //echo '<OPTION value="'.$compName.'" '.$isselected.'>'.$compName.'</OPTION> \n';
                                //$totalCount=$totalCount+1;
                        }

                }
        }
    	
       
    }
    
    echo json_encode($jsonarray);
}
    ?>