var player = null;
	
$(function(){
	// 直播
	livePlay();
	// 点播
	playered();
	
	xjhjobList(xjhid,1,1);

	$('#send_content').keyup(function(event){
		if(event.keyCode ==13){
			send();
		}
	});
	$(document).on('click', function (e) {
		if($('#pagehtml').css('display')!='none'){
			$('#pagehtml').hide();
		}
	});
});

layui.use(['carousel'], function() {//layui 轮播  test1 test2 
	var carousel = layui.carousel;
	
	carousel.render({
		elem: '#test1',
		width: '880px',
		height: '495px',
		indicator: 'none'
	});
	carousel.render({
		elem: '#test2',
		width: '880px',
		height: '495px',
		indicator: 'none'
	});
});
if(livestatus == 1){
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
				liveUtil();
			}
		}else{
			serverTime = nowTime;
		}
	}
	document.addEventListener(visibilityChangeEvent, onVisibilityChange);
	// 处理倒计时
	liveUtil();
}
function liveUtil(){
	layui.use('util', function() {
		var util = layui.util;
		var stime = $("#live_stime").val();
		var endTime = parseInt(stime) * 1000;
		
		if (serverTime < endTime) {
			util.countdown(endTime, serverTime, function(date, serverTime, timer) {
				djsTimer = timer;
				var str = "<span class='xjh_list_zbtime'>" + date[0] + "</span> 天  <span class='xjh_list_zbtime'>" + date[1] +
					"</span> 时  <span class='xjh_list_zbtime'>" + date[2] + "</span> 分 <span class='xjh_list_zbtime'>" + date[3] +
					"</span> 秒";
				layui.$('#countdown').html(str);
		
				if(date[0]==0 && date[1]==0 && date[2]==0 && date[3]==0){
		
					$('.xjhwks_tip').hide();
					$(".xjh_show_spbg").hide();
					$('#waitshow').hide();
					$('.xjh_show_eye').show();
					//倒计时结束
					clearTimeout(timer);
					if(!document.getElementById('live_video')){
						$('#livebody').append('<div id="live_video" class="show_box_header_opacity"></div>');
						getXjhlive();
					}
				}
			});
			$('.xjhwks_tip').show();
		}else{
			$('.xjhwks_tip').hide();
			$(".xjh_show_spbg").hide();
			getXjhlive();
		}
	});
}
function pageHtmlShow(){
	event.stopPropagation();
	$('#pagehtml').toggle();
}
function toxjPages(page){
	if(page==1){
		xjhjobList(xjhid,1,1);
	}else{
		xjhjobList(xjhid,parseInt(page-1),2);
	}
	
}
var tcsetval,
	tcsetwout;
function subxjh(id,uid){
	if(uid){
		$.post('index.php?m=xjhlive&c=xjhSubcribe', {
			xjhid: id
		}, function(data) {
			var res = eval('(' + data + ')');
			if (res.error == 9) {
				if(res.wxshow){
					// 未绑定微信的，提示绑定微信
					layer.msg('恭喜您预约成功', 2, 9, function() {
						$.layer({
							type: 1,
							title: '绑定微信',
							border: [10, 0.3, '#000', true],
							area: ['340px', 'auto'],
							page: {
								dom: "#wxcontent"
							},
							close: function() {
								clearInterval(tcsetval);
								window.location.reload();
							}
						});
					});
					tcwxlogincode();
				}else{
					layer.msg("恭喜您预约成功", 2, 9, function() {
						window.location.reload();
					});
				}
			}else if(res.error == 8){
				layer.msg("请登录个人用户", 2, 8);
			}else if(res.error == 7){
				layer.msg("您已预约，请勿重复预约", 2, 8);
			}else {
				layer.msg("数据异常请重试", 2, 8);
			}
		});
	}else{
		showlogin();
	}
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
function detailtab(obj) {
	var choosedclass = 'xjh_show_botcur';

	var id = $(obj).attr('id');

	$('.xjh_show_botcur').removeClass('xjh_show_botcur');
	$(obj).addClass('xjh_show_botcur');
	$('*[id*="_show"]').hide();
	$('#' + id + '_show').show();
}

function wapdiypreview(){
	$.layer({
		type:1,
		title:'手机观看直播',
		closeBtn:[0,true],
		offset:['20%','30%'],
		border:[10 , 0.3 , '#000', true],
		area:['290px','330px'],
		page:{dom : '#getwapurl'}
	});
}
function livePlay(){
	if(document.getElementById('live_video')){
		var body = document.body,
			live_hls = document.getElementById('live_hls').value,
			live_poster = document.getElementById('live_poster').value,
			img = $("#stopLive").find('img').attr('src'),
			poster = img ? img : live_poster;
		player = new TcPlayer('live_video', {
			"m3u8": live_hls,
			"autoplay": true,
			"live": true,
			"poster": poster,
			"width": '880',
			"height": '495',
			"flash": false,
			"wording": {
				1001: "网络错误，请检查网络配置",
				1002: "主持人暂时离开,请稍候片刻",
			},
			"listener": function(msg){
				if(msg.type == 'load'){
					body.addEventListener('click',function(){
						player.play();
					});
				}else if (msg.type == 'playing') {
					
				}else if(msg.type == 'error'){
					player.errclear();
				}
			}
		});
	}
}
function playered(){
	if(document.getElementById('playered')){
		var url = $("#playurl").val();
		// 实例化播放器
		player = new QPlayer({
			url: url,
			container: document.getElementById("playered"),
			autoplay: true,
			loggerLevel: 3,
			defaultViewConfig:{
				settingsIcon: mbstyle +'/images/qiniuset.png'
			}
		});
	}
}

function getUserZd(){
	window.location.href = weburl + "/member/index.php?c=expect&act=add";
}
function xjhjobList(xjhid,page,updown){

	if(xjhid){
		var updown = updown ? updown : 1;
		var param = {
			xjhid:xjhid,
			updown:updown,
			page:page,
			limit:5
		}
		$.post(weburl+"/index.php?m=xjhlive&c=xjhJoblist",param,function(data){
			var res = eval('(' + data + ')');
			var joblist	=	res.joblist;
			var jobpage	=	res.jobpage ? res.jobpage : 1;
			var maxpage	=	res.maxpage;
			var html = '';
			if(joblist && joblist.length>0){
				for(var i=0;i<joblist.length;i++){
					html +='<li>';
					html +='<div class="xjh_job_name"><a href="'+joblist[i].joburl+'" target="_blank">'+joblist[i].name+'</a></div>';
					html +='<div class="xjh_job_info">'+joblist[i].com_name+'<i class="xjh_job_line">|</i> ';

					if(joblist[i].citystr){
						html +='工作地点： '+joblist[i].citystr+'<i class="xjh_job_line">|</i> ';
					}
					if(joblist[i].job_number){
						html +='招聘人数：'+joblist[i].job_number+' <i class="xjh_job_line">|</i> ';
					}
					if(joblist[i].job_edu){
						html +='学历要求：'+joblist[i].job_edu+'</div>';
					}
					if(joblist[i].job_salary){
						html +='<div class="xjh_job_zy">薪资：'+joblist[i].job_salary+'</div>';
					}
					if(uid){
						if (usertype==2){
							html +='<a onclick="layer.msg(\'只有个人用户才能申请\', 2, 8)" href="javascript:;" class="xjh_job_bth">投简历</a>';
						}else if (usertype==1 && !eid){
							html +='<a href="javascript:;" onclick="getUserZd()" class="xjh_job_bth">投简历</a>';
						}else {
							html +='<a href="'+joblist[i].joburl+'" target="_blank" class="xjh_job_bth">投简历</a>';
						}
					}else{
						html +='<a href="javascript:void(0);"  onclick="showlogin();" class="xjh_job_bth">投简历</a>';
					}
					html +='</li>';
					
				}
				if(maxpage>1){
					html +='<div class="fypages">';
					html +='<a href="javascript:void(0);" class="fypages_a" onclick="xjhjobList('+xjhid+','+jobpage+',1);">上一页</a>';
					
					html +='<div class="pages_sz">';
					html +='	<div id="nowpage" class="pages_szbox" onclick="pageHtmlShow()">'+jobpage+'</div>';
					html +='	<div id="pagehtml" class="pages_sz_s" style="display:none">';
					for(var i=1;i<=maxpage;i++){
						html +='	<a href="javascript:void(0);" onclick="toxjPages('+i+')" class="pages_sz_a">'+i+'</a>';
					}
					html +='	</div>';
					html +='</div>';
					
					html +='<a href="javascript:void(0);" class="fypages_a" onclick="xjhjobList('+xjhid+','+jobpage+',2);">下一页</a>';
					html +='<span class="fypages_pageAll">共'+maxpage+'页</span>';
					html +='</div>';
				}
			}else{
				html +='<div class="xjh_notip">暂无职位信息</div>';
			}
			
			$('#xjjob_show').html(html);
		});
	}
}
// 检查宣讲会直播状态
function getXjhlive(){
	$.post(weburl +"/index.php?m=xjhlive&c=getXjhlive",{id: xjhid},function(data){
		if(data){
			var res = eval('(' + data + ')');
			if(parseInt(res.livestatus) > 0){
				if(res.livestatus == 3 || res.iscaster == 1){
					// 直播中或导播台开启到了直播时间
					if(res.hls){
						$("#live_hls").val(res.hls);
					}
					if(document.getElementById('live_video')){
						if(!player){
							livePlay();
						}
					}else{
						$('#waitshow').hide();
						$(".xjh_show_spbg").hide();
						$('#livebody').append('<div id="live_video" class="show_box_header_opacity"></div>');
						livePlay();
					}
				}else if(res.livestatus == 2){
					// 直播结束
					if(player){
						player.destroy();
					}
					var html = $("#codvideo").html();
					$("#livebody").html(html);
				}
			}
		}
	});
}