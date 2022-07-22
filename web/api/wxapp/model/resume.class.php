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
class resume_controller extends wxapp_controller
{

	//简历列表
	function list_action()
	{

		$_POST	=	$this->post_trim($_POST);

       if(!empty($_POST['token']) && !empty($_POST['uid'])){

            $member  =   $this->yzToken($_POST['uid'],$_POST['token']);
            $uid     =   $member['uid'];
            $usertype=   $member['usertype'];

			if($usertype == '2'){
				$userinfoM	=	$this->MODEL('userinfo');
				$uInfo		=	$userinfoM -> getUserInfo(array('uid' => $uid), array('field' => 'r_status', 'usertype' => $usertype));
				$data['r_status']	=	$uInfo['r_status'];
			}
        }

        if($this->config['com_search']=='1' && !$uid){
            unset($_POST['keyword']);
        }
        if($this->config['com_search']=='1' && $this->config['com_status_search'] == '1'){

            if($usertype==1 || !$uid){
                $_POST['limit'] = 3;
            }else if($uInfo['r_status'] != '1'){
				$_POST['limit'] = 3;
			}
			if($usertype==1){
                if(!empty($this->config['sy_user_visit_resume'])){
                    $_POST['limit'] = 10;
                }
            }

        }else if($this->config['com_search']=='1'){
            if($usertype==1 || !$uid){
                $_POST['limit'] = 3;
            }
        }
        $_POST['keyword']  =  $this->stringfilter($_POST['keyword']);

        // 处理分站查询条件
        if (!empty($_POST['did'])){

            $domain  =  $this->getDomain($_POST['did'], true);

            if (isset($domain['didcity'])){

                $data['didcity']    =  $domain['didcity'];

                if (!empty($_POST['provinceid'])){
                    // 分站下，再次选择城市，查询按选择的来
                    $data['didcity']      =  $domain['city_name'][$_POST['provinceid']];
                }elseif (!empty($domain['provinceid'])){
                    $_POST['provinceid']  =  $domain['provinceid'];
                }
                if (!empty($_POST['cityid'])){
                    // 分站下，再次选择城市，查询按选择的来
                    $data['didcity']  =  $domain['city_name'][$_POST['cityid']];
                }elseif (!empty($domain['cityid'])){
                    $_POST['cityid']  =  $domain['cityid'];
                }
                if (!empty($_POST['three_cityid'])){
                    // 分站下，再次选择城市，查询按选择的来
                    $data['didcity']        =  $domain['city_name'][$_POST['three_cityid']];
                }elseif (!empty($domain['three_cityid'])){
                    $_POST['three_cityid']  =  $domain['three_cityid'];
                }

                $data['cityone']    =  $domain['cityone'];
                $data['citytwo']    =  $domain['citytwo'];
                $data['citythree']  =  $domain['citythree'];
                $data['provinceid']    =  !empty($_POST['provinceid']) ? intval($_POST['provinceid']) : 0;
                $data['cityid']        =  !empty($_POST['cityid']) ? intval($_POST['cityid']) : 0;
                $data['three_cityid']  =  !empty($_POST['three_cityid']) ? intval($_POST['three_cityid']) : 0;
            }
            if (isset($domain['didhy'])){

                if (!empty($domain['hyclass'])){
                    $_POST['hy']  =  $domain['hyclass'];
                }
            }
        }else{
            // 没有已选择的城市，按后台设置的列表页区域默认设置来（后台-页面设置-列表页区域默认设置）
            // 设置了一级城市，后面的搜索，不再展示其他一级城市
            if (empty($_POST['provinceid']) && empty($_POST['cityid']) && empty($_POST['three_cityid']) || (!empty($_POST['provinceid']) && $_POST['provinceid'] == $this->config['sy_web_city_one'])){

                $list_cityid      = isset($_POST['cityid']) ? $_POST['cityid'] : 0;
                $list_threecityid = isset($_POST['three_cityid']) ? $_POST['three_cityid'] : 0;

                $listback = $this->listCity($list_cityid, $list_threecityid);
                if (!empty($listback)) {
                    if (isset($listback['provinceid'])){
                        $_POST['provinceid']  =  $listback['provinceid'];
                    }
                    if (isset($listback['cityid'])){
                        $_POST['cityid']  =  $listback['cityid'];
                    }
                    if (isset($listback['listcity'])){
                        $data['listcity']   =  $listback['listcity'];
                        $data['cityone']    =  $listback['cityone'];
                        $data['citytwo']    =  $listback['citytwo'];
                        $data['citythree']  =  $listback['citythree'];

                        $data['provinceid']    =  !empty($_POST['provinceid']) ? intval($_POST['provinceid']) : 0;
                        $data['cityid']        =  $list_cityid;
                        $data['three_cityid']  =  $list_threecityid;
                    }
                }
            }
        }

        $resumeM  =  $this->MODEL('resume');

        $resumerows  =  $resumeM->getList(
            array(),
            array(
                'search'            =>  $_POST,
                'withResumeField'   =>  'uid,name,nametype,tag,sex,moblie_status,edu,exp,defphoto,photo,resume_photo,phototype,birthday,photo_status,def_job',
                'downresume_where'  =>  array('comid'=>$uid,'usertype'=>$usertype),
                'workexp'           =>  1
            )
        );

        $rows  =  $resumerows['list'];

        if($resumerows['zdids']){
            $data['zdids']  =   $resumerows['zdids'];
        }
        if(!empty($this->config['com_search'])){
            $data['com_search']	=   $this->config['com_search'];
        }else{
            $data['com_search']	=   2;
        }

		if(!empty($this->config['com_status_search'])){
            $data['status_search']	=	$this->config['com_status_search'];
        }else{
            $data['status_search']	=   2;
        }
        if(!empty($this->config['sy_user_visit_resume'])){
            $data['user_visit']  =	$this->config['sy_user_visit_resume'];
        }else{
            $data['user_visit']  =  2;
        }
		$data['wxerm']		=	checkpic($this->config['sy_wx_qcode']);

		$data['freewebtel']	=  $this->config['sy_freewebtel'];
        $data['cuswitch']   =  $this->config['sy_user_change'];

        // 小程序用seo
        if (isset($_POST['provider'])){
            if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao'){
                $seo            =  $this->seo('user_search','','','',false, true);
                $data['seo']    =  $seo;
            }
        }
        if($rows&&is_array($rows)){

            $data['error']  =   1;
            $data['list']   =   count($rows) ? $rows : array();

        }else{

            $data['error']  =   2;
        }
        $this->render_json($data['error'],'',$data);

    }
    //简历内容页
    function show_action(){
        $uid = $usertype = 0;
		$resumeM = $this->MODEL('resume');

		if(!empty($_POST['token']) && !empty($_POST['uid'])){

		    $member     =   $this->yzToken((int)$_POST['uid'],$_POST['token']);

			$uid        =   $member['uid'];

			$usertype   =   $member['usertype'];

        }

        $id             =   '';

        if($_POST['rewardid']){//来自企业会员中心-应聘悬赏简历-查看简历

			$packM      =   $this->MODEL('pack');

            $reward     =   $packM->getReward((int)$_POST['rewardid'],$uid);

            if(empty($reward)){

                $msg    =   '未找到相关数据！';

            }elseif($reward['status']=='0'){

                $msg    =   '请先支付职位赏金！';

            }else{
                $id     =   $reward['eid'];
            }

            $data['reward']  =   $reward;

        }elseif ($_POST['resumeuid']){

            $def_job  =  $resumeM->getResumeInfo(array('uid' => $_POST['resumeuid'], 'r_status' => 1), array('field' => '`def_job`'));

            if ($def_job['def_job']) {

                $id     =   $def_job['def_job'];

            }else{
                $msg    =   '未找到相关数据！';

            }
        }else{

            $id         =  $_POST['id'];
		}


		if(!isset($msg)){

            $resumeM        =   $this->MODEL('resume');

            $edata          =   array('eid' => $id, 'uid' => $uid, 'usertype' => $usertype);

            $edata['reward']=   !empty($reward) ? $reward['status'] : '';

            $expect  =   $resumeM -> getInfoByEid($edata);


            $expect['sy_resume_visitors'] =   $this->config['sy_resume_visitors'];

            if(empty($expect)){

                $msg        =   '没有找到该人才！';

            }elseif($expect['state'] == 0 && $uid != $expect['uid']){

                $msg        =   '简历正在审核中！';

            }elseif($expect['r_status'] == 2 && $uid != $expect['uid']){

                $msg        =   '简历暂被锁定，请稍后查看！';

            }elseif($expect['state'] == 3 && $uid != $expect['uid']){

                $msg        =   '简历审核暂未通过！';

            }elseif($this->config['sy_user_visit_resume'] == '0' && $usertype == 1 && $uid != $expect['uid']){
                $msg        =   '个人用户无权限查看！';

            }else{
                // 检查简历隐私状态设置
                $canShow = true;
                if ($expect['status'] == 2){
                    // 简历关闭
                    $canShow = false;
                }elseif ($expect['status'] == 3){
                    // 简历状态是投递企业可见
                    $canShow = false;
                    if (isset($expect['userid_job'])){
                        // 已向企业投递简历，简历可以展示
                        $canShow = true;
                    }elseif (in_array($usertype, array(2,3))){
                        // 检查个人是否主动向企业、猎头发送了简历，主动发送的，简历可以展示（也算作一种主动投递简历）
                        $barr  =  array(
                            'from'       =>  $expect['uid'],
                            'fusertype'  =>  1,
                            'to'         =>  $uid,
                            'tusertype'  =>  $usertype,
                            'msgtype'    =>  'resume'
                        );
                        $chatM = $this->MODEL('chat');
                        $log   = $chatM->getChatLog($barr);
                        if (!empty($log)){
                            $canShow = true;
                        }
                    }
                }
                if (!$canShow){
                    $msg  =  '简历已设置不对外开放！';
                }else{
                    // 查询黑名单
                    $blackM     =   $this->MODEL('black');
                    $blackInfo  =   $blackM -> getBlackInfo(array('p_uid' => $uid, 'c_uid'=> $expect['uid']));
                    
                    if(!empty($blackInfo)){
                        $msg    =   '该用户已关闭简历!';
                    }
                }
            }
        }

        if(!isset($msg)){
            if (!empty($uid)){
                //人才收藏库
				$reportM					  =	  $this->MODEL('report');
				$talent_pool                  =   $resumeM -> getTalentNum(array('eid' => $id, 'cuid' => $uid));
				$report_num				      =	  $reportM->getNum(array('p_uid' => $expect['uid'], 'eid' => $id,'c_uid' => $uid, 'usertype' => $member['usertype']));
                $JobM                         =   $this->MODEL('job');
                //已邀请面试数量
                $userid_msg                   =   $JobM -> getYqmsNum(array('fid' => $uid,'uid' => $expect['uid'],'isdel'=>9));

				$expect['report_num']  =   $report_num;


                $expect['rec_resume']  =   $expect['rec_resume'];
            }
            $expect['userid_msg']      =   isset($userid_msg) ? $userid_msg : 0;
            $expect['talent_pool']     =   $talent_pool > 0 ? 1 : 0;
            //处理浏览记录
            $lookM                            =   $this -> MODEL('lookresume');
            $lookM -> browseResume(array(
                'euid'                  =>  $expect['uid'],
                'uid'                   =>  $uid,
                'usertype'              =>  $usertype,
                'eid'                   =>  $id
            ));


            $cData['uid']       =   $uid;
            $cData['usertype']  =   $usertype;
            $cData['eid']       =   $id;
            $cData['ruid']      =   $expect['uid'];
            $cData['from']      =   !empty($reward) ?   'reward' : '';//是否来自企业应聘悬赏简历的查看简历
            $resumeCkeck        =   $resumeM->openResumeCheck($cData);

            $expect['resumeCkeck']  =  $resumeCkeck;
            $msg ='';

            if(isset($expect['m_status']) && $expect['m_status'] == 1){
                $expect['showname']  =  $expect['name'];
            }else{
                $expect['showname']  =  $expect['username_n'];
                // 没有简历查看权限，处理手机号
                $expect['telphone'] = sub_string($expect['telphone']);
            }
            $expect['rescheck']	=  $this->config['resume_open_check'];
            $data['info']       =  $expect;
            $data['chatOpen']   =  $this->config['sy_chat_open'];
            $data['chatname']   =  $this->config['sy_chat_name'] ? $this->config['sy_chat_name'] : '';
            $data['userData']   =  array('name'=>$member['username'],'type'=>$member['usertype'],'mtype'=>2);
            $data['iosfk']		=  $this->config['sy_iospay'] ;
            $data['cuswitch']   =  $this->config['sy_user_change'];
            $data['privateTime']=  isset($this->config['sy_privacy_time']) ? intval($this->config['sy_privacy_time']) : 0;
            //判断是否是企业的个人账号简历
            if($member['uid'] == $expect['uid']){
                $data['isMyResume'] = 1;
            }

            if (isset($_POST['provider'])){
                // app用分享数据
                if ($_POST['provider'] == 'app'){

                    $data['shareData']  =  array(
                        'url'       =>  Url('wap',array('c'=>'resume','a'=>'show','id'=>$id)),
                        'title'     =>  $expect['showname'],
                        'summary'   =>  $expect['cityname'].'-'.$expect['customjob'],
                        'imageUrl'  =>  $expect['logo']
                    );
                }
                // 小程序用seo
                if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao'){
                    $seodata['resume_username']	=	$expect['username_n'];//简历人姓名
                    $seodata['resume_city']		=	$expect['cityname'];//城市
                    $seodata['resume_job']		=	$expect['customjob'];//行业
                    $this->data	    =	$seodata;
                    $seo            =   $this->seo('resume','','','',false, true);
                    $data['seo']    =   $seo;
                }
            }
        }
        
        $this->render_json(0,$msg,$data);
    }
    //邀请面试页面相关信息
    function inviteMsg_action()
    {

        $member             =   $this->yzToken((int)$_POST['comid'],$_POST['token']);

        if($_POST['rewardid']){
            $packM          =   $this -> MODEL('pack');
            $reward         =   $packM -> getPackInfo(array('comid'=>$member['uid'],'id'=>(int)$_POST['rewardid']));

            $ruid           =   $reward['uid'];

        }else{
            $ruid           =   (int)$_POST['ruid'];
        }

        $resumeM            =   $this -> MODEL('resume');
        $user_resume        =   $resumeM -> getResumeInfo(array('uid' => $ruid, 'r_status' => 1), array('field' => '`def_job`'));
        $userrows           =   $resumeM -> getInfoByEid(array('eid' => $user_resume['def_job'], 'uid' => $member['uid'], 'usertype' => $member['usertype'],'spid'=>$member['spid']));

        $user               =   array();
        $user['name']       =   $userrows['m_status']==1 ? $userrows['name'] : $userrows['username_n'];
        $user['uid']        =   $userrows['uid'];
        $user['photo']      =   $userrows['photo'];
        $user['sex']        =   $userrows['sex'];
        $user['user_exp']   =   $userrows['user_exp'];
        $user['useredu']    =   $userrows['useredu'];
        $user['age']        =   $userrows['age']?$userrows['age']:'';

        $expect             =   $resumeM -> getExpect(array('uid' => $ruid, 'defaults' => 1), array('field' => '`id`, `job_classid`', 'needCache' => 1));
        $user['id']         =   $expect['id'];
        $user['jobname']    =   @implode('、', $expect['jobnameArr']);



        $jobM     =  $this -> MODEL('job');

        //公司旗下职位信息（包含职位联系方式）
        $rows     =  $jobM -> getList(array('uid' => $member['uid'], 'status' => 0, 'state' => 1, 'r_status' => 1, 'limit'=>50), array('link'=>'yes', 'field' => '`id`, `name`, `is_link`'));

        $joblist  =  $rows['list'];

        if(!empty($reward)){

           foreach ($joblist as $key => $value) {
               $joblist[$key]['content']       = '';
               $joblist[$key]['intertime']     = '';
                if($reward['jobid'] == $value['id']){

                    $data['jobnameIndex'] = $key;
                    break;
                }
            }
        }
        foreach ($joblist as $key => $value) {
            $joblist[$key]['content']    =  '';
            $joblist[$key]['intertime']  =  '';
        }

        $data['joblist']    =   $joblist;
        $data['user']       =   $user;

        //邀请模板
        $yqmbM  =   $this->MODEL('yqmb');
        $ymlist =   $yqmbM  ->getList(array('uid'=>$member['uid'],'status'=>1));
        $ymData =   array();
        $ykey   =   0;
        $ymData[$ykey]['name']          = '请选择';
        $ymData[$ykey]['id']            = '';
        $ymData[$ykey]['link_man']      = '';
        $ymData[$ykey]['link_mobile']   = '';
        $ymData[$ykey]['content']       = '';
        $ymData[$ykey]['intertime']     = '';
        $ymData[$ykey]['address']       = '';

        foreach($ymlist as $yk=>$yv){

            $ykey++;
            $ymData[$ykey]['id']            = $yv['id'];
            $ymData[$ykey]['name']          = $yv['name'];
            $ymData[$ykey]['link_man']      = $yv['linkman'];
            $ymData[$ykey]['link_moblie']   = $yv['linktel'];
            $ymData[$ykey]['content']       = $yv['content'];
            $ymData[$ykey]['intertime']     = $yv['intertime'];
            $ymData[$ykey]['address']       = $yv['address'];

        }
        $data['ymlist'] = $ymData;

        $this->render_json(0,'',$data);
    }
    //邀请面试判断是否满足条件
    function invite_action()
    {
        $member =   $this->yzToken($_POST['fid'],$_POST['token']);

        $companyM   =   $this->MODEL('company');
        $result     =   $companyM->comVipDayActionCheck('interview',$member['uid']);

        if($result['status'] == '-1'){
            $error  =   2;
            $msg    =   strip_tags($result['msg']);

        }else{

            $comtcM            =   $this->MODEL('comtc');
            $data['uid']       =   $member['uid'];
            $data['spid']      =   $member['spid'];
            $data['username']  =   $member['username'];
            $data['usertype']  =   $member['usertype'];
            $data['ruid']      =   $_POST['ruid'];
            $data['show_job']  =   $_POST['show_job'];


            $return     =   $comtcM->invite_resume($data);

            $error      =   $return['status'];
            $msg        =   strip_tags($return['msg']);

        }
		$return['iosfk']	=	$this->config['sy_iospay'] ;
        $this->render_json($error,$msg, $return);
    }
    //执行邀请面试保存数据
    function invitesave_action(){
	    if(!empty($_POST['source']) && $_POST['source'] == 'wap'){
            $_POST['fid'] = $this->uid;
            $_POST['usertype'] = $this->usertype;
        }
        $member		=  $this->yzToken($_POST['fid'],$_POST['token']);
		$jobM       =   $this -> MODEL('job');

		$_POST      =   $this -> post_trim($_POST);
		$_POST['port']	=	$this->plat == 'mini' ? '3' : '4';
		$fidArr     =   array(
		    'fuid'      =>  $member['uid'],
		    'spid'      =>  $member['spid'],		//	子账号UID
		    'fusername' =>  $member['username'],
		    'fusertype' =>  $member['usertype']
		);


        if(!empty($_POST['longitude']) && !empty($_POST['latitude'])){
            $bd09 = $this->Convert_GCJ02_To_BD09($_POST['longitude'], $_POST['latitude']);
            $_POST['longitude'] = $bd09['lng'];
            $_POST['latitude'] = $bd09['lat'];
        }

		$return     =   $jobM -> addYqmsInfo(array_merge($fidArr, $_POST));

		$this->render_json($return['status'], strip_tags($return['msg']), $return);
    }

    /**
     * 下载简历
     */
    function down_action(){

        $member     =   $this->yzToken($_POST['cuid'],$_POST['token']);

        $downReM    =   $this -> MODEL('downresume');

        $data       =   array(
            'eid'       =>  $_POST['eid'],
            'uid'       =>  $member['uid'],
            'spid'      =>  $member['spid'],
            'usertype'  =>  $member['usertype'],
            'utype'     =>  'wxapp',
        );
        $downRes = $downReM -> downResume($data);
        if (isset($downRes['html'])){
            unset($downRes['html']);
        }
        $this->render_json($downRes['status'],strip_tags($downRes['msg']), $downRes);
    }
    /**
     * 加入人才库
     */
    function talentpool_action()
    {
        $member  =  $this->yzToken($_POST['cuid'],$_POST['token']);

        $data       =   array(
            'eid'       =>  $_POST['eid'],
            'cuid'      =>  $member['uid'],
            'usertype'  =>  $member['usertype'],
            'uid'       =>  (int)$_POST['uid'],
        );

        $ResumeM    =   $this->MODEL('resume');
        $return     =   $ResumeM -> addTalent($data);
        $error      =   $return['errcode']==9 ? 1 : 2;
        $this->render_json($error,$return['msg']);

    }

    /**
     * 举报信息保存
     */
	function savereport_action(){
        $member  	=  	$this->yzToken($_POST['uid'],$_POST['token']);
		$reportM	=	$this->MODEL('report');

        $data   	=   array(
			'p_uid'		=>	$member['uid'],
			'c_uid'		=>	$_POST['ruid'],
			'usertype'	=>	$_POST['usertype'],
			'eid'		=>	$_POST['eid'],
			'r_name'	=>	$_POST['rname'],
			'username'	=>	$member['username'],
			'reason'	=>	$_POST['r_reason'],
			'inputtime'	=>	time()
		);
		$return	=	$reportM->ReportResume($data);

		if($return['errcode']==9){
			$errcode	=	1;
		}else{
			$errcode	=	2;
		}
		$this->render_json($errcode, $return['msg']);

	}
	/**
	 * 举报简历前判断
	 */
	function repostlist_action(){
		$member  	=  	$this->yzToken($_POST['uid'],$_POST['token']);

		$Where = array(
		    'uid' => $member['uid'],
		    'usertype' => $member['usertype'],
		    'eid' => $_POST['id']
		);

		$resumeM  =  $this->MODEL('resume');
		$jlres	  =  $resumeM->openResumeCheck($Where);
		if($jlres == 1){
            $reportM	=	$this->MODEL('report');
            $numm		=	$reportM->getNum(array('p_uid' => $_POST['ruid'], 'c_uid' => $member['uid'],'eid' => $_POST['id'], 'usertype' => $member['usertype']));
            if($numm>0){
                $errcode	=	1;
            }else{
                $errcode	=	2;
            }
        }else{
            $errcode = 3;
        }
        $this->render_json($errcode, 'ok');
    }
}
?>