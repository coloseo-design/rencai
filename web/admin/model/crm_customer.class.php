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

class crm_customer_controller extends adminCommon
{

    function set_search()
    {

        $cacheM     =   $this->MODEL('cache');
        $crmCache   =   $cacheM->GetCache(array('crm'));
        $this->yunset(array('cache' => $crmCache, 'crmClassName' => $crmCache['crmclass_name'], 'crmStatus' => $crmCache['crmdata']['client_status'], 'crmType' => $crmCache['crmdata']['client_type']));

        $yyzz       =   array('1' => '已认证', '2' => '待审核', '3' => '未通过', '4' => '待认证');

        $ratingM    =   $this->MODEL('rating');
        $ratingArr  =   $ratingM->getList(array('category' => '1', 'orderby' => 'sort'), array('field' => '`id`,`name`'));

        $vipEtime   =   array('1' => '三天内', '2' => '七天内', '3' => '十五天内', '4' => '一月内', '5' => '已到期');

        $orders     =   array('1' => '客户ID', '2' => '登录时间', '3' => 'VIP到期时间', '4' => '跟进时间');

        $lastFtime  =   array('1' => '从未跟进', '2' => '今天', '3' => '三天未跟进', '4' => '七天未跟进', '5' => '一月未跟进', '6' => '一百天未跟进');

        $nextFtime  =   array('1' => '今天', '2' => '明天', '3' => '三天内', '4' => '七天内', '5' => '一月内');

        $releaseTime=   array('1' => '今天', '2' => '昨天', '3' => '三天内', '4' => '七天内', '5' => '一月内', '6' => '自定义');

        $this->yunset(array('yyzzStatus' => $yyzz, 'ratingArr' => $ratingArr, 'vipEtime' => $vipEtime, 'orders' => $orders, 'lastFtime' => $lastFtime, 'nextFtime' => $nextFtime, 'releaseTime' => $releaseTime));

        $this->yunset('todayStart', strtotime('today'));
    }

    function index_action()
    {

        $this->set_search();


        $comM       =   $this->MODEL('company');
        $userInfoM  =   $this->MODEL('userinfo');
        $crmM       =   $this->MODEL('crm');

        $urlarr        =   $_GET;

        if ($_GET['self'] == '1') {

            $where['crm_uid']   =   $_SESSION['auid'];
            $urlarr['self']     =   $_GET['self'];
            $this->yunset('self', '1');

            if (isset($_GET['jbtime'])){

                $jbTime =   (int)$_GET['jbtime'];

                if ($jbTime == 1) {

                    $where['crm_time']  =   array('>=', strtotime(date('Y-m-d')));
                } elseif ($jbTime == 2) {

                    $where['PHPYUNBTWSTART_A']  =   '';
                    $where['crm_time'][]        =   array('>=', strtotime('yesterday'), '');
                    $where['crm_time'][]        =   array('<', strtotime(date('Y-m-d')), '');
                    $where['PHPYUNBTWEND_A']    =   '';
                } elseif ($jbTime == 3) {

                    $sDate  =   strtotime(date('Y-m-d', strtotime("this week Monday", time())));
                    $eDate  =   strtotime(date('Y-m-d', strtotime("this week Sunday", time()))) + 24 * 3600 - 1;

                    $where['PHPYUNBTWSTART_A']  =   '';
                    $where['crm_time'][]        =   array('>=', $sDate, '');
                    $where['crm_time'][]        =   array('<', $eDate, '');
                    $where['PHPYUNBTWEND_A']    =   '';
                } elseif ($jbTime == 4) {

                    $sDate  =   mktime(0, 0, 0, date('m'), 1, date('Y'));
                    $eDate  =   mktime(23, 59, 59, date('m'), date('t'), date('Y'));

                    $where['PHPYUNBTWSTART_A']  =   '';
                    $where['crm_time'][]        =   array('>=', $sDate, '');
                    $where['crm_time'][]        =   array('<', $eDate, '');
                    $where['PHPYUNBTWEND_A']    =   '';
                }

                $urlarr['jbtime']               =   $_GET['jbtime'];
            }
        } else {

            $where['crm_uid']   =   '0';
        }

        if (isset($_GET['kh'])){

            if ($_GET['kh'] == 1){

                $where['isfollow']          =   1;

            } elseif ($_GET['kh'] == 2){

                $where['isfollow']          =   1;
                $where['f_time']            =   array('>=', strtotime(date('Y-m-d')));
            } elseif ($_GET['kh'] == 3){

                $where['PHPYUNBTWSTART_A']  =   '';
                $where['f_time'][]          =   array('>', 0);
                $where['f_time'][]          =   array('<', strtotime('-30 days'));
                $where['PHPYUNBTWEND_A']    =   '';
            } elseif ($_GET['kh'] == 4){

                $where['PHPYUNBTWSTART_A']  =   '';
                $where['isfollow']          =   array('=', '0', 'OR');
                $where['f_time']            =   array('=', '', 'OR');
                $where['PHPYUNBTWEND_A']    =   '';
            } elseif ($_GET['kh'] == 5){

                $where['PHPYUNBTWSTART_A']  =   '';
                $where['vipetime'][]        =   array('>', time(), 'AND');
                $where['vipetime'][]        =   array('<', strtotime('+15 days'), 'AND');
                $where['PHPYUNBTWEND_A']    =   '';
            } elseif ($_GET['kh'] == 6){

                $where['login_date']        =   array('>=', strtotime(date('Y-m-d')));
                $_GET['loginStart']         =   date('Y-m-d');
            }

            $urlarr['kh']                   =   $_GET['kh'];
        }

        if (isset($_GET['crm_status']) && !empty($_GET['crm_status'])) {

            $crm_status             =   intval($_GET['crm_status']);
            $where['crm_status']    =   $crm_status;
            $urlarr['crm_status']   =   $crm_status;
        }

        if (isset($_GET['crmType']) && !empty($_GET['crmType'])) {

            $crmType                =   intval($_GET['crmType']);
            $where['crm_type']      =   $crmType;
            $urlarr['crmType']      =   $crmType;
        }

        if (isset($_GET['rating']) && $_GET['rating'] != '') {

            $rating             =   intval($_GET['rating']);
            $where['rating']    =   $rating;
            $urlarr['rating']   =   $rating;
        }

        if (isset($_GET['vipstime']) && !empty($_GET['vipstime'])) {

            if ($_GET['rating'] == '0') {

                $where['vipetime']  =   array('<', strtotime("-" . $_GET['vipstime'] . " days"));
            } else {

                $where['vipstime']  =   array('<', strtotime("-" . $_GET['vipstime'] . " days"));
            }
            $urlarr['vipstime']     =   $_GET['vipstime'];
        }

        if (isset($_GET['yyzz_status']) && !empty($_GET['yyzz_status'])) {

            $yyzz_status    =   intval($_GET['yyzz_status']);

            if ($yyzz_status == 1) {

                $where['yyzz_status']   =   $yyzz_status;
            } else {

                $certWhere      =   array();

                if ($yyzz_status == 2) {

                    $certWhere  =   array('type' => 3, 'status' => 0);
                } elseif ($yyzz_status == 3) {

                    $certWhere  =   array('type' => 3, 'status' => 3);
                }elseif ($yyzz_status == 4) {

                    $certWhere  =   array('type' => 3);
                }

                $certList       =   $comM->getCertList($certWhere, array('field' => '`uid`'));
                $uidArrA        =   array();
                foreach ($certList as $cv) {

                    $uidArrA[]  =   $cv['uid'];
                }

                if ($yyzz_status == 4){

                    $where['uid']   =   array('notin', pylode(',', $uidArrA));
                }else{

                    $where['uid']   =   array('in', pylode(',', $uidArrA));
                }
            }

            $urlarr['yyzz_status']  =   $yyzz_status;
        }

        if (isset($_GET['nextFtime']) && !empty($_GET['nextFtime'])) {

            $nextFtime  =   intval($_GET['nextFtime']);

            $taskWhere  =   array();

            if ($nextFtime == 1) {

                $taskWhere['stime'] =   array('<', strtotime(date('Y-m-d 23:59:59')));  //  之前未完成的跟进同步显示
            } elseif ($nextFtime == 2) {

                $taskWhere['PHPYUNBTWSTART_A']  =   '';
                $taskWhere['stime'][]           =   array('>', strtotime(date('Y-m-d 23:59:59')));
                $taskWhere['stime'][]           =   array('<', strtotime(date('Y-m-d 23:59:59')) + 86400);
                $taskWhere['PHPYUNBTWEND_A']    =   '';
            } elseif ($nextFtime == 3) {

                $taskWhere['PHPYUNBTWSTART_A']  =   '';
                $taskWhere['stime'][]           =   array('>', time());
                $taskWhere['stime'][]           =   array('<', strtotime('+3 day'));
                $taskWhere['PHPYUNBTWEND_A']    =   '';
            } elseif ($nextFtime == 4) {

                $taskWhere['PHPYUNBTWSTART_A']  =   '';
                $taskWhere['stime'][]           =   array('>', time());
                $taskWhere['stime'][]           =   array('<', strtotime('+1 week'));
                $taskWhere['PHPYUNBTWEND_A']    =   '';
            } elseif ($nextFtime == 5) {

                $taskWhere['PHPYUNBTWSTART_A']  =   '';
                $taskWhere['stime'][]           =   array('>', time());
                $taskWhere['stime'][]           =   array('<', strtotime('+1 month'));
                $taskWhere['PHPYUNBTWEND_A']    =   '';
            }

            $taskWhere['uid']   =   $_SESSION['auid'];
            $taskList           =   $crmM->getTaskList($taskWhere, array('field' => '`comid`'));

            $uidArrN            =   array();
            foreach ($taskList as $tv) {

                $uidArrN[]      =   $tv['comid'];
            }

            $where['uid']       =   array('in', pylode(',', $uidArrN));
        }

        if (!empty($_GET['lastFtime'])) {

            $lastFtime  =   intval($_GET['lastFtime']);

            if ($lastFtime != 7){
                if ($lastFtime == 1) {
                    $where['PHPYUNBTWSTART_A']  =   '';
                    $where['isfollow']  =   array('=', '0', 'OR');
                    $where['f_time']    =   array('=', '', 'OR');
                    $where['PHPYUNBTWEND_A']  =   '';
                } elseif ($lastFtime == 2) {

                    $where['f_time'] = array('>', strtotime(date('Y-m-d')));
                } elseif ($lastFtime == 3){
                    $where['PHPYUNBTWSTART_A']  =   '';
                    $where['f_time'][]    =   array('>', 0);
                    $where['f_time'][]    =   array('<', strtotime('-3 days'));
                    $where['PHPYUNBTWEND_A']  =   '';
                }elseif ($lastFtime == 4){
                    $where['PHPYUNBTWSTART_A']  =   '';
                    $where['f_time'][]    =   array('>', 0);
                    $where['f_time'][]    =   array('<', strtotime('-7 days'));
                    $where['PHPYUNBTWEND_A']  =   '';
                }elseif ($lastFtime == 5){
                    $where['PHPYUNBTWSTART_A']  =   '';
                    $where['f_time'][]    =   array('>', 0);
                    $where['f_time'][]    =   array('<', strtotime('-30 days'));
                    $where['PHPYUNBTWEND_A']  =   '';
                }elseif ($lastFtime == 6){
                    $where['PHPYUNBTWSTART_A']  =   '';
                    $where['f_time'][]    =   array('>', 0);
                    $where['f_time'][]    =   array('<', strtotime('-100 days'));
                    $where['PHPYUNBTWEND_A']  =   '';
                }else{
                    $where['PHPYUNBTWSTART_A']  =   '';
                    $where['f_time'][]    =   array('isnull', '', '');
                    $where['f_time'][]    =   array('<', strtotime('-'.$_GET['lastFtime'].' days'), 'OR');
                    $where['PHPYUNBTWEND_A']  =   '';
                }
            }

            $urlarr['lastFtime']    =   $lastFtime;

            if ($_GET['lastStart'] || $_GET['lastEnd']){

                $where['PHPYUNBTWSTART_A']  =   '';
                $where['f_time'][]          =   array('>=', strtotime($_GET['lastStart']), '');
                $where['f_time'][]          =   array('<', strtotime($_GET['lastEnd']) + 86400, '');
                $where['PHPYUNBTWEND_A']    =   '';
            }

            $urlarr['lastStart']    =   $_GET['lastStart'];
            $urlarr['lastEnd']      =   $_GET['lastEnd'];

        }

        if (!empty($_GET['releaseTime'])) {

            $releaseTime    =   intval($_GET['releaseTime']);

            if ($releaseTime != 6){

                if ($releaseTime == 1) {

                    $where['release_time']      =   array('>=', strtotime(date('Y-m-d')));
                } elseif ($releaseTime == 2) {

                    $where['PHPYUNBTWSTART_A']  =   '';
                    $where['release_time'][]    =   array('>=', strtotime('yesterday'));
                    $where['release_time'][]    =   array('<', strtotime(date('Y-m-d')));
                    $where['PHPYUNBTWEND_A']    =   '';
                } elseif ($releaseTime == 3){

                    $where['PHPYUNBTWSTART_A']  =   '';
                    $where['release_time'][]    =   array('>=', strtotime('-3 days'));
                    $where['release_time'][]    =   array('<', time());
                    $where['PHPYUNBTWEND_A']    =   '';
                }  elseif ($releaseTime == 4){

                    $where['PHPYUNBTWSTART_A']  =   '';
                    $where['release_time'][]    =   array('>=', strtotime('-7 days'));
                    $where['release_time'][]    =   array('<', time());
                    $where['PHPYUNBTWEND_A']    =   '';
                } elseif ($releaseTime == 5){

                    $where['PHPYUNBTWSTART_A']  =   '';
                    $where['release_time'][]    =   array('>=', strtotime('-30 days'));
                    $where['release_time'][]    =   array('<', time());
                    $where['PHPYUNBTWEND_A']    =   '';
                }
            }

            $urlarr['releaseTime']    =   $releaseTime;

            if ($_GET['releaseStart'] || $_GET['releaseEnd']){

                $where['PHPYUNBTWSTART_A']      =   '';
                $where['release_time'][]        =   array('>=', strtotime($_GET['releaseStart']), '');
                $where['release_time'][]        =   array('<', strtotime($_GET['releaseEnd']) + 86400, '');
                $where['PHPYUNBTWEND_A']        =   '';
            }

            $urlarr['releaseTime']    =   $_GET['releaseStart'];
            $urlarr['releaseTime']    =   $_GET['releaseEnd'];
        }

        if (isset($_GET['vipetime']) && !empty($_GET['vipetime'])) {

            $etime  =   intval($_GET['vipetime']);

            if ($etime == 5) {

                $where['PHPYUNBTWSTART_A']  =   '';
                $where['vipetime'][]        =   array('<', strtotime(date('Y-m-d')), 'AND');
                $where['vipetime'][]        =   array('>', '0', 'AND');
                $where['PHPYUNBTWEND_A']    =   '';

            } else {

                if ($etime == 1) {

                    $num    =   '+3 days';
                } else if ($etime == 2) {

                    $num    =   '+7 days';
                } elseif ($etime == 3) {

                    $num    =   '+15 days';
                } elseif ($etime == 4) {

                    $num    =   '+1 month';
                }

                $where['PHPYUNBTWSTART_A']  =   '';
                $where['vipetime'][]        =   array('>', time(), 'AND');
                $where['vipetime'][]        =   array('<', strtotime($num), 'AND');
                $where['PHPYUNBTWEND_A']    =   '';

            }

            $urlarr['vipetime'] =   $etime;
        }

        if (!empty($_GET['regStart']) || !empty($_GET['regEnd'])) {

            $regStart   =   strtotime($_GET['regStart']);
            $regEnd     =   strtotime($_GET['regEnd']) + 86400;

            $mWhere['PHPYUNBTWSTART_A'] =   '';
            $mWhere['reg_date'][]       =   array('>', $regStart, 'AND');
            $mWhere['reg_date'][]       =   array('<', $regEnd, 'AND');
            $mWhere['PHPYUNBTWEND_A']   =   '';
            $memberList =   $userInfoM->getList($mWhere, array('field' => 'uid'));

            $uidArrB    =   array();
            foreach ($memberList as $mv) {
                $uidArrB[]  =   $mv['uid'];
            }

            $where['uid']   =   array('in', pylode(',', $uidArrB));

            $urlarr['regStart'] =   $_GET['regStart'];
            $urlarr['regEnd']   =   $_GET['regEnd'];
        }

        if (!empty($_GET['loginStart']) || !empty($_GET['loginEnd'])) {

            $loginStart =   strtotime($_GET['loginStart']);
            $loginEnd   =   strtotime($_GET['loginEnd']) + 86400;

            $where['PHPYUNBTWSTART_A']  =   '';
            $where['login_date'][]      =   array('>', $loginStart, 'AND');
            $where['login_date'][]      =   array('<', $loginEnd, 'AND');
            $where['PHPYUNBTWEND_A']    =   '';

            $urlarr['loginStart']       =   $_GET['loginStart'];
            $urlarr['loginEnd']         =   $_GET['loginEnd'];
        }

        if (isset($_GET['keyword']) && $_GET['keyword']) {

            $keywordStr =   trim($_GET['keyword']);
            $typeStr    =   intval($_GET['crm_type']);

            if (!empty($keywordStr)) {
                if ($typeStr == 1) {

                    $where['name']      =   array('like', $keywordStr);
                } else if ($typeStr == 2) {

                    $where['linkman']   =   array('like', $keywordStr);
                } else if ($typeStr == 3) {

                    $where['linktel']   =   $keywordStr;
                } else if ($typeStr == 4) {

                    $where['uid']       =   $keywordStr;
                }
            }

            $urlarr['crm_type'] =   $typeStr;
            $urlarr['keyword']  =   $keywordStr;
        }

        if(isset($_GET['r_status'])){
            $where['r_status']       =   $_GET['r_status'];
        }

        if (!empty($_GET['ordertype'])) {

            $orderType  =   intval($_GET['ordertype']);
            $order      =   '';
            if ($orderType == 1) {
                $order  =   'uid';
            } else if ($orderType == 2) {
                $order  =   'login_date';
            } else if ($orderType == 3) {
                $order  =   'vipetime';
            } else if ($orderType == 4) {
                $order  =   'f_time';
            } else if ($orderType == 5) {
                $order  =   'crm_time';
            }

            $urlarr['ordertype']    =   $orderType;
            $where['orderby']       =   $order.',DESC';

        } else {
            $where['orderby']       =   'login_date,DESC';
        }

        $urlarr['page'] =   '{{page}}';

        $pageurl        =   Url($_GET['m'], $urlarr, 'admin');

        $pageM          =   $this->MODEL('page');

        $pages          =   $pageM->pageList('company', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {

            if (isset($_GET['order'])) {
                if (isset($_GET['t'])) {

                    $where['orderby']   =   $_GET['t'].','.$_GET['order'];
                    $urlarr['t']        =   $_GET['t'];
                } else {

                    $where['orderby']   =   'login_date,desc';
                }

                $urlarr['order']        =   $_GET['order'];
            } else if (isset($order)) {

                $where['orderby']       =   $order . ',DESC';
            }

            $where['limit'] =   $pages['limit'];

            $listA          =   $comM->getList($where, array('utype' => 'crm'));
            foreach ($listA['list']  as $key => $val){
                $listA['list'][$key]['wxBindmsg'] = $this->wxBindState($val);
            }

            $this->yunset(array('rows' => $listA['list'], 'auid' => intval($_SESSION['auid'])));
        }

        $AdminM         =   $this->MODEL('admin');
        $adminUserList  =   $AdminM->getList(array(), array('field' => '`uid`,`name`'));
        $this->yunset('adminUserList', $adminUserList);
        $crmUser        =   $AdminM->getList(array('is_crm' => '1', 'uid' => array('<>', $_SESSION['auid'])));
        $this->yunset(array('crmUser' => $crmUser));
        if (isset($_GET['self'])){

            $this->yuntpl(array('admin/crm_customer'));
        }else{

            $this->yuntpl(array('admin/crm_customer_all'));
        }

    }

    function ajaxCrmSetData_action()
    {
        $crmM   =   $this->MODEL('crm');
        $return =   $crmM->getMyCom($_SESSION['auid']);
        echo $return;
        die;
    }

    /**
     * @desc CRM - 录客户
     */
    function add_action()
    {

        if ($_POST['submit']) {

            $crmUid =   isset($_POST['crm_uid']) && !empty($_POST['crm_uid']) ? $_POST['crm_uid'] : $_SESSION['auid'];

            $mPost  =   array(
                'username'  =>  trim($_POST['username']),
                'companyName'  =>  trim($_POST['name']),
                'moblie'    =>  trim($_POST['moblie']),
                'email'     =>  trim($_POST['email'])
            );

            if ($_POST['username'] == '' || mb_strlen($_POST['username']) < 2 || mb_strlen($_POST['username']) > 16) {

                $this->ACT_layer_msg('客户名称格式错误', 8);
            } elseif ($_POST['password'] == '' || mb_strlen($_POST['password']) < 6 || mb_strlen($_POST['password']) > 20) {

                $this->ACT_layer_msg('客户账号格式错误', 8);
            }

            $userInfoM  =   $this->MODEL('userinfo');
            $result     =   $userInfoM->addMemberCheck($mPost);
            if ($result['msg']) {

                $this->ACT_layer_msg($result['msg'], 8);
            }

            if ($this->config['sy_uc_type'] == 'uc_center') {
                $this->obj->uc_open();
                $user   =   uc_get_user($_POST['username']);
                if (is_array($user)) {

                    $this->ACT_layer_msg('该会员已经存在！', 8);
                }
            }

            $time   =   time();
            $ip     =   fun_ip_get();
            $pass   =   $_POST['password'];

            $password   =   $salt   =   '';
            if ($this->config['sy_uc_type'] == 'uc_center') {

                $uid    =   uc_user_register($_POST['username'], $pass, $_POST['email']);

                if ($uid < 0) {
                    switch ($uid) {
                        case '-1' :
                            $data['msg'] = '用户名不合法!';
                            break;
                        case '-2' :
                            $data['msg'] = '包含不允许注册的词语!';
                            break;
                        case '-3' :
                            $data['msg'] = '用户名已经存在!';
                            break;
                        case '-4' :
                            $data['msg'] = 'Email 格式有误!';
                            break;
                        case '-5' :
                            $data['msg'] = 'Email 不允许注册!';
                            break;
                        case '-6' :
                            $data['msg'] = '该 Email 已经被注册!';
                            break;
                    }

                    $this->ACT_layer_msg($data['msg'], 8);
                } else {

                    list($uid, $username, $email, $password, $salt) = uc_get_user($_POST['email'], $pass);
                }
            } else {

                $pwdRes     =   $userInfoM->generatePwd(array('password' => $pass));
                $salt       =   $pwdRes['salt'];
                $password   =   $pwdRes['pwd'];
            }

            $mdata  =   array(

                'username'  =>  trim($_POST['username']),
                'password'  =>  $password,
                'usertype'  =>  2,
                'salt'      =>  $salt,
                'address'   =>  $_POST['address'],
                'moblie'    =>  $_POST['moblie'],
                'email'     =>  $_POST['email'],
                'reg_date'  =>  $time,
                'reg_ip'    =>  $ip,
                'source'    =>  '16',
                'status'    =>  1
            );

            if ($_POST['areacode'] && $_POST['telphone']) {

                $_POST['phone'] =   $_POST['areacode'].'-'.$_POST['telphone'];

                if ($_POST['exten']) {

                    $_POST['phone'] .=  '-'.$_POST['exten'];
                }
            }

            $udata  =   array(

                'name'          =>  $_POST['name'],
                'hy'            =>  $_POST['hy'],
                'r_status'      =>  1,
                'provinceid'    =>  $_POST['provinceid'],
                'cityid'        =>  $_POST['cityid'],
                'three_cityid'  =>  $_POST['three_cityid'],
                'address'       =>  $_POST['address'],
                'linkman'       =>  $_POST['linkman'],
                'linktel'       =>  $_POST['moblie'],
                'linkphone'     =>  $_POST['phone'],
                'linkmail'      =>  $_POST['email'],
                'crm_uid'       =>  $crmUid,
                'crm_time'      =>  $time,
                'crm_type'      =>  $_POST['crm_type'],
                'crm_status'    =>  $_POST['crm_status']
            );

            $sdata  =   array(

                'rating'    =>  $this->config['com_rating']
            );

            $nid    =   $userInfoM->addInfo(array('mdata' => $mdata, 'udata' => $udata, 'sdata' => $sdata));

            if ($nid) {

                $crmM   =   $this->MODEL('crm');

                if ($_POST['crm_status'] == '9' && !empty($_POST['rating_name'])) {   // 成单客户，新建订单（待审核）

                    $dealData   =   array(

                        'uid'       =>  $nid,
                        'rating'    =>  intval($_POST['rating_name']),
                        'crm_uid'   =>  $crmUid
                    );

                    $crmM->addDeal($dealData);
                }

                $cacheM     =   $this->MODEL('cache');
                $crmCache   =   $cacheM->GetCache(array('crm'));

                $lContent   =   "录入新客户：" . $_POST['name'];
                if ($_POST['crm_type']) {

                    $lContent   .=  "，标记客户等级为：".$crmCache['crmclass_name'][$_POST['crm_type']];
                }
                if ($_POST['crm_status']) {
                    $lContent   .=  "，标记客户状态为：".$crmCache['crmclass_name'][$_POST['crm_status']];
                }
                // 添加CRM操作记录；
                $crmM->addCrmLog($lContent, 1, $nid, $crmUid);
            }

            $msg    =   $nid ? '客户（ID：'.$nid.'）新加成功！' : '客户新加失败，请重试！';

            if ($nid > 0) {

                $this->ACT_layer_msg($msg, 9, 'index.php?m=crm_customer&self=1');
            } else {

                $this->ACT_layer_msg($msg, 8);
            }
        }

        $ratingM    =   $this->MODEL('rating');
        $rating     =   $ratingM->getList(array('category' => '1', 'orderby' => 'sort,asc'), array('field' => '`id`,`name`'));
        $this->yunset('rating_list', $rating);

        $cacheM     =   $this->MODEL('cache');
        $options    =   array('crm', 'hy', 'city');
        $cache      =   $cacheM->GetCache($options);
        $this->yunset('cache', $cache);

        $adminM     =   $this->MODEL('admin');
        $crmUser    =   $adminM->getList(array('is_crm' => '1', 'uid' => array('<>', $_SESSION['auid'])));
        $this->yunset(array('crmUser' => $crmUser));

        $this->yuntpl(array('admin/crm_customer_add'));
    }

    /**
     * @desc CRM - 新增客户 - 用户名检测
     */
    function check_action()
    {

        $username   =   trim($_POST['username']);
        $companyName   =   trim($_POST['companyName']);
        $userInfoM  =   $this->MODEL('userinfo');
        $check      =   $userInfoM->addMemberCheck(array('username' => $username, 'companyName' => $companyName));

        echo $check['msg'];
        die;
    }

    /**
     * @desc CRM - 新建订单（业务员开通套餐，待审核）
     */
    function getstatis_action()
    {

        $ratingM    =   $this->MODEL('rating');
        $rating     =   $ratingM->getList(array('category' => '1', 'orderby' => 'sort,asc'), array('field' => '`id`,`name`'));
        if (!empty($rating)) {
            foreach ($rating as $k => $v) {

                $ratingarr[$v['id']]    =   $v['name'];
            }
        }

        $this->yunset('ratingarr', $ratingarr);

        if ($_GET['uid']) {

            $uid        =   intval($_GET['uid']);
            $statisM    =   $this->MODEL('statis');
            $row        =   $statisM->getInfo($uid, array('usertype' => '2'));

            if ($row['vip_etime'] > 0) {

                $row['vipetime']    =   date("Y-m-d", $row['vip_etime']);
            } else {

                $row['vipetime']    =   '不限';
            }
            $this->yunset('row', $row);
        }

        $this->yuntpl(array('admin/crm_customer_rating'));
    }

    /**
     * @desc CRM - 开通套餐 - 选择套餐查询数据返回；
     */
    function getrating_action()
    {

        if ($_POST['id']) {

            $id     =   intval($_POST['id']);

            $ratingM=   $this->MODEL('rating');

            $rating =   $ratingM->getInfo(array('id' => $id, 'category' => '1'));

            if ($rating['service_time'] > 0) {

                $rating['vip_etime']    =   time() + $rating['service_time'] * 86400;
                $rating['vipetime']     =   date('Y-m-d', $rating['vip_etime']);
            } else {

                $rating['vip_etime']    =   0;
                $rating['vipetime']     =   '不限';
            }

            if ($rating['time_start'] < time() && $rating['time_end'] > time()) {

                $rating['price']    =   $rating['yh_price'];
            } else {

                $rating['price']    =   $rating['service_price'];
            }

            echo json_encode($rating);
        }
    }

    /**
     * @desc 客户信息页面
     */
    function com_action()
    {

        if ($_GET['id']) {

            $comM       =   $this->MODEL('company');
            $crmM       =   $this->MODEL('crm');

            $ratingM    =   $this->MODEL('rating');
            $ratingArr  =   $ratingM->getList(array('category' => '1', 'orderby' => 'sort'), array('field' => '`id`,`name`'));

            $cacheM     =   $this->MODEL('cache');
            $crmCache   =   $cacheM->GetCache(array('crm'));

            $this->yunset(array(
                'cache'         =>  $crmCache,
                'crmClassName'  =>  $crmCache['crmclass_name'],
                'crmType'       =>  $crmCache['crmdata']['client_type'],
                'crmStatus'     =>  $crmCache['crmdata']['client_status'],
                'outClass'      =>  $crmCache['crmdata']['crm_outclass'],
                'followWay'     =>  $crmCache['crmdata']['follow_way'],
                'crmTaskType'   =>  $crmCache['crmdata']['task_type'],
                'ratingArr'     =>  $ratingArr,
                'ratinglist'    =>  $ratingArr
            ));

            $comid      =   intval($_GET['id']);

            $type       =   $_GET['type'] ? intval($_GET['type']) : 1;
            $all        =   $_GET['all'] ? intval($_GET['all']) : '';

            $comInfo    =   $comM->getInfo($comid, array('logo' => 1, 'crm' => 1, 'auid' => $_SESSION['auid']));
            $this->yunset('Info', $comInfo);

            if (!empty($comInfo['followInfo'])) {
                $this->yunset('followInfo', $comInfo['followInfo']);
            }

            //提取顾问信息
            $adminM     =   $this->MODEL('admin');
            $crmUser    =   $adminM->getList(array('is_crm' => '1', 'uid' => array('<>', $_SESSION['auid'])));
            $this->yunset(array('crmUser' => $crmUser));

            $pageM      =   $this->MODEL('page');

            //操作记录
            $logWhere           =   $logUrlArr  =   array();

            $logWhere['uid']    =   $comid;
            $logUrlArr        	=   $_GET;
            $logUrlArr['page']  =   '{{page}}';
            $logUrlArr['c']     =   'com';
            $logUrlArr['id']    =   $comid;
            $logUrlArr['type']  =   $type;

            $pageurl    =   Url($_GET['m'], $logUrlArr, 'admin');
            $pages      =   $pageM->pageList('crm_comlog', $logWhere, $pageurl, $_GET['page']);

            if ($pages['total'] > 0) {

                $logWhere['limit']      =   $pages['limit'];
                $logWhere['orderby']    =   'ctime,desc';

                $logList    =   $crmM->getComLogList($logWhere, array('utype' => 'crm'));
                $this->yunset(array('logList' => $logList, 'logtotal' => $pages['total'], 'logpagenav' => $pages['pagenav'], 'loglimit' => $pages['limit']));
            }

            // 联系跟进记录
            $followUrlArr   =   $followWhere    =   array();

            $followWhere['uid']     =   $comid;
            $followUrlArr       	=   $_GET;
            $followUrlArr['page']   =   '{{page}}';
            $followUrlArr['c']      =   'com';
            $followUrlArr['id']     =   $comid;
            $followUrlArr['type']   =   $type;
            $followUrlArr['all']    =   $all;

            if (!$_GET['all']) {
                $followWhere['auid']    =   $_SESSION['auid'];
            }

            $fpageurl   =   Url($_GET['m'], $followUrlArr, 'admin');
            $fpages     =   $pageM->pageList('crmnew_concern', $followWhere, $fpageurl, $_GET['page'], '4');
            if ($fpages['total'] > 0) {

                $followWhere['limit']   =   $fpages['limit'];
                $followWhere['orderby'] =   'atime,desc';
                $followList             =   $crmM->getConcernList($followWhere, array('utype' => 'crm'));
                $this->yunset(array('followList' => $followList, 'ftotal' => $fpages['total'], 'fpagenav' => $fpages['pagenav'], 'flimit' => $fpages['limit']));
            }

            // 开单记录
            $orderM     =   $this->MODEL('companyorder');
            $orUrlArr   =   $orWhere    =   array();

            $orWhere['uid']     =   $comid;
            $orWhere['crm_uid'] =   $_SESSION['auid'];

            if (!empty($_GET['orState'])) {

                $orWhere['order_state'] =   intval($_GET['orState']);
                $orUrlArr['orState']    =   $_GET['orState'];
            }

            if (!empty($_GET['orType'])) {

                $orWhere['order_type']  =   $_GET['orType'];
                $orUrlArr['orType']     =   $_GET['orType'];
            }

            if (!empty($_GET['orRating'])) {

                $orWhere['rating']      =   $_GET['orRating'];
                $orUrlArr['orType']     =   $_GET['orRating'];
            }

            if (!empty($_GET['orStime']) || !empty($_GET['orEtime'])) {

                $orStime    =   strtotime($_GET['orStime']);
                $orEtime    =   $_GET['orEtime'] ? (strtotime($_GET['orEtime']) + 86399) : time();

                $orWhere['PHPYUNBTWSTART_A']    =   '';
                $orWhere['order_time'][]        =   array('>', $orStime, 'AND');
                $orWhere['order_time'][]        =   array('<', $orEtime, 'AND');
                $orWhere['PHPYUNBTWEND_A']      =   '';
            }

            if (!empty($_GET['orKeyword'])) {

                $orWhere['order_id']    =   array('like', trim($_GET['orKeyword']));
            }
            $urlarr        		=   $_GET;
            $orUrlArr['page']   =   '{{page}}';
            $orUrlArr['c']      =   'com';
            $orUrlArr['id']     =   $comid;
            $orUrlArr['type']   =   $type;


            $orpageurl  =   Url($_GET['m'], $orUrlArr, 'admin');
            $orpages    =   $pageM->pageList('company_order', $orWhere, $orpageurl, $_GET['page']);

            if ($orpages['total'] > 0) {

                $orWhere['limit']   =   $orpages['limit'];
                $orWhere['orderby'] =   'order_time,desc';

                $orderList          =   $orderM->getList($orWhere, array('utype' => 'crmdealsp'));
                $this->yunset(array('orderList' => $orderList, 'orderTotal' => $orpages['total'], 'orderpagenav' => $orpages['pagenav'], 'orderlimit' => $orpages['limit']));
            }

            $this->yunset(array('auid' => $_SESSION['auid'], 'type' => $type));
        }

        $AdminM         =   $this->MODEL('admin');
        $adminUserList  =   $AdminM->getList('', array('field' => '`uid`,`name`'));
        $this->yunset('adminUserList', $adminUserList);

        // 网站所有支付类型
        include(CONFIG_PATH . 'db.data.php');
        $this->yunset('canpay', $arr_data['pay']);

        $this->yuntpl(array('admin/crm_com_info'));
    }

    /**
     * @desc 转交客户
     */
    function deliver_action()
    {

        if (!empty($_POST)) {

            $data           =   $_POST;
            $data['auid']   =   $_SESSION['auid'];

            $crmM   =   $this->MODEL('crm');
            $return =   $crmM->deliverUser($data);

            echo json_encode($return);
            die;
        }
    }

    /**
     * @desc 放弃客户
     */
    function giveUp_action()
    {
        if (!empty($_POST)) {

            $data           =   $_POST;
            $data['auid']   =   $_SESSION['auid'];

            $crmM   =   $this->MODEL('crm');
            $return =   $crmM->giveUpUser($data);

            echo json_encode($return);
            die;
        }
    }

    /**
     * @desc 修改客户状态/等级
     */
    function upStatusType_action()
    {
        if (!empty($_POST)) {

            $data           =   $_POST;
            $data['auid']   =   $_SESSION['auid'];

            $crmM   =   $this->MODEL('crm');
            $return =   $crmM->upComST($data);

            echo json_encode($return);
            die;
        }
    }

    /**
     * @desc 修改客户联系方式
     */
    function upComLink_action()
    {

        if (!empty($_POST)) {

            $data           =   $_POST;
            $data['auid']   =   $_SESSION['auid'];

            $crmM   =   $this->MODEL('crm');
            $return =   $crmM->upComLink($data);

            echo json_encode($return);
            die;
        }
    }

    /**
     * @desc 联系反馈-> 添加企业备注
     */
    function remarkCom_action()
    {
        if (!empty($_POST)) {

            $data           =   $_POST;
            $data['auid']   =   $_SESSION['auid'];

            $crmM   =   $this->MODEL('crm');
            $return =   $crmM->remarkCom($data);

            echo json_encode($return);
            die;
        }
    }

    /**
     * @desc 客户管理 -> 修改账号密码
     */
    function upPassword_action()
    {

        $crmM       =   $this->MODEL("crm");
        $postData   =   $_POST;
        $result     =    $crmM->upPassword($postData);

        echo json_encode($result);
        die;
    }

    /**
     * @desc 客户管理->添加/修改跟进记录
     */
    function addFollow_action()
    {
        if (!empty($_POST)) {

            $data           =   $_POST;
            $data['uid']    =   $_POST['uid'] ? $_POST['uid'] : $_POST['comid'];
            $data['auid']   =   $_SESSION['auid'];

            $crmM   =   $this->MODEL('crm');
            $return =   $crmM->addFollow($data);

            echo json_encode($return);
            die;
        }
    }

    /**
     * @desc 客户管理 -> 短信模板选择
     */
    function getMsgTpl_action()
    {

        if (!empty($_POST)) {

            $data           =   $_POST;
            $data['auid']   =   $_SESSION['auid'];

            $crmM   =   $this->MODEL('crm');
            $return =   $crmM->getMsgTpl($data);

            echo json_encode($return);
            die;
        }
    }

    /**
     * @desc 客户管理->快捷发送短信
     */
    function sendMsg_action()
    {

        if (!empty($_POST)) {

            $data           =   $_POST;
            $data['auid']   =   $_SESSION['auid'];

            $crmM   =   $this->MODEL('crm');
            $return =   $crmM->sendCrmMsg($data);

            echo json_encode($return);
            die;
        }
    }

    /**
     * @desc 客户管理详细页面，点击企业相关功能，跳转企业会员中心
     */
    function Imitate_action()
    {

        $userInfoM  =   $this->MODEL('userinfo');

        $member     =   $userInfoM->getInfo(array('uid' => intval($_GET['uid'])), array('field' => '`uid`,`username`,`salt`,`email`,`password`,`usertype`,`did`'));

        $this->cookie->unset_cookie();
        $this->cookie->add_cookie($member['uid'], $member['username'], $member['salt'], $member['email'], $member['password'], 2, $this->config['sy_logintime'], $member['did'],'1');

        $typeStr    =   trim($_GET['type']);

        $url        =   '';

        if (!empty($typeStr)) {
            if ($typeStr == 'job') {

                $url    =   'index.php?c=' . $typeStr . '&w=1';
            } else {

                $url    =   'index.php?c=' . $typeStr;
            }
        }
        header('Location: ' . $this->config['sy_weburl'] . '/member/' . $url);
    }

    /**
     * @desc CRM-我的客户列表:（统计数量）
     */
    function getComNum_action()
    {

        $crmM   =   $this->MODEL('crm');
        echo $crmM->getMyCustomerNum(array('crm_uid' => $_SESSION['auid']));
    }

}

?>