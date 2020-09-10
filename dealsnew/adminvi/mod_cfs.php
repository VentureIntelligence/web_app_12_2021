<?php

       //function that returns the time_id */
 	function return_timeid($datevalue)
	{

          $mod_dbconn = new db_connection();

          	$get_timeid_Sql = "select time_id from time_dim where calendar_date = '$datevalue'";

            	if ($rsget_timeid = mysql_query($get_timeid_Sql))
            	{
            	//if($mod_dbconn.execute($get_timeid_Sql))
		//{
           	        $time_cnt=mysql_num_rows($rsget_timeid);
			if($time_cnt==1)
			{
				While($myrow=mysql_fetch_array($rsget_timeid, MYSQL_BOTH))
				{
					$time_id = $myrow[0];
					//echo "<br>@@@@".$time_id;
					return $time_id;
				}
			}
		}   //end of rs if_loop
          $mod_dbconn.closeDB();
	} //end of function

        //function that returns the company_id
   	function return_companyid($companyname)
	{
            $mod_dbcompcon = new db_connection();
            $comp_id="";
               	$get_compid_sql = "select company_id from company_dim where company_name like '$companyname%'";
               	//echo "<bR>--" .$get_compid_sql;
              	if ($rsget_compid = mysql_query($get_compid_sql))
            	{
			$comp_cnt=mysql_num_rows($rsget_compid);
			if($comp_cnt==1)
			{
				While($myrow=mysql_fetch_array($rsget_compid, MYSQL_BOTH))
				{
					$comp_id = $myrow[0];
					return $comp_id;
				}
			}
		 }   //end of rs if_loop
		 return $compid;
          $mod_dbcompcon.closeDB();
	} //end of function

        function insert_company($listedcompetitor)
        {
          // echo "<br>1- ".$listedcompetitor;
           $listedcompetitor_id=return_companyid($listedcompetitor);
           //echo "<br>2 - Id= ".$listedcompetitor_id;
            $mod_compcon = new db_connection();
            $compid="";
            if($listedcompetitor_id=="")
            {
              $compid=str_replace(" ","",$listedcompetitor);
              $compid=substr($compid,0,3);
              $compid=strtoupper($compid)."01";
             //echo "<br>3= " .$compid;
             if(check_companyid($compid)!="")
             {
               //echo "<bR>EXISTS";
               $compid=substr($listedcompetitor,1,3);
               $listedcompetitor_id=strtoupper($compid)."01";
               return $listedcompetitor_id;
             }
             else
             { 
               $inscomp_sql= "insert into company_dim(company_id,company_name) values ('$compid','$listedcompetitor')";
              // echo "<bR>Insert- ".$inscomp_sql;
               	if ($rsget_checkcompid = mysql_query($inscomp_sql))
            	{
                  return $listedcompetitor_id;
                 }
             }

           }
           return $listedcompetitor_id;
        }


//function that checks for the company_id
   	function check_companyid($companyid)
	{
            $mod_dbcompid = new db_connection();
            $checkcomp_id="";
               	$check_compid_sql = "select company_id,company_name from company_dim where company_id like '$companyid'";
                if ($rscheck_compid = mysql_query($check_compid_sql))
            	{
			$checkcomp_cnt=mysql_num_rows($rscheck_compid);
			if($checkcomp_cnt==1)
			{
				While($mycrow=mysql_fetch_array($rsget_compid, MYSQL_BOTH))
				{
					$checkcomp_id = $mycrow[0];
					return $checkcomp_id;
				}
			}
		}   //end of rs if_loop
	return $checkcomp_id;
          $mod_dbcompid.closeDB();
	} //end of function


//function that returns the regionid
   	function return_regionid($regioname)
	{
            $mod_dbregionid = new db_connection();

          	$get_regionid_sql = "select region_id from region_dim  where region_name like '$regioname%'";
               	//if ($rsget_timeid = mysql_query($get_timeid_Sql))
            	if ($rsget_regionid = mysql_query($get_regionid_sql))
            	{
			$regionid_cnt=mysql_num_rows($rsget_regionid);
			if($regionid_cnt==1)
			{
				While($myregionidrow=mysql_fetch_array($rsget_regionid, MYSQL_BOTH))
				{
					$regionid = $myregionidrow[0];
					return $regionid;
				}
			}
		}   //end of rs if_loop
          $mod_dbregionid.closeDB();
	} //end of function


//function that returns the region
   	function return_regionname($regionid)
	{
            $mod_dbregion = new db_connection();

          	$get_region_sql = "select region_name from region_dim  where region_id=$regionid";
               	//if ($rsget_timeid = mysql_query($get_timeid_Sql))
            	if ($rsget_region = mysql_query($get_region_sql))
            	{
			$region_cnt=mysql_num_rows($rsget_region);
			if($region_cnt==1)
			{
				While($myregionrow=mysql_fetch_array($rsget_region, MYSQL_BOTH))
				{
					$regionname = $myregionrow[0];
					return $regionname;
				}
			}
		}   //end of rs if_loop
          $mod_dbregion.closeDB();
	} //end of function

        //function that returns the countryid
   	function return_countryid($countryname)
	{
            $mod_dbcountryid = new db_connection();

          	$get_countryid_sql = "select country_id from country_dim  where country_name like '$countryname%'";
               	//if ($rsget_timeid = mysql_query($get_timeid_Sql))
            	if ($rsget_countryid = mysql_query($get_countryid_sql))
            	{
			$countryid_cnt=mysql_num_rows($rsget_countryid);
			if($countryid_cnt==1)
			{
				While($mycountryidrow=mysql_fetch_array($rsget_countryid, MYSQL_BOTH))
				{
					$countryid = $mycountryidrow[0];
					return $countryid;
				}
			}
		}   //end of rs if_loop
          $mod_dbcountryid.closeDB();
	} //end of function


        //function that returns the countryname
   	function return_countryname($countryid)
	{
            $mod_dbcountry = new db_connection();

          	$get_country_sql = "select country_name from country_dim  where country_id='$countryid'";
               	//if ($rsget_timeid = mysql_query($get_timeid_Sql))
            	if ($rsget_country = mysql_query($get_country_sql))
            	{
			$country_cnt=mysql_num_rows($rsget_country);
			if($country_cnt==1)
			{
				While($mycountryrow=mysql_fetch_array($rsget_country, MYSQL_BOTH))
				{
					$countryname = $mycountryrow[0];
					return $countryname;
				}
			}
		}   //end of rs if_loop
          $mod_dbcountry.closeDB();
	} //end of function


      //function that returns the stateid
   	function return_stateid($statename)
	{
            $mod_dbstateid = new db_connection();

          	$get_stateid_sql = "select state_id from state_dim  where state_name like '$statename%'";
          
               	//if ($rsget_timeid = mysql_query($get_timeid_Sql))
            	if ($rsgetid_state = mysql_query($get_stateid_sql))
            	{
			$stateid_cnt=mysql_num_rows($rsgetid_state);
			if($stateid_cnt==1)
			{
				While($mystateidrow=mysql_fetch_array($rsgetid_state, MYSQL_BOTH))
				{
					$stateid = $mystateidrow[0];
					return $stateid;
				}
			}
		}   //end of rs if_loop
          $mod_dbstateid.closeDB();
	} //end of function

        function return_statename($stateid)
	{

            $mod_dbstate = new db_connection();

          	$get_state_sql = "select state_name from state_dim  where state_id=$stateid";
               	//if ($rsget_timeid = mysql_query($get_timeid_Sql))
            	if ($rsget_state = mysql_query($get_state_sql))
            	{
			$state_cnt=mysql_num_rows($rsget_state);
			if($state_cnt==1)
			{
				While($mystaterow=mysql_fetch_array($rsget_state, MYSQL_BOTH))
				{
					$statename = $mystaterow[0];
					return $statename;
				}
			}
		}   //end of rs if_loop
          $mod_dbstate.closeDB();
	} //end of function

     function return_sectorid($sectorname)
	{
            $mod_dbsec = new db_connection();

          	$get_sectorid_sql = "select sector_id from sector_dim  where sector_name like '$sectorname%'";
          	//echo "<bR>--- ".$get_sectorid_sql;
               	//if ($rsget_timeid = mysql_query($get_timeid_Sql))
            	if ($rsget_sectorid= mysql_query($get_sectorid_sql))
            	{
			$sectorid_cnt=mysql_num_rows($rsget_sectorid);
			if($sectorid_cnt==1)
			{
				While($mysectoridrow=mysql_fetch_array($rsget_sectorid, MYSQL_BOTH))
				{
					$sectorid = $mysectoridrow[0];
					return $sectorid;
				}
			}
		}   //end of rs if_loop
          $mod_dbsec.closeDB();
	} //end of function


   	function return_sectorname($sectorid)
	{
            $mod_dbsector = new db_connection();

          	$get_sector_sql = "select sector_name from sector_dim  where sector_id=$sectorid";
               	//if ($rsget_timeid = mysql_query($get_timeid_Sql))
            	if ($rsget_sector= mysql_query($get_sector_sql))
            	{
			$sector_cnt=mysql_num_rows($rsget_sector);
			if($sector_cnt==1)
			{
				While($mysectorrow=mysql_fetch_array($rsget_sector, MYSQL_BOTH))
				{
					$sectorname = $mysectorrow[0];
					return $sectorname;
				}
			}
		}   //end of rs if_loop
          $mod_dbsector.closeDB();
	} //end of functio


        function insert_sector($ind_id,$sec_name)
        {
            $mod_dbinssector = new db_connection();

                  $cnt=0;
                  $check_sector_sql="select * from sector_dim  where industry_id=$ind_id and sector_name like '$sec_name%'";
                  if($rscheck=mysql_query($check_sector_sql))
                  {
                    $cnt=mysql_num_rows($rscheck);
                  }
                  if($cnt==0)
                  {
                          $insert_sector_sql = "insert into sector_dim(industry_id,sector_name) values ($ind_id,'$sec_name')";
                          if ($rsget_timeid = mysql_query($insert_sector_sql))
                           {   }
                  }
         	                 $get_sector_sql="select sector_id from sector_dim  where industry_id=$ind_id and sector_name like '$sec_name%'";
         	                 if ($rsgetSectorId = mysql_query($get_sector_sql))
        		        {
        			$sec_cnt=mysql_num_rows($rsgetSectorId);
         			if($sec_cnt>=1)
        			{
        				While($myrow=mysql_fetch_array($rsgetSectorId, MYSQL_BOTH))
        				{
        					$sector_id = $myrow[0];
        					//echo "<br>Insert return investor id--" .$InvestorId;
        					return $sector_id;
        				}
        			}
        			else
        			     $sector_id=1;
        		       }

                  //end of rs if_loop
		return $sector_id;
          $mod_dbinssector.closeDB();
	} //end of functio


    function return_industryname($industryid)
	{
            $mod_dbindustry = new db_connection();
             	$get_ind_sql = "select industry from industry_dim  where industry_id=$industryid";
                   	//if ($rsget_timeid = mysql_query($get_timeid_Sql))
            	if ($rsget_ind = mysql_query($get_ind_sql))
            	{
			$ind_cnt=mysql_num_rows($rsget_ind);
			if($ind_cnt==1)
			{
				While($myindrow=mysql_fetch_array($rsget_ind, MYSQL_BOTH))
				{
					$industryname = $myindrow[0];
					return $industryname;
				}
			}
		}   //end of rs if_loop
          $mod_dbindustry.closeDB();
	} //end of function


    function return_industryid($industryname)
	{
            $mod_dbind = new db_connection();
             	$get_industry_sql = "select industry_id from industry_dim  where industry like '$industryname%'";
                   	//if ($rsget_timeid = mysql_query($get_timeid_Sql))
            	if ($rsget_indid = mysql_query($get_industry_sql))
            	{
			$indid_cnt=mysql_num_rows($rsget_indid);
			if($indid_cnt==1)
			{
				While($myindidrow=mysql_fetch_array($rsget_indid, MYSQL_BOTH))
				{
					$indid = $myindidrow[0];
					return $indid;
				}
			}
		}   //end of rs if_loop
          $mod_dbind.closeDB();
	} //end of function

?>
