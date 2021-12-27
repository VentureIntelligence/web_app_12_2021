<?php 
        $queryCompanyProfile ='SELECT *  FROM  cprofile INNER JOIN industries b on(Industry = b.Industry_Id) INNER JOIN countries c on(Country = c.Country_Id) INNER JOIN city d on(City = d.city_id)
         INNER JOIN state e on(	State = e.state_id) INNER JOIN sectors f on(Sector  = f.Sector_Id)  WHERE  CIN ="'.$_POST['cin'].'"'; 
                                 
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
                   $financial_data .='</tr>';
                   $financial_data .='<tr>';
                   if($CompanyProfile[84] != ''){  
                     $financial_data .='<td>Sector<span>'.$CompanyProfile[84].'</span></td></tr> ';
                    }  
                    $financial_data .='<tr>  <td></td>  </tr>  <tr>';
                   if($CompanyProfile[11] != ''){ 
                     $financial_data .='<td>Business Description<span>'.$CompanyProfile[11].'</span></td>'; 
                      } 
                      $financial_data .='</tr> <tr>  <td></td> </tr>'; 

                      $financial_data .='<tr id="viewlinkedin_loginbtn">';
                      if($CompanyProfile[35] != ''){  
                        $financial_data .='<td><a href="'.$CompanyProfile[35].'" target="_blank">View LinkedIn Profile</a></td>';
                        } 
                        $financial_data .='</tr>';
                      $financial_data .=' 
                  </tbody>
               </table>
            </td>
            <td>
               <table style="border: 0;">
                  <tbody>';
                  if($CompanyProfile[50] != ''){ 
                     $financial_data .=' <td>CIN Number<span>'.$CompanyProfile[50].'</span></td>';
                     }
                    $financial_data .=' </tr>';
                   
                    
                    $financial_data .='<tr>';
                     if($CompanyProfile[15] != ''){ 
                        $financial_data .='<td>Year Founded<span>'.$CompanyProfile[15].'</span></td>';
                     } 
                    $financial_data .='</tr>';
                  
                    $financial_data .='<tr>';
                          if($CompanyProfile[16] != ''){ 
                             if($CompanyProfile[16] == 0){  
                              $financial_data .='<td>Status<span>Both</span></td>';
                              } else if($CompanyProfile[16] == 1){  
                                 $financial_data .='<td>Status<span>Listed</span></td>';
                              } else if($CompanyProfile[16] == 2){  
                                 $financial_data .='<td>Status<span>Privately held(Ltd)</span></td>';
                              } else if($CompanyProfile[16] == 3){  
                                 $financial_data .='<td>Status<span>Partnership</span></td>';
                              } else if($CompanyProfile[16] == 4){  
                                 $financial_data .='<td>Status<span>Proprietorship</span></td>';
                              }  
                         }  
                    $financial_data .='</tr>';
                    $financial_data .='<tr>';
                   if($CompanyProfile[6] != ''){
                       if($CompanyProfile[6] == 0){
                        $financial_data .='<td>Transaction Status<span>PE Backed</span></td>';
                       } else if($CompanyProfile[6] == 1){
                        $financial_data .='<td>Transaction Status<span>Non-PE Backed</span></td>';
                        } else if($CompanyProfile[6] == 2){
                        //  <!--   <td>Transaction Status<span>Non-Transacted  and Fund Raising</span></td> -->
                       }
                   }
                   $financial_data .='</tr>';




                   $financial_data .='<tr>';
                   if($CompanyProfile[17] != ''){ 
                     $financial_data .='<td>Company Status<span>'.$CompanyProfile[17].'</span></td>';
                     } 
                     $financial_data .='</tr>';
                     $financial_data .='<tr>';
                     $financial_data .='<td></td>';
                     $financial_data .='</tr><tr>';
                   if($CompanyProfile[5] != ''){
                     $financial_data .='<td>Former Name<span>'.$CompanyProfile[5].'</span></td>';
                    }
               $financial_data .='</tr>';
                
                $financial_data .=' 
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
                  <tbody>';

                  $financial_data .='<tr>';
                  if($CompanyProfile[37] != ''){
                  $financial_data .='<td>Contact Name<span>'.$CompanyProfile[37].'</span></td>';
                  }
                  $financial_data .='</tr> <tr>';
                  if($CompanyProfile[38] != ''){
                     $financial_data .='<td>Designation<span>'.$CompanyProfile[38].'</span></td>'; 
                     }
                     $financial_data .='</tr>';
                     $financial_data .='<tr>';
                   if($CompanyProfile[56] != ''){
                     $financial_data .='<td>Auditor Name<span>'.$CompanyProfile[56].'</span></td>';
                      }
                      $financial_data .='</tr>';

                      $financial_data .=' 
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
                  <tbody>';



                  $financial_data .=' <tr>';
                  if($CompanyProfile[25] != ''){  
                     $financial_data .=' <td>Address<span>'.$CompanyProfile[25].'</span></td>';
                       } 
                       $financial_data .=' </tr>';
                       $financial_data .=' <tr>';
                  if($CompanyProfile[72] != ''){
                     $financial_data .=' <td>City<span>'.$CompanyProfile[72].'</span></td>'; 
                      }
                      $financial_data .=' </tr>';
                      $financial_data .=' <tr>';
                  if($CompanyProfile[62] != ''){
                     $financial_data .=' <td>Country<span>'.$CompanyProfile[62].'</span></td>';
                      }
                      $financial_data .=' </tr> <tr>';
                  if($CompanyProfile[31] != ''){
                     $financial_data .=' <td>Telephone<span>'.$CompanyProfile[31].'</span></td>';
                      }
                      $financial_data .=' </tr><tr>';
                     
                     if($CompanyProfile[33] != ''){
                        $financial_data .=' <td>Email<span>'.$CompanyProfile[33].'</span></td>';
                          } 
                          $financial_data .=' </tr>';
                          $financial_data .=' <tr>';
                  if($CompanyProfile[34] != ''){
                     $financial_data .=' <td>Website<span><a href="'.$CompanyProfile['Website_url'].'" target="_blank">'.$CompanyProfile[34].'</a></span></td>';
                   } else {  
                     $financial_data .=' <td> Website';
                     $financial_data .=' <span><a href="https://www.google.com/search?btnI=1&q='.$CompanyProfile[1].'" target="_blank">Click Here</a></span>';
                     $financial_data .=' </td>'; 
                   }
                   $financial_data .=' </tr>';

              $financial_data .=' 
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