<?php
/**
 * http请求结构体
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
class HttpElement {

	/**url地址*/
	public $url;
	/**是否是POST模式*/
	public $post = false;
	/**是否是COOKIE模式*/
	public $cookie = false;
	/**是否是获取COOKIE模式*/
	public $getcookie = false;
	/**json返回解析tab关键域*/
	public $tab;
	/**是否是自动解析模式*/
	public $gson = false;
	/**是否是开启缓存*/
	public $cache = false;
	/**是否是数组结构体*/
	public $array = false;


	/**
	 * @url：url地址    @post：是否是POST模式   @getcookie：是否是COOKIE模式   @cookie：是否是获取COOKIE模式   @tab：json返回解析tab关键域
	 * */
	function __construct($url = "", $post = false, $getcookie = false, $cookie = true, $tab = "", $gson = false, $cache = false) {
		$this->url = $url;
		$this->post = $post;
		$this->getcookie = $getcookie;
		$this->cookie = $cookie;
		$this->tab = $tab;
		$this->gson = $gson;
		$this->cache = $cache;
		if(empty($url)){
			$this->url = $this->getUrlName();
		}
	}

	function setUrl($url) {
		$this->url = $url;
	}

	/**
	 * 是否是数组结构体
	 * */
	function setArray($array) {
		$this->array = $array;
	}

	/**
	 * 是否是POST模式
	 * */
	function setPost($post) {
		$this->post = $post;
	}
	/**
	 * 是否是获取COOKIE模式
	 * */
	function setGetCookie($getcookie) {
		$this->getcookie = $getcookie;
	}

	/**
	 * 是否是COOKIE模式
	 * */
	function setCookie($cookie) {
		$this->cookie = $cookie;
	}
	/**
	 * json返回解析tab关键域
	 * */
	function setTab($tab) {
		$this->tab = $tab;
	}

	/**
	 * 是否是自动解析模式
	 * */
	function setGson($gson) {
		$this->gson = $gson;
	}

	/**
	 * 是否是缓存模式
	 * */
	function setCache($cache) {
		$this->cache = $cache;
	}


	/**
	 * 获取地址
	 * */
	function getUrlName(){


		//		$url = $_SERVER['PHP_SELF'];
		//		$filename = $url;
		//		return $filename;

		$url = $_SERVER['REQUEST_URI'];
		$url = str_replace("/index.php/", "/", $url);
		$arr = explode( '?' , $url );
		if(is_array($arr) && count($arr) > 0){
			$filename= $arr[0];
		}else{
			$filename = $url;
		}
		return $filename;

	}





}
?>