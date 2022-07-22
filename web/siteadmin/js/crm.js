
// 新增客户
function addCustomers(uid) {
	var	uid = uid;
	layer.open({
        title:'添加新客户',
        type: 2,
        area: ['900px', '650px'],
        fix: false, //不固定
        maxmin: true,
        content: 'index.php?m=crm_customer&c=add&add'
	});
}

// 认领客户
function receiveKh(uid){
	
	if(uid == '0'){
		
		var uids = "";
		
		$(".check_all:checked").each(function() { 	
			if (uids == "") {
				uids = $(this).val();
			} else {
				uids = uids + "," + $(this).val();
			}
		});
		
		if (uids == "") {
			parent.layer.msg('请选择你要领取的客户！', 2, 8);
			return false;
		} 
		
 	}else{
 		
 		var uids = uid;
 		
 	}
 	
 	var pytoken	=	$('#pytoken').val();
	loadlayer();
	$.post('index.php?m=crm_index&c=receiveKh', {uids: uids , pytoken:pytoken}, function(data){
		parent.layer.closeAll('loading');
		if(data == '1'){
			
			parent.layer.msg('客户领取成功！', 2, 9, function(){
					
				location.href = 'index.php?m=crm_customer&self=1';
				
			});
			
		}else if (data == '2'){
			
			parent.layer.msg('客户领取失败！', 2, 8);
			return false;
		}
	});
}

//	新建联系记录
function addFollow(uid) {
	var	uid = uid;
	layer.open({
        title:'新建联系记录',
        type: 2,
        area: ['900px', '650px'],
        fix: false, //不固定
        maxmin: true,
        content: 'index.php?m=crm_concern&c=add&comid='+uid
	});
	
}
//绑定业务员
function addDeal(){
	$('.layui-anim_all').html('');
	$.layer({
		type : 1,
		title :'录订单', 
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['450px','auto'],
		offset: ['20px', ''],
		page : {dom :"#crmdeal"}
	});
}
function upDeal(id,uid,rating,comname,order_id,order_price,order_type,order_remark){
	$('.layui-anim_all').html('');
	$("#com_uid").val(uid);
	$("#edittaskid").val(id);
	$("#comname").val(comname);
	$("#order_remark").val(order_remark);
	$("#order_price").val(order_price);
	$("#orderid").val(order_id);
	$("#rid_val").val(rating);
	$("#order_type").val(order_type);
    layui.use(['form'], function() {
            var f = layui.form;
            f.render();
    });
	$.layer({
		type : 1,
		title :'录订单', 
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['450px','auto'],
		offset: ['20px', ''],
		page : {dom :"#crmdeal"}
	});
}
function crmdeal(){
   var uid=$('input[name="com_uid"]').val();
   if(!uid){
       layer.msg('请选择企业客户！',2,8);return false;
   }
}

//	新建待办任务
function addWaitTask(id,url) {
	if(id){
		var pytoken = $('#pytoken').val();
		$.post(url,{pytoken:pytoken,id:id},function(data){
			var data=eval('('+data+')');
			$('input[name="crm_keyword"]').val(data.comname);
			$('input[name="com_uid"]').val(data.comid); 
			
			$('#title').val(data.title);
			$('#stime').val(data.stime_n);
			$('#content').val(data.content);
			$('#edittaskid').val(data.id);
			if(data.status!=1){
				$('#waittasksubmit').hide();
			}else{
				$('#waittasksubmit').show();
			}
		});
	}else{
		$('input[name="crm_keyword"]').val('');
		$('input[name="com_uid"]').val(''); 
		$('#edittaskid').val('');
		$('#title').val('');
		$('#stime').val('');
		$('#content').val('');
		$('#waittasksubmit').show();
	}
	layui.use(['form'],function(){
		var f = layui.form;
		f.render();
	});
	$('.layui-anim_all').html('');
	$.layer({
		type : 1,
		title :'待办任务', 
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['450px','460px'],
		offset: ['20px', ''],
		page : {dom :"#crmwaittask"}
	});
}
function crmwaittask(){
	if(!$('input[name="com_uid"]').val()){
       layer.msg('请选择企业客户',2,8);return false;
	}
	if(!$("#title").val()){
       layer.msg('请填写任务标题',2,8);return false;
	}
	var now		=	Date.parse(new Date()) / 1000;
	var stime	=	$('#stime').val();

	if(stime){
		stime	=	Date.parse(new Date(stime)) / 1000;
		
		if(stime < now){
			layer.msg('新任务时间不合理，请重新设置');
			return false;
		}
	}
	if(!$("#content").val()){
       layer.msg('请填写任务说明',2,8);return false;
	}
}
//任务里的客户信息

function OpenContact(uid,url){
	var pytoken = $('#pytoken').val();
	$.post(url,{pytoken:pytoken,uid:uid},function(data){
		var data=eval('('+data+')');
		$('#crmcomname').html(data.name);
		$('#commoblie').html(data.moblie);
		$('#comrating').html(data.ratingname);
		$('#comratingtime').html(data.ratingtime);
		$('#comcityname').html(data.cityname);
		$('#comlinkman').html(data.linkman);
		
		$.layer({
			type : 1,
			title :'查看联系方式', 
			closeBtn : [0 , true],
			border : [10 , 0.3 , '#000', true],
			area : ['750px','300px'],
			offset: ['20px', ''],
			page : {dom :"#crmcom"}
		});
	});
}
function CompleteDetail(id,url){
	var pytoken = $('#pytoken').val();
	$.post(url,{pytoken:pytoken,id:id},function(data){
		$('#reason').val(data);
		$('#taskreasonsubmit').hide();
		
		$.layer({
			type : 1,
			title :'任务未完成原因', 
			closeBtn : [0 , true],
			border : [10 , 0.3 , '#000', true],
			area : ['450px','250px'],
			offset: ['20px', ''],
			page : {dom :"#taskstatus"}
		});
	});
}
//	新建工作日志
function addWorkLog() {
	$("#logtitle").val('');
	$("#logcontent").val('')
	$.layer({
		type : 1,
		title :'新建工作日志', 
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['650px','450px'],
		offset: ['20px', ''],
		page : {dom :"#crmworklog"}
	});
}
function crmworklog(){
	if(!$("#logtitle").val()){
       layer.msg('请填写日志标题',2,8);return false;
	}
	if(!$("#logcontent").val()){
       layer.msg('请填写日志内容',2,8);return false;
	}
}
//	新建工作日志
function showWorkLog(id,url) {
	var pytoken = $('#pytoken').val();
	$.post(url,{pytoken:pytoken,id:id},function(data){
		var data=eval('('+data+')');
		$('#logtitleshow').html(data.title);

		$('#logcontentshow').html(data.content);
	});
	$.layer({
		type : 1,
		title :'工作日志详情', 
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['850px','300px'],
		offset: ['20px', ''],
		page : {dom :"#worklogshow"}
	});
}
//	外出申请
function addOut() {
	$.layer({
		type : 1,
		title :'外出申请', 
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['500px','450px'],
		offset: ['20px', ''],
		page : {dom :"#crmout"}
	});
}
function crmout(){
	if(!$("#title").val()){
       layer.msg('请填写外出原因',2,8);return false;
	}
	if(!$("#stime").val()){
       layer.msg('请选择外出时间',2,8);return false;
	}
	if(!$("#etime").val()){
		layer.msg('请选择返回时间',2,8);return false;
	 }
	var now		=	Date.parse(new Date()) / 1000;
	var stime	=	$('#stime').val();
	var etime	=	$('#etime').val();
	if(stime){
		stime	=	Date.parse(new Date(stime)) / 1000;
		
		if(stime < now){
			layer.msg('外出时间必须大于现在时间，请重新设置',2,8);
			return false;
		}
		etime	=	Date.parse(new Date(etime)) / 1000;
		if(stime > etime){
			layer.msg('返回时间必须大于外出时间，请重新设置',2,8);
			return false;
		}
	}
}