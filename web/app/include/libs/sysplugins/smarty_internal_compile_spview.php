<?php
class Smarty_Internal_Compile_Spview extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'len', 'limit', 'ispage','order','sort','mun','pr','hy','provinceid','cityid','three_cityid','starttime','keyword');
    public $shorttag_order = array('from', 'item', 'key', 'name');
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        $from = $_attr['from'];
        $item = $_attr['item'];
        $name = $_attr['item'];
        $name=str_replace('\'','',$name);
        $name=$name?$name:'list';$name='$'.$name;
        if (!strncmp("\$_smarty_tpl->tpl_vars[$item]", $from, strlen($item) + 24)) {
            $compiler->trigger_template_error("item variable {$item} may not be the same variable as at 'from'", $compiler->lex->taglineno);
        }

        //自定义标签START
        $OutputStr=''.$name.'=array();$time=time();$paramer='.ArrayToString($_attr,true).';
		global $db,$db_config,$config;
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }

        $cache_array = $db->cacheget();
		$comclass_name = $cache_array["comclass_name"];

        $where = "b.`status` = 1 AND b.`roomstatus` = 0 AND b.`uid`=a.`uid`";
        $pagewhere = "";$joinwhere = "";

		if($config[\'did\']){
			$where.=" and b.`did`=\'".$config[\'did\']."\'";
		}
        if($paramer[starttime]){
            if($paramer[starttime]=="today"){

                $stime = strtotime(date("Y-m-d"));

                $etime = $stime+86400;

                $where  .= " AND b.`starttime` >\'".$stime."\' AND b.`starttime` <\'".$etime."\'";

            }else if($paramer[starttime]=="endsub"){//预约中

                $subtime = time() - ($config[\'sy_spview_yytime\']* 3600);

                $where  .= " AND b.`starttime` >\'".$subtime."\'";

            }
        }
        
        //企业表联查
        $comwhere = " a.`r_status` = 1";
        if($paramer[keyword]){
            
            $comwhere  .= " AND a.`name` LIKE \'%$paramer[keyword]%\'";
            
        }
        if($paramer[mun]){
            
            $comwhere  .= " AND a.`mun` = $paramer[mun]";
            
        }
        if($paramer[hy]){
            
            $comwhere  .= " AND a.`hy` = $paramer[hy]";
            
        }
        if($paramer[pr]){
            
            $comwhere  .= " AND a.`pr` = $paramer[pr]";
            
        }
        if($paramer[provinceid]){
            
            $comwhere  .= " AND a.`provinceid` = $paramer[provinceid]";
            
        }
        if($paramer[cityid]){
            
            $comwhere  .= " AND a.`cityid` = $paramer[cityid]";
            
        }
        if($paramer[three_cityid]){
            
            $comwhere  .= " AND a.`three_cityid` = $paramer[three_cityid]";
            
        }
        if($comwhere!=""){
            $pagewhere .=" ,`".$db_config[def]."company` a ";
            $joinwhere .= $comwhere;
        }
		//查询条数
		if($paramer[limit]){
			$limit=" LIMIT ".$paramer[limit];
		}else{
			$limit=" LIMIT 20";
		}
		if($paramer[ispage]){
            
			$limit = PageNav($paramer,$_GET,"company",$where,$Purl,"spview","0",$_smarty_tpl,$pagewhere,$joinwhere);
		}
        $select = "*";
        $time = time();
        if($paramer[\'order\']=="1"){
            // 条件排序，优先未开始，并按id倒序
            
            $order = " ORDER BY";
            $order .= " CASE";
            $order .= " WHEN b.`starttime`>\'$time\' THEN 1";
            $order .= " WHEN b.`starttime`<\'$time\' THEN 2";
            $order .= " END,b.`id`";
            $sort   =   " DESC";
        }else{
            //排序字段
            if($paramer[\'order\']){
                $order = " ORDER BY b.`".$paramer[\'order\']."`  ";
            }else{
                $order = " ORDER BY b.`id` ";
            }
            //排序规则 默认为倒序
            if($paramer[\'sort\']){
                $sort = $paramer[\'sort\'];
            }else{
                $sort = " DESC";
            }
        }

        $where.=$order.$sort.$limit;

        if($pagewhere!=""){

            $sql = "select ".$select." from `".$db_config[def]."spview` b ".$pagewhere." where ".$joinwhere." and ".$where;

        }else{
            $sql = "select ".$select." from `".$db_config[def]."spview` b where ".$where;
        }
        '.$name.'=$db->DB_query_all($sql,"all");
		
		if(is_array('.$name.')){

            $comids = array();
            $jobidarr = array();
            $idarr = array();

            foreach('.$name.' as $nk=>$nv){

                $jids = array();

                $idarr[] = $nv["id"];

                if($nv["uid"]){
                    $comids[] = $nv["uid"];
                }
                if($nv["jobid"]){
                    $jids = @explode(",",$nv["jobid"]);
                }
                $jobidarr = array_unique(array_merge($jobidarr, $jids));
            }

            if(!empty($idarr)){
                
                $sp_subs = $db->select_all("spview_subscribe","`sid` in (".@implode(",",$idarr).") GROUP BY `sid`","count(*) as num,sid");
                $sp_subarr = $db->select_all("spview_subscribe","`sid` in (".@implode(",",$idarr).")");
            }
            
            if(!empty($comids)){

                $companys = $db->select_all("company","`uid` in (".@implode(",",$comids).") AND `r_status`=\'1\'");
            }
            
            if(!empty($jobidarr)){

                $company_jobs = $db->select_all("company_job","`id` in (".@implode(",",$jobidarr).") AND `r_status`=1 AND `status`=\'0\' AND `state`=1");
            }

			foreach('.$name.' as $key=>$v){
				
                $jobids = array();
                $joblist = array();
                if($v["jobid"]){
                    $jobids = @explode(",",$v["jobid"]);
                }

                '.$name.'[$key]["starttime_n"]  =   date("Y-m-d H:i",$v["starttime"]);
                
				$yytime	=	$config[\'sy_spview_yytime\'] * 3600;
                if(($v["starttime"] - $yytime) > $time){

                    '.$name.'[$key]["s_status"] = 1;//未开始
                }else{

                    if ($v["roomstatus"]  == 1){
                        '.$name.'[$key]["s_status"] = 3;//已结束
                    }else{
                        '.$name.'[$key]["s_status"] = 2;//已开始
                    }
                }
                
                foreach($companys as $ck=>$cv){

                    if($cv["uid"] == $v["uid"]){

                        '.$name.'[$key][\'comname\'] = $cv[\'name\'];
                        '.$name.'[$key][\'com_url\'] = Url("company",array("c"=>"show","id"=>$cv[\'uid\']));
                        '.$name.'[$key][\'joball_url\'] = Url("company",array("c"=>"show","id"=>$cv[\'uid\'],"tp"=>"post"));

                        if(!$cv[\'logo\'] || $cv[\'logo_status\']!=0){
                            '.$name.'[$key][\'comlogo\'] = checkpic("",$config[\'sy_unit_icon\']);
                        }else{
                            '.$name.'[$key][\'comlogo\'] = checkpic($cv[\'logo\'],$config[\'sy_unit_icon\']);
                        }

                        '.$name.'[$key][\'comhy\'] = $cache_array[\'industry_name\'][$cv[hy]];
                        '.$name.'[$key][\'compr\'] = $comclass_name[$cv[\'pr\']];
                        '.$name.'[$key][\'commun\']= $comclass_name[$cv[\'mun\']];

                        //获得福利待遇名称
                        if($cv[\'welfare\']){
                            '.$name.'[$key][\'comwel\'] = @explode(",", $cv[\'welfare\']);
                        }

                    }
                }

                foreach($company_jobs as $jk=>$jv){

                    if(in_array($jv[\'id\'],$jobids)){

                        
                        if($jv[minsalary]&&$jv[maxsalary]){
                            if($config[\'resume_salarytype\']==1){
                                    $company_jobs[$jk][job_salary] =$jv[minsalary]."-".$jv[maxsalary];
                            }else{
                                if($jv[maxsalary]<1000){
                                    if($config[\'resume_salarytype\']==2){
                                        $company_jobs[$jk][job_salary] = "1千以下";
                                    }elseif($config[\'resume_salarytype\']==3){
                                        $company_jobs[$jk][job_salary] = "1K以下";
                                    }elseif($config[\'resume_salarytype\']==4){
                                        $company_jobs[$jk][job_salary] = "1k以下";
                                    }
                                }else{
                                    $company_jobs[$jk][job_salary] =changeSalary($jv[minsalary])."-".changeSalary($jv[maxsalary]);
                                }
                            }
                        }elseif($jv[minsalary]){
                            if($config[\'resume_salarytype\']==1){
                                $company_jobs[$jk][job_salary] =$jv[minsalary];
                            }else{
                                $company_jobs[$jk][job_salary] =changeSalary($jv[minsalary]);
                            }
                        }else{
                            $company_jobs[$jk][job_salary] ="面议";
                        }

                        $company_jobs[$jk][job_url] = Url("job",array("c"=>"comapply","id"=>$jv[id]),"1");

                        $joblist[]  =   $company_jobs[$jk];
                    }

                }
                '.$name.'[$key]["subnum"] = 0;
                foreach($sp_subs as $sk=>$sv){

                    if($sv["sid"] == $v["id"]){

                        '.$name.'[$key]["subnum"] = $sv["num"];

                    }
                }

                '.$name.'[$key]["issub"] = 0;

                if(!empty($sp_subarr) && $_COOKIE[uid]){

                    foreach($sp_subarr as $subk=>$subv){

                        if($_COOKIE[uid]==$subv["uid"]){

                            '.$name.'[$key]["issub"] = 1;

                        }

                    }

                }
                '.$name.'[$key]["jobnum"] = count($joblist);
                '.$name.'[$key]["joblist"] = $joblist;
				'.$name.'[$key]["url"]=Url("spview",array("c"=>\'show\',"id"=>$v[\'id\']),"1");

				
			}
		}';
        //自定义标签 END
        return SmartyOutputStr($this,$compiler,$_attr,'spview',$name,$OutputStr,$name);
    }
}
class Smarty_Internal_Compile_Spviewelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('spview'));
        $this->openTag($compiler, 'spviewelse', array('spviewelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Spviewclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('spview', 'spviewelse'));

        return "<?php } ?>";
    }
}
