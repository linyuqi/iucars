<?php
namespace Product\Controller;
use Common\Controller\AdminbaseController;

/**
 * 后台管理通用模块
 * @author wangdong
 */
class IndexController extends AdminbaseController {
	/**
	 * 分类列表
	 */
	public function classList(){

		$pro_class_db = D('Proclass');
		$data = $pro_class_db->getTreeList('-1');
		$tree = new \Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($data as $r) {
			$r['str_manage'] = '<a href="' . U("index/classAdd", array("parentid" => $r['id'])) . '">添加子类</a> | <a href="' . U("index/classEdit", array("id" => $r['id'])) . '">修改</a>';
			if($r['disabled'] == 0){
				$r['str_manage'] .= '| <a class="J_ajax_recovery" href="' . U("index/classRecovery", array("id" => $r['id'])) . '">启用</a> ';
			}else{
				$r['str_manage'] .= '| <a class="J_ajax_disable" href="' . U("index/classDelete", array("id" => $r['id'])) . '">禁用</a> ';
			}
			$r['disabled'] = ($r['disabled'] == 1) ? '启用':'<font color="red">禁用</font>';
			$r['id']=$r['id'];
			$array[] = $r;
		}
		$tree->init($array);
		$str = "<tr>
					<td><input name='listorders[\$id]' type='text' size='3' value='\$listorder' class='input input-order'></td>
					<td>\$id</td>
					<td>\$spacer \$classname</td>
	    			<td>\$description</td>
					<td align='center'>\$disabled</td>
					<td>\$str_manage</td>
				</tr>";
		$taxonomys = $tree->get_tree(0, $str);

		$this->assign("taxonomys", $taxonomys);
		$this->display();
	}

	
	/**
	 * 添加栏目
	 */
	public function classAdd(){
		if(IS_POST){
			$pro_class_db = D('Proclass');
			$data = I('post.');
			$data['type'] = 'sys';
			$data['addtime'] = time();
			$data['adduser'] = $_COOKIE['admin_username'];
			if($pro_class_db->create($data)){
				$id = $pro_class_db->add($data);
				if($id){
					$this->success('添加成功',U("Index/classList"));
				}else {
					$this->error('添加失败');
				}
			}else{
				$this->error($pro_class_db->getError());
			}

		}else{
			$pro_class_db = D('Proclass');
		 	$parentid = intval(I("get.parentid"));
		 	$tree = new \Tree();
		 	$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		 	$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		 	$terms = $pro_class_db->getTreeList('-1');
		 	$new_terms=array();
		 	foreach ($terms as $r) {
		 		$r['id']=$r['id'];
		 		$r['selected'] = $r['id']==$parentid?"selected":"";
		 		$new_terms[] = $r;
		 	}
		 	$tree->init($new_terms);
		 	$tree_tpl="<option value='\$id' \$selected>\$spacer\$classname</option>";
		 	$tree=$tree->get_tree(0,$tree_tpl);
		 	$this->assign("terms_tree",$tree);
			$this->assign('disabled', array('1'=>"启用",'0'=>'禁用'));
			$this->display();
		}
	}
	/**
	 * 编辑栏目
	 */
	public function classEdit($id){
		$pro_class_db = D('Proclass');
		if(IS_POST){
			$data = I('post.');
			$data['edittime'] = time();
			if($pro_class_db->create($data)){
				$res = $pro_class_db->where(array('id'=>$id))->save($data);
				if($res){
					$this->success('操作成功',U("Index/classList"));
				}else {
					$this->error('操作失败');
				}
			}else{
				$this->error($pro_class_db->getError());
			}

		}else{
			$data = $pro_class_db->where(array('id'=>$id))->find();
		 	$tree = new \Tree();
		 	$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		 	$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		 	$terms = $pro_class_db->getTreeList('-1');
		 	$new_terms=array();
		 	foreach ($terms as $r) {
		 		$r['id']=$r['id'];
		 		$r['selected'] = ($r['id']==$data['parentid'])?"selected":"";
		 		$new_terms[] = $r;
		 	}
		 	$tree->init($new_terms);
		 	$tree_tpl="<option value='\$id' \$selected>\$spacer\$classname</option>";
		 	$tree=$tree->get_tree(0,$tree_tpl);
		 	$this->assign("terms_tree",$tree);

			$this->assign('data', $data);
			$this->assign('disabled', array('1'=>"启用",'0'=>'禁用'));
			$this->display();
		}
	}	


	/**
	 * 栏目排序
	 */
	public function classOrder(){
		if(IS_POST) {
			$pro_class_db = D('Proclass');
			foreach(I('post.listorders') as $id => $listorder) {
				$pro_class_db->where(array('id'=>$id))->save(array('listorder'=>$listorder));
			}
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}

	
	/**
	 * 恢复栏目
	 */
	public function classRecovery($id = 0){
		if($id >0){
			$pro_class_db = D('Proclass');
			$where = array('id'=>$id);
			$result = $pro_class_db->where($where)->save(array('disabled'=>1));
			if($result){
				$this->success('恢复成功');
			}else {
				$this->error('恢复失败');
			}
		}else{
			$this->error('恢复失败');
		}
	}

	/**
	 * 删除栏目
	 */
	public function classDelete($id = 0){

		if($id >0){
			$pro_class_db = D('Proclass');
			//$count = $pro_class_db->where(array("parentid" => $id,'disabled'=>1))->count();
			if ($count > 0) {
				$this->error("该菜单下还有子类，无法删除！");
			}

			$where = array('id'=>$id);
			$result = $pro_class_db->where($where)->save(array('disabled'=>0));
			if($result){
				$this->success('删除成功');
			}else {
				$this->error('删除失败');
			}
		}else{
			$this->error('删除失败');
		}
	}


	
}