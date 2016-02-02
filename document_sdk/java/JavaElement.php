<?php
include_once(dirname(__FILE__)."/../data/DataElement.php");
include_once(dirname(__FILE__)."/JavaFormatListener.php");
include_once(dirname(__FILE__)."/JavaParseListener.php");

/**
 * JAVA结构体
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
class JavaElement extends DataElement implements JavaFormatListener,JavaParseListener{

	// JAVA类型映射表
	public $JAVA_TYPE_KEY = array(
	/**字符串*/
	Element::TYPE_KEY_STRING           => "/javapan/format/string.java",
	/**4位整型*/
	Element::TYPE_KEY_INT        	   => "/javapan/format/int.java",
	/**长整形*/
	Element::TYPE_KEY_LONG             => "/javapan/format/long.java",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT            => "/javapan/format/float.java",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN          => "/javapan/format/boolean.java",
	/**数组队列*/
	Element::TYPE_KEY_ARRAY            => "/javapan/format/array.java",
	/**自定义类数组队列*/
	Element::TYPE_KEY_ARRAY_CLASS      => "/javapan/format/array_class.java",
	/**自定义类*/
	Element::TYPE_KEY_CLASS_CHILD      => "/javapan/format/class_child.java",
	/**内部类函数*/
	Element::TYPE_KEY_CLASS_NESTED     => "/javapan/format/class_nested.java",
	/**类*/
	Element::TYPE_KEY_CLASS     	   => "/javapan/format/class.java",
	/**头部引用*/
	Element::TYPE_KEY_HEAD     	  	   => JAVA_HEAD
	/**待扩展*/
	);

	//JAVA方法映射表
	public $JAVA_TYPE_FUNCTION = array(
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

	// JAVA解析映射表
	public $JAVA_PARSE_KEY = array(
	/**字符串*/
	Element::TYPE_KEY_STRING           => "/javapan/parse/string.java",
	/**4位整型*/
	Element::TYPE_KEY_INT        	   => "/javapan/parse/int.java",
	/**长整形*/
	Element::TYPE_KEY_LONG             => "/javapan/parse/long.java",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT            => "/javapan/parse/float.java",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN          => "/javapan/parse/boolean.java",
	/**数组队列*/
	Element::TYPE_KEY_ARRAY            => "/javapan/parse/array.java",
	/**自定义类数组队列*/
	Element::TYPE_KEY_ARRAY_CLASS      => "/javapan/parse/array_class.java",
	/**自定义类*/
	Element::TYPE_KEY_CLASS_CHILD      => "/javapan/parse/class_child.java",
	/**内部类函数*/
	Element::TYPE_KEY_CLASS_NESTED     => "/javapan/parse/class_nested.java",
	/**类*/
	Element::TYPE_KEY_CLASS     	   => "/javapan/parse/class.java"
	/**待扩展*/
	);


	//JAVA解析Json方法映射表
	public $JAVA_PARSE_FUNCTION = array(
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

	// JAVA静态范围表
	public $JAVA_STATIC_FINAL_KEY = array(
	/**字符串*/
	Element::TYPE_KEY_STRING           => "/javapan/static/string.java",
	/**4位整型*/
	Element::TYPE_KEY_INT        	   => "/javapan/static/int.java",
	/**长整形*/
	Element::TYPE_KEY_LONG             => "/javapan/static/long.java",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT            => "/javapan/static/float.java",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN          => "/javapan/static/boolean.java",
	/**待扩展*/
	);


	//构造方法
	function __construct($note = "" , $parse = Element::PARSE_MODE_JAVA) {
		parent::__construct($note, $parse);
	}
	#@Overrides
	function getTypeKey(){

		return $this->JAVA_TYPE_KEY;

	}
	#@Overrides
	function autoType() {

		if (!isset($this->value) || $this->value == ""){
			throw new Exception("getAutoType value is null!");
		}


		if(is_null($this->value)){

			$this->setType(Element::TYPE_KEY_STRING);

		}else if(is_array($this->value)){

			if (array_key_exists(0,$this->value)){
				if(is_array($this->value[0])){
					$this->setType(Element::TYPE_KEY_ARRAY_CLASS);
				}else{
					$this->setType(Element::TYPE_KEY_ARRAY);
				}
			}else{
				$this->setType(Element::TYPE_KEY_CLASS_CHILD);
			}

		}else if(is_bool($this->value)){

			$this->setType(Element::TYPE_KEY_BOOLEAN);

		}else if(is_numeric($this->value)){


			if(strpos($this->value,'.')){
				$this->setType(Element::TYPE_KEY_FLOAT);
			}else{
				$value = intval($this->value);
				if($value > 2147483647/2){
					$this->setType(Element::TYPE_KEY_LONG);
				}else{
					$this->setType(Element::TYPE_KEY_INT);
				}
			}

		}else if(is_object($this->value)){

			$this->setType(Element::TYPE_KEY_OBJECT);

		}else{

			$this->setType(Element::TYPE_KEY_STRING);

		}
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
						$node = $elment->format($data,Element::PARSE_MODE_JAVA);
						$node->setVersion($elment->getVerison());
						$result = $result.Element::ECHO_ENTER.Element::ECHO_ENTER.$node->format().Element::ECHO_ENTER.Element::ECHO_ENTER;
						//继续遍历下一层的共享数据
						$general = $node->formatGeneral();
						$result = $result.$general;
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

		if (!array_key_exists($this->type, $this->JAVA_TYPE_FUNCTION)) {
			throw new Exception( "getFunctionName no found!");
		}

		return  $this->JAVA_TYPE_FUNCTION[$this->type];
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
			$result = $static.$result;
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
		$format = str_replace(Element::FORMAT_CLASS, $type, $format);
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
		if(!$this->isShare){
			$nested = $TypeKey[Element::TYPE_KEY_CLASS_NESTED];
			$nested = parent::getFileContents($nested);
			$format = $format.$nested;
		}
		$format = str_replace(Element::FORMAT_DATA_KEY, $this->name, $format);
		$format = str_replace(Element::FORMAT_CLASS, $this->divname, $format);
		$data =  "";
		foreach ($this->value[0] as $key => $value) {

			if($value != null){
				$element = $this->getElement();
				$element->initElement($key,$value,$this->getClassElement($key));
				$data .= $this->replace($element->format());
			}

		}
		$format = str_replace(Element::FORMAT_DATA, $data, $format);
		if(!$this->isShare){
			$this->type = Element::TYPE_KEY_CLASS_NESTED;
			$this->value = $this->value[0];
			$format = str_replace(DataElement::FORMAT_JSON_DATA, $this->parse(), $format);
		}
		$format = str_replace(Element::FORMAT_NOTE, $note, $format);
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
		if(!$this->isShare){
			$nested = $TypeKey[Element::TYPE_KEY_CLASS_NESTED];
			$nested = parent::getFileContents($nested);
			$format = $format.$nested;
		}
		$format = str_replace(Element::FORMAT_DATA_KEY, $this->name, $format);
		$format = str_replace(Element::FORMAT_CLASS, $this->divname, $format);

		$data =  "";
		foreach ($this->value as $key => $value) {

			if($value != null){
				$element = $this->getElement();
				$element->initElement($key,$value,$this->getClassElement($key));
				$data .= $this->replace($element->format());
			}

		}
		$format = str_replace(Element::FORMAT_DATA, $data, $format);
		if(!$this->isShare){
			$this->type = Element::TYPE_KEY_CLASS_NESTED;
			$format = str_replace(DataElement::FORMAT_JSON_DATA, $this->parse(), $format);
		}
		$format = str_replace(Element::FORMAT_NOTE, $note, $format);
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
			}
		}
		$format = str_replace(Element::FORMAT_DATA, $data, $format);
		$format = str_replace(DataElement::FORMAT_JSON_DATA, $this->parse(), $format);
		$format = str_replace(Element::FORMAT_NOTE, $note, $format);
		$format = str_replace(Element::FORMAT_VERSION, $this->version, $format);
		$result = JAVA_HEAD.$format;
		$fileurl =$this->getFileUrl($result,$this->divname.".java");
		return $result;
	}

	#@Overrides
	function getParseKey(){

		return $this->JAVA_PARSE_KEY;

	}

	#@Overrides
	function getParseName(){

		if (!array_key_exists($this->type, $this->JAVA_PARSE_FUNCTION)) {
			throw new Exception( "getParseName no found!");
		}

		return  $this->JAVA_PARSE_FUNCTION[$this->type];
	}

	#@Overrides
	function parseBasic($key) {

		$ParseKey = $this->getParseKey();
		if (!array_key_exists($key,$ParseKey)){
			throw new Exception("parseBasic ParseKey no found $key !");
		}
		$parse = $ParseKey[$key];
		$parse = parent::getFileContents($parse);
		$parse = str_replace(Element::FORMAT_DATA_KEY, $this->name, $parse);
		return $parse;

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
		$parse = str_replace(Element::FORMAT_CLASS, $type, $parse);
		$parse = str_replace(DataElement::FORMAT_OBJECT, ucfirst($type), $parse);
		$parse = str_replace("(Int)", "(Integer)", $parse);
		return $parse;


	}

	#@Overrides
	function parseArrayClass() {

		$ParseKey = $this->getParseKey();
		if (!is_array($this->value)){
			throw new Exception("parseArrayClass is_array error!");
		}
		if (!is_array($this->value[0])){
			throw new Exception("parseArrayClass value[0] is_array error!");
		}
		$parse = $ParseKey[Element::TYPE_KEY_ARRAY_CLASS];
		$parse = parent::getFileContents($parse);
		if (empty($parse)){
			throw new Exception("parseArrayClass TYPE_KEY_ARRAY_CLASS null!");
		}
		$parse = str_replace(Element::FORMAT_DATA_KEY, $this->name, $parse);
		$parse = str_replace(Element::FORMAT_CLASS, $this->divname, $parse);

		return $parse;

	}

	#@Overrides
	function parseClassChild() {

		$ParseKey = $this->getParseKey();
		if (!is_array($this->value)){
			throw new Exception("parseClassChild is_array error!");
		}
		$parse = $ParseKey[Element::TYPE_KEY_CLASS_CHILD];
		$parse = parent::getFileContents($parse);
		if (empty($parse)){
			throw new Exception("parseClassChild TYPE_KEY_CLASS_CHILD null!");
		}
		$parse = str_replace(Element::FORMAT_DATA_KEY, $this->name, $parse);
		$parse = str_replace(Element::FORMAT_CLASS, $this->divname, $parse);

		return $parse;


	}

	#@Overrides
	function parseClassNested() {

		$ParseKey = $this->getParseKey();
		if (!is_array($this->value)){
			throw new Exception("parseClassNested is_array error!");
		}
		$parse = $ParseKey[Element::TYPE_KEY_CLASS_NESTED];
		$parse = parent::getFileContents($parse);
		if (empty($parse)){
			throw new Exception("parseClassNested TYPE_KEY_CLASS_NESTED null!");
		}
		if($this->isShare){
			return "";
		}
		$parse = str_replace(Element::FORMAT_DATA_KEY, $this->name, $parse);
		$parse = str_replace(Element::FORMAT_CLASS, $this->divname, $parse);
		$data =  "";
		foreach ($this->value as $key => $value) {

			if($value != null){
				$element = $this->getElement();
				$element->initElement($key,$value,$this->getClassElement($key));
				$data .= $this->replace($element->parse());
			}

		}
		$parse = str_replace(Element::FORMAT_DATA, $data, $parse);
		return $parse;


	}


	#@Overrides
	function parseClass() {

		$ParseKey = $this->getParseKey();
		if (!is_array($this->value)){
			throw new Exception("parseClass is_array error!");
		}
		$parse = $ParseKey[Element::TYPE_KEY_CLASS];
		$parse = parent::getFileContents($parse);
		if (empty($parse)){
			throw new Exception("parseClass TYPE_KEY_CLASS null!");
		}
		$parse = str_replace(Element::FORMAT_CLASS, $this->divname, $parse);
		$data =  "";
		foreach ($this->value as $key => $value) {
			if($value != null){
				$element = $this->getElement();
				$element->initElement($key,$value,$this->getClassElement($key));
				$data = $data.$element->parse();
			}
		}
		$parse = str_replace(Element::FORMAT_DATA, $data, $parse);

		return $parse;


	}


	#@Overrides
	function getStaticKey(){

		return $this->JAVA_STATIC_FINAL_KEY;

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
			$name = strtoupper($this->name."_$name");
			$data = str_replace(Element::FORMAT_NOTE, $note, $static);
			$data = str_replace(Element::FORMAT_CLASS, $name, $data);
			$data = str_replace(Element::FORMAT_DATA_KEY, strval($value), $data);
			$result .= $data;
		}
		return Element::FORMAT_ENTER.$result.Element::FORMAT_ENTER;

	}

	/**
	 * 替换方式
	 * */
	public function replace($value) {
		$result = str_replace(Element::ECHO_ENTER,Element::ECHO_ENTER.Element::FORMAT_SPLACE,$value);
		return $result;

	}

}
?>