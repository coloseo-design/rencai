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
class   admin_comset_controller extends adminCommon{

    function index_action()
    {

        $ratingM    =   $this->MODEL('rating');

        $qy_rows    =   $ratingM->getList(array('category' => 1, 'orderby' => array('sort,desc')));
        $this->yunset("qy_rows", $qy_rows);
        $this->yunset("com_link_no", @explode(',', $this->config['com_link_no']));

        $this->yuntpl(array('admin/admin_com_config'));
    }

	function save_action(){
    	
        $configM    =   $this->   MODEL("config");
    
 		if($_POST["config"]){
      		
            unset($_POST["config"]);
			unset($_POST['pytoken']);
			
			if($_FILES['exa_cert_wt_files']){

				$upArr  =  array(
				    'file'  =>  $_FILES['exa_cert_wt_files'],
				    'dir'   =>  'comdoc'
				);
				
				$uploadM  =  $this->MODEL('upload');
				
				$result   =  $uploadM -> uploadDoc($upArr);
				
				if ($result['msg']){
				    
				    $this->ACT_layer_msg($result['msg'],8);
				    
				}else{

				    $_POST['exa_cert_wt']   =   $result['docurl'];
				}
			}

            if (isset($_POST['sy_only_price'])) {
                $_POST['sy_only_price']     =   $_POST['sy_only_price'] ? @implode(',', $_POST['sy_only_price']) : '';
            }

            if(isset($_POST['com_single_can'])){
	            $_POST['com_single_can']    =   $_POST['com_single_can'] ? @implode(',', $_POST['com_single_can']) : '';
	        }

			$configM -> setConfig($_POST);
       
            $this->web_config();
      
            $this->ACT_layer_msg("配置修改成功！",9,1,2,1);
		}
	}
	function savereward_action(){
    
        $configM    =   $this->   MODEL("config");
    
	    unset($_POST["config"]);
	    
	    $configM -> setConfig($_POST);
	    
	    $this->web_config();
      
	    $this->ACT_layer_msg("配置修改成功！",9,$_SERVER['HTTP_REFERER'],2,1);
      
	}
	function logo_action(){
    
		if($_POST['submit']){
      
			$this->web_config();
      
			$this->ACT_layer_msg("会员头像配置设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
		}
		$this->yuntpl(array('admin/admin_comlogo'));
	}
	function set_action(){
		
		$this->yuntpl(array('admin/admin_integral_com'));
	}
	function rating_action(){
    
        $rating     =   $this->MODEL('rating');
        $qy_rows    =   $rating -> getList(array('category' => 1, 'orderby' => array('sort,desc')));
		$this->yunset("qy_rows",$qy_rows);

        $sy_only_price  =   @explode(',',$this->config['sy_only_price']);
        $this->yunset('sy_only_price',$sy_only_price);


		$com_single_can = @explode(',',$this->config['com_single_can']);
		$this->yunset('com_single_can',$com_single_can);

        $this->yunset("com_look",@explode(',',$this->config['com_look']));
        $this->yunset("rating_add",@explode(',',$this->config['rating_add']));
		$this->yuntpl(array('admin/admin_rating_config'));
	}	
	
	function reward_action(){
    
		$this->yuntpl(array('admin/admin_com_reward'));
    
	}
	
	function comspend_action(){
	    
		$configM 	=	$this -> MODEL('config');
		
		$row		=	$configM -> getInfo(array('name'=>'integral_down_resume_dayprice'));
		
		$marr		=	explode(':',$row['config']);
		
		foreach($marr as $v){
			
			$narr	=	explode('_',$v);
			
			$data[]	=	array('days'=>$narr[0],'price'=>$narr[1]);
		}
		

		$this->yunset('data',$data);

		$this->yuntpl(array('admin/admin_integral_comspend'));
    
	}
	function saveComspend_action(){
	    
	    $configM    =   $this->MODEL("config");
	    
	    if($_POST["config"]){
	        
	        unset($_POST["config"]);
	        unset($_POST['pytoken']);
	        
	        $configM -> setConfig($_POST);
	        
	        $this->web_config();
	        
	        $this->ACT_layer_msg("配置修改成功！",9,1,2,1);
	    }
	}

}
?>