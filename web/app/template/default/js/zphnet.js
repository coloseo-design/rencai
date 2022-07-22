var lineList = [],
	lineInt = null;
$(function(){
	$("input[name='dxzph[]']").each(function(index, value){
		lineList.push($(value).val());
	});
})
function tabChange(obj,id){
	$(obj).parent().find('li').removeClass('wlzp_show_tit_cur');
	$(obj).attr('class','wlzp_show_tit_cur');
	$(".zphnetdiv").addClass("none");
	$("#"+id).removeClass("none");
	$("#boxtype").val(id);
	if(id == 'hall'){
		$("#ztype").val('resume');
	}else{
		$("#ztype").val('job');
	}
	window.location.href = "#" + id;
}
function noresume(){
	var pwcf = layer.confirm("您还没有简历,先去创建简历?",function(){
		layer.close(pwcf);
		window.location.href = weburl+'/member/index.php?c=expect&act=add';
	});
}
function zphend(){
	layer.open({
		type: 1,
		title: '提示',
		closeBtn: 1,
		border: [10, 0.3, '#000', true],
		area: ['auto', 'auto'],
		content: $("#zphend")
	});
}

function clickZphnet(id){
	
	layer.load('执行中，请稍候...',0);
	
	$.post(weburl+"/index.php?m=ajax&c=ajaxComjob",{zphnet:1,id:id},function(data){
		
		layer.closeAll();
		
		var data	=	eval('('+data+')');
		
		if(data.status == 1){
			
			$("#TB_window").show();
			
			$("#joblist").html();
			
			$("#joblist").html(data.html);
			
			layui.use(['layer', 'form'], function() {
				var layer = layui.layer,
					$ = layui.$,
					form = layui.form;

				form.render();

				form.on('checkbox(oneChoose)', function (data) {
					if(!data.elem.checked && $("#checkall").prop("checked")){
						$("#checkall").prop("checked", false);
						form.render("checkbox");
					}
			    });

			});
			

			var msglayer = layer.open({
				type: 1,
				title: '预定网络招聘会',
				closeBtn: 1,
				border: [10, 0.3, '#000', true],
				area: ['340px', 'auto'],
				content: $("#TB_window"),
				cancel: function(){
					window.location.reload();
				}
			});
			
		}else{
			
			layer.msg(data.msg,2,8);
		}
	}) 

}

function submitzphnet(){
	var zid = $("#zid").val();
	var jobid = "";
	$("input[name=checkbox_job]:checked").each(function(){
		if(jobid==""){jobid=$(this).val();}else{jobid=jobid+","+$(this).val();}
	});
	if(!jobid){
		
		layer.msg('请选择参展职位' , 2, 8);return false;
	}else{
	
		layer.load('执行中，请稍候...',0);
		
		$.post(weburl+"/index.php?m=zphnet&c=ajaxZphnet",{zid:zid,jobid:jobid},function(data){
			
			layer.closeAll('loading');
			
			var data	=	eval('('+data+')');
			var status 	= 	data.status;
			
			if(status == 1){
				
				layer.msg(data.msg, 2, 9, function(){
					location.reload();
				});
				
			}else if(status == 2){
				
				server_single('zphnet',data.jifen,data.price);
				
				$('#zid').val(data.zid);
				
				if(data.spid == 1){
					layer.msg('当前账户套餐余量不足，请联系主账户增配！' , 2, 8);return false;
				}else{
					firstTab();
					var msglayer = layer.open({
						type: 1,
						title: '预定网络招聘会',
						closeBtn: 1,
						border: [10, 0.3, '#000', true],
						area: ['auto', 'auto'],
						content: $("#tcmsg"),
						cancel: function(){
							window.location.reload();
						}
					});
				}
			}else{
				if(data.login == 1){
					showlogin('2');
				}else{
					layer.msg(data.msg, 2, 8);
				}
			}
		}) 
	}	
}
function zphnetLook(id, comid, jobid, url){
	layer.load();
	var param = {
		id: id, 
		comid: comid
	};
	if(jobid != ''){
		param.jobid = jobid;
	}
	$.ajax({
		url: weburl + "/index.php?m=zphnet&c=setLook",
		async: false,
		data: param,
		type: 'POST',
		success:function (data) {
			layer.closeAll('loading');
			window.open(url);
		}
	});
}

function getComList(){
	layer.load();
	var zid = $("#zid").val();
	var zw = $("#zphnet_zw").val();
	var param  =  {
		zid: zid,
		page: page,
		keyword: searchKeyword,
		zw: zw
	};
	$.post(weburl + "/index.php?m=zphnet&c=getComList",param, function(data) {
		layer.closeAll('loading');
		if(data){
			var data = eval('(' + data + ')');
			if(data && data.com){
				var comlist = data.com;
				var spOpen = data.spOpen;
				if(comlist && comlist.length > 0){
					var html = '';
					for(var i in comlist){
						html += '<div class="wlzp_show_comlistbox">';
						html += '<span id="dxzph_'+comlist[i].uid+'" class="spmszx zphnetOnline none">在线</span>';
						html += '<div class="wlzp_show_combox_left">';

						html += '<div class="wlzp_showthree_pic"><img src="' + comlist[i].logo + '" width="100" height="100"></div>';

						html += '<div class="wlzp_showthreecom"><div class="wlzp_showthreecomname"><a href="'+weburl+'/index.php?m=company&c=show&id='+comlist[i].uid+ '" target="_blank">' + comlist[i].comname + '</a><p> <span> '+comlist[i].hy_n+' </span>|<span> '+comlist[i].pr_n+' </span>|<span>'+comlist[i].mun_n+'</span></p></div></div>';

						html += '<div class="wlzp_show_combox_right">';

						html += '<div class="wlzp_show_comlist_gd">';
									
						html += '<ul class="wlzp_show_job">';

						for(var j in comlist[i]['job']){
							html += '<li class="wlzp_show_comlistbox_z">';

							if(parseInt(zphetime) <0 ){
								html += '<a href="javascript:void(0)" onclick="zphend()"  class="wlzp_show_rightjobname">'+ comlist[i]['job'][j].name +'</a>';
							}else{

								html += '<a href="javascript:void(0)" onclick="zphnetLook(\''+ zid +'\',\''+ comlist[i]['job'][j].uid +'\',\''+ comlist[i]['job'][j].id +'\',\''+weburl+'/index.php?m=job&c=comapply&id='+ comlist[i]['job'][j].id +'\')" class="wlzp_show_rightjobname">'+ comlist[i]['job'][j].name +'</a>';

							}

							html += '<span class="wlzp_show_rightjobxz">'+ comlist[i]['job'][j].job_salary +'</span></li>';
						}

						html += '</ul></div></div>';


						if(sy_chat_open==1){
							html += '<div class="wlzp_show_cz">';

								if(spOpen==1){
									if(parseInt(zphetime) <0 ){
										html += '<a href="javascript:void(0)" onclick="zphend()" class="wlzp_show_dh_shipin wlzp_show_dh5"> <img src="'+style+'/images/shivideo.png"> 视频面试</a>';
									}else{
										html += '<a href="javascript:void(0);" onclick="spdiv(\'' + zid + '\',\'' + comlist[i].uid + '\',\''+ data.usertype +'\',\'2\')"  class="wlzp_show_dh_shipin wlzp_show_dh5"> <img src="'+style+'/images/shivideo.png"> 视频面试</a>';
									}
								}

								if(parseInt(zphetime) <0 ){
									html += '<a href="javascript:void(0)" onclick="zphend()" class="wlzp_show_dh_gtbth wlzp_show_dh5 communicaterts"><img src="'+style+'/images/gouton.png">立即沟通</a>';
								}else{
									html += '<a href="javascript:void(0)" onclick="jobChat(\''+ comlist[i].uid +'\',\'com\',\'' + usertype + '\',0,\''+ sy_chat_name +'\',\''+ sy_user_change +'\',this)" data-zid="'+ zid +'" class="wlzp_show_dh_gtbth wlzp_show_dh5 communicaterts"><img src="'+style+'/images/gouton.png">立即沟通</a>';
								}
								html+='<a href="'+weburl+'/index.php?m=company&c=show&id='+ comlist[i].uid +'" class="wlzp_show_dh_more">查看更多岗位</a>'

							html += '</div>';		
						}
						
						html += '</div><input type="hidden" name="dxzph[]" value="'+ comlist[i].uid +'" /></div>';		
					
					}
					$("#comdiv").html(html);
					$('#nowpage').text(page);
					lineList = [];
					$("input[name='dxzph[]']").each(function(index, value){
						lineList.push($(value).val());
					});
					if(typeof sendGetonline != 'undefined'){
						sendGetonline();
					}
					clearInterval(lineInt);
					// 定时更新在线情况
					lineInt = setInterval(function(){
						if(typeof sendGetonline != 'undefined'){
							sendGetonline();
						}
					},60 * 1000);
					$("html, body").animate(
						{scrollTop: $("#comlist").offset().top },
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
	if(page < 1){
		page = 1;
	}else if (page > parseInt(comPageAll)){
		page = comPageAll;
	}
	$(".comPageSelect").removeAttr('selected');
	$("#compage_"+page).attr('selected','selected');
	getComList();
}
function tocompage(topage){
	if(topage){
		page = topage;
	}
	if(page < 1){
		page = 1;
	}else if (page > parseInt(comPageAll)){
		page = comPageAll;
	}
	getComList();
}

function pageHtmlShow(){
	event.stopPropagation();
	$('#pagehtml').toggle();
}
// 网络招聘会详细页邀请视频面试
function spdiv(zid, fuid, usertype, utype) {
	if(utype == '1'){
		if(usertype == ''){
			showlogin('2');
		}else if (usertype == '2'){
			layer.load();
			$.post(weburl + "/index.php?m=zphnet&c=isJoin",{zid: zid}, function(data) {
				layer.closeAll('loading');
				var data = eval('(' + data + ')');
				if(data.code==1){
					
					if(data.status == '1'){
						window.localStorage.setItem("spviewinvite", "1");
						window.location.href = weburl + '/member/index.php?c=spview&act=webrtc&roomer=1&zid=' + zid + '&fuid=' + fuid;
					}else if(data.status == '2'){
						layer.msg('参会报名审核未通过，请联系管理员',2,8);
					}else{
						layer.msg('参会报名审核中',2,8);
					}
				}else{
					layer.confirm('您尚未参会，请先报名！',function(){
						clickZphnet(zid)
					});
				}
			});
		}else{
			layer.msg('非企业用户，暂无视频权限！',2,8);
		}
	}else if(utype == '2'){
		if(usertype == ''){
			showlogin('1');
		}else if (usertype == '1'){
			window.localStorage.setItem("spviewinvite", "1");
			window.location.href = weburl + '/member/index.php?c=spview&act=webrtc&roomer=1&zid=' + zid + '&fuid=' + fuid;
		}else{
			layer.msg('非个人用户，暂无视频权限！',2,8);
		}
	}
}