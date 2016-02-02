<br />- (void)request{?}ResultHandle:(void (^)(BOOL isSuccess, id responseObject))handle{
<br />
<br />&nbsp;&nbsp;	[self requestResultHandle:^(BOOL isSuccess, id responseObject) {
<br />&nbsp;&nbsp;&nbsp;&nbsp;		if(isSuccess){
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			self.mBase = [{?} mj_objectWithKeyValues:responseObject[[self getResultTag]]];
<br />&nbsp;&nbsp;&nbsp;&nbsp;		}
<br />&nbsp;&nbsp;&nbsp;&nbsp;		if(handle){
<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			handle(isSuccess, responseObject);
<br />&nbsp;&nbsp;&nbsp;&nbsp;		}
<br />&nbsp;&nbsp;	}];
<br />}