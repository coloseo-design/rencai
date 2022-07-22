<?php
/* *
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2016 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
*
* 百度百聘XML生成模块  QQ9860259
*/
class admin_baipin_controller extends adminCommon{
	function index_action(){
		$this->yuntpl(array('admin/admin_baipin'));
	}
	function add_action(){
		
		$jobM			=	$this->MODEL('job');
		$comM			=	$this->MODEL('company');		
		$numwhere		=	array(
			'state'		=>	1,
			'sdate'     =>  array('>', strtotime('last month')),
			'r_status'	=>	1,
			'pr'        =>  array('>',0),
			'exp'       =>  array('>',0),
			'provinceid'=>  array('>',0),
			'status'	=>	0

		);
		$total_count	=	$jobM->getJobNum($numwhere);
		$pre_count		=	1999;

		$data			=	"<?xml version=\"1.0\" encoding=\"utf-8\" ?>\r\n";
        $data			=	"<sitemapindex>\r\n";
		$j 				= 	1;
		$createcount	=	intval($total_count/$pre_count)+1;
		if($createcount>=10){
			$createcount	=	10;
		}
		for ($i=0;$i<$createcount;$i++){
			$uids		=	$jobs	=	array();
			$start 		= 	strval($i*$pre_count);
			$where		=	array(
				'state'			=>	1,
				'sdate'			=>  array('>', strtotime('last month')),
				'r_status'		=>	1,
				'status'		=>	0,
				'provinceid'	=>  array('>',0),
				'pr'			=>  array('>',0),
				'exp'			=>  array('>',0),
				'orderby'		=>	'lastupdate,desc',
				'limit'			=>	array($start,$pre_count)
			);
			
			$joblist	=	$jobM->getList($where);
			$jobs		=	$joblist['list'];
			foreach ($jobs as $v){
				$uids[]	=	$v['uid'];
			}	

			if (!empty($uids)){
				$com	=	$comM->getList(array('uid'=>array('in',pylode(',',$uids))),array('logo'=>1,'field'=>'`uid`,`address`,`content`'));
				foreach ($jobs as $k=>$v){
					if ($v['welfare']){
						$jobs[$k]['welfarename']	=	$v['welfare'];
					}
					foreach ($com['list'] as $val){
						if ($v['uid']==$val['uid']){
							$jobs[$k]['com_logo']	=	$val['com_logo'];
							$jobs[$k]['address']	=	$val['address'];
							$jobs[$k]['content']	=	str_replace("&nbsp;","",$val['content']);
						}
					}
				}
			}	
     
			$show="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
			$show.="<urlset>\r\n";
			foreach($jobs as $key=>$v){
				$comurl		=	Url("company",array("c"=>'show',"id"=>$v['uid']));
				$joburl		=	Url("job",array("c"=>'comapply',"id"=>$v['id']));
				$wapjoburl  =   Url('wap',array("c"=>"job",'a'=>'comapply',"id"=>$v['id']));
				$cityArr	=	isset($v['job_city_two']) ? $v['job_city_two'] : '不限';
				$citythree	=	isset($v['job_city_three']) ? $v['job_city_three'] : '不限';
				$v['edate'] =   $v['lastupdate'] + 86400 * 60;
				$show.="<url>\r\n";
				$show.="<loc><![CDATA[".$joburl."]]></loc>\r\n";
				$show.="<lastmod><![CDATA[".date('Y-m-d',$v['lastupdate'])."]]></lastmod>\r\n";
				$show.="<changefreq>always</changefreq>\r\n";
				$show.="<priority>1.0</priority>\r\n";
				$show.="<data>\r\n";
				$show.="<display>\r\n";
				$show.="<wapurl></wapurl>\r\n";
				$show.="<title><![CDATA[".$v['name']."]]></title>\r\n";
				$show.="<jobfirstclass><![CDATA[".$v['job_one_n']."]]></jobfirstclass>\r\n";
				$show.="<jobsecondclass><![CDATA[".$v['job_two_n']."]]></jobsecondclass>\r\n";
				$show.="<depart></depart>\r\n";
				$show.="<number><![CDATA[".$v['job_number']."]]></number>\r\n";
				$show.="<age><![CDATA[".$v['job_age']."]]></age>\r\n";
				$show.="<sex><![CDATA[".$v['job_sex']."]]></sex>\r\n";
				$show.="<description><![CDATA[".strip_tags(str_replace(array("&nbsp;","\r\n","\n"),"",$v['description']))."]]></description>\r\n";
				$show.="<education><![CDATA[".$v['job_edu']."]]></education>\r\n";
				$show.="<experience><![CDATA[".$v['job_exp']."]]></experience>\r\n";
				$show.="<startdate><![CDATA[".date('Y-m-d',$v['sdate'])."]]></startdate>\r\n";
				$show.="<enddate><![CDATA[".date('Y-m-d',$v['edate'])."]]></enddate>\r\n";
				$show.="<salary><![CDATA[".$v['job_salary']."]]></salary>\r\n";
				$show.="<city><![CDATA[".$cityArr."]]></city>\r\n";
    			$show.="<district><![CDATA[".$citythree."]]></district>\r\n";
				$show.="<area></area>\r\n";
				$show.="<location><![CDATA[".$v['address']."]]></location>\r\n";
				$show.="<type><![CDATA[".全职."]]></type>\r\n";
				$show.="<jobthirdclass><![CDATA[".$v['job_three_n']."]]></jobthirdclass>\r\n";
				$show.="<jobfourthclass></jobfourthclass>\r\n";
				$show.="<officialname><![CDATA[".$v['com_name']."]]></officialname>\r\n";
				$show.="<commonname></commonname>\r\n";
				$show.="<logo></logo>\r\n";
				$show.="<employerurl><![CDATA[".$comurl."]]></employerurl>\r\n";
				$show.="<companyaddress><![CDATA[".$v['address']."]]></companyaddress>\r\n";
				$show.="<employertype><![CDATA[".$v['job_pr']."]]></employertype>\r\n";
				$show.="<size><![CDATA[".$v['job_mun']."]]></size>\r\n";
				$show.="<welfare><![CDATA[".$v['welfarename']."]]></welfare>\r\n";
				$show.="<companydescription><![CDATA[".strip_tags($v['content'])."]]></companydescription>\r\n";
				$show.="<email></email>\r\n";
				$show.="<industry><![CDATA[".$v['job_hy']."]]></industry>\r\n";
				$show.="<secondindustry><![CDATA[".$v['job_hy']."]]></secondindustry>\r\n";
				$show.="<companyID><![CDATA[".$v['uid']."]]></companyID>\r\n";
				$show.="<source><![CDATA[".$this->config['sy_webname']."]]></source>\r\n";
				$show.="<sourcelink><![CDATA[".$this->config['sy_weburl']."]]></sourcelink>\r\n";
				$show.="<joblink><![CDATA[".$joburl."]]></joblink>\r\n";
				$show.="<jobwapurl><![CDATA[".$wapjoburl."]]></jobwapurl>\r\n";
				$show.="</display>\r\n";
				$show.="</data>\r\n";
				$show.="</url>\r\n";
			}
			$show.="</urlset>\r\n";
			
			$path = APP_PATH."/data/xml/".$j.".xml";
			$fp = @fopen($path,"w");
			@fwrite($fp,$show);
			@fclose($fp);
			
			if($j<=10){
				$data.="<sitemap>\r\n";			
				$data.="<loc>".$this->config['sy_weburl']."/data/xml/".$j.".xml</loc>\r\n";
				$data.="<lastmod>".date("Y-m-d")."</lastmod>\r\n";
				$data.="</sitemap>\r\n"; 
			}
			$j++;
		} 	
		$data.="</sitemapindex>\r\n";

		$path = APP_PATH."/data/xml/baidu.xml";
		$fp = @fopen($path,"w");
		@fwrite($fp,$data);
		@fclose($fp);
		$this->MODEL('log')->addAdminLog("百度百聘生成成功");
		$this->ACT_layer_msg('百度百聘生成成功',9,$_SERVER['HTTP_REFERER'],2,1);
	}

}

?>