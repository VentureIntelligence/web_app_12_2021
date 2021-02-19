<style>.popup ol li{
    list-style-type: decimal; }
#lepopup-wrap{
    top:170px !important;
}</style>
<?php
require_once("../dbconnectvi.php");//including database connectivity file
$Db = new dbInvestments();
if(!isset($_SESSION['UserNames']))
{
         header('Location:../pelogin.php');
}
else
{
if($defpage == 0)
{
?>
 <div id="popup1" style="width:800px;display: none;" class="popup">

    <h3>For the purpose of this database:</h3>
    <ul class="def-list">
        <li>In general, only investments by firms structured as PE/VC funds are INCLUDED</li>
        <li>Real Estate deals - both entity level and project-level are EXCLUDED</li>
        <li>In general, hedge funds / sovereign wealth funds investments into listed cos. are EXCLUDED</li>
        <li>Pre-IPO deals (6-months within IPO-filing date) by hedge funds / sovereign wealth funds / family offices / individuals / public market investors are EXCLUDED</li>
        <li>Strategic Investments and Barter Deals are EXCLUDED</li>
        <li>Follow-on investments by the same investor(s) into a company are included as separate transactions as long as the investments fall in different months. Newer investments in the same month (for example, multiple investments via the public markets) are updated as part of the same transaction.</li>
    </ul>
    <h2>Definitions of Stages-of-company-development used (Private Equity):  </h2>
    <h3>Private Equity investments are classified into the following categories: </h3>
    <h4>Venture Capital: </h4>
   
      <ul class="def-list">
          <li>First to Fourth Round of institutional investments into companies that are:</li>
          <li>Less than < 10 years old, AND</li>
          <li>Investment amount is less than $20 M</li>
      </ul>
    <h4 >Growth-PE: </h4>
    <ul class="def-list">
        <li>First-to-Fourth Round Investments >$20 M into companies < 10 years old, OR </li>
        <li>Fifth / Sixth rounds of institutional investments into companies < 10 years old</li>
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
    
</div>
<?php
}
else if($defpage == 1)
{
 ?>
 <div id="popup1" style="width:450px;display: none;" class="popup">
<p>Venture Capital is a sub-set of Private Equity.</p>

	<h3>Definitions of Stages-of-company-development used (Venture Capital): </h3>
	<h3>Venture Capital investments are classified into the following categories:.</h3>

	<h4>Early Stage:</h4>
	<p>First or Second Round of institutional investments into companies that are: </p>

        <ul class="def-list">
            <li>  Less than five years old, AND  </li> 
            <li>    Not part of a larger business group, AND</li> 
            <li>   Investment amount is less than $20 M</li> 
        </ul>
	<h4>Growth Stage:</h4>
        <ul class="def-list">
                <li>Third / Fourth Round funding of institutional investments OR</li>
                <li>First/Second Round of institutional investments for companies that are >5 years old and < 10 years old OR spin-outs from larger businesses, AND</li>
                <li>Investment amount is less than $20 M</li>
        </ul>
        <h4>For the purpose of this database:</h4>
        <p>Investments by India-dedicated Funds into Cross-Border Cos. (i.e., firms with headquarters outside India but substantial operations in India) are INCLUDED.<br>
        Follow-on investments by the same investor(s) into a company are included as separate transactions.</p>
 </div>
<?php
}
else if($defpage == 2)
{
    ?>
    <div id="popup1" style="width:450px;" class="popup">
        <h3>Angel Investments </h3>
        <h4>Note: This database is restricted to investments by organized Angel Networks and 
        Resident Individuals who have made active investments since 2004.</h4>
    </div>
  <?php  
}
else if($defpage == 3)
{
?>
<div id="popup1" style="width:450px;" class="popup">
    
<!--<p>The following types of</p> <h3>equity investments by insitutional investors</h3> <p>have been included in this database</p>
<ul class="def-list">
    <li>All investments by Social Sector Funds like Aavishkaar, Acumen Fund, etc. are INCLUDED </li>
    <li>&nbsp; All Early and Growth Stage Investments in Social Infrastructure sectors like Education & Healthcare are INCLUDED </li>
    <li>&nbsp; All Rural Banking and Microfinance Sector Investments ($20-M or Lower) are INCLUDED </li>
    <li>&nbsp; All Investments into Publicly-listed entities and Pre-IPO placements are EXCLUDED </li>
 </ul>

<h3>Note for users of PE/VC Database: </h3>
<p>Investments by Social Sector Only Funds do not feature in the PE/VC database - unless they are co-investments with
regular PE/VC funds. Other social venture investments appear in the PE/VC database as well.</p>-->
    <h3>Social Venture Capital / Impact Investments include:</h3>
    <ol>
        <li> All investments that involve a Specialist Social VC / Impact Investors (like Aavishkaar, Acumen Fund, Michael & Susan Dell Foundation, Omidyar Network, etc.)</li>

        <li> Follow on investments into companies that previously raised capital from Specialist Social VC / Impact Investors</li>
    </ol>
 </div>
<?php
}
else if($defpage == 5)
{
?>
    <div id="popup1" style="width:450px;" class="popup">
        <h3>For the purpose of this database, the Industries included are:</h3>

        <ul class="def-list">
            <li>Energy (excluding equipment makers)</li>
            <li>Engg. & Construction</li>
            <li>Shipping & Logistics </li>
            <li>Mining & Minerals</li>
            <li>Telecom (excluding equipment vendors and VAS providers) </li>
            <li>Travel & Transport (excluding travel agencies, portals, etc.) </li>
        </ul>
        <ul class="def-list">
            <li>At this point, we have NOT included Education, Healthcare and Hotels & Resorts in this database. </li>
        </ul>
    </div>
<?php
}
else if($defpage == 31)
{
?>
    <div id="popup1" style="width:450px;" class="popup">
    <h3>For the purpose of this database:</h3>
     <ul class="def-list">
        <li> Exit deals involving investors in a company that has already been featured under PE/VC-backed IPOs (for that particular investor) are EXCLUDED </li>
        <li> Real Estate deals are EXCLUDED</li>
     </ul>
    <h3>Exits via M&A include the following types of deals: </h3>
    <ul class="def-list">
        <li><b> Buyback:</b> Purchase of the PE/VC investors’ equity stakes by either the investee company or its founders/promoters.</li>
        <li><b>Strategic Sale:</b> Sale of the PE/VC investors’ equity stakes (or the entire investee company itself) to a third party company (which is typically a larger company in the same sector). </li>
        <li><b> Secondary Sale:</b> Purchase of the PE/VC investors’ equity stakes by another PE/VC investors. </li>
    </ul>
     </div>
<?php
}
else if($defpage == 30)
{
?>
<div id="popup1" style="width:450px;" class="popup">
    <ul class="def-list">
        <li><b> Public Market Sale:</b> Sale of the PE/VC investors’ equity stakes in listed companies through the public stock market. <br/>Note: To avoid double counting the exits, Public Market Sales by investors who had invested more than 6 months before the company's IPO are captured as part of PE-backed IPO database. <br /></li>
    </ul>
    <h3>For the purpose of this database:</h3>
    <ul class="def-list">
        <li>Exit deals involving investors in a company that has already been featured under PE/VC-backed IPOs (for that particular investor) are EXCLUDED </li>
        <li>Real Estate deals are EXCLUDED</li>
    </ul>
</div>
<?php
}
else if($defpage == 10)
{
?>
<div id="popup1" style="width:450px;" class="popup">
    <h3>For the purpose of this database:</h3>
    <ul class="def-list">
        <li> Only IPOs by companies in which PE/VC funds had invested <b>more 6 months before the IPO filing</b> are INCLUDED </li>
        <li> Post IPO sales by investors in these companies are captured as part of the More Info column of the PE-backed IPO deal.</li>
        <li>Real Estate IPOs are EXCLUDED </li>
     </ul>
</div>
<?php
}
else if($defpage == 11)
{
?>
<div id="popup1" style="width:450px;" class="popup">
    <h3>For the purpose of this database:</h3>
    <ul class="def-list">
        <li>Only IPOs by companies in which VC funds (see Definition of <a target="_blank" href="def_VC.htm">VC investments</a>) have invested more than 6 months before the IPO are INCLUDED </li>
        <li> Real Estate IPOs are EXCLUDED </li>
    </ul>
    </div>
<?php
}
}
?>