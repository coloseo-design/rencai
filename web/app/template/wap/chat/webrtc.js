$(function() {
	if(roomer == '1'){
		// 主动方
		var spviewinvite = window.localStorage.getItem('spviewinvite');
		if(spviewinvite == '1'){
			$("#spComment").css('display', 'block');
			showLoading();
			setTimeout(function(){
				hideLoading();
				sendComment(viewuid);
				sendWxNotice('',''+viewuid+'',''+jid+'');
				window.localStorage.setItem("spviewinvite", "2");
			},2000);
		}
	}else{
		// 非主动方
		if(usertype == '2'){
			// 企业挂断处理
			$("#hangUp").attr('onclick', 'spviewClose()');
		}
		var isspview = window.localStorage.getItem("isspview");
		setTimeout(function(){
			if(isspview && isspview == '1'){
				sendCommentAllow();
				joinRoom();
				window.localStorage.setItem("isspview", "2");
			}
		},1000);
	}
});