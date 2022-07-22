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
class chat_controller extends user
{
    //互动沟通
	function index_action(){
	    
	    if (!empty($_GET['type']) && $_GET['type'] == $this->usertype){
	        $this->ACT_msg('index.php','登录身份错误');
	    }
	    
	    if ($this->config['sy_chat_open']==1){
	        
	        $resume  =  $this->public_action();
	        
	        $chatM   =  $this -> MODEL('chat');
	        
	        if (isset($_GET['id']) && isset($_GET['type']) && $this->uid && $this->usertype){
	            
	            if (substr($_GET['id'], 0, 1) == 'a'){
	                // 聊天对象是管理员
	                $uid = str_replace('a', '', $_GET['id']);
	                $this->yunset('adminChat', 1);
	            }else{
	                $uid = $_GET['id'];
	            }

	            $chatM->upFriend(array('fid'=>$uid,'fusertype'=>$_GET['type'],'uid'=>$this->uid,'usertype'=>$this->usertype),array('ntime'=>time()));
	            
	            $chat   =  $chatM->userinfo(array('uid'=>$uid,'usertype'=>intval($_GET['type']),'nowid'=>$this->uid,'nowtype'=>$this->usertype));
	            
	            $this -> yunset('receive',$chat['mine']);
	            
	            $br  =  $chatM->getBeginid(array('fromid'=>$uid,'toid'=>$this->uid,'fusertype'=>$chat['mine']['usertype'],'tusertype'=>$this->usertype));
	            
	            if (!empty($br['beginid'])){
	                $chatM->upChatLog(array('status'=>1),array('beginid'=>$br['beginid'],'to'=>$this->uid,'tusertype'=>$this->usertype,'status'=>2));
	            }

	            $canwx  =   $chatM->getFriendCan(array('type'=>'wx','uid'=>$this->uid,'usertype'=>$this->usertype,'fid'=>$uid,'fusertype'=>$_GET['type']));
	            $cantel =   $chatM->getFriendCan(array('type'=>'tel','uid'=>$this->uid,'usertype'=>$this->usertype,'fid'=>$uid,'fusertype'=>$_GET['type']));

	            
	            $this -> yunset('cantel',$cantel);
	            $this -> yunset('canwx',$canwx);
	            
	            $data['nickname']  =  $chat['mine']['username'];
	            
	            $this->data        =  $data;
	            
	            $this->seo('chat');
	            
	        }
	        
	        $myself   =  $chatM->userinfo(array('uid'=>$this->uid,'usertype'=>$this->usertype,'history'=>1,'friend'=>1));
	        
	        // 招呼
            $type = $this->usertype == 1 ? 4 : 3;
            $greeting = $chatM->getUsefulSet(array('type'=>$type, 'orderby'=>'sort'));
            $this->yunset('greeting', $greeting['content']);
                
	        $this -> yunset('rows',$myself['history']);
	        
	        $this->yuntpl(array('chat/yunliao/index'));
	    }else{
	        
	        $this->ACT_msg('网站未开启'.$this->config['sy_chat_name'].'功能');
	    }
	}
	// 单对单聊天js预加载
	function single_action()
	{
	    $res   = array();
	    
	    $chatM =  $this -> MODEL('chat');
	    $uid   =  intval($_POST['id']);
	    $utype =  intval($_POST['type']);
	    
	    $chat   =  $chatM->userinfo(array('uid'=>$uid,'usertype'=>$utype,'nowid'=>$this->uid,'nowtype'=>$this->usertype));
	    
	    $res['receive'] = $chat['mine'];
	    
	    $br  =  $chatM->getBeginid(array('fromid'=>$uid,'toid'=>$this->uid,'fusertype'=>$chat['mine']['usertype'],'tusertype'=>$this->usertype));
	    
	    if (!empty($br['beginid'])){
	        $chatM->upChatLog(array('status'=>1),array('beginid'=>$br['beginid'],'to'=>$this->uid,'tusertype'=>$this->usertype,'status'=>2));
	    }
	    
	    $res['canwx']    =  $chatM->getFriendCan(array('type'=>'wx','uid'=>$this->uid,'usertype'=>$this->usertype,'fid'=>$uid,'fusertype'=>$utype));
	    $res['cantel']   =  $chatM->getFriendCan(array('type'=>'tel','uid'=>$this->uid,'usertype'=>$this->usertype,'fid'=>$uid,'fusertype'=>$utype));
	    
	    echo json_encode($res);
	}
}
?>