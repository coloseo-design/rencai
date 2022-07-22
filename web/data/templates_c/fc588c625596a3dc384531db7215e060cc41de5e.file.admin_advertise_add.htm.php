<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 16:35:24
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_advertise_add.htm" */ ?>
<?php /*%%SmartyHeaderCode:2130362d90fcc027c61-94400345%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fc588c625596a3dc384531db7215e060cc41de5e' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_advertise_add.htm',
      1 => 1637309410,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2130362d90fcc027c61-94400345',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'info' => 0,
    'Dname' => 0,
    'class' => 0,
    'v' => 0,
    'appad' => 0,
    'pytoken' => 0,
    'lasturl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d90fcc116ef6_64166178',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d90fcc116ef6_64166178')) {function content_62d90fcc116ef6_64166178($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
" rel="stylesheet">
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
		<style>
			* {margin: 0 ;padding: 0;}
			body,div{ margin: 0 ;padding: 0;}
		</style>
		<title>后台管理</title>
	</head>
	<body class="body_ifm">
		<div class="infoboxp">
			<div class="tty-tishi_top">
			<div class="admin_new_tip">
				<a href="javascript:;" class="admin_new_tip_close"></a>
				<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
				<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
				<div class="admin_new_tip_list_cont">
					<div class="admin_new_tip_list">添加广告时，请正确选择分类和类型。广告分类由：“分站、主站”和广告形式（联盟广告、图片和flash）等个性化设置。</div>
				</div>
			</div>
			<div class="clear"></div>
			
				<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
				<form name="myform" target="supportiframe" action="index.php?m=advertise&c=ad_saveadd" method="post" encType="multipart/form-data" onsubmit="return checkform();" class="layui-form" autocomplete="off">
					<table width="100%" class="table_form">
						<tr>
							<th colspan="2" class="admin_bold_box">
								<span class="admin_bold"><?php if (is_array($_smarty_tpl->tpl_vars['info']->value)) {?>更新广告<?php } else { ?>添加广告<?php }?></span>
							</th>
						</tr>
						<tr>
							<th width="200">广告名称：</th>
							<td>
								<div class="layui-input-block">
									<div class="layui-input-inline t_w480">
										<input class="layui-input" id="ad_name" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['ad_name'];?>
" name="ad_name" size="30">
									</div>
									<input type="checkbox" name="target" value="2" <?php if ($_smarty_tpl->tpl_vars['info']->value['target']!=1) {?>checked<?php }?> title="新窗口打开">
								</div>
							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th width="200">使用范围：</th>
							<td>
								<input type="button" value="<?php if ($_smarty_tpl->tpl_vars['info']->value['did']>0) {
echo $_smarty_tpl->tpl_vars['Dname']->value[$_smarty_tpl->tpl_vars['info']->value['did']];
} elseif ($_smarty_tpl->tpl_vars['info']->value['did']==-1) {?>全站<?php } else { ?>主站<?php }?>" class="city_news_but t_w480" 
								onClick="add_site('<?php echo $_smarty_tpl->tpl_vars['info']->value['did'];?>
','<?php echo $_smarty_tpl->tpl_vars['Dname']->value[$_smarty_tpl->tpl_vars['info']->value['did']];?>
');" style="text-align: left;"/>
								<input type="hidden" id="did" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['did'];?>
" name="did"/>
							</td>
						</tr>
						<tr>
							<th width="200">广告所属分类：</th>
							<td>
								<div class="layui-input-block t_w480">
									<select name="class_id" lay-filter="" id="class_id_val">
										<option value="">请选择</option>
										<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['class']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['info']->value['class_id']==$_smarty_tpl->tpl_vars['v']->value['id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['class_name'];?>
</option>
										<?php } ?> 
									</select> 
								</div> 
							</td> 
						</tr> 
						<tr class="admin_table_trbg">
							<th width="200">广告是否启用：</th>
							<td>
								<div class="layui-input-block">
									<div class="layui-input-inline">
										<input name='is_open' value='1' type='radio' <?php if ($_smarty_tpl->tpl_vars['info']->value['is_open']=='1') {?>checked<?php }?> title="启用" />
										<input name='is_open' value='0' type='radio' <?php if ($_smarty_tpl->tpl_vars['info']->value['is_open']=='0') {?>checked<?php }?> title="关闭" />
									</div>
								</div>
							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th width="200">广告有效期：</th>
							<td>
								<div class="layui-input-block">
									<div class="layui-input-inline t_w150">
										<input class="layui-input" type="text" id="ad_time_start" size="30" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['time_start'];?>
" name="ad_time_start" placeholder="生效时间"/>
										<i class="t_list_icon_time"></i>
									</div>
									-
									<div class="layui-input-inline t_w150">
										<input class="layui-input" type="text" id="ad_time_end" size="30" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['time_end'];?>
" name="ad_time_end" placeholder="结束时间"/>
										<i class="t_list_icon_time"></i>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<th width="200" class="t_fl">备注：</th>
							<td><textarea cols="50" rows="3" name="remark" class="layui-textarea t_w480"><?php echo $_smarty_tpl->tpl_vars['info']->value['remark'];?>
</textarea></td>
						</tr>
						<tr>
							<th width="200" class="t_fl">排序：</th>
							<td>
								<div class="layui-input-block t_w480">
									<input class="layui-input" type="text" id="sort" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['sort'];?>
" name="sort" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
								</div>
								<span class="admin_web_tip">越大越在前</span>
							</td>
						</tr>
						<?php if ($_smarty_tpl->tpl_vars['appad']->value) {?>
						<tr>
							<th width="200" class="t_fl">移动端跳转链接：</th>
							<td>
								<div class="layui-input-block t_w480">
									<input class="layui-input" type="text" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['appurl'];?>
" name="appurl" />
								</div>
								<span class="admin_web_tip">如:/pages/company/show?id=1(仅限APP和小程序使用)</span>
							</td>
						</tr>
						<?php }?>
						<tr>
							<th width="200">广告类型：</th>
							<td colspan="2">
								<div class="layui-input-block">
									<input type="radio" id="word_ad" name="ad_type" value="word" lay-filter="ad_type" <?php if ($_smarty_tpl->tpl_vars['info']->value['ad_type']=="word") {?>checked<?php }?> title="文字广告" />
									<input type="radio" id="pic_ad" name="ad_type" value="pic" lay-filter="ad_type" <?php if ($_smarty_tpl->tpl_vars['info']->value['ad_type']=="pic") {?>checked<?php }?> title="图片广告" />
									<input type="radio" id="flash_ad" name="ad_type" value="flash" lay-filter="ad_type" <?php if ($_smarty_tpl->tpl_vars['info']->value['ad_type']=="flash") {?>checked<?php }?> title="FLASH广告" />
									<input type="radio" id="lianmeng_ad" name="ad_type" value="lianmeng" lay-filter="ad_type" <?php if ($_smarty_tpl->tpl_vars['info']->value['ad_type']=="lianmeng") {?>checked<?php }?> title="联盟广告" />
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding:0; background:none">
								<table width="100%" id="word" style="display:none">
									<tr style="display: block;">
										<th width="200">文字信息：</th>
										<td><input class='layui-input t_w480' id="word_info" name='word_info' value='<?php echo $_smarty_tpl->tpl_vars['info']->value['word_info'];?>
'></td>
									</tr>
									<tr style="display: block;margin-top: 24px;">
										<th width="200" class="t_fl">文字链接：</th>
										<td>
											<input class='layui-input t_w480' id="word_url" name='word_url' value='<?php echo $_smarty_tpl->tpl_vars['info']->value['word_url'];?>
'>
											<span class="admin_web_tip">外部链接请加上“http://”</span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						
						<tr>
							<td colspan="2" style="padding:0; background:none">
								<table id="pic" style="display:none;" width="100%">
									<tr style="display: block;margin-top: -24px;">
										<th width="200" class="t_fl">图片地址：</th>
										<td id='typeid'>
											<div class="layui-input-block" style="width: 600px;">
												<div class="layui-input-block">
													<input id='upload' lay-filter="upload" checked type='radio' name='upload' title="远程地址" value="upload">
													<input id='upload_pic' lay-filter="upload" type='radio' name='upload' title="本地上传" value="upload_pic">
												</div>
												
												<div class="layui-input-inline t_w480" style="margin-top: 12px;margin-bottom: 20px">

													<input class='layui-input' type='text' id='upload_url' name='pic_url' value='<?php echo $_smarty_tpl->tpl_vars['info']->value['pic_url_n'];?>
'>
													<div id="pic_div" class="yun_file_box_gg" style="display:none;">
														<button type="button" class="yun_bth_pic noupload" lay-data="{imgid: 'imgicon',parentid:'imgparent'}">上传图片</button>
														<input type="hidden" id="laynoupload" value="1" />
													</div>
												</div>
											</div>
										</td>
									</tr>
									<tr class="<?php if ($_smarty_tpl->tpl_vars['info']->value['pic_url']) {?> <?php } else { ?>none<?php }?>" id="imgparent" style="margin-top: 24px;">
										<th width="200" class="t_fl">图片：</th>
										<td style="display: block;">
											<img id="imgicon" src="<?php echo $_smarty_tpl->tpl_vars['info']->value['pic_url_n'];?>
" width="100" height="40" style="padding-left: 15px">
										</td>
									</tr>
									<tr style="display: block;margin-top: 24px;">
										<th width="200" class="t_fl">图片链接：</th>
										<td><input class='layui-input t_w480' id="pic_src" name='pic_src' value='<?php echo $_smarty_tpl->tpl_vars['info']->value['pic_src'];?>
'><span class="admin_web_tip">外部链接请加上“http://”</span></td>
									</tr>
									<tr style="display: block;margin-top: 24px;">
										<th width="200" class="t_fl">图片描述：</th>
										<td>
											<input class='layui-input t_w480' id="pic_content" name='pic_content' value='<?php echo $_smarty_tpl->tpl_vars['info']->value['pic_content'];?>
'><span class="admin_web_tip">例如：公司名称或图片介绍，可留空</span>
										</td>
									</tr>
									<tr style="display: block;margin-top: 24px;">
										<th width="200">图片宽度：</th>
										<td>
											<input class='tty_input t_w100' id="pic_width" size='8' onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name='pic_width' value='<?php echo $_smarty_tpl->tpl_vars['info']->value['pic_width'];?>
' style="width:90px;"> px(像素) 
										</td>
									</tr>
									<tr style="display: block;margin-top: 24px;">
										<th width="200">图片高度：</th>
										<td>
											<input class='tty_input t_w100' id="pic_height" size='8' onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name='pic_height' value='<?php echo $_smarty_tpl->tpl_vars['info']->value['pic_height'];?>
' style="width:90px;"> px(像素)
										</td>
									</tr>
								</table>
								<table id="flash" style="display:none;" width="100%">
									<tr style="display: block;margin-top: -24px;">
										<th width="200" class="t_fl">FLASH地址：</th>
										<td id='flashid'>
											<div class="layui-input-block">
												<input class='layui-input t_w480' id="flash_url" name='flash_url' value='<?php echo $_smarty_tpl->tpl_vars['info']->value['flash_url'];?>
'>
												<div id="flash_div" class="yun_file_box" style="display:none;">
													上传falsh
													<input type="file" size="45" id='upload_flash_url' name='flash_url' class="yun_file_bth">
												</div>
												<input type='radio' id='link_flash' lay-filter="flash" checked name='flash' title="远程地址" value="flash" class="layui-input t_w480">
												<input type='radio' id='upload_flash' lay-filter="flash" name='flash' title="本地上传" value="upload_flash">
											</div>
										</td>
									</tr>
									<tr style="display: block;margin-top: 24px;">
										<th width="200">FLASH宽度：</th>
										<td>
											<input class='tty_input t_w100' id="flash_width" name='flash_width' value='<?php echo $_smarty_tpl->tpl_vars['info']->value['flash_width'];?>
'>px(像素)
										</td>
									</tr>
									<tr style="display: block;margin-top: 24px;">
										<th width="200">FLASH高度：</th>
										<td>
											<input class='tty_input t_w100' id="flash_height" name='flash_height' value='<?php echo $_smarty_tpl->tpl_vars['info']->value['flash_height'];?>
'>px(像素)
										</td>
									</tr>
								</table>
								<table id="lianmeng" style="display:none;" width="100%">
									<tr style="display: block;margin-top: -24px;">
										<th width="200" class="t_fl">联盟广告代码：</th>
										<td id='lianmengid'>
											<textarea class="layui-textarea t_w480" id="lianmeng_url" name='lianmeng_url'><?php echo $_smarty_tpl->tpl_vars['info']->value['lianmeng_url'];?>
</textarea>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<?php if (is_array($_smarty_tpl->tpl_vars['info']->value)) {?>
						<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
">
						<?php }?>
						<tr class="admin_table_trbg">
							<td align="left">&nbsp;</td>
							<td align="left">
								<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
								<input type="hidden" name="lasturl" value="<?php echo $_smarty_tpl->tpl_vars['lasturl']->value;?>
">
								<input class="layui-btn tty_sub" type="submit" name="submit" value="&nbsp;提  交&nbsp;" />
								<input class="layui-btn tty_cz" type="reset" name="reset" value="&nbsp;重 置 &nbsp;" />
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/checkdomain.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

		<?php echo '<script'; ?>
>
			layui.use(['layer', 'form', 'laydate'], function() {
				var layer = layui.layer,
					form = layui.form,
					laydate = layui.laydate,
					$ = layui.$;

				laydate.render({
					elem: '#ad_time_start'
				});
				laydate.render({
					elem: '#ad_time_end'
				});
				if ('<?php echo $_smarty_tpl->tpl_vars['info']->value['ad_type'];?>
') {
					$("#<?php echo $_smarty_tpl->tpl_vars['info']->value['ad_type'];?>
").show();
				}

				form.on('radio(ad_type)', function(data) {
					var type = data.value;
					if (type == "word") {
						$("#word").show();
						$("#pic").hide();
						$("#flash").hide();
						$("#lianmeng").hide();
					} else if (type == "pic") {
						$("#word").hide();
						$("#pic").show();
						$("#flash").hide();
						$("#lianmeng").hide();
					} else if (type == "flash") {
						$("#word").hide();
						$("#pic").hide();
						$("#flash").show();
						$("#lianmeng").hide();
					} else if (type == "lianmeng") {
						$("#word").hide();
						$("#pic").hide();
						$("#flash").hide();
						$("#lianmeng").show();
					}

					form.render();
				});

				form.on('radio(upload)', function(data) {
					var type = data.value;
					if (type == "upload") {
						$("input[name=upload]").removeAttr('checked');
						$("input[name=pic_url]").removeAttr('name');
						$("#upload").attr('checked', true);
						$("#upload_url").attr('name', 'ad_url');
						$("#pic_div").hide();
						$("#upload_url").show();
					} else if (type == "upload_pic") {
						$("input[name=upload]").removeAttr('checked');
						$("input[name=pic_url]").removeAttr('name');
						$("#upload_pic").attr('checked', true);
						$("#upload_pic_url").attr('name', 'ad_url');
						$("#pic_div").show();
						$("#upload_url").hide();
					}

					form.render();
				});

				form.on('radio(flash)', function(data) {
					var type = data.value;
					if (type == "flash") {
						$("input[name=flash]").removeAttr('checked');
						$("input[name=flash_url]").removeAttr('name');
						$("#link_flash").attr('checked', true);
						$("#flash_url").attr('name', 'flash_url');
						$("#flash_div").hide();
						$("#flash_url").show();
					} else if (type == "upload_flash") {
						$("input[name=flash]").removeAttr('checked');
						$("input[name=flash_url]").removeAttr('name');
						$("#upload_flash").attr('checked', true);
						$("#upload_flash_url").attr('name', 'flash_url');
						$("#flash_div").show();
						$("#flash_url").hide();
					}

					form.render();
				});

			});

			function checkform() {
				if ($("#ad_name").val() == "") {
					parent.layer.msg('广告名称不能为空！', 2, 8);
					return false;
				}
				if ($("#ad_time_start").val() == "") {
					parent.layer.msg('请填写广告生效时间！', 2, 8);
					return false;
				}

				if ($("#ad_time_end").val() == "") {
					parent.layer.msg('请填写广告结束时间！', 2, 8);
					return false;
				}

				var item = $('input[name="ad_type"]:checked').val();

				if (!item) {
					parent.layer.msg('请选择一种广告类型！', 2, 8);
					return false;
				} else {
					if (item == "word" && $("input[name=word_info]").val() == "") {
						parent.layer.msg('请填写文字信息！', 2, 8);
						return false;
					}
				}
				loadlayer();
			}
			var weburl = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
';
		<?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui.upload.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type='text/javascript'><?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
