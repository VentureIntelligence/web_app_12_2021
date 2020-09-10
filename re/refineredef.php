<?php
if($defpage == 0)
{
?>
 <div id="popup3" style="width:800px;display: none;" class="popup">

    <ul class="def-list">
        <li><b>Foreign :</b> PE/VC firms that do not have a dedicated fund for India. (eg. Carlyle) <li>
        <li><b>Indian :</b> PE/VC firms that invest out of a India-dedicated fund. (eg. Sequoia Capital India)<li>
        <li><b>Co-investments : </b>Investments which involve both foreign funds and India-dedicated funds<li>
    </ul>
</div>
<?php 
}
if($defpage ==2 || $defpage ==3)
{
    ?>
<div id="popup2" style="width:800px;display: none;" class="popup">

    <h3>Buyback:</h3>
    <ul class="def-list">
        <li>Purchase of the PE/VC investors’ equity stakes by either the investee company or its founders/promoters.<li>
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