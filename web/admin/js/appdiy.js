$(function(){
	//input输入实时事件
	//搜索框
    $("#search").on('input propertychange',function(){
        var result = $(this).val();
        $("#pkeyword").attr('placeholder',result);
    });
	//上下移动阻止冒泡
	$(".move").click(function(e){
		e.stopPropagation();
	})
})
//折叠、radio点击事件
layui.use(['element', 'layer', 'form','carousel'], function(){
    var layer = layui.layer
    ,form = layui.form
    ,$ = layui.$;
	var carousel = layui.carousel;
    //图片轮播
	carousel.render({
		elem: '#hdpicshow'
		,width: '100%'
		,height: '130px'
		,interval: 5000
	});
	form.on('radio(membershow)', function(data){
    	if(data.value==1){
    		$("#ptogglemember").show();
    	}else{
    		$("#ptogglemember").hide();
    	}
    });
	form.on('radio(showtype)', function(data){
    	if(data.value==1){
    		$("#membershow").show();
			$("#hdshow").hide();
			$(".membershow").show();
			$(".hdshow").hide();
    	}else{
    		$("#membershow").hide();
			$("#hdshow").show();
			$(".membershow").hide();
			$(".hdshow").show();
    	}
    });
	form.on('radio(timeheader)', function(data){
    	if(data.value==1){
    		$("#timeheader").show();
    	}else{
    		$("#timeheader").hide();
    	}
    });
    form.on('radio(usertype)', function(data){
    	if(data.value==1){
			$("#usermember").show();
			$("#commember").hide();
    	}else{
			$("#usermember").hide();
			$("#commember").show();
    	}
    });
	form.on('radio(searchshow)', function(data){
    	if(data.value==1){
    		$(".yun_wapheader").show();
    	}else{
    		$(".yun_wapheader").hide();
    	}
    });
    form.on('radio(login)', function(data){
    	if(data.value==1){
    		$("#login").show();
    	}else{
    		$("#login").hide();
    	}
    });
	form.on('radio(hdshow)', function(data){
    	if(data.value==1){
    		$(".wap_mb_show_hdp").show();
    	}else{
    		$(".wap_mb_show_hdp").hide();
    	}
    });
    form.on('radio(notice)', function(data){
    	if(data.value==1){
    		$(".noticectrl").show();
    	}else{
    		$(".noticectrl").hide();
    	}
    });
    form.on('radio(connect)', function(data){
        if(data.value==1){
            $(".connectshow").show();
        }else{
            $(".connectshow").hide();
        }
    });
    form.on('radio(rewardjob)', function(data){
    	if(data.value==1){
    		$("#rewardjob").show();
    	}else{
    		$("#rewardjob").hide();
    	}
    });
    form.on('checkbox(rewardjobsalary)', function(data){
    	if(data.elem.checked==true){
    		$(".rewardjobsalary").show();
    	}else{
    		$(".rewardjobsalary").hide();
    	}
    });
    form.on('checkbox(rewardjobreward)', function(data){
    	if(data.elem.checked==true){
    		$(".rewardjobreward").show();
    	}else{
    		$(".rewardjobreward").hide();
    	}
    });
    form.on('radio(rewardjobmore)', function(data){
    	if(data.value==1){
    		$(".rewardjobmore").show();
    	}else{
    		$(".rewardjobmore").hide();
    	}
    });
    form.on('radio(hotcom)', function(data){
    	if(data.value==1){
    		$("#hotcom").show();
    	}else{
    		$("#hotcom").hide();
    	}
    });
    form.on('radio(hotcommore)', function(data){
    	if(data.value==1){
    		$(".hotcommore").show();
    	}else{
    		$(".hotcommore").hide();
    	}
    });
    form.on('checkbox(jobcom)', function(data){
    	if(data.elem.checked==true){
    		$("#jobcom").show();
    	}else{
    		$("#jobcom").hide();
    	}
    });
    form.on('checkbox(jobsalary)', function(data){
    	if(data.elem.checked==true){
    		$("#jobsalary").show();
    	}else{
    		$("#jobsalary").hide();
    	}
    });
    form.on('checkbox(jobcity)', function(data){
    	if(data.elem.checked==true){
    		$("#jobcity").show();
    	}else{
    		$("#jobcity").hide();
    	}
    });
    form.on('checkbox(jobdate)', function(data){
    	if(data.elem.checked==true){
    		$("#jobdate").show();
    	}else{
    		$("#jobdate").hide();
    	}
    });
    form.on('checkbox(jobwelfare)', function(data){
        if(data.elem.checked==true){
            $("#jobwelfare").show();
        }else{
            $("#jobwelfare").hide();
        }
    });
    form.on('radio(jobmore)', function(data){
    	if(data.value==1){
    		$(".jobmore").show();
    	}else{
    		$(".jobmore").hide();
    	}
    });
    form.on('checkbox(connect)', function(data){
        var name = data.elem.dataset.name;

        if(data.elem.checked==true){
            $("#"+name).show();
        }else{
            $("#"+name).hide();
        }
    });
    //招聘会
    form.on('radio(zphshow)', function(data){
        if(data.value==1){
            $(".zphshow").show();
        }else{
            $(".zphshow").hide();
        }
    });
    form.on('checkbox(zphtime)', function(data){
        if(data.elem.checked==true){
            $("#zphtime").show();
        }else{
            $("#zphtime").hide();
        }
    });
    form.on('checkbox(zphplace)', function(data){
        if(data.elem.checked==true){
            $("#zphplace").show();
        }else{
            $("#zphplace").hide();
        }
    });
    form.on('radio(zphmore)', function(data){
        if(data.value==1){
            $(".zphmore").show();
        }else{
            $(".zphmore").hide();
        }
    });
    //咨询
    form.on('radio(articleshow)', function(data){
        if(data.value==1){
            $(".articleshow").show();
        }else{
            $(".articleshow").hide();
        }
    });
    form.on('radio(articletype)', function(data){
        $(".atypectrl").hide();
        $("#articletype"+data.value).show();
    });
    form.on('radio(articlemore)', function(data){
        if(data.value==1){
            $(".articlemore").show();
        }else{
            $(".articlemore").hide();
        }
    });
    //职位类别
    form.on('radio(jobclassone)', function(data){
        if(data.value==1){
            $("#twojobshow").show();
            $("#twojobnum").show();
            $("#morejob").show();
            $(".jobclassone").show();
        }else{
            $("#twojobshow").hide();
            $("#twojobnum").hide();
            $("#morejob").hide();
            $(".jobclassone").hide();
        }
    });
    form.on('checkbox(jobclassonenumall)', function(data){
        if(data.elem.checked==true){
            $("#jobclassonenum").val('');
            $("#jobclassonenum").attr('disabled','disabled');
        }else{
            $("#jobclassonenum").removeAttr('disabled');
        }
    });
    form.on('radio(jobclasstwo)', function(data){
        if(data.value==1){
            $(".jobclasstwo").show();
        }else{
            $(".jobclasstwo").hide();
        }
    });
    form.on('checkbox(jobclasstwonumall)', function(data){
        if(data.elem.checked==true){
            $("#jobclasstwonum").val('');
            $("#jobclasstwonum").attr('disabled','disabled');
        }else{
            $("#jobclasstwonum").removeAttr('disabled');
        }
    });
    form.on('radio(jobclassmore)', function(data){
        if(data.value==1){
            $(".jobclassmore").show();
        }else{
            $(".jobclassmore").hide();
        }
    });
  });
//图片轮播
layui.use(['carousel'], function(){
	  var carousel = layui.carousel;

	  carousel.render({
	    elem: '#hdpicshow'
	    ,width: '100%'
	    ,height: '130px'
	    ,interval: 5000
	  });
});
//选择主题颜色
function getcolor(id){
	$(".js_change_color").removeClass("selected");
	$(".bg"+id).addClass("selected");
	$(".wap_header").attr('class',"wap_header bg"+id+" selected");
	$("#color").val(id);
	$(".yun_wapheader").attr('class',"yun_wapheader bg"+id);
	$(".yun_new_indexnav").attr('class',"yun_new_indexnav bg"+id);
}
//预览图片
function showpic(fileDom,imgid,pimgid){
	//判断是否支持FileReader
    if (window.FileReader) {
        var reader = new FileReader();
    } else {
    	layer.msg("您的设备不支持图片预览功能，如需该功能请升级您的设备！",2,8);
    }
    //获取文件
    var file = fileDom.files[0];
    var imageType = /^image\//;
    //是否是图片
    if (!imageType.test(file.type)) {
        layer.msg("请选择图片！",2,8);return;
    }
    //读取完成
    reader.onload = function(e) {

        //获取图片dom
        var img = document.getElementById(imgid);
		if(pimgid){
			var pimg = document.getElementById(pimgid);
            if(pimg){
                pimg.src = e.target.result;
            }

		}
        //图片路径设置为读取的图片
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}
//上移
function upsort(type){
	var $tr = $("#toggle"+type);
	var $ptr = $("#ptoggle"+type);
	var pytoken=$("#pytoken").val();
	if ($tr.index() > 4) {
		$tr.prev().before($tr);
		$ptr.prev().before($ptr);
		var sort =[];
		$("input[name='sort[]']").each(function(index,item){
			sort.push($(this).val());
		});

		$.post('index.php?m=admin_app_set&c=sort',{sort:sort,pytoken:pytoken},function(data){
		})
    }else{
    	layer.msg('已经是第一个了，不能上移',2,8);
    }
}
//下移
function downsort(type){
    var trCnt = $('#tpl_tbl tr').length// 自定义模板表格行数
	var $tr = $("#toggle"+type);
	var $ptr = $("#ptoggle"+type);
	var pytoken=$("#pytoken").val();
    if ($tr.index() + 1 < trCnt - 2) {
    	$tr.next().after($tr);
        $ptr.next().after($ptr);
    	var sort =[];
		$("input[name='sort[]']").each(function(index,item){
			sort.push($(this).val());
		});

    	$.post('index.php?m=admin_app_set&c=sort',{sort:sort,pytoken:pytoken},function(data){
		})
    }else{
    	layer.msg('已经是最后一个了，不能下移',2,8);
    }
}
//导航显示
function shownav(obj){
	var id=$(obj).attr('data-id');
	$(obj).val('隐藏');
	$(obj).attr('onclick','hidenav(this)');
	$(obj).attr('class','wap_appmb_bth');
	$("#navdisplay"+id).val(1);
	$("#prn"+id).show();
	$("#navsortbox"+id).show();
}
//导航隐藏
function hidenav(obj){
	var id=$(obj).attr('data-id');
	$(obj).val('显示');
	$(obj).attr('onclick','shownav(this)');
	$(obj).attr('class','wap_appmb_xsbth');
	$("#navdisplay"+id).val(2);
	$("#prn"+id).hide();
	$("#navsortbox"+id).hide();
}
//大导航显示
function shownavb(obj){
    var id=$(obj).attr('data-id');
    $(obj).val('隐藏');
    $(obj).attr('onclick','hidenavb(this)');
    $("#navbigdisplay"+id).val(1);
    $("#prnb"+id).show();
    $("#navbigsortbox"+id).show();
}
//大导航隐藏
function hidenavb(obj){
    var id=$(obj).attr('data-id');
    $(obj).val('显示');
    $(obj).attr('onclick','shownavb(this)');
    $("#navbigdisplay"+id).val(2);
    $("#prnb"+id).hide();
    $("#navbigsortbox"+id).hide();
}
//导航上移
function upnav(obj){
	var id=$(obj).attr('data-id');
	var tr=$("#n"+id),
		ptr=$("#prn"+id),
		navsort=parseInt($("#navsort"+id).val());
	tr.prev().before(tr);
	ptr.prev().before(ptr);
	if(navsort==navlength){
		$(obj).next('a').show();
		$(obj).parent().parent().next('li').find('.downnav').hide();
	}
	if(navsort>1){
		$(obj).parent().parent().next('li').find('input[name="navsort[]"]').val(navsort);
		navsort = navsort-1;
		if(navsort==1){
			$(obj).hide();
			$(obj).prev('a').hide();
		}
		$("#navsort"+id).val(navsort);
	}
}
//导航下移
function downnav(obj){
	var id=$(obj).attr('data-id');
	var tr=$("#n"+id),
		ptr=$("#prn"+id),
		navsort=parseInt($("#navsort"+id).val());
	tr.next().after(tr);
	ptr.next().after(ptr);
	if(navsort==1){
		$(obj).prev('a').show();
		$(obj).parent().parent().prev('li').find('.upnav').hide();
	}
	if(navsort<navlength){
		$(obj).parent().parent().prev('li').find('input[name="navsort[]"]').val(navsort);
		navsort = navsort+1;
		if(navsort==navlength){
			$(obj).hide();
		}
		$("#navsort"+id).val(navsort);
	}
}
