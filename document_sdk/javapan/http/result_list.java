<br />&nbsp;&nbsp;	public List&lt;{?}&gt; mBase = new ArrayList&lt;{?}&gt;();
<br />	
<br />&nbsp;&nbsp;	@Override
<br />&nbsp;&nbsp;	public void getGson(Object mObject) {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		mBase = (List&lt;{?}&gt;) mObject;
<br />&nbsp;&nbsp;	}
<br />
<br />&nbsp;&nbsp;	@Override
<br />&nbsp;&nbsp;	public TypeToken getTypeToken() {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		return new TypeToken&lt;List&lt;{?}&gt;&gt;() {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		};
<br />&nbsp;&nbsp;	}
<br />