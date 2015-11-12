<?php
include_once(dirname(__FILE__)."/../data/DataElement.php");
include_once(dirname(__FILE__)."/../java/JavaFormatListener.php");
include_once(dirname(__FILE__)."/../java/JavaParseListener.php");

/**
 * JAVA结构体
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
class IosElement extends DataElement implements JavaFormatListener,JavaParseListener{

	// JAVA类型映射表
	public $JAVA_TYPE_KEY = array(
	/**字符串*/
	Element::TYPE_KEY_STRING           => "public String {?} = \"\";",
	/**4位整型*/
	Element::TYPE_KEY_INT        	   => "public int {?} = 0;",
	/**长整形*/
	Element::TYPE_KEY_LONG             => "public long {?} = 0;",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT            => "public float {?} = 0.0f;",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN          => "public boolean {?} = false;",
	/**数组队列*/
	Element::TYPE_KEY_ARRAY            => "public String[] {?} = null;",
	/**自定义类数组队列*/
	Element::TYPE_KEY_ARRAY_CLASS      => "[ ]public ArrayList&lt;{!}&gt; {?} = new ArrayList&lt;{!}&gt;();[^]",
	/**自定义类*/
	Element::TYPE_KEY_CLASS_CHILD      => "[ ]public {!} {?} = new {!}();[^]",
	/**内部类函数*/
	Element::TYPE_KEY_CLASS_NESTED     => "[ ]public class {!} {{...}{JSON}[ ]}",
	/**类*/
	Element::TYPE_KEY_CLASS     	   => "public class {!} {{...}{JSON}}",
	/**头部引用*/
	Element::TYPE_KEY_HEAD     	  	   => JAVA_HEAD
	/**待扩展*/
	);

	//JAVA方法映射表
	public $JAVA_TYPE_FUNCTION = array(
	/**字符串*/
	Element::TYPE_KEY_STRING           => "formatString",
	/**4位整型*/
	Element::TYPE_KEY_INT        	   => "formatInt",
	/**长整形*/
	Element::TYPE_KEY_LONG             => "formatLong",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT            => "formatFloat",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN          => "formatBool",
	/**数组队列*/
	Element::TYPE_KEY_ARRAY            => "formatArray",
	/**自定义类数组队列*/
	Element::TYPE_KEY_ARRAY_CLASS      => "formatArrayClass",
	/**自定义类*/
	Element::TYPE_KEY_CLASS_CHILD      => "formatClassChild",
	/**类*/
	Element::TYPE_KEY_CLASS     	   => "formatClass",
	/**头部引用*/
	Element::TYPE_KEY_HEAD     	       => "formatHead"
	/**待扩展*/
	);

	// JAVA解析映射表
	public $JAVA_PARSE_KEY = array(
	/**字符串*/
	Element::TYPE_KEY_STRING           => "mBase.{?} = HttpBase.jsonToString(jsonObject, \"{?}\");",
	/**4位整型*/
	Element::TYPE_KEY_INT        	   => "mBase.{?} = HttpBase.jsonToInt(jsonObject, \"{?}\");",
	/**长整形*/
	Element::TYPE_KEY_LONG             => "mBase.{?} = HttpBase.jsonToLong(jsonObject, \"{?}\");",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT            => "mBase.{?} = HttpBase.jsonToFloat(jsonObject, \"{?}\");",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN          => "mBase.{?} = HttpBase.jsonToBoolean(jsonObject, \"{?}\");",
	/**数组队列*/
	Element::TYPE_KEY_ARRAY            => "[ ][ ][ ]JSONArray {?}_list = HttpBase.jsonToArray(jsonObject, \"{?}\");[^][ ][ ][ ]if ({?}_list != null) {[^][ ][ ][ ][ ]mBase.{?} = new String[{?}_list.length()];[^][ ][ ][ ][ ]for (int index = 0; index < {?}_list.length(); index++) {[^][ ][ ][ ][ ][ ]mBase.{?}[index] = {?}_list.getString(index);[^][ ][ ][ ][ ]}[^][ ][ ][ ]}",
	/**自定义类数组队列*/
	Element::TYPE_KEY_ARRAY_CLASS      => "[ ][ ][ ]JSONArray {?}_list = HttpBase.jsonToArray(jsonObject, \"{?}\");[^][ ][ ][ ]if ({?}_list != null) {[^][ ][ ][ ][ ]for (int index = 0; index < {?}_list.length(); index++) {[^][ ][ ][ ][ ][ ]JSONObject jsonItemObject = {?}_list.getJSONObject(index);[^][ ][ ][ ][ ][ ]{!} {?}ItemData = new {!}();[^][ ][ ][ ][ ][ ]mBase.{?}.add({?}ItemData.getBase(mContext, jsonItemObject));[^][ ][ ][ ][ ]}[^][ ][ ][ ]}",
	/**自定义类*/
	Element::TYPE_KEY_CLASS_CHILD      => "[ ][ ][ ]JSONObject {?}_data = HttpBase.jsonToJSON(jsonObject, \"{?}\");[^][ ][ ][ ]if({?}_data != null) {[^][ ][ ][ ][ ]{!} {?}ItemData = new {!}();[^][ ][ ][ ][ ]mBase.{?} = {?}ItemData.getBase(mContext, {?}_data);[^][ ][ ][ ]}",
	/**内部类函数*/
	Element::TYPE_KEY_CLASS_NESTED     => "[ ][ ]public {!} getBase(Context mContext, JSONObject jsonObject) {[^][ ][ ][ ]{!} mBase = new {!}();[^][ ][ ][ ]try {[^]{...}[^][ ][ ][ ]} catch (Exception e) {[^][ ][ ][ ][ ]e.printStackTrace();[^][ ][ ][ ][ ]MyLog.d(RerviceHttp.class, \"{!} error e:\"+e.getMessage());[^][ ][ ][ ]}[^][ ][ ][ ]return mBase;[^][ ][ ]}[^]",
	/**类*/
	Element::TYPE_KEY_CLASS     	   => "[ ]public {!} getBase(Context mContext, JSONObject jsonObject) {[^][ ][ ]{!} mBase = new {!}();[^][ ][ ]try {[^]{...}[^][ ][ ]} catch (Exception e) {[^][ ][ ][ ]e.printStackTrace();[^][ ][ ][ ]MyLog.d(RerviceHttp.class, \"{!} error e:\"+e.getMessage());[^][ ][ ]}[^][ ][ ]return mBase;[^][ ]}[^]"
	/**待扩展*/
	);


	//JAVA解析Json方法映射表
	public $JAVA_PARSE_FUNCTION = array(
	/**字符串*/
	Element::TYPE_KEY_STRING           => "parseString",
	/**4位整型*/
	Element::TYPE_KEY_INT        	   => "parseInt",
	/**长整形*/
	Element::TYPE_KEY_LONG             => "parseLong",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT            => "parseFloat",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN          => "parseBool",
	/**数组队列*/
	Element::TYPE_KEY_ARRAY            => "parseArray",
	/**自定义类数组队列*/
	Element::TYPE_KEY_ARRAY_CLASS      => "parseArrayClass",
	/**自定义类*/
	Element::TYPE_KEY_CLASS_CHILD      => "parseClassChild",
	/**内部类*/
	Element::TYPE_KEY_CLASS_NESTED     => "parseClassNested",
	/**类*/
	Element::TYPE_KEY_CLASS     	   => "parseClass"
	/**待扩展*/
	);



	//构造方法
	function __construct($note = "") {
		parent::__construct($note, Element::PARSE_MODE_JAVA);
	}
	#@Overrides
	function getTypeKey(){

		return $this->JAVA_TYPE_KEY;

	}
	#@Overrides
	function autoType() {

		if (empty($this->value)){
			throw new Exception("getAutoType value is null!");
		}


		if(is_null($this->value)){

			$this->setType(Element::TYPE_KEY_STRING);

		}else if(is_array($this->value)){

			if (array_key_exists(0,$this->value)){
				if(is_array($this->value[0])){
					$this->setType(Element::TYPE_KEY_ARRAY_CLASS);
				}else{
					$this->setType(Element::TYPE_KEY_ARRAY);
				}
			}else{
				$this->setType(Element::TYPE_KEY_CLASS_CHILD);
			}

		}else if(is_bool($this->value)){

			$this->setType(Element::TYPE_KEY_BOOLEAN);

		}else if(is_numeric($this->value)){


			if(strpos($this->value,'.')){
				$this->setType(Element::TYPE_KEY_FLOAT);
			}else{
				$value = intval($this->value);
				if($value > 2147483647/2){
					$this->setType(Element::TYPE_KEY_LONG);
				}else{
					$this->setType(Element::TYPE_KEY_INT);
				}
			}

		}else if(is_object($this->value)){

			$this->setType(Element::TYPE_KEY_OBJECT);

		}else{

			$this->setType(Element::TYPE_KEY_STRING);

		}
	}

	#@Overrides
	function formatGeneralClass($dictionary,$key=""){

		$result ="";
		foreach ($dictionary as $itemkey => $value) {

			if(($value instanceof ClassElement) && $value->isShare){
				if(empty($key)){
					$key = $itemkey;
				}else{
					$key .= "；".$itemkey;
				}
				$arr = explode("；",$key);
				$data = $this->value;
				foreach($arr as $u){
					$data = $data[$u];
				}
				$function_name = "document".$value->name;
				if (function_exists($function_name)) {
					$result = $result.Element::ECHO_ENTER.Element::ECHO_ENTER.$function_name($data,Element::PARSE_MODE_JAVA).Element::ECHO_ENTER.Element::ECHO_ENTER;
				}else{
					throw new Exception( $value->name." function {$function_name} undefine!");
				}
			}else if(is_array($value)){
				if(empty($key)){
					$key = $itemkey;
				}else{
					$key .= "；".$itemkey;
				}
				$result .= $this->formatGeneralClass($value,$key);
			}
		}

		return $result;

	}
	#@Overrides
	function getFunctionName(){

		if (!array_key_exists($this->type, $this->JAVA_TYPE_FUNCTION)) {
			throw new Exception( "getFunctionName no found!");
		}

		return  $this->JAVA_TYPE_FUNCTION[$this->type];
	}

	#@Overrides
	function formatBasic($key) {

		$TypeKey = $this->getTypeKey();
		$note = $this->getNoteFormat();
		if (!array_key_exists($key,$TypeKey)){
			throw new Exception("formatBasic TypeKey no found $key !");
		}
		$format = $TypeKey[$key];
		$format = str_replace(Element::FORMAT_DATA_KEY, $this->name, $format);
		return Element::ECHO_SPLACE.$note.Element::ECHO_SPLACE.$format.Element::ECHO_ENTER;

	}
	#@Overrides
	function formatArray() {

		$TypeKey = $this->getTypeKey();
		$note = $this->getNoteFormat();
		if (!is_array($this->value)){
			throw new Exception("formatArray is_array error!");
		}
		$format = $TypeKey[Element::TYPE_KEY_ARRAY];
		$format = str_replace(Element::FORMAT_DATA_KEY, $this->name, $format);
		return Element::ECHO_SPLACE.$note.Element::ECHO_SPLACE.$format.Element::ECHO_ENTER;
	}
	#@Overrides
	function formatArrayClass() {

		$TypeKey = $this->getTypeKey();
		$note = $this->getNoteFormat();
		if (!is_array($this->value)){
			throw new Exception("formatArrayClass is_array error!");
		}
		if (!is_array($this->value[0])){
			throw new Exception("formatArrayClass value[0] is_array error!");
		}
		$format = $TypeKey[Element::TYPE_KEY_ARRAY_CLASS];
		if (empty($format)){
			throw new Exception("formatArrayClass TYPE_KEY_ARRAY_CLASS null!");
		}
		if(!$this->isShare){
			$format = $format. $TypeKey[Element::TYPE_KEY_CLASS_NESTED];
		}
		$format = str_replace(Element::FORMAT_DATA_KEY, $this->name, $format);
		$format = str_replace(Element::FORMAT_CLASS, $this->divname, $format);
		$data =  "";
		foreach ($this->value[0] as $key => $value) {

			if($value != null){
				$element = $this->getElement();
				$element->initElement($key,$value,$this->getClassElement($key));
				$data = $data.str_replace(Element::ECHO_ENTER, Element::FORMAT_ENTER.Element::FORMAT_SPLACE, $element->format());
			}

		}
		$data = Element::ECHO_ENTER.Element::ECHO_SPLACE.$data.Element::ECHO_ENTER;
		$format = str_replace(Element::FORMAT_DATA, $data, $format);
		if(!$this->isShare){
			$this->type = Element::TYPE_KEY_CLASS_NESTED;
			$this->value = $this->value[0];
			$format = str_replace(DataElement::FORMAT_JSON_DATA, $this->parse(), $format);
		}
		return Element::ECHO_ENTER.Element::ECHO_SPLACE.$note.$format.Element::ECHO_ENTER;


	}

	#@Overrides
	function formatClassChild() {

		$TypeKey = $this->getTypeKey();
		$note = $this->getNoteFormat();
		if (!is_array($this->value)){
			throw new Exception("formatClassChild is_array error!");
		}
		$format = $TypeKey[Element::TYPE_KEY_CLASS_CHILD];
		if (empty($format)){
			throw new Exception("formatClassChild TYPE_KEY_CLASS_CHILD null!");
		}
		if(!$this->isShare){
			$format = $format. $TypeKey[Element::TYPE_KEY_CLASS_NESTED];
		}
		$format = str_replace(Element::FORMAT_DATA_KEY, $this->name, $format);
		$format = str_replace(Element::FORMAT_CLASS, $this->divname, $format);

		$data =  "";
		foreach ($this->value as $key => $value) {

			if($value != null){
				$element = $this->getElement();
				$element->initElement($key,$value,$this->getClassElement($key));
				$data = $data.str_replace(Element::ECHO_ENTER, Element::FORMAT_ENTER.Element::FORMAT_SPLACE, $element->format());
			}

		}
		$data = Element::ECHO_ENTER.Element::ECHO_SPLACE.$data.Element::ECHO_ENTER;
		$format = str_replace(Element::FORMAT_DATA, $data, $format);
		if(!$this->isShare){
			$this->type = Element::TYPE_KEY_CLASS_NESTED;
			$format = str_replace(DataElement::FORMAT_JSON_DATA, $this->parse(), $format);
		}
		return Element::ECHO_ENTER.Element::ECHO_SPLACE.$note.$format.Element::ECHO_ENTER;



	}
	#@Overrides
	function formatClass() {

		$TypeKey = $this->getTypeKey();
		$note = $this->getNoteFormat();
		if (!is_array($this->value)){
			throw new Exception("formatClass is_array error!");
		}
		$format = $TypeKey[Element::TYPE_KEY_CLASS];
		if (empty($format)){
			throw new Exception("formatClass TYPE_KEY_CLASS null!");
		}
		$format = str_replace(Element::FORMAT_CLASS, $this->divname, $format);
		$data =  Element::ECHO_ENTER;
		foreach ($this->value as $key => $value) {
			if($value != null){
				$element = $this->getElement();
				$element->initElement($key,$value,$this->getClassElement($key));
				$data = $data.$element->format();
			}
		}
		$data = Element::ECHO_ENTER.$data.Element::ECHO_ENTER.Element::ECHO_ENTER;
		$format = str_replace(Element::FORMAT_DATA, $data, $format);
		$format = str_replace(DataElement::FORMAT_JSON_DATA, $this->parse(), $format);
		$result = JAVA_HEAD.$note.$format;
		$fileurl =$this->getFileUrl($result,$this->divname.".java");
		return Element::ECHO_ENTER.$fileurl.Element::ECHO_ENTER.Element::ECHO_ENTER.$result;
	}

	#@Overrides
	function getParseKey(){

		return $this->JAVA_PARSE_KEY;

	}

	#@Overrides
	function getParseName(){

		if (!array_key_exists($this->type, $this->JAVA_PARSE_FUNCTION)) {
			throw new Exception( "getParseName no found!");
		}

		return  $this->JAVA_PARSE_FUNCTION[$this->type];
	}

	#@Overrides
	function parseBasic($key) {

		$ParseKey = $this->getParseKey();
		if (!array_key_exists($key,$ParseKey)){
			throw new Exception("parseBasic ParseKey no found $key !");
		}
		$parse = $ParseKey[$key];
		$parse = str_replace(Element::FORMAT_DATA_KEY, $this->name, $parse);
		return Element::ECHO_SPLACE.Element::ECHO_SPLACE.Element::ECHO_SPLACE.$parse.Element::ECHO_ENTER;

	}
	#@Overrides
	function parseArray() {

		$ParseKey = $this->getParseKey();
		if (!is_array($this->value)){
			throw new Exception("parseArray is_array error!");
		}
		$parse = $ParseKey[Element::TYPE_KEY_ARRAY];
		$parse = str_replace(Element::FORMAT_DATA_KEY, $this->name, $parse);
		return $parse.Element::ECHO_ENTER;


	}

	#@Overrides
	function parseArrayClass() {

		$ParseKey = $this->getParseKey();
		if (!is_array($this->value)){
			throw new Exception("parseArrayClass is_array error!");
		}
		if (!is_array($this->value[0])){
			throw new Exception("parseArrayClass value[0] is_array error!");
		}
		$parse = $ParseKey[Element::TYPE_KEY_ARRAY_CLASS];
		if (empty($parse)){
			throw new Exception("parseArrayClass TYPE_KEY_ARRAY_CLASS null!");
		}
		$parse = str_replace(Element::FORMAT_DATA_KEY, $this->name, $parse);
		$parse = str_replace(Element::FORMAT_CLASS, $this->divname, $parse);

		return $parse.Element::ECHO_ENTER;

	}

	#@Overrides
	function parseClassChild() {

		$ParseKey = $this->getParseKey();
		if (!is_array($this->value)){
			throw new Exception("parseClassChild is_array error!");
		}
		$parse = $ParseKey[Element::TYPE_KEY_CLASS_CHILD];
		if (empty($parse)){
			throw new Exception("parseClassChild TYPE_KEY_CLASS_CHILD null!");
		}
		$parse = str_replace(Element::FORMAT_DATA_KEY, $this->name, $parse);
		$parse = str_replace(Element::FORMAT_CLASS, $this->divname, $parse);

		return $parse.Element::ECHO_ENTER;


	}

	#@Overrides
	function parseClassNested() {

		$ParseKey = $this->getParseKey();
		if (!is_array($this->value)){
			throw new Exception("parseClassNested is_array error!");
		}
		$parse = $ParseKey[Element::TYPE_KEY_CLASS_NESTED];
		if (empty($parse)){
			throw new Exception("parseClassNested TYPE_KEY_CLASS_NESTED null!");
		}
		if($this->isShare){
			return "";
		}
		$parse = str_replace(Element::FORMAT_DATA_KEY, $this->name, $parse);
		$parse = str_replace(Element::FORMAT_CLASS, $this->divname, $parse);
		$data =  Element::ECHO_ENTER.Element::ECHO_SPLACE;
		foreach ($this->value as $key => $value) {

			if($value != null){
				$element = $this->getElement();
				$element->initElement($key,$value,$this->getClassElement($key));
				$data = $data.str_replace(Element::ECHO_ENTER, Element::FORMAT_ENTER.Element::FORMAT_SPLACE, $element->parse());
			}

		}
		$parse = str_replace(Element::FORMAT_DATA, $data, $parse);
		return $parse.Element::ECHO_ENTER;


	}


	#@Overrides
	function parseClass() {

		$ParseKey = $this->getParseKey();
		if (!is_array($this->value)){
			throw new Exception("parseClass is_array error!");
		}
		$parse = $ParseKey[Element::TYPE_KEY_CLASS];
		if (empty($parse)){
			throw new Exception("parseClass TYPE_KEY_CLASS null!");
		}
		$parse = str_replace(Element::FORMAT_CLASS, $this->divname, $parse);
		$data =  Element::ECHO_ENTER;
		foreach ($this->value as $key => $value) {
			if($value != null){
				$element = $this->getElement();
				$element->initElement($key,$value,$this->getClassElement($key));
				$data = $data.$element->parse();
			}
		}
		$parse = str_replace(Element::FORMAT_DATA, $data, $parse);
		return $parse.Element::ECHO_ENTER;


	}


	#@Overrides
	function getStaticKey(){



	}

	#@Overrides
	function formatStatic($key){



	}


}
?>