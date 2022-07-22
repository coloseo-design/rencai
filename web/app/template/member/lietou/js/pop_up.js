function input_check_show(){
	var skill_val = "";
	/*$("input[name='job']").each(function(){
	var info = $(this).val().split("+");
	skill_val+="<span class=\"m_name_fw\" id=\"sk"+info[0]+"\"><em>"+info[1]+"</em><input type=\"button\" class=\"m_fw_submit\" onclick=\"del_type('"+info[0]+"');\"><input type=\"hidden\" value=\""+info[0]+"\" name=\"job[]\" /></span>";
	});*/
	var jobids = $('#jobids').val();
	var jobidlist = jobids.split(',');
	var jobnames = $('#jobnames').val();
	var jobnamelist = jobnames.split(',');
	if(jobids){
		for (var i = 0; i < jobidlist.length; i++) {
			skill_val += "<span class=\"m_name_fw\" id=\"ltjob" + jobidlist[i] + "\"><em>" + jobnamelist[i] + "</em><input type=\"button\" class=\"m_fw_submit\" onclick=\"del_type('" + jobidlist[i] + "','"+jobnamelist[i]+"');\"><input type=\"hidden\" value=\"" + jobidlist[i] + "\" name=\"job[]\" /></span>";
		}
	}
	$("#job").html(skill_val);
	var jobaddtype=$("#jobaddtype").val();
	if(jobaddtype=="ltinfo"){
		if(skill_val!=""){
			$("#by_job").html('');
			$("#by_job").attr("class","m_name_gh");
		}else{
			$("#by_job").attr("class","");
		}
	}
	layer.closeAll();
}

function input_check_show2(){
	var skill_val = "";
	/*$("input[name='hy']").each(function(){
	var info = $(this).val().split("+");
	skill_val += "<span class=\"m_name_fw\" id=\"lthy" + hyidlist[i] + "\"><em>" + hynamelist[i] + "</em><input type=\"button\" class=\"m_fw_submit\" onclick=\"del_type2('" + hyidlist[i] + "');\"><input type=\"hidden\" value=\"" + hyidlist[i] + "\" name=\"qw_hy[]\" /></span>";
	});*/
	var hyids = $('#hyids').val();
	var hyidlist = hyids.split(',');
	var hynames = $('#hynames').val();
	var hynamelist = hynames.split(',');
	if(hyids){
		for (var i = 0; i < hyidlist.length; i++) {
			skill_val += "<span class=\"m_name_fw\" id=\"lthy" + hyidlist[i] + "\"><em>" + hynamelist[i] + "</em><input type=\"button\" class=\"m_fw_submit\" onclick=\"del_type2('" + hyidlist[i] + "','"+hynamelist[i]+"');\"><input type=\"hidden\" value=\"" + hyidlist[i] + "\" name=\"qw_hy[]\" /></span>";
		}
	}
	$("#qw_hy").html(skill_val);
	//猎头基本信息--start
	var jobaddtype=$("#jobaddtype").val();
	if(jobaddtype=="ltinfo"){
		if(skill_val==""){
			$("#by_hy").attr("class","");
		}else{
			$("#by_hy").html('');
			$("#by_hy").attr("class","m_name_gh");
		}
	}
	//猎头基本信息--end
	layer.closeAll();
}
function del_type(id,name){
	$("#ltjob"+id).remove();
	$("#sk"+id).remove();
	$("#zn"+id).removeAttr("checked");
	var jobids = $('#jobids').val();
	var jobidlist = jobids.split(',');
	var keyid = jobidlist.indexOf(id);
	if (keyid > -1) {
		jobidlist.splice(keyid, 1);
		$('#jobids').val(jobidlist);
	}
	var jobnames = $('#jobnames').val();
	var jobnamelist = jobnames.split(',');
	var keyname = jobnamelist.indexOf(name);
	if (keyname > -1) {
		jobnamelist.splice(keyname, 1);
		$('#jobnames').val(jobnamelist);
	}
	input_check_show();
}
function del_type2(id,name){
	$("#lthy"+id).remove();
	$("#hy_"+id).remove();
	$("#hy"+id).removeAttr("checked");
	var hyids = $('#hyids').val();
	var hyidlist = hyids.split(',');
	var keyid = hyidlist.indexOf(id);
	if (keyid > -1) {
		hyidlist.splice(keyid, 1);
		$('#hyids').val(hyidlist);
	}
	var hynames = $('#hynames').val();
	var hynamelist = hynames.split(',');
	var keyname = hynamelist.indexOf(name);
	if (keyname > -1) {
		hynamelist.splice(keyname, 1);
		$('#hynames').val(hynamelist);
	}
	input_check_show2();
	
} 
/*----弹出end---*/
//私信
function ltreply(id,pid){ 
    $("#fid").val(id);
    $("#pid").val(pid); 
	$.layer({
		type : 1,
		title :'发私信', 
		offset: [($(window).height() - 192)/2 + 'px', ''],
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['330px','220px'],
		page : {dom :"#reply"}
	}); 
}
function check_xin(){
	var content=$.trim($("#content").val());
	var fid=$.trim($("#fid").val());
	if(content==""){ 
		layer.msg('回复内容不能为空！', 2, 8); 
		return false;
	}	 
}
//私信---end