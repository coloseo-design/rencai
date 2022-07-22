<?php
/* *
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
*/
class admin_app_config_controller extends adminCommon{  
	function index_action()
	{
	    include(DATA_PATH.'api/wxapp/app.config.php');
	    if (!empty($appconfig['sy_push_appid']) || !empty($appconfig['sy_push_appsecret']) || !empty($appconfig['sy_push_appkey']) || !empty($appconfig['sy_push_masterSecret'])){
	        
	        $this->config['sy_push_appid']         =  $appconfig['sy_push_appid'];
	        $this->config['sy_push_appsecret']     =  $appconfig['sy_push_appsecret'];
	        $this->config['sy_push_appkey']        =  $appconfig['sy_push_appkey'];
	        $this->config['sy_push_masterSecret']  =  $appconfig['sy_push_masterSecret'];
	        
	        $this -> yunset('config', $this->config);
	    }
		$this->yuntpl(array('admin/admin_app_config'));
	}
	function save_action()
	{
	    $_POST	=	$this->post_trim($_POST);
	    
	    if ($_POST['sy_app_open']){
	        
	        $data['sy_app_open'] 		= 	1;
	        
	    }else{
	        
	        $data['sy_app_open'] 		= 	2;
	        
	    }
	    
	    if ($_POST['sy_push_open'] && PHP_VERSION >= '5.5'){
	        
	        $data['sy_push_open'] 		= 	1;
	        
	    }else{
	        
	        $data['sy_push_open'] 		= 	2;
	        
	    }
	    
	    if ($_POST['sy_iospay']){
	        
	        $data['sy_iospay']			=	1;
	        
	    }else{
	        
	        $data['sy_iospay'] 			= 	2;
	        
	    }
	    
	    if ($_POST['sy_ioslocation']){
	        
	        $data['sy_ioslocation'] 	= 	1;
	        
	    }else{
	        
	        $data['sy_ioslocation'] 	= 	2;
	        
	    }
	    
	    if ($_POST['sy_app_qqlogin']){
	        $data['sy_app_qqlogin'] 		= 	1;
	    }else{
	        $data['sy_app_qqlogin'] 		= 	2;
	        
	    }
	    if ($_POST['sy_app_wxlogin']){
	        $data['sy_app_wxlogin'] 	= 	1;
	    }else{
	        $data['sy_app_wxlogin'] 	= 	2;
	    }
	    if ($_POST['sy_app_wxkf']){
	        $data['sy_app_wxkf'] 	= 	1;
	    }else{
	        $data['sy_app_wxkf'] 	= 	2;
	    }
	    
	    $configM  =  $this->MODEL('config');
	    $configM->setConfig($data);
	    
	    $this->web_config();
	    
	    $appData  =  array(
	        'sy_push_appid'         =>  $_POST['sy_push_appid'],
	        'sy_push_appsecret'     =>  $_POST['sy_push_appsecret'],
	        'sy_push_appkey'        =>  $_POST['sy_push_appkey'],
	        'sy_push_masterSecret'  =>  $_POST['sy_push_masterSecret']
	    );
	    $wxappM  =  $this->MODEL('wxapp');
	    $wxappM->setConfig($appData);
	    
	    if ($_POST['sy_push_open'] && PHP_VERSION < '5.5'){
	        
	        $this->ACT_layer_msg("PHP版本低于5.5，无法使用推送！",8,$_SERVER['HTTP_REFERER'],2,1);
	        
	    }else{
	        
	        $this->ACT_layer_msg("App设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
	    }
	}
	function version_action()
	{
	    include(DATA_PATH.'api/wxapp/app.config.php');
	    if (!empty($appconfig['apptitle']) || !empty($appconfig['androidurl']) || !empty($appconfig['iosurl'])){
	        
	        $this->config['iosversion']      =  $appconfig['iosversion'];
	        $this->config['iosurl']          =  $appconfig['iosurl'];
	        $this->config['androidversion']  =  $appconfig['androidversion'];
	        $this->config['androidurl']      =  $appconfig['androidurl'];
	        $this->config['apptitle']        =  $appconfig['apptitle'];
	        $this->config['appcontent']      =  $appconfig['appcontent'];
	        $this->config['sy_app_upforce']  =  $appconfig['sy_app_upforce'];
	        
	        $this -> yunset('config', $this->config);
	    }
	    
	    $this->yuntpl(array('admin/admin_app_version'));
	}
	function saveversion_action()
	{
	    
	    $_POST  =  $this->post_trim($_POST);
	    
	    $appData  =  array(
	        'iosversion'      =>  $_POST['iosversion'],
	        'iosurl'          =>  $_POST['iosurl'],
	        'androidversion'  =>  $_POST['androidversion'],
	        'androidurl'      =>  $_POST['androidurl'],
	        'apptitle'        =>  $_POST['apptitle'],
	        'appcontent'      =>  $_POST['appcontent'],
	        'sy_app_upforce'  =>  isset($_POST['sy_app_upforce']) ? 1 : 0
	    );
	    $wxappM  =  $this->MODEL('wxapp');
	    $wxappM->setConfig($appData);
	    
	    $this->ACT_layer_msg("App版本更新设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
	}
	function xybox_action()
	{
	    include(DATA_PATH.'api/wxapp/app.config.php');
	    $this->yunset('appconfig',$appconfig);
	    $this->yuntpl(array('admin/admin_app_version'));
	}
	function savexybox_action()
	{
	    $_POST  =  $this->post_trim($_POST);
	    
	    $appData  =  array(
	        'xyboxtitle'      =>  $_POST['xyboxtitle'],
	        'xyboxcontent'    =>  $_POST['xyboxcontent']
	    );
	    $wxappM  =  $this->MODEL('wxapp');
	    $wxappM->setConfig($appData);
	    
	    $this->ACT_layer_msg("App首页提示设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
	}
}
?>