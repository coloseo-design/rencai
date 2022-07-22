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
class job_controller extends lietou
{

    function index_action()
    {
        
        $this -> public_action();
        
        $where          =   array();
        
        $where['uid']   =   $this->uid;
        $where['usertype']   =   $this->usertype;
        
        if ($_GET['zp_status'] == 1) {

            $where['zp_status']     =   '1';

            $urlarr['zp_status']    =   $_GET['zp_status'];
        } else {

            if ($_GET['s']) {

                $where['status']    =   $_GET['s'];

                $where['zp_status'] =   '0';

                $urlarr['s']        =   $_GET['s'];
            } else {

                $where['status']    =   '0';

                $where['zp_status'] =   '0';

                $urlarr['s']        =   0;
            }
        }
        $urlarr['c']    =   'job';

        $urlarr['page'] =   '{{page}}';

        $pageurl        =   Url('member', $urlarr);

        $pageM          =   $this->MODEL('page');

        $pages          =   $pageM->pageList('lt_job', $where, $pageurl, $_GET['page'], $this->config['sy_listnum']);

        if ($pages['total'] > 0) {
            
            if ($_GET['order']) {
            
                $where['orderby']   =   $_GET['t'].','.$_GET['order'];

                $urlarr['order']    =   $_GET['order'];

                $urlarr['t']        =   $_GET['t'];
            } else {

                $where['orderby']   =   'lastupdate';
            }
            
            $where['limit']         =   $pages['limit'];

            $ltjobM                 =   $this->MODEL('lietoujob');

            $List                   =   $ltjobM->getList($where);

            $this->yunset('joblist', $List);
        }

        $this->yunset('s', $_GET['s']);

        $this->yunset('zp_status', $_GET['zp_status']);

        $this->lietou_tpl('job');
    }

    function del_action()
    {
        
        if ($_GET['del'] != '' || $_GET['id']) {

            $ltjobM     =   $this->MODEL('lietoujob');

            if (is_array($_GET['del'])) {

                $del    =   pylode(",", $_GET['del']);
            } else {

                $del    =   (int) $_GET['id'];
            }
            $return     =   $ltjobM->delLietouJob($del);

            if ($return['id']) {
                
                $this->MODEL('log')->addMemberLog($this->uid, $this->usertype, "删除猎头职位", 10, 3); // 会员日志
            }
            
            $this->layer_msg($return['msg'], $return['errcode'], $return['layertype'], $_SERVER['HTTP_REFERER']);
            
        } else {

            $this->layer_msg('请选择要删除的职位！', 8, 2, $_SERVER['HTTP_REFERER']);
        }
    }

    function jobset_action()
    {
        if ($_GET['id']) {

            $nid    =   $this->MODEL('lietoujob')->upInfo(array('id' => intval($_GET['id']), 'uid' => $this->uid), array('zp_status' => (int) $_GET['zp']));

            if ($nid) {

                $this->MODEL('log')->addMemberLog($this->uid, $this->usertype, '设置猎头职位招聘状态', 10, 2); // 会员日志

                $this->layer_msg('操作成功！', 9, 0, $_SERVER['HTTP_REFERER']);
            } else {

                $this->layer_msg('操作失败！', 8, 0, $_SERVER['HTTP_REFERER']);
            }
        }
    }

    function ltRefreshJob_action()
    {
        
        if ($_POST) {
            
            $_POST['uid']		=	$this->uid;
            $_POST['usertype']	=	$this->usertype;
            $_POST['port']	    =   1;

            $comtcM =   $this->MODEL('comtc');

            $return =   $comtcM->ltRefreshJob($_POST);

            if ($return['status'] == 1) {// 猎头职位刷新成功
                
                echo json_encode(array(
                    'error' =>  1,
                    'msg'   =>  $return['msg']
                ));
            } else if ($return['status'] == 2) {// 套餐不足，金额消费
                
                echo json_encode(array(
                    'error'     =>  2,
                    'pro'       =>  $return['pro'],
                    'online'    =>  $return['online'],
                    'integral'  =>  $return['integral'],
                    'jifen'     =>  $return['jifen'],
                    'price'     =>  $return['price']
                ));
            } else {// 猎头职位刷新失败
                
                echo json_encode(array(
                    'error' =>  3,
                    'msg'   =>  $return['msg'],
                    'url'   =>  $return['url']
                ));
            }
        } else {
            
            echo json_encode(array(
                'error' =>  3,
                'msg'   =>  '参数错误，请重试！'
            ));
        }
    }
}
?>