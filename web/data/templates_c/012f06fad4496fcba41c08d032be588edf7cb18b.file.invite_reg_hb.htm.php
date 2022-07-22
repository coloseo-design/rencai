<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:10:03
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\\member\public\invite_reg_hb.htm" */ ?>
<?php /*%%SmartyHeaderCode:431762d8fbcb64a642-49918004%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '012f06fad4496fcba41c08d032be588edf7cb18b' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\\\member\\public\\invite_reg_hb.htm',
      1 => 1640333832,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '431762d8fbcb64a642-49918004',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d8fbcb677a65_09744975',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d8fbcb677a65_09744975')) {function content_62d8fbcb677a65_09744975($_smarty_tpl) {?><?php echo '<script'; ?>
>
    var weburl = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
';
    var invite_reg_hbids = [];

    function getInviteRegHbList() {
        let lr = false;
        $.ajax({
            type: 'post',
            url: weburl + '/index.php?m=ajax&c=getInviteRegHbList',
            async: false,
            dataType: 'json',
            success: function(res){
                if(res && res.list && res.list.length > 0){
                    res.list.forEach(function (item) {
                        invite_reg_hbids.push(item.id);
                    });

                    lr = true;
                }
            }
        })
        return lr;
    }

    function getInviteRegHb(hb) {
        layer.closeAll();
        let hbNum = invite_reg_hbids.length;

        if(hbNum == 0){
            var lr = this.getInviteRegHbList();
            if(!lr){
                layer.msg("功能无法使用，请联系网站客服", 2, 8)
                return false;
            }
            hbNum = invite_reg_hbids.length; // 重新分配海报数量
        }

        const url = weburl + '/index.php?m=ajax&c=getInviteRegHb&hb=' + invite_reg_hbids[hb];
        if (hb < (parseInt(hbNum) - 1)) {
            var next = hb + 1;
        } else {
            var next = 0;
        }

        const loading = layer.load('生成中...', 0);

        var image = new Image();
        image.src = url;
        image.onload = function() {
            layer.closeAll();

            layer.open({
                type: 1,
                title: false,
                content: '<div class="hb_tc"><img src="' + image.src + '" style="max-width: 100%;"><div class="hb_tc_bth"><a href="javascript:;" onclick="getInviteRegHb(' + next + ');" class="hb_tc_hyz">换一张</a><a href="javascript:;" onclick="downInviteRegHb(' + hb + ');" class="hb_tc_xz">下载海报</a></div></div>',
                area: ['360px', 'auto'],
                offset: '55px',
                closeBtn: 0,
                shadeClose: true
            });
        };
    }

    function downInviteRegHb(hb) {
        const loading = layer.load('下载中...', 0);
        const url   =   weburl + '/index.php?m=ajax&c=getInviteRegHb&hb=' +  + invite_reg_hbids[hb];
        var image = new Image();
        image.src = url;
        image.onload = function() {
            layer.closeAll();
            var a = document.createElement('a');          // 创建一个a节点插入的document
            var event = new MouseEvent('click')           // 模拟鼠标click点击事件
            a.download = 'whb_' +invite_reg_hbids[hb];     // 设置a节点的download属性值
            a.href = url;                                 // 将图片的src赋值给a节点的href
            a.dispatchEvent(event);
        }
    }

<?php echo '</script'; ?>
>
<style>
    .hb_tc_bth{padding:10px 0; text-align: center;}
    .hb_tc_bth .hb_tc_hyz{width:120px;height:40px; line-height: 40px; text-align: center; display: inline-block; background-color: #3478ea;color:#fff;border-radius:3px;color:#fff;}
    .hb_tc_xz{width:120px;height:40px; line-height: 40px; text-align: center; display: inline-block; margin-left: 10px; background-color: #01af67;color:#fff;border-radius:3px;color:#fff;}
    .hb_tc_bth a:hover{color:#fff}
</style><?php }} ?>
