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

class lietou extends common
{

    public $ltInfo = array();

    function __construct($tpl, $db, $def = "", $model = "index", $m = "")
    {

        $this->common($tpl, $db, $def, $model, $m);

        $LtM    =   $this->MODEL('lietou');
        $uid    =   $this->uid;

        $this->ltInfo   =   $LtM->getInfo(array('uid' => $uid), array('utype' => 'user'));

        if (!in_array($_GET['c'], array('info', 'uppic', 'log')) && !in_array($_GET['act'], array('logout'))) {

            if ($this->config['lt_enforce_info'] == 1) {

                if (!$this->ltInfo['realname'] || !$this->ltInfo['com_name'] || !$this->ltInfo['provinceid'] || !$this->ltInfo['moblie']) {

                    $this->yunset('isdef', 1);
                    $this->yunset('class', 1);

                    $remindInfo['url']      =   'index.php?c=info';
                    $remindInfo['title']    =   '基本信息尚未完善！';
                    $remindInfo['msg']      =   '完善的基本信息有助于帮您快速招聘人才！';

                    $this->yunset('isremind', 1);
                    $this->yunset('remindInfo', $remindInfo);

                    $this->lietou_tpl('info');
                }

            } elseif (!$this->ltInfo['uid']) {

                //容错机制，前期强制完善资料，后期开放，防止部分数据无uid 又可以直接操作会员中心
                $userinfoM  =   $this->MODEL("userinfo");
                $userinfoM->activUser($this->uid, 3);
            }
        }
    }

    function public_action()
    {

        include(PLUS_PATH."com.cache.php");
        $this->yunset('comdata', $comdata);
        $this->yunset('comclass_name', $comclass_name);

        $UserInfoM  =   $this->MODEL('userinfo');
        $member     =   $UserInfoM->getInfo(array('uid' => $this->uid), array('setname' => '1'));
        $this->yunset('member', $member);

        $ltM        =   $this->MODEL('lietou');
        $user       =   $this->ltInfo;
        $user       =   $this->lt_array_action($user);

        $this->yunset('user', $user);

        $giverebatenum  =   $ltM->getRebatesNum(array('job_uid' => $this->uid));

        $this->yunset('giverebatenum', $giverebatenum);

        $statis     =   $this->lt_satic();

        // 会员等级 增值包 套餐
        $ratingM    =   $this->MODEL('rating');
        $ratingList =   $ratingM->getList(array('display' => 1, 'orderby' => array('type,asc', 'sort,desc')));
        $rating_1   =   $rating_2   =   $raV    =   array();

        if (!empty($ratingList)) {
            foreach ($ratingList as $ratingV) {

                $raV[$ratingV['id']]    =   $ratingV;

                if ($ratingV['category'] == 2 && $ratingV['service_price'] > 0) {
                    if ($ratingV['type'] == 1) {

                        $rating_1[]     =   $ratingV;
                    } elseif ($ratingV['type'] == 2) {

                        $rating_2[]     =   $ratingV;
                    }
                }
            }
        }
        $this->yunset('rating_1', $rating_1);
        $this->yunset('rating_2', $rating_2);

        if (!empty($statis)) {

            $discount   =   isset($raV[$statis['rating']]) ? $raV[$statis['rating']] : array();
            $this->yunset('discount', $discount);
            $this->yunset('statis', $statis);
            $this->yunset('todayStart', strtotime('today'));
        }

        $add        =   $ltM->getLtservicedetailList(array('orderby' => array('type,asc', 'sort,desc')), array('pack' => '1'));
        $this->yunset('add', $add);

        $couponM    =   $this->MODEL('coupon');
        $couponList =   $couponM->getCouponList(array('uid' => $this->uid, 'status' => 1, 'validity' => array('>', time()), 'orderby' => array('coupon_amount,asc', 'coupon_scope,asc')));
        $this->yunset('couponList', $couponList);

        if (!isVip($statis['vip_etime'])) {

            $this->yunset('vipIsDown', 1); //  会员过期
        }

        $this->get_nav();
    }

    function lietou_tpl($tpl)
    {
        $this->yuntpl(array('member/lietou/' . $tpl));
    }

    function get_nav()
    {

        if (in_array($_GET['c'], array('info', 'uppic', 'binding', 'passwd', 'zixun', 'sysnews', 'setname', 'baoming_subject', 'fav_subject', 'subject_zixun', 'fav_agency', 'atn_teacher'))) {

            $isdef  =   1;
        } elseif (in_array($_GET['c'], array('jobadd', 'job'))) {

            $isdef  =   2;
        } elseif (in_array($_GET['c'], array('mypay', 'pay', 'paylog', 'consume', 'payment', 'coupon_list', 'reward_list', 'paylogtc', 'right', 'log', 'integral', 'integral_reduce', 'payment')) || in_array($_GET['act'], array('loglist', 'withdraw', 'withdrawlist', 'change', 'changelist'))) {

            $isdef  =   3;
        } elseif (in_array($_GET['c'], array('search_resume', 'down_resume', 'look_resume', 'entrust_resume', 'yp_resume', 'give_rebates', 'my_rebates', 'talent', 'jobpack', 'reward', 'chat'))) {

            $isdef  =   4;
        } elseif (empty($_GET['c'])) {

            $isdef  =   5;
        }
        $this->yunset("isdef", $isdef);
    }

    //会员统计信息调用
    function lt_satic()
    {
        $statisM = $this->MODEL('statis');
        $statis = $statisM->vipLtOver($this->uid);

        $this->yunset('statis', $statis);
        $this->yunset("addltjobnum", $statis['addltjobnum']);
        $this->yunset('todayStart', strtotime('today'));

        return $statis;
    }

    function user_shell()
    {

        $userinfo   =   $this->MODEL('lietou')->getInfo(array('uid' => $this->uid));

        if ($userinfo['realname'] == "") {

            $this->ACT_layer_msg("请先完善基本资料！", 8, $_SERVER['HTTP_REFERER']);

        }
    }

    function logout_action()
    {
        $this->logout();
    }

    /**
     * 将猎头信息替换为缓存数组中内容
     */
    function lt_array_action($info, $array = array())
    {
        if (!empty($array)) {

            $ltclass_name   =   $array["ltclass_name"];
            $city_name      =   $array["city_name"];
        } else {
            include PLUS_PATH."/lt.cache.php";
            include PLUS_PATH."/city.cache.php";
        }
        $info['provinceid_info']    =   $city_name[$info["provinceid"]];
        $info['cityid_info']        =   $city_name[$info["cityid"]];
        $info['three_cityid_info']  =   $city_name[$info["three_cityid"]];
        $info['title_info']         =   $ltclass_name[$info["title"]];
        $info['exp_info']           =   $ltclass_name[$info["exp"]];
        return $info;
    }
}

?>