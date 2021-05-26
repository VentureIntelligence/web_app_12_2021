<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
require("checkaccess.php");
///checkaccess( 'user_management' );
 //session_save_path("/tmp");
session_start();
//print_r($_POST);

if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
{
    $sel = "SELECT *, DATE_FORMAT(published_at,'%d-%M-%y') as publishdate FROM newsletter where is_deleted = 0 ";
    $res = mysql_query( $sel ) or die( mysql_error() );
    $numrows = mysql_num_rows( $res );

   
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<link rel="stylesheet" href="../css/jquery-ui.css">
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<link href="../css/vistyle.css" rel="stylesheet" type="text/css">
<link href="../css/material-design-iconic-font.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
               <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
               
<style>
.userMGMT #headingtextpro table {
    width:100%; margin-top: 20px;
}
.userMGMT #headingtextpro table thead tr th {
    text-align: left;
    font-size: 13px;
    color: #818181;
    padding: 10px 0px;
    border-top: 1px solid #ececec;
}
.userMGMT #headingtextpro table tbody tr td {
    padding: 10px 0px;
    border-top: 1px solid #ececec;
}
</style>
</head>
<body class="">
    <!-- <div class="loader-wrapper">
        <div class="loadersmall"></div>
    </div> -->
<div id="containerproductproducts">
    <!-- Starting Left Panel -->
    <?php include_once('leftpanel.php'); ?>
    <!-- Ending Left Panel -->
    <!-- Starting Work Area -->

    <div class="userMGMT" style="width:570px; float:right; ">
    	<div style="width:565px; float:left; padding-left:2px;">
            <div style=" width:565px;  margin-top:4px;" class="main_content_container">
                
                <div id="maintextpro" style="background-color: #ffffff;width:100%; min-height: 774px;">
                <div id="heading"><h2 style="text-align: center;">News Letter</h2></div>
                    <div id="headingtextpro">
                            <span style="float: right; margin-right: 10px;">
                                <a href="addnewsletter.php" style="text-decoration: underline;">Create News Letter</a></span><br><br>
                        <table style=""   id="myTable">
                            <thead>
                                <tr>
                                    <th style="width:30px !important">ID</th>
                                    <th style="width: 184px; !important">Category</th>
                                    <th style="" style="">Heading</th>
                                    <th style="">Published at</th>
                                    <th style="">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if( $numrows > 0 ) {
                                    while( $result = mysql_fetch_array( $res ) ) {
                                        $category =$result[ 'category' ];

                                        
                                ?>
                                <tr>
                                    <td><?php echo $result[ 'id' ] ?></td>
                                    <td ><?php echo $category ?></td>
                                    <td><?php echo substr_replace($result[ 'heading' ], "...", 20) ?></td>
                                    <td><?php echo  $result[ 'publishdate' ] ?></td>
                                    <td>
                                        <a href="editnewsletter.php?userID=<?php echo $result[ 'id' ]; ?>">
                                            <img src="images/edit.png" style="width: 15px; height: 15px;" />
                                        </a>&nbsp;&nbsp;
                                        <a href="javascript:;" class="delete_user" data-userid="<?php echo $result[ 'id' ]; ?>">
                                            <img src="images/delete.png" style="width: 15px; height: 15px;" />
                                        </a>
                                    </td>
                                    <!-- <td>
                                        <a href="javascript:;" class="user_permission"" data-permit="<?php echo $value; ?>" data-userid="<?php echo $result[ 'id' ]; ?>"><img src="images/<?php echo $icon; ?>" style="width: 15px; height: 15px;" /></a>
                                    </td> -->
                                </tr>
                                <?php
                                    }
                                } else {
                                ?>
                                <tr>
                                    <td colspan="7">No News Letter(s) added</td>
                                </tr>
                                <?php
                                } 
                                ?>
                            </tbody>
                        </table>
                    </div><!-- end of headingtextpro-->
                </div> <!-- end of maintext pro-->
           </div>
    	</div>
    </div>

    <div class="bottom-section">
        <div style="padding-top: 10px;height: 25px;font-size: 11px;margin-left: 0px;padding-left: 25px; width: 75%; float: left;">
            <span><a href="../index.htm">Home</a> I <a href="../products.htm">Products</a> I </span>
            <span><a href="../events.htm">Events</a> I<a href="../investors.htm"> Investors</a> I </span>
            <span><a href="../entrepreneurs.htm">Entrepreneurs</a> I <a href="../serviceproviders.htm">Service Providers</a> I  </span>
            <span><a  href="../news.htm">News</a> I <a href="../aboutus.htm">About Us</a> I</span>
            <span><a href="../contactus.htm"> Contact Us</a>	</span>
        </div>
        <div id="copyright">� TSJ Media Pvt. Ltd</div>
    </div>
</div>
  <!-- Ending Work Area -->
<script>
     $( '.delete_user' ).on( 'click', function() {
            var confirmMsg = confirm('Do you want to delete this user.');
            if( confirmMsg ) {
                var userID = $(this).data('userid');
                //alert(userID);
                $.ajax({
                    type: 'POST',
                    url: 'ajax_news_del.php',
                    data: {userid:userID},
                    success: function( resp ) {
                        if( resp == 1 ) {
                            alert( 'News Letter deleted successfully' );
                        } else {
                            alert( 'Some problem occurred' );
                        }
                        location.reload();
                    }
                });
            }
        });
        $(document).ready(function() {
         $('#myTable').DataTable();
         } );
</script>


</body>
</html>
<?php

} // if resgistered loop ends
else
    header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>