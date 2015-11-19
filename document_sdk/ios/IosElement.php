<?php
include_once(dirname(__FILE__)."/../java/JavaElement.php");


/**
 * Ios结构体
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
class IosElement extends JavaElement{

	// Ios类型映射表
	public $IOS_TYPE_KEY = array(
	/**字符串*/
	Element::TYPE_KEY_STRING           => "/iospan/format/string.h",
	/**4位整型*/
	Element::TYPE_KEY_INT        	   => "/iospan/format/int.h",
	/**长整形*/
	Element::TYPE_KEY_LONG             => "/iospan/format/long.h",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT            => "/iospan/format/float.h",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN          => "/iospan/format/boolean.h",
	/**数组队列*/
	Element::TYPE_KEY_ARRAY            => "/iospan/format/array.h",
	/**自定义类数组队列*/
	Element::TYPE_KEY_ARRAY_CLASS      => "/iospan/format/array_class.h",
	/**自定义类*/
	Element::TYPE_KEY_CLASS_CHILD      => "/iospan/format/class_child.h",
	/**内部类函数*/
	Element::TYPE_KEY_CLASS_NESTED     => "/iospan/format/class_nested.h",
	/**类*/
	Element::TYPE_KEY_CLASS     	   => "/iospan/format/class.h"
	/**待扩展*/
	);

	// Ios实现类类型映射表
	public $IOS_MTYPE_KEY = array(
	/**自定义类数组队列*/
	Element::TYPE_KEY_ARRAY_CLASS      => "/iospan/format/array_class.m",
	/**内部类函数*/
	Element::TYPE_KEY_CLASS_NESTED     => "/iospan/format/class_nested.m",
	/**类*/
	Element::TYPE_KEY_CLASS     	   => "/iospan/format/class.m"
	/**待扩展*/
	);


	// IOS静态范围表
	public $IOS_STATIC_FINAL_KEY = array(
	/**字符串*/
	Element::TYPE_KEY_STRING           => "/iospan/static/string.h",
	/**4位整型*/
	Element::TYPE_KEY_INT        	   => "/iospan/static/int.h",
	/**长整形*/
	Element::TYPE_KEY_LONG             => "/iospan/static/long.h",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT            => "/iospan/static/float.h",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN          => "/iospan/static/boolean.h",
	/**待扩展*/
	);

	// 实现类解析对象数组方式
	public $m_array_class_method = "";

	//  实现类
	public $m_class = array();

	//  实现数组类
	public $m_array_class = array();

	// 嵌套类
	public $class_nested = array();

	// 静态常量定义
	public $static_params = array();

	/**静态名称 */
	const FORMAT_STATIC ="{static}";

	// 静态引用定义
	public $import_params = array();

	/**静态引用名称 */
	const FORMAT_IMPORT ="{import}";
	const FORMAT_IMPORT_VALUE ="#import	\"{?}.h\"";


	// 静态引用内部定义
	public $class_params = array();

	/**静态引用内部名称 */
	const FORMAT_CLASS ="{class}";
	const FORMAT_CLASS_VALUE ="@class	{?};";


	//构造方法
	function __construct($note = "" , $parse = Element::PARSE_MODE_IOS) {
		parent::__construct($note, $parse);
	}

	//获取本身解析类
	function getMClassData(){

		$m_class = "";
		for($index =count($this->m_class)-1;$index>=0;$index--){
			$m_class .= Element::FORMAT_ENTER.Element::FORMAT_ENTER.$this->m_class[$index];
		}
		return $m_class;
	}

	//增加本身解析类
	function setMClassData($data){

		if(!empty($data)){
			$data = str_replace(Element::FORMAT_DATA, $this->getMArrayClassData(), $data);
			$this->m_class[] = $data;
		}

	}

	//增加解析类
	function addMClass($element){

		if(($element instanceof IosElement) && $element->type == Element::TYPE_KEY_CLASS_NESTED){
			//嵌套类型
			foreach ($element->m_class as $key => $value) {
				if(!empty($value)){
					$this->m_class[] = $value;
				}
			}
		}

	}

	//获取本身解析类
	function getMArrayClassData(){

		$m_class = "";
		foreach ($this->m_array_class as $key => $value) {
			$m_class .= Element::FORMAT_ENTER.$value;
		}
		return $m_class;
	}

	//增加解析类
	function addMArrayClass($element){

		if(($element instanceof IosElement) && $element->type == Element::TYPE_KEY_CLASS_NESTED){
			//嵌套类型
			if(!empty($element->m_array_class_method)){
				$this->m_array_class[] = $element->m_array_class_method;
			}

		}

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

		if($element instanceof IosElement){
			//嵌套类型
			foreach ($element->static_params as $key => $value) {
				if(!empty($value)){
					$this->static_params[] = $value;
				}
			}
		}

	}


	//获取静态内部类定义
	function getClassParams(){

		$class = "";
		foreach ($this->class_params as $key => $value) {
			$class .= Element::FORMAT_ENTER.$value;
		}
		return $class;
	}

	//增加静态内部类
	function setClassParamsData($data){

		if(!empty($data)){
			
			if(strpos($data,'@class') === false){
				$data = str_replace(Element::FORMAT_DATA_KEY, $data, self::FORMAT_CLASS_VALUE);
			}
			
			foreach ($this->class_params as $key => $value) {
				if($value == $data){
					return;
				}
			}
			$this->class_params[] = $data;
		}

	}

	//增加静态内部类
	function addClassParams($element){

		if($element instanceof IosElement && $element->type == Element::TYPE_KEY_CLASS_NESTED){
			//嵌套类型
			foreach ($element->class_params as $key => $value) {
				if(!empty($value)){
					$this->setClassParamsData($value);
				}
			}
		}

	}




	//获取静态引用定义
	function getImportParams(){

		$import = "";
		foreach ($this->import_params as $key => $value) {
			$import .= Element::FORMAT_ENTER.$value;
		}
		return $import;
	}

	//增加静态常量
	function setImportParamsData($data){

		if(!empty($data)){

			if(strpos($data,'#import') === false){
				$data = str_replace(Element::FORMAT_DATA_KEY, $data, self::FORMAT_IMPORT_VALUE);
			}
			foreach ($this->import_params as $key => $value) {
				if($value == $data){
					return;
				}
			}
			$this->import_params[] = $data;
		}

	}

	//增加静态常量
	function addImportParams($element){

		if($element instanceof IosElement){
			//嵌套类型
			foreach ($element->import_params as $key => $value) {
				if(!empty($value)){
					$this->setImportParamsData($value);
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

		if(($element instanceof IosElement) && $element->type == Element::TYPE_KEY_CLASS_NESTED){
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

		return $this->IOS_TYPE_KEY;

	}
	/**获取实现类*/
	function getMTypeKey(){

		return $this->IOS_MTYPE_KEY;

	}

	#@Overrides
	function formatGeneralClass($dictionary,$key=""){

		$result ="";
		foreach ($dictionary as $itemkey => $value) {

			if(($value instanceof ClassElement) && $value->isShare){
				if(empty($key)){
					$key = $itemkey;
				}else{
					$key .= "；".$itemkey;
				}
				$arr = explode("；",$key);
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
						$node = $elment->format($data,Element::PARSE_MODE_IOS);
						$result = $result.Element::ECHO_ENTER.Element::ECHO_ENTER.$node->format().Element::ECHO_ENTER.Element::ECHO_ENTER;
						$this->setFileList($node->getFileList());
					}else{
						throw new Exception( $value->name." no extend NoteClass!");
					}
				}else{
					throw new Exception( $value->name." class undefine!");
				}

			}else if(is_array($value)){
				if(empty($key)){
					$key = $itemkey;
				}else{
					$key .= "；".$itemkey;
				}
				$result .= $this->formatGeneralClass($value,$key);
			}
		}

		return $result;

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

	/**
	 * 此地方需要重写解析方式.m文件
	 * */
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

		/**.m文件解析本身的数组方式*/
		$this->parseArrayClass();

		if(!$this->isShare){
			/**不是共用类，也必须重写.m*/
			$nested = $TypeKey[Element::TYPE_KEY_CLASS_NESTED];
			$nested = parent::getFileContents($nested);
			$data =  "";
			foreach ($this->value[0] as $key => $value) {
				if($value != null){
					$element = $this->getElement();
					$element->initElement($key,$value,$this->getClassElement($key));
					$data .= $element->format();
					/**累计增加所有对象*/
					$this->addMClass($element);
					/**遍历所有数组对象方法*/
					$this->addMArrayClass($element);
					$this->addClassNested($element);
					$this->addStaticParams($element);
					$this->addImportParams($element);
					$this->addClassParams($element);
				}
			}
			$nested = str_replace(Element::FORMAT_DATA_KEY, $this->name, $nested);
			$nested = str_replace(Element::FORMAT_CLASS, $this->divname, $nested);
			$nested = str_replace(Element::FORMAT_NOTE, $note, $nested);
			$this->type = Element::TYPE_KEY_CLASS_NESTED;
			$this->value = $this->value[0];
			$nested = str_replace(Element::FORMAT_DATA, $data, $nested);
			$this->setClassNestedData($nested);
			$this->setClassParamsData($this->divname);
			$this->parseClassNested();

		}else{
			/**共享类*/
			$this->setImportParamsData($this->divname);
		}

		return $format;

	}

	/**
	 * .m文件解释对象数组方式
	 * */
	#@Overrides
	function parseArrayClass() {

		$MTypeKey = $this->getMTypeKey();
		$parse = $MTypeKey[Element::TYPE_KEY_ARRAY_CLASS];
		$parse = parent::getFileContents($parse);
		if (empty($parse)){
			throw new Exception("parseArrayClass TYPE_KEY_ARRAY_CLASS null!");
		}
		$parse = str_replace(Element::FORMAT_DATA_KEY, $this->name, $parse);
		$parse = str_replace(Element::FORMAT_CLASS, $this->divname, $parse);
		$this->m_array_class_method = $parse;

	}


	/**
	 * .m文件解释对象
	 * */
	#@Overrides
	function parseClassNested() {

		$MTypeKey = $this->getMTypeKey();
		$note = parent::getNoteFormat();
		$parse = $MTypeKey[Element::TYPE_KEY_CLASS_NESTED];
		$parse = parent::getFileContents($parse);
		if (empty($parse)){
			throw new Exception("parseClassNested TYPE_KEY_ARRAY_CLASS null!");
		}
		$parse = str_replace(Element::FORMAT_DATA_KEY, $this->name, $parse);
		$parse = str_replace(Element::FORMAT_CLASS, $this->divname, $parse);
		$parse = str_replace(Element::FORMAT_NOTE, $note, $parse);
		$this->setMClassData($parse);

	}


	/**
	 * .m文件解释启动类对象
	 * */
	#@Overrides
	function parseClass() {

		$MTypeKey = $this->getMTypeKey();
		$note = parent::getNoteFormat();
		$parse = $MTypeKey[Element::TYPE_KEY_CLASS];
		$parse = parent::getFileContents($parse);
		if (empty($parse)){
			throw new Exception("parseClass TYPE_KEY_ARRAY_CLASS null!");
		}
		$parse = str_replace(Element::FORMAT_DATA_KEY, $this->name, $parse);
		$parse = str_replace(Element::FORMAT_CLASS, $this->divname, $parse);
		$parse = str_replace(Element::FORMAT_NOTE, $note, $parse);
		$parse = str_replace(Element::FORMAT_VERSION, $this->version, $parse);

		$this->setMClassData($parse);

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
					/**累计增加所有对象*/
					$this->addMClass($element);
					/**遍历所有数组对象方法*/
					$this->addMArrayClass($element);
					$this->addClassNested($element);
					$this->addStaticParams($element);
					$this->addImportParams($element);
					$this->addClassParams($element);
				}
			}
			$nested = str_replace(Element::FORMAT_DATA_KEY, $this->name, $nested);
			$nested = str_replace(Element::FORMAT_CLASS, $this->divname, $nested);
			$nested = str_replace(Element::FORMAT_NOTE, $note, $nested);
			$this->type = Element::TYPE_KEY_CLASS_NESTED;
			$nested = str_replace(Element::FORMAT_DATA, $data, $nested);
			$this->setClassNestedData($nested);
			$this->setClassParamsData($this->divname);
			$this->parseClassNested();
		}else{
			/**共享类*/
			$this->setImportParamsData($this->divname);
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
				/**累计增加所有对象*/
				$this->addMClass($element);
				/**遍历所有数组对象方法*/
				$this->addMArrayClass($element);
				$this->addClassNested($element);
				$this->addStaticParams($element);
				$this->addImportParams($element);
				$this->addClassParams($element);
			}
		}
		$format = str_replace(Element::FORMAT_DATA, $data, $format);
		$format = str_replace(Element::FORMAT_NOTE, $note, $format);
		$format = str_replace(Element::FORMAT_VERSION, $this->version, $format);
		$format = str_replace(self::FORMAT_STATIC, $this->getStaticParams(), $format);
		$format = str_replace(self::FORMAT_IMPORT, $this->getImportParams(), $format);
		$format = str_replace(self::FORMAT_CLASS, $this->getClassParams(), $format);
		$result = $format.$this->getClassNestedData();

		/**解析.m文件*/
		$this->parseClass();


		$fileurl =$this->getFileUrl($result,$this->divname.".h");
		$m_result =$this->getMClassData();
		$fileurl =$this->getFileUrl($m_result,$this->divname.".m");
		$node = "<br /><br />--------------------------------【.m解释文件】--------------------------------";
		$result .= $node.$m_result;
		return $result;
	}


	#@Overrides
	function getStaticKey(){

		return $this->IOS_STATIC_FINAL_KEY;

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
		return $result;

	}

}
?>