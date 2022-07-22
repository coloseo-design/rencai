var lastid = '',
	ismore = false,
	loaded = true,
	scrollHeight = 0,
	page = 1,
	islink = 1,
	socket = null,
	ping_timer = null,
	listLoad = false,
	boxElement = null;

$(function() {
	if ("WebSocket" in window) {
		webSocket(socketUrl);
		chatUnlogin();
		hiddenCommon();
	} else {
		console.log("您的浏览器不支持聊天!");
	}
	$(window).keydown(function (e) {
		// Enter发送
		if(e.keyCode == 13){
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
	// 发送消息
	if ($('#send').length > 0) {
		$('#send').click(function() {
			if(socket && socket.readyState == 1){
				send();
			}else{
				webSocket(socketUrl);
				var timer = setInterval(function(){
					if(socket && socket.readyState == 1){
						clearInterval(timer);
						send();
					}
				},100);
				setTimeout(function(){
					if(timer){
						clearInterval(timer);
					}
				},10000);
			}
		});
	}
	$("body").click(function(e){
		var con = $("#commonly");   // 设置目标区域
		var face = $("#face");
		if ((!con.is(e.target) && con.has(e.target).length === 0) && (!face.is(e.target) && face.has(e.target).length === 0)) {
			commonHide();
		}
	});
	$("#face").click(function(){
		face();
	});
	if($("#chat_content").length > 0){
		$("#chat_content").scroll(function(){
			var cs = document.getElementById('chat_content').scrollTop;
			if(cs == 0 && ismore && loaded){
				document.getElementById('chat_content').scrollTop = 21;
				loaded = false;
				app.cslog(app.$data.logid);
			}
		})
	}
	if($("#chatList").length > 0){
		boxElement = document.getElementById("chatList");
		boxElement.addEventListener('scroll', listScroll);
	}
});
function webSocket(socketUrl){
	if(islink == 1){
		if(ping_timer){
			clearInterval(ping_timer);
			ping_timer = null;
		}
		socket = new WebSocket(socketUrl);
		socket.onopen = function() {
			var ping = {
				type: 'ping'
			};
			ping_timer = setInterval(function() {
				if (socket && socket.readyState == 1){
					socket.send(JSON.stringify(ping));
				}else{
					socket.close();
				}
			}, 30000);
		};
			
		socket.onerror = function() {
			islink = 2;
			socket = null;
			if(ping_timer){
				clearInterval(ping_timer);
				ping_timer = null;
			}
		};
		
		socket.onclose = function() {
			socket = null;
			if(ping_timer){
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
				case 'error':
					islink = 2;
					if(ping_timer){
						clearInterval(ping_timer);
						ping_timer = null;
					}
					break;
			}
		};
	}
}
// 未登录用户加载聊天数据
function chatUnlogin(){
	$.post("index.php?m=crm_chat&c=getUnloginToken", {
		chattype: 'admin',pytoken: pytoken
	}, function(res) {
		if (res) {
			var t = setInterval(function(){
				if (socket && socket.readyState == 1){
					clearInterval(t);
					if(res.data){
						var bindData = res.data;
						var bind = {
							type: 'bind',
							data: bindData
						}
						socket.send(JSON.stringify(bind));
					}
					if(res.mine){
						mine = res.mine;
					}
					window.localStorage.setItem("islink", "1");
				}
			},100);
			setTimeout(function(){
				if(t){
					clearInterval(t);
				}
			},10000);
		}
	},'json');
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
				chatUnlogin();
			}
		}
	});
}
// 发送消息
function send() {
	var content = document.getElementById('send_content');
	if (content.value != '') {
		sendMessage(content.value,'char','');
		content.value = '';
	}
}
function getMessage(msg){
	// 后台
	if (msg.id && msg.totype == 9 && msg.msgtype != 'read'){
		if (typeof toid != 'undefined') {
			chatRender(msg);
		}else{
			if ($('#crm_chat_num').length > 0) {
				var msg_new = $('#crm_chat_num');
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
function chatRender(msg){
	// 渲染消息内容
	var	newlog = {
		    chatid: new Date().getTime(),
			mine: false,
			msgtype: msg.msgtype,
			avatar: msg.avatar,
			content: rexContent(msg.content)
		};
	app.$data.logList.push(newlog);
	setTimeout(function(){
		var scroll = document.getElementById('chat_content').scrollHeight;
		chatScrollTo(scroll);
	},100);
}
// 发送消息
function sendMessage(content, type, id){
	commonHide();
	var time = new Date().getTime();
	if(socket && socket.readyState == 1){
		// 根据消息类型区分保存内容
		if (type == 'adminjob') {
			content = 'jobid=' + id;
		}
		var mineData = {
			id: mine.id,
			mine: true,
			ftype: mine.usertype,
			avatar: mine.avatar,
			username: mine.username,
			linkman: mine.linkman,
			timestamp: time,
			content: content,
			msgtype: type,
			op: {},
		};
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
		if (type != 'change') {
			var pdata = {
				to: sendData.to.id,
				totype: sendData.to.utype,
				content: content,
				timestamp: sendData.mine.timestamp,
				msgtype: sendData.mine.msgtype,
				nowid: sendData.mine.id,
				nowtype: sendData.mine.ftype,
				pytoken: pytoken,
				eid: eid,
				chated: chated
			};
		
			$.post("index.php?m=crm_chat&c=chatLog", pdata, function(res) {
				if (res) {
					if (res.error == 0) {
						chated = 1;
						message.data.content.mine.chatid = res.chatid;
						socket.send(JSON.stringify(message));
						// 渲染消息内容
						mineData.content = rexContent(content);
						if (type == 'adminjob') {
							mineData.job = app.$data.joblist[jobkey];
						}
						app.$data.logList.push(mineData);
						setTimeout(function(){
							var scroll = document.getElementById('chat_content').scrollHeight;
							chatScrollTo(scroll);
						},100);
						if(typeof parent.needLoad !== 'undefined'){
							parent.needLoad = true;
						}
					}
				}
			},'json');
		} else {
			socket.send(JSON.stringify(message));
			// 渲染消息内容
			mineData.content = rexContent(content);
			app.$data.logList.push(mineData);
			setTimeout(function(){
				var scroll = document.getElementById('chat_content').scrollHeight;
				chatScrollTo(scroll);
			},100);
		}
	}else{
		layer.msg('客勤功能加载中', 2, 8);
	}
}
// 页面滚动
function chatScrollTo(ypos) {
	var clientHeight = document.getElementById('chat_content').clientHeight;
	if(ypos > clientHeight){
		// 兼容各种浏览器
		document.getElementById('chat_content').scrollTop = ypos;
	}
}

// 上传图片
function upImage(obj) {
	layer.load();
	$('#imgform').submit();
	var iframe = $('#cs_iframe'),
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
// 转义内容
function rexContent(content){
	content = (content||'').replace(/&(?!#?[a-zA-Z0-9]+;)/g, '&amp;')
    .replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/'/g, '&#39;').replace(/"/g, '&quot;') //XSS
	.replace(/face\[([^\s\[\]]+?)\]/g, function(face){  //转义表情
		var alt = face.replace(/^face/g, '');
		return '<img class="chat_bq_img" alt="'+ alt +'" title="'+ alt +'" src="' + faces([alt]) + '">';
	})
	.replace(/img\[([^\s]+?)\]/g, function(img){  //转义图片
      return '<img class="chat_photos" src="' + img.replace(/(^img\[)|(\]$)/g, '') + '">';
    })
	return content;
}
//表情库
function faces(fc){
    var alt = {1:'[龇牙]',2:'[调皮]',3:'[流汗]',4:'[偷笑]',5:'[再见]',6:'[敲打]',7:'[擦汗]',8:'[流泪]',9:'[大哭]',10:'[嘘]',11:'[酷]',12:'[抓狂]',13:'[可爱]',14:'[色]',15:'[害羞]',16:'[得意]',17:'[吐]',18:'[微笑]',19:'[怒]',20:'[尴尬]',21:'[惊恐]',22:'[冷汗]',23:'[白眼]',24:'[傲慢]',25:'[难过]',26:'[惊讶]',27:'[疑问]',28:'[么么哒]',29:'[困]',30:'[憨笑]',31:'[撇嘴]',32:'[阴险]',33:'[奋斗]',34:'[发呆]',35:'[左哼哼]',36:'[右哼哼]',74:'[抱抱]',37:'[坏笑]',38:'[鄙视]',39:'[晕]',40:'[可怜]',41:'[饥饿]',42:'[咒骂]',43:'[折磨]',44:'[抠鼻]',45:'[鼓掌]',46:'[糗大了]',47:'[打哈欠]',48:'[快哭了]',49:'[吓]',50:'[闭嘴]',51:'[大兵]',52:'[委屈]',53:'[NO]',54:'[OK]',56:'[弱]',57:'[强]',60:'[握手]',63:'[胜利]',58:'[抱拳]',66:'[凋谢]',99:'[米饭]',108:'[蛋糕]',112:'[西瓜]',70:'[啤酒]',89:'[瓢虫]',62:'[勾引]',82:'[爱你]',69:'[咖啡]',72:'[月亮]',68:'[刀]',55:'[差劲]',59:'[拳头]',65:'[便便]',79:'[炸弹]',107:'[菜刀]',82:'[心碎了]',83:'[爱心]',71:'[太阳]',97:'[礼物]',92:'[皮球]',137:'[骷髅]',123:'[闪电]',80:'[猪头]',67:'[玫瑰]',98:'[篮球]',64:'[乒乓]',101:'[红双喜]',139:'[麻将]',73:'[彩带]',61:'[爱你]',95:'[示爱]',111:'[衰]',109:'[蜡烛]'},arr = {};
	$.each(alt, function(index, item){
		arr[item] = weburl + '/js/im/emoji_'+ index +'@2x.png';
    });
	if(fc){
		return arr[fc];
	}else{
		return arr;
	}
}
function face(){
	if($('#face').hasClass('sendbq_i')){
		$('#commonly').removeClass('none');
		$('#face').removeClass("sendbq_i");
		var content = '',
			faceArr = faces();
			
		$.each(faceArr, function(key, item){
			content += '<li title="'+ key +'"><img src="'+ item +'"></li>';
		});
		content = '<ul id="face_content" class="chat_face">'+ content +'</ul>';
		$('#commonly').html(content);
		
		$("#face_content").off("click");
		$('#face_content').find('li').on('click', function(elem){
			var title = elem.currentTarget.title;
			focusInsert(document.getElementById("send_content"), 'face' + title + ' ', true);
		});
	}else{
		$('#commonly').addClass('none');
		$('#face').addClass("sendbq_i");
	}
}
//在焦点处插入内容
function focusInsert(obj, str, nofocus){
	
    var result, val = obj.value;
    nofocus || obj.focus();
    if(document.selection){ //ie
		result = document.selection.createRange(); 
		document.selection.empty(); 
		result.text = str; 
    } else {
		result = [val.substring(0, obj.selectionStart), str, val.substr(obj.selectionEnd)];
		nofocus || obj.focus();
		obj.value = result.join('');
    }
}
function commonHide(){
	$('#commonly').addClass('none');
	if(! $('#face').hasClass('sendbq_i')){
		$('#face').addClass('sendbq_i');
	}
}

// 格式化时间戳
function timeFormat(stime) {
	var nowtime = new Date(stime);
	var today = new Date(new Date().setHours(0, 0, 0, 0)).getTime();
	var year = nowtime.getFullYear(),
		month = nowtime.getMonth(),
		day = nowtime.getDate(),
		hour = nowtime.getHours(),
		minute = nowtime.getMinutes(),
		second = nowtime.getSeconds();
	if(stime < today){
		month = month + 1;
		if (month < 10) {
			month = '0' + month;
		}
		if (day < 10 && day > 0) {
			day = '0' + day;
		}
		return year + '-' + month + '-' + day;
	}else{
		if (hour < 10 && hour > 0) {
			hour = '0' + hour;
		}
		if (minute < 10 && minute > 0) {
			minute = '0' + minute;
		}
		if (second < 10 && second > 0) {
			second = '0' + second;
		}
		return hour + ':' + minute + ':' + second;
	}
}
// 列表滚动
function listScroll(){
	if (boxElement.scrollHeight - boxElement.scrollTop === boxElement.clientHeight && listLoad) {
		app.getList();
	}
}
// 获取文档完整的高度 
function getScrollHeight() { 
	return Math.max(document.body.scrollHeight, document.documentElement.scrollHeight); 
}