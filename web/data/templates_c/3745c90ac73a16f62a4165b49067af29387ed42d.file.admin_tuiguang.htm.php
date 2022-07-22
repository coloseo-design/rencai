<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:17:53
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_tuiguang.htm" */ ?>
<?php /*%%SmartyHeaderCode:2100962c7e831a13308-20414106%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3745c90ac73a16f62a4165b49067af29387ed42d' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_tuiguang.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2100962c7e831a13308-20414106',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'birthday' => 0,
    'anniversary' => 0,
    'todaydue' => 0,
    'sevendue' => 0,
    'useradd' => 0,
    'userup' => 0,
    'addjob' => 0,
    'upjob' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e831b326c1_33122724',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e831b326c1_33122724')) {function content_62c7e831b326c1_33122724($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
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

<?php echo '<script'; ?>
 language="javascript">

	function sendemail(type,emailtype,emailtpl,dayslimit,status,value,msg,sendok,sendno){
		 
		if(status=="3"){
			var sort=1;
			var pagelimit=20;
			var pytoken=$("input[name='pytoken']").val();
			var ii = parent.layer.msg(msg,5000,{
				icon:16,shade:0.01
			})
			$.post("index.php?m=email&c=sendPromotion",{
				action:"sendEmailMsg",
				type:type,emailtype:emailtype,emailtpl:emailtpl,dayslimit:dayslimit,sort:sort,pytoken:pytoken,
				value:value,sendok:sendok,sendno:sendno,
				pagelimit:pagelimit
				},
				function(data){
					parent.layer.close(ii);
					var data=eval('('+data+')');
					sendemail(type,emailtype,emailtpl,dayslimit,data.status,data.value,data.msg,data.sendok,data.sendno)
				})
		}else{
			parent.layer.close(ii);
			parent.layer.alert(msg, 9);
			location.reload();
		}
	}
	function outemail(outtype) {
        $("#outtype").val(outtype);
        layer.confirm("确定导出相关邮箱吗？", function () {
            setTimeout(function () {
                $('#formstatus').submit()
            }, 0);
            layer.closeAll();
        });
    }
    function finishemail(type){
    	var ii = parent.layer.msg('正在执行...',5000,{
				icon:16,shade:0.01
			})
    	var pytoken=$("input[name='pytoken']").val();
    	$.post("index.php?m=email&c=finish",{type:type,pytoken:pytoken,xls_type:'email'},
			function(data){
				parent.layer.close(ii);
				var data=eval('('+data+')');
				if(data.status=='1'){

					layer.msg("操作成功！",2,9);
				}else{

					layer.msg("操作失败请重试！",2,8);
				}
			}
		)

    }
	$(document).ready(function(){ 
		$.get('index.php?m=email&c=getBirthday&type=email',{},function(data){
			var num=eval('('+data+')');
			$('#birthday').html(num.birthday_e);
			if(num.birthday_e==0){
				$("#bpost").attr("disabled",true);
				$("#bpost").attr("class","admin_unclick");

				$("#bout").attr("disabled",true);
				$("#bout").attr("class","admin_unclick");

				$("#bfinish").attr("disabled",true);
				$("#bfinish").attr("class","admin_unclick");
			}
			$('#anniversary').html(num.anniversary_e);
			if(parseInt(num.anniversary_e)==0){
				$("#apost").attr("disabled",true);
				$("#apost").attr("class","admin_unclick");

				$("#aout").attr("disabled",true);
				$("#aout").attr("class","admin_unclick");

				$("#afinish").attr("disabled",true);
				$("#afinish").attr("class","admin_unclick");
			}
			$('#todaydue').html(num.todaydue_e);
			if(num.todaydue_e==0){
				$("#tpost").attr("disabled",true);
				$("#tpost").attr("class","admin_unclick");

				$("#tout").attr("disabled",true);
				$("#tout").attr("class","admin_unclick");

				$("#tfinish").attr("disabled",true);
				$("#tfinish").attr("class","admin_unclick");
			} 
			$('#sevendue').html(num.sevendue_e);
			if(num.sevendue_e==0){
				$("#spost").attr("disabled",true);
				$("#spost").attr("class","admin_unclick");

				$("#sout").attr("disabled",true);
				$("#sout").attr("class","admin_unclick");

				$("#sfinish").attr("disabled",true);
				$("#sfinish").attr("class","admin_unclick");
			}
			$('#useradd').html(num.useradd_e);
			if(num.useradd_e==0){
				$("#useraddpost").attr("disabled",true);
				$("#useraddpost").attr("class","admin_unclick");

				$("#useraddout").attr("disabled",true);
				$("#useraddout").attr("class","admin_unclick");

				$("#useraddfinish").attr("disabled",true);
				$("#useraddfinish").attr("class","admin_unclick");
			}
			$('#userup').html(num.userup_e);
			if(num.userup_e==0){
				$("#useruppost").attr("disabled",true);
				$("#useruppost").attr("class","admin_unclick");

				$("#userupout").attr("disabled",true);
				$("#userupout").attr("class","admin_unclick");

				$("#userupfinish").attr("disabled",true);
				$("#userupfinish").attr("class","admin_unclick");
			}
			$('#addjob').html(num.addjob_e);
			if(num.addjob_e==0){
				$("#addjobpost").attr("disabled",true);
				$("#addjobpost").attr("class","admin_unclick");

				$("#addjobout").attr("disabled",true);
				$("#addjobout").attr("class","admin_unclick");

				$("#addjobfinish").attr("disabled",true);
				$("#addjobfinish").attr("class","admin_unclick");
			}
			$('#upjob').html(num.upjob_e);
			if(num.upjob_e==0){
				$("#upjobpost").attr("disabled",true);
				$("#upjobpost").attr("class","admin_unclick");

				$("#upjobout").attr("disabled",true);
				$("#upjobout").attr("class","admin_unclick");

				$("#upjobfinish").attr("disabled",true);
				$("#upjobfinish").attr("class","admin_unclick");
			}
		});
		
	});
<?php echo '</script'; ?>
>

<title>后台管理</title>


<style>
	.table_border{
		border: 1px solid #e8eaec;
		border-collapse: separate;
		border-spacing: 0px 0px;
		margin-top: 5px;
	}
	.table_border_tit{
		text-align: left;
		font-weight: bold;
		padding-left: 10px;
		font-size: 16px;
	}
	.table_border tr{
		display: block;
		height: 46px;
		line-height: 46px;
		border-bottom: 1px solid #e8eaec;
	}
	.table_border tr th{
		width: 300px;
	}
		
</style>
</head>

<body class="body_ifm">

<div class="infoboxp">
	<div class="tty-tishi_top">
	<div class="tabs_info">
		<ul>
			<li <?php if ($_GET['c']=='') {?>class="curr"<?php }?>><a  href="index.php?m=email">邮件推广</a></li>
			<li <?php if ($_GET['c']=='msgtg') {?>class="curr"<?php }?>><a href="index.php?m=email&c=msgtg">短信推广</a></li>
			<li <?php if ($_GET['c']=='tgresume') {?>class="curr"<?php }?> ><a href="index.php?m=email&c=tgresume">简历推广</a></li>
			<li <?php if ($_GET['c']=='tgjob') {?>class="curr"<?php }?> > <a href="index.php?m=email&c=tgjob">职位推广</a></li>
			<li <?php if ($_GET['c']=='email') {?>class="curr"<?php }?> ><a href="index.php?m=email&c=email">自定义邮件</a> </li>
			<li <?php if ($_GET['c']=='msg') {?>class="curr"<?php }?>><a  href="index.php?m=email&c=msg">自定义短信</a></li>
			<li <?php if ($_GET['c']=='wxtpl') {?>class="curr"<?php }?>><a  href="index.php?m=email&c=wxtpl">公众号模板消息</a></li>
		</ul>
	</div>

	<div class="clear"></div>

	<div class="admin_new_tip">
		<a href="javascript:;" class="admin_new_tip_close"></a>
		<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
		<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
		<div class="admin_new_tip_list_cont">
			<div class="admin_new_tip_list">发送短信时，请选择合适的时间进行发送</div>
		</div>
	</div>
	
	

	<div class="clear"></div>
		<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
		<table width="100%" class="table_form table_border">
			<tr style="background: #f5f7fb;">
				<th colspan="2" class="admin_bold_box">
					<div class="table_border_tit">邮件推广</div>
				</th>
			</tr>
			<tr>
				<th>今天过生日的用户:</th>
				<td>
					<div class="admin_msgtg_f">
						符合用户数：<font color="#ff9900" id="birthday">0</font> 位 
						<?php if ($_smarty_tpl->tpl_vars['birthday']->value['ctime']) {?>，上次发送时间：<font color="#ff9900"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['birthday']->value['ctime'],"%Y-%m-%d");?>
</font><?php }?>。
					</div>
					<input class="<?php if ($_smarty_tpl->tpl_vars['birthday']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="bpost" onclick="sendemail('1','1','1','','3','0','正在发送，请稍候。。。','0','0')" value="&nbsp;发送邮件&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['birthday']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>

					<input class="<?php if ($_smarty_tpl->tpl_vars['birthday']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="bout" onclick="outemail('birthday')" value="&nbsp;导出邮箱&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['birthday']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>

					<input class="<?php if ($_smarty_tpl->tpl_vars['birthday']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="bfinish" onclick="finishemail('birthday')" value="&nbsp;已发送&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['birthday']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>

				</td>
			</tr>

			<tr>
				<th>周年提醒（所有用户）:</th>
				<td>
					<div class="admin_msgtg_f">
						符合用户数：<font color="#ff9900" id="anniversary">0</font> 位
						<?php if ($_smarty_tpl->tpl_vars['anniversary']->value['ctime']) {?>，上次发送时间：<font color="#ff9900"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['anniversary']->value['ctime'],"%Y-%m-%d");?>
</font><?php }?>。
					</div>
					<input class="<?php if ($_smarty_tpl->tpl_vars['anniversary']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="apost" onclick="sendemail('2','2','1','','3','0','正在发送，请稍候。。。','0','0')" value="&nbsp;发送邮件&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['anniversary']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>

					<input class="<?php if ($_smarty_tpl->tpl_vars['anniversary']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="aout" onclick="outemail('anniversary')" value="&nbsp;导出邮箱&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['anniversary']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>

					<input class="<?php if ($_smarty_tpl->tpl_vars['anniversary']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="afinish" onclick="finishemail('anniversary')" value="&nbsp;已发送&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['anniversary']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>
				</td>
			</tr>
			<tr>
				<th>今日会员到期提醒（企业用户）:</th>
				<td>
					<div class="admin_msgtg_f">
						符合用户数：<font color="#ff9900" id="todaydue">0</font> 位
						<?php if ($_smarty_tpl->tpl_vars['todaydue']->value['ctime']) {?>，上次发送时间：<font color="#ff9900"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['todaydue']->value['ctime'],"%Y-%m-%d");?>
</font><?php }?>。
					</div>
					<input class="<?php if ($_smarty_tpl->tpl_vars['todaydue']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="tpost" onclick="sendemail('1','3','1','1','3','0','正在发送，请稍候。。。','0','0')" value="&nbsp;发送邮件&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['todaydue']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>

					<input class="<?php if ($_smarty_tpl->tpl_vars['todaydue']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="tout" onclick="outemail('todaydue')" value="&nbsp;导出邮箱&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['todaydue']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>

					<input class="<?php if ($_smarty_tpl->tpl_vars['todaydue']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="tfinish" onclick="finishemail('todaydue')" value="&nbsp;已发送&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['todaydue']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>
				</td>
			</tr>
			<tr>
				<th>7日会员到期提醒（企业用户）:</th>
				<td>
					<div class="admin_msgtg_f">
						符合用户数：<font color="#ff9900" id="sevendue">0</font> 位
						<?php if ($_smarty_tpl->tpl_vars['sevendue']->value['ctime']) {?>，上次发送时间：<font color="#ff9900"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['sevendue']->value['ctime'],"%Y-%m-%d");?>
</font><?php }?>。
					</div>
					<input class="<?php if ($_smarty_tpl->tpl_vars['sevendue']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="spost" onclick="sendemail('1','3','1','7','3','0','正在发送，请稍候。。。','0','0')" value="&nbsp;发送邮件&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['sevendue']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>

					<input class="<?php if ($_smarty_tpl->tpl_vars['sevendue']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="sout" onclick="outemail('sevendue')" value="&nbsp;导出邮箱&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['sevendue']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>

					<input class="<?php if ($_smarty_tpl->tpl_vars['sevendue']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="sfinish" onclick="finishemail('sevendue')" value="&nbsp;已发送&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['sevendue']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>
				</td>
			</tr>
      
			<tr>
				<th>注册后7日内未发布简历（个人用户）:</th>
				<td>
					<div class="admin_msgtg_f">
						符合用户数：<font color="#ff9900" id="useradd">0</font> 位
						<?php if ($_smarty_tpl->tpl_vars['useradd']->value['ctime']) {?>，上次发送时间：<font color="#ff9900"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['useradd']->value['ctime'],"%Y-%m-%d");?>
</font><?php }?>。
					</div>
					<input class="<?php if ($_smarty_tpl->tpl_vars['useradd']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="useraddpost" onclick="sendemail('1','4','1','7','3','0','正在发送，请稍候。。。','0','0')" value="&nbsp;发送邮件&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['useradd']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>

					<input class="<?php if ($_smarty_tpl->tpl_vars['useradd']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="useraddout" onclick="outemail('useradd')" value="&nbsp;导出邮箱&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['useradd']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>

					<input class="<?php if ($_smarty_tpl->tpl_vars['useradd']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="useraddfinish" onclick="finishemail('useradd')" value="&nbsp;已发送&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['useradd']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>
				</td>
			</tr>
			<tr>
				<th>7日未刷新简历（个人用户）:</th>
				<td>
					<div class="admin_msgtg_f">
						符合用户数：<font color="#ff9900" id="userup">0</font> 位
						<?php if ($_smarty_tpl->tpl_vars['userup']->value['ctime']) {?>，上次发送时间：<font color="#ff9900"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['userup']->value['ctime'],"%Y-%m-%d");?>
</font><?php }?>。
					</div>
					<input class="<?php if ($_smarty_tpl->tpl_vars['userup']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="useruppost" onclick="sendemail('1','5','1','7','3','0','正在发送，请稍候。。。','0','0')" value="&nbsp;发送邮件&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['userup']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>

					<input class="<?php if ($_smarty_tpl->tpl_vars['userup']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="userupout" onclick="outemail('userup')" value="&nbsp;导出邮箱&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['userup']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>

					<input class="<?php if ($_smarty_tpl->tpl_vars['userup']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="userupfinish" onclick="finishemail('userup')" value="&nbsp;已发送&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['userup']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>
				</td>
			</tr>
			<tr>
				<th>7日未发布职位（企业用户）</th>
				<td>
					<div class="admin_msgtg_f">
						符合用户数：<font color="#ff9900" id="addjob">0</font> 位
						<?php if ($_smarty_tpl->tpl_vars['addjob']->value['ctime']) {?>，上次发送时间：<font color="#ff9900"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['addjob']->value['ctime'],"%Y-%m-%d");?>
</font><?php }?>。
					</div>
					<input class="<?php if ($_smarty_tpl->tpl_vars['addjob']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="addjobpost" onclick="sendemail('2','6','1','7','3','0','正在发送，请稍候。。。','0','0')" value="&nbsp;发送邮件&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['addjob']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>

					<input class="<?php if ($_smarty_tpl->tpl_vars['addjob']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="addjobout" onclick="outemail('addjob')" value="&nbsp;导出邮箱&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['addjob']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>

					<input class="<?php if ($_smarty_tpl->tpl_vars['addjob']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="addjobfinish" onclick="finishemail('addjob')" value="&nbsp;已发送&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['addjob']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>

				</td>
			</tr>
			<tr>
				<th >7日未刷新职位（企业用户）</th>
				<td>
					<div class="admin_msgtg_f">
						符合用户数：<font color="#ff9900" id="upjob">0</font> 位
						<?php if ($_smarty_tpl->tpl_vars['upjob']->value['ctime']) {?>，上次发送时间：<font color="#ff9900"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['upjob']->value['ctime'],"%Y-%m-%d");?>
</font><?php }?>。
					</div>
					<input class="<?php if ($_smarty_tpl->tpl_vars['upjob']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="upjobpost" onclick="sendemail('2','7','1','7','3','0','正在发送，请稍候。。。','0','0')" value="&nbsp;发送邮件&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['upjob']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>

					<input class="<?php if ($_smarty_tpl->tpl_vars['upjob']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="upjobout" onclick="outemail('upjob')" value="&nbsp;导出邮箱&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['upjob']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>

					<input class="<?php if ($_smarty_tpl->tpl_vars['upjob']->value['disabled']==1) {?>admin_unclick<?php } else { ?>admin_unclick2<?php }?>" type="submit" id="upjobfinish" onclick="finishemail('upjob')" value="&nbsp;已发送&nbsp;"  <?php if ($_smarty_tpl->tpl_vars['upjob']->value['disabled']==1) {?>disabled="disabled"<?php }?>/>

				</td>
			</tr>
		</table>
		<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
		<div id="export" style="display:none;">
		    <div style=" margin-top:10px;">
		        <div>
		            <form action="index.php?m=email&c=xls" target="supportiframe" method="post" id="formstatus" class="myform">
		                <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
		                <input id="outtype" name="outtype" value="" type="hidden">
		                <input name="xls_type" value="email" type="hidden">
		            </form>
		        </div>
		    </div>
		</div>
	</div>
</div>
</body>
</html><?php }} ?>
