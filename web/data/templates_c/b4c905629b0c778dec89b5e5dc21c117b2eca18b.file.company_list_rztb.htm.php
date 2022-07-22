<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:49:02
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\company_list_rztb.htm" */ ?>
<?php /*%%SmartyHeaderCode:3217262d904eec4c4a0-36863730%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b4c905629b0c778dec89b5e5dc21c117b2eca18b' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\company_list_rztb.htm',
      1 => 1635304534,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3217262d904eec4c4a0-36863730',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d904eed5a295_67062422',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d904eed5a295_67062422')) {function content_62d904eed5a295_67062422($_smarty_tpl) {?><!--列表页认证图标相关操作  目前只有crm在用-->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/viewer/viewer.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/viewer/viewer.min.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />

<!-- 邮箱认证弹出框 -->
<div id="renemail" style="display:none;text-align:center; ">
	<div class="mt10">
		<form class="layui-form" action="index.php?m=admin_company&c=emaillock" target="supportiframe" method="post" autocomplete="off">
			<table cellspacing='1' cellpadding='1' class="admin_examine_table">
				<tr>
					<th width="80">邮箱：</th>
					<td align="left">
						<div class="layui-input-block">
							<input type="text" id="comemail" class="tty_input t_w200" name="comemail" value="">
						</div>
					</td>
				</tr>
				<tr>
					<th width="80">认证操作：</th>
					<td align="left">
						<div class="layui-input-block">
							<input name="estatus" id="estatus0"  value="0" title="待认证" type="radio" />
							<input name="estatus" id="estatus1"  value="1" title="已认证" type="radio" />
						</div>
					</td>
				</tr>

				<tr>
					<td colspan='2' align="center">
						<input type="submit" onclick="loadlayer();" value='确认' class="admin_examine_bth">
						<input type="button" class="admin_examine_bth_qx closebutton" value='取消'>
					</td>
				</tr>
			</table>

			<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
			<input type="hidden" name="uid" id="uid" value="0" >
		</form>
	</div>
</div>
<!-- 邮箱认证弹出框END -->

<!--手机认证弹出框-->
<div id="renphone" style="display:none;text-align:center; ">
	<div class="mt10">
		<form class="layui-form" action="index.php?m=admin_company&c=phonelock" target="supportiframe" method="post" autocomplete="off">
			<table cellspacing='1' cellpadding='1' class="admin_examine_table">
				<tr>
					<th width="80">手机号码：</th>
					<td align="left">
						<div class="layui-input-block">
							<input type="text" class="tty_input t_w200" id="comlinktel" name="comlinktel" value="">
						</div>
					</td>
				</tr>
				<tr>
					<th width="80">认证操作：</th>
					<td align="left">
						<div class="layui-input-block">
							<input name="mstatus" id="pstatus0"  value="0" title="待认证" type="radio" />
							<input name="mstatus" id="pstatus1"  value="1" title="已认证" type="radio" />
						</div>
					</td>
				</tr>

				<tr>
					<td colspan='2' align="center">
						<input type="submit" onclick="loadlayer();" value='确认' class="admin_examine_bth">
						<input type="button" class="admin_examine_bth_qx closebutton" value='取消'>
					</td>
				</tr>
			</table>

			<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
			<input type="hidden" name="uid" id="phoneuid" value="0" >
		</form>
	</div>
</div>
<!-- 手机认证end -->
<!-- 证书认证弹出框 -->
<div id="preview" style="display:none;width:450px ">
	<div style="height:500px; overflow:auto;width:650px;">
		<form class="layui-form" name="formstatus" action="index.php?m=admin_company&c=comStatus" target="supportiframe" method="post" onsubmit="return tcdiv();">

			<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">

			<table cellspacing='1' cellpadding='1' class="admin_examine_table">
				<tr>
					<th>公司名称：</th>
					<td align="left"><span id="comname_id"></span></td>
				</tr>
				<?php if ($_smarty_tpl->tpl_vars['config']->value['com_social_credit']=="1") {?>
				<tr>
					<th>统一社会信用代码：</th>
					<td align="left"><span id="social_credit"></span></td>
				</tr>
				<tr>
					<?php }?>
					<th class="t_fr">证件照片：</th>
					<td align="left">
						<div class="zj_box_list">
							<div id="preview_show" class="zj_box"></div>
							<div class="zj_box_name">营业执照/代码证</div>
						</div>
						<?php if ($_smarty_tpl->tpl_vars['config']->value['com_cert_owner']=="1") {?>
						<div class="zj_box_list">
							<div id="owner_cert_show" class="zj_box"></div>
							<div class="zj_box_name"> 经办人身份证</div>
						</div>

						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['config']->value['com_cert_wt']=="1") {?>

						<div class="zj_box_list">
							<div id="wt_cert_show" class="zj_box"></div>
							<div class="zj_box_name">   委托书/承诺函</div>
						</div>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['config']->value['com_cert_other']=="1") {?>
						<div class="zj_box_list">
							<div id="other_cert_show" class="zj_box"></div>
							<div class="zj_box_name">   其他材料</div>
						</div>
						<?php }?>
						<div class="clear"></div>
						<div class=""><span class="admin_web_tip">说明：点击图片查看原图</span></div>
					</td>
				</tr>

				<tr>
					<th width="130">审核操作：</th>
					<td align="left">
						<div class="layui-input-block">
							<input name="r_status" id="comstatus1" value="1" title="正常" type="radio" />
							<input name="r_status" id="comstatus2" value="2" title="未通过" type="radio" />
						</div>
					</td>
				</tr>
				<?php if ($_smarty_tpl->tpl_vars['config']->value['com_free_status']=='1') {?>
				<tr>
					<th>同步操作：</th>
					<td align="left">
						<div class="layui-input-block">
							<input name="job_status" value="1" title="审核" type="checkbox" />
							【说明：所有未审核职位同步审核成功】
						</div>
					</td>
				</tr>
				<?php }?>

				<tr>
					<th class="t_fr">审核说明：</th>
					<td align="left"><textarea id="renzhencontent" name="statusbody" class="admin_explain_textarea"></textarea></td>
				</tr>
				<tr>
					<td colspan='2' align="center">
						<div class=""> <input type="submit" value='确认' class="admin_examine_bth"> <input type="button" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'></div>
					</td>
				</tr>
			</table>
			<input name="noyyzz" id="noyyzz" value="" type="hidden">
			<input name="uid" id="comuid" value="0" type="hidden">
		</form>

	</div>
</div>
<!-- 证书认证弹出框end -->
<div id="acwxbind" class="wx_login_show none">
	<div class="job_tel_wx_box">
		<div id="wx_login_qrcode" class=" job_tel_wx_zs">正在获取二维码...</div>
		<div class="job_tel_wx_p"><span class="job_tel_wx_bth">将二维码发给企业，企业扫码后绑定</span></div>
		<div id="wx_sx" class="none">
			<div class="fast_login_show_sxbox"><a href="javascript:void(0);" onclick="getwxlogincode()" class="fast_login_show_sxicon"></a>二维码已失效点击刷新</div>
		</div>
	</div>
</div>

<?php echo '<script'; ?>
>
	$(document).ready(function () {
		/* 公众号,微信小程序和APP微信绑定状态显示 */
		$(".wxBindmsgs").hover(function(){
			var msg=$(this).attr('msg');
			msg += '<br/>点击图标，可弹出绑定微信二维码';
			layer.tips(msg, this, {guide: 1, style: ['background-color:#5EA7DC; color:#fff;top:-7px', '#5EA7DC'],area: ['250px', 'auto'],time:5000});
			$(".xubox_layer").addClass("xubox_tips_border");
		},function(){

			layer.closeAll('tips');

		});

		/* 邮箱绑定状态显示 */
		$(".mt_email").hover(function(){
			var msg=$(this).attr('msg');
			msg += '<br/>点击图标，可弹出绑定邮箱';
			layer.tips(msg, this, {guide: 1, style: ['background-color:#5EA7DC; color:#fff;top:-7px', '#5EA7DC'],area: ['200px', 'auto'],time:5000});
			$(".xubox_layer").addClass("xubox_tips_border");
		},function(){

			layer.closeAll('tips');

		});

		/* 手机号绑定状态显示 */
		$(".mt_phone").hover(function(){
			var msg=$(this).attr('msg');
			msg += '<br/>点击图标，可弹出绑定手机号';
			layer.tips(msg, this, {guide: 1, style: ['background-color:#5EA7DC; color:#fff;top:-7px', '#5EA7DC'],area: ['200px', 'auto'],time:5000});
			$(".xubox_layer").addClass("xubox_tips_border");
		},function(){

			layer.closeAll('tips');

		});

		/* 企业资质绑定状态显示 */
		$(".m_yyzz").hover(function(){
			var msg=$(this).attr('msg');
			msg += '<br/>点击图标，可查看企业资质认证';
			layer.tips(msg, this, {guide: 1, style: ['background-color:#5EA7DC; color:#fff;top:-7px', '#5EA7DC'],area: ['200px', 'auto'],time:5000});
			$(".xubox_layer").addClass("xubox_tips_border");
		},function(){
			layer.closeAll('tips');
		});

		/* 邮件认证 */
		$(".mt_email").click(function(data){
			var status = $(this).attr("data-status");
			var uid    = $(this).attr("data-url");
			var email  = $(this).attr("data-mail");
			$('#comname_id').html(name);
			$('#comemail').val(email);
			$('#uid').val(uid);
			$("#estatus" + status).attr("checked", true);
			layui.use([ 'form' ], function() {
				var form = layui.form;
				form.render();
			});
			$.layer({
				type : 1,
				title : '邮箱认证',
				closeBtn : [ 0, true ],
				offset : [ '80px', '' ],
				border : [ 10, 0.3, '#000', true ],
				area : [ '350px', '220px' ],
				page : {
					dom : '#renemail'
				}
			});

			$('.closebutton').on('click', function(){
				var index = layer.index;
				layer.close(index);
			});
		})

		/* 手机认证 */
		$(".mt_phone").click(function(data){
			var status   = 	$(this).attr("data-status");
			var uid      = 	$(this).attr("data-url");
			var linktel  = 	$(this).attr("data-phone");
			$('#comlinktel').val(linktel);
			$('#phoneuid').val(uid);
			$("#pstatus" + status).attr("checked", true);
			layui.use([ 'form' ], function() {
				var form = layui.form;
				form.render();
			});
			$.layer({
				type : 1,
				title : '手机认证',
				closeBtn : [ 0, true ],
				offset : [ '80px', '' ],
				border : [ 10, 0.3, '#000', true ],
				area : [ '350px', '220px' ],
				page : {
					dom : '#renphone'
				}
			});
		})

		/* 企业资质 */
		$(".m_yyzz").click( function() {
			var url = $(this).attr("data-url");
			var ourl = $(this).attr("data-ourl");
			var wurl = $(this).attr("data-wurl");
			var otherurl = $(this).attr("data-otherurl");
			var name = $(this).attr("data-name");
			var social_credit = $(this).attr("data-scredit");
			var uid = $(this).attr("data-uid");
			var pytoken = $('#pytoken').val();
			var picobj = {
				'preview':url,
			<?php if ($_smarty_tpl->tpl_vars['config']->value['com_cert_owner']=="1") {?>'owner_cert':ourl,<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['config']->value['com_cert_wt']=="1") {?>'wt_cert'   :wurl,<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['config']->value['com_cert_other']=="1") {?>'other_cert':otherurl<?php }?>
					};
						$("#comname_id").html(name);
						if($("#social_credit")){
							$("#social_credit").html(social_credit);
						}
						$("#comuid").val(uid);
						$("#comstatus" + status).attr("checked", true);
						layui.use([ 'form' ], function() {
							var form = layui.form;
							form.render();
						});
						$.post("index.php?m=comcert&c=sbody", {uid: uid,pytoken: pytoken}, function(msg) {
							$("#renzhencontent").val(msg);
						});

						for(let i in picobj){
							if($("#"+i+"_show")){
								$("#"+i+"_show").html("<img src='" + picobj[i] + "' style='width:100px;height:100px' />");
								if(picobj[i]){
									// $("#"+i+"_url").attr("href",picobj[i]);
									$("#zw_"+i).hide();
									$("#"+i+"_url").show();
								}else{
									$("#"+i+"_url").hide();
									$("#noyyzz").val('1');
									$("#zw_"+i).show();
								}
							}

						}


						$.layer({
							type : 1,
							title : '查看图片',
							closeBtn : [ 0, true ],
							offset : [ '80px', '' ],
							border : [ 10, 0.3, '#000', true ],
							area : [ '650px', 'auto' ],
							page : {
								dom : '#preview'
							}
						});
						var viewer = new Viewer(document.getElementById('preview'), {
							url: 'lay-src',
							toolbar: true,  //显示工具条
							show: function (){        // 动态加载图片后，更新实例
								viewer.update();
							},
						});
					});

		$('.closebutton').on('click', function(){
			var index = layer.index;
			layer.close(index);
		});
	});

	// 显示微信绑定弹窗
	function showQrcode(comid,wxid){
		if(wxid == ''){
			acwxbind(comid);
			$.layer({
				type: 1,
				title: '微信扫码绑定',
				closeBtn: [0, true],
				offset: ['100px', ''],
				border: [10, 0.3, '#000', true],
				area: ['300px', '300px'],
				page: {
					dom: "#acwxbind"
				},
				close: function(){
					if(setval){
						clearInterval(setval);
						setval = null;
					}
					if(setwout){
						clearTimeout(setwout);
						setwout = null;
					}
				}
			});
		}else{
			layer.msg('企业已绑定微信',2,9);
		}
	}

	// 获取微信绑定二维码
	var setval,
			setwout;
	function acwxbind(comid){
		var pytoken = $("#pytoken").val();
		$.post('index.php?m=admin_company&c=acwxbind', {
			comid: comid,
			pytoken: pytoken
		}, function(data) {
			if(data == 0) {
				$('#wx_login_qrcode').html('二维码获取失败..');
			} else {
				$('#wx_login_qrcode').html('<img src="' + data + '" width="140" height="140">');
				setval = setInterval(function(){
					$.post('index.php?m=admin_company&c=getacbindstatus', {
						comid: comid,
						pytoken: pytoken
					}, function(data) {
						var data = eval('(' + data + ')');
						if(data.msg != '') {
							clearInterval(setval);
							setval = null;
							layer.msg(data.msg, 2, 9, function() {
								window.location.reload();
							});
						}
					});
				}, 2000);
				if(setwout){
					clearTimeout(setwout);
					setwout = null;
				}
				setwout = setTimeout(function(){
					if(setval){
						clearInterval(setval);
						setval = null;
					}
					var wx_sx = $("#wx_sx").html();
					$('#wx_login_qrcode').html(wx_sx);
				},300*1000);
			}
		});
	}
<?php echo '</script'; ?>
>
<?php }} ?>
