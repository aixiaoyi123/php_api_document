<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			JSONArray {?}_list = HttpBase.jsonToArray(jsonObject, "{?}");
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			if ({?}_list != null) {
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;				for (int index = 0; index < {?}_list.length(); index++) {
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;					JSONObject jsonItemObject = {?}_list.getJSONObject(index);
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;					{!} {?}ItemData = new {!}();
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;					mBase.{?}.add({?}ItemData.getBase(mContext, jsonItemObject));
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;				}
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			}
