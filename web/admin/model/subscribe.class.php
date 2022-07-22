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
class subscribe_controller extends adminCommon{
	function set_search(){

		$search_list[]			=		array("param"=>"type","name"=>'订阅类型',"value"=>array("1"=>"订阅职位","2"=>"订阅简历"));
		
		$search_list[]			=		array("param"=>"state","name"=>'状态',"value"=>array("1"=>"已认证","2"=>"未认证"));

		$search_list[]			=		array("param"=>"end","name"=>'订阅时间',"value"=>array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月'));
		
		$this->yunset("search_list",$search_list);

	}
	function index_action(){

		$this->set_search();

		$SubscribeM							=			$this->MODEL('subscribe');

		if($_GET['end']){
			if($_GET['end']=='1'){

				$where['ctime']	  			=  			array('>=',strtotime('today'));
			
			}else{

				$where['ctime']	  			=  			array('>',strtotime('-'.intval($_GET['end']).' day'));

			}
			
			$urlarr['end']=$_GET['end'];
		}

		if($_GET['type']){ 

			$type							=			intval($_GET['type']);

			$where['type']					=			$type;			
 
			$urlarr['type']					=			$type;
		}
		if($_GET['state']){

			$state							=			intval($_GET['state']);

			$where['status']				=			$state	==	2	?	0	:	$state;

			$urlarr['state']				=			$state;
		
		}
		if($_GET['keyword']){

			$keyword  						=   		trim($_GET['keyword']);

			$where['email']      			=  			array('like',$keyword);

		}				
		$urlarr        						=   		$_GET;
		$urlarr['page']			  	  		=			'{{page}}';
		
		$pageurl				      		=			Url($_GET['m'],$urlarr,'admin');

		//提取分页
		$pageM					      		=			$this  -> MODEL('page');

		$pages					      		=			$pageM -> pageList('subscribe',$where,$pageurl,$_GET['page']);
		
		if($pages['total']>0){

			if($_GET['order']){

				$where['orderby']			=			$_GET['t'].','.$_GET['order'];

				$urlarr['order']			=			$_GET['order'];

				$urlarr['t']				=			$_GET['t'];

			}else{

				$where['orderby']			=		  	array('ctime,desc');

			}
			
			$where['limit']					=			$pages['limit'];
		
			$rows							=			$SubscribeM->getList($where);

		}
		
		$this->yunset("rows",$rows);

		$this->yuntpl(array('admin/subscribe_list'));

	}

	function del_action(){

		$this->check_token();

		$SubscribeM							=			$this->MODEL('subscribe');

		$del								=			$_GET['del'];

		$addArr								=			$SubscribeM -> del($del);
		
		$this   ->  layer_msg( $addArr['msg'],$addArr['errcode'],$addArr['layertype'],$_SERVER['HTTP_REFERER'],2,1);

	}
}

?>