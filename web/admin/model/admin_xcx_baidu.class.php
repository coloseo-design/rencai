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
class admin_xcx_baidu_controller extends adminCommon
{

    function index_action()
    {

        if ($_POST['pay_config']) {

            $_POST  =   $this->post_trim($_POST);

            $str    =   str_replace("\r\n", '', $_POST['sy_privateKey']);

            $baidu  =   array(

                'sy_appKey'     =>  $_POST['sy_appKey'],
                'sy_dealId'     =>  $_POST['sy_dealId'],
                'sy_privateKey' =>  str_replace(PHP_EOL, '', $str),
                'sy_publicKey'  =>  $_POST['sy_publicKey'],
                'sy_baidu_iospay' => isset($_POST['sy_baidu_iospay']) ? 1 : 2
            );
            foreach ($baidu as $v) {
                if (empty($v)) {
                    $this->ACT_layer_msg('请将参数配置齐', 8);
                }
            }
            $baidu['sy_bdlogin_appKey'] =  $_POST['sy_bdlogin_appKey'];
            $baidu['sy_bdlogin_appSecret'] =  $_POST['sy_bdlogin_appSecret'];

            made_web(DATA_PATH . 'api/baidu/baidu_data.php', ArrayToString($baidu), 'baiduData');

            unset($baidu['sy_weburl']);

            $configM    =   $this->MODEL('config');
            $configM->setConfig($baidu);

            $this->web_config();

            $this->ACT_layer_msg('百度小程序配置成功！', 9, $_SERVER['HTTP_REFERER'], 2, 1);
        }

        @include(DATA_PATH . 'api/baidu/baidu_data.php');
        if (isset($baiduData)) {

            $this->yunset('baiduData', $baiduData);
        }

        $this->yuntpl(array('admin/admin_xcx_baidu'));
    }

    function makeCache_action()
    {

        $wxAppM =   $this->MODEL('wxapp');
        $wxAppM->makeBaiduCache();
    }
}

?>