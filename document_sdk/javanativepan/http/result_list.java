<br />&nbsp;&nbsp;	public List<{?}> mBase = new ArrayList<{?}>();
<br />	
<br />&nbsp;&nbsp;	public void getGson(Object mObject) {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		mBase = (List<{?}>) mObject;
<br />&nbsp;&nbsp;	}
<br />
<br />&nbsp;&nbsp;	public TypeToken getTypeToken() {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		return new TypeToken<List<{?}>>() {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		};
<br />&nbsp;&nbsp;	}
<br />