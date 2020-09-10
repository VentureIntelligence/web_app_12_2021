<?php
 require_once("../dbconnectvi.php");
 $Db = new dbInvestments();
 $searchString="Undisclosed";
 $searchString=strtolower($searchString);
 $searchString1="Unknown";
 $searchString1=strtolower($searchString1);

//Company Sector
$searchString="Undisclosed";
$searchString=strtolower($searchString);

$searchString1="Unknown";
$searchString1=strtolower($searchString1);

$searchString2="Others";  
$searchString2=strtolower($searchString2);
$company_cntall=$_POST['totalrecords'];
$companysql=  urldecode($_POST['sql']);
$orderby=$_POST['orderby'];
$ordertype=$_POST['ordertype'];
$searchallfieldFlag = $_POST[ 'searchField' ];

if($companysql!="" && $orderby!="" && $ordertype!="") {
    if($orderby=="sector_business")
        $orderstr="order by ".$orderby." ".$ordertype.","." i.industry ".$ordertype ;
    else
        $orderstr="order by ".$orderby." ".$ordertype;
    $companysql = $companysql . " ". $orderstr ;  
}

if(!empty($_POST[ 'uncheckRows' ])){
    
    $uncheckRows = $_POST[ 'uncheckRows' ];
    $uncheckArray = explode( ',', $uncheckRows );
}else{
    $uncheckArray=[];
}

if(!empty($_POST[ 'checkedRow' ])){
    
    $checkedRow = $_POST[ 'checkedRow' ];
    $checkedArray = explode( ',', $checkedRow );
}else{
    $checkedArray=[];
}
    //echo $uncheckRows;
if($company_cntall > 0)
{
    $rec_limit = 50;
    $rec_count = $company_cntall;

    if( isset($_POST['page']) )
    {
    
    $currentpage=$_POST['page']-1;
    $page = $_POST['page']-1;
    $offset = $rec_limit * $page ;
    }
    else
    {
    $currentpage=1;
    $page = 1;
    $offset = 0;
    }
    $left_rec = $rec_count - ($page * $rec_limit);
    $companysqlwithlimit=$companysql." limit $offset, $rec_limit";
    //echo  $companysqlwithlimit;
    if ($companyrs = mysql_query($companysqlwithlimit))
    {
        $company_cnt = mysql_num_rows($companyrs);
    }
             //$searchTitle=" List of Deals";
}
else
{
     $searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
     $notable=true;
     writeSql_for_no_records($companysql,$emailid);
}

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
                              <thead><tr>
                              <?php 
                        if( $searchallfieldFlag != '') {

                            if(count($uncheckArray) == 0){ 

                                $allchecked= 'checked'; 
                            }
                            
                            if($_POST['full_uncheck_flag']!='' && $_POST['full_uncheck_flag'] ==1 ){

                                $allchecked='';
                            } 
                            ?>
                            <th class=""><input type="checkbox" class="all_checkbox" id="all_checkbox" <?php echo $allchecked; ?>/></th>
                        <?php } ?>

                                <th style="width: 745px;" class="header <?php echo ($orderby=="companyname")?$ordertype:""; ?>" id="companyname">Target</th>
                                <th style="width: 625px;" class="header <?php echo ($orderby=="sector_business")?$ordertype:""; ?>" id="sector_business">Sector</th>
                                <th style="width: 625px;" class="header <?php echo ($orderby=="Acquirer")?$ordertype:""; ?>" id="Acquirer">Acquirer</th>
                                <th style="width: 205px;" class="header <?php echo ($orderby=="DealDate")?$ordertype:""; ?>" id="DealDate">Date</th>
                                <th style="width: 153px;" class="header <?php echo ($orderby=="Amount")?$ordertype:""; ?>" id="Amount">Amount (US$M)</th>
                                </tr></thead>
                              <tbody id="movies">
                        <?php
                        if ($company_cnt>0)
                          {
                            $hidecount=0;
                        While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                        
                                                {

                                                    $hideFlagset = 0;

                                                        $searchString4="PE Firm(s)";
                                                        $searchString4=strtolower($searchString4);
                                                        $searchString4ForDisplay="PE Firm(s)";

                                                        $searchString="Undisclosed";
                                                        $searchString=strtolower($searchString);

                                                        $searchString3="Individual";
                                                        $searchString3=strtolower($searchString3);

                                                        $companyName=trim($myrow["companyname"]);
                                                        $companyName=strtolower($companyName);
                                                        $compResult=substr_count($companyName,$searchString);
                                                        $compResult4=substr_count($companyName,$searchString4);

                                                        $acquirerName=$myrow["Acquirer"];
                                                        $acquirerName=strtolower($acquirerName);

                                                        $compResultAcquirer=substr_count($acquirerName,$searchString4);
                                                        $compResultAcquirerUndisclosed=substr_count($acquirerName,$searchString);
                                                        $compResultAcquirerIndividual=substr_count($acquirerName,$searchString3);

                                                        if($compResult==0)
                                                                $displaycomp=$myrow["companyname"];
                                                        elseif($compResult4==1)
                                                                $displaycomp=ucfirst("$searchString4");
                                                        elseif($compResult==1)
                                                                $displaycomp=ucfirst("$searchString");

                                                        if(($compResultAcquirer==0) && ($compResultAcquirerUndisclosed==0) && ($compResultAcquirerIndividual==0))
                                                                $displayAcquirer=$myrow["Acquirer"];
                                                        elseif($compResultAcquirer==1)
                                                                $displayAcquirer=ucfirst("$searchString4ForDisplay");
                                                        elseif($compResultAcquirerUndisclosed==1)
                                                                $displayAcquirer=ucfirst("$searchString");
                                                        elseif($compResultAcquirerIndividual==1)
                                                                $displayAcquirer=ucfirst("$searchString3");
                                                            $sector=$myrow["sector_business"];
                                                        if($myrow["Asset"]==1)
                                                        {
                                                                $openBracket="(";
                                                                $closeBracket=")";
                                                                //$hideFlagset = 1;
                                                        }
                                                        else
                                                        {
                                                                $openBracket="";
                                                                $closeBracket="";
                                                        }
                                                        
                                                        if($myrow["dates"]!="")
                                                        {
                                                                
                                                                $displaydate=$myrow["dates"];
                                                        }
                                                        else
                                                        {
                                                                $displaydate="-";
                                                        }
                                                        if($myrow["Amount"]==0)
                                                        {
                                                                $hideamount="";
                                                                $amountobeAdded=0;
                                                        }
                                                        elseif($myrow["hideamount"]==1)
                                                        {
                                                                $hideamount="";
                                                                $amountobeAdded=0;

                                                        }
                                                        else
                                                        {
                                                                $hideamount=$myrow["Amount"];
                                                                //$acrossDealsCnt=$acrossDealsCnt+1;
                                                                $amountobeAdded=$myrow["Amount"];
                                                        }
                                                         if($myrow["AggHide"]==1)
                                                        {
                                                                $opensquareBracket="{";
                                                                $closesquareBracket="}";
                                                                $amtTobeDeductedforAggHide=$myrow["Amount"];
                                                                $NoofDealsCntTobeDeducted=1;
                                                                if($myrow["Amount"] != 0){
                                                                    $acrossDealsCnt=$acrossDealsCnt-1;
                                                                }
                                                                $hideFlagset = 1;
                                                         }
                                                        else
                                                        {
                                                                $opensquareBracket="";
                                                                $closesquareBracket="";
                                                                $amtTobeDeductedforAggHide=0;
                                                                $NoofDealsCntTobeDeducted=0;
                                                        }
                                                        if(trim($myrow["sector_business"])=="")
                                                                $showindsec=$myrow["industry"];
                                                        else
                                                                $showindsec=$myrow["sector_business"];

                                                        ?>

                                                        <?php
                                                        if($searchallfieldFlag != ''){
                                        
                                        if(count($uncheckArray) > 0 && $uncheckArray[0]!='' &&  count($checkedArray) > 0 && $checkedArray[0]!=''){

                                                if( (in_array( $myrow["MAMAId"], $uncheckArray )) ) {
                                                        $checked = '';
                                                        $rowClass = 'event_stop';

                                                } 
                                                elseif( (in_array( $myrow["MAMAId"], $uncheckArray )) ) {
                                                        $checked = 'checked';
                                                        $rowClass = '';

                                                } 
                                                elseif($_POST['full_uncheck_flag']==1){
                                                    $checked = '';
                                                    $rowClass = 'event_stop';
                                                }
                                                elseif($_POST['full_uncheck_flag']==''){
                                                    $rowClass = '';
                                                    $checked = 'checked';
                                                }

                                            }
                                            elseif(!empty( $uncheckArray )  && $uncheckArray[0]!=''){

                                                if( (in_array( $myrow["MAMAId"], $uncheckArray )) ) {
                                                        $checked = '';
                                                        $rowClass = 'event_stop';

                                                }elseif($_POST['full_uncheck_flag']==1){
                                                    $checked = '';
                                                    $rowClass = 'event_stop';
                                                } else {
                                                        $checked = 'checked';
                                                        $rowClass = '';
                                                }

                                            }elseif( !empty( $uncheckArray ) && $uncheckArray[0]!=''){

                                                if( (in_array( $myrow["MAMAId"], $uncheckArray )) ) {
                                                        $checked = 'checked';
                                                        $rowClass = '';

                                                }elseif($_POST['full_uncheck_flag']==1){
                                                    $checked = '';
                                                    $rowClass = 'event_stop';
                                                } else {
                                                        $checked = '';
                                                        $rowClass = 'event_stop';
                                                }

                                            }elseif($_POST['full_uncheck_flag']==1){

                                                $checked = '';
                                                $rowClass = 'event_stop';
                                            } else{

                                                $checked = 'checked';
                                                $rowClass = '';
                                            }
                                    }
                                ?>

                                                        <tr class="details_link <?php echo $rowClass; ?>" valueId="<?php echo $myrow["MAMAId"];?>">
                                                        
                                                        <?php
                                                        if($searchallfieldFlag != ''){ ?>

                                                        <td><input type="checkbox" data-deal-amount="<?php echo $myrow['Amount']; ?>" data-hide-flag="<?php echo $hideFlagset; ?>" data-company-id="<?php echo $myrow[ 'PECompanyId' ]; ?>" class="pe_checkbox" <?php echo $checked; ?> value="<?php echo $myrow["MAMAId"];?>" /></td>

                                                        <?php } ?>

                                                        <?php

                                                        //Session Variable for storing Id. To be used in Previous / Next Buttons
                                                        $_SESSION['resultId'][$icount++] = $myrow["MAMAId"];
                                                        ?>
                                                            <td style="width: 745px;"><?php echo $openBracket ; ?><?php echo $opensquareBracket; ?><a class="postlink" href="madealdetails.php?value=<?php echo $myrow["MAMAId"];?>"><?php echo $displaycomp;?>  </a> <?php echo $closesquareBracket; ?><?php echo $closeBracket ; ?></td>
                                                            <td style="width: 625px;"><a class="postlink" href="madealdetails.php?value=<?php echo $myrow["MAMAId"];?>"><?php echo $sector; ?></a></td>
                                                            <td style="width: 625px;"><a class="postlink" href="madealdetails.php?value=<?php echo $myrow["MAMAId"];?>"><?php echo $displayAcquirer; ?></a></td>
                                                            <td style="width: 205px;"><a class="postlink" href="madealdetails.php?value=<?php echo $myrow["MAMAId"];?>"><?php echo $displaydate; ?></a></td>
                                                            <td style="width: 153px;"><a class="postlink" href="madealdetails.php?value=<?php echo $myrow["MAMAId"];?>"><?php echo $hideamount; ?>&nbsp;</a></td>

                                                        </tr>
                                <!--</tbody>-->
                            <?php
                                                                $industryAdded = $myrow["industry"];
                            }
                        }
                        ?>
                        </tbody>
                  </table>

                  

                  <script>
                    $('input').iCheck({
                        checkboxClass: 'icheckbox_flat-red',
                        radioClass: 'iradio_flat-red'
                    });
                    
                  </script>
<?php mysql_close(); ?>