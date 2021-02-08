<?php 
 require_once("../dbconnectvi.php");
 $Db = new dbInvestments();
 if(!isset($_SESSION['UserNames']))
 {
     header('Location:../pelogin.php');
 }
 else
 {?>
<script type="text/javascript">
    var demotour='';
    var vcdemotour='';
    var EXITSdemotour='';
    var Directorydemotour='';
</script>

<?php 
//$tour = array();
//        $tour['PEinvestmentsTour'] = "PEinvestmentsTour";
//        $tour['VCinvestmentsTour'] = "VCinvestmentsTour";
//        $tour['ExitsTour'] = "ExitsTour";


if($tour=='Allow'){ ?> 
    <li class="classic-btn" id="toursec">
            
            <?php if(isset($_SESSION["demoTour"]) && $_SESSION["demoTour"]=='1') { ?> 
            <input  type="button" id="tourlibtn" value="Start Tour" style="display:none"/>  
            <input  type="button" id="stopTourBtn"  value="Stop Tour" />
           
            <?php } else if(isset($_SESSION["VCdemoTour"]) && $_SESSION["VCdemoTour"]=='1') { ?> 
            <input  type="button" id="tourlibtn" value="Start Tour" style="display:none"/>  
            <input  type="button" id="stopVCTourBtn"  value="Stop Tour" />
            
            <?php } else if(isset($_SESSION["EXITSdemoTour"]) && $_SESSION["EXITSdemoTour"]=='1') { ?> 
            <input  type="button" id="tourlibtn" value="Start Tour" style="display:none"/>  
            <input  type="button" id="stopEXITSTourBtn"  value="Stop Tour" />
            
            <?php } else if(isset($_SESSION["DirectorydemoTour"]) && $_SESSION["DirectorydemoTour"]=='1') { ?> 
            <input  type="button" id="tourlibtn" value="Start Tour" style="display:none"/>  
            <input  type="button" id="stopDirectoryTourBtn"  value="Stop Tour" />
            
            <?php } else { ?>
            <input  type="button" id="tourlibtn" value="Start Tour" />  
            <input  type="button" id="autostartstopbtn"  value="Stop Tour" style="display:none"/>
            
            <?php } ?>
            
            <div id="tourlist"  style="background-color: #BFA074;display:none;position: fixed;width:130px;">
            <ul id="starttour">
            <li class="peonly_tour"> <input  type="button" class="tourbtn " id="startTourBtn" value="PE Investments" /></li> 
            <li class="vconly_tour" ><input  type="button" class="tourbtn " id="startVCTourBtn" value="VC Investments" /> </li>
            <li class="peonly_tour" ><input  type="button" class="tourbtn " id="startEXITSTourBtn" value="EXITS" /> </li>
            <li class="peonly_tour"><input  type="button" class="tourbtn last" id="startDirectoryTourBtn" value="PE-VC Directory" /> </li>
            </ul>
            </div>
    </li>
    <?php } else { ?> 
    
    <li class="classic-btn" id="toursec">           

           <input  type="button" id="tourlibtn" value="Start Tour" />  

           <div id="tourlist"  style="background-color: #BFA074;display:none;position: fixed;width:130px;">
           <ul id="starttour">
           <li class="peonly_tour"> <input  type="button" class="tourbtn " id="startTourBtn" value="PE Investments" /></li> 
           <li class="vconly_tour"><input  type="button" class="tourbtn " id="startVCTourBtn" value="VC Investments" /> </li>
           <li class="peonly_tour"><input  type="button" class="tourbtn " id="startEXITSTourBtn2" value="EXITS" /> </li>
           <li class="peonly_tour"><input  type="button" class="tourbtn last" id="startDirectoryTourBtn2" value="PE-VC Directory" /> </li>
           </ul>
           </div>

   </li>
    <?php } ?> 
   
   
   
   <script>
    <?php if($_SESSION['peonly']==1){ ?>
                $(document).ready(function(){  
                $(".peonly_tour").show();                
                $(".vconly_tour").hide();
                });
   <?php } 
   else if($_SESSION['vconly']==1){ ?>
                $(document).ready(function(){  
                $(".vconly_tour").show();                
                $(".peonly_tour").hide();
                });
   <?php } }?>
</script> 