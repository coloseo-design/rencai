<?php
/*
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2018 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */
class version_controller extends wxapp_controller{    
	
	function index_action()
	{
	    include(DATA_PATH.'api/wxapp/app.config.php');
	    $update = false;
	    $platform = strtolower($_POST['platform']);
	    
	    if ($platform == 'ios' && !empty($appconfig['iosversion'])){
		    
		    $vcode  = $this->versionCompare($appconfig['iosversion'], $_POST['version']);
		    
		    if ($vcode == 1){
		        
		        $update = true;
		        
		        $data['version']     =  $appconfig['iosversion'];
		        $data['title']       =  $appconfig['apptitle'];
		        $data['note']        =  $appconfig['appcontent'];
		        $data['url']         =  $appconfig['iosurl'];
		        $data['forceUpdate'] =  !empty($appconfig['sy_app_upforce']) ? $appconfig['sy_app_upforce'] : 0;
		    }
		    
	    }elseif ($platform == 'android' && !empty($appconfig['androidversion'])){
		    
		    $vcode  = $this->versionCompare($appconfig['androidversion'], $_POST['version']);
		    
		    if ($vcode == 1){
		        
		        $update = true;
		        
		        $data['version']     =  $appconfig['androidversion'];
		        $data['title']       =  $appconfig['apptitle'];
		        $data['note']        =  $appconfig['appcontent'];
		        $data['url']         =  $appconfig['androidurl'];
		        $data['forceUpdate'] =  !empty($appconfig['sy_app_upforce']) ? $appconfig['sy_app_upforce'] : 0;
		    }
		}
		
		if ($update){
		    
		    $this->render_json(0,'ok',$data);
		    
		}else{
		    
		    $this->render_json(1,'no update');
		}
    }
    /**
     * 老版app更新配置
     */
    function oldIndex()
    {
        include(DATA_PATH.'api/wxapp/app.config.php');
        
        if (!empty($appconfig['iosversion'])){
            $data['iOS']['version'] = $appconfig['iosversion'];
            $data['iOS']['title'] = $appconfig['apptitle'];
            $data['iOS']['note'] = $appconfig['appcontent'];
            $data['iOS']['url'] = $appconfig['iosurl'];
        }else{
            $data['iOS']['version'] = $this->config['iosversion'];
            $data['iOS']['title'] = $this->config['apptitle'];
            $data['iOS']['note'] = $this->config['appcontent'];
            $data['iOS']['url'] = $this->config['iosurl'];
        }
        
        if (!empty($appconfig['androidversion'])){
            $data['Android']['version'] = $appconfig['androidversion'];
            $data['Android']['title'] = $appconfig['apptitle'];
            $data['Android']['note'] = $appconfig['appcontent'];
            $data['Android']['url'] = $appconfig['androidurl'];
        }else{
            $data['Android']['version'] = $this->config['androidversion'];
            $data['Android']['title'] = $this->config['apptitle'];
            $data['Android']['note'] = $this->config['appcontent'];
            $data['Android']['url'] = $this->config['androidurl'];
        }
        
        echo json_encode($data);die;
    }
    private function reg($str){
        return preg_replace('/[^0-9]/','',$str);
    }
    //根据length的长度进行补0的操作，$length的值为两个版本号中最长的那个
    private function add($str,$length){
        return str_pad($str,$length,"0");
    }
    // 版本号比较
    private function versionCompare($v1,$v2){
        $length = strlen($this->reg($v1))>strlen($this->reg($v2)) ? strlen($this->reg($v1)): strlen($this->reg($v2));
        $v1 = $this->add($this->reg($v1),$length);
        $v2 = $this->add($this->reg($v2),$length);
        if($v1 == $v2) {
            return 0;
        }else{
            return $v1>$v2?1:-1;
        }
    }
}
?>