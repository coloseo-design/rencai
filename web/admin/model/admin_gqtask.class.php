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
class admin_gqtask_controller extends adminCommon{

    private  function set_search(){

        $search_list[]              =           array('param' => 'status',   'name'=>'审核状态', 'value' =>  array('3'=>'待审核','1'=>'已审核','2'=>'未通过'));
       	
        $search_list[]              =           array('param' => 'state',  'name'=>'招聘状态', 'value' =>  array('1'=>'招聘中','2'=>'已过期'));
		
        $search_list[]              =           array('param' => 'ctime',   'name'=>'发布时间', 'value' =>  array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月'));
        
        $this->yunset("search_list", $search_list);
    }
    
    /**
     * @desc 后台供发布求任务 -- 浏览记录
     */

    function index_action(){

        $this->set_search();
       

        $gqdemandM    			        =  		     $this -> MODEL('gqdemand');
         //查询状态
        
        if($_GET['status']){
		    
		    $status                     =            intval($_GET['status']);
		    
		    if($status == 3){

		        $where['status']      =            '0';
		        
		    }elseif($status == 2){
		        
		       $where['status']       =             '2';
 		        
		    }elseif($status==1){
		        
                $where['status']      =             '1';
 		        
		    }
		    
		    $urlarr['status']           =               $status;
        }
        //招聘状态
        
        if($_GET['state']){
		    
		    $state                      =               intval($_GET['state']);
		    
		   if($state    ==      1){

                $where['etime']         =               array('>',time());

           }else{

                 $where['etime']        =               array('<',time());


           }
		    
		    $urlarr['state']            =               $state;
		}
        
        
        //查询时间
        if ($_GET['ctime']) {
	        
	        $ctime                      =               intval($_GET['ctime']);
	        
	        if($ctime == 1){
	        
                $where['ctime']         =               array('>',  strtotime('today'));
	        
	        }else {
	            
	            $where['ctime']         =               array('>', strtotime('-'.$ctime.' day'));    
	            
	        }
	        
	        $urlarr['ctime']            =               $ctime;
	        
        }
        //根据条件查询
      
        $typeStr                        =               intval($_GET['type']);

        $keywordStr                     =               trim($_GET['keyword']);
        
        if (!empty($keywordStr)) {
            
            if ($typeStr == 2) {
                
                $mwhere['name']          =              array('like',$keywordStr);

                $gqrows                  =              $gqdemandM->getGqinfoList($mwhere,array('field'=>'`uid`','type'=>1));

                foreach($gqrows as $v){
	                
	                $gquids[]	         =	            $v['uid'];
	                
                }
                
                $where['uid']            =              array('in',pylode(',',$gquids));

            } else{
                $where['name']           =              array('like',$keywordStr);
                
                 
            }
            
            $urlarr['type']              =              $typeStr;

            $urlarr['keyword']           =              $keywordStr;
        }
     
        //分页链接
		$urlarr        					 =  			$_GET;
        $urlarr['page']	                 =	            '{{page}}';
        
        $pageurl		                 =	            Url($_GET['m'],$urlarr,'admin');
        
        //提取分页
        $pageM			                 =	            $this  -> MODEL('page');
      
        $pages			                 =	            $pageM -> pageList('gq_task',$where,$pageurl,$_GET['page']);
       
        //分页数大于0的情况下 执行列表查询
        if($pages['total'] > 0){
           
            
            //limit order 只有在列表查询时才需要
            if($_GET['order']){
                
                $where['orderby']		=	            $_GET['t'].','.$_GET['order'];

                $urlarr['order']		=	            $_GET['order'];

                $urlarr['t']			=	            $_GET['t'];
                
            }else{
                $where['orderby']		=	            array('status,asc','id,desc');   
            }
           
            $where['limit']				=	            $pages['limit'];
           
            $rows                       =               $gqdemandM->getGqtaskList($where);

            $this -> yunset('rows',$rows);
            
        }
        
        $this->yuntpl(array('admin/admin_gqtask_list'));
        
    }

    /**
     * @desc  删除供求发布记录
     */
    function delgqtask_action(){
        
        $gqdemandM    			        =  		        $this -> MODEL('gqdemand');

        if(is_array($_GET['del'])){
            
            $id                         =               $_GET['del'];
            
        }else{
            
            $id                         =               intval($_GET['id']);
            
        }

        $arr                            =               $gqdemandM -> deltask($id,array('utype'=>'admin'));
        
        $this ->  layer_msg($arr['msg'], $arr['errcode'], $arr['layertype'],$_SERVER['HTTP_REFERER']);
        
    }
     //详情页面
     public function details_action(){

        $gqdemandM    	            =  		        $this -> MODEL('gqdemand');

        $id                         =               intval($_GET['id']);

        $where['id']                =               $id;

        $show                       =               $gqdemandM   ->  getGqtaskInfo($where, array('type' =>1));

        $this ->  yunset('show',  $show);

        
        $this ->  yunset('lasturl',   $_SERVER['HTTP_REFERER']);

		$this->yuntpl(array('admin/admin_gqtask_details'));

    }
  
    //浏览
    public function show_action(){

        $gqdemandM    	                =  		        $this -> MODEL('gqdemand');

        if($_GET['id']){

            $id                         =               intval($_GET['id']);

            $where['id']                =               $id;

            $show                       =               $gqdemandM   ->  getGqtaskInfo($where, array('type' =>1));

            $this ->  yunset('show',  $show);

            $time                       =               time();
            
            $this ->  yunset('time',  $time);
            
            $this ->  yunset('lasturl',   $_SERVER['HTTP_REFERER']);
            
        }

		$this->yuntpl(array('admin/admin_gqtask_show'));

    }
    //审核说明  type=>1:表示不查询里面联系表信息    type     =>  null   表示查询联系表信息
    public function  lockinfo_action(){

        $gqdemandM    	                =  		        $this -> MODEL('gqdemand');

        $id                             =               intval($_POST['id']);

        $where['id']                    =               $id;

        $tinfo                          =               $gqdemandM-> getGqtaskInfo($where,array('field'=>'`statusbody`','type'=>1));
        
        echo $tinfo['statusbody'];die;

    }

    //审核任务
    public function statis_action()
	{

        $gqdemandM	=	$this -> MODEL('gqdemand');

        $id			=@explode(',', $_POST['id']);
        
        if($_POST['status']  ==""){

            $this->ACT_layer_msg("请选择审核状态",8);return false;

        }
     
        if($id){
  
            $updata	=	array(

                'status'	=>	$_POST['status'],  
                'statusbody'=>	$_POST['statusbody']
            );

            $return	=	$gqdemandM -> upGqtaskStatus($id,$updata);
         
            $this -> ACT_layer_msg($return['msg'], $return['errcode'], $_SERVER['HTTP_REFERER'], 2, 1);

        }else{

            $this->ACT_layer_msg('非法操作！',8,$_SERVER['HTTP_REFERER']);
        }
    }

    //修改保存
    public function savetask_action(){

        $gqdemandM    	                =  		         $this -> MODEL('gqdemand');

        if($_POST['update']){
		    
		    $id                         =              intval($_POST['id']);
            
            $lasturl                    =              trim($_POST['lasturl']);
		    
		    if (!empty($id)) {

                $data                   =               array(

                    'name'              =>              $_POST['name'],

                    'salary'            =>              $_POST['salary'],

                    'edate'             =>              $_POST['edate'],

                    'etime'             =>              strtotime($_POST['etime']),

                    'content'           =>              str_replace(array('&amp;','background-color:#ffffff','background-color:#fff','white-space:nowrap;'),array('&','background-color:','background-color:','white-space:'),$_POST['content']),

                    'link_man'          =>              $_POST['link_man'],

                    'link_moblie'       =>              $_POST['link_moblie'],

                    'lastupdate'        =>              time(),

                    'hits'              =>              $_POST['hits']

                );

                $where['id']            =               $id;
                 
                $arr                    =               $gqdemandM -> upaddGqtask($where, $data,1);
		        
		        $this ->  ACT_layer_msg($arr['msg'],$arr['errcode'],$lasturl,2,1);
		            
		    }else{

                $this->ACT_layer_msg('非法操作！',8,$lasturl);

            }           

        }
        
    }

    /**
	 * @desc 获取项目发布任务数量
	 */
	function gqtaskNum_action(){

        $MsgNum             =           $this->MODEL('msgNum');
        
        echo $MsgNum->taskNum();
        
	}
    
}
?>