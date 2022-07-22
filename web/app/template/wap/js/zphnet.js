var lineList = [],
	lineInt = null;
$(function(){
	$("input[name='dxzph[]']").each(function(index, value){
		lineList.push($(value).val());
	})
})
function tabChange(obj,id){
	$(obj).parent().find('li').removeClass('zph_net_nav_cur');
	$(obj).attr('class','zph_net_nav_cur');
	$(".zphnetdiv").addClass("none");
	$("#"+id).removeClass("none");
	$("#boxtype").val(id);
	if(id == 'hall'){
		$("#ztype").val('resume');
		$("#keyword").attr('placeholder','搜索简历名称');
		$(".wlzph_leftnv").css('display','none')
	}else{
		$("#ztype").val('job');
		$("#keyword").attr('placeholder','搜索职位/公司');
		$(".wlzph_leftnv").css('display','block')
	}
}
function zphend(){
  	showConfirm('本场招聘会已结束 , 去逛逛其他招聘会吧~',function(){
		window.location.href = wapurl + "index.php?c=zphnet";
	});
}
function noresume(){
  	$("#interview").css('display','block');
}
function clickZphnet(id) {
	showLoading();
	
	$.post(wapurl+"/index.php?c=ajax&a=ajaxComjob",{zphnet:1,id:id},function(data){
		hideLoading();
		if(data.status == 1){
			yunvue.$data.joblist = data.list;
			yunvue.$data.jobBox = true;
			setTimeout(function(){
				$(".checkall").click(function() {
					var checked = this.checked;
					$(".zphnet_cbox").each(function(){ 
				        this.checked = checked; 
				    }); 
				});
				$(".zphnet_cbox").click(function(){ 
				    if(!this.checked){
				    	$(".checkall").each(function(){
							this.checked = false;
						});
				    }
				});
			},100) 
		}else{
			showToast(data.msg);return false;
		}
	},'json') 
}
function submitzphnet() {
	var zid = $("#zid").val();
	var jobid = jobIds;
	
	if(jobid.length == 0){
		showToast('请选择参展职位');
	}else{
		jobid = jobid.join(',');
		showLoading();
		$.post(wapurl + "/index.php?c=zphnet&a=ajaxZphnet",{zid : zid,jobid:jobid}, function(data) {
			hideLoading();
			var data = eval('(' + data + ')');
			if (data.status == 1) {	// 报名成功
				showToast(data.msg,2,function(){
					location.reload();
				});
			} else if (data.status == 2) {
			  	showConfirm(data.msg,function(){
					window.location.href = wapurl + "member/index.php?c=server&server=zphnet&id=" + zid;
				});
				 
			} else{ 
				if(data.login == 1){
					pleaselogin('您还未登录企业账号，是否登录？',wapurl+'/index.php?c=login')
				}else{
					showToast(data.msg);return false;
				}
			}
		})
	}
}
function zphnetLook(id, comid, jobid, url){
	showLoading();
	var param = {
		id: id, 
		comid: comid
	};
	if(jobid != ''){
		param.jobid = jobid;
	}
	$.post(wapurl + "index.php?c=zphnet&a=setLook",param, function(data) {
		hideLoading();
		window.location.href = url;
	});
}

function getComList(){
	showLoading();
	var zid = $("#zid").val();
	var zw = $("#zphnet_zw").val();
	var param  =  {
		zid: zid,
		page: page,
		keyword: searchKeyword,
		zw: zw
	};
	$.post(wapurl + "index.php?c=zphnet&a=getComList",param, function(data) {
		hideLoading();
		if(data){
			var data = eval('(' + data + ')');
			if(data && data.com){
				var comlist = data.com;
				var spOpen = data.spOpen;
				if(comlist && comlist.length > 0){
					var html = '';
					for(var i in comlist){
						html += '<div class="zph_net_list">';
						html += '<div class="zph_net_list_c">';
						html += '<span id="dxzph_'+comlist[i].uid+'" class="spmszx zphnetOnline none">在线</span>';
						html += '<div onclick="zphnetLook(\''+ zid +'\',\''+ comlist[i].uid +'\',\'\',\'index.php?c=company&a=show&id='+ comlist[i].uid +'\')" class="zph_net_list_combox">';
						html += '<div class="zph_net_list_pic"><img src="' + comlist[i].logo + '"></div>';
						html += '<div class="zph_net_list_comname">' + comlist[i].comname + '</div>';
						html += '<div class="zph_net_list_cominfo">'+comlist[i].hy_n+'<i class="">|</i>'+comlist[i].pr_n+'<i class="">|</i>'+comlist[i].mun_n+'</div>';
						html += '</div>';
						html += '<div class="zph_net_list_joblist">';
						for(var j in comlist[i]['job']){
							html += '<div class="zph_net_jobbox"><div class="zph_net_list_job"  onclick="zphnetLook(\''+ zid +'\',\''+ comlist[i]['job'][j].uid +'\',\''+ comlist[i]['job'][j].id +'\',\'index.php?c=job&a=comapply&id='+ comlist[i]['job'][j].id +'\')">' + comlist[i]['job'][j].name + '</div>';
							html += '<span class="zph_net_jobxz">' + comlist[i]['job'][j].job_salary + '</span></div>';
						}
						html += '</div><a href="javascript:void(0)" onclick="zphnetLook(\''+ zid +'\',\''+ comlist[i].uid +'\',\'\',\'index.php?c=company&a=show&id='+ comlist[i].uid +'\')" class="zph_netjobmore">查看更多<img src="'+wap_style+'/images/oei.png"></a>';
						html += '<div class="zph_net_new_gt">';
						if(sy_chat_open=='1'){
							if(parseInt(zphetime) <0 ){
								html += '<a href="javascript:void(0)" onclick="zphend()">立即沟通</a>';
							}else if(comlist[i]['job']){
								html += '<a href="javascript:void(0)" onclick="jobChat(\''+ comlist[i]['job'][j].uid +'\',\'com\',\'' + usertype + '\',\''+ sy_chat_name +'\',\''+ sy_user_change +'\',this)" data-zid="'+ zid +'">立即沟通</a>';
							}
							if(spOpen==1){
								html += '<a href="javascript:void(0);" onclick="spdiv(\'' + zid + '\',\'' + comlist[i].uid + '\',\''+ data.usertype +'\',\'2\')" class="spmswzx">视频面试</a>';
							}
						}
						html += '</div>';
						html += '</div><input type="hidden" name="dxzph[]" value="'+ comlist[i].uid +'" /></div>';
					}
					$("#comdiv").html(html);
					lineList = [];
					$("input[name='dxzph[]']").each(function(index, value){
						lineList.push($(value).val());
					});
					if(typeof sendGetonline != 'undefined'){
						sendGetonline();
					}
					clearInterval(lineInt);
					lineInt = setInterval(function(){
						if(typeof sendGetonline != 'undefined'){
							sendGetonline();
						}
					},15000);
					$("html, body").animate(
						{scrollTop: $("#zph_net_nav").offset().top },
						{duration: 500,easing: "swing"}
					);
				}else{
					lineList = [];
				}
			}
		}
	});
}
function compage(id){
	if(id == '1'){
		page--;
	}else{
		page++;
	}
	if(page < 0){
		page = 1;
	}else if (page > parseInt(comPageAll)){
		page = comPageAll;
	}
	$('#zphnetComPage').val(page);
	getComList();
}
function toZphnetComPage(){
	var obj = document.getElementById("zphnetComPage");
	page = obj.options[obj.selectedIndex].value;
	getComList();
}
// 网络招聘会详细页邀请视频面试
function spdiv(zid, fuid, usertype, utype) {
	if(utype == '1'){
		if(usertype == ''){
			pleaselogin('您还未登录企业账号，是否登录？', wapurl + '/index.php?c=login');
		}else if (usertype == '2'){
			showLoading();
			$.post(wapurl + "index.php?c=zphnet&a=isJoin",{zid: zid}, function(data) {
				hideLoading();
				var data = eval('(' + data + ')');
				if(data.code == 1){
					if(data.status == '1'){
						window.localStorage.setItem("spviewinvite", "1");
						window.location.href = wapurl + 'member/index.php?c=webrtc&roomer=1&zid=' + zid + '&fuid=' + fuid;
					}else if(data.status == '2'){
						showToast('参会报名审核未通过，请联系管理员');
					}else{
						showToast('参会报名审核中');
					}
				}else{
					showConfirm('您尚未参会，请先参会！',  function(e){
						if(e.index==1){
							clickZphnet(zid);
						}
					})
				}
			});
		}else{
			showToast('非企业用户，暂无视频权限！');
		}
	}else if(utype == '2'){
		if(usertype == ''){
			pleaselogin('您还未登录个人账号，是否登录？', wapurl + '/index.php?c=login');
		}else if (usertype == '1'){
			showLoading();
			$.post(weburl + '/api/wxapp/index.php?h=user&m=index&c=getInfo', {rand: Math.random()}, function (data) {
				hideLoading();
				if(data.error === 0){
					if(data.data.expect_state != '1'){
						showToast('您的简历还在审核中，无法参加视频面试');
					}else{
						window.localStorage.setItem("spviewinvite", "1");
						window.location.href = wapurl + 'member/index.php?c=webrtc&roomer=1&zid=' + zid + '&fuid=' + fuid;
					}
				}
			}, 'json')
		}else{
			showToast('非个人用户，暂无视频权限！');
		}
	}
}