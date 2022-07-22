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
class admin_px_pic_controller extends siteadmin_controller{
	function set_search()
    {
        $search_list[]  = array(
            "param"     => "status",
            "name"      => '审核状态',
            "value"     => array(
                '0' => '已审核',
                '1' => '未审核'
            )
        );

        $this->yunset("search_list", $search_list);
    }
	/**
	 * 会员 - 培训 - 图片管理
	 * 培训logo
	 * 2019-06-05 hjy
	 */
	public function index_action(){
		$this -> set_search();
		$pxWhereData			=	array();
		$pxWhereData['logo']	=	array('<>', '');

		$keywordStr				=	trim($_GET['keyword']);
		$typeStr				=	trim($_GET['type']);

		//机构名称条件
		if(!empty($keywordStr) && $typeStr == 1){
			$pxWhereData['name']	=	array('like', $keywordStr);
		}

		//uid条件
		if(!empty($keywordStr) && $typeStr == 2){
			$pxWhereData['uid']		=	array('like', $keywordStr);
		}

		if(isset($_GET['status'])){
	        
	        $status                	 		=   intval($_GET['status']);
	        
	        $pxWhereData['logo_status']  	=  	$status;
	        
	        $urlarr['status']       		=  	$status;
	    }

		$urlarr['page']		=	"{{page}}";
		$pageurl			=	Url($_GET['m'], $urlarr, 'admin');
		//提取分页
		$pageM				=	$this  -> MODEL('page');
		$pxM				=	$this  -> MODEL('train');
		$pages				=	$pageM -> pageList('px_train', $pxWhereData, $pageurl, $_GET['page'], 15);

		//分页数大于0的情况下 执行列表查询
		$List				=	array();
		if($pages['total'] > 0){
			$pxWhereData['orderby']		=	'uid';

			$pxWhereData['limit']		=	$pages['limit'];		
			$List						=	$pxM -> getList($pxWhereData);
		}

		$this -> yunset('rows', $List);
		$this -> siteadmin_tpl(array('admin_px_pic'));
	}
	/**
	 * 会员 - 培训 - 图片管理
	 * 机构环境
	 * 2019-06-05 hjy
	 */
	public function show_action(){
		$this -> set_search();
		$pxswWhereData	=	array();

		$keywordStr		=	trim($_GET['keyword']);
		$typeStr		=	trim($_GET['type']);

		//机构名称条件
		if(!empty($keywordStr) && $typeStr == 3){
			$pxswWhereData['title']		=	array('like', $keywordStr);
		}

		//uid条件
		if(!empty($keywordStr) && $typeStr == 2){
			$pxswWhereData['uid']		=	array('like', $keywordStr);
		}
		$pxM			=	$this -> MODEL('train');
		$comids			=	array();
		if(!empty($keywordStr) && $typeStr == 1){
			$px							=	$pxM -> getList(array('name' => array('like', $keywordStr)), array('field' => '`uid`'));
			if(!empty($px)){
				foreach($px as $val){
					$comids[] 			=	$val['uid'];
				}				
			}else{
				$comids					=	array(0);
			}
		}
		if(!empty($comids)){
			$pxswWhereData['uid']		=	array('in', pylode(',', $comids));
		}

		if(isset($_GET['status'])){
	        
	        $status                 	=   intval($_GET['status']);
	        
	        $pxswWhereData['status']  	=  	$status;
	        
	        $urlarr['status']       	=  	$status;
	    }

		$urlarr['c']	    =	$_GET['c'];
		$urlarr['page']		=	"{{page}}";
		$pageurl			=	Url($_GET['m'], $urlarr, 'admin');
		//提取分页
		$pageM				=	$this  -> MODEL('page');
		$pxM				=	$this  -> MODEL('train');
		$pages				=	$pageM -> pageList('px_train_show', $pxswWhereData, $pageurl, $_GET['page'], 15);

		//分页数大于0的情况下 执行列表查询
		$List							=	array();
		if($pages['total'] > 0){
			$pxswWhereData['orderby']	=	'id';

			$pxswWhereData['limit']		=	$pages['limit'];		
			$List						=	$pxM -> getPxshowList($pxswWhereData);
		}

		if(!empty($List)){
			foreach ($List as $v){
				$uids[]		=	$v['uid'];
			}
			$bcWhereData	=	array('uid' => array('in', pylode(',', $uids)));
			//补充机构相关的信息
			$pxField		=	'`uid`, `name`';
			$pxList			=	$pxM -> getList($bcWhereData, array('field' => $pxField));
			$pxListIndex	=	array();
			if(!empty($pxList)){
				foreach ($pxList as $pxV) {
					$pxListIndex[$pxV['uid']]	=	$pxV;
				}
			}
			foreach($List as $key => $value){
				
				$List[$key]['title']		=	mb_substr($value['title'], 0, 15);
				if(isset($pxListIndex[$value['uid']])){
					$List[$key]['name']		=	$pxListIndex[$value['uid']]['name'];
				}
			}
		}

		$this -> yunset('rows', $List);
		$this -> siteadmin_tpl(array('admin_px_picshow'));
	}
	/**
     * @desc 培训LOGO审核
     */
    function status_action(){
		$trainM  	=  	$this->MODEL('train');
		
		$post      	=   array(

			'logo_statusbody'   =>  trim($_POST['statusbody']),
            
            'logo_status'       =>  intval($_POST['status'])
		);

		$return   	=  	$trainM -> statusLogo($_POST['sid'], array('post'=>$post));
		
		$this -> ACT_layer_msg($return['msg'], $return['errcode'], $_SERVER['HTTP_REFERER'],2,1);

    }
    
    /**
     * @desc 培训LOGO审核说明
     */
    function getStatusBody_action()
    {
        $trainM   =   $this -> MODEL('train');
        
        $train    =   $trainM -> getInfo(array('uid'=>intval($_GET['uid'])), array('field' => 'logo_statusbody'));
        
        echo trim($train['logo_statusbody']);die();
        
    }
    /**
     * @desc 培训机构环境审核说明
     */
    function getShowStatusBody_action()
    {
        $trainM    =   $this -> MODEL('train');
        
        $pxshow    =   $trainM -> getPxshowInfo(array('id'=>intval($_GET['sid'])), array('field' => 'statusbody'));
        
        echo trim($pxshow['statusbody']);die();
        
    }
    /**
     * @desc 培训机构环境审核
     */
    function showStatus_action(){
		
        $trainM    =    $this->MODEL('train');

        $post      =    array(

			'status'        =>  intval($_POST['status']),
			
			'statusbody'    =>  trim($_POST['statusbody'])
			
        );

		$return    =    $trainM -> statusShow($_POST['sid'],array('post'=>$post));
	    
	    $this -> ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);
       
    }
    /**
     * @desc 培训机构环境审核说明
     */
    function getBannerStatusBody_action()
    {
        $trainM		=    $this -> MODEL('train');
        
        $pxbanner	=    $trainM -> getBannerInfo(array('id'=>intval($_GET['sid'])), array('field' => 'statusbody'));
        
        echo trim($pxbanner['statusbody']);die();
        
    }
    /**
     * @desc 企业环境审核
     */
    function bannerStatus_action(){
        $trainM   	=   $this->MODEL('train');
        
        $status     =   intval($_POST['status']);
        
		$statusbody =   trim($_POST['statusbody']);
		
		$post       =  	array(

			'status'        =>  $status,
			
			'statusbody'    =>  $statusbody
			
        );
		
		$return		=	$trainM->statusBanner($_POST['sid'],array('post'=>$post));

		$this -> ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);

    }
	/**
	 * 会员 - 培训 - 图片管理
	 * 机构横幅
	 * 2019-06-05 hjy
	 */
	public function banner_action(){
		$this -> set_search();
		$pxbaWhereData	=	array();

		$keywordStr		=	trim($_GET['keyword']);
		$typeStr		=	trim($_GET['type']);

		//uid条件
		if(!empty($keywordStr) && $typeStr == 2){
			$pxbaWhereData['uid']	=	array('like', $keywordStr);
		}
		$pxM			=	$this -> MODEL('train');
		$comids			=	array();
		if(!empty($keywordStr) && $typeStr == 1){
			$px			=	$pxM -> getList(array('name' => array('like', $keywordStr)), array('field' => '`uid`'));
			if(!empty($px)){
				foreach($px as $val){
					$comids[] 			=	$val['uid'];
				}				
			}else{
				$comids					=	array(0);
			}
		}
		if(!empty($comids)){
			$pxbaWhereData['uid']		=	array('in', pylode(',', $comids));
		}
		if(isset($_GET['status'])){
	        
	        $status                     =   intval($_GET['status']);
	        
	        $pxbaWhereData['status']  	=  	$status;
	        
	        $urlarr['status']       	=  	$status;
	    }

		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	"{{page}}";
		$pageurl		=	Url($_GET['m'], $urlarr, 'admin');
		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pxM			=	$this  -> MODEL('train');
		$pages			=	$pageM -> pageList('px_banner', $pxbaWhereData, $pageurl, $_GET['page'], 15);

		//分页数大于0的情况下 执行列表查询
		$List			=	array();
		if($pages['total'] > 0){
			$pxbaWhereData['orderby']	=	'id';

			$pxbaWhereData['limit']		=	$pages['limit'];		
			$List						=	$pxM -> getBannerList($pxbaWhereData);
		}

		if(!empty($List)){
			foreach ($List as $v){
				$uids[]	=	$v['uid'];
			}
			$bcWhereData				=	array('uid' => array('in', pylode(',', $uids)));
			//补充机构相关的信息
			$pxField					=	'`uid`, `name`';
			$pxList						=	$pxM -> getList($bcWhereData, array('field' => $pxField));
			$pxListIndex				=	array();
			if(!empty($pxList)){
				foreach ($pxList as $pxV) {
					$pxListIndex[$pxV['uid']]	=	$pxV;
				}
			}
			foreach($List as $key => $value){
				
				if(isset($pxListIndex[$value['uid']])){
					$List[$key]['name']			=	$pxListIndex[$value['uid']]['name'];
				}
			}
		}

		$this -> yunset('rows', $List);
		$this -> siteadmin_tpl(array('admin_px_picbanner'));
	}
	/**
	 * 会员 - 培训 - 图片管理
	 * 保存图片
	 * 2019-06-05 hjy
	 */
	public function uploadsave_action(){
		$_POST	=	$this->post_trim($_POST);
		$id		=	intval($_POST['id']);
		if(empty($_POST['update'])){
			$this -> ACT_layer_msg('参数错误！', 8, $_SERVER['HTTP_REFERER']);
		}

		$pxM		=	$this -> MODEL('train');
		$resType	=	'';
		$nbid		=	0;
		if($_POST['type'] == 'logo'){
			$row	=	$pxM -> getInfo(array('uid' => array('=', $id)), array('field' => '`logo`'));
			if(empty($row)){
				$this -> ACT_layer_msg('数据错误！', 8, $_SERVER['HTTP_REFERER']);
			}
			$data	=	array();

			$uploadRes			=	$this -> uploadImg($_FILES, 'train');
			if($uploadRes['errorcode'] == 9 && !empty($uploadRes['img'])){
				$data['logo']	=	$uploadRes['img'];
			}else{
				$this -> ACT_layer_msg('上传图片错误！', 8, $_SERVER['HTTP_REFERER']);
			}

			$nbid		=	$pxM -> upInfo(array('uid' => array('=', $id)), $data);
			$resType	=	'培训logo';
		}

		if($_POST['type'] == 'show'){
			$row		=	$pxM -> getPxshowInfo(array('id' => array('=', $id)), array('field' => '`picurl`'));
			if(empty($row)){
				$this -> ACT_layer_msg('数据错误！', 8, $_SERVER['HTTP_REFERER']);
			}
			$data		=	array();
			$uploadRes	=	$this -> uploadImg($_FILES, 'show');
			if($uploadRes['errorcode'] == 9 && !empty($uploadRes['img'])){
				$data['picurl']	=	$uploadRes['img'];
			}else{
				$this -> ACT_layer_msg('上传图片错误！', 8, $_SERVER['HTTP_REFERER']);
			}
			$data['title']		=	$_POST['title'];
			$data['ctime']		=	time();
			$nbid				=	$pxM -> upPxshowInfo(array('id' => array('=', $id)), $data);
			$resType			=	'机构环境';
		}

		if($_POST['type'] == 'banner'){

			$row				=	$pxM -> getBannerInfo(array('id' => array('=', $id)), array('field' => '`pic`'));
			if(empty($row)){
				$this -> ACT_layer_msg('数据错误！', 8, $_SERVER['HTTP_REFERER']);
			}
			$data				=	array();
			$uploadRes			=	$this -> uploadImg($_FILES,'train');
			if($uploadRes['errorcode'] == 9 && !empty($uploadRes['img'])){
				$data['pic']	=	$uploadRes['img'];
			}else{
				$this -> ACT_layer_msg('上传图片错误！', 8, $_SERVER['HTTP_REFERER']);
			}
			$nbid				=	$pxM -> upBannerInfo(array('id' => array('=', $id)), $data);
			$resType			=	'机构横幅';
		}

		if(!empty($resType) && !empty($nbid)){
			$this -> ACT_layer_msg($resType.'(ID:'.$id.')修改成功！', 9, $_SERVER['HTTP_REFERER'], 2, 1);
		}else{
			$this -> ACT_layer_msg('修改失败！', 8, $_SERVER['HTTP_REFERER']);
		}

	}

	/**
	 * 上传图片
	 */
	private function uploadImg($filesData,$typeS){
		$return		=	array(
			'errorcode'	=>	8,
			'msg'		=>	'',
			'img'		=>	''
		);
		if($filesData['file']['tmp_name']){

			$upArr  =   array(
				'file'  =>  $filesData['file'],
				'dir'   =>  $typeS
			);

			$uploadM  =  $this->MODEL('upload');

			$picr     =  $uploadM->newUpload($upArr);
			
			if (!empty($picr['msg'])){

				$return['msg']	=	$picr['msg'];
				return $return;

			}elseif (!empty($picr['picurl'])){

				$return['errorcode']	=	9;

				$return['img'] 	 	 	=  	$picr['picurl'];
			}

		}
		return $return;
	}
	/**
	 * 会员 - 培训 - 图片管理
	 * 删除图片
	 * 2019-06-06 hjy
	 */
	public function del_action(){
		$del	=	$_GET['del'];
		$this -> check_token();
		if(is_array($del)){
			$linkid			=	pylode(',', $del);
			$layer_type		=	1;
		}else{			
			$linkid			=	$_GET['delid'];
			$layer_type		=	0;
		}
		if(empty($linkid)){
			$this -> layer_msg('请选择您要删除的图片！', 8, 1, $_SERVER['HTTP_REFERER']);
		}
		$typeStr		=	trim($_GET['type']);
		$resType		=	'';
		$delid			=	0;
		$pxM			=	$this -> MODEL('train');
		if($typeStr == 'logo'){
			$resType	=	'培训LOGO';
			
			$delid		=	$pxM -> upInfo(array('uid' => array('in', $linkid)), array('logo' => ''));
		}

		if($typeStr == 'show'){
			$resType	=	'机构环境';
			
			$delid		=	$pxM -> upPxshowInfo(array('uid' => array('in', $linkid)), array('picurl' => ''));
		}

		if($typeStr == 'banner'){
			$resType	=	'机构横幅';
			
			$delid		=	$pxM -> upBannerInfo(array('uid' => array('in', $linkid)), array('pic' => ''));
		}

		if(!empty($resType) && !empty($delid)){
			$this -> layer_msg($resType.'(ID:'.$linkid.')删除成功！', 9, $layer_type, $_SERVER['HTTP_REFERER']);
		}else{
			$this -> layer_msg('删除失败！', 8, $layer_type, $_SERVER['HTTP_REFERER']);
		}
	}
}
?>