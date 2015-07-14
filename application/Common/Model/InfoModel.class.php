<?php
namespace Common\Model;
use Common\Model\CommonModel;

class InfoModel extends CommonModel{
	protected $tableName = 'info';
	protected $pk             = 'id';
	public      $error;
	
	/**
	 * 获取车系列表
	 */
	public function getInfoList(){
		$order = '`id` DESC';
		$field = array('id','logoid','years','seriesid','modelid','listorder','addtime','edittime');
		$where = array('disabled' => 0);
		$data = $this->field($field)->where($where)->order($order)->select();
		
		$series_db = D('Series');
		$logo_db = D('Logo');

		foreach($data as &$row){
			$series_id = $row['seriesid'];
			$logo_id = $row['logoid'];
			$series_info = $series_db -> getSerieInfo($series_id);
			$logo_info = $logo_db -> getLogoInfo($logo_id);
			$row['logo_name'] = $logo_info['signname'];
			$row['series_name'] = $series_info['showname'];
		}
		//echo $this->getLastSql();
		return $data;
	}

	/**
	* 按ID查询信息
	*/
	public function getInfoById($id){
		if(empty($id)) return false;
		$field = array('id','logoid','years','seriesid','modelid','listorder','addtime','edittime');
		$where = array('id' => $id);
		$info = $this->field($field)->where($where)->find();
		return $info;
	}

	/**
	* 按品牌、车系、年款查询信息
	*/
	public function getInfoByPro($logoid,$seriesid,$year, $type='yeas'){
		if(empty($logoid) && empty($seriesid) && empty($year)) return false;
		$field = array('id','logoid','years','seriesid','modelid','listorder','addtime','edittime');
		if($type == 'years'){
			$where = array('logoid' => $logoid, 'seriesid'=>$seriesid, 'years'=>$year);
		}else{
			$where = array('logoid' => $logoid, 'seriesid'=>$seriesid, 'modelid'=>$year);
		}
		$info = $this->field($field)->where($where)->find();
		/*echo $year;
		echo $this->getLastSql();*/
		return $info;
	}


}