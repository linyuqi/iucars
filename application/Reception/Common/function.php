<?php
//获取图片结构
function getPicMetaArr($infoid=0,$classid=0){
		//获取
		$pic_db = D('Pic');
		//获取一级图片
		$topPicList = $pic_db->getPicList($infoid,$classid);
		$father = array();
		$child = array();
		foreach ($topPicList as $k => $picInfo) {
			$picInfo['metaList'] = getMetaList($picInfo['id']);
			$metaId = $picInfo['metaid'];
			if($metaId == 0){
				$father[] = $picInfo;
			}else{
				$child[$metaId] = $picInfo;
			}
		}
	return  array('father' =>$father, 'child' =>$child);
}

//获取坐标信息
function getMetaList($picId = 0){
	if(!$picId) return false;
	$meta_db = D('Meta');
	$MetaList = $meta_db->getMetaListByPicid($picId);
	foreach ($MetaList as $k => $vv) {
		$MetaList[$k]['left'] = sprintf("%.2f",($vv['posx']/1920)*100);
		$MetaList[$k]['top'] = sprintf("%.2f",($vv['posy']/1280)*100);
	}

	return $MetaList;
}	