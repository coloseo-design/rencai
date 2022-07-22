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
class crm_salesman_list_controller extends adminCommon
{

    function crm_class()
    {
        $cacheM     =   $this->MODEL('cache');

        $crmCache   =   $cacheM->GetCache(array('crm'));

        $this -> yunset(array('cache' => $crmCache, 'crmClassName' => $crmCache['crmclass_name'], 'crmDepart' => $crmCache['crmdata']['crm_depart']));
    }

    /**
     * @desc CRM管理 - 列表
     */
    function index_action()
    {
        $this->crm_class();

        $adminM     =   $this->MODEL('admin');

        $where['did']       =   0;
		$where['is_crm']	=	1;
        $typeStr    =   intval($_GET['type']);
        $keywordStr =   trim($_GET['keyword']);
        
        if (empty($keywordStr)) {

            if ($typeStr == 1) {
                
                $where['username']  =   array('like', $keywordStr);
            }else if ($typeStr == 2) {
                
                $where['name']      =   array('like', $keywordStr);
            }else if ($typeStr == 3) {
                
                $where['uid']       =   array('=', $keywordStr);
            }  
            
            $urlarr['type']         =   $typeStr;
            $urlarr['keyword']      =   $keywordStr;
        }
        $urlarr        	=   $_GET;
        $urlarr['page'] =   "{{page}}";
        $pageurl        =   Url($_GET['m'], $urlarr, 'admin');
        $pageM          =   $this->MODEL('page');
        $pages          =   $pageM->pageList('admin_user', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {
             
            if ($_GET['order'] && $_GET['t']) {
                
                $where['orderby']   =   $_GET['t'].','.$_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];
            } else {
                
                $where['orderby']   =   array('uid,desc');
            }
            $where['limit']         =   $pages['limit'];

            $rows   =   $adminM->getList($where, array('utype' => 'crm', 'field' => '`uid`,`name`,`status`,`username`,`did`,`depart`,`org`'));
            $this->yunset('userrows', $rows);
        }

        $this->yuntpl(array('admin/crm_salesman_list'));
    }

    /**
     * @desc 分配客户 - 列表页
     */
    public function assign_company_action()
    {
        $where['crm_uid']   =   0;
        $urlarr        		=   $_GET;
        $urlarr['c']        =   $_GET['c'];
        $urlarr['uid']      =   $_GET['uid'];
        $urlarr['page']     =   "{{page}}";
        
        $pageurl    =   Url($_GET['m'], $urlarr, 'admin');
        
        $pageM      =   $this->MODEL('page');
        $pages      =   $pageM->pageList('company', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {
            
            if ($_GET['order'] && $_GET['t']) {

                $where['orderby']   =   $_GET['t'].','.$_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];
            } else {
                
                $where['orderby']   =   array('uid,desc');
            }
            
            $where['limit'] =   $pages['limit'];
            $companyM       =   $this->MODEL('company');
            $rows           =   $companyM->getList($where, array('field' => '`uid`,`name`'));
            $this->yunset('company', $rows['list']);
        }

        $this->yuntpl(array('admin/crm_assign_company'));
    }

    /**
     * @desc 分配客户
     */
    public function ajax_assign_action()
    {
        $salesmanId =   isset($_POST['uid']) ? $_POST['uid'] : 0;
        $companyId  =   isset($_POST['comid']) ? $_POST['comid'] : '';

        if ($salesmanId == 0 || $companyId == '') {
            echo '请选择企业进行分配';
            exit();
        }
        $comids =   @explode(',',$companyId);
        $comM   =   $this->MODEL('company');
        $return =   $comM->upInfo($comids, '', array('crm_uid' => $salesmanId, 'crm_time' => time()));
        
        echo $return ? '1' : '分配失败，数据错误'; exit();
    }

    /**
     * @desc CRM 在职/离职 设置
     */ 
    function status_action()
    {
        $adminM =   $this->MODEL('admin');

        $uid    =   intval($_POST['uid']);

        $nid    =   $adminM->upInfo(array('status' => (int) $_POST['status']), array('uid' => $uid));

        if ($nid) {
            
			$status	=	(int)$_POST['status'];

			$msg	=	$status == 1 ? '在职' : '离职';

            $this->MODEL('log')->addAdminLog("业务员(ID:" . $uid . ")".$msg."设置成功！");
			
			if($status == 2){	//	离职设置，客户状态重置未分配

				$companyM   =   $this->MODEL('company');
				$companyM -> upInfo('', array('crm_uid' => $uid), array('crm_uid' => 0, 'crm_time' => 0));
			}

            $this->ACT_layer_msg("业务员(ID:" . $uid . ")".$msg."设置成功！", 9, $_SERVER['HTTP_REFERER'], 2);

        } else {

            $this->ACT_layer_msg("设置失败！", 8, $_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * @desc  批量转移客户 - 列表
     */
    public function shift_company_action()
    {
        $where['crm_uid']   =   $_GET['uid'];
		$urlarr        		=   $_GET;
        $urlarr['c']        =   $_GET['c'];
        $urlarr['uid']      =   $_GET['uid'];
        $urlarr['page']     =   "{{page}}";
        
        $pageurl            =   Url($_GET['m'], $urlarr, 'admin');
        
        $pageM  =   $this->MODEL('page');
        $pages  =   $pageM->pageList('company', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {
            if ($_GET['order'] && $_GET['t']) {

                $where['orderby']   =   $_GET['t'].','.$_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];
            } else {
                
                $where['orderby']   =   array('uid,desc');
            }
            $where['limit'] =   $pages['limit'];
            $companyM       =   $this->MODEL('company');
            $rows           =   $companyM->getList($where, array('field' => '`uid`,`name`,`isfollow`, `f_time'));
            $this->yunset('company', $rows['list']);
        }

        $adminM             =   $this->MODEL('admin');
         
        $uwhere['is_crm']   =   1;
        $uwhere['did']		=   0;
        $uwhere['uid']		=   array('<>', $_GET['uid']);

        $new_uid			=   $adminM -> getList($uwhere, array('field' => '`uid`,`name`'));
        $this->yunset('new_uid', $new_uid);

        $this->yuntpl(array('admin/crm_shift_company'));
    }

    /**
     * @desc 批量转移客户
     */
    public function ajax_shift_action()
    {
        $salesmanId =   isset($_POST['uid']) ? $_POST['uid'] : 0;
        $companyId  =   isset($_POST['comid']) ? $_POST['comid'] : '';
        $new_uid    =   isset($_POST['new_uid']) ? $_POST['new_uid'] : 0;

        if ($salesmanId == 0 || $companyId == '' || $new_uid == 0) {
            echo '请选择企业/业务员进行转移';
            exit();
        }
        $companyId  =   @explode(',', $companyId);
        
        $comM   =   $this->MODEL('company');
        $return =   $comM->upInfo($companyId, array('crm_uid' => $salesmanId), array('crm_uid' => $new_uid, 'crm_time' => time()));

        echo $return ? '1' : '转移失败，数据库错误'; exit();
    }
    
    function set_search(){
        
        $cacheM     =   $this->MODEL('cache');
        
        $crmCache   =   $cacheM -> GetCache(array('crm'));
        
        $this->yunset(array('cache'=>$crmCache,'crmClassName' => $crmCache['crmclass_name'], 'crmStatus' => $crmCache['crmdata']['client_status'], 'crmType' => $crmCache['crmdata']['client_type']));
        
        $yyzz       =   array('1'=>'已认证', '2'=>'待审核', '3'=>'未通过', '4' => '待认证');
        
        $ratingM    =   $this -> MODEL('rating');
        $ratingArr  =   $ratingM -> getList(array( 'category' => '1', 'orderby' => 'sort' ), array('field'=>'`id`,`name`'));
        $vipEtime   =   array('1'=>'三天内', '2'=>'七天内', '3'=>'一月内', '4' => '已到期');
        
        $orders     =   array('1'=>'客户ID','2'=> '更新日期', '3'=>'VIP到期时间');
        
        $lastFtime  =   array('1'=>'从未跟进', '2'=>'今天', '3'=>'三天未跟进', '4'=>'七天未跟进', '5'=>'一月未跟进', '6'=>'一百天未跟进');
        $nextFtime  =   array('1'=>'今天', '2'=>'明天', '3'=>'三天内', '4'=>'七天内', '5'=>'一月内');
        
        $this -> yunset(array('yyzzStatus' => $yyzz, 'ratingArr' => $ratingArr, 'vipEtime' => $vipEtime, 'orders' => $orders, 'lastFtime' => $lastFtime, 'nextFtime' => $nextFtime));
        
        //提取顾问信息
        $adminM    =   $this->MODEL('admin');
         
        $crmUser   =   $adminM -> getList(array('is_crm' => '1'));
        $this -> yunset('crmUser',$crmUser);
        
        $this->yunset('todayStart', strtotime('today'));
    }

    /**
     * @desc CRM客户列表
     */
    public function customer_list_action()
    {

        $this -> set_search();

        $comM       =   $this -> MODEL('company');
        $userInfoM  =   $this -> MODEL('userinfo');
        $crmM       =   $this -> MODEL('crm');

        if (isset($_GET['iscrm']) && $_GET['iscrm'] == 1){

            $where['crm_uid']   =   array('>', 0);
            $urlarr['iscrm']    =   $_GET['iscrm'];
        }

        if ($_GET['auid']) {

            $adminM             =   $this->MODEL('admin');
            $adminUserInfo      =   $adminM -> getAdminUser(array('uid' => $_GET['auid']));
            $this->yunset('adminUserInfo', $adminUserInfo);
            $where['crm_uid']   =   $_GET['auid'];
            $urlarr['auid']     =   $_GET['auid'];
        }

        if (!empty($_GET['crm_status'])) {

            $crm_status             =   intval($_GET['crm_status']);
            $where['crm_status']    =   $crm_status;
            $urlarr['crm_status']   =   $crm_status;
        }

        if (!empty($_GET['crmType'])) {

            $crmType                =   intval($_GET['crmType']);
            $where['crm_type']      =   $crmType;
            $urlarr['crmType']      =   $crmType;
        }

        if (!empty($_GET['yyzz_status'])) {

            $yyzz_status            =   intval($_GET['yyzz_status']);
            if ($yyzz_status == 1) {

                $where['yyzz_status']   =   $yyzz_status;
            } else if ($yyzz_status == 4) {

                $where['yyzz_status']   =   0;
            } else {
                if ($yyzz_status == 2) {

                    $certWhere          =   array('type' => 3, 'status' => 0);
                } elseif ($yyzz_status == 3) {

                    $certWhere          =   array('type' => 3, 'status' => 3);
                }
                $certList   =   $comM->getCertList($certWhere, array('field' => '`uid`'));
                $uidArrA    =   array();
                foreach ($certList as $cv) {
                    $uidArrA[]  =   $cv['uid'];
                }
                $where['uid']   =   array('in', pylode(',', $uidArrA));
            }
            $urlarr['yyzz_status']  =   $yyzz_status;
        }

        if (!empty($_GET['rating'])) {

            $rating             =    intval($_GET['rating']);
            $where['rating']    =   $rating;
            $urlarr['rating']   =   $rating;
        }

        if (isset($_GET['vip']) && $_GET['vip'] == 1) {

            $where['PHPYUNBTWSTART_A']  =   '';
            $where['rating'][]          =   array('>', 0, 'and');
            $where['rating'][]          =   array('<>', $this->config['sy_free_id'], 'and');
            $where['PHPYUNBTWEND_A']    =   '';
            $urlarr['vip']              =   $_GET['vip'];
        }

        if (!empty($_GET['vipetime'])) {

            $etime  =   intval($_GET['vipetime']);

            if ($etime != 4) {

                if ($etime == 1) {
                    $num    =   '+3 days';
                }else if ($etime == 2) {
                    $num    =   '+7 days';
                }elseif ($etime == 3){
                    $num    =   '+1 month';
                }else if ($etime == 5) {
                    $num    =   '+15 days';
                }

                $where['PHPYUNBTWSTART_A']  =   '';
                $where['vipetime'][]        =   array('>', time(),'AND');
                $where['vipetime'][]        =   array('<', strtotime($num),'AND');
                $where['PHPYUNBTWEND_A']    =   '';

            }else{

                $where['PHPYUNBTWSTART_A']  =   '';
                $where['vipetime'][]        =   array('<', time(), '');
                $where['vipetime'][]        =   array('>', '0', '');
                $where['PHPYUNBTWEND_A']    =   '';
            }

            $urlarr['vipetime'] =   $etime;

        }

        if (isset($_GET['reg']) && $_GET['reg'] == 1) {

            $rList      =   $userInfoM->getList(array('reg_date' => array('>=', strtotime(date('Y-m-d'))), 'usertype' => 2), array('field' => 'uid'));
            $uidArrR    =   array();
            foreach ($rList as $rv) {
                $uidArrR[]  =   $rv['uid'];
            }
            $where['uid']   =   array('in', pylode(',', $uidArrR));
        }

        if (!empty($_GET['regStart']) || !empty($_GET['regEnd'])) {

            $regStart   =   strtotime($_GET['regStart']);
            $regEnd     =   strtotime($_GET['regEnd']) + 86400;

            $mWhere['PHPYUNBTWSTART_A']     =   '';
            $mWhere['reg_date'][]           =   array('>', $regStart, 'AND');
            $mWhere['reg_date'][]           =   array('<', $regEnd, 'AND');
            $mWhere['PHPYUNBTWEND_A']       =   '';

            $memberList     =   $userInfoM -> getList($mWhere, array('field' => 'uid'));

            $uidArrB        =   array();
            foreach ($memberList as $mv) {
                $uidArrB[]  =   $mv['uid'];
            }

            $where['uid']   =   array('in', pylode(',', $uidArrB));

            $urlarr['regStart'] =   $_GET['regStart'];
            $urlarr['regEnd']   =   $_GET['regEnd'];
        }

        if (!empty($_GET['isfollow'])) {
            $where['isfollow']  =   $_GET['isfollow'] == 1 ? 1 : 0;
            $urlarr['isfollow'] =   $_GET['isfollow'];
        }

        if (isset($_GET['newF'])){

            $where['f_time']    =   array('>', strtotime(date('Y-m-d')));
            $urlarr['newF']     =   $_GET['newF'];
        }

        if (isset($_GET['recent'])){

            $where['f_time']    =   array('>', strtotime('-7 days'));
            $urlarr['recent']   =   $_GET['recent'];
        }

        if (!empty($_GET['lastFtime'])) {

            $lastFtime = intval($_GET['lastFtime']);

            if ($lastFtime == 1) {

                $where['isfollow'] = '0';
            } else {

                $where['isfollow'] = 1;

                if ($lastFtime == 2) {

                    $where['f_time'] = array('>', strtotime(date('Y-m-d')));
                } elseif ($lastFtime == 3) {

                    $where['f_time'] = array('<', strtotime('-3 day'));
                } elseif ($lastFtime == 4) {

                    $where['f_time'] = array('<', strtotime('-7 day'));
                } elseif ($lastFtime == 5) {

                    $where['f_time'] = array('<', strtotime('-1 month'));
                } elseif ($lastFtime == 6) {

                    $where['f_time'] = array('<', strtotime('-100 day'));
                }
            }
            $urlarr['lastFtime'] = $lastFtime;
        }

        if (!empty($_GET['nextFtime'])) {

            $nextFtime  =   intval($_GET['nextFtime']);

            $taskWhere  =   array();

            if($nextFtime == 1){

                $taskWhere['stime']             =   array('<', strtotime(date('Y-m-d 23:59:59')));  //  之前未完成的跟进同步显示
            }elseif ($nextFtime == 2){

                $taskWhere['PHPYUNBTWSTART_A']  =   '';
                $taskWhere['stime'][]           =   array('>', strtotime(date('Y-m-d 23:59:59')));
                $taskWhere['stime'][]           =   array('<', strtotime(date('Y-m-d 23:59:59')) + 86400);
                $taskWhere['PHPYUNBTWEND_A']    =   '';
            }elseif ($nextFtime == 3){

                $taskWhere['PHPYUNBTWSTART_A']  =   '';
                $taskWhere['stime'][]           =   array('>', time());
                $taskWhere['stime'][]           =   array('<', strtotime('+3 day'));
                $taskWhere['PHPYUNBTWEND_A']    =   '';
            }elseif ($nextFtime == 4){

                $taskWhere['PHPYUNBTWSTART_A']  =   '';
                $taskWhere['stime'][]           =   array('>', time());
                $taskWhere['stime'][]           =   array('<', strtotime('+1 week'));
                $taskWhere['PHPYUNBTWEND_A']    =   '';
            }elseif ($nextFtime == 5){

                $taskWhere['PHPYUNBTWSTART_A']  =   '';
                $taskWhere['stime'][]           =   array('>', time());
                $taskWhere['stime'][]           =   array('<', strtotime('+1 month'));
                $taskWhere['PHPYUNBTWEND_A']    =   '';
            }

            if($_GET['auid']){

                $taskWhere['uid']   =   $_GET['auid'];
            }
            $taskList   =   $crmM -> getTaskList($taskWhere, array('field' => '`comid`'));

            $uidArrN    =   array();
            foreach ($taskList as $tv) {

                $uidArrN[]  =   $tv['comid'];
            }

            $where['uid']   =   array('in', pylode(',', $uidArrN));
        }

        if ($_GET['keyword']) {

            $keywordStr     =   trim($_GET['keyword']);

            $typeStr        =   intval($_GET['crm_type']);

            if (!empty($keywordStr)) {

                if ($typeStr == 1) {

                    $where['name']      =   array('like', $keywordStr);

                }else if($typeStr == 2){

                    $where['linkman']   =   array('like', $keywordStr);

                }else if($typeStr == 3){

                    $where['linktel']   =   array('like', $keywordStr);

                }else if($typeStr == 4){

                    $where['uid']       =   array('=', $keywordStr);
                }

            }
            $urlarr['crm_type']	    =	$typeStr;
            $urlarr['keyword']		=	$keywordStr;
        }

        if ($_GET['time'] || $_GET['stime']) {
            if ($_GET['time']) {
                if ($_GET['time'] == -1) {
                    $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                    $timeEnd    =   time();
                } elseif ($_GET['time'] == 1) {
                    $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 86400;
                    $timeEnd    =   mktime(23, 59, 59, date('m'), date('d'), date('Y')) - 86400;
                } else {
                    $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('Y')) - $_GET['time'] * 86400;
                    $timeEnd    =   mktime(23, 59, 59, date('m'), date('d'), date('Y'));
                }
                $urlarr['time'] =   $_GET['time'];
            }else if ($_GET['stime']) {
                $stime          =   explode('-', $_GET['stime']);
                $etime          =   explode('-', $_GET['etime']);
                $timeBegin      =   mktime(0, 0, 0, $stime[1], $stime[2], $stime[0]);
                $timeEnd        =   mktime(23, 59, 59, $etime[1], $etime[2], $etime[0]);
                $urlarr['stime']=   $_GET['stime'];
            }

            $where['PHPYUNBTWSTART_A']  =   '';
            $where['crm_time'][]        =   array('>=', $timeBegin, '');
            $where['crm_time'][]        =   array('<', $timeEnd, '');
            $where['PHPYUNBTWEND_A']    =   '';
        }

        if ($_GET['crm_time']){

            $timeA  =   explode('-', $_GET['crm_time']);
            $month  =   (int)$timeA[1];

            $sTime  =   mktime(0, 0, 0, $month, 1, $timeA[0]);
            $eTime  =   mktime(23, 59, 59, $month+1, 0, $timeA[0]);

            $where['PHPYUNBTWSTART_A']  =   '';
            $where['crm_time'][]        =   array('>=', $sTime, '');
            $where['crm_time'][]        =   array('<', $eTime, '');
            $where['PHPYUNBTWEND_A']    =   '';
            $urlarr['crm_time']         =   $_GET['crm_time'];
        }

        if (!empty($_GET['ordertype'])) {

            $orderType  = intval($_GET['ordertype']);

            if ($orderType == 1) {
                $order  =   'uid';
            }else if ($orderType == 2) {
                $order  =   'lastupdate';
            }else if ($orderType == 3) {
                $order  =   'vipetime';
            }

            $urlarr['ordertype']    =   $orderType;
        }

        $urlarr        		=   $_GET;
        $urlarr['page']	    =	'{{page}}';

        $urlarr['c']        =	$_GET['c'];

        $pageurl            =	Url($_GET['m'], $urlarr, 'admin');

        $pageM              =	$this  -> MODEL('page');

        $pages              =	$pageM -> pageList('company', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {

            if ($_GET['order']) {

                if ($_GET['t']) {

                    $where['orderby']   =   $_GET['t'].','.$_GET['order'];
                    $urlarr['t']        =   $_GET['t'];
                }else if($order){

                    $where['orderby']   =   $order.','.$_GET['order'];
                }else{

                    $where['orderby']   =   'uid';
                }

                $urlarr['order']    =   $_GET['order'];
            }

            $where['limit']         =   $pages['limit'];

            $listA                  =   $comM -> getList($where,array('utype' => 'crm'));
            $this -> yunset(array('rows' => $listA['list'],'auid' => intval($_SESSION['auid'])));
        }


        /**
         * @desc 今日跟进任务 ;今日需跟进客户数量
         */
        $toWhere        =   array(
            'uid'   =>  intval($_SESSION['auid']),
            'type'  =>  '22',
            'status'=>  '1',
            'stime' =>  array('<', strtotime(date('Y-m-d 23:59:59')))
        );
        $toFollowList   =   $crmM -> getTaskList($toWhere, array('field' => '`comid`'));

        $toUids =   array();
        foreach ($toFollowList as $toV) {
            $toUids[$toV['comid']]  =   $toV['comid'];
        }
        $todayNum   =   count($toUids) > 0 ? count($toUids) : 0;

        /**
         * @desc 跟进期限内未跟进客户数量 【期限参数：sy_crm_follow_deadline】
         */
        if ((int)$this->config['sy_crm_follow_deadline'] > 0) {

            $noFollowDeadList   =   $crmM -> getConcernList(array('auid' => intval($_SESSION['auid']), 'atime' => array('<', strtotime('- '.$this->config['sy_crm_follow_deadline'].' day'))), array('field' => '`uid`'));

            $noFollowUids   =   array();
            foreach ($noFollowDeadList as $noV) {
                $noFollowUids[$noV['uid']] = $noV['uid'];
            }
            $noNum1 =   count($noFollowUids) > 0 ? count($noFollowUids) : 0;    //  跟进后查过期限未跟进客户

            $noNum2 =   $comM -> getCompanyNum(array('crm_uid' => $_SESSION['auid'], 'isfollow' => '0', 'crm_time' => array('<', strtotime('- '.$this->config['sy_crm_follow_deadline'].' day')))); // 超期限从未跟进

            $noFollowNum    =   $noNum1 + $noNum2;
        }

        $this -> yunset(array('todayNum' => $todayNum, 'noFollowNum' => $noFollowNum));

        $AdminM			=	$this -> MODEL('admin');
        $adminUserList	=	$AdminM -> getList(array(),array('field'=>'`uid`,username'));
        $this->yunset('adminUserList',$adminUserList);


        $this->yuntpl(array('admin/crm_customer_list'));
    }
}
?>