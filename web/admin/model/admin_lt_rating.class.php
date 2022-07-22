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
class admin_lt_rating_controller extends adminCommon{
	/**
	 * 会员-猎头-增值套餐服务
	 * 2019-06-03 hjy
	 */
	public function index_action(){

		//会员等级			
		$ratingM				=	$this -> MODEL('rating');
		$whereData				=	array();
		$whereData['category']	=	array('=', 2);
		//等级条件
		if(!empty($_GET['rating'])){
			$whereData['id']	=	array('id' => array('=', $_GET['rating']));
		}
		$whereData['orderby']	=	'sort,asc';
		$rating_list			=	$ratingM -> getList($whereData);

		$this -> yunset('list', $rating_list);
		$this -> yuntpl(array('admin/admin_lt_rating'));
	}
	/**
	 * 会员-猎头-增值套餐服务
	 * 编辑会员等级信息
	 * 2019-06-03 hjy
	 */
	public function rating_action(){
		$idStr					=	intval($_GET['id']);
		$row					=	array();
		if(!empty($idStr)){
			$ratingM			=	$this -> MODEL('rating');
			$row				=	$ratingM -> getInfo(array('id' => array('=', $idStr)));			
		}
		//获取优惠券信息
		$couponM				=	$this -> MODEL('coupon');
		$coupon					=	$couponM -> getList(array('id' => array('>', 0)));
		$this -> yunset('row', $row);
		$this -> yunset('coupon', $coupon);
		$this -> yuntpl(array('admin/admin_ltclass_add'));
	}

	/**
	 * 会员-猎头-增值套餐服务
	 * 编辑会员等级信息->保存数据
	 * 2019-06-03 hjy
	 */
	public function saveclass_action(){
	    
		$idStr					=	intval($_POST['id']);
		
		$ratingM				=	$this -> MODEL('rating');
		
		if($_FILES['file']['tmp_name']){
			$upArr    =  array(
				'file'  =>  $_FILES['file'],
				'dir'   =>  'compic'
			);

			$uploadM  =  $this->MODEL('upload');

			$pic      =  $uploadM->newUpload($upArr);
			
			if (!empty($pic['msg'])){

				$this->ACT_layer_msg($pic['msg'],8);

			}elseif (!empty($pic['picurl'])){

				$pictures 	=  	$pic['picurl'];
			}

		}

		if(isset($pictures)){

			$_POST['com_pic']	=	$pictures;

		}else{

			unset($_POST['com_pic']);

		}

		$postData				=	$_POST;
		
	    if(empty($idStr)){
	        
	        $res				=	$ratingM -> addRating($postData);
	        
	    }else{
	        
	        $res				=	$ratingM -> upRating($idStr, $postData);
	        
		}
		    
        $this -> ACT_layer_msg($res['msg'], $res['errcode'], 'index.php?m=admin_lt_rating', 2, 1);
		 
	}
	
	
	/**
	 * @desc   会员-猎头-增值套餐服务
	 * @desc   删除会员等级信息
	 * 2019-06-03 hjy
	 */
	public function delrating_action(){
		if(!empty($_POST['del'])){
			
		    $id					=	$_POST['del'];
		    
		}else if(!empty($_GET['id'])){
		    
			$this -> check_token();
			
			$id					=	$_GET['id'];
			
		}

		$ratingM				=	$this -> MODEL('rating');
		//删除等级数据
		$res					=	$ratingM -> delRating($id, array('category'=>'2'));
		    
        $this -> layer_msg($res['msg'], $res['errcode'], $res['layertype'], $_SERVER['HTTP_REFERER']);
	}
	
	/**
	 * @desc 会员-猎头-增值套餐服务 - 增值服务
	 * 2019-06-03 hjy
	 */
	public function server_action(){
		$ltM					=	$this -> MODEL('lietou');
		$list					=	$ltM -> getLtserviceList(array('id' => array('>', 0)));
		$this -> yunset('list', $list);
		$this -> yuntpl(array('admin/admin_ltrating'));
	}

	/**
	 * @desc 会员-猎头-增值套餐服务
	 * @desc 增值服务 -> 删除增值类型
	 * 2019-06-03 hjy
	 */
	function dels_action(){
	    
		if(!empty($_POST['del'])){
		
		    $id					=	pylode(',', $_POST['del']);
		    $layer_type			=	1;
		}else if(!empty($_GET['id'])){

		    $this -> check_token();

		    $id					=	$_GET['id'];
		    $layer_type			=	0;
		}
		
		$ltM					=	$this -> MODEL('lietou');
		$nid					=	$ltM -> delLtservice(array('id' => array('in', $id)));
		$ltM -> delLtservicedetail(array('type' => array('=', $id)));
		if(!empty($nid)){
			$this -> layer_msg('增值服务包删除(ID:'.$id.')成功！', 9, $layer_type, $_SERVER['HTTP_REFERER']);
		}else{
			$this -> layer_msg('删除失败！', 8, $layer_type, $_SERVER['HTTP_REFERER']);
		}
	}

	/**
	 * 会员-猎头-增值套餐服务
	 * 增值服务 -> 下架此服务
	 * 2019-06-03 hjy
	 */
	public function opera_action(){
		$dispStr				=	intval($_POST['display']);
		$idStr					=	intval($_POST['id']);
		if(empty($dispStr) || empty($idStr)){
			echo 2;die;
		}
		$ltM					=	$this -> MODEL('lietou');
		$nid					=	$ltM -> upLtservice(array('id' => array('=', $idStr)), array('display' => $dispStr));
		if($nid){
			echo 1;die;
		}else{
			echo 2;die;
		}
	}

	/**
	 * 会员-猎头-增值套餐服务
	 * 增值服务 -> 服务列表详情
	 * 2019-06-03 hjy
	 */
	public function list_action(){
		$ltM					=	$this -> MODEL('lietou');
		$zzlist					=	$ltM -> getLtserviceList(array('id' => array('>', 0)));
		$this->yunset('zzlist',$zzlist);
		$idStr					=	intval($_GET['id']);
		$row	=	$list		=	array();
		if(!empty($idStr)){
 			$row				=	$ltM -> getLtserviceInfo(array('id' => array('=', $idStr)));
			$list				=	$ltM -> getLtservicedetailList(array('type' => array('=', $idStr), 'orderby' => 'id,asc'));		
		}
		$this -> yunset('row', $row);
		$this->yunset('list',$list);
		$this -> yuntpl(array('admin/admin_ltservice_list'));
	}

	/**
	 * 会员-猎头-增值套餐服务
	 * 增值服务 -> 删除增值服务套餐
	 * 2019-06-03 hjy
	 */
	public function delt_action(){
		if(!empty($_POST['del'])){
			$layer_type			=	1;
			$id					=	pylode(',', $_POST['del']);
		}else if(!empty($_GET['id'])){
			$this -> check_token();
			$layer_type			=	0;
			$id					=	$_GET['id'];
		}
		$ltM					=	$this -> MODEL('lietou');
		$nid					=	$ltM -> delLtservicedetail(array('id' => array('in', $id)));
		if(!empty($nid)){
			$this -> layer_msg('套餐删除(ID:'.$id.')成功！', 9, $layer_type, $_SERVER['HTTP_REFERER']);
		}else{
			$this -> layer_msg('删除失败！', 8, $layer_type, $_SERVER['HTTP_REFERER']);
		}
	}

	/**
	 * 会员-猎头-增值套餐服务
	 * 增值服务 -> 设置增值类型
	 * 2019-06-03 hjy
	 */
	public function srating_action(){
		$this -> yuntpl(array('admin/admin_ltrating_add'));
	}

	/**
	 * 会员-猎头-增值套餐服务
	 * 增值服务 -> 保存设置的增值类型
	 * 2019-06-03 hjy
	 */
	public function save_action(){
		$nid					=	0;
		if(empty($_POST['useradd'])){
			$this -> ACT_layer_msg('数据错误！', 8, $_SERVER['HTTP_REFERER']);
		}
		unset($_POST['useradd']);
		$name					=	trim($_POST['name']);
		$ltM					=	$this -> MODEL('lietou');
		$row					=	$ltM -> getLtserviceList(array('name' => array('=', $name)));
		$postData				=	$_POST;
		if(!empty($row)){
			$this->ACT_layer_msg('增值包名称已存在！', 8, $_SERVER['HTTP_REFERER']);
		}else{
			$nid 				=	$ltM -> addLtservice($postData);
			$name				=	'猎头增值包（ID：'.$nid.'）添加';
		}
		if($nid){
			$this -> ACT_layer_msg($name.'成功！<br>请在增值包中添加套餐！', 9, 'index.php?m=admin_lt_rating&c=edit&id='.$nid, 2, 1);
		}else{
			$this -> ACT_layer_msg($name.'失败！', 8, $_SERVER['HTTP_REFERER']);
		}
	}

	/**
	 * 会员-猎头-增值套餐服务
	 * 增值服务 -> 设置增值包(新增)
	 * 2019-06-03 hjy
	 */
	public function edit_action(){
		$ltM					=	$this -> MODEL('lietou');
		$zzlist					=	$ltM -> getLtserviceList(array('id' => array('>', 0)));
		$this -> yunset('zzlist', $zzlist);
		$idStr					=	intval($_GET['id']);

		$row	=	$list		=	array();
		if(!empty($idStr)){
 			$row				=	$ltM -> getLtserviceInfo(array('id' => array('=', $idStr)));
			//$list				=	$ltM -> getLtservicedetailList(array('type' => array('=', $idStr), 'orderby' => 'id,asc'));		
		}
		$this -> yunset('row', $row);
		$this -> yunset('list', $list);
		$this -> yuntpl(array('admin/admin_ltservice_add'));
	}
	/**
	 * 会员-猎头-增值套餐服务
	 * 增值服务 -> 编辑增值包(编辑)
	 * 2019-06-03 hjy
	 */
	public function edittc_action(){
		$ltM					=	$this -> MODEL('lietou');
		$zzlist					=	$ltM -> getLtserviceList(array('id' => array('>', 0)));
		$this -> yunset('zzlist', $zzlist);
		$idStr					=	intval($_GET['id']);
		$tidStr					=	intval($_GET['tid']);
		$row	=	$list		=	array();
		if(!empty($idStr)){
 			$row				=	$ltM -> getLtserviceInfo(array('id' => array('=', $idStr)));
			//$list				=	$ltM -> getLtservicedetailList(array('type' => array('=', $idStr), 'orderby' => 'id,asc'));		
		}
		$listinfo				=	array();
		if(!empty($tidStr)){
			$listinfo			=	$ltM -> getLtservicedetailInfo(array('id' => array('=', $tidStr)));
		}
		$this -> yunset('row', $row);
		$this -> yunset('list', $list);
		$this -> yunset('listinfo', $listinfo);
		$this -> yuntpl(array('admin/admin_ltservice_add'));
 	}

	/**
	 * 会员-猎头-增值套餐服务
	 * 增值服务 -> 保存增值包数据
	 * 2019-06-03 hjy
	 */
	public function saves_action(){
		$ltM					=	$this -> MODEL('lietou');
		$id						=	$_POST['type'];
		if($_POST['useradd']){
 			unset($_POST['useradd']);
 			$nid				=	$ltM -> addLtservicedetail($_POST);
			$name				=	'套餐（ID：'.$nid.'）添加';
		}else if($_POST['userupdate']){
			$tid				=	$_POST['tid'];
			unset($_POST['userupdate']);
			unset($_POST['tid']);
			unset($_POST['id']);
			$nid				=	$ltM -> upLtservicedetail(array('id' => array('=', $tid)), $_POST);
			$name				=	'套餐（ID：'.$tid.'）更新';
		}
		if($nid){
			$this -> ACT_layer_msg($name.'成功！', 9, 'index.php?m=admin_lt_rating&c=list&id='.$id, 2, 1);
		}else{
			$this -> ACT_layer_msg($name.'失败！', 8, $_SERVER['HTTP_REFERER']);
		}
	}

}

?>