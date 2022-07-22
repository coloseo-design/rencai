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
class index_controller extends train_controller{
	function index_action(){
		$trainM				=		$this->MODEL('train');

		/* 推荐课程 */
		$rswhere			=		array(
		
			'r_status'		=>	1,
			'status'		=>	1,
			'pause_status'	=>	1,
			'rec'			=>	1,
			'orderby'		=>	'id,desc',
			'limit'			=>	8
			
		);
		
		if($this->config['did']){
			
			$rswhere['did']		=		$this->config['did'];
			
		}
		$recsubject				=		$trainM->getSubList($rswhere, array('field' => "`id`,`uid`,`name`,`price`,`pic`" , 'utype'=>'front','num'=>1));
		
		$this->yunset("recsubject",$recsubject);
		
		
		/* 推荐机构 */
		$rtwhere			=		array(
		
			'r_status'		=>	1,
			'name'			=>	array('<>', ''),
			'rec'			=>	1,
			'orderby'		=>	'uid,desc',
			'limit'			=>	12
			
		);
		
		if($this->config['did']){
			
			$rtwhere['did']		=		$this->config['did'];
			
		}
		$rectrain				=		$trainM->getList($rtwhere , array('field'=>'`uid`,`name`,`logo`,`content`' , 'utype'=>'front'));
		
		$this->yunset("rectrain",$rectrain);
		
		/* 最新课程 */
		$nswhere			=		array(
		
			'r_status'		=>	1,
			'status'		=>	1,
			'pause_status'	=>	1,
			'orderby'		=>	'ctime,desc',
			'limit'			=>	8
			
		);
		
		if($this->config['did']){
			
			$nswhere['did']		=		$this->config['did'];
			
		}
		$NewSubjectList			=		$trainM->getSubList($nswhere, array('field' => "`id`,`uid`,`name`,`price`,`pic`" , 'utype'=>'front','num'=>1));
	
		$this->yunset("newsubject",$NewSubjectList);
		
		
		/* 明星讲师 */
		$twhere				=		array(
		
			'r_status'		=>	1,
			'status'		=>	1,
			'rec'			=>	1,
			'orderby'		=>	'id,desc',
			'limit'			=>	10
			
		);
		
		if($this->config['did']){
			
			$twhere['did']		=		$this->config['did'];
			
		}
		$teacher				=		$trainM->getTeaList($twhere,array('field'=>'`id`,`uid`,`name`,`pic`,`sid`'));
	   
		$this->yunset("teacher",$teacher);
		
		$CacheM					=	$this->MODEL('cache');
		$CacheList				=	$CacheM->GetCache(array('subject'));
		
		$this->yunset($CacheList);
		
		
		/* 机构新闻 */
		$nwhere				=		array(
		
			'r_status'		=>	1,
			'status'		=>	1,
			'orderby'		=>	'id,desc',
			'limit'			=>	8
			
		);
		
		if($this->config['did']){
			
			$nwhere['did']		=		$this->config['did'];
			
		}
		$newslist				=		$trainM->getPxnewsList($nwhere,array('field'=>'`id`,`uid`,`title`,`ctime`'));
		
		$this->yunset("newslist",$newslist);
		
		
		/* 关键字显示 */
		include PLUS_PATH."keyword.cache.php";
		if(is_array($keyword)){
			
			foreach($keyword as $k=>$v){
				  
				if($v['type']=='9'&&$v['tuijian']=='1'){
						
					$subjectkeyword[]	=	$v;
				}
			}
		}
		$this->yunset("subjectkeyword",$subjectkeyword);
		
		$this->public_action();
		$this->seo('train_index');
		$this->train_tpl('index');
	}
	
	function register_action(){
		$this			->	public_action();
		$this			->	seo('register');
		
		
		if($this->config['reg_user_stop']!=1){		 
			$this->train_tpl('stopreg');
		}else{ 
			if($this->uid!=""&&$this->username!=""){
				$this->logout(false);
			}
			if($_POST){
				$Member      				=   	$this->MODEL('userinfo');
				$data['usertype']			=		4;
				$data['uid']				=		$this->uid;
				$data['password']			=		$_POST['password'];
				$data['passconfirm']		=		$_POST['passconfirm'];
				$data['username']			=		$_POST['username'];
				$data['email']				=		$_POST['email'];
				$data['realname']			=		$_POST['realname'];
				$data['moblie_code']		=		$_POST['moblie_code'];
				$data['code']				=		$_POST['authcode'];
				$data['codeid']				=		$_POST['codeid'];				
				$data['port']				=		1;				
				
				$return 					=		$Member->userRegSave($data);
				
				if($return['errcode']){
					$arr['status']			=		$return['errcode'];
					$arr['msg']  			= 		$return['msg'];
				}else{
					$arr['status']			=		8;
					$arr['msg']  			= 		$return['msg'];
				}
				
				echo json_encode($arr);die;
			}else{
				
				$this->train_tpl('register');
			}
		}
	}
	
	function login_action(){
		if($this->uid!=""&&$this->username!=""){
			if($_GET['type']=="out"){       
				
				$this->cookie->unset_cookie();
				
			}else{
				$this->ACT_msg($this->config['sy_weburl']."/member", "您已经登录了！");
			}
		}

		if($_POST){
			$Member					=			$this	->	MODEL('userinfo');
			
			$lData['username']		=			$_POST['username'];
			$lData['uid']			=			$this->uid;
			$lData['usertype']		=			$this->usertype;
			$lData['path']			=			$_POST['path'];
			$lData['password']		=			$_POST['password'];
			$lData['backurl']		=			$_POST['backurl'];
			$_POST['authcode']		=			$_POST['authcode'];
			$return					=			$Member->userLogin($lData);
			
			if($return['errcode']==9){
        	echo json_encode(array('url'=>$return['url'],'errcode'=>1));die;
			
			}else{
				echo $return['msg'];die;
			}
		}
		$this->yunset("cookie", $_COOKIE['checkurl']);
		$this->public_action();
   		 $this->yunset("referurl",$_SERVER['HTTP_REFERER']);
		$this->seo("login");
		$this->train_tpl('login');
	}
	
	/* 培训课程列表页 */
	function subject_action(){
		$trainM				=		$this->MODEL('train');
		$CacheM				=		$this->MODEL('cache');
		
		if($_GET['all']){
	    	$all			=	explode("_",$_GET['all']);
			$_GET['nid']	=	$all[0];
	    	$_GET['tnid']	=	$all[1];
	    	$_GET['type']	=	$all[2];
	    }
		
		if($_GET['orderby']){
	    	$orderby		=	explode("_",$_GET['orderby']);
			$_GET['order']	=	$orderby[0];
	    	$_GET['t']		=	$orderby[1];
	    }
		
		if($_GET['t']=='desc'){
			$this->yunset('t','asc');
		}else{
			$this->yunset('t','desc');
		}
		
		
		$CacheList			=	$CacheM->GetCache(array('subject','subjecttype'));
		
		$this->right();
		$this->yunset($CacheList);
		$this->public_action();
		$this->yunset("def","1");
		
		$subWhereData['r_status']				=	1;
		
		$subWhereData['status']					=	'1';
		
		$subWhereData['pause_status']			=	'1';
		
		if($this->config['did']){	
		
			$subWhereData['did']				=	$this->config['did'];
			
		}
		if((int)$_GET['minprice']){
			
			$subWhereData['price'][]			=	array('>=', (int)$_GET['minprice']);
			
			$urlarr['minprice']					=	(int)$_GET['minprice'];
		}
		
		if((int)$_GET['maxprice']){
			
			$subWhereData['price'][]			=	array('<=', (int)$_GET['maxprice']);
			
			$urlarr['maxprice']					=	(int)$_GET['maxprice'];
		}
		
		if((int)$_GET['nid']){
			
			$subWhereData['nid']				=	(int)$_GET['nid'];
			
			$urlarr['nid']						=	(int)$_GET['nid'];
		}
		
		if((int)$_GET['tnid']){
			
			$subWhereData['tnid']				=	(int)$_GET['tnid'];
			
			$urlarr['tnid']						=	(int)$_GET['tnid'];
		}
		
		if((int)$_GET['type']){
			
			$subWhereData['type']				=	(int)$_GET['type'];
			
			$urlarr['type']						=	(int)$_GET['type'];
		}
		
		if((int)$_GET['rec']){
			
			$subWhereData['rec']				=	(int)$_GET['rec'];
			
			$urlarr['rec']						=	(int)$_GET['rec'];
		}
		
		if($_GET['keyword']){
			
			$subWhereData['name']				=	array('like', trim($_GET['keyword']));
			
			$urlarr['keyword']					=	(int)$_GET['keyword'];
		}
		
		
		
		$urlarr['c'] 							=	$_GET['c'];
		$urlarr['page']							=	"{{page}}";
		$pageurl								=	Url("train",$urlarr);
		//提取分页
		$pageM									=	$this  -> MODEL('page');
		$pages									=	$pageM -> pageList('px_subject', $subWhereData, $pageurl, $_GET['page']);
		
		if($pages['total'] > 0){
			
			if($_GET['order']){
				$subWhereData['orderby']		=	$_GET['order'].','.$_GET['t'];
				
				$urlarr['order']				=	$_GET['order'];
				
				$urlarr['t']					=	$_GET['t'];
			}else{
				$subWhereData['orderby']		=	'id,desc';
			}
			
			$subWhereData['limit']				=	$pages['limit'];		
			$List								=	$trainM -> getSubList($subWhereData,array('utype'=>'front','num'=>1));
			
			$this->yunset("rows",$List);
		}
		
		
		if(!empty($List) && $_GET['keyword']){
			
			$this->addkeywords("9",$_GET['keyword']);
			
		}
		
		//关键字显示
		include PLUS_PATH."keyword.cache.php";
		if(is_array($keyword)){
			
			  foreach($keyword as $k=>$v){
				  
					if($v['type']=='9'&&$v['tuijian']=='1'){
						
						$subjectkeyword[]	=	$v;
					}
			  }
		}
		$this->yunset("subjectkeyword",$subjectkeyword);
		
		$this->seo("subject");
		$this->yunset("total",$pages['total']);
		$this->train_tpl('subject');
	}
	
	/* 培训课程内容页 */
	function subshow_action(){
		if((int)$_GET['id']){
            $trainM		=	$this->MODEL('train');
            $resumeM	=	$this->MODEL('resume');
			$CompanyM	=	$this->MODEL("company");
			$CacheM		=	$this->MODEL('cache');
			$lietouM	=	$this->MODEL('lietou');
			
			$CacheList	=	$CacheM->GetCache(array('city','subject'));
			$this->yunset($CacheList);
			
			/* 课程详情 */
			$rwhere		=	array(
			
				'id'				=>	(int)$_GET['id'],
				
				'PHPYUNBTWSTART_A'	=>	'',
				
				'uid'				=>	array('=' , $this->uid),
				
				'PHPYUNBTWSTART_B'	=>	'OR',
				
				'status'			=>	'1',
				
				'pause_status'		=>	'1',
				
				'PHPYUNBTWEND_B'	=>	'',
				
				'PHPYUNBTWEND_A'	=>	''
			
			);
			
			$row		=	$trainM->getSubInfo($rwhere,array('utype'=>'front'));
			
			if($row['id']==''){
				
				$this->ACT_msg($this->config['sy_weburl'],"没有找到该课程！");
				
			}
			if ($row['r_status']==2){
				
			    $this->ACT_msg($this->config['sy_weburl'],"发布该课的机构已被锁定！");
				
			}else{
				$trainM->upSubInfo(array('id'=>(int)$_GET['id']),array('hits'=>array('+',1)));

			    $this->yunset("row",$row);
				
			    /* 收藏数目 */
			    $collect_num	=	$trainM->getSubCollectNum(array('sid'=>$row['id']));
			    $this->yunset("collect_num",$collect_num);
			    
				/* 培训机构信息 */
			    $infoWhere  =  array(
			        'uid'  =>  $row['uid']
			    );
			    if (!$this->uid || $row['uid'] != $this->uid){
			        $infoWhere['r_status']  =  1;
			    }
			    $traininfo		=	$trainM->getInfo($infoWhere);
			    $this->yunset("train",$traininfo);
				
				/* 该机构其他课程 */
			    $otherlist		=	$trainM->getSubList(array('r_status'=>1,'uid'=>$row['uid'],'id'=>array('<>', (int)$_GET['id']),'status'=>1,'pause_status'=>1) , array('num'=>1 ,'uid'=>$this->uid));
			    $this->yunset("otherlist",$otherlist);

				/* 报名的时候，调用姓名和联系电话 */
			    if($this->uid&&$this->usertype!='4'){

			        if($this->usertype==1){
			            $member				=	$resumeM->getResumeInfo(array("uid"=>$this->uid),array("field"=>'name,telphone'));
			            $user['name']		=	$member['name'];
			            $user['phone']		=	$member['telphone'];
						
			        }elseif($this->usertype==2){
			            $member				=	$CompanyM->getInfo($this->uid,array("field"=>'linkman,linktel'));
			            $user['name']		=	$member['linkman'];
			            $user['phone']		=	$member['linktel'];
						
			        }elseif($this->usertype==3){
			            $member				=	$lietouM->getInfo(array("uid"=>$this->uid),array("field"=>'realname,moblie,phone'));
			            $user['name']		=	$member['realname'];
			            if($member['moblie']){
			                $user['phone']	=	$member['moblie'];
			            }elseif($member['phone']){
			                $user['phone']	=	$member['phone'];
			            }
			        }
			        $this->yunset("user",$user);
				   
					/* 获取收藏课程信息 */
			        $collect	=	$trainM->getSubCollectInfo(array('uid'=>$this->uid,'sid'=>(int)$_GET['id']));
			        $this->yunset("collect",$collect);
					
					/* 获取报名信息 */
			        $baoming	=	$trainM->getBmInfo(array('uid'=>$this->uid,'sid'=>(int)$_GET['id']));
			        $this->yunset("baoming",$baoming);
			    }
			}
		}
		
		/* 课程内容页关注培训机构 */
		$this->getAtnTrain((int)$row['uid']);
		
		$data['px_subject_name']	=	$row['name'];
		$this->data	=	$data;
		$this->reclist((int)$row['uid']);
		$this->public_action();
		$this->yunset("def","1");
		$this->seo("subject_show");
		$this->train_tpl('subject_show');

	}

	/* 培训机构列表页*/
	function agency_action(){
		$trainM				=		$this->MODEL('train');
		$CacheM				=		$this->MODEL('cache');
		
		/* 城市匹配 */
		if($_GET[city]){
	    	$city					=	explode("_",$_GET[city]);
	    	$_GET['provinceid']		=	$city[0];
	    	$_GET['cityid']			=	$city[1];
	    	$_GET['three_cityid']	=	$city[2];
	    }
		
		if($_GET['all']){
	    	$all			=	explode("_",$_GET['all']);
			$_GET['sid']	=	$all[3];
	    	$_GET['mun']	=	$all[4];
	    	$_GET['pr']		=	$all[5];
	    }
		
		if($_GET['orderby']){
	    	$orderby		=	explode("_",$_GET['orderby']);
			$_GET['order']	=	$orderby[0];
	    	$_GET['t']		=	$orderby[1];
	    }
		
		$where['r_status']			=	1;
		
		$where['name']				=	array('<>', '');
		
		$where['sid']				=	array('<>', '');
		
		if($this->config['did']){				
			$where['did']			=	$this->config['did'];		
		}
		if((int)$_GET['sid']){
			$where['sid']			=	(int)$_GET['sid'];		
		}
		if((int)$_GET['pr']){
			$where['pr']			=	(int)$_GET['pr'];		
		}
		if((int)$_GET['provinceid']){
			$where['provinceid']	=	(int)$_GET['provinceid'];		
		}
		if((int)$_GET['cityid']){
			$where['cityid']		=	(int)$_GET['cityid'];		
		}
		if((int)$_GET['three_cityid']){
			$where['threecityid']	=	(int)$_GET['three_cityid'];		
		}
		if((int)$_GET['mun']){
			$where['mun']			=	(int)$_GET['mun'];		
		}
		if((int)$_GET['rec']){
			$where['rec']			=	(int)$_GET['rec'];		
		}
		if($_GET['keyword']){
			$where['name']			=	array('like' , trim($_GET['keyword']));		
		}
		
		$urlarr['c'] 				=	$_GET['c'];
		$urlarr['page']				=	"{{page}}";
		$pageurl					=	Url("train",$urlarr);
		$pageM						=	$this  -> MODEL('page');
		$pages						=	$pageM -> pageList('px_train', $where, $pageurl, $_GET['page']);
		
		if($pages['total'] > 0){
			
			$where['orderby']		=	'uid,desc';
			 
			$where['limit']			=	$pages['limit'];	
			
			$List					=	$trainM -> getList($where,array('utype'=>'front','num'=>1));
			
			$this->yunset("rows",$List);
		}
		
		if(isset($List) && is_array($List)){
			if($_GET['keyword']){
				$this->addkeywords("10",$_GET['keyword']);
			}
		}
		
		$CacheList	=	$CacheM->GetCache(array('com','city','subject'));
		$this->right();
		$this->yunset($CacheList);
		
		/* 关键字显示 */
		include PLUS_PATH."keyword.cache.php";
		if(is_array($keyword)){
			foreach($keyword as $k=>$v){
				if($v['type']=='10'&&$v['tuijian']=='1'){
					$agencykeyword[]	=	$v;
				}
			}
		}
		$this->yunset("agencykeyword",$agencykeyword);
		$this->public_action();
		$this->yunset("def","3");
		$this->seo("agency");
		
		$this->train_tpl('agency');
	}
	
	/* 培训机构内容页 */
	function agencyshow_action(){
		$trainM					=		$this->MODEL('train');
			
		$id=(int)$_GET['id'];		
		
		/* 机构内容页关注培训机构 */
		$this->getAtnTrain((int)$_GET['id']);
		
		$show					=		$trainM->getPxshowList(array('uid'=>$id));
		
		$this->yunset("show",$show);
		
		/* 课程 */
		$swhere					=		array(
		
			'r_status'			=>		array('<>', '2'),
			'status'			=>		1,
			'pause_status'		=>		1,
			'uid'				=>		$id,
			'orderby'			=>		'ctime,desc',
			'limit'				=>		6
			
		);
		$sublist				=		$trainM->getSubList($swhere, array('field' => "`id`,`uid`,`name`,`price`,`pic`,`tnid`,`ctime`,`cityid`,`threecityid`,`hours`" , 'utype'=>'front','num'=>1 ,'uid'=>$this->uid));
		
		$this->yunset('sublist',$sublist);
		$this->reclist($id);
		$this->agency($id);
		$this->public_action();
		$this->yunset("def","3");
		$this->seo("agency_show");
		$this->train_tpl('agency_show');
	}
	
	/* 培训机构内容页关注培训机构 */
	function intro_action(){
		$this->getAtnTrain((int)$_GET['id']);
		$this->reclist((int)$_GET['id']);
		$this->agency((int)$_GET['id']);
		$this->public_action();
		$this->seo("agency_intro");
		$this->yunset("def","3");
		$this->train_tpl('intro');
	}
	
	/* 培训机构课程 */
	function mysubject_action(){
        $trainM					=	$this->MODEL('train');
		
		/* 机构内容页关注培训机构 */
		$this->getAtnTrain((int)$_GET['id']);
		
		/* 机构 */
		$where				=		array(
		
			'r_status'		=>	array('<>', '2'),
			'status'		=>	1,
			'pause_status'	=>	1,
			'uid'			=>	(int)$_GET['id']
			
		);
		
		$urlarr['id']							=	$_GET['id'];
		$urlarr['c'] 							=	$_GET['c'];
		$urlarr['page']							=	"{{page}}";
		$pageurl								=	Url("train",$urlarr);
		$pageM									=	$this  -> MODEL('page');
		$pages									=	$pageM -> pageList('px_subject', $where, $pageurl, $_GET['page']);
		
		if($pages['total'] > 0){
			
			$where['orderby']			=	'id,desc';
			
			$where['limit']				=	$pages['limit'];		
			$List						=	$trainM -> getSubList($where,array('num'=>1 ,'uid'=>$this->uid));
			
			$this->yunset("rows",$List);
		}
		
		$this->reclist((int)$_GET['id']);
		$this->agency((int)$_GET['id']);
		$this->public_action();
		$this->seo("mysubject");
		$this->yunset("def","3");
		$this->train_tpl('mysubject');
	}
	
	/* 收藏培训课程 */
	function collect_action(){
		$trainM	=	$this->MODEL('train');
		
		$data['uid']		=	$this->uid;
		$data['usertype']	=	$this->usertype;
		$data['id']			=	$_POST['id'];
		
		$return	=	$trainM	-> collectSub($data);	
		
		echo $return ;die;
		
	}
	
	/* 培训机构新闻 */
	function news_action(){
		$trainM					=		$this->MODEL('train');
		
		$id						=		(int)$_GET['id'];
		/* 机构内容页关注培训机构 */
		$this->getAtnTrain((int)$_GET['id']);
		
		$where['uid']			=		$id;
			
		$where['status']		=		1;
				
		$urlarr['id']			=		$_GET['id'];
		$urlarr['c'] 			=		$_GET['c'];
		$urlarr['page']			=		"{{page}}";
		$pageurl				=		Url("train",$urlarr);
		$pageM					=		$this  -> MODEL('page');
		$pages					=		$pageM -> pageList('px_train_news', $where, $pageurl, $_GET['page']);
			
		if($pages['total'] > 0){	
				
			$where['orderby']	=		'ctime,desc';
				
			$where['limit']		=		$pages['limit'];	
				
			$List				=		$trainM -> getPxnewsList($where);
			
			$this->yunset("rows",$List);
		}
 
		$this->reclist($id);
		$this->agency($id);
		$this->public_action();
		$this->seo("px_news");
		$this->yunset("def","3");
		$this->train_tpl('news');
	}
	
	/* 培训机构新闻详情页 */
	function newsshow_action(){
		$trainM					=		$this->MODEL('train');
		
		$id						=		(int)$_GET['id'];
		/* 机构内容页关注培训机构 */
		$this->getAtnTrain((int)$_GET['id']);
		
		$this->reclist((int)$_GET['id']);
		$this->agency((int)$_GET['id']);
		$this->public_action();
		
		if($_GET['nid']){
			
			$nwhere['id']						=		(int)$_GET['nid'];
							
            if ($_GET['id']){			
					
				$nwhere['uid']					=		intval($_GET['id']);
						
                $news							=		$trainM->getPxnewsInfo($nwhere);
            }else{   			
			
				$nwhere['PHPYUNBTWSTART']		=		'';
				
				$nwhere['uid']					=		$this->uid;
				
				$nwhere['status']				=		array('=' , '1' , 'OR');
		
				$nwhere['PHPYUNBTWEND']			=		'';
														
                $news							=		$trainM->getPxnewsInfo($nwhere);
           
			}
			
			$this->yunset("news",$news);
			
			$data['news_title']					=		$news['title'];
			
			$this->data							=		$data;
		}
		$this->seo("px_news_show");
		$this->train_tpl('news_show');
	}

	/* 培训课程报名 */
	function baoming_action(){
		if($_POST['submit']){
            $orderM				=		$this->MODEL('companyorder');
			
			$data['uid']		=		$this->uid;
			
			$data['did']		=		$this->userdid;
			
			$data['usertype']	=		$this->usertype;
			
			$data['sid']		=		$_POST['sid'];
			
			$data['s_uid']		=		$_POST['s_uid'];
									 
			$data['name']		=		$_POST['name'];
										 
			$data['phone']		=		$_POST['phone'];
									 
			$data['content']	=		$_POST['content'];
									 
			$data['price']		=		$_POST['price'];
			
			$data['isprice']	=		$_POST['isprice'];
			
			$return				=		$orderM->addBaomingOrder($data);
			
			$this->ACT_layer_msg($return['msg'],$return['cod'],$return['url']);
			
		}
	}

	/* 咨询留言 */
	function zixun_action(){
		$trainM		=	$this->MODEL('train');
		
		if($_POST['submit']){
			
			if(!$this->uid){
				$this->ACT_layer_msg("您还没有登录，请先登录！",8,$_SERVER['HTTP_REFERER']);
			}
			if($_POST['s_uid'] == $_POST['uid']){
				$this->ACT_layer_msg("自己不能咨询自己培训信息！",8,$_SERVER['HTTP_REFERER']);
			}
			if($this->usertype==4){
				$this->ACT_layer_msg("只有个人用户和hr才可以咨询课程！",8,$_SERVER['HTTP_REFERER']);
			}
			if($_POST['phone']==''){
				$this->ACT_layer_msg("联系电话不能为空！",8);
			}
			if(!CheckMobile($_POST['phone'])){
				$this->ACT_layer_msg("请正确填写联系电话！",8);				
			}
			if($_POST['content']==''){
				$this->ACT_layer_msg("内容不能为空！",8);
			}
			$trainM->addPxzixun(array('uid'=>$this->uid,'sid'=>$_POST['sid'],'s_uid'=>$_POST['s_uid'],'phone'=>$_POST['phone'],'content'=>$_POST['content'],'ctime'=>time(),'did'=>$this->userdid,'usertype'=>$this->usertype));
			$this->automsg("您收到一份咨询",$_POST['s_uid']);
			$this->ACT_layer_msg("咨询成功！",9,$_SERVER['HTTP_REFERER']);
		}
		
		$id						=		(int)$_GET['id'];
		/* 机构内容页关注培训机构 */
		$this->getAtnTrain((int)$_GET['id']);
		
		$where['s_uid']			=		$id;
				
		$urlarr['id']			=		$_GET['id'];
		$urlarr['c'] 			=		$_GET['c'];
		$urlarr['page']			=		"{{page}}";
		$pageurl				=		Url("train",$urlarr);
		$pageM					=		$this  -> MODEL('page');
		$pages					=		$pageM -> pageList('px_zixun', $where, $pageurl, $_GET['page']);
			
		if($pages['total'] > 0){	
				
			$where['orderby']	=		'ctime,desc';
				
			$where['limit']		=		$pages['limit'];	
				
			$List				=		$trainM -> getPxzxList($where,array('utype'=>'front'));
			
			$this->yunset("rows",$List);
		}
 
		/* 推荐课程 */
		$nswhere			=		array(
		
			'r_status'		=>	array('<>', '2'),
			'status'		=>	1,
			'pause_status'	=>	1,
			'rec'			=>	1,
			'orderby'		=>	'ctime,desc',
			'limit'			=>	4
			
		);
		$reclist		=		$trainM->getSubList($nswhere, array('field' => "`id`,`uid`,`name`,`price`,`pic`" ));
		$this->yunset("reclist",$reclist);
		
		$this->agency((int)$_GET['id']);
		$this->public_action();
		$this->seo("zixun");
		$this->yunset("def","3");
		$this->train_tpl('zixun');
	}

	function link_action(){
		$this->getAtnTrain((int)$_GET['id']);
		$this->reclist((int)$_GET['id']);
		$this->agency((int)$_GET['id']);
		$this->public_action();
		$this->seo("px_link");
		$this->yunset("def","3");
		$this->train_tpl('link');
	}
	
	function show_action(){	
		$trainM					=		$this->MODEL('train');
		//机构内容页关注培训机构
		$this->getAtnTrain((int)$_GET['id']);
		
		$where['uid']			=		(int)$_GET['id'];
		
		$urlarr['id']			=		$_GET['id'];
		$urlarr['c'] 			=		$_GET['c'];
		$urlarr['page']			=		"{{page}}";
		$pageurl				=		Url("train",$urlarr);
		$pageM					=		$this  -> MODEL('page');
		$pages					=		$pageM -> pageList('px_train_show', $where, $pageurl, $_GET['page']);
		
		if($pages['total'] > 0){	
				
			$where['orderby']	=		'id,desc';
				
			$where['limit']		=		$pages['limit'];	
				
			$List				=		$trainM -> getPxshowList($where);
			
			$this->yunset("rows",$List);
		}
 		
		$this->reclist((int)$_GET['id']);
		$this->agency((int)$_GET['id']);
		$this->public_action();
		$this->seo("px_show");
		$this->yunset("def","3");
		$this->train_tpl('show');
	}

	function team_action(){
		$trainM	=	$this->MODEL('train');
		
		/* 机构内容页关注培训机构 */
		$this->getAtnTrain((int)$_GET['id']);
		
		$where['r_status']	=	1;
		$where['uid']		=	(int)$_GET['id'];
		$where['status']	=	'1';
		
		$urlarr['id']		=	$_GET['id'];
		$urlarr['c'] 		=	$_GET['c'];
		$urlarr['page']		=	"{{page}}";
		$pageurl			=	Url("train",$urlarr);
		$pageM				=	$this  -> MODEL('page');
		$pages				=	$pageM -> pageList('px_teacher', $where, $pageurl, $_GET['page']);
		
		if($pages['total'] > 0){	
				
			$where['orderby']	=	'ctime,desc';
			$where['limit']		=	$pages['limit'];	
				
			$List				=	$trainM -> getTeaList($where);
			$this->yunset("rows",$List);
		}
		$this->reclist((int)$_GET['id']);
		$this->agency((int)$_GET['id']);
		$this->yunset($this->MODEL('cache')->GetCache(array('hy')));
		$this->public_action();
		$this->seo("team");
		$this->yunset("def","3");
		$this->train_tpl('team');
	}
	
	/* 培训师 */
	function teacher_action(){
		$trainM							=	$this->MODEL('train');
		
		/* 城市匹配 */
		if($_GET['city']){
	    	$city						=	explode("_",$_GET['city']);
	    	$_GET['provinceid']			=	$city[0];
	    	$_GET['cityid']				=	$city[1];
	    	$_GET['three_cityid']		=	$city[2];
	    }	
			
		if($_GET['all']){	
	    	$all						=	explode("_",$_GET['all']);
			$_GET['sid']				=	$all[3];
	    }	
			
		$where['r_status']				=	1;
			
		$where['status']				=	'1';
		
		if($this->config['did']){		
			$where['did']				=	$this->config['did'];
		}	
			
		if((int)$_GET['sid']){	
			$where['sid']				=	(int)$_GET['sid'];
			$urlarr['sid']				=	(int)$_GET['sid'];
		}
		
		if((int)$_GET['provinceid']){
			$where['provinceid']		=	(int)$_GET['provinceid'];
			$urlarr['provinceid']		=	(int)$_GET['provinceid'];
		}	
			
		if((int)$_GET['cityid']){	
			$where['cityid']			=	(int)$_GET['cityid'];
			$urlarr['cityid']			=	(int)$_GET['cityid'];
		}
		
		if((int)$_GET['three_cityid']){
			$where['three_cityid']		=	(int)$_GET['three_cityid'];
			$urlarr['three_cityid']		=	(int)$_GET['three_cityid'];
		}
		
		if((int)$_GET['hy']){
			$where['hy']				=	(int)$_GET['hy'];
			$urlarr['hy']				=	(int)$_GET['hy'];
		}
		
		if((int)$_GET['rec']){
			$where['rec']				=	(int)$_GET['rec'];
			$urlarr['rec']				=	(int)$_GET['rec'];
		}
		
		if($_GET['keyword']){
			$where['name']				=	array('like',trim($_GET['keyword']));
			$urlarr['keyword']			=	trim($_GET['keyword']);
		}
		
		$urlarr['c'] 				=	$_GET['c'];
		$urlarr['page']				=	"{{page}}";
		$pageurl					=	Url("train",$urlarr);
		$pageM						=	$this  -> MODEL('page');
		$pages						=	$pageM -> pageList('px_teacher', $where, $pageurl, $_GET['page']);
		
		if($pages['total'] > 0){
			
			$where['orderby']		=	'ctime,desc';
			 
			$where['limit']			=	$pages['limit'];	

			$List					=	$trainM -> getTeaList($where,array('utype'=>'front' , 'uid'=>$this->uid));

			$this->yunset("rows",$List);
		}

        if(isset($List) && is_array($List)){

            if($_GET['keyword']){

                $this->addkeywords("11",$_GET['keyword']);
            }
        }

		$this->right();
        $CacheM=$this->MODEL('cache');
        $CacheList=$CacheM->GetCache(array('hy','city','subject'));
		$this->yunset($CacheList);
		
		/* 关键字显示 */
		include PLUS_PATH."keyword.cache.php";
		if(is_array($keyword)){
			
			  foreach($keyword as $k=>$v){
				  
					if($v['type']=='9'&&$v['tuijian']=='1'){
						
						$subjectkeyword[]	=	$v;
					}
			  }
		}
		$this->yunset("teacherkeyword",$teacherkeyword);
		$this->public_action();
		$this->yunset('def','2');
		$this->seo('teacher');
		$this->train_tpl('teacher');
	}
	
    /* 讲师内容页 */
	function teamshow_action(){
		$trainM		=	$this->MODEL('train');
		
		/* 机构内容页关注培训机构 */
		$this->getAtnTrain((int)$_GET['id']);
      
		$this->reclist((int)$_GET['id']);
		$this->agency((int)$_GET['id']);
		$this->public_action();
		$this->yunset($this->MODEL('cache')->GetCache(array('city','hy','subject')));
		
		if((int)$_GET['nid']){
			$teacher					=		$trainM->getTeaInfo(array('r_status' => 1, 'id'=>(int)$_GET['nid']) );

			if($teacher['id']==''){
				$this->ACT_msg($this->config['sy_weburl'],"没有找到相关讲师！");
			
			}
			$this->yunset("teacher",$teacher);
			
			$data['px_teacher_name']	=		$teacher['name'];
			
			$this->data					=		$data;
			$teachsub					=		$trainM->getSubList(array('r_status'=>1,'status'=>'1','pause_status'=>'1' , 'teachid'=>array('findin',(int)$_GET['nid']) ) ,array( 'uid'=>$this->uid));
			
			$this->yunset("teachsub",$teachsub);
		}
		$this->yunset("def","3");
		$this->seo('teamshow');
		$this->train_tpl('team_show');
	}
	
	function ajaxget_subject_action(){
        $trainM					=	$this->MODEL('train');
		
		$where['r_status']		=	1;
		
		$where['status']		=	'1';
		
		$where['pause_status']	=	'1';
		
		$where['nid']			=	(int)$_POST['id'];
		
		$where['pic']			=	array('<>','');
		
		$where['orderby']		=	'id,desc';
		
		$where['limit']			=	6;
		
		$picsubject				=	$trainM->getSubList($where , array('field'=>"`id`,`pic`,`name`,`price`"));
		
		if(is_array($picsubject)){
			$html   =   '';
			foreach($picsubject as $v){
				
				$url			=	Url('train',array('c'=>'subshow','id'=>$v[id]));
				
				$html			.=	'<dl class="training_new_Courses_top_list ftl mt10"><dt><a href="'.$url.'" title="'.$v[name].'"><img src="'.$this->config[sy_ossurl].'/'.$v[pic].'" width="150" height="100"></a></dt><dd class="training_new_Courses_top_list_name"><a href="'.$url.'" class="training_new_Courses_top_list_name_a" title="'.$v[name].'">'.$v[name].'</a></dd><dd class="training_new_Courses_top_list_Price">￥'.$v[price].'</dd></dl>';
			}
		}
		echo $html;die;
	}
	
	
	/* 关注 */
	function getAtnTrain($id){
		
		if($this->uid	&&	$this->usertype!='4'){	
			$atnM				=		$this->MODEL('atn');
			
			$atwhere['uid']		=		$this->uid;
				
			$atwhere['sc_uid']	=		$id;
			
			$atwhere['sc_usertype']	=	4;
				
			$atwhere['tid']		=		'';
			
			$isatn				=		$atnM->getatnInfo($atwhere , array('field'=>'id'));
			
			$this->yunset("isatn",$isatn);
		}
		
	}
	
	function reclist($id){
		$trainM			=	$this->MODEL('train');
	   
		/* 咨询留言 */
		$zixun			=	$trainM->getPxzxList(array('s_uid'=>$id , 'orderby'=>'id,desc' , 'limit'=>4) ,array('utype'=>'front') );
		
		$this->yunset("zixun",$zixun);

		/* 推荐课程 */
		$nswhere			=		array(
		
			'r_status'		=>	1,
			'status'		=>	1,
			'pause_status'	=>	1,
			'rec'			=>	1,
			'orderby'		=>	'ctime,desc',
			'limit'			=>	3
			
		);
		$reclist		=		$trainM->getSubList($nswhere, array('field' => "`id`,`uid`,`name`,`price`,`pic`" ));
		
		$this->yunset("reclist",$reclist);
	} 
	
	function agency($id){
		if($id){
			$trainM		=	$this->MODEL('train');
           
			$row		=	$trainM->getInfo(array('uid'=>$id));
			
			if($row['r_status']==2){
				$this->ACT_msg($this->config['sy_weburl'],"该机构已被锁定！");
			}elseif($row['uid']==''){
				$this->ACT_msg($this->config['sy_weburl'],"没有找到该机构！");
			}
			
			/* content里会有html标签没有闭合影响到页面显示和查看更多功能，用closetages补全闭合标签 */
			$row['logo']			=	$row['logo_n'];
			$row['shortcontent']	=	$this->CloseTags(mb_substr($row['content'],0,600,'utf-8'));
			$row['content']			=	$this->CloseTags($row['content']);
			$data['px_agency_name']	=	$row['name'];
			$this->data				=	$data;
			
			$banner					=	$trainM		->	getBannerInfo(array('uid'=>$id),array('pic'=>1));
			
			$this->yunset("banner",$banner);
			$this->yunset("row",$row);
			
		}
        $CacheM		=	$this->MODEL('cache');
        $CacheList	=	$CacheM->GetCache(array('com','city','subject'));
		$this->yunset($CacheList);
	}
	
	function right(){
        $trainM				=		$this->MODEL('train');
		
		//推荐机构
		$rtwhere			=		array(
		
			'r_status'		=>	1,
			'name'			=>	array('<>', ''),
			'rec'			=>	1,
			'orderby'		=>	'uid,desc',
			'limit'			=>	4
			
		);
		
		if($this->config['did']){
			
			$rtwhere['did']		=		$this->config['did'];
			
		}
		$rectrain				=		$trainM->getList($rtwhere , array('field'=>'`uid`,`name`,`logo`,`logo_status`,`content`,`sid`' , 'utype'=>'front' , 'num'=>1));
		
		$this->yunset("rectrain",$rectrain);
		
		
		//最新课程
		$nswhere			=		array(
		
			'r_status'		=>	1,
			'status'		=>	1,
			'pause_status'	=>	1,
			'rec'			=>	1,
			'orderby'		=>	'ctime,desc',
			'limit'			=>	3
			
		);
		
		if($this->config['did']){
			
			$nswhere['did']		=		$this->config['did'];
			
		}
		$reclist				=		$trainM->getSubList($nswhere, array('field' => "`id`,`uid`,`name`,`price`,`pic`" , 'utype'=>'front' , 'num'=>1));
		
		$this->yunset('reclist',$reclist);
	}

}
?>