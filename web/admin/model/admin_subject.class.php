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
class admin_subject_controller extends adminCommon{

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
			'param'		=>	'rec',
			'name'		=>	'是否推荐',
			'value'		=>	array(
				1		=>	'已推荐',
				2		=>	'未推荐'
			)
		);
		$search_list[]	=	array(
			'param'		=>	'status',
			'name'		=>	'审核状态',
			'value'		=>	array(
				1		=>	'已审核',
				3		=>	'未审核',
				2		=>	'未通过',
        4		=>	'已锁定'
			)
		);
		$search_list[]	=	array(
			'param'		=>	'publish',
			'name'		=>	'发布时间',
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
	 * 会员- 培训 - 培训课程管理
	 * 全部培训
	 * 2019-06-04 hjy
	 */
	public function index_action(){
		$this -> set_search();

		$subWhereData							=	array();
		$keywordStr								=	trim($_GET['keyword']);
		$typeStr								=	intval($_GET['type']);

		//课程名称条件
		if(!empty($keywordStr) && $typeStr == 1){
			$subWhereData['name']				=	array('like', $keywordStr);
		}
		//地址条件
		if(!empty($keywordStr) && $typeStr == 2){
			$subWhereData['address']			=	array('like', $keywordStr);
		}
		//审核状态条件
		if(!empty($_GET['status'])){
			if ($_GET['status'] == 3){
				$subWhereData['status']			=	  array('=', 0);
			}elseif($_GET['status']==4){
				$subWhereData['r_status']		=	  array('>', 1);
			}else{
				$subWhereData['status']			=	  array('=', $_GET['status']);
			}
		}

		$publishStr								=	intval($_GET['publish']);
		//发布时间条件
		if(!empty($publishStr)){
			if($publishStr == 1){
				$subWhereData['ctime']			=	array('>=', strtotime(date("Y-m-d")));
			}else{
				$subWhereData['ctime']			=	array('>=', strtotime('-'.$publishStr.'day'));
			}
		}
		//推荐条件
		if(!empty($_GET['rec'])){
			if ($_GET['rec'] == 2){
				$subWhereData['rec']			=	array('=', 0);
			}else{
				$subWhereData['rec']			=	array('=', $_GET['rec']);
			}
		}
		//收费方式条件
		if(!empty($_GET['isprice'])){
			$subWhereData['isprice']			=	array('=', $_GET['isprice']);
		}

		$urlarr 								=	$_GET;
		$urlarr['page']							=	"{{page}}";
		$pageurl								=	Url($_GET['m'], $urlarr, 'admin');
		//提取分页
		$pageM									=	$this  -> MODEL('page');
		$pages									=	$pageM -> pageList('px_subject', $subWhereData, $pageurl, $_GET['page']);

		//分页数大于0的情况下 执行列表查询
		$List									=	array();
		$pxM									=	$this -> MODEL('train');
		if($pages['total'] > 0){
			//limit order 只有在列表查询时才需要
			if(!empty($_GET['order']) && !empty($_GET['t'])){
				$subWhereData['orderby']		=	$_GET['t'].','.$_GET['order'];
			}else{
				$subWhereData['orderby']		=	array('r_status,asc','status,asc', 'id,desc');
			}

			$subWhereData['limit']				=	$pages['limit'];		
			$List								=	$pxM -> getSubList($subWhereData);
		}
		if(!empty($List)){
			$pxuid								=	array();
			$memM								=	$this -> MODEL('userinfo');
			foreach($List as $lv){
				$pxuid[] 						=	$lv['uid'];
			}
			$bcWhereData						=	array('uid' => array('in', pylode(',', $pxuid)));
			//补充用户相关的信息
			$memField							=	'`uid`, `username`';
			$memList							=	$memM -> getList($bcWhereData, array('field' => $memField));
			$memListIndex						=	array();
			if(!empty($memList)){
				foreach ($memList as $pxV) {
					$memListIndex[$pxV['uid']]	=	$pxV;
				}
			}
			$cacheList							=	$this -> MODEL('cache') -> GetCache(array('city'));
			//补充进相关信息
			foreach($List as $Lk => $Lv){
				if(isset($memListIndex[$Lv['uid']])){
					$List[$Lk]['username']		=	$memListIndex[$Lv['uid']]['username'];
				}
				$List[$Lk]['threecityid']		=	$cacheList['city_name'][$Lv['threecityid']];
				$List[$Lk]['cityid']			=	$cacheList['city_name'][$Lv['cityid']];
			}
		}

		$this -> yunset('lotime', $this -> timeSection);
		$this -> yunset('rows', $List);
		$this -> yunset('get_type', $_GET);
		$this -> yuntpl(array('admin/admin_subject'));
	}
	/**
	 * 会员- 培训 - 培训课程管理
	 * 审核信息
	 * 2019-06-05 hjy
	 */
	function lockinfo_action(){
		$pxM									=	$this -> MODEL('train');
		$rows									=	$pxM -> getSubInfo(array('id' => array('=', $_POST['id'])), array('field' => '`statusbody`'));
		echo $rows['statusbody'];die;
	}
	
    function subjectstatus_action()
    {
        if ($_POST) {
            
            $id         =   intval($_POST['tid']);
            $uid        =   intval($_POST['tuid']);
            $status     =   intval($_POST['r_status']);
            $statusbody =   trim($_POST['statusbody']);
            
            
            $pxM    =   $this->MODEL('train');
             
            $post   =   array(
                
                'uid'           =>  $uid,
                'status'        =>  $status==3 ? 2: 1 ,
                'statusbody'    =>  $statusbody
            );
            
            $return     =   $pxM -> statusSubject($id, $post);
            
            $this -> ACT_layer_msg($return['msg'], $return['errcode'], $_SERVER['HTTP_REFERER'], 2, 1);
        }
    }
	/**
	 * 会员- 培训 - 培训课程管理
	 * 审核课程
	 * 2019-06-05 hjy
	 */
	public function status_action(){
		$postData								=	$this -> post_trim($_POST);
		$id										=	trim($postData['id'], ',');
		if(empty($id)){
			$this -> ACT_layer_msg('非法操作！', 8, $_SERVER['HTTP_REFERER']);
		}
		$pxM									=	$this -> MODEL('train');

		$subList								=	$pxM -> getSubList(array('id' => array('in', $id),'r_status'=>1), array('field' => '`uid`, `name`'));
		$noticeType				=	'';
		if($postData['status'] == 1){
			$noticeType							=	"subjectshtg";
		}elseif($postData['status'] == 2){
			$noticeType							=	"subjectshwtg";
		}
		
		/* 消息前缀 */		
		$tagName  				=	'课程';
		
		foreach($subList as $v){
			
			 $uidArr[]  =  $v['uid'];
						
			/* 处理审核信息 */
			if ($postData['status'] == 2){
				
				$statusInfo  =  $tagName.':'.$v['name'].'审核未通过 , ';
				
				if($postData['statusbody']){
					
					$statusInfo  .=  '原因：'.$postData['statusbody'];
					
				}
				
				$msg[$v['uid']][]  =  $statusInfo;
				
			}elseif($postData['status'] == 1){
				
				$msg[$v['uid']][]  =  $tagName.':'.$v['name'].'已审核通过';
				
			}
		}
		//发送系统通知
		$sysmsgM	=	$this->MODEL('sysmsg');
		
		$sysmsgM -> addInfo(array('uid'=>$uidArr,'usertype'=>4, 'content'=>$msg));
		
		$uidArr									=	array_unique($uidArr);
		$pxField								=	array('field' => '`uid`, `name`, `linktel`, `linkmail`');
		$pxList									=	$pxM -> getList(array('uid' => array('in', pylode(',', $uidArr),'r_status'=>1)), $pxField);
		$pxListIndex							=	array();
		foreach ($pxList as $pxV) {
			$pxListIndex[$pxV['uid']]			=	$pxV;
		}
		//发送email sms通知
		$notice 								=	$this->MODEL('notice');
		foreach ($subList as $sV) {
			$sendArr							=	array();
			$sendArr['type']					=	$noticeType;
			$sendArr['uid']						=	$sV['uid'];
			$sendArr['name']					=	$pxListIndex[$sV['uid']]['name'];
			$sendArr['email']					=	$pxListIndex[$sV['uid']]['linkmail'];
			$sendArr['moblie']					=	$pxListIndex[$sV['uid']]['linktel'];
			$sendArr['subjectname']				=	$sV['name'];
			$sendArr['date']					=	date("Y-m-d H:i:s");
			$sendArr['status_info']				=	$postData['statusbody'];
			if(!empty($sendArr['email'])){
				$notice -> sendEmailType($sendArr);
			}
			if(!empty($sendArr['moblie'])){

				$sendArr['port']	=	'5';
				$notice -> sendSMSType($sendArr);
			}
		}
		//修改课程字段
		$nid									=	$pxM->upSubInfo(array('id' => array('in', $id),'r_status'=>1), array('status' => $postData['status'], 'statusbody' => $postData['statusbody']));
		if(!empty($nid)){

			$pxsubjectwhere['id']				 =		array('in', $id);
			$pxsubjectnum						 =		$pxM->getPxSubjectNum($pxsubjectwhere);
			if($pxsubjectnum>1){
				$pxsubjecttwhere['id']           =     array('in',$id);
				$pxsubjecttwhere['r_status']     =     1;
				$pxsubjecttnum                   =     $pxM->getPxSubjectNum($pxsubjecttwhere);
				$pxsubjectwwhere['id']           =     array('in',$id);
				$pxsubjectwwhere['r_status']     =     array('<>',1);
				$pxsubjectwnum              	 =     $pxM->getPxSubjectNum($pxsubjectwwhere);
				if($pxsubjectwnum>0){
                    $msg='培训课程批量审核成功'.$pxsubjecttnum.'条，失败'.$pxsubjectwnum.'条。原因:培训账户未审核！';
                }else{
                    $msg='培训课程批量审核成功(ID:'.$id.')';
                }
                $this -> ACT_layer_msg($msg, 9, $_SERVER['HTTP_REFERER'], 2, 1);
			}else{
				$pxwwhere['id']           =     array('in',$id);
				$pxwwhere['r_status']     =     array('<>',1);
				$pxtnum                   =     $pxM->getPxSubjectNum($pxwwhere);
				if($pxtnum>0){
					$this -> ACT_layer_msg('培训课程审核(ID:'.$id.')失败，原因:培训账户未审核！', 8, $_SERVER['HTTP_REFERER']);
				}else{
					$this -> ACT_layer_msg('培训课程审核(ID:'.$id.')设置成功！', 9, $_SERVER['HTTP_REFERER'], 2, 1);
				}
			}	

		}else{
			$this -> ACT_layer_msg('设置失败！', 8, $_SERVER['HTTP_REFERER']);
		}
	}

	/**
	 * 会员- 培训 - 培训课程管理
	 * 设置推荐
	 * 2019-06-05 hjy
	 */	
	public function rec_action(){
		$this->check_token();

		$pxId									=	intval($_GET['id']);
		$pxRec									=	intval($_GET['rec']);
		$upData									=	array();
		$upData['rec']							=	$pxRec;
		$pxM									=	$this -> MODEL('train');
		$whereData								=	array('id' => array('=', $pxId));
		$info									=	$pxM -> getSubInfo($whereData, array('field' => '`uid`, `name`'));
		if(empty($info)){
			$this -> layer_msg('设置失败！', 8, 0, $_SERVER['HTTP_REFERER']);
		}
		$nid 									=	$pxM -> upSubInfo($whereData, $upData);
		$sysmsgM								=	$this -> MODEL('sysmsg');
		if($nid && $pxRec == 1){
			$sysmsgM -> addInfo(array('content' => '管理员设置：推荐课程'.$info['name'],'usertype'=>4,  'uid' => $info['uid']));
		}elseif($nid && $pxRec == 0){
			$sysmsgM -> addInfo(array('content' => '管理员操作：取消课程推荐'.$info['name'],'usertype'=>4,  'uid' => $info['uid']));
		}
		$this -> MODEL('log') -> addAdminLog("培训课程推荐(ID:".$pxId.")推荐设置成功！");
		echo $nid?1:0;die;
	}
	/**
	 * 会员- 培训 - 培训课程管理
	 * 修改课程
	 * 2019-06-05 hjy
	 */	
	public function add_action(){
		$idStr									=	intval($_GET['id']);
		if(!empty($idStr)){
			$pxM								=	$this -> MODEL('train');
			$row								=	$pxM -> getSubInfo(array('id' => array('=', $idStr)));
			$row['type']						=	@explode(",", $row['type']);
			$row['teachid']						=	@explode(',', $row['teachid']);
			$teaWhere							=	array('uid' => array('=', $row['uid']), 'status' => array('=', 1));
			$teachinfo							=	$pxM -> getTeaList($teaWhere, array('field' => '`id`, `name`'));
			$this -> yunset("row", $row);
			$where['uid']		=		$row['uid'];
			$trainfo			=		$pxM->getInfo($where,array('field'=>'`r_status`,`uid`'));
			$this -> yunset("trainfo", $trainfo);
		}
		$this -> yunset($this -> MODEL('cache') -> GetCache(array('city','subject','subjecttype')));
		$this -> yuntpl(array('admin/admin_subject_add'));
	}
	/**
	 * 会员- 培训 - 培训课程管理
	 * 保存课程数据
	 * 2019-06-05 hjy
	 */	
	public function save_action(){
		$trainM	=	$this -> MODEL('train');
		$_POST	=	$this->post_trim($_POST);
		if($_POST['r_status']==1){
			$status		=	1;
		}else{
			$status		=	0;
		}
		$post	=	array(
			'name'			=>	$_POST['name'],
			'nid'			=>	$_POST['nid'],
			'tnid'			=>	$_POST['tnid'],
			'provinceid'	=>	$_POST['provinceid'],
			'cityid'		=>	$_POST['cityid'],
			'threecityid'	=>	$_POST['threecityid'],
			'address'		=>	$_POST['address'],
			'hours'			=>	$_POST['hours'],
			'price'			=>	$_POST['price'],
			'isprice'		=>	$_POST['isprice'],
			'moblie'		=>	$_POST['moblie'],
			'crowd'			=>	$_POST['crowd'],
			'superiority'	=>	$_POST['superiority'],
			'content'		=>	$_POST['content'],
			'type'			=>	pylode(',',$_POST['type']),
			'teachid'		=>	pylode(',',$_POST['teachid']),
			'status'		=>	$status,
			'r_status'		=>	$_POST['r_status'],
			'file'			=>	$_FILES['file']
		);
		
		$data	=	array(
			'post'		=>	$post,
			'uid'		=>	(int)$_POST['uid'],
			'id'		=>	(int)$_POST['id']
		);
		$return			=	$trainM->addSubjectInfo($data);

		$this->ACT_layer_msg($return['msg'], $return['errcode'], 'index.php?m=admin_subject');
	}
	/**
	 * 会员- 培训 - 培训课程管理
	 * 删除课程数据
	 * 2019-06-05 hjy
	 */	
	public function del_action(){

		$del									=	$_GET['del'];
		$this -> check_token();
		if(is_array($del)){
			$layer_type							=	1;
			$del								=	pylode(',', $del);
		}else{
			$layer_type							=	0;
		}
		if(empty($del)){
			$this->layer_msg('请选择要删除的内容！', 8, 0, $_SERVER['HTTP_REFERER']);
		}

		$pxM									=	$this -> MODEL('train');
		$delRes									=	$pxM -> delSub(array('id' => $del));
		if($delRes['errcode'] == 9){
			$this->layer_msg($delRes['msg'], 9, $layer_type, $_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg($delRes['msg'], 8, $layer_type, $_SERVER['HTTP_REFERER']);
		}
	}

	/**
	 * 会员- 培训 - 培训课程管理
	 * 数据统计
	 * 2019-06-05 hjy
	 */
	public function subjectNum_action(){		
		$MsgNum									=	$this -> MODEL('msgNum');
		echo $MsgNum -> subjectNum();	
	}


}