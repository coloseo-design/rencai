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
class trainnews_controller extends siteadmin_controller{
	/**
	 * 设置高级搜索功能
	 * 高级搜索参数
	 */
	public function set_search(){
		$search_list[]	=	array(
			'param'		=>	'status',
			'name'		=>	'审核状态',
			'value'		=>	array(
				'1'		=>	'已审核',
				'3'		=>	'未审核',
				'2'		=>	'未通过',
        '4'		=>	'已锁定'
			)
		);
		$this -> yunset('search_list', $search_list);
	}
	/**
	 * 会员 - 培训 - 培训新闻
	 * 2019-06-06 hjy
	 */
	public function index_action(){

		$this->set_search();
		$pxWhereData	=	array();

		$keywordStr		=	trim($_GET['keyword']);
		$typeStr		=	trim($_GET['type']);
		$pxM			=	$this  -> MODEL('train');

		//新闻标题条件
		if(!empty($keywordStr) && $typeStr == 2){
			$pxWhereData['title']	=	array('like', $keywordStr);
		}
		$uidArr			=	array();
		if(!empty($keywordStr) && $typeStr == 1){
			$trows		=	$pxM -> getList(array('name' => array('like', $keywordStr)), array('field' => '`uid`'));
			if(!empty($trows)){
				foreach($trows as $val){
					$uidArr[]		=	$val['uid'];
				}
			}else{
				$uidArr				=	array(0);
			}			
		}
		if(!empty($uidArr)){
			$pxWhereData['uid']		=	array('in', pylode(',', $uidArr));
		}

		if(!empty($_GET['status'])){
			if ($_GET['status'] == 3){
				$pxWhereData['status']		    =	  array('=', 0);
        $pxWhereData['r_status']			=	  array('=', 1);
			}else if($_GET['status']==4){
        $pxWhereData['r_status']			=	  array('>', 1);
      }else{
				$pxWhereData['status']		    =	  array('=', $_GET['status']);
        $pxWhereData['r_status']			=	  array('=', 1);
			}
		}

		$urlarr['page']		=	"{{page}}";
		$pageurl			=	Url($_GET['m'], $urlarr, 'admin');
		//提取分页
		$pageM				=	$this  -> MODEL('page');
		$pages				=	$pageM -> pageList('px_train_news', $pxWhereData, $pageurl, $_GET['page']);

		//分页数大于0的情况下 执行列表查询
		$List								=	array();
		if($pages['total'] > 0){
			//limit order 只有在列表查询时才需要
			if(!empty($_GET['order']) && !empty($_GET['t'])){
				$pxWhereData['orderby']		=	$_GET['t'].','.$_GET['order'];
			}else{
				$pxWhereData['orderby']		=	array('r_status,asc','status,asc', 'uid,desc');
			}

			$pxWhereData['limit']			=	$pages['limit'];		
			$List							=	$pxM -> getPxnewsList($pxWhereData);
		}
		$this -> yunset('rows', $List);
		$this -> yunset('get_type', $_GET);
		$this -> siteadmin_tpl(array('admin_trainnews'));
	}
	/**
	 * 会员 - 培训 - 培训新闻
	 * 审核信息
	 * 2019-06-06 hjy
	 */
	public function lockinfo_action(){
		$pxM	=	$this  -> MODEL('train');
		$row	=	$pxM -> getPxnewsInfo(array('id' => array('=', $_POST['id'])), array('field' => '`statusbody`'));
		echo $row['statusbody'];die;
	}
	/**
	 * 会员 - 培训 - 培训新闻
	 * 保存审核信息
	 * 2019-06-06 hjy
	 */
	public function status_action(){
		$_POST		=	$this -> post_trim($_POST);
		$pid		=	trim($_POST['pid'], ',');
		if(empty($pid)){
			$this -> ACT_layer_msg('非法操作！', 8, $_SERVER['HTTP_REFERER']);
		}
		$pxM		=	$this  -> MODEL('train');
		$list		=	$pxM -> getPxnewsList(array('id' => array('in', $pid)), array('field' => '`uid`, `title`'));
		if(empty($list)){
			$this -> ACT_layer_msg('数据错误！', 8, $_SERVER['HTTP_REFERER']);
		}
		$upData		=	array();
		$upData['status']		=	$_POST['status'];
		$upData['statusbody']	=	$_POST['statusbody'];
		$id			=	$pxM -> upPxnewsInfo(array('id' => array('in', $pid)), $upData);
		if(!empty($id)){
			$sysmsgM	=	$this -> MODEL('sysmsg');
			/* 消息前缀 */		
			$tagName  	=	'新闻';
			//发送会员通知
			foreach($list as $v){
				
				$uids[] =   $v['uid'];
				
				/* 处理审核信息 */
				if ($upData['status'] == 2){
					
					$statusInfo  =  $tagName.':'.$v['title'].'审核未通过 ';
					
					if($upData['statusbody']){
						
						$statusInfo  .=  ', 原因：'.$upData['statusbody'];
						
					}
					
					$msg[$v['uid']][]  =  $statusInfo;
					
				}elseif($upData['status'] == 1){
					
					$msg[$v['uid']][]  =  $tagName.':'.$v['title'].'已审核通过';
					
				}
			}
			
			$sysmsgM -> addInfo(array('uid'=>$uids,'usertype'=>4, 'content'=>$msg));
			
			$this -> ACT_layer_msg('培训新闻审核(ID:'.$pid.')设置成功！', 9, $_SERVER['HTTP_REFERER'], 2, 1);
		}else{
			$this -> ACT_layer_msg('设置失败！', 8, $_SERVER['HTTP_REFERER']);
		}
	}
	/**
	 * 会员 - 培训 - 培训新闻
	 * 删除新闻
	 * 2019-06-06 hjy
	 */
	public function del_action(){
		$this -> check_token();

		$del			=	$_GET['del'];
		$layer_type		=	0;
		if(!empty($del) && is_array($del)){
			$linkid		=	pylode(',', $del);
			$layer_type	=	1;
		}else{			
			$linkid		=	$_GET['del'];
		}
		if(empty($linkid)){
			$this -> layer_msg('请选择您要删除的新闻！', 8, $layer_type, $_SERVER['HTTP_REFERER']);
		}

		$pxM		=	$this  -> MODEL('train');
		$list		=	$pxM -> getPxnewsList(array('id' => array('in', $linkid)), array('field' => '`uid`, `title`'));
		if(empty($list)){
			$this -> ACT_layer_msg('数据错误！', 8, $_SERVER['HTTP_REFERER']);
		}
		$sysmsgM	=	$this -> MODEL('sysmsg');
		foreach($list as $v){
			$sysmsgM -> addInfo(array('content' => '管理员删除新闻《'.$v['title'].'》','usertype'=>4,  'uid' => $v['uid']));
		}
		$did		=	$pxM -> delPxnews(array('id' => array('in', $linkid)));
		if(!empty($did)){
			$this -> layer_msg('培训新闻(ID:'.$linkid.')删除成功！', 9, $layer_type, $_SERVER['HTTP_REFERER']);
		}else{
			$this -> layer_msg('删除失败！', 8, $layer_type, $_SERVER['HTTP_REFERER']);
		}
	}
}
?>