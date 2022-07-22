<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:37:48
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\wap\publichtm\search.htm" */ ?>
<?php /*%%SmartyHeaderCode:446162c549dc2e1699-39959818%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '89eb1cd87c05a3cb3b48c49a8f8930b3d027ccbc' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\wap\\publichtm\\search.htm',
      1 => 1634883852,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '446162c549dc2e1699-39959818',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config_wapdomain' => 0,
    'keylist' => 0,
    'key' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c549dc30a0b5_06435595',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c549dc30a0b5_06435595')) {function content_62c549dc30a0b5_06435595($_smarty_tpl) {?><div id="searchhtml" class="none">
    <!-- 头部 -->
    <div class="wap_search_header">
        <div class="wap_search_header_c">
			<div class="wap_search_headerqx" onclick="searchhtmlhide()"> </div>
            <form method="get" action="<?php echo $_smarty_tpl->tpl_vars['config_wapdomain']->value;?>
/index.php">
                <input type="hidden" id="type" name="c" value="<?php if ($_GET['c']) {
echo $_GET['c'];
} else { ?>job<?php }?>"/>
                <div class="wap_search_text">
                    <input type="text" value="" onkeyup="this.value = this.value.replace(/[,]/g,'');" id="input_search" name="keyword" class="" placeholder="请输入<?php if ($_GET['c']=='job'||!$_GET['c']) {?>职位名/公司名<?php } elseif ($_GET['c']=='resume') {?>关键字<?php }?>">
                    
                </div><div class="wap_search_hbth"><input type="submit" value="搜索" class=""></div>
            </form>
            
        </div>
    </div>
    <!-- 主体 -->
    <div class="Search_jobs_body">
        <div class="search_history_tit">
            <span class=" ">历史搜索</span>
            <span class="search_history_qc" style="display:none" id="clearhistory"></span>
        </div>
        <div class="" id="historylist">
            <div class="search_history_no">
                暂无搜索记录~
            </div>
        </div>
    </div>
    <div class="Search_jobs_body">
        <div class="search_history_tit">热门搜索</div>
        <div class="search_history_tag_box">

            <?php if ($_GET['c']=='job'||!$_GET['c']) {?>
                <?php  $_smarty_tpl->tpl_vars['keylist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['keylist']->_loop = false;
global $config;$paramer=array("limit"=>"12","recom"=>"1","type"=>"3","iswap"=>"1","item"=>"'keylist'","nocache"=>"")
;$list=array();
        
        $ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		//是否推荐
		if($paramer[recom]){
			$tuijian = 1;
		}
		//类别
		if($paramer[type]){
			$type = $paramer[type];
		}
		//查询条数
		if($paramer[limit]){
			$limit=$paramer[limit];
		}else{
			$limit=5;
		}
		include PLUS_PATH."/keyword.cache.php";
		if($paramer[iswap]){
			$wap = "/wap";
		}else{
			$index =1;
		}
		if(is_array($keyword)){
			if($paramer[iswap]){
				$i=0;
				foreach($keyword as $k=>$v){
					if($tuijian && $v[tuijian]!=1){
						continue;
					}
					if($type && $v[type]!=$type){
						continue;
					}

					$i++;
					if($v[type]=="1"){
						$v[url] = Url("wap",array("c"=>"once","keyword"=>$v['key_name']));
						$v[type_name]='店铺招聘';
					}elseif($v['type']=="13"){
						$v['url'] = Url("wap",array("c"=>"tiny","keyword"=>$v['key_name']));
						$v['type_name']='普工简历';
					}elseif($v[type]=="3"){
						$v[url] = Url("wap",array("c"=>"job","keyword"=>$v['key_name']));
						$v[type_name]='职位';
					}elseif($v['type']=="4"){
						$v['url'] = Url("wap",array("c"=>"company","keyword"=>$v['key_name']));
						$v['type_name']='公司';
					}elseif($v['type']=="5"){
						$v['url'] = Url("wap",array("c"=>"resume","keyword"=>$v['key_name']));
						$v['type_name']='人才';
					}
					$v['key_title']=$v['key_name'];
					if($v['color']){
						$v['key_name']="<font color='".$v['color']."'>".$v['key_name']."</font>";
					}
					$list[] = $v;
					if($i==$limit){
						break;
					}
				}
			}else{
				$i=0;
				foreach($keyword as $k=>$v){
					if($tuijian && $v['tuijian']!=1){
						continue;
					}
					if($type && $v['type']!=$type){
						continue;
					}
					$i++;
					if($v['type']=="1"){
						$v['url'] = Url("once",array("keyword"=>$v['key_name']));
						$v['type_name']='店铺招聘';
					}elseif($v['type']=="2"){
						$v['url'] = Url("part",array("keyword"=>$v['key_name']));
						$v['type_name']='兼职';
					}elseif($v['type']=="13"){
						$v['url'] = Url("tiny",array("keyword"=>$v['key_name']));
						$v['type_name']='普工简历';
					}elseif($v['type']=="3"){
						$v['url'] = Url("job",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='职位';
					}elseif($v['type']=="4"){
						$v['url'] = Url("company",array("keyword"=>$v['key_name']));
						$v['type_name']='公司';
					}elseif($v['type']=="5"){
						$v['url'] = Url("resume",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='人才';
					}elseif($v['type']=="6"){
						$v['url'] = Url("lietou",array("c"=>"service","keyword"=>$v['key_name']));
						$v['type_name']='猎头';
					}elseif($v['type']=="7"){
						$v['url'] = Url("lietou",array("c"=>"post","keyword"=>$v['key_name']));
						$v['type_name']='猎头职位';
					}else if($v['type']=="9"){
						$v['url'] = Url("train",array("c"=>"subject","keyword"=>$v['key_name']));
						$v['type_name']='培训课程';
					}else if($v['type']=="10"){
						$v['url'] = Url("train",array("c"=>"agency","keyword"=>$v['key_name']));
						$v['type_name']='培训机构';
					}else if($v['type']=="11"){
						$v['url'] = Url("train",array("c"=>"teacher","keyword"=>$v['key_name']));
						$v['type_name']='培训师';
					}else if($v['type']=="12"){
						$v['url'] = Url("ask",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='问答';
					}
					$v['key_title']=$v['key_name'];
					if($v['color']){
						$v['key_name']="<font color='".$v['color']."'>".$v['key_name']."</font>";
					}

					$list[] = $v;
					if($i==$limit){
						break;
					}
				}
			}
		}$list = $list; if (!is_array($list) && !is_object($list)) { settype($list, 'array');}
foreach ($list as $_smarty_tpl->tpl_vars['keylist']->key => $_smarty_tpl->tpl_vars['keylist']->value) {
$_smarty_tpl->tpl_vars['keylist']->_loop = true;
?>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['keylist']->value['url'];?>
" class="search_history_tag"><?php echo $_smarty_tpl->tpl_vars['keylist']->value['key_name'];?>
</a>
                <?php } ?>
            <?php } elseif ($_GET['c']=='resume') {?>
                <?php  $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['key']->_loop = false;
global $config;$paramer=array("limit"=>"12","recom"=>"1","type"=>"5","iswap"=>"1","item"=>"'key'","nocache"=>"")
;$list=array();
        
        $ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		//是否推荐
		if($paramer[recom]){
			$tuijian = 1;
		}
		//类别
		if($paramer[type]){
			$type = $paramer[type];
		}
		//查询条数
		if($paramer[limit]){
			$limit=$paramer[limit];
		}else{
			$limit=5;
		}
		include PLUS_PATH."/keyword.cache.php";
		if($paramer[iswap]){
			$wap = "/wap";
		}else{
			$index =1;
		}
		if(is_array($keyword)){
			if($paramer[iswap]){
				$i=0;
				foreach($keyword as $k=>$v){
					if($tuijian && $v[tuijian]!=1){
						continue;
					}
					if($type && $v[type]!=$type){
						continue;
					}

					$i++;
					if($v[type]=="1"){
						$v[url] = Url("wap",array("c"=>"once","keyword"=>$v['key_name']));
						$v[type_name]='店铺招聘';
					}elseif($v['type']=="13"){
						$v['url'] = Url("wap",array("c"=>"tiny","keyword"=>$v['key_name']));
						$v['type_name']='普工简历';
					}elseif($v[type]=="3"){
						$v[url] = Url("wap",array("c"=>"job","keyword"=>$v['key_name']));
						$v[type_name]='职位';
					}elseif($v['type']=="4"){
						$v['url'] = Url("wap",array("c"=>"company","keyword"=>$v['key_name']));
						$v['type_name']='公司';
					}elseif($v['type']=="5"){
						$v['url'] = Url("wap",array("c"=>"resume","keyword"=>$v['key_name']));
						$v['type_name']='人才';
					}
					$v['key_title']=$v['key_name'];
					if($v['color']){
						$v['key_name']="<font color='".$v['color']."'>".$v['key_name']."</font>";
					}
					$list[] = $v;
					if($i==$limit){
						break;
					}
				}
			}else{
				$i=0;
				foreach($keyword as $k=>$v){
					if($tuijian && $v['tuijian']!=1){
						continue;
					}
					if($type && $v['type']!=$type){
						continue;
					}
					$i++;
					if($v['type']=="1"){
						$v['url'] = Url("once",array("keyword"=>$v['key_name']));
						$v['type_name']='店铺招聘';
					}elseif($v['type']=="2"){
						$v['url'] = Url("part",array("keyword"=>$v['key_name']));
						$v['type_name']='兼职';
					}elseif($v['type']=="13"){
						$v['url'] = Url("tiny",array("keyword"=>$v['key_name']));
						$v['type_name']='普工简历';
					}elseif($v['type']=="3"){
						$v['url'] = Url("job",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='职位';
					}elseif($v['type']=="4"){
						$v['url'] = Url("company",array("keyword"=>$v['key_name']));
						$v['type_name']='公司';
					}elseif($v['type']=="5"){
						$v['url'] = Url("resume",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='人才';
					}elseif($v['type']=="6"){
						$v['url'] = Url("lietou",array("c"=>"service","keyword"=>$v['key_name']));
						$v['type_name']='猎头';
					}elseif($v['type']=="7"){
						$v['url'] = Url("lietou",array("c"=>"post","keyword"=>$v['key_name']));
						$v['type_name']='猎头职位';
					}else if($v['type']=="9"){
						$v['url'] = Url("train",array("c"=>"subject","keyword"=>$v['key_name']));
						$v['type_name']='培训课程';
					}else if($v['type']=="10"){
						$v['url'] = Url("train",array("c"=>"agency","keyword"=>$v['key_name']));
						$v['type_name']='培训机构';
					}else if($v['type']=="11"){
						$v['url'] = Url("train",array("c"=>"teacher","keyword"=>$v['key_name']));
						$v['type_name']='培训师';
					}else if($v['type']=="12"){
						$v['url'] = Url("ask",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='问答';
					}
					$v['key_title']=$v['key_name'];
					if($v['color']){
						$v['key_name']="<font color='".$v['color']."'>".$v['key_name']."</font>";
					}

					$list[] = $v;
					if($i==$limit){
						break;
					}
				}
			}
		}$list = $list; if (!is_array($list) && !is_object($list)) { settype($list, 'array');}
foreach ($list as $_smarty_tpl->tpl_vars['key']->key => $_smarty_tpl->tpl_vars['key']->value) {
$_smarty_tpl->tpl_vars['key']->_loop = true;
?>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['key']->value['url'];?>
" class="search_history_tag"><?php echo $_smarty_tpl->tpl_vars['key']->value['key_name'];?>
</a>
                <?php } ?>
            <?php }?>
        </div>
    </div>
</div>
<?php echo '<script'; ?>
>
    function clearhis(type) {
        $.post("index.php?c=search&a=del", {
            type: type
        }, function (data) {
            if (data) {
                showToast("历史已清除！", 2, function () {
                    window.location.href = data;
                })
                return false;
            } else {
                showToast("操作失败！");
                return false;
            }
        });
    }

    function searchhtmlhide() {
        $("#searchhtml").addClass('none');
        $("#app").removeClass('none');
    }

    $(document).ready(function () {
        $(".searchnew").on('click', function () {
            setTimeout(function () {
                $("#app").addClass('none');
                $("#searchhtml").removeClass('none');
            }, 400);
        })
        var type = $("#type").val();
        $.post("index.php?c=search&a=history", {
            type: type
        }, function (data) {

            if (data) {
                var data = eval('(' + data + ')');

                if (data.hisid) {
                    $("#clearhistory").html("<a href='javascript:void(0);' onclick=\"clearhis('" + data.hisid + "')\">清除历史</a>");
                    $("#clearhistory").show();
                }
                if (data.list) {
                    var html = '';
                    $.each(data.list, function () {
                        html += "<div class=\"search_history_tag\"> <a href=\"" + this.url + "\">" + this.key_name + "</a></div>";
                    });
                    $("#historylist").html(html);
                }
            }
        });
    });
<?php echo '</script'; ?>
><?php }} ?>
