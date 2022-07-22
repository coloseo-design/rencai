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
class lietou_controller extends common
{

    function public_action()
    {
        $this->yunset('lietoustyle', TPL_PATH . 'lietou');
        $this->yunset('lietou_style', $this->config['sy_weburl'] . '/app/template/lietou');
        $this->yunset('uid', $this->uid);
        $this->yunset('username', $this->username);
    }

    function lietou_tpl($tpl)
    {
        $this->yuntpl(array('lietou/'.$tpl));
    }

    function job($M)
    {
        session_start();
        
        if ($_POST['submit']) {
            
            if (! $this->uid) {
                $this->ACT_layer_msg('请先登录！', 8, $_SERVER['HTTP_REFERER']);
            }
            
            if ($this->usertype == '4') {
                $this->ACT_layer_msg('只有个人用户和hr可以留言！', 8, $_SERVER['HTTP_REFERER']);
            }
            
            if (trim($_POST['content']) == '') {
                $this->ACT_layer_msg('留言内容不能为空！', 8, $_SERVER['HTTP_REFERER']);
            }
            
            if (trim($_POST['authcode']) == '') {
                $this->ACT_layer_msg('验证码不能为空！', 8, $_SERVER['HTTP_REFERER']);
            }
            
            if (md5(strtolower($_POST['authcode'])) != $_SESSION['authcode'] || empty($_SESSION['authcode'])) {
                $this->ACT_layer_msg('验证码错误！', 8, $_SERVER['HTTP_REFERER']);
            }
            
            $_POST['uid']       =   $this->uid;
            $_POST['username']  =   $this->username;
            $_POST['datetime']  =   time();
            
            unset($_POST['submit']);
            
            $msgM   =   $this->MODEL('msg');
            $msgM -> addInfo($_POST);
            $this -> ACT_layer_msg('留言成功！', 9, $_SERVER['HTTP_REFERER']);
            
        } else if ((int) $_GET['id']) {
             
            $job    =   $M -> getInfo(array('id' => intval($_GET['id'])), array('cache' => '1', 'datatype' => 'moreinfo'));
        }
        
        if ($_SESSION['auid'] != '') {
            
            if (!is_array($job)) {
                $this->ACT_msg(url('lietou', array('c' => 'post')), '没有该职位！');
            }
            
        } else {
            if (!is_array($job)) {
                
                $this->ACT_msg(url('lietou', array('c' => 'post')), '没有该职位！');
                
            } elseif ($job['r_status'] == '2') {
                
                $this->ACT_msg(url('lietou', array('c' => 'post')), '企业已被锁定！');
            } elseif ($job['zp_status'] == 1) {
                
                $this->ACT_msg(url('lietou', array('c' => 'post')), '职位已下架！');
            } elseif ($job['status'] == 0) {
                
                $this->ACT_msg(url('lietou', array('c' => 'post')), '职位还未审核，请耐心等待！');
            } elseif ($job['status'] == 3) {
                
                $this->ACT_msg(url('lietou', array('c' => 'post')), '职位审核未通过！');
            }
        }

        $this->yunset($job['cache']);

        $UserInfoM  =   $this->MODEL('userinfo');
        $com        =   $UserInfoM -> getUserInfo(array('uid' => $job['uid']), array('usertype' => 2));
        
        if ($com['shortname']) {
            $job['com_name'] = $com['shortname'];
        }

        if ($job['status'] == '2' || $job['zp_status'] == '1') {
            $job['notuserjob'] = 1;
        }
        $this->yunset('job', $job);
        
        $data['job_name']   =   $job['job_name'];
        
        $this->data = $data;
        
        return $job;
    }
}
?>