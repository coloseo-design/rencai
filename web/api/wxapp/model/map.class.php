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
class map_controller extends wxapp_controller{
	//附近职位列表
	function list_action(){
	    $coordinates	=	$this->Convert_GCJ02_To_BD09($_POST['x'],$_POST['y']);
	    $x	=	$coordinates['lng'];
	    $y	=	$coordinates['lat'];
	    // 根据sql距离计算公式计算距离并排序
        $select =   "`id`,`uid`,`name`,`x`,`y`,`provinceid`,`cityid`,`com_logo`,`exp`,`edu`,`minsalary`,`maxsalary`,`welfare`,`lastupdate`, `is_link`, 6371 * acos(cos(radians(" . $y . ")) * cos(radians(`y`)) * cos(radians(`x`) - radians(" . $x . ")) + sin(radians(" . $y . ")) * sin(radians(`y`))) AS `distance`";
        
        $page   =   $_POST['page'] ? $_POST['page'] : 1;

        if ($this->config['sy_indexpage']) {
            $indexPageNum   =   ceil($this->config['sy_indexpage'] / 10);
            
            if ($page > $indexPageNum) {
                $page   =   $indexPageNum;
            }
        }
        

	    $pagenav    =   ($page - 1) * 10;
        
	    $limit      =   array($pagenav,10);

        $where      =   array(
            
            'state'     =>  1,
            'r_status'  =>  1,
            'status'    =>  0,
            'x'         =>  array('>', 0),
            'y'         =>  array('>', 0),
            'orderby'   =>  'distance, asc',
            'limit'     =>  $limit
        );
        if(!empty($_POST['did'])){
            
            $where['did']	=	$_POST['did'];
        }else{
            $where['PHPYUNBTWSTART']	=	'';
            
            $where['did'][]	=	array('isnull');
            
            $where['did'][]	=	array('=','0','OR');
            
            $where['PHPYUNBTWEND']	=	'';
        }
        $jobM   =   $this->MODEL('job');
	    $jobListA   =   $jobM -> getList($where, array('field' => $select, 'link' => 'yes', 'from'=> 'wap_map'));
        
        $rows       =   $jobListA['list'];

        if (!empty($rows)) {
        
            $uids       =   array();
            
            foreach ($rows as $v) {
                
                $uids[] = $v['uid'];
            }
            
            $comM       =   $this->MODEL('company');
            
            $comListA   =   $comM->getList(array('uid' => array('in', pylode(',', $uids))), array('field' => '`uid`,`name`,`shortname`,`address`'));

            $list       =   array();
            
            foreach ($rows as $k => $v) {
                
                $list[$k]['id']         =   $v['id'];
                $list[$k]['name']       =   mb_substr($v['name'], 0, 16, 'utf-8');
                $list[$k]['salary_n']   =   $v['job_salary'];
                $list[$k]['job_edu'] = $v['job_edu'];
                $list[$k]['job_exp'] = $v['job_exp'];
                if(!empty($v['citystr'])) {
                    $list[$k]['citystr'] = $v['citystr'];
                }
                if(!empty($v['address'])){
                    $list[$k]['address']  =  $v['address'];
                }

                $list[$k]['comlogo'] = $v['com_logo_n'];

                $newxy  =  $this->Convert_BD09_To_GCJ02($v['x'], $v['y']);
                $list[$k]['x']          =  $newxy['lng'];
                $list[$k]['y']          =  $newxy['lat'];
                
                if ($v['welfare_n']) {
                    $list[$k]['welfare_n']=   $v['welfare_n'];
                }
                if ($v['distance'] <= 1) {
                    $list[$k]['dis']    =   ceil($v['distance'] * 1000) . 'm';
                } else {
                    $list[$k]['dis']    =   round($v['distance'], 2) . 'km';
                }
                
                
                foreach ($comListA['list'] as $val) {
                    
                    if ($val['uid'] == $v['uid']) {
                        
                        if ($v['shortname']) {
                            
                            $list[$k]['com_name']   =   mb_substr($val['shortname'], 0, 16, 'utf-8');
                        } else {
                            
                            $list[$k]['com_name']   =   mb_substr($val['name'], 0, 16, 'utf-8');
                        }
                        if(empty($v['address'])){
                            
                            $list[$k]['address']    =   $val['address'];
                        }
                    }
                }
            }
        }
        $data['list']   =   count($list) > 0 ? $list : array();
        // 小程序用seo
        if (isset($_POST['provider'])){
            if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao'){
                $seo            =  $this->seo('map','','','',false, true);
                $data['seo']    =  $seo;
            }
        }
        
	    $this->render_json(0,'ok',$data);
	}
	// 静态图
	function staticMap_action(){
	    
	    if (!empty($this->config['sy_chat_mapkey'])){
	        $center = $_POST['lng'] . ',' . $_POST['lat'];  // lng,lat
	        // 高德
	        $url = 'https://restapi.amap.com/v3/staticmap';
	        
	        $params = array(
	            'location' => $center,
	            'zoom'     => 14,
	            'scale'    => 2,
	            'size'     => '320*130',
	            'markers'  => 'large,0xFF0000,:'.$center,
	            'key'      => $this->config['sy_chat_mapkey']
	        );
	        $preSignStr = $this->getSignContent($params);
	        
	        $url = $url . "?" . $preSignStr;
	        
	        $back = CurlGet($url);
	        $json = json_encode($back, true);
	        
	        if (! $json){
	            
	            // 重新定义文件名称 图片一律用 jpeg
	            $filename  =  time().rand(1000,9999).'.png';
	            //自定义目录名称
	            $dirName = APP_PATH . 'data/upload/chat/' . date('Ymd');
	            //定义新名称以及目录
	            if (!file_exists($dirName)){
	                mkdir($dirName, 0777, true);
	            }
	            $res = fopen($dirName . '/' . $filename, 'a');
	            fwrite($res, $back);
	            fclose($res);
	            
	            if($this->config['sy_oss'] == 1){
	                
	                include_once(LIB_PATH.'oss/ossupload.class.php');
	                $ossUpload  =  new ossUpload();
	                $pic        =  $ossUpload -> uploadLocalImg($dirName . '/' . $filename);
	                
	                $picUrl  =  $pic['picurl'];
	            }else{
	                
	                $picUrl =	str_replace(APP_PATH.'data', './data', $dirName . '/' . $filename);
	            }
	            $this->render_json(0, 'ok', array('url'=>checkpic($picUrl)));
	        }else{
	            // 高德
	            $msg = isset($json['info']) ? $json['info'] : '静态图生成失败';
	            $this->render_json(-1, $msg);
	        }
	    }else {
	        $this->render_json(-1, '地图key未配置');
	    }
	}
	function getSignContent($params){
	    
	    ksort($params);
	    
	    $stringToBeSigned = "";
	    $i = 0;
	    foreach ($params as $k => $v) {
	        if ($this->checkEmpty($v) === false && substr($v, 0, 1) != "@") {
	            
	            if ($i == 0) {
	                $stringToBeSigned .= "$k" . "=" . "$v";
	            } else {
	                $stringToBeSigned .= "&" . "$k" . "=" . "$v";
	            }
	            $i++;
	        }
	    }
	    unset ($k, $v);
	    
	    return $stringToBeSigned;
	}
	function checkEmpty($value) {
	    if (!isset($value)){
	        return true;
	    }
        if ($value === null){
            return true;
        }
        if (trim($value) === ""){
            return true;
        }
        return false;
	}
}
?>