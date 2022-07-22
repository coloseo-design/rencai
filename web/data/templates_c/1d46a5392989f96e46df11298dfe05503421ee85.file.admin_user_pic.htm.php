<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:16:02
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_user_pic.htm" */ ?>
<?php /*%%SmartyHeaderCode:16662d8fd323c56a5-36850107%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1d46a5392989f96e46df11298dfe05503421ee85' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_user_pic.htm',
      1 => 1643078082,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16662d8fd323c56a5-36850107',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'rows' => 0,
    'list' => 0,
    'total' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d8fd324b3b40_26964519',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d8fd324b3b40_26964519')) {function content_62d8fd324b3b40_26964519($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
		<?php echo '<script'; ?>
 src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
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
		<title>后台管理</title>
	</head>

	<body class="body_ifm">
		<div class="infoboxp">
			
			<div class="tty-tishi_top">
				
			<div class="tabs_info">
				<ul>
					<li class="curr"><a href="index.php?m=admin_user_pic">个人头像</a></li>
					<li><a href="index.php?m=admin_user_pic&c=show">作品案例</a></li>
				</ul>
			</div>	
			
			<div class="admin_new_search_box">
				<div class="admin_new_search_name">搜索类型：</div>
				<form action="index.php" name="myform" method="get">
					<input type="hidden" name="m" value="admin_user_pic" />
					<div class="admin_Filter_text formselect" did="dcom_type">
						<input type="button" value="<?php if ($_GET['type']=='1'||$_GET['type']=='') {?> 个人姓名 <?php } elseif ($_GET['type']=='2') {?> 用户ID <?php }?>" class="admin_new_select_text" id="bcom_type">
						<input type="hidden" name="type" id="com_type" value="<?php if ($_GET['type']) {
echo $_GET['type'];
} else { ?>1<?php }?>" />
			
						<div class="admin_Filter_text_box" style="display:none" id="dcom_type">
							<ul>
								<li><a href="javascript:void(0)" onClick="formselect('1','com_type','个人姓名')">个人姓名</a></li>
								<li><a href="javascript:void(0)" onClick="formselect('2','com_type','用户ID')">用户ID</a></li>
							</ul>
						</div>
					</div>
					<input type="text" placeholder="输入你要搜索的关键字" name="keyword" class="admin_new_text">
					<input type="submit" name='news_search' value="搜索" class="admin_new_bth" />
					<a href="javascript:void(0)" onclick="$('.admin_screenlist_box').toggle();" class="admin_new_search_gj">高级搜索</a>
				</form>
				<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			</div>
			
			<div class="clear"></div>
			</div>

			<div class="main_tag mt10">

				

				<div class="tag_box">
					<div class="clear"></div>

					<form action="index.php?m=admin_user_pic&c=delPhoto" target="supportiframe" name="myform" id='myform' method="post">
						<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
						<?php  $_smarty_tpl->tpl_vars['list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['list']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['list']->key => $_smarty_tpl->tpl_vars['list']->value) {
$_smarty_tpl->tpl_vars['list']->_loop = true;
?>
						<div class="admin_zph_img">
							<div class="admin_zph_img_box">
								<div class="admin_com_img_box_img">
									<img src="<?php echo $_smarty_tpl->tpl_vars['list']->value['photo'];?>
" lay-src="<?php echo $_smarty_tpl->tpl_vars['list']->value['photo'];?>
" id="pix<?php echo $_smarty_tpl->tpl_vars['list']->value['uid'];?>
" width="140" height="140" >

									<input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['list']->value['uid'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" class="admin_com_img_checkbox check_all">

									<div class="admin_zph_img_box_img_p" title="<?php echo $_smarty_tpl->tpl_vars['list']->value['username_n'];
if ($_smarty_tpl->tpl_vars['list']->value['photo_status']=='0') {?>已审核<?php } elseif ($_smarty_tpl->tpl_vars['list']->value['photo_status']=='1') {?>未审核<?php } elseif ($_smarty_tpl->tpl_vars['list']->value['photo_status']=='2') {?>未通过<?php }?>">
										<?php echo $_smarty_tpl->tpl_vars['list']->value['username_n'];?>

										<?php if ($_smarty_tpl->tpl_vars['list']->value['photo_status']=='0') {?>
										<span>
											<font color="#1bbe36">已审核</font>
										</span>
										<?php } elseif ($_smarty_tpl->tpl_vars['list']->value['photo_status']=='1') {?>
										<span>
											<font color="#f00">未审核</font>
										</span>
										<?php } elseif ($_smarty_tpl->tpl_vars['list']->value['photo_status']=='2') {?>
										<span>
											<font color="#f00"> 未通过</font>
										</span>
										<?php }?>
									</div>
								</div>

								<div class="admin_zph_img_box_p">

									<a href="javascript:void(0)" pid="<?php echo $_smarty_tpl->tpl_vars['list']->value['uid'];?>
" status="<?php echo $_smarty_tpl->tpl_vars['list']->value['photo_status'];?>
" class="admin_new_c_bth admin_new_c_bthsh status">审核</a>
									<a href="javascript:addImg('<?php echo $_smarty_tpl->tpl_vars['list']->value['uid'];?>
','<?php echo $_smarty_tpl->tpl_vars['list']->value['name_n'];?>
','<?php echo $_smarty_tpl->tpl_vars['list']->value['photo'];?>
')" class="admin_new_c_bth">修改</a>

									<a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=admin_user_pic&c=delPhoto&del=<?php echo $_smarty_tpl->tpl_vars['list']->value['uid'];?>
');" class="admin_new_c_bth admin_new_c_bth_sc">删除</a>
								</div>
							</div>
						</div>
						<?php } ?>

						<div class="clear"></div>

						<div class="admin_com_img_box_digg">
							<span class="admin_com_img_box_qx">
								<input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)'><label for="chkAll2">全选</label>
								<input type="button" name="delsub" onClick="return really('del[]')" value="批量删除" class="admin_button">
								<input type="button" name="delsub" onClick="StatusAll();" value="批量审核" class="admin_button">
							</span>
						</div>

						<?php if ($_smarty_tpl->tpl_vars['total']->value>15) {?>
						<div class="admin_com_img_box_digg">
							<?php if ($_smarty_tpl->tpl_vars['pagenum']->value==1) {?>
							<span class="admin_com_img_box_qx"> 从 1 到 15 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</span>
							<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value>1&&$_smarty_tpl->tpl_vars['pagenum']->value<$_smarty_tpl->tpl_vars['pages']->value) {?> 
							<span class="admin_com_img_box_qx"> 从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*15+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['pagenum']->value*15;?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</span>
							<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value==$_smarty_tpl->tpl_vars['pages']->value) {?>
							<span class="admin_com_img_box_qx"> 从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*15+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 ，总共<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</span>
							<?php }?>
							<div class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</div>
						</div>
						<?php }?>
					</form>
				</div>

				<div class="clear"></div>
				<div id="info_div" style="display:none; width: 390px;padding-bottom: 10px;">
					<div class="">
						<form class="layui-form" action="index.php?m=admin_user_pic&c=status" target="supportiframe" method="post" onsubmit="return htStatus()">
							<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
							<input name="uid" value="0" type="hidden">
							<table cellspacing='1' cellpadding='1' class="admin_examine_table">
								<tr>
									<th width="80">审核操作：</th>
									<td align="left">
										<div class="layui-input-block">
											<input name="status" id="state0" value="0" title="正常" type="radio" />
											<input name="status" id="state2" value="2" title="未通过" type="radio" />
										</div>
									</td>
								</tr>
								<tr>
									<th class="t_fr">审核说明：</th>
									<td align="left"> <textarea id="statusbody" name="statusbody" class="admin_explain_textarea"></textarea> </td>
								</tr>
								<tr>
									<th></th>
									<td>
										<span class="admin_web_tip" style="padding-top: 0;">审核未通过将删除图片</span>
									</td>
								</tr>
								
								<tr>
									<td colspan='2' align="center">
										<input type="submit" value='确认' class="admin_examine_bth">
										<input type="button" id="zxxCancelBtn" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'>
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>

				<div class="subnav" id="addImage" style="display:none">
					<div class="">
						<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
						<form name="myform" target="supportiframe" action="index.php?m=admin_user_pic&c=savePhoto" method="post" encType="multipart/form-data" onsubmit="return ckform()">
							<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">

							<div class="zph_tjlist">
								<em class="zph_tjlist_s">姓名：</em>
								<input class="layui-input" id="name" type="text" value="" disabled />
							</div>
							
							
							
							<div class="zph_tjlist">
								<em class="zph_tjlist_s">上传图片：</em>
								
								<div class="admin_uppicbox" style="width: 100px;height: 100px;">
									<input type="hidden" id="laynoupload" value="1">
								
									<div class="admin_uppicimg" id="imgparent" class="none">
										<img id="imgicon" width="100" height="100" />
									</div>
								
									<span>
										<button type="button" class="noupload adminupbtn"  lay-data="{imgid: 'imgicon',parentid: 'imgparent'}">重新上传</button>		
									</span>
								</div>
								
							</div>
							
							<div class="zph_tjlist tty_tc_botm">
								<input type="hidden" name="id" value="" />
								<input class="t_tanc_btn" type="submit" name="update" value="修改" style="margin-left:0px;">
							</div>
						</form>
					</div>
				</div>
				<div id="preview" style="display:none; width:400px; ">
					<div style="height:300px; overflow:auto; width:auto; ">
						<div class="job_box_div" style="text-align:center;"></div>
					</div>
				</div>

			</div>

			<?php echo '<script'; ?>
>
				layui.use(['layer'], function() {
					var layer = layui.layer,
						$ = layui.$;
					layer.photos({
					  photos: '#myform',
					  anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
					}); 
				});
				var weburl = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
';
				$(function() {
					$(".status").click(function() {
						$("input[name=pid]").val($(this).attr("pid"));
						var uid = $(this).attr("pid");
						var status = $(this).attr("status");

						$("#state" + status).attr("checked", true);

						layui.use(['form'], function() {
							var form = layui.form;
							form.render();
						});
						$("input[name=uid]").val(uid);
						$.get("index.php?m=admin_user_pic&c=getStatusBody&uid=" + uid, function(msg) {
							$("#statusbody").val($.trim(msg));
							$.layer({
								type: 1,
								title: '个人头像审核',
								closeBtn: [0, true],
								border: [10, 0.3, '#000', true],
								area: ['390px', 'auto'],
								page: {
									dom: "#info_div"
								}
							});
						});
					});
				});
				function ckform() {
					if ($("input[name=id]").val() == '') {
						var pic = $("input[name=pic]").val();
						if (!pic) {
							layer.msg('请上传图片！', 2, 8);
							return false;
						}
					}
					loadlayer();
				}

				function addImg(id, name, picUrl) {
					$("#name").val(name);
					$('#imgicon').attr('src', picUrl);// 要修改的图片展示
					$("input[name=id]").val(id);
					$.layer({
						type: 1,
						title: '修改个人头像',
						closeBtn: [0, true],
						border: [10, 0.3, '#000', true],
						area: ['400px', '300px'],
						page: {
							dom: "#addImage"
						}
					});
				}

				function StatusAll() {
					var codewebarr = "";
					$(".check_all:checked").each(function() { //由于复选框一般选中的是多个,所以可以循环输出
						if (codewebarr == "") {
							codewebarr = $(this).val();
						} else {
							codewebarr = codewebarr + "," + $(this).val();
						}
					});
					if (codewebarr == "") {
						parent.layer.msg('您还未选择需要审核的头像！', 2, 8);
						return false;
					} else {
						layui.use(['form'], function() {
							var form = layui.form;
							form.render();
						});
						$("input[name=uid]").val(codewebarr);
						$("#statusbody").val('');
						$("input[name='status']").attr('checked', false);

						$.layer({
							type: 1,
							title: '个人头像审核',
							closeBtn: [0, true],
							border: [10, 0.3, '#000', true],
							area: ['390px', 'auto'],
							page: {
								dom: "#info_div"
							}
						});
					}
				}
			<?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui.upload.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type='text/javascript'><?php echo '</script'; ?>
>
		</div>
	</body>
</html>
<?php }} ?>
