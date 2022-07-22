// JavaScript Document
function atnxjh(id,comid){
	layer.load('执行中，请稍候...',0);  
	$.post(weburl+'/school/index.php?c=atnxjh',{id:id,comid:comid},function(data){
		layer.closeAll('loading');
		var data=eval('('+data+')');
		if(data.status==9){
			layer.msg(data.msg,2,9,function(){window.location.reload();});return false;
		}else{
			layer.msg(data.msg,2,8);return false;
		}
	});
} 
function reportxjh(id,uid,name){
	$("#id").val(id);
	$("#x_uid").val(uid);
	$("#c_name").val(name);
	$.layer({
		type : 1,
		title :'我要报错', 
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['500px','350px'],
		page : {dom :"#xjhreport"}
	});
}
function xjhSub(img){
	var authcode=$("#report_authcode").val();
	var e_reason=$("#e_reason").val();
	var r_reason=$("#r_reason").val();
	var x_uid=$("#x_uid").val();
	var id=$("#id").val();
	var c_name=$("#c_name").val();
	if($.trim(e_reason)==""){
		layer.msg('请填写错误宣讲会信息！',2,8);return false;
	}
	if($.trim(r_reason)==""){
		layer.msg('请填写正确的宣讲会信息！',2,8);return false;
	}
	if($.trim(authcode)==""){
		layer.msg('请填写验证码！',2,8);return false;
	}
	var i = layer.load('执行中，请稍候...',0);  
	$.post(weburl+"/school/index.php?c=report",{authcode:authcode,e_reason:e_reason,r_reason:r_reason,id:id,c_name:c_name,x_uid:x_uid},function(data){
		layer.close(i);
		if(data==1){
			layer.msg('验证码不正确！',2,8,function(){checkCode(img);});
		}else if(data==2){
			layer.msg('您已报错过该宣讲会！',2,8,function(){checkCode(img);});
		}else if(data==3){
			layer.closeAll();
			layer.msg('提交成功！',2,9);
		}else if(data==4){
			layer.msg('提交失败！',2,8,function(){checkCode(img);});
		}
	})
}