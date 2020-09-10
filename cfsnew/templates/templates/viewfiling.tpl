{include file="header.tpl"}
{include file="leftpanel.tpl"}
<div class="container-right">

{include file="filters.tpl"}

<div class="list-tab">
<ul>
    <li><a class="postlink" href="home.php"><i></i> LIST VIEW</a></li>
<li><a   href="details.php?vcid={$VCID}" class="active postlink"><i class="i-detail-view"></i> DETAIL VIEW</a></li>
</ul>
</div>

<div class="companies-details">
<div class="detailed-title-links"> <h2>{$companyName}</h2> <!--<a class="previous" href="javascript:;">Previous</a> <a class="next" href="javascript:;">Next</a> --><br></div>


<div class="filing-cnt">

<div class="title-table"><h3>FILINGS</h3> <a href="details.php?vcid={$backcid}" class="postlink">Back to details</a></div>

 

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<!--tHead> <tr>
<!--th><input name="" type="checkbox" value="" /></th>
    <th>File Name </th>
<th> Date</th>
<th>  </th> 
</tr></thead-->
<tbody>  
    {section name=customer loop=$searchResults}
          
       <tr> 
        <td>{$searchResults[customer].name}  </td>
      
  </tr>
    {/section}
</tbody>
  </table>
  
 </div>
</div>

</div>

{literal}
<script type="text/javascript">


function check(newLink)
{
	location.href= newLink; //document.getElementById("google-link").value; //  "http://www.yahoo.com/";
	return false;	// so important
}
</script>


    
{/literal}