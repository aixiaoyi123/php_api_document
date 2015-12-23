<br />&nbsp;&nbsp;	/** {note} */
<br />&nbsp;&nbsp;	public Map&lt;String, File&gt; mUploadFile = new HashMap&lt;String, File&gt;();
<br />{...}
<br />&nbsp;&nbsp;	private void setPath(String mKey, String mPath) {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		mUploadFile.put(mKey, new File(mPath));
<br />&nbsp;&nbsp;	}
<br />
<br />&nbsp;&nbsp;	public Map&lt;String, File&gt; getSendFile() {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		if (mUploadFile == null || mUploadFile.size() <= 0) {
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			return new HashMap&lt;String, File&gt;();
<br />&nbsp;&nbsp;&nbsp;&nbsp;		}
<br />&nbsp;&nbsp;&nbsp;&nbsp;		return mUploadFile;
<br />&nbsp;&nbsp;	}
<br />