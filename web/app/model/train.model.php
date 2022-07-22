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
class train_model extends model{
	/**
     * @desc   引用log类，添加用户日志   
     */
    private function addMemberLog($uid,$usertype,$content,$opera='',$type='') {
        require_once ('log.model.php');
        $LogM = new log_model($this->db, $this->def);
        return  $LogM -> addMemberLog($uid,$usertype,$content,$opera='',$type=''); 
    }
    /**
     * 获取px_train     列表
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getList($whereData, $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $List           =   $this -> select_all('px_train', $whereData, $data['field']);
		if(!empty($List)){
				foreach ($List as $k=>$v){
					
					$UIDList[]	=	$v['uid'];
					
					$sid[]		=	$v['id'];
				}
				
				
				/* 查询培训课程	 */
				if($data['num']){
					
					$SubjectList 	=  	$this -> getSubList(
						array('uid' => array('in', pylode(',',$UIDList)) , 'status'=>1 , 'pause_status'=>1,'groupby'=>'uid'),
						array('field'=>'`id`,`uid`,`name`,`pic`,count(*) as num')
					);
					
					if(is_array($SubjectList)){
						foreach($SubjectList as $key=>$value){
							$SubNum[$value['uid']]		=		$value['num'];
						}
					}
				
				}
				
				if($data['utype']=='wap'){
					
					$SubjectList 	=  	$this -> getSubList(
						array('uid' => array('in', pylode(',',$UIDList)) , 'status'=>1 , 'pause_status'=>1),
						array('field'=>'`id`,`uid`,`name`,`pic`')
					);
					
					$TeacherList 	= 	$this->getTeaList(
						array('uid' => array('in', pylode(',',$UIDList)) , 'status'=>1 , 'r_status'=>1 , 'groupby'=>'uid'),
						array('field'=>'`uid`,count(*) as num')
					);

					$ZixunList	 	= 	$this->getPxzxList(
						array('s_uid' => array('in', pylode(',',$UIDList)) ),
						array('field'=>'`s_uid`')
					);
					
					if(is_array($TeacherList)){
						foreach($TeacherList as $key=>$value){
							$TeaNum[$value['uid']]		=		$value['num'];
						}
					}
					
				}
				
				foreach ($List as $k=>$v){
					
					if(strpos($v['cert'],'3')){
						
						$List[$k]['iscert']				=		1;
									
					}			
								
					if($data['utype']=='wap'){			
								
						if($TeaNum[$v['uid']]){			
							$List[$k]['teanum'] 		= 		$TeaNum[$v['uid']];
						}else{				
							$List[$k]['teanum'] 		= 		0;
						}	
						
						$List[$k]['num']				= 		0;
						
						foreach($SubjectList as $value){
							if($v['uid']==$value['uid']){
								$List[$k]['slist'][]	=		$value;
								$List[$k]['num'] 		+=		1;
							}
						}
						
						$List[$k]['zixunnum'] = 0;
						
						foreach($ZixunList as $value){
							if($v['uid']==$value['s_uid']){
								$List[$k]['zixunnum'] 	+= 		1;
							}
						}
					
					}
					/* 获取课程数量 */
					if($data['num']){
						
						if($SubNum[$v['uid']]){			
						
							$List[$k]['num'] 		= 		$SubNum[$v['uid']];
							
						}else{		
						
							$List[$k]['num'] 		= 		0;
						}
					}
					
					if(!empty($v['logo'])&&$v['logo_status']==0||$data['utype']=='admin'){
						$List[$k]['logo']	=	checkpic($v['logo'],$this->config['sy_px_icon']);
					}else{
						$List[$k]['logo']	=	checkpic($this->config['sy_px_icon']);
					}
					
					
				}
		
		}
        
        return $List;    
    }
    /**
     * 获取px_train     详情
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getInfo($whereData, $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $Info           =   $this -> select_once('px_train', $whereData, $data['field']);  
        if(!empty($Info['logo'])&&$Info['logo_status']==0||$data['utype']=='user'){
            $Info['logo_n']    =   checkpic($Info['logo'],$this->config['sy_px_icon']);      
        }else{
            $Info['logo_n']    =   checkpic($this->config['sy_px_icon']);
        }
        return $Info;    
    }
    /**
     * 修改px_train     详情 
     * $whereData       修改条件数据
     * $upData          修改的数据
     * $data 		    自定义处理数组
     * 此方法只为修改一下简单的字段操作，如需编辑操作，需访问upTrainInfo方法
     */
	public function upInfo($whereData = array(), $upData = array(), $data = array()){
        $nid            =   0;
	    if (!empty($upData) && !empty($whereData)){        
	        $nid	    =	$this -> update_once('px_train', $upData, $whereData);
        }
        return $nid;
    }
    /**
     * 获取px_teacher   列表
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getTeaList($whereData = array(), $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $List           =   $this -> select_all('px_teacher', $whereData, $data['field']);  
        if(!empty($List)){
			foreach($List as $val){
				$uid[]=$val['uid'];
			}
			
			if($data['utype']=='front'){
				
				$train		=	$this->getList(array('uid'=>array('in', pylode(',',$uid))),array('field'=>'`uid`,`name`'));
				
				$atn		=	$this->select_all('atn',array('uid'=>$data['uid'] , 'tid'=>array('<>','') , 'sc_usertype'=>4));
				
//				$num		=	$this->getPxSubjectNum(array('uid'=>$data['uid']) );
											
				$SubList 	= 	$this -> getSubList(array('uid'=>array('in', pylode(',',$uid)),'status'=>1,'pause_status'=>1),array('field' => '`uid`,`teachid`'));
				
				foreach($SubList as $k=>$v){
					
					$teachid			=	explode(',',$v['teachid']);
					
					foreach($teachid as $key=>$val){
						if($val){
							$ids[]		=	$val;
						}
						
					}
				}
				
				$idsArr	=	array_count_values($ids);
				
			}
			
            foreach ($List as $k=>$v){
				
				$List[$k]['pic']    =   checkpic($v['pic'],$this->config['sy_pxteacher_icon']);
				if(!empty($train)){
					
					if($idsArr[$v['id']]){
						
						$List[$k]['num']				=	$idsArr[$v['id']];
					
					}else{
						
						$List[$k]['num']				=	0;
					}
					
					foreach($train as $val){
						if($v['uid']==$val['uid']){
							
							$List[$k]['train_name']		=	$val['name'];
							
						}
					}
				}
				
				if(!empty($atn)){
				    foreach ($atn as $val){
						
				        if($v['id']==$val['tid']){
							
				            $List[$k]['atn']			=	1;
				        }
				    }
				}
            }
        }      
        return $List;
    }
    /**
     * 获取px_teacher   详情
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getTeaInfo($whereData = array(), $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $Info           =   $this -> select_once('px_teacher', $whereData, $data['field']);  
		
    		if(!empty($Info )){
    			/* 关注 */
    			if(!empty($data['uid'])){
    				$atn		=	$this->select_once('atn',array('uid'=>$data['uid'] , 'tid'=>$Info['id']));
    			
    				if(!empty($atn)){
    					
    					$Info['atn']	=	1;
    				}
    				
    			}
				if($Info['pic']){
					$Info['pic']    =   checkpic($Info['pic'],$this->config['sy_pxteacher_icon']); 
				}
				$train		=	$this->getInfo(array('uid'=>$Info['uid']),array('field'=>'`uid`,`name`'));
    			$Info['train_name']=$train['name'];
    		}
		
        
        return $Info;    
    }
    
    /**
     * 统计px_teacher     列表
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getPxTeacherNum($whereData) {
        return $this -> select_num('px_teacher', $whereData);
    }
    /**
     * 修改px_teacher   详情 
     * $whereData       修改条件数据
     * $upData          修改的数据
     * $data 		    自定义处理数组
     */
	  public function upTeaInfo($whereData = array(), $upData = array(), $data = array()){
        $return                        =   0;
	      if (!empty($upData) && !empty($whereData)){
            
            if ($upData['file']['tmp_name'] || $upData['base']){
                
                $upArr   =  array(
                    'file'     =>  $upData['file'],
                    'dir'      =>  'team',
                    'base'     =>  $upData['base'],
                    'preview'  =>  $upData['preview']
                );
                
                $result  =  $this -> upload($upArr);
                
                if (!empty($result['msg'])){
                    
                    $return['msg']      =  $result['msg'];
                    $return['errcode']  =  '8';
                    
                    return $return;
                    
                }elseif (!empty($result['picurl'])){
                    
                    $picurl  =  $result['picurl'];
                }
            }
            unset($upData['file']);
            unset($upData['base']);
            unset($upData['preview']);
            if(isset($picurl)){

              $upData['pic']       = $picurl;
              
            }

            if(!empty($upData['content'])){
                $oneArr             =   array('&amp;','background-color:#ffffff','background-color:#fff','white-space:nowrap;');
                $twoArr             =   array('&','background-color:','background-color:','white-space:');
                $upData['content']  =   str_replace($oneArr, $twoArr, $upData['content']);
            }
	          $return	                =	$this -> update_once('px_teacher', $upData, $whereData);
            if($data['member']){
                if($return){
                    $this   ->  addMemberLog($data['uid'],$data['usertype'],'更新培训师',20,2);//会员日志
                    $returns['msg'] =   '更新成功！';
                    $returns['cod'] =   9;
                    $returns['url'] =   'index.php?c=team&status=0';
                }else{
                    $returns['msg'] =   '更新失败,请重新填写！';
                    $returns['cod'] =   8;
                    if($data['wap']){
                        $returns['url'] =   '';
                    }else{
                        $returns['url'] =   'index.php?c=team_add';
                    }
                    
                }
                $return =   array();
                $return =   $returns;
            }
        }
        return $return;
    }
    
    /**
     * 修改px_teacher   详情 
     * $addData          修改的数据
     * $data            自定义处理数组
     */
    public function addTeaInfo($addData = array(), $data = array()){
        $return                        =   0;
        if (!empty($addData)){
            if(!empty($addData['content'])){
                $oneArr             =   array('&amp;','background-color:#ffffff','background-color:#fff','white-space:nowrap;');
                $twoArr             =   array('&','background-color:','background-color:','white-space:');
                $addData['content']  =   str_replace($oneArr, $twoArr, $addData['content']);
            }

            if ($addData['file']['tmp_name'] || $addData['base']){
                
                $upArr   =  array(
                    'file'     =>  $addData['file'],
                    'dir'      =>  'team',
                    'base'     =>  $addData['base'],
                    'preview'  =>  $addData['preview']
                );
                
                $result  =  $this -> upload($upArr);
                
                if (!empty($result['msg'])){
                    
                    $return['msg']      =  $result['msg'];
                    $return['errcode']  =  '8';
                    
                    return $return;
                    
                }elseif (!empty($result['picurl'])){
                    
                    $picurl  =  $result['picurl'];
                }
            }
            unset($addData['file']);
            unset($addData['base']);
            unset($addData['preview']);

            if(isset($picurl)){

              $addData['pic']       = $picurl;

            }
            
            $return                 =   $this -> insert_into('px_teacher', $addData);
            if($data['member']){
                if($return){
                    $this   ->  addMemberLog($data['uid'],$data['usertype'],'添加培训师',20,1);//会员日志
                    $returns['msg'] =   '添加成功！';
                    $returns['cod'] =   9;
                    $returns['url'] =   'index.php?c=team&status=0';
                }else{
                    $returns['msg'] =   '添加失败,请重新填写！';
                    $returns['cod'] =   8;
                    if($data['wap']){
                        $returns['url'] =   '';
                    }else{
                        $returns['url'] =   'index.php?c=team_add';
                    }
                }
                $return =   array();
                $return =   $returns;
            }
        }
        return $return;
    }
    /**
     * 删除px_teacher   详情
     * $whereData       查询条件
     */
    public function delTea($whereData = array(),$data=array()) 
	{
		 
        $return	=	$this -> delete_all('px_teacher', $whereData, ''); 

        if($data['member']){
            if($return){
                $this   ->  addMemberLog($data['uid'],$data['usertype'],'删除培训师',20,3);//会员日志
                $returns['msg']     =   '删除成功！';
                $returns['cod']     =   9;
                $returns['laytype'] =   0;
                $returns['url']     =   $_SERVER['HTTP_REFERER'];
            }else{
                $returns['msg']     =   '删除失败！';
                $returns['cod']     =   8;
                $returns['laytype'] =   0;
                $returns['url']     =   $_SERVER['HTTP_REFERER'];
            }
            $return =   array();
            $return =   $returns;
        }
           
        return $return;    
    }
    /**
     * 获取px_train_show列表
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getPxshowList($whereData, $data = array()) {
       
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $List           =   $this -> select_all('px_train_show', $whereData, $data['field']); 

        if(!empty($List)){
            foreach($List as $k=>$v){
               $List[$k]['picurl']  =    checkpic($v['picurl']);
            }
        }       
        return $List;
    }
    /**
     * 获取px_train_show详情
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getPxshowInfo($whereData = array(), $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $Info           =   $this -> select_once('px_train_show', $whereData, $data['field']);        
        return $Info;    
    }
    /**
     * 修改px_train_show详情 
     * $whereData       修改条件数据
     * $upData          修改的数据
     * $data 		    自定义处理数组
     */
	public function upPxshowInfo($whereData = array(), $upData = array(), $data = array()){
        $nid            =   0;
	    if (!empty($upData) && !empty($whereData)){
	        $nid        =	$this -> update_once('px_train_show', $upData, $whereData);
        }
        return $nid;
    }
    /**
     * 删除px_train_show 
      * $data            自定义处理数组
     */
    public function delPxshowInfo($data = array()){

		if($data['utype'] != 'admin'){
			
			$where['uid']	=	$data['uid'];
		}
        if(is_array($data['id'])){
            $where['id']    =   array('in',pylode(',',$data['id']));
        }else{
            $where['id']    =   $data['id'];
        }
        $row    =   $this   ->  getPxshowList($where);
        if(is_array($row)){
			 
            $nid	=   $this -> delete_all('px_train_show', $where, '');
        }
        if($nid){

            if($data['member']){
                $this   ->  addMemberLog($data['uid'],$data['usertype'],'删除机构环境展示',16,3);//会员日志
            }
            $return=array('msg'=>'删除成功！','cod'=>9);
        }else{
            $return=array('msg'=>'删除失败！','cod'=>8);
        }
       
        
        return $return;
    }
    /**
     * 插入px_train_show详情 
     * $addData          修改的数据
     * $data            自定义处理数组
     */
    public function addPxshowInfo($addData = array(), $data = array()){

        $nid            =   0;
        if (!empty($addData)){
            
              //wap端上传图片
            if ($addData['base'] || $addData['file']['tmp_name']){

                $upArr   =  array(
                    'file'     =>  $addData['file'],
                    'dir'      =>  'show',
                    'base'     =>  $addData['base'],
                );
                
                $result  =  $this -> upload($upArr);
                
                if (!empty($result['msg'])){
                    
                    $return['msg']      =  $result['msg'];
                    $return['errcode']  =  '8';
                    
                    return $return;
                    
                }elseif (!empty($result['picurl'])){
                    
                    $picurl  =  $result['picurl'];
                }

            }
            unset($addData['base']);
            unset($addData['file']);

            
            if(isset($picurl)){

              $addData['picurl']  = $picurl;
              
            }
			$member			=	$this->select_once('member',array('uid'=>$data['uid']),'`did`');
			$addData['did']	=	$member['did'];
			
            $nid        =   $this -> insert_into('px_train_show', $addData);
            if($data['member']){
                $this   ->  addMemberLog($data['uid'],$data['usertype'],'添加环境展示',16,1);
            }
        }
        return $nid;
    }
    /**
    * 获取px_train_news列表
    * $whereData       查询条件
    * $data            自定义处理数组
    */
    public function getPxnewsList($whereData, $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $List           =   $this -> select_all('px_train_news', $whereData, $data['field']);
		if(!empty($List)){
			foreach($List as $lv){
				$pxuid[] 	=	$lv['uid'];
			}
			$bcWhere['uid']	=	array('in', pylode(',', $pxuid));
			$pxList			=	$this -> getList($bcWhere, array('field' => '`uid`, `name`'));
			foreach($List as $k => $v){
				foreach($pxList as $val){
					if($v['uid']==$val['uid']){
						$List[$k]['name']	=	$val['name'];
					}
				}
			}
		}
        return $List;
    }
   /**
    * 获取px_train_news详情
    * $whereData       查询条件
    * $data            自定义处理数组
    */
    public function getPxnewsInfo($whereData = array(), $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $Info           =   $this -> select_once('px_train_news', $whereData, $data['field']);        
        return $Info;    
    }
   /**
    * 修改px_train_news详情 
    * $whereData       修改条件数据
    * $upData          修改的数据
    * $data 		    自定义处理数组
    */
    public function upPxnewsInfo($whereData = array(), $upData = array(), $data = array()){
        $return            =   0;
        if (!empty($upData) && !empty($whereData)){
			if($this->config['sy_outlinks']!=1){
				$patten		=	array("\r\n", "\n", "\r"); 
				$patea      =   "/<a[^>]*>(.*?)<\/a>/is";//匹配a标签
				$patet      =   "/href=\"(.*)\"/";//取a标签的值
				$pateh      =   '/<a .*?href="(.*?)".*?>/is';
				$content	=	str_replace($patten, "<br/>", $upData['body']);
				$str		=	htmlspecialchars_decode($content);
				if(!empty($upData['body'])){
				    $upData['body']	=	preg_replace($patea,"$1", $str);
				}
			}
            $return        =	$this -> update_once('px_train_news', $upData, $whereData);
            if($data['member']){
                if($return){
                    $this   ->  addMemberLog($data['uid'],$data['usertype'],'更新培训新闻',22,1);//会员日志
                    $returns['msg'] =   '更新培训新闻成功';
                    $returns['cod'] =   9;
                    $returns['url'] =   'index.php?c=news';
                }else{
                    $returns['msg'] =   '更新培训新闻失败，请稍后再试';
                    $returns['cod'] =   8;
                    $returns['url'] =   'index.php?c=news';
                }
                $return =   array();
                $return =   $returns;
            }
        }
        return $return;
    }
    /**
    * 添加px_train_news详情 
    * $addData          修改的数据
    * $data             自定义处理数组
    */
    public function addPxnewsInfo($addData = array(), $data = array()){
        $return            =   0;
        if (!empty($addData)){
			if($this->config['sy_outlinks']!=1){
				$patten		=	array("\r\n", "\n", "\r"); 
				$patea      =   "/<a[^>]*>(.*?)<\/a>/is";//匹配a标签
				$patet      =   "/href=\"(.*)\"/";//取a标签的值
				$pateh      =   '/<a .*?href="(.*?)".*?>/is';
				$content	=	str_replace($patten, "<br/>", $addData['body']);
				$str		=	htmlspecialchars_decode($content);
				$addData['body']	=	preg_replace($patea,"$1", $str);
			}
			
            $return        =   $this -> insert_into('px_train_news', $addData);
            if($data['member']){
                if($return){
                    $this   ->  addMemberLog($data['uid'],$data['usertype'],'添加培训新闻',22,1);//会员日志
                    $returns['msg']  =   '添加培训新闻成功';
                    $returns['cod']  =   9;
                    $returns['url']  =   'index.php?c=news';
                }else{
                    $returns['msg']  =   '添加培训新闻失败，请稍后再试';
                    $returns['cod']  =   8;
                    $returns['url']  =   'index.php?c=news';
                }
                $return =   array();
                $return =   $returns;
            }
            
        }
        return $return;
    }
      /**
     * 统计px_train_news    列表
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getPxTrainNewsNum($whereData) {
        return $this -> select_num('px_train_news', $whereData);
    }
    /**
     * 删除px_train_news详情
     * $whereData       查询条件
     * $data            自定义
     */
    public function delPxnews($whereData = array(),$data=array()) 
	{
		
        $return		=	$this -> delete_all('px_train_news', $whereData, '');

        if($data['member']){
            if($return){
                $this   ->  addMemberLog($data['uid'],$data['usertype'],'删除培训新闻',22,3);//会员日志
                $returns['msg']  =   '删除成功！';
                $returns['cod']  =   9;
                $returns['url']  =   $_SERVER['HTTP_REFERER'];
            }else{
                $returns['msg']  =   '删除失败！';
                $returns['cod']  =   8;
                $returns['url']  =   $_SERVER['HTTP_REFERER'];
            }
            $return =   array();
            $return =   $returns;
        }        
        return $return;    
    }
    /**
    * 获取px_zixun      列表
    * $whereData        查询条件
    * $data             自定义处理数组
    */
    public function getPxzxList($whereData, $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $List           =   $this -> select_all('px_zixun', $whereData, $data['field']);     
		
		foreach($List as $val){
			
			$sids[]		=	$val['s_uid'];
			
			$uid[]		=	$val['uid'];
			
		}
		
		if($data['utype']=='zixun'){
			//  查询培训
			$trWhere['uid']             =   array('in', pylode(',', $sids));
			$trData['field']          	=   '`uid`,`logo`,`name`';
			$train				   		=	$this->getList($trWhere,$trData['field']);
			
			//  查询培训课程	
			$sWhere['uid']				=	array('in',pylode(',', $sids));
			$sWhere['status']			=   '1';
			$sWhere['r_status']			=   1;
			$sData['field']            	=   '`uid`,`name`,`id`';
			$subject				   	=	$this->select_all('px_subject',$sWhere,$sData['field']);
			foreach($subject as $v){
				if($data['wap']){
					$url				=	Url('wap',array('c'=>'train','a'=>'subshow','id'=>$v['id']));
				}else{
					$url				=	Url('train',array('c'=>'subshow','id'=>$v['id']));
				}
				
				$subname[$v['uid']][]	=	'<a href="'.$url.'" target="_bank">'.$v['name'].'</a>';
			}
			
		}
		
		if($data['utype']=='front'){
			
			$result		=	$this->select_all('member',  array('uid'=>array('in',pylode(',',$uid))),'uid,username,usertype');
			$resume		=	$this->select_all('resume',  array('uid'=>array('in',pylode(',',$uid))),'uid,name,photo,sex');
			$company	=	$this->select_all('company', array('uid'=>array('in',pylode(',',$uid))),'uid,name,logo');
			$lietou		=	$this->select_all('lt_info', array('uid'=>array('in',pylode(',',$uid))),'uid,realname,photo');
			$train		=	$this->select_all('px_train',array('uid'=>array('in',pylode(',',$uid))),'uid,name,logo');
			
			foreach ($result as $key=>$val){
				foreach ($resume as $v){
					if($val['uid']==$v['uid']&&$val['usertype']==1){
						$result[$key]['pic']		=	$v['photo'];
						if($v['sex'] == 1){
						    $result[$key]['nickname']  =  mb_substr($v['name'], 0, 1, 'utf-8').'先生';
						}else{
						    $result[$key]['nickname']  =  mb_substr($v['name'], 0, 1, 'utf-8').'女士';
						}
					}
				}
				foreach ($company as $v){
					if($val['uid']==$v['uid']&&$val['usertype']==2){
						$result[$key]['pic']		=	$v['logo'];
						$result[$key]['nickname']	=	$v['name'];
					}
				}
				foreach ($lietou as $v){
					if($val['uid']==$v['uid']&&$val['usertype']==3){
						$result[$key]['pic']		=	$v['photo'];
						$result[$key]['nickname']	=	$v['realname'];
					}
				}
				foreach ($train as $v){
					if($val['uid']==$v['uid']&&$val['usertype']==4){
						$result[$key]['pic']		=	$v['logo'];
						$result[$key]['nickname']	=	$v['name'];
					}
				}
			}
		}   
		
		if(!empty($List)){
			foreach($List as $key=>$val){
				
				if($data['utype']=='zixun'){
					foreach($train as $v){
						if($val['s_uid']==$v['uid']){
							$List[$key]['name']			=	$v['name'];
							if($v['logo']){
								$List[$key]['logo']		=	$v['logo'];
							}else{
								$List[$key]['logo']		=	$this->config['sy_px_icon'];
							}
						}
					}
					
					foreach($subname as $k=>$v){
						if($val['s_uid']==$k){
							$List[$key]['num']			=	count($v);
							$i=0;
							foreach($v as $value){
								if($i<2){
									$sublist[$key][]	=	$value;
								}
								$i++;
							}
							
							$List[$key]['subname']		=	@implode(',',$sublist[$key]);
						}
					}
					
				}
				
				if(!empty($result)){
					foreach($result as $v){
						if($v['uid']==$val['uid']){
							$List[$key]['name']		=	$v['username'];
							$List[$key]['nickname']	=	$v['nickname'];
							if($v['pic']){
								$List[$key]['pic']	=	checkpic($v['pic']);
							}else{
								$List[$key]['pic']	=	checkpic($this->config['sy_friend_icon']);
							}
						}
					}
					
				}
			}
			
		}
		
        return $List;
    }
    
       /**
     * 获取px_zixun详情
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getPxzixunInfo($whereData = array(), $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $Info           =   $this -> select_once('px_zixun', $whereData, $data['field']);        
        return $Info;    
    }

        /**
     * 修改px_zixun    详情 
     * $whereData       修改条件数据
     * $upData          修改的数据
     * $data 		    自定义处理数组
     */
	public function upPxzixun($whereData = array(), $data = array()){

            $nid        =	$this -> update_once('px_zixun', $data, $whereData);
            
            return $nid;
    }
	
	 /**
     * 添加px_zixun   
     * $whereData       修改条件数据
     * $upData          修改的数据
     * $data 		    自定义处理数组
     */
	public function addPxzixun($addData = array()){
		if (!empty($addData)){
            $nid        =   $this -> insert_into('px_zixun', $addData);
		}
		return $nid;
	}
	
    /**
     * 删除px_zixun     详情
     * $id       查询条件
     */
	 public function delPxzx($id,$data=array()){
		 if(!empty($id) || !empty($data['where'])){
            
            $where      =       array();
            
            if (!empty($id)) {
            
                if(is_array($id)){
                    
                    $ids    =	$id;
                    
                    $return['layertype']	=	1;
                    
                }else{
                    
                    $ids        =   @explode(',', $id);
                    $return['layertype']	=	0;
                    
                }
                
                $ids            =   pylode(',', $ids);
                
                $where['id']    =   array('in', $ids);
				if($data['uid']){
					if($data['usertype'] == '4'){
						$where['s_uid']    =   $data['uid'];
					}else{
					
						$where['uid']    =   $data['uid'];
					}
					
				}
            
            }
            
            if (!empty($data['where'])) {
                
                $where          =   array_merge($where, $data['where']);
                
            }

            $return['id']	=	$this -> delete_all('px_zixun', $where, '');
            
            if($return['id']){
                $this	->addMemberLog	($data['uid'],$data['usertype'],'删除培训机构留言',18,3);
                $return['msg']      =  '删除成功';
                $return['errcode']  =  '9';
              } else{
                $return['msg']      =  '删除失败';
                $return['errcode']  =  '8';
              }
            
        }else{
            $return['msg']			=	'请选择您要删除的数据！';
            $return['errcode']		=	8;
            $return['layertype']	=	0;
        }
		return $return;  
	}
    /**
     * 获取px_banner    列表
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getBannerList($whereData, $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $List           =   $this -> select_all('px_banner', $whereData, $data['field']); 
        if(!empty($List)){
            foreach ($List as $k => $v) {
                $List[$k]['pic']=checkpic($v['pic']);
            }  
        }
              
        return $List;
    }

    /**
     * 统计px_banner    列表
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getBannerNum($whereData) {
        return $this -> select_num('px_banner', $whereData);
    }
    /**
     * 获取px_banner    详情
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getBannerInfo($whereData = array(), $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $Info           =   $this -> select_once('px_banner', $whereData, $data['field']);
        if(!empty($Info)){
            if($data['pic']){
                $Info['pic']    =   checkpic($Info['pic']);
            }
        }       
        return $Info;    
    }
    /**
     * 修改px_banner    详情 
     * $whereData       修改条件数据
     * $upData          修改的数据
     * $data 		    自定义处理数组 uid 为必传参数
     */
	public function upBannerInfo($whereData = array(), $upData = array(), $data = array()){
        if (!empty($upData) && !empty($whereData)){
            
            if($data['member']){
                $pxinfo	=	$this -> getInfo(array('uid'=>$data['uid']),array('field'=>'r_status'));
                $upData['status']	=	$pxinfo['r_status'] != 2 ? 1 : $this->config['px_banner_status'];
            }
	        $nid        =	$this -> update_once('px_banner', $upData, $whereData);
            $return     =   array();
            if($data['member']){
                $this   ->  addMemberLog($data['uid'],$data['usertype'],'编辑机构横幅',16,2);//会员日志
            }
            if($nid){
                $return['url']  =   'index.php?c=banner';
                $return['msg']  =   '设置成功！';
                $return['cod']  =   9;
            }else{
                $return['msg']  =   '设置失败！';
                $return['cod']  =   8;
            }
        }
        return $return;
    }
    /**
     * 删除px_banner
      * $data            自定义处理数组
     */
    public function delBanner($data = array())
	{

        if(is_array($data['id'])){

            $where['id']    =   array('in',pylode(',',$data['id']));
        }else{

            $where['id']    =   $data['id'];
        }

        $row	=	$this -> getBannerList($where);
        if(is_array($row)){
			 
            $nid        =   $this -> delete_all('px_banner', $where, '');
        }
        if($nid){
            
            $return=array('msg'=>'删除成功！','cod'=>9);
        }else{
            $return=array('msg'=>'删除失败！','cod'=>8);
        }
       
        
        return $return;
    }
    /**
     * 会员设置px_banner 
     * 
     * $data            自定义处理数组
     */
    public function setBanner($data=array()){
        if(!empty($data)){
          
            if ($data['file']['tmp_name'] || $data['base']){
                
                $upArr   =  array(
                    'file'     =>  $data['file'],
                    'dir'      =>  'train',
                    'base'     =>  $data['base'],
                    'preview'  =>  $data['preview']
                );
                
                $result  =  $this -> upload($upArr);
                
                if (!empty($result['msg'])){
                    
                    $return['msg']      =  $result['msg'];
                    $return['errcode']  =  '8';
                    
                    return $return;
                    
                }elseif (!empty($result['picurl'])){
                    
                    $picurl  =  $result['picurl'];
                }
            }
            if(isset($picurl)){
                $valueData['pic']   =   $picurl;
			
                if($data['type']=='add'){

                    $member				=	$this->select_once('member',array('uid'=>$data['uid']),'`did`');
                    $valueData['did']	=	$member['did'];
                    $valueData['uid']	=   $data['uid'];

                    $return=$this  ->  addBannerInfo($valueData,array('member'=>'train','uid'=>$data['uid'],'usertype'=>$data['usertype'],));
				
                }elseif($data['type']=='update'){

                    $whereData['uid'] =   $data['uid'];
                    $return	=	$this ->  upBannerInfo($whereData,$valueData,
                        array(
                            'uid'        =>  $data['uid'],
                            'usertype'   =>  $data['usertype'],
                            'member'     =>  'train'
                        )
                    );
                }
            }else{
                $return['msg']      =  '请上传机构横幅';
                $return['errcode']  =  8;
            }
            return $return;
        }
    }
    /**
     * 添加px_banner详情 
     * $addData          修改的数据
     * $data            自定义处理数组
     */
    public function addBannerInfo($addData = array(), $data = array()){
        if (!empty($addData)){

            if($data['member']){
                $pxinfo	=	$this -> getInfo(array('uid'=>$data['uid']),array('field'=>'r_status'));
                $addData['status']	=	$pxinfo['r_status']!= 2 ? 1 : $this->config['px_banner_status'];
            }

            $nid        =   $this -> insert_into('px_banner', $addData);
            $return     =   array();
            if($data['member']){
                $this   ->  addMemberLog($data['uid'],$data['usertype'],'上传机构横幅',16,1);//会员日志
                require_once ('integral.model.php');
                $IntegralM      =   new integral_model($this->db, $this->def);
                $IntegralM      ->  invtalCheck($addData['uid'],$data['usertype'],'integral_px_banner','上传培训横幅');
            }
            if($nid){
                $return['url']  =   'index.php?c=banner';
                $return['msg']  =   '设置成功！';
                $return['cod']  =   9;
            }else{
                $return['msg']  =   '设置失败！';
                $return['cod']  =   8;
            }
        }
        return $return;
    }
    /**
     * 获取px_subject   列表
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getSubList($whereData, $data = array('utype'=>'')) 
    {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $List           =   $this -> select_all('px_subject', $whereData, $data['field']);
     
        if(!empty($List)){
          require_once ('cache.model.php');
          $CacheM      	=   new cache_model($this->db, $this->def);
          $CacheList		=	$CacheM->GetCache(array('subject','subjecttype'));
			
			
			foreach($List as $k=>$v){
				$uid[]		=	$v['uid'];
				
				$ids[]		=	$v['id'];
			}
			
			/* 获取报名数量 */
			if($data['num']){
				
				$NumList  =  $this->getBmList(array('sid'=>array('in' , pylode(',' , $ids)),'groupby'=>'sid'),array('field'=>'`sid`,count(*) as num'));	
				if(is_array($NumList)){
				
					foreach($NumList as $key=>$value){
						
						$BmNum[$value['sid']]	=	$value['num'];
					}
				}
			}
			
			/* 查询是否报名 */
			if($data['uid'] && !empty($ids)){
				$baomingList			=	$this -> getBmList(	array('sid' => array('in' , pylode(',' , $ids)) , 'uid' => $data['uid']));	
				
				if(is_array($baomingList)){
					
					foreach($baomingList as $key=>$value){
						
						$BmID[$value['sid']]	=	$value['sid'];
					}
				}
			}
			
			//获取培训信息
			if($data['utype']=='front' && !empty($uid)){
			    
			    $reccom  =	$this->getList(array('uid' => array('in' , pylode(',' , $uid))),array('field' => '`uid`,`name`'));
			}
			
			foreach($List as $k=>$v){
				
				if($v['isprice']){
					$List[$k]['isprice_n']	=	$v['isprice']==1 ? '在线收费':'到场收费';
				}
				
				$List[$k]['pic']            =   checkpic($v['pic'],$this -> config['sy_pxsubject_icon']);
				$List[$k]['price']			=	floatval($v['price']);
				
				//处理报名数据
				if(!empty($BmNum)){
					
					if($BmNum[$v['id']]){
					
						$List[$k]['baomingnum']		=	$BmNum[$v['id']];
						
					}else{
						
						$List[$k]['baomingnum']		=	0;
					}
				}
				if(!empty($BmID)){
					
					$List[$k]['baoming']		=	$BmID[$v['id']];
				}
				
				//处理前台数据
				if($data['utype']=='front'){
						
					foreach($reccom as $val){
						
						if($v['uid'] == $val['uid']){
							
							$List[$k]['comname']		=	$val['name'];
						}
					}
					
					if($v['type']!=''){
						
						$type_name						=	array();
						
						$type							=	@explode(',',$v['type']);
						
						foreach($type as $val){
							
							$type_name[]				=	$CacheList['subject_type_name'][$val];
						}
						
						$List[$k]['type_n']				=	@implode(',',$type_name);
					}
				}
			}
        }
        return $List;
    }
    /**
     * 获取px_subject   详情
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getSubInfo($whereData, $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $Info           =   $this -> select_once('px_subject', $whereData, $data['field']); 
        if($Info['pic']){
          $Info['pic']      =  checkpic($Info['pic'],$this->config['sy_pxsubject_icon']); 
        }
        
		if($data['utype']=='front'){
			
			require_once ('cache.model.php');
			$CacheM      					=   new cache_model($this->db, $this->def);
			$CacheList						=	$CacheM->GetCache('subjecttype');
			
			$subject_type_name				=	$CacheList['subject_type_name'];
			
			
			if($Info['type']!=''){
				$type						=	@explode(',',$Info['type']);
				
				$type_name					=	array();
				
				foreach($type as $v){
					
					$type_name[]			=	$subject_type_name[$v];
					
				}
				
				$Info['type']				=	@implode(',',$type_name);
			}
			
			if($Info['teachid']!=''){
				
				$teach						=	$this->getTeaList(array('id'=>array('in' , $Info['teachid']) ,  'status'=>'1'));
				
				foreach($teach as $v){
					
					$teachname[$v['id']]	=	$v['name'];
				}
				
				$teachid					=	@explode(',',$Info['teachid']);
				
				$teach_name					=	array();
				
				foreach($teachid as $v){
					
					$teach_name[]			=	$teachname[$v];
					
				}
				
				$Info['teach']				=	@implode('/',$teach_name);
			}
			
			$Info['price']=floatval($Info['price']);
		}
        return $Info;    
    }
    /**
     * 添加px_subject   详情
     */
    public function addSubjectInfo($data = array()) {
        $post   =   $data['post'];
        $id     =   $data['id'];
        
        if ($post['file']['tmp_name'] || $post['base']){
                
            $upArr   =  array(
                'file'     =>  $post['file'],
                'dir'      =>  'subject',
                'base'     =>  $post['base'],
                'preview'  =>  $post['preview']
            );
            
            $result  =  $this -> upload($upArr);
            
            if (!empty($result['msg'])){
                
                $return['msg']      =  $result['msg'];
                $return['errcode']  =  '8';
                
                return $return;
                
            }elseif (!empty($result['picurl'])){
                
                $picurl  =  $result['picurl'];
            }
        }

        unset($post['file']);
        unset($post['preview']);
        unset($post['base']);
        if(isset($picurl)){

          $post['pic']  = $picurl;

        }

        if($id){
            $nid	  =	$this->upSubInfo(array('id'=>$id,'uid'=>$data['uid']),$post);
            $type   =   2;
            $msg    =   '更新课程';
  	    }else{
			      $post['uid']    =   $data['uid'];
            $post['did']    =   $data['did'];
            $post['ctime']  =   time();
            
            $nid	  =	$this->addSubInfo($post);

            $type   =    1;
            $msg    =   '发布课程';
        }
        if($nid){
            $this -> addMemberLog($data['uid'],$data['usertype'],$msg,21,$type);
            $return['msg']      =   $msg.'成功！';
            $return['errcode']  =   9;
            $return['url']      =   'index.php?c=subject&status=1';
        }else{
            $return['msg']      =   $msg.'失败！';
            $return['errcode']  =   8;
            $return['url']      =   'index.php?c=subject_add';
        }
        return $return;    
    }
    /**
     * 添加px_subject   详情
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function addSubInfo($upData = array(), $data = array()) {
        
          $nid          =       0;
      
         if (!empty($upData)){
           
            if(!empty($upData['content'])){
              
                $oneArr             =   array('&amp;','background-color:#ffffff','background-color:#fff','white-space:nowrap;');
                
                $twoArr             =   array('&','background-color:','background-color:','white-space:');
                
                $upData['content']  =   str_replace($oneArr, $twoArr, $upData['content']);
            }
            
            $nid	                  =	  $this -> insert_into('px_subject', $upData);
        }
      
        return $nid;    
    }
    /**
     * 修改px_subject   详情 
     * $whereData       修改条件数据
     * $upData          修改的数据
     * $data 		    自定义处理数组
     */
	public function upSubInfo($whereData = array(), $upData = array(), $data = array()){
        $nid                        =   0;
        if (!empty($upData) && !empty($whereData)){
            if(!empty($upData['content'])){
                $oneArr             =   array('&amp;','background-color:#ffffff','background-color:#fff','white-space:nowrap;');
                $twoArr             =   array('&','background-color:','background-color:','white-space:');
                $upData['content']  =   str_replace($oneArr, $twoArr, $upData['content']);
            }
	        $nid	                =	$this -> update_once('px_subject', $upData, $whereData);
        }
        return $nid;
    }
	
	/**
	 *	@desc 删除培训课程信息
	 */
    public function delsubInfo($id,$data=array()){
 
		$nid	=	$this -> delete_all('px_subject',array('id'=>$id,'uid'=>$data['uid']), '');
		if($nid){

			$baoming	=	$this->getBmInfo(array('sid'=>$id,'uid'=>$data['uid']));
		   
			if($baoming){
				$this->delete_all('company_order',array('sid'=>$baoming['id'],'uid'=>$data['uid']),'');

			}
			$this->delete_all('px_baoming',array('id'=>$id,'uid'=>$data['uid']), '');
			
			$this->delete_all('px_subject_collect',array('id'=>$id,'uid'=>$data['uid']), '');

			$this->addMemberLog($data['uid'],$data['usertype'],'删除培训课程',21,3);

			$return['errcode']          =   9;
			$return['msg']              =   '培训课程(ID:'.$id.')删除成功！';
		}else{
			$return['errcode']          =   8;
			$return['msg']              =   '培训课程(ID:'.$id.')删除失败！';
		}
		return $return;
    }
    /**
     * 删除px_subject   详情
     * $whereData       查询条件
     * $data            自定义处理数组
     */
	public function delSub($whereData = array()) 
	{
	
		$return = array(
			'errcode'   => 8,
			'msg'       => ''
		);
		$del		=   $whereData['id'];

		$whereData	=   array('id' => array('in', $del));

		$list		=	$this -> getSubList($whereData, array('field' => '`uid`, `name`, `pic`'));
		if(empty($list)){

			$return['msg']          =   '数据错误';

			 return $return;
		 }

		require_once('sysmsg.model.php');
		$sysmsgM                    =	new sysmsg_model($this->db, $this->def);
		
		foreach($list as $v){

			$sysmsgM -> addInfo(array('content' => '管理员操作：删除课程《'.$v['name'].'》','usertype'=>4,  'uid' => $v['uid']));
				
		}
		
		 $baomingid	=	$this -> getBmList(array('sid' => array('in', $del)), array('field' => '`id`'));

		 $sid		=	array();

		if(!empty($baomingid)){
			foreach($baomingid as $v){
				$sid[]				=	$v['id'];
			}
		}
		//删除相关数据
		$sidWhereData	=	array('sid' => array('in', $del));
		
		$result	=	$this -> delete_all('px_subject', $whereData, '');
		
		if($result){
			$this -> delete_all('company_order', array('sid' => array('in', pylode($sid))), '');
			$this -> delete_all('px_baoming', $sidWhereData, '');
			$this -> delete_all('px_subject_collect', $sidWhereData, '');
		}
		

		$return['errcode']          =   9;
		$return['msg']              =   '培训课程(ID:'.$del.')删除成功！';
		return $return;
    }
    /**
     * 获取px_baoming   列表
     * $whereData       查询条件
     * $data            自定义处理数组 scene 场景值，定制不同场景返回的数据
     */
    public function getBmList($whereData, $data = array()) {
        $List                                   =   array();
        $data['field']                          =	empty($data['field']) ? '*' : $data['field'];
        $List                                   =   $this -> select_all('px_baoming', $whereData, $data['field']);
        if(empty($List)){
            return $List;
        }
        //详情
        if(isset($data['scene']) && $data['scene'] == 'detail'){
            $sid    =   $s_uid  =   $ids        =   array();
			foreach($List as $val){
				$sid[]                          =   $val['sid'];
				$s_uid[]                        =   $val['s_uid'];
				$ids[]                          =   $val['id'];
            }
            //课程数据
            $subject                            =   $this -> getSubList(array('id' => array('in', pylode(',',$sid))), array('field' => '`id`,`uid`,`name`,`price`,`isprice`,`pic`'));
            $subjectIndex                       =   array();
            if(!empty($subject)){
                foreach ($subject as $subV) {
                    $subjectIndex[$subV['id']]  =   $subV;
                }
            }
            //培训数据
            $train                              =   $this -> getList(array('uid' => array('in', pylode(',',$s_uid))), array('field' => '`uid`,`name`'));
            $trainIndex                         =   array();
            if(!empty($train)){
                foreach ($train as $tV) {
                    $trainIndex[$tV['uid']]     =   $tV;
                }
            }
            //订单数据
            $order                              =   $this -> select_all('company_order', array('sid' => array('in', pylode(',',$ids)), 'type' => 6), '`id`,`sid`,`order_state`');
            $orderIndex                         =   array();
            if(!empty($order)){
                foreach ($order as $oV) {
                    $orderIndex[$oV['sid']]     =   $oV;
                }
            }
			foreach($List as $key=>$val){
                if(isset($subjectIndex[$val['sid']])){
                    $List[$key]['subname']      =   $subjectIndex[$val['sid']]['name'];
                    $List[$key]['price']        =   number_format($subjectIndex[$val['sid']]['price'],2);
                    $List[$key]['isprice']      =   $subjectIndex[$val['sid']]['isprice'];
					$List[$key]['isprice_n']    =   $subjectIndex[$val['sid']]['isprice_n'];
					$List[$key]['pic_n']      	=   $subjectIndex[$val['sid']]['pic'];
                }
                if(isset($trainIndex[$val['s_uid']])){
                    $List[$key]['trainname']    =   $trainIndex[$val['s_uid']]['name'];
                }
                if(isset($orderIndex[$val['id']])){
                    $List[$key]['order_state']  =   $orderIndex[$val['id']]['order_state'];
					$List[$key]['oid']  		=   $orderIndex[$val['id']]['id'];
                }
			}
        }
        return $List;
    }
    /**
     * 获取px_baoming   详情
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getBmInfo($whereData, $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $Info           =   $this -> select_once('px_baoming', $whereData, $data['field']);        
        return $Info;    
    }
    /**
     *修改px_baoming   详情
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function upBmInfo($whereData = array(), $data = array()){
       
        $nid	    =	$this -> update_once('px_baoming', $data, $whereData);
        
        return $nid;
    }

    /**
     * 删除px_baoming   详情
     * @param  $whereData   查询条件
     * @param  $data    自定义处理数组
     * @return array
     */
    public function delBm($whereData = array(), $data = array()) {
        
        $return = array(
            'errcode'   => 8,
            'msg'       => ''
        );
        $del                        =   $whereData['id'];

        $where['id']				=   array('in', $del);
		if($whereData['uid']){
			$where['uid']			=   $whereData['uid'];
		}
        $list                       =	$this -> getBmList($where, array('field' => '`s_uid`,`uid`'));
       
		if(empty($list)){
            $return['msg']          =   '数据错误';
            
			return $return;
        }else{
			foreach($list as $key=>$value){
				if($data['s_uid']  && $data['s_uid'] != $value['s_uid']){
					$return['msg']          =   '数据错误';
            
					return $return;
				}
			}
		}

        //删除相关数据
		$result	=	$this -> delete_all('px_baoming', array('id' => array('in', $del)), '');

		if($result){

			$this -> delete_all('company_order', array('sid' => array('in', $del), 'type' => array('=', 6)), '');
        }
		
		$this -> addMemberLog($data['uid'],$data['usertype'],'取消报名的课程',6,3);
			
        $return['errcode']          =   9;
        $return['msg']              =   '报名记录(ID:'.$del.')删除成功！';
        return $return;
    }
    /**
     * 修改培训基本信息
     * $whereData 修改条件
     * $data  mData member表要修改数据;  trainData px_train表要修改数据(简单的修改只需要带上此参数);  sData 后台修改操作数量数据;  utype 修改操作类型：admin-后台，user-会员中心
     */
	public function upTrainInfo($whereData, $data=array('mData'=>null, 'trainData'=>null, 'sData'=>null, 'utype'=>null)) {
	    
	    $return  =  array();
	    
	    if(is_array($whereData) && !empty($whereData)){
	        //会员操作的修改，需要判断手机号、邮件是否已绑定，绑定的不能修改
	        if ($data['utype'] == 'user'){
	            
	            $px  =  $this -> select_once('px_train',array('uid'=>$whereData['uid']),'`moblie_status`,`email_status`');
	            
	            if (!empty($px)){
	                
	                if ($px['moblie_status'] == '1'){
	                    
	                    if (!empty($data['mData']) && $data['mData']['moblie']){
	                        
	                        unset($data['mData']['moblie']);
	                    }
	                    if (!empty($data['trainData']) && $data['trainData']['moblie']){
	                        
	                        unset($data['trainData']['moblie']);
	                    }
	                }
	                if ($px['email_status'] == '1'){
	                    
	                    if (!empty($data['mData']) && $data['mData']['email']){
	                        
	                        unset($data['mData']['email']);
	                    }
	                    if (!empty($data['trainData']) && $data['trainData']['email']){
	                        
	                        unset($data['trainData']['email']);
	                    }
	                }
	            }
	        }
	        // 处理会员基本信息
	        if (!empty($data['mData'])){
	            
	            require_once ('userinfo.model.php');
	            
	            $UserinfoM  =  new userinfo_model($this->db, $this->def);
	            
	            $ckresult   =  $UserinfoM -> addMemberCheck($data['mData'], $whereData['uid'], $data['utype']);
	            
	            if (isset($ckresult) && $ckresult['msg']){
	                
	                $ckresult['errcode']	=  8;
	                
	                return $ckresult;
	            }
	        }
	        
	        // 处理培训基本信息
	        if (!empty($data['trainData'])){
	            
	            if(!empty($data['trainData']['linkphone'])){
	                
	                $pxphone   =   $this -> select_once('px_train', array('linkphone' => $data['trainData']['linkphone']),'`uid`');
	                
	                if(!empty($pxphone) && $pxphone['uid'] != $whereData['uid']){
	                    
	                    $return['msg']      =  '座机已存在！';
	                    $return['errcode']	=  8;
	                    return	$return;
	                }
	            }
	            
	            $return['id']  =  $this -> update_once('px_train', $data['trainData'], $whereData);
	            
	            if ($return['id']){
	                // 会员操作的要记录会员日志
	                if ($data['utype'] == 'user'){
	                    
	                    $this   ->  addMemberLog($whereData['uid'], 4, '完善基本资料',7);
	                    
	                    // 如是第一次完善，需要进行积分处理
	                    if(!empty($px)  && $px['name'] == ''){
	                        
	                        require_once ('integral.model.php');
	                        
	                        $IntegralM  =  new integral_model($this->db, $this->def);
	                        
	                        $IntegralM -> invtalCheck($whereData['uid'],4,'integral_userinfo','完善基本资料');
	                    }
	                }
					
	                $return['msg']		=  $data['utype'] == 'user' ?  '基本信息修改成功' : '培训会员(ID:'.$whereData['uid'].')基本信息修改成功';
	                $return['errcode']	=  9;
	                $return['url']	=  $_SERVER['HTTP_REFERER'];
	            }else{
	                $return['msg']		=  $data['utype'] == 'user' ?  '基本信息修改失败' :'培训会员(ID:'.$whereData['uid'].')基本信息修改失败';
	                $return['errcode']	=  8;
	                $return['url']	=  $_SERVER['HTTP_REFERER'];
	            }
	        }
	    }
	    return $return;
    }
    /**
     * 修改个人头像
     * @param array $whereData
     * @param array $data   photo/需上传的图片文件;   thumb/已处理好的缩略图;  utype/操作的用户类型;  base/需上传的base4图片;  preview/pc预览即上传
     */
    public function upLogo($whereData = array(),$data=array('photo'=>null,'thumb'=>null,'utype'=>null,'base'=>null,'preview'=>null))
    {
        if (!empty($whereData['uid'])){
            
            $uid  =  $whereData['uid'];
            // 头像还需上传的
            if ($data['photo'] || $data['base']){
                
                $upArr   =  array(
                    'file'     =>  $data['photo'],
                    'dir'      =>  'train',
                    'type'     =>  'logo',
                    'base'     =>  $data['base'],
                    'preview'  =>  $data['preview']
                );
                $result  =  $this -> upload($upArr);
                
                if (!empty($result['msg'])){
                    
                    $return['msg']      =  $result['msg'];
                    $return['errcode']  =  '8';
                    
                    return $return;
                    
                }elseif (!empty($result['picurl'])){
                    
                    $photo  =  $result['picurl'];
                        
                }
            }
            // 已处理好的头像缩略图
            if ($data['thumb']){
                
                $photo  =  str_replace('../data','./data',$data['thumb'][1]);
            }
            
            if (!empty($photo)){
                // 用户操作，且后台设置用户头像需要审核的
                $pxinfo	=	$this -> getInfo(array('uid'=>$uid),array('field'=>'r_status'));
				if(empty($pxinfo)){

					include_once('userinfo.model.php');
          
					$userinfoM  =  new userinfo_model($this->db, $this->def);
					$userinfoM -> activUser($uid,4);
				}
                if ($data['utype'] == 'user' && $this -> config['px_logo_status'] == 1){
                    $photo_status  =  1;
                }else{
                    $photo_status  =  $pxinfo['r_status']==0?1:0;
                }
                $return['id']      =  $this ->  update_once('px_train',array('logo'=>$photo,'logo_status'=>$photo_status),array('uid'=>$uid));
                
                $this -> update_once('answer',array('pic'=>$photo),array('uid'=>$uid));
                
                $this -> update_once('question',array('pic'=>$photo),array('uid'=>$uid));
            }
            
            if (isset($return['id'])) {
                // 用户操作的，判断处理头像上传积分
                if ($data['utype'] == 'user'){
                    
                    require_once ('integral.model.php');
                    
                    $IntegralM  =   new integral_model($this -> db, $this -> def);
                    $IntegralM  ->  invtalCheck($uid,4,'integral_avatar','上传头像');
                    
                    $this -> addMemberLog($uid, 4, '上传头像', 16, 1);
                    
                    if ($this -> config['px_logo_status'] == 1){
                        $return['errcode']  =  '9';
                        $return['msg']      =  '上传成功，管理员审核后对其他用户开放显示';
                    }else{
                        $return['errcode']  =  '9';
                        $return['msg']      =  '上传成功';
                    }
                    // pc会员中心预览即上传，处理预览图
                    if ($data['preview']){
                        
                        $return['picurl']  =  checkpic($photo);
                    }
                }else{
                    $return['msg']      =  '培训头像(ID:'.$uid.')修改成功';
                    $return['errcode']  =  '9';
                }
            }else{
                
                $return['msg']      =  '培训头像(ID:'.$uid.')修改失败';
                $return['errcode']  =  '8';
            }
        }else{
            
            $return['msg']      =  '请选择需要修改的用户';
            $return['errcode']  =  '8';
        }
        return $return;
    }
    
	
	 /**
     * px_subject_collect   列表
     * $whereData       查询条件
     * $data            自定义处理数组 scene 场景值，定制不同场景返回的数据
     */
    public function getFavSubList($whereData, $data = array()) {
        $List                                   =   array();
        $data['field']                          =	empty($data['field']) ? '*' : $data['field'];
        $List                                   =   $this -> select_all('px_subject_collect', $whereData, $data['field']);
        if(empty($List)){
            return $List;
        }
        //详情
        if(isset($data['scene']) && $data['scene'] == 'detail'){
            $sid    =   $s_uid  =   $ids        =   array();
			foreach($List as $val){
				$sid[]                          =   $val['sid'];
				$s_uid[]                        =   $val['s_uid'];
            }
            //课程数据
            $subject                            =   $this -> getSubList(array('id' => array('in', pylode(',',$sid))), array('field' => '`id`,`name`,`address`,`pic`,`price`,`isprice`'));
            $subjectIndex                       =   array();
            if(!empty($subject)){
                foreach ($subject as $subV) {
                    $subjectIndex[$subV['id']]  =   $subV;
                }
            }
            //培训数据
            $train                              =   $this -> getList(array('uid' => array('in', pylode(',',$s_uid))), array('field' => '`uid`,`name`'));
            $trainIndex                         =   array();
            if(!empty($train)){
                foreach ($train as $tV) {
                    $trainIndex[$tV['uid']]     =   $tV;
                }
            }
			foreach($List as $key=>$val){
                if(isset($subjectIndex[$val['sid']])){
                    $List[$key]['name']      	=   $subjectIndex[$val['sid']]['name'];
                    $List[$key]['price']      	=   number_format($subjectIndex[$val['sid']]['price'],2);
                    $List[$key]['address']      =   $subjectIndex[$val['sid']]['address'];
                    $List[$key]['isprice_n']    =   $subjectIndex[$val['sid']]['isprice_n'];
					if($subjectIndex[$val['sid']]['pic']){
						 $List[$key]['pic']		=	$subjectIndex[$val['sid']]['pic'];
					}else{
						 $List[$key]['pic']		=	$this->config['sy_pxsubject_icon'];
					}
                }
                if(isset($trainIndex[$val['s_uid']])){
                    $List[$key]['train_name']   =   $trainIndex[$val['s_uid']]['name'];
                }
			}
        }

        return $List;
    }
	
	/**
     * 删除px_subject_collect
     * $delId 	        id
     */
	public function delFavSub($id,$data=array()) {
		
		if(!empty($id)){
			
			if(is_array($id)){

				$ids    =	$id;

				$return['layertype']	=	1;

			}else{

				$ids    =   @explode(',', $id);

				$return['layertype']	=	0;

			}

			$id          	=   pylode(',', $ids);

			$delWhere['id']	=	array('in',$id);

			if($data['uid']){

				$delWhere['uid']	=	$data['uid'];
			
			}
			$return['id']	=	$this -> delete_all('px_subject_collect',$delWhere,'');

			if($return['id']){
				$this -> addMemberLog($data['uid'],$data['usertype'],'删除收藏的课程',5,3);
				
				$return['msg']      =	'收藏的课程(ID:'.$id.')取消成功';

				$return['errcode']  =	'9';

			} else{
				$return['msg']      = 	'收藏的课程(ID:'.$id.')取消失败';

				$return['errcode']  =	'8';
			}
            
        }else{
        
			$return['msg']      	= 	'系统繁忙';

			$return['errcode']  	=	'8';

			$return['layertype']	=	'0';
        
        }
      
        return $return;  
	}
	
	 /**
     * px_subject_collect   列表
     * $whereData       查询条件
     * $data            自定义处理数组 scene 场景值，定制不同场景返回的数据
     */
    public function getFavAgencyList($whereData, $data = array()) {
        $List                                   =   array();
        $data['field']                          =	empty($data['field']) ? '*' : $data['field'];
        $List                                   =   $this -> select_all('px_subject_collect', $whereData, $data['field']);
        if(empty($List)){
            return $List;
        }
        //详情
        if(isset($data['scene']) && $data['scene'] == 'detail'){
            $sid    =   $s_uid  =   $ids        =   array();
			foreach($List as $val){
				$sid[]                          =   $val['sid'];
				$s_uid[]                        =   $val['s_uid'];
            }
            //课程数据
            $subject                            =   $this -> getSubList(array('id' => array('in', pylode(',',$sid))), array('field' => '`id`,`name`,`address`,`pic`'));
            $subjectIndex                       =   array();
            if(!empty($subject)){
                foreach ($subject as $subV) {
                    $subjectIndex[$subV['id']]  =   $subV;
                }
            }
            //培训数据
            $train                              =   $this -> getList(array('uid' => array('in', pylode(',',$s_uid))), array('field' => '`uid`,`name`'));
            $trainIndex                         =   array();
            if(!empty($train)){
                foreach ($train as $tV) {
                    $trainIndex[$tV['uid']]     =   $tV;
                }
            }
			foreach($List as $key=>$val){
                if(isset($subjectIndex[$val['sid']])){
                    $List[$key]['name']      	=   $subjectIndex[$val['sid']]['name'];
                    $List[$key]['address']      =   number_format($subjectIndex[$val['sid']]['price'],2);
					if($subjectIndex[$val['sid']]['pic']){
						 $List[$key]['pic']		=	$subjectIndex[$val['sid']]['pic'];
					}else{
						 $List[$key]['pic']		=	$this->config['sy_pxsubject_icon'];
					}
                }
                if(isset($trainIndex[$val['s_uid']])){
                    $List[$key]['train_name']   =   $trainIndex[$val['s_uid']]['name'];
                }
			}
        }

        return $List;
    }

    /**
     * 统计px_subject    课程数目
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getPxSubjectNum($whereData) {
        return $this -> select_num('px_subject', $whereData);
    }

     /**
     * 统计px_baoming    课程预约数目
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getPxBaomingNum($whereData) {
        return $this -> select_num('px_baoming', $whereData);
    }
     /**
     * 统计px_zixun   咨询留言数目
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getZixungNum($whereData) {
        return $this -> select_num('px_zixun', $whereData);
    }
	
	 /**
     * px_subject_collect    课程收藏数目
     * $whereData       查询条件
     * $data            自定义处理数组
     */
	function getSubCollectNum($Where=array()){
        return $this->select_num('px_subject_collect',$Where);
    }
	
	/**
     * px_subject_collect   详情
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getSubCollectInfo($whereData, $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $Info           =   $this -> select_once('px_subject_collect', $whereData, $data['field']);        
        return $Info;    
    }
	
	/**
     * 收藏课程
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function collectSub($data) {
		if(!empty($data)){
		
			if(!$data['uid']){
					
				return  -3;
				
			}elseif($this->usertype==4){
				
				return  -1;
				
			}
			
			$subject	=	$this->getSubInfo(array('id'=>(int)$data['id']),array('field'=>'`uid`'));
			
			if(empty($subject)){
				
				return  -2;
				
			}
			$info		=	$this->getSubCollectInfo(array('uid'=>$data['uid'],'sid'=>(int)$data['id']));
			
			if(empty($info)){
				
				$this->insert_into('px_subject_collect',array('sid'=>(int)$data['id'],'s_uid'=>$subject['uid'],'uid'=>$data['uid'],'ctime'=>time(),'usertype'=>$data['usertype']));
				$num	=	$this->getSubCollectNum(array('sid'=>(int)$data['id']));
				
				return  $num;
			}else{
				
				return  0;
				
			}
		}else{
			
			return  -3;
			
		}
			
    }
	
	/**
     * 添加报名
     * $addData      	添加参数
     * $data            自定义处理数组
     */
	 public function addBaoming($addData = array(), $data = array()){
		if(!empty($addData)){
			
			$nid	=	$this -> insert_into('px_baoming',$addData);
			
		}
	
		return $nid;
	
	 }
	
	/**
     * 添加px_train
     * $addData      	添加参数
     * $data            自定义处理数组
     */
	 public function addPxTrain($addData = array(), $data = array()){
		if(!empty($addData)){
			
			$nid	=	$this -> insert_into('px_train',$addData);
			
		}
	
		return $nid;
	
	 }
	 /**
     * 处理单个图片上传
     * @param file/需上传文件; dir/上传目录; type/上传图片类型; base/需上传base64; preview/pc预览即上传
     */
    private function upload($data = array('file'=>null,'dir'=>null,'type'=>null,'base'=>null,'preview'=>null)){
        
        include_once('upload.model.php');
        
        $UploadM  =  new upload_model($this->db, $this->def);
        
        $upArr  =  array(
            'file'     =>  $data['file'],
            'dir'      =>  $data['dir'],
            'type'     =>  $data['type'],
            'base'     =>  $data['base'],
            'preview'  =>  $data['preview']
        );
        $return  =  $UploadM -> newUpload($upArr);
        
        return $return;
    }
    public function statusLogo($uid,$data = array()){

        $uid  =  @explode(',',$uid);

        foreach($uid as $v){
            
            if($v){
                
                $uids[]  =  $v;
            }
        }

        if (!empty($uids)){
            
            $uidstr  =  pylode(',', $uids);
            
            $post    =  $data['post'];
            
            if ($post['logo_status'] == 2){
                //审核不通过删除图片
                $post['logo']	='';
            }
            
            $result  =  $this -> update_once('px_train', $post, array('uid'=>array('in',$uidstr)));

            if ($result){
                
                if ($post['logo_status'] == 2){
                    
                    // 审核不通过，相关表头像删除

                    $this -> update_once('answer',array('pic'=>''),array('uid'=>array('in',$uidstr)));
                    $this -> update_once('question',array('pic'=>''),array('uid'=>array('in',$uidstr)));
                    
                    $statusInfo  =  '您的LOGO';
                    
                    foreach ($uids as $k=>$v){
                        
                        /* 处理审核信息 */
                        if($post['logo_statusbody']){
                            
                            $statusInfo  .=  ' , 因为'.$post['logo_statusbody'].' , ';
                        }
                        
                        $statusInfo  .=  '已被管理员删除';
                        
                        $msg[$v]  =  $statusInfo;
                    }
                    
                    //发送系统通知
                    include_once('sysmsg.model.php');
                    
                    $sysmsgM  =  new sysmsg_model($this->db, $this->def);

                    $sysmsgM -> addInfo(array('uid'=>$uids,'usertype'=>4, 'content'=>$msg));
                    
                    
                }else{

                    $pxtrain  =  $this->select_all('px_train',array('uid'=>array('in',$uidstr)),'`uid`,`logo`');
                    foreach ($pxtrain as $k=>$v){
                        
                        $newlogo[$v['uid']]   =  $v['logo'];
                    }
                    $this -> update_once('answer',array('pic'=>array('CASE','uid',$newlogo)),array('uid'=>array('in',$uidstr)));
                    $this -> update_once('question',array('pic'=>array('CASE','uid',$newlogo)),array('uid'=>array('in',$uidstr)));
                }
                
                $return['msg']      =  '培训LOGO审核(ID:'.$uidstr.')设置成功';
                $return['errcode']  =  '9';
            }else{
                $return['msg']      =  '培训LOGO审核(ID:'.$uidstr.')设置失败';
                $return['errcode']  =  '8';
            }
        }else{
            $return['msg']      =  '请选择要培训审核的LOGO';
            $return['errcode']  =  '8';
        }
        return $return;

    }
		/**
	 * 后台培训机构环境审核
	 * @param string $id    格式：单个，如1 ; 批量，如1,2,3
	 * @param array $data
	 */
	public function statusShow($id,$data = array()){
	    
	    $id  =  @explode(',',$id);
	    
	    foreach($id as $v){
	        
	        if($v){
	            
	            $ids[]  =  $v;
	        }
	    }
	    if (!empty($ids)){
	        
	        $idstr  =  pylode(',', $ids);

	        $shows	=	$this	->	getPxshowList(array('id'=>array('in',$idstr)),array('field'=>'`uid`,`title`'));

	        $post    =  $data['post'];
	       
	        if ($post['status'] == 2){
                //审核不通过删除
                
                $result	=	$this	->	delete_all('px_train_show', array('id'=>array('in',$idstr)),'');
            
		    }elseif($post['status'] == 0){

                $result	=	$this	->	update_once('px_train_show',$post, array('id'=>array('in',$idstr)),'');
		    
		    }
		    
	        if ($result){
	            
	            if ($post['status'] == 0 || $post['status'] == 2){
	                
	                foreach ($shows as $k=>$v){
						$uids[]				=	$v['uid'];
						/* 处理审核信息 */
						if ($post['status'] == 2){
							
							$statusInfo		=	'您的机构环境('.$v['title'].')审核未通过';
							
							if($post['statusbody']){
								
								$statusInfo  .=  ', 原因：'.$post['statusbody'];
								
							}
							
							$msg[$v['uid']][]  =  $statusInfo;
							
						}elseif($post['status'] == 0){
							
							$msg[$v['uid']][]  =  '您的机构环境('.$v['title'].')已审核通过';
							
						}
	                }
					//发送系统通知
	                include_once('sysmsg.model.php');
	                
	                $sysmsgM  =  new sysmsg_model($this->db, $this->def);
	                
	                $sysmsgM -> addInfo(array('uid'=>$uids,'usertype'=>4, 'content'=>$msg));
	                
	            }
	            
	            $return['msg']      =  '机构环境审核(ID:'.$idstr.')设置成功';
	            $return['errcode']  =  '9';
	        }else{
	            $return['msg']      =  '机构环境审核(ID:'.$idstr.')设置失败';
	            $return['errcode']  =  '8';
	        }
	    }else{
	        $return['msg']      =  '请选择要审核的机构环境';
	        $return['errcode']  =  '8';
	    }
	    return $return;
	}
		/**
	 * 后台培训机构环境审核
	 * @param string $id    格式：单个，如1 ; 批量，如1,2,3
	 * @param array $data
	 */
	public function statusBanner($id,$data = array()){

	    $id  =  @explode(',',$id);
	    
	    foreach($id as $v){
	        
	        if($v){
	            
	            $ids[]  =  $v;
	        }
	    }
	    if (!empty($ids)){
	        
            $idstr  =  pylode(',', $ids);
            
            $shows  =   $this->getBannerList(array('id'=>array('in',$idstr)), array('field' => '`uid`'));

	        $post    =  $data['post'];

	        if ($post['status'] == 2){
                //审核不通过删除
                $result	=	$this	->	delete_all('px_banner', array('id'=>array('in',$idstr)),'');
            
		    }elseif($post['status'] == 0){

                $result	=	$this	->	update_once('px_banner',$post, array('id'=>array('in',$idstr)),'');
		    
		    }
		    
	        if ($result){
	            
	            if ($post['status'] == 0 || $post['status'] == 2){
	                
	                foreach ($shows as $k=>$v){
						$uids[]				=	$v['uid'];
						/* 处理审核信息 */
						if ($post['status'] == 2){
							
							$statusInfo		=	'您的机构横幅审核未通过';
							
							if($post['statusbody']){
								
								$statusInfo  .=  ', 原因：'.$post['statusbody'];
								
							}
							
							$msg[$v['uid']][]  =  $statusInfo;
							
						}elseif($post['status'] == 0){
							
							$msg[$v['uid']][]  =  '您的机构横幅已审核通过';
							
						}
	                }
					//发送系统通知
	                include_once('sysmsg.model.php');
	                
	                $sysmsgM  =  new sysmsg_model($this->db, $this->def);
	                
	                $sysmsgM -> addInfo(array('uid'=>$uids,'usertype'=>4, 'content'=>$msg));
	                
	            }
	            
                $return['msg']      =  '机构横幅审核(ID:'.$idstr.')设置成功';
                
                $return['errcode']  =  '9';
                
	        }else{
                $return['msg']      =  '机构横幅审核(ID:'.$idstr.')设置失败';
                
                $return['errcode']  =  '8';
                
	        }
	    }else{

            $return['msg']      =  '请选择要审核的机构横幅';
            
            $return['errcode']  =  '8';
            
        }
        
        return $return;
        
	}
	
	/**
	 * @desc 讲师审核，培训机构不是已审核状态，弹出同步操作状态审核
	 * @param int $id
	 * @param array $data|state statusbody
	 */
	public function statusTeacher($id, $data = array()){
	    
	    if (!$id){
	        
	        $return     =   array(
	            'errcode' => 8,
	            'msg'     => '参数错误！'
	        );
	        return $return;
	    }else{
	        
	        $teacher    =   $this->select_once('px_teacher', array('id' => $id), '`id`,`uid`,`name`');
	        
	        $upData     =   array(
	            
	            'status'    =>  intval($data['status']),
	            'statusbody'=>  trim($data['statusbody']),
	            'lastupdate'=>  time()
	        );
	        
	        $uid        =   $data['uid'];
	        
	        $result     =   $this -> update_once('px_teacher', $upData, array('id' => $id, 'uid' => $uid));
	        
	        if ($result) {
	            
	            if ($data['status'] == '1') {
	                require_once 'userinfo.model.php';
	                $userinfoM  =   new userinfo_model($this->db, $this->def);
	                
	                $post   =   array(
	                    'id'        =>  $id,
	                    'status'    =>  1
	                );
	                $userinfoM -> status(array('uid' => $uid, 'usertype' => 4), array('post' => $post));
	            }
	            
	            //发送系统通知
	            require_once 'sysmsg.model.php';
	            $sysmsgM    =   new sysmsg_model($this->db, $this->def);
	            $msg        =   $data['status'] == 2 ? '讲师《'.$teacher['name'].'》审核未通过；原因：'.$data['statusbody'] : '讲师《'.$teacher['name'].'》审核通过';
	            $sysmsgM -> addInfo(array('uid' => $uid,'usertype'=>4,'content'=>$msg));
	            
	            $return = array(
	                'errcode' => 9,
	                'msg'     => '讲师(ID:'.$id.')审核设置成功！'
	            );
	            
	        }else{
	            $return = array(
	                'errcode' => 8,
	                'msg'     => '讲师(ID:'.$id.')审核设置失败！'
	            );
	        }
	        
	        return $return;
	    }
	}
	
	/**
	 * @desc 课程审核，培训机构不是已审核状态，弹出同步操作状态审核
	 * @param int $id
	 * @param array $data|state statusbody
	 */
	public function statusSubject($id, $data = array()){
	    
	    if (!$id){
	        
	        $return     =   array(
	            'errcode' => 8,
	            'msg'     => '参数错误！'
	        );
	        return $return;
	    }else{
	        
	        $subject    =   $this->select_once('px_subject', array('id' => $id), '`id`,`uid`,`name`');
	        
	        $upData     =   array(
	            
	            'status'    =>  intval($data['status']),
	            'statusbody'=>  trim($data['statusbody']),
	            'lastupdate'=>  time()
	        );
	        
	        $uid        =   $data['uid'];
	        
	        $result     =   $this -> update_once('px_subject', $upData, array('id' => $id, 'uid' => $uid));
	        
	        if ($result) {
	            
	            if ($data['status'] == '1') {
	                require_once 'userinfo.model.php';
	                $userinfoM  =   new userinfo_model($this->db, $this->def);
	                
	                $post   =   array(
	                    'id'        =>  $id,
	                    'status'    =>  1
	                );
	                $userinfoM -> status(array('uid' => $uid, 'usertype' => 4), array('post' => $post));
	            }
	            
	            //发送系统通知
	            require_once 'sysmsg.model.php';
	            $sysmsgM    =   new sysmsg_model($this->db, $this->def);
	            $msg        =   $data['status'] == 2 ? '课程《'.$subject['name'].'》审核未通过；原因：'.$data['statusbody'] : '课程《'.$subject['name'].'》审核通过';
	            $sysmsgM -> addInfo(array('uid' => $uid,'usertype'=>4,'content'=>$msg));
	            
	            $return = array(
	                'errcode' => 9,
	                'msg'     => '课程(ID:'.$id.')审核设置成功！'
	            );
	            
	        }else{
	            $return = array(
	                'errcode' => 8,
	                'msg'     => '课程(ID:'.$id.')审核设置失败！'
	            );
	        }
	        
	        return $return;
	    }
	}
	
	/**
	 * @desc 新闻审核，培训机构不是已审核状态，弹出同步操作状态审核
	 * @param int $id
	 * @param array $data|state statusbody
	 */
	public function statusNews($id, $data = array()){
	    
	    if (!$id){
	        
	        $return     =   array(
	            'errcode' => 8,
	            'msg'     => '参数错误！'
	        );
	        return $return;
	    }else{
	        
	        $news      =   $this->select_once('px_train_news', array('id' => $id), '`id`,`uid`,`title`');
	        
	        $upData     =   array(
	            
	            'status'    =>  intval($data['status']),
	            'statusbody'=>  trim($data['statusbody']),
	            'lastupdate'=>  time()
	        );
	        
	        $uid        =   $data['uid'];
	        
	        $result     =   $this -> update_once('px_train_news', $upData, array('id' => $id, 'uid' => $uid));
	        
	        if ($result) {
	            
	            if ($data['status'] == '1') {
	                require_once 'userinfo.model.php';
	                $userinfoM  =   new userinfo_model($this->db, $this->def);
	                
	                $post   =   array(
	                    'id'        =>  $id,
	                    'status'    =>  1
	                );
	                $userinfoM -> status(array('uid' => $uid, 'usertype' => 4), array('post' => $post));
	            }
	            
	            //发送系统通知
	            require_once 'sysmsg.model.php';
	            $sysmsgM    =   new sysmsg_model($this->db, $this->def);
	            $msg        =   $data['status'] == 2 ? '新闻《'.$news['title'].'》审核未通过；原因：'.$data['statusbody'] : '新闻《'.$news['title'].'》审核通过';
	            $sysmsgM -> addInfo(array('uid' => $uid,'usertype'=>4,'content'=>$msg));
	            
	            $return = array(
	                'errcode' => 9,
	                'msg'     => '培训机构新闻(ID:'.$id.')审核设置成功！'
	            );
	            
	        }else{
	            $return = array(
	                'errcode' => 8,
	                'msg'     => '培训机构新闻(ID:'.$id.')审核设置失败！'
	            );
	        }
	        
	        return $return;
	    }
	}
	
}
?>