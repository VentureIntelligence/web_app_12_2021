{include file="header.tpl"}
<script type="text/javascript" src="{$SITE_PATH}js/common.js"></script>
<script type="text/javascript" src="{$SITE_PATH}js/compare.js"></script>
<!--<script type="text/javascript" src="{$SITE_PATH}js/jquery.js"></script>-->

{literal}<script src="http://foundation.zurb.com/docs/assets/vendor/custom.modernizr.js"></script>{/literal}

{literal}
<script type="text/javascript" language="javascript1.2">
$(document).ready(function(){
$(".relSpace").hide();
$(".balancesheetminus").click(function(){
    $(".balancesheet").slideToggle("slow");
	$(".balancesheetminus").hide();
	$(".balancesheetplus").show();
	
  });
});
$(document).ready(function(){
$(".balancesheetplus").click(function(){
    $(".balancesheet").slideToggle("slow");
	$(".balancesheetminus").show();
	$(".balancesheetplus").hide();
	
  });
});

$(document).ready(function(){
$(".balancesheetminus1").click(function(){
    $(".balancesheet1").slideToggle("slow");
	$(".balancesheetminus1").hide();
	$(".balancesheetplus1").show();
	
  });
});
$(document).ready(function(){
$(".balancesheetplus1").click(function(){
    $(".balancesheet1").slideToggle("slow");
	$(".balancesheetminus1").show();
	$(".balancesheetplus1").hide();
	
  });
});

$(document).ready(function(){
$(".diagramsminus").click(function(){
    $(".diagrams").slideToggle("slow");
	$(".diagramsminus").hide();
	$(".diagramsplus").show();
	
  });
});
$(document).ready(function(){
$(".diagramsplus").click(function(){
    $(".diagrams").slideToggle("slow");
	$(".diagramsminus").show();
	$(".diagramsplus").hide();
	
  });
});
/*$(document).ready(function(){
	$(".ExportComparsion").click(function(){
		$(".downloadExportComparsion").show();
	  });
});*/

	/*label1 = document.getElementById('req_answer[CompanyId]');
	label2 = document.getElementById('req_answer[PLStandard]');
	label1.setAttribute("class","error");
	label2.setAttribute("class","error");*/
	
function comaparepercen(pertype){
	if(pertype=='Percentage'){
                $(".relSpace").show();
		$(".relativecal").show();
		$(".absolutecal").hide();
	}else{
                $(".relSpace").hide();
		$(".relativecal").hide();
		$(".absolutecal").show();
	}
}

$(function() {
    
    $( "#company1" ).autocomplete({
        source: "autosuggestjson.php",
        minLength: 2,
        select: function( event, ui ) {
          $('#comp_1').val(ui.item.id);
          $('#compname_1').val(ui.item.value);
        }
    });
    $( "#company2" ).autocomplete({
        source: "autosuggestjson.php",
        minLength: 2,
        select: function( event, ui ) {
          $('#comp_2').val(ui.item.id);
          $('#compname_2').val(ui.item.value);
        }
    });
    
     $( "#company3" ).autocomplete({
        source: "autosuggestjson.php",
        minLength: 2,
        select: function( event, ui ) {
           $('#comp_3').attr('disabled',false);
           $('#compname_3').attr('disabled',false);
           $('#comp_3').val(ui.item.id);
           $('#compname_3').val(ui.item.value);
        }
    });
     $(".resetcompany").click(function(){
         id=$(this).attr('id');
         $('#resetcompany').val(id);
         $('#Frm_HmeSearch').submit();
     });
    
});


function submitselect(value){
    
     $('#answerYear').val(value);
     company1=$('#company1').val();
     company2=$('#company2').val();
     if(company1!="" &&  company2!=""){
     document.forms['Frm_HmeSearch'].submit();
     }
}
function validate()
{
    if($("#comp_1").val()!="" && $("#comp_2").val()!="")
    {
         document.forms['Frm_HmeSearch'].submit();
        return true;
    }
    else
    {
        alert("Specify two Company Names to Compare !!");
        return false;
    }
     return false;
}
</script>
{/literal}
 
<div class="container ">
   
    {if not $comparecompany}
    <div class="compare-companies compare-start" >
        <ul>
            <li><input name="company1" type="text" placeholder="Enter Company Name Here" id='company1'/></li>
            <li><input name="company2" type="text" placeholder="Enter Company Name Here" id='company2'/></li>
            <li><input name="save" type="button" value="Compare" onclick="return validate();"/></li>
            <input type="hidden" name="answer[CCompanies][]" id="comp_1">
            <input type="hidden" name="answer[CCompanies][]" id="comp_2">
            <input type="hidden" name="answer[CCompanynames][]" id="compname_1">
            <input type="hidden" name="answer[CCompanynames][]" id="compname_2">
            <input type="hidden" name="resetcompany" id="resetcompany">
            <input type="hidden" id="answerYear" name="answer[Year]" value="{$comparecompanyyear}"/>
            
        </ul>
    </div>
    {/if}
    
    {if $comparecompany}
      <p style="padding:0.5% 1%; text-align: right;color: #A37635;">All figures are in INR Crore, unless otherwise specified</p>   
    <div class="compare-companies">
        <ul  class="operations-list">
            <li><h4>OPERATIONS</h4></li>
            <li class="relSpace">&nbsp;</li>
            <li class="fontb">OPERTNAL INCOME</li>
            <li class="fontb">OTHER INCOME</li>
            <li>Total Income</li>
            <li><span  data-tooltip="" title="Operating,Admministrative & Other Expenses">Ope,Ad&Other</span></li>
            <li>Operating Profit</li>
            <li class="fontb">EBITDA</li>
            <li>Interest</li>
            <li class="fontb">EBDT</li>
            <li>Depreciation</li>
            <li class="fontb">EBT</li>
            <li>Tax</li>
            <li class="fontb">PAT</li> 
            
            <li>Basic INR</li>
            <li>Diluted INR</li>
        </ul>

        <div class="compare-scroll" style="">
            <div style="">{section name=List loop=$CompareResults}<ul><li><h4>{$CompareResults[List].SCompanyName|truncate:100|lower|capitalize}{if count($comparecompany) gt 2}<span class="resetcompany" style="float: right; top: 0px; position: absolute; right: 0px; font-size: 16px; padding: 5px; margin: 0px; background: #999;cursor: pointer;" id="{$CompareResults[List].CId_FK}"><img width="7" height="7" border="0" src="images/icon-close-ul.png" alt=""></span>{/if}</h4></li>
                {* <li>{if $CompareResults[List].OptnlIncome eq 0}-{else}{$CompareResults[List].OptnlIncome}{/if}</li>
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
                 <li>{if $CompareResults[List].DINR eq 0}-{else}{$CompareResults[List].DINR|number_format:0:".":","}{/if}</li>*}
                <li class="relSpace">&nbsp;</li>
                <li>{if $CompareResults[List].OptnlIncome eq 0}-{else}{math  equation="comresult/crores" comresult=$CompareResults[List].OptnlIncome crores=10000000}{/if}</li>
                 <li>{if $CompareResults[List].OtherIncome eq 0}-{else}{math equation="comresult/crores" comresult=$CompareResults[List].OtherIncome crores=10000000}{/if}</li>
                 <li>{if $CompareResults[List].TotalIncome eq 0}-{else}{math equation="comresult/crores" comresult=$CompareResults[List].TotalIncome crores=10000000}{/if}</li>
                 <li>{if $CompareResults[List].OptnlAdminandOthrExp eq 0}-{else}{math equation="comresult/crores" comresult=$CompareResults[List].OptnlAdminandOthrExp crores=10000000}{/if}</li>
                 <li>{if $CompareResults[List].OptnlProfit eq 0}-{else}{math equation="comresult/crores" comresult=$CompareResults[List].OptnlProfit crores=10000000}{/if}</li>
                 <li>{if $CompareResults[List].EBITDA eq 0}-{else}{math equation="comresult/crores" comresult=$CompareResults[List].EBITDA crores=10000000}{/if}</li>
                 <li>{if $CompareResults[List].Interest eq 0}-{else}{math equation="comresult/crores" comresult=$CompareResults[List].Interest crores=10000000}{/if}</li>
                 <li>{if $CompareResults[List].EBDT eq 0}-{else}{math equation="comresult/crores" comresult=$CompareResults[List].EBDT crores=10000000}{/if}</li>
                 <li>{if $CompareResults[List].Depreciation eq 0}-{else}{math equation="comresult/crores" comresult=$CompareResults[List].Depreciation crores=10000000}{/if}</li>
                 <li>{if $CompareResults[List].EBT eq 0}-{else}{math equation="comresult/crores" comresult=$CompareResults[List].EBT crores=10000000}{/if}</li>
                 <li>{if $CompareResults[List].Tax eq 0}-{else}{math equation="comresult/crores" comresult=$CompareResults[List].Tax crores=10000000}{/if}</li>
                 <li>{if $CompareResults[List].PAT eq 0}-{else}{math equation="comresult/crores" comresult=$CompareResults[List].PAT crores=10000000}{/if}</li>
                 
                 <li>{if $CompareResults[List].BINR eq 0}-{else}{$CompareResults[List].BINR}{/if}</li>
                 <li>{if $CompareResults[List].DINR eq 0}-{else}{$CompareResults[List].DINR}{/if}</li>
                 </ul>{/section}{section name=List loop=$unavailcomp}<ul><li><h4>{$unavailcomp[List]}{if count($comparecompany) gt 2}<span class="resetcompany" style="float: right; top: 0px; position: absolute; right: 0px; font-size: 16px; padding: 5px; margin: 0px; background: #999;cursor: pointer;" id="{$unavailid[List]}"><img width="7" height="7" border="0" src="images/icon-close-ul.png" alt=""></span>{/if}</h4></li>
                 <li>No Data Available</li>
                 <li>-</li>
                 <li>-</li>
                 <li>-</li>
                 <li>-</li>
                 <li>-</li>
                 <li>-</li>
                 <li>-</li>
                 <li>-</li>
                 <li>-</li>
                 <li>-</li>
                 <li>-</li>
                 <li>-</li>
                <li>-</li>
                </ul>{/section}{section name=List loop=$CompareMean}<ul class="compare-list absolutecal" id='absolutecal' {if CompareType neq 0} style="display:none;"{/if}>
                <li><h4>{$SCompanyName1[List.index_next]}/{$SCompanyName1[0]} (-)</h4></li>
                <li class="relSpace">&nbsp;</li>
                {section name=List1 loop=$CompareMean[List]}
                <li>{if $CompareMean[List][List1] eq 0}-{else} {if $smarty.section.List1.index eq 12 or $smarty.section.List1.index eq 13} {$CompareMean[List][List1]} {else} {math equation="comresult/crores" comresult=$CompareMean[List][List1] crores=10000000}{/if}{/if} </li>
                {/section}</ul>{/section}
                {section name=List loop=$RealtiveCompareMean}<ul class="compare-list relativecal" id='relativecal' {if CompareType neq 1} style="display:none;"{/if}>
                 <li class="lo"><h4 class="frh">{$SCompanyName1[List.index_next]}/{$SCompanyName1[0]}</h4></li>
                 
                <!-- <li>
                     <table>
                         
                         <tr>
                             <td>Multiple(x)</td>
                             <td>|</td>
                             <td>Percentage (%)</td>
                         </tr>
                         {section name=List1 loop=$RealtiveCompareMean[List]}
                         <tr>
                             <td>{if $RealtiveCompareMean[List][List1] eq 0}-{else}{$RealtiveCompareMean[List][List1]|number_format:2:".":","}(x){/if}</td>
                             <td>|</td>
                             <td>{if $RelativeCompareMeanper[List][List1] eq 0}-{else}{$RelativeCompareMeanper[List][List1]|number_format:0:".":","}%{/if}</td>
                         </tr>
                         {/section}
                     </table>
                 </li>-->
                         
                         <li class="relSpace"><div class="main-cn"><div class="lfhead-cn">Multiple(x)</div><div class="rghead-cn">Percentage (%)</div></div></li>
                 {section name=List1 loop=$RealtiveCompareMean[List]}
                 
                 <li><div class="main-cn"><div class="lf-cn">{if $RealtiveCompareMean[List][List1] eq 0}-{else}{$RealtiveCompareMean[List][List1]|number_format:2:".":","}(x){/if} </div>
                         <div class="rg-cn">{if $RelativeCompareMeanper[List][List1] eq 0}-{else}{$RelativeCompareMeanper[List][List1]|number_format:0:".":","}%{/if}</div></div> </li>
                 
                 {/section}
                 
                 
                 
                 </ul>
                 {/section}</div>
                 
                 
    </div>
        
                {section name=List loop=$comparecompany}
                    <input type="hidden" id="answer[CCompanies][]" name="answer[CCompanies][]" value="{$comparecompany[List]}"/>
                {/section}
                {section name=List loop=$comparecompanyname}
                    <input type="hidden" id="answer[CCompanynames][]" name="answer[CCompanynames][]" value="{$comparecompanyname[List]}"/>
                {/section}
                <input type="hidden" name="resetcompany" id="resetcompany">
                <input type="hidden" id="answerYear" name="answer[Year]" value="{$comparecompanyyear}"/>
                <input type="hidden" name="answer[CCompanies][]" id="comp_3" disabled>
                <input type="hidden" name="answer[CCompanynames][]" id="compname_3" disabled>
 
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
    
    {/if}
    </form>
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

{/literal}

</body>
</html>
