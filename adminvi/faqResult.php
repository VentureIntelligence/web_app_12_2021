<?php
    
    require("../dbconnectvi.php");
    $Db = new dbInvestments();
    $dbtype=$_REQUEST['dbtype'];
    //print_r($dbtype);exit();
    
            if(trim($dbtype)!="")
            {
                $nanoSql="select * from faq where DBtype='$dbtype' and status='0' ORDER BY faq_order_no ASC";
            }
            else{
                $nanoSql="select * from faq where status='0' ORDER BY faq_order_no ASC";
            }
   /* echo $nanoSql;
    exit();*/
    $jsonarray=array();

    if ($rsfaq = mysql_query($nanoSql))
    {
        While($myrow=mysql_fetch_array($rsfaq, MYSQL_BOTH))
        {
            //print_r($myrow);
            $faqId=$myrow["id"];
            $faqQues=trim($myrow["question"]);
            $faqdbtype=trim($myrow["DBtype"]); 
			$faqAnswer=trim($myrow["answer"]); 
            $jsonarray[]=array('id'=>$faqId,'question'=>$faqQues,'dbtype'=>$faqdbtype,'answer'=>$faqAnswer);

        }
    }
    
    echo json_encode($jsonarray);
            
               
?>
