<?php
include_once(dirname(__FILE__)."/Config.php");

function language($value,$from="auto",$to="auto")
{
	$value_code=urlencode($value);
	#首先对要翻译的文字进行 urlencode 处理
	$appid=BAIDU_LANGUAGE_APPKEY;
	#您注册的API Key
	$languageurl = "http://openapi.baidu.com/public/2.0/bmt/translate?client_id=" . $appid ."&q=" .$value_code. "&from=".$from."&to=".$to;
	#生成翻译API的URL GET地址
	$text=json_decode(language_text($languageurl));
	$text = $text->trans_result;
	return $text[0]->dst;
}
function language_text($url)  #获取目标URL所打印的内容
{
	if(!function_exists('file_get_contents')) {
		$file_contents = file_get_contents($url);
	} else {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$file_contents = curl_exec($ch);
		curl_close($ch);
	}
	return $file_contents;
}

function language_new_cidian($value){

	$azauto = ($_POST['azauto']=='')?urldecode($_GET['azauto']):$_POST['azauto'];
	if(!$azauto){
		return $value;
	}
	
	
	if(preg_match("/^[a-zA-Z\s]+$/",$value)){
		$from="en";
		$to="zh";
	}else{
		$from="zh";
		$to="en";
	}

	$ch = curl_init();
	$url = 'http://apis.baidu.com/apistore/tranlateservice/dictionary?query='.$value.'&from='.$from.'&to='.$to;
	$header = array(
        'apikey: '.BAIDU_LANGUAGE_APPKEY,
	);
	// 添加apikey到header
	curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// 执行HTTP请求
	curl_setopt($ch , CURLOPT_URL , $url);
	$res = curl_exec($ch);
	#生成翻译API的URL GET地址
	$text=json_decode($res);
	//var_dump($text);
	$text = $text->retData;
	//var_dump($text);
	$text = $text->dict_result;
	$text = $text->symbols;
	if(empty($text)){
		return "";
	}
	//var_dump($text);
	$text = $text[0]->parts;
	//var_dump($text);
	$text = $text[0]->means;
	//var_dump($text);
	return $text;
}



function language_new_az($value){

	$azauto = ($_POST['azauto']=='')?urldecode($_GET['azauto']):$_POST['azauto'];
	if(!$azauto){
		return $value;
	}
	
	if(empty($value)){
		return "";
	}

	if(strpos($value,'_')){
		$data = explode('_',$value);
		if(is_array($data)){
			$value = $data[0];
		}
	}
	if(strpos(AZ_LANGUAGE_FILTER,$value)){
		//过滤字段
		return "";
	}

	if(preg_match("/^[a-zA-Z\s]+$/",$value)){
		$from="en";
		$to="zh";
	}else{
		$from="zh";
		$to="en";
	}

	$ch = curl_init();
	$url = 'http://apis.baidu.com/apistore/tranlateservice/translate?query='.$value.'&from='.$from.'&to='.$to;
	$header = array(
        'apikey: '.BAIDU_LANGUAGE_APPKEY,
	);
	// 添加apikey到header
	curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// 执行HTTP请求
	curl_setopt($ch , CURLOPT_URL , $url);
	$res = curl_exec($ch);
	$text=json_decode($res);
	//var_dump($text);
	$text = $text->retData;
	//var_dump($text);
	$text = $text->trans_result;
	if(empty($text)){
		return "";
	}
	$text = $text[0]->dst;
	return $text;
}



?>
