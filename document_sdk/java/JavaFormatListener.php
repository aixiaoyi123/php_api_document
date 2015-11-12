<?php
/**
 * JAVA格式化接口
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
interface JavaFormatListener {
	
	/**
	 * 格式化数组
	 * */
	function formatArray();


	/**
	 * 格式化自定义数组Class
	 * */
	function formatArrayClass();


	/**
	 * 格式化子类Class
	 * */
	function formatClassChild();


	/**
	 * 格式化Class
	 * */
	function formatClass();


}
?>