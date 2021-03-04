<?php 
 require_once("../dbconnectvi.php");
 $Db = new dbInvestments();
 if(!isset($_SESSION['UserNames']))
 {
     header('Location:../pelogin.php');
 }
 else
 {	
     ?>
<style>
    /* .tagSearch{
        padding: 5px 15px;
        font-size: 12px;
        font-weight: bold;
        background: #000;
        color: #fff;
        line-height: 35px;
        border-radius: 25px;
        margin-left: 5px;
        margin-right: 5px;
        white-space: nowrap;
        box-shadow: 2px 1px 2px 2px #ccc;
    }
    .sub-tag {
        font-weight: bold;
        font-size: 15px;
        text-align: center;
        text-transform: uppercase;
        margin-bottom:2px;
    }
    .helplineTag {
        float: right;
        padding-right: 5%;
        padding-bottom: 2%;
    } */
.listitem_ascolun{
    -webkit-column-width: 150px;
    -moz-column-width: 150px;
    -o-column-width: 150px;
    -ms-column-width: 150px;
    column-width: 150px;
    /* -webkit-column-rule-style: solid; */
    -moz-column-rule-style: solid;
    -o-column-rule-style: solid;
    -ms-column-rule-style: solid;
    /* column-rule-style: solid; */
}
.sub-tag {
    display: block;
    border-bottom: 1px solid;
    padding: 10px;
    text-align: center;
    margin:0px;
    font-weight: bold;
    font-size: 15px;
}
#popup6 ul.def-list {
    border: 1px solid;
    padding: 0;
    margin:2% 0 4% auto;
}
#popup6 ul.def-list li {
    padding: 0 8px;
    line-height: 30px;
   
}
.helplineTag {
        padding-right: 5%;
        padding-bottom: 2%;
}

.overlaydiv{
    position: absolute;
    /*left: 322.5px;
    top: 170px !important;*/
    min-width: 400px;
     display: none; 
    z-index: 100031;
    background-color: #fff;
    padding: 30px;
    padding-right: 0px;
        border-radius: 5px;
        top: 25%;
    left: 50%;
    margin-left: -400px; 
    margin-top: -40px; 
}

.overlayshowdow{
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background-color: #000000;
    zoom: 1 !important;
    filter: alpha(opacity=70) !important;
    opacity: 0.7 !important;
    display: none;
    z-index: 10000;
}
.overlayinner{
    height: 500px;
    overflow: auto;
    margin-top: 35px;

}
.close{
    background-image: url(../dealsnew/images/sprite-close.png);
    background-repeat: no-repeat;
    background-position: 0px -14px;
    width:15px;
    height: 15px;
    position: absolute;
        cursor: pointer;
            right: 2%;
}
.overlayheader{
position: absolute;
    left: 0;
    right: 0;
    padding: 20px 30px;
    top: 1%;
    background: #fff;
}
.tagpopup{
    cursor: pointer;
}
</style>
<?php
//echo "page".$defpage;
//echo "stage".$stagedef;
//echo "inv".$investdef;
// echo "ind".$indef;
//echo "deal".$dealdef;
if(($defpage == 0 && $stagedef == 1) || ($defpage == 5 && $stagedef == 1)|| ($defpage == 3 && $stagedef == 1)|| ($defpage == 4 && $stagedef == 1) || ($defpage ==41 && $stagedef == 1) || ($defpage == 42 && $stagedef == 1))
{
?>
 <div id="popup2" style="width:800px;display: none;" class="popup">

    <h3>Early Stage</h3>
    <h4>First / Second Round of institutional investments into companies that are:<h4>
    <ul class="def-list">
        <li>Less than five years old, AND</li>
        <li>Not part of a larger business group, AND</li>
        <li>Investment amount is less than $20 M</li>
        </ul>
   
    <h3>Growth Stage:</h3>
      <ul class="def-list">
          <li>Third / Fourth Round funding of institutional investments OR</li>
          <li>First/Second Round of institutional investments for companies that are >5 years old and
				< 10 years old OR spin-outs from larger businesses, AND</li>
          <li>Investment amount is less than $20 M</li>
      </ul>
    <h3>Growth Stage-PE: </h3>
    <ul class="def-list">
        <li>First/Second Round Investments >$20 M, OR </li>
        <li>Third / Fourth Round funding for companies that are >5 years old and < 10 years old OR subsidiaries/spin-outs of larger businesses, OR</li>
         <li>Fifth / Sixth rounds of institutional investments</li>
    </ul>
    <h4 >Late Stage: </h4>
    <ul class="def-list">
        <li>Investment into companies that are over 10 years old, OR </li>
        <li>Seventh or later rounds of institutional investments</li>
    </ul>
    <h4>PIPEs: </h4>
    <ul class="def-list">
       <li> PE investments in publicly-listed companies via preferential allotments / private  placements, OR</li>
       <li>	Acquisition of shares by PE firms via the secondary market</li>
    </ul>
    <h4 >Buyout: </h4>
    <ul class="def-list">
        <li>Acquisition of controlling stake via purchase of stakes of existing shareholders  </li>
    </ul>
     <h4 >Buyout - Large: </h4>
    <ul class="def-list">
        <li>Buyout Deals of $100-M+ in Value </li>
    </ul>
      <h4 >Other: </h4>
    <ul class="def-list">
        <li>PE investments in Special Purpose Vehicle (SPV) or Project-level investments. </li>
    </ul>
    
</div>
<?php
}
if($defpage == 0 && $investdef == 1 || $defpage == 38  )
{
?>
 <div id="popup3" style="width:800px;display: none;" class="popup">

    <ul class="def-list">
        <li><b>Foreign :</b> PE/VC firms that do not have a dedicated fund for India. (eg. Carlyle) </li>
        <li><b>Indian :</b> PE/VC firms that invest out of a India-dedicated fund. (eg. Sequoia Capital India)</li>
        <li><b>Co-investments : </b>Investments which involve both foreign funds and India-dedicated funds</li>
    </ul>
</div>
<?php 
}
if( ($defpage == 3 && $stagedef == 3) )
{
 ?>
<div id="popup2" style="width:800px;display: none;" class="popup">

    <!--<h3>Early Stage</h3>
    <h4>First / Second Round of institutional investments into companies that are:<h4>
    <ul class="def-list">
        <li>Less than five years old, AND<li>
        <li>Not part of a larger business group, AND<li>
        <li>Investment amount is less than $20 M<li>
        </ul>
   
    <h3>Growth Stage:</h3>
      <ul class="def-list">
          <li>Third / Fourth Round funding of institutional investments OR</li>
          <li>First/Second Round of institutional investments for companies that are >5 years old and
				< 10 years old OR spin-outs from larger businesses, AND</li>
          <li>Investment amount is less than $20 M</li>
      </ul>-->
    <h3>Social Venture Capital / Impact Investments include:</h3>
    <ol>
        <li> All investments that involve a Specialist Social VC / Impact Investors (like Aavishkaar, Acumen Fund, Michael & Susan Dell Foundation, Omidyar Network, etc.)</li>

        <li> Follow on investments into companies that previously raised capital from Specialist Social VC / Impact Investors</li>
    </ol>
    <h3>Early Stage</h3>
    <h4>First / Second Round of institutional investments into companies that are:<h4>
    <ul class="def-list">
        <li>Less than five years old, AND</li>
        <li>Not part of a larger business group, AND</li>
        <li>Investment amount is less than $20 M</li>
        </ul>
   
    <h3>Growth Stage:</h3>
      <ul class="def-list">
          <li>Third / Fourth Round funding of institutional investments OR</li>
          <li>First/Second Round of institutional investments for companies that are >5 years old and
				< 10 years old OR spin-outs from larger businesses, AND</li>
          <li>Investment amount is less than $20 M</li>
      </ul>
    <h3>Growth Stage-PE: </h3>
    <ul class="def-list">
        <li>First/Second Round Investments >$20 M, OR </li>
        <li>Third / Fourth Round funding for companies that are >5 years old and < 10 years old OR subsidiaries/spin-outs of larger businesses, OR</li>
         <li>Fifth / Sixth rounds of institutional investments</li>
    </ul>
    <h4 >Late Stage: </h4>
    <ul class="def-list">
        <li>Investment into companies that are over 10 years old, OR </li>
        <li>Seventh or later rounds of institutional investments</li>
    </ul>
    <h4>PIPEs: </h4>
    <ul class="def-list">
       <li> PE investments in publicly-listed companies via preferential allotments / private  placements, OR</li>
       <li>	Acquisition of shares by PE firms via the secondary market</li>
    </ul>
    <h4 >Buyout: </h4>
    <ul class="def-list">
        <li>Acquisition of controlling stake via purchase of stakes of existing shareholders  </li>
    </ul>
     <h4 >Buyout - Large: </h4>
    <ul class="def-list">
        <li>Buyout Deals of $100-M+ in Value </li>
    </ul>
      <h4 >Other: </h4>
    <ul class="def-list">
        <li>PE investments in Special Purpose Vehicle (SPV) or Project-level investments. </li>
    </ul>
</div>

<?php
}
if( ($defpage == 1 && $stagedef == 1))
{
 ?>
<div id="popup2" style="width:800px;display: none;" class="popup">

    <h3>Early Stage</h3>
    <h4>First / Second Round of institutional investments into companies that are:</h4>
    <ul class="def-list">
        <li>Less than five years old, AND</li>
        <li>Not part of a larger business group, AND</li>
        <li>Investment amount is less than $20 M</li>
        </ul>
   
    <h3>Growth Stage:</h3>
      <ul class="def-list">
          <li>Third / Fourth Round funding of institutional investments OR</li>
          <li>First/Second Round of institutional investments for companies that are >5 years old and
				< 10 years old OR spin-outs from larger businesses, AND</li>
          <li>Investment amount is less than $20 M</li>
      </ul>
</div>
<?php
}
if(($defpage == 1 && $investdef == 1) || ($defpage == 5 && $investdef == 1)|| ($defpage == 3 && $investdef == 1)|| ($defpage == 4 && $investdef == 1)|| ($defpage == 10 && $investdef == 1)
        || ($defpage == 11 && $investdef == 1) || ($defpage ==31 && $investdef == 1)|| ($defpage == 32 && $investdef == 1)|| ($defpage == 30 && $investdef == 1))
{
?>
 <div id="popup3" style="width:800px;display: none;" class="popup">

    <ul class="def-list">
        <li><b>Foreign :</b> PE/VC firms that do not have a dedicated fund for India. (eg. Carlyle) </li>
        <li><b>Indian :</b> PE/VC firms that invest out of a India-dedicated fund. (eg. Sequoia Capital India)</li>
        <li><b>Co-investments : </b>Investments which involve both foreign funds and India-dedicated funds</li>
    </ul>
</div>
<?php 
}
if(($defpage == 5 && $indef == 1) || ($defpage == 2 && $indef == 1)|| ($defpage == 6 && $indef == 1))
{
    ?>
    <div id="popup4" style="width:800px;display: none;" class="popup">

    <h4>For the purpose of this database, the Industries included are:</h4>
    <ul class="def-list">
        <li>Energy (excluding equipment makers)</li>
        <li> Engg. & Construction</li>
        <li>Shipping & Logistics</li>
        <li> Mining & Minerals</li>
        <li> Telecom (excluding equipment vendors and VAS providers)</li>
        <li> Travel & Transport (excluding travel agencies, portals, etc.)</li>
        </ul>
    <p>At this point, we have NOT included Education, Healthcare and Hotels & Resorts in this database.</p>
</div>
 <?php   
}
if(($defpage ==31 && $dealdef == 1)|| ($defpage ==32 && $dealdef == 1) || ($defpage ==38 && $dealdef == 1))
{
    ?>
<div id="popup5" style="width:800px;display: none;" class="popup">

    <h3>Buyback:</h3>
    <ul class="def-list">
        <li>Purchase of the PE/VC investors’ equity stakes by either the investee company or its founders/promoters.</li>
    </ul>
   
    <h3>Strategic Sale:</h3>
      <ul class="def-list">
          <li>Sale of the PE/VC investors’ equity stakes (or the entire investee company itself) to a third party company (which is typically a larger company in the same sector).</li>
      </ul>
    <h3>Secondary Sale:</h3>
      <ul class="def-list">
          <li>Purchase of the PE/VC investors’ equity stakes by another PE/VC investors.</li>
      </ul>
    <h3>Public Market Sale:</h3>
      <ul class="def-list">
          <li>Sale of the PE/VC investors’ equity stakes (in a listed company) through the public market.</li>
      </ul>
</div>
<?php
}
?>

<div class="overlayshowdow"></div>
<div class="overlaydiv">
    
<div class="overlayinner">
<div id="popup6" style="width:800px;    padding-right: 20px;" >
    <div class="overlayheader">
    <div class="close" title="Close Popup"></div>
    <h3 style="text-align: center;    font-size: 18px;">Tag List</h3>
    </div>
    <ul class="def-list">
        <p class="sub-tag">Industry Tags</p>
        <li class="listitem_ascolun">
             <ul>
            <?php 
                    $tagsql = "SELECT substring_index(tag_name, ':', -1) as tag FROM `tags` WHERE tag_type='Industry Tags'  ORDER BY tag";

                    if ($rstag = mysql_query($tagsql))
                    {
                        While($myrow=mysql_fetch_array($rstag, MYSQL_BOTH)){
                            $tag_name=trim($myrow['tag']); ?>
                            
                                <li><?php echo $tag_name?></li>
                            
              <?php }
                       
                    }
            ?>
            </ul>
        </li>
    </ul>
    <ul class="def-list">
        <p class="sub-tag">Sector Tags</p>
        <li class="listitem_ascolun">
            <ul>
            <?php 
                        $tagsql = "SELECT substring_index(tag_name, ':', -1) as tag FROM `tags` WHERE tag_type='Sector Tags' ORDER BY tag";

                        if ($rstag = mysql_query($tagsql))
                        {
                            While($myrow=mysql_fetch_array($rstag, MYSQL_BOTH)){
                                $tag_name=trim($myrow['tag']); ?>
                                 <li><?php echo $tag_name?></li>
                <?php }
                        
                        }
                ?>
            </ul>
        </li>
    </ul>
    <ul class="def-list">
        <p class="sub-tag">Competitor Tags</p>
        <li class="listitem_ascolun">
            <ul>
            <?php 
                        $tagsql = "SELECT substring_index(tag_name, ':', -1) as tag FROM `tags` WHERE tag_type='Competitor Tags'  ORDER BY tag";

                        if ($rstag = mysql_query($tagsql))
                        {
                            While($myrow=mysql_fetch_array($rstag, MYSQL_BOTH)){
                                $tag_name=trim($myrow['tag']); ?>
                                 <li><?php echo $tag_name?></li>
                <?php }
                        
                        }
                ?>
            </ul>
        </li>
    </ul>
</div>
</div>
</div>
<?php } ?>