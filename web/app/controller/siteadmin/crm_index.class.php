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
class crm_index_controller extends siteadmin_controller{
    
    function index_action() {
        
        $crmM       =   $this -> MODEL('crm');
        $orderM     =   $this -> MODEL('companyorder');
		
        $auid		=   intval($_SESSION['auid']);
        
        // 代办任务
        $tasks		=   $crmM -> getTaskList(array('uid' => $auid, 'stime' => array('<', time()), 'status' => '1', 'orderby'=>'stime'), array('utype' => 'crm'));
        $this -> yunset('tasks', $tasks);
		$this -> yunset('tasknum',count($tasks));
		
		// 待审核订单
		$orders  	=   $orderM -> getList(array('crm_uid' => $auid, 'order_state' => '1'),array('utype'=>'crmdealsp'));
		$this -> yunset('orders', $orders);
		
		//会员套餐
		$ratingM	=	$this -> MODEL('rating');
	    $ratinglist	=	$ratingM -> getList(array( 'category' => '1'), array('field'=>'`id`,`name`'));
		$this -> yunset('ratinglist', $ratinglist);
		$cacheM		=   $this -> MODEL('cache');  
        $cache		=   $cacheM -> GetCache(array('crm'));
        $this -> yunset('cache', $cache);
		include(CONFIG_PATH."db.data.php");
		$paystate	=  $arr_data['paystate'];
		$this -> yunset('paystate', $paystate);
        $this -> siteadmin_tpl(array('crm_index'));  
    }
	
	
	function crmDeal_action(){
		$crmM  		=   $this -> MODEL('crm');
		$dealData	=   array(
			'uid'      			=>  intval($_POST['com_uid']),
			'rating'   			=>  intval($_POST['rid']),
			'crm_uid'  			=>  intval($_SESSION['auid']),
			'order_remark' 		=> 	$_POST['order_remark'],
			'order_type'  		=>	$_POST['order_type'],
			'order_price'  		=> 	$_POST['order_price'],
		);
		$updealData	=   array(
			'uid'      			=>  intval($_POST['com_uid']),
			'rating'   			=>  intval($_POST['rid']),
			'crm_uid'  			=>  intval($_SESSION['auid']),
			'order_remark' 		=> 	$_POST['order_remark'],
			'order_type'  		=>	$_POST['order_type'],
			'order_price'  		=> 	$_POST['order_price'],
			'order_id'  		=> 	$_POST['order_id'],
		);
		if($_POST['id']){
			$return		=	$crmM  -> upDeal(array('id'=>$_POST['id']),$updealData);
		}else{
			$return		=	$crmM  -> addDeal($dealData);
		}
		$this -> ACT_layer_msg( $return['msg'], $return['errcode'], $_SERVER['HTTP_REFERER'], 2, 1);
	}
	function searchcom_action(){
		
		if($_POST['keyword']){
			
			$companyM	=   $this -> MODEL('company');
			$keyword	=	$this->post_trim($_POST['keyword']);
			
			$list		=   $companyM -> getList(array('crm_uid'=> $_SESSION['auid'],'name'=>array('like',$keyword)),array('field' => '`uid`,`name`'));
			
			$com		=	$list['list'];
			
 			if(is_array($com) && !empty($com)){
				foreach($com as $val){
					$data[]=array('uid'=>$val['uid'],'name'=> $val['name'],); 
					
				 }
			} 
		}
		echo json_encode($data);die;
	}
	public function orderprice_action(){
		$id					=	intval($_POST['id']);
		$ratingM			=	$this -> MODEL('rating');
		$rating				=	$ratingM -> getInfo(array('id' => $id));
		echo json_encode($rating);
	}
	/**
	 * @desc 我的简报
	 */
	function getWorkReport_action(){
	    
	    $crmM      =   $this -> MODEL('crm');
	    if ($_POST['time'] == 1) {//今天
            $sDate  =   mktime(0, 0, 0, date('m'), date('d') , date('Y'));
			$eDate  =   mktime(23, 59, 59, date('m'), date('d') , date('Y'));
            
        }else if ($_POST['time'] == 2) {//昨天
            $sDate  =   mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
			$eDate  =   mktime(23, 59, 59, date('m'), date('d') - 1, date('Y'));
            
        }else if ($_POST['time'] == 3) {//本周
            
            $sDate  =   strtotime(date('Y-m-d', strtotime("this week Monday", time())));
            $eDate  =   strtotime(date('Y-m-d', strtotime("this week Sunday", time()))) + 24 * 3600 - 1;
            
        }else if ($_POST['time'] == 4) {//本月
            
            $sDate  =   mktime(0, 0, 0, date('m'), 1, date('Y'));
            $eDate  =   mktime(23, 59, 59, date('m'), date('t'), date('Y'));
            
        }
	   // $sDate     =   strtotime(date('Y-m-d'));
	   // $eDate     =   time();  
	    
	    $return    =   $crmM -> getWorkReport(array('sdate' => $sDate, 'edate' => $eDate, 'auid' => $_SESSION['auid']));
 	    
 	    echo json_encode($return);
	}
	
	/**
	 * @desc  认领客户
	 */
	function receiveKh_action(){
	    
	    if ($_POST['uids']) {
	        
	        $uids  =   @explode(',', $_POST['uids']);
 	        
 	        $auid  =   intval($_SESSION['auid']);
	        
	        $comM  =   $this -> MODEL('company');
	        
	        $nid   =   $comM -> upInfo($uids, '', array('crm_uid'=>$auid,'crm_time'=>time()));
	        
	        echo $nid ? 1 : 2;
	        
	    }
	    
	}
    
}

?>