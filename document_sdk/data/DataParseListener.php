<?php
/**
 * 通用解析接口
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
interface DataParseListener {
	
	/**
	 * 解析字符串
	 * */
	function parseString();


	/**
	 * 解析整型
	 * */
	function parseInt();

	/**
	 * 解析长整型
	 * */
	function parseLong();

	/**
	 * 解析浮点数
	 * */
	function parseFloat();


	/**
	 * 解析布尔变量
	 * */
	function parseBool();



}
?>