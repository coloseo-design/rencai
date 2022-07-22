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
class link_controller extends adminCommon{ 
	function index_action(){
		if($_GET['state']=='1'){
			$where['link_state']	=	1;
			$urlarr['state']		=	1;
		}elseif($_GET['state']=='2'){
			$where['link_state']	=	0;
			$urlarr['state']		=	2;
		}
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	"{{page}}";
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('admin_link',$where,$pageurl,$_GET['page']);
		if($pages['total'] > 0){
			if($_GET['order']){
				$where['orderby']	=	$_GET['t'].','.$_GET['order'];
				$urlarr['order']	=	$_GET['order'];
				$urlarr['t']		=	$_GET['t'];
			}else{
				$where['orderby']	=	array('link_state,asc','link_time,desc');
			}
			$where['limit']			=	$pages['limit'];
			$linkM					=	$this  -> MODEL('link');
			$rows 					=	$linkM -> getList($where);
			$this -> yunset("linkrows",$rows);
		}
		$this->yunset('backurl',basename($_SERVER['HTTP_REFERER']));
		$this->yunset("headertitle","友情链接");
		$this->yuntpl(array('wapadmin/admin_link'));
	}

	function add_action(){ 
		if($_GET['id']){
			$linkM	=	$this  -> MODEL('link');
			$linkarr=	$linkM -> getInfo(array('id'=>$_GET['id']));
			$this->yunset("linkrow",$linkarr);
		}
		//分站
		$cacheM	=	$this -> MODEL('cache');
		$domain	=	$cacheM	-> GetCache('domain');
		$this->yunset('Dname', $domain['Dname']);
		$this->yunset("headertitle","友情链接");
		$this->yuntpl(array('wapadmin/admin_link_show'));
	}
	//删除链接
	function del_action(){
		if(is_array($_POST['del'])){
			$id	=	$_POST['del'];
		}else{
			$id	=	$_GET['id'];
		}
		$linkM	=	$this  -> MODEL('link');
		$return	=	$linkM -> delInfo($id);
		$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],"index.php?c=link");
	}
	//审核链接
	function status_action(){
		$id		=	$_POST['id'];
		$linkM	=	$this  -> MODEL('link');
		$return	=	$linkM -> setLinkStatus($id,array('status'=>$_POST['status']));
		$this->layer_msg($return['msg'],$return['errcode'],0,'index.php?c=link');
	}
	//保存信息
	function save_action(){
		$linkM			=	$this  -> MODEL('link');
		if($_POST['phototype']==1){
			if($_FILES['file']['tmp_name']){
		 		$upArr	=	array(
					'file'	=>	$_FILES['file'],
					'dir'	=>	'link'
				);
				$uploadM	=	$this->MODEL('upload');
				$pic		=	$uploadM->newUpload($upArr);
				if (!empty($pic['msg'])){
					$this->ACT_layer_msg($pic['msg'],8);
				}elseif (!empty($pic['picurl'])){
					$pictures	=	$pic['picurl'];
				}
		 	}
		}else{
			$pictures		=	$_POST['uplocadpic'];
		}
		$post	=	array(
			'did'			=>	$_POST['did'],
			'link_name'		=>	trim($_POST['title']),
			'link_url'		=>	$_POST['url'],
			'link_type'		=>	$_POST['type'],
			'tem_type'		=>	$_POST['tem_type'],
			'img_type'		=>	$_POST['phototype'],
			'link_sorting'	=>	$_POST['sorting'],
			'link_state'	=>	1,
		);
		if(isset($pictures)){
			$post['pic']	=	$pictures;
		}
		$data	=	array(
			'post'	=>	$post,
			'id'	=>	$_POST['id'],
			'utype'	=>	'admin'
		);
		$return	=	$linkM -> addInfo($data);
		$this->ACT_layer_msg($return['msg'],$return['errcode'],"index.php?m=link");

	}

	function checksitedid_action(){
		$linkM	=	$this  -> MODEL('link');
		$data	=	array(
			'uid'=>$_POST['uid'],
			'did'=>$_POST['did']
		);
		$return	=	$linkM -> setLinkSite($data);
		$this->ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER']);
	}
}

?>