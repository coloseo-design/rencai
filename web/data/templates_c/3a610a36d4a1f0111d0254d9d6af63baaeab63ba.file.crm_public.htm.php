<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:22:11
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\crm_public.htm" */ ?>
<?php /*%%SmartyHeaderCode:1456462c54633acf918-06240497%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3a610a36d4a1f0111d0254d9d6af63baaeab63ba' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\crm_public.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1456462c54633acf918-06240497',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cache' => 0,
    'v' => 0,
    'canpay' => 0,
    'key' => 0,
    'cop' => 0,
    'ratinglist' => 0,
    'adminUserList' => 0,
    'pytoken' => 0,
    'crmUser' => 0,
    'crmStatus' => 0,
    'status' => 0,
    'crmClassName' => 0,
    'crmType' => 0,
    'type' => 0,
    'outClass' => 0,
    'out' => 0,
    'auid' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c54633b237e4_52760656',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c54633b237e4_52760656')) {function content_62c54633b237e4_52760656($_smarty_tpl) {?><div id="crmNewConcern"  style="display:none;">
	<form class="layui-form" lay-filter='formConcern'> 
		<div class="crm_record_list" >
			<div class="crm_record_name"><span class="admin_required_icon"></span> 客户名称：</div>
			<div class="crm_record_textbox" style='width:180px;'>
				<div>
				  	<div class="layui-input-inline" >
						<input type="text" class="layui-input"  name="crm_keyword" id="fcomname" style='width:315px;' placeholder='输入企业名称，搜索选择'>
				  	</div>
				</div>
				<div  class="layui-anim_al">
					<dl name="word" class="layui-anim_all" >
					</dl>
				</div>
			</div>
		</div>
		<div class="crm_record_list" >
			<div class="crm_record_name"><span class="admin_required_icon"></span> 跟进时间：</div>
			<div class="crm_record_textbox" >
				<div>
					<div class="layui-inline">
						<div class="layui-input-inline">
							<input type="text" class="layui-input" id="public_ftime" name="ftime" >
						</div>
					</div>
				</div>
			</div>
		</div>	
		<div class="crm_record_list" >
			<div class="crm_record_name"><span class="admin_required_icon"></span> 跟进方式：</div>
			<div class="crm_record_textbox" >
				<div >
					<div class="layui-input-inline" >
						<select name="order_type" id="fWay" lay-filter="">
 						    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cache']->value['crmdata']['follow_way']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
						        <option value='<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
' title='<?php echo $_smarty_tpl->tpl_vars['cache']->value['crmclass_name'][$_smarty_tpl->tpl_vars['v']->value];?>
'><?php echo $_smarty_tpl->tpl_vars['cache']->value['crmclass_name'][$_smarty_tpl->tpl_vars['v']->value];?>
</option>
			              	<?php } ?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="crm_record_list" >
			<div class="crm_record_name"><span class="admin_required_icon"></span> 跟进内容：</div>
			<div class="crm_record_textbox" style='width:80px;'>
				<div >
				  <div class="layui-input-inline" >
						<textarea id="fRemark" class="layui-textarea" style="width:315px;"></textarea>
				  </div>
				</div>
			</div>
		</div>
		<div class="crm_record_list" >
			<div class="crm_record_name"><span class="admin_required_icon"></span> 下次跟进：</div>
			<div class="crm_record_textbox" >
				<div >
					<div class="layui-input-inline" style="width:20px; padding-top:10px;">
						<input type="checkbox" lay-skin="primary" lay-filter="follow" id="follow"/>
					</div>
					<div class="layui-input-inline ftime_div" style="display: none;">
						<input type="text" class="layui-input" id='public_ptime' name="ptime"  placeholder='请选择跟进时间' />
					</div>
				</div>
			</div>
		</div>
		<div class="crm_record_list" style="padding-bottom:20px;">
			<span class="crm_record_name">&nbsp;</span>
			<div class="crm_record_textbox"  style='width:315px;' >
				<input type="hidden" id="crm_task_id" value="" />
				<input type="button" value='确认' class="admin_examine_bth crmConcern" />
			</div> 	
		</div> 
	</form> 
</div>

<div id="crmDeal"  style="display:none;">
	<form class="layui-form" lay-filter="crmFormDeal"> 
		<div class="crm_record_list" >
			<div class="crm_record_name"><span class="admin_required_icon"></span> 客户名称：</div>
			<div class="crm_record_textbox" style='width:180px;'>
				<div>
				  <div class="layui-input-inline" >
						<input type="text" class="layui-input"  name="crm_keyword" id="comname" style='width:315px;' >
				  </div>
				</div>
				<div  class="layui-anim_al">
					<dl name="word" class="layui-anim_all" >
					</dl>
				</div>
			</div>
		</div>
		<div class="crm_record_list" >
			<div class="crm_record_name"><span class="admin_required_icon"></span> 支付方式：</div>
			<div class="crm_record_textbox" >
				<div>
					<div class="layui-input-inline" >
						<select name="order_type" id="order_type" lay-filter="order_type">
						    <option value=''>请选择</option>
 							<?php  $_smarty_tpl->tpl_vars['cop'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cop']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['canpay']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cop']->key => $_smarty_tpl->tpl_vars['cop']->value) {
$_smarty_tpl->tpl_vars['cop']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['cop']->key;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['cop']->value;?>
</option>
							<?php } ?>
 						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="crm_record_list" >
			<div class="crm_record_name"><span class="admin_required_icon"></span> 会员套餐：</div>
			<div class="crm_record_textbox" >
				<div >
					<div class="layui-input-inline" >
						<select name="rid" id="rid_val" lay-filter="rid">
                            <option value="">请选择</option>
                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ratinglist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
                            <?php } ?>
                        </select>
					</div>
				</div>		
			</div>
		</div>
		<div class="crm_record_list" >
			<div class="crm_record_name"><span class="admin_required_icon"></span> 付款金额：</div>
			<div class="crm_record_textbox" >
				<div >
					<div class="layui-input-inline" >
						 <input type="text" name="order_price" id="order_price" size="15"  value="" class="layui-input"/>
					</div>
				</div>		
			</div>
		</div>
		<div class="crm_record_list" >
			<div class="crm_record_name"><span class="admin_required_icon"></span> 备注信息：</div>
			<div class="crm_record_textbox" style='width:80px;'>
				<div >
				  <div class="layui-input-inline" >
						<textarea id="order_remark" name="order_remark"  class="layui-textarea" style="width:315px;"></textarea>
				  </div>
				</div>
			</div>
		</div>
		<div class="crm_record_list" style="padding-bottom:20px;">
			<span class="crm_record_name">&nbsp;</span>
			<div class="crm_record_textbox"  style='width:315px;' >
				<input type="hidden" id='dealInfo' value='' />
				<input type="hidden" id="orderId" name="orderId" value='' />
				<input type="button" id="newOrder" value='确认' class="admin_examine_bth">
			</div> 	
		</div> 
	</form> 
</div>

<div id="crmNewTask"  style="display:none; width:450px; ">
	<form class="layui-form" lay-filter='formCrmTask'>
		<div class="crm_record_list" >
			<div class="crm_record_name"><span class="admin_required_icon"></span> 任务类型：</div>
			<div class="crm_record_textbox" >
				<div>
					<div class="layui-input-inline" >
						<select name="taskType" id="taskType" lay-filter="taskType">
							<option value="">请选择</option>
                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cache']->value['crmdata']['task_type']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['cache']->value['crmclass_name'][$_smarty_tpl->tpl_vars['v']->value];?>
</option>
                            <?php } ?>
                        </select>
					</div>
				</div>		
			</div>
		</div>
		
		<div class="crm_record_list" >
			<div class="crm_record_name"><span class="admin_required_icon"></span> 客户名称：</div>
			<div class="crm_record_textbox">
				<div>
				  <div class="layui-input-inline" style="width:315px" >
					<input type="text" class="layui-input" name="crm_keyword" id="tcomname" style='width:315px;' placeholder='填写名称，搜索选择'  />
				  </div>
				 </div>
				 <div  class="layui-anim_al">
					<dl name="word" class="layui-anim_all" >
					 </dl>
				 </div>
			</div>
		</div>
		<div class="crm_record_list" id="handle">
			<div class="crm_record_name"><span class="admin_required_icon"></span> 处理人：</div>
			<div class="crm_record_textbox" >
				<div>
					<div class="layui-input-inline" >
						<select name="taskHuid" id="taskHuid" lay-filter="taskHuid">
							<option value="">请选择</option>
                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['adminUserList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
                            <?php } ?>
                        </select>
					</div>
				</div>		
			</div>
		</div>
		<div class="crm_record_list" id="taskTimeshow" style="display:none;">
			<div class="crm_record_name"><span class="admin_required_icon"></span>任务时间：</div>
			<div class="crm_record_textbox">
				<div>
					<div class="layui-inline">
						<div class="layui-input-inline">
							<input type="text" class="layui-input" id='taskTime' name='taskTime' placeholder="yyyy-MM-dd HH:mm:ss" style='width:315px;'>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="crm_record_list">
			<div class="crm_record_name"><span class="admin_required_icon"></span>任务描述：</div>
			
			<div class="crm_record_textbox">
				<textarea  id="taskRemark" name="taskRemark" cols="100" rows="4"  class="layui-textarea"></textarea>
			</div>
		</div>
		<div class="crm_record_list" style="padding-bottom:20px;">
			<span class="crm_record_name">&nbsp;</span>
            <div class="crm_record_textbox">
				<input type="button"  value='确认' class="admin_examine_bth" id="crmTask">
			</div> 	
		</div> 
		<input type="hidden" id="info" value="" />
		<input type="hidden" id="task_type_id" value="" />
	</form> 
</div>

<div id="crmworklog"  style="display:none; width:450px; ">
	<form class="layui-form" action="index.php?m=crm_worklog&c=add" target="supportiframe" method="post" lay-filter="formCrmWorklog" onsubmit="return crmworklog()" autocomplete='off'>
		<div class="crm_record_list">
			<div class="crm_record_name" style="width: 200px;"><span class="admin_required_icon" >注意：提交后将不能修改！</span></div>
	 	</div>
		<div class="crm_record_list">
			<div class="crm_record_name"><span class="admin_required_icon"></span>日志标题：</div>
			<div class="crm_record_textbox">
				<div>
					<div class="layui-inline">
						<div class="layui-input-inline">
							<input type="text" class="layui-input" id='logtitle' name='logtitle'  style='width:315px;'>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="crm_record_list">
			<div class="crm_record_name"><span class="admin_required_icon"></span>日志内容：</div>
			<div class="crm_record_textbox" >
				<textarea id="logcontent" name="logcontent"  class="layui-textarea" style="width:500px;height:200px;"></textarea>
			</div>
		</div>
		<div class="crm_record_list">
			<span class="crm_record_name">&nbsp;</span>
			<div class="crm_record_textbox">
				<input type="submit"  value='确认' class="admin_examine_bth"><input type="button"  onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消' style="margin-left:10px;">
			</div> 	
		</div> 
		<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
	</form> 
</div>

<div id="comLinkInfo"  style="display:none; width:450px; ">
	<form class="layui-form">
		
		<div class="crm_record_list" >
			<div>
		    	<div class="layui-inline">
		      		<label class="layui-form-label">客户名称：</label>
		      		<div class="layui-input-inline" style="width: 310px;">
		        		<input type="text" id="comLink_name" autocomplete="off" class="layui-input">
		      		</div>
		    	</div>
			</div>
		</div>
		
		<div class="crm_record_list" >
			<div>
		    	<div class="layui-inline">
		      		<label class="layui-form-label">会员套餐：</label>
		      		<div class="layui-input-inline" style="width: 100px;">
		        		<input type="text" id="comLink_ratingname"   autocomplete="off" class="layui-input">
		      		</div>
		      		<div class="layui-input-inline" style="width: 100px;">
		        		<input type="text" id="comLink_vipetime"   autocomplete="off" class="layui-input">
		      		</div>
		    	</div>
			</div>
		</div>
		
		<div class="crm_record_list" >
			<div>
		    	<div class="layui-inline">
		      		<label class="layui-form-label">所在城市：</label>
		      		<div class="layui-input-inline" style="width: 210px;">
		        		<input type="text" id="comLink_city" autocomplete="off" class="layui-input">
		      		</div>
		    	</div>
			</div>
		</div>
		
		<div class="crm_record_list" >
			<div>
		    	<div class="layui-inline">
		      		<label class="layui-form-label">联系方式：</label>
		      		<div class="layui-input-inline" style="width: 100px;">
		        		<input type="text" id="comLink_linkman"   autocomplete="off" class="layui-input">
		      		</div>
		      		<div class="layui-input-inline" style="width: 100px;">
		        		<input type="text" id="comLink_linktel"   autocomplete="off" class="layui-input">
		      		</div>
		    	</div>
			</div>
		</div>
	</form> 
</div>

<div id="crmDeliver"  style="display:none;">
	<form class="layui-form" lay-filter="formCrmDeliver"> 
		<div class="crm_record_tip" >
			<font color='red'>重要提示：客户被转交后将不能拥有客户操作权限</font>
		</div>
		<div class="crm_record_tip" >
			将企业客户转交给：
		</div>
		<div class="crm_record_list" >
			<div class="crm_record_name"><span class="admin_required_icon"></span> 客户经理：</div>
			<div class="crm_record_textbox" >
				<div>
					<div class="layui-input-inline" >
						<select name="crmuser" id="crmuser" lay-filter="">
                            <option value="">请选择</option>
                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['crmUser']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
-<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
                            <?php } ?>
                        </select>
					</div>
				</div>		
			</div>
		</div>
		<div class="crm_record_list" >
			<div class="crm_record_name"><span class="admin_required_icon"></span> 备注信息：</div>
			<div class="crm_record_textbox" style='width:80px;'>
				<div>
				  <div class="layui-input-inline" >
						<textarea id="deliverRemark" class="layui-textarea" style="width:315px;"></textarea>
				  </div>
				</div>
			</div>
		</div>
		<div class="crm_record_list" style="padding-bottom:20px;">
			<span class="crm_record_name">&nbsp;</span>
			<div class="crm_record_textbox"  style='width:315px;' >
				<input type="button" value='确认转交' class="admin_examine_bth" onclick="crmDeliver()">
			</div> 	
		</div> 
	</form> 
</div>

<div id="crmGiveup"  style="display:none;">
	<form class="layui-form" lay-filter="formCrmGiveup"> 
		<div class="crm_record_tip" >
		
			<font color='red'>重要提示：客户被放弃后将不能拥有客户操作权限</font>
			
		</div>
		<div class="crm_record_list" >
			<div class="crm_record_name"><span class="admin_required_icon"></span> 说明备注：</div>
			<div class="crm_record_textbox" style='width:80px;'>
				<div>
				  <div class="layui-input-inline" >
						<textarea id="giveupRemark" class="layui-textarea" style="width:315px;"></textarea>
				  </div>
				</div>
			</div>
		</div>
		<div class="crm_record_list" style="padding-bottom:20px;">
			<span class="crm_record_name">&nbsp;</span>
			<div class="crm_record_textbox"  style='width:315px;' >
				<input type="button" value='确认放弃' class="admin_examine_bth" onclick="crmGiveup()">
			</div> 	
		</div> 
	</form> 
</div>

<div id="crmStatusType"  style="display:none;">
	<form class="layui-form" lay-filter="formCrmStatusType"> 
		<div class="crm_record_list" >
 			<div class="crm_record_name">客户设置为：</div>
 			<div class="crm_record_textbox" id="select_CrmStatus" style="display:none;">
				<div>
				    <div class="layui-input-block">
				    	<?php  $_smarty_tpl->tpl_vars['status'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['status']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['crmStatus']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['status']->key => $_smarty_tpl->tpl_vars['status']->value) {
$_smarty_tpl->tpl_vars['status']->_loop = true;
?>
				      	<input type="radio" name="status" value="<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['crmClassName']->value[$_smarty_tpl->tpl_vars['status']->value];?>
" title="<?php echo $_smarty_tpl->tpl_vars['crmClassName']->value[$_smarty_tpl->tpl_vars['status']->value];?>
">
				      	<?php } ?>
   				    </div>
				</div>	
			</div>
			
			<div class="crm_record_textbox" id="select_CrmType" style="display:none;">
				<div>
				    <div class="layui-input-block">
				    	<?php  $_smarty_tpl->tpl_vars['type'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['type']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['crmType']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['type']->key => $_smarty_tpl->tpl_vars['type']->value) {
$_smarty_tpl->tpl_vars['type']->_loop = true;
?>
				      	<input type="radio" name="level" value="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['crmClassName']->value[$_smarty_tpl->tpl_vars['type']->value];?>
" title="<?php echo $_smarty_tpl->tpl_vars['crmClassName']->value[$_smarty_tpl->tpl_vars['type']->value];?>
">
				      	<?php } ?>
   				    </div>
				</div>	
			</div>
			
		</div>
		<div class="crm_record_list" >
			<div class="crm_record_name"><span class="admin_required_icon"></span> 备注信息：</div>
			<div class="crm_record_textbox" style='width:80px;'>
				<div>
				  <div class="layui-input-inline" >
						<textarea id="st_Remark" class="layui-textarea" style="width:315px;"></textarea>
				  </div>
				</div>
			</div>
		</div>
		<div class="crm_record_list" style="padding-bottom:20px;">
			<span class="crm_record_name">&nbsp;</span>
			<div class="crm_record_textbox"  style='width:315px;' >
 				<input type="hidden" id='isSt' value="">
				<input type="button" value='确认' class="admin_examine_bth" onclick="crmStatusType();">
			</div> 	
		</div> 
	</form> 
</div>

<div id="crmOut"  style="display:none; width:450px; ">

	<form class="layui-form" lay-filter="formCrmOut">
		
		<div class="crm_record_list">
			<div class="crm_record_name"><span class="admin_required_icon"></span>客户名称：</div>
			<div class="crm_record_textbox">
				<div>
					<div class="layui-inline">
						<div class="layui-input-inline">
							 <input type="text" class="layui-input" id='outComName' name="crm_keyword"  style='width:173px;'>
						</div>
					</div>
				</div>
				<div  class="layui-anim_al">
					<dl name="word" class="layui-anim_all" >
					</dl>
				</div>
			</div>
		</div>
		
		<div class="crm_record_list">
			<div class="crm_record_name"><span class="admin_required_icon"></span>外出原因：</div>
			<div class="crm_record_textbox">
				<div>
					<div class="layui-inline">
						<div class="layui-input-inline">
							<select name="reason" id="reason" lay-filter="">
	                            <option value="">请选择</option>
	                            <?php  $_smarty_tpl->tpl_vars['out'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['out']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['outClass']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['out']->key => $_smarty_tpl->tpl_vars['out']->value) {
$_smarty_tpl->tpl_vars['out']->_loop = true;
?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['out']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['crmClassName']->value[$_smarty_tpl->tpl_vars['out']->value];?>
</option>
	                            <?php } ?>
	                        </select>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="crm_record_list">
			<div class="crm_record_name"><span class="admin_required_icon"></span>外出时间：</div>
			<div class="crm_record_textbox">
				<div>
					<div class="layui-inline">
						<div class="layui-input-inline">
							<input type="text" class="layui-input" id='outStime' name='outStime'  style='width:173px;'>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="crm_record_list">
			<div class="crm_record_name"><span class="admin_required_icon"></span>返回时间：</div>
			<div class="crm_record_textbox">
				<div>
					<div class="layui-inline">
						<div class="layui-input-inline">
							<input type="text" class="layui-input" id='outEtime' name='outEtime'  style='width:173px;'>
						</div>
					</div>
				</div>
			</div>
		</div>
		 
		<div class="crm_record_list">
			<div class="crm_record_name"><span class="admin_required_icon"></span>备注：</div>
			<div class="crm_record_textbox" >
				<textarea id="outRemark" name="outRemark"  class="layui-textarea" style="width:300px;"></textarea>
			</div>
		</div>
		<div class="crm_record_list">
			<span class="crm_record_name">&nbsp;</span>
			<div class="crm_record_textbox">
 				<input type="button"  value='确认' class="admin_examine_bth" onclick='crmOut();'>
			</div> 	
		</div> 
	</form> 
</div>

<div>
	<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
	<input type='hidden' id="com_uid" name="com_uid" value="" />
	<input type='hidden' id="auid" name="auid" value="<?php echo $_smarty_tpl->tpl_vars['auid']->value;?>
" />
	<input type='hidden' id="newwindow" value="" />
</div>
<style>
	.layui-anim_al {
	    position: absolute;
	    z-index: 2147483647;
	    min-width: 315px;
	    max-height: 300px;
	    overflow-y: auto;
	    background-color: white;
	    border-radius: 2px;
	    box-shadow: 0 2px 4px hsla(0, 0%, 0%, .12);
	    box-sizing: border-box;
	}
	.layui-anim_al dl dd, .layui-anim_al dl dt {
	    padding: 0 10px;
	    line-height: 36px;
	    white-space: nowrap;
	    overflow: hidden;
	    text-overflow: ellipsis;
	}
	.click_work {
	    padding-bottom: 8px;
	    font-weight: lighter;
	    font-size: 13px;
	    cursor: pointer;
	}
</style>

<?php echo '<script'; ?>
>
	layui.use([ 'form', 'laydate' ], function() {
		var form 	= layui.form, 
			laydate = layui.laydate, 
			$ 		= layui.$;
		
		var pytoken = 	$('#pytoken').val();
		var auid	=	$('#auid').val();
		
		form.on('select(taskType)', function(data) {
			
			if(data.value=='22'){
				
				$("#taskHuid").attr("disabled","disabled"); 
				$("#taskHuid").val(auid); 
				$("#handle").hide();
				$("#taskTimeshow").attr("style","display:block;");
			}else{
				$("#handle").show();
				$("#taskHuid").attr("disabled",false);
				$("#taskTimeshow").attr("style","display:none;");
			}
			
			form.render('select');
		});
		
		form.on('select(rid)', function(data) {
			$.post("index.php?m=crm_index&c=orderprice", {id : data.value, pytoken : pytoken}, function(data) {
				if (data) {
					var dataJson = eval("(" + data + ")");
					$('#order_price').val(dataJson.service_price);
				}
				form.render('select');
			});
		});

		var d = new Date(),
		str = '';
		str += d.getHours() + ':';
		str += d.getMinutes() + ':';
		str += d.getSeconds();

		/*跟进时间*/
		laydate.render({
			elem : '#public_ftime',
			type : 'datetime',
			min	 : -7,
			max	 : str
		});

		form.on('checkbox(follow)', function(data){
			if(data.elem.checked){
				$(".ftime_div").show();
			}else{
				$(".ftime_div").hide();
			}
		});  

		/*下次跟进时间（计划任务时间）*/
		laydate.render({
			elem : '#public_ptime',
			type : 'datetime'
		});
		
		laydate.render({
			elem : '#taskTime',
			type : 'datetime',
			value: new Date()
		});
		laydate.render({
			elem : '#outStime',
			type : 'datetime',
			value: new Date()
		});
		laydate.render({
			elem : '#outEtime',
			type : 'datetime'
		});
	});

	var weburl = "<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
";
	
	$('input[name="crm_keyword"]').keyup(function() {
	
		var pytoken = $('#pytoken').val();
		var comname = $.trim($(this).val());
		
		if (comname == '') {
			$('.layui-anim_al').hide();
			$('input[name="com_uid"]').val('');
		}
		$.ajax({
			url	 : 'index.php?m=crm_index&c=searchcom',
			data : {keyword : comname, pytoken : pytoken},
			type : 'post',
			dataType : 'JSON',
			async : false,
			success : function(data) {
				var html = "";
				if (data) {
					for (var i = 0; i < data.length; i++) {
						html += '<dd lay-value="" class="layui-select-tips"><div class="click_work" data-uid="'+data[i].uid+'">' + data[i].name + '</div></div>';
					}
					$('.layui-anim_all').html(html);
					$('.layui-anim_al').show();
				} else {
					if (comname) {
						html = '<dd lay-value="" class="layui-select-tips"><div class="click_work" >无相关客户</div></div>';
						$('.layui-anim_all').html(html);
						$('.layui-anim_al').show();
						$('input[name="com_uid"]').val('');
					} else {
						$('.layui-anim_al').hide();
						$('input[name="com_uid"]').val('');
					}
				}
			}
		})
	})
	
	$(document).on('click', '.click_work', function() {
		var comuid = $(this).attr('data-uid');
		$('input[name="crm_keyword"]').val($(this).text());
		$('.layui-anim_al').hide();
		$('input[name="com_uid"]').val(comuid);
	})
<?php echo '</script'; ?>
><?php }} ?>
