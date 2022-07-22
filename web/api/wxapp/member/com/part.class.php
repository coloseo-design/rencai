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

class part_controller extends com_controller
{

    /**
     * 兼职报名列表
     */
    function applylist_action()
    {

        $partM              =   $this->MODEL('part');

        $where['comid']     =   $this->member['uid'];

        if (isset($_POST['partid'])) {

            $where['jobid'] =   intval($_POST['partid']);
        }

        $where['orderby']   =   array('id,desc');

        $rows               =   $partM->getPartSqList($where);
        if ($rows && is_array($rows)) {

            $data['list']   =   $rows;

            $this->render_json(0, 'ok', $data);
        } else {

            $this->render_json(2);
        }
    }

    /**
     * 删除兼职报名
     */
    function delapply_action()
    {

        $partM  =   $this->MODEL('part');

        $id     =   intval($_POST['ids']);

        $return =   $partM->delPartApply($id, array('uid' => $this->member['uid'], 'usertype' => $this->member['usertype']));

        $error  =   $return['errcode'] == 9 ? 1 : 2;

        $this->render_json($error, $return['msg']);
    }

    /**
     * 简历列表
     */
    function partlist_action()
    {

        $partM  =   $this->MODEL('part');

        $stype              =   (int)$_POST['stype'];

        $where['uid']       =   $this->member['uid'];

        if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {

            $where['name']  =   array('like', $_POST['keyword']);
        }

        if ($stype == 1) {

            $where['state']             =   1;
            $where['PHPYUNBTWSTART_A']  =   '';
            $where['edate'][]           =   array('>', time(), '');
            $where['edate'][]           =   array('=', 0, 'OR');
            $where['PHPYUNBTWEND_A']    =   '';
        } else if ($stype == '2') {

            $where['state']             =   array('<>', 1);
        } else if ($stype == '3') {

            $where['PHPYUNBTWSTART_A']  =   '';
            $where['edate'][]           =   array('<', time(), '');
            $where['edate'][]           =   array('<>', 0, '');
            $where['PHPYUNBTWEND_A']    =   '';
        }


        $data['total']      =   $partM->getpartJobNum($where);
        $page               =   $_POST['page'];

        if ($_POST['limit']) {

            $limit              =   $_POST['limit'];
            if ($page) {

                $pagenav        =   ($page - 1) * $limit;
                $where['limit'] =   array($pagenav, $limit);
            } else {

                $where['limit'] =   $limit;
            }
        }

        $rows   =   $partM->getList($where);
        $zp =   $sh =   $dq =   0;

        if ($stype == 1) {

            $zp =   count($rows);
        } else if ($stype == 2) {

            $sh =   count($rows);
        } else if ($stype == 3) {

            $dq =   count($rows);
        }
        $data['zp']     =   $zp;
        $data['sh']     =   $sh;
        $data['dq']     =   $dq;

        $data['statis'] =   $this->company_statis($this->member['uid']);
        $data['list']   =   $rows;
        $data['iosfk']  =   $this->config['sy_iospay'];
        $data['fktype'] =   $this->fktype();
        $data['config'] =   array(

            'recPrice'              =>  $this->config['com_recjob'],
            'online'                =>  $this->config['com_integral_online'],
            'integral_name'         =>  $this->config['integral_pricename'],
            'integral_proportion'   =>  $this->config['integral_proportion'],
            'integral_min'          =>  $this->config['integral_min_recharge']
        );
        $comSingle      =   @explode(',', $this->config['com_single_can']);
        $data['config']['recJob']   =   in_array('jobrec', $comSingle) ? '1' : '2';
        $onlyPrice      =   @explode(',', $this->config['sy_only_price']);
        $data['config']['onlyRec']  =   in_array('jobrec', $onlyPrice) ? '1' : '2';

        $this->render_json(0, 'ok', $data);
    }

    /**
     * 兼职列表tab数量统计
     */
    function partnum_action()
    {

        $partM  =   $this->MODEL('part');
        $where['uid']       =   $this->member['uid'];

        if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {

            $where['name']  =   array('like', $_POST['keyword']);
        }

        $dqWhere = $dsWhere = $zpWhere = $where;
        // 招聘中
        $zpWhere['state']             =   1;
        $zpWhere['PHPYUNBTWSTART_A']  =   '';
        $zpWhere['edate'][]           =   array('>', time(), '');
        $zpWhere['edate'][]           =   array('=', 0, 'OR');
        $zpWhere['PHPYUNBTWEND_A']    =   '';
        //待审
        $dsWhere['state']             =   array('<>', 1);
        // 已到期
        $dqWhere['PHPYUNBTWSTART_A']  =   '';
        $dqWhere['edate'][]           =   array('<', time(), '');
        $dqWhere['edate'][]           =   array('<>', 0, '');
        $dqWhere['PHPYUNBTWEND_A']    =   '';


        $data['count']['zp']      =   $partM->getpartJobNum($zpWhere);
        $data['count']['ds']      =   $partM->getpartJobNum($dsWhere);
        $data['count']['dq']      =   $partM->getpartJobNum($dqWhere);

        $this->render_json(0, 'ok', $data);
    }

    function delpart_action()
    {

        $partM  =   $this->MODEL('part');
        $id     =   (int)$_POST['id'];
        $delRes =   $partM->delPart($id, array('uid' => $this->member['uid'], 'usertype' => $this->member['usertype']));
        $error  =   $delRes['errcode'] == 9 ? 1 : 2;
        $msg    =   preg_replace('/\([^\)]+?\)/x', '', $delRes['msg']);
        $this->render_json($error, $msg);
    }


    function partedit_action()
    {

        $partM  =   $this->MODEL('part');

        $id     =   intval($_POST['id']);

        if ($id) {

            $where['uid']   =   $this->member['uid'];
            $where['id']    =   $id;

            $row    =   $partM->getInfo($where, array('edit' => 1));
            $row    =   $row['info'];

            if (!empty($row['x']) && !empty($row['y'])) {
                if (!empty($_POST['source']) && $_POST['source'] == 'wap') { // WAP站百度坐标系，不需要转

                } else {

                    $coordinates    =   $this->Convert_BD09_To_GCJ02($row['x'], $row['y']);
                    $row['x']       =   $coordinates['lng'];
                    $row['y']       =   $coordinates['lat'];
                }
            }
            if (!empty($row['content'])) {

                $row['content_t']   =   strip_tags($row['content']);
            }

            $this->render_json(0, 'ok', $row);
        } else {

            $this->render_json(2);
        }
    }

    function partsave_action()
    {

        $provider   =   isset($_POST['provider']) ? $_POST['provider'] : '';

        $comInfo    =   $this->comInfo;

        $partM      =   $this->MODEL('part');

        $_POST      =   $this->post_trim($_POST);

        if (!$_POST['name'] || !$_POST['type'] || !$_POST['number'] || !$_POST['address'] || !$_POST['linkman'] || !$_POST['linktel']) {

            $this->render_json(3, '请完善信息');
        }

        $msg        =   array();

        $isallow_addjob = '1';

        if ($this->config['com_enforce_emailcert'] == '1') {
            if ($this->comInfo['email_status'] != '1') {

                $isallow_addjob =   '0';
                $msg[]          =   '请先完成邮箱认证';
            }
        }
        if ($this->config['com_enforce_mobilecert'] == '1') {
            if ($this->comInfo['moblie_status'] != '1') {

                $isallow_addjob =   '0';
                $msg[]          =   '请先完成手机认证';
            }
        }
        if ($this->config['com_enforce_licensecert'] == '1') {

            $comM   =   $this->MODEL('company');
            $cert   =   $comM->getCertInfo(array('uid' => $this->member['uid'], 'type' => 3), array('field' => 'uid,status'));

            if ($this->comInfo['yyzz_status'] != '1' && (empty($cert) || $cert['status'] == 2)) {
                $isallow_addjob =   '0';
                $msg[]          =   '请先完成企业资质认证';
            }
        }
        if ($this->config['com_enforce_setposition'] == '1') {
            if (empty($this->comInfo['x']) || empty($this->comInfo['y'])) {
                $isallow_addjob =   '0';
                $msg[]          =   '请先完成企业地图设置';
            }
        }
        if ($this->config['com_gzgzh'] == '1') {
            if ($provider != 'toutiao' && $provider != 'baidu') {

                $userInfoM  =   $this->MODEL('userinfo');
                $uInfo      =   $userInfoM->getInfo(array('uid' => $this->member['uid']), array('field' => '`wxid`,`wxopenid`,`unionid`'));
                if (empty($uInfo['wxopenid']) && empty($uInfo['unionid'])) {

                    $isallow_addjob =   '0';
                    if (!empty($uInfo['wxid'])) {
                        $msg[]      =   '微信绑定失效请重新绑定';
                    } else {
                        $msg[]      =   '请先完成绑定微信';
                    }
                }
            }
        }

        if ($isallow_addjob == '0') {

            $data['msg']    =   implode(',', $msg) . '！';
        }
        if ($data['msg'] != '') {

            $this->render_json(-1, $data['msg']);
        }

        $id =   intval($_POST['id']);

        if (!$id) {

            $statis =   $this->company_statis($this->member['uid']);

            if ($statis['addjobnum'] == 0) {

                $arr['error']   =   3;
                $arr['msg']     =   '发布职位套餐已用完';
                $this->render_json($arr['error'], $arr['msg']);

            } elseif ($statis['addjobnum'] == 3) {

                $arr['error']   =   3;
                $arr['msg']     =   "您的" . $this->config['integral_pricename'] . "不足！";
                $this->render_json($arr['error'], $arr['msg']);
            }
        }
        if (!empty($_POST['edate'])) {
            $_POST['edate']     =   strtotime($_POST['edate']);
        }
        if (!empty($_POST['source']) && $_POST['source'] == 'wap') { // WAP站百度坐标系，不需要转

        } else {
            $coordinates    =   $this->Convert_GCJ02_To_BD09($_POST['x'], $_POST['y']);
            $_POST['x']     =   $coordinates['lng'];
            $_POST['y']     =   $coordinates['lat'];
        }

        $data   =   $_POST;

        $data['uid']        =   $this->member['uid'];
        $data['spid']       =   $this->member['spid'];
        $data['usertype']   =   $this->member['usertype'];
        $data['utype']      =   'user';
        $data['r_status']   =   $comInfo['r_status'];

        $return =   $partM->upPartInfo($data);
        $error  =   $return['errcode'] == 9 ? 1 : 2;
        $msg    =   preg_replace('/\([^\)]+?\)/x', '', $return['msg']);

        $this->render_json($error, $msg);
    }

    /**
     * 刷新兼职职位
     */
    function refresh_action()
    {

        $partids    =   intval($_POST['partid']);

        if (empty($partids)) {

            $this->render_json(1, '没有招聘中的职位');
        }

        $this->company_statis($this->member['uid']);

        //检查是否达到每日最大操作次数
        $result     =   $this->day_check($this->member['uid'], 'refreshjob');
        if ($result['status'] != 1) {

            $this->render_json(2, $result['msg']);
        }

        $refresh['partid']      =   $partids;
        $refresh['uid']         =   $this->member['uid'];
        $refresh['usertype']    =   $this->member['usertype'];

        if (!empty($this->member['spid'])) {
            $refresh['spid']    =   $this->member['spid'];
        }

        if (isset($_POST['provider'])) {

            if ($_POST['provider'] == 'wap') {

                $refresh['port']    =   2;
            } elseif ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'toutiao' || $_POST['provider'] == 'weixin') {

                $refresh['port']    =   3;
            } elseif ($_POST['provider'] == 'app') {

                $refresh['port']    =   4;
            }
        }

        $comtcM =   $this->MODEL('comtc');
        $return =   $comtcM->refresh_part($refresh);

        if (isset($return['msg']) && !empty($return['msg'])) {

            $return['msg'] =    strip_tags($return['msg']);
        }
        if ($return['status'] == 1) {

            $this->render_json(0, $return['msg']);
        } else if ($return['status'] == 2) {

            $this->render_json(3, $return['msg'], $return);
        } else {

            $this->render_json(4, $return['msg']);
        }
    }

    function upapply_action()
    {
        $applyid    =   $_POST['applyid'];
        if (empty($applyid)) {
            $this->render_json(2, '没有该申请');
        }
        $partM      =   $this->MODEL('part');
        $nid        =   $partM->upPartSq(array('id' => $applyid, 'comid'=>$this->member['uid']), array('status' => 2));
        if ($nid) {

            $this->render_json(1, '');
        } else {

            $this->render_json(2, '查看失败');
        }
    }
}