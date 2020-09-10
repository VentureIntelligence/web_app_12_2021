<?php include_once("../globalconfig.php"); ?>
<?php
setlocale(LC_MONETARY, 'en_IN');


$vcflagValue = 2;
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
$videalPageName = "AngelCoInv";
include ('checklogin.php');
$topNav = 'Deals';
$pagename ='AngelCo';

 $filter='';
if($_POST){
    
    
    if($_POST['companysearch']!=''){
        $companysearch = stripslashes($_POST['companysearch']);
        $companysearchhidden=$companysearch;
        $filter .= " a.company_name IN ($companysearch)  ";
    }
    
    if($_POST['location']!=''){
        $location = $_POST['location'];
        $locationhidden=$location;
        if($filter=='')
            $filter .= "  a.location ='$location'  ";
        else
            $filter .= " and a.location ='$location'  "; 
    }
    
    
                //amount filter
                if( $_POST['amount_from']!='' ||  $_POST['amount_to']!=''){

                    $amount_from = $_POST['amount_from'];
                    $amount_to = $_POST['amount_to'];

                    $amount_from_hidden = $amount_from;
                    $amount_to_hidden = $amount_to;
                    
                    if( $amount_from!='' &&  $amount_to==''){
                        
                        $Amt_from = $amount_from*1000;

                        if($filter=='')
                        $filter .= "  a.raising_amount >=  $Amt_from     ";
                      else
                        $filter .= " and  a.raising_amount >=   $Amt_from   ";

                    }
                    elseif( $amount_from=='' &&  $amount_to!=''){
                        
                         $Amt_to = $amount_to*1000;

                        if($filter=='')
                        $filter .= "  a.raising_amount <=  $Amt_to     ";
                      else
                        $filter .= " and  a.raising_amount <=   $Amt_to   ";

                    }
                    elseif( $amount_from <  $amount_to){
                        
                        $Amt_from = $amount_from*1000;
                        $Amt_to = $amount_to*1000;

                        if($filter=='')
                        $filter .= "  a.raising_amount  BETWEEN  $Amt_from  and  $Amt_to   ";
                      else
                        $filter .= " and  a.raising_amount  BETWEEN  $Amt_from  and  $Amt_to   ";
 
                    }



                }
                //amount filter end
    
    
    if($filter!=''){
        $filter = '  WHERE '.$filter;
    }
    
    
   
    
}else{
     if($filter==''){
        $filter = '  WHERE raising_amount >= 10000  ' ;
    }
}



$currentpage =1;
$ordertype='asc';
$query1 =" SELECT a.*,p.PECompanyId FROM angelco_fundraising_cos   a LEFT JOIN  pecompanies p ON p.angelco_compID=a.angel_id   $filter "; 
$totalAngelCo = mysql_query($query1);



$orderby="  ORDER BY a.company_name ASC ";
$query2 ="  SELECT a.*,p.PECompanyId FROM angelco_fundraising_cos   a LEFT JOIN  pecompanies p ON p.angelco_compID=a.angel_id  $filter  ";

$angelquery  = $query2 . $orderby."  LIMIT 0, 50";

$angelco = mysql_query($angelquery);

//
//
//
// detail view tab
$angelquery2   = $query2 . $orderby."  LIMIT 1";
$angelco2 = mysql_fetch_array(mysql_query($angelquery2));

if($angelco2['PECompanyId']!='' && $angelco2['PECompanyId']>0){
    $detail_data = "value=".$angelco2['PECompanyId']."/$vcflagValue"; 
}
elseif($angelco2['angel_id']!='' && $angelco2['angel_id']>0){
    $detail_data = "value=".$angelco2['angel_id']."/$vcflagValue&angelco_only"; 
}

//

function moneyFormatIndia($num){
    $explrestunits = "" ;
    if(strlen($num)>3){
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++){
            // creates each of the 2's group and adds a comma to the end
            if($i==0)
            {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            }else{
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash; // writes the final format where $currency is the currency symbol.
}


function moneyFormatUS($num){
    $explrestunits = "" ;
    if(strlen($num)>3){
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%3 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 3);
        for($i=0; $i<sizeof($expunit); $i++){
            // creates each of the 2's group and adds a comma to the end
            if($i==0)
            {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            }else{
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash; // writes the final format where $currency is the currency symbol.
}


include_once('angelcoheader_search.php');


?>
<div id="container" >
    <table cellpadding="0" cellspacing="0" width="100%" >
        <tr>
            <td class="left-td-bg" >
                <div class="acc_main">
                    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>

                    <div id="panel" style="display:block; overflow:visible; clear:both;">

                        <?php include_once('angelcorefine.php'); ?>
                        <input type="hidden" name="resetfield" value="" id="resetfield"/>	
                    </div>
                </div>
            </td>  
            <td class="profile-view-left" style="width:100%;">

                <div class="result-cnt" style="margin-top:10px;margin-bottom: 30px;">

                    <div class="result-title">
                        <div class="lft-cn">  
                            <ul  class="result-select">
                                <?php if($_POST){ ?>    
                                <?php
                                if($companysearch !='' ){ ?>
                                <li>
                                        <?php echo$_POST['companyauto']?><a  onclick="resetClearinput3('<?php echo $_REQUEST['companyauto']?>');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 

                                if($location !='' ){ ?>
                                <li>
                                        <?php echo $location; ?><a  onclick="resetClearinput('location');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 


                                if($amount_from !='' ){ ?>
                                <li>
                                        <?php echo "(US $ K) ".$amount_from."-".$amount_to; ?><a  onclick="resetClearinput2('amount');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } ?>

                                <?php } else { ?>
                                <li>
                                        <?php echo "(US $ K) 10-"; ?><a  onclick="resetClearinput2('amount');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="result-rt-cnt">
                            <div class="result-count">
                                <span class="result-no"><?php echo mysql_num_rows($totalAngelCo) ?> Results Found </span> 
                                <span class="result-for"> for Fund Raising</span> 
                                <div class="title-links " id="exportbtn"><input class ="export" type="button" id="expshowdeals"  value="Export" name="showdeals"></div>
                            </div>
                        </div>      
                    </div>                  
                </div>
                    <div style="margin-top: -25px; margin-left: 35%; position: relative;width: 450px;float: left;">
                        <label style="float:left"  ><input type="radio" name="angelnav" class="angelnav" value="1"  >Funded Companies</label>
                        <label style="float:left; margin-left: 15px;"  ><input type="radio" name="angelnav" class="angelnav" value="2" checked>Fundraising Companies 
                            <img src="img/powered_by.png" style="position: absolute;    right: 25px;    top: -9px;" > 
                        </label>
                    </div>
<!--                    <div class="list-tab mt-trend-tab" style="margin-top: 122px !important;"><ul>
                            <li class="active"><a class="postlink"   href="angelcoindex.php"  id="icon-grid-view"><i></i> List  View</a></li>

                            <li><a id="icon-detailed-view" class="postlink" href="companydetails.php?<?php echo $detail_data?>&raisingcomp" ><i></i> Detail  View</a></li> 
                            <li style="float:right"><img src="img/angle-list.png" alt="angle-list" style="padding:5px;float:right"></li>
                        </ul>
                    </div>-->

                    <a id="detailpost" class="postlink"></a>
                    <div class="view-table view-table-list">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
                            <thead><tr>
                                    <th class="header <?php echo ($orderby == "company_name") ? $ordertype : ""; ?>"  id="company_name"> Company Name</th>
                                    <th class="header asc <?php echo ($orderby == "raising_amount") ? $ordertype : ""; ?>" id="raising_amount">Raising Amount(US $)</th>
                                    <th  class="header <?php echo ($orderby == "location") ? $ordertype : ""; ?>" id="location">Location</th>
                                    <th class="header" style="width: 250px; background: none"   id="high_concept">Description</th>
                                    <th class="header" style="width: 150px; background: none" id="website">Website</th>

                                </tr></thead>
                            <tbody id="movies">
                                
                                <?php
                                while ($co = mysql_fetch_array($angelco)) {
                                    if($co['PECompanyId']!='' && $co['PECompanyId']>0){
                                        $data = "value=".$co['PECompanyId']."/$vcflagValue&raisingcomp"; 
                                    }
                                    elseif($co['angel_id']!='' && $co['angel_id']>0){
                                        $data = "value=".$co['angel_id']."/$vcflagValue&angelco_only&raisingcomp"; 
                                    }
                                    
                                  ?>
                                <tr  class="details_link" valueid="<?php echo $data?>" >
                                    <td> <a class="postlink" href="companydetails.php?<?php echo $data?>" style="text-decoration: none"> <?php echo $co['company_name'] ?> </a></td>
                                    <td> <a class="postlink" href="companydetails.php?<?php echo $data?>" style="text-decoration: none"> <?php echo number_format($co['raising_amount'])  ?> </a></td>
                                    <td> <a class="postlink" href="companydetails.php?<?php echo $data?>" style="text-decoration: none"> <?php echo $co['location'] ?>  </a></td>
                                    <td> <a class="postlink" href="companydetails.php?<?php echo $data?>" style="text-decoration: none"> <?php echo $co['high_concept'] ?>  </a></td>
                                    <td> <a class="postlink" href="companydetails.php?<?php echo $data?>" style="text-decoration: none"> <?php echo $co['company_url'] ?>  </a></td>
                                </tr>    
                                <?php 
                                }
                                
                                ?>

                            </tbody>
                        </table>

                    </div>			


                    
                       <div class="holder">
                 <?php
                    $totalpages=  ceil(mysql_num_rows($totalAngelCo)/50); 
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
    <div>&nbsp;</div>
    <div>&nbsp;</div>
    
    
    

                </div>

            </td>

        </tr>
    </table>

</div>
</form>
<form name="companyDisplay" id="angelco" method="post" action="exportangelco.php">
    <input type="hidden" name="companyhidden" value="<?php echo $companysearchhidden; ?>" >
    <input type="hidden" name="locationhidden" value="<?php echo $locationhidden; ?>" >
    <input type="hidden" name="amount_to_hidden" value="<?php echo $amount_to_hidden; ?>" >    
    <input type="hidden" name="amount_from_hidden" value="<?php echo $amount_from_hidden; ?>" >
</form>
<div class=""></div>

</div>



 <input type="hidden" id="prev" value="<?php echo $prevpage; ?>"/>
            <input type="hidden" id="current" value="<?php echo $currentpage; ?>"/>
            <input type="hidden" id="next" value="<?php echo $nextpage; ?>"/>
            <script src="js/listviewfunctions.js"></script>
            <script type="text/javascript">
                
                
                
                function resetClearinput(fieldname)
                {
                  $("#"+fieldname).val('');
                  $("#pesearch").submit();
                    return false;
                }
                 function resetClearinput2(fieldname)
                {
                  $("#amount_from, #amount_to").val('');
                  $("#pesearch").submit();
                    return false;
                }
                
                 function resetClearinput3(fieldname)
                {
                  $("#companyauto, #companysearch").val('');
                  $("#pesearch").submit();
                    return false;
                }
                
                
                
                  $(document).ready(function(){ 
                      
                      
                      
                           $('.angelnav').on('ifChecked', function(event){

                            val = $('input[name=angelnav]:checked').val();
                            if(val==1){
                                window.location.href='angelindex.php';
                            }
                             else if(val==2){
                               window.location.href='angelcoindex.php';
                            }
                         });
           
           
           
           
      $('#pesearch').attr('action','angelcoindex.php');
          }); 
                
                
                
                
                orderby='company_name';
                 ordertype='asc';
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
                    
                    if($(this).hasClass("asc")){
                        ordertype="desc";
                    }
                    else{
                        ordertype="asc";
                    }
                    loadhtml(1,orderby,ordertype);
                    return  false;
                });    
		
    
               
               function loadhtml(pageno,orderby,ordertype)
               {
                jQuery('#preloading').fadeIn(1000);   
                $.ajax({
                type : 'POST',
                url  : 'angelcoindexAjax.php',
                data: {

                        sql : '<?php echo addslashes($query2); ?>',
                        totalrecords : '<?php echo mysql_num_rows($totalAngelCo); ?>',
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
                        var next=parseInt(pageno)+1;
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
               
            $('#expshowdeals').click(function(){ 
                jQuery('#preloading').fadeIn();   
                initExport();
                return false;
            });
               
           
            function initExport(){
                    $.ajax({
                        url: 'ajxCheckDownload.php',
                        dataType: 'json',
                        success: function(data){
                            var downloaded = data['recDownloaded'];
                            var exportLimit = data.exportLimit;
                            var currentRec = <?php echo mysql_num_rows($totalAngelCo); ?>;
			
                            //alert(currentRec + downloaded);
                            var remLimit = exportLimit-downloaded;
               
                            if (currentRec < remLimit){
                                hrefval= 'exportangelco.php';
                                $("#angelco").attr("action", hrefval);
                                $("#angelco").submit();
                                jQuery('#preloading').fadeOut();
                            }else{
                                jQuery('#preloading').fadeOut();
                                //alert("You have downloaded "+ downloaded +" records of allowed "+ exportLimit +" records(within 48 hours). You can download "+ remLimit +" more records.");
                                alert("Currently your export action is crossing the limit of "+ exportLimit +" records. You can download "+ remLimit +" more records. To increase the limit please contact info@ventureintelligence.com");
                            }
                        },
                        error:function(){
                            jQuery('#preloading').fadeOut();
                            alert("There was some problem exporting...");
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
                $("a.postlink").click(function(){
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
                $(document).on('click', 'tr .details_link', function(){ 
                
                idval=$(this).attr("valueId");
                $("#detailpost").attr("href","<?php echo GLOBAL_BASE_URL; ?>dev/dealsnew/companydetails.php?"+idval).trigger("click");
            });
            </script>
    </body>
</html>
<?php
mysql_close();
    mysql_close($cnx);
    ?>
