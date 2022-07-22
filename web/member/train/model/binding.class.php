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

class binding_controller extends train{

    function index_action()
    {


        $userM  =   $this->MODEL('userinfo');
        $member	=	$userM->getInfo(array('uid'=> $this->uid), array('setname'=>'1'));
        $this->yunset('member',$member);

        $comM   =   $this->MODEL('company');
        $cert   =   $comM->getCertInfo(array('uid' => $this->uid, 'type' => '5'));
        $this->yunset('cert', $cert);

        $this->train_satic();
        $this->train_tpl('binding');
    }
	
	/**
	 * @desc 手机认证
	 */
    function save_action()
    {

        $CookieM    =   $this->MODEL('cookie');
        $CookieM->SetCookie('delay', '', time() - 60);

        $CompanyM   =   $this->MODEL('company');

        $data       =   array(

            'uid'       =>  $this->uid,
            'usertype'  =>  $this->usertype,
            'moblie'    =>  $_POST['moblie']
        );

        $errCode    =   $CompanyM->upCertInfo(array('uid' => $this->uid, 'check2' => $_POST['code']), array('status' => '1'), $data);

        echo $errCode;
        die;

    }

    function savecert_action()
    {

        $CookieM    =   $this->MODEL('cookie');
        $CookieM->SetCookie('delay', '', time() - 60);

        $ComapnyM   =   $this->MODEL('company');

        $uid        =   intval($this->uid);
        $usertype   =   intval($this->usertype);

        $row        =   $ComapnyM->getCertInfo(array('uid' => $uid, 'type' => '5'));

        if ($this->pxInfo['r_status'] == 0) {

            $status =   0;
        } else {

            $status =   $this->config['px_cert_status'] == '1' ? 0 : 1;
        }
        /* 更新培训执照参数整理  */
        $upData     =   array(

            'status'    =>  $status,
            'check'     =>  $_FILES['file'],
            'check2'    =>  '0',
            'step'      =>  '1',
            'ctime'     =>  time()
        );

        /* 自定义参数整理  */
        $data       =   array(

            'yyzz'      =>  '1',
            'usertype'  =>  $usertype,
            'type'      =>  '5',
            'px_name'   =>  trim($_POST['name'])
        );

        if (!empty($row) && is_array($row) && $row['ctime']) {

            $err    =   $ComapnyM->upCertInfo(array('id' => intval($row['id']), 'uid' => $uid), $upData, $data);
        } else {

            /* 新增培训执照参数补充，包含自定义查询参数  */
            $postData   =   array(

                'uid'       =>  $uid,
                'did'       =>  $this->userdid,
                'usertype'  =>  $usertype,
                'px_name'   =>  trim($_POST['name']),
                'type'      =>  '5',

            );

            $postData   =   array_merge($postData, $upData);

            $err        =   $ComapnyM->addCertInfo($postData);
        }

        $this->ACT_layer_msg($err['msg'], $err['errcode'], $_SERVER['HTTP_REFERER']);
    }

    /**
     * @desc 解除绑定
     */
    function del_action()
    {

        $companyM   =   $this->MODEL('company');
        $return     =   $companyM->delBd($this->uid, array('type' => $_GET['type'], 'usertype' => $this->usertype));
        $this->layer_msg($return['msg'], $return['errcode'], 0, $_SERVER['HTTP_REFERER']);
    }
}
?>