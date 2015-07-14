<?php
namespace Common\Model;
use Common\Model\CommonModel;

class ModelsModel extends CommonModel{
	protected $tableName = 'model';
	protected $pk             = 'id';
	public      $error;
	
	/**
	 * 获取车型列表
	 */
	public function getModelList($seriesid,$mode='years'){
		$seriesid = intval($seriesid);
		$order = '`model_year` DESC';
		$field = array('model_id','model_year','m_name');
		$where = array('bseries_id' => $seriesid, 'isshow' => 'yes');
		$group = ($mode == 'years') ? 'model_year' : '';
		$data = $this->field($field)->where($where)->order($order)->group($group)->select();
		//echo $this->getLastSql();
		return $data;
	}

	/**
	* 获取车型信息
	*/

}