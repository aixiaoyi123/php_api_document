<?php
include_once(dirname(__FILE__)."/../java/JavaElement.php");

/**
 * JAVA原生结构体
 * @author HuangYi
 * @link email：95487710@qq.com
 * */
class JavaNativeElement extends JavaElement{


	// JAVA解析映射表
	public $JAVA_NATIVE_PARSE_KEY = array(
	/**字符串*/
	Element::TYPE_KEY_STRING           => "/javanativepan/parse/string.java",
	/**4位整型*/
	Element::TYPE_KEY_INT        	   => "/javanativepan/parse/int.java",
	/**长整形*/
	Element::TYPE_KEY_LONG             => "/javanativepan/parse/long.java",
	/**浮点数*/
	Element::TYPE_KEY_FLOAT            => "/javanativepan/parse/float.java",
	/**布尔型*/
	Element::TYPE_KEY_BOOLEAN          => "/javanativepan/parse/boolean.java",
	/**数组队列*/
	Element::TYPE_KEY_ARRAY            => "/javanativepan/parse/array.java",
	/**自定义类数组队列*/
	Element::TYPE_KEY_ARRAY_CLASS      => "/javanativepan/parse/array_class.java",
	/**自定义类*/
	Element::TYPE_KEY_CLASS_CHILD      => "/javanativepan/parse/class_child.java",
	/**内部类函数*/
	Element::TYPE_KEY_CLASS_NESTED     => "/javanativepan/parse/class_nested.java",
	/**类*/
	Element::TYPE_KEY_CLASS     	   => "/javanativepan/parse/class.java"
	/**待扩展*/
	);


	//构造方法
	function __construct($note = "" , $parse = Element::PARSE_MODE_JAVA_NATIVE) {
		parent::__construct($note, $parse);
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
					if(isset($data[$u])){
						$data = $data[$u];
					}
				}
				$class = $value->name;
				if(class_exists($class)){
					$elment = new $class();
					if($elment instanceof NoteClass){
						$node = $elment->format($data,Element::PARSE_MODE_JAVA_NATIVE);
						$result = $result.Element::ECHO_ENTER.Element::ECHO_ENTER.$node->format().Element::ECHO_ENTER.Element::ECHO_ENTER;
						$this->setFileList($node->getFileList());
					}else{
						throw new Exception( $value->name." no extend NoteClass!");
					}
				}else{
					throw new Exception( $value->name." class undefine!");
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
	function formatClass() {

		$TypeKey = $this->getTypeKey();
		$note = parent::getNoteFormat();
		if (!is_array($this->value)){
			throw new Exception("formatClass is_array error!");
		}
		$format = $TypeKey[Element::TYPE_KEY_CLASS];
		$format = parent::getFileContents($format);
		if (empty($format)){
			throw new Exception("formatClass TYPE_KEY_CLASS null!");
		}
		$format = str_replace(Element::FORMAT_CLASS, $this->divname, $format);
		$data =  "";
		foreach ($this->value as $key => $value) {
			if($value != null){
				$element = $this->getElement();
				$element->initElement($key,$value,$this->getClassElement($key));
				$data = $data.$element->format();
			}
		}
		$format = str_replace(Element::FORMAT_DATA, $data, $format);
		$format = str_replace(DataElement::FORMAT_JSON_DATA, $this->parse(), $format);
		$format = str_replace(Element::FORMAT_NOTE, $note, $format);
		$format = str_replace(Element::FORMAT_VERSION, $this->version, $format);
		$result = JAVA_NATIVE_HEAD.$format;
		$fileurl =$this->getFileUrl($result,$this->divname.".java");
		return $result;
	}


	#@Overrides
	function getParseKey(){

		return $this->JAVA_NATIVE_PARSE_KEY;

	}

}
?>