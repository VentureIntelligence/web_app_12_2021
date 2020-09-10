<?php
/*
 * A class for Xml Perse. 
 *
 * PHP 5 >
 *
 * @author     Jun Yamane <jun1969x[at]gmail.com>
 * @license    BSD http://www.opensource.org/licenses/bsd-license.html
 * @version    ver 0.13 (2011-01-24)
 * @link       http://sourceforge.jp/projects/xbrl-php/
 *
 */

class XML {
/**********************************************************
Properties. -> Changing "function changeProperties()"
**********************************************************/
	public $ATTR = "_attributes:";
	public $CAT = "_category:";
	public $LIST = "_file:list";
	public $NS = "_namespace:";
	public $VAL = "_value:";
/**********************************************************
Conf
**********************************************************/
	function __construct() {
		$ver = explode(".", phpversion(), 2);
		if((int)$ver[0]<5) {
			exit("<h1>Sorry</h1><p>This library needs PHP ver.5 or more.</p><p>*This servar : PHP ver.".phpversion().".</p>");
		}
// json_encode http://snippets.dzone.com/posts/show/7487
		if(!function_exists("json_encode")) {
			function json_encode($a=false) {
				if(is_null($a)) {
					return "null";
				}else if($a===false) {
					return "false";
				}else if($a===true) {
					return "true";
				}
				if(is_scalar($a)) {
					if(is_float($a)) {
						return floatval(str_replace(",", ".", strval($a)));
					}
					if(is_string($a)) {
						static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
						return '"'.str_replace($jsonReplaces[0], $jsonReplaces[1], $a).'"';
					}else {
						return $a;
					}
				}
				$isList = true;
				for($i=0, reset($a); $i<count($a); $i++, next($a)) {
					if(key($a)!==$i) {
						$isList = false;
						break;
					}
				}
				$result = array();
				if($isList) {
					foreach($a as $v) {
						$result[] = json_encode($v);
					}
					return '['.join(',', $result).']';
				}else {
					foreach($a as $k => $v) {
						$result[] = json_encode($k).':'.json_encode($v);
					}
					return '{'. join(',', $result).'}';
				}
			}
		}
	}
/**********************************************************
Change Properties
**********************************************************/
	public function changePrint(&$names="") {
		$this->changeProperties($names);
	}
	public function changeProperties($names="") {
		if(is_array($names)) {
			foreach($names as $key=>$val) {
				$this->$key = $val;
			}
		}
	}
/**********************************************************
htmlspecialchars. http://ma-bank.com/item/812
**********************************************************/
	public function h($expression="") {
		if(is_array($expression)) {
			return array_map(array(&$this, "h"), $expression);
		}else {
			if(!is_numeric($expression)) {
				$expression = htmlspecialchars($expression, ENT_QUOTES, "UTF-8");
			}
		}
		return $expression;
	}
/**********************************************************
Perse Xml (SimpleXML).
http://www.php.net/manual/en/book.simplexml.php
**********************************************************/
	public function perseXml($file="", $print="", $id="", $xbrlid="") {
		libxml_use_internal_errors(true);
		$doc = ($id!=1) ? @simplexml_load_file($file, null, LIBXML_COMPACT|LIBXML_NOCDATA|LIBXML_NOBLANKS|LIBXML_NOENT) : @simplexml_load_string($file, null, LIBXML_COMPACT|LIBXML_NOCDATA|LIBXML_NOBLANKS|LIBXML_NOENT);
		if(!is_object($doc)) {
			$err["status"] = "Failed loading XML.";
			foreach(libxml_get_errors() as $error) {
				$err["error"][] = $error->message;
			}
			return $err;
		}
		$ns = $data[$this->NS] = $doc->getDocNamespaces();
		if(!count($ns)) {
			$body = $this->_perseXmlLoop($doc, "", 1);
		}else {
			$ns = $this->_nameSpace($ns, 1);
			foreach($ns as $key=>$val) {
				$obj_attr = ($val) ? $doc->attributes($val) : $doc->attributes();
				if($obj_attr) {
					$data[$this->ATTR.$key] = $this->_perseAttributes($obj_attr);
				}
			}
			$root = $doc->getName();
			if($root=="xbrl" && $xbrlid==1) {
				list($doc, $catid) = $this->_changeXbrl($doc, $ns);
				if($catid) {
					$data[$this->CAT] = $catid;
				}
			}
			$body[$root] = $data;
			foreach($ns as $key=>$val) {
				if($obj_data = $this->_perseXmlLoop($doc, $val)) {
					$body[$root][$key] = $obj_data;
				}
			}
		}
		return ($print!=1) ? $body : $this->prints($body);
	}
/**********************************************************
Print_r.
**********************************************************/
	public function prints($expression="") {
		print_r("<pre>");
		print_r($this->h($expression));
		print_r("</pre>");
	}
/**********************************************************
Change Xbrl. Get Category &  Replace Expand Label. (Japanese)
**********************************************************/
	private static function _changeXbrl($doc="", $ns="") {
		foreach($ns as $key=>$val) {
			if(strpos($key, "jpfr-t-")!==FALSE) {
				$catid = $key;
				break;
			}
		}
		if(!$catid) {
			return array($doc);
		}
		foreach($ns as $key=>$val) {
			foreach(array("tdnet-", "jpfr-") as $elabel) {
				if(strpos($key, $elabel)!==FALSE && strlen($key)>12 && $key!=$catid) {
					foreach($doc->children($val) as $obj_key=>$obj_val) {
						$obj_val->addAttribute("_expandLabel", $key);
						$before[] = $key.":".$obj_key;
						$after[] = $catid.":".$obj_key;
					}
					break;
				}
			}
		}
		if(!$before) {
			return array($doc, $catid);
		}
		$text = str_replace($before, $after, $doc->asXML());
		$doc = simplexml_load_string($text);
		return array($doc, $catid);
	}
/**********************************************************
Name Space.
**********************************************************/
	private function _nameSpace($array="", $id="") {
		if(!array_key_exists("", $array) || (!in_array("", $array) && $id!=1)) {
			$array[""] = "";
		}
		return $array;
	}
/**********************************************************
Perse Xml Attributes.
**********************************************************/
	private function _perseAttributes($attributes="") {
		foreach($attributes as $attr) {
			$data[(string)$attr->getName()] = (string)$attr;
		}
		return $data;
	}
/**********************************************************
Perse Xml Loop.
**********************************************************/
	private function _perseXmlLoop($doc="", $vals="", $not="") {
		if(!is_object($doc)) {
			return;
		}
		$ns = $this->_nameSpace($doc->getNamespaces(true));
		$vals_ = (!$vals) ? $doc->children() : $doc->children($vals);
		foreach($vals_ as $obj_key=>$obj_val) {
			if($not===1) {
				if($obj_attr = $doc->attributes()) {
					$body[$obj_key][$this->ATTR] = $this->_perseAttributes($obj_attr);
				}
			}
			$data = "";
			foreach($ns as $key=>$val) {
				if($obj_loop = $this->_perseXmlLoop($obj_val, $val)) {
					$data[$key] = $obj_loop;
				}
			}
			if(count($ns)===1) {
				$data = $data[""];
			}
			foreach($ns as $key=>$val) {
				$obj_attr = ($val) ? $obj_val->attributes($val) : $obj_val->attributes();
				if($obj_attr) {
					$data[$this->ATTR.$key] = $this->_perseAttributes($obj_attr);
				}
			}
			if((string)$obj_val && !is_array($obj_val)) {
				$data[$this->VAL] = (string)$obj_val;
			}
			$body[$obj_key][] = $data;
		}
		return $body;
	}
}
?>