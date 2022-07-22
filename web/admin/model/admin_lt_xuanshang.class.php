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
class admin_lt_xuanshang_controller extends adminCommon{

	//时间区间
	public $timeSection	=	array(
		'1'		=>	'今天',
		'3'		=>	'最近三天',
		'7'		=>	'最近七天',
		'15'	=>	'最近半月',
		'30'	=>	'最近一个月'
	);

	/**
	 * 设置高级搜索功能
	 * 高级搜索参数
	 */
	public function set_search(){
		$search_list[]	=	array(
			'param'	=>	'look',
			'name'	=>	'信息状态',
			'value'	=>	array(
				0	=>	'未查看',
				1	=>	'已查看',
				2	=>	'已试用',
				3	=>	'未通过',
				4	=>	'已返利'
			)
		);
		$search_list[]	=	array(
			'param'	=>	'end',
			'name'	=>	'推荐时间',
			'value'	=>	$this -> timeSection
		);
		$search_list[]	=	array(
			'param'	=>	'reply',
			'name'	=>	'回复时间',
			'value'	=>	$this -> timeSection
		);
		$this -> yunset('search_list', $search_list);
	}
	/**
	 * 会员-猎头-猎头悬赏
	 * 2019-06-03 hjy
	 */
	public function index_action(){

		//获取搜索
		$this -> set_search();

		$keywordStr									=	trim($_GET['keyword']);
		$typeStr 									=	intval($_GET['type']);

		$memberWhereData	= 	$rebatesWhereData	=	array();
		$memberUid									=	array();
		$memberM									=	$this -> MODEL('userinfo');
		if(!empty($keywordStr) && !empty($typeStr)){
			$memberWhereData['username']			=	array('like', $keywordStr);
			$uidList								=	$memberM -> getList($memberWhereData, array('field' => '`uid`'));			
			if(!empty($uidList)){
				foreach($uidList as $uv){
					$memberUid[]					=	$uv['uid'];
				}
			}else{
				$memberUid							=	array(0);
			}
			$uidStr									=	pylode(',', $memberUid);
			if($typeStr == 1){
				$rebatesWhereData['uid']			=	array('in', $uidStr);
			}
			if($typeStr == 4){
				$rebatesWhereData['job_uid']		=	array('in', $uidStr);
			}
		}

		$endStr										=	intval($_GET['end']);
		$replyStr									=	intval($_GET['reply']);
		$statusStr									=	intval($_GET['status']);
		//推荐时间条件
		if(!empty($endStr)){
			if($endStr == 1){
				$rebatesWhereData['datetime']		=	array('>=', strtotime(date("Y-m-d")));
			}else{
				$rebatesWhereData['datetime']		=	array('>=', strtotime('-'.$endStr.'day'));
			}
		}
		//回复时间条件
		if(!empty($replyStr)){
			if($replyStr == 1){
				$rebatesWhereData['reply_time']		=	array('>=', strtotime(date("Y-m-d")));
			}else{
				$rebatesWhereData['reply_time']		=	array('>=', strtotime('-'.$replyStr.'day'));
			}
		}
		//信息状态条件
        if($_GET['look']){
			$rebatesWhereData['status']				=	array('=', $_GET['look']);
        }
		//状态条件
		if($statusStr == 1){
			$rebatesWhereData['edate']				=	array('>', time());
		}elseif ($statusStr == 2) {
			$rebatesWhereData['edate']				=	array('<', time());
		}elseif ($statusStr == 3) {
			$rebatesWhereData['status']				=	array('=', 3);
		}elseif ($statusStr == 4) {
			$rebatesWhereData['status']				=	array('=', 0);
		}

		$urlarr 									=	$_GET;
		$urlarr['page']								=	"{{page}}";
		$pageurl									=	Url($_GET['m'], $urlarr, 'admin');
		//提取分页
		$pageM										=	$this  -> MODEL('page');
		$pages										=	$pageM -> pageList('rebates', $rebatesWhereData, $pageurl, $_GET['page']);
		//分页数大于0的情况下 执行列表查询
		$List										=	array();
		$ltM										=	$this -> MODEL('lietou');
		if($pages['total'] > 0){
			//limit order 只有在列表查询时才需要
			if(!empty($_GET['order']) && !empty($_GET['t'])){
				$rebatesWhereData['orderby']		=	$_GET['t'].','.$_GET['order'];			
			}else{
				$rebatesWhereData['orderby']		=	array('status,asc', 'id,desc');
			}
			$rebatesWhereData['limit']				=	$pages['limit'];
			$List									=	$ltM -> getRebatesList($rebatesWhereData);
		}

		if(!empty($List)){
			$ltuid	=	$jobid						=	array();
			foreach($List as $lv){
				$ltuid[] 							=	$lv['uid'];
				$ltuid[] 							=	$lv['job_uid'];
				$jobid[]							=	$lv['job_id'];
			}
			$bcWhereData							=	array('uid' => array('in', pylode(',',$ltuid)));
			//补充用户相关的信息
			$memberField							=	'`uid`, `username`';
			$memberList								=	$memberM -> getList($bcWhereData, array('field' => $memberField));
			$memberListIndex						=	array();
			if(!empty($memberList)){
				foreach ($memberList as $memberV) {
					$memberListIndex[$memberV['uid']]	=	$memberV;
				}
			}
			//补充猎头职位相关的信息
			$ltjobField								=	'`id`, `com_name`, `job_name`, `rebates`';
			$ltjobM									=	$this -> MODEL('lietoujob');
			$ltjobList								=	$ltjobM -> getList(array('id' => array('in', pylode(',', $jobid))), array('field' => $ltjobField));
			$ltjobListIndex							=	array();
			if(!empty($ltjobList)){
				foreach ($ltjobList as $ltjobV) {
					$ltjobListIndex[$ltjobV['id']]	=	$ltjobV;
				}
			}

			//补充进相关信息
			foreach($List as $Lk => $Lv){
				if(isset($memberListIndex[$Lv['uid']])){
					$List[$Lk]['username']			=	$memberListIndex[$Lv['uid']]['username'];
				}
				if(isset($memberListIndex[$Lv['job_uid']])){
					$List[$Lk]['rname']				=	$memberListIndex[$Lv['uid']]['username'];
				}
				if(isset($ltjobListIndex[$Lv['job_id']])){
					$List[$Lk]['com_name'] 			=	$ltjobListIndex[$Lv['job_id']]['com_name'];
					$List[$Lk]['job_name'] 			=	$ltjobListIndex[$Lv['job_id']]['job_name'];
					$List[$Lk]['rebates']  			=	$ltjobListIndex[$Lv['job_id']]['rebates'];
				}
			}
		}

		$this -> yunset('get_type', $typeStr);
		$this -> yunset('list', $List);
		$this -> yuntpl(array('admin/admin_lt_xuanshang'));
	}

	/**
	 * 会员-猎头-查看悬赏
	 * 2019-06-03 hjy
	 */
	public function show_action(){
		$idStr	=	intval($_GET['id']);
		$rebate	=	$resume	=	array();
		if(!empty($idStr)){
			//获取悬赏信息
			$ltM	=	$this -> MODEL('lietou');
			$rebate	=	$ltM -> getRebatesInfo(array('id' => array('=', $idStr)));
			if(!empty($rebate)){
				//获取临时简历信息
				$resumeM	=	$this -> MODEL('resume');
				$resume		=	$resumeM -> getTempResumeInfo(array('rid' => array('=', $idStr)), array('scene' => 'detail'));
				
				if($resume['uname']	== $rebate['name']){
					$resume['telphone']	=	$rebate['phone'];
				}
			}
		}
		$this -> yunset('rebate', $rebate);
		$this -> yunset('resume', $resume);
		$this -> yuntpl(array('admin/admin_lt_xuanshang_show'));
	}

	/**
	 * 会员-猎头-猎头悬赏
	 * 删除悬赏
	 * 2019-06-03 hjy
	 */
	public function del_action(){
		$this -> check_token();
		if(!empty($_GET['del'])){
			$id		=	$_GET['del'];
		}else if(!empty($_GET['id'])){
			$id		=	$_GET['id'];
		}
		$ltM		=	$this -> MODEL('lietou');
		$result		=	$ltM -> delRebates($id);
		$this -> layer_msg($result['msg'],$result['errcode'], $result['layertype'], $_SERVER['HTTP_REFERER']);
	}

}
?>