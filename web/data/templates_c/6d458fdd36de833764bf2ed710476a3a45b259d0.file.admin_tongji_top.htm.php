<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 17:31:06
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_tongji_top.htm" */ ?>
<?php /*%%SmartyHeaderCode:270362d91cdab2fe03-71685657%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6d458fdd36de833764bf2ed710476a3a45b259d0' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_tongji_top.htm',
      1 => 1644196793,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '270362d91cdab2fe03-71685657',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'Dname' => 0,
    'key' => 0,
    'dlist' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d91cdabb6431_98358611',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d91cdabb6431_98358611')) {function content_62d91cdabb6431_98358611($_smarty_tpl) {?><iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
<div class="tty-tishi_top" style="padding: 5px 15px 0px 15px;">	
	<div class="admin_tj_newlist">
		<span class="admin_tj_newname">统计类别：</span>
		<a href="index.php?m=admin_tongji&c=reg&days=7"<?php if ($_GET['c']=='reg') {?> class="admin_tj_cur"<?php }?>>会员注册统计</a>
		<a href="index.php?m=admin_tongji&c=lookjob&days=7"<?php if ($_GET['c']=='lookjob') {?> class="admin_tj_cur"<?php }?>>职位浏览统计</a> 
		<a href="index.php?m=admin_tongji&c=lookresume&days=7"<?php if ($_GET['c']=='lookresume') {?> class="admin_tj_cur"<?php }?>>简历浏览统计</a>
		<a href="index.php?m=admin_tongji&c=useridmsg&days=7"<?php if ($_GET['c']=='useridmsg') {?> class="admin_tj_cur"<?php }?>>邀请面试统计</a>
		<a href="index.php?m=admin_tongji&c=downresume&days=7" <?php if ($_GET['c']=='downresume') {?> class="admin_tj_cur"<?php }?>>简历下载统计</a>
		<a href="index.php?m=admin_tongji&c=useridjob&days=7"<?php if ($_GET['c']=='useridjob') {?> class="admin_tj_cur"<?php }?>>简历投递统计</a>
		<a href="index.php?m=admin_tongji&c=order&days=7" <?php if ($_GET['c']=='order') {?> class="admin_tj_cur"<?php }?>>财务统计</a>
		<a href="index.php?m=admin_tongji&c=ad&days=7" <?php if ($_GET['c']=='ad') {?> class="admin_tj_cur"<?php }?>>广告统计</a>
		<a href="index.php?m=admin_tongji&c=company&days=7" <?php if ($_GET['c']=='company') {?> class="admin_tj_cur"<?php }?>>企业统计</a>
		<a href="index.php?m=admin_tongji&c=job&days=7" <?php if ($_GET['c']=='job') {?> class="admin_tj_cur"<?php }?>>职位数据统计</a>
		<a href="index.php?m=admin_tongji&c=resume&days=7"<?php if ($_GET['c']=='resume') {?> class="admin_tj_cur"<?php }?>>简历数据统计</a>
	</div>
	
	<form action="index.php" name="myform" method="get" onSubmit="return cktimesave()" >
        <div class="admin_tj_newlist">
			<span class="admin_tj_newname">统计时间：</span>
			<a href="javascript:;" onclick="tongjiChange('index.php?m=admin_tongji&c=<?php echo $_GET['c'];?>
&days=-1&did=<?php echo $_GET['did'];?>
')" class="admin_tj_a <?php if ($_GET['days']=='-1') {?>admin_tj_cur<?php }?>">昨天</a>
			<a href="javascript:;" onclick="tongjiChange('index.php?m=admin_tongji&c=<?php echo $_GET['c'];?>
&days=1&did=<?php echo $_GET['did'];?>
')" class="admin_tj_a <?php if ($_GET['days']=='1') {?>admin_tj_cur<?php }?>">今天</a>
			<a href="javascript:;" onclick="tongjiChange('index.php?m=admin_tongji&c=<?php echo $_GET['c'];?>
&days=7&did=<?php echo $_GET['did'];?>
')" class="admin_tj_a  <?php if ($_GET['days']=='7') {?>admin_tj_cur<?php }?>">一周内</a>
			<a href="javascript:;" onclick="tongjiChange('index.php?m=admin_tongji&c=<?php echo $_GET['c'];?>
&days=30&did=<?php echo $_GET['did'];?>
')" class="admin_tj_a  <?php if ($_GET['days']=='30') {?>admin_tj_cur<?php }?>">一月内</a>
			<a href="javascript:;" onclick="tongjiChange('index.php?m=admin_tongji&c=<?php echo $_GET['c'];?>
&days=90&did=<?php echo $_GET['did'];?>
')" class="admin_tj_a  <?php if ($_GET['days']=='90') {?>admin_tj_cur<?php }?>">三月内</a>
			<a href="javascript:;" onclick="tongjiChange('index.php?m=admin_tongji&c=<?php echo $_GET['c'];?>
&days=180&did=<?php echo $_GET['did'];?>
')" class="admin_tj_a  <?php if ($_GET['days']=='180') {?>admin_tj_cur<?php }?>">半年</a>
			<a href="javascript:;" onclick="tongjiChange('index.php?m=admin_tongji&c=<?php echo $_GET['c'];?>
&days=360&did=<?php echo $_GET['did'];?>
')" class="admin_tj_a  <?php if ($_GET['days']=='360') {?>admin_tj_cur<?php }?>">一年</a>
			<input name="m" value="admin_tongji" type="hidden"/>
			<?php if ($_GET['c']) {?>
			<input name="c" value="<?php echo $_GET['c'];?>
" type="hidden"/>
			<?php }?>
			<?php if ($_GET['did']) {?>
			<input name="did" value="<?php echo $_GET['did'];?>
" type="hidden"/>
			<?php }?>
			<input class="admin_tj_sjd" type="text" id="date" name="date" value="<?php echo $_GET['date'];?>
" placeholder="选择时间段"/>
       
			<?php echo '<script'; ?>
 type="text/javascript">
				layui.use(['laydate'], function(){
					var laydate = layui.laydate
						,$ = layui.$;
						
					laydate.render({
						elem: '#date',range:'~'
					});
				});
				function tongjiChange(url){
					loadlayer();
					window.location.href = url;
				}
			<?php echo '</script'; ?>
>
			
		
		<input  class="admin_tj_sjd1d"  type="submit" name="" value="查询"/>

		</div>
		<?php if ($_GET['c']=='order') {?>
		<div class="admin_tj_newlist">
			<span class="admin_tj_newname">分站选择：</span>
			<?php  $_smarty_tpl->tpl_vars['dlist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dlist']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['Dname']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dlist']->key => $_smarty_tpl->tpl_vars['dlist']->value) {
$_smarty_tpl->tpl_vars['dlist']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['dlist']->key;
?>
				<a href="index.php?m=admin_tongji&c=order&days=<?php echo $_GET['days'];?>
&did=<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" class="admin_tj_a  <?php if ($_GET['did']==$_smarty_tpl->tpl_vars['key']->value) {?>admin_tj_cur<?php }?>""><?php echo $_smarty_tpl->tpl_vars['dlist']->value;?>
</a>
			<?php } ?>
		</div>
		<?php }?>
 	</form>
	
</div><?php }} ?>
