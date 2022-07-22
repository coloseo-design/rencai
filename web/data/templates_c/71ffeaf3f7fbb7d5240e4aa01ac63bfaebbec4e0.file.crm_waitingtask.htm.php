<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:49:03
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\crm_waitingtask.htm" */ ?>
<?php /*%%SmartyHeaderCode:1562762d904ef4f7928-11082340%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '71ffeaf3f7fbb7d5240e4aa01ac63bfaebbec4e0' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\crm_waitingtask.htm',
      1 => 1644196793,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1562762d904ef4f7928-11082340',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'power' => 0,
    'pytoken' => 0,
    'v' => 0,
    'cache' => 0,
    'tasks' => 0,
    'key' => 0,
    'total' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d904ef6c0e72_77490440',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d904ef6c0e72_77490440')) {function content_62d904ef6c0e72_77490440($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
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
	<link href="images/workspace.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" /> 
	<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" />
	
	<?php echo '<script'; ?>
 src="../js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
> 
	<?php echo '<script'; ?>
 src="js/crm.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
> 
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/layui.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/phpyun_layer.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
	
	<title>后台管理</title>
	
</head>

<body class="body_ifm">
	<div class="infoboxp">
	<div class="tty-tishi_top">
		<div class="tabs_info" style="height:36px;">
        	<ul>
               	<li class="curr"><a href="index.php?m=crm_waitingtask">我的任务</a></li>
               	<?php if (in_array('804',$_smarty_tpl->tpl_vars['power']->value)) {?>
               	<li><a href="index.php?m=crm_waitingtask&c=depart">下属的任务</a></li>
               	<?php }?>
           	</ul>
		</div>

		<div class="crm_searctime">
        	<ul>
               	<li <?php if (!$_GET['time']) {?>class="curr"<?php }?>><a href="index.php?m=crm_waitingtask">今天</a></li>
               	<li <?php if ($_GET['time']==1) {?>class="curr"<?php }?>><a href="index.php?m=crm_waitingtask&time=1">明天</a></li>
               	<li <?php if ($_GET['time']==2) {?>class="curr"<?php }?>><a href="index.php?m=crm_waitingtask&time=2">后天</a></li>
               	<li <?php if ($_GET['time']==3) {?>class="curr"<?php }?>><a href="index.php?m=crm_waitingtask&time=3">一周内</a></li>
               	<li <?php if ($_GET['time']==4) {?>class="curr"<?php }?>><a href="index.php?m=crm_waitingtask&time=4">所有任务</a></li>
           	</ul>
		</div>


		<form action="index.php" name="myform" method="get" class='layui-form'>
			
			<input type="hidden" name="pytoken"  id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
" />
			<input name="m" value="crm_waitingtask" type="hidden" />
			<input name="time" value="<?php echo $_GET['time'];?>
" type="hidden" />

			<div class="crm_newly_build_tit" style="padding:0; padding-top:10px;">
		 		<div class="layui-input-inline">
					<select name="status" id="status" lay-filter='status'>
						<option value="1" <?php if ($_GET['status']==1||!$_GET['status']) {?>selected<?php }?> data-url="<?php echo smarty_function_searchurl(array('m'=>$_GET['m'],'c'=>$_GET['c'],'type'=>$_GET['type'],'adv'=>'1','adt'=>'status','untype'=>'status'),$_smarty_tpl);?>
">进行中</option>
						<option value="2" <?php if ($_GET['status']==2) {?>selected<?php }?> data-url="<?php echo smarty_function_searchurl(array('m'=>$_GET['m'],'c'=>$_GET['c'],'type'=>$_GET['type'],'adv'=>'2','adt'=>'status','untype'=>'status'),$_smarty_tpl);?>
">已完成</option>
						<option value="3" <?php if ($_GET['status']==3) {?>selected<?php }?> data-url="<?php echo smarty_function_searchurl(array('m'=>$_GET['m'],'c'=>$_GET['c'],'type'=>$_GET['type'],'adv'=>'3','adt'=>'status','untype'=>'status'),$_smarty_tpl);?>
">未完成</option>
						<option value="4" <?php if ($_GET['status']==4) {?>selected<?php }?> data-url="<?php echo smarty_function_searchurl(array('m'=>$_GET['m'],'c'=>$_GET['c'],'type'=>$_GET['type'],'adv'=>'4','adt'=>'status','untype'=>'status'),$_smarty_tpl);?>
">已取消</option>
						<option value="5" <?php if ($_GET['status']==5) {?>selected<?php }?> data-url="<?php echo smarty_function_searchurl(array('m'=>$_GET['m'],'c'=>$_GET['c'],'type'=>$_GET['type'],'adv'=>'5','adt'=>'status','untype'=>'status'),$_smarty_tpl);?>
">全部</option>
					</select>
				</div>
				
				<div class="layui-input-inline">
					<select name="type" id="type" lay-filter='type'>
						<option value='' data-url="<?php echo smarty_function_searchurl(array('m'=>$_GET['m'],'c'=>$_GET['c'],'status'=>$_GET['status'],'adv'=>$_smarty_tpl->tpl_vars['v']->value,'adt'=>'type','untype'=>'type'),$_smarty_tpl);?>
">任务类型</option>
						<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cache']->value['crmdata']['task_type']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_GET['type']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?> data-url="<?php echo smarty_function_searchurl(array('m'=>$_GET['m'],'c'=>$_GET['c'],'status'=>$_GET['status'],'adv'=>$_smarty_tpl->tpl_vars['v']->value,'adt'=>'type','untype'=>'type'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['cache']->value['crmclass_name'][$_smarty_tpl->tpl_vars['v']->value];?>
</option>
                     	<?php } ?>
					</select>
				</div>
				<div class="layui-input-inline">
					<div class="crm_search_text"><input name="keyword" type="text" value="<?php echo $_GET['keyword'];?>
" class="layui-input" placeholder="输入关键字搜索"></div>
					<input type="submit" class="layui-btn layui-btn-normal" value="搜索" style="margin-left:10px; background:#31b4e1" />
				</div>
			</div>
		</form>
		<iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
		<form action="index.php" name="myform" method="get" id='myform' target="supportiframe">
			<div class="tty_table-bom">
			<div class="table-list" style="color:#898989; margin-top:10px;">
				<div class="admin_table_border">	
					<table width="100%">
						<thead>
							<tr class="admin_table_top">
	                          	<th align="left" ><div class="crm_listpd">客户名称</div></th>
	                           	<th align="left">任务类型</th>
	                           	<th align="left">任务事项</th>
								<th align="left">提交人</th>
	                           	<th>提交时间</th>
								<th>任务时间</th>
								<th>完成时间</th>
								<th>任务反馈</th>
								<th>操作</th>
								<th>客户管理</th>
							</tr>
						</thead>
						
						<tbody>
						<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['tasks']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
						
							<tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
                               	<td align="left">
	                               	<div class="crm_listpd">
	                               		<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>

	                               	<div class="">	<a href="javascript:OpenContact('<?php echo $_smarty_tpl->tpl_vars['v']->value['comid'];?>
','index.php?m=crm_waitingtask&c=ComDetail')" title="联系方式" class="crm_comtel">联系方式</a></div>
	                               	</div>
                             	</td>
                             	<td align="left"><?php echo $_smarty_tpl->tpl_vars['cache']->value['crmclass_name'][$_smarty_tpl->tpl_vars['v']->value['type']];?>
</td>
                             	<td align="left"><div class="crm_rwsx"><?php echo $_smarty_tpl->tpl_vars['v']->value['content'];?>
</div></td>
								<td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['aname'];?>
</td>
                             	<td>
                             		<?php echo $_smarty_tpl->tpl_vars['v']->value['ctime_n'];?>

                             		<div class="crm_time_b"><font color="red"><?php echo $_smarty_tpl->tpl_vars['v']->value['addDay'];?>
</font></div>
                             	</td>
                               	<td>
                               		<div class="crm_rwtime">
                               		<?php if ($_smarty_tpl->tpl_vars['v']->value['stime']) {?>
                               			<?php echo $_smarty_tpl->tpl_vars['v']->value['stime_n'];?>

                               			<div class="crm_time_b"><font color="red"><?php echo $_smarty_tpl->tpl_vars['v']->value['taskDay'];?>
</font></div>
                               			<?php if ($_smarty_tpl->tpl_vars['v']->value['stime']<time()&&$_smarty_tpl->tpl_vars['v']->value['status']!='2') {?> <span class="crm_rwtime_gq">已过期</span><?php }?>
                               		<?php } else { ?>
                               			--	
                               		<?php }?>
                               		</div>
                               	</td>
                               	<td>
                               		<?php if ($_smarty_tpl->tpl_vars['v']->value['status']=='1') {?> 
                               			<span style="color:#FF0000;">进行中</span>
									<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status']=='2') {?> 
										<span style="color:green"> <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['etime'],"%Y-%m-%d");?>
 </span>
									<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status']=='3') {?>
										<span style="color:#FF0000;"> 未完成 </span>
									<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status']=='4') {?> 
										<span style="color:#f60">已取消</span>
									<?php }?>
								</td>
								
								
								<td align="left">
									<div class="crm_rwsx" style="font-size: 14px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
										<?php if ($_smarty_tpl->tpl_vars['v']->value['reason']) {
echo $_smarty_tpl->tpl_vars['v']->value['reason'];
} else { ?><div style="width:100%; text-align:center">--</div><?php }?>
									</div>
								</td>
								
								<td align="center" width="240">
									<?php if ($_smarty_tpl->tpl_vars['v']->value['status']=='1') {?>
										<?php if ($_smarty_tpl->tpl_vars['v']->value['type']==22&&$_smarty_tpl->tpl_vars['v']->value['crm_uid']==$_smarty_tpl->tpl_vars['v']->value['uid']) {?>
											<a href="javascript:void(0)" class="crm_submitwc CrmnewFollow" data-uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['comid'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" data-type="<?php echo $_smarty_tpl->tpl_vars['v']->value['type'];?>
" data-taskid="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" >完成</a>
										<?php } else { ?> 
											<a href="javascript:void(0)" onclick="settaskstatus('2','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','index.php?m=crm_waitingtask&c=setStatus')"  class="crm_submitwc">完成</a>
										<?php }?>
										<a href="javascript:void(0)" onclick="settaskstatus('3','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','index.php?m=crm_waitingtask&c=setStatus')"  class="crm_submitwwc">未完成</a>
										<a href="javascript:void(0)" onclick="settaskstatus('4','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','index.php?m=crm_waitingtask&c=setStatus')"  class="crm_submitqx">取消任务</a>
									<?php }?>
									<?php if ($_smarty_tpl->tpl_vars['v']->value['status']=='2') {?>
										<span style="color:green"> [已完成] </span>
									<?php }?>
									<?php if ($_smarty_tpl->tpl_vars['v']->value['status']=='3') {?>
										<span style="color:#FF0000"> [未完成] </span>
									<?php }?>
								</td>
								<td><a href="javascript:(0);" onclick="khgl('index.php?m=crm_customer&c=com&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['comid'];?>
');" class="crm_submit">管理</a></td>
							</tr>
						<?php }
if (!$_smarty_tpl->tpl_vars['v']->_loop) {
?>
      					
	      					<tr align="center">
					        	<td class="ud" colspan="6"><div class="admin_notip">暂无任务安排，换个条件试试~</div></td>
					      	</tr>
      					
						<?php } ?>
						
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
								<td colspan="7" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
							</tr>
						<?php }?>
						</tbody>
					</table>
				</div>
			</div>
		</form>
	</div>
	
	<div id="taskstatus" style="display:none; width:auto">
		<table cellspacing='1' cellpadding='1' class="admin_examine_table">
			<tr>
				<td align="center" style="padding:20px;">
					<textarea id="reason" name="reason" class="admin_explain_textarea" style="width: 350px;height:150px;"></textarea>
				</td>
			</tr>
			<tr id="taskreasonsubmit">
				<td align="center">
					<input type="hidden" id="task_status" value="" />
					<input type="button" onclick="setStatusu();" value='保存' class="admin_examine_bth">
					<input type="button" class="admin_examine_bth_qx" onClick="layer.closeAll();" value='关闭'>
				</td>
			</tr>
		</table>
  	</div>
  	
	<div id="taskstatusqx" style="display:none; width:300px;text-align:center; ">
		<form class='layui-form'>
			<table cellspacing='1' cellpadding='1' class="admin_examine_table">
				<tr>
					<td align="left">
						<div class="layui-form-item">
							<div class="layui-input-block">
								<div class="admin_examine_right"  >
									<input name="type" value="1" title="取消任务 (将任务设为已取消状态)" checked type="radio" />
								</div>
							</div>
						</div>

						<div class="layui-form-item" style="margin-bottom: 14px;">
							<div class="layui-input-block">
								<div class="admin_examine_right"  >
									<input name="type" value="2" title="删除任务 (彻底删除且不可恢复)" type="radio" />
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td  align="center">
						<input type="button" onclick="setStatusqx();" value='保存' class="admin_examine_bth">
						<input type="button" class="admin_examine_bth_qx" onClick="layer.closeAll();" value='关闭'>
					</td>
				</tr>
			</table>
		</form>	
   </div>
   </div>
   
	<input type="hidden" name="taskid" id="taskid" value="">
	
	<?php echo '<script'; ?>
>
		var weburl="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
";
		
		layui.use(['form', 'laydate'], function(){
			var form = layui.form
				,laydate = layui.laydate
				,$ = layui.$;
			
			form.on('select(status)', function(data){
				var url=$('#status option:selected').attr('data-url');
				location.href=url;
			});
			form.on('select(type)', function(data){
				var url=$('#type option:selected').attr('data-url');
				if(url){
					location.href=url;
				}else{
					location.href='index.php?m=crm_waitingtask';
				}
			});
			
			laydate.render({
				elem: '#stime'
				,type: 'datetime'
			});
		});
		
		function settaskstatus(status,id,url){
			
			var pytoken	= $('#pytoken').val();
			
			if(status==2 || status==3){
				$('#task_status').val(status);
				$('#taskid').val(id);
				$('#taskreasonsubmit').show();
			 	$.layer({
					type : 1,
					title :'任务反馈', 
					closeBtn : [0 , true],
					border : [10 , 0.3 , '#000', true],
					area : ['auto','300px'],
					offset: ['20px', ''],
					page : {dom :"#taskstatus"}
				}); 	
			}else if(status==4){
				$('#taskid').val(id);
				$.layer({
					type : 1,
					title :'取消任务', 
					closeBtn : [0 , true],
					border : [10 , 0.3 , '#000', true],
					area : ['300px','240px'],
					offset: ['20px', ''],
					page : {dom :"#taskstatusqx"}
				});
			}
		}
		
		function setStatusu(){
			var pytoken	= $('#pytoken').val();
			var status	= $('#task_status').val();
			var id 		= $('#taskid').val();
			var reason 	= $('#reason').val();
			if(!reason && status == 3){
				layer.msg('请填写任务反馈信息！',2,8);return false;
			}
			loadlayer();
			$.post('index.php?m=crm_waitingtask&c=setStatus',{pytoken:pytoken,status:status,id:id,reason:reason,type:1},function(data){
				parent.layer.closeAll('loading');
				if(data==1){
					location.reload();
				}
			});
		}
		
		function setStatusqx(){
			var pytoken = 	$('#pytoken').val();
			var id 		= 	$('#taskid').val();
			var type	=	$('input[name="type"]:checked').val();
			loadlayer();
			$.post('index.php?m=crm_waitingtask&c=setStatus',{pytoken:pytoken,status:4,id:id,type:type},function(data){
				parent.layer.closeAll('loading');
				if(data==1){
					location.reload();
				}
			});
		}

		function khgl(url) {

			layer.open({
				type: 2,
				title: '客户管理',
				shadeClose: true,
				shade: false,
				maxmin: true, //开启最大化最小化按钮
				area: ['80%', '100%'],
				content: url,
				anim: 2,
				offset: 'r'
			});
		}
	<?php echo '</script'; ?>
>
	
 	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/crm_public.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

 	
</body>
</html><?php }} ?>
