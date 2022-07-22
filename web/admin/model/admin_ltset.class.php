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
class admin_ltset_controller extends adminCommon{
	/**
	 * 会员-猎头- 猎头设置
	 * 猎头设置
	 * 2019-06-03 hjy
	 */
    public function index_action()
    {
        $ratingM        =   $this->MODEL('rating');
        $rating_list    =   $ratingM->getList(array('category' => 2, 'orderby' => 'sort, asc'));
        $this->yunset("lt_rows", $rating_list);

        $lt_single_can  =   @explode(',', $this->config['lt_single_can']);
        $this->yunset('lt_single_can', $lt_single_can);

        $lt_rating_add  =   @explode(',', $this->config['lt_rating_add']);
        $this->yunset('lt_rating_add', $lt_rating_add);

        $this->yuntpl(array('admin/admin_lt_config'));
    }
	/**
	 * 会员-猎头- 猎头设置
	 * 头像设置
	 * 2019-06-03 hjy
	 */
	public function logo_action(){
	    if(!empty($_POST['submit'])){
			

			$this -> web_config();
			$this -> ACT_layer_msg("会员头像配置设置成功！", 9, $_SERVER['HTTP_REFERER'],2,1);
		}
		$this -> yuntpl(array('admin/admin_ltlogo'));
	}
	/**
	 * 会员-猎头- 猎头设置
	 * 积分设置
	 * 2019-06-03 hjy
	 */
	public function set_action(){
		$this -> yuntpl(array('admin/admin_integral_lt'));		
	}
	 
	/**
	 * 会员-猎头- 猎头设置
	 * 保存设置
	 * 2019-06-03 hjy
	 */
	public function save_action(){
		if(empty($_POST["config"])){
			$this -> ACT_layer_msg("配置修改失败！", 8, $_SERVER['HTTP_REFERER']);
		}

		unset($_POST["config"]);

		$configM					=	$this -> MODEL('config');
		$postData					=	$this -> post_trim($_POST);

		if(isset($postData['lt_single_can'])){
			$postData['lt_single_can'] = $postData['lt_single_can'] ? @implode(',', $postData['lt_single_can']) : '';
		}else{
			$postData['lt_single_can'] = '';
		}

		$configM -> setConfig($postData);

		$this -> web_config();
		$this -> ACT_layer_msg("配置修改成功！", 9, 1, 2, 1);
	}

}
?>