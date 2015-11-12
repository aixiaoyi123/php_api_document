<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			JSONArray {?}_list = jsonObject.getJSONArray("{?}");
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			if ({?}_list != null) {
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;				mBase.{?} = new {!}[{?}_list.length()];
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;				for (int index = 0; index < {?}_list.length(); index++) {
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;					mBase.{?}[index] = ({Object}){?}_list.get(index);
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;				}
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			}
