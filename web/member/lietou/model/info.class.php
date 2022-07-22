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
class info_controller extends lietou
{

    function index_action()
    {
        
        $LietouM    =   $this->MODEL('lietou');

        $row        =   $LietouM->getInfo(array('uid' => $this->uid));

        $CacheList  =   $this->MODEL('cache')->GetCache(array('city', 'lt', 'ltjob', 'lthy'));
		
        $jobnameA   =   $hynameA    =   array();
        
        $job        =   @explode(',', $row['job']);
        
        $this->yunset('job', $job);
        
        $hy         =   @explode(',', $row['hy']);
        
        $this->yunset('hy', $hy);
        
        foreach ($job as $v) {
            
            $jobnameA[] =   $CacheList['ltjob_name'][$v];
        }
        
        $row['jobname'] =   @implode(',', $jobnameA);
        
        foreach ($hy as $v) {
            
            $hynameA[]  =   $CacheList['lthy_name'][$v];
        }
        
        $row['hyname']  =   @implode(',', $hynameA);

        $this->yunset($CacheList);

        $this->yunset('row', $row);

        $this->public_action();

        $this->yunset('class', '1');

        $this->lietou_tpl('info');
    }

    function save_action()
    {
        $LietouM        =   $this->MODEL('lietou');

        $lt            	=	$this->ltInfo;
		if($lt){
			$rstaus     =   $lt['r_status'];
		}else{
			$rstaus		=	$this->config['lt_status'];
		}
 
        $_POST['job']   =   pylode(',', $_POST['job']);

        $_POST['hy']    =   pylode(',', $_POST['qw_hy']);

        $mData          =   array('email' => $_POST['email'], 'moblie' => $_POST['moblie']);

        $ltData         =   array(
            'realname'      =>  $_POST['realname'],
            'com_name'      =>  $_POST['com_name'],
            'email'         =>  $_POST['email'],
            'moblie'        =>  $_POST['moblie'],
            'phone'         =>  $_POST['phone'],
            'provinceid'    =>  $_POST['provinceid'],
            'cityid'        =>  $_POST['cityid'],
            'three_cityid'  =>  $_POST['three_cityid'],
            'exp'           =>  $_POST['exp'],
            'title'         =>  $_POST['title'],
            'hy'            =>  $_POST['hy'],
            'job'           =>  $_POST['job'],
            'content'       =>  $_POST['content'],
            'r_status' 		=> 	$rstaus,
            'client'        =>  $_POST['client']
        );
		if(!$this -> ltInfo['uid']){
			$userinfoM    =   $this->MODEL("userinfo");
			$userinfoM -> activUser($this->uid,3);
		}
        $return         =   $LietouM->upLtInfo(array('uid' => $this->uid), array('mData' => $mData, 'ltData' => $ltData, 'utype' => 'user'));
        
        if ($return['url']) {
            
            $this->ACT_layer_msg($return['msg'], $return['errcode'], $_SERVER['HTTP_REFERER']);
        } else {
            // 当前手机号码不存在 页面不要刷新
            $this->ACT_layer_msg($return['msg'], $return['errcode']);
        }
    }
}
?>