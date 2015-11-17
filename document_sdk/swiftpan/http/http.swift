{static}
<br />
<br />/**
<br /> * {note}
<br /> * @version {version}
<br /> * @author HuangYi
<br /> * @link email：95487710@qq.com
<br /> * */
<br />class {!}: RequestOperation {
<br />
<br />&nbsp;&nbsp;	let SWIFT_URL:String = "{url}"
<br />
<br />&nbsp;&nbsp;	init() {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		super.init(baseURL: NSURL(string: ""))
<br />&nbsp;&nbsp;	}
<br />
<br />&nbsp;&nbsp;	override func defaultURL() -> String {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		return SWIFT_URL
<br />&nbsp;&nbsp;	}
<br />
<br />&nbsp;&nbsp;	override func defaultPostMode() -> Bool {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		return {post}
<br />&nbsp;&nbsp;	}
<br />
<br />&nbsp;&nbsp;	override func defaultCookieMode() -> Bool {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		return {cookie}
<br />&nbsp;&nbsp;	}
<br />
<br />&nbsp;&nbsp;	override func defaultGetCookieMode() -> Bool {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		return {getcookie}
<br />&nbsp;&nbsp;	}
<br />
<br />&nbsp;&nbsp;	override func defaultParams() -> SADictionary {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		return [{params}]
<br />&nbsp;&nbsp;	}
<br />
<br />&nbsp;&nbsp;	required init(coder aDecoder: NSCoder) {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		fatalError("init(coder:) has not been implemented")
<br />&nbsp;&nbsp;	}
<br />
<br />{...}
<br />}