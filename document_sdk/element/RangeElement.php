<?php
include_once(dirname(__FILE__)."/NoteElement.php");

/**
 * 范围解析体
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
class RangeElement extends NoteElement {

	// 范围
	public $range;
	// 注解方式
	public $note_type;
	
	/**
	 * @range：字段范围    @note：注释   @note_type：翻译模式   @type：字段类型
	 * */
	function __construct($range, $note = "", $note_type = "auto", $type = "") {
		parent::__construct($note,$type);
		$this->range = $range;
		$this->note_type = $note_type;
	}
	
	
	
}
?>