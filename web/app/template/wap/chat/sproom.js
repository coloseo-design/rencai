$(function() {
	if (usertype == '2') {
		getLineData();
	} else if (usertype == '1') {
		var isspview = window.localStorage.getItem("isspview");
		if (isspview && isspview == '1') {
			$("#splist").css('display', 'none');
			$("#sproom").css('display', 'block');
			$("#backicon").css('display', 'none');
			$("#spComment").css('display', 'none');
			$("#hangdiv").css('display', 'none');
		}
		setTimeout(function() {
			if (isspview && isspview == '1') {
				sendCommentAllow();
				joinRoom();
				window.localStorage.setItem("isspview", "2");
			}
		}, 1000);
	}
});

function getLineData(nowuid) {
	$("#nowresume").addClass('none');
	showLoading();
	$.post("index.php?c=getLineData", {
		'sid': sid,
		'nowuid': nowuid
	}, function(data) {
		hideLoading();
		if (data.errorcode == '9') {
			$('#subnum').text(data.subnum);
			$('#linenum').text(data.linenum);
			$('#msnum').text(data.msnum);
			if (data.msnum) {
				var msdata = {
					msnum: data.msnum,
					msuid: viewuid
				};
				roomMessage(msdata);
			}

			viewuid = data.nowuid;

			var ehtml = '';
			if (data.expects) {
				$("#nouser").css('display', 'none');
				var expects = data.expects;
				for (let i in expects) {
					ehtml += '<div id="ms_' + expects[i].uid + '" class="msj_list">';
					ehtml += '<div class="msj_list_user_box">';
					ehtml += '<div class="msj_list_user_pic">';
					ehtml += '<img src="' + expects[i].photo_n + '"></div>';
					ehtml += '<div class="msj_list_user">' + expects[i].uname;
					ehtml += '<a href="javascript:void(0);" onclick="nowresume(\'' + expects[i].eid + '\', \'' + expects[i].jobid + '\')" class="msj_list_userlook">查看简历</a></div>';
					ehtml += '<div class="msj_list_userjob">预约职位：<span class="msj_list_userjob_n">' + expects[i].jobname + '</span></div></div>'
					if (viewuid && viewuid == expects[i].uid) {
						ehtml += '<span class="msj_list_userjob_msz">面试中</span>';
					} else {
						ehtml += '<a href="javascript:void(0);" onclick="getLineData(\'' + expects[i].uid + '\')" class="msj_list_userjob_yq">面试TA</a>';
					}
					ehtml += '<span class="spzl">暂离<span>';
					ehtml += '</div>';
					offlineList.push(expects[i].uid);
				}
			} else {
				$("#nouser").css('display', 'block');
			}
			$('#waitingUser').html(ehtml);
			
			if (nowuid) {
				
				// 发送视频面试通知
				sendComment(nowuid, data.jobid);
			}
		} else {
			showToast(data.msg)
			return false;
		}
	},'json');
}

function nowresume(eid, jobid) {
	showLoading();
	$.post(nowresumeUrl, {
		'eid': eid
	}, function(data) {
		hideLoading();
		var expect = data.data;
		var rhtml = '<div class="spview_jobname">' + expect.uname + '</div>';
		rhtml += '<div class="spview_jobinfo">' + expect.sex_n;
		rhtml += expect.age ? '|' + expect.age + '岁' : '';
		rhtml += expect.liveing ? '|' + expect.liveing : '';
		rhtml += expect.edu_n ? '|' + expect.edu_n : '';
		rhtml += expect.exp_n ? '|' + expect.exp_n : '';
		rhtml += '</div>';

		rhtml += '<div class="spview_jobn">求职意向</div>';
		rhtml += '<div class="spview_jobp">';
		rhtml += '<div class="">期望职位：' + expect.r_name + '</div>';
		rhtml += '<div class="">工作地点：' + expect.cityname + '</div>';
		rhtml += '<div class="">从事行业：' + expect.hy + '</div>';
		rhtml += '<div class="">期望薪资：' + expect.salary + '</div>';
		rhtml += '<div class="">到岗时间：' + expect.report + '</div>';
		rhtml += '<div class="">工作性质：' + expect.type + '</div>';
		rhtml += '<div class="">求职状态：' + expect.jobstatus + '</div>';
		rhtml += '<div class="">工作职能：' + expect.expectjob + '</div>';
		rhtml += '</div>';

		if (expect.user_work && expect.user_work.length > 0) {
			var work = expect.user_work;
			rhtml += '<div class="spview_jobn">工作经历</div>';
			for (let i in work) {

				rhtml += '<div class="spview_userxh">';
				rhtml += '<div class="">' + work[i].name + '</div>';
				rhtml += '<div class="">' + work[i].title + '</div>';
				rhtml += '<div class="">' + work[i].date_n + '</div>';
				rhtml += '<div class="">' + work[i].content + '</div>';
				rhtml += '</div>';
			}
		}
		if (expect.user_edu && expect.user_edu.length > 0) {
			var edu = expect.user_edu;
			rhtml += '<div class="spview_jobn">教育经历</div>';
			for (let i in edu) {

				rhtml += '<div class="spview_userxh">';
				rhtml += '<div class="">' + edu[i].name + '</div>';
				rhtml += '<div class="">' + edu[i].education_n + '</div>';
				rhtml += '<div class="">' + edu[i].specialty + '</div>';
				rhtml += '<div class="">' + edu[i].date_n + '</div>';
				rhtml += '</div>';
			}
		}
		if (expect.user_xm && expect.user_xm.length > 0) {
			var project = expect.user_xm;
			rhtml += '<div class="spview_jobn">项目经历</div>';
			for (let i in project) {

				rhtml += '<div class="spview_userxh">';
				rhtml += '<div class="">' + project[i].name + '</div>';
				rhtml += '<div class="">' + project[i].title + '</div>';
				rhtml += '<div class="">' + project[i].date_n + '</div>';
				rhtml += '<div class="">' + project[i].content + '</div>';
				rhtml += '</div>';
			}
		}
		if (expect.user_tra && expect.user_tra.length > 0) {
			var train = expect.user_tra;
			rhtml += '<div class="spview_jobn">培训经历</div>';
			for (let i in train) {

				rhtml += '<div class="spview_userxh">';
				rhtml += '<div class="">' + train[i].name + '</div>';
				rhtml += '<div class="">' + train[i].title + '</div>';
				rhtml += '<div class="">' + train[i].date_n + '</div>';
				rhtml += '<div class="">' + train[i].content + '</div>';
				rhtml += '</div>';
			}
		}
		if (expect.user_skill && expect.user_skill.length > 0) {
			var skill = expect.user_skill;
			rhtml += '<div class="spview_jobn">职业技能</div>';
			for (let i in skill) {

				rhtml += '<div class="spview_userxh">';
				rhtml += '<div class="">技能名称：' + skill[i].name + '</div>';
				rhtml += '<div class="">掌握时间：' + skill[i].longtime + '年</div>';
				rhtml += '<div class="">熟练程度：' + skill[i].ing_n + '</div>';
				rhtml += '</div>';
			}
		}
		if (expect.user_other && expect.user_other.length > 0) {
			var other = expect.user_other;
			rhtml += '<div class="spview_jobn">其他信息</div>';
			for (let i in other) {

				rhtml += '<div class="spview_userxh">';
				rhtml += '<div class="">' + other[i].name + '</div>';
				rhtml += '<div class="">' + other[i].content + '</div>';
				rhtml += '</div>';
			}
		}
		if (expect.description || expect.tag) {

			rhtml += '<div class="spview_jobn">自我评价</div>';
			if (expect.tag) {
				rhtml += '<div class="">' + expect.tag + '</div>';
			}
			if (expect.description) {
				rhtml += '<div class="spview_jobp">' + expect.description + '</div>';
			}
		}
		rhtml += '<div class="spview_yms">';
		rhtml += '<div class="spview_yms_c">';
		if (viewuid && viewuid == expect.uid) {
			// 有正在面试中的
			rhtml += '<a href="javascript:void(0);" onclick="sendComment(\'' + expect.uid + '\',\'' + jobid +'\')" class="spview_yms_bth">继续面试</a>';
		} else {
			rhtml += '<a href="javascript:void(0);" onclick="getLineData(\'' + expect.uid +'\')" class="spview_yms_bth">面试TA</a>';
		}
		rhtml += '</div></div>';

		$("#rinfo").html(rhtml);
		$("#nowresume").css('display', 'block');
	},'json')
}

function closeResume() {
	$("#nowresume").css('display', 'none');
}