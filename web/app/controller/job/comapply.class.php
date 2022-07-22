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
class comapply_controller extends job_controller
{

    /**
     * 职位详情
     * 2019-06-12
     */
    function index_action()
    {
        $id = intval($_GET['id']);
        if (empty($id)) {
            $this->ACT_msg($_SERVER['HTTP_REFERER'], '参数错误！');
        }

        $JobM       =   $this->MODEL('job');
        $ComM       =   $this->MODEL('company');
        $statisM    =   $this->MODEL('statis');
        $RatingM    =   $this->MODEL('rating');
        $userinfoM  =   $this->MODEL('userinfo');
        $CompanyaccountM  =   $this->MODEL('companyaccount');

        $jobField   =   array('com'=>'yes', 'link'=>1, 'uid'=>$this->uid, 'usertype'=>$this->usertype);
        $JobInfo    =   $JobM->getInfo(array('id' => $id), $jobField);
        $recjobnum  =   $JobM->getJobNum(array('state'=>1,'r_status'=>1,'status'=>0,'job1'=>$JobInfo['job1'],'id'=>array('<>',$JobInfo['id'])));
        $this->yunset('recjobnum',$recjobnum);

		$department	=	$CompanyaccountM ->getInfo(array('uid'=>$JobInfo['zuid']),array('field'=>'`uid`,`name`'));
        $this->yunset('department', $department['name']);
        $viplist    =   $statisM->getInfo($JobInfo['uid'], array('usertype' => 2,'field' => '`vip_etime`,`rating`'));
        $comrat     =   $RatingM->getInfo(array('id' => $viplist['rating']), array('pic' => '1'));
        $this->yunset('comrat', $comrat);
        if (isVip($viplist['vip_etime'])) {

            $eviplist   =   1; // 表示未过期
        } else {

            $eviplist   =   2; // 表示已过期
        }
        $this->yunset('eviplist', $eviplist);
        
        // 联系方式
        $this->yunset('link', $JobInfo['linkInfo']);
        
        if(empty($JobInfo)){
            $this->ACT_msg($this->config['sy_weburl'], '职位不存在!');
        }else{
            // 管理员查看
            $look = isset($_GET['look']) && $_GET['look'] == 'admin' && !empty($_SESSION['auid']) ? 'admin' : '';
            if ($look != 'admin') {
                // 职位状态判断
                if (empty($this->uid) || $this->uid != $JobInfo['uid']) {
                    
                    if ($JobInfo['r_status'] == 0 || $JobInfo['r_status'] == 3) {
                        $this->ACT_msg($this->config['sy_weburl'], '企业暂未通过审核！');
                    } elseif ($JobInfo['r_status'] == 2 || $JobInfo['r_status'] == 4) {
                        $this->ACT_msg($this->config['sy_weburl'], '企业已被锁定！');
                    }elseif ($JobInfo['state'] == 0) {
                        $this->ACT_msg($_SERVER['HTTP_REFERER'], '职位审核中！');
                    } elseif ($JobInfo['state'] == 3) {
                        $this->ACT_msg($_SERVER['HTTP_REFERER'], '该职位未通过审核！');
                    }
                }
            }
        }


        $member     =   $userinfoM->getInfo(array('uid' => $JobInfo['uid']), array('field' => '`login_date`'));
        $JobInfo['login_date']  =   $member['login_date'];

        if ($JobInfo['status'] == 1) {
            $this->yunset('stop', 1);
        }


        // 有管理员登录信息时，设置state为1
        if (!empty($_SESSION['auid'])) {
            $adminM =   $this->MODEL('admin');
            $row    =   $adminM->getAdminUser(array('uid' => array('=', $_SESSION['auid'])));
            if (!empty($row) && $_SESSION['ashell'] == md5($row['username'].$row['password'].$this->md)) {
                $JobInfo['state'] = 1;
            }
        }

        $CacheM     =   $this->MODEL('cache');
        $CacheList  =   $CacheM->GetCache(array('job', 'city', 'com'));
        $this->yunset($CacheList);

        /* 个人会员登录状态 */
        if ($this->uid && $this->usertype == 1) {

            $UJWhere['uid']     =   $this->uid;
            $UJWhere['job_id']  =   $id;
            $UJWhere['isdel']   =   9;
            $userIdJobNum       =   $JobM -> getSqJobNum($UJWhere);
            if ($userIdJobNum > 0) {
                $this->yunset('userIdJobNum', $userIdJobNum);
            }

            $FJWhere['uid']     =   $this->uid;
            $FJWhere['job_id']  =   $id;
            $FJWhere['type']    =   '1';
            $favJobNum          =   $JobM -> getFavJobNum($FJWhere);
            if ($favJobNum > 0) {
                $this->yunset('favJobNum', $favJobNum);
            }

            $this->yunset('usertype', '1');

            $ResumeM    =   $this->MODEL('resume');
            $resumenum  =   $ResumeM->getExpectNum(array('uid'=>$this->uid,'status'=>1,'state'=>1,'r_status'=>1));
            $this->yunset('resumenum', $resumenum);
        }

        // 查询求职咨询信息
        $msgM       =   $this->MODEL('msg');
        $msgList    =   $msgM->getList(array('jobid' => $id, 'job_uid' => $JobInfo['uid'], 'reply' => array('<>',''), 'orderby' => 'datetime,desc', 'limit' => 5));
        $this->yunset('msgList', $msgList['list']);

        // 获取该职位的面试信息
        $company_msg    =   $ComM->getCompanyMsgInfo(array('jobid' => $id,'status'=>1), array('field' => '`content`'));
        if (!empty($company_msg)) {
            $this->yunset('company_msg', $company_msg);
        }

        // 投递数量
        $allnum     =   $JobM->getSqJobNum(array('job_id' => $id,'isdel'=>9));
        $replynum   =   $JobM->getSqJobNum(array('job_id' => $id,'isdel'=>9,'is_browse' => array('>', 1)));
        if ($allnum == 0) {
            $JobInfo['pre'] = 100;
        } else {
            $JobInfo['pre'] = round(($replynum / $allnum) * 100);
        }
        $JobInfo['snum'] = $allnum;

        $this->yunset('Info', $JobInfo);

        // 获取悬赏数据
        if ($JobInfo['rewardpack'] == 1) {
            $packM  =   $this->MODEL('pack');
            $reward =   $packM->getRewardJobInfo($id);
            $reward['money']        =   floatval($reward['money']);
            $reward['sqmoney']      =   floatval($reward['sqmoney']);
            $reward['invitemoney']  =   floatval($reward['invitemoney']);
            $reward['offermoney']   =   floatval($reward['offermoney']);
			$needs	=	array();
			if($reward['exp'] == '1'){$needs[]		=	'工作经历';}
			if($reward['edu'] == '1'){$needs[]		=	'教育经历';}
			if($reward['project'] == '1'){$needs[]	=	'项目经历';}
			if($reward['skill'] == '1'){$needs[]	=	'技能证书';}
			if(!empty($needs)){
				$reward['needs']	=	@implode('，', $needs);
			}
            $this->yunset('reward', $reward);
        }

        // 判断当天推荐职位、简历数是否已满
        if ($this->uid && isset($this->config['sy_recommend_day_num']) && $this->config['sy_recommend_day_num'] > 0) {

            $recomM =   $this->MODEL('recommend');
            $num    =   $recomM->getRecommendNum(array('uid' => $this->uid));

            if ($num >= $this->config['sy_recommend_day_num']) {
                $this->yunset('sy_recommend_day_num', $this->config['sy_recommend_day_num']);
            }
        }

        // 两次推荐职位、简历的最小时间间隔
        $recommendInterval = isset($this->config['sy_recommend_interval']) ? $this->config['sy_recommend_interval'] : 0;
        $this->yunset('recommendInterval', $recommendInterval);

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

        $WhbM       =   $this->MODEL('whb');

        $syJobHb    =   $WhbM->getWhbList(array('type' => 1, 'isopen' => 1));
        
        $this->yunset('hbNum', count($syJobHb));
        if(!empty($syJobHb)){
            $hbids = array();
            foreach ($syJobHb as $hk => $hv) {
                $hbids[] = $hv['id'];
            }
            $this->yunset('hbids', $hbids);
        }
        

        // 获取seo使用的数据
        $data['job_name']       =   $JobInfo['jobname']; // 职位名称
        $data['company_name']   =   $JobInfo['com_name']; // 公司名称
        $data['industry_class'] =   $JobInfo['hy_n']; // 所属行业
        $data['job_class']      =   $JobInfo['job_one'].','.$JobInfo['job_two'].','.$JobInfo['job_three']; // 职位名称
        $data['job_salary']     =   $JobInfo['job_salary']; // 职位薪资
        $data['job_desc']       =   $this->GET_content_desc($JobInfo['description']); // 描述
        $this->data =   $data;
        $this->seo('comapply');
        $this->yun_tpl(array('comapply'));
    }

    /**
     * 职位详情
     * 求职咨询
     * 2019-06-12
     */
    function msg_action()
    {
        if ($_POST['submit']) {

            $_POST              =   $this->post_trim($_POST);
            $_POST['uid']       =   $this->uid;
            $_POST['username']  =   $this->username;
            $_POST['usertype']  =   $this->usertype;

            $msgM   =   $this->MODEL('msg');

            $res    =   $msgM->addMsg($_POST);

            $this->ACT_layer_msg($res['msg'], $res['errorcode'], $_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * 职位详情
     * 浏览数量
     * 2019-06-12
     */
    function GetHits_action()
    {
        $id = intval($_GET['id']);
        if (empty($id)) {
            echo 'document.write(0)';
            die();
        }

        $JobM   =   $this->MODEL('job');

        $JobM->addJobHits($id);

        $hits   =   $JobM->getInfo(array('id' => $id), array('field' => '`uid`, `jobhits`'));
        echo 'document.write('.$hits['jobhits'].')';
        die();
    }

    /**
     * 职位详情
     * 获取联系方式
     * 2019-06-12
     */
    function gettel_action()
    {

        $id         =   intval($_POST['id']);
        $JobM       =   $this->MODEL('job');
        $dataArr    =   array('id' => $id, 'uid' => $this->uid, 'usertype' => $this->usertype,'isgetprv'=>$this->config['sy_comprivacy_open']);
        $telRes     =   $JobM -> getCompanyJobTel($dataArr);
		
        if (($telRes['errorcode'] == 9 || $telRes['errorcode'] == 10) && ! empty($telRes['data'])) {
			$telRes['data']['errorcode'] = $telRes['errorcode'];
			$telRes['data']['msg']       = $telRes['msg'];
            echo json_encode($telRes['data']);
            die();
        } else {
            echo $telRes['errorcode'];
            die();
        }
    }

	

    /**
     * 求职竞争力分析
     */
    function compete_action()
    {
        if ($_POST['id']) {

            $competeM   =   $this->MODEL('compete');

            $List       =   $competeM->userJob($this->uid, (int)$_POST['id'], $this->usertype);

            if ($List['errcode'] != '1') {

                echo $List['errcode'];
            } else {

                $this->yunset('List', $List);

                $this->yun_tpl(array('usercompete'));
            }
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
                $jobArr = @explode(',', $cookieJobIds);
                if (!in_array($id, $jobArr)) {
                    $lookJobIds =   $cookieJobIds.",".$id;
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
    /**
     * 快速申请职位
     */
    function applyjobuid_action(){
        
        $CacheM     =   $this->MODEL('cache');
        $CacheList  =   $CacheM->GetCache(array('job', 'city', 'com', 'user', 'hy'));
        $this->yunset($CacheList);
        
        $this->yun_tpl(array('applyjobuid'));
    }
}
?>