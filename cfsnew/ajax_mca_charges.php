<?php
include "header.php";
include "sessauth.php";
// if(!isset($_SESSION)){
//     session_save_path("/tmp");
//     session_start();
// }
$cin = $_REQUEST['cin'];
include_once('simple_html_dom.php');
//Data from MCA website 
try{ 
    //Index of charges tata from MCA website
        $urltopost = "http://www.mca.gov.in/mcafoportal/viewIndexOfCharges.do";
        $datatopost = array ("companyID" => $cin);
         $ch = curl_init ($urltopost);
        curl_setopt ($ch, CURLOPT_POST, true);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $datatopost);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        if(curl_exec($ch) !== false)
        {
        $returndata = curl_exec ($ch);

        curl_close($ch);

        $LLPMasterCharges = str_get_html($returndata);
        $LLPMasterCharge = $LLPMasterCharges->find('table[id=charges]', 0);
        if(isset($LLPMasterCharge)){
        ?>
                <script type="text/javascript" >
                    var indexCharge = '<?php echo $LLPMasterCharge; ?>';
                    if(indexCharge !=''){
                        $('#chargesRegistered').html('<div style="color:#c0a172;font-size:18px;border-bottom:1px solid #d4d4d4">Index Of Charges</div>'+indexCharge);
                    }
                $('#charges .table-header:first').html('');
                $('#charges .table-header:first').hide();
                 $('#exportCompanyMasterData').attr('action', 'http://www.mca.gov.in/mcafoportal/exportCompanyMasterData.do');
                // $('#exportCompanyMasterData_0').attr('type', 'button');
                 
                </script>
            <?php
            }else{   ?>  
                    <script type="text/javascript" >               
                 //   $('.indexChargesBox').html('');
                  //  $('.indexChargesBox').hide();
                        $('#chargesRegistered').html('<div style="color:#c0a172;font-size:18px;border-bottom:1px solid #d4d4d4">Index Of Charges</div><div class="no_data">No data found</div>');
                </script>
                <?php
            }
        }

}  catch (Exception $e) {
    echo $e;
} ?>
<div  class="work-masonry-thumb col-4 indexChargesBox" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
               <br/>
               <div id="chargesRegistered" class="chargesRegistered">             
               </div>
            </div>
