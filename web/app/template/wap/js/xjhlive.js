var player = null,
	playing = false,
	setval = null;

var u = navigator.userAgent;
var x5_type = 'h5';
if (/(iPhone|iPad|iPod|iOS)/i.test(u)) { //判断iPhone|iPad|iPod|iOS
	x5_type = 'h5';
} else if (/(Android)/i.test(u)) { //判断Android
	x5_type = 'h5-page';
}
var clientHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
var clientWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

$(function(){
	// 直播
	livePlay();
	// 点播
	playered();
	xjhjobList(xjhid,1,1);
	$('.chat_nav  li>a').each(function() {

		$(this).click(function() {
			$('.chat_nav  li>a').removeClass("show_box_menu_border");
			$(this).addClass("show_box_menu_border");
		})

		var ah2 = document.querySelectorAll(".chat_nav  li>a")
		var ap = document.querySelectorAll(".show_box_menu_con>div")
		
		// 遍历元素<br>　　//这里我们要通过for循环去获取li中的索引，然后成功的运用到下面的div中。
		for (var i = 0; i < ah2.length; i++) {
			// 编号
			ah2[i].index = i;
			// 各种事件
			ah2[i].onclick = function() {
				for (var j = 0; j < ap.length; j++) {
					ap[j].style.display = "none"
				}
				// 显示
				if(ap[this.index]){
					ap[this.index].style.display = "block";
				}
				
			}
		}
	})
	//用户变化屏幕方向时调用
	$(window).bind('orientationchange', function() {
		if(playing){
			palyOrient();
		}else{
			orient();
		}
	});
})

function livePlay() {

	if (document.getElementById('live_video')) {
		var live_hls = document.getElementById('live_hls').value,
			live_poster = document.getElementById('live_poster').value,
			img = $("#poster").find('img').attr('src'),
			poster = img ? img : live_poster;
		player = new TcPlayer('live_video', {
			"m3u8": live_hls,
			"autoplay": true,
			"live": true,
			"poster": poster,
			//"width": '640',
			"height": '220',
			"x5_player": true,
			"x5_type": x5_type,
			"x5_orientation": 0,
			//"x5_playsinline": 1,
			"x5_fullscreen": true, //是否全屏
			"wording": {
				1: "网络错误，请检查网络配置",
				4: "主持人暂时离开,请稍候片刻",
			},
			"listener": function(msg) {
				if (msg.type == 'playing') {
					playing = true;
				} else if (msg.type == 'pause' || msg.type == 'ended' || msg.type == 'error') {
					playing = false;
				}
			}
		});
	}
}

function playered() {
	if (document.getElementById('playered')) {
		var url = $("#playurl").val();
		// 实例化播放器
		player = new QPlayer({
			url: url,
			container: document.getElementById("playered"),
			autoplay: true,
			loggerLevel: 3,
			defaultViewConfig: {
				settingsIcon: mbstyle +'/images/qiniuset.png'
			}
		});
		player.on('play', function() {
			//用户变化屏幕方向时调用
			$(window).bind('orientationchange', function() {
				palyOrient();
			});
		});
	}
}

// 播放时处理横屏和竖屏
function palyOrient() {
	if(typeof commonHide != 'undefined'){
		commonHide();
	}
	if (window.orientation == 90 || window.orientation == -90) {
		//横屏
		// 直播
		if ($("#live_video").length > 0) {
			$("#liveTab").hide();
			player.fullscreen(true);
		}
		return false;
	} else if (window.orientation == 0 || window.orientation == 180) {
		//竖屏
		// 直播
		if ($("#live_video").length > 0) {
			$("#liveTab").show();
			player.fullscreen(false);
			$(window).unbind();
			orient();
		}
		return false;
	}
}
// 处理横屏和竖屏
function orient() {
	if(typeof commonHide != 'undefined'){
		commonHide();
	}
	if (window.orientation == 90 || window.orientation == -90) {
		//横屏
		// 直播
		if ($("#live_video").length > 0) {
			$("#liveTab").hide();
			$(".e_resume").hide();
			setTimeout(function(){
				var clientHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
				var hpheight = clientHeight - 51 + 'px';
				$("#livebody").css('height',hpheight);
				$("#xjhdiv").attr('style','width:60%;margin:0 auto;');
				$(".vcp-player").css({"width":"100%","height":hpheight});
				$("#live_video").find('video').css({"width":"100%","height":hpheight});
				$('.xjh_show_wid').css({"width":"60%","margin":"0 auto"});
				$(".show_box_chat_input").css({"width":"60%","margin":"0 auto","background":"#fff","box-shadow":"none"});
			},200)
		}
	} else if (window.orientation == 0 || window.orientation == 180) {
		//竖屏
		// 直播
		if ($("#live_video").length > 0) {
			$("#liveTab").show();
			$(".e_resume").show();
			$("#livebody").css('height','220px');
			$(".vcp-player").css({"width":"100%","height":'220px'});
			$("#live_video").find('video').css({"width":"100%","height":'220px'});
			$("#xjhdiv").removeAttr('style');
			$('.xjh_show_wid').removeAttr('style');
			$(".show_box_chat_input").removeAttr('style');
		}
		return false;
	}
}
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
			if(player){
				player.pause();
			}
		}
	}
	document.addEventListener(visibilityChangeEvent, onVisibilityChange);
	// 处理倒计时
	liveUtil();
}

function liveUtil(){
    var stime = parseInt($("#live_stime").val()) * 1000;

	var time = stime -serverTime;
	if (serverTime < stime) {
		var vm = new Vue({
	        el: '#waitshow',
	        data: {
		        time:time,
	        },
	        methods: {
			    onFinish() {
			        $('#waitshow').hide();
					$('.sp_img').hide();
					$('.number').show();
					//倒计时结束
					if (!document.getElementById('live_video')) {
						$('#livediv').append('<div id="live_video" class="show_box_header_opacity"></div>');
						getXjhlive();
					}
			    },
		  },
	    });
	}else {
		$('#waitshow').hide();
		getXjhlive();
	}
}

function xjhjobList(xjhid,page,updown){

	if(xjhid){
		var updown 		= updown ? updown : 1;
		var param = {
			xjhid:xjhid,
			updown:updown,
			page:page,
			limit:5
		}
		$.post(wapurl+"/index.php?c=xjhlive&a=xjhJoblist",param,function(data){
			var res = eval('(' + data + ')');
			var joblist	=	res.joblist;
			var jobpage	=	res.jobpage ? res.jobpage : 1;
			var maxpage	=	res.maxpage;
			var html = '';

			if(joblist && joblist.length>0){
				for(var i=0;i<joblist.length;i++){
					html +='<div class="position_c">';
					html +='<div class="position_c_left">';
					html +='<div class="position_c_title"><a href="'+joblist[i].wapurl+'"> '+joblist[i].name+'</a></div>';
					html +='<div class="position_c_label"><a href="'+joblist[i].comurl+'"> '+joblist[i].com_name+'</a></div>';
					html +='<div class="position_c_label"><i>'+joblist[i].citystr+'</i><i>'+joblist[i].job_edu+'学历</i></div>';
					html +='<span class="position_c_salary">'+joblist[i].job_salary+'</span>';
					html +='</div>';
					html +='<div class="position_c_right"><a href="'+joblist[i].wapurl+'" class="position_c_submit">投简历</a></div>';
					
					html +='</div>';
					
				}
				if(maxpage>1){
					html +='<div class="pages" style="margin-top:20px">';
					html +='<a href="javascript:void(0);" onclick="xjhjobList('+xjhid+','+jobpage+',1);">上一页</a>';
					html +='<select onchange="toxjPages()" id="xjpage">';
					for(var i=1;i<=maxpage;i++){
						html +='<option value="'+i+'" ';
						if(i==jobpage){
							html +='selected';
						}
						html +=' >'+i+'</option>';

					}
					html +='</select>';

					html +='<a href="javascript:void(0);" onclick="xjhjobList('+xjhid+','+jobpage+',2);">下一页</a>';
					html +='共'+maxpage+'页</div>';
				}
				
			}else{
				html +='<div class="evaluate_pj_no"><i class="evaluate_pj_no_icon"></i>暂无职位信息</div>';
			}
			
			$('#xjjob_show').html(html);
			
		});
		setTimeout(function(){
			window.scrollBy(0,5);
			window.scrollBy(0,-5);
		},200)
	}
}
function toxjPages(){
	var obj		=	document.getElementById("xjpage");
	var page	=	obj.options[obj.selectedIndex].value;
	if(page==1){
		xjhjobList(xjhid,1,1);
	}else{
		xjhjobList(xjhid,parseInt(page-1),2);
	}
	
}
function subxjh(id) {
	showLoading();
	var url = wapurl + '/index.php?c=xjhlive&a=xjhSubcribe';
	$.post(url, {
		xjhid: id
	}, function(data) {
		hideLoading();
		var res=eval('('+data+')');
		if (res.error == 9) {
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
							yunvue.$data.ewmurl = wdata;
							yunvue.$data.ewmBox = true;
							
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
					yunvue.$data.ewmurl = ewmurl;
					yunvue.$data.ewmBox = true;
				}
			}else{
				showToast("预约成功", 2, function() {
					window.location.reload();
				});
			}
		}else if(res.error == 8){
			showToast("请登录个人用户");
		}else if(res.error == 7){
			showToast("您已预约，请勿重复预约");
		}else {
			showToast("数据异常请重试");
		}
	});
}
// 检查宣讲会直播状态
function getXjhlive(){
	$.post(wapurl+"index.php?c=xjhlive&a=getXjhlive",{id: xjhid},function(data){
		if(data){
			var res = eval('(' + data + ')');
			if(parseInt(res.livestatus) > 0){
				if(res.livestatus == 3 || res.iscaster == 1){
					// 直播中或导播台开启到了直播时间
					if(res.hls){
						$("#live_hls").val(res.hls);
					}
					if (document.getElementById('live_video')) {
						if(player){
							player.destroy();
						}
						livePlay();
					}else{
						$('#waitshow').hide();
						$('.sp_img').hide();
						$('#livediv').append('<div id="live_video" class="show_box_header_opacity"></div>');
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
