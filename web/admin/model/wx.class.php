<?php
/* *
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
*/
class wx_controller extends adminCommon{
	
	
	protected	$pubtoolself_publiccolumn_map = array();
	protected 	$pubtoolself_publiccolumn = array();

	protected 	$pubtoolself_jobcolumn_map = array();
	protected 	$pubtoolself_jobcolumn = array();

	protected 	$pubtoolself_resumecolumn = array();
	protected 	$pubtoolself_resumecolumn_map = array();

	protected   $pubtoolself_companycolumn = array();
	protected 	$pubtoolself_companycolumn_map = array();

	protected 	$pubtoolself_totalcolumn = array();
	protected 	$pubtoolself_totalcolumn_map = array();

	function __construct($tpl,$db,$def='',$model='index',$m='') {

		parent::__construct($tpl,$db,$def,$model,$m);
		//职位参数
		$wxpubtempM	=	$this->MODEL('wxpubtemp');
		
		$this->pubtoolself_jobcolumn_map 	= $wxpubtempM->pubtoolself_jobcolumn_map;

    
    	$this->pubtoolself_jobcolumn 		= $wxpubtempM->pubtoolself_jobcolumn;
    	//简历参数
    
    	$this->pubtoolself_resumecolumn_map = $wxpubtempM->pubtoolself_resumecolumn_map;
    	$this->pubtoolself_resumecolumn 	= $wxpubtempM->pubtoolself_resumecolumn;
    	//企业参数
    
    	$this->pubtoolself_companycolumn 	= $wxpubtempM->pubtoolself_companycolumn;
    	$this->pubtoolself_companycolumn_map= $wxpubtempM->pubtoolself_companycolumn_map;
    	//模板类型公共参数
   		$this->pubtoolself_publiccolumn_map = $wxpubtempM->pubtoolself_publiccolumn_map;
    	$this->pubtoolself_publiccolumn 	= $wxpubtempM->pubtoolself_publiccolumn;
    	//整体公共参数
    	$this->pubtoolself_totalcolumn_map 	= $wxpubtempM->pubtoolself_totalcolumn_map;
    	$this->pubtoolself_totalcolumn 		= $wxpubtempM->pubtoolself_totalcolumn;
		
	}
	//设置高级搜索功能
	function set_search(){
		/*高级搜索相关代码*/
		$type		=	array('1'=>'关注微信','2'=>'绑定微信账户','3'=>'创建首份简历','4'=>'企业完善资料');
		$usertype	=	array('1'=>'个人','2'=>'企业','3'=>'猎头','4'=>'培训');
		$status		=	array('2'=>'失败','1'=>'成功');
		$time		=	array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$this->yunset('type',$type);
		$this->yunset('usertype',$usertype);
		$this->yunset('status',$status);
		$this->yunset('time',$time);

		/*高级搜索结束*/
		$search_list[]	=	array('param'=>'usertype','name'=>'用户类型','value'=>$usertype);
		$search_list[]	=	array('param'=>'status','name'=>'状态','value'=>$status);
		$search_list[]	=	array('param'=>'time','name'=>'发放时间','value'=>$time);
		$search_list[]	=	array('param'=>'type','name'=>'红包类型','value'=>$type);
		$this->yunset('search_list',$search_list);
	}

	function setwx_search(){
		/*高级搜索相关代码*/
		$status	=	array('2'=>'未登录','1'=>'已登录');

		$time	=	array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');

		$this->yunset('status',$status);

		$this->yunset('time',$time);

		/*高级搜索结束*/
		$search_list[]	=	array('param'=>'status','name'=>'状态','value'=>$status);

		$search_list[]	=	array('param'=>'time','name'=>'登录时间','value'=>$time);

		$this->yunset('search_list',$search_list);
	}

	function index_action(){

		$this->yuntpl(array('admin/admin_wx'));

	}

	function wxtz_action(){

		$this->yuntpl(array('admin/admin_wxtz'));

	}

	function save_action(){
 		if($_POST['msgconfig']){
 		    $_POST      =   $this->post_trim($_POST);
			//实例化
			$configM	=	$this->MODEL('config');

			unset($_POST['msgconfig']);

			$configM->setConfig($_POST);

			$this->web_config();

			$this->ACT_layer_msg('微信配置更新成功！',9,$_SERVER['HTTP_REFERER'],2,1);
		}
	}

	function wxredpack_action(){
		//微信红包使用场景
	    $redArr  =  array(
	        '0'  =>  '其他',
	        '1'  =>  '商品促销',
	        '2'  =>  '抽奖',
	        '3'  =>  '虚拟物品兑奖',
	        '4'  =>  '企业内部福利',
	        '5'  =>  '渠道分润'
	    );
	    $this->yunset('redArr',$redArr);

 		if($_POST['msgconfig']){

			//实例化
			$configM	=	$this->MODEL('config');

			unset($_POST['msgconfig']);

			unset($_POST['pytoken']);

			$configM->setConfig($_POST);

			$this->web_config();

			$this->ACT_layer_msg('微信红包配置更新成功！',9,$_SERVER['HTTP_REFERER'],2,1);

		}

		$this->yuntpl(array('admin/admin_wxredpack'));
	}

	function binduser_action(){

		//实例化
		$userInfoM =	$this->MODEL('userinfo');

		$where['PHPYUNBTWSTART']	=	'';

		$where['wxid'][]			=	array('<>','');

		$where['wxid'][]			=	array('notnull');

		$where['PHPYUNBTWEND']		=	'';

		if(trim($_GET['keyword'])){

			$where['username']	=	array('like',trim($_GET['keyword']));

			$urlarr['keyword']	=	$_GET['keyword'];

		}

		//分页链接
		$urlarr        	=   $_GET;
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	$_GET['c'];
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');

		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('member',$where,$pageurl,$_GET['page']);

		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){

		    //limit order 只有在列表查询时才需要
			$where['orderby']		=	'wxbindtime,desc';

		    $where['limit']			=	$pages['limit'];

			$urlarr['order']		=	$_GET['order'];

			$urlarr['t']			=	$_GET['t'];

		    $List	=	$userInfoM -> getList($where,array('field'=>'`uid`,`username`,`wxid`,`wxbindtime`'));

			$this->yunset('userList',$List);
		}

		$this->yuntpl(array('admin/admin_wxbind'));
	}

	function keyword_action(){

		$hotKeyM	=	$this->MODEL('hotkey');

		$where['type']	=	'8';

		if(trim($_GET['keyword'])){

			$where['key_name']	=	array('like',trim($_GET['keyword']));

			$urlarr['keyword']	=	trim($_GET['keyword']);
		}
		$urlarr        	=   $_GET;
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	$_GET['c'];
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');

		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('hot_key',$where,$pageurl,$_GET['page']);

		if($pages['total'] > 0){

			$where['orderby']		=	'num,desc';

		    $where['limit']			=	$pages['limit'];

			$urlarr['order']		=	$_GET['order'];

			$urlarr['t']			=	$_GET['t'];

		    $List	=	$hotKeyM -> getList($where);

			$this->yunset('keyList',$List);
		}

		$this->yuntpl(array('admin/admin_wxkey'));
	}

	function wxnav_action(){
		//实例化
		$weiXinM			=	$this->MODEL('weixin');

		$where['id']		=	array('>',0);

		$where['orderby']	=	'sort,asc';

  		$navlist 			= 	$weiXinM->getWxNavList($where);

		$this->yunset('navlist',$navlist);

		$this->yuntpl(array('admin/admin_wxnav'));
	}

	function wxlog_action(){
		$this->set_search();

		//实例化
		$wxredpackM	=	$this->MODEL('wxredpack');


		if(trim($_GET['keyword'])){

			if($_GET['wtype']=='1'){

				$where['re_nick']	=	array('like',trim($_GET['keyword']));

		    }elseif($_GET['wtype']=='2'){

				$where['username']	=	array('like',trim($_GET['keyword']));

			}

			$where['PHPYUNBTWSTART']		=	'';

			$where['username']		=	array('like',trim($_GET['keyword']));

			$where['re_nick']		=	array('like',trim($_GET['keyword']),'or');

			$where['PHPYUNBTWEND']	=	'';

			$urlarr['keyword']		=	trim($_GET['keyword']);
		}

		if($_GET['status']){

			if($_GET['status']=='2'){

				$status = 0;

			}else{

				$status = $_GET['status'];

			}
			$where['status']		=	$status;

			$urlarr['status']		=	trim($_GET['status']);
		}

		if($_GET['usertype']){

			$where['usertype']		=	$_GET['usertype'];

			$urlarr['usertype']		=	trim($_GET['usertype']);
		}

		if($_GET['type']){

			$where['type']			=	$_GET['type'];

			$urlarr['type']			=	trim($_GET['type']);
		}

		if($_GET['time']){

			if($_GET['time']=='1'){

				$where['time']		=	array('>',strtotime(date('Y-m-d 00:00:00')));

			}else{

				$where['time']		=	array('>',strtotime('-'.intval($_GET['time']).' day'));
			}

				$urlarr['time']		=	$_GET['time'];

		}

		//分页链接
		$urlarr        	=   $_GET;
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	$_GET['c'];
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');

		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('wxredpack',$where,$pageurl,$_GET['page']);

		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){

		    //limit order 只有在列表查询时才需要
			$where['orderby']		=	'time,desc';

		    $where['limit']			=	$pages['limit'];

			$urlarr['order']		=	$_GET['order'];

			$urlarr['t']			=	$_GET['t'];

			$List	=	$wxredpackM -> getWxRedPackList($where);

			$this->yunset('logList',$List['list']);
		}

		$this->yuntpl(array('admin/admin_wxlog'));
	}

	function wxqrcodelog_action(){
		$this->setwx_search();
		// 查询出字段值为纯数字的，排除带参二维码
		$where['wxloginid']  =  array('regexp','[^0-9.]');
		//实例化
		$weiXinM	=	$this->MODEL('weixin');

		if(trim($_GET['keyword'])){

			if($_GET['wtype']=='1'){

				$where['re_nick']	=	array('like',trim($_GET['keyword']));

		    }elseif($_GET['wtype']=='2'){

				$where['username']	=	array('like',trim($_GET['keyword']));

			}

			$where['PHPYUNBTWSTART']		=	'';

			$where['username']		=	array('like',trim($_GET['keyword']));

			$where['re_nick']		=	array('like',trim($_GET['keyword']),'or');

			$where['PHPYUNBTWEND']	=	'';

			$urlarr['keyword']		=	trim($_GET['keyword']);

			$urlarr['keyword']		=	trim($_GET['keyword']);
		}

		if($_GET['status']){

			if($_GET['status']=='2'){

				$status = 0;

			}else{

				$status = $_GET['status'];

			}
			$where['status']		=	$status;

			$urlarr['status']		=	trim($_GET['status']);
		}

		if($_GET['usertype']){

			$where['usertype']		=	$_GET['usertype'];

			$urlarr['usertype']		=	trim($_GET['usertype']);
		}

		if($_GET['time']){

			if($_GET['time']=='1'){

				$where['time']		=	array('>',strtotime(date('Y-m-d 00:00:00')));

			}else{

				$where['time']		=	array('>',strtotime('-'.intval($_GET['time']).' day'));
			}

				$urlarr['time']		=	$_GET['time'];

		}

		//分页链接
		$urlarr        	=   $_GET;
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	$_GET['c'];
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');

		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('wxqrcode',$where,$pageurl,$_GET['page']);

		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){

		    //limit order 只有在列表查询时才需要
			$where['orderby']		=	'time,desc';

		    $where['limit']			=	$pages['limit'];

			$urlarr['order']		=	$_GET['order'];

			$urlarr['t']			=	$_GET['t'];
			
			$List	=	$weiXinM -> getWxQrcodeList($where);

			$this->yunset('logList',$List['list']);
		}

		$this->yuntpl(array('admin/admin_wxqrcodelog'));
	}

	function edit_action(){

		//实例化
		$weiXinM	=	$this->MODEL('weixin');

		$logM		=	$this->MODEL('log');

		if($_POST['name'] && $_POST['keyid']!==''){

			$data['name']		=	$_POST['name'];

			$data['key'] 		= 	$_POST['key'];

			$data['keyid'] 		= 	$_POST['keyid'];

			$data['url'] 		= 	$_POST['url'];

			$data['type'] 		= 	$_POST['type'];

			$data['sort'] 		= 	$_POST['sort'];

			$data['appid'] 		= 	$_POST['appid'];

			$data['apppage'] 	= 	$_POST['apppage'];

			$where['name']		= 	$_POST['name'];

			if($_POST['keyid']>0){

				if(!$_POST['key'] && $_POST['type']=='click'){

					echo 1;exit();

				}elseif($_POST['type']=='miniprogram' && (!$_POST['url'] || !$_POST['appid'] || !$_POST['apppage'])){

					echo 1;exit();

				}elseif($_POST['type']=='view' && !$_POST['url']){

					echo 1;exit();

				}else{

					$where['PHPYUNBTWSTART']		=	'';

					$where['name']			=	$_POST['name'];

					$where['keyid']			=	$_POST['keyid'];

					$where['PHPYUNBTWEND']	=	'';

				}
			}

			if($_POST['navid']>0){

				$where['id']	=	array('<>',$_POST['navid']);

			}

 			$nav = $weiXinM->getWxNavNum($where);

			if($nav>0){

				echo 2;exit();

			}

			unset($_POST['pytoken']);

			if($_POST['navid']>0){

				$navid = $_POST['navid'];

				unset($_POST['navid']);

				$upWhere['id']	=	$navid;

				$weiXinM->upWxNavInfo($upWhere,$data);

				$logM	->addAdminLog('微信菜单(ID:'.$navid.')修改成功');

			}else{

				$navid	=	$weiXinM->addWxNavInfo($data);

				$logM	->addAdminLog('微信菜单(ID:'.$navid.')添加成功');
			}

			echo 3;	exit();

		}else{

			echo 1;	exit();

		}

	}

	function creat_action(){

		//实例化
		$weiXinM			=	$this->MODEL('weixin');

		$where['id']		=	array('>',0);

		$where['orderby']	=	array('keyid,asc','sort,asc');

  		$creatNav	=	$weiXinM->creatWxNavList($where);

		if(is_array($creatNav))	{

 			$Token = getToken();

 			$DelUrl = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.$Token;
			CurlPost($DelUrl);

			$Url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$Token;
			$result = CurlPost($Url,urldecode(json_encode($creatNav)));

			$Info = json_decode($result);

			if($Info->errcode=='0' || $Info->errmsg=='ok'){

				echo 1;die;

			}else{

				echo '错误代码:'.$Info->errcode.',错误信息:'.$Info->errmsg;die;
			}
		}
	}

 	function delnav_action(){

		//实例化
		$weiXinM	=	$this->MODEL('weixin');

		if($_POST['del']){

			$where['id']	=	array('in',pylode(',',$_POST['del']));

			$where['keyid']	=	array('in',pylode(',',$_POST['del']),'or');

			$weiXinM->delWxNav($where,array('type'=>'all'));

			$this->layer_msg('微信菜单(ID:'.pylode(',',$_POST['del']).')删除成功！',9,1,$_SERVER['HTTP_REFERER']);
		}
		if((int)$_GET['delid']){

			$this->check_token();

			$where['id']	=	(int)$_GET['delid'];

			$where['keyid']	=	array('=',(int)$_GET['delid'],'or');

			//删除微信菜单及子菜单
			$id	=	$weiXinM->delWxNav($where,array('type'=>'one'));

			$id?$this->layer_msg('微信菜单(ID:'.$_GET['delid'].')删除成功！',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,0,$_SERVER['HTTP_REFERER']);
		}
	}

 	function deluser_action(){

		//实例化
		$userInfoM	=	$this->MODEL('userinfo');
		if($_GET['del']){

			$this->check_token();

			$where['uid']	=	array('in',pylode(',',$_GET['del']));

			$data['wxid']	=	'';

			$userInfoM->upInfo($where,$data);

			$this->layer_msg('微信用户(ID:'.pylode(',',$_GET['del']).')取消绑定成功！',9,1,$_SERVER['HTTP_REFERER']);
		}

	}

	function ajax_action(){
		//实例化
		$weiXinM	=	$this->MODEL('weixin');

		$logM		=	$this->MODEL('log');

		if($_POST['sort']){

			$upWhere['id']	=	$_POST['id'];

			$data['sort']	=	$_POST['sort'];

			$weiXinM->upWxNavInfo($upWhere,$data);

			$logM->addAdminLog('微信菜单(ID:'.$_POST['id'].')排序修改成功');
		}

		if($_POST['name']){

			$upWhere['id']	=	$_POST['id'];

			$data['name']	=	$_POST['name'];

			$weiXinM->upWxNavInfo($upWhere,$data);

			$logM->addAdminLog('微信菜单(ID:'.$_POST['id'].')名称修改成功');
		}

		echo '1';die;
	}

	function zdkeyword_action(){
		//实例化
		$weiXinM	=	$this->MODEL('weixin');


		if(trim($_GET['keyword'])){

			$where['keyword']	=	array('like',trim($_GET['keyword']));

			$urlarr['keyword']	=	trim($_GET['keyword']);
		}

		//分页链接
		$urlarr        	=   $_GET;
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	$_GET['c'];
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');

		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('wxzdkeyword',$where,$pageurl,$_GET['page']);

		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){

		    //limit order 只有在列表查询时才需要
			$where['orderby']		=	'time,desc';

		    $where['limit']			=	$pages['limit'];

			$urlarr['order']		=	$_GET['order'];

			$urlarr['t']			=	$_GET['t'];

		    $List	=	$weiXinM->getWxzdkeywordList($where);

			$this->yunset('keyList',$List['list']);
		}

		$this->yuntpl(array('admin/admin_zdkeyword'));
	}

	//一键清除三天以上记录
	function clearwx_action(){

		//实例化
		$weiXinM	=	$this->MODEL('weixin');

		$where['time']	=	array('<',strtotime('-3 days'));

		$del		=	$weiXinM->delWxqrcode($where,array('type'=>'all'));

		echo $del ? '清理完成！' : '删除失败！';

	}

	function zdaddkeyword_action(){

		//实例化
		$weiXinM		=	$this->MODEL('weixin');

		$where['id']	=	(int)$_GET['id'];

		$row	=	$weiXinM->getWxzdkeyword($where);

	    $this->yunset('row',$row);

		if($_POST['submit']){

			if(trim($_POST['title'])==''){

				$this->ACT_layer_msg('规则名称不能为空！',8);

			}

			if(trim($_POST['keyword'])==''){

				$this->ACT_layer_msg('关键字不能为空！',8);

			}

			if(trim($_POST['content'])==''){

				$this->ACT_layer_msg('回复内容不能为空！',8);

			}

			$data['title']		=	trim($_POST['title']);

			$data['keyword']	=	trim($_POST['keyword']);

			$data['content']	=	trim($_POST['content']);

			$data['time']		=	time();

			$weiXinM->addWxzdkeyword($data);

			$this->ACT_layer_msg('添加成功！',9,'index.php?m=wx&c=zdkeyword',2,1);
		}

		if($_POST['update']){

			$data['title']		=	trim($_POST['title']);

			$data['keyword']	=	trim($_POST['keyword']);

			$data['content']	=	trim($_POST['content']);

			$data['time']		=	time();

			$zdWhere['id']		=	$_POST['id'];

			$weiXinM->upWxzdkeyword($zdWhere,$data);

		    $this->ACT_layer_msg('修改成功！',9,'index.php?m=wx&c=zdkeyword',2,1);

		}

		$this->yuntpl(array('admin/admin_zdaddkeyword'));
	}

	function delkeyword_action(){

		//实例化
		$weiXinM	=	$this->MODEL('weixin');

		if(is_array($_POST['del'])){

			$where['id']	=	array('in',pylode(',',$_POST['del']));

			$del			=	$weiXinM->delWxzdkeyword($where,array('type'=>'all'));

			$layer_type		=	1;

			$delid			=	pylode(',',$_POST['del']);

		}else{

			$this->check_token();

			$where['id']	=	(int)$_GET['id'];

			$del			=	$weiXinM->delWxzdkeyword($where,array('type'=>'one'));

			$layer_type		=	0;

			$delid			=	(int)$_GET['id'];
		}

		if(!$delid){

			$this->layer_msg('请选择要删除的内容！',8);

		}

		$del?$this->layer_msg('(ID:'.$delid.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);
	}
	/**
	 * 微信发布工具
	 */
	function pubtool_action(){
		
		$wxpubtempM		=	$this->MODEL('wxpubtemp');
		$temps = $wxpubtempM->getTempList(array('orderby'=>'id,desc'),array('field'=>'`id`,`title`,`type`,`temptype`'));
		foreach ($temps as $key => $value) {
			if($value['type']=='onejob'){
				$temps[$key]['type'] = 'job';
			}
		}
		$this->yunset('temps',$temps);

		$CacheM		=	$this->MODEL('cache');
        $CacheList	=	$CacheM->GetCache(array('hy','job','city','user','domain'));

		//会员等级
		$ratingM	=	$this -> MODEL('rating');

		$ratingList	=	$ratingM -> getList(array('category'=>1,'orderby'=>'sort,asc'),array('field'=>"`id`,`name`"));

		$this->yunset('rating',$ratingList);


		$this->yunset('userdata',$CacheList['userdata']);

        $this->yunset('cache',$CacheList);

        $this->yunset('userclass_name',$CacheList['userclass_name']);

		$this->yunset('domain',$CacheList['Dname']);
		
	    $this->yuntpl(array('admin/admin_wxpubtool'));
	}
	
	function wxPubTempList_action(){
		
		$search_list    =   array();
        $search_list[]  =   array('param'=>'type','name'=>'模板类型','value'=>array('job'=>'职位','resume'=>'简历','company'=>'企业'));
        
		$this->yunset('search_list',$search_list);

 		if($_GET['keyword']){
		    
            $keyword        =   trim($_GET['keyword']);
		    $where['title'] = array('like',$keyword);
            $urlarr['keyword']   =   $keyword;
		}
		if($_GET['type']){
		    
            $where['type']         =   $_GET['type'];
		    
            $urlarr['type']        =   $_GET['type'];
		}

		if(isset($_GET['temptype'])){
		    
            $where['temptype']         =   $_GET['temptype'];
		    
            $urlarr['temptype']        =   $_GET['temptype'];
		}
		$urlarr        	=   $_GET;
		$urlarr['page'] =   "{{page}}";
	    $urlarr['c']	=	$_GET['c'];
        $pageurl        =   Url($_GET['m'], $urlarr, 'admin');
	    
        //提取分页
        $pageM          =	$this  -> MODEL('page');
        $pages          =	$pageM -> pageList('wxpub_temps', $where, $pageurl, $_GET['page'],20);
        
        if($pages['total'] > 0){
            
            $field  =  '*,CASE WHEN `type`="job" THEN 1';
            $field  .=  ' WHEN `type`="company" THEN 2';
	        $field  .=  ' WHEN `type`="resume" THEN 3 END AS `type_px`';

	        $where['orderby']		=	array('type_px,asc','id,desc');

            $where['limit']         =	$pages['limit'];
			$wxpubtempM		=	$this->MODEL('wxpubtemp');
			$temps = $wxpubtempM->getTempList($where,array('field'=>$field));
			$this->yunset('rows',$temps);
		}
		

		$this->yuntpl(array('admin/admin_wxpubtemplist'));
		
		
	}
	function wxPubTemp_action(){
		
		if($_GET['id']){

			$wxpubtempM	=	$this->MODEL('wxpubtemp');

			$temp 		= 	$wxpubtempM->getTemp(array('id'=>$_GET['id']));

			if($temp['type']=='onejob'){
				$temp['type'] = 'job';
			}

			$selfcolumn	=	'pubtoolself_'.$temp['type'].'column';

			$typecolumn = 	array_merge($this->$selfcolumn,$this->pubtoolself_publiccolumn,$this->pubtoolself_totalcolumn);
			$temptype 	= 	$temp['temptype'];

			$temp['header'] = str_replace('{admin_style}',$this->config['sy_weburl']."/app/template/admin", $temp['header']);
			$temp['body'] = str_replace('{admin_style}',$this->config['sy_weburl']."/app/template/admin", $temp['body']);
			$temp['footer'] = str_replace('{admin_style}',$this->config['sy_weburl']."/app/template/admin", $temp['footer']);

			$temp['header'] = preg_replace('#\{yun:\}(.*?)\{\/yun\}#i','',$temp['header']);
			$temp['body'] = preg_replace('#\{yun:\}(.*?)\{\/yun\}#i','',$temp['body']);
			$temp['footer'] = preg_replace('#\{yun:\}(.*?)\{\/yun\}#i','',$temp['footer']);

			$this->yunset('info',$temp);
		}else{
			$temptype 	= 	$_GET['temptype'];
			
			$typecolumn = 	array_merge($this->pubtoolself_jobcolumn,$this->pubtoolself_resumecolumn,$this->pubtoolself_companycolumn,$this->pubtoolself_publiccolumn,$this->pubtoolself_totalcolumn);
		}
		if($temptype=='1'){
			foreach ($typecolumn as $tk => $tv) {
				if(strpos($tv[1],'img_')!== false || strpos($tv[1],'H5xcx_')!== false){

					unset($typecolumn[$tk]);
				}
			}
		}
		

		$this->yunset('temptype',$temptype);
		
		$this->yunset('typecolumn',$typecolumn);
		
		$this->yunset('jobcolumn_map',$this->pubtoolself_jobcolumn_map);
		$this->yunset('resumecolumn_map',$this->pubtoolself_resumecolumn_map);
		$this->yunset('companycolumn_map',$this->pubtoolself_companycolumn_map);
		$this->yunset('publiccolumn_map',$this->pubtoolself_publiccolumn_map);

		$this->yunset('totalcolumn',$this->pubtoolself_totalcolumn);
		$this->yunset('totalcolumn_map',$this->pubtoolself_totalcolumn_map);
		
		$this->yuntpl(array('admin/admin_wxpubtemp'));
	}
	
	function wxPubTempSave_action(){
		
		$whereData = array();

		$_POST['header'] = $this->downloadWxPic($_POST['header']);

		$_POST['body'] = $this->downloadWxPic($_POST['body']);
		$_POST['footer'] = $this->downloadWxPic($_POST['footer']);

		$rep_arr = array($this->config['sy_weburl']."/app/template/admin",'http://www.yunjob.com/app/template/admin');
		$_POST['header'] = str_replace($rep_arr,'{admin_style}', $_POST['header']);
		$_POST['body'] = str_replace($rep_arr,'{admin_style}', $_POST['body']);
		$_POST['footer'] = str_replace($rep_arr,'{admin_style}', $_POST['footer']);

		

		$wxpubtempM = $this->MODEL('wxpubtemp');
		
		$fwhere = array();
		$fwhere['title'] = $_POST['title'];

		if($_POST['id']){
			$tempinfo = $wxpubtempM->getTemp(array('id'=>$_POST['id']));
			$whereData['id'] = $_POST['id'];
			$fwhere['id'] = array('<>',$_POST['id']);
		}

		

		$temp = $wxpubtempM->getTemp($fwhere);

		$updata	   = array(
			'title'	=>	$_POST['title'],
			'header'=>	preg_replace('#\{yun:\}(.*?)\{\/yun\}#i','',$_POST['header']),
			'body'	=>	preg_replace('#\{yun:\}(.*?)\{\/yun\}#i','',$_POST['body']),
			'footer'=>	preg_replace('#\{yun:\}(.*?)\{\/yun\}#i','',$_POST['footer']),
			'type'	=>	$tempinfo['type']=='onejob' ? 'onejob' : $_POST['type'],
			'temptype'	=>	$_POST['temptype'],
			'time'	=>	time()
		);
		
		if($temp){
			$return['msg'] = '该模板名称已使用，请重新命名';
			$return['errcode'] = 8;
		}else{
			$return = $wxpubtempM->setTemp($updata,$whereData);
		}

		$this -> layer_msg($return['msg'],$return['errcode']);
		
	}
	
	
	private function downloadWxPic($str){

		$str = stripslashes($str);
		//来源自公众号的图片，且非svg类型的，下载
		if(strpos($str,'mmbiz.qpic.cn')!==false && strpos($str,'mmbiz_svg')===false){

			$preg = '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i';
			preg_match_all($preg, $str, $img);
			
			$imgArr = array_unique($img[1]);

			//自定义目录名称
		    $dirName = APP_PATH . 'data/upload/wx/' . date('Ymd');

		    include_once(LIB_PATH.'upload.class.php');
		    $upload =   new Upload();

			if ($this->config['sy_oss'] == 1){
			    include_once(LIB_PATH.'oss/ossupload.class.php');
                $ossUpload  =  new ossUpload();
            }

			foreach ($imgArr as $ik => $iv) {

				if(strpos($iv,'mmbiz.qpic.cn')!==false){

					$iv_arr = explode('?', $iv);

					$CurlReturn = CurlGet($iv_arr[0]);
					print_r($CurlReturn);die;
					if($CurlReturn){
		               // 重新定义文件名称 图片一律用 jpeg
		                $filename  =  time().rand(1000,9999).'.jpeg';
		                
		                if (!file_exists($dirName)){
		                    mkdir($dirName, 0777, true);
		                }
		                //对原图进行强制压缩 防止非法图片上传
		                $pic = $dirName . '/' . $filename;

		                $ires=file_put_contents($pic, $CurlReturn);
		                
		                $picUrl =   str_replace(APP_PATH.'data', './data', $pic);
		               
		                if ($this->config['sy_oss'] == 1){

		                	$return = $ossUpload->uploadLocalImg(realpath($pic));

		                	$picUrl = $return['picurl'];
		                }

		                if($picUrl){
		                	$picUrl = checkpic($picUrl);
		                	$str = str_replace($iv,$picUrl,$str);
		                }
		            }
				}
			}

		}
		
		return $str;
		
	}
	function wxPubTempDel_action(){

		if($_GET['del'])
		{
			$this->check_token();
			
			$wxpubtempM = $this->MODEL('wxpubtemp');
			
			$return		=	$wxpubtempM->delTemp($_GET['del']);
			
			$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('请选择要删除的内容！',8);
		}
	}
	//微信发布工具信息
	function Getpubtool_action(){
		$get = $_POST;
		//查询类型 0职位列表1简历列表2企业列表
		$type = $get['type'];
		
		@include(DATA_PATH.'api/wxpay/wxpay_data.php');
        
        $this->yunset('wxpaydata',$wxpaydata);

		switch ($type) {
			case '1':
				$this->Getjob($get);
				break;
			case '2':
				$this->Getresume($get);
				break;
			case '3':
				$this->Getcompany($get);
				break;
			default:
				echo "暂无信息";
				break;
		}
	}

	/**
	 * 微信模板消息通知列表
	 */
	function wxmsglist_action(){

		$weixinM	=	$this->MODEL('weixin');

		if($_GET['keyword']){

			$keyword	=	trim($_GET['keyword']);

			$type		=	intval($_GET['type']);

			$uids		=	array();

			if($type==99){

				$mwhere['username']	=	array('like',$keyword);
				$adminM 			=	$this->MODEL('admin');
				$ulist				=	$adminM	->	getList($mwhere);
				foreach($ulist	as $uk=>$uv){
				    
				    if($uv['uid']){
				        
				        $uids[] 		=	$uv['uid'];
				    }
				}
				
				$where['utype']			=	$type;
				
				$where['uid']			=	array('in',pylode(',',$uids));
			}else{

				if (in_array($type, array(1,2,3,4))){
				    // 搜姓名、企业名称
				    $UserinfoM			=	$this->MODEL('userinfo');
				    $marr               =   array(
				        1 => array('name' =>  array('like', $keyword)),
				        2 => array('name' =>  array('like', $keyword)),
				        3 => array('realname' =>  array('like', $keyword)),
				        4 => array('name' =>  array('like', $keyword))
				    );
				    $ulist              =	$UserinfoM -> getUserInfoList($marr[$type], array('usertype'=>$type,'field'=>'uid'));
				    
				    foreach($ulist	as $uk=>$uv){
				        if($uv['uid']){
				            $uids[] 	=	$uv['uid'];
				        }
				    }
				    $where['utype']		=	$type;
				    $where['uid']		=	array('in', pylode(',',$uids));
				    
				}elseif ($type == 90){
				    // 搜用户UID
				    $where['utype']		=	$type;
				    
				    $where['uid']		=	$keyword;
				}
			}

			$urlarr['type']		=	"".$type."";

			$urlarr['keyword']  =	"".$keyword."";
		}
		if(($_GET['date'])){

			$times=@explode('~',$_GET['date']);

			$where['ctime'][]	=	array('>=',strtotime($times[0]." 00:00:00"));

			$where['ctime'][]	=	array('<',strtotime($times[1]." 23:59:59"));

			$urlarr['date']		=	$_GET['date'];
		}
		$urlarr        	=   $_GET;
		$urlarr['page']	=	"{{page}}";
		$urlarr['c']	=	"wxmsglist";

		$pageurl		=	Url($_GET['m'],$urlarr,'admin');

		$pageM			=	$this  -> MODEL('page');

		$pages			=	$pageM -> pageList('wx_msg',$where,$pageurl,$_GET['page']);

		//分页数大于0的情况下 执行列表查询

		if($pages['total'] > 0){

			if($_GET['order'])
			{
				$where['orderby']	=	$_GET['t'].','.$_GET['order'];

				$urlarr['order']	=	$_GET['order'];

				$urlarr['t']		=	$_GET['t'];
			}else{

				$where['orderby']	=	'id';
			}

			$where['limit']	=	$pages['limit'];

			$wxmsgList		=	$weixinM -> getWxmsgList($where);


		}

		$this->yunset('rows',$wxmsgList);

		$this->yuntpl(array('admin/admin_wxmsglist'));
	}

	function delmsg_action(){

		$weixinM	=	$this -> Model('weixin');

		if(is_array($_POST['del'])){

			$delid		=	@implode(',',$_POST['del']);

			$layer_type	=	1;
		}else{
			$this -> check_token();

			$delid		=	(int)$_GET['id'];

			$layer_type	=	0;
		}

		$where['id']	=	array('in',$delid);

		$del	=	$weixinM -> delWxmsg(array('where'=>$where));

		$del?$this -> layer_msg('微信通知消息(ID:'.$delid.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']):$this -> layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);

	}
	/**
	 * 微信模板消息通知列表
	 */
	function qywxMsgList_action(){

		$weixinM	=	$this->MODEL('weixin');

		if($_GET['keyword']){

			$keyword	=	trim($_GET['keyword']);

			$type		=	intval($_GET['type']);

			

			if($type==1){

				$uids		=	array();

				$mwhere['username']	=	array('like',$keyword);
				$adminM 			=	$this->MODEL('admin');
				$ulist				=	$adminM	->	getList($mwhere);

				foreach($ulist	as $uk=>$uv){

					if($uv['uid']){

						$uids[] 	=	$uv['uid'];

					}

				}

				$where['uids']		=	array('findin',pylode(',',$uids));

			}else{

				$where['touser']	=	array('like',$keyword);

			}

			$urlarr['type']			=	"".$type."";

			$urlarr['keyword']		=	"".$keyword."";
		}
		if(($_GET['date'])){

			$times=@explode('~',$_GET['date']);

			$where['ctime'][]	=	array('>=',strtotime($times[0]." 00:00:00"));

			$where['ctime'][]	=	array('<',strtotime($times[1]." 23:59:59"));

			$urlarr['date']		=	$_GET['date'];
		}
		$urlarr        	=   $_GET;
		$urlarr['page']	=	"{{page}}";
		$urlarr['c']	=	$_GET['c'];

		$pageurl		=	Url($_GET['m'],$urlarr,'admin');

		$pageM			=	$this  -> MODEL('page');

		$pages			=	$pageM -> pageList('wx_qymsg',$where,$pageurl,$_GET['page']);

		//分页数大于0的情况下 执行列表查询

		if($pages['total'] > 0){

			if($_GET['order'])
			{
				$where['orderby']	=	$_GET['t'].','.$_GET['order'];

				$urlarr['order']	=	$_GET['order'];

				$urlarr['t']		=	$_GET['t'];
			}else{

				$where['orderby']	=	'id';
			}

			$where['limit']	=	$pages['limit'];

			$wxmsgList		=	$weixinM -> getQyWxmsgList($where);


		}

		$this->yunset('rows',$wxmsgList);

		$this->yuntpl(array('admin/admin_qywxmsglist'));
	}
	function delQymsg_action(){
		$weixinM	=	$this -> Model('weixin');

		if(is_array($_POST['del'])){

			$delid		=	@implode(',',$_POST['del']);

			$layer_type	=	1;
		}else{
			$this -> check_token();

			$delid		=	(int)$_GET['id'];

			$layer_type	=	0;
		}

		$where['id']	=	array('in',$delid);

		$del	=	$weixinM -> delQyWxmsg(array('where'=>$where));

		$del?$this -> layer_msg('微信通知消息(ID:'.$delid.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']):$this -> layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);
	}

	//职位列表
	protected function Getjob($GET){

		$jobM  = $this->MODEL('job');
		$time  = time();
		$where = array();
		$data  = array();

		if($GET['param'] != ''){
			$param = explode(',',$GET['param']);
			//置顶
			if(in_array('0',$param)){
				$where['xsdate'] = array('>',$time);
			}
			//紧急
			if(in_array('1',$param)){
				$where['urgent_time'] = array('>',$time);
			}
			//推荐
			if(in_array('2',$param)){
				$where['rec_time'] = array('>',$time);
			}
		}
		
		if($GET['rating'] != ''){

			$rating = pylode(',',$GET['rating']);
			
			$where['rating'] = array('in',$rating);
			
		}
        //地点
        if($GET['provinceid'] != ''){
            $where['provinceid'] = $GET['provinceid'];
            if($GET['cityid'] != ''){
                $where['cityid'] = $GET['cityid'];
                if($GET['three_cityid'] != ''){
                    $where['three_cityid'] = $GET['three_cityid'];
                }
            }
        }

        //职位类别
        if($GET['job1'] != ''){
            $where['job1']     = $GET['job1'];
            if($GET['job1_son'] != ''){
                $where['job1_son'] = $GET['job1_son'];
                if($GET['job_post'] != ''){
                    $where['job_post'] = $GET['job_post'];
                }
            }
        }
        //薪资待遇
        if($GET['minsalary'] != '' && $GET['maxsalary'] == ''){
            $where['minsalary'] = array('>', $GET['minsalary']);

        }elseif ($GET['minsalary'] == '' && $GET['maxsalary'] != ''){
            $where['maxsalary'] = array('<', $GET['maxsalary']);

        }elseif ($GET['minsalary'] != '' && $GET['maxsalary'] != ''){
            $where['minsalary'] = array('>', $GET['minsalary']);
            $where['maxsalary'] = array('<', $GET['maxsalary']);
        }


		//职位更新时间
		if($GET['times'] != '0'){
			$times = $GET['times'];
			if($times  ==  '1'){
                $where['lastupdate'] = array('>',strtotime(date('Y-m-d 00:00:00')));
            }else{
                $where['lastupdate'] = array('>',strtotime('-'.intval($times).' day'));
            }
		}

        //职位发布时间
        if($GET['ftimes'] != '0'){
            $times = $GET['ftimes'];
            if($times  ==  '1'){
                $where['sdate'] = array('>',strtotime(date('Y-m-d 00:00:00')));
            }else{
                $where['sdate'] = array('>',strtotime('-'.intval($times).' day'));
            }
        }

		//指定职位id
		if($GET['jobcopos'] != ''){
			$where['id'] = array('in',str_replace('，',',',$GET['jobcopos']));
		}

		//职位展示限制
		if($GET['rule'] != '0'){
			$data['rule'] = $GET['rule'];
		}

		//关键词
		if($GET['keyword'] != ''){
			$GET['keyword'] = trim($GET['keyword']);
			$where['PHPYUNBTWSTART']  =  '';
			$where['com_name'] = array('like',$GET['keyword'],'or');
			$where['name'] = array('like',$GET['keyword'],'or');
			$where['PHPYUNBTWEND']    =  '';
		}
		//福利待遇
		if($GET['welfare'] != ''){
			$GET['welfare'] = trim($GET['welfare']);

			if(strpos($GET['welfare'],'|')!==false){

				$welfare = explode('|',$GET['welfare']);
				if(!empty($welfare)){
					$where['PHPYUNBTWSTART']  =  '';
					foreach($welfare as $key=>$value){

						$where['welfare'][] = array('like',trim($value),'OR');
					}
					$where['PHPYUNBTWEND']    =  '';
				}
			}elseif(strpos($GET['welfare']," ")!==false){
				$welfare = explode(' ',$GET['welfare']);
				if(!empty($welfare)){
					$where['PHPYUNBTWSTART']  =  '';
					foreach($welfare as $key=>$value){

						$where['welfare'][] = array('like',trim($value),'AND');
					}
					$where['PHPYUNBTWEND']    =  '';
				}
			
			}else{
				$where['welfare'] = array('like',$GET['welfare'],'OR');
			}
			
		}

		//信息数量
		$num                =   $GET['num'];
		$where['limit']	    =   $num;
		
		$where['state']		=   '1';
		$where['r_status']	=   '1';
		$where['status']	=   '0';

		$where['orderby']	=	'lastupdate,desc';
		$lists = $jobM->Getpubtool($where,$data);
		$this->yunset('lists',$lists);
		$this->yunset('ewmtype',$GET['ewmtype']);
		//风格模板
		
		
		$res = $this->mk_temp($GET['tpl']);
		if($res){
			$this->yuntpl(array($res));
		}
			

	}
	
	//简历列表
	protected function Getresume($GET){
		$resumeM = $this->MODEL('resume');
		$time = time();
		$where = array();
		
	
		//简历类型
		if($GET['cvkind'] != ''){
			//置顶
		    $where['top'] 		  =  1;
		    $where['topdate']	  =  array('>',$time);
		}

		//意向职位
		if($GET['ideapos'] != ''){
			$where['name'] = array('like',$GET['ideapos']);
		}

		//意向地区
		if($GET['ideaarea'] != ''){

			$CacheM		=	$this->MODEL('cache');
            $CacheList	=	$CacheM->GetCache(array('city'));

            $area   = array_flip($CacheList['city_name']);

            $areaid = $area[$GET['ideaarea']]?$area[$GET['ideaarea']]:0;

            $where['city_classid']   = array('like',$areaid);
		}

		//学历
		if($GET['bd'] != ''){
			$where['edu'] = array('in',$GET['bd']);
		}
        //简历发布时间
        if($GET['rtimes'] != '0'){
            $times = $GET['rtimes'];
            if($times  ==  '1'){
                $where['ctime'] = array('>',strtotime(date('Y-m-d 00:00:00')));
            }else{
                $where['ctime'] = array('>',strtotime('-'.intval($times).' day'));
            }
        }

        //简历刷新时间
        if($GET['rltimes'] != '0'){
            $times = $GET['rltimes'];
            if($times  ==  '1'){
                $where['lastupdate'] = array('>',strtotime(date('Y-m-d 00:00:00')));
            }else{
                $where['lastupdate'] = array('>',strtotime('-'.intval($times).' day'));
            }
        }
		//经验
		if($GET['exp'] != ''){
			$where['exp'] = array('in',$GET['exp']);
		}

		//简历完整度
		$whole = $GET['whole'];//0 40%   1 60%   2 80%
		if($whole== 0){
	        $where['PHPYUNBTWSTART']   =   '';
	        $where['integrity'][]	=	array('>=', '40','AND');
	        $where['integrity'][]	=	array('<','60','AND');
	        $where['PHPYUNBTWEND']     =   '';
	    }elseif($whole== 1){
	        $where['PHPYUNBTWSTART']   =   '';
	        $where['integrity'][]	=	array('>=', '60', 'AND');
	        $where['integrity'][]	=	array('<','80','AND');
	        $where['PHPYUNBTWEND']     =   '';
	    }elseif($whole== 2){
	        $where['PHPYUNBTWSTART']   =   '';
	        $where['integrity'][]	=	array('>=', '80', 'AND');
	        $where['integrity'][]	=	array('<=','100','AND');
	        $where['PHPYUNBTWEND']     =   '';
	    }

		//信息数量
		$num = $GET['num'];
		$where['limit']	= $num;


		$where['defaults'] = 1;
		$where['state']    = 1;
		$where['status']   = 1;
		$where['r_status'] = 1;
		$where['orderby'] = "lastupdate,desc";
		$lists = $resumeM->Getresume($where,$data);
		
		$this->yunset('lists',$lists);
		$this->yunset('ewmtype',$GET['ewmtype']);
		//风格模板

		$res = $this->mk_temp($GET['tpl']);
		if($res){
			$this->yuntpl(array($res));
		}
	
	}
	//企业列表
	protected function Getcompany($GET){
		global $db_config;
		$companyM = $this->MODEL('company');
		$data  = array();
		$time  = time();

		$where = ' a.`r_status`=1 AND a.`name`<>\'\'';

		if($GET['rating'] != ''){

			$rating = pylode(',',$GET['rating']);
			$where	.= " AND a.`rating` in (".$rating.")";
			
		}

		$data['jWhere']['r_status'] =   1;
        $data['jWhere']['status']   =   0;
        $data['jWhere']['state']    =   1;
        $data['jWhere']['orderby']	=	"lastupdate,desc";
		$jwhere = ' AND b.`r_status`=1 AND b.`status`=0 AND b.`state`=1';
		//职位参数 0置顶 1紧急 2推荐
		if($GET['param'] != ''){
			$param = explode(',',$GET['param']);
			//置顶
			if(in_array('0',$param)){
				$data['jWhere']['xsdate'] = array('>',$time);
				$jwhere .= ' AND b.`xsdate`>'.$time;
			}
			//紧急
			if(in_array('1',$param)){
				$data['jWhere']['urgent_time'] = array('>',$time);
				$jwhere .= ' AND b.`urgent_time`>'.$time;
			}
			//推荐
			if(in_array('2',$param)){
				$data['jWhere']['rec_time'] = array('>',$time);
				$jwhere .= ' AND b.`rec_time`>'.$time;
			}
		}
		if($GET['rule']){
			$data['jWhere']['limit'] = $GET['rule'];
		}


		//站点
		if($GET['did'] != ''){
			$where	.= ' AND a.`did`='.$GET['did'];
		}
        //套餐开通时间
        if($GET['vtimes'] != '0'){
            $times = $GET['vtimes'];
            if($times  ==  '1'){

                $where	.= ' AND a.`vipstime`>"'.strtotime(date('Y-m-d 00:00:00')).'"';

            }else{

                $where	.= ' AND  a.`vipstime`>"'.strtotime('-'.intval($times).' day').'"';
            }
        }
		//企业类型
		if($GET['bekind'] != ''){
			$where	.= ' AND a.`rec`=1 AND a.`hotstart`<="'.$time.'" AND a.`hottime`>"'.$time.'"';
		}
        //地点
        if($GET['provinceid'] != ''){
            $where	.= ' AND a.`provinceid`='.$GET['provinceid'];
            if($GET['cityid'] != ''){
                $where	.= ' AND a.`cityid`='.$GET['cityid'];
                if($GET['three_cityid'] != ''){
                    $where	.= ' AND a.`three_cityid`='.$GET['three_cityid'];
                }
            }
        }
        //行业
        if($GET['hy'] != ''){
            $where	.= ' AND a.`hy`='.$GET['hy'];
        }

		//指定企业职位 企业ID
		if($GET['copos'] != ''){
            $where	.= " AND a.`uid` in (".str_replace('，',',',$GET['copos']).")";
		}

		//关键词
		if($GET['keyword'] != ''){
			$where	.= ' AND a.`name` LIKE "%'.$GET['keyword'].'%"';
		}

		//信息数量
		$num = $GET['num'];

        $orderby	= ' ORDER BY maxup DESC';

        $sql ="SELECT a.uid,a.name,a.address,a.linkman,a.linktel,a.welfare, MAX(b.lastupdate) as maxup FROM $db_config[def]company a LEFT JOIN $db_config[def]company_job b ON a.`uid` = b.`uid` WHERE ".$where.$jwhere."  GROUP BY a.`uid` ".$orderby." limit ".$num;

        $lists = $companyM->Getcompany($sql,$data);

		$this->yunset('lists',$lists);
		
		$this->yunset('ewmtype',$GET['ewmtype']);
		
		$res = $this->mk_temp($GET['tpl']);
		if($res){
			$this->yuntpl(array($res));
		}
	
		
	}
	protected function mk_temp($id,$data=array()){

		$tempath = '';

		if(empty($id)){
			return false;
		}
		$wxpubtempM	=	$this->MODEL('wxpubtemp');
		$temp = $wxpubtempM->getTemp(array('id'=>$id));
		
		if(empty($temp)){
		    return false;
		}

		if($temp['type']=='onejob'){
			$temp['type'] = 'job';
		}

		$temtype='pubtoolself_'.$temp['type'].'column_map';
		$tempmap = $this->$temtype;

		if(!empty($tempmap)){
			$search_arr = $replace_arr = array();

			$publiccolumn_map = $this->pubtoolself_publiccolumn_map;
			$totalcolumn_map = $this->pubtoolself_totalcolumn_map;

			$xcxurltype_v = $xcxurlid_v = $toc_v = $toa_v = $toid_v = $minipath ='';
			

			if($temp['type']=='resume'){

				$toc_v = 'resume';
				$toa_v = 'show';
				$toid_v = '$v.list.id';
				$minipath = '/pages/resume/show?id={yun:}$v.list.id{/yun}';

				$xcxurltype_v = 'resume';
				$xcxurlid_v = '$v.list.id';

			}else if($temp['type']=='job'){

				$toc_v = 'job';
				$toa_v = 'comapply';
				$toid_v = '$v.id';
				$minipath = '/pages/job/show?id={yun:}$v.id{/yun}';

				$xcxurltype_v = 'job';
				$xcxurlid_v = '$v.id';

			}else if($temp['type']=='company'){

				$toc_v = 'company';
				$toa_v = 'show';
				$toid_v = '$v.uid';
				$minipath = '/pages/company/show?id={yun:}$v.uid{/yun}';

				$xcxurltype_v = 'company';
				$xcxurlid_v = '$v.uid';
			}

			$param_s = array('toc_v','toa_v','toid_v','minipath','xcxurltype_v','xcxurlid_v');
			$param_v  = array($toc_v,$toa_v,$toid_v,$minipath,$xcxurltype_v,$xcxurlid_v);
			
			foreach ($publiccolumn_map as $pk => $pv) {
				$publiccolumn_map[$pk]['php'] = str_replace($param_s,$param_v,$pv['php']);
			}

			
			$tempmap = array_merge($tempmap,$publiccolumn_map,$totalcolumn_map);

			//正文中是否含有需要生成图片标签的参数，有的话生成标签和样式并加入待替换数组
			$result = array(); 
			preg_match_all('#\{(.*?)\}#i',$temp['body'], $result);

			$style_v='""';

			foreach ($result[1] as $key => $value) {

			    $img_arr	=	explode("|",$value);

			    if(count($img_arr)>1){

			    	$tempmap_key = '{'.$img_arr[0].'}';
				    $style_v	=	str_replace('样式=','', $img_arr[1]);
				    $style_v	=	str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $style_v);
				    //将{xxxx|样式=""}整体加入$tempmap
				    $tempmap['{'.$value.'}'] =	array(
			    		'php'=>str_replace('style_v',$style_v,$tempmap[$tempmap_key]['php'])
			    	);
				    
			    }
			}

			//正文中是否含有需要生成图片标签的参数，有的话生成标签和样式并替换end

			foreach ($totalcolumn_map as $totalk => $totalv) {
				
				$search_total_arr[] 	= $totalk;

				$replace_total_arr[] 	= $totalv['php'];
				
			}

			foreach ($tempmap as $key => $value) {
				
				$search_arr[] = $key;
				if(strpos($value['php'],'style_v')!==false){
					$replace_arr[] = str_replace('style_v',$style_v, $value['php']);
				}else{
					$replace_arr[] = $value['php'];
				}
				
			}

			$search_total_arr[] = '&amp;';
			$replace_total_arr[]= '&';
			$search_arr[] = '&amp;';
			$replace_arr[] = '&';

			$enter = '';
			if($temp['temptype']=='1'){
				$enter = "\r\n";
			}

			$html = 	'';
			$html .=	str_replace($search_total_arr, $replace_total_arr,$temp['header']);
			
			$html .= 	'{yun:}foreach item=v from=$lists{/yun}';
			$html .= 	str_replace($search_arr, $replace_arr,$temp['body']);
			$html .=	$enter;
			$html .= 	'{yun:}/foreach{/yun}';
			
			$html .=	str_replace($search_total_arr, $replace_total_arr,$temp['footer']);

			if ($temp['temptype']=='1' && !$data['notoBr']){
                $html = str_replace("\n","</br>",$html);
            }
	        

			if(!file_exists(DATA_PATH.'wxpubtpl')){
	            @mkdir(DATA_PATH.'wxpubtpl',0777,true);
	        }

			file_put_contents(DATA_PATH.'wxpubtpl/'.$temp['id'].'.htm',$html);
	        
	        $tempath = DATA_PATH.'wxpubtpl/'.$temp['id'];

	        
		}
		return $tempath;
		
	}
	function twTask_action(){
		
		$wxpubtempM		=	$this->MODEL('wxpubtemp');
		$where['status']	= 	0;
		if($_GET['keyword']){

			$keyword	=	trim($_GET['keyword']);
			$jobM		=	$this->MODEL('job');
            $jobid_arr = array();
            if(is_numeric($keyword)){
                $jobid_arr= array($keyword);
            }else {
                $jobwhere = array();
                $jobwhere['name'] = array('like', $keyword);
                $jobwhere['com_name'] = array('like', $keyword, 'or');
                if($_GET['welfarekeyword']){
                    $welfarekeyword = explode(' ',trim($_GET['welfarekeyword']));

                    $jobwhere['PHPYUNBTWSTART_A']  =   '';
                    foreach ($welfarekeyword as $k=>$v){
                        $jobwhere['welfare'][] = array('findin',$v);
                    }
                    $jobwhere['PHPYUNBTWEND_A']    =   '';
                    $urlarr['welfarekeyword']			=	$welfarekeyword;
                }
                $joblist = $jobM->getListId($jobwhere, array('field' => '`id`'));
                foreach ($joblist as $jk => $jv) {
                    $jobid_arr[] = $jv['id'];
                }
            }
            $where['PHPYUNBTWSTART_B']  =   '';
            $where['jobid'] = array('in', pylode(',', $jobid_arr));
            $where['content']			= 	array('like',$keyword,'or');
            $where['PHPYUNBTWEND_B']    =   '';
			$urlarr['keyword']			=	$keyword;
		}else{
            $jobM		=	$this->MODEL('job');
            $jobid_arr = array();
            if($_GET['welfarekeyword']){
                $welfarekeyword = explode(' ',trim($_GET['welfarekeyword']));

                $jobwhere['PHPYUNBTWSTART_A']  =   '';
                foreach ($welfarekeyword as $k=>$v){
                    $jobwhere['welfare'][] = array('findin',$v);
                }
                $jobwhere['PHPYUNBTWEND_A']    =   '';
                $joblist = $jobM->getListId($jobwhere, array('field' => '`id`'));

                foreach ($joblist as $jk => $jv) {
                    $jobid_arr[] = $jv['id'];
                }
                $where['jobid'] = array('in', pylode(',', $jobid_arr));
                $urlarr['welfarekeyword']			=	$welfarekeyword;
            }

        }

		if($_GET['auid']){
			$where['auid']	= 	$_GET['auid'];
			$urlarr['auid']	=	$_GET['auid'];
		}

		if($_GET['status']){
			$where['status']	= 	$_GET['status'];
			$urlarr['status']	=	$_GET['status'];
		}

		if($_GET['urgent']){
			$where['urgent']	= 	$_GET['urgent'];
			$urlarr['urgent']	=	$_GET['urgent'];
		}

		if($_GET['wcmoments']){
			$where['wcmoments']	= 	$_GET['wcmoments'];
			$urlarr['wcmoments']=	$_GET['wcmoments'];
		}
		$urlarr        	=   $_GET;
		$urlarr['page']	=	"{{page}}";
		$urlarr['c']	=	"twTask";

		$pageurl		=	Url($_GET['m'],$urlarr,'admin');

		$pageM			=	$this  -> MODEL('page');

		$pages			=	$pageM -> pageList('wxpub_twtask',$where,$pageurl,$_GET['page']);

		//分页数大于0的情况下 执行列表查询

		if($pages['total'] > 0){

			if($_GET['order'])
			{
				$where['orderby']	=	$_GET['t'].','.$_GET['order'];

				$urlarr['order']	=	$_GET['order'];

				$urlarr['t']		=	$_GET['t'];
			}else{

				$where['orderby']	=	'ctime';
			}

			$where['limit']	=	$pages['limit'];

			$twtasks		=	$wxpubtempM -> getTwTaskList($where);

		}

		$this->yunset('rows',$twtasks);

		$adminM            =  $this -> MODEL('admin');
	    $adminList	       =  $adminM -> getList(array('orderby'=>'uid'),array('field'=>'`uid`,`username`'));
	    $this->yunset('adminList',$adminList);

	    $tempWhere = array(
	    	'temptype'=>1,
	    	'orderby'=>'id,asc'
	    );
	    $tempWhere['PHPYUNBTWSTART_A']	=	'';
	    $tempWhere['type'][] = array('=','job');
	    $tempWhere['type'][] = array('=','onejob','or');
	    $tempWhere['PHPYUNBTWEND_A']	=	'';

	    $temps = $wxpubtempM->getTempList($tempWhere,'`id`,`title`');
        $temp2Where = array(
            'temptype'=>0,
            'type'=>'job',
            'orderby'=>'id,asc'
        );

        $temps2 = $wxpubtempM->getTempList($temp2Where,'`id`,`title`');
	    $this->yunset('temps',$temps);
	    $this->yunset('temps2',$temps2);

		$this->yuntpl(array('admin/admin_twtask'));
	}

	function delTwTask_action(){

		
		if($_GET['del'])
		{
			$this->check_token();
			
			$wxpubtempM = $this->MODEL('wxpubtemp');
			
			$return		=	$wxpubtempM->delTwtask($_GET['del']);
			
			$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('请选择要删除的内容！',8);
		}

	}
	
	function getTW_action(){

		$jobids = $_POST['jobids'];
		$tpl 	= $_POST['tpl'];

		$jobid_arr = !empty($jobids) ? explode(',',$jobids) : array();

		$jobid_arr = array_unique($jobid_arr);

		if(!empty($jobid_arr) && !empty($tpl)){
			$jobM  	= $this->MODEL('job');
			$time  	= time();
			$where 	= array();
			
			$where['id'] = array('in',pylode(',',$jobids));
			
			$lists = $jobM->Getpubtool($where);

			$jobs = array();
			$joblists = array();
			foreach ($lists as $lk => $lv) {
				$jobs[$lv['id']] = $lv;
			}
			foreach ($jobid_arr as $jk => $jv) {
				$joblists[] = $jobs[$jv];
			}

			$this->yunset('lists',$joblists);
			
			$wxpubtempM	=	$this->MODEL('wxpubtemp');
			$temp = $wxpubtempM->getTemp(array('id'=>$tpl),array('field'=>'`id`,`temptype`'));
			$notoBr = $temp['temptype']==1 ? true : false;
			
			//风格模板
			$res = $this->mk_temp($tpl,array('notoBr'=>$notoBr));
			if($res){
				$this->yuntpl(array($res));
			}
		}
		
	}
	function taskFinish_action(){
		
		if($_POST['id']){
			$wxpubtempM = 	$this->MODEL('wxpubtemp');
			$return		=	$wxpubtempM->upTwtask(array('id'=>$_POST['id']),array('status'=>1));
			if($return){
				$this->layer_msg('操作成功',9,0,'',2,1);
			}else{
				$this->layer_msg('操作失败请重试',8,0,'',2,1);
			}
		}else{
			$this->layer_msg('参数错误请重试',8,0,'',2,1);
		}
	}
	
	//失败微信通知重发
	function msgrepeat_action(){
	    
	    if($_POST['id']){
	        
	        $wxM  =	 $this->MODEL('weixin');
	        $msg  =	 $wxM->msgrepeat($_POST['id']);
	        
	        echo $msg;
	    }else{
	        echo "请选择需要重发的通知！";
	    }
	}
}

?>