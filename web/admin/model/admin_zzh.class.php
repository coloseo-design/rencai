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
class admin_zzh_controller extends adminCommon
{

	private function set_search()
	{

		include(CONFIG_PATH.'db.data.php');
		$source         =  $arr_data['source'];
		$search_list[]  =  array('param'=>'lotime','name'=>'最近登录','value'=>array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月'));
		$search_list[]  =  array('param'=>'adtime','name'=>'最近注册','value'=>array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月'));
		$search_list[]  =  array('param'=>'status','name'=>'锁定状态','value'=>array('1'=>'已审核','2'=>'已锁定'));
		$this->yunset('source',$source);
		$this->yunset('search_list',$search_list);
	}

	function index_action(){
		$this->set_search();

		$CompanyaccountM	=	$this->MODEL('companyaccount');
		$userinfoM 			=	$this->MODEL('userinfo');
		$companyM 			=	$this->MODEL('company');
		
		if($_GET['lotime']){
			if($_GET['lotime']=='1'){

				$where['login_date']	=	array('>',strtotime(date("Y-m-d 00:00:00")));
			}else{

				$where['login_date']	=	array('>',strtotime('-'.(int)$_GET['lotime'].'day'));

			}
			$urlarr['lotime']			=	$_GET['lotime'];
		}
		
		if($_GET['adtime']){
			if($_GET['adtime']=='1'){

				$where['reg_date']		=	array('>',strtotime(date("Y-m-d 00:00:00")));
			}else{

				$where['reg_date']		=	array('>',strtotime('-'.(int)$_GET['adtime'].'day'));
			}
			$urlarr['adtime']			=	$_GET['adtime'];
		}

		if($_GET['status']){
				
			$status						=	intval($_GET['status']);
			
			$uMem						=	$userinfoM -> getList(array('status' => $status, 'pid' => array('>', '0')), array('field' => '`uid`'));
			
			if (!empty($uMem)){
				foreach ($uMem as $uk => $uv) {
					$uids[]				=	$uv['uid'];
				}
				
				$where['uid']			=	array('in', pylode(',', $uids));
			}
				
			$urlarr['status']			=	$status;
		}

		 
		if(trim($_GET['keyword'])){
			if($_GET['type']==1){

				$where['name']			=	array('like',trim($_GET['keyword']));

			}elseif($_GET['type']==3){

				$where['uid']			=	array('=',trim($_GET['keyword']));

			}
			$urlarr['keyword']			=	$_GET['keyword'];
				
			$urlarr['type']				=	$_GET['type'];
		}
		if($_GET['order']){
			$where['orderby']			=	$_GET['t'].','.$_GET['order'];
				
			$urlarr['order']			=	$_GET['order'];
				
			$urlarr['t']				=	$_GET['t'];
		}else{
				
			$where['orderby']			=	array('uid,desc');
				
		}
		$urlarr        	=   $_GET;
		$urlarr['page']	=	'{{page}}';

		$pageurl		=	Url($_GET['m'],$urlarr,'admin');

		$pageM			=	$this  -> MODEL('page');

		$pages			=	$pageM -> pageList('company_account',$where,$pageurl,$_GET['page']);

		if($pages['total'] > 0){
				
			$where['limit']	=  	$pages['limit'];
				
			$List   =  $CompanyaccountM -> getList($where);

			foreach($List as $v){
				$rows[] = $v['uid'];
				$comid[] = $v['comid'];
			}
			$Lists	=	$userinfoM -> getList(array('uid' => array('in', pylode(',',$rows))));

			$List1 	= 	$companyM -> getList(array('uid' => array('in', pylode(',',$comid))),array('field'=>'`name`,`uid`'));

			$List2 	= 	$List1['list'];

			foreach($List as $k=> $v){
				foreach ($List2 as $ke => $val) {
					if($List2[$ke]['uid'] == $List[$k]['comid']){
						$List[$k]['comname']=$List2[$ke]['name'];
						$List[$k]['uids']=$List2[$ke]['uid'];
						$List3=	$userinfoM -> getList(array('uid' => array('in', pylode(',',$List[$k]['uids']))));

						foreach ($List3 as $keys => $vals) {
							$List[$k]['username']=$List3[$keys]['username'];

						}
					}
				}
				foreach ($Lists as $key => $value) {
					if($Lists[$key]['uid'] == $List[$k]['uid']){
						$List[$k]['source']		=	$Lists[$key]['source'];
						$List[$k]['moblie']		=	$Lists[$key]['moblie'];
						$List[$k]['email']		=	$Lists[$key]['email'];
						$List[$k]['did']		=	$Lists[$key]['did'];
						$List[$k]['statuss']	=	$Lists[$key]['status'];
						$List[$k]['childname']	=	$Lists[$key]['username'];
						$List[$k]['login_date']	=	$Lists[$key]['login_date'];
						$List[$k]['reg_date']	=	$Lists[$key]['reg_date'];
					}
				}

			}

			$this->yunset("rows",$List);
		}
		$cacheM	=	$this -> MODEL('cache');

		$domain	=	$cacheM	-> GetCache('domain');

		$this -> yunset("Dname",$domain['Dname']);

		$this->yuntpl(array('admin/admin_zzh'));
	}

	function edit_action(){
		$memberM	=	$this->MODEL('userinfo');

		$cacheM		=	$this -> MODEL('cache');

		$member		=	$memberM->getInfo(array('uid'=>$_GET['uid']),array('sf'=>'1'));

		$domain		=	$cacheM	-> GetCache('domain');

		$this -> yunset('Dname', $domain['Dname']);
		$this -> yunset('lasturl', 'index.php?m=admin_member');
		$this -> yunset('member', $member);
		$this -> yuntpl(array('admin/admin_member_edit'));
	}


	function lockinfo_action(){
	  
		$userinfoM  =  $this -> MODEL('userinfo');
	  
		$member     =  $userinfoM -> getInfo(array('uid'=> $_GET['uid']),array('field'=>'lock_info'));
	  
		echo trim($member['lock_info']);die;
	}

	/**
	 * 会员用户列表:会员锁定
	 */
	function lock_action(){
	  
		$userinfoM  =  $this -> MODEL('userinfo');
	  
		$post       =  array(
	        'status'     =>  intval($_POST['status']),
	        'lock_info'  =>  trim($_POST['lock_info'])
		);
	  
		$return     =  $userinfoM -> lock(array('uid'=>intval($_POST['uid'])),array('post'=>$post));
	  
		$this->ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);
	}

	function reset_pw_action(){

		$this -> check_token();

		$userinfoM  =  $this->MODEL('userinfo');

		$userinfoM -> upInfo(array('uid'=>intval($_GET['uid'])),array('password'=>'123456'));

		$this -> MODEL('log') -> addAdminLog('会员(ID:'.$_GET['uid'].')重置密码成功');

		echo '1';
	}


	/**
	 * 子账户列表（页面统计数量）
	 */
	function memNum_action(){

		$MsgNum	=	$this->MODEL('msgNum');

		echo $MsgNum->memNum();
	}

	function del_action(){

		$userinfoM	=	$this->MODEL('userinfo');

		if($_GET['del']){
			$del	=	$_GET['del'];
		}else{
			$del	=	$_POST['del'];
		}
		$return	=	$userinfoM->delMember($del);
			
		$this->layer_msg( $return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
	}
	/**
	 * 会员列表（分配分站）
	 */
	function checksitedid_action(){
		$siteM	=	$this -> MODEL('site');

		$return	=	$siteM -> memberSiteDid($_POST);

		$this->ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);
	}
}
?>