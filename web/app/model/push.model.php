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
class push_model extends model{
   
    /**
     * @desc    发送推送消息
     * @param   string $type 类型 
    			1，jobNewResume			职位收到新投递/快速简历投递
    			2，rewardNewresume		赏金职位收到新投递
    			3，partNewResume			兼职收到新投递
    			4, invite 				个人收到企业邀请面试
    			5，chat					聊天
    			6，jobState				职位审核
    			7，partState			          兼职审核
			
     * @param array $data 自定义数组
                1,fuid                  发送推送用户uid
                2,puser                 接受用户，可以是数组，但必须带有uid
                3,tid                   相关操作表id，
                                        (1)职位收到新投递：             userid_job  表id
                                        (2)赏金职位收到新投递：    company_job_rewardlist  表id
                                        (3)兼职收到新申请 ：           part_apply   表id
                                        (4)个人被邀请面试：              userid_msg 表id
                                        (5)聊天 :              chat_log  表id
                                        (6)职位审核 :           company_job 表id
                                        (6)兼职审核 :           partjob 表id
     */
    
    /**
     * @desc 目前有推送的地方：
        app：
            1，企业职位收到新简历投递；
            2，赏金职位收到新申请
            3，企业职位收到 快速投递简历 申请
            4，企业兼职收到新申请
            5，个人被邀请面试
        wxapp：
            1，企业职位收到 快速投递简历 申请
            2，企业兼职收到新申请
        pc：
            1，企业职位收到新简历投递；
            2，个人被邀请面试
            3，企业职位收到 快速投递简历 申请
            4，赏金职位收到新申请
            5，企业兼职收到新申请
            6，后台审核职位
            7，后台审核兼职
        wap：
            1，企业职位收到新简历投递；
            2，赏金职位收到新申请
            3，个人被邀请面试
            4，企业兼职收到新申请
            5，企业职位收到 快速投递简历 申请

            聊天 chat model

    */
    private function pushing(){
        
        $push  =  null;
        
        include(DATA_PATH.'api/wxapp/app.config.php');
        
        if($this->config['sy_push_open']==1 && $appconfig['sy_push_appid'] && $appconfig['sy_push_appkey'] && $appconfig['sy_push_masterSecret']){
            
            $getui	=	array(
                'appid'			=>	$appconfig['sy_push_appid'],
                'appkey'		=>	$appconfig['sy_push_appkey'],
                'masterSecret'	=>	$appconfig['sy_push_masterSecret'],
                'ssl'           =>  strpos($this->config['sy_weburl'], 'https://') !== false ? true : false
            );
            if (file_exists(APP_PATH.'api/wxapp/getui-v2/PhpyunPush.php')){
                
                include_once APP_PATH.'api/wxapp/getui-v2/PhpyunPush.php';
                
                $push  =   new PhpyunPush($getui);
            }
        }
        
        return $push;
    }
    
    public function pushMsg($type='',$data=array(), $push = null){

        if($this->config['sy_push_open']==1){//查看后台是否开启推送
            
            //收到推送的uid
            if(is_array($data['puser'])){
            
                $data['suid']   =   $data['puser']['uid'];
            }else{
                
                $data['suid']   =   $data['puser'];
            }
            
            //推送记录数据
            $pushData           =   array();
            $pushData['fuid']   =   $data['fuid'];
            $pushData['suid']   =   $data['suid'];
            $pushData['ctime']  =   time();
            $pushData['tid']    =   $data['tid'];
            $pushData['type']   =   $this -> gettype($type, 'funtonum');
            
            //获取所需信息
            if(method_exists($this, $type)){
                
                $res  =  $this->$type($data);
                
                if (!empty($res)){
                    $puser  =  $res['puser'];
                    if (!is_array($puser)){
                        
                        $puser  =  $this->select_once('member',array('uid' => $puser),'`clientid`,`deviceToken`,`app_push`');
                    }
                    if(!empty($puser['clientid']) && $puser['app_push'] == 1){
                        
                        if (!isset($push)){
                            $push  =  $this->pushing();
                        }
                        if($push){
                            $return  =  $this->makePush($res['title'], $res['content'], $puser, $res['payload'], $push);
                            
                            if(!empty($return) && is_array($return)){
                                
                                if ($return['code'] == 0){
                                    $pushData['result']  =   'ok';
                                    $pushData['taskId']  =   key($return['data']);
                                    $pushData['status']  =   current($return['data'][$pushData['taskId']]);
                                }else{
                                    $pushData['result']  =   $return['code'].'，'.$return['msg'];
                                }
                                
                                $this -> addAppPush($pushData);
                            }
                        }
                    }
                }
            }
    	}
    	return $push;
    }
    
    /**
     * @desc  推送类型转换
     * @param string $type： 传参
     * @param string $totype： 想要的类型，比如'funtonum' function类型对应数字,'numtostr'数字对应文字描述
     */
    private function gettype($type,$totype){
        if($type){
            
            if($totype=='funtonum'){
            
                $typearr    =   array(
                    'jobNewResume'      =>  '1',
                    'rewardNewresume'   =>  '2',
                    'partNewResume'     =>  '3',
                    'invite'            =>  '4',
                    'chat'              =>  '5',
                    'jobState'          =>  '6',
                    'partState'         =>  '7'
                );
            }else if($totype=='numtostr'){
                
                $typearr    =   array(
                    '1'     =>  '普通职位收到新投递',
                    '2'     =>  '赏金职位收到新投递',
                    '3'     =>  '兼职收到新投递',
                    '4'     =>  '个人收到邀请面试',
                    '5'     =>  '聊天',
                    '6'     =>  '审核职位',
                    '7'     =>  '审核兼职'
                );
            }
            
            if(is_array($typearr)){
            
                return $typearr[$type];
            }
        }
    } 
    
    //聊天推送，$data数组
    private function chat($data = array())
    {
        $return             =   array();
        
        $content  =  mb_substr($data['content'], 0,24,'utf-8');
        
        if($data['puser']){
            
            $data['title']  =   $data['title']  ?   $data['title']  :   '通知';
            
            $return         =   array(
                'title'     =>  $data['title'],
                'content'   =>  $content,
                'puser'     =>  $data['puser'],
                'payload'   =>  array('path'=>'/pson/pages/chat/chat')
            );
        }
        
        return $return;
    }
    
    //个人收到邀请面试，$data数组  comname-企业名称
    private function invite($data = array()){
        
        $return             =   array();

        if($data['comname']){

            $content        =   mb_substr($data['comname'].'邀请您参加面试', 0, 24, 'UTF-8');

            if($data['puser']){
                
                $data['title']  =   $data['title']  ?   $data['title']  :   '通知';
                
                $return         =   array(
                
                    'title'     =>  $data['title'],
                    'content'   =>  $content,
                    'puser'     =>  $data['puser'],
                    'payload'   =>  array('path'=>'/pson/pages/usermember/invite/index')
                );
            }
        }
        return $return;
    }
    
    //兼职职位收到新投递，$data数组   jobid-职位id  jobname-兼职名称
    private function partNewResume($data = array()){
        
        $return                 =   array();

        if($data['jobid'] || $data['jobname']){

            if($data['jobname']){

                $jobname        =   $data['jobname'];
                
            }else{

                $job            =   $this -> select_once('partjob', array('id'=>$data['jobid']),'name,uid');

                $jobname        =   $job['name'];

                $data['puser']  =   $data['puser']  ?   $data['puser']  :   $job['uid'];
            }

            $content            =   mb_substr('兼职('.preg_replace('# #','',$jobname).')有新的申请', 0, 24, 'UTF-8');

            if($data['puser']){
                
                $data['title']  =   $data['title']  ?   $data['title']  :   '通知';
                
                $return         =   array(
                    
                    'title'     =>  $data['title'],
                    'content'   =>  $content,
                    'puser'     =>  $data['puser'],
                    'payload'   =>  array('path'=>'/pson/pages/commember/partapply/index', 'params'=>array('partid'=>$data['jobid']))
                );
            }
        }
        return $return;
    }
    
    //赏金职位收到新投递，$data数组   jobid-职位id 
    private function rewardNewresume($data = array()){
        
        $return             =   array();

        if($data['jobid']){

            $job            =   $this -> select_once('company_job', array('id'=>$data['jobid']),'`name`,`uid`');

            $data['puser']  =   $data['puser']  ?   $data['puser']  :   $job['uid'];

            $content        =   mb_substr('赏金职位('.preg_replace('# #','',$job['name']).')有新的申请', 0, 24, 'UTF-8');

            if($data['puser']){
                
                $data['title']  =   $data['title']  ?   $data['title']  :   '通知';
                
                $return         =   array(
                
                    'title'     =>  $data['title'],
                    'content'   =>  $content,
                    'puser'     =>  $data['puser'],
                    'payload'   =>  array('path'=>'/pson/pages/commember/jobpack/rewardlog','params'=>array('jobid'=>$data['jobid']))
                );
            }
        }
        return $return;
    }
    
    //职位收到新投递，$data数组   jobid-职位id  jobname-职位名称
    private function jobNewResume($data = array()){

    	$return			        =	array();

    	if(isset($data['jobid']) || isset($data['jobname'])){
    		
    	    if(isset($data['jobname'])){

    			$jobname	    =	$data['jobname'];
    			
    		}else{

    			$job		    =   $this -> select_once('company_job', array('id'=>$data['jobid']),'name,uid');

    			$jobname	    =	$job['name'];

                $data['puser']  =   $data['puser']  ?   $data['puser']  :   $job['uid'];
    		}
    		// 去除所有空格
    		$content	        =	mb_substr('职位('.preg_replace('# #','',$jobname).')有新简历投递', 0, 24, 'UTF-8');

    		if($data['puser']){
    		    
    		    $data['title']  =   isset($data['title'])  ?   $data['title']  :   '通知';
                
                $return         =   array(
                
                    'title'     =>  $data['title'],
                    'content'   =>  $content,
                    'puser'     =>  $data['puser'],
                    'payload'   =>  array('path'=>'/pson/pages/commember/hr/index')
                );
            }
    	}
    	return $return;
    }
    
    //职位审核通知，$data数组 id-职位id jobname-职位名称
    private function jobState($data = array()){
        
        $return			        =	array();
        
        if($data['tid'] || $data['jobname']){
            
            if($data['jobname']){
                
                $jobname	    =	$data['jobname'];
                
            }else{
                
                $jobs		    =   $this -> select_once('company_job', array('id' => $data['tid']),'name,uid');
                
                $jobname	    =	$jobs['name'];
                
                $data['puser']  =   isset($data['puser'])  ?   $data['puser']  :   $jobs['uid'];
            }
            $msg  =  '职位('.preg_replace('# #','',$jobname).')审核';
            $msg .=  $data['state'] == 3 ? '未通过' : '通过';
            
            $content	        =	mb_substr($msg, 0, 24, 'UTF-8');
            
            if($data['puser']){
                
                $data['title']  =   isset($data['title'])  ?   $data['title']  :   '通知';
                
                $return         =   array(
                
                    'title'     =>  $data['title'],
                    'content'   =>  $content,
                    'puser'     =>  $data['puser'],
                    'payload'   =>  array('path'=>'/pson/pages/commember/job/index')
                );
            }
        }
        return $return;
    }
    
    //兼职审核通知，$data数组 id-职位id jobname-职位名称
    private function partState($data = array()){
        
        $return			        =	array();
        
        if($data['tid'] || $data['jobname']){
            
            if($data['jobname']){
                
                $jobname	    =	$data['jobname'];
                
            }else{
                
                $part		    =   $this -> select_once('partjob', array('id'=>$data['tid']),'name,uid');
                
                $jobname	    =	$part['name'];
                
                $data['puser']  =   $data['puser']  ?   $data['puser']  :   $part['uid'];
            }
            $msg  =  '兼职('.preg_replace('# #','',$jobname).')审核';
            $msg .=  $data['state'] == 3 ? '未通过' : '通过';
            
            $content	        =	mb_substr($msg, 0, 24, 'UTF-8');
            
            if($data['puser']){
                
                $data['title']  =   $data['title']  ?   $data['title']  :   '通知';
                
                $return         =   array(
                    
                    'title'     =>  $data['title'],
                    'content'   =>  $content,
                    'puser'     =>  $data['puser'],
                    'payload'   =>  array('path'=>'/pson/pages/commember/part/index')
                );
            }
        }
        return $return;
    }
    
    /**
     * @desc    发送推送消息
     * @param   string $title 标题
     * @param   string $content 内容
     * @param   array $puser 接受方信息
     */
    private function makePush($title, $content, $puser, $payload = array(), $push = false){
        
        $content	=	str_replace("/", '', $content);

        $phonetype	=  !empty($puser['deviceToken']) ? 1 : 2;
        
        $msg		=	array(
            'title'		=>	$title,
            'content'	=>	$content,
            'payload'	=>	json_encode($payload)
        );
        
        $to			=	array(
            'cid'			=>	$puser['clientid'],
            'device_token'	=>	$puser['deviceToken'],
            'system'		=>	$phonetype
        );
        
        if($push){
            
            $return =   $push->pushIGtMsg($msg, $to);
            
            return  $return;
        }
    }
    
    //插入app推送记录
    private function addAppPush($addData=array()){
        $result = 0;
        if(!empty($addData)){
            
            $result  = $this->insert_into('app_push',$addData);
            
        }
        return  $result;
    }
    
    //获取推送记录列表
    public function getAppPushList($where=array(),$data=array()){
        
        if(!empty($where)){

            $data['field']  =   $data['field']  ?   $data['field']  :   '*';

            $list           =   $this   ->  select_all('app_push',$where,$data['field']);

            if(!empty($list)){

                foreach($list as $uk=>$uv){
                    //将发送人和接收人uid集合
                    $alluids[]                    =   $uv['fuid'];
                    $alluids[]                    =   $uv['suid'];
                }
                $alluids    =   array_unique($alluids);

                require_once ('userinfo.model.php');
                $userinfoM  =   new userinfo_model($this->db, $this->def);
                $namelist   =   $userinfoM  ->  getUserList(array('uid'=>array('in',pylode(',',$alluids))));
                foreach($namelist as $nk=>$nv){
                    $names[$nv['uid']]       =   $nv['name'];
                }

                foreach($list as $k=>$v){
                    //发送人名称
                    $list[$k]['fname']          =   $names[$v['fuid']]   ?   $names[$v['fuid']]   :   '用户不存在';
                    //接收人名称
                    $list[$k]['sname']          =   $names[$v['suid']]   ?   $names[$v['suid']]   :   '用户不存在';
                    //推送类型
                    $list[$k]['type_n']         =   $this->gettype($v['type'],'numtostr');
                    //推送时间
                    $list[$k]['ctime']          =   date('Y-m-d H:i:s',$v['ctime']);

                    //推送结果
                    if($v['result']){

                        $list[$k]['result_n']   =   $v['result']=='ok'  ?   '推送成功'  :   '推送失败('.$v['result'].')';

                    }
                    //在线状态
                    if($v['status']=='successed_offline'){

                        $list[$k]['status_n']   =   'app离线';

                    }elseif($v['status']=='successed_online'){

                        $list[$k]['status_n']   =   'app在线';

                    }

                }
            }

            $List['list']   =   $list;
        }
        return  $List;
    }
    
    public function delAppPush($id,$data=array()){
        
        if($id){
            if(is_array($id)){
                $id         =   pylode(',',$id);
                $limit      =   '';
                $layer_type =   '1';
            }else{
                $limit      =   'limit 1';
                $layer_type =   '0';
            }
            $where['id']    =   array('in',$id);
			
            $this           ->  delete_all("app_push",$where,$limit,'');

            $return         =   array(
                'msg'		=>  '推送消息(ID:'.$id.')删除成功！',
                'errcode'   =>  '9',
                'laytype'	=>  $layer_type,
                'url'		=>  $_SERVER['HTTP_REFERER']
            );

        }else{
            $return     =   array(
                'msg'		=>  '请选择您要删除的信息！',
                'errcode'   =>  '8',
                'laytype'	=>  '1',
                'url'		=>  $_SERVER['HTTP_REFERER']
            );
        }
        return $return;
    }
}
?>