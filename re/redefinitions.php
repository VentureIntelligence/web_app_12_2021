<?php
if($defpage == 0)
{
?>
 <div id="popup1" style="width:750px;display: none;" class="popup">

    <p>For the purpose of this database, Real Estate Investments include "cash for equity" investments made by financial investors into Real Estate companies or projects.</p>
    <ul class="def-list">
        <li> Investments by firms structured as PE/VC funds (as well as investors who compete with such investors like hedge funds / sovereign wealth funds) are INCLUDED <li>
        <li> In general, hedge funds / sovereign wealth funds investments into listed RE cos. (at the entity level) are EXCLUDED<li>
        <li>  Pre-IPO deals (6-months within IPO-filing date) by hedge funds / sovereign wealth funds / family offices / individuals / public market investors are EXCLUDED <li>
        <li>Strategic Investments and Barter Deals (like trading ad space for equity) are EXCLUDED <li>
        <li> Follow-on investments by the same investor(s) into a company are included as separate transactions as long as the investments fall in different months. Newer investments in the same month (for example, multiple investments via the public markets) are updated as part of the same transaction. <li>
    </ul>
</div>
<?php
}
else if($defpage == 1)
{
 ?>
 <div id="popup1" style="width:500px;display: none;" class="popup">

	<h3>For the purpose of this database: </h3>
        <ul class="def-list">
            <li> Only IPOs by companies in which PE/VC funds have invested more than 6 months before the IPO filing are INCLUDED  </li> 
        </ul>
</div>
<?php
}
else if($defpage ==2)
{
?>
    <div id="popup1" style="width:750px;" class="popup">
    <h3>For the purpose of this database:</h3>
    <ul class="def-list">
        <li>Exit deals involving investors in a company that has already been featured under PE/VC-backed IPOs (for that particular investor) are EXCLUDED </li>
    </ul>   
    <h3> Exits via M&A include the following types of deals: </h3>
    <ul class="def-list">
        <li> <b>Buyback:</b> Purchase of the PE/VC investors’ equity stakes by either the investee company or its founders/promoters. </li>
        <li><b>Strategic Sale:</b> Sale of the PE/VC investors’ equity stakes (or the entire investee company/project itself) to a third party company.  </li>
        <li><b>Secondary Sale:<li>  Purchase of the PE/VC investors’ equity stakes by another PE/VC investors.  </li>
        <li><b>Public Market Sale:<li>Sale of the PE/VC investors’ equity stakes (in a listed entity) through the public market. </li>
    </ul>
    </div>
<?php
}
else if($defpage == 3)
{
?>
    <div id="popup1" style="width:750px;" class="popup">
   
    <ul class="def-list">
        <li>Only transactions involving acquisition of 50% or higher stake are INCLUDED </li>
        <li>M&A that happen in India as a result of a foreign/global transaction (i.e. the merger of the Indian subsidiaries of foreign cos. which have been involved in a transaction overseas) are EXCLUDED </li>
        <li> Joint Venture (Greenfield Projects) deals are EXCLUDED </li>
        <li>  Follow-up transactions to the same M&A deal (i.e., Open Offers, additional share purchases) are EXCLUDED unless separated by a 12 month period.</li>
    </ul>
     </div>
<?php
}
?>
