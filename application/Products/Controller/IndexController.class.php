<?php
namespace Products\Controller;
use Common\Controller\AdminbaseController;

/**
 * 后台管理通用模块
 * @author wangdong
 */
class IndexController extends AdminbaseController {
	/**
	 * 后台首页
	 */
	public function index() {
    	$this->display(":index");
    }

	public function desList($page=1, $rows=10, $search = array(), $sort = 'id', $order = 'desc'){
			$info_db = D('Info');
			
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
				$row['logo_name'] = $logo_info['signname'];
				$row['series_name'] = $series_info['showname'];
				$row['addtime'] = date('Y-m-d H:i:s', $row['addtime']);
				$row['edittime'] = date('Y-m-d H:i:s', $row['edittime']);
			}
			$this->assign('post_info', $post_info);
			$this->assign('list', $list);
			$this->display('deslist');
	}
	//删除主表数据
	function delete(){
		$info_db = D('Info');

		if(IS_POST){
			if(isset($_POST['ids'])){
				$tids=join(",",$_POST['ids']);
				$data['disabled']=1;
				if ($info_db->where("id in ($tids)")->save($data)) {
					$this->success("删除成功！");
				} else {
					$this->error("删除失败！");
				}
			}
		}else{
			$info_id = I("get.info_id");
			if(isset($info_id)){
				$tid = intval($info_id);
				$data['disabled']=1;
				if ($info_db->where("id=$info_id")->save($data)) {
					$this->success("删除成功！");
				} else {
					$this->error("删除失败！");
				}
			}
		}
		
	}
	
	//删除图片数据
	public function imgDel(){
		$pic_db = D('Pic');

		if(IS_POST){
			if(isset($_POST['ids'])){
				$tids=join(",",$_POST['ids']);
				$data['disabled']=1;
				if ($pic_db->where("id in ($tids)")->save($data)) {
					$this->success("删除成功！");
				} else {
					$this->error("删除失败！");
				}
			}
		}else{
			$pic_id = I("get.pic_id");
			if(isset($pic_id)){
				$tid = intval($pic_id);
				$data['disabled']=1;
				if ($pic_db->where("id=$pic_id")->save($data)) {
					$this->success("删除成功！");
				} else {
					$this->error("删除失败！");
				}
			}
		}
	
	}
	//排序
	public function listdesorders() {
		$info_db = D('Info');
		$status = parent::_listorders($info_db);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}

	/**
	* 异步获取品牌列表
	*/
	function getLogoList(){
		$logo_db = D('Logo');
		$logo_list = $logo_db -> getLogoList();
		$data = json_encode($logo_list);
		echo $data;
		exit;
	
	}

	
	/**
	* 异步获取车系列表
	*/
	public function getSeriesList(){
		$series_db = D('Series');

		$logoid = I('get.id');
		$jsoncallback = I('get.jsoncallback');
		$jsoncallback = I('get.cheshicallback') ? I('get.cheshicallback') : I('get.jsoncallback');
		if(!$jsoncallback){
			$jsoncallback = "cheshiSeriesFeed";
		}

		if(!$logoid && !$jsoncallback)exit;
		$series_list = $series_db -> getSeriesList($logoid);
		$data = json_encode($series_list);
		echo($jsoncallback."({series:".$data."})");
		exit;
	
	}


	/**
	* 异步获取车型年款列表
	*/
	public function getModelList(){
		$models_db = D('Models');

		$seriesid = I('get.id');
		$lsttype = I('get.lsttype');
		$jsoncallback = I('get.jsoncallback');
		$jsoncallback = I('get.cheshicallback') ? I('get.cheshicallback') : I('get.jsoncallback');
		if(!$jsoncallback){
			$jsoncallback = "cheshiSeriesFeed";
		}

		if(!$seriesid && !$jsoncallback)exit;
		$model_list = $models_db -> getModelList($seriesid, $lsttype);
		$data = json_encode($model_list);
		echo ($jsoncallback."({model:".$data."})");
		exit;
	
	}


	/**
	* 添加说明书
	*/
	public function desAdd(){
		import("Tree");
		$tree = new \Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$class_db = D('Proclass');

		if(!IS_POST){
			$step = I('get.step');
			$act = I('get.act');
			$info_id = I('get.info_id');
			$lsttype = I('get.lsttype');

			if(!$info_id){
				$post_info = array('logoid'=>'-1', 'seriesid'=>'-1', 'years'=>'-1');
				$model_years = '-1';
			}else{
				$info = D('Info');
				$pro_info = $info -> getInfoById($info_id);//用于参数传递
				
				if($lsttype == 'model'){
					$post_info = array('logoid'=>$pro_info['logoid'], 'seriesid'=>$pro_info['seriesid'], 'modelid'=>$pro_info['modelid']);
					$model_years = ($pro_info['modelid']) ? $pro_info['modelid'] : '-1';
				}else{
					$post_info = array('logoid'=>$pro_info['logoid'], 'seriesid'=>$pro_info['seriesid'], 'years'=>$pro_info['years']);
					$model_years = ($pro_info['years']) ? $pro_info['years'] : '-1';
				}
			}
			
			$this->assign('model_years', $model_years);
			$this->assign('post_info', $post_info);
			
			$data = $class_db->getTreeList();
			$classself_db = D('ClassSelf');

			$data_class = array();
			if($step == 1){
				$data_class = $classself_db -> getClassSelfList($info_id);// 已选择类别
				foreach($data as &$row){
					$addstr = '';
					$row['parentid_node'] = ($row['parentid']) ? ' class="child-of-node-' . $row['parentid'] . '"' : '';
					$input_id = (!$row['parentid']) ? $row['id'] : $row['parentid'].'_'.$row['id'];

					$classidArr = '';
					foreach($data_class as $infos)$classidArr[] = $infos['classid'];
					$checked = (in_array($row['id'], $classidArr)) ? 'checked="checked"' : '';
					
					$row['check_box'] = '<input type="checkbox" id="J_check_'.$input_id.'" class="J_check" data-yid="J_check_y" data-xid="J_check_y" name="ids[]" value="'.$input_id.'" title="ID:'.$row['id'].'" pid="J_check_'.$row['parentid'].'" '.$checked.'>';
					$row['input_value'] = '<input type="text" name="class_name_'.$row['id'].'" id="class_'.$row['id'].'" value="'.$row['classname'].'">';
				}
				
				$tree->init($data);
				$str = "<tr id='node-\$id' \$parentid_node>
							<td>\$check_box</td>
							<td>\$id</td>
							<td>\$spacer\$input_value</td>
						</tr>";
				$categorys = $tree->get_tree(0, $str);
			}elseif($step == 2){
				$data_class = $classself_db -> getClassSelfList($info_id);// 已选择类别
				foreach($data_class as &$row){
					$addstr = '';
					$row['catid'] = $row['id'];
					$row['id'] = $row['classid'];
					$row['parentid_node'] = ($row['parentid']) ? ' class="child-of-node-' . $row['parentid'] . '"' : '';
					$addstr = ($row['parentid']==0) ? '<a class="btn" onclick="addself('.$info_id.','.$row['parentid'].','.$row['id'].')">添加自定义分类</a>  <a href="javascript:;" style="margin: 5px 0;" onclick="javascript:flashupload(\'albums_images\', \'图片上传\',\'photos\',change_images2,\'20,gif|jpg|jpeg|png|bmp,0,'.$row['id'].',0,'.$info_id.','.$post_info['logoid'].','.$post_info['seriesid'].','.$post_info['years'].'\',\'\',\'\',\'\')" class="btn">图片上传 </a> <a id="view_images" onclick="javascript:view_images('.$info_id.', '.$row['id'].');" target="_self" class="btn">查看图片</a>' : '<a href="javascript:;" style="margin: 5px 0;" onclick="javascript:flashupload(\'albums_images\', \'图片上传\',\'photos\',change_images2,\'20,gif|jpg|jpeg|png|bmp,0,'.$row['id'].',0,'.$info_id.','.$post_info['logoid'].','.$post_info['seriesid'].','.$post_info['years'].'\',\'\',\'\',\'\')" class="btn">图片上传 </a> <a id="view_images" onclick="javascript:view_images('.$info_id.','.$row['id'].');" target="_self" class="btn">查看图片</a>';
					$row['str_manage'] = $addstr;
				}
				//print_r($data_class);
				$tree->init($data_class);
				$str = "<tr id='node-\$id' \$parentid_node>
							<td style='padding-left:20px;'><input name='listorders[\$catid]' type='text' size='3' value='\$listorder' class='input input-order'></td>
							<td>\$id</td>
							<td>\$spacer\$classname</td>
							<td>\$str_manage</td>
						</tr>";
				$categorys = $tree->get_tree(0, $str);
				$this->assign('isshow', 'yes');
				//$this->assign("categorys", $categorys);
			
			}
			$step = ($step) ? $step : 0;
			$this->assign('info_id', $info_id);
			$this->assign('step', $step);
			$this->assign('act', $act);
			$this->assign('lsttype', $lsttype);
			$this->assign("categorys", $categorys);
			$this->display('desadd');
		}else{
			/**保存说明书基本信息**/
			$info_db = D('Info');
			$post_info = I('post.search');
			$act = $post_info['act'];
			$lsttype = $post_info['lsttype'];

			$username = $_SESSION['name'];
			$time = time();
			
			//判断是否为复制
			$copy_model = $post_info['copy_model'];
			if($copy_model != '-1' && $copy_model > 0){
				$info = $info_db -> getInfoByPro($post_info['logo'], $post_info['series'], $copy_model, 'model');
				
				if($info){
					$classself_db = D('ClassSelf');
					$c_info_id = $info['id'];
					$c_class = $classself_db -> getClassSelfList($c_info_id);
					
					//1.先入主表
					$info_data = array('logoid'=>$post_info['logo'], 'seriesid'=>$post_info['series'], 'modelid'=>$post_info['model'], 'adduser'=>$username, 'addtime'=>$time, 'edittime'=>$time);
					$last_id = $info_db -> add($info_data);

					//第一步完成后进行2步
					if(is_array($c_class)){
						foreach($c_class as $cc){
							$data = array('infoid'=>$last_id, 'parentid'=>$cc['parentid'], 'classid'=> $cc['classid'], 'classname'=>$cc['classname'], 'description'=>$cc['classname'], 'adduser'=>$username, 'addtime'=>$time);
							$c_insert_id = $classself_db -> add($data);
							if(!$c_insert_id) $this->error("复制车型失败！");
						}
						$this->success('复制车型成功....', U('Index/desAdd', array('info_id'=>$last_id, 'step'=>1, 'act'=>$act, 'lsttype'=>$lsttype)));
					}

				}else{
					$this->success('对不起！该车型暂时没有数据，无法复制....', U('Index/desAdd', array('lsttype'=>$lsttype)));
				}
			}else{
				//判断存在
				$info = $info_db -> getInfoByPro($post_info['logo'], $post_info['series'], $post_info['model']);
				if(!$info && $act == 'add'){
					if($lsttype == 'model'){
						$info_data = array('logoid'=>$post_info['logo'], 'seriesid'=>$post_info['series'], 'modelid'=>$post_info['model'], 'adduser'=>$username, 'addtime'=>$time, 'edittime'=>$time);
					}else{
						$info_data = array('logoid'=>$post_info['logo'], 'seriesid'=>$post_info['series'], 'years'=>$post_info['model'], 'adduser'=>$username, 'addtime'=>$time, 'edittime'=>$time);
					}
					$last_id = $info_db -> add($info_data);
				}
				$info_id = ($last_id>0) ? $last_id : $info['id'];
				if($post_info && $act == 'add'){
					$this->success('正在添加....', U('Index/desAdd', array('info_id'=>$info_id, 'step'=>1, 'act'=>$act, 'lsttype'=>$lsttype)));
				}
			}
		}		
	}
	//排序
	public function listorders() {
		$classself_db = D('ClassSelf');
		$status = parent::_listorders($classself_db);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}

	/**
	* 保存选择的分类列表数据
	**/
	public function selectDataSave(){
		if(IS_POST){
			$submit = I('post.submit');
			if($submit == 'add_class'){//保存第一步分类
				$ids = I('post.ids');
				$info_id = I('post.info_id');
				$act = I('post.act');
				$lsttype = I('post.lsttype');

				$username = $_SESSION['name'];
				$time = time();
				$classself_db = D('ClassSelf');
		
				
				if($ids){
					foreach($ids as $id){
						$classid = $parentid = 0;
						$idArr = explode('_', $id);
						if(count($idArr)>1){
							$classid = $idArr[1];
							$parentid = $idArr[0];
						}else{
							$classid = $id;

						}
						
						$parentid = ($parentid) ? $parentid : 0;
						$class_name = I('post.class_name_'.$classid);
						$data = array('infoid'=>$info_id, 'parentid'=>$parentid, 'classid'=> $classid, 'classname'=>$class_name, 'description'=>$class_name, 'adduser'=>$username, 'addtime'=>$time);

						if($act == 'edit'){//修改时，不删除,已有的修改，没有的添加
							//$classself_db->where('infoid='.$info_id)->delete();
							$res = $classself_db->getInfoByAllId($info_id, $classid, $parentid);
							if($res)continue;
						}
						
						$insert_id = $classself_db -> add($data);
						if(!$insert_id) $this->error("保存分类失败！");
					}

					
				}
				$this->success("保存分类成功！", U('Index/desAdd', array('info_id'=>$info_id, 'step'=>2, 'act'=>$act, 'lsttype'=>$lsttype)));
			
			}
		}
	}
	/**
	* 判断该年款是否存在
	**/
	public function desExits(){
		//判断是否已添加
		$info_db = D('Info');
		$logo = I('post.logoid');
		$series = I('post.seriesid');
		$years = I('post.years');

		$info = $info_db -> getInfoByPro($logo, $series, $years);
		$msg = ($info) ? '2' : '1';
		exit($msg);
		
	}
	/**
	* 添加说明书图片
	*/
	public function imgAdd(){
		
		if(IS_POST){
			$pic_db = D('Pic');
			$info_db = D('Info');

			$filenames = I('post.filenames');
			$args = I('post.args');
			
			if($filenames && $args){
				$filenameArr = explode('|', $filenames);
				$classid = $args[0];
				$meta_id = $args[1];
				$info_id = $args[2];

				$logoid = $args[3];
				$seriesid = $args[4];
				$years = $args[5];
				$username = $_SESSION['name'];
				$time = time();
				
				$meta_id = ($meta_id) ? $meta_id : 0;
				/*$info_data = array('logoid'=>$logoid, 'seriesid'=>$seriesid, 'years'=>$years, 'adduser'=>$username, 'addtime'=>$time, 'edittime'=>$time);
				$last_id = $info_db -> add($info_data);*/

				//$picArr = array();
				foreach($filenames as $img){
					$pic_data = array('infoid'=>$last_id, 'metaid'=>$meta_id, 'infoid'=>$info_id, 'classid'=>$classid, 'imgurl'=>$img, 'adduser'=>$username, 'addtime'=>$time);
					$pic_id = $pic_db -> add($pic_data);
					if(!$pic_id)exit('2');
				}
				
				exit('1');
			}else{
				exit('2');
			}
		}
	}

	/**
	* 查看说明图片
	**/
	public function imgView(){
		$pic_db = D('Pic');
		$Proclass_db = D('Proclass');

		$class_id = I('get.class_id');
		$info_id = I('get.info_id');
		$meta_id = I('get.meta_id');
		
		if($meta_id){
			$pic_list = $pic_db -> getPicList($info_id, $class_id, $meta_id);
		}else{
			$pic_list = $pic_db -> getPicList($info_id, $class_id);
		}
		foreach($pic_list as &$pic_info){
			$class_info = $Proclass_db -> getSelectInfo($pic_info['classid']);
			$pic_info['classname'] = $class_info['classname'];
			$pic_info['add_time'] = date('Y-m-d H:i:s',$pic_info['addtime']);
		}
		
		$this->assign('list', $pic_list);
		$this->assign('info_id', $info_id);
		$this->display('imgview');
	}

	/**
	* 保存图片说明
	**/
	public function contentSave(){
		$pic_db = D('Pic');
		
		if(IS_POST){
			$photo_id = I('post.photo_id');
			$content_value = I('post.content');
			$data = array('description'=>$content_value);
			$res = $pic_db->where('id='.$photo_id)->save($data);
			if($res){
				exit('1');
			}else{
				exit('2');
			}
		}
	}

	/**
	* 坐标添加
	**/
	public function metaAdd(){
		$meta_db = D('Meta');

		$photo_id = I('get.photo_id');
		$class_id = I('get.class_id');
		$info_id = I('get.info_id');
		
		$info = D('Info');
		$pro_info = $info -> getInfoById($info_id);//用于参数传递
		$meta_list = $meta_db -> getMetaListByPicid($photo_id);
		$this->assign('list', $meta_list);
		$this->assign('photo_id', $photo_id);
		$this->assign('class_id', $class_id);
		$this->assign('info_id', $info_id);
		$this->assign('pro_info', $pro_info);
		$this->display('metaadd');
	}

	/**
	* 坐标修改
	**/
	public function metaEdit(){
		$photo_id = I('get.photo_id');
		$meta_id = I('get.meta_id');
		$act = I('get.type');

		if($act == 'edit'){
			$meta_db = D('Meta');
			$metaInfo = $meta_db-> getMetaInfo($meta_id);
			$this->assign('meta_id', $meta_id);
			$this->assign('metaInfo', $metaInfo);
		}
		$this->assign('photo_id', $photo_id);
		$this->display('metaedit');
	}

	/**
	* 坐标保存处理
	**/
	public function metaSave(){
		$meta_db = D('Meta');
		if(IS_POST){
			$act = I('post.act');
			$listorder = I('post.listorder');
			$metaname = I('post.metaname');
			$posx = I('post.posx');
			$posy = I('post.posy');
			$content = I('post.content');
			$photo_id = I('post.photo_id');
			$meta_id = I('post.meta_id');

			$time = time();
			$username = $_SESSION['name'];

			$data = array('listorder'=>$listorder, 'picid'=>$photo_id, 'metaname'=>$metaname, 'posx'=>$posx, 'posy'=>$posy, 'description'=>$content, 'addtime'=>$time, 'adduser'=>$username);
			
			if($act == 'add'){
				$res = $meta_db -> add($data);
				if($res){
					exit('add_1');
				}else{
					exit('add_2');
				}
			}else{
				$meta_data = array('listorder'=>$listorder, 'metaname'=>$metaname, 'posx'=>$posx, 'posy'=>$posy, 'description'=>$content, 'addtime'=>$time, 'adduser'=>$username);
				$res = $meta_db->where('id='.$meta_id)->save($meta_data);
				if($res){
					exit('edit_1');
				}else{
					exit('edit_2');
				}
			}
		}
	
	}

	/**
	* 删除坐标
	**/
	public function metaDel(){
		$meta_db = D('Meta');
		$meta_ids = I('get.ids');
		$metaArr = explode(',', $meta_ids);
			
		foreach($metaArr as $id){
			$res = $meta_db->where('id='.$id)->delete();
			if(!$res)exit('2');
		}
		exit('1');
	}

	/**
	* 添加自定义分类
	**/
	public function classSelfAdd(){
		$classself_db = D('ClassSelf');

		if(IS_POST){
			$infoid = intval(I('post.infoid'));
			$classname = I('post.classname');
			$parentid = intval(I('post.parentid'));
			$description = I('post.description');
			$imgurl = I('post.imgurl');
			$username = $_SESSION['name'];
			$time = time();

			$data = array('parentid'=>$parentid, 'classname'=> $classname, 'infoid'=> $infoid, 'image'=> $imgurl, 'description'=> $description, 'addtime'=>$time, 'adduser'=>$username);
			$_id = $classself_db -> add($data);
			if($_id > 0){
				$updateid = $classself_db->where('id='.$_id)->save(array('classid'=>$_id));
			}
			$msg = ($updateid) ? '1' : '2';
			exit($msg);
		}else{
			$infoid = intval(I('get.info_id'));
			$classid = intval(I('get.class_id'));
			$parentid = intval(I('get.parent_id'));

			$res = $classself_db->getInfoByAllId($infoid, $classid, $parentid);

			$this->assign('self_class', $res);
			$this->display('classselfadd');
		}
	}
	
}