<?php
include_once(dirname(__FILE__)."/../Element.php");
include_once(dirname(__FILE__)."/DataFormatListener.php");
include_once(dirname(__FILE__)."/DataParseListener.php");

/**
 * 元素结构体
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
abstract class DataElement extends Element implements DataFormatListener,DataParseListener{

	/**JSON数据*/
	const FORMAT_JSON_DATA ="{JSON}";
	/**对象类型 */
	const FORMAT_OBJECT ="{Object}";

	// 自定义名称
	public $divname;
	// 数据类型
	public $type;
	// 共享类
	public $isShare = false;

	function __construct($note = "", $parse = Element::PARSE_MODE_JAVA) {
		parent::__construct($parse);
		$this->note = $note;
	}

	/**
	 * 获取变量解析字典
	 * */
	abstract function getTypeKey();

	/**
	 * 获取变量解析json字典
	 * */
	abstract function getParseKey();

	/**
	 * 获取静态变量解析范围
	 * */
	abstract function getStaticKey();

	/**
	 * 智能判断KEY
	 * */
	abstract function autoType();
	/**
	 * 格式化分享类
	 * */
	abstract function formatGeneralClass($dictionary,$key="");

	/**
	 * 获取方法名称
	 * */
	abstract function getFunctionName();

	/**
	 * 获取解析方法名称
	 * */
	abstract function getParseName();

	/**
	 * 格式化基础数据
	 * */
	abstract function formatBasic($key);

	/**
	 * 解析json基础数据
	 * */
	abstract function parseBasic($key);

	/**
	 * 格式化静态域范围
	 * */
	abstract function formatStatic($key);


	/**
	 * 设置变量名称
	 * */
	function setName($value) {

		if (empty($value)){
			throw new Exception("setName value is null!");
		}
		$this->name = $value;
		$this->divname = $value;
	}


	/**
	 * 设置变量类型
	 * */
	function setType($value) {

		if (empty($value)){
			throw new Exception("setType value is null!");
		}

		if (!array_key_exists($value, $this->getTypeKey())) {
			throw new Exception("setType value in_array is null!");
		}

		$this->type = $value;
	}

	#@Overrides
	function formatString() {
		return $this->formatBasic(Element::TYPE_KEY_STRING);
	}
	#@Overrides
	function formatInt() {
		return $this->formatBasic(Element::TYPE_KEY_INT);
	}
	#@Overrides
	function formatLong() {
		return $this->formatBasic(Element::TYPE_KEY_LONG);
	}
	#@Overrides
	function formatFloat() {
		return $this->formatBasic(Element::TYPE_KEY_FLOAT);
	}
	#@Overrides
	function formatBool() {
		return $this->formatBasic(Element::TYPE_KEY_BOOL);
	}
	#@Overrides
	function parseString() {
		return $this->parseBasic(Element::TYPE_KEY_STRING);
	}
	#@Overrides
	function parseInt() {
		return $this->parseBasic(Element::TYPE_KEY_INT);
	}
	#@Overrides
	function parseLong() {
		return $this->parseBasic(Element::TYPE_KEY_LONG);
	}
	#@Overrides
	function parseFloat() {
		return $this->parseBasic(Element::TYPE_KEY_FLOAT);
	}
	#@Overrides
	function parseBool() {
		return $this->parseBasic(Element::TYPE_KEY_BOOL);
	}

	/**
	 * 获取基础元素
	 * */
	function getElement() {

		if($this->parse == Element::PARSE_MODE_JAVA){
			$element = new JavaElement();
		}else if($this->parse == Element::PARSE_MODE_JAVA_NATIVE){
			$element = new JavaNativeElement();
		}else if($this->parse == Element::PARSE_MODE_TXT){
			$element = new TxtElement();
		}else if($this->parse == Element::PARSE_MODE_SWIFT){
			$element = new SwiftElement();
		}else{
			$element = new IosElement();
		}
		return $element;

	}

	/**
	 * 获取名称
	 * */
	function getName($value) {

		if (empty($value)){
			throw new Exception("getName value is null!");
		}

		if(is_array($this->dictionary) && $this->dictionary[$value] instanceof ClassElement){
			$name = $this->dictionary[$value]->name;
			if(!empty($name)){
				return $name;
			}
		}
		return ucfirst($value);

	}

	/**
	 * 获取共享模式
	 * */
	function getShareMode($value) {

		if (empty($value)){
			throw new Exception("getShareMode value is null!");
		}

		if(is_array($this->dictionary) && $this->dictionary[$value] instanceof ClassElement){
			$isShare = $this->dictionary[$value]->isShare;
			return $isShare;
		}
		return false;

	}


	/**
	 * 获取类元素
	 * */
	function getClassElement($value) {

		if (empty($value)){
			throw new Exception("getClassElement value is null!");
		}
		if($this->dictionary[$value] instanceof ClassElement){
			return $this->dictionary[$value];
		}else{
			$element = new ClassElement($this->getName($value),$this->getDictionary($value),$this->getShareMode($value),$this->getType($value));
			return $element;
		}

		return $element;

	}


	/**
	 * 获取数组基础类型
	 * */
	function getArrayType($value){

		if(!is_array($value)){
			return Element::TYPE_KEY_STRING;
		}
		$type = "";
		foreach ($value as $key => $data) {
			if(is_bool($data)){
				$item_type = Element::TYPE_KEY_BOOLEAN;
			}else if(is_numeric($data)){
				if(strpos($data,'.')){
					$item_type = Element::TYPE_KEY_FLOAT;
					if($type == Element::TYPE_KEY_INT){
						//float向下兼容int
						$type = Element::TYPE_KEY_FLOAT;
					}

				}else{
					$value = intval($data);
					if($value > 2147483647/2){
						$item_type = Element::TYPE_KEY_LONG;
						if($type == Element::TYPE_KEY_INT){
							//long向下兼容int
							$type = Element::TYPE_KEY_LONG;
						}
					}else{
						$item_type = Element::TYPE_KEY_INT;
						if($type == Element::TYPE_KEY_FLOAT || $type == Element::TYPE_KEY_LONG ){
							//int向上继承float与long
							$item_type = $type;
						}
					}
				}
			}else{
				$item_type = Element::TYPE_KEY_STRING;
			}

			if(empty($type)){
				$type = $item_type;
			}else if(strpos($type,$item_type) === false){
				return Element::TYPE_KEY_STRING;
			}
		}
		return $item_type;
	}


	/**
	 * 初始化基础元素
	 * */
	function initElement($name = "", $value = "", $element, $note_type = Element::NOTE_TYPE_DEFAULT) {


		$divname = $element->name;
		$isShare = $element->isShare;
		$note = $element->note;
		$type = $element->type;

		$this->name = $name;
		$this->divname = $divname;
		$this->isShare = $isShare;
		$this->value = $value;
		$this->note = $note;
		$this->type = $type;
		$this->note_type = $note_type;

		if(empty($note)){
			$this->note = $name;
			//开启自动翻译
			$this->setNoteType(Element::NOTE_TYPE_AUTO);

		}else if(!empty($note) && is_array($note)){
			foreach ($note as $key => $value) {
				if($value != null && is_array($value)){
					$this->note = $key;
					$this->dictionary = $value;
				}else if($value != null){
					$this->note = "";
					$this->dictionary = $note;
				}
			}
		}else if($note instanceof RangeElement){
			/**范围解析体*/
			$this->note = $note->note;
			$this->dictionary = $note->range;
			$this->setNoteType($note->note_type);
		}
	}

	/**
	 * 获取文件下载地址
	 * */
	function getFileUrl($value, $filename) {

		if (empty($value)){
			return "";
		}
		$value = str_replace("&lt;","<",$value);
		$value = str_replace("&gt;",">",$value);
		$value = str_replace(Element::FORMAT_SPLACE,"	",$value);
		$value = str_replace(Element::FORMAT_ENTER,"\r\n",$value);
		$value = str_replace(Element::ECHO_ENTER,"",$value);
		$value = str_replace(Element::ECHO_SPLACE,"",$value);

		if($this->parse == Element::PARSE_MODE_JAVA){
			$path = getcwd().JAVA_DATA_SAVE_PATH;
		}else if($this->parse == Element::PARSE_MODE_JAVA_NATIVE){
			$path = getcwd().JAVA_NATIVE_DATA_SAVE_PATH;
		}else if($this->parse == Element::PARSE_MODE_TXT){
			$path = getcwd().TXT_DATA_SAVE_PATH;
		}else if($this->parse == Element::PARSE_MODE_SWIFT){
			$path = getcwd().SWIFT_DATA_SAVE_PATH;
		}else{

		}
		@mkdir($path, 0777, true);
		file_put_contents($path.$filename, $value);
		$result = "<input type=button value=↓下载数据类↓$filename  onclick=\"window.open('../document_sdk/FileDownLoad.php?filename=$filename&amp;parse=".$this->parse."')\"/>";
		$this->setFileList($result);
		return $result;

	}



	/**
	 * 格式化数据
	 * */
	function format() {


		if (empty($this->value)){
			throw new Exception("format value is null!");
		}

		if (empty($this->name)){
			throw new Exception("format name is null!");
		}

		if (empty($this->dictionary) && empty($this->note)){
			throw new Exception("format dictionary or note is null!");
		}

		if(empty($this->type)){
			$this->autoType();
		}
		//echo $this->name."___".$this->type."<br />";
		$result = $this->controller($this->getFunctionName());
		return $result;

	}

	/**
	 * 格式化通用数据
	 * */
	function formatGeneral(){
		$result = $this->formatGeneralClass($this->dictionary);
		return $result;
	}


	/**
	 * 解析数据
	 * */
	function parse() {

		if (empty($this->value)){
			throw new Exception("parse value is null!");
		}

		if (empty($this->name)){
			throw new Exception("parse name is null!");
		}

		if (empty($this->dictionary) && empty($this->note)){
			throw new Exception("parse dictionary or note is null!");
		}

		if(empty($this->type)){
			$this->autoType();
		}
		$result = $this->controller($this->getParseName());
		return $result;

	}

	/**
	 * 打开共享模式
	 * */
	function openShareMode() {
		$this->isShare = true;
	}



}
?>