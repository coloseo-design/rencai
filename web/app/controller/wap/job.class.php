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
class job_controller extends common
{
    /**
     * 职位列表
     */
    function index_action()
    {
        $CacheM     =   $this->MODEL('cache');
        $CacheArr   =   $CacheM->GetCache(array('job', 'city', 'hy', 'com', 'uptime'));
        // 后台-页面设置-列表页区域默认设置。选择了一级城市
        if (!empty($this->config['sy_web_city_one'])) {
            $provinceid  =  $this->config['sy_web_city_one'];
            $CacheArr['city_index']  =  array($provinceid);
            $this->yunset('nocityall', 1);
            // 选择了二级城市
            if (!empty($this->config['sy_web_city_two'])) {
                $cityid  =  $this->config['sy_web_city_two'];
            }
            if (!isset($_GET['provinceid']) && !isset($_GET['cityid'])){
                if (isset($provinceid)){
                    $_GET['provinceid'] = $provinceid;
                }
                if (isset($cityid)){
                    $_GET['cityid'] = $cityid;
                }
            }
            if (isset($_GET['three_cityid'])) {
                unset($_GET['provinceid']);
                unset($_GET['cityid']);
            }
        }
        $this->yunset($CacheArr);
        
        if ($_GET['jobin']) {
            $job_classid    =   @explode(',', $_GET['jobin']);
            $jobname        =   $CacheArr['job_name'][$job_classid[0]];
            $this->yunset('jobname', mb_substr($jobname, 0, 6, 'utf-8'));
        }
        
        if (isset($_GET['ecity']) || isset($_GET['ejob'])){
            
            $pinyin  =  $CacheM->pinYin($_GET,array('city_index'=>$CacheArr['city_index'],'job_index'=>$CacheArr['job_index']));
            
            if (!empty($pinyin)){
                
                $_GET  =  array_merge($_GET,$pinyin);
            }
        }
        $searchurl  =   array();
        $searchUrlObj = array();
        foreach ($_GET as $k => $v) {
            if ($k != "") {
                $searchurl[]    =   $k."=".$v;
                $searchUrlObj[$k]    = $v;
            }
        }
        if (count($searchurl) > 1){
            $this->seo('com_search');
        }else{
            $this->seo('com');
        }
        $searchurl  =   @implode('&', $searchurl);
        $this->yunset('searchurl', $searchurl);
        $this->yunset('searchUrlObj',json_encode($searchUrlObj));

        $cityChoosed = '';
        if($_GET['three_cityid']){
            $cityChoosed = $_GET['three_cityid'];
        }else if($_GET['cityid']){
            $cityChoosed = $_GET['cityid'];
        }else if($_GET['provinceid']){
            $cityChoosed = $_GET['provinceid'];
        }
        $this->yunset('cityChoosed', $cityChoosed);

        $jobChoosed = '';
        if($_GET['job_post']){
            $jobChoosed = $_GET['job_post'];
        }else if($_GET['job1_son']){
            $jobChoosed = $_GET['job1_son'];
        }else if($_GET['job1']){
            $jobChoosed = $_GET['job1'];
        }
        $this->yunset('jobChoosed', $jobChoosed);

        if ($this->uid && $this->usertype == 1) {
            $lookJobIds    =   @explode(',', $_COOKIE['lookjob']);
            $this->yunset("lookJobIds", $lookJobIds);
        }
        $this->yunset('backurl', Url('wap'));
        $this->yunset('headertitle', '职位搜索');
        $this->yunset('topplaceholder', '请输入职位关键字,如：会计...');

        $this->yuntpl(array('wap/job')); 
        
        
    }

    function search_action()
    {
        
        $this->index_action();
    }

    /**
     * 职位详情
     * 2019-06-20
     */
    function comapply_action()
    {
        $id = intval($_GET['id']);
        if (empty($id)) {
            $this->ACT_msg_wap($_SERVER['HTTP_REFERER'], '参数错误！', 2, 5);
        }
        
        // 收藏 申请职位
        $typeStr    =   trim($_GET['type']);

        if (!empty($typeStr)) {

            $this -> typeJob($typeStr, $id,intval($_GET['eid']));
        }

        $JobM       =   $this->MODEL('job');
        $companyM   =   $this->MODEL('company');
        $uid        =   $this->uid;

        $jobField   =   array('com'=>'yes', 'link'=>1, 'uid'=>$this->uid, 'usertype'=>$this->usertype);

        $job        =   $JobM -> getInfo(array('id' => $id), $jobField);
        $CompanyaccountM  =   $this->MODEL('companyaccount');
		$department	=	$CompanyaccountM ->getInfo(array('uid'=>$job['zuid']),array('field'=>'`uid`,`name`'));
        $this->yunset('department', $department['name']);

        $userinfoM  =   $this->MODEL('userinfo');
        $member     =   $userinfoM->getInfo(array('uid' => $job['uid']), array('field' => '`login_date`'));
        $job['login_date'] = $member['login_date'];

        // 联系方式
        $this->yunset('link', $job['linkInfo']);
        
        if ($this->uid == $job['uid']) {
            if ($job['state'] == 2) {
                $this->yunset('entype', 1);
            }
        } else {
            
            if ($job['r_status'] == 0 || $job['r_status'] == 3) {
                $this->ACT_msg_wap($_SERVER['HTTP_REFERER'], '企业暂未通过审核！');
            } elseif ($job['r_status'] == 2 || $job['r_status'] == 4) {
                $this->ACT_msg_wap($_SERVER['HTTP_REFERER'], '企业已被锁定！');
            }
            
            if ($job['state'] == 0) {
                $this->ACT_msg_wap($_SERVER['HTTP_REFERER'], '职位审核中！', 2, 5);
            } elseif ($job['state'] == 2) {
                $this->yunset('entype', 1);
            } elseif ($job['state'] == 3) {
                $this->ACT_msg_wap($_SERVER['HTTP_REFERER'], '该职位未通过审核！', 2, 5);
            } 
        }

        $JobM->addJobHits($id);
        $hits   =   $JobM->getInfo(array('id' => $id), array('field' => '`uid`, `jobhits`'));
        $job['jobhits']     =   $hits['jobhits'];
        // 投递数量
        $UJWhere['uid']     =   $this->uid;
        $UJWhere['job_id']  =   $id;
        $UJWhere['isdel']   =   9;
        $userid_job         =   $JobM->getSqJobNum($UJWhere);

        // 收藏数量
        $FJWhere['uid']     =   $this->uid;
        $FJWhere['job_id']  =   $id;
        $FJWhere['type']    =   '1';
        $fav_job            =   $JobM->getFavJobNum($FJWhere);

        // 邀请面试数量
        $invite_job         =   $JobM->getYqmsNum(array('jobid' => $id,'uid' => $this->uid,'isdel'=>9));

        // 举报数量
        $reportM            =   $this->MODEL('report');
        $report_job         =   $reportM->getNum(array('eid' => $id, 'p_uid' => $this->uid, 'c_uid' => $job['uid']));

        // 面试评价
        $company_msg        =   $companyM->getCompanyMsgInfo(array('jobid' => $id,'status'=>1), array('field' => '`content`'));
        $this->yunset('company_msg', $company_msg);

        $job['userid_job']  =   $userid_job;
        $job['invite_job']  =   $invite_job;
        $job['fav_job']     =   $fav_job;
        $job['report_job']  =   $report_job;

        // 解决通过Editor上传的图片路径问题
        $job['description'] =   str_replace(array("ti<x>tle","“","”"), array("title"," "," "), $job['description']);
        $job['description'] =   htmlspecialchars_decode($job['description']);
        
        preg_match_all('/<img(.*?)src=("|\'|\s)?(.*?)(?="|\'|\s)/', $job['description'], $res);
        
        if (!empty($res[3])) {
            foreach ($res[3] as $v) {
                if (strpos($v, 'http:') === false && strpos($v, 'https:') === false) {
                    $ossv = checkpic($v);
                    $job['description'] = str_replace($v, $ossv, $job['description']);
                }
            }
        }

        // 回复率
        $allnum     =   $JobM->getSqJobNum(array('job_id' => $id,'isdel'=>9));

        $replynum   =   $JobM->getSqJobNum(array('job_id' => $id,'isdel'=>9,'is_browse' => array('>', 1)));
        if ($allnum == 0) {
            $job['pre'] = 100;
        } else {
            $job['pre'] = round(($replynum / $allnum) * 100);
        }
        $job['snum']    =   $allnum;

        // 会员等级
        $ratingM    =   $this -> MODEL('rating');
        $comrat     =   $ratingM -> getInfo(array('id' => intval($job['rating'])), array('pic' => '1'));

        // 查询咨询记录记录
        $msgM       =   $this->MODEL('msg');
        $msgList    =   $msgM->getList(array('jobid' => $id,'job_uid' => $job['uid'],'status'=>1,'reply' => array('<>', ''), 'orderby' => 'datetime,desc', 'limit' => 5));
        $this->yunset('msgList', $msgList['list']);

        // 获取悬赏职位
        if ($job['rewardpack'] == 1) {
            $packM      =   $this->MODEL('pack');
            $reward     =   $packM->getRewardJobInfo($id);
            $reward['money']        =   floatval($reward['money']);
            $reward['sqmoney']      =   floatval($reward['sqmoney']);
            $reward['invitemoney']  =   floatval($reward['invitemoney']);
            $reward['offermoney']   =   floatval($reward['offermoney']);
            $this->yunset('reward', $reward);
        }

        if (strpos($_SERVER['HTTP_REFERER'], 'ajaxreward') || strpos($_SERVER['HTTP_REFERER'], 'sqreward') || $_GET['tolist']) {
            $backurl    = Url('wap', array('c' => 'job'));
            $this->yunset('backurl', $backurl);
        }
        // 获取seo使用的数据
        $data['job_name']       =   $job['jobname']; // 职位名称
        $data['company_name']   =   $job['com_name']; // 公司名称
        $data['industry_class'] =   $job['hy_n']; // 所属行业
        $data['job_class']      =   $job['job_one'] . ',' . $job['job_two'] . ',' . $job['job_three']; // 职位名称
        $data['job_salary']     =   $job['job_salary']; // 职位薪资
        $job_desc       =   $this->GET_content_desc($job['description']); // 描述
        $data['job_desc'] = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/", "", $job_desc);
        
        $this->data = $data;
        $this->seo('comapply');
        
        $this->yunset('job', $job);
        $this->yunset('comrat', $comrat);
        $this->yunset('headertitle', '职位详情');
        if($this->config['sy_h5_share']==1){
          $this->yunset('shareurl', Url('wap', array('c' => 'job', 'a' => 'share', 'id' => $id )));
        }else{
          $this->yunset("shareurl",Url('wap',array('c'=>'job','a'=>'comapply','id'=>$id)));
        }

        $user_agent = (! isset($_SERVER['HTTP_USER_AGENT'])) ? FALSE : $_SERVER['HTTP_USER_AGENT'];
        
        if ($_COOKIE['mapx'] > 0 && $_COOKIE['mapy'] > 0 && strpos($user_agent, 'Android') && is_weixin()) {
            
            $this->yunset(array('mapx' => $_COOKIE['mapx'], 'mapy' => $_COOKIE['mapy'] ));
        } else {
            
            $this->yunset(array('mapx' => 0, 'mapy' => 0));
        }
        if($this->uid && $this->usertype==1){
            $ResumeM    =   $this->MODEL('resume');
            $resumenum  =   $ResumeM->getExpectNum(array('uid'=>$this->uid,'status'=>1,'state'=>1,'r_status'=>1));
            $this->yunset('resumenum', $resumenum);
        }
        
        if (isset($this->config['sy_spview_web']) && $this->config['sy_spview_web'] == 1){
            //包含此职位且可预约的视频面试
            $spviewM        =   $this->MODEL('spview');
            
            $yytime         =   time()+($this->config['sy_spview_yytime']*3600);
            
            $spviewWhere    =   array(
                
                'starttime' =>  array('>',$yytime),
                'status'    =>  1,
                'jobid'     =>  array('findin',$id),
                'roomstatus'=>  0
            );
            
            $spview         =   $spviewM->getInfo($spviewWhere,array('field'=>'id'));
            $this->yunset('spid',$spview['id']);
        }

        if ($this->config['sy_haibao_isopen'] == 1) {

            $WhbM       =   $this->MODEL('whb');
            $syJobHb    =   $WhbM->getWhbList(array('type' => 1, 'isopen' => '1'));
            $this->yunset('hbNum', count($syJobHb));
            if (!empty($syJobHb)) {
                $hbids  =   array();
                foreach ($syJobHb as $hk => $hv) {
                    $hbids[]    =   $hv['id'];
                }
                $this->yunset('hbids', $hbids);
            }
        }

        $wxpubtempM     =   $this->MODEL('wxpubtemp');
        $wxpubtemp_html =   $wxpubtempM->getOneJob($job['id'], 'wap');
        $this->yunset('wxpubtemp_html',$wxpubtemp_html);

        $this->yuntpl(array('wap/job_show'));
    }
	//兼容以前版本链接
	function view_action(){
		if($_GET['id']){
			header('HTTP/1.1 301 Moved Permanently');
			header('Location: '.Url('wap',array('c'=>'job','a'=>'comapply','id'=>$_GET['id'])));//
		}
	}
    // 收藏 申请职位
    private function typeJob($typeStr, $id,$eid='')
    {
        $JobM   =   $this->MODEL('job');

        $data   =   array('uid' => $this->uid, 'usertype' => $this->usertype, 'did' => $this->userdid, 'job_id' => $id);

        if ($typeStr == 'sq') {
			if($eid){
				$data['eid']=	$eid;
			}
			$data['port']	=	'2';
            $res	=	$JobM->applyJob($data);
            
            $res['state']  =  $res['errorcode'];
            
        } elseif ($typeStr == 'fav') {
            
            $res = $JobM->collectJob($data);
        }

        if ($res['errorcode'] != 9) {
            $res['url'] = empty($res['url']) ? $_SERVER['HTTP_REFERER'] : $res['url'];
        }
        echo json_encode($res);
        die();
    }

    /**
     * 职位举报
     */
    function report_action()
    {
        session_start();

        $reportM    =   $this->MODEL('report');
        $jobM       =   $this->MODEL('job');
        
        if ($this->usertype != '1') {
            $data['url']    =   $_SERVER['HTTP_REFERER'];
            $data['msg']    =   '只有个人会员才可举报！';
            echo json_encode($data);
            die();
        }
        if (md5(strtolower($_POST['authcode'])) != $_SESSION['authcode'] || empty($_SESSION['authcode'])) {
            unset($_SESSION['authcode']);
            $data['url'] = $_SERVER['HTTP_REFERER'];
            $data['msg'] = '验证码错误！';
            echo json_encode($data);
            die();
        }
        $job    =   $jobM->getInfo(array('id' => intval($_POST['id'])), array('field' => '`uid`,`com_name`'));

        $row    =   $reportM -> getReportOne(array('p_uid' => $this->uid, 'eid' => (int) $_POST['id'], 'c_uid' => $job['uid'], 'usertype' => $this->usertype));

        if (is_array($row)) {
            $data['url']    =   $_SERVER['HTTP_REFERER'];
            $data['msg']    =   '您已举报过该用户！';
            echo json_encode($data);
            die();
        }
        
        $data   =   array(
            'c_uid'         =>  $job['uid'],
            'inputtime'     =>  time(),
            'p_uid'         =>  $this->uid,
            'usertype'      =>  (int) $this->usertype,
            'eid'           =>  (int) $_POST['id'],
            'r_name'        =>  $job['com_name'],
            'username'      =>  $this->username,
            'r_reason'      =>  $this->stringfilter($_POST['reason']),
            'did'           =>  $this->userdid
        );

        $nid    =   $reportM -> addJobReport($data);
        
        if ($nid) {
            $data['url']    =   $_SERVER['HTTP_REFERER'];
            $data['msg']    =   '举报成功！';
            echo json_encode($data);
            die();
        } else {
            $data['url']    =   $_SERVER['HTTP_REFERER'];
            $data['msg']    =   '举报失败！';
            echo json_encode($data);
            die();
        }
    }

    /**
     * 快速申请
     */
    function applyjobuid_action()
    {
        include CONFIG_PATH.'db.data.php';
        unset($arr_data['sex'][3]);
        $this->yunset('sexData', $arr_data['sex']);
        
        $JobM   =   $this -> MODEL('job');
        $job    =   $JobM -> getInfo(array('id' => $_GET['jobid']));
        $this->yunset('job', $job);

        $data['job_name']       =   $job['name']; // 职位名称
        $data['company_name']   =   $job['com_name']; // 公司名称
        $data['job_desc']       =   $this->GET_content_desc($job['description']); // 描述
        $data['industry_class'] =   $job['job_hy']; // 所属行业
        $data['job_class']      =   $job['job_one'] . "," . $job['job_two'] . "," . $job['job_three'];
        $data['job_salary']     =   $job['job_salary'];
        $this->data = $data;
        $this->seo('comapply');

        $this->yunset('headertitle', '快速申请');
        $this->yuntpl(array('wap/applyjobuid'));
    }

    /**
     * 职位详情
     * 分享数量
     * 2019-06-21
     */
    function share_action()
    {
        $id     =   intval($_GET['id']);
        $this->get_moblie();

        $JobM   =   $this->MODEL('job');
        $CacheM =   $this->MODEL('cache');
        $CacheArr   =   $CacheM->GetCache(array('job', 'city', 'hy', 'com'));

        $jobField   =   array('com'=>'yes', 'link'=>1, 'uid'=>$this->uid, 'usertype'=>$this->usertype);
        $job        =   $JobM->getInfo(array('id' => $id), $jobField);
        $job['content']     =   strip_tags($job['content']);
        $job['description'] =   strip_tags($job['description'], '<br>');	
        $this->yunset('job', $job);

        $this->yunset('link', $job['linkInfo']);

        $this->yunset($CacheArr);
        
        $data['job_name']       =   $job['jobname']; // 职位名称
        $data['company_name']   =   $job['com_name']; // 公司名称
        $data['industry_class'] =   $job['job_hy']; // 所属行业
        $data['job_class']      =   $job['job_one'] . ',' . $job['job_two'] . ',' . $job['job_three']; // 职位名称
        $data['job_desc']       =   $this->GET_content_desc($job['description']); // 描述
        $data['job_salary']     =   $job['job_salary'];
        $this->data = $data;
        $this->seo('comapply');

        $this->yunset('headertitle', $job['name'].'-'.$job['com_name'].'-'.$this->config['sy_webname']);

        $this->yunset('job_style', $this->config['sy_weburl'] . '/app/template/wap/job');
        $this->yuntpl(array('wap/job/index'));
    }

    /**
     * 职位详情
     * 浏览数量
     * 2019-06-21
     */
    function GetHits_action()
    {
        $id     =   intval($_GET['id']);
        if (empty($id)) {
            echo 'document.write(0)';
        }
        $JobM   =   $this->MODEL('job');
        $JobM->addJobHits($id);

        $hits   =   $JobM->getInfo(array('id' => $id), array('field' => '`uid`, `jobhits`'));
        echo 'document.write(' . $hits['jobhits'] . ')';
    }

    /**
     * 职位详情
     * 求职咨询
     * 2019-06-12
     */
    function msg_action()
    {
        $_POST  =   $this->post_trim($_POST);
        
        $_POST['uid']       =   $this->uid;
        $_POST['username']  =   $this->username;
        $_POST['usertype']  =   $this->usertype;
        
        $msgM   =   $this->MODEL('msg');
        $res    =   $msgM->addMsg($_POST);

        $res['url']     =   empty($res['url']) ? $_SERVER['HTTP_REFERER'] : $res['url'];
        echo json_encode($res);
        die();
    }

    /**
     * 企业位置
     */
    function jobmap_action()
    {
        $this->get_moblie();

        $comid      =   intval($_GET['id']);
        $companyM   =   $this->MODEL('company');
        $com        =   $companyM->getInfo($comid, array('field' => '`uid`,`name`,`cityid`,`address`,`x`,`y`'));
        $this->yunset('com', $com);

        $CacheM     =   $this->MODEL('cache');
        $CacheArr   =   $CacheM->GetCache(array('city'));
        $cityname   =   $CacheArr['city_name'][$com['cityid']];
        $this->yunset('cityname', $cityname);

        $user_agent =   (! isset($_SERVER['HTTP_USER_AGENT'])) ? FALSE : $_SERVER['HTTP_USER_AGENT'];

        if (($_COOKIE['mapx'] && $_COOKIE['mapx'] > 0) && ($_COOKIE['mapy'] && $_COOKIE['mapy'] > 0) && strpos($user_agent, 'Android') && is_weixin()) {

            $this->yunset(array('mapx' => $_COOKIE['mapx'], 'mapy' => $_COOKIE['mapy']));
            
        } else {
            
            $this->yunset(array('mapx' => 0, 'mapy' => 0));
        }
        $this->yunset('title', '企业位置');
        $this->yunset('headertitle', '企业位置');
        $this->yuntpl(array('wap/job_map'));
    }

    // 安卓微信浏览器保存定位。
    function distance_action()
    {
        $x  =   $_POST['x'];
        $y  =   $_POST['y'];
        $this->cookie->setcookie('mapx', $x, time() + 1800);
        $this->cookie->setcookie('mapy', $y, time() + 1800);
    }

    /**
     * 求职竞争力分析
     */
    function compete_action()
    {
        if ($_GET['id']) {

            if (! $this->uid) {

                $this -> ACT_msg_wap(Url('wap', array('c' => 'login')), '请先登录！', 2, 5);
                
            } elseif ($this->usertype != '1') {

                $this->ACT_msg_wap(Url('wap') . 'member/', '请先切换为求职者身份！', 2, 5);
                
            } else {
                
                $competeM   =   $this->MODEL('compete');

                $List       =   $competeM->userJob($this->uid, (int) $_GET['id'], $this->usertype);

                if ($List['errcode'] == '1') {

                    $this->yunset('title', '求职竞争力分析-'.$this->config['sy_webname']);
                    $this->yunset('headertitle', '求职竞争力');
                    $this->yunset('List', $List);
                    $this->yuntpl(array('wap/usercompete'));
                } else {
                    
                    if ($List['errcode'] == '2') {

                        $this -> ACT_msg_wap(Url('wap', array('c' => 'job', 'a' => 'comapply', 'id' => (int) $_GET['id'] )), '关注人数较少，暂无足够样本用于数据分析！', 2, 5);
                        
                    } elseif ($List['errcode'] == '4') {

                        $this->ACT_msg_wap(Url('wap') . 'member/index.php?c=addresume', '请先创建一份完善的简历！', 2, 5);
                    }
                }
            }
        } else {

            $this->ACT_msg_wap($_SERVER['HTTP_REFERER'], '请选择正确的信息！', 2, 5);
        }
    }

    /**
     * 浏览历史记录
     */
    function history_action(){
        
        if ($_POST['id'] && $this->usertype == 1) {
            
            $id     =   intval($_POST['id']);
            
            $time   =   time();
            
            $cookieM        =   $this->MODEL('cookie');
            $cookieJobIds   =   $_COOKIE['lookjob'];
            
            if ($cookieJobIds) {
                $jobArr = @explode('-', $cookieJobIds);
                if (!in_array($id, $jobArr)) {
                    $lookJobIds =   $cookieJobIds."-".$id;
                }else{
                    $lookJobIds =   $cookieJobIds;
                }
            }else{
                $lookJobIds =   $id;
            }
            
            $cookieM -> setcookie('lookjob', $lookJobIds, time()+3600);
            // 增加职位浏览记录
            $JobM   =   $this->MODEL('job');
            $JobM -> addLookJob(array('uid' => $this->uid, 'jobid' => $id, 'datetime' => $time,'did' => $this->userdid));
        }
    }

    /**
     * 微信内上拉加载
     */
    function ajaxLoad_action(){
        
        $param = array();
        $searchurl = explode('&', $_POST['searchurl']);
        foreach ($searchurl as $v){
            $p = explode('=', $v);
            $param[$p[0]] = $p[1];
        }
        $page  = $_POST['page'];
        $limit = 20;
        
        $where['state']		=	1;
        $where['status']	=	0;
        $where['r_status']	=	1;
        $provinceid			=	(int)$param['provinceid'];
        $cityid				=	(int)$param['cityid'];
        $three_cityid		=	(int)$param['three_cityid'];
        $job1				=	(int)$param['job1'];
        $job1_son			=	(int)$param['job1_son'];
        $job_post			=	(int)$param['job_post'];
        $exp				=	(int)$param['exp'];
        $hy					=	(int)$param['hy'];
        $pr					=	(int)$param['pr'];
        $mun				=	(int)$param['mun'];
        $edu				=	$param['edu'];
        
        $sdate				=	$param['sdate'];
        $edate				=	$param['edate'];
        
        $keyword		    =	$this->stringfilter($param['keyword']);
        
        $order				=	$param['order'];
        $state				=	(int)$param['state'];
        $rec 				=	(int)$param['rec'];
        
        $jfield   =  '`id`,`uid`,`name`,`provinceid`,`cityid`,`exp`,`edu`,`welfare`,`minsalary`,`maxsalary`,`lastupdate`,`com_name`,`sdate`,`rec`,`rec_time`,`urgent`,`urgent_time`,`xsdate`,`rating`,`zuid`';
        
        if($_POST['x'] && $_POST['y']){
            $jfield .= ", 6371 * acos(cos(radians(" . $_POST['y'] . ")) * cos(radians(`y`)) * cos(radians(`x`) - radians(" . $_POST['x'] . ")) + sin(radians(" . $_POST['y'] . ")) * sin(radians(`y`))) AS `distance`";
            $order = 'distance, asc';

            $where['x']  =   array('>',0);
            $where['y']  =   array('>',0);
        }

        if($param['state']){
            if($param['state']==2){
                $where['edate']	=	array('<',time());
            }elseif($param['state']==4){
                $where['state']	=	'0';
            }else{
                $where['state']	=	$param['state'];
            }
        }
        if($param['cuid']){
            $where['uid']		=	$param['cuid'];
        }
        if($param['urgent']){
            $where['urgent_time']=	array('>',time());
        }
        if($edu){
            $where['edu']		=	$edu;
        }
        if($param['r_status']){
            $where['r_status']	=	(int)$param['r_status'];
        }
        if($param['status']){
            $where['status']	=	(int)$param['status'];
        }
        if($rec==1){
            //老版的推荐排序为 优先排会员且按rec_time排序，此处暂时参照wap
            $where['rec_time']	=	array('>=',time());
        }
        if($hy){//类别ID
            $where['hy']		=	$hy;
        }
        if($pr){//类别ID
            $where['pr']		=	$pr;
        }
        if($mun){//类别ID
            $where['mun']		=	$mun;
        }
        if($exp){
            $where['exp']		=	$exp;
        }
        if($provinceid){//类别ID
            $where['provinceid']=	$provinceid;
        }
        if($cityid){//类别ID
            $where['cityid']	=	$cityid;
        }
        if($three_cityid){//类别ID
            $where['three_cityid']	=	$three_cityid;
        }
        
        if($job1){//类别ID
            $where['job1']		=	$job1;
        }
        if($job1_son){//类别ID
            $where['job1_son']	=	$job1_son;
        }
        if($job_post){//类别ID
            $where['job_post']	=	$job_post;
        }
        if($sdate){//开始时间
            $where['lastupdate']=	array('>',strtotime($sdate));
        }
        if($edate){//结束时间
            $where['lastupdate']=	array('<',strtotime($edate));
        }
        if($param['sex']){
            $where['sex']		=	$param['sex'];
        }
        if($param['uptime']){//更新时间
            if($param['uptime']==1){
                $where['lastupdate']=	array('>',strtotime(date('Y-m-d 00:00:00')));
            }else{
                $where['lastupdate']=	array('>',strtotime('-'.$param['uptime'].' day'));
            }
        }
        if($keyword){//关键字
            $cache	=	$this	->	MODEL('cache')->GetCache('city');
            $cityid	=	array();
            foreach($cache['city_name'] as $k=>$v){
                if(strpos($v,$keyword)!==false){
                    $cityid[]	=	$k;
                }
            }
            
            
            $where['PHPYUNBTWSTART_A']	=	'';
            $where['name']				=	array('like',$keyword);
            $where['com_name']			=	array('like',$keyword,'OR');
            if (!empty($cityid)){
                $where['provinceid']	=	array('in',pylode(',',$cityid),'OR');
                $where['cityid']		=	array('in',pylode(',',$cityid),'OR');
            }
            $where['PHPYUNBTWEND_A']	=	'';
        }
        if ($param['salary']){
            $salaryArr  =  $this->salaryArr(true);
            $salary     =  $salaryArr[$param['salary']];
            
            if ($salary['minsalary'] > 0 && $salary['maxsalary'] > 0){
                
                $where['PHPYUNBTWSTART_A']  =  '';
                $where['minsalary'][]       =  array('>=', $salary['minsalary']);
                $where['minsalary'][]       =  array('<=', $salary['maxsalary']);
                $where['maxsalary']         =  array('<=', $salary['maxsalary']);
                $where['PHPYUNBTWEND_A']	=	'';
                
            } elseif ($salary['minsalary'] > 0 && $salary['maxsalary'] == 0){
                
                $where['minsalary']         =  array('>=', $salary['minsalary']);
                
            } elseif ($salary['minsalary'] == 0 && $salary['maxsalary'] > 0){
                
                $where['minsalary']         =  array('<=', $salary['maxsalary']);
                $where['maxsalary']         =  array('<=', $salary['maxsalary']);
            }
        }
        // 处理分站查询条件
        if ($this->config['sy_web_site'] == 1){
            
            if ($this->config['province'] > 0){
                $where['provinceid']  =  $this->config['province'];
            }
            if ($this->config['cityid'] > 0){
                $where['cityid']  =  $this->config['cityid'];
            }
            if ($this->config['three_cityid'] > 0){
                $where['three_cityid']  =  $this->config['three_cityid'];
            }
            if ($this->config['hyclass'] > 0){
                $where['hy']  =  $this->config['hyclass'];
            }
        }
        
        if($order){//排序
            $where['orderby']	=	$order;
        }else{
            $where['orderby']	=	'lastupdate,desc';
        }
        if($page){//分页
            $pagenav		=	($page-1)*$limit;
            $where['limit']	=	array($pagenav,$limit);
        }else{
            $where['limit']	=	$limit;
        }
        


        $jobM     =  $this->MODEL('job');
        
        $jobrows  =  $jobM	->	getList($where,array('field'=>$jfield,'utype'=>'wxapp','isurl'=>'yes'));
        
        $joblist  =  $jobrows['list'];

        foreach ($joblist as $k => $v) {
            if(isset($v['distance'])){
                if ($v['distance'] <= 1) {
                    $joblist[$k]['dis'] = ceil($v['distance'] * 1000) . 'm';
                } else {
                    $joblist[$k]['dis'] = round($v['distance'], 2) . 'km';
                }
            }
        }

        $data['list']  =  !empty($joblist) ? $joblist : array();
        
        if ($this->uid && $this->usertype == 1) {
            $data['lookJobIds']  =  @explode(',', $_COOKIE['lookjob']);
        }
        
        echo json_encode($data);die;
    }
    //微信扫码查看联系方式
    function telQrcode_action(){
        
        $WxM	=	$this -> MODEL('weixin');
        
        $qrcode =	$WxM->pubWxQrcode('jobtel',$_GET['id']);
        if(isset($qrcode)){
            
            $imgStr  =	CurlGet($qrcode);
            
            header("Content-Type:image/png");
            
            echo $imgStr;
        }
    }
    // 获取职位联系方式
    function getLink_action(){
        
        $JobM    =  $this->MODEL('job');
        $link	 =  $JobM->getCompanyJobTel(array('id'=>$_POST['jobid'],'uid'=>$this->uid,'usertype'=>$this->usertype,'isgetprv'=>$this->config['sy_comprivacy_open']));
        
        $link['data']['errorcode'] = $link['errorcode'];
        $link['data']['msg']       = $link['msg'];
        
        echo json_encode($link['data']);die;
    }
}
?>