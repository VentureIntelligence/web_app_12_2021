
{assign var="putDots" value=3}
{assign var="border" value=2}
{assign var="firstpage" value=1}
{assign var="curPage" value=$curPage}
{assign var="url" value="home.php?page=%x"}
{assign var="totalPages" value=0}

{math 
  assign="totalPages"
  equation="totalrecords/limit"
  totalrecords=$totalrecord
  limit=$limit
}
{assign var="previous" value=0}
{assign var="nextpage" value=0}
{math 
  assign="previous"
  equation="curPage-1"
  curPage=$curPage
}
{math 
  assign="nextpage"
  equation="curPage+1"
  curPage=$curPage
}
<div class="pagination-main">


{$paginationdiv}

</div>






