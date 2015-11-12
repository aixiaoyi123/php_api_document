<?php
include_once(dirname(__FILE__)."/../http/DataHttpElement.php");

/**
 * 文件解析体
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
class FileElement extends NoteElement {

	/**
	 * @note：注释
	 * */
	function __construct($note = "") {
		parent::__construct($note,DataHttpElement::HTTP_KEY_FILE);
	}
	
	
	
}
?>