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
class admin_gqset_controller extends adminCommon{
    /**
     * 会员-供求-供求设置:供求设置
     */
	function index_action(){
    
    
    
		$this -> yuntpl(array('admin/admin_gq_config'));
	
	}
	  
	function save_action(){
    
		if($_POST['config']){

		    $post 					    =  		array(

				'gq_number'             => 	 	$_POST['gq_number'],//供求每天发布多少需求
				
				'gq_task_link'          =>  	$_POST['gq_task_link'],//联系方式是否公开（发布任务）

				'gq_info_link'          =>  	$_POST['gq_info_link'],//供求入住客户

				'gq_fast_status'        =>  	$_POST['gq_fast_status'],//供求用户审核

				'gq_task_status'        =>  	$_POST['gq_task_status'],//供求发布任务户审核

				'gq_pay_price'          =>  	$_POST['gq_pay_price'],//发布任务多少钱
				
				'gq_photo_status'       =>  	$_POST['gq_photo_status'],//上传头像审核

				'gq_refrsh_pay'     	=>  	$_POST['gq_refrsh_pay'],//刷新金额
		     
			);
			
		    $configM  =  $this -> MODEL('config');
		    
		    $configM -> setConfig($post);
		    
		    $this -> web_config();
		    
		 	$this -> ACT_layer_msg('操作成功！',9,1,2,1);
		  
		}

	}
	
}
?>