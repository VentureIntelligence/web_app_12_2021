<?php
 session_save_path("/tmp");
 session_start();

 require ("../dbConnect_cfs.php");
 require ("mod_cfs.php");
 $dbconnCFS = new db_connection();
/*
 filename : insert_cfs.php
 uses mod_cfs for function returns
*/
   if (session_is_registered("SessLoggedAdminPwd"))
  {

         $listedcompetitor_1_id="";
         $listedcompetitor_2_id="";
         $listedcompetitor_3_id="";
         $listedcompetitor_4_id="";
         $listedcompetitor_5_id="";
         $unlistedcompetitor_1_id="";
         $unlistedcompetitor_2_id="";
         $unlistedcompetitor_3_id="";
         $unlistedcompetitor_4_id="";
         $unlistedcompetitor_4_id="";
         $listedcomparable_1_id="";
         $listedcomparable_2_id="";
         $listedcomparable_3_id="";
         $listedcomparable_4_id="";
         $listedcomparable_5_id="";
         $unlistedcomparable_1_id="";
         $unlistedcomparable_2_id="";
         $unlistedcomparable_3_id="";
         $unlistedcomparable_4_id="";
         $unlistedcomparable_5_id="";
         $parent_company_id="";
         $ipo_time_id=0;
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
         $no_shares=0;
         $stake_percentage=0;
         $sub_sector="";
         $brand_tag="";
         $business_desc="";
         //echo "<bR>STARTING-- ";


         $fullcompany_name=$_POST['txtfullcompanyname'];
         //echo "<br>1";
         $company_id=$_POST['companyid'];
         //echo "<bRE>1 aaaa-  ".$company_id;
         $brand_name=$_POST['brandname'];
         $company_status=$_POST['companystatus'];
         //echo "<br>2 ";
         if($_POST['parentcompany'])
         {
           $parent_company_name=$_POST['parentcompany'];
           //$parent_company_id=$_POST['parentcompanyid'];
           $parent_company_id=return_companyid($parent_company_name);
         }
         //echo "<br>3 ";
         $former_name=$_POST['formername'];
         $listing_status=$_POST['listingstatus'];
         $stockcode_bse=$_POST['stockcodebse'];
         $stockcode_nse=$_POST['stockcodense'];
         $industry_id=$_POST['industry'];
        // echo "<br>4 Industry id= ".$industry_id;
         $industry_name=return_industryname($industry_id);
         //echo "<br>5 Industry name- ".$industry_name;

         $sector_id=$_POST['sector'];
         //echo "<br>6 SectorId=". $sector_id;
         if($sector_id >1)
         {   $sector_name=return_sectorname($sector_id);}
         //echo "<br>6 Sector name-" .$sector_name;
         $newsector_name=$_POST['txtnewsector'];
         if($newsector_name!="Type Sector to add new")
         {       $sector_id=insert_sector($industry_id,$newsector_name);
                 $sector_name=$newsector_name;
          }
         //echo "<bR>6 New sector id= ".$sector_id;

         $sub_sector=$_POST['subsector'];
         $brand_tag=$_POST['brandtag'];
         $business_desc=$_POST['txtbusinessdesc'];
         $region_id=$_POST['region'];
         $region_name=return_regionname($region_id);
         //echo "<bR>7 Region - ".$region_name;

         $year_founded=$_POST['yearfounded'];
         if($year_founded=="")
           $year_founded=0;
         $ipo_date=$_POST['ipodate'];
            //if(IsDate($ipo_date))
            $ipo_time_id= return_timeid($ipo_date);
         // echo "<br>8 Time Id- ".$ipo_time_id;
          $address_1=$_POST['address1'];
         $address_2=$_POST['address2'];
         $city=$_POST['city'];
         $country_id=$_POST['country'];
         $country_name=return_countryname($country_id);
         //echo "<bR>9 country name- ".$country_name;

         if($_POST['state'])
         {
           $state_id=$_POST['state'];
           $state_name=return_statename($state_id);
         }
         else
         {
           $state_id=0;
           $state_name="";
         }
        // echo "<Br>10 statename - ".$state_name;

         $pin=$_POST['pincode'];
         if($pin=="")
           $pin=0;
         $phone=$_POST['telephone'];
         $fax=$_POST['fax'];
         $emailid=$_POST['email'];
         $website=$_POST['website'];
         $ceo_name=$POST['ceo'];
         $cfo_name=$_POST['cfo'];


         $listedcompetitor_1=$_POST['listed_competitor_1'];
         if($listedcompetitor_1!="")
             $listedcompetitor_1_id=insert_company($listedcompetitor_1);
          $listedcompetitor_2=$_POST['listed_competitor_2'];
          if($listedcompetitor_2!="")
             $listedcompetitor_2_id=insert_company($listedcompetitor_2);
         $listedcompetitor_3=$_POST['listed_competitor_3'];
         if($listedcompetitor_3!="")
             $listedcompetitor_3_id=insert_company($listedcompetitor_3);
         $listedcompetitor_4=$_POST['listed_competitor_4'];
         if($listedcompetitor_4!="")
             $listedcompetitor_4_id=insert_company($listedcompetitor_4);
         $listedcompetitor_5=$_POST['listed_competitor_5'];
         if($listedcompetitor_5!="")
             $listedcompetitor_2_id=insert_company($listedcompetitor_5);
         $unlistedcompetitor_1=$_POST['unlisted_competitor_1'];
         if($unlistedcompetitor_1!="")
         {    $unlistedcompetitor_1_id=insert_company($unlistedcompetitor_1);   }
         //echo "<BR>11- ".$unlistedcompetitor_1_id;
         $unlistedcompetitor_2=$_POST['unlisted_competitor_2'];
         if($unlistedcompetitor_2!="")
             $unlistedcompetitor_2_id=insert_company($unlistedcompetitor_2);
         $unlistedcompetitor_3=$_POST['unlisted_competitor_3'];
         if($unlistedcompetitor_3!="")
             $unlistedcompetitor_3_id=insert_company($unlistedcompetitor_3);
         $unlistedcompetitor_4=$_POST['unlisted_competitor_4'];
         if($unlistedcompetitor_4!="")
             $unlistedcompetitor_4_id=insert_company($unlistedcompetitor_4);
         $unlistedcompetitor_5=$_POST['unlisted_competitor_5'];
         if($unlistedcompetitor_5!="")
             $unlistedcompetitor_5_id=insert_company($unlistedcompetitor_5);
         $listedcomparable_1=$_POST['listed_comparable_1'];
         if($listedcomparable_1!="")
             $listedcomparable_1_id=insert_company($listedcomparable_1);
         $listedcomparable_2=$_POST['listed_comparable_2'];
         if($listedcomparable_2!="")
             $listedcomparable_2_id=insert_company($listedcomparable_2);
         $listedcomparable_3=$_POST['listed_comparable_3'];
         if($listedcomparable_3!="")
             $listedcomparable_3_id=insert_company($listedcomparable_3);
         $listedcomparable_4=$_POST['listed_comparable_4'];
         if($listedcomparable_4!="")
             $listedcomparable_4_id=insert_company($listedcomparable_4);
         $listedcomparable_5=$_POST['listed_comparable_5'];
         if($listedcomparable_5!="")
             $listedcomparable_5_id=insert_company($listedcomparable_5);
         $unlistedcomparable_1=$_POST['unlisted_comparable_1'];

         if($unlistedcomparable_1!="")
         {    $unlistedcomparable_1_id=insert_company($unlistedcomparable_1); }
         //echo "<br>Unlisted comparable - ". $unlistedcomparable_1_id;
         $unlistedcomparable_2=$_POST['unlisted_comparable_2'];
         if($unlistedcomparable_2!="")
         {    $unlistedcomparable_2_id=insert_company($unlistedcomparable_2); }
         //echo "<br>Unlisted comparable 2 - ". $unlistedcomparable_2_id;
         $unlistedcomparable_3=$_POST['unlisted_comparable_3'];
         if($unlistedcomparable_3!="")
             $unlistedcomparable_3_id=insert_company($unlistedcomparable_3);
         $unlistedcomparable_4=$_POST['unlisted_comparable_4'];
         if($unlistedcomparable_4!="")
             $unlistedcomparable_4_id=insert_company($unlistedcomparable_4);
         $unlistedcomparable_5=$_POST['unlisted_comparable_5'];
         if($unlistedcomparable_5!="")
             $unlistedcomparable_5_id=insert_company($unlistedcomparable_5);
         $shareholder_name= $_POST['shareholdername'];
         //echo "<bR>--" .$shareholder_name;
         $share_type=$_POST['shtype'];
         $no_shares=$_POST['noshares'];
         if($no_shares=="")
            $no_shares=0;
         $stake_percentage=$_POST['stakepercentage'];
         if($stake_percentage=="")
             $stake_percentage=0;
         $fin_year=$_POST['finyear'];
         $fin_year_id=return_timeid($fin_year);
         $currency_flag=$_POST['currencyflag'];
         $fin_type=$_POST['fintype'];
         //echo "<br>!!!!!!!!!!!!" .$currency_flag;
         if($currency_flag==0)
            $multiplefactor=10000000;
         elseif($currency_flag==1)
            $multiplefactor=100000;
         elseif($currency_flag==2)
            $multiplefactor=1;


         $operationanl_income=($_POST['operationalincome'] * $multiplefactor);
          $other_income=($_POST['otherincome'] * $multiplefactor);
         $op_admin_other_exp=($_POST['opadminotherexp'] * $multiplefactor);
         $operating_profit=($_POST['operatingprofit'] * $multiplefactor);
         $EBITDA_val=($_POST['EBITDA'] * $multiplefactor);
         $interest_val=($_POST['interest'] * $multiplefactor);
         $EBDT_val=($_POST['EBDT'] * $multiplefactor);
         $depreciation_val=($_POST['EBDT'] * $multiplefactor) ;
         $EBT_pre_extraitems=($_POST['EBTpreextraitems'] * $multiplefactor);
         //$extra_items=($_POST['extraitems'] * $multiplefactor);
         //$EBT_post_extraitems =($_POST['EBTpostextraitems'] * $multiplefactor);
         $tax_val=($_POST['tax'] * $multiplefactor);
         $PAT_val=($_POST['PAT']* $multiplefactor);
         //$PAT_after_minority_interest=$_POST['PATafterminorityinterest'];
         $eps_val=$_POST['eps'];

        $insert_company_sql = "insert into company_dim(company_id,company_name,company_brandname,company_formername,address1,address2,city,
        region,state,pincode,country,telephone,fax,emailid,website,company_listing,stockcode_bse,stockcode_nse, IPO_date_id,
        yearfounded,industry_name,sector_name,sub_sector,brand_tags,business_description,CEO,CFO,
        listed_competitor_1,listed_competitor_2,listed_competitor_3,listed_competitor_4,listed_competitor_5,
        unlisted_competitor_1,unlisted_competitor_2,unlisted_competitor_3,unlisted_competitor_4,unlisted_competitor_5,
        listed_comparable_1,listed_comparable_2,listed_comparable_3,listed_comparable_4,listed_comparable_5,
        unlisted_comparable_1,unlisted_comparable_2,unlisted_comparable_3,unlisted_comparable_4,unlisted_comparable_5,
        parent_company_id) values ('$company_id','$fullcompany_name','$brand_name','$former_name','$address1','$address2','$city','$region_name','$state_name',$pin,
        '$country_name','$phone','$fax','$emailid','$website','$listing_status','$stockcode_bse','$stockcode_nse',$ipo_time_id,'$year_founded','$industry_name',
        '$sector_name','$sub_sector','$brand_tag','$business_desc','$ceo','$cfo',
         '$listedcompetitor_1_id', '$listedcompetitor_2_id','$listedcompetitor_3_id','$listedcompetitor_4_id','$listedcompetitor_5_id',
         '$unlistedcompetitor_1_id','$unlistedcompetitor_2_id','$unlistedcompetitor_3_id','$unlistedcompetitor_4_id','$unlistedcompetitor_4_id',
         '$listedcomparable_1_id','$listedcomparable_2_id','$listedcomparable_3_id','$listedcomparable_4_id','$listedcomparable_5_id',
         '$unlistedcomparable_1_id','$unlistedcomparable_2_id','$unlistedcomparable_3_id','$unlistedcomparable_4_id','$unlistedcomparable_5_id','$parent_company_id')";

         //echo "<bR>--^^ ".$insert_company_sql;

         $insert_cfs_sql ="insert into company_fin_fact(time_id,company_id,parent_company_id,industry_id,sector_id,region_id,state_id,
         country_id,operational_income,other_income,op_amin_other_exp,operating_profit,EBITDA,interest,EBDT,depreciation,
         EBT,tax,PAT,EPS,fin_type) values
         ('$fin_year_id','$company_id','$parent_company_id',$industry_id,$sector_id,$region_id,$state_id,'$country_id',
         $operationanl_income,$other_income,$op_admin_other_exp,$operating_profit,$EBITDA_val,$interest_val,$EBDT_val,
         $depreciation_val, $EBT_pre_extraitems,$tax_val,$PAT_val,$eps_val,'$fin_type')";
         //echo "<br><br>---**** ".$insert_cfs_sql;

         $insert_shareholder_sql="insert into company_shareholder_fact values('$company_id','$shareholder_name',$share_type,$no_shares,$stake_percentage)";
         //echo "<BR><BR>--- ".$insert_shareholder_sql;

         if(($fullcompany_name !="" ) && ($company_id!=""))
         {
              if ($rsins_comp = mysql_query($insert_company_sql))
              {
                 echo "<br> Company Details inserted ";
                 if($rsins_cfs= mysql_query($insert_cfs_sql))
                 {
                   echo "<br><br> Company CFS Details inserted ";
                   if($shareholder_name!="")
                    {
                      if($rsshare_sql= mysql_query($insert_shareholder_sql))
                      {
                        echo "<br><br> Share holder Info Inserted ";
                      }
                    }
                 }
              }
              else
                 echo "<bR>Insert company fails-";

         }
} // if resgistered loop ends


?>