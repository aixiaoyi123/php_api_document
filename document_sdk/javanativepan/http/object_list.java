<br />&nbsp;&nbsp;	/** 重写自动解析,数组类型 */
<br />&nbsp;&nbsp;	public Object getObject(String json, Type type) {
<br />
<br />&nbsp;&nbsp;&nbsp;&nbsp;		List&lt;{?}&gt; base = new ArrayList&lt;{?}&gt;();
<br />&nbsp;&nbsp;&nbsp;&nbsp;		try {
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			JSONArray data = new JSONArray(json);
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			for (int index = 0; index < data.length(); index++) {
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;				JSONObject jsonObject = data.getJSONObject(index);
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;				{?} item = new {?}();
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;				item = item.getBase(mContext, jsonObject);
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;				base.add(item);
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			}
<br />&nbsp;&nbsp;&nbsp;&nbsp;		} catch (Exception e) {
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			e.printStackTrace();
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			Log.d("{?}", "getObject List error e:" + e.getMessage());
<br />&nbsp;&nbsp;&nbsp;&nbsp;		}
<br />&nbsp;&nbsp;&nbsp;&nbsp;		return base;
<br />&nbsp;&nbsp;	}
<br />