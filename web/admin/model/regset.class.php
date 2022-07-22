<?php

/*
 * $Author ：PHPYUN开发团队
 *
 * 官网: http://www.phpyun.com
 *
 * 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
 *
 * 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */
class regset_controller extends adminCommon
{

    function index_action()
    {
        $Coupon = $this->MODEL('coupon');
        
        $rows = $Coupon->getList();
        
        $this->yunset("rows", $rows);
        
        $this->yunset("config", $this->config);
        
        $this->yuntpl(array('admin/admin_regset'));
    }

    // 保存
    function save_action()
    {
        if ($_POST['config']) {
            
            unset($_POST['config']);
            unset($_POST['pytoken']);
            
            $configM = $this->MODEL('config');
            
            $configM->setConfig($_POST);
            
            $this->web_config();
            
            $this->layer_msg("注册设置成功！", 9, 1);
        }
    }
}
?>