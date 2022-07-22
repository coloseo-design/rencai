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

class errlog_controller extends adminCommon
{

    function set_search()
    {
        $ad_time = array('1' => '今天', '3' => '最近三天', '7' => '最近七天', '15' => '最近半月', '30' => '最近一个月');
        $logtype = array('1' => '注册', '2' => '添加简历', '3' => '申请职位', '4' => '发布职位', '5' => '刷新职位', '6' => '下载简历', '7' => '邀请面试', '8' => '发送短信', '9' => '发送邮件', '10' => '微信小程序', '11' => '内容检测');

        $search_list[] = array("param" => "end", "name" => '发布时间', "value" => $ad_time);
        $search_list[] = array("param" => "logtype", "name" => '类型', "value" => $logtype);

        $this->yunset("search_list", $search_list);
    }

    function index_action()
    {

        $this->set_search();

        $errlogM    =   $this->MODEL('errlog');

        if (trim($_GET['keyword'])) {
            if ($_GET['type'] == "1") {

                $where['uid']       =   $_GET['keyword'];
            } else {

                $where['content']   =   array('like', trim($_GET['keyword']));
            }

            $urlarr['keyword']      =   $_GET['keyword'];
            $urlarr['type']         =   $_GET['type'];
        }

        if (isset($_GET['end'])) {
            if ($_GET['end'] == '1') {

                $where['ctime']     =   array('>=', strtotime(date("Y-m-d 00:00:00")));
            } else {

                $where['ctime']     =   array('>=', strtotime('-' . $_GET['end'] . 'day'));
            }
            $urlarr['end']          =   $_GET['end'];
        }

        if ($_GET['logtype']) {

            $where['type']          =   $_GET['logtype'];
            $urlarr['logtype']      =   $_GET['logtype'];
        }

        $urlarr         =   $_GET;
        $urlarr['page'] =   "{{page}}";

        $pageurl        =   Url($_GET['m'], $urlarr, 'admin');
        $pageM          =   $this->MODEL('page');
        $pages          =   $pageM->pageList('error_log', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {
            if ($_GET['order']) {

                $where['orderby']   =   $_GET['t'] . ',' . $_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];
            } else {

                $where['orderby']   =   array('isread, asc', 'id,desc');
            }

            $where['limit']         =   $pages['limit'];
            $List                   =   $errlogM->getList($where, array('utype' => 'admin'));
            $this->yunset('rows', $List);
        }
        $this->yuntpl(array('admin/errlog'));
    }

    function del_action()
    {
        $this->check_token();

        $errlogM    =   $this->MODEL('errlog');

        if ($_GET["id"] == 'all') {

            $where['id']    =   array('>', 0);
            $errlogM->delErrlog($where);
            $this->layer_msg("已清空错误日志！", 9, 0, $_SERVER['HTTP_REFERER']);
        } else {

            if ($_GET["del"]) {

                $where['id']    =   array('in', pylode(',', $_GET["del"]));
            } elseif (isset($_GET["id"])) {

                $where['id']    =   $_GET["id"];
            }

            $return =   $errlogM->delErrlog($where);
            $this->layer_msg($return['msg'], $return['errcode'], $return['layertype'], $_SERVER['HTTP_REFERER']);
        }
    }
}