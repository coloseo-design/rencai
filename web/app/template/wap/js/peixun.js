// 关注培训讲师
function atnteacher(tid,id){
	if(id){
		showLoading()
		$.post(wapurl+'index.php?c=ajax&a=atn_teacher',{id:id,tid:tid},function(data){
			hideLoading(); 
			var data=eval('('+data+')');
			if(data.errcode==1 && !data.cancel){
				showToast('关注成功');
				$("#gz_"+tid).removeClass('firm_name_gz');
				$("#gz_"+tid).addClass('firm_name_gz_no');
				$("#atn_"+tid).html('取消关注');
			}else if(data.errcode==1 && data.cancel == 1){
				showToast('取消关注');
				$("#gz_"+tid).removeClass('firm_name_gz_no');
				$("#gz_"+tid).addClass('firm_name_gz'); 
				$("#atn_"+tid).html('关注');
			}else{
				showToast(data.msg);return false;
			}
		});
	}
}

/* 是否退出当前用户，并注册培训用户 */
function istrainlogin(){
	showConfirm("只有培训用户可发布，是否登录培训用户？", function(){
		window.location.href ='index.php?c=login';
		window.event.returnValue = false;
		return false;
	},'取消','登录');
}