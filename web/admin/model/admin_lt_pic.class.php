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
class admin_lt_pic_controller extends adminCommon{
	function set_search()
    {
        $search_list[]  = array(
            'param'     => 'status',
            'name'      => '审核状态',
            'value'     => array(
                '0' => '已审核',
                '1' => '未审核'
            )
        );

        $this->yunset('search_list', $search_list);
    }
	/**
	 * 会员-猎头-图片管理
	 * 2019-06-03 hjy
	 */
	public function index_action(){
		$this			->	set_search();

		$ltWhereData						=	array();
		$ltWhereData['photo_big']				=	array('<>', '');

		$keywordStr							=	trim($_GET['keyword']);
		$typeStr							=	intval($_GET['type']);
		if(!empty($keywordStr)){
			if($typeStr == 2){
				$ltWhereData['uid']	=	array('=', $keywordStr);
			}elseif($typeStr == 3){
				$ltWhereData['realname']	=	array('like', $keywordStr);
			}else{
				$ltWhereData['com_name']	=	array('like', $keywordStr);
			}
		}

		if(isset($_GET['status'])){
	        
	        $status                		 	=   intval($_GET['status']);
	        
	        $ltWhereData['photo_status']  	=  $status;
	        
	        $urlarr['status']       		=  $status;
	    }

		$urlarr 								=	$_GET;
		$urlarr['page']							=	'{{page}}';
		$pageurl								=	Url($_GET['m'], $urlarr, 'admin');
		//提取分页
		$pageM									=	$this  -> MODEL('page');
		$pages									=	$pageM -> pageList('lt_info', $ltWhereData, $pageurl, $_GET['page']);
		//分页数大于0的情况下 执行列表查询
		$List									=	array();
		$ltM									=	$this -> MODEL('lietou');
		if($pages['total'] > 0){
			//limit order 只有在列表查询时才需要
		    $ltWhereData['orderby']				=	array('photo_status,desc','uid,desc');
			$ltWhereData['limit']				=	$pages['limit'];		
			$List								=	$ltM -> getList($ltWhereData);
		}


		$this -> yunset('rows', $List);
		$this -> yuntpl(array('admin/admin_lt_pic'));
	}
	/**
     * @desc 猎头LOGO审核说明
     */
    function getStatusBody_action()
    {
        $lietouM   =   $this -> MODEL('lietou');
        
        $lietou    =   $lietouM -> getInfo(intval($_GET['uid']), array('field' => 'photo_statusbody'));
        
        echo trim($lietou['photo_statusbody']);die();
        
    }
    /**
     * @desc 猎头LOGO审核
     */
    function status_action()
    {
        $lietouM   =   $this->MODEL('lietou');
        
        //$status     =   intval($_POST['status']);
        
        //$statusbody =   trim($_POST['statusbody']);
        
       // $allid      =   @explode(',', $_POST['sid']);

        //$list    =   $lietouM -> getList(array('uid'=>array('in',pylode(',', $allid))), array('field' => 'uid'));

        $post     				 =   	array(
            
            'photo_statusbody'   =>  	trim($_POST['statusbody']),
            
            'photo_status'       =>  	intval($_POST['status'])
            
		);
		
		$return   				=  		$lietouM -> statusLogo($_POST['sid'], array('post'=>$post));

		$this -> ACT_layer_msg($return['msg'], $return['errcode'], $_SERVER['HTTP_REFERER'],2,1);

    }
	/**
	 * 会员-猎头-图片管理
	 * 保存图片
	 * 2019-06-03 hjy
	 */
	public function uploadsave_action(){
		$_POST									=	$this -> post_trim($_POST);
		$id										=	intval($_POST['id']);
		$UploadM								=	$this -> MODEL('upload');

		if(empty($_POST['update']) || $_POST['type'] != 'photo'){
			$this->ACT_layer_msg('参数错误！', 8, $_SERVER['HTTP_REFERER']);
		}
		$ltM									=	$this -> MODEL('lietou');
		$whereData								=	array('uid' => array('=', $id));
		$upData									=	array();
		if($_FILES['file']['tmp_name']){
			$upArr    =  array(
				'file'  =>  $_FILES['file'],
				'dir'   =>  'lietou',
                'watermark' => 0
			);

			$uploadM  =  $this->MODEL('upload');

			$pic      =  $uploadM->newUpload($upArr);
			
			if (!empty($pic['msg'])){

				$this->ACT_layer_msg($pic['msg'],8);

			}elseif (!empty($pic['picurl'])){

				$pictures 	=  	$pic['picurl'];
			}

			$upData['photo_big']	=	$pictures;
			
		}else{
			$this -> ACT_layer_msg('请选择图片！', 8);
		}

		$nbid									=	$ltM -> upInfo($whereData, $upData);
		if(!empty($nbid)){
			$this -> ACT_layer_msg('猎头头像(ID:'.$id.')修改成功！', 9, $_SERVER['HTTP_REFERER'], 2, 1);
		}else{
			$this -> ACT_layer_msg('修改失败！', 8, $_SERVER['HTTP_REFERER']);
		}

	}
	/**
	 * 会员-猎头-图片管理
	 * 删除图片
	 * 2019-06-03 hjy
	 */
	public function del_action(){
		if(!empty($_GET['del'])){
			$this -> check_token();
			$layer_type							=	1;
			$id									=	pylode(',', $_GET['del']);
		}else if(!empty($_GET['delid'])){
			$this -> check_token();
			$layer_type							=	0;
			$id									=	$_GET['delid'];
		}
		if(empty($id)){
			$this -> layer_msg('请选择您要删除的图片！', 8, 1);
		}

		$ltM									=	$this -> MODEL('lietou');
		//修改相应图片字段
		$delid									=	$ltM -> upInfo(array('uid' => array('in', $id)), array('photo_big' => ''));
		if(!empty($delid)){
			$this -> layer_msg('猎头头像(ID:'.$id.')删除成功！', 9, $layer_type, $_SERVER['HTTP_REFERER']);
		}else{
			$this -> layer_msg('删除失败！', 8, $layer_type, $_SERVER['HTTP_REFERER']);
		}

	}
}
?>