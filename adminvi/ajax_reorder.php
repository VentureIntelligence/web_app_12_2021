<?php
    
    require("../dbconnectvi.php");
    $Db = new dbInvestments();
	
	//$dbtype=$_REQUEST['dbtype'];
	
	
	//echo $_POST["post_order_ids"];
	
	// exit;
	//print_r($_REQUEST["post_order_ids"]);
	
	$post_order = isset($_REQUEST["post_order_ids"]) ? $_REQUEST["post_order_ids"] : [];
	if(count($post_order)>0){
	
	 for($order_no= 0; $order_no < count($post_order); $order_no++)
	{
	 $query = "UPDATE faq SET faq_order_no = '".($order_no+1)."' WHERE id = '".$post_order[$order_no]."'";
	//$query = "UPDATE faq SET faq_order_no = '".($order_no+1)."' WHERE id = '".$post_order[$order_no]."'";
	mysql_query($query);
	}  
	echo true; 
	
	}else{
	echo false; 
	}
	
	
	
    /*
            if(trim($dbtype)!="")
            {
                $nanoSql="select * from faq where DBtype='$dbtype' and status='0' order by createdDate desc";
            }
            else{
                $nanoSql="select * from faq where status='0' order by createdDate desc";
            } 
    $jsonarray=array();

    if ($rsfaq = mysql_query($nanoSql))
    {
        While($myrow=mysql_fetch_array($rsfaq, MYSQL_BOTH))
        { 
            $faqId=$myrow["id"];
            $faqQues=trim($myrow["question"]);
            $faqdbtype=trim($myrow["DBtype"]);

            $jsonarray[]=array('id'=>$faqId,'question'=>$faqQues,'dbtype'=>$faqdbtype);

        }
    }
    
    echo json_encode($jsonarray); */ 
            
               
?>
