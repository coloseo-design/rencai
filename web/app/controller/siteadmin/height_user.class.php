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
class height_user_controller extends siteadmin_controller{

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
	 * 2019-05-31 hjy
	 */
	public function set_search(){
		include PLUS_PATH."/user.cache.php";
        foreach($userdata['user_type'] as $k=>$v){
               $ltar[$v]=$userclass_name[$v];
        }
        foreach($userdata['user_report'] as $k=>$v){
               $ltarry[$v]=$userclass_name[$v];
        }
        $search_list[]	=	array(
			"param"		=>	"rec",
			"name"		=>	'推荐状态',
			"value"		=>	array(
				"1"		=>	"已推荐",
				"2"		=>	"未推荐"
			)
		);
        $search_list[]	=	array(
			"param"		=>	"searchtype",
			"name"		=>	'工作性质',
			"value"		=>	$ltar
		);
        $search_list[]	=	array(
			"param"		=>	"status",
			"name"		=>	'审核状态',
			"value"		=>	array(
				"1"		=>	"未审核",
				"2"		=>	"已审核",
				"3"		=>	"未通过",
        "4"   =>  "已锁定"
			)
		);
        $search_list[]	=	array(
			"param"		=>	"verify",
			"name"		=>	'审核时间',
			"value"		=>	$this -> timeSection
		);
        $search_list[]	=	array(
			"param"		=>	"searchreport",
			"name"		=>	'到岗时间',
			"value"		=>	$ltarry
		);
		$this -> yunset("search_list",$search_list);
	}
	
	/**
	 * 会员-猎头-优质人才简历
	 * 2019-05-31 hjy
	 */
	public function index_action(){

		//获取相关参数
		$cacheArr	=	$this -> MODEL('cache') -> GetCache(array('user'));

		//获取搜索
		$this -> set_search($cacheArr['userdata'], $cacheArr['userclass_name']);

		$memberWhereData	= 	$huWhereData	=	array();
		$huWhereData['height_status']		=	array('<>', 0);

		//工作性质条件
		if(!empty($_GET['searchtype'])){
			$huWhereData['type']			=	array('=', $_GET['searchtype']);
		}

		//到岗时间条件
		if(!empty($_GET['searchreport'])){
			$huWhereData['report']			=	array('=', $_GET['searchreport']);
		}

		$keywordStr							=	trim($_GET['keyword']);
		$snameStr							=	intval($_GET['searchrname']);

		//如果有用户相关的搜索条件,则先获取用户的id
		if(!empty($keywordStr) && $snameStr == 1){
			$memberWhereData['username']	=	array('like', $keywordStr);
		}
		$memberUid							=	array();
		$memberM							=	$this -> MODEL('userinfo');
		if(!empty($memberWhereData)){
			$resWhere						=	array_merge(array('usertype' => array('=', 1)), $memberWhereData);
			$uidList						=	$memberM -> getList($resWhere, array('field' => '`uid`'));			
			if(!empty($uidList)){
				foreach($uidList as $uv){
					$memberUid[]			=	$uv['uid'];
				}
			}else{
				$memberUid					=	array(0);
			}
		}
		if(!empty($memberUid)){
			$huWhereData['uid']				=	array('in', pylode(',', $memberUid));
		}

		//简历名称条件
		if(!empty($keywordStr) && $snameStr == 2){
			$huWhereData['name']			=	array('like', $keywordStr);
		}
		//审核状态
		if(!empty($_GET['status'])){
      if($_GET['status']==4){
        $huWhereData['r_status']		=	array('>', 1);
      }else{
        $huWhereData['r_status']		=	1;
        $huWhereData['height_status']	=	$_GET['status'];
      }
    }
		//推荐状态条件
		if(!empty($_GET['rec'])){
			if($_GET['rec']=='2'){
				$huWhereData['rec']			=	array('=', 0);
			}else{
				$huWhereData['rec']			=	array('=', $_GET['rec']);
			}
		}
		//审核时间条件
		$verifyStr							=	intval($_GET['verify']);
		if(!empty($verifyStr)){
			if($verifyStr == 1){
				$huWhereData['status_time']	=	array('>=', strtotime(date("Y-m-d")));
			}else{
				$huWhereData['status_time']	=	array('>=', strtotime('-'.$verifyStr.'day'));
			}
		}

		$urlarr['page']							=	"{{page}}";
		$pageurl								=	Url($_GET['m'], $urlarr, 'admin');
		//提取分页
		$pageM									=	$this  -> MODEL('page');
		$pages									=	$pageM -> pageList('resume_expect', $huWhereData, $pageurl, $_GET['page']);
		//分页数大于0的情况下 执行列表查询
		$List									=	array();
		$resumeM								=	$this -> MODEL('resume');
		if($pages['total'] > 0){
			//limit order 只有在列表查询时才需要
			if(!empty($_GET['order']) && !empty($_GET['t'])){
				if($_GET['t'] == 'time'){
					$huWhereData['orderby']		=	'status_time,'.$_GET['order'];
				}else{
					$huWhereData['orderby']		=	$_GET['t'].','.$_GET['order'];
				}				
			}else{
				$huWhereData['orderby']			=	array('height_status,asc', 'id,desc');
			}
			$huWhereData['limit']				=	$pages['limit'];		
			$List								=	$resumeM -> getList($huWhereData, array('utype' => 'admin'));
		}
		$this -> yunset("get_type", $_GET);
		$this -> yunset("rows", $List['list']);
    $this -> siteadmin_tpl(array('admin_height_user'));

	}

	/**
	 * 会员-猎头-优质人才简历
	 * 审核职位-> 获取审核数据
	 * 2019-05-31 hjy
	 */
	public function lockinfo_action(){
		$reId									=	intval($_POST['pid']);
		$resumeM								=	$this -> MODEL('resume');
		$row									=	$resumeM -> getExpect(array('id' => array('=', $reId)), array('field' => '`statusbody`'));
		echo $row['statusbody'];die;
	}

	/**
	 * 会员-猎头-优质人才简历
	 * 审核职位 -> 保存数据
	 * 2019-05-31 hjy
	 */
	public function status_action(){
		$reId									=	trim($_POST['pid']);
		if(empty($reId)){
			$this->ACT_layer_msg('审核设置失败！', 8, $_SERVER['HTTP_REFERER']);
		}

		$resumeM								=	$this -> MODEL('resume');

		//查询数据是否存在
		$list	=	$resumeM -> getSimpleList(array('id' => array('in', $reId)), array('field' => '`id`,`uid`,`name`'));
		if(empty($list)){
			$this->ACT_layer_msg('数据错误！', 8, $_SERVER['HTTP_REFERER']);
		}

		//修改简历参数
		$upData									=	array();
		$upData['height_status']				=	$_POST['status'];
		$upData['statusbody']					=	$_POST['statusbody'];
		$upData['status_time']					=	time();
		$resumeM -> upInfo(array('id' => array('in', $reId)), array('eData'=>$upData));
		
		/* 消息前缀 */		
		$tagName  				=	'优质简历';
		
		foreach($list as $v){
			
			 $uids[]  =  $v['uid'];
						
			/* 处理审核信息 */
			if ($_POST['status'] == 3){
				
				$statusInfo  =  $tagName.':<a href="resumetpl,'.$v['id'].'">'.$v['name'].'</a>审核未通过';
				
				if($_POST['statusbody']){
					
					$statusInfo  .=  ' , 原因：'.$_POST['statusbody'];
					
				}
				
				$msg[$v['uid']][]  =  $statusInfo;
				
			}elseif($_POST['status'] == 2){
				
				$msg[$v['uid']][]  =  $tagName.':<a href="resumetpl,'.$v['id'].'">'.$v['name'].'</a>已审核通过';
				
			}
		}
		//发送系统通知
		
		$sysmsgM	=	$this->MODEL('sysmsg');
		
		$sysmsgM -> addInfo(array('uid'=>$uids,'usertype'=>1, 'content'=>$msg));

		//记录管理员日志
		$this -> MODEL('log') -> addAdminLog('优质人才(ID:'.$reId.')审核设置成功');

		$this -> ACT_layer_msg('审核设置成功！', 9, $_SERVER['HTTP_REFERER']);

	}

	/**
	 * 会员-猎头-优质人才简历
	 * 设置推荐
	 * 2019-06-01 hjy
	 */
	public function recommend_action(){

		$resumeId								=	intval($_GET['id']);
		$resumeRec								=	intval($_GET['rec']);
		$resumeM								=	$this -> MODEL('resume');

		//获取哦简历信息
		$resume	=	$resumeM -> getExpect(array('id' => $resumeId), array('field' => '`id`,`name`,`uid`'));
		if(empty($resume)){
			echo 0;die;
		}

		//修改推荐状态
		$nid = $resumeM -> upInfo(array('id' => array('=', $resumeId)),array('eData'=>array(''.$_GET['type'].''=>$resumeRec)));
		//记录系统日志
		$sysmsgM								=	$this -> MODEL('sysmsg');
		if($nid && $resumeRec == 1){
			$sysmsgM -> addInfo(array('content' => '管理员设置：推荐优质简历<a href="resumetpl,'.$resume['id'].'">《'.$resume['name'].'》</a>','usertype'=>1,  'uid' => $resume['uid']));
		}elseif($nid && $resumeRec == 0){
			$sysmsgM -> addInfo(array('content' => '管理员设置：取消推荐优质简历<a href="resumetpl,'.$resume['id'].'">《'.$resume['name'].'》</a>','usertype'=>1,  'uid' => $resume['uid']));
		}

		//记录管理员日志
		$this->MODEL('log')->addAdminLog('优质人才(ID:'.$_GET['id'].')推荐成功');
		echo $nid?1:0;die;
	}

	/**
	 * 会员-猎头-优质人才简历
	 * 删除简历
	 * 2019-06-01 hjy
	 */
	public function del_action(){
		$this->check_token();
		$del									=	$_GET['del'];
		if(empty($del)){
			$this->layer_msg('请选择您要删除的优质人才！', 8, 1, $_SERVER['HTTP_REFERER']);
		}
		$resumeM								=	$this -> MODEL('resume');
		if(is_array($del)){
			$del								=	pylode(',', $del);
			$layer_type							=	1;
		}else{
			$layer_type							=	0;
		}

		$list	=	$resumeM -> getSimpleList(array('id' => array('in', $del)), array('field' => '`id`,`uid`,`name`'));
		if(empty($list)){
			$this->layer_msg('参数错误！', 8, 1, $_SERVER['HTTP_REFERER']);
		}

		//修改简历状态
		$resumeM -> upInfo(array('id' => array('=', $del)), array('eData'=>array('height_status' => 0)));

		//记录系统日志
		$sysmsgM								=	$this -> MODEL('sysmsg');
		foreach ($list as $v) {
			$sysmsgM -> addInfo(array('content' => '管理员设置：取消优质简历<a href="resumetpl,'.$v['id'].'">《'.$v['name'].'》</a>','usertype'=>1,  'uid' => $v['uid']));
		}
		
		$this->layer_msg('优质人才(ID:'.$del.')删除成功！',9, $layer_type, $_SERVER['HTTP_REFERER']);
	}

	/**
	 * 会员-猎头-优质人才简历
	 * 数据统计
	 * 2019-06-01 hjy
	 */
	function gresumeNum_action(){
		$MsgNum	=	$this -> MODEL('msgNum');
		echo $MsgNum -> gresumeNum();
	}
}
?>