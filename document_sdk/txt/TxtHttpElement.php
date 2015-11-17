<?php
include_once(dirname(__FILE__)."/../http/DataHttpElement.php");
include_once(dirname(__FILE__)."/TxtHttpListener.php");

/**
 * Txt Http请求结构体
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
class TxtHttpElement extends DataHttpElement implements TxtHttpListener{

	// TXT http映射表
	public $TXT_HTTP_KEY = array(
	/**字符串*/
	Element::TYPE_KEY_STRING                => '/txtpan/http/string.java',
	/**4位整型*/
	Element::TYPE_KEY_INT        	        => "/txtpan/http/int.java",
	/**长整形*/
	Element::TYPE_KEY_LONG                  => "/txtpan/http/long.java",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT                 => "/txtpan/http/float.java",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN               => "/txtpan/http/boolean.java",
	/**文件参数*/
	DataHttpElement::HTTP_KEY_FILE          => "/txtpan/http/file.java",
	/**整体*/
	DataHttpElement::HTTP_KEY_HTTP          => "/txtpan/http/http.java"
	/**待扩展*/
	);


	//TXT http方法映射表
	public $TXT_HTTP_FUNCTION = array(
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
	DataHttpElement::HTTP_KEY_FILE          => "txtFile",
	/**整体*/
	DataHttpElement::HTTP_KEY_HTTP          => "txtHttp"
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
	function __construct() {
		parent::__construct();
	}

	#@Overrides
	function getHttpKey(){

		return $this->TXT_HTTP_KEY;

	}
	#@Overrides
	function autoType() {

		if (empty($this->value)){
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

		if (!array_key_exists($this->type, $this->TXT_HTTP_FUNCTION)) {
			throw new Exception( "getFunctionName no found!");
		}

		return  $this->TXT_HTTP_FUNCTION[$this->type];
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
		$result = str_replace(Element::FORMAT_NOTE, $note, $http);

		$static = $this->formatStatic($key);
		if(!empty($static)){
			$result = $result.$static;
		}
		return $result;

	}

	#@Overrides
	function httpString() {
		return $this->httpBasic(Element::TYPE_KEY_STRING, $this->name);
	}
	#@Overrides
	function httpInt() {
		return $this->httpBasic(Element::TYPE_KEY_INT, $this->name);
	}
	#@Overrides
	function httpLong() {
		return $this->httpBasic(Element::TYPE_KEY_LONG, $this->name);
	}
	#@Overrides
	function httpFloat() {
		return $this->httpBasic(Element::TYPE_KEY_FLOAT, $this->name);
	}
	#@Overrides
	function httpBool() {
		return $this->httpBasic(Element::TYPE_KEY_BOOLEAN, $this->name);
	}

	#@Overrides
	function txtFile() {

		$HttpKey = $this->getHttpKey();
		$note = parent::getNoteFormat();

		$file = $HttpKey[DataHttpElement::HTTP_KEY_FILE];
		$file = parent::getFileContents($file);

		$path = "";
		if (is_array($this->value)){
			//多文件上传情况
			foreach ($this->value as $key => $value) {
				if($value != null){
					$path .= str_replace(Element::FORMAT_DATA_KEY, $value, $file);
				}
			}
		}else{
			$path .= str_replace(Element::FORMAT_DATA_KEY, $this->name, $file);
		}
		$path = str_replace(Element::FORMAT_NOTE, $note, $path);
		return $path;

	}


	#@Overrides
	function txtHttp() {

		$HttpKey = $this->getHttpKey();
		$note = parent::getNoteFormat();
		if (!is_array($this->value)){
			throw new Exception("httpHttp is_array error!");
		}
		$http = $HttpKey[DataHttpElement::HTTP_KEY_HTTP];
		$http = parent::getFileContents($http);

		$http = str_replace(Element::FORMAT_CLASS, $this->name, $http);
		$data = "";

		foreach ($this->value as $key => $value) {
			$element = $this->getElement();
			$element->initElement($key,$value,$this->getNoteElement($key));
			$data = $data.$element->http();
		}
		$http = str_replace(Element::FORMAT_DATA, $data, $http);

		$url = $this->element->url;
		$http = str_replace(DataHttpElement::HTTP_URL, $url, $http);
			
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
			$http = str_replace(DataHttpElement::HTTP_TAB, "默认", $http);
		}else{
			$http = str_replace(DataHttpElement::HTTP_TAB, "$tab", $http);
		}


		if($this->element->gson === false){
			$http = str_replace(DataHttpElement::HTTP_GSON, "false", $http);
		}else{
			$http = str_replace(DataHttpElement::HTTP_GSON, "true", $http);
		}


		if($this->isListMode === false){
			$http = str_replace(DataHttpElement::HTTP_JSON_RESULT, "false", $http);
		}else{
			$http = str_replace(DataHttpElement::HTTP_JSON_RESULT, "true", $http);
		}


		$http = str_replace(Element::FORMAT_NOTE, $note, $http);
		$http = str_replace(Element::FORMAT_VERSION, $this->version, $http);
		$result = $http;
		$fileurl =$this->getFileUrl($result,$this->name.".txt");
		//return Element::ECHO_ENTER.$fileurl.Element::ECHO_ENTER.Element::ECHO_ENTER.$result;
		return $result;


	}


	#@Overrides
	function getStaticKey(){

		return $this->TXT_STATIC_FINAL_KEY;

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
		return $result;

	}



}
?>