<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 4.0                                                      |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997, 1998, 1999, 2000, 2001 The PHP Group             |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Adam Daniel <adaniel1@eesus.jnj.com>                        |
// |          Bertrand Mansion <bmansion@mamasam.com>                     |
// +----------------------------------------------------------------------+
//
// $Id: resource.php,v 1.2 2005/01/25 13:46:10 cgarcia Exp $

require_once("HTML/QuickForm/input.php");


/**
 * HTML class for a hidden type element
 * 
 * @author       Adam Daniel <adaniel1@eesus.jnj.com>
 * @author       Bertrand Mansion <bmansion@mamasam.com>
 * @version      1.0
 * @since        PHP4.04pl1
 * @access       public
 */
class HTML_QuickForm_resource extends HTML_QuickForm_input
{
    // {{{ constructor

    /**
     * Class constructor
     * 
     * @param     string    $elementName    (optional)Input field name attribute
     * @param     string    $value          (optional)Input field value
     * @param     mixed     $attributes     (optional)Either a typical HTML attribute string 
     *                                      or an associative array
     * @since     1.0
     * @access    public
     * @return    void
     */
    function HTML_QuickForm_resource($elementName=null, $elementLabel=null, $attributes=null)
    {
        HTML_QuickForm_input::HTML_QuickForm_input($elementName, $elementLabel, $attributes);
		$this->_persistantFreeze = true;
		$this->_type="text";
        $this->setValue($value);
    } //end constructor
        
    // }}}
    // {{{ freeze()

    /**
     * Freeze the element so that only its value is returned
     * 
     * @access    public
     * @return    void
     */
    /*function freeze()
    {
        return false;
    } *///end func freeze

    // }}}
    // {{{ accept()

   /**
    * Accepts a renderer
    *
    * @param object     An HTML_QuickForm_Renderer object
    * @access public
    * @return void 
    */
    /*function accept(&$renderer)
    {
        $renderer->renderHidden($this);
    } */// end func accept


/**
     * Returns the input field in HTML
     * 
     * @since     1.0
     * @access    public
     * @return    string
     */
    function toHtml()
    {
        if ($this->_flagFrozen) {
            return $this->getFrozenHtml();
        } else {
			$name=$this->getAttribute('name');
			$value=$this->getAttribute('value');
            $html="<SCRIPT language=javascript>\n".
				"	function popup(URL){\n".
				"		window.open('".ADMIN_DIR."'+URL, 'Resource', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=700,height=500');\n".
				"	}\n".
				"	function delete1Resource(elem,nameDiv){\n".
				"		divName = (arguments.length < 2) ? 'resource' : nameDiv;\n".
				"		if (elem.value != null && elem.value.length > 0) {\n".
				"			elem.value='';\n".
				"			obj = eval(\"document.getElementById('\"+divName+\"')\");\n".
				"			pos = obj.innerHTML.indexOf('-')+2;\n".
				"			ult = obj.innerHTML.lastIndexOf('-');\n".
				"			obj.innerHTML = obj.innerHTML.substr(pos,ult-pos);\n".
				"		}\n".
				"	}\n".
				"	function previewResource(id){\n".
				"		window.open('".ADMIN_DIR."resourcePreviewPage.php?rsr_ID='+id, 'Resource', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=300,height=300');\n".
				"	}\n".
				"</SCRIPT>\n";

			if(strlen($value) && $value != '0')
				$html.="<div id='div_$name' style='width=400px'>".
				"<a href=javascript:previewResource(".$value.")><img src='".ADMIN_IMG_DIR."preview.gif' border=0 align='middle'></a> - </a>".
				"<a href=javascript:popup('resourceSelectPage.php?selectField=$name');><img src='".ADMIN_IMG_DIR."assign.gif' border=0 align='absmiddle'></a>".
				" - <a href=javascript:delete1Resource(document.forms[0].".$name.",'div_".$name."')><img src='".ADMIN_IMG_DIR."delete.gif' border=0 align='absmiddle'></a>".
				"</div>\n";
			else
			$html.="<div id='div_$name'>".
				"<a href=\"javascript:popup('resourceSelectPage.php?selectField=$name');\"><img src='".ADMIN_IMG_DIR."assign.gif' border=0 align='absmiddle'></a>".
				"</div>\n";
			
			return $this->_getTabs() . '<input type="hidden" name="'.$name.'" value="'.$value.'"/>'.$html;
        }
    } //end func toHtml


    // }}}

	/**
     * Returns the value of field without HTML tags (in this case, value is changed to a mask)
     * 
     * @since     1.0
     * @access    public
     * @return    string
     */
    function getFrozenHtml()
    {
        $tabs = $this->_getTabs();
        $value = $this->getValue();
        if(strlen($value) && $value != "0") 
		{
			$html="<SCRIPT language=javascript>\n".
					"	function previewResource(id){\n".
					"		window.open('".ADMIN_DIR."resourcePreviewPage.php?rsr_ID='+id, 'Resource', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=300,height=300');\n".
					"	}\n".
					"</SCRIPT>\n";
			$html = $html."$tabs <a href=javascript:previewResource(".$value.")><img src='".ADMIN_IMG_DIR."preview.gif' border=0 align='middle'></a>\n";
		}
		if ($this->_persistantFreeze) {
            $html .= $tabs.'<input type="hidden" name="' . 
                $this->getName() . '" value="' . $value . '" />';
        }
        return $html;
    } //end func getFrozenHtml

} //end class HTML_QuickForm_hidden
?>
