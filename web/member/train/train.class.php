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
class train extends common
{

    public $pxInfo = array();

    function __construct($tpl, $db, $def = "", $model = "index", $m = "")
    {

        $this -> common($tpl, $db, $def, $model, $m);

        $TrainM     =   $this->MODEL('train');
        
        $now_url    =   @explode("/", $_SERVER['REQUEST_URI']);
        $now_url    =   $now_url[count($now_url) - 1];
        $this->yunset('now_url', $now_url);

        $this->pxInfo   =   $TrainM->getInfo(array('uid' => $this->uid),array('utype'=>'user'));
       
        $this->yunset('info', $this->pxInfo);

        if (!in_array($_GET['c'], array('info', 'log', 'uppic')) && !in_array($_GET['act'], array('logout'))) {

            // 强制完善基本资料
            if ($this->config['px_enforce_info'] == 1) {

                if (! $this->pxInfo['name'] || ! $this->pxInfo['linktel']) {

                    $remindInfo = array(
                        'url'   =>  'index.php?c=info',
                        'title' =>  '机构资料尚未完善！',
                        'msg'   =>  '完善信息有助于帮您快速开展工作！'
                    );

                    $this -> yunset('isremind', 1);
                    $this -> yunset('remindInfo', $remindInfo);
                    $this -> train_tpl('info');
                }
            } elseif (! $this->pxInfo['uid']) {

                // 容错机制，前期强制完善资料，后期开放，防止部分数据无uid 又可以直接操作会员中心
                $userinfoM  =   $this->MODEL('userinfo');
                $userinfoM -> activUser($this->uid, 4);
            }
        }
    }

    function train_tpl($tpl)
    {
        
        $this->yuntpl(array('member/train/'.$tpl));
    }

    // 会员统计信息调用
    function train_satic()
    {
        $statisM    =   $this->MODEL('statis');
        $statis     =   $statisM->getInfo($this->uid, array('usertype' => 4));
        $this->yunset('statis', $statis);
        return $statis;
    }

    // 退出
    function logout_action()
    {
        $this->logout();
    }
}
?>