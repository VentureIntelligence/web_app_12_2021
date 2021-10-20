<?php
    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();

    // echo '<pre>'; print_r($_POST); echo '</pre>'; exit;

    $majoy_category = $_POST['majoy_category'];

    // echo $majoy_category;

    $sql = "SELECT * FROM newsletter_category WHERE category_id = $majoy_category";
    
    $option = "";
    if ($getSubCat = mysql_query($sql))
    {
        $value  = "<select name='Category' class = 'subcategorydropdown'>--- Select Major Category ---</option>";

        While($myrow=mysql_fetch_assoc($getSubCat, MYSQL_BOTH))
        {
            // echo '<pre>'; print_r($myrow); echo '</pre>';

            $id = $myrow['id'];
            $cat = $myrow['name'];

            $option = $option.'<option value="'.$id.'">'.$cat.'</option>';

        }
        $value2 = "</select>";

        $final  = $value. $option. $value1;
        echo $final;

    }
?>
