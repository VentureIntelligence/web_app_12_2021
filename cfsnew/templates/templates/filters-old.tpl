
<h1>{if $smarty.session.totalResults}<span>{$smarty.session.totalResults}</span>{else}0{/if} Companies found</h1>


<div class="filter-selected">
{if count($REQUEST) gt 0 and count($fliters)}     
    <ul>
    {section name=List loop=$fliters}
      <li> <span>{$fliters[List].value}</span> <a  onclick="resetinput('{$fliters[List].field}','{$fliters[List].key}');"><img src="images/close-selected.gif" width="14" height="14" alt="" /></a></li> 
    {/section}
<!--<li> <span>Unlisted</span> <a href="javascript:;"><img src="images/close-selected.gif" width="14" height="14" alt="" /></a></li>-->

<li class="result-select-close"><a href="home.php">
                                             <img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
</ul>
  {/if}
  {if $pageName1  eq 'home.php' or  $pageName1  eq 'home1.php' or  $pageName1  eq 'homedev.php'}
  <div class="page-no"><span>Show </span>
    <select name="limit" onchange="this.form.submit();">
    <option value="all" {if $limit eq "all"}selected{/if}>All</option>
    <option value="10" {if $limit eq 10}selected{/if}>10</option>
    <option value="25" {if $limit eq 25}selected{/if}>25</option>
    <option value="50" {if $limit eq 50}selected{/if}>50</option>
</select>
</div>
{/if}
</div>