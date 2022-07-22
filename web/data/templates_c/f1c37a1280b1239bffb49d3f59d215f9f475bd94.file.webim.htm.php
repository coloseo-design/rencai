<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:10:03
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\\chat\webim.htm" */ ?>
<?php /*%%SmartyHeaderCode:1987562d8fbcb3640c6-40687955%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f1c37a1280b1239bffb49d3f59d215f9f475bd94' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\\\chat\\webim.htm',
      1 => 1634883833,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1987562d8fbcb3640c6-40687955',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'uid' => 0,
    'usertype' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d8fbcb3feee9_31360297',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d8fbcb3feee9_31360297')) {function content_62d8fbcb3feee9_31360297($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['config']->value['sy_chat_open']==1) {?>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/app/template/chat/yunliao/chat.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
>var spWait = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_spview_wait'];?>
';<?php echo '</script'; ?>
>
	<?php if ($_GET['c']!='chat') {?>
		<?php echo '<script'; ?>
 type="text/javascript">
			var socketUrl = "<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_chat_weburl'];?>
",
				weburl = "<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
",
				toid = '',
				mine = {id:'<?php echo $_smarty_tpl->tpl_vars['uid']->value;?>
',usertype: '<?php echo $_smarty_tpl->tpl_vars['usertype']->value;?>
'},
				chat_name = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_chat_name'];?>
';
				getUnread();
				
			function getUnread(){
				if(typeof memberMsgnum === 'undefined'){
					// 避免重复查询
					$.get(weburl+"/index.php?m=ajax&c=msgNum",function(data){ 
						var datas=eval("(" + data + ")");
						if(datas.chatNum){
							$('#memberNoChat').addClass('none');
							$('#memberHaveChat').removeClass('none');
							$('#memberChatNum').text(datas.chatNum);

							if (typeof(newChatMsg) != "undefined") {
								newChatMsg = true;
							}
						}else{
							$('#memberNoChat').removeClass('none');
							$('#memberHaveChat').addClass('none');
							$('#memberChatNum').text('');
							
						}
					})
				}
			}
		<?php echo '</script'; ?>
>
		<?php if ($_smarty_tpl->tpl_vars['uid']->value&&$_smarty_tpl->tpl_vars['usertype']->value) {?>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/app/template/chat/yunliao/websocket.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<div id="memberNoChat" class="chat_box" onclick="goChat()">
			<div class="chat_box_c"><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_chat_logo'];?>
"> <span><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_chat_name'];?>
</span></div>
		</div>
        <div id="memberHaveChat" class="chat_box chat_box_news none" onclick="goChat()">
            <div class="chat_box_c"><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_chat_logo'];?>
"> <span> 有新消息<span id="memberChatNum" class="chat_n"></span></span></div>
		</div>
		<div id="zwf" class="none">【&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;】</div>
		<style>
		.chat_box{width:160px;height:50px; line-height:50px; position:fixed;right:0px;bottom:0px;border-radius: 2px;box-shadow: 1px 1px 50px rgba(0,0,0,.3); background:#fff ; cursor:pointer; z-index:100000000;}
		.chat_box_c{padding-left:50px; position:relative}
		.chat_box img{width:30px;height:30px; position:absolute;left:10px;top:10px; }
		.chat_box_news img{animation: rotate 1s infinite; -moz-animation: rotate 1s infinite;; -ms-animation: rotate 1s infinite; -o-animation: rotate 1s infinite; -webkit-animation: rotate 1s ease-in  infinite ;}
		@keyframes rotate {
		0% { opacity:0 ;}
		100% {opacity:1;}
		}
		.chat_n{font-size: 12px;background: red;color: #fff;border: none;border-radius: 15px;line-height: 16px;padding: 0 5px; margin-left:10px;}
		.chat_box_news{ background:#fff;}
		</style>
		<?php }?>
	<?php }?>
<?php }?><?php }} ?>
