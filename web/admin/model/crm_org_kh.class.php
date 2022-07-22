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

class crm_org_kh_controller extends adminCommon
{

    function set_search()
    {

        $cacheM     =   $this->MODEL('cache');
        $crmCache   =   $cacheM->GetCache(array('crm'));
        $this->yunset(array('cache' => $crmCache, 'crmClassName' => $crmCache['crmclass_name'], 'crmStatus' => $crmCache['crmdata']['client_status'], 'crmType' => $crmCache['crmdata']['client_type']));

        $yyzz       =   array('1' => '已认证', '2' => '待审核', '3' => '未通过', '4' => '待认证');

        $ratingM    =   $this->MODEL('rating');
        $ratingArr  =   $ratingM->getList(array('category' => '1', 'orderby' => 'sort'), array('field' => '`id`,`name`'));
        $vipEtime   =   array('1' => '三天内', '2' => '七天内', '3' => '一月内', '4' => '已到期');
        $orders     =   array('1' => '客户ID', '2' => '登录日期', '3' => 'VIP到期时间', '4' => '跟进时间');
        $lastFtime  =   array('1' => '从未跟进', '2' => '今天', '3' => '三天未跟进', '4' => '七天未跟进', '5' => '一月未跟进', '6' => '一百天未跟进');
        $nextFtime  =   array('1' => '今天', '2' => '明天', '3' => '三天内', '4' => '七天内', '5' => '一月内');
        $this->yunset(array('yyzzStatus' => $yyzz, 'ratingArr' => $ratingArr, 'vipEtime' => $vipEtime, 'orders' => $orders, 'lastFtime' => $lastFtime, 'nextFtime' => $nextFtime));

        $this->yunset('todayStart', strtotime('today'));
    }

    function index_action()
    {

        $this->set_search();

        $AdminM         =   $this->MODEL('admin');
        $adminUserInfo  =   $AdminM->getAdminUser(array('uid' => $_SESSION['auid']), array('field' => 'org,power,spower'));

        $Company        =   $this->MODEL('company');
        $userInfoM      =   $this->MODEL('userinfo');
        $crmM           =   $this->MODEL('crm');

        if (isset($adminUserInfo) && $adminUserInfo['org'] > 0) {

            $orgInfo    =   $crmM->getOrgInfo(array('id' => $adminUserInfo['org']));

            $oIds = $orgIds = $orgIdss = $orgIdsss = array();

            if ($adminUserInfo['power'] == '1') {    // 同级部门权限

                $oList  =   $crmM->getOrgList(array('level' => $orgInfo['level']));
                foreach ($oList as $k => $v) {
                    $orgIds[]   =   $v['id'];
                }
            }

            if ($adminUserInfo['power'] == '1') {    // 子部门权限
                if ($orgInfo['level'] == '1') {

                    $orgList    =   $crmM->getOrgList(array('fid' => $adminUserInfo['org']));
                    foreach ($orgList as $ok => $ov) {
                        $orgIdss[]  =   $ov['id'];
                    }

                    $orgLists   =   $crmM->getOrgList(array('fid' => array('in', pylode(',', $orgIdss))));

                    foreach ($orgLists as $ook => $oov) {
                        $orgIdsss[] =   $oov['id'];
                    }

                } elseif ($orgInfo['level'] == '2') {

                    $orgList    =   $crmM->getOrgList(array('fid' => $adminUserInfo['org']));
                    foreach ($orgList as $ok => $ov) {

                        $orgIdss[]  =   $ov['id'];
                    }
                }
            }

            $oIds   =   array_merge($orgIds, $orgIdss, $orgIdsss);

            $adminUserList  =   $AdminM->getList(array('uid' => array('<>', $_SESSION['auid']), 'org' => array('in', pylode(',', $oIds))), array('field' => '`uid`,`name`,`username`'));
            foreach ($adminUserList as $v) {
                $uids[]     =   $v['uid'];
            }
            $this->yunset('adminUserList', $adminUserList);
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

        if (!empty($_GET['crmType'])) {

            $crmType                =   intval($_GET['crmType']);
            $where['crm_type']      =   $crmType;
            $urlarr['crmType']      =   $crmType;
        }

        if (!empty($_GET['crm_status'])) {

            $crm_status             =   intval($_GET['crm_status']);
            $where['crm_status']    =   $crm_status;
            $urlarr['crm_status']   =   $crm_status;
        }

        if (!empty($_GET['yyzz_status'])) {

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

                $certList       =   $Company->getCertList($certWhere, array('field' => '`uid`'));
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

        if (!empty($_GET['rating'])) {

            $rating             =   intval($_GET['rating']);
            $where['rating']    =   $rating;
            $urlarr['rating']   =   $rating;
        }

        if (!empty($_GET['regStart']) || !empty($_GET['regEnd'])) {

            $regStart   =   strtotime($_GET['regStart']);
            $regEnd     =   strtotime($_GET['regEnd']);

            $mWhere['PHPYUNBTWSTART_A'] =   '';
            $mWhere['reg_date'][]       =   array('>', $regStart, 'AND');
            $mWhere['reg_date'][]       =   array('<', $regEnd, 'AND');
            $mWhere['PHPYUNBTWEND_A']   =   '';
            $memberList =   $userInfoM->getList($mWhere, array('field' => 'uid'));

            $uidArrB = array();
            foreach ($memberList as $mv) {
                $uidArrB[]  =   $mv['uid'];
            }
            $where['uid']   =   array('in', pylode(',', $uidArrB));

            $urlarr['regStart'] =   $_GET['regStart'];
            $urlarr['regEnd']   =   $_GET['regEnd'];
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
            $where['orderby']       =   $order.',desc';
        }else{

            $where['orderby']       =   'login_date,desc';
        }

        if (!empty($_GET['lastFtime'])) {

            $lastFtime  =   intval($_GET['lastFtime']);
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

            $urlarr['lastFtime']    =   $lastFtime;
        }

        if (!empty($_GET['nextFtime'])) {

            $nextFtime  =   intval($_GET['nextFtime']);
            $taskWhere  =   array();
            if ($nextFtime == 1) {

                $taskWhere['PHPYUNBTWSTART_A']  =   '';
                $taskWhere['stime'][]           =   array('>', strtotime(date('Y-m-d')));
                $taskWhere['stime'][]           =   array('<', strtotime(date('Y-m-d 23:59:59')));
                $taskWhere['PHPYUNBTWEND_A']    =   '';
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

        if (!empty($_GET['vipetime'])) {

            $etime  =   intval($_GET['vipetime']);

            if ($etime == 4) {

                $where['PHPYUNBTWSTART_A']  =   '';
                $where['vipetime'][]        =   array('<', strtotime(date('Y-m-d')), 'AND');
                $where['vipetime'][]        =   array('>', '0', 'AND');
                $where['PHPYUNBTWEND_A']    =   '';
            } else {

                if ($etime == 1) {

                    $num    =   '+3 day';
                } else if ($etime == 2) {

                    $num    =   '+7 day';
                } elseif ($etime == 3) {

                    $num    =   '+1 month';
                }
                $where['PHPYUNBTWSTART_A']  =   '';
                $where['vipetime'][]        =   array('>', time(), 'AND');
                $where['vipetime'][]        =   array('<', strtotime($num), 'AND');
                $where['PHPYUNBTWEND_A']    =   '';
            }
            $urlarr['vipetime'] =   $etime;
        }

        if (!empty($_GET['loginStart']) || !empty($_GET['loginEnd'])) {

            $loginStart =   strtotime($_GET['loginStart']);
            $loginEnd   =   strtotime($_GET['loginEnd']) + 86400;

            $where['PHPYUNBTWSTART_A']  =   '';
            $where['login_date'][]      =   array('>', $loginStart, 'AND');
            $where['login_date'][]      =   array('<', $loginEnd, 'AND');
            $where['PHPYUNBTWEND_A']    =   '';

            $urlarr['regStart'] =   $_GET['regStart'];
            $urlarr['regEnd']   =   $_GET['regEnd'];
        }

        if (isset($_GET['crm_uid']) && $_GET['crm_uid'] > 0){

            $where['crm_uid']           =   $_GET['crm_uid'];
            $urlarr['crm_uid']          =   $_GET['crm_uid'];
        }else{

            $where['PHPYUNBTWSTART_A']  =   '';
            $where['crm_uid'][]         =   array('<>', 0, 'AND');
            $where['crm_uid'][]         =   array('in', pylode(',', $uids), 'AND');
            $where['PHPYUNBTWEND_A']    =   '';
        }

        if ($_GET['keyword']) {

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
		$urlarr        	=   $_GET;
        $urlarr['page'] =   '{{page}}';
        $pageurl        =   Url($_GET['m'], $urlarr, 'admin');
        $pageM          =   $this->MODEL('page');
        $pages          =   $pageM->pageList('company', $where, $pageurl, $_GET['page']);
        if ($pages['total'] > 0) {
            if ($_GET['order']) {
                if ($_GET['t']) {

                    $where['orderby']   =   $_GET['t'] . ',' . $_GET['order'];
                    $urlarr['t']        =   $_GET['t'];
                } else {

                    $where['orderby']   =   'login_date, desc';
                }
                $urlarr['order']        =   $_GET['order'];
            } else if (isset($order)) {

                $where['orderby']       =   $order . ',' . $_GET['order'];
            }
            $where['limit'] =   $pages['limit'];
            $comList        =   $Company->getList($where, array('utype' => 'crm'));

            foreach ($comList['list']  as $key => $val){
                $comList['list'][$key]['wxBindmsg'] = $this->wxBindState($val);
            }

            $this->yunset('rows', $comList['list']);
        }
        $this->yuntpl(array('admin/crm_org_kh'));
    }
}

?>