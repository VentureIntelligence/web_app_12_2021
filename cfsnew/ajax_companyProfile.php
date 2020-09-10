<?php 
if(!isset($_SESSION)){
    session_save_path("/tmp");
    session_start();
}
include "header.php";
include "sessauth.php";

require_once MODULES_DIR."cprofile.php";
$cprofile = new cprofile();

$fields2 = array("*");
$where3 ='';
$fields3='*';
$where3 .= " Company_Id = ".$_GET['cid'];
$CompanyProfile = $cprofile->getFullList("","",$fields3,$where3,$order3,"name3");
$cprofile->select($_GET['cid']);
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
?>
<div  class="work-masonry-thumb "> <h2>  COMPANY PROFILE</h2>
    <table width="100%" cellspacing="0" cellpadding="0" class="company-profile-table"> 
    <tbody>

    <tr>
        <td>
            <table style="border: 0;">
                <tr>
                    <?php if($CompanyProfile[59] != ''){ ?>
                        <td>Industry<span><?php echo $CompanyProfile[59]; ?></span></td>
                    <?php } else { ?>
                        <td></td>
                    <?php } ?>
                </tr>
                <tr>
                    <?php if($CompanyProfile[84] != ''){ ?>
                    <td>Sector<span><?php echo $CompanyProfile[84]; ?></span></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <?php if($CompanyProfile[11] != ''){ ?> <td>Business Description<span><?php echo $CompanyProfile[11]; ?></span></td><?php } ?>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr id="viewlinkedin_loginbtn">
                    <?php if($CompanyProfile[35] != ''){ ?>
                    <td><a href="<?php echo $CompanyProfile[35]; ?>" target="_blank">View LinkedIn Profile</a></td>
                    <?php } ?>
                </tr>
            </table>
        </td>
        <td>
            <table  style="border: 0;">
                <tr>
                    <?php if($CompanyProfile[50] != ''){ ?>
                    <td>CIN Number<span><?php echo $CompanyProfile[50]; ?></span></td>
                    <?php } ?>
                </tr>
                <tr>
                    <?php if($CompanyProfile[15] != ''){ ?><td>Year Founded<span><?php echo $CompanyProfile[15]; ?></span></td><?php } ?>
                </tr>
                <tr>
                    <?php if($CompanyProfile[16] != ''){ ?>
                        <?php if($CompanyProfile[16] == 0){ ?>
                            <td>Status<span>Both</span></td>
                        <?php } else if($CompanyProfile[16] == 1){ ?>
                            <td>Status<span>Listed</span></td>
                        <?php } else if($CompanyProfile[16] == 2){ ?>
                            <td>Status<span>Privately held(Ltd)</span></td>
                        <?php } else if($CompanyProfile[16] == 3){ ?>
                            <td>Status<span>Partnership</span></td>
                        <?php } else if($CompanyProfile[16] == 4){ ?>
                            <td>Status<span>Proprietorship</span></td>
                        <?php } ?>
                    <?php } ?>
                </tr>
                <tr>
                    <?php if($CompanyProfile[6] != ''){ ?>
                        <?php if($CompanyProfile[6] == 0){ ?>
                            <td>Transaction Status<span>PE Backed</span></td>
                        <?php } else if($CompanyProfile[6] == 1){ ?>
                            <td>Transaction Status<span>Non-PE Backed</span></td>
                         <?php } else if($CompanyProfile[6] == 2){ ?>
                         <!--   <td>Transaction Status<span>Non-Transacted  and Fund Raising</span></td> -->
                        <?php } ?>
                    <?php } ?>
                </tr>
                 <tr>
                    <?php if($CompanyProfile[17] != ''){ ?>
                    <td>Company Status<span><?php echo $CompanyProfile[17]; ?></span></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <?php if($CompanyProfile[5] != ''){ ?><td>Former Name<span><?php echo $CompanyProfile[5]; ?></span></td><?php } ?>
                </tr>
            </table>
        </td>
        <td>
            <table  style="border: 0;">
                <tr>
                    <?php if($CompanyProfile[37] != ''){ ?>
                    <td>Contact Name<span><?php echo $CompanyProfile[37]; ?></span></td>
                    <?php } ?>
                </tr>
                <tr>
                    <?php if($CompanyProfile[38] != ''){ ?><td>Designation<span><?php echo $CompanyProfile[38]; ?></span></td><?php } ?>
                </tr>
                <tr>
                    <?php if($CompanyProfile[56] != ''){ ?><td>Auditor Name<span><?php echo $CompanyProfile[56]; ?></span></td><?php } ?>
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
            </table>
        </td>
        <td>
            <table  style="border: 0;">
                <tr>
                    <?php if($CompanyProfile[25] != ''){ ?><td>Address<span><?php echo $CompanyProfile[25]; ?></span></td><?php } ?>
                </tr>
                <tr>
                    <?php if($CompanyProfile[72] != ''){ ?><td>City<span><?php echo $CompanyProfile[72]; ?></span></td><?php } ?>
                </tr>
                <tr>
                    <?php if($CompanyProfile[62] != ''){ ?><td>Country<span><?php echo $CompanyProfile[62]; ?></span></td><?php } ?>
                </tr>
                <tr>
                    <?php if($CompanyProfile[31] != ''){ ?><td>Telephone<span><?php echo $CompanyProfile[31]; ?></span></td><?php } ?>
                </tr>
                <tr>
                    <?php if($CompanyProfile[33] != ''){ ?><td>Email<span><?php echo $CompanyProfile[33]; ?></span></td><?php } ?>
                </tr>
                <tr>
                    <?php if($CompanyProfile[34] != ''){ ?>
                    <td>Website<span><a href="<?php echo $CompanyProfile['Website_url']; ?>" target="_blank"><?php echo $CompanyProfile[34]; ?></a></span></td>
                    <?php } else { ?>
                       <td> Website
                            <span><a href="https://www.google.com/search?btnI=1&q=<?php echo $CompanyProfile[1]; ?>" target="_blank">Click Here</a></span>
                        </td> 
                    <?php } ?>
                </tr>
            </table>
        </td>
    </tr>
     <div class="linkedin-bg">
        <script type="text/javascript" > 
            
            $(document).ready(function () {
        $('#lframe,#lframe1').on('load', function () {
//            $('#loader').hide();
            
        });
            });
            
function autoResize(id){
    var newheight;
    var newwidth;

    if(document.getElementById){
        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
        newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
    }

    document.getElementById(id).height= (newheight) + "px";
    document.getElementById(id).width= (newwidth) + "px";
}

 $('#senddeal').click(function(){ 
                    jQuery('#maskscreen').fadeIn(1000);
                    jQuery('#popup-box').fadeIn();   
                    return false;
                });
            $('#cancelbtn').click(function(){ 

               jQuery('#popup-box').fadeOut();   
                jQuery('#maskscreen').fadeOut(1000);
               return false;
           });
           $("#result").on('click', '.updateFinancialDetail', function() {
                    jQuery('#maskscreen').fadeIn(1000);
                    jQuery('#popup-boxDetail').fadeIn();   
                    return false;
                });
           $(".updateFinancialDetail1").on('click', function() {
                    jQuery('#maskscreen').fadeIn(1000);
                    jQuery('#popup-boxDetail').fadeIn();   
                    return false;
                });
            $('#cancelbtnDetail').click(function(){ 

               jQuery('#popup-boxDetail').fadeOut();   
                jQuery('#maskscreen').fadeOut(1000);
               return false;
           });
           
       $(document).ready(function(){
 $('#mailbtnDetail').click(function(e){
        e.preventDefault(); 
        var to = $('#u_toaddress').val().trim();
        var subject = $('#u_subject').val().trim();
        var textMessage = $('#u_textMessage').val().trim();
        var from = $('#u_fromaddress').val().trim();
        var cc = $('#u_cc').val().trim();
        if(from ==''){
            alert("Please enter the from address");
            $('#u_fromaddress').focus();
            return false;
        }
        else if(!(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/).test(from)){
            alert('Invalid from address');
            $('#u_fromaddress').focus();
            return false;
        }
        else if((cc !='') && (!(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/).test(from))){
            alert('Invalid CC');
            $('#u_fromaddress').focus();
            return false;
        }
        else if(textMessage =='')
        {
          alert("Please enter the message");
            $('#u_textMessage').focus();
            return false;
        }else{
            $.ajax({
               url: 'ajaxsendmails.php',
                type: "POST",
               data: { to : to, subject : subject, message : textMessage , cc: cc, from : from },
               success: function(data){
                      if(data=="1"){       
                          alert("Your request has been sent successfully"); 
                         // $('#addDBFinacials')[0].reset();
                         $('#u_fromaddress').val('');
                         $('#u_textMessage').val('');
                         $('#u_cc').val('');
                         jQuery('#popup-boxDetail').fadeOut();   
                         jQuery('#maskscreen').fadeOut(1000); 
                        return true;
                  }else{
                      alert("Try Again");
                        return false;
                  }
               },
               error:function(){
                   alert("There was some problem sending request...");
                    return false;
               }
           });
           }
       }); 
       });   
            function validateEmail(field) {
                    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    return (regex.test(field)) ? true : false;
                }
            function checkEmail() {

                var email = $("#toaddress").val();
                    if (email != '') {
                        var result = email.split(",");
                        for (var i = 0; i < result.length; i++) {
                            if (result[i] != '') {
                                if (!validateEmail(result[i])) {

                                    alert('Please check, `' + result[i] + '` email addresses not valid!');
                                    email.focus();
                                    return false;
                                }
                            }
                        }
                }
                else
                {
                    alert('Please enter email address');
                    email.focus();
                    return false;
                }
                return true;
            }
            
             $('#mailbtn').click(function(){ 
                        
                        if(checkEmail())
                        {
                            
                        
                        $.ajax({
                            url: 'ajaxsendmail.php',
                             type: "POST",
                            data: { to : $("#toaddress").val(), subject : $("#subject").val(), message : $("#message").val() , userMail : $("#useremail").val() },
                            success: function(data){
                                    if(data=="1"){
                                         alert("Mail Sent Successfully");
                                        jQuery('#popup-box').fadeOut();   
                                        jQuery('#maskscreen').fadeOut(1000);
                                   
                                }else{
                                    jQuery('#popup-box').fadeOut();   
                                    jQuery('#maskscreen').fadeOut(1000);
                                    alert("Try Again");
                                }
                            },
                            error:function(){
                                jQuery('#preloading').fadeOut();
                                alert("There was some problem sending mail...");
                            }

                        });
                        }
                        
                    });
 </script>
 

         <input type="hidden" name="dataId" id="dataId" >
   
 </div>
    <tr><td colspan="5">  <div  id="sample" style="padding:10px 10px 0 0;" class="fl">
        <iframe src="" id="lframe"  scrolling="no" frameborder="no" align="center" width="400" height="0"></iframe>
    </div> <div class="fl" style="padding:10px 10px 0 0;" ><iframe src="" id="lframe1"  scrolling="no" frameborder="no" align="center" width="674" height="0" ></iframe></div> </td>    
</tr>
    </tbody>
    </table> 
    </div> 
     <div  class="work-masonry-thumb col-4" href="http://erikjohanssonphoto.com/work/aishti-ss13/" >
    <h2>  COMPANY RATING</h2>
    <table width="100%" cellspacing="0" cellpadding="0" class="company-profile-table"> 
    <tbody>
        <?php if ($ICRArating != ""){ echo $ICRAratingUrl;?>
    <tr>
        <td>
            ICRA    
            <span><a href="<?php echo $ICRAratingUrl;?>" target="_blank">View Rating</a> ($ICRArating )</span>
        </td>
     </tr>
       <?php }?>
     <tr>
         <td>
            <?php if ($FCompanyName != "ANI TECHNOLOGIES PRIVATE LIMITED"){?>
           
             CRISIL <span><a href="<?php echo $crisilRating;?>" target="_blank">View Rating</a></span>
        <?php }?>
        </td>
         <td>
             CARE <span><a href="<?php echo $careRating;?>" target="_blank">View Rating</a></span>
        </td>
         <td>
             &nbsp;
        </td>
     </tr>
     <tr>
         <td>
             SMERA <span><a href="javascript:void(0)" id="smera_link"> View Rating</a></span>
        </td>
        <form action="//www.smera.in/live_ratings.php" name="smera_form" id="smera_form" method="post" target='_blank'>
       
            <input type="hidden" name="company_name" id="company_name" value="<?php echo $SCompanyName;?>" />
        </form>
           
                <script type="text/javascript" >
                $( "#smera_link" ).click(function() {
                  $( "#smera_form" ).submit();
                });    
                </script>
            
         <td>
             BRICKWORK
            <form action="//www.brickworkratings.com/CreditRatings.aspx" name="form1" id="form1" method="post" target='_blank'>    
           <input type="hidden" name="__EVENTTARGET" id="__EVENTTARGET" value="">
           <input type="hidden" name="__EVENTARGUMENT" id="__EVENTARGUMENT" value="">
          <input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="<?php echo $B_VIEWSTATE;?>" />

           <input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="D090B1EF">
               <input type="hidden" name="__SCROLLPOSITIONX" id="__SCROLLPOSITIONX" value="0" />
               <input type="hidden" name="__SCROLLPOSITIONY" id="__SCROLLPOSITIONY" value="0" />
               <input type="hidden" name="__VIEWSTATEENCRYPTED" id="__VIEWSTATEENCRYPTED" value="" />
           <input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="<?php echo $B_EVENTVALIDATION;?>" />
               <input type="hidden" name="txtSearch" value="<?php echo $SCompanyName;?>" />
               <span> <input type="submit" name="btnSearch" style="border:none;color: #c0a172; font-weight: bold; text-decoration: underline; font-size: 16px; text-align: left; background: none; padding: 0;" value="View Rating" /> </span>
           </form>
        </td>
        <td>
             ICRA
             <span><a href="http://www.icra.in/search.aspx?word=<?php echo $SCompanyName_url;?>" target="_blank">View Rating</a></span>
        </td>
     </tr> 
    </tbody>
    </table> 
    </div> 
