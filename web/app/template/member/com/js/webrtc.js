$(function(){
	getResumeDtail();
	$('#resume_detail').click(function() {
		$('#nowresume').fadeToggle(100);
	});
	// 非主动方
	if(roomer == ''){
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

function getResumeDtail(){
	if(viewuid != ''){
		loadlayer();
		$.post("index.php?c=spview&act=getResumeDtail", {
			'uid': viewuid
		}, function(data) {
			layer.closeAll();
			if(data){
				var res = eval('(' + data + ')');
				if(res.resume){
					var resume = res.resume;
					if(roomer == '1'){
						$("#reinvite").attr('onclick','sendComment("'+ resume.uid +'")');
						// 发送邀请视频面试
						var spviewinvite = window.localStorage.getItem('spviewinvite');
						if(spviewinvite == '1'){
							sendComment(resume.uid);
							sendWxNotice('',''+resume.uid+'',''+jid+'');
							window.localStorage.setItem("spviewinvite", "2");
						}else{
							$("#reinvite").show();
						}
					}
					
					var uhtml = '<img src="' + resume.photo + '" alt="" class="head_portrait">';
					uhtml += '<div class="name">' + resume.uname + ' <span>面试中</span></div>';
					uhtml += '<div class="info">';	
					uhtml += '<div><i class="info_i1"></i>期望职位：' + resume.r_name + '</div>';
					uhtml += '<div><i class="info_i2"></i>基本信息：' + resume.age + '岁，' + resume.exp_n + '工作经验，' + resume.edu_n +
						'学历</div>';
					uhtml += '</div>';
					
					$('#nowuser').html(uhtml);
					
					var rhtml = '<div class="resume_de_tit">基本信息</div>';
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
				
					if (resume.user_work && resume.user_work.length > 0) {
						var work = resume.user_work;
						rhtml += '<div class="resume_de_tit">工作经历</div>';
						for (let i in work) {
				
							rhtml += '<div class="resume_de_info">';
							rhtml += '<div class="company_name">' + work[i].name + ' <span class="jl_time">' + work[i].date_n + '</span></div>';
							rhtml += '<div class="color_666"><label>工作职位：</label>' + work[i].title + '</div>';
							rhtml += '<div class="color_666"><label>工作内容：</label>' + work[i].content + '</div>';
							rhtml += '</div>';
						}
					}
					if (resume.user_edu && resume.user_edu.length > 0) {
						var edu = resume.user_edu;
				
						rhtml += '<div class="resume_de_tit">教育经历</div>';
						for (let i in edu) {
				
							rhtml += '<div class="resume_de_info">';
							rhtml += '<div class="company_name">' + edu[i].name + ' <span class="jl_time">' + edu[i].date_n + '</span></div>';
							rhtml += '<div class="color_666"><label>学历：</label>' + edu[i].education_n + '</div>';
							rhtml += '<div class="color_666"><label>所学专业：</label>' + edu[i].specialty + '</div>';
							rhtml += '</div>';
						}
					}
					if (resume.user_xm && resume.user_xm.length > 0) {
						var project = resume.user_xm;
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
			}
		});
	}
}
function spviewEndNow(){
	layer.confirm('确定结束与对方的面试？', {
		btn: ['确定', '取消']
	}, function() {
		document.getElementById('reinvite').style.display = 'none';
		if(commentState == 'commenting'){
			// 正在视频中需要结束当前视频
			leaveRoom();
		}
		var loadi = loadlayer();
		
		var post = {}
		
		post.startTime = startTime;
		post.endTime = new Date().getTime();
		post.splogid = splogid;
		post.spend = 1;
		post.roomer = roomer;
		$.post("index.php?c=spview&act=splog", post, function(data) {
			if(document.referrer != ''){
				if(document.referrer.indexOf('webrtc') > -1){
					window.location.href = weburl + '/member/';
				}else{
					history.back();
				}
			}else{
				window.location.href = weburl + '/member/';
			}
		});
	});
}
function saveZreamrk(){
	var content = $("#remark").val();
	var splogid = splogid;
	if(splogid != '' && parseInt(splogid) > 0){
		if($.trim(content) == ''){
			return layer.msg('请填写备注', 2, 8);
		}

		if(viewuid == ''){
			return layer.msg('当前无人面试，请先邀请面试', 2, 8);
		}

		var loadi = loadlayer();
		$.post("index.php?c=spview&act=webrtcRemark", {
			'splogid':splogid,
			'zid': zid,
			'uid': viewuid,
			'content': content
		}, function(data) {

			data = eval('(' + data + ')');

			layer.closeAll();

			var laytype = 9;

			
			if(data.error!='1'){
				laytype = 8;
			}
			
			layer.msg(data.msg, 2, laytype);
		});
	}else{
		return layer.msg('请先开始视频面试', 2, 8);
	}
	
}