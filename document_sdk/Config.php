<?php
//百度翻译KEY
define("BAIDU_LANGUAGE_APPKEY", "6e87261cf9d883ddc2bc4c629991a087");
//启动翻译模式
define("OPEN_LANGUAGE_MODE", true);
//翻译过滤字段，简单说就是过滤那些一看就明白意思的字段
define("AZ_LANGUAGE_FILTER", "{id}{date}{clientdate}{sex}");

//JAVA包名
define("JAVA_PACKNAME", "yousi.com.http.data");
//JAVA头部文件
define("JAVA_HEAD", "package ".JAVA_PACKNAME.";[^][^]"
."import java.util.ArrayList;[^]"
."import org.json.JSONArray;[^]"
."import org.json.JSONObject;[^]"
."import General.Inter.HttpBase;[^]"
."import General.Inter.RerviceHttp;[^]"
."import General.System.MyLog;[^]"
."import android.content.Context;[^][^]");
//JAVA数据类保存路径
define("JAVA_DATA_SAVE_PATH", "/java/yousi/com/http/data/");


//JAVA原生头部文件
define("JAVA_NATIVE_HEAD", "package ".JAVA_PACKNAME.";[^][^]"
."import java.util.ArrayList;[^][^]"
."import org.json.JSONArray;[^]"
."import org.json.JSONObject;[^][^]"
."import android.content.Context;[^]"
."import android.util.Log;[^][^]");
//JAVA原生数据类保存路径
define("JAVA_NATIVE_DATA_SAVE_PATH", "/javanative/yousi/com/http/data/");



//JAVA HTTP包名
define("JAVA_HTTP_PACKNAME", "yousi.com.http");
//JAVA HTTP头部文件
define("JAVA_HTTP_HEAD", "package ".JAVA_HTTP_PACKNAME.";[^][^]"
."import java.io.File;[^]"
."import java.lang.reflect.Type;[^]"
."import java.util.HashMap;[^]"
."import java.util.Map;[^]"
."import java.util.ArrayList;[^][^]"
."import org.json.JSONObject;[^]"
."import org.json.JSONArray;[^][^]"
."import ".JAVA_PACKNAME.".{?};[^]"
."import General.Inter.HttpEnd;[^]"
."import General.Inter.RerviceHttp;[^]"
."import General.System.MyLog;[^]"
."import android.content.Context;[^][^]"
."import com.google.gson.reflect.TypeToken;[^][^]");
// JAVA请求数据类保存路径
define("JAVA_HTTP_DATA_SAVE_PATH", "/java/yousi/com/http/");


//JAVA原生 HTTP头部文件
define("JAVA_NATIVE_HTTP_HEAD", "package ".JAVA_HTTP_PACKNAME.";[^][^]"
."import java.io.File;[^]"
."import java.lang.reflect.Type;[^]"
."import java.util.HashMap;[^]"
."import java.util.Map;[^]"
."import java.util.ArrayList;[^][^]"
."import org.json.JSONObject;[^]"
."import org.json.JSONArray;[^][^]"
."import ".JAVA_PACKNAME.".{?};[^]"
."import android.content.Context;[^]"
."import android.util.Log;[^][^]"
."import com.google.gson.reflect.TypeToken;[^][^]");
// JAVA原生请求数据类保存路径
define("JAVA_NATIVE_HTTP_DATA_SAVE_PATH", "/javanative/yousi/com/http/");


//TXT数据类保存路径
define("TXT_DATA_SAVE_PATH", "/txt/http/data/");
//TXT请求数据类保存路径
define("TXT_HTTP_DATA_SAVE_PATH", "/txt/http/");


//SWIFT数据类保存路径
define("SWIFT_DATA_SAVE_PATH", "/swift/http/data/");
//SWIFT请求数据类保存路径
define("SWIFT_HTTP_DATA_SAVE_PATH", "/swift/http/");


//IOS数据类保存路径
define("IOS_DATA_SAVE_PATH", "/ios/yousi/com/http/data/");
//IOS请求数据类保存路径
define("IOS_HTTP_DATA_SAVE_PATH", "/ios/yousi/com/http/");

?>