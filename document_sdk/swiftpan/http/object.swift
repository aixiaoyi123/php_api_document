<br />&nbsp;&nbsp;	/** 解析方法 */
<br />&nbsp;&nbsp;	func requestData(block:((resObj:{?})->Void)) {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		self.requestDataWithUrl { (isSucces, errorType, response) -> Void in
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			if response != nil {
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;				 block(resObj: {?}(dict: response! as! SADictionary))
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			} 
<br />&nbsp;&nbsp;&nbsp;&nbsp;		}
<br />&nbsp;&nbsp;	}
<br />