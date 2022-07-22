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
class school_model extends model{
	private function getClass($options){
	    if (!empty($options)){
	        
	        include_once('cache.model.php');
	        
	        $cacheM            =   new cache_model($this->db,$this->def);
	        
	        $cache             =   $cacheM -> GetCache($options);
	        
	        return $cache;
	    }
	}
      /**
      * 查询全部信息
      * @param 表：school_academy
      * @param 功能说明：获取school_academy表里面所有普工信息
      * @param 引用字段：$whereData：条件  2:$data:查询字段
      *
     */
     public function getSchoolAcademyList($whereData,$data=array()){
       $field             =   $data['field'] ? $data['field'] : '*';
       $List    =   $this   ->  select_all('school_academy',$whereData,$field);
      
       if(!empty($List) && $List){
			if($data['xjh']){
				foreach($List as $v){
					  
					$ids[]	=	$v['id'];
				}
				$xjhWhere['schoolid']	=	array('in',pylode(',',$ids));
				$xjhWhere['status']		=	1;
				$xjhWhere['etime']		=	array('>',time());
				$xjhWhere['groupby']	=	'schoolid';
				$xjh	=	$this->select_all('school_xjh',$xjhWhere,'`schoolid`,count(schoolid) as xjhnum');
			}
			$cache   =   $this -> getClass(array('school','city'));
			foreach($List as $k=>$v){
				if($v['provinceid']){
					$List[$k]['provinceid_n']			= $cache['city_name'][$v['provinceid']];
				}
				if($v['cityid']){
					$List[$k]['cityid_n']				= $cache['city_name'][$v['cityid']];
				}
				if($v['three_cityid']){
					$List[$k]['three_cityid_n']			= $cache['city_name'][$v['three_cityid']];
				}
				if($v['school_department']){
					$List[$k]['school_department_n']	= $cache['schoolclass_name'][$v['school_department']];
				}
				if($v['school_level']){
					$List[$k]['school_level_n']			= $cache['schoolclass_name'][$v['school_level']];
				}
				if($v['school_categty']){
					$List[$k]['school_categty_n']		= $cache['schoolclass_name'][$v['school_categty']];
				}
				if($v['schooltag']){
					$List[$k]['schooltag_n']			= $cache['schoolclass_name'][$v['schooltag']];
				}
				
				$List[$k]['photo_n']  = checkpic($v['photo']);
				foreach($xjh as $val){
					if($v['id']==$val['schoolid']){
						$List[$k]['atnnum']=$val['xjhnum'];
					}
				}
			}
			
			$ListNew['list']  =   $List;
		}
        return $ListNew;
    }
    
     /**
      * 查询单条信息
      * @param 查询表：school_academy
      *
     */
    public function getSchoolAcademyInfo($where=array(),$data=array()){
        
		$cache	=	$this -> getClass(array('school','city'));
    if($data['cache']){
			$List['cache']	=	$cache;
		}
		$select	=	$data['field'] ? $data['field'] : '*';
          
		$Info	=	$this -> select_once('school_academy',$where, $select);
        if(!empty($Info)){
      			if($Info['provinceid']){
      				$Info['provinceid_n']			= $cache['city_name'][$Info['provinceid']];
      			}
      			if($Info['cityid']){
      				$Info['cityid_n']				= $cache['city_name'][$Info['cityid']];
      			}
      			if($Info['three_cityid']){
      				$Info['three_cityid_n']			= $cache['city_name'][$Info['three_cityid']];
      			}
      			if($Info['school_department']){
      				$Info['school_department_n']	= $cache['schoolclass_name'][$Info['school_department']];
      			}
      			if($Info['school_level']){
      				$Info['school_level_n']			= $cache['schoolclass_name'][$Info['school_level']];
      			}
      			if($Info['school_categty']){
      				$Info['school_categty_n']		= $cache['schoolclass_name'][$Info['school_categty']];
      			}
      			if($Info['schooltag']){
      				$Info['schooltag_n']			= $cache['schoolclass_name'][$Info['schooltag']];
      			}
      			$Info['photo'] = checkpic($Info['photo']);	
      			
        }
        $List['info']	=	$Info;
      
        return $List;

    }
    /**
      * 添加信息
      * @param  表：school_academy
      * @param 功能说明：添加school_academy信息
      *
     */
    
    public function addSchoolAcademy($data){
      
        $adddata  =   array(

                'schoolname'          =>  $data['schoolname'],
                  
                'provinceid'          =>  $data['provinceid'],
                
                'cityid'              =>  $data['cityid'],
                
                'three_cityid'        =>  $data['three_cityid'],
                
                'school_categty'      =>  $data['school_categty'],
                
                'school_department'   =>  $data['school_department'],
                
                'school_level'        =>  $data['school_level'],
                
                'schooltag'           =>  $data['schooltag'],
                
                'school_phone'        =>  $data['school_phone'],
                
                'address'             =>  $data['address'],
                
                'schoolemail'         =>  $data['schoolemail'],
                
                'schoolinternet'      =>  $data['schoolinternet'],
                
                'downtime'            =>  time(),
                
                
                'lastupdate'          =>  time(),
                
                'did'          =>  $this->config['did']
     
        );

        if($data['photo']){
            $adddata['photo']  = $data['photo'];
        }
        
        $nid	=	$this->insert_into('school_academy',$adddata);
        
        return $nid;
      
    }
    
    
     /**
      * 更新信息
      * @param  表：school_academy
      * @param 功能说明：根据条件$id 修改school_academy表里面信息
      * @param 引用字段：$id :条件 2:$data:引用字段名称

      *
     */
  
    public function upSchoolAcademy($id,$data = array()){
    
      $where  =   array();
    
     if(!empty($id)){
        
          $where['id']   =   $id; 
          
          $updata  =   array(

                'schoolname'          =>  $data['schoolname'],
                  
                'provinceid'          =>  $data['provinceid'],
                
                'cityid'              =>  $data['cityid'],
                
                'three_cityid'        =>  $data['three_cityid'],
                
                'school_categty'      =>  $data['school_categty'],
                
                'school_department'   =>  $data['school_department'],
                
                'school_level'        =>  $data['school_level'],
                
                'schooltag'           =>  $data['schooltag'],
                
                'school_phone'        =>  $data['school_phone'],
                
                'address'             =>  $data['address'],
                
                'schoolemail'         =>  $data['schoolemail'],
                
                'schoolinternet'      =>  $data['schoolinternet'],
                
                'downtime'            =>  time(),
                
                'lastupdate'          =>  time(),
     
        );
        if($data['photo']){
            $updata['photo']  = $data['photo'];
        }

        $nid    =   $this ->  update_once('school_academy',$updata,$where);
       
        return $nid;
    }
    
  }
    
   
  
    /**
      * 删除信息
      * @param  表：resume_tiny
      * @param 功能说明：根据条件$id 删除resume_tiny表里面信息
      * @param 引用字段：$id :条件 2:$data:字段
      *
     */
	public function delSchoolAcademy($id,$data=array())
	{
		if(!empty($id)){
        
			if(is_array($id)){
                
				$ids	=	$id;
			}else{
                
				$ids	=   @explode(',', $id);
			}

			$id	=	pylode(',', $ids);
      
			$return['id']	=	$this -> delete_all('school_academy',array('id' => array('in',$id)),'');
            
			if($return['id']){
            
				$return['msg']      =  '院校(ID:'.$id.')删除成功';
				$return['errcode']  =  '9';
			}else{

				$return['msg']      =  '院校(ID:'.$id.')删除失败';
				$return['errcode']  =  '8';
	        }
		}else{
        
			$return['msg']      =  '系统繁忙';
			$return['errcode']  =  '8';
        }
		return $return;  
	}
	/**
      * 查询全部信息
      * @param 表：school_xjh
      * @param 功能说明：获取school_xjh表里面所有普工信息
      * @param 引用字段：$whereData：条件  2:$data:查询字段
      *
     */
     public function getSchoolXjhList($whereData,$data=array()){
       
        require_once ('company.model.php');
        require_once ('atn.model.php');
        $companyM	=   new company_model($this->db, $this->def);
        $atnM 		= 	new atn_model($this->db, $this->def);

        $List = array();

        $field = $data['field'] ? $data['field'] : '*';

        $List = $this->select_all('school_xjh', $whereData, $field);
      
        foreach($List as $val){
              
			$uids[]=$val['uid'];
				
			$sids[]=$val['schoolid'];
				
			$xjhids[]=$val['id'];
              
        }
       
       if(!empty($List) && $List){
         
            $cache   =   $this -> getClass(array('city'));
            
            $schoolwhere['id']		=   array('in', pylode(',', $sids));
            $schoollist   			=   $this -> select_all('school_academy',$schoolwhere,'`id`,`schoolname`');
			
            $Companywhere['uid']   =   array('in', pylode(',', $uids));
            $ListA				   =   $companyM     ->    getList($Companywhere);
            $companyList		   =	$ListA['list'];
                        
            $atnwhere['xjhid']     =   array('in', pylode(',', $xjhids));
            $atnwhere['groupby']   =   'xjhid';
            $atnNumList            =    $atnM     ->    getatnList($atnwhere,array('field'=>'`xjhid`,count(xjhid) as xjhnum'));
            
            foreach($List  as $key=>$val){
                
                $List[$key]['provinceid_n']    =   $cache['city_name'][$val['provinceid']];
                $List[$key]['cityid_n']        =   $cache['city_name'][$val['cityid']];
                $List[$key]['three_cityid_n']  =   $cache['city_name'][$val['three_cityid']];  
                
                foreach($companyList  as  $v){
                  
					if($val['uid']==$v['uid']){
                    
						$List[$key]['com_name']    =   $v['name'];
                    
					}
                }
                foreach($schoollist   as  $v){
                  
					if($val['schoolid']==$v['id']){
                     
						$List[$key]['sch_name']    =    $v['schoolname'];

					}
                }
                foreach($atnNumList           as  $v){
                  
					if($val['id']==$v['xjhid']){
                     
						$List[$key]['atnnum']      =    $v['xjhnum'];

					}
                }
            }
       }
        return $List;
    }
    
    
    /**
     * @desc    查询宣讲会单条信息
     * @param   int     $id : 传值ID参数查询
     * @param   array   $data ： 自定义查询数组（data['where']=>补充查询条件； data['cache']=>后台修改宣讲会，查询城市类别返回；）
     * @return  array
     */
    public function getSchoolXjhInfo($id,$data=array()){
        
        if(!empty($id) || !empty($data['where'])){
            $select    =   $data['field'] ? $data['field'] : '*';
            $where     =   array();
            if (!empty($id)) {
                $where['id']	=   intval($id);
            }
			if($data['uid']){
				$where['uid']	=   intval($data['uid']);
			}
            if (!empty($data['where'])) {
                $where			=   array_merge($where, $data['where']);
            }
			$cache   	=   $this -> getClass(array('city'));
			
            $Info     	=   $this -> select_once('school_xjh', $where, $select);
			if(!empty($Info)){
				if($Info['provinceid']){
					$Info['provinceid_n'] 	=   $cache['city_name'][$Info['provinceid']];
				}
				if($Info['cityid']){
					$Info['cityid_n']    	=   $cache['city_name'][$Info['cityid']];
				}
				if($Info['three_cityid']){
					$Info['three_cityid_n']	=   $cache['city_name'][$Info['three_cityid']];
				}
			}
			$List['info']		=	$Info;
			
            if ($data['cache'] == '1') {
                $List['cache']	=   $cache;
            }
        }
        return $List;
    }
     
    /**
     * @desc   更新信息
     * @param  表：school_xjh
     * @param  功能说明：根据条件$id 修改school_xjh表里面信息
     * @param  引用字段：$id :条件 2:$data:引用字段名称
     */
    public function upSchoolXjh($id,$data = array()){
        
        $where      =   array();
    
     if(!empty($id)){
          
          $where['id']   =   $id; 
            
          $nid    =   $this ->  update_once('school_xjh',$data,$where);
         
          return $nid;
      }
    
    }
    
    
    /**
     * @desc    添加宣讲会
     * @param   表：school_xjh
     * @param   功能说明：添加一条到school_xjh表里面信息
     * @param   引用字段：2:$data:引用字段名称
     */
    public function addSchoolXjh($data=array()){
		$post	=	$data['post'];
		$id	 	= 	intval($data['id']);
  
		if($post['provinceid']==''){
			$return['msg']		=	'请选择宣讲省份';
			$return['errcode']	=	8;
		}
		if($post['cityid']==''){
			$return['msg']		=	'请选择宣讲城市';
			$return['errcode']	=	8;
		}
		if($post['schoolid']==''){
			$return['msg']		=	'请选择宣讲学校';
			$return['errcode']	=	8;
		}
		if($post['address']==''){
			$return['msg']		=	'请选择详细地点';
			$return['errcode']	=	8;
		}
		if($data['datetime']==''){
			$return['msg']		=	'请选择宣讲时间';
			$return['errcode']	=	8;
		}
		if($data['stime']==''){
			$return['msg']		=	'请选择宣讲开始时间';
			$return['errcode']	=	8;
		}
		if($data['etime']==''){
			$return['msg']		=	'请选择宣讲结束时间';
			$return['errcode']	=	8;
		}
		
		$sdate	=	strtotime($data['datetime'].' '.$data['stime']);
		$edate	=	strtotime($data['datetime'].' '.$data['etime']);
  
		if($sdate>$edate){
			$return['msg']		=	'开始时间要小于结束时间';
			$return['errcode']	=	8;
		}
		$post['stime']		=	$sdate;
		$post['etime']		=	$edate;
		
		if($id){
			$return['id']	=	$this -> update_once('school_xjh',$post,array('id'=>$id,'uid'=>$post['uid']));
			$msg			=	'修改';
		}else{
			$post['ctime' ]	=	time();
			$return['id']	=	$this->insert_into('school_xjh',$post);
			$msg			=	'添加';
		}
		if($return['id']){
			$return['msg']		=	$msg.'成功';
			$return['errcode']	=	9;
		}else{
			$return['msg']		=	$msg.'失败';
			$return['errcode']	=	8;
		}
        return $return;
    }
    /**
     * @desc   删除信息
     * @param  表：school_xjh
     * @param  功能说明：根据条件$id 删除school_xjh表里面信息
     * @param  引用字段：$id :条件 2:$data:字段
     */
    public function delSchoolxjh($id, $data=array()){
      
        if(!empty($id)){
            
            $return     =   array();
        
            if(is_array($id)){
                
                $ids        =	$id;
                
                $return['layertype']	=	1;
                
            }else{
                
                $ids        =   @explode(',', $id);
                
                $return['layertype']	=	0;
                
            }
            
            $ids            =   pylode(',', $ids);
			if($data['uid']){
				$delWhere = array('id' => array('in',$ids),'uid'=>$data['uid']);
			}else{
				$delWhere = array('id' => array('in',$ids));
			}
			 
            $return['id']	=	$this -> delete_all('school_xjh',$delWhere,'');
            
            if($return['id']){
                
                $return['msg']      =  '校招宣讲会(ID:'.pylode(',', $id).')删除成功';
                
                $return['errcode']  =  '9';
            
            } else{
                
                $return['msg']      =  '校招宣讲会(ID:'.pylode(',', $id).')删除失败';
                
                $return['errcode']  =  '8';
            
            }
        
        }else{
            
            $return['msg']          =  '系统繁忙';
          
            $return['errcode']      =  '8';
			$return['layertype']	=	0;
        
        }
      
        return $return;  
     
    }
     
   
    
 
    
}
?>