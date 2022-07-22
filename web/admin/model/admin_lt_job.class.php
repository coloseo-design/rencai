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
class admin_lt_job_controller extends adminCommon{

	/**
	 * 设置高级搜索功能
	 * 高级搜索参数
	 */
	public function set_search($ltdata = array(), $ltclass = array()){
		$ltar			=	array();
        foreach($ltdata['lt_exp'] as $k => $v){
			$ltar[$v]	=	$ltclass[$v];
		}
		$search_list[]	=	array('param'=>'zpstatus','name'=>'招聘状态','value'=>array('2'=>'招聘中','1'=>'已下架'));  
		$search_list[]	=	array(
			'param'	=>	'rec',
			'name'	=>	'推荐状态',
			'value' => array(
				'1' =>	'已推荐',
				'2'	=>	'未推荐'
			)
		);
		$search_list[]	=	array(
			'param'	=>	'status',
			'name'	=>	'审核状态',
			'value' => array(
				'1'	=>	'已审核',
				'3'	=>	'未通过',
				'4'	=>	'未审核',
        		'2'	=>	'已锁定'
			)
		);
		$search_list[] = array(
			'param' => 'ltexp',
			'name'	=> '工作经验',
			'value' => $ltar
		);
		$this -> yunset('search_list', $search_list);
	}

	/**
	 * 会员-猎头-猎头职位管理
	 * 2019-05-31 hjy
	 */
	public function index_action(){

		//获取相关参数
		$cacheArr			=	$this -> MODEL('cache') -> GetCache(array('lt', 'ltjob', 'city'));

		//获取搜索
		$this -> set_search($cacheArr['ltdata'], $cacheArr['ltclass_name']);

		$memberWhereData	= 	$ltJobWhereData	= array();

		$keywordStr								=	trim($_GET['keyword']);
		$ltnameStr 								=	intval($_GET['ltname']);

		//如果有用户相关的搜索条件,则先获取用户的id
		if(!empty($keywordStr) && $ltnameStr == 1){
			$memberWhereData['username']		=	array('like', $keywordStr);
		}
		$memberUid								=	array();
		$memberM								=	$this -> MODEL('userinfo');
		if(!empty($memberWhereData)){
			$resWhere							=	array_merge(array('usertype' => array('=', 3)), $memberWhereData);
			$uidList							=	$memberM -> getList($resWhere, array('field' => '`uid`'));			
			if(!empty($uidList)){
				foreach($uidList as $uv){
					$memberUid[]				=	$uv['uid'];
				}
			}else{
				$memberUid						=	array(0);
			}
		}
		if(!empty($memberUid)){
			$ltJobWhereData['uid']				=	array('in', pylode(',', $memberUid));
		}

		//职位名称条件
		if(!empty($keywordStr) && $ltnameStr == 2){
			$ltJobWhereData['job_name']			=	array('like', $keywordStr);
		}
		//公司名称条件
		if(!empty($keywordStr) && $ltnameStr == 3){
			$ltJobWhereData['com_name']			=	array('like', $keywordStr);
		}
		//工作经验条件
		if(!empty($_GET['ltexp'])){
			$ltJobWhereData['exp']				=	array('=', $_GET['ltexp']);
		}
		if(!empty($_GET['zpstatus'])){
			$zpstatus       =   intval($_GET['zpstatus']);
			$ltJobWhereData['zp_status']     =   $zpstatus == 2 ? 0 : $zpstatus;
		}
		//审核状态条件
		if(!empty($_GET['status'])){
			if($_GET['status']=="1"){
				$ltJobWhereData['status']		=	1;
        		$ltJobWhereData['r_status']		=	1;
			}elseif($_GET['status']=="2"){
				$ltJobWhereData['r_status']		=	2;
			}elseif($_GET['status']=="3"){
				$ltJobWhereData['status']		  =	3;
			}elseif($_GET['status']=="4"){
				$ltJobWhereData['status']		=	0;
			}
		}
		//推荐状态条件
		if(!empty($_GET['rec'])){
			if($_GET['rec']=='2'){
				$ltJobWhereData['rec']			=	array('=', 0);
			}else{
				$ltJobWhereData['rec']			=	array('=', $_GET['rec']);
			}
		}

		$urlarr 								=	$_GET;
		$urlarr['page']							=	"{{page}}";
		$pageurl								=	Url($_GET['m'], $urlarr, 'admin');
		//提取分页
		$pageM									=	$this  -> MODEL('page');
		$pages									=	$pageM -> pageList('lt_job', $ltJobWhereData, $pageurl, $_GET['page']);
		//分页数大于0的情况下 执行列表查询
		$List									=	array();
		$ltjobM									=	$this -> MODEL('lietoujob');
		if($pages['total'] > 0){
			//limit order 只有在列表查询时才需要
			if(!empty($_GET['order']) && !empty($_GET['t'])){
				$ltJobWhereData['orderby']		=	$_GET['t'].','.$_GET['order'];
			}else{
				$ltJobWhereData['orderby']		=	array('r_status,asc','status,asc', 'id,desc');
			}
			$ltJobWhereData['limit']			=	$pages['limit'];		
			$List								=	$ltjobM -> getList($ltJobWhereData);
		}
		if(!empty($List)){
			$ltuid								=	array();
			foreach($List as $lv){
				$ltuid[] 						=	$lv['uid'];
			}
			$bcWhereData						=	array('uid' => array('in', pylode(',',$ltuid)));
			//补充用户相关的信息
			$memberField						=	'`uid`, `username`';
			$memberList							=	$memberM -> getList($bcWhereData, array('field' => $memberField));
			$memberListIndex					=	array();
			if(!empty($memberList)){
				foreach ($memberList as $memberV) {
					$memberListIndex[$memberV['uid']]	=	$memberV;
				}
			}
			//补充进相关信息
			foreach($List as $Lk => $Lv){
				if(isset($memberListIndex[$Lv['uid']])){
					$List[$Lk]					=	array_merge($List[$Lk], $memberListIndex[$Lv['uid']]);
				}
				$List[$Lk]['jobone']			=	$cacheArr['ltjob_name'][$Lv['jobone']];
		        $List[$Lk]['exp']				=	$cacheArr['ltclass_name'][$Lv['exp']];
			    $List[$Lk]['cityid']			=	$cacheArr['city_name'][$Lv['cityid']];
			}
		}

		$this -> yunset("get_type", $_GET);
        $this -> yunset("rows", $List);
		$this -> yuntpl(array('admin/admin_lt_job'));
	}
    /**
	 * 会员-猎头-猎头职位管理
	 * 审核职位 -> 同步审核用户
	 * 
	 */
    function ltjobstatus_action()
    {
        if ($_POST) {
            
            $id         =   intval($_POST['ltid']);
            $uid        =   intval($_POST['ltuid']);
            $status     =   intval($_POST['r_status']);
            $statusbody =   trim($_POST['statusbody']);
            
            $lietoujobM =   $this->MODEL('lietoujob');
            
            $post   =   array(
                
                'uid'           =>  $uid,
                'status'        =>  $status,
                'statusbody'    =>  $statusbody
            );
            
            $return     =   $lietoujobM -> status($id, $post);
            $this -> ACT_layer_msg($return['msg'], $return['errcode'], $_SERVER['HTTP_REFERER'], 2, 1);
        }
    }
	/**
	 * 会员-猎头-猎头职位管理
	 * 审核职位 -> 保存数据
	 */
	public function status_action()
	{
	    $ltjobM   =	  $this -> MODEL('lietoujob');
	    
	    $statusData = array(
	        
	        'status'       =>  intval($_POST['status']),
	        'statusbody'   =>  trim($_POST['statusbody'])
	    );
	    
	    $return = $ltjobM -> statusLtjob($_POST['pid'], $statusData);
	    
	    $this->ACT_layer_msg($return['msg'], $return['errcode'], $_SERVER['HTTP_REFERER'], 2, 1);
	}

	/**
	 * 会员-猎头-猎头职位管理
	 * 审核职位-> 获取审核数据
	 * 2019-05-31 hjy
	 */
	public function lockinfo_action(){
		$ltjobM		=	$this -> MODEL('lietoujob');
		$userinfo	=	$ltjobM -> getInfo(array('id' => array('=', $_GET['id'])), array('field' => '`statusbody`'));
		echo $userinfo['statusbody'];die;
	}

	/**
	 * 会员-猎头-猎头职位管理
	 * 设置推荐
	 * 2019-05-31 hjy
	 */
	public function recommend_action(){

		$this -> check_token();
		$ltjobId					=	intval($_GET['id']);
		$ltjobRec					=	intval($_GET['rec']);
		$ltjobType					=	trim($_GET['type']);
		$ltjobM						=	$this -> MODEL('lietoujob');
		$ltjobInfo					=	$ltjobM -> getInfo(array('id' => array('=', $ltjobId)), array('field' => '`job_name`, `uid`'));
		if(empty($ltjobInfo)){
			echo 0;die;
		}

		$upData		=	array();
		$msgContent	=	'';
		if($ltjobRec == 0){
			$upData['rec']			=	0;
			$upData['rec_time']		=	'';
			$msgContent	=	'管理员设置：取消推荐职位《'.$ltjobInfo['job_name'].'》';
		}elseif($ltjobRec == 1){
			$upData['rec']			=	1;
			$upData['rec_time']		=	time();
			$msgContent	=	'管理员设置：推荐职位《'.$ltjobInfo['job_name'].'》';
		}
		//修改职位状态
		if(!empty($upData)){
			$ltjobM -> upInfo(array('id' => array('=', $ltjobId)), $upData);
		}
		//记录系统日志
		if(!empty($msgContent)){
			$sysmsgM				=	$this -> MODEL('sysmsg');
			$sysmsgM -> addInfo(array('content' => $msgContent,'usertype'=>3,  'uid' => $ltjobInfo['uid']));
		}

		echo 1;die;
	}

	/**
	 * 会员-猎头-猎头职位管理
	 * 删除职位
	 * 2019-05-31 hjy
	 */
	public function del_action(){
		$this->check_token();
		$ltjobM		=	$this -> MODEL('lietoujob');
		$delRes		=	$ltjobM -> delLietouJob($_GET['del'],array('utype'=>'admin'));
		$this -> layer_msg($delRes['msg'], 9, $delRes['layertype'], $_SERVER['HTTP_REFERER']);
	}

	/**
	 * 会员-猎头-猎头职位管理
	 * 数据统计
	 * 2019-05-31 hjy
	 */
	public function ltjobNum_action(){
		$MsgNum	=	$this -> MODEL('msgNum');
		echo $MsgNum -> ltjobNum();
	}
}
?>