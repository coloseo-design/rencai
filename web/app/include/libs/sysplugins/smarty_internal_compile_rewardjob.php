<?php
class Smarty_Internal_Compile_Rewardjob extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'limit', 'comlen', 'namelen', 'urgent', 'ispage', 'rec','report', 'hy', 'job1', 'job1_son', 'job_post', 'jobids', 'pr', 'mun', 'provinceid', 'cityid', 'ltype', 'three_cityid', 'type', 'edu', 'exp', 'sex', 'minsalary','maxsalary','keyword', 'sdate', 'cert', 'sdate', 'uptime', 'order', 'orderby', 'uid', 'noid', 'reward', 'bid', 'state','share','jobin','cityin','islt','noids');
    public $shorttag_order = array('from', 'item', 'key', 'name');
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        $from = $_attr['from'];
        $item = $_attr['item'];
        $name = $_attr['item'];
        $name=str_replace('\'','',$name);
        $name=$name?$name:'List';$name='$'.$name;
        if (!strncmp("\$_smarty_tpl->tpl_vars[$item]", $from, strlen($item) + 24)) {
            $compiler->trigger_template_error("item variable {$item} may not be the same variable as at 'from'", $compiler->lex->taglineno);
        }

        //自定义标签 START
        $OutputStr='global $db,$db_config,$config;
		$time = time();
		
		
		//可以做缓存
        $paramer='.ArrayToString($_attr,true).';
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
        $Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		include_once  PLUS_PATH."/comrating.cache.php";
		include(CONFIG_PATH."db.data.php"); 
		
		if($config[sy_web_site]=="1"){
			if($config[province]>0 && $config[province]!=""){
				$paramer[provinceid] = $config[province];
			}
			if($config[cityid]>0 && $config[cityid]!=""){
				$paramer[cityid] = $config[cityid];
			}
			if($config[three_cityid]>0 && $config[three_cityid]!=""){
				$paramer[three_cityid] = $config[three_cityid];
			}
			if($config[hyclass]>0 && $config[hyclass]!=""){
				$paramer[hy]=$config[hyclass];
			}
		}

		if($paramer[reward]==\'1\'){
			$where="`rewardpack`=\'1\'";

		}elseif($paramer[share]==\'1\'){
		
			$where="`sharepack`=\'1\'";
		}
		//城市大类
			if($paramer[provinceid]){
				$where .= " AND `provinceid` = $paramer[provinceid]";
			}
			//城市子类
			if($paramer[\'cityid\']){
				$where .= " AND (`cityid` IN ($paramer[cityid]))";
			}
			//城市三级子类
			if($paramer[\'three_cityid\']){
				$where .= " AND (`three_cityid` IN ($paramer[three_cityid]))";
			}
			 
		
		$where .= " AND `r_status`=\'1\' AND `state`=1 and `status`=\'0\' ";
		
		
		//按照职位名称匹配
		if($paramer[keyword]){
			$where1[]="`name` LIKE \'%".$paramer[keyword]."%\'";
			$where1[]="`com_name` LIKE \'%".$paramer[keyword]."%\'";

			$where.=" AND (".@implode(" or ",$where1).")";
		}

		//筛除重复
		if($paramer[noids]==1 && !empty($noids)){
			$where.=" AND `id` NOT IN (".@implode(\',\',$noids).")";
		}
	

		//查询条数
		if($paramer[limit]){
			$limit = " limit ".$paramer[limit];
		}

		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"company_job",$where,$Purl,"",$paramer[islt]?$paramer[islt]:"6",$_smarty_tpl);
          
		} 
		//排序字段默认为更新时间
		if($paramer[order] && $paramer[order]!="lastdate"){
			$order = " ORDER BY ".str_replace("\'","",$paramer[order])."  ";
		}else{
			$order = " ORDER BY `lastupdate` ";
		}
		//排序规则 默认为倒序
		if($paramer[sort]){
			$sort = $paramer[sort];
		}else{
			$sort = " DESC";
		} 
		$where.=$order.$sort;  
		 
		'.$name.' = $db->select_all("company_job",$where.$limit);
		if(is_array('.$name.')){
			//处理类别字段
			$cache_array = $db->cacheget();
			$comuid=$jobid=array();
			foreach('.$name.' as $key=>$value){
				$comuid[] = $value[\'uid\'];
				$jobid[] = $value[\'id\'];
			}
			$comuids = @implode(\',\',$comuid);
			$jobids = @implode(\',\',$jobid);
			$r_uid = array();
			
			if($comuids){
				$r_uids=$db->select_all("company","`uid` IN (".$comuids.")","`name`,`uid`,`shortname`,`yyzz_status`,`logo`,`pr`,`hy`,`mun`");
				if(is_array($r_uids)){
					foreach($r_uids as $key=>$value){
						if($value[\'shortname\']){
    						$value[\'name\'] =$value[\'shortname\'];
    					}
						$value[\'logo\']= checkpic($value[\'logo\'],$config[\'sy_unit_icon\']);
						$value[\'pr_n\'] = $cache_array[\'comclass_name\'][$value[pr]];
						$value[\'hy_n\'] = $cache_array[\'industry_name\'][$value[hy]];
						$value[\'mun_n\'] = $cache_array[\'comclass_name\'][$value[mun]];
						$r_uid[$value[\'uid\']] = $value;
					}
				}
			}
			
			if($jobids){
			
			    //$db -> update_all("company_job", "`jobexpoure` = `jobexpoure` + 1", "`id` IN ($jobids)");
			
				if($paramer[reward]==\'1\'){
					
					$rewardList=$db->select_all("company_job_reward","`jobid` IN (".$jobids.")");
					
				}elseif($paramer[share]==\'1\'){ 

					$rewardList=$db->select_all("company_job_share","`jobid` IN (".$jobids.")","`jobid`,`packmoney`,`packprice`,`packnum`");
				
				}
				if(is_array($rewardList)){
						foreach($rewardList as $key=>$value){
							
							$rewadArr[$value[\'jobid\']] = $value;
						}
					}
			}
			    
			
			$noids=array();
			foreach('.$name.' as $key=>$value){
				if($paramer[bid]){
					$noids[] = $value[id];
				}
				'.$name.'[$key] = $db->array_action($value,$cache_array);
				'.$name.'[$key][stime] = date("Y-m-d",$value[sdate]);
				'.$name.'[$key][etime] = date("Y-m-d",$value[edate]);
				if($arr_data[\'sex\'][$value[\'sex\']]){
    				'.$name.'[$key][sex_n]=$arr_data[\'sex\'][$value[\'sex\']];
    			}
				'.$name.'[$key][lastupdate] = date("Y-m-d",$value[lastupdate]);

				if($value[minsalary] && $value[maxsalary]){
					if($config[\'resume_salarytype\']==1){
						'.$name.'[$key][job_salary] =$value[minsalary]."~".$value[maxsalary]."元";
					}else{
						if($value[maxsalary]<1000){
							if($config[\'resume_salarytype\']==2){
								'.$name.'[$key][job_salary] = "1千以下";
							}elseif($config[\'resume_salarytype\']==3){
								'.$name.'[$key][job_salary] = "1K以下";
							}elseif($config[\'resume_salarytype\']==4){
								'.$name.'[$key][job_salary] = "1k以下";
							}

						}else{
							'.$name.'[$key][job_salary] =changeSalary($value[minsalary])."~".changeSalary($value[maxsalary]);
						}
					}
				}elseif($value[minsalary]){
					if($config[\'resume_salarytype\']==1){
						'.$name.'[$key][job_salary] =$value[minsalary];
					}else{
						'.$name.'[$key][job_salary] =changeSalary($value[minsalary]);
					}
				}else{
                    '.$name.'[$key][job_salary] ="面议";
                }
				//if($r_uid[$value[\'uid\']][shortname]){
    				'.$name.'[$key][com_name] =$r_uid[$value[\'uid\']][name];
    			//}
				'.$name.'[$key][yyzz_status] =$r_uid[$value[\'com_id\']][yyzz_status];
				'.$name.'[$key][logo] =$r_uid[$value[\'uid\']][logo];
				'.$name.'[$key][pr_n] =$r_uid[$value[\'uid\']][pr_n];
				'.$name.'[$key][hy_n] =$r_uid[$value[\'uid\']][hy_n];
				'.$name.'[$key][mun_n] =$r_uid[$value[\'uid\']][mun_n];
				
				if($paramer[reward]==\'1\'){
					'.$name.'[$key][sqmoney] =floatval( $rewadArr[$value[\'id\']][sqmoney]);
					'.$name.'[$key][invitemoney] =floatval( $rewadArr[$value[\'id\']][invitemoney]);
					'.$name.'[$key][offermoney] =floatval( $rewadArr[$value[\'id\']][offermoney]);
					'.$name.'[$key][money] =floatval( $rewadArr[$value[\'id\']][money]);
					'.$name.'[$key][r_exp] = $rewadArr[$value[\'id\']][exp];
					'.$name.'[$key][r_edu] = $rewadArr[$value[\'id\']][edu];
					'.$name.'[$key][r_project] = $rewadArr[$value[\'id\']][project];
					'.$name.'[$key][r_skill] = $rewadArr[$value[\'id\']][skill];
				}

				if($paramer[share]==\'1\'){
					'.$name.'[$key][packmoney] = $rewadArr[$value[\'id\']][packmoney];
					'.$name.'[$key][packnum] = $rewadArr[$value[\'id\']][packnum];
					'.$name.'[$key][packprice] = $rewadArr[$value[\'id\']][packprice];
					
				}
				

				$time=$value[\'lastupdate\'];
				//今天开始时间戳
				$beginToday=time(0,0,0,date(\'m\'),date(\'d\'),date(\'Y\'));
				//昨天开始时间戳
				$beginYesterday=time(0,0,0,date(\'m\'),date(\'d\')-1,date(\'Y\'));
				if($time>$beginYesterday && $time<$beginToday){
					'.$name.'[$key][\'time\'] ="昨天";
				}elseif($time>$beginToday){	
					'.$name.'[$key][\'time\'] = date("H:i",$value[\'lastupdate\']);
					'.$name.'[$key][\'redtime\'] =1;
				}else{
					'.$name.'[$key][\'time\'] = date("Y-m-d",$value[\'lastupdate\']);
				}
				//获得福利待遇名称
				if(is_array('.$name.'[$key][\'welfare\'])&&'.$name.'[$key][\'welfare\']){
					foreach('.$name.'[$key][\'welfare\'] as $val){
						//'.$name.'[$key][\'welfarename\'][]=$cache_array[\'comclass_name\'][$val];
						'.$name.'[$key][\'welfarename\'][]=$val;
					}

				}
				//截取公司名称
				if($paramer[comlen]){
					if($r_uid[$value[\'com_id\']][shortname]){
    					'.$name.'[$key][com_n] = mb_substr($r_uid[$value[\'com_id\']][shortname],0,$paramer[comlen],"utf-8");
    				}else{
    					'.$name.'[$key][com_n] = mb_substr($value[\'com_name\'],0,$paramer[comlen],"utf-8");
    				}
					
				}
				//截取职位名称
				if($paramer[namelen]){
					if($value[\'rec_time\']>time()){
						'.$name.'[$key][name_n] = "<font color=\'red\'>".mb_substr($value[\'name\'],0,$paramer[namelen],"utf-8")."</font>";
					}else{
						'.$name.'[$key][name_n] = mb_substr($value[\'name\'],0,$paramer[namelen],"utf-8");
					}
				}else{
					if($value[\'rec_time\']>time()){
						'.$name.'[$key][\'name_n\'] = "<font color=\'red\'>".$value[\'name\']."</font>";
					}else{
						'.$name.'[$key][\'name_n\'] = $value[\'name\'];
					}
				}
				//构建职位伪静态URL
				'.$name.'[$key][job_url] = Url("job",array("c"=>"comapply","id"=>$value[id]),"1");
				'.$name.'[$key][job_wapurl] = Url("wap",array("c"=>"job","a"=>"comapply","id"=>$value[id]),"1");
				//构建企业伪静态URL
				'.$name.'[$key][com_url] = Url("company",array("c"=>"show","id"=>$value[uid]));
				foreach($comrat as $k=>$v){
					if($value[rating]==$v[id]){
						'.$name.'[$key][color] = str_replace("#","",$v[com_color]);
						'.$name.'[$key][ratlogo] = $v[com_pic];
						'.$name.'[$key][ratname] = $v[name];
					}
				}
				if($paramer[keyword]){
					'.$name.'[$key][name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[name]);
					'.$name.'[$key][com_name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[com_name]);
					'.$name.'[$key][name_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",'.$name.'[$key][name_n]);
					'.$name.'[$key][com_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",'.$name.'[$key][com_n]);
				}
			}

			if(is_array('.$name.')){
				if($paramer[keyword]!=""&&!empty('.$name.')){
					addkeywords(\'3\',$paramer[keyword]);
				}
			}
		}';
       // global $DiyTagOutputStr;
       // $DiyTagOutputStr[]=$OutputStr;
        return SmartyOutputStr($this,$compiler,$_attr,'rewardjob',$name,$OutputStr,$name);
    }
}
class Smarty_Internal_Compile_Rewardjobelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('rewardjob'));
        $this->openTag($compiler, 'rewardjobelse', array('rewardjobelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Rewardjobclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('rewardjob', 'rewardjobelse'));

        return "<?php } ?>";
    }
}
