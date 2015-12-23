<?php
include_once(dirname(__FILE__)."/../java/JavaElement.php");


/**
 * SWIFT结构体
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
class SwiftElement extends JavaElement{

	// Swift类型映射表
	public $SWIFT_TYPE_KEY = array(
	/**字符串*/
	Element::TYPE_KEY_STRING           => "/swiftpan/format/string.swift",
	/**4位整型*/
	Element::TYPE_KEY_INT        	   => "/swiftpan/format/int.swift",
	/**长整形*/
	Element::TYPE_KEY_LONG             => "/swiftpan/format/long.swift",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT            => "/swiftpan/format/float.swift",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN          => "/swiftpan/format/boolean.swift",
	/**数组队列*/
	Element::TYPE_KEY_ARRAY            => "/swiftpan/format/array.swift",
	/**自定义类数组队列*/
	Element::TYPE_KEY_ARRAY_CLASS      => "/swiftpan/format/array_class.swift",
	/**自定义类*/
	Element::TYPE_KEY_CLASS_CHILD      => "/swiftpan/format/class_child.swift",
	/**内部类函数*/
	Element::TYPE_KEY_CLASS_NESTED     => "/swiftpan/format/class_nested.swift",
	/**类*/
	Element::TYPE_KEY_CLASS     	   => "/swiftpan/format/class.swift"
	/**待扩展*/
	);

	//Swift方法映射表
	public $SWIFT_TYPE_FUNCTION = array(
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
	Element::TYPE_KEY_CLASS     	   => "formatClass",
	/**头部引用*/
	Element::TYPE_KEY_HEAD     	       => "formatHead"
	/**待扩展*/
	);

	// SWIFT解析映射表
	public $SWIFT_PARSE_KEY = array(
	/**字符串*/
	Element::TYPE_KEY_STRING           => "/swiftpan/parse/string.swift",
	/**4位整型*/
	Element::TYPE_KEY_INT        	   => "/swiftpan/parse/int.swift",
	/**长整形*/
	Element::TYPE_KEY_LONG             => "/swiftpan/parse/long.swift",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT            => "/swiftpan/parse/float.swift",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN          => "/swiftpan/parse/boolean.swift",
	/**数组队列*/
	Element::TYPE_KEY_ARRAY            => "/swiftpan/parse/array.swift",
	/**自定义类数组队列*/
	Element::TYPE_KEY_ARRAY_CLASS      => "/swiftpan/parse/array_class.swift",
	/**自定义类*/
	Element::TYPE_KEY_CLASS_CHILD      => "/swiftpan/parse/class_child.swift",
	/**内部类函数*/
	Element::TYPE_KEY_CLASS_NESTED     => "/swiftpan/parse/class_nested.swift",
	/**类*/
	Element::TYPE_KEY_CLASS     	   => "/swiftpan/parse/class.swift"
	/**待扩展*/
	);


	//SWIFT解析Json方法映射表
	public $SWIFT_PARSE_FUNCTION = array(
	/**字符串*/
	Element::TYPE_KEY_STRING           => "parseString",
	/**4位整型*/
	Element::TYPE_KEY_INT        	   => "parseInt",
	/**长整形*/
	Element::TYPE_KEY_LONG             => "parseLong",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT            => "parseFloat",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN          => "parseBool",
	/**数组队列*/
	Element::TYPE_KEY_ARRAY            => "parseArray",
	/**自定义类数组队列*/
	Element::TYPE_KEY_ARRAY_CLASS      => "parseArrayClass",
	/**自定义类*/
	Element::TYPE_KEY_CLASS_CHILD      => "parseClassChild",
	/**内部类*/
	Element::TYPE_KEY_CLASS_NESTED     => "parseClassNested",
	/**类*/
	Element::TYPE_KEY_CLASS     	   => "parseClass"
	/**待扩展*/
	);

	// SWIFT静态范围表
	public $SWIFT_STATIC_FINAL_KEY = array(
	/**字符串*/
	Element::TYPE_KEY_STRING           => "/swiftpan/static/string.swift",
	/**4位整型*/
	Element::TYPE_KEY_INT        	   => "/swiftpan/static/int.swift",
	/**长整形*/
	Element::TYPE_KEY_LONG             => "/swiftpan/static/long.swift",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT            => "/swiftpan/static/float.swift",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN          => "/swiftpan/static/boolean.swift",
	/**待扩展*/
	);

	// 嵌套类
	public $class_nested = array();

	// 静态常量定义
	public $static_params = array();

	/**静态名称 */
	const FORMAT_STATIC ="{static}";

	//构造方法
	function __construct($note = "" , $parse = Element::PARSE_MODE_SWIFT) {
		parent::__construct($note, $parse);
	}

	//获取静态常量定义
	function getStaticParams(){

		$static = "";
		foreach ($this->static_params as $key => $value) {
			$static .= Element::FORMAT_ENTER.Element::FORMAT_ENTER.$value;
		}
		$static = str_replace(self::FORMAT_STATIC, strtoupper($this->name), $static);
		return $static;
	}

	//增加静态常量
	function setStaticParamsData($data){

		if(!empty($data)){
			$this->static_params[] = $data;
		}

	}

	//增加静态常量
	function addStaticParams($element){

		if($element instanceof SwiftElement){
			//嵌套类型
			foreach ($element->static_params as $key => $value) {
				if(!empty($value)){
					$this->static_params[] = $value;
				}
			}
		}

	}


	//获取本身嵌套类
	function getClassNestedData(){

		$nested = "";
		foreach ($this->class_nested as $key => $value) {
			$nested .= Element::FORMAT_ENTER.Element::FORMAT_ENTER.$value;
		}
		return $nested;
	}

	//增加本身嵌套类
	function setClassNestedData($data){

		if(!empty($data)){
			$this->class_nested[] = $data;
		}

	}

	//增加嵌套类
	function addClassNested($element){

		if(($element instanceof SwiftElement) && $element->type == Element::TYPE_KEY_CLASS_NESTED){
			//嵌套类型
			foreach ($element->class_nested as $key => $value) {
				if(!empty($value)){
					$this->class_nested[] = $value;
				}
			}
		}

	}


	#@Overrides
	function getTypeKey(){

		return $this->SWIFT_TYPE_KEY;

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
						$node = $elment->format($data,Element::PARSE_MODE_SWIFT);
						$result = $result.Element::ECHO_ENTER.Element::ECHO_ENTER.$node->format().Element::ECHO_ENTER.Element::ECHO_ENTER;
						$this->setFileList($node->getFileList());
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

		return $result;

	}
	#@Overrides
	function getFunctionName(){

		if (!array_key_exists($this->type, $this->SWIFT_TYPE_FUNCTION)) {
			throw new Exception( "getFunctionName no found!");
		}

		return  $this->SWIFT_TYPE_FUNCTION[$this->type];
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
			$this->setStaticParamsData($static);
		}
		return $result;

	}


	#@Overrides
	function formatArray() {

		$TypeKey = $this->getTypeKey();
		$note = parent::getNoteFormat();
		if (!is_array($this->value)){
			throw new Exception("formatArray is_array error!");
		}
		$format = $TypeKey[Element::TYPE_KEY_ARRAY];
		$format = parent::getFileContents($format);
		$type = $this->getArrayType($this->value);
		$format = str_replace(Element::FORMAT_DATA_KEY, $this->name, $format);
		$format = str_replace(Element::FORMAT_CLASS, ucfirst($type), $format);
		$format = str_replace(Element::FORMAT_NOTE, $note, $format);
		return $format;
	}


	#@Overrides
	function formatArrayClass() {

		$TypeKey = $this->getTypeKey();
		$note = parent::getNoteFormat();
		if (!is_array($this->value)){
			throw new Exception("formatArrayClass is_array error!");
		}
		if (!is_array($this->value[0])){
			throw new Exception("formatArrayClass value[0] is_array error!");
		}
		$format = $TypeKey[Element::TYPE_KEY_ARRAY_CLASS];
		$format = parent::getFileContents($format);
		if (empty($format)){
			throw new Exception("formatArrayClass TYPE_KEY_ARRAY_CLASS null!");
		}
		$format = str_replace(Element::FORMAT_DATA_KEY, $this->name, $format);
		$format = str_replace(Element::FORMAT_CLASS, $this->divname, $format);
		$format = str_replace(Element::FORMAT_NOTE, $note, $format);

		if(!$this->isShare){
			$nested = $TypeKey[Element::TYPE_KEY_CLASS_NESTED];
			$nested = parent::getFileContents($nested);
			$data =  "";
			foreach ($this->value[0] as $key => $value) {
				if($value != null){
					$element = $this->getElement();
					$element->initElement($key,$value,$this->getClassElement($key));
					$data .= $element->format();
					$this->addClassNested($element);
					$this->addStaticParams($element);
				}
			}
			$nested = str_replace(Element::FORMAT_DATA_KEY, $this->name, $nested);
			$nested = str_replace(Element::FORMAT_CLASS, $this->divname, $nested);
			$nested = str_replace(Element::FORMAT_NOTE, $note, $nested);
			$this->type = Element::TYPE_KEY_CLASS_NESTED;
			$this->value = $this->value[0];
			$nested = str_replace(Element::FORMAT_DATA, $data, $nested);
			$nested = str_replace(DataElement::FORMAT_JSON_DATA, $this->parse(), $nested);
			$this->setClassNestedData($nested);
		}

		return $format;

	}

	#@Overrides
	function formatClassChild() {

		$TypeKey = $this->getTypeKey();
		$note = parent::getNoteFormat();
		if (!is_array($this->value)){
			throw new Exception("formatClassChild is_array error!");
		}
		$format = $TypeKey[Element::TYPE_KEY_CLASS_CHILD];
		$format = parent::getFileContents($format);
		if (empty($format)){
			throw new Exception("formatClassChild TYPE_KEY_CLASS_CHILD null!");
		}

		$format = str_replace(Element::FORMAT_DATA_KEY, $this->name, $format);
		$format = str_replace(Element::FORMAT_CLASS, $this->divname, $format);
		$format = str_replace(Element::FORMAT_NOTE, $note, $format);

		if(!$this->isShare){
			$nested = $TypeKey[Element::TYPE_KEY_CLASS_NESTED];
			$nested = parent::getFileContents($nested);
			$data =  "";
			foreach ($this->value as $key => $value) {
				if($value != null){
					$element = $this->getElement();
					$element->initElement($key,$value,$this->getClassElement($key));
					$data .= $element->format();
					$this->addClassNested($element);
					$this->addStaticParams($element);
				}
			}
			$nested = str_replace(Element::FORMAT_DATA_KEY, $this->name, $nested);
			$nested = str_replace(Element::FORMAT_CLASS, $this->divname, $nested);
			$nested = str_replace(Element::FORMAT_NOTE, $note, $nested);
			$this->type = Element::TYPE_KEY_CLASS_NESTED;
			$nested = str_replace(Element::FORMAT_DATA, $data, $nested);
			$nested = str_replace(DataElement::FORMAT_JSON_DATA, $this->parse(), $nested);
			$this->setClassNestedData($nested);
		}


		return $format;



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
				$this->addClassNested($element);
				$this->addStaticParams($element);
			}
		}
		$format = str_replace(Element::FORMAT_DATA, $data, $format);
		$format = str_replace(DataElement::FORMAT_JSON_DATA, $this->parse(), $format);
		$format = str_replace(Element::FORMAT_NOTE, $note, $format);
		$format = str_replace(Element::FORMAT_VERSION, $this->version, $format);
		$format = str_replace(self::FORMAT_STATIC, $this->getStaticParams(), $format);
		$result = $format.$this->getClassNestedData();

		$fileurl =$this->getFileUrl($result,$this->divname.".swift");
		return $result;
	}

	#@Overrides
	function getParseKey(){

		return $this->SWIFT_PARSE_KEY;

	}

	#@Overrides
	function getParseName(){

		if (!array_key_exists($this->type, $this->SWIFT_PARSE_FUNCTION)) {
			throw new Exception( "getParseName no found!");
		}

		return  $this->SWIFT_PARSE_FUNCTION[$this->type];
	}

	#@Overrides
	function parseArray() {

		$ParseKey = $this->getParseKey();
		if (!is_array($this->value)){
			throw new Exception("parseArray is_array error!");
		}
		$parse = $ParseKey[Element::TYPE_KEY_ARRAY];
		$parse = parent::getFileContents($parse);
		$type = $this->getArrayType($this->value);
		$parse = str_replace(Element::FORMAT_DATA_KEY, $this->name, $parse);
		$parse = str_replace(Element::FORMAT_CLASS, ucfirst($type), $parse);
		$parse = str_replace(DataElement::FORMAT_OBJECT, ucfirst($type), $parse);
		$parse = str_replace("(Int)", "(Integer)", $parse);
		return $parse;


	}


	#@Overrides
	function getStaticKey(){

		return $this->SWIFT_STATIC_FINAL_KEY;

	}

	#@Overrides
	function formatStatic($key){

		if (!is_array($this->dictionary)){
			/**没有静态区间标注*/
			return "";
		}
		$StaticKey = $this->getStaticKey();
		if (!array_key_exists($key,$StaticKey)){
			throw new Exception("formatStatic StaticKey no found $key !");
		}
		$static = $StaticKey[$key];
		$static = parent::getFileContents($static);
		$result = "";
		foreach ($this->dictionary as $value => $note) {
			$name = $value;
			if($this->note_type == self::NOTE_TYPE_AUTO && $key != Element::TYPE_KEY_STRING && !empty($note)){
				$az = language_new_az($note);
				if(!empty($az) && preg_match("/^[a-zA-Z\s]+$/",$az)){
					$name = $az;
				}
			}
			$name = self::FORMAT_STATIC.strtoupper("_".$this->name."_$name");
			$data = str_replace(Element::FORMAT_NOTE, $note, $static);
			$data = str_replace(Element::FORMAT_CLASS, $name, $data);
			$data = str_replace(Element::FORMAT_DATA_KEY, strval($value), $data);
			$result .= $data;
		}
		return $result;

	}

}
?>