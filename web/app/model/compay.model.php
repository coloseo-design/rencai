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
class compay_model extends model{


    public $onlyPrice  =  array();

    /**
     * @desc   引用statis类，获取账户套餐数据信息
     */
    private function getStatisInfo($uid, $data = array()) {
        require_once ('statis.model.php');
        $StatisM = new statis_model($this->db, $this->def);
        return  $StatisM -> getInfo($uid , $data);
    }
    
    /**
     * @desc 更新优惠券使用状态
     */
    private function upCouponList($where = array(), $data = array()){
        require_once 'coupon.model.php';
        $couponM    =   new coupon_model($this->db, $this->def);
        return $couponM -> upCouponList($where, $data, array());        
    }

    /**
     * @desc 订单生成
     * @param array $data
     * @return bool
     */
    private function addOrder($data = array()){
        require_once 'companyorder.model.php';
        $orderM     =   new companyorder_model($this->db, $this->def);
        return $orderM -> addOrder($data);
    }
    
    function orderBuy($data = array())
    {
        if ($data['uid']){
            
            if($data['usertype']==2){
                $single_can = @explode(',', $this->config['com_single_can']);
            }else{
                $single_can = @explode(',', $this->config['lt_single_can']);
            }

            $this->onlyPrice =  @explode(',', $this->config['sy_only_price']);

            if($data['server']!='vip' && $data['server']!='pack' && $data['server']!='autojob'){

                $serverCheck = $data['server'];
                if($data['server']=='sxltjob'||$data['server']=='sxpart'||$data['server']=='sxjob'){
                    $serverCheck = 'sxjob';
                }
                if($data['server']=='partrec'){
                    $serverCheck = 'jobrec';
                }
                $singleServer	=	array('issuejob','jobtop','jobrec','joburgent','sxjob','downresume','invite','zph','createson','chat','zphnet','spview');
                if($serverCheck && in_array($serverCheck,$singleServer) && !in_array($serverCheck,$single_can)){
                      return  array(
                        'error' => 1,
                        'msg'   => '该服务已关闭单项购买，请选择其它购买方式'
                    );
                }
            }

            if ($data['usertype'] == 2 && !$data['crm_uid']){
                $comInfo    =   $this->select_once('company',array('uid' => $data['uid']), '`crm_uid`');
                if (!empty($comInfo) && $comInfo['crm_uid'] > 0){
                    $data['crm_uid']    =   $comInfo['crm_uid'];
                }
            }

            if ($data['server'] == 'autojob') {
                
                $return  =  $this->buyAutoJob($data);
            } elseif ($data['server'] == 'jobtop') {
                
                $return  =  $this->buyZdJob($data);
            } elseif ($data['server'] == 'jobrec') {
                
                $return  =  $this->buyRecJob($data);
            } elseif ($data['server'] == 'joburgent') {
                
                $return  =  $this->buyUrgentJob($data);
            } elseif ($data['server'] == 'sxjob') {
                
                $return  =  $this->buyRefreshJob($data);
            } elseif ($data['server'] == 'sxltjob') {
                
                $return  =  $this->buyRefreshLtJob($data);
            } elseif ($data['server'] == 'downresume') {
                
                $return	=	$this->buyDownresume($data);
            } elseif ($data['server']=='issuejob') {
                
                $return  =  $this->buyIssueJob($data);
            } elseif ($data['server'] == 'invite') {
                
                $return  =  $this->buyInviteResume($data);
            } elseif ($data['server'] == 'pack') {
                
                $return  =  $this->buyPackOrder($data);
            } elseif ($data['server'] == 'vip') {
                
                $return  =  $this->buyVip($data);
            } elseif ($data['server'] == 'sxpart') {
                
                $return  =  $this->buyRefreshPart($data);
            } elseif ($data['server'] == 'partrec') {
                
                $return  =  $this->buyRecPart($data);
            } elseif ($data['server'] == 'createson') {
                
                $return  =  $this->buyCreateSon($data);
            } elseif ($data['server'] == 'zph') {
                
                $return  =  $this->buyZph($data);
            } elseif ($data['server'] == 'chat') {
                
                $return  =  $this->buyChat($data);
            }elseif ($data['server'] == 'spview') {
                
                $return  =  $this->buySpview($data);
            } elseif ($data['server'] == 'zphnet') {
                
                $return  =  $this->buyZphnet($data);
            }elseif ($data['server']=='rewardjob'){

				include_once('pack.model.php');
				$packM  =  new pack_model($this->db,$this->def);
				$return =	$packM -> rewardPackOrder($data);
				$msg	=	"悬赏职位推广";
			}elseif ($data['server']=='sharejob'){
				
				include_once('pack.model.php');
				$packM  =  new pack_model($this->db,$this->def);
				$return =	$packM -> redPackOrder($data);
				$msg	=	"分享职位推广";
			}
            if ($return['order']['order_id'] && $return['order']['id']) {
                
                // 订单生成成功
                $return = array(
                    'error'        =>  0,
                    'orderid'      =>  $return['order']['order_id'],
                    'id'           =>  $return['order']['id'],
                    'order_price'  =>  $return['order']['order_price']
                );
            } else {
                // 生成失败 返回具体原因
                $return = array(
                    'error' => 1,
                    'msg' => $return['error']
                );
            }
        }else{
            $return = array(
                'error' => 1,
                'msg'   => '请先登录'
            );
        }
        return $return;
    }
    /**
     * @desc    生成订单购买会员套餐处理（包含积分充值购买）
     * @param   $data
     * @return  $return
     */
    function buyVip($data){
        
        $uid        =   intval($data['uid']);
        $usertype   =   intval($data['usertype']);
        $username   =   trim($data['username']);
        $did        =   $data['did'] ? $data['did'] : $this -> config['did'];
        
        $return     =   array();

        $data['dkjf'] = $data['dkjf']>0 ? $data['dkjf'] : 0;

        if($data['ratingid']){
            
            $ratingId   =   intval($data['ratingid']);
            
            $paytype    =   $data['paytype'] ? $data['paytype'] : '';
            
            $couponid   =   intval($data['coupon_id']);
            
            $rating     =   $this -> select_once('company_rating',array('id' => $ratingId)); // 会员套餐详情
            
            $statis     =   $this -> getStatisInfo($uid, array('usertype' => $usertype, 'field'=>'`integral`'));
            
            if($rating['time_start'] < time() && $rating['time_end'] > time()){
                
                $price	=  $rating['yh_price'];
            }else{
                
                $price	=  $rating['service_price'];
            }
            
            /* 优惠券额度优先扣除 */
            $couponWhere=   array(
              
                'id'            =>  $couponid,
                'uid'           =>  $uid,
                'status'        =>  1,
                'validity'      =>  array('>', time()),
                'coupon_amount' =>  array('<', $price),
                'coupon_scope'  =>  array('<=', $price)
            );
            
            $coupon     =   $this->select_once('coupon_list', $couponWhere);
            
            if ($coupon && is_array($coupon)) {
                
                $price -= $coupon['coupon_amount'];

                $price  =   sprintf("%.2f", $price);            //  扣除优惠券额度后
            }

            if (!in_array('vip', $this->onlyPrice)) {

                if ($this->config['com_integral_online'] == 1) {

                    $dkjf   =   $data['dkjf'] ? intval($data['dkjf']) : '';         //  抵扣积分

                } elseif ($this->config['com_integral_online'] == 3) {

                    $jifen  =   !empty($data['price_int']) ? intval($data['price_int']) : '';   //  充值积分
                }
            }
            
            if ($dkjf) {
                
                $dkjf   =	$dkjf >= intval($statis['integral']) ? $statis['integral'] : $dkjf;
                $price  =   $price - $dkjf / $this->config['integral_proportion'];
            }
            
            if (!empty($jifen)) {
                
                $vip_integral   =   $price * $this->config['integral_proportion'];  //  会员套餐所需积分
                $integral_min   =   $this -> config['integral_min_recharge'];       //  站点最低充值积分
                
                if (($jifen + intval($statis['integral'])) <  intval($vip_integral)) {
                    
                    $return['error']    =   '充值'.$this->config['integral_pricename'].'不足购买会员套餐，请重新输入'.$this->config['integral_pricename'].'数量！';
                    return $return;
                }else if ($jifen < intval($integral_min)) {
                    
                    $return['error']    =   '最低充值'.$this->config['integral_pricename'].'不低于'.$integral_min;
                    return $return;
                }
                
                $price  =   $jifen  /  $this->config['integral_proportion'];
                
            }
            
            $price      =   sprintf("%.2f", $price);
            
            if($price > 0){
 
                if(empty($rating)){
                    
                    $return['error']    =   '请选择正确的会员套餐！';
                    
                }else {
                    
                    $dingdan                    =   time().rand(10000,99999);
                    $orderData                  =   array();
                    $orderData['type']          =   '1';
                    $orderData['order_id']      =   $dingdan;
                    $orderData['order_price']   =   $price;
                    $orderData['integral']		=	$jifen ? $jifen : '';
                    $orderData['coupon']		=	$couponid ? $couponid : '';
                    $orderData['order_time']    =   time();
                    $orderData['order_type']    =   $paytype;
                    $orderData['order_state']   =   1;
                    $orderData['rating']        =   $ratingId;
                    
                    $orderData['order_remark']  .=   $jifen ? '充值'.$this->config['integral_pricename'].'购买会员' : '购买会员';
                    
                    $orderData['order_remark']	.=	$dkjf ? ', '.$this->config['integral_pricename'].'抵扣金额'.round(($dkjf / $this->config['integral_proportion']), 2).'元' : '';
                    
                    $orderData['order_remark']	.=	$coupon ? ', 使用优惠券'.$coupon['coupon_amount'].'元' : '';
                    
                    $orderData['uid']           =   $uid;
					$orderData['usertype']      =   $usertype;
                    $orderData['did']           =   $did;
                    $orderData['order_dkjf']    =   $dkjf ? $dkjf : '';
                    if ($data['crm_uid']){
                        $orderData['crm_uid']   =   $data['crm_uid'];
                    }
                    
                    if($jifen){
                        $orderData['order_info']=	serialize(array('ratingid'=>$ratingId,'vip_integral' => $vip_integral,'uid'=>$uid));
                    }
                    
					$id     =   $this -> addOrder($orderData);
                    
                    if ($id) {
                        
                        require_once('integral.model.php');
                        
                        $integral   =   new integral_model($this->db,$this->def,array('uid'=>$uid,'username'=>$username,'usertype'=>$usertype));
                        

					 
                        if ($coupon) {  //  更改优惠券使用状态
                            $this -> upCouponList(array('id' => $couponid, 'uid' => $uid), array('status' => 2, 'xf_time'=>time()));   //  更新优惠券状态 2 已使用
                            $integral -> company_invtal($uid, $usertype, $coupon['coupon_amount'], false, '购买会员，使用优惠券', true, 2, 'yhq', 12, '', $couponid);
                        }
                        
                        if($dkjf){
                            $integral -> company_invtal($uid, $usertype, $dkjf, false, '购买会员，使用'.$this->config['integral_pricename'].'抵扣', true, 2, 'integral', 12);
                        } 
                        
                        $orderData['id']    =   $id;
                        $return['order']    =   $orderData;

						 
                    }else{
                        
                        $return['error'] = '订单生成失败！';
                    }
                }
            }else{
                
                $return['error'] = '套餐金额出错！';
            }
        }else{
            
            $return['error'] = '参数错误，请重新选择！';
        }
        return $return;
    }
    
    /**
     * @desc    购买增值服务（包含积分充值购买）
     * @param   array $data
     * @return  array $return
     */
    function buyPackOrder($data){
        
         
        $uid        =   intval($data['uid']);
        $usertype   =   intval($data['usertype']);
        $username   =   trim($data['username']);
        $did        =   $data['did'] ? $data['did'] : $this -> config['did'];
        
         
        $return     =   array();

		$data['dkjf'] = $data['dkjf']>0 ? $data['dkjf'] : 0;

        if($data['tcid']){
            
            $tid        =   intval($data['tcid']);
            
            $couponid   =   intval($data['coupon_id']);
            
            $paytype    =   $data['paytype'] ? $data['paytype'] : '';


            if (!in_array('pack', $this->onlyPrice)) {
                if ($this->config['com_integral_online'] == 1) {

                    $dkjf   =   $data['dkjf'] ? intval($data['dkjf']) : '';         //  抵扣积分

                } elseif ($this->config['com_integral_online'] == 3) {

                    $jifen  =   $data['price_int'] ? intval($data['price_int']) : ''; // 充值积分
                }
            }
            $tb_service =   $usertype == 2 ? 'company_service_detail' : 'lt_service_detail' ;
            
            $service    =   $this -> select_once($tb_service, array('id' => $tid), '`id`,`service_price`');

            $statis     =   $this -> getStatisInfo($uid,array('usertype' => $usertype, 'field'=>'`integral`, `rating`'));
           
            $rating     =   $this -> select_once('company_rating',array('id' => $statis['rating']), '`service_discount`');  //增值服务折扣
            
            if($rating['service_discount']){
                
                $discount   =   intval($rating['service_discount']);
                $price      =   floatval($service['service_price'] * $discount * 0.01) ;
               
            }else{
                
                $price      =   $service['service_price'];
            }
            
            /* 优惠券额度优先扣除 */
            $couponWhere=   array(
                
                'id'            =>  $couponid,
                'uid'           =>  $uid,
                'status'        =>  1,
                'validity'      =>  array('>', time()),
                'coupon_amount' =>  array('<', $price),
                'coupon_scope'  =>  array('<=', $price)
            );
            
            $coupon     =   $this->select_once('coupon_list', $couponWhere);
            
            if ($coupon && is_array($coupon)) {
                
                $price  =   $price - $coupon['coupon_amount'];            //  扣除优惠券额度后
            }
            
            if (isset($dkjf)) {
                
                $dkjf   =	$dkjf >= intval($statis['integral']) ? $statis['integral'] : $dkjf;
                $price  =   $price - $dkjf / $this->config['integral_proportion'];
            }
            
            if ($jifen) {
                
                $pack_integral  =   $price * $this->config['integral_proportion'];  //  增值服务所需积分
                $integral_min   =   $this -> config['integral_min_recharge'];       //  站点最低充值积分
                
                
                if (($jifen + intval($statis['integral'])) <  intval($pack_integral)) {
                    
                    $return['error']    =   '充值'.$this->config['integral_pricename'].'不足购买增值服务，请重新输入'.$this->config['integral_pricename'].'数量！';
                    return $return;
                }else if ($jifen < intval($integral_min)) {
                    
                    $return['error']    =   '最低充值'.$this->config['integral_pricename'].'不低于'.$integral_min;
                    return $return;
                }
                
                $price  =   $jifen  /  $this->config['integral_proportion'];
                
            }
             
            $price          =   sprintf("%.2f", $price);
           
            if($price > 0){
                
                $packinfo   =   $service;
                
                if(empty($packinfo)){
                    
                    $return['error']    =   '请选择正确的增值套餐！';
                }else {
                    
                    $dingdan                    =   time().rand(10000,99999);
                    $orderData                  =   array();
                    $orderData['type']          =   '5';
                    $orderData['order_id']      =   $dingdan;
                    $orderData['order_price']   =   $price;
                    $orderData['order_time']    =   time();
                    $orderData['order_type']    =   $paytype;
                    $orderData['order_state']   =   1;
                    $orderData['rating']        =   $tid;
                    
                    $orderData['order_remark']  =   $jifen ? '充值'.$this->config['integral_pricename'].'购买增值服务。' : '';
                    
                    $orderData['order_remark']	.=	$dkjf ? $this->config['integral_pricename'].'抵扣金额'.round(($dkjf / $this->config['integral_proportion']), 2).'元。' : '';
                    
                    $orderData['order_remark']	.=	$coupon ? ' 使用优惠券'.$coupon['coupon_amount'].'元。' : '';
                    
                    $orderData['uid']           =   $uid;
                    $orderData['usertype']      =   $usertype;
                    $orderData['did']           =   $did;
                    $orderData['integral']		=	$jifen ? $jifen : '';
                    $orderData['coupon']		=	$couponid ? $couponid : '';
                    $orderData['order_dkjf']    =   $dkjf ? $dkjf : '';
                    if ($data['crm_uid']){
                        $orderData['crm_uid']   =   $data['crm_uid'];
                    }
                    
                    if ($jifen) {
                        $orderData['order_info']	=	serialize(array('tid'=>$tid,'pack_integral' => $pack_integral,'uid'=>$uid));
                    }
                    
                    $id     =   $this -> addOrder($orderData);
                    
                    if ($id) {
                        
                        require_once('integral.model.php');
                        
                        $integral   =   new integral_model($this->db,$this->def,array('uid'=>$uid,'username'=>$username,'usertype'=>$usertype));
                        
                        if ($coupon) {  //  更改优惠券使用状态
                            
                            $this -> upCouponList(array('id' => $couponid, 'uid' => $uid), array('status' => 2, 'xf_time'=>time()));   //  更新优惠券状态 2 已使用
                            
                            $integral -> company_invtal($uid, $usertype, $coupon['coupon_amount'], false, '购买增值服务，使用优惠券', true, 2, 'yhq', 12, '', $couponid);
                        }
                        
                        if($dkjf){
                            
                            $integral   ->  company_invtal($uid, $usertype, $dkjf, false, '购买增值包，使用'.$this->config['integral_pricename'].'抵扣', true, 2, 'integral', 12);
                            
                        }
                        
                        $orderData['id']    =   $id;
                        
                        $return['order']    =   $orderData;
                        
                    }else{
                        
                        $return['error']    =   '订单生成失败！';
                    }
                }
        
            }else{
                
                $return['error'] = '套餐金额出错！';
            }
            
        }else{
            
            $return['error'] = '参数错误，请重新选择！';
        }
        
        return $return;
    }
    
    
    /**
     * @desc    购买自动刷新职位
     * @param   array $data
     * @return  array $return
     */
    function buyAutoJob($data){
        
        $uid        =   intval($data['uid']);
        $usertype   =   intval($data['usertype']);
        $username   =   trim($data['username']);
        $did        =   !empty($data['did']) ? $data['did'] : $this -> config['did'];
        
        $return     =   array();
        
		$data['dkjf'] = $data['dkjf']>0 ? $data['dkjf'] : 0;

        if($data['jobautoids'] && ($data['days'] || $data['xdays'])){
            
            $jobautoids =   pylode(',' , @explode(',' , $data['jobautoids']));
            
            $autodays   =   intval($data['days']) > 0 ? intval($data['days']) : (intval($data['xdays']) > 1 ? intval($data['xdays']) : 1);
            
            $paytype    =   $data['paytype'] ? $data['paytype'] : '';
            
            if($this->config['com_integral_online'] == 1){
                
                $dkjf   =   $data['dkjf'] ? intval($data['dkjf']) : '';         //  抵扣积分
                
            }elseif ($this->config['com_integral_online'] == 3){
                
                $jifen  =   $data['price_int'] ? intval($data['price_int']) : ''; // 充值积分
            }
            
            $statis     =   $this -> getStatisInfo($uid,array('usertype' => $usertype, 'field'=>'`integral`'));
            
            if($autodays > 0 && $jobautoids){
                
                //判断职位ID真实性
                $jobs    =   $this -> select_all('company_job',array('uid' => $uid, 'id' => array('in',$jobautoids)), '`autotime`,`id`');
                
                if(empty($jobs)){
                    
                    $return['error']    =   '请选择正确的刷新职位！';
                    
                }else {
                    
                    $jobnum =   $this->select_num('company_job', array('uid' => $uid, 'id' => array('in',$jobautoids))); //计算自动刷新职位数量
                    
                    /* 计算需付费金额  */
                    $price  =   $autodays * $this->config['job_auto'] * $jobnum; // 购买自动刷新职位所需金额
                    
                    $couponid   =   intval($data['coupon_id']);
                    
                    /* 优惠券额度优先扣除 */
                    $couponWhere=   array(
                        
                        'id'            =>  $couponid,
                        'uid'           =>  $uid,
                        'status'        =>  1,
                        'validity'      =>  array('>', time()),
                        'coupon_amount' =>  array('<', $price),
                        'coupon_scope'  =>  array('<=', $price)
                    );
                    
                    $coupon     =   $this->select_once('coupon_list', $couponWhere);
                    
                    if ($coupon && is_array($coupon)) {
                        
                        $price  =   ceil($price - $coupon['coupon_amount']);            //  扣除优惠券额度后
                    }
                    
                    if ($dkjf) {
                        
                        $dkjf   =	$dkjf >= intval($statis['integral']) ? $statis['integral'] : $dkjf;
                        $price  =   $price - $dkjf / $this->config['integral_proportion'];
                    }
                    
                    if ($jifen) {
                        
                        $auto_integral      =   $price * $this->config['integral_proportion'];  //  自动刷新所需积分
                        $integral_min       =   $this -> config['integral_min_recharge'];       //  站点最低充值积分
                        
                        if (($jifen + intval($statis['integral'])) <  intval($auto_integral)) {
                            
                            $return['error']    =   '充值'.$this->config['integral_pricename'].'不足购买自动刷新，请重新输入'.$this->config['integral_pricename'].'数量！';
                            return $return;
                        }else if ($jifen < intval($integral_min)) {
                            
                            $return['error']    =   '最低充值'.$this->config['integral_pricename'].'不低于'.$integral_min;
                            return $return;
                        }
                        
                        $price  =   $jifen  /  $this->config['integral_proportion'];
                        
                    }
                    $price = sprintf('%.2f', $price);
                    
                    if ($price < 0.01){
                        
                        $return['error']  =   '购买总金额不得小于0.01元！';
                        
                    } else {
                        
                        //生成相关订单
                        $dingdan					=	time().rand(10000,99999);
                        $orderData                  =   array();
                        $orderData['type']			=	'13';
                        $orderData['order_id']		=	$dingdan;
                        $orderData['order_type']	=	$paytype;
                        $orderData['order_price']	=	$price;
                        $orderData['integral']	    =	$jifen ? $jifen : '';
                        $orderData['coupon']	    =	$couponid ? $couponid : '';
                        $orderData['order_dkjf']    =	$dkjf ? $dkjf : '';
                        $orderData['order_time']	=	time();
                        $orderData['order_state']	=	'1';
                        $orderData['order_remark']	=	$jifen ? '充值'.$this->config['integral_pricename'].'购买自动刷新' : '自动刷新';
                        
                        $orderData['order_remark']	.=	$dkjf ? ', '.$this->config['integral_pricename'].'抵扣金额'.round(($dkjf / $this->config['integral_proportion']), 2).'元' : '';
                        
                        $orderData['order_remark']	.=	$coupon ? ', 使用优惠券'.$coupon['coupon_amount'].'元' : '';
                        
                        $orderData['uid']			=	$uid;
                        $orderData['usertype']		=	$usertype;
                        $orderData['did']			=	$did;
                        if ($data['crm_uid']){
                            $orderData['crm_uid']   =   $data['crm_uid'];
                        }
                        
                        if ($jifen) {
                            
                            $orderData['order_info']	=	serialize(array('jobid' => $data['jobautoids'], 'days' => $autodays, 'auto_integral' => $auto_integral, 'price' => $price));
                        }else {
                            
                            $orderData['order_info']	=	serialize(array('jobid' => $data['jobautoids'], 'days' => $autodays, 'price' => $price));
                        }
                        
                        $id     =   $this->addOrder($orderData);
                        
                        if ($id) {
                            
                            require_once('integral.model.php');
                            
                            $integral  =   new integral_model($this->db , $this->def , array('uid' => $uid, 'username' => $username, 'usertype' => $usertype));
                            
                            if ($coupon) {  //  更改优惠券使用状态
                             
                                $this -> upCouponList(array('id' => $couponid, 'uid' => $uid), array('status' => 2, 'xf_time'=>time()));   //  更新优惠券状态 2 已使用
                                $integral -> company_invtal($uid, $usertype, $coupon['coupon_amount'], false, '购买自动刷新，使用优惠券', true, 2, 'yhq', 12, '', $couponid);
                            }
                            
                            if ($dkjf) {
                                
                                $integral  ->  company_invtal($uid, $usertype, $dkjf, false, '购买自动刷新职位，使用'.$this->config['integral_pricename'].'抵扣', true , 2 , 'integral' , 12);
                            }
                            $orderData['id']   =   $id;
                            $return['order']   =   $orderData;
                            
                        }else{
                            
                            $return['error']   =   '订单生成失败！';
                        }
                    }
                }
                
            }else{
                
                $return['error'] = '请正确选择自动刷新职位以及刷新天数！';
                
            }
            
            
        } else {
            
            $return['error'] = '参数填写错误，请重新设置！';
            
        }
        
        return $return;
        
    }
    
    /**
     * @desc    购买置顶职位
     * @param   array $data
     * @return  array $return
     */
    function buyZdJob($data){
        
        $uid        =   intval($data['uid']);
        $usertype   =   intval($data['usertype']);
        $username   =   trim($data['username']);
        $did        =   $data['did'] ? $data['did'] : $this -> config['did'];
        
        $return     =   array();
        
		$data['dkjf'] = $data['dkjf']>0 ? $data['dkjf'] : 0;

        if($data['zdjobid'] && ($data['days'] || $data['xdays'])){
            
            $jobid      =   $data['zdjobid'];
            
            $xsdays     =   intval($data['days']) > 0 ? intval($data['days']) : (intval($data['xdays']) > 1 ? intval($data['xdays']) : 1);
            
            $paytype    =   $data['paytype'] ? $data['paytype'] : '';

            if (!in_array('jobtop', $this->onlyPrice)) {
                if ($this->config['com_integral_online'] == 1) {

                    $dkjf   =   $data['dkjf'] ? intval($data['dkjf']) : '';         //  抵扣积分

                } elseif ($this->config['com_integral_online'] == 3) {

                    $jifen  =   $data['price_int'] ? intval($data['price_int']) : ''; // 充值积分
                }
            }
            $statis     =   $this -> getStatisInfo($uid,array('usertype' => $usertype, 'field'=>'`integral`'));
            
            if($xsdays > 0 && $jobid){
                
                //判断职位ID真实性
                $job    =   $this -> select_once('company_job', array('uid' => $uid,'id' => $jobid));
                
                if(empty($job)){
                    
                    $return['error']    =   '请选择正确的职位置顶！';
                    
                }else {
                    
                    //计算需付费金额
                    $price      =   $xsdays * $this->config['integral_job_top']; // 购买置顶职位所需金额
                    
                    $couponid   =   intval($data['coupon_id']);
                    
                    /* 优惠券额度优先扣除 */
                    $couponWhere=   array(
                        
                        'id'            =>  $couponid,
                        'uid'           =>  $uid,
                        'status'        =>  1,
                        'validity'      =>  array('>', time()),
                        'coupon_amount' =>  array('<', $price),
                        'coupon_scope'  =>  array('<=', $price)
                    );
                    
                    $coupon     =   $this->select_once('coupon_list', $couponWhere);
                    
                    
                    if ($coupon && is_array($coupon)) {
                        
                        $price  =   ceil($price - $coupon['coupon_amount']);            //  扣除优惠券额度后
                    }
                    
                    if ($dkjf) {
                        
                        $dkjf   =	$dkjf >= intval($statis['integral']) ? $statis['integral'] : $dkjf;
                        $price  =   $price - $dkjf / $this->config['integral_proportion'];
                    }
                    
                    if ($jifen) {
                        
                        $jobzd_integral     =   $price * $this->config['integral_proportion'];  //  职位置顶所需积分
                        $integral_min       =   $this -> config['integral_min_recharge'];       //  站点最低充值积分
                        
                        if (($jifen + intval($statis['integral'])) <  intval($jobzd_integral)) {
                            
                            $return['error']    =   '充值'.$this->config['integral_pricename'].'不足购买职位置顶，请重新输入'.$this->config['integral_pricename'].'数量！';
                            return $return;
                        }else if ($jifen < intval($integral_min)) {
                            
                            $return['error']    =   '最低充值'.$this->config['integral_pricename'].'不低于'.$integral_min;
                            return $return;
                        }
                        
                        $price  =   $jifen  /  $this->config['integral_proportion'];
                        
                    }
                    
                    $price  =   sprintf('%.2f', $price);
                    
                    if ($price < 0.01){
                        
                        $return['error']    =   '购买总金额不得小于0.01元！';
                        
                    } else {
                        //生成相关订单
                        $dingdan					=	time().rand(10000,99999);
                        $orderData                  =   array();
                        $orderData['type']			=	'10';
                        $orderData['order_id']		=	$dingdan;
                        $orderData['order_type']	=	$paytype;
                        $orderData['order_price']	=	$price;
                        $orderData['integral']	    =	$jifen ? $jifen : '';
                        $orderData['coupon']		=	$couponid ? $couponid : '';
                        $orderData['order_dkjf']    =	$dkjf ? $dkjf : '';
                        $orderData['order_time']	=	time();
                        $orderData['order_state']	=	'1';
                        $orderData['order_remark']	=	$jifen ? '充值'.$this->config['integral_pricename'].'购买职位置顶' : '置顶服务';
                        
                        $orderData['order_remark']	.=	$dkjf ? ', '.$this->config['integral_pricename'].'抵扣金额'.round(($dkjf / $this->config['integral_proportion']), 2).'元' : '';
                        
                        $orderData['order_remark']	.=	$coupon ? ', 使用优惠券'.$coupon['coupon_amount'].'元' : '';
                        
                        $orderData['uid']			=	$uid;
						$orderData['usertype']		=	$usertype;
                        $orderData['did']			=	$did;
                        if ($data['crm_uid']){
                            $orderData['crm_uid']   =   $data['crm_uid'];
                        }
                        
                        if ($jifen) {
                            
                            $orderData['order_info']	=	serialize(array('jobid' => $jobid, 'days' => $xsdays, 'jobzd_integral' => $jobzd_integral, 'price' => $price));
                        }else {
                            
                            $orderData['order_info']	=	serialize(array('jobid' => $jobid, 'days' => $xsdays, 'price' => $price));
                        }
                        
                        $id =   $this->addOrder($orderData);
                        
                        if ($id) {
                            
                            require_once('integral.model.php');
                            
                            $integral   =   new integral_model($this->db , $this->def , array('uid' => $uid, 'username' => $username, 'usertype' => $usertype));
                            
                            if ($coupon) {  //  更改优惠券使用状态
                                
                                $this -> upCouponList(array('id' => $couponid, 'uid' => $uid), array('status' => 2, 'xf_time'=>time()));   //  更新优惠券状态 2 已使用
                                $integral -> company_invtal($uid, $usertype, $coupon['coupon_amount'], false, '购买职位置顶，使用优惠券', true, 2, 'yhq', 12, '', $couponid);
                            }
                            
                            if ($dkjf) {
                                
                                $integral   ->  company_invtal($uid,$usertype, $dkjf, false, '购买职位置顶，使用'.$this->config['integral_pricename'].'抵扣', true, 2, 'integral', 12);
                            }
                            
                            $orderData['id']    =   $id;
                            $return['order']    =   $orderData;
                            
                        }else {
                            
                            $return['error']    =   '订单生成失败！';
                        }
                         
                    }
                }
                
            }else{
                
                $return['error']    =   '请正确选择职位置顶以及置顶的天数！';
                
            }
            
        } else {
            
            $return['error']        =   '参数填写错误，请重新设置！';
            
        }
        
        return $return;
    }
    
    /**
     * @desc    购买职位推荐
     * @param   array $data
     * @return  array $return
     */
    function buyRecJob($data){
        
        $uid        =   intval($data['uid']);
        $usertype   =   intval($data['usertype']);
        $username   =   trim($data['username']);
        $did        =   $data['did'] ? $data['did'] : $this -> config['did'];

        $return     =   array();

        $data['dkjf'] = $data['dkjf']>0 ? $data['dkjf'] : 0;

        if($data['recjobid'] && ($data['days'] || $data['xdays'])){
            
            $jobid      =   $data['recjobid'];
            
            $recdays    =   intval($data['days']) > 0 ? intval($data['days']) : (intval($data['xdays']) > 1 ? intval($data['xdays']) : 1);
            
            $paytype    =   $data['paytype'] ? $data['paytype'] : '';

            if (!in_array('jobrec', $this->onlyPrice)) {
                if ($this->config['com_integral_online'] == 1) {

                    $dkjf   =   $data['dkjf'] ? intval($data['dkjf']) : '';         //  抵扣积分

                } elseif ($this->config['com_integral_online'] == 3) {

                    $jifen  =   $data['price_int'] ? intval($data['price_int']) : ''; // 充值积分
                }
            }
            $statis     =   $this -> getStatisInfo($uid,array('usertype' => $usertype, 'field'=>'`integral`'));
            
            if($recdays > 0 && $jobid){
                
                //判断职位ID真实性
                $job    =   $this -> select_once('company_job', array('uid' => $uid, 'id' => $jobid));
                
                if(empty($job)){
                    
                    $return['error'] = '请选择正确的职位推荐！';
                }else {
                    //计算需付费金额
                    $price      =   $recdays * $this->config['com_recjob']; // 购买职位推荐所需金额
                    
                    $couponid   =   intval($data['coupon_id']);
                    /* 优惠券额度优先扣除 */
                    $couponWhere=   array(
                        
                        'id'            =>  $couponid,
                        'uid'           =>  $uid,
                        'status'        =>  1,
                        'validity'      =>  array('>', time()),
                        'coupon_amount' =>  array('<', $price),
                        'coupon_scope'  =>  array('<=', $price)
                    );
                    
                    $coupon     =   $this->select_once('coupon_list', $couponWhere);
                    
                    
                    if ($coupon && is_array($coupon)) {
                        
                        $price  =   ceil($price - $coupon['coupon_amount']);            //  扣除优惠券额度后
                    }
                    
                    if ($dkjf) {
                        
                        $dkjf   =	$dkjf >= intval($statis['integral']) ? $statis['integral'] : $dkjf;
                        $price  =   $price - $dkjf / $this->config['integral_proportion'];
                    }
                    
                    if ($jifen) {
                        
                        $jobrec_integral    =   $price * $this->config['integral_proportion'];  //  职位推荐所需积分
                        $integral_min       =   $this -> config['integral_min_recharge'];       //  站点最低充值积分
                        
                        if (($jifen + intval($statis['integral'])) <  intval($jobrec_integral)) {
                            
                            $return['error']    =   '充值'.$this->config['integral_pricename'].'不足购买职位推荐，请重新输入'.$this->config['integral_pricename'].'数量！';
                            return $return;
                        }else if ($jifen < intval($integral_min)) {
                            
                            $return['error']    =   '最低充值'.$this->config['integral_pricename'].'不低于'.$integral_min;
                            return $return;
                        }
                        
                        $price  =   $jifen  /  $this->config['integral_proportion'];
                        
                    }
                    
                    $price      =   sprintf("%.2f", $price);
                    
                    if ($price < 0.01){
                        
                        $return['error']            =   '购买总金额不得小于0.01元！';
                    } else {
                         
                        //生成相关订单
                        $dingdan					=	time().rand(10000,99999);
                        $orderData                  =   array();
                        $orderData['type']			=	'12';    
                        $orderData['order_id']		=	$dingdan;
                        $orderData['order_type']	=	$paytype;
                        $orderData['order_price']	=	$price;
                        $orderData['integral']	    =	$jifen ? $jifen : '';
                        $orderData['coupon']	    =	$couponid ? $couponid : '';
                        $orderData['order_dkjf']    =	$dkjf ? $dkjf : '';
                        $orderData['order_time']	=	time();
                        $orderData['order_state']	=	'1';
                        
                        $orderData['order_remark']	=	$jifen ? '充值'.$this->config['integral_pricename'].'购买职位推荐' : '职位推荐';
                        
                        $orderData['order_remark']	.=	$dkjf ? ', '.$this->config['integral_pricename'].'抵扣金额'.round(($dkjf / $this->config['integral_proportion']), 2).'元' : '';
                        
                        $orderData['order_remark']	.=	$coupon ? ', 使用优惠券'.$coupon['coupon_amount'].'元' : '';
                        
                        $orderData['uid']			=	$uid;
						$orderData['usertype']		=	$usertype;
                        $orderData['did']			=	$did;

                        if ($data['crm_uid']){
                            $orderData['crm_uid']   =   $data['crm_uid'];
                        }
                        
                        if ($jifen) {
                            
                            $orderData['order_info']	=	serialize(array('jobid' => $jobid, 'days' => $recdays, 'jobrec_integral' => $jobrec_integral, 'price' => $price));
                        }else {
                            
                            $orderData['order_info']	=	serialize(array('jobid' => $jobid, 'days' => $recdays, 'price' => $price));
                        }
                        
                        $id =   $this -> addOrder($orderData);
                        
                        if ($id) {
                            require_once('integral.model.php');
                            
                            $integral   =   new integral_model($this->db , $this->def , array('uid' => $uid, 'username' => $username, 'usertype' => $usertype));
                            
                            if ($coupon) {  //  更改优惠券使用状态
                                
                                $this -> upCouponList(array('id' => $couponid, 'uid' => $uid), array('status' => 2, 'xf_time'=>time()));   //  更新优惠券状态 2 已使用
                                $integral -> company_invtal($uid, $usertype, $coupon['coupon_amount'], false, '购买职位推荐，使用优惠券', true, 2, 'yhq', 12, '', $couponid);
                            }
                            
                            if ($dkjf) {
                                
                                $integral -> company_invtal($uid,$usertype, $dkjf, false, '购买职位推荐，使用'.$this->config['integral_pricename'].'抵扣', true, 2, 'integral', 12);
                            }
                            $orderData['id']    =   $id;
                            $return['order']    =   $orderData;
                            
                        }else {
                            
                            $return['error']    =   '订单生成失败！';
                        }
                    }
                }
            }else{
                
                $return['error']    =   '请正确选择职位推荐以及推荐的时长！';
                
            }
            
        } else {
            
            $return['error']        =   '参数填写错误，请重新设置！';
            
        }
        
        return $return;
        
    }
    
    /**
     * @desc    购买兼职推荐
     * @param   array $data
     * @return  array $return
     */
    function buyRecPart($data){
        
        $uid        =   intval($data['uid']);
        $usertype   =   intval($data['usertype']);
        $username   =   trim($data['username']);
        $did        =   $data['did'] ? $data['did'] : $this -> config['did'];
        
        $return     =   array();
        
		$data['dkjf'] = $data['dkjf']>0 ? $data['dkjf'] : 0;

        if($data['recpartid'] && ($data['days'] || $data['xdays'])){
        
            $jobid      =   $data['recpartid'];
            
            $recdays    =   intval($data['days']) > 0 ? intval($data['days']) : (intval($data['xdays']) > 1 ? intval($data['xdays']) : 1);
            
            $paytype    =   $data['paytype'] ? $data['paytype'] : '';

            if (!in_array('job_rec', $this->onlyPrice)) {
                if ($this->config['com_integral_online'] == 1) {

                    $dkjf = $data['dkjf'] ? intval($data['dkjf']) : '';       // 抵扣积分

                } elseif ($this->config['com_integral_online'] == 3) {

                    $jifen = $data['price_int'] ? intval($data['price_int']) : '';   // 充值积分
                }
            }
            
            $statis     =   $this -> getStatisInfo($uid,array('usertype' => $usertype, 'field'=>'`integral`'));
            
            if($recdays > 0 && $jobid){
                
                //判断职位ID真实性
                $job    =   $this -> select_once('partjob', array('id' => $jobid, 'uid' => $uid));
                
                if(empty($job)){
                    
                    $return['error']    =   '请选择正确的职位推荐！';
                    
                }else {
                    
                    //计算需付费金额
                    $price      =   $recdays * $this->config['com_recjob'];     // 购买职位推荐所需金额
                    
                    $couponid   =   intval($data['coupon_id']);
                    
                    /* 优惠券额度优先扣除 */
                    $couponWhere=   array(
                        
                        'id'            =>  $couponid,
                        'uid'           =>  $uid,
                        'status'        =>  1,
                        'validity'      =>  array('>', time()),
                        'coupon_amount' =>  array('<', $price),
                        'coupon_scope'  =>  array('<=', $price)
                    );
                    
                    $coupon     =   $this->select_once('coupon_list', $couponWhere);
                    
                    
                    if ($coupon && is_array($coupon)) {
                        
                        $price  =   ceil($price - $coupon['coupon_amount']);            //  扣除优惠券额度后
                    }
                    
                    if ($dkjf) {
                        
                        $dkjf   =	$dkjf >= intval($statis['integral']) ? $statis['integral'] : $dkjf;
                        $price  =   $price - $dkjf / $this->config['integral_proportion'];
                    }
                    
                    if ($jifen) {
                        
                        $recpart_integral=   $price * $this->config['integral_proportion'];  //  职位推荐所需积分
                        $integral_min       =   $this -> config['integral_min_recharge'];       //  站点最低充值积分
                        
                        if (($jifen + intval($statis['integral'])) <  intval($recpart_integral)) {
                            
                            $return['error']    =   '充值'.$this->config['integral_pricename'].'不足购买推荐兼职，请重新输入'.$this->config['integral_pricename'].'数量！';
                            return $return;
                        }else if ($jifen < intval($integral_min)) {
                            
                            $return['error']    =   '最低充值'.$this->config['integral_pricename'].'不低于'.$integral_min;
                            return $return;
                        }
                        
                        $price  =   $jifen  /  $this->config['integral_proportion'];
                        
                    }
                    
                    $price  =   sprintf("%.2f", $price);
                    
                    if ($price < 0.01){
                        
                        $return['error']            =   '购买总金额不得小于0.01元！';
                        
                    } else {
                        //生成相关订单
                        $dingdan					=	time().rand(10000,99999);
                        $orderData                  =   array();
                        $orderData['type']			=	'24';
                        $orderData['order_id']		=	$dingdan;
                        $orderData['order_type']	=	$paytype;
                        $orderData['order_price']	=	$price;
                        $orderData['integral']	    =	$jifen ? $jifen : '';
                        $orderData['coupon']	    =	$couponid ? $couponid : '';
                        $orderData['order_dkjf']    =	$dkjf ? $dkjf : '';
                        $orderData['order_time']	=	time();
                        $orderData['order_state']	=	'1';
                        
                        $orderData['order_remark']	=	$jifen ? '充值'.$this->config['integral_pricename'].'购买兼职推荐' : '兼职推荐';
                        
                        $orderData['order_remark']	.=	$dkjf ? ', '.$this->config['integral_pricename'].'抵扣金额'.round(($dkjf / $this->config['integral_proportion']), 2).'元' : '';
                        
                        $orderData['order_remark']	.=	$coupon ? ', 使用优惠券'.$coupon['coupon_amount'].'元' : '';
                        
                        $orderData['uid']			=	$uid;
                        $orderData['usertype']		=	$usertype;
                        $orderData['did']			=	$did;

                        if ($data['crm_uid']){
                            $orderData['crm_uid']   =   $data['crm_uid'];
                        }
                        
                        if ($jifen) {
                            
                            $orderData['order_info']	=	serialize(array('jobid' => $jobid, 'days' => $recdays, 'recpart_integral' => $recpart_integral, 'price' => $price));
                        }else {
                            
                            $orderData['order_info']	=	serialize(array('jobid' => $jobid, 'days' => $recdays, 'price' => $price));
                        }
                        
                        $id =   $this -> addOrder($orderData);
                        
                        if ($id) {
                            require_once('integral.model.php');
                            
                            $integral   =   new integral_model($this->db , $this->def , array('uid' => $uid, 'username' => $username, 'usertype' => $usertype));
                            
                            if ($coupon) {  //  更改优惠券使用状态
                                
                                $this -> upCouponList(array('id' => $couponid, 'uid' => $uid), array('status' => 2, 'xf_time'=>time()));   //  更新优惠券状态 2 已使用
                                $integral -> company_invtal($uid, $usertype, $coupon['coupon_amount'], false, '购买兼职推荐，使用优惠券', true, 2, 'yhq', 12, '', $couponid);
                            }
                            
                            if ($dkjf) {
                                
                                $integral -> company_invtal($uid,$usertype, $dkjf, false, '购买兼职推荐，使用'.$this->config['integral_pricename'].'抵扣', true, 2, 'integral', 12);
                            }
                            $orderData['id']    =   $id;
                            $return['order']    =   $orderData;
                            
                        }else {
                            
                            $return['error']    =   '订单生成失败！';
                        }
                    }
                }
            
            }else{
                
                $return['error']    =   '请正确选择职位推荐以及推荐的时长！';
                
            }
            
        } else {
            
            $return['error']        =   '参数填写错误，请重新设置！';
            
        }
        
        return $return;
        
    }
    
    /**
     * @desc    购买紧急招聘
     * @param   array $data
     * @return  array $return
     */
    function buyUrgentJob($data){
        
        $uid        =   intval($data['uid']);
        $usertype   =   intval($data['usertype']);
        $username   =   trim($data['username']);
        $did        =   $data['did'] ? $data['did'] : $this -> config['did'];
        
        $return     =   array();

        $data['dkjf'] = $data['dkjf']>0 ? $data['dkjf'] : 0;

        if($data['ujobid'] && ($data['days'] || $data['xdays'])){
            
            $jobid      =   $data['ujobid'];
            
            $udays      =   intval($data['days']) > 0 ? intval($data['days']) : (intval($data['xdays']) > 1 ? intval($data['xdays']) : 1);
            
            $paytype    =   $data['paytype'] ? $data['paytype'] : '';

            if (!in_array('joburgent', $this->onlyPrice)) {
                if ($this->config['com_integral_online'] == 1) {

                    $dkjf = $data['dkjf'] ? intval($data['dkjf']) : '';         //  抵扣积分

                } elseif ($this->config['com_integral_online'] == 3) {

                    $jifen = $data['price_int'] ? intval($data['price_int']) : '';   // 充值积分
                }
            }
            $statis     =   $this -> getStatisInfo($uid,array('usertype' => $usertype, 'field'=>'`integral`'));
            
            if($udays > 0 && $jobid){
                 
                //判断职位ID真实性
                $job    =   $this -> select_once('company_job', array('uid' => $uid, 'id' => $jobid));
                
                if(empty($job)){
                    
                    $return['error']    =   '请选择正确的职位！';
                    
                }else {
                    
                    //计算需付费金额
                    $price  =   $udays * $this->config['com_urgent']; // 购买紧急招聘职位所需金额
                    
                    $couponid   =   intval($data['coupon_id']);
                    
                    /* 优惠券额度优先扣除 */
                    $couponWhere=   array(
                        
                        'id'            =>  $couponid,
                        'uid'           =>  $uid,
                        'status'        =>  1,
                        'validity'      =>  array('>', time()),
                        'coupon_amount' =>  array('<', $price),
                        'coupon_scope'  =>  array('<=', $price)
                    );
                    
                    $coupon     =   $this->select_once('coupon_list', $couponWhere);
                    
                    
                    if ($coupon && is_array($coupon)) {
                        
                        $price  =   ceil($price - $coupon['coupon_amount']);            //  扣除优惠券额度后
                    }
                    
                    if ($dkjf) {
                        
                        $dkjf   =	$dkjf >= intval($statis['integral']) ? $statis['integral'] : $dkjf;
                        $price  =   $price - $dkjf / $this->config['integral_proportion'];
                    }
                    
                    if ($jifen) {
                        
                        $joburgent_integral     =   $price * $this->config['integral_proportion'];  //  职位紧急招聘所需积分
                        $integral_min           =   $this -> config['integral_min_recharge'];       //  站点最低充值积分
                        
                        if (($jifen + intval($statis['integral'])) <  intval($joburgent_integral)) {
                            
                            $return['error']    =   '充值'.$this->config['integral_pricename'].'不足购买职位紧急招聘，请重新输入'.$this->config['integral_pricename'].'数量！';
                            return $return;
                        }else if ($jifen < intval($integral_min)) {
                            
                            $return['error']    =   '最低充值'.$this->config['integral_pricename'].'不低于'.$integral_min;
                            return $return;
                        }
                        
                        $price  =   $jifen  /  $this->config['integral_proportion'];
                        
                    }
                    
                    $price  =   sprintf("%.2f", $price);
                    
                    if ($price < 0.01){
                        
                        $return['error'] = '购买总金额不得小于0.01元！';
                        
                    } else {
                        
                        //生成相关订单
                        $dingdan					=	time().rand(10000,99999);
                        $orderData                  =   array();
                        $orderData['type']			=	'11';    
                        $orderData['order_id']		=	$dingdan;
                        $orderData['order_type']	=	$paytype;
                        $orderData['order_price']	=	$price;
                        $orderData['integral']	    =	$jifen ? $jifen : '';
                        $orderData['coupon']	    =	$couponid ? $couponid : '';
                        $orderData['order_dkjf']    =	$dkjf ? $dkjf : '';
                        $orderData['order_time']	=	time();
                        $orderData['order_state']	=	'1';
                        
                        $orderData['order_remark']	=	$jifen ? '充值'.$this->config['integral_pricename'].'购买职位紧急招聘' : '紧急招聘';
                        
                        $orderData['order_remark']	.=	$dkjf ? ', '.$this->config['integral_pricename'].'抵扣金额'.round(($dkjf / $this->config['integral_proportion']), 2).'元' : '';
                        
                        $orderData['order_remark']	.=	$coupon ? ', 使用优惠券'.$coupon['coupon_amount'].'元' : '';
                        
                        $orderData['uid']			=	$uid;
						$orderData['usertype']		=	$usertype;
                        $orderData['did']			=	$did;

                        if ($data['crm_uid']){
                            $orderData['crm_uid']   =   $data['crm_uid'];
                        }
                        
                        if ($jifen) {
                            
                            $orderData['order_info']	=	serialize(array('jobid' => $jobid, 'days' => $udays, 'joburgent_integral' => $joburgent_integral, 'price' => $price));
                        }else {
                            
                            $orderData['order_info']	=	serialize(array('jobid' => $jobid, 'days' => $udays, 'price' => $price));
                        }
                        
                        $id     =   $this -> addOrder($orderData);
                        
                        if ($id) {
                            
                            require_once('integral.model.php');
                            
                            $integral   =   new integral_model($this->db , $this->def , array('uid' => $uid, 'username' => $username, 'usertype' => $usertype));
                            
                            if ($coupon) {  //  更改优惠券使用状态
                                
                                $this -> upCouponList(array('id' => $couponid, 'uid' => $uid), array('status' => 2, 'xf_time'=>time()));   //  更新优惠券状态 2 已使用
                                $integral -> company_invtal($uid, $usertype, $coupon['coupon_amount'], false, '购买紧急招聘，使用优惠券', true, 2, 'yhq', 12, '', $couponid);
                            }
                            
                            if ($dkjf) {
                                
                                $integral -> company_invtal($uid,$usertype, $dkjf, false, '购买紧急招聘，使用'.$this->config['integral_pricename'].'抵扣', true, 2, 'integral', 12);
                            }
                            $orderData['id']    =   $id;
                            $return['order']    =   $orderData;
                            
                        }else {
                            
                            $return['error']    =   '订单生成失败！';
                        }
                        
                    }
                }
                
            }else{
                
                $return['error']    =   '请正确选择职位以及紧急招聘天数！';
                
            }
            
        } else {
            
            $return['error']    =   '参数填写错误，请重新设置！';
            
        }
        
        return $return;
        
    }
    
    /**
     * @desc    购买职位刷新
     * @param   array $data
     * @return  array $return
     */
    function buyRefreshJob($data)
    {
        
        $uid        =   intval($data['uid']);
        $usertype   =   intval($data['usertype']);
        $username   =   trim($data['username']);
        $did        =   $data['did'] ? $data['did'] : $this -> config['did'];
        
        $return     =   array();
        
		$data['dkjf'] = $data['dkjf']>0 ? $data['dkjf'] : 0;

        if ($data['sxjobid']) {
            
            if ($data['sxjobid'] == 'all'){
                // 小程序刷新全部职位
                $jobs   =   $this -> select_all('company_job', array('uid' => $uid,'state' => 1, 'status' => 0,'r_status' => 1), '`id`');
                
                foreach ($jobs as $v){
                    $jid[] = $v['id'];
                }
                $jobid  =  pylode(',', $jid);
                
            }else{
                
                $jobid  =   pylode(',', @explode(',', $data['sxjobid']));
            }

            $paytype    =   $data['paytype'] ? $data['paytype'] : '';

            if (!in_array('sxjob', $this->onlyPrice)) {
                if ($this->config['com_integral_online'] == 1) {

                    $dkjf = $data['dkjf'] ? intval($data['dkjf']) : '';       //  抵扣积分

                } elseif ($this->config['com_integral_online'] == 3) {

                    $jifen = $data['price_int'] ? intval($data['price_int']) : '';   //  充值积分
                }
            }
            $statis     =   $this -> getStatisInfo($uid,array('usertype' => $usertype, 'field'=>'`integral`,`breakjob_num`'));
            
            if ($jobid) {
                
                $couponid       =   intval($data['coupon_id']);
 
                $breakjob_num   =   intval($statis['breakjob_num']);

                // 判断职位ID真实性
                $jobs   =   $this -> select_all('company_job', array('uid' => $uid, 'id' => array('in', $jobid)), '`id`');

                if (empty($jobs)) {
                    
                    $return['error']    =   '请选择正确的职位刷新！';
                } else {
                    
                    $jobnum =   $this->select_num('company_job', array('uid' => $uid, 'id' => array('in', $jobid))); // 计算刷新职位数量
                    
                    // 扣除套参数操作（会员套餐未用完，优先扣除套餐）
                    if ($breakjob_num) {
                        $jobnum    =   $jobnum - $breakjob_num;
                    }
                    
                    // 计算需付费金额
                    $price  =   $this->config['integral_jobefresh'] * $jobnum;  //  购买刷新职位所需金额

                    /* 优惠券额度优先扣除 */
                    $couponWhere=   array(
                        
                        'id'            =>  $couponid,
                        'uid'           =>  $uid,
                        'status'        =>  1,
                        'validity'      =>  array('>', time()),
                        'coupon_amount' =>  array('<', $price),
                        'coupon_scope'  =>  array('<=', $price)
                    );
                    
                    $coupon     =   $this->select_once('coupon_list', $couponWhere);
                    
                    if ($coupon && is_array($coupon)) {
                        
                        $price  =   ceil($price - $coupon['coupon_amount']);    //  扣除优惠券额度后
                    }
                    
                    if ($dkjf) {
                        
                        $dkjf   =	$dkjf >= intval($statis['integral']) ? $statis['integral'] : $dkjf;
                        $price  =   $price - $dkjf / $this->config['integral_proportion'];
                    }
                    
                    if ($jifen) {
                        
                        $sxjob_integral         =   $price * $this->config['integral_proportion'];  //  刷新职位所需积分
                        $integral_min           =   $this -> config['integral_min_recharge'];       //  站点最低充值积分
                        
                        if (($jifen + intval($statis['integral'])) <  intval($sxjob_integral)) {
                            
                            $return['error']    =   '充值'.$this->config['integral_pricename'].'不足购买职位刷新，请重新输入'.$this->config['integral_pricename'].'数量！';
                            return $return;
                        }else if ($jifen < intval($integral_min)) {
                            
                            $return['error']    =   '最低充值'.$this->config['integral_pricename'].'不低于'.$integral_min;
                            return $return;
                        }
                        
                        $price  =   $jifen  /  $this->config['integral_proportion'];
                        
                    }
                    
                    $price  =   sprintf("%.2f", $price);
                    
                    if ($price < 0.01) {
                    
                        $return['error'] = '购买总金额不得小于0.01元！';
                    } else {
                        
                        //生成相关订单
                        $dingdan					=	time().rand(10000,99999);
                        $orderData                  =   array();
                        $orderData['type']			=	'16';
                        $orderData['order_id']		=	$dingdan;
                        $orderData['order_type']	=	$paytype;
                        $orderData['order_price']	=	$price;
                        $orderData['integral']	    =	$jifen ? $jifen : '';
                        $orderData['order_dkjf']    =	$dkjf ? $dkjf : '';
                        $orderData['coupon']	    =	$couponid ? $couponid : '';
                        $orderData['order_time']	=	time();
                        $orderData['order_state']	=	'1';
                        
                        $orderData['order_remark']	=	$jifen ? '充值'.$this->config['integral_pricename'].'购买职位刷新' : '刷新职位';
                        
                        $orderData['order_remark']	.=	$dkjf ? ', '.$this->config['integral_pricename'].'抵扣金额'.round(($dkjf / $this->config['integral_proportion']), 2).'元' : '';
                        
                        $orderData['order_remark']	.=	$coupon ? ', 使用优惠券'.$coupon['coupon_amount'].'元' : '';
                        
                        $orderData['uid']			=	$uid;
                        $orderData['usertype']		=	$usertype;
                        $orderData['did']			=	$did;

                        if ($data['crm_uid']){
                            $orderData['crm_uid']   =   $data['crm_uid'];
                        }
                        
                        if ($jifen) {
                            
                            $orderData['order_info']	=	serialize(array('jobid' => $jobid, 'breakjob_num' => $breakjob_num ? $breakjob_num : 0, 'sxjob_integral' => $sxjob_integral, 'price' => $price));
                        }else {
                            
                            $orderData['order_info']	=	serialize(array('jobid' => $jobid, 'breakjob_num' => $breakjob_num ? $breakjob_num : 0, 'price' => $price));
                        }
                        
                        $id     =   $this->addOrder($orderData);
                        
                        if ($id) {
                            
                            if ($breakjob_num) {
                                
                                $this->update_once('company_statis', array('breakjob_num' => '0'), array('uid' => $uid));
                            }
                            
                            require_once ('integral.model.php');
                            
                            $integral = new integral_model($this->db, $this->def, array('uid' => $uid, 'username' => $username, 'usertype' => $usertype));
                            
                            if ($coupon) {  //  更改优惠券使用状态
                             
                                $this -> upCouponList(array('id' => $couponid, 'uid' => $uid), array('status' => 2, 'xf_time'=>time()));   //  更新优惠券状态 2 已使用
                                
                                $integral -> company_invtal($uid, $usertype, $coupon['coupon_amount'], false, '购买职位刷新，使用优惠券', true, 2, 'yhq', 12, '', $couponid);
                            }
                            
                            if($dkjf){
                                
                                $integral->company_invtal($uid, $usertype, $dkjf, false, "购买刷新职位，使用".$this->config['integral_pricename']."抵扣", true, 2, 'integral', 12);
                            }
                            
                            $orderData['id'] = $id;
                            $return['order'] = $orderData;
                            
                        }else{
                            
                            $return['error'] = '订单生成失败！';
                        }
                    }
                }
                
            } else {
                $return['error'] = '请正确选择职位刷新！';
            }
            
        } else {
            
            $return['error'] = '参数填写错误，请重新设置！';
        }
        
        return $return;
    }

    /**
     * 购买兼职刷新
     *
     * @param array $data
     * @return array $return
     */
    function buyRefreshPart($data)
    {
        $uid        =   intval($data['uid']);
        $usertype   =   intval($data['usertype']);
        $username   =   trim($data['username']);
        $did        =   $data['did'] ? $data['did'] : $this -> config['did'];
        
        $return     =   array();

		
		$data['dkjf'] = $data['dkjf']>0 ? $data['dkjf'] : 0;

        if ($data['sxpartid']) {

            $jobid  =   pylode(',', @explode(',', $data['sxpartid']));
            
            $paytype    =   $data['paytype'] ? $data['paytype'] : '';

            if (!in_array('sxjob', $this->onlyPrice)) {
                if ($this->config['com_integral_online'] == 1) {

                    $dkjf = $data['dkjf'] ? intval($data['dkjf']) : '';         //  抵扣积分

                } elseif ($this->config['com_integral_online'] == 3) {

                    $jifen = $data['price_int'] ? intval($data['price_int']) : ''; // 充值积分
                }
            }
            
            $statis     =   $this -> getStatisInfo($uid,array('usertype' => $usertype, 'field'=>'`integral`,`breakjob_num`'));
             
            if ($jobid) {
                
                $couponid       =   intval($data['coupon_id']);

                $breakpart_num  =   intval($statis['breakjob_num']);

                // 判断职位ID真实性
                $parts  =   $this -> select_all('partjob', array('uid' => $uid, 'id' => array('in', $jobid)), '`id`');

                if (empty($parts)) {
                    
                    $return['error']    =   '职位参数错误！';
                    
                } else {
                    
                    $partnum    =   $this->select_num('partjob', array('uid' => $uid, 'id' => array('in', $jobid))); // 计算刷新兼职数量

                    // 扣除套参数操作（会员套餐未用完，优先扣除套餐）
                    if ($breakpart_num) {
                        $partnum    =   $partnum - $breakpart_num;
                    }

                    // 计算需付费金额
                    $price  =   $this->config['integral_jobefresh'] * $partnum; // 购买刷新职位所需金额

                    /* 优惠券额度优先扣除 */
                    $couponWhere=   array(
                        
                        'id'            =>  $couponid,
                        'uid'           =>  $uid,
                        'status'        =>  1,
                        'validity'      =>  array('>', time()),
                        'coupon_amount' =>  array('<', $price),
                        'coupon_scope'  =>  array('<=', $price)
                    );
                    
                    $coupon     =   $this->select_once('coupon_list', $couponWhere);
                    
                    if ($coupon && is_array($coupon)) {
                        
                        $price  =   ceil($price - $coupon['coupon_amount']);    //  扣除优惠券额度后
                    }
                    
                    if ($dkjf) {
                        
                        $dkjf   =	$dkjf >= intval($statis['integral']) ? $statis['integral'] : $dkjf;
                        $price  =   $price - $dkjf / $this->config['integral_proportion'];
                    }
                    
                    if ($jifen) {
                        
                        $sxpart_integral        =   $price * $this->config['integral_proportion'];  //  刷新兼职所需积分
                        $integral_min           =   $this -> config['integral_min_recharge'];       //  站点最低充值积分
                        
                        if (($jifen + intval($statis['integral'])) <  intval($sxpart_integral)) {
                            
                            $return['error']    =   '充值'.$this->config['integral_pricename'].'不足购买兼职刷新，请重新输入'.$this->config['integral_pricename'].'数量！';
                            return $return;
                        }else if ($jifen < intval($integral_min)) {
                            
                            $return['error']    =   '最低充值'.$this->config['integral_pricename'].'不低于'.$integral_min;
                            return $return;
                        }
                        
                        $price  =   $jifen  /  $this->config['integral_proportion'];
                        
                    }
                    $price = sprintf("%.2f", $price);
                    
                    if ($price < 0.01) {
                        
                        $return['error'] = '购买总金额不得小于0.01元！';
                    } else {
                        
                        //生成相关订单
                        $dingdan					=	time().rand(10000,99999);
                        $orderData                  =   array();
                        $orderData['type']			=	'17';
                        $orderData['order_id']		=	$dingdan;
                        $orderData['order_type']	=	$paytype;
                        $orderData['order_price']	=	$price;
                        $orderData['integral']	    =	$jifen ? $jifen : '';
                        $orderData['order_dkjf']    =	$dkjf ? $dkjf : '';
                        $orderData['coupon']	    =	$couponid ? $couponid : '';
                        $orderData['order_time']	=	time();
                        $orderData['order_state']	=	'1';
                        
                        $orderData['order_remark']	=	$jifen ? '充值'.$this->config['integral_pricename'].'购买兼职刷新' : '兼职刷新';
                        
                        $orderData['order_remark']	.=	$dkjf ? ', '.$this->config['integral_pricename'].'抵扣金额'.round(($dkjf / $this->config['integral_proportion']), 2).'元' : '';
                        
                        $orderData['order_remark']	.=	$coupon ? ', 使用优惠券'.$coupon['coupon_amount'].'元' : '';
                        
                        $orderData['uid']			=	$uid;
                        $orderData['usertype']		=	$usertype;
                        $orderData['did']			=	$did;

                        if ($data['crm_uid']){
                            $orderData['crm_uid']   =   $data['crm_uid'];
                        }
                        
                        if ($jifen) {
                            
                            $orderData['order_info']	=	serialize(array('jobid' => $data['sxpartid'], 'breakjob_num' => $breakpart_num ? $breakpart_num : 0, 'sxpart_integral' => $sxpart_integral, 'price' => $price));
                        }else {
                            
                            $orderData['order_info']	=	serialize(array('jobid' => $data['sxpartid'], 'breakjob_num' => $breakpart_num ? $breakpart_num : 0, 'price' => $price));
                        }
                         
                        $id =   $this->addOrder($orderData);
                        
                        if ($id) {
                            
                            if ($breakpart_num) {
                                
                                $this->update_once('company_statis', array('breakjob_num' => '0'), array('uid' => $uid));
                            }
                            
                            require_once ('integral.model.php');
                            
                            $integral = new integral_model($this->db, $this->def, array('uid' => $uid, 'username' => $username, 'usertype' => $usertype));
                            
                            if ($coupon) {  //  更改优惠券使用状态
                                
                                $this -> upCouponList(array('id' => $couponid, 'uid' => $uid), array('status' => 2, 'xf_time'=>time()));   //  更新优惠券状态 2 已使用
                                
                                $integral -> company_invtal($uid, $usertype, $coupon['coupon_amount'], false, '购买兼职刷新，使用优惠券', true, 2, 'yhq', 12, '', $couponid);
                            }
                            
                            if ($dkjf) {
                            
                                $integral->company_invtal($uid, $usertype, $dkjf, false, "购买兼职刷新，使用".$this->config['integral_pricename']."抵扣", true, 2, 'integral', 12);
                            }
                            
                            $orderData['id'] = $id;
                            $return['order'] = $orderData;
                        }else{
                            
                            $return['error'] = '订单生成失败！';
                        }
                    }
                }
            } else {
            
                $return['error'] = '请正确选择职位刷新！';
            }
        } else {
            
            $return['error'] = '参数填写错误，请重新设置！';
        }
        return $return;
    }

    /**
     * @desc    购买简历下载
     * @param   array $data
     * @return  array $return
     */
    function buyDownresume($data){
        
        $uid	  	=	intval($data['uid']);
        $usertype   =   intval($data['usertype']);
        $did        =   $data['did'] ? $data['did'] : $this -> config['did'];
        
        $return     =   array();
        
		$data['dkjf'] = $data['dkjf']>0 ? $data['dkjf'] : 0;

        if($data['eid']){
            
            $eid        =   intval($data['eid']);
            
            $paytype    =   $data['paytype'] ? $data['paytype'] : '';

            if (!in_array('downresume', $this->onlyPrice)) {
                if ($this->config['com_integral_online'] == 1) {

                    $dkjf = $data['dkjf'] ? intval($data['dkjf']) : '';         //  抵扣积分

                } elseif ($this->config['com_integral_online'] == 3) {

                    $jifen = $data['price_int'] ? intval($data['price_int']) : ''; // 充值积分
                }
            }
            $statis     =   $this -> getStatisInfo($uid,array('usertype' => $usertype, 'field'=>'`integral`'));
            
            //判断简历ID真实性
            $expect     =   $this -> select_once('resume_expect', array('id' => $eid), '`id`,`uid`,`height_status`');
            
            $resume     =   $this -> select_once('resume', array('uid' => $expect['uid'], 'r_status' => 1), '`uid`,`name`,`telphone`,`telhome`,`email`');
            
            $resume['id']   =   $expect['id'];
            
            $couponid   =   intval($data['coupon_id']);
            
            if(empty($resume)){
                
                $return['error']    =   '请选择正确的简历下载';
                
            }else {
                
                //计算需付费金额
                require_once('resume.model.php');
                
                $resumeM    =   new resume_model($this->db,$this->def);
                
                $price      =   $resumeM->setDayprice($eid);
                
                /* 优惠券额度优先扣除 */
                $couponWhere=   array(
                    
                    'id'            =>  $couponid,
                    'uid'           =>  $uid,
                    'status'        =>  1,
                    'validity'      =>  array('>', time()),
                    'coupon_amount' =>  array('<', $price),
                    'coupon_scope'  =>  array('<=', $price)
                );
                
                $coupon     =   $this->select_once('coupon_list', $couponWhere);
                
                if ($coupon && is_array($coupon)) {
                    
                    $price  =   ceil($price - $coupon['coupon_amount']);    //  扣除优惠券额度后
                }
                
                if ($dkjf) {
                    
                    $dkjf   =	$dkjf >= intval($statis['integral']) ? $statis['integral'] : $dkjf;
                    $price  =   $price - $dkjf / $this->config['integral_proportion'];
                }
                
                if ($jifen) {
                    
                    $resume_integral    =   $price * $this->config['integral_proportion'];  //  下载简历所需积分
                    $integral_min       =   $this -> config['integral_min_recharge'];       //  站点最低充值积分
                    
                    if (($jifen + intval($statis['integral'])) <  intval($resume_integral)) {
                        
                        $return['error']    =   '充值'.$this->config['integral_pricename'].'不足购买下载简历，请重新输入'.$this->config['integral_pricename'].'数量！';
                        return $return;
                    }else if ($jifen < intval($integral_min)) {
                        
                        $return['error']    =   '最低充值'.$this->config['integral_pricename'].'不低于'.$integral_min;
                        return $return;
                    }
                    
                    $price  =   $jifen  /  $this->config['integral_proportion'];
                    
                }
                
                 
                $price  =  sprintf('%.2f', $price);
                
                if ($price < 0.01){
                    
                    $return['error'] = '购买总金额不得小于0.01元！';
                    
                } else {
                    //生成相关订单
                    $dingdan					=	time().rand(10000,99999);
                    $orderData                  =   array();
                    $orderData['type']			=	'19';//19 下载简历
                    $orderData['order_id']		=	$dingdan;
                    $orderData['order_type']	=	$paytype;
                    $orderData['order_price']	=	$price;
                    $orderData['integral']	    =	$jifen ? $jifen : '';
                    $orderData['order_dkjf']    =	$dkjf ? $dkjf : '';
                    $orderData['coupon']	    =	$couponid ? $couponid : '';
                    $orderData['order_time']	=	time();
                    $orderData['order_state']	=	'1';
                    
                    $orderData['order_remark']	=	$jifen ? '充值'.$this->config['integral_pricename'].'下载简历':'下载简历';
                    
                    $orderData['order_remark']	.=	$dkjf ? ', '.$this->config['integral_pricename'].'抵扣金额'.round(($dkjf / $this->config['integral_proportion']), 2).'元' : '';
                    
                    $orderData['order_remark']	.=	$coupon ? ', 使用优惠券'.$coupon['coupon_amount'].'元' : '';
                    
                    $orderData['uid']			=	$uid;
					$orderData['usertype']		=	$usertype;
                    $orderData['did']			=	$did;
                    $orderData['sid']			=	$eid; // type=19 sid=eid下载简历id

                    if ($data['crm_uid']){
                        $orderData['crm_uid']   =   $data['crm_uid'];
                    }
                     
                    if ($jifen) {
                        
                        $orderData['order_info']	=	serialize(array('eid'=>$eid,'resume_integral'=>$resume_integral,'uid'=>$uid));
                    }else{
                        
                        $orderData['order_info']	=	serialize(array('eid'=>$eid,'price'=>$price,'uid'=>$uid));
                    }
                    
                    $id  =   $this -> addOrder($orderData);
                    
                    if ($id) {
                        
                        require_once('integral.model.php');
                        
                        $integral  =   new integral_model($this->db,$this->def);
                        
                        if ($coupon) {
                            
                            $this -> upCouponList(array('id' => $couponid, 'uid' => $uid), array('status' => 2, 'xf_time'=>time()));   //  更新优惠券状态 2 已使用
                            
                            $integral -> company_invtal($uid, $usertype, $coupon['coupon_amount'], false, '购买简历下载，使用优惠券', true, 2, 'yhq', 12, $data['eid'], $couponid);
                        }
                        
                        if ($dkjf) {
                            
                            $integral -> company_invtal($uid, $usertype, $dkjf, false, '简历下载，使用'.$this->config['integral_pricename'].'抵扣',true, 2, 'integral', 12, $data['eid']);
                        }

                        $orderData['id']    =   $id;
                        
                        $return['order']    =   $orderData;
                    }else {
                        
                        $return['error']    =   '订单生成失败！';
                    }
                }
            }
             
        } else {
            $return['error'] = '参数错误，请重新设置！';
        }
        
        return $return;
    }
    
    /**
     * @desc    购买职位发布
     * @param   array $data
     * @return  array $return
     */
    function buyIssueJob($data)
    {
        
        $uid        =   intval($data['uid']);
        $usertype   =   intval($data['usertype']);
        $username   =   trim($data['username']);
        $did        =   $data['did'] ? $data['did'] : $this->config['did'];
        
        $return     =   array();
        
        $paytype    =   $data['paytype'] ? $data['paytype'] : '';

		$data['dkjf'] = $data['dkjf']>0 ? $data['dkjf'] : 0;

        if (!in_array('issuejob', $this->onlyPrice)) {
            if ($this->config['com_integral_online'] == 1) {

                $dkjf = $data['dkjf'] ? intval($data['dkjf']) : ''; //  抵扣积分

            } elseif ($this->config['com_integral_online'] == 3) {

                $jifen = $data['price_int'] ? intval($data['price_int']) : '';   // 充值积分
            }
        }
        $statis     =   $this -> getStatisInfo($uid,array('usertype' => $usertype, 'field'=>'`integral`'));
        
        $couponid   =   intval($data['coupon_id']);
        
        // 计算需付费金额
        $price      =   $this->config['integral_job']; // 购买职位发布所需金额
        
        /* 优惠券额度优先扣除 */
        $couponWhere=   array(
            
            'id'            =>  $couponid,
            'uid'           =>  $uid,
            'status'        =>  1,
            'validity'      =>  array('>', time()),
            'coupon_amount' =>  array('<', $price),
            'coupon_scope'  =>  array('<=', $price)
        );
        
        $coupon     =   $this->select_once('coupon_list', $couponWhere);
        
        if ($coupon && is_array($coupon)) {
            
            $price  =   ceil($price - $coupon['coupon_amount']);            //  扣除优惠券额度后
        }
        
        if ($dkjf) {
            
            $dkjf   =	$dkjf >= intval($statis['integral']) ? $statis['integral'] : $dkjf;
            
            
            $price  =   $price - $dkjf / $this->config['integral_proportion'];
        }
        
        if ($jifen) {
            
            $issue_integral         =   $price * $this->config['integral_proportion'];  //  职位发布所需积分
            $integral_min           =   $this -> config['integral_min_recharge'];       //  站点最低充值积分
            
            if (($jifen + intval($statis['integral'])) <  intval($issue_integral)) {
                
                $return['error']    =   '充值'.$this->config['integral_pricename'].'不足购买职位发布，请重新输入'.$this->config['integral_pricename'].'数量！';
                return $return;
            }else if ($jifen < intval($integral_min)) {
                
                $return['error']    =   '最低充值'.$this->config['integral_pricename'].'不低于'.$integral_min;
                return $return;
            }
            
            $price  =   $jifen  /  $this->config['integral_proportion'];
            
        }
        
        $price      =   sprintf("%.2f", $price);
        
        if ($price < 0.01) {
            
            $return['error']    =   '购买总金额不得小于0.01元！';
        } else {
            
            //生成相关订单
            $dingdan					=	time().rand(10000,99999);
            $orderData                  =   array();
            $orderData['type']			=	$usertype == 2 ? '20' : '22';
            $orderData['order_id']		=	$dingdan;
            $orderData['order_type']	=	$paytype;
            $orderData['order_price']	=	$price;
            $orderData['order_time']	=	time();
            $orderData['order_state']	=	'1';
            
            $orderData['order_remark']	=	$jifen ? '充值'.$this->config['integral_pricename'].'购买职位发布' : '发布职位';
            
            $orderData['order_remark']	.=	$dkjf ? ', '.$this->config['integral_pricename'].'抵扣金额'.round(($dkjf / $this->config['integral_proportion']), 2).'元' : '';
            
            $orderData['order_remark']	.=	$coupon ? ', 使用优惠券'.$coupon['coupon_amount'].'元' : '';
            
            $orderData['uid']			=	$uid;
            $orderData['usertype']		=	$usertype;
            $orderData['did']			=	$did;
            
            $orderData['integral']	    =	$jifen ? $jifen : '';
            $orderData['order_dkjf']    =   $dkjf ? $dkjf : '';
            $orderData['coupon']        =   $couponid ? $couponid : '';

            if ($data['crm_uid']){
                $orderData['crm_uid']   =   $data['crm_uid'];
            }
            
            if ($jifen) {
                
                $orderData['order_info']	=	serialize(array('issue_integral' => $issue_integral, 'price' => $price));
            }
            
            $id =   $this->addOrder($orderData);
            
            if ($id) {
                
                require_once ('integral.model.php');
                $integral   =   new integral_model($this->db, $this->def, array('uid' => $uid, 'username' => $username, 'usertype' => $usertype));
                
                if ($coupon) {  //  更改优惠券使用状态
                    
                    $this -> upCouponList(array('id' => $couponid, 'uid' => $uid), array('status' => 2, 'xf_time'=>time()));   //  更新优惠券状态 2 已使用
                    
                    $integral -> company_invtal($uid, $usertype, $coupon['coupon_amount'], false, '购买职位发布，使用优惠券', true, 2, 'yhq', 12, '', $couponid);
                }
                
                if ($dkjf) {
                    $integral -> company_invtal($uid, $usertype, $dkjf, false, '购买职位发布，使用'.$this->config['integral_pricename'].'抵扣', true, 2, 'integral', 12);
                }
                
                
                $orderData['id']    =   $id;
                $return['order']    =   $orderData;
                
            }else{
                
                $return['error']    =   '订单生成失败！';
            }
        }
        return $return;
    }
     
    /**
     * @desc    购买面试邀请
     * @param   array $data
     * @return  array $return
     */
    function buyInviteResume($data){
        
        $uid        =   intval($data['uid']);
        $usertype   =   intval($data['usertype']);
        $username   =   trim($data['username']);
        $did        =   $data['did'] ? $data['did'] : $this -> config['did'];
        
        $return     =   array();
        
        $paytype    =   $data['paytype'] ? $data['paytype'] : '';

		$data['dkjf'] = $data['dkjf']>0 ? $data['dkjf'] : 0;

        if (!in_array('invite', $this->onlyPrice)) {
            if ($this->config['com_integral_online'] == 1) {

                $dkjf = $data['dkjf'] ? intval($data['dkjf']) : '';         //  抵扣积分

            } elseif ($this->config['com_integral_online'] == 3) {

                $jifen = $data['price_int'] ? intval($data['price_int']) : ''; // 充值积分
            }
        }
        $statis     =   $this -> select_once('company_statis',array('uid' => $uid),'`integral`');
        
        //计算需付费金额
        $price      =   $this->config['integral_interview'];
        
        $couponid   =   intval($data['coupon_id']);
        
        /* 优惠券额度优先扣除 */
        $couponWhere=   array(
            
            'id'            =>  $couponid,
            'uid'           =>  $uid,
            'status'        =>  1,
            'validity'      =>  array('>', time()),
            'coupon_amount' =>  array('<', $price),
            'coupon_scope'  =>  array('<=', $price)
        );
        
        $coupon     =   $this->select_once('coupon_list', $couponWhere);
        
        if ($coupon && is_array($coupon)) {
            
            $price  =   ceil($price - $coupon['coupon_amount']);    //  扣除优惠券额度后
        }
        
        if ($dkjf) {
            
            $dkjf   =	$dkjf >= intval($statis['integral']) ? $statis['integral'] : $dkjf;
            $price  =   $price - $dkjf / $this->config['integral_proportion'];
        }
        
        if ($jifen) {
            
            $invite_integral    =   $price * $this->config['integral_proportion'];  //  邀请面试所需积分
            $integral_min       =   $this -> config['integral_min_recharge'];       //  站点最低充值积分
            
            if (($jifen + intval($statis['integral'])) <  intval($invite_integral)) {
                
                $return['error']    =   '充值'.$this->config['integral_pricename'].'不足购买邀请面试，请重新输入'.$this->config['integral_pricename'].'数量！';
                return $return;
            }else if ($jifen < intval($integral_min)) {
                
                $return['error']    =   '最低充值'.$this->config['integral_pricename'].'不低于'.$integral_min;
                return $return;
            }
            
            $price  =   $jifen  /  $this->config['integral_proportion'];
            
        }
        
        $price  =  sprintf('%.2f', $price);
        
        if ($price < 0.01){
            
            $return['error'] = '购买总金额不得小于0.01元！';
        } else {
            
            // 生成相关订单
            $dingdan                    =   time().rand(10000,99999);
            $orderData                  =   array();
            $orderData['type']          =   '23';
            $orderData['order_id']      =   $dingdan;
            $orderData['order_type']    =   $paytype;
            $orderData['integral']	    =	$jifen ? $jifen : '';
            $orderData['order_dkjf']    =   $dkjf ? $dkjf : '';
            $orderData['coupon']        =   $couponid ? $couponid : '';
            $orderData['order_price']   =   $price;
            $orderData['order_time']    =   time();
            $orderData['order_state']   =   '1';
            
            $orderData['order_remark']  =   $jifen ? '充值'.$this->config['integral_pricename'].'购买面试邀请' : '面试邀请';
            
            $orderData['order_remark']	.=	$dkjf ? ', '.$this->config['integral_pricename'].'抵扣金额'.round(($dkjf / $this->config['integral_proportion']), 2).'元' : '';
            
            $orderData['order_remark']	.=	$coupon ? ', 使用优惠券'.$coupon['coupon_amount'].'元' : '';
            
            $orderData['uid']           =   $uid;
            $orderData['usertype']		=	$usertype;
            $orderData['did']           =   $did;

            if ($data['crm_uid']){
                $orderData['crm_uid']   =   $data['crm_uid'];
            }
            
            if ($jifen) {
                $orderData['order_info']=   serialize(array('invite_integral'=>$invite_integral,'uid'=>$uid));
            }
            
            $id =   $this -> addOrder($orderData);
            
            if ($id) {
                require_once('integral.model.php');
                $integral   =   new integral_model($this->db,$this->def,array('uid'=>$uid,'username'=>$username,'usertype'=>$usertype));
                
                if ($coupon) {
                    
                    $this -> upCouponList(array('id' => $couponid, 'uid' => $uid), array('status' => 2, 'xf_time'=>time()));   //  更新优惠券状态 2 已使用
                    
                    $integral -> company_invtal($uid, $usertype, $coupon['coupon_amount'], false, '购买邀请面试，使用优惠券 ', true, 2, 'yhq',12, '', $couponid);
                }
                
                if($dkjf){
                    
                    $integral -> company_invtal($uid, $usertype, $dkjf, false, '购买面试邀请，使用'.$this->config['integral_pricename'].'抵扣', true, 2, 'integral', 12);
                    
                }
                
                $orderData['id']    =   $id;
                $return['order']    =   $orderData;
                
            }else{
                
                $return['error']    =   '订单生成失败！';
            }
        }
        
        return $return;
    }
    /**
     * 购买职位刷新
     *
     * @param array $data
     * @return array $return
     */
    function buyRefreshLtJob($data)
    {
        $uid        =   intval($data['uid']);
        $usertype   =   intval($data['usertype']);
        $username   =   trim($data['username']);
        $did        =   $data['did'] ? $data['did'] : $this -> config['did'];
        
        $return     =   array();

		$data['dkjf'] = $data['dkjf']>0 ? $data['dkjf'] : 0;
        
        if ($data['sxltjobid']) {
            
            $jobid  =   pylode(',', @explode(',', $data['sxltjobid']));
            
            $paytype    =   $data['paytype'] ? $data['paytype'] : '';

            if (!in_array('sxjob', $this->onlyPrice)) {
                if ($this->config['com_integral_online'] == 1) {

                    $dkjf = $data['dkjf'] ? intval($data['dkjf']) : '';     //  抵扣积分

                } elseif ($this->config['com_integral_online'] == 3) {

                    $jifen = $data['price_int'] ? intval($data['price_int']) : '';   //  充值积分
                }
            }
            if ($jobid) {
                
                // 判断职位ID真实性
                $ltjobs =   $this->select_all('lt_job', array('uid' => $uid, 'id' => array('in', $jobid)), '`id`');
                
                if (empty($ltjobs)) {
                    
                    $return['error']    =   '请选择正确的职位刷新！';
                } else {
                    $field  =  '`integral`';
                    
                    if ($usertype == 2){
                        $field .= ',`breakjob_num`';
                    }elseif ($usertype == 3){
                        $field .= ',`lt_breakjob_num` AS `breakjob_num`';
                    }
                    
                    $statis     =   $this -> getStatisInfo($uid,array('usertype' => $usertype, 'field'=>$field));
                    
                    $neednum    =   $this->select_num('lt_job', array('uid' => $uid, 'id' => array('in', $jobid))); // 计算刷新职位数量
                    
                    $couponid   =   intval($data['coupon_id']);
                    
                    $breakjob_num  =   intval($statis['breakjob_num']);
                    // 扣除套参数操作（会员套餐未用完，优先扣除套餐）
                    $ltjobnum   =   $neednum - $breakjob_num;
                    
                    // 计算需付费金额
                    $price  =   $this->config['integral_jobefresh'] * $ltjobnum; // 购买刷新职位所需金额
                    
                    /* 优惠券额度优先扣除 */
                    $couponWhere=   array(
                        
                        'id'            =>  $couponid,
                        'uid'           =>  $uid,
                        'status'        =>  1,
                        'validity'      =>  array('>', time()),
                        'coupon_amount' =>  array('<', $price),
                        'coupon_scope'  =>  array('<=', $price)
                    );
                    
                    $coupon     =   $this->select_once('coupon_list', $couponWhere);
                    
                    if ($coupon && is_array($coupon)) {
                        
                        $price  =   ceil($price - $coupon['coupon_amount']);    //  扣除优惠券额度后
                    }
                    
                    if ($dkjf) {
                        
                        $dkjf   =	$dkjf >= intval($statis['integral']) ? $statis['integral'] : $dkjf;
                        $price  =   $price - $dkjf / $this->config['integral_proportion'];
                    }
                    
                    if ($jifen) {
                        
                        $sxltjob_integral       =   $price * $this->config['integral_proportion'];  //  刷新职位所需积分
                        $integral_min           =   $this -> config['integral_min_recharge'];       //  站点最低充值积分
                        
                        if (($jifen + intval($statis['integral'])) <  intval($sxltjob_integral)) {
                            
                            $return['error']    =   '充值'.$this->config['integral_pricename'].'不足购买职位刷新，请重新输入'.$this->config['integral_pricename'].'数量！';
                            return $return;
                        }else if ($jifen < intval($integral_min)) {
                            
                            $return['error']    =   '最低充值'.$this->config['integral_pricename'].'不低于'.$integral_min;
                            return $return;
                        }
                        
                        $price  =   $jifen  /  $this->config['integral_proportion'];
                        
                    }
                    
                    $price  =   sprintf("%.2f", $price);
                    
                    if ($price < 0.01) {
                        
                        $return['error'] = '购买总金额不得小于0.01元！';
                    } else {
                        
                        //生成相关订单
                        $dingdan					=	time().rand(10000,99999);
                        $orderData                  =   array();
                        $orderData['type']			=	'18';
                        $orderData['order_id']		=	$dingdan;
                        $orderData['order_type']	=	$paytype;
                        $orderData['order_price']	=	$price;
                        $orderData['integral']	    =	$jifen ? $jifen : '';
                        $orderData['order_dkjf']    =	$dkjf ? $dkjf : '';
                        $orderData['coupon']	    =	$couponid ? $couponid : '';
                        $orderData['order_time']	=	time();
                        $orderData['order_state']	=	'1';
                        
                        $orderData['order_remark']	=	$jifen ? '充值'.$this->config['integral_pricename'].'购买猎头职位刷新' : '刷新猎头职位';
                        
                        $orderData['order_remark']	.=	$dkjf ? ', '.$this->config['integral_pricename'].'抵扣金额'.round(($dkjf / $this->config['integral_proportion']), 2).'元' : '';
                        
                        $orderData['order_remark']	.=	$coupon ? ', 使用优惠券'.$coupon['coupon_amount'].'元' : '';
                        
                        $orderData['uid']			=	$uid;
                        $orderData['usertype']		=	$usertype;
                        $orderData['did']			=	$did;

                        if ($data['crm_uid']){
                            $orderData['crm_uid']   =   $data['crm_uid'];
                        }

                        if ($jifen) {
                            
                            $orderData['order_info']	=	serialize(array('jobid' => $data['sxltjobid'], 'breakjob_num' => $breakjob_num ? $breakjob_num : 0, 'sxltjob_integral' => $sxltjob_integral, 'price' => $price));
                        }else {
                            
                            $orderData['order_info']	=	serialize(array('jobid' => $data['sxltjobid'], 'breakjob_num' => $breakjob_num ? $breakjob_num : 0, 'price' => $price));
                        }
                        
                        $id = $this->addOrder($orderData);
                        
                        if ($id) {
                            
                            if ($breakjob_num) {
                                
                                if ($usertype == 2){
                                    $this->update_once('company_statis', array('breakjob_num' => '0'), array('uid' => $uid));
                                }elseif ($usertype == 3){
                                    $this->update_once('lt_statis', array('lt_breakjob_num' => '0'), array('uid' => $uid));
                                }
                            }
                            
                            require_once ('integral.model.php');
                            
                            $integral = new integral_model($this->db, $this->def, array('uid' => $uid, 'username' => $username, 'usertype' => $usertype));
                            
                            if ($coupon) {  //  更改优惠券使用状态
                                
                                $this -> upCouponList(array('id' => $couponid, 'uid' => $uid), array('status' => 2, 'xf_time'=>time()));   //  更新优惠券状态 2 已使用
                                
                                $integral -> company_invtal($uid, $usertype, $coupon['coupon_amount'], false, '购买猎头职位刷新，使用优惠券', true, 2, 'yhq', 12, '', $couponid);
                            }
                            
                            if ($dkjf) {
                                
                                $integral->company_invtal($uid, $usertype, $dkjf, false, "购买猎头职位刷新，使用".$this->config['integral_pricename']."抵扣", true, 2, 'integral', 12);
                            }
                            
                            $orderData['id']    =   $id;
                            $return['order']    =   $orderData;
                            
                        }else {
                            
                            $return['error']    =   '订单生成失败！';
                        }
                    }
                }
            } else {
                $return['error'] = '请正确选择职位刷新！';
            }
        } else {
            
            $return['error'] = '参数填写错误，请重新设置！';
        }
        
        return $return;
    }
    
    //购买招聘会次数
    function buyZph($data = array()){
        
        $uid        =   intval($data['uid']);
        $usertype   =   intval($data['usertype']);
        $username   =   trim($data['username']);
        
        $did        =   !empty($data['did']) ? $data['did'] : $this -> config['did'];
        
        $return     =   array();

        $data['dkjf'] = $data['dkjf']>0 ? $data['dkjf'] : 0;

        if($data['zid'] && $data['bid']){
            
            $zid        =   intval($data['zid']);
            $bid        =   intval($data['bid']);
            $paytype    =   !empty($data['paytype']) ? $data['paytype'] : '';

            if (!in_array('zph', $this->onlyPrice)) {
                if ($this->config['com_integral_online'] == 1) {

                    $dkjf = !empty($data['dkjf']) ? intval($data['dkjf']) : '';         //  抵扣积分

                } elseif ($this->config['com_integral_online'] == 3) {

                    $jifen = !empty($data['price_int']) ? intval($data['price_int']) : ''; // 充值积分
                }
            }
            
            $statis     =   $this -> getStatisInfo($uid,array('usertype' => $usertype, 'field'=>'`integral`'));
            
            //判断招聘会id真实性
            $zph        =   $this -> select_once('zhaopinhui', array('id' => $zid), '`id`');
            $space      =   $this -> select_once('zhaopinhui_space', array('id' => $bid));
            $sid        =   $this -> select_once('zhaopinhui_space', array('id' => $space['keyid']));
            
            if(empty($zph) || empty($space)){
                
                $return['error']  =  '参数错误，请重新预定！';
                
            }else {
                
                $price      =  round(($space['price'] / $this->config['integral_proportion']), 2);
                
                $couponid   =   intval($data['coupon_id']);
                
                /* 优惠券额度优先扣除 */
                $couponWhere=   array(
                    
                    'id'            =>  $couponid,
                    'uid'           =>  $uid,
                    'status'        =>  1,
                    'validity'      =>  array('>', time()),
                    'coupon_amount' =>  array('<', $price),
                    'coupon_scope'  =>  array('<=', $price)
                );
                
                $coupon     =   $this->select_once('coupon_list', $couponWhere);
                
                if ($coupon && is_array($coupon)) {
                    
                    $price  =   ceil($price - $coupon['coupon_amount']);    //  扣除优惠券额度后
                }
                
                if ($dkjf) {
                    
                    $dkjf   =	$dkjf >= intval($statis['integral']) ? $statis['integral'] : $dkjf;
                    $price  =   $price - $dkjf / $this->config['integral_proportion'];
                }
                
                if ($jifen) {
                    $com           =  $this -> select_once('company', array('uid' => $uid), '`name`');
                    $zph_integral  =  $price * $this->config['integral_proportion'];  //  预定招聘会所需积分
                    $integral_min  =  $this -> config['integral_min_recharge'];       //  站点最低充值积分
                    
                    if (($jifen + intval($statis['integral'])) <  intval($zph_integral)) {
                        
                        $return['error']  =  '充值'.$this->config['integral_pricename'].'不足预定招聘会，请重新输入'.$this->config['integral_pricename'].'数量！';
                        return $return;
                    }else if ($jifen < intval($integral_min)) {
                        
                        $return['error']  =  '最低充值'.$this->config['integral_pricename'].'不低于'.$integral_min;
                        return $return;
                    }
                    
                    $price  =  $jifen  /  $this->config['integral_proportion'];
                    
                }
                
                $price  =  sprintf('%.2f', $price);
    			 
                if ($price < 0.01){
                    
                    $return['error']  =  '购买总金额不得小于0.01元！';
                } else {

                    //生成相关订单
                    $dingdan					 =	time().rand(10000,99999);
                    $orderData                   =  array();
                    $orderData['type']			 =	'28';
                    $orderData['order_id']		 =	$dingdan;
                    $orderData['order_type']     =	$paytype;
                    $orderData['order_price']    =	$price;
                    $orderData['integral']	     =	$jifen ? $jifen : '';
                    $orderData['coupon']	     =	$couponid ? $couponid : '';
                    $orderData['order_dkjf']     =	$dkjf ? $dkjf : '';
                    $orderData['order_time']     =	time();
                    $orderData['order_state']    =	'1';
                    
                    $orderData['order_remark']   =	$jifen ? '充值'.$this->config['integral_pricename'].'预定招聘会' :'预定招聘会';
                    
                    $orderData['order_remark']	.=	$dkjf ? ', '.$this->config['integral_pricename'].'抵扣金额'.round(($dkjf / $this->config['integral_proportion']), 2).'元' : '';
                    
                    $orderData['order_remark']	.=	$coupon ? ', 使用优惠券'.$coupon['coupon_amount'].'元' : '';
                    
                    $orderData['uid']            =	$uid;
					$orderData['usertype']		 =	$usertype;
                    $orderData['did']            =	$did;

                    if ($data['crm_uid']){
                        $orderData['crm_uid']   =   $data['crm_uid'];
                    }
                    
                    $order_info  =  array(
                        'uid'       =>  $uid,
                        'com_name'  =>  $com['name'],
                        'zid'       =>  $zid ,'bid'=> $bid,
                        'sid'       =>  $sid['keyid'],
                        'cid'       =>  $space['keyid']
                    );
                    if($jifen){
                        $order_info['zph_integral']  =  $zph_integral;
                    }
                    // 参会职位处理
                    if (!empty($data['jobid'])){
                        // pc
                        $order_info['jobid']  =   $data['jobid'];
                        
                    }elseif (!empty($_COOKIE['zphjobid'])){
                        // wap
                        $order_info['jobid']  =   $_COOKIE['zphjobid'];
                    }
                    
                    $orderData['order_info']  =  serialize($order_info);
                    
                    $id     =   $this->addOrder($orderData);
                    
                    if ($id) {
                        
                        require_once('integral.model.php');
                        
                        $integral  =  new integral_model($this->db,$this->def,array('uid'=>$uid,'username'=>$username,'usertype'=>$usertype));
                        
                        if ($coupon) {
                            
                            $this -> upCouponList(array('id' => $couponid, 'uid' => $uid), array('status' => 2, 'xf_time'=>time()));   //  更新优惠券状态 2 已使用
                            
                            $integral -> company_invtal($uid, $usertype, $coupon['coupon_amount'], false, '报名招聘会，使用优惠券', true, 2, 'yhq', 14, '', $couponid);
                        }
                        
                        if($dkjf){
                            
                            $integral -> company_invtal($uid, $usertype, $dkjf, false, '报名招聘会，使用'.$this->config['integral_pricename'].'抵扣', true, 2, 'integral');
                        }
                        
                        $orderData['id']  =  $id;
                        
                        $return['order']  =  $orderData;
                        
                    }else {
                        
                        $return['error']  =  '订单生成失败！';
                    }
                    
                }
            }
        }else{
            $return['error'] = '参数填写错误，请重新设置！';
        }
        return $return;
    }
    
    /**
     * 购买创建子账号
     * 2019-07-04
     */
    function buyCreateSon($data = array())
    {
        
        $uid        =   intval($data['uid']);
        $usertype   =   intval($data['usertype']);
        $username   =   trim($data['username']);
        $did        =   $data['did'] ? $data['did'] : $this -> config['did'];
        
        $return     =   array();
        
        $paytype    =   $data['paytype'] ? $data['paytype'] : '';

		$data['dkjf'] = $data['dkjf']>0 ? $data['dkjf'] : 0;

        if (!in_array('createson', $this->onlyPrice)) {
            if ($this->config['com_integral_online'] == 1) {

                $dkjf = $data['dkjf'] ? intval($data['dkjf']) : '';             //  抵扣积分

            } elseif ($this->config['com_integral_online'] == 3) {

                $jifen = $data['price_int'] ? intval($data['price_int']) : '';   // 充值积分
            }
        }
        $statis     =   $this -> getStatisInfo($uid,array('usertype' => $usertype, 'field'=>'`integral`'));
        
        // 计算需付费金额
        $price      =   $this->config['integral_sons_num'];                     // 购买子账号所需金额
        
        $couponid   =   intval($data['coupon_id']);
        
        /* 优惠券额度优先扣除 */
        $couponWhere  =   array(
            
            'id'            =>  $couponid,
            'uid'           =>  $uid,
            'status'        =>  1,
            'validity'      =>  array('>', time()),
            'coupon_amount' =>  array('<', $price),
            'coupon_scope'  =>  array('<=', $price)
        );
        
        $coupon     =   $this->select_once('coupon_list', $couponWhere);
        
        if ($coupon && is_array($coupon)) {
            
            $price  =   ceil($price - $coupon['coupon_amount']);    //  扣除优惠券额度后
        }
        
        if ($dkjf) {
            
            $dkjf   =	$dkjf >= intval($statis['integral']) ? $statis['integral'] : $dkjf;
            $price  =   $price - $dkjf / $this->config['integral_proportion'];
        }
        
        if ($jifen) {
            
            $son_integral           =   $price * $this->config['integral_proportion'];  //  子账号所需积分
            $integral_min           =   $this -> config['integral_min_recharge'];       //  站点最低充值积分
            
            if (($jifen + intval($statis['integral'])) <  intval($son_integral)) {
                
                $return['error']    =   '充值'.$this->config['integral_pricename'].'不足购买子账号，请重新输入'.$this->config['integral_pricename'].'数量！';
                return $return;
            }else if ($jifen < intval($integral_min)) {
                
                $return['error']    =   '最低充值'.$this->config['integral_pricename'].'不低于'.$integral_min;
                return $return;
            }
            
            $price  =   $jifen  /  $this->config['integral_proportion'];
            
        }
        
        $price      =   sprintf("%.2f", $price);
        
        if (bccomp($price, 0.01, 2) == - 1) {
            
            $return['error']    =   '购买总金额不得小于0.01元！';
        } else {
            
            //生成相关订单
            $dingdan					=	time().rand(10000,99999);
            $orderData                  =   array();
            $orderData['type']			=	'27';    // 子账号购买
            $orderData['order_id']		=	$dingdan;
            $orderData['order_type']	=	$paytype;
            $orderData['order_price']	=	$price;
            $orderData['integral']	    =	$jifen ? $jifen : '';
            $orderData['coupon']	    =	$couponid ? $couponid : '';
            $orderData['order_dkjf']    =	$dkjf ? $dkjf : '';
            $orderData['order_time']	=	time();
            $orderData['order_state']	=	'1';
            $orderData['order_remark']	=	$jifen ? '充值'.$this->config['integral_pricename'].'购买子账号' : '子账号购买';
            
            $orderData['order_remark']	.=	$dkjf ? ', '.$this->config['integral_pricename'].'抵扣金额'.round(($dkjf / $this->config['integral_proportion']), 2).'元' : '';
            
            $orderData['order_remark']	.=	$coupon ? ', 使用优惠券'.$coupon['coupon_amount'].'元' : '';
            
            $orderData['uid']			=	$uid;
            $orderData['usertype']		=	$usertype;
            $orderData['did']			=	$did;

            if ($data['crm_uid']){
                $orderData['crm_uid']   =   $data['crm_uid'];
            }
            
            if ($jifen) {
                
                $orderData['order_info']	=	serialize(array('son_integral' => $son_integral, 'uid' => $data['uid'], 'price' => $price));
            }else{
                
                $orderData['order_info']	=	serialize(array('uid' => $data['uid'], 'price' => $price));
            }
            
            $id     =   $this->addOrder($orderData);
            
            if ($id) {
                require_once ('integral.model.php');
                $integral   =   new integral_model($this->db, $this->def, array('uid' => $uid, 'username' => $username, 'usertype' => $usertype));
                
                if ($coupon) {
                    
                    $this -> upCouponList(array('id' => $couponid, 'uid' => $uid), array('status' => 2, 'xf_time'=>time()));   //  更新优惠券状态 2 已使用
                    
                    $integral -> company_invtal($uid, $usertype, $coupon['coupon_amount'], false, '购买子账号，使用优惠券', true, 2, 'yhq', 37, '', $couponid);
                }
                
                if ($dkjf) {
                    
                    $integral -> company_invtal($uid, $usertype, $dkjf, false, '购买子账号', true, 2, 'integral', 37);
                }
                
                $orderData['id']    =   $id;
                $return['order']    =   $orderData;
            }else{
                
                $return['error']    =   '订单生成失败！';
            }
        }
        
        return $return;
    }
    /**
     * 购买聊天数量
     */
    function buyChat($data = array())
    {
        
        $uid       =  intval($data['uid']);
        $usertype  =  intval($data['usertype']);
        $username  =  trim($data['username']);
        $did       =  $data['did'] ? $data['did'] : $this -> config['did'];
        $return    =  array();
        $online    =  $this->config['com_integral_online'];

		$data['dkjf'] = $data['dkjf']>0 ? $data['dkjf'] : 0;
        
        if (!empty($data['chatid'])) {
            
            $paytype    =   $data['paytype'] ? $data['paytype'] : '';

            if (!in_array('chat', $this->onlyPrice)) {
                if ($online == 1) {

                    $dkjf = $data['dkjf'] ? intval($data['dkjf']) : '';             //  抵扣积分

                } elseif ($online == 3) {

                    $jifen = $data['price_int'] ? intval($data['price_int']) : '';   // 充值积分
                }
            }
            $statis     =   $this -> getStatisInfo($uid,array('usertype' => $usertype, 'field'=>'`integral`'));
            
            // 计算需付费金额
            $price      =   $this->config['integral_chat_num'];
            
            $couponid   =   intval($data['coupon_id']);
            
            /* 优惠券额度优先扣除 */
            $couponWhere  =   array(
                
                'id'            =>  $couponid,
                'uid'           =>  $uid,
                'status'        =>  1,
                'validity'      =>  array('>', time()),
                'coupon_amount' =>  array('<', $price),
                'coupon_scope'  =>  array('<=', $price)
            );
            
            $coupon     =   $this->select_once('coupon_list', $couponWhere);
            
            if ($coupon && is_array($coupon)) {
                
                $price  =   ceil($price - $coupon['coupon_amount']);    //  扣除优惠券额度后
            }
            
            $pro        =  $this->config['integral_proportion'];
            $jfmc       =  $this->config['integral_pricename'];
            $chat_name  =  $this->config['sy_chat_name'];
            
            if ($dkjf) {
                
                $dkjf   =	$dkjf >= intval($statis['integral']) ? $statis['integral'] : $dkjf;
                $price  =   $price - $dkjf / $pro;
            }
            
            if ($jifen) {
                
                $chat_integral           =   $price * $pro;  //  聊天数量所需积分
                $integral_min           =   $this -> config['integral_min_recharge'];       //  站点最低充值积分
                
                if (($jifen + intval($statis['integral'])) <  intval($chat_integral)) {
                    
                    $return['error']    =   '充值'.$jfmc.'不足购买'.$chat_name.'，请重新输入'.$jfmc.'数量！';
                    return $return;
                }else if ($jifen < intval($integral_min)) {
                    
                    $return['error']    =   '最低充值'.$jfmc.'不低于'.$integral_min;
                    return $return;
                }
                
                $price  =   $jifen  /  $pro;
                
            }
            
            $price      =   sprintf("%.2f", $price);
            
            if (bccomp($price, 0.01, 2) == - 1) {
                
                $return['error']    =   '购买总金额不得小于0.01元！';
            } else {
                
                //生成相关订单
                $dingdan					=	time().rand(10000,99999);
                $orderData                  =   array();
                $orderData['type']			=	'31';
                $orderData['order_id']		=	$dingdan;
                $orderData['order_type']	=	$paytype;
                $orderData['order_price']	=	$price;
                $orderData['integral']	    =	$jifen ? $jifen : '';
                $orderData['coupon']	    =	$couponid ? $couponid : '';
                $orderData['order_dkjf']    =	$dkjf ? $dkjf : '';
                $orderData['order_time']	=	time();
                $orderData['order_state']	=	'1';
                $orderData['order_remark']	=	$jifen ? '充值'.$jfmc.'购买'.$chat_name : $chat_name.'购买';
                
                $orderData['order_remark']	.=	$dkjf ? ', '.$jfmc.'抵扣金额'.round(($dkjf / $pro), 2).'元' : '';
                
                $orderData['order_remark']	.=	$coupon ? ', 使用优惠券'.$coupon['coupon_amount'].'元' : '';
                
                $orderData['uid']			=	$uid;
                $orderData['usertype']		=	$usertype;
                $orderData['did']			=	$did;

                if ($data['crm_uid']){
                    $orderData['crm_uid']   =   $data['crm_uid'];
                }
                
                if ($jifen) {
                    
                    $orderData['order_info']	=	serialize(array('chat_integral'=>$chat_integral,'uid'=>$data['chatid'],'comid'=>$uid,'usertype'=>$usertype,'price'=>$price));
                }else{
                    
                    $orderData['order_info']	=	serialize(array('uid'=>$data['chatid'],'comid'=>$uid,'usertype'=>$usertype,'price'=>$price));
                }
                
                $id     =   $this->addOrder($orderData);
                
                if ($id) {
                    require_once ('integral.model.php');
                    $integral   =   new integral_model($this->db, $this->def, array('uid' => $uid, 'username' => $username, 'usertype' => $usertype));
                    
                    if ($coupon) {
                        
                        $this -> upCouponList(array('id' => $couponid, 'uid' => $uid), array('status' => 2, 'xf_time'=>time()));   //  更新优惠券状态 2 已使用
                        
                        $integral -> company_invtal($uid, $usertype, $coupon['coupon_amount'], false, $chat_name.'购买，使用优惠券', true, 2, 'yhq', 27, '', $couponid);
                    }
                    
                    if ($dkjf) {
                        
                        $integral -> company_invtal($uid, $usertype, $dkjf, false, '购买'.$chat_name, true, 2, 'integral', 27);
                    }
                    
                    $orderData['id']    =   $id;
                    $return['order']    =   $orderData;
                }else{
                    
                    $return['error']    =   '订单生成失败！';
                }
            }
            
        }else {
            
            $return['error'] = '系统错误，请稍候重试！';
        }
        
        return $return;
    }
	/**
     * 购买视频面试
     */
    function buySpview($data = array())
    {
        
        $uid        =   intval($data['uid']);
        $usertype   =   intval($data['usertype']);
        $username   =   trim($data['username']);
        $did        =   $data['did'] ? $data['did'] : $this->config['did'];
        
        $return     =   array();
        
        $paytype    =   $data['paytype'] ? $data['paytype'] : '';

		$data['dkjf'] = $data['dkjf']>0 ? $data['dkjf'] : 0;

        if (!in_array('spview', $this->onlyPrice)) {
            if ($this->config['com_integral_online'] == 1) {

                $dkjf = $data['dkjf'] ? intval($data['dkjf']) : ''; //  抵扣积分

            } elseif ($this->config['com_integral_online'] == 3) {

                $jifen = $data['price_int'] ? intval($data['price_int']) : '';   // 充值积分
            }
        }
        $statis     =   $this -> getStatisInfo($uid,array('usertype' => $usertype, 'field'=>'`integral`'));
        
        $couponid   =   intval($data['coupon_id']);
        
        // 计算需付费金额
        $price      =   $this->config['integral_spview']; // 购买视频面试所需金额
        
        /* 优惠券额度优先扣除 */
        $couponWhere=   array(
            
            'id'            =>  $couponid,
            'uid'           =>  $uid,
            'status'        =>  1,
            'validity'      =>  array('>', time()),
            'coupon_amount' =>  array('<', $price),
            'coupon_scope'  =>  array('<=', $price)
        );
        
        $coupon     =   $this->select_once('coupon_list', $couponWhere);
        
        if ($coupon && is_array($coupon)) {
            
            $price  =   ceil($price - $coupon['coupon_amount']);            //  扣除优惠券额度后
        }
        
        if ($dkjf) {
            
            $dkjf   =	$dkjf >= intval($statis['integral']) ? $statis['integral'] : $dkjf;
            
            
            $price  =   $price - $dkjf / $this->config['integral_proportion'];
        }
        
        if ($jifen) {
            
            $issue_integral         =   $price * $this->config['integral_proportion'];  	
            $integral_min           =   $this -> config['integral_min_recharge'];       	
            
            if (($jifen + intval($statis['integral'])) <  intval($issue_integral)) {
                
                $return['error']    =   '充值'.$this->config['integral_pricename'].'不足购买视频面试，请重新输入'.$this->config['integral_pricename'].'数量！';
                return $return;
            }else if ($jifen < intval($integral_min)) {
                
                $return['error']    =   '最低充值'.$this->config['integral_pricename'].'不低于'.$integral_min;
                return $return;
            }
            
            $price  =   $jifen  /  $this->config['integral_proportion'];
            
        }
        
        $price      =   sprintf("%.2f", $price);
        
        if ($price < 0.01) {
            
            $return['error']    =   '购买总金额不得小于0.01元！';
        } else {
            
            //生成相关订单
            $dingdan					=	time().rand(10000,99999);
            $orderData                  =   array();
            $orderData['type']			=	'33';	// 视频面试
            $orderData['order_id']		=	$dingdan;
            $orderData['order_type']	=	$paytype;
            $orderData['order_price']	=	$price;
            $orderData['order_time']	=	time();
            $orderData['order_state']	=	'1';
            
            $orderData['order_remark']	=	$jifen ? '充值'.$this->config['integral_pricename'].'购买视频面试' : '添加视频面试';
            
            $orderData['order_remark']	.=	$dkjf ? ', '.$this->config['integral_pricename'].'抵扣金额'.round(($dkjf / $this->config['integral_proportion']), 2).'元' : '';
            
            $orderData['order_remark']	.=	$coupon ? ', 使用优惠券'.$coupon['coupon_amount'].'元' : '';
            
            $orderData['uid']			=	$uid;
            $orderData['usertype']		=	$usertype;
            $orderData['did']			=	$did;
            
            $orderData['integral']	    =	$jifen ? $jifen : '';
            $orderData['order_dkjf']    =   $dkjf ? $dkjf : '';
            $orderData['coupon']        =   $couponid ? $couponid : '';

            if ($data['crm_uid']){
                $orderData['crm_uid']   =   $data['crm_uid'];
            }
            
            if ($jifen) {
                
                $orderData['order_info']	=	serialize(array('issue_integral' => $issue_integral, 'price' => $price));
            }
            
            $id =   $this->addOrder($orderData);
            
            if ($id) {
                
                require_once ('integral.model.php');
                $integral   =   new integral_model($this->db, $this->def, array('uid' => $uid, 'username' => $username, 'usertype' => $usertype));
                
                if ($coupon) {  //  更改优惠券使用状态
                    
                    $this -> upCouponList(array('id' => $couponid, 'uid' => $uid), array('status' => 2, 'xf_time'=>time()));   //  更新优惠券状态 2 已使用
                    
                    $integral -> company_invtal($uid, $usertype, $coupon['coupon_amount'], false, '购买视频面试，使用优惠券', true, 2, 'yhq', 12, '', $couponid);
                }
                
                if ($dkjf) {
                    $integral -> company_invtal($uid, $usertype, $dkjf, false, '购买视频面试，使用'.$this->config['integral_pricename'].'抵扣', true, 2, 'integral', 12);
                }
                
                
                $orderData['id']    =   $id;
                $return['order']    =   $orderData;
                
            }else{
                
                $return['error']    =   '订单生成失败！';
            }
        }
        return $return;
    }
    /**
     * 购买网络招聘会次数
     */
    function buyZphnet($data = array()){
        
        $uid        =   intval($data['uid']);
        $usertype   =   intval($data['usertype']);
        $username   =   trim($data['username']);
        
        $did        =   !empty($data['did']) ? $data['did'] : $this -> config['did'];
        
        $return     =   array();

		$data['dkjf'] = $data['dkjf']>0 ? $data['dkjf'] : 0;
        
        if($data['zid']){
            
            $zid        =   intval($data['zid']);
            $paytype    =   !empty($data['paytype']) ? $data['paytype'] : '';

            if (!in_array('zphnet', $this->onlyPrice)) {
                if ($this->config['com_integral_online'] == 1) {

                    $dkjf = !empty($data['dkjf']) ? intval($data['dkjf']) : '';         //  抵扣积分

                } elseif ($this->config['com_integral_online'] == 3) {

                    $jifen = !empty($data['price_int']) ? intval($data['price_int']) : ''; // 充值积分
                }
            }
            $statis     =   $this -> getStatisInfo($uid,array('usertype' => $usertype, 'field'=>'`integral`'));
            
            //判断网络招聘会id真实性
            $zph        =   $this -> select_once('zphnet', array('id' => $zid), '`id`');
            
            if(empty($zph)){
                
                $return['error']  =  '参数错误，请重新预定！';
                
            }else {
                
                $price      =  $this->config['integral_zphnet'];
                
                $couponid   =  intval($data['coupon_id']);
                
                /* 优惠券额度优先扣除 */
                $couponWhere=   array(
                    
                    'id'            =>  $couponid,
                    'uid'           =>  $uid,
                    'status'        =>  1,
                    'validity'      =>  array('>', time()),
                    'coupon_amount' =>  array('<', $price),
                    'coupon_scope'  =>  array('<=', $price)
                );
                
                $coupon     =   $this->select_once('coupon_list', $couponWhere);
                
                if ($coupon && is_array($coupon)) {
                    
                    $price  =   ceil($price - $coupon['coupon_amount']);    //  扣除优惠券额度后
                }
                
                if ($dkjf) {
                    
                    $dkjf   =	$dkjf >= intval($statis['integral']) ? $statis['integral'] : $dkjf;
                    $price  =   $price - $dkjf / $this->config['integral_proportion'];
                }
                
                if ($jifen) {
                    $zph_integral  =  $price * $this->config['integral_proportion'];  //  预定网络招聘会所需积分
                    $integral_min  =  $this -> config['integral_min_recharge'];       //  站点最低充值积分
                    
                    if (($jifen + intval($statis['integral'])) <  intval($zph_integral)) {
                        
                        $return['error']  =  '充值'.$this->config['integral_pricename'].'不足预定招聘会，请重新输入'.$this->config['integral_pricename'].'数量！';
                        return $return;
                    }else if ($jifen < intval($integral_min)) {
                        
                        $return['error']  =  '最低充值'.$this->config['integral_pricename'].'不低于'.$integral_min;
                        return $return;
                    }
                    
                    $price  =  $jifen  /  $this->config['integral_proportion'];
                    
                }
                
                $price  =  sprintf('%.2f', $price);
                
                if ($price < 0.01){
                    
                    $return['error']  =  '购买总金额不得小于0.01元！';
                } else {
                    
                    //生成相关订单
                    $dingdan					 =	time().rand(10000,99999);
                    $orderData                   =  array();
                    $orderData['type']			 =	'32';
                    $orderData['order_id']		 =	$dingdan;
                    $orderData['order_type']     =	$paytype;
                    $orderData['order_price']    =	$price;
                    $orderData['integral']	     =	$jifen ? $jifen : '';
                    $orderData['coupon']	     =	$couponid ? $couponid : '';
                    $orderData['order_dkjf']     =	$dkjf ? $dkjf : '';
                    $orderData['order_time']     =	time();
                    $orderData['order_state']    =	'1';
                    
                    $orderData['order_remark']   =	$jifen ? '充值'.$this->config['integral_pricename'].'预定网络招聘会' :'预定网络招聘会';
                    
                    $orderData['order_remark']	.=	$dkjf ? ', '.$this->config['integral_pricename'].'抵扣金额'.round(($dkjf / $this->config['integral_proportion']), 2).'元' : '';
                    
                    $orderData['order_remark']	.=	$coupon ? ', 使用优惠券'.$coupon['coupon_amount'].'元' : '';
                    
                    $orderData['uid']            =	$uid;
                    $orderData['usertype']		 =	$usertype;
                    $orderData['did']            =	$did;

                    if ($data['crm_uid']){
                        $orderData['crm_uid']   =   $data['crm_uid'];
                    }
                    
                    $order_info  =  array(
                        'uid'  =>  $uid,
                        'zid'  =>  $zid 
                    );
                    if($jifen){
                        $order_info['zph_integral']  =  $zph_integral;
                    }
                    // 参会职位处理
                    if (!empty($data['jobid'])){
                        // pc
                        $order_info['jobid']  =   $data['jobid'];
                        
                    }elseif (!empty($_COOKIE['zphjobid'])){
                        // wap
                        $order_info['jobid']  =   $_COOKIE['zphjobid'];
                    }
                    
                    $orderData['order_info']  =  serialize($order_info);
                    
                    $id     =   $this->addOrder($orderData);
                    
                    if ($id) {
                        
                        require_once('integral.model.php');
                        
                        $integral  =  new integral_model($this->db,$this->def,array('uid'=>$uid,'username'=>$username,'usertype'=>$usertype));
                        
                        if ($coupon) {
                            
                            $this -> upCouponList(array('id' => $couponid, 'uid' => $uid), array('status' => 2, 'xf_time'=>time()));   //  更新优惠券状态 2 已使用
                            
                            $integral -> company_invtal($uid, $usertype, $coupon['coupon_amount'], false, '报名网络招聘会，使用优惠券', true, 2, 'yhq', 14, '', $couponid);
                        }
                        
                        if($dkjf){
                            
                            $integral -> company_invtal($uid, $usertype, $dkjf, false, '报名网络招聘会，使用'.$this->config['integral_pricename'].'抵扣', true, 2, 'integral');
                        }
                        
                        $orderData['id']  =  $id;
                        
                        $return['order']  =  $orderData;
                        
                    }else {
                        
                        $return['error']  =  '订单生成失败！';
                    }
                    
                }
            }
        }else{
            $return['error'] = '参数填写错误，请重新设置！';
        }
        return $return;
    }
}
?>