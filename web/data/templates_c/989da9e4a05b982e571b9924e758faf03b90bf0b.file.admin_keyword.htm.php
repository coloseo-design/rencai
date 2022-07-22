<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:19:57
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_keyword.htm" */ ?>
<?php /*%%SmartyHeaderCode:1583462c7e8ad44f136-31383597%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '989da9e4a05b982e571b9924e758faf03b90bf0b' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_keyword.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1583462c7e8ad44f136-31383597',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'keywordarr' => 0,
    'k' => 0,
    'v' => 0,
    'rows' => 0,
    'total' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e8ad58aac8_67282353',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e8ad58aac8_67282353')) {function content_62c7e8ad58aac8_67282353($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
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
 src="js/show_pub.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
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
		<?php echo '<script'; ?>
>
			function keywords(key_name,type,color,size,bold,tuijian,num,id){
			$("#id").val(id);
			$("#key_name").val(key_name);
			$("#onesize").val(size);
			var val=$(".hiddentype"+type).val();
			
			if(color!=""){
				$("#onecolor").val(color);
				$(".layui-colorpicker-trigger-span").attr("style","background-color:"+color);
				$("#onecolor").attr("style","background-color:"+color);
			}else{
				$("#onecolor").attr("style","");
				$("layui-colorpicker-trigger-span").attr("style","");
				$("#onecolor").attr("style","");
			}
			$("#num").val(num);
			
			$("#addclass2_val").val(type);  
			if(bold == 0){
				$("#bold_switch").attr("checked", false);
			}else if(bold == 1){
				$("#bold_switch").attr("checked", true);
			}
			$("#bold_value").val(bold);
			if(tuijian == 0){
				$("#tuijian_switch").attr("checked", false);
			}else if(tuijian == 1){
				$("#tuijian_switch").attr("checked", true);
			}
			$("#tuijian_value").val(tuijian);
			layui.use(['form'],function(){
				var form = layui.form;
				form.render();
			});

			add_class('关键字管理','480','460','#status_div','');
		}
		function audall(name){
			var chk_value =[];
			$('input[name="'+name+'"]:checked').each(function(){
				chk_value.push($(this).val());
			});
			if(chk_value.length==0){
				parent.layer.msg("请先选择关键字数据！",2,8);return false;
			}else{
				var color = "000000";
				$("#color").val(color);
				$("#color").attr("style","background-color:#"+color);
				$("input[name=pid]").val(chk_value);
				$.layer({
					type : 1,
					title :'关键字管理', 
					closeBtn : [0 , true],
					border : [10 , 0.3 , '#000', true],
					offset: ['20px', ''],
					area : ['400px','320px'],
					page : {dom :"#infobox2"}
				});
			}
		}
		function stausall() {
			var codewebarr = "";
			$(".check_all:checked").each(function() {
				if (codewebarr == "") {
					codewebarr = $(this).val();
				} else {
					codewebarr = codewebarr + "," + $(this).val();
				}
			});
			if (codewebarr == "") {
				parent.layer.msg("您还未选择任何信息！", 2, 8);
				return false;
			} else {
				$("input[name=sid]").val(codewebarr);
				$("input[name=status]").attr("checked", false);
				add_class('批量审核', '300', '170', '#infobox', '');
			}
		}
	<?php echo '</script'; ?>
>

		<link href="images/reset.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<link href="images/system.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<link href="images/table_form.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />

		<title>后台管理</title>

	</head>

	<body class="body_ifm">
		<div id="infobox" style="display:none; width: 390px; ">
			<form action="index.php?m=admin_keyword&c=state" target="supportiframe" method="post" class="layui-form" onsubmit="return htStatus()">
				<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
				<table cellspacing='1' cellpadding='1' class="admin_examine_table">
					<tr>
						<th width="80">审核操作：</th>
						<td align="left">
							<div class="layui-input-block">
								<input name="status" id="status0" value="0" title="未审核" type="radio" />
								<input name="status" id="status1" value="1" title="正常" type="radio" />
							</div>
						</td>
					</tr>
					<tr>
						<td colspan='2' align="center">
							<div class="admin_Operating_sub">
								<input name="sid" value="0" type="hidden">
								<input type="submit" value='确认' class="admin_examine_bth">
								<input type="button" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'>
							</div>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<div id="infobox2" style="display:none; width: 400px; ">
			<form action="index.php?m=admin_keyword&c=status" target="supportiframe" method="post" id="formstatus">
				<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
				<table cellspacing='2' cellpadding='3'>
					<tr class="keywords_sum">
						<th class="key_wid" style="padding:10px">关键字类型：</th>
						<td>
							<div class="yun_admin_select_box">
								<input type="button" value="请选择" class="yun_admin_select_box_text" id="addclass_name" onClick="select_click('addclass');">
								<input name="type" type="hidden" id="addclass_val" value="">
								<div class="yun_admin_select_box_list_box dn" id="addclass_select">
									<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['keywordarr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
									<div class="yun_admin_select_box_list">
										<a href="javascript:;" onClick="select_new('addclass','<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
')"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</a>
									</div>
									<?php } ?>
								</div>
							</div>
						</td>
					</tr>

					<tr class="keywords_sum">
						<th class="key_wid">字体大小：</th>
						<td>
							<input class="admin_wx_text" type="text" id="size" name="size" value="" />
							<span class="admin_web_tip">例：12px</span>
						</td>
					</tr>

					<tr class="keywords_sum">
						<th class="key_wid">字体颜色：</th>
						<td>
							<input class="admin_wx_text" readonly type="text" id="color" name="color" size="20" value="" style="margin-top:5px;width: 193px;" />
							<div id="test_redally"></div>
						</td>
					</tr>

					<tr class="keywords_sum">
						<th class="key_wid">是否加粗：</th>
						<td>
							<div class="admin_examine_right">
								<label>
									<span class="admin_examine_table_s"><input type="radio" name="bold" value="0" id="bold_0">否</span>
								</label>
								<label>
									<span class="admin_examine_table_s"><input type="radio" name="bold" value="1" id="bold_1">是</span>
								</label>
							</div>
						</td>
					</tr>

					<tr class="keywords_sum">
						<th class="key_wid">是否推荐：</th>
						<td>
							<div class="admin_examine_right">
								<label>
									<span class="admin_examine_table_s"><input type="radio" name="tuijian" value="0" id="tuijian_0">否</span>
								</label>
								<label>
									<span class="admin_examine_table_s"><input type="radio" name="tuijian" value="1" id="tuijian_1">是</span>
								</label>
							</div>
						</td>
					</tr>

					<tr class="keywords_sum">
						<th class="key_wid">是否审核：</th>
						<td>
							<div class="admin_examine_right">
								<label>
									<span class="admin_examine_table_s"><input type="radio" name="status" value="0" id="status0">否</span>
								</label>
								<label>
									<span class="admin_examine_table_s"><input type="radio" name="status" value="1" id="status1">是</span>
								</label>
							</div>
						</td>
					</tr>

					<tr>
						<td colspan='2' align="center">
							<div class="admin_Operating_sub">
								<input type="submit" value='确认' class="admin_examine_bth">
								<input type="button" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'>
							</div>
						</td>
					</tr>
				</table>
				<input name="pid" value="0" type="hidden">
			</form>
		</div>

		<div id="status_div" style="display:none;">
			<div style="width:100%;margin-top: 10px;">
				<form action="index.php?m=admin_keyword&c=save" target="supportiframe" method="post" id="formstatus" class="layui-form">
					<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					<table cellspacing='2' cellpadding='3' class="key_table" style="width: 100%;">
						<tr class="keywords_sum">
							<th class="key_wid" align="right">
								<div class="key_wid" style="width:120px;">关键字名称：</div>
							</th>
							<td>
								<input id="key_name" class="key_input_text" type="text" value="" name="key_name" />
								<span class="admin_web_tip">例：phpyun</span>
							</td>
						</tr>

						<tr class="keywords_sum">
							<th class="key_wid" align="right">关键字类型：</th>
							<td>
								<div class="layui-input-inline" style="width: 200px;">
									<select name="type" lay-filter="type" id="addclass2_val">
										<option value="">请选择</option>
										<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['keywordarr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
										<?php } ?>
									</select>
								</div>
							</td>
						</tr>

						<tr class="keywords_sum">
							<th class="key_wid" align="right">字体大小：</th>
							<td>
								<input class="key_input_text" type="text" id="onesize" name="size" size="20" value="" />
								<span class="admin_web_tip">例：12px</span>
							</td>
						</tr>

						<tr class="keywords_sum">

							<th class="key_wid" align="right">字体颜色：</th>
							<td>
								<input class="input-text" readonly type="text" id="onecolor" name="color" size="20" value="" style="width: 193px;"/>
								<div id="test-all"></div>
							</td>
						</tr>

						<tr class="keywords_sum">
							<th class="key_wid" align="right">是否加粗：</th>
							<td>
								<div class="layui-input-block">
									<input name="bold_switch" id="bold_switch" lay-filter="bold_switch" lay-skin="switch" lay-text="开启|关闭" type="checkbox" />
									<input type="hidden" name="bold" id="bold_value" value="" />
								</div>
							</td>
						</tr>

						<tr class="keywords_sum">
							<th class="key_wid" align="right">是否推荐：</th>
							<td>
								<div class="layui-input-block">
									<input name="tuijian_switch" id="tuijian_switch" lay-filter="tuijian_switch" lay-skin="switch" lay-text="开启|关闭"
									 type="checkbox" />
									<input type="hidden" name="tuijian" id="tuijian_value" value="" />
								</div>
							</td>
						</tr>

						<tr class="keywords_sum">
							<th class="key_wid" align="right">搜索次数：</th>
							<td>
								<input class="key_input_text" type="text" id="num" name="num" size="10" value="" />
								<span class="admin_web_tip">例：大前小后</span>
							</td>
						</tr>

						<tr style="text-align:center;margin-top:10px">
							<td colspan='2'>
								<input type="submit" value='确认' class="admin_examine_bth">&nbsp;&nbsp;
								<input type="button" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'>
							</td>
						</tr>
					</table>
					<input type="hidden" name="id" id="id" value="" />
				</form>
			</div>
		</div>

		<div class="infoboxp">
			<div class="tty-tishi_top">


				<div class="admin_new_search_box">
					<form action="index.php" name="myform" method="get">
						<input name="m" value="admin_keyword" type="hidden" />
						<input type="hidden" name="check" value="<?php echo $_GET['check'];?>
" />
						<div class="admin_new_search_name">搜索类型：</div>
						<div class="admin_Filter_text formselect" did='dtype'>
							<input type="button" value="<?php if ($_GET['type']) {
echo $_smarty_tpl->tpl_vars['keywordarr']->value[$_GET['type']];
} else { ?>请选择<?php }?>"
							 class="admin_Filter_but" id="btype">
							<input type="hidden" id='type' value="<?php echo $_GET['type'];?>
" name='type'>
							<div class="admin_Filter_text_box" style="display:none" id='dtype'>
								<ul>
									<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['keywordarr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
									<li><a href="javascript:void(0)" onClick="formselect('<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
','type','<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
')"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</a></li>
									<?php } ?>
								</ul>
							</div>
						</div>
						<input class="admin_Filter_search" type="text" name="keyword" size="25" style="float:left" placeholder="请输入你要搜索的关键字">
						<input class="admin_Filter_bth" type="submit" name="news_search" style="cursor:pointer;" value="搜索" />

						<a href="javascript:void(0)" onclick="$('.admin_screenlist_box').toggle();" class="admin_new_search_gj">高级搜索</a>
						<a href="javascript:void(0)" onClick="keywords('','','','','','','','')" class="admin_new_cz_tj">+ 添加关键字</a>

					</form>
					<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

				</div>

				<div class="clear"></div>
			</div>

			<div class="tty_table-bom">
				<div class="table-list">
					<div class="admin_table_border">
						<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
						<form action="index.php?m=admin_keyword&c=del" name="myform" method="post" target="supportiframe" id='myform'
						 class="layui-form">
							<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
							<table width="100%">
								<thead>
									<tr class="admin_table_top">
										<th width="50">
											<input type="checkbox" lay-skin="primary" lay-filter="alladmin" id="chkAll" />
										</th>
										<th align="left">
											<?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?>
											<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'id','m'=>'admin_keyword','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img src="images/sanj.jpg" /></a>
											<?php } else { ?>
											<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'id','m'=>'admin_keyword','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img src="images/sanj2.jpg" /></a>
											<?php }?>
										</th>
										<th align="left" width="20%">热门关键字</th>
										<th align="left">关键字类型</th>
										<th align="left">
											<?php if ($_GET['t']=="num"&&$_GET['order']=="asc") {?>
											<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'num','m'=>'admin_keyword','untype'=>'order,t'),$_smarty_tpl);?>
">搜索次数<img src="images/sanj.jpg" /></a>
											<?php } else { ?>
											<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'num','m'=>'admin_keyword','untype'=>'order,t'),$_smarty_tpl);?>
">搜索次数<img src="images/sanj2.jpg" /></a>
											<?php }?>
										</th>
										<th align="left">加粗</th>
										<th align="left">推荐</th>
										<th align="left">审核</th>
										<th align="left" class="admin_table_th_bg" width="140" style="text-align:center">操作</th>
									</tr>
								</thead>
								<tbody>
									<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
									<?php $_smarty_tpl->tpl_vars["type"] = new Smarty_variable($_smarty_tpl->tpl_vars['v']->value['type'], null, 0);?>
									<tr id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
										<td align="center">
											<input type="checkbox" class="check_all" lay-skin="primary" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" lay-filter="checklist"
											 name='del[]' rel="del_chk" />
										</td>
										<td><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
										<td align="left" class="td1">
											<font color="<?php echo $_smarty_tpl->tpl_vars['v']->value['color'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['key_name'];?>
</font>
										</td>
										<td align="left"><?php echo $_smarty_tpl->tpl_vars['keywordarr']->value[$_smarty_tpl->tpl_vars['v']->value['type']];?>
</td>
										<td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['num'];?>
</td>
										<td id="bold<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
											<input name="bold" lay-skin="switch" lay-text="是|否" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['v']->value['bold']=="1") {?> checked
											 <?php }?> lay-filter="bold" data-id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" />
										</td>
										<td id="tuijian<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
											<input name="tuijian" lay-skin="switch" lay-text="是|否" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['v']->value['tuijian']=="1") {?>
											 checked <?php }?> lay-filter="tuijian" data-id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" />
										</td>
										<td id="check<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
											<input name="check" lay-skin="switch" lay-text="是|否" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['v']->value['check']=="1") {?> checked
											 <?php }?> lay-filter="check" data-id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" />
										</td>
										<td>
											<span style="cursor:pointer;" onClick="keywords('<?php echo $_smarty_tpl->tpl_vars['v']->value['key_name'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['type'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['color'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['size'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['bold'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['tuijian'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['num'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')"
											 class="admin_new_c_bth">修改</span>
											<a href="javascript:void(0)" class="admin_new_c_bth admin_new_c_bth_sc" onClick="layer_del('确定要删除？', 'index.php?m=admin_keyword&c=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');">删除</a>
										</td>
									</tr>
									<?php } ?>
									<tr>
										<td align="center">
											<input type="checkbox" lay-skin="primary" lay-filter="alladmin" id="chkAll2" class="chkall" />
										</td>
										<td colspan="8">
											<label for="chkall">全选</label> &nbsp;
											<input class="admin_button" type="button" name="delsub" value="删除所选" onclick="return really('del[]')" />
											<input class="admin_button" type="button" name="delsub" value="批量审核" onClick="stausall();" />
											<input class="admin_button" type="button" name="delsub" value="加粗" onClick="audall('del[]');" />
											<input class="admin_button" type="button" name="delsub" value="推荐" onClick="audall('del[]');" />
											<input class="admin_button" type="button" name="delsub" value="修改类型" onClick="audall('del[]');" />
										</td>
									</tr>
									<?php if ($_smarty_tpl->tpl_vars['total']->value>$_smarty_tpl->tpl_vars['config']->value['sy_listnum']) {?>
									<tr>
										<?php if ($_smarty_tpl->tpl_vars['pagenum']->value==1) {?>
										<td colspan="3"> 从 1 到 <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
										<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value>1&&$_smarty_tpl->tpl_vars['pagenum']->value<$_smarty_tpl->tpl_vars['pages']->value) {?> <td colspan="3"> 从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['pagenum']->value*$_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
											<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value==$_smarty_tpl->tpl_vars['pages']->value) {?>
											<td colspan="3"> 从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 ，总共
												<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
											<?php }?>
											<td colspan="6" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
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

		<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['keywordarr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
		<input class="hiddentype<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" type="hidden" name="delsub" value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" />
		<?php } ?>
		<style>

			.colorpicker {
			z-index: 9999;
		}
	</style>

		<?php echo '<script'; ?>
 type="text/javascript">
			//test_redally
			layui.use(['form', 'colorpicker'], function() {
				var colorpicker = layui.colorpicker,
					form = layui.form,
					$ = layui.$;
				colorpicker.render({
					elem: '#test_redally',
					size: 'xs',
					change: function(data) {
						$('#color').attr('style', "background-color:" + data);
						$('#color').val(data);
					}

				});
				colorpicker.render({
					elem: '#test-all',
					size: 'xs',
					change: function(data) {
						$('#onecolor').attr('style', "background-color:" + data);
						$('#onecolor').val(data);
					}

				});

				form.on('checkbox(alladmin)', function(data) {
					$("input[name='del[]']").each(function() {
						this.checked = data.elem.checked;
					});
					if (data.elem.checked == true) {
						$("#chkAll").prop("checked", true);
						$("#chkAll2").prop("checked", true);
					} else {
						$("#chkAll").prop("checked", false);
						$("#chkAll2").prop("checked", false);
					}
					form.render('checkbox');
				});

				form.on('checkbox(checklist)', function(data) { //触发其中一个数据按钮   全选按钮自动取消选中
					var item = $(".check_all");
					for (var i = 0; i < item.length; i++) {
						if (item[i].checked == false) {
							$("#chkAll").prop("checked", false);
							$("#chkAll2").prop("checked", false);
							form.render('checkbox');
							break;
						}
					}
					var all = item.length; //选择本页面   全选自动选中
					for (var i = 0; i < item.length; i++) {
						if (item[i].checked == true) {
							all--;
						}
					}
					if (all == 0) {
						$("#chkAll").prop("checked", true);
						$("#chkAll2").prop("checked", true);
						form.render('checkbox');
					}
				});
				form.on('switch(bold_switch)', function(data) {
					var v = this.checked ? 1 : 0;
					$("#bold_value").val(v);
				});

				form.on('switch(tuijian_switch)', function(data) {
					var v = this.checked ? 1 : 0;
					$("#tuijian_value").val(v);
				});

				form.on('switch(bold)', function(data) {
					var url = 'index.php?m=admin_keyword&c=recup',
						id = data.elem.getAttribute('data-id'),
						pytoken = $("#pytoken").val(),
						rec = this.checked ? 1 : 0,
						type = 'bold';
					$.get(url + "&id=" + id + "&rec=" + rec + "&type=" + type + "&pytoken=" + pytoken, function(data) {
						if (data != 1) {
							parent.layer.msg('设置加粗失败！', 2, 8);
						}
					});
				});

				form.on('switch(tuijian)', function(data) {
					var url = 'index.php?m=admin_keyword&c=recup',
						id = data.elem.getAttribute('data-id'),
						pytoken = $("#pytoken").val(),
						rec = this.checked ? 1 : 0,
						type = 'tuijian';
					$.get(url + "&id=" + id + "&rec=" + rec + "&type=" + type + "&pytoken=" + pytoken, function(data) {
						if (data != 1) {
							parent.layer.msg('设置推荐失败！', 2, 8);
						}
					});
				});

				form.on('switch(check)', function(data) {
					var url = 'index.php?m=admin_keyword&c=recup',
						id = data.elem.getAttribute('data-id'),
						pytoken = $("#pytoken").val(),
						rec = this.checked ? 1 : 0,
						type = 'check';
					$.get(url + "&id=" + id + "&rec=" + rec + "&type=" + type + "&pytoken=" + pytoken, function(data) {
						if (data != 1) {
							parent.layer.msg('审核失败！', 2, 8);
						}
					});
				});


			});
		<?php echo '</script'; ?>
>

	</body>
</html>
<?php }} ?>
