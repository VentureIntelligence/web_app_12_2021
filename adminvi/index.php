<?php
session_save_path("/tmp");
session_start();

require("../dbconnectvi.php");
$Db = new dbInvestments();

//if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
if (isset($_SESSION["SessLoggedAdminPwd"]) && isset($_SESSION["SessLoggedIpAdd"]))
{
    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title>Venture Intelligence</title>
        <link href="../css/vistyle.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <form name="admin"  method="post" action="" >
            <div id="containerproductproducts">

            <!-- Starting Left Panel -->
              <?php include_once('leftpanel.php'); ?>
            <!-- Ending Left Panel -->
            
        <!-- Starting Work Area -->

                <div style="width:570px; float:right; ">
                    <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/top1.js"></SCRIPT>
                    <SCRIPT>
                        call()
                    </script>

                    <div style="background-color:#FFF;width:565px; float:left; padding-left:2px;height: 800px;">
                        <div style=" width:565px; margin-top:4px;">
                            <div id="maintextpro">
                                <div id="headingtextpro">
                                  
                                     <h3>Welcome <?php echo $_SESSION['name']; ?></h3>
                                    <h3>Please access from the menu bar on left.</h3>
                                    


                                </div><!-- end of headingtextpro-->
                            </div> <!-- end of maintext pro-->
                        </div>
                    </div>
                </div>
            </div>
                        <!-- Ending Work Area -->
              <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom1.js"></SCRIPT>
    </form>

   <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
  </script>

</body>
</html>
<?php

} // if resgistered loop ends
else{
    
    header( 'Location: ' . BASE_URL . 'admin.php' ) ;
}
?>