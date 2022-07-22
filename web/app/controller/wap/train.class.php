<?php
/* *
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
*/
class train_controller extends common{
	/* 培训首页 */
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

		foreach($_GET as $k=>$v){
			if($k!=""){
				$searchurl[]=$k."=".$v;
			}
		}
		$this->yunset('backurl',Url('wap'));
		$searchurl=@implode("&",$searchurl);
		$this->yunset("searchurl",$searchurl);
		$this->yunset("headertitle","职业培训");
		$this->seo("train_index");
		$this->yuntpl(array('wap/train'));
	}
	
	/* 培训课程列表页 */
	function subject_action(){	
		$trainM				=		$this->MODEL('train');
		$CacheM				=		$this->MODEL('cache');
		
		$where['r_status']				=		1;
					
		$where['status']				=		'1';
					
		$where['pause_status']			=		'1';
					
		if((int)$_GET['type']){		
						
			$where['type']				=		(int)$_GET['type'];
						
			$urlarr['type']				=		(int)$_GET['type'];
		}			
					
		if($_GET['keyword']){			
						
			$where['name']				=		 array('like', trim($_GET['keyword']));
						
			$urlarr['keyword']			=		(int)$_GET['keyword'];
		}			
					
		if((int)$_GET['nid']){	
						
			$where['nid']				=		(int)$_GET['nid'];
						
			$urlarr['nid']				=		(int)$_GET['nid'];
		}	
			
		$urlarr['c'] 					=		$_GET['c'];
		$urlarr['page']					=		"{{page}}";
		$urlarr['a']					=		"subject";
		$pageurl						=		Url("wap",$urlarr);
		/* 提取分页	 */
		$pageM							=		$this  -> MODEL('page');
		$pages							=		$pageM -> pageList('px_subject', $where, $pageurl, $_GET['page']);
			
		if($pages['total'] > 0){	
				
			$where['orderby']			=		'ctime,desc';
				
			$where['limit']				=		$pages['limit'];		
			$List						=		$trainM -> getSubList($where,array('utype'=>'front','num'=>1));
			
			$this->yunset("newsubject",$List);
		}
		
		
		$this->yunset("topplaceholder","搜索课程");
		foreach($_GET as $k=>$v){
			if($k!=""){
				$searchurl[]=$k."=".$v;
			}
		}
		$searchurl	=	@implode("&",$searchurl);
		$CacheList	=	$CacheM->GetCache(array('subject','subjecttype'));
		$this->yunset($CacheList);
		$this->yunset("searchurl",$searchurl);
		$this->yunset('backurl',Url('wap',array('c'=>'train')));
		$this->seo("train_index");
		$this->yuntpl(array('wap/pxsubject'));
	}
	
	/* 培训课程内容页 */
	function subshow_action(){
		if((int)$_GET['id']){
            $trainM		=	$this->MODEL('train');
            $resumeM	=	$this->MODEL('resume');
			$CompanyM	=	$this->MODEL("company");
			$CacheM		=	$this->MODEL('cache');
			$lietouM	=	$this->MODEL('lietou');
			
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
				
				$data['msg']	=	'没有找到该课程！';
				
				$data['url']	=	'index.php';
				
				$this->layer_msg($data['msg'],9,0,$data['url'],2);
				
			}elseif($row['r_status']==2){
				
				$data['msg']	=	'发布该课的机构已被锁定！';
				
				$data['url']	=	'index.php';
				
				$this->layer_msg($data['msg'],9,0,$data['url'],2);
				
			}else{
				
				$trainM->upSubInfo(array('id'=>(int)$_GET['id']),array('hits'=>array('+',1)));

			    $this->yunset("row",$row);
				
				 /* 收藏数目 */
			    $collect_num	=	$trainM->getSubCollectNum(array('sid'=>$row['id']));
			    $this->yunset("collect_num",$collect_num);
				
				/* 培训机构信息 */
				$traininfo		=	$trainM->getInfo(array('r_status'=>1 , 'uid'=>$row['uid']));
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
			$data['px_subject_name']	=	$row['name'];
			$this->data					=	$data;
		}
		
		$CacheList		=	$CacheM->GetCache(array('city','subject','com'));
		$this->reclist($row['uid']);
		$this->yunset($CacheList);
		$this->yunset("headertitle","课程详情");
		$this->seo("subject_show");
		$this->yuntpl(array('wap/pxsubshow'));
	}
	
	/* 培训机构列表页*/
	function agency_action(){
		$trainM						=	$this->MODEL('train');
		$CacheM						=	$this->MODEL('cache');
		
		$where['r_status']			=	1;
		
		$where['name']				=	array('<>', '');
		
		$where['sid']				=	array('<>', '');
		
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
		
		if($_GET['keyword']){
			$where['name']			=	array('like' , trim($_GET['keyword']));		
		}
		
		$urlarr['c'] 				=	"train";
		$urlarr['a']				=	$_GET['a'];
		$urlarr['page']				=	"{{page}}";
		$pageurl					=	Url("wap",$urlarr);
		$pageM						=	$this  -> MODEL('page');
		$pages						=	$pageM -> pageList('px_train', $where, $pageurl, $_GET['page']);
		
		if($pages['total'] > 0){
			
			$where['orderby']		=	array('rec,desc','uid,desc');
			 
			$where['limit']			=	$pages['limit'];	
			
			$List					=	$trainM -> getList($where,array('utype'=>'wap'));
			
			$this->yunset("rows",$List);
		}
		
		if(isset($List) && is_array($List)){
			if($_GET['keyword']){
				$this->addkeywords("10",$_GET['keyword']);
			}
		}
		
		foreach($_GET as $k=>$v){
			if($k!=""){
				$searchurl[]		=	$k."=".$v;
			}
		}
		$searchurl					=	@implode("&",$searchurl);
		
        $CacheList					=	$CacheM->GetCache(array('com','city','subject'));
		
		$this->yunset($CacheList);
		$this->yunset("searchurl",$searchurl);
		$this->yunset("topplaceholder","搜索培训机构");
		$this->yunset('backurl',Url('wap',array('c'=>'train')));
		$this->seo("agency");
		$this->yuntpl(array('wap/pxagency'));
	}
	
	/* 培训机构内容页 */
	function agencyshow_action(){
		$trainM							=		$this->MODEL('train');
			
		$id								=		(int)$_GET['id'];		
		
		/* 机构内容页关注培训机构 */
		$this->getAtnTrain((int)$_GET['id']);
		
		$show							=		$trainM->getPxshowList(array('uid'=>$id));
		$this->yunset("show",$show);
		
		/* 课程 */
		$swhere							=		array(
				
			'r_status'					=>		1,
			'status'					=>		1,
			'pause_status'				=>		1,
			'uid'						=>		$id,
			'orderby'					=>		'ctime,desc',
			'limit'						=>		6
					
		);		
		$sublist						=		$trainM->getSubList($swhere, array('field' => "`id`,`uid`,`name`,`price`,`pic`,`hours`,`ctime`" , 'utype'=>'front','num'=>1 ,'uid'=>$this->uid));
		
		$this->yunset('sublist',$sublist);
		
		/* 讲师 */
		$twhere							=		array(
					
			'r_status'					=>		1,
			'uid'						=>		$id,
			'status'					=>		1,
			'orderby'					=>		'ctime,desc',
			'limit'						=>		10
			
		);
		
		if($this->config['did']){
			
			$twhere['did']				=		$this->config['did'];
					
		}		
		$teacher						=		$trainM->getTeaList($twhere,array('field'=>'`id`,`uid`,`name`,`pic`,`sid`,`hy`,`cityid`'));
				
		
		
		$this->agency($id);
		$this->reclist($id);
		$this->yunset('teach',$teacher);
		$this->yunset("headertitle","机构详情");
		$this->seo("agency_show");
		$this->yuntpl(array('wap/pxagencyshow'));
	}

	/* 培训师 */
	function teacher_action(){
		$trainM							=		$this->MODEL('train');
		$CacheM							=		$this->MODEL('cache');
			
		$where['r_status']				=		1;
				
		$where['status']				=		'1';
			
		if((int)$_GET['sid']){		
			$where['sid']				=		(int)$_GET['sid'];
			$urlarr['sid']				=		(int)$_GET['sid'];
		}	
			
		if((int)$_GET['provinceid']){	
			$where['provinceid']		=		(int)$_GET['provinceid'];
			$urlarr['provinceid']		=		(int)$_GET['provinceid'];
		}		
				
		if((int)$_GET['cityid']){		
			$where['cityid']			=		(int)$_GET['cityid'];
			$urlarr['cityid']			=		(int)$_GET['cityid'];
		}	
			
		if((int)$_GET['three_cityid']){	
			$where['three_cityid']		=		(int)$_GET['three_cityid'];
			$urlarr['three_cityid']		=		(int)$_GET['three_cityid'];
		}	
			
		if((int)$_GET['hy']){
			$where['hy']				=		(int)$_GET['hy'];
			$urlarr['hy']				=		(int)$_GET['hy'];
		}	
			
		if($_GET['keyword']){	
			$where['name']				=		array('like',trim($_GET['keyword']));
			$urlarr['keyword']			=		trim($_GET['keyword']);
		}	
	
		$urlarr['c'] 					=		$_GET['c'];
		$urlarr['a']					=		$_GET['a'];
		$urlarr['page']					=		"{{page}}";
		$pageurl						=		Url("wap",$urlarr);
		$pageM							=		$this  -> MODEL('page');
		$pages							=		$pageM -> pageList('px_teacher', $where, $pageurl, $_GET['page']);
		
		if($pages['total'] > 0){
			
			$where['orderby']			=		'ctime,desc';
					
			$where['limit']				=		$pages['limit'];	
			
			$List						=		$trainM -> getTeaList($where,array('utype'=>'front' , 'uid'=>$this->uid));
			
			$this->yunset("rows",$List);
		}

		foreach($_GET as $k=>$v){
			if($k!=""){
				$searchurl[]			=		$k."=".$v;
			}
		}
		$searchurl						=		pylode("&",$searchurl);
		
        $CacheList						=		$CacheM->GetCache(array('hy','city','subject'));
		
		$this->yunset($CacheList);
		$this->yunset("topplaceholder","搜索讲师");
		$this->yunset("searchurl",$searchurl);
		$this->yunset('backurl',Url('wap',array('c'=>'train')));
		$this->seo('teacher');
		$this->yuntpl(array('wap/pxteacher'));
	}
	
	 /* 讲师内容页 */
	function teamshow_action(){
		$trainM							=		$this->MODEL('train');
		$CacheM							=		$this->MODEL('cache');
		
		if((int)$_GET['nid']){
			$teacher					=		$trainM->getTeaInfo(array('r_status'=>1 , 'id'=>(int)$_GET['nid']), array('uid'=>$this->uid) );
			
			if($teacher['id']==''){
				$this->ACT_msg_wap($this->config['sy_weburl'],"没有找到相关讲师！",2,5);
			}
			
			$this->yunset("teacher",$teacher);
			
			$data['px_teacher_name']	=		$teacher['name'];
			
			$this->data					=		$data;
			$teachsub					=		$trainM->getSubList(array('r_status'=>1 ,'status'=>'1','pause_status'=>'1' , 'teachid'=>array('findin',(int)$_GET['nid']) ) ,array( 'uid'=>$this->uid));
			
			$this->yunset("teachsub",$teachsub);
		}
		
		$CacheList						=		$CacheM->GetCache(array('hy','city','subject'));
		
		$this->yunset($CacheList);
		$this->yunset("headertitle","讲师详情");
		$this->seo('teamshow');
		$this->yuntpl(array('wap/pxteachershow'));
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
			
			$data['utype']		=		'wap';
			
			$return				=		$orderM->addBaomingOrder($data);
			
			$this->layer_msg($return['msg'],9,0,$return['url'],2);
           
		}
	}
	
	/* 收藏培训课程 */
	function collect_action(){
		if($_POST['id']){
			$trainM	=	$this->MODEL('train');
		
			$data['uid']		=	$this->uid;
			$data['usertype']	=	$this->usertype;
			$data['id']			=	$_POST['id'];
			
			$return	=	$trainM	-> collectSub($data);	
			
			echo $return ;die;
			
		}
	}
	
	function zixun_action(){
		$trainM		=	$this->MODEL('train');
		
		if($_POST['submit']){
			if(!$this->uid){
				
				$data['msg']	=	"您还没有登录，请先登录！";
				
			}
			
			if($this->usertype==4){
				
				$data['msg']	=	"只有个人和hr可以收藏！";
				
			}
			
			if($_POST['phone']==''){
				
				$data['msg']	=	"联系电话不能为空！";
				
			}elseif(!CheckMobile($_POST['phone'])){
				
				$data['msg']	=	"请正确填写联系电话！";
			}
			
			if(!empty($data)){
				
				$this->layer_msg($data['msg'],9,0,$_SERVER['HTTP_REFERER'],2);
				
			}
			
			$trainM->addPxzixun(array('uid'=>$this->uid,'sid'=>$_POST['sid'],'s_uid'=>$_POST['s_uid'],'phone'=>$_POST['phone'],'content'=>$_POST['content'],'ctime'=>time(),'did'=>$this->userdid,'usertype'=>$this->usertype));
			
			$data['msg']		=	"咨询成功！";
			$data['url']		=	$_SERVER['HTTP_REFERER'];
			$this->layer_msg($data['msg'],9,0,$data['url'],2);
		}
		
		$id						=		(int)$_GET['id'];
		
		$where['s_uid']			=		$id;
				
		$urlarr['id']			=		$_GET['id'];
		$urlarr['c'] 			=		$_GET['c'];
		$urlarr['a']			=		$_GET['a'];
		$urlarr['page']			=		"{{page}}";
		$pageurl				=		Url("wap",$urlarr);
		$pageM					=		$this  -> MODEL('page');
		$pages					=		$pageM -> pageList('px_zixun', $where, $pageurl, $_GET['page']);
		
		if($pages['total'] > 0){	
				
			$where['orderby']	=		'ctime,desc';
				
			$where['limit']		=		$pages['limit'];	
				
			$List				=		$trainM -> getPxzxList($where,array('utype'=>'front'));
			
			$this->yunset("rows",$List);
		}
		
		$this->yunset("headertitle","留言咨询");
		$this->agency($id);
		$this->seo('zixun');
		$this->yuntpl(array('wap/pxzixun'));
	}
	
	function agency($id){
		
		if($id){
			$trainM		=	$this->MODEL('train');
			$row		=	$trainM->getInfo(array('uid'=>$id));
			if($row['r_status']==2){
				
				$data['msg']		=	"该机构已被锁定！";
				$data['url']		=	'index.php?c=index&a=agency';
				
			}elseif($row['uid']==''){
				
				$data['msg']		=	"没有找到该机构！";
				$data['url']		=	'index.php?c=index&a=agency';
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
        $CacheList	=	$CacheM->GetCache(array('com','city','subject','hy'));
		$this->yunset($CacheList);
	}
	
	function reclist($id){
		$trainM			=	$this->MODEL('train');
		
		$zixun			=	$trainM->getPxzxList(array('s_uid'=>$id , 'orderby'=>'id,desc' , 'limit'=>4) ,array('utype'=>'front') );
		
		$this->yunset("zixun",$zixun);		
	}
	
	/* 机构内容页关注培训机构 */
	function getAtnTrain($id){
		
		if($this->uid	&&	$this->usertype!='4'){	
			$atnM				=		$this->MODEL('atn');
			
			$atwhere['uid']		=		$this->uid;
				
			$atwhere['sc_uid']	=		$id;
				
			$atwhere['tid']		=		'';
			
			$isatn				=		$atnM->getatnInfo($atwhere , array('field'=>'id'));
			
			$this->yunset("isatn",$isatn);
		}
		
	}

	
}
?>