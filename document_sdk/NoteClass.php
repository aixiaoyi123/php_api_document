<?php
include_once(dirname(__FILE__)."/java/JavaElement.php");
include_once(dirname(__FILE__)."/javanative/JavaNativeElement.php");
include_once(dirname(__FILE__)."/ios/IosElement.php");
include_once(dirname(__FILE__)."/ios/IosHttpElement.php");
include_once(dirname(__FILE__)."/txt/TxtElement.php");
include_once(dirname(__FILE__)."/swift/SwiftElement.php");
include_once(dirname(__FILE__)."/swift/SwiftHttpElement.php");
include_once(dirname(__FILE__)."/java/JavaHttpElement.php");
include_once(dirname(__FILE__)."/javanative/JavaNativeHttpElement.php");
include_once(dirname(__FILE__)."/txt/TxtHttpElement.php");
include_once(dirname(__FILE__)."/HttpParamsListener.php");

/**
 * 注释集合
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
abstract class NoteClass{

	function __construct() {

	}

	// 输出结果
	public $result;

	// 文件列表
	public $filelist = array();

	/**
	 * 增加下载文件入口
	 * */
	function setFileList($data){

		if(!empty($data)){
			$this->filelist[] = $data;
		}

	}

	/**
	 * 获取所有文件下载输出
	 * */
	function getFileList(){

		$file = "";
		foreach ($this->filelist as $key => $value) {
			$file .= $value;
		}
		$node = "--------------------------------【数据输出】--------------------------------<br /><br />";
		return $node.$file.Element::ECHO_ENTER.Element::ECHO_ENTER;
	}


	/**
	 * 获取类名称
	 * */
	abstract function getName();

	/**
	 * 获取类注解
	 * */
	abstract function getNote();

	/**
	 * 获取类字典映射
	 * */
	abstract function getKeys();

	/**
	 * 获取数值
	 * */
	abstract function getValue();

	/**
	 * 是否是通用数据模式
	 * */
	abstract function isGeneralMode();

	/**
	 * 获取字典集合
	 * */
	function getDictionary(){

		$keys = $this->getKeys();
		$note = $this->getNote();
		$name = $this->getName();
		if(empty($note)){
			$dictionary = $keys;
		}else{
			$dictionary = array($note => $keys);
		}
		$isShare = $this->isGeneralMode();
		if($isShare){
			/**共用数据模式*/
			$element = new ClassElement($name,$dictionary,true);
		}else{
			$element = $dictionary;
		}
		return $element;

	}

	/**
	 * 数据整合
	 * */
	function getElement($element){

		$note = $this->getNote();
		if(!empty($note)){
			$element->setNote($note);
		}
		$name = $this->getName();
		if(!empty($name)){
			$element->setName($name);
		}
		$value = $this->getValue();
		if(!empty($value)){
			$element->setValue($value);
		}

		$dictionary = $this->getDictionary();
		if(is_array($dictionary)){
			$data = $dictionary[$note];
		}else if($dictionary instanceof ClassElement){
			$data = $dictionary->note;
		}
		$element->setDictionary($data);

		if(isset($data) && !is_array($data) && ($data instanceof ClassElement)){
			//输出数据全为共享数据体
			$value = array();
			$value['data'] = $element->value;
			$dictionary = array();
			$dictionary['data'] = $data;
			$element->setValue($value);
			$element->setDictionary($dictionary);
		}

		return $element;

	}

	/**
	 * 数据整合
	 * */
	function format($value,$parse = Element::PARSE_MODE_JAVA){

		$element = $this->getDictionary();

		if($element instanceof ClassElement){
			$data = $this->getValue();
			if(!empty($data)){
				$value = $data;
			}

			if(is_array($value)){
				if (array_key_exists(0,$value)){
					$value = $value[0];
				}
			}

			if($parse == Element::PARSE_MODE_JAVA){
				return $element->getJavaElement($value);
			}else if($parse == Element::PARSE_MODE_TXT){
				return $element->getTxtElement($value);
			}else if($parse == Element::PARSE_MODE_SWIFT){
				return $element->getSwiftElement($value);
			}else if($parse == Element::PARSE_MODE_JAVA_NATIVE){
				return $element->getJavaNativeElement($value);
			}else if($parse == Element::PARSE_MODE_IOS){
				return $element->getIosElement($value);
			}else{
				return $element->getIosElement($value);
			}
			return $element;
		}
		return null;

	}


	/**
	 * 执行总流程
	 * */
	function document_format($value, $parse = Element::PARSE_MODE_JAVA){

		if($parse == Element::PARSE_MODE_JAVA){
			$data = new JavaElement();
		}else if($parse == Element::PARSE_MODE_JAVA_NATIVE){
			$data = new JavaNativeElement();
		}else if($parse == Element::PARSE_MODE_TXT){
			$data = new TxtElement();
		}else if($parse == Element::PARSE_MODE_SWIFT){
			$data = new SwiftElement();
		}else if($parse == Element::PARSE_MODE_IOS){
			$data = new IosElement();
		}else{
			$data = new IosElement();
		}
		$data->setType(Element::TYPE_KEY_CLASS);
		$data ->setValue($value);
		$data ->setVersion($this->getVerison());
		$data = $this->getElement($data);
		if(!$this->isGeneralMode()){
			$end = $data->format();
			$end = str_replace(Element::FORMAT_SPLACE,Element::ECHO_SPLACE,$end);
			$end = str_replace(Element::FORMAT_ENTER,Element::ECHO_ENTER,$end);
		}else{
			$end = "";
		}

		$general = $data->formatGeneral();
		$general = str_replace(Element::FORMAT_SPLACE,Element::ECHO_SPLACE,$general);
		$general = str_replace(Element::FORMAT_ENTER,Element::ECHO_ENTER,$general);
		$this->setFileList($data->getFileList());
		$this->result .= $end."<br />";

		if(!empty($general)){
			$general = "<br />--------------------------------【公用数据类】--------------------------------".$general;
		}
		$this->result .= $general;
		$this->result =$data->getHeadUrl().$this->getFileList().$this->result;

		$js = $data->getFileContents('/js/download.js');
		$base64js = $data->getFileContents('/js/jbase64.js');
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			echo $base64js.$js.$this->result;
		}else{
			iconv_echo($base64js.$js.$this->result);
		}

	}

	/**
	 * 执行总输入
	 * */
	function document_http($element,$value,$parse = Element::PARSE_MODE_JAVA){

		$name = $this->getName();
		$basename = $this->getName();
		$name = str_replace("Data", "Http", $name);
		if(strpos($name, "Http") === false){
			$name .= "Http";
		}
		$note = $this->getNote();
		if($parse == Element::PARSE_MODE_JAVA){
			$data = new JavaHttpElement();
		}else if($parse == Element::PARSE_MODE_JAVA_NATIVE){
			$data = new JavaNativeHttpElement();
		}else if($parse == Element::PARSE_MODE_TXT){
			$data = new TxtHttpElement();
		}else if($parse == Element::PARSE_MODE_SWIFT){
			$data = new SwiftHttpElement();
		}else if($parse == Element::PARSE_MODE_IOS){
			$data = new IosHttpElement();
		}else{

		}
		$data->setName($name);
		$data->setNote($note."请求");
		$data->setParse($parse);
		$data->setType(DataHttpElement::HTTP_KEY_HTTP);
		$httpelement = $element->getHttpElement();
		$data->setElement($httpelement);
		$data ->setValue($element->getHttpParamsValue());
		$data ->setDictionary($element->getHttpKeys());
		$data ->setVersion($this->getVerison());

		if($httpelement->array){
			$data ->openListMode();
		}

		if(is_array($value)){
			if (array_key_exists(0,$value)){
				$data ->openListMode();
			}
		}

		$data ->setBaseName($basename);
		$end = $data->http();
		$end = str_replace(Element::FORMAT_SPLACE,Element::ECHO_SPLACE,$end);
		$end = str_replace(Element::FORMAT_ENTER,Element::ECHO_ENTER,$end);

		$this->setFileList($data->getFileList());
		$this->result .= $end;



	}

	/**
	 * 获取版本号
	 * */
	function getVerison(){
		$name = $this->getName();
		$cwd = dirname(__FILE__);
		$cwd = str_replace("document_sdk", "document", $cwd);
		$path = $cwd . "/Class.$name.php";
		if(!file_exists($path)){
			$path = $cwd . "/data/Class.$name.php";
		}
		$version = filemtime($path);
		date_default_timezone_set("Asia/Shanghai");
		$version = date("Ymd.H.i",$version);
		return $version;
	}




}
?>