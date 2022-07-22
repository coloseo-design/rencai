<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:15:23
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_announcement_add.htm" */ ?>
<?php /*%%SmartyHeaderCode:663162c7e79b9990f9-99258478%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f775e7e7f09c435b04be521e32707a25116c5699' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_announcement_add.htm',
      1 => 1640333834,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '663162c7e79b9990f9-99258478',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'info' => 0,
    'Dname' => 0,
    'pytoken' => 0,
    'lasturl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e79ba24263_95371853',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e79ba24263_95371853')) {function content_62c7e79ba24263_95371853($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
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
		<?php echo '<script'; ?>
 src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/ueditor/ueditor.config.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/ueditor/ueditor.all.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
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

		<title>后台管理</title>
		<style>
			.layui-form-item {
				margin-bottom: 0px;
				clear: both;
			}
		</style>
	</head>
	<body class="body_ifm">
		<div class="infoboxp">

			<div class="tty-tishi_top">
			<div class="admin_new_tip">
				<a href="javascript:;" class="admin_new_tip_close"></a>
				<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
				<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
				<div class="admin_new_tip_list_cont">
					<div class="admin_new_tip_list">添加公告主要满足运营者发布网站公告需求，针对网站大记事或优惠活动都是可以通过公告形式发布！让用户了解到网站动态！<span style="color: red">公告内容中如提供文档、表格等附件供下载，请从编辑器上传附件，不要从其他地方直接复制。</span></div>
				</div>
			</div>
			<div class="clear"></div>

				<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
				<form name="myform" target="supportiframe" action="index.php?m=admin_announcement&c=save" method="post" encType="multipart/form-data"
				 onSubmit="return checkform(this);">
					<table width="100%" class="table_form" style="background:#fff;">
						<tr class="admin_table_trbg">
							<th colspan="4" class="admin_bold_box">
								<div class="admin_bold">添加公告</div>
							</th>
						</tr>
						<tr>
							<th width="200">公告标题：</th>
							<td>
								<div class="layui-input-block t_w480">
									<input type="text" name="title" id="title" lay-verify="required" placeholder="请输入公告标题" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['title'];?>
"
									 size="40" autocomplete="off" class="layui-input">
								</div>
							</td>
						</tr>
						<tr>
							<th>使用范围：</th>
							<td><input type="button" value="<?php if ($_smarty_tpl->tpl_vars['info']->value['did']>0) {
echo $_smarty_tpl->tpl_vars['Dname']->value[$_smarty_tpl->tpl_vars['info']->value['did']];
} elseif ($_smarty_tpl->tpl_vars['info']->value['did']==-1) {?>全站<?php } else { ?>主站<?php }?>"
								 class="city_news_but t_w480" onClick="add_site('<?php echo $_smarty_tpl->tpl_vars['info']->value['did'];?>
','<?php echo $_smarty_tpl->tpl_vars['Dname']->value[$_smarty_tpl->tpl_vars['info']->value['did']];?>
');" style="text-align: left;">
								<input type="hidden" id="did" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['did'];?>
" name="did">
							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th class="t_fr">关 键 词：</th>
							<td>
								<div class="layui-input-block t_w480">
									<input type="text" name="keyword" id="keyword" lay-verify="required" placeholder="请输入关键词" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['keyword'];?>
"
									 size="50" autocomplete="off" class="layui-input">
								</div>
								<span class="admin_web_tip">多关键字，请用，隔开，请不要为空</span>
							</td>
						</tr>

                        <tr>
                            <th class="t_fr">开始时间：</th>
                            <td>
                                <div class="layui-input-block t_w480">
                                    <input type="text" name="startime" id="startime" lay-verify="required" placeholder="请输入开始时间" value="<?php if ($_smarty_tpl->tpl_vars['info']->value['startime']) {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['info']->value['startime'],'%Y-%m-%d');
}?>"
                                     size="50" autocomplete="off" class="layui-input">
                                </div>
                                <span class="admin_web_tip">默认当前时间</span>
                            </td>
                        </tr>

						<tr>
							<th class="t_fr">结束时间：</th>
							<td>
								<div class="layui-input-block t_w480">
									<input type="text" name="endtime" id="endtime" lay-verify="required" placeholder="请输入结束时间" value="<?php if ($_smarty_tpl->tpl_vars['info']->value['endtime']) {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['info']->value['endtime'],'%Y-%m-%d');
}?>"
									 size="50" autocomplete="off" class="layui-input">
								</div>
								<span class="admin_web_tip">默认时间为永久</span>
							</td>
						</tr>
						<tr>
							<th class="t_fr">描　　述：</th>
							<td>
								<div class="layui-input-block t_w480">
									<textarea name="description" placeholder="请输入描述" lay-verify="required" class="layui-textarea"
									autocomplete="off"><?php echo $_smarty_tpl->tpl_vars['info']->value['description'];?>
</textarea>
								</div>
							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th class="t_fr">公告内容： </th>
							<td>
								<?php echo '<script'; ?>
 id="myEditor" name="content" type="text/plain" style="width:700px;height:300px;"><?php echo $_smarty_tpl->tpl_vars['info']->value['content'];?>
<?php echo '</script'; ?>
>
							</td>
						</tr>

						<tr>
							<th>&nbsp;</th>
							<td align="left">
								<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
								<?php if ($_smarty_tpl->tpl_vars['info']->value['id']) {?>
								<input type="hidden" name="id" size="40" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
" />
								<input type="hidden" name="lasturl" value="<?php echo $_smarty_tpl->tpl_vars['lasturl']->value;?>
">
								<input class="layui-btn tty_sub" type="submit" name="update" value="&nbsp;更 新&nbsp;" />
								<?php } else { ?>
								<input class="layui-btn tty_sub" type="submit" name="add" value="&nbsp;添 加&nbsp;" />
								<?php }?>
								<input class="layui-btn tty_cz" type="reset" name="reset" value="&nbsp;重 置 &nbsp;" />
							</td>
						</tr>

					</table>

				</form>
			</div>
		</div>
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/checkdomain.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

		<?php echo '<script'; ?>
 language="javascript">
			layui.use(['layer', 'form', 'laydate'], function() {
				var layer = layui.layer,
					form = layui.form,
					laydate = layui.laydate,
					$ = layui.$;
				
				//定义当前时间
                var nowTime = new Date();

                //获取最小值
                let stime = $("input[name='startime']").val();
                let etime = $("input[name='endtime']").val();

				//开始时间
				laydate.render({
					elem: '#startime',
					value: stime!='' ? stime : nowTime,
					min: 0
				});
				//结束时间
				laydate.render({
					elem: '#endtime',
					value: etime!='' ? etime : '',
					min: 1
				});
			});

			function checkform(myform) {
				if (myform.title.value == "") {
					parent.layer.msg('请填写公告标题！', 2, 8);
					myform.title.focus();
					return (false);
				}

				if (myform.keyword.value == "") {
					parent.layer.msg('请填写公告关键字！', 2, 8);
					myform.keyword.focus();
					return (false);
				}

				var stime	=	$('#startime').val();
				var etime	=	$('#endtime').val();

				if(stime!='' && etime!='' && stime>etime){
					parent.layer.msg('结束时间必须大于开始时间！', 2,8);return false;
				}


				if (myform.description.value == "") {
					parent.layer.msg('请填写公告描述！', 2, 8);
					myform.description.focus();
					return (false);
				}
				loadlayer();
			}

			var ue = UE.getEditor('myEditor');
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
