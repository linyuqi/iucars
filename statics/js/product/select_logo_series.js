/**
 * 初始化logo下拉框
 */
function initSelectLogo(logo_id, series_id, model_id, logo_value, series_value, model_value, lsttype){
	var optionItem;
	var iLength = JSON_logo.masterLogo.length;
	var iData = JSON_logo.masterLogo; 
	//清除下拉框中的内容
	$("#"+logo_id).empty();
	//填充logo下拉框数据
	optionItem = new Option("请选择品牌","-1");
	$("#"+logo_id)[0].options.add(optionItem);

	for(var i=0; i<iLength; i++){
		optionItem = new Option(iData[i].name, iData[i].id);
		$("#"+logo_id)[0].options.add(optionItem);
	}
	//初始化车系下拉框
	initSelectSeries(series_id, model_id, logo_value, series_value, model_value);

	//初始化车型  
    initSelectModel(model_id,series_value,model_value, lsttype);

	//移动到选定logo
	$("#"+logo_id).val(logo_value);
}
//logo下拉框点击事件
function selectLogoOnChange(logo_id, series_id, model_id, lsttype){
	var logo_value = $("#"+logo_id).val();
	initSelectLogo(logo_id, series_id, model_id, logo_value, "-1", "-1", lsttype);
}

//series下拉框点击
function selectSeriesOnChange(series_id, model_id, lsttype){
	var series_value = $("#"+series_id).val();
	initSelectModel(model_id, series_value, -1, lsttype);
}

/**
 * 初始化车系下拉框
 */
function initSelectSeries(series_id, model_id, logo_value, series_value, model_value){
	var optionItem;
	var isExist = 0;
	//清除下拉框中内容
	$("#"+series_id).empty();
	
	//填充下拉框数据
	optionItem = new Option("请选择车系",-1);
	$("#"+series_id)[0].options.add(optionItem);
	
	if(logo_value == "-1") return;
	
	//获取本logo下的品牌车系数据
	$.getJSON("/index.php?g=Products&c=Index&a=getSeriesList&id="+logo_value+"&lsttype=logo&jsoncallback=?", function(list){
		for(var kid in list['series']){
				var tmp_id = list['series'][kid]['id'];
				var arr_tmp = tmp_id.split("_");
				if(arr_tmp[0] == series_value) isExist = 1;
				if(arr_tmp[1] == "b"){
					optionItem = new Option("=="+list['series'][kid]['name']+"==", list['series'][kid]['id']);
				}else if(arr_tmp[1] == "c"){
					optionItem = new Option(list['series'][kid]['name'], list['series'][kid]['bseries_id']);
				}
				$("#"+series_id)[0].options.add(optionItem);
		}
		$("#"+series_id).val(series_value);
	});
	//if(model_value!="-1")   initSelectModel(model_id,series_value, model_value);
	
}

/**
 * 初始化年款下拉框
 */
function initSelectModel(model_id, series_value, model_value, lsttype){
	
	var optionItem,optionItem_copy;
	var isExist = 0;
	//清除下拉框中内容
	$("#"+model_id).empty();
	
	//填充下拉框数据
	var msg = (lsttype == 'years') ? "请选择年款" : "请选择车型";
	optionItem = new Option(msg, -1);
	$("#"+model_id)[0].options.add(optionItem);
	
	if(series_value == "-1") return;
	
	//获取本logo下的品牌车系数据
	$.getJSON("/index.php?g=Products&c=Index&a=getModelList&id="+series_value+"&lsttype="+lsttype+"&jsoncallback=?", function(list){
		for(var kid in list['model']){
				if(lsttype == 'years'){
					optionItem = new Option(list['model'][kid]['model_year'], list['model'][kid]['model_year']);
					$("#"+model_id)[0].options.add(optionItem);
				}else{
					optionItem = new Option(list['model'][kid]['m_name'], list['model'][kid]['model_id']);
					$("#"+model_id)[0].options.add(optionItem);
					//复制
					optionItem_copy = new Option(list['model'][kid]['m_name'], list['model'][kid]['model_id']);
					if($("#copy_model")[0])$("#copy_model")[0].options.add(optionItem_copy);
				}
		}
		$("#"+model_id).val(model_value);
	});
	
}