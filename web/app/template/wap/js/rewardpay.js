function getStatus(rewardid, status) {
	if(status == '2') {
		window.location.href = 'index.php?c=rewardinvite&rewardid=' + rewardid;
		
	} else if(status == '26') {
		window.location.href = 'index.php?c=arb&rewardid=' + rewardid;
		
	} else {
		$.post('index.php?c=logstatus', {
			rewardid: rewardid,
			status: status
		}, function(data) {
			var data = eval('(' + data + ')');
			if(data.error == 'ok') {

				showToast('操作成功', 2, function() {
					location.reload(true);
				});
			} else {
				showToast(data.error, 3);
			}
		});
	}
}

function invite() {

	var rewardid = $('#rewardid').val();
	var jobid = $('#jobid').val();
	var linkman = $('#linkman').val();
	var linktel = $('#linktel').val();
	var intertime = $('#intertime').val();
	var address = $('#address').val();
	var content = $('#content').val();
	if(linkman == '') {
		showToast('请填写联系人！', 2);
		return false;
	}
	if(linktel == '') {
		showToast('请填写联系人电话！', 2);
		return false;
	}
	if(intertime == '') {
		showToast('请选择面试日期！', 2);
		return false;
	}
	if(address == '') {
		showToast('请填写面试地址！', 2);
		return false;
	}
	$.post('index.php?c=logstatus', {
		rewardid: rewardid,
		status: 2,
		linkman: linkman,
		linktel: linktel,
		intertime: intertime,
		address: address,
		content: content
	}, function(data) {
		var data = eval('(' + data + ')');
		if(data.error == 'ok') {

			showToast('操作成功', 2, function() {
				window.location.href = 'index.php?c=rewardlog&jobid=' + jobid;
			});
		} else {
			showToast(data.error, 2);
		}
	});

}

function withdraw_form() {
	var price = $("#price").val();
	var real_name = $("#real_name").val();
	if(!real_name) {
		showToast('请填写真实姓名！', 2);
		return false;
	}
	if(Number(price) < 1) {
		showToast('请正确填写提现金额！', 2);
		return false;
	}

	$.post('index.php?c=withdraw', {
		real_name: real_name,
		price: price,
	}, function(data) {
		var data = eval('(' + data + ')');
		showToast(data.msg, 2, function() {
			window.location.href = data.url;
		});
	});
	return true;
}

function change_form(){
	var changeprice = $('#changeprice').val();
	if(changeprice == ''){
		showToast('请正确填写转换金额！');return false;
	}
	if (changeprice >= 0 && changeprice < minchangeprice) {
		$("#changeprice").val(minchangeprice);
		$("#changeintegral").val(proportion * minchangeprice);
		$("#payintegral").html(proportion * minchangeprice);
		showToast('转换金额不能小于'+minchangeprice+'元,请重新填写 ！');
		return false;
	}
	var changeintegral = $("#changeintegral").val();
	showLoading();
	$.post('index.php?c=saveChange',{changeprice: changeprice, changeintegral: changeintegral}, function(data){
		hideLoading();
		if(data){
			var res = JSON.parse(data);
			if(res.url){
				showToast(res.msg, 2, function(){
					window.location.href = res.url;
				})
			}else{
				showToast(res.msg);
			}
		}
	})
}


function arb_form() {
	var content = $("#content").val();
	
	if(!content) {
		showToast('请填写仲裁原因！', 2);
		return false;
	}
	return true;
}


(function() {
	var rewararbsubmit = document.getElementById('rewararb');
	if (rewararbsubmit){
		rewararbsubmit.addEventListener('tap', function(event) {
			var preview = $.trim(document.getElementById('arbpic').value);
		
			formData.append('preview', preview);

			formData.append('submit', 1);

			showLoading()
			$.ajax({
				url: "index.php?c=arb",
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
		}, false)
	}
})();
