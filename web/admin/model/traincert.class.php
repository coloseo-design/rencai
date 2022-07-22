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
class traincert_controller extends adminCommon{

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
			'param'		=>	'status',
			'name'		=>	'审核状态',
			'value'		=>	array(
				3		=>	'未审核',
				1		=>	'已审核',
				2		=>	'未通过'
			)
		);
		$search_list[]	=	array(
			'param'		=>	'apply',
			'name'		=>	'申请时间',
			'value'		=>	$this -> timeSection
		);
		$this -> yunset('search_list', $search_list);
	}
	/**
	 * 会员- 培训 - 培训认证审核
	 * 2019-06-05 hjy
	 */
	public function index_action(){
		$this->set_search();
		$certWhereData							=	array();
		$certWhereData['type']					=	5;

		//审核状态条件
		if(!empty($_GET['status'])){
			if ($_GET['status'] == 3){
				$certWhereData['status']		=	array('=', 0);
			}else{
				$certWhereData['status']		=	array('=', $_GET['status']);
			}
		}

		//关键词条件
		$keywordStr								=	trim($_GET['keyword']);
		$pxM									=	$this -> MODEL('train');
		$comids									=	array();
		if(!empty($keywordStr)){		
			$lt									=	$pxM -> getList(array('name' => array('like', $keywordStr)),array('field' => '`uid`,`name`'));
			if(!empty($lt)){
				foreach($lt as $val){
					$comids[]					=	$val['uid'];
				}				
			}else{
				$comids							=	array(0);
			}
		}
		if(!empty($comids)){
			$certWhereData['uid']				=	array('in', pylode(',', $comids));
		}

		//申请时间条件
		$endStr									=	intval($_GET['apply']);
		if(!empty($endStr)){
			if($endStr == 1){
				$certWhereData['ctime']			=	array('>=', strtotime(date("Y-m-d")));
			}else{
				$certWhereData['ctime']			=	array('>=', strtotime('-'.$endStr.'day'));
			}
		}

		$urlarr 								=	$_GET;
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
			$List								=	$companyM -> getCertList($certWhereData, array('utype'=>'pxcert'));
		}
		$this -> yunset('rows', $List);
		$this -> yunset('get_type', $_GET);
		$this -> yuntpl(array('admin/admin_train_cert'));
	}
	/**
	 * 会员- 培训 - 培训认证审核
	 * 审核认证 -> 获取审核数据
	 * 2019-06-05 hjy
	 */
	public function sbody_action(){
		$companyM								=	$this -> MODEL('company');
		$userinfo								=	$companyM -> getCertInfo(array('id' => array('=', $_POST['pid'])), array('field' => '`statusbody`'));
		echo $userinfo['statusbody'];die;
	}
	/**
	 * 会员- 培训 - 培训认证审核
	 * 审核认证 -> 保存审核数据
	 * 2019-06-05 hjy
	 */
	public function status_action(){
		$pxUid									=	trim($_POST['uid']);
		$pxPid									=	intval($_POST['pid']);
		$pxStatus								=	intval($_POST['status']);
		if(empty($pxUid)){
			$this -> ACT_layer_msg('非法操作！', 8, $_SERVER['HTTP_REFERER']);
		}

		//查询数据是否存在
		$pxM									=	$this -> MODEL('train');
		$pxlist									=	$pxM -> getList(array('uid' => array('in', $pxUid)), array('field' => '`linkmail`, `uid`, `name`'));
		if(empty($pxlist)){
			$this -> ACT_layer_msg('数据错误！', 8, $_SERVER['HTTP_REFERER']);
		}

		if($pxStatus != 1){
			$yyzz_status						=	0;
		}else{
			$yyzz_status						=	1;
		}

		$notice 								=	$this -> MODEL('notice');
		$sysmsgM								=	$this -> MODEL('sysmsg');
		$inteM									=	$this -> MODEL('integral');
		$companyM								=	$this -> MODEL('company');
		
		/* 消息前缀 */		
		$tagName  				=	'培训机构';
		
		foreach($pxlist as $v){
			 $uids[]  =  $v['uid'];
			 
			//修改lietou信息
			$pxM -> upInfo(array('uid' => array('=', $v['uid'])),array('yyzz_status' => $yyzz_status));
			
			/* 处理审核信息 */
			if ($pxStatus == 2){
				
				$statusInfo  =  $tagName.':'.$v['name'].'机构认证审核未通过 ';
				
				if($_POST['statusbody']){
					
					$statusInfo  .=  ', 原因：'.trim($_POST['statusbody']);
					
				}
				
				$msg[$v['uid']]  =  $statusInfo;
				
			}elseif($pxStatus == 1){
				
				$msg[$v['uid']]  =  $tagName.':'.$v['name'].'机构认证已审核通过';
				
			}

			//发送email
			if(!empty($v['linkmail'])){
				$notice -> sendEmailType(array(
						"uid"		=>	$v['uid'],
						"name"		=>	$v['name'],
						"email"		=>	$v['linkmail'],
						"comname"	=>	$v['name'],
						"type"		=>	"comcert"
					)
				);
			}
		}
		//发送系统通知
		$sysmsgM -> addInfo(array('uid'=>$uids,'usertype'=>4, 'content'=>$msg));
		//修改认证表中数据
		$upData				=	array(
			'status'		=>	$pxStatus,
			'statusbody'	=>	trim($_POST['statusbody'])
		);
		$id										=	$companyM -> upCertInfo(array('id' => array('in', $pxPid)), $upData,array('utype'=>'admin'));
		if($id){
			$this -> ACT_layer_msg('培训机构认证审核(UID:'.$_POST['status'].')设置成功！', 9 ,$_SERVER['HTTP_REFERER'], 2, 1);
		}else{
			$this -> ACT_layer_msg('设置失败！', 8, $_SERVER['HTTP_REFERER']);
		}
	}
	/**
	 * 会员- 培训 - 培训认证审核
	 * 审核认证 -> 删除审核数据
	 * 2019-06-05 hjy
	 */
	public function del_action(){
	    
	    $companyM       =   $this->MODEL('company');
	    
	    if (is_array($_POST['del'])) {
	        
	        $linkid     =   $_POST['del'];
	        
	    } else {
	        
	        $this   ->  check_token();
	        
	        $linkid     =   $_GET['uid'];
	    
	    }
	    
	    $pxM  =	$this -> MODEL('train');
	    
	    $pxM -> upInfo(array('uid' => array('in', pylode(',', $linkid))), array('yyzz_status' => 0));
	    
	    $err    =   $companyM -> delCert($linkid, array('type'=>'5'));
	    
	    $this   ->  layer_msg($err['msg'], $err['errcode'], $err['layertype'], $_SERVER['HTTP_REFERER']);
	}
	
	/**
	 * 会员- 培训 - 培训认证审核
	 * 数据统计
	 * 2019-06-05 hjy
	 */
	function pxcertNum_action(){
		$MsgNum = $this->MODEL('msgNum');
		echo $MsgNum->pxcertNum();
	}
}

?>