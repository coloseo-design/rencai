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

class msgNum_model extends model
{

    function getmsgNum($uid, $usertype, $data = array())
    {

        //  设置个人中心右上角用户名展示未读系统消息数
        $msgNum =   0;
        $arr    =   array();

        if ($uid) {

            //  未读系统消息
            $sysMsgNum  =   $this->select_num('sysmsg', array('fa_uid' => $uid, 'usertype' => $usertype, 'remind_status' => '0'));
            if ($sysMsgNum > 0) {
                $msgNum             +=  $sysMsgNum;
                $arr['sysmsgNum']   =   $sysMsgNum;
            }
            if (!empty($this->config['sy_chat_open']) && $this->config['sy_chat_open'] == 1) {
                // 未读聊天条数
                // 根据后台设置聊天记录查询日期时限来查询
                $day        =   !empty($this->config['sy_chat_day']) ? $this->config['sy_chat_day'] : 30;
                $time       =   strtotime('-' . $day . ' day') * 1000;
                $chatNum    =   $this->select_num('chat_log', array('to' => $uid, 'tusertype' => $usertype, 'status' => 2, 'sendTime' => array('>', $time)));
                if ($chatNum > 0) {
                    $msgNum         +=  $chatNum;
                    $arr['chatNum'] =   $chatNum;
                }
            }

            if ($_COOKIE['couponOT'] && $_COOKIE['couponOT'] == $uid) {

                $arr['couponNum']   =   0;
            } else {

                $couponNum          =   $this->select_num('coupon_list', array('uid' => $uid, 'validity' => array(array('>', time()), array('<', strtotime('+ ' . $this->config['sy_couponday'] . ' days'), 'AND')), 'status' => 1));
                $arr['couponNum']   =   $couponNum;

                if ($usertype == 2 || $usertype == 3) {

                    require_once('cookie.model.php');
                    $cookieM = new cookie_model($this->db, $this->def);
                    $cookieM->setcookie('couponOT', $uid, strtotime(date('Y-m-d', strtotime('+1 day'))));
                }
            }

            if ($usertype == 1) {
                //  邀请面试
                $userid_msg         =   $this->select_num('userid_msg', array('uid' => $uid,'isdel'=>9,'is_browse' => '1'));
                if ($userid_msg > 0) {
                    $msgNum                 +=  $userid_msg;
                    $arr['userid_msgNum']   =   $userid_msg;
                }
                //  求职咨询
                $usermsg            =   $this->select_num('msg', array('uid' => $uid, 'status' => 1, 'user_remind_status' => '0'));
                if ($usermsg > 0) {
                    $msgNum                 +=  $usermsg;
                    $arr['usermsgNum']      =   $usermsg;
                }
                // 邀请面试总数量
                $yqnum              =   $this->select_num('userid_msg', array('uid' => $uid,'isdel'=>9));
                $arr['yqnum']       =   $yqnum;

                // 未读邀请面试数量
                $wkyqnum            =   $this->select_num('userid_msg', array('uid' => $uid,'is_browse'=>'1','isdel'=>9));
                $arr['wkyqnum']     =   $wkyqnum;

                // 申请职位数量
                $sq_nums            =   $this->select_num('userid_job', array('uid' => $uid,'isdel'=>9));
                $arr['sq_jobnum']   =   $sq_nums;

                // 收藏的职位数量
                $favwhere['uid']    =   $uid;
                if ($data['type']) {//小程序只显示普通职位
                    $favwhere['type']   =   $data['type'];
                }
                $fav_jobnum         =   $this->select_num('fav_job', $favwhere);
                $arr['fav_jobnum']  =   $fav_jobnum;

                // 关注数量
                require_once('atn.model.php');
                $atnM   =   new atn_model($this->db, $this->def);

                $where['uid']               =   $uid;
                $where['sc_usertype']       =   '2';
                $where['PHPYUNBTWSTART_A']  =   '';
                $where['xjhid'][]           =   array('=', 0);
                $where['xjhid'][]           =   array('isnull', '', 'OR');
                $where['PHPYUNBTWEND_A']    =   '';
                $atncomnum                  =   $atnM->getAtnNum($where);

                $atnltnum                   =   $atnM->getAtnNum(array('uid' => $uid, 'sc_usertype' => '3'));
                $atnacademynum              =   $atnM->getAtnNum(array('uid' => $uid, 'sc_usertype' => '5'));
                $atnxjhnum                  =   $atnM->getAtnNum(array('uid' => $uid, 'sc_usertype' => '2', 'xjhid' => array('<>', '')));

                $atn_num                =   $atncomnum + $atnltnum + $atnacademynum + $atnxjhnum;
                $arr['atn_num']         =   $atn_num;
            } elseif ($usertype == 2) {

                //职位申请数
                $jobApplyNum            =   $this->select_num('userid_job', array('com_id' => $uid,'isdel'=>9,'type' => array('<>', 3), 'is_browse' => '1'));
                if ($jobApplyNum > 0) {
                    $msgNum             +=  $jobApplyNum;
                    $arr['jobApplyNum'] =   $jobApplyNum;
                }

                //求职咨询数
                $qzwhere['job_uid']         =   $uid;
                $qzwhere['status']          =   1;
                $qzwhere['del_status']      =   array('<>', '1');
                $qzwhere['PHPYUNBTWSTART']  =   '';
                $qzwhere['reply'][]         =   array('isnull');
                $qzwhere['reply'][]         =   array('=', '', 'OR');
                $qzwhere['PHPYUNBTWEND']    =   '';
                $jobAskNum                  =   $this->select_num('msg', $qzwhere);
                if ($jobAskNum > 0) {
                    $msgNum             +=  $jobAskNum;
                    $arr['jobAskNum']   =   $jobAskNum;
                }

                //赏金投递数
                if ($data['from'] == 'wxapp') {

                    $jobpackNum         =   $this->select_num('company_job_rewardlist', array('comid' => $uid, 'usertype' => '1', 'status' => '0'));
                } else {

                    $jobpackNum         =   $this->select_num('company_job_rewardlist', array('comid' => $uid, 'status' => '0'));
                }
                if ($jobpackNum > 0) {
                    $msgNum             +=  $jobpackNum;
                    $arr['jobpackNum']  =   $jobpackNum;
                }

                //面试评价数
                $company_msg            =   $this->select_once('company_msg', array('cuid' => $uid, 'status' => 1, 'orderby' => 'ctime,desc'));
                if ($company_msg) {

                    $ComMsgNum          =   $this->select_num('company_msg', array('cuid' => $uid, 'status' => 1, 'reply' => ''));

                    if ($ComMsgNum > 0) {

                        $msgNum             += $ComMsgNum;
                        $arr['ComMsgNum']   =   $ComMsgNum;
                    }
                }

                $sqnum                  =   $this->select_num('userid_job', array('com_id' => $uid,'isdel'=>9,'type' => array('<>', 3)));
                $arr['sqnum']           =   $sqnum;

                $invite_num             =   $this->select_num('userid_msg', array('fid' => $uid,'isdel'=>9));
                $arr['invite_num']      =   $invite_num;

                $msgnum                 =   $this->select_num('msg', array('job_uid' => $uid, 'status' => 1));
                $arr['msgnum']          =   $msgnum;

                $attention_menum        =   $this->select_num('atn', array('sc_uid' => $uid));
                $arr['attention_menum'] =   $attention_menum;

                $companyjobnum          =   $this->select_num('company_job', array('uid' => $uid, 'state' => 1, 'status' => 0, 'r_status' => 1));
                $arr['companyjobnum']   =   $companyjobnum;

                $arr['look_jobnum']     =   $this->select_num('look_job', array('com_id' => $uid));

                $talent_pool_num        =   $this->select_num('talent_pool', array('cuid' => $uid));
                $arr['talent_pool_num'] =   $talent_pool_num;

                require_once 'company.model.php';
                $comM           =   new company_model($this->db, $this->def);
                $hitsExpour     =   $comM->getHitsExpoure($uid);
                $arr['hits']    =   $hitsExpour['hits'];
                $arr['expoure'] =   $hitsExpour['expoure'];
            } elseif ($usertype == 3) {

                //应聘简历
                $userid_job     =   $this->select_num('userid_job', array('com_id' => $uid,'isdel'=>9,'type' => 3, 'is_browse' => '1'));
                if ($userid_job > 0) {
                    $msgNum                 +=  $userid_job;
                    $arr['userid_jobNum']   =   $userid_job;
                }

                //委托简历
                $entrust        =   $this->select_num('entrust', array('lt_uid' => $uid, 'remind_status' => '0'));
                if ($entrust > 0) {
                    $msgNum             +=  $entrust;
                    $arr['entrustNum']  =   $entrust;
                }

                //求职咨询
                $msg            = $this->select_num('msg', array('job_uid' => $uid, 'status' => 1, 'type' => 3, 'com_remind_status' => '0'));
                if ($msg > 0) {
                    $msgNum             +=  $msg;
                    $arr['commsgNum']   =   $msg;
                }
                $downnum        =   $this->select_num('down_resume', array('comid' => $uid, 'usertype' => 3,'isdel'=>9));
                $arr['downnum'] =   $downnum;

                $ypnum          =   $this->select_num('userid_job', array('com_id' => $uid, 'type' => 3,'isdel'=>9));
                $arr['ypnum']   =   $ypnum;

                $jobnum         =   $this->select_num('lt_job', array('uid' => $uid, 'status' => '1', 'zp_status' => array('<>', '1')));
                $arr['jobnum']  =   $jobnum;
            } elseif ($usertype == 4) {

                //咨询留言
                $message        =   $this->select_num('px_zixun', array('s_uid' => $uid, 'status' => '1'));
                if ($message > 0) {
                    $msgNum             +=  $message;
                    $arr['messageNum']  =   $message;
                }
                //课程预约
                $sign_up        =   $this->select_num('px_baoming', array('s_uid' => $uid, 'status' => '0'));
                if ($sign_up > 0) {
                    $msgNum             +=  $sign_up;
                    $arr['sign_upNum']  =   $sign_up;
                }
                //课程数目
                $subject_num        =   $this->select_num('px_subject', array('uid' => $uid));
                $arr['subject_num'] =   $subject_num;

                //课程预约数目
                $baoming_num        =   $this->select_num('px_baoming', array('s_uid' => $uid));
                $arr['baoming_num'] =   $baoming_num;

                //咨询留言数目
                $zixun_num          =   $this->select_num('px_zixun', array('s_uid' => $uid));
                $arr['zixun_num']   =   $zixun_num;
            }
        }
        $arr['usertype']    =   $usertype;
        $arr['msgNum']      =   $msgNum;
        return $arr;
    }

    /**
     * @desc 设置管理后台右上角用户名展示未审核消息数
     */
    function msgNum()
    {

        $msgNum =   0;
        $arr    =   array();

        //待审核企业
        $company                =   $this->select_num('company', array('r_status' => '0'));
        if ($company > 0) {
            $msgNum             +=  $company;
            $arr['company']     =   $company;
        }

        //待审核职位
        $company_job            =   $this->select_num('company_job', array('state' => '0'));
        if ($company_job > 0) {
            $msgNum             +=  $company_job;
            $arr['company_job'] =   $company_job;
        }

        //待审核兼职
        $partjob                =   $this->select_num('partjob', array('state' => '0'));
        if ($partjob > 0) {
            $msgNum             +=  $partjob;
            $arr['partjob']     =   $partjob;
        }

        //待审核企业认证
        $company_cert           =   $this->select_num('company_cert', array('status' => '0', 'type' => '3'));
        if ($company_cert > 0) {
            $msgNum             +=  $company_cert;
            $arr['company_cert']=   $company_cert;
        }

        //待审核企业logo
        $comlogo                = $this->select_num('company', array('logo' => array('<>', ''), 'logo_status' => '1'));
        if ($comlogo > 0) {
            $msgNum             +=  $comlogo;
            $arr['comlogo']     =   $comlogo;
        }
        //待审核企业环境
        $comshow                =   $this->select_num('company_show', array('picurl' => array('<>', ''), 'status' => '1'));
        if ($comshow > 0) {
            $msgNum             +=  $comshow;
            $arr['comshow']     =   $comshow;
        }
        //待审核企业横幅
        $combanner              =   $this->select_num('banner', array('pic' => array('<>', ''), 'status' => '1'));
        if ($combanner > 0) {
            $msgNum             +=  $combanner;
            $arr['combanner']   =   $combanner;
        }

        //待审核企业产品
        $company_product            =   $this->select_num('company_product', array('status' => '0'));
        if ($company_product > 0) {
            $msgNum                 +=  $company_product;
            $arr['company_product'] =   $company_product;
        }

        //待审核发票
        $invoice                =   $this->select_num('invoice_record', array('status' => '0'));
        if ($invoice > 0) {
            $msgNum             +=  $invoice;
            $arr['invoiceNum']  =   $invoice;
        }

        //待审核企业新闻
        $company_news           =   $this->select_num('company_news', array('status' => '0'));
        if ($company_news > 0) {
            $msgNum             +=  $company_news;
            $arr['company_news']=   $company_news;
        }

        //待审核个人
        $user                   =   $this->select_num('resume', array('r_status' => '0'));
        if ($user > 0) {
            $msgNum             +=  $user;
            $arr['userNum']     =   $user;
        }

        //待审核简历
        $resume_expect              =   $this->select_num('resume_expect', array('state' => '0'));
        if ($resume_expect > 0) {
            $msgNum                 +=  $resume_expect;
            $arr['resume_expect']   =   $resume_expect;
        }

        //待审核委托简历
        $resumetrust                =   $this->select_num('user_entrust', array('status' => '0'));
        if ($resumetrust > 0) {
            $msgNum                 +=  $resumetrust;
            $arr['resumetrust']     =   $resumetrust;
        }

        //错误日志
        $errlog                     =   $this->select_num('error_log', array('isread' => 0));

        if ($errlog > 0) {
            $msgNum                 +=  $errlog;
            $arr['errlog']          =   $errlog;
        }

        //待审核网络招聘会报名
        $zphnetcomtrust             =   $this->select_num('zphnet_com', array('status' => '0'));
        if ($zphnetcomtrust > 0) {
            $msgNum                 +=  $zphnetcomtrust;
            $arr['zphnetcomtrust']  =   $zphnetcomtrust;
        }
        //待审核优质简历
        $heightuser                 =   $this->select_num('resume_expect', array('height_status' => '1'));
        if ($heightuser > 0) {
            $msgNum                 +=  $heightuser;
            $arr['ltheightuser']    =   $heightuser;
        }

        //待审核个人认证
        $usercertNum                =   $this->select_num('resume', array('idcard_pic' => array('<>', ''), 'idcard_status' => '0'));
        if ($usercertNum > 0) {
            $msgNum                 +=  $usercertNum;
            $arr['usercertNum']     =   $usercertNum;
        }

        //待审核猎头
        $lt                         =   $this->select_num('lt_info', array('r_status' => '0'));
        if ($lt > 0) {
            $msgNum                 +=  $lt;
            $arr['ltNum']           =   $lt;
        }

        //待审核猎头认证
        $ltcert_n                   =   $this->select_all('lt_info');
        $ltcertuids                 =   array();
        foreach ($ltcert_n as $val) {
            $ltcertuids[]           =   $val['uid'];
        }
        $ltcert                     =   $this->select_num('company_cert', array('type' => '4', 'status' => '0', 'uid' => array('in', pylode(',', $ltcertuids))));
        if ($ltcert > 0) {
            $msgNum                 +=  $ltcert;
            $arr['ltcert']          =   $ltcert;
        }

        //待审核猎头职位
        $lt_job                     =   $this->select_num('lt_job', array('status' => '0'));
        if ($lt_job > 0) {
            $msgNum                 +=  $lt_job;
            $arr['ltjob']           =   $lt_job;
        }

        //待审核猎头logo
        $ltlogo                     =   $this->select_num('lt_info', array('photo_big' => array('<>', ''), 'photo_status' => '1'));
        if ($ltlogo > 0) {
            $msgNum                 +=  $ltlogo;
            $arr['ltlogo']          =   $ltlogo;
        }

        //待审核培训
        $train                      =   $this->select_num('px_train', array('r_status' => '0'));
        if ($train > 0) {
            $msgNum                 +=  $train;
            $arr['trainNum']        =   $train;
        }

        //待审核培训讲师
        $teacher                    =   $this->select_num('px_teacher', array('status' => '0'));
        if ($teacher > 0) {
            $msgNum                 +=  $teacher;
            $arr['teacher']         =   $teacher;
        }
        //待审核培训课程
        $subject                    =   $this->select_num('px_subject', array('status' => '0'));
        if ($subject > 0) {
            $msgNum                 +=  $subject;
            $arr['subject']         =   $subject;
        }

        //待审核培训认证
        $traincert_n                =   $this->select_all('px_train');
        $traincertuids              =   array();
        foreach ($traincert_n as $val) {
            $traincertuids[]        =   $val['uid'];
        }

        $traincert                  =   $this->select_num('company_cert', array('type' => '5', 'status' => '0', 'uid' => array('in', pylode(',', $traincertuids))));
        if ($traincert > 0) {
            $msgNum                 +=  $traincert;
            $arr['traincert']       =   $traincert;
        }

        //待审核培训新闻
        $trainnews                  =   $this->select_num('px_train_news', array('status' => '0'));
        if ($trainnews > 0) {
            $msgNum                 +=  $trainnews;
            $arr['trainnews']       =   $trainnews;
        }

        //待审核培训logo
        $pxlogo                     =   $this->select_num('px_train', array('logo' => array('<>', ''), 'logo_status' => '1'));
        if ($pxlogo > 0) {
            $msgNum                 +=  $pxlogo;
            $arr['pxlogo']          =   $pxlogo;
        }

        //待审核培训环境
        $pxshow                     =   $this->select_num('px_train_show', array('picurl' => array('<>', ''), 'status' => '1'));
        if ($pxshow > 0) {
            $msgNum                 +=  $pxshow;
            $arr['pxshow']          =   $pxshow;
        }
        //待审核培训横幅
        $pxbanner                   =   $this->select_num('px_banner', array('pic' => array('<>', ''), 'status' => '1'));
        if ($pxbanner > 0) {
            $msgNum                 +=  $pxbanner;
            $arr['pxbanner']        =   $pxbanner;
        }

        //会员申诉
        $appealnum                  =   $this->select_num('member', array('appealtime' => array('>', '0'), 'appealstate' => '1'));
        if ($appealnum > 0) {
            if (!$this->config['did'] || $this->config['did'] == 0) {
                $msgNum             +=  $appealnum;
            }
            $arr['appealnum']       =   $appealnum;
        }

        //待审核店铺招聘
        $once_job                   =   $this->select_num('once_job', array('status' => '0', 'edate' => array('>', time())));
        if ($once_job > 0) {
            $msgNum                 +=  $once_job;
            $arr['once_job']        =   $once_job;
        }

        //待审核普工简历
        $tiny                       =   $this->select_num('resume_tiny', array('status' => '0'));
        if ($tiny > 0) {
            $msgNum                 +=  $tiny;
            $arr['tiny']            =   $tiny;
        }

        //待审核赏金提现
        $withdrawNum                =   $this->select_num('member_withdraw', array('order_state' => '0'));
        if ($withdrawNum > 0) {
            $msgNum                 +=  $withdrawNum;
            $arr['withdrawNum']     =   $withdrawNum;
        }

        //待审核应届毕业生职位
        $schooljob                  =   $this->select_num('company_job', array('is_graduate' => '1', 'state' => '0'));
        if ($schooljob > 0) {
            $msgNum                 +=  $schooljob;
            $arr['schooljob']       =   $schooljob;
        }

        //待审核宣讲会
        $schoolxjh                  =   $this->select_num('school_xjh', array('status' => '0'));
        if ($schoolxjh > 0) {
            $msgNum                 +=  $schoolxjh;
            $arr['schoolxjh']       =   $schoolxjh;
        }

        //待审核参会企业
        $zphcom                     =   $this->select_num('zhaopinhui_com', array('status' => '0'));
        if ($zphcom > 0) {
            $msgNum                 +=  $zphcom;
            $arr['zphcom']          =   $zphcom;
        }

        //待审核问答
        $ask                        =   $this->select_num('question', array('state' => '0'));
        if ($ask > 0) {
            $msgNum                 +=  $ask;
            $arr['ask']             =   $ask;
        }

        //待付款订单
        $order                      =   $this->select_num('company_order', array('order_state' => '1'));
        if ($order > 0) {
            $msgNum                 +=  $order;
            $arr['order']           =   $order;
        }

        //待确认授课订单
        $adorder                    =   $this->select_num('ad_order', array('status' => '0'));
        if ($adorder > 0) {
            $msgNum                 +=  $adorder;
            $arr['adorder']         =   $adorder;
        }

        //待处理举报职位
        $rjwhere['usertype']        =   1;
        $rjwhere['type']            =   0;
		$rjwhere['status']			=	0;
        $rjwhere['PHPYUNBTWSTART']  =   '';
        $rjwhere['result'][]        =   array('=', '');
        $rjwhere['result'][]        =   array('isnull', '', 'OR');
        $rjwhere['PHPYUNBTWEND']    =   '';
        $reportjob                  =   $this->select_num('report', $rjwhere);
        if ($reportjob > 0) {
            $msgNum                 +=  $reportjob;
            $arr['reportjob']       =   $reportjob;
        }

        //待处理举报简历
        $rrwhere['usertype']        =   2;
        $rrwhere['type']            =   0;
		$rrwhere['status']			=	0;
        $rrwhere['PHPYUNBTWSTART']  =   '';
        $rrwhere['result'][]        =   array('=', '');
        $rrwhere['result'][]        =   array('isnull', '', 'OR');
        $rrwhere['PHPYUNBTWEND']    =   '';
        $reportresume               =   $this->select_num('report', $rrwhere);
        if ($reportresume > 0) {
            $msgNum                 +=  $reportresume;
            $arr['reportresume']    =   $reportresume;
        }
        //待处理举报问答
        $rtwhere['status']          =   0;
        $rtwhere['type']            =   1;
		$rtwhere['status']			=	0;
        $rtwhere['PHPYUNBTWSTART']  =   '';
        $rtwhere['result'][]        =   array('=', '');
        $rtwhere['result'][]        =   array('isnull', '', 'OR');
        $rtwhere['PHPYUNBTWEND']    =   '';
        $reportask                  =   $this->select_num('report', $rtwhere);
        if ($reportask > 0) {
            $msgNum                 +=  $reportask;
            $arr['reportask']       =   $reportask;
        }
        //待处理举报顾问
        $rgwhere['status']          =   0;
        $rgwhere['type']            =   2;
		$rgwhere['status']			=	0;
        $rgwhere['PHPYUNBTWSTART']  =   '';
        $rgwhere['result'][]        =   array('=', '');
        $rgwhere['result'][]        =   array('isnull', '', 'OR');
        $rgwhere['PHPYUNBTWEND']    =   '';
        $reportgw                   =   $this->select_num('report', $rgwhere);
        if ($reportgw > 0) {
            $msgNum                 +=  $reportgw;
            $arr['reportgw']        =   $reportgw;
        }
        //  待处理纠错宣讲会
        $rxwhere['status']          =   0;
        $rxwhere['type']            =   3;
		$rxwhere['status']			=	0;
        $rxwhere['PHPYUNBTWSTART']  =   '';
        $rxwhere['result'][]        =   array('=', '');
        $rxwhere['result'][]        =   array('isnull', '', 'OR');
        $rxwhere['PHPYUNBTWEND']    =   '';
        $reportxjh                  =   $this->select_num('report', $rxwhere);
        if ($reportxjh > 0) {
            $msgNum                 +=  $reportxjh;
            $arr['reportxjh']       =   $reportxjh;
        }

        //待审核个人头像
        $userpic                    =   $this->select_num('resume', array('photo' => array('<>', ''),'defphoto'=>1,'photo_status' => '1'));
        if ($userpic > 0) {
            $msgNum                 +=  $userpic;
            $arr['userpic']         =   $userpic;
        }
        //待审核个人作品
        $usershow                   =   $this->select_num('resume_show', array('picurl' => array('<>', ''), 'status' => '1'));
        if ($usershow > 0) {
            $msgNum                 +=  $usershow;
            $arr['usershow']        =   $usershow;
        }
        //待审核供求会员
        $gq_u                       =   $this->select_all('member', array('status' => '0', 'usertype' => '5'));
        $gquids                     =   array();
        foreach ($gq_u as $val) {
            $gquids[]               =   $val['uid'];
        }
        $gqinfo                     =   $this->select_num('gq_info', array('uid' => array('in', pylode(',', $gquids))));
        if ($gqinfo > 0) {
            $msgNum                 +=  $gqinfo;
            $arr['gqNum']           =   $gqinfo;
        }
        //待审核供求头像
        $gqpic                      =   $this->select_num('gq_info', array('photo' => array('<>', ''), 'photo_status' => '1'));
        if ($gqpic > 0) {
            $msgNum                 +=  $gqpic;
            $arr['gqpic']           =   $gqpic;
        }
        //待审核项目任务
        $gqtask                     =   $this->select_num('gq_task', array('status' => '0'));
        if ($gqtask > 0) {
            $msgNum                 +=  $gqtask;
            $arr['gqtask']          =   $gqtask;
        }
        if (!$this->config['did']) {
            //待审核友情链接
            $linkNum                =   $this->select_num('admin_link', array('link_state' => '0'));
            if ($linkNum > 0) {
                $msgNum             +=  $linkNum;
                $arr['linkNum']     =   $linkNum;
            }
            //待审核商品兑换
            $redeem                 =   $this->select_num('change', array('status' => '0'));
            if ($redeem > 0) {
                $msgNum             +=  $redeem;
                $arr['redeem']      =   $redeem;
            }
            //待付款订单
            $specialcom             =   $this->select_num('special_com', array('status' => '0'));
            if ($specialcom > 0) {
                $msgNum             +=  $specialcom;
                $arr['specialcom']  =   $specialcom;
            }
            //待审核转换申请
            $userchangenum              =   $this->select_num('user_change', array('status' => '0'));
            if ($userchangenum > 0) {
                $msgNum                 +=  $userchangenum;
                $arr['userchangenum']   =   $userchangenum;
            }
            //待处理意见反馈
            $handlenum              =   $this->select_num('advice_question', array('status' => '1'));
            if ($handlenum > 0) {
                $msgNum             +=  $handlenum;
                $arr['handlenum']   =   $handlenum;
            }
        }
        //待处理注销账号
        $logout                     =   $this->select_num('member_logout', array('status' => 1));
        if ($logout > 0) {
            $msgNum                 +=  $logout;
            $arr['logout']          =   $logout;
        }
        //待审核视频面试
        $spview                     =   $this->select_num('spview', array('status' => 0));
        if ($spview > 0) {
            $msgNum                 +=  $spview;
            $arr['spview']          =   $spview;
        }
        //待审核面试评价
        $company_msg                =   $this->select_num('company_msg', array('status' => 0));
        if ($company_msg > 0) {
            $msgNum                 +=  $company_msg;
            $arr['company_msg']     =   $company_msg;
        }

        //待审核面试模板
        $yqmb_msg                   =   $this->select_num('yqmb', array('status' => 0));
        if ($yqmb_msg > 0) {
            $msgNum                 +=  $yqmb_msg;
            $arr['yqmb_msg']         =  $yqmb_msg;
        }

        //待审核求职咨询
        $usermsg_msg                =   $this->select_num('msg', array('status' => 0));
        if ($usermsg_msg > 0) {
            $msgNum                 +=  $usermsg_msg;
            $arr['usermsg_msg']     =   $usermsg_msg;
        }

        //待审核问答回复
        $answer_msg                 =   $this->select_num('answer', array('status' => 0));
        if ($answer_msg > 0) {
            $msgNum                 +=  $answer_msg;
            $arr['answer_msg']      =   $answer_msg;
        }

        //待审核问答评价
        $answerreview_msg           =   $this->select_num('answer_review', array('status' => 0));
        if ($answerreview_msg > 0) {
            $msgNum                 +=  $answerreview_msg;
            $arr['answerreview_msg']=   $answerreview_msg;
        }

        //待处理内容检测
        $concheck_msg           =   $this->select_num('concheck_log', array('status' => 0));
        if ($concheck_msg > 0) {
            $msgNum                 +=  $concheck_msg;
            $arr['concheck_msg']=   $concheck_msg;
        }
        if (!empty($this->config['sy_chat_open']) && $this->config['sy_chat_open'] == 1) {
            // 未读聊天条数
            // 根据后台设置聊天记录查询日期时限来查询
            $day        =   !empty($this->config['sy_chat_day']) ? $this->config['sy_chat_day'] : 30;
            $time       =   strtotime('-' . $day . ' day') * 1000;
            $chatNum    =   $this->select_num('chat_log', array('to' => $_SESSION['auid'], 'tusertype' => 9, 'status' => 2, 'sendTime' => array('>', $time)));
            if ($chatNum > 0) {
                $arr['chatNum'] =   $chatNum;
            }
        }
        $arr['msgNum']  =   $msgNum;
        return json_encode($arr);
    }

    function companyNum()
    {

        $arr    =   array();

        //企业总数
        $companyAllNum      =   $this->select_num('company');
        if ($companyAllNum > 0) {
            $arr['companyAllNum']       =   $companyAllNum;
        }

        //待审核企业
        $companyStatusNum1  =   $this->select_num('company', array('r_status' => '0'));
        if ($companyStatusNum1 > 0) {
            $arr['companyStatusNum1']   =   $companyStatusNum1;
        }

        //未通过企业
        $companyStatusNum2 =    $this->select_num('company', array('r_status' => '3'));
        if ($companyStatusNum2 > 0) {
            $arr['companyStatusNum2']   =   $companyStatusNum2;
        }

        //锁定企业
        $companyStatusNum3 =    $this->select_num('company', array('r_status' => '2'));
        if ($companyStatusNum3 > 0) {
            $arr['companyStatusNum3']   =   $companyStatusNum3;
        }
        return json_encode($arr);
    }

    function hotNum()
    {

        $arr    =   array();
        //名企总数
        $hotAllNum  =   $this->select_num('hotjob');
        if ($hotAllNum > 0) {
            $arr['hotAllNum']   =   $hotAllNum;
        }
        //已过期名企
        $hoted      =   $this->select_num('hotjob', array('time_end' => array('<=', time())));
        if ($hoted > 0) {
            $arr['hoted']       =   $hoted;
        }

        return json_encode($arr);
    }

    function comCertNum()
    {
        $arr    =   array();
        //企业认证总数
        $comCertAll =   $this->select_num('company_cert', array('type' => '3'));
        if ($comCertAll > 0) {
            $arr['comCertAll']  =   $comCertAll;
        }
        //未审核企业认证
        $comCert1   =   $this->select_num('company_cert', array('type' => '3', 'status' => '0'));
        if ($comCert1 > 0) {
            $arr['comCert1']    =   $comCert1;
        }
        //未通过认证
        $comCert2   =   $this->select_num('company_cert', array('type' => '3', 'status' => '2'));
        if ($comCert2 > 0) {
            $arr['comCert2']    =   $comCert2;
        }

        return json_encode($arr);
    }

    function jobNum()
    {
        $arr    =   array();

        //职位总数
        $jobAllNum      =   $this->select_num('company_job');
        if ($jobAllNum > 0) {
            $arr['jobAllNum']       =   $jobAllNum;
        }
        //待审核职位
        $jobStatusNum1  =   $this->select_num('company_job', array('state' => '0'));
        if ($jobStatusNum1 > 0) {
            $arr['jobStatusNum1']   =   $jobStatusNum1;
        }
        // 未通过职位
        $jobStatusNum2  =   $this->select_num('company_job', array('state' => '3'));
        if ($jobStatusNum2 > 0) {
            $arr['jobStatusNum2']   =   $jobStatusNum2;
        }
        //下架职位
        $jobStatusNum3  =   $this->select_num('company_job', array('status' => '1'));
        if ($jobStatusNum3 > 0) {
            $arr['jobStatusNum3']   =   $jobStatusNum3;
        }

        return json_encode($arr);
    }

    function partNum()
    {

        $arr    =   array();
        //兼职总数
        $partAllNum     =   $this->select_num('partjob');
        if ($partAllNum > 0) {
            $arr['partAllNum']      =   $partAllNum;
        }
        //待审核兼职
        $partStatusNum1 =   $this->select_num('partjob', array('state' => '0'));
        if ($partStatusNum1 > 0) {
            $arr['partStatusNum1']  =   $partStatusNum1;
        }
        //未通过兼职
        $partStatusNum2 =   $this->select_num('partjob', array('state' => '3'));
        if ($partStatusNum2 > 0) {
            $arr['partStatusNum2']  =   $partStatusNum2;
        }
        //已过期兼职
        $ewhere =   array(
            'PHPYUNBTWSTART_A'  =>  '',
            'edate'             =>  array(
                '0' =>  array('<', time(), 'AND'),
                '1' =>  array('>', '0', 'AND')
            ),
            'PHPYUNBTWEND_A'    =>  '',
        );
        $partStatusNum3             =   $this->select_num('partjob', $ewhere);
        if ($partStatusNum3 > 0) {
            $arr['partStatusNum3']  =   $partStatusNum3;
        }
        return json_encode($arr);
    }

    function orderSum($where=array())
    {
        $order_state_where = isset($where['order_state'])?$where['order_state']:'';
        unset($where['order_state']);
        if($order_state_where!=''){
            $where['order_state'][]= array('=',$order_state_where);
        }
        

        $arr = array(); 
        //订单总额
        $where1 = $where;

        $where1['order_price'] = array('>','0');

        $orderAll = $this->select_once('company_order',$where1, 'sum(`order_price`) as `pricesum`');
        if ($orderAll['pricesum'] > 0) {
            $arr['orderPriceAll'] = $orderAll['pricesum'];
        }
        //已支付金额
        $where2 = $where;
        $where2['order_price'] = array('>','0');
        $where2['order_state'][] = array('=',2,'and');
        
        $orderPayed = $this->select_once('company_order',$where2, 'sum(`order_price`) as `orderPayed`');
        
        if ($orderPayed['orderPayed'] > 0) {
            $arr['orderPayed'] = $orderPayed['orderPayed'];
        }
        //待支付金额
        $where3 = $where;
        $where3['order_price'] = array('>','0');
        $where3['order_state'][] = array('=',1,'and');
        $orderPay = $this->select_once('company_order',$where3, 'sum(`order_price`) as `orderPay`');
        if ($orderPay['orderPay'] > 0) {
            $arr['orderPay'] = $orderPay['orderPay'];
        }
        //等待确认金额
        $where4 = $where;
        $where4['order_price'] = array('>','0');
        $where4['order_state'][] = array('=',3,'and');
        $orderPaying = $this->select_once('company_order',$where4, 'sum(`order_price`) as `orderPaying`');
        if ($orderPaying['orderPaying'] > 0) {
            $arr['orderPaying'] = $orderPaying['orderPaying'];
        }

        return json_encode($arr);
    }

    function userNum()
    {
        $arr = array();
        //个人总数
        $userAllNum = $this->select_num('resume');
        if ($userAllNum > 0) {
            $arr['userAllNum'] = $userAllNum;
        }
        //待审核个人
        $userStatusNum1 = $this->select_num('resume', array('r_status' => '0'));
        if ($userStatusNum1 > 0) {
            $arr['userStatusNum1'] = $userStatusNum1;
        }
        //未通过个人
        $userStatusNum2 = $this->select_num('resume', array('r_status' => '3'));
        if ($userStatusNum2 > 0) {
            $arr['userStatusNum2'] = $userStatusNum2;
        }
        //锁定个人
        $userStatusNum3 = $this->select_num('resume', array('r_status' => '2'));
        if ($userStatusNum3 > 0) {
            $arr['userStatusNum3'] = $userStatusNum3;
        }
        return json_encode($arr);
    }

    function gqNum()
    {
        $arr = array();
        //供求总数
        $gqAllNum = $this->select_num('gq_info', array('state' => 1));
        if ($gqAllNum > 0) {
            $arr['gqAllNum'] = $gqAllNum;
        }
        //待审核供求
        $gqStatusNum1 = $this->select_num('gq_info', array('status' => '0', 'state' => '1'));

        if ($gqStatusNum1 > 0) {
            $arr['gqStatusNum1'] = $gqStatusNum1;
        }
        //未通过供求
        $gqStatusNum2 = $this->select_num('gq_info', array('status' => '3', 'state' => '1'));
        if ($gqStatusNum2 > 0) {
            $arr['gqStatusNum2'] = $gqStatusNum2;
        }
        //锁定供求
        $gqStatusNum3 = $this->select_num('gq_info', array('r_status' => '2', 'state' => '1'));
        if ($gqStatusNum3 > 0) {
            $arr['gqStatusNum3'] = $gqStatusNum3;
        }
        return json_encode($arr);
    }

    function resumeNum()
    {
        $arr = array();
        //简历总数
        $resumeAllNum = $this->select_num('resume_expect');
        if ($resumeAllNum > 0) {
            $arr['resumeAllNum'] = $resumeAllNum;
        }
        //待审核简历
        $resumeStatusNum1 = $this->select_num('resume_expect', array('state' => '0'));
        if ($resumeStatusNum1 > 0) {
            $arr['resumeStatusNum1'] = $resumeStatusNum1;
        }
        //未通过简历
        $resumeStatusNum2 = $this->select_num('resume_expect', array('state' => '3'));
        if ($resumeStatusNum2 > 0) {
            $arr['resumeStatusNum2'] = $resumeStatusNum2;
        }
        //锁定简历
        $resumeStatusNum3 = $this->select_num('resume_expect', array('r_status' => '2'));
        if ($resumeStatusNum3 > 0) {
            $arr['resumeStatusNum3'] = $resumeStatusNum3;
        }

        //未成年
        $datetime=strtotime('-16 years');
        $resumeTeenNum = $this->select_num('resume_expect', array('birthday' => array('unixtime','>',$datetime)));
        if ($resumeTeenNum > 0) {
            $arr['resumeTeenNum'] = $resumeTeenNum;
        }
        return json_encode($arr);
    }

    function idCardNum()
    {
        $arr = array();
        //个人认证总数
        $idCardAll = $this->select_num('resume', array('idcard_pic' => array('<>', ''), 'idcard_status' => '1'));
        if ($idCardAll > 0) {
            $arr['idCardAll'] = $idCardAll;
        }
        //未审核个人认证
        $idCardNum1 = $this->select_num('resume', array('idcard_pic' => array('<>', ''), 'idcard_status' => '0'));
        if ($idCardNum1 > 0) {
            $arr['idCardNum1'] = $idCardNum1;
        }
        //未通过身份认证
        $idCardNum2 = $this->select_num('resume', array('idcard_pic' => array('<>', ''), 'idcard_status' => '2'));
        if ($idCardNum2 > 0) {
            $arr['idCardNum2'] = $idCardNum2;
        }

        return json_encode($arr);
    }

    function trustNum()
    {
        $arr = array();
        //简历总数
        $resumeAllNum = $this->select_num('user_entrust');
        if ($resumeAllNum > 0) {
            $arr['resumeAllNum'] = $resumeAllNum;
        }
        //待审核委托
        $resumeStatusNum1 = $this->select_num('user_entrust', array('status' => '0'));
        if ($resumeStatusNum1 > 0) {
            $arr['resumeStatusNum1'] = $resumeStatusNum1;
        }
        //未接受委托
        $resumeStatusNum2 = $this->select_num('user_entrust', array('status' => '2'));
        if ($resumeStatusNum2 > 0) {
            $arr['resumeStatusNum2'] = $resumeStatusNum2;
        }

        return json_encode($arr);
    }

    function ltNum()
    {
        $arr = array();
        //lt会员总数
        $ltAllNum = $this->select_num('lt_info');
        if ($ltAllNum > 0) {
            $arr['ltAllNum'] = $ltAllNum;
        }
        //待审核猎头会员
        $ltStatusNum1 = $this->select_num('lt_info', array('r_status' => '0'));
        if ($ltStatusNum1 > 0) {
            $arr['ltStatusNum1'] = $ltStatusNum1;
        }
        //未通过猎头会员
        $ltStatusNum2 = $this->select_num('lt_info', array('r_status' => '3'));
        if ($ltStatusNum2 > 0) {
            $arr['ltStatusNum2'] = $ltStatusNum2;
        }
        //锁定猎头会员
        $ltStatusNum3 = $this->select_num('lt_info', array('r_status' => '2'));
        if ($ltStatusNum3 > 0) {
            $arr['ltStatusNum3'] = $ltStatusNum3;
        }
        return json_encode($arr);
    }

    function ltjobNum()
    {
        $arr = array();
        //lt职位总数
        $ltjobAllNum = $this->select_num('lt_job');
        if ($ltjobAllNum > 0) {
            $arr['ltjobAllNum'] = $ltjobAllNum;
        }
        //待审核lt职位
        $ltjobStatusNum1 = $this->select_num('lt_job', array('status' => '0'));
        if ($ltjobStatusNum1 > 0) {
            $arr['ltjobStatusNum1'] = $ltjobStatusNum1;
        }
        //未通过lt职位
        $ltjobStatusNum2 = $this->select_num('lt_job', array('status' => '3'));
        if ($ltjobStatusNum2 > 0) {
            $arr['ltjobStatusNum2'] = $ltjobStatusNum2;
        }
        return json_encode($arr);
    }

    function gresumeNum()
    {
        $arr = array();
        //优质人才简历总数
        $resumeAllNum = $this->select_num('resume_expect', array('height_status' => array('<>', '0')));
        if ($resumeAllNum > 0) {
            $arr['resumeAllNum'] = $resumeAllNum;
        }
        //待审核简历
        $resumeStatusNum1 = $this->select_num('resume_expect', array('height_status' => '1'));
        if ($resumeStatusNum1 > 0) {
            $arr['resumeStatusNum1'] = $resumeStatusNum1;
        }
        //未通过简历
        $resumeStatusNum2 = $this->select_num('resume_expect', array('height_status' => '3'));
        if ($resumeStatusNum2 > 0) {
            $arr['resumeStatusNum2'] = $resumeStatusNum2;
        }

        return json_encode($arr);
    }

    function ltcertNum()
    {
        $arr = array();
        //lt认证总数
        $ltCertAllNum = $this->select_num('company_cert', array('type' => '4'));
        if ($ltCertAllNum > 0) {
            $arr['ltCertAllNum'] = $ltCertAllNum;
        }
        //未审核lt认证
        $ltcertStatusNum1 = $this->select_num('company_cert', array('type' => '4', 'status' => '0'));
        if ($ltcertStatusNum1 > 0) {
            $arr['ltcertStatusNum1'] = $ltcertStatusNum1;
        }
        //未通过认证
        $ltcertStatusNum2 = $this->select_num('company_cert', array('type' => '4', 'status' => '2'));
        if ($ltcertStatusNum2 > 0) {
            $arr['ltcertStatusNum2'] = $ltcertStatusNum2;
        }

        return json_encode($arr);
    }

    function pxNum()
    {
        $arr = array();
        //PX总数
        $pxAllNum = $this->select_num('px_train');
        if ($pxAllNum > 0) {
            $arr['pxAllNum'] = $pxAllNum;
        }
        //未审核培训机构
        $pxStatusNum1 = $this->select_num('px_train', array('r_status' => '0'));
        if ($pxStatusNum1 > 0) {
            $arr['pxStatusNum1'] = $pxStatusNum1;
        }
        //未通过培训机构
        $pxStatusNum2 = $this->select_num('px_train', array('r_status' => '3'));
        if ($pxStatusNum2 > 0) {
            $arr['pxStatusNum2'] = $pxStatusNum2;
        }
        //锁定培训机构
        $pxStatusNum3 = $this->select_num('px_train', array('r_status' => '2'));
        if ($pxStatusNum3 > 0) {
            $arr['pxStatusNum3'] = $pxStatusNum3;
        }

        return json_encode($arr);
    }

    function teacherNum()
    {

        $arr = array();
        //讲师总数
        $teacherAllNum = $this->select_num('px_teacher');
        if ($teacherAllNum > 0) {
            $arr['teacherAllNum'] = $teacherAllNum;
        }
        //未审核讲师
        $teachStatusNum1 = $this->select_num('px_teacher', array('status' => '0'));
        if ($teachStatusNum1 > 0) {
            $arr['teachStatusNum1'] = $teachStatusNum1;
        }
        //未通过讲师
        $teachStatusNum2 = $this->select_num('px_teacher', array('status' => '2'));
        if ($teachStatusNum2 > 0) {
            $arr['teachStatusNum2'] = $teachStatusNum2;
        }

        return json_encode($arr);

    }

    function subjectNum()
    {
        $arr = array();
        //课程总数
        $subjectAllNum = $this->select_num('px_subject');
        if ($subjectAllNum > 0) {
            $arr['subjectAllNum'] = $subjectAllNum;
        }
        //未审核课程
        $subjectStatusNum1 = $this->select_num('px_subject', array('status' => '0'));
        if ($subjectStatusNum1 > 0) {
            $arr['subjectStatusNum1'] = $subjectStatusNum1;
        }
        //未通过课程
        $subjectStatusNum2 = $this->select_num('px_subject', array('status' => '2'));
        if ($subjectStatusNum2 > 0) {
            $arr['subjectStatusNum2'] = $subjectStatusNum2;
        }

        return json_encode($arr);

    }

    function pxcertNum()
    {
        $arr = array();
        //px认证总数
        $pxCertAllNum = $this->select_num('company_cert', array('type' => '5'));
        if ($pxCertAllNum > 0) {
            $arr['certAllNum'] = $pxCertAllNum;
        }
        //未审核px认证
        $certStatusNum1 = $this->select_num('company_cert', array('type' => '5', 'status' => '0'));
        if ($certStatusNum1 > 0) {
            $arr['certStatusNum1'] = $certStatusNum1;
        }
        //未通过认证
        $certStatusNum2 = $this->select_num('company_cert', array('type' => '5', 'status' => '2'));
        if ($certStatusNum2 > 0) {
            $arr['certStatusNum2'] = $certStatusNum2;
        }

        return json_encode($arr);
    }

    function onceNum()
    {
        $arr = array();
        //店铺总数
        $onceAllNum = $this->select_num('once_job');
        if ($onceAllNum > 0) {
            $arr['onceAllNum'] = $onceAllNum;
        }
        //未审核
        $onceStatusNum1 = $this->select_num('once_job', array('status' => '0', 'edate' => array('>', time())));
        if ($onceStatusNum1 > 0) {
            $arr['onceStatusNum1'] = $onceStatusNum1;
        }
        //已过期
        $onceStatusNum2 = $this->select_num('once_job', array('edate' => array('<', time())));
        if ($onceStatusNum2 > 0) {
            $arr['onceStatusNum2'] = $onceStatusNum2;
        }
        return json_encode($arr);
    }

    function tinyNum()
    {
        $arr = array();
        //普工总数
        $tinyAllNum = $this->select_num('resume_tiny');
        if ($tinyAllNum > 0) {
            $arr['tinyAllNum'] = $tinyAllNum;
        }
        //未审核
        $tinyStatusNum = $this->select_num('resume_tiny', array('status' => '0'));
        if ($tinyStatusNum > 0) {
            $arr['tinyStatusNum'] = $tinyStatusNum;
        }
        return json_encode($arr);
    }

    function sjobNum()
    {

        $arr    =   array();
        //应届生职位总数
        $jobAllNum = $this->select_num('company_job', array('is_graduate' => '1'));
        if ($jobAllNum > 0) {
            $arr['jobAllNum'] = $jobAllNum;
        }
        //待审核职位
        $jobStatusNum1 = $this->select_num('company_job', array('is_graduate' => '1', 'state' => '0'));
        if ($jobStatusNum1 > 0) {
            $arr['jobStatusNum1'] = $jobStatusNum1;
        }
        //未通过职位
        $jobStatusNum2 = $this->select_num('company_job', array('is_graduate' => '1', 'state' => '3'));
        if ($jobStatusNum2 > 0) {
            $arr['jobStatusNum2'] = $jobStatusNum2;
        }
        //下架职位
        $jobStatusNum3 = $this->select_num('company_job', array('is_graduate' => '1', 'status' => '1'));
        if ($jobStatusNum3 > 0) {
            $arr['jobStatusNum3'] = $jobStatusNum3;
        }

        return json_encode($arr);
    }

    function xjhNum()
    {
        $arr    =   array();
        //宣讲会总数
        $xjhAllNum      =   $this->select_num('school_xjh');
        if ($xjhAllNum > 0) {
            $arr['xjhAllNum']       =   $xjhAllNum;
        }
        //待审核宣讲会
        $xjhStatusNum1  =   $this->select_num('school_xjh', array('status' => '0'));
        if ($xjhStatusNum1 > 0) {
            $arr['xjhStatusNum1']   =   $xjhStatusNum1;
        }
        //未通过宣讲会
        $xjhStatusNum2  =   $this->select_num('school_xjh', array('status' => '2'));
        if ($xjhStatusNum2 > 0) {
            $arr['xjhStatusNum2']   =   $xjhStatusNum2;
        }

        //待举办宣讲会
        $xjhStateNum1   =   $this->select_num('school_xjh', array('stime' => array('>', time())));
        if ($xjhStateNum1 > 0) {
            $arr['xjhStateNum1']    =   $xjhStateNum1;
        }

        //已结束宣讲会
        $xjhStateNum2   =   $this->select_num('school_xjh', array('etime' => array('<', time())));
        if ($xjhStateNum2 > 0) {
            $arr['xjhStateNum2']    =   $xjhStateNum2;
        }
        return json_encode($arr);
    }

    function taskNum()
    {
        $arr = array();
        //供求任务总数
        $taskAllNum     =   $this->select_num('gq_task');
        if ($taskAllNum > 0) {
            $arr['taskAllNum'] = $taskAllNum;
        }
        //待审核供求任务
        $taskStatusNum1 =   $this->select_num('gq_task', array('status' => '0'));
        if ($taskStatusNum1 > 0) {
            $arr['taskStatusNum1'] = $taskStatusNum1;
        }
        //未通过供求任务
        $taskStatusNum2 =   $this->select_num('gq_task', array('status' => '2'));
        if ($taskStatusNum2 > 0) {
            $arr['taskStatusNum2'] = $taskStatusNum2;
        }
        //已过期供求任务
        $taskStatusNum3 =   $this->select_num('gq_task', array('etime' => array('<', time())));
        if ($taskStatusNum3 > 0) {
            $arr['taskStatusNum3'] = $taskStatusNum3;
        }
        return json_encode($arr);
    }

    function memNum()
    {
        $arr    =   array();
        //会员总数
        $memAllNum      =   $this->select_num('member');
        if ($memAllNum > 0) {
            $arr['memAllNum']       =   $memAllNum;
        }
        //子账户总数
        $memAllNum1     =   $this->select_num('company_account');
        if ($memAllNum1 > 0) {
            $arr['memAllNum1']      =   $memAllNum1;
        }

        //待审核会员
        $memStatusNum1  =   $this->select_num('member', array('status' => '0'));
        if ($memStatusNum1 > 0) {
            $arr['memStatusNum1']   =   $memStatusNum1;
        }
        //未通过会员
        $memStatusNum2  =   $this->select_num('member', array('status' => '3'));
        if ($memStatusNum2 > 0) {
            $arr['memStatusNum2']   =   $memStatusNum2;
        }
        //锁定会员
        $memStatusNum3  =   $this->select_num('member', array('status' => '2'));
        if ($memStatusNum3 > 0) {
            $arr['memStatusNum3']   =   $memStatusNum3;
        }
        //锁定子账户
        $rows           =   $this->select_all('company_account', '`uid`');
        $uids           =   array();
        foreach ($rows as $v) {
            $uids[]     =   $v['uid'];
        }

        $memStatusNum4  =   $this->select_num('member', array('status' => '2', 'uid' => array('in', pylode(',', $uids))));
        if ($memStatusNum4 > 0) {
            $arr['memStatusNum4']   =   $memStatusNum4;
        }

        return json_encode($arr);
    }

    function memchangeNum()
    {
        $arr    =   array();
        //供求任务总数
        $memAllNum      =   $this->select_num('user_change');
        if ($memAllNum > 0) {
            $arr['memAllNum']       =   $memAllNum;
        }
        //已拒绝申请
        $memStatusNum3  =   $this->select_num('user_change', array('status' => '0'));
        if ($memStatusNum3 > 0) {
            $arr['memStatusNum3']   =   $memStatusNum3;
        }
        return json_encode($arr);
    }

    function helpSum()
    {

        $arr    =   array();

        include(CONFIG_PATH . "db.data.php");
        //任务总数
        $helpAll    =   $this->select_num('friend_help');
        //助力总数
        $logAll     =   $this->select_num('friend_help_log');
        //已发权益
        //$logAll   =	$this -> select_num('friend_help_log');
        $receiveAll =   $this->select_all('friend_help_receive', array('groupby' => 'name'), '`name`,sum(`num`) as `receivenum`');

        if (!empty($receiveAll) && isset($arr_data)) {

            $html       =   array();
            foreach ($receiveAll as $key => $value) {
                $html[] =   $arr_data['helpconfig'][$value['name']]['name'] . ':' . $value['receivenum'];
            }
        }

        $arr['helpall']     =   $helpAll > 0 ? $helpAll : 0;
        $arr['logall']      =   $logAll > 0 ? $logAll : 0;
        $arr['receiveall']  =   @implode(',', $html);

        return json_encode($arr);
    }
}

?>