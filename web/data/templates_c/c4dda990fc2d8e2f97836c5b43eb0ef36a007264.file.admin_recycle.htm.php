<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 17:28:46
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_recycle.htm" */ ?>
<?php /*%%SmartyHeaderCode:285062d91c4ec9d7a5-37057463%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c4dda990fc2d8e2f97836c5b43eb0ef36a007264' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_recycle.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '285062d91c4ec9d7a5-37057463',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'rows' => 0,
    'key' => 0,
    'v' => 0,
    'total' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d91c4ed6af26_74194922',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d91c4ed6af26_74194922')) {function content_62d91c4ed6af26_74194922($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
" rel="stylesheet" type="text/css" />
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
	<title>后台管理</title>
</head>

<?php echo '<script'; ?>
> 
	
	function delall(){
		var time=$("#ad_start").val(); 
		if(time==""){ 
			parent.layer.msg('请选择时间！', 2, 8);return false;
		}
		layer_del("确定删除"+time+"以前的数据吗？","index.php?m=recycle&c=del&time="+time);  
	}

	function cktimesave(){
		var stime=$("#stime").val();
		var etime=$("#etime").val();
		if(stime&&etime&&toDate(stime)>toDate(etime)){
			layer.msg("结束时间必须大于开始时间！",2,8);return false;
		}
	}

	function recovers(){
		
		var codewebarr =[];  
		
		$('.check_all:checked').each(function(){    
			codewebarr.push($(this).val());   
		}); 
		
		if(codewebarr.length==0){
			
			parent.layer.msg("您还未选择任何信息！",2,8);return false;

		}else{
			
			var url		= 'index.php?m=recycle&c=recover';

			var pytoken	= $('#pytoken').val();

			parent.layer.confirm('确定要恢复数据？', function(){

				parent.layer.load('执行中，请稍候...',4);
				
				$.get(url+'&pytoken='+pytoken,{id: codewebarr},function(data){

					parent.layer.closeAll();
				
					var data = eval('('+data+')');
					
					if(data.url=='1' || data.url == ''){
						parent.layer.msg(data.msg, Number(data.tm), Number(data.st),function(){location.reload();});return false;
					}else{
						parent.layer.msg(data.msg, Number(data.tm), Number(data.st),function(){location.href=data.url;});return false;
					}
				});
			});
			 
		}
	}
<?php echo '</script'; ?>
>

<body class="body_ifm">

<div class="infoboxp">

	<div class="tty-tishi_top">
	
		<div class="tabs_info">
			<ul>
				<li class="curr"><a href="index.php?m=recycle">删除记录</a></li>
			</ul>
		</div>

		<div class="admin_new_tip">
			<a href="javascript:;" class="admin_new_tip_close"></a>
			<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
			<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
			<div class="admin_new_tip_list_cont">
				<div class="admin_new_tip_list">回收站功能主要记录，管理员已删除的信息或数据库字段！</div>
				<div class="admin_new_tip_list">单次数据可以通过回收站功能进行“恢复”操作。</div>
				<div class="admin_new_tip_list">综合恢复指同一次操作下删除的关联数据，如删除企业账户同步删除的职位、申请记录等数据可以一次性批量恢复。</div>

			</div>
		</div>

		<div class="clear"></div>
		
	
		<div class="admin_new_search_box">
		
			<form action="index.php" name="myform" method="get" onSubmit="return cktimesave()">
				
				<input name="m" value="recycle" type="hidden"/>
				<!-- <div class="admin_new_search_name">搜索类型：</div>
				<div class="admin_Filter_text formselect" did='dtype'>
					<input type="button" <?php if ($_GET['type']=='1'||$_GET['type']=='') {?> value="操作人"<?php } elseif ($_GET['type']=='2') {?> value="数据内容" <?php } elseif ($_GET['type']=='3') {?> value="数据表名" <?php }?> class="admin_Filter_but" id="btype">
					<input type="hidden" name="type" id="type" value="<?php if ($_GET['type']) {
echo $_GET['type'];
} else { ?>1<?php }?>"/>
					
					<div class="admin_Filter_text_box" style="display:none" id="dtype">
						<ul>
							<li><a href="javascript:void(0)" onClick="formselect('1','type','操作人')">操作人</a></li>
							<li><a href="javascript:void(0)" onClick="formselect('2','type','数据内容')">数据内容</a></li>
							<li><a href="javascript:void(0)" onClick="formselect('3','type','数据表名')">数据表名</a></li>
						</ul>
					</div>
				</div> -->

				<input class="admin_Filter_search" type="text" name="ukeyword" value="<?php echo $_GET['ukeyword'];?>
" size="25" style="float:left;width:150px;" placeholder="输入操作人用户名" >
				<input class="admin_Filter_search" type="text" name="keyword" value="<?php echo $_GET['keyword'];?>
" size="25" style="float:left;width:150px;" placeholder="输入数据内容关键字">


				<input type="text" placeholder="输入表名" value="<?php echo $_GET['tkeyword'];?>
" name='tkeyword' class="admin_Filter_search" style="width: 150px;">
				<span class="admin_Filter_span">时间段：</span>
				<input class="admin_Filter_search" type="text" id="time" value="<?php echo $_GET['time'];?>
" name="time" style="width: 200px;"/>
				<input type="submit" name='search' value="搜索" class="admin_Filter_bth">
				<?php if ($_GET['ident']) {?>
				<a href="javascript:;" onclick="layer_del('确认要恢复数据吗？','index.php?m=recycle&c=recoverByIdent&ident=<?php echo $_GET['ident'];?>
');" class="admin_new_cz_tj">一键恢复</a>
				<?php }?>
			</form>

			<div class="clear"></div>
		</div>
	
	</div>
	
	<div class="tty_table-bom">
		<div class="table-list mt10">
			<div class="admin_table_border">
				<iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
				<form action="index.php" target="supportiframe" name="myform" method="get" id='myform'>
					<input name="m" value="recycle" type="hidden"/>
					<input name="c" value="del" type="hidden"/>
					<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					<table width="100%">
						<thead>
							<tr class="admin_table_top">
								<th width="20"><label for="chkall"><input type="checkbox" id='chkAll' onclick='CheckAll(this.form)'/></label></th>
								<th width="80"> 
									<?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?> 
										<a href="index.php?m=recycle&order=desc&t=id">编号<img src="images/sanj.jpg"/></a> 
									<?php } else { ?> 
										<a href="index.php?m=recycle&order=asc&t=id">编号<img src="images/sanj2.jpg"/></a> 
									<?php }?> 
								</th>
								<th align="left">操作人</th>
								<th align="left">数据表名</th>
								<th align="left">时间</th>
								<th class="admin_table_th_bg">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
								<tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
									<td>
										<input type="checkbox" class="check_all" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk"/>
									</td>
									<td align="center" class="td1" width="80"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
									<td class="od" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
</td>
									<td class="gd" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['tablename'];?>
</td>
									<td class="od" align="left"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['ctime'],"%Y-%m-%d %H:%M:%S");?>
</td>
									<td>
									<?php if ($_smarty_tpl->tpl_vars['v']->value['ident']) {?>
									<a href="index.php?m=recycle&ident=<?php echo $_smarty_tpl->tpl_vars['v']->value['ident'];?>
" class="admin_cz_sc">综合恢复</a> | 
									<?php }?>
										<a href="index.php?m=recycle&c=show&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_cz_sc">查看数据</a> |  
										<a href="javascript:void(0)" onClick="layer_del('确定要恢复数据？','index.php?m=recycle&c=recover&isdel=all&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" class="admin_cz_sc">恢复</a> | 
										<a href="javascript:void(0)" onClick="layer_del('确定要删除？','index.php?m=recycle&c=del&isdel=all&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" class="admin_cz_sc">永久删除</a>
									</td>
								</tr>
							<?php } ?>
							<tr>
								<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
								<td colspan="5" >
									<label for="chkAll2">全选</label> &nbsp;
									<input class="admin_button" type="button" name="delsub" value="批量恢复" onClick="recovers();" />
									<input class="admin_button" type="button" name="delsub" value="删除所选" onClick="return really('del[]')" />
									<input class="admin_button" type="button"  value="清空回收站" onClick="layer_del('确定要清空回收站？','index.php?m=recycle&c=del&id=alldel');" />
								</td>
							</tr>
							<?php if ($_smarty_tpl->tpl_vars['total']->value>$_smarty_tpl->tpl_vars['config']->value['sy_listnum']) {?>
								<tr>
									<?php if ($_smarty_tpl->tpl_vars['pagenum']->value==1) {?>
										<td colspan="3"> 从 1 到 <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
									<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value>1&&$_smarty_tpl->tpl_vars['pagenum']->value<$_smarty_tpl->tpl_vars['pages']->value) {?>
										<td colspan="3"> 从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['pagenum']->value*$_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
									<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value==$_smarty_tpl->tpl_vars['pages']->value) {?>
										<td colspan="3"> 从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
									<?php }?>
									<td colspan="3" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
								</tr>
							<?php }?>
						</tbody>
					</table>
				</form>
				
			</div>
		</div>
	</div>
</div>
<?php echo '<script'; ?>
>
	layui.use(['laydate'], function(){
		var laydate = layui.laydate
			,$ = layui.$;
		laydate.render({
			elem: '#time'
			,range:'~'
		});
	});
<?php echo '</script'; ?>
>
</body>
</html><?php }} ?>
