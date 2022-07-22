<?php
/* *
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
*/
class admin_concheck_log_controller extends adminCommon{  

	function set_search(){
		
		include(CONFIG_PATH."db.data.php");

		$search_list[]	=	array("param"=>"result","name"=>'检测结果',"value"=>array("1"=>"合规","2"=>"不合规"));

		$search_list[]	=	array("param"=>"status","name"=>'处理状态',"value"=>array("0"=>"待处理","1"=>"已处理","2"=>'无需处理'));
		
		$ports			=	array();
		foreach ($arr_data['source'] as $key => $value) {
			if(in_array($key,array(1,2,3,13,19,22))){
				$ports[$key] = $value;
			}
		}
		
		
		$search_list[]	=	array("param"=>"source","name"=>'内容来源',"value" => $ports);
		
		$this->yunset(array('search_list' => $search_list, 'ports' => $ports));
		
	}

	function index_action(){

		$this->set_search();

		$concheckM = $this->MODEL('concheck');
		$where = array();
		$noUsername = true;
		if($_GET['keyword']){
			
			$keyword	=	trim($_GET['keyword']);
			
			$type		=	intval($_GET['type']);
			
			if ($type=='1'){
				
			    $userInfoM  =  $this->MODEL('userinfo');
			    $member  =  $userInfoM->getList(array('username'=>array('like',$keyword)),array('field'=>'`uid`'));
			    if (!empty($member)){
			        
			        $muids  =  array();
			        foreach ($member as $v){
			            
			            $muids[] = $v['uid'];
			        }
			        
			        $where['uid']  =  array('in',pylode(',', $muids));
			        
			    }else{
			        $noUsername = false;
			    }
			}elseif($type=='2'){
				
				$where['content']	=	array('like',$keyword);
			}
			$urlarr['type']			=	"".$type."";
			
			$urlarr['keyword']		=	"".$keyword."";
		}
		if(($_GET['date'])){
			
			$times=@explode('~',$_GET['date']);
			
			$where['ctime']	=	array('>=',strtotime($times[0]." 00:00:00")*1000);
			
			$where['ctime']	=	array('<',strtotime($times[1]." 23:59:59")*1000);
			
			$urlarr['date']		=	$_GET['date'];
		}
		if(isset($_GET['status'])){

			$where['status']	=	$_GET['status'];
			$urlarr['status']	=	$_GET['status'];
		}
		if($_GET['result']){
			if($_GET['result']=='1'){
				$where['result']	=	1;
			}else{
				$where['result']	=	array('<>',1);
			}
			
			$urlarr['result']	=	$_GET['result'];
		}
		if($_GET['source']){

			$where['source']	=	$_GET['source'];
			$urlarr['source']	=	$_GET['source'];
		}
		if($_GET['history']){
			$coninfo = $concheckM->getInfo(array('id'=>$_GET['history']));

			$where['ctype']	=	$coninfo['ctype'];
			$where['cid']	=	$coninfo['cid'];
		}
		$urlarr        	=   $_GET;
	    $urlarr['page']	=	"{{page}}";
	    
	    $pageurl		=	Url($_GET['m'],$urlarr,'admin');
	    
	    $pageM			=	$this  -> MODEL('page');
	    
	    $pages			=	$pageM -> pageList('concheck_log',$where,$pageurl,$_GET['page']);
	    
	    //分页数大于0的情况下 执行列表查询
	    if($pages['total'] > 0){
	        
	        if($_GET['order'])
	        {
	            $where['orderby']	=	$_GET['t'].','.$_GET['order'];
	            
	            $urlarr['order']	=	$_GET['order'];
	            
	            $urlarr['t']		=	$_GET['t'];
	        }else{
	            
	            $where['orderby']	=	'id';
	        }
	        
	        $where['limit']	=	$pages['limit'];
	        
	        $logList		=	$concheckM -> getLogList($where);
	        
	        
	    }
	    
	    $this->yunset('rows',$logList);
		
		
		$this->yuntpl(array('admin/admin_concheck_log'));
	}
	function del_action(){
		
		$concheckM	=	$this -> Model('concheck');
		
		$id		=	is_array($_POST['del']) ? $_POST['del'] : $_GET['id'];
		
		$return	=	$concheckM -> delConCheck($id);
		
		$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
		
	}
	function lockinfo_action(){

	    $concheckM  =   $this -> MODEL('concheck');

	    $info  =   $concheckM ->    getInfo(array('id' => intval($_POST['id'])), array('field'=>'`statusbody`'));

	    echo $info['statusbody'];die;

	}
	function status_action()
    {
        $concheckM  =   $this -> MODEL('concheck');

        $statusData = array(

            'status'        =>  intval($_POST['status']),
            'statusbody'    =>  trim($_POST['statusbody'])
        );

        $return = $concheckM -> statusConCheck($_POST['pid'], $statusData);

        $this->ACT_layer_msg($return['msg'], $return['errcode'], "index.php?m=admin_concheck_log", 2, 1);
    }
}

?>