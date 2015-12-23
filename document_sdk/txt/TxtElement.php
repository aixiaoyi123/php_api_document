<?php
include_once(dirname(__FILE__)."/../data/DataElement.php");
include_once(dirname(__FILE__)."/../java/JavaElement.php");

/**
 * TXT结构体
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
class TxtElement extends JavaElement{

	// TXT类型映射表
	public $TXT_TYPE_KEY = array(
	/**字符串*/
	Element::TYPE_KEY_STRING           => "/txtpan/format/string.java",
	/**4位整型*/
	Element::TYPE_KEY_INT        	   => "/txtpan/format/int.java",
	/**长整形*/
	Element::TYPE_KEY_LONG             => "/txtpan/format/long.java",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT            => "/txtpan/format/float.java",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN          => "/txtpan/format/boolean.java",
	/**数组队列*/
	Element::TYPE_KEY_ARRAY            => "/txtpan/format/array.java",
	/**自定义类数组队列*/
	Element::TYPE_KEY_ARRAY_CLASS      => "/txtpan/format/array_class.java",
	/**自定义类*/
	Element::TYPE_KEY_CLASS_CHILD      => "/txtpan/format/class_child.java",
	/**内部类函数*/
	Element::TYPE_KEY_CLASS_NESTED     => "/txtpan/format/class_nested.java",
	/**类*/
	Element::TYPE_KEY_CLASS     	   => "/txtpan/format/class.java"
	/**待扩展*/
	);

	//TXT方法映射表
	public $TXT_TYPE_FUNCTION = array(
	/**字符串*/
	Element::TYPE_KEY_STRING           => "formatString",
	/**4位整型*/
	Element::TYPE_KEY_INT        	   => "formatInt",
	/**长整形*/
	Element::TYPE_KEY_LONG             => "formatLong",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT            => "formatFloat",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN          => "formatBool",
	/**数组队列*/
	Element::TYPE_KEY_ARRAY            => "formatArray",
	/**自定义类数组队列*/
	Element::TYPE_KEY_ARRAY_CLASS      => "formatArrayClass",
	/**自定义类*/
	Element::TYPE_KEY_CLASS_CHILD      => "formatClassChild",
	/**类*/
	Element::TYPE_KEY_CLASS     	   => "formatClass"
	/**待扩展*/
	);


	// TXT静态范围表
	public $TXT_STATIC_FINAL_KEY = array(
	/**字符串*/
	Element::TYPE_KEY_STRING           => "/txtpan/static/string.java",
	/**4位整型*/
	Element::TYPE_KEY_INT        	   => "/txtpan/static/int.java",
	/**长整形*/
	Element::TYPE_KEY_LONG             => "/txtpan/static/long.java",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT            => "/txtpan/static/float.java",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN          => "/txtpan/static/boolean.java",
	/**待扩展*/
	);


	//构造方法
	function __construct($note = "") {
		parent::__construct($note, Element::PARSE_MODE_TXT);
	}
	#@Overrides
	function getTypeKey(){

		return $this->TXT_TYPE_KEY;

	}

	#@Overrides
	function formatGeneralClass($dictionary,$key=""){

		$result ="";
		foreach ($dictionary as $itemkey => $value) {

			if(($value instanceof ClassElement) && $value->isShare){
				if(!empty($key)){
					$itemkey = $key ."；".$itemkey;
				}
				$arr = explode("；",$itemkey);
				$data = $this->value;
				foreach($arr as $u){
					if(isset($data[$u])){
						$data = $data[$u];
					}
				}

				$class = $value->name;
				if(class_exists($class)){
					$elment = new $class();
					if($elment instanceof NoteClass){
						$node = $elment->format($data,Element::PARSE_MODE_TXT);
						$result = $result.Element::ECHO_ENTER.Element::ECHO_ENTER.$node->format().Element::ECHO_ENTER.Element::ECHO_ENTER;
					}else{
						throw new Exception( $value->name." no extend NoteClass!");
					}
				}else{
					throw new Exception( $value->name." class undefine!");
				}

			}else if(is_array($value)){
				if(!empty($key)){
					$itemkey = $key ."；".$itemkey;
				}
				$result .= $this->formatGeneralClass($value,$itemkey);
			}
		}

		$result = str_replace("◤JSON结构体", "◤JSON【公用】结构体", $result);
		return $result;

	}
	#@Overrides
	function getFunctionName(){

		if (!array_key_exists($this->type, $this->TXT_TYPE_FUNCTION)) {
			throw new Exception( "getFunctionName no found!");
		}

		return  $this->TXT_TYPE_FUNCTION[$this->type];
	}

	#@Overrides
	function formatBasic($key) {

		$TypeKey = $this->getTypeKey();
		$note = parent::getNoteFormat();
		if (!array_key_exists($key,$TypeKey)){
			throw new Exception("formatBasic TypeKey no found $key !");
		}
		$format = $TypeKey[$key];
		$format = parent::getFileContents($format);
		$format = str_replace(Element::FORMAT_DATA_KEY, $this->name, $format);
		$format = str_replace(Element::FORMAT_NOTE, $note, $format);
		$result = $format;

		$static = $this->formatStatic($key);
		if(!empty($static)){
			$result .= $static;
		}
		return $result;

	}

	#@Overrides
	function formatClass() {

		$TypeKey = $this->getTypeKey();
		$note = parent::getNoteFormat();
		if (!is_array($this->value)){
			throw new Exception("formatClass is_array error!");
		}
		$format = $TypeKey[Element::TYPE_KEY_CLASS];
		$format = parent::getFileContents($format);
		if (empty($format)){
			throw new Exception("formatClass TYPE_KEY_CLASS null!");
		}
		$format = str_replace(Element::FORMAT_CLASS, $this->divname, $format);
		$data =  "";
		foreach ($this->value as $key => $value) {
			if($value != null){
				$element = $this->getElement();
				$element->initElement($key,$value,$this->getClassElement($key));
				$data = $data.$element->format();
			}
		}
		$format = str_replace(Element::FORMAT_DATA, $data, $format);
		$format = str_replace(DataElement::FORMAT_JSON_DATA, $this->parse(), $format);
		$format = str_replace(Element::FORMAT_NOTE, $note, $format);
		$result = $format;
		$fileurl =$this->getFileUrl($result,$this->divname.".txt");
		//return Element::ECHO_ENTER.$fileurl.Element::ECHO_ENTER.Element::ECHO_ENTER.$result;
		return $result;
	}

	#@Overrides
	function getParseKey(){
		return "";
	}

	#@Overrides
	function getParseName(){
		return "";
	}

	#@Overrides
	function parseBasic($key) {
		return "";
	}

	#@Overrides
	function getStaticKey(){

		return $this->TXT_STATIC_FINAL_KEY;

	}

}
?>