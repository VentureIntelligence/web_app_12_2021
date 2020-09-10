<?php
require("../dbconnectvi.php");
	$Db = new dbInvestments();
	require("checkaccess.php");
	checkaccess( 'edit' );
 session_save_path("/tmp");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	{

?>
<html><head>
<title>PE Investment Company Profile</title>
<SCRIPT LANGUAGE="JavaScript">
function checkFields()
{
 //alert(document.editcompprofile.txtbrdExecutiveId[].length);
}

</SCRIPT>
</head>

<body>
 <form name=editcompprofile enctype="multipart/form-data" method=post  action="companyprofileeditupdate.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=100%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
	

$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';

	$SelCompRef=$value;
   	$getDatasql = "SELECT pec.PECompanyId, pec.companyname,pec.CINNo, pec.industry, i.industry, pec.sector_business, website,linkedIn,
  			stockcode, yearfounded,pec.Address1,pec.Address2,pec.AdCity,pec.Zip,pec.OtherLocation,
  			pec.countryid,pec.Telephone,pec.Fax,pec.Email,pec.AdditionalInfor,pec.RegionId,pec.uploadfilename,pec.filingfile,pec.angelco_compID ,pec.tags,pec.state,pec.stateid 
			FROM industry AS i,pecompanies AS pec
			WHERE pec.industry = i.industryid
			 AND  pec.PECompanyId=$SelCompRef";
        
        $getfilingDatasql = "SELECT * from companies_filing_files WHERE companies_filing_files.company_id=$SelCompRef";
//echo "<br>--" .$getDatasql;
	if ($companyrs = mysql_query($getDatasql))
	{
		$company_cnt = mysql_num_rows($companyrs);
	}
	  if($company_cnt > 0)
	{
		While($mycomprow=mysql_fetch_array($companyrs, MYSQL_BOTH))
		{
                    
                    $angelco_compID = $mycomprow["angelco_compID"];
?>
		   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Edit Company Profile</b></td></tr>
				<tr>

				<!-- industry id -->
				<td  style="font-family: Verdana; font-size: 87pt" align=left>
				<input type="hidden" name="txtindustryId" size="10" value="<?php echo $mycomprow[2]; ?>"> </td>

				<!-- PECompanyid -->
				<td  style="font-family: Verdana; font-size: 8pt" align=left>
				<input type="hidden" name="txtcompanyid" size="10" value="<?php echo $mycomprow["PECompanyId"]; ?>"> </td>
				</tr>

				<tr style="font-family: Verdana; font-size: 8pt">
				<td >Company</td>
				<td><input type="text" name="txtname" size="50" value="<?php echo $companyname = $mycomprow["companyname"]; ?>"> </td>
				</tr>

                                <tr style="font-family: Verdana; font-size: 8pt">
				<td >CIN No</td>
				<td><input type="text" name="txtcinno" size="50" value="<?php echo $mycomprow["CINNo"]; ?>"> </td>
				</tr>

				<tr>
				<td>Industry</td>
				<td > <SELECT name="industry">

				<?php

					$industrysql = "select distinct i.industryid,i.industry  from industry as i
					order by i.industry";
					if ($industryrs = mysql_query( $industrysql))
					{
					  $ind_cnt = mysql_num_rows($industryrs);
					}
					if($ind_cnt > 0)
					{
						While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
						{
							$id = $myrow[0];
							$name = $myrow[1];
							if ($id==$mycomprow[3])
							{
								echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."  </OPTION>\n";
							}
							else
							{
								echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION> \n";
							}
						}
						mysql_free_result($industryrs);
					}

				?>
				</select> </td> </tR>

				<tr><td >Sector</td>
				<td>
				<input type="text" name="txtsector" size="50" value="<?php echo $mycomprow["sector_business"]; ?>"> </td>
				</tr>

				<tr><td >Tags</td>
				<td>
				<!--<input type="text" name="txttags" size="50" value="<?php // echo $mycomprow["tags"]; ?>">-->
                                <textarea name="txttags" rows="4" cols="50"><?php echo trim($mycomprow["tags"]); ?> </textarea></td>
				</tr>

				<tr><td >Stock Code</td>
				<td >
				<input type="text" name="txtstockcode" size="50" value="<?php echo $mycomprow["stockcode"]; ?>">
				</td>
				</tr>
				<tr><td >Year founded</td>
				<td >
				<input type="text" name="txtyearfounded" size="50" value="<?php echo $mycomprow["yearfounded"]; ?>">
				</td>
				</tr>
				<tr><td >Address1 </td>
				<td><textarea name="txtaddress1" rows="4" cols="50"><?php echo $mycomprow["Address1"]; ?> </textarea> </td>

				</tr>
				<tr><td >&nbsp; </td>
				<td >
				<input type="text" name="txtaddress2" size="50" value="<?php echo $mycomprow["Address2"]; ?>">
				</td>
				</tr>
				<tr><td >City</td>
				<td>
				<input type="text" name="txtadcity" size="50" value="<?php echo $mycomprow["AdCity"]; ?>"> </td>
				</tr>
				<tr>
							 <td> State</td>
							 <Td width=5% align=left> <SELECT NAME=txtstate>
							  <OPTION value="1" selected> Choose state </option>

						<?php
							$regionSql = "select state_id,state_name from state where state_name!=''";
							if ($regionrs = mysql_query($regionSql))
							{
							  $region_cnt = mysql_num_rows($regionrs);
							}
							if($region_cnt > 0)
							{
								While($myrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
								{
									$id = $myrow[0];
									$name = $myrow[1];
									if ($id==$mycomprow["stateid"])
									{
										echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."  </OPTION>\n";
									}
									else
									{
										echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION> \n";
									}

								}
							}
						?>
		</SELECT></td></tr>
				<tr>
							 <td> Region</td>
							 <Td width=5% align=left> <SELECT NAME=txtregion>
							  <OPTION value="1" selected> Choose Region </option>

						<?php
							$regionSql = "select RegionId,Region from region where Region!=''";
							if ($regionrs = mysql_query($regionSql))
							{
							  $region_cnt = mysql_num_rows($regionrs);
							}
							if($region_cnt > 0)
							{
								While($myrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
								{
									$id = $myrow[0];
									$name = $myrow[1];
									if ($id==$mycomprow["RegionId"])
									{
										echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."  </OPTION>\n";
									}
									else
									{
										echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION> \n";
									}

								}
							}
						?>
		</SELECT></td></tr>

		<tr><td >Country (Target)</td><td>
				<SELECT name="txtcountry" style="font-family: Arial; color: #004646;font-size: 8pt">
			<OPTION id=0 value="--" selected> Choose Country  </option>
			<?php
				//$countryselected="IN";
				$countryselected=$mycomprow["countryid"];

				 $dealtypesql="select CountryId,Country from country where countryid NOT IN('','--','10','11') order by country asc";
					if ($rsdealtypes = mysql_query($dealtypesql))
					{
					 $dealtype_cnt = mysql_num_rows($rsdealtypes);
					}
					if($dealtype_cnt>0)
					{
						 While($myrow=mysql_fetch_array($rsdealtypes, MYSQL_BOTH))
						{
							$id = $myrow[0];
							$name = $myrow[1];
							if($id==$countryselected)
								echo "<OPTION id=".$id. " value=".$id." SELECTED>".$name."</OPTION> \n";
							else
								echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
						}
						mysql_free_result($rsdealtypes);
					}
			?></select></td></tr>



				<tr><td >Zip</td>
				<td>
				<input type="text" name="txtzip" size="50" value="<?php echo $mycomprow["Zip"]; ?>"> </td>
				</tr>

				<tr><td >Other Location</td>
				<td><textarea name="txtotherlocation" rows="4" cols="50"><?php echo $mycomprow["OtherLocation"]; ?> </textarea> </td>
				</tr>




				<tr><td >Telephone</td>
				<td>
				<input type="text" name="txttelephone" size="50" value="<?php echo $mycomprow["Telephone"]; ?>"> </td>
				</tr>
				<tr><td >Website</td>
				<td>
				<input type="text" name="txtwebsite" size="50" value="<?php echo $mycomprow["website"]; ?>"> </td>
				</tr>
                                <tr><td >LinkedIn URL</td>
				<td>
				<input type="text" name="txtlinkedin" size="50" value="<?php echo $mycomprow["linkedIn"]; ?>"> </td>
				</tr>
				<tr><td >Fax</td>
				<td>
				<input type="text" name="txtfax" size="50" value="<?php echo $mycomprow["Fax"]; ?>"> </td>
				</tr>
				<tr><td >Email</td>
				<td>
				<input type="text" name="txtemail" size="50" value="<?php echo $mycomprow["Email"]; ?>"> </td>
				</tr>
				<tr><td >Additional Information</td>
				<td><textarea name="txtaddinfor" rows="4" cols="50"><?php echo $mycomprow["AdditionalInfor"]; ?> </textarea> </td>
				</tr>


				<tr>
					<td>Board <br>
					<input type="button" value="Add Executive (Board)" name="btnaddboard"
					onClick="window.open('addcompBoardMgmt.php?value=<?php echo $SelCompRef;?>','mywindow','width=400,height=600')">
					<td valign=top style="font-family: Verdana; font-size: 8pt" align=left>
					<table border=1 width=100% cellpadding=1 cellspacing=0>

					<?php
					$strBoard="";
          			 $getInvestorsSql="select peinv.PECompanyId,peinv.ExecutiveId,e.ExecutiveName,e.Designation,e.Company from
          			 pecompanies_board as peinv,
					 executives as e where e.ExecutiveId=peinv.ExecutiveId and peinv.PECompanyId=$SelCompRef";

					  if ($rsinvestors = mysql_query($getInvestorsSql))
					  {


						While($myInvrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
						{
							$strBoard=$strBoard.", ".$myInvrow["ExecutiveName"];
							if(trim($myInvrow["Designation"])!="")
								$strBoard=$strBoard.", ".$myInvrow["Designation"];
							if(trim($myInvrow["Company"])!="")
								$strBoard=$strBoard.", ".$myInvrow["Company"];
							$strBoard =substr_replace($strBoard, '', 0,1);
						?>
						<tr style="font-family: Verdana; font-size: 8pt" >
						<td valign=top width="20" >
						<input  name="txtbrdExecutiveId[]" type="text" READONLY size="15" value=" <?php echo $myInvrow["ExecutiveId"]; ?>"  >
						</td>
						<td> <input type="text" name="txtbrdExecutiveName[]"  size="50" value="<?php echo trim($strBoard); ?> "> </td>

						</tr>

					<?php
							$strBoard="";
						}

					}
					?>
					</table>
					</td>
				</tr>

					<tr>
					<td>Management
					<input type="button" value="Add Executive (Management)" name="btnaddmgmt"
					onClick="window.open('addcompBoardMgmt.php?value=<?php echo $SelCompRef;?>','mywindow','width=400,height=600')">
					<td valign=top style="font-family: Verdana; font-size: 8pt" align=left>
					<table border=1 width=100% cellpadding=1 cellspacing=0>

					<?php
					$strManagement="";
					 $getInvestorsSql="select peinv.PECompanyId,peinv.ExecutiveId,e.ExecutiveName,e.Designation,e.Company from
					 pecompanies_management as peinv,
					 executives as e where e.ExecutiveId=peinv.ExecutiveId and peinv.PECompanyId=$SelCompRef";

					  if ($rsMgmtinvestors = mysql_query($getInvestorsSql))
					  {

						While($myMgmtInvrow=mysql_fetch_array($rsMgmtinvestors, MYSQL_BOTH))
						{
							$strManagement=$strManagement.", ".$myMgmtInvrow["ExecutiveName"];
							if(trim($myMgmtInvrow["Designation"])!="")
								$strManagement=$strManagement.", ".$myMgmtInvrow["Designation"];
							if(trim($myMgmtInvrow["Company"])!="")
								$strManagement=$strManagement.", ".$myMgmtInvrow["Company"];
						  $strManagement =substr_replace($strManagement, '', 0,1);

							//$strManagement=$strManagement.";";
						?>
					<tr style="font-family: Verdana; font-size: 8pt" >
					<td valign=top width="20" >
					<input name="txtmgmtExecutiveId[]" type="text" READONLY size="15" value=" <?php echo $myMgmtInvrow["ExecutiveId"]; ?>"  >
					</td>
					<td> <input type="text" name="txtmgmtExecutiveName[]"  size="50" value="<?php echo trim($strManagement); ?> "> </td>
					</tr>

					<?php
						$strManagement="";
						}

					?>
						<!--<tr><td valign=top >
						<td valign=top><textarea name="txtboard" rows="2" cols="50"><?php echo trim($strManagement); ?> </textarea> </td>
						</tr> -->

					<?php
					}
					?>
					</table>
					</td>
				</tr>


                                <tr>
					<td>Links & Comments <br>
					<input type="button" value="Add Links & Comments" name="btnlinkcomment"
					onClick="window.open('addCompLink.php?value=<?php echo $SelCompRef;?>','mywindow','width=800,height=500')">
					<td valign=top style="font-family: Verdana; font-size: 8pt" align=left>
					<table border=1 width=100% cellpadding=1 cellspacing=0>

					<?php
					$strlinkcomment="";
          			 $getCompanyLinkSql="select peinv.PECompanyId,peinv.Link,peinv.Comment from
          			 pecompanies_links as peinv  where peinv.PECompanyId=$SelCompRef";

					  if ($rscompanylink = mysql_query($getCompanyLinkSql))
					  {
                        			While($mycompLinkrow=mysql_fetch_array($rscompanylink, MYSQL_BOTH))
						{

						?>
						<tr style="font-family: Verdana; font-size: 8pt" >
						<td valign=top width="20" >
						<input  name="txtCompanyLinkhidden[]" type="hidden" size="50" value=" <?php echo $mycompLinkrow["Link"]; ?>"  >
						<input  name="txtCompanyLink[]" type="text" size="50" value=" <?php echo $mycompLinkrow["Link"]; ?>"  >

						 <textarea name="txtCompanyComment[]" rows="3" cols="50"><?php echo $mycompLinkrow["Comment"]; ?> </textarea> </td>

						</tr>

					<?php

						}

					}
					?>
					</table>
					</td>
				</tr>

                                <tr>
                                    <td >&nbsp;Financial <br></td>
                                    <td valign=top><INPUT NAME="txtfilepath" TYPE="file" value="<?php echo $mycomprow["uploadfilename"]; ?>" size=50>
                                    <input name="txtfile" type="text" size="50" value="<?php echo $mycomprow["uploadfilename"]; ?>" >
                                    <?php
                                            if($pe_re=="PE")
                                            {
                                            ?>
                                                    <input type="button" value="Delete File" name="deletepeuploadfile" onClick="delUploadFile();"  >
                                            <?php
                                            }
                                            else
                                            {
                                            ?>
                                                    <input type="button" value="Delete File" name="deletereuploadfile" onClick="delREUploadFile('F');"  >
                                            <?php
                                            }
                                            ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td >&nbsp;Upload Working/Filings <br></td>
                                    <td id="addmorebtn">
                                        <br>
                                        
                                   
                                    <?php
                                    
                                    if ($filingrs = mysql_query($getfilingDatasql))
                                    {
                                            $filing_cnt = mysql_num_rows($filingrs);
                                    }
                                    if($filing_cnt > 0)
                                    {
                                            ?>
                                        <table border="1">
                                            <?php
                                            While($myfilingrow=mysql_fetch_array($filingrs, MYSQL_BOTH))
                                            {
                                                 if($myfilingrow["file_name"]!=''){ ?>
                                            
                                                        <tr>
                                                        <?php 
                                                            $file = "../../uploadfilingfiles/".str_replace(" ", "%20",$myfilingrow["file_name"]);
                                                            
                                                            $info = new SplFileInfo($myfilingrow["file_name"]); ?>
                                                            
                                                            <td><span style="font-weight: 20px;pointer-events: none;"><?php echo $myfilingrow["file_name"]; ?></span></td>
                                                            <?php
                                                            if($info->getExtension()!='pdf'){
                                                                ?>
                                                                    <td><a href=<?php echo $file;?> target="_blank" > <input type="button" value="Download"></a></td>

                                                                <?php }else{ ?>
                                                                       <td> <a href="downloadpdf.php?file=<?php echo $myfilingrow["file_name"]; ?>" > <input type="button" value="Download"></a></td>

                                                                <?php } ?>   
                                                                        <td><a href="Deletefiling.php?delete=<?php echo $myfilingrow["id"]; ?>" > <input type="button" value="Delete File"><br></td>
                                                        </tr>
                                                    <?php } 
                                                
                                            }?>
                                                        </table><br>
                                    <?php } ?>
                                        <input NAME="txtfilingpath[]" TYPE="file" value="" size=50><br><br></input>
                                        <button type="button" name="addfile" id="addbtn">Click to Add file <br></button>
                                        
                                    </td>
                                </tr>

			<?php
				}
			mysql_free_result($rscompanylink);
		}

 ?>

                                                                
                                                                
                                                                
                                                                <tr>
                                                                    <td style="padding: 50px 10px; font-size: 13px;"  colspan='2' >
                                                                        
                                                                        <span>  <u>Angel.co</u> Company ID :     </span> <input type="text" value="<?php echo $angelco_compID ?>" id="angelco_compID" name="angelco_compID" size="50" >
                                                                        
                                                                        <br><br><br>
                                                                        <b> Search <u>Angel.co</u>  Api  </b>
                                                                        
                                                                        <input type="text" value="<?php echo $companyname; ?>" name="search_txt" id="search_txt" size="50" >
                                                                        <input type="button" value="Search" id="search_angelcoAPI" name="search_angelcoAPI" >
                                                                        <br><br>
                                                                        <div id="results" style="display: none">
                                                                            
                                                                        </div>
                                                                    </td>
                                                                    
                                                                </tr>                                                                
</table>
<table align=center>
<tr> <Td> <input type="submit" value="Update" name="updateDeal" > </td></tr></table>


     </form>
 <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
   </script>

   <script src="js/jquery-1.8.3.min.js" type="text/javascript"></script>
   
   <script type="text/javascript" >
    $("#addbtn").live("click",function() {
           
        $(this).remove();
        $('#addmorebtn').append($('<input/>',{type:"file",name:"txtfilingpath[]"}));
        $('#addmorebtn').append($('<br/><br/>')); 
        $('#addmorebtn').append($('<button/>',{type:"button",name:"addfile",id:"addbtn",text:"Click to Add file"}));   
                
    });
    $("input:file").live('change',function (){
  
                var fileName = $(this).val();
                var ext = fileName.split('.').pop();
                
                if(ext === 'pdf' || ext === 'xls' || ext === 'doc'){
                   return true;
                } else{
                    
                   $(this).remove();
                   $('#addbtn').remove();
                    $('#addmorebtn').append($('<input/>',{type:"file",name:"txtfilingpath[]"}));
                    $('#addmorebtn').append($('<br/><br/>')); 
                    $('#addmorebtn').append($('<button/>',{type:"button",name:"addfile",id:"addbtn",text:"Click to Add file"}));   
                   alert("Please select Excel or PDF or doc files");
                   return false;
                }

         });
    $(document).ready(function () {
        
//        $("input:file").change(function (){
//  
//                alert("dddddddd");
//                var fileName = $(this).val();
//                var ext = fileName.split('.').pop();
//                if(ext!="pdf" || ext!="xls"){
//                   
//                   $(this).remove();
//                   $('#addbtn').remove();
//                    $('#addmorebtn').append($('<input/>',{type:"file",name:"txtfilingpath[]"}));
//                    $('#addmorebtn').append($('<br/><br/>')); 
//                    $('#addmorebtn').append($('<button/>',{type:"button",name:"addfile",id:"addbtn",text:"Click to Add file"}));   
//                   alert("Please select Excel or PDF file");
//                   return false;
//                } else{
//                    
//                    return true;
//                }
//
//         });
        
         $('div').on("click", ".angelcomp", function() {
             var angelco_compID=  $("input[name=angelcomp]:checked").val();
             
             $('#angelco_compID').val(angelco_compID);
        
         });
        

        $('#search_angelcoAPI').click(function (e) {
          $('#results').hide();
           $('#results').html('');
          
          var searchtxt = $('#search_txt').val();
            var formData ={'search':searchtxt};

            $.ajax({
                url: 'searcAngelCoAPI.php?companysearch',
                type: 'POST',
                data: formData,
                timeout: 30000, // in milliseconds
                success: function (data) {
                    
//                    data = $.parseJSON(data);
//                    count = data['count'];
//                    results = data['count'];
                    
                    if(data==0){
                        
                       // alert('No results');
                       $('#results').html('<br><i style="color:red">No results found</i>');
                       $('#results').show();
                        return false;
                    }
                    else{
                         $('#results').html(data);
                         $('#results').show();
                         return false;
                    }
                    
                },
                error: function (request, statusCode, err) {
                    alert("Check Network Connectivity and Try Again");
                    return false;
                }
            });
            return false;
        });

    });
</script>


 </body>
 </html>
 <?php

 } // if resgistered loop ends
 else
 	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>