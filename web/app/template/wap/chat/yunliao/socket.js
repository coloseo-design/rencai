var socket = null,
	ping_timer = null,
	islink = 1,
	nowSend = 0,
	pastSend = 0,
	chatpage = 1,
	jobShowed = true,
	invitedShowed = true,
	newChatMsg = false,
	lastid = '',
	isIELowVision = false,
	beforeScrollTop = 0,
	mhpage = 0,
	mhdata = true,
	commentState = null,
	roomData = {},
	spint = null,
	zphnetSocketOnline = [],
	canSend = false,
	preReady = false,
	morelog = false,
	adminjob = {};
//浏览器内部通过storage通讯
window.addEventListener("storage", function(e) {
	// 其他页面退出登录本页面需要关闭socket
	if (e.key == 'socketState' && e.newValue == '2') {
		if(socket && socket.readyState == 1){
			socket.close();
		}
	}
});
$(function() {

	isIELowVision = IEVersion();

	if ("WebSocket" in window) {
		webSocket(socketUrl);
		chatOnLoad();
		hiddenCommon();
	} else {
		console.log("您的浏览器不支持聊天!");
	}
	// 发送消息
	$('#send').click(function() {
		if (socket && socket.readyState == 1) {
			send();
		} else {
			webSocket(socketUrl);
			var timer = setInterval(function() {
				if (socket && socket.readyState == 1) {
					clearInterval(timer);
					timer = null;
					send();
				}
			}, 500);
			setTimeout(function() {
				if (timer) {
					clearInterval(timer);
					timer = null;
				}
			}, 10000);
		}
	});
	// 发送简历
	if ($('#sendExpcet')) {
		$('#sendExpcet').click(function() {
			sendExpcet();
		});
	}
	// 邀请面试
	if ($('#invite')) {
		$('#invite').click(function() {

			if(inviteNum==0){
				inviteCheck();
			}else{
				showToast('您已经邀请了该用户面试');
			}
			
		});
	}
	// 视频面试
	if ($('#spview')) {
		$('#spview').click(function() {
			window.localStorage.setItem("spviewinvite", "1");
			var url = wapurl + 'member/index.php?c=webrtc&roomer=1&fuid=' + toid;
			if(jid != ''){
				url += '&jid=' + jid;
			}
			window.location.href = url;
		});
	}
	// 发送职位
	if ($('#sendJob')) {
		$('#sendJob').click(function() {
			$('#joblist').removeClass('none');
		});
	}
	// 发送职位
	if ($('#closeJob')) {
		$('#closeJob').click(function() {
			$('#joblist').addClass('none');
		});
	}
	if (typeof chat_single != 'undefined') {
		// 获取准备信息
		getPrepare();
		getUseful();
	}
	// 公司主页
	if ($('#toCompany')) {
		$('#toCompany').click(function() {
			if (app.$data.company) {
				window.location.href = app.$data.company.wapurl;
			}
		});
	}
	timeFormat();
	//输入框失去焦点时，聊天内容高度，不大于屏幕高度，页面置顶,IOS需要处理此问题
	var u = navigator.userAgent;
	if (!!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/)) {
		$('#send_content').on('blur', function() {
			setTimeout(function() {
				window.scrollBy(0, 5);
				window.scrollBy(0, -5);
			}, 200)
		});
	}
	// 消息页面监听滚动
	if ($('#sysChatbox').length > 0) {
		beforeScrollTop = getScrollTop();
		window.addEventListener('scroll', listScroll);
	}
	// 聊天界面监听滚动
	if ($('#chatbody').length > 0) {
		beforeScrollTop = getScrollTop();
		window.addEventListener('scroll', chatScroll);
	}
	$("body").click(function(e) {
		var con = $("#commonly"); // 设置目标区域
		var face = $("#face");
		if ((!con.is(e.target) && con.has(e.target).length === 0) && (!face.is(e.target) && face.has(e.target).length === 0)) {
			commonHide();
		}
		var morediv = $("#more");
		if ((!con.is(e.target) && con.has(e.target).length === 0) && (!morediv.is(e.target) && morediv.has(e.target).length === 0)) {
			$("#chatfooter").addClass('none');
		}
	});
	$("#face").click(function() {
		face();
	});
	// 底部加号点击
	$("#more").click(function() {
		if ($('#chatfooter').hasClass('none')) {
			$("#chatfooter").removeClass('none');
		}else{
			$("#chatfooter").addClass('none');
		}
	});
});
//浏览器内部通过storage通讯
window.addEventListener("storage", function(e) {
	if (e.key == 'isspview' && e.newValue == '2') {
		// 一个页面接受或拒绝视频面试邀请，请他页面的选择框关闭
		$("#spviewModal").css('display','none');
		commentState = null;
		if(spint){
			clearInterval(spint);
			spint = null;
		}
	}
})
// 聊天界面滚动处理
function chatScroll() {
	if(! app.$data.usefulBox && ! app.$data.reportAdd){
		// 常用语弹出时不需要监听
		var afterScrollTop = getScrollTop();
		// 向下滑动，并且滑到底
		if((afterScrollTop <= beforeScrollTop) && afterScrollTop == 0 && morelog){
			throttle(moreChat);
		}
		beforeScrollTop = afterScrollTop;
	}
}
// 消息页面滚动处理
function listScroll() {
	var afterScrollTop = getScrollTop(),
		ch = getClientHeight(),
		sh = getScrollHeight();
	// 向下滑动，并且滑到底
	if((afterScrollTop > beforeScrollTop) && (afterScrollTop + ch + 60 >= sh)){
		throttle(fetchData);
	}
	beforeScrollTop = afterScrollTop;
}
// 节流函数
var timer, flag;
var throttle = function(func, wait = 1000){
	if (!flag) {
		flag = true;
		// 如果是立即执行，则在wait毫秒内开始时执行
		typeof func === 'function' && func();
		timer = setTimeout(() => {
			flag = false;
		}, wait);
	}
}
// 获取当前滚动条的位置
function getScrollTop() { 
	var scrollTop = 0; 
	if (document.documentElement && document.documentElement.scrollTop) { 
		scrollTop = document.documentElement.scrollTop; 
	} else if (document.body) { 
		scrollTop = document.body.scrollTop; 
	} 
	return scrollTop; 
} 
// 获取当前可视范围的高度 
function getClientHeight() { 
	var clientHeight = 0; 
	if (document.body.clientHeight && document.documentElement.clientHeight) { 
		clientHeight = Math.min(document.body.clientHeight, document.documentElement.clientHeight); 
	} 
	else { 
		clientHeight = Math.max(document.body.clientHeight, document.documentElement.clientHeight); 
	} 
	return clientHeight; 
} 
// 获取文档完整的高度 
function getScrollHeight() { 
	return Math.max(document.body.scrollHeight, document.documentElement.scrollHeight); 
}

function webSocket(socketUrl) {
	if(islink == 1){
		if (ping_timer) {
			clearInterval(ping_timer);
			ping_timer = null;
		}
		socket = new WebSocket(socketUrl);
		socket.onopen = function() {
			//向聊天服务器发送心跳包
			var ping = {
				type: 'ping'
			};
			ping_timer = setInterval(function() {
				if (socket && socket.readyState == 1) {
					socket.send(JSON.stringify(ping));
				} else {
					socket.close();
				}
			}, 50000);
		};
		socket.onerror = function() {
			islink = 2;
			if (ping_timer) {
				clearInterval(ping_timer);
				ping_timer = null;
			}
		};
		
		socket.onclose = function() {
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
				//显示收到的消息
				case 'getMessage':
					getMessage(e.data);
					break;
				case 'unsend':
					unSend(e.data);
					break;
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
				case 'closesp':
					onClosesp(e.data);
					break;
				case 'countRoom':
					countRoom(e.data);
					break;
				case 'mscount':
					mscount(e.data);
					break;
				case 'closeSpConfirm':
					closeSpConfirm(e.data);
					break;
				case 'getListOnline':
					onGetListOnline(e.data);
					break;
			}
		};
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
			tel = mine.tel;
			wxid = mine.wxid;
			if (socket && socket.readyState == 1) {
				bindUser(res);
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
	});
}

function bindUser(res) {
	if (res.yuntoken && res.yuntoken.token) {
		var yuntoken = res.yuntoken.token;
		var bind = {
			type: 'bind',
			data: {
				uid: mine.id,
				yuntoken: yuntoken
			}
		}
		socket.send(JSON.stringify(bind));
		canSend = true;
		window.localStorage.setItem("socketState", "1");
		
		if($("#zphnet_group").length > 0){
			// 网络招聘会详细页
			if(lineList.length > 0){
				var msg = {
					type: 'getListOnline',
					data: {
						mine: {
							id: mine.id,
							list: lineList,
							timestamp: new Date().getTime()
						}
					}
				};
				socket.send(JSON.stringify(msg));
				lineInt = setInterval(function(){
					sendGetonline();
				},15000);
			}
		}
		// 邀请面试发送消息
		if (typeof chat_single != 'undefined') {
			setTimeout(function() {
				if (inviteid != '' && invitedShowed) {
					invitedShowed = false;
					sendMessage('', 'invite', inviteid);
				}
			}, 800);
		}
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
function back() {
	if (document.referrer != ''){
		if(inviteid != ''){
			window.location.href = wapurl + 'member/?c=sysnews';
		}else{
			history.back();
		}
	}else{
		window.location.href = wapurl;
	}
}

function getPrepare() {
	$.post(wapurl + "index.php?c=chat&a=prepare", {
		'toid': toid,
		'totype': totype
	}, function(res) {
		if (res) {
			if (res.joblist) {
				app.$data.joblist = res.joblist;
			}
			if (res.expect) {
				app.$data.expect = res.expect;
			}
			if (res.company) {
				app.$data.company = res.company;
			}
			// 渲染聊天记录
			moreChat();
			preReady = true;
		}
	},'json');
}

// 发送消息
function send() {
	var content = document.getElementById('send_content');
	if (content.value != '') {
		// 发送聊天
		if (toid != '') {
			$('#send_content').css('height','24px');
			sendMessage(content.value, 'char', '');
			content.value = '';
			checkSend();
		} else {
			showToast('请选择' + chat_name + '对象')
		}
	}
}

function getMessage(msg) {
	if (msg.id && msg.totype == mine.usertype) {
		if (typeof toid != 'undefined' && msg.id == toid) {
			if(msg.msgtype == 'adminjob'){
				getAdminjob(msg);
			}else{
				render(msg, 'get');
			}
			// 收到消息处理
			var setArr = ['char', 'job', 'resume', 'invite', 'ask', 'confirm', 'refuse', 'spview','adminjob'];
			if(setArr.indexOf(msg.msgtype) != -1){
				setTimeout(function() {
					$.post(wapurl + "index.php?c=chat&a=setMsgStatus", {
						'id': toid,
						'type': totype,
						'nowid': mine.id,
						'nowtype': mine.usertype
					}, function(res) {
						if (typeof res.errmsg != 'undefined') {
							showToast(res.errmsg, 2, function() {
								location.href = wapurl;
								return;
							});
						}else if(msg.chatid){
							sendMessage('', 'read', msg.chatid);
						}
					},'json');
				}, 500);
			}
		} else {
			var content = (msg.content || '').replace(/&(?!#?[a-zA-Z0-9]+;)/g, '&amp;')
				.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/'/g, '&#39;').replace(/"/g, '&quot;') //XSS
				.replace(/img\[([^\s]+?)\]/g, function(img) { //转义图片
					return '[图片]';
				})
				.replace(/voice\[([^\s]+?)\]/g, function(img) { //转义图片
					return '[语音]';
				});
			if (msg.msgtype == 'ask') {
				content = '请求互换联系方式';
			} else if (msg.msgtype == 'confirm' || msg.msgtype == 'refuse') {
				content = '互换联系方式消息';
			} else {
				if (msg.msgtype == 'job') {
					content = '职位消息';
				} else if (msg.msgtype == 'resume') {
					content = '简历消息';
				} else if (msg.msgtype == 'invite') {
					content = '面试消息';
				} else if (msg.msgtype == 'spview') {
					content = '视频面试消息';
				}else if (msg.msgtype == 'map') {
					content = '[位置]';
				}
			}
			// 聊天列表处理接收信息
			if ($('#allchat').length > 0) {
				if ($('#chat_' + msg.id).length > 0) {
					for(var i in sysapp.$data.allchat){
						if(sysapp.$data.allchat[i].id == msg.id){
							sysapp.$data.allchat[i].content = content;
							sysapp.$data.allchat[i].time = msg.timefromat;
							if(sysapp.$data.allchat[i].unread){
								sysapp.$data.allchat[i].unread = parseInt(sysapp.$data.allchat[i].unread) + 1;
							}
							break;
						}
					}
				} else {
					let newItem = {
						avatar: msg.avatar,
						content: content,
						id: msg.id,
						tusertype: msg.ftype,
						linkman: msg.username,
						time: msg.timefromat,
						unread: 1
					};
					sysapp.$data.allchat.unshift(newItem);
				}
			}
			// foot
			if ($('#tzmsgNum').length > 0) {
				var msg_new = $('#tzmsgNum');
				if (msg_new.text() == '') {
					msg_new.text(1);
					msg_new.css('display','block');
				} else if (parseInt(msg_new.text()) > 0) {
					msg_new.text(parseInt(msg_new.text()) + 1);
					msg_new.css('display','block');
				}
			}
		}
	}
}
// 加号和发送切换
function checkSend() {
	var content = document.getElementById('send_content').value;
	if (content.trim() != '') {
		$('#send').removeClass('none');
		$('#more').addClass('none');
		//$('#chat_footer').addClass('bqbtn_ctrl');
	} else {
		$('#send').addClass('none');
		$('#more').removeClass('none');
		//$('#chat_footer').removeClass('bqbtn_ctrl');
	}
}
// 由简历/职位详情页进入,发预定消息
function prepare() {
	if (jid != '' && app.$data.joblist[jid] && jobShowed && mine.usertype == 1) {
		// 发送消息
		setTimeout(function() {
			sendMessage('', 'job', jid);
		}, 500);
		var content = greeting != '' ? greeting : '你好，可以聊聊吗？这个职位我很感兴趣，希望进一步了解';
		setTimeout(function() {
			sendMessage(content, 'char', '');
		}, 800);
	}
	if(mine.usertype != 1 && app.$data.chat.length == 0){
		// 没有聊天记录，非个人用户向个人用户打招呼
		var content = greeting != '' ? greeting : '你好，可以聊聊吗？';
		setTimeout(function() {
			sendMessage(content, 'char', '');
		}, 500);
	}
}

function sendExpcet() {
	if (app.$data.expect.id) {
		sendMessage('', 'resume', app.$data.expect.id);
	} else {
		showConfirm('您还没有可以投递的简历',function(){
			window.location.href = wapurl + '/member/index.php?c=resume'
		},'取消', '前往发布');
	}
}
function jobShow(id) {
	$('#joblist').addClass('none');
	// 发送消息
	sendMessage('', 'job', id);
	// 设置当前沟通职位
	jid = id;
}
function toShow(obj) {
	var url = obj.getAttribute('data-wapurl');
	if (url && url != '') {
		location.href = url;
	}
}

function inviteCheck() {
	showLoading()
	//判断是否达到每天最大操作次数
	$.post(wapurl + '/index.php?c=ajax&a=ajax_day_action_check', {
			'type': 'interview'
		},
		function(data) {
			hideLoading('loading');
			data = eval('(' + data + ')');
			if (data.status == -1) {
				showToast(data.msg);
				return false;
			} else if (data.status == 1) {

				$.post(wapurl + "/index.php?c=ajax&a=indexajaxresume", {
					show_job: 1
				}, function(data) {
					var data = eval('(' + data + ')');
					var status = data.status;
					if (status == 1) {
						showModal(data.msgList.join(''));
					} else if (status == 2) {
						if (data.spid) {
							showConfirm('当前账户套餐余量不足，请联系主账户增配！您还没有可以投递的简历',function(){
								window.location.href = wapurl + '/member/index.php?c=resume'
							});
						} else {
							showConfirm(data.msg,function(){
								window.location.href = wapurl + "/member/index.php?c=server&server=invite&id=" + toid;
							});
						}
					} else if (status == 3) {
						var inviteUrl = wapurl + 'index.php?c=resume&a=invite&uid=' + toid + '&chat=' + toid;
						if (jid != '') {
							inviteUrl += '&jobid=' + jid;
							location.href = inviteUrl;
						} else {
							location.href = inviteUrl;
						}
					} else {
						if (data.login == 1) {

							pleaselogin('您还未登录企业账号，是否登录？', wapurl + '/index.php?c=login')
						} else if (data.login == 2) {
							showToast('请先申请企业用户');
						} else {
							showModal(data.msg);

							return false;
						}
					}
				});
			}
		}
	);
}

// 展示邀请详情
function inviteShow(id) {
	if (id && id != '') {
		if (mine.usertype == 1) {
			var url = wapurl + 'member/index.php?c=invitecont&id=' + id;
		} else {
			var url = wapurl + 'member/index.php?c=invite&chat=1';
		}
		location.href = url;
	}
}

function nochat() {
	showLoading();
	$.post(wapurl + "/index.php?c=chat&a=delChatLog", {
		to: toid,
		type: totype
	}, function(res) {
		hideLoading();
		if (res) {
			if(res.error==3){
				showToast(res.errmsg);
			}else if (res.errmsg) {
				showToast(res.errmsg, 2, function() {
					location.href = wapurl;
				});
			} else {
				back();
			}
		}
	},'json');
}
// 发送消息
function sendMessage(content, type, id) {
	if (socket && socket.readyState == 1 && canSend) {
		// 根据消息类型区分保存内容
		if (type == 'job') {
			var msgcontent = 'jobid=' + id;
		} else if (type == 'resume') {
			var msgcontent = 'eid=' + id;
		} else if (type == 'invite') {
			var msgcontent = 'inviteid=' + id;
		} else if (type == 'ask') {
			var msgcontent = 'ask=' + id;
		} else if (type == 'confirm') {
			var msgcontent = 'confirm=' + id;
		} else if (type == 'refuse') {
			var msgcontent = 'refuse=' + id;
		} else if (type == 'read') {
			var msgcontent = 'read=' + id;
		} else {
			var msgcontent = content;
		}
		var mineData = {
			id: mine.id,
			mine: true,
			ftype: mine.usertype,
			avatar: mine.avatar,
			username: mine.username,
			linkman: mine.linkman,
			timestamp: new Date().getTime(),
			content: msgcontent,
			msgtype: type,
			op: {},
		};
		if (type == 'confirm') {
			mineData.op.confirmcon = content;
		}
		var sendData = {
			mine: mineData,
			to: {
				id: toid,
				utype: totype
			}
		}
		var message = {
			type: 'chatMessage',
			data: {
				content: sendData
			}
		}
		// 保存聊天记录
		var nolog = ['change', 'read'];
		if (nolog.indexOf(type) == -1) {
			var pdata = {
				to: sendData.to.id,
				totype: sendData.to.utype,
				content: msgcontent,
				timestamp: sendData.mine.timestamp,
				msgtype: sendData.mine.msgtype,
				nowid: sendData.mine.id,
				nowtype: sendData.mine.ftype,
			};

			$.post(wapurl + "/index.php?c=chat&a=chatLog", pdata, function(data) {
				if (data) {
					var res = eval('(' + data + ')');
					if (res.error != 0) {
						if (res.error == 4) {
							showConfirm(res.errmsg,function(){
								window.location.href = wapurl + "member/index.php?c=server&server=chat&id="+ pdata.to;
							});
							return false;
						}else if (res.error == 3) {
							return showToast(res.errmsg, 2);
						} else if (res.errmsg) {
							showToast(res.errmsg, 2, function() {
								location.href = wapurl;
							});
						}
					} else {
						message.data.content.mine.chatid = res.chatid;
						socket.send(JSON.stringify(message));
						// 渲染消息内容
						mineData.chatid = res.chatid;
						render(mineData, 'send', id);
					}
				}
			});
		} else {
			socket.send(JSON.stringify(message));
			// 渲染消息内容
			render(mineData, 'send', id);
		}
	} else {
		showToast(chat_name + '功能加载中');
	}
}
// 渲染消息内容
function render(msg, type, id = '') {
	if (type == 'send') {
		// 发送
		var chat = {
			mine: true,
			avatar: msg.avatar,
			msgtype: msg.msgtype
		};
		if (msg.msgtype == 'char'){
			if(msg.content.indexOf('img[') != -1){
			 	chat.image = msg.content.replace(/(^img\[)|(\]$)/g, '');
			}else{
				chat.content = rexContent(msg.content);
			}
		}else if (msg.msgtype == 'job'){
			chat.jobid = id;
			if(app.$data.joblist[id]){
				chat.job = app.$data.joblist[id];
				chat.ctime = timeFormat(msg.timestamp);
			}
			jid = id;
		}else if(msg.msgtype == 'resume'){
			chat.eid = id;
		}else if(msg.msgtype == 'invite'){
			// 邀请面试消息和普通消息类似
			chat.msgtype = 'char';
			chat.inviteid = id;
		}else if (msg.msgtype == 'ask'){
			chat.asktype = id;
			chat.asktext = getAskContent(chat);
		}else if(msg.msgtype == 'confirm'){
			chat.confirmtype = id;
			if(id=='wx'){
				chat.askvalue = towx;
				chat.askmsg	  = linkman+'的微信号:';
			}else if(id=='tel'){
				chat.askvalue = totel;
				chat.askmsg	  = linkman+'的手机号:';
			}
			
		}else if(msg.msgtype == 'refuse'){
			chat.refusetype = id;
			chat.refusetext = getRefuseContent(chat);
		}
	} else {
		// 接收
		if(msg.msgtype == 'char' && msg.content.indexOf('img[') == -1){
			var content = rexContent(msg.content);
		}else{
			var content = msg.content;
		}
		var	chat = {
			    chatid: new Date().getTime(),
				mine: false,
				msgtype: msg.msgtype,
				avatar: msg.avatar,
				content: content
			};
		if (msg.msgtype == 'job'){
			if(content.indexOf('jobid') != -1){
				var jobid = content.replace('jobid=','');
				if(app.$data.joblist[jobid]){
					chat.job = app.$data.joblist[jobid];
					chat.ctime = timeFormat(msg.timestamp);
				}
				jid = jobid;
			}
		}else if (msg.msgtype == 'resume'){
			if(content.indexOf('eid') != -1){
				chat.eid = content.replace('eid=','');
			}
		}else if(msg.msgtype == 'voice'){
			if(content.indexOf('voice[') != -1){
				chat.voice = content.replace(/(^voice\[)|(\]$)/g, '');
				chat.voicestatus= 0;
			}
			chat.voicelength = msg.voicelength;
			var gvw = getVoiceWidth(msg.voicelength);
			chat.vl = gvw.str;
			chat.vw = gvw.width;
		}else if (msg.msgtype == 'ask'){
			if(content.indexOf('ask') != -1){
				chat.asktype = content.replace('ask=','');
				chat.asktext = getAskContent(chat);
				chat.askstatus = 3;
			}
		}else if (msg.msgtype == 'confirm'){
			if(content.indexOf('confirm') != -1){
				var confirmid = content.replace('confirm=','');
				chat.confirmtype = confirmid;
				chat.askvalue = msg.confirmcon;
				if(confirmid == 'wx'){
					var asktype = '的微信号:';
					canwx = 1;
				}else if(confirmid == 'tel'){
					var asktype = '的手机号:';
					cantel = 1;
				}
				chat.askmsg   = linkman + asktype;
			}
		}else if(msg.msgtype == 'refuse'){
			
			if(content.indexOf('refuse') != -1){
				var refuseid = content.replace('refuse=','');
				chat.refusetype = refuseid;
				if(refuseid == 'wx'){
					canwx = 2;
				}else if(refuseid == 'tel'){
					cantel = 2;
				}
				chat.refusetext = getRefuseContent(chat);
			}
		}else if (msg.msgtype == 'spview'){
			
		}else if (msg.msgtype == 'read'){
			if(content.indexOf('read') != -1){
				var isnew = false;
				var readid = content.replace('read=','');
				var list = app.$data.chat;
				for(var i in list){
					if(typeof list[i].chatid !== 'undefined' && list[i].chatid == readid){
						isnew = true;
						list[i].read = 1;
					}
				}
				if(isnew){
					app.$data.chat = [];
					app.$data.chat = list;
				}
			}
			return
		}else if(msg.msgtype == 'invite'){
			// 邀请面试消息和普通消息类似
			if(content.indexOf('inviteid') != -1){
				chat.inviteid = content.replace('inviteid=','');
				chat.msgtype = 'char';
			}
		}else if(msg.msgtype == 'map'){
			// 位置消息
			let map = content.split('|');
			if(map.length == 4){
				chat.name = map[0];
				chat.url = map[1];
				chat.lat = map[2];
				chat.lng = map[3];
			}
		}else{
			if(content.indexOf('img[') != -1){
			 	chat.image = content.replace(/(^img\[)|(\]$)/g, '');
			}
		}
	}
	// 处理时间
	chat.time = getSendTime(msg.timestamp);
	if(msg.chatid){
		chat.chatid = msg.chatid;
	}
	app.$data.chat.push(chat);
	setTimeout(function(){
		var scroll = getScrollHeight();
		scrollTo(scroll);
	},100);
	// 图片类型加载较慢，滚动到底部需要时间
	if($("#chat_content").find('ul').last().find('img')){
		// 上面滚动过之后，新的高度
		lastscroll = document.getElementById('chat_content').scrollHeight;
		var timer_num = 0;
		var timer = setInterval(function() {
			timer_num++;
			var imgscroll = document.getElementById('chat_content').scrollHeight;
			if(imgscroll > lastscroll || timer_num > 5){
				scrollTo(imgscroll);
				clearInterval(timer);
				timer = null;
			}
		}, 200);
	}
}
function getSendTime(time){
	if(time - nowSend > 60*1000){
		nowSend = time;
		return timeFormat(time);
	}else{
		return '';
	}
}
function timeFormat(nowtime) {
	nowtime = parseInt(nowtime);
	if(nowtime){
		nowtime = new Date(nowtime);
	}else{
		nowtime = new Date();
	}
	var month = nowtime.getMonth() + 1,
		day = nowtime.getDate(),
		hour = nowtime.getHours(),
		minutes = nowtime.getMinutes();
	if (month < 10) {
		month = '0' + month;
	}
	if (hour < 10 && hour > 0) {
		hour = '0' + hour;
	}
	if (minutes < 10 && minutes > 0) {
		minutes = '0' + minutes;
	}
	if (day < 10 && day > 0) {
		day = '0' + day;
	}
	var time = month + '-' + day + ' ' + hour + ':' + minutes;
	return time;
}
// 转义内容
function rexContent (content){
	content = (content||'').replace(/&(?!#?[a-zA-Z0-9]+;)/g, '&amp;')
	.replace(/face\[([^\s\[\]]+?)\]/g, function(face){  //转义表情
		var alt = face.replace(/^face/g, '');
		return '####' + faces([alt]) + '####';
	});
	var carr = content.split('####');
	var nc = [];
	for(var i in carr){
		if(carr[i].trim() != ''){
			if(carr[i].indexOf(weburl + '/js/im/emoji_') > -1){
				nc.push({t:'image',n:carr[i]});
			}else{
				nc.push({t:'char',n:carr[i]});
			}
		}
	}
	return nc;
}

function upImage(obj) {
	var files = obj.files,
		file;
	if(files && files.length) {
		previewImage(obj, 'chatpic', 'index.php?c=chat&a=uploadImage');
	}
	var timer = setInterval(function() {
			var pic = $('#chatpic').val();
			if(pic != ''){
				clearInterval(timer);
				focusInsert(document.getElementById("send_content"), 'img[' + (pic || '') + ']', true);
				send();
				$('#chatpic').val('');
			}
		}, 30);
	obj.value = '';
}
// 页面滚动
function scrollTo(ypos) {
	var clientHeight = document.documentElement.clientHeight || document.body.clientHeight;
	var bottom = document.getElementById('chat_bottom').clientHeight;
	var head = document.getElementById('chat_head').clientHeight;
	ypos = ypos + bottom + head;
	if ((ypos) > clientHeight) {
		// 兼容各种浏览器
		document.body.scrollTop = ypos;
		document.documentElement.scrollTop = ypos;
	}
}

function moreChat() {
	if(chatpage > 1){
		showLoading();
	}
	$.ajax({
		type: "post",
		url: wapurl + "index.php?c=chat&a=getChatPage",
		data: {
			'id': toid,
			'totype': totype,
			'page': chatpage,
			'lastid': lastid
		},
		dataType: "json",
		success: function(res) {
			hideLoading();
			if (res) {
				if (res.msg) {
					return showToast(res.msg, 2, 8, function() {
						window.location.href = weburl + '/member/';
					});
				}
				chatpage = chatpage + 1;
				var scroll = null;
				if (chatpage > 2) {
					// 第二页开始，记录前一次滚动距离
					scroll = getScrollHeight();
				}

				$('#chat_more').remove();
				if (res.code == 0) {
					if(res.adminjob){
						adminjob = res.adminjob;
					}
					var chatlog = res.data;
					if (chatlog.length > 0) {
						pastSend = chatlog[0].sendTime;
						var list = [];
						for (var i in chatlog) {
							var chat = renderPast(chatlog[i], i);
							if(chat){
								list.push(chat);
							}
							// 最后一条时，如还有历史消息，增加更多消息
							if (i == chatlog.length - 1 && res.ismore) {
								morelog = true;
								lastid = chatlog[i]['id'];
							}else{
								morelog = false;
							}
						}
						list.reverse();
						app.$data.chat = list.concat(app.$data.chat);
					}
				}
				if (chatpage == 2) {
					// 第一页需做初始化准备
					var pint = setInterval(function(){
						if(preReady){
							clearInterval(pint);
							prepare();
						}
					},300);
					app.$nextTick(function(){
						var scroll = getScrollHeight();
						scrollTo(scroll);
					});
					$('#chat_content').css('display','block');
				}else{
					if (scroll) {
						app.$nextTick(function(){
							// 渲染后，滚动到上一页的距离
							var newScroll = getScrollHeight();
							scrollTo(newScroll - scroll);
						})
					}
				}
			}
		}
	});
}
// 渲染历史消息
function renderPast(msg, key) {
	var content = msg.content;
	var chat = {
			chatid: msg.chatid,
			mine: msg.mine,
			msgtype: msg.msgtype,
			avatar: msg.avatar,
			content: content,
			sendTime: msg.sendTime,
			fusertype: msg.fusertype,
			read: msg.read
		};
	if (msg.msgtype == 'ask'){
		if(content.indexOf('ask') != -1){
			var askid = content.replace('ask=','');
			chat.asktype = askid;
			chat.asktext = getAskContent(chat);
			chat.askstatus = msg.askstatus;
		}
	}else if (msg.msgtype == 'confirm'){
		if(content.indexOf('confirm') != -1){
			var confirmid = content.replace('confirm=','');
			chat.confirmtype = confirmid;
			chat.askvalue = msg.confirmcon;
			if(confirmid=='wx'){
				chat.askmsg   = linkman+'的微信号:';
			}else if(confirmid=='tel'){
				chat.askmsg   = linkman+'的手机号:';
			}
		}
	}else if(msg.msgtype == 'refuse'){
		if(content.indexOf('refuse') != -1){
			var refuseid = content.replace('refuse=','');
			chat.refusetype = refuseid;
			chat.refusetext = getRefuseContent(chat);
		}
	}else if (msg.msgtype == 'job'){
		if(content.indexOf('jobid') != -1){
			jid = content.replace('jobid=','');
			if(app.$data.joblist[jid]){
				chat.job = app.$data.joblist[jid];
				chat.jobid = jid;
				chat.ctime = timeFormat(chat.sendTime);
				jobShowed = false;
			}
		}
	}else if (msg.msgtype == 'adminjob'){
		if(content.indexOf('jobid') != -1){
			jid = content.replace('jobid=','');
			if(adminjob[jid]){
				chat.job = adminjob[jid];
				chat.jobid = jid;
				chat.ctime = timeFormat(chat.sendTime);
				jobShowed = false;
			}
		}
	}else if (msg.msgtype == 'resume'){
		if(content.indexOf('eid') != -1){
			chat.eid = content.replace('eid=','');
		}
	}else if (msg.msgtype == 'invite'){
		if(content.indexOf('inviteid') != -1){
			chat.msgtype = 'char';
			chat.inviteid = content.replace('inviteid=','');
			invitedShowed = false;
		}
	}else if (msg.msgtype == 'voice'){
		if(content.indexOf('voice[') != -1){
			chat.voice = content.replace(/(^voice\[)|(\]$)/g, '');
		}
		chat.voicelength = msg.voicelength;
		chat.voicestatus = msg.voicestatus;
		var gvw = getVoiceWidth(msg.voicelength);
		chat.vl = gvw.str;
		chat.vw = gvw.width;
	}else if (msg.msgtype == 'spview'){
		
	}else if (msg.msgtype == 'read'){
		return
	}else if (msg.msgtype == 'map'){
		// 位置消息
		let map = content.split('|');
		if(map.length == 4){
			chat.name = map[0];
			chat.url = map[1];
			chat.lat = map[2];
			chat.lng = map[3];
		}
	}else{
		for(var c in content){
			if(content[c].n.indexOf('img[') != -1){
				chat.image = content[c].n.replace(/(^img\[)|(\]$)/g, '');
			}
		}
	}
	var time = parseInt(chat.sendTime);
	if (key == 0){
		pastSend = time;
	}
	if(pastSend - time > 60*1000){
		chat.time = timeFormat(time);
		pastSend = time;
	}
	return chat;
}
//对方未在线，发送提醒
function unSend(msg) {
	$.post(wapurl + "index.php?c=chat&a=unSend", {
		'nowtype': msg.ftype,
		'toid': msg.toid,
		'totype': msg.totype
	}, function() {});
}
// 语音按时长获取宽度
function getVoiceWidth(length){
	var arr = length.split(':');
	var min = parseInt(arr[0]),
		sec = parseInt(arr[1]),
		str = '',
		width = 100;
	if (min > 0){
		str = min + "′";
		width = 200;
	}
	if (sec > 0){
		str += sec + '″';
		if (sec > 40){
			width = 175;
		}else if (sec > 20){
			width = 150;
		}else if (sec > 10){
			width = 125;
		}
	}
	var res = {str:str, width:width};
	return res;
}
//生成语音标签
function getVoiceHtml(voiceurl, msg) {

	var voicediv = document.createElement('div');

	if (isIELowVision) {
		var head = document.head || document.getElementsByTagName('head')[0];
		var bgsound = document.getElementsByTagName('bgsound')[0];
		if (!bgsound) {
			var player = document.createElement('bgsound');

			player.src = '';

			head.appendChild(player);
		}
	} else {

		var player = document.createElement('audio');
		player.id = 'voice_' + msg.chatid;
		var source = document.createElement('source');
		source.src = voiceurl;
		source.type = 'audio/mpeg';
		player.appendChild(source);
		//player.controls = 'controls';
		voicediv.appendChild(player);
	}
	return voicediv;
}
//播放语音
function playAudit(chatid, key) {
	var audio = document.getElementById('voice_' + chatid);
	var onplay = false;
	if (isIELowVision) {
		onplay = true;
	} else {
		if(app.$data.playMsgid){
			var palyedAudio = document.getElementById('voice_' + app.$data.playMsgid);
			palyedAudio.pause(); // 暂停
			palyedAudio.currentTime = 0;
		}

		if (audio !== null && chatid!=app.$data.playMsgid) {
			if (audio.paused) {
				audio.play(); // 播放 
				onplay = true;
			} else {
				audio.pause(); // 暂停
				audio.currentTime = 0;
			}
		}

		audio.addEventListener("play", function() { //开始播放时触发
			//console.log('开始播放');
		});
		
		audio.addEventListener("ended", function() {
			//console.log('播放结束');
			app.$data.playMsgid = null;
		}, false);

	}
	if (onplay) {
		app.$data.playMsgid = chatid;
	} else {
		app.$data.playMsgid = null;
	}
	var voicestatus = app.$data.chat[key].voicestatus;
	if (chatid && voicestatus == 0) {
		$.post(wapurl + "index.php?c=chat&a=setVoiceStatus", {
			chatid: chatid,
			id: toid,
			type: totype,
		},
		function(data) {
			if (data) {
				app.$data.chat[key].voicestatus = 1;
				if (data.errmsg) {
					showToast(data.errmsg, 2, function() {
						location.href = wapurl;
						return;
					});
				}
			}
		},'json');
	}
}

function IEVersion() {
	//取得浏览器的userAgent字符串
	var userAgent = navigator.userAgent;
	//判断是否IE浏览器
	var isIE = userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1;
	if (isIE) {
		var reIE = new RegExp("MSIE (\\d+\\.\\d+);");
		reIE.test(userAgent);
		var fIEVersion = parseFloat(RegExp["$1"]);
		if (fIEVersion < 9) {
			return true;
		}
	} else {
		return false;
	}
}
//表情库
function faces(fc) {
	var alt = {
			1: '[龇牙]',2: '[调皮]',3: '[流汗]',4: '[偷笑]',5: '[再见]',6: '[敲打]',7: '[擦汗]',8: '[流泪]',9: '[大哭]',10: '[嘘]',11: '[酷]',12: '[抓狂]',13: '[可爱]',14: '[色]',15: '[害羞]',16: '[得意]',17: '[吐]',18: '[微笑]',19: '[怒]',20: '[尴尬]',21: '[惊恐]',22: '[冷汗]',23: '[白眼]',24: '[傲慢]',25: '[难过]',26: '[惊讶]',27: '[疑问]',28: '[么么哒]',29: '[困]',30: '[憨笑]',31: '[撇嘴]',32: '[阴险]',33: '[奋斗]',34: '[发呆]',35: '[左哼哼]',36: '[右哼哼]',74: '[抱抱]',37: '[坏笑]',38: '[鄙视]',39: '[晕]',40: '[可怜]',41: '[饥饿]',42: '[咒骂]',43: '[折磨]',44: '[抠鼻]',45: '[鼓掌]',46: '[糗大了]',47: '[打哈欠]',48: '[快哭了]',49: '[吓]',50: '[闭嘴]',51: '[大兵]',52: '[委屈]',53: '[NO]',54: '[OK]',56: '[弱]',57: '[强]',60: '[握手]',63: '[胜利]',58: '[抱拳]',66: '[凋谢]',99: '[米饭]',108: '[蛋糕]',112: '[西瓜]',70: '[啤酒]',89: '[瓢虫]',62: '[勾引]',82: '[爱你]',69: '[咖啡]',72: '[月亮]',68: '[刀]',55: '[差劲]',59: '[拳头]',65: '[便便]',79: '[炸弹]',107: '[菜刀]',82: '[心碎了]',83: '[爱心]',71: '[太阳]',97: '[礼物]',92: '[皮球]',137: '[骷髅]',123: '[闪电]',80: '[猪头]',67: '[玫瑰]',98: '[篮球]',64: '[乒乓]',101: '[红双喜]',139: '[麻将]',73: '[彩带]',61: '[爱你]',95: '[示爱]',111: '[衰]',109: '[蜡烛]'
		},
		arr = {};

	$.each(alt, function(index, item) {
		arr[item] = weburl + '/js/im/emoji_' + index + '@2x.png';
	});
	if (fc) {
		return arr[fc];
	} else {
		return arr;
	}
}

function face() {
	if ($('#face').hasClass('sendbq')) {
		$('#commonly').removeClass('none');
		$('#face').attr('class', 'chat_footer_keyboard');
		var content = '',
			faceArr = faces();

		$.each(faceArr, function(key, item) {
			content += '<li title="' + key + '"><img src="' + item + '"></li>';
		});
		content = '<ul id="face_content" class="chat_face">' + content + '</ul>';
		$('#commonly').html(content);

		$("#face_content").off("click");
		$('#face_content').find('li').on('click', function(elem) {
			var title = elem.currentTarget.title;
			focusInsert(document.getElementById("send_content"), 'face' + title + ' ', true);
			checkSend();
		});
	} else {
		$('#commonly').addClass('none');
		$('#face').attr('class', 'sendbq');
		document.getElementById("send_content").focus();
	}
}
//在焦点处插入内容
function focusInsert(obj, str, nofocus) {
	var result, val = obj.value;
	nofocus || obj.focus();
	if (document.selection) { //ie
		result = document.selection.createRange();
		document.selection.empty();
		result.text = str;
	} else {
		result = [val.substring(0, obj.selectionStart), str, val.substr(obj.selectionEnd)];
		nofocus || obj.focus();
		obj.value = result.join('');
	}
}
function commonHide() {
	$('#commonly').addClass('none');
	$('#face').attr('class', 'sendbq');
}
function getAskContent(chat){
	var asktext = '';
	if(chat.asktype=='tel'){
		if(chat.mine){
			asktext = '正在请求互换电话，等待对方同意';
		}else{
			asktext = '我想要和您互换电话，您是否同意';
		}
	}else if(chat.asktype=='wx'){
		if(chat.mine){
			asktext = '正在请求互换微信，等待对方同意';
		}else{
			asktext = '我想要和您互换微信，您是否同意';
		}
	}
	return asktext;
}
function getRefuseContent(chat){
	var refusetext = '';
	if(chat.refusetype=='tel'){
		if(chat.mine){
			refusetext = '您已拒绝对方的互换电话请求';
		}else{
			refusetext = '对方已拒绝了您的互换电话请求';
		}
	}else if(chat.refusetype=='wx'){
		if(chat.mine){
			refusetext = '您已拒绝对方的互换微信请求';
		}else{
			refusetext = '对方已拒绝了您的互换微信请求';
		}
	}
	return refusetext;
}
function sendAsk(ask) {
	$('#sendtype').val('sendask');
	$('#hhtype').val(ask);

	if (ask == 'tel') {
		if (cantel != '3') {
			if (tel == '') {
				$('#wxdiv').css('display','none');
				$('#teldiv').css('display','block');
				$('#hhshow').css('display','block');
			}else{
				postAsk('tel', tel);
			}
		}else{
			showToast('已发出请求，请等待回复');
		}
	} else if (ask == 'wx') {
		if (canwx != '3') {
			// 因微信号无处修改，每次要弹出输入框（后面各身份类型调整之后，按手机号处理）
			$('#teldiv').css('display','none');
			$('#wxdiv').css('display','block');
			$('#hhshow').css('display','block');
			if (wxid != '') {
				$('#wxinput').val(wxid);
			}
		}else{
			showToast('已发出请求，请等待回复');
		}
	}
}
// 点击同意互换微信、电话
function confirmAsk(ask, chatid) {
	$('#sendtype').val('sendconfirm');
	$('#hhtype').val(ask);
	$('#chatid').val(chatid);
	if (ask == 'tel') {
		if (tel == '') {
			$('#wxdiv').css('display','none');
			$('#teldiv').css('display','block');
			$('#hhshow').css('display','block');
		}else{
			// 已有手机号，不需要重复输入
			postConfirm('tel', tel);
		}
	} else if (ask == 'wx') {
		// 因微信号无处修改，每次要弹出输入框（后面各身份类型调整之后，按手机号处理）
		$('#teldiv').css('display','none');
		$('#wxdiv').css('display','block');
		$('#hhshow').css('display','block');
		if (wxid != '') {
			$('#wxinput').val(wxid);
		}
	}
}

function savehh() {
	var hhtype = $('#hhtype').val();
	var hhvalue = '';
	if (hhtype == 'wx') {
		hhvalue = $('#wxinput').val();
	} else if (hhtype == 'tel') {
		hhvalue = $('#telinput').val();
		if (hhvalue == '') {
			showToast('请填写手机号', 2, 8);
			return false;
		} else if (!isjsMobile(hhvalue)) {
			showToast('手机格式错误！', 2, 8);
			return false;
		}
	}
	if (hhvalue) {
		var sendtype = $('#sendtype').val();
		if (sendtype == 'sendask') { //发送请求互换
			postAsk(hhtype, hhvalue);
		} else if (sendtype == 'sendconfirm') { //发送确认互换
			postConfirm(hhtype, hhvalue);
		}
	} else {
		if(hhtype == 'wx'){
			showToast('请填写微信号', 2, 8);
		}else if(hhtype == 'tel'){
			showToast('请填写联系电话', 2, 8);
		}
	}
}
//发送请求互换
function postAsk(ask, askvalue) {
	var asktext = '';
	if (ask && askvalue) {
		var loading = showLoading();
		$.post(wapurl + "index.php?c=chat&a=checkCanAsk", {
			toid: toid,
			totype: totype,
			ask: ask,
			askvalue: askvalue
		}, function(data) {
			hideLoading(loading);
			if (data.error == '9') {
				$('#hhshow').css('display','none');
				if (ask == 'tel') {
					asktext = '我想要和您互换电话，您是否同意';
					cantel = 3;
				} else if (ask == 'wx') {
					asktext = '我想要和您互换微信，您是否同意';
					canwx = 3;
				}
				huhuanStatus(ask, '3');
				sendMessage(1, 'ask', ask);
			} else {
				showToast(data.msg, 2, 8);
				if (data.error == '7') {
					huhuanStatus(ask, '3');
				}
			}
		},'json');
	}
}
//发送确认互换
function postConfirm(ask, askvalue) {
	if (ask && askvalue) {
		var chatid = $('#chatid').val();
		showLoading();
		$.post(wapurl + "index.php?c=chat&a=confirmAsk", {
			toid: toid,
			totype: totype,
			ask: ask,
			askvalue: askvalue,
			chatid: chatid
		}, function(data) {
			hideLoading();
			if (data.error == '1') {
				$('#hhshow').css('display','none');
				if (data.towx) {
					towx = data.towx;
					huhuanStatus('wx', '1');
				}
				if (data.totel) {
					totel = data.totel;
					huhuanStatus('tel', '1');
				}
				sendMessage(askvalue, 'confirm', ask);
				changeAsk(1, chatid);
			} else {
				showToast('参数错误，请重试');
			}
		}, 'json');
	}
}

function huhuanStatus(type, val) {
	if (type == 'wx') {
		canwx = val;
	} else if (type == 'tel') {
		cantel = val;
	}
}

function copyMsg(chatid) {
	var askvalue = document.querySelector('#ask' + chatid);
	askvalue.select(); // 选择对象
	if (document.execCommand("copy")) {
		document.execCommand("copy");
		showToast('已复制');
	};
}
// 拨打电话
function dial(tel){
	window.location.href = 'tel://' + tel;
}
function refuseAsk(ask, chatid) {
	if (toid != '') {
		showLoading();
		$.post(wapurl + "index.php?c=chat&a=refuseAsk", {
			toid: toid,
			totype: totype,
			ask: ask,
			chatid: chatid
		}, function(data) {
			hideLoading();
			if (data.error == 1) {
				huhuanStatus(ask, '2');
				sendMessage('', 'refuse', ask);
				changeAsk(2, chatid);
			} else {
				showToast('参数错误，请重试');
			}
		},'json');
	} else {
		showToast('参数错误，请重试');
	}
}
// 改变换电话、换微信请求状态
function changeAsk(status, chatid){
	for(var i in app.$data.chat){
		if(app.$data.chat[i].chatid == chatid){
			app.$data.chat[i].askstatus = status;
			break;
		}
	}
}
// 收到视频面试通知处理
function comment(data) {
	if (!commentState) {
		if (data.to == mine.id) {
			var timestamp = new Date().getTime();
			commentState = 'receive';
			window.localStorage.setItem("isspview", "0");
			
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
					hideLoading('loading');
					if(res.name){
						$("#modalLogo").attr('src',res.logo);
						$("#modalName").text(res.name);
						$("#spviewModal").css('display','block');
						roomData = data;
						spint = setInterval(function(){
							$("#spviewModal").css('display','none');
						},60*1000);
					}
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
						timestamp: timestamp
					},
					to: {
						id: data.id
					}
				}
			};
			socket.send(JSON.stringify(msg));
		}
	}
}
// 同意视频
function allowSp(){
	if(spint){
		clearInterval(spint);
		spint = null;
	}
	$("#spviewModal").css('display','none');
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
// 拒绝视频
function closeSp(){
	if(spint){
		clearInterval(spint);
		spint = null;
	}
	$("#spviewModal").css('display','none');
	var timestamp = new Date().getTime();
	var msg = {
		type: 'commentRefused',
		data: {
			mine: {
				id: roomData.to,
				timestamp: timestamp
			},
			to: {
				id: roomData.id
			}
		}
	};
	socket.send(JSON.stringify(msg));
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
// 对方取消视频请求
function onClosesp(msg) {
	if (msg.to == mine.id) {
		$("#spviewModal").css('display','none');
		showToast('对方取消视频请求');
		commentState = null;
		if(spint){
			clearInterval(spint);
			spint = null;
		}
	}
}
// 告知自己的全部连接，关闭是否面试的询问框
function closeSpConfirm(msg) {
	if (msg.to == mine.id) {
		$("#spviewModal").css('display','none');
		commentState = null;
		if(spint){
			clearInterval(spint);
			spint = null;
		}
	}
}
// 有新成员开始排队
function countRoom(data) {
	if (data.roomid == 'trtc_' + TrtcConfig.roomId) {
		$("#linenum").text(data.num);
	}
}
// 已面试人数
function mscount(data) {
	if (data.roomid == 'trtc_' + TrtcConfig.roomId) {
		$("#msnum").text(data.num);
	}
}
// 查询网络招聘会在线用户
function sendGetonline(){
	if(socket && socket.readyState == 1){
		if(lineList.length > 0){
			var msg = {
				type: 'getListOnline',
				data: {
					mine: {
						id: mine.id,
						list: lineList,
						timestamp: new Date().getTime()
					}
				}
			};
			socket.send(JSON.stringify(msg));
			zphnetSocketOnline = [];
			setTimeout(function(){
				if(zphnetSocketOnline.length == 0){
					$(".zphnetOnline").css('display','none');
				}
			},1500);
		}
	}
}
// 网络招聘会在线用户查询结果处理
function onGetListOnline(data){
	if(data.id == mine.id){
		if(data.list.length > 0){
			zphnetSocketOnline = data.list;
			for (var i in data.list){
				if($("#dxzph_" + data.list[i]).length > 0){
					$("#dxzph_" + data.list[i]).css('display','block');
				}
			}
		}
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
//举报回退
function reportAddBack(){
	$('#chatbox').removeClass('none');
	app.$data.reportAdd = false;
}
// 常用语保存
function reportSave(){
	var content = $("#report_description").val();
	if(content.trim()==''){
		return showToast('请填写举报内容');
	}else if(content.trim().length > 200){
		return showToast('举报内容最多200个');
	}
	showLoading();
	$.post(wapurl + "index.php?c=chat&a=reportSave", {
		content: content,
		toid: toid,
		totype:totype
	}, function(res) {
		hideLoading();
		if(res.errcode == 9){
			showToast(res.msg, 2, function(){
				reportAddBack();
			});
		}else{
			showToast(res.msg);
			
		}
	}, 'json');
}
// 常用语弹出框关闭
function usefulClose(){
	usefulShow = false;
	$('#Common_language').css('display','none');
	document.body.style.overflow = "auto";
}
// 前往常用语设置
function usefulSet(){
	$('#Common_language').css('display','none');
	document.body.style.overflow = "auto";
	$('#chatbox').addClass('none');
	app.$data.usefulBox = true;
}
// 常用语设置返回聊天界面
function usefulBack(){
	$('#chatbox').removeClass('none');
	app.$data.usefulBox = false;
}
// 前往常用语添加
function usefulAdd(){
	$("#ufid").val('');
	$("#description").val('');
	$("#usefulWords").text(0);
	app.$data.usefulBox = false;
	app.$data.usefulAdd = true;
}
// 常用语添加返回常用语设置
function usefulAddBack(){
	app.$data.usefulBox = true;
	app.$data.usefulAdd = false;
}
// 常用语保存
function usefulSave(){
	var content = $("#description").val();
	if(content.trim().length == 0){
		return showToast('请填写常用语');
	}
	if(content.trim().length > 200){
		return showToast('常用语字数最多200个');
	}
	var ufid = $("#ufid").val();
	showLoading();
	$.post(wapurl + "index.php?c=chat&a=usefulSave", {
		content: content,
		id: ufid
	}, function(res) {
		hideLoading();
		if(res.errcode == 9){
			showToast(res.msg, 2, function(){
				app.$data.useful = [];
				showToast();
				getUseful();
				usefulAddBack();
			});
		}else{
			showToast(res.msg);
		}
	}, 'json');
}
// 查询常用语
function getUseful(){
	$.post(wapurl + "index.php?c=chat&a=getUseful", {
		rand: Math.random(),
	}, function(res) {
		hideLoading('loading');
		if(res.length > 0){
			app.$data.useful = res;
		}
	}, 'json');
}
// 修改常用语
function editUseful(uk){
	if(typeof app.$data.useful[uk] != 'undefined'){
		var content = app.$data.useful[uk].content;
		$("#ufid").val(app.$data.useful[uk].id);
		$("#description").val(content);
		$("#usefulWords").text(content.length);
		app.$data.usefulBox = false;
		app.$data.usefulAdd = true;
	}else{
		showToast('数据异常', 2, function(){
			window.location.reload();
		});
	}
}
// 删除常用语选择框
function delConfirm(uk){
	$("#useful_expressions_mask").css('display','block');
	document.body.style.overflow = "hidden";
	$("#usefulkey").val(uk);
}
// 取消删除常用语
function usefulCancel(){
	$("#useful_expressions_mask").css('display','none');
	document.body.style.overflow = "auto";
	$("#usefulkey").val('');
}
function delUseful(){
	var uk = $("#usefulkey").val();
	if(typeof app.$data.useful[uk] != 'undefined'){
		var id = app.$data.useful[uk].id;
		showLoading();
		$.post(wapurl + "index.php?c=chat&a=delUseful", {
			id: id
		}, function(res) {
			hideLoading();
			if(res.errcode == 9){
				usefulCancel();
				app.$data.useful.splice(uk, 1);
				showToast(res.msg);
			}else{
				showToast(res.msg);
			}
		}, 'json');
	}else{
		showToast('数据异常', 2, function(){
			window.location.reload();
		});
	}
}
// 发送常用语消息
function sendUseful(uk){
	if(typeof app.$data.useful[uk] != 'undefined'){
		var content = app.$data.useful[uk].content;
		sendMessage(content, 'char', '');
		usefulClose();
	}else{
		showToast('数据异常', 2, function(){
			window.location.reload();
		});
	}
}
function lookResume(){
	if (app.$data.expect) {
		window.location.href = app.$data.expect.wapurl;
	}
}
function lookJob(url){
	window.location.href = url;
}
// 消息页面聊天记录
function fetchData() {
	var page = 0,
		loading = false,
		chatCate = sysapp.$data.chatCate,
		old = [];
	if(chatCate == 'all'){
		page = apage;
		if(page > 0){
			loading = true;
		}
		old = deepClone(sysapp.$data.allchat);
	}else if(chatCate == 'new'){
		page = npage;
		loading = true;
		old = deepClone(sysapp.$data.newchat);
	}else if(chatCate == 'old'){
		page = opage;
		loading = true;
		old = deepClone(sysapp.$data.oldchat);
	}
	if(loading){
		showLoading();
	}
	$.post(mhurl, {chatCate: chatCate, page: page}, function(data){
		hideLoading();
		if (data) {
			let list = data.data;
			if(old.length > 0 && list.length > 0){
				for(var i in list){
					for(var j in old){
						if(list[i].id == old[j].id){
							old.splice(j, 1);
						}
					}
					old.push(list[i]);
				}
			}else{
				old = list;
			}
		}
		if(chatCate == 'all'){
			if(old.length > 0){
				sysapp.$data.allchat = old;
			}
			apage++;
		}else if(chatCate == 'new'){
			if(old.length > 0){
				sysapp.$data.newchat = old;
			}
			newshow = true;
			npage++;
		}else if(chatCate == 'old'){
			if(old.length > 0){
				sysapp.$data.oldchat = old;
			}
			oldshow = true;
			opage++;
		}
		$('#sysChatbox').css('display', 'block');
	},'json');
}
// 消息页面聊天类型切换
function chatulShow(cate){
	sysapp.$data.chatCate = cate;
	$('#listbox').find('ul').css('display', 'none');
	$('#' + cate + 'chat').css('display', 'block');
	$('.chatno_tip').css('display', 'block');
	if(cate == 'new' && !newshow){
		fetchData();
	}else if(cate == 'old' && !oldshow){
		fetchData();
	}
}

function toMap(e){
	var url = wapurl + 'index.php?c=chat&a=map&x=' + e.lng + '&y=' + e.lat + '&name=' + e.name;
	window.location.href = url;
}

// 判断arr是否为一个数组，返回一个bool值
function isArray (arr) {
    return Object.prototype.toString.call(arr) === '[object Array]';
}

// 深度克隆
function deepClone (obj) {
	// 对常见的“非”值，直接返回原来值
	if([null, undefined, NaN, false].includes(obj)) return obj;
    if(typeof obj !== "object" && typeof obj !== 'function') {
		//原始类型直接返回
        return obj;
    }
    var o = isArray(obj) ? [] : {};
    for(let i in obj) {
        if(obj.hasOwnProperty(i)){
            o[i] = typeof obj[i] === "object" ? deepClone(obj[i]) : obj[i];
        }
    }
    return o;
}
function getAdminjob(msg){
	var jobid = msg.content.replace('jobid=', '');
	$.post(wapurl + "index.php?c=chat&a=getJob",{jobid: jobid}, function(res){
		if(res.id){
			var	chat = {
				    chatid: new Date().getTime(),
					mine: false,
					msgtype: msg.msgtype,
					avatar: msg.avatar,
					content: msg.content
				};
			chat.job = res;
			chat.ctime = timeFormat(msg.timestamp);
			// 处理时间
			chat.time = getSendTime(msg.timestamp);
			if(msg.chatid){
				chat.chatid = msg.chatid;
			}
			app.$data.chat.push(chat);
			setTimeout(function(){
				var scroll = getScrollHeight();
				scrollTo(scroll);
			},100);
		}
	},'json');
}