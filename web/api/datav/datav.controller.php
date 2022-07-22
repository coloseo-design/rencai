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
class datav_controller extends common{ 

    public $member   =  array();
    public $comInfo  =  array();
    public $sy_datav_diydata = array();
    
	function __construct($tpl,$db,$def='',$model='index',$m='') {

		$this->common($tpl,$db,$def,'datav',$m);
		$diydata = json_decode($this->config['sy_datav_diydata'],true);
		$this->sy_datav_diydata = array(
			'allcomnum'=>intval($diydata['allcomnum']),
			'daycomnum'=>intval($diydata['daycomnum']),
			'alljobnum'=>intval($diydata['alljobnum']),
			'dayjobnum'=>intval($diydata['dayjobnum']),
			'allusernum'=>intval($diydata['allusernum']),
			'dayusernum'=>intval($diydata['dayusernum']),
			'allzphnum'=>intval($diydata['allzphnum']),
			'dayzphnum'=>intval($diydata['dayzphnum']),

			'yearuser_monthreg'=>intval($diydata['yearuser_monthreg']),
			'yearuser_monthreg_rand'=>intval($diydata['yearuser_monthreg_rand']),
			'monthreg_user'=>intval($diydata['monthreg_user']),
			'dayreg_user'=>intval($diydata['dayreg_user']),
			'year_sqnum'=>intval($diydata['year_sqnum']),
			'year_yqnum'=>intval($diydata['year_yqnum']),
			'year_chatnum'=>intval($diydata['year_chatnum']),
			'year_lrnum'=>intval($diydata['year_lrnum']),
			'year_ljnum'=>intval($diydata['year_ljnum']),

			'yearcom_regnum'=>intval($diydata['yearcom_regnum']),
			'yearcom_monthreg'=>intval($diydata['yearcom_monthreg']),
			'yearcom_monthreg_rand'=>intval($diydata['yearcom_monthreg_rand']),

			'hothy_sqnum'=>intval($diydata['hothy_sqnum']),
			'hothy_sqnum_rand'=>intval($diydata['hothy_sqnum_rand']),
			'hothy_jobs'=>intval($diydata['hothy_jobs']),
			'hothy_jobs_rand'=>intval($diydata['hothy_jobs_rand']),

			'hotjob_sqnum'=>intval($diydata['hotjob_sqnum']),
			'hotjob_sqnum_rand'=>intval($diydata['hotjob_sqnum_rand']),
			'hotjob_jobs'=>intval($diydata['hotjob_jobs']),
			'hotjob_jobs_rand'=>intval($diydata['hotjob_jobs_rand']),
		);
		$this->datatoken();
		
	}
	//通信验证
	function datatoken(){
	  
	    if ($_GET['token'] && $this->config['sy_datav_token'] && $_GET['token'] == $this->config['sy_datav_token']){
	       	return true;
	    }else{
	    	$result = array(
		        'error'  =>  1001,
		        'url'=>$this->config['sy_weburl']
		    );
		    header('content-type:application/json; charset=utf-8');
		    echo json_encode($result);exit();
	    }
	}
	
	/**
	 * 将接口返回数据以统一格式的JSON输出
	 * $data 	  array 	执行结果输出的数据
	 */
	public function success($data = array()) {
	    // 将数组中null字段转为空
	    $result  =  $this->nullToEmpty($data);
	    header('content-type:application/json; charset=utf-8');
	    echo json_encode($result);
	    exit;
	}
	/**
	 * 将接口返回数据以统一格式的JSON输出
	 * $errcode   string 	执行结果标识码，
	 * $msg 	  string 	执行结果描述信息
	 */
	public function fail($msg='') {
	    
	    $result = array(
	        'error'  =>  400,
	        'msg'    =>  $msg
	    );
	    header('content-type:application/json; charset=utf-8');
	    echo json_encode($result);
	    exit;
	}
	/**
	 * 将null字段值转为空
	 * @param array $arr
	 * @return string
	 */
	function nullToEmpty($arr = array()){
	    
	    if (!empty($arr)){
	        
	        foreach ($arr as $k=>$v){
	            
	            if (is_null($v)){
	                
	                $arr[$k] = '';
	                
	            }elseif (is_array($v)){
	                
	                $arr[$k]  =  $this->nullToEmpty($v);
	            }
	        }
	    }
	    return $arr;
	}

    /**
     * 【时间戳转为多久之前】
     * @param String timestamp 时间戳
     * @param String | Boolean format 如果为时间格式字符串，超出一定时间范围，返回固定的时间格式；
     * 如果为布尔值false，无论什么时间，都返回多久以前的格式
     * @return false|string
     */
    public function getDateView($timestamp = null, $format = 'Y-m-d')
    {

        $timer = bcsub(time(), $timestamp);

        switch (true) {
            case $timer < 60:
                $datetime_n = '刚刚';
                break;
            case $timer >= 60 && $timer < 3600:
                $datetime_n = intval(bcdiv($timer , 60)).'分钟前';
                break;
            case $timer >= 3600 && $timer < 86400:
                $datetime_n = intval(bcdiv($timer , 3600)).'小时前';
                break;
            case $timer >= 86400 && $timer < 2592000:
                $datetime_n = intval(bcdiv($timer , 86400)).'天前';
                break;
            default:
                // 如果format为false，则无论什么时间戳，都显示xx之前
                if ($format === false) {
                    if ($timer >= 2592000 && $timer < 365 * 86400) {
                        $datetime_n = intval(bcdiv($timer , bcmul(86400 , 30))).'个月前';
                    } else {
                        $datetime_n = intval(bcdiv($timer , bcmul(86400 , 365))).'年前';
                    }
                } else {
                    $datetime_n = date($format, $timestamp);
                }
                break;
        }

        return $datetime_n;
    }

}
?>