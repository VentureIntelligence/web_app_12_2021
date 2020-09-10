<?php

        require_once("maconfig.php");
        require_once("../dbconnectvi.php");//including database connectivity file
        $Db = new dbInvestments();
        $videalPageName="MAMA";
        include_once('machecklogin.php');
                
        
                
              
                $orderby=""; $ordertype="";
                if(!$_POST)
                {
                   // $iftest=1;
                   // $yourquery=0;
                    $reportsql = "SELECT * from nanotool WHERE typeofReport='M&A' ";
                   
                    $orderby2="date";
                    $ordertype2="desc";
                    $reportsql = $reportsql . " order by ".$orderby2." ".$ordertype2 ; 
                    $datefilert='';
                     $totalreportsql =$reportsql;
                     //echo "<br>all records" .$reportsql;
                    
                }
                else if (isset($_POST['month1']))
                {
                 // echo "<br>--" .$regionId;
                    $iftest=5;
                    $yourquery=1;
                    $reportsql = "SELECT * from nanotool   WHERE typeofReport='M&A'  ";
                    $datefilert="datefilter";
                    
                    $month1=$_POST['month1'];
                    $year1=$_POST['year1'];
                    $month2=$_POST['month2'];
                    $year2=$_POST['year2'];
                    
                    if ($_POST['month1']!="--" && $_POST['year1']!="--" && $_POST['month2']!="--" && $_POST['year2']!="--")
                    {
                          
                           $reportsql.= " and  MONTH(date) >= $_POST[month1]  and MONTH(date) <= $_POST[month2]   and YEAR(date) >= $_POST[year1]  and YEAR(date) <= $_POST[year2]";
                    }                    
                   
                    $orderby2="date";
                    $ordertype2="desc";
                    
                     $reportsql = $reportsql . " order by ".$orderby2." ".$ordertype2 ; 
                     $totalreportsql =$reportsql;
                }
                
        $ajaxcompanysql=  urlencode($reportsql);
       
    ?>

    <?php 
    $topNav = 'Report';
    include_once('report_search.php');
    ?>

<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>
    <?php
        $exportToExcel=0;
        $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,dealmembers as dm
                                                            where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
        //echo "<br>---" .$TrialSql;
        if($trialrs=mysql_query($TrialSql))
        {
                while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                {
                        $exportToExcel=$trialrow["TrialLogin"];
                        $studentOption=$trialrow["Student"];
                }
        }
        if($yourquery==1)
                $queryDisplayTitle="Query:";
        elseif($yourquery==0)
                $queryDisplayTitle="";
        if(trim($buttonClicked==""))
        {
            $totalDisplay="Total";
            $industryAdded ="";
            $totalAmount=0.0;
            $totalInv=0;
            $compDisplayOboldTag="";
            $compDisplayEboldTag="";
            //echo $status;
            //  /   echo "<br> query final-----" .$companysql."//".$iftest."/".$TrialSql."/".$studentOption."/".$companysearch;
            /* Select queries return a resultset */
          
            //echo $reportsql;
            if ($reportall = mysql_query($reportsql))
            {
                $report_cntall = mysql_num_rows($reportall);
            } 
            if($report_cntall > 0)
            {
                $rec_limit =20;
                /*if(!$_POST)
                {
                       $rec_limit = 6;  
                }else{
                     $rec_limit = 50;
                }*/
               
                $rec_count = $report_cntall;
                if( isset($_GET{'page'} ) )
                {
                   $currentpage=$page;
                   $page = $_GET{'page'} + 1;
                   $offset = $rec_limit * $page ;
                }
                else
                {
                    $currentpage=1;
                   $page = 1;
                   $offset = 0;
                }
                
                if ($_POST)
                    $reportsqlwithlimit=$reportsql." limit $offset, $rec_limit";
                else
                    $reportsqlwithlimit=$reportsql." limit 0, 20";
                
                 //echo  $reportsqlwithlimit;
                if ($reportrs = mysql_query($reportsqlwithlimit))
                {
                    $report_cnt = mysql_num_rows($reportrs);
                }
            }
            else
            {
                 $searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
                 $notable=true;
            }
           ?>     
    <td class="profile-view-left" style="width:100%;">
     
    <div class="result-cnt" style="margin-bottom: 30px;">
    	<?php if ($accesserror==1){?>
                    <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm" target="_blank">Click here</a></b></div>
        <?php
                exit; 
                } 
        ?>
        <div class="result-title">

                <?php if(!$_POST)
                    {   
                    ?>
            <h2>
               <span class="result-no"> Listed Reports(<?php echo mysql_num_rows(mysql_query($totalreportsql))?>)</span>
            </h2>                   
            <?php 
            }
            else 
            {
               ?>
            <h2>
             <?php  
                if($studentOption==1)
                {
                ?>
                 <span class="result-no">Listed Reports(<?php echo @mysql_num_rows($reportall); ?>)/span>  
                 <?php
                }
                else
                {
                   if($exportToExcel==1)
                     {
                     ?> 
                       <span class="result-no">Listed Reports(<?php echo @mysql_num_rows($reportall); ?>)</span> 
                     <?php
                     }
                     else
                     {
                     ?>
                             <span class="result-no">XXX Results Found</span> 
                     <?php
                     }
                }
            }
                ?>   
  </div>	
   <?php
        if($notable==false)
        { 
        ?>	
        
         <div class="list-tab <?php echo ($cls!="")?$cls:"mt-list-tab-directory"; ?>"></div>
        <div class="view-table view-table-list">

            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
              <thead><tr>
                
<!--                    <th class="header <?php echo ($orderby=="title")?$ordertype:""; ?>" id="title" >Title</th>
                    <th class="header <?php echo ($orderby=="type")?$ordertype:""; ?>" id="type" >Type</th>
                    <th class="header <?php echo ($orderby=="period")?$ordertype:""; ?>" id="period">Period</th>
                    <th class="header <?php echo ($orderby=="date")?$ordertype:""; ?>" id="date">Date</th>-->
                
                    <th>Title </th>
                                <th>Type</th>
                                <th>Period</th>
                                <th>Date</th>
               
               </tr></thead>
              
              <tbody id="movies">
                     <?php
                     
                        if ($report_cnt>0)
                          {
                                $hidecount=0;
                                //Code to add PREV /NEXT
                                mysql_data_seek($reportrs,0);
                                While($myrow=mysql_fetch_array($reportrs, MYSQL_BOTH))
                                {
                                    if( !empty( $myrow[ 'zscore_id' ] ) ) {
                                        //$detailsLink = "http://demo.zscore.co.in/Zscore/zscore/index.html#user/admin/".$myrow[ 'zscore_id' ]; 
                                        $detailsLink = $myrow[ 'zscore_id' ];
                                    } else {
                                        $detailsLink = "report_details.php?id=" . $myrow["id"];
                                    }
                           ?>           <tr>
                               
                                            <td ><a class="" href="<?php echo $detailsLink; ?>" target="_blank"><?php echo trim($myrow["titleofReport"]);?> </a></td>
                                            <td><?php echo $myrow["typeofReport"];?></td>
                                            <td><?php echo str_replace('_', ' ', $myrow["periodofReport"]); ?></td>
                                            <td><?php echo date("d-m-Y", strtotime($myrow["date"])); ?> </td>
                                                        </tr>
                                        <?php
                                        }
                        }
                        ?>
        </tbody>
    </table>

    </div>			
<?php
                }
                

?>
      
      <div class="holder">
                 <?php
                    $totalpages=  ceil( mysql_num_rows(mysql_query($totalreportsql))/$rec_limit);
                    $firstpage=1;
                    $lastpage=$totalpages;
                    $prevpage=(( $currentpage-1)>0)?($currentpage-1):1;
                    $nextpage=(($currentpage+1)<$totalpages)?($currentpage+1):$totalpages;
                 ?>
                 
                  <?php
                    $pages=array();
                    $pages[]=1;
                    $pages[]=$currentpage-2;
                    $pages[]=$currentpage-1;
                    $pages[]=$currentpage;
                    $pages[]=$currentpage+1;
                    $pages[]=$currentpage+2;
                    $pages[]=$totalpages;
                    $pages =  array_unique($pages);
                    sort($pages);
                 if($currentpage<2){
                 ?>
                 <a class="jp-previous jp-disabled" >&#8592; Previous</a>
                 <?php } else { ?>
                 <a class="jp-previous" >&#8592; Previous</a>
                 <?php } for($i=0;$i<count($pages);$i++){ 
                     if($pages[$i] > 0 && $pages[$i] <= $totalpages){
                ?>
                 <a class='<?php echo ($pages[$i]==$currentpage)? "jp-current":"jp-page" ?>'  ><?php echo $pages[$i]; ?></a>
                 <?php } 
                     }
                     if($currentpage<$totalpages){
                     ?>
                 <a class="jp-next">Next &#8594;</a>
                     <?php } else { ?>
                  <a class="jp-next jp-disabled">Next &#8594;</a>
                     <?php  } ?>
             </div>
         
       

    </div>
		<?php
					}
					elseif($buttonClicked=='Aggregate')
					{

						$aggsql= $aggsql. " i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
								and  pe.Deleted=0 " .$addVCFlagqry.
									 " order by pe.amount desc,dates desc";
						//	echo "<br>Agg SQL--" .$aggsql;
							 if ($rsAgg = mysql_query($aggsql))
							 {
								$agg_cnt = mysql_num_rows($rsAgg);
							 }
							   if($agg_cnt > 0)
							   {
									 While($myrow=mysql_fetch_array($rsAgg, MYSQL_BOTH))
									   {
											$totDeals = $myrow["totaldeals"];
											$totDealsAmount = $myrow["totalamount"];
										}
							   }
							   else
							   {
									$searchTitle= $searchTitle ." -- No Investments found for this search";
							   }
							   if($industry >0)
							   {
							   	  $indSql= "select industry from industry where industryid=$industry";
							   	  if($rsInd=mysql_query($indSql))
							   	  {
								   	  while($myindRow=mysql_fetch_array($rsInd,MYSQL_BOTH))
								   	  {
								   	  	$indqryValue=$myindRow["industry"];
								   	  }
								   }
								}
								 if($stage!="")
							   {
								  $stageSql= "select Stage from stage where StageId=$stage";
								  if($rsStage=mysql_query($stageSql))
								  {
									  while($mystageRow=mysql_fetch_array($rsStage,MYSQL_BOTH))
									  {
										$stageqryValue=$mystageRow["Stage"];
									  }
								   }
								}
								if($dealtype!= "--")
								{
									$dealSql= "select Stage from dealtypes where StageId=$stage";
								  	if($rsDealType=mysql_query($dealSql))
								  	{
									  while($mydealRow=mysql_fetch_array($rsDealType,MYSQL_BOTH))
									  {
										$stageqryValue=$mydealRow["Stage"];
									  }
								   	}
								 }
								if($range!= "--")
								{
									$rangeqryValue= $rangeText;
								}
								if($wheredates !== "")
								{
									$dateqryValue= returnMonthname($month1) ." ".$year1 ." - ". returnMonthname($month2) ." " .$year2;
								}
								$searchsubTitle="";
								if(($industry==0) && ($stage=="--") && ($range=="--") && ($wheredates==""))
								{
									$searchsubTitle= "All";
								}

					?>
						<div id="headingtextpro">
						<div id="headingtextproboldfontcolor"> <?php echo $searchAggTitle; ?> <br />  <br /> </div>
						<div id="headingtextprobold"> Search By :  <?php echo $searchsubTitle; ?> <br /> <br /></div>
					<?php
						$spacing="<Br />";
						if ($industry > 0)
						{

					?>
							<?php echo $qryIndTitle; ?><?php echo $indqryValue; ?> <?php echo $spacing; ?>
					<?php
						}
						if($stage !="")
						{
					?>
							<?php echo $qryDealTypeTitle; ?><?php echo $stageqryValue; ?> <?php echo $spacing; ?>
					<?php
						}
						if($range!="--")
						{
					?>
							<?php echo $qryRangeTitle; ?><?php echo $rangeqryValue; ?> <?php echo $spacing; ?>
					<?php
						}
						if($wheredates!="--")
						{
					?>
							<?php echo $qryDateTitle; ?><?php echo $dateqryValue; ?> <?php echo $spacing; ?>
					<?php
						}
					?>
						<div id="headingtextprobold"> <br />No of Deals : <?php echo $totDeals; ?>  <br /> <br/></div>
						<div id="headingtextprobold"> Value (US $M) : <?php echo $totDealsAmount; ?>   <br /></div>
						</div>
					<?php
					}
                                          
			?>
    </div>

    </td>

    </tr>
    </table>

    </div>
    <div class=""></div>
            <input type="hidden" id="prev" value="<?php echo $prevpage; ?>"/>
            <input type="hidden" id="current" value="<?php echo $currentpage; ?>"/>
            <input type="hidden" id="next" value="<?php echo $nextpage; ?>"/>
            <script src="<?php echo $refUrl; ?>js/listviewfunctions.js"></script>
             <script type="text/javascript">
                 orderby='<?php echo $orderby; ?>';
                 ordertype='<?php echo $ordertype; ?>';
                $(".jp-next").live("click",function(){
                    if(!$(this).hasClass('jp-disabled')){
                    pageno=$("#next").val();
                    loadhtml(pageno,orderby,ordertype);}
                    return  false;
                });
                $(".jp-page").live("click",function(){
                    pageno=$(this).text();
                    loadhtml(pageno,orderby,ordertype);
                    return  false;
                });
                $(".jp-previous").live("click",function(){
                    if(!$(this).hasClass('jp-disabled')){
                    pageno=$("#prev").val();
                    loadhtml(pageno,orderby,ordertype);
                    }
                    return  false;
                });
		$(".header").live("click",function(){
                    orderby=$(this).attr('id');
                    
                    if($(this).hasClass("asc"))
                        ordertype="desc";
                    else
                        ordertype="asc";
                    loadhtml(1,orderby,ordertype);
                    return  false;
                });          
               function loadhtml(pageno,orderby,ordertype)
               {
                jQuery('#preloading').fadeIn(1000);   
                $.ajax({
                type : 'POST',
                url  : 'ajaxListview_report.php',
                data: {

                        sql : '<?php echo addslashes($ajaxcompanysql); ?>',
                        totalrecords : '<?php echo addslashes($report_cntall); ?>',
                        page: pageno,
                        vcflagvalue:'<?php echo $vcflagValue; ?>',
                        orderby:orderby,
                        ordertype:ordertype
                },
                success : function(data){
                    
                        $(".view-table-list").html(data);
                        $(".jp-current").text(pageno);
                       var prev=parseInt(pageno)-1
                        if(prev>0)
                        $("#prev").val(pageno-1);
                        else
                        {
                        $("#prev").val(1);
//                        $(".jp-previous").addClass('.jp-disabled').removeClass('.jp-previous');
                        }
                        $("#current").val(pageno);
                       var  next=parseInt(pageno)+1;
                        if(next < <?php echo $totalpages ?> )
                         $("#next").val(next);
                        else
                        {
                        $("#next").val(<?php echo $totalpages ?>);
//                        $(".jp-next").addClass('.jp-disabled').removeClass('.jp-next');
                        }
                        drawNav(<?php echo $totalpages ?>,parseInt(pageno))
                        jQuery('#preloading').fadeOut(500); 
                       
                        return  false;
                        
                       
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                        jQuery('#preloading').fadeOut(500);
                        alert('There was an error');
                }
            });
               }
			
                $("a.postlink").live('click',function(){
                  
                    $('<input>').attr({
                    type: 'hidden',
                    id: 'foo',
                    name: 'searchallfield',
                    value:'<?php echo $searchallfield; ?>'
                    }).appendTo('#pesearch');
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    
                });
                function resetinput(fieldname)
                {
                  $("#resetfield").val(fieldname);
                  //alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }
            </script>
            <script type="text/javascript">
        
           $('#expshowdeals').click(function(){ 
            hrefval= 'exportinvdeals.php';
            
            $("#pelisting").submit();
            return false;
            });
            $('#expshowdeals1').click(function(){ 
            hrefval= 'exportinvdeals.php';
            
            $("#pelisting").submit();
            return false;
            });
            
                $("a.postlink").live('click',function(){
                   $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    
                });
                 
                  function resetinput(fieldname)
                {
                 
               // alert($('[name="'+fieldname+'"]').val());
                  $("#resetfield").val(fieldname);
                //  alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }
            </script>
                </div>
    </form>
    <form name="pelisting"  method="post" action="exportincdeals.php" id="pelisting">
    <input type="hidden" name="txtsearchon" value="1" >
    <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
    <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
    <input type="hidden" name="txthideindustry" value=<?php echo $industryvalue; ?> >
    <input type="hidden" name="txthideindustryid" value=<?php echo $industry; ?> >
    <input type="hidden" name="txthidestage" value=<?php echo $statusvalue; ?> >
    <input type="hidden" name="txthidestageid" value=<?php echo $status; ?> >
    <input type="hidden" name="txthidefirmtypeid" value=<?php echo $incfirmtype; ?> >
    <input type="hidden" name="txthidedefunct" value=<?php echo $defunctflag; ?> >
    <input type="hidden" name="txthidedefunctvalue" value=<?php echo $defunctText; ?> >
    <input type="hidden" name="txthidefollowonfund" value=<?php echo $followonFund; ?> >
    <input type="hidden" name="txthidefollowonfundvalue" value=<?php echo $followonFundText; ?> >
    <input type="hidden" name="txthideregion" value=<?php echo $regionId; ?> >
    <input type="hidden" name="txthideregiontext" value=<?php echo $regionvalue; ?> >
    <input type="hidden" name="txthideinvestor" value=<?php echo $keywordhidden; ?> >
    <input type="hidden" name="txthidecompany" value=<?php echo $companysearchhidden; ?> >
    <input type="hidden" name="txthidesearchallfield" value=<?php echo $searchallfieldhidden; ?> >
    </form>
    </body>
    </html>

    <?php
    function returnMonthname($mth)
    {
        if($mth==1)
                return "Jan";
        elseif($mth==2)
                return "Feb";
        elseif($mth==3)
                return "Mar";
        elseif($mth==4)
                return "Apr";
        elseif($mth==5)
                return "May";
        elseif($mth==6)
                return "Jun";
        elseif($mth==7)
                return "Jul";
        elseif($mth==8)
                return "Aug";
        elseif($mth==9)
                return "Sep";
        elseif($mth==10)
                return "Oct";
        elseif($mth==11)
                return "Nov";
        elseif($mth==12)
                return "Dec";
    }
    function writeSql_for_no_records($sqlqry,$mailid)
    {
    $write_filename="pe_query_no_records.txt";
    //echo "<Br>***".$sqlqry;
                        $schema_insert="";
                        //TRYING TO WRIRE IN EXCEL
                                                 //define separator (defines columns in excel & tabs in word)
                                                         $sep = "\t"; //tabbed character
                                                         $cr = "\n"; //new line

                                                         //start of printing column names as names of MySQL fields

                                                                print("\n");
                                                                 print("\n");
                                                         //end of printing column names
                                                                        $schema_insert .=$cr;
                                                                        $schema_insert .=$mailid.$sep;
                                                                        $schema_insert .=$sqlqry.$sep;
                                                                        $schema_insert = str_replace($sep."$", "", $schema_insert);
                                                            $schema_insert .= ""."\n";

                                                                        if (file_exists($write_filename))
                                                                        {
                                                                                //echo "<br>break 1--" .$file;
                                                                                 $fp = fopen($write_filename,"a+"); // $fp is now the file pointer to file
                                                                                         if($fp)
                                                                                         {//echo "<Br>-- ".$schema_insert;
                                                                                                fwrite($fp,$schema_insert);    //    Write information to the file
                                                                                                  fclose($fp);  //    Close the file
                                                                                                // echo "File saved successfully";
                                                                                         }
                                                                                         else
                                                                                                {
                                                                                                echo "Error saving file!"; }
                                                                        }

                                                 print "\n";

    }
    mysql_close();
    ?>
<script type="text/javascript" >
        <?php  if($_POST || $vcflagValue==6)
        { ?>
             $("#panel").animate({width: 'toggle'}, 200); 
             $(".btn-slide").toggleClass("active"); 
             if ($('.left-td-bg').css("min-width") == '264px') {
             $('.left-td-bg').css("min-width", '36px');
             $('.acc_main').css("width", '35px');
             }
             else {
             $('.left-td-bg').css("min-width", '264px');
             $('.acc_main').css("width", '264px');
             } 
        <?php } ?>
                                        
    </script> 
    <?php  mysql_close(); ?>