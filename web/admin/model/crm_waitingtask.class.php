<?php

/**
 * $Author ：PHPYUN开发团队
 *
 * 官网: http://www.phpyun.com
 *
 * 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
 *
 * 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */
class crm_waitingtask_controller extends adminCommon
{

    function index_action()
    {
        $crmM       =   $this->MODEL('crm');
        $adminM     =   $this->MODEL('admin');

        $where  =   $urlarr =   array();

        $where['uid']   =   $_SESSION['auid'];

        if ($_GET['time']) {

            $time   =   intval($_GET['time']);

            if ($time != 4) {

                if ($time == 1) { // 明天

                    $sDate = mktime(0, 0, 0, date('m'), date('d'), date('Y')) + 86400;
                    $eDate = mktime(23, 59, 59, date('m'), date('d'), date('Y')) + 86400;
                } elseif ($time == 2) { // 后天

                    $sDate = mktime(0, 0, 0, date('m'), date('d'), date('Y')) + 86400 * 2;
                    $eDate = mktime(23, 59, 59, date('m'), date('d'), date('Y')) + 86400 * 2;
                } elseif ($time == 3) { // 一周内

                    $sDate = mktime(0, 0, 0, date('m'), date('d'), date('y'));
                    $eDate = mktime(23, 59, 59, date('m'), date('d'), date('Y')) + 86400 * 7;
                }

                $where['PHPYUNBTWSTART_A'] = '';
                $where['stime'][] = array('>=', $sDate, 'and');
                $where['stime'][] = array('<=', $eDate, 'and');
                $where['stime'][] = array('isnull', '', 'OR');
                $where['PHPYUNBTWEND_A'] = '';
            }
            $urlarr['time'] = $time;
        } else{ // 今天

            $eDate  =   mktime(23, 59, 59, date('m'), date('d'), date('y'));
            $where['PHPYUNBTWSTART_A'] = '';
            $where['stime'][]   =   array('<', $eDate,'OR');
            $where['stime'][]   =   array('isnull', '','OR');
            $where['PHPYUNBTWEND_A'] = '';
        }

        if ($_GET['status']) {

            $status =   intval($_GET['status']);

            if ($status != 5) {

                $where['status']    =   $status;
            }

            $urlarr['status']       =   $status;
        } else {

            $urlarr['status']       =   1;
            $where['status']        =   1;
        }

        if ($_GET['type']) {

            $type           =   intval($_GET['type']);
            $where['type']  =   $type;
            $urlarr['type'] =   $type;
        }

        if ($_GET['keyword']) {

            $KeywordStr         =   trim($_GET['keyword']);

            $comM               =   $this->MODEL('company');
            $coms               =   $comM->getList(array('name' => array('like', $KeywordStr)), '`uid`');
            if (!empty($coms)){

                $comUids        =   array();
                foreach ($coms['list'] as $ck => $cv) {
                    $comUids[$cv['uid']]   =   $cv['uid'];
                }
            }

            if (!empty($comUids)){

                $where['PHPYUNBTWSTART_B']  =   '';
                $where['content']           =   array('like', $KeywordStr, '');
                $where['comid']             =   array('in', pylode(',', $comUids), 'or');
                $where['PHPYUNBTWEND_B']    =   '';
            }else{

                $where['content']   =   array('like', $KeywordStr);
            }

            $urlarr['keyword']  =   $KeywordStr;
        }

        $urlarr        	=   $_GET;
        $urlarr['page'] =   '{{page}}';
        $pageurl        =   Url($_GET['m'], $urlarr, 'admin');
        $pageM          =   $this->MODEL('page');
        $pages          =   $pageM->pageList('crm_work_plan', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {
            if ($_GET['order']) {

                $where['orderby']   =   $_GET['t'].','.$_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];
            } else {

                $where['orderby']   =   array('stime,desc','type,asc','ctime,desc');
            }

            $where['limit'] =   $pages['limit'];

            $list           =   $crmM->getTaskList($where, array('utype' => 'crm'));

            $this->yunset(array('tasks' => $list));
        }

        $power  =   $adminM->getPower(array('uid' => $_SESSION['auid']));
        $this->yunset('power', $power['power']);

        $cacheM =   $this->MODEL('cache');
        $cache  =   $cacheM->GetCache(array('crm'));
        $this->yunset('cache', $cache);

        $this->yuntpl(array('admin/crm_waitingtask'));
    }

    /**
     * @desc 部门下属任务
     */
    function depart_action()
    {

        $AdminM     =   $this->MODEL('admin');
        $crmM       =   $this->MODEL('crm');
        $cacheM     =   $this->MODEL('cache');

        $adminUserInfo  =   $AdminM->getAdminUser(array('uid' => $_SESSION['auid']), array('field' => 'org,power,spower'));

        if($adminUserInfo['org'] > 0){

            $orgInfo	=	$crmM -> getOrgInfo(array('id' => $adminUserInfo['org']));

            $oIds	=	$orgIds	=	$orgIdss	=	$orgIdsss	=	array();

            if ($adminUserInfo['power'] == '1'){	// 同级部门权限
                $oList				=	$crmM -> getOrgList(array('level' => $orgInfo['level']));

                foreach ($oList as $k => $v) {
                    $orgIds[]		=	$v['id'];
                }
            }

            if ($adminUserInfo['power'] == '1'){	// 子部门权限
                if ($orgInfo['level'] == '1'){

                    $orgList			=	$crmM -> getOrgList(array('fid' => $adminUserInfo['org']));

                    foreach ($orgList as $ok => $ov) {
                        $orgIdss[]		=	$ov['id'];
                    }

                    $orgLists			=	$crmM -> getOrgList(array('fid' => array('in', pylode(',', $orgIdss))));

                    foreach ($orgLists as $ook => $oov) {
                        $orgIdsss[]		=	$oov['id'];
                    }

                }elseif ($orgInfo['level'] == '2'){

                    $orgList			=	$crmM -> getOrgList(array('fid' => $adminUserInfo['org']));
                    foreach ($orgList as $ok => $ov) {
                        $orgIdss[]		=	$ov['id'];
                    }

                }
            }
            $oIds			=	array_merge($orgIds, $orgIdss, $orgIdsss);

            $adminUserList	=	$AdminM -> getList(array('uid'=>array('<>',$_SESSION['auid']),'org'=>array('in', pylode(',', $oIds))),array('field'=>'`uid`,`name`,`username`'));
            foreach($adminUserList as $v){
                $uids[]		=	$v['uid'];
            }
            $this->yunset('adminUserList',$adminUserList);
        }

        $where  =   $urlarr =   array();

        if ($_GET['time']) {

            $time   =   intval($_GET['time']);

            if ($time != 4) {

                if ($time == 1) { // 明天

                    $sDate = mktime(0, 0, 0, date('m'), date('d'), date('Y')) + 86400;
                    $eDate = mktime(23, 59, 59, date('m'), date('d') + 1, date('Y')) + 86400;
                } elseif ($time == 2) { // 后天

                    $sDate = mktime(0, 0, 0, date('m'), date('d'), date('Y')) + 86400 * 2;
                    $eDate = mktime(23, 59, 59, date('m'), date('d'), date('Y')) + 86400 * 2;
                } elseif ($time == 3) { // 一周内

                    $sDate = mktime(0, 0, 0, date('m'), date('d'), date('y'));
                    $eDate = mktime(23, 59, 59, date('m'), date('d'), date('Y')) + 86400 * 7;
                }

                $where['PHPYUNBTWSTART_A'] = '';
                $where['stime'][] = array('>=', $sDate, 'and');
                $where['stime'][] = array('<=', $eDate, 'and');
                $where['stime'][] = array('isnull', '', 'OR');
                $where['PHPYUNBTWEND_A'] = '';
            }
            $urlarr['time'] =   $time;

        } else { // 今天

            $eDate              =   mktime(23, 59, 59, date('m'), date('d'), date('y'));

            $where['PHPYUNBTWSTART_A'] = '';
            $where['stime'][]   =   array('<', $eDate,'OR');
            $where['stime'][]   =   array('isnull', '','OR');
            $where['PHPYUNBTWEND_A'] = '';

        }

        if ($_GET['status']) {

            $status =   intval($_GET['status']);

            if ($status != 5) {

                $where['status']    =   $status;
            }
            $urlarr['status']       =   $status;
        }else {

            $urlarr['status']       =   1;
            $where['status']        =   1;
        }

        if ($_GET['type']) {

            $type           =   intval($_GET['type']);
            $where['type']  =   $type;
            $urlarr['type'] =   $type;
        }

        if ($_GET['keyword']) {

            $KeywordStr =   trim($_GET['keyword']);

            $comM               =   $this->MODEL('company');
            $coms               =   $comM->getList(array('name' => array('like', $KeywordStr)), '`uid`');
            if (!empty($coms)){

                $comUids        =   array();
                foreach ($coms['list'] as $ck => $cv) {
                    $comUids[$cv['uid']]   =   $cv['uid'];
                }
            }

            if (!empty($comUids)){

                $where['PHPYUNBTWSTART_B']  =   '';
                $where['content']           =   array('like', $KeywordStr, '');
                $where['comid']             =   array('in', pylode(',', $comUids), 'or');
                $where['PHPYUNBTWEND_B']    =   '';
            }else{

                $where['content']   =   array('like', $KeywordStr);
            }

            $urlarr['keyword']  =   $KeywordStr;
        }

        if(!empty($_GET['crmuid'])) {
            $where['uid']		=	$_GET['crmuid'];
            $urlarr['crmuid']	=   $_GET['crmuid'];
        }else{
            $where['uid']	=	array('in',pylode(',',$uids));
        }
        $urlarr        	=   $_GET;
        $urlarr['page'] =   '{{page}}';
        $urlarr['c']    =   $_GET['c'];
        $pageurl        =   Url($_GET['m'], $urlarr, 'admin');
        $pageM          =   $this->MODEL('page');
        $pages          =   $pageM->pageList('crm_work_plan', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {
            if ($_GET['order']) {

                $where['orderby']   =   $_GET['t'].','.$_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];
            } else {

                $where['orderby']   =   array('stime,desc','type,asc','ctime,desc');
            }
            $where['limit']         =   $pages['limit'];
            $list   =   $crmM->getTaskList($where, array('utype' => 'crm'));
        }

        $this->yunset('tasks', $list);

        $cache  =   $cacheM->GetCache(array('crm'));
        $this->yunset('cache', $cache);

        $this->yuntpl(array('admin/crm_waitingtask_depart'));
    }

    /**
     *@desc  任务状态设置
     */
    function setStatus_action()
    {
        $crmM	=	$this->MODEL('crm');

        if (intval($_POST['type']) == 1) {

            $tValue	=	array(
                'status'	=>	intval($_POST['status']),
                'reason'	=>	$_POST['reason'],
                'etime'		=>	$_POST['status'] == '2' ? time() : ''
            );

            $data	=	array(
                'auid'	=>	$_SESSION['auid'],
                'tValue'=>	$tValue
            );

            $nid    =   $crmM -> upTask($data, array('id' => intval($_POST['id'])));
        } else {

            $nid    =   $crmM -> delTask(array('id' => intval($_POST['id'])), array('auid' => $_SESSION['auid']));
        }

        if ($nid) {
            echo 1;
            die();
        }
    }

    /**
     * @desc 新建任务
     */
    function add_action()
    {

        if ($_POST) {

            $crmM   =   $this->MODEL('crm');

            $Data   =   array(

                'auid'      =>  $_SESSION['auid'],
                'uid'       =>  $_POST['taskHuid'],
                'comid'     =>  $_POST['comid'],
                'type'      =>  $_POST['type'],
                'content'   =>  $_POST['content']
            );

            if ($_POST['type'] == '22') {
                $Data['stime']  =   $_POST['stime'];
            }else{
                unset($Data['stime']);
            }
            $return =   $crmM->addWaitingTask($Data);
        }

        echo json_encode($return);
        die();
    }

    function detail_action()
    {
        $crmM = $this->MODEL('crm');
        $info = $crmM->getTaskInfo(array('id' => intval($_POST['id'])));

        $companyM = $this->MODEL('company');
        $cominfo = $companyM->getInfo($info['comid'], array(
            'field' => '`uid`,`name`'
        ));
        $info['comname'] = $cominfo['name'];
        echo json_encode($info);
    }

    /**
     * @desc 企业信息查询
     */
    function ComDetail_action()
    {

        $uid        =   intval($_POST['uid']);

        $companyM   =   $this->MODEL('company');

        $info       =   $companyM->getInfo($uid, array('field' => '`uid`,`name`,`linktel`,`linkphone`,`provinceid`,`cityid`,`three_cityid`,`linkman`'));

        $info['cityname']   =   $info['job_city_one'].' '.$info['job_city_two'].' '.$info['job_city_three'];

        if ($info['linktel']) {

            $info['moblie'] = $info['linktel'];
        } else {

            $info['moblie'] = $info['linkphone'];
        }

        $statisM    =   $this->MODEL('statis');
        $statis     =   $statisM->getInfo((int) $_POST['uid'], array('usertype' => 2, 'field' => '`rating_name`,`vip_etime`'));

        if ($statis) {
            $info['ratingname'] =   $statis['rating_name'];
            if ($statis['vip_etime']) {

                $info['ratingtime'] = date('Y-m-d', $statis['vip_etime']);
            } else {

                $info['ratingtime'] = '永久会员';
            }
        }
        echo json_encode($info);
    }

    /**
     * @desc 任务反馈说明
     */
    function reason_action()
    {
        $crmM = $this->MODEL('crm');
        $info = $crmM->getTaskInfo(array('id' => intval($_POST['id'])), array('field' => '`reason`'));
        echo $info['reason'];
    }
}

?>