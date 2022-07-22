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

class attention_me_controller extends company
{
    /*
    查看对我感兴趣的列表页面
    **/
    function index_action()
    {

        $where['sc_uid']            =   $this->uid;
        $where['sc_usertype']       =   2;
        $where['PHPYUNBTWSTART_A']  =   '';
        $where['xjhid'][]           =   array('=', 0);
        $where['xjhid'][]           =   array('isnull', '', 'OR');
        $where['PHPYUNBTWEND_A']    =   '';

        if (isset($_GET['keyword']) && !empty(trim($_GET['keyword']))) {

            $resumeM    =   $this->MODEL('resume');

            $resume     =   $resumeM->getSimpleList(array('uname' => array('like', trim($_GET['keyword']))), array('field' => 'uid'));

            if ($resume) {
                $uid    =   array();
                foreach ($resume as $v) {
                    if ($v['uid'] && !in_array($v['uid'], $uid)) {
                        $uid[]  =   $v['uid'];
                    }
                }
                $where['uid']   =   array('in', pylode(',', $uid));
            }
            $urlarr['keyword']  =   trim($_GET['keyword']);
        }

        $urlarr['c']    =   $_GET['c'];
        $urlarr['page'] =   '{{page}}';
        $pageurl        =   Url('member', $urlarr);

        $pageM  =   $this->MODEL('page');
        $pages  =   $pageM->pageList('atn', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {
            $where['orderby']   =   'id';
            $where['limit']     =   $pages['limit'];

            $atnM   =   $this->MODEL('atn');
            $List   =   $atnM->getatnList($where, array('utype' => 'user', 'uid' => $this->uid));
            $this->yunset('rows', $List);
        }

        //邀请面试选择职位
        $this->yqmsInfo();
        $this->company_satic();
        $this->public_action();

        $this->com_tpl('attention_me');
    }
}

?>