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
class trainmessage_controller extends siteadmin_controller{
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
			'param'		=>	'end',
			'name'		=>	'咨询时间',
			'value'		=>	$this -> timeSection
		);
		$this -> yunset('search_list', $search_list);
	}
	/**
	 * 会员 - 培训 - 咨询留言
	 * 2019-06-06 hjy
	 */
	public function index_action(){

		$this->set_search();		

		$pxWhereData						=	array();

		$endStr								=	intval($_GET['end']);
		//咨询时间条件
		if(!empty($endStr)){
			if($endStr == 1){
				$pxWhereData['ctime']		=	array('>=', strtotime(date("Y-m-d")));
			}else{
				$pxWhereData['ctime']		=	array('>=', strtotime('-'.$endStr.'day'));
			}
		}
		$rtStr								=	intval($_GET['r_time']);
		//回复时间条件
		if(!empty($rtStr)){
			if($rtStr == 1){
				$pxWhereData['reply_time']	=	array('>=', strtotime(date("Y-m-d")));
			}else{
				$pxWhereData['reply_time']	=	array('>=', strtotime('-'.$rtStr.'day'));
			}
		}

		$keywordStr							=	trim($_GET['keyword']);
		$typeStr							=	trim($_GET['type']);

		//咨询内容条件
		if(!empty($keywordStr) && $typeStr == 3){
			$pxWhereData['content']			=	array('like', $keywordStr);
		}
		
		//回复内容条件
		if(!empty($keywordStr) && $typeStr == 4){
			$pxWhereData['reply']			=	array('like', $keywordStr);
		}

		//咨询人条件
		$resumeM							=	$this -> MODEL('resume');
		$userId								=	array();
		if(!empty($keywordStr) && $typeStr == 1){
			$reWhere						=	array('name' => array('like', $keywordStr));
			$member							=	$resumeM -> getResumeList($reWhere, array('field' => '`uid`,`name`'));
			if(!empty($member)){
				foreach($member as $v){
					$userId[]				=	$v['uid'];
				}
			}else{
				$userId						=	array(0);
			}
		}
		if(!empty($userId)){
			$pxWhereData['uid']				=	array('in', pylode(',', $userId));
		}

		$urlarr['page']						=	"{{page}}";
		$pageurl							=	Url($_GET['m'], $urlarr, 'admin');
		//提取分页
		$pageM								=	$this  -> MODEL('page');
		$pxM								=	$this  -> MODEL('train');
		$pages								=	$pageM -> pageList('px_zixun', $pxWhereData, $pageurl, $_GET['page']);
		//分页数大于0的情况下 执行列表查询
		$List								=	array();
		if($pages['total'] > 0){
			//limit order 只有在列表查询时才需要
			if(!empty($_GET['order']) && !empty($_GET['t'])){
				$pxWhereData['orderby']		=	$_GET['t'].','.$_GET['order'];
			}else{
				$pxWhereData['orderby']		=	'id';
			}

			$pxWhereData['limit']			=	$pages['limit'];		
			$List							=	$pxM -> getPxzxList($pxWhereData);
		}

		if(!empty($List)){
			$pxuid	=	$comuid				=	array();
			foreach($List as $lv){
				$pxuid[] 					=	$lv['s_uid'];
				$comuid[]					=	$lv['uid'];
			}			
			//补充培训用户相关的信息
			$bcWhereData					=	array('uid' => array('in', pylode(',', $pxuid)));
			$pxField						=	'`uid`, `name`';
			$pxList							=	$pxM -> getList($bcWhereData, array('field' => $pxField));
			$pxListIndex					=	array();
			if(!empty($pxList)){
				foreach ($pxList as $pxV) {
					$pxListIndex[$pxV['uid']]	=	$pxV;
				}
			}
			//补充个人用户相关的信息
			$reWhereData					=	array('uid' => array('in', pylode(',', $comuid)));
			$reList							=	$resumeM -> getResumeList($reWhereData, array('field' => '`uid`, `name`'));
			$reListIndex					=	array();
			if(!empty($reList)){
				foreach ($reList as $reV) {
					$reListIndex[$reV['uid']]	=	$reV;
				}
			}
			//补充企业用户相关的信息
			$comM								=	$this -> MODEL('company');
			$comList							=	$comM -> getList($reWhereData, array('field' => '`uid`, `name`'));
			$comListIndex						=	array();
			if(!empty($comList)){
				foreach ($comList['list'] as $comV) {
					$comListIndex[$comV['uid']]	=	$comV;
				}
			}
			//补充猎头用户相关的信息
			$ltM								=	$this -> MODEL('lietou');
			$ltList								=	$ltM -> getList($reWhereData, array('field' => '`uid`, `realname`'));
			$ltListIndex						=	array();
			if(!empty($ltList)){
				foreach ($ltList as $ltV) {
					$ltListIndex[$ltV['uid']]	=	$ltV;
				}
			}
			//补充进相关信息
			foreach($List as $Lk => $Lv){
				$List[$Lk]['content'] 		=	str_replace('"', "", $Lv['content']);
				$List[$Lk]['reply'] 		=	str_replace('"', "", $Lv['reply']);
				if(isset($pxListIndex[$Lv['s_uid']])){
					$List[$Lk]['pxname']	=	$pxListIndex[$Lv['s_uid']]['name'];
				}
				if(isset($reListIndex[$Lv['uid']])){
					$List[$Lk]['zname']		=	$reListIndex[$Lv['uid']]['name'];
				}
				if(isset($comListIndex[$Lv['uid']])){
					$List[$Lk]['zname']		=	$comListIndex[$Lv['uid']]['name'];
				}
				if(isset($ltListIndex[$Lv['uid']])){
					$List[$Lk]['zname']		=	$ltListIndex[$Lv['uid']]['realname'];
				}
			}
		}
		$this -> yunset('get_type', $_GET);
		$this -> yunset('mes_list', $List);
		$this -> siteadmin_tpl(array('admin_trainmessage'));
	}
	/**
	 * 会员 - 培训 - 咨询留言
	 * 删除咨询留言
	 * 2019-06-06 hjy
	 */
	function del_action(){
		$this -> check_token();	
		$del			=	$_POST['del'];
		if(!empty($del) && is_array($del)){
			
			$linkid		=	$del;
		}else{
			
			$linkid		=	$_GET['id'];
		}
		$pxM			=	$this  -> MODEL('train');
		$return			=	$pxM -> delPxzx($linkid);
		$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
	}
}
?>