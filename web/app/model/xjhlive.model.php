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
class xjhlive_model extends model{
    /**
     * @desc  发布/修改直播宣讲会
     * @param array $data: post-宣讲会相关字段 id-修改宣讲会Id
     * @return $return
     */
    function addXjh($data = array())
    {
        
        $post     =   $data['post'];      //  宣讲会数据相关字段
        $id       =   $data['id'];        //  更新宣讲会ID
        
        if($post){
            
            $picurlArr	=	array();
            // 处理封面图片
            if(is_array($post['pic'])){
                
                $picArr		=	$post['pic'];
                
                include_once('upload.model.php');
                $UploadM  =  new upload_model($this->db, $this->def);
                
                foreach($picArr as $pk=>$pv){
                    
                    if (!empty($pv)){
                        
                        $upArr   =  array(
                            'dir'      =>  'xjh',
                            'base'	   =>  $pv
                        );
                        
                        $result  =  $UploadM -> newUpload($upArr);
                        
                        if (!empty($result['msg'])){
                            
                            $return['msg']      =  $result['msg'];
                            $return['errcode']  =  '8';
                            
                            return $return;
                        }else if(!empty($result['picurl'])){
                            $picurlArr[]  =  $result['picurl'];
                        }
                    }
                }
            }
            unset($post['pic']);
            
            if ($post['state'] == 1){
                
                $post['statetime']  =  time();
                
            }elseif ($post['state'] == 3){
                
                $post['statetime']  =  '';
            }
            
            if (!empty($id)) {
                
                $xjh  =  $this -> select_once('xjhlive', array('id'=>$id));
                
                if ($xjh['stime'] < time()){
                    
                    $return['msg']  =  '宣讲会直播已到开始时间，不支持修改';
                    
                }else if ($xjh['livestatus'] == 3){
                    
                    $return['msg']  =  '宣讲会直播已开始，不支持修改';
                    
                }else if ($xjh['livestatus'] == 2){
                    
                    $return['msg']  =  '宣讲会直播已结束，不支持修改';
                    
                }else if ($xjh['caster'] == 2){
                    
                    $return['msg']  =  '导播台已开启，不支持修改';
                }
                if (!empty($return['msg'])){
                    
                    $return['errcode']  =  8;
                    
                    return $return;
                }
                
                $this->update_once('xjhlive', $post, array('id' => $id));
                $nid	=	$id;
                $msg    =   '更新';
            } else {
                
                $nid    =   $this->insert_into('xjhlive', $post);
                $msg    =   '发布';
            }
            if ($nid) {
                
                if(!empty($picurlArr)){
                    //插入封面多图
                    foreach($picurlArr as $xpk=>$xpv){
                        
                        $picdata	=	array(
                            'xid' 	=>	$nid,
                            'picurl'=>	$xpv,
                            'ctime'	=>	time()
                        );
                        
                        $this->insert_into('xjhlive_pic', $picdata);
                    }
                    
                }
                // 同步处理获取直播播放地址
                $result  =  $this->xjhSync($nid);
                
                if (empty($result['msg'])){
                    
                    $return =   array(
                        'id'        =>  $nid,
                        'errcode'   =>  9,
                        'msg'       =>  $msg.'直播宣讲会成功'
                    );
                }else{
                    
                    $return  =  $result;
                    
                    if (empty($id)) {
                        // 平台发布失败，清除本地记录
                        $this->delete_all('xjhlive', array('id'=>$nid));
                        $this->delete_all('xjhlive_pic', array('xid'=>$nid), '');
                    }
                }
            }
            
        }else{
            
            $return   =   array(
                'errcode' =>  8,
                'msg'     =>  '数据错误'
            );
        }
        
        return $return;
    }
    /**
     * 后台添加参会企业
     */
    public function addXjhCom($data	=	array()){
        
        if (!empty($data['comid'])){
            
            $comid  =  explode(',', $data['comid']);
            $rows   =  $this->select_all('xjhlive_com',array('xid'=>$data['xid']));
            
            if (!empty($rows)){
                
                foreach ($rows as $v){
                    
                    $xc[]  =  $v['uid'];
                }
                
                foreach ($comid as $v){
                    if (!in_array($v, $xc)){
                        
                        $new[]  =  $v;
                    }
                }
            }else{
                
                $new  =  $comid;
            }
            
            if (!empty($new)){
                
                $time       =  time();
                $valueData  =  array();
                
                foreach ($new as $k => $v){
                    
                    $valueData[$k]['uid']    =   $v;
                    $valueData[$k]['xid']    =   $data['xid'];
                    $valueData[$k]['ctime']  =   $time;
                }
                $this->DB_insert_multi('xjhlive_com', $valueData);
                
                $return['errcode']  =  9;
                $return['msg']		=  '添加成功';
                
            }else{
                
                $return['errcode']  =  8;
                $return['msg']		=  '重复添加';
            }
        }else{
            
            $return['errcode']  =  8;
            $return['msg']		=  '请选择要添加的企业';
        }
        return $return;
    }
    function upXjh($where=array(),$data=array()){
        
        if(!empty($where) && !empty($data)){
            
            $xid	=	$this->update_once('xjhlive',$data,$where);
            
            return $xid;
        }
    }

    /**
     * 获取宣讲会列表
     * @param $whereData    查询条件
     * @param string[] $data    自定义处理数组
     * @return array|bool|false|string|void
     */
    function getList($whereData,$data=array('utype'=>'')){
        
        if(!empty($whereData)){
            
            $select		=	$data['field'] ? $data['field'] : '*';
            
            $List		=	$this -> select_all('xjhlive',$whereData,$select);
            
            if(!empty($List)){
                
                foreach($List as $k=>$v){
                    
                    $xjhids[]	=	$v['id'];
                }
                $time	=	time();
                
                $pwhere	=	array(
                    'xid'		=>	array('in',pylode(',',$xjhids)),
                    'orderby' 	=>	'id,ASC'
                );
                $xjhpic   =   $this->select_all("xjhlive_pic",$pwhere);
                $picarr   =   array();
                if(!empty($xjhpic)){
                    
                    foreach($xjhpic as $pk=>$pv){
                        $picarr[$pv["xid"]][] = $pv["picurl"];
                    }
                }
                
                foreach($List as $k=>$v){
                    if (!empty($v['stime'])){
                        $List[$k]['stime_n'] 	= date('Y-m-d H:i',$v['stime']);
                    }
                    if (!empty($v['ctime'])){
                        $List[$k]['ctime_n'] 	= date('Y-m-d H:i',$v['ctime']);
                    }
                    if (!empty($v['statetime'])){
                        $List[$k]['statetime_n']= date('Y-m-d H:i',$v['statetime']);
                    }
                    $List[$k]['picarr']		=	array();
                    
                    if(!empty($picarr[$v['id']])){
                        
                        foreach($picarr[$v['id']] as $pk=>$pv){
                            
                            $picarr[$v['id']][$pk] = checkpic($pv);
                            
                        }
                        
                        $List[$k]['picarr']		=	$picarr[$v['id']];
                        $List[$k]['pic']		=	$picarr[$v['id']][0] ? $picarr[$v['id']][0] : '';
                    }
                    
                    if(isset($v['status']) && $v['status']==0){
                        $List[$k]['status_n'] 	= '未审核';
                    }else if($v['status']==1){
                        $List[$k]['status_n'] 	= '已审核';
                    }else if($v['status']==2){
                        $List[$k]['status_n'] 	= '未通过';
                    }
                    
                    if($v['livestatus']==1){
                        
                        if (!empty($v['playtime'])){
                            
                            $List[$k]['livestatus_n'] 	= '未开始';
                            
                        }else{
                            $List[$k]['livestatus_n'] 	= '未开始';
                        }
                        $List[$k]['livestatus'] = 1;
                    }else if($v['livestatus']==2){
                        
                        $List[$k]['livestatus_n'] 	= '已结束';
                        $List[$k]['livestatus'] = 2;
                    }else if($v['livestatus']==3){
                        $List[$k]['livestatus_n']  =  '直播中';
                        $List[$k]['livestatus'] = 3;
                    }
                }
                if ($data['utype'] == 'admin'){
                    
                    $List = $this->adminList($List);
                }
                
                if ($data['shortlen'] > 0){
                    foreach($List as $k=>$v){
                        if(mb_strlen($v['name'])>$data['shortlen']){
                            
                            $List[$k]['name']	    =	mb_substr($v['name'],0,$data['shortlen'],'utf-8')."...";
                            $List[$k]['name_t']	=	$v['name'];
                        }
                    }
                }
                
                if ($data['num']){
                    
                    $subList	=	$this->select_all('xjhlive_yy',array('xid'=>array('in',pylode(',',$xjhids)),'groupby'=>'xid'),'`xid`,count(*) AS `num`');
                    
                    if(!empty($subList)){
                        foreach($List as $key=>$val) {
                            
                            $subnum  =  0;
                            
                            foreach($subList as $v) {
                                
                                if($val['id']==$v['xid']){
                                    $subnum  =  $v['num'];
                                }
                            }
                            $List[$key]['subnum']	=	$subnum;
                        }
                    }
                }
            }
            return	$List;
        }
    }
    private function adminList($List){
        
        $uids  =  array();
        foreach ($List as $v){
            
            $xids[]		=	$v['id'];
            $uids[]  =  $v['uid'];
        }
        $com  =  $this->select_all('company',array('uid'=>array('in',pylode(',', array_unique($uids)))),'`uid`,`name`');
        
        $all	=	$this->select_all('xjhlive_com',array('xid'=>array('in', pylode(',', $xids)),'groupby'=>'xid'),'xid,count(*) as num');
        
        foreach($List as $k=>$v){
            
            foreach ($com as $val){
                
                if ($v['uid'] == $val['uid']){
                    
                    $List[$k]['comname']  =  $val['name'];
                }
            }
            
            if(!empty($all)){
                foreach($all as $val){
                    if($v['id'] == $val['xid']){
                        $List[$k]['comnum']	=	$val['num'];	//	 参会企业
                    }
                }
            }
        }
        return $List;
    }

    /**
     * 获取宣讲会详情
     * @param $whereData    查询条件
     * @param int[] $data   liveRecord    获取点播数据    livestatus    获取直播状态
     * @return array|bool|false|string|void
     */
    function getInfo($whereData, $data = array('liveRecord'=>0,'livestatus'=>0)){
        
        if(!empty($whereData)){
            
            $xjh	=	$this -> select_once('xjhlive', $whereData);

            if($xjh['livestatus']==1 && ($xjh['stime']+3600*$xjh['playtime'])<time()){
                // 直播宣讲会，超过预设时间后，将状态改为已结束，导播台开启的也要关掉
                if ($xjh['caster'] == 2){
                    
                    $sqlArr['caster']  =  1;
                }
                $sqlArr['livestatus']  =  2;
                $this->update_once('xjhlive',$sqlArr,$whereData);
            }
            
            $field  =  empty($data['field']) ? '*' : $data['field'];
            
            $Info   =  $this->select_once('xjhlive', $whereData, $field);
            
            if(!empty($Info)){
                
                $xjhpics	=	$this -> select_all('xjhlive_pic',array('xid'=>$Info['id']));
                $picarr		=	array();
                if(!empty($xjhpics)){
                    foreach($xjhpics as $pk=>$pv){
                        $picarr[$pk]['id'] 	 =  $pv['id'];
                        $picarr[$pk]['url']  =  checkpic($pv['picurl']);
                    }
                }
                $Info['picarr'] =	$picarr;
                if (!empty($Info['stime'])){
                    $Info['stime_n']  =  date('Y-m-d H:i',$Info['stime']);
                }
                if (!empty($Info['ctime'])){
                    $Info['ctime_n']  =  date('Y-m-d H:i',$Info['ctime']);
                }
                
                $time  =  time();
                
                // 正在直播改为手动触发，但正在直播需在直播时间内，不然依然算未开始
                if ($Info['livestatus']==3 && !empty($Info['playtime'])){
                    
                    if ($Info['stime'] > $time || ($Info['stime'] + (3600 * $Info['playtime'])) < $time){
                        
                        $Info['livestatus']  =  1;
                    }
                }
                
                if (isset($Info['caster']) && $Info['caster'] == 2 && $Info['stime'] <= $time){
                    // 开启了导播台，并且到直播开始时间
                    $Info['iscaster']  =  1;
                }else{
                    $Info['iscaster']  =  0;
                }
                if (!empty($Info['playtime'])){
                    $Info['endtime']  =  $Info['stime'] + (3600 * $Info['playtime']);
                }
                if (!empty($Info['statetime'])){
                    $Info['statetime_n']  =  date('Y-m-d H:i',$Info['statetime']);
                }
                // 直播公告
                $Info['content']    =  $this->config['sy_xjh_notice'];
                //获取所有参会企业信息
                if(isset($data['getcom'])){
                    $xjhcoms	=	$this -> select_all('xjhlive_com',array('xid'=>$Info['id']));
                    
                    if(!empty($xjhcoms)){
                        $cuid	=	array();
                        foreach($xjhcoms as $k=>$v){
                            $cuid[]  =  $v['uid'];
                        }
                        
                        require_once ('company.model.php');
                        $comM 	  =  new company_model($this->db, $this->def);
                        $comlist  =  $comM->getList(
                            array(
                                'uid'		=>	array('in',pylode(',',$cuid)),
                                'r_status'	=>	1,
                                'name'		=>	array('<>','')
                            ),
                            array('field'=>'`uid`,`content`,`name`','logo'=>'1')
                            );
                        
                        if (!empty($comlist['list'])){
                            
                            foreach ($comlist['list'] as $ck=>$cv){
                                $content = strip_tags($cv['content']);
                                if(mb_strlen($content)>100){
                                    $comlist['list'][$ck]['content']  =  mb_substr($content, 0, 100, 'UTF8').'...';
                                }else{
                                    $comlist['list'][$ck]['content']  =  $content;
                                }
                            }
                        }
                    }
                    $Info['comlist']	=	!empty($comlist['list']) ? $comlist['list'] : array();
                }
                
                if (!empty($Info['playurl'])){
                    
                    $Info['hls']  =  $Info['playurl'] . '.m3u8';
                    $Info['flv']  =  $Info['playurl'] . '.flv';
                    unset($Info['playurl']);
                }
                if (isset($data['livestatus']) && $data['livestatus'] == 1){
                    
                    if ($Info['livestatus'] == 2){
                        
                        $Info['errmsg']  =  '宣讲会直播已结束';
                    }
                }
            }
        }
        
        return $Info;
    }

    /**
     * @desc 删除宣讲会
     * @param int|array $delId
     * @param array $data: admin, zdid, uid,userdel
     */
    public function delXjh($delId = null, $data = array())
    {
        if (empty($delId)) {
            
            $return =   array(
                'errcode'   =>  8,
                'msg'       => '请选择要删除的数据！'
            );
        } else {
            
            if (is_array($delId)) {
                
                $delId  =   pylode(',', $delId);
                
                $return['layertype']    =   1;
            } else {
                
                $return['layertype']    =   0;
            }
            
            $delWhere   =   array('id' => array('in', $delId));
            
            $result =   $this->delete_all('xjhlive', $delWhere, '');
            
            if ($result) {
                
                $this->delete_all('xjhlive_black', array('xid' => array('in', $delId)), '');
                
                $this->delete_all('xjhlive_material', array('xid' => array('in', $delId)), '');
                
                $this->delete_all('xjhlive_yy', array('xid' => array('in', $delId)), '');
                
                $this->delete_all('xjhlive_yymsg', array('xid' => array('in', $delId)), '');
                
                $this->delete_all('xjhlive_com', array('xid' => array('in', $delId)), '');
                
                $this->delete_all('xjhlive_chat', array('xid' => array('in', $delId)), '');
                
                $this->delete_all('xjhlive_pic', array('xid' => array('in', $delId)), '');
                
                $postjson  =  array('xid'=>$delId);
                $this->dxRequest('m=xjh&c=delsync', $postjson);
            }
            
            $return['errcode']  =   $result ? 9 : 8;
            
            $msg    = '宣讲会';
            
            $return['msg']  =   $result ? $msg.'删除成功！' : $msg.'删除失败！';
        }
        return $return;
    }
    /**
     * @desc 删除宣讲会封面
     * @param int|array $delId
     * @param array $data: admin, zdid, uid,userdel
     */
    public function delXjhPic($delId = null, $data = array())
    {
        if (empty($delId)) {
            
            $return =   array(
                'errcode'   =>  8,
                'msg'       => '请选择要删除的数据！'
            );
        } else {
            
            if (is_array($delId)) {
                
                $delId  =   pylode(',', $delId);
                
                $return['layertype']    =   1;
            } else {
                
                $return['layertype']    =   0;
            }
            
            if ($data['utype'] == 'admin') {
                
                $delWhere   =   array('id' => array('in', $delId));
            } else {
                
                $delWhere['id']     =   array('in', $delId);
                
                $delWhere['uid']    =   $data['uid'];
            }
            
            $result =   $this->delete_all('xjhlive_pic', $delWhere, '');
            
            
            $return['errcode']  =   $result ? 9 : 8;
            
            $msg    = '宣讲会封面';
            
            $return['msg']  =   $result ? $msg.'删除成功！' : $msg.'删除失败！';
        }
        return $return;
    }
    /**
     * 删除参会企业
     */
    public function delXjhCom($delId = null, $xid = ''){
        
        if (empty($delId) || $xid == '') {
            
            $return         =   array('errcode' => 8, 'msg' => '请选择要删除的数据！');
        } else {
            
            if (is_array($delId)) {
                
                $delId                  =   pylode(',', $delId);
                
                $return['layertype']    =   1;
            } else {
                
                $return['layertype']    =   0;
            }
            
            $list  =  $this->select_all('xjhlive_com',array('id'=>array('in',$delId)));
            
            if(!empty($list)){
                
                foreach ($list as $v){
                    
                    $uid[]  =  $v['uid'];
                }
            }
            
            $return['id']       =   $this -> delete_all('xjhlive_com', array('id' => array('in', $delId)), '');
            
            $return['errcode']  =   $return['id'] ? 9 : 8;
            
            $msg                =   '宣讲会参会企业（ID：'.$delId.'）';
            
            $return['msg']      =   $return['id'] ? $msg.'删除成功！' : '删除失败！';
        }
        return $return;
    }
    /**
     * 查询参会企业
     */
    function getXjhComList($whereData=array(),$data=array()){
        
        $field  =  !empty($data['field']) ? $data['field'] : '*';
        
        $List   =  $this->select_all('xjhlive_com',$whereData,$field);
        
        if(!empty($List)){
            
            $uid  =  $zid  =  $xid = array();
            
            foreach($List as $v){
                if($v['uid'] && !in_array($v['uid'] , $uid)){
                    $uid[]  =  $v['uid'];
                }
                if($v['xid'] && !in_array($v['xid'],$xid)){
                    $xid[]  =  $v['xid'];
                }
            }
            
            if ($data['utype'] == 'admin'){
                
                $company  =  $this -> select_all('company', array('uid'=>array('in',pylode(',',$uid))),'`uid`,`name`,`logo`,`logo_status`,`r_status`');
                
                $jfield   =  '`id`,`uid`,`name`';
                
                $listA	  =  $this -> select_all('company_job',array('uid'=>array('in',pylode(',',$uid)),'state' => 1, 'status' => 0,'r_status' => 1),$jfield);
            }
            
            $xjh  =  $this -> select_all('xjhlive',array('id'=>array('in',pylode(',',$xid))),'`id`,`name`');
            
            
            foreach($List as $k => $v){
                
                if ($data['utype'] == 'admin'){
                    foreach($company as $val){
                        
                        if($v['uid'] == $val['uid']){
                            
                            $List[$k]['comname']	=	$val['name'];
                        }
                    }
                    $jobname	=	array();
                    
                    foreach($listA as $val){
                        
                        if ($v['uid'] == $val['uid']) {
                            if (count($jobname) < 10){
                                $jobname[]		      =  $val['name'];
                                $List[$k]['jobname']  =  @implode('、',$jobname);
                            }
                        }
                    }
                }
                foreach($xjh as $val){
                    if($v['xid'] == $val['id']){
                        $List[$k]['xjhname']	=	$val['name'];
                    }
                }
            }
        }
        
        return $List;
    }
    /**
     * @desc 查询宣讲会预定列表
     * $whereData 	查询条件
     * $data 		自定义处理数组
     */
    function getyyList($where=array(),$data=array()){
        
        if(!empty($where)){
            
            $List	=	$this->select_all('xjhlive_yy',$where);
            
            if(!empty($List)){
                
                $uid  =  $xid  =  array();
                
                foreach($List as $k=>$v){
                    
                    if($v['uid'] && !in_array($v['uid'] , $uid)){
                        $uid[]  =  $v['uid'];
                    }
                    if($v['xid'] && !in_array($v['xid'],$xid)){
                        $xid[]  =  $v['xid'];
                    }
                }
                $user     =  $this->select_all('resume', array('uid'=>array('in',pylode(',',$uid))),'`uid`,`name`');
                $xjhList  =  $this->getList(array('id'=>array('in',pylode(',',$xid))));
                
                foreach($List as $key=>$val){
                    
                    $List[$key]['ctime_n']  =  date('Y-m-d H:i', $val['ctime']);
                    
                    foreach ($user as $cv){
                        if ($val['uid'] == $cv['uid']){
                            
                            $List[$key]['name']  =	$cv['name'];
                        }
                    }
                    foreach($xjhList as $k=>$v){
                        
                        if($val['xid'] == $v['id']){
                            
                            $List[$key]['xjhname']	     =	$v['name'];
                            
                            $List[$key]['stime_n']	     =	$v['stime_n'];
                            
                            $List[$key]['livestatus_n']	 =	$v['livestatus_n'];
                            $List[$key]['livestatus']	 =	$v['livestatus'];
                            $List[$key]['wapxjh_url']    =  Url('wap',array('c'=>'xjhlive','a'=>'show','id'=>$v['id']));
                        }
                    }
                }
            }
            
            return $List;
        }
    }
    /**
     * 删除宣讲会预约记录
     * @param int|array $delId
     * @param array $data
     */
    public function delyy($delId, $data = array()){
        
        if (empty($delId)) {
            
            $return         =   array('errcode' => 8, 'msg' => '请选择要取消的数据！');
        } else {
            
            if (is_array($delId)) {
                
                $delId                  =   pylode(',', $delId);
                
                $return['layertype']    =   1;
            } else {
                
                $return['layertype']    =   0;
            }
            
            if ($data['utype'] == 'admin'){
                
                $delWhere	=	array('id' => array('in', $delId));
                
            }else{
                
                $delWhere	=	array('id' => array('in', $delId), 'uid' => $data['uid']);
            }

            $yylist         =   $this->select_all('xjhlive_yy', $delWhere);

            $yids           =   array();

            foreach($yylist as $k=>$v){
                $yids[]     =   $v['id'];
            }
            
            $return['id']       =  $this->delete_all('xjhlive_yy', $delWhere, '');
            
            if ($return['id']) {

                $this -> delete_all('xjhlive_yymsg', array('yid'  => array('in', pylode(',', $yids))), '');
            }

            $return['errcode']  =  $return['id'] ? 9 : 8;
            
            $msg                =  '宣讲会预约记录';
            
            $return['msg']      =  $return['id'] ? $msg.'取消成功！' : $msg.'取消失败！';
        }
        return $return;
    }
    /**
     * 添加宣讲会严禁词
     */
    function addXjhkeyword($name=array(),$data=array()){
        
        if(!empty($name)){
            
            $nwarr	=	$this->select_all('xjhlive_keyword', array('name' => array('in', "'".implode("','", $name)."'")));
            
            if(empty($nwarr)){
                
                foreach($name as $k=>$v){
                    
                    if (!empty($v)){
                        
                        $nid=	$this->insert_into('xjhlive_keyword',array('name'=>$v));
                    }
                }
                
                if($nid){
                    
                    $this->addKeywordFile();
                    
                    $return['msg']      =   '添加成功';
                    
                    $return['errcode']  =   9;
                    
                }else{
                    
                    $return['msg']      =   '数据错误';
                    
                    $return['errcode']  =   8;
                }
            }else{
                
                $return['msg']      =   '该严禁词已添加';
                $return['code']  	=   7;
                $return['errcode']  =   8;
            }
            
        }else{
            $return['msg']      =   '严禁词不能为空';
            
            $return['errcode']  =   8;
        }
        return $return;
    }
    private function addKeywordFile($data=array()){
        
        $zdid 	= 	$data['zdid'] ? $data['zdid'] : 0;
        
        $nwarr	=	$this->select_all('xjhlive_keyword');
        
        $name	=	array();
        foreach($nwarr as $k=>$v){
            $name[]	=	$v['name'];
        }
        if(!empty($name)){
            
            $nstr	=	implode("\r\n", $name);
        }else{
            
            $nstr	=	'';
        }
        
        $path 	= 	DATA_PATH.'sensitive/xjhword.txt';
        
        $fp = @fopen($path,w);
        @fwrite($fp,"$nstr");
        @fclose($fp);
    }
    public function delXjhkeyword($delId = null, $data = array()){
        
        if (empty($delId)) {
            
            $return         =   array('errcode' => 8, 'msg' => '请选择要删除的数据！');
        } else {
            
            if (is_array($delId)) {
                
                $delId                  =   pylode(',', $delId);
                
                $return['layertype']    =   1;
            } else {
                
                $return['layertype']    =   0;
            }
            
            $delWhere	=	array('id' => array('in',$delId));
            
            $return['id']       =   $this -> delete_all('xjhlive_keyword', $delWhere, '');
            
            $this->addKeywordFile();
            
            $return['errcode']  =   $return['id'] ? 9 : 8;
            
            $msg                =   '严禁词';
            
            $return['msg']      =   $return['id'] ? $msg.'删除成功！' : '删除失败！';
        }
        return $return;
    }
    /**
     * 严禁词列表
     */
    public function getXjhkeywordList($whereData , $data = array('field'=>null, 'utype'=> null)) {
        
        $select  =  $data['field'] ? $data['field'] : '*';
        
        $List	 =  $this -> select_all('xjhlive_keyword',$whereData,$select);
        
        return $List;
    }
    /**
     * 添加宣讲会开播通知待发送记录
     */
    function addyyMsg($xjhid = '', $uid = '',$nid){
        
        if($xjhid != ''){
            
            $xjh	=	$this -> select_once('xjhlive', array('id'=>$xjhid),'`id`,`name`,`stime`');
            
            if(!empty($xjh)){
                $stime	=  $xjh['stime']-30*60>time()?$xjh['stime']-30*60:time();
                
                $msgData  =  array(
                    'xid'	   =>  $xjh['id'],
                    'stime'	   =>  $stime,
                    'yid'      =>  $nid,
                    'xjhname'  =>  $xjh['name'],
                    'xjhtime'  =>  $xjh['stime']
                );
                
                $member  =  $this->select_once('member',array('uid'=>$uid),'`uid`,`wxid`');
                
                if (!empty($member)){
                    // 有这些参数，可用来发送通知
                    $msgData['uid']       =  $member['uid'];
                    
                    if (empty($member['wxid'])){
                        
                        $return['wxshow']  =  1;
                    }
                }
                
                $return['id']  =  $this -> insert_into('xjhlive_yymsg', $msgData);
                
                return $return;
            }
        }
    }
    /**
     * 直播宣讲会预约发送微信提醒
     * 后台计划任务文件名：xjhlive_yy.php; url执行方法：index.php?m=ajax&c=sendXjhliveYy
     */
    function sendYymsg(){
        
        $time     =     time();

        $begined  =     $this->select_once('xjhlive_yymsg', array('status'=>1,'xjhtime'=>array('<',$time)));

        if (!empty($begined)){
            
            $this->delete_all('xjhlive_yymsg', array('status'=>1,'xjhtime'=>array('<',$time)), '');
        }

        $list   =   $this -> select_all('xjhlive_yymsg', array('status'=>0,'stime'=>array('<',time())));
        
        if(!empty($list)){
            
            $ids    =   array();
            foreach($list as $val){
                
                $uids[]  =  $val['uid'];
            }
            $uids  =  array_unique($uids);
            
            $members  =  $this->select_all('member', array('uid'=>array('in', pylode(',', $uids))), '`uid`,`wxid`');
            
            require_once 'weixin.model.php';
            
            $weixinM    =   new weixin_model($this->db, $this->def);

            $sendData   =   array();
            
            foreach($list as $key=>$val){
                
                foreach ($members as $v){
                    
                    if ($val['uid'] == $v['uid']){
                        
                        $sendData['id']     =   $val['id'];
                        $sendData['uid']    =   $val['uid'];
                        $sendData['usertype']=   1;
                        $sendData['wxid']   =   $v['wxid'];
                        $sendData['name']   =   $val['xjhname'];
                        $sendData['stime']  =   $val['xjhtime'];
                        $sendData['url']    =   Url('wap', array('c'=>'xjhlive', 'a' => 'show', 'id' => $val['xid']));
                        
                        $weixinM->sendWxXjhLiveYy($sendData);
                        
                        $ids[]   =  $val['id'];
                    }
                }
            }
            if (!empty($ids)){
                
                $this->update_once('xjhlive_yymsg',array('status'=>1),array('id'=>array('in',pylode(',', $ids))));
            }
        }
    }
    /**
     * 添加预约记录
     * @param array $data
     * @return boolean|unknown
     */
    function addyy($data=array()){
        
        if(!empty($data)){
            $nid	=	$this->insert_into('xjhlive_yy', $data);
        }
        
        return $nid;
        
    }
    /**
     * 获取预约信息
     */
    function getyyInfo($whereData=array(),$data=array()){
        
        if(!empty($whereData)){
            
            $field  =	empty($data['field']) ? '*' : $data['field'];
            
            $Info	=	$this -> select_once('xjhlive_yy', $whereData, $field);
            
            if(!empty($Info)){
                
                $xjh	=	$this->getInfo(array('id'=>$Info['xid']));
                
                $Info['status_n']	=	$xjh['status_n'];
                
                $Info['name']		=	$xjh['name'];
                
                $Info['stime_n']	=	$xjh['stime_n'];
            }
        }
        
        return $Info;
        
    }
    /**
     * 添加宣讲会导播台素材
     */
    function addMaterial($data){
        
        if (!empty($data)){
            
            $this->insert_into('xjhlive_material', $data);
        }
    }
    /**
     * 查询宣讲会导播台素材
     */
    function getMaterial($where){
        
        $row  =  $this->select_once('xjhlive_material', $where);
        
        if (!empty($row['url'])){
            
            $token = $this->base64Encode(array('ak'=>$this->config['sy_xjhlive_appkey'],'t'=>time()));
            
            if (stripos($row['url'], '.mp4')!==false || stripos($row['url'], '.MP4') !== false){
                $row['url'] .= '?vframe/jpg/offset/0/w/140/h/90&token=' .$token;
            }else{
                $row['url'] .= '?token='.$token;
            }
        }
        return $row;
    }
    /**
     * 查询宣讲会导播台素材列表
     */
    function getMaterials($where){
        
        $rows  =  $this->select_all('xjhlive_material', $where);
        
        if (!empty($rows)){
            
            $token = $this->base64Encode(array('ak'=>$this->config['sy_xjhlive_appkey'],'t'=>time()));
            
            foreach ($rows as $k=>$v){
                
                $rows[$k]['video']  =  0;
                if (stripos($v['url'], '.mp4')!==false  || stripos($v['url'], '.MP4')!==false){
                    $rows[$k]['video']  =  1;
                    $rows[$k]['url']  =  $v['url']. '?vframe/jpg/offset/0/w/140/h/90&token=' .$token;
                }else{
                    $rows[$k]['url']  =  $v['url']. '?token=' .$token;
                }
            }
        }
        return $rows;
    }
    /**
     * 宣讲会导播台素材修改
     */
    function upMaterial($where=array(),$data=array()){
        
        if(!empty($where)){
            
            $xid  =  $this->update_once('xjhlive_material',$data,$where);
            
            return $xid;
        }
    }
    /**
     * @desc 删除宣讲会导播台素材
     */
    public function delMaterial($delId = null, $data = array())
    {
        if (empty($delId)) {
            
            $return =   array(
                'errcode'   =>  8,
                'msg'       => '请选择要删除的数据！'
            );
        } else {
            
            if (is_array($delId)) {
                
                $delId  =   pylode(',', $delId);
                
                $return['layertype']    =   1;
            } else {
                
                $return['layertype']    =   0;
            }
            
            $result =   $this->delete_all('xjhlive_material', array('id' => array('in', $delId)), '');
            
            $return['errcode']  =   $result ? 9 : 8;
            
            $msg    = '导播素材';
            
            $return['msg']  =   $result ? $msg.'删除成功！' : $msg.'删除失败！';
        }
        return $return;
    }
    /**
     * 设置导播台暖场视频
     */
    function setCasterVideo($where,$data){
        
        $msg  =  '暖场视频';
        
        if ($data['state'] == 1){
            // 设置
            $startvideo  =  1;
            
        }else{
            // 取消设置
            $startvideo  =  0;
            $msg .=  '取消';
        }
        
        $this->update_once('xjhlive_material', array('startvideo'=>$startvideo), $where);
        
        $row  =  $this->select_once('xjhlive_material',$where, '`id`,xid,`syncid`');
        
        $postjson['mid']         =  $row['syncid'];
        $postjson['xid']         =  $row['xid'];
        $postjson['startvideo']  =  $startvideo;
        
        $url  =  'm=xjh&c=setVideo';
        
        $this->dxRequest($url, $postjson);
        
        $return['msg']      =  $msg . '设置成功';
        $return['errcode']  =  9;
        
        return $return;
    }
    /**
     * 创建导播台
     */
    function createCaster($data = array()){
        
        $xid  =  $data['xid'];
        $xjh  =  $this->select_once('xjhlive', array('id'=>$xid), '`id`,`stime`,`playtime`,`status`,`livestatus`');
        
        if ($xjh['status'] == 0){
            
            $return  =  array('errcode'=>8,'msg'=>'宣讲会审核中');
            
        }elseif ($xjh['status'] == 2){
            
            $return  =  array('errcode'=>8,'msg'=>'宣讲会未通过审核');
            
        }elseif ($xjh['stime'] - 600 >= time()){
            
            $return  =  array('errcode'=>8,'msg'=>'宣讲会开始前10分钟内才可创建导播台');
            
        }elseif ($xjh['livestatus'] == 2){
            
            $return  =  array('errcode'=>8,'msg'=>'宣讲会已结束');
            
        }elseif ($xjh['livestatus'] == 3){
            
            $return  =  array('errcode'=>8,'msg'=>'宣讲会正在直播中，无法创建导播台');
            
        }else{
            
            $material  =  $this->select_once('xjhlive_material',array('xid'=>$xjh['id']));
            
            if (!empty($material)){
                
                // 创建导播台
                $postjson['xid']  =  $xjh['id'];
                
                $url 	  =	 'm=xjh&c=createCaster';
                
                $return   =  $this->dxRequest($url, $postjson);
                
                if (!empty($return['playurl'])){
                    
                    $this->update_once('xjhlive',array('playurl'=>$return['playurl'],'caster'=>1),array('id'=>$xjh['id']));
                    
                    $return  =  array('errcode'=>9,'msg'=>'导播台创建成功');
                }else{
                    $return  =  array('errcode'=>8,'msg'=>$return['msg']);
                }
            }else{
                
                $return  =  array('errcode'=>8,'msg'=>'请先添加导播素材');
            }
        }
        return $return;
    }
    /**
     * 开启导播台
     */
    function openCaster($data = array()){
        
        $xid  =  $data['xid'];
        $xjh  =  $this->select_once('xjhlive', array('id'=>$xid), '`id`');
        
        $postjson['xid']  =  $xjh['id'];
        
        $url 	  =	 'm=xjh&c=openCaster';
        
        $return   =  $this->dxRequest($url, $postjson);
        
        if ($return['errcode'] == 9){
            
            $this->update_once('xjhlive',array('caster'=>2), array('id'=>$xjh['id']));
            
            $return  =  array('errcode'=>9,'msg'=>$return['msg']);
            
        }else{
            
            $return  =  array('errcode'=>8,'msg'=>$return['msg']);
        }
        
        return $return;
    }
    /**
     * 导播台切换监视器画面，并切换布局
     */
    function upMonitor($data = array()){
        
        $xid  =  $data['xid'];
        $xjh  =  $this->select_once('xjhlive', array('id'=>$xid), '`id`');
        
        $postjson['xid']     =  $xjh['id'];
        $postjson['mid']     =  $data['mid'];
        $postjson['layout']  =  $data['layout'];
        
        $url 	  =	 'm=xjh&c=upMonitor';
        
        $return   =  $this->dxRequest($url, $postjson);
        
        if ($return['errcode'] == 9){
            
            $return  =  array('errcode'=>9,'msg'=>'切换成功');
            
        }else{
            
            $return  =  array('errcode'=>8,'msg'=>$return['msg']);
        }
        
        return $return;
    }
    /**
     * 导播台切换监视器画面，并切换布局
     */
    function liveCaster($data = array()){
        
        $xid  =  $data['xid'];
        $xjh  =  $this->select_once('xjhlive', array('id'=>$xid), '`id`');
        
        $postjson['xid']  =  $xjh['id'];
        
        $url 	  =	 'm=xjh&c=liveCaster';
        
        $return   =  $this->dxRequest($url, $postjson);
        
        if ($return['errcode'] == 9){
            
            $return  =  array('errcode'=>9,'msg'=>'切换成功');
            
        }else{
            
            $return  =  array('errcode'=>8,'msg'=>$return['msg']);
        }
        
        return $return;
    }
    /**
     * 上传素材文件
     */
    function uploadMaterial($file, $data = array()){
        
        $xjh  =  $this->select_once('xjhlive', array('id'=>$data['xid']), '`livestatus`');
        
        if($xjh['livestatus'] ==2){
            
            $return  =  array('errcode'=>8,'msg'=>'直播宣讲会已结束');
            
        }else{
            
            if ($file['tmp_name']){
                
                $douxu  =  $this->dxRequest('m=xjh&c=getUpToken');
                
                if ($douxu['errcode'] == 9){
                    
                    require_once APP_PATH.'api/qiniu/oss.php';
                    
                    $oss  =  new qiniuOss();
                    $res  =  $oss->uploadFile($douxu['token'], $file);
                    
                    if (!empty($res['url'])){
                        
                        $postjson['xid']  =  $data['xid'];
                        $postjson['url']  =  $res['url'];
                        
                        $return    =  $this->dxRequest('m=xjh&c=addMaterial', $postjson);
                        
                    }else{
                        
                        $return  =  array('errcode'=>8,'msg'=>'文件上传失败');
                    }
                }else{
                    
                    $return  =  array('errcode'=>8,'msg'=>'上传凭证获取失败');
                }
            }else{
                
                $return  =  array('errcode'=>8,'msg'=>'请上传文件');
            }
        }
        return $return;
    }
    /**
     * 通过接口查询是否可以创建宣讲会
     */
    function xjhCanAdd(){
        
        $url 	=  'm=xjh&c=canAdd';
        
        $douxu  =  $this->dxRequest($url);
        
        return $douxu;
    }
    /**
     * 通过接口同步宣讲会，获取直播播放地址
     */
    function xjhSync($id){
        
        $xjh  =  $this->select_once('xjhlive',array('id'=>$id),'`id`,`name`,`ctime`,`stime`,`playtime`,`playback`,`state`,`statetime`');
        
        $postjson['xjh']      =  json_encode($xjh);
        
        $url 	  =	 'm=xjh&c=sync';
        
        $douxu    =  $this->dxRequest($url, $postjson);
        
        if (!empty($douxu['playurl'])){
            
            $this->update_once('xjhlive', array('playurl'=>$douxu['playurl'],'syncid'=>$douxu['id']), array('id'=>$xjh['id']));
        }else{
            
            $return  =  array('errcode'=>8,'msg'=>'操作失败：'.$douxu['msg']);
        }
        return $return;
    }
    /**
     * 通过接口获取宣讲会直播地址
     */
    function getLiveQrcode($where){
        
        $xjh  =  $this->select_once('xjhlive', $where, '`id`,`name`,`ctime`,`stime`,`playtime`,`playback`,`livestatus`');
        
        if($xjh['livestatus'] == 2 || ($xjh['stime']+3600*$xjh['playtime']) < time()){
            
            $return  =  array('errcode'=>8,'msg'=>'直播宣讲会已结束');
        }else{
            
            $postjson['xjh']  =  json_encode($xjh);
            
            $url 	  =	 'm=xjh&c=getLiveQrcode';
            
            $douxu    =  $this->dxRequest($url, $postjson);
            
            if (!empty($douxu['pushurl'])){
                
                $return  =  array('errcode'=>9,'msg'=>'直播宣讲会直播地址获取成功','url'=>$douxu['pushurl']);
                
            }else{
                
                $return  =  array('errcode'=>8,'msg'=>'直播宣讲会直播地址获取失败'.$douxu['msg']);
            }
        }
        return $return;
    }
    /**
     * 同步关闭直播
     */
    function liveEnd($where){
        
        $xjh  =  $this->select_once('xjhlive', $where, '`id`,`stime`,`livestatus`,`caster`');
        
        if($xjh['livestatus'] == 1 && $xjh['stime'] >= time()){
            
            $return  =  array('errcode'=>8,'msg'=>'直播宣讲会未开始');
            
        }elseif($xjh['livestatus'] ==2){
            
            $return  =  array('errcode'=>8,'msg'=>'直播宣讲会已结束');
            
        }else{
            
            $url 	  =	 'm=xjh&c=liveEnd';
            
            $douxu    =  $this->dxRequest($url, array('xid'=>$xjh['id']));
            
            if ($douxu['errcode'] == 9){
                
                $sql  =  array(
                    'livestatus'  =>  2
                );
                
                if (!empty($douxu['fname'])){
                    
                    $sql['recordurl']  =  $douxu['fname'];
                }
                if ($xjh['caster'] == 2){
                    
                    $sql['caster']  =  1;
                }
                $this->update_once('xjhlive', $sql, array('id'=>$xjh['id']));
                
                $return  =  array('errcode'=>9,'msg'=>'直播关闭成功');
                
            }else{
                
                $return  =  array('errcode'=>8,'msg'=>'直播关闭失败'.$douxu['msg']);
            }
        }
        return $return;
    }
    /**
     * 获取宣讲会直播推流地址
     */
    function getPushUrl($where){
        
        $xjh  =  $this->select_once('xjhlive', $where, '`id`,`stime`,`livestatus`,`caster`,`playtime`');
        
        if ($xjh['stime'] - 1800 >= time()){
            $return  =  array('errcode'=>8,'msg'=>'宣讲会开始前30分钟内才可获取');
        }elseif($xjh['livestatus'] == 2){
            $return  =  array('errcode'=>8,'msg'=>'直播宣讲会已结束');
        }elseif ($xjh['caster'] != 0){
            $return  =  array('errcode'=>8,'msg'=>'已创建导播台，不支持获取推流地址');
        }else{
            $url 	  =	 'm=xjh&c=getPushUrl';
            
            $douxu    =  $this->dxRequest($url, array('xid'=>$xjh['id']));
            
            if ($douxu['errcode'] == 9){
                
                $return  =  array('errcode'=>9,'msg'=>'推流地址有效期'.$xjh['playtime'].'小时','live'=>$douxu['live']);
                
            }else{
                
                $return  =  array('errcode'=>8,'msg'=>'获取失败，'.$douxu['msg']);
            }
        }
        return $return;
    }
    /**
     * 请求综合平台
     */
    private function dxRequest($url, $postjson = array()){
        
        if (!empty($this->config['sy_xjhlive_appkey']) && !empty($this->config['sy_xjhlive_appsecret'])){
            
            $postjson['appKey']     =  $this->config['sy_xjhlive_appkey'];
            $postjson['appSecret']  =  $this->config['sy_xjhlive_appsecret'];
            
            $url      =  'https://trtc.phpyun.com/zphnetv/index.php?'. $url;
            
            $result	  =	 CurlPost($url,$postjson);
            $reponse  =	 json_decode($result, true);
            $return   =  $reponse['data'];
            
        }else{
            
            $return  =  array('errcode'=>8,'msg'=>'请配置宣讲会云导播秘钥');
        }
        return $return;
    }
    /**
     * base64加密
     * @param string $data 需要编码的数组
     * @return string
     */
    private static function base64Encode($data)
    {
        return str_replace('=', '', strtr(base64_encode(json_encode($data, JSON_UNESCAPED_UNICODE)), '+/', '-_'));
    }
}
?>