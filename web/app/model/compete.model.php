<?php

/**
 * $Author ：PHPYUN开发团队
 *
 * 官网: http://www.phpyun.com
 *
 * 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
 *
 * 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */

class compete_model extends model
{

    /**
     * 企业发布职位竞争力统计
     * @param $uid
     * @param $jobid
     * @return array
     */
    public function comJob($uid, $jobid, $usertype)
    {

        $compete = array();
        //根据职位ID 用户ID 查出职位参数：类别、薪资、福利待遇、经验、学历要求
        $jobInfo = $this->select_once('company_job', array('id' => (int)$jobid, 'uid' => (int)$uid), '`id`,`uid`,`minsalary`,`maxsalary`,`edu`,`exp`,`job1_son`,`name`,`welfare`');

        if ($jobInfo['job1_son']) {

            //以职位分类为基准查询同类型职位 作为统计标本
            $sameJobWhere['job1_son']   =   $jobInfo['job1_son'];
//            $sameJobWhere['uid']        =   array('<>', $jobInfo['uid']);
        } elseif ($jobInfo['name']) {

            //无职位分类（采集、其他系统迁入、导入等非正常渠道来源数据）使用名称模糊匹配
            $sameJobWhere['name']       =   array('like', $jobInfo['name']);
//            $sameJobWhere['uid']        =   array('<>', $jobInfo['uid']);
        }
        if ($sameJobWhere) {

            $sameJobWhere['orderby']    =   array('lastupdate,desc');
            //查询最新2000份样本进行统计
            $sameJobWhere['limit']      =   '2000';
            $sameJobList                =   $this->select_all('company_job', $sameJobWhere, '`uid`,`minsalary`,`welfare`,`exp`,`edu`');
        }

        if (!empty($sameJobList)) {

            include(PLUS_PATH . 'com.cache.php');

            $jobNum = count($sameJobList);

            $competeWelfare = array();

            foreach ($sameJobList as $key => $value) {

                //统计薪酬 四个区间 3000以下、3-5000、5-8000、8-10000、10000以上

                $salaryCpt      =   $this->salaryCompete($value['minsalary']);
                $competeKey     =   $salaryCpt['competeKey'];
                $competeName    =   $salaryCpt['competeName'];

                $compete        =   $this->competeStatic($compete, 'salary', $competeKey, $competeName, $jobNum);

                //统计学历要求
                if ($value['edu']) {
                    $compete    =   $this->competeStatic($compete, 'edu', array_search($value['edu'], $comdata['job_edu']), $comclass_name[$value['edu']], $jobNum);
                }

                //统计经验要求
                if ($value['exp']) {
                    $compete    =   $this->competeStatic($compete, 'exp', array_search($value['exp'], $comdata['job_exp']), $comclass_name[$value['exp']], $jobNum);
                }
                //统计福利待遇
                if ($value['welfare']) {

                    $welfare    =   @explode(',', $value['welfare']);
                    $competeWelfare = array_unique(array_merge($welfare, $competeWelfare));
                }
            }

            //信息比对 1:薪资区间 2：学历要求 3：工作经验 4：福利待遇
            $salaryCpt  =   $this->salaryCompete($jobInfo['minsalary']);
            $jobKey     =   $salaryCpt['competeKey'];

            //薪资比对
            $compete['salaryStatis']    =   $this->perceStatis($compete['salary'], $jobKey, '');

            //学历要求比对
            if ($jobInfo['edu']) {

                $compete['eduStatis']   =   $this->perceStatis($compete['edu'], array_search($jobInfo['edu'], $comdata['job_edu']), '');
            } else {

                $compete['eduStatis']   =   array();
            }


            //工作经验要求比对
            if ($jobInfo['exp']) {

                $compete['expStatis']   =   $this->perceStatis($compete['exp'], array_search($jobInfo['exp'], $comdata['job_exp']), '');
            } else {

                $compete['expStatis']   =   array();
            }

            //福利待遇比对
            if ($jobInfo['welfare']) {

                $welfare    =   explode(',', $jobInfo['welfare']);
                foreach ($welfare as $key => $value) {

                    if (!in_array($value, $competeWelfare)) {

                        $compete['welfare']['my'][] = $value;
                    } else {

                        $welKey = array_search($value, $competeWelfare);
                        unset($competeWelfare[$welKey]);
                    }
                }
            }
            $compete['welfare']['else'] =   $competeWelfare;
            /*根据统计数据分析竞争力指标
            * 评分 高薪占比 40 学历 25 工作经验 25 待遇优势 10
            * 40分以下 竞争力低
            * 40-60 中
            * 大于60 高
            * 根据各项评分 生成评述语
            */
            $score  =   0;
            if ($compete['salaryStatis']['type'] == 1) {
                $score += 40;
                $scoreMsg[] = '最低薪资高于行业平均水平';
            } else {
                $scoreMsg[] = '最低薪资低于行业平均水平';
            }

            if ($compete['expStatis']['type'] == 2) {
                $score += 25;
                $scoreMsg[] = '工作经验要求低于同行业';
            } else {
                $scoreMsg[] = '工作经验要求高于同行业';
            }
            if ($compete['eduStatis']['type'] == 2) {
                $score += 25;
                $scoreMsg[] = '学历要求低于同行业';
            } else {
                $scoreMsg[] = '学历要求高于同行业';
            }
            if (!empty($compete['welfare']['my'])) {
                $score += 10;
                $scoreMsg[] = '拥有相应福利待遇优势';
            } else {
                $scoreMsg[] = '相应福利待遇没有优势';
            }
            if ($score < 40) {
                $compete['scoreName'] = '低';
            } elseif ($score >= 40 && $score <= 60) {
                $compete['scoreName'] = '中';
            } elseif ($score > 60) {
                $compete['scoreName'] = '高';
            }
            $compete['scoreMsg'] = implode(',', $scoreMsg);
            $compete['score'] = $score;

            //整理当前职位相关信息

            $compete['jobinfo']['job_salary_n'] =   $this->salaryCompete($jobInfo['minsalary']);
            $compete['jobinfo']['job_salary']   =   $this->salaryShow($jobInfo['minsalary'], $jobInfo['maxsalary']);

            $compete['jobinfo']['job_edu']      =   $comclass_name[$jobInfo['edu']];

            $compete['jobinfo']['job_exp']      =   $comclass_name[$jobInfo['exp']];

            $compete['jobinfo']['name']         =   $jobInfo['name'];

            $compete['errcode'] = '1';
        } else {
            //无足够样本
            $compete['errcode'] = '2';
        }

        return $compete;
    }


    function userJob($uid, $jobid, $usertype)
    {

        if (!$uid) {
            $compete['errcode'] = '3';//请先登录
            return $compete;
        }

        if ($usertype != 1) {
            $compete['errcode'] = '5';//请先切换身份
            return $compete;
        }

        //取出当前匹配的简历信息
        $expectInfo = $this->select_once('resume_expect', array('uid' => (int)$uid, 'defaults' => 1), '`minsalary`,`maxsalary`,`edu`,`exp`');
        if (empty($expectInfo)) {
            $compete['errcode'] = '4';//请先创建一份简历
            return $compete;
        }
        //取出对应职位的浏览记录
        $lookLog = $this->select_all('look_job', array('jobid' => (int)$jobid, 'orderby' => 'datetime,desc', 'limit' => '1000'), '`uid`');
        if (empty($lookLog)) {
            $compete['errcode'] = '2';//无足够样本
            return $compete;
        }
        if (!empty($lookLog)) {

            foreach ($lookLog as $key => $value) {

                //同一人名下不参与评比分析
//                if ($value['uid'] != $uid) {
                    $lookUid[$value['uid']] = $value['uid'];
//                }
            }
            //根据浏览记录获取对应的简历信息

            $expectList = $this->select_all('resume_expect', array('uid' => array('in', pylode(',', $lookUid)), 'defaults' => 1), '`uid`,`minsalary`,`edu`,`exp`');

            if (empty($expectList)) {

                $compete['errcode'] = '2';//无足够样本
                return $compete;
            } else {

                include(PLUS_PATH . 'user.cache.php');

                $expectNum = count($expectList);

                $competeWelfare = array();
                $compete = array();
                foreach ($expectList as $key => $value) {

                    //统计薪酬 四个区间 3000以下、3-5000、5-8000、8-10000、10000以上

                    $salaryCpt = $this->salaryCompete($value['minsalary']);
                    $competeKey = $salaryCpt['competeKey'];
                    $competeName = $salaryCpt['competeName'];

                    $compete = $this->competeStatic($compete, 'salary', $competeKey, $competeName, $expectNum);


                    //统计学历要求
                    if ($value['edu']) {
                        $compete = $this->competeStatic($compete, 'edu', array_search($value['edu'], $userdata['user_edu']), $userclass_name[$value['edu']], $expectNum);
                    }

                    //统计经验要求
                    if ($value['exp']) {
                        $compete = $this->competeStatic($compete, 'exp', array_search($value['exp'], $userdata['user_word']), $userclass_name[$value['exp']], $expectNum);
                    }

                }

                //信息比对 1:薪资区间 2：学历要求 3：工作经验 4：福利待遇

                $salaryCpt = $this->salaryCompete($expectInfo['minsalary']);
                $userKey = $salaryCpt['competeKey'];

                //薪资比对
                $compete['salaryStatis'] = $this->perceStatis($compete['salary'], $userKey, '');

                //学历要求比对
                if ($expectInfo['edu']) {
                    $compete['eduStatis'] = $this->perceStatis($compete['edu'], array_search($expectInfo['edu'], $userdata['user_edu']), '');
                }

                //工作经验要求比对
                if ($expectInfo['exp']) {
                    $compete['expStatis'] = $this->perceStatis($compete['exp'], array_search($expectInfo['exp'], $userdata['user_word']), '');
                }

            }

            $score = 0;
            if ($compete['salaryStatis']['type'] == 2) {

                $scoreMsg[] = '期望薪资低于平均水平';
            } else {
                $score += 45;
                $scoreMsg[] = '期望薪资高于平均水平';
            }

            if ($compete['expStatis']['type'] == 2) {

                $scoreMsg[] = '工作经验低于同行';
            } else {
                $score += 30;
                $scoreMsg[] = '工作经验高于同行';
            }
            if ($compete['eduStatis']['type'] == 2) {

                $scoreMsg[] = '学历低于同行';
            } else {
                $score += 35;
                $scoreMsg[] = '学历高于同行';
            }

            if ($score < 45) {
                $compete['scoreName'] = '低';
            } elseif ($score >= 45 && $score <= 65) {
                $compete['scoreName'] = '中';
            } elseif ($score > 65) {
                $compete['scoreName'] = '高';
            }
            $compete['scoreMsg'] = implode(',', $scoreMsg);
            $compete['score'] = $score;


            $compete['resinfo']['user_salary_n']=   $this->salaryCompete($expectInfo['minsalary']);
            $compete['resinfo']['user_salary']  =   $this->salaryShow($expectInfo['minsalary'], $expectInfo['maxsalary']);
            $compete['resinfo']['user_edu']     =   $userclass_name[$expectInfo['edu']];

            $compete['resinfo']['user_exp']     =   $userclass_name[$expectInfo['exp']];
            $compete['errcode'] = '1';

        }

        return $compete;


    }

    private function salaryShow($minsalary, $maxsalary)
    {

        //整理当前简历相关信息
        if ($minsalary || $maxsalary) {

            if ($minsalary && $maxsalary) {
                if ($this->config['resume_salarytype'] == 1) {
                    $salary = $minsalary . '-' . $maxsalary;
                } else {
                    $salary = changeSalary($minsalary) . '-' . changeSalary($maxsalary);
                }
            } elseif ($minsalary) {
                if ($this->config['resume_salarytype'] == 1) {
                    $salary = $minsalary;
                } else {
                    $salary = changeSalary($minsalary);
                }
            } else {

                $salary = '面议';

            }

        } else {

            $salary = '面议';

        }

        return $salary;

    }

    //薪资区间定位
    private function salaryCompete($salary)
    {

        if ($salary > 0) {
            if ($salary >= 10000) {
                $competeKey     =   10001;
                $competeName    =   '10K以上';
            } elseif ($salary >= 8000) {
                $competeKey     =   8001;
                $competeName    =   '8K-10K';
            } elseif ($salary >= 5000) {
                $competeKey     =   5001;
                $competeName    =   '5K-8K';
            } elseif ($salary >= 3000) {
                $competeKey     =   3001;
                $competeName    =   '3K-5K';
            } else {
                $competeKey     =   3000;
                $competeName    =   '3K以下';
            }
        } else {

            $competeKey     =   0;
            $competeName    =   '面议';
        }

        return array('competeKey' => $competeKey, 'competeName' => $competeName);
    }

    //占比统计
    private function perceStatis($competeData, $jobKey, $typeMsg = '')
    {

        $perceData  =   array();
        $perceData['max']   =   $perceData['min']   =   $perceData['same'] = 0;

        if (!empty($competeData)) {

            foreach ($competeData as $key => $value) {
                //根据jobkey 将数据整理成三份 1：同等数据 2：低于当前自身数据 3：高于当前自身数据
                if ($key > $jobKey) {

                    $perceData['max'] += $value['perce'];
                } elseif ($key < $jobKey) {

                    $perceData['min'] += $value['perce'];
                } elseif ($key == $jobKey) {

                    $perceData['same'] = $value['perce'];
                }

            }
            $perceData['max']   =   round($perceData['max'], 2);
            $perceData['min']   =   round($perceData['min'], 2);
            $perceData['same']  =   round($perceData['same'], 2);
            //根据数据统计出整体行业对比水准 1：高 2：低 持平也算作低
            if (($perceData['same'] + $perceData['min']) > $perceData['max']) {

                $perceData['type'] = 1;
            } else {

                $perceData['type'] = 2;
            }
            /*
            if(!empty($perceData))
            {
                if($perceData['max'] == 1){
                    $msgInfo[] = '低于全行业';
                }elseif($perceData['max']>0){
                    $msgInfo[] = '低于 '.($perceData['max']*100).'% 同行';
                }

                if($perceData['min'] == 1){
                    $msgInfo[] = '高于全行业';
                }elseif($perceData['min']>0){
                    $msgInfo[] = '高于 '.($perceData['min']*100).'% 同行';
                }

                if($perceData['same'] == 1){
                    $msgInfo[] = '与全行业持平';
                }elseif($perceData['same']>0){
                    $msgInfo[] = '与'.($perceData['same']*100).'% 同行持平';
                }

                $perceData['msg']	=	implode(',',$msgInfo);
            }*/
        }

        return $perceData;

    }


    //数据整理
    private function competeStatic($compete, $type, $competeKey, $competeName, $Num)
    {

        $compete[$type][$competeKey]['name'] = $competeName;
        $compete[$type][$competeKey]['count']++;
        //$compete[$type][$competeKey]['perce']		=   round($compete[$type][$competeKey]['count']/$Num,4)*100;

        $price = round(round($compete[$type][$competeKey]['count'] / $Num, 4) * (100), 2);
        $compete[$type][$competeKey]['perce'] = $price;
        return $compete;
    }

}

?>