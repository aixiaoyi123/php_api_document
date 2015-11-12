<?php
/**
 * HTTP请求参数接口
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
interface HttpParamsListener {

	/**
	 * 获取请求字典
	 * */
	function getHttpKeys();


	/**
	 * 获取请求参数值
	 * */
	function getHttpParamsValue();


	/**
	 * 获取HTTP请求设置
	 * */
	function getHttpElement();



}
?>