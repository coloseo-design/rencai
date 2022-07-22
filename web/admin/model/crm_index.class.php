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

class crm_index_controller extends adminCommon
{

    function index_action()
    {

        $auid       =   intval($_SESSION['auid']);

        //会员套餐
        $ratingM    =   $this->MODEL('rating');
        $ratinglist =   $ratingM->getList(array('category' => '1', 'service_price' => array('>', '0')), array('field' => '`id`,`name`'));
        $this->yunset('ratinglist', $ratinglist);

        $cacheM     =   $this->MODEL('cache');
        $cache      =   $cacheM->GetCache(array('crm'));
        $this->yunset('cache', $cache);

        $AdminM     =   $this->MODEL('admin');
        $where      =   array();
        $adminUser  =   $AdminM->getList($where, array('field' => '`uid`,`username`,`name`'));
        $this->yunset('adminUserList', $adminUser);
        $this->yunset('auid', $auid);

        // 网站所有支付类型
        include(CONFIG_PATH . 'db.data.php');
        $this->yunset('canpay', $arr_data['pay']);

        $this->yunset(array('time' => date('Y-m'), 'month' => '（'.(int)date('m').'月）'));
        $this->yuntpl(array('admin/crm_index'));
    }

    function addDeal_action()
    {

        if (!empty($_POST)) {

            $crmM   =   $this->MODEL('crm');

            $data           =   $_POST;
            $data['auid']   =   $_SESSION['auid'];
            $return         =   $crmM->addDeal($data);
        } else {

            $return =   array('errcode' => 8, 'msg' => '操作错误，请重试！');
        }
        echo json_encode($return);
        die;
    }

    function searchcom_action()
    {

        if (isset($_POST['keyword'])) {

            $companyM   =   $this->MODEL('company');
            $keyword    =   $this->post_trim($_POST['keyword']);

            $list       =   $companyM->getList(array('crm_uid' => $_SESSION['auid'], 'name' => array('like', $keyword)), array('field' => '`uid`,`name`'));

            $com        =   $list['list'];

            if (is_array($com) && !empty($com)) {
                foreach ($com as $val) {

                    $data[] =   array('uid' => $val['uid'], 'name' => $val['name'],);
                }
            }
        }
        echo json_encode($data);
        die;
    }

    public function orderprice_action()
    {

        $id         =   intval($_POST['id']);
        $ratingM    =   $this->MODEL('rating');
        $rating     =   $ratingM->getInfo(array('id' => $id));
        echo json_encode($rating);
    }

    /**
     * @desc 工作台 - 消息提醒
     */
    function getNotice_action()
    {

        $crmM   =   $this->MODEL('crm');

        $return =   $crmM->getNotice($_SESSION['auid']);

        echo $return;
    }

    /**
     * @desc 我的简报
     */
    function getWorkReport_action()
    {

        $crmM   =   $this->MODEL('crm');

        if ($_POST['time'] == 1) {//今天

            $sDate  =   mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            $eDate  =   mktime(23, 59, 59, date('m'), date('d'), date('Y'));
        } else if ($_POST['time'] == 2) {//昨天

            $sDate  =   mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 86400;
            $eDate  =   mktime(23, 59, 59, date('m'), date('d'), date('Y')) - 86400;
        } else if ($_POST['time'] == 3) {//本周

            $sDate  =   strtotime(date('Y-m-d', strtotime("this week Monday", time())));
            $eDate  =   strtotime(date('Y-m-d', strtotime("this week Sunday", time()))) + 24 * 3600 - 1;
        } else if ($_POST['time'] == 4) {//本月

            $sDate  =   mktime(0, 0, 0, date('m'), 1, date('Y'));
            $eDate  =   mktime(23, 59, 59, date('m'), date('t'), date('Y'));
        }

        $return =   $crmM->getWorkReport(array('sdate' => $sDate, 'edate' => $eDate, 'auid' => $_SESSION['auid']));
        echo json_encode($return);
    }

    /**
     * @desc  认领客户
     */
    function receiveKh_action()
    {

        if ($_POST['uids']) {

            $uids   =   @explode(',', $_POST['uids']);
            $auid   =   intval($_SESSION['auid']);
            $crmM   =   $this->MODEL('crm');
            $return =   $crmM->claimCom($uids, $auid);
            echo json_encode($return);
        }
    }


    function log_action()
    {

        $where  =   $urlarr =   array();

        $crmM   =   $this->MODEL('crm');

        if ($_GET['logType']) {

            $where['type']      =   $_GET['logType'];
            $urlarr['logType']  =    $_GET['logType'];
        }

        if ($_GET['uid']) {

            $where['auid']      =   $_GET['uid'];
            $urlarr['uid']      =   $_GET['uid'];
        }

        if ($_GET['keyword']) {

            $where['content']   =   array('like', $_GET['keyword']);
            $urlarr['keyword']  =   $_GET['keyword'];
        }
		$urlarr         =   $_GET;
        $urlarr['page'] =   '{{page}}';
        $urlarr['c']    =   'log';

        $pageurl        =   Url($_GET['m'], $urlarr, 'admin');
        $pageM          =   $this->MODEL('page');

        $pages          =   $pageM->pageList('crm_log', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {
            if (isset($_GET['order'])) {

                $where['orderby']   =   $_GET['t'] . ',' . $_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];
            } else {

                $where['orderby']   =   'ctime,desc';
            }

            $where['limit'] =   $pages['limit'];

            $list           =   $crmM->getCrmLogList($where);

            $this->yunset(array('list' => $list));
        }

        $typeArr    =   array('1' => '用户录入', '2' => '客户信息', '3' => '跟进记录' , '4' => '订单数据', '5' => '工作任务', '6' => '工作日志', '7' => '转交客户', '8' => '放弃客户', '9' => '等级状态', '10' => '外出申请', '11' => '联系方式', '12' => '领取客户');
        $this->yunset('typeArr', $typeArr);

        $adminM     =   $this->MODEL('admin');
        $crmUser    =   $adminM->getList(array('is_crm' => '1'));
        $this->yunset('crmUser', $crmUser);
        $this->yuntpl(array('admin/crm_log'));
    }

    /**
     * @desc 删除操作记录
     */
    function delCrmLog_action()
    {

        if ($_POST['del']) {

            $delId  =   $_POST['del'];
        } else if ($_GET['id']) {

            $this->check_token();
            $delId  =   intval($_GET['id']);
        }

        $crmM   =   $this->MODEL('crm');
        $return =   $crmM->delCrmLog($delId);

        if ($return['errcode'] == '9') {

            $this->MODEL('log')->addAdminLog("删除CRM操作记录（ID：" . $delId . "）");
        }

        $this->layer_msg($return['msg'], $return['errcode'], $return['layertype'], $_SERVER['HTTP_REFERER']);
    }

    function getKhb_action(){

        $crmM       =   $this->MODEL('crm');

        $crmKhb     =   $crmM->getKhbList($_POST['time']);
        echo json_encode($crmKhb);
    }

    function getJeb_action(){

        $crmM       =   $this->MODEL('crm');

        $crmJeb     =   $crmM->getJebList($_POST['time']);
        echo json_encode($crmJeb);
    }

}

?>