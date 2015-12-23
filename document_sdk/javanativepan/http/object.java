<br />&nbsp;&nbsp;	/** 重写自动解析 */
<br />&nbsp;&nbsp;	public Object getObject(String json, Type type) {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		{?} base = new {?}();
<br />&nbsp;&nbsp;&nbsp;&nbsp;		try {
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			JSONObject jsonObject = new JSONObject(json);
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			base = base.getBase(mContext, jsonObject);
<br />&nbsp;&nbsp;&nbsp;&nbsp;		} catch (Exception e) {
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			e.printStackTrace();
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			Log.d("{?}", "getObject error e:" + e.getMessage());
<br />&nbsp;&nbsp;&nbsp;&nbsp;		}
<br />&nbsp;&nbsp;&nbsp;&nbsp;		return base;
<br />&nbsp;&nbsp;	}
<br />