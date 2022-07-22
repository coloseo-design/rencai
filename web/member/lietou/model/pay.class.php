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
class pay_controller extends lietou
{

	function index_action(){
		$orderM		=	$this->MODEL('companyorder');
		
		$nopayorder	=	$orderM->getCompanyOrderNum(array('uid'=>$this->uid,'usertype' => $this->usertype, 'order_state'=>1));
		
		$this->yunset('nopayorder',$nopayorder);
        $this->public_action();
        $arr        =   $this->MODEL('cache')->GetCache(array('integralclass'));

        $fkey       =   0;
        $class_price=   array();
        foreach ($arr['integralclass_index'] as $k => $v) {
            $arr['integralclass_index'][$k]['val']  =   (int)$v;
            $discount               =   100;
            if ($arr['integralclass_discount'][$v] > 0) {
                $discount           =   $arr['integralclass_discount'][$v];
            }
            $class_price[$v]        =   round($arr['integralclass_name'][$v] / $this->config['integral_proportion'] * $discount / 100, 2);
            $num    =   (int)$arr['integralclass_name'][$v];
            if ($num >= $this->config['integral_min_recharge']) {
                if ($fkey == 0) {
                    $fkey   =   $k + 1;
                }
            }
        }
        if ($fkey != 0) {

            $arr['first']           =   $arr['integralclass_index'][$fkey - 1];
            $arr['firstprice']      =   $class_price[$arr['integralclass_index'][$fkey - 1]];
            $arr['firstjf']         =   $arr['integralclass_name'][$arr['integralclass_index'][$fkey - 1]];
        }
        $this->yunset($arr);
		$this->yunset("class","21");
		$this->lietou_tpl('pay');
	}
	
	function dingdan_action(){

	    $data['price']			=	$_POST['price'];
	    $data['comvip']			=	$_POST['comvip'];
	    $data['comservice']		=	$_POST['comservice'];
	    $data['price_int']		=	$_POST['price_int'];
	    $data['integralid']		=	$_POST['integralid'];
	    $data['order_remark']	=	$_POST['remark'];
	    $data['uid']			=	$this->uid;
	    $data['usertype']		=	$this->usertype;
	    $data['did']			=	$this->userdid;
	    $orderM	=	$this	->	MODEL('companyorder');
	    $return	=	$orderM	->	addComOrder($data);
	    $this	->	ACT_layer_msg($return['msg'],$return['errcode'],$return['url']);
	}


	function dkzf_action(){
		$M	=	$this->MODEL('jfdk');
		if($_POST){
			if($_POST['id']){
				$return = $M->buyVip(array('id'=>$_POST['id'], 'orderid'=>$_POST['orderid'], 'uid'=>$this->uid, 'username' => $this->username,'usertype'=>3));				
			}
			if($return['status']==1){
				//积分抵扣，购买成功
				echo json_encode(array('error'=>0,'msg'=>$return['msg']));
			}else{
				//积分抵扣，失败 返回具体原因
				echo json_encode(array('error'=>1,'msg'=>$return['error'],'url'=>$return['url']));
			}
		}else{
			echo json_encode(array('error'=>1,'msg'=>'参数错误，请重试！'));
		}
	}
}
?>