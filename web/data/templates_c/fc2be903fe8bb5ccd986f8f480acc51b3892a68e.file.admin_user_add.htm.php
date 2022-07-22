<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:29:45
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_user_add.htm" */ ?>
<?php /*%%SmartyHeaderCode:3129162d90069770751-74723702%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fc2be903fe8bb5ccd986f8f480acc51b3892a68e' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_user_add.htm',
      1 => 1640333834,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3129162d90069770751-74723702',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'adminuser' => 0,
    'pytoken' => 0,
    'user_group' => 0,
    'v' => 0,
    'week' => 0,
    'key' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d90069855c38_01636722',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d90069855c38_01636722')) {function content_62d90069855c38_01636722($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<link href="./images/reset.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css"/>
	<link href="./images/system.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css"/>
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
" rel="stylesheet" type="text/css"/>
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
	<link href="./images/table_form.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css"/>
	<title></title>
</head>

<?php if ($_smarty_tpl->tpl_vars['adminuser']->value['is_crm']!=1) {?>
<style>
	.duty {
		display: none;
	}
</style>
<?php }?>

<body class="body_ifm">

<div class="infoboxp">
	<div class="tty-tishi_top">
		<div class="admin_new_tip">
			<a href="javascript:;" class="admin_new_tip_close"></a>
			<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
			<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
			<div class="admin_new_tip_list_cont">
				<div class="admin_new_tip_list">添加管理员功能根据运营需求，超级管理员可以自由添加网站的多个超级管理员、分站管理员、CRM业务员等常规化设置。</div>
				<div class="admin_new_tip_list">真实姓名填写：如果作为招聘顾问展示，建议填写虚拟称呼，如：客服-小王</div>
				<div class="admin_new_tip_list">设置为业务员/招聘顾问后，可对业务员信息进行补充完善</div>
				<div class="admin_new_tip_list duty" style="color: red;"><span style="color: blue;">客户数量：</span>业务员主动领取客户公海客户，限定已拥有客户数量，未达限定值方可领取新客户（CRM排班自动分配客户不受该条件限制）</div>
			</div>
		</div>

		<div class="clear"></div>

		<div class="common-form">
			<div class="tag_box mt10">

				<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
				<form name="myform" action="index.php?m=admin_user&c=save" target="supportiframe" method="post" id="myform" onsubmit="return saveUseradd();" class="layui-form" enctype="multipart/form-data">

					<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['adminuser']->value['uid'];?>
" name="uid"/>
					<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">

					<table width="100%" class="table_form ">
						<tbody>
						<tr>
							<th>用户名：</th>
							<td>
								<div class="layui-input-block">
									<input type="text" name="username" id="username" lay-verify="required" placeholder="请输入用户名" value="<?php echo $_smarty_tpl->tpl_vars['adminuser']->value['username'];?>
" size="30" autocomplete="off" class="layui-input t_w200">
								</div>
							</td>
							<th>密码：</th>
							<td>
								<div class="layui-input-inline" style="margin-right:10px;">
									<input type="password" name="password" id="password" lay-verify="required" placeholder="请输入密码" size="30" autocomplete="off" class="layui-input t_w200">
								</div>
								<?php if (is_array($_smarty_tpl->tpl_vars['adminuser']->value)) {?><span class="admin_web_tip">如果密码留空则不修改密码！</span><?php }?>
							</td>
						</tr>


						<tr>
							<th>真实姓名：</th>
							<td>
								<div class="layui-input-inline" style="margin-right:30px;">
									<input type="text" name="name" id="name" lay-verify="required" placeholder="请输入真实姓名" value="<?php echo $_smarty_tpl->tpl_vars['adminuser']->value['name'];?>
" size="30" autocomplete="off" class="layui-input t_w200">
								</div>
							</td>

							<th>用户组：</th>
							<td>
								<div class="layui-input-inline t_w200">
									<select name="m_id" id="m_id_val">
										<option value="">请选择</option>
										<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['user_group']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['v']->value['id']==$_smarty_tpl->tpl_vars['adminuser']->value['m_id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['group_name'];?>
</option>
										<?php } ?>
									</select>
								</div>
							</td>
						</tr>

						<tr>
							<th>是否可以登录分站：</th>
							<td>
								<div class="layui-input-block">
									<input name="isdid" value="1" title="可以登录" <?php if ($_smarty_tpl->tpl_vars['adminuser']->value['isdid']=="1") {?>checked<?php }?> type="radio"/>
									<input name="isdid" value="2" title="不可以登录" <?php if ($_smarty_tpl->tpl_vars['adminuser']->value['isdid']=="2") {?>checked<?php }?> type="radio"/>
								</div>
							</td>

							<th>业务员/招聘顾问：</th>
							<td>
								<div class="layui-input-block fl">
									<input type="checkbox" name="is_crm" value="1" lay-skin="switch" lay-text="是|否" <?php if ($_smarty_tpl->tpl_vars['adminuser']->value['is_crm']==1) {?> checked="" <?php }?> lay-filter="is_crm">
								</div>
								<span class="admin_web_tip fl ml30">业务轮值安排，可以设轮值时间和区域</span>
							</td>
						</tr>
						<tr>
							<th>企业微信账户：</th>
							<td>
								<div class="layui-input-inline" style="margin-right:30px;">
									<input type="text" name="qy_userid" id="qy_userid" placeholder="请输入企业微信账户" value="<?php echo $_smarty_tpl->tpl_vars['adminuser']->value['qy_userid'];?>
" autocomplete="off" class="layui-input t_w200">
								</div>
							</td>
							<th>登录控制：</th>
							<td>
								<div class="layui-input-inline" style="margin-right:30px;">
									<input type="text" class="layui-input t_w200" value="<?php echo $_smarty_tpl->tpl_vars['adminuser']->value['control_login'];?>
" name="control_login" id="control_login" placeholder="">
								</div>
								<span class="admin_web_tip">每天在选择固定时间内才能登录</span>
							</td>
						</tr>
						<tr>
							<th>查看后台首页统计权限：</th>
							<td>
								<div class="layui-input-inline">
									<input name="index_lookstatistc" value="1" title="否" <?php if ($_smarty_tpl->tpl_vars['adminuser']->value['index_lookstatistc']=="1") {?>checked<?php }?> type="radio"/>
									<input name="index_lookstatistc" value="2" title="是" <?php if ($_smarty_tpl->tpl_vars['adminuser']->value['index_lookstatistc']=="2") {?>checked<?php }?> type="radio"/>
								</div>
							</td>
						</tr>
						<tr class="admin_table_trbg duty">
							<th colspan="4" class="admin_bold_box">
								<div class="admin_bold" style="margin-top: 20px;">业务员/招聘顾问信息</div>
							</th>
						</tr>
						<tr class="duty">
							<th>微信号：</th>
							<td>
								<div class="layui-input-block">
									<input type="text" name="weixin" id="weixin" lay-verify="required" placeholder="请输入微信号" value="<?php echo $_smarty_tpl->tpl_vars['adminuser']->value['weixin'];?>
" size="30" autocomplete="off" class="layui-input t_w200">
								</div>
							</td>
							<th>手机号：</th>
							<td>
								<div class="layui-input-block">
									<input type="text" name="moblie" id="moblie" lay-verify="required" placeholder="请输入手机号" value="<?php echo $_smarty_tpl->tpl_vars['adminuser']->value['moblie'];?>
" size="30" autocomplete="off" class="layui-input t_w200">
								</div>
							</td>
						</tr>

						<tr class="duty">

							<th>联系QQ：</th>
							<td>
								<div class="layui-input-block">
									<input type="text" name="qq" id="qq" lay-verify="required" placeholder="请输入联系QQ" value="<?php echo $_smarty_tpl->tpl_vars['adminuser']->value['qq'];?>
" size="30" autocomplete="off" class="layui-input t_w200" />
								</div>
							</td>
							<th style="color: blue;">客户数量：</th>
							<td>
								<div class="layui-input-block fl">
									<input type="text" name="num" id="num" lay-verify="required" placeholder="请输入领取客户限制数量" value="<?php echo $_smarty_tpl->tpl_vars['adminuser']->value['num'];?>
" size="30" autocomplete="off" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'')" class="layui-input t_w200" />
								</div>
								<span class="admin_web_tip fl ml30">0或空数量不限</span>
							</td>
						</tr>

						<tr class="duty">
							<th>职业形象照：</th>
							<td>
								<button type="button" class="yun_bth_pic noupload" lay-data="{imgid: 'imgphoto'}">上传形象</button>
								<input type="hidden" id="laynoupload" value="1"/>
								<img id="imgphoto" src="<?php echo $_smarty_tpl->tpl_vars['adminuser']->value['photo_n'];?>
" style="width:36px;height:36px;" <?php if (!$_smarty_tpl->tpl_vars['adminuser']->value['photo']) {?>class="none"<?php }?> />
							</td>
							<th>微信二维码：</th>
							<td>
								<button type="button" class="yun_bth_pic noupload2" lay-data="{imgid: 'imgewm'}">上传二维码</button>
								<img id="imgewm" src="<?php echo $_smarty_tpl->tpl_vars['adminuser']->value['ewm_n'];?>
" style="width:36px;height:36px;" <?php if (!$_smarty_tpl->tpl_vars['adminuser']->value['ewm']) {?>class="none"<?php }?> />
							</td>
						</tr>

						<tr class="duty">
							<th>轮值时间：</th>
							<td colspan='3'>
								<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['week']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
								<input name="crm_duty[]" title="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" lay-skin="primary" <?php if (in_array($_smarty_tpl->tpl_vars['key']->value,$_smarty_tpl->tpl_vars['adminuser']->value['crm_duty'])) {?>checked="checked"<?php }?> type="checkbox" /><div class="layui-unselect layui-form-checkbox "><span><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
1</span><i class="layui-icon"></i></div>
								<?php } ?>
							</td>
						</tr>
						<tr class="duty">
							<th>轮值区域：</th>
							<td colspan='3'>
								<div class="layui-input-block">
									<div class="yun_resume_popup_chose_box news_expect_text_new  news_expect_text_re9" style="width:500px;">
										<input name='crm_city' id='crm_city' value="<?php echo $_smarty_tpl->tpl_vars['adminuser']->value['crm_city'];?>
" type='hidden'/>
										<select id="cityclass_search" name="cityclass_search" xm-select-type="cityclass" xm-select="cityclass_search" xm-select-search="" xm-select-max="" xm-select-skin="default" xm-select-direction="down">
											<option value="">输入区域名称搜索选择</option>
										</select>
									</div>
								</div>
							</td>
						</tr>

						<tr>
							<th style="border-bottom:none;">&nbsp;</th>
							<td align="left" style="border-bottom:none;">
								<input class="tty_sub" name="useradd" type="submit" value="提交" id="dosubmit">
							</td>
						</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/plus/city.cache.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/plus/cityparent.cache.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/formSelects-v4.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css"/>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/formSelects-v4.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
<style type="text/css">
	.layui-laydate-content > .layui-laydate-list {
		padding-bottom: 0px;
		overflow: hidden;
	}

	.layui-laydate-content > .layui-laydate-list > li {
		width: 50%
	}

	.laydate-time-list ol li {
		padding-left: 54px;
	}

	.merge-box .scrollbox .merge-list {
		padding-bottom: 5px;
	}
</style>
<?php echo '<script'; ?>
 language="javascript">
	layui.use(['layer', 'form', 'element', 'laydate'], function () {

		var layer = layui.layer
				, form = layui.form
				, element = layui.element
				, formSelects = layui.formSelects
				, laydate = layui.laydate
				, $ = layui.$;

		form.on('switch(is_crm)', function (data) {
			if (data.elem.checked) {
				$(".duty").show();
			} else {
				$(".duty").hide();
			}
			form.render();
		});
		//时间范围
		laydate.render({
			elem: '#control_login'
			, type: 'time'
			, range: true
			, format: 'HH:mm'
			, btns: ['clear', 'confirm']
			, ready: function (date) {
				var showtime1 = $($(".laydate-main-list-0 .laydate-time-list li ol")[1]).find("li");
				var showtime2 = $($(".laydate-main-list-1 .laydate-time-list li ol")[1]).find("li");
				for (var i = 0; i < showtime1.length; i++) {
					var t00 = showtime1[i].innerText;
					if (t00 != "00" && t00 != "10" && t00 != "20" && t00 != "30" && t00 != "40" && t00 != "50") {
						showtime1[i].remove()
					}
				}
				for (var i = 0; i < showtime2.length; i++) {
					var t00 = showtime2[i].innerText;
					if (t00 != "00" && t00 != "10" && t00 != "20" && t00 != "30" && t00 != "40" && t00 != "50") {
						showtime2[i].remove()
					}
				}
				$($(".laydate-time-list li ol")[2]).find("li").remove();  //清空秒
			}

		});

		formSelects.btns('cityclass_search', []);

		formSelects.on('cityclass_search', function (id, vals, val, isAdd, isDisabled) {
			var cityvalue = [];
			vals.forEach(function (item, index) {
				cityvalue.push(item.value);
			})
			$('#crm_city').val(cityvalue.join(','));
		}, true);


	});//end layui.use()

	'<?php if ($_smarty_tpl->tpl_vars['adminuser']->value['crm_city']) {?>'

	var formSelects = layui.formSelects,
			cityclassArr = $("#crm_city").val() != '' ? $("#crm_city").val().split(",") : [],
			carr = [];
	for (var i = 0; i < cityclassArr.length; i++) {
		carr.push({"name": cn[cityclassArr[i]], "value": cityclassArr[i], "selected": 'selected'});
	}
	formSelects.data('cityclass_search', 'local', {
		arr: carr
	});
	'<?php }?>'

	function saveUseradd() {
		var control_login = $.trim($("#control_login").val());
		var username = $.trim($("#username").val());
		var password = $.trim($("#password").val());
		var name = $.trim($("#name").val());
		var m_id_val = $.trim($("#m_id_val").val());
		var moblie = $("#moblie").val();
		var isdid = $('input[name="isdid"]:checked').val();


		if (username == "") {
			parent.layer.msg('请填写用户名！', 2, 8);
			return false;
		}

		<?php if (!is_array($_smarty_tpl->tpl_vars['adminuser']->value)) {?>
			if (password == "") {
				parent.layer.msg('请填写密码！', 2, 8);
				return false;
			}
			<?php }?>

		if (name == "") {
			parent.layer.msg('请填写真实姓名！', 2, 8);
			return false;
		}
		if (m_id_val == "") {
			parent.layer.msg('请选择用户组类型！', 2, 8);
			return false;
		}
		if (!isdid) {
			parent.layer.msg('请选择是否登录分站！', 2, 8);
			return false;
		}

		if (moblie && isjsMobile(moblie) == false) {
			layer.msg('手机号格式错误！', 2, 8);
			return false;
		}
		if (control_login != '') {
			var timeArr = control_login.split(" - ");
			if (timeArr[0] >= timeArr[1]) {
				layer.msg('登录控制的结束时间应该大于开始时间', 2, 8);
				return false;
			}
		}
	}
<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 type="text/javascript">
	layui.use('upload', function () {
		var $ = layui.$
				, upload = layui.upload
				, layer = layui.layer
				, device = layui.device();

		var laynoupload = $("#laynoupload").val(); 		   //1、选完不上传
		//选完不上传，url暂未用到，只是需要其样式

		if (laynoupload == 1) {
			//上传文件类型
			var layaccept = 'images', layexts = 'jpg|png|gif|bmp|jpeg';

			upload.render({
				elem: '.noupload'
				, auto: false
				, accept: layaccept
				, exts: layexts
				, field: 'photo'
				, choose: function (obj) {
					if (this.imgid) {
						//预读本地文件示例，不支持ie8/9
						var imgid = null;
						if (this.imgid) {
							imgid = this.imgid;
						}
						obj.preview(function (index, file, result) {
							if (imgid && $('#' + imgid).length > 0) {
								$('#' + imgid).removeClass('none');
								$('#' + imgid).attr('src', result); //图片链接（base64）
							}
						});
					}
				}
			});
			upload.render({
				elem: '.noupload2'
				, auto: false
				, accept: layaccept
				, exts: layexts
				, field: 'ewm'
				, choose: function (obj) {
					if (this.imgid) {
						//预读本地文件示例，不支持ie8/9
						var imgid = null;
						if (this.imgid) {
							imgid = this.imgid;
						}
						obj.preview(function (index, file, result) {
							if (imgid && $('#' + imgid).length > 0) {
								$('#' + imgid).removeClass('none');
								$('#' + imgid).attr('src', result); //图片链接（base64）
							}
						});
					}
				}
			});
		}
	});

<?php echo '</script'; ?>
>
</body>
</html><?php }} ?>
