function goChat(){
	window.open(weburl + '/member/index.php?c=chat');
}
function zphnetChat(id, eid, usertype, name,obj) {
	if(obj && $(obj).attr('data-zid')){
		var zid = $(obj).attr('data-zid');
		layer.load('请稍候...', 0);
		$.post(weburl + "/index.php?m=zphnet&c=isJoin",{zid: zid}, function(data) {
			layer.closeAll('loading');
			var data = eval('(' + data + ')');
			if(data.code == 1){
				if(data.status == '1'){
					resumeChat(id, eid, usertype, name,obj);
				}else if(data.status == '2'){
					return layer.msg('参会报名审核未通过，请联系管理员',2,8);
				}else{
					layer.msg('参会报名审核中',2,8);
				}
			}else{
				
				layer.confirm('您尚未参会，请先报名！',function(){
					clickZphnet(id)
				});
			}
		});
	}else{
		return layer.msg('参数异常！',2,8);
	}
}
function resumeChat(id, eid, usertype, name,obj) {
	if(usertype && usertype != ''){
		if(usertype==1){
			layer.msg('请先申请企业用户',2,8);
			return false;
		}
		var zid  =  0;
		if(obj){
			zid = $(obj).attr('data-zid');
		}
		var i = layer.load('请稍候...', 0);
		$.ajax({
			url: weburl + "/index.php?m=chat&c=getdown",
			async: false,
			data: {
				toid: id,
				eid: eid,
				nowtype: usertype,
				zid: zid
			},
			type:'POST',
			success:function (data) {
				layer.closeAll('loading');
				var res = eval('(' + data + ')');

				if (res.code == 0) {

					toMemberChat(id,eid,'',zid);
				} else if (res.code == 1) {
					layer.alert('您还没有招聘中的职位，是否先发布职位？', 0, '提示', function() {
						window.location.href = weburl + "/member/index.php?c=job&w=1";
						window.event.returnValue = false;
						return false;
					});
				} else if (res.code == 2) {
					layer.alert('您还没有招聘中的职位，是否先发布职位？', 0, '提示', function() {
						window.location.href = weburl + "/member/index.php?c=job&s=1";
						window.event.returnValue = false;
						return false;
					});
				} else if(res.code == 3){
					
					$('#chatid').val(id);
					server_single('chat');
				
					firstTab();
					var msglayer = layer.open({
						type: 1,
						title: name,
						closeBtn: 1,
						border: [10, 0.3, '#000', true],
						area: ['auto', 'auto'],
						content: $("#tcmsg"),
						cancel:function(){
							window.location.reload();
						}
					});
					return false;
				} else if (res.code == 4) {
					layer.msg(res.msg , 2, 8);return false;
				} else if (res.code == 5) {
					layer.closeAll();
					showlogin(usertype);
				} else if (res.code == 6) {
					layer.msg('自己无法与自己' + name, 2, 8);
					return false;
				} else if (res.code == 7) {
					layer.msg('当前用户身份不符', 2, 8, function(){
						location.reload();
					});
				} else if (res.code == 8) {
					layer.msg('您的账号还未通过审核，请联系网站客服', 2, 8);
					return false;
				} else if (res.code == 9) {
					layer.msg('您的账号已被锁定，请联系网站客服', 2, 8);
					return false;
				} else if (res.code == 10) {
					layer.msg('您的账号未通过审核，请联系网站客服', 2, 8);
					return false;
				}
			}
		});
	}else{
		showlogin('2');
	}
}
function jobChat(id,jobtype,usertype,jobid,name,userchange,obj) {
	if(usertype && usertype != ''){
		if(usertype!=1){
			if(userchange==1){
				layer.msg('请先转换为求职者，才能' +name, 2, 8);
				return false;
			}else{
				layer.msg('只有个人用户才能' +name, 2, 8);
				return false;
			}
			return false;
		}
		var i = layer.load('加载中..', 0);
		var zid  =  0;
		if(obj){
			zid = $(obj).attr('data-zid');
		}
		$.ajax({
			url:weburl + "/index.php?m=chat&c=isResume",
			async: false,
			data: {
				jobtype: jobtype,
				id: id,
				jobid: jobid,
				nowtype: usertype,
				zid: zid
			},
			type:'POST',
			success:function (data) {
				layer.closeAll();
				var res = eval('(' + data + ')');
				if (res.code == 1 || res.code == 5) {
					var i = layer.load('加载中..', 0);
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
						url:weburl + "/index.php?m=chat&c=beginChat",
						async: false,
						data: pdata,
						type:'POST',
						success:function (data) {
							layer.close(i);
							var chaturl = weburl + '/member/index.php?c=chat&id=' + id  + '&type=' + pdata.usertype;
							if(jobid){
								chaturl += '&jid=' + jobid;
							}
							window.open(chaturl);
						}
					});
				} else if (res.code == 2) {
					layer.alert('您还没有简历，是否先添加简历？', 0, '提示', function() {
						window.location.href = weburl + "/member/index.php?c=expect&act=add";
						window.event.returnValue = false;
						return false;
					});
				} else if (res.code == 3) {
					layer.alert('您还没有优质简历，是否先添加简历？', 0, '提示', function() {
						window.location.href = weburl + "/member/index.php?c=resume";
						window.event.returnValue = false;
						return false;
					});
				}  else if (res.code == 4) {
					showlogin('1');
				} else if (res.code == 6) {
					layer.msg('您的简历未通过审核，无法' + name, 2, 8);
					return false;
				} else if (res.code == 7) {
					layer.msg('您的简历还在审核中，无法' + name, 2, 8);
					return false;
				} else if (res.code == 8) {
					layer.msg('您的简历已被举报，无法' + name, 2, 8);
					return false;
				} else if (res.code == 9) {
					layer.msg('请先向企业的在招职位投递简历', 2, 8);
					return false;
				} else if (res.code == 10) {
					layer.msg('自己无法和自己' +name, 2, 8);
					return false;
				} else if (res.code == 11) {
					layer.msg('当前用户身份不符', 2, 8, function(){
						location.reload();
					});
				}
			}
		});
	}else{
		showlogin('1');
	}
}
function toMemberChat(id, eid, dir, zid){
	var i = layer.load('请稍候...', 0);
	$.ajax({
		url: weburl + "/index.php?m=chat&c=beginChat",
		async: false,
		data: {
			id: id,
			usertype: 1,
			timestamp: Date.now()
		},
		type:'POST',
		success:function (data) {
			layer.closeAll('loading');
			if(zid){
				var chaturl = weburl + '/member/index.php?c=chat&id=' + id  + '&type=1&zid=' + zid;
			}else{
				var chaturl = weburl + '/member/index.php?c=chat&id=' + id  + '&type=1';
			}
			if(eid){
				chaturl+= '&eid=' + eid;
			}
			if(dir && dir == 'member'){
				window.location.href = chaturl;
			}else{
				window.open(chaturl);
			}
		}
	});
}