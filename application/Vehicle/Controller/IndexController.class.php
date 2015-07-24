<?php
namespace Vehicle\Controller;
use Common\Controller\AdminbaseController;

/**
 * 后台管理通用模块
 * @author wangdong
 */
class IndexController extends AdminbaseController {

	public function desList($page=1, $rows=10, $search = array(), $sort = 'id', $order = 'desc'){
				$info_db = D('Info');
				$ve_db = D('Vehicle');
				$ve_grade_db = D('Vegrade');
				//搜索
				$where = array();
				$post_info = array('logo'=>'-1', 'series'=>'-1', 'model'=>'-1');
				if(IS_POST){
					$post_info = I('post.search');
	
					foreach ($post_info as $k=>$v){
						if($k == 'logo' && $post_info['logo'] !== '-1'){
							$where[] = "`logoid` = '{$post_info['logo']}'";
						}elseif($k == 'series' && $post_info['series'] !== '-1'){
							$where[] = "`seriesid` = '{$post_info['series']}'";
						}elseif($k == 'model' && $post_info['model'] !== '-1'){
							$where[] = "`years` = '{$post_info['model']}'";
						}
							
					}
					
				}
				$where[] = "`disabled` = '0'";
	
				$limit=($page - 1) * $rows . "," . $rows;
				$total = $info_db->where($where)->count();
				$field = array('id','logoid','years','seriesid','listorder','addtime','edittime', 'modelid', 'adduser');
				$order = $sort.' '.$order;
				$list = $total ? $info_db->field($field)->where($where)->order($order)->limit($limit)->select() : array();
	
				$series_db = D('Series');
				$logo_db = D('Logo');
	
				$arr = array();
				foreach($list as &$row){
					$series_id = $row['seriesid'];
					$logo_id = $row['logoid'];
					$series_info = $series_db -> getSerieInfo($series_id);
					$logo_info = $logo_db -> getLogoInfo($logo_id);
					$row['sumpoint'] = $ve_grade_db->getVegradeCount($row['id']);
					$row['sum'] = $ve_db->getVehicleCount($row['id']);
					$row['logo_name'] = $logo_info['signname'];
					$row['series_name'] = $series_info['showname'];
					$row['addtime'] = date('Y-m-d H:i:s', $row['addtime']);
					$row['edittime'] = date('Y-m-d H:i:s', $row['edittime']);
				}
				
				$this->assign('post_info', $post_info);
				$this->assign('list', $list);
				$this->display('desList');
	}
	 /*
	  * 车震震后感列表
	  */
	 public function veList()
	 {
	 	$info_id = intval(I('get.info_id'));
	 	$veList_db = D('Vehicle');
		$list = $veList_db->getVehicleList($info_id);
		//var_dump($data);
		$this->assign('info_id',$info_id);
		$this->assign('list',$list);
		$this->display();	 	
	 }
	 
	 
	 /*
	  *添加震后感 
	  */
	 public function veAdd()
	 {
	 	$info_id = intval(I('get.info_id'));
	 	if(IS_POST)
		{
			$ve_class_db = D('Vehicle');
			$data['info_id'] = intval(I('post.info_id'));
			$data['author'] = trim(I('post.author'));
			$data['avatar'] = I('post.avatar');
			$data['content'] = trim(I('post.content'));
			$data['addtime'] = time();
			$data['stat'] = I('post.stat');
			$data['edtime'] = time();
			$data['adduser'] = $_COOKIE['admin_username'];
			$_id = $ve_class_db -> add($data);
			$msg = ($_id > 0) ? '1' : '0';
			exit(msg);
		}else{
			$this->assign('stat', array('0'=>'禁用','1'=>"启用"));
			$this->assign('info_id',$info_id);
			$this->display();
		}		
	}
	 
	/*
	 * 编辑震后感
	 */
	public function veEdit($id=0)
	{
		//$id = intval(I('get.id'));
		if(IS_POST)
		{
			$ve_class_db = D('Vehicle');
			$where = array('id'=>I("post.vid"));
			$data['author'] = trim(I('post.author'));
			$data['avatar'] = I('post.avatar');
			$data['content'] = trim(I('post.content'));
			$data['stat'] = I("post.stat");
			$data['edtime'] = time();
			$_id = $ve_class_db ->where($where)->save($data);
			$msg = ($_id > 0) ? '1' : '0';
			exit(msg);
		}
		else
		{
			$ve_db = D('Vehicle');
			$where = array('id'=>$id);
			$field = array('id','info_id','author','avatar','stat','content');
			$list = $ve_db->field($field)->where($where)->find();
			$this->assign('stat', array('0'=>'禁用','1'=>"启用"));
			$this->assign('list',$list);
			$this->display();		
		}
	}
	
	/*
	 * 删除震后感
	 */
	public function veDelete()
	{
		$ve_class_db = D('Vehicle');
		if(IS_POST){
			if(isset($_POST['ids'])){
				$tids=join(",",$_POST['ids']);
				if ($ve_class_db->where("id in ($tids)")->delete()) {
					$this->success("删除成功！");
				} else {
					$this->error("删除失败！");
				}
			}
		}
		else
		{
			$id = intval(I('get.id'));
			$where = array('id'=>$id);
			$_id = $ve_class_db ->where($where)->delete();	
			if($_id)
			{
				$this->success("删除成功！");
			}else{
				$this->error("删除失败！");
			}

		}
	}
	
	/*
	 * 车震评分
	 */
	 
	public function vegradeList()
	{
		$info_id = I("get.info_id");
		$ve_info_db = D('info');
		$where = array('id'=>$info_id);
		$field = array('modelid','id','seriesid','logoid');
		$info = $ve_info_db->field($field)->where($where)->find();
		$ve_class_db = D('Vegrade');
		$where = array('info_id'=>$info_id);
		$grade = $ve_class_db->where($where)->find();
		if($grade)
		{
			$grade['feature_type'] = explode(',',$grade['feature_type']);
			$list = $grade;
		}
		$space1 = array('选择座位评分',1,2,3,4,5,6,7,8,9,10);
		$space4 = array('选择储藏处数',1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20);
		$this->assign('info',$info);
		$this->assign('space1',$space1);
		$this->assign('space4',$space4);
		$this->assign('list',$list);
		$this->display();
	}
	
	//车震评分更新
	public function vegradeUpdate()
	{
		$id = I("post.id");
		$ve_db = D('Vegrade');
		$data['brand_type'] = intval(I("post.brandpoint"))/3;
		$data['brand_point'] = intval(I("post.brandpoint"));
		$data['feature_type'] = implode(',',I("post.featurepoint"));
		$data['feature_point'] = count(I("post.featurepoint"));
		$data['space1_point'] = intval(I("post.space1"));
		$data['space2_point'] = intval(I("post.space2"));
		$data['space3_name'] = I("post.space3");
		$data['space3_point'] = intval(I("post.space3point"));
		$data['space4_point'] = intval(I("post.space4point"));
		$data['space4_point'] = intval(I("post.space4point"));
		$data['space5_long'] = intval(I("post.space5long"));
		$data['space5_width'] = intval(I("post.space5width"));
		$data['space5_height'] = intval(I("post.space5height"));
		$data['space5_point'] = intval(I("post.space5point"));
		$data['sumpoint'] = intval(I("post.sumpoint"));
		if($id > 0 )
		{
			//更新操作
			$data['edtime'] = time();
			$_id = $ve_db->where(array('id'=>$id))->save($data);
			if($_id)
			{
				$this->success("更新成功！");
			}else{
				$this->error("更新失败！");
			}
		}
		else
		{
			//添加操作
			$data['info_id'] = intval(I("post.info_id"));
			$data['model_id'] = intval(I("post.model_id"));
			$data['series_id'] = intval(I("post.series_id"));
			$data['logo_id'] = intval(I("post.logo_id"));
			$data['addtime'] = time();
			$_id = $ve_db->add($data);
			if($_id)
			{
				$this->success("添加成功！");
			}else{
				$this->error("添加失败！");
			}
		}
	}
	 
}