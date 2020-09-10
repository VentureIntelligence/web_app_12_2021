<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Author:  Bertrand Mansion <bmansion@mamasam.com>                     |
// +----------------------------------------------------------------------+
//
// $Id: userprofilescope.php,v 1.1.1.1 2005/01/17 07:43:59 rsalvado Exp $

require_once('HTML/QuickForm/group.php');
require_once('HTML/QuickForm/select.php');
require_once('HTML/QuickForm/html.php');

/**
 * Class to dynamically create two HTML Select elements
 * The first select changes the content of the second select.
 * This element is considered as a group. Selects will be named
 * groupName[0], groupName[1].
 *
 * Ex:
 * $form->setDefaults(array('test' => array('4','15')));
 * $sel =& $form->addElement('hierselect', 'test', 'Test:', null, '/');
 * $mainOptions = $db->getAssoc('select pkparent, par_desc from parent');
 * $sel->setMainOptions($mainOptions);
 *
 * $result = $db->query("select fk_parent, pkchild, chi_desc from child");
 * while ($result->fetchInto($row)) {
 *     $secOptions[$row[0]][$row[1]] = $row[2];
 * }
 * $sel->setSecOptions($secOptions);
 *
 * @author       Bertrand Mansion <bmansion@mamasam.com>
 */
class HTML_QuickForm_userprofilescope extends HTML_QuickForm_group
{   
    // {{{ properties

    /**
     * Options for the second select element
     *
     * Format is a bit more complex as we need to know which options
     * are related to the ones in the first select:
     *
     * array[mainOption value][secOption value] = secOption text.
     * Ex:
     * $main[0] = 'Pop';
     * $main[1] = 'Classical';
     * $main[2] = 'Funeral doom';
     *
     * $sec[0][1] = 'Red Hot Chili Peppers';
     * $sec[0][2] = 'The Pixies';
     * $sec[1][3] = 'Wagner';
     * $sec[1][4] = 'Strauss';
     * $sec[2][5] = 'Pantheist';
     * $sec[2][6] = 'Skepticism';
     *
     * @var       array
     * @access    private
     */
    var $_secOptions = array();

    /**
     * The javascript used to set and change the options
     * @var       string
     * @access    private
     */
    var $_js = "<script type=\"text/javascript\">\n";

    // }}}
    // {{{ constructor

    /**
     * Class constructor
     * 
     * @param     string    $elementName    (optional)Input field name attribute
     * @param     string    $elementLabel   (optional)Input field label in form
     * @param     mixed     $attributes     (optional)Either a typical HTML attribute string 
     *                                      or an associative array. Date format is passed along the attributes.
     * @access    public
     * @return    void
     */
    function HTML_QuickForm_userprofilescope($elementName=null, $elementLabel=null, $attributes=null, $separator=null)
    {
        $this->HTML_QuickForm_element($elementName, $elementLabel, $attributes);
        $this->_persistantFreeze = true;
        if (isset($separator)) {
            $this->_separator = $separator;
        }
        $this->_type = 'userprofilescope';
        $this->_appendName = true;
    } //end constructor

    // }}}
    // {{{ setMainOptions()

    /**
     * Sets the options for the first select
     * Format is standard key/value pairs for select elements.
     *
     * @param     array    $options    Array of options for the first select
     * @access    public
     * @return    void
     */
    function setMainOptions($options)
    {
        if (empty($this->_elements)) {
            $this->_createElements();
        }
        $select1 =& $this->_elements[0];
        $select1->loadArray($options);
    } // end func setMainOptions

    // }}}
    // {{{ setSecOptions()

    /**
     * Sets the options for the second select
     * 
     * @param     array    $options    Array of options for the second select
     * @access    public
     * @return    void
     */
    function setSecOptions($options)
    {
        if (empty($this->_elements)) {
            $this->_createElements();
        }
		foreach ($options as $key=>$array)
		{
			foreach ($array as $key2=>$value)
				$options[$key][$key2]=addslashes($value);
			
		}
        $this->_secOptions = $options;
        $elValue = $this->getValue();
		if (is_array($elValue)) {
            $curKey = isset($options[$elValue[0]]) ? $elValue[0] : key($options);
        } else {
            $curKey = key($options);
        }
		$options1 = $this->_elements[0]->_options;
		for($i=0;$i<count($options1);$i++) {
			$varName = $this->getName()."_".$options1[$i]["attr"]["value"];
            $this->_js .= "var ".$varName." = new Array();\n";
			$this->_js .= $varName."[0] = new Array('','');\n";
		}
        foreach ($options as $key => $array) {
            if ($key == $curKey) {
                $select2 =& $this->_elements[1];
                $select2->loadArray($array,$elValue[1]);    
            }
            $varName = $this->getName()."_".$key;
            $i = 0;
            foreach ($array as $value => $text) {
                $this->_js .= $varName."[".$i."] = new Array('".$value."', '".$text."');\n";
                $i++;
            }
        }
        $this->_js .= "</script>\n";
    } // end func setSecOptions

    // }}}
    // {{{ setValue()
	
	function setProfileOptions($options)
    {
        if (empty($this->_elements)) {
            $this->_createElements();
        }
        $select3 =& $this->_elements[2];
        $select3->loadArray($options);
    } // end func setMainOptions

    /**
     * Sets the element value
     * 
     * @param     array     An array of 2 values, for the first and the second selects
     * @access    public
     * @return    void
     */
    function setValue($value)
    {
        parent::setValue($value);
        // Reload the options in the second selects
        if (sizeof($this->_secOptions) > 0) {
            if (is_array($value)) {
                $curKey = isset($this->_secOptions[$value[0][0]]) ? $value[0][0] : key($this->_secOptions);
            } else {
                $curKey = key($this->_secOptions);
            }
            $select2 =& $this->_elements[1];
            $select2->_options = array(); // Bad, private...
            if($this->_secOptions[$curKey]) $select2->loadArray($this->_secOptions[$curKey]);
        }
    } // end func setValue

    // }}}
    // {{{ _createElements()

    /**
     * Creates the two select objects
     * 
     * @access    public
     * @return    void
     */
    function _createElements()
    {
        if (!defined('HTML_QUICKFORM_HIERSELECT_EXISTS')) {
            $this->_js .= "function swapOptions(selIndex, ctl, arName) {\n"
                     ."  ctl.options.length = 0;\n"
                     ."  var the_array = eval(arName + '_' + selIndex);\n"
                     ."  for (i=0; i < the_array.length; i++) {\n"
                     ."    opt = new Option(the_array[i][1], the_array[i][0], false, false);\n"
                     ."    ctl.options[i] = opt;\n"
                     ."  }\n"
                     ."}\n";
            define('HTML_QUICKFORM_HIERSELECT_EXISTS', true);
        }
        
		eval (ST ("perfil", "\$profile", DEFAULT_LANGUAGE));
		eval (ST ("ambito", "\$scope", DEFAULT_LANGUAGE));
		$this->_elements[] =& new HTML_QuickForm_select('0', $scope, array(), $this->getAttributes());
        $this->_elements[] =& new HTML_QuickForm_select(null, null, array(), $this->getAttributes());
		$this->_elements[] =& new HTML_QuickForm_select('profile', $profile, array(), $this->getAttributes());
		$this->_elements[] =& new HTML_QuickForm_select('profilescope', $profile, array(), array("multiple"=>"multiple"));
		
    } // end func _createElements

    // }}}
    // {{{ toHtml()

    /**
     * Returns Html for the group
     * 
     * @access      public
     * @return      string
     */
    function toHtml()
    {
        $this->_elements[0]->updateAttributes(array('onChange' => 'swapOptions(this.options[this.selectedIndex].value, this.form[\''.$this->getElementName(1)."'], '".$this->getName()."');"));
        if ($this->_flagFrozen) {
            $this->_js = '';
        }
        include_once('HTML/QuickForm/Renderer/Default.php');
        $renderer =& new HTML_QuickForm_Renderer_Default();
        $renderer->setElementTemplate('{element}');
		//$renderer->setGroupTemplate('{content}', $this->_name);
		$renderer->setGroupElementTemplate(' <br>{label} {element}', $this->_name);
		parent::accept($renderer);
		
		return $this->_js.$renderer->toHtml();
    } // end func toHtml

    // }}}
    // {{{ accept()

   /**
    * Accepts a renderer
    *
    * @param object     An HTML_QuickForm_Renderer object
    * @param bool       Whether a group is required
    * @param string     An error message associated with a group
    * @access public
    * @return void 
    */
    function accept(&$renderer, $required = false, $error = null)
    {
        $renderer->renderElement($this, $required, $error);
    } // end func accept

    // }}}
} // end class HTML_QuickForm_hierselect
?>