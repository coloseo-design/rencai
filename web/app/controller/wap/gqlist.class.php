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

class gqlist_controller extends common
{

    function index_action()
    {

        $this->get_moblie();
        $this->yunset('backurl', Url('wap'));
        $this->yunset('headertitle', '自由职业');
        $this->seo('gq_index');
        $this->yuntpl(array('wap/gqlist'));
    }

    function task_action()
    {

        $gqdemandM  =   $this->MODEL('gqdemand');
        $start_time =   strtotime(date('Y-m-d 00:00:00'));
        $end_time   =   strtotime(date('Y-m-d 23:59:59'));//开始时间

        $taskwhere['PHPYUNBTWSTATRT_A'] =   '';
        $taskwhere['ctime'][]           =   array('>', $start_time, 'AND');
        $taskwhere['ctime'][]           =   array('<', $end_time, 'AND');
        $taskwhere['PHPYUNBTWEND_A']    =   '';

        $taskwhere['uid']       =   $this->uid;
        $taskwhere['pay']       =   3;

        $mess   =   $gqdemandM->getTaskNum($taskwhere);

        if ($this->config['gq_pay_price'] == 0) {

            if ($this->config['gq_number'] > 0) {

                $num    =   $this->config['gq_number'] - $mess;
            } else {

                $num    =   $this->config['gq_number'];
            }

            $this->yunset("num", $num);
        }
        $this->get_moblie();
        $this->yunset('backurl', Url('wap', array('c' => 'gqlist')));
        $this->yunset('headertitle', '任务大厅');
        $this->seo('gq_task');
        $this->yuntpl(array('wap/gqtask'));
    }


    function taskshow_action()
    {

        $this->get_moblie();

        $gqdemandM  =   $this->MODEL('gqdemand');

        $uid        =   $this->uid;

        if ($_GET['id']) {

            $where['id']    =   intval($_GET['id']);

            $show           =   $gqdemandM->getGqtaskInfo($where, array('type' => 1));

            if (is_array($show) && $show) {

                if ($show['pay'] == 1 && $show['uid'] != $uid){

                    $this->ACT_msg_wap(Url('wap', array('c' => 'gqlist', 'a' => 'task')), '任务不存在!', 2, 5);
                }

                //统计添加记录
                $gqdemandM->getGqtaskhits(intval($_GET['id']), array('type' => 1));

                if ($uid != $show['uid'] && $uid) {

                    //查询一下  里面是否存在浏览记录
                    $browerwhere['task_id'] =   intval($_GET['id']);
                    $browerwhere['uid']     =   $this->uid;

                    $updata         =   array(

                        'uid'       =>  $this->uid,//浏览uid
                        'task_id'   =>  $show['id'],
                        'task_name' =>  $show['name'],
                        'gq_id'     =>  $show['uid'],//任务发布者id
                        'ctime'     =>  time()//更新时间
                    );
                    $gqdemandM->addbrowertask($browerwhere, $updata);
                }
            } else {

                $this->ACT_msg_wap(Url('wap', array('c' => 'gqlist', 'a' => 'task')), '任务不存在!', 2, 5);
            }
        }

        $this->yunset('show', $show);
        $this->yunset('backurl', Url('wap', array('c' => 'gqlist', 'a' => 'task')));
        $this->yunset('headertitle', '任务详情');
        $this->seo('gq_taskshow');
        $this->yuntpl(array('wap/gqtask_show'));
    }

    function free_action()
    {

        $this->get_moblie();
        $where['state']     =   1;
        $where['r_status']  =   1;
        $where['status']    =   1;
        if ($_GET['keyword']) {

            $where['name']      =   array('like', $_GET['keyword']);
            $urlarr['keyword']  =   $_GET['keyword'];
        }

        $urlarr['page']     =   '{{page}}';
        $pageurl            =   Url('wap', $urlarr);

        $pageM  =   $this->MODEL('page');
        $pages  =   $pageM->pageList('gq_info', $where, $pageurl, $_GET['page']);
        if ($pages['total'] > 0) {

            $where['orderby']   =   'uid';
            $where['limit']     =   $pages['limit'];
            $gqdemandM          =   $this->MODEL('gqdemand');
            $List               =   $gqdemandM->getGqinfoList($where);
            $this->yunset('rows', $List);
        }

        $this->yunset('backurl', Url('wap', array('c' => 'gqlist')));
        $this->yunset('headertitle', '自由职业者大厅');
        $this->seo('gq_free');
        $this->yuntpl(array('wap/gqfree'));
    }

    function freeshow_action()
    {

        $this->get_moblie();

        $gqdemandM  =   $this->MODEL('gqdemand');

        $where['state'] =   1;

        if ($_GET['id']) {

            $where['uid']   =   intval($_GET['id']);
            $show           =   $gqdemandM->getGqInfo($where);
            if (empty($show['uid'])) {
                $this->ACT_msg_wap(Url('wap', array('c' => 'gqlist', 'a' => 'free')), '任务不存在!', 2, 5);
            }
            $this->yunset('show', $show);
        }

        $this->yunset('backurl', Url('wap', array('c' => 'gqlist', 'a' => 'free')));
        $this->yunset('headertitle', '自由职业者');
        $this->seo('gq_freeshow');
        $this->yuntpl(array('wap/gqfree_show'));
    }

}

?>