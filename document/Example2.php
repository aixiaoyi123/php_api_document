<?php
include_once(dirname(__FILE__)."/data.api.php");
include_once(dirname(__FILE__)."/../classes/Json.class.php");

$city1 = array();
$city1['id'] =1;
$city1['name'] ="泉州市";

$city2 = array();
$city2['id'] =2;
$city2['name'] ="上海市";


$citylist[] = $city1;
$citylist[] = $city2;

/**测试地址 Example.php?document=truxish2114558de*/
document('GetCityList',$citylist);
Json::echoJson($citylist);


?>