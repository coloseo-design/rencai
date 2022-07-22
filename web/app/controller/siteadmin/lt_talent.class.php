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
class lt_talent_controller extends siteadmin_controller{

	/**
	 * 会员-猎头-简历库
	 * 简历列表
	 * 2019-06-04 hjy
	 */
	public function index_action(){

		$memberWhereData	= 	$ltTalWhereData	= array();
		$keywordStr								=	trim($_GET['keyword']);
		$nameStr 								=	intval($_GET['searchrname']);
		
		//如果有用户相关的搜索条件,则先获取用户的id
		if(!empty($keywordStr) && $nameStr == 1){
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
			$ltTalWhereData['uid']				=	array('in', pylode(',', $memberUid));
		}

		//姓名条件
		if(!empty($keywordStr) && $nameStr == 2){
			$ltTalWhereData['name']				=	array('like', $keywordStr);
		}
		//意向职位条件
		if(!empty($keywordStr) && $nameStr == 3){
			$ltTalWhereData['jobname']			=	array('like', $keywordStr);
		}

		$urlarr['page']							=	"{{page}}";
		$pageurl								=	Url($_GET['m'], $urlarr, 'admin');
		//提取分页
		$pageM									=	$this  -> MODEL('page');
		$pages									=	$pageM -> pageList('lt_talent', $ltTalWhereData, $pageurl, $_GET['page']);
		//分页数大于0的情况下 执行列表查询
		$List									=	array();
		$talentM								=	$this -> MODEL('talent');
		if($pages['total'] > 0){
			//limit order 只有在列表查询时才需要
			if(!empty($_GET['order']) && !empty($_GET['t'])){
				if($_GET['t'] == 'time'){
					$ltTalWhereData['orderby']	=	'status_time,'.$_GET['order'];
				}else{
					$ltTalWhereData['orderby']	=	$_GET['t'].','.$_GET['order'];
				}				
			}else{
				$ltTalWhereData['orderby']		=	'id,desc';
			}
			$ltTalWhereData['limit']			=	$pages['limit'];		
			$List								=	$talentM -> getList($ltTalWhereData,array('field'=>'`id`,`uid`,`name`,`edu`,`exp`,`jobname`,`maxsalary`,`minsalary`,`provinceid`,`cityid`,`three_cityid`,`jobstatus`,`status`,`linktel`,`telstatus`'));
		}
		$this -> yunset('get_type', $_GET);
		$this -> yunset('rows', $List);
    $this -> siteadmin_tpl(array('admin_lt_talent'));

	}
	/**
	 * 会员-猎头-简历库
	 * 简历预览
	 * 2019-06-04 hjy
	 */
	public function show_action(){
		$idStr									=	intval($_GET['id']);
		$uidStr									=	intval($_GET['uid']);
		if(!empty($idStr)){
			$talentM							=	$this -> MODEL('talent');
			$Info								=	$talentM -> getInfo(array('id' => $idStr));
			
			$this -> yunset('Info', $Info);
      $this -> siteadmin_tpl(array('admin_lt_talent_show'));

		}
	}

	/**
	 * 会员-猎头-简历库
	 * 简历删除
	 * 2019-06-04 hjy
	 */
	public function del_action(){
		$this->check_token();
		//批量删除
		$del									=	trim($_GET['del']);
		if(empty($del)){
			$this -> layer_msg('请选择您要删除的猎头简历库简历！',8,1,$_SERVER['HTTP_REFERER']);
		}

		if(is_array($del)){
			$del								=	pylode(',', $del);
			$layer_type							=	1;
		}else{
			$layer_type 						= 	0;
		}

		$lttalM									=	$this -> MODEL('talent');
		$Info									=	$lttalM -> delTalent(array('id' => array('in', $del)));
		$this->layer_msg('猎头简历库简历(ID:'.$del.')删除成功！', 9, $layer_type, $_SERVER['HTTP_REFERER']);
	}
}
?>