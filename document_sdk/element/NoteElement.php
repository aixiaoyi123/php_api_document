<?php
/**
 * 注释结构体,指定数据类型
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
class NoteElement {

	// 数据类型
	public $type = "";
	// 注解
	public $note = "";

	function __construct($note = "", $type = "") {
		$this->note = $note;
		$this->type = $type;
	}

}
?>