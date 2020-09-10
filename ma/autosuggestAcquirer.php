<?php
    require_once("../dbconnectvi.php");//including database connectivity file
    $Db = new dbInvestments();

    $searchTerm = $_REQUEST['queryString'];
    $jsonarray=array();

    if ($searchTerm!=''){

	$acquirersql="SELECT distinct peinv.AcquirerId, ac.Acquirer FROM acquirers AS ac, mama AS peinv WHERE ac.AcquirerId = peinv.AcquirerId and peinv.Deleted=0 AND ac.industryId IN (".$_SESSION['MA_industries'].") and ac.Acquirer like '%".$searchTerm."%' order by Acquirer";

        /* populating the investortype from the investortype table */
        $searchString="Undisclosed";
        $searchString=strtolower($searchString);

        $searchString1="Unknown";
        $searchString1=strtolower($searchString1);

        $searchString2="Others";
        $searchString2=strtolower($searchString2);
        
        if ($rsacquire = mysql_query($acquirersql))
        {
             $acquire_cnt = mysql_num_rows($rsacquire);
	}

        if($acquire_cnt >0){
            While($myrow=mysql_fetch_array($rsacquire, MYSQL_BOTH))
            {
                    $adviosrname=trim($myrow["Acquirer"]);
                    $adviosrname=strtolower($adviosrname);

                    $invResult=substr_count($adviosrname,$searchString,0);
                    $invResult1=substr_count($adviosrname,$searchString1,0);
                    //echo "ddddddddddddd".$invResult2=strcasecmp($adviosrname,$searchString2);
                    $invResult2=($adviosrname == $searchString2) ? 1 : 0;

                    if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                    {
                        $ladvisor = $myrow["Acquirer"];
                        $ladvisorid = $myrow["AcquirerId"];
                        $jsonarray[]=array('ladvisor'=>addslashes($ladvisor),'ladvisorid'=>$ladvisorid);
                        
                        //echo "<OPTION value=".$ladvisorid.">".$ladvisor."</OPTION> \n";
                        //$isselcted = (trim($_POST['keywordsearch'])==trim($ladvisor)) ? 'SELECTED' : '';
                        //echo "<OPTION value='".$ladvisor."'>".$ladvisor."</OPTION> \n";
                    }
            }
                    mysql_free_result($rsadvisor);
        }
    }
    
    echo json_encode($jsonarray);
    mysql_close();