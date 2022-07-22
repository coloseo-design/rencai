<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:39:28
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_job.htm" */ ?>
<?php /*%%SmartyHeaderCode:2285762d902b0e2a319-91425291%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '462e0af6147fa210123df9a44d7b48b3d9a03188' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_job.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2285762d902b0e2a319-91425291',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'position' => 0,
    'one' => 0,
    'id' => 0,
    'pytoken' => 0,
    'key' => 0,
    'v' => 0,
    'onejob' => 0,
    'twojob' => 0,
    'two' => 0,
    'two_class_id' => 0,
    'threejob' => 0,
    'three' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d902b139ef15_78860291',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d902b139ef15_78860291')) {function content_62d902b139ef15_78860291($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
		<link href="images/reset.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<link href="images/system.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<link href="images/table_form.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet"
		 type="text/css" />
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/layui.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/phpyun_layer.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
>
			
			
			$(document).ready(function(){
				$(".imghide").hover(function(){
					$(this).find('.class_xg').show();
				},function(){
					$(this).find('.class_xg').hide();
				});
			})
			function replace_job(id){
				var type=$("input[name='type']").val();
				var pytoken=$("#pytoken").val();
				
				if(id!="0"&&type=='2'){
					$.post("index.php?m=admin_job&c=get_class", {nid:id,pytoken:pytoken},function(data) {
						var data=eval('('+data+')');
						var html="";
						if(data && data.length>0){
						  html+= "<select name='keyid'>";
						  html+= "<option value=''>==请选择==</option>";
						  for(var i=0; i<data.length;i++){
							html+="<option value='"+data[i].id+"'>"+data[i].name+"</option>";
						  }
						  html+="<select>";
						}
						$("#tow_class").html(html);
						$("#tow_class").parents().show();
					});	
				}
			}
			function showdiv8(type,pid){
				$(".pid").val(pid);  
				$("input[name='type']").val(type);
				if(type=="1"){
					$("#gettow").hide();
					$("#tow_class").html('');
				}
				$.layer({
					type : 1,
					title : '移动类别', 
					closeBtn : [0 , true],
					border : [10 , 0.3 , '#000', true],
					area : ['350px','150px'],
					page : {dom :"#job_div"}
				});  
			} 
			function clickname(id){
				if(document.getElementById('msg'+id).style.display=='none'){
					document.getElementById('msg'+id).style.display='block';
					$("#msg"+id).attr("class","open");
					}else{
					document.getElementById('msg'+id).style.display='none';
					$("#msg"+id).attr("msg","close");
				}
			}
			function is_move(){
				layer.closeAll();
				var nid=$("#movenid").attr('value');
				
				parent.layer.confirm('移动分类可能导致现有数据职位类别混淆，确认移动？',function(){
					setTimeout(function(){$('#moveform').submit()},0);
				});
				
			}
			function chachong(page,type){
				var pytoken=$("#pytoken").val();
				$.post("index.php?m=admin_job&c=ajaxchachong", {page:page,pytoken:pytoken},function(edata) {
					var edata=eval('('+edata+')');
					var data=edata.list;
					var html='';
					if(data){
						for(var i=0;i<data.length;i++){
							html+='<tr><td class="ud">'+data[i].id+'</td><td align="left" class="imghide">'+data[i].name+'</td><td class="imghide" align="left"><span onClick="checkename(\''+data[i].id+'\');" id="ename'+data[i].id+'" style="cursor:pointer;">'+data[i].e_name+'</span><input class="input-text hidden cityename" type="text" id="inputename'+data[i].id+'" size="10" value="'+data[i].e_name+'" onBlur="subename(\''+data[i].id+'\',\'index.php?m=admin_job&c=ajax\');"><input type="hidden" id="inputname'+data[i].id+'" value="'+data[i].name+'"></tr>';
						}
						html+='<tr><td colspan="3" style="text-align:center"><input class="admin_button" type="button" name="add" onClick="chachong(\''+edata.page+'\',\'1\')" value="换一批" /></td></tr>';
						$('#chachong').html(html);
						if(type!='1'){
							$.layer({
								type : 1,
								title : '拼音重复类别', 
								closeBtn : [0 , true],
								border : [10 , 0.3 , '#000', true],
								area : ['650px','auto'],
								page : {dom :"#chongfu_div"}
							});
						}
					}
				});
			}
			function pinyin(msg,status,page,pagesize){
				var pytoken=$("#pytoken").val();
				if(status=='2'){
					parent.layer.confirm(msg,function(){
						$.post('index.php?m=admin_job&c=ajaxpinyin',{page:page,pagesize:pagesize,pytoken:pytoken},function(data){
							var data=eval('('+data+')');
							pinyin(data.msg,data.errcode,data.page,data.pagesize);
						})
					});
				}else if(status=='8'){
					var ii = parent.layer.msg(msg,5000,{icon:16,shade:0.01});
					$.post('index.php?m=admin_job&c=ajaxpinyin',{page:page,pagesize:pagesize,pytoken:pytoken},function(data){
						parent.layer.close(ii);
						var data=eval('('+data+')');
						pinyin(data.msg,data.errcode,data.page,data.pagesize);
					})
				}else{
					parent.layer.close(ii);
					parent.layer.alert(msg,9);
					location.reload();
				}
			}
			function clearPinYin(){
				var pytoken=$("#pytoken").val();
				
				parent.layer.confirm('清空所有城市对应拼音？',function(){
					$.post('index.php?m=admin_job&c=clearpinyin',{pytoken:pytoken},function(data){
						parent.layer.msg("拼音已清空！",2, 9,function(){location.reload();});
					})
				});
				
			}
		<?php echo '</script'; ?>
>
		<title>后台管理</title>
	</head>
	<body class="body_ifm">
		<div id="wname" style="display:none; width: 300px; ">
			<div style="height: 160px;" class="job_box_div">
				<div class="job_box_inp">
					<table class="table_form " style="width:100%">
						<tr>
							<td colspan='2' class='ui_content_wrap'>
								<input name='ctype' type='radio' value='1' checked='checked'>一级类别
								<input name='ctype' type='radio' value='2'>二级类别
								<input name='ctype' type='radio' value='3'>三级类别
							</td>
						</tr>
						<tr class='sclass_2 sclass_3  sclass' style="display:none;">
							<td style="text-align: right;">一级分类:</td>
							<td>
								<select name="nid" id='nid'>
									<?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['position']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['one']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['one']->value['name'];?>
</option>
									<?php } ?>
								</select> 
							</td>
						</tr>
						<tr class='sclass_3 sclass' style="display:none;">
							<td style="text-align: right;">二级分类:</td>
							<td>
								<select name="keyid" id='keyid'>
									<option value="">--请选择--</option>
								</select> 
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">类别名称:</td>
							<td><input type="text" name="position" id='position' class="input-text" /></td>
						</tr>
						<tr>
							<td style="text-align: right;">排序:</td>
							<td><input type="text" name="sort" id='sort' class="input-text" size='5' /></td>
						</tr>
						<tr>
							<td colspan='2' class='ui_content_wrap' style="border-bottom:none"><input class="admin_button" type="button"
								 value="添加 " onClick="save_jobclass()" /></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<span id="temp"></span>
		<div class="infoboxp">
			<div class="tty-tishi_top">
				<div class="admin_new_search_box">
					<a href="index.php?m=admin_job&c=classadd" class="admin_new_cz_tj" style="margin-left:0px;">+ 添加类别</a>
					<a href="javascript:;" onclick="pinyin('未设置拼音的相关分类将根据中文名称自动生成拼音？','2','0','100')" class="admin_new_cz_tj" style="margin-left:0px;">生成拼音</a>
					<a href="javascript:;" onclick="chachong('0','')" class="admin_new_cz_tj" style="margin-left:0px;">一键查重</a>
					<a href="javascript:;" onclick="clearPinYin();" class="admin_new_cz_tj" style="margin-left:0px;">清空拼音</a>
					<?php if ($_smarty_tpl->tpl_vars['id']->value) {?>
					<a href=" javascript:history.back(-1);" class="admin_new_cz_tj" style="margin-left:0px;"> 返回</a>
					<?php }?>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tty_table-bom">
				<div class="table-list">
					<div class="admin_table_border">
						<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
						<form action="index.php?m=admin_job&c=del" method="post" id='myform' target="supportiframe">
							<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
							<table width="100%">
								<thead>
									<tr class="admin_table_top">
										<th width="50"><label for="chkall"> <input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' /></label></th>
										<th>编号</th>
										<th align="left">职位名称<span class="clickup">(点击修改)</span></th>
										<th align="left">英文名称/拼音<span class="clickup">(点击修改)</span></th>
										<th width="100">职位排序</th>
										<th width="100">职位描述样本</th>
										<th width="180" class="admin_table_th_bg">操作</th>
									</tr>
								</thead>
								<tbody>
									<?php if (empty($_smarty_tpl->tpl_vars['id']->value)) {?>
									<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['position']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
									<tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
										<td width="50"><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
										<td class="ud"><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
										<td align="left" class="imghide">一级分类：
											<span onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" id="name<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</span>
											<input class="input-text hidden" type="text" id="inputname<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
"
											 onBlur="subname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','index.php?m=admin_job&c=ajax');">
											<img class="" src="images/xg.png" onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" style="padding-left:5px;cursor:pointer;" />
										</td>
										<td class="imghide" align="left"><span onClick="checke_name('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" id="e_name<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"
											 style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['v']->value['e_name'];?>
</span>
											<input class="input-text hidden citye_name" type="text" id="inpute_name<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" size="10" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['e_name'];?>
"
											 onBlur="sube_name('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','index.php?m=admin_job&c=ajax');">
											<img class="" src="images/xg.png" onClick="checke_name('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" style="padding-left:5px;cursor:pointer;" /></td>
										<td class="imghide"><span onClick="checksort('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" id="sort<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['v']->value['sort'];?>
</span>
											<input class="input-text hidden citysort" type="text" id="input<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" size="10" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['sort'];?>
"
											 onBlur="subsort('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','index.php?m=admin_job&c=ajax');">
											<img class="" src="images/xg.png" onClick="checksort('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" style="padding-left:5px;cursor:pointer;" /></td>
										<td class="ud">
											<a href="index.php?m=admin_job&c=up&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="lb_setyb">设置</a> </td>
										<td class="ud">
											<a href="index.php?m=admin_job&c=up&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_new_c_bth">管理</a>
											<a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=admin_job&c=del&delid=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"
											 class="admin_new_c_bth admin_new_c_bth_sc">删除</a>
										</td>
									</tr>

									<?php } ?>
									<?php }?>
									<?php if ($_smarty_tpl->tpl_vars['id']->value) {?>
									<tr align="center" id="list<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
">
										<td width="50"><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
										<td class="ud" width="60"><?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
</td>
										<td class="ud imghide" align="left">一级分类：<span onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
');" id="name<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
"
											 style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['onejob']->value['name'];?>
</span><input class="input-text hidden" type="text" id="inputname<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
"
											 value="<?php echo $_smarty_tpl->tpl_vars['onejob']->value['name'];?>
" onBlur="subname('<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
','index.php?m=admin_job&c=ajax');">
											<img class="" src="images/xg.png" onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
');" style="padding-left:5px;cursor:pointer;" />
										</td>
										<td class="imghide" align="left"><span onClick="checke_name('<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
');" id="e_name<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"
											 style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['onejob']->value['e_name'];?>
</span>
											<input class="input-text hidden citye_name" type="text" id="inpute_name<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
" size="10"
											 value="<?php echo $_smarty_tpl->tpl_vars['onejob']->value['e_name'];?>
" onBlur="sube_name('<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
','index.php?m=admin_job&c=ajax');">
											<img class="" src="images/xg.png" onClick="checke_name('<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
');" style="padding-left:5px;cursor:pointer;" /></td>
										<td class="imghide"><span onClick="checksort('<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
');" id="sort<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
"
											 style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['onejob']->value['sort'];?>
</span><input class="input-text hidden citysort" type="text"
											 id="input<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
" size="10" value="<?php echo $_smarty_tpl->tpl_vars['onejob']->value['sort'];?>
" onBlur="subsort('<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
','index.php?m=admin_job&c=ajax');"><img
											 class="" src="images/xg.png" onClick="checksort('<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
');" style="padding-left:5px;cursor:pointer;" /></td>
										<td class="ud">&nbsp;</td>
										<td class="ud" width="180"><A href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=admin_job&c=del&delid=<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
');"
											 class="admin_new_c_bth admin_new_c_bth_sc">删除</a></td>
									</tr>
									<?php  $_smarty_tpl->tpl_vars['two'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['two']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['twojob']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['two']->key => $_smarty_tpl->tpl_vars['two']->value) {
$_smarty_tpl->tpl_vars['two']->_loop = true;
?>
									<?php $_smarty_tpl->tpl_vars["two_class_id"] = new Smarty_variable($_smarty_tpl->tpl_vars['two']->value['id'], null, 0);?>
									<tr align="center" id="list<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
">
										<td width="50"><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
										<td class="ud"><?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
</td>
										<td align="left" class="imghide">&nbsp;&nbsp;&nbsp;&nbsp;
											二级分类：┗<span onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
');" id="name<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['two']->value['name'];?>
</span>
											<input class="input-text hidden" type="text" id="inputname<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['two']->value['name'];?>
"
											 onBlur="subname('<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
','index.php?m=admin_job&c=ajax');">
											<img class="" src="images/xg.png" onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
');" style="padding-left:5px;cursor:pointer;" />
										</td>
										<td class="imghide" align="left"><span onClick="checke_name('<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
');" id="e_name<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
"
											 style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['two']->value['e_name'];?>
</span>
											<input class="input-text hidden citye_name" type="text" id="inpute_name<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
" size="10" value="<?php echo $_smarty_tpl->tpl_vars['two']->value['e_name'];?>
"
											 onBlur="sube_name('<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
','index.php?m=admin_job&c=ajax');">
											<img class="" src="images/xg.png" onClick="checke_name('<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
');" style="padding-left:5px;cursor:pointer;" /></td>
										<td class="imghide"><span onClick="checksort('<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
');" id="sort<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['two']->value['sort'];?>
</span>
											<input class="input-text hidden citysort" type="text" id="input<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
" size="10" value="<?php echo $_smarty_tpl->tpl_vars['two']->value['sort'];?>
"
											 onBlur="subsort('<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
','index.php?m=admin_job&c=ajax');"> <img class="" src="images/xg.png"
											 onClick="checksort('<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
');" style="padding-left:5px;cursor:pointer;" /></td>
										<td class="ud"><a href="index.php?m=admin_job&c=classadd&tid=<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
" class="lb_setyb ">设置样本</a></td>
										<td class="ud">

											<A href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=admin_job&c=del&delid=<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
');"
											 class="admin_new_c_bth admin_new_c_bth_sc">删除</a>
											<a href="javascript:;" onClick="showdiv8('1','<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
');" class="admin_new_c_bth ">移动</a>
											<a href="index.php?m=admin_job&c=classadd&tid=<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
" class="admin_new_c_bth ">修改</a></td>
									</tr>
									<?php  $_smarty_tpl->tpl_vars['three'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['three']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['threejob']->value[$_smarty_tpl->tpl_vars['two_class_id']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['three']->key => $_smarty_tpl->tpl_vars['three']->value) {
$_smarty_tpl->tpl_vars['three']->_loop = true;
?>
									<?php $_smarty_tpl->tpl_vars["three_class_arr"] = new Smarty_variable($_smarty_tpl->tpl_vars['threejob']->value[$_smarty_tpl->tpl_vars['two_class_id']->value], null, 0);?>
									<tr align="center" id="list<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
">
										<td width="50"><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
										<td class="ud"><?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
</td>
										<td class="ud imghide" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											┗<span onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
');" id="name<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['three']->value['name'];?>
</span>
											<input class="input-text hidden" type="text" id="inputname<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['three']->value['name'];?>
"
											 onBlur="subname('<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
','index.php?m=admin_job&c=ajax');">
											<img class="" src="images/xg.png" onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
');" style="padding-left:5px;cursor:pointer;" />
										</td>
										<td class="imghide" align="left"><span onClick="checke_name('<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
');" id="e_name<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
"
											 style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['three']->value['e_name'];?>
</span>
											<input class="input-text hidden citye_name" type="text" id="inpute_name<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
" size="10"
											 value="<?php echo $_smarty_tpl->tpl_vars['three']->value['e_name'];?>
" onBlur="sube_name('<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
','index.php?m=admin_job&c=ajax');">
											<img class="" src="images/xg.png" onClick="checke_name('<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
');" style="padding-left:5px;cursor:pointer;" /></td>
										<td class="imghide"><span onClick="checksort('<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
');" id="sort<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['three']->value['sort'];?>
</span>
											<input class="input-text hidden citysort" type="text" id="input<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
" size="10" value="<?php echo $_smarty_tpl->tpl_vars['three']->value['sort'];?>
"
											 onBlur="subsort('<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
','index.php?m=admin_job&c=ajax');">
											<img class="" src="images/xg.png" onClick="checksort('<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
');" style="padding-left:5px;cursor:pointer;" /></td>
										<td class=""> <a href="index.php?m=admin_job&c=classadd&id=<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
" class="lb_setyb ">设置样本</a></td>
										<td class="ud">

											<A href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=admin_job&c=del&delid=<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
');"
											 class="admin_new_c_bth ">删除</a>
											<a href="javascript:;" onClick="showdiv8('2','<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
');" class="admin_new_c_bth ">移动</a>
											<a href="index.php?m=admin_job&c=classadd&id=<?php echo $_smarty_tpl->tpl_vars['three']->value['id'];?>
" class="admin_new_c_bth ">修改</a></td>


									</tr>

									<?php } ?>
									<?php } ?>
									<?php }?>
									<tr style="background:#f1f1f1;">
										<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
										<td colspan="6">
											<label for="chkAll2">全选</label>&nbsp;
											<input class="admin_button" type="button" name="delsub" value="删除所选" onclick="return really('del[]')" /></td>
									</tr>
								</tbody>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>
		
	<div id="job_div" style="width: 350px;display:none;" class="layui-layer-wrap">
	    	<form class="layui-form" action="index.php?m=admin_job&c=move" target="supportiframe" method="post" id="moveform">
				<input type="hidden" class="pid" name="pid" value="0">
				<input type="hidden" name="type" value="0">
				<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
	           	<table cellspacing="1" cellpadding="1" class="admin_examine_table">
					<tbody>
							
						<tr>
							<th style="width: 90px !important;">一级类别： </th>
							<td>
								<div class="layui-input-inline" style="width: 220px;">
									<select name="nid" id="movenid" onChange="replace_job(this.value);">
										<option value="0">==请选择==</option>
										<?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['position']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['one']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['one']->value['name'];?>
</option>
										<?php } ?>
									</select>
								</div>
							</td>
						</tr>
						<tr style="display:none" id="gettow">
							<th class="ui_content_wrap" style=" margin:0px;">二级分类：</th>
							<td id="tow_class"></td>
						</tr>
						<tr>
							<td colspan='2' style="text-align:center">
								<input class="admin_examine_bth" type="button" name="add" onClick="is_move()" value=" 确认 " />
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
		<div id="chongfu_div" style="display:none;" class="job_box_div">
			<div class="table-list table-tc">
				<table class="" style="width:100%">
					<thead>
						<tr class="admin_table_top">
							<th width="110" style="padding-left: 40px;" align="left">ID</th>
							<th width="150" align="left">类别名称</th>
							<th width="300" align="left">英文/拼音<span class="clickup">(点击修改)</span></th>
						</tr>
					</thead>
					<tbody id="chachong">
					</tbody>
				</table>
			</div>
		</div>
		
		
		<?php echo '<script'; ?>
>
			layui.use('form', function(){
			  var form = layui.form; 
			  
			  // form.render();
			}); 
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
