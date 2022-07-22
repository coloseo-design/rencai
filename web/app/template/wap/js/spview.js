var u = navigator.userAgent;
var x5_type = 'h5';
if (/(iPhone|iPad|iPod|iOS)/i.test(u)) { //判断iPhone|iPad|iPod|iOS
	x5_type = 'h5';
} else if (/(Android)/i.test(u)) { //判断Android
	x5_type = 'h5-page';
}
var clientHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
var clientWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
var setval = null;

//查看职位详情
function jobDetail(jobid){

	if(jobid && sid){
		showLoading();
		$.post(wapurl + '/index.php?c=ajax&a=getSpviewJobInfo', {
			sid:sid,
			jobid: jobid
		}, function(res) {
			hideLoading();
			var html= '';
			if(res.error=='1'){

				var job = res.job;
				
				html +='<div class="spview_jobname">'+job.name+'</div>';
				html +='<div class="spview_jobxz">'+job.job_salary+'</div>';
				html +='<div class="spview_jobinfo">'
				if(job.citystr){
					html +=	job.citystr+' | ';
				}
				if(job.job_edu){
					html +=	job.job_edu+'学历 | ';
				}
				if(job.job_exp){
					html +=	job.job_exp+'经验';
				}
				
				html +='</div>';

				if(job.job_welfare){

					html +='<div class="job_show_infowelfare">';
					for(let i in job.job_welfare){
						html +='<span class="job_show_infowelfare_n">'+job.job_welfare[i]+'</span>';
					}
					html +='</div>';

				}

				html +='<div class="spview_jobn">职位要求</div>';
				html +='<div class="spview_jobp">';
				if(job.job_number){
					html +='	<div class="spview_jobw">招聘人数：'+job.job_number+'</div>';
				}
				if(job.job_report){
					html +='	<div class="spview_jobw">到岗时间：'+job.job_report+'</div>';
				}
				if(job.job_age){
					html +='	<div class="spview_jobw">年龄要求：'+job.job_age+'</div>';
				}

				if(job.job_marriage){
					html +='	<div class="spview_jobw">婚况要求：'+job.job_marriage+'</div>';
				}
				
				html +='</div>';

				if(job.description){
					html +='<div class="spview_jobn">职位描述</div>';
					html +='<div class="spview_jobp">'+job.description+'</div>';
				}
				
				if(usertype=='1'){
					html +='<div class="spview_yms">';
					html +='	<div class="spview_yms_c">';
					html +='		<a href="javascript:void(0);" onclick="chooseResume('+job.id+');" class="spview_yms_bth">预约面试</a>';
					html +='	</div>';
					html +='</div>';
				}
				

				$('#spviewjobshow').html(html);

				$('#spviewjob').show();

			}else{
				showToast(res.msg);
				return false;
			}
		},'json')
	}
}
//预约
function viewSub(jobid) {

	$(".wap_tips_jobapplyjob").hide();
	$('#bg').hide();
	var eid=$(".job_prompt_sendresume_list_cur").length ? $(".job_prompt_sendresume_list_cur").attr('data_did') : '';

	if(sid && jobid){
		showLoading();
		$.post(wapurl + '/index.php?c=spview&a=viewSub', {
			jobid: jobid,
			sid: sid,
			eid:eid
		}, function(data) {
			hideLoading();
			$('#spviewjob').hide();

			if (data.errcode == 9) {
				if(isweiixn){
					if (data.wxshow) {
						// 未绑定微信的，提示绑定微信
						showLoading();
						$.post(getwxurl, {
							t: 1
						}, function(wdata) {
							hideLoading();
							if (wdata == 0) {
								showToast("预约成功", 2, function() {
									window.location.reload();
								});
							} else {
								$('#wx_login_qrcode').html('<img src="' + wdata + '" width="200" height="200">');
								wxvue.$data.wxbox = true;
								setval = setInterval(function(){
									$.post(getwxstatusurl,{t:1},function(data){
										var res=eval('('+data+')');
										if(res.msg!=''){
											window.location.reload();
										}
									});
								}, 2000); 
							}
						});
					}else{
						// 已绑定微信的，显示公众号二维码
						wxvue.$data.wxbox = true;
					}
				} else {
					showToast("预约成功", 2, function() {
						window.location.reload();
					});
				}
			} else if (data.errcode == 8) {

				if (data.hy_check) {
					$("#need_hy").html(data.hy);
					$("#my_hy").html(data.m_hy);
					$("#hy_check").show();
				} else {
					$("#need_hy").html('');
					$("#my_hy").html('');
					$("#hy_check").hide();
				}

				if (data.exp_check) {
					$("#need_work").html(data.job_exp);
					$("#my_work").html(data.my_exp);
					$("#exp_check").show();
				} else {
					$("#need_work").html('');
					$("#my_work").html('');
					$("#exp_check").hide();
				}

				if (data.age_check) {

					$("#need_age").html(data.job_age);
					$("#my_age").html(data.my_age);
					$("#age_check").show();
				} else {
					$("#need_age").html('');
					$("#my_age").html('');
					$("#age_check").hide();
				}

				if (data.edu_check) {

					$("#need_edu").html(data.job_edu);
					$("#my_edu").html(data.my_edu);
					$("#edu_check").show();
				} else {
					$("#need_edu").html('');
					$("#my_edu").html('');
					$("#edu_check").hide();
				}
				if (data.iswork || data.isedu || data.isproject) {
					$('#sp_other').removeClass('none');
					if (data.iswork) {
						$("#exp_work").show();
					} else {
						$("#exp_work").hide();
					}
					if (data.isedu) {
						$("#exp_edu").show();
					} else {
						$("#exp_edu").hide();
					}
					if (data.isproject) {
						$("#exp_pro").show();
					} else {
						$("#exp_pro").hide();
					}
				} else {
					$('#sp_other').addClass('none');
				}

				$('#yytips').show();
				
			} else {
				showToast(data.msg);
			}
		},'json');
	}else{
		showToast('数据异常，请重试');
	}
	
}
//进入房间
function goRoom(sid) {
	showLoading();
	$.post(wapurl+"/index.php?c=spview&a=goRoom", {
		sid: sid
	}, function(data) {
		hideLoading();
		window.location.href = wapurl + '/member/?c=sproom&id=' + sid;
	});

}
function chooseResume(jobid){
	closetip();

	var resumenum = $("#resumenum").val();
	
	if(resumenum>1){
		$.post(wapurl + "?c=spview&a=ajaxResume", {
            sid: sid
        }, function(data) {
			var data = eval('(' + data + ')');
			if(data.status==1){
				$(".POp_up_r").html();
				$(".POp_up_r").html(data.html);
				$("#subbtn").attr('onclick','viewSub(\''+jobid+'\')');
				$(".wap_tips_jobapplyjob").show();
				$("#bg").show();
			}else{
				showToast(data.msg);
				return false;
			}
        });
	}else{
		viewSub(jobid);
	}
	
}
function closetip(){
	$('.wap_link_tips').hide();
	$('#bg').hide();
}
function closeshow(){
	$(".wap_tips_jobapplyjob").hide();
	$("#bg").hide();
}

function viewsubclic(id){
	$(".job_prompt_sendresume_list").removeClass("job_prompt_sendresume_list_cur");
	$('#resume_'+id).addClass("job_prompt_sendresume_list_cur");
}