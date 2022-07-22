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
class companyaccount_model extends model{

    
    // 获取套餐数据信息
    private function getStatisInfo($uid, $data = array())
    {
        require_once ('statis.model.php');

        $StatisM    =   new statis_model($this->db, $this->def);

        return $StatisM -> getInfo($uid, $data);
    }
    
    // 添加会员日志
    private function addMemberLog($uid, $usertype, $content, $opera = '', $type = '')
    {
        require_once ('log.model.php');

        $LogM       =   new log_model($this->db, $this->def);

        return $LogM -> addMemberLog($uid, $usertype, $content, $opera, $type);
    }
    
    /**
     * @data    添加company_account 子账号数据
     */
    public function addInfo($data = array()) {
        
        $nid	=	$this -> insert_into('company_account', $data);
        return $nid;
    }

    /**
     * @data    修改company_account 子账号数据
     */
    public function updInfo($where = array(), $data = array()) {
        
        $nid	=	$this -> update_once('company_account', $data, $where);
        return $nid;
        
    }

    /**
     * @data    company_account 子账号数据列表
     */
    public function getList($where = array(), $data = array()) {

        $select =   $data['field'] ? $data['field'] : '*';
        $List	=   $this -> select_all('company_account', $where, $select);
        return $List;
        
    }

    /**
     * @data    company_account 子账号数据信息
     */
    public function getInfo($where = array(), $data = array()) {

        $select =   $data['field'] ? $data['field'] : '*';
        $Info	=   $this -> select_once('company_account', $where, $select);
        return $Info;
        
    }

    /**
     * @data    company_account 子账号数量
     */
    public function getNum($where = array()) {

        return $this -> select_num('company_account', $where);
        
    }

    /**
     * @data    添加company_account 子账号数据
     * 创建完子账号，增加 company_statis信息
     */
    public function createAccount($data = array()){
        $res    =   array(
            'errcode'   =>  8,
            'msg'       =>  ''
        );
        if(empty($data['comid'])){
            $res['msg'] =   '缺少主账号信息!';
            return $res;
        }

        //增加company_statis信息
        require_once ('statis.model.php');
        $statisM		=	new statis_model($this->db, $this->def);
        $fatherData     =   $statisM -> getInfo($data['comid'], array('usertype' => 2));
        if(empty($fatherData)){
            $res['msg'] =   '主账号套餐信息错误!';
			return $res;
        }

        //创建子账号
        $accountId      =   $this -> addInfo($data);
        if(empty($accountId)){
            $res['msg'] =   '子账号创建失败!';
            return $res;
        }

        //补充主账号的信息
        $sonStatisData  =   array();
        $sonStatisData['rating']      =   $fatherData['rating'];
        $sonStatisData['rating_name'] =   $fatherData['rating_name'];
        $sonStatisData['rating_type'] =   $fatherData['rating_type'];
        $sonStatisData['vip_stime']   =   $fatherData['vip_stime'];
        $sonStatisData['vip_etime']   =   $fatherData['vip_etime'];
        $sonStatisData['uid']         =   $accountId;

        $statisId       =   $statisM -> addInfo($sonStatisData, array('usertype' => 2));

        $res['errcode'] =   9;
        return $res;
    }

	/**
	 * @desc   删除子账户
	  *                        子账号套餐归还主账号
	  *                        删除相关数据表信息：member、company_statis、company_account
	 *                        
     * @param  int $data['pid'] 主账号
	 * @param  int $data['uid'] 子账号
	 * 
	 */
	public function delChild($data = array()){
	    
		if(empty($data['uid']) || empty($data['pid'])){
			$res			=	array(
				'ecode'		=>	8,
				'msg'		=>	'参数UID错误'
			);
			return $res;
		}else{
		    
            $pid            =   intval($data['pid']);
            $uid            =   intval($data['uid']);
		}
		
        $field              =   '`job_num`, `breakjob_num`, `down_resume`, `invite_resume`, `top_num`, `rec_num`, `urgent_num`, `zph_num`';
        $statisChild        =   $this -> getStatisInfo($uid, array('usertype' => 2, 'field' => $field));
        
        $res['id']          =   $this -> delete_all('member', array('uid' => $uid), '');
        
        if ($res['id']) {

            /* 子账号套餐添加单主账号 */
            if (!empty($statisChild) && is_array($statisChild)) {
                
                $upStatisData   =   array(
                    
                    'job_num'       =>  array('+', intval($statisChild['job_num'])),
                    'breakjob_num'  =>  array('+', intval($statisChild['breakjob_num'])),
                    'down_resume'   =>  array('+', intval($statisChild['down_resume'])),
                    'invite_resume' =>  array('+', intval($statisChild['invite_resume'])),
                    'top_num'       =>  array('+', intval($statisChild['top_num'])),
                    'rec_num'       =>  array('+', intval($statisChild['rec_num'])),
                    'urgent_num'    =>  array('+', intval($statisChild['urgent_num'])),
                    'zph_num'       =>  array('+', intval($statisChild['zph_num']))
                );
                
                $this -> update_once('company_statis', $upStatisData, array('uid' => $pid));
            }
            
            $this -> delete_all('company_statis', array('uid' => $uid), '');
            $this -> delete_all('company_account', array('uid' => $uid), '');
            $this -> addMemberLog($pid, 2, '删除子账号（UID：'.$uid.'）', 27, 3);
            
            $res    =   array('ecode' => 9, 'msg' => '子账号删除成功！');
            
        }else{
            
            $res    =   array('ecode' => 8, 'msg' => '子账号删除失败！');
        }
		return $res;
	}

    /**
     * @desc    company_account 子账号数据列表；应用中的列表
     */
    public function getWorkList($where = array(), $data = array()) {
        
        $List   =   array();
        $List   =   $this -> getList($where, $data);
        
        if(empty($List)){
            return $List;
        }

        //获取登录名称
        $uid    =   array();
        
        foreach ($List as $v) {
            $uid[]  =   $v['uid'];
        }
        require_once ('userinfo.model.php');        
        $memberM    =   new userinfo_model($this->db, $this->def);
        $memField   =   array('field' => '`uid`, `username`,`status`');
        $tmpList    =   $memberM -> getList(array('uid' => array('in', pylode(',', $uid))), $memField);
        
        $memberList =   array();
        $statusList =   array();
        foreach ($tmpList as $tv) {
            $memberList[$tv['uid']]     =   $tv['username'];
            $statusList[$tv['uid']]     =   $tv['status'];
        }

        //给子账号补充登录名称
        foreach ($List as $lk => $lv) {
            
            $List[$lk]['ctime_n']  =   date('Y-m-d',$lv['ctime']);
            
            if(array_key_exists($lv['uid'], $memberList)){
                $List[$lk]['username']  =   $memberList[$lv['uid']];
            }
            if(array_key_exists($lv['uid'], $statusList)){
                $List[$lk]['status']    =   $statusList[$lv['uid']];
            }
        }

        return $List;
    }
}
?>