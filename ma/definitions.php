<?php

    require_once("../dbconnectvi.php");//including database connectivity file
    $Db = new dbInvestments();
    include ('machecklogin.php');
    ?>
 <div id="popup1" style="width:800px;display: none;" class="popup">
    <ul class="def-list">
        <li>Only transactions involving acquisition of 50% or higher stake are INCLUDED <li>
        <li>M&A that happen in India as a result of a foreign/global transaction (i.e. the merger of the Indian subsidiaries of foreign cos. which have been involved in a transaction overseas) are EXCLUDED <li>
        <li>Joint Venture (Greenfield Projects) deals are EXCLUDED <li>
        <li>Follow-up transactions to the same M&A deal (i.e., Open Offers, additional share purchases) are EXCLUDED unless separated by a 12 month period.<li>
    </ul>
</div>