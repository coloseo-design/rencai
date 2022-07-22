$(document).ready(function(){
	var search=$("#search").val(); 
	if(search!="输入职位关键词：如销售总监等"){
		$("input[id='search']").css("color","#000"); 
	} 
}); 
function myself() { layer.msg('本人发布，无法推荐！', 2, 8); return false; }
function checkform_msg(){
	var name=$.trim($("#uname").val());
	if(name==""){
		layer.msg('姓名不能为空！', 2, 8);return false; 
	}
	if($("input[name='sex']:checked").val()==''){
		layer.msg('请选择性别！', 2, 8);return false;
	}
	if($.trim($("#birthday").val())==''){
		layer.msg('请选择出生年月！', 2, 8);return false;
	}
	if($.trim($("#edu").val())==''){
		layer.msg('请选择最高学历！', 2, 8);return false;
	}
	if($.trim($("#exp").val())==''){
		layer.msg('请选择工作经验！', 2, 8);return false;
	}
	if($.trim($("#hy").val())==''){
		layer.msg('请选择从事行业！', 2, 8);return false;
	}
	if($.trim($("#job").val())==''){
		layer.msg('请选择意向职位！', 2, 8);return false;
	}
	var cionly	=	$.trim($("#cionly").val());
	if(cionly=='1'){
		if($("#provinceid").val()==""){
			layer.msg('请选择期望城市！',2,8);return false;
		}
	}else{
		if($.trim($("#cityid").val())==''){
			layer.msg('请选择期望城市！', 2, 8);return false;
		}
	}
		
	var min = $.trim($("#minsalary").val());
	var max = $.trim($("#maxsalary").val());
	if(min==''){
		layer.msg('请填写期望薪资！', 2, 8);return false;
	}
	if(max){
		if(parseInt(max)<=parseInt(min)){
			layer.msg('最高工资必须大于最低工资！', 2, 8);return false;
		}
	}
	if($.trim($("#type").val())==''){
		layer.msg('请选择工作性质！', 2, 8);return false;
	}
	var phone=$.trim($("#telphone").val());
	if(phone==""){
		layer.msg('请填写手机号码！', 2, 8);return false; 
	}else if(!isjsMobile(phone)){
		layer.msg('手机格式不正确！', 2, 8);return false; 
	}
	var email=$.trim($("#email").val());
	var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;  
	if(email!="" && !myreg.test(email)){
		layer.msg('邮箱格式不正确！', 2, 8);return false; 
	}	
	if($.trim($("#report").val())==''){
		layer.msg('请选择到岗时间！', 2, 8);return false;
	}
	var content=$.trim($("#content").val());
	if(content==""){
		layer.msg('推荐描述不能为空！', 2, 8);return false; 
	}
}
//收藏猎头职位 type:普通职位 1 ，公司发布的猎头职位 2，猎头发布的职位 3
function fav_hjob(id){
	layer.load('执行中，请稍候...',0);  
	$.post(weburl+"/lietou/index.php?c=favjob",{id:id},function(data){
		layer.closeAll();
		var data=eval('('+data+')');
		if(data.state=='0'){
			showlogin(1);
			return false; 
		}else if(data.state=='3'){
			layer.msg('您已收藏过该职位！', 2,8);return false;
		}else if(data.state=='1'){
			$("#ltjob"+id).addClass("job_resp_collect_have");
			$("#ltjob"+id).html("已收藏");
			layer.confirm('收藏成功，是否返回个人中心？', function(){ window.location.href =weburl+"/member/index.php?c=favorite"; window.event.returnValue = false;return false; }); 
		}else if(data.state=='4'){
			layer.msg('对不起，您不是个人用户，无法收藏职位！', 2,8);return false;  
		}
	});

}
//关注
function ltatn(id, type) {
     
	if(id){
		layer.load('执行中，请稍候...',0);  
	    $.post(weburl + "/index.php?m=ajax&c=atn", { id: id ,type : type}, function (data) {
			layer.closeAll(); 
			var data=eval('('+data+')');
			if(data.errcode == '2'){
				layer.msg(data.msg, 2,8);return false;
			}else{
				layer.msg(data.msg, 2,9, function(){
					window.location.reload();
				});return false;
			} 
		});
	}

}
//委托简历
function entrust(uid,name){
	layer.load('执行中，请稍候...',0);  
	$.post(weburl+"/index.php?m=ajax&c=entrust",{uid:uid,name:name},function(data){
		layer.closeAll();
		var data=eval('('+data+')');
		if(data.errcode==3){
			layer.msg(data.msg, 2,9);return false;
		}else{
			layer.msg(data.msg, 2,8);return false;
		}
	})
}
function send_msg(){
	var fid=$("#fid").val();
	var content=$.trim($("#content").val());
	if(content==""){ 
		layer.msg('内容不能为空！', 2,8);return false;
	}
	layer.load('执行中，请稍候...',0);  
	$.post(weburl+"/lietou/index.php?c=send_msg",{content:content,fid:fid},function(data){  
		layer.closeAll();
		if(data=='-1'){
			layer.msg('请先登录！', 2,8);return false;
		}else if(data>'1'){
			layer.msg('发私信成功！', 2,9);return false;
		} else{
			layer.msg('发私信失败！', 2,8);return false;
		}
	})
}

function ypjob(type,uid,job_id){
	if(uid==""){ 
		layer.msg('您还没有登录！', 2,8);return false;
	}else{
		layer.confirm('确定申请该职位吗？', function(){
			layer.load('执行中，请稍候...',0);  
			$.post(weburl+"/index.php?m=ajax&c=yqjob",{type:type,job_id:job_id},function(data){
				layer.closeAll();
				var data=eval('('+data+')');
				layer.msg(data.msg, 2,data.errorcode,function(){location.reload();});return false; 
			})
		});
	}
}
function showImgDelay(imgObj, imgSrc, maxErrorNum) {
    if (maxErrorNum > 0) {
        imgObj.onerror = function () {
            showImgDelay(imgObj, imgSrc, maxErrorNum - 1);
        };
        setTimeout(function () {
            imgObj.src = imgSrc;
        }, 500);
        maxErrorNum = parseInt(maxErrorNum) - parseInt(1);
    }
}
 
//分享：qq空间、新浪、腾讯微博、人人网，type: qq,sina,qqwb,renren
function shareTO(type,title){ 
	var tip =  '赶紧分享给您的朋友吧。';
	var info = webname+' -- ' + '“'+ title + '”'+ '（来自'+ weburl + ')。  ';
	switch(type){
		case 'qq':
			 var href = 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?title=' + encodeURIComponent(info + tip) + '&summary=' + encodeURIComponent(info + tip) + '&url=' + encodeURIComponent(window.location.href);
			break;
		case 'sina':
			var href = 'http://service.weibo.com/share/share.php?title=' + encodeURIComponent(info + tip) + '&url=' + encodeURIComponent(window.location.href) + '&source=bookmark';
			break;
		case 'renren':
			 var href = 'http://share.renren.com/share/buttonshare.do?link=' + encodeURIComponent(window.location.href) + '&title==' + encodeURIComponent(info + tip);
			break;
	}
	// window.open(href);  
	window.location = href;  
} 