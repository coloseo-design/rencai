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
class prepaid_model extends model{
	/**
	 * @desc 获取充值卡信息
	 * $whereData		查询条件
	 * $data			自定义处理数组
	 */
	public function getList($whereData, $data = array()){
		
		$data['field']	=	empty($data['field']) ? '*' : $data['field'];
		
		$List			=	$this -> select_all('prepaid_card', $whereData, $data['field']);
		
		return	$List;
	}
	/**
	 * @desc 获取单个充值卡信息
	 * $whereData		查询条件
	 * $data			自定义处理数组
	 */
	public function getInfo($whereData, $data = array()){
		
		$data['field']	=	empty($data['field']) ? '*' : $data['field'];
		
		$List			=	$this -> select_once('prepaid_card', $whereData, $data['field']);
		
		return	$List;
	}
	/**
	 * @desc 增加充值卡信息
	 * $whereData		查询条件
	 * $data			自定义处理数组
	 */
	public function addInfo($post = array()){
		if(!empty($post)){
			
			$num	=	intval($post['num']);
			
			for($i=0;$i<$num;$i++){
				
				$time		=	@explode(" ", microtime () );
				
				$time		=	$time[1].($time[0]*1000000);
				
				if(strlen($time)<16){
					
					$time	=	substr($time.'0000',0,16);
				}
				$card		=	substr($time.rand(100,999),0,16);
				
				$password	=	substr(base_convert($card,10,8),-5).rand(100,999);
				
				$data[$i]['card']		=	$card;
				
				$data[$i]['password']	=	$password;
				
				$data[$i]['quota']		=	trim($post['quota']);
				
				$data[$i]['stime']		=	strtotime($post['stime']);
				
				$data[$i]['etime']		=	strtotime($post['etime']); 
				
				$data[$i]['type']		=	trim($post['type']);
				
				$data[$i]['atime']		=	time();
				
			}
			if (!empty($data)){
				
				$this -> DB_insert_multi('prepaid_card',$data);
				
			}
		}
		
		$return['msg']		=	'充值卡添加成功！';
		
		$return['errcode']	=	9;
		
		return	$return;
	}
	/*
	 * 更新充值卡
	 * $whereData 	查询条件
	 * $addData 	更新数据 
	 
	 */
	function upInfo($postData=array(),$whereData=array(),$data=array()){
		
		$addData['type']=$postData['type'];
		
		if(empty($data['rec'])){
			
			$addData['stime']		=	strtotime($postData['stime']);
			
			$addData['etime']		=	strtotime($postData['etime']);
			
			$addData['password']	=	trim($postData['password']);
			
			$addData['quota']		=	trim($postData['quota']);
		}
		$return['id']	=	$this	->	update_once('prepaid_card',$addData,$whereData);
		
		if(empty($data['rec'])){
			
			$return['msg']		=	$return['id']?'充值卡(ID:'.intval($return['id']).')更新成功！':'充值卡更新失败！';
		
			$return['errcode']	=	$return['id']?9:8;
			
		}
		return	$return;
	}
	/**
	 * 删除充值卡
	 * $delId 	查询条件
	 */
	public function delInfo($delId){
		$return['layertype']	=	0;
		if($delId){
			if(is_array($delId)){
				$delId					=	pylode(',', $delId);
				
				$return['layertype']	=	1;
			}
			
			$return['id']				=	$this->delete_all('prepaid_card',array('id'=>array('in',$delId)),'');
			
			$return['msg']				=	'充值卡(ID:'.$delId.')';
			$return['errcode']			=	$return['id'] ? '9' :'8';
			$return['msg']				=	$return['id'] ? $return['msg'].'删除成功！' : $return['msg'].'删除失败！';
		}else{
			$return['msg']				=	'请选择要删除的内容';
			$return['errcode']			=	'8';
		}
		return $return;
	}
}
?>