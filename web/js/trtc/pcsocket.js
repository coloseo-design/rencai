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
	csWait = 30,
	cint = null,
	coint = null,
	spconfirm = null,
	offlineList = [],
	splogid = '',
	startTime = 0,
	endTime = 0,
	logInt = null,
	spviewBell = null,
	needRelink = true,
	spint = null,
	requestdsq = null,
	dsqconfirm = null,
	canSend = false;
// receive    收到视频请求
// calling    面试请求中
// commenting 正在视频

//浏览器内部通过storage通讯
window.addEventListener("storage", function(e) {
	if (e.key == 'isspview' && e.newValue == '2' && spconfirm) {
		// 一个页面接收视频面试邀请，请他页面的选择框关闭
		layer.close(spconfirm);
		if(spviewBell){
			spviewBell.pause();
			spviewBell = null;
		}
		commentState = null;
	}
	// 其他页面退出登录本页面需要关闭socket
	if (e.key == 'socketState' && e.newValue == '2') {
		window.location.reload();
	}
});
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
					closesp(e.data);
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
		};
	}
}

function socketSend(msg) {
	if (socket) {
		if(socket.readyState == 1 && canSend){
			socket.send(JSON.stringify(msg));
		}else{
			var t = setInterval(function() {
				if (socket.readyState == 1 && canSend) {
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
		layer.msg('服务加载中，请稍后', 2, 8, function() {
			if (!socket) {
				webSocket(socketUrl);
				chatOnShow();
			}
		});
	}
}
// 加载聊天数据
function chatOnLoad() {
	$.post(weburl + "/index.php?m=chat&c=goChat", {
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
		$.post(weburl + "/index.php?m=chat&c=getToken", {
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
			// 标签显示
			if (!socket || (socket && socket.readyState != 1)) {
				webSocket(socketUrl);
				chatOnShow();
			}
		}else{
			// 标签隐藏，关闭响铃
			if(spviewBell){
				spviewBell.pause();
				spviewBell = null;
			}
		}
	});
}
// 发送视频面试通知
function sendComment(toid, jobid) {
	if(TrtcConfig.roomId != ''){
		if (socket && socket.readyState == 1) {
			if (!commentState) {
				commentState = 'calling';
				if (!spviewBell){
					spviewBell = document.createElement("audio");
					spviewBell.src = weburl + '/js/trtc/video.mp3';
					spviewBell.loop = true;
					spviewBell.play();
				}
				$("#bdiv").hide();
				$("#sprequest").show();
				$("#spWait").text(TrtcConfig.spWait);
				// 对方超过20秒未接受，弹出选择是否主动挂断
				requestdsq = setTimeout(function(){
					dsqconfirm = layer.confirm('对方可能不在线，是否挂断？', {
						btn: ['挂断', '继续']
					},
					function() {
						clearInterval(cint);
						cint = null;
						$("#sprequest").hide();
						layer.closeAll();
						layer.msg('对方未接受', 2, 8);
						document.getElementById('reinvite').style.display = 'block';
						setTimeout(function(){
							sendClosesp();
						},2000);
						if(spviewBell){
							spviewBell.pause();
							spviewBell = null;
						}
						layer.close(dsqconfirm);
					},
					function() {
						layer.close(dsqconfirm);
					});
				},20000);
				
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
				// 发出邀请后，隐藏重新邀请
				document.getElementById('reinvite').style.display = 'none';
				var attrjs = 'sendComment( "' + toid + '")';
				if(jobid){
					attrjs = 'sendComment( "' + toid + '", "' + jobid + '")';
				}
				$("#reinvite").attr('onclick', attrjs);
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
					spWait--
					document.getElementById('spWait').innerText = spWait;
					if (spWait < 1) {
						clearInterval(cint);
						cint = null;
						$("#sprequest").hide();
						layer.closeAll();
						layer.msg('对方未接受', 2, 8);
						document.getElementById('reinvite').style.display = 'block';
						setTimeout(function(){
							sendClosesp();
						},2000);
						if(spviewBell){
							spviewBell.pause();
							spviewBell = null;
						}
					} else if (commentState != 'calling') {
						layer.closeAll();
						clearInterval(cint);
						cint = null;
						$("#sprequest").hide();
						if(spviewBell){
							spviewBell.pause();
							spviewBell = null;
						}
					}
				}, 1000);
			} else {
				layer.msg('视频请求中,请稍候', 2, 8);
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
	}else{
		layer.msg('视频面试数据异常', 2, 8);
	}
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
	if($("#dwc").length > 0){
		$("#dwc").hide();
	}
}
// 退出视频房间
function leaveRoom(type) {
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
	if(TrtcConfig.roomId != ''){
		if (!commentState) {
			if (data.to == TrtcConfig.mine) {
				commentState = 'receive';
				if (!spviewBell && !isHidden()){
					spviewBell = document.createElement("audio");
					spviewBell.src = weburl + '/js/trtc/video.mp3';
					spviewBell.loop = true;
					spviewBell.play();
				}
				if (rtc) {
					// 正在测试视频画面，要先离开
					leaveRoom(2);
				}
				spconfirm = layer.confirm('收到视频面试邀请，是否接受', {
						btn: ['接受', '拒绝']
					},
					function() {
						layer.close(spconfirm);
						if(spviewBell){
							spviewBell.pause();
							spviewBell = null;
						}
						
						window.localStorage.setItem("isspview", "1");
						if(data.sid){
							// 企业发布的视频面试
							window.location.href = weburl + '/member/?c=spview&act=sproom&id=' + data.sid;
						}else if (data.zid){
							// 网络招聘会
							window.location.href = weburl + '/member/?c=spview&act=webrtc&zid=' + data.zid +'&fuid=' + data.id;
						}else{
							// 普通单对单
							window.location.href = weburl + '/member/?c=spview&act=webrtc&fuid=' + data.id;
						}
					},
					function() {
						layer.close(spconfirm);
						if(spviewBell){
							spviewBell.pause();
							spviewBell = null;
						}
						var msg = {
							type: 'commentRefused',
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
						socket.send(JSON.stringify(msg));
						commentState = null;
						window.localStorage.setItem("isspview", "2");
						
						// 拒绝视频，记录聊天记录
						var pdata = {
							to: data.id,
							totype: mine.usertype == '2' ? 1 : 2,
							content: 'refused',
							timestamp: timestamp
						};
						
						$.post(weburl + "/index.php?m=chat&c=spviewChat", pdata, function(data) {});
					});
				spint = setInterval(function(){
					layer.close(spconfirm);
					if(spviewBell){
						spviewBell.pause();
						spviewBell = null;
					}
				},parseInt(TrtcConfig.spWait)*1000);
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
// 邀请对象，接受视频邀请
function onCommentAllow(msg) {
	layer.closeAll();
	// 当前显示的页面才能同意邀请
	if (msg.to == TrtcConfig.mine && msg.id == TrtcConfig.commentID && !isHidden()) {
		if(cint){
			clearInterval(cint);
			cint = null;
			$("#sprequest").hide();
		}
		if(coint){
			clearInterval(coint);
			coint = null;
		}
		joinRoom();
		layer.load();
		if(spviewBell){
			spviewBell.pause();
			spviewBell = null;
		}
		if(spint){
			clearInterval(spint);
			spint = null;
		}
		if(requestdsq){
			clearTimeout(requestdsq);
			requestdsq = null;
		}
		document.getElementById('reinvite').style.display = 'none';
	}
}
// 告知自己的全部连接，关闭是否面试的询问框
function closeSpConfirm(msg) {
	if (msg.to == mine.id) {
		layer.close(spconfirm);
		if(spviewBell){
			spviewBell.pause();
			spviewBell = null;
		}
		if(spint){
			clearInterval(spint);
			spint = null;
		}
		commentState = null;
	}
}
// 对方正在视频中
function commenting(msg) {
	layer.closeAll();
	layer.msg('对方正在面试中,请稍后再试', 2, 8);
	commentState = null;
	$("#reinvite").show();
	if($("#dwc").length > 0){
		$("#dwc").hide();
	}
	if(cint){
		clearInterval(cint);
		cint = null;
		$("#sprequest").hide();
	}
	if(coint){
		clearInterval(coint);
		coint = null;
	}
	if(spviewBell){
		spviewBell.pause();
		spviewBell = null;
	}
	if(requestdsq){
		clearTimeout(requestdsq);
		requestdsq = null;
	}
}
// 对方拒绝视频
function commentRefused(msg) {
	if (msg.to == TrtcConfig.mine && msg.id == TrtcConfig.commentID) {
		layer.closeAll();
		layer.msg('对方拒绝了你的面试请求', 2, 8);
		commentState = null;
		$("#reinvite").show();
		if($("#dwc").length > 0){
			$("#dwc").hide();
		}
		if(cint){
			clearInterval(cint);
			cint = null;
			$("#sprequest").hide();
		}
		if(coint){
			clearInterval(coint);
			coint = null;
		}
		if(spviewBell){
			spviewBell.pause();
			spviewBell = null;
		}
		if(requestdsq){
			clearTimeout(requestdsq);
			requestdsq = null;
		}
	}
}
// 对方取消视频请求
function closesp(msg) {
	if (msg.to == TrtcConfig.mine && msg.id == TrtcConfig.commentID) {
		layer.closeAll();
		layer.msg('对方取消视频', 2, 8);
		commentState = null;
		leaveRoom(2);
		$("#reinvite").show();
		if($("#dwc").length > 0){
			$("#dwc").hide();
		}
		if(spviewBell){
			spviewBell.pause();
			spviewBell = null;
		}
		if(spint){
			clearInterval(spint);
			spint = null;
		}
	}
}
// 收到挂断通知,视频结束
function hangUp(msg) {
	if (msg.to == TrtcConfig.mine && msg.id == TrtcConfig.commentID) {
		leaveRoom(2);
		commentState = null;
		layui.use('layer', function() {
			var layer = layui.layer;
			layer.open({
				type: 0,
				content: '视频面试已结束',
				end: function() {
					window.location.href = weburl + '/member/';
				}
			});
		});
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
				layer.msg('视频连接断开', 2, 8, function() {
					$("#reinvite").show();
					if($("#dwc").length > 0){
						$("#dwc").hide();
					}
					$("#sprequest").hide();
				});
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
	layui.use('layer', function() {
		var layer = layui.layer;
		layer.open({
			type: 0,
			content: '您的浏览器不支持视频面试功能！<br>建议使用最新版Chrome浏览器或将浏览器更换为极速模式',
			end: function() {
				window.location.href = weburl + '/member/';
			}
		});
	});
}
function deviceNotFound(){
	layer.msg('浏览器获取不到摄像头/麦克风设备,无法视频面试', 2, 8, function() {
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
	layer.msg('摄像头权限被拒绝,无法视频面试', 2, 8, function() {
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
	layer.msg('摄像头已被占用,无法视频面试', 2, 8, function() {
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
	layer.msg('发生错误,无法视频面试', 2, 8, function() {
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
	if(cint){
		clearInterval(cint);
		cint = null;
		$("#sprequest").hide();
		if(spviewBell){
			spviewBell.pause();
			spviewBell = null;
		}
	}
	if(coint){
		clearInterval(coint);
		coint = null;
	}
	commentState = null;
	var timestamp = new Date().getTime();
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
		totype: usertype == '2' ? 1 : 2,
		content: 'closesp',
		timestamp: timestamp
	};
	
	$.post(weburl + "/index.php?m=chat&c=spviewChat", pdata, function(data) {});
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
			}
		}
	};
	socketSend(msg);
	// 检查还在面试间页面的个人数量
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
// 已面试人数
function mscount(data) {
	if (data.roomid == 'trtc_' + TrtcConfig.roomId && typeof sid !== 'undefined') {
		$("#msnum").text(data.num);
	}
}
// 处理重复进入视频面试房间
function onRoomBanned(data){
	if(data.id == TrtcConfig.mine){
		needRelink = false;
		socket.close();
		layer.closeAll();
		if(commentState == 'commenting'){
			leaveRoom(2);
		}
		if(cint){
			clearInterval(cint);
			cint = null;
			$("#sprequest").hide();
			if(spviewBell){
				spviewBell.pause();
				spviewBell = null;
			}
		}
		if(coint){
			clearInterval(coint);
			coint = null;
		}
		layer.open({
			type: 0,
			content: '您的账号有新连接加入视频面试间，本页面将退出视频面试间',
			end: function() {
				window.location.href = weburl + '/member/';
			}
		});
	}
}
// 有新成员开始排队。查询其相关信息
function getSub(msuid){
	$.post(weburl + "/member/index.php?c=spview&act=getSub", {
		sid: sid,
		msuid: msuid
	}, function(data) {
		data = eval('(' + data + ')');
		if (data && data.uid) {
			var ehtml = '<li id="ms_' + data.uid + '" class="list">';
				ehtml += '<img src="' + data.photo_n + '" alt="" class="head_portrait">';
				ehtml += '<div class="name">' + data.uname; 
				ehtml += '<a href="javascript:void(0);" onclick="lookresume(\''+ data.uid +'\')" class="look_resume" target="_blank">&nbsp;&nbsp;查看简历</a></div>';
				ehtml += '<div class="job">预约职位：' + data.jobname + '</div>';
				ehtml += '<a href="javascript:void(0);" onclick="getLineData(' + data.uid + ')" class="jump">邀请面试</a>';
				ehtml += '</li>';
			$('#waitingUser').append(ehtml);
		}
	})
}
// 测试视频画面
function csvideo() {
	$("#csvideo").hide();
	shareUserId = TrtcConfig.userId;
	if (rtc) return;

	rtc = new RtcClient({
		userId: TrtcConfig.userId,
		roomId: TrtcConfig.csRoomId,
		sdkAppId: TrtcConfig.sdkAppId,
		userSig: TrtcConfig.userSig
	});
	rtc.join();
	layer.msg('测试开始, 测试时长限时' + csWait + '秒', 2, 9);
	setTimeout(function() {
		$("#csvideo").show();
		leaveRoom();
	}, csWait * 1000);
}
// 视频面试开始
function spviewStart(){
	layer.closeAll();
	// 企业端记录视频面试成功记录
	if(usertype == '2' && viewuid != '' && commentState == 'commenting'){
		var post = {
			uid: viewuid,
			roomId: TrtcConfig.roomId
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
		$.post("index.php?c=spview&act=spSuccess", post, function(data) {
			if (data) {
				splogid = data;
				if(typeof zid !== 'undefined' && $('#remarkshow')){
					$('#remarkshow').show();
				}
			}
		});
		
		// 30秒更新一次面试记录
		startTime = new Date().getTime();
		logInt = setInterval(function() {
			if(splogid != '' && parseInt(splogid) > 0){
				endTime = new Date().getTime();
				
				post.startTime = startTime;
				post.endTime = endTime;
				post.splogid = splogid;
				$.post("index.php?c=spview&act=splog", post, function(data) {
					if (data) {
						var res = eval('(' + data + ')');
						if(res.error == 1){
							layer.msg(res.msg, 2,9);
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
							layui.use('layer', function() {
								var layer = layui.layer;
								layer.open({
									type: 0,
									content: res.msg,
									end: function() {
										if(document.referrer != ''){
											history.back();
										}else{
											window.location.href = weburl + '/member/';
										}
									}
								});
							});
						}
					}
				});
			}
		}, 30000);
	}
}
// 企业主动邀请面试，
function sendWxNotice(sid, ruid, jobid) {

	$.post(weburl + "/index.php?m=ajax&c=sendWxNotice", {
		sid: sid,
		ruid: ruid,
		jobid: jobid
	}, function(data) {
		if (data) {
			return
		}
	})
}