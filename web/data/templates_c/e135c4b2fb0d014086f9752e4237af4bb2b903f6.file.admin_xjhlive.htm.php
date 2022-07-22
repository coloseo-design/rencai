<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:41:02
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_xjhlive.htm" */ ?>
<?php /*%%SmartyHeaderCode:2194962c54a9ec43194-61460460%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e135c4b2fb0d014086f9752e4237af4bb2b903f6' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_xjhlive.htm',
      1 => 1635405861,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2194962c54a9ec43194-61460460',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'rows' => 0,
    'v' => 0,
    'vc' => 0,
    'Dname' => 0,
    'total' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c54a9ecd5e93_66791781',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c54a9ecd5e93_66791781')) {function content_62c54a9ecd5e93_66791781($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
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
		<style>
			.yun_wxbd_box{ background:#fff; padding-bottom:20px;}
			.yun_wxbd_img_c{ padding:40px  0 0 0;}
			.yun_wxbd_img{ width:180px;height:180px; margin:0 auto;border:1px solid #ffb97f; text-align:center; background:#fff; padding:10px;}
		</style>
	</head>
	<body class="body_ifm">
		<div class="infoboxp">
			<div class="tty-tishi_top">

				<div class="admin_new_search_box">
					<form action="index.php" name="myform" method="get">
						<input name="m" value="admin_xjhlive" type="hidden" />
						<input type="hidden" name="status" value="<?php echo $_GET['status'];?>
" />
						<div class="admin_new_search_name">直播宣讲会名称:</div>
						<input class="admin_Filter_search" type="text" name="keyword" maxlength="25" placeholder="请输入您要搜索的关键字">
						<input class="admin_Filter_bth" type="submit" value="搜索" />
						<a href="javascript:void(0)" onclick="$('.admin_screenlist_box').toggle();" class="admin_new_search_gj">高级搜索</a>
						<a href="javascript:void(0)" onclick="canAdd()" class="admin_new_cz_tj" style="width:120px">+ 添加直播宣讲会</a>
					</form>
					<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

				</div>
				<div class="clear"></div>
			</div>

			<div class="tty_table-bom">
				<div class="table-list">
					<div class="admin_table_border">
						<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
						<form action="index.php?m=admin_xjhlive&c=del" name="myform" method="post" target="supportiframe" id='myform'>
							<table width="100%">
								<thead>
									<tr class="admin_table_top">
										<th style="width:20px;">
											<label for="chkall">
												<input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' />
											</label>
										</th>
										<th> <?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?>
											<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'id','m'=>'admin_xjhlive','untype'=>'order,t'),$_smarty_tpl);?>
">ID<img src="images/sanj.jpg" /></a> <?php } else { ?>
											<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'id','m'=>'admin_xjhlive','untype'=>'order,t'),$_smarty_tpl);?>
">ID<img src="images/sanj2.jpg" /></a> <?php }?> </th>
										<th align="left">标题</th>
										<th align="center">参会企业</th>
										<th>封面</th>
										<th width="120">上架/开始时间</th>
										<th>预约次数</th>
										<th>分站</th>
										<th>状态</th>
										<th width="180">操作</th>
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
									<tr align="center" id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
										<td style="width:20px;">
											<input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="check_all" name='del[]' onclick='unselectall()' rel="del_chk" />
										</td>
										<td align="left" class="td1" style="text-align:center;"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
										<td align="left"><a href="<?php echo smarty_function_url(array('m'=>'xjhlive','c'=>'show','id'=>$_smarty_tpl->tpl_vars['v']->value['id']),$_smarty_tpl);?>
" target="_blank" title="<?php echo $_smarty_tpl->tpl_vars['v']->value['name_t'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a></td>

										<td align="center">
											<div class="admin_zph_ch_p">
											<?php if ($_smarty_tpl->tpl_vars['v']->value['comnum']) {?>
											   <?php echo $_smarty_tpl->tpl_vars['v']->value['comnum'];?>

											<?php } else { ?>
											0
											<?php }?>
											</div>
											<div class="mt5"><a href='index.php?m=admin_xjhlive&c=com&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
' class="admin_company_xg_icon">查看</a></div>
										</td>
										<td>
											<div class="admin_table_w84"><?php if (!empty($_smarty_tpl->tpl_vars['v']->value['picarr'])) {?>
											 <a href="javascript:void(0);" onclick="fmprvw('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" class="layui-btn layui-btn-small">点击查看</a><?php } else { ?>无<?php }?></div>
											<div id="preview_<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
												<?php  $_smarty_tpl->tpl_vars['vc'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vc']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['v']->value['picarr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vc']->key => $_smarty_tpl->tpl_vars['vc']->value) {
$_smarty_tpl->tpl_vars['vc']->_loop = true;
?>
												<img layer-src="<?php echo $_smarty_tpl->tpl_vars['vc']->value;?>
">
												<?php } ?>
											</div>
										</td>
										<td class="td" width="100">
											<?php if ($_smarty_tpl->tpl_vars['v']->value['statetime_n']) {
echo $_smarty_tpl->tpl_vars['v']->value['statetime_n'];
} else { ?>未上架<?php }?>
											<div><?php echo $_smarty_tpl->tpl_vars['v']->value['stime_n'];?>
</div>
										</td>
										<td><?php echo $_smarty_tpl->tpl_vars['v']->value['subnum'];?>
</td>
										<td>
											<div><?php echo $_smarty_tpl->tpl_vars['Dname']->value[$_smarty_tpl->tpl_vars['v']->value['did']];?>
</div>
											<div>
												<a href="javascript:;" onclick="checksite('<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','index.php?m=admin_xjhlive&c=checksitedid');"
												 class="admin_company_xg_icon">重新分配</a>
											</div>
										</td>
										<td><?php if ($_smarty_tpl->tpl_vars['v']->value['livestatus']==1) {?><span class="admin_com_tg">未开始</span><?php } elseif ($_smarty_tpl->tpl_vars['v']->value['livestatus']==2) {?><span class="admin_com_tg">已结束</span><?php } elseif ($_smarty_tpl->tpl_vars['v']->value['livestatus']==3) {?><span class="admin_com_Audited">直播中</span><?php }?></td>
										<td width="180" align="left">
											<a href="index.php?m=admin_xjhlive&c=add&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_new_c_bth ">修改</a>
											<a href="index.php?m=admin_xjhlive&c=xjhchat&xid=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_new_c_bth admin_new_c_rz">聊天</a> 
											<a href="javascript:void(0);" onclick="layer_del('确定要删除？','index.php?m=admin_xjhlive&c=del&xjhid=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" class="admin_new_c_bth admin_new_c_bth_sc">删除</a> 
											<a href="javascript:void(0);" onclick="liveShow('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" class="admin_new_c_bth admin_new_c_bth_pp mt5">直播</a> 
											<a href="javascript:void(0);" onclick="layer_del('确定要关闭宣讲会并停止直播？','index.php?m=admin_xjhlive&c=liveEnd&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" class="admin_new_c_bth admin_new_c_bthsh mt5">关闭</a> 
											<a href="index.php?m=admin_xjhlive&c=caster&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_new_c_bth admin_new_c_bth_more mt5">导播</a> 
										</td>
									</tr>
									<?php } ?>
									<tr>
										<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
										<td colspan="2">
											<label for="chkAll2">全选</label>&nbsp;
											<input class="admin_button" type="button" name="delsub" value="删除所选" onclick="return really('del[]')" />
										</td>
									</tr>
									<?php if ($_smarty_tpl->tpl_vars['total']->value>$_smarty_tpl->tpl_vars['config']->value['sy_listnum']) {?>
									<tr>
										<?php if ($_smarty_tpl->tpl_vars['pagenum']->value==1) {?>
										<td colspan="3"> 从 1 到 <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
										<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value>1&&$_smarty_tpl->tpl_vars['pagenum']->value<$_smarty_tpl->tpl_vars['pages']->value) {?> <td colspan="3">
										从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['pagenum']->value*$_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共
										<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条
										</td>
										<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value==$_smarty_tpl->tpl_vars['pages']->value) {?>
										<td colspan="3">
											从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 ，总共<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条
										</td>
										<?php }?>
										<td colspan="8" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
									</tr>
									<?php }?>
								</tbody>
							</table>
							<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
						</form>
					</div>
				</div>
			</div>
		</div>
		<div id="liveDiv" style="display: none;">
			<div class="yun_wxbd_box">
				<div class="yun_wxbd_img_c">
					<div class="yun_wxbd_img">
						<img src="" width="180" height="180" />
					</div>
				</div>
			</div>
		</div>
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/checkdomain.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


		<?php echo '<script'; ?>
 type="text/javascript">
			layui.use('form', function() {
				var form = layui.form
			});
			function fmprvw(id){
				var img = $('#preview_' + id).find('img');
				
				var imgarr = [];
				for(var i=0; i<img.length; i++){
					var obj = {
						"alt": "图片" + i,
						"pid": i,
						"src": $(img[i]).attr('layer-src'), 
						"thumb": ""
					}
					imgarr.push(obj);
				}
				var pvw = {
				  "title": "直播宣讲会", 
				  "id": id,
				  "start": 0,
				  "data": imgarr
				}
				layer.photos({
				   photos: pvw
				  ,anim: 5
				}); 
			}
			function liveShow(id){
				var pytoken = $("#pytoken").val();
				loadlayer();
				$.post('index.php?m=admin_xjhlive&c=getLive',{id:id,pytoken:pytoken}, function(data){
					parent.layer.closeAll();
					if(data){
						var res = JSON.parse(data);
						if(res.errcode == 9){
							$("#liveDiv").find('img').attr('src', res.url);
							layer.open({
								type : 1,
								title : '微信扫码开始直播',
								closeBtn : 1,
								border : [ 10, 0.3, '#000', true ],
								area : [ '250px', '210px' ],
								content : $("#liveDiv")
							});
						}else{
							parent.layer.msg(res.msg, 2, 8)
						}
					}
				})
			}
			function canAdd(){
				var pytoken = $("#pytoken").val();
				loadlayer();
				$.post('index.php?m=admin_xjhlive&c=canAdd',{pytoken:pytoken}, function(data){
					parent.layer.closeAll();
					if(data){
						var res = JSON.parse(data);
						if(res.errcode == 0){
							window.location.href = 'index.php?m=admin_xjhlive&c=add';
						}else{
							if(res.errcode == 101){
								parent.layer.msg('直播宣讲会服务已过期', 2, 8)
							}else{
								parent.layer.msg(res.msg, 2, 8)
							}
						}
					}
				})
			}
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
