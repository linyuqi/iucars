<?php
namespace Common\Model;
use Common\Model\CommonModel;

class ProclassModel extends CommonModel{
	protected $tableName = 'class';
	protected $pk        = 'id';

	protected $_validate = array(
			//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
			array('classname', 'require', '分类名称不能为空！', 1, 'regex', 3),
			array('description', 'require', '分类描述不能为空！', 1, 'regex', 3),
	);	
	//获取栏目列表
	public function getTree($parentid = 0){
		$field = array('id','logoid','seriesid','years','classid','type','parentid','classname','description','listorder','disabled','addtime','edittime','adduser','`id` as `operateid`');
		$order = '`listorder` ASC,`id` ASC';
		$data = $this->field($field)->where(array('parentid'=>$parentid,'type'=>'sys'))->order($order)->select();
		if (is_array($data)){
			foreach ($data as &$arr){
				$arr = array_merge($arr, array(
					'field_view'     => 'view',
					'field_add'      => 'add',
					'field_edit'     => 'edit',
					'field_delete'   => 'delete',
				));
				$arr['children'] = $this->getTree($arr['id']);
			}
		}else{
			$data = array();
		}
		return $data;
	}
	

	/**
	 * 检查上级菜单设置是否正确
	 */
	public function checkParentId($id, $parentid){
		if($id == $parentid) return false;  //上级菜单不能与本级菜单相同
		$order = '`listorder` ASC,`id` ASC';
		$data = $this->field(array('id'))->where(array('parentid'=>$id))->order($order)->select();
		if(is_array($data)){
			foreach ($data as &$arr){
				if($arr['id'] == $parentid) return false; //上级菜单不能与本级菜单子菜单
	
				return $this->checkParentId($arr['id'], $parentid);
			}
		}else{
			return true;
		}
		return true;
	}

	//栏目下拉列表
	public function getSelectTree($parentid = 0){
		$field = array('`id`','`classname` as `text`','`parentid`');
		$order = '`listorder` ASC,`id` ASC';
		$data = $this->field($field)->where(array('parentid'=>$parentid,'type'=>'sys'))->order($order)->select();
		if (is_array($data)){
			foreach ($data as &$arr){
				$arr['children'] = $this->getSelectTree($arr['id']);
			}
		}else{
			$data = array();
		}
		return $data;
	}

	//栏目列表
	public function getTreeList($disabled=1,$sys='sys'){
		$field = array('id','logoid','seriesid','years','classid','type','parentid','classname','description','listorder','disabled','addtime','edittime','adduser','`id` as `operateid`');
		$order = '`listorder` ASC,`id` ASC';
		$where = array();
		if($disabled != -1){
			$where['disabled'] = $disabled;	
		}
		$where['type'] = $sys;

		$data = $this->field($field)->where($where)->order($order)->select();
		return $data;
	}
	//根据ID获取一条信息
	public function getSelectInfo($id){
		$field = array('classname');
		$where = array('id'=>$id);
		$data = $this->field($field)->where($where)->find();
		return $data;
	}
}