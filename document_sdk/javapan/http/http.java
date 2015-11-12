<br />
<br />/**
<br /> * {note}
<br /> * @version {version}
<br /> * @author HuangYi
<br /> * @link email：95487710@qq.com
<br /> * */
<br />public class {!} extends BasicHttp {
<br />
<br />&nbsp;&nbsp;	private static final String URL = "{url}?";
<br />
<br />&nbsp;&nbsp;	public {!}(Context mContext, HttpEnd mHttpEnd) {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		super(mContext, mHttpEnd);
<br />&nbsp;&nbsp;	}
<br />
<br />&nbsp;&nbsp;	@Override
<br />&nbsp;&nbsp;	public String getHttpUrl() {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		return URL{params};
<br />&nbsp;&nbsp;	}
<br />
<br />&nbsp;&nbsp;	@Override
<br />&nbsp;&nbsp;	public boolean isPostMode() {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		return {post};
<br />&nbsp;&nbsp;	}
<br />
<br />&nbsp;&nbsp;	@Override
<br />&nbsp;&nbsp;	public boolean isCookieMode() {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		return {cookie};
<br />&nbsp;&nbsp;	}
<br />
<br />&nbsp;&nbsp;	@Override
<br />&nbsp;&nbsp;	public boolean isGetCookieMode() {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		return {getcookie};
<br />&nbsp;&nbsp;	}
<br />	
<br />&nbsp;&nbsp;	/** 获取解析的标签，null的时候为默认的解析方式，即解析data字段 */
<br />&nbsp;&nbsp;	@Override
<br />&nbsp;&nbsp;	public String getDataTab() {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		// TODO Auto-generated method stub
<br />&nbsp;&nbsp;&nbsp;&nbsp;		return {tab};
<br />&nbsp;&nbsp;	}
<br />{...}
<br />}
