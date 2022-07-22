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
class com_pl_controller extends siteadmin_controller{
	function set_search(){
		$search_list[]=array("param"=>"end","name"=>'发送时间',"value"=>array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月'));
		$search_list[]=array("param"=>"r_time","name"=>'回复时间',"value"=>array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月'));
		$this->yunset("search_list",$search_list);
	}
	function index_action(){

		$this->set_search();
    
		$companyM   =   $this ->  MODEL('company'); 
    
		$resumeM    =   $this ->  MODEL('resume'); 
    
    
		if($_GET['end']){
      
			if($_GET['end']=='1'){
        
				$where['ctime']	=	array('>=',strtotime('today'));
         
			}else{
				$where['ctime']	=	array('>=',strtotime('-'.intval($_GET['end']).' day'));
			}
			$urlarr['end']		=	$_GET['end'];
		} 
    
		if($_GET['r_time']){
      
			if($_GET['r_time']=='1'){
        
				$where['reply_time']	=	array('>=',strtotime('today'));
         
			}else{
				$where['reply_time']	=	array('>=',strtotime('-'.intval($_GET['r_time']).' day'));
			}
			$urlarr['r_time']			=	$_GET['r_time'];
		} 
    
		if($_GET['keyword']){
      
			$keytype	=	intval($_GET['type']);
		    
			$keyword	=	trim($_GET['keyword']);
      
			if($keytype     ==    1){
         
				$rwhere['name']	=	array('like',$keyword);         
          
				$resume			=	$resumeM -> getResumeList($rwhere,array('field'=>'uid,name')); 
        
				foreach($resume as $v){

					$userid[]	=	$v['uid'];
				} 
        
				$where['uid']	=	array('in',pylode(',',$userid));
        
			}elseif($keytype    ==    2){
        
				$cwhere['name']	=	array('like',$keyword);
           
				$ctList			=	$companyM ->getList($cwhere,array('field'=>'uid')); 
            
				$comapant		=	$ctList['list'];
              
				foreach($comapant as $v){
            
					$comid[]	=	$v['uid'];
           
				}
           
				$where['cuid']	=	array('in',pylode(',',$comid));
        
			}elseif($keytype    ==    3){
        
				$where['content']=	array('like',$keyword); 
        
			}elseif($keytype    ==    4){
        
				$where['reply']	=	array('like',$keyword); 
        
			}
      
			$urlarr['keytype']	=	$keytype;
		    
			$urlarr['keyword']	=	$keyword;
      
		}
    
		$urlarr['page']	=	"{{page}}";
    
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
    
		$pageM			=	$this  -> MODEL('page');
     
		$pages			=	$pageM -> pageList('company_msg',$where,$pageurl,$_GET['page']);
    
		if($pages['total']  > 0){
			//limit order 只有在列表查询时才需要
			if($_GET['order']){
         
				$where['orderby']	=	$_GET['t'].','.$_GET['order'];
				$urlarr['order']	=	$_GET['order'];
				$urlarr['t']		=	$_GET['t'];
         
			}else{
          
				$where['orderby']	=	array('id,desc');
			}
      
		}  
    
		$where['limit']	=	$pages['limit'];

		$mes_list		=	$companyM -> getCompanyMsgList($where,array('utype'=>'admin','cache'=>'1'));

		$this->yunset("mes_list",$mes_list);
    
		$this->siteadmin_tpl(array('admin_compl'));
	}
	function del_action(){
      
		$compannyM    =   $this   ->    MODEL('company');
      
		$delID	      =	  is_array($_POST['del']) ? $_POST['del'] : $_GET['id'];
      
        if($delID){
              
            $where['id']  =   array('in',pylode(',',$delID));
            
            $list         =   $compannyM -> getCompanyMsgList($where,array('field'=>'uid'));
             
            $return	      =	  $compannyM -> delCompanyMsg($delID);
              
            if($list){
          
                foreach($list as $v){
                  
                  $this->automsg('管理员操作：删除会员（ID：'.$v['uid'].'）面试评论',$v['uid']);
                  
                }
                
            }
              
            $this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
              
        }else{
            $this->layer_msg('非法操作！',8);
        }
		
	}
  
	function show_action(){
    
		$companyM	=	$this->MODEL("company");
     
		$id			=	intval($_POST['id']);
      
		$info		=	$companyM->getCompanyMsgInfo(array('id' => $id), array('field'=>'content,othercontent,reply')); 
     
		$data['content']		=	$info['content'];
			
		$data['othercontent']	=	$info['othercontent'];
			
		$data['reply']			=	$info['reply'];
      
		echo json_encode($data);die;
     
	}
}
?>