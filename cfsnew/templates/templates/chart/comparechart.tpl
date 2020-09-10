{if $TotalIncomeNegative}
	<div>
	<img style="margin-left:55px;" src="http://chart.apis.google.com/chart?chxt=y&
	&chtt=Revenue
	&cht=bvs
	&chd=t:{section name=List loop=$CompareResults}{$CompareResults[List].TotalIncome}{if $smarty.section.List.last}{else},{/if}{/section}
	&chs=650x150
	&chds=a
	&chl={section name=List loop=$CompareResults}{$CompareResults[List].Ident}{if $smarty.section.List.last}{else}|{/if}{/section}
	&chdl={section name=List loop=$CompareResults}{$CompareResults[List].SCompanyName}{if $smarty.section.List.last}{else}|{/if}{/section}
	&chco=3366CC|DC3912|FF9900|109618
	" />
	</div>
{/if}	
{if $EBITDAIncomeNegative}
	<div>
	<img style="margin-left:55px;" src="http://chart.apis.google.com/chart?chxt=y&
	&chtt=EBITDA
	&cht=bvs
	&chd=t:{section name=List loop=$CompareResults}{$CompareResults[List].EBITDA}{if $smarty.section.List.last}{else},{/if}{/section}
	&chs=650x150
	&chds=a
	&chl={section name=List loop=$CompareResults}{$CompareResults[List].Ident}{if $smarty.section.List.last}{else}|{/if}{/section}
	&chdl={section name=List loop=$CompareResults}{$CompareResults[List].SCompanyName}{if $smarty.section.List.last}{else}|{/if}{/section}
	&chco=3366CC|DC3912|FF9900|109618
	" />
	</div>
{/if}

{if $PATIncomeNegative}
	<div>
	<img style="margin-left:55px;" src="http://chart.apis.google.com/chart?chxt=y&
	&chtt=PAT
	&cht=bvs
	&chd=t:{section name=List loop=$CompareResults}{$CompareResults[List].PAT}{if $smarty.section.List.last}{else},{/if}{/section}
	&chs=650x150
	&chds=a
	&chl={section name=List loop=$CompareResults}{$CompareResults[List].Ident}{if $smarty.section.List.last}{else}|{/if}{/section}
	&chdl={section name=List loop=$CompareResults}{$CompareResults[List].SCompanyName}{if $smarty.section.List.last}{else}|{/if}{/section}
	&chco=3366CC|DC3912|FF9900|109618
	" />
	</div>
{/if}