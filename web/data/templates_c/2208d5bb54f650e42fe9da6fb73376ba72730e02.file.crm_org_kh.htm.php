<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:49:01
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\crm_org_kh.htm" */ ?>
<?php /*%%SmartyHeaderCode:430062d904ededc0c9-57105013%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2208d5bb54f650e42fe9da6fb73376ba72730e02' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\crm_org_kh.htm',
      1 => 1644196793,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '430062d904ededc0c9-57105013',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'adminUserList' => 0,
    'v' => 0,
    'crmType' => 0,
    'type' => 0,
    'crmClassName' => 0,
    'crmStatus' => 0,
    'cStatus' => 0,
    'yyzzStatus' => 0,
    'key' => 0,
    'yyzz' => 0,
    'ratingArr' => 0,
    'rating' => 0,
    'vipEtime' => 0,
    'etime' => 0,
    'lastFtime' => 0,
    'lftime' => 0,
    'nextFtime' => 0,
    'nftime' => 0,
    'total' => 0,
    'pytoken' => 0,
    'rows' => 0,
    'todayStart' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d904ee1d2bd0_03166791',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d904ee1d2bd0_03166791')) {function content_62d904ee1d2bd0_03166791($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	
	<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
	<link href="images/reset.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
	<link href="images/system.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
	<link href="images/table_form.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
	<link href="images/workspace.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
	
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="js/crm.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="js/show_pub.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
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
		.admin_new_c_bth{
			width:50px !important;
		}
	</style>
	
</head>

<body class="body_ifm">
	<div class="infoboxp">
        <div class="tty-tishi_top">

			<div class="tabs_info">
				<ul>
					<li <?php if (!$_GET['kh']) {?>class="curr"<?php }?>><a href="index.php?m=crm_org_kh">全部客户</a></li>
					<li <?php if ($_GET['kh']==1) {?>class="curr"<?php }?>><a href="index.php?m=crm_org_kh&kh=1">联系中的客户</a></li>
					<li <?php if ($_GET['kh']==2) {?>class="curr"<?php }?>><a href="index.php?m=crm_org_kh&kh=2">今日已跟进</a></li>
					<li <?php if ($_GET['kh']==3) {?>class="curr"<?php }?>><a href="index.php?m=crm_org_kh&kh=3">30天未跟进</a></li>
					<li <?php if ($_GET['kh']==4) {?>class="curr"<?php }?>><a href="index.php?m=crm_org_kh&kh=4">从未跟进</a></li>
					<li <?php if ($_GET['kh']==5) {?>class="curr"<?php }?>><a href="index.php?m=crm_org_kh&kh=5">15天内到期</a></li>
					<li <?php if ($_GET['kh']==6) {?>class="curr"<?php }?>><a href="index.php?m=crm_org_kh&kh=6">登录客户</a></li>
				</ul>
			</div>

			<form action="index.php" name="myform"  method="get" class='layui-form layui-form-pane'>

				<input type="hidden" name="m" value="crm_org_kh" />
				<input type="hidden" name="kh" value="<?php echo $_GET['kh'];?>
"/>

				<div class="layui-form-item">
					<div class="layui-input-inline t_w150" style="width:100px !important">
						<select name="crm_uid" id="crm_uid" lay-verify="">
							<option value="">客户经理</option>
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['adminUserList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" <?php if ($_GET['crm_uid']==$_smarty_tpl->tpl_vars['v']->value['uid']) {?>selected<?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
							<?php } ?>
						</select>
					</div>
					<div class="layui-input-inline t_w150">
						<select name="crmType" id="crmType" lay-verify="">
							<option value="">客户等级</option>
							<?php  $_smarty_tpl->tpl_vars['type'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['type']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['crmType']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['type']->key => $_smarty_tpl->tpl_vars['type']->value) {
$_smarty_tpl->tpl_vars['type']->_loop = true;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
" <?php if ($_GET['crmType']==$_smarty_tpl->tpl_vars['type']->value) {?>selected<?php }?> ><?php echo $_smarty_tpl->tpl_vars['crmClassName']->value[$_smarty_tpl->tpl_vars['type']->value];?>
</option>
							<?php } ?>
						</select>
					</div>
					<div class="layui-input-inline t_w150">
						<select name="crm_status" id="crm_status" lay-verify="">
							<option value="">客户状态</option>
							<?php  $_smarty_tpl->tpl_vars['cStatus'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cStatus']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['crmStatus']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cStatus']->key => $_smarty_tpl->tpl_vars['cStatus']->value) {
$_smarty_tpl->tpl_vars['cStatus']->_loop = true;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['cStatus']->value;?>
" <?php if ($_GET['crm_status']==$_smarty_tpl->tpl_vars['cStatus']->value) {?>selected<?php }?> ><?php echo $_smarty_tpl->tpl_vars['crmClassName']->value[$_smarty_tpl->tpl_vars['cStatus']->value];?>
</option>
							<?php } ?>
						</select>
					</div>
					<div class="layui-input-inline t_w150" style="width:130px !important">
						<select name="yyzz_status" id="yyzz_status" lay-verify="">
							<option value="">资质认证状态</option>
							<?php  $_smarty_tpl->tpl_vars['yyzz'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['yyzz']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['yyzzStatus']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['yyzz']->key => $_smarty_tpl->tpl_vars['yyzz']->value) {
$_smarty_tpl->tpl_vars['yyzz']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['yyzz']->key;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_GET['yyzz_status']==$_smarty_tpl->tpl_vars['key']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['yyzz']->value;?>
</option>
							<?php } ?>
						</select>
					</div>
					<div class="layui-input-inline t_w150">
						<select name="rating" id="rating" lay-verify="">
							<option value="">会员套餐类型</option>
							<?php  $_smarty_tpl->tpl_vars['rating'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['rating']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ratingArr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['rating']->key => $_smarty_tpl->tpl_vars['rating']->value) {
$_smarty_tpl->tpl_vars['rating']->_loop = true;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['rating']->value['id'];?>
" <?php if ($_GET['rating']==$_smarty_tpl->tpl_vars['rating']->value['id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['rating']->value['name'];?>
</option>
							<?php } ?>
						</select>
					</div>
					<div class="layui-input-inline t_w150" style="width:130px !important; <?php if ($_GET['kh']==5) {?>display: none;<?php }?>">
						<select name="vipetime" id="vipetime" lay-verify="">
							<option value="">套餐到期时间</option>
							<?php  $_smarty_tpl->tpl_vars['etime'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['etime']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['vipEtime']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['etime']->key => $_smarty_tpl->tpl_vars['etime']->value) {
$_smarty_tpl->tpl_vars['etime']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['etime']->key;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_GET['vipetime']==$_smarty_tpl->tpl_vars['key']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['etime']->value;?>
</option>
							<?php } ?>
						</select>
					</div>

					<div class="layui-input-inline t_w150" style="width:130px !important; <?php if ($_GET['kh']>=1&&$_GET['kh']<=4) {?>display: none;<?php }?>">
						<select name="lastFtime" id="lastFtime" lay-verify="">
							<option value="">最后跟进时间</option>
							<?php  $_smarty_tpl->tpl_vars['lftime'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['lftime']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['lastFtime']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['lftime']->key => $_smarty_tpl->tpl_vars['lftime']->value) {
$_smarty_tpl->tpl_vars['lftime']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['lftime']->key;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_GET['lastFtime']==$_smarty_tpl->tpl_vars['key']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['lftime']->value;?>
</option>
							<?php } ?>
						</select>
					</div>
					<div class="layui-input-inline t_w150" style="width:130px !important">
						<select name="nextFtime" id="nextFtime" lay-verify="">
							<option value="">下次跟进时间</option>
							<?php  $_smarty_tpl->tpl_vars['nftime'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['nftime']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['nextFtime']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['nftime']->key => $_smarty_tpl->tpl_vars['nftime']->value) {
$_smarty_tpl->tpl_vars['nftime']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['nftime']->key;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_GET['nextFtime']==$_smarty_tpl->tpl_vars['key']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['nftime']->value;?>
</option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="layui-form-item">
					<div class="layui-inline">
						<label class="layui-form-label">登录日期</label>
						<div class="layui-inline">
							<div class="layui-input-inline t_w100">
								<input type="text" autocomplete="off" name="loginStart" id="loginStart" class="layui-input" placeholder="开始日期">
							</div>
							<div class="layui-form-mid">-</div>
							<div class="layui-input-inline t_w100">
								<input type="text" autocomplete="off" name="loginEnd" id="loginEnd" class="layui-input" placeholder="结束日期">
							</div>
						</div>
					</div>
					<div class="layui-inline">
						<label class="layui-form-label">注册日期</label>
						<div class="layui-inline">
							<div class="layui-input-inline t_w100">
								<input type="text" autocomplete="off" name="regStart" id="regStart" class="layui-input" placeholder="开始日期">
							</div>
							<div class="layui-form-mid">-</div>
							<div class="layui-input-inline t_w100">
								<input type="text" autocomplete="off" name="regEnd" id="regEnd" class="layui-input" placeholder="结束日期">
							</div>
						</div>
					</div>
					<div class="crm_search_box layui-inline">
						<div class="crm_search_box_search formselect" did="crm_type_n">
							<span id='crm_type_name'>
								<?php if ($_GET['crm_type']==1||$_GET['crm_type']=='') {?>公司名
								<?php } elseif ($_GET['crm_type']==2) {?>联系人
								<?php } elseif ($_GET['crm_type']==3) {?>电话
								<?php } elseif ($_GET['crm_type']==4) {?>UID
								<?php }?>
							</span>
							<div class="crm_search_list" style="display:none;"  id="crm_type_n">
								<a href="javascript:void(0);" onclick="keySelect('1', 'crm_type', '公司名');">公司名</a>
								<a href="javascript:void(0);" onclick="keySelect('2', 'crm_type','联系人');">联系人</a>
								<a href="javascript:void(0);" onclick="keySelect('3', 'crm_type', '电话');">电话</a>
								<a href="javascript:void(0);" onclick="keySelect('4', 'crm_type', 'UID');">UID</a>
							</div>
						</div>
						<input type="hidden" id="crm_type" name="crm_type" value="<?php if ($_GET['crm_type']) {
echo $_GET['crm_type'];
} else { ?>1<?php }?>">
						<div class="crm_search_text" style="width:150px;"><input name="keyword" type="text" value=""></div>
						<input type="submit" value="搜索" class="crm_search_bth">
						<button type="reset"  class="crm_search_bth crm_search_bth_cz" onclick="location.href='index.php?m=crm_org_kh'">重置</button>
					</div>
				</div>
			</form>
		</div>

		<div class="tty_table-bom">
        <?php if ($_GET['self']=='1') {?>
		<div class="admin_statistics" style="margin-top:10px;">
			数据统计：
			<em class="admin_statistics_s">总数：<span class="ajaxcompanyall">0</span></em>
			<em class="admin_statistics_s">未审核：<span class="ajaxcompanystatus1">0</span></em>
			<em class="admin_statistics_s">未通过：<span class="ajaxcompanystatus2">0</span></em>
			<em class="admin_statistics_s">已锁定：<span class="ajaxcompanystatus3">0</span></em>
			搜索结果：<span><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</span>；
		</div>
		<?php }?>

		<div class="table-list" style="color:#898989; margin-top:10px;">
			
			<div class="admin_table_border">
			
				<iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
				<form action="index.php" name="myform" method="get" id='myform' target="supportiframe">
					
					<input type="hidden" name="pytoken"  id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					<input name="m" value="crm_org_kh" type="hidden"/>
					<input name="c" value="del" type="hidden"/>
					
					<table width="100%">
						<thead>
							<tr class="admin_table_top">
								<th style="width:20px;">
									<label for="chkall"></label>
								</th>
								<th align="left" width="50"> 
									<?php if ($_GET['t']=="uid"&&$_GET['order']=="asc") {?> 
										<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'uid','m'=>'crm_org_kh','untype'=>'order,t'),$_smarty_tpl);?>
">客户ID <img src="images/sanj.jpg"/></a>
									<?php } else { ?> 
										<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'uid','m'=>'crm_org_kh','untype'=>'order,t'),$_smarty_tpl);?>
">客户ID <img src="images/sanj2.jpg"/></a>
									<?php }?> 
								</th>

								<th align="left" width="160">客户名称</th>
								<th align="left" width="100">业务经理 /
									<?php if ($_GET['t']=="crm_time"&&$_GET['order']=="asc") {?>
									<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'crm_time','m'=>'crm_org_kh','untype'=>'order,t'),$_smarty_tpl);?>
">领取时间 <img src="images/sanj.jpg"/></a>
									<?php } else { ?>
									<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'crm_time','m'=>'crm_org_kh','untype'=>'order,t'),$_smarty_tpl);?>
">领取时间 <img src="images/sanj2.jpg"/></a>
									<?php }?>
								</th>
								<th align="left" width="80">
									<?php if ($_GET['t']=="login_date"&&$_GET['order']=="asc") {?>
									<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'login_date','m'=>'crm_org_kh','untype'=>'order,t'),$_smarty_tpl);?>
">登录 <img src="images/sanj.jpg"/></a>
									<?php } else { ?>
									<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'login_date','m'=>'crm_org_kh','untype'=>'order,t'),$_smarty_tpl);?>
">登录 <img src="images/sanj2.jpg"/></a>
									<?php }?>
									/ 注册</th>
								<th align="left" width="120">
									会员等级 /
									<?php if ($_GET['t']=="vipetime"&&$_GET['order']=="asc") {?>
									<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'vipetime','m'=>'crm_org_kh','untype'=>'order,t'),$_smarty_tpl);?>
">到期时间 <img src="images/sanj.jpg"/></a>
									<?php } else { ?>
									<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'vipetime','m'=>'crm_org_kh','untype'=>'order,t'),$_smarty_tpl);?>
">到期时间 <img src="images/sanj2.jpg"/></a>
									<?php }?>
								</th>
								<th align="left" width="100">联系信息</th>
								
								<th align="left" width="140">客户等级 / 客户状态</th>
								<th align="left" width="150">
									<?php if ($_GET['t']=="f_time"&&$_GET['order']=="asc") {?>
									<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'f_time','m'=>'crm_org_kh','untype'=>'order,t'),$_smarty_tpl);?>
">跟进时间 <img src="images/sanj.jpg"/></a>
									<?php } else { ?>
									<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'f_time','m'=>'crm_org_kh','untype'=>'order,t'),$_smarty_tpl);?>
">跟进时间 <img src="images/sanj2.jpg"/></a>
									<?php }?>
								</th>
								<th align="" width="80">操作</th>
								
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
							
								<tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
">
									<td>
										<!--<input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" class="check_all"  name='del[]' onclick='unselectall()' rel="del_chk"  style="margin-left:5px;"/>-->
									</td>
									<td align="left" class="td1"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
</span></td>
									
									<td align="left">
										<div><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
</div>
										<div class="" style="">
											<a href="javascript:;" onclick="khgl('index.php?m=crm_customer&c=com&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
');" class="admin_com_name"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a>
											<?php if ($_smarty_tpl->tpl_vars['v']->value['r_status']==0) {?>
												<em style="color:#f00">【未审核】</em> 
											<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['r_status']==2) {?> 
												<em style="color:#f00">【未通过】</em> 
											<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['r_status']==3) {?>
												<em style="color:#f00">【已锁定】</em> 
											<?php }?>
										</div>
										<div class="mt5">
											<?php if ($_smarty_tpl->tpl_vars['v']->value['moblie_status']==1) {?>
											<img src="../config/ajax_img/2-1.png" msg="手机已绑定" data-status="<?php echo $_smarty_tpl->tpl_vars['v']->value['moblie_status'];?>
" data-url="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
"  data-phone="<?php echo $_smarty_tpl->tpl_vars['v']->value['linktel'];?>
"  data-name="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
"  class="company_rzpng  mt_phone" width="20" height="20">
											<?php } else { ?>
											<img src="../config/ajax_img/2-2.png" msg="手机未绑定" data-status="<?php echo $_smarty_tpl->tpl_vars['v']->value['moblie_status'];?>
" data-url="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
"  data-phone="<?php echo $_smarty_tpl->tpl_vars['v']->value['linktel'];?>
"  data-name="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
"  class="company_rzpng  mt_phone" width="20" height="20">
											<?php }?>

											<?php if ($_smarty_tpl->tpl_vars['v']->value['wxid']!=''||$_smarty_tpl->tpl_vars['v']->value['wxopenid']!=''||$_smarty_tpl->tpl_vars['v']->value['app_wxid']!='') {?>
											<img src="../config/ajax_img/4-1.png" class="wxBindmsgs" msg="<?php echo $_smarty_tpl->tpl_vars['v']->value['wxBindmsg'];?>
" onclick="showQrcode('<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['wxid'];?>
')" width="20" height="20" />
											<?php } else { ?>
											<img src="../config/ajax_img/4-2.png" class="wxBindmsgs" msg="<?php echo $_smarty_tpl->tpl_vars['v']->value['wxBindmsg'];?>
" onclick="showQrcode('<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['wxid'];?>
')" width="20" height="20" />
											<?php }?>

											<?php if ($_smarty_tpl->tpl_vars['v']->value['yyzz_status']==1) {?>
											<img src="../config/ajax_img/3-1.png" msg="企业资质已认证" data-url="<?php echo $_smarty_tpl->tpl_vars['v']->value['yyzzurl'];?>
" data-ourl="<?php echo $_smarty_tpl->tpl_vars['v']->value['owner_cert_url'];?>
" data-wurl="<?php echo $_smarty_tpl->tpl_vars['v']->value['wt_cert_url'];?>
" data-otherurl="<?php echo $_smarty_tpl->tpl_vars['v']->value['other_cert_url'];?>
" data-uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" data-status="<?php echo $_smarty_tpl->tpl_vars['v']->value['yyzz_status'];?>
" data-scredit="<?php echo $_smarty_tpl->tpl_vars['v']->value['social_credit'];?>
" class="company_rzpng m_yyzz" width="20" height="20">
											<?php } else { ?>
											<img src="../config/ajax_img/3-2.png" msg="企业资质未认证" data-url="<?php echo $_smarty_tpl->tpl_vars['v']->value['yyzzurl'];?>
" data-ourl="<?php echo $_smarty_tpl->tpl_vars['v']->value['owner_cert_url'];?>
" data-wurl="<?php echo $_smarty_tpl->tpl_vars['v']->value['wt_cert_url'];?>
" data-otherurl="<?php echo $_smarty_tpl->tpl_vars['v']->value['other_cert_url'];?>
" data-uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" data-status="<?php echo $_smarty_tpl->tpl_vars['v']->value['yyzz_status'];?>
" data-scredit="<?php echo $_smarty_tpl->tpl_vars['v']->value['social_credit'];?>
" class="company_rzpng m_yyzz" width="20" height="20">
											<?php }?>
											<?php if ($_smarty_tpl->tpl_vars['v']->value['email_status']==1) {?>
											<img src="../config/ajax_img/1-1.png"  msg="邮箱已认证" data-status="<?php echo $_smarty_tpl->tpl_vars['v']->value['email_status'];?>
" data-url="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
"  data-mail="<?php echo $_smarty_tpl->tpl_vars['v']->value['linkmail'];?>
"   data-name="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" class="company_rzpng mt_email" width="20" height="20">
											<?php } else { ?>

											<img src="../config/ajax_img/1-2.png"  msg="邮箱未认证" data-status="<?php echo $_smarty_tpl->tpl_vars['v']->value['email_status'];?>
" data-url="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
"  data-mail="<?php echo $_smarty_tpl->tpl_vars['v']->value['linkmail'];?>
"  data-name="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
"  class="company_rzpng mt_email" width="20" height="20">
											<?php }?>
										</div>
									</td>

									<td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['crm_name'];?>
<br><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['crm_time'],"%Y-%m-%d");?>
</td>
									<td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['login_date_n'];?>
<br><?php echo $_smarty_tpl->tpl_vars['v']->value['reg_date_n'];?>
</td>
									<td align="left">
										<?php echo $_smarty_tpl->tpl_vars['v']->value['rating_name'];?>

										<div>
										<?php if ($_smarty_tpl->tpl_vars['v']->value['vipetime']>=$_smarty_tpl->tpl_vars['todayStart']->value) {?>
											<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['vipetime'],"%Y-%m-%d");?>
<font color='red'> (<?php echo $_smarty_tpl->tpl_vars['v']->value['vipDay'];?>
)</font>
										<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['vipetime']<$_smarty_tpl->tpl_vars['todayStart']->value&&$_smarty_tpl->tpl_vars['v']->value['vipetime']!='0') {?>
											<font color='red'> <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['vipetime'],"%Y-%m-%d");?>
 (<?php echo $_smarty_tpl->tpl_vars['v']->value['vipDay'];?>
)</font>
										<?php } else { ?>
											永久
										<?php }?>
										</div>
									</td>

									<td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['linkman'];?>
<br><?php echo $_smarty_tpl->tpl_vars['v']->value['linktel'];?>
<br><?php echo $_smarty_tpl->tpl_vars['v']->value['job_city_one'];
echo $_smarty_tpl->tpl_vars['v']->value['job_city_two'];
echo $_smarty_tpl->tpl_vars['v']->value['job_city_three'];?>
</td>
									
									<td align="left">
										<div>等级：
										<?php if ($_smarty_tpl->tpl_vars['v']->value['crm_type']) {?>
											<?php echo $_smarty_tpl->tpl_vars['v']->value['crm_type'];?>

										<?php } else { ?>
										 	--
										<?php }?>
										</div>
										<div>状态：
										<?php if ($_smarty_tpl->tpl_vars['v']->value['crm_status']) {?>
											<?php echo $_smarty_tpl->tpl_vars['v']->value['crm_status'];?>

										<?php } else { ?>
										 	--
										<?php }?>
										</div>
									</td>
								
									<td align="left">
										<div  data-content="<?php echo $_smarty_tpl->tpl_vars['v']->value['c_desc'];?>
" class="mt_c_desc">上次：
										<?php if ($_smarty_tpl->tpl_vars['v']->value['lastTime']) {?>
											<?php echo $_smarty_tpl->tpl_vars['v']->value['lastTime'];?>
<br>
										<?php } else { ?>
											<?php if ($_GET['self']) {?>
										 		<a href='javascript:void(0);' class="CrmnewFollow crm_submit_gj" data-uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
">写跟进</a>
										 	<?php } else { ?>
										 		--
										 	<?php }?>
										<?php }?>
										</div>
										<div >下次：
										<?php if ($_smarty_tpl->tpl_vars['v']->value['nextTime']) {?>
											<?php echo $_smarty_tpl->tpl_vars['v']->value['nextTime'];?>
<br>
										<?php } else { ?>
											<?php if ($_GET['self']) {?>
										 		<a href='javascript:void(0);' class="CrmnewTask crm_submit crm_submit_rw" data-id="22" data-uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
">建任务</a>
										 	<?php } else { ?>
										 		--
										 	<?php }?>
										<?php }?>
										</div>
									</td>
									<td width="80">
										<a href="javascript:;" onclick="khgl('index.php?m=crm_customer&c=com&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
');" class="crm_submit">管理</a>
									</td>
								</tr>
								
								
							<?php }
if (!$_smarty_tpl->tpl_vars['v']->_loop) {
?>
      					
		      					<tr align="left">
						        	<td class="ud" colspan="13"><div class="admin_notip">暂无客户信息~</div></td>
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
										<td colspan="4"> 从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
									<?php }?>
									<td colspan="11" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
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
</body>

<?php echo '<script'; ?>
>
	layui.use(['layer', 'form', 'laydate'], function(){
		var form 	= layui.form,
			laydate = layui.laydate,
			$ 		= layui.$;

		laydate.render({
			elem: '#loginStart',
			value: '<?php if ($_GET['loginStart']) {
echo $_GET['loginStart'];
}?>'
		});
		laydate.render({
			elem: '#loginEnd',
			value: '<?php if ($_GET['loginEnd']) {
echo $_GET['loginEnd'];
}?>'
		});

		laydate.render({
			elem: '#regStart',
			value: '<?php if ($_GET['regStart']) {
echo $_GET['regStart'];
}?>'
		});
		laydate.render({
			elem: '#regEnd',
			value: '<?php if ($_GET['regEnd']) {
echo $_GET['regEnd'];
}?>'
		});
	});

	$(document).ready(function () {

		$(".mt_c_desc").hover(function(){
			var msg=$(this).attr('data-content');
			if (msg!='') {
				layer.tips(msg, this, {
					guide: 1,
					style: ['background-color:#5EA7DC; color:#fff;top:-7px', '#5EA7DC'],
					area: ['200px', 'auto'],
					time: 5000
				});
				$(".xubox_layer").addClass("xubox_tips_border");
			}
		},function(){

			layer.closeAll('tips');
		});
	});

	function khgl(url) {

		$.layer({
			type: 2,
			shadeClose: true,
			title: '客户管理',
			area: ['80%', '100%'],
			offset: 'r',
			iframe: {src: url},
			close: function(){
				if(needLoad){
					window.location.reload();
				}else{
					$('body').css('overflow-y', '');
				}
			}
		});
	}
<?php echo '</script'; ?>
>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/crm_public.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/company_list_rztb.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


</html><?php }} ?>
