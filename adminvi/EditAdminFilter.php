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
      <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
      <style>
         .list-unstyled {
         padding-left: 0;
         list-style: none;
         }
         .li-post-group {
         background: #fff;
         /*padding: 5px 10px;*/
         /*padding: 5px;
         border-bottom: solid 1px #CFCFCF;*/
         /*margin-top: 5px;*/
         }
         /*.li-post-title {
         border-left: solid 4px #304d49;
         background: #946a22;
         padding: 5px;
         color: #ffffff;
         margin: 0px;
         }*/
         .show-more {
         background: #10c1b9;
         width: 100%;
         text-align: center;
         padding: 10px;
         border-radius: 5px;
         margin: 5px;
         color: #fff;
         cursor: pointer;
         font-size: 20px;
         display: none;
         margin: 0px;
         margin-top: 25px;
         }
         .li-post-desc {
         line-height: 15px !important;
         font-size: 12px;
         box-shadow: inset 0px 0px 5px #946a22;
         padding: 10px;
         margin: 0px;
         }
         .panel-default {
         margin-bottom: 100px;
         }
         .post-data-list {
         max-height: 374px;
         overflow-y: auto;
         }
         .radio-inline {
         font-size: 20px;
         color: #c36928;
         }
         .progress, .progress-bar{ height: 40px; line-height: 40px; display: none; }
         #post_list li
         {
         /* border: 1px solid #946a22;*/
         cursor: move;
         margin-top:10px;
         }
         #post_list li.ui-state-highlight {
         padding: 20px;
         background-color: #eaecec;
         border: 1px dotted #ccc;
         cursor: move;
         margin-top: 12px;
         }
         .alert {
         padding: 15px;
         margin-bottom: 20px;
         border: 1px solid transparent;
         border-radius: 4px;
         }
         .alert-success {
         color: #3c763d;
         background-color: #dff0d8;
         border-color: #d6e9c6;
         }
         .alert-danger {
         color: #a94442;
         background-color: #f2dede;
         border-color: #ebccd1;
         }
         .form-alter {
         display: none;
         }
         .fa-pencil-square-o,.fa-trash{
         font-size: 16px;
         }
         .deleteFaq1{
         margin-left: 14px;
         }
      </style>
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
               <script type="text/javascript" src="../dealsnew/js/jquery-1.8.2.min.js"></script> 
               <SCRIPT>
                  // call()
               </script>
               <script type="text/javascript"></script>
               <div style="width:565px; float:left; padding-left:2px;">
                  <div style="background-color:#FFF; width:565px; /*height:622px;*/ margin-top:5px;" class="main_content_container">
                     <div id="maintextpro">
                        <?php
                           $keyword="";
                           $keyword=$_POST['repDBtype'];
                           
                           $nanoSql="SELECT * FROM `saved_filter` where company_name IN('Pranion','VI-Research','Venture')  order by filter_order_no asc,id desc";
                           if ($reportrs = mysql_query($nanoSql))
                           {
                           $report_cnt = mysql_num_rows($reportrs);
                           }
                           ?>
                        <div id="headingtextpro" style="margin:10px;">
                           Drag and Re-order Your Filters &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           <div style=" overflow:auto;margin-top:10px;" class="content_container">
                              <div class="alert icon-alert with-arrow alert-success form-alter" role="alert">
                                 <i class="fa fa-fw fa-check-circle"></i>
                                 <strong> Success ! </strong> <span class="success-message"> Filter Order has been updated successfully </span>
                              </div>
                              <div class="alert icon-alert with-arrow alert-danger form-alter" role="alert">
                                 <i class="fa fa-fw fa-times-circle"></i>
                                 <strong> Note !</strong> <span class="warning-message"> Empty list cant be ordered </span>
                              </div>
                              <div style='clear:both'></div>
                              <ul class="list-unstyled" id="post_list">
                                 <?php
                                    if ($report_cnt>0)
                                    {
                                    While($myrow=mysql_fetch_array($reportrs, MYSQL_BOTH))
                                    {
                                   // if($myrow['vi_filter'] == 1 ){	
                                    ?>
                                 <li data-post-id="<?php echo $myrow["id"]; ?>">
                                    <div class="li-post-group">
                                       <!-- <h5 class="li-post-title">
                                          <?php echo $myrow["id"].' - '.$myrow["filter_name"]; ?> 
                                          </h5> -->
                                       <p class="li-post-desc"><?php 
                                          if(strlen($myrow["filter_name"]) > 70)
                                          echo  $myrow["id"].' - '.substr($myrow["filter_name"],0,70).'...'; 
                                          else
                                          echo  $myrow["id"].' - '.$myrow["filter_name"];  
                                          
                                          ?>
                                          <a href="javascript:void(0)" class='deleteFaq'style='float:right'  data-faq-id=<?php echo $myrow["id"]; ?> > &nbsp; &nbsp; <i class="fa  fa-trash" aria-hidden="true"></i>  </a>
                                          <?php if($myrow['vi_filter'] == 1 ){	?>
                                          <a href="adminFilter.php?id=<?php echo $myrow["id"]; ?>&filterName=<?php echo $myrow["filter_name"] ?>" style='float:right'> <i class="fa fa-pencil-square-o"></i> </a>
                                          <?php } ?>
                                       </p>
                                    </div>
                                 </li>
                                 <?php
                                   // } 
								}
							}
                                    
								
                                    else {?>
                                 <li style="font-family: Verdana; font-size: 8pt" >
                                    <td align=center colspan=5 >No data Found</td>
                                 </li>
                                 <?php } ?>	 
                              </ul>
                           </div>
                           <br>
                        </div>
                        <!-- end of headingtextpro-->
                     </div>
                     <!-- end of maintext pro-->
                  </div>
               </div>
            </div>
         </div>
         <!-- Ending Work Area -->
         </div>
         <!--  <SCRIPT LANGUAGE="JavaScript1.2" SRC="../bottom1.js"></SCRIPT> -->
      </form>
      <script src="https://www.google-analytics.com/urchin.js" type="text/javascript"></script>
     
      <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
      <script>
         $( "#post_list" ).sortable({
         //alert();
         placeholder : "ui-state-highlight",
         update  : function(event, ui)
         {
         var post_order_ids = new Array();
         $('#post_list li').each(function(){
         post_order_ids.push($(this).data("post-id"));
         });
         
         console.log('post_order_ids',post_order_ids);
         
         
         $.ajax({
         url:"saveFilter.php",
         method:"POST",
         data:{post_order_ids:post_order_ids},
         success:function(data)
         {
         if(data){
         $(".alert-danger").hide();
         $(".alert-success ").show();
         }else{
         $(".alert-success").hide();
         $(".alert-danger").show();
         }
         }
         });
         } 
         });
      </script>
      <SCRIPT LANGUAGE="JavaScript">
         function getFilterName()
         {
         document.admin.action="EditAdminFilter.php";
         document.admin.submit();
         }
         
         $(document).on("click",".deleteFaq",function() {
         var currentId = $(this).attr('data-faq-id'); 
         $('.deal-comp-id').val(currentId);
         
         var del=confirm("Are you sure you want to delete this record?");
         if (del==true){ 
         $.ajax({
         url: 'saveFilter.php',
         type: "POST",
         data: {filterId: currentId, mode: 'D'},
         success: function(data){
         
         alert('deleted successfully');
         getFilterName();
         },
         });
         } else {
         alert("Record Not Deleted")
         }  
         
         });
         
      </SCRIPT>
   </body>
</html>
<?php
   } // if resgistered loop ends
   else
   header( 'Location: ' . BASE_URL . 'admin.php' ) ;
   ?>


   