<?php
$dbhost = "localhost";
$dbuser = "venture_admin16";
$dbpassword = "V@dm!n2016";
$dbname = "venture_peinvestments";
$dbhandle = mysql_connect($dbhost, $dbuser, $dbpassword) 
  or die("Unable to connect to MySQL");
$selected = mysql_select_db($dbname,$dbhandle) 
  or die("Database could not select");

//if(isset($_GET["action"]) && ($_GET["action"] == "upload")){
    //company upload    
    $added_date = date('Y-m-d H:i:s');
    $result = mysql_query("SELECT tags FROM pecompanies WHERE tags!=''");
    if(mysql_num_rows($result) >0){
        while($res = mysql_fetch_array($result)){
            $tags = $res['tags'];
            $ex_tags = explode(',',$tags);
            if(count($ex_tags) > 0){
                for($l=0;$l<count($ex_tags);$l++){
                    if($ex_tags[$l] !=''){ 
                        $tag_name = trim($ex_tags[$l]);
                        $tag_check = mysql_query("SELECT id FROM tags WHERE tag_name='$tag_name'" );
                        $tag_check_count = mysql_num_rows($tag_check);
                        if($tag_check_count == 0){
                            $ex_tag_name = explode(':',$tag_name);
                            $tag_type = $ex_tag_name[0];
                            if($tag_type == 'i'){
                                $tagType = 'Industry Tags';
                            }else if($tag_type == 's'){
                                $tagType = 'Sector Tags';
                            }else if($tag_type == 'c'){
                                $tagType = 'Competitor Tags';
                            }
                            $sql_insert_pl = "INSERT INTO tags ( tag_name,tag_type,created_date  )  VALUES ('$tag_name','$tagType','$added_date')";
                            $result_insert_pl = mysql_query($sql_insert_pl) or die(mysql_error());
                        }
                    }
                }
            }
            
        }
    }
        
        
        echo "Tags imported successfully";
  //  header("Location:upload.php");
//}
?>