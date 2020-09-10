<?php
/*
 * A class for XBRL Perse. 
 *
 * PHP 5 >
 *
 * @author     Jun Yamane <jun1969x[at]gmail.com>
 * @license    BSD http://www.opensource.org/licenses/bsd-license.html
 * @version    ver 0.13 (2011-01-24)
 * @link       http://sourceforge.jp/projects/xbrl-php/
 *
 */

new ClassLoad;
ClassLoad::Start("XML", "/XML.php");

/**********************************************************
class 'ClassLoad'
**********************************************************/
class ClassLoad {
	public static function Start($class, $file) {
		if(!class_exists($class)) {
			$file = dirname(__FILE__).$file;
			if(file_exists($file)) {
				require($file);
			}else {
				$err["status"] = "Class '".$class."' not found";
				$err["error"] = "'".$file."' not found";
				exit("<pre>".print_r($err, true)."</pre>");
			}
		}
	}
}

/**********************************************************
class 'XBRL'
**********************************************************/
class XBRL extends XML {
	public $ACCOUNT_ARY;
	public $CATEGORY_ARY;
	public $NS_DATE = "2010-03-11";
	public $NS_ROOT = "./xml/ns/info.edinet-fsa.go.jp/jp/";
	public $ROLE_ARY;
/**********************************************************
Analysis Japanese Xbrl. (EDINET or TDnet)
**********************************************************/
	public function analysisXbrl($file="") {
		$body = $this->zipFiles($file, "", "", "", 1);
		$files = $body[$this->LIST];
		if(!$files) {
			return array("error", print_r($body, true)); 
		}
		foreach($files as $file) {
// Expand Account
			if(strpos($file, "-definition.xml")!==FALSE) {
				foreach($body[$file]["linkbase"]["link"] as $keys=>$vals) {
					foreach($vals as $val) {
						switch($keys) {
						case "roleRef" :
							$role = $this->x($val[$this->ATTR]["roleURI"]);
							$defs[$file][$keys][$role] = $this->x($val[$this->ATTR."xlink"]["href"]);
							break;
						case "definitionLink" :
							if(is_array($val["link"]["loc"])) {
								foreach($val["link"]["loc"] as $vv) {
									$defs[$file][ $vv[$this->ATTR."xlink"]["type"]][] = $vv[$this->ATTR."xlink"]["label"];
								}
							}
							break;
						}
					}
				}
			}
			foreach(array("", "-en") as $exval) {
				if(strpos($file, "-label".$exval.".xml")!==FALSE) {
					foreach($body[$file]["linkbase"]["link"] as $keys=>$vals) {
						foreach($vals[0]["link"]["label"] as $val) {
							$defs[$file][$val[$this->ATTR."xlink"]["label"]] = $val[$this->VAL];
						}
					}
				}
			}
		}
		foreach($files as $file) {
			$val = explode(".", $file);
			switch($val[1]) {
			case "csv" :
				break;
			case "xsd" :
				break;
			default :
				if($xdata = $body[$file]["xbrl"]) {
					$this->_changeAry();
					$category = $xdata[$this->CAT];
					$d[$file][$this->CAT] = $this->CATEGORY_ARY[$category][0];
					$d[$file][$this->NS] = $xdata[$this->NS];
					if(is_array($xdata["link"])) {
						foreach($xdata["link"] as $keys=>$vals) {
							if($keys=="roleRef") {
								foreach($vals as $val) {
									$role = $this->x($val[$this->ATTR]["roleURI"]);
									$d[$file]["link"][$role] = $this->x($val[$this->ATTR."xlink"]["href"]);
								}
							}
						}
					}
					if(is_array($xdata["jpfr-di"])) {
						foreach($xdata["jpfr-di"] as $keys=>$vals) {
							foreach($vals as $val) {
								$d[$file]["jpfr-di"][$keys] = $val[$this->VAL];
							}
						}
					}
					if(is_array($xdata["xbrli"])) {
						foreach($xdata["xbrli"] as $keys=>$vals) {
							if($keys=="context") {
								foreach($vals as $key=>$val) {
									foreach(array("instant", "startDate", "endDate") as $v) {
										$d[$file]["xbrli"][$val[$this->ATTR]["id"]][$v] = $val["xbrli"]["period"][0]["xbrli"][$v][0][$this->VAL];
									}
								}
							}
						}
					}
					if(is_array($xdata[$category])) {
						foreach($xdata[$category] as $keys=>$vals) {
							foreach($vals as $val) {
								$kval = array();
								$term = $val[$this->ATTR]["contextRef"];
								if($expand = $val[$this->ATTR]["_expandLabel"]) {
									$kval[] = $expand;
									array_unshift($kval, $val[$this->VAL]);
								}else {
									$kval = $this->ACCOUNT_ARY[$keys];
									array_unshift($kval, $val[$this->VAL]);
								}
								$d[$file][$category][$term][$keys] = $kval;
							}
						}
					}
				}
				break;
			}
		}
		return array("ok", array($files, $d, $defs));
	}
/**********************************************************
Perse Csv.
**********************************************************/
	public function perseCsv($file="", $print="", $id="") {
		$files = ($id!=1) ? file($file) : explode("\n", $file);
		foreach($files as $vals) {
			$vals = mb_convert_encoding($vals, "UTF-8", "Shift-JIS");
			foreach(explode(",", $vals) as $val) {
				if($val) {
					$body[] = $val;
				}
			}
		}
		return ($print!=1) ? $body : $this->prints($body);
	}
/**********************************************************
Get file name
**********************************************************/
	public function x($str="") {
		$str = array_slice(explode("/", $str), -1);
		return $str[0];
	}
/**********************************************************
Class 'dUnzip2' is necessary.
http://olederer.users.phpclasses.org/browse/package/2495.html
**********************************************************/
	public function zipFiles($file="", $print="", $lists="", $ajaxfile="", $xbrlid="") {
		if(is_file($file)) {
			ClassLoad::Start("dUnzip2", "/../dunzip2/dUnzip2.inc.php");
			$zip = new dUnzip2($file);
//			$zip->debug = true;
			if($files = $zip->getList()) {
				foreach($files as $entry) {
					$fname = $entry["file_name"];
					$name = $this->x($fname);
					$id = explode(".", $name);
					$body[$this->LIST][] = $name;
					if(!$lists) {
						$fdata = $zip->unzip($fname);
						$body[$name] = ($id[1]!="csv") ? $this->perseXml($fdata, "", 1, $xbrlid) : $this->perseCsv($fdata, "", 1);
					}else {
						if($ajaxfile==$name || $ajaxfile==$fname) {
							$fdata = $zip->unzip($fname);
							$bodys = ($id[1]!="csv") ? $this->perseXml($fdata, "", 1, $xbrlid) : $this->perseCsv($fdata, "", 1);	
							header("Content-Type: text/javascript; charset=utf-8");
							exit(json_encode($bodys));
						}
					}
				}
			}
		}
		if(!$body) {
			$body = $this->perseXml($file);
		}
		return ($print!=1) ? $body : $this->prints($body);
	}
/**********************************************************
Get data.
**********************************************************/
	private function _changeAry() {
		$ary = array("ACCOUNT_ARY"=>"fr/gaap/t", "CATEGORY_ARY"=>"category", "ROLE_ARY"=>"fr/gaap/role");
		foreach($ary as $key=>$val) {
			$dir = $this->NS_ROOT.$val."/".$this->NS_DATE."/data.dat";
			$this->$key = unserialize(@file_get_contents($dir));
		}
	}
}

/**********************************************************
Get data for Ajax.
**********************************************************/
if($_REQUEST["zip"] && $_REQUEST["file"]) {
	$ob_ = new XBRL;
	return $ob_->zipFiles($_REQUEST["zip"], "", 1, $_REQUEST["file"]);
}
?>