<!--script src="//code.jquery.com/jquery-1.11.3.min.js"></script-->

  <?php 
  
  $dbhost2 = "localhost";
  $dbuser2 = "venture_admin";
  $dbpassword2 = "Admin2014";
$db2 = "venture_peinvestments";

$connection2 = mysql_connect($dbhost2,$dbuser2,$dbpassword2) or die (mysql_error());
mysql_select_db($db2,$connection2);
        
         
       
        if($surveyDB=='CFS'){
        $email = $_SESSION['username'];
       }else{
          $email = $_SESSION['UserEmail']; 
       }

        date_default_timezone_set ('Asia/Kolkata');
        $date =  date('Y-m-d'); 

        //$check_status = "select status,date from survey_stats where user_id='".$user_id."' and date='".$date."'";
        $check_status = "select * from survey_stats where  email='".$email."'    ";
        $check_status_exe=mysql_query($check_status);
       
         $data_status=mysql_num_rows($check_status_exe);
        // echo 'ssssssssssssssssssss='.$data_status;;
        if($data_status==0)
        {
        
             include("popup.php");
  
        }
        else 
        { 
            
    
            $data=mysql_fetch_array($check_status_exe);
            
            
            if($data['status']==2 && $data['date']!=$date )
            {
                  include("popup.php");

            }

            
 
        
        }
  
  
  ?>

