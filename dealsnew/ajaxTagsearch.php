<?php

        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
        
        $search_tag=$_REQUEST['pe_cq'];
        if(!isset($_SESSION['UserNames']))
         {
                  header('Location:../pelogin.php');
         }
         else
         {
     // $tagsql = "SELECT substring_index(tag_name, ':', -1)as tag FROM `tags` where tag_name like '%".$search_tag."%' and tag_type!='Competitor Tags' and tag_type!=''";
        $tagsql = "SELECT substring_index(tag_name, ':', -1)as tag FROM `tags` where tag_name like '%".$search_tag."%' and tag_type!=''";

        if ($rstag = mysql_query($tagsql))
        {

            While($myrow=mysql_fetch_array($rstag, MYSQL_BOTH)){
                
                $tag_name=trim($myrow["tag"]);
                $jsonarray[]=array('id'=>$tag_name,'label'=>$tag_name,'name'=>$tag_name,'value'=>$tag_name);
                               
           }
        }
        echo json_encode($jsonarray);
      }
?>
