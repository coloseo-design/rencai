$(function() {
	getLineData();
	$('#resume_detail').click(function() {
		var ruid = $(this).attr('data-uid');
		lookresume(ruid);
	});
})
//暂停面试
function spviewPause() {
	if (viewuid) {
		var msg = '确定结束与对方的面试，并将面试间设置为暂停开放？';
	}else{
		var msg = '确定将面试间设置为暂停开放？';
	}
	layer.confirm(msg, {
		btn: ['确定', '取消']
	}, function() {
		document.getElementById('reinvite').style.display = 'none';
		if(commentState == 'commenting'){
			// 正在视频中需要结束当前视频
			leaveRoom();
		}
		var loadi = loadlayer();
		$.post("index.php?c=spview&act=spviewPause", {
			'sid': sid
		}, function(data) {
			data = eval('(' + data + ')');
			layer.closeAll();
			if (data.errorcode == '9') {
				viewuid = '';
				getLineData();
			} else {
				layer.msg(data.msg, 2, 8);
			}
		});
	});
}
//判断询问是否进行下一位面试
function spviewNextAsk(nowuid) {
	if (viewuid) {
		layer.confirm('确定结束当前面试，发出新的邀请？', {
			btn: ['确定', '取消']
		}, function() {
			spviewNext(nowuid);
		});
	} else {
		spviewNext(nowuid);
	}
}
//进行下一位面试
function spviewNext(nowuid) {
	if(commentState == 'commenting'){
		// 正在视频中需要结束当前视频
		leaveRoom();
		if (splogid != ''){
			// 记录结束日志
			var post = {}
		
			post.startTime = startTime;
			post.endTime = new Date().getTime();
			post.splogid = splogid;
			post.spend = 1;
			post.roomer = 1;
			$.post("index.php?c=spview&act=splog", post, function(data) {
				if(document.referrer != ''){
					history.back();
				}else{
					window.location.href = weburl + '/member/';
				}
			});
			splogid = '';
		}
	}
	var loadi = loadlayer();
	setTimeout(function(){
		$.post("index.php?c=spview&act=spviewNext", {
			'sid': sid,
			'nowuid': nowuid
		}, function(data) {
			layer.closeAll();
			data = eval('(' + data + ')');
			if (data.errorcode == '9') {
				getLineData(data.nextuid, 'next');
			} else {
				layer.msg(data.msg, 2, 8, function(){
					window.location.reload();
				});
				return false;
			}
		});
	},800);
}

//终止面试
function spviewFinish() {

	var i = layer.confirm('确定终止面试并关闭面试间？', {
		btn: ['确定', '取消']
	}, function() {
		layer.close(i);
		var j = layer.confirm('终止面试是不可逆操作，确定终止？', {
			btn: ['确定', '取消']
		}, function() {
			layer.close(j);
			if(commentState == 'commenting'){
				// 正在视频中需要结束当前视频
				leaveRoom();
				if (splogid != ''){
					// 记录结束日志
					var post = {}
				
					post.startTime = startTime;
					post.endTime = new Date().getTime();
					post.splogid = splogid;
					post.spend = 1;
					post.roomer = roomer;
					$.post("index.php?c=spview&act=splog", post, function(data) {
						if(document.referrer != ''){
							history.back();
						}else{
							window.location.href = weburl + '/member/';
						}
					});
				}
			}
			var loadi = loadlayer();
			$.post("index.php?c=spview&act=spviewFinish", {
				'sid': sid
			}, function(data) {
				layer.closeAll();
				data = eval('(' + data + ')');
				if (data.errorcode == '9') {
					layer.msg(data.msg, 2, 9, function() {
						window.location.href = weburl + "/member/index.php?c=spview";
					});
					return false;
				} else {
					layer.msg(data.msg, 2, 8);
					return false;
				}
			});
		});
	});
}
function lookresume(uid){

	if(viewruid == uid){

		$('#nowresume').fadeToggle(100);

	}else{
		
		if(typeof layer !== 'undefined'){
			layer.load();
		}
		$.post("index.php?c=spview&act=getResumeDtail", {
			'sid': sid,
			'uid': uid
		}, function(data) {

			layer.closeAll('loading');
			data = eval('(' + data + ')');

			if(data.error == '2'){

				layer.msg(data.msg, 2, 8);
				
			}else{
				
				var resume = data.resume;

				viewruid = uid;

				var rhtml = '';

				if(resume){

					rhtml += '<div class="resume_de_tit">基本信息</div>';
					rhtml += '<div class="resume_de_info">';
					rhtml += '<div class="resume_name">' + resume.uname + '<span style="padding: 0 5px;">/</span>' + resume.sex_n + '</div>';
					rhtml += '<div>';
					rhtml += resume.age + '岁<span class="xian"></span>';
					rhtml += resume.edu_n + '学历<span class="xian"></span>';
					rhtml += resume.exp_n + '工作经验';
					rhtml += '</div>';
					rhtml += '</div>';

					rhtml += '<div class="resume_de_tit">求职意向</div>';
					rhtml += '<div class="resume_de_info">';
					rhtml += '<div class="color_666"><label>意向职位：</label>' + resume.r_name + '</div>';
					rhtml += '<div class="color_666"><label>期望薪资：</label>' + resume.salary + '</div>';
					rhtml += '<div class="color_666"><label>求职状态：</label>' + resume.jobstatus + '</div>';
					rhtml += '<div class="color_666"><label>工作地点：</label>' + resume.cityname + '</div>';
					rhtml += '</div>';

					if (data.resume.user_work && data.resume.user_work.length > 0) {
						var work = data.resume.user_work;
						rhtml += '<div class="resume_de_tit">工作经历</div>';
						for (let i in work) {

							rhtml += '<div class="resume_de_info">';
							rhtml += '<div class="company_name">' + work[i].name + ' <span class="jl_time">' + work[i].date_n + '</span></div>';
							rhtml += '<div class="color_666"><label>工作职位：</label>' + work[i].title + '</div>';
							rhtml += '<div class="color_666"><label>工作内容：</label>' + work[i].content + '</div>';
							rhtml += '</div>';
						}
					}
					if (data.resume.user_edu && data.resume.user_edu.length > 0) {
						var edu = data.resume.user_edu;

						rhtml += '<div class="resume_de_tit">教育经历</div>';
						for (let i in edu) {

							rhtml += '<div class="resume_de_info">';
							rhtml += '<div class="company_name">' + edu[i].name + ' <span class="jl_time">' + edu[i].date_n + '</span></div>';
							rhtml += '<div class="color_666"><label>学历：</label>' + edu[i].education_n + '</div>';
							rhtml += '<div class="color_666"><label>所学专业：</label>' + edu[i].specialty + '</div>';
							rhtml += '</div>';
						}
					}
					if (data.resume.user_xm && data.resume.user_xm.length > 0) {
						var project = data.resume.user_xm;
						rhtml += '<div class="resume_de_tit">项目经历</div>';
						for (let i in project) {
							rhtml += '<div class="resume_de_info">';
							rhtml += '<div class="company_name">' + project[i].name + ' <span class="jl_time">' + project[i].date_n + '</span></div>';
							rhtml += '<div class="color_666"><label>项目名称：</label>' + project[i].title + '</div>';
							rhtml += '<div class="color_666"><label>项目内容：</label>' + project[i].content + '</div>';
							rhtml += '</div>';
						}
					}
				}
				$('#nowresume').html(rhtml);

				if($("#nowresume").is(":hidden")){
					$('#nowresume').fadeToggle(100);
				}
			}

		})
	}
}
function getLineData(nowuid, isnext) {
	if(nowuid && (viewuid != '' && viewuid != nowuid) && !isnext){
		// 有正在面试中的
		spviewNextAsk(nowuid);
		return
	}
	if(typeof layer !== 'undefined'){
		layer.load();
	}
	$.post("index.php?c=spview&act=getLineData", {
		'sid': sid,
		'nowuid': nowuid
	}, function(data) {
		layer.closeAll('loading');
		data = eval('(' + data + ')');
		if (data.errorcode == '9') {
			$('#subnum').text(data.subnum);
			$('#linenum').text(data.linenum);
			$('#msnum').text(data.msnum);
			if(data.msnum){
				var msdata = {
					msnum: data.msnum,
					msuid: viewuid
				};
				roomMessage(msdata);
			}
			viewuid = data.nowuid;

			$('#resume_detail').attr('data-uid',viewuid);

			var ehtml = '';
			var uhtml = '';
			if (data.expects) {
				$("#bdiv").show();
				$("#nouser").hide();
				var expects = data.expects;
				for (let i in expects) {
					ehtml += '<li id="ms_' + expects[i].uid + '" class="list">';
					ehtml += '<img src="' + expects[i].photo_n + '" alt="" class="head_portrait">';
					ehtml += '<div class="name">' + expects[i].uname; 
					ehtml += '<a href="javascript:void(0);" onclick="lookresume(\''+expects[i].uid+'\')" class="look_resume" >&nbsp;&nbsp;查看简历</a></div>';
					ehtml += '<div class="job">预约职位：' + expects[i].jobname + '</div>';

					if (viewuid && viewuid == expects[i].uid) {
						ehtml += '<a href="javascript:void(0);" class="state"><i></i>面试中</a>';
					} else {
						ehtml += '<a href="javascript:void(0);" onclick="getLineData(' + expects[i].uid + ')" class="jump">邀请面试</a>';
					}
					ehtml += '<span class="spzl">暂离<span>';
					ehtml += '</li>';
					offlineList.push(expects[i].uid);
				}
			}else{
				$("#nouser").show();
			}
			$('#waitingUser').html(ehtml);
			if (data.resume && data.resume.uid) {
				// 处理面试评价
				$("#remark").val(data.remark);
				$("#bdiv").hide();
				if(nowuid){
					// 发送视频面试通知
					sendComment(data.resume.uid, data.jobid);
				}else{
					// 当前有正在面试中的人，显示重新发送按钮
					document.getElementById('reinvite').style.display = 'block';
					$("#reinvite").attr('onclick','sendComment("'+ data.resume.uid +'", "'+ data.jobid +'")');
				}
				
				var resume = data.resume;
				uhtml += '<img src="' + resume.photo + '" alt="" class="head_portrait">';
				uhtml += '<div class="name">' + resume.uname + ' <span>面试中</span></div>';
				uhtml += '<div class="info">';	
				uhtml += '<div><i class="info_i1"></i>期望职位：' + resume.r_name + '</div>';
				uhtml += '<div><i class="info_i2"></i>基本信息：' + resume.age + '岁，' + resume.exp_n + '工作经验，' + resume.edu_n +
					'学历</div>';
				uhtml += '</div>';

				
			}
			$('#nowuser').html(uhtml);
		} else {
			layer.msg(data.msg, 2, 8);
			return false;
		}
	});
}
function saveReamrk(){
	var content = $("#remark").val();
	if($.trim(content) == ''){
		return layer.msg('请填写面试评价', 2, 8);
	}

	if(viewuid == ''){
		return layer.msg('当前无人面试，请先邀请面试', 2, 8);
	}

	var loadi = loadlayer();
	$.post("index.php?c=spview&act=spviewRemark", {
		'sid': sid,
		'uid': viewuid,
		'content': content
	}, function(data) {
		layer.closeAll();
		layer.msg('保存成功', 2, 9);
	});
}
function spviewEndNow(){
	if(viewuid == ''){
		return layer.msg('当前无人面试，请先邀请面试', 2, 8);
	}
	layer.confirm('确定结束与对方的面试？', {
		btn: ['确定', '取消']
	}, function() {
		document.getElementById('reinvite').style.display = 'none';
		if(commentState == 'commenting'){
			// 正在视频中需要结束当前视频
			leaveRoom();
		}
		var loadi = loadlayer();
		$.post("index.php?c=spview&act=spviewPause", {
			'sid': sid
		}, function(data) {
			data = eval('(' + data + ')');
			layer.closeAll();
			if (data.errorcode == '9') {
				viewuid = '';
				getLineData();
			} else {
				layer.msg(data.msg, 2, 8);
			}
		});
	});
}