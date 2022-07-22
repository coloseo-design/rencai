<?php

/**
 * $Author ：PHPYUN开发团队
 *
 * 官网: http://www.phpyun.com
 *
 * 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
 *
 * 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */

class zphnet_model extends model
{

    /**
     * @desc   获取网络招聘会列表
     * @param  $whereData :查询条件
     * @param  $data :自定义处理数组
     * @return array|bool|false|string|void
     */
	public function getList($whereData , $data = array('field'=>null,'utype'=>null))
    {

		$select		=	$data['field'] ? $data['field'] : '*';

		$List		=   $this -> select_all('zphnet',$whereData,$select);

		$time  		=  	time();

		if($List&&is_array($List)){
		    
		    if ($data['utype'] == 'admin'){

		        foreach($List as $key => $val){

		            $zid[]	=	$val['id'];

		            $List[$key]['comnum']	=	'0';
		            $List[$key]['booking']	=	'0';
		        }

		        $all	    =	$this->select_all('zphnet_com',array('zid'=>array('in',pylode(',', $zid)),'groupby'=>'zid'),'zid,count(*) as num');

		        $status     =	$this->select_all('zphnet_com',array('zid'=>array('in',pylode(',', $zid)),'status'=>'0','groupby'=>'zid'),'`zid`,count(*) as num');

				$spLog		=	$this->select_all('spview_log',array('zid' => array('in', pylode(',', $zid)),'groupby'=>'zid'), '`zid`, count(*) as `num`, sum(`sptime`) as `sptime_t`');

                $userwhere  =   array('zid' => array('in', pylode(',', $zid)), 'usertype' => 1, 'groupby' => 'zid');

                $usercount 	= 	$this->select_all("zphnet_user",$userwhere,"`zid`,`uid`,count(*) as `num`");

		        foreach($List as $key => $v){
					if(!empty($spLog)){
						foreach($spLog as $val){
							if($v['id'] == $val['zid']){

								$List[$key]['spnum']		=	$val['num'];					    //	视频场次
								$List[$key]['sptime_total']	=	ceil($val['sptime_t'] / 60);	//	视频时间（分钟）
							}
						}
					}
		            foreach($all as $val){
		                if($v['id'] == $val['zid']){

		                    $List[$key]['comnum']	=	$val['num'];
		                }
		            }
                    foreach($usercount as $uk=>$uv){
                        if($uv["zid"] == $v["id"]){

                            $List[$key]["usernum"]  =   $uv["num"];
                        }
                    }
		            foreach($status as $val){
		                if($v['id'] == $val['zid']){

		                    $List[$key]['booking']	=	$val['num'];
		                }
		            }
		            if($v['did']<1){

		                $List[$key]['did']	        =	'0';
		            }
		        }
		    }
		    if ($data['utype'] == 'wxapp'){

                $zids = $zcount = array();

	            foreach($List as $k=>$v){

	                $zids[] =   $v["id"];
	            }

                $userwhere  =   array('zid' => array('in', pylode(',', $zids)), 'usertype' => 1, 'groupby' => 'zid');

	            $usercount 	= 	$this->select_all("zphnet_user",$userwhere,"`zid`,count(*) as `num`");

	            $comlist 	= 	$this->select_all("zphnet_com",array('zid'=>array('in',pylode(',', $zids)),'status'=>1),"`zid`,`uid`,`jobid`");

	            $cuids 		= 	array();
	            $job_ids	=	array();
	            foreach($comlist as $comk=>$comv){

	            	if(!in_array($comv['uid'],$cuids)){

	            		$cuids[] =  $comv["uid"];
	            	}
	            	if($comv['jobid']){

	                    $job_ids = array_unique(array_merge($job_ids,@explode(",",$comv['jobid'])));
	                }
	            }

	            $jobarr     =   array();

	            if(!empty($cuids)){

                    $coms   =   $this->select_all("company", array('uid' => array('in', pylode(',', $cuids)), 'r_status' => 1), "`uid`");

                    $comids =   array();

	            	foreach($coms as $comk=>$comv){

	            		$comids[]   =   $comv['uid'];
	            	}

	            	foreach($comlist as $ck=>$cv){
	            		if(!in_array($cv['uid'],$comids)){

	            			unset($comlist[$ck]);
	            		}
	            	}

	            	$jobwhere = array(
		            	'uid'		=>	array('in',pylode(',',$cuids)),
		            	'state'		=>	1,
		            	'r_status'	=>	1,
		            	'status'	=>	0,
		            	'groupby'	=>	'uid'
		            );

	                $jobs       =   $this->select_all("company_job",$jobwhere,"count(*) as num,`uid`,sum(`zp_num`) as `zpnum`");

	                $comjobzparr=   array();

	                foreach($jobs as $jk=>$jv){

	                    $jobarr[$jv["uid"]] = $jv["num"];
	                    $comjobzparr[$jv["uid"]] = $jv['zpnum'];
	                }

	                $jobidwhere = array(
		            	'id'		=>	array('in',pylode(',',$job_ids)),
		            	'state'		=>	1,
		            	'r_status'	=>	1,
		            	'status'	=>	0
		            );

                    $jobidlist  =   $this->select_all("company_job", $jobidwhere, "`id`,`zp_num`");

                    $jidarr     =   array();
                    $jusernumarr=   array();
                    foreach ($jobidlist as $jidv) {

                        $jidarr[]   = $jidv['id'];
                        $jusernumarr[$jidv['id']] = $jidv['zp_num'];
                    }
	            }
	            
	            foreach($comlist as $clk=>$clv){

                    $comlist[$clk]['jobnum'] = 0;
                    $comlist[$clk]['zpnum'] = 0;

	                if($clv["jobid"]){

	                    $jobidarr = @explode(",",$clv["jobid"]);

	                    foreach($jobidarr as $jv){

	                        if(in_array($jv,$jidarr)){
	                        	$zp_num = !empty($jusernumarr[$jv])?$jusernumarr[$jv]:0;
	                            $comlist[$clk]['jobnum']++;
	                            $comlist[$clk]['zpnum']+=$zp_num;
	                        }
	                    }
	                }else{

	                    $comlist[$clk]['jobnum']  	=  	$jobarr[$clv['uid']]; 
	                    $comlist[$clk]['zpnum']		=	$comjobzparr[$clv['uid']] ? $comjobzparr[$clv['uid']] : 0;
	                }
	            }
		        foreach($List as $key => $val){

		        	$List[$key]["usernum"] 	  =  0;
	                $List[$key]["comnum"] 	  =  0;
	                $List[$key]["jobnum"] 	  =  0;
	                $List[$key]["zpnum"] 	  =  0;
	                $List[$key]["zphtype"] 	  =  'zphnet';

	                foreach($comlist as $cv){
	                    if($cv['zid'] == $val['id']){
                            $List[$key]["comnum"]++;
                            $List[$key]["jobnum"]   +=  $cv['jobnum'];
                            $List[$key]["zpnum"]    +=  $cv['zpnum'];
	                    }
	                }

                    if (isset($val['pnum']) && (int)$val['pnum'] > 0) {
                        $List[$key]['comnum']   =   $List[$key]['comnum'] + $val['pnum'];
                    }
                    if (isset($val['jnum']) && (int)$val['jnum'] > 0) {
                        $List[$key]['jobnum']   =   $List[$key]['jobnum'] + $val['jnum'];
                    }
                    if (isset($val['zpnum']) && (int)$val['zpnum'] > 0) {
                        $List[$key]['zpnum']    =   $List[$key]['zpnum'] + $val['zpnum'];
                    }

                    $List[$key]['starttime_timestamp']  =  strtotime($val['starttime']);
                    $List[$key]['endtime_timestamp']  	=  strtotime($val['endtime']);
		            $List[$key]['starttime']  =  date('Y-m-d H:i',strtotime($val['starttime']));
		            $List[$key]['endtime']    =  date('Y-m-d H:i',strtotime($val['endtime']));
		            $List[$key]['stime']      =  strtotime($val['starttime'])-$time;
		            $List[$key]['etime']      =  strtotime($val['endtime'])-$time;

		            if($data['utype']=='wxapp' && $val['pic_wap']){
		            	$List[$key]['pic_n']  =  checkpic($val['pic_wap'],$this->config['sy_zph_icon']);
		            }else{
		            	$List[$key]['pic_n']  =  checkpic($val['pic'],$this->config['sy_zph_icon']);
		            }
		            if(($data['utype']=='wxapp') && $val['banner_wap']){
		                $List[$key]['banner_wap_n']  =  checkpic($val['banner_wap'],$this->config['sy_zph_icon']);
		            }else{
		                $List[$key]['banner_wap_n']  =  checkpic($this->config['sy_zph_icon']);
		            }

	                foreach($usercount as $uk=>$uv){
	                    if($uv["zid"] == $val["id"]){

	                        $List[$key]["usernum"] = $uv["num"];
	                    }
	                }
		        }
		    }
		}
		return $List;
	}

	/**
	* @desc 获取招聘会列表详细信息
	*/
	public function getInfo($whereData,$data = array())
	{
        $select  =  $data['field'] ? $data['field'] : '*';

        $Info    =  $this -> select_once('zphnet', $whereData, $select);

        if (!empty($Info)) {

            if (!empty($Info['starttime']))
            {
                $Info['starttime_n']  =  date('Y-m-d H:i',strtotime($Info['starttime']));
                $Info['stime']      =  strtotime($Info['starttime']) - time();
            }

            if (!empty($Info['endtime']))
            {
                $Info['endtime_n']  =  date('Y-m-d H:i',strtotime($Info['endtime']));
                $Info['etime']    =  strtotime($Info['endtime']) - time();
            }

            if (!empty($Info['body'])){

                $body  =  str_replace(array('&quot;','&nbsp;','<>'), array('','',''), $Info['body']);
                $body  =  htmlspecialchars_decode($body);

                preg_match_all('/<img(.*?)src=("|\'|\s)?(.*?)(?="|\'|\s)/',$body,$res);
                if(!empty($res[3])){
                    foreach($res[3] as $v){
                        if(strpos($v,'http:')===false && strpos($v,'https:')===false){
                            $body  =  str_replace($v,$this->config['sy_ossurl'].$v,$body);
                        }
                    }
                }
                $Info['body_n'] = mb_substr(strip_tags($body),0,50).'...';
                $Info['body']  =  $body;
            }
            $Info['pic_n']  =  checkpic($Info['pic'], $this->config['sy_zph_icon']);
            $Info['pic_wap_n']  =  checkpic($Info['pic_wap'], $this->config['sy_zph_icon']);
            // pc横幅
            $Info['banner_n']  =  checkpic($Info['banner'], $this->config['sy_zphbanner_icon']);
            // wap横幅
            $Info['banner_wap_n']  =  checkpic($Info['banner_wap'],  $Info['banner_n']);
        }
        return $Info;
    }

    /**
     * @desc 添加招聘会
     * @param array $data
     * @return bool
     */
    public function addInfo($data = array())
    {

		$AddData	=	array(
			'title'		 =>	 $data['title'],
			'address'	 =>	 $data['address'],
			'phone'		 =>	 $data['phone'],
			'starttime'  =>	 $data['starttime'],
			'endtime'	 =>	 $data['endtime'],
			'body'		 =>	 $data['body'],
			'ctime'		 =>	 time(),
			'did'	     =>	 $data['did'],
		    'toptitle'   =>  $data['toptitle'],
		    'zw'         =>  $data['zw'],
		    'is_open'    =>  $data['is_open'],
		    'sort'       =>  $data['sort'],
            'hits'       =>  $data['hits'],
            'pnum'       =>  $data['pnum'],
            'jnum'       =>  $data['jnum'],
            'zpnum'      =>  $data['zpnum'],
            'anum'       =>  $data['anum'],
            'unum'       =>  $data['unum'],
            'pic'        =>  $data['pic'],
            'banner'     =>  $data['banner'],
            'pic_wap'    =>  $data['pic_wap'],
            'banner_wap' =>  $data['banner_wap']
		);
		if($data['issync']){

			$AddData['issync']	=	$data['issync'];
		}
		if ($AddData && is_array($AddData)){

			$nid	=	$this -> insert_into('zphnet',$AddData);
		}
		return $nid;
	}

    /**
     * @desc 修改招聘会
     * @param $whereData
     * @param array $data
     * @return bool
     */
    public function upInfo($whereData, $data = array())
    {

		if(!empty($whereData)) {

			$PostData	=	array(
				'title'		 =>	 $data['title'],
				'phone'		 =>	 $data['phone'],
				'starttime'  =>	 $data['starttime'],
				'endtime'	 =>	 $data['endtime'],
				'body'		 =>	 $data['body'],
				'did'		 =>	 $data['did'],
			    'toptitle'   =>  $data['toptitle'],
			    'zw'         =>  $data['zw'],
			    'is_open'    =>  $data['is_open'],
                'sort'       =>  $data['sort'],
			    'hits'       =>  $data['hits'],
                'pnum'       =>  $data['pnum'],
                'jnum'       =>  $data['jnum'],
                'zpnum'      =>  $data['zpnum'],
                'anum'       =>  $data['anum'],
                'unum'       =>  $data['unum'],
                'pic'        =>  $data['pic'],
                'banner'     =>  $data['banner'],
                'pic_wap'    =>  $data['pic_wap'],
                'banner_wap' =>  $data['banner_wap']
			);
			if($data['issync']){

				$PostData['issync']	=	$data['issync'];
			}
			if ($PostData && is_array($PostData)){

				$nid	=	$this -> update_once('zphnet',$PostData,array('id'=>$whereData['id']));
			}
			return $nid;
		}
	}

    /**
     * @desc 删除招聘会
     * @param $delId
     * @return array
     */
	public function delZph($delId){

        if (empty($delId)) {

            $return     =   array( 'errcode' => 8, 'msg' => '请选择要删除的数据！');
        } else {
            if (is_array($delId)) {

                $delId  =   pylode(',', $delId);
                $return['layertype']    =   1;
            } else {

                $return['layertype']    =   0;
            }

            $delid      =   $this -> delete_all('zphnet', array('id' => array('in', $delId)), '');

            if ($delid) {

                $this -> delete_all('zphnet_com', array('zid' => array('in', $delId)), '');
                $this -> delete_all('zphnet_look', array('zid' => array('in', $delId)), '');
                $this -> delete_all('zphnet_user', array('zid' => array('in', $delId)), '');
            }
            $return['msg']      =   '网络招聘会';
            $return['errcode']  =   $delid ? '9' : '8';
            $return['msg']      =   $delid ? $return['msg'].'删除成功！' : $return['msg'].'删除失败！';
        }

        return $return;
    }

    /**
     * @desc 获取参会企业列表
     * @param $whereData
     * @param string[] $data
     * @return array|bool|false|string|void
     */
	public function getZphnetComList($whereData , $data=array('utype'=>''))
	{
	    $select  	=  	$data['field'] ? $data['field'] : '*';

	    $List		=	$this -> select_all('zphnet_com' , $whereData, $select);

	    if(!empty($List)){

		    $jobids = $jobuid = $uid  =  $zid  =  array();

			foreach($List as $v){
				if($v['uid'] && !in_array($v['uid'] , $uid)){
					$uid[]  =  $v['uid'];
				}
				if($v['zid'] && !in_array($v['zid'],$zid)){
				    $zid[]  =  $v['zid'];
				}

				if($v['jobid']){

					$jobarr 	=	@explode(',',$v['jobid']);
					$jobids		=	array_merge($jobids,$jobarr);
				}else{
					if(!in_array($v['uid'] , $jobuid)){
						$jobuid[]	=	$v['uid'];
					}
				}
			}
			
			if ($data['utype'] == 'admin'){

			    $company  =  $this -> select_all('company', array('uid'=>array('in',pylode(',',$uid))),'`uid`,`name`,`logo`,`logo_status`,`r_status`');

			    $jfield   =  '`id`,`uid`,`name`';

			    $jobwhere =	 array(
					'state' 	=>	1,
					'status' 	=>	0,
					'r_status'	=>	1
				);

				$jobwhere['PHPYUNBTWSTART'] = 1;
				$jobwhere['uid']	=	array('in',pylode(',',$jobuid));
				$jobwhere['id']	=	array('in',pylode(',',$jobids),'OR');
				$jobwhere['PHPYUNBTWEND'] = 1;

			    $listA	  =  $this -> select_all('company_job',$jobwhere,$jfield);
			}

			$zph	  	=  	$this -> select_all('zphnet',array('id'=>array('in',pylode(',',$zid))),'`id`,`title`,`starttime`,`endtime`');

			$spwhere	=	array('zid' => array('in', pylode(',', $zid)),'groupby'=>'zid');

			if($data['comid']){

				$spwhere['comid'] = array('in',$data['comid']);
			}
			
			$spLog		=	$this->select_all('spview_log',$spwhere, '`zid`, count(*) as `num`, sum(`sptime`) as `sptime_t`');

			foreach($List as $k => $v){

			    $List[$k]['wapurl']         = Url('wap', array('c'=>'zphnet','a'=>'show','id'=>$v['zid']));
			    $List[$k]['bmctime_n']	    =	date('Y-m-d',$v['ctime']);

			    $List[$k]['spnum']			=	0;
			    $List[$k]['sptime_total']	=	0;
			    if(!empty($spLog)){
					foreach($spLog as $val){
						if($v['zid'] == $val['zid']){

							$List[$k]['spnum']			=	$val['num'];					//	视频场次
							$List[$k]['sptime_total']	=	ceil($val['sptime_t'] / 60);	//	视频时间（分钟）
						}
					}
				}

			    if ($data['utype'] == 'admin'){
			        foreach($company as $val){

			            if($v['uid'] == $val['uid']){

			                $List[$k]['comname']	    =	$val['name'];
			            }
			        }
			        $jobname	=	array();

			        foreach($listA as $val){
			            if ($v['uid'] == $val['uid']) {
			                if (count($jobname) < 10){
			                    $jobname[]		        =   $val['name'];
			                    $List[$k]['jobname']    =   @implode('、',$jobname);
			                }
			            }
			        }
			    }
				foreach($zph as $val){

				    if($v['zid'] == $val['id']){
				        $List[$k]['zphname']	=	$val['title'];
				        $List[$k]['title']		=	$val['title'];
				        $List[$k]['starttime']	=	$val['starttime'];
				        $List[$k]['endtime']	=	$val['endtime'];
				        if(strtotime($val['starttime'])>time()){
				            $List[$k]['notstart']	=	1;
				        }
				        if(strtotime($val['endtime'])>time()){
				            $List[$k]['notend'] =   1;
                        }
				    }
				}
			}
		}
		return $List;
	}
	//
	function getAreaComList($whereData, $data = array('zw'=>'','keyword'=>''))
	{
		$whereData['status']   =  1;

		if (!empty($data['zw'])){
	        $whereData['zw'] = $data['zw'];
	    }
	    // 先查出所有参会企业。为排序做准备
	    $comlist =  $this->select_all('zphnet_com', array('zid'=>$whereData['zid'],'status'=>1),'`uid`,`jobid`,`sort`');
	    
	    if (!empty($comlist)){
	        
	        $comid = $jobid = $nojobuid = $ucom = $zcom = array();
	        
	        foreach ($comlist as $v){
	            $comid[] = $v['uid'];
	        }
	        if (!empty($data['keyword'])){
	            // 关键字搜索的，先处理
	            $kcom = $this->select_all('company', array('uid'=>array('in',pylode(',',$comid)), 'name'=>array('like',$data['keyword'])), '`uid`');
	            if (!empty($kcom)){
	                $comid = array();
	                foreach ($kcom as $v){
	                    $comid[] = $v['uid'];
	                }
	            }
	        }
	        // 按处理过的企业id数组来，获取要查询的职位
	        foreach ($comlist as $k=>$v){
	            if (in_array($v['uid'], $comid)){
	                $jobarr = !empty($v['jobid']) ? explode(',', $v['jobid']) : array();
	                if (empty($jobarr)){
	                    $nojobuid[] = $v['uid'];
	                }else{
	                    $jobid = array_merge($jobid, $jobarr);
	                }
	            }else{
	                // 清理掉没搜索到的
	                unset($comlist[$k]);
	            }
	        }
	        // 处理参会职位是空的记录
	        if (!empty($nojobuid)){
	            $otherjob = $this->select_all('company_job', array('uid'=>array('in', pylode(',', $nojobuid)),'state'=>1,'r_status'=>1,'status'=>0),'id');
	            foreach ($otherjob as $v){
	                $jobid[] = $v['id'];
	            }
	        }
	        if (!empty($jobid)){
	            // 按职位更新时间查询，为排序准备数据
	            $sjwhere = array('id'=>array('in', pylode(',', $jobid)),'state'=>1,'r_status'=>1,'status'=>0,'groupby'=>'uid','orderby'=>array('lastupdate,DESC'));
	            $sortjob = $this->select_all('company_job', $sjwhere,'`uid`,`lastupdate`');
	            // 组合企业和最新更新时间数组
	            foreach ($sortjob as $v){
	                $zcom[] = $v['uid'];
	                $ucom[$v['uid']] = $v['lastupdate'];
	            }
	            $lastupdate = $sort = array();
	            
	            foreach ($comlist as $k=>$v){
	                if (!in_array($v['uid'], $zcom)){
	                    // 清掉没有在招职位的企业
	                    unset($comlist[$k]);
	                }else{
	                    foreach ($ucom as $key=>$val){
	                        if ($v['uid'] == $key){
	                            $comlist[$k]['lastupdate'] = $val;
	                            $lastupdate[$k] = $val;
	                            $sort[$k] = empty($v['sort']) ? 0 : $v['sort'];
	                        }
	                    }
	                }
	            }
	            
	            // 根据职位刷新时间、参会企业排序倒序排，参会企业排序值最优先
	            array_multisort($sort, SORT_DESC, $lastupdate, SORT_DESC, $comlist);
	            
	            $uw = $ruid = $njuid = $njobid =array();
	            // 处理分页数据
	            if (is_array($whereData['limit'])){
	                $start = $whereData['limit'][0];
	                $end   = $start + $whereData['limit'][1];
	                // 计算总页数
	                $count = count($comlist);
	                $area['total']  =  intval(ceil($count/$whereData['limit'][1]));
	            }else{
	                $start = 0;
	                $end   = $whereData['limit'];
	                // 计算总页数
	                $count = count($comlist);
	                $area['total']  =  intval(ceil($count/$whereData['limit']));
	            }
	            if (!empty($data['keyword'])){
	                // 关键词搜索时全部展示
	                $end = $count;
	                $area['total']  =  1;
	            }
	            unset($whereData['limit']);
	            
	            foreach ($comlist as $k=>$v){
	                if ($k >=$start && $k < $end){
	                    $uw[] = $v['uid'];
	                }
	            }
	            
	            $whereData['uid'] = array('in', pylode(',', $uw));
	            // 按组装好条件，查询数据
	            $rows  =  $this->select_all('zphnet_com', $whereData);
	            
	            foreach ($rows as $v){
	                $ruid[] = $v['uid'];
	                $jobarr = !empty($v['jobid']) ? explode(',', $v['jobid']) : array();
	                if (empty($jobarr)){
	                    $njuid[] = $v['uid'];
	                }else{
	                    $njobid = array_merge($njobid, $jobarr);
	                }
	            }
	            
	            $company  =  $this->select_all('company', array('uid'=>array('in',pylode(',',$ruid))), '`uid`,`name`,`shortname`,`logo`,`logo_status`,`r_status`,`mun`,`pr`,`hy`');
	            
	            $jfield  =  '`id`,`uid`,`name`,`exp`,`edu`,`sex`,`age`,`marriage`,`minsalary`,`maxsalary`,`lastupdate`';
	            
	            $jobwhere =	 array(
	                'state' 	=>	1,
	                'status' 	=>	0,
	                'r_status'	=>	1
	            );
	            // 区分是否有参会记录中，参会职位为空来区分查询
	            if (!empty($njuid)){
	                $jobwhere['PHPYUNBTWSTART'] = 1;
	                $jobwhere['uid']	=	array('in',pylode(',',$njuid));
	                $jobwhere['id']	    =	array('in',pylode(',',$njobid),'OR');
	                $jobwhere['PHPYUNBTWEND'] = 1;
	            }else{
	                $jobwhere['id']	=	array('in',pylode(',',$njobid));
	            }
	            $jobwhere['orderby'] =['lastupdate, desc'];
	            $job     =  $this->select_all('company_job', $jobwhere,$jfield);
	            
	            include_once ('cache.model.php');
	            $cacheM  =  new cache_model($this->db, $this->def);
	            $cache   =  $cacheM -> GetCache(array('com','hy'));
	            foreach ($company as $k=>$v){
	                if ($v['shortname']){
	                    $company[$k]['comname']  =  $v['shortname'];
	                }else{
	                    $company[$k]['comname']  =  $v['name'];
	                }
	                if ($v['logo_status'] == 0){
	                    $company[$k]['logo']  =  checkpic($v['logo'],$this->config['sy_unit_icon']);
	                }else{
	                    $company[$k]['logo']  =  checkpic($this->config['sy_unit_icon']);
	                }
	                if($v['hy']){
	                    $company[$k]['hy_n']        =    $cache['industry_name'][$v['hy']];
	                }
	                if($v['pr']){
	                    $company[$k]['pr_n']        =    $cache['comclass_name'][$v['pr']];
	                }
	                if($v['mun']){
	                    $company[$k]['mun_n']       =    $cache['comclass_name'][$v['mun']];
	                }
	                foreach ($job as $val){
	                    
	                    if ($v['uid'] == $val['uid']){
	                        
	                        $company[$k]['job'][]  =  $this->jobData($val, $cache);
	                    }
	                }
	            }
	            
	            foreach ($company as $k=>$v){
	                $company[$k]['online']  =  0;
	                $company[$k]['jobnum']  =  count($v['job']);
	                foreach ($v['job'] as $key=>$val){
	                    if ($key > 4){
	                        unset($company[$k]['job'][$key]);
	                    }
	                }
	            }
	            foreach ($comlist as $key=>$val){
	                
	                foreach ($company as $k=>$v){
	                    
	                    if($val['uid']==$v['uid']){
	                        
	                        $comnew[]	=	$v;
	                        
	                    }
	                }
	                
	            }
	            
	            $area['com']  =  $comnew;
	        }
	    }

		return $area;

	}

	private function jobData($job, $cache){

	    $name  =  $cache['comclass_name'];
	    $sex   =  $cache['com_sex'];

	    $data  =  array(
	        'id'=>$job['id'],
	        'uid'=>$job['uid'],
	        'name'=>$job['name']
	    );

	    if (!empty($job['minsalary']) || !empty($job['maxsalary'])) {

	        if(!empty($job['minsalary']) && !empty($job['maxsalary'])){
				if($this ->config['resume_salarytype']==1){
					$data['job_salary']  =  $job['minsalary'].'-'.$job['maxsalary'];
				}else{
	                if($job['maxsalary']<1000){
	                	if($this->config['resume_salarytype']==2){
                            $data['job_salary']      =   '1千以下';
                        }elseif($this->config['resume_salarytype']==3){
                            $data['job_salary']      =   '1K以下';
                        }elseif($this->config['resume_salarytype']==4){
                            $data['job_salary']      =   '1k以下';
                        }
	                }else{
	                    $data['job_salary']      =   changeSalary($job[minsalary]).'-'.changeSalary($job[maxsalary]);
	                }

            	}
	        }elseif (!empty($job['minsalary'])){
	            if($this ->config['resume_salarytype']==1){
                	$data['job_salary']      =   $job["minsalary"];
	            }else{
	                $data['job_salary']  =  changeSalary($job['minsalary']);
	            }
	        }else{

	            $data['job_salary']  =  '面议';
	        }
	    }else{

	        $data['job_salary']      =  '面议';
	    }

	    $require  =  array();
	    if (!empty($job['exp'])){

	        $require[]      =  $name[$job['exp']].'经验';
	    }
	    if (!empty($job['edu'])){

	        $require[]      =  $name[$job['edu']].'学历';
	    }
	    if (!empty($job['age'])){

	        $require[]  =  '年龄'.$name[$job['age']];
	    }
	    if (!empty($job['sex'])){

	        $require[]  =  '性别'.$sex[$job['sex']];
	    }
	    if (!empty($job['marriage'])){

	        $marriage  =  $name[$job['marriage']];

	        if ($marriage == '不限'){

	            $require[]  =  '婚况不限';

	        }else{

	            $require[]  =  $marriage;
	        }
	    }
	    $data['require']  =  implode(',', $require);

	    return $data;
	}
	/**
	* @desc 获取参会企业详细信息
	*/
	public function getZphnetCom($whereData,$data	=	array()){

		$select		=	$data['field'] ? $data['field'] : '*';

		$ZComInfo	=	$this -> select_once('zphnet_com', $whereData, $select);

		return $ZComInfo;

	}
	/**
	* @desc 获取参会企业数量
	*/
	public function getZphnetComNum($whereData=array(),$data=array()){


		if (!empty($data['zw'])){
	        $whereData['zw'] = $data['zw'];
	    }
		return $this -> select_num('zphnet_com', $whereData);

	}

	/**
	 * @desc 获取参会企业数量总数、职位总数量
	 */
	public function getZphnetAllNum($whereData=array(),$data=array())
	{

	    $com  =  $this->select_all('zphnet_com', $whereData, '`uid`,`status`,`jobid`');


		if (!empty($com)){

	    	$jobids	= $jobuid = array();

	        foreach ($com as $v){

	            if($v['status']== 1){
					$uids[]  =  $v['uid'];
				}
				if($v['jobid']){

					$jobarr 	=	@explode(',',$v['jobid']);
					$jobids		=	array_merge($jobids,$jobarr);

				}else{

					if(!in_array($v['uid'] , $jobuid)){
						$jobuid[]	=	$v['uid'];
					}
				}
	        }

	        $jobwhere =	 array(
				'state' 	=>	1,
				'status' 	=>	0,
				'r_status'	=>	1
			);
            if(!empty($jobuid)){

                $jobwhere['PHPYUNBTWSTART'] = 1;
                $jobwhere['uid']	=	array('in',pylode(',',$jobuid));
                $jobwhere['id']	    =	array('in',pylode(',',$jobids),'OR');
                $jobwhere['PHPYUNBTWEND'] = 1;
            }else{
                $jobwhere['id']	    =	array('in',pylode(',',$jobids));
            }

	        $comnum  =  $this->select_num('company',array('uid'=>array('in',pylode(',', $uids)),'r_status'=>1));

	        $jobnum  =  $this->select_num('company_job',$jobwhere);


	        $jobwhere['zp_num'] = array('>',0);
	        $zpnum = $this->select_all('company_job',$jobwhere,'sum(zp_num) as num');
	        $zpnum = $zpnum[0]['num'];
	    }

        $usernum  =  $this->select_num('zphnet_user',array('zid'=>$whereData['zid'],'usertype'=>1),'distinct uid');
        $zphinfo  =  $this->select_once('zphnet',array('id'=>$whereData['zid']),'pnum,jnum,anum,zpnum,unum,starttime,endtime');
        if(!empty($jobuid)){

            $userjobwehre['PHPYUNBTWSTART'] =   1;
            $userjobwehre['com_id']         =   array('in',pylode(',',$jobuid));
            $userjobwehre['job_id']         =   array('in',pylode(',',$jobids),'OR');
            $userjobwehre['PHPYUNBTWEND']   =   1;
        }else{
            $userjobwehre['job_id']	        =	array('in',pylode(',',$jobids));
        }
        $userjobwehre['PHPYUNBTWSTART_B']   =   "";
        $userjobwehre['datetime'][]         =   array(">=" , strtotime($zphinfo['starttime']));
        $userjobwehre['datetime'][]         =   array("<=" , strtotime($zphinfo['endtime']),'and');
        $userjobwehre['PHPYUNBTWEND_B']     =   "";
        $userjobnum                         =   $this->select_num('userid_job',$userjobwehre);

        if ($zphinfo['pnum'] > 0) {
            $comnum = $comnum + $zphinfo['pnum'];
        }
        if ($zphinfo['anum'] > 0) {
            $userjobnum = $userjobnum + $zphinfo['anum'];
        }
        if ($zphinfo['zpnum'] > 0) {
            $zpnum = $zpnum + $zphinfo['zpnum'];
        }
        if ($zphinfo['jnum'] > 0) {
            $jobnum = $jobnum + $zphinfo['jnum'];
        }
        if ($zphinfo['unum'] > 0) {
            $usernum = $usernum + $zphinfo['unum'];
        }

	    $return  =  array(
	        'comnum'        =>  isset($comnum) ? $comnum : 0,
	        'jobnum'        =>  isset($jobnum) ? $jobnum : 0,
	        'usernum'       =>  isset($usernum) ? $usernum : 0,
            'zpnum'         =>  isset($zpnum) ? $zpnum : 0,
            'userjobnum'    =>  isset($userjobnum) ? $userjobnum : 0,
	    );

	    return $return;
	}

	/**
	* @desc 添加参会企业
	*/
	public function addZphnetCom($data	=	array()){

	    $return   =  array();
		$AddData  =  array(
			'uid'		=>	$data['comid'],
			'zid'		=>	$data['zphid'],
			'sort'		=>	$data['sort'],
			'ctime'		=>	time(),
			'status'	=>	isset($data['status']) ? $data['status'] : 1,
		    'jobid'     =>  $data['jobid']
		);

		$row  =  $this->select_once('zphnet_com',array('zid'=>$AddData['zid'],'uid'=>$AddData['uid']));

		if (!empty($row)){

		    $return['errcode']  =  8;
		    $return['msg']		=  '该企业已参加本次招聘会';

		}else{

		    $nid	=	$this -> insert_into('zphnet_com',$AddData);

		    $return['errcode']  =  9;
		    $return['msg']		=  '添加成功';
		    $return['id']       =  $nid;
		}
		return $return;
	}

	/**
	 * @desc   审核参会企业表信息
	 */
	public  function zphnetComStatus($id , $data = array(), $data1 = array()){
        $where  =   array();

        if (! empty($id)) {

            $where['id']    =   array( 'in', pylode(',', $id));

            if ($data['status']) {

                $updata     =   array('status' => $data['status'],'statusbody' => $data['statusbody']);

            }else if ($data['did']) {

                $updata     =   array('did' => $data['did']);
            }

            $nid            =   $this->update_once('zphnet_com', $updata, $where);

            if (!empty($data['status'])) {

                $List           =   $this -> getZphnetComList($where, $data1);

                /* 消息前缀 */
                $tagName        =   '参会企业';

                if (! empty($List)) {

                    foreach ($List as $v) {

                        $uids[] =   $v['uid'];

                        if ($updata['status'] == 2) {

                            $statusInfo       =  $tagName . ':<a href="zphnettpl,'.$v['zid'].'">'.$v['comname'].'</a>,审核未通过';

                            if ($updata['statusbody']) {

                                $statusInfo  .=  ' , 原因：' . $updata['statusbody'];
                            }

                            $msg[$v['uid']]   =  $statusInfo;

                        } elseif ($updata['status'] == 1) {

                            $msg[$v['uid']]   =  $tagName . ':<a href="zphnettpl,'.$v['zid'].'">'.$v['comname'].'</a>,已审核通过';
                        }
                    }

                    // 发送系统通知
                    include_once ('sysmsg.model.php');
                    $sysmsgM    = new sysmsg_model($this->db, $this->def);
                    $sysmsgM -> addInfo(array('uid' => $uids,'usertype'=>2, 'content' => $msg));
                }
            }

            return $nid;
        }
    }

	/**
	* @desc  删除参会企业
	*/
	public function delZphnetCom($delId = null, $uid=''){


        if (empty($delId)) {

            $return         =   array('errcode' => 8, 'msg' => '请选择要删除的数据！');
        } else {

            if (is_array($delId)) {

                $delId                  =   pylode(',', $delId);

                $return['layertype']    =   1;
            } else {

                $return['layertype']    =   0;
            }
            $zcwhere	=	array('id'=>array('in',$delId));
            if($uid!=''){
            	$zcwhere['uid']	=	$uid;
            }
            $list  =  $this->select_all('zphnet_com',$zcwhere);

            if(!empty($list)){
                $zuid = array();
                foreach ($list as $v){

                    if(!in_array($v['uid'],$zuid)){
                    	$zuid[]  =  $v['uid'];
                    }

                    $zid  =  $v['zid'];

                }

                $this->delete_all('zphnet_look',array('zid'=>$zid,'comid'=>array('in',pylode(',', $zuid))),'');

            }

            $return['id']       =   $this -> delete_all('zphnet_com', $zcwhere, '');

            $return['errcode']  =   $return['id'] ? 9 : 8;

            $msg                =   '网络招聘会参会企业（ID：'.$delId.'）';

            $return['msg']      =   $return['id'] ? $msg.'删除成功！' : '删除失败！';
        }
        return $return;
    }

	/**
	 * @desc   招聘会预定
	 */
	public function ajaxZphnet($data = array())
	{

	    $uid        =   intval($data['uid']);
	    $spid		=   intval($data['spid']);
	    $usertype   =   intval($data['usertype']);

	    $did        =   $data['did'] ? intval($data['did']) : $this->config['did'];
	    $zid        =   $data['zid'] ? intval($data['zid']) : '';

	    $time       =   time();
	    $return     =   array();

	    if (empty($uid) || empty($usertype)) {

	        $return['login']    =   1;

	    } else if ($usertype != 2) {

	        $return['msg']      =   '企业用户才可以预定招聘会！';

	    } else {

	    	//判断后台是否开启该单项购买
	        $single_can     =   @explode(',', $this->config['com_single_can']);
	        $serverOpen     =   1;
	        if(!in_array('zphnet',$single_can)){
	            $serverOpen =   0;
	        }

	        $zph    =   $this->getInfo(array('id' => $zid), array('field' => '`starttime`,`endtime`'));

	        if (strtotime($zph['endtime']) < $time) {

	            $return['msg']  =   '招聘会已经结束！';
	        } else {

	            $cInfo  =  $this->select_once('company',array('uid' => $uid), '`name`,`r_status`');

	            if (empty($cInfo['name'])){

	                $return['msg']	=	'请先完善基本资料！';

	            } elseif ($cInfo['r_status'] != 1) {

	                $return['msg']  =   '您的账号未通过审核，请联系管理员加速审核进度！';

	            } else {

	                $zphcom  =  $this->getZphnetCom(array('uid' => $uid, 'zid' => $zid));

	                if (!empty($zphcom)) {

	                    if ($zphcom['status'] == 2) {

	                        $return['msg'] = '您的报名未通过审核，请联系管理员！';
	                    } else {
	                        $return['msg']      = '您已报名该招聘会！';
	                    }
	                } else {

	                    $suid   =   !empty($spid) ? $spid : $uid;

	                    require_once ('statis.model.php');
	                    $statisM  =  new statis_model($this->db, $this->def);
	                    $statis   =  $statisM -> getInfo($suid, array('usertype' => $usertype, 'field' => '`rating_type`,`vip_etime`,`zph_num`,`integral`'));

	                    $com      =  $this->select_once('company',array('uid'=>$uid),'`name`');

	                    $zData              =   array();
	                    $zData['uid']       =   $uid;
	                    $zData['usertype']  =   $usertype;
	                    $zData['com_name']  =   $com['name'];
	                    $zData['did']       =   $did;
	                    $zData['zid']       =   $zid;
						$zData['jobid']		=   $data['jobid'];
	                    $zData['fuid']      =   $uid;
	                    // 价格

	                    $price   =  $this->config['integral_zphnet'];
	                    $jifen   =  $price * $this->config['integral_proportion'];
	                    $online  =  $this->config['com_integral_online'];

	                    if ($price == 0) {

	                        $return = $this->reserveZphnet($zData);

	                        return $return;
	                    }

	                    if (isVip($statis['vip_etime'])) {

	                        if ($statis['rating_type'] == 1) {

	                            // 没有招聘会报名次数
	                            if ($statis['zph_num'] == 0) {

	                                if(empty($spid)){

	                                    if ($online != 4) { // 套餐模式

	                                        if ($online == 3 && !in_array('zphnet', explode(',', $this->config['sy_only_price']))) { // 积分消费
	                                        	if($serverOpen){
	                                        		$return['msg']      =   "您的等级特权已经用完，继续报名将消费 <span style=color:red;>" .$jifen . "</span> ".$this->config['integral_pricename']."，是否继续？";
	                                        	}else{
	                                        		$return['msg']          =   "您的等级特权已经用完，可以<a href=\"" . $this->config['sy_weburl'] . "/wap/member/index.php?c=rating\" style=\"color:red;cursor:pointer;\">购买会员</a>！";
	                                        	}
	                                            
	                                            $return['url']      =   $this->config['sy_weburl'] . 'wap/member/index.php?c=getserver&id=' . $uid . '&server=15';
	                                            $return['jifen']    =   $jifen;
	                                            $return['integral'] =   intval($statis['integral']);
	                                            $return['pro']      =   $this->config['integral_proportion'];
	                                        } else {

	                                            $return['url']      =   $this->config['sy_weburl'] . 'wap/member/index.php?c=getserver&id=' . $uid . '&server=15';
	                                            if($serverOpen){
		                                            $return['msg']      =   "您的等级特权已经用完，继续报名将消费 <span style=color:red;>" . $price . "</span> 元，是否继续？";
		                                        }else{
		                                        	$return['msg']          =   "您的等级特权已经用完，可以<a href=\"" . $this->config['sy_weburl'] . "/wap/member/index.php?c=rating\" style=\"color:red;cursor:pointer;\">购买会员</a>！";
		                                        }
	                                            $return['price']    =   $price;
	                                        }
	                                    } else {
	                                    	$return['price']    	=   $price;
	                                        $return['url']          =   $this->config['sy_weburl'] . 'wap/member/index.php?c=rating';
	                                        $return['msg']          =   "您的等级特权已经用完，可以<a href=\"" . $this->config['sy_weburl'] . "/wap/member/index.php?c=rating\" style=\"color:red;cursor:pointer;\">购买会员</a>！";
	                                    }
	                                    $return['zid']      =   $zid;
	                                    $return['status']   =   2;
	                                }else{

	                                    $return['msg']  =   '当前账户套餐余量不足，请联系主账户增配！';
	                                }

	                            } else {

	                                $statisM -> upInfo(array('zph_num' => array('-', 1)), array('uid' => $suid, 'usertype' => $usertype));
	                                $return     =   $this->reserveZphnet($zData);
	                            }
	                        } else if ($statis['rating_type'] == 2) {

	                            // 判断当天是否已达到最大报名次数
	                            require_once ('company.model.php');
	                            $companyM  =  new company_model($this->db, $this->def);
	                            $result    =  $companyM->comVipDayActionCheck('zphnet', $uid);

	                            if ($result['status'] != 1) {
	                                return $result;
	                            }

	                            $return         =   $this->reserveZphnet($zData);
	                        }
	                    } else { // 过期会员

	                        if(empty($spid)){

	                            if ($online != 4) {

	                                if ($online == 3 && !in_array('zphnet', explode(',', $this->config['sy_only_price']))) { // 积分消费

 	                                    $return['jifen']    =   $jifen;
	                                    $return['integral'] =   intval($statis['integral']);
	                                    $return['pro']      =   $this->config['integral_proportion'];
	                                } else {
	                                    $return['price']    =   $price;
	                                }
	                                $return['msg']      =   "你的会员已到期，请先购买会员！";
	                            } else {
	                                $return['url']  =   $this->config['sy_weburl'] . 'wap/member/index.php?c=rating';
	                                $return['msg']  =   "你的会员已到期，你可以<a href='" . $this->config['sy_weburl'] . "/wap/member/index.php?c=rating' style='color:red;cursor:pointer;'>购买会员</a>！";
	                            }
	                            $return['zid']      =   $zid;
	                            $return['status']   =   2;

	                        }else{

	                            $return['msg']  =   '当前账户会员已过期，请联系主账户升级！';
	                        }
	                    }
	                }
	            }
	        }
	    }
	    return $return;
	}
	/**
	 * 修改参会企业
	 * @param array $where
	 * @param array $up
	 */
	public function upZphnetCom($where = array(), $up = array())
	{
	    $return  =  array();
	    if (!empty($where)){

	        $nid  =  $this->update_once('zphnet_com', $up, $where);

	        $return['errcode']	=	$nid ? '9' :'8';
	        $return['msg']		=	$nid ? '参会企业修改成功！' : '修改失败！';
	    }
	    return $return;
	}

	/**
     * 修改参会企业参会职位
	*/
	public function editZphnetComjob($where = array(),$post = array()){
        $return  =  array();
        if (!empty($where)){
            $up['jobid'] = $post['jobid'];
            $nid  =  $this->update_once('zphnet_com', $up, $where);
            if($nid && $post['uid']){
                //查询职位名称
                $jfield   =  '`id`,`uid`,`name`';
                $jobwhere['id']	=	array('in',$up['jobid']);
                $listA	  =  $this -> select_all('company_job',$jobwhere,$jfield);
                if ($listA){
                    $jobnamestr = '';
                    foreach ($listA as $k=>$v){
                        if($jobnamestr == ''){
                            $jobnamestr .= $v['name'];
                        }else{
                            $jobnamestr .= ",".$v['name'];
                        }
                    }
                }
                require_once ('log.model.php');
                $logM  =  new log_model($this->db, $this->def);
                $logM -> addMemberLog($post['uid'], $post['usertype'],'修改网络招聘会参会职位：'.$jobnamestr,14,1);
            }
            $return['errcode']	=	$nid ? '9' :'8';
            $return['msg']		=	$nid ? '参会职位修改成功！' : '修改失败！';
        }
        return $return;
    }
	/**
	 * @Desc   网络招聘会报名
	 *
	 * @param array $data
	 */
	private function reserveZphnet($data = array()){

	    $sql  =  array(
	        'uid'       =>  $data['uid'],
	        'com_name'  =>  $data['com_name'],
	        'zid'       =>  $data['zid'],
			'jobid'		=>	$data['jobid'],
	        'ctime'     =>  time(),
	        'status'    =>  0,
	        'did'       =>  $data['did']
	    );

	    require_once('company.model.php');
        $comM      =   new company_model($this->db,$this->def);

	    $com     =   $comM -> getInfo($data['uid'], array('field' => '`name`'));

	    $zph     =   $this -> getInfo(array('id' =>$data['zid']));

	    $nid     =  $this->insert_into('zphnet_com', $sql);
	    $return  =  array();

	    if ($nid){
	        require_once ('log.model.php');
	        $logM  =  new log_model($this->db, $this->def);
	        $logM -> addMemberLog($data['fuid'], $data['usertype'],'报名网络招聘会,ID:'.$data['zid'],14,1);

	        require_once('admin.model.php');
	        $adminM  =  new admin_model($this->db,$this->def);
	        $adminM -> sendAdminMsg(array('first'=>'有新的网络招聘会报名需要审核，企业《'.$com['name'].'》报名网络招聘会《'.$zph['title'].'》','type'=>13));

	        $return['status']  =  1;
	        $return['msg']     =  '报名成功,等待管理员审核！';

	    }else{
	        $return['msg']     =  '报名失败,请稍候重试！';
	    }
	    return $return;
	}
	function insertZphnetCom($data=array()){
		$nid     =  $this->insert_into('zphnet_com', $data);
		return $nid;
	}
	/**
	 * 记录用户进入网络招聘会大厅，同一招聘会不重复记录
	 * @param array $data
	 */
	public function addZphnetUser($data = array()){

	    if (!empty($data['zid']) && !empty($data['uid']) && !empty($data['usertype'])){
            
	        if ($data['usertype'] == 1 || $data['usertype'] == 2){
	            
	            $row  =  $this->select_once('zphnet_user',array('zid'=>$data['zid'],'uid'=>$data['uid'],'usertype'=>$data['usertype']));
	            
	            if (empty($row)){
	                
	                if ($data['usertype'] == 1){
	                    // 个人用户 能在列表正常展示的简历，才统计
	                    $expect  =  $this->select_once('resume_expect',array('uid'=>$data['uid'],'defaults'=>1,'state'=>'1','status'=>'1','r_status'=>'1'),'`id`');
	                    
	                    if (empty($expect)){
	                        return;
	                    }
	                }
	                
	                $data['ctime']  =  time();
	                
	                $this->insert_into('zphnet_user',$data);
	            }
	        }
	    }
	}
	/**
	 * 查询进入大厅记录
	 */
	public function getZphnetUser($where = array(),$data = array('resume'=>'','keyword'=>'','photo'=>'','utype'=>''))
	{
	    // 求职者大厅
	    if (!empty($data['resume'])){

	        $row  =  $this->select_all('zphnet_user',array('zid'=>$where['zid'],'usertype'=>1,'orderby'=>'ctime','limit'=>$data['resume']),'`uid`');

	        if (!empty($row)){

	            foreach ($row as $v){

	                $uids[]  =  $v['uid'];
	            }

	            include_once('resume.model.php');
	            $resumeM  =  new resume_model($this->db, $this->def);
	            if ($data['utype'] == 'admin'){
                    $rwhere = array('uid' => array('in', pylode(',', $uids)));
                }else {
                    $rwhere = array('uid' => array('in', pylode(',', $uids)), 'defaults' => 1, 'state' => '1', 'status' => '1', 'r_status' => '1');
                }
	            if (!empty($data['keyword'])){

	                $rwhere['name']  =  array('like', $data['keyword']);
	            }

	            $expect   =  $resumeM->getList($rwhere,array('utype'=>'zphnet'));

	            return $expect['list'];
	        }
	    }else{

	        $row  =  $this->select_all('zphnet_user',$where);

	        if (!empty($row)){
	            $u  =  $c  =  array();

	            foreach ($row as $v){

	                if ($v['usertype'] == 1){
	                    $u[]  =  $v['uid'];
	                }elseif ($v['usertype'] == 2){
	                    $c[]  =  $v['uid'];
	                }
	            }
	            if (!empty($c)){

                    $com  =  $this->select_all('company',array('uid'=>array('in',pylode(',', $c))),'`uid`,`name`,`shortname`,`logo`,`logo_status`');
	            }
	            if (!empty($u)){

                    $user  =  $this->select_all('resume',array('uid'=>array('in',pylode(',', $u))),'`uid`,`name`,`photo`,`phototype`,`photo_status`,`sex`');
	            }

	            foreach ($row as $k=>$v){

	                foreach ($com as $val){

	                    if ($v['uid'] == $val['uid']){

	                        if ($val['shortname']){

	                            $row[$k]['name']  =  $val['shortname'].'进入了大厅';

	                        }else{

	                            $row[$k]['name']  =  $val['name'].'进入了大厅';
                            }
                            if($val['logo'] !='' && $val['logo_status']==0){
                                $row[$k]['photo_n'] = checkpic($v['logo'],$this->config['sy_unit_icon']);
                            }else{
                                $row[$k]['photo_n'] = checkpic($this->config['sy_unit_icon']);
                            }
	                    }
	                }
	                foreach ($user as $val){

	                    if ($v['uid'] == $val['uid']){

	                        $name  =  mb_substr($val['name'], 1, 1, 'utf8');
	                        $row[$k]['name']  = str_replace($name, '*', $val['name']).'进入了大厅';
	                        //设置头像
                            $maleUrl  	  =  checkpic('',$this -> config['sy_member_icon']);
                            $femaleUrl    =  checkpic('',$this -> config['sy_member_iconv']);
                            $sexArr		  =	 array(1, 152);
                            if($val['defphoto']==2){
                                $resumePhoto        =   checkpic($val['photo']);
                            }else{
                                if(empty($this -> config['user_pic']) || $this -> config['user_pic'] == 1){
                                    if($val['photo'] && $val['photo_status'] == 0 && $val['phototype'] != 1){
                                        $resumePhoto		=	checkpic($val['photo']);
                                    }else{
                                        if(in_array($val['sex'], $sexArr)){
                                            $resumePhoto	=	$maleUrl;
                                        }else{
                                            $resumePhoto	=	$femaleUrl;
                                        }
                                    }
                                }elseif($this -> config['user_pic'] == 2){
                                    if($val['photo'] && $val['photo_status'] == 0){
                                        $resumePhoto		=	checkpic($val['photo']);
                                    }else{
                                        if(in_array($val['sex'], $sexArr)){
                                            $resumePhoto	=	$maleUrl;
                                        }else{
                                            $resumePhoto	=	$femaleUrl;
                                        }
                                    }
                                }elseif($this -> config['user_pic'] == 3){
                                    if(in_array($val['sex'], $sexArr)){
                                        $resumePhoto		=	$maleUrl;
                                    }else{
                                        $resumePhoto		=	$femaleUrl;
                                    }
                                }
                            }
                            $row[$k]['photo_n'] = $resumePhoto;
	                    }
	                }
	            }
	            return $row;
	        }
	    }
	}

    /***
     * 删除网络招聘会参会个人记录
     * @param null $delId
     * @param string $uid
     * @return array
     */
    public function delZphnetUser($delId = null, $uid=''){

        if (empty($delId)) {

            $return         =   array('errcode' => 8, 'msg' => '请选择要删除的数据！');
        } else {

            if (is_array($delId)) {

                $delId                  =   pylode(',', $delId);

                $return['layertype']    =   1;
            } else {

                $return['layertype']    =   0;
            }
            $zcwhere	=	array('uid'=>array('in',$delId));
            if($uid!=''){
                $zcwhere['uid']	=	$uid;
            }
            $return['id']       =   $this -> delete_all('zphnet_user', $zcwhere, '');

            $return['errcode']  =   $return['id'] ? 9 : 8;

            $msg                =   '网络招聘会参会个人（ID：'.$delId.'）';

            $return['msg']      =   $return['id'] ? $msg.'删除成功！' : '删除失败！';
        }
        return $return;
    }


	/**
	 * 网络招聘会查看职位记录
	 */
	public function addZphnetLook($data = array()){

	    if (!empty($data)){

	        if (!empty($data['uid'])){

	            $row  =  $this->select_once('zphnet_look',array('uid'=>$data['uid'],'zid'=>$data['zid'],'jobid'=>$data['jobid']));
	        }
	        // 用户登录时，个人查看才记录
	        if (empty($row) && (empty($data['usertype']) || (!empty($data['usertype']) && $data['usertype'] ==1))){

	            $nid  =  $this->insert_into('zphnet_look',$data);
	        }

	        return $nid;
	    }
	}
	/**
	 * 获取招聘会查看职位记录
	 */
	public function getZphnetLook($where = array()){

	    $list  =  $this->select_all('zphnet_look',$where);

	    if (!empty($list)){

	        $j  =  $u  =  $c  =  array();

	        foreach ($list as $v){

	            $j[]  =  $v['jobid'];
	            if ($v['usertype'] == 1){

	                $u[]  =  $v['uid'];
	            }
	            if (!empty($v['comid'])){

	                $c[]  =  $v['comid'];
	            }
	        }
	        if (!empty($j)){
	            $job   =  $this->select_all('company_job',array('id'=>array('in',pylode(',', $j))),'`id`,`name`');
	        }
	        if (!empty($u)){
	            $user  =  $this->select_all('resume',array('uid'=>array('in',pylode(',', $u))),'`uid`,`name`,`photo`,`phototype`,`photo_status`,`sex`');
	        }
	        if (!empty($c)){
	            $com  =  $this->select_all('company',array('uid'=>array('in',pylode(',', $c))),'`uid`,`name`,`shortname`,`logo`,`logo_status`');
	        }

	        foreach ($list as $k=>$v){

	            if (!empty($job)){
	                foreach ($job as $val){

	                    if ($v['jobid'] == $val['id']){

	                        $list[$k]['jobname']  =  $val['name'];
	                    }
	                }
	            }

	            $list[$k]['name']  = '访客';
                $list[$k]['photo_n'] = checkpic("",$this->config['sy_member_icon']);
	            if (!empty($user)){

	                foreach ($user as $val){

	                    if ($v['uid'] == $val['uid']){

	                        $name  =  mb_substr($val['name'], 1, 1, 'utf8');
	                        $list[$k]['name']  = str_replace($name, '*', $val['name']);
                            //设置头像
                            $maleUrl  	  =  checkpic('',$this -> config['sy_member_icon']);
                            $femaleUrl    =  checkpic('',$this -> config['sy_member_iconv']);
                            $sexArr		  =	 array(1, 152);
                            if($val['defphoto']==2){
                                $resumePhoto        =   checkpic($val['photo']);
                            }else{
                                if(empty($this -> config['user_pic']) || $this -> config['user_pic'] == 1){
                                    if($val['photo'] && $val['photo_status'] == 0 && $val['phototype'] != 1){
                                        $resumePhoto		=	checkpic($val['photo']);
                                    }else{
                                        if(in_array($val['sex'], $sexArr)){
                                            $resumePhoto	=	$maleUrl;
                                        }else{
                                            $resumePhoto	=	$femaleUrl;
                                        }
                                    }
                                }elseif($this -> config['user_pic'] == 2){
                                    if($val['photo'] && $val['photo_status'] == 0){
                                        $resumePhoto		=	checkpic($val['photo']);
                                    }else{
                                        if(in_array($val['sex'], $sexArr)){
                                            $resumePhoto	=	$maleUrl;
                                        }else{
                                            $resumePhoto	=	$femaleUrl;
                                        }
                                    }
                                }elseif($this -> config['user_pic'] == 3){
                                    if(in_array($val['sex'], $sexArr)){
                                        $resumePhoto		=	$maleUrl;
                                    }else{
                                        $resumePhoto		=	$femaleUrl;
                                    }
                                }
                            }
                            $row[$k]['photo_n'] = $resumePhoto;
	                    }
	                }
	            }
	            if (!empty($com)){

	                foreach ($com as $val){

	                    if ($v['comid'] == $val['uid']){

	                        if ($val['shortname']){

	                            $list[$k]['comname']  =  $val['shortname'];

	                        }else{

	                            $list[$k]['comname']  =  $val['name'];
	                        }

	                    }
	                }
	            }
	        }
	    }

	    return $list;
	}
	/**
	 * wxapp 参展职位列表
	 */
	public function getZphnetJob($where = array(), $data = array())
	{
	    $return  =  array();

	    if (!empty($where['zid'])){

	        $zphcom  =  $this->select_all('zphnet_com', array('zid'=>$where['zid'],'status'=>1),'`uid`,`jobid`');

	        if (!empty($zphcom)){

	        	$jobids = $jobuid = array();

	            foreach ($zphcom as $v){

	                $cuid[]  =  $v['uid'];

	                if($v['jobid']){

						$jobarr 	=	@explode(',',$v['jobid']);
						$jobids		=	array_merge($jobids,$jobarr);

					}else{

						if(!in_array($v['uid'] , $jobuid)){
							$jobuid[]	=	$v['uid'];
						}
					}
	            }
	            
	            $jwhere =	 array(
					'state' 	=>	1,
					'status' 	=>	0,
					'r_status'	=>	1
				);

				$jwhere['PHPYUNBTWSTART'] = 1;
				$jwhere['uid']	=	array('in',pylode(',',$jobuid));
				$jwhere['id']	=	array('in',pylode(',',$jobids),'OR');
				$jwhere['PHPYUNBTWEND'] = 1;

	            if (!empty($data['keyword'])){

	                $jwhere['name']  =  array('like',$data['keyword']);
	            }
	            $jwhere['limit']  =  $where['limit'];

	            $job  =  $this->select_all('company_job',$jwhere,'`id`,`uid`,`name`,`exp`,`edu`,`minsalary`,`maxsalary`');

	            if (!empty($job)){

	                foreach ($job as $v){

	                    $juid[]  =  $v['uid'];
	                }
	                $juid  =  array_unique($juid);

	                $com   =  $this->select_all('company',array('uid'=>array('in',pylode(',', $juid))),'`uid`,`name`,`shortname`');

	                include_once('cache.model.php');
	                $cacheM  =  new cache_model($this->db,$this->def);
	                $cache   =   $cacheM -> GetCache('com');

	                foreach ($job as $k=>$v){

	                    $job[$k]['exp_n']  =  $cache['comclass_name'][$v['exp']].'经验';
	                    $job[$k]['edu_n']  =  $cache['comclass_name'][$v['edu']].'学历';

	                    if (!empty($v['minsalary']) || !empty($v['minsalary'])) {

	                        if(!empty($v['minsalary']) && !empty($v['maxsalary'])){
	                            if($this ->config['resume_salarytype']==1){
	                            	$job[$k]['job_salary']  =  $v['minsalary'].'-'.$v['maxsalary'].'元';
	                            }else{
	                            	if($v['maxsalary']<1000){
	                            		if($this->config['resume_salarytype']==2){
				                            $job[$k]['job_salary']  =  '1千以下';
				                        }elseif($this->config['resume_salarytype']==3){
				                            $job[$k]['job_salary']  =  '1K以下';
				                        }elseif($this->config['resume_salarytype']==4){
				                            $job[$k]['job_salary']  =  '1k以下';
				                        }
	                            	}else{
	                            		$job[$k]['job_salary']  =  changeSalary($v['minsalary']).'-'.changeSalary($v['maxsalary']);
	                            	}
	                            }
	                        }elseif (!empty($v['minsalary'])){
	                            if($this ->config['resume_salarytype']==1){
	                            	$job[$k]['job_salary']  =  $v['minsalary'].'元';
	                            }else{
	                            	$job[$k]['job_salary']  =  changeSalary($v['minsalary']);
	                            }
	                        }else{

	                            $job[$k]['job_salary']  =  '面议';
	                        }
	                    }else{

	                        $job[$k]['job_salary']      =  '面议';
	                    }

	                    foreach ($com as $val){

	                        if ($v['uid'] == $val['uid']){

	                            if ($val['shortname']){

	                                $job[$k]['comname']  =  $val['shortname'];

	                            }else {

	                                $job[$k]['comname']  =  $val['name'];
	                            }
	                        }
	                    }
	                }
	            }
	        }
	        if (!empty($job)){

	            $return  =  $job;
	        }

	        return $return;
	    }
	}
	/**
	 * 推荐企业类别列表
	 */
	public function getClassList($where = array(), $data = array())
	{

	    $list  =  $this->select_all('zphnet_class',$where);

	    return $list;
	}
	/**
	 * 展位分区类别
	 */
	public function getClass($where = array())
	{

	    $list  =  $this->select_once('zphnet_class',$where);
	    return $list;
	}
	/**
	 * 添加或更新展位分区
	 * $addData 	提交分类数据
	 * $whereData 	更新分类查询条件
	 */
	function addClass($addData=array(),$whereData = array()){

		if(!empty($whereData)){
			if($addData['name']){//修改名称
				$type	=	'名称';
			}else{
				unset($addData['name']);
			}
			if($addData['sort']){//修改排序
				$type	=	'排序';
			}else{
				unset($addData['sort']);
			}
			$this->update_once('zphnet_class',$addData,$whereData);
			$showid	 =  $whereData['id'] ? "(ID:".$whereData['id'].")" : '';
			$this->adminLog('网络招聘会展位分区类别'.$showid.$type.'修改成功');
		}else{
			$name				=	array();
			foreach ($addData['name'] as $val){
				if($val){
					$name[]		= 	$val;
				}
			}

			if($addData['keyid']){
				$where['keyid'] =	$addData['keyid'];
			}
			if(count($name)){
				$where['name']  =	array('in',"'".@implode("','",$name)."'");
			}
			//检查提交的类别名称是否有同名
			$class			    =	$this->getClassList($where);
			$valueData			=	array();

			if(empty($class)){//没有同名类则正常添加
				if($addData['ctype'] == '1'){//添加的是一级分类
					foreach ($name as $key => $val){
			            $valueData[$key]['name']		= $val;

			        }
			    }else{//添加二级分类
					foreach ($name as $key => $val){
						$valueData[$key]['name'] 	= $val;
			            $valueData[$key]['keyid'] 	= intval($addData['keyid']);
			        }
			    }
				$nid 			=	$this->DB_insert_multi('zphnet_class',$valueData);
				$return['msg']	=	$nid ? 2 : 3;
				$this 			->  adminLog('网络招聘会展位分区类别添加成功');
			}else{//有同名类，给出提示
				$return['msg']	=	1;
			}
		}
		return	$return;
	}
	/**
	 * 修改企业推荐类别
	 */
	public function insertClass($data = array())
	{
	    if (!empty($data)){

	        $zcid	=	$this->insert_into('zphnet_class', $data);

	        return $zcid;
	    }
	}
	/**
	 * 修改企业推荐类别
	 */
	public function upClass($where = array(), $data = array())
	{
	    if (!empty($data)){

	        $this->update_once('zphnet_class', $data, $where);
	    }
	}
	/**
	 * 删除招聘会企业推荐类别
	 */
	public function delClass($delId){

	    if (empty($delId)) {

	        $return     =   array( 'errcode' => 8, 'msg' => '请选择要删除的数据！');

	    } else {

	        if (is_array($delId)) {

	            $delId  =   pylode(',', $delId);

	            $return['layertype']    =   1;

	        } else {

	            $return['layertype']    =   0;
	        }

	        $id					=	array();
	        $sclass				=	$this	->	select_all('zphnet_class',array('id' => array('in', $delId)),'id');
	        foreach ($sclass as $key => $value) {
	            $id[]			=	$value['id'];
	        }
	        $ids				=	$this->sonclass('zphnet_class',$id);//获取当前项及其所有子类的id集合
	        if(count($ids)){
	            $result			=	$this->delete_all('zphnet_class',array('id'=>array('in',pylode(',',$ids))),'');
	        }
	        $return['errcode']	=	$result ? '9' :'8';
	        $return['msg']		=	$result ? '网络招聘会展位分区类别删除成功！' : '删除失败！';
	    }

	    return $return;
	}
	function sonclass($table,$id=array()){
	    $ids	=	array();
	    if(count($id)){
	        $class	=	$this	->	select_all($table,array('keyid'=>array('in',pylode(',',$id))),'id');
	        if($class&&is_array($class)){
	            foreach($class as $val){
	                $ids[]	=	$val['id'];
	            }
	        }
	        $ids	=	array_merge($id,$ids);
	    }
	    return $ids;
	}

    /**
     * 修改招聘前台显示
     */

    public function upIsOpen($id,$is_open){
        if (!empty($id)) {
            $result  =  $this->update_once('zphnet',array('is_open' => $is_open), array('id' => $id));

            if ($result){
                $return['msg']          =   '修改成功！';
                $return['errcode']      =   9;
            }else{
                $return['msg']          =   '修改失败！';
                $return['errcode']      =   8;
            }
        }else{
            $return['msg']          =   '参数错误！';
            $return['errcode']      =   8;
        }
        return $return;
    }

	/*
	 * 添加管理员日志
	 */
	function adminLog($content, $opera = '', $type = '', $opera_id=''){
	    require_once('log.model.php');
	    $logM	=	new log_model($this->db,$this->def);
	    return	$logM	->	addAdminLog($content, $opera = '', $type = '', $opera_id='');
	}

    //更新网络招聘会浏览数
    function addZphnetHits($id){
        if($this -> config['sy_job_hits'] > 100 || !$this -> config['sy_job_hits']){
            $hits       =   1;
        }else{
            $hits       =   mt_rand(1, $this->config['sy_job_hits']);
        }

        $this -> update_once('zphnet', array('hits' => array('+', $hits)), array('id' => $id));
    }
}
?>