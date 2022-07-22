var lookCount = {
		num: 0,
		time: 0
	},
	ajaxlook = 0,
	lastid = '',
	ismore = false,
	loaded = true,
	scrollHeight = 0,
	page = 1,
	islink = 1,
	socket = null,
	ping_timer = null;
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
	
	moreChat();
	nowCount();
	
	if ("WebSocket" in window) {
		webSocket(socketUrl);
		if(mine.usertype){
			chatOnLoad();
		}else{
			chatUnlogin();
		}
		hiddenCommon();
	} else {
		console.log("您的浏览器不支持聊天!");
	}
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
				},500);
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
	$("#chat_content").scroll(function(){
		var cs = document.getElementById('chat_content').scrollTop;
		if(cs == 0 && ismore && loaded){
			document.getElementById('chat_content').scrollTop = 21;
			loaded = false;
			layer.load('执行中，请稍候...',0);
			moreChat();
		}
	})
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
			}, 50000);
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
				case 'xjhMessage':
					getMessage(e.data);
					break;
				case 'xjhCount':
					break;
				case 'error':
					islink = 2;
					if(ping_timer){
						clearInterval(ping_timer);
						ping_timer = null;
					}
					break;
				case 'startLive':
					startLive(e.data);
					break;
				case 'stopLive':
					stopLive(e.data);
					break;
			}
		};
	}
}
// 加载聊天数据
function chatOnLoad(){
	$.post(weburl + "/index.php?m=chat&c=goChat", {
		chattype: 'xjh'
	}, function(data) {
		if (data) {
			var res = eval('(' + data + ')');
			mine = res.mine;
			if (socket && socket.readyState == 1){
				bindUser(res)
			}else{
				var t = setInterval(function(){
					if (socket && socket.readyState == 1){
						clearInterval(t);
						t = null;
						bindUser(res);
					}
				},100);
				setTimeout(function(){
					if(t){
						clearInterval(t);
						t = null;
					}
				},10000);
			}
		}
	});
}
// 重新连接请求数据
function chatOnShow(){
	$.post(weburl + "/index.php?m=chat&c=getToken", {
		chattype: 'xjh'
	}, function(data) {
		if (data) {
			var res = eval('(' + data + ')');
			if (socket && socket.readyState == 1){
				bindUser(res);
			}else{
				var t = setInterval(function(){
					if (socket && socket.readyState == 1){
						clearInterval(t);
						t = null;
						bindUser(res);
					}
				},500);
				setTimeout(function(){
					if(t){
						clearInterval(t);
						t = null;
					}
				},10000);
			}
		}
	})
}
function bindUser(res){
	if(res.yuntoken && res.yuntoken.token && typeof(xjhsyncid) != "undefined" && xjhsyncid != ""){
		var yuntoken = res.yuntoken.token;
		var bind = {
			type: 'bind',
			data: {
				uid: mine.id,
				usertype: mine.usertype,
				yuntoken: yuntoken,
				group: 'xjh_' + xjhsyncid
			}
		}
		socket.send(JSON.stringify(bind));
		window.localStorage.setItem("socketState", "1");
	}else{
		socket = null;
		islink = 2;
		if(ping_timer){
			clearInterval(ping_timer);
			ping_timer = null;
		}
	}
}
// 未登录用户加载聊天数据
function chatUnlogin(){
	$.post(weburl + "/index.php?m=chat&c=getUnloginToken", {
		chattype: 'xjh'
	}, function(data) {
		if (data) {
			var res = eval('(' + data + ')');
			var t = setInterval(function(){
				if (socket && socket.readyState == 1){
					clearInterval(t);
					// 加入宣讲会
					if(res.data){
						var bindData = res.data;
						bindData.group = 'xjh_' + xjhsyncid;
						var bind = {
							type: 'bind',
							data: bindData
						}
						socket.send(JSON.stringify(bind));
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
	});
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
				if(mine.usertype){
					chatOnShow();
				}else{
					chatUnlogin();
				}
			}
		}
	});
}
function back(){
	history.back();
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
	if(msg.xjhid == 'xjh_' + xjhsyncid && (msg.id != mine.id || (msg.id == mine.id && msg.plat != 'pc'))) {
		chatRender(msg, 'get');
	}
}
// 发送消息
function sendMessage(content, type, id){
	
	var time = new Date().getTime();
	if(socket && socket.readyState == 1){
		// 根据消息类型区分保存内容
		var mineData = {
			id: mine.id,
			avatar: mine.avatar,
			username: mine.username,
			linkman: mine.linkman,
			timestamp: new Date().getTime(),
			xjhid: 'xjh_' + xjhsyncid,
			xid: xjhid,
			msgtype: type,
			caster:0,
			plat: 'pc'
		};
		
		var checkdata = {
			id: mine.id,
			content: content,
			xjhid: xjhid,
			timestamp: mineData.timestamp
		};
		$.post(weburl+"/index.php?m=chat&c=checkdata", checkdata, function (data) {
			var res = eval('(' + data + ')');
			if(res.errcode){
				layer.msg(res.msg, 2,8);
			}else{
				if(res.msgcontent != ''){
					if(res.nickname){
						mineData.username = res.nickname;
					}
					mineData.content = res.msgcontent;
			
					var message = {
						type: 'xjhMessage',
						data: {
							mine: mineData
						}
					};
					socket.send(JSON.stringify(message));
					// 渲染消息内容
					mineData.htmlcontent = res.msgcontent;
					chatRender(mineData, 'send');
				}else{
					layer.msg('请慎重发言', 2,8);
				}
			}
			
		});
	}else{
		layer.msg(chat_name+'功能加载中', 2, 8);
	}
}
// 渲染消息内容
function chatRender(msg, type){
	if(type == 'send'){
		// 发送
		if(msg.msgtype == 'char'){
			var content = rexContent(msg.htmlcontent);
			// 我说
			var html  = '<li><div class="xjh_show_lytx">';
				html += '<img src="' + msg.avatar + '" width="45" height="45"></div>';
				html += '<div class="xjh_show_lyuser">'+ msg.username +'</div>';
				if(msg.caster==1){
					html += '<div class="xjh_gf">官方</div>';
				}
				html += '<div class="xjh_show_ly_p">' + content + '</div>';
				html += '</li>';
		}
	}else {
		// 接收
		if(msg.msgtype == 'char'){
			
			msg.content = rexContent(msg.content);
			var html  = '<li><div class="xjh_show_lytx">';
				html += '<img src="' + msg.avatar + '" width="45" height="45"></div>';
				html += '<div class="xjh_show_lyuser">'+ msg.username +'</div>';
				html += '<div class="xjh_show_ly_p">' + msg.content + '</div>';
				html += '</li>';
		}
	}
	$("#chat_content").find('ul').append(html);
	var scroll = document.getElementById('chat_content').scrollHeight;
	chatScrollTo(scroll);
	return html;
}
// 转义内容
function rexContent(content){
	content = (content||'').replace(/&(?!#?[a-zA-Z0-9]+;)/g, '&amp;')
    .replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/'/g, '&#39;').replace(/"/g, '&quot;') //XSS
	.replace(/face\[([^\s\[\]]+?)\]/g, function(face){  //转义表情
		var alt = face.replace(/^face/g, '');
		return '<img alt="'+ alt +'" title="'+ alt +'" src="' + faces([alt]) + '">';
	})
	.replace(/img\[([^\s]+?)\]/g, function(img){  //转义图片
      return '<img class="chat_photos" src="' + img.replace(/(^img\[)|(\]$)/g, '') + '">';
    })
	return content;
}
function timeFormat(nowtime) {
	if(nowtime){
		nowtime = new Date(nowtime);
	}else{
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
	var clientHeight = document.getElementById('chat_content').clientHeight;
	if(ypos > clientHeight){
		// 兼容各种浏览器
		document.getElementById('chat_content').scrollTop = ypos;
	}
}

function moreChat(){
	$.ajax({
		type : "post",
		url : weburl + "/index.php?m=chat&c=getXjhChatPage",
		async: false,
		data : {'xjhid': xjhid,'page': page,'lastid': lastid},
		dataType : "json",
		success : function(res) {
			if (res) {
				ismore = res.ismore;
				var cl = res.list.length;
				if(cl>0){
					page = page + 1;
					if(page == 2){
						// 初次加载首条id
						lastid = res.list[cl-1]['chatid'];
						for(var i in res.list){
							chatRender(res.list[i],'get');
						}
					}else{
						var list = res.list.reverse();
						for(var i in list){
							renderPast(list[i],'get');
						}
					}
				}
			}
			setTimeout(function(){
				layer.closeAll();
				loaded = true;
			},500);
		}
    });
}
// 渲染加载的历史记录
function renderPast(msg){
	if(msg.msgtype == 'char'){
		
		msg.content = rexContent(msg.content);
		var html  = '<li><div class="xjh_show_lytx">';
			html += '<img src="' + msg.avatar + '" width="45" height="45"></div>';
			html += '<div class="xjh_show_lyuser">'+ msg.username +'</div>';
			html += '<div class="xjh_show_ly_p">' + msg.content + '</div>';
			html += '</li>';
	}
	$("#chat_content").find('ul').prepend(html);
}
function startLive(e){
	if(typeof(xjhsyncid) != "undefined" && xjhsyncid != ""){
		if(xjhsyncid == e.xjhid && livestatus != '2'){
			// 查询播放地址
			$.post(weburl +"/index.php?m=xjhlive&c=getXjhlive",{id: xjhid},function(data){
				if(data){
					var res = eval('(' + data + ')');
					if(res.hls){
						$("#live_hls").val(res.hls);
					}
				}
				if(document.getElementById('live_video')){
					if(player){
						player.destroy();
					}
					livePlay();
				}else{
					$('#waitshow').hide();
					$(".xjh_show_spbg").hide();
					$('.xjh_show_eye').show();
					$('#livebody').append('<div id="live_video" class="show_box_header_opacity"></div>');
					livePlay();
				}
			});
		}
	}
}
function stopLive(e){
	if(typeof(xjhsyncid) != "undefined" && xjhsyncid != ""){
		if(xjhsyncid == e.xjhid){
			if(player){
				player.destroy();
			}
			setTimeout(function(){
				var html = $("#codvideo").html();
				$("#livebody").html(html);
			},2000);
		}
	}
}
// 实时统计
function xjhCount(msg){
	if(livestatus != 1){
		lookCount.time = new Date().getTime();
		lookCount.num = msg.count;
		ajaxlook = 0;
	}
}
// 数据统计
function nowCount(){
	if(livestatus != 1){
		setInterval(function(){
			var nowtime = new Date().getTime();
			if((nowtime - lookCount.time) > 1000 && ajaxlook < 1){
				ajaxlook++
				$.get('index.php?m=xjh&a=getAjaxHits&id='+ xjhid, function(data){
					$("#looknum").text(data);
				});
			}
		},5000);
	}
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
		// $('#face').attr('class','chat_footer_keyboard');
		// $('#face').addClass('chat_footer_keyboard');
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
		// $('#face').attr('class','sendbq');
		$('#face').addClass("sendbq_i");
		document.getElementById("send_content").focus();
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
	$('#face').attr('class','sendbq');
	$('#face').addClass("sendbq_i");
}