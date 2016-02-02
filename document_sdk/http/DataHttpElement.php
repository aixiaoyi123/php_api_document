<?php
include_once(dirname(__FILE__)."/../Element.php");
include_once(dirname(__FILE__)."/../element/HttpElement.php");
include_once(dirname(__FILE__)."/DataHttpListener.php");


/**
 * HTTP结构体
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
abstract class DataHttpElement extends Element implements DataHttpListener{

	/**url地址*/
	const HTTP_URL ="{url}";
	/**请求固定参数*/
	const HTTP_FINAL ="{value}";
	/**请求参数*/
	const HTTP_PARAMS ="{params}";
	/**是否是POST模式*/
	const HTTP_POST ="{post}";
	/**是否是COOKIE模式*/
	const HTTP_COOKIE ="{cookie}";
	/**是否是获取COOKIE模式*/
	const HTTP_GETCOOKIE ="{getcookie}";
	/**是否是缓存模式*/
	const HTTP_CACHE ="{cache}";
	/**json返回解析tab关键域*/
	const HTTP_TAB ="{tab}";
	/**是够gson序列化*/
	const HTTP_GSON ="{gson}";
	/**json结果*/
	const HTTP_JSON_RESULT ="{arraylist}";

	/**文件参数*/
	const HTTP_KEY_FILE = "file";
	/**文件路径设置*/
	const HTTP_KEY_FILE_PATH = "file_path";
	/**结果解析*/
	const HTTP_KEY_OBJECT = "object";
	/**结果数组解析*/
	const HTTP_KEY_OBJECT_LIST = "object_list";
	/**对象*/
	const HTTP_KEY_RESULT = "result";
	/**对象数组*/
	const HTTP_KEY_RESULT_LIST = "result_list";
	/**整体*/
	const HTTP_KEY_HTTP = "http";

	// 返回数据名称
	public $base_name;

	// 数据类型
	public $type;

	// 数据类型
	public $element;

	// 是否是数组
	public $isListMode = false;

	// 请求固定参数
	public $final;

	function __construct($name = "", $note = "", $element = null, $parse = Element::PARSE_MODE_JAVA) {
		parent::__construct($parse);
		$this->name = $name;
		$this->note = $note;
		$this->element = $element;
	}

	/**
	 * 获取HTTP解析字典
	 * */
	abstract function getHttpKey();

	/**
	 * 获取HTTP常量请求字典
	 * */
	abstract function getFinalKey();


	/**
	 * 智能判断KEY
	 * */
	abstract function autoType();

	/**
	 * http请求基础数据
	 * */
	abstract function httpBasic($key, $value);

	/**
	 * 获取方法名称
	 * */
	abstract function getFunctionName();

	/**
	 * 获取静态变量解析范围
	 * */
	abstract function getStaticKey();

	/**
	 * 格式化静态域范围
	 * */
	abstract function formatStatic($key);

	#@Overrides
	function httpString() {
		return $this->httpBasic(Element::TYPE_KEY_STRING, ucfirst($this->name));
	}
	#@Overrides
	function httpInt() {
		return $this->httpBasic(Element::TYPE_KEY_INT, ucfirst($this->name));
	}
	#@Overrides
	function httpLong() {
		return $this->httpBasic(Element::TYPE_KEY_LONG, ucfirst($this->name));
	}
	#@Overrides
	function httpFloat() {
		return $this->httpBasic(Element::TYPE_KEY_FLOAT, ucfirst($this->name));
	}
	#@Overrides
	function httpBool() {
		return $this->httpBasic(Element::TYPE_KEY_BOOLEAN, ucfirst($this->name));
	}

	/**
	 * 设置变量类型
	 * */
	function setElement($value) {

		if (empty($value)){
			$this->element = new HttpElement();
		}else{
			$this->element = $value;
		}
	}

	/**
	 * 设置数据名称
	 * */
	function setBaseName($value) {

		if (empty($value)){
			throw new Exception("setBaseName value is null!");
		}

		$this->base_name = $value;
	}


	/**
	 * 设置变量类型
	 * */
	function setType($value) {

		if (empty($value)){
			throw new Exception("setType value is null!");
		}

		if (!array_key_exists($value, $this->getHttpKey())) {
			throw new Exception("setType value in_array is null!");
		}

		$this->type = $value;
	}

	/**
	 * 打开列表模式
	 * */
	function openListMode() {

		$this->isListMode = true;

	}


	/**
	 * 获取基础元素
	 * */
	function getElement() {

		if($this->parse == Element::PARSE_MODE_JAVA){
			$element = new JavaHttpElement();
		}else if($this->parse == Element::PARSE_MODE_JAVA_NATIVE){
			$element = new JavaNativeHttpElement();
		}else if($this->parse == Element::PARSE_MODE_TXT){
			$element = new TxtHttpElement();
		}else if($this->parse == Element::PARSE_MODE_SWIFT){
			$element = new SwiftHttpElement();
		}else if($this->parse == Element::PARSE_MODE_IOS){
			$element = new IosHttpElement();
		}else{

		}
		return $element;

	}


	/**
	 * 获取类元素
	 * */
	function getNoteElement($value) {

		if (empty($value)){
			throw new Exception("getNoteElement value is null!");
		}

		if($this->dictionary[$value] instanceof FinalElement){
			$element = new NoteElement($this->dictionary[$value],$this->getType($value));
			return $element;
		}else if($this->dictionary[$value] instanceof RangeElement){
			$element = new NoteElement($this->dictionary[$value],$this->getType($value));
			return $element;
		}else if($this->dictionary[$value] instanceof NoteElement){
			return $this->dictionary[$value];
		}else{
			$element = new NoteElement($this->getDictionary($value),$this->getType($value));
			return $element;
		}

		return $element;

	}


	/**
	 * 初始化基础元素
	 * */
	function initElement($name = "", $value = "", $element, $note_type = Element::NOTE_TYPE_DEFAULT) {


		$note = $element->note;
		$type = $element->type;

		$this->name = $name;
		$this->value = $value;
		$this->note = $note;
		$this->type = $type;
		$this->note_type = $note_type;

		if(empty($note)){

			$this->note = $name;
			//开启自动翻译
			$this->setNoteType(Element::NOTE_TYPE_AUTO);

		}else if($note instanceof FinalElement){
			/**常量请求解析体*/
			$this->note = $note->note;
			$this->type = $note->type;
			$this->final = $note->final;
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
		$value = str_replace(Element::FORMAT_SPLACE," ",$value);
		$value = str_replace(Element::FORMAT_ENTER,"\r\n",$value);
		$value = str_replace(Element::ECHO_ENTER,"",$value);
		$value = str_replace(Element::ECHO_SPLACE,"",$value);

		$cwd = $this->getSavePath();

		if($this->parse == Element::PARSE_MODE_JAVA){
			$path = $cwd.JAVA_HTTP_DATA_SAVE_PATH;
		}else if($this->parse == Element::PARSE_MODE_JAVA_NATIVE){
			$path = $cwd.JAVA_NATIVE_HTTP_DATA_SAVE_PATH;
		}else if($this->parse == Element::PARSE_MODE_TXT){
			$path = $cwd.TXT_HTTP_DATA_SAVE_PATH;
		}else if($this->parse == Element::PARSE_MODE_SWIFT){
			$path = $cwd.SWIFT_HTTP_DATA_SAVE_PATH;
		}else if($this->parse == Element::PARSE_MODE_IOS){
			$path = $cwd.IOS_HTTP_DATA_SAVE_PATH;
		}else{

		}

		@mkdir($path, 0777, true);
		file_put_contents($path.$filename, $value);
		return 	$this->getSaveFileUrl('↓下载请求类↓', $filename, true);

	}


	/**
	 * http数据
	 * */
	function http() {


		if (!isset($this->value) || $this->value == ""){
			$this->value = " ";
		}

		if (empty($this->name)){
			throw new Exception("http name is null!");
		}

		if(empty($this->type)){
			$this->autoType();
		}
		//echo $this->name."___".$this->type."<br />";
		$result = $this->controller($this->getFunctionName());
		return $result;

	}


}
?>