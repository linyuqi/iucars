<?php
namespace Common\Model;
use Common\Model\CommonModel;

class VehicleModel extends CommonModel{
	protected $tableName = 'vehicle';
	protected $pk             = 'id';
	public      $error;
	
	/**
	 * 获取车系列表
	 */
	public function getVehicleList($info_id){
		$order = '`id` DESC';
		$field = array('id','info_id','author','content','stat','addtime','edtime','adduser');
		$where = array('info_id' => $info_id);
		$data = $this->field($field)->where($where)->order($order)->select();
		return $data;
	}
	
	/*
	 *获取车震数总数 
	 */
	 public function getVehicleCount($info_id)
	 {
	 	$where = array('info_id' => $info_id);
		$data = $this->where($where)->count();
		return $data > 0 ? "<font color=green><a href='/index.php?g=Vehicle&m=Index&a=veList&info_id=".$info_id."'>".$data."</a></font>" : "<font color=red>".$data."</font>";
	 }


}