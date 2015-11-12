<?php
/**
 * 通用格式化接口
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
interface DataFormatListener {
	
	/**
	 * 格式化字符串
	 * */
	function formatString();


	/**
	 * 格式化整型
	 * */
	function formatInt();

	/**
	 * 格式化长整型
	 * */
	function formatLong();

	/**
	 * 格式化浮点数
	 * */
	function formatFloat();


	/**
	 * 格式化布尔变量
	 * */
	function formatBool();



}
?>