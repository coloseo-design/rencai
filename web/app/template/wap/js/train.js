function collect_subject(id, url) {
	showLoading()
	$.post(url, {
		id: id
	}, function(data) {
		hideLoading(); 
		if(data == "-3") {
			showToast('您还没有登录，请先登录！');
		} else if(data == "-1") {
			showToast('只有个人用户和hr才可以收藏！');
		} else if(data == "-2") {
			showToast('没有该课程！');
		} else if(data == "0") {
			showToast('您已经收藏过该课程！');
		} else {
			showToast('收藏成功！', 2, function() {
				location.reload(true);
			});
		}
	})
}


function check_baoming(target_form) {
	var name = $("#name").val();
	var phone = $("#bmphone").val();
	var content = $("#bmcontent").val();
	var s_uid = $("#baoming_s_uid").val();
	var sid = $("#baoming_sid").val();
	var submit = $("#submit").val();
	var isprice = $("#isprice").val();
	var price = $("#price").val();

	if(name == "") {
		showToast('姓名不能为空！');
		return false;
	}
	var phoneset = isjsMobile(phone);
	if(phone == "") {
		showToast('电话不能为空！');
		return false;
	} else if(phoneset == false && isjsTell(phone) == false) {
		showToast('电话格式错误！');
		return false;
	}
	if(content == "") {
		showToast('留言不能为空！');
		return false;
	}
	// post2ajax(target_form);
	$.post(wapurl+"/index.php?c=train&a=baoming",{
		name:name,
		phone:phone,
		content:content,
		s_uid:s_uid,
		sid:sid,
		isprice: isprice,
		price: price,
		submit:submit,
	},function(data){
		hideLoading();
		var data=eval('('+data+')');
		if(data.error==0){
			showToast(data.msg,2,function(){
				window.location.href = data.url;
			});
			return false;
		}else {
			showToast(data.msg,2);
			return false;
		}
	});	
	return false;
}

function check_con() {
	var content = $("#content").val();
	if(content == "我想参加这个培训班，请尽快跟我联系。") {
		$("#content").val('');
	}
}

function over_con() {
	var content = $("#content").val();
	if(content == "") {
		$("#content").val('我想参加这个培训班，请尽快跟我联系。');
	}
}


function check_zixun(target_form) {
	var phone = $("#phone").val();
	var content = $("#content").val();
	var s_uid = $("#s_uid").val();
	var sid = $("#sid").val();
	if(phone == "") {
		showToast('电话不能为空！' + phone);
		return false;
	}
	var reg_phone = (/^[1][3456789]\d{9}$|^([0-9]{3,4})[-]?[0-9]{7,8}$/);
	if(!reg_phone.test(phone)) {
		showToast('请正确填写联系电话');
		return false;
	}
	if(content == "") {
		showToast('内容不能为空！');
		return false;
	}
	// post2ajax(target_form);
	$.post(wapurl+"/index.php?c=train&a=zixun",{
		name:name,
		phone:phone,
		content:content,
		s_uid:s_uid,
		sid:sid,
		submit:'提交',
		
	},function(data){
		hideLoading();
		var data=eval('('+data+')');
		if(data.error==0){
			showToast(data.msg,2,function(){
				window.location.reload();
			});
			return false;
		}else {
			showToast(data.msg,2);
			return false;
		}
	});	

	return false;
}
$(document).ready(function() {
	$("#ckcontent").click(function() {
		var obj = $("#contentshow").css('display');
		if(obj == 'none') {
			$("#contentshow").show();
			$("#contenthide").hide();
			$("#ckcontent").html('展开查看更多');
		} else {
			$("#contentshow").hide();
			$("#contenthide").show();
			$("#ckcontent").html('收起');
		}
	});
});

function cktrain(type) {
	var val = $("#" + type).find("option:selected").text();
	$('.' + type).html(val);
}

