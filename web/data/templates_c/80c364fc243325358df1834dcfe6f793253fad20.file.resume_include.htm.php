<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-22 10:13:55
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\\resume\resume_include.htm" */ ?>
<?php /*%%SmartyHeaderCode:2647762da07e35cebd0-99155887%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '80c364fc243325358df1834dcfe6f793253fad20' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\\\resume\\resume_include.htm',
      1 => 1637140097,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2647762da07e35cebd0-99155887',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'company_job' => 0,
    'v' => 0,
    'ymlist' => 0,
    'yv' => 0,
    'ymcan' => 0,
    'Info' => 0,
    'uid' => 0,
    'config' => 0,
    'usertype' => 0,
    'eid' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62da07e364b729_25842715',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62da07e364b729_25842715')) {function content_62da07e364b729_25842715($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
?><div id='job_box' class="none" style="float:left">
    <div class="r_Interview" style="z-index:11">
        <span class="Interview_span">面试职位</span>
        <div class="Interview_text_box">
            <input type="button" value="请选择面试职位" class="Interview_text_box_t" id="name" onClick="search_show('job_name');" />
            <input type="hidden" id="nameid" name="name" value='' />
            <div class="Interview_text_box_list none" id="job_name">
                <ul>
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['company_job']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                    <li>
                        <a href="javascript:;" onclick="selecteInviteJob('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
', 'name', '<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['link_man'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['link_moblie'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['address'];?>
');"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <!--切换使用模板-->
    <?php if (!empty($_smarty_tpl->tpl_vars['ymlist']->value)) {?>
    <div class="r_Interview" style="z-index:10">
        <span class="Interview_span">选择面试模板</span>
        <div class="Interview_text_box">
            <input type="button" value="请选择面试模板" class="Interview_text_box_t" id="mbname" onClick="search_show('mb_name');" />
            <input type="hidden" id="ymid" name="ymid" value='' />
            <div class="Interview_text_box_list none" id="mb_name">
                <ul>
                    <?php  $_smarty_tpl->tpl_vars['yv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['yv']->_loop = false;
 $_smarty_tpl->tpl_vars['yk'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ymlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['yv']->key => $_smarty_tpl->tpl_vars['yv']->value) {
$_smarty_tpl->tpl_vars['yv']->_loop = true;
 $_smarty_tpl->tpl_vars['yk']->value = $_smarty_tpl->tpl_vars['yv']->key;
?>
                    <li>
                        <a href="javascript:;" onclick="selecteYqmb('<?php echo $_smarty_tpl->tpl_vars['yv']->value['linkman'];?>
','<?php echo $_smarty_tpl->tpl_vars['yv']->value['linktel'];?>
', '<?php echo $_smarty_tpl->tpl_vars['yv']->value['address'];?>
','<?php echo $_smarty_tpl->tpl_vars['yv']->value['intertime'];?>
','<?php echo $_smarty_tpl->tpl_vars['yv']->value['content'];?>
','<?php echo $_smarty_tpl->tpl_vars['yv']->value['name'];?>
','<?php echo $_smarty_tpl->tpl_vars['yv']->value['id'];?>
');"><?php echo $_smarty_tpl->tpl_vars['yv']->value['name'];?>
</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <?php }?>
    <div class="r_Interview" style="z-index:9"><span class="Interview_span">联系人</span><input size='5' id='linkman' value='' class="Interview_text" /></div>
    <div class="r_Interview"><span class="Interview_span">联系电话</span><input size='19' id='linktel' value='' class="Interview_text" /></div>
    <div class="r_Interview"><span class="Interview_span">面试时间</span><input size='40' id='intertime' value='' class="Interview_text" placeholder="请选择面试时间"  autocomplete="off" /></div>
    <div class="r_Interview"><span class="Interview_span">面试地址</span><input size='40' id='address' value='' class="Interview_text" /></div>
    <div class="r_Interview"><span class="Interview_span">面试备注</span><textarea id="content" cols="40" rows="5" class="Interview_textarea_text"></textarea></div>
    
    <div id="ymctrl" class="r_Interview <?php if (!$_smarty_tpl->tpl_vars['ymcan']->value) {?>none<?php }?>">
        <form  method="post" action=""  class="layui-form">
            <input type="checkbox" id="save_yqmb" name="save_yqmb" title="保存面试模板"  value="1" lay-filter="save_yqmb" lay-skin="primary" />
        </form>
    </div>  
    
    <div class="r_Interview " style="padding-bottom:20px;"><span class="Interview_span">&nbsp;</span>
        <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['uid'];?>
" id="uid" />
		<?php if ($_smarty_tpl->tpl_vars['uid']->value) {?>
        <input type="hidden" id="username" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['name'];?>
" />
		<?php }?>
        <input class="resume_sub_yq" id="click_invite" type="button" value="邀请面试" />
    </div>
    <?php echo '<script'; ?>
>
        $(function(){

            
            layui.use(['form','laydate'], function() {
                var $ = layui.$,
                    form = layui.form,
                    laydate = layui.laydate;
               

            });
        })
    <?php echo '</script'; ?>
>
</div>

<div id="talent_pool_beizhu" class="none">
    <div class="resume_beizu" style="margin-left:18px; margin-top:18px;">
        <textarea id="remark" cols="40" rows="5" class="resume_beizu_text" style="width:340px;height:90px;border:1px solid #ddd"></textarea>
    </div>
    <div style="text-align:center; padding:10px 0;">
        <input type="button" value="保存" onClick="talent_pool('<?php echo $_smarty_tpl->tpl_vars['Info']->value['uid'];?>
','<?php echo $_smarty_tpl->tpl_vars['Info']->value['id'];?>
','<?php echo smarty_function_url(array('m'=>'ajax','c'=>'talent_pool'),$_smarty_tpl);?>
')" class="resume_beizu_bth" />
    </div>
</div>

<?php echo '<script'; ?>
>
    var ymcan = '<?php echo $_smarty_tpl->tpl_vars['ymcan']->value;?>
';
    var weburl="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
";
    function selecteYqmb(man,tel,address,intertime,content,name,id){
        
        $("#ymid").val(id);
        $("#linkman").val(man);
        $("#linktel").val(tel);
        $("#address").val(address);
        $("#content").val(content);
        $("#intertime").val(intertime);
        $('#mbname').val(name);

        
        $('#ymctrl').removeClass('none');
        $('#save_yqmb').attr('title','更新面试模板')

        $('#save_yqmb').prop("checked", false);
        
        layui.use(['form', 'layer'], function() {
            var $ = layui.$,
                form = layui.form,
                layer = layui.layer;
            form.render();

        });

        $("#mb_name").hide();
    }
    function search_show(id) {
        $("#" + id).show();
    }
    function selecteInviteJob(id, type, name, man, tel, address) {
        $("#job_" + type).hide();
        $("#" + type).val(name);
        $("#" + type + "id").val(id);
        if(man && tel){
            $("#linkman").val(man);
            $("#linktel").val(tel);
            $("#address").val(address);
        }
    }
    
	$(function(){

        $('#intertime').datetimepicker({
            format:'Y-m-d H:i',
            step:10
        });
        $.datetimepicker.setLocale('zh');
        
		$('body').click(function(evt) {
            if($(evt.target).parents("#name").length == 0 && evt.target.id != "name") {
                $('#job_name').hide();
            }
            if($(evt.target).parents("#mbname").length == 0 && evt.target.id != "mbname") {
                $("#mb_name").hide();
            }
        });
        
	})
    var height = "300px";
    function onResume_invite() {
        $.layer({
            type: 1,
            title: '邀请面试',
            closeBtn: [0, true],
            border: [10, 0.3, '#000', true],
            area: ['480px', height],
            page: {
                dom: '#invite_server'
            }
        });
    }
 
	$(function(){
		'<?php if ($_smarty_tpl->tpl_vars['usertype']->value==2||$_smarty_tpl->tpl_vars['usertype']->value==3) {?>'
			var eid = '<?php echo $_smarty_tpl->tpl_vars['eid']->value;?>
';
			$.post(weburl+'/index.php?m=resume&c=show&a=history',{eid:eid},function(data){
				if(data){
					return true;			
				}
			})
		'<?php }?>'
	}); 
<?php echo '</script'; ?>
><?php }} ?>
