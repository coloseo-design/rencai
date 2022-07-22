$(function(){
	$('#resume_detail').click(function() {
		$('#nowresume').fadeToggle(100)
	});
	$('#dwc').show();
	if(roomer == '1'){
		// 主动方
		var spviewinvite = window.localStorage.getItem('spviewinvite');
		if(spviewinvite == '1'){
			loadlayer();
			setTimeout(function(){
				layer.closeAll();
				sendComment(viewuid);
				window.localStorage.setItem("spviewinvite", "2");
			},2000);
		}else{
			$("#reinvite").show();
			$('#dwc').hide();
		}
	}else{
		// 非主动方
		var isspview = window.localStorage.getItem("isspview");
		setTimeout(function(){
			if(isspview && isspview == '1'){
				sendCommentAllow();
				joinRoom();
				window.localStorage.setItem("isspview", "2");
			}
		},1000);
	}
})

