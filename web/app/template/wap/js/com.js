function comjobAdd(url ,param, callback){
	
	showLoading();
	$.post(url, {provider: 'h5'}, function (data) {
		hideLoading();

		if (data.error == 0){
			let res = data.data,
				checked = {};
			if(res.need){
				if(res.need.name){
					checked.name = true;
				}else{
					checked.name = false;
				}
				if(res.need.tel){
					checked.tel = true;
				}else{
					checked.tel = false;
				}
				if(res.need.email){
					checked.email = true;
				}else{
					checked.email = false;
				}
				if(res.need.yyzz){
					checked.yyzz = true;
				}else{
					checked.yyzz = false;
				}
				if(res.need.xy){
					checked.xy = true;
				}else{
					checked.xy = false;
				}
				if(res.need.gzh){
					checked.gzh = res.need.gzh;
				}else{
					checked.gzh = 0;
				}
				if(callback){
					callback(checked);
				}
			}else if(res.num && res.num == 1){
				
				if(param.job=='part'){
					navigateTo(wapurl+'member/index.php?c=partadd');
				}else if(param.job=='job'){
					navigateTo(wapurl+'member/index.php?c=jobadd');
				}else if(param.job=='ltjob'){
					navigateTo(wapurl+'member/index.php?c=lt_jobadd');
				}
			}else{
				if(res.spid){
					showToast(res.msg);
				}else{
					if(callback){
						callback({msg: res.msg});
					}
				}
			}
		}else{
			showToast(data.msg);
		}
	}, 'json');
}
function comjobRefresh(url, param, callback){
	showLoading();
	$.post(url, param, function (data) {
		hideLoading();
		if (data.error == 0) {
			showToast(data.msg);
		} else if (data.error == 3) {
			if(callback){
				callback({msg: data.msg});
			}
		} else {
			showToast(data.msg);
		}
	})
}