function zphnetChat(id, eid, usertype, name,obj) {
	if(obj && $(obj).attr('data-zid')){
		var zid = $(obj).attr('data-zid');
		showLoading()
		$.post(wapurl + "index.php?c=zphnet&a=isJoin",{zid: zid}, function(data) {
			hideLoading('loading');
			var data = eval('(' + data + ')');
			if(data.code == 1){
				
				if(data.status == '1'){
					resumeChat(id, eid, usertype, name,obj);
				}else if(data.status == '2'){
					return showToast('参会报名审核未通过，请联系管理员');
				}else{
					showToast('参会报名审核中');
				}
			}else{				
				showConfirm('您尚未参会，请先参会！', function(e){
					if(e.index==1){
						clickZphnet(id);
					}
				})
			}
		});
	}else{
		return showToast('参数异常！');
	}
}
function resumeChat(id, eid, usertype, name,obj){
	if(usertype && usertype != ''){
		if(usertype==1){
			showToast('招聘者才能和求职者' + name);
			return false;
		}
		var zid  =  0;
		if(obj){
			zid = $(obj).attr('data-zid');
		}
		var i=showLoading()
		$.post(wapurl + "index.php?c=chat&a=getdown",{
				toid: id,
				eid: eid,
				nowtype: usertype,
				zid: zid
			},function(data){
			hideLoading();
			var res = eval('(' + data + ')');
			if(res.code == 0){
				showLoading();
				$.ajax({
					url: wapurl + "index.php?c=chat&a=beginChat",
					async: false,
					data: {
						id: id,
						usertype: 1,
						timestamp: Date.now()
					},
					type:'POST',
					success:function (sdata) {
						hideLoading();
						var url = wapurl+'?c=chat&id='+id + '&type=1&eid=' + eid;
						window.location.href = url;
					}
				});
			}else if(res.code==1){
			  	showConfirm('您还没有招聘中的职位，是否先发布职位？',function(){
					window.location.href = wapurl+"/member/index.php?c=job";
				});
			}else if(res.code==2){
			  	showConfirm('您还没有招聘中的职位，是否先发布职位？',function(){
					window.location.href = wapurl+"/member/index.php?c=job&s=1";
				});
			}else if(res.code==3){
			  	showConfirm(res.msg,function(){
					window.location.href = wapurl + "member/index.php?c=server&server=chat&id="+ id;
				});
				return false;
			}else if(res.code==4){
				showToast(res.msg);
			}else if(res.code==5){
				pleaselogin('请先登录', wapurl+'?c=login');
			}else if(res.code==6){
				showToast('自己无法和自己' + name);return false;
			} else if (res.code == 7) {
				showToast('当前用户身份不符', function(){
					location.reload();
				});
			} else if (res.code == 8) {
				showToast('您的账号还未通过审核，请联系网站客服');
				return false;
			} else if (res.code == 9) {
				showToast('您的账号已被锁定，请联系网站客服');
				return false;
			} else if (res.code == 10) {
				showToast('您的账号未通过审核，请联系网站客服');
				return false;
			}
		});
	}else{
		pleaselogin('请先登录', wapurl+'?c=login');
	}
}
function jobChat(id, jobtype, usertype, jobid,name,obj){
	if(usertype && usertype != ''){
		if(usertype != '1'){
			showToast('求职者才能和主管'+ name,2);
			return false;
		}
		var zid  =  0;
		if(obj){
			zid = $(obj).attr('data-zid');
		}
		var i=showLoading();
		$.post(wapurl+"index.php?c=chat&a=isResume",{jobtype: jobtype, id: id, jobid: jobid, nowtype: usertype, zid: zid},function(data){
			hideLoading();
			var res = eval('(' + data + ')');
			if(res.code==1 || res.code==5){
				showLoading();
				var pdata = {
					id: id,
					timestamp: Date.now(),
					jobid: jobid,
					jobtype: jobtype
				}
				if(jobtype == 'com'){
					pdata.usertype = 2;
				}else{
					pdata.usertype = 3;
				}
				$.ajax({
					url: wapurl + "index.php?c=chat&a=beginChat",
					async: false,
					data: pdata,
					type:'POST',
					success:function (sdata) {
						hideLoading();
						var url = wapurl+'?c=chat&id='+id + '&type=' + pdata.usertype;
						if(jobid){
							url += '&jid=' + jobid;
						}
						window.location.href = url;
					}
				});
			}else if(res.code==2){
			  	showConfirm('您还没有简历，是否先添加简历？',function(){
					window.location.href = wapurl+"member/index.php?c=addresume";
				});
			}else if(res.code==3){
			  	showConfirm('您还没有简历,先去创建简历?',function(){
					window.location.href = wapurl+"member/index.php?c=resume";
				});
			}else if(res.code==4){
				pleaselogin('请先登录', wapurl+'?c=login');
			}else if(res.code==6){
				showToast('您的简历未通过审核，无法'+name);return false;
			}else if(res.code==7){
				showToast('您的简历还在审核中，无法'+name);return false;
			}else if(res.code==8){
				showToast('您的简历已被举报，无法'+name);return false;
			}else if(res.code==9){

				showToast('请先向企业的在招职位投递简历');
				
				if($("#job")){
					setTimeout(function(){
						$("html,body").animate({scrollTop:$("#job").offset().top},300);
					},2000)
				}
				
				
				return false;

			}else if(res.code==10){
				showToast('自己无法和自己' + name);return false;
			}else if (res.code == 11) {
				showToast('当前用户身份不符', function(){
					location.reload();
				});
			}
		})
	}else{
		pleaselogin('请先登录', wapurl+'?c=login');
	}
}
function toChat(id,type){
	window.location.href = wapurl + 'index.php?c=chat&id=' + id + '&type=' + type;
}