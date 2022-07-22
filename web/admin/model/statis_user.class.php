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
class statis_user_controller extends adminCommon{

	//图表类型 bar 柱形图，line折线图，pie饼形图
	private $chartType = 'pie';
	
	//消费最多企业统计
	public function index_action(){

		$this->getUser(2);

		$this->yuntpl(array('admin/statis_user'));

	}

	//个人
	public function user_action(){

		$this->getUser(1);

		$this->yuntpl(array('admin/statis_user'));
	}

	//猎头
	public function lt_action(){

		$this->getUser(3);

		$this->yuntpl(array('admin/statis_user'));
	}

	//查询消费最多的企业
	public function getUser($userType){	

		$CompanyorderM					=			$this->MODEL('companyorder');

		$StatisM						=			$this->MODEL('statis');

		if(isset($_GET['radio_time'])){

			$this->yunset('radio_time', $_GET['radio_time']);

		}
		//查询报表数据
		$time_begin 				= 				isset($_GET['time_begin']) ? $_GET['time_begin'] : date('Y-m-d 00:00:00', strtotime('-30 day'));
		
		$time_end 					= 				isset($_GET['time_end']) ? $_GET['time_end'] :date('Y-m-d H:i:s');
		
		$this->yunset('defaultTimeBegin', $time_begin);
		
		$this->yunset('defaultTimeEnd', $time_end);

		$isAllTime = isset($_GET['isAllTime']) ? $_GET['isAllTime'] : 0; 

		//查询30条内的信息，展示到页面第一屏
		if($isAllTime != 1){

			$timeBegin 				= 		strtotime($time_begin);

		}else{

			$timeBegin 				= 		strtotime(date('Y-m-d 00:00:00', strtotime('-30 year')));

		}	
		$timeEnd 					= 		strtotime("now");
	
		list($in, $out, $net_income)		=			$StatisM->getStatisTotal($timeBegin,$timeEnd,$userType);
		
		$data [] 							= 			array('time' => '近30', 'in' => $in, 'out' => $out, 'net_income' => $net_income);
		
		$this->yunset('data', $data);

		if($userType == 2){

			$user 							=		 	'企业';
		
		}else if($userType == 1){
			
			$user 							= 			 '个人';
		
		}else if($userType == 3){
			
			$user 							= 			  '猎头';
		}

		$this->yunset('user', $user);
		
		//如果不是查询全部数据，组织查询的开始、结束时间
		if($isAllTime != 1){

			$timeBegin 						= 				strtotime($time_begin);

			$timeEnd 						= 				strtotime($time_end);
			
			$dateBegin 						= 				date('Y-m-d', $timeBegin);

	    	$dateEnd 						= 				date('Y-m-d', $timeEnd);
		
			$title 							= 				"消费最多{$user}统计 - {$dateBegin}~{$dateEnd}";
		}else{

			$title 							= 				"消费最多{$user}统计 - 全部数据";
		
		}

		$names 								= 				array();//扇形每块的名称（收入渠道）
		
		$values	 							= 				array();//扇形每块的值
		
		$topNum 							= 				10;//统计消费最多10个企业

		$where['order_state']				=				2;//只查询已付款订单

		if($isAllTime != 1){

			$where['order_time'][]    		=   		  	array('>=', $timeBegin);
		
			$where['order_time'][]    		=         		array('<=', $timeEnd,'AND');

		}

		$limit 								= 				$topNum * 6;
		
		$where['groupby']			  		=				'uid';
		
		$where['orderby']			  		=        		array('num,desc');

		$where['limit']			  	 	 	=				$limit;
		
		$field 						  		= 	   			'sum(order_price) as `num`, `uid`';
		
		$row						  		=				$CompanyorderM->getList($where,array('field'=>$field));
	
		$uidArr 					  		= 				array();

		$uidValue 					  		= 				array();
		
		foreach($row as $r){
			
			$uidArr [] 				 		= 				$r['uid'];
			
			$uidValue[$r['uid']] 	 		= 				$r['num'];
		
		}
		
		$uidStr 							= 				implode(',', $uidArr);

		if($userType == 2){

			$CompanyM						=				$this->MODEL('company');

			$comwhere['uid']			 	=				array('in',pylode(',',$uidStr));

			$comwhere['orderbyfield']	 	=				array('uid',$uidStr);
				
			$comwhere['limit']			 	=				$topNum;
			
			$data						 	=				$CompanyM->getChCompanyList($comwhere,array('field'=>'`uid`,`name`'));
			
		}else if($userType == 1){

			$ResumeM						=				$this->MODEL('resume');

			$rmewhere['uid']				=				array('in',pylode(',',$uidStr));

			$rmewhere['orderbyfield']		=				array('uid',$uidStr);

			$rmewhere['limit']				=				$topNum;

			$data							=				$ResumeM->getResumeList($rmewhere,array('field'=>'`uid`,`name`'));
			
		}else if($userType == 3){

			$LietouM						=				$this->MODEL('lietou');

			$ltwhere['uid']					=				array('in',pylode(',',$uidStr));

			$ltwhere['orderbyfield']		=				array('uid',$uidStr);

			$ltwhere['limit']				=				$topNum;

			$data							=				$LietouM->getList($ltwhere,array('field'=>'`uid`,`realname` as `name`'));
		
		}

		$total 								= 				0;
		
		foreach($data as $r){

			$names [] 						= 				"id:{$r['uid']} {$r['name']}";

			$rr['value'] 					= 				$uidValue[$r['uid']];
			
			$rr['name'] 					= 				"id:{$r['uid']} {$r['name']}";

			$values [] 						= 				$rr;

			$total 							+=				$uidValue[$r['uid']];
		}

		$this->yunset('total', $total);

		$data 								=			    array('title' => $title,'names' => $names, 'values' => $values );

		$c 									= 				isset($_GET['c']) ? $_GET['c'] : '';

		$this->yunset('gourl', "index.php?m={$_GET['m']}&c={$c}");
		
		$this->yunset($data);

	}

}
?>