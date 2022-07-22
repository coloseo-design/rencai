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

class admin_resume_controller extends adminCommon
{

    //设置高级搜索功能
    function set_search($CacheList = array())
    {

        if (!$CacheList){

            $cacheM		=	$this -> MODEL('cache');
            $CacheList	=	$cacheM -> GetCache(array('user', 'job', 'city'));

            $setArr	    =	array(
                'userdata'		=>	$CacheList['userdata'],
                'userclass_name'=>	$CacheList['userclass_name'],
                'job_name'		=>	$CacheList['job_name'],
                'city_name'		=>	$CacheList['city_name']
            );
            $this -> yunset($setArr);
        }

        $userdata       =   $CacheList['userdata'];
        $userclass_name =   $CacheList['userclass_name'];

        foreach($userdata['user_type'] as $k=>$v){

            $type[$v]   =   $userclass_name[$v];
        }

        foreach($userdata['user_edu'] as $k=>$v){

            $edu[$v]    =   $userclass_name[$v];
        }

        foreach($userdata['user_word'] as $k=>$v){

            $exp[$v]    =   $userclass_name[$v];
        }

        foreach($userdata['user_report'] as $k=>$v){

            $report[$v] =   $userclass_name[$v];
        }

        include(CONFIG_PATH.'db.data.php');

        $source		=    $arr_data['source'];
        $uptime		=	array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
        $adtime		=	array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
        $status		=	array('1'=>'已审核','2'=>'已锁定','3'=>'未通过','4'=>'未审核');
        $service	=	array('1'=>'置顶','2'=>'推荐');
        $integrity  =	$arr_data['integrity_name'];
        $search[]	=	array('param'=>'status','name'=>'审核状态','value'=>$status);
        $search[]	=	array('param'=>'uptime','name'=>'更新时间','value'=>$uptime);
        $search[]	=	array('param'=>'source','name'=>'数据来源','value'=>$source);
        $search[]	=	array('param'=>'service','name'=>'简历类型','value'=>$service);
        $search[]	=	array('param'=>'adtime','name'=>'添加时间','value'=>$adtime);
        $search[]	=	array('param'=>'type','name'=>'工作性质','value'=>$type);
        $search[]	=	array('param'=>'edu','name'=>'最高学历','value'=>$edu);
        $search[]	=	array('param'=>'exp','name'=>'工作经验','value'=>$exp);
        $search[]	=	array('param'=>'report','name'=>'到岗时间','value'=>$report);
        $search[]	=	array('param'=>'integrity','name'=>'完整度','value'=>$integrity);
        $this->yunset('source',$source);

        $this->yunset('search_list',$search);
    }
    /**
     * 会员-个人-简历管理
     */
    function index_action()
    {

        $resumeM    =   $this->MODEL('resume');

        $urlarr     =   array();
        $where      =   '1';

        include(CONFIG_PATH . 'db.data.php');

        //搜索类型和搜索关键字
        if ($_GET['keyword']) {

            $keytype = intval($_GET['keytype']);
            $keyword = trim($_GET['keyword']);

            if ($keytype == 1) {

                $where .= " and a.name like '%$keyword%'";
            } elseif ($keytype == 2) {

                $where .= " and a.uname like '%$keyword%'";
            } elseif ($keytype == 3) {

                $where .= " and a.id = $keyword";
            }elseif ($keytype == 4) {
                $mUids		=	array();

                $UserinfoM	=	$this -> MODEL('userinfo');
                $mwhere['username']     =   array('like', $keyword);
                if(!empty($mwhere)){

                    $uidList	=	$UserinfoM  ->  getList($mwhere, array('field' => '`uid`'));

                    if(!empty($uidList)){

                        foreach($uidList as $uv){

                            $mUids[]	=	$uv['uid'];

                        }

                    }

                    $where .= " and a.uid in (".pylode(',', $mUids).")";
                }

            } elseif ($keytype == 5) {
                $mUids		=	array();
                $UserinfoM	=	$this -> MODEL('userinfo');
                $mwhere['telphone']     =   array('like', $keyword);
                if(!empty($mwhere)){
                    $uidList	=	$UserinfoM  ->  getUserInfoList($mwhere, array('usertype'=>1,'field' => '`uid`'));
                    if(!empty($uidList)){
                        foreach($uidList as $uv){
                            $mUids[]	=	$uv['uid'];
                        }
                    }
                    $where .= " and a.uid in (".pylode(',', $mUids).")";
                }
            } elseif ($keytype == 6) {                      //  教育经历

                $eduWhere   =   array(
                    'name'      =>  array('like', $keyword),
                    'title'     =>  array('like', $keyword, 'OR'),
                    'specialty' =>  array('like', $keyword, 'OR')
                );

                $edu        =   $resumeM->getResumeEdus($eduWhere, 'eid');

                if ($edu) {

                    $eids = array();
                    foreach ($edu as $v) {

                        $eids[] = $v['eid'];
                    }

                    $where .= " and a.id in (".pylode(',', $eids).")";
                }
            } elseif ($keytype == 7) {                      //  工作经历

                $workWhere  =   array(
                    'name'      =>  array('like', $keyword),
                    'title'     =>  array('like', $keyword, 'OR'),
                    'content'   =>  array('like', $keyword, 'OR')
                );

                $work       =   $resumeM->getResumeWorks($workWhere, 'eid');

                if ($work) {

                    $eids = array();
                    foreach ($work as $v) {

                        $eids[] = $v['eid'];
                    }

                    $where .= " and a.id in (".pylode(',', $eids).")";
                }
            }elseif ($keytype == 8) {                      //  项目经历

                $proWhere  =   array(
                    'name'      =>  array('like', $keyword),
                    'title'     =>  array('like', $keyword, 'OR'),
                    'content'   =>  array('like', $keyword, 'OR')
                );

                $work       =   $resumeM->getResumeProjects($proWhere, 'eid');

                if ($work) {

                    $eids = array();
                    foreach ($work as $v) {

                        $eids[] = $v['eid'];
                    }

                    $where .= " and a.id in (".pylode(',', $eids).")";
                }
            }elseif ($keytype == 9) {                      //  培训经历

                $trainWhere  =   array(
                    'name'      =>  array('like', $keyword),
                    'title'     =>  array('like', $keyword, 'OR'),
                    'content'   =>  array('like', $keyword, 'OR')
                );

                $work       =   $resumeM->getResumeTrains($trainWhere, 'eid');

                if ($work) {

                    $eids = array();
                    foreach ($work as $v) {

                        $eids[] = $v['eid'];
                    }

                    $where .= " and a.id in (".pylode(',', $eids).")";
                }
            }elseif ($keytype == 10) {                      //  职业技能

                $skillWhere  =   array(
                    'name'      =>  array('like', $keyword),
                    'title'     =>  array('like', $keyword, 'OR'),
                    'content'   =>  array('like', $keyword, 'OR')
                );

                $work       =   $resumeM->getResumeSkills($skillWhere, 'eid');

                if ($work) {

                    $eids = array();
                    foreach ($work as $v) {

                        $eids[] = $v['eid'];
                    }

                    $where .= " and a.id in (".pylode(',', $eids).")";
                }
            }

            $urlarr['keytype'] = $keytype;
            $urlarr['keyword'] = $keyword;
        }

        //审核状态
        if ($_GET['status']) {

            $status = intval($_GET['status']);

            if ($status == 2) {

                $where .= " and a.r_status = 2";
            } else {

                $where .= " and a.state = " . ($status == 4 ? 0 : $status);
            }

            $urlarr['status'] = $status;
        }

        //来源
        if ($_GET['source']) {

            $where .= " and a.source = ".intval($_GET['source']);

            $urlarr['source'] = intval($_GET['source']);
        }

        //发布时间
        if ($_GET['adtime']) {

            $adtime = intval($_GET['adtime']);

            if ($adtime == 1) {

                $where .= " and a.ctime > ".strtotime('today');

            } else {

                $where .= " and a.ctime > ".strtotime('-' . $adtime . ' day');
            }

            $urlarr['adtime'] = $adtime;
        }

        //更新时间
        if ($_GET['uptime']) {

            $uptime = intval($_GET['uptime']);

            if ($uptime == 1) {

                $where .= " and a.lastupdate > ".strtotime('today');

            } else {

                $where .= " and a.lastupdate > ".strtotime('-' . $uptime . ' day');
            }
            $urlarr['uptime'] = $uptime;
        }

        //工作性质
        if ($_GET['type']) {

            $where .= " and a.type = ".intval($_GET['type']);

            $urlarr['type'] = $_GET['type'];
        }

        //学历要求
        if ($_GET['edu']) {
            include_once PLUS_PATH.'user.cache.php';
            $eduArr = $userdata['user_edu'];
            $eduIds = [];
            foreach ($eduArr as $key => $value) {
                if ($value == $_GET['edu']) {
                    $eduIds = array_slice($eduArr, $key);
                    break;
                }
            }
            sort($eduIds);
            if ($eduIds) {
                $where .= " AND a.`edu` in (".implode(",", $eduIds).")";
            }
            $urlarr['edu'] = intval($_GET['edu']);
        }

        //工作经验
        if ($_GET['exp']) {
            include_once PLUS_PATH.'user.cache.php';
            $expArr = $userdata['user_word'];
            $expIds = [];
            foreach ($expArr as $key => $value) {
                if ($value == $_GET['exp']) {
                    $expIds = array_slice($expArr, $key);
                    break;
                }
            }
            sort($expIds);
            if ($expIds) {
                $where .= " AND a.`exp` in (".implode(",",$expIds).")";
            }
            $urlarr['exp'] = intval($_GET['exp']);
        }
        //到岗时间
        if ($_GET['report']) {

            $where .= " and a.report = ".intval($_GET['report']);

            $urlarr['report'] = intval($_GET['report']);
        }

        //简历完整度
        if ($_GET['integrity']) {

            $integrity_val = $arr_data['integrity_val'];
            $where .= " and a.integrity >= ".$integrity_val[$_GET['integrity']];
            $urlarr['integrity'] = $_GET['integrity'];
        }

        //简历类型
        if ($_GET['service']) {

            $service = intval($_GET['service']);

            if ($service == 1) {
                //置顶
                $where .= " and a.top = 1";

                $where .= " and a.topdate > ".time();
            } elseif ($service == 2) {
                //推荐
                $where .= " and a.rec_resume = 1";
            }

            $urlarr['service'] = $service;
        }
        if($_GET['teen']==1){

            $datetime=strtotime('-16 years');

            $where .= " and UNIX_TIMESTAMP(a.`birthday`) >".$datetime;

            $urlarr['teen']  =  $_GET['teen'];
        }

        $city_job_class = '';
        if ($_GET['job_class'] || $_GET['city_class']) {
            include_once(PLUS_PATH . 'city.cache.php');
            include_once(PLUS_PATH . 'cityparent.cache.php');
            include_once(PLUS_PATH . 'job.cache.php');
            include_once(PLUS_PATH . 'jobparent.cache.php');
            $city_col = $job_col = '';
            $cjwhere = '';
            if ($_GET['job_class']) {
                if ($job_parent[$_GET['job_class']] == '0') {
                    $job_col = "job1";
                    $cjwhere .= "$job_col = {$_GET['job_class']}";
                } elseif (in_array($job_parent[$_GET['job_class']], $job_index)) {
                    $job_col = "job1_son";
                    $cjwhere .= "$job_col = {$_GET['job_class']}";
                } elseif ($job_parent[$_GET['job_class']] > 0) {
                    $job_col = "job_post";
                    $cjwhere .= "$job_col = {$_GET['job_class']}";
                }
                $urlarr['job_class'] = $_GET['job_class'];
            }
            if ($_GET['city_class']) {
                $cjand = $cjwhere ? ' AND ' : '';
                if ($city_parent[$_GET['city_class']] == '0') {
                    $city_col = "provinceid";
                    $cjwhere .= "{$cjand}$city_col = {$_GET['city_class']}";
                } elseif (in_array($city_parent[$_GET['city_class']], $city_index)) {
                    $city_col = "cityid";
                    $cjwhere .= "{$cjand}$city_col = {$_GET['city_class']}";
                } elseif ($city_parent[$_GET['city_class']] > 0) {
                    $city_col = "three_cityid";
                    $cjwhere .= "{$cjand}$city_col = {$_GET['city_class']}";
                }
                $urlarr['city_class'] = $_GET['city_class'];
            }
            // 拼接唯一标识字段
            if ($city_col || $job_col) {
                if ($city_col && $job_col) {
                    $cjwhere .= " AND {$city_col}_{$job_col}_num = 1";
                } elseif ($city_col) {
                    $cjwhere .= " AND {$city_col}_num = 1";
                } elseif ($job_col) {
                    $cjwhere .= " AND {$job_col}_num = 1";
                }
            }
            $city_job_class = ",(select `eid` from `".$this->def."resume_city_job_class` where $cjwhere) cj";
            $where .= " and a.id = cj.eid";
        }

        $countSql = "select count(*) as num from `".$this->def."resume_expect` a{$city_job_class} where {$where}";

        //分页链接
		$urlarr        	=   $_GET;
        $urlarr['page'] = '{{page}}';
        $pageurl = Url($_GET['m'], $urlarr, 'admin');
        //提取分页
        $pageM = $this->MODEL('page');
        $pages = $pageM->pageList('resume_expect', $where, $pageurl, $_GET['page'], '', $countSql);

        $order = '';
        //分页数大于0的情况下 执行列表查询
        if ($pages['total'] > 0) {
            //limit order 只有在列表查询时才需要
            if ($_GET['order']) {

                if ($_GET['t'] == 'time') {

                    $order .= "order by a.lastupdate ". $_GET['order'];
                } else {

                    $order .= 'order by a.' . $_GET['t'] . ' ' . $_GET['order'];
                }

                $urlarr['order'] = $_GET['order'];
                $urlarr['t'] = $_GET['t'];
            } else {
                $order .= 'order by a.lastupdate desc';
            }
            $sql        =   "select a.* from `".$this->def."resume_expect` a{$city_job_class} where {$where} {$order} limit {$pages['limit'][0]},{$pages['limit'][1]}";
            $List       =   $resumeM->getList(array(), array('cache' => 1, 'utype' => 'admin', 'sql' => $sql));
            $CacheList  =   $List['cache'];

            $setArr                 =   array(
                'rows'              =>  $List['list'],
                'userdata'          =>  $CacheList['userdata'],
                'userclass_name'    =>  $CacheList['userclass_name'],
                'job_name'          =>  $CacheList['job_name'],
                'city_name'         =>  $CacheList['city_name']
            );
            $this->yunset($setArr);
        }
        // 查无数据的搜索条件也记入session，导出时根据此条件查无数据，提示暂无数据
        session_start();
        //处理导出需要的where条件
        $_SESSION['resumeXls']  =   array(
            'where'             =>  $where,
            'order'             =>  $order,
            'city_job_class'    =>  $city_job_class
        );

        //高级搜索
        $this->set_search($CacheList);

        $this->yuntpl(array('admin/admin_resume'));
    }
    /**
     * 会员-个人-简历管理: 添加简历页面
     */
    public function addResume_action(){

        $cacheM  =  $this->MODEL('cache');

        $cache   =  $cacheM -> GetCache('user');

        if ($_GET['uid']){

            $where['uid'] = intval($_GET['uid']);

            $resumeM   =   $this->MODEL('resume');

            $return  =  $resumeM -> getResumeInfo($where);

        }

        $setarr  =  array(
            'row'             =>  $return,
            'user_sex'        =>  $cache['user_sex'],
            'userdata'        =>  $cache['userdata'],
            'userclass_name'  =>  $cache['userclass_name'],
        );

        $this->yunset($setarr);

        $this->yuntpl(array('admin/admin_resume_add'));
    }
    /**
     * 会员-个人-简历管理: 添加简历保存
     */
    public function saveResume_action(){
        if($_POST['next']){

            $resumeM  =  $this->MODEL('resume');

            $_POST    =  $this->post_trim($_POST);



            if($_POST['uid']){

                $uid    =  intval($_POST['uid']);

                $mData = array(
                    'email'  => $_POST['email'],
                    'moblie' => $_POST['moblie']
                );

                $rData = array(
                    'name'        => 	$_POST['resume_name'],
                    'sex'         => 	$_POST['sex'],
                    'birthday'    => 	$_POST['birthday'],
                    'living'      => 	$_POST['living'],
                    'edu'         => 	$_POST['edu'],
                    'exp'         => 	$_POST['exp'],
                    'telphone'    => 	$_POST['moblie'],
                    'email'       => 	$_POST['email'],
                    'description' => 	$_POST['description'],
                );

                $result  =  $resumeM -> upResumeInfo(array('uid'=>$uid),array('mData'=>$mData,'rData'=>$rData));

                if ($result['id']){

                    $this -> ACT_layer_msg('下一步：填写求职意向',9,'index.php?m=admin_resume&c=editResume&uid='.$_POST['uid'].'');

                }elseif ($result['msg']){

                    $this -> ACT_layer_msg($result['msg'], 8);

                }else{

                    $this -> ACT_layer_msg('保存失败，请重试！',8);
                }
            }else{
                if($this->config['sy_uc_type']=='uc_center'){

                    $this-> obj-> uc_open();

                    $user = uc_get_user($_POST['username']);

                    if ($user){

                        $this->ACT_layer_msg('该会员已经存在！',8);
                    }
                }
                $userinfoM = $this->MODEL('userinfo');
                //检测用户名、手机号、邮箱是否已被注册
                $checkData = array(
                    'username' => $_POST['username'],
                    'moblie'   => $_POST['moblie'],
                    'email'    => $_POST['email'],
                );
                $memberCheck = $userinfoM->addMemberCheck($checkData);

                if ($memberCheck['msg']){

                    $this->ACT_layer_msg($memberCheck['msg'],8);
                }

                $ip    =  fun_ip_get();
                $time  =  time();
                $pass  =  $_POST['password'];

                if($this->config['sy_uc_type']=='uc_center'){

                    $uid  =  uc_user_register($_POST['username'],$pass,$_POST['email']);

                    if($uid < 0){

                        switch($uid){
                            case "-1" : $data['msg']='用户名不合法!';
                                break;
                            case "-2" : $data['msg']='包含不允许注册的词语!';
                                break;
                            case "-3" : $data['msg']='用户名已经存在!';
                                break;
                            case "-4" : $data['msg']='Email 格式有误!';
                                break;
                            case "-5" : $data['msg']='Email 不允许注册!';
                                break;
                            case "-6" : $data['msg']='该 Email 已经被注册!';
                                break;
                        }
                        $this -> ACT_layer_msg($data['msg'],8);
                    }else{

                        list($uid,$username,$email,$password,$salt)=uc_get_user($_POST['username'],$pass);
                    }
                }else{
                    $salt      =  substr(uniqid(rand()), -6);

                    $password  =  passCheck($pass,$salt);
                }

                $mdata = array(
                    'username'  =>  $_POST['username'],
                    'password'  =>  $password,
                    'usertype'  =>  1,
                    'salt'      =>  $salt,
                    'moblie'    =>  $_POST['moblie'],
                    'email'     =>  $_POST['email'],
                    'reg_date'  =>  $time,
                    'reg_ip'    =>  $ip,
                    'status'    =>  1
                );
                $udata = array(
                    'name'         =>  $_POST['resume_name'],
                    'sex'          =>  $_POST['sex'],
                    'edu'          =>  $_POST['edu'],
                    'exp'          =>  $_POST['exp'],
                    'birthday'     =>  $_POST['birthday'],
                    'email'        =>  $_POST['email'],
                    'telphone'     =>  $_POST['moblie'],
                    'description'  =>  $_POST['description'],
                    'living'       =>  $_POST['living'],
                    'r_status'	   =>  1
                );

                $nid  =  $userinfoM -> addInfo(array('mdata'=>$mdata,'udata'=>$udata,'sdata'=>array('integral'=>0)));

                if($nid > 0){

                    $this->ACT_layer_msg('下一步：填写求职意向',9,'index.php?m=admin_resume&c=editResume&uid='.$nid.'');

                }else{

                    $this->ACT_layer_msg('会员添加失败，请重试！',8);
                }
            }
        }
    }
    /**
     *
     */
    function saveResumeInfo_action(){
        $resumeM  =  $this->MODEL('resume');

        $_POST    =  $this->post_trim($_POST);
        if($_POST['uid']) {

            $uid = intval($_POST['uid']);
            $rData = array(
                'name' => $_POST['resume_name'],
                'sex' => $_POST['sex'],
                'birthday' => $_POST['birthday'],

                'edu' => $_POST['edu'],
                'exp' => $_POST['exp'],

                'description' => $_POST['description'],
            );

            $result = $resumeM->upResumeInfo(array('uid' => $uid), array('rData' => $rData));

            if($_POST['from'] == 'crm_chat_room' || $_POST['from'] =='resume_audit'){

                if($result){
                    $where['uid']       =       $uid;
                    $resumeinfo         =       $resumeM->getResumeInfo($where,array('logo'=>2));
                    echo json_encode(array('error'=>1,'resumeinfo'=>$resumeinfo));die;

                }else{

                    echo json_encode(array('error'=>0,'msg'=>'操作失败'));die;
                }
            }else{
                if($result){
                    $this -> ACT_layer_msg('修改成功！',9,'index.php?m=admin_resume&c=editResume&uid='.$uid.'&id='.$_POST['eid']);
                }else{
                    $this -> ACT_layer_msg('修改失败！',8);
                }
            }

        }
    }
    /**
     * 会员-个人-简历管理: 修改简历页面
     */
    public function editResume_action(){
        $cacheM  =  $this->MODEL('cache');

        $cache   =  $cacheM -> GetCache('user');
        $uid = intval($_GET['uid']);

        if($_GET['id']){

            $eid = intval($_GET['id']);
        }
        $resumeM = $this->MODEL('resume');

        $return = $resumeM->getInfo(array('uid'=>$uid,'eid'=>$eid,'tb'=>'all','needCache'=>1));



        $setarr = array(
            'uid'             =>   $uid,
            'expect'          =>   $return['expect'],
            'edu'             =>   $return['edu'],
            'other'           =>   $return['other'],
            'project'         =>   $return['project'],
            'skill'           =>   $return['skill'],
            'training'        =>   $return['training'],
            'work'            =>   $return['work'],
            'industry_index'  =>   $return['cache']['industry_index'],
            'industry_name'   =>   $return['cache']['industry_name'],
            'userdata'        =>   $return['cache']['userdata'],
            'userclass_name'  =>   $return['cache']['userclass_name'],
        );

        $this->yunset($setarr);

        if(empty($return['cache']['city_type'])){
            $this   ->  yunset('cionly',1);
        }
        if(empty($return['cache']['job_type'])){
            $this   ->  yunset('jionly',1);
        }

        $where['uid']		=		$uid;

        $resumeinfo			=		$resumeM->getResumeInfo($where,array('logo'=>2));
        $setarr  =  array(
            'row'             =>  $return,
            'user_sex'        =>  $cache['user_sex'],
            'userdata'        =>  $cache['userdata'],
            'userclass_name'  =>  $cache['userclass_name'],
        );

        $this->yunset($setarr);
        $this->yunset('resumeinfo',$resumeinfo);

        $this->yuntpl(array('admin/admin_resume_edit'));
    }
    /**
     * 会员-个人-简历管理: 保存求职意向
     */
    public function saveExpect_action(){

        if($_POST['submit']){
            $eid      =  (int)$_POST['eid'];
            $uid      =  (int)$_POST['uid'];
            $time     =  time();

            $resumeM  =  $this->MODEL('resume');

            if($eid == ''){

                $field   =  'uid,name,edu,exp,sex,birthday,idcard_status,status,photo,phototype,r_status';

                $resumewhere['uid']     =     $uid;

                $resume  =  $resumeM -> getResumeInfo($resumewhere,array('field'=>$field));
                if(is_array($resume)){
                    if($resume['r_status']==1){
                        $state			=		1;
                    }else{
                        $state			=		0;
                    }
                }else{
                    $state			=		1;
                }

                $expectDate = array(
                    'height_status'	  =>  0,
                    'r_status'        =>  $resume['r_status'],
                    'state'        		=>  $state,
                    'integrity'		  =>  55,
                    'lastupdate'	  =>  $time,
                    'ctime'			  =>  $time,
                    'name'			  =>  $_POST['name'],
                    'hy'			  =>  $_POST['hy'],
                    'job_classid'	  =>  $_POST['job_classid'],
                    'minsalary'		  =>  $_POST['minsalary'],
                    'maxsalary'		  =>  $_POST['maxsalary'],
                    'city_classid'	  =>  $_POST['city_classid'],
                    'type'			  =>  $_POST['type'],
                    'report'		  =>  $_POST['report'],
                    'jobstatus'		  =>  $_POST['jobstatus'],
                    'uid'			  =>  $resume['uid'],
                    'edu'             =>  $resume['edu'],
                    'exp'             =>  $resume['exp'],
                    'uname'           =>  $resume['name'],
                    'sex'             =>  $resume['sex'],
                    'birthday'        =>  $resume['birthday'],
                    'idcard_status'   =>  $resume['idcard_status'],
                    'status'          =>  $resume['status'],
                    'photo'           =>  $resume['photo'],
                    'phototype'       =>  $resume['phototype']

                );
                $return  =  $resumeM -> addInfo(array('uid'=>$uid,'eData'=>$expectDate,'utype'=>'admin'));
                $eid     =  $return['id'];
            }else{
                $expectDate  =  array(
                    'name'			=>	$_POST['name'],
                    'hy'			=>	$_POST['hy'],
                    'job_classid'	=>	$_POST['job_classid'],
                    'minsalary'		=>	$_POST['minsalary'],
                    'maxsalary'		=>	$_POST['maxsalary'],
                    'city_classid'	=>	$_POST['city_classid'],
                    'type'			=>	$_POST['type'],
                    'report'		=>	$_POST['report'],
                    'jobstatus'		=>	$_POST['jobstatus'],
                    'lastupdate'	=>	$time
                );

                $return  =  $resumeM -> upInfo(array('id'=>$eid), array('eData'=>$expectDate,'utype'=>'admin'));

            }

            if($return['id']){

                $expect  =  $resumeM -> getExpect(array('id'=>$eid),array('needCache'=>1));

                echo json_encode(array('error'=>1,'expect'=>$expect));die;

            }else{

                echo json_encode(array('error'=>0,'msg'=>'操作失败'));die;
            }
        }
    }
    /**
     * 会员-个人-简历管理: 修改简历页面（工作经历处理）
     */
    public function work_action(){

        $eid   =   intval($_POST['eid']);

        $id    =   intval($_POST['id']);

        $uid   =   intval($_POST['uid']);

        $resumeM   =   $this -> MODEL('resume');

        $post = array(
            'uid'		=>  $uid,
            'eid'		=>  $eid,
            'name'		=>  $_POST['name'],
            'sdate'		=>	strtotime($_POST['sdate']),
            'edate'		=>  strtotime($_POST['edate']),
            'title'		=>  $_POST['title'],
            'content'	=>	$_POST['content']
        );

        if(!$id){

            $return  =  $resumeM -> addResumeWork($post,array('utype'=>'admin'));

            $id      =  $return['id'];
        }else{

            $resumeM -> addResumeWork($post,array('where'=>array('id'=>$id),'utype'=>'admin'));
        }

        $work  =   $resumeM -> getResumeWork(array('id'=>$id));

        echo json_encode($work);die;
    }
    /**
     * 会员-个人-简历管理: 修改简历页面（教育经历处理）
     */
    public function edu_action()
    {
        $eid   =   intval($_POST['eid']);

        $id    =   intval($_POST['id']);

        $uid   =   intval($_POST['uid']);

        $resumeM   =   $this -> MODEL('resume');

        $post = array(
            'uid'		=>  $uid,
            'eid'		=>  $eid,
            'name'		=>  $_POST['name'],
            'sdate'		=>	strtotime($_POST['sdate']),
            'edate'		=>  strtotime($_POST['edate']),
            'title'		=>  $_POST['title'],
            'education'	=>	$_POST['education'],
            'specialty' =>  $_POST['specialty']
        );

        if(!$id){

            $return  =  $resumeM -> addResumeEdu($post,array('utype'=>'admin'));

            $id      =  $return['id'];
        }else{

            $resumeM -> addResumeEdu($post,array('where'=>array('id'=>$id),'utype'=>'admin'));
        }

        $edu  =   $resumeM -> getResumeEdu(array('id'=>$id));

        echo json_encode($edu);die;
    }
    /**
     * 会员-个人-简历管理: 修改简历页面（培训经历处理）
     */
    public function training_action(){
        $eid   =   intval($_POST['eid']);

        $id    =   intval($_POST['id']);

        $uid   =   intval($_POST['uid']);

        $resumeM   =   $this -> MODEL('resume');

        $post = array(
            'uid'		=>  $uid,
            'eid'		=>  $eid,
            'name'		=>  $_POST['name'],
            'sdate'		=>	strtotime($_POST['sdate']),
            'edate'		=>  strtotime($_POST['edate']),
            'title'		=>  $_POST['title'],
            'content'	=>	$_POST['content']
        );

        if(!$id){

            $return  =  $resumeM -> addResumeTrain($post,array('utype'=>'admin'));

            $id      =  $return['id'];
        }else{

            $resumeM -> addResumeTrain($post,array('where'=>array('id'=>$id),'utype'=>'admin'));
        }

        $train  =   $resumeM -> getResumeTrain(array('id'=>$id));

        echo json_encode($train);die;
    }
    /**
     * 会员-个人-简历管理: 修改简历页面（职业技能处理）
     */
    public function skill_action(){
        $eid   =   intval($_POST['eid']);

        $id    =   intval($_POST['id']);

        $uid   =   intval($_POST['uid']);

        $resumeM   =   $this -> MODEL('resume');
        $post = array(
            'uid'		=>  $uid,
            'eid'		=>  $eid,
            'name'		=>  $_POST['name'],
            'ing'		=>  $_POST['user_ing_name'],
            'file'		=>  $_FILES['file'],
            'longtime'	=>	$_POST['longtime']
        );

        if(!$id){

            $return  =  $resumeM -> addResumeSkill($post,array('utype'=>'admin'));

            $id      =  $return['id'];
        }else{

            $return  =  $resumeM -> addResumeSkill($post,array('where'=>array('id'=>$id),'utype'=>'admin'));
        }

        if($_POST['from'] == 'crm_chat_room'){
            $return_url = 'index.php?m=crm_chat&c=room&id='.$uid;
        }else if($_POST['from'] == 'resume_audit'){
            $return_url = 'index.php?m=admin_resume&c=resumeAudit&id='.$eid;
        }else{
            $return_url = 'index.php?m=admin_resume&c=editResume&uid='.$uid.'&id='.$eid;
        }

        $this->ACT_layer_msg($return['msg'],$return['errcode'],$return_url);
    }
    /**
     * 会员-个人-简历管理: 修改简历页面（项目经历处理）
     */
    public function project_action(){
        $eid   =   intval($_POST['eid']);

        $id    =   intval($_POST['id']);

        $uid   =   intval($_POST['uid']);

        $resumeM   =   $this -> MODEL('resume');

        $post = array(
            'uid'		=>  $uid,
            'eid'		=>  $eid,
            'name'		=>  $_POST['name'],
            'sdate'		=>	strtotime($_POST['sdate']),
            'edate'		=>  strtotime($_POST['edate']),
            'title'		=>  $_POST['title'],
            'content'	=>	$_POST['content']
        );

        if(!$id){

            $return  =  $resumeM -> addResumeProject($post,array('utype'=>'admin'));

            $id      =  $return['id'];
        }else{

            $resumeM -> addResumeProject($post,array('where'=>array('id'=>$id),'utype'=>'admin'));
        }

        $project  =   $resumeM -> getResumeProject(array('id'=>$id));

        echo json_encode($project);die;
    }
    /**
     * 会员-个人-简历管理: 修改简历页面（其他描述处理）
     */
    public function other_action(){
        $eid   =   intval($_POST['eid']);

        $id    =   intval($_POST['id']);

        $uid   =   intval($_POST['uid']);

        $resumeM   =   $this -> MODEL('resume');

        $post = array(
            'uid'		=>  $uid,
            'eid'		=>  $eid,
            'name'		=>  $_POST['name'],
            'content'	=>	$_POST['content']
        );

        if(!$id){

            $return  =  $resumeM -> addResumeOther($post,array('utype'=>'admin'));

            $id      =  $return['id'];
        }else{

            $resumeM -> addResumeOther($post,array('where'=>array('id'=>$id),'utype'=>'admin'));
        }

        $other  =   $resumeM -> getResumeOther(array('id'=>$id));

        echo json_encode($other);die;
    }
    /**
     * 会员-个人-简历管理: 修改简历页面（简历附表详情）
     */
    function getResumeFb_action(){

        $resumeM   =   $this -> MODEL('resume');

        $id    =   intval($_POST['id']);

        $table =   'resume_'.$_POST['type'];

        $info  =   $resumeM -> getFb($table,$id);

        echo json_encode($info);die;
    }
    /**
     * 会员-个人-简历管理: 修改简历页面（简历详情页附表删除）
     */
    function delResumeFb_action(){

        $table  =  trim($_POST['table']);

        $tables  =  array('skill','work','project','edu','training','other');

        if(in_array($table,$tables)){

            $id       =  (int)$_POST['id'];
            $eid      =  (int)$_POST['eid'];
            $uid      =  (int)$_POST['uid'];

            $resumeM  =  $this -> MODEL('resume');

            $return   =  $resumeM -> delFb($table,array('id'=>$id,'eid'=>$eid,'uid'=>$uid), array('utype' => 'admin'));

            if (is_array($return)) {

                $this -> layer_msg($return['msg'],$return['errcode']);
            }else{

                $this -> layer_msg('操作成功！', 9);
            }
        }else{

            $this -> layer_msg('系统异常',8);
        }
    }
    /**
     * 会员-个人-简历管理: 审核简历
     */
    function status_action(){

        $resumeM   =   $this -> MODEL('resume');

        $post      =   array(
            'state'        =>  intval($_POST['status']),
            'statusbody'   =>  trim($_POST['statusbody'])
        );

        $return  =  $resumeM -> statusResume($_POST['id'],array('post'=>$post));

        if (isset($_POST['single'])){
            if ($return['errcode'] == 9){
                if($_POST['atype'] == 1){
                    // 仅保存
                    $this->layer_msg($return['msg'],9);
                }else{
                    // 下一个待审核简历
                    $resumeM  =  $this->MODEL('resume');
                    $row      =  $resumeM->getExpect(array('state'=>0,'orderby'=>array('lastupdate,DESC')), array('field'=>'id'));
                    if (!empty($row)){
                        $this->layer_msg($return['msg'],9,0,'index.php?m=admin_resume&c=resumeAudit&id='.$row['id']);
                    }else{
                        $this->layer_msg($return['msg'],9);
                    }
                }
            }else{
                $this->layer_msg($return['msg'],8);
            }
        }else{
            $this -> ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);
        }
    }
    /**
     * 会员-个人-简历管理: 同步审核用户
     */
    function resumestatus_action()
    {
        if ($_POST) {

            $id         =   intval($_POST['id']);
            $uid        =   intval($_POST['uid']);
            $status     =   intval($_POST['status']);
            $statusbody =   trim($_POST['statusbody']);

            $resumeM    =   $this->MODEL('resume');

            $post   =   array(

                'uid'           =>  $uid,
                'state'         =>  $status,
                'statusbody'    =>  $statusbody
            );

            $return     =   $resumeM -> status($id, $post);

            if (isset($_POST['single'])){
                if ($return['errcode'] == 9){
                    if($_POST['atype'] == 1){
                        // 仅保存
                        $this->layer_msg($return['msg'],9);
                    }else{
                        // 下一个待审核简历
                        $resumeM  =  $this->MODEL('resume');
                        $row      =  $resumeM->getExpect(array('state'=>0,'orderby'=>array('lastupdate,DESC')), array('field'=>'id'));
                        if (!empty($row)){
                            $this->layer_msg($return['msg'],9,0,'index.php?m=admin_resume&c=resumeAudit&id='.$row['id']);
                        }else{
                            $this->layer_msg($return['msg'],9);
                        }
                    }
                }else{
                    $this->layer_msg($return['msg'],8);
                }
            }else{
                $this -> ACT_layer_msg($return['msg'], $return['errcode'], $_SERVER['HTTP_REFERER'], 2, 1);
            }
        }
    }
    /**
     * 会员-个人-简历管理: 刷新简历
     */
    function refresh_action()
    {

        if ($_GET['id']) {

            $id =   intval($_GET['id']);
        } elseif ($_POST['ids']) {

            $id =   trim($_POST['ids']);
        }
        $resumeM=   $this->MODEL('resume');

        $return =   $resumeM->refreshResume($id);

        $this->layer_msg($return['msg'], $return['errcode']);
    }
    /**
     * 会员-个人-简历管理: 推荐简历
     */
    function rec_action(){
        if ($_GET['id']){

            $id   =  intval($_GET['id']);

            $rec  =  $_GET['rec'];

        }elseif ($_POST['ids']){

            $id   =  trim($_POST['ids']);

            $rec  =  $_POST['rec_resume'];
        }
        $resumeM  =  $this -> MODEL('resume');

        $return   =  $resumeM -> recResume($id,$rec);

        echo $return?1:0;die;
    }
    /**
     * 会员-个人-简历管理: 置顶简历
     */
    function top_action(){

        $id   =  trim($_POST['eid']);

        if ($_POST['s']){

            $post  =  array(
                'top'      =>  0,
                'topdate'  =>  0
            );
        }else{
            $post  =  array(
                'top'      =>  1,
                'topdate'  =>  strtotime('+'.intval($_POST['addday']).' day')
            );
        }
        $resumeM  =  $this -> MODEL('resume');

        $return   =  $resumeM -> topResume($id,$post);

        $this->ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);
    }
    /**
     * 会员-个人-简历管理: 简历备注
     */
    function label_action(){

        $id=(int)$_POST['id'];

        $post     =  array(
            'label'    => (int)$_POST['label'],
            'content'  => trim($_POST['content'])
        );

        $resumeM  =  $this -> MODEL('resume');

        $return   =  $resumeM -> label($id,$post);

        $this->ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);
    }
    /**
     * 会员-个人-简历管理: 删除简历
     */
    function delResume_action(){

        if ($_GET['del']){

            $this -> check_token();

            $id   =  intval($_GET['del']);

        }elseif ($_POST['del']){

            if(is_array($_POST['del'])){
                $id   =  $_POST['del'];
            }else{
                $id   =  explode(',',$_POST['del']);
            }

        }

        $resumeM  =  $this -> MODEL('resume');

        $return   =  $resumeM -> delResume($id,array('utype'=>'admin', 'delAccount' => $_POST['delAccount']));

        $this -> ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);
    }
    /**
     * 会员-个人-简历管理: 检测用户名重复性
     */
    function checkUsername_action(){

        $userinfoM	=	$this -> MODEL('userinfo');

        $result     =   $userinfoM -> addMemberCheck(array('username'=>trim($_POST['username'])));

        echo json_encode($result);die;
    }
    /**
     * 会员-个人-简历管理: 数据统计查询
     */
    function resumeNum_action(){

        $MsgNum = $this -> MODEL('msgNum');

        echo $MsgNum -> resumeNum();
    }

    /**
     * @desc  导出数据检测
     */
    function export_check_action(){
        session_start();

        $city_job_class = '';
        $where = '1';
        $sessionData = $_SESSION['resumeXls'] ? $_SESSION['resumeXls'] : array();
        if($sessionData){
            $city_job_class = $sessionData['city_job_class'];
            $where = $sessionData['where'];
            $order = $sessionData['order'];
        }else{
            $order = 'order by id';
        }
        if(!empty($_POST['rtype'])){
            foreach($_POST['rtype'] as $v){
                if($v == 'lastdate'){
                    $rtype[]  =  'a.lastupdate';
                }else{
                    $rtype[]  =  'a.'.$v;
                }
            }
            $rfield  =  @implode(',',$rtype).',a.uid';
        }else{
            $rfield  =  'a.uid';
        }
        $limit = '';
        if($_POST['limit']){
            $limit = "limit " . intval($_POST['limit']);
        }
        if($_POST['section']){
            $num=explode(',',$_POST['section']);
            $startNum = $num[0]-1;
            $endNum = $num[1];
            $limit = "limit {$startNum},$endNum";
        }
        if($_POST['ids']){
            // 传id参数，直接按id查，不需要考虑其他条件
            $where = 'a.id in ('. pylode(',', $_POST['ids']) .')';
            $sql = "select {$rfield} from `".$this->def."resume_expect` a where {$where} {$order} {$limit}";
        }else{
            $sql = "select {$rfield} from `".$this->def."resume_expect` a{$city_job_class} where {$where} {$order} {$limit}";
        }
        $_SESSION['resumeXlsSql'] = $sql;
        $_SESSION['resumeXlsPostRTypes'] = $_POST['rtype'];
        $resumeM  =  $this->MODEL('resume');
        $resumeNum = $resumeM->getExpectNum($where);
        if (intval($resumeNum) > 0){
            if(!empty($_POST['type'])){
                if(in_array('uid',$_POST['type'])){
                    $field  =  @implode(',',$_POST['type']);
                }else{
                    $field  =  @implode(',',$_POST['type']).',uid';
                }
            } else {
                $field = 'uid';
            }
            $_SESSION['resumeXlsFields'] = $field;
            $_SESSION['resumeXlsPostTypes'] = $_POST['type'];
            echo json_encode(['code'=> 200]);
        } else {
            echo json_encode(['code'=> 400, 'msg' => '暂无符合条件的简历数据！']);
        }
    }

    /**
     * 会员-个人-简历管理: 导出简历
     */
    function xls_action(){
        session_start();
//        $city_job_class = '';
//        $where = '1';
//        $sessionData = $_SESSION['resumeXls'] ? $_SESSION['resumeXls'] : array();
//        if($sessionData){
//            $city_job_class = $sessionData['city_job_class'];
//            $where = $sessionData['where'];
//            $order = $sessionData['order'];
//        }else{
//            $order = 'order by id';
//        }
//        if(!empty($_POST['rtype'])){
//            foreach($_POST['rtype'] as $v){
//                if($v == 'lastdate'){
//                    $rtype[]  =  'a.lastupdate';
//                }else{
//                    $rtype[]  =  'a.'.$v;
//                }
//            }
//            $rfield  =  @implode(',',$rtype).',a.uid';
//        }else{
//            $rfield  =  'a.uid';
//        }
//        $limit = '';
//        if($_POST['limit']){
//            $limit = "limit " . intval($_POST['limit']);
//        }
//        if($_POST['section']){
//            $num=explode(',',$_POST['section']);
//            $startNum = $num[0]-1;
//            $endNum = $num[1];
//            $limit = "limit {$startNum},$endNum";
//        }
//        $resumeM  =  $this -> MODEL('resume');
//
//        if($_POST['ids']){
//            // 传id参数，直接按id查，不需要考虑其他条件
//            $ids = @explode(',',$_POST['ids']);
//
//            $where = 'a.id in ('. pylode(',',$ids) .')';
//
//            $sql = "select {$rfield} from `".$this->def."resume_expect` a where {$where} {$order} {$limit}";
//        }else{
//            $sql = "select {$rfield} from `".$this->def."resume_expect` a{$city_job_class} where {$where} {$order} {$limit}";
//        }
        $sql = $_SESSION['resumeXlsSql'];
        $this->cookie->SetCookie("resumeXls",true,time() + 60);// 前台获取到该cookie值后关闭页面加载动画
        $resumeM  =  $this -> MODEL('resume');
        $listNew = $resumeM->getList(array(), array('cache' => 1, 'utype' => 'admin', 'sql' => $sql));
        $expects  =  $listNew['list'];
        $rTypes = $_SESSION['resumeXlsPostRTypes'];
        if (!empty($expects)){
            $types = $_SESSION['resumeXlsPostTypes'];
            if(!empty($types)){
                foreach($expects as $v){
                    $uids[]  =  $v['uid'];
                }
                $field = $_SESSION['resumeXlsFields'];
                $resume = $resumeM->getResumeList(array('uid'=>array('in',pylode(',', $uids))),array('field'=>$field));
            }
            foreach ($expects as $k=>$v){
                if(is_array($resume)){
                    foreach($resume as $val){
                        if($v['uid']==$val['uid']){
                            $expects[$k]['reusme'] = $val;
                            $expects[$k]['marriage_n'] = $listNew['cache']['userclass_name'][$val['marriage']];
                        }
                    }
                }
            }
            $this->yunset('list',$expects);
            $this->yunset('type',$types);
            $this->yunset('rtype',$rTypes);

            $this -> MODEL('log') -> addAdminLog('导出简历信息');
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=resume.xls");
            $this->yuntpl(array('admin/admin_resume_xls'));
        } else {
            $this -> ACT_layer_msg('暂无符合条件的简历数据！', 8, $_SERVER['HTTP_REFERER']);
        }
    }
    // 简历单个审核，带简历详情
    function resumeAudit_action(){

        $resumeM =  $this->MODEL('resume');
        $Info     =  $resumeM->getInfoByEid(array('eid'=>$_GET['id']));
        $this->yunset('Info', $Info);

        $cacheM    =  $this->MODEL('cache');
        $cacheList =  $cacheM->GetCache('user');
        $this->yunset($cacheList);

        //简历数据
        $expect = $resumeM->getExpect(array('id'=>$_GET['id']),array('field'=>'id,`uid`'));
        $return = $resumeM->getInfo(array('uid'=>$Info['uid'],'eid'=>$_GET['id'],'tb'=>'all','needCache'=>1));
        $setarr = array(
            'expect'          =>   $return['expect'],
            'edu'             =>   $return['edu'],
            'other'           =>   $return['other'],
            'project'         =>   $return['project'],
            'skill'           =>   $return['skill'],
            'training'        =>   $return['training'],
            'work'            =>   $return['work'],
            'industry_index'  =>   $return['cache']['industry_index'],
            'industry_name'   =>   $return['cache']['industry_name'],
            'userdata'        =>   $return['cache']['userdata'],
            'userclass_name'  =>   $return['cache']['userclass_name'],
            'user_sex'        =>   $return['cache']['user_sex'],
        );

        if(empty($return['cache']['city_type'])){
            $this   ->  yunset('cionly',1);
        }
        if(empty($return['cache']['job_type'])){
            $this   ->  yunset('jionly',1);
        }
        $where['uid']       =       $Info['uid'];

        $resumeinfo         =       $resumeM->getResumeInfo($where,array('logo'=>2));


        $this->yunset($setarr);
        $this->yunset('resumeinfo',$resumeinfo);
        //简历数据end

        // 待审核数量
        $snum = $resumeM->getExpectNum(array('state'=>0,'id'=>array('<>', $_GET['id'])));
        $this->yunset('snum', $snum);

        $this->yuntpl(array('admin/admin_resume_audit'));
    }

    // 简历预览
    function resumePreview_action(){

        $resumeM =  $this->MODEL('resume');

        if(!empty($_GET['id'])){// 简历ID
            $Info     =  $resumeM->getInfoByEid(array('eid'=>$_GET['id']));
        }elseif(!empty($_GET['uid'])){// 用户ID
            $where['uid']       =       $_GET['uid'];
            $resumeinfo         =       $resumeM->getResumeInfo($where,array('logo'=>2));
            $Info     =  $resumeM->getInfoByEid(array('eid'=>$resumeinfo['def_job']));
        }

        $this->yunset('Info', $Info);



        $cacheM    =  $this->MODEL('cache');
        $cacheList =  $cacheM->GetCache('user');
        $this->yunset($cacheList);

        //简历数据
        $return = $resumeM->getInfo(array('uid'=>$Info['uid'],'eid'=>$Info['id'],'tb'=>'all','needCache'=>1));
        $setarr = array(
            'expect'          =>   $return['expect'],
            'edu'             =>   $return['edu'],
            'other'           =>   $return['other'],
            'project'         =>   $return['project'],
            'skill'           =>   $return['skill'],
            'training'        =>   $return['training'],
            'work'            =>   $return['work'],
            'industry_index'  =>   $return['cache']['industry_index'],
            'industry_name'   =>   $return['cache']['industry_name'],
            'userdata'        =>   $return['cache']['userdata'],
            'userclass_name'  =>   $return['cache']['userclass_name'],
            'user_sex'        =>   $return['cache']['user_sex'],
        );

        if(empty($return['cache']['city_type'])){
            $this   ->  yunset('cionly',1);
        }
        if(empty($return['cache']['job_type'])){
            $this   ->  yunset('jionly',1);
        }

        if(empty($_GET['uid'])){
            $where['uid']       =       $Info['uid'];
            $resumeinfo         =       $resumeM->getResumeInfo($where,array('logo'=>2));
        }
        if($_GET['fromc'] == 'matching'){
            $this->yunset('matching',$_GET['fromc']);
        }
        $this->yunset($setarr);
        $this->yunset('resumeinfo',$resumeinfo);
        //简历数据end

        $this->yuntpl(array('admin/admin_resume_preview'));
    }

    public function sxLog_action()
    {

        $logM   =   $this->MODEL('log');

        $where  =   array();

        $keyStr =   trim($_GET['keyword']);
        $typeStr=   (int)$_GET['ktype'];

        if (!empty($keyStr)) {

            $rWhere =   array();

            if ($typeStr == 1) {

                $rWhere['uname']    =   array('like', $keyStr);
            } elseif ($typeStr == 2) {

                $rWhere['name']     =   array('like', $keyStr);
            }

            $resumeS    =   $logM->getResumeBySxLog($rWhere, array('field' => 'id'));

            $resumeIds  =   array();

            foreach ($resumeS as $rk => $rv) {
                if (!in_array($rv['id'], $resumeIds)) {

                    $resumeIds[]    =   $rv['id'];
                }
            }

            $where['resume_id']     =   array('in', pylode(',', $resumeIds));

            $urlarr['type']     =   $_GET['type'];
            $urlarr['keyword']  =   $_GET['keyword'];
        }

        $urlarr        			=   $_GET;
        $urlarr['c']            =   'sxLog';
        $urlarr['page']         =   '{{page}}';

        $pageurl                =   Url($_GET['m'], $urlarr, 'admin');

        $pageM  =   $this->MODEL('page');
        $pages  =   $pageM->pageList('resume_refresh_log', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {
            if ($_GET['order']) {

                $where['orderby']   =   $_GET['t'] . ',' . $_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];

            } else {

                $where['orderby']   =   'id,desc';
            }

            $where['limit'] =   $pages['limit'];

            $List           =   $logM->getSxResumeLogList($where, array('utype' => 'admin'));

            $this->yunset(array('rows' => $List));
        }
        $this->yuntpl(array('admin/admin_sx_resume_log'));
    }

    function delSxLog_action()
    {

        $this->check_token();

        $LogM   =   $this -> MODEL('log');

        if($_GET['del']){

            $id =   $_GET['del'];
        }else{

            $id =   $_GET['id'];
        }

        $arr    =   $LogM -> delSxResumeLog($id,array('utype'=>'admin'));

        $this->layer_msg($arr['msg'], $arr['errcode'], $arr['layertype'], $_SERVER['HTTP_REFERER']);
    }
}
?>