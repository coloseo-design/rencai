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
class spviewadd_controller extends company
{

    function index_action()
    {
        $statics = $this->public_action();
        
        if ($statics['spviewNum'] == 0) { // 会员过期
            
            if($this->spid){
                
                $this->ACT_msg('index.php', '当前账号会员已到期，请联系主账号进行升级！', 8);
            }else{
                
                $this->ACT_msg('index.php?c=right', '你的会员已到期！', 8);
            }
        }
        
        if ($statics['spviewNum'] == 2) { // 会员套餐已用完
            
            if ($this->config['integral_spview'] != '0') {
                if($this->spid){
                    
                    $this->ACT_msg('index.php', '您的套餐数据已用完，请联系主账号进行分配！', 8);
                }else{
                    
                    $this->ACT_msg('index.php?c=right', '你的套餐已用完！', 8);
                }
            } else {
                if($this->spid){
                    $this->MODEL('statis')->upInfo(array('spview_num' => '1'), array('uid' => $this->spid, 'usertype' => '2'));
                }else{
                    $this->MODEL('statis')->upInfo(array('spview_num' => '1'), array('uid' => $this->uid, 'usertype' => '2'));
                }
            }
        }
        
        $cacheArr   =   $this->MODEL('cache')->GetCache(array('user'));

        $jobM       =   $this->MODEL('job');

        $jobwhere   =   array(
            'uid'       =>  $this->uid,
            'state'     =>  1,
            'status'    =>  0,
            'r_status'  =>  1
        );
        
        $List    =   $jobM->getList($jobwhere,array('field'=>'`name`,`id`'));

        foreach ($List['list'] as $key => $value) {
           $jobArr[$value['id']] = $value['name'];

        }
        $this->yunset('job',$jobArr);
        $this->yunset($cacheArr);
        $this->com_tpl('spshow');
    }

    function edit_action()
    {
        $this->public_action();

        $spviewM       =   $this->MODEL('spview');

        $id     =   intval($_GET['id']);
        
        $row    =   $spviewM->getInfo(array('id' => $id,'uid'=>$this->uid));
        
        if (empty($row)) {
            
            $this->ACT_msg('index.php?c=spviewadd', '视频面试参数错误！');
        }

        $jobM       =   $this->MODEL('job');

        $jobwhere   =   array(
            'uid'       =>  $this->uid,
            'state'     =>  1,
            'status'    =>  0,
            'r_status'  =>  1
        );
        
        $List    =   $jobM->getList($jobwhere,array('field'=>'`name`,`id`'));

        foreach ($List['list'] as $key => $value) {
            $jobArr[$value['id']] = $value['name'];
        }
      
        $this->yunset('job',$jobArr);

        $CacheArr   =   $this->MODEL('cache') -> GetCache(array('user'));
        $this->yunset($CacheArr);


        $this->yunset('row', $row);
        
        $this->com_tpl('spshow');

    }

    function save_action(){
        if ($_POST['submitBtn']) {
            
            $post   = array(
                'id'            => intval($_POST['id']),
                'uid'           => $this->uid,
                'jobid'         => trim(pylode(',', $_POST['jid'])),
                'starttime'     => strtotime($_POST['sdate']),
                'exp'           => trim($_POST['exp']),
                'edu'           => trim($_POST['edu']),
                'sex'           => trim(pylode(',', $_POST['sex'])),
                'other'         => trim(pylode(',', $_POST['other'])),
            	'remark'       	=> trim($_POST['remark']),
                'did'           => $this->userdid,
            );
            
            $spviewM   =   $this->MODEL('spview');
            
            $return =   $spviewM->addInfo($post);
            
            $this->ACT_layer_msg($return['msg'], $return['errcode'], $return['url']);

        }
    }
   
}
?>