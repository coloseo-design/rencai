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
class admin_datav_config_controller extends adminCommon{

    
    function index_action(){
        $url = '';
        if($this->config['sy_datavurl'] && $this->config['sy_datav_token']){
            $url = $this->config['sy_datavurl'].'/index.php?token='.$this->config['sy_datav_token'];
        
        }else{
            if($this->config['sy_datavurl']){
                $datavurl   =   $this->config['sy_datavurl'];
            }else{
                $datavurl   =   $this->config['sy_weburl'].'/datav';
            }
            $url = $this->newurl($datavurl);
        }
        $this->yunset('url',$url);
        $this -> yuntpl(array('admin/admin_datav_config'));
    }
    function seturl_action(){

        $url = $_POST['url']?$_POST['url']:$this->config['sy_weburl'].'/datav';
        
        $data = array();
        if($url){
            $_url = $this->newurl($url);
            
            $data['url'] = $_url;
            $data['err'] = 1;
        }else{
            $data['err'] = 0;
        }

        echo json_encode($data);exit();
    }
    function newurl($url){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
        for ($i = 0; $i <6; $i++) { 
            $randomString .= $characters[rand(0, strlen($characters) - 1)]; 
        } 
        
        $config['sy_datavurl'] = $url;
        $config['sy_datav_token'] = $randomString;
        $configM  =  $this->MODEL('config');
        
        $configM -> setConfig($config);
        
        $this -> web_config();
        
        $_url = $url.'/index.php?token='.$randomString;
        return $_url;
    }
    function diyData_action(){

        $diydata = $this->config['sy_datav_diydata'];

        $diydata = !empty($diydata) ? json_decode($diydata,true):array();

        $this->yunset('diydata', $diydata);
        $this -> yuntpl(array('admin/admin_datav_diydata'));
    }

    function diyDataSave_action(){
        
        if($_POST['config']){
            
            
            $sy_datav_diydata  =  array(
                'datavtitle'  =>  trim($_POST['datavtitle']),
                'allcomnum'  =>  intval($_POST['allcomnum']),
                'daycomnum'  =>  intval($_POST['daycomnum']),
                'allusernum' =>  intval($_POST['allusernum']),
                'dayusernum' =>  intval($_POST['dayusernum']),
                'alljobnum'  =>  intval($_POST['alljobnum']),
                'dayjobnum'  =>  intval($_POST['dayjobnum']),
                'allzphnum'  =>  intval($_POST['allzphnum']),
                'dayzphnum'  =>  intval($_POST['dayzphnum']),
                'yearuser_monthreg'  =>  intval($_POST['yearuser_monthreg']),
                'yearuser_monthreg_rand'  =>  intval($_POST['yearuser_monthreg_rand']),
                'monthreg_user'  =>  intval($_POST['monthreg_user']),
                'dayreg_user'  =>  intval($_POST['dayreg_user']),
                'year_sqnum'  =>  intval($_POST['year_sqnum']),
                'year_yqnum'  =>  intval($_POST['year_yqnum']),
                'year_chatnum'  =>  intval($_POST['year_chatnum']),
                'year_lrnum'  =>  intval($_POST['year_lrnum']),
                'year_ljnum'  =>  intval($_POST['year_ljnum']),
                'yearcom_regnum'  =>  intval($_POST['yearcom_regnum']),
                'yearcom_monthreg'  =>  intval($_POST['yearcom_monthreg']),
                'yearcom_monthreg_rand'  =>  intval($_POST['yearcom_monthreg_rand']),
                'hothy_sqnum'       =>  intval($_POST['hothy_sqnum']),
                'hothy_sqnum_rand'  =>  intval($_POST['hothy_sqnum_rand']),
                'hothy_jobs'        =>  intval($_POST['hothy_jobs']),
                'hothy_jobs_rand'   =>  intval($_POST['hothy_jobs_rand']),
                'hotjob_sqnum'      =>  intval($_POST['hotjob_sqnum']),
                'hotjob_sqnum_rand' =>  intval($_POST['hotjob_sqnum_rand']),
                'hotjob_jobs'       =>  intval($_POST['hotjob_jobs']),
                'hotjob_jobs_rand'  =>  intval($_POST['hotjob_jobs_rand']),
            );

            $config['sy_datav_diydata'] = json_encode($sy_datav_diydata,JSON_UNESCAPED_UNICODE);
            $configM  =  $this->MODEL('config');
            
            $configM -> setConfig($config);
            
            $this -> web_config();
            
            $this->ACT_layer_msg('大屏基数配置设置成功',9,$_SERVER['HTTP_REFERER'],2,1);
        }
    }

}
?>