<?php
include_once(dirname(__FILE__)."/NoteElement.php");

/**
 * 类型解析体
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
class ClassElement extends NoteElement {

	// 名称
	public $name = "";

	// 共享类
	public $isShare = false;

	/**
	 * @name：类名    @note：注释   @isShare：是否共享数据   @type：字段类型
	 * */
	function __construct($name = "", $note = "", $isShare = false, $type = "") {
		parent::__construct($note,$type);
		$this->name = $name;
		$this->isShare = $isShare;

	}

	function getJavaElement($datavalue) {

		foreach ($this->note as $key => $value) {
			if($value != null && is_array($value)){
				$data = new JavaElement($key);
				$data->setDictionary($value);
				break;
			}else if($value != null){
				$data = new JavaElement();
				$data->setDictionary($this->note);
				break;
			}
		}
		$data->setType(Element::TYPE_KEY_CLASS);
		$data->setValue($datavalue);
		$data->setName($this->name);
		return $data;
	}

	function getTxtElement($datavalue) {

		foreach ($this->note as $key => $value) {
			if($value != null && is_array($value)){
				$data = new TxtElement($key);
				$data->setDictionary($value);
				break;
			}else if($value != null){
				$data = new TxtElement();
				$data->setDictionary($this->note);
				break;
			}
		}
		$data->setType(Element::TYPE_KEY_CLASS);
		$data->setValue($datavalue);
		$data->setName($this->name);
		return $data;
	}

	function getSwiftElement($datavalue) {

		foreach ($this->note as $key => $value) {
			if($value != null && is_array($value)){
				$data = new SwiftElement($key);
				$data->setDictionary($value);
				break;
			}else if($value != null){
				$data = new SwiftElement();
				$data->setDictionary($this->note);
				break;
			}
		}
		$data->setType(Element::TYPE_KEY_CLASS);
		$data->setValue($datavalue);
		$data->setName($this->name);
		return $data;
	}
	


	function getIosElement($datavalue) {

		foreach ($this->note as $key => $value) {
			if($value != null && is_array($value)){
				$data = new IosElement($key);
				$data->setDictionary($value);
				break;
			}else if($value != null){
				$data = new IosElement();
				$data->setDictionary($this->note);
				break;
			}
		}
		$data->setType(Element::TYPE_KEY_CLASS);
		$data->setValue($datavalue);
		$data->setName($this->name);
		return $data;
	}



}
?>