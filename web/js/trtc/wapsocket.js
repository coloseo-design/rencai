var rtc = null,
	cameraId = '',
	micId = '',
	shareUserId = '',
	socket = null,
	ping_timer = null,
	commentState = null,
	islink = 1,
	mine = null,
	spWait = 0,
	csWait = 60,
	cint = null,
	coint = null,
	offlineList = [],
	splogid = '',
	startTime = 0,
	endTime = 0,
	logInt = null,
	spint = null,
	needRelink = true,
	canSend = false;
// receive    收到视频请求
// calling    面试请求中
// commenting 正在视频

//浏览器内部通过storage通讯
window.addEventListener("storage", function(e) {
	if (e.key == 'isspview' && e.newValue == '2') {
		// 一个页面接收视频面试邀请，请他页面的选择框关闭
		$("#spviewModal").hide();
		commentState = null;
		if(spint){
			clearInterval(spint);
			spint = null;
		}
	}
	// 其他页面退出登录本页面需要关闭socket
	if (e.key == 'socketState' && e.newValue == '2') {
		window.location.reload();
	}
})

$(function() {
	if ("WebSocket" in window) {
		webSocket(socketUrl);
		chatOnLoad();
		hiddenCommon();
	} else {
		console.log("您的浏览器不支持聊天!");
	}
})

function webSocket(socketUrl) {
	if(islink == 1){
		if (ping_timer) {
			clearInterval(ping_timer);
			ping_timer = null;
		}
		socket = new WebSocket(socketUrl);
		socket.onopen = function() {
			var ping = {
				type: 'ping'
			};
			ping_timer = setInterval(function() {
				if (socket && socket.readyState == 1) {
					socketSend(ping);
				} else {
					socket.close();
				}
			}, 25000);
		};
		socket.onerror = function() {
			islink = 2;
			if (ping_timer) {
				clearInterval(ping_timer);
				ping_timer = null;
			}
		};
		
		socket.onclose = function() {
			socket = null;
			if (ping_timer) {
				clearInterval(ping_timer);
				ping_timer = null;
			}
		};
		//捕捉socket端发来的事件
		socket.onmessage = function(event) {
			var e = JSON.parse(event.data);
			//console.log(e);
			switch (e.type) {
				case 'error':
					islink = 2;
					if (ping_timer) {
						clearInterval(ping_timer);
						ping_timer = null;
					}
					break;
				case 'comment':
					comment(e.data);
					break;
				case 'commentAllow':
					onCommentAllow(e.data);
					break;
				case 'closeSpConfirm':
					closeSpConfirm(e.data);
					break;
				case 'commenting':
					commenting(e.data);
					break;
				case 'commentRefused':
					commentRefused(e.data);
					break;
				case 'closesp':
					onClosesp(e.data);
					break;
				case 'hangUp':
					hangUp(e.data);
					break;
				case 'countRoom':
					countRoom(e.data);
					break;
				case 'mscount':
					mscount(e.data);
					break;
				case 'getOnline':
					onGetOnline(e.data);
					break;
				case 'roomBanned':
					onRoomBanned(e.data);
					break;
			}
		}
	}
}

function socketSend(msg) {
	if (socket) {
		if(socket.readyState == 1 && canSend){
			socket.send(JSON.stringify(msg));
		}else{
			var t = setInterval(function() {
				if (socket.readyState == 1 && canSend){
					clearInterval(t);
					t = null;
					socket.send(JSON.stringify(msg));
				}
			}, 500);
			setTimeout(function() {
				if (t) {
					clearInterval(t);
					t = null;
				}
			}, 10000);
		}
	} else {
		showTaost('服务加载中，请稍后', 2, function() {
			if (!socket || (socket && socket.readyState != 1)) {
				webSocket(socketUrl);
				chatOnShow();
			}
		});
	}
}
// 加载聊天数据
function chatOnLoad() {
	$.post(wapurl + "index.php?c=chat&a=goChat", {
		rand: Math.random()
	}, function(data) {
		if (data) {
			var res = eval('(' + data + ')');
			mine = res.mine;
			if (socket && socket.readyState == 1) {
				bindUser(res)
			} else {
				var t = setInterval(function() {
					if (socket && socket.readyState == 1) {
						clearInterval(t);
						t = null;
						bindUser(res);
					}
				}, 100);
				setTimeout(function() {
					if (t) {
						clearInterval(t);
						t = null;
					}
				}, 10000);
			}
		}
	});
}
// 重新连接请求数据
function chatOnShow() {
	if(needRelink){
		$.post(wapurl + "index.php?c=chat&a=getToken", {
			rand: Math.random()
		}, function(data) {
			if (data) {
				var res = eval('(' + data + ')');
				if (socket && socket.readyState == 1) {
					bindUser(res);
				} else {
					var t = setInterval(function() {
						if (socket && socket.readyState == 1) {
							clearInterval(t);
							t = null;
							bindUser(res);
						}
					}, 500);
					setTimeout(function() {
						if (t) {
							clearInterval(t);
							t = null;
						}
					}, 10000);
				}
			}
		})
	}
}

function bindUser(res) {
	if (res.yuntoken && res.yuntoken.token) {
		var yuntoken = res.yuntoken.token;
		var bind = {
			type: 'bind',
			data: {
				uid: mine.id,
				usertype: mine.usertype,
				yuntoken: yuntoken
			}
		}
		if(TrtcConfig.status != '2' && TrtcConfig.roomId !=''){
			bind.data.status = TrtcConfig.status;
			bind.data.group = 'trtc_' + TrtcConfig.roomId;
		}
		socket.send(JSON.stringify(bind));
		canSend = true;
		window.localStorage.setItem("socketState", "1");
	} else {
		socket = null;
		islink = 2;
		if(ping_timer){
			clearInterval(ping_timer);
			ping_timer = null;
		}
	}
}
function hiddenCommon(){
	// 检查页面是否后台运行
	var yunhdn, yunvsb;
	if (typeof document.hidden !== "undefined") {
		yunhdn = "hidden";
		yunvsb = "visibilitychange";
	} else if (typeof document.msHidden !== "undefined") {
		yunhdn = "msHidden";
		yunvsb = "msvisibilitychange";
	} else if (typeof document.webkitHidden !== "undefined") {
		yunhdn = "webkitHidden";
		yunvsb = "webkitvisibilitychange";
	}
	document.addEventListener(yunvsb, function(){
		// 前台运行后，如socket断开，重新连接
		if(!document[yunhdn]){
			if (!socket || (socket && socket.readyState != 1)) {
				webSocket(socketUrl);
				chatOnShow();
			}
		}
	});
}
// 发送视频面试通知
function sendComment(toid, jobid) {
	$("#nowresume").hide();
	if (socket && socket.readyState == 1) {
		if (!commentState) {
			commentState = 'calling';
			var todata = {
				id: toid,
				roomId: TrtcConfig.roomId
			};
			if(typeof sid !== 'undefined'){
				todata.sid = sid;
			}
			if(typeof jobid !== 'undefined'){
				spjobid = jobid;
				todata.jobid = jobid;
			}
			if(typeof zid !== 'undefined'){
				todata.zid = zid;
			}
			var msg = {
				type: 'comment',
				data: {
					mine: {
						id: TrtcConfig.mine,
						timestamp: new Date().getTime()
					},
					to: todata
				}
			};
			// 视频面试，企业手动邀请，发送微信通知
			if(typeof sid !== 'undefined'){
				sendWxNotice(sid, toid, jobid);
			}
		
			socketSend(msg);
			TrtcConfig.commentID = toid;
			// 发出邀请后，隐藏列表
			$("#splist").hide();
			$("#sproom").show();
			$("#backicon").hide();
			// 视频面试请求过程中，每隔5秒发一次请求
			coint = setInterval(function() {
				if (commentState != 'calling') {
					clearInterval(coint);
					coint = null;
				} else {
					socketSend(msg);
				}
			}, 5000);
			// 处理视频请求时限
			spWait = parseInt(TrtcConfig.spWait);
			cint = setInterval(function() {
				spWait--;
				document.getElementById('spWait').innerText = spWait;
				if (spWait < 1) {
					setTimeout(function(){
						sendClosesp();
					},2000);
					showToast('对方未接受', 2, function(){
						if(typeof sid == 'undefined' && document.referrer != ''){
							history.back();
						}
					});
				} else if (commentState != 'calling') {
					clearInterval(cint);
					cint = null;
				}
			}, 1000);
		} else {
			showToast('视频请求中,请稍候');
		}
	} else {
		var t = setInterval(function() {
			if (socket && socket.readyState == 1) {
				clearInterval(t);
				t = null;
				sendComment(toid, jobid);
			}
		}, 500);
		setTimeout(function() {
			if (t) {
				clearInterval(t);
				t = null;
			}
		}, 5000);
	}
}
// 企业主动邀请面试，
function sendWxNotice(sid, ruid, jobid) {

	$.post(wapurl + "index.php?c=ajax&a=sendWxNotice", {
		sid: sid,
		ruid: ruid,
		jobid: jobid
	}, function(data) {
		if (data) {
			return
		}
	})
}
// 加入视频房间
function joinRoom() {
	shareUserId = TrtcConfig.userId;
	if (rtc) return;

	rtc = new RtcClient({
		userId: TrtcConfig.userId,
		roomId: TrtcConfig.roomId,
		sdkAppId: TrtcConfig.sdkAppId,
		userSig: TrtcConfig.userSig
	});
	rtc.join();
	commentState = 'commenting';
	$("#csvideo").hide();
}
// 退出视频房间
function leaveRoom(type) {
	$("#splist").show();
	$("#sproom").hide();
	$("#backicon").show();
	if (rtc) {
		// 主动退出房间的，才要发送挂断通知
		if (!type) {
			sendHangUp();
		}
		commentState = null;
		rtc.leave();
		rtc = null;
	}
	if(logInt){
		clearInterval(logInt);
		logInt = null;
	}
}
// 收到视频通知
function comment(data) {
	if (!commentState) {
		if (data.to == TrtcConfig.mine) {
			commentState = 'receive';
			if (rtc) {
				// 正在测试视频画面，要先离开
				leaveRoom(2);
			}
			var post = {fuid: data.id};
			if(data.sid){
				post.sid = data.sid;
			}
			if(data.jobid){
				post.jobid = data.jobid;
			}
			$.post(wapurl + "index.php?c=spview&a=uinfo", post, function(res) {
				if(res){
					var res = eval('(' + res + ')');
					$("#modalLogo").attr('src',res.logo);
					$("#modalName").text(res.name);
					$("#spviewModal").show();
					roomData = data;
					spint = setInterval(function(){
						$("#spviewModal").hide();
					},60*1000);
				}
			})
		}
	} else {
		if (commentState != 'receive') {
			var msg = {
				type: 'commenting',
				data: {
					mine: {
						id: data.to,
						timestamp: new Date().getTime()
					},
					to: {
						id: data.id
					}
				}
			};
			socketSend(msg);
		}
	}
}
// 同意视频
function allowSp(){
	if(spint){
		clearInterval(spint);
		spint = null;
	}
	$("#spviewModal").hide();
	$("#splist").hide();
	$("#sproom").show();
	$("#backicon").hide();
	$("#spComment").hide();
	$("#hangdiv").hide();
	
	commentState = null;
	window.localStorage.setItem("isspview", "1");
	if(roomData.sid){
		// 企业发布的视频面试
		window.location.href = wapurl + 'member/?c=sproom&id=' + roomData.sid;
	}else if (roomData.zid){
		// 网络招聘会
		window.location.href = wapurl + 'member/?c=webrtc&zid=' + roomData.zid +'&fuid=' + roomData.id;
	}else{
		// 普通单对单
		window.location.href = wapurl + 'member/?c=webrtc&fuid=' + roomData.id;
	}
	roomData = {};
}
// 发送同意视频面试
function sendCommentAllow(){
	var msg = {
		type: 'commentAllow',
		data: {
			mine: {
				id: TrtcConfig.mine,
				roomId: TrtcConfig.roomId,
				timestamp: new Date().getTime()
			},
			to: {
				id: TrtcConfig.commentID
			}
		}
	};
	socketSend(msg);
}
// 拒绝视频
function closeSp(){
	if(spint){
		clearInterval(spint);
		spint = null;
	}
	$("#spviewModal").hide();
	var msg = {
		type: 'commentRefused',
		data: {
			mine: {
				id: roomData.to,
				timestamp: new Date().getTime()
			},
			to: {
				id: roomData.id
			}
		}
	};
	socketSend(msg);
	commentState = null;
	window.localStorage.setItem("isspview", "2");
	// 拒绝视频，记录聊天记录
	var pdata = {
		to: roomData.id,
		totype: mine.usertype == '2' ? 1 : 2,
		content: 'refused',
		timestamp: timestamp
	};
	
	$.post(wapurl + "index.php?c=chat&a=spviewChat", pdata, function(data) {});
	roomData = {};
}
// 邀请对象，接受视频邀请
function onCommentAllow(msg) {
	hideLoading();
	// 当前显示的页面才能同意邀请
	if (msg.to == TrtcConfig.mine && msg.id == TrtcConfig.commentID && !isHidden()) {
		if(cint){
			clearInterval(cint);
			cint = null;
		}
		if(coint){
			clearInterval(coint);
			coint = null;
		}
		$("#spComment").hide();
		$("#hangUp").attr('onclick', 'spviewClose()');
		joinRoom();
		showLoading();
	}
}
// 告知自己的全部连接，关闭是否面试的询问框
function closeSpConfirm(msg) {
	if (msg.to == mine.id) {
		$("#spviewModal").hide();
		commentState = null;
		if(spint){
			clearInterval(spint);
			spint = null;
		}
	}
}
// 挂断，结束面试
function spviewClose(){
	showConfirm('确定完成与对方的面试？', function(){
		leaveRoom();
		commentState = null;
		showLoading();
		if(splogid != '' && parseInt(splogid) > 0){
			// 企业方记录结束日志
			var post = {}
			post.startTime = startTime;
			post.endTime = new Date().getTime();
			post.splogID = splogid;
			post.spend = 1;
			if(typeof sid == 'undefined'){
				post.roomer = roomer;
			}else{
				post.roomer = 1;
			}
			$.post(splogUrl, post, function(data) {
				if(typeof sid == 'undefined'){
					history.back();
				}
			});
		}
		if(typeof sid !== 'undefined'){
			$.post(spviewPauseUrl, {
				'sid': sid
			}, function(data) {
				window.location.reload();
			});
		}else{
			history.back();
		}
	})
}
// 对方正在视频中
function commenting(msg) {
	commentState = null;
	$("#splist").show();
	$("#sproom").hide();
	$("#backicon").show();
	if(cint){
		clearInterval(cint);
		cint = null;
	}
	if(coint){
		clearInterval(coint);
		coint = null;
	}
	showToast('对方正在面试中,请稍后再试', 2,function(){
		if(typeof sid == 'undefined' && document.referrer != ''){
			history.back();
		}
	});
}
// 对方拒绝视频
function commentRefused(msg) {
	if (msg.to == TrtcConfig.mine && msg.id == TrtcConfig.commentID) {
		commentState = null;
		$("#splist").show();
		$("#sproom").hide();
		$("#backicon").show();
		if(cint){
			clearInterval(cint);
			cint = null;
		}
		if(coint){
			clearInterval(coint);
			coint = null;
		}
		showToast('对方拒绝了你的面试请求', 2,function(){
			if(typeof sid == 'undefined' && document.referrer != ''){
				history.back();
			}
		});
	}
}
// 对方取消视频请求
function onClosesp(msg) {
	if (msg.to == TrtcConfig.mine && msg.id == TrtcConfig.commentID) {
		$("#spviewModal").hide();
		showToast('对方取消视频', 2, function(){
			if(typeof sid == 'undefined' && document.referrer != ''){
				history.back();
			}
		});
		commentState = null;
		leaveRoom(2);
	}
}
// 收到挂断通知,视频结束
function hangUp(msg) {
	if (msg.to == TrtcConfig.mine && msg.id == TrtcConfig.commentID) {
		leaveRoom(2);
		commentState = null;
		showToast('视频面试已结束', 2, function(){
			window.location.href = wapurl + 'member/';
		});
		if(splogid != '' && parseInt(splogid) > 0){
			// 企业收到个人的挂断通知，记录结束日志
			var post = {}
			post.startTime = startTime;
			post.endTime = new Date().getTime();
			post.splogID = splogid;
			post.spend = 1;
			post.roomer = '';
			$.post(splogUrl, post, function(data) {});
		}
	}
}
// 发送通知，视频结束
function sendHangUp() {
	var msg = {
		type: 'hangUp',
		data: {
			mine: {
				id: TrtcConfig.mine,
				timestamp: new Date().getTime()
			},
			to: {
				id: TrtcConfig.commentID
			}
		}
	};
	socketSend(msg);
}

function getCameraId() {
	return cameraId;
}

function getMicrophoneId() {
	return micId;
}

function removeView(id) {
	if ($('#' + id)[0]) {
		$('#' + id).remove();
		//将video-grid中第一个div设为main-video
		$('.video-box').first().css('grid-area', '1/1/3/4');
		setTimeout(function(){
			if(commentState == 'commenting'){
				leaveRoom(2);
				showToast('视频连接断开');
			}
		},1000);
	}
}

function isHidden() {
	var hidden, visibilityChange;
	if (typeof document.hidden !== "undefined") {
		hidden = "hidden";
		visibilityChange = "visibilitychange";
	} else if (typeof document.msHidden !== "undefined") {
		hidden = "msHidden";
		visibilityChange = "msvisibilitychange";
	} else if (typeof document.webkitHidden !== "undefined") {
		hidden = "webkitHidden";
		visibilityChange = "webkitvisibilitychange";
	}
	return document[hidden];
}

function addVideoView(id, isLocal = false) {
	var div = $('<div/>', {
		id: id,
		class: 'video-box',
		style: 'justify-content: center'
	});
	div.appendTo('#video-grid');
}

function unUserd() {
	hideLoading();
	showModal('您的浏览器不支持视频面试功能！<br>建议使用最新版Chrome浏览器', function(){
		history.back();
	})
}
function deviceNotFound(){
	showToast('浏览器获取不到摄像头/麦克风设备,无法视频面试', 2, function() {
		if(commentState){
			sendClosesp();
		}
		if(typeof sid == 'undefined' && document.referrer != ''){
			history.back();
		}else{
			window.location.reload();
		}
	});
}
function cameraDenied(){
	showToast('摄像头权限被拒绝,无法视频面试', 2, function() {
		if(commentState){
			sendClosesp();
		}
		if(typeof sid == 'undefined' && document.referrer != ''){
			history.back();
		}else{
			window.location.reload();
		}
	});
}
function cameraUsed() {
	showToast('摄像头已被占用,无法视频面试', 2, function() {
		if(commentState){
			sendClosesp();
		}
		if(typeof sid == 'undefined' && document.referrer != ''){
			history.back();
		}else{
			window.location.reload();
		}
	});
}

function joinFail() {
	showToast('发生错误,无法视频面试', 2, function() {
		if(commentState){
			sendClosesp();
		}
		if(typeof sid == 'undefined' && document.referrer != ''){
			history.back();
		}else{
			window.location.reload();
		}
	});
}
// 发送取消视频面试
function sendClosesp() {
	var timestamp = new Date().getTime();
	$("#splist").show();
	$("#sproom").hide();
	$("#backicon").show();
	$("#spComment").show();
	if(cint){
		clearInterval(cint);
		cint = null;
	}
	if(coint){
		clearInterval(coint);
		coint = null;
	}
	commentState = null;
	var msg = {
		type: 'closesp',
		data: {
			mine: {
				id: TrtcConfig.mine,
				timestamp: timestamp
			},
			to: {
				id: TrtcConfig.commentID
			}
		}
	};
	socketSend(msg);
	// 取消视频，记录聊天记录
	var pdata = {
		to: TrtcConfig.commentID,
		totype: mine.usertype == '2' ? 1 : 2,
		content: 'closesp',
		timestamp: timestamp
	};
	showLoading();
	$.post(wapurl + "index.php?c=chat&a=spviewChat", pdata, function(data) {
		hideLoading()
		if(typeof sid == 'undefined' && document.referrer != ''){
			history.back();
		}else{
			setTimeout(function(){
				leaveRoom(2);
			},1500);
		}
	});
}
// 发送已面试人数
function roomMessage(msdata) {
	var msg = {
		type: 'mscount',
		data: {
			mine: {
				group: 'trtc_' + TrtcConfig.roomId,
				msdata: msdata,
				timestamp: new Date().getTime()
			},
		}
	};
	socketSend(msg);
	
	var zxmsg = {
		type: 'getOnline',
		data: {
			mine: {
				group: 'trtc_' + TrtcConfig.roomId,
				id: TrtcConfig.mine,
				timestamp: new Date().getTime()
			}
		}
	}
	socketSend(zxmsg);
}
// 在线情况检查
function onGetOnline(data){
	if (data.group == 'trtc_' + TrtcConfig.roomId) {
		if(data.online.length > 0){
			for(var i in data.online){
				if(offlineList.indexOf(data.online[i]) > -1){
					$('#ms_' + data.online[i]).find('.spzl').text('');
				}
			}
		}
	}
}
// 有新成员开始排队
function countRoom(data) {
	if (data.roomid == 'trtc_' + TrtcConfig.roomId && typeof sid !== 'undefined') {
		$("#linenum").text(data.num);
		if(data.uuid && (data.uuid != TrtcConfig.mine) && usertype == '2'){
			if(!$('#ms_' + data.uuid)[0]){
				getSub(data.uuid);
			}else{
				$('#ms_' + data.uuid).find('.spzl').text('');
			}
		}
		if(data.zuid && (data.zuid != TrtcConfig.mine) && usertype == '2'){
			if($('#ms_' + data.zuid)[0]){
				$('#ms_' + data.zuid).find('.spzl').text('暂离');
			}
		}
	}
}
// 有新成员开始排队。查询其相关信息
function getSub(msuid){
	$.post(getSubUrl, {
		sid: sid,
		msuid: msuid
	}, function(data) {
		if (data && data.data.uid) {
			var res = data.data;
			var ehtml = '<div id="ms_' + res.uid + '" class="msj_list">';
			ehtml += '<div class="msj_list_user_box">';
			ehtml += '<div class="msj_list_user_pic">';
			ehtml += '<img src="' + res.photo_n + '"></div>';
			ehtml += '<div class="msj_list_user">' + res.uname;
			ehtml += '<a href="javascript:void(0);" onclick="nowresume(\'' + res.eid + '\', \'' + res.jobid + '\')" class="msj_list_userlook">查看简历</a></div>';
			ehtml += '<div class="msj_list_userjob">预约职位：<span class="msj_list_userjob_n">' + res.jobname + '</span></div></div>'
			ehtml += '<a href="javascript:void(0);" onclick="getLineData(\'' + res.uid + '\')" class="msj_list_userjob_yq">面试TA</a>';
			ehtml += '</div>';
			$('#waitingUser').append(ehtml);
		}
	},'json')
}
// 已面试人数
function mscount(data) {
	if (data.roomid == 'trtc_' + TrtcConfig.roomId && typeof sid !== 'undefined') {
		$("#msnum").text(data.num);
	}
}
// 处理重复加入视频面试房间
function onRoomBanned(data){
	if(data.id == TrtcConfig.mine){
		needRelink = false;
		socket.close();
		$("#spviewModal").hide();
		$("#spComment").hide();
		if(commentState == 'commenting'){
			leaveRoom(2);
		}
		if(cint){
			clearInterval(cint);
			cint = null;
		}
		if(coint){
			clearInterval(coint);
			coint = null;
		}
		showModal('您的账号有新连接加入视频面试间，本页面将退出视频面试间', function(){
			window.location.href = wapurl + 'member/';
		})
	}
}
// 测试视频画面
function csvideo() {
	$("#splist").hide();
	$("#sproom").show();
	$("#backicon").hide();
	$("#spComment").hide();
	$("#hangUp").attr('onclick', 'closecsvideo()');
	$("#csvideo").hide();
	var smallvideo = $("#smallvideo").html(),
		bigvideo = $("#bigvideo").html();
	$("#bigvideo").html(smallvideo);
	$("#smallvideo").html(bigvideo);
	$("#smallvideo").hide();
	shareUserId = TrtcConfig.userId;
	if (rtc) return;

	rtc = new RtcClient({
		userId: TrtcConfig.userId,
		roomId: TrtcConfig.csRoomId,
		sdkAppId: TrtcConfig.sdkAppId,
		userSig: TrtcConfig.userSig
	});
	rtc.join();
	showToast('测试开始, 测试时长限时' + csWait + '秒');
	setTimeout(function() {
		closecsvideo();
	}, csWait * 1000);
}
function closecsvideo(){
	location.reload();
}
// 视频面试开始
function spviewStart(){
	// 企业端记录视频面试成功记录
	hideLoading();
	if(usertype == '2' && viewuid != '' && commentState == 'commenting'){
		var post = {
			uid: viewuid,
			roomId: TrtcConfig.roomId,
			commentID: TrtcConfig.roomId
		};
		if(typeof sid !== 'undefined'){
			post.sid = sid;
		}
		if(spjobid != ''){
			post.jobid = spjobid;
		}
		if(typeof zid !== 'undefined'){
			post.zid = zid;
		}
		$.post(spSuccessUrl, post, function(data) {
			if (data) {
				splogid = data.data.splogid;
			}
		},'json');
		// 30秒更新一次面试记录
		startTime = new Date().getTime();
		logInt = setInterval(function() {
			if(splogid != '' && parseInt(splogid) > 0){
				endTime = new Date().getTime();
				
				post.startTime = startTime;
				post.endTime = endTime;
				post.splogID = splogid;
				$.post(splogUrl, post, function(data) {
					if (data) {
						var res = data.data;
						if(res.error == 1){
							showToast(res.msg);
						}else if (res.error == 2){
							// 到达后台设置最长视频面试时间，面试结束
							if(logInt){
								clearInterval(logInt);
								logInt = null;
							}
							if(commentState == 'commenting'){
								// 正在视频中需要结束当前视频
								leaveRoom();
							}
							showModal(res.msg, function(){
								if(document.referrer != ''){
									history.back();
								}else{
									window.location.href = weburl + '/member/';
								}
							})
						}
					}
				},'json');
			}
		}, 30000);
	}
}