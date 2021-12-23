<?php 
        $queryCompanyProfile ="SELECT *  FROM  cprofile INNER JOIN industries b on(Industry = b.Industry_Id) INNER JOIN countries c on(Country = c.Country_Id) INNER JOIN city d on(City = d.city_id)
         INNER JOIN state e on(	State = e.state_id) 
         INNER JOIN sectors f on(Sector  = f.Sector_Id)  WHERE  CIN ='U65999PN2016PTC166384'"; 
                                 
        $queryCompanyProfile = mysql_query($queryCompanyProfile);   
        $CompanyProfile=mysql_fetch_array($queryCompanyProfile);
  

        $crisilRating = "http://google.com/search?btnI=1&q=".$cprofile->elements['FCompanyName']."+site:crisil.com";
        $careRating = "http://google.com/search?btnI=1&q=".$cprofile->elements['FCompanyName']."+site:careratings.com";
        $ICRAratingUrl = "http://icra.in/search.aspx?word=".$cprofile->elements['FCompanyName'];
         $webdisplay = $CompanyProfile[34];
         $companyWebsite  = $CompanyProfile[34];
        $pos1 = strpos($companyWebsite, "http://");
        $pos2 = strpos($companyWebsite, "https://");
        
        if ($pos1 === false && $pos2 === false) {
            $CompanyProfile["Website_url"] = "http://".$companyWebsite;
        }else{
            $CompanyProfile["Website_url"] = $companyWebsite;
        }
            $linkedinSearchDomain=  str_replace("http://www.", "", $webdisplay); 
            $linkedinSearchDomain=  str_replace("http://", "", $linkedinSearchDomain); 
            if(strrpos($linkedinSearchDomain, "/")!="")
            {
               $linkedinSearchDomain= substr($linkedinSearchDomain, 0, strpos($linkedinSearchDomain, "/"));
            } 
            $companylinkedIn = $linkedinSearchDomain;
            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $link = $actual_link;
            $SCompanyName=$cprofile->elements['SCompanyName'];
            $SCompanyName_url = urlencode(trim($cprofile->elements['SCompanyName']));
 
          
            // $financial_data .='<h2> dewjkrhe </h2> </div>';
            $financial_data .='  <div class="finance-cnt">    
<div class="work-masonry-thumb" style="margin:5px">
   <h2 style="background:none !important"> COMPANY PROFILE </h2>';

   

   $financial_data .='<div class="linkedin-bg">
      <input type="hidden" name="dataId" id="dataId">
   </div>
   <table width="100%" cellspacing="0" cellpadding="0" class="company-profile-table">
      <tbody>
         <tr>
            <td>
               <table style="border: 0 !important;">
                  <tbody>
                  <tr>';

                  if($CompanyProfile[59] != ''){
                     $financial_data .='<td>Industry<span>'.$CompanyProfile[59].'</span></td>';
                   } else { 
                     $financial_data .=' <td></td>';
                   } 
                   $financial_data .='</tr>
                     <tr>
                        <td>Sector<span>Specialty Textiles</span></td>
                     </tr>
                     <tr>
                        <td></td>
                     </tr>
                     <tr>
                        <td>Business Description<span>A B Cotspin India Limited operates as a manufacturer of textiles</span></td>
                     </tr>
                     <tr>
                        <td></td>
                     </tr>
                     <tr id="viewlinkedin_loginbtn">
                     </tr>
                  </tbody>
               </table>
            </td>
            <td>
               <table style="border: 0;">
                  <tbody>
                     <tr>
                        <td>CIN Number<span>U17111PB1997PLC020118</span></td>
                     </tr>
                     <tr>
                        <td>Year Founded<span>1997</span></td>
                     </tr>
                     <tr>
                        <td>Status<span>Privately held(Ltd)</span></td>
                     </tr>
                     <tr>
                        <td>Transaction Status<span>Non-PE Backed</span></td>
                     </tr>
                     <tr>
                        <td>Company Status<span>Active</span></td>
                     </tr>
                     <tr>
                        <td></td>
                     </tr>
                     <tr>
                     </tr>
                  </tbody>
               </table>
            </td>
            <td>
               <table style="border: 0;">
                  <tbody>
                     <tr>
                        <td>Contact Name<span>DEEPAK GARG</span></td>
                     </tr>
                     <tr>
                        <td>Designation<span>Managing Director</span></td>
                     </tr>
                     <tr>
                        <td>Auditor Name<span>SHIV JINDAL &amp; CO</span></td>
                     </tr>
                     <tr>
                        <td></td>
                     </tr>
                     <tr>
                        <td></td>
                     </tr>
                     <tr>
                        <td></td>
                     </tr>
                  </tbody>
               </table>
            </td>
            <td>
               <table style="border: 0;">
                  <tbody>
                     <tr>
                        <td>Address<span>176 Homeland Enclave, Bathinda, Bathinda Bathinda PB 151001 IN</span></td>
                     </tr>
                     <tr>
                        <td>City<span>Bathinda</span></td>
                     </tr>
                     <tr>
                        <td>Country<span>India</span></td>
                     </tr>
                     <tr>
                     </tr>
                     <tr>
                        <td>Email<span>cs@abcotspin.in</span></td>
                     </tr>
                     <tr>
                        <td> Website
                           <span><a href="https://www.google.com/search?btnI=1&amp;q=A B Cotspin " target="_blank">Click Here</a></span>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </td>
         </tr>
         <tr>
            <td colspan="5">
               <div id="sample" style="padding:10px 10px 0 0;" class="fl">
                  <iframe src="" id="lframe" scrolling="no" frameborder="no" align="center" width="400" height="0"></iframe>
               </div>
               <div class="fl" style="padding:10px 10px 0 0;"><iframe src="" id="lframe1" scrolling="no" frameborder="no" align="center" width="674" height="0"></iframe></div>
            </td>
         </tr>
      </tbody>
   </table>
</div> </div>';


echo json_encode($financial_data);
exit;

?>