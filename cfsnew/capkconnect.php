<?php
include_once('simple_html_dom.php');
$dbhost = "localhost";
$dbuser = "venture_admin16";
$dbpassword = "V@dm!n2016";
$dbname = "venture_peinvestments";
$dbhandle = mysql_connect($dbhost, $dbuser, $dbpassword) 
  or die("Unable to connect to MySQL");
$selected = mysql_select_db($dbname,$dbhandle) 
  or die("Database could not select");
if((isset($_REQUEST['user_name']) && $_REQUEST['user_name'] !='') && (isset($_REQUEST['password']) && $_REQUEST['password'] !='')){
    $user_name = $_REQUEST['user_name'];
    $password = md5($_REQUEST['password']);
    $cin_check = mysql_query("SELECT user_id FROM capkconnect_user WHERE username='$user_name' and password='$password'" );
    if(mysql_num_rows($cin_check) > 0){
        $cin_res = mysql_fetch_array($cin_check);
        $user_id = $cin_res['user_id'];
        $Qry = mysql_query("SELECT c.SCompanyName,c.CIN FROM capkconnect_user_company as cc, cprofile as c WHERE cc.company_id = c.Company_Id and cc.user_id = '$user_id'");
        if(mysql_num_rows($Qry) > 0){
            while($res = mysql_fetch_array($Qry)){
                $company['company_name'] = $res['SCompanyName'];
                $company['CIN'] = base64_encode($res['CIN']);
                $data_inner['data'][] = $company;
            }
        }
        $data['companyList'] = $data_inner;
        $data['success'] = "Logged in successfully";
    }else{
        $data['error'] = "Please check Username/Password you have given";        
    }
}else{
    $data['error'] = "Please check Username/Password you have given";
}
 //   print_r($data);
    echo json_encode($data);
 mysql_close(); 
 ?>