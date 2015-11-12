<?php
/**
 * 通用Http参数接口
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
interface DataHttpListener {
	
	/**
	 * 字符串参数
	 * */
	function httpString();


	/**
	 * 整型参数
	 * */
	function httpInt();

	/**
	 * 长整型参数
	 * */
	function httpLong();

	/**
	 * 浮点数参数
	 * */
	function httpFloat();


	/**
	 * 布尔变量参数
	 * */
	function httpBool();



}
?>