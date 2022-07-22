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

class free_controller extends common
{

    function index_action()
    {

        if (!$this->uid) {
            $this->ACT_msg_wap(Url('wap', array('c' => 'login')), '请先登录!', 2, 5);
        }

        $gqM    =   $this->MODEL('gqdemand');

        //查询当前是否有记录
        $where['uid']   =   $this->uid;
        $gqinfo         =   $gqM->getGqInfo($where, array('field' => '`uid`'));

        if ($gqinfo['uid'] == "") {
            $data       =   array('uid' => $this->uid, 'state' => 2);
            $gqM->addGqInfo($data);
        }
        $backurl        =   Url('wap', array(), 'member');
        $this->yunset('backurl', $backurl);
        $this->yunset('headertitle', "供求任务");
        $this->yuntpl(array('wap/gq_index'));
    }

    function info_action()
    {

        if (!$this->uid) {

            $this->ACT_msg_wap(Url('wap', array('c' => 'login')), '请先登录!', 2, 5);
        }

        $this->yunset($this->MODEL('cache')->GetCache(array('user', 'city')));

        $this->yunset('headertitle', "技能信息");

        $userInfoM  =   $this->MODEL('userinfo');

        $gqM        =   $this->MODEL('gqdemand');

        $logM       =   $this->MODEL('log');

        $where['uid']   =   $this->uid;

        $gqinfo         =   $gqM->getGqInfo($where);

        if ($gqinfo['uid'] == "") {

            $data       =   array('uid' => $this->uid, 'state' => 2);
            $gqM->addGqInfo($data);
        }

        if ($_POST['submit']) {

            $memberwhere['uid'] =   $this->uid;

            $member             =   $userInfoM->getInfo($memberwhere);

            if ($member['status'] == 1) {

                $status     =   $this->config['gq_task_status'];
            } else {

                $status     =   0;
            }
            $gqwhere['uid'] =   $this->uid;

            $infodata       =   array(
                'uid'           =>  $this->uid,
                'name'          =>  $_POST['name'],
                'sex'           =>  $_POST['sex'],
                'provinceid'    =>  $_POST['provinceid'],
                'cityid'        =>  $_POST['cityid'],
                'three_cityid'  =>  $_POST['three_cityid'],
                'services'      =>  str_replace(array('&amp;', 'background-color:#ffffff', 'background-color:#fff', 'white-space:nowrap;'), array('&', 'background-color:', 'background-color:', 'white-space:'), $_POST['services']),
                'salary'        =>  $_POST['salary'],
                'content'       =>  str_replace(array('&amp;', 'background-color:#ffffff', 'background-color:#fff', 'white-space:nowrap;'), array('&', 'background-color:', 'background-color:', 'white-space:'), $_POST['content']),
                'moblie'        =>  $_POST['moblie'],
                'speciality'    =>  $_POST['speciality'],
                'status'        =>  $status,
                'state'         =>  1,
                'r_status'      =>  $member['status'],
                'lastupdate'    =>  time()
            );

            $return =   $gqM->upaddGqinfo($gqwhere, $infodata);

            if ($return['errcode'] == 9) {

                $logM->addMemberLog($this->uid, 5, '修改基本信息', 7, 2);
                $data   =   array('msg' => $return['msg'], 'url' => 'index.php?c=free');
            } else {

                $data   =   array('msg' => $return['msg']);
            }

            echo json_encode($data);
            die;

        }

        $this->yunset('gqinfo', $gqinfo);
        $this->yuntpl(array('wap/gq_info'));
    }

    function freemoblie_action()
    {

        $gqdM               =   $this->MODEL('gqdemand');

        $where['moblie']    =   $_POST['moblie'];
        $where['uid']       =   array('<>', $this->uid);

        $info               =   $gqdM->getGqInfo($where, array('field' => '`uid`'));

        if ($info['uid']) {
            echo 1;
            die;
        } else {
            echo 2;
            die;
        }
    }

    /**
     * 查看发布任务
     */
    function tasklist_action()
    {

        $this->yunset('headertitle', "我发布的任务");

        if (!$this->uid) {

            $this->ACT_msg_wap(Url('wap', array('c' => 'login')), '请先登录!', 2, 5);
        }

        $gqdemandM      =   $this->MODEL('gqdemand');

        $where['uid']   =   $this->uid;

        $rows           =   $gqdemandM->getGqtaskList($where, array('type' => 1));

        if (is_array($rows) && $rows) {

            $zp = $sh = $gq = $xj = 0;
            $time = time();
            foreach ($rows as $value) {
                if ($value['status'] == 1 && date('Y-m-d', $value['etime']) >= date('Y-m-d', $time) && $value['state'] == 1) {
                    $zp += 1;
                }
                if ($value['status'] != 1 && date('Y-m-d', $value['etime']) >= date('Y-m-d', $time) && $value['state'] == 1) {
                    $sh += 1;
                }
                if (date('Y-m-d', $value['etime']) < date('Y-m-d', $time) && $value['state'] == 1) {
                    $gq += 1;
                }
                if ($value['status'] == 1 && date('Y-m-d', $value['etime']) >= date('Y-m-d', $time) && $value['state'] == 2) {
                    $xj += 1;
                }
            }
        }

        $this->yunset(array('zp' => $zp, 'sh' => $sh, 'gq' => $gq, 'xj' => $xj));

        $backurl    =   Url('wap', array('c' => 'free'));
        $this->yunset('backurl', $backurl);
        $this->yunset('time', $time);
        $this->yunset('rows', $rows);
        $this->yuntpl(array('wap/tasklist'));
    }

    /**
     * 发布项目任务和修改任务
     */
    function addtask_action()
    {

        if (!$this->uid) {

            $this->ACT_msg_wap(Url('wap', array('c' => 'login')), '请先登录!', 2, 5);
        }

        $logM       =   $this->MODEL('log');
        $userinfoM  =   $this->MODEL('userinfo');
        $gqdemandM  =   $this->MODEL('gqdemand');

        if ((int)$this->config['gq_pay_price'] == 0) {

            $start_time             =   strtotime(date('Y-m-d 00:00:00'));
            $end_time               =   strtotime(date('Y-m-d 23:59:59'));//开始时间
            $taskwhere['ctime'][]   =   array('>', $start_time);
            $taskwhere['ctime'][]   =   array('<', $end_time);
            $taskwhere['uid']       =   $this->uid;
            $taskwhere['pay']       =   3;

            if ((int)$this->config['gq_number'] > 0) {

                $mess   =   $gqdemandM->getTaskNum($taskwhere);
                if ($mess >= $this->config['gq_number']) {

                    $data['msg']    =   "一天内只能发布" . $this->config['gq_number'] . "条项目任务！！";
                    $data['url']    =   Url('wap', array("c" => 'tasklist'));
                }
            }
        }
        $this->yunset('layer', $data);

        if ($_GET['id']) {

            $rows   =   $gqdemandM->getGqtaskInfo(array('id' => $_GET['id'], 'uid' => $this->uid), array('type' => 1));
            if ($rows['content']) {

                $rows['content_t'] = strip_tags($rows['content']);
            }
            $this->yunset('rows', $rows);
        } else {

            if (floatval($this->config['gq_pay_price']) > 0) {

                $orderM     =   $this->MODEL('companyorder');
                $orderNum   =   $orderM->getCompanyOrderNum(array('order_state' => 1, 'type' => 29, 'uid' => $this->uid));
                $this->yunset('num', $orderNum);
            }
        }

        $pay    =   $this->config['gq_pay_price'] > 0 ? 1 : 3;
        $time   =   date('Y-m-d', time());
        $gqinfo =   $gqdemandM->getGqInfo(array('uid' => $this->uid));
        $this->yunset(array('time' => $time, 'pay' => $pay, 'gqinfo' => $gqinfo));

        if ($_POST['submit']) {

            $member     =   $userinfoM->getInfo(array('uid' => $this->uid));
            $status     =   $member['status'] == '1' ? $this->config['gq_task_status'] : '0';
            $content    =   str_replace(array("&amp;", "background-color:#ffffff", "background-color:#fff", "white-space:nowrap;"), array("&", 'background-color:', 'background-color:', 'white-space:'), $_POST['content']);

            $data       =   array(
                'uid'           =>  $this->uid,
                'name'          =>  $_POST['name'],
                'salary'        =>  $_POST['salary'],
                'edate'         =>  $_POST['edate'],
                'etime'         =>  strtotime($_POST['etime']),
                'content'       =>  $content,
                'link_man'      =>  $_POST['link_man'],
                'link_moblie'   =>  $_POST['link_moblie'],
                'status'        =>  $status,
                'ctime'         =>  isset($rows['ctime']) ? $rows['ctime'] : time(),
                'lastupdate'    =>  time(),
                'state'         =>  $_POST['state'],
                'r_status'      =>  $member['status'],
                'pay'           =>  $_POST['pay']
            );

            $where  =   array();
            if ($_POST['id']) {

                $where['id']    =   $_POST['id'];
                $logM->addMemberLog($this->uid, 5, '更新项目任务', 29, 2);
            } else {

                $logM->addMemberLog($this->uid, 5, '发布项目任务', 29, 1);
            }

            $return =   $gqdemandM->upaddGqtask($where, $data, '');

            echo json_encode($return);
            die;
        }

        $this->yunset('headertitle', "发布任务");
        $this->yuntpl(array('wap/addtask'));
    }


    //删除发布项目任务
    function deltask_action()
    {

        if (!$this->uid) {

            $this->ACT_msg_wap(Url('wap', array('c' => 'login')), '请先登录!', 2, 5);
        }

        $logM       = $this->MODEL('log');

        $gqdemandM  = $this->MODEL('gqdemand');

        $id         = $_GET['id'];

        $return = $gqdemandM->deltask($id, array('uid' => $this->uid));

        if ($return['errcode'] == 9) {

            $logM->addMemberLog($this->uid, 5, '删除项目任务', 29, 3);

            echo 1;
            die;

        } else {

            echo 2;
            die;

        }

    }

    function pay_action()
    {

        if (!$this->uid) {

            $this->ACT_msg_wap(Url('wap', array('c' => 'login')), '请先登录!', 2, 5);
        }


        $gqdemandM = $this->MODEL('gqdemand');

        $row = $gqdemandM->getGqtaskInfo(array('id' => (int)$_GET['id']));

        if (!$row) {
            $this->ACT_msg_wap(Url('wap', array('c' => 'free', 'a' => 'tasklist')), '供求任务信息不存在！', 1, 3);
        }

        if ($this->config['wxpay'] == '1') {
            $paytype['wxpay'] = '1';
        }
        if ($this->config['alipay'] == '1' && $this->config['alipaytype'] == '1') {
            $paytype['alipay'] = '1';
        }

        if ($paytype) {
            $this->yunset("paytype", $paytype);
        }

        $this->get_moblie();
        $this->yunset("headertitle", "供求任务");
        $this->yuntpl(array('wap/gq_pay'));
    }

    function dingdan_action()
    {

        if (!$this->uid) {

            $this->ACT_msg_wap(Url('wap', array('c' => 'login')), '请先登录!', 2, 5);
        }

        if ($_POST) {

            $gqdemandM = $this->MODEL('gqdemand');

            $data = array(
                'uid' => $this->uid,
                'usertype' => 5,
                'id' => $_POST['id'],
                'did' => $this->userdid,
                'pay_type' => $_POST['paytype'] == 'wxpay' ? 'wxh5' : $_POST['paytype']
            );
            if (empty($_POST['type'])) {
                $return = $gqdemandM->payTask($data);
            } else {
                $return = $gqdemandM->payTaskRefresh($data);
            }
            if ($return['id']) {

                if ($_POST['paytype'] == 'alipay') {

                    $dingdan = $return['orderid'];

                    if (empty($_POST['type'])) {
                        $price = $this->config['gq_pay_price'];
                    } else {
                        $price = $this->config['gq_refrsh_pay'];
                    }

                    $url = $this->config['sy_weburl'] . '/api/wapalipay/alipayto.php?dingdan=' . $dingdan . '&dingdanname=' . $dingdan . '&alimoney=' . $price;

                } else if ($_POST['paytype'] == 'wxpay') {

                    $url = Url('wap', array('c' => 'free', 'a' => 'wxpay', 'id' => $return['id']));

                }

                header('Location: ' . $url);
                exit();
            } else {
                $this->ACT_msg_wap(Url('wap', array('c' => 'free', 'a' => 'tasklist')), '提交失败！！', 1, 3);
            }

        } else if ($_GET['id']) {

            $companyorderM = $this->MODEL('companyorder');

            $order = $companyorderM->getInfo(array('id' => (int)$_GET['id']));

        }
    }

    function wxpay_action()
    {

        if (!$this->uid) {
            $this->ACT_msg_wap(Url('wap', array('c' => 'login')), '请先登录!', 2, 5);
        }

        if ($_GET['id']) {

            $companyorderM = $this->MODEL('companyorder');

            $data['orderId'] = (int)$_GET['id'];

            if (isset($_GET['paytype'])) {

                $data['paytype'] = $_GET['paytype'];
            }

            $return = $companyorderM->payComOrderByWXWAP($data);

            if ($return['header']) {

                header($return['header']);

                exit();
            } elseif ($return['msg']) {
                $this->ACT_msg_wap($return['url'], $return['msg'], 1, 3);

            } else {
                $this->yunset('jsApiParameters', $return['jsApiParameters']);
            }
            $this->yunset('id', (int)$_GET['id']);

            $this->yunset('headertitle', '微信支付');
        } else {
            $this->ACT_msg_wap($_SERVER['HTTP_REFERER'], '参数不正确，请正确填写！', 1, 3);
        }

        $this->yuntpl(array('wap/gq_wxpay'));
    }

    function payment_action()
    {
        if (!$this->uid) {

            $this->ACT_msg_wap(Url('wap', array('c' => 'login')), '请先登录!', 2, 5);
        }
        if ($this->config['wxpay'] == '1') {

            $paytype['wxpay'] = '1';

        }
        if ($this->config['alipay'] == '1' && $this->config['alipaytype'] == '1') {

            $paytype['alipay'] = '1';

        }
        if ($paytype) {

            if ($_GET['id']) {//订单

                $orderM = $this->MODEL('companyorder');

                $order = $orderM->getInfo(array('uid' => $this->uid, 'id' => (int)$_GET['id']), array('bank' => 1));
                if (empty($order)) {
                    $this->ACT_msg_wap($_SERVER['HTTP_REFERER'], '订单不存在！', 1, 3);
                } elseif ($order['order_state'] != '1') {
                    header("Location:" . Url('wap', array('c' => 'free', 'a' => 'paylog')));
                } else {

                    $this->yunset("order", $order);
                }
            }
            $this->yunset("paytype", $paytype);

            $this->yunset("js_def", 4);

        } else {
            $this->ACT_msg_wap($_SERVER['HTTP_REFERER'], '暂未开通手机支付！', 1, 3);
        }
        $this->yunset('headertitle', "订单确认");

        $this->yuntpl(array('wap/gq_payment'));

    }

    function paylog_action()
    {

        if (!$this->uid) {

            $this->ACT_msg_wap(Url('wap', array('c' => 'login')), '请先登录!', 2, 5);
        }

        $where['uid'] = $this->uid;
        $where['usertype'] = 5;

        $where['orderby'] = 'order_time,desc';

        $urlarr = array("c" => "free", "a" => "paylog", "page" => "{{page}}");

        $pageurl = Url('wap', $urlarr);

        $pageM = $this->MODEL('page');

        $pages = $pageM->pageList('company_order', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {

            $where['limit'] = $pages['limit'];

            $companyorderM = $this->MODEL('companyorder');

            $rows = $companyorderM->getList($where);

            $this->yunset("rows", $rows);
        }

        include(CONFIG_PATH . "db.data.php");

        $this->yunset("arr_data", $arr_data);

        $this->yunset('backurl', Url('wap', array('c' => 'free', 'a' => 'tasklist')));

        $this->yunset("headertitle", "订单管理");

        $this->yuntpl(array('wap/gq_paylog'));
    }

    function delpaylog_action()
    {

        if (!$this->uid) {

            $this->ACT_msg_wap(Url('wap', array('c' => 'login')), '请先登录!', 2, 5);
        }

        $orderM = $this->MODEL('companyorder');

        $return = $orderM->del((int)$_GET['id'], array('uid' => $this->uid));

        if ($return['errcode'] == 9) {

            echo 1;
            die;
        } else {
            echo 2;
            die;
        }

    }

    /**上架下架管理** */

    function freeset_action()
    {

        if (!$this->uid) {

            $this->ACT_msg_wap(Url('wap', array('c' => 'login')), '请先登录!', 2, 5);
        }

        $gqdemandM = $this->MODEL('gqdemand');

        $LogM = $this->MODEL('log');

        $where['id'] = intval($_GET['id']);

        $data = array(

            'state' => intval($_GET['state'])

        );

        $nid = $gqdemandM->upGqtaskStatus($where, $data);

        if ($nid) {
            $LogM->addMemberLog($this->uid, 5, "修改项目任务招聘状态", 29, 2);
            echo 1;
            die;
        } else {
            echo 2;
            die;
        }
    }

    //项目任务刷新功能
    public function refrshtask_action()
    {

        if (!$this->uid) {

            $this->ACT_msg_wap(Url('wap', array('c' => 'login')), '请先登录!', 2, 5);
        }

        $gqdemandM = $this->MODEL('gqdemand');

        $LogM = $this->MODEL('log');

        if ($this->config['gq_refrsh_pay'] != 0) {
            //付费功能
            $datat['msg'] = "刷新项目任务，需要支付" . $this->config['gq_refrsh_pay'] . "元";
            $datat['url'] = 'index.php?c=free&a=pay&id=' . $_GET['id'] . '&type=refresh';

        } else {
            //免费功能

            $where['id'] = intval($_GET['id']);

            $data = array(

                'lastupdate' => time()

            );

            $nid = $gqdemandM->upGqtaskStatus($where, $data);

            if ($nid) {
                $LogM->addMemberLog($this->uid, 5, "刷新项目任务招聘状态", 29, 4);
                $datat['msg'] = "供求项目任务刷新成功";
                $datat['url'] = 'index.php?c=free&a=tasklist';
            } else {
                $datat['msg'] = "供求项目任务刷新失败";
            }

        }
        echo json_encode($datat);
        die;

    }


    //查看浏览记录
    function browserlist_action()
    {

        if (!$this->uid) {

            $this->ACT_msg_wap(Url('wap', array('c' => 'login')), '请先登录!', 2, 5);
        }

        $gqdemandM = $this->MODEL('gqdemand');

        $uid = $this->uid;

        $where['uid'] = $uid;

        $rows = $gqdemandM->gqbrowseList($where);

        $this->yunset('rows', $rows);

        $this->yunset('headertitle', "浏览供求任务");

        $this->yuntpl(array('wap/gq_browserlist'));


    }

    //删除浏览任务
    function delbrowse_action()
    {
        if (!$this->uid) {

            $this->ACT_msg_wap(Url('wap', array('c' => 'login')), '请先登录!', 2, 5);
        }

        $logM = $this->MODEL('log');

        $gqdemandM = $this->MODEL('gqdemand');

        $id = $_GET['id'];

        $return = $gqdemandM->delbrower($id, array('uid' => $this->uid));

        if ($return) {

            $logM->addMemberLog($this->uid, 5, '删除浏览项目任务', 6, 3);

            echo 1;
            die;
        } else {
            echo 2;
            die;
        }

    }

    function photo_action()
    {
        if (!$this->uid) {

            $this->ACT_msg_wap(Url('wap', array('c' => 'login')), '请先登录!', 2, 5);
        }

        $logM = $this->MODEL('log');

        $gqdemandM = $this->MODEL('gqdemand');

        $uid = $this->uid;

        $where['uid'] = $uid;

        if ($_POST['submit']) {

            $return = $gqdemandM->upPhoto(array('uid' => $this->uid), array('utype' => 'gq', 'base' => $_POST['uimage']));

            $logM->addMemberLog($this->uid, $this->usertype, '上传图片', 16, 1);

        }

        echo $return['errcode'];
        die;

    }

}

?>