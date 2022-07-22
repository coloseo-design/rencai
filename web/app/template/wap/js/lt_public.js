function jobadd_url(num,integral_job,type,online,pro){

	if(type == 'part'){
		
		gourl = 'index.php?c=partadd';
 	}else if(type == 'ltjob'){
 		
		gourl = 'index.php?c=lt_jobadd';
 	}else {
 		
		gourl = 'index.php?c=jobadd';
	}
	
	var url			=	wapurl + 'index.php?c=ajax&a=ajax_day_action_check';
	var checkUrl 	= 	wapurl + 'member/index.php?c=jobCheck';
	
	showLoading();
	
	$.post(url, {type : 'jobnum'}, function(data){
		
		hideLoading(); 
		
		data = eval('(' + data + ')');
		
		if(data.status == -1){
		
			showToast(data.msg);
			return false;
			
		}else if(data.status == 1){
			
			$.post(checkUrl, {rand:Math.random()}, function(data){
				
				var data = eval('(' + data + ')');
				
				if(data.msgList && data.msgList.length > 0){
					
					if(data.spid){						
						let content = data.msgList.join('')+'<div class="tjwmz">以上条件尚未满足，请联系主账号完成</div>'
						showConfirm(content,function(){
							window.location.href = wapurl + 'member/';
						});
					}else{
						
						let content = data.msgList.join('')+'<div class="tjwmz">以上条件尚未满足</div>';
						showConfirm(content,function(){
							window.location.href = wapurl + 'member/index.php?c=set';
						});
					}
					
					
				}else{

					if(num == 1 || (integral_job == 0 && num == 2)) {
						
						location.href = gourl;	
						
					}else{
						
						if(data.spid){
														
							let content = '当前账户套餐余量不足，请联系主账户增配！';
							showConfirm(content,function(){
								window.location.href = wapurl + 'member/index.php?c=set';
							},'','我知道了');
						}else{
							 
							if(num == 2) {
								
								if(online == 4 || data.singlecan=='2'){
									
									var msg	=	'您的会员套餐已用完，请先购买会员套餐！';
									
								}else{
									
									if(online == 3 && data.meal!=1){
										
										var jifen	=	accMul(parseInt(integral_job), parseInt(pro));
 										var msg		=	'套餐已用完，继续操作将会消费'+jifen+integral_pricename+'，是否继续？';
									}else{
										
										var msg		=	'套餐已用完，继续操作将会消费'+integral_job+'元，是否继续？';
									}
								}
								
							} else if(num == 0) {
									
								var msg 	= 	'您的会员已到期，请先升级会员等级！';
							}
							
							
							showConfirm(msg,function(){
								window.location.href = wapurl + 'member/index.php?c=server&server=issuejob';
							});
						}
					} 
				}
			});
		}
	});
}