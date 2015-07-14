<?php
namespace Common\Model;
use Common\Model\CommonModel;

class BrandModel extends CommonModel{
	protected $tableName = 'brand';
	protected $pk             = 'id';
	public      $error;
	
	/**
	 * 获取厂商列表
	 */
	public function getBrandList($logoid){
		$logoid = intval($logoid);
		$order = '`id` DESC';
		$field = array('name,brand_id,logo_id');
		$data = $this->field($field)->where(array('logo_id'=>$logoid, 'isshow'=>'yes'))->order($order)->select();
		return $data;
	}


	/**
	* 获取车系信息
	*/
	public function getSerieInfo($userid){
		$roleid = intval($roleid);
		$rolename = $this->where(array('roleid'=>$roleid))->getField('rolename');
		return $rolename;
	}
	
	/**
	 * 修改密码
	 */
	public function editPassword($userid, $password){
		$userid = intval($userid);
		if($userid < 1) return false;
		$passwordinfo = password($password);
		return $this->where(array('userid'=>$userid))->save($passwordinfo);
	}
}