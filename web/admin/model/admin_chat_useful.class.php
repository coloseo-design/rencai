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
class admin_chat_useful_controller extends adminCommon{  
	function index_action(){
		$chatM = $this->MODEL('chat');
		$where = array();
		$noUsername = true;
		if($_GET['keyword']){
			
			$keyword	=	trim($_GET['keyword']);
			
			$type		=	intval($_GET['type']);
			
			if ($type==1){
				
			    $userInfoM  =  $this->MODEL('userinfo');
			    $member  =  $userInfoM->getList(array('username'=>array('like',$keyword)),array('field'=>'`uid`'));
			    if (!empty($member)){
			        
			        $muids  =  array();
			        foreach ($member as $v){
			            
			            $muids[] = $v['uid'];
			        }
			        if ($type == 1){
			            
			            $where['from']  =  array('in',pylode(',', $muids));
			            
			        }elseif ($type == 2){
			            
			            $where['to']  =  array('in',pylode(',', $muids));
			        }
			    }else{
			        $noUsername = false;
			    }
			}elseif($type==2){
				
				$where['content']	=	array('like',$keyword);
			}
			$urlarr['type']			=	"".$type."";
			
			$urlarr['keyword']		=	"".$keyword."";
		}
		// 用户名没搜到的，不查询
		if ($noUsername){
			$urlarr        	=   $_GET;
		    $urlarr['page']	=	"{{page}}";
		    
		    $pageurl		=	Url($_GET['m'],$urlarr,'admin');
		    
		    $pageM			=	$this  -> MODEL('page');
		    
		    $pages			=	$pageM -> pageList('chat_useful',$where,$pageurl,$_GET['page']);
		    
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
		        
		        $chatList		=	$chatM -> getChatUsefulList($where,array('admin'=>1));
		    }
		    
		    $this->yunset('rows',$chatList);
		}
		
		$this->yuntpl(array('admin/admin_chat_useful'));
	}
	function usefulSet_action(){
	    if($_GET['type'] !=''){
            $type=$_GET['type'];
        }else{
	        $type="1";
        }

        $chatM = $this->MODEL('chat');
        $chatList = $chatM->getUsefulSetList(array('type'=>$type,'orderby'=>'sort,desc'),array('admin'=>1));
        $this->yunset('rows',$chatList);
        $this->yunset('type',$type);
        $this->yuntpl(array('admin/admin_chat_useful_set'));
    }
    function usefulSetAdd_action(){
	    if($_POST['submit']){
            unset($_POST['submit']);
            $chatM = $this->MODEL('chat');
            $_POST['content'] = trim($_POST['content']);
            if(isset($_POST['id'])&&!empty($_POST['id'])){
                $return = $chatM->upChatUsefulSet(array('id'=>intval($_POST['id'])),$_POST);
            }else{

                $return = $chatM->addChatUsefulSet($_POST);
            }

        }else{
	        $return['msg'] = '非法操作！';
	        $return['errcode'] = '8';
        }
        $this->ACT_layer_msg($return['msg'],$return['errcode'],'index.php?m=admin_chat_useful&c=usefulSet&type='.$_POST['type'],2,1);
    }
	function add_action(){
	    
	    $data = array('content'=>trim($_POST['content']));
	    
	    $chatM	=	$this->Model('chat');
	    $data['utype'] = "admin";
	    if (isset($_POST['id'])){
	        $res = $chatM->upChatUseful(array('id'=>intval($_POST['id'])), $data);
	    }
	}
	function customdel_action(){
        $this -> check_token();

        $delid		=	(int)$_GET['id'];
        $chatM	=	$this -> Model('chat');

        $where['id']	=	$delid;
        $return	=	$chatM -> delUsefulSet($where);

        $return?$this -> layer_msg($return['msg'],9,2,$_SERVER['HTTP_REFERER']):$this -> layer_msg($return['msg'],8,2,$_SERVER['HTTP_REFERER']);

    }
	function del_action(){

		$chatM	=	$this -> Model('chat');
		
		if(is_array($_POST['del'])){
			
			$delid		=	@implode(',',$_POST['del']);
			
			$layer_type	=	1;
		}else{
			$this -> check_token();
			
			$delid		=	(int)$_GET['id'];
			
			$layer_type	=	0;
		}

		$where['id']	=	array('in',$delid);

        $data['utype'] = "admin";
		$del	=	$chatM -> delChatUseful($where,$data);

		$del?$this -> layer_msg('用户常用语(ID:'.$delid.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']):$this -> layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);

	}
}

?>