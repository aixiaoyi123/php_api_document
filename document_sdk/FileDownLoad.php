<?php
include_once(dirname(__FILE__)."/data/DataElement.php");

$filename = $_GET['filename'];
$parse = $_GET['parse'];
$http = $_GET['http'];

//要下载的文件名
if($parse == Element::PARSE_MODE_JAVA){
	if(!empty($http)){
		$path = "../document".JAVA_HTTP_DATA_SAVE_PATH.$filename;
	}else{
		$path = "../document".JAVA_DATA_SAVE_PATH.$filename;
	}
}else if($parse == Element::PARSE_MODE_JAVA_NATIVE){
	if(!empty($http)){
		$path = "../document".JAVA_NATIVE_HTTP_DATA_SAVE_PATH.$filename;
	}else{
		$path = "../document".JAVA_NATIVE_DATA_SAVE_PATH.$filename;
	}
}else if($parse == Element::PARSE_MODE_SWIFT){
	if(!empty($http)){
		$path = "../document".SWIFT_HTTP_DATA_SAVE_PATH.$filename;
	}else{
		$path = "../document".SWIFT_DATA_SAVE_PATH.$filename;
	}
}else if($parse == Element::PARSE_MODE_TXT){
	if(!empty($http)){
		$path = "../document".TXT_HTTP_DATA_SAVE_PATH.$filename;
	}else{
		$path = "../document".TXT_DATA_SAVE_PATH.$filename;
	}
}
header("Content-Type: application/force-download");
header("Content-Disposition: attachment; filename=".basename($path));
readfile($path);


?>