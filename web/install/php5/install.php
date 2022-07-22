<?php
/*
 * $Author ：维特网络技术支持
 *
 * 官网: http://www.weitenet.com
 *
 * 技术电话：18668215192 技术微信：18668215192
 *
 * 【主营业务】网站建设、源码模板、服务器空间租售、网站维护、网站托管、网站优化、百度推广、自媒体营销、微信公众号分销商城、如有意向-联系我们。
 */
if(file_exists(APP_PATH."/data/phpyun.lock")){
	show_view('<div class="centent"><div class="step"><div class="server"><table width="100%"><tbody><tr><td class="td1" width="100">提示信息</td><td class="td1" width="200">&nbsp;</td><td class="td1">&nbsp;</td></tr><tr><td colspan="3" style="width:100%;">你已经安装过该人才系统，请删除phpyun_lock文件再安装！</td></tr></tbody></table></div></div></div>');
	exit ();
}
if(empty($_GET['step']))
	$_GET['step'] = 'start';
if ($_GET['step'] == 'start'){
	
	show_view('
<div class="main">
    <textarea class="pact" readonly="readonly">
        源码说明： 本系统为人才招聘系统VIP5.1最新版，带校园招聘、赏金职位、猎头招聘、CRM客户关系管理、远程培训、微信支付、微信红包、海报等功能。
	   
	   维特网络：【主营业务】网站建设、源码模板、服务器空间租售、网站维护、网站托管、网站优化、百度推广、自媒体营销、微信公众号分销商城、如有意向-联系我们。
	   
	   技术电话：18668215192 技术微信：18668215192
    </textarea>
</div>
<div class="bottom">
    <form action="" autocomplete="off" method="get">
        <input name="step" value="checkset" type="hidden">
        <input type="submit" value="我同意" name="" class="submit">
        <input type="button" value="我不同意" onclick="window.close();" name="exit"class="submit">
    </form>
</div>');
}elseif ($_GET['step'] == 'checkset') {
	function_check($func_items);
	env_check($env_items);
	dirfile_check($dirfile_items);
	echo(show_env_result($env_items, $dirfile_items, $func_items));
}
elseif ($_GET['step'] == 'sql') {
	$protocol = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
    $url_this = $protocol . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"];
	$url_this = explode('/install/', $url_this);
	$url_this = $url_this[0];

	$form_str ='<div class="step">
    <ul>
        <li class="on">
            <em>
                1
            </em>
            检测环境
        </li>
        <li class="current">
            <em>
                2
            </em>
            创建数据
        </li>
        <li>
            <em>
                3
            </em>
            完成安装
        </li>
    </ul>
    <div class="server">
        <form id="install" method="post" name="frm_sql" action="index.php?step=data"onsubmit="return checkweb();">
            <table width="100%">
                <tbody>
                    <tr>
                        <td class="td1" width="100">
                            数据库信息
                        </td>
                        <td class="td1" width="200">
                            &nbsp;
                        </td>
                        <td class="td1">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td class="tar">
                            网站地址：
                        </td>
                        <td>
                            <input class="input" type="text" value="'.$url_this.'" name="weburl">
                        </td>
                        <td>
                            <span class="gray" id="weburl_msg">
                                站点的url
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="tar">
                            数据库服务器：
                        </td>
                        <td>
                            <input class="input" name="dbhost" type="text" value="127.0.0.1">
                        </td>
                        <td>
                            <span class="gray" id="dbhost_msg">
                                数据库服务器地址，一般为127.0.0.1
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="tar">
                            数据库用户名：
                        </td>
                        <td>
                            <input class="input" name="dbuser" type="text" value="root">
                        </td>
                        <td>
                            <span class="gray" id="dbuser_msg">
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="tar">
                            数据库密码：
                        </td>
                        <td>
                            <input class="input" name="dbpwd" type="text" value="">
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td class="tar">
                            数据库名：
                        </td>
                        <td>
                            <input class="input" name="dbname" type="text" value="weite">
                        </td>
                        <td>
                            <span class="gray" id="dbname_msg">
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="tar">
                            数据库表前缀：
                        </td>
                        <td>
                            <input class="input" name="tablepre" type="text" value="phpyun_">
                        </td>
                        <td>
                            <span class="gray" id="tablepre_msg">
                                同一数据库运行多个系统时，请修改前缀
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table width="100%">
                <tbody>
                    <tr>
                        <td class="td1" width="100">
                            创始人信息
                        </td>
                        <td class="td1" width="200">
                            &nbsp;
                        </td>
                        <td class="td1">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td class="tar">
                            管理员帐号：
                        </td>
                        <td>
                            <input class="input" name="username" type="text" value="admin">
                        </td>
                        <td>
                            <span class="gray" id="username_msg">
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="tar">
                            密码：
                        </td>
                        <td>
                            <input class="input" type="password" name="password" value="admin">
                        </td>
                        <td>
                            <span class="gray" id="password_msg">
                                默认密码：admin
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="tar">
                            重复密码：
                        </td>
                        <td>
                            <input class="input" name="password2" type="password" value="admin">
                        </td>
                        <td>
                            <span class="gray" id="password2_msg">
                                默认密码：admin
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="tar">
                            Email：
                        </td>
                        <td>
                            <input class="input" type="text" value="admin@admin.com" name="manager_email">
                        </td>
                        <td>
                        </td>
                    </tr>
                </tbody>
            </table>
    </div>
</div>
<div class="bottom">
    <input type="submit" value="确定" name="setup_sql" class="submit">
    <input type="button" value="返回" onclick="history.back()" name="exit" class="submit">
    </form>
</div>';
    show_header();

    echo ($form_str);
    show_footer();
}elseif ($_GET['step'] == 'data') {
	if ($_POST[setup_sql]) {
		$manager_email = $_POST['manager_email'];
		$weburl = $_POST['weburl'];
		$dbhost = $_POST['dbhost'];
		$dbname = $_POST['dbname'];
		$dbuser = $_POST['dbuser'];
		$dbpwd = $_POST['dbpwd'];
		$username = $_POST[username];
		$name = $_POST[name];
		$password = md5(md5($_POST[password]));
	
		if (empty ($dbhost) || empty ($dbname) || empty ($dbuser)) {
			show_view('<div class="centent"><div class="step"><div class="server"><table width="100%"><tbody><tr><td class="td1" width="100">提示信息</td><td class="td1" width="200">&nbsp;</td><td class="td1">&nbsp;</td></tr><tr><td colspan="3" style="width:100%;">你填写的服务器配置资料不完整！<a href="javascript:history.back();">点击返回</a></td></tr></tbody></table></div></div></div>');
		} else {
            $conn = @mysql_connect($dbhost,$dbuser,$dbpwd);
            if($conn==false){
                show_view('<div class="centent"><div class="step"><div class="server"><table width="100%"><tbody><tr><td class="td1" width="100">提示信息</td><td class="td1" width="200">&nbsp;</td><td class="td1">&nbsp;</td></tr><tr><td colspan="3" style="width:100%;">服务器的用户名或者密码错误！<a href="javascript:history.back();">点击返回</a></td></tr></tbody></table></div></div></div>');exit();
            }
		}
        $dbname_states="连接";
		if(@mysql_select_db($dbname)==false){
			if(mysql_get_server_info() > '4.1') {
                mysql_query("CREATE DATABASE `$dbname` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",$conn);
                $dbsql=@mysql_select_db($dbname);
                $dbname_states="建立";
			} else {
				show_view('<div class="centent"><div class="step"><div class="server"><table width="100%"><tbody><tr><td class="td1" width="100">提示信息</td><td class="td1" width="200">&nbsp;</td><td class="td1">&nbsp;</td></tr><tr><td colspan="3" style="width:100%;">您的数据库版本太低,请高于4.1以上！<a href="javascript:history.back();">点击返回</a></td></tr></tbody></table></div></div></div>');
				exit();
			}
		}
	}
	mysql_query("set names 'utf8'");
	echo(show_sql_result($env_items, $dirfile_items, $func_items));
	
	 echo Encode('<script>document.getElementById("kays").innerHTML+="<dd>'.$dbname_states.'数据库 '.$dbname.'...成功</dd>";document.getElementById("kays").scrollTop+='.(30).';</script>','utf-8');  
	sleep(1);
   
    header('Content-Type: text/html; charset=utf-8'); 
    ob_start();
 
    $tablepre = $_POST[tablepre];
    $fp=@file_get_contents("data/phpyun.sql");
    $fp=str_replace("phpyun_",$tablepre,$fp);
    preg_match_all("/CREATE(.*);/Uis",$fp,$arrdata);
    $preg="/CREATE TABLE `(.*)` \(/Uis";
    foreach($arrdata[0] as $k=>$v){
        $sql=str_replace("\r\n","",$v);
        preg_match_all($preg,$sql,$tablearr);
        if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$tablearr[1][0]."'"))==1){				   
            mysql_query("DROP TABLE `".$tablearr[1][0]."`;");
        }
        mysql_query($sql)or die(mysql_error());
        echo Encode('<script>document.getElementById("kays").innerHTML+="<div>正在建表'.$tablearr[1][0].'...成功</div>";document.getElementById("kays").scrollTop+='.(30).';</script>','utf-8');  
        ob_flush();
        flush();  
        ob_end_clean();
    }
   
    $fpp=@file_get_contents("data/phpyun_data.sql");
    $fpp=str_replace("phpyun_",$tablepre,$fpp);
    preg_match_all("/INSERT(.*)\);/Uis",$fpp,$data);
    foreach($data[0] as $k=>$v){
        echo Encode('<script>document.getElementById("kays").innerHTML+="<div>正在导入数据'.$k.'的第'.($k+1).'条记录</div>";document.getElementById("kays").scrollTop+='.(30).';</script>','utf-8');  
        ob_flush();
        flush();  
        ob_end_clean();
        $sql=str_replace("\r\n","",$v);
        mysql_query($sql) or die(mysql_error());
    }
   
    $table_user=$tablepre."admin_user";
    $table_config=$tablepre."admin_config";
    mysql_query("INSERT INTO $table_user SET `m_id`='1',`username`='".$username."',`password`='".$password."',`name`='超级管理员',`did`='0',`lasttime`='".time()."'");
    mysql_query("update $table_config set `config`='$weburl' where `name`='sy_weburl'");
	$str = '';
   $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz.!@#%^&*";
   $max = strlen($strPol)-1;

   for($i=0;$i<10;$i++){
    $str.=$strPol[rand(0,$max)];
   }

	 mysql_query("update $table_config set `config`='$str' where `name`='sy_safekey'");
    mysql_query("update $table_config set `config`='$manager_email' where `name`='sy_webemail'");    
	
    echo Encode('<script>document.getElementById("kays").innerHTML+="<div>添加管理员...成功</div>";document.getElementById("kays").scrollTop+='.(30).';</script>','utf-8');  
	
    $coding=md5($weburl.$name.mktime());
    $config=@fopen("../config/db.config.php","w+");
    if($config){
        $db="<?php \r\n";
        $db.="  \$db_config = array(\r\n";
        $db.="      'dbtype'=>'mysql',\r\n";
        $db.="      'dbhost'=>'$dbhost',\r\n";
        $db.="      'dbuser'=>'$dbuser',\r\n";
        $db.="      'dbpass'=>'$dbpwd',\r\n";
        $db.="      'dbname'=>'$dbname',\r\n";
        $db.="      'def'=>'$tablepre',\r\n";
        $db.="      'charset'=>'utf8',\r\n";
        $db.="      'timezone'=>'PRC',\r\n";
        $db.="      'coding'=>'$coding', //生成cookie加密\r\n";
        $db.="    );\r\n";
        $db.="    \r\n?>";
    }
    fwrite($config,$db);
    fclose($config);
    mysql_close($conn);
        echo Encode('<script>document.getElementById("kays").innerHTML+="<div>生成系统文件...成功</div>";document.getElementById("kays").scrollTop+='.(30).';</script>','utf-8');  

    echo Encode('<script>document.getElementById("kays").innerHTML+="<div>初始化数据...成功</div>";document.getElementById("kays").scrollTop+='.(30).';</script>','utf-8');  

    echo Encode('<script>document.getElementById("kays").innerHTML+="<div>更新网站缓存...成功</div>";document.getElementById("kays").scrollTop+='.(30).';</script>','utf-8');  

    echo "<script>setTimeout('location.href=\"index.php?step=finish\"',2000);</script>";
}elseif ($_GET['step'] == 'finish') {
	@fopen("../data/phpyun.lock", "w+");
	$url_this = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"];
	$url_this = explode('/install/', $url_this);
	$url_this = $url_this[0];
	
	unset($_SESSION["authcode"]);
	unset($_SESSION["auid"]);
	unset($_SESSION["ausername"]);
	unset($_SESSION["ashell"]);
	unset($_SESSION["md"]);
	unset($_SESSION["tooken"]);
	
	show_view('
<div class="step">
    <ul>
        <li class="on">
            <em>
                1
            </em>
            检测环境
        </li>
        <li class="on">
            <em>
                2
            </em>
            创建数据
        </li>
        <li class="current">
            <em>
                3
            </em>
            完成安装
        </li>
    </ul>
    <div class="server_2">
        <div class="info">
            <p class="t">
                安装成功，欢迎使用VIP版人才系统
            </p>
            <p>
                人才系统致力于帮助站长提高网站流量，增强网站运营能力，增加网站收入。
            </p>
            <p>
                人才系统目前免费提供了QQ互联、整合UC、多套模板、邮件提醒等功能。人才系统将陆续提供更多优质的服务项目。
            </p>
            <p style="color:#999;">
                大家在使用过程中，可以向我们反馈意见及BUG。
            
                </a>
            </p>
            <br>
            <br>
            <br>
            <br>
            <center>
                <input type="button" value="浏览首页" class="submit" onclick="location.href=\'../index.php\'">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" value="后台管理" class="submit" onclick="location.href=\'../admin/index.php\'">
            </center>
            <script type="text/javascript" src="'.$url_this.'/admin/index.php"></script>
        </div>
    </div>
</div>');
    echo "<div style=\"display:none\"><script src='".$url_this."/index.php'></script></div>";
}
function Encode($string,$charset){
    $InputCoding=strtolower(mb_detect_encoding($string,array('utf-8','gbk')));
    if($charset==$InputCoding){
        return $string;
    }else{
        return mb_convert_encoding($string,$charset,$InputCoding);
    }
}
?>