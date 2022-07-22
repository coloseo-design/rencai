if(issub == '3'){
	var serverTime = new Date().getTime(),
		djsTimer = null;
	// 监测浏览器息屏和可见
	var hiddenProperty = 'hidden' in document ? 'hidden' : 'webkitHidden' in document ? 'webkitHidden' : 'mozHidden' in document ? 'mozHidden' :  null;
	// 不同浏览器的事件名
	var visibilityChangeEvent = hiddenProperty.replace(/hidden/i, 'visibilitychange');
	var onVisibilityChange = function(){
		var nowTime = new Date().getTime();
		if(!document[hiddenProperty]){
			if(serverTime > 0 && (nowTime - serverTime > 60000)){
				clearTimeout(djsTimer);
				serverTime = nowTime;
				spviewUtil()
			}
		}else{
			serverTime = nowTime;
		}
	}
	document.addEventListener(visibilityChangeEvent, onVisibilityChange);
	// 处理倒计时
	spviewUtil();
}
function spviewUtil(){
	layui.use(['layer', 'util'], function() {
		var util = layui.util;
		var views = document.getElementById('view_stime');
		if (views) {
			var stime = views.value;
			var endTime = parseInt(stime) * 1000;;

			if (serverTime < endTime) {

				util.countdown(endTime, serverTime, function(date, serverTime, timer) {
					djsTimer = timer;
					var str = "<span class='kp_m'>" + date[0] + "</span><span> 天 </span> <span class='kp_m'>" + date[1] + "</span><span>小时</span><span class='kp_m'>" + date[2] + "</span> <span>分</span> <span class='kp_m'>" + date[3] + "</span> <span>秒</span>";
					layui.$('#countdown').html(str);

					if (date[0] == 0 && date[1] == 0 && date[2] == 0 && date[3] == 0) {

						window.location.reload();
					}
				});

				$('.xjhwks_tip').show();
			} else {
				$('.xjhwks_tip').hide();
				$(".xjh_show_spbg").hide();
			}
		}
	});
}

$(function() {
	$('.msjob_list_detail').click(function() {
		var jobid = $(this).attr('data-id');
		$.post(weburl + '/index.php?m=ajax&c=getJobInfo', {
			jobid: jobid
		}, function(data) {
			$(".job_popup_box").html(data);
			layer.open({
				title: '职位详细',
				content: $('.job_popup'),
				type: 1,
				area: ['640px', 'auto'],
				shade: 0.3,
				anim: 2,
				fixed: true,
			});
		})
	});
	$('#job_popup_close').click(function() {
		layer.closeAll();
	});
	$('.sp_show_msjob_list').each(function() {
		$(this).click(function() {
			var jobid = $(this).attr('data-id');
			$('.sp_show_msjob_list').removeClass("sp_show_msjob_list_cur")
			$(this).addClass("sp_show_msjob_list_cur")
			$("#jobid").val(jobid);
		})
	});
	$('#need_hy').mouseover(function() {
		$('#nhytips').removeClass('none');
	});
	$('#need_hy').mouseout(function() {
		$('#nhytips').addClass('none');
	});
	$('#my_hy').mouseover(function() {
		$('#mhytips').removeClass('none');
	});
	$('#my_hy').mouseout(function() {
		$('#mhytips').addClass('none');
	});
})

function spviewend() {
	layer.open({
		type: 1,
		title: '提示',
		closeBtn: 1,
		border: [10, 0.3, '#000', true],
		area: ['auto', 'auto'],
		content: $("#spviewend")
	});
}

function tologin() {
	layer.closeAll();
	showlogin(2);
}
function chooseResume() {

	var resumenum = $("#resumenum").val();
	if(resumenum>1){
		var sid = $("#sid").val();
		loadlayer();
		$.post(weburl + "/index.php?m=spview&c=ajaxResume", { sid: sid }, function(data) {
			layer.closeAll();
			data = eval('(' + data + ')');

			if(data.status == 1){
				
				$(".POp_up_r").html('');
				$(".POp_up_r").append(data.resumeList);

				var msglayer = layer.open({
					type: 1,
					title: '预约视频面试',
					closeBtn: 1,
					border: [10, 0.3, '#000', true],
					area: ['450px', 'auto'],
					content: $("#viewsub_show")
				});
			}else{
				if(data.login){
					showlogin('1');
				}else if(data.alert){

					layer.alert(data.msg, 0, '提示', function() {
					
						window.location.href = weburl + "/member/index.php?c=expect&act=add";
						window.event.returnValue = false;
						return false;
					});
				}else{

					layer.msg(data.msg, 2, 8);
				}
			}
		});
	}else{
		viewSub();
	}
}
function subviewclic(id){
	$(".job_prompt_sendresume_list").removeClass("job_prompt_sendresume_list_cur");
	$('#resume_'+id).addClass("job_prompt_sendresume_list_cur");
}

var tcsetval,
	tcsetwout;

function viewSub() {

	var jobid = $("#jobid").val();
	var eid=$(".job_prompt_sendresume_list_cur").length ? $(".job_prompt_sendresume_list_cur").attr('data_did') : '';
	var sid = $("#sid").val();
	var comid = $("#comid").val();
	loadlayer();

	$.post('index.php?m=spview&c=viewSub', {
		comid: comid,
		jobid: jobid,
		eid:eid,
		sid: sid
	}, function(data) {
		layer.closeAll();

		var data = eval('(' + data + ')');

		if (data.errcode == 9) {

			if (data.wxshow) {
				// 未绑定微信的，提示绑定微信
				
				layer.msg(data.msg, 2, 9, function() {
					$.layer({
						type: 1,
						title: '绑定微信',
						border: [10, 0.3, '#000', true],
						area: ['340px', 'auto'],
						page: {
							dom: "#wxcontent"
						},
						close: function() {
							window.location.reload();
						}
					});
				});
				tcwxlogincode();
			} else {
				$.layer({
					type: 1,
					title: '预约成功',
					area: ['415px', 'auto'],
					page: {
						dom: "#yycg"
					},
					close: function() {
						window.location.reload();
					}
				});
			}

		} else if (data.errcode == 8) {

			var info = data.info;
			var sp_resume = false;
			layer.open({
				title: '预约视频面试',
				content: $('.yyms_popup'),
				type: 1,
				area: ['600px', 'auto'],
				shade: 0.3,
				anim: 2,
				fixed: true
			});

			if (data.hy_check) {
				sp_resume = true;
				$(".need_hy").html("<i class='yyms_popup_atypism'></i>不符合");
				$("#need_hy").html(data.n_hy + '<div id="nhytips" class="none">' + data.hy + '</div>');
				$("#my_hy").html(data.m_hy + '<div id="mhytips" class="none">' + data.my_hy + '</div>');
			} else {
				$("#need_hy").html('');
				$("#my_hy").html('');
				$(".need_hy").html('<i class="yyms_popup_accord"></i>符合');
				$("#hy_check").hide();
			}

			if (data.exp_check) {
				sp_resume = true;
				$(".need_work").html("<i class='yyms_popup_atypism'></i>不符合");
				$("#need_work").html(data.job_exp);
				$("#my_work").html(data.my_exp);
			} else {
				$("#need_work").html('');
				$("#my_work").html('');
				$(".need_work").html('<i class="yyms_popup_accord"></i>符合');
				$("#exp_check").hide();
			}

			if (data.sex_check) {
				sp_resume = true;
				$(".need_sex").html("<i class='yyms_popup_atypism'></i>不符合");
				$("#need_sex").html(data.job_sex);
				$("#my_sex").html(data.my_sex);

			} else {
				$("#need_sex").html('');
				$("#my_sex").html('');
				$(".need_sex").html('<i class="yyms_popup_accord"></i>符合');
				$("#sex_check").hide();
			}

			if (data.age_check) {
				sp_resume = true;
				$(".need_age").html("<i class='yyms_popup_atypism'></i>不符合");
				$("#need_age").html(data.job_age);
				$("#my_age").html(data.my_age);

			} else {
				$("#need_age").html('');
				$("#my_age").html('');
				$(".need_age").html('<i class="yyms_popup_accord"></i>符合');
				$("#age_check").hide();
			}

			if (data.edu_check) {
				sp_resume = true;
				$(".need_edu").html("<i class='yyms_popup_atypism'></i>不符合");
				$("#need_edu").html(data.job_edu);
				$("#my_edu").html(data.my_edu);

			} else {
				$("#need_edu").html('');
				$("#my_edu").html('');
				$(".need_edu").html('<i class="yyms_popup_accord"></i>符合');
				$("#edu_check").hide();
			}
			if(!sp_resume){
				$('#sp_resume').hide();
			}

			if (data.iswork || data.isedu || data.isproject) {
				$('#sp_other').removeClass('none');
				if (data.iswork) {
					$(".exp_work").show();
					$("#exp_work").hide();
				} else {
					$(".exp_work").hide();
					$("#exp_work").show();
					$("#iswork").hide();
				}
				if (data.isedu) {
					$(".exp_edu").show();
					$("#exp_edu").hide();
				} else {
					$(".exp_edu").hide();
					$("#exp_edu").show();
					$("#isedu").hide();
				}
				if (data.isproject) {
					$(".exp_pro").show();
					$("#exp_pro").hide();
				} else {
					$(".exp_pro").hide();
					$("#exp_pro").show();
					$("#isproject").hide();
				}
			} else {
				$('#sp_other').addClass('none');
			}
		} else {
			layer.msg(data.msg, 2, 8);
		}
	});
}
function tcwxlogincode(){
	
	$.post(getwxurl, {
		t: 1
	}, function(wdata) {
		if (wdata == 0) {
			$('#wx_login_qrcode_spview').html('二维码获取失败..');
		} else {
			$('#wx_login_qrcode_spview').html('<img src="' + wdata + '" width="180" height="180">');
			tcsetval = setInterval(function() {
				$.post(getwxstatusurl, {
					t: 1
				}, function(data) {

					var data = eval('(' + data + ')');

					if (data.url != '' && data.msg != '') {
						clearInterval(tcsetval);
						tcsetval = null;
						layer.msg(data.msg, 2, 9, function() {
							window.location.reload();
						});
					} else if (data.url != '') {
						window.location.reload();
					}
				});
			}, 2000);
			if(tcsetwout){
				clearTimeout(tcsetwout);
				tcsetwout = null;
			}
			tcsetwout = setTimeout(function(){
				clearInterval(tcsetval);
				tcsetval = null;
				var tcwx_sx = $("#tcwx_sx").html();
				$('#wx_login_qrcode_spview').html(tcwx_sx);
			},300*1000);
		}
	});
}
function goRoom(sid) {
	loadlayer();
	$.post('index.php?m=spview&c=goRoom', {
		sid: sid
	}, function(data) {
		window.location.href = weburl + '/member/?c=spview&act=sproom&id=' + sid;
	});
}
