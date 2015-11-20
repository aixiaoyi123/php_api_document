<?php
include_once(dirname(__FILE__)."/data.api.php");
include_once(dirname(__FILE__)."/../classes/Json.class.php");

$userinfo = array();
$userinfo['uid'] =10086;
$userinfo['name'] ="大帅";
$userinfo['age'] =18;
$userinfo['sex'] =1;



$grade = array(1,2,3,4,5,6);

$info = array();
$info['up'] =1;
$info['down'] =1;


$comment_data = array();
$comment_data['uid'] = 10086;
$comment_data['name'] = "大帅";
$comments = array($comment_data,$comment_data);

$pinfo = array();
$pinfo['id']=2;
$pinfo['uid']='10086';
$pinfo['rid']='10086';
$pinfo['money']=100.25;
$pinfo['key']='tokendddsxsedfs115';
$pinfo['alias']='techer';
$pinfo['aliastype']='yousi.com';
$pinfo['date']='2015-11-12 15:17:23';
$pinfo['clientdate']=1446450068;
$pinfo['info']=$info;
$pinfo['grade']=$grade;
$pinfo['comments']=$comments;
$pinfo['userinfo']=$userinfo;


/**测试地址 Example.php?document=truxish2114558de*/
document($pinfo,'PushInfoData');
Json::echoJson($pinfo);


?>