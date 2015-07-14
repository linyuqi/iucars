<?php
namespace Reception\Controller;
use Common\Controller\HomeBaseController; 
/**
 * 首页
 */
class InfoController extends HomeBaseController {
	
    //首页
	public function info() {
		$infoid = I('get.infoid');

		$this->assign('infoid', $infoid);

		//获取车型列表
		$info_db = D('Info');
		$infoList = $info_db -> getInfoList();
		$this->assign('infoList', $infoList);

		//题图
		$topPicList = getPicMetaArr($infoid,91);
		//print_r($topPicList);exit;
		$this->assign('topPicList', $topPicList);

		$classself_db = D('ClassSelf');
		$data_class = array();
		$data_class = $classself_db -> getClassSelfList($infoid);
		foreach($data_class as $key => &$row){
			if($row['classid'] == 91) unset($data_class[$key]);
			if($row['parentid'] == 91) unset($data_class[$key]);
			$row['cid'] = $row['id'];
			$row['id'] = $row['classid'];
		}
		$tree = new \Tree();
		$tree->init($data_class);
		$menuList = $tree->get_tree_array(0);
		$this->assign('menuList', $menuList);
    	$this->display(":info");
    }



}


