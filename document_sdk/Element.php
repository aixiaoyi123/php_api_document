<?php
include_once(dirname(__FILE__)."/Config.php");
include_once(dirname(__FILE__)."/element/ClassElement.php");
include_once(dirname(__FILE__)."/element/RangeElement.php");
include_once(dirname(__FILE__)."/element/FileElement.php");
include_once(dirname(__FILE__)."/baidu_language_api.php");

/**
 * 结构体
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
class Element{

	// 换行符号
	const ECHO_ENTER = "<br />";
	// 空格符号
	const ECHO_SPLACE = "&nbsp;&nbsp;";

	// 数据KEY类型
	/**字符串*/
	const TYPE_KEY_STRING = "String";
	/**4位整型*/
	const TYPE_KEY_INT = "int";
	/**长整形*/
	const TYPE_KEY_LONG = "long";
	/**浮点数*/
	const TYPE_KEY_FLOAT = "float";
	/**布尔型*/
	const TYPE_KEY_BOOLEAN = "boolean";
	/**数组队列*/
	const TYPE_KEY_ARRAY = "array";
	/**自定义类数组队列*/
	const TYPE_KEY_ARRAY_CLASS = "array_class";
	/**自定义类*/
	const TYPE_KEY_CLASS_CHILD = "class_child";
	/**类*/
	const TYPE_KEY_CLASS = "class";
	/**内部类函数*/
	const TYPE_KEY_CLASS_NESTED = "class_nested";
	/**头部引用*/
	const TYPE_KEY_HEAD = "head";

	/**note类型映射表*/
	const NOTE_TYPE_DEFAULT = "default";
	const NOTE_TYPE_AUTO = "auto";

	/**数据*/
	const FORMAT_DATA ="{...}";
	/**数据名称 */
	const FORMAT_DATA_KEY ="{?}";
	/**对象名称 */
	const FORMAT_CLASS ="{!}";
	/**注解格式*/
	const FORMAT_NOTE = "{note}";
	/**空格格式 */
	const FORMAT_SPLACE ="[ ]";
	/**回车格式 */
	const FORMAT_ENTER ="[^]";
	/**静态注解格式*/
	const FORMAT_STATIC_NOTE = "/** {?} */";
	/**版本号 */
	const FORMAT_VERSION ="{version}";

	/**解析类型*/
	const PARSE_MODE_JAVA = "java";
	const PARSE_MODE_IOS = "ios";
	const PARSE_MODE_TXT = "txt";
	const PARSE_MODE_SWIFT = "swift";

	// 变量名称
	public $name;
	// 解析方式
	public $parse;
	// 注解
	public $note = "";
	// 注解
	public $note_type = self::NOTE_TYPE_DEFAULT;
	// 数据
	public $value;
	// 字典
	public $dictionary;
	// 版本号
	public $version;
	// 文件列表
	public $filelist = array();


	function __construct($parse = self::PARSE_MODE_JAVA) {
		$this->parse = $parse;
	}

	/**
	 * 增加下载文件入口
	 * */
	function setFileList($data){
		
		if(!empty($data)){
			$this->filelist[] = $data;
		}
		
	}
	
	/**
	 * 获取所有文件下载
	 * */
	function getFileList(){

		$file = "";
		foreach ($this->filelist as $key => $value) {
			$file .= $value.self::ECHO_SPLACE;
		}
		return $file;
	}
	
	

	/**
	 * 设置解析方法
	 * */
	function setParse($value) {

		if (empty($value)){
			throw new Exception("setParse value is null!");
		}
		$this->parse = $value;

	}

	/**
	 * 设置版本号
	 * */
	function setVersion($value) {

		$this->version = $value;

	}


	/**
	 * 设置注释
	 * */
	function setNote($value) {

		if (empty($value)){
			throw new Exception("setNote value is null!");
		}
		$this->note = $value;

	}

	/**
	 * 设置变量名称
	 * */
	function setName($value) {

		if (empty($value)){
			throw new Exception("setName value is null!");
		}
		$this->name = $value;
	}

	/**
	 * 设置注解类型
	 * */
	function setNoteType($value) {

		if (empty($value)){
			throw new Exception("setNoteType value is null!");
		}
		if(OPEN_LANGUAGE_MODE === false){
			$this->note_type = self::NOTE_TYPE_DEFAULT;
		}else{
			$this->note_type = $value;
		}
	}


	/**
	 * 设置数据
	 * */
	function setValue($value) {

		if (empty($value)){
			throw new Exception("setValue value is null!");
		}
		$this->value = $value;

	}

	/**
	 * 动态方法
	 * */
	function controller($fun){
		if(empty($fun))
		return "";
		if(method_exists($this, $fun)) {
			return $this->$fun();
		}else {
			throw new Exception( "function {$fun} undefine!");
		}
	}

	/**
	 * 设置字典
	 * */
	function setDictionary($value) {

		if (empty($value)){
			throw new Exception("setDictionary value is null!");
		}
		$this->dictionary = $value;
	}


	/**
	 * 获取字典数据
	 * */
	function getDictionary($value) {

		if (empty($value)){
			throw new Exception("getDictionary value is null!");
		}

		if($this->dictionary[$value] instanceof RangeElement){
			return $this->dictionary[$value];
		}else if($this->dictionary[$value] instanceof NoteElement){
			return $this->dictionary[$value]->note;
		}else{
			return $this->dictionary[$value];
		}
	}

	/**
	 * 获取字典特殊类型
	 * */
	function getType($value) {

		if (empty($value)){
			throw new Exception("getType value is null!");
		}

		if($this->dictionary[$value] instanceof NoteElement){
			return $this->dictionary[$value]->type;
		}else{
			return "";
		}
	}

	/**
	 * 获取文件内容
	 * */
	function getFileContents($value) {
			
		if (empty($value)){
			throw new Exception("getFileContents value is null!");
		}

		if(file_exists($value)){
			$contents = file_get_contents($value);
		}else{
			throw new Exception("getFileContents $value no exists!");
		}

		return $contents;
	}


	/**
	 * 获取注释
	 * */
	public function getNoteFormat() {

		if(empty($this->note)){
			//return "";
		}
		if($this->note_type == Element::NOTE_TYPE_AUTO && preg_match("/^[a-zA-Z\s]+$/",$this->note)){
			$az = language_new_az($this->note);
			if(!empty($az)){
				$this->note = $az;
			}
		}
		return $this->note;

	}


	/**
	 * 后去固定头
	 * */
	function getHeadUrl() {


		$url = $_SERVER['PHP_SELF'];
		$arr = explode( '/' , $url );
		$filename= $arr[count($arr)-1];
		$data = array("API"=> "API输出数据",
		self::PARSE_MODE_TXT=> "文本文档",
		self::PARSE_MODE_JAVA=> "JAVA请求与解析代码",
		self::PARSE_MODE_SWIFT=> "Swift1.2请求与解析代码");

		foreach ($data as $key => $value) {
			$document = ($_POST['document']=='')?urldecode($_GET['document']):$_POST['document'];
			if($key != $this->parse){
				if($key == "API"){
					$document = "";
				}
				$result .= "<input type=button value=点击查看$value  onclick=\"window.open('../document/$filename?document=$document&amp;parse=$key')\"/>";
				$result .=self::ECHO_SPLACE;
			}
		}
		return self::ECHO_ENTER.$result.self::ECHO_ENTER.self::ECHO_ENTER;

	}


}
?>