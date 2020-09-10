<?php 

//error_reporting(0);
 require_once("../dbconnectvi.php");
$Db = new dbInvestments();
if($_POST['queryString']!='')
{
$industry=$_POST['queryString']."%";
        
        $industrysql_search="select industryid,industry from industry where industryid !=15 and industry like '".$industry."' order by industry";
        if ($industryrs = mysql_query($industrysql_search))
        {
         $ind_cnt = mysql_num_rows($industryrs);
        }
        if($ind_cnt>0)
        {
             $jsonarray=array();
                 While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                {
                        $id = $myrow[0];
                        $name = $myrow[1];
                        $jsonarray[]=array('industryname'=>addslashes($name),'industryid'=>$id);
                }
                mysql_free_result($industryrs);
                echo json_encode($jsonarray);
        }
}

if($_POST['queryString1']!='')
{
$industry=$_POST['queryString1']."%";
        
        
          $industrysql_search="select industryid,industry from industry where industryid !=15 and industry like '".$industry."' order by industry";
        if ($industryrs = mysql_query($industrysql_search))
        {
         $ind_cnt = mysql_num_rows($industryrs);
        }
        if($ind_cnt>0)
        {
             $jsonarray=array();
                 While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                {
                        $id = $myrow[0];
                        $name = $myrow[1];
                        $jsonarray[]=array('industryname'=>addslashes($name),'industryid'=>$id);
                }
                mysql_free_result($industryrs);
                echo json_encode($jsonarray);
        }
}

    ?>
