<?php
/**push信息字典*/
include_once(dirname(__FILE__)."/Class.UserInfoData.php");
include_once(dirname(__FILE__)."/../document_sdk/NoteClass.php");

class PushInfoData extends NoteClass implements HttpParamsListener{

	#@Overrides
	function getName(){
		return __CLASS__;
	}

	#@Overrides
	function getNote(){
		/**此API注释*/
		return "push信息表";
	}

	#@Overrides
	/**字段解析字段，未标明则会自动调用英汉翻译标注*/
	function getKeys(){

		$comments_keys =array("uid"=>"用户账号","name"=>"昵称");
		/**普通样式,本身无注释*/
		//$info_keys = array("up"=>"支持数","down"=>"反对数");
		/**普通样式,本身有注释*/
		$info_keys = array("基础信息" => array("up"=>"支持数","down"=>"反对数"));
		/**指定类名*/
		$info_keys = new ClassElement("InfoData",$info_keys);
		/**普通样式*/
		//$uid_keys = "用户UID";
		/**指定数据类型*/
		$uid_keys = new NoteElement("用户UID",Element::TYPE_KEY_STRING);
		/**公用数据结构,用户资料是经常公用的*/
		$userinfo =  new UserInfoData();
		$userinfo_keys = $userinfo->getDictionary();

		$keys = array("uid"=>$uid_keys,
			"rid"=>"回复ID",
			"money"=>"价格",
			"key"=>"友盟token",
			"alias"=>"域",
			"aliastype"=>"用户范围",
			"date"=>"日期",
			"clientdate"=>"时间戳",
			"info"=>$info_keys,
			"comments"=>$comments_keys,
			"userinfo"=>$userinfo_keys
		);

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

		$file = new FileElement("文件上传");
		$type = new RangeElement(array("list"=>"列表","info"=>"详情"),"类型");

		$keys = array("time"=>"时间戳",
						"type"=>$type,
						"isTop"=>"排行",
						"sex"=>"性别",
						"money"=>"身价",
						"file"=>$file);
		return $keys;
	}

	#@Overrides
	/**模拟请求数值，来定位类型*/
	function getHttpParamsValue(){

		$data = array( "time"=>1446450068,
						"type"=>"list",
						"isTop"=>true,
						"sex"=>1,
						"money"=>"1.1",
						"file"=>""
						/**多文件上传*/
		//"file"=>array("file1","file2","file3","file4")
		);
		return $data;

	}

	#@Overrides
	/**设置请求模式*/
	function getHttpElement(){
		$element = new HttpElement();
		/**cookie模式*/
		$element->setCookie(true);
		/**获取cookie模式*/
		$element->setGetCookie(false);
		/**Post请求*/
		$element->setPost(true);
		/**终端自动序列化如Gson*/
		$element->setGson(false);
		return new HttpElement();
	}


}
?>