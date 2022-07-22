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
class admin_once_controller extends adminCommon{
	function index_action(){  
		$OnceM			=	$this -> MODEL('once');
		$where			=	array();
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	"{{page}}";
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM			=	$this -> MODEL('page');
		$pages			=	$pageM -> pageList('once_job',$where,$pageurl,$_GET['page']);
		if($pages['total'] > 0){
			$where['orderby']	=	'id,desc';
			$where['limit']		=	$pages['limit'];
			$rows				=	$OnceM -> getOnceList($where);
		}
		$this->yunset("rows",$rows);
		$this->yunset("headertitle","店铺招聘");
		$this->yunset('backurl','index.php?c=company');
		$this->yuntpl(array('wapadmin/admin_once'));
	}
	function show_action(){
		$OnceM		=	$this -> MODEL('once');
		$row		=	$OnceM -> getOnceInfo(array('id'=>intval($_GET['id'])));
		$lasturl	=	$_SERVER['HTTP_REFERER'];
		if(strpos($lasturl, 'a=show')===false){
		    if(strpos($lasturl, 'c=admin_once')!==false){
		        $this->cookie->setcookie('lasturl',$lasturl,time()+300);
		        $_COOKIE['lasturl']	=	$lasturl;
		    }
		}
		$this->yunset('lasturl',$_COOKIE['lasturl']); 
		$this->yunset("row",$row);
		$this->yunset("headertitle","店铺招聘审核");
		$this->yunset('backurl','index.php?c=admin_once');
		$this->yuntpl(array('wapadmin/admin_once_show'));
	}
	function add_action(){
		$OnceM		=	$this -> MODEL('once');
		$CacheM		=	$this -> MODEL('cache');
		if(intval($_GET['id'])){
			$row	=	$OnceM -> getOnceInfo(array('id'=>intval($_GET['id'])));
			$this->yunset('row',$row);
			$this->yunset("headertitle","店铺招聘修改");
		}else{
			$this->yunset("headertitle","店铺招聘添加");
		}
		if($_POST['add']){
			$edate	=	strtotime("+".(int)$_POST['edate']." days");
			if($_FILES['pic']['tmp_name']){
				$upArr    =  array(
					'file'  	=>  $_FILES['pic'],
					'dir'   	=>  'once',	
				);
				$uploadM	=  $this -> MODEL('upload');
				$pic		=  $uploadM -> newUpload($upArr);
				if (!empty($pic['msg'])){
					$this->ACT_layer_msg($pic['msg'],8);
				}elseif (!empty($pic['picurl'])){
					$pictures	=	$pic['picurl'];
				}
			}
			if(isset($pictures)){
				$_POST['pic']	=	$pictures;
			}
			if($row['pic'] && $_POST['pic']==''){
				$_POST['pic']	=	$row['pic'];
			}
			$postData	=	array(
				'title'			=>	$_POST['title'],
				'companyname'	=>	$_POST['companyname'],
				'edate'			=>	$edate,
				'linkman'		=>	$_POST['linkman'],
				'phone'			=>	$_POST['phone'],
				'salary'		=>	$_POST['salary'],
				'provinceid' 	=>  $_POST['provinceid'],
				'cityid' 		=>  $_POST['cityid'],
				'three_cityid'	=>  $_POST['three_cityid'],
				'address'		=>	$_POST['address'],
				'require'		=>	$_POST['require'],
				'password'		=>	$_POST['password'],
				'status' 		=>  1,
				'pic'			=>	$_POST['pic'],
			);
			$data	=	array(
				'id'     =>	 intval($_POST['id']),
				'post'   =>	 $postData,
				'type'   =>  'admin'
			);
			$return	=	$OnceM -> addOnceInfo($data,'admin');
			if($return['errcode']==9){
				if($_POST['id']){
					$data['msg']	=	$return['msg'];
					$data['url']	=	'index.php?c=admin_once';
				}else{
					$data['msg']	=	$return['msg'];
					$data['url']	=	'index.php?c=admin_once';
				}
			}
			$this->yunset("layer",$data);
		}
	    $CacheList	=	$CacheM -> GetCache(array('city'));
        $this->yunset($CacheList);
	    if($_GET['id']){
	    	$this->yunset('backurl','index.php?c=admin_once&a=show&id='.$_GET['id']);
	    }else{
	    	$this->yunset('backurl','index.php?c=admin_once');
	    }			
	    $this->yuntpl(array('wapadmin/admin_once_add'));
	}
	function status_action(){
		$OnceM		=	$this -> MODEL('once');
		if(intval($_POST['id'])){
			$nid	=	$OnceM -> setOnceStatus(intval($_POST['id']),array('status'=>$_POST['status']));
			if($nid){
	            $this->layer_msg('店铺招聘审核(ID:'.$_POST['id'].')设置成功！',9,0,'index.php?c=admin_once');
	        }else{
	            $this->layer_msg('设置失败！',8);
	        }
		}
	}
	function del_action(){
		$OnceM		=	$this -> MODEL('once');
		$return		=	$OnceM -> delOnce(intval($_GET['id']));
		if($return['errcode']==9){
			$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],"index.php?c=admin_once");
		}else{
			$this->layer_msg($return['msg'],$return['errcode']);
		} 
	}
}
?>