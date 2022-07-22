<?php
/* *
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
*/
class admin_xcx_wx_controller extends adminCommon{
    
    function index_action()
    {
        
        if($_POST['pay_config']){
            
            $wxpay['sy_wxpayappid']		=	trim($_POST['sy_wxpayappid']);
            
            $wxpay['sy_wxappsecret']	=	trim($_POST['sy_wxappsecret']);
            
            $wxpay['sy_wxpaymchid']		=	trim($_POST['sy_wxpaymchid']);
            
            $wxpay['sy_wxpaykey']		=	trim($_POST['sy_wxpaykey']);
            
            $wxpay['sy_wxpem_cert']		=	$_POST['sy_wxpem_cert'];
            
            $wxpay['sy_wxpem_key']		=	$_POST['sy_wxpem_key'];
            
            $wxpay['sy_wxpem_ca']		=	$_POST['sy_wxpem_ca'];
            
            //小程序用
            $wxpay['sy_xcxappid']		=	trim($_POST['sy_xcxappid']);
            
            $wxpay['sy_xcxsecret']		=	trim($_POST['sy_xcxsecret']);
            
            $wxpay['sy_xcxysid']		=	trim($_POST['sy_xcxysid']);
            
            $wxpay['sy_sphid']		    =	trim($_POST['sy_sphid']);
            
            made_web(DATA_PATH.'api/wxpay/wxpay_data.php',ArrayToString($wxpay),'wxpaydata');
            
            $configM  =  $this->MODEL('config');

            $data['sy_xcxappid'] = trim($_POST['sy_xcxappid']);
            $data['sy_wxxcx_iospay']  =  isset($_POST['sy_wxxcx_iospay']) ? 1 : 2;
            $data['sy_xcx_contact']  =  isset($_POST['sy_xcx_contact']) ? 1 : 2;
            $data['sy_xcxQrcode']  =  isset($_POST['sy_xcxQrcode']) ? 1 : 2;
            
			$data['sy_xcxname'] = trim($_POST['sy_xcxname']);

			$data['sy_xcxpath'] = trim($_POST['sy_xcxpath']);


            $configM -> setConfig($data);
            
            $this->web_config();
            
            $this->ACT_layer_msg('微信小程序配置成功！',9,$_SERVER['HTTP_REFERER'],2,1);
        }
        
        @include(DATA_PATH.'api/wxpay/wxpay_data.php');

        if (isset($wxpaydata)){
            $this->yunset('wxpaydata',$wxpaydata);
        }

        $this->yuntpl(array('admin/admin_xcx_wx'));
    }
    
    function getQrcode_action(){
        
        if ($_GET['type']){
            
            $jobM  =  $this->MODEL('job');
            
            $job   =  $jobM->getInfo(array('state'=>1,'status'=>0,'r_status'=>1,'orderby'=>'id,desc'),array('field'=>'`id`'));
            
            if (!empty($job)){
                
                $data  =  array(
                    'type'  =>  $_GET['type'],
                    'id'    =>  $job['id']
                );
                $xcxM    =  $this->MODEL('xcx');
                
                $return  =  $xcxM->getQrcode($data);
                
                echo json_encode($return);die();
            }
        }
    }

}

?>