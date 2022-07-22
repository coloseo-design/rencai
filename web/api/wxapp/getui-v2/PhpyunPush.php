<?php
require_once(dirname(__FILE__) . '/' . 'GTClient.php');

class PhpyunPush{
    private $api;
    
    function __construct($config) {
        $this->api = new GTClient(null,$config['appkey'],$config['appid'],$config['masterSecret'], $config['ssl']);
        
    }
    /**
     * 总的单推消息的接口
     * param1(推送消息)  :   ['title' => "通知标题",'content' => "通知内容" , 'payload' => "通知去干嘛这里可以自定义"]
     * param2(接收人)   :   ['cid' => "",'device_token' => "" , system=""]
     * */
    public function pushIGtMsg($msg , $to ){
        
        if($to['system'] == 1){
            $push = $this->getParamForIOS($msg);
        }else if($to['system'] == 2){
            $push = $this->getParamForAndroid($msg);
        }
        $push->setCid($to['cid']);
        $rep = $this->api->pushApi()->pushToSingleByCid($push);
        
        return $rep;
    }
    function getParamForIOS($msg){
        $push = new GTPushRequest();
        $push->setRequestId($this->micro_time());
        //设置setting
        $set = new GTSettings();
        $set->setTtl(3600000);
        //$set->setSpeed(1000);
        //$set->setScheduleTime(1591794372930);
        
        // 推送模式
        $strategy = new GTStrategy();
        $strategy->setDefault(GTStrategy::STRATEGY_THIRD_FIRST);
        //$strategy->setIos(GTStrategy::STRATEGY_GT_ONLY);
        //$strategy->setOp(GTStrategy::STRATEGY_THIRD_FIRST);
        //$strategy->setHw(GTStrategy::STRATEGY_THIRD_ONLY);
        $set->setStrategy($strategy);
        $push->setSettings($set);
        
        $notify = new GTNotification();
        $notify->setTitle($msg['title']); // 通知消息标题
        $notify->setBody($msg['content']); // 通知消息内容
        $notify->setClickType("payload");
        $notify->setPayload($msg['payload']);
        
        //设置PushMessage，
        $message = new GTPushMessage();
        $message->setNotification($notify);
        $push->setPushMessage($message);
        //$message->setDuration("1590547347000-1590633747000");
         //厂商推送消息参数
         $pushChannel = new GTPushChannel();
         //ios
         $ios = new GTIos();
         $ios->setType("notify");
         $ios->setAutoBadge("+1");
         $ios->setPayload($msg['payload']);
         //$ios->setApnsCollapseId("apnsCollapseId");
         //aps设置
         $aps = new GTAps();
         $aps->setContentAvailable(0);
         //$aps->setSound("com.gexin.ios.silenc");
         //$aps->setCategory("category");
         //$aps->setThreadId("threadId");
         
         $alert = new GTAlert();
         $alert->setTitle($msg['title']);
         $alert->setBody($msg['content']);
         
         // 多语言支持
//          $alert->setActionLocKey("ActionLocKey");
//          $alert->setLocKey("LocKey");
//          $alert->setLocArgs(array("LocArgs1","LocArgs2"));
         
         //$alert->setLaunchImage("LaunchImage"); // 指定启动界面图片名
         
//          $alert->setTitleLocKey("TitleLocKey");
//          $alert->setTitleLocArgs(array("TitleLocArgs1","TitleLocArgs2"));

         // 通知子标题,仅支持iOS8.2以上版本
//          $alert->setSubtitle("Subtitle");
//          $alert->setSubtitleLocKey("SubtitleLocKey");
//          $alert->setSubtitleLocArgs(array("subtitleLocArgs1","subtitleLocArgs2"));
         $aps->setAlert($alert);
         $ios->setAps($aps);
         
         $pushChannel->setIos($ios);
         $push->setPushChannel($pushChannel);
         
        return $push;
    }
    function getParamForAndroid($msg){
        $push = new GTPushRequest();
        $push->setRequestId($this->micro_time());
        //设置setting
        $set = new GTSettings();
        $set->setTtl(3600000);
        //$set->setSpeed(1000);
        //$set->setScheduleTime(1591794372930);
        
        // 推送模式
        $strategy = new GTStrategy();
        $strategy->setDefault(GTStrategy::STRATEGY_THIRD_FIRST);
        //$strategy->setIos(GTStrategy::STRATEGY_GT_ONLY);
        //$strategy->setOp(GTStrategy::STRATEGY_THIRD_FIRST);
        //$strategy->setHw(GTStrategy::STRATEGY_THIRD_ONLY);
        $set->setStrategy($strategy);
        $push->setSettings($set);
        //设置PushMessage，
        $message = new GTPushMessage();
        // 通知、透传、撤回三选一
       
        //通知
        $notify = new GTNotification();
        $notify->setTitle($msg['title']); // 通知消息标题
        $notify->setBody($msg['content']); // 通知消息内容
        $notify->setClickType("payload");
        $notify->setPayload($msg['payload']);
        
        // 点击跳转地址
//         $notify->setIntent("intent:#Intent;component=你的包名/你要打开的 activity 全路径;S.parm1=value1;S.parm2=value2;end");
//         $notify->setUrl("url");

        $message->setNotification($notify);
        //透传
        //$message->setTransmission($msg);
        /*
        //撤回
        $revoke = new GTRevoke();
        $revoke->setForce(true);
        $revoke->setOldTaskId("taskId");
        $message->setRevoke($revoke);
        */
        $push->setPushMessage($message);
        //$message->setDuration("1590547347000-1590633747000");
        /*
        //厂商推送消息参数
        $pushChannel = new GTPushChannel();
        
        //安卓厂商通道
        $android = new GTAndroid();
        $ups = new GTUps();
        //    $ups->setTransmission("ups Transmission");
        $thirdNotification = new GTThirdNotification();
        $thirdNotification->setTitle("title".$this->micro_time());
        $thirdNotification->setBody("body".$this->micro_time());
        $thirdNotification->setClickType(GTThirdNotification::CLICK_TYPE_URL);
        $thirdNotification->setIntent("intent:#Intent;component=你的包名/你要打开的 activity 全路径;S.parm1=value1;S.parm2=value2;end");
        $thirdNotification->setUrl("http://docs.getui.com/getui/server/rest_v2/push/");
        $thirdNotification->setPayload("payload");
        $thirdNotification->setNotifyId(456666);
        $ups->addOption("HW","badgeAddNum",1);
        $ups->addOption("OP","channel","Default");
        $ups->addOption("OP","aaa","bbb");
        $ups->addOption(null,"a","b");
        
        $ups->setNotification($thirdNotification);
        $android->setUps($ups);
        $pushChannel->setAndroid($android);
        $push->setPushChannel($pushChannel);
        */
        return $push;
    }
    
    function micro_time()
    {
        list($usec, $sec) = explode(" ", microtime());
        $time = ($sec . substr($usec, 2, 3));
        return $time;
    }
}
?>