<?php
        $companyId=632270771;
        $compId=0;
        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
        $company_cntall=$_POST['totalrecords'];
        $companysql=  urldecode($_POST['sql']);
        $vcflagValue=$_POST['vcflagvalue'];
        $dealvalue=$_POST['dealvalue'];
        if($company_cntall > 0)
        {
         $rec_limit = 100;
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

<?php
        if ($rsinvestor = mysql_query($companysqlwithlimit))
        {
              $investor_cnt = mysql_num_rows($rsinvestor);
        }
        $rowlimit=25;
        $offset=0;
        $i=1;
        $j=1;
        $newrowflag=1;
        $newcolumnflag=1;
        $columncount=1;
         $columnlimit=4;?>
                            
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTables">
                              <thead><tr>
                                      <?php
                                        if($dealvalue==101)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Target Companies</th>
                                      <?php
                                          }
                                          if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Acquirer Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of  Legal Advisors</th>
                                      <?php
                                          } else if ($dealvalue==104){
                                      ?>
                                               <th colspan="<?php echo $columnlimit; ?>">List of Transaction Advisors</th>
                                      <?php
                                          }
                                      
                                      ?>
                              </tr></thead>
                              
                              <tbody id="movies">
                                  <?php
                                    //Code to add PREV /NEXT
                                        $icount = 0;
                                         if ($_SESSION['resultCompanyId'])
                                        {
                                              unset($_SESSION['resultCompanyId']);
                                        }
                                        if ($_SESSION['acquirerId']) 
                                        {
                                            unset($_SESSION['acquirerId']);
                                        }
                                       
                                        if ($_SESSION['advisorId'])
                                        {
                                              unset($_SESSION['advisorId']);
                                        }
                                     $count=mysql_num_rows($rsinvestor);
                                     //echo "Deal value=".$dealvalue;
                                     
                                  if($dealvalue==101)
                                     {
                                        While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                        {
                                                $companyname=trim($myrow["companyname"]);
                                                $companyname=strtolower($companyname);

                                                $invResult=substr_count($companyname,$searchString);
                                                $invResult1=substr_count($companyname,$searchString1);
                                                $invResult2=substr_count($companyname,$searchString2);
                                               if($newrowflag==1)
                                                   echo "<tr><td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";
                                   
                                                if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                                {
                                                    $_SESSION['resultCompanyId'][$icount++] = $myrow["PECompanyId"];
                                                   
                                   ?><tr>
                                       <td ><a class="postlink" href="dircomdetails.php?value=<?php echo $myrow["PECompanyId"];?>/<?php echo $dealvalue;?> "> <?php echo $myrow["companyname"];?></a></td></tr>
                                   <?php
                                                   $totalCount=$totalCount+1;
                                                  
                                                }
						
                                                $newrowflag=0;
                                                if($i==$rowlimit)
                                                {  
                                                   $i=1;
                                                   echo "</table></td>";
                                                   if($count>$i && $columncount<$columnlimit)
                                                   {

                                                       echo "<td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";                                                           
                                                   }
                                                   elseif ($j==$count) 
                                                   {

                                                      echo "</table></td></tr>";
                                                   }
                                                if($columncount==$columnlimit)
                                                {
                                                    $columncount=1;
                                                    $newrowflag=1;
                                                }
                                                else
                                                {

                                                $columncount++;
                                                }
                                                }
                                                elseif ($j==$count) 
                                                {
                                                      echo "</table></td></tr>";
                                                }
                                                else if(($invResult==0) && ($invResult1==0) && ($invResult2==0)) { 
                                                    $i++;
                                                }
                                                        $j++;
                                           }
                                     }
                                     if($dealvalue==102)
                                     {
                                        While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                        {
                                                $adviosrname=trim($myrow["Acquirer"]);
                                                $adviosrname=strtolower($adviosrname);
                                                $querystrvalue= $myrow["AcquirerId"];
                                                
                                               $invResult=substr_count($adviosrname,$searchString);
                                                $invResult1=substr_count($adviosrname,$searchString1);
                                                $invResult2=substr_count($adviosrname,$searchString2);
                                                
                                               if($newrowflag==1)
                                                   echo "<tr><td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";
                                   
                                                if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                                {
                                                    $_SESSION['acquirerId'][$icount++] = $myrow["AcquirerId"];
                                                   
                                   ?><tr>
                                       <td ><a class="postlink" href="diracquirer.php?value=<?php echo $myrow["AcquirerId"];?>/<?php echo $dealvalue;?> "><?php echo $myrow["Acquirer"];?> </a></td></tr>
                                   <?php
                                                   $totalCount=$totalCount+1;
                                                  
                                                }
						
                                                $newrowflag=0;
                                                if($i==$rowlimit)
                                                {  
                                                   $i=1;
                                                   echo "</table></td>";
                                                   if($count>$i && $columncount<$columnlimit)
                                                   {

                                                       echo "<td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";                                                           
                                                   }
                                                   elseif ($j==$count) 
                                                   {

                                                      echo "</table></td></tr>";
                                                   }
                                                if($columncount==$columnlimit)
                                                {
                                                    $columncount=1;
                                                    $newrowflag=1;
                                                }
                                                else
                                                {

                                                $columncount++;
                                                }
                                                }
                                                elseif ($j==$count) 
                                                {
                                                      echo "</table></td></tr>";
                                                }
                                                else if(($invResult==0) && ($invResult1==0) && ($invResult2==0)) { 
                                                    $i++;
                                                }
                                                        $j++;
                                           }
                                     }
                                     else if($dealvalue==103 || $dealvalue==104)
                                     {
                                        While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                        {
                                                $adviosrname=trim($myrow["Investor"]);
                                                $adviosrname=strtolower($adviosrname);

                                                $invResult=substr_count($adviosrname,$searchString);
                                                $invResult1=substr_count($adviosrname,$searchString1);
                                                $invResult2=substr_count($adviosrname,$searchString2);
                                                if($newrowflag==1)
                                                echo "<tr><td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";
                                                
                                                if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                                {
                                                        $querystrvalue= $myrow["CIAId"];
                                                        $_SESSION['advisorId'][$icount++] = $myrow["CIAId"];
                                         ?>
                                                        <tr><td>
                                                        <a style="text-decoration: none" href='diradvisor.php?value=<?php echo $querystrvalue;?>/<?php echo $dealvalue;?>' >
                                                        <?php echo $myrow["Cianame"]; ?></a></td></tr>
                                                <?php
                                                        $totalCount=$totalCount+1;
                                                }
                                                 $newrowflag=0;
                                                if($i==$rowlimit)
                                                {  
                                                   $i=1;
                                                   echo "</table></td>";
                                                   if($count>$i && $columncount<$columnlimit)
                                                   {

                                                       echo "<td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";                                                           
                                                   }
                                                   elseif ($j==$count) 
                                                   {

                                                      echo "</table></td></tr>";
                                                   }
                                                if($columncount==$columnlimit)
                                                {
                                                    $columncount=1;
                                                    $newrowflag=1;
                                                }
                                                else
                                                {

                                                $columncount++;
                                                }
                                                }
                                                elseif ($j==$count) 
                                                {
                                                      echo "</table></td></tr>";
                                                }
                                                else if(($invResult==0) && ($invResult1==0) && ($invResult2==0)) { 
                                                    $i++;
                                                }
                                                        $j++;
                                        }
                                     }
                                  ?>
                              </tbody> 
                              
                             </table>
                       
    <?php mysql_close(); ?>