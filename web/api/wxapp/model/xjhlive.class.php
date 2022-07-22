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
class xjhlive_controller extends wxapp_controller{
    
    function list_action()
    {
        $return = array();
		$xjhM  =  $this->MODEL('xjhlive');
        $where  = array(
            'status'     => 1,
            'state'      => array('<>',3),
            'statetime'  =>array('<',time())
        );
        $xjhtab =   (int)$_POST['xjhtab'];
        $csort   =   false;
        if($xjhtab==1){
            $where['livestatus']    =   1;
            $csort   =   true;
        }else if($xjhtab==2){
            $where['livestatus']    =   2;
            $where['playback']      =   1;
        }else if($xjhtab==3){
            $where['livestatus']    =   3;
            $csort   =   true;
        }else{
            $csort   =   true;
        }

        if($_POST['keyword']){
			
			$where['name']	=	array('like',$_POST['keyword']);
		}
		// 处理分站查询条件
		if (!empty($_POST['did'])){
		    $where['did']  =  $_POST['did'];
		}
        $field  =   '`id`,`name`,`livestatus`,`stime`';
        if ($csort){
            // 条件排序，进行中在最上面，接着是未开始，最后是已结束
            $field  .=  ',CASE WHEN `livestatus`<>2  THEN `stime`';
            $field  .=  ' WHEN `livestatus`=2 THEN -1*`stime` END AS `xjh_px`';
            
            $where['orderby'] .=  ' CASE WHEN `livestatus`=3 THEN 0';
            $where['orderby'] .=  ' WHEN `livestatus`=1 THEN 1';
            $where['orderby'] .=  ' WHEN `livestatus`=2 THEN 2';
            $where['orderby'] .=  ' END,`xjh_px` ASC';
        }else{
            $where['orderby'] .=  '`stime`,DESC';
        }

        $page   =  $_POST['page'];
        $limit  =  $_POST['limit'] ? $_POST['limit'] : 10;
        if($page){
            
            $pagenav  =  ($page - 1) * $limit;
            $where['limit']  =  array($pagenav,$limit);
            
        }else{
            
            $where['limit']  =  $limit;
        }
        
        $list  =  $xjhM->getList($where,array('field'=>$field,'num'=>'1','shortlen'=>20));
        
        $enum  =  0;
        $error =  0;
        $return['list']  =  $list;
        
        if (!empty($_POST['uid']) && !empty($_POST['token'])){
            
            $member   =  $this->yzToken($_POST['uid'], $_POST['token']);
            
            $resumeM  =  $this->MODEL('resume');
            $enum     =  $resumeM->getExpectNum(array('uid'=>$member['uid']));
        }
        
        $return['enum']  =  $enum;
        
        $this->render_json($error, 'ok', $return);
    }
    /**
     * 查询宣讲会数据
     */
    function xjhShow_action(){
        
        $time   =  time();
        $member =  array();
        $return =  array();
        
        if (!empty($_POST['uid']) && !empty($_POST['token'])){
            
            $member  =  $this->yzToken($_POST['uid'], $_POST['token']);
        }
        
        $xjhM  =  $this->MODEL('xjhlive');
        
        $xjh   =  $xjhM->getInfo(array('id'=>$_POST['xjhid'],'status'=>1),array('getcom'=>true,'liveRecord'=>1,'defaultPic'=>true));
        
        if (!empty($xjh)){
            
            if($xjh['stime']>$time){
                $second         =   $xjh['stime']-$time;
                $xjh['day']     =   floor($second/(3600*24));
                $second         =   $second%(3600*24);
                $xjh['hour']    =   floor($second/3600);
                $second         =   $second%3600; 
                $xjh['minute']  =   floor($second/60);
                $xjh['second']  =   $second%60;
            }
            
            $return['xjhInfo']  =  $xjh;
            
            // 聊天参数
            if (!empty($member)){
                
                $mine  =  $this->getMine($member, $xjh['uid']);
                $return['mine']  =  $mine;
                if($member['usertype']==1){//个人用户进入页面判断是否存在简历
                    $resumeM	=	$this->MODEL('resume');
                    $enum		=	$resumeM->getExpectNum(array('uid'=>$member['uid']));
                    $return['enum']  =  $enum;
                }
            }
			
			if($xjh['livestatus']==3){
		      $return['sethit']   =	1;
			}elseif($xjh['livestatus']==2 && $xjh['status']==1){
			    $return['sethit']    =	1;
			}
			
			if($xjh['stime']>$time && $xjh['status']==1){
			    if (!empty($member)){
			        if($xjh['uid'] != $member['uid'] && $member['usertype'] == 1){
			            
			            $sub	=	$xjhM->getyyInfo(array('uid'=>$member['uid'],'xid'=>$xjh['id']));
			            
			            if($sub){
			                
			                $return['sub']  =  2;
			            }else{
			                
			                $return['sub']  =  1;
			            }
			        }
			    }else{
			        $return['sub']  =  1;
			    }
			}
			if (isset($_POST['provider'])){
			    // app用分享数据
			    if ($_POST['provider'] == 'app'){
			        $return['shareData']  =  array(
			            'url'       =>  Url('wap',array('c'=>'xjhlive','a'=>'show','id'=>$xjh['id'])),
			            'title'     =>  $xjh['name'],
			            'summary'   =>  mb_substr(strip_tags($xjh['body']), 0,30,'UTF8'),
			            'imageUrl'  =>  !empty($xjh['picarr'][0]) ? $xjh['picarr'][0] : checkpic($this->config['sy_logo'])
			        );
			    }
			    // 百度小程序用seo
			    if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao'){
			        $seodata['xjhlive_title']  =   $xjh['name'];
			        $seodata['xjhlive_desc']   =   $this -> GET_content_desc($xjh['body']);
                    $this->data     =   $seodata;
                    $seo            =   $this->seo('xjhlive_show', '', '', '', false, true);
                    $data['seo']    =   $seo;
			    }
			}
            $this->render_json(0,'ok',$return);
        }else{
            
            $this->render_json(-1,'宣讲会异常');
        }
    }
    //直播招聘岗位列表
	function xjhJoblist_action(){

        if($_POST['xjhid']){

            $xid    =   $_POST['xjhid'];

            $xjhM   =   $this->MODEL('xjhlive');

            $info   =   $xjhM->getInfo(array('id'=>$xid));

            $cuid   =   array();

            $xcoms  =   $xjhM->getXjhComList(array('xid'=>$info['id']));
            foreach ($xcoms as $key => $value) {
                $cuid[]  =   $value['uid'];
            }
            
            $page           =   $_POST['page'];
            $maxpage        =   1;
            if(!empty($cuid)){
                $jobM       =   $this->MODEL('job');

                $jWhere['uid']          =   array('in', pylode(',', $cuid));
                $jWhere['r_status']     =   1;
                $jWhere['status']       =   0;
                $jWhere['state']        =   1;
                $jWhere['orderby'][]    =   'uid,desc';
                $jWhere['orderby'][]    =   'id,desc';
                $jData['field']         =   '`id`,`uid`,`name`,`com_name`,`exp`,`edu`,`number`,`minsalary`,`maxsalary`,`provinceid`,`cityid`';

                $num                    =   $jobM -> getJobNum($jWhere);

                $limit                  =   $_POST['limit'] ? intval($_POST['limit']) : 5;
                
                
                if($page){
                    
                    $pagenav            =  ($page - 1) * $limit;
                    $jWhere['limit']    =  array($pagenav,$limit);
                    
                }else{
                    
                    $jWhere['limit']    =  $limit;
                }
                $maxpage        =   intval(ceil($num/$limit));

                $joblist        =   $jobM->getList($jWhere, $jData);
            }
            $data['joblist']    =   !empty($joblist['list']) ? $joblist['list'] : array();
            $data['islast']     =   $maxpage==0 || $maxpage==$page ? 1 : 0;
            $this->render_json(-1,'',$data);
        }else{
            $this->render_json(-1,'参数异常');
        }
    }
    //预约直播
	function xjhSubcribe_action(){
		
		$member  =  $this->yzToken($_POST['uid'], $_POST['token']);
		
		if($member){
			
			$xjhM  =  $this->MODEL('xjhlive');
			
            $yyinfo=    $xjhM->getyyInfo(array('uid'=>$uid,'xid'=>$_POST['xjhid']));
            
            if(!empty($yyinfo)){
                $this->render_json(-1,'您已预约，请勿重复预约');
            }else{
    			$subData	=	array(
    				'uid'		=>  $member['uid'],
                    'xid'		=>  $_POST['xjhid'],
                    'ctime'		=>  time(),
    			);
    			$nid	=	$xjhM->addyy($subData);
    			if($nid){
    			    
    			    $xjhM->addyyMsg($_POST['xjhid'],$member['uid'],$nid);
    			}
    			$this->render_json(0,'ok');
            }
			
		}else{
            
            $this->render_json(-1,'数据异常请重试');
        }
	}
    /**
     * 观看次数
     */
    function setHits_action()
    {
        $id     =   intval($_POST['xjhid']);
        
        $xjhM   =   $this->MODEL('xjhlive');
             
        $xjhM	->	upXjh(array('id' => $id),array('hits'=>array('+',1)));
        
        $this->render_json(0,'ok');
    }
    /**
     * 宣讲会直播观看人数实时统计
     */
    function liveStatis_action(){
        
        $xjhM   =  $this->MODEL('xjhlive');
        
        $data   =  array(
            'xid'    =>  $_POST['xjhid'],
            'num'    =>  $_POST['num'],
            'ctime'  =>  time()
        );
        
        $xjhM->addLiveStatis($data);
        
        $this->render_json(0,'ok');
    }
    /**
     * 宣讲会查询登录用户聊天所需参数
     */
    function getMine($member){
        
        // 聊天参数
        if (!empty($member)){
            
            $chatM  =  $this->MODEL('chat');
            $chat   =  $chatM->userinfo(array('uid'=>$member['uid'],'usertype'=>$member['usertype']));
            
            $mine   =  array(
                'id'         =>  $member['uid'],
                'avatar'     =>  $chat['mine']['avatar'],
                'username'   =>  $chat['mine']['username']
            );
            return  $mine;
        }
    }
    /**
     * 查询直播状态、直播播放地址
     */
    function getXjhlive_action(){
        
        $id		=	$_POST['id'];
        
        $xjhM	=	$this->MODEL('xjhlive');
        
        $info	=	$xjhM->getInfo(array('id'=>$id), array('field'=>'`livestatus`,`playtime`,`stime`,`playurl`,`caster`'));
        
        $this->render_json(0,'ok',$info);
    }
}
?>