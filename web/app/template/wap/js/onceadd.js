
function oncesubmit(){
	var title = $.trim(document.getElementById('title').value),
		salary = $.trim(document.getElementById('salary').value),
		provinceid = $.trim(document.getElementById('provinceid').value),
		cityid = $.trim(document.getElementById('cityid').value),
		three_cityid = $.trim(document.getElementById('three_cityid').value),
		address = $.trim(document.getElementById('address').value),
		content = $.trim($("#content").val()),
		companyname = $.trim(document.getElementById('companyname').value),
		linkman = $.trim(document.getElementById('linkman').value),
		phone = $.trim(document.getElementById('phone').value),
		edate = $.trim(document.getElementById('edate').value),
		password = $.trim(document.getElementById('password').value),
		preview = $.trim(document.getElementById('preview').value),
		id = $.trim(document.getElementById('id').value),
		
		checkcode,
		verify_token;

		if(!id || id == '') {
			id = 0;
		} else {
			id = id;
		}

		if(!pic || pic == '') {
			pic = '';
		} else {
			pic = pic;
		}
		if(title == '') {
			return showToast('请填写招聘名称！');
		}
		if(salary == '') {
			return showToast('请填写工资！');
		}
		var cionly ='';
		if(ct.length<=0 || ct=='new Array()'){
			cionly = '1';
		}
		if(cionly == '1'){
			if(provinceid == '') {
				return showToast('请选择工作地区！');
			}
		}else{
			if(cityid == '') {
				return showToast('请选择工作地区！');
			}
		}
		
		if(address == '') {
			return showToast('请填写详细地址！');
		}
		if(content == '') {
			return showToast('请填写招聘要求！');
		}
		if(companyname == '') {
			return showToast('请填写店面名称！');
		}
		if(linkman == '') {
			return showToast('请填写联系人！');
		}
		if(phone == '') {
			return showToast('请填写联系电话！');
		}
		if(isjsMobile(phone) == false) {
			return showToast('请注意联系电话格式！');
		}
		if(exitsid("moblie_code")){
			var moblie_code = $("#moblie_code").val();
			if(moblie_code == ''){
				return showToast('请填写短信验证码！');			
			}
			formData.append('moblie_code', moblie_code);
		}
		
		if(edate == '') {
			return showToast('请填写招聘有效期！');
		}
		if(password == '') {
			return showToast('请填写密码！');
		}
		if(code_web.indexOf("店铺招聘")>=0) {
			if(code_kind == 1) {
				var code = $('#checkcode').val();
				if(code == '') {
					return showToast('请填写验证码！');
				}
			}else if(code_kind > 2) {
				$("#bind-captcha").attr('data-id','oncesubmit');
				$("#bind-captcha").attr('data-type','click');
				verify_token = $('input[name="verify_token"]').val();

				if(verify_token == '') {
					$("#bind-submit").trigger("click");
					return false; 
				}
			}
		}
		formData.append('title', title);
		formData.append('title', title);
		formData.append('salary', salary);
		formData.append('provinceid', provinceid);
		formData.append('cityid', cityid);
		formData.append('three_cityid', three_cityid);
		formData.append('address', address);
		formData.append('companyname', companyname);
		formData.append('linkman', linkman);
		formData.append('phone', phone);
		formData.append('require', content);
		formData.append('edate', edate);
		formData.append('password', password);
		formData.append('preview', preview);
		formData.append('id', id);

		if(code_web.indexOf("店铺招聘") >= 0){
			if(code_kind == 1){
				formData.append('authcode', code);
			}else if(code_kind > 2){
			
				formData.append('verify_token', verify_token);
			}
		}
		formData.append('submit', 1);
		showLoading();
		$.ajax({
			url: "index.php?c=once&a=add",
			type: 'post',
			data: formData,
			contentType: false,
			processData: false,
			dataType: 'json',
			success: function(res) {
				hideLoading();
				var res = JSON.stringify(res);
				var data = JSON.parse(res);
				if(data.url) {
					showToast(data.msg, 2, function() {
						location.href = data.url;
					});
				} else {
					checkCode('vcode_img');
					showToast(data.msg, 2);
					return false;
				}
			}
		})
}