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

class index_controller extends common{
    function goChat_action()
    {
        
        if ($this -> config['sy_chat_open'] == 1){
            
            if ($this->usertype && ($this->usertype == 1 || $this->usertype == 2 || $this->usertype == 3)){
                
                $chatM  =  $this->MODEL('chat');
                $chat   =  $chatM->userinfo(array('uid'=>$this->uid,'usertype'=>$this->usertype));
                $token  =  $chatM->chatToken($this->uid);
                
                $chat['yuntoken']  =  $token;
                
                $chat['usefullist']   = $chatM->getChatUsefulList(array('uid'=>$this->uid,'usertype'=>$this->usertype), array('utype'=>'user'));

                echo json_encode($chat);
            }
        }
    }
    //开始聊天，先发个信息作为开始
    function beginChat_action()
    {
        if ($this->uid && $this->usertype){
            
            $data   =  array(
                'toid'       =>  $this->uid,
                'fromid'     =>  (int)$_POST['id'],
                'tusertype'  =>  $this->usertype,
                'fusertype'  =>  $_POST['usertype'],
                'jobid'      =>  $_POST['jobid'],
                'jobtype'    =>  $_POST['jobtype'],
                'timestamp'  =>  $_POST['timestamp']
            );
            
            $chatM   =  $this->MODEL('chat');
            
            $return  =  $chatM -> beginChat($data);
            
            echo json_encode($return);
        }
    }
    // 获取单个聊天记录
    function getSingleChatOnlineData_action(){

        if ($this->uid && $this->usertype){
            if($_POST['totype']==9){
                $_POST['toid'] = str_replace('a','',$_POST['toid']);
            }
            $data   =  array(
                'uid'       =>  $this->uid,
                'usertype'  =>  $this->usertype,
                'toid'      =>  $_POST['toid'],
                'totype'    =>  $_POST['totype'],
            );

            $chatM   =  $this->MODEL('chat');
            
            $return  =  $chatM -> getSingleChatOnlineData($data);
            
            echo json_encode($return);die;
        }
    }
    // 按列表获取聊天数据
    function getAllChatOnlineData_action(){

        if ($this->uid && $this->usertype){

            $data   =  array(
                'uid'       =>  $this->uid,
                'usertype'  =>  $this->usertype,
            );

            $chatM   =  $this->MODEL('chat');
            
            $return  =  $chatM -> getAllChatOnlineData($data);
            
            echo json_encode($return);die;
        }
    }
    
    //个人用户切换聊天对象时，异步查出对方所有职位
    function getAjaxJobs_action(){

        $toid      =  intval($_POST['toid']);
        $totype    =  intval($_POST['totype']);

        if($this->uid && $this->usertype && $toid){
            
            $return = array();

            if($totype==2){

                $jobM  =  $this->MODEL('job');
                $jobs  =  $jobM->getList(array('uid'=>$toid,'state'=>1,'r_status'=>1,'status'=>0,'limit'=>50),array('chat'=>1,'field'=>'`id`,`uid`,`name`,`com_name`,`provinceid`,`cityid`,`minsalary`,`maxsalary`,`exp`,`edu`'));

                if (!empty($jobs['list'])){
                    
                    $joblist = array();
                    foreach ($jobs['list'] as $k=>$v){
                       
                       $joblist[$v['id']] = $v;
                       $joblist[$v['id']]['weburl'] = Url('job',array('c'=>'comapply','id'=>$v['id']));
                    }
                    $return['joblist']  =  $joblist;
                }

            }elseif($totype==3){

                $ltjobM  =  $this->MODEL('lietoujob');
                $jobs    =  $ltjobM->getList(array('uid'=>$toid,'status'=>1,'zp_status'=>0,'r_status'=>1));
           
                foreach ($jobs as $k=>$v){
                   
                    $joblist[$v['id']]['id']            =  $v['id'];
                    $joblist[$v['id']]['name']          =  $v['job_name'];
                    $joblist[$v['id']]['com_name']      =  $v['com_name'];
                    $joblist[$v['id']]['job_salary']    =  $v['salary'];
                    $joblist[$v['id']]['citystr']       =  isset($v['citystr']) ? $v['citystr'] : '';
                    $joblist[$v['id']]['job_exp']       =  $v['exp_n'];
                    $joblist[$v['id']]['job_edu']       =  $v['edu_n'];
                }

                $return['joblist']  =  $joblist;

            }
            
            echo json_encode($return);die;
        }
    }
    //添加聊天发送记录
    function chatLog_action()
    {
        $uid     =  intval($_POST['to']);
        $chatM   =  $this -> MODEL('chat');
        //条件聊天判断时否有和个人聊天的权利
        $tcarr = array(
            'uid'      => $this->uid,
            'spid'     => $this->spid,
            'username' => $this->username,
            'usertype' => $this->usertype,
            'chatid'   => $uid
        );
        $comtcM  =  $this->MODEL('comtc');
        $res     =  $comtcM->chatRight($tcarr);
        
        if ($res['error'] == 0){
            $arr     =  array(
                'toid'       =>  $_POST['to'],
                'tusertype'  =>  $_POST['totype'],
                'fromid'     =>  $this->uid,
                'fusertype'  =>  $this->usertype,
                'content'    =>  $_POST['content'],
                'timestamp'  =>  $_POST['timestamp'],
                'msgtype'    =>  $_POST['msgtype'],
                'nowid'      =>  $_POST['nowid'],
                'nowtype'    =>  $_POST['nowtype'],
                'source'     =>  1
            );
            
            $return  =  $chatM -> chatLog($arr);
        }else{
            $return  =  $res;
        }
        echo json_encode($return);die;
    }
    /**
     * 聊天记录分页
     */
    function getChatPage_action()
    {
        if ($this->uid && $this->usertype){
            
            $arr    =  array(
                'toid'       =>  $_POST['id'],
                'tusertype'  =>  $_POST['totype'],
                'fromid'     =>  $this->uid,
                'fusertype'  =>  $this->usertype,
                'page'       =>  $_POST['page'],
                'lastid'     =>  $_POST['lastid']
            );
            
            $chatM   =  $this -> MODEL('chat');
            
            $return  =  $chatM -> getChatPage($arr);
            
            echo  json_encode($return);die;
        }
    }
    /**
     * 判断简历是否被下载
     */
    function getdown_action()
    {
        
        $arr   =  array(
            'eid'         =>  $_POST['eid'],
            'toid'        =>  $_POST['toid'],
            'nowtype'     =>  $_POST['nowtype'],
            'fromid'      =>  $this->uid,
            'fusertype'   =>  $this->usertype,
            'zid'         =>  $_POST['zid']
        );

        if ($this->spid){
            $arr['spid']    =   $this->spid;
        }
        
        $chatM  =  $this->MODEL('chat');
        
        $return  =  $chatM -> comToChat($arr);
        
        echo json_encode($return);
    }
    /**
     * 发送图片信息
     */
    function uploadImage_action()
    {
        if ($this->uid && $this->usertype){
            
            $UploadM  =  $this -> MODEL('upload');
            
            $upArr  =  array(
                'file' =>  $_FILES['file'],
                'dir'  =>  'chat'
            );
            $result  =  $UploadM->newUpload($upArr);
            
            if (!empty($result['msg'])){
                $return  =  array(
                    'code'  =>  1,
                    'msg'   =>  $result['msg'],
                    'data'  =>  array()
                );
            }else{
                $pic  =  $result['picurl'];
                
                $result['picurl']  =  checkpic($pic);
                
                $return = array(
                    'code' => 0,
                    'msg' => '',
                    'data' => array('url'=>$result['picurl'])
                );
            }
        }else{
            
            $return['msg']       =  '请先登录';
            $return['code']      =  1;
        }
        echo json_encode($return);
    }
    //条件聊天时，判断个人是否有简历，并判断是否申请过该企业职位/已被企业邀请面试
    function isResume_action(){
        
        $arr  =  array(
            'uid'       =>  $this->uid,
            'usertype'  =>  $this->usertype,
            'comid'     =>  $_POST['id'],
            'jobtype'   =>  $_POST['jobtype'],
            'jobid'     =>  $_POST['jobid'],
            'nowtype'   =>  $_POST['nowtype'],
            'zid'       =>  $_POST['zid']
        );
        
        $chatM  =  $this->MODEL('chat');
        
        $return  =  $chatM -> userToChat($arr);
        
        echo json_encode($return);die;
    }
    // 收到消息即设为已读
    function setMsgStatus_action()
    {
        
        $chatM   =  $this -> MODEL('chat');
        
        $arr     =  array(
            'toid'       =>  $this->uid,
            'fromid'     =>  $_POST['id'],
            'tusertype'  =>  $this->usertype,
            'fusertype'  =>  $_POST['type'],
            'nowid'      =>  $_POST['nowid'],
            'nowtype'    =>  $_POST['nowtype']
        );
        
        $return  =  $chatM->setMsg($arr);
        
        echo json_encode($return);die;
    }
    // 设置语音聊天记录
    function setVoiceStatus_action()
    {
        
        $chatM  =  $this -> MODEL('chat');
        
        $chatid =   intval($_POST['chatid']);
        
        $arr     =  array(
            'id'            =>  $chatid,
            'fromid'        =>  intval($_POST['id']),
            'fusertype'     =>  $_POST['type'],
            'toid'          =>  $this->uid,
            'tusertype'     =>  $this->usertype,
            'nowid'         =>  $this->uid,
            'nowtype'       =>  $this->usertype,
        );
        $return = $chatM -> setVoiceStatus($arr);

        echo json_encode($return);die;
    }
    // 不感兴趣
    function delChatLog_action()
    {
        $return  =  array();
        
        if ($this->uid && $this->usertype){
            
            $arr = array(
                'toid'      => $_POST['to'],
                'tusertype' => $_POST['type'],
                'fromid'    => $this->uid,
                'fusertype' => $this->usertype
            );
            
            $chatM  =  $this->MODEL('chat');
            $chatM->delChatLog($arr);
            
        }else{
            
            $return  =  array('errcode'=>8,'errmsg'=>'请先登录');
        }
        echo json_encode($return);die;
    }
    // 由简历/职位详情页进入,发预定消息
    function prepare_action()
    {
        $pArr   =  array(
            'uid'       =>  $this->uid,
            'usertype'  =>  $this->usertype,
            'toid'      =>  intval($_POST['toid']),
            'totype'    =>  intval($_POST['totype'])
        );
        
        $chatM  =  $this->MODEL('chat');
        
        $list   =  $chatM -> getPrepare($pArr);
        
        echo json_encode($list);die;
    }
    // 查询邀请面试情况
    function inviteCheck_action(){
        
        $jobM  =  $this->MODEL('job');
        
        $where  =  array('uid'=>intval($_POST['id']));
        
        if (!empty($_POST['jid'])){
            
            $where['jobid']  =  intval($_POST['jid']);
        }
        $where['isdel'] = 9;
        $num      =  $jobM->getYqmsNum($where);
        
        $resumeM  =  $this->MODEL('resume');
        
        $resume   =  $resumeM->getResumeInfo(array('uid'=>intval($_POST['id'])),array('field'=>'`name`'));
        
        if ($num > 0){
            $data['msg']  =  '您已邀请其面试，前往查看邀请记录？';
        }else{
            $data['msg']  =  '';
        }
        $data['name']  =  $resume['name'];
        
        echo json_encode($data);die;
    }
    /**
     * 用户不在线，收到消息，提醒用户
     */
    function unSend_action()
    {
        $chatM   =  $this -> MODEL('chat');
        
        $arr     =  array(
            'fromid'    =>  $this->uid,
            'fusertype' =>  $this->usertype,
            'toid'      =>  $_POST['toid'],
            'tusertype' =>  $_POST['totype'],
            'nowtype'   =>  $_POST['nowtype'],
			'port'		=>	'1'
        );
        
        $return  =  $chatM->setUnSend($arr);
    }
    /**
     * 获取聊天token
     */
    function getToken_action()
    {
        
        $chatM  =  $this->MODEL('chat');
        
        $token  =  $chatM->chatToken($this->uid);
        
        $chat['yuntoken']  =  $token;
        
        echo json_encode($chat);
    }
    /**
     * 宣讲会聊天记录分页
     */
    function getXjhChatPage_action()
    {
        $arr    =  array(
            'xid'      =>  $_POST['xjhid'],
            'orderby'    =>  '`id`,DESC',
        );
        $page               =   $_POST['page'];
        $limit              =   10;
        if($page){//分页
            $pagenav        =   ($page-1)*$limit;
            $arr['limit']   =   array($pagenav,$limit);
        }else{
            $arr['limit']   =   $limit;
        }
        
        //筛除被禁言用户
        $buids              =   array();
        $chatM              =   $this -> MODEL('chat');
        $blacklist          =   $chatM ->getXjhchatBlackList(array('xjhid'=>(int)$_POST['xjhid']));
        
        foreach ($blacklist as $bk => $bv) {
            
            if($bv['uid'] && !in_array($bv['uid'],$buids)){
                
                $buids[]    =   $bv['uid'];
            }
        }
        
        if(!empty($buids)){
            $arr['fuid']    =   array('notin',pylode(',',$buids));
        }
        //筛除被禁言用户end
        
        $xjhM               =  $this->MODEL('xjhlive');
        $xjh                =  $xjhM->getInfo(array('id'=>(int)$_POST['xjhid']));
        $return             =  $chatM->getChatList($arr,array('fdata'=>true,'sensitive'=>true));
        $return             =  array_reverse($return);
        $list   =   array();
        foreach($return as $k=>$v){
            $list[$k]['id']         =   $v['fuid'];
            $list[$k]['avatar']     =   $v['user']['avatar'];
            $list[$k]['username']   =   $v['user']['nickname'];
            $list[$k]['caster']     =   $xjh['uid']==$v['fuid']?1:0;
            $list[$k]['content']    =   $v['content'];
            $list[$k]['msgtype']    =   'char';
            $list[$k]['xjhid']      =   'xjh_'.$_POST['xjhid'];
            $list[$k]['xid']        =   $_POST['xjhid'];
            $list[$k]['chatid']     =   $v['id'];
        }
        foreach($list as $k=>$v){
            if($v['id']!=$xjh['uid']){
                $list[$k]['black']	=	1;
            }
        }
        
        $chatnum   =  $chatM->getChatNum(array('xid'=>$arr['xid']));
        
        $ismore    =  ceil($chatnum/$limit) > $page ? true : false;
        
        $result  =  array(
            'list'    =>  $list,
            'ismore'  =>  $ismore
        );
        
        echo  json_encode($result);die;
    }
    
    /**
     * 宣讲会发言，关键词检测
     */
    function checkdata_action(){
        
        $xjhM   =  	$this -> MODEL('xjhlive');
        
        $xjh	=	$xjhM -> getInfo(array('id'=>$_POST['xjhid']),array('field'=>'`id`'));
        
        if(!empty($xjh)){
            
            $chatM     =  $this->MODEL('chat');
            $blacknum  =  $chatM->getXjhchatBlackNum(array('uid'=>$this->uid,'xid'=>$xjh['id']));
            
            if ($blacknum > 0){
                
                echo json_encode(array('errcode'=>8,'您已被禁言'));die;
                
            }else{
                
                if($_POST['content']){
                    $content	=	'';
                    include(LIB_PATH.'sensitive.class.php');
                    $instance = Sensitive::getInstance();
                    
                    if(file_exists(DATA_PATH.'sensitive/xjhword.txt')){
                        $instance->addSensitiveWords(DATA_PATH.'sensitive/xjhword.txt');
                        $content    =   $instance->execFilter($_POST['content']);
                    }else{
                        $content 	=	$_POST['content'];
                    }
                    
                    // 保存聊天记录
                    $arr     =  array(
                        'fuid'       =>  $this->uid,
                        'fusertype'  =>  $this->usertype,
                        'ip'         =>  fun_ip_get(),
                        'content'    =>  $_POST['content'],
                        'timestamp'  =>  $_POST['timestamp'],
                        'msgtype'    =>  'char',
                        'xjhid'      =>  $_POST['xjhid']
                    );
                    $chatM->xhjChat($arr);
                    
                    $return['msgcontent']	=	$content;
                    
                    if ($this->usertype == 1){
                        // 个人用户，发送时不完全展示姓名
                        $resumeM  =  $this->MODEL('resume');
                        $resume   =  $resumeM->getResumeInfo(array('uid'=>$this->uid),array('field'=>'`name`,`sex`'));
                        
                        $return['nickname']  =  $resume['sex'] == 1 ? mb_substr($resume['name'], 0, 1, 'utf-8').'先生' : mb_substr($resume['name'], 0, 1, 'utf-8').'女士';
                    }
                }else{
                    
                    $return['msgcontent']	=	'';
                }
            }
            
            echo json_encode($return);die;
        }
    }
    // 视频面试操作记录聊天记录
    function spviewChat_action(){
        
        if ($_POST['to']){
            $arr     =  array(
                'content'    =>  $_POST['content'],
                'timestamp'  =>  $_POST['timestamp'],
                'msgtype'    =>  'spview'
            );
            if ($_POST['content'] == 'refused'){
                // 拒绝视频，发送方改为对方
                $arr['toid']       =  $this->uid;
                $arr['tusertype']  =  $this->usertype;
                $arr['fromid']     =  $_POST['to'];
                $arr['fusertype']  =  $_POST['totype'];
                $arr['nowid']      =  $_POST['to'];
                $arr['nowtype']    =  $_POST['totype'];
            }elseif ($_POST['content'] == 'closesp'){
                // 取消视频，发送方改为自己
                $arr['toid']       =  $_POST['to'];
                $arr['tusertype']  =  $_POST['totype'];
                $arr['fromid']     =  $this->uid;
                $arr['fusertype']  =  $this->usertype;
                $arr['nowid']      =  $this->uid;
                $arr['nowtype']    =  $this->usertype;
            }
            
            $chatM   =  $this -> MODEL('chat');
            
            $return  =  $chatM -> chatLog($arr);
            
            echo json_encode($return);
        }
    }
    // 未登录用户获取聊天登录参数
    function getUnloginToken_action(){
        
        $ct    =  (trim($_POST['chattype']));
        
        if ($this->uid && $this->usertype){
            $member  =  array('uid'=>$this->uid, 'usertype'=>$this->usertype);
        }else{
            $member  =  array();
        }
        
        $csM   =  $this->MODEL('chatcs');
        $data  =  $csM->getUnloginToken($ct, $member);
        
        echo json_encode($data);
    }
    // 会员中心查询聊天对象列表
    function getmh_action(){
        
        if ($this->uid  && $this->usertype){
            
            $page     =  intval($_POST['page']);
            
            $chatM    =  $this->MODEL('chat');
            
            $history  =  $chatM->getHistory($this->uid, $this->usertype, $page);

            $data   =  array(
                'uid'       =>  $this->uid,
                'usertype'  =>  $this->usertype,
                'page'      =>  $page
            );

            $return  =  $chatM -> getAllChatOnlineData($data);
            
        }
        if(!empty($history)){
            echo json_encode(array('error'=>0,'history'=>$history,'chatstorage'=>$return['toall']));
        }else{
            echo json_encode(array('error'=>1));
        }
    }
    // 换电话、微信状态查询
    function checkCanAsk_action(){

        $chatM  =   $this->MODEL('chat');

        $data   =   array(
            'uid'       =>  $this->uid,
            'usertype'  =>  $this->usertype,
            'toid'      =>  intval($_POST['toid']),
            'totype'    =>  intval($_POST['totype']),
            'ask'       =>  $_POST['ask'],
            'askvalue'  =>  $_POST['askvalue'],
        );

        $return =   $chatM->checkCanAsk($data);
        echo json_encode($return);
    }
    // 同意换电话、微信
    function confirmAsk_action(){

        $data['uid']        = $this->uid;
        $data['usertype']   = $this->usertype;
        $data['toid']       = $_POST['toid'];
        $data['totype']     = $_POST['totype'];
        $data['ask']        = $_POST['ask'];
        $data['askvalue']   = $_POST['askvalue'];
        $data['chatid']     = $_POST['chatid'];
        $chatM  =   $this->MODEL('chat');
        $return =   $chatM->confirmAsk($data);

        echo json_encode($return);
    }
    // 拒绝换电话、微信
    function refuseAsk_action(){
        $data['uid']        = $this->uid;
        $data['usertype']   = $this->usertype;
        $data['toid']       = $_POST['toid'];
        $data['totype']     = $_POST['totype'];
        $data['ask']        = $_POST['ask'];
        $data['chatid']     = $_POST['chatid'];
        $chatM  =   $this->MODEL('chat');
        $return =   $chatM->refuseAsk($data);

        echo json_encode($return);
    }
    // 查询单个职位
    function getJob_action(){
        
        $jobM = $this->MODEL('job');
        
        $job  = $jobM->getInfo(array('id'=>$_POST['jobid']),array('field'=>'id,name,com_name,job1,job1_son,job_post,provinceid,cityid,three_cityid,exp,edu,minsalary,maxsalary'));
        
        $job['weburl'] = Url('job',array('c'=>'comapply','id'=>$job['id']));
        
        echo json_encode($job);die;
    }

    // 删除常用语
    function delUseful_action(){
        
        $chatM  =  $this->MODEL('chat');
        $res    =  $chatM->delChatUseful(array('id'=>$_POST['id'],'uid'=>$this->uid,'usertype'=>$this->usertype));
        
        echo json_encode($res);
    }
    // 常用语保存
    function usefulSave_action(){
        
        $data = array(
            'uid'      => $this->uid,
            'usertype' => $this->usertype,
            'content'  => trim($_POST['content'])
        );
        
        $chatM  =  $this->MODEL('chat');
        
        if (empty($_POST['id'])){
            $res  =  $chatM->addChatUseful($data);
        }else{
            $res  =  $chatM->upChatUseful(array('id'=>$_POST['id']), $data);
        }
        
        echo json_encode($res);
    }
}
?>