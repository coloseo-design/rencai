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
class trainpay_controller extends adminCommon{

	//时间区间
	public $timeSection	=	array(
		'1'		=>	'今天',
		'3'		=>	'最近三天',
		'7'		=>	'最近七天',
		'15'	=>	'最近半月',
		'30'	=>	'最近一个月'
	);

	//设置高级搜索功能
	public function set_search(){
		$search_list[]	=	array(
			'param'		=>	'time',
			'name'		=>	'报名时间',
			'value'		=>	$this -> timeSection
		);
		$search_list[]	=	array(
			'param'		=>	'isprice',
			'name'		=>	'收费方式',
			'value'		=>	array(
				1		=>	'在线收费',
				2		=>	'到场收费'
			)
		);
		$this -> yunset('search_list', $search_list);
	}
	/**
	 * 会员 - 培训 - 课程报名
	 * 2019-06-05 hjy
	 */
	public function index_action(){
		//搜索
		$this -> set_search();
		$bmWhereData							=	array();

		$keywordStr								=	trim($_GET['keyword']);
		$typecaStr								=	trim($_GET['typeca']);

		//客户名称条件
		if(!empty($keywordStr) && $typecaStr == 2){
			$bmWhereData['name']				=	array('like', $keywordStr);
		}

		//报名时间条件
		$endStr									=	intval($_GET['time']);
		if(!empty($endStr)){
			if($endStr == 1){
				$bmWhereData['ctime']			=	array('>=', strtotime(date("Y-m-d")));
			}else{
				$bmWhereData['ctime']			=	array('>=', strtotime('-'.$endStr.'day'));
			}
		}

		$pxM									=	$this -> MODEL('train');
		$comids	=	$subWhereData				=	array();
		//课程名称条件
		if(!empty($keywordStr) && $typecaStr == 1){
			$subWhereData['name']				=	array('like', $keywordStr);
		}
		//收费方式条件
		$ispriceStr								=	intval($_GET['isprice']);
		if(!empty($ispriceStr)){
			$subWhereData['isprice']			=	array('=', $ispriceStr);
		}
		if(!empty($subWhereData)){
			$pxsub								=	$pxM -> getSubList($subWhereData, array('field' => '`id`'));
			if(!empty($pxsub)){
				foreach($pxsub as $val){
					$comids[] 					=	$val['id'];
				}				
			}else{
				$comids							=	array(0);
			}
		}
		if(!empty($comids)){
			$bmWhereData['sid']					=	array('in', pylode(',', $comids));
		}

		$urlarr 								=	$_GET;
		$urlarr['page']							=	'{{page}}';
		$pageurl								=	Url($_GET['m'], $urlarr, 'admin');
		//提取分页
		$pageM									=	$this  -> MODEL('page');
		$pages									=	$pageM -> pageList('px_baoming', $bmWhereData, $pageurl, $_GET['page']);

		//分页数大于0的情况下 执行列表查询
		$List									=	array();
		if($pages['total'] > 0){
			//limit order 只有在列表查询时才需要
			if(!empty($_GET['order']) && !empty($_GET['t'])){
				$bmWhereData['orderby']			=	$_GET['t'].','.$_GET['order'];
			}else{
				$bmWhereData['orderby']			=	'id';
			}

			$bmWhereData['limit']				=	$pages['limit'];		
			$List								=	$pxM -> getBmList($bmWhereData, array('scene' => 'detail'));
		}

        $this -> yunset('get_type', $_GET);
		$this -> yunset('rows', $List);
		$this -> yuntpl(array('admin/admin_trainpay'));
	}
	/**
	 * 会员 - 培训 - 课程报名
	 * 查看详情
	 * 2019-06-05 hjy
	 */
	public function edit_action(){
		$id										=	intval($_GET['id']);
		$order	=	$subject	=	$baoming	=	array();
		if(!empty($id)){
			$pxM								=	$this -> MODEL('train');
			$companyM							=	$this -> MODEL('company');
			$baoming							=	$pxM -> getBmInfo(array('id' => array('=', $id)));
			$subject							=	$pxM -> getSubInfo(array('id' => array('=', $baoming['sid'])), array('field' => '`name`,`price`,`isprice`'));
			$train								=	$pxM -> getInfo(array('uid' => array('=', $baoming['s_uid'])), array('field' => '`name`'));
			$baoming['trainname']				=	$train['name'];
			$orderField							=	'`id`,`sid`,`order_state`,`order_id`,`order_price`';
			$order								=	$companyM -> getOrderInfo(array('sid' => array('=', $id), 'type' => array('=', 6)),array('field'=>$orderField));
			include (APP_PATH."/config/db.data.php");
			$order['order_state_n']				=	$arr_data['paystate'][$order['order_state']];
		}
		$this -> yunset('order', $order);
		$this -> yunset('subject', $subject);
		$this -> yunset('row', $baoming);
		$this -> yuntpl(array('admin/admin_trainpay_edit'));
	}

	/**
	 * 会员 - 培训 - 课程报名
	 * 确认收费
	 * 2019-06-05 hjy
	 */
	public function setpay_action(){
		$del									=	intval($_GET['id']);
		if(empty($del)){
			$this->layer_msg("参数错误！",8);
		}
		$this -> check_token();
		$companyM								=	$this -> MODEL('company');
		$row									=	$companyM -> getOrderInfo(array('sid' => array('=', $del)));
		if($row['order_state'] == 1 || $row['order_state'] == 3){
			$nid								=	$this -> MODEL('qrorder') -> upuser_statis($row);
			isset($nid) ? $this -> layer_msg('订单记录(ID:'.$del.')确认成功！', 9) : $this -> layer_msg('确认失败,请销后再试！', 8);
		}else{
			$this -> layer_msg("订单已确认，请勿重复操作！", 8);
		}
	}

	/**
	 * 会员 - 培训 - 课程报名
	 * 删除课程报名
	 * 2019-06-05 hjy
	 */
	public function del_action(){
		$this -> check_token();
		$del									=	$_GET['del'];
		if(is_array($del)){
			$linkid								=	pylode(',',$del);
			$layer_type							=	1;
		}else{
			$linkid								=	$_GET['id'];
			$layer_type							=	0;
		}
		if(empty($linkid)){
			$this -> layer_msg('请选择您要删除的信息！', 8, $layer_type, $_SERVER['HTTP_REFERER']);
		}
		$pxM									=	$this -> MODEL('train');
		$delRes									=	$pxM -> delBm(array('id' => $linkid	));
		if($delRes['errcode'] == 9){
			$this->layer_msg($delRes['msg'], 9, $layer_type, $_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg($delRes['msg'], 8, $layer_type, $_SERVER['HTTP_REFERER']);
		}
	}
}
?>