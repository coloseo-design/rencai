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

class part_controller extends wxapp_controller
{

    function list_action()
    {

        $partM  =   $this->MODEL('part');

        $where['state']     =   1;

        $where['r_status']  =   array('<>', 2);

        $where['PHPYUNBTWSTART_A']  =   '';
        $where['edate'][]           =   array('>', time());
        $where['edate'][]           =   array('=', 0, 'or');
        $where['PHPYUNBTWEND_A']    =   '';

        if ($this->config['sy_datacycle'] > 0) {
            // 后台-页面设置-数据周期
            $where['lastupdate']    =   array('>', strtotime('-'.$this->config['sy_datacycle'].' day'));
        }

        if ($_POST['cycle']) {

            $where['billing_cycle'] =   $_POST['cycle'];
        }

        if ($_POST['provinceid']) {

            $where['provinceid']    =   $_POST['provinceid'];
        }

        if ($_POST['cityid']) {

            $where['cityid']        =   $_POST['cityid'];
        }

        if ($_POST['three_cityid']) {

            $where['three_cityid']  =   $_POST['three_cityid'];
        }

        if ($_POST['type']) {

            $where['type']          =   $_POST['type'];
        }

        if ($_POST['keyword']) {

            $keyword                =   $this->stringfilter($_POST['keyword']);
            $where['name']          =   array('like', $keyword);
        }

        if (!empty($_POST['did'])) {

            $domain =   $this->getDomain($_POST['did'], true);

            if (isset($domain['didcity'])) {

                if (!empty($domain['provinceid'])) {
                    $where['provinceid']    =   $domain['provinceid'];
                }
                if (!empty($domain['cityid'])) {
                    $where['cityid']        =   $domain['cityid'];
                }
                if (!empty($domain['three_cityid'])) {
                    $where['three_cityid']  =   $domain['three_cityid'];
                }
                $data['didcity']            =   $domain['didcity'];
                $data['cityone']            =   $domain['cityone'];
                $data['citytwo']            =   $domain['citytwo'];
                $data['citythree']          =   $domain['citythree'];
                $data['provinceid']         =   !empty($domain['provinceid']) ? intval($domain['provinceid']) : 0;
                $data['cityid']             =   !empty($domain['cityid']) ? intval($domain['cityid']) : 0;
                $data['three_cityid']       =   !empty($domain['three_cityid']) ? intval($domain['three_cityid']) : 0;
            }
        }
        $where['orderby']                   =   array('lastupdate,desc');

        $page   =   $_POST['page'];

        if ($_POST['limit']) {

            $limit  =   $_POST['limit'];
            if ($page) {
                $pagenav        =   ($page - 1) * $limit;
                $where['limit'] =   array($pagenav, $limit);
            } else {
                $where['limit'] =   $limit;
            }
        }

        $rows           =   $partM->getList($where);

        $data['list']   =   count($rows) ? $rows : array();

        if (isset($_POST['provider'])) {
            if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao') {
                $seo            =   $this->seo('part_index', '', '', '', false, true);
                $data['seo']    =   $seo;
            }
        }
        $this->render_json(0, '', $data);
    }

    function show_action()
    {

        $msg    =   '';
        if ($this->config['sy_part_web'] == '2') {

            $msg    =   '很抱歉！该模块已关闭！';
            $error  =   0;
        }
        $id     =   (int)$_POST['id'];

        if ($msg == '') {
            if ($_POST['token'] && $_POST['uid']) {

                $user       =   $this->yzToken((int)$_POST['uid'], $_POST['token']);
                $uid        =   $user['uid'];
                $usertype   =   $user['usertype'];
            }

            if ($id) {
                $partM      =   $this->MODEL('part');
                $info       =   $partM->getInfo(array('id' => $id), array('cache' => 1, 'com' => 1, 'utype' => 'wxapp', 'uid' => $uid, 'usertype' => $usertype));

                $job        =   $info['info'];

                $morning    =   $info['cache']['part_morning'];
                $noon       =   $info['cache']['part_noon'];
                $afternoon  =   $info['cache']['part_afternoon'];

                $job['com_name']    =   $info['com']['name'];

                if (!empty($job['x']) && !empty($job['y'])) {

                    $coordinates    =   $this->Convert_BD09_To_GCJ02($job['x'], $job['y']);
                    $job['x']       =   $coordinates['lng'];
                    $job['y']       =   $coordinates['lat'];
                }

                $partM->upInfo(array('hits' => array('+', 1)), array('id' => $id)); // 更新浏览次数

                if ($usertype == 1) {

                    $apply      =   $partM->getPartSqInfo(array('uid' => $uid, 'jobid' => $id));
                    $collect    =   $partM->getPartCollectInfo(array('uid' => $uid, 'jobid' => $id));
                }
                if ($job['worktime_n']) {
                    foreach ($morning as $v) {
                        if (in_array($v, $job['worktime_n'])) {
                            $job['morning'][$v] = 1;
                        } else {
                            $job['morning'][$v] = 0;
                        }
                    }
                    foreach ($noon as $v) {
                        if (in_array($v, $job['worktime_n'])) {
                            $job['noon'][$v] = 1;
                        } else {
                            $job['noon'][$v] = 0;
                        }
                    }
                    foreach ($afternoon as $v) {
                        if (in_array($v, $job['worktime_n'])) {
                            $job['afternoon'][$v] = 1;
                        } else {
                            $job['afternoon'][$v] = 0;
                        }
                    }
                }
                $job['apply']   =   !empty($apply) ? 1 : 0;
                $job['collect'] =   !empty($collect) ? 1 : 0;

                if (isset($_POST['provider'])) {
                    if ($_POST['provider'] == 'app') {

                        $job['shareData'] = array(
                            'url'       =>  Url('wap', array('c' => 'part', 'a' => 'show', 'id' => $id)),
                            'title'     =>  $job['name'],
                            'summary'   =>  mb_substr(strip_tags($job['content']), 0, 30, 'UTF8'),
                            'imageUrl'  =>  checkpic($this->config['sy_wx_sharelogo'])
                        );
                    }
                    if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['toutiao']) {
                        $seoData['part_name']   =   $job['name'];
                        $this->data             =   $seoData;
                        $seo                    =   $this->seo('part_show', '', '', '', false, true);
                        $job['seo']             =   $seo;
                    }
                }
                $error = 1;
            } else {
                $msg    =   '该兼职暂无法展示！';
                $error  =   0;
            }
        }

        $info   =   count($job) ? $job : array();
        $this->render_json($error, $msg, $info);
    }

    function apply_action()
    {

        $user       =   $this->yzToken((int)$_POST['uid'], $_POST['token']);
        $uid        =   $user['uid'];
        $usertype   =   $user['usertype'];

        $partM      =   $this->MODEL('part');
        $jobid      =   (int)$_POST['jobid'];

        $data       =   array(
            'uid'       =>  $uid,
            'usertype'  =>  $usertype,
            'jobid'     =>  $jobid,
            'port'      =>  $_POST['codelPlat'] == 'mini' ? '3' : '4'
        );

        $return     =   $partM->addPartSq($data);

        $this->render_json($return['status'], $return['msg']);

    }

    function fav_action()
    {

        $user       =   $this->yzToken((int)$_POST['uid'], $_POST['token']);
        $uid        = $user['uid'];
        $usertype   =   $user['usertype'];

        $partM      =   $this->MODEL('part');

        $jobid      =   (int)$_POST['jobid'];
        $comid      =   (int)$_POST['comid'];

        $data       =   array(

            'uid'       =>  $uid,
            'usertype'  =>  $usertype,
            'jobid'     =>  $jobid,
            'comid'     =>  $comid
        );

        $return     =   $partM->addPartCollect($data);
        $this->render_json($return['status'], $return['msg']);
    }
}

?>