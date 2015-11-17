<?php
include_once(dirname(__FILE__)."/../java/JavaHttpElement.php");

/**
 * JAVA原生 Http请求结构体
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
class JavaNativeHttpElement extends JavaHttpElement{

	// JAVA原生 http映射表
	public $JAVA_NATIVE_HTTP_KEY = array(
	/**字符串*/
	Element::TYPE_KEY_STRING                => '/javanativepan/http/string.java',
	/**4位整型*/
	Element::TYPE_KEY_INT        	        => "/javanativepan/http/int.java",
	/**长整形*/
	Element::TYPE_KEY_LONG                  => "/javanativepan/http/long.java",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT                 => "/javanativepan/http/float.java",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN               => "/javanativepan/http/boolean.java",
	/**文件参数*/
	DataHttpElement::HTTP_KEY_FILE          => "/javanativepan/http/file.java",
	/**文件路径设置*/
	DataHttpElement::HTTP_KEY_FILE_PATH     => "/javanativepan/http/filepath.java",
	/**结果解析*/
	DataHttpElement::HTTP_KEY_OBJECT        => "/javanativepan/http/object.java",
	/**结果数组解析*/
	DataHttpElement::HTTP_KEY_OBJECT_LIST   => "/javanativepan/http/object_list.java",
	/**对象*/
	DataHttpElement::HTTP_KEY_RESULT        => "/javanativepan/http/result.java",
	/**对象数组*/
	DataHttpElement::HTTP_KEY_RESULT_LIST   => "/javanativepan/http/result_list.java",
	/**整体*/
	DataHttpElement::HTTP_KEY_HTTP          => "/javanativepan/http/http.java",
	/**头部引用*/
	Element::TYPE_KEY_HEAD     	  	        => JAVA_NATIVE_HEAD
	/**待扩展*/
	);


	//构造方法
	function __construct() {
		parent::__construct();
	}

	#@Overrides
	function getHttpKey(){

		return $this->JAVA_NATIVE_HTTP_KEY;

	}


	#@Overrides
	function httpHttp() {

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
			if($element->type != DataHttpElement::HTTP_KEY_FILE){
				$params .= " + \"&$key=\" + m".ucfirst($element->name);
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
		$header = str_replace(Element::FORMAT_DATA_KEY, $this->base_name, JAVA_NATIVE_HTTP_HEAD);
		$result = $header.$http;
		$fileurl =$this->getFileUrl($result,$this->name.".java");
		return $result;



	}


}
?>