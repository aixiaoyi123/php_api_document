<?php
include_once(dirname(__FILE__)."/NoteElement.php");

/**
 * 固定请求参数解析体
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
class FinalElement extends NoteElement {

	// 固定参数
	public $final;
	
	/**
	 * @final：固定参数    @note：注释   @type：字段类型
	 * */
	function __construct($final, $note = "", $type = "") {
		parent::__construct($note,$type);
		$this->final = $final;
	}
	
	
	
}
?>