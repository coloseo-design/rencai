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
class fk_controller extends wxapp_controller{
    
    
    function index_action()
    {
        $where['id']  =  intval($_POST['id']);
        if($_POST['from'] != 'once'){
            if ($_POST['uid'] && $_POST['token']){
                $member  =  $this->yztoken($_POST['uid'],$_POST['token']);
                
                $where['uid']  =  $member['uid'];
            }
        }
        
        
        $orderM  =  $this->MODEL('companyorder');
        $order	 =	$orderM->getInfo($where,array('field'=>'`order_state`'));
        
        if(empty($order)){
            $this->render_json(2,'订单不存在');
        }elseif ($order['order_state']==2) {
            $this->render_json(0,'ok');
        }else{
            $this->render_json(1,'未付款');
        }
    }
    /**
     * 小程序付款
     */
    function xcxfk_action()
    {
        // 非店铺招聘付款要判断登录状态
        if(!(isset($_POST['fr']) && $_POST['fr'] == 'once')){
            $member = $this->yzToken($_POST['uid'],$_POST['token']);
        }
        $code    =  trim($_POST['code']);
        $id      =  intval($_POST['id']);
        
        $result  =  array();
        if (!empty($code)){
            
            $getdata	=	$this->getOpenid($code);
            
            if($getdata['openid']){
                
                $orderM	 	=  	$this->MODEL('companyorder');
                $order		=	$orderM->getInfo(array('id'=>$id),array('field'=>'`id`,`order_type`,`order_id`,`order_price`'));
               
                if (!empty($order)){
					 $orderM -> upInfo($id, array('port' => '3'));
                    // 跨端支付，生成新订单
                    if($order['order_type'] == 'wxpay' || $order['order_type'] == 'wxh5'){
                        
                        $order  =	$orderM -> wxPayChange($order['id'], array('paytype'=>'wxxcx'));
                    }
                    
                    require_once(LIB_PATH.'wxOrder.function.php');
                    
                    $result  =  wxXcxOrder(array('body'=>'充值','id'=>$order['order_id'],'url'=>$this->config['sy_weburl'],'total_fee'=>$order['order_price'],'openid'=>$getdata['openid']));
                    $msg	 =	'ok';
                }else{
                    
                    $msg	=	'没有该订单';
                }
            }else{
                if ($getdata['errcode']){
                    $msg	=	'微信小程序配置错误';
                    $this->MODEL('errlog')->addErrorLog($member['uid'], 10, '微信小程序付款获取openid错误。code:'.$_POST['code'].'。'.$getdata['errcode'].'，'.$getdata['errmsg']);
                }else{
                    $msg	=	'参数错误';
                }
            }
        }else{
            $msg	=	'微信登录状态获取失败';
        }
        
        $this->render_json(0,$msg,$result);
    }
    /**
     * app付款链接
     */
    function mfk_action()
    {
        if($_POST['from']!='once'){
            if($_POST['uid'] && $_POST['token']){
                $member = $this->yzToken($_POST['uid'],$_POST['token']);
            }
        }
        $orderM	=  	$this->MODEL('companyorder');
        $id		=  intval($_POST['id']);
		$orderM -> upInfo($id, array('port' => '4'));
        if ($_POST['fktype'] == 'fkwx'){
            
            $data  =  $this->wxpay($id);
            
        }elseif ($_POST['fktype'] == 'fkal'){
            
            $orderM	 	=  	$this->MODEL('companyorder');
            $order		=	$orderM->getInfo(array('id'=>$id),array('field'=>'`order_id`,`order_price`'));
            
            $data['url']  =  $this->config['sy_weburl'].'/api/wapalipay/alipayto.php?dingdan='.$order['order_id'].'&token='.$_POST['token'].'&uid='.$member['uid'];


        }
        $data['id'] =   $id;
        $this->render_json(0, 'ok', $data);
    }
    /**
     * 百度小程序付款
     */
    function baidufk_action(){
        // 非店铺招聘付款要判断登录状态
        if(!(isset($_POST['fr']) && $_POST['fr'] == 'once')){
            $member = $this->yzToken($_POST['uid'],$_POST['token']);
        }
        $id       =  intval($_POST['id']);
        $result   =  array();
        
        $orderM	  =  $this->MODEL('companyorder');
        $order	  =  $orderM->getInfo(array('id'=>$id),array('field'=>'`id`,`order_type`,`order_id`,`order_price`'));
        
        if (!empty($order)){
            $orderM -> upInfo($id, array('port' => '3'));
            require_once(APP_PATH.'api/baiduPay/baiduPay.php');
            
            $result  = baiduOrder(array('tpOrderId'=>$order['order_id'],'totalAmount'=>$order['order_price']));
            $msg	 =	'ok';
        }else{
            
            $msg	=	'没有该订单';
        }
        
        $this->render_json(0,$msg,$result);
    }
    /**
     * 支付宝小程序付款
     */
    function zfbfk_action()
    {
        // 非店铺招聘付款要判断登录状态
        if(!(isset($_POST['fr']) && $_POST['fr'] == 'once')){
            $member = $this->yzToken($_POST['uid'],$_POST['token']);
        }
        $id       =  intval($_POST['id']);
        $result   =  array();
        
        $orderM	  =  $this->MODEL('companyorder');
        $order	  =  $orderM->getInfo(array('id'=>$id),array('field'=>'`id`,`order_type`,`order_id`,`order_price`'));
        
        if (!empty($order)){
            $orderM -> upInfo($id, array('port' => '3'));
            require_once(APP_PATH.'api/aop/AopToYun.php');
            $mini    =  new AlipayMini();
            $result  =  $mini->alipay(array('id'=>$order['order_id'],'total_amount'=>$order['order_price'],'subject'=>'充值','code'=>$_POST['zfbcode']));
            
            if ($result['msg']){
                $msg  =  $result['msg'];
            }else{
                $msg  =  'ok';
            }
        }else{
            
            $msg	=	'没有该订单';
        }
        
        $this->render_json(0,$msg,$result);
    }
    /**
     * 头条小程序付款
     */
    function toutiaofk_action(){
        // 非店铺招聘付款要判断登录状态
        if(!(isset($_POST['fr']) && $_POST['fr'] == 'once')){
            $member = $this->yzToken($_POST['uid'],$_POST['token']);
        }
        $id       =  intval($_POST['id']);
        $result   =  array();
        
        $orderM	  =  $this->MODEL('companyorder');
        $order	  =  $orderM->getInfo(array('id'=>$id),array('field'=>'`id`,`order_type`,`order_id`,`order_price`'));
        
        if (!empty($order)){
            $orderM -> upInfo($id, array('port' => '3'));
            require_once(APP_PATH.'api/bytedance/ecpay.php');
            $ecpay = new ecpay();
            $res = $ecpay->create_order(array('body'=>'充值','out_order_no'=>$order['order_id'],'notify_url'=>$this->config['sy_weburl'].'/api/bytedance/notify.php','total_amount'=>$order['order_price']));
            
            if ($res['err_no'] == 0){
                $this->render_json(0,'ok',$res['data']);
            }else{
                $this->render_json(-1, $res['err_no'].'，'.$res['err_tips']);
            }
        }else{
            $this->render_json(-1, '没有该订单');
        }
    }
}
?>