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
class index_controller extends xjhlive_controller{
	function index_action()
	{
		$this->seo('xjhlive');		
	    $this->yun_tpl(array('index'));
	}
	function show_action()
	{
		if($_GET['id']){
			$id		=	$_GET['id'];

			$xjhM	=	$this->MODEL('xjhlive');

			$info	=	$xjhM->getInfo(array('id'=>$id),array('getcom'=>true,'defaultPic'=>true));

			$comlist=	$info['comlist'];//所有参会企业

			$this->yunset('comlist',$comlist);

			if (empty($info)){
			    $this->ACT_msg($_SERVER['HTTP_REFERER'], '宣讲会不存在！');
			}else if($info['status']==0){
			    $this->ACT_msg($_SERVER['HTTP_REFERER'], '宣讲会审核中！');
			}else if($info['status']==2){
			    $this->ACT_msg($_SERVER['HTTP_REFERER'], '宣讲会未通过审核！');
			}

			if($info['livestatus']==1 && $info['status']==1 && $info['stime']>time()){
				
				if(!$this->uid){
					$this->yunset('substatus',1);
				}
				if($info['uid'] != $this->uid && $this->usertype == 1){
					
				    $sub	=	$xjhM->getyyInfo(array('uid'=>$this->uid,'xid'=>$info['id']));
					
					if($sub){
						
						$substatus  =  2;
					}else{
						
						$substatus  =  1;
					}
					
					$this->yunset('substatus',$substatus);
				}	
			}
			
			if($info['livestatus']==3 || $info['livestatus']==2){
			      $this->yunset('hit',1);
			}
			
			$this->yunset('info',$info);
			
			if($this->uid){
				$chatM  =  	$this->MODEL('chat');
				
				$blacknum	=	$chatM->getXjhchatBlackNum(array('uid'=>$this->uid,'xid'=>$id));
				
				if($blacknum>0){
					
					$this->yunset('black',1);
				}
			}

			if($this->usertype==1){//个人用户进入页面判断是否存在简历
				$resumeM	=	$this->MODEL('resume');
				$expect		=	$resumeM->getExpect(array('uid'=>$this->uid),array('field'=>'id'));
				$this->yunset('eid',$expect['id']);
			}
		}
		$data['xjhlive_title']  =   $info['name'];
	    $data['xjhlive_desc']   =   $this -> GET_content_desc($info['body']);
	    $this -> data       =   $data;
		
	    $this->seo('xjhlive_show');
	    $this->yun_tpl(array('show'));
	}
	/*招聘岗位*/
	function xjhJoblist_action(){

		if($_POST['xjhid']){

			$xid 	=	$_POST['xjhid'];

			$xjhM	=	$this->MODEL('xjhlive');

			$info	=	$xjhM->getInfo(array('id'=>$xid));

			$cuid	=	array();

			$xcoms	=	$xjhM->getXjhComList(array('xid'=>$info['id']));
			foreach ($xcoms as $key => $value) {
			    $cuid[]  =  $value['uid'];
			}
			
			if(!empty($cuid)){
				$jobM 		=	$this->MODEL('job');

				$jWhere['uid']      	=   array('in', pylode(',', $cuid));
		        $jWhere['r_status'] 	=   1;
		        $jWhere['status']  	 	=   0;
		        $jWhere['state']    	=   1;
		        $jWhere['orderby'][]  	=   'uid,desc';
		        $jWhere['orderby'][]  	=   'id,desc';
		        $jData['field']     	=   '`id`,`uid`,`name`,`com_name`,`exp`,`edu`,`number`,`minsalary`,`maxsalary`,`provinceid`,`cityid`';

		        $num        	=   $jobM -> getJobNum($jWhere);

		        $page        	=   $_POST['page'] ? intval($_POST['page']) : 1;  
				$limit       	=   $_POST['limit'] ? intval($_POST['limit']) : 5;
				$maxpage     	=   intval(ceil($num/$limit));
				
				if ($page > $maxpage){
				    $page    	=   $maxpage;
		        }
		        
		        $start       	=     $page * $limit;

		        if (intval($_POST['updown'])==1){
		            
		            $jobpage   	=   max(1,($page-1));
					
		        }else if (intval($_POST['updown'])==2){
		            
		            $jobpage   	=   min($maxpage,($page+1));
					
		        }
				
				if($jobpage == 1){
				    
					$start  	=  0;
					
				}else{
				    
				    $start   	=   ($jobpage-1)*$limit;
				}

				$jWhere['limit']  =	 array($start, $limit);
				
				$jData['isurl']   =  'yes';
				
				$joblist		=	$jobM->getList($jWhere, $jData);
			}
			$data['joblist']	=	!empty($joblist['list']) ? $joblist['list'] : array();
			$data['jobpage']	=	$jobpage;
			$data['maxpage']	=	$maxpage;
			echo json_encode($data);
		}
	}
	function xjhSubcribe_action(){
		$uid	=	$this->uid;
		$usertype	=	$this->usertype;
		
		if($uid && $usertype==1){
			
			$xjhM  =  	$this->MODEL('xjhlive');

			$yyinfo=	$xjhM->getyyInfo(array('uid'=>$uid,'xid'=>$_POST['xjhid']));
			
			if(!empty($yyinfo)){
				
			    $data['error']  =  7;
			}else{
				$subData	=	array(
					'uid'		=>  $uid,
	                'xid'		=>  $_POST['xjhid'],
	                'ctime'		=>  time(),
				);
				$nid	=	$xjhM->addyy($subData);
				
				if($nid){

				    $return  =  $xjhM->addyyMsg($_POST['xjhid'],$uid,$nid);
				    
				    if (!empty($return['wxshow'])){
				        
				        $data['wxshow']  =  1;
				    }
				}
				
				$data['error']  =  9;
			}

		}else{
			
		    $data['error']  =  8;
        }
		
        echo json_encode($data);die;
	}
	function playback_action()
	{
		$this->seo('xjhlive_playback');		
	    $this->yun_tpl(array('playback'));
	}
	
	function delblackuser_action()
    {
		if($_POST['id'] && $_POST['xjhid']){
			
			$chatM  =  	$this->MODEL('chat');
			
			$where	=	array(
				'uid' 	=>	$_POST['id'],
				'xjhid'	=>	$_POST['xjhid'],
			);
			$return  =  $chatM->delXjhchatBlack('',array('where'=>$where));
			
		}else{
			$return['errcode']	=	8;
			$return['msg']	=	"请选择您要解禁的用户！";
		}
		echo json_encode($return);die;
    }
	/**
     * 观看次数
     */
    function GetHits_action()
    {
        $id = intval($_GET['id']);
        if (empty($id)) {
            echo 'document.write(0)';
            die();
        }
		
        if(!isset($_COOKIE['seexjh']) || (isset($_COOKIE['seexjh']) && $_COOKIE['seexjh'] != $id)){
		    
		    $xjhM   =   $this->MODEL('xjhlive');
		    $info	=	$xjhM->getInfo(array('id'=>$id),array('field'=>'livestatus'));
		    // 直播中、直播结束，才统计观看人数
		    if($info['livestatus']==3 || $info['livestatus']==2){
		        $xjhM->upXjh(array('id'=>$id),array('hits'=>array('+',1)));
		        $hits   =   $xjhM->getInfo(array('id' => $id), array('field' => '`hits`'));
		        
		        $this->cookie->setcookie('seexjh',$id, time()+300);
		    }else{
		        $hits['hits']  =  1;
		    }
		}else{
		    
		    $hits['hits']	=	$_GET['hits'];
		}
        
        echo 'document.write('.$hits['hits'].')';
        die();
    }
    /*
     * ajax获取观看人数
     */
    function getAjaxHits_action(){
        
        $xjhM   =   $this->MODEL('xjhlive');
        $hits   =   $xjhM->getInfo(array('id' => $_GET['id']), array('field' => '`hits`'));
        
        echo $hits['hits'];die;
    }
    /**
     * wap站宣讲会详情页二维码
     */
    function getXjhShowQrcode_action()
    {
        $url  =  Url('wap',array('c'=>'xjhlive','a'=>'show','id'=>intval($_GET['id'])));
        
        include_once LIB_PATH."yunqrcode.class.php";
        YunQrcode::generatePng2($url,4);
    }
    /**
     * 查询直播状态、直播播放地址
     */
    function getXjhlive_action(){
        
        $id		=	$_POST['id'];
        
        $xjhM	=	$this->MODEL('xjhlive');
        
        $info	=	$xjhM->getInfo(array('id'=>$id), array('field'=>'`livestatus`,`playtime`,`stime`,`playurl`,`caster`'));
        
        echo json_encode($info);die;
    }
}
?>