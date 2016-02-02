<br />
<br />/**
<br /> * {note}
<br /> * @version {version}
<br /> * @author HuangYi
<br /> * @link email：95487710@qq.com
<br /> * */
<br />#import "{!}.h"
<br />
<br />@implementation {!}
<br />
<br />#pragma mark -
<br />- (NSDictionary *)getUrlParam{
<br />&nbsp;&nbsp;	NSDictionary *paramDic = @{{params}};
<br />&nbsp;&nbsp;	return paramDic;
<br />}
<br />
<br />#pragma mark -
<br />- (NSString *)getUrl{
<br />&nbsp;&nbsp;	return [NSString stringWithFormat:@"%@", {!!}_URLAPI];
<br />}
<br />
<br />#pragma mark -
<br />- (BOOL)isPost{
<br />&nbsp;&nbsp;	return {post};
<br />}
<br />
<br />#pragma mark -
<br />- (BOOL)isCookie{
<br />&nbsp;&nbsp;	return {cookie};
<br />}
<br />
<br />#pragma mark -
<br />- (BOOL)isGetCookie{
<br />&nbsp;&nbsp;	return {getcookie};
<br />}
<br />	
<br />#pragma mark -
<br />- (BOOL)isCache{
<br />&nbsp;&nbsp;	return {cache};
<br />}
<br />	
<br />#pragma mark -
<br />- (NSString *)getDivTag{
<br />&nbsp;&nbsp;	return {tab};
<br />}
<br />{...}
<br />@end
