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
	public $post;
	/**是否是COOKIE模式*/
	public $cookie;
	/**是否是获取COOKIE模式*/
	public $getcookie;
	/**json返回解析tab关键域*/
	public $tab;
	/**是否是自动解析模式*/
	public $gson;

	/**
	 * @url：url地址    @post：是否是POST模式   @getcookie：是否是COOKIE模式   @cookie：是否是获取COOKIE模式   @tab：json返回解析tab关键域
	 * */
	function __construct($url = "", $post = false, $getcookie = false, $cookie = true, $tab = "", $gson = false) {
		$this->url = $url;
		$this->post = $post;
		$this->getcookie = $getcookie;
		$this->cookie = $cookie;
		$this->tab = $tab;
		$this->gson = $gson;
		if(empty($url)){
			$this->url = $this->getUrlName();
		}
	}

	function setUrl($url) {
		$this->url = $url;
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
	 * 获取地址
	 * */
	function getUrlName(){

		$url = $_SERVER['PHP_SELF'];
		//		$arr = explode( '/' , $url );
		//		$filename= $arr[count($arr)-1];
		$filename = $url;
		return $filename;

	}





}
?>