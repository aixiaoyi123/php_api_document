<?php
include_once(dirname(__FILE__)."/../http/DataHttpElement.php");
include_once(dirname(__FILE__)."/JavaHttpListener.php");

/**
 * JAVA Http请求结构体
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
class JavaHttpElement extends DataHttpElement implements JavaHttpListener{

	// JAVA http映射表
	public $JAVA_HTTP_KEY = array(
	/**字符串*/
	Element::TYPE_KEY_STRING                => '/javapan/http/string.java',
	/**4位整型*/
	Element::TYPE_KEY_INT        	        => "/javapan/http/int.java",
	/**长整形*/
	Element::TYPE_KEY_LONG                  => "/javapan/http/long.java",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT                 => "/javapan/http/float.java",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN               => "/javapan/http/boolean.java",
	/**文件参数*/
	DataHttpElement::HTTP_KEY_FILE          => "/javapan/http/file.java",
	/**文件路径设置*/
	DataHttpElement::HTTP_KEY_FILE_PATH     => "/javapan/http/filepath.java",
	/**结果解析*/
	DataHttpElement::HTTP_KEY_OBJECT        => "/javapan/http/object.java",
	/**结果数组解析*/
	DataHttpElement::HTTP_KEY_OBJECT_LIST   => "/javapan/http/object_list.java",
	/**对象*/
	DataHttpElement::HTTP_KEY_RESULT        => "/javapan/http/result.java",
	/**对象数组*/
	DataHttpElement::HTTP_KEY_RESULT_LIST   => "/javapan/http/result_list.java",
	/**整体*/
	DataHttpElement::HTTP_KEY_HTTP          => "/javapan/http/http.java",
	/**头部引用*/
	Element::TYPE_KEY_HEAD     	  	        => JAVA_HEAD
	/**待扩展*/
	);


	//JAVA http方法映射表
	public $JAVA_HTTP_FUNCTION = array(
	/**字符串*/
	Element::TYPE_KEY_STRING                => 'httpString',
	/**4位整型*/
	Element::TYPE_KEY_INT        	        => "httpInt",
	/**长整形*/
	Element::TYPE_KEY_LONG                  => "httpLong",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT                 => "httpFloat",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN               => "httpBool",
	/**文件参数*/
	DataHttpElement::HTTP_KEY_FILE          => "httpFile",
	/**结果解析*/
	DataHttpElement::HTTP_KEY_OBJECT        => "httpObject",
	/**结果数组解析*/
	DataHttpElement::HTTP_KEY_OBJECT_LIST   => "httpObjectList",
	/**对象*/
	DataHttpElement::HTTP_KEY_RESULT        => "httpResult",
	/**对象数组*/
	DataHttpElement::HTTP_KEY_RESULT_LIST   => "httpResultList",
	/**整体*/
	DataHttpElement::HTTP_KEY_HTTP          => "httpHttp",
	/**头部引用*/
	Element::TYPE_KEY_HEAD     	  	        => "httpHead"
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
	function __construct() {
		parent::__construct();
	}

	#@Overrides
	function getHttpKey(){

		return $this->JAVA_HTTP_KEY;

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
	function getFunctionName(){

		if (!array_key_exists($this->type, $this->JAVA_HTTP_FUNCTION)) {
			throw new Exception( "getFunctionName no found!");
		}

		return  $this->JAVA_HTTP_FUNCTION[$this->type];
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
			$result = $static.$result;
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

	/**
	 * 对象
	 * */
	function httpResult(){
		return $this->httpBasic(DataHttpElement::HTTP_KEY_RESULT, $this->base_name);
	}

	/**
	 * 对象数组
	 * */
	function httpResultList() {
		return $this->httpBasic(DataHttpElement::HTTP_KEY_RESULT_LIST, $this->base_name);
	}


	#@Overrides
	function httpHttp() {
		$object = "";
		if($this->isListMode === false){
			$result = $this->httpResult();
			if($this->element->gson === false){
				$object = $this->httpObject();
			}
		}else{
			$result = $this->httpResultList();
			if($this->element->gson === false){
				$object = $this->httpObjectList();
			}
		}


		$HttpKey = $this->getHttpKey();
		$note = parent::getNoteFormat();
		$http = $HttpKey[DataHttpElement::HTTP_KEY_HTTP];
		$http = parent::getFileContents($http);

		$http = str_replace(Element::FORMAT_CLASS, $this->name, $http);
		$data = "";
		$params = "";
		if (is_array($this->value)){
			foreach ($this->value as $key => $value) {
				$element = $this->getElement();
				$element->initElement($key,$value,$this->getNoteElement($key));
				$data = $data.$element->http();
				if($element->type != DataHttpElement::HTTP_KEY_FILE){
					$params .= " + \"&$key=\" + m".ucfirst($element->name);
				}
			}
		}
		$data .= $result.$object;
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
		$header = str_replace(Element::FORMAT_DATA_KEY, $this->base_name, JAVA_HTTP_HEAD);
		$result = $header.$http;
		$fileurl =$this->getFileUrl($result,$this->name.".java");
		return $result;



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
			$name = strtoupper($this->name."_type_$name");
			$data = str_replace(Element::FORMAT_NOTE, $note, $static);
			$data = str_replace(Element::FORMAT_CLASS, $name, $data);
			$data = str_replace(Element::FORMAT_DATA_KEY, strval($value), $data);
			$result .= $data;
		}
		return Element::FORMAT_ENTER.$result.Element::FORMAT_ENTER;

	}



}
?>