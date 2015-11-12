<?php
/**用户资料字典*/
include_once(dirname(__FILE__)."/../document_sdk/NoteClass.php");

class UserInfoData extends NoteClass{

	#@Overrides
	function getName(){
		return __CLASS__;
	}

	#@Overrides
	function getNote(){
		return "用户资料";
	}

	#@Overrides
	function getKeys(){

		//$sex = new RangeElement(array(2=>"男",1=>"女",0=>"不限"),"性别");
		$sex = new RangeElement(array("男","女","不限"),"性别");

		$keys = array("uid"=>"用户账号",
					   "name"=>"昵称",
					   "age"=>"年龄",
					   "sex"=>$sex);
		return $keys;
	}
	#@Overrides
	/**此数据是为了公共数据的格式，以免某些接口输出是少不完整的用户资料字段，有些接口又是完整的用户资料字段*/
	function getValue(){

		$data = array(
						'uid'=>10086,
						"name"=>"大帅",
						"age"=>18,
						"sex"=>1
		);
		return $data;
	}

	#@Overrides
	function isGeneralMode(){
		return true;
	}

}
?>