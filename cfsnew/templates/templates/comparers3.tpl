{include file="header.tpl"}
<script type="text/javascript" src="{$SITE_PATH}js/common.js"></script>
<script type="text/javascript" src="{$SITE_PATH}js/compare.js"></script>
<!--<script type="text/javascript" src="{$SITE_PATH}js/jquery.js"></script>-->
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


{literal}
<script type="text/javascript" language="javascript1.2">
$j = jQuery.noConflict();

$j(document).ready(function(){
$j(".balancesheetminus").click(function(){
    $j(".balancesheet").slideToggle("slow");
	$j(".balancesheetminus").hide();
	$j(".balancesheetplus").show();
	
  });
});
$j(document).ready(function(){
$j(".balancesheetplus").click(function(){
    $j(".balancesheet").slideToggle("slow");
	$j(".balancesheetminus").show();
	$j(".balancesheetplus").hide();
	
  });
});

$j(document).ready(function(){
$j(".balancesheetminus1").click(function(){
    $j(".balancesheet1").slideToggle("slow");
	$j(".balancesheetminus1").hide();
	$j(".balancesheetplus1").show();
	
  });
});
$j(document).ready(function(){
$j(".balancesheetplus1").click(function(){
    $j(".balancesheet1").slideToggle("slow");
	$j(".balancesheetminus1").show();
	$j(".balancesheetplus1").hide();
	
  });
});

$j(document).ready(function(){
$j(".diagramsminus").click(function(){
    $j(".diagrams").slideToggle("slow");
	$j(".diagramsminus").hide();
	$j(".diagramsplus").show();
	
  });
});
$j(document).ready(function(){
$j(".diagramsplus").click(function(){
    $j(".diagrams").slideToggle("slow");
	$j(".diagramsminus").show();
	$j(".diagramsplus").hide();
	
  });
});
/*$j(document).ready(function(){
	$j(".ExportComparsion").click(function(){
		$j(".downloadExportComparsion").show();
	  });
});*/

	/*label1 = document.getElementById('req_answer[CompanyId]');
	label2 = document.getElementById('req_answer[PLStandard]');
	label1.setAttribute("class","error");
	label2.setAttribute("class","error");*/
	
function comaparepercen(pertype){
	if(pertype=='Percentage'){
		$j(".relativecal").show();
		$j(".absolutecal").hide();
	}else{
		$j(".relativecal").hide();
		$j(".absolutecal").show();
	}
}

$(function() {
    $( "#company1" ).autocomplete({
        source: "autosuggestjson.php",
        minLength: 2,
        select: function( event, ui ) {
          $('#comp_1').val(ui.item.id);
        }
    });
    $( "#company2" ).autocomplete({
        source: "autosuggestjson.php",
        minLength: 2,
        select: function( event, ui ) {
          $('#comp_2').val(ui.item.id);
        }
    });
    
     $( "#company3" ).autocomplete({
        source: "autosuggestjson.php",
        minLength: 2,
        select: function( event, ui ) {
           $('#comp_3').attr('disabled',false);
           $('#comp_3').val(ui.item.id);
        }
    });
    
    
});


function submitselect(value){
    
     $('#answerYear').val(value);
     document.forms['Frm_HmeSearch'].submit();
}
</script>
{/literal}

<div class="container ">
    <form name="Frm_HmeSearch" id="Frm_HmeSearch" action="comparers.php" method="post" class="custom"   enctype="multipart/form-data" >
    {if not $CompareResults}
    <div class="compare-companies compare-start" >
        <ul>
            <li><input name="company1" type="text" placeholder="Enter Company Name Here" id='company1'/></li>
            <li><input name="company2" type="text" placeholder="Enter Company Name Here" id='company2'/></li>
            <li><input name="save" type="submit" value="Compare"/></li>
            <input type="hidden" name="answer[CCompanies][]" id="comp_1">
            <input type="hidden" name="answer[CCompanies][]" id="comp_2">
            <input type="hidden" id="answerYear" name="answer[Year]" value="{$comparecompanyyear}"/>
        </ul>
    </div>
    {/if}
    
    {if $CompareResults}
        
    <div class="compare-companies">
        <ul  class="operations-list">
            <li><h4>OPERATIONS</h4></li>
            <li class="fontb">OPERTNAL INCOME</li>
            <li class="fontb">OTHER INCOME</li>
            <li>Ope,Ad&Other</li>
            <li>Operating Profit</li>
            <li class="fontb">EBITDA</li>
            <li>Interest</li>
            <li class="fontb">EBDT</li>
            <li>Depreciation</li>
            <li class="fontb">EBT</li>
            <li>Tax</li>
            <li class="fontb">PAT</li>
            <li>Total Income</li>
            <li>Basic INR</li>
            <li>Diluted INR</li>
        </ul>

        <div class="compare-scroll" style="">
            <div style=""> 
                {section name=List loop=$CompareResults}
                 <ul>
                 <li><h4>{$CompareResults[List].SCompanyName|truncate:100|lower|capitalize}</h4></li>
                 <li>{if $CompareResults[List].OptnlIncome eq 0}-{else}{$CompareResults[List].OptnlIncome|number_format:0:".":","}{/if}</li>
                 <li>{if $CompareResults[List].OtherIncome eq 0}-{else}{$CompareResults[List].OtherIncome|number_format:0:".":","}{/if}</li>
                 <li>{if $CompareResults[List].OptnlAdminandOthrExp eq 0}-{else}{$CompareResults[List].OptnlAdminandOthrExp|number_format:0:".":","}{/if}</li>
                 <li>{if $CompareResults[List].OptnlProfit eq 0}-{else}{$CompareResults[List].OptnlProfit|number_format:0:".":","}{/if}</li>
                 <li>{if $CompareResults[List].EBITDA eq 0}-{else}{$CompareResults[List].EBITDA|number_format:0:".":","}{/if}</li>
                 <li>{if $CompareResults[List].Interest eq 0}-{else}{$CompareResults[List].Interest|number_format:0:".":","}{/if}</li>
                 <li>{if $CompareResults[List].EBDT eq 0}-{else}{$CompareResults[List].EBDT|number_format:0:".":","}{/if}</li>
                 <li>{if $CompareResults[List].Depreciation eq 0}-{else}{$CompareResults[List].Depreciation|number_format:0:".":","}{/if}</li>
                 <li>{if $CompareResults[List].EBT eq 0}-{else}{$CompareResults[List].EBT|number_format:0:".":","}{/if}</li>
                 <li>{if $CompareResults[List].Tax eq 0}-{else}{$CompareResults[List].Tax|number_format:0:".":","}{/if}</li>
                 <li>{if $CompareResults[List].PAT eq 0}-{else}{$CompareResults[List].PAT|number_format:0:".":","}{/if}</li>
                 <li>{if $CompareResults[List].TotalIncome eq 0}-{else}{$CompareResults[List].TotalIncome|number_format:0:".":","}{/if}</li>
                 <li>{if $CompareResults[List].BINR eq 0}-{else}{$CompareResults[List].BINR|number_format:0:".":","}{/if}</li>
                 <li>{if $CompareResults[List].DINR eq 0}-{else}{$CompareResults[List].DINR|number_format:0:".":","}{/if}</li>
                 </ul>
                 {/section}

                            
                
                 {section name=List loop=$CompareMean}
                     <ul class="compare-list absolutecal" id='absolutecal' {if CompareType neq 0} style="display:none;"{/if}>
                        <li><h4>{$SCompanyName1[List.index_next]}(-){$SCompanyName1[0]}</h4></li>
                        {section name=List1 loop=$CompareMean[List]}
                           <li>{if $CompareMean[List][List1] eq 0}-{else}{$CompareMean[List][List1]|number_format:2:".":","}{/if}</li>
                        {/section}
                    </ul>
                 {/section}

                                 
                 {section name=List loop=$RealtiveCompareMean}
                 <ul class="compare-list relativecal" id='relativecal' {if CompareType neq 1} style="display:none;"{/if}>
                 <li><h4>{$SCompanyName1[List.index_next]}(%){$SCompanyName1[0]}</h4></li>
                 {section name=List1 loop=$RealtiveCompareMean[List]}
                    <li>{if $RealtiveCompareMean[List][List1] eq 0}-{else}{$RealtiveCompareMean[List][List1]|number_format:2:".":","}{/if} %</li>
                 {/section}
                 </ul>
                 {/section}

          </div>
    </div>
    
                 {section name=List loop=$comparecompany}
                    <input type="hidden" id="answer[CCompanies][]" name="answer[CCompanies][]" value="{$comparecompany[List]}"/>
                {/section}
                <input type="hidden" id="answerYear" name="answer[Year]" value="{$comparecompanyyear}"/>
                 <input type="hidden" name="answer[CCompanies][]" id="comp_3" disabled>
            
    

    <ul class="compare-new"> 
    <li id="add-company-btn"> <input name="" type="button" value="ADD COMPANY" id="add-company" /></li> 
    <li id="compare-btn" style="display:none"> <input name="company3" id="company3" type="text" placeholder="Enter Company Name here" /> <br />
     <input name="compare" type="submit" value="Compare" id="compare" /></li> 
    </ul> 
    </div>
    

    {if $CompareResults}
    <div class="chart-cnt">
    <h3><span>[+]</span>  VIEW CHART</h3>
        
        <div class="show-chart">
            <!-- Chart Part Starts -->
            {php}include "piechartphpgoogle.php"{/php}
		<div style="clear:both;">&nbsp;</div>
            {include file='chart/comparechart.tpl'}
        <!-- Chart Parts Ends -->
            <div id="optnlIncome"></div>
            <div id="EBITDA"></div>
            <div id="PAT"></div>
        </div>
    </div>
    </form>
    {/if}
    
    <form name="Frm_Compare" id="Frm_Compare" action="comparers.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="exportenable" id="exportenable" value="0"/>
            {section name=List loop=$CompareResults}
                    <input type="hidden" id="answer[CCompanies][]" name="answer[CCompanies][]" value="{$comparecompany[List]}"/>
            {/section}
            <input type="hidden" id="answer[Year]" name="answer[Year]" value="{$comparecompanyyear}"/>
            <div class="btn-cnt p10"><input name="exportcompare" id="exportcompare" type="submit" value="EXPORT" /></div>
    </form>
    
    
    {/if}
</div>


{literal}
<script type="text/javascript">

$("#compare-btn").hide();  

$("#add-company").click(function () {
$("#add-company-btn").hide();  
$("#compare-btn").show(); 
});

$("#compare").click(function () {
$("#add-company-btn").show();  
$("#compare-btn").hide(); 
});

$(".show-chart").hide(); 
$(".chart-cnt h3").click(function () {
    $(this).next(".show-chart").slideToggle("fast");
    var text = $(this).find('span').text();
    $(this).find('span').text(text == " [-] " ? " [+] " : " [-] ");
});
 

</script>

 <script src="http://foundation.zurb.com/docs/assets/docs.js"></script>
<script>
  $(document)

    .foundation();


</script>
{/literal}

</body>
</html>
