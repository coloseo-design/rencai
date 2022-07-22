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

class chat_controller extends common{
    function index_action()
    {
        if (!$this->uid || !$this->usertype){
            header('location:'.Url('wap',array('c'=>'login')));
        }
        if (!empty($_GET['type']) && $_GET['type'] == $this->usertype){
            $this->ACT_msg_wap('index.php','登录身份错误');
        }
        if (!empty($_GET['wxuid']) && $_GET['wxuid'] != $this->uid){
            $this->ACT_msg_wap('index.php','账号登录错误');
        }
        if ($this->config['sy_chat_open']==1){
            
            if (isset($_GET['id']) && isset($_GET['type']) && $this->uid && $this->usertype && $this->usertype != 4){
                
                if (substr($_GET['id'], 0, 1) == 'a'){
                    // 聊天对象是管理员
                    $uid = str_replace('a', '', $_GET['id']);
                    $this->yunset('adminChat', 1);
                }else{
                    $uid = $_GET['id'];
                }
                
                $chatM  =  $this -> MODEL('chat');
                
                $chat   =  $chatM->userinfo(array('uid'=>$uid,'usertype'=>intval($_GET['type']),'nowid'=>$this->uid,'nowtype'=>$this->usertype));
                
                $this -> yunset('receive',$chat['mine']);
                
                $br  =  $chatM->getBeginid(array('fromid'=>$uid,'toid'=>$this->uid,'fusertype'=>$chat['mine']['usertype'],'tusertype'=>$this->usertype));
                if (!empty($br['beginid'])){
                    $chatM->upChatLog(array('status'=>1),array('beginid'=>$br['beginid'],'to'=>$this->uid,'tusertype'=>$this->usertype,'status'=>2));
                }
                
                $data['nickname']  =  $chat['mine']['username'];

                $canwx  =   $chatM->getFriendCan(array('type'=>'wx','uid'=>$this->uid,'usertype'=>$this->usertype,'fid'=>$uid,'fusertype'=>$chat['mine']['usertype']));
                $cantel =   $chatM->getFriendCan(array('type'=>'tel','uid'=>$this->uid,'usertype'=>$this->usertype,'fid'=>$uid,'fusertype'=>$chat['mine']['usertype']));

                $this -> yunset('cantel',$cantel);
                $this -> yunset('canwx',$canwx);
                if($this->usertype==2){
                    $jobM  =  $this->MODEL('job');
                        
                    $num   =  $jobM->getYqmsNum(array('uid'=>$uid,'fid'=>$this->uid,'isdel'=>9));
                    
                    $this -> yunset('inviteNum',$num);
                }
                // 招呼
                $type = $this->usertype == 1 ? 4 : 3;
                $greeting = $chatM->getUsefulSet(array('type'=>$type, 'orderby'=>'sort'));
                $this->yunset('greeting', $greeting['content']);
                
                $this->data  =  $data;
                $this -> seo('chat');
                
            }
            $this -> yuntpl(array('wap/chat/wapim_yunliao'));
        }
    }
    
    function goChat_action()
    {
        
        if ($this -> config['sy_chat_open'] == 1 && !empty($this->uid) && !empty($this->usertype)){
            
            $chatM  =  $this->MODEL('chat');
            $chat   =  $chatM->userinfo(array('uid'=>$this->uid,'usertype'=>$this->usertype,'history'=>1));
            $token  =  $chatM->chatToken($this->uid);
            
            $chat['yuntoken']  =  $token;
            
            echo json_encode($chat);
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
    //添加聊天发送记录
    function chatLog_action()
    {
        $uid     =  intval($_POST['to']);
        $chatM   =  $this -> MODEL('chat');
        //条件聊天判断时否有和个人聊天的权利
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
                'source'     =>  2,
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
            echo  json_encode($return);die;
        }
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
    /**
     * 判断简历是否被下载
     */
    function getdown_action()
    {
        $arr   =  array(
            'eid'         =>  $_POST['eid'],
            'toid'        =>  $_POST['toid'],
            'fromid'      =>  $this->uid,
            'fusertype'   =>  $this->usertype,
            'nowtype'     =>  $_POST['nowtype'],
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
                'base' =>  $_POST['preview'],
                'dir'  =>  'chat'
            );
            $result  =  $UploadM->newUpload($upArr);
            
            if (!empty($result['msg'])){
                
                $return  =  array(
                    'error'  =>  2,
                    'msg'   =>  $result['msg']
                );
            }else{
                
                $pic  =  $result['picurl'];
                
                $result['picurl']  =  checkpic($pic);
                
                $return  =  array(
                    'error'  =>  1,
                    'picurl' =>  $result['picurl']
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
    function isLogin_action(){
        
        if ($this->uid && $this->usertype){
            
            $return  =  array('errcode'=>9);
        }else{
            
            $return  =  array('errcode'=>8,'msg'=>'请先登录');
        }
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
            
            $return  =  array('errcode'=>8,'msg'=>'请先登录');
        }
        echo json_encode($return);die;
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
			'port'		=>	'2'
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
            $list[$k]['caster']     =   0;
            $list[$k]['content']    =   $v['content'];
            $list[$k]['msgtype']    =   'char';
            $list[$k]['xjhid']      =   'xjh_'.$_POST['xjhid'];
            $list[$k]['xid']        =   $_POST['xjhid'];
            $list[$k]['chatid']     =   $v['id'];
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
        
        if ($this->uid && $this->usertype){
            $member  =  array('uid'=>$this->uid, 'usertype'=>$this->usertype);
        }else{
            $member  =  array();
        }
        
        $csM   =  $this->MODEL('chatcs');
        $data  =  $csM->getUnloginToken('wap', $member);
        
        echo json_encode($data);
    }
    /**
     * 会员中心查询聊天对象列表
     */
    function getmh_action(){
        
        if ($this->uid  && $this->usertype){
            
            $page     =  intval(0);
            
            $chatM    =  $this->MODEL('chat');
            
            $history  =  $chatM->getHistory($this->uid, $this->usertype, $page, 0, 'all');
            
        }
        if(!empty($history)){
            echo json_encode(array('errcode'=>0,'list'=>$history));
        }else{
            echo json_encode(array('errcode'=>1));
        }
    }
    // 发送互换电话、微信请求
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
    // 同意互换微信、电话
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
    // 拒绝互换电话、微信
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
    // 常用语列表
    function getUseful_action(){
        
        $chatM  =  $this->MODEL('chat');
        $res   = $chatM->getChatUsefulList(array('uid'=>$this->uid,'usertype'=>$this->usertype), array('utype'=>'user'));
        
        echo json_encode($res);
    }
    // 删除常用语
    function delUseful_action(){
        
        $chatM  =  $this->MODEL('chat');
        $res    =  $chatM->delChatUseful(array('id'=>$_POST['id'],'uid'=>$this->uid,'usertype'=>$this->usertype));
        
        echo json_encode($res);
    }

    function reportSave_action(){
        $toid   = intval($_POST['toid']);
        $totype = intval($_POST['totype']);

        if($toid && $totype){

            if(trim($_POST['content'])==''){
                $return = array('msg'=>'请填写举报内容','errcode'=>8);
                echo json_encode($return);exit();
            }

            $reportM    =   $this->MODEL('report');

            $reported   =       $reportM->getReportOne(array('p_uid'=>$this->uid,'usertype'=>$this->usertype,'c_uid'=>$toid,'c_usertype'=>$totype,'type'=>4,'status'=>0));

            if(!empty($reported)){
                $return = array('msg'=>'您已举报该用户','errcode'=>8);
                echo json_encode($return);exit();
            }

            $userinfoM  =   $this->MODEL('userinfo');
            $user       =   $userinfoM->getUserInfo(array('uid'=>$toid),array('usertype'=>$totype));
            if($totype==1 || $totype==2){
                $r_name =   $user['name'];
            }else if($totype==3){
                $r_name =   $user['realname'];
            }

            
            $rData      =   array(
                'did'       =>  $this->config['did'],
                'p_uid'     =>  $this->uid,
                'usertype'  =>  $this->usertype,
                'c_uid'     =>  $toid,
                'c_usertype'=>  $totype,
                'inputtime' =>  time(),
                'username'  =>  $this->username,
                'r_name'    =>  $r_name,
                'r_reason'  =>  trim($_POST['content']),
                'type'      =>  4
            );

            $new_id     =   $reportM -> addChatReport($rData);
            if($new_id){
                $this ->MODEL('log') ->addMemberLog($this->uid, $this->usertype, '举报聊天对象', 23, 1);
                $return = array('msg'=>'举报成功','errcode'=>9);
            }
        }else{
            $return = array('msg'=>'数据异常，请重试','errcode'=>8);
        }

        echo json_encode($return);
    }
    // 聊天地图展示
    function map_action(){
        
        $location = $this->Convert_GCJ02_To_BD09($_GET['x'], $_GET['y']);
        $location['name'] = $_GET['name'];
        $this->yunset('location',$location);
        
        $user_agent =   (! isset($_SERVER['HTTP_USER_AGENT'])) ? FALSE : $_SERVER['HTTP_USER_AGENT'];
        
        if (($_COOKIE['mapx'] && $_COOKIE['mapx'] > 0) && ($_COOKIE['mapy'] && $_COOKIE['mapy'] > 0) && strpos($user_agent, 'Android') && is_weixin()) {
            
            $this->yunset(array('mapx' => $_COOKIE['mapx'], 'mapy' => $_COOKIE['mapy']));
            
        } else {
            
            $this->yunset(array('mapx' => 0, 'mapy' => 0));
        }
        
        $this -> yuntpl(array('wap/chat/map'));
    }
    /*
     * 中国正常GCJ02坐标---->百度地图BD09坐标
     * 腾讯地图用的也是GCJ02坐标
     * @param double $lat 纬度
     * @param double $lng 经度
     */
    function Convert_GCJ02_To_BD09($lng,$lat)
    {
        $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
        $x = $lng;
        $y = $lat;
        $z =sqrt($x * $x + $y * $y) + 0.00002 * sin($y * $x_pi);
        $theta = atan2($y, $x) + 0.000003 * cos($x * $x_pi);
        $lng = $z * cos($theta) + 0.0065;
        $lat = $z * sin($theta) + 0.006;
        return array('lng'=>$lng,'lat'=>$lat);
    }
    // 查询单个职位
    function getJob_action(){
        
        $jobM = $this->MODEL('job');
        
        $job  = $jobM->getInfo(array('id'=>$_POST['jobid']),array('field'=>'id,name,com_name,job1,job1_son,job_post,provinceid,cityid,three_cityid,exp,edu,minsalary,maxsalary'));
        
        $job['wapurl'] = Url('wap',array('c'=>'job','a'=>'comapply','id'=>$job['id']));
        
        echo json_encode($job);die;
    }
}
?>