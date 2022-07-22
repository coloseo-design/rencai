<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:14:48
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_evaluate_examup.htm" */ ?>
<?php /*%%SmartyHeaderCode:1644962c7e778ec4fb8-67269032%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aae121b8139f4eaa8c724eb754081f1675858dc9' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_evaluate_examup.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1644962c7e778ec4fb8-67269032',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'type' => 0,
    'info' => 0,
    'group_all' => 0,
    'v' => 0,
    'key' => 0,
    'pytoken' => 0,
    'ask' => 0,
    'fullscore' => 0,
    'value' => 0,
    'k' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e7790a76d1_27475052',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e7790a76d1_27475052')) {function content_62c7e7790a76d1_27475052($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
" language="javascript" type="text/javascript"><?php echo '</script'; ?>
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
> var weburl = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
'; <?php echo '</script'; ?>
>
	<title>后台管理</title>
</head>

<body class="body_ifm">

	<div class="infoboxp">
	

		<div class="tty-tishi_top">
			 

			<div class="tabs_info" style="height: 35px;">
				<ul>
					<li <?php if (!$_smarty_tpl->tpl_vars['type']->value) {?>class="curr"<?php }?>>试卷信息</li>
					<?php if ($_GET['id']) {?><li <?php if ($_smarty_tpl->tpl_vars['type']->value) {?>class="curr"<?php }?>>题目管理</li><?php }?>
				</ul>
			</div>	
		</div>
		
		<div class="tty_table-bom">
			<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>

			<form id="cpform" name="myform" target="supportiframe" action="index.php?m=admin_evaluate&c=examupsave" method="post"
			 encType="multipart/form-data" class="layui-form" <?php if ($_smarty_tpl->tpl_vars['type']->value) {?>style="display: none;"<?php }?>>
			
				<table class="table_form" width="100%">

					<tr>
						<th colspan="2" class="admin_bold_box">
							<div class="admin_bold"><?php if ($_GET['id']) {?>修改<?php } else { ?>添加<?php }?>测评试卷</div>
							
						</th>
					</tr>  

					<tr>
						<th width="120">试卷名称：</th>
						<td>
							<div class="layui-input-input t_w480">
								<input type="text" name="examtitle" id="examtitle" lay-verify="required" placeholder="请输入试卷名称" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
" autocomplete="off" class="layui-input" style="display:inline;">
							</div>
						</td>
					</tr>
					
					<tr>
						<th width="120">试卷类别选择：</th>
						<td>
							<div class="layui-input-inline t_w480">
								<select name="selectgroup" id="selectgroup">
									<option value="">请选择</option>
									<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group_all']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
										<?php if ($_smarty_tpl->tpl_vars['v']->value['id']==$_smarty_tpl->tpl_vars['info']->value['keyid']) {?>
											<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" selected><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
										<?php } else { ?>
											<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
										<?php }?>
									<?php } ?>

								</select>
							</div>
							<?php if (!$_smarty_tpl->tpl_vars['group_all']->value) {?><span style="font-size:14px; color:red; display:inline-block; line-height:34px;">请先添加测评类别</span><?php }?>
						</td>
					</tr>

					<tr>
						<th width="120" class="t_fl">缩略图：</th>
						<td >
							
							<button type="button" class="yun_bth_pic noupload"  lay-data="{imgid: 'imgicon',parentid: 'imgparent'}">上传缩略图</button>

								<input type="hidden" id="laynoupload" value="1" />
								<div class="clear"></div>
								<div class="" style=" margin-top:10px;">
									<img id="imgicon" src="<?php if ($_smarty_tpl->tpl_vars['info']->value['pic_n']) {
echo $_smarty_tpl->tpl_vars['info']->value['pic_n'];
} else {
echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_cplogo'];
}?>" width='150' height='100' />
								</div>
					
							 
						</td>
					</tr>

					<tr>
						<th width="120">试卷排序：</th>
						<td>
							<div class="layui-input-block t_w480">
								<input type="text" name="sort" id="sort" lay-verify="required" placeholder="请输入试卷排序" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['sort'];?>
" size="5" autocomplete="off" class="layui-input">
							</div>
						</td>
					</tr>

					<tr>
						<th width="120">试卷属性：</th>
						<td>
							<div class="layui-input-inline">
								<input type="checkbox" name="top" lay-skin="primary" title="首页幻灯" value="1" <?php if ($_smarty_tpl->tpl_vars['info']->value['top']=='1') {?>checked="checked"<?php }?>>
								<input type="checkbox" name="hot" lay-skin="primary" title="头条" value="1" <?php if ($_smarty_tpl->tpl_vars['info']->value['hot']=='1') {?>checked="checked"<?php }?>>
								<input type="checkbox" name="recommend" lay-skin="primary" title="推荐" value="1" <?php if ($_smarty_tpl->tpl_vars['info']->value['recommend']=='1') {?>checked="checked"<?php }?>>
							</div>
						</td>
					</tr>

					<tr>
						<th width="120" class="t_fl">描　　述：</th>
						<td>
							<div class="layui-input-block t_w480">
								<textarea name="description" id='description' cols="100" rows="3" placeholder="请输入描述" lay-verify="required" class="layui-textarea" autocomplete="off"><?php echo $_smarty_tpl->tpl_vars['info']->value['description'];?>
</textarea>
							</div>
						</td>
					</tr>

					<tr>
						<th width="120" class="t_fl">评语管理：</th>
						<td>
							<div class='' style="">
								
								<?php if ($_smarty_tpl->tpl_vars['info']->value['id']) {?>
								<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['info']->value['fromscore']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
								<div class="ty_cpsj_pygl" style="padding: 20px;">
									<div class="layui-form-item layui-form-text">
										<label class="ty_cpsj_pygl_label">成绩</label>
										<div class="layui-input-block t_w400">
											<div class="admin_comclass_addjg_box lf" style="width: 140px;">
												<input type="text" class="layui-input" name="fromscore[]"  size="4" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['fromscore'][$_smarty_tpl->tpl_vars['key']->value];?>
" placeholder="请输入成绩" />
												<span class="admin_comclass_add_dw">分</span> 
											</div>
											<span style="float: left;padding: 10px 20px;">到</span>
											<div class="admin_comclass_addjg_box lf" style="width: 140px;">
												<input type="text" name="toscore[]" class="layui-input" size="4" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['toscore'][$_smarty_tpl->tpl_vars['key']->value];?>
" placeholder="请输入成绩" />
												<span class="admin_comclass_add_dw">分</span> 
											</div>
										</div>
									</div>
									<div class="layui-form-item layui-form-text" style="margin-top: 10px;">
										<label class="ty_cpsj_pygl_label">评语</label>
										<div class="layui-input-inline" style="width: 370px;">
										  <textarea placeholder="请输入评语" class="layui-textarea" name="comment[]"><?php echo $_smarty_tpl->tpl_vars['info']->value['comment'][$_smarty_tpl->tpl_vars['key']->value];?>
</textarea>
										</div>
									</div>
									<a class="ty_cpsj_pygl_sc" href="javascript:;" onclick="removeComment(this);">删除</a> 
								</div>
								<?php } ?>
								<?php } else { ?>
								<div class="ty_cpsj_pygl" style="padding: 20px;">
									<div class="layui-form-item layui-form-text">
										<label class="ty_cpsj_pygl_label">成绩</label>
										<div class="layui-input-block t_w400">
											<div class="admin_comclass_addjg_box lf" style="width: 140px;">
												<input type="text" class="layui-input" name="fromscore[]"  size="4" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['fromscore'][$_smarty_tpl->tpl_vars['key']->value];?>
" placeholder="请输入成绩" />
												<span class="admin_comclass_add_dw">分</span> 
											</div>
											<span style="float: left;padding: 10px 20px;">到</span>
											<div class="admin_comclass_addjg_box lf" style="width: 140px;">
												<input type="text" name="toscore[]" class="layui-input" size="4" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['toscore'][$_smarty_tpl->tpl_vars['key']->value];?>
" placeholder="请输入成绩" />
												<span class="admin_comclass_add_dw">分</span> 
											</div>
										</div>
									</div>
									<div class="layui-form-item layui-form-text" style="margin-top: 10px;">
										<label class="ty_cpsj_pygl_label">评语</label>
										<div class="layui-input-inline" style="width: 370px;">
										  <textarea placeholder="请输入评语" class="layui-textarea" name="comment[]"><?php echo $_smarty_tpl->tpl_vars['info']->value['comment'][$_smarty_tpl->tpl_vars['key']->value];?>
</textarea>
										</div>
									</div>
									<a class="ty_cpsj_pygl_sc" href="javascript:;" onclick="removeComment(this);">删除</a> 
								</div>
								<?php }?>

								<a class="admin_infoboxp_nav admin_infoboxp_tj" href="javascript:;" onclick="addNewComment();" id="newCommentBtn">添加评语管理</a>
							</div>
						</td>
					</tr>
					
					
					<tr class="admin_table_trbg">
						<th style="border-bottom:none;">&nbsp;</th>
						<td align="left" style="border-bottom:none;">
							
							<input class="layui-btn tty_sub" type="button" onclick="addCpInfo();" value="<?php if ($_smarty_tpl->tpl_vars['info']->value['id']) {?>修改<?php } else { ?>保存<?php }?>" /> 

							<input class="layui-btn tty_cz" type="reset" name="reset" value="&nbsp;重 置 &nbsp;" />
						</td>
					</tr>
				</table>
				<input type="hidden" name="examid" size="40" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
" />
				<input type="hidden" name="lasturl" value="" />
				<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
" />
			</form>

			<form id="cpform2" class="layui-form"  <?php if (!$_smarty_tpl->tpl_vars['type']->value) {?>style="display: none;"<?php }?>>
			
				<table class="table_form" width="100%">
					
					<tr>
						<th colspan="3" class="admin_bold_box">
							<div class="admin_bold">试题管理</div>
						</th>
					</tr>
				</table>
				<div class="lookQu">
					<div class="admin_statistics"  id="divExamInfo">
						<span class="tty_sjtj_color">题目统计：</span>
						<em class="admin_statistics_s">总数：<span class="ajaxall"><?php echo count($_smarty_tpl->tpl_vars['ask']->value);?>
道</span></em>
						<em class="admin_statistics_s">总分：<span class="StatusNum3"><?php echo $_smarty_tpl->tpl_vars['fullscore']->value;?>
分</span></em>
					
					</div>
				<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ask']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
				
				
						<div id="lookQuestion[<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
]" name="lookQuestion[<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
]" class="wt_list">
						问题 <?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>

						<?php echo $_smarty_tpl->tpl_vars['value']->value['question'];?>

						<div class="tm_right">
						<input class="tm_xg" type="button" value="修改" onClick="editquestion(<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
)"/>

						<input class="tm_xg_sc" type="button" value="删除" onclick="layer_del('确定要删除？', 'index.php?m=admin_evaluate&c=delquestion&qid=<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
');"/>
						</div>
						</div>
				

				<table class="table_form editQu" width="100%" id="tQuestion[<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
]" name="tQuestion[<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
]" style="display: none;">	 
					<tr>
						<td>
							<div class="ty_cpsj_pygl questionDiv" >
								
								<div class="layui-form-item layui-form-text">
									<label class="ty_cpsj_pygl_label">问题<?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
</label>
									<div class="layui-input-inline" style="width: 370px;">
										<textarea placeholder="请输入问题" id="textarea<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" name="question[<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
]" class="layui-textarea"><?php echo $_smarty_tpl->tpl_vars['value']->value['question'];?>
</textarea>
									</div>
								</div>
								
								<div class="layui-form-item layui-form-text">
									<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['value']->value['option']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
									<div class="layui-input-block t_w400" style="margin-top: 10px;">
										<div class="admin_comclass_addjg_box lf" style="width: 170px;">
											<label class="ty_cpsj_pygl_label">选项</label>
											<div class="layui-input-inline t_w100">
												<input type="text" class="layui-input" name="option[<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
][]" value="<?php echo $_smarty_tpl->tpl_vars['ask']->value[$_smarty_tpl->tpl_vars['key']->value]['option'][$_smarty_tpl->tpl_vars['k']->value];?>
" size="50" placeholder="请输入选项">
											</div>
										</div>
										<div class="admin_comclass_addjg_box lf" style="width: 170px;">
											<label class="ty_cpsj_pygl_label">分值</label>
											<div class="layui-input-inline t_w100">
												<input type="text" class="layui-input" name="score[<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
][]" size="3" value="<?php echo $_smarty_tpl->tpl_vars['ask']->value[$_smarty_tpl->tpl_vars['key']->value]['score'][$_smarty_tpl->tpl_vars['k']->value];?>
" placeholder="请输入分值">
											</div>
										</div>
										<div class="admin_comclass_addjg_a lf" >
											<a href="javascript:;"onclick="delOption(this,'<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
')">删除</a>
										</div>
									</div>
									<?php } ?>
									<a href="javascript:;" onclick="createOption('<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
')" class="ty_cpsj_adddxx" id="actionTr<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
">添加选项</a>
								</div>
							</div>
						</td>
					</tr>  
					 <tr class="admin_table_trbg">
						<td align="left" style="border-bottom:none;">
							<input class="layui-btn tty_sub" type="button" onclick="saveQuestion(<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
);" value="&nbsp;更 新&nbsp;" />
							<input class="layui-btn tty_cz" type="button" onclick="abandonSave(<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
)" value="&nbsp;放 弃&nbsp;" />
						</td>
					</tr> 
				</table>
				<?php } ?>
				</div>
	<a class="  questionAddbtn" href="javascript:;"><div class="tjrtm_bth">+ 添加测评题目</div></a>
				<div id="divSeparat"></div>
				
				<input type="hidden" name="examid" size="40" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
" />
				<input type="hidden" name="lasturl" value="" />
				<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
" />
			</form>
		</div>
	</div>
	


	<style>
		.layui-form-item {
			margin-bottom: 0px;
			clear: both;
		}
		.examinfo {position: fixed; _position:absolute; text-align: center; bottom: 15px; cursor: pointer; right: 40px; border: 1px solid #1178c3;background-color: white; width:84px;}
		.examinfoD{width:100%;height:28px; line-height:28px; background: #1178c3;color:#fff; font-weight:bold;font-size: 12px; }
	</style>
	
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui.upload.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type='text/javascript'><?php echo '</script'; ?>
>
	
	<?php echo '<script'; ?>
>
		layui.use(['layer', 'form', 'element'], function() {
			var layer = layui.layer,
				form = layui.form,
				element = layui.element,
				$ = layui.$;

		});

		/*设置分值为三位数纯数字*/
		function setNumber(obj){obj.value=obj.value.replace(/([\D]+)|^([0].+)|([\d]{4,})/igm,"");};
 	<?php echo '</script'; ?>
>
	
	<?php echo '<script'; ?>
>
		/*限制 分值 为数字*/
		$("input[name='fromscore[]']").live("keyup",function(){
			setNumber(this);
		});
		$("input[name='toscore[]']").live("keyup",function(){
			setNumber(this);	
		});
		$("input[name='sort']").live("keyup",function(){ 
			this.value = this.value.replace(/([\D]+)|^([0].+)/igm,"");
		});
		 
		/*添加新评语*/
		function addNewComment(){
			var newCStr	=	'<div class="ty_cpsj_pygl" style="padding: 20px;">'
						+		'<div class="layui-form-item layui-form-text">'
						+			'<label class="ty_cpsj_pygl_label">成绩</label>'
						+			'<div class="layui-input-block t_w400">'
						+				'<div class="admin_comclass_addjg_box lf" style="width: 140px;">'
						+					'<input type="text" class="layui-input" name="fromscore[]"  size="4" value="" placeholder="请输入成绩" />'
						+					'<span class="admin_comclass_add_dw">分</span> '
						+				'</div>'
						+				'<span style="float: left;padding: 10px 20px;">到</span>'
						+				'<div class="admin_comclass_addjg_box lf" style="width: 140px;">'
						+					'<input type="text" name="toscore[]" class="layui-input" size="4" value="" placeholder="请输入成绩" />'
						+					'<span class="admin_comclass_add_dw">分</span>' 
						+				'</div>'
						+			'</div>'
						+		'</div>'
						+		'<div class="layui-form-item layui-form-text" style="margin-top: 10px;">'
						+			'<label class="ty_cpsj_pygl_label">评语</label>'
						+			'<div class="layui-input-inline" style="width: 370px;">'
						+				'<textarea placeholder="请输入评语" class="layui-textarea" name="comment[]"></textarea>'
						+			'</div>'
						+		'</div>'
						+		'<a class="ty_cpsj_pygl_sc" href="javascript:;" onclick="removeComment(this);">删除</a>'
						+	'</div>';

			$("#newCommentBtn").before(newCStr);
		}
		/*移除评语*/
		function removeComment(Obj){
			var commentSet=$("input[name='fromscore[]']");
			if(commentSet.length<2){
				parent.layer.msg('再删就没有啦！', 2, 8);return false;
			}else{
				Obj.parentNode.parentNode.removeChild(Obj.parentNode);
			}
		}
		/*测评基本内容*/
		function addCpInfo(){
			
			var examtitle	=	$.trim($("#examtitle").val());
			var selectgroup	=	$.trim($("#selectgroup").val());
			var description	=	$.trim($("#description").val());
			parent.layer.closeAll();
			if(examtitle==''){
				layer.msg('请填写测评名称！',2,8);return false;
			}
			if(selectgroup==''){
				layer.msg('请选择测评分组！',2,8);return false;
			}
			
			var mtype='';
			$("input[name='fromscore[]']").each(function(){  
				if($(this).val()==''){
					mtype=1;
				}
			});
			$("input[name='toscore[]']").each(function(){  
				if($(this).val()==''){
					mtype=1; 
				}
			});
			$("textarea[name='comment[]']").each(function(){  
				if($(this).val()==''){
					mtype=1; 
				}
			});
			if(mtype!=''){
				layer.msg('请完善评语管理！',2,8);return false;
			}
			$('#cpform').submit();
		}
	<?php echo '</script'; ?>
>
	
	<?php echo '<script'; ?>
>
		
		$(document).ready(function(){
			
			/* 添加问题 */
			$('.questionAddbtn').click(function(){
				
				if($("#divSeparat").prev().attr("name")){
					var tableNameId = Number(($("#divSeparat").prev().attr("name")).match(/\d+/g))+1; 
				}else{
					var tableNameId=1;
				}
				var quesId = Number($("table[name^='tQuestion']").length)+1;
				var tpl=
					'<table class="table_form" width="100%"  name="tQuestion['+tableNameId+']">'
					+	'<tr>'
					+		'<td>'
					+			'<div class="ty_cpsj_pygl questionDiv" >'
					+				'<div class="layui-form-item layui-form-text">'
					+					'<label class="ty_cpsj_pygl_label">问题'+quesId+'</label>'
					+					'<div class="layui-input-inline" style="width: 370px;">'
					+						'<textarea placeholder="请输入问题" name="question['+tableNameId+']" class="layui-textarea"></textarea>'
					+					'</div>'
					+				'</div>'
								
					+				'<div class="layui-form-item layui-form-text">'
					+					'<div class="layui-input-block t_w400" style="margin-top: 10px;">'
					+						'<div class="admin_comclass_addjg_box lf" style="width: 170px;">'
					+							'<label class="ty_cpsj_pygl_label">选项</label>'
					+							'<div class="layui-input-inline t_w100">'
					+								'<input type="text" class="layui-input" name="option['+tableNameId+'][]" size="50" placeholder="请输入选项">'
					+							'</div>'
					+						'</div>'
					+						'<div class="admin_comclass_addjg_box lf" style="width: 170px;">'
					+							'<label class="ty_cpsj_pygl_label">分值</label>'
					+							'<div class="layui-input-inline t_w100">'
					+								'<input type="text" class="layui-input" name="score['+tableNameId+'][]" size="3" placeholder="请输入分值">'
					+							'</div>'
					+						'</div>'
					+						'<div class="admin_comclass_addjg_a lf" >'
					+							'<a href="javascript:;"onclick="delOption(this,'+tableNameId+');">删除</a>'
					+						'</div>'
					+					'</div>'

					+					'<div class="layui-input-block t_w400" style="margin-top: 10px;">'
					+						'<div class="admin_comclass_addjg_box lf" style="width: 170px;">'
					+							'<label class="ty_cpsj_pygl_label">选项</label>'
					+							'<div class="layui-input-inline t_w100">'
					+								'<input type="text" class="layui-input" name="option['+tableNameId+'][]" size="50" placeholder="请输入选项">'
					+							'</div>'
					+						'</div>'
					+						'<div class="admin_comclass_addjg_box lf" style="width: 170px;">'
					+							'<label class="ty_cpsj_pygl_label">分值</label>'
					+							'<div class="layui-input-inline t_w100">'
					+								'<input type="text" class="layui-input" name="score['+tableNameId+'][]" size="3" placeholder="请输入分值">'
					+							'</div>'
					+						'</div>'
					+						'<div class="admin_comclass_addjg_a lf" >'
					+							'<a href="javascript:;"onclick="delOption(this,'+tableNameId+');">删除</a>'
					+						'</div>'
					+					'</div>'
					+					'<a href="javascript:;" onclick="createOption('+tableNameId+')" class="ty_cpsj_adddxx" id="actionTr'+tableNameId+'">添加选项</a>'
					+				'</div>'
					+			'</div>'
					+		'</td>'
					+	'</tr>' 
					+	'<tr class="admin_table_trbg">'
					+		'<td align="left" style="border-bottom:none;">'
					+			'<input class="layui-btn tty_sub" type="button" onclick="saveNewQuestion('+tableNameId+');" value="&nbsp;保 存&nbsp;" />'
					+			'<input class="layui-btn tty_cz" type="button" onclick="delQuestion('+tableNameId+')" value="&nbsp;删 除&nbsp;" />'
					+		'</td>'
					+	'</tr> '
					+'</table>';
					 
					 $("#divSeparat").before(tpl);		
					 $(".questionAddbtn").hide();

			});

		});
		
		/* 删除问题 */
		function delQuestion(tableNameId){
			$("table[name='tQuestion["+tableNameId+"]']").remove();
			$(".questionAddbtn").show();
		}

		/* 添加选项 */
		function createOption(tableNameId){
			var optionArray = $("input[name='option["+tableNameId+"][]']");
			var optionId = Number(optionArray.length)+1;
			var oTr	= '<div class="layui-input-block t_w400" style="margin-top: 10px;">'
					+	'<div class="admin_comclass_addjg_box lf" style="width: 170px;">'
					+		'<label class="ty_cpsj_pygl_label">选项</label>'
					+		'<div class="layui-input-inline t_w100">'
					+			'<input type="text" class="layui-input" name="option['+tableNameId+'][]" size="50" placeholder="请输入选项">'
					+		'</div>'
					+	'</div>'
					+	'<div class="admin_comclass_addjg_box lf" style="width: 170px;">'
					+		'<label class="ty_cpsj_pygl_label">分值</label>'
					+		'<div class="layui-input-inline t_w100">'
					+			'<input type="text" class="layui-input" name="score['+tableNameId+'][]" size="3" placeholder="请输入分值">'
					+		'</div>'
					+	'</div>'
					+	'<div class="admin_comclass_addjg_a lf" >'
					+		'<a href="javascript:;"onclick="delOption(this,'+tableNameId+');">删除</a>'
					+	'</div>'
					+'</div>';
			$("#actionTr"+tableNameId).before(oTr);
		}

		/* 删除选项 */
		function delOption(Obj, tableNameId){
			var optionArray = $("input[name='option["+tableNameId+"][]']");
			var scoreArray = $("input[name='score["+tableNameId+"][]']");
			if(Number(optionArray.length)==Number(scoreArray.length) && Number(optionArray.length) > 1){
				Obj.parentNode.parentNode.remove();
			}else{
				parent.layer.msg('再删就没有啦！',2,8);return false;
			}
		}

		/*保存新题*/
		function saveNewQuestion(tableNameId){
			var examid		=	$("input[name='examid']").val();
			var question	=	$.trim($("textarea[name='question["+tableNameId+"]']").val());
			var option_arr	=	$("input[name='option["+tableNameId+"][]']");
			var score_arr	=	$("input[name='score["+tableNameId+"][]']");
			var option		=	new Array();
			var score		=	new Array();
			for(var i=0; i<option_arr.length; i++){
				option[i]	=	option_arr[i].value;
				score[i]	=	score_arr[i].value;
			};
			if(question==''||option==''||score==''){
				layer.msg("问题、选项、分值都不能为空！！",2,8);return false;
			}

			var url	=	"index.php?m=admin_evaluate&c=ajaxsave";
			var sendinfo = {examid:examid, question:question, option:option, score:score, status:"new", pytoken:$("#pytoken").val()};
			$.post(url,sendinfo,function(data){
				if(data!=1){
					config_msg(data);
				}else{
					location.href="index.php?m=admin_evaluate&c=examup&id="+examid+"&type=1";
				}
			});
		} 
		
		/* 更新问题 */
		function saveQuestion(id){
			var examid		=	$("input[name='examid']").val();
			var questid		=	id;
			var question	=	$("textarea[name='question["+id+"]']").val();
			var option_arr	=	$("input[name='option["+id+"][]']");
			var option		=	new Array();
			var score_arr	=	$("input[name='score["+id+"][]']");
			var score		=	new Array();

			for(var i=0; i<option_arr.length; i++){
				if(option_arr[i].value){
					option[i] = option_arr[i].value;
				}
				if(score_arr[i].value){
					score[i] = score_arr[i].value;
				} 
			}
			if(question==''||option==''||score==''){
				layer.msg("问题、选项、分值都不能为空！！",2,8);return false;
			} 

			var url="index.php?m=admin_evaluate&c=ajaxsave";
			var sendinfo = {questid:questid, question:question, option:option, score:score, status:"up", pytoken:$("#pytoken").val()};
			$.post(url,sendinfo,function(data){
				if(data!=1){
					config_msg(data);
				}else{
					location.href="index.php?m=admin_evaluate&c=examup&id="+examid+"&type=1";
				}
			});
		}
			
		/*限制 分值 为数字*/
		$("input[name^='score']").live("keyup",function(){
			setNumber(this);
		});

		/*点击问题，编辑修改*/
		function editquestion(id){
			$("table[name='lookQuestion["+id+"]']").hide();
			$(".editQu").hide();
			$(".lookQu").show();
			$("table[name='tQuestion["+id+"]']").show();
		}
		/*放弃修改问题*/
		function abandonSave(id){
			$("table[name='lookQuestion["+id+"]']").show();
			$("table[name='tQuestion["+id+"]']").hide();
		}

		 
	<?php echo '</script'; ?>
>

	<?php echo '<script'; ?>
>
		var ah2 = $(".tabs_info li")
		var ap = $(".tty_table-bom form")
		
		for (var i = 0; i < ah2.length; i++) {
			ah2[i].index = i;
			
			ah2[i].onclick = function () {
				for (var j = 0; j < ap.length; j++) {
					ap[j].style.display = "none"
				}
				ap[this.index].style.display = "block";
			}
		}
		ah2.each(function(){
			
			$(this).click(function(){
				ah2.removeClass("curr")
				$(this).addClass("curr")
			})
		})
	<?php echo '</script'; ?>
>
</body>
</html>
<?php }} ?>
