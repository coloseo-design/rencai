var socket = null,
	islink = 1,
	ping_timer = null,
	lastid = '',
	sendTime = 0,
	pastSend = 0,
	chatpage = 1,
	jobShowed = true,
	newChatMsg = false,
	joblist = null,
	expect = null,
	titledsq = null,
	isIELowVision = false,
	playMsgid = null,
	chatlistch = 0,
	boxElement = null,
	mhpage = 0,
	mhdata = true,
	commentState = null,
	spconfirm = null,
	spint = null,
	zphnetSocketOnline = [],
	spviewBell = null,
	canSend = false,
	moreReady = false,

	usefullist = [],
	
	comalljobnum = 0,
	inviteNum = 0,
	chatMineStorage = {},
	chatStorage = [],
	adminjob = {};


var hiddenProperty = 'hidden' in document ? 'hidden' : 'webkitHidden' in document ? 'webkitHidden' : 'mozHidden' in document ? 'mozHidden' : null;
// 不同浏览器的事件名
if (hiddenProperty) {
	var visibilityChangeEvent = hiddenProperty.replace(/hidden/i, 'visibilitychange');
}
var pageTitle = document.title;
var onVisibilityChange = function() {
	if (typeof isAdmin === 'undefined') {
		if(document[hiddenProperty]){
			// 标签隐藏
			if (newChatMsg) {
				var titAn = true;
				if (titledsq) {
					clearInterval(titledsq);
				}
				titledsq = setInterval(function() {
					if (titAn) {
						document.title = '【新消息】';
						titAn = false;
					} else {
						document.title = $('#zwf').text();
						titAn = true;
					}
				}, 1000);
			} else {
				document.title = pageTitle;
				clearInterval(titledsq);
				titledsq = null;
			}
			// 关闭响铃
			if(spviewBell){
				spviewBell.pause();
				spviewBell = null;
			}
		}else{
			if (!socket || (socket && socket.readyState != 1)) {
				webSocket(socketUrl);
				chatOnShow();
			}
			document.title = pageTitle;
			clearInterval(titledsq);
			titledsq = null;
		}
	}
}
document.addEventListener(visibilityChangeEvent, onVisibilityChange);

//浏览器内部通过storage通讯
window.addEventListener("storage", function(e) {
	if (e.key == 'isspview' && e.newValue == '2' && spconfirm) {
		// 一个页面接受或拒绝视频面试邀请，请他页面的选择框关闭
		layer.close(spconfirm);
		commentState = null;
		if(spint){
			clearInterval(spint);
			spint = null;
		}
	}
})
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

	//获取所有聊天用户数据缓存
	if(typeof(isAdmin) === 'undefined'){
		getAllChatOnlineData(toid);
	}
	if ("WebSocket" in window && typeof(isAdmin) === 'undefined') {
		webSocket(socketUrl);
		chatOnLoad();
	} else {
		console.log("您的浏览器不支持聊天!");
	}
	// 发送消息
	if ($('#send').length > 0) {
		$('#send').click(function() {
			if (socket && socket.readyState == 1) {
				send();
			} else {
				webSocket(socketUrl);
				var timer = setInterval(function() {
					if (socket && socket.readyState == 1) {
						clearInterval(timer);
						send();
					}
				}, 500);
				setTimeout(function() {
					if (timer) {
						clearInterval(timer);
					}
				}, 10000);
			}
		});
	}
	if ($('#send_content').length > 0) {
		$('#send_content').on('keydown', function(e) {
			var keyCode = e.keyCode;
			if (keyCode === 13) {
				e.preventDefault();
				if (socket && socket.readyState == 1) {
					send();
				} else {
					webSocket(socketUrl);
					var timer = setInterval(function() {
						if (socket && socket.readyState == 1) {
							clearInterval(timer);
							send();
						}
					}, 500);
					setTimeout(function() {
						if (timer) {
							clearInterval(timer);
						}
					}, 10000);
				}
			}
		});
	}
	// 查询准备数据
	
	// 列表未读消息
	if ($('#showUnread').length > 0) {
		$('#showUnread').click(function() {

			var list = $('#chatList').find('li');

			var i = $('#showUnread').find('i');



			if (i.hasClass('chat_wd_checkbox_xz')) {
				i.removeClass('chat_wd_checkbox_xz');
				list.each(function(index, item) {
					var su = $(this).find('.chat_box_usermsg').text();
					if ($.trim(su) == '') {
						$(this).removeClass('none');
					}
				})
			} else {
				i.addClass('chat_wd_checkbox_xz');

				list.each(function(index, item) {
					var su = $(this).find('.chat_box_usermsg').text();

					if ($.trim(su) == '') {
						$(this).addClass('none');
					}
				})
			}
		});
	}
	
	$("body").click(function(e) {
		var con = $("#commonly"); // 设置目标区域
		var face = $("#face");
		var usefulButton = $("#usefulButton");
		if ((!con.is(e.target) && con.has(e.target).length === 0) 
			&& (!face.is(e.target) && face.has(e.target).length ===0)) {
			commonHide();
		}
		if(!usefulButton.is(e.target) && usefulButton.has(e.target).length ===0){
			closeUseful();
		}
	});
	$("#face").click(function() {
		face();
	});
	jsPrepare();
});
// js点击监听
function jsPrepare(){
	// 发送简历
	$('#sendExpcet').click(function() {
		sendExpcet();
	});
	// 发送职位
	$('#sendJob').click(function() {
		sendJob();
	});
	// 发送职位
	$('#closeJob').click(function() {
		$('#joblist').addClass('none');
	});
	//互换电话和微信
	$('.sendask').click(function() {
		var type = $(this).attr('data-id');
		if (type) {
			sendAsk(type);
		}
	});
	// 不感兴趣
	$('#nochat').click(function() {
		nochat();
	});
	// 线下面试
	$('#inviteCheck').on('click', function(e) {
		if(inviteNum>0){
			layer.msg('您已邀请了该用户面试', 2, 9);
		}else{
			inviteResume("#inviteCheck");
		}
		
	});
	// 视频面试
	$('#spview').click(function() {
		window.localStorage.setItem("spviewinvite", "1");
		var url = weburl + '/member/index.php?c=spview&act=webrtc&roomer=1&fuid=' + toid;
		if(jid != ''){
			url += '&jid=' + jid;
		}
		window.location.href = url;
	});
}
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
					socket.send(JSON.stringify(ping));
				} else {
					socket.close();
				}
			}, 50000);
		};
		
		socket.onerror = function() {
			socket = null;
			islink = 2;
			if (ping_timer) {
				clearInterval(ping_timer);
				ping_timer = null;
			}
		};
		
		socket.onclose = function(res) {
			if (ping_timer) {
				clearInterval(ping_timer);
				ping_timer = null;
				if(res.code == 1006){
					// 服务器断开的重连
					webSocket(socketUrl);
					chatOnShow();
				}
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
				case 'getUnread':
					if ($('#memberNoChat').length > 0) {
						getUnread();
					}
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
					closesp(e.data);
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

function UsefulTrigger(){
	if($('#usefulBox').hasClass('none')){
		showUseful();
	}else{
		closeUseful();
	}
}
function showUseful(){
	$('#usefulBox').removeClass('none');
}
function closeUseful(){
	$('#usefulBox').addClass('none');
}
//常用语初始化，默认窗体隐藏，内容为空
function usefulDefConfig(){

	closeUseful();
	editUsefulClose();
	var usefulhtml = '',
		usefulSethtml = '';

	if(usefullist.length>0){
		for(let i in usefullist){

			usefulhtml +='<div class="cyy_box_list" onclick="sendUseful('+i+')"><span class="cyy_box_name">'+usefullist[i].content+'</span>  <a href="javascript:void(0);" class="cyy_box_fs"> 发送</a></div>';
			
			usefulSethtml +='<div class="cyy_set_list">. '+usefullist[i].content;

			if(typeof usefullist[i].uid != 'undefined' && usefullist[i].uid !=''){
				usefulSethtml +='	<span class="cyy_set_list_cz">';
				usefulSethtml +='		<a href="javascript:void(0);" onclick="delUseful('+i+');">删除</a>';
				usefulSethtml +='		<a href="javascript:void(0);" onclick="editUseful('+i+')">编辑</a>';
				usefulSethtml +='	</span>';
			}

			usefulSethtml +='</div>';
		}
	}else{
		usefulhtml +='<div>目前没有添加常用语</div>';
		usefulSethtml +='<div>目前没有添加常用语</div>';
	}

	$('#usefulListBox').html(usefulhtml);
	$('#usefulSetList').html(usefulSethtml);
	
}
function usefulSetShow(){

	$.layer({
        type: 1,
        title: '常用语设置',
        closeBtn: [0, true],
        border: [10, 0.3, '#000', true],
        area: ['auto', 'auto'],
        page: {
            dom: "#usefulSetBox"
        }
    });
}
function editUseful(key){
	var usefulid = '',
		usefulcon= '';
	if(typeof key != 'undefined' && typeof usefullist[key].id != 'undefined' && usefullist[key].id!=''){
		usefulid	= usefullist[key].id;
		usefulcon	= usefullist[key].content;
	}
	
	$('#usefulid').val(usefulid);
	$('#usefulcon').val(usefulcon);
	$('#usefulAddBox').show();
}
function editUsefulClose(){
	$('#usefulid').val('');
	$('#usefulcon').val('');
	$('#usefulAddBox').hide();
}
// 常用语保存
function usefulSave(){
	var content = $("#usefulcon").val();
	if(content.trim().length == 0){
		layer.msg('请填写常用语', 2, 8);return false;
	}
	if(content.trim().length > 200){
		layer.msg('常用语字数最多200个', 2, 8);return false;
	}
	var usefulid = $("#usefulid").val();
	var loadi = loadlayer();
	$.post(weburl + "/index.php?m=chat&c=usefulSave", {
		content: content,
		id: usefulid
	}, function(res) {
		layer.closeAll();
		if(res.errcode == 9){
			layer.msg(res.msg, 2, 9,function(){
				
				if(usefulid!=''){
					
					for(let i in usefullist){
						if(usefullist[i].id == usefulid){
							usefullist[i].content = content;
						}
					}
				}else{
					var userful = {
						content:content,
						id:res.id,
						uid:mine.id
					};
					usefullist.unshift(userful);
				}
				usefulDefConfig();
			});
		}else{
			layer.msg(res.msg, 2, 8);
		}
	}, 'json');
}
//删除常用语
function delUseful(key){

	if(typeof key != 'undefined' && typeof usefullist[key].id !='undefined' && usefullist[key].id !=''){

		var id = usefullist[key].id;

		var loadi = loadlayer();
		$.post(weburl + "/index.php?m=chat&c=delUseful", {
			id: id
		}, function(res) {
			layer.closeAll();
			if(res.errcode == 9){
				usefullist.splice(key, 1);
				usefulDefConfig();
				layer.msg(res.msg, 2, 9);
			}else{
				layer.msg(res.msg, 2, 8);
			}
		}, 'json');
	}else{
		layer.msg('数据异常', 2, 8);
	}
}
// 发送常用语消息
function sendUseful(key){
	if(typeof usefullist[key] != 'undefined'){
		var content = usefullist[key].content;
		sendMessage(content,'char','');
		closeUseful();
	}else{
		layer.msg('数据异常', 2, 8);
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
			usefullist = res.usefullist;
			usefulDefConfig();
			tel = mine.tel;
			wxid = mine.wxid;
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
			// 让其他页面检查未读消息
			if (toid != '') {
				var jw = setInterval(function() {
					if (socket && socket.readyState == 1) {
						clearInterval(jw);
						jw = null;
						var message = {
							type: 'getUnread',
							data: {
								uid: mine.id,
							}
						}
						socket.send(JSON.stringify(message));
					}
				}, 1000);
				setTimeout(function() {
					if (jw) {
						clearInterval(jw);
						jw = null;
					}
				}, 10000);
			}
		}
	});
}
// 重新连接请求数据
function chatOnShow() {
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
				},1000 * 60);
			}
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

function checkSend() {
	var content = document.getElementById('send_content').value;
	if (content.trim() != '') {
		$('#send').removeClass('disclick');
	} else {
		$('#send').addClass('disclick');
	}
}

function back() {
	history.back();
}

function getPrepare() {
	var loadi = setInterval(function(){
		if(typeof layer != 'undefined' && ! moreReady){
			clearInterval(loadi);
			layer.load();
		}
	},20);
	var loadci = setInterval(function(){
		if(moreReady){
			clearInterval(loadci);
			layer.closeAll('loading');
		}
	},1000);
	$.post(weburl + "/index.php?m=chat&c=prepare", {
		'toid': toid,
		'totype': totype
	}, function(data) {
		if (data) {
			var res = eval('(' + data + ')');
			if (res.joblist) {
				joblist = res.joblist;
			}
			if (res.expect) {
				expect = res.expect;
			}
			prepareHtml();
			// 渲染聊天记录
			moreChat();
		}
	});
}
function prepareHtml(){
	var html = '',
		list = [];
	if (joblist) {
		
		for (var i in joblist) {
			list.push(i);
			html += '<div class="chatjob_list">';
			html += '<div class="chatjob_name">' + joblist[i].name + '</div>';
			html += '<div class="chatjob_xz">' + joblist[i].job_salary + '</div>';
			html += '<div class="chatjob_info">' + joblist[i].job_city_one;
			if (joblist[i].job_city_two) {
				html += '-' + joblist[i].job_city_two;
			}
			if (joblist[i].job_exp) {
				html += '<span class="chatjob_info_line">|</span>' + joblist[i].job_exp + '经验';
			}
			if (joblist[i].job_edu) {
				html += '<span class="chatjob_info_line">|</span>' + joblist[i].job_edu + '学历';
			}
			html += '</div>';
			html += '<span class="chatjob_bth" data-jobid="' + joblist[i].id + '" onclick="jobShow(this)">发送</span></div>';
		}
		if (list.length == 0) {
			html = '<div class="chat_nojob">~ 亲 , 暂无可选职位哦！</div>';
		}
		$('#chatjob_list').html(html);
	} else {
		html = '<div class="chat_nojob">~ 亲 , 暂无可选职位哦！</div>';
		$('#chatjob_list').html(html);
	}
	if (expect) {
		
		if ($('#content_expect')) {
			var ehtml = '';
			ehtml += '<span class="chat_box_right_gtjob_xz">' + expect.salary + '</span><span class="chat_line">|</span>' + expect.city_classname +
				'<span class="chat_line">|</span>' + expect.exp_n;
			ehtml += '<span class="chat_line">|</span>' + expect.edu_n + '<a href="' + expect.weburl +
				'" target="_blank" class="chat_box_right_gtjob_name">查看简历</a>';
			$('#content_expect').html(ehtml);
		}

		$('#eid').val(expect.id);
	}
}
// 发送消息
function send() {
	var content = document.getElementById('send_content');
	if (content.value != '') {
		// 发送聊天
		if (toid != '') {
			sendMessage(content.value, 'char', '');
			content.value = '';
			checkSend();
		} else {
			layer.msg('请选择' + chat_name + '对象', 2, 8);
		}
	}
}
// 更新聊天列表的聊天内容
function setChatDesc(msg){
	if (msg.ftype == '1') {
		var content = msg.content;
		if (msg.msgtype == 'char') {
			if (content.indexOf('[img') > -1) {
				content = '图片消息';
			}else if (content.indexOf('face[') > -1) {
				content = '表情消息';
			}
		} else if (msg.msgtype == 'voice') {
			if (content.indexOf('[voice') > -1) {
				content = '语音消息';
			}
		} else if (msg.msgtype == 'ask') {
			content = '请求互换联系方式';
		} else if (msg.msgtype == 'confirm' || msg.msgtype == 'refuse') {
			content = '互换联系方式消息';
		} else if (msg.msgtype == 'job') {
				content = '职位消息';
		} else if (msg.msgtype == 'resume') {
			content = '简历消息';
		} else if (msg.msgtype == 'change') {
			content = '面试消息';
		} else if (msg.msgtype == 'map') {
			content = '[位置]';
		}
		$('#chat_desc_' + msg.id).html(content);
		return content;
	}
}
function getMessage(msg) {
	if (msg.id && msg.totype == mine.usertype) {

		var setArr = ['char', 'job', 'resume', 'invite', 'ask', 'confirm', 'refuse', 'spview'];
		
		if(setArr.indexOf(msg.msgtype) != -1 && typeof chatStorage[msg.id]!='undefined' && chatStorage[msg.id]){
			chatStorage[msg.id].history.unshift(msg);
		}

		if (toid != '' && msg.id == toid) {
			if(msg.msgtype == 'adminjob'){
				getAdminjob(msg);
			}else{
				chatRender(msg, 'get');
				
				setRead(msg);
			}
			setChatDesc(msg);
		} else {
			// 聊天列表处理接收信息
			if ($('#chatList').length > 0) {
				if ($('#chat_' + msg.id).length > 0) {
					var msg_new = $('#chat_' + msg.id).find('.chat_box_usermsg');
					if (msg_new.text() == '') {
						$('#chat_' + msg.id).find('.chat_box_usermsg').text(1);
						$('#chat_' + msg.id).find('.chat_box_usertime').text(timeFormat(msg.timestamp));
					} else if (parseInt(msg_new.text()) > 0) {
						var num = parseInt(msg_new.text()) + 1;
						$('#chat_' + msg.id).find('.chat_box_usermsg').text(num);
						$('#chat_' + msg.id).find('.chat_box_usertime').text(timeFormat(msg.timestamp));
					}
					setChatDesc(msg);
				} else {

					$.post(weburl + "/index.php?m=chat&c=getSingleChatOnlineData", {
						'toid': msg.id,
						'totype': msg.ftype,
					}, function(res) {
						
						chatStorage[msg.id] = res;
						if(chatStorage[msg.id].history.length==0){
							chatStorage[msg.id].history.unshift(msg);
						}
						if ($('#chat_' + msg.id).length > 0) {
							// 防止发速度快，导致有重复数据，需要重新判断
							var msg_new = $('#chat_' + msg.id).find('.chat_box_usermsg');
							if (msg_new.text() == '') {
								$('#chat_' + msg.id).find('.chat_box_usermsg').text(1);
								$('#chat_' + msg.id).find('.chat_box_usertime').text(timeFormat(msg.timestamp));
							} else if (parseInt(msg_new.text()) > 0) {
								var num = parseInt(msg_new.text()) + 1;
								$('#chat_' + msg.id).find('.chat_box_usermsg').text(num);
								$('#chat_' + msg.id).find('.chat_box_usertime').text(timeFormat(msg.timestamp));
							}
							setChatDesc(msg);
						}else{
							var html = '';
							html += '<li id="chat_' + msg.id + '" onclick="toChat(' + msg.id + ',' + msg.ftype + ',' + msg.totype + ')">';
							html += '<div class="chat_box_userpic"><img src="' + msg.avatar +
								'" width="40" height="40"><i id="unread_'+msg.id+'" class="chat_box_usermsg">1</i></div>';
							html += '<div class="chat_box_userinfo"><div class="chat_box_username">' + msg.linkman +
								'<span class="chat_box_userzw">';
							
							if (msg.ftype == '1') {
								html += '求职者';
							} else {
								html += '招聘者';
							}
							html += '</span></div>';
							html += '<div id="chat_desc_'+ msg.id +'" class="chat_box_userp">';
							if (msg.ftype == '1') {
								var content = setChatDesc(msg);;
								html += content;
							} else {
								html += msg.username;
							}
							html += '</div><span class="chat_box_usertime">' + msg.timefromat + '</span></div></li>';
							$('#chatList').prepend(html);
						}
					},'json');

				}
			}
			if ($('#memberNoChat').length > 0) {
				if ($('#memberHaveChat').hasClass('none')) {
					$('#memberNoChat').addClass('none');
					$('#memberHaveChat').removeClass('none');
					$('#memberChatNum').text(1);
					
				} else {
					var num = $('#memberChatNum').text();
					if (parseInt(num) > 0) {
						$('#memberChatNum').text(parseInt(num) + 1);

					}
				}
			}
		}
		newChatMsg = true;
		if (document[hiddenProperty]) {
			var titAn = true;
			if (titledsq) {
				clearInterval(titledsq);
			}
			titledsq = setInterval(function() {
				if (titAn) {
					document.title = '【新消息】';
					titAn = false;
				} else {
					document.title = $('#zwf').text();
					titAn = true;
				}
			}, 1000);
		}
	}
}
// 由简历/职位详情页进入,发预定消息
function prepare(thischatStorage) {
	
	var pdata = {};
	
	if (jid != '' && joblist && joblist[jid] && jobShowed) {
		var html = '<li class="chat_li"><div class="chat_yx_job" data-wapurl="' + joblist[jid].weburl +
			'" onclick="toShow(this)">';
		html += '<span><div class="chat_yx_job_name">' + joblist[jid].name + '</div>';
		html += '<span class="chat_yx_xz">' + joblist[jid].job_salary + '</span>';
		html += '<div class="chat_yx_com_name">' + joblist[jid].com_name + '</div>';
		html += '<div class="">' + joblist[jid].job_city_one;
		if (joblist[jid].job_city_two) {
			html += '-' + joblist[jid].job_city_two;
		}
		if (joblist[jid].job_exp) {
			html += ' . ' + joblist[jid].job_exp + '经验';
		}
		if (joblist[jid].job_edu) {
			html += ' . ' + joblist[jid].job_edu + '学历';
		}
		html += '</div>';
		html += '<div class="chat_yx_time">' + timeFormat() + ' 由你发起的沟通</div></span></div></li>';
		// 发送消息
		setTimeout(function() {
			sendMessage(html, 'job', jid);
		}, 500);
		setTimeout(function() {
			var send = greeting != '' ? greeting : '你好，可以聊聊吗？这个职位我很感兴趣，希望进一步了解';
			sendMessage(send, 'char', '');
		}, 800);
	}

	if(mine.usertype != 1 && thischatStorage && thischatStorage.history && thischatStorage.history.length==0){
		// 没有聊天记录，非个人用户向个人用户打招呼
		var send = greeting != '' ? greeting : '你好，可以聊聊吗？';
		setTimeout(function() {
			sendMessage(send, 'char', '');
		}, 800);
	}
}

function sendExpcet() {
	if (expect) {
		var html = '<li class="chat_li"><div class="chat_userresume" data-wapurl="' + expect.weburl +
			'" onclick="toShow(this)">';
		html += '<span><div class="chat_userresume_name">' + expect.uname + ' <span class="chat_userresume_ys">' + expect.sex_n +
			',' + expect.age + '岁</span></div>';
		html += '<div class="chat_userresume_info">' + expect.exp_n + ' . ' + expect.edu_n + ' </div>';
		html += '<div class="chat_userresume_want">期望职位 <span class="chat_userresume_wantjob">' + expect.name +
			'</span> </div>';
		html += '<div class="chat_userresume_pic"><img src=" ' + expect.photo + ' "></div></span></div></li>';
		// 发送消息内容
		sendMessage(html, 'resume', expect.id);
	} else {
		var i = layer.confirm('您还没有可以投递的简历', {
				btn: ['前往发布', '取消']
			},
			function() {
				window.location.href = weburl + '/member/index.php?c=expect&act=add';
				return false;
			},
			function() {
				layer.close(i);
			}
		);
	}
}

function toShow(obj) {
	var url = obj.getAttribute('data-wapurl');
	if (url && url != '') {
		window.open(url);
	}
}

function sendInvite(id) {
	var html = '<li class="chat_li"><div class="chat_sendcont">';
	html += '<div class="chat_sendcont_pic"><img src="' + mine.avatar + '"></div>';
	html +=
		'<span class="chat_sendcont_p"><em class="chat_sendcont_yqbox">发送了面试邀请<i class="chat_sendcont_yq"></i></em></span></div></li>';
	// 发送消息
	sendMessage(html, 'invite', id);
}
// 展示邀请详情
function inviteShow(obj) {
	var id = obj.getAttribute('data-inviteid');
	if (id && id != '') {
		if (mine.usertype == 1) {
			var url = weburl + '/member/index.php?index.php?c=invite';
		} else {
			var url = weburl + '/member/index.php?index.php?c=invite';
		}
		location.href = url;
	}
}

function sendJob() {
	prepareHtml();
	$('#joblist').removeClass('none');
}

function jobShow(obj) {
	var id = obj.getAttribute('data-jobid');
	$('#joblist').addClass('none');
	if (jid != id && jid > 0) {
		if (mine.usertype == 1) {
			var change = '您更换了与招聘者沟通的职位';
		} else {
			var change = '您更换了与求职者沟通的职位';
		}
		// 发送消息
		sendMessage(change, 'change', '');
	}

	var jobhtml = '<li class="chat_li"><div class="chat_yx_job" data-wapurl="' + joblist[id].weburl +
		'" onclick="toShow(this)">';
	jobhtml += '<span><div class="chat_yx_job_name">' + joblist[id].name + '</div>';
	jobhtml += '<span class="chat_yx_xz">' + joblist[id].job_salary + '</span>';
	jobhtml += '<div class="chat_yx_com_name">' + joblist[id].com_name + '</div>';
	jobhtml += '<div class="">' + joblist[id].job_city_one;
	if (joblist[id].job_city_two) {
		jobhtml += '-' + joblist[id].job_city_two;
	}
	if (joblist[id].job_exp) {
		jobhtml += ' . ' + joblist[id].job_exp + '经验';
	}
	if (joblist[id].job_edu) {
		jobhtml += ' . ' + joblist[id].job_edu + '学历';
	}
	jobhtml += '</div>';
	if (jid != id && jid > 0) {
		jobhtml += '<div class="chat_yx_time">' + timeFormat() + ' 由你发起的沟通</div></span></div></li>';
	}
	// 发送消息
	sendMessage(jobhtml, 'job', id);
	// 设置当前沟通职位
	jid = id;
}

function nochat() {
	layer.open({
		content: '设定不感兴趣将会删除与TA的' + chat_name + '记录，并将TA加入' + chat_name + '黑名单，确定继续？',
		btn: ['确定', '取消'],
		yes: function(index) {
			layer.close(index);
			loadlayer();
			$.post(weburl + "/index.php?m=chat&c=delChatLog", {
				to: toid,
				type: totype
			}, function(res) {
				layer.closeAll('loading');
				if (res.errmsg) {
					layer.msg(res.errmsg, 2, 8, function() {
						location.href = weburl;
					});
				} else {
					window.location.href = weburl + '/member/index.php?c=chat';
				}
			},'json');
		}
	});
}
// 发送消息
function sendMessage(content, type, id) {

	var time = new Date().getTime();

	if (socket && socket.readyState == 1 && canSend){
		// 根据消息类型区分保存内容
		if (type == 'job') {
			var msgcontent = 'jobid=' + id;
			showChatJob(id);
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
			timestamp: time,
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
		};
		var message = {
			type: 'chatMessage',
			data: {
				content: sendData
			}
		};
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
				nowtype: sendData.mine.ftype
			};

			$.post(weburl + "/index.php?m=chat&c=chatLog", pdata, function(data) {
				if (data) {
					var res = eval('(' + data + ')');
					if (res.error != 0) {
						if (res.error == 4) {
							$('#chatid').val(id);
							server_single('chat');
							firstTab();
							var msglayer = layer.open({
								type: 1,
								title: chat_name,
								closeBtn: 1,
								border: [10, 0.3, '#000', true],
								area: ['810px', 'auto'],
								content: $("#tcmsg"),
								cancel: function() {
									window.location.reload();
								}
							});
							return false;
						}else if (res.error == 3) {
							layer.msg(res.errmsg, 2, 8);
						} else if (res.errmsg) {
							layer.msg(res.errmsg, 2, 8, function() {
								location.href = weburl;
								return;
							});
						}
					} else {
						message.data.content.mine.chatid = res.chatid;
						socket.send(JSON.stringify(message));
						// 渲染消息内容
						mineData.chatid = res.chatid;
						// 渲染消息内容
						mineData.htmlcontent = content;

						if(typeof chatStorage[toid]!='undifined' && chatStorage[toid]){
							chatStorage[toid].history.unshift(mineData);
						}

						var html = chatRender(mineData, 'send');
					}
				}
			});
		} else {
			socket.send(JSON.stringify(message));
			// 渲染消息内容
			mineData.htmlcontent = content;
			var html = chatRender(mineData, 'send');
		}
		// 消息时间间隔超60秒，显示新时间
		if (sendData.mine.timestamp - sendTime > 60 * 1000) {
			$("#chat_content").find('ul').append('<li class="chat_li"><div class="chat_sendtime"><span class="chat_sendtime_b">' + timeFormat(sendData.mine.timestamp) +
				'</span></div></li>');
			sendTime = sendData.mine.timestamp;
		}
	} else {
		layer.msg(chat_name + '功能加载中', 2, 8);
	}
}
// 渲染消息内容
function chatRender(msg, type) {
	if (type == 'send') {
		// 发送
		if (msg.msgtype == 'char') {
			var content = rexContent(msg.htmlcontent, msg.msgtype,msg);
			// 我说
			var html = '<li class="chat_li"><div class="chat_sendcont">';
			html += '<div class="chat_sendcont_pic"><img src="' + msg.avatar + '"></div>';
			html += '<span class="chat_sendcont_p">' + content + '</span></div></li>';
		} else if (msg.msgtype == 'change') {
			var html = '<li class="chat_li"><div class="chat_comjobtip"><span class="chat_comjobtip_p">' + msg.htmlcontent +
				'</span></div></li>';
		} else if (msg.msgtype == 'ask') {
			if (msg.content.indexOf('ask') != -1) {
				var askid = msg.content.replace('ask=', '');
				var html = getAskHtml(askid, msg);
			}
		} else if (msg.msgtype == 'confirm') {
			if (msg.content.indexOf('confirm') != -1) {

				var confirmid = msg.content.replace('confirm=', '');
				var askvalue = '';
				huhuanStatus(confirmid, 1);
				if (confirmid == 'wx') {
					askvalue = towx;
				} else if (confirmid == 'tel') {
					askvalue = totel;
				}
				var html = confirmAskHtml(askvalue, confirmid, msg);


			}
		} else if (msg.msgtype == 'refuse') {
			if (msg.content.indexOf('refuse') != -1) {
				var refuseid = msg.content.replace('refuse=', '');
				huhuanStatus(refuseid, 2);
				var html = getRefuseHtml(refuseid, msg);

			}
		} else {
			var html = msg.htmlcontent;
		}
	} else {
		// 接收
		if (msg.msgtype == 'char' || msg.msgtype == 'voice') {
			msg.content = rexContent(msg.content, msg.msgtype,msg);
			// 他说
			var html = '<li class="chat_li"><div class="chat_other_say">';
			html += '<div class="chat_other_pic"><img src="' + msg.avatar + '"></div>';
			html += '<span class="chat_sendcont_p2">' + msg.content + '</span></div></li>';
		} else if (msg.msgtype == 'ask') {
			if (msg.content.indexOf('ask') != -1) {
				var askid = msg.content.replace('ask=', '');
				var html = getAskHtml(askid, msg);
			}
		} else if (msg.msgtype == 'confirm') {
			if (msg.content.indexOf('confirm') != -1) {
				var confirmid = msg.content.replace('confirm=', '');

				huhuanStatus(confirmid, '1');
				var html = confirmAskHtml(msg.confirmcon, confirmid, msg);
			}
		} else if (msg.msgtype == 'refuse') {
			if (msg.content.indexOf('refuse') != -1) {
				var refuseid = msg.content.replace('refuse=', '');
				huhuanStatus(refuseid, '2');
				var html = getRefuseHtml(refuseid, msg);

			}
		} else if (msg.msgtype == 'job') {
			if (msg.content.indexOf('jobid') != -1) {
				var jobid = msg.content.replace('jobid=', '');
				var html = getJobHtml(joblist[jobid]);
			}
		} else if (msg.msgtype == 'resume') {
			if (msg.content.indexOf('eid') != -1) {
				var eid = msg.content.replace('eid=', '');
				var html = getResumeHtml(eid);
			}
		} else if (msg.msgtype == 'change') {
			if (msg.ftype == 1) {
				var change = '求职者更换了与您沟通的职位';
			} else {
				var change = '招聘者更换了与您沟通的职位';
			}
			var html = '<li class="chat_li"><div class="chat_comjobtip"><span class="chat_comjobtip_p">' + change +
				'</span></div></li>';
		} else if (msg.msgtype == 'invite') {
			if (msg.content.indexOf('inviteid') != -1) {
				var inviteid = msg.content.replace('inviteid=', '');
				var html = '<li class="chat_li"><div class="chat_other_say" data-inviteid="' + inviteid +
					'" onclick="inviteShow(this)">';
				html += '<div class="chat_other_pic"><img src="' + msg.avatar + '"></div>';
				html +=
					'<span class="chat_sendcont_p2"><em class="chat_sendcont_jsbox">发送了面试邀请<i class="chat_sendcont_jsyq"></i></em></span></div></li>';
			}
		} else if (msg.msgtype == 'spview') {
			if (msg.mine) {
				var html = '<li class="chat_li"><div class="chat_sendcont">';
				html += '<div class="chat_sendcont_pic"><img src="' + msg.avatar + '"></div>';
				html += '<div class="chat_sendcont_p">';
				if (msg.content == 'closesp') {
					var fuser = msg.fusertype != mine.usertype ? '对方' : '';
					html += '<div class="spqxboxtwo"><i class="spqx2"></i>'+ fuser +'已取消</div>';
				}else if (msg.content == 'refused') {
					var fuser = msg.fusertype == mine.usertype ? '对方' : '';
					html += '<div class="spqxboxtwo"><i class="spqx2"></i>'+ fuser +'已拒绝</div>';
				}else{
					html += '<div class="spqxboxtwo"><i class="spqx2"></i>'+ msg.content +'</div>';
				}
				html += '</div></div></li>';
			} else {
				var html = '<li class="chat_li"><div class="chat_other_say">';
				html += '<div class="chat_other_pic"><img src="' + msg.avatar + '"></div>';
				html += '<div class="chat_sendcont_p2">';
				if (msg.content == 'closesp') {
					var fuser = msg.fusertype != mine.usertype ? '对方' : '';
					html += '<div class="spqxbox"><i class="spqx"></i>'+ fuser +'已取消</div>';
				}else if (msg.content == 'refused') {
					var fuser = msg.fusertype == mine.usertype ? '对方' : '';
					html += '<div class="spqxbox"><i class="spqx"></i>'+ fuser +'已拒绝</div>';
				}else{
					html += '<div class="spqxbox"><i class="spqx"></i>'+ msg.content +'</div>';
				}
				html += '</div></div></li>';
			}
		}else if (msg.msgtype == 'read'){
			return
		}else if (msg.msgtype == 'map'){
			let map = msg.content .split('|');
			var staticmap = '';
			if(map.length == 4){
				staticmap = map[1];
			}
			if(staticmap!=''){
				msg.content = '<img class="chat_photos" src="' + staticmap + '">';

				if (msg.mine) {
					// 我说
					var html = '<li class="chat_li"><div class="chat_sendcont">';
					html += '<div class="chat_sendcont_pic"><img src="' + msg.avatar + '"></div>';
					html += '<span class="chat_sendcont_p">' + msg.content + '</span></div></li>';
				} else {
					
					// 他说
					var html = '<li class="chat_li"><div class="chat_other_say">';
					html += '<div class="chat_other_pic"><img src="' + msg.avatar + '"></div>';
					html += '<span class="chat_sendcont_p2">' + msg.content + '</span></div></li>';
				}
			}
		} else {
			var html = msg.content;
		}
		// 消息时间间隔超60秒，显示新时间
		if (msg.timestamp - sendTime > 60 * 1000) {
			$("#chat_content").find('ul').append('<div class="chat_sendtime"><span class="chat_sendtime_b">' + timeFormat(msg.timestamp) + '</span></div>');
			sendTime = msg.timestamp;
		}
	}
	$("#chat_content").find('ul').append(html);
	picviewjs();
	var scroll = document.getElementById('chat_content').scrollHeight;
	chatScrollTo(scroll);
	// 图片类型加载较慢，滚动到底部需要时间
	if ($("#chat_content").find('ul').last().find('img')) {
		// 上面滚动过之后，新的高度
		lastscroll = document.getElementById('chat_content').scrollHeight;
		var timer = setInterval(function() {
			var imgscroll = document.getElementById('chat_content').scrollHeight;
			if (imgscroll > lastscroll) {
				chatScrollTo(imgscroll);
				clearInterval(timer);
				timer = null;
			}
		}, 200);
		setTimeout(function() {
			if (timer) {
				clearInterval(timer);
			}
		}, 2000);
	}
	return html;
}

function getJobHtml(job, msg) {
	var html = '';

	if (job) {
		html = '<li class="chat_li"><div class="chat_yx_job"  data-wapurl="' + job.weburl +
			'" onclick="toShow(this)">';
		html += '<span><div class="chat_yx_job_name">' + job.name + '</div>';
		html += '<span class="chat_yx_xz">' + job.job_salary + '</span>';
		html += '<div class="chat_yx_com_name">' + job.com_name + '</div>';
		html += '<div class="">' + job.job_city_one;
		if (job.job_city_two) {
			html += '-' + job.job_city_two;
		}
		if (job.job_exp) {
			html += ' . ' + job.job_exp + '经验';
		}
		if (job.job_edu) {
			html += ' . ' + job.job_edu + '学历';
		}
		html += '</div>';
		if (msg && msg.newjob) {
			var msgtime = parseInt(msg.msgtime);
			var gtuser;
			if (msg.newjob == 1) {
				gtuser = '你';
			} else {
				if (msg.fusertype == 1) {
					if (mine.usertype == 1) {
						gtuser = '你';
					} else {
						gtuser = '招聘者';
					}
				} else {
					if (mine.usertype == 1) {
						gtuser = '求职者';
					} else {
						gtuser = '你';
					}
				}
			}
			html += '<div class="chat_yx_time">' + timeFormat(msgtime) + ' 由' + gtuser + '发起的沟通</div></span></div></li>';
		}
		html += '</li>';
	}
	return html;
}

function getResumeHtml(eid) {
	var html = '';
	if (expect) {
		html = '<li class="chat_li"><div class="chat_userresume" data-wapurl="' + expect.weburl + '" onclick="toShow(this)">';
		html += '<span><div class="chat_userresume_name">' + expect.uname + ' <span class="chat_userresume_ys">' + expect.sex_n +
			',' + expect.age + '岁</span></div>';
		html += '<div class="chat_userresume_info">' + expect.exp_n + ' . ' + expect.edu_n + ' </div>';
		html += '<div class="chat_userresume_want">期望职位 <span class="chat_userresume_wantjob">' + expect.name +
			'</span> </div>';
		html += '<div class="chat_userresume_pic"><img src=" ' + expect.photo + ' "></div></span></div></li>';
	}
	return html;
}
// 转义内容
function rexContent(content, msgtype,msg) {
	if (msgtype == 'voice') {
		content = (content || '').replace(/&(?!#?[a-zA-Z0-9]+;)/g, '&amp;')
			.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/'/g, '&#39;').replace(/"/g, '&quot;') //XSS

			.replace(/voice\[([^\s]+?)\]/g, function(voice) { //转义图片

				var voiceurl = voice.replace(/(^voice\[)|(\]$)/g, '');

				var voicehtml = getVoiceHtml(voiceurl, msg);
				var voicestatus = 0;
				var html = '';
				html += '<div onclick="playVoice(this)" data-id="' + msg.chatid + '" data-voice="' + voiceurl + '">';

				if (msg.mine) { //右侧
					html += '	<div class="yuyinboxright"><i id="onplay_' + msg.chatid + '" class="yuyinbox_wt"></i>' + msg.voicelength +
						'</div>';
				} else { //左侧
					html += '	<div class="yuyinbox"><i id="onplay_' + msg.chatid + '" class="yuyinbox_wt"></i>' + msg.voicelength +
						'</div>';
				}
				html += '	<div>' + voicehtml.innerHTML + '</div>';

				if (!msg.mine && msg.voicestatus != 1) { //未读消息红点
					html += '	<div id="unlisten_' + msg.chatid + '" class="xxwd"></div>';
					voicestatus = 0;
				} else {
					voicestatus = 1;
				}
				html += '<input id="voicestatus_' + msg.chatid + '" type="hidden" value="' + voicestatus + '" />';
				html += '</div>';

				return html;
			})
	} else {
		content = (content || '').replace(/&(?!#?[a-zA-Z0-9]+;)/g, '&amp;')
			.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/'/g, '&#39;').replace(/"/g, '&quot;') //XSS
			.replace(/img\[([^\s]+?)\]/g, function(img) { //转义图片
				return '<img class="chat_photos" src="' + img.replace(/(^img\[)|(\]$)/g, '') + '">';
			})
			.replace(/face\[([^\s\[\]]+?)\]/g, function(face) { //转义表情
				var alt = face.replace(/^face/g, '');
				return '<img alt="' + alt + '" class="chat_bq_img" title="' + alt + '" src="' + faces([alt]) + '">';
			})
	}
	return content;
}

function upImage(obj) {
	layer.load();
	$('#imgform').submit();
	var iframe = $('#chat_iframe'),
		timer = setInterval(function() {
			var res;
			try {
				res = iframe.contents().find('body').text();
			} catch (e) {
				layer.closeAll('loading');
				clearInterval(timer);
				timer = null;
			}
			if (res) {
				layer.closeAll('loading');
				clearInterval(timer);
				timer = null;
				iframe.contents().find('body').html('');
				try {
					res = JSON.parse(res);
				} catch (e) {
					res = {};
				}
				if (res.msg) {
					layer.msg(res.msg, 2, 8);
				} else {
					focusInsert(document.getElementById("send_content"), 'img[' + (res.data.url || '') + ']', true);
					send();
				}
			}
		}, 30);
	obj.value = '';
}

function timeFormat(nowtime) {
	if (nowtime) {
		nowtime = new Date(nowtime);
	} else {
		nowtime = new Date();
	}
	var month = nowtime.getMonth(),
		day = nowtime.getDate(),
		hour = nowtime.getHours(),
		minutes = nowtime.getMinutes();
	month = month + 1;
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
// 页面滚动
function chatScrollTo(ypos) {
	var clientHeight = document.getElementById('chat_box').clientHeight;;
	if (ypos > clientHeight) {
		// 兼容各种浏览器
		document.getElementById('chat_box').scrollTop = ypos;
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

function moreChat() {
	$.ajax({
		type: "post",
		url: weburl + "/index.php?m=chat&c=getChatPage",
		async: false,
		data: {
			'id': toid,
			'totype': totype,
			'page': chatpage,
			'lastid': lastid
		},
		dataType: "json",
		success: function(res) {
			layer.closeAll('loading');
			if (res) {
				if(res.msg){
					return layer.msg(res.msg, 2, 8, function(){
						window.location.href = weburl + '/member/';
					});
				}
				chatpage = chatpage + 1;
				var scroll = null;
				if (chatpage > 2) {
					// 第二页开始，记录前一次滚动距离
					scroll = document.getElementById('chat_content').scrollHeight;
				}

				$('#chat_more').remove();
				if (res.code == 0) {
					if(res.adminjob){
						adminjob = res.adminjob;
					}
					var chatlog = res.data;
					if (chatlog.length > 0) {
						pastSend = chatlog[0].sendTime;
						for (var i in chatlog) {
							if(chatStorage[toid]){
								chatStorage[toid].history.push(chatlog[i]);
							}

							renderPast(chatlog[i]);
							// 最后一条时，如还有历史消息，增加更多消息
							if (i == chatlog.length - 1 && res.ismore) {
								$("#chat_content").find('ul').prepend(
									'<li id="chat_more" class="chat_more" onclick="moreChat()"><div class="chat_comjobtip"><span class="chat_comjobtip_p">查看更多消息</span></div></li>'
								);
								lastid = chatlog[i]['id'];
							}
							if (scroll) {
								// 渲染后，滚动到上一页的距离
								var newScroll = document.getElementById('chat_content').scrollHeight;
								chatScrollTo(newScroll - scroll);
							}
						}
					}
				}
				prepare();
				moreReady = true;
				
			}
		}
	});
}
function isArray (arr) {
    return Object.prototype.toString.call(arr) === '[object Array]';
}

// 深度克隆
function deepClone (obj) {
	// 对常见的“非”值，直接返回原来值
	if(!obj || typeof(obj) == 'undefined' || isNaN(obj)) return obj;
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
function chathistoryHtml(thischatStorage){
	
	if(thischatStorage.history && thischatStorage.history.length>0){
		chatpage = chatpage + 1;
		$('#chat_more').remove();
		
		var chatlog = thischatStorage.history;
		
		if (chatlog.length > 0) {
			pastSend = chatlog[0].sendTime;
			for (var i in chatlog) {
				renderPast(chatlog[i]) 
				// 最后一条时，如还有历史消息，增加更多消息
				if (i == chatlog.length - 1) {
					$("#chat_content").find('ul').prepend(
						'<li id="chat_more" class="chat_more" onclick="moreChat()"><div class="chat_comjobtip"><span class="chat_comjobtip_p">查看更多消息</span></div></li>'
					);
					lastid = chatlog[i]['id'];
				}
			}
		}
		
		moreReady = true;
	}
	prepare(thischatStorage);
}
// 渲染历史消息
function renderPast(msg) {

	// 接收
	if (msg.msgtype == 'char' || msg.msgtype == 'voice') {
		msg.content = rexContent(msg.content, msg.msgtype,msg);
		if (msg.mine) {
			// 我说
			var html = '<li class="chat_li"><div class="chat_sendcont">';
			html += '<div class="chat_sendcont_pic"><img src="' + msg.avatar + '"></div>';
			html += '<span class="chat_sendcont_p">' + msg.content + '</span></div></li>';
		} else {
			
			// 他说
			var html = '<li class="chat_li"><div class="chat_other_say">';
			html += '<div class="chat_other_pic"><img src="' + msg.avatar + '"></div>';
			html += '<span class="chat_sendcont_p2">' + msg.content + '</span></div></li>';
		}
	} else if (msg.msgtype == 'ask') {
		if (msg.content.indexOf('ask') != -1) {
			var askid = msg.content.replace('ask=', '');
			var html = getAskHtml(askid, msg);
		}

	} else if (msg.msgtype == 'confirm') {
		if (msg.content.indexOf('confirm') != -1) {
			var confirmid = msg.content.replace('confirm=', '');

			var html = confirmAskHtml(msg.confirmcon, confirmid, msg);
		}

	} else if (msg.msgtype == 'refuse') {
		if (msg.content.indexOf('refuse') != -1) {
			var refuseid = msg.content.replace('refuse=', '');
			var html = getRefuseHtml(refuseid, msg);

		}
	} else if (msg.msgtype == 'job') {
		if (msg.content.indexOf('jobid') != -1) {
			var jobid = msg.content.replace('jobid=', '');
			
			var html = getJobHtml(joblist[jobid], msg);

			if (jid == '') {
				showChatJob(jobid);
			}
			jid = jobid;
			jobShowed = false;
		}
	}else if (msg.msgtype == 'adminjob'){
		if(msg.content.indexOf('jobid') != -1){
			var jobid = msg.content.replace('jobid=', '');
			
			var html = getJobHtml(adminjob[jobid], msg);
			
			if (jid == '') {
				showChatJob(jobid);
			}
			jid = jobid;
			jobShowed = false;
		}
	} else if (msg.msgtype == 'resume') {
		if (msg.content.indexOf('eid') != -1) {
			var eid = msg.content.replace('eid=', '');
			var html = getResumeHtml(eid);
		}
	} else if (msg.msgtype == 'change') {
		if (mine.usertype == 1) {
			var change = '求职者更换了与您沟通的职位';
		} else {
			var change = '招聘者更换了与您沟通的职位';
		}
		var html = '<li class="chat_li"><div class="chat_comjobtip"><span class="chat_comjobtip_p">' + change +
			'</span></div></li>';
	} else if (msg.msgtype == 'invite') {
		if (msg.content.indexOf('inviteid') != -1) {
			var qyid = msg.content.replace('inviteid=', '');
			if (msg.mine) {
				var html = '<li class="chat_li"><div class="chat_sendcont">';
				html += '<div class="chat_sendcont_pic"><img src="' + mine.avatar + '"></div>';
				html +=
					'<span class="chat_sendcont_p"><em class="chat_sendcont_yqbox">发送了面试邀请<i class="chat_sendcont_yq"></i></em></span></div></li>';
			} else {
				var html = '<li class="chat_li"><div class="chat_other_say">';
				html += '<div class="chat_other_pic"><img src="' + msg.avatar + '"></div>';
				html +=
					'<span class="chat_sendcont_p2"><em class="chat_sendcont_jsbox">发送了面试邀请<i class="chat_sendcont_jsyq"></i></em></span></div></li>';
			}
			if (inviteid != '' && inviteid == qyid) {
				inviteid = '';
			}
		}
	} else if (msg.msgtype == 'spview') {
		if (msg.mine) {
			var html = '<li class="chat_li"><div class="chat_sendcont">';
			html += '<div class="chat_sendcont_pic"><img src="' + msg.avatar + '"></div>';
			html += '<div class="chat_sendcont_p">';
			if (msg.content == 'closesp') {
				var fuser = msg.fusertype != mine.usertype ? '对方' : '';
				html += '<div class="spqxboxtwo"><i class="spqx2"></i>'+ fuser +'已取消</div>';
			}else if (msg.content == 'refused') {
				var fuser = msg.fusertype == mine.usertype ? '对方' : '';
				html += '<div class="spqxboxtwo"><i class="spqx2"></i>'+ fuser +'已拒绝</div>';
			}else{
				html += '<div class="spqxboxtwo"><i class="spqx2"></i>'+ msg.content +'</div>';
			}
			html += '</div></div></li>';
		} else {
			var html = '<li class="chat_li"><div class="chat_other_say">';
			html += '<div class="chat_other_pic"><img src="' + msg.avatar + '"></div>';
			html += '<div class="chat_sendcont_p2">';
			if (msg.content == 'closesp') {
				var fuser = msg.fusertype != mine.usertype ? '对方' : '';
				html += '<div class="spqxbox"><i class="spqx"></i>'+ fuser +'已取消</div>';
			}else if (msg.content == 'refused') {
				var fuser = msg.fusertype == mine.usertype ? '对方' : '';
				html += '<div class="spqxbox"><i class="spqx"></i>'+ fuser +'已拒绝</div>';
			}else{
				html += '<div class="spqxbox"><i class="spqx"></i>'+ msg.content +'</div>';
			}
			html += '</div></div></li>';
		}
	} else if (msg.msgtype == 'map') {
		let map = msg.content .split('|');
		var staticmap = '';
		if(map.length == 4){
			staticmap = map[1];
		}
		if(staticmap!=''){
			msg.content = '<img class="chat_photos" src="' + staticmap + '">';

			if (msg.mine) {
				// 我说
				var html = '<li class="chat_li"><div class="chat_sendcont">';
				html += '<div class="chat_sendcont_pic"><img src="' + msg.avatar + '"></div>';
				html += '<span class="chat_sendcont_p">' + msg.content + '</span></div></li>';
			} else {
				
				// 他说
				var html = '<li class="chat_li"><div class="chat_other_say">';
				html += '<div class="chat_other_pic"><img src="' + msg.avatar + '"></div>';
				html += '<span class="chat_sendcont_p2">' + msg.content + '</span></div></li>';
			}
		}
	} else {
		var html = msg.content;
	}
	if(typeof html !== 'undefined'){
		$("#chat_content").find('ul').prepend(html);
		picviewjs();
		// 消息时间间隔超60秒，显示新时间
		if (pastSend - msg.sendTime > 60 * 1000) {
			$("#chat_content").find('ul').prepend('<li class="chat_li"><div class="chat_sendtime"><span class="chat_sendtime_b">' + timeFormat(parseInt(msg.sendTime)) +
				'</span></div></li>');
			pastSend = msg.sendTime;
		}
		if (chatpage == 2) {
			var scroll = document.getElementById('chat_content').scrollHeight;
			chatScrollTo(scroll);
			// 图片类型加载较慢，滚动到底部需要时间
			var timer_num = 0;
			var timer = setInterval(function() {
				timer_num++;
				var imgscroll = document.getElementById('chat_content').scrollHeight;
				chatScrollTo(imgscroll);
				if (timer_num > 20) {
					clearInterval(timer);
					timer = null;
				}
			}, 50);
		}
	}
}
//预览图片js点击监听初始化
function picviewjs(){
	$(".chat_photos").unbind("click");
	$('.chat_photos').click(function(){
		var url =	$(this).attr('src');
        var picjson={
		  "data": []
		}
        if(url){
            picjson.data.push({"src": url,"thumb": url});
        }
        
		layer.photos({
			photos: picjson
			,anim: 5 
		});
	})
}
function showChatJob(id) {
	var html = '';
	if ($('#content_job')) {
		if (joblist && joblist[id]) {
			html += '<span class="chat_box_right_gtjob_n">沟通职位</span><a href="' + joblist[id].weburl +
				'" target="_blank" class="chat_box_right_gtjob_name">' + joblist[id].name + '</a>';
			html += '<span class="chat_box_right_gtjob_xz">' + joblist[id].job_salary + '</span><span class="chat_line">|</span>' + joblist[id].job_city_one;

			if (joblist[id].job_city_two) {
				html += '-' + joblist[id].job_city_two;
			}
			$('#content_job').html(html);
		}
	}
}
// 对方未在线，发送提醒
function unSend(msg) {
	$.post(weburl + "/index.php?m=chat&c=unSend", {
		'nowtype': msg.ftype,
		'toid': msg.toid,
		'totype': msg.totype
	}, function() {});
}
/*
chatStorage数据结构
[
	20034:{
		toid:20034,
		totype:1,
		
		cantel:1,
		canwx:1,
		linkman:'',
		identity:'',
		
		expect:{},
		joblist:[{...}],
		history:[{...}]
	}
]
**/
function getChatLocalStorage(toid){

	var csto = deepClone(chatStorage);

	if(toid){
		return (typeof csto[toid]!='undefined'&&csto[toid]) ? csto[toid]:null;
	}else{
		return csto;
	}

}
function setChatLocalStorage(data){
	if(data){
		chatStorage = data;
	}
}
//切换后页面参数初始化
function initData(thischatStorage){

	
	if(thischatStorage.toid!=toid){

		

		jid = '';
		eid = '';
		totype = thischatStorage.totype;
		if(totype == 9){
			// 管理员
			toid = 'a' + thischatStorage.toid;
		}else{
			toid = thischatStorage.toid;
		}
		inviteid = '';
		
		towx = "";
		totel = "";
		cantel = thischatStorage.cantel;
		canwx = thischatStorage.canwx;
		inviteNum = thischatStorage.inviteNum;
		linkman = typeof thischatStorage.linkman!='undefined'?thischatStorage.linkman:'';
		identity = typeof thischatStorage.identity!='undefined'?thischatStorage.identity:'';

		
		lastid = '';
		sendTime = 0;
		pastSend = 0;
		chatpage = 1;
		jobShowed = false;
		comalljobnum  = 0;

		playMsgid = null;
		chatlistch = 0;
		mhpage = 0;
		mhdata = true;
		commentState = null;
		spconfirm = null;
		spint = null;
		zphnetSocketOnline = [];
		spviewBell = null;
	}
	

	if(mine.usertype=='1'){

		expect = chatMineStorage.expect?chatMineStorage.expect:null;

		if(totype=='9'){
			adminjob = thischatStorage.joblist?thischatStorage.joblist:{};
			singleHtml();
			prepareHtml();
			chathistoryHtml(thischatStorage);
			setRead();
		}else{
			joblist = thischatStorage.joblist?thischatStorage.joblist:[];

			comalljobnum  = thischatStorage.comalljobnum?thischatStorage.comalljobnum:0;
			//本地职位数量小于对方表里职位数量的，且本地职位数量小于50条的，请求出对方所有职位，并设置本地缓存
			var jobnum = Object.keys(joblist);

			if(jobnum.length<comalljobnum && jobnum.length<50){

				$.post(weburl + "/index.php?m=chat&c=getAjaxJobs", {
					toid: toid,
					totype:totype
				}, function(res) {
					
					if(res.joblist){
						joblist = res.joblist;
						chatStorage[toid].joblist = joblist;
						singleHtml();
						prepareHtml();
						chathistoryHtml(thischatStorage);
						setRead();
					}

				}, 'json');
			}else{
				singleHtml();
				prepareHtml();
				chathistoryHtml(thischatStorage);
				setRead();
			}
		}
		
	}else{
		

		expect = thischatStorage.expect?thischatStorage.expect:null;

		joblist = chatMineStorage.joblist?chatMineStorage.joblist:null;

		singleHtml();
		prepareHtml();
		chathistoryHtml(thischatStorage);
		setRead();
	}

	
	
}
function getAllChatOnlineData(toid){

	if (typeof toid !== 'undefined' && toid != '') {
		$('#chat_'+toid).show();
	}
	$('#chatlist_load').show();
	
	$.post(weburl + "/index.php?m=chat&c=getAllChatOnlineData", {
		rand: Math.random()
	}, function(res) {
		
		chatMineStorage = res.mine;

		setChatLocalStorage(res.toall);

		$('#chatlist_load').hide();
		$('.chatlistCtrl').removeClass('none');

		if ($('#chatList').length > 0) {
			boxElement = document.getElementById("chatList");

			boxElement.addEventListener('scroll', listScroll);

			// 获取滚动条滚动区域盒子的高度
			chatlistch = boxElement.clientHeight;
		}

		// 查询准备数据
		if (typeof toid !== 'undefined' && toid != '') {
			toChat(toid, totype, mine.usertype);
		}

	}, 'json');
}
function setRead(msg){
	var setArr = ['char', 'job', 'resume', 'invite', 'ask', 'confirm', 'refuse', 'spview','adminjob'];

	if (toid != '') {
		if(typeof msg!='undefined' && setArr.indexOf(msg.msgtype) == -1){
			return false;
		}
		// 收到消息处理
		setTimeout(function() {
			$.post(weburl + "/index.php?m=chat&c=setMsgStatus", {
				'id': toid,
				'type': totype,
				'nowid': mine.id,
				'nowtype': mine.usertype
			}, function(res) {
				if (typeof res.errmsg != 'undefined') {
					layer.msg(res.errmsg, 2, 8, function() {
						location.href = weburl;
						return;
					});
				}else if(typeof msg!='undefined'){
					if(msg.chatid){
						sendMessage('', 'read', msg.chatid);
					}
				}
			},'json');
		}, 500);
	}
}
/* 会员中心判断聊天权利*/
function toChat(id, type, nowtype) {
	
	var thischatStorage = getChatLocalStorage(id);
	if(thischatStorage && typeof thischatStorage.toid!='undefined' && thischatStorage.toid){
		initData(thischatStorage);
	}else{
		showSingle(id, type);
	}
}
// 展示聊天详情
function showSingle(id, type){
	
	layer.load();
	$.post("index.php?c=chat&act=single", {
		id: id,
		type: type
	}, function(res) {
		layer.closeAll('loading');
		var receive = res.receive;
		toid = receive.id;
		totype = receive.usertype;
		linkman = receive.linkman;
		identity = receive.identity;
		cantel = res.cantel;
		canwx = res.canwx;
		
		singleHtml();

		getPrepare();
		lastid = '';
		sendTime = 0;
		pastSend = 0;
		chatpage = 1;
		jobShowed = false;
		expect = null;
		joblist = null;
		playMsgid = null;
		chatlistch = 0;
	}, 'json');
}

function singleHtml(){

	$("#unread_" + toid).text('');
	var head = '';
	if(linkman){
		head += '<span class="chat_box_right_gtinfo_u">' + linkman + '</span>';
	}
	head += identity;
	
	if(totype == 9){
		// 管理员，隐藏发简历等操作栏
		$('#single_foot').hide();
	}else{
		$('#single_foot').show();
		if(totype == 1){
			head += '<div id="content_expect" class="chat_box_right_gtjob"></div>';
		}else{
			head += '<div id="content_job" class="chat_box_right_gtjob"></div>';
		}
	} 
	$('#single_head').html(head);
	
	var foot = '';
	if(cantel == 3){
		var telclass = 'chat_header_hdh_grey';
		var teltext = '请求电话中';
	}else{
		var telclass = 'chat_header_hdh';
		var teltext = '互换电话';
	}
	if(canwx == 3){
		var wxclass = 'chat_header_hwx_grey';
		var wxtext = '请求微信中';
	}else{
		var wxclass = 'chat_header_hwx';
		var wxtext = '互换微信';
	}
	if(sy_chat_exphone != 1){
		foot += '<span data-id="tel" class="chat_box_right_cz_a sendask">';
		foot += '<div id="header_hdh" class="' + telclass + '"><i class="header_czicon header_hdhicon"></i>';
		foot += '<div id="header_hdhtxt">' + teltext + '</div></div></span>';
		foot += '<span data-id="wx" class="chat_box_right_cz_a sendask">';
		foot += '<div id="header_hwx" class="' + wxclass + '"><i class="header_czicon header_hwxicon"></i>';
		foot += '<div id="header_hwxtxt">' + wxtext + '</div></div></span>';
	}
	if(mine.usertype == 2){
		if(sy_spview_web == 1){
			foot += '<span id="spview" class="chat_box_right_cz_a"><i class="header_czicon header_spmsicon"></i>视频面试</span>';
		}
		var yqtext = '';
		if(inviteNum>0){
			yqtext = '已邀请';
		}else{
			yqtext = '面试邀请';
		}
		foot += '<span id="inviteCheck" uid="'+ toid +'" class="chat_box_right_cz_a"><i class="header_czicon header_msicon"></i>'+yqtext+'</span>'
	}
	if(mine.usertype == 1){
		foot += '<span id="sendJob" class="chat_box_right_cz_a"><i class="header_czicon header_fbicon"></i>发职位</span>';
		foot += '<span id="sendExpcet" class="chat_box_right_cz_a"><i class="header_czicon header_msicon"></i>发简历</span>';
	}
	foot += '<span id="nochat" class="chat_box_right_cz_a"><i class="header_czicon header_bzhicon"></i>不感兴趣</span>';
	$('#single_foot').html(foot);
	$("#cbr_y").show();
	$("#cbr_n").hide();
	$("#chat_content").html('<ul></ul>');
	jsPrepare();
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
function playVoice(obj) {
	var chatid = $(obj).attr('data-id');
	var voiceurl = $(obj).attr('data-voice');
	var audio = document.getElementById('voice_' + chatid);
	var voicestatus = document.getElementById('voicestatus_' + chatid);
	var onplay = false;

	var palyedAudio = document.getElementById('voice_' + playMsgid);
	
	if ($('.yuyinbox_onplay')) {
		$('.yuyinbox_onplay').attr('class', 'yuyinbox_wt');
	}
	if (isIELowVision) {
		var bgsound = document.getElementsByTagName('bgsound')[0];
		if (bgsound.src == '') {
			bgsound.src = voiceurl;
			onplay = true;
		} else {
			bgsound.src = '';
		}

	} else {
		if(palyedAudio){
			palyedAudio.pause(); // 暂停
			palyedAudio.currentTime = 0;
		}
		if (audio !== null && chatid!=playMsgid) {
			if (audio.paused) {

				audio.play(); // 播放 

				onplay = true;

			} else {
				audio.pause(); // 停止
				audio.currentTime = 0;
			}
		}

		audio.addEventListener("play", function() { //开始播放时触发
			//console.log('开始播放');
		});
		
		audio.addEventListener("ended", function() {
			//console.log('播放结束');
			playMsgid = null;
			$('.yuyinbox_onplay').attr('class', 'yuyinbox_wt');
		}, false);
	}
	if (onplay) {
		playMsgid = chatid;
		$('#onplay_' + chatid).attr('class', 'yuyinbox_onplay');
	} else {
		playMsgid = null;
		$('#onplay_' + chatid).attr('class', 'yuyinbox_wt');
	}

	if (chatid && voicestatus.value == '0' && typeof isAdmin === 'undefined') {
		$.post(weburl + "/index.php?m=chat&c=setVoiceStatus", {
				chatid: chatid,
				id: toid,
				type: totype,
			},
			function(data) {
				if (data) {
					var res = eval('(' + data + ')');
					$('#voicestatus_' + chatid).val('1');
					$('#unlisten_' + chatid).hide();
					if (res.errmsg) {
						layermsg(res.errmsg, 2, function() {
							location.href = weburl;
							return;
						});
					}
				}
			}
		);
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
		if (fIEVersion < 10) {
			return true;
		}
	} else {
		return false;
	}
}
//聊天对象记录翻页
function listScroll() {

	if (boxElement.scrollHeight - boxElement.scrollTop <= (chatlistch + 15)) {
		
		if (mhdata) {
			mhpage = mhpage + 1;
			getmh(mhpage);
		}
	}
}

function getmh(page) {
	mhdata = false;
	var loading = layer.load('执行中，请稍候...', 0);
	$.post(weburl + '/index.php?m=chat&c=getmh', {
		page: page
	}, function(res) {
		layer.closeAll();
		if (res.error == 0) {
			mhdata = true;

			var cstorage = res.chatstorage;
			for(let i in cstorage){
				chatStorage[i] = cstorage[i];
			}

			var his = res.history;
			var mhdiv = $("#chatList");

			for (var i in his) {
				// 判断id是否存在，防止重复加载
				if(! document.getElementById('chat_' + his[i].id)){
					var html = '';
					html += '<li id="chat_' + his[i].id + '" onclick="toChat(\'' + his[i].id + '\',\'' + his[i].usertype + '\',\'' +
						mine.usertype + '\')" class="">';
					html += '<div class="chat_box_userpic"><img src="' + his[i].avatar + '" width="40" height="40">';
					if (his[i].unread > 0) {
						html += '<i  id="unread_'+his[i].id+'" class="chat_box_usermsg">' + his[i].unread + '</i>';
					}
					html += '</div><div class="chat_box_userinfo">';
					html += '<div class="chat_box_username">' + his[i].linkman + '<span class="chat_box_userzw">';
					if (his[i].tusertype != 1) {
						html += '招聘者';
					} else {
						html += '求职者';
					}
					html += '</span></div>';
					html += '<div class="chat_box_userp">';
					if (his[i].tusertype != 1) {
						html += his[i].username;
					} else {
						html += his[i].content;
					}
					html += '</div><span class="chat_box_usertime">' + his[i].time + '</span>';
					html += '<div class="xz_zt">';
					if (his[i].down == 1) {
						html += '<span class="xz_zt_a">已下载简历</span>';
					}
					if (his[i].sq == 1 && (mine.usertype == 2 || mine.usertype == 3)) {
						html += '<span class="xz_zt_a">已投递简历</span>';
					}
					if (his[i].sq == 1 && mine.usertype == 1) {
						html += '<span class="xz_zt_a">已申请职位</span>';
					}
					html += '</div></div></li>';
					mhdiv.append(html);
				}
			}
		}
	},'json');
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
	if ($('#face').hasClass('sendbq_i')) {
		$('#commonly').removeClass('none');
		// $('#face').attr('class','chat_footer_keyboard');
		// $('#face').addClass('chat_footer_keyboard');
		$('#face').removeClass("sendbq_i");
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
		});
	} else {
		$('#commonly').addClass('none');
		// $('#face').attr('class','sendbq');
		$('#face').addClass("sendbq_i");
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
	$('#face').addClass("sendbq_i");
	
}
// 收到视频面试通知处理
function comment(data) {
	if (!commentState) {
		if (data.to == mine.id) {
			var timestamp = new Date().getTime();
			commentState = 'receive';
			window.localStorage.setItem("isspview", "0");
			if(!spviewBell && !document[hiddenProperty]){
				spviewBell = document.createElement("audio");
				spviewBell.src = weburl + '/js/trtc/video.mp3';
				spviewBell.loop = true;
				spviewBell.play();
			}
			spconfirm = layer.confirm('收到视频面试邀请，是否接受', {
					btn: ['接受', '拒绝']
				},
				function() {
					layer.close(spconfirm);
					if(spint){
						clearInterval(spint);
						spint = null;
					}
					commentState = null;
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
					if(spint){
						clearInterval(spint);
						spint = null;
					}
					var msg = {
						type: 'commentRefused',
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
			if(spWait == ''){
				spWait = 60;
			}else{
				spWait = parseInt(spWait);
			}
			spint = setInterval(function(){
				layer.close(spconfirm);
				if(spviewBell){
					spviewBell.pause();
					spviewBell = null;
				}
			},spWait*1000);
			
			newChatMsg = true;
			if (document[hiddenProperty]) {
				var titAn = true;
				if (titledsq) {
					clearInterval(titledsq);
				}
				titledsq = setInterval(function() {
					if (titAn) {
						document.title = '【新消息】';
						titAn = false;
					} else {
						document.title = $('#zwf').text();
						titAn = true;
					}
				}, 1000);
			}
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
			socket.send(JSON.stringify(msg));
		}
	}
}
// 对方取消视频请求
function closesp(msg) {
	if (msg.to == mine.id) {
		layer.closeAll();
		layer.msg('对方取消视频请求', 2, 8);
		commentState = null;
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
// 告知自己的全部连接，关闭是否面试的询问框
function closeSpConfirm(msg) {
	if (msg.to == mine.id) {
		layer.close(spconfirm);
		commentState = null;
		if(spint){
			clearInterval(spint);
			spint = null;
		}
	}
}
function sendAsk(ask) {
	$('#sendtype').val('sendask');
	$('#hhtype').val(ask);

	if (ask == 'tel') {

		if (cantel != '3') {
			$('#wxdiv').hide();
			$('#teldiv').show();
			if (tel) {
				$('#telinput').val(tel);
			}
			$('#hhshow').show();
		}

	} else if (ask == 'wx') {

		if (canwx != '3') {
			$('#teldiv').hide();
			$('#wxdiv').show();
			if (wxid) {
				$('#wxinput').val(wxid);
			}
			$('#hhshow').show();
		}
	}
}

function confirmAsk(obj) {
	var ask = $(obj).attr('data-ask');
	var chatid = $(obj).attr('data-chatid');
	$('#sendtype').val('sendconfirm');
	$('#hhtype').val(ask);
	$('#chatid').val(chatid);
	if (ask == 'tel') {

		$('#wxdiv').hide();
		$('#teldiv').show();
		if (tel) {
			$('#telinput').val(tel);
		}
		$('#hhshow').show();

	} else if (ask == 'wx') {

		$('#teldiv').hide();
		$('#wxdiv').show();
		if (wxid) {
			$('#wxinput').val(wxid);
		}
		$('#hhshow').show();
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

			layer.msg('请填写手机号', 2, 8);
			return false;

		} else if (!isjsMobile(hhvalue)) {

			layer.msg('手机格式错误！', 2, 8);
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
			layer.msg('请填写微信号', 2, 8);
		}else if(hhtype == 'tel'){
			layer.msg('请填写联系电话', 2, 8);
		}

		
	}
}
//发送请求互换
function postAsk(ask, askvalue) {

	var asktext = '';

	if (ask && askvalue) {

		$.post(weburl + "/index.php?m=chat&c=checkCanAsk", {
			toid: toid,
			totype: totype,
			ask: ask,
			askvalue: askvalue
		}, function(data) {

			var data = eval('(' + data + ')');

			if (data.error == '9') {

				$('#hhshow').hide();

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

				layer.msg(data.msg, 2, 8);

				if (data.error == '7') {

					huhuanStatus(ask, '3');
				}
			}
		});
	}
}
//发送确认互换
function postConfirm(ask, askvalue) {

	if (ask && askvalue) {

		var chatid = $('#chatid').val();

		$.post(weburl + "/index.php?m=chat&c=confirmAsk", {
			toid: toid,
			totype: totype,
			ask: ask,
			askvalue: askvalue,
			chatid: chatid
		}, function(data) {

			var data = eval('(' + data + ')');

			if (data.error == '1') {

				$('#hhshow').hide();

				if (data.towx) {
					towx = data.towx;
					huhuanStatus('wx', '1');
				}
				if (data.totel) {
					totel = data.totel;
					huhuanStatus('tel', '1');
				}

				sendMessage(askvalue, 'confirm', ask);

				banClickHtml(chatid, 'confirm');
			} else {
				layer.msg('参数错误，请重试', 2, 8);
			}
		});
	}
}

function banClickHtml(chatid, type) {

	var typetext = type == 'confirm' ? '已同意' : '已拒绝';
	var html = '<span class="wxyty">' + typetext + '</span>';
	$('#hhbtn_' + chatid).html(html);
}

function huhuanStatus(type, val) {
	if (type == 'wx') {
		canwx = val;
		if (val == '3') {
			$('#header_hwx').attr('class', 'chat_header_hwx_grey');
			$('#header_hwxtxt').text('请求微信中');
		} else {
			$('#header_hwx').attr('class', 'chat_header_hwx');
			$('#header_hwxtxt').text('互换微信');
		}
	} else if (type == 'tel') {
		cantel = val;
		if (val == '3') {
			$('#header_hdh').attr('class', 'chat_header_hdh_grey');
			$('#header_hdhtxt').text('请求电话中');
		} else {
			$('#header_hdh').attr('class', 'chat_header_hdh');
			$('#header_hdhtxt').text('互换电话');
		}
	}
}

function getAskHtml(ask, msg) {
	var asktext = '',
		can = 0;
	if (ask == 'tel') {
		if (msg.mine) {

			
			asktext = '正在请求互换电话，等待对方同意';
			

		} else {
			asktext = '我想要和您互换电话<br>您是否同意';
		}

		can = cantel;
	} else if (ask == 'wx') {

		if (msg.mine) {
			
			asktext = '正在请求互换微信，等待对方同意';
			

		} else {
			asktext = '我想要和您互换微信<br>您是否同意';
		}
		can = canwx;
	}

	if (msg.mine) {
		var html = '<li class="chat_li"><div class="chat_hdh">';
		html += '<span><div class="chat_hdh_p">' + asktext + '</div></span></div></li>';
	} else {
		var askIcon = '';
		if (ask == 'tel') {
			askIcon = 'chat_hhyq_icon';
		} else if (ask == 'wx') {
			askIcon = 'chat_hhwx_icon';
		}
		var html = '<li class="chat_li"><div class="chat_hhyq">';
		html += '<div class="chat_hhyq_p chat_hhyq_pq"><i class="' + askIcon + '"></i>' + asktext + '</div>';
		if (msg.askstatus == '1') {
			html += '<div id="hhbtn_' + msg.chatid +
				'" class="chat_hhyq_bth"><span class="wxyty">已同意</span></div></span></div></li>';
		} else if (msg.askstatus == '2') {
			html += '<div id="hhbtn_' + msg.chatid +
				'" class="chat_hhyq_bth"><span class="wxyty">已拒绝</span></div></span></div></li>';
		} else {

			html += '<div id="hhbtn_' + msg.chatid + '" class="chat_hhyq_bth">';

			html += '<div data-ask="' + ask + '" data-chatid="' + msg.chatid +
				'"  onclick="confirmAsk(this)" class="bh_bth bh_bthline">同意</div>';
			html += '<span data-ask="' + ask + '" data-chatid="' + msg.chatid +
				'"  onclick="refuseAsk(this)" class="bh_bth">拒绝</span>';

			html += '</div></span></div></li>';
		}
	}
	return html;
}

function getRefuseHtml(type, msg) {
	var that = this,
		refusetext = '',
		ask = type;

	if (ask == 'tel') {
		if (msg.mine) {

			//refusetext = '您已拒绝对方的互换电话请求';

		} else {

			refusetext = '对方已拒绝了您的互换电话请求';
		}

	} else if (ask == 'wx') {
		if (msg.mine) {

			//refusetext = '您已拒绝对方的互换微信请求';

		} else {

			refusetext = '对方已拒绝了您的互换微信请求';
		}
	}

	var html = '<li class="chat_li"><div class="chat_hdh">';
	html += '<span><div class="chat_hdh_p">' + refusetext + '</div></span></div></li>';
	return html;
}

function confirmAskHtml(askvalue, ask, msg) {
	if (askvalue) {
		var askmsg = '';
		var askIcon = '';
		var linkman_v = '';
		if (ask == 'wx') {
			askmsg = '的微信号:<br>';
			askIcon = 'chat_hhwx_icon';
		} else if (ask == 'tel') {
			askmsg = '的手机号:<br>';
			askIcon = 'chat_hhyq_icon';
		}
		if(typeof linkman =='undefined'){
			
			linkman_v = msg.username;
			
		}else{
			linkman_v = linkman;
		}
		var time = new Date().getTime();
		var askvalueid = 'askvalue' + time;
		var html = '<li class="chat_li"><div class="chat_hhyq">';
		html += '<div class="chat_hhyq_p"><i class="' + askIcon + '"></i>' + linkman_v + askmsg + askvalue + '</div>';
		html += '<input  id="' + askvalueid + '" value="' + askvalue +
			'"  style="opacity: 0;position: absolute;height:0;" type="text">';
		html += '<div data-askvalueid="' + askvalueid + '" data-ask="' + ask +
				'"  onclick="copyMsg(this)"  class="chat_hhyq_bth">';
		if (ask == 'wx') {
			html += '<span class="">复制微信号</span>';
		} else if (ask == 'tel') {

			html += '<span class="">复制手机号</span>';

			
		}

		html += '</div></span></div></li>';
		return html;
	}
}

function copyMsg(obj) {
	var ask = $(obj).attr('data-ask');
	var askvalueid = $(obj).attr('data-askvalueid');
	var askvalue = document.querySelector('#' + askvalueid);
	askvalue.select(); // 选择对象

	if (document.execCommand("copy")) {
		document.execCommand("copy");
		layer.msg('已复制');
	};
}

function refuseAsk(obj) {

	var ask = $(obj).attr('data-ask');
	var chatid = $(obj).attr('data-chatid');
	if (toid != '') {

		$.post(weburl + "/index.php?m=chat&c=refuseAsk", {
			toid: toid,
			totype: totype,
			ask: ask,
			chatid: chatid
		}, function(data) {

			var data = eval('(' + data + ')');

			if (data.error == 1) {

				huhuanStatus(ask, '2');
				sendMessage('', 'refuse', ask);
				banClickHtml(chatid, 'refuse');
			} else {
				layer.msg('参数错误，请重试', 2, 8);
			}
		});
	} else {
		layer.msg('参数错误，请重试', 2, 8);
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
					$(".zphnetOnline").hide();
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
					$("#dxzph_" + data.list[i]).show();
				}
			}
		}
	}
}
// 接收管理员发送的职位
function getAdminjob(msg){
	var jobid = msg.content.replace('jobid=', '');
	$.post(weburl + "/index.php?m=chat&c=getJob",{jobid: jobid}, function(res){
		if(res.id){
			// 消息时间间隔超60秒，显示新时间
			if (msg.timestamp - sendTime > 60 * 1000) {
				$("#chat_content").find('ul').append('<div class="chat_sendtime"><span class="chat_sendtime_b">' + timeFormat(msg.timestamp) + '</span></div>');
				sendTime = msg.timestamp;
			}
			var html = '<li class="chat_li"><div class="chat_yx_job"  data-wapurl="' + res.weburl +
					'" onclick="toShow(this)">';
				html += '<span><div class="chat_yx_job_name">' + res.name + '</div>';
				html += '<span class="chat_yx_xz">' + res.job_salary + '</span>';
				html += '<div class="chat_yx_com_name">' + res.com_name + '</div>';
				html += '<div class="">' + res.citystr;
				if (res.job_exp) {
					html += ' . ' + res.job_exp + '经验';
				}
				if (res.job_edu) {
					html += ' . ' + res.job_edu + '学历';
				}
				html += '</div>';
				html += '</li>';
			$("#chat_content").find('ul').append(html);
			
			var scroll = document.getElementById('chat_content').scrollHeight;
			chatScrollTo(scroll);
			
			setRead(msg);
		}
	},'json');
}
function goBack(){
    if (navigator.userAgent.indexOf('Firefox') >= 0 ||
		navigator.userAgent.indexOf('Opera') >= 0 ||
		navigator.userAgent.indexOf('Safari') >= 0 ||
		navigator.userAgent.indexOf('Chrome') >= 0 ||
		navigator.userAgent.indexOf('WebKit') >= 0){

		if(window.history.length > 1){
			window.history.go( -1 );
		}else{
			window.location.reload();
		}
	}else{ //未知的浏览器
		window.history.go( -1 );
	}
}