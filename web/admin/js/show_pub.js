function showdiv(id){  
	$.layer({
		type: 2, 
		shadeClose: true,
		maxmin: false,
		title: '名企招聘',  
		border : [5 , 1 , '#5EA7DC', true],
		offset: [($(window).height() - 500)/2 + 'px', ''],
		area: ['610px','530px'], 
		iframe: {src: 'index.php?m=admin_hotjob&c=hotjobinfo&uid='+id}
	}); 
} 
 
function showdiv3(id){  
	$.layer({
		type: 2,
		maxmin: false,
		shadeClose: true,
		title: '名企招聘',  
		offset: [($(window).height() - 500)/2 + 'px', ''],
		area: ['610px','530px'],
		iframe: {src: 'index.php?m=admin_hotjob&c=hotjobinfo&id='+id}
	});  
}
 
function showdiv4(div,id,url){ 
	var pytoken=$("#pytoken").val();
	$("#msgid").val(id);
	$.post(url,{id:id,pytoken:pytoken},function(data){
		var data=eval('('+data+')');
		$("#beizhu").html(data.content);
		$("#reply").html(data.reply);
		$.layer({
			type : 1,
			title :'回复评论', 
			offset: [($(window).height() - 210)/2 + 'px', ''],
			closeBtn : [0 , true],
			border : [10 , 0.3 , '#000', true],
			area : ['420px','310px'],
			page : {dom :"#"+div}
		}); 
	});
}
