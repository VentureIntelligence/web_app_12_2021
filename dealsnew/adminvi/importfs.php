<?php
  require ("../dbConnect_cfs.php");
  require ("mod_cfs.php");
 $dbconnFS = new db_connection();
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
 session_start();
/*
 filename : importfs.php
 uses mod_cfs for function returns
 */
         $operationanl_income=0;
         $other_income=0;
         $op_admin_other_exp=0;
         $operating_profit=0;
         $EBITDA_val=0;
         $interest_val=0;
         $EBDT_val=0;
         $depreciation_val=0;
         $EBT_pre_extraitems=0;
         //$extra_items=0;
         //$EBT_post_extraitems =0;
         $tax_val=0;
         $PAT_val=0;
         //$PAT_after_minority_interest=0;
         $eps_val=0;
            //   echo "<bR>^^^***^^^^";
          if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	 	{

                //$file ="importfiles/peinvestmentsexport.txt";
                	$currentdir=getcwd();
			$target = $currentdir . "/importfiles/" . basename($_FILES['txtcfs']['name']);
			$file = "importfiles/" . basename($_FILES['txtcfs']['name']);
        		//echo"<br>************".$target;
			if (!(file_exists($file)))
			{

        			if(move_uploaded_file($_FILES['txtcfs']['tmp_name'], $target))
				{
					//echo "<Br>The file ". basename( $_FILES['txtfilepath']['name']). " has been uploaded";
					echo "<br>File is getting uploaded . Please wait..";
					$file = "importfiles/" . basename($_FILES['txtcfs']['name']);
					//echo "<br>----------------" .$file;

				}
				else
				{
					echo "<br>Sorry, there was a problem uploading the file.";
				}
			}
			$importTotal=0;

                        
                        if (file_exists($file))
			{
			if ($file !="")
			{
			echo "<Br>File is being read. It will take time to import all data. Please wait....";
				$fp = fopen($file, "r") or die("Couldn't open file");
				//$data = fread($fp, filesize($fp));
				while(!feof($fp))
				{		$data .= fgets($fp, 1024);
				}
				fclose($fp);
			
				$values = explode("\n", $data);

                                for($i=0;$i<=9;$i++)
				{
						if($values[$i] != "")
						{
							//echo "<br>full string- " .$i;
							$fstring = explode("\t", $values[$i]);

							if(trim($fstring[1])=="")
							{ $compdetails[$i]=0;  }
                                                else
                                                { $compdetails[$i] = trim($fstring[1]);
                                                }
                                                 //echo "<br>--". $i ."-" .$compdetails[$i];
					        }
				}

                             $fullcompany_name=$compdetails[0];
                             $company_id=insert_company($fullcompany_name);
                             //echo "<bR>CompanyId- ".$company_id;
                             if($compdetails[1]!="0")
                             {
                               $parent_company_name=$compdetails[1];
                               //$parent_company_id=$_POST['parentcompanyid'];
                               $parent_company_id=insert_company($parent_company_name);
                             }
                             else
                             {
                               $parent_company_name="";
                               $parent_company_id="";
                             }
                             if($compdetails[2]!="0")
                             {

                                $industry_name=$compdetails[2];
                                $industry_id=return_industryid($industry_name);
                             }
                             else
                             {
                                 $industry_name="";
                                 $industry_id=0;  
                             }

                             if($compdetails[3]!="0")
                             {  
                               $sector_name=$compdetails[3];
                               $sector_id=return_sectorid($sector_name);
                             }
                             else
                             {
                               $sector_name="";
                               $sector_id=1;
                             }

                             if($compdetails[4]!="0")
                             {
                             $region_name=$compdetails[4];
                             $region_id=return_regionid($region_name);
                             }
                             else
                             {
                               $region_name="";
                               $region_id=0;
                             }

                             if($compdetails[5]!="0")
                             {

                               $state_name=$compdetails[5];
                               $state_id=return_stateid($state_name);
                             }
                             else
                             {
                               $state_name="";
                               $state_id=0;
                             }

                             if($compdetails[6]!="0")
                             {
                                $country_name=$compdetails[6];
                                $country_id=return_countryid($country_name);
                             }
                             else
                             {
                                 $country_name="";
                                 $country_id=0;
                             }
                             $listing_status=$compdetails[7];
                             $currency_flag=$compdetails[8];
                             $fin_type=$compdetails[9];
                             if($currency_flag=="C")
                             {   $multiplefactor=10000000; }
                             elseif($currency_flag=="L")
                             {   $multiplefactor=100000; }
                             elseif($currency_flag=="I")
                             {   $multiplefactor=1; }

                             $insert_company_sql = "insert into company_dim(company_id,company_name,
                            region,state,country,company_listing,industry_name,sector_name,parent_company_id) values
                             ('$company_id','$fullcompany_name','$region_name','$state_name','$country_name','$listing_status','$industry_name','$sector_name','$parent_company_id')";

                             if($company_id!="")
                             {
                             if ($rsinscompany = mysql_query($insert_company_sql))
            	              {
                                echo "<Br> Company details inserted ";
                              }
                             }
				$arraycnt=0;
				for($k=1;$k<=5;$k++)
				{
                                  $arraycnt=0;
                                      for($a=10;$a<=22;$a++)
				      {
                                        $fsvalues[]="";
                                      $fs=explode("\t",$values[$a]);
                                        if($fs[$k]!="")
                                        {
                                          $fsvalues[$arraycnt]=$fs[$k] ;         //direct values can be retrieved
                                          $arraycnt=$arraycnt+1;
                                         //echo "<bR>-*-" .$fs[$k];
                                        }
                                        else
                                        {
                                         $fsvalues[$arraycnt]=0;
                                        }
                                      }
                                      if($fsvalues[0]!=0)
                                      {
                                        $time_id=return_timeid($fsvalues[0]);
                                       // echo "<br>*** ".$multiplefactor;
                                        $operationanl_income=$fsvalues[1] * $multiplefactor;
                                       // echo "<bR>*OP INC**" .$operationanl_income;
                                       $other_income=$fsvalues[2] * $multiplefactor;
                                       $op_admin_other_exp=$fsvalues[3] * $multiplefactor;
                                       $operating_profit=$fsvalues[4] * $multiplefactor;
                                       $EBITDA_val=$fsvalues[5] * $multiplefactor;
                                       $interest_val=$fsvalues[6] * $multiplefactor;
                                       $EBDT_val=$fsvalues[7] * $multiplefactor;
                                       $depreciation_val=$fsvalues[8] * $multiplefactor;
                                       $EBT_pre_extraitems=$fsvalues[9] * $multiplefactor;
                                       $tax_val=$fsvalues[10] * $multiplefactor;
                                       $PAT_val=$fsvalues[11] * $multiplefactor;
                                       $eps_val=$fsvalues[12];
                                        $insert_cfs_sql ="insert into company_fin_fact(time_id,company_id,parent_company_id,industry_id,sector_id,region_id,state_id,
                                       country_id,operational_income,other_income,op_amin_other_exp,operating_profit,EBITDA,interest,EBDT,depreciation,
                                       EBT,tax,PAT,EPS,fin_type) values
                                       ($time_id,'$company_id','$parent_company_id',$industry_id,$sector_id,$region_id,$state_id,'$country_id',
                                       $operationanl_income,$other_income,$op_admin_other_exp,$operating_profit,$EBITDA_val,$interest_val,$EBDT_val,$depreciation_val,$EBT_pre_extraitems,$tax_val,$PAT_val,$eps_val,'$fin_type')";
                                       //echo "<bR>FINANCIAL -- ".$insert_cfs_sql;
                                       if ($rsfin = mysql_query($insert_cfs_sql))
                  	                {
                                          echo "<Br> " .$fsvalues[0]  ." - Company financial details inserted ";
                                       }
                                      }
                               }
	                  }
                         }
        } // if resgistered loop ends


?>


</html>