<br />&nbsp;&nbsp;	/** 解析方法 */
<br />&nbsp;&nbsp;	func requestData(block:((resObj:[{?}])->Void)) {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		self.requestDataWithUrl { (isSucces, errorType, response) -> Void in
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			if response != nil {
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;				if let objs = response as? [SADictionary] {
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;					var lists:[{?}] = []
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;					for obj in objs {
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;						lists.append({?}(dict: obj))
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;					}
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;					block(resObj: lists)
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;				}
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			} 
<br />&nbsp;&nbsp;&nbsp;&nbsp;		}
<br />&nbsp;&nbsp;	}
<br />