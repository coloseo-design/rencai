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
class admin_lt_member_controller extends adminCommon{

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

		$ratingM				=	$this -> MODEL('rating');
		$whereData				=	array();
		$whereData['category']	=	array('=', 2);
		$whereData['display']	=	array('=', 1);
		$whereData['orderby']	=	'sort,asc';
		$cusData['field']		=	'`id`,`name`';
		$rating					=	$ratingM -> getList($whereData, $cusData);
		$ratingarr				=	array();
		if(!empty($rating)){
			foreach($rating as $v){
				$ratingarr[$v['id']]=$v['name'];
			}
		}
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
				3	=>	'未通过',
				2	=>	'已锁定',
				4	=>	'未审核'
			)
		);
		$search_list[]	=	array(
			'param'	=>	'rating',
			'name'	=>	'会员等级',
			'value'	=>	$ratingarr
		);
		$search_list[]	=	array(
			'param'	=>	'register',
			'name'	=>	'注册时间',
			'value'	=>	$this -> timeSection
		);
		$search_list[]	=	array(
			'param'	=>	'login',
			'name'	=>	'登录时间',
			'value'	=>	$this -> timeSection
		);

		$this->yunset('ratingarr', $ratingarr);
		$this->yunset('search_list', $search_list);
	}

	/**
	 * 日志搜索功能
	 * 搜索参数
	 */
	public function log_search(){
	
		$opera = array('10' => '职位', '2' => '财务', '3' => '下载简历', '5' => '收藏关注', '6' => '应聘委托', '7' => '基本信息', '8' => '修改密码', '11' => '修改账号', '13' => '认证绑定', '12' => '账号解绑', '16' => '图片', '17' => '积分兑换', '18' => '消息', '19' => '问答', '24' => '优惠券', '25' => '悬赏推荐', '26' => '浏览');
		$search_list[] = array('param' => 'operas', 'name' => '操作类型', 'value' => $opera);
		
		$parr = array('1' => '增加', '2' => '修改', '3' => '删除', '4' => '刷新');
		$search_list[] = array('param' => 'parrs', 'name' => '操作内容', 'value' => $parr);

	    $search_list[] = array('param' => 'end', 'name' => '操作时间', 'value' => $this -> timeSection);
		$this -> yunset('search_list', $search_list);
	}

	/**
	 * 会员-猎头-用户管理:全部猎头
	 */
	public function index_action(){

		$this -> set_search();

		$keywordStr								=	trim($_GET['keyword']);
		$typeStr 								=	intval($_GET['type']);
		$loginStr 								=	intval($_GET['login']);
		$regStr 								=	intval($_GET['register']);
		//如果有用户相关的搜索条件,则先获取用户的id
		$memberWhereData = $ltWhereData = array();
		if(!empty($keywordStr) && $typeStr == 1){
			$memberWhereData['username']		=	array('like', $keywordStr);
		}
		if(!empty($loginStr)){
			if($loginStr == 1){
				$memberWhereData['login_date']	=	array('>=', strtotime(date('Y-m-d')));
			}else{
				$memberWhereData['login_date']	=	array('>=', strtotime('-'.$loginStr.'day'));
			}
		}
		if(!empty($regStr)){
			if($regStr == 1){
				$memberWhereData['reg_date']	=	array('>=', strtotime(date('Y-m-d')));
			}else{
				$memberWhereData['reg_date']	=	array('>=', strtotime('-'.$regStr.'day'));
			}
		}
		if(!empty($_GET['status'])){
			if ($_GET['status']=='4'){
			    $ltWhereData['r_status']		=	array('=', 0);
			}else{
			    $ltWhereData['r_status']		=	array('=', $_GET['status']);
			}
		}
		$memberUid								=	array();

		$memberM								=	$this -> MODEL('userinfo');

		$CompanyM								=	$this -> MODEL('company');
		
		if(!empty($memberWhereData)){
			$resWhere							=	$memberWhereData;
			$uidList							=	$memberM -> getList($resWhere, array('field' => '`uid`'));			
			if(!empty($uidList)){
				foreach($uidList as $uv){
					$memberUid[]				=	$uv['uid'];
				}
			}else{
				$memberUid						=	array(0);
			}
		}
		//公司名称条件
		if(!empty($keywordStr) && $typeStr == 2){
			$ltWhereData['com_name']			=	array('like', $keywordStr);
		}
		//email条件
		if(!empty($keywordStr) && $typeStr == 3){
			$ltWhereData['email']				=	array('like', $keywordStr);
		}
		//moblie条件
		if(!empty($keywordStr) && $typeStr == 4){
			$ltWhereData['moblie']				=	array('like', $keywordStr);
		}
		$ltM									=	$this -> MODEL('lietou');
		//会员等级条件
		$expireduids 							=	array();
		if(!empty($_GET['rating'])){
			$ltStaWbereData						=	array('rating' => array('=', $_GET['rating']));
			$list								=	$ltM -> getLtStatisList($ltStaWbereData, array('field' => '`uid`'));
			if(!empty($list)){
				foreach($list as $val){
					$expireduids[] = $val['uid'];
				}
			}else{
				$expireduids					=	array(0);
			}
		}
		$tmpUidArr = array_unique(array_merge($memberUid, $expireduids));
		if(!empty($tmpUidArr)){
			$ltWhereData['uid']					=	array('in', pylode(',', $tmpUidArr));
		}
		//推荐状态
		if ($_GET['rec'] == 1){
			$ltWhereData['rec']					=	array('=', 1);
		}elseif ($_GET['rec']=='2'){
			$ltWhereData['rec']					=	array('=', 0);
		}

		$urlarr 								=	$_GET;
		$urlarr['page']							=	'{{page}}';
		$pageurl								=	Url($_GET['m'], $urlarr, 'admin');
		//提取分页
		$pageM									=	$this  -> MODEL('page');
		$pages									=	$pageM -> pageList('lt_info', $ltWhereData, $pageurl, $_GET['page']);
		//分页数大于0的情况下 执行列表查询
		$List									=	array();
		if($pages['total'] > 0){
			//limit order 只有在列表查询时才需要
			if(!empty($_GET['order']) && !empty($_GET['t'])){
				$ltWhereData['orderby']			=	$_GET['t'].','.$_GET['order'];
			}else{
				$ltWhereData['orderby']			=	'uid';
			}
			$ltWhereData['limit']				=	$pages['limit'];		
			$List								=	$ltM -> getList($ltWhereData);
		}
		
		if(!empty($List)){
			$ltuid								=	array();
			foreach($List as $lv){
				$ltuid[] 						=	$lv['uid'];
			}
			$bcWhereData						=	array('uid' => array('in', pylode(',',$ltuid)));
			//补充用户相关的信息
			$memberField						=	'`uid`, `login_date`, `reg_date`, `username`, `status`, `login_ip`, `usertype`,`wxid`,`unionid`';
			$memberList							=	$memberM -> getList($bcWhereData, array('field' => $memberField));
			$memberListIndex					=	array();
			if(!empty($memberList)){
				foreach ($memberList as $memberV) {
					$memberListIndex[$memberV['uid']]	=	$memberV;
				}
			}
			//补充会员等级
			$statisField						=	'`uid`, `rating_name`, `rating`, `vip_etime`';
			$statisData							=	array('field' => $statisField, 'index' => 'uid');
			$statisList							=	$ltM -> getLtStatisList($bcWhereData, $statisData);
		
			$certWhereData						=	array('uid' => array('in', pylode(',',$ltuid)));
			$certWhereData						=	array('type' => 4);

			$certField							=	'`uid`,`check`,`status`';
			
			$certdata							=	array('field'=>$certField);

			$certList							=	$CompanyM->getCertList($certWhereData,$certdata);
			
			//补充进相关信息
			foreach($List as $Lk => $Lv){
				
				if(isset($memberListIndex[$Lv['uid']])){
					$List[$Lk]					=	array_merge($List[$Lk], $memberListIndex[$Lv['uid']]);
				}
				if(isset($statisList[$Lv['uid']])){					
					$List[$Lk]					=	array_merge($List[$Lk], $statisList[$Lv['uid']]);
				}	
				foreach($certList  as $val){
					if($Lv['uid']	==	$val['uid']){
						
						$List[$Lk]['check']		=	$val['check'];
						$List[$Lk]['status_n']		=	$val['status'];
						
					}
				}			
			}

		}

		//提取分站内容
		$cacheM									=	$this   -> MODEL('cache');
		$domain									=	$cacheM	-> GetCache('domain');
		
		$this -> yunset('Dname', $domain['Dname']);
		$this -> yunset('rows', $List);
		
		$this -> yuntpl(array('admin/admin_member_ltlist'));
	}
 
	/**
	 * 会员-猎头-用户管理:会员日志
	 */
	public function member_log_action(){

		$this->log_search();
 		
		$mlWhereData 						=	array();
		$mlWhereData['usertype']			=	array('=', 3);

		$uidStr								=	intval($_GET['uid']);
		$keywordStr							=	trim($_GET['keyword']);
		$typeStr 							=	intval($_GET['type']);
		$operasStr							=	intval($_GET['operas']);
		$endStr 							=	intval($_GET['end']);

		//如果有猎头信息相关的搜索条件,则先获取uid
		$ltWhereData = array();
		if(!empty($keywordStr) && $typeStr == 1){
			$ltWhereData['com_name']		=	array('like', $keywordStr);
		}
		$memberUid							=	array();
		$ltM								=	$this -> MODEL('lietou');	
		if(!empty($ltWhereData)){
			$uidList						=	$ltM -> getList($ltWhereData, array('field' => '`uid`'));
			if(!empty($uidList)){
				foreach($uidList as $uv){
					$memberUid[]			=	$uv['uid'];
				}
			}else{
				$memberUid					=	array(0);
			}
		}
		if(!empty($memberUid)){
			$mlWhereData['uid']				=	array('in', pylode(',', $memberUid));
		}

		//uid条件
		$memberM							=	$this -> MODEL('userinfo');	
		$uinfo								=	array();
		if(!empty($uidStr)){
			$mlWhereData['uid']				=	array('=', $uidStr);
			$uinfo							=	$memberM -> getInfo(array('uid'=> $uidStr), array('field' => '`uid` , `username`'));
		}
		//内容条件
		if(!empty($keywordStr) && $typeStr == 2){
			$mlWhereData['content']			=	array('like', $keywordStr);
		}
		//UID条件
		if(!empty($keywordStr) && $typeStr == 3){
			$mlWhereData['uid']				=	array('=', $keywordStr);
		}
		//操作类型条件
		$operaSql 	= 	array(
			'2'		=>	array('name' => array('订单'), 'realId' => 88),
			'3'		=>	array('name' => array('简历'), 'realId' => 3),
			'16'	=>	array('name' => array('头像'), 'realId' => 16),
			'17' 	=>	array('name' => array('兑换'), 'realId' => 17),
			'19' 	=>	array('name' => array('问答'), 'realId' => 19),
			'24' 	=>	array('name' => array('优惠券'), 'realId' => 24),
			'25' 	=>	array('name' => array('悬赏'), 'realId' => 25),
			'26' 	=>	array('name' => array('浏览'), 'realId' => 26),
			'5'	 	=>	array('name' => array('收藏', '关注'), 'realId' => 5),
			'6'		=>	array('name' => array('应聘', '委托'), 'realId' => 6),
			'13'	=>	array('name' => array('认证', '资格证书'), 'realId' => 13),
			'18'	=>	array('name' => array('咨询', '留言'), 'realId' => 18)
		);
		if($operasStr == 10){
			$mlWhereData['PHPYUNBTWSTART']		=	'';
			$mlWhereData['opera']			=	array('=', $operasStr);
			$mlWhereData['opera']			=	array('=', 1, 'OR');
			$mlWhereData['PHPYUNBTWEND']	=	'';
		}elseif(array_key_exists($operasStr, $operaSql)){
			$mlWhereData['PHPYUNBTWSTART']		=	'';
			$mlWhereData['opera']			=	array('=', $operaSql[$operasStr]['realId']);
			foreach ($operaSql[$operasStr]['name'] as $oV) {
				$mlWhereData['content']		=	array('like', $oV, 'OR');
			}
			$mlWhereData['PHPYUNBTWEND']	=	'';
		}elseif(!empty($operasStr)){
			$mlWhereData['opera']			=	array('=', $operasStr);
		}
		//操作内容条件
	    if(!empty($_GET['parrs'])){
			$mlWhereData['type']			=	array('=', $_GET['parrs']);
		}
		//结束时间条件
		if(!empty($endStr)){
			if($endStr == 1){
				$mlWhereData['ctime']		=	array('>=', strtotime(date('Y-m-d')));
			}else{
				$mlWhereData['ctime']		=	array('>=', strtotime('-'.$endStr.'day'));
			}
		}
		//时间段条件
		if($_GET['time']){
			$time 							= 	explode('~', $_GET['time']);
			$mlWhereData['ctime']			=	array('>=', strtotime($time[0]));
			$mlWhereData['ctime']			=	array('<=', strtotime($time[1].'23:59:59'));
		}

		$urlarr = $_GET;
		$urlarr['page']						=	'{{page}}';

		$pageurl							=	Url($_GET['m'], $urlarr, 'admin');

		//提取分页
		$pageM								=	$this  -> MODEL('page');
		$pages								=	$pageM -> pageList('member_log', $mlWhereData, $pageurl, $_GET['page']);
		//分页数大于0的情况下 执行列表查询
		$List								=	array();
		if($pages['total'] > 0){
			//limit order 只有在列表查询时才需要
			if(!empty($_GET['order']) && !empty($_GET['t'])){
				$mlWhereData['orderby']		=	$_GET['t'].','.$_GET['order'];
			}else{
				$mlWhereData['orderby']		=	'id';
			}

			$mlWhereData['limit']			=	$pages['limit'];
			$mlM							=	$this -> MODEL('log');
			$List							=	$mlM -> getMemlogList($mlWhereData);
		}
		if(!empty($List)){
			$ltuid							=	array();
			foreach($List as $lv){
				$ltuid[] 					=	$lv['uid'];
			}
			$ltuid							=	array_unique($ltuid);
			$bcWhereData					=	array('uid' => array('in', pylode(',',$ltuid)));
			//补充用户相关的信息
			$memberField					=	'`uid`, `username`';
			$memberList						=	$memberM -> getList($bcWhereData, array('field' => $memberField));
			$memberListIndex				=	array();
			if(!empty($memberList)){
				foreach ($memberList as $memberV) {
					$memberListIndex[$memberV['uid']]	=	$memberV;
				}
			}
			//补充猎头用户相关的信息
			$ltField						=	'`uid`, `com_name`';
			$ltList							=	$ltM -> getList($bcWhereData, array('field' => $ltField));
			$ltListIndex					=	array();
			if(!empty($ltList)){
				foreach ($ltList as $ltV) {
					$ltListIndex[$ltV['uid']]			=	$ltV;
				}
			}
			//补充进相关信息
			foreach($List as $Lk => $Lv){
				if(isset($memberListIndex[$Lv['uid']])){
					$List[$Lk]['username']	=	$memberListIndex[$Lv['uid']]['username'];
				}
				if(isset($ltListIndex[$Lv['uid']])){
					$List[$Lk]['com_name']	=	$ltListIndex[$Lv['uid']]['com_name'];
				}
			}
		}
		
	    $this -> yunset('uinfo', $uinfo);
	    $this -> yunset('rows', $List);
	    $this -> yuntpl(array('admin/admin_lt_member_log'));
	}


	/**
	 * 会员-猎头-用户管理:全部猎头->删除猎头
	 */
	public function del_action(){
	    
		$this -> check_token();

		$userinfoM  =  $this -> MODEL('userinfo');
		
		$return     =  $userinfoM -> delInfo($_GET['del'], 3);
		
		$this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
	}
	 
	/**
	 * 会员-猎头-用户管理:会员日志->删除
	 */
	public function memberlogdel_action(){
		$this -> check_token();
		$del		=	$_GET['del'];

		if(empty($del)){
			$this -> layer_msg('请选择您要删除的信息！', 8, 1, $_SERVER['HTTP_REFERER']);
		}

		$logM		=	$this -> MODEL('log');
		if (is_array($del)){
		    $where  =	array('id' => array('in',pylode(',', $del)));
		}else{
		    $where  =	array('id' => array('=', $del));
		}
		$delRes	    =	$logM -> delMemlog($where);
		$this -> layer_msg($delRes['msg'], 9, $delRes['layertype'], $_SERVER['HTTP_REFERER']);
	}

	/**
	 * 会员-猎头-用户管理:全部猎头->锁定猎头
	 * 锁定信息
	 */
	public function lockinfo_action(){
		$memberM	=	$this -> MODEL('userinfo');
		$userinfo	=	$memberM -> getInfo(array('uid'=> $_POST['uid']), array('field' => 'lock_info'));
		echo empty($userinfo['lock_info']) ? '' : $userinfo['lock_info'];
		die;
	}

	/**
	 * 会员-猎头-用户管理:全部猎头->审核猎头
	 * 审核猎头
	 */
	public function status_action(){
	    
	    $userinfoM  =  $this -> MODEL('userinfo');
	    
	    $post       =  array(
	        'status'     =>  intval($_POST['status']),
	        'lock_info'  =>  trim($_POST['statusbody'])
	    );
	    
	    $uids       =  @explode(',', $_POST['uid']);
	    
	    $return     =  $userinfoM -> status(array('uid' => array('in', pylode(',', $uids)),'usertype'=>3),array('post'=>$post));
	    
	    $this->ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);
	}

	/**
	 * 会员-猎头-用户管理:全部猎头->修改猎头
	 * 修改猎头信息
	 */
	public function edit_action(){

		//读取相关配置缓存信息
	    $CacheList					=	$this->MODEL('cache')->GetCache(array('lt', 'city', 'ltjob', 'lthy'));
		$this -> yunset($CacheList);
		$ltId 						= 	intval($_GET['id']);

		//编辑页面信息
		if(!empty($ltId)){
			//获取用户信息
			$memberM				=	$this -> MODEL('userinfo');
			$com_info 				=	$memberM -> getInfo(array('uid'=> $ltId));

			//获取猎头信息
			$ltM					=	$this -> MODEL('lietou');
        	$row 					=	$ltM -> getInfo(array('uid' => array('=', $ltId)));
        	if(!empty($row['job'])){
				$job				=	@explode(',',$row['job']);
				foreach ($job as $v){
					$jobname[] 		=	$CacheList['ltjob_name'][$v];
				}
            }
        	$jobname				=	pylode(',', $jobname);
        	$this -> yunset('jobname', $jobname);
        	if(!empty($row['hy'])){
        		$hy					=	@explode(',', $row['hy']);
        		foreach ($hy as $v){
        			$hyname[] 		=	$CacheList['lthy_name'][$v];
        		}
        	}
        	$hyname					=	pylode(',', $hyname);
        	$this -> yunset('hyname', $hyname);
        	
			//会员等级			
			$ratingM				=	$this -> MODEL('rating');
			$whereData				=	array();
			$whereData['category']	=	array('=', 2);
			$whereData['orderby']	=	'sort,asc';
			$rating_list			=	$ratingM -> getList($whereData);

			//猎头统计信息
			$statis					=	$ltM -> getLtStatisInfo(array('uid' => array('=', $ltId)));

			//模板赋值			
        	$this -> yunset('statis', $statis);
        	$this -> yunset('row', $row);
        	$this -> yunset('rating_list', $rating_list);
        	$this -> yunset('rating', $_GET['rating']);
        	$this -> yunset('lasturl', $_SERVER['HTTP_REFERER']);
			$this -> yunset('com_info', $com_info);
			$this -> yuntpl(array('admin/admin_member_ltedit'));
		}

		//保存修改的猎头信息
		if(!empty($_POST['lt_update'])){
			$_POST = $this->post_trim($_POST);
		    $mData   =  array(
		        //'username'      =>  $_POST['username'],
		        //'password'      =>  $_POST['password'],
		        'email'			=>	$_POST['email'],
		        'moblie'		=>	$_POST['moblie'],
		        //'status'        =>  $_POST['status']
		    );
		    
		    $ltData	 =	array(
		        'realname'		=>	$_POST['realname'],
		        'com_name'		=>	$_POST['com_name'],
		        'email'			=>	$_POST['email'],
		        'moblie'		=>	$_POST['moblie'],
		        'phone'			=>	$_POST['phone'],
		        'provinceid'	=>	$_POST['provinceid'],
		        'cityid'		=>	$_POST['cityid'],
		        'three_cityid'	=>	$_POST['threecityid'],
		        'exp'			=>	$_POST['exp'],
		        'title'			=>	$_POST['title'],
		        'hy'			=>	$_POST['hy'],
		        'job'			=>	$_POST['job'],
		        'content'		=>	$_POST['content'],
		        'client'		=>	$_POST['client']
		    );
		    
			$ltM      =  $this -> MODEL('lietou');
			
			$return	  =  $ltM -> upLtInfo(array('uid'=>intval($_POST['uid'])),array('mData'=>$mData,'ltData'=>$ltData,'utype'=>'admin'));
			
			$this -> ACT_layer_msg($return['msg'], $return['errcode'], $_SERVER['HTTP_REFERER'], 2, 1);
		}
	}

	/**
	 * 会员-猎头-用户管理:全部猎头->修改猎头
	 * 修改猎头信息->修改会员级别
	 */
	public function rating_action(){
		$ratUid				=	intval($_POST['uid']);
		$rating_name		=	trim($_POST['rat']);
		$rat_arr			=	@explode(',',$rating_name);
		if(empty($ratUid) || count($rat_arr) != 2){
			echo 0;die;
		}
		$ratingM			=	$this -> MODEL('rating');
		$value				=	$ratingM -> ltratingInfo($rat_arr[0], $ratUid);
		if(empty($value)){
			echo 0;die;
		}
		$ltM				=	$this -> MODEL('lietou');
		$statis				=	$ltM -> getLtStatisInfo(array('uid' => array('=', $ratUid)));
		if(empty($statis)){
			$value['uid']	=	$ratUid;
			$ltM -> addStatis($value);
		}else{
			if($statis['rating'] != $rat_arr[0]){
				$ltM -> upStatis(array('uid' => array('=', $ratUid)), $value);
			}
		}
		echo 1;die;
	}
 
	/**
	 * 会员-猎头-用户管理:全部猎头
	 * 修改会员等级->获取统计等级信息
	 */
	public function getstatis_action(){
		$ratUid					=	intval($_POST['uid']);
		if(empty($ratUid)){
			echo '';die;
		}
		$ltM					=	$this -> MODEL('lietou');
		$fieldData				=	array('field' => '`rating`, `rating_name`, `lt_job_num`, `lt_down_resume`, `lt_editjob_num`,`lt_breakjob_num`, `integral`, `vip_etime`,`chat_num`');
		$rating					=	$ltM -> getLtStatisInfo(array('uid' => array('=', $ratUid)), $fieldData);
		if($rating['vip_etime'] > 0){
			$rating['vipetime'] = date('Y-m-d',$rating['vip_etime']);
		}else{
			$rating['vipetime'] = '不限';				
		}
		echo json_encode($rating);
	}

	/**
	 * 会员-猎头-用户管理:全部猎头
	 * 修改会员等级->保存会员的等级信息
	 */
	public function uprating_action(){
		$ratingId					=	intval($_POST['rating']);
		$ratingUid					=	intval($_POST['ratuid']);
		if(empty($ratingId) || empty($ratingUid)){
			$this->ACT_layer_msg( '缺少参数！', 8, $_SERVER['HTTP_REFERER']);
		}

		unset($_POST['ratuid']);unset($_POST['pytoken']);

		if($_POST['delaytime'] && $_POST['oldetime']){
			
			$_POST['vip_etime'] 	=	strtotime($_POST['delaytime']);
			
		}else{
			$_POST['vip_etime'] 	=	intval($_POST['oldetime']);
		}
		unset($_POST['delaytime']);
		unset($_POST['oldetime']);

		$ratingM					=	$this -> MODEL('rating');
		$ratinginfo					=	$ratingM -> getInfo(array('id' => array('=', $ratingId)), array('field' => '`type`, `name`'));
		$_POST['rating_type']		=	$ratinginfo['type'];
		$_POST['rating_name']		=	$ratinginfo['name'];
		$ltM						=	$this -> MODEL('lietou');
		$id 						=	$ltM -> upStatis(array('uid' => array('=', $ratingUid)), $_POST);

		$id ? $this->ACT_layer_msg('猎头会员等级(ID:'.$ratingUid.')修改成功！', 9, $_SERVER['HTTP_REFERER'], 2, 1) : $this->ACT_layer_msg('修改失败！', 8, $_SERVER['HTTP_REFERER']);
	}

	/**
	 * 会员-猎头-用户管理:全部猎头
	 * 修改会员等级->选择会员等级
	 */
	public function getrating_action(){
		$ratingId	=	intval($_POST['id']);
		$uid		=   intval($_POST['uid']);
		if(empty($ratingId)){
			echo '';die;
		}
		$ratingM					=	$this -> MODEL('rating');
		$rating						=	$ratingM -> changeltratingInfo($ratingId,$uid);
		
		if($rating['vip_etime']>0){
			
			$rating['oldetime'] = $rating['vip_etime'];
			$rating['vipetime'] = date('Y-m-d',$rating['vip_etime']);
			
		}else{
			
			$rating['oldetime'] = 0;
			$rating['vipetime'] = '不限';
			
		}
		
		echo json_encode($rating);
	}

	/**
	 * @desc 后台猎头列表 --  修改 -- 会员套餐 -- 提交表单
	 */
	function saveRating_action(){
	 
	 	if($_POST){

			$uid		=	intval($_POST['uid']);

			$ltM		=	$this->MODEL('lietou');

			$sData		=	array(
			
				'rating'			=>  $_POST['rating'],
				'vip_etime'			=>  $_POST['vip_etime']?strtotime($_POST['vip_etime']):0,
				'lt_job_num'		=>  intval($_POST['lt_job_num']),
				'lt_breakjob_num'	=>  intval($_POST['lt_breakjob_num']),
				'lt_down_resume'	=>  intval($_POST['lt_down_resume']),
				'chat_num'			=>  intval($_POST['chat_num'])
			);
			
			$return		=	$ltM -> setStatisInfo($uid, array('sData' => $sData, 'utype' => 'admin'));
			
			if ($return['errcode'] == 8){
            
				$this->ACT_layer_msg($return['msg'], 8);
			}else{
				
				$this->ACT_layer_msg($return['msg'], $return['errcode'], $_SERVER['HTTP_REFERER'], 2, 1);
			}
		}
		
	}

	/**
	 * @desc 后台猎头列表 --  修改 -- 账户信息 -- 提交表单
	 */
	 function saveUser_action(){
	 
	 	if($_POST){

			$uid		=	intval($_POST['uid']);

			$userInfoM	=	$this->MODEL('userinfo');

			$data		=	array(
			
				'username'	=>	$_POST['username'],
				'password'	=>	$_POST['password'],
				'status'	=>	$_POST['status'],
				'lock_info'	=>	$_POST['lock_info']
			);

			$result		=	$userInfoM -> addMemberCheck($data, $uid, 'admin');

			if(!empty($result['msg'])){

				$this->ACT_layer_msg($result['msg'], 8);
			}else{
				
				$return =	$userInfoM -> upInfo(array('uid' => $uid), $data);

				$this->ACT_layer_msg('更新成功！', 9, $_SERVER['HTTP_REFERER'], 2, 1);
			}
			 
		}
		
	 }

	/**
	 * 会员-猎头-用户管理:全部猎头
	 * 设置推荐
	 */
	public function lt_rec_action(){
		$this -> check_token();
		$ltId						=	intval($_GET['id']);
		$ltRec						=	intval($_GET['rec']);
		$ltM						=	$this -> MODEL('lietou');
		$nid 						=	$ltM -> upInfo(array('uid' => array('=', $ltId)), array('rec' => $ltRec));
		$sysmsgM					=	$this -> MODEL('sysmsg');
		if($nid && $ltRec == 1){
			$sysmsgM -> addInfo(array('content' => '管理员设置猎头推荐','usertype'=>3,  'uid' => $ltId));
		}elseif($nid && $ltRec == 0){
			$sysmsgM -> addInfo(array('content' => '管理员操作：取消猎头推荐','usertype'=>3,  'uid' => $ltId));
		}
		$this -> MODEL('log') -> addAdminLog('猎头会员(ID:'.$ltId.')推荐设置成功！');
		echo $nid?1:0;die;
	}

	/**
	 * 会员-猎头-用户管理:全部猎头
	 * 设置分站
	 */
	public function checksitedid_action(){
		$uid						=	trim($_POST['uid']);
		$did						=	intval($_POST['did']);
		if(empty($uid)){
			$this->ACT_layer_msg('参数不全请重试！', 8, $_SERVER['HTTP_REFERER']);
		}

		$uids						=	@explode(',',$_POST['uid']);
		$uid 						=	pylode(',',$uids);
		if(empty($uid)){
			$this->ACT_layer_msg('请正确选择需分配用户！', 8, $_SERVER['HTTP_REFERER']);
		}

		$siteDomain					=	$this -> MODEL('site');
		$Table						=	array('member', 'company_cert', 'lt_info', 'lt_job', 'lt_statis', 'company_order', 'invoice_record');
		$didData					=	array('did' => $did);
		$siteDomain -> updDid(array('report'), array('p_uid' => array('in', $uid),'usertype'=>3), $didData);
		$siteDomain -> updDid(array('down_resume'), array('comid' => array('in', $uid),'usertype'=>3), $didData);
		$siteDomain -> updDid(array('company_pay','look_resume'), array('com_id' => array('in', $uid),'usertype'=>3), $didData);
		$siteDomain -> updDid(array('userid_job'), array('com_id' => array('in', $uid)), $didData);
		$siteDomain -> updDid($Table, array('uid' => array('in', $uid)), $didData);
		$this -> ACT_layer_msg('会员(ID:'.$_POST['uid'].')分配站点成功！', 9, $_SERVER['HTTP_REFERER'], 2, 1);
	}

	/**
	 * 会员-猎头-用户管理:全部猎头
	 * 数据统计
	 */
	public function ltNum_action(){
 		$MsgNum = $this -> MODEL('msgNum');
		echo $MsgNum -> ltNum();
	}
	public function	 mobliestatus_action(){

		//查询当前邮箱或者当前数据是否存在
		$LietouM    =  $this->MODEL('lietou');
		$_POST = $this->post_trim($_POST);
		$UserinfoM  =  $this->MODEL('userinfo');
			
		$uid		=  $_POST['uid'];
		
		$status     =  $_POST['mstatus'];

		if($_POST['ltphonemoblie']==""){

			$this->ACT_layer_msg("请填写手机号码",8);	

		}elseif(CheckMobile($_POST['ltphonemoblie'])==false){

			$this->ACT_layer_msg("手机号码格式错误",8);	

		}

		$where['uid']				=			$uid;

		$rows						=			$LietouM->getInfo($where,array('field'=>'`moblie_status`'));
		
		if($rows){
			//进行认证管理
			$data					=			array(

			    'moblie_status'		=>			$status,

				'moblie'			=>			$_POST['ltphonemoblie']

			);

			$nid					=			$LietouM->upInfo($where,$data);

			$memberdata  =  array(

				'moblie'     	 =>  $_POST['ltphonemoblie'],
			    'moblie_status'  =>  $status
			);

			$UserinfoM->upInfo($where,$memberdata);

			if($nid){
			    if($status==1){

			        $this->ACT_layer_msg("手机认证成功",9,$_SERVER['HTTP_REFERER'],2,1);

				}else{

				    $this->ACT_layer_msg("手机取消认证成功",9,$_SERVER['HTTP_REFERER'],2,1);

				}
			
			}else{
			    if($status==1){

					$this->ACT_layer_msg("手机认证失败",8,$_SERVER['HTTP_REFERER']);

				}else{

					$this->ACT_layer_msg("手机取消认证失败",8,$_SERVER['HTTP_REFERER']);

				}

				
			}

		}else{
			
			$this->ACT_layer_msg("当前数据错误",8,$_SERVER['HTTP_REFERER']);

		}

	}
	public  function emailstatus_action(){

		//查询当前邮箱或者当前数据是否存在
		$LietouM    =  $this->MODEL('lietou');

		$UserinfoM  =  $this->MODEL('userinfo');
		
		$uid		=  $_POST['uid'];
		
		$status     =  intval($_POST['estatus']);

		if($_POST['ltemailmail']==""){

			$this->ACT_layer_msg("请填写邮箱",8);	

		}elseif(CheckRegEmail($_POST['ltemailmail'])==false){

			$this->ACT_layer_msg("邮箱格式错误",8);	
		}

		$where['uid']  =  $uid;

		$rows		   =  $LietouM->getInfo($where,array('field'=>'`email_status`'));
		
		if($rows){
			//进行认证管理
			$data  =  array(

			    'email_status'  =>  $status,

				'email'			=>  $_POST['ltemailmail']

			);

			$nid		=  $LietouM->upInfo($where,$data);

			$emaildata  =  array(

				'email'			=>	$_POST['ltemailmail'],
			    'email_status'  =>  $status

			);

			$UserinfoM->upInfo($where,$emaildata);


			if($nid){
			    if($status==1){

			        $this->ACT_layer_msg("邮箱认证成功",9,$_SERVER['HTTP_REFERER'],2,1);

				}else{

				    $this->ACT_layer_msg("邮箱取消认证成功",9,$_SERVER['HTTP_REFERER'],2,1);


				}
			
			}else{
			    if($status==1){

					$this->ACT_layer_msg("邮箱认证失败",8,$_SERVER['HTTP_REFERER']);

				}else{

					$this->ACT_layer_msg("邮箱取消认证失败",8,$_SERVER['HTTP_REFERER']);
				}
			}
		}else{
			
			$this->ACT_layer_msg("当前数据错误",8,$_SERVER['HTTP_REFERER']);
		}
	}
	//批量认证
	public  function batchfirm_action(){

		$LietouM	=  $this->MODEL('lietou');
        $UserinfoM  =  $this->MODEL('userinfo');
		$CompanyM	=  $this->MODEL('company');
		$status     =  $_POST['plstatus'];
		$msg        =  array();

		if($_POST['ltname_email']==""  && 	$_POST['ltname_moblie']=="" && 	$_POST['ltname_yyzz']==""){

			$this->ACT_layer_msg("请选择认证类型",8);

		}
		if($_POST['uid']==""){

			$this->ACT_layer_msg("非法操作",8);

		}

		if($status==""){

			$this->ACT_layer_msg("请选择认证状态",8);
		
		}
		if($_POST['ltname_email'] || $_POST['ltname_moblie']){

			$where['uid']		=		array('in',pylode(',',$_POST['uid']));

			$rows				=		$LietouM->getList($where,array('field'=>'`uid`,`email`,`moblie`,`email_status`,`moblie_status`'));

			if(is_array($rows) && $rows){

				if($_POST['ltname_email']){
				    array_push($msg, '邮箱');
				    
					foreach($rows  as $val){

						if($val['email'] ||  $val['email_status']==1){

							$emailuid[]		=		$val['uid'];	

						}

					}

					$emaildata				=		array(

					    'email_status'		=>			$status
				
					);

					$emailwhere['uid']		 =			array('in',pylode(',',$emailuid));
          
                    $UserinfoM->upInfo($emailwhere,$emaildata);
					
					$nid					=			$LietouM->upInfo($emailwhere,$emaildata);

				}

				if($_POST['ltname_moblie']){
				    array_push($msg, '手机');
				    
					foreach($rows  as $val){
						
						if($val['moblie']  ||  $val['moblie_status']==1){

							$moblieuid[]		=		$val['uid'];	

						}

					
					}

					$mobliewhere['uid']		 =			array('in',pylode(',',$moblieuid));

					$mobliedata					=		array(

					    'moblie_status'			=>			$status
				
					);

                    $UserinfoM->upInfo($mobliewhere,$mobliedata);

					$nid					=			$LietouM->upInfo($mobliewhere,$mobliedata);
					
				}
			}
		}
		if($_POST['ltname_yyzz']){
		    array_push($msg, '营业执照');
		    
		    if($status!=0){

				$yyzzwhere['uid']				=		array('in',pylode(',',$_POST['uid']));

				$yyzzwhere['type']				=		4;	

				$yyzz							=		$CompanyM->getCertList($yyzzwhere,array('field'=>'`uid`,`check`'));
			
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
					
			$nid						=			$LietouM->upInfo($yyzzkwhere,$yyzzkdata);

			$checkdata					=			array(

			    'status'				=>			$status

			);

			$checwhere['uid']		 =			array('in',pylode(',',$checkuid));

			$checwhere['type']		 =			4;

			$CompanyM->upCertInfo($checwhere,$checkdata,array('utype'=>'admin'));
		}
		$ty =  $status = 1 ? '已认证' : '待认证';
		
		$this->ACT_layer_msg('(猎头列表)'.implode(',', $msg).'批量设置'.$ty.'成功(ID:'.pylode(',',$_POST['uid']).')',9,$_SERVER['HTTP_REFERER'],2,1);

	}
	/**
	 * 会员-猎头-猎头认证管理
	 * 审核认证 -> 保存数据
	 * 2019-05-31 hjy
	 */
	public function ltstatus_action(){
	    
	    $ltUid									=	trim($_POST['uid']);
	    $ltStatus								=	intval($_POST['r_status']);
	    if(empty($ltUid)){
	        $this -> ACT_layer_msg('非法操作！', 8, $_SERVER['HTTP_REFERER']);
	    }
	    
	    //查询数据是否存在
	    $ltM									=	$this -> MODEL('lietou');
	    $ltlist									=	$ltM -> getList(array('uid' => array('in', $ltUid)), array('field' => '`email`, `uid`, `realname`, `rzid`'));
	    if(empty($ltlist)){
	        $this -> ACT_layer_msg('数据错误！', 8, $_SERVER['HTTP_REFERER']);
	    }
	    
	    if($ltStatus != 1){
	        $cert_status						=	0;
	    }else{
	        $cert_status						=	1;
	    }
	    
	    $notice 								=	$this -> MODEL('notice');
	    $sysmsgM								=	$this -> MODEL('sysmsg');
	    $inteM									=	$this -> MODEL('integral');
	    $companyM								=	$this -> MODEL('company');
	    
	    /* 消息前缀 */
	    $tagName  								=	'职业资格';
	    
	    foreach($ltlist as $v){
	        
	        $uids[]  =  $v['uid'];
	        
	        /* 处理审核信息 */
	        if ($ltStatus == 2){
	            
	            $statusInfo  =  $tagName.':'.$v['name'].'审核未通过';
	            
	            if($_POST['statusbody']){
	                
	                $statusInfo  .=  ' , 原因：'.$_POST['statusbody'];
	                
	            }
	            
	            $msg[$v['uid']]  =  $statusInfo;
	            
	        }elseif($ltStatus == 1){
	            
	            $msg[$v['uid']]  =  $tagName.':'.$v['name'].'已审核通过';
	            
	        }
	    }
	    //发送系统通知
	    $sysmsgM -> addInfo(array('uid'=>$uids,'usertype'=>3, 'content'=>$msg));
	    
	    foreach($ltlist as $v){
	        $rzid								=	"YLT".sprintf("%08d", $v['uid']);
	        //修改lietou信息
	        $ltM -> upInfo(array('uid' => array('=', $v['uid'])),array('yyzz_status' => $cert_status, 'rzid' => $rzid));
	        
	        //记录系统日志
	        if($ltStatus == 1){
	            $certinfo						=	'职业资格审核通过！';
	        }elseif($ltStatus == 2){
	            $certinfo						=	'职业资格审核未通过！';
	        }else{
	            $certinfo						=	'职业资格待审核！';
	        }
	        
	        //发送email
	        if(!empty($v['email'])){
	            $notice -> sendEmailType(array(
	                "uid"		=>	$v['uid'],
	                "name"		=>	$v['realname'],
	                "email"		=>	$v['email'],
	                "certinfo"	=>	$certinfo,
	                "comname"	=>	$v['realname'],
	                "type"		=>	"comcert"
	            )
	                );
	        }
	        //审核通过 修改integral_ltcert
	        if(empty($v['rzid']) && $ltStatus == 1){
	            $inteM -> invtalCheck($v['uid'], 3,'integral_ltcert', '猎头执照认证',21);
	        }
	    }
	    //修改认证表中数据
	    $upData				=	array(
	        'status'		=>	$ltStatus,
	        'statusbody'	=>	trim($_POST['statusbody'])
	    );
	    
	    $id										=	$companyM -> upCertInfo(array('uid' => array('in', $ltUid), 'type' => array('=', 4)), $upData,array('utype'=>'admin'));
	    if($id){
	        $this -> ACT_layer_msg('猎头认证(UID:'.$ltUid.')设置成功！', 9 ,$_SERVER['HTTP_REFERER'], 2, 1);
	    }else{
	        $this -> ACT_layer_msg('设置失败！', 8, $_SERVER['HTTP_REFERER']);
	    }
	}
	public function yyzzlockinfo_action(){
		$companyM								=	$this -> MODEL('company');
		$userinfo								=	$companyM -> getCertInfo(array('uid' => array('=', $_POST['uid']), 'type' => array('=', 4)), array('field' => '`statusbody`'));
		echo $userinfo['statusbody'];die;
	}
	public function Imitate_action(){
	    
	    $userinfoM  =  $this->MODEL('userinfo');
	    
	    $member     =  $userinfoM -> getInfo(array('uid'=> intval($_GET['uid'])),array('field'=>'`uid`,`username`,`salt`,`email`,`password`,`usertype`,`did`'));
	    
 
	    $this -> cookie->unset_cookie();
	    
	    $this -> cookie->add_cookie($member['uid'],$member['username'],$member['salt'],$member['email'],$member['password'],3,$this->config['sy_logintime'],$member['did'],'1');
		
		$logM  		=  $this->MODEL('log');
		
		$content	=	'管理员'.$_SESSION['ausername'].'登录猎头账户'.$member['username'].'成功！';
		
		$adminLo	=	$logM -> addAdminLog($content);
		
		header('Location: '.$this->config['sy_weburl'].'/member');
	}
}
?>