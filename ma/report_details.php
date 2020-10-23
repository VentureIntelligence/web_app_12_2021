<?php include_once("../globalconfig.php"); ?>
<?php               
    require_once("maconfig.php");
    $topNav = 'Report';
    require_once("../dbconnectvi.php"); 
    $Db = new dbInvestments();
    //include ('access_right.php');
    include_once('report_search.php');
    $id = $_GET['id'];
    
    if($accesserror==0)
    {
        $nanoSql="select `nanobi_EC` from nanotool WHERE `id`='".$id."'";
        $result = mysql_query($nanoSql) or die(mysql_error());
        $row=mysql_fetch_array($result);
        $rpLink = GLOBAL_BASE_URL."adminvi/nanofolder/".$row['nanobi_EC'];
    }
    else
    {
        echo"<div class='alert-note'><b>You are not subscribed to this database. To subscribe <a href='".BASE_URL."'contactus.htm'>Click here</a></b></div>";			
        exit;
    }
    
    mysql_close();
    
?>

<div id="container" >
    <div class="view-table1">
     <div class="close-frame"><strong> X</strong></div>
    <!--div style="margin-left: 360px;margin-bottom:5px;"><strong style="font-size: 16px;">Please read FY as CY </strong><i> (e.g: FY 2004-2005 as CY 2004)</i></div-->
       <iframe src="<?php echo $rpLink; ?>" frameborder="0" height="100%" width="100%" onload="this.width=screen.width;this.height=(screen.height-250);"> </iframe>
    </div>
</div>


</body>
</html>
<script>
    $(".close-frame").live("click",function(){
                    window.location.href = '<?php echo GLOBAL_BASE_URL; ?>ma/report.php';
                    return  false;
                }); 
    </script>
   