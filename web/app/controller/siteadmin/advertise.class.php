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
class advertise_controller extends siteadmin_controller{
	
	function index_action(){
 		$adM	=	$this->MODEL('ad');
		
		if($_GET['is_check']){
			if($_GET['is_check']=='1'){
				$where['is_check']	=	'1';
				$where['time_end']	=	array('unixtime','>',time());
				$urlarr['is_check']	=	$_GET['is_check'];
			}
			
			if($_GET['is_check']=='-1'){
				$where['is_check'] 	=	'0';
				$where['time_end']	=	array('unixtime','>',time());
				$urlarr['is_check']	=	$_GET['is_check'];
			}

			if($_GET['is_check']=='2'){
				$where['time_end']	=	array('unixtime','<=',time());
				$urlarr['end']		=	1;
			}

		}
 
 		if($_GET['class_id']){
			$where['class_id']		=	$_GET['class_id'];
			$urlarr['class_id']		=	$_GET['class_id'];
		}
		
		if($_GET['name']){
			$where['ad_name']		=	array('like',$_GET['name']);
			$urlarr['name']			=	$_GET['name'];
		}
		
		if($_GET['ad']){
			if($_GET['ad']=='1'){
				$where['ad_type']	=	'word';
			}
			if($_GET['ad']=='2'){
				$where['ad_type']	=	'pic';
			}
			if($_GET['ad']=='3'){
				$where['ad_type']	=	'flash';
			}
			$urlarr['ad']			=	$_GET['ad'];
		}
		
		//分页链接
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	$_GET['c']; 
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		
		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('ad',$where,$pageurl,$_GET['page']);
		
		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){
			
		    //limit order 只有在列表查询时才需要
		    $where['orderby']		=	'id,desc';
		    $where['limit']			=	$pages['limit'];
			//获取列表
			$List					=	$adM -> getAdList($where);
			$this->yunset('linkrows',$List['list']);
			$this->yunset('nclass',$List['nclass']);
			$this->yunset('class',$List['class']);
		}
		
		$ad_time		=	array('1'=>'一天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]	=	array('param'=>'ad','name'=>'广告类型','value'=>array('1'=>'文字广告','2'=>'图片广告','3'=>'FLASH广告'));
		$search_list[]	=	array('param'=>'is_check','name'=>'审核状态','value'=>array('-1'=>'未审核', '1'=>'已审核', '2'=>'已过期'));
		$this->yunset('search_list',$search_list);
        $this->yunset('ad_time',$ad_time);
		$this->yunset('get_type', $_GET);
	
		$this->siteadmin_tpl(array('admin_advertise'));
	}
	function ad_add_action() {
		$adM	=	$this->MODEL('ad');
		
		$class 	= 	$adM->getAdClassList();
		$this->yunset('class',$class['list']);

		if($_GET['id']){
		    $info	=	$adM->getInfo(array('id'=>$_GET['id']));
		    $this->yunset('info',$info);
		}
		$this->siteadmin_tpl(array('admin_advertise_add'));
	}
	function ad_saveadd_action(){
		$adM	=	$this->MODEL('ad');
		if($_FILES['flash_url']['size']>0 && $_POST['ad_type']=='flash'){
			$time 			= 	time();
			$flash_name 	= 	$time.rand(0,999).'.swf';
			move_uploaded_file($_FILES['flash_url']['tmp_name'],DATA_PATH.'/upload/flash/'.$flash_name);
			$pictures 		= 	'../data/upload/flash/'.$flash_name;
		}

		if ($_POST['ad_type']=='pic'){
			if($_POST['upload']=='upload'){
				$pictures 	=  	$_POST['pic_url'];
			}else{
				if($_FILES['file']['tmp_name']){
					$upArr    =  array(
						'file'  =>  $_FILES['file'],
						'dir'   =>  'pimg'
					);

					$uploadM  =  $this->MODEL('upload');

					$pic      =  $uploadM->newUpload($upArr);
					
					if (!empty($pic['msg'])){

						$this->ACT_layer_msg($pic['msg'],8);

					}elseif (!empty($pic['picurl'])){

						$pictures 	=  	$pic['picurl'];
					}
				}
			}
		}
		$_POST['target']	=	$_POST['target']==2?2:1;
		$_POST['is_check']	=	1;
		$_POST['did']		=	$this->config['did'];
		$return 			= 	$adM->model_saveadd($_POST,$pictures);

		$this->ACT_layer_msg($return['msg'],$return['errcode'],$return['url']);
		 
	}

	function modify_save_action(){
		$adM	=	$this->MODEL('ad');
		
		if($_FILES['flash_url']['size']>0 && $_POST['ad_type']=='flash'){
		    $time 			= 	time();
		    $flash_name	 	= 	$time.rand(0,999).'.swf';
		    move_uploaded_file($_FILES['flash_url']['tmp_name'],DATA_PATH.'/upload/flash/'.$flash_name);
		    $pictures 		= 	'../data/upload/flash/'.$flash_name;
		}
		if ($_POST['ad_type']=='pic'){
		    if($_FILES['file']['tmp_name']){
		    	$upArr    =  array(
			        'file'  =>  $_FILES['file'],
			        'dir'   =>  'pimg'
			    );
			    
			    $uploadM  =  $this->MODEL('upload');
			    
			    $pic      =  $uploadM->newUpload($upArr);
			    if (!empty($pic['msg'])){
			        
			        $this->ACT_layer_msg($pic['msg'],8);
			        
			    }elseif (!empty($pic['picurl'])){
			        
			        $pictures 	=  		$pic['picurl'];
			    }
		    }
		    
		}
		$_POST['target']	=	$_POST['target']==2?2:1;
		$_POST['did']		=	$this->config['did'];
		$return				=	$adM->model_saveadd($_POST,$pictures);
		
		$this->ACT_layer_msg($return['msg'],$return['errcode'],$return['url'],2,1);
		
	}
	function del_ad_action(){
		$adM	=	$this->MODEL('ad');
		$this->check_token();
		if($_GET['id']){
			$ad	=	$adM->getInfo(array('id'=>(int)$_GET['id']));
			if(is_array($ad)){
				
				$adM->delAd(array('id'=>$_GET['id']),array('type'=>'one'));
			}
		}
		$adM->model_ad_arr();
		$this->layer_msg('广告(ID:'.$_GET['id'].')删除成功！',9,0,$_SERVER['HTTP_REFERER']);
	}

	function ad_preview_action(){
		$adM	=	$this->MODEL('ad');
		
		$ad		=	$adM->getInfo(array('id'=>(int)$_GET['id']));
		if($ad['ad_type']=='word'){
			$ad['html']		=	'<a href="'.$ad['word_url'].'">'.$ad['word_info'].'</a>';
		}else if($ad['ad_type']=='pic'){
			$height = $width='';
			if($ad['pic_height']){
				$height 	=	'height="'.$ad['pic_height'].'"';
			}
			if($ad['pic_width']){
				$width 		=	'width="'.$ad['pic_width'].'"';
			}
			$ad['html']		=	'<a href="'.$ad['pic_src'].'" target="_blank" rel="nofollow"><img src="'.$ad['pic_url_n'].'"  '.$height.' '.$width.' ></a>';
		}else if($ad['ad_type']=='flash'){
			if(@!stripos('ttp://',$ad['flash_url'])){
				$flash_url	= 	str_replace('../',$this->config['sy_ossurl'].'/',$ad['flash_url']);
			}
			$ad['html']		=	'<object type="application/x-shockwave-flash" data="'.$flash_url.'" width="'.$ad['flash_width'].'" height="'.$ad['flash_height'].'"><param name="movie" value="'.$flash_url.'" /><param value="transparent" name="wmode"></object>';
		}else if($ad['ad_type']=='lianmeng'){
			
			$ad['html']		=	$ad['lianmeng_url'];
		}
		if(@strtotime($ad['time_end'].' 23:59:59')<time()){
			$ad['is_end']	=	'1';
		}
		$ad['src']			=	$this->config['sy_weburl'].'/data/plus/yunimg.php?classid='.$ad['class_id'].'&ad_id='.$ad['id'];
		$this->yunset('ad',$ad);
		$this->siteadmin_tpl(array('admin_ad_preview'));
	}
	function ajax_check_action(){
		$adM	=	$this->MODEL('ad');
		$adM	->	upInfo(array('id'=>(int)$_POST['id']),array('is_check'=>$_POST['val']));
		$adM	->	model_ad_arr();
		if($_POST['val']=='1'){
			echo '<font color="green">已审核</font>';
		}else{
			echo '<font color="red">未审核</font>';
		}

	}
	function cache_ad_action(){
		$adM					=	$this->MODEL('ad');
		$adM->model_ad_arr();
		$this->layer_msg('广告更新成功！',9,0,'index.php?m=advertise');
	}
	function ctime_action(){
		$adM					=	$this->MODEL('ad');
		$upData['time_end']		=	array('DATE_ADD',$_POST['endtime']);
		$upWhere['id']			=	array('in',$_POST['jobid']);
		$id						=	$adM->upInfo($upWhere,$upData);
		$adM->model_ad_arr();
		$id?$this->ACT_layer_msg('广告批量延期(ID:'.$_POST['jobid'].')设置成功！',9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg('设置失败！',8,$_SERVER['HTTP_REFERER']);
	}
    function del_action(){
		$adM	=	$this->MODEL('ad');
		if(is_array($_GET['del'])){
			$delid			=	pylode(',',$_GET['del']);
			$where['id']	=	array('in',$delid);
			$data['type']	=	'all';
			$layer_type		=	1;
		}else{
			$this->check_token();
			$delid			=	(int)$_GET['id'];
			$where['id']	=	$delid;
			$data['type']	=	'one';
			$layer_type		=	0;
		}
		if(!$delid){
			$this->layer_msg('请选择要删除的内容！',8);
		}
		
		$del	=	$adM->delAd($where,$data);
		$adM	->	model_ad_arr();
		$del?$this->layer_msg('广告(ID:'.$delid.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);
	}

}
?>