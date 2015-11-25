<?php
/**
 * 文件夹下载
 * */
include_once(dirname(__FILE__)."/Element.php");
include_once(dirname(__FILE__)."/Config.php");

if(isset($_POST['document'])){
	$document = $_POST['document'];
}else if(isset($_GET['document'])){
	$document = $_GET['document'];
}else{
	$document = "";
}

if(isset($_POST['parse'])){
	$parse = $_POST['parse'];
}else if(isset($_GET['parse'])){
	$parse = $_GET['parse'];
}else{
	$parse = "";
}

if($document == DOCUMENT_KEY){

	if(!empty($parse)){
		$element = new Element();
		$dir = $element->getSavePath();
		@mkdir($dir."/zip/", 0777, true);

		$path  = "";
		if($parse == Element::PARSE_MODE_TXT){
			$path =  TXT_DATA_SAVE_PATH;
		}else if($parse == Element::PARSE_MODE_JAVA){
			$path =  JAVA_DATA_SAVE_PATH;
		}else if($parse == Element::PARSE_MODE_JAVA_NATIVE){
			$path =  JAVA_NATIVE_DATA_SAVE_PATH;
		}else if($parse == Element::PARSE_MODE_SWIFT){
			$path =  SWIFT_DATA_SAVE_PATH;
		}else if($parse == Element::PARSE_MODE_IOS){
			$path =  IOS_DATA_SAVE_PATH;
		}
		$rootpath = explode('/',$path);
		foreach ($rootpath as $key => $value) {
			if(!empty($value)){
				$path = $value;
				break;
			}
		}
		#zip
		$zip = $path.'.zip';
		exec("zip -r ".$dir.'/zip/'.$zip .' '.$dir.'/'.$path.'/*');

		$path = $dir.'/zip/'.$zip;
		//echo $path;
		header("Content-Type: application/force-download");
		header("Content-Disposition: attachment; filename=".basename($path));
		readfile($path);
		exit;
	}


	$data = array(
	Element::PARSE_MODE_TXT=> "1.TXT文件夹",
	Element::PARSE_MODE_JAVA=> "2.JAVA依赖文件夹",
	Element::PARSE_MODE_JAVA_NATIVE=> "3.JAVA原生文件夹",
	Element::PARSE_MODE_SWIFT=> "4.Swift1.2文件夹",
	Element::PARSE_MODE_IOS=> "5.Ios_MJExtension文件夹"
	);
	$result = '';
	foreach ($data as $key => $value) {
		$result_url = "FolderDownLoad.php?document=$document&amp;parse=$key";
		$result .= "<input type=button value=点击下载$value  onclick=\"window.open('$result_url')\"/>";
		$result .=Element::ECHO_SPLACE.Element::ECHO_ENTER.Element::ECHO_ENTER;
	}
	$result = Element::ECHO_ENTER.$result.Element::ECHO_ENTER.Element::ECHO_ENTER;
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		echo iconv($result);
	}else{
		echo iconv("UTF-8", "GBK",$result);
	}
}

exit;



?>