<?php
include_once(dirname(__FILE__)."/../java/JavaHttpElement.php");

/**
 * Ios Http请求结构体
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
class IosHttpElement extends JavaHttpElement{

	// ios http映射表
	public $IOS_HTTP_KEY = array(
	/**字符串*/
	Element::TYPE_KEY_STRING                => '/iospan/http/string.h',
	/**4位整型*/
	Element::TYPE_KEY_INT        	        => "/iospan/http/int.h",
	/**长整形*/
	Element::TYPE_KEY_LONG                  => "/iospan/http/long.h",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT                 => "/iospan/http/float.h",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN               => "/iospan/http/boolean.h",
	/**文件参数*/
	DataHttpElement::HTTP_KEY_FILE          => "/iospan/http/file.h",
	/**文件路径设置*/
	DataHttpElement::HTTP_KEY_FILE_PATH     => "/iospan/http/filepath.h",
	/**对象*/
	DataHttpElement::HTTP_KEY_RESULT        => "/iospan/http/result.h",
	/**对象数组*/
	DataHttpElement::HTTP_KEY_RESULT_LIST   => "/iospan/http/result_list.h",
	/**整体*/
	DataHttpElement::HTTP_KEY_HTTP          => "/iospan/http/http.h",
	/**头部引用*/
	Element::TYPE_KEY_HEAD     	  	        => IOS_HTTP_HEAD
	/**待扩展*/
	);

	// ios http解析映射表
	public $IOS_MHTTP_KEY = array(
	/**文件参数*/
	DataHttpElement::HTTP_KEY_FILE          => "/iospan/http/file.m",
	/**文件路径设置*/
	DataHttpElement::HTTP_KEY_FILE_PATH     => "/iospan/http/filepath.m",
	/**对象*/
	DataHttpElement::HTTP_KEY_RESULT        => "/iospan/http/result.m",
	/**对象数组*/
	DataHttpElement::HTTP_KEY_RESULT_LIST   => "/iospan/http/result_list.m",
	/**整体*/
	DataHttpElement::HTTP_KEY_HTTP          => "/iospan/http/http.m"
	/**待扩展*/
	);


	// ios静态范围表
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

	// ios请求常量
	public $IOS_FINAL_KEY = array(
	/**字符串*/
	Element::TYPE_KEY_STRING           => "/iospan/final/string.h",
	/**4位整型*/
	Element::TYPE_KEY_INT        	   => "/iospan/final/int.h",
	/**长整形*/
	Element::TYPE_KEY_LONG             => "/iospan/final/long.h",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT            => "/iospan/final/float.h",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN          => "/iospan/final/boolean.h",
	/**待扩展*/
	);

	// 变量
	public $params = array();

	//获取变量
	function getParams(){

		$params = "";
		foreach ($this->params as $key => $value) {
			$params .= $value;
		}
		$params = str_replace(self::FORMAT_FINAL, strtoupper($this->name), $params);
		if(!empty($params)){
			$params = substr($params, 0, -1);
		}
		return $params;
	}

	//增加变量
	function setParamsData($key,$data,$final = false){

		$FinalKey = $this->getFinalKey();
		if (!array_key_exists($key,$FinalKey)){
			return;
		}
		$splace = Element::FORMAT_ENTER;
		$splace .= Element::ECHO_SPLACE.Element::ECHO_SPLACE;
		$splace .= Element::FORMAT_SPLACE.Element::FORMAT_SPLACE;
		$splace .= Element::FORMAT_SPLACE.Element::FORMAT_SPLACE;
		$splace .= Element::FORMAT_SPLACE.Element::FORMAT_SPLACE;
		$quote = "@(".Element::FORMAT_DATA_KEY.")";
		if($key == Element::TYPE_KEY_STRING){
			//字符串的时候
			$quote = Element::FORMAT_DATA_KEY;
		}

		if(!empty($data)){
			$data = lcfirst($data);
			if($final){
				//静态常量的模式
				$quote  = str_replace(Element::FORMAT_DATA_KEY, self::FORMAT_FINAL."_".strtoupper($data), $quote);
			}else{
				$quote  = str_replace(Element::FORMAT_DATA_KEY, "self.m".ucfirst($data), $quote);
			}
			$this->params[] = $splace."@\"$data=\":".$quote.",";
		}

	}

	//增加变量
	function addParamsData($element){

		if($element instanceof IosHttpElement){
			//嵌套类型
			foreach ($element->params as $key => $value) {
				if(!empty($value)){
					$this->params[] = $value;
				}
			}
		}

	}



	// 解析类定义
	public $m_params = array();

	//获取解析类定义
	function getMParams(){

		$m = "";
		foreach ($this->m_params as $key => $value) {
			$m .= Element::FORMAT_ENTER.Element::FORMAT_ENTER.$value;
		}
		return $m;
	}

	//增加解析类定义
	function setMParamsData($data){

		if(!empty($data)){
			$this->m_params[] = $data;
		}

	}

	//增加解析类定义
	function addMParamsData($element){

		if($element instanceof IosHttpElement){
			//嵌套类型
			foreach ($element->m_params as $key => $value) {
				if(!empty($value)){
					$this->m_params[] = $value;
				}
			}
		}

	}


	// 静态常量定义
	public $static_params = array();

	/**静态名称 */
	const FORMAT_STATIC ="{static}";

	//获取静态常量定义
	function getStaticParams(){

		$static = "";
		foreach ($this->static_params as $key => $value) {
			$static .= $value;
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

		if($element instanceof IosHttpElement){
			//嵌套类型
			foreach ($element->static_params as $key => $value) {
				if(!empty($value)){
					$this->static_params[] = $value;
				}
			}
		}

	}



	// 常量定义
	public $final_params = array();

	/**静态名称 */
	const FORMAT_FINAL ="{final}";


	//获取常量定义
	function getFinalParams(){
		$final = "";
		foreach ($this->final_params as $key => $value) {
			$final .= $value;
		}
		$final = str_replace(self::FORMAT_FINAL, strtoupper($this->name), $final);
		return $final;
	}

	//增加常量
	function setFinalParamsData($data){

		if(!empty($data)){
			$this->final_params[] = $data;
		}

	}

	//增加静态常量
	function addFinalParams($element){

		if($element instanceof IosHttpElement){
			//嵌套类型
			foreach ($element->final_params as $key => $value) {
				if(!empty($value)){
					$this->final_params[] = $value;
				}
			}
		}

	}



	//构造方法
	function __construct() {
		parent::__construct();
	}

	#@Overrides
	function getHttpKey(){

		return $this->IOS_HTTP_KEY;

	}

	function getMHttpKey(){

		return $this->IOS_MHTTP_KEY;

	}

	#@Overrides
	function getFinalKey(){

		return $this->IOS_FINAL_KEY;

	}

	#@Overrides
	function httpBasic($key, $value) {

		if(isset($this->final)){
			$HttpKey = $this->getFinalKey();
		}else{
			$HttpKey = $this->getHttpKey();
		}
		if(empty($this->base_name)){
			$note = parent::getNoteFormat();
		}
		if (!array_key_exists($key,$HttpKey)){
			throw new Exception("httpBasic HttpKey no found $key !");
		}
		$http = $HttpKey[$key];
		$http = parent::getFileContents($http);
		if(isset($this->final)){
			//常量用大写的字母表示
			$http = str_replace(Element::FORMAT_DATA_KEY, strtoupper($value), $http);
		}else{
			$http = str_replace(Element::FORMAT_DATA_KEY, $value, $http);
		}
		$result = $http;
		if(isset($note)){
			$result = str_replace(Element::FORMAT_NOTE, $note, $result);
		}

		if(isset($this->final)){
			//常量
			$result = str_replace(DataHttpElement::HTTP_FINAL, $this->final, $result);
			$this->setFinalParamsData($result);
			$this->setParamsData($key,$value,true);
			$result = "";
		}else{
			//判断是否是静态常量
			$static = $this->formatStatic($key);
			if(!empty($static)){
				$this->setStaticParamsData($static);
			}
			$this->setParamsData($key,$value);
		}


		$MHttpKey = $this->getMHttpKey();
		if (array_key_exists($key,$MHttpKey)){
			//存在M注释片段
			$mhttp = $MHttpKey[$key];
			$mhttp = parent::getFileContents($mhttp);
			$mhttp = str_replace(Element::FORMAT_DATA_KEY, $value, $mhttp);
			$mresult = $mhttp;
			if(isset($note)){
				$mresult = str_replace(Element::FORMAT_NOTE, $note, $mresult);
			}
			$this->setMParamsData($mresult);
		}

		return $result;

	}

	#@Overrides
	function httpFile() {

		$HttpKey = $this->getHttpKey();
		$MHttpKey = $this->getMHttpKey();
		$note = parent::getNoteFormat();

		$file = $HttpKey[DataHttpElement::HTTP_KEY_FILE];
		$file = parent::getFileContents($file);
		$filepath = $HttpKey[DataHttpElement::HTTP_KEY_FILE_PATH];
		$filepath = parent::getFileContents($filepath);

		$mfile = $MHttpKey[DataHttpElement::HTTP_KEY_FILE];
		$mfile = parent::getFileContents($mfile);
		$mfilepath = $MHttpKey[DataHttpElement::HTTP_KEY_FILE_PATH];
		$mfilepath = parent::getFileContents($mfilepath);

		$path = "";
		$mpath = "";
		if (is_array($this->value)){
			//多文件上传情况
			foreach ($this->value as $key => $value) {
				if($value != null){
					$path .= str_replace(Element::FORMAT_DATA_KEY, $value, $filepath);
					$mpath .= str_replace(Element::FORMAT_DATA_KEY, $value, $mfilepath);
				}
			}
		}else{
			$path .= str_replace(Element::FORMAT_DATA_KEY, $this->name, $filepath);
			$mpath .= str_replace(Element::FORMAT_DATA_KEY, $this->name, $mfilepath);
		}
		$file = str_replace(Element::FORMAT_DATA, $path, $file);
		$file = str_replace(Element::FORMAT_NOTE, $note, $file);

		$mfile = str_replace(Element::FORMAT_DATA, $mpath, $mfile);
		$mfile = str_replace(Element::FORMAT_NOTE, $note, $mfile);
		$this->setMParamsData($mfile);

		return $file;

	}


	#@Overrides
	function httpHttp() {
		$object = "";
		if($this->isListMode === false){
			$result = $this->httpResult();
		}else{
			$result = $this->httpResultList();
		}

		$HttpKey = $this->getHttpKey();
		$note = parent::getNoteFormat();
		$http = $HttpKey[DataHttpElement::HTTP_KEY_HTTP];
		$http = parent::getFileContents($http);

		$MHttpKey = $this->getMHttpKey();
		$mhttp = $MHttpKey[DataHttpElement::HTTP_KEY_HTTP];
		$mhttp = parent::getFileContents($mhttp);

		$post = $this->element->post;
		if($post === false){
			$mhttp = str_replace(DataHttpElement::HTTP_POST, "false", $mhttp);
		}else{
			$mhttp = str_replace(DataHttpElement::HTTP_POST, "true", $mhttp);
		}

		$http = str_replace(Element::FORMAT_CLASS, $this->name, $http);
		$http = str_replace(Element::FORMAT_CLASS_UPPER, strtoupper($this->name), $http);
		$mhttp = str_replace(Element::FORMAT_CLASS, $this->name, $mhttp);
		$mhttp = str_replace(Element::FORMAT_CLASS_UPPER, strtoupper($this->name), $mhttp);

		$data = "";
		if (is_array($this->value)){
			foreach ($this->value as $key => $value) {
				$element = $this->getElement();
				$element->initElement($key,$value,$this->getNoteElement($key));
				$data = $data.$element->http();
				$this->addFinalParams($element);
				$this->addStaticParams($element);
				$this->addMParamsData($element);
				$this->addParamsData($element);
			}
		}
		$data .= $result.$object;
		$http = str_replace(Element::FORMAT_DATA, $data, $http);
		$http = str_replace(self::FORMAT_FINAL, $this->getFinalParams(), $http);
		$http = str_replace(self::FORMAT_STATIC, $this->getStaticParams(), $http);
		$url = $this->element->url;
		$http = str_replace(DataHttpElement::HTTP_URL, $url, $http);

		$mhttp = str_replace(Element::FORMAT_DATA, $this->getMParams(), $mhttp);
		$mhttp = str_replace(DataHttpElement::HTTP_PARAMS, $this->getParams(), $mhttp);
			

			
		$cookie = $this->element->cookie;
		if($cookie === false){
			$mhttp = str_replace(DataHttpElement::HTTP_COOKIE, "false", $mhttp);
		}else{
			$mhttp = str_replace(DataHttpElement::HTTP_COOKIE, "true", $mhttp);
		}
			
		$getcookie= $this->element->getcookie;
		if($getcookie === false){
			$mhttp = str_replace(DataHttpElement::HTTP_GETCOOKIE, "false", $mhttp);
		}else{
			$mhttp = str_replace(DataHttpElement::HTTP_GETCOOKIE, "true", $mhttp);
		}

		$cache= $this->element->cache;
		if($cache === false){
			$mhttp = str_replace(DataHttpElement::HTTP_CACHE, "false", $mhttp);
		}else{
			$mhttp = str_replace(DataHttpElement::HTTP_CACHE, "true", $mhttp);
		}

		$tab= $this->element->tab;
		if(empty($tab)){
			$mhttp = str_replace(DataHttpElement::HTTP_TAB, "@\"\"", $mhttp);
		}else{
			$mhttp = str_replace(DataHttpElement::HTTP_TAB, "@\"$tab\"", $mhttp);
		}


		$http = str_replace(Element::FORMAT_NOTE, $note, $http);
		$http = str_replace(Element::FORMAT_VERSION, $this->version, $http);
		$header = str_replace(Element::FORMAT_DATA_KEY, $this->base_name, IOS_HTTP_HEAD);
		$result = $header.$http;
		$fileurl =$this->getFileUrl($result,$this->name.".h");


		$mhttp = str_replace(Element::FORMAT_NOTE, $note, $mhttp);
		$m_result = str_replace(Element::FORMAT_VERSION, $this->version, $mhttp);
		$fileurl =$this->getFileUrl($m_result,$this->name.".m");
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