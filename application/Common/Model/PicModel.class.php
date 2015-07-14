<?php
namespace Common\Model;
use Common\Model\CommonModel;

class PicModel extends CommonModel{
	protected $tableName = 'pic';
	protected $pk             = 'id';
	public      $error;
	
	/**
	 * 获取车系列表
	 */
	public function getPicList($proid=0,$classid=0, $mata_id=0){
		$order = '`id` DESC';
		$field = array('id','infoid','classid','metaid','imgurl','addtime','adduser','description');
		
		$where = array();
		if($proid && $classid == 0){
			$where = array('infoid' => $proid, 'disabled'=>'0');
		}elseif($proid && $classid && $mata_id){
			$where = array('infoid' => $proid, 'classid' => $classid, 'metaid'=> $mata_id, 'disabled'=>'0');
		}elseif($proid && $classid){
			$where = array('infoid' => $proid, 'classid' => $classid, 'disabled'=>'0');
		}elseif($proid == 0 && $classid){
			$where = array('classid' => $classid, 'disabled'=>'0');
		}
		$data = $this->field($field)->where($where)->order($order)->select();
		//echo $this->getLastSql();
		return $data;
	}


}