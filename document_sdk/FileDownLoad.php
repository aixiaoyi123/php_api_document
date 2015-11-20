<?php
include_once(dirname(__FILE__)."/data/DataElement.php");
include_once(dirname(__FILE__)."/Config.php");

/**
 * 外部连接配置
 */
function getHttpPath($filename ='', $parse = Element::PARSE_MODE_JAVA, $http = false)
{

	return 'http://'.$_SERVER['HTTP_HOST'].DOCUMENT_SAVE_ROOT_PATH.getPath($filename,$parse,$http);
}


/**
 * 输出字典配置
 */
function getPath($filename ='', $parse = Element::PARSE_MODE_JAVA, $http = false)
{

	//要下载的文件名
	if($parse == Element::PARSE_MODE_JAVA){
		if(!empty($http) && $http){
			$path = JAVA_HTTP_DATA_SAVE_PATH.$filename;
		}else{
			$path = JAVA_DATA_SAVE_PATH.$filename;
		}
	}else if($parse == Element::PARSE_MODE_JAVA_NATIVE){
		if(!empty($http) && $http){
			$path = JAVA_NATIVE_HTTP_DATA_SAVE_PATH.$filename;
		}else{
			$path = JAVA_NATIVE_DATA_SAVE_PATH.$filename;
		}
	}else if($parse == Element::PARSE_MODE_SWIFT){
		if(!empty($http) && $http){
			$path = SWIFT_HTTP_DATA_SAVE_PATH.$filename;
		}else{
			$path = SWIFT_DATA_SAVE_PATH.$filename;
		}
	}else if($parse == Element::PARSE_MODE_IOS){
		if(!empty($http) && $http){
			$path = IOS_HTTP_DATA_SAVE_PATH.$filename;
		}else{
			$path = IOS_DATA_SAVE_PATH.$filename;
		}
	}else if($parse == Element::PARSE_MODE_TXT){
		if(!empty($http) && $http){
			$path = TXT_HTTP_DATA_SAVE_PATH.$filename;
		}else{
			$path = TXT_DATA_SAVE_PATH.$filename;
		}
	}

	return $path;
}

/**
 * 下载地址
 */
function downlaod($path)
{
	header("Content-Type: application/force-download");
	header("Content-Disposition: attachment; filename=".basename($path));
	readfile($path);
}


?>