<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script> -->
<?php

require("../dbconnectvi.php");
$Db = new dbInvestments();
require("checkaccess.php");
 // checkaccess( 'user_management' );
 //session_save_path("/tmp");
session_start();
//print_r($_POST);
if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
{
    $userExists = false;
    $emailExists = false;
    $successState = false;
    if( isset( $_POST[ 'add_btn' ] ) ) {

        // echo '<pre>'; print_r($_POST); echo '</pre>'; 

        $category = mysql_real_escape_string( $_POST[ 'Category' ] );
        $sub_category_id  =  mysql_real_escape_string( $_POST[ 'SubCategory' ] );
        $heading = mysql_real_escape_string( $_POST[ 'Heading' ] );
        $slug = mysql_real_escape_string( $_POST[ 'slug' ] );

        $tags =  $_POST[ 'tags' ];
        $tags_string = implode(',',$tags);

        // echo '<pre>'; print_r($tags); echo '</pre>';  

        // exit;


        // Only News Array
        foreach ($tags as $val1)
        {
            if (!is_numeric($val1))
            {
                $onlynew[] = $val1;
            }else{
            }
        }
        // echo '<pre>'; print_r($onlynew); echo '</pre>';

   
        // Existing Array Name
        foreach ($tags as $val)
        {
            if (!is_numeric($val))
            {

            }else{
                $getTagName = "SELECT substring_index(tag_name, ':', -1)as tag FROM `tags` where id = $val";

                if ($rstag = mysql_query($getTagName))
                {
                    While($myrow=mysql_fetch_array($rstag, MYSQL_BOTH)){
                        
                        $tag_name[] = trim($myrow["tag"]);
                    }
                }
            }
        }

        //  echo '<pre>'; print_r($tag_name); echo '</pre>';

       if(!empty($onlynew) && !empty($tag_name)) {

            $final_tag = array_merge($onlynew,$tag_name);
            $tags_string = implode(',',$final_tag);

        }elseif(!empty($onlynew)){

            $tags_string = implode(',',$onlynew);
        }
        elseif(!empty($tag_name)){
            $tags_string = implode(',',$tag_name);
        }else{
            ?>
            <script>
                alert('Pls Enter the Non Numeric Value in Tags');
                location.href = 'newsletter.php';
            </script><?php
        }

        // echo '<pre>'; print_r($tag_name); echo '</pre>';
        // echo '<pre>'; print_r($final_tag); echo '</pre>'; 
        
        // echo '<pre>'; print_r($tags_string); echo '</pre>';

        // exit;


        $summary = mysql_real_escape_string( $_POST[ 'Summary' ] );
        $Targetcmp_website = mysql_real_escape_string( $_POST[ 'Targetcmpweb' ] );
        $vi_database = mysql_real_escape_string( $_POST[ 'vi_db' ] );
        $createdOn = date( 'Y-m-d h:i:s' );
        $publish_at = $_POST[ 'publish_at' ];
        $keyword="";
        $keyword=$_GET['id'];
        $date  = "$publish_at";

        $dt   = new DateTime($date);
        $epochtime= $dt->getTimestamp();
        $sel = "SELECT * from newsletter where id='".$keyword."'";
        $res = mysql_query( $sel ) or die( mysql_error() );
        $numrows = mysql_num_rows( $res );
        if( $numrows > 0 ) {
            $result = mysql_fetch_array( $res );
           
        } else {

            // get Major Cat Name
            $getCatName = "SELECT `name` FROM newsletter_major_category WHERE id = $category";
            $cat_name = mysql_query( $getCatName ) or die( mysql_error() );
            $numrows = mysql_num_rows( $cat_name );
            if( $numrows > 0 ) {
                $cat_result = mysql_fetch_assoc( $cat_name );
                $category_name =  ($cat_result['name']);
            }else{}

             //    get SubCat Name
            $getSubCatName = "SELECT `name` FROM newsletter_category WHERE id = $sub_category_id";
            $sub_cat_name = mysql_query( $getSubCatName ) or die( mysql_error() );
            $numrows = mysql_num_rows( $sub_cat_name );
            if( $numrows > 0 ) {
                $sub_cat_result = mysql_fetch_assoc( $sub_cat_name );
                $subcategory_name =  ($sub_cat_result['name']);
            }else{}

                $insert = "INSERT INTO newsletter ( major_category_id, major_category, category_id, category, heading, slug, tags, summary, targetcmp_website, vi_database, published_at,created_on )
                VALUES( '" . $category . "', '" . $category_name . "', '" . $sub_category_id . "','" . $subcategory_name . "', '" . $heading . "', '" . $slug . "',  '" . $tags_string . "',     '" . $summary . "', '" . $Targetcmp_website . "', '" . $vi_database . "', '" . $publish_at . "','" . $createdOn . "' )";

            //    echo $insert;exit();

           if( mysql_query( $insert ) ) {
                $lastInsertId = mysql_insert_id();

                // Insert Source
                for ($i=0;$i<count($_POST['name']);$i++){
                $name= mysql_real_escape_string( $_POST[ 'name' ][$i] );
                
                $url= mysql_real_escape_string( $_POST[ 'URL' ][$i] );
            
                $insert_mod = "INSERT INTO sources ( news_id, name, url )
                                VALUES( '" . $lastInsertId . "', '" . $name . "', '" . $url . "' )";
                mysql_query( $insert_mod ) or die( mysql_error() );
                }


                $selected_array = $_POST['tags'];
                // echo '<pre>'; print_r($selected_array); echo '</pre>'; 
                foreach ($selected_array as $value)
                {
                    // echo '<pre>'; print_r($value); echo '</pre>'; 
                    // exit;
                    if (!is_numeric($value)) // there are several ways to do this
                    {
                        // echo 'notInsert___'.$value.'<br />';
                        // echo 'Insert___'.$value.'<br />';

                        $insert_tag = "INSERT INTO tags ( tag_name, tag_type, created_date ) VALUES( '" . $value . "', '" . $value . "', '" . $createdOn . "' )";

                        // echo $insert_tag;

                        mysql_query( $insert_tag ) or die( mysql_error() );
                    
                    }else{}
                }
                $successState = true;
            }
        }
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
}
input[type=text],textarea,input[type=date]
{
    width: 82% ;
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
                    <span style="float: right; margin-right: 10px;">
                                <a href="newsletter.php" style="text-decoration: underline;">Back</a></span>

                        <div class="form_container">
                            <?php
                            if( $emailExists && $userExists  ) {
                                echo '<div class="error_msg">Email id and user name already exists</div>';
                            } else if( $emailExists ) {
                                echo '<div class="error_msg">Email already exists</div>';
                            } else if( $userExists ) {
                                echo '<div class="error_msg">User name already exists</div>';
                            }
                            if( $successState ) {

                                echo '<script>alert("News Letter added successfully")</script>';
                                echo "<script>window.open('newsletter.php','_self')</script>";

                            }
                            ?>
                            <form method="post" action="addnewsletter.php">
                                <table border="1" align="center" cellpadding="2" cellspacing="0" width="80%" style="font-family: Arial; margin-top: 20px; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" bgcolor="#F5F0E4">
                                    <tbody>
                                        <tr bgcolor="#808000"><td colspan="2" align="center" style="color: #FFFFFF"><b> Add News Letter</b></td></tr>
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="Category">Major Category</label>
                                            </td>
                                            <td>
                                            
                                            <?php
                                                $sql = "SELECT `id`,`name` FROM newsletter_major_category";
                                                $res = mysql_query($sql) or die(mysql_error());
                                                $option = '';
                                                
                                                while($rows=mysql_fetch_array($res)){ 
                                                    $id = $rows['id'];
                                                    $cat = $rows['name'];
                                                    $option .= '<option value="'.$id.'">'.$cat.'</option>';
                                                    
                                                }
                                                
                                            ?>

                                            <!-- <input type="text" name = "major_cat" id = "major_cat" value = "<?php echo $cat?>"> -->
                                            <select name="Category" onchange="getSubCat(this.value)" >
                                                <option value="">--- Select Major Category ---</option>
                                                <?php echo $option; ?>
                                            </select>

                                                <!-- <input type="text" id="Category" size="26" name="Category" class="req_value" forerror="UserName" value="">  -->
                                                <!-- <select name="Category" id="Category">
                                                    <option value="Private Equity Fund Investments">Private Equity Fund Investments</option>
                                                    <option value="Liquidity Events">Liquidity Events</option>
                                                    <option value="Social VC Investments">Social VC Investments</option>
                                                    <option value="Incubation/Acceleration">Incubation/Acceleration</option>
                                                    <option value="Angel Investments">Angel Investments</option>
                                                    <option value="Other Private Equity/Strategic Investments">Other Private Equity/Strategic Investments</option>
                                                    <option value="M&A">M&A</option>
                                                    <option value="IPO">IPO</option>
                                                    <option value="Secondary Issues">Secondary Issues</option>
                                                    <option value="Other Deals">Other Deals</option>
                                                    <option value="Other Deals - Listed Firms">Other Deals - Listed Firms</option>
                                                    <option value="Debt Financing">Debt Financing </option>
                                                    <option value="Real Estate Transactions">Real Estate Transactions</option>
                                                    <option value="Fund News">Fund News</option>

                                                </select> -->
                                            </td>
                                        </tr>
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="Heading">Category</label> 
                                            </td>
                                            <td>
                                                <select name="SubCategory" class = "subcategorydropdown">
                                                    <option value="">--- Select Category ---</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="Heading">Heading</label> 
                                            </td>
                                            <td>
                                                <input type="text" id="Heading" size="26" name="Heading" class="req_value" forerror="UserName" value="" onchange = "headingslug(this.value)" required>
                                                <input type="hidden" id="slug" size="26" name="slug" class="req_value slugvalue" forerror="UserName" value=""
                                            </td>
                                        </tr>
                                        <!-- <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="Heading">Tags</label> 
                                            </td>
                                            <td>
                                                <input type="text" id="tags" size="26" name="tags" class="req_value" forerror="UserName" value="" >
                                            </td>
                                        </tr> -->
                                       
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="Source">Source</label> 
                                            </td>
                                            <td>
                                            <p>
                                            <div id="IpRnglst" style="overflow: auto;margin-bottom:20px;max-height: 200px;">
                                             <!-- <?php echo $ipContent; ?> -->
                                                <input type="hidden" name="ipCount" id="ipCount" value="0">
                                            </div>
                                               
                                                                     </p>
                                            </td>
                                        </tr>
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="Summary">Summary</label> 
                                            </td>
                                            <td>
                                                <textarea type="text" id="Summary" size="26" name="Summary" class="req_value" forerror="UserName" value=""></textarea>
                                            </td>
                                        </tr>
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="Targetcmpweb">Target company Websites</label> 
                                            </td>
                                            <td>
                                                <input type="text" id="Targetcmpweb" size="26" name="Targetcmpweb" class="req_value" forerror="UserName" value="">
                                            </td>
                                        </tr>
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="vi_db">From Vi Database</label> 
                                            </td>
                                            <td>
                                            <textarea type="text" id="vi_db" size="26" name="vi_db" class="req_value" forerror="UserName" value=""></textarea>
                                                <!-- <input type="text" id="vi_db" size="26" name="vi_db" class="req_value" forerror="UserName" value=""> -->
                                            </td>
                                        </tr>



                                        <!-- Tags -->
                                        <tr style="font-family: Verdana; font-size: 8pt;">
                                            <td>
                                                <label for="vi_db">Tags</label> 
                                            </td>
                                            <td >
                                                <?php 
                                                    $tagsql = "SELECT substring_index(tag_name, ':', -1)as tag,id FROM `tags` where tag_name like '%".$search_tag."%' and tag_type!=''";

                                                    if ($rstag = mysql_query($tagsql))
                                                    {
                                                        While($myrow=mysql_fetch_array($rstag, MYSQL_BOTH)){

                                                            $id = $myrow["id"];
                                                            $tag_name = trim($myrow["tag"]);
                                                            $optiontags .= '<option value="'.$id.'">'.$tag_name.'</option>';
                                                        }
                                                    }
                                                ?>
                                                <select class="form-control js-example-tokenizer" multiple="multiple" name="tags[]" id="tags">
                                                    <?php echo $optiontags; ?>
                                                </select>
                                            </td>
                                        </tr>


                                        


                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="publish_at">Published At</label> 
                                            </td>
                                            <td>
                                                <input type="date" id="publish_at" size="26" name="publish_at" class="req_value" forerror="UserName" value="<?php echo date('Y-m-d') ?>">
                                            </td>
                                        </tr>
                                        <!-- <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="Heading">Slug</label> 
                                            </td>
                                            <td>
                                                <input type="text" id="slug" size="26" name="slug" class="req_value slugvalue" forerror="UserName" value="" disabled>
                                                <input type="hidden" id="slug" size="26" name="slug" class="req_value slugvalue" forerror="UserName" value=""> 
                                            </td>
                                        </tr> -->
                                        
                                    </tbody>
                                </table>
                                <div style="text-align: center; margin-top: 20px;">
                                    <input type="submit" id="add_btn" name="add_btn" value="save" />
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

   <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
        // CKEDITOR.replace('Summary')

    $(document).ready(function(){
        var ipNum = $("#ipCount").val();
        if(ipNum == 0)
        {
            var htmlpr = '<p id="ipPr'+ipNum+'"><input type="text" name="name[]" style="width:32%" placeholder="Name" size="10" value="">&nbsp;<input type="text" name="URL[]" style="width:32%" placeholder="URL" size="10" value="">&nbsp;<input type="button" name="addMore" id="addMore" value="Add"></p>';
            $("#ipCount").val(ipNum); 
            $("#IpRnglst").append(htmlpr);
                                                
        }
    
        $('#addMore').click(function(){
            var ipNum = $("#ipCount").val();
            ipNum = (ipNum * 1) + 1;
            var htmlpr = '<p id="ipPr'+ipNum+'"><input type="text" name="name[]" style="width:32%" placeholder="Name" size="10" value="">&nbsp;<input type="text" name="URL[]" style="width:32%"  placeholder="URL" size="10" value="">&nbsp;<img src="../dealsnew/images/cross.gif" onclick="removeip('+ ipNum +')"></p>';
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
$( '#cancel_user' ).on('click', function() {
    window.location.href = '<?php echo BASE_URL; ?>adminvi/newsletter.php';
  });

  </script>

    <script>
        function headingslug(val)
        {
            var slugvalue1 = val.toLowerCase();            
            var slugvalue = slugvalue1.replace(/ /g,"-");

            $(".slugvalue").val(slugvalue);
        }
    </script>

</body>
</html>
<?php

} // if resgistered loop ends
else
    header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>

<style>
    .js-example-tokenizer {
    width: 250px;
}
 
</style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$(".js-example-tokenizer").select2({
    allowClear: true,
    width: "resolve"
});

  
$(".js-example-tokenizer").select2({
    tags: true,
    tokenSeparators: [',', ' ']
})

    function getSubCat(val)
    {
        $.ajax({
            type: "POST",
            url: "ajax_cat_related.php",
            data: {
                majoy_category: val
            },
            success: function( data ) {
                // alert(data.responseText);
                if(data != "")
                {
                    // alert(data);
                    $(".subcategorydropdown").html(data);
                }
                else{
                    $(".subcategorydropdown").html('');
                }
             }
        });

    }
    

</script>