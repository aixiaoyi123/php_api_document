<?php
include_once(dirname(__FILE__)."/../java/JavaHttpElement.php");

/**
 * Swift Http请求结构体
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
class SwiftHttpElement extends JavaHttpElement{

	// Swift http映射表
	public $SWIFT_HTTP_KEY = array(
	/**字符串*/
	Element::TYPE_KEY_STRING                => '/swiftpan/http/string.swift',
	/**4位整型*/
	Element::TYPE_KEY_INT        	        => "/swiftpan/http/int.swift",
	/**长整形*/
	Element::TYPE_KEY_LONG                  => "/swiftpan/http/long.swift",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT                 => "/swiftpan/http/float.swift",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN               => "/swiftpan/http/boolean.swift",
	/**文件参数*/
	DataHttpElement::HTTP_KEY_FILE          => "/swiftpan/http/file.swift",
	/**文件路径设置*/
	DataHttpElement::HTTP_KEY_FILE_PATH     => "/swiftpan/http/filepath.swift",
	/**结果解析*/
	DataHttpElement::HTTP_KEY_OBJECT        => "/swiftpan/http/object.swift",
	/**结果数组解析*/
	DataHttpElement::HTTP_KEY_OBJECT_LIST   => "/swiftpan/http/object_list.swift",
	/**整体*/
	DataHttpElement::HTTP_KEY_HTTP          => "/swiftpan/http/http.swift"
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

	// 静态常量定义
	public $static_params = array();

	/**静态名称 */
	const FORMAT_STATIC ="{static}";

	/**设置URL的参数 */
	const FORMAT_URL_PARAMS ="\"{!}\":\"\\(m{?})\"";

	//构造方法
	function __construct() {
		parent::__construct();
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

		if($element instanceof SwiftHttpElement){
			//嵌套类型
			foreach ($element->static_params as $key => $value) {
				if(!empty($value)){
					$this->static_params[] = $value;
				}
			}
		}

	}


	#@Overrides
	function getHttpKey(){

		return $this->SWIFT_HTTP_KEY;

	}

	#@Overrides
	function httpBasic($key, $value) {

		$HttpKey = $this->getHttpKey();
		if(empty($this->base_name)){
			$note = parent::getNoteFormat();
		}
		if (!array_key_exists($key,$HttpKey)){
			throw new Exception("httpBasic HttpKey no found $key !");
		}
		$http = $HttpKey[$key];
		$http = parent::getFileContents($http);
		$http = str_replace(Element::FORMAT_DATA_KEY, $value, $http);
		$result = $http;
		if(isset($note)){
			$result = str_replace(Element::FORMAT_NOTE, $note, $result);
		}
		$static = $this->formatStatic($key);
		if(!empty($static)){
			$this->setStaticParamsData($static);
		}
		return $result;

	}


	#@Overrides
	function httpFile() {

		$HttpKey = $this->getHttpKey();
		$note = parent::getNoteFormat();

		$file = $HttpKey[DataHttpElement::HTTP_KEY_FILE];
		$file = parent::getFileContents($file);
		$filepath = $HttpKey[DataHttpElement::HTTP_KEY_FILE_PATH];
		$filepath = parent::getFileContents($filepath);

		$path = "";
		if (is_array($this->value)){
			//多文件上传情况
			foreach ($this->value as $key => $value) {
				if($value != null){
					$path .= str_replace(Element::FORMAT_DATA_KEY, $value, $filepath);
				}
			}
		}else{
			$path .= str_replace(Element::FORMAT_DATA_KEY, $this->name, $filepath);
		}
		$file = str_replace(Element::FORMAT_DATA, $path, $file);
		$file = str_replace(Element::FORMAT_NOTE, $note, $file);
		return $file;

	}

	/**
	 * 结果解析
	 * */
	function httpObject(){
		return $this->httpBasic(DataHttpElement::HTTP_KEY_OBJECT, $this->base_name);
	}

	/**
	 * 结果数组解析
	 * */
	function httpObjectList(){
		return $this->httpBasic(DataHttpElement::HTTP_KEY_OBJECT_LIST, $this->base_name);
	}

	#@Overrides
	function httpHttp() {

		if($this->isListMode === false){
			//if($this->element->gson === false){
			$object = $this->httpObject();
			//}
		}else{
			//if($this->element->gson === false){
			$object = $this->httpObjectList();
			//}
		}


		$HttpKey = $this->getHttpKey();
		$note = parent::getNoteFormat();
		if (!is_array($this->value)){
			throw new Exception("httpHttp is_array error!");
		}
		$http = $HttpKey[DataHttpElement::HTTP_KEY_HTTP];
		$http = parent::getFileContents($http);

		$http = str_replace(Element::FORMAT_CLASS, $this->name, $http);
		$data = "";
		$params = "";

		foreach ($this->value as $key => $value) {
			$element = $this->getElement();
			$element->initElement($key,$value,$this->getNoteElement($key));
			$data = $data.$element->http();
			$this->addStaticParams($element);
			if($element->type != DataHttpElement::HTTP_KEY_FILE){
				$urlparams = str_replace(Element::FORMAT_CLASS, $key, self::FORMAT_URL_PARAMS);
				$urlparams = str_replace(Element::FORMAT_DATA_KEY, ucfirst($element->name), $urlparams);
				$params .= $urlparams.",";
			}
		}

		if(!empty($params)){
			$params = substr($params, 0, strlen($params)-1);
		}
		$data .= $object;
		$http = str_replace(Element::FORMAT_DATA, $data, $http);

		$url = $this->element->url;
		$http = str_replace(DataHttpElement::HTTP_URL, $url, $http);

		$http = str_replace(DataHttpElement::HTTP_PARAMS, $params, $http);
			
		$post = $this->element->post;
		if($post === false){
			$http = str_replace(DataHttpElement::HTTP_POST, "false", $http);
		}else{
			$http = str_replace(DataHttpElement::HTTP_POST, "true", $http);
		}
			
		$cookie = $this->element->cookie;
		if($cookie === false){
			$http = str_replace(DataHttpElement::HTTP_COOKIE, "false", $http);
		}else{
			$http = str_replace(DataHttpElement::HTTP_COOKIE, "true", $http);
		}
			
		$getcookie= $this->element->getcookie;
		if($getcookie === false){
			$http = str_replace(DataHttpElement::HTTP_GETCOOKIE, "false", $http);
		}else{
			$http = str_replace(DataHttpElement::HTTP_GETCOOKIE, "true", $http);
		}
			
		$tab= $this->element->tab;
		if(empty($tab)){
			$http = str_replace(DataHttpElement::HTTP_TAB, "null", $http);
		}else{
			$http = str_replace(DataHttpElement::HTTP_TAB, "\"$tab\"", $http);
		}


		$http = str_replace(Element::FORMAT_NOTE, $note, $http);
		$http = str_replace(Element::FORMAT_VERSION, $this->version, $http);
		$http = str_replace(self::FORMAT_STATIC, $this->getStaticParams(), $http);

		$result = $http;
		$fileurl =$this->getFileUrl($result,$this->name.".swift");
		return $result;



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
			return "";
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