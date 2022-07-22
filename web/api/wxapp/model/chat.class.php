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

class chat_controller extends wxapp_controller{
    
    /**
     * 查询登录用户聊天所需参数，不需要聊天记录等其他数据
     */
    function getMine_action(){
        
        $return  =  array();
        
        if (!empty($_POST['token']) && !empty($_POST['uid'])){
            
            $member =  $this->yztoken($_POST['uid'], $_POST['token']);
            
            $chatM  =  $this->MODEL('chat');
            $token  =  $chatM->chatToken($member['uid']);
            
            if (!empty($_POST['mine'])){
                $chat   =  $chatM->userinfo(array('uid'=>$member['uid'],'usertype'=>$member['usertype']));
                $return['mine']      =  $chat['mine'];
            }
            
            $return['yuntoken']  =  $token;
        }
        
        $this->render_json(0,'ok',$return);
    }
    function goChat_action()
    {
        $member =  $this->yztoken($_POST['uid'], $_POST['token']);
        
        if (substr($_POST['toid'], 0, 1) == 'a'){
            // 聊天对象是管理员
            $toid = str_replace('a', '', $_POST['toid']);
            $data['admin'] = 1;
        }else{
            $toid  =  intval($_POST['toid']);
        }
        
        $totype  =  intval($_POST['totype']);
        $zid     =  intval($_POST['zid']);
        
        if ($this -> config['sy_chat_open'] == 1){
            
            $chatM  =  $this->MODEL('chat');
            $chat   =  $chatM->userinfo(array('uid'=>$member['uid'],'usertype'=>$member['usertype']));
            $to     =  $chatM->userinfo(array('uid'=>$toid,'usertype'=>$totype,'nowid'=>$member['uid'],'nowtype'=>$member['usertype']));
            
            $br  =  $chatM->getBeginid(array('fromid'=>$toid,'toid'=>$member['uid'],'fusertype'=>$totype,'tusertype'=>$member['usertype']));
            if (!empty($br['beginid'])){
                $chatM->upChatLog(array('status'=>1),array('beginid'=>$br['beginid'],'to'=>$member['uid'],'tusertype'=>$member['usertype'],'status'=>2));
            }
            
            $data['mine']  =  $chat['mine'];
            $data['to']    =  $to['mine'];
            
            $token  =  $chatM->chatToken($member['uid']);
            
            $data['yuntoken']  =  $token;

            $canwx  =   $chatM->getFriendCan(array('type'=>'wx','uid'=>$member['uid'],'usertype'=>$member['usertype'],'fid'=>$toid,'fusertype'=>$totype));
            $cantel =   $chatM->getFriendCan(array('type'=>'tel','uid'=>$member['uid'],'usertype'=>$member['usertype'],'fid'=>$toid,'fusertype'=>$totype));

            $data['cantel']  =  $cantel;
            $data['canwx']   =  $canwx;
            
            $userM  =   $this->MODEL('userinfo');
            $user   =   $userM->getInfo(array('uid'=>$member['uid']));
            $data['user']  =  $user;
            
            
            if ($member['usertype'] == 2){
                
                $jobM  =  $this->MODEL('job');
                
                $num   =  $jobM->getYqmsNum(array('uid'=>$toid,'fid'=>$member['uid'],'isdel'=>9));
                
                $data['inviteNum']  =  $num;
            }
            $data['iosfk']	     =  $this->config['sy_iospay'];
            $data['chat_name']	 =  $this->config['sy_chat_name'];
            $data['mapkey']      =  !empty($this->config['sy_chat_mapkey']) ? 1 : 2;
            
            include_once(CONFIG_PATH.'db.data.php');
            $data['spview_web']  =  isset($arr_data['modelconfig']['spview']) && isset($this->config['sy_spview_web']) ? $this->config['sy_spview_web'] : 2;
            if ($this->platform == 'ios' && $_POST['provider'] == 'app'){
                // IOS APP 不支持视频面试
                $data['spview_web'] = 2;
            }
            
            if (!isset($this->config['sy_chat_exphone']) || (!empty($this->config['sy_chat_exphone']) && $this->config['sy_chat_exphone'] == 2)){
                $data['chat_exphone']  =  2;
            }else{
                $data['chat_exphone']  =  1;
            }
            
            if (!empty($this->config['sy_spview_appkey']) && !empty($this->config['sy_spview_appsecret']) && $member['usertype'] == 2 && $this->plat == 'app'){
                // 处理视频面试所需参数
                $data['spinfo']  =  array(
                    'name'    =>  $to['mine']['username'],
                    'logo'    =>  $to['mine']['avatar'],
                    'myname'  =>  $chat['mine']['username'],
                    'mylogo'  =>  $chat['mine']['avatar']
                );
                $trtcM  =  $this->MODEL('trtc');
                $trtc   =  $trtcM->getUserSig(array('uid'=>$member['uid'], 'fuid'=>$toid, 'usertype'=>$member['usertype']));
                
                if(!empty($trtc['appid'])){
                    
                    $data['spinfo']['sdkAppId']   =  $trtc['appid'];
                    $data['spinfo']['userSig']    =  $trtc['usersig'];
                    $data['spinfo']['roomId']     =  $trtc['roomid'];
                    $data['spinfo']['commentID']  =  $trtc['wid'] .'_'.$toid;
                    $data['spinfo']['userId']     =  $trtc['wid'] .'_'.$member['uid'];
                    $data['spinfo']['spWait']     =  $this->config['sy_spview_wait'];
                    $data['spinfo']['spLong']     =  $this->config['sy_spview_time'];
                }else{
                    $data['spinfo']  =  $trtc;
                }
            }
            // 招呼
            $type = $member['usertype'] == 1 ? 4 : 3;
            $greeting = $chatM->getUsefulSet(array('type'=>$type, 'orderby'=>'sort'));
            $data['greeting'] = $greeting['content'];
            
            $data['concheck'] = isset($this->config['sy_chat_concheck']) ? $this->config['sy_chat_concheck'] : 0;
            
            $this->render_json(0, 'ok', $data);
        }
    }
    //开始聊天，先发个信息作为开始
    function beginChat_action()
    {
        $member  =  $this->yztoken($_POST['uid'], $_POST['token']);
            
        $data   =  array(
            'toid'       =>  $member['uid'],
            'fromid'     =>  (int)$_POST['id'],
            'tusertype'  =>  $member['usertype'],
            'fusertype'  =>  $_POST['usertype'],
            'jobid'      =>  $_POST['jobid'],
            'jobtype'    =>  $_POST['jobtype'],
            'timestamp'  =>  $_POST['timestamp']
        );
        $chatM   =  $this->MODEL('chat');
        
        $return  =  $chatM -> beginChat($data);
        
        $this->render_json(0, 'ok', $return);
    }
    function chatRight_action(){
        $this->render_json(1, 'ok');
    }
    //添加聊天发送记录
    function chatLog_action()
    {
        $member  =  $this->yzToken($_POST['uid'],$_POST['token']);
        
        $uid     =  intval($_POST['to']);
        $chatM   =  $this -> MODEL('chat');
        //条件聊天判断时否有和个人聊天的权利
        //条件聊天判断时否有和个人聊天的权利
        $tcarr = array(
            'uid'      => $member['uid'],
            'spid'     => $member['spid'],
            'username' => $member['username'],
            'usertype' => $member['usertype'],
            'chatid'   => $uid
        );
        $comtcM  =  $this->MODEL('comtc');
        $res     =  $comtcM->chatRight($tcarr);
        
        if ($res['error'] == 0){
            $arr     =  array(
                'toid'       =>  $_POST['to'],
                'tusertype'  =>  $_POST['totype'],
                'fromid'     =>  $member['uid'],
                'fusertype'  =>  $member['usertype'],
                'content'    =>  $_POST['content'],
                'timestamp'  =>  $_POST['timestamp'],
                'msgtype'    =>  $_POST['msgtype'],
                'nowid'      =>  $member['uid'],
                'nowtype'    =>  $member['usertype'],
                'source'     =>  $_POST['source'],
                'action'     =>  'chatlog'
            );
            if($_POST['source']==13 && isset($_POST['code']) && $this->config['sy_chat_concheck']==2){
                
                $getdata  =  $this->getOpenid($_POST['code']);
                
                if(isset($getdata['errcode'])){
                    $this->MODEL('errlog')->addErrorLog($member['uid'], 10, 'wxapp聊天内容安全检测获取openid错误。code:'.$_POST['code'].'。'.$getdata['errcode'].'，'.$getdata['errmsg']);
                }else{
                    $arr['openid']  =  $getdata['openid'];
                }
            }
            
            $return  =  $chatM -> chatLog($arr);
        }else{
            $return  =  $res;
        }
        $this->render_json(0, 'ok', $return);
    }
    /**
     * 聊天记录分页
     */
    function getChatPage_action()
    {
        $member  =  $this->yzToken($_POST['uid'], $_POST['token']);
        
        $arr    =  array(
            'toid'       =>  $_POST['id'],
            'tusertype'  =>  $_POST['totype'],
            'fromid'     =>  $member['uid'],
            'fusertype'  =>  $member['usertype'],
            'page'       =>  $_POST['page'],
            'lastid'     =>  $_POST['lastid']
        );
        
        $chatM   =  $this -> MODEL('chat');
        
        $return  =  $chatM -> getChatPage($arr);
        
        foreach($return['data'] as $k=>$v){

            if($v['msgtype']=='char'){

                $content  =  preg_replace_callback("/face\[([^\s\[\]]+?)\]/", array($this, 'faces'), $v['content']);
                $c = explode('#==#', $content);
                $carr = array();

                foreach ($c as $cv){
                    $cv = trim($cv);
                    if (!empty($cv)){
                      if (stripos($cv, $this->config['sy_weburl'].'/js/im/emoji_') !== false){
                          $carr[] = array(
                              't'=>'image',
                              'n'=>$cv
                          );
                      }else{
                          $carr[] = array(
                              't'=>'char',
                              'n'=>$cv
                          );
                      }
                  }
                }
                $return['data'][$k]['content'] = $carr;
            }
            
        }

        $this->render_json(0, 'ok', $return);
    }
    /**
     * 判断简历是否被下载
     */
    function getdown_action()
    {
        $member  =  $this->yzToken($_POST['uid'], $_POST['token']);
        
        $arr   =  array(
            'eid'         =>  $_POST['eid'],
            'toid'        =>  $_POST['toid'],
            'fromid'      =>  $member['uid'],
            'fusertype'   =>  $member['usertype'],
            'nowtype'     =>  $member['usertype'],
            'zid'         =>  intval($_POST['zid'])
        );
        if (!empty($member['spid'])){
            $arr['spid']    =   $member['spid'];
        }
        
        $chatM  =  $this->MODEL('chat');
        
        $return  =  $chatM -> comToChat($arr);
        
        $this->render_json(0, 'ok', $return);
    }
    /**
     * 发送图片信息
     */
    function uploadImage_action()
    {
        $UploadM  =  $this -> MODEL('upload');
        
        $upArr  =  array(
            'file' =>  $_FILES['photos'],
            'dir'  =>  'chat'
        );
        $result  =  $UploadM->newUpload($upArr);
        
        if (!empty($result['msg'])){
            $this->render_json(1, $result['msg'], array());
        }else{
            
            $pic  =  $result['picurl'];
            
            $result['picurl']  =  checkpic($pic);
            
            $this->render_json(0, 'ok', array('url'=>$result['picurl']));
        }
    }
    //条件聊天时，判断个人是否有简历，并判断是否申请过该企业职位/已被企业邀请面试
    function isResume_action()
    {
        
        $member  =  $this->yzToken($_POST['uid'], $_POST['token']);
        
        $arr  =  array(
            'uid'       =>  $member['uid'],
            'usertype'  =>  $member['usertype'],
            'comid'     =>  $_POST['id'],
            'jobtype'   =>  $_POST['jobtype'],
            'jobid'     =>  $_POST['jobid'],
            'nowtype'   =>  $member['usertype']
        );
        
        $chatM  =  $this->MODEL('chat');
        
        $return  =  $chatM -> userToChat($arr);
        
        $this->render_json(0, 'ok', $return);
    }
    // 收到消息即设为已读
    function setMsgStatus_action()
    {
        $member  =  $this->yztoken($_POST['uid'], $_POST['token']);
        
        $chatM   =  $this -> MODEL('chat');
        
        $arr     =  array(
            'toid'       =>  $member['uid'],
            'fromid'     =>  $_POST['id'],
            'tusertype'  =>  $member['usertype'],
            'fusertype'  =>  $_POST['type'],
            'nowid'      =>  $member['uid'],
            'nowtype'    =>  $member['usertype']
        );
        
        $return  =  $chatM->setMsg($arr);
        $this->render_json(0, 'ok', $return);
    }
    // 由简历/职位详情页进入,发预定消息
    function prepare_action()
    {
        $member  =  $this->yztoken($_POST['uid'], $_POST['token']);
        
        $pArr   =  array(
            'uid'       =>  $member['uid'],
            'usertype'  =>  $member['usertype'],
            'toid'      =>  intval($_POST['toid']),
            'totype'    =>  intval($_POST['totype'])
        );
        
        $chatM  =  $this->MODEL('chat');
        
        $list   =  $chatM -> getPrepare($pArr);
        
        $this->render_json(0, 'ok', $list);
    }
    // 不感兴趣
    function delChatLog_action()
    {
        $member  =  $this->yzToken($_POST['uid'], $_POST['token']);
        
        $arr = array(
            'toid'      => $_POST['to'],
            'tusertype' => $_POST['type'],
            'fromid'    => $member['uid'],
            'fusertype' => $member['usertype']
        );
        
        $chatM  =  $this->MODEL('chat');
        $chatM->delChatLog($arr);
        
        $this->render_json(0, 'ok');
    }
    /**
     * 用户不在线，收到消息，提醒用户
     */
    function unSend_action()
    {
        $member  =  $this->yzToken($_POST['uid'], $_POST['token']);
        $chatM   =  $this -> MODEL('chat');
        
        $arr     =  array(
            'fromid'    =>  $member['uid'],
            'fusertype' =>  $member['usertype'],
            'toid'      =>  $_POST['toid'],
            'tusertype' =>  $_POST['totype'],
            'nowtype'	=>  $_POST['nowtype'],
            'port'		=>	$this->plat == 'mini' ? '3' : '4'
        );
        
        $return  =  $chatM->setUnSend($arr);
        $this->render_json(0, 'ok');
    }
    //上传语音
    function upVoice_action(){
        
        if($_FILES['voice']['tmp_name']){
            $member  =  $this->yzToken($_POST['uid'],$_POST['token']);


            $UploadM  =  $this -> MODEL('upload');
        
            $upArr  =  array(
                'file' =>  $_FILES['voice'],
                'dir'  =>  'voice'
            );
            $result  =  $UploadM->voiceUpload($upArr);
            
            if (!empty($result['msg'])){

                $this->render_json(0,'',$result);
                
            }else{
                if ($result['voiceurl'] && $_POST['to']){
                    
                    $voiceDir     =   $result['voiceurl'];

                    $content      =   'voice['.checkpic($voiceDir).']';

                    $arr     =  array(
                        'toid'       =>  $_POST['to'],
                        'tusertype'  =>  $_POST['totype'],
                        'fromid'     =>  $member['uid'],
                        'fusertype'  =>  $member['usertype'],
                        'content'    =>  $content,
                        'timestamp'  =>  $_POST['timestamp'],
                        'msgtype'    =>  $_POST['msgtype'],
                        'nowid'      =>  $member['uid'],
                        'nowtype'    =>  $member['usertype'],
                        'voicelength'=>  $_POST['voicelength']
                    );
                    
                    $chatM   =  $this -> MODEL('chat');
                    
                    $return  =  $chatM -> chatLog($arr);
                    
                    $return['content'] = $content;
                }
            }    
        }else{
            $return['error'] = 2;
            $return['errmsg'] = '录音失败，请重试';
        }

        $this->render_json(0, 'ok', $return);
        
    }
    function setVoiceStatus_action()
    {
        $member =  $this->yztoken($_POST['uid'], $_POST['token']);
        
        $chatM  =  $this -> MODEL('chat');
        
        $toid   =  intval($_POST['id']);

        $chatid =   intval($_POST['chatid']);
        
        $arr     =  array(
            'id'            =>  $chatid,
            'fromid'        =>  $toid,
            'fusertype'     =>  $_POST['totype'],
            'toid'          =>  $member['uid'],
            'tusertype'     =>  $member['usertype'],
            'nowid'         =>  $member['uid'],
            'nowtype'       =>  $member['usertype'],
        );
        $return = $chatM -> setVoiceStatus($arr);

        $this->render_json(0, 'ok', $return);
    }
    /**
     * 宣讲会聊天发言检测,并保存聊天记录
     */
    function checkdata_action(){
        
        $member	 =	$this->yzToken($_POST['uid'],$_POST['token']);
        
        $return  =  array();
        
        $xjhM   =  	$this -> MODEL('xjhlive');
        
        $xjh	=	$xjhM -> getInfo(array('id'=>$_POST['xjhid']),array('field'=>'`id`'));
        
        if(!empty($xjh)){
            
            $chatM     =  $this->MODEL('chat');
            $blacknum  =  $chatM->getXjhchatBlackNum(array('uid'=>$member['uid'],'xid'=>$xjh['id']));
            
            if ($blacknum > 0){
                
                $this->render_json(-1, '您已被禁言');
                
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
                        'fuid'       =>  $member['uid'],
                        'fusertype'  =>  $member['usertype'],
                        'ip'         =>  fun_ip_get(),
                        'content'    =>  $_POST['content'],
                        'timestamp'  =>  $_POST['timestamp'],
                        'msgtype'    =>  'char',
                        'xjhid'      =>  $_POST['xjhid']
                    );
                    $chatM   =  $this->MODEL('chat');
                    $chatM->xhjChat($arr);
                    
                    $return['msgcontent']	=	$content;
                    
                    if ($member['usertype'] == 1){
                        // 个人用户，发送时不完全展示姓名
                        $resumeM  =  $this->MODEL('resume');
                        $resume   =  $resumeM->getResumeInfo(array('uid'=>$this->member['uid']),array('field'=>'`name`,`sex`'));
                        
                        $return['nickname']  =  $resume['sex'] == 1 ? mb_substr($resume['name'], 0, 1, 'utf-8').'先生' : mb_substr($resume['name'], 0, 1, 'utf-8').'女士';
                    }
                }else{
                    
                    $return['msgcontent']	=	'';
                }
            }
        }
        
        $this->render_json(0, 'ok', $return);
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
            $list[$k]['msgtype']    =   'char';
            $list[$k]['xjhid']      =   'xjh_'.$_POST['xjhid'];
            $list[$k]['xid']        =   $_POST['xjhid'];
            $list[$k]['chatid']     =   $v['id'];
            // 处理表情内容
            $content  =  preg_replace_callback("/face\[([^\s\[\]]+?)\]/", array($this, 'faces'), $v['content']);
            $c = explode('#==#', $content);
            $carr = array();
            
            foreach ($c as $cv){
                $cv = trim($cv);
                if (!empty($cv)){
                    if (stripos($cv, $this->config['sy_weburl'].'/js/im/emoji_') !== false){
                        $carr[] = array(
                            't'=>'image',
                            'n'=>$cv
                        );
                    }else{
                        $carr[] = array(
                            't'=>'char',
                            'n'=>$cv
                        );
                    }
                }
            }
            $list[$k]['content']    =   $carr;
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
        $this->render_json(0, 'ok', $result);
    }
    /**
     * 用于正则替换表情图片
     */
    function faces($matches){
        
        $alt = array(
            1=>'face[龇牙]',2=>'face[调皮]',3=>'face[流汗]',4=>'face[偷笑]',5=>'face[再见]',6=>'face[敲打]',7=>'face[擦汗]',8=>'face[流泪]',9=>'face[大哭]',10=>'face[嘘]',11=>'face[酷]',12=>'face[抓狂]',13=>'face[可爱]',14=>'face[色]',15=>'face[害羞]',16=>'face[得意]',17=>'face[吐]',18=>'face[微笑]',19=>'face[怒]',20=>'face[尴尬]',21=>'face[惊恐]',22=>'face[冷汗]',23=>'face[白眼]',24=>'face[傲慢]',25=>'face[难过]',26=>'face[惊讶]',27=>'face[疑问]',28=>'face[么么哒]',29=>'face[困]',30=>'face[憨笑]',31=>'face[撇嘴]',32=>'face[阴险]',33=>'face[奋斗]',34=>'face[发呆]',35=>'face[左哼哼]',36=>'face[右哼哼]',74=>'face[抱抱]',37=>'face[坏笑]',38=>'face[鄙视]',39=>'face[晕]',40=>'face[可怜]',41=>'face[饥饿]',42=>'face[咒骂]',43=>'face[折磨]',44=>'face[抠鼻]',45=>'face[鼓掌]',46=>'face[糗大了]',47=>'face[打哈欠]',48=>'face[快哭了]',49=>'face[吓]',50=>'face[闭嘴]',51=>'face[大兵]',52=>'face[委屈]',53=>'face[NO]',54=>'face[OK]',56=>'face[弱]',57=>'face[强]',60=>'face[握手]',63=>'face[胜利]',58=>'face[抱拳]',66=>'face[凋谢]',99=>'face[米饭]',108=>'face[蛋糕]',112=>'face[西瓜]',70=>'face[啤酒]',89=>'face[瓢虫]',62=>'face[勾引]',82=>'face[爱你]',69=>'face[咖啡]',72=>'face[月亮]',68=>'face[刀]',55=>'face[差劲]',59=>'face[拳头]',65=>'face[便便]',79=>'face[炸弹]',107=>'face[菜刀]',82=>'face[心碎了]',83=>'face[爱心]',71=>'face[太阳]',97=>'face[礼物]',92=>'face[皮球]',137=>'face[骷髅]',123=>'face[闪电]',80=>'face[猪头]',67=>'face[玫瑰]',98=>'face[篮球]',64=>'face[乒乓]',101=>'face[红双喜]',139=>'face[麻将]',73=>'face[彩带]',61=>'face[爱你]',95=>'face[示爱]',111=>'face[衰]',109=>'face[蜡烛]'
        );
        
        $faces  =  array_flip($alt);
        $imgid  =  $faces[$matches[0]];
        
        if (!empty($imgid)){
            
            $return  =  '#==#'.$this->config['sy_weburl'].'/js/im/emoji_'. $imgid .'@2x.png#==#';
            
        }else{
            
            $return  =  '';
        }
        return $return;
    }

    function checkCanAsk_action(){

        $member  =  $this->yzToken($_POST['uid'],$_POST['token']);

        $chatM  =   $this->MODEL('chat');

        $data   =   array(
            'uid'       =>  $member['uid'],
            'usertype'  =>  $member['usertype'],
            'toid'      =>  intval($_POST['toid']),
            'totype'    =>  intval($_POST['totype']),
            'ask'       =>  $_POST['ask'],
            'askvalue'  =>  $_POST['askvalue'],
        );

        $return =   $chatM->checkCanAsk($data);
        echo json_encode($return);
    }

    function confirmAsk_action(){

        $member  =  $this->yzToken($_POST['uid'],$_POST['token']);

        $data['uid']        = $member['uid'];
        $data['usertype']   = $member['usertype'];
        $data['toid']       = $_POST['toid'];
        $data['totype']     = $_POST['totype'];
        $data['ask']        = $_POST['ask'];
        $data['askvalue']   = $_POST['askvalue'];
        $data['chatid']     = $_POST['chatid'];
        $chatM  =   $this->MODEL('chat');
        $return =   $chatM->confirmAsk($data);

        echo json_encode($return);
    }
    function refuseAsk_action(){

        $member  =  $this->yzToken($_POST['uid'],$_POST['token']);
        
        $data['uid']        = $member['uid'];
        $data['usertype']   = $member['usertype'];
        $data['toid']       = $_POST['toid'];
        $data['totype']     = $_POST['totype'];
        $data['ask']        = $_POST['ask'];
        $data['chatid']     = $_POST['chatid'];
        $chatM  =   $this->MODEL('chat');
        $return =   $chatM->refuseAsk($data);

        echo json_encode($return);
    }
    // 视频面试操作记录聊天记录
    function spviewChat_action(){
        
        $member  =  $this->yzToken($_POST['uid'],$_POST['token']);
        
        if ($_POST['to']){
            $arr     =  array(
                'content'    =>  $_POST['content'],
                'timestamp'  =>  $_POST['timestamp'],
                'msgtype'    =>  'spview'
            );
            if ($_POST['content'] == 'refused'){
                // 拒绝视频，发送方改为对方
                $arr['toid']       =  $member['uid'];
                $arr['tusertype']  =  $member['usertype'];
                $arr['fromid']     =  $_POST['to'];
                $arr['fusertype']  =  $_POST['totype'];
                $arr['nowid']      =  $_POST['to'];
                $arr['nowtype']    =  $_POST['totype'];
            }elseif ($_POST['content'] == 'closesp'){
                // 取消视频，发送方改为自己
                $arr['toid']       =  $_POST['to'];
                $arr['tusertype']  =  $_POST['totype'];
                $arr['fromid']     =  $member['uid'];
                $arr['fusertype']  =  $member['usertype'];
                $arr['nowid']      =  $member['uid'];
                $arr['nowtype']    =  $member['usertype'];
            }
            
            $chatM   =  $this -> MODEL('chat');
            
            $return  =  $chatM -> chatLog($arr);
            
            $this->render_json(0, 'ok');
        }
    }
    // 未登录用户获取聊天登录参数
    function getUnloginToken_action(){
        
        if (isset($_POST['uid']) && isset($_POST['token'])){
            $member  =  $this->yzToken($_POST['uid'],$_POST['token']);
        }else{
            $member  =  array();
        }
        $csM   =  $this->MODEL('chatcs');
        $data  =  $csM->getUnloginToken('wxapp',$member);
        
        $this->render_json(0, 'ok', $data);
    }
    // 会员中心查询聊天对象列表
    function getmh_action(){
        
        if ($this->config['sy_chat_open']==1){
            $member  =  $this->yzToken($_POST['uid'],$_POST['token']);
            
            $chatM    =  $this->MODEL('chat');
            
            $history  =  $chatM->getHistory($member['uid'],$member['usertype'], intval($_POST['page']), 0, $_POST['chatCate']);
            
            if (!empty($history)){
                $this->render_json(0, 'ok', $history);
            }else{
                $this->render_json(1, 'no data');
            }
        }
    }
    // 常用语保存
    function usefulSave_action(){
        
        $member  =  $this->yzToken($_POST['uid'],$_POST['token']);
        if(trim($_POST['content'])==''){
            $this->render_json(0, 'ok',array('errcode'=>8,'msg'=>'请填写常用语'));
        }
        $data = array(
            'uid'      => $member['uid'],
            'usertype' => $member['usertype'],
            'content'  => trim($_POST['content'])
        );
        
        $chatM  =  $this->MODEL('chat');
        
        if (empty($_POST['id'])){
            $res  =  $chatM->addChatUseful($data);
        }else{
            $res  =  $chatM->upChatUseful(array('id'=>$_POST['id']), $data);
        }
        $this->render_json(0, 'ok', $res);
    }
    // 常用语列表
    function getUseful_action(){
        
        $member  =  $this->yzToken($_POST['uid'],$_POST['token']);
        
        $chatM  =  $this->MODEL('chat');
        $res    = $chatM->getChatUsefulList(array('uid'=>$member['uid'],'usertype'=>$member['usertype']), array('utype'=>'user'));
        
        $this->render_json(0, 'ok', $res);
    }
    // 删除常用语
    function delUseful_action(){
        
        $member  =  $this->yzToken($_POST['uid'],$_POST['token']);
        
        $chatM  =  $this->MODEL('chat');
        $res    =  $chatM->delChatUseful(array('id'=>$_POST['id'],'uid'=>$member['uid'],'usertype'=>$member['usertype']));
        
        $this->render_json(0, 'ok', $res);
    }
    function reportSave_action(){

        $member  =  $this->yzToken($_POST['uid'],$_POST['token']);

        $toid   = intval($_POST['toid']);
        $totype = intval($_POST['totype']);

        if($toid && $totype){

            if(trim($_POST['content'])==''){
                $return = array('msg'=>'请填写举报内容','errcode'=>8);
                $this->render_json(0, 'ok', $return);
            }

            $reportM    =   $this->MODEL('report');

            $reported   =       $reportM->getReportOne(array('p_uid'=>$member['uid'],'usertype'=>$member['usertype'],'c_uid'=>$toid,'c_usertype'=>$totype,'type'=>4,'status'=>0));

            if(!empty($reported)){
                $return = array('msg'=>'您已举报该用户','errcode'=>8);
                $this->render_json(0, 'ok', $return);
            }

            $userinfoM  =   $this->MODEL('userinfo');
            $user       =   $userinfoM->getUserInfo(array('uid'=>$toid),array('usertype'=>$totype));
            if($totype==1 || $totype==2){
                $r_name =   $user['name'];
            }else if($totype==3){
                $r_name =   $user['realname'];
            }

            
            $rData      =   array(
                'did'       =>  $member['did'],
                'p_uid'     =>  $member['uid'],
                'usertype'  =>  $member['usertype'],
                'c_uid'     =>  $toid,
                'c_usertype'=>  $totype,
                'inputtime' =>  time(),
                'username'  =>  $member['username'],
                'r_name'    =>  $r_name,
                'r_reason'  =>  trim($_POST['content']),
                'type'      =>  4
            );

            $new_id     =   $reportM -> addChatReport($rData);
            if($new_id){
                $this ->MODEL('log') ->addMemberLog($member['uid'],$member['usertype'], '举报聊天对象', 23, 1);
                $return = array('msg'=>'举报成功','errcode'=>9);
            }
        }else{
            $return = array('msg'=>'数据异常，请重试','errcode'=>8);
        }
        $this->render_json(0, 'ok', $return);
        
    }
    // 查询单个职位
    function getJob_action(){
        
        $member  =  $this->yzToken($_POST['uid'],$_POST['token']);
        
        $jobM    =  $this->MODEL('job');
        $job     =  $jobM->getInfo(array('id'=>$_POST['jobid']),array('field'=>'id,name,com_name,job1,job1_son,job_post,provinceid,cityid,three_cityid,exp,edu,minsalary,maxsalary'));
        
        $this->render_json(0, 'ok', $job);
    }
}
?>