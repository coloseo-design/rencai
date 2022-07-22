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

/**
 * @method  支付处理函数
 * @param   回调参数
 * @param   dingdan   系统订单ID
 * @param   total_fee 支付金额
 */

//合并所有支付API 支付成功逻辑处理函数（支付宝、财付通、微信、wap支付宝）

//孔舒程  2015-12-08

class ApiPay extends common{
    
	function payAll($dingdan,$total_fee='',$paytype=''){
		
	
		//支付回调参数验证数据合法性
		if(!preg_match('/^[0-9]+$/', $dingdan)){

			  die;
		}

		//查询订单是否真实存在
		$orderM       =   $this -> MODEL('companyorder');
		$order        =   $orderM -> getInfo(array('order_id'=>$dingdan));

		
		$userinfoM    =   $this -> MODEL('userinfo');
		$resumeM      =   $this -> MODEL('resume');
		$comM         =   $this -> MODEL('company');
		$jobM         =   $this -> MODEL('job');
		$ltM          =   $this -> MODEL('lietou');
		$ratingM      =   $this -> MODEL('rating');
		$logM         =   $this -> MODEL('log');
		$statisM      =   $this -> MODEL('statis');
		$integralM    =   $this -> MODEL('integral');
		$packM        =   $this -> MODEL('pack');
		$warningM     =   $this -> MODEL('warning');
		
		//判断订单状态是否未处理，只处理未付款的
		
		if($order['order_state']=='1' && $order['id']){
		    
		    $uid      =   intval($order['uid']);
		    $ratingId =   intval($order['rating']);
		    $orderid  =   $order['order_id'];
		    $type     =   intval($order['type']);
		    
		    $tvalue   =   array();
		    $usertype =   intval($order['usertype']);
		    
		    $member   =   $userinfoM -> getInfo(array('uid'=> $uid), array('field'=>'`username`,`usertype`,`wxid`'));
			
			$wxtempMsg = '';
		    $usertype_n = '';

		    if($usertype == 1){
			    
			    $marr    =   $resumeM -> getResumeInfo(array('uid'=>$uid), array('field'=>'`name`,`email`,`telphone` as `moblie`'));
			    $usertype_n = '个人用户';
				
		    }else if($usertype == 2){
			    
			    $tvalue['all_pay']   =   array('+', $order['order_price']);
				
			    $marr                =   $comM -> getInfo($uid, array('field'=>'`name`,`crm_uid`,`linkmail` as `email`, `linktel` as moblie'));
			    $usertype_n = '企业用户';
				
		    }else if($usertype == 3){
			    
			    $tvalue['all_pay']   =   array('+', $order['order_price']);
			    
			    $marr                =   $ltM -> getInfo(array('uid' => $uid), array('field' => '`realname` as `name`, `emial`, `moblie`'));
			    $usertype_n = '猎头用户';
			}
			$emaildata               =   array();
			$emaildata['type']       =   'recharge';
			$emaildata['username']   =   $member['username'];
			$emaildata['name']       =   $marr['name'];
			$emaildata['price']      =   $order['order_price'];
			$emaildata['time']       =   date("Y-m-d H:i:s");
			$emaildata['email']      =   $marr['email'];
			$emaildata['moblie']     =   $marr['moblie'];
			$emaildata['port']		 =   $order['port'];

			$sendInfo                =   array();
			$sendInfo['wxid']        =   $member['wxid'];
			$sendInfo['first']       =   '您有一笔订单支付成功！';
			$sendInfo['username']    =   $member['username'];
			$sendInfo['order']       =   $orderid;
			$sendInfo['price']       =   $order['order_price'];
			$sendInfo['time']        =   date('Y-m-d H:i:s');
			$sendInfo['uid']         =   $uid;
			$sendInfo['usertype']    =   $member['usertype'];
			switch($paytype){
					
				case 'alipay':$sendInfo['paytype']='支付宝';
				break;
				case 'wxpay':$sendInfo['paytype']='微信支付';
				break;
				case 'wapalipay':$sendInfo['paytype']='支付宝手机支付';
				break;
				case 'tenpay':$sendInfo['paytype']='财付通';
				break;
				case 'baidu':$sendInfo['paytype']='百度闪付';
				break;
				default :$sendInfo['paytype']='其他支付方式';

				break;

			}

			//发送短信邮件通知站长参数
			if($type == 1 && $ratingId && $usertype != 1){//购买会员
			    
				if($usertype == 2){
				    
					$value =   $ratingM -> ratingInfo($ratingId, $uid);

                    $accountM   =   $this->MODEL('companyaccount');
                    
                    $sonList    =   $accountM -> getList(array('comid' => $uid, 'status' => 1), array('field' => '`uid`'));
                    
                    if (is_array($sonList) && !empty($sonList)) {
                        
                        $spids          =   array();
                        
                        foreach ($sonList as $v){
                            $spids[]    =   $v['uid'];
                        }
                        
                        if($value['rating_type'] == 2){ //  时间会员，变更套餐数据（每日上限）
                            $sonData        =   array(
                                
                                'job_num'       =>  $value['job_num'],
                                'breakjob_num'  =>  $value['breakjob_num'],
                                'down_resume'   =>  $value['down_resume'],
                                'invite_resume' =>  $value['invite_resume'],
                                'zph_num'       =>  $value['zph_num'],
                                'top_num'       =>  $value['top_num'],
                                'rec_num'       =>  $value['rec_num'],
                                'urgent_num'    =>  $value['urgent_num'],
                                'rating_name'   =>  $value['rating_name'],
                                'rating_type'   =>  $value['rating_type'],
                                'vip_etime'     =>  $value['vip_etime'],
                                'vip_stime'     =>  $value['vip_stime'],
                                'rating'        =>  $value['rating']
                            );
                        }else{  //  套餐会员，子账号套餐数据不用调整
                            
                            $sonData        =   array(
                                'job_num'       =>  0,
                                'breakjob_num'  =>  0,
                                'down_resume'   =>  0,
                                'invite_resume' =>  0,
                                'zph_num'       =>  0,
                                'top_num'       =>  0,
                                'rec_num'       =>  0,
                                'urgent_num'    =>  0,
                                'rating_name'   =>  $value['rating_name'],
                                'rating_type'   =>  $value['rating_type'],
                                'vip_etime'     =>  $value['vip_etime'],
                                'vip_stime'     =>  $value['vip_stime'],
                                'rating'        =>  $value['rating']
                            );
                        }
                    }
           
				}else if($usertype == 3){
				    
				    $value  =   $ratingM -> ltratingInfo($ratingId, $uid);
				}
       
				$nid    =   $statisM -> upInfo($value, array('uid' => $uid, 'usertype' => $usertype));
				
				if ($nid) {
				    
				    if (!empty($spids)) {
				        
				        $this->obj->update_once('company_statis', $sonData, array('uid' => array('in', pylode(',', $spids))));
				    }

				    if (isset($value['integral'])){

				        $addJF  =   $value['integral'][1];
                        $integralM->insert_company_pay($addJF,2,$uid,$order['usertype'],'开通会员赠送积分',1,2,true);
                    }
				    
				    $order_info 	=	 unserialize($order['order_info']);
				    
				    if ($order_info['vip_integral'] && $order['integral']) { // 充值积分购买会员
				        
				        $tvalue['integral']	   =   array('+' , $order['integral']);
				        
				        $statisM -> upInfo($tvalue, array('uid' => $uid, 'usertype' => $usertype));
				        
				        $integralM -> insert_company_pay($order['integral'],2,$uid,$order['usertype'],"充值".$this->config['integral_pricename'].'，购买会员',1,2,true);
				        
				        $statisM ->upInfo(array('integral' => array('-', $order_info['vip_integral'])), array('uid' => $uid, 'usertype' => $usertype));
				        
				        $integralM -> insert_company_pay($order_info['vip_integral'],2,$uid,$order['usertype'],"购买会员，扣除".$this->config['integral_pricename'],1,2,false);
				        
				        $warningM -> warning(4, $uid); //充值预警提醒
				    }
				    $logContent = $sendInfo['paytype'].$value['rating_name'].'购买成功，价格:'.$order['order_price'].'元，'.'订单编号：'.$order['id'];
				    $logContent .= $order['order_dkjf'] > 0 ? '，使用抵扣'.$this->config['integral_pricename'].$order['order_dkjf'] : '';
				    $logContent .= !empty($order['coupon']) ? '，使用优惠券id:'.$order['coupon'] : '';
				    $logM->addMemberLog($uid, $usertype, $logContent);
				}

				$sendMail   = 1;//确定发送邮件状态
				$sendInfo['info']   = '购买：'.$value['rating_name'];

				$wxtempMsg =$usertype_n.$marr['name'].$logContent;
				
			}else if($type == 2 && $order['integral']){//充值积分

                $tvalue['integral'] =   array('+', $order['integral']);
                $nid                =   $statisM -> upInfo($tvalue, array('uid' => $uid,'usertype'=>$usertype));
                
                if ($nid) {
                    $warningM -> warning(4, $uid); //充值预警提醒
                    $logContent = $sendInfo['paytype'].'充值'.$this->config['integral_pricename'].$order['integral'].'成功';
                    $logContent .= $order['order_dkjf'] > 0 ? '，使用抵扣'.$this->config['integral_pricename'].$order['order_dkjf'] : '';
                    $logContent .= !empty($order['coupon']) ? '，使用优惠券id:'.$order['coupon'] : '';
                    $logM->addMemberLog($uid, $usertype, $logContent);
                }
                $sendMail           =   1;  
				$sendInfo['info']   =   '充值'.$this->config['integral_pricename'].'：'.$order['integral'];

				$wxtempMsg =$usertype_n.$marr['name'].$logContent."，实际支付$order[order_price]元,订单编号：$order[id]";
			}else if($type == 5){//购买增值包
			    
				if($usertype == 2){

				    $row    =   $ratingM -> getComSerDetailInfo($ratingId);
					
				    $value['job_num']           =   array('+', intval($row['job_num'])); 
				    $value['breakjob_num']      =   array('+', intval($row['breakjob_num']));  
				    $value['down_resume']       =   array('+', intval($row['resume'])); 
				    $value['invite_resume']     =   array('+', intval($row['interview'])); 
				    $value['zph_num']			=	array('+', intval($row['zph_num']));
					$value['top_num']			=   array('+', intval($row['top_num']));
					$value['rec_num']			=   array('+', intval($row['rec_num']));
					$value['urgent_num']		=   array('+', intval($row['urgent_num']));
				    $value['chat_num']			=   array('+', intval($row['chat_num'])); 
				    $value['spview_num']		=   array('+', intval($row['spview_num'])); 
				    
				}elseif($usertype == 3){

                    $row    =   $ltM-> getLtservicedetailInfo(array('id' => $ratingId));

				    $value['lt_job_num']        =   array('+', intval($row['lt_job_num']));
				    $value['lt_down_resume']    =   array('+', intval($row['lt_resume']));
				    $value['lt_breakjob_num']   =   array('+', intval($row['lt_breakjob_num']));
				    
				}
                
				$nid        =   $statisM -> upInfo($value, array('uid' => $uid, 'usertype' => $usertype));
				
				if ($nid) {
				    
				    $order_info 	=	 unserialize($order['order_info']);
				    
				    if ($order_info['pack_integral'] && $order['integral']) { // 充值积分购买增值服务
				        
				        $tvalue['integral']	   =   array('+' , $order['integral']);
				        
				        $statisM -> upInfo($tvalue, array('uid' => $uid, 'usertype' => $usertype));
				        
				        $integralM -> insert_company_pay($order['integral'],2,$uid,$order['usertype'],"充值".$this->config['integral_pricename'].'，购买增值服务',1,2,true);
				        
				        $statisM ->upInfo(array('integral' => array('-', $order_info['pack_integral'])), array('uid' => $uid, 'usertype' => $usertype));
				        
				        $integralM -> insert_company_pay($order_info['pack_integral'],2,$uid,$order['usertype'],"购买增值服务，扣除".$this->config['integral_pricename'],1,2,false);
				        
				        $warningM -> warning(4, $uid); //充值预警提醒
				    }
				    $logContent = $sendInfo['paytype'].'增值服务购买成功';
				    $logContent .= $order['order_dkjf'] > 0 ? '，使用抵扣'.$this->config['integral_pricename'].$order['order_dkjf'] : '';
				    $logContent .= !empty($order['coupon']) ? '，使用优惠券id:'.$order['coupon'] : '';
				    $logM->addMemberLog($uid, $usertype, $logContent);
				}
				
				$sendMail   =   1;
				$sendInfo['info']   =   '购买增值包：'.$row['name'];

				$wxtempMsg =$usertype_n.$marr['name'].$logContent."，实际支付$order[order_price]元,订单编号：$order[id]";

			}else if($type == 6){//购买课程
			    
			    $trainM  =  $this -> MODEL('train');
			    $px      =  $trainM -> getBmInfo(array('id' => intval($order['sid'])), array('field' => '`sid`, `s_uid`'));
			    
				if($px){
				    
				    $subject  =  $trainM -> getSubInfo(array('id' => intval($px['sid'])), array('field' => '`name`'));
				}
				
				$pValue  =  array(
				    
				    'order_id'     =>  $orderid,
				    'order_price'  =>  $order['order_price'],
				    'pay_time'     =>  time(),
				    'pay_state'    =>  2,
				    'com_id'       =>  intval($px['s_uid']),
					'usertype'     =>  4,
				    'pay_reamrk'   =>  '课程《'.$subject['name'].'》报名费',
				    'did'          =>  $this->config['did']
				    
				);
				
				$this -> insert_into('company_pay', $pValue);
            
				$value['packpay']   =   array('+', $order['order_price']);
        				
				$sendMail           =   1;  


				$sendInfo['info']   =   '购买培训课程';
				
				$nid                =   $statisM -> upInfo($value, array('uid'=>$px['s_uid'], 'usertype' => 4));
				if ($nid){
				    $logM->addMemberLog($uid, $usertype, $sendInfo['paytype'].'购买培训课程：'.$subject['name']);
				}
				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买培训课程：'.$subject['name']."，实际支付$order[order_price]元,订单编号：$order[id]";
				
			}elseif($type == 8){//分享推广红包
			    
			    $order_info  =   unserialize($order['order_info']);
			    
			    $jobid       =   intval($order_info['jobid']);
			    $jobname	 =	 '';
				if($order_info['jobid']){
				    
				    //查询该职位当前是否有做推广并且尚未结束
				    $packjob    =   $packM -> getShareJobOne($jobid);
					
					//如果当前职位已有推广记录
					if(!empty($packjob)){
					    
						if($packjob['packnum']<1){
						    
						    $nid          =   $this -> obj -> update_once('company_job_share', array('packnum' => $order_info['packnum'], 'packprice' => $order_info['packprice']), array('id' => $packjob['id']));
							
						    $shareType    = 1;
							
						}elseif($packjob['packmoney'] == $order_info['packmoney']){
						    
						    $nid          =   $this -> obj ->update_once('company_job_share', array('packnum' => array('+', $order_info['packnum']), 'packprice' => array('+', $order_info['packprice'])), array('id' => $packjob['id']));
 							
						    $shareType    = 1;
							
						}else{
							//将金额返还到红包专属账户
							$statisM ->  upInfo(array('packpay' => array('+',$order['order_price']), array('uid' => $uid, 'usertype' => $usertype)));
							
							$pValue         =   array(
							    'order_id'      =>  $orderid,
							    'order_price'   =>  $order['order_price'],
							    'pay_time'      =>  time(),
							    'pay_state'     =>  2,
							    'com_id'        =>  $uid,
								'usertype'      =>  intval($order['usertype']),
							    'pay_reamrk'    =>  '职位已推广，重复支付推广金退还至红包账户',
							    'type'          =>  2,
							    'did'           =>  $this->config['did']
							);
							
							$nid =   $this -> obj -> insert_into('company_pay', $pValue);
 						}
 						
					}else{
					    $job   =   $jobM -> getInfo(array('id' => $jobid), array('field'=>'`status`'));

						if(!empty($job)){
						    
						    $shareData    =   array(
						        'uid'         =>  $uid,
						        'jobid'       =>  $jobid,
						        'packnum'     =>  intval($order_info['packnum']),
						        'packmoney'   =>  floatval($order_info['packmoney']),
						        'packprice'   =>  floatval($order_info['packprice']),
						        'stime'       =>  time()
						    );
						    
						    $nid  =   $this -> obj ->insert_into('company_job_share', $shareData);
						    
						}else{
						    
						    $nid  =   $jobid;
						}
						$shareType = 1;
					}
 					if($shareType == 1){
					    
					    $jobM -> upInfo(array('sharepack' => '1'), array('id' => $jobid));
					}

					$jobname = '，推广职位：'.$packjob['name'];
				}
				
				$sendInfo['info'] = '分享推广红包';

				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'分享推广红包'.$jobname."，实际支付$order[order_price]元,订单编号：$order[id]";
				
			}else if($type == 9){//悬赏红包
			    
			    $rewardId    =   $order['rewardid'];
			    
			    $reward      =   $packM -> getPackInfo(array('id'=>$rewardId));
			    $jobname	 =	 '';
				if(!empty($reward) && $reward['status']=='0'){
				    $jobname = '，悬赏职位：'.$reward['job_name'];
				    $ruid    =  intval($reward['uid']);
				    
				    $rutype  =  intval($reward['usertype']);
    				    
					//发放投递赏金
					if($reward['sqmoney'] > 0){
					    					                             
					    $statisM   -> upInfo(array('packpay' => array('+', $reward['sqmoney'])), array('uid' => $ruid, 'usertype' => $rutype));
					    
					    $nid   =   $this -> obj -> insert_into('company_pay', array('order_id' => $orderid , 'order_price' => '-'.$reward['sqmoney'], 'pay_time' => time(), 'pay_state' => '2', 'com_id' => $reward['comid'],'usertype'  => 2, 'pay_remark' => '发放投递赏金' , 'type' => '2', 'pay_type' => 2, 'did' => $this->config['did']));
					    
					    $nid   =   $this -> obj -> insert_into('company_pay', array('order_id' => $orderid , 'order_price' => $reward['sqmoney'], 'pay_time' => time(), 'pay_state' => '2', 'com_id' => $ruid,'usertype'      =>  $rutype, 'pay_remark' => '企业发放投递赏金' , 'type' => '2', 'pay_type' => 2, 'did' => $this->config['did']));
					}
					
					//修改记录状态 
					$packM -> upstatus($rewardId,'1');

					//插入日志记录
					$logDataValue  =   array(
					  
					    'jobid'        =>  intval($reward['jobid']),
					    'rewardid'     =>  intval($reward['id']),
					    'eid'          =>  intval($reward['eid']),
					    'status'       =>  '1',
					    'uid'          =>  intval($reward['comid']),
					    'utype'        =>  '2',
					    'ctime'        =>  time(),
					    'pay'          =>  $reward['sqmoney']
					    
					);

					$nid   =   $packM -> statusLog($logDataValue);
					
				}else{
				
					//归还付款
					//将金额返还到红包专属账户
					$statisM -> upInfo(array('packpay' => array('+', $order['order_price'])), array('uid' => $uid, 'usertype' => $usertype));
					
					$nid   =   $this -> obj -> insert_into('company_pay', array('order_id' => $orderid , 'order_price' => $order['order_price'], 'pay_time' => time(), 'pay_state' => '2', 'com_id' => $uid, 'usertype' =>'2', 'pay_remark' => '重复职位赏金退还至红包账户' , 'type' => '2', 'pay_type' => 2, 'did' => $this->config['did']));

				}
				
				$sendMail   = 1;//确定发送邮件状态
				//购买会员
				$sendInfo['info'] = '悬赏红包';

				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买职位悬赏红包'.$jobname."，实际支付$order[order_price]元,订单编号：$order[id]";
				
			}else if($order['type']=='10'){//职位置顶
				/**
 				 * 购买置顶职位，付款成功后续操作，
				 * @var jobid days price
				 */
				$order_info = unserialize($order['order_info']);

				$jobname = '';

				if($order_info['jobid']){
				    
					//查询该职位
				    $xsJob  =   $jobM -> getInfo(array('id' => intval($order_info['jobid'])), array('field' => '`id`,`name`,`xsdate`'));
				    
					if(!empty($xsJob)){
					    
					    $jobname = '，置顶职位'.$xsJob['name'].$order_info['days'].'天';

					    $xsdate    =   $xsJob['xsdate'] > time() ? array('+', $order_info['days'] * 86400) : strtotime('+'.$order_info['days'].' day');
					    $nid       =   $jobM -> upInfo(array('xsdate' => $xsdate), array('uid' => $uid, 'id' => intval($order_info['jobid'])));
						
					    if ($order_info['jobzd_integral'] && $order['integral']) { // 充值积分购买职位置顶
					        
					        $tvalue['integral']	   =   array('+' , $order['integral']);
					        
					        $statisM -> upInfo($tvalue, array('uid' => $uid, 'usertype' => $usertype));
					        
					        $integralM -> insert_company_pay($order['integral'],2,$uid,$order['usertype'],"充值".$this->config['integral_pricename'].'，购买职位置顶',1,2,true);
					        
					        $statisM ->upInfo(array('integral' => array('-', $order_info['jobzd_integral'])), array('uid' => $uid, 'usertype' => $usertype));
					        
					        $integralM -> insert_company_pay($order_info['jobzd_integral'],2,$uid,$order['usertype'],"职位置顶，扣除".$this->config['integral_pricename'],1,2,false);
					        
					        $warningM -> warning(4, $uid); //充值预警提醒
					    }
					    
					    $logM -> addMemberLog($uid, $usertype, '购买职位置顶','1','1');
					}
 				}

 				$sendInfo['info'] = '职位置顶';

 				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'后买职位置顶'.$jobname."，实际支付$order[order_price]元,订单编号：$order[id]";
			}
			else if($type == 11){//职位紧急
				/**
 				 * 购买紧急招聘，付款成功后续操作，
				 * @var jobid days price
				 */
				$order_info = unserialize($order['order_info']);
                
                $jobname = '';

				if($order_info['jobid']){
				    
					//查询该职位
					$uJob  =   $jobM -> getInfo(array('id' => intval($order_info['jobid'])), array('where' => array('uid'=>$uid),'field'=>'`id`,`name`, `urgent_time`'));
					
					if(!empty($uJob)){
					    
					    $jobname = '，设置职位'.$uJob['name'].'紧急'.$order_info['days'].'天';

					    $urgent_time   =   $uJob['urgent_time'] > time() ? array('+' , $order_info['days'] * 86400) : strtotime('+'.$order_info['days'].' day');
					    
					    $nid           =   $jobM   -> upInfo(array('urgent_time' => $urgent_time, 'urgent' => '1'),array('uid' => $uid, 'id' => intval($order_info['jobid'])));
						
					    if ($order_info['joburgent_integral'] && $order['integral']) { // 充值积分购买紧急招聘
					        
					        $tvalue['integral']	   =   array('+' , $order['integral']);
					        
					        $statisM -> upInfo($tvalue, array('uid' => $uid, 'usertype' => $usertype));
					        
					        $integralM -> insert_company_pay($order['integral'],2,$uid,$order['usertype'],"充值".$this->config['integral_pricename'].'购买职位紧急招聘',1,2,true);
					        
					        $statisM ->upInfo(array('integral' => array('-', $order_info['joburgent_integral'])), array('uid' => $uid, 'usertype' => $usertype));
					        
					        $integralM -> insert_company_pay($order_info['joburgent_integral'],2,$uid,$order['usertype'],"职位紧急招聘，扣除".$this->config['integral_pricename'],1,2,false);
					        
					        $warningM -> warning(4, $uid); //充值预警提醒
					    }
					    
                        $logM -> addMemberLog($uid, $usertype, '购买紧急招聘','1','1');
					}
 				}
				$sendInfo['info'] = '职位紧急';

				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买职位紧急'.$jobname."，实际支付$order[order_price]元,订单编号：$order[id]";
				
			}else if($type == 12){//职位推荐
				
				/**
 				 * 购买职位推荐，付款成功后续操作，
				 * @var jobid days price
				 */
				$order_info = unserialize($order['order_info']);

				$jobname = '';

				if($order_info['jobid']){
					//查询该职位
					$recJob    =   $jobM -> getInfo(array('id' => intval($order_info['jobid']), 'uid' => $uid), array('field'=>'`id`,`name`,`rec_time`'));
					
					if(!empty($recJob)){
						
						$jobname = '，推荐职位：'.$recJob['name'].$order_info['days'].'天';

					    $rec_time  =   $recJob['rec_time'] > time() ? array('+', $order_info['days']) : strtotime('+'.$order_info['days'].' day') ;

					    $nid       =   $jobM -> upInfo(array('rec_time' => $rec_time, 'rec' => '1'), array('uid' => $uid, 'id' => intval($order_info['jobid'])));
					    
					    if ($order_info['jobrec_integral'] && $order['integral']) { // 充值积分购买职位推荐
					        
					        $tvalue['integral']	   =   array('+' , $order['integral']);
					        
					        $statisM -> upInfo($tvalue, array('uid' => $uid, 'usertype' => $usertype));
					        
					        $integralM -> insert_company_pay($order['integral'],2,$uid,$order['usertype'],"充值".$this->config['integral_pricename'].'，购买职位推荐',1,2,true);
					        
					        $statisM ->upInfo(array('integral' => array('-', $order_info['jobrec_integral'])), array('uid' => $uid, 'usertype' => $usertype));
					        
					        $integralM -> insert_company_pay($order_info['jobrec_integral'],2,$uid,$order['usertype'],"职位推荐，扣除".$this->config['integral_pricename'],1,2,false);
					        
					        $warningM -> warning(4, $uid); //充值预警提醒
					    }
					    
                        $logM -> addMemberLog($uid, $usertype, '购买职位推荐','1','1');
					}
 				}
 				$sendInfo['info'] = '职位推荐';

 				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买职位推荐'.$jobname."，实际支付$order[order_price]元,订单编号：$order[id]";
			}else if($type == 13){//职位自动刷新
				/**
				 * 购买自动刷新，付款成功后续操作，
				 * @var jobautoids days price
				 */
				$order_info = unserialize($order['order_info']);

				if($order_info['jobid']){
				    
					//查询该职位
				    $ListA    =   $jobM -> getList(array('uid' => $uid, 'id' => array('in', $order_info['jobid'])), array('field'=>'`id`,`autotime`'));
					
				    $autoJob  =   $ListA['list'];
				    
					if(!empty($autoJob)){
						$lastautotime =   0;
						foreach ($autoJob as $v){
						    $autotime    =   $v['autotime'] >= time() ? array('+', $order_info['days'] * 86400) : strtotime('+'.$order_info['days'].' day');
							
							if ($autotime > $lastautotime) {
								$lastautotime = $autotime;
							}
							
							$nid         =   $jobM -> upInfo(array('autotime' => $autotime),array('uid' => $uid, 'id' => $v['id']));
							
						}
						
						if ($order_info['auto_integral'] && $order['integral']) { // 充值积分购买自动刷新
						    
						    $tvalue['integral']	   =   array('+' , $order['integral']);
						    
						    $statisM -> upInfo($tvalue, array('uid' => $uid, 'usertype' => 2));
						    
						    $integralM -> insert_company_pay($order['integral'],2,$uid,2,"充值".$this->config['integral_pricename'].'，购买职位自动刷新',1,2,true);
						    
						    $statisM ->upInfo(array('integral' => array('-', $order_info['auto_integral'])), array('uid' => $uid, 'usertype' => $usertype));
						    
						    $integralM -> insert_company_pay($order_info['auto_integral'],2,$uid,$order['usertype'],"职位自动刷新，扣除".$this->config['integral_pricename'],1,2,false);
						    
						    $warningM -> warning(4, $uid); //充值预警提醒
						}
						
						$logM -> addMemberLog($uid, $usertype, '购买职位自动刷新功能','1','2');
						
					}
 				}
 				$sendInfo['info']   = '职位刷新';

 				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买职位自动刷新'."，实际支付$order[order_price]元,订单编号：$order[id]";
				
			}else if($type == 14){//简历置顶
				
				/**
 				 * 购买简历置顶，付款成功后续操作，
				 * @var resumeid days price
				 */
				$order_info = unserialize($order['order_info']);

				$orderMsg = '';

				if($order_info['resumeid']){
					//查询该简历
					$zdResume  =   $resumeM -> getExpect(array('id'=>intval($order_info['resumeid']), 'uid' => $uid), array('field'=>'`id`,`name`,`topdate`'));
					
					if(!empty($zdResume)){
					    
					    $topdate   =   $zdResume['topdate'] > time() ? array('+', $order_info['days'] * 86400) : strtotime('+'.$order_info['days'].' day');
                        
					    $nid       =   $resumeM -> upInfo(array('id' => intval($order_info['resumeid'])),array('eData'=>array('topdate' => $topdate, 'top' => '1')) );
					    
					    $orderMsg = '，置顶简历'.$zdResume['name'].$order_info['days'].'天';

					    $logM -> addMemberLog($uid, $usertype, '购买简历置顶','2','1');
					}
					
 				}
 				
				$sendInfo['info'] = '简历置顶';

				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买简历置顶'.$orderMsg."，实际支付$order[order_price]元,订单编号：$order[id]";
				
			}else if($order['type']=='15'){//委托简历
				
				/**
				 * @var resumeid  price
				 */
				$order_info = unserialize($order['order_info']);

				$orderMsg = '';

				if($order_info['resumeid']){
					//查询该简历
					$wtResume  =   $resumeM -> getExpect(array('uid' => $uid, 'id' => intval($order_info['resumeid']), 'is_entrust' =>'0'), array('field' => '`id`, `uid`, `name`, `is_entrust`'));

					if(!empty($wtResume)){

					    $orderMsg = '，委托简历：'.$wtResume['name'];

					    $iData     =   array(
					        
					        'uid'      =>  $wtResume['uid'],
					        'did'      =>  $this -> config['did'],
					        'username' =>  $wtResume['name'],
					        'eid'      =>  $wtResume['id'],
					        'status'   =>  $this -> config['user_trust_status'],
					        'price'    =>  $order['order_price'],
					        'add_tme'  =>  time()
					        
					    );
					    
					    $nid   =   $this -> obj -> insert_into('user_entrust', $iData);
					    
					    if($nid){
							if($this->config['user_trust_status']=='1'){
							    
							    $resumeM -> upInfo(array('id' => intval($order_info['resumeid'])),array('eData'=>array('is_entrsut' =>'2')));
							}else{
							    $resumeM -> upInfo(array('id' => intval($order_info['resumeid'])),array('eData'=>array('is_entrsut' =>'1')));
							}
						}
						$logM -> addMemberLog($uid, $usertype, '委托简历','6','1');
					}
					
 				}
 				
				$sendInfo['info'] = '委托简历';

				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买委托简历'.$orderMsg."，实际支付$order[order_price]元,订单编号：$order[id]";
				
			}else if($type ==  16){//职位刷新
				
			    $order_info = unserialize($order['order_info']);
			    
			    if($order_info['jobid']){
				
				    //查询该职位
				    $sxJob  =   $jobM -> getList(array('uid'=>$uid , 'id' => array('in', $order_info['jobid'])), array('field'=>'`lastupdate`,`id`'));

					if(!empty($sxJob)){
					    
					    $nid   =   $jobM -> upInfo(array('lastupdate' => time()), array('id' => array('in', pylode(',' , explode(',', $order_info['jobid'])))));
 						
					    if ($order_info['sxjob_integral'] && $order['integral']) {
					        
					        $tvalue['integral']	   =   array('+' , $order['integral']);
					        
					        $statisM -> upInfo($tvalue, array('uid' => $uid, 'usertype' => $usertype));
					        
					        $integralM -> insert_company_pay($order['integral'],2,$uid,$order['usertype'],"充值".$this->config['integral_pricename'].'， 购买职位刷新',1,2,true);
					        
					        $statisM ->upInfo(array('integral' => array('-', $order_info['sxjob_integral'])), array('uid' => $uid, 'usertype' => $usertype));
					        
					        $integralM -> insert_company_pay($order_info['sxjob_integral'],2,$uid,$order['usertype'],"职位刷新，扣除".$this->config['integral_pricename'],1,2,false);
					        
					        $warningM -> warning(4, $uid); //充值预警提醒
					    }
					    
					    $comM  ->  upInfo($uid, '', array('lastupdate' => time()));

					    $logM  ->  addMemberLog($uid, $usertype, '职位刷新','1','4');
					}
 				}
				$sendInfo['info'] = '职位刷新';

				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买职位刷新'."，实际支付$order[order_price]元,订单编号：$order[id]";
				
			}else if($type == 17){//兼职刷新
			    
			    $partM       =   $this -> MODEL('part');
				
			    $order_info  =   unserialize($order['order_info']);
			    
			    if($order_info['jobid']){
			        //查询该职位
			        $sxPart  =   $partM -> getList(array('uid' => $uid, 'id' => array('in', $order_info['jobid'])), array('field' => '`id`,`lastupdate`'));
					
					if(!empty($sxPart)){
					    
					    $nid   =   $partM -> upInfo(array('lastupdate' => time()), array('id' => array('in', pylode(',', explode(',', $order_info['jobid'])))));
					    if ($order_info['sxpart_integral'] && $order['integral']) {
					        
					        $tvalue['integral']	   =   array('+' , $order['integral']);
					        
					        $statisM -> upInfo($tvalue, array('uid' => $uid, 'usertype' => $usertype));
					        
					        $integralM -> insert_company_pay($order['integral'],2,$uid,$order['usertype'],"充值".$this->config['integral_pricename'].'， 购买兼职刷新',1,2,true);
					        
					        $statisM ->upInfo(array('integral' => array('-', $order_info['sxpart_integral'])), array('uid' => $uid, 'usertype' => $usertype));
					        
					        $integralM -> insert_company_pay($order_info['sxpart_integral'],2,$uid,$order['usertype'],"兼职刷新，扣除".$this->config['integral_pricename'],1,2,false);
					        
					        $warningM -> warning(4, $uid); //充值预警提醒
					    }
					    $logM  ->  addMemberLog($uid, $usertype, '兼职刷新','9','4');
					}
					
 				}
 				$sendInfo['info'] = '兼职刷新';

 				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买兼职刷新'."，实际支付$order[order_price]元,订单编号：$order[id]";
				
				
			}else if($type == 18){//猎头职位刷新
			    
				$order_info     = unserialize($order['order_info']);
				
				if($order_info['jobid']){
				    
				    $sxltjob    =   $ltM -> getList(array('uid' => $uid, 'id' => array('in', $order_info['jobid'])), array('field' => '`id`,`lastupdate`'));

					if(!empty($sxltjob)){
					    
					    $nid    =   $ltM -> upInfo(array('id' => array('in', $order_info['jobid'])), array('lastupdate' => time()));
                        
					    if ($order_info['sxltjob_integral'] && $order['integral']) {  
					        
					        $tvalue['integral']	   =   array('+' , $order['integral']);
					        
					        $statisM -> upInfo($tvalue, array('uid' => $uid, 'usertype' => $usertype));
					        
					        $integralM -> insert_company_pay($order['integral'],2,$uid,$order['usertype'],"充值".$this->config['integral_pricename'].'，购买猎头职位刷新',1,2,true);
					        
					        $statisM ->upInfo(array('integral' => array('-', $order_info['sxltjob_integral'])), array('uid' => $uid, 'usertype' => $usertype));
					        
					        $integralM -> insert_company_pay($order_info['sxltjob_integral'],2,$uid,$order['usertype'],"猎头职位刷新，扣除".$this->config['integral_pricename'],1,2,false);
					        
					        $warningM -> warning(4, $uid); //充值预警提醒
					    }
					    
					    $comM  ->  upInfo($uid, '', array('jobtime' => time()));
					    $logM  ->  addMemberLog($uid, $usertype, '猎头职位刷新','10','4');
  					}
				}
				
				$sendInfo['info'] = '猎头职位刷新';

				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买猎头职位刷新'."，实际支付$order[order_price]元,订单编号：$order[id]";
				
				
			}else if($type == 19){//下载简历
			    
				$order_info =   unserialize($order['order_info']);
				
				$orderMsg = '';

				if($order_info['eid']){
				
				    $eid    =   intval($order_info['eid']);
					
				    $expect =   $resumeM -> getExpect(array('id' => $eid), array('field' => '`id`,`uid`,`name`,`uname`,`height_status`'));
				    
				    if ($expect) {
				         
    				    $dData          =   array(
    				        
    				        'eid'          =>  intval($expect['id']),
    				        'uid'          =>  intval($expect['uid']),
    				        'comid'        =>  intval($order_info['uid']),
    				        'usertype'     =>  intval($usertype),
    				        'type'         =>  intval($expect['height_status']),
    				        'downtime'     =>  time(),
    				        'did'          =>  $this->config['did']
    				        
    				    );
    				    
    				    $downM   =  $this -> MODEL('downresume');
    				    $isDown  =  $downM -> getDownResumeInfo(array('eid' => $eid , 'comid' => $order_info['uid'],'usertype'=>$usertype));
    				    
    				    if(empty($isDown)){
    				        
    				        $orderMsg = '，下载简历：'.$expect['name'];

    				        $nid    =   $downM -> addInfo($dData);
    				        
    				        $resumeM -> upInfo(array('id'=>$eid), array('eData'=>array('dnum' => array('+','1'))));
    				        
    				        if ($order_info['resume_integral'] && $order['integral']) { // 充值积分下载简历
    				            
    				            $tvalue['integral']	   =   array('+' , $order['integral']);
    				            
    				            $statisM -> upInfo($tvalue, array('uid' => $uid, 'usertype' => $usertype));
    				            
    				            $integralM -> insert_company_pay($order['integral'],2,$uid,$order['usertype'],"充值".$this->config['integral_pricename'].'，下载简历',1,2,true);
    				            
    				            $statisM ->upInfo(array('integral' => array('-', $order_info['resume_integral'])), array('uid' => $uid, 'usertype' => $usertype));
    				            
    				            $integralM -> insert_company_pay($order_info['resume_integral'],2,$uid,$order['usertype'],"下载简历，扣除".$this->config['integral_pricename'],1,2,false);
    				         
    				            $warningM -> warning(4, $uid); //充值预警提醒
    				        }
    				    }else{
    				        
    				        $this->update_once('company_order', array('order_state' => '4', 'order_remark' => '简历（ID:'.$expect['id'].'）您已经下载过，关闭无效交易订单！'), array('id'=>$order['id']));
    				    }
     					
     					$logM -> addMemberLog($uid, $usertype, '下载简历：'.$expect['uname'],3,1);
				    }
				}
				$sendInfo['info']   =   '下载简历';

				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买下载简历次数'.$orderMsg."，实际支付$order[order_price]元,订单编号：$order[id]";
				
				
			}else if($type == 20){//发布职位
			    
			    $order_info =   unserialize($order['order_info']);
			    
				if($usertype == 2){
 					$jobnum   =   array('+', 1);
				}
				$nid        =   $statisM -> upInfo(array('job_num' => $jobnum), array('uid' => $uid, 'usertype' => $usertype));
				
				if ($order_info['issue_integral'] && $order['integral']) { // 充值积分购买职位发布
				    
				    $tvalue['integral']	   =   array('+' , $order['integral']);
				    
				    $statisM -> upInfo($tvalue, array('uid' => $uid, 'usertype' => $usertype));
				    
				    $integralM -> insert_company_pay($order['integral'],2,$uid,$order['usertype'],"充值".$this->config['integral_pricename'].'，购买职位发布',1,2,true);
				    
				    $statisM ->upInfo(array('integral' => array('-', $order_info['issue_integral'])), array('uid' => $uid, 'usertype' => $usertype));
				    
				    $integralM -> insert_company_pay($order_info['issue_integral'],2,$uid,$order['usertype'],"发布职位，扣除".$this->config['integral_pricename'],1,2,false);
				    
				    $warningM -> warning(4, $uid); //充值预警提醒
				}
				$sendMail   =   1;
 				$sendInfo['info'] = '购买职位发布';

 				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买发布职位次数'."，实际支付$order[order_price]元,订单编号：$order[id]";
 				
			}else if($type== 22){//发布猎头职位
  				
			    $order_info =   unserialize($order['order_info']);
			    
			    if($usertype == 3){
			        
			        $jobnum =   array('+',1);
			    }
   				
			    $nid      =   $statisM -> upInfo(array('lt_job_num' => $jobnum), array('uid' => $uid , 'usertype' => $usertype));
				
			    if ($order_info['issue_integral'] && $order['integral']) { // 充值积分购买职位发布
			        
			        $tvalue['integral']	   =   array('+' , $order['integral']);
			        
			        $statisM -> upInfo($tvalue, array('uid' => $uid, 'usertype' => $usertype));
			        
			        $integralM -> insert_company_pay($order['integral'],2,$uid,$order['usertype'],"充值".$this->config['integral_pricename'].'，购买职位发布',1,2,true);
			        
			        $statisM ->upInfo(array('integral' => array('-', $order_info['issue_integral'])), array('uid' => $uid, 'usertype' => $usertype));
			        
			        $integralM -> insert_company_pay($order_info['issue_integral'],2,$uid,$order['usertype'],"购买发布职位，扣除".$this->config['integral_pricename'],1,2,false);
			        
			        $warningM -> warning(4, $uid); //充值预警提醒
			    }
			    
			    $sendMail = 1;//确定发送邮件状态
 				$sendInfo['info'] = '购买猎头职位发布';

 				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买发布猎头职位次数'."，实际支付$order[order_price]元,订单编号：$order[id]";
 				
			}else if($type == 23){//面试邀请
			    
			    $order_info      = unserialize($order['order_info']);
			    
				if($usertype == 2){
				    $inviteNum  =   array('+', 1);
				}
				$nid    =   $statisM -> upInfo(array('invite_resume' => $inviteNum), array('uid' => $uid, 'usertype' => $usertype));
				
				if ($order_info['invite_integral'] && $order['integral']) { 
				    
				    $tvalue['integral']	   =   array('+' , $order['integral']);
				    
				    $statisM -> upInfo($tvalue, array('uid' => $uid, 'usertype' => $usertype));
				    
				    $integralM -> insert_company_pay($order['integral'],2,$uid,$order['usertype'],"充值".$this->config['integral_pricename'].'，购买面试邀请',1,2,true);
				    
				    $statisM ->upInfo(array('integral' => array('-', $order_info['invite_integral'])), array('uid' => $uid, 'usertype' => $usertype));
				    
				    $integralM -> insert_company_pay($order_info['invite_integral'],2,$uid,$order['usertype'],"面试邀请，扣除".$this->config['integral_pricename'],1,2,false);
				    
				    $warningM -> warning(4, $uid); //充值预警提醒
				}
				$sendMail = 1;//确定发送邮件状态
 				$sendInfo['info'] = '购买面试邀请';

 				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买面试邀请次数'."，实际支付$order[order_price]元,订单编号：$order[id]";
 				
			}else if($type == 24){//兼职推荐
			    
			    $order_info      = unserialize($order['order_info']);
			    
			    $orderMsg = '';

			    if($order_info['jobid']){
			        //查询该职位
			        $partM       =   $this -> MODEL('part');
			        $partA       =   $partM -> getInfo(array('id' => intval($order_info['jobid'])),array('field'=>'`id`,`name`,`rec_time`'));
			        $recJob      =   $partA['info'];    
					
					if(!empty($recJob)){
					    
					    $rec_time  =   $recJob['rec_time'] > time() ? array('+', $order_info['days'] * 86400) :  strtotime('+'.$order_info['days'].' day');
					    
					    $nid       =   $partM -> upInfo(array('rec_time' => $rec_time), array('id' => intval($order_info['jobid']), 'uid' => $uid));

					    $orderMsg = '，推荐兼职'.$recJob['name'].$order_info['days'].'天';
                        
					    if ($order_info['recpart_integral'] && $order['integral']) {
					        
					        $tvalue['integral']	   =   array('+' , $order['integral']);
					        
					        $statisM -> upInfo($tvalue, array('uid' => $uid, 'usertype' => $usertype));
					        
					        $integralM -> insert_company_pay($order['integral'],2,$uid,$order['usertype'],"充值".$this->config['integral_pricename'].'，购买兼职推荐',1,2,true);
					        
					        $statisM ->upInfo(array('integral' => array('-', $order_info['recpart_integral'])), array('uid' => $uid, 'usertype' => $usertype));
					        
					        $integralM -> insert_company_pay($order_info['recpart_integral'],2,$uid,$order['usertype'],"推荐兼职，扣除".$this->config['integral_pricename'],1,2,false);
					        
					        $warningM -> warning(4, $uid); //充值预警提醒
					    }
					    
					    $logM -> addMemberLog($uid, $usertype, '购买推荐兼职：'.$recJob['name'],9,4);
 					}
 				}
				$sendInfo['info'] = '兼职推荐';

				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买兼职推荐'.$orderMsg."，实际支付$order[order_price]元,订单编号：$order[id]";
				
			}else if($type == 25){//店铺招聘
 				
 				$orderMsg = '';

			    if($order['once_id']){
 				    
 				    $onceM =   $this -> MODEL('once');
 				    $once  =   $onceM  -> getOnceInfo(array('id' => intval($order['once_id'])), array('field'=>'`pay`'));
 				    
					if(!empty($once)){
	 				
					    $nid   =   $onceM -> upOnce(array('pay' => '2'), array('id' => intval($order['once_id'])));
 					}
 					$orderMsg = '，店铺id('.$order['once_id'].')';
				}

				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买发布店铺招聘'.$orderMsg."，实际支付$order[order_price]元,订单编号：$order[id]";
				
 			}else if($type == 26){//购买广告位
 				
 				$orderMsg = '';

 			    if($order['order_id']){
 			        
 			        $adM    =   $this -> MODEL('ad');
 			        $ad     =   $adM  ->   getAdOrderInfo(array('order_id' => $orderid), array('field' => '`aid`,`price`'));
					if(!empty($ad)){
					    $orderMsg = '，广告位id('.$ad['aid'].')';
					    $nid   =   $adM -> upOrderAd(array('order_id' => $orderid), array('order_state' => '2'));
					}
				}

				$sendInfo['info'] = '购买广告位';

				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买广告位'.$orderMsg."，实际支付$order[order_price]元,订单编号：$order[id]";

			 }else if($type == 27){//创建子账号
			     
				$order_info = unserialize($order['order_info']);
				
				if(!empty($order_info['uid'])){
					$statisvalue = $statiswhere			=	array();
					$statisvalue['sons_num']			=   array('+', 1);
					$statiswhere['uid']                 =   $order_info['uid'];
					$statiswhere['usertype']            =   2;
					$nid 							    =  	$statisM -> upInfo($statisvalue, $statiswhere);
					
					if ($order_info['son_integral'] && $order['integral']) {
					    
					    $tvalue['integral']	   =   array('+' , $order['integral']);
					    
					    $statisM -> upInfo($tvalue, array('uid' => $uid, 'usertype' => $usertype));
					    
					    $integralM -> insert_company_pay($order['integral'],2,$uid,$order['usertype'],"充值".$this->config['integral_pricename'].'，购买子账号',1,2,true);
					    
					    $statisM ->upInfo(array('integral' => array('-', $order_info['son_integral'])), array('uid' => $uid, 'usertype' => $usertype));
					    
					    $integralM -> insert_company_pay($order_info['son_integral'],2,$uid,$order['usertype'],"购买子账号，扣除".$this->config['integral_pricename'],1,2,false);
					    
					    $warningM -> warning(4, $uid); //充值预警提醒
					}
					
					$logM -> addMemberLog($uid, $usertype, '购买子账号：', 27, 1);
					
				}
				$sendInfo['info'] = '购买子账号';

				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买发布子账号次数'."，实际支付$order[order_price]元,订单编号：$order[id]";

			 }else if($type == 28){ //招聘会报名 
			    
                $order_info =   unserialize($order['order_info']);

                $orderMsg = '';

                if ($order_info['zid']) {
                    $zid    =   intval($order_info['zid']);
                    $bmData =   array(
                        'comid'	    =>	$order_info['uid'],
                        'zphid'	    =>	$zid,
                        'bid'       =>  $order_info['bid'],
                        'sid'       =>  $order_info['sid'],
                        'cid'       =>  $order_info['cid'],
                        'jobid'     =>  $order_info['jobid'],
                        'ctime'     =>  time(),
                        'status'    =>  0,
                        'price'     =>  $order['order_price'],
                        'com_name'  =>  $order_info['com_name'],
                        'jobid'     =>  $order_info['jobid']
                    );
                    $zphM   =   $this -> MODEL('zph');
                     
                    $zphCom =   $zphM -> getZphComInfo(array('uid' => $uid, 'zid' => $zid));
                    
                    if (empty($zphCom)) {
                        $nid = $zphM -> addZCom($bmData);
                        
                        if ($nid) {
                            $order_info 	=	 unserialize($order['order_info']);
                            
                            if ($order_info['zph_integral'] && $order['integral']) { // 充值积分报名招聘会
                                
                                $tvalue['integral']	   =   array('+' , $order['integral']);
                                
                                $statisM -> upInfo($tvalue, array('uid' => $uid, 'usertype' => $usertype));
                                
                                $integralM -> insert_company_pay($order['integral'],2,$uid,$order['usertype'],"充值".$this->config['integral_pricename'].'，预定招聘会',1,2,true);
                                 
                                $statisM -> upInfo(array('integral' => array('-', $order_info['zph_integral'])), array('uid' => $uid, 'usertype' => $usertype));
                                
                                $integralM -> insert_company_pay($order_info['zph_integral'],2,$uid,$order['usertype'],"预定招聘会，扣除".$this->config['integral_pricename'],1,2,false);
                                
                                $warningM -> warning(4, $uid); //充值预警提醒
                            }
                        }
                    }
                    $orderMsg = '，招聘会id('.$zid.')';
                }
			    $sendInfo['info'] = '报名招聘会'; 

			    $wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买报名招聘会次数'.$orderMsg."，实际支付$order[order_price]元,订单编号：$order[id]";

             }else if($type == '29'){//购买供求任务
                 $gqdemandM    =   $this -> MODEL('gqdemand');
                 $order_info 	=	 unserialize($order['order_info']);
                 if($order_info['gqid']){
                     $gqtaskwhere['id']  =  $order_info['gqid'];
                     $task     =  $gqdemandM->getGqtaskInfo($gqtaskwhere,array('type'=>1,'field'=>'`pay`'));
                     if(!empty($task)){
                         $nid  =  $gqdemandM->upGqtaskpay($gqtaskwhere, array('pay'=>'2'));
                     }
                  }

                  $wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买发布供求任务次数'."，实际支付$order[order_price]元,订单编号：$order[id]";

              }else if($type == '30'){//刷新供求任务
                  $gqdemandM    =   $this -> MODEL('gqdemand');
                  $order_info 	=	 unserialize($order['order_info']);
                  if($order_info['gqid']){
                      
                      $gqtaskwhere['id']      =     $order_info['gqid'];
                      $task   =    $gqdemandM->getGqtaskInfo($gqtaskwhere,array('type'=>1,'field'=>'`id`,`lastupdate`'));
                      if(!empty($task)){
                          
                          $nid	=  $gqdemandM->upGqtaskpay($gqtaskwhere, array('lastupdate'=>time()));
                      }
                  }

                  $wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买刷新供求任务次数'."，实际支付$order[order_price]元,订单编号：$order[id]";

              }elseif ($type == '31'){ //购买聊天数量
                  
                  $chat_name  =  $this->config['sy_chat_name'];
                  $order_info =   unserialize($order['order_info']);
                  
                  if($order_info['comid']){
                      
                      $chatM  =  $this->MODEL('chat');
                      $right  =  $chatM->getChatRight(array('uid'=>$order_info['uid'],'comid'=>$order_info['comid'],'usertype'=>$order_info['usertype']));
                      
                      if (empty($right)){
                          
                          $rData  =  array(
                              'uid'       =>  $order_info['uid'],
                              'comid'     =>  $order_info['comid'],
                              'usertype'  =>  $order_info['usertype'],
                              'ctime'     =>  time()
                          );
                          $nid  =  $chatM->addChatRight($rData);
                          
                          if ($order_info['chat_integral'] && $order['integral']) { // 充值积分购买聊天数量
                              
                              $jfmc       =  $this->config['integral_pricename'];
                              
                              $tvalue['integral']  =  array('+' , $order['integral']);
                              
                              $statisM -> upInfo($tvalue, array('uid' => $uid, 'usertype' => $usertype));
                              
                              $integralM -> insert_company_pay($order['integral'],2,$uid,$order['usertype'],"充值".$jfmc.'，购买'.$chat_name,1,2,true);
                              
                              $statisM ->upInfo(array('integral' => array('-', $order_info['chat_integral'])), array('uid' => $uid, 'usertype' => $usertype));
                              
                              $integralM -> insert_company_pay($order_info['chat_integral'],2,$uid,$order['usertype'],'购买'.$chat_name.'，扣除'.$jfmc,1,2,false);
                              
                              $warningM -> warning(4, $uid); //充值预警提醒
                          }
                      }else{
                          
                            $orderM -> upInfo($order['id'], array('order_state' => '4', 'order_remark' => '用户（ID:'.$order_info['uid'].'）您可以正常'.$chat_name.'，关闭无效交易订单！'));
                          
                      }
                      $logM->addMemberLog($uid, $usertype, '购买'.$chat_name, 30, 1);
                  }
                  
                  $sendInfo['info']  =  '购买'.$chat_name;

                  $wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买'.$chat_name.'次数'."，实际支付$order[order_price]元,订单编号：$order[id]";

              }else if($type == 32){ //网络招聘会报名
                  
                  $order_info =   unserialize($order['order_info']);
                  
                  $orderMsg = '';

                  if ($order_info['zid']) {
                      $zid    =   intval($order_info['zid']);
                      $zData		=	array(
                          'comid'	=>	$order_info['uid'],
                          'zphid'	=>	$zid,
                          'ctime'	=>	time(),
                          'status'	=>	0,
                          'price'	=>	$order['order_dkjf'],
                          'jobid'   =>  $order_info['jobid']
                      );
                      $zphnetM   =   $this -> MODEL('zphnet');
                      
                      $zphCom =   $zphnetM -> getZphnetCom(array('uid' => $uid, 'zid' => $zid));
                      
                      if (empty($zphCom)) {
                          
                          $nid = $zphnetM -> addZphnetCom($zData);
                          
                          if ($nid) {
                              $order_info 	=	 unserialize($order['order_info']);
                              
                              if ($order_info['zph_integral'] && $order['integral']) { // 充值积分报名招聘会
                                  
                                  $tvalue['integral']	   =   array('+' , $order['integral']);
                                  
                                  $statisM -> upInfo($tvalue, array('uid' => $uid, 'usertype' => $usertype));
                                  
                                  $integralM -> insert_company_pay($order['integral'],2,$uid,$order['usertype'],"充值".$this->config['integral_pricename'].'，预定网络招聘会',1,2,true);
                                  
                                  $statisM -> upInfo(array('integral' => array('-', $order_info['zph_integral'])), array('uid' => $uid, 'usertype' => $usertype));
                                  
                                  $integralM -> insert_company_pay($order_info['zph_integral'],2,$uid,$order['usertype'],"预定网络招聘会，扣除".$this->config['integral_pricename'],1,2,false);
                                  
                                  $warningM -> warning(4, $uid); //充值预警提醒
                              }
                          }
                      }
                      $orderMsg = '，网络招聘会id('.$order_info['zid'].')';
                  }
                  $sendInfo['info'] = '报名网络招聘会';

                  $wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买报名网络招聘会次数'.$orderMsg."，实际支付$order[order_price]元,订单编号：$order[id]";

              }else if($type == 33){//视频面试
			    
			    $order_info =   unserialize($order['order_info']);
			    
			    $spviewNum	=   array('+', 1);
				$nid        =   $statisM -> upInfo(array('spview_num' => $spviewNum), array('uid' => $uid, 'usertype' => 2));
				
				if ($order_info['issue_integral'] && $order['integral']) {  
				    
				    $tvalue['integral']	   =   array('+' , $order['integral']);
				    
				    $statisM -> upInfo($tvalue, array('uid' => $uid, 'usertype' => 2));
				    
				    $integralM -> insert_company_pay($order['integral'],2,$uid,$order['usertype'],"充值".$this->config['integral_pricename'].'，购买视频面试添加',1,2,true);
				    
				    $statisM ->upInfo(array('integral' => array('-', $order_info['issue_integral'])), array('uid' => $uid, 'usertype' => 2));
				    
				    $integralM -> insert_company_pay($order_info['issue_integral'],2,$uid,$order['usertype'],"添加视频面试，扣除".$this->config['integral_pricename'],1,2,false);
				    
				    $warningM -> warning(4, $uid); //充值预警提醒
				}
				$sendMail   =   1;
 				$sendInfo['info'] = '购买视频面试';
 				
 				$wxtempMsg =$usertype_n.$marr['name'].$sendInfo['paytype'].'购买发布视频面试次数'."，实际支付$order[order_price]元,订单编号：$order[id]";
			}
			 
			 if($nid){
				
			    $order_remark  =  !empty($order['order_remark']) ? $order['order_remark'] . '。' : '';
			    $order_remark .=  $sendInfo['paytype'];
			    $orderM -> upInfo($order['id'], array('order_state' => '2', 'order_remark'=> $order_remark));
				
				$this->MODEL('admin')->sendAdminMsg(array('first'=>'有新的订单付款成功，'.$wxtempMsg,'type'=>1));
				//微信通知
				$Weixin =   $this->MODEL('weixin');
				$Weixin ->  sendWxPay($sendInfo);
				
				if($sendMail==1){
				    $notice =   $this->MODEL('notice');
				    $notice -> sendEmailType($emaildata);
				    $notice -> sendSMSType($emaildata);
				}
				if($usertype==2 && $marr['crm_uid'] != '0'){
					$wxcontent = '您的客户 '.$marr['name'].' '.$sendInfo['info'].',支付金额：'.$order['order_price'].'元。';
					$crmM  =  $this -> MODEL('crm');
					$crmM -> sendCrmWxMsg($marr['crm_uid'],array('first'=>$wxcontent,'type'=>1));
				}
				if($order['type']=='2'){
					$integralM  =  $this->MODEL('integral');
					$integralM  -> insert_company_pay($order['integral'],2,$order['uid'],$order['usertype'],"购买".$this->config['integral_pricename'],1,2,true);
				}
				return 2;
			}
		}else{
			return $order['order_state'];
		
		}
	}
	function getOrder($id){
    	if (! preg_match('/^[0-9]+$/', $id)) {
            return array();
            
        } else {
            $orderM =   $this -> MODEL('companyorder');
            
            $order  =   $orderM -> getInfo(array('id' => $id));
            
            return $order;
        }
    }
}

?>