<?php

/* *
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
*/

class partadd_controller extends company
{
    function index_action()
    {

        $company    =   $this->comInfo['info'];

        if (!$company['name'] || !$company['provinceid'] || (!$company['linktel'] && !$company['linkphone'])) {

            $this->ACT_msg('index.php?c=info', '请先完善基本资料！');
        }
        $this->yunset('company', $company);

        // 身份认证信息，强制邮箱、手机、企业资质认证配置--start
        $msg        =   array();

        $isallow_addjob =   '1';

        $url        =   $this->spid ? 'index.php' : 'index.php?c=binding';

        if ($this->config['com_enforce_emailcert'] == '1') {
            if ($company['email_status'] != '1') {

                $isallow_addjob =   '0';
                $msg[]          =   '邮箱认证';
            }
        }
        if ($this->config['com_enforce_mobilecert'] == '1') {
            if ($company['moblie_status'] != '1') {

                $isallow_addjob =   '0';
                $msg[]          =   '手机认证';
            }
        }

        if ($this->config['com_enforce_licensecert'] == '1') {

            $comM   =   $this->MODEL('company');
            $cert   =   $comM->getCertInfo(array('uid' => $this->uid, 'type' => 3), array('field' => '`uid`,`status`'));

            if ($company['yyzz_status'] != '1' && (empty($cert) || $cert['status'] == 2)) {

                $isallow_addjob =   '0';
                $msg[]          =   '企业资质认证';
            }
        }

        if ($isallow_addjob == '0') {
            if ($this->spid) {

                $this->ACT_msg($url, '请联系主账号，先完成' . implode('、', $msg) . '！');
            } else {

                $this->ACT_msg($url, '请先完成' . implode('、', $msg) . '！');
            }
        }

        if ($this->config['com_enforce_setposition'] == '1') {
            if (empty($company['x']) || empty($company['y'])) {
                $this->ACT_msg('index.php?c=map', '请先完成地图设置！');
            }
        }

        if ($this->config['com_gzgzh'] == '1') {

            $userinfoM  =   $this->MODEL('userinfo');
            $uInfo      =   $userinfoM->getInfo(array('uid' => $this->uid), array('field' => '`wxid`,`unionid`'));
            if (empty($uInfo['wxid']) && empty($uInfo['unionid'])) {

                $this->cookie->SetCookie('gzh', '', (strtotime('today') - 86400));
                $this->ACT_msg('index.php', '请先关注公众号！');
            }
        }

        $partM      =   $this->MODEL('part');
        $statisM    =   $this->MODEL('statis');

        $id         =   intval($_GET['id']);

        if ($id) {
            $row    =   $partM->getInfo(array('uid' => $this->uid, 'id' => $id));

            $row['info']['workcishu']   =   count($row['info']['worktime_n']);
            $this->yunset('row', $row['info']);
        } else {

            $statics    =   $this->company_satic();

            if ($statics['addjobnum'] == 0) {//会员过期
                if ($this->spid) {

                    $this->ACT_msg('index.php', '当前账号会员已到期，请联系主账号进行升级！', 8);
                } else {

                    $this->ACT_msg("index.php?c=right", "你的会员已到期！", 8);
                }
            }
            if ($statics['addjobnum'] == 2) {//套餐会员，发布兼职套餐为0
                if ($this->config['integral_job'] != '0') {
                    if ($this->spid) {

                        $this->ACT_msg('index.php', '您的套餐已用完，请联系主账号进行分配！', 8);
                    } else {

                        $this->ACT_msg("index.php?c=right", "你的套餐已用完！", 8);
                    }
                } else {
                    if ($this->spid) {

                        $statisM->upInfo(array('job_num' => 1), array('uid' => $this->spid, 'usertype' => $this->usertype));
                    } else {

                        $statisM->upInfo(array('job_num' => 1), array('uid' => $this->uid, 'usertype' => $this->usertype));
                    }

                }
            }
        }

        $this->yunset($this->MODEL('cache')->GetCache(array('city', 'part')));

        $this->company_satic();
        $this->public_action();
        $this->yunset("today", date("Y-m-d"));

        $this->com_tpl('partadd');
    }

    function save_action()
    {

        if ($_POST['submit']) {

            $_POST['r_status']  =   $this->comInfo['info']['r_status'];

            $partM              =   $this->MODEL('part');

            $this->cookie->SetCookie('delay', "", time() - 60);

            if ($_POST['timetype']) {

                $_POST['edate'] =   "";
            } else {

                $_POST['edate'] =   strtotime($_POST['edate']);
            }

            $data               =   $_POST;

            $data['uid']        =   $this->uid;
            $data['spid']       =   $this->spid;
            $data['usertype']   =   $this->usertype;
            $data['utype']      =   'user';

            $return =   $partM->upPartInfo($data);
            $toUrl  =   $return['errcode'] == 9 ? 'index.php?c=part' : '';
            $this->ACT_layer_msg($return['msg'], $return['errcode'], $toUrl);
        }
    }
}

?>