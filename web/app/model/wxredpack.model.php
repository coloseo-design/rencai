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
class wxredpack_model extends model{
    /**
     * 添加红包发送记录
     * @param array $data
     */
    public function addInfo($data = array()){
	
	    return $this -> insert_into('wxredpack', $data);
    }
    /**
     * 修改红包发送记录
     * @param array $whereData
     * @param array $upData
     */
    public function upInfo($whereData,$upData){
	    
	    return $this -> update_once('wxredpack', $upData, $whereData);
    }
	
	//新查询所有微信红包记录
    public function getWxRedPackList($whereData,$data=array()){
		$ListNew	=	array();
		
		$List		=	$this -> select_all('wxredpack',$whereData);
		
		if(!empty( $List )){
			
			$ListNew['list']	=	$List;
		}
        
		return $ListNew;
    }
    //微信红包总函数 data type:类型 1：关注 2：绑定帐号 3：创建第一份简历 4：完善企业资料;  openid：用户wx身份id;  uid：用户ID （与openid 不会同时存在）
    public function sendRedPack($data)
    {
        if(!empty($data['type']) && $this->config['sy_wxredpack_isopen'.$data['type']]=='1'){
            
            $type  =  intval($data['type']);
            
            if($data['openid']){
                
                $openid  =  $data['openid'];
                
            }else{
                if(!empty($data['uid'])){//判断是否传入UID 根据UID 获取用户绑定的openid
                    
                    $uid     =  intval($data['uid']);
                    
                    $userWx  =  $this -> select_once('member', array('uid'=>$uid), 'wxid,username,usertype');
                    
                    if($userWx['wxid']){
                        
                        $openid  =  $userWx['wxid'];
                        
                    }
                    
                }else{
                    
                    return array('msg'=>'请选择要发红包的用户');
                }
            }
                //红包需要微信支付 则该公众号必定是已经认证 拥有获取用户资料接口权限
                if(!empty($openid)){
                    //获取用户真实资料
                    require_once 'weixin.model.php';
                    
                    $wxM         =  new weixin_model($this->db, $this->def);
                    
                    $wxUserInfo  =  $wxM -> getWxUser($openid);
                    
                    //根据传入类型判断该用户是否处于第一次获取红包状态
                    $wxRedPack   = $this -> select_once('wxredpack', array('re_openid'=>$openid,"type"=>$type), '`id`,`status`');
                    
                    //如status 不为1 则该用户未接受过该类型红包或红包发放失败
                    if($wxRedPack['status'] != '1'){
                        //获取红包对应的参数 金额 发放人
                        $wxRedPackArr['openid']        =  $openid;//微信用户身份ID
                        $wxRedPackArr['send_name']     =  $this->config['sy_wxredpack_nick'];//红包发送者名称
                        $wxRedPackArr['total_amount']  =  intval($this->config['sy_wxredpack_money'.$type]*100);//发放金额
                        $wxRedPackArr['mch_billno']    =  time().rand(1000,9999);//当前红包订单ID 自定义生成
                        $wxRedPackArr['client_ip']     =  $this->config['sy_wxredpack_ip'];//服务器IP
                        $wxRedPackArr['wishing']       =  $this->config['sy_wxredpack_wishing'.$type];//服务器IP
                        $wxRedPackArr['act_name']      =  $this->config['sy_wxredpack_actname'.$type];//活动名称
                        $wxRedPackArr['remark']        =  $this->config['sy_wxredpack_remark'];//红包备注
                        $wxRedPackArr['scene_id']      =  intval($this->config['sy_wxredpack_pro'.$type]);//发放场景
                        //调用红包接口类
                        include(LIB_PATH."ApiWxHb.class.php");
                        
                        $wxHb     =  new ApiWxHb();
                        
                        $wxHbMsg  =  $wxHb -> sendHb($wxRedPackArr);
                        
                        //红包记录存入数据库
                        if($wxHbMsg['result_code'] == 'SUCCESS'){
                            
                            $wxRedInfo['status'] = '1';
                            
                        }else{
                            
                            $wxRedInfo['status'] = '0';
                        }
                        $wxRedInfo['msg']           =  $wxHbMsg['return_msg'];
                        $wxRedInfo['orderid']       =  $wxRedPackArr['mch_billno'];//订单号
                        $wxRedInfo['re_openid']     =  $openid;//用户身份标识
                        $wxRedInfo['re_nick']       =  $wxUserInfo['nickname'];//用户昵称
                        $wxRedInfo['total_amount']  =  $wxRedPackArr['total_amount']/100;//发放金额
                        $wxRedInfo['wishing']       =  $wxRedPackArr['wishing'];//红包祝福语
                        $wxRedInfo['type']          =  $type;//发放类型
                        $wxRedInfo['time']          =  time();//红包祝福语
                        $wxRedInfo['uid']           =  $uid;
                        $wxRedInfo['username']      =  $userWx['username'];
                        $wxRedInfo['usertype']      =  $userWx['usertype'];
                        
                        if(empty($wxRedPack)){
                            
                            $this -> addInfo($wxRedInfo);
                        }else{
                            
                            $this -> upInfo(array('re_openid'=>$openid), array('status'=>$wxRedInfo['status'],'msg'=>$wxHbMsg['return_msg']));//更新原有纪录
                        }
                    }
                }
        }
    }
}
?>