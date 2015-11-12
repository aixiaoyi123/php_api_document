<?php
/**
 * JAVA解析接口
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
interface JavaParseListener {

	/**
	 * 解析数组
	 * */
	function parseArray();


	/**
	 * 解析自定义数组Class
	 * */
	function parseArrayClass();


	/**
	 * 解析子类Class
	 * */
	function parseClassChild();


	/**
	 * 解析内部类Class
	 * */
	function parseClassNested();

	/**
	 * 解析Class
	 * */
	function parseClass();


}
?>