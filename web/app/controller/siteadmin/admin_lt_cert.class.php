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
class admin_lt_cert_controller extends siteadmin_controller{

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
			'param'	=>	'status',
			'name'	=>	'审核状态',
			'value'	=>	array(
				'1'	=>	'已审核',
				'2'	=>	'未通过',
				'0'	=>	'未审核'
			)
		);
		$search_list[]	=	array(
			'param'	=>	'end',
			'name'	=>	'申请时间',
			'value'	=>	$this -> timeSection
		);
		$this->yunset("search_list",$search_list);
	}

	/**
	 * 会员-猎头-猎头认证管理
	 * 2019-06-01 hjy
	 */
	public function index_action(){

		//获取搜索
		$this->set_search();

		$certWhereData							=	array();
		$certWhereData['type']					=	4;

		//审核状态条件
		if(!empty($_GET['status'])){
			$certWhereData['status']			=	array('=', $_GET['status']);
		}

		//关键词条件
		$keywordStr								=	trim($_GET['keyword']);
		$ltM									=	$this -> MODEL('lietou');
		$comids									=	array();
		if(!empty($keywordStr)){		
			$lt									=	$ltM -> getList(array('realname' => array('like', $keywordStr)),array('field' => '`uid`,`realname`'));
			if(!empty($lt)){
				foreach($lt as $val){
					$comids[] 					=	$val['uid'];
				}				
			}else{
				$comids							=	array(0);
			}
		}
		if(!empty($comids)){
			$certWhereData['uid']				=	array('in', pylode(',', $comids));
		}

		//申请时间条件
		$endStr									=	intval($_GET['end']);
		if(!empty($endStr)){
			if($endStr == 1){
				$certWhereData['ctime']			=	array('>=', strtotime(date("Y-m-d")));
			}else{
				$certWhereData['ctime']			=	array('>=', strtotime('-'.$endStr.'day'));
			}
		}

		$urlarr['page']							=	"{{page}}";
		$pageurl								=	Url($_GET['m'], $urlarr, 'admin');
		//提取分页
		$pageM									=	$this  -> MODEL('page');
		$pages									=	$pageM -> pageList('company_cert', $certWhereData, $pageurl, $_GET['page']);
		//分页数大于0的情况下 执行列表查询
		$List									=	array();
		$companyM								=	$this -> MODEL('company');
		if($pages['total'] > 0){
			//limit order 只有在列表查询时才需要
			if(!empty($_GET['order']) && !empty($_GET['t'])){
				$certWhereData['orderby']		=	$_GET['t'].','.$_GET['order'];			
			}else{
				$certWhereData['orderby']		=	array('status,asc', 'id,desc');
			}
			$certWhereData['limit']				=	$pages['limit'];		
			$List								=	$companyM -> getCertList($certWhereData, array('utype'=>'ltcert'));
		}

		$this -> yunset('rows', $List);
		$this -> siteadmin_tpl(array('admin_lt_cert'));
	
	}

	/**
	 * 会员-猎头-猎头认证管理
	 * 审核认证 -> 获取审核数据
	 * 2019-06-01 hjy
	 */
	public function lockinfo_action(){
		$companyM								=	$this -> MODEL('company');
		$userinfo								=	$companyM -> getCertInfo(array('uid' => array('=', $_POST['uid']), 'type' => array('=', 4)), array('field' => '`statusbody`'));
		echo $userinfo['statusbody'];die;
	}

	/**
	 * 会员-猎头-猎头认证管理
	 * 审核认证 -> 保存数据
	 * 2019-05-31 hjy
	 */
	public function status_action(){
	    
 		$ltUid									=	trim($_POST['uid']);
		$ltStatus								=	intval($_POST['status']);
		if(empty($ltUid)){
			$this -> ACT_layer_msg('非法操作！', 8, $_SERVER['HTTP_REFERER']);
		}

		//查询数据是否存在
		$ltM									=	$this -> MODEL('lietou');
		$ltlist									=	$ltM -> getList(array('uid' => array('in', $ltUid)), array('field' => '`email`, `uid`, `realname`, `rzid`'));
		if(empty($ltlist)){
			$this -> ACT_layer_msg('数据错误！', 8, $_SERVER['HTTP_REFERER']);
		}

		if($ltStatus != 1){
			$cert_status						=	0;
		}else{
			$cert_status						=	1;
		}

		$notice 								=	$this -> MODEL('notice');
		$sysmsgM								=	$this -> MODEL('sysmsg');
		$inteM									=	$this -> MODEL('integral');
		$companyM								=	$this -> MODEL('company');
		
		/* 消息前缀 */		
		$tagName  								=	'职业资格';
		
		foreach($ltlist as $v){
			
			 $uids[]  =  $v['uid'];
						
			/* 处理审核信息 */
			if ($_POST['status'] == 2){
				
				$statusInfo  =  $tagName.':'.$v['name'].'审核未通过';
				
				if($_POST['statusbody']){
					
					$statusInfo  .=  ' , 原因：'.$_POST['statusbody'];
					
				}
				
				$msg[$v['uid']]  =  $statusInfo;
				
			}elseif($_POST['status'] == 1){
				
				$msg[$v['uid']]  =  $tagName.':'.$v['name'].'已审核通过';
				
			}
		}
		//发送系统通知
		$sysmsgM -> addInfo(array('uid'=>$uids,'usertype'=>3, 'content'=>$msg));
					
		foreach($ltlist as $v){
			$rzid								=	"YLT".sprintf("%08d", $v['uid']);
			//修改lietou信息
			$ltM -> upInfo(array('uid' => array('=', $v['uid'])),array('yyzz_status' => $cert_status, 'rzid' => $rzid));

			//记录系统日志
			if($ltStatus == 1){
				$certinfo						=	'职业资格审核通过！';
			}elseif($ltStatus == 2){
				$certinfo						=	'职业资格审核未通过！';
			}else{
				$certinfo						=	'职业资格待审核！';
			}	

			//发送email
			if(!empty($v['email'])){
				$notice -> sendEmailType(array(
						"uid"		=>	$v['uid'],
						"name"		=>	$v['realname'],
						"email"		=>	$v['email'],
						"certinfo"	=>	$certinfo,
						"comname"	=>	$v['realname'],
						"type"		=>	"comcert"
					)
				);
			}
			//审核通过 修改integral_ltcert
			if(empty($v['rzid']) && $ltStatus == 1){
				$inteM -> invtalCheck($v['uid'], 3,'integral_ltcert', '猎头执照认证',21);
			}
		}
		//修改认证表中数据
		$upData				=	array(
			'status'		=>	$ltStatus,
			'statusbody'	=>	trim($_POST['statusbody'])
		);
		
		$id										=	$companyM -> upCertInfo(array('uid' => array('in', $ltUid), 'type' => array('=', 4)), $upData,array('utype'=>'admin'));
		if($id){
			$this -> ACT_layer_msg('猎头认证(UID:'.$_POST['status'].')设置成功！', 9 ,$_SERVER['HTTP_REFERER'], 2, 1);
		}else{
			$this -> ACT_layer_msg('设置失败！', 8, $_SERVER['HTTP_REFERER']);
		}
	}

	/**
	 * 会员-猎头-猎头认证管理
	 * 删除认证
	 * 2019-06-01 hjy
	 */
	public function del_action(){
	    
	    $companyM      =   $this->MODEL('company');
	    
	    if (is_array($_POST['del'])) {
	        
	        $linkid    =   $_POST['del'];
	        
	    } else {
	        
	        $this   ->  check_token();
	        
	        $linkid    =   $_GET['id'];
	    }
	    
	    $ltM           =	$this -> MODEL('lietou');
	    
	    $ltM -> upInfo(array('uid' => array('in', pylode(',', $linkid))), array('yyzz_status' => 0));
	    
	    $err    =   $companyM -> delCert($linkid, array('type'=>'4'));
		
	    $this   ->  layer_msg($err['msg'], $err['errcode'], $err['layertype'], $_SERVER['HTTP_REFERER']);
	    
	}

	/**
	 * 会员-猎头-猎头认证管理
	 * 数据统计
	 * 2019-06-01 hjy
	 */
	public function ltcertNum_action(){
		$MsgNum 								=	$this -> MODEL('msgNum');
 		echo $MsgNum -> ltcertNum();
	}
}

?>