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
class teacher_controller extends siteadmin_controller{
	/**
	 * 设置高级搜索功能
	 * 高级搜索参数
	 */
	public function set_search(){
		$search_list[]	=	array('param'	=>'status','name'=>'审核状态','value'	=>array('1'	=>'已审核','3'=>'未审核','2'=>'未通过','4'=>'已锁定')
		);
		$this -> yunset('search_list', $search_list);
	}
	/**
	 * 会员- 培训 - 培训师
	 * 2019-06-04 hjy
	 */
	public function index_action(){

		$this->set_search();

		$teWhereData				=	array();
		$keywordStr					=	trim($_GET['keyword']);

		if(!empty($keywordStr)){

			$teWhereData['name']	=	array('like', $keywordStr);
		}
		//审核状态条件
		if(!empty($_GET['status'])){

			if ($_GET['status'] == 3){
				
				$teWhereData['status']		=	0;
				$teWhereData['r_status']	=	1;

			}else if($_GET['status']==4){

				$teWhereData['r_status']	=	array('>', 1);
			}else{

				$teWhereData['status']		=	$_GET['status'];
				$teWhereData['r_status']	=	1;
			}
		}

		
		$urlarr['page']						=	"{{page}}";
		$pageurl							=	Url($_GET['m'], $urlarr, 'admin');
		//提取分页
		$pageM								=	$this  -> MODEL('page');
		$pages								=	$pageM -> pageList('px_teacher', $teWhereData, $pageurl, $_GET['page']);

		//分页数大于0的情况下 执行列表查询
		$List								=	array();
		$pxM								=	$this -> MODEL('train');

		if($pages['total'] > 0){
			//limit order 只有在列表查询时才需要
			if(!empty($_GET['order']) && !empty($_GET['t'])){
				$teWhereData['orderby']		=	$_GET['t'].','.$_GET['order'];
			}else{
				$teWhereData['orderby']		=	array('r_status,asc','status,asc', 'id,desc');
			}

			$teWhereData['limit']			=	$pages['limit'];		
			$List							=	$pxM -> getTeaList($teWhereData);
		}
		if(!empty($List)){
			$pxuid							=	array();
			foreach($List as $lv){
				$pxuid[] 					=	$lv['uid'];
			}
			$bcWhereData					=	array('uid' => array('in', pylode(',',$pxuid)));
			//补充用户相关的信息
			$pxField						=	'`uid`, `name` AS train_name';
			$pxList							=	$pxM -> getList($bcWhereData, array('field' => $pxField));
			$pxListIndex					=	array();
			if(!empty($pxList)){
				foreach ($pxList as $pxV) {
					$pxListIndex[$pxV['uid']]	=	$pxV;
				}
			}
			//补充进相关信息
			foreach($List as $Lk => $Lv){
				if(isset($pxListIndex[$Lv['uid']])){
					$List[$Lk]					=	array_merge($List[$Lk], $pxListIndex[$Lv['uid']]);
				}
			}
		}
		$this -> yunset('rows', $List);
		$this -> yunset($this -> MODEL('cache') -> GetCache(array('city', 'hy', 'subject')));
		$this -> yunset('get_type', $_GET);
		$this -> siteadmin_tpl(array('admin_teacher'));
	}
	/**
	 * 会员- 培训 - 培训师
	 * 审核信息
	 * 2019-06-05 hjy
	 */
	public function lockinfo_action(){
		$pxM									=	$this -> MODEL('train');
		$rows									=	$pxM -> getTeaInfo(array('id' => array('=', $_POST['id'])), array('field' => '`statusbody`'));
		echo $rows['statusbody'];die;
	}
	/**
	 * 会员- 培训 - 培训师
	 * 审核培训师
	 * 2019-06-05 hjy
	 */
	public function status_action(){
		$postData								=	$this -> post_trim($_POST);
		$postData['id']							=	trim($postData['id'], ',');
		if(empty($postData['id'])){
			$this -> ACT_layer_msg('非法操作！', 9, $_SERVER['HTTP_REFERER']);
		}

		$pxM									=	$this -> MODEL('train');
		$upData									=	array();
		$upData['status']						=	$postData['status'];
		$upData['statusbody']					=	$postData['statusbody'];
		$upid									=	$pxM -> upTeaInfo(array('id' => array('in', $postData['id'])), $upData);
		if(empty($upid)){
			$this->ACT_layer_msg('设置失败！', 8, $_SERVER['HTTP_REFERER']);
		}
		$px_subj								= 	$pxM -> getSubList(array('teachid' => array('in', $postData['id'])), array('field' => '`uid`, `name`'));
		
		$TeaList								= 	$pxM -> getTeaList(array('id' => array('in', $postData['id'])), array('field' => '`uid`, `name`,`id`'));
		
		if(!empty($px_subj)){
			if($postData['status'] != 1){
				$pxM -> upSubInfo(array('teachid' => array('in', $postData['id']), array('status' => $postData['status'])));
			}
			
		}
		
		if(!empty($TeaList)){
			
			/* 消息前缀 */		
			$tagName  				=	'培训师';
			
			$sysmsgM	=	$this->MODEL('sysmsg');
			
			foreach($TeaList as $v){
				
				 $uids[]  =  $v['uid'];
				 
				/* 处理审核信息 */				
				if ($upData['status'] == 2){
				
					$statusInfo  =  $tagName.':'.$v['name'].'审核未通过';
					
					if($upData['statusbody']){
						
						$statusInfo  .=  ' , 原因：'.$upData['statusbody'];
						
					}
					
					$msg[$v['uid']][]  =  $statusInfo;
					
				}elseif($upData['status'] == 1){
					
					$msg[$v['uid']][]  =  $tagName.':'.$v['name'].'已审核通过';
					
				}
			}
			
			$sysmsgM -> addInfo(array('uid'=> $uids,'usertype'=>4, 'content'=>$msg));
				
		}
		$this -> ACT_layer_msg('培训师审核(ID:'.$postData['id'].')设置成功！', 9, $_SERVER['HTTP_REFERER'], 2, 1); 
	}
	/**
	 * 会员- 培训 - 培训师
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
		$info									=	$pxM -> getTeaInfo($whereData, array('field' => '`uid`, `name`'));
		if(empty($info)){
			$this -> layer_msg('设置失败！', 8, 0, $_SERVER['HTTP_REFERER']);
		}
		$nid 									=	$pxM -> upTeaInfo($whereData, $upData);
		$sysmsgM								=	$this -> MODEL('sysmsg');
		if($nid && $pxRec == 1){
			$sysmsgM -> addInfo(array('content' => '管理员设置：推荐培训师'.$info['name'],'usertype'=>4,  'uid' => $info['uid']));
		}elseif($nid && $pxRec == 0){
			$sysmsgM -> addInfo(array('content' => '管理员操作：取消培训师推荐'.$info['name'],'usertype'=>4,  'uid' => $info['uid']));
		}
		$this -> MODEL('log') -> addAdminLog("培训师(ID:".$pxId.")推荐设置成功！");
		echo $nid?1:0;die;
	}

	/**
	 * 会员- 培训 - 培训师
	 * 修改培训师
	 * 2019-06-05 hjy
	 */
	public function add_action(){
		$pxId 									= 	intval($_GET['id']);
		$pxM									=	$this -> MODEL('train');
		if(!empty($pxId)){
			$row								=	$pxM -> getTeaInfo(array('id' => array('=', $pxId)));
			$this -> yunset("row", $row);
			$this -> yunset($this -> MODEL('cache') -> GetCache(array('city', 'hy', 'subject')));
			$this -> siteadmin_tpl(array('admin_teacher_add'));
		}
		if(!empty($_POST['update'])){
			$postData							=	$this -> post_trim($_POST);
			$id									=	intval($postData['id']);
			$teacher							=	$pxM -> getTeaInfo(array('id' => array('=', $id)), array('field' => '`pic`'));
			if(empty($teacher)){
				$this->ACT_layer_msg('数据错误！', 8, 'index.php?m=teacher');
			}
			unset($postData['id']);
			unset($postData['update']);

			
			$postData['file']					=	$_FILES['file'];
			$postData['status']					=	1;

			$nid								=	$pxM -> upTeaInfo(array('id' => array('=', $id)), $postData);
			if($nid){				
				$this->ACT_layer_msg('更新成功！', 9, 'index.php?m=teacher');
			}else{
				$this->ACT_layer_msg('更新失败！', 8, 'index.php?m=teacher');
			}
		}
	}
	/**
	 * 会员- 培训 - 培训师
	 * 删除培训师
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
		$list									=	$pxM -> getTeaList(array('id' => array('in', $del)), array('field' => '`uid`, `name`, `pic`'));
		if(!empty($list)){
			$sysmsgM							=	$this -> MODEL('sysmsg');
			$pxM -> delTea(array('id' => array('in', $del)));
			foreach($list as $v){
				$sysmsgM -> addInfo(array('content' => '管理员操作：删除培训讲师《'.$v['name'].'》','usertype'=>4,  'uid' => $v['uid']));
			}
		}
		$this->layer_msg('培训师(ID:'.$del.')删除成功！', 9, $layer_type, $_SERVER['HTTP_REFERER']);
	}
	/**
	 * 会员- 培训 - 培训师
	 * 数据统计
	 * 2019-06-05 hjy
	 */
	public function teacherNum_action(){	
		$MsgNum 								=	$this->MODEL('msgNum');
		echo $MsgNum -> teacherNum();
	}


}