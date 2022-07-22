$(document).ready(function(){
	$(".search_add").hover(function(){
		var aid=$(this).attr("type");
		$("#list"+aid).show();
	},function(){
		var aid=$(this).attr("type");
		$("#list"+aid).hide();
	})   
	$(".service_items").hover(function(){
		$(this).addClass("service_items_hover");
	},function(){
		$(this).removeClass("service_items_hover");
	}) 
})
function check_show_search(id){
	if(id==2){
		$("#searchtype1").show();
		$("#searchtype2").hide();
	}else{
		$("#searchtype1").hide();
		$("#searchtype2").show();
	}
}
function checkfrom(myform){
	var keyword=myform.keyword.value; 
	if(keyword=="请输入你要查找的信息"){
		myform.keyword.value='';
	}
}

	$(function(){
	    //关键字输入框内容与提示信息相同时，当输入框获取焦点则置空该输入框
	    $('.search_keyword').delegate('input[name=keyword]','focus',function(){
	        if($.trim($(this).val())==$(this).attr('placeholder')){
	            $(this).val('');
	        }
	    });
	    //切换 简洁搜索<==>高级搜索
	    $('.hunter_search').delegate('.search_more_bth,.search_more_bth_up', 'click', function () {
	        if($("#formSimpleSearch").is(":hidden")){
	            $('#formAdvanceSearch').hide();
	            $('#formSimpleSearch').show();
	        }else{
	            $('#formSimpleSearch').hide();
	            $('#formAdvanceSearch').show();
	        }
	    });
	    //光标悬停时，显示知名企业关注信息
	    $('.company_items').delegate('.company_logo','mouseover',function(){
	        $(this).find('.company_focus').show();
	    });
	    //光标离开时，隐藏知名企业关注信息
	    $('.company_items').delegate('.company_logo','mouseout',function(){
	        $(this).find('.company_focus').hide();
	    });
	    //单击页面其他区域时，隐藏选择下拉框
	    $(document.body).click(function(evt){
	        var e = evt || event || window.event;
	        var ClickedElement=e.target;
	        if(!($(ClickedElement).hasClass('search_add')||$(ClickedElement).parent().hasClass('search_add')||$(ClickedElement).parent().parent().hasClass('search_add')||$(ClickedElement).parent().parent().parent().hasClass('search_add'))){
	            $('.search_more .search_select_list').hide();
	        } 
	    });
	    //单击选择按钮，显示选择下拉框
	    $('#cityin_name,#hy_name,#mun_name,#pr_name,#uptime_name').click(function () {		    
	        $('.search_more .search_select_list').hide();
	        var SelectedList=$(this).parent().find('.search_select_list');
	        if(SelectedList.length>0){
	            if(SelectedList.is(":hidden")){
	                SelectedList.show();
	            }else{
	                SelectedList.hide();
	            }
	        }
	    });
	    //单击选择下拉框指定项，隐藏选择下拉框，并设置选择项
	    $('.search_more').delegate('.search_select_list li','click',function(){
	        $(this).parent().hide();
	        $(this).parent().prev().val($(this).attr('code'));
	        $(this).parent().prev().prev().val($(this).attr('codename'));
	    });
	});