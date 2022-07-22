function getshow(divid,title,linktel,id){
	$("#linktel").val(linktel);
	$("#telid").val(id);
	$.layer({
		type : 1,
		title :title,
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['500px','auto'],
		page : {dom :"#"+divid}
	});
}
function sendmoblie(img){
	if($("#send").val()=="1"){
		return false;
	}
	var moblie=$("#linktel").val();
	if(moblie==''){
		layer.msg('手机号不能为空！',2,8);return false;
	}else if(!isjsMobile(moblie)){
		layer.msg('手机号码格式错误！',2,8);return false;
	}
	var pcode=$("input[name=img_code]").val();
	if(pcode==""){
		layer.msg('验证码不能为空！',2,8);return false;
	}
	var i=loadlayer();
	$.ajaxSetup({cache:false});
	$.post(weburl+"/member/index.php?m=ajax&c=mobliecert", {str:moblie,pcode:pcode},function(data) {
		layer.close(i);
		if(data){
			var res = JSON.parse(data);
			var icon = res.error == 1 ? 9 : 8;
			layer.msg(res.msg, 2, icon, function(){
				if(res.error == 1){
					send(121); 
				}else if(res.error == 106){
					checkCode(img);
				}
			});
		}
	})
}
function send(i){
	i--;
	if(i==-1){
		$("#time").html("重新获取");
		$("#send").val(0)
	}else{
		$("#send").val(1)
		$("#time").html(i+"秒");
		setTimeout("send("+i+");",1000);
	}
}
function telstatus(){
	var id = $('#telid').val();
	var linktel = $('#linktel').val();
	
	if(linktel==""){ 
		layer.msg('请输入手机号码！',2,8);
		return false;
	}
	var code=$("#moblie_code").val();
	if(code==""){ 
		layer.msg('请输入短信验证码！',2,8);
		return false;
	}
	
	var i=loadlayer();
	$.ajaxSetup({cache:false});
	$.post("index.php?c=talent&act=telstatus",{id:id,linktel:linktel,code:code},function(data){
		layer.close(i);
		data = eval('('+data+')');
		if(data.error=='1'){
			
			layer.msg('授权认证成功！',2,9,function(){location.reload();}); 
			
		}else{
			layer.msg(data.msg,2,8); 
		}
	})
}

