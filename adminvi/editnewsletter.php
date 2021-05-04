<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
require("checkaccess.php");
  checkaccess( 'user_management' );
 //session_save_path("/tmp");
session_start();
//print_r($_POST);
if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
{
    $userExists = false;
    $emailExists = false;
    $successState = false;
    if( isset( $_POST[ 'add_btn' ] ) ) {
        $category = mysql_real_escape_string( $_POST[ 'Category' ] );
        $heading = mysql_real_escape_string( $_POST[ 'Heading' ] );
        $summary = mysql_real_escape_string( $_POST[ 'Summary' ] );
        $Targetcmp_website = mysql_real_escape_string( $_POST[ 'Targetcmpweb' ] );
        $vi_database = mysql_real_escape_string( $_POST[ 'vi_db' ] );
        $createdOn = date( 'Y-m-d h:i:s' );
        $publish_at = $_POST[ 'publish_at' ];
        $keyword=$_GET['userID'];
       
        $update = "UPDATE newsletter SET
                    category = '" . trim($category) . "', heading = '" . trim( $heading ) . "', summary = '" . trim( $summary ) . "', Targetcmp_website = '" . trim( $Targetcmp_website ) . "' , vi_database = '" . trim( $vi_database ) . "', publish_at = '" . trim( $publish_at ) . "'
                    WHERE id = " . $keyword;
                   // echo $update;exit();
        if( mysql_query( $update ) ) {
            for ($i=0;$i<count($_POST['name']);$i++){
                if($i<$numrowsquery){
                            $name= mysql_real_escape_string( $_POST[ 'name' ][$i] );
                            
                            $url= mysql_real_escape_string( $_POST[ 'URL' ][$i] );

                    $update_mod = "UPDATE newsletter_source SET
                                        name = '" . $name . "', url = '" . $url . "'
                                        WHERE news_id = " . $keyword;
                                    // echo $update_mod;exit();
                                        mysql_query( $update_mod ) or die( mysql_error() );
                }
                        else{
                            $insert_mod = "INSERT INTO newsletter_source ( news_id, name, url )
                            VALUES( '" . $lastInsertId . "', '" . $name . "', '" . $url . "' )";
                                            mysql_query( $insert_mod ) or die( mysql_error() );
                        }


            }
            $successState = true;
        }
    }

    if( isset( $_GET[ 'userID' ] ) ) {
        $userID = $_GET[ 'userID' ];
        $sel = "SELECT * FROM newsletter
                WHERE newsletter.id = " . $userID;
                //echo $sel;exit();
        $res = mysql_query( $sel ) or die( mysql_error() );
        $numrows = mysql_num_rows( $res );
        $result = mysql_fetch_array( $res );
    }
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
<script src="//cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
<style>
td{
    width: 20% !important;
    font-size: 12px !important;
    text-align: center !important;
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

    <div style="width:570px; float:right; ">
    	<div style="width:565px; float:left; padding-left:2px;">
            <div style=" width:565px;  margin-top:4px;" class="main_content_container">
                
                <div id="maintextpro" style="background-color: #ffffff;width:100%; min-height: 774px;">
                    <div id="headingtextpro">
                        <div class="form_container">
                            <?php
                            if( $successState ) {
                                echo '<div class="success_msg">User updated successfully</div>';
                            }
                            ?>

                            <form method="post" action="editnewsletter.php?userID=<?php echo $userID; ?>">
                                <table border="1" align="center" cellpadding="2" cellspacing="0" width="80%" style="font-family: Arial; margin-top: 20px; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" bgcolor="#F5F0E4">
                                    <tbody>
                                        <tr bgcolor="#808000"><td colspan="2" align="center" style="color: #FFFFFF"><b> Add News Letter</b></td></tr>
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="Category">Category</label>
                                            </td>
                                            <td>
                                                <input type="text" id="Category" size="26" name="Category" class="req_value" forerror="UserName" value="<?php echo $result[ 'category' ]; ?>"> 
                                            </td>
                                        </tr>
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="Heading">Heading</label> 
                                            </td>
                                            <td>
                                                <input type="text" id="Heading" size="26" name="Heading" class="req_value" forerror="UserName" value="<?php echo $result[ 'heading' ]; ?>">
                                            </td>
                                        </tr>
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="Source">Source</label> 
                                            </td>
                                            <td>
                                            <p>
                                            <div id="IpRnglst" style="overflow: auto;margin-bottom:20px;max-height: 200px;">
                                            <!-- <input type="hidden" name="ipCount" id="ipCount" value="<?php echo ($numrows -1 ) ?>"> -->

                                            <?php
                                             $selQuery = "SELECT * FROM newsletter_source WHERE newsletter_source.news_id = " . $userID;
                                             //echo $selQuery;exit();
                                            $resquery = mysql_query( $selQuery ) or die( mysql_error() );
                                            $numrowsquery = mysql_num_rows( $resquery );

                                            $ipCount = 0;

                                            while ($rows = mysql_fetch_array($resquery)) {
                                             if ($ipCount==0) { ?>
                                            
                                                <p id="ipPr<?php echo $ipCount?>">

                                                <input type="text" name="name[]" placeholder="Name" size="10" value="<?php echo $rows[ 'name' ]; ?>">
                                                &nbsp;
                                                <input type="text" name="URL[]" placeholder="URL" size="10" value="<?php echo $rows[ 'url' ]; ?>">
                                                &nbsp;
                                                <input type="button" name="addMore" id="addMore" value="Add">
                                                </p>

                                           <?php }else{ ?>
                                            <p id="ipPr<?php echo $ipCount?>">

                                            <input type="text" name="name[]" placeholder="Name" size="10" value="<?php echo $rows[ 'name' ]; ?>">
                                            &nbsp;
                                            <input type="text" name="URL[]" placeholder="URL" size="10" value="<?php echo $rows[ 'url' ]; ?>">
                                            &nbsp;
                                            <img src="../dealsnew/images/cross.gif" onclick="removeip('<?php echo $ipCount ?>')">                                            </p>


                                          <?php } $ipCount++; } ?>

                                            </div>
                                               
                                            </td>
                                        </tr>
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="Summary">Summary</label> 
                                            </td>
                                            <td>
                                                <textarea type="text" id="Summary" size="26" name="Summary" class="req_value" forerror="UserName" ><?php echo $result['summary']; ?></textarea>
                                            </td>
                                        </tr>
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="Targetcmpweb">Target company Websites</label> 
                                            </td>
                                            <td>
                                                <input type="text" id="Targetcmpweb" size="26" name="Targetcmpweb" class="req_value" forerror="UserName" value="<?php echo $result[ 'Targetcmp_website' ]; ?>">
                                            </td>
                                        </tr>
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="vi_db">From Vi Database</label> 
                                            </td>
                                            <td>
                                                <input type="text" id="vi_db" size="26" name="vi_db" class="req_value" forerror="UserName" value="<?php echo $result[ 'vi_database' ]; ?>">
                                            </td>
                                        </tr>
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="publish_at">Published At</label> 
                                            </td>
                                            <td>
                                                <input type="text" id="publish_at" size="26" name="publish_at" class="req_value" forerror="UserName" value="<?php echo $result[ 'publish_at' ]; ?>">
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                <div style="text-align: center; margin-top: 20px;">
                                    <input type="submit" id="add_btn" name="add_btn" value="Update" />
                                    <button type="button" name="cancel_user" id="cancel_user">Cancel</button>
                                </div>
                            </form>
                        </div>
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

<!--   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom1.js"></SCRIPT>-->
<script type="text/javascript">
    CKEDITOR.replace('Summary')
    $(document).ready(function(){
        var ipNum = $("#ipCount").val();
        if(ipNum == 0)
        {
            var htmlpr = '<p id="ipPr'+ipNum+'"><input type="text" name="name[]" placeholder="Name" size="10" value="">&nbsp;<input type="text" name="URL[]" placeholder="URL" size="10" value="">&nbsp;<input type="button" name="addMore" id="addMore" value="Add"></p>';
            $("#ipCount").val(ipNum); 
            $("#IpRnglst").append(htmlpr);
                                                
        }
    
        $('#addMore').click(function(){debugger;
            var ipNum = $("#ipCount").val();
            ipNum = (ipNum * 1) + 1;
            var htmlpr = '<p id="ipPr'+ipNum+'"><input type="text" name="name[]" placeholder="Name" size="10" value="">&nbsp;<input type="text" name="URL[]" placeholder="URL" size="10" value="">&nbsp;<img src="../dealsnew/images/cross.gif" onclick="removeip('+ ipNum +')"></p>';
            $("#ipCount").val(ipNum); 
            $("#IpRnglst").append(htmlpr);
        });
    });
    function removeip(idval){
    
    var temp = '#ipPr'+idval;
    $(temp).html('');
    $(temp).remove();
    $("#ipCount").val(idval-1);
}
// function textToHtmlCodeHW() { 
//   var htmlEditorData = CKEDITOR.instances.ckeditor.getData(); 
//   var editor = ace.edit("Summary");
//   var code = editor.getValue();
//   editor.setValue(htmlEditorData)
// }

  </script>

</body>
</html>
<?php

} // if resgistered loop ends
else
    header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>