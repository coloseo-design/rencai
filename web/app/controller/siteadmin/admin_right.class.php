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
class admin_right_controller extends siteadmin_controller
{
	function index_action(){
		global $db_config;
		$this->yunset("db_config",$db_config);

		include(APP_PATH.'version.php');
		$this->yunset("version",$version);
		
		$base		=	base64_encode($db_config["coding"]."|phpyun|".$this->config["sy_webname"]."|phpyun|".$this->config["sy_weburl"]."|phpyun|".$this->config["sy_webemail"]."|phpyun|".$version);
		$this->yunset("base",$base);
		
		$soft		=	$_SERVER['SERVER_SOFTWARE'];
		$this->yunset("soft",$soft);
		
		$kongjian	=	round(@disk_free_space(".")/(1024*1024),2);
		$this->yunset("kongjian",$kongjian);
		
		$banben		=	$this->db->mysql_server(1);
		$this->yunset("banben",$banben);
		
		$yonghu		=	@get_current_user();
		$this->yunset("yonghu",$yonghu);
		
		$server		=	$_SERVER['SERVER_NAME'];
		$this->yunset("server",$server);
		
		if(is_dir("../admin"))$dirname[]="admin";
		if(is_dir("../install"))$dirname[]="install";
		$this->yunset("dirname",@implode(',',$dirname));
		
		$adminM		=     $this -> MODEL('admin');
        
        $nav_user	=     $adminM -> getPower(array('uid'=>$_SESSION['auid']));
        
        $mruser    =  $nav_user['username'] == 'admin' && $nav_user['password'] == $adminM->makePass('admin') ? 1 : 0;

        $this -> yunset('mruser', $mruser);
		
		$this->siteadmin_tpl(array('admin_right'));
	}
	// 后台首页：会员统计信息：今日新增会员总数、新增个人会员数、新增简历、新增企业、新增职位、
    // 待审核个人会员、企业、职位、简历、猎头
    // 后台首页：收益统计：总收益、
    function ajax_statis_action(){

        $UserinfoM	=	$this->MODEL('userinfo');  
        $ResumeM	=	$this->MODEL('resume');
        $ArticleM	=	$this->MODEL('article');
        $OnceM		=	$this->MODEL('once');
        $JobM		=	$this->MODEL('job');
        $CompanyM	=	$this->MODEL('company');
        $CorderM	=	$this->MODEL('companyorder');
        $AdM		=	$this->MODEL('ad');
        $TinyM		=	$this->MODEL('tiny');
        
        $today	=	strtotime('today');
        $month	=	strtotime(date("Y-m-d", strtotime("-30 day")));
        
        // 今日新增会员数
        $where['reg_date']      =	array(">=",$today);
        $memberNum              =	$UserinfoM->getMemberNum($where);
        
        $userwhere['reg_date']	=	array(">=",$today);
        $userwhere['usertype']	=	1;
        // 新增个人会员数
        $userNum				=	$UserinfoM->getMemberNum($userwhere);
        
        // 新增企业会员数
        $comwhere['reg_date']	=	array(">=",$today);
        $comwhere['usertype']	=	2;
        $companyNum				=	$UserinfoM->getMemberNum($comwhere);
        
        $expectwhere['ctime']	=	array(">=",$today);
        $resumeNum				=	$ResumeM->getExpectNum($expectwhere);

        $jobwhere['sdate']	=	array(">=",$today);
        $jobNum				=	$JobM->getJobNum($jobwhere);
        
        $checkwhere['status']	=	0;
        $checkwhere['usertype']	=	1;
        $checkUserNum			=	$UserinfoM->getMemberNum($checkwhere);
       
        $cmwhere['status']		=	0;
        $cmwhere['usertype']	=	2;
        $com					=	$UserinfoM->getList($comwhere,array('field'=>'`uid`'));

        foreach ($com as $val) {

            $comuids[] = $val['uid'];
        }
        $cwhere['uid']			=	array('in',pylode(',',$comuids));
        $checkCompanyNum        =	$CompanyM->getCompanyNum($cwhere);
        // *Company End*//
        $orderwhere['order_state']  =	3;
        $checkOrderNum              =	$CorderM->getCompanyOrderNum($orderwhere);

        $ordertime					=	strtotime('-' . intval(7) . ' day');
        $corderwhere['order_state']	=	1;
        $corderwhere['order_time']	=	array('>',$ordertime);
        $checkPayNum				=	$CorderM->getCompanyOrderNum($corderwhere);
        
        $rewhere['r_status']	=	1;
        $checkResumeNum			=	$ResumeM->getExpectNum($rewhere);

        $jnumwhere['state']		=	0;
        $checkJobNum			=	$JobM->getJobNum($jnumwhere);
               
        // 总收益
        $owhere['order_state']	=	2;
        $owhere['order_time']	=	array('>=',$today);

        $moneyTotal	=	$CorderM->getInfo($owhere,array('field'=>'sum(order_price) as `total`'));
        $moneyTotal	=	$moneyTotal['total'];
        // 增值套餐 收益
        $vwhere['order_state']	=	2;
        $vwhere['order_time']	=	array('>=',$today);
        $vwhere['type']			=	1;

        $moneyVip	=	$CorderM->getInfo($vwhere,array('field'=>'sum(order_price) as `total`'));
        $moneyVip	=	$moneyVip['total'];
       
        // 积分充值 收益
        $Iwhere['order_state']	=	2;
        $Iwhere['order_time']	=	array('>=',$today);
        $Iwhere['type']			=	2;
        $moneyIntegral	=	$CorderM->getInfo($Iwhere,array('field'=>'sum(order_price) as `total`'));
        $moneyIntegral	=	$moneyIntegral['total'];
        
        // 增值服务 收益
        $swhere['order_state']	=	2;
        $swhere['order_time']	=	array('>=',$today);
        $swhere['type']			=	5;

        $moneyService	=	$CorderM->getInfo($swhere,array('field'=>'sum(order_price) as `total`'));
        $moneyService	=	$moneyService['total'];
        
        // 职位推广、赏金悬赏 收益
        $jwhere['order_state']		=	2;
        $jwhere['order_time']		=	array('>=',$today);
        $jwhere['PHPYUNBTWSTART_A']	=	'';
        $jwhere['type']				=	array("=",8,'OR');
        $jwhere['type']				=	array("=",9,'OR');
        $jwhere['PHPYUNBTWEND_A']	=	'';
        $moneyJob	=	$CorderM->getInfo($jwhere,array('field'=>'sum(order_price) as `total`'));
        $moneyJob	=	$moneyJob['total'];

        $mrewhere['ctime']	=	array('>=',$month); 
        $resumeNumMon		=	$ResumeM->getExpectNum($mrewhere);
        
        $mjobwhere['sdate']	=	array('>=',$month);
        $jobNumMon			=	$JobM->getJobNum($mjobwhere);
        
        $mcomwhere['usertype']	=	2;
        $mcomwhere['reg_date']	=	array('>=',$month);
        $companyNumMon			=	$UserinfoM->getMemberNum($mcomwhere);

        $muserwhere['usertype']	=	1;
        $muserwhere['reg_date']	=	array('>=',$month);
        $userNumMon				=	$UserinfoM->getMemberNum($muserwhere);

        $mnewwhere['datetime']	=	array('>=',$month);
        $newsNumMon				=	$ArticleM->getNum($mnewwhere);   

        $madwhere['addtime']	=	array('>=',$month);
        $ggNumMon				=	$AdM->getAdClickNum($madwhere);

        $moncewhere['ctime']	=	array('>=',$month);
        $onceNumMon				=	$OnceM->getOnceNum($moncewhere);

        $mtiwhere['time']	=	array('>=',$month);
        $tinyNumMon			=	$TinyM->getResumeTinyNum($mtiwhere);
        
        echo json_encode(array(
            'memberNum'			=>	$memberNum,
            'userNum'			=>	$userNum,
            'companyNum'		=>	$companyNum,
            'resumeNum'			=>	$resumeNum,
            'jobNum'			=>	$jobNum,
            'checkUserNum'		=>	$checkUserNum,
            'checkCompanyNum'	=>	$checkCompanyNum,
            'checkOrderNum'		=>	$checkOrderNum,
            'checkPayNum'		=>	$checkPayNum,
            'checkResumeNum'	=>	$checkResumeNum,
            'checkJobNum'		=>	$checkJobNum,
            'moneyTotal'		=>	$moneyTotal,
            'moneyVip'			=>	$moneyVip,
            'moneyIntegral'		=>	$moneyIntegral,
            'moneyService'		=>	$moneyService,
            'moneyJob'			=>	$moneyJob,
            'resumeNumMon'		=>	$resumeNumMon,
            'jobNumMon'			=>	$jobNumMon,
            'companyNumMon'		=>	$companyNumMon,
            'userNumMon'		=>	$userNumMon,
            'newsNumMon'		=>	$newsNumMon,
            'ggNumMon'			=>	$ggNumMon,
            'onceNumMon'		=>	$onceNumMon,
            'tinyNumMon'		=>	$tinyNumMon
        ));
        exit();
    }
	function tjl($tablename1,$tablename2, $field = array(), $name = array(), $data=array()){

        $TongjiM	=	$this->MODEL('tongji');
        $TimeDate	=	$this->day();
        $sdate		=	$TimeDate['sdate'];
        $edate		=	$TimeDate['edate'];
        $days		=	$TimeDate['days'];
		
        if ($field[0]) {

            $where['usertype']	=	$data['type'];
            $where[$field[0]][]	=	array(">=",strtotime($sdate));
            $where[$field[0]][]	=	array("<=",strtotime($edate . ' 23:59:59'));
            $where['groupby']	=	'td';
            $where['orderby']	=	array('td,desc');          

            $RegStats	=	$TongjiM->tjtotal($tablename1,$where,array('field'=>'FROM_UNIXTIME('.$field[0].',"%Y%m%d") as td,count(*) as cnt'));
           
            if (is_array($RegStats)) {

                $AllNum	=	0;

                foreach ($RegStats as $key => $value) {

                    $AllNum				+=	$value['cnt'];
                    $Date[$value['td']]	=	$value;
                }
                if ($days > 0) {

                    for ($i = 0; $i <= $days; $i ++) {
						
                        $onday	=	date("Ymd", strtotime(' -' . $i . 'day'));
                        $td		=	date('m-d', strtotime(' -' . $i . 'day'));
                        $date	=	date('Y-m-d', strtotime(' -' . $i . 'day'));
						
                        if (! empty($Date[$onday])) {

                            $Date[$onday]['td']		=	$td;
                            $Date[$onday]['date']	=	$date;
                            $List[$onday]			=	$Date[$onday];
							
                        } else {
                            $List[$onday]			=	array('td' => $td,'cnt' => 0,'date' => $date);
                        }
                    }
                }
            }
            ksort($List);
        }
        if ($field[1]) {

            $loginWhere['usertype']		=	$data['type'];
            $loginWhere[$field[1]][]	=	array(">=",strtotime($sdate));
            $loginWhere[$field[1]][]	=	array("<=",strtotime($edate . ' 23:59:59'));
            $loginWhere['groupby']		=	'td';
            $loginWhere['orderby']		=	array('td,desc'); 
			
            $loginStats	=	$TongjiM->tjtotal($tablename2,$loginWhere,array('field'=>'FROM_UNIXTIME('.$field[1].',"%Y%m%d") as td,count(*) as cnt'));

            if (is_array($loginStats)) {

                $twoNum	=	0;
                foreach ($loginStats as $key => $val) {

                    $twoNum					+=	$val['cnt'];
                    $twodate[$val['td']]	=	$val;
                }
                if ($days > 0) {
                    for ($j = 0; $j <= $days; $j ++) {

                        $onday	=	date("Ymd", strtotime(' -' . $j . 'day'));
                        $td		=	date('m-d', strtotime(' -' . $j . 'day'));
                        $date	=	date('Y-m-d', strtotime(' -' . $j . 'day'));

                        if (! empty($twodate[$onday])) {

                            $twodate[$onday]['td']		=	$td;
                            $twodate[$onday]['date']	=	$date;
                            $twolist[$onday]			=	$twodate[$onday];
                        } else {
                            $twolist[$onday]			=	array('td' => $td,'cnt' => 0,'date' => $date );
                        }
                    }
                }
            }
            ksort($twolist);
        }
        $this->yunset('twolist', $twolist);
        $this->yunset('list', $List);
        $this->yunset('name', $name);
        $this->yunset('type', "tj");

        $this->siteadmin_tpl(array('admin_right_web'));
    }
	function getweb_action(){
		$this->tjl("member","login_log", array('reg_date','ctime'), array('个人注册','个人登录'), array('type'=>1));
	}
	function comtj_action(){
		$this->tjl("member","login_log", array('reg_date','ctime'), array('企业注册','企业登录'), array('type'=>2));
	}
	function resumetj_action(){
		 $this->tj("resume_expect", array('ctime','lastupdate'), array('简历新增','简历刷新'));
	}
	function newstj_action(){
		$this->tj("news_base", array('datetime'), array('新闻新增'));
	}
	function adtj_action(){
		$this->tj("adclick", array('addtime'), array('广告点击统计'));
	}
	function jobtj_action(){
		$this->tj("company_job", array('sdate','lastupdate'), array('职位新增','职位刷新'));
	}
	function wzptj_action(){
		$this->tj("once_job", array('ctime','sxtime'), array('店铺招聘新增','店铺招聘刷新'));
	}
	function wjltj_action(){
		$this->tj("resume_tiny", array('time','lastupdate'), array('普工简历新增','普工简历刷新'));
	}
	function payordertj_action(){
		$this->tj("company_order", array('order_time'), array('充值统计'));
	}
	function tj($tablename, $field = array(), $name = array(), $where = ''){
        
        $TongjiM	=	$this->MODEL('tongji');

        $TimeDate	=	$this->day();
        $sdate		=	$TimeDate['sdate'];
        $edate		=	$TimeDate['edate'];
        $days		=	$TimeDate['days'];
		
        if ($field[0]) {

            $RegWhere[$field[0]][]	=	array(">=",strtotime($sdate));
            $RegWhere[$field[0]][]	=	array("<=",strtotime($edate . ' 23:59:59'));
            $RegWhere['groupby']	=	'td';
            $RegWhere['orderby']	=	array('td,desc');  
         
            $RegStats	=	$TongjiM->tjtotal($tablename,$RegWhere,array('field'=>'FROM_UNIXTIME('.$field[0].',"%Y%m%d") as td,count(*) as cnt'));
          
            if (is_array($RegStats)) {
                $AllNum                        =        0;
                foreach ($RegStats as $key => $value) {

                    $AllNum				+=	$value['cnt'];
                    $Date[$value['td']]	=	$value;
                }
                if ($days > 0) {
                    for ($i = 0; $i <= $days; $i ++) {

                        $onday	=	date("Ymd", strtotime(' -' . $i . 'day'));
                        $td		=	date('m-d', strtotime(' -' . $i . 'day'));
                        $date	=	date('Y-m-d', strtotime(' -' . $i . 'day'));
						
                        if (! empty($Date[$onday])) {
							
                            $Date[$onday]['td']         =       $td;
                            $Date[$onday]['date']       =       $date;
                            $List[$onday]               =       $Date[$onday];
							
                        } else {
                            $List[$onday] = array('td' => $td,'cnt' => 0,'date' => $date);
                        }
                    }
                }
            }
            ksort($List);
        }
        if ($field[1]) {

            $loginWhere[$field[1]][]	=	array(">=",strtotime($sdate));
            $loginWhere[$field[1]][]	=	array("<=",strtotime($edate . ' 23:59:59'));
            $loginWhere['groupby']		=	'td';
            $loginWhere['orderby']		=	array('td,desc');  

            $loginStats	=	$TongjiM->tjtotal($tablename,$loginWhere,array('field'=>'FROM_UNIXTIME('.$field[1].',"%Y%m%d") as td,count(*) as cnt'));

            if (is_array($loginStats)) {
                $twoNum 	= 	0;
                foreach ($loginStats as $key => $val) {

                    $twoNum					+=	$val['cnt'];
                    $twodate[$val['td']]	=	$val;
                }
                if ($days > 0) {
                    for ($j = 0; $j <= $days; $j ++) {

                        $onday	=	date("Ymd", strtotime(' -' . $j . 'day'));
                        $td		=	date('m-d', strtotime(' -' . $j . 'day'));
                        $date	=	date('Y-m-d', strtotime(' -' . $j . 'day'));

                        if (! empty($twodate[$onday])) {

                            $twodate[$onday]['td']		=	$td;
                            $twodate[$onday]['date']	=	$date;
                            $twolist[$onday]			=	$twodate[$onday];

                        } else {
                            $twolist[$onday] 			= 	array('td' => $td,'cnt' => 0, 'date' => $date);
                        }
                    }
                }
            }
            ksort($twolist);
        }
        $this->yunset('twolist', $twolist);
        $this->yunset('list', $List);
        $this->yunset('name', $name);
        $this->yunset('type', "tj");

        $this->siteadmin_tpl(array('admin_right_web'));
    }
	
	//网站动态	
	function downresumedt_action(){
        
        $where['orderby']	=	array('downtime,desc');
        $this->dt("down_resume", "downtime", "下载简历动态",$where);
    }
    function lookjobdt_action(){

        $where['orderby']	=	array('datetime,desc');
        $this->dt("look_job", "datetime", "职位浏览动态", $where);
    }
    function lookresumedt_action(){

        $where['orderby']	=	array('datetime,desc');
        $this->dt("look_resume", "datetime", "简历浏览动态",$where);
    }
    function useridjobdt_action(){

        $where['orderby']	=	array('datetime,desc');
        $this->dt("userid_job", "datetime", "职位申请动态",$where);
    }
    function favjobdt_action(){
		
        $where['orderby']	=	array('datetime,desc');
        $this->dt("fav_job", "datetime", "职位收藏动态", $where);
    }
    function payorderdt_action(){
		
        $where['orderby']	=	array('order_time,desc');
        $this->dt("company_order", "order_time", "充值动态", $where);
    }
	function dt($tablename, $field, $name, $where=array()){

        $UserinfoM		=	$this->MODEL('userinfo');  
        $TongjiM		=	$this->MODEL('tongji');
        $JobM			=	$this->MODEL('job');
        $ResumeM		=	$this->MODEL('resume');
        
        $where['limit']	=	'21';
        
        $List			=	$TongjiM->tjtotal($tablename,$where);

        if (is_array($List)) {
            foreach ($List as $v) {

                $uid[]		=	$v['uid'];
                $comid[]	=	$v['comid'];
                $com_id[]	=	$v['com_id'];
                $jobid[]	=	$v['jobid'];
            }
            $comidwhere['uid']	=	array('in',pylode(',',$comid));
            $member				=	$UserinfoM->getList($comidwhere);

            $uidwhere['uid']	=	array('in',pylode(',',$uid));
            $member2			=	$UserinfoM->getList($uidwhere);

            $com_idwhere['uid']	=	array('in',pylode(',',$com_id));
            $member3			=	$UserinfoM->getList($com_idwhere);

            $resumewhere['uid']	=	array('in',pylode(',',$uid));
            $resume				=	$ResumeM->getResumeList($resumewhere);

            $jobwhere['id']		=	array('in',pylode(',',$jobid));
            $jobA				=	$JobM->getList($jobwhere);
            $job				=	$jobA['list'];
         
            foreach ($List as $k => $v) {

                foreach ($resume as $val) {

                    if ($v['uid'] == $val['uid']) {

                        $List[$k]['username']		=	$val['name'];
                    }
                }
                foreach ($job as $val) {

                    if ($v['jobid'] == $val['id']) {

                        $List[$k]['jobname']		=	$val['name'];
                    }
                }
                foreach ($member as $val) {

                    if ($v['comid'] == $val['uid']) {

                        $List[$k]['comusername']	=	$val['username'];
                    }
                }
                foreach ($member2 as $val) {

                    if ($v['uid'] == $val['uid']) {

                        $List[$k]['username']		=	$val['username'];
                    }
                }
                foreach ($member3 as $val) {

                    if ($v['com_id'] == $val['uid']) {

                        $List[$k]['comusername']	=	$val['username'];
                    }
                }
                $time	=	time() - $v['downtime'];

                if ($time > 86400 && $time < 604800) {

                    $List[$k]['time']	=	ceil($time / 86400) . "天前";

                } elseif ($time > 3600 && $time < 86400) {

                    $List[$k]['time']	=	ceil($time / 3600) . "小时前";

                } elseif ($time > 60 && $time < 3600) {

                    $List[$k]['time']	=	ceil($time / 60) . "分钟前";

                } elseif ($time < 60) {

                    $List[$k]['time']	=	"刚刚";
                } else {
                    $List[$k]['time']	=	date("Y-m-d", $v['downtime']);
                }
                $times	=	time() - $v['datetime'];

                if ($times > 86400 && $times < 604800) {

                    $List[$k]['times']	=	ceil($times / 86400) . "天前";

                } elseif ($times > 3600 && $times < 86400) {

                    $List[$k]['times']	=	ceil($times / 3600) . "小时前";

                } elseif ($times > 60 && $times < 3600) {

                    $List[$k]['times']	=	ceil($times / 60) . "分钟前";

                } elseif ($times < 60) {

                    $List[$k]['times']	=	"刚刚";
                } else {
                    $List[$k]['times']	=	date("Y-m-d", $v['datetime']);
                }
                $timess	=	time() - $v['order_time'];

                if ($timess > 86400 && $timess < 604800) {

                    $List[$k]['timess']	=	ceil($timess / 86400) . "天前";

                } elseif ($timess > 3600 && $timess < 86400) {

                    $List[$k]['timess']	=	ceil($timess / 3600) . "小时前";

                } elseif ($timess > 60 && $timess < 3600) {

                    $List[$k]['timess']	=	ceil($timess / 60) . "分钟前";

                } elseif ($timess < 60) {

                    $List[$k]['timess']	=	"刚刚";
                } else {
                    $List[$k]['timess']	=	date("Y-m-d", $v['order_time']);
                }
            }
        }
        $this->yunset('list', $List);
        $this->yunset('name', $name);
        $this->yunset('type', "dt");

        $this->siteadmin_tpl(array('admin_right_web'));
    }

	// 会员日志
    function userrz_action(){

        $where['usertype']	=	1;
        $where['orderby']	=	array('ctime,desc');
        $this->rz("member_log", "ctime", "个人会员日志", $where);
    }
    function comrz_action(){

        $where['usertype']	=	2;
        $where['orderby']	=	array('ctime,desc');
        $this->rz("member_log", "ctime", "企业会员日志", $where);
    }
    function lietoutz_action(){

        $where['usertype']	=	3;
        $where['orderby']	=	array('ctime,desc');
        $this->rz("member_log", "ctime", "猎头会员日志",$where);
    }
    function traintz_action(){

        $where['usertype']	=	4;
        $where['orderby']	=	array('ctime,desc');
        $this->rz("member_log", "ctime", "培训会员日志",$where);
    }
    
     function gqtz_action(){

        $where['usertype']	=	5;
        $where['orderby']	=	array('ctime,desc');
        $this->rz("member_log", "ctime", "供求会员日志",$where);
    }
	function rz($tablename, $field, $name, $where=array()){

        $UserinfoM	=	$this->MODEL('userinfo');  
        $TongjiM	=	$this->MODEL('tongji');

        $where['limit']	=	21;
        $List			=	$TongjiM->tjtotal($tablename,$where);
        
        if (is_array($List)) {

            foreach ($List as $v) {

                $uid[]	=	$v['uid'];
            }
            $uidwhere['uid']	=	array('in',pylode(',',$uid));
            $member				=	$UserinfoM->getList($uidwhere,array('field'=>'`username`,`uid`'));

            foreach ($List as $k => $v) {

                foreach ($member as $val) {

                    if ($v['uid'] == $val['uid']) {

                        $List[$k]['username']	=	$val['username'];
                    }
                }
                $time	=	time() - $v['ctime'];

                if ($time > 86400 && $time < 604800) {

                    $List[$k]['time']   =	ceil($time / 86400) . "天前";

                } elseif ($time > 3600 && $time < 86400) {

                    $List[$k]['time']   =	ceil($time / 3600) . "小时前";

                } elseif ($time > 60 && $time < 3600) {

                    $List[$k]['time']   =	ceil($time / 60) . "分钟前";

                } elseif ($time < 60) {

                    $List[$k]['time']   =	"刚刚";
                } else {
                    $List[$k]['time']	=	date("Y-m-d", $v['ctime']);
                }
            }
        }
        $this->yunset('list', $List);
        $this->yunset('name', $name);
        $this->yunset('type', "rz");

        $this->siteadmin_tpl(array('admin_right_web'));
    }
	// 动态活跃
    function downresumedthy_action(){
        $this->hy("down_resume", "downtime", 'company');
    }
    function lookjobdthy_action(){
        $this->hy("look_job", "datetime", 'member');
    }
    function lookresumedthy_action(){
        $this->hy("look_resume", "datetime", 'company');
    }
    function useridjobdthy_action(){
        $this->hy("userid_job", "datetime", 'member');
    }
    function favjobdthy_action(){
        $this->hy("fav_job", "datetime", 'member');
    }
    function payorderdthy_action(){
        $this->hy("company_order", "order_time");
    }
    // 日志活跃
    function userrzhy_action(){
        $where['usertype']	=	1;
        $this->hy("member_log", "ctime", 'member', $where);
    }
    function comrzhy_action(){
        $where['usertype']	=	2;
        $this->hy("member_log", "ctime", 'company',  $where);
    }
    function lietoutzhy_action(){
        $where['usertype']	=	3;
        $this->hy("member_log", "ctime", 'lt_info', $where);
    }
    function hy($tablename, $field, $tablename2, $where=array()){

        $TongjiM	=	$this->MODEL('tongji');
        $UserinfoM	=	$this->MODEL('userinfo');
        $LietouM	=	$this->MODEL('lietou');
        $CompanyM	=	$this->MODEL('company'); 
		
        $date				=	date('Y-m-d');
        $where[$field][]	=	array('>=',strtotime($date . ' 00:00:01'));
        $where[$field][]	=	array('<=',strtotime($date . ' 23:59:59'));
        $List				=	$TongjiM->tjtotal($tablename,$where);
    
        $html 				=	"<div><div>今日操作总数：" . count($List) . "</div>  ";

        if ($tablename == 'down_resume' || $tablename == 'look_resume' || $tablename == 'company_order') {

            if ($tablename == 'down_resume') {

                foreach ($List as $v) {

                    $uid[] = $v['comid'];
                }
            } elseif ($tablename == 'look_resume') {

                foreach ($List as $v) {

                    $uid[] = $v['com_id'];
                }
            } else {
                foreach ($List as $v) {

                    $uid[] = $v['uid'];
                }
            }
            $huoyue				=	$this->getMostElements($uid);
            $memberwhere['uid']	=	$huoyue[0];
            $member				=	$UserinfoM->getInfo($memberwhere,array('field'=>'`uid`,`username`,`usertype`'));

            if ($member['usertype'] == 2) {

                $comwhere['uid']	=	$member['uid'];
                $com				=	$CompanyM->getChCompanyList($comwhere,array('field'=>'`name`'));

                if ($com) {

                    $html .= "<span>活跃会员：" . substr($com['name'], 0, 20) . "</span>";
                }
            } elseif ($member['usertype'] == 3) {

                $ltwhere['uid']	=	$member['uid'];
                $com			=	$LietouM->getList($ltwhere,array('field'=>'`realname`'));
        
                if ($com) {

                    $html .= "<span>活跃会员：" . substr($com['realname'], 0, 20) . "</span>";
                }
            } elseif ($member['usertype'] == 1) {

                $html .= "<span>活跃会员：" . substr($member['username'], 0, 20) . "</span>";
            }
        } elseif ($tablename == 'userid_job' || $tablename == 'look_job' || $tablename == 'fav_job') {

            foreach ($List as $v) {

                $uid[] = $v['uid'];
            }
            $huoyue				=	$this->getMostElements($uid);
            $tablewhere['uid']	=	$huoyue[0];
            $com                =   $TongjiM->tjtonce($tablename2,$tablewhere,array('field'=>'`username`'));

            if ($com) {
                $html .= "<span>活跃会员：" . substr($com['username'], 0, 20) . "</span>";
            }
        } elseif ($tablename == 'member_log') {
			
            foreach ($List as $v) {
				
                $uid[] = $v['uid'];
            }
            $huoyue = $this->getMostElements($uid);
			
            if ($tablename2 == 'member') {

                $memberwhere['uid']	=	$huoyue[0];
                $com				=	$TongjiM->tjtonce($tablename2,$memberwhere,array('field'=>'`username`'));

                if ($com) {

                    $html .= "<span>活跃会员：" . substr($com['username'], 0, 20) . "</span>";
                }
            } elseif ($tablename2 == 'lt_info') {

                $ltwhere['uid']	=	$huoyue[0];
                $com			=	$TongjiM->tjtonce($tablename2,$ltwhere,array('field'=>'`realname`'));

                if ($com) {

                    $html .= "<span>活跃会员：" . substr($com['realname'], 0, 20) . "</span>";
                }
            } else {
                $otherewhere['uid']	=	$huoyue[0];

                $com				=	$TongjiM->tjtonce($tablename2,$otherewhere,array('field'=>'`name`'));
               
                if ($com) {

                    $html .= "<span>活跃会员：" . substr($com['name'], 0, 20) . "</span>";
                }
            }
        }
        $html .= "</div>";
        echo $html;
    }

    function getMostElements($arr){
        $arr            =       array_count_values($arr);
        asort($arr);
        
        $findNum        =       end($arr);

        foreach ($arr as $k => $v) {

            if ($v != $findNum) {

                unset($arr[$k]);

            }

        }
        return array_keys($arr);

    }
	// 时间获取
    function day(){

        if ((int) $_GET['days'] > 0) {

            $days       =       (int) $_GET['days'];
            $sdate      =       date('Y-m-d', (time() - $days * 86400));
            $edate      =       date('Y-m-d');

        } elseif ($_GET['sdate']) {

            $sdate      =      $_GET['sdate'];
            $days       =      ceil(abs(time() - strtotime($sdate)) / 86400);

            if ($_GET['edate']) {

                $edate  =       $_GET['edate'];
                $days   =       ceil(abs(strtotime($edate) - strtotime($sdate)) / 86400);
            }
        } else {
            $days       =       30;
            $sdate      =       date('Y-m-d', (time() - $days * 86400));
            $edate      =       date('Y-m-d');
        }
        return array('sdate' => $sdate,'days' => $days,'edate' => $edate);
    }
}
?>