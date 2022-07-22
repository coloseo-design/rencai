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
class crm_set_controller extends adminCommon
{

    function index_action()
    {
    	$crmM		=	$this->MODEL('crm');
    	
    	$list		=	$crmM -> getCrmsetList();
    	
    	if (!empty($list)){
    		$ratingId	=	'';
    		foreach ($list as $v) {
    			if ($ratingId == ''){
    				$ratingId	=	$v['rating'];
    			}else{
    				$ratingId	.=	",".$v['rating'];
    			}	
    		}
    	}
    	
    	$ratingIdArr=	@explode(',', $ratingId);
    	
    	$ratingM	=	$this -> MODEL('rating');
		
		$ratinglist	=	$ratingM -> getList(array('category' => '1'), array('field'=>'`id`,`name`'));
		
		$ratingArr	=	array();
		foreach ($ratinglist as $rv) {
			$ratingArr[]	=	$rv['id'];
		}
		$diff	=	array_diff($ratingArr, $ratingIdArr);
		if (!empty($diff)){
			$this->yunset('add', '1');
		}
		
		$this->yunset('list', $list);
		
		if ($_GET['type'] == 'lz'){
			$this->yunset('lz', '1');
		}
    	
        $this->yuntpl(array('admin/crm_set_list'));
    }
    
    function add_action(){
    	
    	$crmM	=	$this->MODEL('crm');
    	
    	if($_GET['id']){
			
			$Info	=	$crmM -> getCrmsetInfo(array('id' => $_GET['id']));
			
			$ratingIdInfo	=	@explode(',', $Info['rating']);
			
			$Info['ratingId']	=	$ratingIdInfo;	
			
			$this->yunset('info', $Info);
		}
    	
    	$list	=	$crmM -> getCrmsetList(array(), array('field' => '`rating`'));
    	if (!empty($list)){
    		$ratingId	=	'';
    		foreach ($list as $v) {
    			if ($ratingId == ''){
    				$ratingId	=	$v['rating'];
    			}else{
    				$ratingId	.=	",".$v['rating'];
    			}	
    		}
    	}
    	
    	$ratingIdArr=	@explode(',', $ratingId);
    	
    	if(!empty($ratingIdInfo)){
    		
			$ratingIdArr	=	array_diff($ratingIdArr, $ratingIdInfo);    		
    	}
     	
    	if (in_array('999', $ratingIdArr)){
    		
    		$this->yunset('novip', '1');
    	}
    	
		$ratingM	=	$this -> MODEL('rating');
		
		if (!empty($ratingIdArr)){
			
			$rWhere	=	array('id' => array('notin', pylode(',', $ratingIdArr)), 'category' => '1');
		}else{
			
			$rWhere	=	array('category' => '1');
		}
		
		$ratinglist	=	$ratingM -> getList($rWhere, array('field'=>'`id`,`name`'));
		
		$this -> yunset('ratinglist', $ratinglist);
    	
		$this->yuntpl(array('admin/crm_set'));
    }
    
    function save_action(){
    	
    	if($_POST){
    		
    		$crmM 	=	$this->MODEL('crm');
    		
    		$value	=	array(
    		
    			'rating'		=>	pylode(',', $_POST['rating']),
    			'follow_day'	=>	intval($_POST['follow_day']),
    			'release_day'	=>	intval($_POST['release_day']),
    			'deal_day'		=>	intval($_POST['deal_day']),
    			'claim_day'		=>	intval($_POST['claim_day'])
    		);
    		
    		if($_POST['id']){
    			
    			$data['id']	=	intval($_POST['id']);
    		}
    		
    		$data['value']	=	$value;
    		
    		$return	=	$crmM -> addCrmset($data);
    		
    		$this->ACT_layer_msg($return['msg'],$return['errcode'],"index.php?m=crm_set");
    	}
    }
    
    function delSet_action(){
    	
    	$this->check_token();
    	
    	if($_GET["id"]){
			
			$crmM	=	$this->MODEL('crm');
			
			$return	=	$crmM->delCrmset($_GET["id"]);
			
			$this->layer_msg($return['msg'],$return['errcode'],0,"index.php?m=crm_set");
		}
    }
    
    function config_action(){
    	if($_POST['config']){
            
            unset($_POST['config']);
            
            $configM  =  $this->MODEL('config');
            
            $configM -> setConfig($_POST);
            
            $this->web_config();
            
            $this->ACT_layer_msg('CRM设置修改成功！',9,1,2,1);
        }
    }
}

?>