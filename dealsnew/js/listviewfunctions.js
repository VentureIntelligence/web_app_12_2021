/* List view ajax functions */

function drawNav(totalpages,currentpage)
{
    totalpages=parseInt(totalpages);
    currentpage=parseInt(currentpage);
    var pages = [];
    pages.push(1);
    pages.push(currentpage-2);
    pages.push(currentpage-1);
    pages.push(currentpage);
    pages.push(parseInt(currentpage)+1);
    pages.push(parseInt(currentpage)+2);
    pages.push(totalpages);
    pages=unique(pages);
    pages.sort(sortmyway);
    bar="";
    bar=bar+"<div class='paginate-wrapper' style='display: inline-block;'>";
    if(currentpage<2){
    bar=bar+'<a class="jp-previous jp-disabled" >&#8592; Previous</a>'; }
    else {
    bar=bar+'<a class="jp-previous" >&#8592; Previous</a>'; }    
    for(i=0;i<pages.length;i++)
    {
        if(pages[i] > 0 && pages[i] <= totalpages){
              bar=bar+'<a class="';
              if(pages[i]==currentpage)
                 bar=bar+'jp-current';
             else
                 bar=bar+'jp-page'; 
                bar=bar+'" >'+pages[i]+"</a>";
        }
    }
    if(currentpage<totalpages){
        bar=bar+'<a class="jp-next" >Next &#8594;</a>';
    } 
    else {
        bar=bar+'<a class="jp-next jp-disabled" >Next &#8594;</a>';
    }
    bar=bar+"</div>";
     $('.holder').html(bar);
}

/* Unique array */
function unique(list) {
    var result = [];
    $.each(list, function(i, e) {
        if ($.inArray(e, result) == -1) result.push(e);
    });
    return result;
}

/* sort numeric array */
function sortmyway(data_A, data_B)
{
    return (data_A - data_B);
}
