<?php
/**push信息字典*/
include_once(dirname(__FILE__)."/../document_sdk/NoteClass.php");

class GetCityList extends NoteClass implements HttpParamsListener{

	#@Overrides
	function getName(){
		return __CLASS__;
	}

	#@Overrides
	function getNote(){
		/**此API注释*/
		return "城市信息列表";
	}

	#@Overrides
	/**字段解析字段，未标明则会自动调用英汉翻译标注*/
	function getKeys(){

		$keys = array("name"=>"城市名称");
		/**可为空*/
		return $keys;
	}
	#@Overrides
	/**为空则引用JSON数据*/
	function getValue(){
		return null;
	}

	#@Overrides
	/**是否为公用数据*/
	function isGeneralMode(){
		return false;
	}

	/***-----------------------请求参数设置------------------------------------***/

	#@Overrides
	/**请求参数*/
	function getHttpKeys(){
		return null;
	}

	#@Overrides
	/**模拟请求数值，来定位类型*/
	function getHttpParamsValue(){
		return null;
	}

	#@Overrides
	/**设置请求模式*/
	function getHttpElement(){
		$element = new HttpElement();
		/**cookie模式*/
		$element->setCookie(false);
		/**获取cookie模式*/
		$element->setGetCookie(false);
		/**Post请求*/
		$element->setPost(false);
		/**终端自动序列化如Gson*/
		$element->setGson(false);
		return new HttpElement();
	}


}
?>