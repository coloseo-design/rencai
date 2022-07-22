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

class buysave_controller extends company
{
    function index_action()
    {

        $statis =   $this->company_satic();
        $adM    =   $this->MODEL('ad');

        if ($_POST['type'] == 'ad') {

            $row    =   $adM->getAdClassInfo(array('id' => (int)$_POST['aid'], 'type' => '1'));

            if ($row['id']) {

                $integral   =   $row['integral_buy'] * intval($_POST['buy_time']);
            } else {

                $this->ACT_layer_msg("非法操作！", 8, "index.php?c=ad");
            }
        }
        if ($_POST['btype'] == 1) {
            if ($statis['integral'] < $integral) {

                $this->ACT_layer_msg("你的" . $this->config['integral_pricename'] . "不足，请先充值！", 8, "index.php?c=pay");
            }
        }
        //购买广告位
        if ($_POST['type'] == "ad") {

            $IntegralM      =   $this->MODEL('integral');
            $pay_integral   =   $integral;

            $dingdan        =   time() . rand(10000, 99999);

            if ($_POST['btype'] == 1) {

                $nid        =   $IntegralM->company_invtal($this->uid, $this->usertype, $pay_integral, false, "购买广告位", true, 2, 'integral', 4);//积分操作记录
            } elseif ($_POST['btype'] == 2) {

                $orderM     =   $this->MODEL('companyorder');

                $datas['uid']           =   $this->uid;
                $datas['usertype']      =   $this->usertype;
                $datas['did']           =   $this->userdid;
                $datas['order_id']      =   $dingdan;
                $datas['order_price']   =   $pay_integral;
                $datas['order_time']    =   time();
                $datas['order_state']   =   1;
                $datas['order_remark']  =   "购买了广告位 " . $_POST['adname'];
                $datas['type']          =   26;
                if ($this->comInfo['crm_uid']){
                    $datas['crm_uid']   =   $this->comInfo['crm_uid'];
                }
                $nid                    =   $orderM->adOrder($datas);
            }

            if ($nid) {
                if (isset($_FILES['file'])) {

                    // pc端上传
                    $upArr  =   array(
                        'file'  =>  $_FILES['file'],
                        'dir'   =>  'adpic'
                    );
                    $uploadM=   $this->MODEL('upload');
                    $pic    =   $uploadM->newUpload($upArr);

                    if (!empty($pic['msg'])) {

                        $this->ACT_layer_msg($pic['msg'], 8);
                    } elseif (!empty($pic['picurl'])) {

                        $picurl =   $pic['picurl'];
                    }
                }
                $data['comid']      =   $this->uid;
                $data['did']        =   $this->userdid;
                $data['order_id']   =   $dingdan;

                $data['pic_url']    =   $picurl;
                $data['ad_name']    =   $_POST['ad_name'];
                $data['pic_src']    =   $_POST['pic_src'];
                $data['buy_time']   =   intval($_POST['buy_time']);

                if ($_POST['btype'] == 1) {

                    $data['integral']   =   $pay_integral;
                } elseif ($_POST['btype'] == 2) {

                    $data['price']      =   $pay_integral;
                }
                $data['buytype']    =   $_POST['btype'];
                $data['aid']        =   (int)$_POST['aid'];
                $data['adname']     =   $_POST['adname'];
                if ($_POST['btype'] == 1) {

                    $data['order_state']    =   2;
                } elseif ($_POST['btype'] == 2) {

                    $data['order_state']    =   1;
                }
                $data['datetime']   =   time();
                $oid                =   $adM->addOrderAd($data);

                if ($oid) {

                    //会员日志
                    $logM   =   $this->MODEL('log');
                    if ($_POST['btype'] == 1) {

                        $comM    =   $this->MODEL('company');
                        $cominfo = $comM->getInfo($this->uid,array('field'=>'`name`'));

                        $logM->addMemberLog($this->uid, $this->usertype, '购买广告位', 88, 1);

                        $this->MODEL('admin')->sendAdminMsg(array('first' => '有新的广告订单需要审核，企业《'.$cominfo['name'].'》购买了广告位《'.$_POST['ad_name'].'》', 'type' => 23));

                        $this->ACT_layer_msg("您的订单已提交，请等待管理员审核！", 9, "index.php?c=ad_order");
                    } elseif ($_POST['btype'] == 2) {

                        $logM->addMemberLog($this->uid, $this->usertype, "购买广告位,订单ID" . $dingdan, 88);
                        $this->ACT_layer_msg("下单成功，请付款！", 9, $this->config['sy_weburl'] . "/member/index.php?c=payment&id=" . $nid);
                    }
                } else {

                    $this->ACT_layer_msg("提交失败，请稍后再试！", 8, $_SERVER['HTTP_REFERER']);
                }
            } else {

                $this->ACT_layer_msg("系统出错，请联系管理员！", 8, "index.php");
            }
        }
    }
}

?>