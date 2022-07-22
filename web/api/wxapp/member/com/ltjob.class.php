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

class ltjob_controller extends com_controller
{
    function joblist_action()
    {
        $where = array(
            'uid'      => $this->member['uid'],
            'usertype' => $this->member['usertype']
        );
        
        $ltjobM		    =	$this -> MODEL('lietoujob');
        $data['total']  =   $ltjobM->getLtjobNum($where);
        
        $page   =  isset($_POST['page']) ? $_POST['page'] : 1;
        $limit  =  isset($_POST['limit']) ? $_POST['limit'] : 10;
        
        if ($page) {//分页
            
            $pagenav        =   ($page - 1) * $limit;
            $where['limit'] =   array($pagenav, $limit);
        } else {
            
            $where['limit'] =   $limit;
        }
        $where['orderby']  =  'lastupdate';
        
        $rows  =  $ltjobM->getList($where);
        
        $data['list']   =   count($rows) > 0 ? $rows : array();
        
        $this->render_json(1, 'ok', $data);
    }
    /**
     * 刷新猎头职位
     */
    function ltjobRefresh_action()
    {
        
        $ids    =   intval($_POST['ltjobid']);
        
        if (empty($ids)) {
            
            $this->render_json(1, '没有招聘中的职位');
        }
        
        $this->company_statis($this->member['uid']);
        
        //检查是否达到每日最大操作次数
        $result     =   $this->day_check($this->member['uid'], 'refreshjob');
        if ($result['status'] != 1) {
            
            $this->render_json(2, $result['msg']);
        }

        $refresh['ltjobid']     =   $ids;
        $refresh['uid']         =   $this->member['uid'];
        $refresh['usertype']    =   $this->member['usertype'];
        
        if (!empty($this->member['spid'])) {
            $refresh['spid']    =   $this->member['spid'];
        }
        if (isset($_POST['provider'])) {

            if ($_POST['provider'] == 'wap') {

                $refresh['port']    =   2;
            } elseif ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'toutiao' || $_POST['provider'] == 'weixin') {

                $refresh['port']    =   3;
            } elseif ($_POST['provider'] == 'app') {

                $refresh['port']    =   4;
            }
        }
        
        $comtcM =   $this->MODEL('comtc');
        $return =   $comtcM->refresh_ltjob($refresh);
        
        if (isset($return['msg']) && !empty($return['msg'])) {
            
            $return['msg'] =    strip_tags($return['msg']);
        }
        if ($return['status'] == 1) {
            
            $this->render_json(0, $return['msg']);
        } else if ($return['status'] == 2) {
            
            $this->render_json(3, $return['msg'], $return);
        } else {
            
            $this->render_json(4, $return['msg']);
        }
    }
    // 猎头职位设置上架、下架
    function ltjobSet_action(){
        
        $ltjobM	=	$this -> MODEL('lietoujob');
        $logM	=	$this -> Model('log');
        
        if(!empty($_POST['id'])){
            $nid	=	$ltjobM -> upInfo(array('id'=>$_POST['id'],'uid'=>$this->member['uid']),array('zp_status'=>intval($_POST['status'])));
            
            if ($nid){
                $logM->addMemberLog($this->member['uid'],$this->member['usertype'],'设置猎头职位招聘状态',1,2);
                
                $this->render_json(1, '设置成功');
            }else{
                $this->render_json(-1, '设置失败');
            }
        }else{
            $this->render_json(-1, '请选择要设置的职位');
        }
    }
    // 猎头职位删除
    function ltjobdel_action(){
        
        $ltjobM   	=	$this -> MODEL('lietoujob');
        $logM	  	=	$this -> MODEL('log');
        
        $delRes	=	$ltjobM -> delLietouJob($_POST['id'],array('uid'=>$this->member['uid']));
        
        $logM->addMemberLog($this->member['uid'],$this->member['usertype'],"删除猎头职位",1,3);
        
        $this->render_json(0, $return['msg']);
    }
}