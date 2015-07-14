<?php
namespace Common\Model;
use Common\Model\CommonModel;

class ClassSelfModel extends CommonModel{
	protected $tableName = 'class_self';
	protected $pk             = 'id';
	public      $error;
	
	/**
	 * 获取车系列表
	 */
	public function getClassSelfList($info_id=0){
		if(!$info_id)return false;
		$order = '`listorder` ASC,`id` ASC';
		$field = array('id','infoid','classid','parentid','classname','addtime','adduser','description','listorder');
		
		$where = array('infoid' => $info_id);
		$data = $this->field($field)->where($where)->order($order)->select();
		//echo $this->getLastSql();
		return $data;
	}

	/**
	* 按ID查询信息
	*/
	public function getInfoByAllId($info_id,$class_id,$parent_id){
		if(empty($info_id)) return false;
		$field = array('id','infoid','classid','parentid','classname','addtime','adduser','description','listorder');
		$where = array('infoid' => $info_id, 'classid'=>$class_id, 'parentid'=>$parent_id);
		$info = $this->field($field)->where($where)->find();
		return $info;
	}



}