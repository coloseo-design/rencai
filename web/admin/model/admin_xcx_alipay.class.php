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

class admin_xcx_alipay_controller extends adminCommon
{

    function index_action()
    {

        if ($_POST['pay_config']) {

            $_POST  =   $this->post_trim($_POST);

            $alipay =   array(
                'sy_weburl'     =>  $this->config['sy_weburl'],
                'sy_xcxAppid'   =>  $_POST['sy_xcxAppid'],
                'sy_privateKey' =>  $_POST['sy_privateKey'],
                'sy_publicKey'  =>  $_POST['sy_publicKey']
            );

            made_web(DATA_PATH.'api/alipay/alipay_aop.php', ArrayToString($alipay), 'alipaydata');

            $this->web_config();

            $this->ACT_layer_msg('支付宝小程序配置成功！', 9, $_SERVER['HTTP_REFERER'], 2, 1);
        }

        @include(DATA_PATH.'api/alipay/alipay_aop.php');
        if (isset($alipaydata)) {

            $this->yunset('alipaydata', $alipaydata);
        }

        $this->yuntpl(array('admin/admin_xcx_alipay'));
    }
}

?>