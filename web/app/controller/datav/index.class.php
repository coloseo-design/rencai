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
class index_controller extends common{
	function index_action(){
     	
          if ($_GET['token'] && $this->config['sy_datav_token'] && $_GET['token'] == $this->config['sy_datav_token']){
               
               $sy_datav_diydata = json_decode($this->config['sy_datav_diydata'],true); 

               if($sy_datav_diydata['datavtitle']){
                    $title = $sy_datav_diydata['datavtitle'];
               }else{
                    $title = $this->config['sy_webname'].'大数据平台';
               }

               $this->yunset('token',$_GET['token']);
               $this->yunset('datavtitle',$title);
               $this->yun_tpl(array('index'));
          }else{
               header("location:".$this->config['sy_weburl']);
          }

     	
	}

}
?>
