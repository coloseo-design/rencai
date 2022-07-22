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

class admin_weblog_controller extends adminCommon
{

    function set_search()
    {
        $search_list[]  =   array("param" => "usertype", "name" => '用户类型', "value" => array("1" => "个人用户", "2" => "企业用户"));
        $search_list[]  =   array("param" => "times", "name" => '行为日期', "value" => array("1" => "今天", "2" => "昨天", "3" => "最近3天", "4" => "最近7天"));
        $this->yunset("search_list", $search_list);
    }

    function index_action()
    {

        $webLogM    =   $this->MODEL('weblog');
        $UserinfoM  =   $this->MODEL('userinfo');
        $this->set_search();

        $where['usertype']  =   array('in', '1,2');

        if (trim($_GET['keyword'])) {
            if ($_GET['type'] == 1) {

                $username   =   $UserinfoM->getList(array('username' => array('like', trim($_GET['keyword']))), array('field' => '`uid`,`username`'));
                if ($username && is_array($username)) {
                    foreach ($username as $val) {
                        $muids[]    =   $val['uid'];
                    }
                    $where['uid']   =   array('in', pylode(',', $muids));
                }
            }
            $urlarr["keyword"]  =   $_GET["keyword"];
            $urlarr["type"]     =   $_GET["type"];
        }
        if ($_GET['usertype']) {

            $where['usertype']  =   $_GET['usertype'];
            $urlarr['usertype'] =   $_GET['usertype'];
        }

        if ($_GET['times']) {

            $today  =   strtotime(date('Y-m-d'));
            if ($_GET['times'] == 1) {

                $where['time']  =   array('>=', $today, 'AND');
            } else if ($_GET['times'] == 2) {

                $where['PHPYUNBTWSTART_A']  =   '';
                $where['time']  =   array('>=', strtotime('-1 day', $today), 'AND');
                $where['time']  =   array('<', $today, 'AND');
                $where['PHPYUNBTWEND_A']    =   '';
            } else if ($_GET['times'] == 3) {

                $where['time']  =   array('>=', strtotime('-3 day', $today), 'AND');
            } else if ($_GET['times'] == 4) {

                $where['time']  =   array('>=', strtotime('-7 day', $today), 'AND');
            }
            $urlarr['times']    =   $_GET['times'];
        }

        if ($_GET['time']) {
            $times              =   @explode('~', $_GET['time']);
            $where['PHPYUNBTWSTART_A']  =   '';
            $where['time'][]    =   array('>=', strtotime($times[0] . "00:00:00"), 'AND');
            $where['time'][]    =   array('<=', strtotime($times[1] . "23:59:59"), 'AND');
            $where['PHPYUNBTWEND_A']  =   '';
            $urlarr['time']     =   $_GET['time'];
        }
		$urlarr        	=   $_GET;
        $urlarr['page'] = "{{page}}";
        $pageurl    =   Url($_GET['m'], $urlarr, 'admin');
        $pageM      =   $this->MODEL('page');
        $pages      =   $pageM->pageList('web_log', $where, $pageurl, $_GET['page']);
        if ($pages['total'] > 0) {
            if ($_GET['order']) {

                $where['orderby']   =   $_GET['t'] . ',' . $_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];
            } else {

                $where['orderby']   =   'id';
            }
            $where['limit'] =   $pages['limit'];
            $rows           =   $webLogM->getWebLogList($where, array('utype' => 'admin'));
        }
        $this->yunset("rows", $rows);
        $this->yuntpl(array('admin/admin_weblog'));
    }


    function tj_action()
    {

        if ($_GET['uid'] && $_GET['usertype']) {

            $this->yunset("uid", $_GET['uid']);
            $this->yunset("usertype", $_GET['usertype']);
        }
        $this->yuntpl(array('admin/admin_weblogtj'));
    }


    function getloglist_action()
    {

        if ($_POST['uid']) {

            $webLogM        =   $this->MODEL('weblog');

            $where['uid']   =   intval($_POST['uid']);

            //默认取当天数据
            $today          =   strtotime(date('Y-m-d'));
            if ($_POST['time'] == 1) {

                $where['time']  =   array('>=', $today, 'AND');
            } else if ($_POST['time'] == 2) {

                $where['PHPYUNBTWSTART_A']  =   '';
                $where['time'][]            =   array('>=', strtotime('-1 day', $today), 'AND');
                $where['time'][]            =   array('<', $today, 'AND');
                $where['PHPYUNBTWEND_A']    =   '';
            } else if ($_POST['time'] == 3) {

                $where['time']  =   array('>=', strtotime('-3 day', $today), 'AND');
            } else if ($_POST['time'] == 4) {

                $where['time']  =   array('>=', strtotime('-7 day', $today), 'AND');
            }

            if ($_POST['times']) {
                $times              =   @explode('~', $_POST['times']);
                $where['PHPYUNBTWSTART_B']  =   '';
                $where['time'][]    =   array('>=', strtotime($times[0] . "00:00:00"), 'AND');
                $where['time'][]    =   array('<=', strtotime($times[1] . "23:59:59"), 'AND');
                $where['PHPYUNBTWEND_B']  =   '';
                $urlarr['time']     =   $_GET['time'];
            }

            $pagenav            =   $_POST['pagenav'] > 0 ? $_POST['pagenav'] : 0;

            $where['limit']     =   array($pagenav * $this->config['sy_listnum'], $this->config['sy_listnum']);

            $where['orderby']   =   'id';

            $rows               =   $webLogM->getWebLogList($where);

            if (!empty($rows)) {

                $List['code']       =   1;
                $List['list']       =   $rows;
                $List['pagenav']    =   $pagenav + 1;
            } else {

                $List['code']       =   2;
            }
            echo json_encode($List);
        }
    }

    function getlogtj_action()
    {

        if ($_POST['uid']) {

            $webLogM    =   $this->MODEL('weblog');
            $logCount   =   $webLogM->logCount(array('uid' => $_POST['uid'], 'time' => $_POST['time'], 'times' => $_POST['times'], 'usertype' => $_POST['usertype']));
            echo json_encode($logCount);
        }
    }


}

?>