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
class admin_trainset_controller extends adminCommon{
	/**
	 * 会员 - 培训 - 培训设置
	 * 培训设置
	 * 2019-06-06 hjy
	 */	 
	public function index_action(){
		$this -> yuntpl(array('admin/admin_train_config'));
	}

	/**
	 * 会员 - 培训 - 培训设置
	 * 保存培训设置
	 * 2019-06-06 hjy
	 */	
	public function config_action(){
		if(empty($_POST["config"])){
			$this -> ACT_layer_msg("参数错误！", 8, $_SERVER['HTTP_REFERER']);
		}

		unset($_POST["config"]);

		$configM					=	$this -> MODEL('config');
		$postData					=	$this -> post_trim($_POST);
		$configM -> setConfig($postData);

		$this -> web_config();
		$this -> ACT_layer_msg($this->config['integral_train']."配置修改成功！", 9, 1, 2, 1);
   }

   	/**
	 * 会员 - 培训 - 培训设置
	 * 头像设置 保存头像设置
	 * 2019-06-06 hjy
	 */	 
	public function logo_action(){
		if(!empty($_POST['submit'])){
			unset($_POST['submit']);
			
			$this -> web_config();
			$this -> ACT_layer_msg("会员头像配置设置成功！", 9, $_SERVER['HTTP_REFERER'], 2, 1);
		}
		$this -> yuntpl(array('admin/admin_pxlogo'));
	}

	/**
	 * 会员 - 培训 - 培训设置
	 * 积分设置
	 * 2019-06-06 hjy
	 */	 
	public function set_action(){
		$this -> yuntpl(array('admin/admin_integral_train'));		
	}
	/**
	 * 会员 - 培训 - 培训设置
	 * 保存积分设置
	 * 2019-06-06 hjy
	 */	
	public function save_action(){

		if(empty($_POST["config"])){
			$this -> ACT_layer_msg("参数错误！", 8, $_SERVER['HTTP_REFERER']);
		}

		unset($_POST["config"]);

		$configM					=	$this -> MODEL('config');
		$postData					=	$this -> post_trim($_POST);
		$configM -> setConfig($postData);

		$this -> web_config();
		$this -> ACT_layer_msg($this->config['integral_pricename']."配置修改成功！", 9, 1, 2, 1);

   }

}
?>