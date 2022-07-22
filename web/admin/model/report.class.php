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

class report_controller extends adminCommon
{

    function index_action()
    {

        $reportM    =   $this->MODEL('report');

        $where      =   array();

        $type       =   intval($_GET['type']);
        $ut         =   intval($_GET['ut']);

        $keywordStr =   trim($_GET['keyword']);
        $ftypeStr   =   intval($_GET['f_type']);
        $ptypeStr   =   intval($_GET['p_type']);

        if ($type == 0) {

            $where['usertype']  =   $ut == 2 ? 2 : 1;
            $where['type']      =   $type;

            if (!empty($keywordStr)) {
                if ($ut == 2) {     //  简历

                    $reports    =   $this->obj->select_all('report', array('usertype' => 2, 'type' => 0), '`eid`,`p_uid`,`c_uid`');
                    $eids   =   $uids   =   $comIds =   array();
                    foreach ($reports as $rk => $rv) {
                        $eids[$rv['eid']]       =   $rv['eid'];
                        $comIds[$rv['p_uid']]   =   $rv['p_uid'];
                    }
                    if ($ftypeStr == 1) {        //  简历名称

                        $resumeA            =   $this->obj->select_all('resume_expect', array('id' => array('in', pylode(',', $eids)), 'name' => array('like', $keywordStr)), 'id');

                        if (!empty($resumeA)) {
                            $reIds          =   array();
                            foreach ($resumeA as $rak => $rav) {
                                $reIds[]    =   $rav['id'];
                            }
                        }
                        $where['eid']       =   array('in', pylode(',', $reIds));
                    } elseif ($ftypeStr == 2) {   //  个人姓名

                        $where['r_name']    =   array('like', $keywordStr);
                    } elseif ($ftypeStr == 3) {   //  企业名称

                        $coms               =   $this->obj->select_all('company', array('uid' => array('in', pylode(',', $comIds)), 'name' => array('like', $keywordStr)), 'uid');
                        if (!empty($coms)) {

                            $puids          =   array();
                            foreach ($coms as $ck => $cv) {
                                $puids[]    =   $cv['uid'];
                            }
                        }
                        $where['p_uid']     =   array('in', pylode(',', $puids));
                    }
                } else {

                    $reports    =   $this->obj->select_all('report', array('usertype' => 1, 'type' => 0), '`eid`,`p_uid`,`c_uid`');

                    $jobIds     =   $r_uids =   array();
                    foreach ($reports as $rk => $rv) {

                        $jobIds[$rv['eid']]     =   $rv['eid'];
                        $r_uids[$rv['c_uid']]   =   $rv['c_uid'];
                    }

                    if ($ftypeStr == 1) {        //  职位名称

                        $jobs           =   $this->obj->select_all('company_job', array('name' => array('like', $keywordStr), 'id' => array('in', pylode(',', $jobIds))), 'id');
                        if (!empty($jobs)) {
                            $eids       =   array();
                            foreach ($jobs as $jk => $jv) {
                                $eids[] =   $jv['id'];
                            }
                        }
                        $where['eid']   =   array('in', pylode(',', $eids));
                    } elseif ($ftypeStr == 2) {   //  企业名称

                        $where['r_name']=   array('like', $keywordStr);
                    } elseif ($ftypeStr == 3) {   //  个人姓名

                        $resumes        =   $this->obj->select_all('resume', array('uid' => array('in', pylode(',', $r_uids)), 'name' => array('like', $keywordStr)), 'uid');
                        $uids           =   array();
                        if (!empty($resumes)) {  //
                            foreach ($resumes as $rek => $rev) {
                                $uids[] =   $rev['uid'];
                            }
                        }
                        $where['c_uid'] =   array('in', pylode(',', $uids));
                    }
                }

                $urlarr['f_type']       =   $ftypeStr;
                $urlarr['keyword']      =   $keywordStr;
            }

            $type           =   0;
            $rowName        =   'userrows';
            $urlarr['ut']   =   $ut;
            $this->yunset('ut', $ut);

        } else if ($type < 3) {

            $where['type']  =   $type;

            if (!empty($keywordStr)) {
                if ($ptypeStr == 1) {

                    $where['r_name']    =   array('like', $keywordStr);
                } else {

                    $where['username']  =   array('like', $keywordStr);
                }

                $urlarr['p_type']       =   $ptypeStr;
                $urlarr['keyword']      =   $keywordStr;
            }
            $rowName                    =   'q_report';
            $urlarr['type']             =   $type;
        } else if ($type == 3) {

            $where['type']  =   $type;

            if (isset($keywordStr) && !empty($keywordStr)) {

                $where['PHPYUNBTWSTART_A']  =   '';
                $where['username']          =   array('like', $keywordStr, 'OR');
                $where['r_reason']          =   array('like', $keywordStr, 'OR');
                $where['PHPYUNBTWEND_A']    =   '';
            }

            $rowName                    =   'q_report';
            $urlarr['type']             =   $type;
        } else if ($type == 4) {

            $where['type']  =   $type;

            if (!empty($keywordStr)) {
                if ($ptypeStr == 1) {

                    $where['r_name']    =   array('like', $keywordStr);
                } else {

                    $where['username']  =   array('like', $keywordStr);
                }

                $urlarr['p_type']       =   $ptypeStr;
                $urlarr['keyword']      =   $keywordStr;
            }
            $rowName                    =   'chat_report';
            $urlarr['type']             =   $type;
        } 

        $urlarr['page'] =   '{{page}}';
        $pageurl        =   Url($_GET['m'], $urlarr, 'admin');

        $pageM      =   $this->MODEL('page');
        $pages      =   $pageM->pageList('report', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {
            if ($_GET['order']) {

                $where['orderby']   =   $_GET['t'].",".$_GET['order'];
            } else {

                $where['orderby']   =   'id,desc';
            }
            $where['limit']         =   $pages['limit'];
            $urlarr['order']        =   $_GET['order'];
            $urlarr['t']            =   $_GET['t'];

            $List   = $reportM->getReportList($where, array('utype' => 'admin', 'type' => $type));

            $this->yunset($rowName, $List['list']);
        }

        $back_url   =   $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
        $this->yunset('type', $type);
        $this->yunset('back_url', $back_url);

        $this->yuntpl(array('admin/admin_report_userlist'));
    }

    function recommend_action()
    {
        $reportM = $this->MODEL('report');
        $logM = $this->MODEL('log');

        $data[$_GET['type']] = $_GET['rec'];
        $where['id'] = $_GET['id'];
        $where['type'] = '1';
        $nid = $reportM->upReport($where, $data);

        $logM->addAdminLog("举报问答(ID:" . $_GET['id'] . ")设置是否处理");
        echo $nid ? 1 : 0;
        die;
    }

    function result_action()
    {
        $reportM = $this->MODEL('report');
        $adminM = $this->MODEL('admin');

        $info = $reportM->getReportOne(array('id' => intval($_POST['id'])), array('field' => '`result`,`rtime`,`admin`'));
        if ($info['admin']) {
            $adminname = $adminM->getAdminUser(array('uid' => $info['admin']), array('field' => '`name`'));
            $info['admin'] = $adminname['name'];
            $info['rtime'] = date('Y-m-d H:i', $info['rtime']);
        }
        echo json_encode($info);
        die;
    }

    function saveresult_action()
    {

        $reportM=   $this->MODEL('report');

        $id     =   intval($_POST['pid']);

        $result =   trim($_POST['result']);

        $eid    =   intval($_POST['eid']);
        $uid    =   intval($_POST['uid']);

        if (isset($_POST['ut'])){

            if ($_POST['ut'] == 1){         //  处理举报职位

                $upData =   array(

                    'result'    =>  $result,
                    'status'    =>  1,
                    'rtime'     =>  time(),
                    'admin'     =>  $_SESSION['auid']
                );

                $return =   $reportM->upReport(array('id' => $id), $upData);
                if ($return){

                    $logM   =   $this->MODEL('log');
                    $logM->addAdminLog("职位投诉(ID:" . $id . ")处理");
                    $this->ACT_layer_msg('操作成功！', 9, $_SERVER['HTTP_REFERER']);
                }else{

                    $this->ACT_layer_msg('操作失败，请重试！', 8, $_SERVER['HTTP_REFERER']);
                }

            }elseif($_POST['ut'] == 4){//处理举报聊天

                if($_POST['chatresult'] == 1){

                    $report =   $reportM->getReportOne(array('id' => $id));
                    
                    $chatM  =  $this -> MODEL('chat');
            
                    $chatM->delChatLog(array('toid'=>$report['c_uid'],'fromid'=>$report['p_uid'],'tusertype'=>$report['c_usertype'],'fusertype'=>$report['usertype']));
                }
                

                $upData =   array(

                    'result'    =>  $result,
                    'status'    =>  1,
                    'rtime'     =>  time(),
                    'admin'     =>  $_SESSION['auid']
                );

                $return =   $reportM->upReport(array('id' => $id), $upData);
                if ($return){

                    $logM   =   $this->MODEL('log');
                    $logM->addAdminLog("聊天(ID:" . $id . ")处理");
                    $this->ACT_layer_msg('操作成功！', 9, $_SERVER['HTTP_REFERER']);
                }else{

                    $this->ACT_layer_msg('操作失败，请重试！', 8, $_SERVER['HTTP_REFERER']);
                }
            }elseif ($_POST['ut'] == 2){    //  处理举报简历

                $downM      =   $this->MODEL('downresume');
                $statisM    =   $this->MODEL('statis');
                $integralM  =   $this->MODEL('integral');
                $orderM     =   $this->MODEL('companyorder');
                $rtComIds = array();// 初始化需要返还下载数量的企业用户id

                if (isset($_POST['tongbu ']) && $_POST['tongbu'] == 1){     //  同步处理

                    $reportList     =   $reportM -> getReportList(array('eid' => $eid, 'type' => 0, 'usertype' => 2, 'status' => 0));
                    $reportResume   =   $reportList['list'];
                    $rids   =   $comIds =   array();
                    foreach ($reportResume as $key => $val){

                        $rids[]     =   $val['id'];// 记录待处理的举报记录id
                        $comIds[]   =   $val['p_uid'];
                    }

                    if (isset($_POST['datafh']) && $_POST['datafh'] == 1){  //  返还企业特权（积分/简历数）

                        $comIdA =   $dReport    =   array();
                        $dResume=   $downM -> getSimpleList(array('eid' => $eid, 'comid' => array('in', pylode(",", $comIds))));
                        foreach ($reportResume as $key => $val){
                            foreach ($dResume as $k => $v) {
                                if ($v['comid'] == $val['p_uid'] && $v['eid'] == $val['eid'] && $val['datafh']!= 1) {

                                    $dReport[]  =   $val;
                                    $comIdA[]   =   $val['p_uid'];
                                }
                            }
                        }

                        $notUid =   array();

                        $order  =   $orderM->getList(array('type' => 19, 'sid' => $eid, 'order_remark' => array('like', '下载简历'), 'uid' => array('in', pylode(',', $comIdA))));
                        $compay =   $integralM->getList(array('type' => 1, 'eid' => $eid, 'pay_type' => '12', 'pay_remark' => array('like', '简历下载'), 'com_id' => array('in', pylode(',', $comIdA))));
                        foreach ($order as $k => $v) {
                            $notUid[]   =   $v['uid'];
                            $integralM->company_invtal($v['uid'], 2, $v['order_price'], true, '举报简历返还金额', true, 2, 'packpay', 99);
                        }
                        foreach ($compay as $k => $v) {
                            $noUid[]    =   $v['com_id'];
                            $integralM->company_invtal($v['com_id'], 2, abs($v['order_price']), true, '举报简历返还积分', true, 2, 'integral', 99);
                        }
                        foreach ($dReport as $drk => $drv) {
                            if (!in_array($drv['p_uid'], $notUid) && in_array($drv['p_uid'], $comIdA)) {
                                !in_array($drv['p_uid'], $rtComIds) && array_push($rtComIds, $drv['p_uid']);// 记录返还下载数量的企业用户id
                                // 没有充值购买记录，有下载记录的，返还下载数量
                                $statisM->upInfo(array('down_resume' => array('+', 1)), array('usertype' => 2, 'uid' => $drv['p_uid']));
                            }
                        }
                    }

                    $where['id']    =   array('in', pylode(",", $rids));
                }else{
                    $rids = array($id);// 待处理的举报记录id
                    $report =   $reportM->getReportOne(array('id' => $id), array('field' => '`p_uid`, `datafh`'));

                    if (intval($_POST['datafh']) == 1 && $report['datafh']!= 1) {

                        $comId      =   $report['p_uid'];

                        $dResume    =   $downM->getDownResumeInfo(array('eid' => $eid, 'uid' => $uid, 'comid' => $comId), array('field' => '`eid`'));
                        if (!empty($dResume)) {

                            $order  =   $orderM->getInfo(array('type' => 19, 'sid' => $eid, 'order_remark' => array('like', '下载简历'), 'uid' => $comId), array('field' => '`order_price`'));
                            $compay =   $integralM->getInfo(array('type' => 1, 'eid' => $eid, 'pay_type' => '12', 'pay_remark' => array('like', '下载简历'), 'com_id' => $comId), array('field' => '`order_price`'));
                        }

                        if (isset($order) && !empty($order)) {
                            $integralM->company_invtal($comId, 2, $order['order_price'], true, '举报简历返还金额', true, 2, 'packpay', 99);
                        }
                        if (isset($compay) && !empty($compay)) {
                            $integralM->company_invtal($comId, 2, abs($compay['order_price']), true, '举报简历返还积分', true, 2, 'integral', 99);
                        }
                        if (empty($order) && empty($compay) && !empty($dResume)) {
                            !in_array($comId, $rtComIds) && array_push($rtComIds, $comId);// 记录返还下载数量的企业用户id
                            // 没有充值购买记录，有下载记录的，返还下载数量
                            $statisM->upInfo(array('down_resume' => array('+', 1)), array('usertype' => 2, 'uid' => $comId));
                        }
                    }
                    $where['id']    =   intval($_POST['pid']);
                }

                $upData     =   array(
                    'status'    =>  1,
                    'result'    =>  $result,
                    'rtime'     =>  time(),
                    'admin'     =>  $_SESSION['auid'],
                    'datafh'    =>  $_POST['datafh']
                );
                $return     =   $reportM->upReport($where, $upData);
                if ($return){

                    $logM   =   $this->MODEL('log');
                    $m = $rtComIds ? "，已为ID为(" . implode(',', $rtComIds) . ")的企业用户返还简历下载数量" : "";
                    $logM->addAdminLog("简历投诉(ID:" . implode(',', $rids) . ")处理" . $m);
                    $this->ACT_layer_msg("操作成功！", 9, $_SERVER['HTTP_REFERER']);
                }else{

                    $this->ACT_layer_msg("操作失败，请重试！", 8, $_SERVER['HTTP_REFERER']);
                }
            }
        }
    }

    function saveresultall_action()
    {


        $reportM    =   $this->MODEL('report');
        $resumeM    =   $this->MODEL('resume');
        $statisM    =   $this->MODEL('statis');
        $integralM  =   $this->MODEL('integral');
        $orderM     =   $this->MODEL('companyorder');
        $downM      =   $this->MODEL('downresume');

        if (!empty($_POST['rid'])) {

            $rids   = explode(',', $_POST['rid']);

            if (isset($_POST['datafh']) && intval($_POST['datafh']) == 1) {

                $reportArr  =   $reportM->getReportList(array('id' => array('in', pylode(",", $rids))));
                $reportList =   $reportArr['list'];
                $comid  =   $dreport    =   array();
                foreach ($reportList as $key => $val) {

                    $dResume    =   $downM->getDownNum(array('eid' => $val['eid'], 'uid' => $val['c_uid'], 'comid' => $val['p_uid'], 'usertype' => 2));

                    if ($dResume > 0 && $val['datafh'] != 1) {

                        $val['fhtype']  =   1;
                        $comid[]        =   $val['p_uid'];
                        $dreport[]      =   $val;
                    }
                }

                if (isset($dreport) && !empty($dreport)) {


                    $order  =   $orderM->getList(array('type' => 19, 'order_remark' => array('like', '下载简历'), 'uid' => array('in', pylode(',', $comid))));
                    $compay =   $integralM->getList(array('type' => 1, 'pay_type' => '12', 'pay_remark' => array('like', '简历下载'), 'com_id' => array('in', pylode(',', $comid))));
                    foreach ($dreport as $key => $val) {
                        foreach ($order as $k => $v) {
                            if ($val['p_uid'] == $v['uid'] && $val['eid'] == $v['sid']) {

                                $dreport[$key]['fhtype']    =   2;//金额操作
                                $dreport[$key]['fhprice']   =   $v['order_price'];
                            }
                        }
                        foreach ($compay as $k => $v) {
                            if ($val['p_uid'] == $v['com_id'] && $val['eid'] == $v['eid']) {
                                if ($dreport[$key]['fhtype'] == 2) {

                                    $dreport[$key]['fhtype']        =   4;//金额+积分操作
                                    $dreport[$key]['fhprice_two']   =   abs($v['order_price']);
                                } else {

                                    $dreport[$key]['fhtype']        =   3;//积分操作
                                    $dreport[$key]['fhprice']       =   abs($v['order_price']);
                                }
                            }
                        }
                    }

                    foreach ($dreport as $key => $val) {
                        if ($val['fhtype'] == 2) {

                            $integralM->company_invtal($val['p_uid'], 2, $val['fhprice'], true, '举报简历返还金额', true, 2, 'packpay', 99);
                        } elseif ($val['fhtype'] == 3) {

                            $integralM->company_invtal($val['p_uid'], 2, $val['fhprice'], true, '举报简历返还积分', true, 2, 'integral', 99);
                        } elseif ($val['fhtype'] == 4) {

                            $integralM->company_invtal($val['p_uid'], 2, $val['fhprice'], true, '举报简历返还金额', true, 2, 'packpay', 99);
                            $integralM->company_invtal($val['p_uid'], 2, $val['fhprice_two'], true, '举报简历返还积分', true, 2, 'integral', 99);
                        } else {

                            $statisM->upInfo(array('down_resume' => array('+', 1)), array('usertype' => 2, 'uid' => $val['p_uid']));
                        }
                    }
                }
            }
            $data['datafh'] =   $_POST['datafh'];
            $data['result'] =   trim($_POST['result']);
            $data['admin']  =   $_SESSION['auid'];
            $data['rtime']  =   time();
            $data['status'] =   1;
            $where['id']    =   array('in', pylode(",", $rids));

            $return         =   $reportM->upReport($where, $data);
            if ($return){

                $logM   =   $this->MODEL('log');
                $logM->addAdminLog("简历投诉(ID:" . pylode(',', $rids) . ")处理");
                $this->ACT_layer_msg("操作成功！", 9, $_SERVER['HTTP_REFERER']);
            }else{

                $this->ACT_layer_msg("操作失败，请重试！", 8, $_SERVER['HTTP_REFERER']);
            }
        }
    }


    /**
     * @desc 删除举报简历,返还套餐特权
     */
    function delresume_action()
    {

        $reportM    =   $this->MODEL('report');
        $resumeM    =   $this->MODEL('resume');
        $statisM    =   $this->MODEL('statis');

        $integralM  =   $this->MODEL('integral');
        $orderM     =   $this->MODEL('companyorder');
        $downM      =   $this->MODEL('downresume');

        $eid        =   intval($_GET['eid']);
        $id         =   intval($_GET['id']);
        $uid        =   intval($_GET['uid']);

        $report     =   $reportM->getReportOne(array('id' => $id), array('field' => '`p_uid`, `datafh`'));
        $comid      =   intval($report['p_uid']);

        $dresume    =   $downM->getDownResumeInfo(array('eid' => $eid, 'uid' => $uid, 'comid' => $comid), array('field' => '`eid`'));

        if (!empty($dresume)) {

            $order  =   $orderM->getInfo(array('type' => 19, 'sid' => $eid, 'order_remark' => array('like', '下载简历'), 'uid' => $comid), array('field' => '`order_price`'));
            $compay =   $integralM->getInfo(array('type' => 1, 'eid' => $eid, 'pay_type' => '12', 'pay_remark' => array('like', '下载简历'), 'com_id' => $comid), array('field' => '`order_price`'));
        }
        $result     =   $resumeM->delResume($eid, array('utype' => 'admin'));

        if ($result) {

            if (!empty($order) && is_array($order) && $report['datafh'] != 1) {

                $integralM->company_invtal($comid, 2, $order['order_price'], true, '举报简历返还金额', true, 2, 'packpay', 99);
            }
            if (!empty($compay) && is_array($compay) && $report['datafh'] != 1) {

                $integralM->company_invtal($comid, 2, abs($compay['order_price']), true, '举报简历返还积分', true, 2, 'integral', 99);
            }
            if (empty($order) && empty($compay) && !empty($dresume) && $report['datafh'] != 1) {
                // 没有充值购买记录，有下载记录的，返还下载数量
                $statisM->upInfo(array('down_resume' => array('+', 1)), array('usertype' => 2, 'uid' => $comid));
            }

            $statisM->upInfo(array('resume_num' => array('-', 1)), array('usertype' => 1, 'uid' => $uid));

            if ($result){

                $return =   array('msg' => '投诉简历（ID:'.$eid.'）删除成功', 'errcode' => 9, 'layertype' => 0);
            }else{
                $return =   array('msg' => '投诉简历（ID:'.$eid.'）删除失败', 'errcode' => 8, 'layertype' => 0);
            }

            $this->layer_msg($return['msg'], $return['errcode'], $return['layertype'], $_SERVER['HTTP_REFERER'], 2, 1);
        }
    }

    /**
     * @desc 批量删除举报简历
     */
    function delresumeall_action()
    {

        $reportM    =   $this->MODEL('report');
        $statisM    =   $this->MODEL('statis');
        $integralM  =   $this->MODEL('integral');
        $orderM     =   $this->MODEL('companyorder');
        $downM      =   $this->MODEL('downresume');
        $resumeM    =   $this->MODEL('resume');

        if (!empty($_POST['rid'])) {

            $rids       =   explode(",", $_POST['rid']);
            $reportArr  =   $reportM->getReportList(array('id' => array('in', pylode(",", $rids))));

            $reportList =   $reportArr['list'];

            $comid      =   $dreport    =   $resumeIds  =   array();

            foreach ($reportList as $key => $val) {

                $resumeIds[]    =   $val['eid'];

                $dresume=   $downM->getDownNum(array('eid' => $val['eid'], 'uid' => $val['c_uid'], 'comid' => $val['p_uid'], 'usertype' => 2));

                if ($dresume > 0 && $val['datafh']!=1) {

                    $val['fhtype']  =   1;
                    $comid[]        =   $val['p_uid'];
                    $dreport[]      =   $val;
                }
            }

            $result     =   $resumeM->delResume($resumeIds, array('utype' => 'admin'));

            if ($result && isset($comid) && !empty($comid)) {

                $order  =   $orderM->getList(array('type' => 19, 'order_remark' => array('like', '下载简历'), 'uid' => array('in', pylode(',', $comid))));
                $compay =   $integralM->getList(array('type' => 1, 'pay_type' => '12', 'pay_remark' => array('like', '简历下载'), 'com_id' => array('in', pylode(',', $comid))));

                foreach ($dreport as $key => $val) {
                    foreach ($order as $k => $v) {
                        if ($val['p_uid'] == $v['uid'] && $val['eid'] == $v['sid']) {

                            $dreport[$key]['fhtype']    =   2;//金额操作
                            $dreport[$key]['fhprice']   =   $v['order_price'];
                        }
                    }
                    foreach ($compay as $k => $v) {
                        if ($val['p_uid'] == $v['com_id'] && $val['eid'] == $v['eid']) {
                            if ($dreport[$key]['fhtype'] == 2) {

                                $dreport[$key]['fhtype']        =   4;//金额+积分操作
                                $dreport[$key]['fhprice_two']   =   abs($v['order_price']);
                            } else {

                                $dreport[$key]['fhtype']        =   3;//积分操作
                                $dreport[$key]['fhprice']       =   abs($v['order_price']);
                            }
                        }
                    }
                }

                foreach ($dreport as $key => $val) {
                    if ($val['fhtype'] == 2) {

                        $integralM->company_invtal($val['p_uid'], 2, $val['fhprice'], true, '举报简历返还金额', true, 2, 'packpay', 99);
                    } elseif ($val['fhtype'] == 3) {

                        $integralM->company_invtal($val['p_uid'], 2, $val['fhprice'], true, '举报简历返还积分', true, 2, 'integral', 99);
                    } elseif ($val['fhtype'] == 4) {

                        $integralM->company_invtal($val['p_uid'], 2, $val['fhprice'], true, '举报简历返还金额', true, 2, 'packpay', 99);
                        $integralM->company_invtal($val['p_uid'], 2, $val['fhprice_two'], true, '举报简历返还积分', true, 2, 'integral', 99);
                    } else {

                        $statisM->upInfo(array('down_resume' => array('+', 1)), array('usertype' => 2, 'uid' => $val['p_uid']));
                    }
                }
            }
            if ($result){

                $return =   array('msg' => '投诉简历（ID:'.pylode(',', $resumeIds).'）删除成功', 'errcode' => 9, 'layertype' => 1);
            }else{
                $return =   array('msg' => '投诉简历（ID:'.pylode(',', $resumeIds).'）删除失败', 'errcode' => 8, 'layertype' => 1);
            }
            echo json_encode($return);
            die;
        }
    }

    function deljob_action()
    {

        $jobM       =   $this->MODEL('job');

        $result     =   $jobM->delJob(array('id' => $_GET['eid']), array('utype' => 'admin'));

        if ($result){

            $return =   array('msg' =>'职位投诉（ID：'.$_GET['id'].'）删除成功！', 'errcode' => 9, 'layertype' => 0);
        }else{

            $return =   array('msg' =>'职位投诉（ID：'.$_GET['id'].'）删除失败！', 'errcode' => 8, 'layertype' => 0);
        }
        $this->layer_msg($return['msg'], $return['errcode'], $return['layertype'], $_SERVER['HTTP_REFERER'], 2, 1);
    }

    function del_action()
    {

        $this->check_token();

        $reportM    =   $this->MODEL('report');

        if ($_GET['type'] == 'pldel') {

            $one    =   $reportM->getReportOne(array('id' => $_GET['del']), array('field' => '`eid`'));
            $report =   $reportM->getReportList(array('eid' => $one['eid']));

            $rids   =   array();

            foreach ($report['list'] as $key => $val) {
                $rids[]     =   $val['id'];
            }
            $where['id']    =   $rids;
        } else {

            $where['id']    =   $_GET['del'];
        }

        $return =   $reportM->delReport($where, array('title' => '举报'));

        if ($_GET['type'] == 'pldel') {
            $return['layertype']    =   0;
        }
        $this->layer_msg($return['msg'], $return['errcode'], $return['layertype'], $_SERVER['HTTP_REFERER'], 2, 1);
    }

    function delquestion_action()
    {
        if ($_GET['del']) {
            $askM = $this->MODEL('ask');
            $askM->DeleteQuestion($_GET['del']);
            $this->layer_msg('问答(ID:' . $_GET['del'] . ')删除成功！', 9, 0, $_SERVER['HTTP_REFERER']);
        }
    }

    function show_action()
    {
        if ($_POST['id']) {
            $reportM = $this->MODEL('report');
            $row = $reportM->getReportOne(array('id' => $_POST['id']), array('field' => '`r_reason`'));
            $data['r_reason'] = $row['r_reason'];

            echo json_encode($data);
            die;
        }
    }

    function showxjh_action()
    {
        if ($_POST['id']) {
            $reportM = $this->MODEL('report');
            $row = $reportM->getReportOne(array('id' => $_POST['id'], 'type' => '3'), array('field' => '`r_reason`'));
            $reason = explode('@', $row['r_reason']);
            if ($_POST['type'] == 'error') {

                $data['r_reason'] = $reason[0];

            } elseif ($_POST['type'] == 'right') {

                $data['r_reason'] = $reason[1];
            }

            echo json_encode($data);
            die;
        }
    }
}

?>