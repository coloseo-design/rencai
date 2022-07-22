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
class train_member_controller extends siteadmin_controller{

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
			'param'	=>	'rec',
			'name'	=>	'推荐状态',
			'value'	=>	array(
				1	=>	'已推荐',
				2	=>	'未推荐'
			)
		);
		$search_list[]	=	array(
			'param'	=>	'status',
			'name'	=>	'审核状态',
			'value'	=>	array(
				1	=>	'已审核',
				4	=>	'未审核',
				3	=>	'未通过',
				2	=>	'已锁定'
			)
		);
		$search_list[]	=	array(
			'param'	=>	'r_time',
			'name'	=>	'注册时间',
			'value'	=>	$this -> timeSection
		);
		$search_list[]	=	array(
			'param'	=>	'l_time',
			'name'	=>	'登录时间',
			'value'	=>	$this -> timeSection
		);
		$this -> yunset('search_list', $search_list);
	}

	/**
	 * 日志搜索功能
	 * 搜索参数
	 */
	public function log_search(){
		$opera			=	array(
			7 => '基本信息', 8 => '修改密码', 11 => '修改账号', 13 => '认证绑定', 
			12 => '账号解绑', 20 =>'培训师', 21 => '课程', 6 => '预约报名', 22 => '新闻',
			 16 => '图片', 17 => '积分兑换', 18 => '消息', 19 => '问答'
		);
		$search_list[]	=	array('param' => 'operas', 'name' => '操作类型', "value" => $opera);
	    $search_list[]	=	array('param' => 'end', 'name' => '操作时间', "value" => $this -> timeSection);
		$this -> yunset('search_list', $search_list);
	}

	/**
	 * 会员- 培训 - 培训用户列表
	 * 全部培训
	 * 从px_train中读取
	 * 2019-07-17 hjy
	 */
	public function index_action(){

		$this -> set_search();

		$pxWhereData=	$memberWhereData 	= 	array();

		$keywordStr							=	trim($_GET['keyword']);
		$typeStr 							=	intval($_GET['type']);
		$loginStr							=	intval($_GET['l_time']);
		$regStr								=	intval($_GET['r_time']);
		//用户名条件
		if(!empty($keywordStr) && $typeStr == 1){
			$memberWhereData['username']		=	array('like', $keywordStr);
			$urlarr['keyword']					=	trim($_GET['keyword']);
			$urlarr['type']						=	intval($_GET['type']);
		}
		if(!empty($loginStr)){
			if($loginStr == 1){
				$memberWhereData['login_date']	=	array('>=', strtotime(date('Y-m-d')));
			}else{
				$memberWhereData['login_date']	=	array('>=', strtotime('-'.$loginStr.'day'));
			}
			$urlarr['l_time']					=	intval($_GET['l_time']);
		}
		if(!empty($regStr)){
			if($regStr == 1){
				$memberWhereData['reg_date']	=	array('>=', strtotime(date('Y-m-d')));
			}else{
				$memberWhereData['reg_date']	=	array('>=', strtotime('-'.$regStr.'day'));
			}
			$urlarr['r_time']					=	intval($_GET['r_time']);
		}
		if(!empty($_GET['status'])){
			if ($_GET['status']=='4'){
				$memberWhereData['status']		=	array('=', 0);
			}else{
				$memberWhereData['status']		=	array('=', $_GET['status']);
			}
			$urlarr['status']					=	$_GET['status'];
		}
		$memberUid								=	array();

		$memberM								=	$this -> MODEL('userinfo');

		if(!empty($memberWhereData)){
			$resWhere							=	array_merge(array('usertype' => array('=', 4)), $memberWhereData);
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
			$pxWhereData['uid']					=	array('in', pylode(',', $memberUid));
		}

		//email条件
		if(!empty($keywordStr) && $typeStr == 3){
			$pxWhereData['limkmail']		=	array('like', $keywordStr);
			$urlarr['keyword']				=	trim($_GET['keyword']);
			$urlarr['type']					=	intval($_GET['type']);
		}
		//mobile条件
		if(!empty($keywordStr) && $typeStr == 4){
			$pxWhereData['linktel']			=	array('like', $keywordStr);
			$urlarr['keyword']				=	trim($_GET['keyword']);
			$urlarr['type']					=	intval($_GET['type']);
		}
		//机构名称条件
		$pxM								=	$this -> MODEL('train');

		if(!empty($keywordStr) && $typeStr == 2){
			$pxWhereData['name']			=	array('like', $keywordStr);
			$urlarr['keyword']				=	trim($_GET['keyword']);
			$urlarr['type']					=	intval($_GET['type']);
		}
		$recStr								=	intval($_GET['rec']);
		if(!empty($recStr)){
			if($recStr == 2){
				$re							=	0;
			}else{
				$re							=	$recStr;
			}
			$pxWhereData['rec']				=	array('=', $re);
			$urlarr['rec']					=	intval($_GET['rec']);
		}

		$urlarr['page']						=	"{{page}}";
		$pageurl							=	Url($_GET['m'], $urlarr, 'admin');
		//提取分页
		$pageM								=	$this  -> MODEL('page');
		$pages								=	$pageM -> pageList('px_train', $pxWhereData, $pageurl, $_GET['page']);

		//分页数大于0的情况下 执行列表查询
		$List								=	array();

		$CompanyM							=	$this -> MODEL('company');
		if($pages['total'] > 0){
			//limit order 只有在列表查询时才需要
			if(!empty($_GET['order']) && !empty($_GET['t'])){
				$pxWhereData['orderby']		=	$_GET['t'].','.$_GET['order'];
			}else{
				$pxWhereData['orderby']		=	'uid';
			}
			$pxWhereData['limit']			=	$pages['limit'];		
			$List							=	$pxM -> getList($pxWhereData);
		}

		if(!empty($List)){
			$pxuid							=	array();
			foreach($List as $lv){
				$pxuid[] 					=	$lv['uid'];
			}
			$bcWhereData					=	array('uid' => array('in', pylode(',', $pxuid)));
			//补充用户相关的信息
			$memberField					=	'`uid`, `login_date`, `reg_date`, `username`, `status`, `login_ip`, `usertype`';
			$memberField					.=	', `email`, `moblie`';
			$memberList						=	$memberM -> getList($bcWhereData, array('field' => $memberField));
			$memberListIndex				=	array();
			if(!empty($memberList)){
				foreach ($memberList as $memberV) {
					$memberListIndex[$memberV['uid']]	=	$memberV;
				}
			}

			$bcWhereData['type']			=	5;

			$certField						=	'`uid`,`check`,`status`';
			
			$certdata						=	array('field'=>$certField);

			$certList						=	$CompanyM->getCertList($bcWhereData,$certdata);
			
			//补充进相关信息
			foreach($List as $Lk => $Lv){
				$List[$Lk]['train_name']	=	$Lv['name'];

				if(isset($memberListIndex[$Lv['uid']])){
					$List[$Lk]				=	array_merge($List[$Lk], $memberListIndex[$Lv['uid']]);
				}else{
					unset($List[$Lk]);
					continue;
				}

				foreach($certList  as $val){
					if($Lv['uid']	==	$val['uid']){						
						$List[$Lk]['check']		=	$val['check'];
						$List[$Lk]['status_n']	=	$val['status'];
					}
				}

				if($Lv['did'] < 1){
					$List[$Lk]['did'] 			=	0;
				}
			}
		}
		$this -> yunset("userrows", $List);
		$this -> yunset("lotime", $this -> timeSection);
		$this -> yunset("get_type", $_GET);
		$this -> siteadmin_tpl(array('admin_member_trainlist'));
	}

	/**
	 * 会员- 培训 - 培训用户列表
	 * 查看日志记录
	 * 2019-06-04 hjy
	 */
	public function member_log_action(){

		$this->log_search();

		$mlWhereData 							=	array();
		$mlWhereData['usertype']				=	array('=', 4);
		
		$uidStr									=	intval($_GET['uid']);
		$keywordStr								=	trim($_GET['keyword']);
		$typeStr 								=	intval($_GET['type']);
		$operasStr								=	intval($_GET['operas']);
		$endStr 								=	intval($_GET['end']);

		//uid条件
		$memberM								=	$this -> MODEL('userinfo');	
		$uinfo									=	array();
		if(!empty($uidStr)){
			$mlWhereData['uid']					=	array('=', $uidStr);
			$uinfo								=	$memberM -> getInfo(array('uid'=> $uidStr), array('field' => '`uid` , `username`'));
		}
		$pxWhereData = array();
		if(!empty($keywordStr) && $typeStr == 1){
			$pxWhereData['name']				=	array('like', $keywordStr);
		}
		$pxM									=	$this -> MODEL('train');
		if(!empty($pxWhereData)){
			$uidList							=	$pxM -> getList($pxWhereData, array('field' => '`uid`'));
			if(!empty($uidList)){
				foreach($uidList as $uv){
					$memberUid[]				=	$uv['uid'];
				}
			}else{
				$memberUid						=	array(0);
			}
		}
		if(!empty($memberUid)){
			$mlWhereData['uid']					=	array('in', pylode(',', $memberUid));
		}
		//内容条件
		if(!empty($keywordStr) && $typeStr == 2){
			$mlWhereData['content']				=	array('like', $keywordStr);
		}
		//UID条件
		if(!empty($keywordStr) && $typeStr == 3){
			$mlWhereData['uid']					=	array('like', $keywordStr);
		}

		//操作类型条件
		$operaSql 	= 	array(
			'21'	=>	array('name' => array('课程')),
			'20'	=>	array('name' => array('培训师')),
			'19'	=>	array('name' => array('问答')),
			'17' 	=>	array('name' => array('兑换')),
			'13'	=>	array('name' => array('执照', '绑定')),
			'16'	=>	array('name' => array('环境', 'LOGO')),
			'18'	=>	array('name' => array('留言', '消息')),
		);
		if($operasStr == 7){
			$mlWhereData['content']				=	array('like', '资料');
		}elseif(array_key_exists($operasStr, $operaSql)){
			$mlWhereData['PHPYUNBTWSTART']		=	'';
			$mlWhereData['opera']				=	array('=', $operaSql[$operasStr]['realId']);
			foreach ($operaSql[$operasStr]['name'] as $oV) {
				$mlWhereData['content']			=	array('like', $oV, 'OR');
			}
			$mlWhereData['PHPYUNBTWEND']		=	'';
		}elseif(!empty($operasStr)){
			$mlWhereData['opera']				=	array('=', $operasStr);
		}

		$endStr 								=	intval($_GET['end']);
		//结束时间条件
		if(!empty($endStr)){
			if($endStr == 1){
				$mlWhereData['ctime']			=	array('>=', strtotime(date("Y-m-d")));
			}else{
				$mlWhereData['ctime']			=	array('>=', strtotime('-'.$endStr.'day'));
			}
		}
		//时间段条件
		if($_GET['time']){
			$time 								= 	explode('~', $_GET['time']);
			$mlWhereData['ctime']				=	array('>=', strtotime($time[0]));
			$mlWhereData['ctime']				=	array('<=', strtotime($time[1]."23:59:59"));
		}

		$urlarr = $_GET;
		$urlarr['page']							=	"{{page}}";

		$pageurl								=	Url($_GET['m'], $urlarr, 'admin');

		//提取分页
		$pageM									=	$this  -> MODEL('page');
		$pages									=	$pageM -> pageList('member_log', $mlWhereData, $pageurl, $_GET['page']);
		//分页数大于0的情况下 执行列表查询
		$List									=	array();
		if($pages['total'] > 0){
			//limit order 只有在列表查询时才需要
			if(!empty($_GET['order']) && !empty($_GET['t'])){
				$mlWhereData['orderby']			=	$_GET['t'].','.$_GET['order'];
			}else{
				$mlWhereData['orderby']			=	'id';
			}

			$mlWhereData['limit']				=	$pages['limit'];
			$mlM								=	$this -> MODEL('log');
			$List								=	$mlM -> getMemlogList($mlWhereData);
		}
		if(!empty($List)){
			$ltuid								=	array();
			foreach($List as $lv){
				$ltuid[] 						=	$lv['uid'];
			}
			$ltuid								=	array_unique($ltuid);
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
			//补充猎头用户相关的信息
			$pxField							=	'`uid`, `name`';
			$pxList								=	$pxM -> getList($bcWhereData, array('field' => $pxField));
			$pxListIndex						=	array();
			if(!empty($pxList)){
				foreach ($pxList as $pxV) {
					$pxListIndex[$pxV['uid']]	=	$pxV;
				}
			}
			//补充进相关信息
			foreach($List as $Lk => $Lv){
				if(isset($memberListIndex[$Lv['uid']])){
					$List[$Lk]['username']		=	$memberListIndex[$Lv['uid']]['username'];
				}
				if(isset($pxListIndex[$Lv['uid']])){
					$List[$Lk]['name']			=	$pxListIndex[$Lv['uid']]['name'];
				}
			}
		}

	    $this -> yunset('uinfo', $uinfo);
	    $this -> yunset('rows', $List);
	    $this -> siteadmin_tpl(array('admin_train_member_log'));
	}
	/**
	 * 会员- 培训 - 培训用户列表
	 * 查看日志记录->删除日志
	 * 2019-06-04 hjy
	 */
	public function memberlogdel_action(){
		$this -> check_token();
		$del									=	trim($_GET['del']);
		if(empty($del)){
			$this -> layer_msg('请选择您要删除的信息！',8,1,$_SERVER['HTTP_REFERER']);
		}

		$logM									=	$this -> MODEL('log');
		if (is_array($del)){
		    $where  							=	array('id' => array('in',pylode(',', $del)));
		}else{
		    $where  							=	array('id' => array('=', $del));
		}
		$delRes	    							=	$logM -> delMemlog($where);
		$this -> layer_msg($delRes['msg'], 9, $delRes['layertype'], $_SERVER['HTTP_REFERER']);
	}
	
	
	 
	/**
	 * 会员 - 培训 - 培训用户列表:全部培训
	 * 锁定信息
	 * 2019-06-04 hjy
	 */
	public function lockinfo_action(){
		$memberM								=	$this -> MODEL('userinfo');
		$userinfo								=	$memberM -> getInfo(array('uid'=> $_POST['uid']), array('field' => 'lock_info'));
		echo empty($userinfo['lock_info']) ? '' : $userinfo['lock_info'];
		die;
	}
	/**
	 * 会员 - 培训 - 培训用户列表:全部培训
	 * 锁定培训
	 * 2019-06-04 hjy
	 */
	public function lock_action(){
	    
	    $userinfoM  =  $this -> MODEL('userinfo');
	    
	    $post       =  array(
	        'status'     =>  intval($_POST['status']),
	        'lock_info'  =>  trim($_POST['lock_info'])
	    );
	    
	    $return     =  $userinfoM -> lock(array('uid'=>intval($_POST['uid']),'usertype'=>4),array('post'=>$post));
	    
	    $this -> ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);
	}
	/**
	 * 会员 - 培训 - 培训用户列表:全部培训
	 * 审核培训
	 * 2019-06-04 hjy
	 */
	public function status_action(){
	    
	    $userinfoM  =  $this -> MODEL('userinfo');
	    
	    $post       =  array(
	        'status'     =>  intval($_POST['status']),
	        'lock_info'  =>  trim($_POST['statusbody'])
	    );
	    
	    $return     =  $userinfoM -> status(array('uid'=>intval($_POST['uid']),'usertype'=>4),array('post'=>$post));
	    
	    $this -> ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);
	}
	/**
	 * 会员 - 培训 - 培训用户列表:全部培训
	 * 设置推荐
	 * 2019-06-04 hjy
	 */
	public function rec_action(){
		$this->check_token();

		$pxId									=	intval($_GET['id']);
		$pxRec									=	intval($_GET['rec']);
		$upData									=	array();
		$upData['rec']							=	$pxRec;
		if($pxRec == 1){
			$upData['r_status']					=	1;
		}
		$pxM									=	$this -> MODEL('train');
		$nid 									=	$pxM -> upInfo(array('uid' => array('=', $pxId)), $upData);
		$sysmsgM								=	$this -> MODEL('sysmsg');
		//发送会员通知
		if($nid && $pxRec == 1){
			$sysmsgM -> addInfo(array('content' => '管理员设置培训机构推荐','usertype'=>4,  'uid' => $pxId));
		}elseif($nid && $pxRec == 0){
			$sysmsgM -> addInfo(array('content' => '管理员操作：取消培训机构推荐','usertype'=>4,  'uid' => $pxId));
		}
		$this -> MODEL('log') -> addAdminLog("培训机构(ID:".$pxId.")推荐设置成功！");
		echo $nid?1:0;die;
	}
	/**
	 * 会员 - 培训 - 培训用户列表:全部培训
	 * 编辑培训用户
	 * 2019-06-04 hjy
	 */
	public function edit_action(){
		//编辑页面
		$pxId 									= 	intval($_GET['id']);
		$pxM									=	$this -> MODEL('train');
		if(!empty($pxId)){
			//用户信息
			$memberM							=	$this -> MODEL('userinfo');
			$com_info 							=	$memberM -> getInfo(array('uid'=> $pxId));
			//培训信息
			$row 								=	$pxM -> getInfo(array('uid' => array('=', $pxId)));

			$this -> yunset("row", $row);
			$this -> yunset("com_info",$com_info);
			$this -> yunset($this->MODEL('cache')->GetCache(array('com','city','subject')));
			$this -> siteadmin_tpl(array('admin_member_trainedit'));
		}

		if(!empty($_POST['submit'])){
		    
		    $mData   =  array(
		        'username'      =>  $_POST['username'],
		        'password'      =>  $_POST['password'],
		        'email'			=>	$_POST['email'],
		        'moblie'		=>	$_POST['moblie'],
		        'status'        =>  $_POST['status'],
		        'lock_info'     =>  $_POST['lock_info']
		    );
		    
		    $trainData	=	array(
		        'name'			=>	$_POST['name'],
		        'sid'			=>	$_POST['sid'],
		        'pr'			=>	$_POST['pr'],
		        'provinceid'	=>	$_POST['provinceid'],
		        'cityid'		=>	$_POST['cityid'],
		        'threecityid'	=>	$_POST['threecityid'],
		        'mun'			=>	$_POST['mun'],
		        'address'		=>	$_POST['address'],
		        'linkman'		=>	$_POST['linkman'],
		        'linkphone'		=>	$_POST['linkphone'],
		        'linktel'		=>	$_POST['moblie'],
		        'sdate'			=>	$_POST['sdate'],
		        'content' 		=>	str_replace(array("&amp;",'background-color:#ffffff','background-color:#fff','white-space:nowrap;'),array('&','background-color:','background-color:','white-space:'),$_POST['content']),
		        'linkmail'		=>	$_POST['email'],
		        'linkqq'		=>	$_POST['linkqq'],
		        'website'		=>	$_POST['website'],
		        'r_status'      =>  $_POST['status']
		    );
		    $trainM	=	$this	->	MODEL('train');
		    $return =	$trainM	->	upTrainInfo(array('uid'=>$_POST['uid']),array('trainData'=>$trainData,'mData'=>$mData,'utype'=>'admin'));
		    
		    $this	->	ACT_layer_msg($return['msg'], $return['errcode'], $_SERVER['HTTP_REFERER']);
		    
			$editRes							=	$pxM -> editTrain($this -> post_trim($_POST));
			if($editRes['errcode'] == 9){
				$this -> ACT_layer_msg($editRes['msg'], 9, $_SERVER['HTTP_REFERER'], 2, 1);
			}else{
				$this -> ACT_layer_msg($editRes['msg'], 8, $_SERVER['HTTP_REFERER']);
			}
		}

	}
	/**
	 * 会员 - 培训 - 培训用户列表:全部培训
	 * 删除培训用户
	 * 2019-06-04 hjy
	 */
	public function del_action(){
		$this -> check_token();
		
		$userinfoM  =  $this -> MODEL('userinfo');
		
		$return     =  $userinfoM -> delInfo($_GET['del'], 4);
		
		$this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
	}
	/**
	 * 会员 - 培训 - 培训用户列表:全部培训
	 * 数据统计
	 * 2019-06-04 hjy
	 */
	public function pxNum_action(){
		$MsgNum 								=	$this -> MODEL('msgNum');
		echo $MsgNum -> pxNum();
	}
	public function emailstatus_action(){

		$TrainM					    =			$this->MODEL('train');

		$UserinfoM					=			$this->MODEL('userinfo');
			
		if($_POST['trainemailemail']==""){

			$this->ACT_layer_msg("请填写邮箱",8);	

		}elseif(CheckRegEmail($_POST['trainemailemail'])==false){

			$this->ACT_layer_msg("邮箱格式错误",8);	
		}
		
		$uid						=			$_POST['uid'];

		$where['uid']				=			$uid;

		$rows						=			$TrainM->getInfo($where,array('field'=>'`email_status`'));

		if($rows){
			//进行认证管理
			$data					=			array(

				'email_status'		=>			$_POST['status'],

				'linkmail'			=>			$_POST['trainemailemail']

			);

			$nid					=			$TrainM->upInfo($where,$data);

			$emaildata				=			array(

				'email'				=>			$_POST['trainemailemail']

			);

			$UserinfoM->upInfo($where,$emaildata);

			if($nid){

				if($_POST['status']==1){

					$this->ACT_layer_msg("邮箱认证成功",9,$_SERVER['HTTP_REFERER']);

				}else{

					$this->ACT_layer_msg("邮箱取消认证成功",9,$_SERVER['HTTP_REFERER']);


				}
			
			}else{
				if($_POST['status']==1){

					$this->ACT_layer_msg("邮箱认证失败",8,$_SERVER['HTTP_REFERER']);

				}else{

					$this->ACT_layer_msg("邮箱取消认证失败",9,$_SERVER['HTTP_REFERER']);


				}
				
			}


		}else{
			
			$this->ACT_layer_msg("当前数据错误",8,$_SERVER['HTTP_REFERER']);

		}

	}
	public function mobliestatus_action(){

		$TrainM					    =			$this->MODEL('train');

		$UserinfoM					=			$this->MODEL('userinfo');

		if($_POST['trainmobliemoblie']==""){

			$this->ACT_layer_msg("请填写手机号码",8);	

		}elseif(CheckMobile($_POST['trainmobliemoblie'])==false){

			$this->ACT_layer_msg("手机号码格式错误",8);	
		}
			
		$uid						=			$_POST['uid'];

		$where['uid']				=			$uid;

		$rows						=			$TrainM->getInfo($where,array('field'=>'`moblie_status`'));

		if($rows){
			//进行认证管理
			$data					=			array(

				'linktel'			=>			$_POST['trainmobliemoblie'],

				'moblie_status'		=>			$_POST['status']

			);

			$nid					=			$TrainM->upInfo($where,$data);

			$memberdata             =			array(

				'moblie'     		=>  		$_POST['trainmobliemoblie']

			);

			$UserinfoM->upInfo($where,$memberdata);

			if($nid){
				if($_POST['status']==1){

					$this->ACT_layer_msg("手机认证成功",9,$_SERVER['HTTP_REFERER']);

				}else{

					$this->ACT_layer_msg("手机取消认证成功",9,$_SERVER['HTTP_REFERER']);

				}
			
			}else{
				if($_POST['status']==1){

					$this->ACT_layer_msg("手机认证失败",8,$_SERVER['HTTP_REFERER']);

				}else{

					$this->ACT_layer_msg("手机取消认证失败",9,$_SERVER['HTTP_REFERER']);

				}
				
			}

		}else{
			
			$this->ACT_layer_msg("当前数据错误",8,$_SERVER['HTTP_REFERER']);

		}

	}
	//批量认证
	public  function batchfirm_action(){

	    $TrainM		=  $this->MODEL('train');
	    $UserinfoM  =  $this->MODEL('userinfo');
	    $CompanyM	=  $this->MODEL('company');
	    $status     =  $_POST['status'];
	    $msg        =  array();

		if($_POST['trainname_email']==""  && 	$_POST['trainname_moblie']=="" && 	$_POST['trainname_yyzz']==""){

			$this->ACT_layer_msg("请选择认证类型",8);

		}
		if($_POST['uid']==""){

			$this->ACT_layer_msg("非法操作",8);

		}

		if($status==""){

			$this->ACT_layer_msg("请选择认证状态",8);
		
		}

		$where['uid']		=		array('in',pylode(',',$_POST['uid']));

		$rows				=		$TrainM->getList($where,array('field'=>'`uid`,`linktel`,`linkmail`,`email_status`,`moblie_status`'));
		if($_POST['trainname_email'] || $_POST['trainname_moblie']){
			if(is_array($rows) && $rows){

				if($_POST['trainname_email']){
				    array_push($msg, '邮箱');
				    
					foreach($rows  as $val){

						if($val['linkmail'] || $val['email_status']==1){

							$emailuid[]		=		$val['uid'];	

						}

					}

					$emaildata				=		array(

						'email_status'		=>			$status
				
					);

					$emailwhere['uid']		 =			array('in',pylode(',',$emailuid));
					
					$nid					=			$TrainM->upInfo($emailwhere,$emaildata);

				}

				if($_POST['trainname_moblie']){
				    array_push($msg, '手机');
				    
					foreach($rows  as $val){
						
						if($val['linktel'] || $val['moblie_status']==1){

							$moblieuid[]		=		$val['uid'];	

						}

					
					}

					$mobliewhere['uid']		 =			array('in',pylode(',',$moblieuid));

					$mobliedata					=		array(

						'moblie_status'			=>			$status,
				
					);

					$nid					=			$TrainM->upInfo($mobliewhere,$mobliedata);
				}
			}
		}

		if($_POST['trainname_yyzz']){
		    array_push($msg, '营业执照');
		    
			if($status!=0){

				$yyzzwhere['uid']	=		array('in',pylode(',',$_POST['uid']));

				$yyzzwhere['type']	=		5;	
		
				$yyzz				=		$CompanyM->getCertList($yyzzwhere,array('field'=>'`uid`,`check`'));
				
				if(is_array($yyzz) &&  $yyzz){

					foreach($yyzz as $val){
		
						if($val['check']){
		
							$checkuid[]		=		$val['uid'];	
		
						}
					}
				}
				
			}else{

				$checkuid[]		=		$_POST['uid'];	

			}

			
			$yyzzkwhere['uid']		 =				array('in',pylode(',',$checkuid));

			$yyzzkdata					=			array(

				'yyzz_status'			=>			$status
				
			);
		
			$nid						=			$TrainM->upInfo($yyzzkwhere,$yyzzkdata);
				
			$checkdata					=		array(

				'status'				=>			$status

			);

			$checwhere['uid']		 =			array('in',pylode(',',$checkuid));

			$checwhere['type']		 =			5;

			$CompanyM->upCertInfo($checwhere,$checkdata,array('utype'=>'admin'));
		}
		$ty =  $status = 1 ? '已认证' : '待认证';
		
		$this->ACT_layer_msg('(培训列表)'.implode(',', $msg).'批量设置'.$ty.'成功(ID:'.pylode(',',$_POST['uid']).')',9,$_SERVER['HTTP_REFERER'],2,1);
	}

	/**
	 * 会员- 培训 - 培训认证审核
	 * 审核认证 -> 获取审核数据
	 * 2019-06-05 hjy
	 */
	public function sbody_action(){
		$companyM								=	$this -> MODEL('company');

		$userinfo								=	$companyM -> getCertInfo(array('uid' => array('=', $_POST['pid']),'type'=>5), array('field' => '`statusbody`'));
		echo $userinfo['statusbody'];die;
	}


		/**
	 * 会员- 培训 - 培训认证审核
	 * 审核认证 -> 保存审核数据
	 * 2019-06-05 hjy
	 */
	public function trainstatus_action(){
		$pxUid									=	trim($_POST['uid']);
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
				
				$statusInfo  =  $tagName.':'.$v['name'].'审核未通过 ';
				
				if($_POST['statusbody']){
					
					$statusInfo  .=  ', 原因：'.trim($_POST['statusbody']);
					
				}
				
				$msg[$v['uid']]  =  $statusInfo;
				
			}elseif($pxStatus == 1){
				
				$msg[$v['uid']]  =  $tagName.':'.$v['name'].'已审核通过';
				
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
		$id										=	$companyM -> upCertInfo(array('uid' => array('in', $pxUid),'type'=>5), $upData,array('utype'=>'admin'));
		if($id){
			$this -> ACT_layer_msg('培训机构认证审核(UID:'.$_POST['status'].')设置成功！', 9 ,$_SERVER['HTTP_REFERER'], 2, 1);
		}else{
			$this -> ACT_layer_msg('设置失败！', 8, $_SERVER['HTTP_REFERER']);
		}
	}
	public function Imitate_action(){
	    
	    $userinfoM  =  $this->MODEL('userinfo');
	    
	    $member     =  $userinfoM -> getInfo(array('uid'=> intval($_GET['uid'])),array('field'=>'`uid`,`username`,`salt`,`email`,`password`,`usertype`,`did`'));
	    
	    $this -> cookie->unset_cookie();
	    
	    $this -> cookie->add_cookie($member['uid'],$member['username'],$member['salt'],$member['email'],$member['password'],4,$this->config['sy_logintime'],$member['did'],'1');
		
		header('Location: '.$this->config['sy_weburl'].'/member');
	}
}

?>