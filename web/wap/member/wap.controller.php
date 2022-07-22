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

class wap_controller extends common
{

    public $resumeInfo  =   array();
    public $comInfo     =   array();
    public $ltInfo      =   array();
    public $pxInfo      =   array();

    function __construct($tpl, $db, $def = '', $model = 'index', $m = '')
    {

        $this->common($tpl, $db, $def, $model, $m);

        if ($this->usertype == 1) {

            //判断是否强制创建简历(等同于企业强制完善基本资料)
            $resumeM    =   $this->MODEL('resume');

            if ($this->config['user_resume_status'] == '1') {
                if (!in_array($_GET['c'], array('addresume', 'userLog', 'kresume', 'binding'))) {

                    $expectnum  =   $resumeM->getExpectNum(array('uid' => $this->uid));

                    if ($expectnum < 1) {

                        $this->yunset('header_title', '创建简历');
                        $this->yunset("remind", array('info' => '请先创建一份简历！', 'url' => 'index.php?c=addresume', 'btn' => '立即创建'));
                        $this->yuntpl(array('wap/member/user/addresume'));
                    }
                }
            } else {

                $this->resumeInfo =   $resumeM->getResumeInfo(array('uid' => $this->uid));
                if (!$this->resumeInfo['uid']) {

                    $isActivUser    =   1;
                    $activuid       =   $this->uid;
                }
            }
        } elseif ($this->usertype == 2) {

            if (!empty($this->spid) && in_array($_GET['c'], array('info', 'rating', 'time', 'added', 'pay', 'payment', 'integral', 'set', 'loglist', 'usercard', 'withdraw', 'change', 'jobpack', 'rewardpay'))) {

                $this->Act_msg_wap(Url('wap', '', 'member'), '操作错误！', 2, 5);
            }

            $this->yunset('todayStart', strtotime('today'));

            $CompanyM       =   $this->MODEL("company");
            $this->comInfo  =   $CompanyM->getInfo($this->uid, array('info' => '1', 'edit' => '1', 'logo' => '1', 'utype' => 'user'));
            $this->yunset('info', $this->comInfo);

            if (!in_array($_GET['c'], array('photo', 'info', 'userLog', 'ajaxCheckInfo'))) {

                // 强制完善基本资料
                if ($this->config['com_enforce_info'] == 1) {
                    if (!$this->comInfo['info']['name'] || !$this->comInfo['info']['provinceid'] || !$this->comInfo['info']['linktel']) {

                        $this->yunset('header_title', '基本信息');
                        $this->yunset("remind", array('info' => '请先完善信息！', 'url' => 'index.php?c=info', 'btn' => '立即完善'));
                        $this->yuntpl(array('wap/member/com/info'));
                    }
                } elseif (!$this->comInfo['info']['uid']) {

                    $isActivUser    =   1;
                    $activuid       =   $this->uid;
                }
            }
        } elseif ($this->usertype == 3) {

            $LietouM        =   $this->MODEL('lietou');
            $this->ltInfo   =   $LietouM->getInfo(array('uid' => $this->uid));

            $this->yunset('todayStart', strtotime('today'));

            if (!in_array($_GET['c'], array('info', 'uppic', 'userLog'))) {
                if ($this->config['lt_enforce_info'] == 1) {
                    // 强制完善基本资料
                    if (!$this->ltInfo['realname'] || !$this->ltInfo['com_name'] || !$this->ltInfo['provinceid'] || !$this->ltInfo['moblie']) {

                        $this->yunset("remind", array('info' => '请先完善信息！', 'url' => 'index.php?c=info', 'btn' => '立即完善'));
                        $this->yunset('header_title', '基本信息');
                        $this->yuntpl(array('wap/member/lietou/info'));
                    }
                } elseif (!$this->comInfo['info']['uid']) {

                    $isActivUser    =   1;
                    $activuid       =   $this->uid;
                }

            }
        } elseif ($this->usertype == 4) {

            $TrainM         =   $this->MODEL('train');
            $this->pxInfo   =   $TrainM->getInfo(array('uid' => $this->uid));

            $this->yunset('info', $this->pxInfo);

            if (!in_array($_GET['c'], array('info', 'userLog'))) {
                // 强制完善基本资料
                if ($this->config['px_enforce_info'] == 1) {
                    if (!$this->pxInfo['name'] || !$this->pxInfo['linktel']) {

                        $this->yunset("remind", array('info' => '请先完善信息！', 'url' => 'index.php?c=info', 'btn' => '立即完善'));
                        $this->yunset('header_title', '基本信息');
                        $this->yuntpl(array('wap/member/train/info'));
                    }
                } elseif (!$this->pxInfo['uid']) {

                    $isActivUser    =   1;
                    $activuid       =   $this->uid;
                }
            }
        }

        //容错机制，前期强制完善资料，后期开放，防止部分数据无uid 又可以直接操作会员中心
        if ($isActivUser == 1) {

            $userinfoM  =   $this->MODEL("userinfo");
            $userinfoM->activUser($activuid, $this->usertype);
        }

        include PLUS_PATH . 'tplmoblie.cache.php';
        $this->yunset('tplmoblie', $tplmoblie);
    }

    function waplayer_msg($msg, $url = '1', $tm = 2)
    {

        $msg    =   preg_replace('/\([^\)]+?\)/x', "", str_replace(array("（", "）"), array("(", ")"), $msg));

        $layer_msg['msg']   =   $msg;
        $layer_msg['url']   =   $url;
        $layer_msg['tm']    =   $tm;

        $msg    =   json_encode($layer_msg);
        echo $msg;
        die();
    }
}

?>