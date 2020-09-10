<?php
    require_once("../dbconnectvi.php");//including database connectivity file
    $Db = new dbInvestments();

    $searchTerm = $_REQUEST['queryString'];
    $jsonarray=array();

    if ($searchTerm!=''){
  

    $addVCFlagqry="";
    $pagetitle="Angel Investments - Investors";
    
   $getIncubatorsSql="SELECT DISTINCT pe.IncubatorId, inc.Incubator
				FROM incubatordeals AS pe,  incubators as inc
				WHERE inc.IncubatorId=pe.IncubatorId and pe.Deleted=0 and inc.Incubator!='' and inc.Incubator like '".$searchTerm."%'
				 order by inc.Incubator ";
    
 
            /* populating the investortype from the investortype table */
			$searchString="Undisclosed";
			$searchString=strtolower($searchString);
		
			$searchString1="Unknown";
			$searchString1=strtolower($searchString1);
		
			$searchString2="Others";
			$searchString2=strtolower($searchString2);
			
            
				
            if ($rsinvestors = mysql_query($getIncubatorsSql)){
               $investor_cnt = mysql_num_rows($rsinvestors);
            }
			
            if($investor_cnt >0){
             	 While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH)){
                	$Investorname=trim($myrow["Incubator"]);
                        $Investorname=strtolower($Investorname);

                        $invResult=substr_count($Investorname,$searchString);
                        $invResult1=substr_count($Investorname,$searchString1);
                        $invResult2=substr_count($Investorname,$searchString2);

                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                        {
                                $investor = $myrow["Incubator"];
                                $investorId = $myrow["IncubatorId"];
                                 $jsonarray[]=array('investor'=>addslashes($investor),'investorid'=>$investorId);
                                //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                //$isselcted = (trim($_POST['keywordsearch'])==trim($investor)) ? 'SELECTED' : '';
                                //echo "<OPTION value='".$investor."' ".$isselcted.">".$investor."</OPTION> \n";
                        }
            	}
                mysql_free_result($invtypers);
        }   
 
    	
       
    }
    
    echo json_encode($jsonarray);
    

    ?>