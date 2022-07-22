function toDate(str) {
	var sd = str.split("-");
	return new Date(sd[0], sd[1], sd[2]);
}
//关注
function ltatn(id, type) {
	 
	if(id) {
		showLoading()
		$.post(wapurl + "/index.php?c=ajax&a=atn", {id: id, type: type}, function(data) {
			hideLoading();
			var data =eval('('+data+')');
			if(data.errcode == '3'){
				showToast(data.msg, 2);return false;
			}else{
				showToast(data.msg, 2, function(){
					window.location.reload();
				});return false;
			}
		});
	}
}
//猎头发布咨询
function ltmsg(img) {
	var msg_content = $.trim($("#msg_content").val());
	var authcode = $("#msg_CheckCode").val();
	var jobid = $("#jobid").val();
	var job_uid = $("#job_uid").val();
	var com_name = $("#com_name").val();
	var job_name = $("#job_name").val();
	var type	= $("#type").val();
	if(msg_content == '') {
		showToast('咨询内容不能为空！');
		return false;
	} else if(authcode == '') {
		showToast('验证码不能为空！');
		return false;
	} else {
		showLoading()
		$.post(wapurl + "/index.php?c=ajax&a=pl", {
			content: msg_content,
			authcode: authcode,
			jobid: jobid,
			job_uid: job_uid,
			com_name: com_name,
			job_name: job_name,
			type: type
		}, function(data) {
			hideLoading();
			if(data == 0) {
				showToast('只有个人用户才可以关注！');
				return false;
			} else if(data == 1) {
				showToast('留言成功！', 2, function() {
					location.reload(true);
				});
				return false;
			} else if(data == 2) {
				showToast('咨询内容不能为空！');
				return false;
			} else if(data == 3) {
				showToast('您还没有登录！');
				return false;
			} else if(data == 4) {
				showToast('验证码不能为空！');
				return false;
			} else if(data == 5) {
				showToast('验证码错误！', 2, function() {
					checkCode(img);
				});
				return false;
			} else if(data == 6) {
				showToast('咨询失败！');
				return false;
			} else if(data == 7) {
				showToast('该企业暂不接受相关咨询！');
				return false;
			}

		});
	}
}
//申请职位
function ypjob(type, uid, job_id) {
	if(uid == "") {
		showToast('您还没有登录！');
		return false;
	} else {
		showLoading()
		$.post(wapurl + "/index.php?c=ajax&a=yqjob", {
			type: type,
			job_id: job_id
		}, function(data) {
			hideLoading();
			var data = eval('(' + data + ')');
			showToast(data.msg, 2, function() {
				location.reload(true);
			});
			return false;
		})
	}
}
//收藏猎头职位 type:普通职位 1 ，公司发布的猎头职位 2，猎头发布的职位 3
function fav_hjob(id) {
	showLoading()
	$.post(wapurl + "/index.php?c=post&a=favjob", {
		id: id
	}, function(data) {
		hideLoading();
		var data=eval('('+data+')');
		if(data.state == '1') {
			showToast('收藏成功！', 2, function() {
				location.reload(true);
			});
		} else {
			showToast(data.msg);
			return false;
		}
	});
}
//推荐人才
function ltrecuser() {
	var uid = $.trim(document.getElementById('uid').value);
	var job_uid =$.trim( document.getElementById('job_uid').value);
	var job_id = $.trim(document.getElementById('job_id').value);
	var name = $.trim(document.getElementById('name').value);
	var content = $.trim(document.getElementById('content').value);
	var phone = $.trim(document.getElementById('phone').value);
	var hy = $.trim(document.getElementById('hy').value);
	
	var provinceid = $.trim(document.getElementById('provinceid').value);
	var cityid = $.trim(document.getElementById('cityid').value);
	var three_cityid = $.trim(document.getElementById('three_cityid').value);
	var minsalary = $.trim($("#minsalary").val());
	var maxsalary = $.trim($("#maxsalary").val());
	var type = $.trim(document.getElementById('type').value);
	var report = $.trim(document.getElementById('report').value);
	var birthday = $.trim(document.getElementById('birthday').value);
	var edu = $.trim(document.getElementById('edu').value);
	var exp = $.trim(document.getElementById('exp').value);
	var email = $.trim(document.getElementById('email').value);
	var sex = $.trim(document.getElementById('sex').value);
	var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	if(name == "") {
		return showToast('姓名不能为空！');
	}
	if(sex == '') {
		return showToast('请选择性别！');
	}
	if(birthday == '') {
		return showToast('请选择出生年月！');
	}
	if(edu == '') {
		return showToast('请选择最高学历！');
	}
	if(exp == '') {
		return showToast('请选择工作经验！');
	}
	if(phone == "") {
		return showToast('手机不能为空！');
	}
	if(!isjsMobile(phone)) {
		return showToast('手机格式不正确！');
	}
	if(email != "" && !myreg.test(email)) {
		return showToast('邮箱格式不正确！');
	}
	if(hy == '') {
		return showToast('请选择从事行业！');
	}
	var jionly ='';
	if(jt.length<=0 || jt=='new Array()'){
		jionly = '1';
	}
	
	if(jionly == '1'){
		var job_post = $.trim(document.getElementById('job1').value);
	}else{
		var job_post = $.trim(document.getElementById('job_post').value);
	}
	if(job_post == '') {
		return showToast('请选择期望职位！');
	}
	var cionly ='';
	if(ct.length<=0 || ct=='new Array()'){
		cionly = '1';
	}
	if(cionly == '1'){
		if(provinceid == '') {
			return showToast('请选择期望城市！');
		}
	}else{
		if(three_cityid == '') {
			return showToast('请选择期望城市！');
		}
	}
	
	if(minsalary == '') {
		return showToast('请填写期望薪资！');
	}
	if(maxsalary) {
		if(parseInt(minsalary) >= parseInt(maxsalary)) {
			return showToast('最低薪资必须小于最高薪资！');
		}
	}
	if(type == '') {
		return showToast('请选择工作性质！');
	}
	if(report == '') {
		return showToast('请选择到岗时间！');
	}
	if(content == "") {
		return showToast('推荐描述不能为空！');
	}
	showLoading()
	$.post('index.php?c=post&a=recusersave', {
		uid: uid,
		job_uid: job_uid,
		job_id: job_id,
		name: name,
		content: content,
		phone: phone,
		hy: hy,
		job_classid: job_post,
		provinceid: provinceid,
		cityid: cityid,
		three_cityid: three_cityid,
		minsalary: minsalary,
		maxsalary: maxsalary,
		type: type,
		report: report,
		birthday: birthday,
		edu: edu,
		exp: exp,
		email: email,
		sex: sex,
		submit: 'submit'
	}, function(data) {
		hideLoading();
		var data=eval('('+data+')');
		if(data.error == '1') {
			showToast(data.msg,2,function(){
				location.reload(true);
			});
			return false;

		} else {
			return showToast(data.msg);
		}
	});
}

//猎头基本信息擅长行业、职位清除
function ltremoves(type) {
	if(type == 'lthy') {
		$("#qw_hy").val("");
	} else if(type == 'ltjob') {
		$("#job").val("");
	}
	$("#" + type + "name").val("请选择");
	$("input[name='" + type + "class']").removeClass('xz');
	$("input[name='" + type + "class']").prop('checked',false);
	$("input[name='" + type + "classone']").prop("checked",false);
	$("input[name='" + type + "classone']").removeAttr("disabled");
}
//猎头基本信息擅长行业、职位确认
function ltrealy(type) {
	var info = "";
	var value = "";
	$("input[name='" + type + "class']:checked").each(function() {
		var obj = $(this).val();
		var name = $(this).attr("data");
		if(info == "") {
			info = obj;
			value = name;
		} else {
			var jclass = $(this).attr("class");
			var rej = jclass.split("jobone")[1];
			if(info.indexOf(rej) < 0) {
				info = info + "," + obj;
				value = value + "," + name;
			}
		}
	})
	$("input[name='" + type + "classone']:checked").each(function() {
		obj = $(this).val();
		name = $(this).attr("data");
		if(info == "") {
			info = obj;
			value = name;
		} else {
			var oneclass = $(this).attr("class");
			var ret = oneclass.split("one")[1];
			if(info.indexOf(ret) < 0) {
				info = info + "," + obj;
				value = value + "," + name;
			}
		}
	})

	if(info == "") {
		showToast("请选择！");
		return false;
	} else {
		if(type == 'lthy') {
			$("#qw_hy").val(info);
		} else if(type == 'ltjob') {
			$("#job").val(info);
		}
		if(type == 'lthy' || type == 'ltjob') {
			$("#" + type + "name").html(value);
		}

		$("#" + type + "name").val(value);
		Closes(type);
	}
}
//猎头基本信息擅长行业、职位选择
function ltchecked_input(id, type) {
	if(type == 'lthy') {
		if($("#r" + id).is(':checked')) {
			$("#r" + id).addClass('xz');
			$(".one" + id).removeClass('xz');
			$(".one" + id).attr('checked', true);
			$(".one" + id).attr('disabled', 'disabled');
		} else {
			$("#r" + id).removeClass('xz');
			$(".one" + id).attr('disabled', false);
			$(".one" + id).attr('checked', false);
		}
	} else if(type == 'ltjob') {
		if($("#j" + id).is(':checked')) {
			$("#j" + id).addClass('xzj');
			$(".jobone" + id).removeClass('xzj');
			$(".jobone" + id).attr('checked', false);
			$(".jobone" + id).attr('disabled', 'disabled');
		} else {
			$("#j" + id).removeClass('xzj');
			$(".jobone" + id).attr('disabled', false);
			$(".jobone" + id).attr('checked', false);
		}
	}
	//var class_length = $("input[name='"+type+"class']:checked").length;
	/*if((class_length)>2){
		showToast('搜索条件过多！',2,function(){
			if(type=='lthy'){
				$("#r"+id).attr("checked",false);
				$(".one"+id).attr("checked",false);
				$(".one"+id).attr('disabled',false);
			}else if(type=='ltjob'){
				$("#j"+id).attr("checked",false);
				$(".jobone"+id).attr("checked",false);
				$(".jobone"+id).attr('disabled',false);
			}
		}); 	
	}*/
	var r_length = $(".xz").length;
	if(r_length > 5) {
		showToast('您最多只能选择五个！', 2, function() {
			$("#r" + id).attr("checked", false);
			$("#r" + id).removeClass('xz');
		})
	}
	var j_length = $(".xzj").length;
	if(j_length > 5) {
		showToast('您最多只能选择五个！', 2, function() {
			$("#j" + id).attr("checked", false);
			$("#j" + id).removeClass('xzj');
		})
	}
}

$(function() {
	var ltjobsubmit = document.getElementById('ltjobsubmit');
	if(ltjobsubmit) {
		ltjobsubmit.addEventListener('tap', function(event) {
			var job_name = $.trim($("#job_name").val()),
    			r_status = $.trim($("#r_status").val()),
				jobone = $.trim($("#jobone").val()),
				jobtwo = $.trim($("#jobtwo").val()),
				provinceid = $.trim($("#provinceid").val()),
				cityid = $.trim($("#cityid").val()),
				three_cityid = $.trim($("#three_cityid").val()),
				minsalary = $.trim($("#minsalary").val()),
				maxsalary = $.trim($("#maxsalary").val()),
				job_desc = $.trim($("#contenttext").val()),
				eligible = $.trim($("#eligibletext").val()),
				department = $.trim($("#department").val()),
				exp = $.trim($("#exp").val()),
				report = $.trim($("#report").val()),
				age = $.trim($("#age").val()),
				sex = $.trim($("#sex").val()),
				edu = $.trim($("#edu").val()),
				language = $.trim($("#lang").val()),
				constitute = $.trim($("#constitute").val()),
				welfare = $.trim($("#welfare").val()),
				rebates = $.trim($("#rebates").val()),
				other = $.trim($("#othertext").val()),
				com_name = $.trim($("#com_name").val()),
				pr = $.trim($("#pr").val()),
				hy = $.trim($("#hy").val()),
				mun = $.trim($("#mun").val()),
				desc = $.trim($("#desc").val()),
				id = $.trim($("#id").val());

			if($.trim($("#job_name").val()) == "") {
				return showToast("请输入职位名称");

			}
			if($.trim($("#jobtwo").val()) == "") {
				return showToast("请选择职位分类");

			}
			var cionly ='';
			if(ct.length<=0 || ct=='new Array()'){
				cionly = '1';
			}
			if(cionly == '1'){
				if(provinceid == '') {
					return showToast('请选择工作地点');
				}
			}else{
				if($.trim($("#cityid").val()) == "") {
					return showToast("请选择工作地点");

				}
			}
			
			var job_desc = $.trim($("#contenttext").val());
			if(job_desc == "") {
				return showToast("请输入任职描述");

			}
			var eligible = $.trim($("#eligibletext").val());
			if(eligible == "") {
				return showToast("请输入任职资格");

			}
			if($.trim($("#department").val()) == "") {
				return showToast("请输入所属部门");

			}
			if($.trim($("#report").val()) == "") {
				return showToast("请输入汇报对象");

			}
			var min = $.trim($("#minsalary").val());
			var max = $.trim($("#maxsalary").val());

			if(min == "" || min == "0") {
				return showToast("请填写职位年薪");

			}
			if(max && parseInt(max) <= parseInt(min)) {
				return showToast("最高年薪必须大于最低年薪");

			}
			var constitute = [];
			$('input[name="xzgc"]:checked').each(function() {
				constitute.push($(this).val());
			});
			if(constitute.length == 0) {
				return showToast("请选择薪资构成！", 2);

			}
			var welfare = [];
			$('input[name="fldy"]:checked').each(function() {
				welfare.push($(this).val());
			});

			if($.trim($("#age").val()) < 1) {
				return showToast("请选择年龄要求");

			}
			if($.trim($("#sex").val()) < 1) {
				return showToast("请选择性别要求");

			}
			if($.trim($("#exp").val()) < 1) {
				return showToast("请选择工作经验");

			}

			if($.trim($("#edu").val()) < 1) {
				return showToast("请选择学历要求");
			}
			var language = [];
			$('input[name="yyyq"]:checked').each(function() {
				language.push($(this).val());
			});
			if($.trim($("#com_name").val()) == "") {
				return showToast("请输入公司名称");
			}
			if($.trim($("#pr").val()) < 1) {
				return showToast("请选择公司性质");
				return false;
			}
			if($.trim($("#hy").val()) < 1) {
				return showToast("请选择所属行业");
				return false;
			}
			if($.trim($("#mun").val()) < 1) {
				return showToast("请选择公司规模");
			}
			if($.trim($("#desc").val()) == "") {
				return showToast("请输入公司介绍");
			}

			var sql = {
        r_status:r_status,
				job_name: job_name,
				jobone: jobone,
				jobtwo: jobtwo,
				provinceid: provinceid,
				cityid: cityid,
				three_cityid: three_cityid,
				minsalary: minsalary,
				maxsalary: maxsalary,
				department: department,
				job_desc: job_desc,
				constitute: constitute,
				welfare: welfare,
				exp: exp,
				report: report,
				age: age,
				sex: sex,
				edu: edu,
				eligible: eligible,
				rebates: rebates,
				other: other,
				language: language,
				com_name: com_name,
				pr: pr,
				hy: hy,
				mun: mun,
				desc: desc,
				id: id,
				submit: 'submit'
			}

			document.getElementById('ltjobsubmit').value = "提交中...";
			document.getElementById('ltjobsubmit').id = "submit";
			$.post('index.php?c=jobadd', sql, function(data) {
				showToast(data.msg, 2, function() {
					location.href = data.url;
				});
			}, 'json');
		})
	}

})

function send_ltmsg() {
	var fid = $("#fid").val();
	var content = $.trim($("#content").val());
	if(content == "") {
		showToast('内容不能为空！');
		return false;
	}
	showLoading();
	$.post(wapurl + "index.php?c=post&a=send_ltmsg", {
		content: content,
		fid: fid
	}, function(data) {
		hideLoading();
		if(data == '-1') {
			showToast('请先登录！');
			return false;
		} else if(data > '1') {
			showToast('发私信成功！');
			return false;
		} else {
			showToast('发私信失败！');
			return false;
		}
	})
}
//委托简历
function entrust(uid, name) {
	showLoading();
	$.post(wapurl + "index.php?c=ajax&a=entrust", {
		uid: uid,
		name: name
	}, function(data) {
		hideLoading();
		var data =eval('('+data+')');
		if(data.errcode== 1) {
			showToast('您不是个人用户！');
			return false;
		} else if(data.errcode== 2) {
			showToast('您已经委托过简历给该猎头！');
			return false;
		} else if(data.errcode== 3) {
			showToast('委托简历成功！');
			return false;
		} else if(data.errcode== 4) {
			showConfirm('先完善简历，成为优质人才以后才可以申请猎头帮您找到合适的工作！',function(){
				window.location.href=wapurl+"member/index.php?c=resume";
			});

 			return false;
		}  
	})
}

if(typeof ci != "undefined" && typeof ct != "undefined" && typeof cn != "undefined") {
	var cityData = [];
	for(var i = 0; i < ci.length; i++) {
		var city = [];
    var cvlaue = [];
    var ctext = [];
		if(typeof ct[ci[i]] != "undefined"){
			for(var j = 0; j < ct[ci[i]].length; j++) {
				var threecity = [];
       
				if(ct[ct[ci[i]][j]]) {
          
					for(var k = 0; k <=ct[ct[ci[i]][j]].length; k++) {            
            if(k==0){
              cvlaue='0';
              ctext='全部';
            }else{
              t=k-1;
              cvlaue=	ct[ct[ci[i]][j]][t];
              ctext=	cn[ct[ct[ci[i]][j]][t]];
            }
            threecity.push({
              value: cvlaue,
							text: ctext
						})
					}
				}
				city.push({
				
          value: ct[ci[i]][j],
					text: cn[ct[ci[i]][j]],
					children: threecity
				})
			}
		}
		
		cityData.push({
			value: ci[i],
			text: cn[ci[i]],
			children: city
		})
	}
}
if(typeof ji != "undefined" && typeof jt != "undefined" && typeof jn != "undefined") {
	var jobData = [];
	for(var i = 0; i < ji.length; i++) {
		var job_son = [];
		if(typeof jt[ji[i]] != "undefined"){
		
			for(var j = 0; j < jt[ji[i]].length; j++) {
				var job_post = [];
				if(jt[jt[ji[i]][j]]) {
					for(var k = 0; k < jt[jt[ji[i]][j]].length; k++) {
						job_post.push({
							value: jt[jt[ji[i]][j]][k],
							text: jn[jt[jt[ji[i]][j]][k]]
						})
					}
				}
				job_son.push({
					value: jt[ji[i]][j],
					text: jn[jt[ji[i]][j]],
					children: job_post
				})
			}
		}
		
		jobData.push({
			value: ji[i],
			text: jn[ji[i]],
			children: job_son
		})
	}
}
if(typeof mui !== 'undefined'){
	(function($, doc) {
		$.init();
		$.ready(function() {
			//从事行业
			var hyPickerButton = doc.getElementById('hyPicker');
			if(typeof hyData != "undefined" && hyPickerButton) {
				var hyPicker = new $.PopPicker();
				hyPicker.setData(hyData);
				var dhy = hyPickerButton.getAttribute('data-hy');
				if(dhy) {
					hyPicker.pickers[0].setSelectedValue(dhy);
				}
				var hy = doc.getElementById('hy');
				hyPickerButton.addEventListener('tap', function(event) {
					document.activeElement.blur();
					hyPicker.show(function(items) {
						hy.value = items[0].value;
						hyPickerButton.innerText = items[0].text;
					});
				}, false);
			}
			//城市选择
			var cityPickerButton = doc.getElementById('cityPicker');
			if(typeof cityData != "undefined" && cityPickerButton) {
				var cclass = 3;
				if(ct.length<=0 || ct=='new Array()'){
					cclass = 1;
				}
				var cityPicker = new $.PopPicker({
					layer: cclass
				});
				cityPicker.setData(cityData);
				var provinceid = cityPickerButton.getAttribute('data-provinceid'),
					cityid = cityPickerButton.getAttribute('data-cityid'),
					three_cityid = cityPickerButton.getAttribute('data-three_cityid');
				if(provinceid) {
					cityPicker.pickers[0].setSelectedValue(provinceid);
				}
				if(cityid) {
					setTimeout(function() {
						if(cityPicker.pickers[1]){
							cityPicker.pickers[1].setSelectedValue(cityid);
						}
						
					}, 200);
				}
				if(three_cityid) {
					setTimeout(function() {
						if(cityPicker.pickers[2]){
							cityPicker.pickers[2].setSelectedValue(three_cityid);
						}
					}, 400);
				}
				cityPickerButton.addEventListener('tap', function(event) {
					document.activeElement.blur();
					cityPicker.show(function(items) {
	
						doc.getElementById('provinceid').value = items[0].value;
						if(items[1]){
							doc.getElementById('cityid').value = items[1].value;
						}
						if(items[2]){
							doc.getElementById('three_cityid').value = items[2].value;
						}
						var html = items[0].text;
						
						if(items[1]){
							html = html + " " + items[1].text;
						}
						if(items[2] && items[2].text!='全部' && items[2].value!=0){
				            html += items[2].text ? " " + items[2].text : '';
				        }
						cityPickerButton.innerText = html;
	
					});
				}, false);
			}
			//宣讲会二级城市
			if(typeof xjhcityData != "undefined" && cityPickerButton) {
				var cclass = 2;
				if(ct.length<=0 || ct=='new Array()'){
					cclass = 1;
				}
	
				var cityPicker = new $.PopPicker({
					layer: cclass
				});
				var cityschool = [];
				cityPicker.setData(xjhcityData);
				var provinceid = cityPickerButton.getAttribute('data-provinceid'),
					cityid = cityPickerButton.getAttribute('data-cityid');
				if(provinceid) {
					cityPicker.pickers[0].setSelectedValue(provinceid);
				}
				if(cityid) {
					setTimeout(function() {
						if(cityPicker.pickers[1]){
							cityPicker.pickers[1].setSelectedValue(cityid);
						}
						
					}, 200);
				}
				cityPickerButton.addEventListener('tap', function(event) {
					document.activeElement.blur();
					cityPicker.show(function(items) {
						doc.getElementById('provinceid').value = items[0].value;
						if(items[1]){
							doc.getElementById('cityid').value = items[1].value;
						}
						var html = items[0].text;
	
						if(items[1]){
							html +=" " + items[1].text
						}
						cityPickerButton.innerText = html;
						doc.getElementById('schoolPicker').innerText = '请选择';
						cityschool = [];
						$.each(xjhschoolData, function(i, n) {
							if(xjhschoolData[i]['cid'] == items[1].value) {
								cityschool.push(xjhschoolData[i]);
							} 
						});
					});
				}, false);
			}
			
			//宣讲会学校选择
			if(typeof xjhschoolData != "undefined") {
	        var schoolPicker = new $.PopPicker();
	        schoolPicker.setData(xjhschoolData);
	        var schoolPickerBtn = doc.getElementById('schoolPicker');
	        var school = doc.getElementById('schoolid');
	        schoolPickerBtn.addEventListener('tap', function(event) {
	          var id= doc.getElementById('id');
	          var provinceid= doc.getElementById('provinceid');
	          var cityid= doc.getElementById('cityid');
	          if(id.value>0){
	            var sql={
	              provinceid : provinceid.value,
	              cityid : cityid.value,
	              id:id.value
	            };
	            mui.post('index.php?c=xjhcity',sql,function(data) {
	              if(data==1){
	                 schoolPicker.setData(xjhschooltwodata);
	              }else{
	                 schoolPicker.setData(cityschool);
	              }
	            }, 'json');
	   
	          }else{
	            var provinceid= doc.getElementById('provinceid');
	            var cityid= doc.getElementById('cityid');
	            if(provinceid.value>0 && cityid.value>0){
	               schoolPicker.setData(cityschool);
	            }
	          }
	         
	          var schoolPickerBtn = doc.getElementById('schoolPicker');
	          var school = doc.getElementById('schoolid');
	          var schoolid = schoolPickerBtn.getAttribute('data-schoolid');
	          if(schoolid){
	           schoolPicker.pickers[0].setSelectedValue(schoolid);
	          }
	          document.activeElement.blur();
	          schoolPicker.show(function(items) {
						if(items[0].value){
							school.value = items[0].value;
							schoolPickerBtn.innerText = items[0].text;
						}
					});
				}, false);
			}
			//职位类别选择
			var jobPickerButton = doc.getElementById('jobPicker');
			if(typeof jobData != "undefined" && jobPickerButton) {
				var jclass = 3;
				if(jt.length<=0 || jt=='new Array()'){
					var jclass = 1;
				}
				var jobPicker = new $.PopPicker({
					layer: jclass
				});
				jobPicker.setData(jobData);
				var addtype	= jobPickerButton.getAttribute('data-add_type'),
					job1 = jobPickerButton.getAttribute('data-job1'),
					job1_son = jobPickerButton.getAttribute('data-job1_son'),
					job_post = jobPickerButton.getAttribute('data-job_post');
				if(job1) {
					jobPicker.pickers[0].setSelectedValue(job1);
				}
				if(job1_son) {
					setTimeout(function() {
						if(jobPicker.pickers[1]){
							jobPicker.pickers[1].setSelectedValue(job1_son);
						}
						
					}, 100);
				}
				if(job_post) {
					setTimeout(function() {
						if(jobPicker.pickers[2]){
							jobPicker.pickers[2].setSelectedValue(job_post);
						}
						
					}, 300);
				}
				if(jobPickerButton) {
					jobPickerButton.addEventListener('tap', function(event) {
						document.activeElement.blur();
						jobPicker.show(function(items) {
							doc.getElementById('job1').value = items[0].value;
							if(items[1]){
								doc.getElementById('job1_son').value = items[1].value;
							}
							if(items[2]){
								doc.getElementById('job_post').value = items[2].value;
							}
							var item0_text = items[0].text;
							var item1_text = '';
							var item2_text = '';
							if(items[2]){
								var item2_text = items[2].text;
							}
							if(items[1]){
								var item1_text = items[1].text;
							}
							var html = item2_text ? item2_text : (item1_text ? item1_text : item0_text);
							jobPickerButton.innerText = html;
							if(addtype=='jobadd'){
								if(items[2]){
									var sql={
									  id : items[2].value
									};
									mui.post('index.php?c=ajaxjobclass',sql,function(data) {
									if(data==1){
										 document.getElementById('description').style.display='block';
										 document.getElementById('descname').innerText = html;
									  }else{
										 document.getElementById('description').style.display='none';
										 document.getElementById('descname').innerText = '';
									  }
									}, 'json');
								}
								
							}
						});
					}, false);
				}
			}
			//猎头职位类别选择
			if(typeof ltjobData != "undefined") {
				var ltjobPicker = new $.PopPicker({
					layer: 2
				});
				ltjobPicker.setData(ltjobData);
				var ltjobPickerButton = doc.getElementById('ltjobPicker');
				var djobone = ltjobPickerButton.getAttribute('data-jobone'),
					djobtwo = ltjobPickerButton.getAttribute('data-jobtwo');
				if(djobone) {
					ltjobPicker.pickers[0].setSelectedValue(djobone);
				}
				if(djobtwo) {
					setTimeout(function() {
						ltjobPicker.pickers[1].setSelectedValue(djobtwo);
					}, 100);
				}
				ltjobPickerButton.addEventListener('tap', function(event) {
					document.activeElement.blur();
					ltjobPicker.show(function(items) {
						doc.getElementById('jobone').value = items[0].value;
						doc.getElementById('jobtwo').value = items[1].value;
						ltjobPickerButton.innerText = items[1].text;
					});
				}, false);
			}
			//问答类别（不能和城市同时使用）
			var showAskPickerButton = doc.getElementById('showAskPicker');
			if(showAskPickerButton) {
				var askData = [];
				for(var i = 0; i < ai.length; i++) {
					var ask = [];
					if(typeof at[ai[i]] != "undefined") {
					
						for(var j = 0; j < at[ai[i]].length; j++) {
							ask.push({
								value: at[ai[i]][j],
								text: an[at[ai[i]][j]]
							})
						}
					}
					askData.push({
						value: ai[i],
						text: an[ai[i]],
						children: ask
					})
				}
				var askPicker = new $.PopPicker({
					layer: 2
				});
				askPicker.setData(askData);
				var askResult = doc.getElementById('cid');
				showAskPickerButton.addEventListener('tap', function(event) {
					document.activeElement.blur();
					askPicker.show(function(items) {
						askResult.value = items[1].value;
						showAskPickerButton.innerText = items[1].text;
					});
				}, false);
			}
			//公司性质
			var prComPickerButton = doc.getElementById('prComPicker');
			if(prComPickerButton) {
				var prcomPicker = new $.PopPicker();
				prcomPicker.setData(prData);
				var pr = doc.getElementById('pr'),
					dpr = prComPickerButton.getAttribute('data-pr');
				if(dpr) {
					prcomPicker.pickers[0].setSelectedValue(dpr);
				}
				prComPickerButton.addEventListener('tap', function(event) {
					document.activeElement.blur();
					prcomPicker.show(function(items) {
						pr.value = items[0].value;
						prComPickerButton.innerText = items[0].text;
					});
				}, false);
			}
			//企业规模
	        var munComPickerButton = doc.getElementById('munComPicker');
	        if(munComPickerButton) {
	            var muncomPicker = new $.PopPicker();
	            muncomPicker.setData(munData);
	            var mun = doc.getElementById('mun'),
	                dmun = munComPickerButton.getAttribute('data-mun');
	            if(dmun) {
	                muncomPicker.pickers[0].setSelectedValue(dmun);
	            }
	            munComPickerButton.addEventListener('tap', function(event) {
	                document.activeElement.blur();
	                muncomPicker.show(function(items) {
	                    mun.value = items[0].value;
	                    munComPickerButton.innerText = items[0].text;
	                });
	            }, false);
	        }
			//企业联系方式是否公开
			var infostatusComPickerButton = doc.getElementById('infostatusComPicker');
			if(infostatusComPickerButton) {
				var infostatuscomPicker = new $.PopPicker();
				infostatuscomPicker.setData(infostatusData);
				var infostatus = doc.getElementById('infostatus'),
					dinfostatus = infostatusComPickerButton.getAttribute('data-infostatus');
				if(dinfostatus) {
					infostatuscomPicker.pickers[0].setSelectedValue(dinfostatus);
				}
				infostatusComPickerButton.addEventListener('tap', function(event) {
					document.activeElement.blur();
					infostatuscomPicker.show(function(items) {
						infostatus.value = items[0].value;
						infostatusComPickerButton.innerText = items[0].text;
					});
				}, false);
			}
			//企业注册资金
			var moneytypeComPickerButton = doc.getElementById('moneytypeComPicker');
			if(moneytypeComPickerButton) {
				var moneytypecomPicker = new $.PopPicker();
				moneytypecomPicker.setData(moneytypeData);
				var moneytype = doc.getElementById('moneytype'),
					dmoneytype = moneytypeComPickerButton.getAttribute('data-moneytype');
				if(dmoneytype) {
					moneytypecomPicker.pickers[0].setSelectedValue(dmoneytype);
				}
				moneytypeComPickerButton.addEventListener('tap', function(event) {
					document.activeElement.blur();
					moneytypecomPicker.show(function(items) {
						if(items[0].value == 2) {
							$('.moneyname')[0].innerHTML = '万美元';
						} else {
							$('.moneyname')[0].innerHTML = '万元';
						}
						moneytype.value = items[0].value;
						moneytypeComPickerButton.innerText = items[0].text;
					});
				}, false);
			}
			//招聘人数
			if(typeof numberData != "undefined") {
				var numberPicker = new $.PopPicker();
				numberPicker.setData(numberData);
				var numberPickerBtn = doc.getElementById('numberPicker'),
					number = doc.getElementById('number'),
					dnumber = numberPickerBtn.getAttribute('data-number');
				if(dnumber) {
					numberPicker.pickers[0].setSelectedValue(dnumber);
				}
				//if(number.value == "") {
					
					if(numberPickerBtn.innerText == ""&&number.value == "") {
						numberPickerBtn.innerText = numberData[0].text;
						number.value = numberData[0].value;
					}
				//}
				numberPickerBtn.addEventListener('tap', function(event) {
					document.activeElement.blur();
					numberPicker.show(function(items) {
						number.value = items[0].value;
						numberPickerBtn.innerText = items[0].text;
					});
				}, false);
			}
			//工作经验
			if(typeof expData != "undefined") {
				var expPicker = new $.PopPicker();
				expPicker.setData(expData);
				var expPickerBtn = doc.getElementById('expPicker'),
					exp = doc.getElementById('exp'),
					dexp = expPickerBtn.getAttribute('data-exp');
				if(dexp) {
					expPicker.pickers[0].setSelectedValue(dexp);
				}
				//if(exp.value == "") {
					
					if(expPickerBtn.innerText == ""&&exp.value == "") {
						expPickerBtn.innerText = expData[0].text;
						exp.value = expData[0].value;
					}
				//}
				expPickerBtn.addEventListener('tap', function(event) {
					document.activeElement.blur();
					expPicker.show(function(items) {
						exp.value = items[0].value;
						expPickerBtn.innerText = items[0].text;
					});
				}, false);
			}
	
			//经验门槛
			if(typeof expreqData != "undefined") {
				var expreqPicker = new $.PopPicker();
				expreqPicker.setData(expreqData);
				var expreqPickerBtn = doc.getElementById('expreqPicker'),
					expreq = doc.getElementById('exp_req'),
					dexpreq = expreqPickerBtn.getAttribute('data-exp');
				if(dexpreq) {
					expreqPicker.pickers[0].setSelectedValue(dexpreq);
				}
				//if(exp.value == "") {
					
					if(expreqPickerBtn.innerText == ""&&expreq.value == "") {
						expreqPickerBtn.innerText = expreqData[0].text;
						expreq.value = expreqData[0].value;
					}
				//}
				expreqPickerBtn.addEventListener('tap', function(event) {
					document.activeElement.blur();
					expreqPicker.show(function(items) {
						expreq.value = items[0].value;
						expreqPickerBtn.innerText = items[0].text;
					});
				}, false);
			}
	
			//学历门槛
			if(typeof edureqData != "undefined") {
				var edureqPicker = new $.PopPicker();
				edureqPicker.setData(edureqData);
				var edureqPickerBtn = doc.getElementById('edureqPicker'),
					edureq = doc.getElementById('edu_req'),
					dedureq = edureqPickerBtn.getAttribute('data-edu');
				if(dedureq) {
					edureqPicker.pickers[0].setSelectedValue(dedureq);
				}
				//if(edu.value == "") {
					
					if(edureqPickerBtn.innerText == ""&&edureq.value == "") {
						edureqPickerBtn.innerText = edureqData[0].text;
						edureq.value = edureqData[0].value;
					}
				//}
				edureqPickerBtn.addEventListener('tap', function(event) {
					document.activeElement.blur();
					edureqPicker.show(function(items) {
						edureq.value = items[0].value;
						edureqPickerBtn.innerText = items[0].text;
					});
				}, false);
			}
	
			//到岗时间
			if(typeof reportData != "undefined") {
				var reportPicker = new $.PopPicker();
				reportPicker.setData(reportData);
				var reportPickerBtn = doc.getElementById('reportPicker'),
					report = doc.getElementById('report'),
					dreport = reportPickerBtn.getAttribute('data-report');
				if(dreport) {
					reportPicker.pickers[0].setSelectedValue(dreport);
				}
				//if(report.value == "") {
					
					if(reportPickerBtn.innerText == ""&&report.value == "") {
						reportPickerBtn.innerText = reportData[0].text;
						report.value = reportData[0].value;
					}
				//}
				reportPickerBtn.addEventListener('tap', function(event) {
					document.activeElement.blur();
					reportPicker.show(function(items) {
						report.value = items[0].value;
						reportPickerBtn.innerText = items[0].text;
					});
				}, false);
			}
			//年龄要求
			var agePickerBtn = doc.getElementById('agePicker');
			if(typeof ageData != "undefined" && agePickerBtn) {
				var agePicker = new $.PopPicker();
				agePicker.setData(ageData);
				var	age = doc.getElementById('age'),
					dage = agePickerBtn.getAttribute('data-age');
				if(dage) {
					agePicker.pickers[0].setSelectedValue(dage);
				}
				//if(age.value == "") {
					
					if(agePickerBtn.innerText == ""&&age.value == "") {
						agePickerBtn.innerText = ageData[0].text;
						age.value = ageData[0].value;
					}
				//}
				agePickerBtn.addEventListener('tap', function(event) {
					document.activeElement.blur();
					agePicker.show(function(items) {
						age.value = items[0].value;
						agePickerBtn.innerText = items[0].text;
					});
				}, false);
			}
			//性别要求
			var sexPickerBtn = doc.getElementById('sexPicker');
			if(typeof sexData != "undefined" && sexPickerBtn) {
				var sexPicker = new $.PopPicker();
				sexPicker.setData(sexData);
				var sex = doc.getElementById('sex');
					dsex = sexPickerBtn.getAttribute('data-sex');
				if(dsex) {
					sexPicker.pickers[0].setSelectedValue(dsex);
				}
				//if(sex.value == "") {
					
					if(sexPickerBtn.innerText == ""&&sex.value == "") {
						sexPickerBtn.innerText = sexData[0].text;
						sex.value = sexData[0].value;
					}
				//}
				sexPickerBtn.addEventListener('tap', function(event) {
					document.activeElement.blur();
					sexPicker.show(function(items) {
						sex.value = items[0].value;
						sexPickerBtn.innerText = items[0].text;
					});
				}, false);
			}
			//教育程度
			var eduPickerBtn = doc.getElementById('eduPicker');
			if(typeof eduData != "undefined" && eduPickerBtn) {
				var eduPicker = new $.PopPicker();
				eduPicker.setData(eduData);
				var	edu = doc.getElementById('edu'),
					dedu = eduPickerBtn.getAttribute('data-edu');
				if(dedu) {
					eduPicker.pickers[0].setSelectedValue(dedu);
				}
				//if(edu.value == "") {
					if(eduPickerBtn.innerText == ''&&edu.value == ""){
						eduPickerBtn.innerText = eduData[0].text;
						edu.value = eduData[0].value;
					}
				//}
				eduPickerBtn.addEventListener('tap', function(event) {
					document.activeElement.blur();
					eduPicker.show(function(items) {
						edu.value = items[0].value;
						eduPickerBtn.innerText = items[0].text;
					});
				}, false);
			}
			//婚姻状况
			if(typeof marriageData != "undefined") {
				var marriagePicker = new $.PopPicker();
				marriagePicker.setData(marriageData);
				var marriagePickerBtn = doc.getElementById('marriagePicker'),
					marriage = doc.getElementById('marriage'),
					dmarriage = marriagePickerBtn.getAttribute('data-marriage');
				if(dmarriage) {
					marriagePicker.pickers[0].setSelectedValue(dmarriage);
				}
				//if(marriage.value == "") {
					if(marriagePickerBtn.innerText == ""&&marriage.value == "") {
						marriagePickerBtn.innerText = marriageData[0].text;
						marriage.value = marriageData[0].value;
					}
				//}
				marriagePickerBtn.addEventListener('tap', function(event) {
					document.activeElement.blur();
					marriagePicker.show(function(items) {
						marriage.value = items[0].value;
						marriagePickerBtn.innerText = items[0].text;
					});
				}, false);
			}
			//工作性质
			var typePickerButton = document.getElementById('typePicker');
			if(typeof typeData != "undefined" && typePickerButton) {
				var typePicker = new mui.PopPicker();
				typePicker.setData(typeData);
				var type = document.getElementById('type'),
					dtype = typePickerButton.getAttribute('data-type');
				if(dtype) {
					typePicker.pickers[0].setSelectedValue(dtype);
				}
				typePickerButton.addEventListener('tap', function(event) {
					document.activeElement.blur();
					typePicker.show(function(items) {
						type.value = items[0].value;
						typePickerButton.innerText = items[0].text;
					});
				}, false);
			}
			//求职状态
			var jobstatusPickerButton = document.getElementById('jobstatusPicker');
			if(typeof jobstatusData != "undefined" && jobstatusPickerButton) {
				var jobstatusPicker = new mui.PopPicker();
				jobstatusPicker.setData(jobstatusData);
				var jobstatus = document.getElementById('jobstatus'),
					djobstatus = jobstatusPickerButton.getAttribute('data-jobstatus');
				if(djobstatus) {
					jobstatusPicker.pickers[0].setSelectedValue(djobstatus);
				}
				jobstatusPickerButton.addEventListener('tap', function(event) {
					document.activeElement.blur();
					jobstatusPicker.show(function(items) {
						jobstatus.value = items[0].value;
						jobstatusPickerButton.innerText = items[0].text;
					});
				}, false);
			}
			//猎头目前头衔
			var titlePickerButton = doc.getElementById('titlePicker');
			if(titlePickerButton) {
				var titlePicker = new $.PopPicker();
				titlePicker.setData(titleData);
				var title = doc.getElementById('title'),
					dtitle = titlePickerButton.getAttribute('data-title');
				if(dtitle) {
					titlePicker.pickers[0].setSelectedValue(dtitle);
				}
				titlePickerButton.addEventListener('tap', function(event) {
					document.activeElement.blur();
					titlePicker.show(function(items) {
						title.value = items[0].value;
						titlePickerButton.innerText = items[0].text;
					});
				}, false);
			}
			//培训方向
			var sidPickerButton = doc.getElementById('sidPicker');
			if(sidPickerButton) {
				var sidPicker = new $.PopPicker();
				sidPicker.setData(sidData);
				var sid = doc.getElementById('sid'),
					dsid = sidPickerButton.getAttribute('data-sid');
				if(dsid) {
					sidPicker.pickers[0].setSelectedValue(dsid);
				}
				sidPickerButton.addEventListener('tap', function(event) {
					document.activeElement.blur();
					sidPicker.show(function(items) {
						sid.value = items[0].value;
						sidPickerButton.innerText = items[0].text;
					});
				}, false);
			}
			//培训课程分类
			var nidPickerButton = doc.getElementById('nidPicker');
			if(nidPickerButton) {
				var nidPicker = new $.PopPicker({
						layer: 2
					});
				nidPicker.setData(nidData);
				var dnid = nidPickerButton.getAttribute('data-nid');
				if(dnid) {
					nidPicker.pickers[0].setSelectedValue(dnid);
				}
				var dtnid = nidPickerButton.getAttribute('data-tnid');
				if(dtnid) {
					setTimeout(function() {
						nidPicker.pickers[1].setSelectedValue(dtnid);
					}, 100);
				}
				nidPickerButton.addEventListener('tap', function(event) {
					document.activeElement.blur();
					nidPicker.show(function(items) {
						doc.getElementById('nid').value = items[0].value;
						doc.getElementById('tnid').value = items[1].value;
						nidPickerButton.innerText =items[1].text;
					});
				}, false);
			}
			//培训课程收费方式
			var ispricePickerButton = doc.getElementById('ispricePicker');
			if(ispricePickerButton) {
				var ispriceData = [];
					ispriceData.push({
						value: '1',
						text: '在线收费'
					},
					{
						value: '2',
						text: '到场收费'
					})
				var ispricePicker = new $.PopPicker();
				ispricePicker.setData(ispriceData);
				var disprice = ispricePickerButton.getAttribute('data-isprice');
				if(disprice) {
					ispricePicker.pickers[0].setSelectedValue(disprice);
				}
				ispricePickerButton.addEventListener('tap', function(event) {
					document.activeElement.blur();
					ispricePicker.show(function(items) {
						doc.getElementById('isprice').value = items[0].value;
						ispricePickerButton.innerText =items[0].text;
					});
				}, false);
			}
			//头像展示
			var phototypePickerBtn = doc.getElementById('phototypePicker');
			if(phototypePickerBtn) {
				var phototypeData = [
					{value: 0, text: '公开'},
					{value: 1, text: '不公开'}
				];
				var phototypePicker = new $.PopPicker();
				phototypePicker.setData(phototypeData);
				var phototype = doc.getElementById('phototype');
					dphototype = phototypePickerBtn.getAttribute('data-phototype');
				if(dphototype) {
					phototypePicker.pickers[0].setSelectedValue(dphototype);
				}
				//if(phototype.value == "") {
					
					if(phototypePickerBtn.innerText == ""&&phototype.value == "") {
						phototypePickerBtn.innerText = phototypeData[0].text;
						phototype.value = phototypeData[0].value;
					}
				//}
				phototypePickerBtn.addEventListener('tap', function(event) {
					document.activeElement.blur();
					phototypePicker.show(function(items) {
						phototype.value = items[0].value;
						phototypePickerBtn.innerText = items[0].text;
					});
				}, false);
			}
			//姓名展示
			var nametypePickerBtn = doc.getElementById('nametypePicker');
			if(nametypePickerBtn) {
				var nametypePicker = new $.PopPicker();
				nametypePicker.setData(nametypeData);
				var nametype = doc.getElementById('nametype');
					dnametype = nametypePickerBtn.getAttribute('data-nametype');
				if(dnametype) {
					nametypePicker.pickers[0].setSelectedValue(dnametype);
				}
				//if(nametype.value == "") {
					
					if(nametypePickerBtn.innerText == ""&&nametype.value == "") {
						nametypePickerBtn.innerText = nametypeData[0].text;
						nametype.value = nametypeData[0].value;
					}
				//}
				nametypePickerBtn.addEventListener('tap', function(event) {
					document.activeElement.blur();
					nametypePicker.show(function(items) {
						nametype.value = items[0].value;
						nametypePickerBtn.innerText = items[0].text;
					});
				}, false);
			}
			//汇款银行
			var bank_namePickerButton = document.getElementById('bank_namePicker');
			if(typeof bank_nameData != "undefined" && bank_namePickerButton){
				var bank_namePicker = new mui.PopPicker();
				bank_namePicker.setData(bank_nameData);
				bank_namePickerButton.addEventListener('tap', function(event) {
					document.activeElement.blur();
					bank_namePicker.show(function(items) {
						document.getElementById('bank_name').value = items[0].value;
						document.getElementById('bank_number').value = items[0].bank_number;
						bank_namePickerButton.innerText = items[0].text;
					});
				}, false);
			}
		});
	})(mui, document);
}