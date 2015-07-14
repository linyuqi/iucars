<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=0.3">
<title><?php if(is_array($infoList)): foreach($infoList as $key=>$info): if($info["id"] == $infoid): echo ($info["series_name"]); ?>用车指南<?php endif; endforeach; endif; ?></title>
<script src="/statics/js/jquery.js" type="text/javascript"></script> 
<script src="/statics/js/touch.min.js" type="text/javascript"></script> 
<link type="text/css" rel="stylesheet" href="/statics/css/index.css">
</head>

<body>
<div class="ina_silde">

<header>
<?php if(is_array($infoList)): foreach($infoList as $key=>$info): ?><a href="<?php echo U('Reception/info/info',array('infoid'=>$info['id']));?>" <?php if($info["id"] == $infoid): ?>class="ina_dq"<?php endif; ?> title="<?php echo ($info["series_name"]); ?>"><?php echo ($info["series_name"]); ?></a><?php endforeach; endif; ?>
</header>

<div class="ina_yczn">
<h3>用车指南</h3>
<p>
<?php if(is_array($infoList)): foreach($infoList as $key=>$info): if($info["id"] == $infoid): echo ($info["series_name"]); endif; endforeach; endif; ?>
</p>
</div>
<div class="ina_focus">
<ul>
<?php $child = 'topPicList.child'; ?>
<?php if(is_array($topPicList["father"])): foreach($topPicList["father"] as $key=>$picinfo): ?><li>
<img src="<?php echo sp_get_asset_upload_path($picinfo['imgurl']);?>">
<?php if(is_array($picinfo["metaList"])): foreach($picinfo["metaList"] as $key=>$metainfo): $metaid = $metainfo["id"]; ?>
<?php if($child['metaid'] ): ?><a href="<?php echo ($child[$metaid]); ?>" style="left:calc(<?php echo ($metainfo["left"]); ?>% - 2.5rem);top:calc(<?php echo ($metainfo["top"]); ?>% - 2.5rem);"><i></i></a>
<?php else: ?>
<a href="#" style="left:73%;top:27%;" class="ina_black"><i></i></a><?php endif; endforeach; endif; ?>
</li><?php endforeach; endif; ?>


</ul>
</div>
<div class="ina_shisubiao">
<div class="ina_daohang">
<a href="javascript:void(0)" data-message="0"><i></i><span>快速<br>上手</span></a>
<a href="javascript:void(0)" data-message="1"><i></i><span>高级<br>教程</span></a>
<a href="javascript:void(0)"><i></i><span>安全<br>行车</span></a>
<a href="javascript:void(0)"><i></i><span>用车<br>技巧</span></a>
<a href="javascript:void(0)"><i></i><span>养车<br>相关</span></a>
<a href="javascript:void(0)"><i></i><span>车震<br>体验</span></a>
<a href="javascript:void(0)"><i></i><span>应急<br>指南</span></a>
<a href="javascript:void(0)"><i></i><span>亮点<br>功能</span></a>
</div>
<div class="ina_shisu">
<div class="ina_jianbian"><img src="/statics/images/icon/jianbian.png"></div>
<div class="ina_biaopan"><img src="/statics/images/icon/shisubiao.png"></div>
<div class="ina_zhizhen"><img src="/statics/images/icon/zhizhen.png" id="ina_zhizhen"></div>
<div class="ina_red"><span id="ina_red1"></span><span id="ina_red2"></span><span id="ina_red3"></span></div>
</div>
</div>
</div>
<div class="ina_main">


<?php if(is_array($menuList)): foreach($menuList as $k=>$vo): ?><div class="ina_bt" data-message="<?php echo ($k); ?>"><h3><?php echo ($vo["classname"]); ?></h3></div>

<?php if($vo["id"] == 93 ): ?><div class="ina_czty">
<div class="ina_czty_top">
<ul>
<?php if(is_array($vo["child"])): foreach($vo["child"] as $key=>$child): ?><li class="ina_red"><a href="#"><img src="<?php echo sp_get_asset_upload_path($child['image']);?>"><span><?php echo ($child["classname"]); ?></span></a></li><?php endforeach; endif; ?>



</ul>
</div>
<div class="ina_czty_bt"><p>“震”后感！</p></div>
<div class="ina_czty_bottom">
<ul>
<li>
<div class="ina_czty_img"><img src="/statics/images/icon/3.jpg"></div>
<p><b>女主说：</b>Jeep而狂热的心和一个精于算数的头脑相遇，一定会惊叹于Jeep者与自由客这一季的“22元低日供”金融一定会惊叹于</p>
</li>
<li>
<div class="ina_czty_img"><img src="/statics/images/icon/3.jpg"></div>
<p><b>男主说：</b>Jeep而狂热的心和一个精于算数的头脑相遇，一定会惊叹于Jeep者与自由客这一季的“22元低日供”金融一定会惊叹于</p>
</li>
<li>
<div class="ina_czty_img"><img src="/statics/images/icon/3.jpg"></div>
<p><b>编辑说：</b>Jeep而狂热的心和一个精于算数的头脑相遇，一定会惊叹于Jeep者与自由客这一季的“22元低日供”金融一定会惊叹于</p>
</li>
</ul>
<div class="ina_czzs">
<p>车震指数：<b>85.0分</b></p>
<span><a href="#">查看更多评分&gt;</a></span>
</div>
</div>

<?php else: ?> 

<?php if(is_array($vo["child"])): foreach($vo["child"] as $key=>$child): ?><dl>
<dt><p><?php echo ($child["classname"]); ?></p><span>+</span></dt>
<dd>
<p><?php echo ($child["description"]); ?></p>
<a href="#">全文</a>
</dd>
</dl><?php endforeach; endif; endif; endforeach; endif; ?>










</div>
<div class="ina_hide">
<div class="ina_btn"><img src="/statics/images/icon/btn.png"></div>
<div class="ina_btn_big">
<img src="/statics/images/icon/btn1.png">
<div class="ina_btn_nr">
<a href="javascript:void(0)"></a>
<a href="javascript:void(0)"></a>
<a href="javascript:void(0)"></a>
<a href="javascript:void(0)"></a>
<a href="javascript:void(0)"></a>
<a href="javascript:void(0)"></a>
<a href="javascript:void(0)"></a>
<a href="javascript:void(0)"></a>
<a href="javascript:void(0)"></a>
<a href="javascript:void(0)"><img src="/statics/images/icon/btn.png"></a>
</div>
</div>
</div>
<footer>
<p>©2015有车生活  京ICP备09043258号-2</p> 
<p>京公网安备1101052730</p>
</footer>
<script>
var height=$(window).height();
$(".ina_silde").height(height);
$.fn.extend({
	ina_focus:function(){
		var _this=$(this),ul=_this.find("ul"),li=ul.find("li");
		li.eq(0).show();
		li.eq(0).addClass("ina_dq");
		var width=600,height=480,w_width=document.documentElement.clientWidth||document.body.clientWidth;
		_this.height(w_width*0.8);
		ul.height(w_width*0.8);
		if(li.length>1){
			_this.append("<div class='ina_prev'></div><div class='ina_next'></div>");
			var prev=_this.find(".ina_prev"),next=_this.find(".ina_next");
			touch.on(ul,"touchstart",function(ev){
				//ev.preventDefault();
				})
			touch.on(ul,"swipeleft",function(ev){
				ev.preventDefault();
				for(var i=0;i<li.length;i++){
					if(li.eq(i).hasClass("ina_dq")){
						j=i+1;
						if(j>=li.length){j=0}
						li.eq(i).stop().animate({left:-w_width},function(){$(this).removeClass("ina_dq");$(this).hide();})
						li.eq(j).show().css({left:w_width}).stop().animate({left:0},function(){$(this).addClass("ina_dq")})
						return false;
						}
					}
				})
			touch.on(ul,"swiperight",function(ev){
				ev.preventDefault();
				for(var i=0;i<li.length;i++){
					if(li.eq(i).hasClass("ina_dq")){
						j=i-1;
						if(j<0){j=li.length-1}
						li.eq(i).stop().animate({left:w_width},function(){$(this).removeClass("ina_dq");$(this).hide();})
						li.eq(j).show().css({left:-w_width}).stop().animate({left:0},function(){$(this).addClass("ina_dq")})
						return false;
						}
					}
				})
			touch.on(prev,"tap",function(ev){
				for(var i=0;i<li.length;i++){
					if(li.eq(i).hasClass("ina_dq")){
						j=i-1;
						if(j<0){j=li.length-1}
						li.eq(i).stop().animate({left:w_width},function(){$(this).removeClass("ina_dq");$(this).hide();})
						li.eq(j).show().css({left:-w_width}).stop().animate({left:0},function(){$(this).addClass("ina_dq")})
						return false;
						}
					}
				})
			touch.on(next,"tap",function(ev){
				for(var i=0;i<li.length;i++){
					if(li.eq(i).hasClass("ina_dq")){
						j=i+1;
						if(j>=li.length){j=0}
						li.eq(i).stop().animate({left:-w_width},function(){$(this).removeClass("ina_dq");$(this).hide();})
						li.eq(j).show().css({left:w_width}).stop().animate({left:0},function(){$(this).addClass("ina_dq")})
						return false;
						}
					}
				})
			
			}
		}
	})
$(".ina_focus").ina_focus()
var angle =-100;
touch.on('.ina_zhizhen img', 'touchstart', function(ev){
    ev.startRotate();
    ev.preventDefault();
});

touch.on('.ina_zhizhen img', 'rotate', function(ev){
    var totalAngle = angle + ev.rotation;
	
    if(ev.fingerStatus === 'end'){
        angle = angle + ev.rotation;
    }
	if(totalAngle>=-100&&totalAngle<=103){
    this.style.webkitTransform = 'rotate(' + totalAngle + 'deg)';
	this.style.transform = 'rotate(' + totalAngle + 'deg)';
	var ina_red1=document.getElementById("ina_red1"),ina_red2=document.getElementById("ina_red2"),ina_red3=document.getElementById("ina_red3");
	if(totalAngle>=-100&&totalAngle<=-10){
		var red1=-totalAngle-14;
		ina_red1.style.webkitTransform='rotate(-14deg) skew('+red1+'deg)';
		ina_red2.style.webkitTransform='rotate(76deg) skew(90deg)';
		ina_red3.style.webkitTransform='rotate(166deg) skew(90deg)';
		ina_red1.style.transform='rotate(-14deg) skew('+red1+'deg)';
		ina_red2.style.transform='rotate(76deg) skew(90deg)';
		ina_red3.style.transform='rotate(166deg) skew(90deg)';
		}
	if(totalAngle>=-10&&totalAngle<=80){
		var red2=76-totalAngle;
		ina_red1.style.webkitTransform='rotate(-14deg) skew(0deg)';
		ina_red2.style.webkitTransform='rotate(76deg) skew('+red2+'deg)';
		ina_red3.style.webkitTransform='rotate(166deg) skew(90deg)';
		ina_red1.style.transform='rotate(-14deg) skew(0deg)';
		ina_red2.style.transform='rotate(76deg) skew('+red2+'deg)';
		ina_red3.style.transform='rotate(166deg) skew(90deg)';
		}
	if(totalAngle>=80&&totalAngle<=103){
		var red3=166-totalAngle;
		ina_red1.style.webkitTransform='rotate(-14deg) skew(0deg)';
		ina_red2.style.webkitTransform='rotate(76deg) skew(0deg)';
		ina_red3.style.webkitTransform='rotate(166deg) skew('+red3+'deg)';
		ina_red1.style.transform='rotate(-14deg) skew(0deg)';
		ina_red2.style.transform='rotate(76deg) skew(0deg)';
		ina_red3.style.transform='rotate(166deg) skew('+red3+'deg)';
		}
	if(totalAngle>=-100&&totalAngle<-70){
		$(".ina_daohang a").removeClass("ina_dq").eq(0).addClass("ina_dq");
		}
	else if(totalAngle>=-70&&totalAngle<-40){
		$(".ina_daohang a").removeClass("ina_dq").eq(1).addClass("ina_dq");
		}
	else if(totalAngle>=-40&&totalAngle<-15){
		$(".ina_daohang a").removeClass("ina_dq").eq(2).addClass("ina_dq");
		}
	else if(totalAngle>=-15&&totalAngle<15){
		$(".ina_daohang a").removeClass("ina_dq").eq(3).addClass("ina_dq");
		}
	else if(totalAngle>=15&&totalAngle<40){
		$(".ina_daohang a").removeClass("ina_dq").eq(4).addClass("ina_dq");
		}
	else if(totalAngle>=40&&totalAngle<70){
		$(".ina_daohang a").removeClass("ina_dq").eq(5).addClass("ina_dq");
		}
	else if(totalAngle>=70&&totalAngle<100){
		$(".ina_daohang a").removeClass("ina_dq").eq(6).addClass("ina_dq");
		}
	else if(totalAngle>=100){
		$(".ina_daohang a").removeClass("ina_dq").eq(7).addClass("ina_dq");
		}
	}
});
touch.on('.ina_zhizhen img','touchend',function(ev){
	for(var i=0;i<$(".ina_daohang a").length;i++){
		if($(".ina_daohang a").eq(i).hasClass("ina_dq")){
			var message=$(".ina_daohang a").eq(i).attr("data-message");
			for(var j=0;j<$(".ina_main .ina_bt").length;j++){
				if($(".ina_main .ina_bt").eq(j).attr("data-message")==message){
					var height=$(".ina_main .ina_bt").eq(j).offset().top;
		            $("body,html").animate({scrollTop:height})
					}
				}
			
			}
		}
	})
$(".ina_daohang a").click(function(){
	$(this).addClass("ina_dq").siblings().removeClass("ina_dq");
	var index=$(this).index(),zhizhen=document.getElementById("ina_zhizhen");
	var ina_red1=document.getElementById("ina_red1"),ina_red2=document.getElementById("ina_red2"),ina_red3=document.getElementById("ina_red3");
	var message=$(".ina_daohang a").eq(index).attr("data-message");
	for(var j=0;j<$(".ina_main .ina_bt").length;j++){
		if($(".ina_main .ina_bt").eq(j).attr("data-message")==message){
			var height=$(".ina_main .ina_bt").eq(j).offset().top;
	           $("body,html").animate({scrollTop:height})
			}
		}
	ina_zhizhen(index);
	})
$(".ina_main dl dt span").click(function(){
	if($(this).parents("dl").hasClass("ina_dq")){
		$(this).parents("dl").removeClass("ina_dq");
		$(this).html("+")
		}
	else{
		$(this).parents("dl").addClass("ina_dq");
		$(this).html("-")
		}
	})
function ina_zhizhen(index){
	$(".ina_daohang a").removeClass("ina_dq").eq(index).addClass("ina_dq");
	var ina_red1=document.getElementById("ina_red1"),ina_red2=document.getElementById("ina_red2"),ina_red3=document.getElementById("ina_red3"),zhizhen=document.getElementById("ina_zhizhen");
	if(index==0){
		zhizhen.style.webkitTransform='rotate(-100deg)';
		ina_red1.style.webkitTransform='rotate(-14deg) skew(83deg)';
		ina_red2.style.webkitTransform='rotate(76deg) skew(90deg)';
		ina_red3.style.webkitTransform='rotate(166deg) skew(90deg)';
		zhizhen.style.transform='rotate(-100deg)';
		ina_red1.style.transform='rotate(-14deg) skew(83deg)';
		ina_red2.style.transform='rotate(76deg) skew(90deg)';
		ina_red3.style.transform='rotate(166deg) skew(90deg)';
		$(".ina_btn_nr a").eq(9).css({left:"13rem",top:"12rem"});
		}
	else if(index==1){
		zhizhen.style.webkitTransform='rotate(-70deg)';
		ina_red1.style.webkitTransform='rotate(-14deg) skew(53deg)';
		ina_red2.style.webkitTransform='rotate(76deg) skew(90deg)';
		ina_red3.style.webkitTransform='rotate(166deg) skew(90deg)';
		zhizhen.style.transform='rotate(-70deg)';
		ina_red1.style.transform='rotate(-14deg) skew(53deg)';
		ina_red2.style.transform='rotate(76deg) skew(90deg)';
		ina_red3.style.transform='rotate(166deg) skew(90deg)';
		$(".ina_btn_nr a").eq(9).css({left:"13rem",top:"36rem"});
		}
	else if(index==2){
		zhizhen.style.webkitTransform='rotate(-40deg)';
		ina_red1.style.webkitTransform='rotate(-14deg) skew(24deg)';
		ina_red2.style.webkitTransform='rotate(76deg) skew(90deg)';
		ina_red3.style.webkitTransform='rotate(166deg) skew(90deg)';
		zhizhen.style.transform='rotate(-40deg)';
		ina_red1.style.transform='rotate(-14deg) skew(24deg)';
		ina_red2.style.transform='rotate(76deg) skew(90deg)';
		ina_red3.style.transform='rotate(166deg) skew(90deg)';
		$(".ina_btn_nr a").eq(9).css({left:"23rem",top:"12rem"});
		}
	else if(index==3){
		zhizhen.style.webkitTransform='rotate(-15deg)';
		ina_red1.style.webkitTransform='rotate(-14deg) skew(0deg)';
		ina_red2.style.webkitTransform='rotate(76deg) skew(90deg)';
		ina_red3.style.webkitTransform='rotate(166deg) skew(90deg)';
		zhizhen.style.transform='rotate(-15deg)';
		ina_red1.style.transform='rotate(-14deg) skew(0deg)';
		ina_red2.style.transform='rotate(76deg) skew(90deg)';
		ina_red3.style.transform='rotate(166deg) skew(90deg)';
		$(".ina_btn_nr a").eq(9).css({left:"23rem",top:"36rem"});
		}
	else if(index==4){
		zhizhen.style.webkitTransform='rotate(15deg)';
		ina_red1.style.webkitTransform='rotate(-14deg) skew(0deg)';
		ina_red2.style.webkitTransform='rotate(76deg) skew(60deg)';
		ina_red3.style.webkitTransform='rotate(166deg) skew(90deg)';
		zhizhen.style.transform='rotate(15deg)';
		ina_red1.style.transform='rotate(-14deg) skew(0deg)';
		ina_red2.style.transform='rotate(76deg) skew(60deg)';
		ina_red3.style.transform='rotate(166deg) skew(90deg)';
		$(".ina_btn_nr a").eq(9).css({left:"32rem",top:"12rem"});
		}
	else if(index==5){
		zhizhen.style.webkitTransform='rotate(40deg)';
		ina_red1.style.webkitTransform='rotate(-14deg) skew(0deg)';
		ina_red2.style.webkitTransform='rotate(76deg) skew(35deg)';
		ina_red3.style.webkitTransform='rotate(166deg) skew(90deg)';
		zhizhen.style.transform='rotate(40deg)';
		ina_red1.style.transform='rotate(-14deg) skew(0deg)';
		ina_red2.style.transform='rotate(76deg) skew(35deg)';
		ina_red3.style.transform='rotate(166deg) skew(90deg)';
		$(".ina_btn_nr a").eq(9).css({left:"32rem",top:"36rem"});
		}
	else if(index==6){
		zhizhen.style.webkitTransform='rotate(70deg)';
		ina_red1.style.webkitTransform='rotate(-14deg) skew(0deg)';
		ina_red2.style.webkitTransform='rotate(76deg) skew(5deg)';
		ina_red3.style.webkitTransform='rotate(166deg) skew(90deg)';
		zhizhen.style.transform='rotate(70deg)';
		ina_red1.style.transform='rotate(-14deg) skew(0deg)';
		ina_red2.style.transform='rotate(76deg) skew(5deg)';
		ina_red3.style.transform='rotate(166deg) skew(90deg)';
		$(".ina_btn_nr a").eq(9).css({left:"42rem",top:"12rem"});
		}
	else if(index==7){
		zhizhen.style.webkitTransform='rotate(103deg)';
		ina_red1.style.webkitTransform='rotate(-14deg) skew(0deg)';
		ina_red2.style.webkitTransform='rotate(76deg) skew(0deg)';
		ina_red3.style.webkitTransform='rotate(166deg) skew(62deg)';
		zhizhen.style.transform='rotate(103deg)';
		ina_red1.style.transform='rotate(-14deg) skew(0deg)';
		ina_red2.style.transform='rotate(76deg) skew(0deg)';
		ina_red3.style.transform='rotate(166deg) skew(62deg)';
		$(".ina_btn_nr a").eq(9).css({left:"42rem",top:"36rem"});
		}
	}
$(".ina_btn_nr a").click(function(){
	var index=$(this).index();
	var zhizhen=document.getElementById("ina_zhizhen");
	var ina_red1=document.getElementById("ina_red1"),ina_red2=document.getElementById("ina_red2"),ina_red3=document.getElementById("ina_red3");
	if(index<8){
		var message=$(".ina_daohang a").eq(index).attr("data-message");
	    for(var j=0;j<$(".ina_main .ina_bt").length;j++){
		    if($(".ina_main .ina_bt").eq(j).attr("data-message")==message){
			    var height=$(".ina_main .ina_bt").eq(j).offset().top;
	                $("body,html").animate({scrollTop:height})
			    }
		    }
	    ina_zhizhen(index);
		}
	else if(index==8){
		$("body,html").animate({scrollTop:0},function(){$(".ina_hide").hide();$(".ina_btn_nr a").eq(9).css({left:"23rem",top:"24rem"});});
		zhizhen.style.webkitTransform='rotate(-100deg)';
		ina_red1.style.webkitTransform='rotate(-14deg) skew(90deg)';
		ina_red2.style.webkitTransform='rotate(76deg) skew(90deg)';
		ina_red3.style.webkitTransform='rotate(166deg) skew(90deg)';
		zhizhen.style.transform='rotate(-100deg)';
		ina_red1.style.transform='rotate(-14deg) skew(90deg)';
		ina_red2.style.transform='rotate(76deg) skew(90deg)';
		ina_red3.style.transform='rotate(166deg) skew(90deg)';
		$(".ina_daohang a").removeClass("ina_dq");
		$(".ina_btn_nr a").eq(9).css({left:"4rem",top:"36rem"})
		}
	else{$(".ina_btn").show();$(".ina_btn_big").hide();$(".ina_btn_nr a").eq(9).css({left:"23rem",top:"24rem"});}
	})
$(".ina_btn").click(function(){
	$(this).hide();
	$(".ina_btn_big").show();
	})
$(window).scroll(function(){
	var H=document.documentElement.clientHeight||document.body.clientHeight;
	var H_scroll=$(document).scrollTop();
	if(H_scroll>H){$(".ina_hide").show();}
	else{$(".ina_hide,.ina_btn_big").hide();$(".ina_btn").show();}
	})
</script>
</body>
</html>