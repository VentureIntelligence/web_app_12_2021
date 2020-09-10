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
// $Id: mresource.php,v 1.12 2005/07/14 11:40:30 jgil Exp $

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
class HTML_QuickForm_mresource extends HTML_QuickForm_input
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

    var $_options = array();

    function HTML_QuickForm_mresource($elementName=null, $elementLabel=null, $options=null)
    {
        HTML_QuickForm_input::HTML_QuickForm_input($elementName, $elementLabel, $options);
        $this->_persistantFreeze = true;
        $this->_type="text";
        $this->setValue($value);
        $this->_options = $options;
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
                "    function popup(URL){\n".
                "        window.open('".ADMIN_DIR."'+URL, 'Resource', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=700,height=500');\n".
                "    }\n".
                "    function deleteResource(n,nameDiv){\n".
                "        obj = eval(\"document.getElementById('\"+nameDiv+\"')\");\n".
                "        obj.innerHTML = ''\n".
                "        pos = orderFind(n)\n".
                "        for (i=pos;i<ordre.length;i++) {".
                "            if (i+1 != ordre.length) {ordre[i]=ordre[i+1];divs[i]=divs[i+1];eval(\"document.forms[0].order_\"+ordre[i]+\".value=document.forms[0].order_\"+ordre[i+1]+\".value\");}\n".
                "            else { ordre[i]=''; ordre.length--; divs[i]=''; divs.length--}\n".
                "        }\n".
                "        nresources--;\n".
                "    }\n".
                "    function orderFind(num){\n".
                "        for (j=0;j<ordre.length;j++)\n".
                "            if (ordre[j]==num) return j;\n".
                "        return -1\n".
                "        }\n".
                "    function goUp(n){\n".
                "        o=orderFind(n);\n".
                "        if (o>0) {\n".
                "            aux = ordre[o-1];\n".
                "            ordre[o-1] = ordre[o];\n".
                "            eval(\"document.forms[0].order_\"+aux+\".value = o;\");\n".
                "            ordre[o] = aux;\n".
                "            eval(\"document.forms[0].order_\"+n+\".value = (o-1)\");\n".
                "            aux = divs[o-1];\n".
                "            divs[o-1] = divs[o];\n".
                "            divs[o] = aux;\n".
                "            reOrder();\n".
                "        }\n".
                "    }\n".
                "    function goDown(n){\n".
                "        o=orderFind(n);\n".
                "        if (o<(ordre.length-1)) {\n".
                "            aux = ordre[o+1];\n".
                "            ordre[o+1] = ordre[o];\n".
                "            eval(\"document.forms[0].order_\"+aux+\".value = o;\");\n".
                "            ordre[o] = aux;\n".
                "            eval(\"document.forms[0].order_\"+n+\".value = (o+1)\");\n".
                "            aux = divs[o+1];\n".
                "            divs[o+1] = divs[o];\n".
                "            divs[o] = aux;\n".
                "            reOrder();\n".
                "        }\n".
                "    }\n".
                // Reescriu la capa de recursos ordenada.
                "    function reOrder(){\n".
                "        capa = \"\";\n".
                "        for (o=0;o<divs.length;o++) {\n".
                "            capa += divs[o];\n".
                "        }\n".
                "        document.getElementById('div_$name').innerHTML=\"Añadir recurso: <a href=\\\"javascript:popup('mresourceSelectPage.php?selectMult=$name&selectField='+nresources);\\\"><img src='".ADMIN_IMG_DIR."assign.gif' border=0 align='absmiddle'></a>"."<br>\" + capa;\n".
                "    }\n".
                "    function previewResource(id){\n".
                "        window.open('".ADMIN_DIR."resourcePreviewPage.php?rsr_ID='+id, 'Resource', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=300,height=300');\n".
                "    }\n".
                "</SCRIPT>\n".

                "\n<script>\n".
                "nresources = ".count($this->_options)."\n".
                "incres = ".count($this->_options)."\n".
                "ordre = new Array()\n".
                "divs = new Array()\n".
                "</script>\n";
            $html.= "<div id='div_$name'>".
            // Num. de recursos ja associats
            // Butó per associar nous recursos
            "Añadir recurso: <a href=\"javascript:popup('mresourceSelectPage.php?selectMult=$name&selectField='+nresources);\"><img src='".ADMIN_IMG_DIR."assign.gif' border=0 align='absmiddle'></a>";
            $cont = 0;
            // Afegim els recursos
            foreach ($this->_options as $option) {
                $htmldiv = "<div id='div_".$cont."' style='width=400px'>".
                " <a href=javascript:previewResource(".$option[0].")><img src='".ADMIN_IMG_DIR."preview.gif' alt='".$option[1]."' border=0 align='middle'></a> - ".
                //" <a href=javascript:goUp(".$cont.")><img src='".ADMIN_IMG_DIR."order_up.gif' border=0 align='middle'></a>".
                //" <a href=javascript:goDown(".$cont.")><img src='".ADMIN_IMG_DIR."order_down.gif' border=0 align='middle'></a> - ".
                " <a href=javascript:deleteResource($cont,'div_".$cont."')><img src='".ADMIN_IMG_DIR."delete.gif' border=0 align='absmiddle'></a>".
                "&nbsp;&nbsp; - ".$option[1]."".
                " <input type='hidden' id='resource_".$cont."' name='resource_".$cont."' value='".$option[0]."'>".
                " <input type='hidden' id='order_".$cont."' name='order_".$cont."' value='".$cont."'>".
                "</div>";
                $html = $html.$htmldiv."<script>ordre[".$cont."]=".$cont.";divs[".$cont."]=\"".$htmldiv."\";</script>\n";
                $cont++;
            }
            $html.=    "</div>\n";

            return $this->_getTabs() . $html;
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
        $nr = new NoticiasResource();
        if (strlen($_REQUEST["not_ID"]))
            $ID = $_REQUEST["not_ID"];
        else{
            $n = new Noticias();
            $ID = $n->getMaxID();
        }


        $recursos = $nr->getSelect($ID);

        $tabs = $this->_getTabs();
//        $value = $this->getValue();
        //if(strlen($value) && $value != "0")
        //{
            $html="<SCRIPT language=javascript>\n".
                    "    function previewResource(id){\n".
                    "        window.open('".ADMIN_DIR."resourcePreviewPage.php?rsr_ID='+id, 'Resource', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=300,height=300');\n".
                    "    }\n".
                    "</SCRIPT>\n";
            foreach($recursos as $r)
            {
                $html.= "<a href=javascript:previewResource(".$r[0].")><img src='".ADMIN_IMG_DIR."preview.gif' border=0 align='middle'></a> ".$r[1]."<br>\n";
            }
            $html = $html.$tabs;
        //}
        if ($this->_persistantFreeze) {
            $html .= $tabs.'<input type="hidden" name="' .
                $this->getName() . '" value="' . $value . '" />';
        }
        return $html;

    } //end func getFrozenHtml

} //end class HTML_QuickForm_hidden
?>