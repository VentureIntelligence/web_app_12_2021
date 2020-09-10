<?php
if(!isset($_SESSION)){
    session_save_path("/tmp");
    session_start();
}
$cin = $_REQUEST['cin'];
include_once('simple_html_dom.php');
//Data from MCA website 
try{ 
    $urltopost = "http://www.mca.gov.in/mcafoportal/companyLLPMasterData.do";
    $datatopost = array ("companyID" => $cin);
    $ch = curl_init ($urltopost);
    curl_setopt ($ch, CURLOPT_POST, true);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, $datatopost);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
    if(curl_exec($ch) !== false) {
        $returndata = curl_exec ($ch); 
        curl_close($ch);
        $LLPMaster = str_get_html($returndata);
        $LLPMasterForm = $LLPMaster->find('form[id=exportCompanyMasterData]', 0);

        $LLPMasterProfile = $LLPMaster->find('div[id=companyMasterData]', 0);
        $llpMasterData = $LLPMaster->find('div[id=llpMasterData]', 0);
        $LLPMasterFormSubmit = $LLPMaster->find('input[id=exportCompanyMasterData_0]', 0);
        $LLPMasterFormAltScheme = $LLPMaster->find('input[id=altScheme]', 0);
        $LLPMasterFormExportCompanyMasterData_companyID = $LLPMaster->find('input[id=exportCompanyMasterData_companyID]', 0);
        $LLPMasterFormExportCompanyMasterData_companyName = $LLPMaster->find('input[id=exportCompanyMasterData_companyName]', 0);
        if(isset($LLPMasterForm)){
         ?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.js"></script>
            <style>#resultTab1{width:100%} #chargesRegistered div, #signatories div{padding: 0px 10px 10px 10px;
                margin: 0;
                border-bottom: 1px solid #d4d4d4;
                color: #c09f74 !important;
                font-weight: bold;
                font-size: 18px;} .table-header th{ border-bottom:2px solid #d4d4d4; border-right:1px solid #d4d4d4; padding: 10px; }


            /* The Modal (background) */
            .modal {
                display: none; /* Hidden by default */
                position: fixed; /* Stay in place */
                z-index: 1; /* Sit on top */
                padding-top: 100px; /* Location of the box */
                left: 0;
                top: 0;
                width: 100%; /* Full width */
                height: 100%; /* Full height */
                overflow: auto; /* Enable scroll if needed */
                background-color: rgb(0,0,0); /* Fallback color */
                background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            }

            /* Modal Content */
            .modal-content {
                background-color: #fefefe;
                margin: auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
                min-height: 500px;
            }

            /* The Close Button */
            .close {
                color: #aaaaaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: #000;
                text-decoration: none;
                cursor: pointer;
            }
            .modal-content #resultsTab2, .modal-content #resultsTab3{ width : 100%;}
            .modal-content table tr th{ border-bottom:2px solid #d4d4d4; border-right:1px solid #d4d4d4; }
            .modal-content table{ border:1px solid #d4d4d4; }
            .modal-content #dirMasterData span{ color: #c09f74 !important; font-weight: bold;}
            table{
                    border-spacing: 0px;
            }
            .finance-cnt .imgButton{
                    margin: 0;
                font-size: 14px;
                border: 1px solid #000;
                float: left;
                background: #a37635;
                padding: 3px 5px;
                text-transform: uppercase;
                color: #fff;
                font-weight: bold;
            }
            #charges b{color:#c0a172;font-size:18px;}
            #resultTab1{ border-bottom: none;}
            </style>
            <script>
                var companyMasterData = $('#companyMasterData').html();
                 var companyMasterData_val = $.trim(companyMasterData);
                 if(companyMasterData_val == ''){
                     $('#llp_result').html('<?php echo $llpMasterData; ?>');
                 }
                        </script>
                <form id="exportCompanyMasterData" name="exportCompanyMasterData" action="http://www.mca.gov.in/mcafoportal/exportCompanyMasterData.do" method="post"> 
            <div  class="work-masonry-thumb col-4 tab_menu" id="companyMasterData_result" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
                <h2> Company Master Data <span style="float:right;"><?php echo $LLPMasterFormSubmit; ?></span></h2>
                <span id='llp_result'>
               <?php echo $LLPMasterProfile; ?>
                </span>
           </div>
            <?php echo $LLPMasterFormAltScheme; ?>
            <?php echo $LLPMasterFormExportCompanyMasterData_companyID; ?>
            <?php echo $LLPMasterFormExportCompanyMasterData_companyName; ?>
                </form>
            <?php }
    }

}  catch (Exception $e) {
    echo $e;
} ?>
<script type="text/javascript" >
                $( "#mca_data" ).on( "click", "#exportCompanyMasterData_0", function(e) {
                    e.preventDefault();
                    $('#exportCompanyMasterData').submit();
                });
            </script>
