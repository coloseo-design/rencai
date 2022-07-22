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
class wxapp_model extends model{
	
    public function setConfig($data = array())
    {
        $config  =  $this -> select_all('app_config',array(),'`name`');
        
        foreach($config as $v){
            
            $allList[]  =  $v['name'];
            
        }
        
        foreach($data as $key=>$v){
            
            if(in_array($key,$allList)){
                
                $this->update_once('app_config',array('config'=>$v),array('name'=>$key));
                
            }else{
                
                $this->insert_into('app_config',array('name'=>$key,'config'=>$v));
            }
        }
        $this->makeConfig();
    }
    /**
     * 生成appp配置缓存
     */
    public function makeConfig()
    {
        $config  =  $this -> select_all('app_config',array());
       
        if(is_array($config)){
            foreach($config as $v){
                $configarr[$v['name']]	=	$v['config'];
            }
        }
        if(!empty($configarr)){
            made_web(DATA_PATH.'api/wxapp/app.config.php',ArrayToString($configarr),'appconfig');
        }
    }
    /**
     * 移动端自定义设置保存
     */
    public function saveTplApp($data){
        
        if(!empty($data)){
            
            $tList	=	$this->select_all("tplapp",array('type'=>'index'),'`name`');
            
            foreach($tList as $k=>$v){
                
                $nameList[$v['name']]	=	1;
            }
        }
        foreach ($data as $key=>$val){
            
            if(isset($nameList[$key]) && $nameList[$key]==1){
                
                $this->update_once("tplapp",array('config'=>$val),array('name'=>$key));
                
            }else{
                
                $this->insert_into("tplapp",array('name'=>$key,'config'=>$val,'type'=>'index'));
            }
        }
    }
    
    /**
     *
     */
    public function sortTplApp($data){
        
        if(!empty($data)){
            
            $num		=		$this->select_num("tplapp",array('name'=>'sort'));
            
            $sort		=		implode(',', $data);
            
            if($num){
                
                $nid	=		$this->update_once("tplapp",array('config'=>$sort),array('name'=>'sort'));
                
            }else{
                
                $nid	=		$this->insert_into("tplapp",array('name'=>'sort','config'=>$sort,'type'=>'index'));
                
            }
        }
        return	$nid;
    }
    /**
     *
     */
    public function getTplAppList($whereData){
        
        $List			=	array();
        
        if($whereData){
            
            $List		=	$this -> select_all('tplapp',$whereData);
        }
        return	$List;
    }
    /**
     *
     */
    public function getTplApp($whereData){
        
        $row  =  $this->select_once('tplapp',$whereData);
        return	$row;
    }
    /**
     *
     */
    public function delTplApp($type,$post){
        
        $tpltype 		= 	$this->getTplAppList(array('type'=>$type));
        
        foreach($tpltype as $k=>$v){
            
            if(!in_array($v['id'], $post)){
                $nid		=	$this->delete_all('tplapp',array('id'=>$v['id']));
            }
        }
        return	$nid;
    }
    
    /**
     *
     */
    public function saveAllTplApp($whereData,$data){
        
        if($data['name']!='' && $data['url']!=''){
            
            $value	=	array(
                'name'	=>	$data['name'],
                'url'	=>	$data['url'],
                'type'	=>	$data['type']
            );
            
            if ($data['display']){
                $value['display']  =  $data['display'];
            }
            if ($data['navsort']){
                $value['navsort']  =  $data['navsort'];
            }
            if ($data['desc']){
                $value['desc']	   =  $data['desc'];
            }
            if($data['pic']){
                $value['pic']	   =  $data['pic'];
            }
            if($whereData['id'] != ''){
                
                $nid  =	 $this -> update_once('tplapp',$value,$whereData);
                
            }else{
                
                $nid  =	 $this -> insert_into('tplapp',$value);
            }
        }
        return	$nid;
    }
    /**
     * 生成tplapp缓存
     */
    public function tplappCache($type = ''){
        // 清除生成缓存标记
        $this->delete_all('tplapp', array('name'=>'isnew'));
        
        $tplApp =   $this->getTplAppList(array('id' => array('>', 0)));
        
        if (is_array($tplApp)) {
            $index = $nav = $foot = array();
            foreach ($tplApp as $k => $v) {
                if ($v['type'] == 'index') {
                    if ($v['name'] == 'sort' && stripos($v['config'], 'login') == false) {
                        
                        $index[$v['name']]  =   'search,member,nav,navbig,notice,login,hotcom,ad,job,zph,article,jobclass,connect,foot';
                    } else {
                        
                        $index[$v['name']]  =   $v['config'];
                    }
                }
                if ($v['type'] == 'nav') {
                    
                    $nav[$k]['id']      =   $v['id'];
                    $nav[$k]['name']    =   $v['name'];
                    $nav[$k]['pic']     =   $v['pic'];
                    $nav[$k]['type']    =   $v['type'];
                    $nav[$k]['url']     =   $v['url'];
                    $nav[$k]['display'] =   $v['display'];
                    $nav[$k]['navsort'] =   $v['navsort'];
                }
                if ($v['type'] == 'navbig') {
                    
                    $navbig[$k]['id']       =   $v['id'];
                    $navbig[$k]['name']     =   $v['name'];
                    $navbig[$k]['desc']     =   $v['desc'];
                    $navbig[$k]['pic']      =   $v['pic'];
                    $navbig[$k]['type']     =   $v['type'];
                    $navbig[$k]['url']      =   $v['url'];
                    $navbig[$k]['display']  =   $v['display'];
                    $navbig[$k]['navsort']  =   $v['navsort'];
                }
                if ($v['type'] == 'foot') {
                    $foot[$k]['id']     =   $v['id'];
                    $foot[$k]['name']   =   $v['name'];
                    $foot[$k]['pic']    =   $v['pic'];
                    $foot[$k]['type']   =   $v['type'];
                    $foot[$k]['url']    =   $v['url'];
                }
            }
            if ($type == 'foot') {
                $index['footRand']  =   time();//如果更新的是uniapp底部导航，则生成时间戳缓存
            }
            
            $data['tplapp']     =   ArrayToString($index);
            $data['nav']        =   ArrayToString($nav);
            $data['navbig']     =   ArrayToString($navbig);
            $data['footnav']    =   ArrayToString($foot);
            made_web_array(DATA_PATH.'api/wxapp/tplapp.cache.php', $data);
        }
    }
    public function makeCache()
    {
        $config  =  array();
        include(DATA_PATH.'api/wxapp/app.config.php');
        if (empty($appconfig['sy_push_appid'])){
            if (!empty($this->config['sy_push_appid'])){
                
                $config['sy_push_appid']         =  $this->config['sy_push_appid'];
                $config['sy_push_appsecret']     =  $this->config['sy_push_appsecret'];
                $config['sy_push_appkey']        =  $this->config['sy_push_appkey'];
                $config['sy_push_masterSecret']  =  $this->config['sy_push_masterSecret'];
            }
        }
        include(DATA_PATH.'api/wxapp/app.config.php');
        if (empty($appconfig['apptitle'])){
            if (!empty($this->config['apptitle'])){
                
                $config['iosversion']      =  $this->config['iosversion'];
                $config['iosurl']          =  $this->config['iosurl'];
                $config['androidversion']  =  $this->config['androidversion'];
                $config['androidurl']      =  $this->config['androidurl'];
                $config['apptitle']        =  $this->config['apptitle'];
                $config['appcontent']      =  $this->config['appcontent'];
            }
        }
        if (!empty($config)){
            
            $this->setConfig($config);
        }
    }
    /**
     * 生成百度小程序所需缓存
     */
    public function makeBaiduCache(){
        
        if (!empty($this->config['sy_dealId']) && !empty($this->config['sy_appKey'])){
            // 生成百度小程序缓存
            $baidu  =  array(
                'sy_weburl'     =>  $this->config['sy_weburl'],
                'sy_appKey'     =>  $this->config['sy_appKey'],
                'sy_dealId'     =>  $this->config['sy_dealId'],
                'sy_privateKey' =>  $this->config['sy_privateKey'],
                'sy_publicKey'  =>  $this->config['sy_publicKey'],
                'sy_bdlogin_appKey'=> $this->config['sy_bdlogin_appKey'],
                'sy_bdlogin_appSecret'=>$this->config['sy_bdlogin_appSecret']
            );
            
            made_web(DATA_PATH.'api/baidu/baidu_data.php',ArrayToString($baidu),'baiduData');
        }
    }

    /**
     * 添加小程序seo
     * @param $data
     * @return array
     */
    public function addWxSeo($data){

        $nid    =   $this->insert_into('wxxcx_seo', $data);

        if ($nid) {
            // 生成缓存
            $this->makeWxSeoCache();

            $return =   array(
                'id'        =>  $nid,
                'errcode'   =>  9,
                'msg'       =>  '添加成功'
            );
        } else {

            $return =   array(
                'errcode'   =>  8,
                'msg'       =>  '添加失败'
            );
        }
        return $return;
    }

    /**
     * 修改小程序seo
     * @param array $where
     * @param $data
     * @return array
     */
    public function upWxSeo($where = array(), $data){
        
        if (!empty($where)){

            $nid    =   $this->update_once('wxxcx_seo', $data, $where);

            if ($nid) {

                // 生成缓存
                $this->makeWxSeoCache();

                $return =   array(
                    'errcode'   =>  9,
                    'msg'       =>  '修改成功'
                );
            } else {
                $return =   array(
                    'errcode'   =>  8,
                    'msg'       =>  '修改失败'
                );
            }
            return $return;
        }
    }

    /**
     * 获取小程序seo列表
     * @param array $where
     * @return array|bool|false|string|void
     */
    public function getWxSeo($where = array()){

        $seo = $this->select_once('wxxcx_seo', $where);

        if(!empty($seo)){
            if($seo['share_pic']){
                $seo['share_pic_n'] = checkpic($seo['share_pic']);
            }
        }
        return $seo;
    }

    /**
     * 获取小程序seo列表
     * @param array $where
     * @return array|bool|false|string|void
     */
    public function getWxSeoList($where = array()){

        return $this->select_all('wxxcx_seo', $where);
    }

    /**
     * 删除小程序SEO
     * @param $where
     * @return array
     */
    public function delWxSeo($where)
    {

        $res    =   $this->delete_all('wxxcx_seo', $where);

        if ($res) {
            // 生成缓存
            $this->makeWxSeoCache();
            $return =   array('msg' => 'SEO删除成功', 'errcode' => 9);
        } else {
            $return =   array('msg' => 'SEO删除失败', 'errcode' => 8);
        }
        return $return;
    }

    /**
     * 生成小程序SEO缓存
     */
    public function makeWxSeoCache()
    {

        $list   =   $this->select_all('wxxcx_seo');

        if (!empty($list)) {
            foreach ($list as $k => $v) {
                if (!empty($v['ident']) && !empty($v['title'])) {
                    $seo_index[$v["ident"]][$k]['title']      =   $v["title"];
                    $seo_index[$v["ident"]][$k]['share_pic']  =   $v["share_pic"];
                    $seo_index[$v["ident"]][$k]['keywords']   =   $v["keywords"];
                    $seo_index[$v["ident"]][$k]['description']=   $v["description"];
                }
            }
            if (isset($seo_index)){

                $data['seo']    =   ArrayToString($seo_index);
                made_web_array(DATA_PATH.'api/wxapp/wxseo.cache.php', $data);
            }
        }
    }
    /**
     * 生成字节跳动小程序所需缓存
     */
    public function makettCache(){
        
        if (!empty($this->config['sy_tt_appId']) && !empty($this->config['sy_tt_salt'])){
            
            $tt  =  array(
                'sy_weburl'    =>  $this->config['sy_weburl'],
                'sy_tt_appId'  =>  $this->config['sy_tt_appId'],
                'sy_tt_salt'   =>  $this->config['sy_tt_salt']
            );
            
            made_web(DATA_PATH.'api/bytedance/tt_data.php',ArrayToString($tt),'ttData');
        }
    }
}
?>