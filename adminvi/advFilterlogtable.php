<?php
   require("../dbconnectvi.php");
   $Db = new dbInvestments();
   require("checkaccess.php");
   //checkaccess( 'admin_report' );
   session_save_path("/tmp");
   session_start();
   //print_r($_SESSION);
   if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
   {
   ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
      <title>Venture Intelligence</title>
      <link href="../css/vistyle.css" rel="stylesheet" type="text/css">
      <style>
    
         /* tbody td {
         text-align: center!important;
         } */
         * {
  box-sizing: border-box;
}

.row {
  margin-left:-5px;
  margin-right:-5px;
}
  
.column {
  float: left;
  width: 50%;
  padding: 5px;
}

/* Clearfix (clear floats) */
.row::after {
  content: "";
  clear: both;
  display: table;
}
.headingFiltr
{
    text-align: center;
    padding: 10px 0px 0px 0px;
}

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;

}

th {
  border-bottom: 1px solid black;
  text-align: left;
  padding: 10px 0px;
  color: #818181;
}

td {
    border-bottom: 1px solid #ececec;

  text-align: left;
  padding: 10px 0px;
}
.main_content_container {
    height: 1080px !important;
    margin-bottom: 10px;
}

      </style>
   </head>
   <body>
      <form name="admin"  method="post" action="" >
         <div id="containerproductproducts">
            <!-- Starting Left Panel -->
            <?php include_once('leftpanel.php'); ?>
            <div style="width:570px; float:right; ">
               <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/top1.js"></SCRIPT>
               <script type="text/javascript" src="../dealsnew/js/jquery-1.8.2.min.js"></script> 
               <link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
               <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
               <div style="width:565px; float:left; padding-left:2px;">
               <div style="background-color:#FFF; width:565px; /*height:622px;*/ margin-top:5px;" class="main_content_containerFl">
               <div id="headingtextpro" style="margin:10px;">
                          <h4 class="headingFiltr" style="    padding-top: 10px;"> Log table </h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          
               <div class="row">
               <div style=" overflow:auto;margin-top:10px;" class="content_container">
                           <?php
                           $keyword="";
                           $keyword=$_POST['repDBtype'];
                           
                           $nanoSql="SELECT * FROM `advance_export_filter_log` order by id desc";
                           if ($reportrs = mysql_query($nanoSql))
                           {
                           $report_cnt = mysql_num_rows($reportrs);
                           }
                           ?>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
                              <thead>
                                 <tr>
                                    <th>Name</th>
                                    <th>Filter Name</th>
                                    <th>Filter Type</th>
                                    <th>Company Name</th>
                                    <th>Created Date</th>
                                    <th style="display:none">Date</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                    if ($report_cnt>0)
                                    {
                                    
                                    While($myrow=mysql_fetch_array($reportrs))
                                    {
                                    // print_r($myrow);
                                    
                                    ?>
                                 <tr>
                                    <td><?php echo $myrow['name'] ?></td>
                                    <td><?php echo $myrow['filter_name'] ?></td>
                                    <td><?php echo $myrow['filter_type'] ?></td>
                                    <td><?php echo $myrow['company_name'] ?></td>
                                    <td><?php echo date('d-M-y', strtotime($myrow['created_date']));?></td>
                                    <td style="display:none"><?php echo date('yyyy-mm-dd', strtotime($myrow['created_date']));?></td>
                                 </tr>
                                 <?php } } else {?>
                                 <tr>
                                    <td colspan="2">No Records Found</td>
                                 </tr>
                                 <?php } ?>
                              </tbody>
                              </table>
                           </div>
  <div class="companylist">
  <h4 class="headingFiltr">Top Five Company List</h4>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                              <thead>
                                 <tr>
                                    <th style="width: 50%;">Company Name</th>
                                    <th>Overall Filter Count</th>
                                 </tr>
                              </thead>
                              <tbody>
                              <?php
                           $keyword="";
                           $keyword=$_POST['repDBtype'];
                           
                           $nanoSql="SELECT company_name,count(id) as totalcount FROM `advance_export_filter_log` GROUP BY company_name ORDER by totalcount DESC limit 5";
                           if ($reportrs = mysql_query($nanoSql))
                           {
                           $report_cnt = mysql_num_rows($reportrs);
                           }
                           ?>
                                 <?php
                                    if ($report_cnt>0)
                                    {
                                    
                                    While($myrow=mysql_fetch_array($reportrs))
                                    {
                                    // print_r($myrow);
                                    
                                    ?>
                                 <tr>
                                    <td><?php echo $myrow['company_name'] ?></td>
                                    <td><?php echo $myrow['totalcount']?></td>
                                 </tr>
                                 <?php } } else {?>
                                 <tr>
                                    <td colspan="2">No Records Found</td>
                                 </tr>
                                 <?php } ?>
                              </tbody></table>
  </div>
  <div class="filterlist">
  <h4 class="headingFiltr" >Top Five Filter List</h4>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <thead>
                                 <tr>
                                    <th style="width: 50%;">Filter Name</th>
                                    <th>Overall Filter Count</th>
                                 </tr>
                              </thead>
                              <tbody>
                              <?php
                           $keyword="";
                           $keyword=$_POST['repDBtype'];
                           
                           $nanoSql="SELECT filter_name,count(id) as totalcount FROM `advance_export_filter_log` GROUP BY filter_name ORDER by totalcount DESC limit 5";
                           if ($reportrs = mysql_query($nanoSql))
                           {
                           $report_cnt = mysql_num_rows($reportrs);
                           }
                           ?>
                                 <?php
                                    if ($report_cnt>0)
                                    {
                                    
                                    While($myrow=mysql_fetch_array($reportrs))
                                    {
                                    // print_r($myrow);
                                    
                                    ?>
                                 <tr>
                                    <td><?php echo $myrow['filter_name'] ?></td>
                                    <td><?php echo $myrow['totalcount'] ?></td>
                                 </tr>
                                 <?php } } else {?>
                                 <tr>
                                    <td colspan="2">No Records Found</td>
                                 </tr>
                                 <?php } ?>
                              </tbody>
    </table>
  </div>
</div>


                           <br>
                        </div>

                </div>
               </div>
            </div>
         </div>
         <!-- Ending Work Area -->
         </div>
         <!--  <SCRIPT LANGUAGE="JavaScript1.2" SRC="../bottom1.js"></SCRIPT> -->
      </form>
      <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
      <script>
         $(document).ready(function() {
         $('#myTable').DataTable({
            columnDefs: [ { type: 'date', 'targets': [4] } ],
            order: [[ 4, 'desc' ]]
         } );
         } );
      
      </script>
   </body>
</html>
<?php
   } // if resgistered loop ends
   else
   header( 'Location: ' . BASE_URL . 'admin.php' ) ;
   ?>
