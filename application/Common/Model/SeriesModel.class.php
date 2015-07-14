<?php
namespace Common\Model;
use Common\Model\CommonModel;

class SeriesModel extends CommonModel{
	protected $tableName = 'series';
	protected $pk             = 'id';
	public      $error;
	
	/**
	 * 获取车系列表
	 */
	public function getSeriesList($logoid){
		$logoid = intval($logoid);
		$brandModel = D('Brand');
		$brand_list = $brandModel->getBrandList($logoid);
		
		$list = array();
		foreach($brand_list as $brandInfo){
			if(count($brand_list) > 1){
				$row['name'] = '=='.$brandInfo['name'];
				$row['id'] = $brandInfo['logo_id']."_b";
				$list[] = $row;	
			}

			$brandid = $brandInfo['brand_id'];
			$order = '`id` DESC';
			$field = array('showname','bseries_id','minprice','maxprice');
			$where = array('brand_id' => $brandid, 'isshow' => 'yes', 'salestate' => array('IN', '在销,待销'), 'level' => array('NEQ','概念车'));
			$data = $this->field($field)->where($where)->order($order)->select();
			//echo $this->getLastSql()."<br />";
			if($data){
				foreach($data as $key => $bseries_name){
					$row['name'] = '--'.$bseries_name['showname'];
					$row['id'] = $bseries_name['bseries_id']."_c";
					$row['bseries_id'] = $bseries_name['bseries_id'];
					$row['range'] = round($bseries_name['minprice']/10000,2).'-'.round($bseries_name['maxprice']/10000,2).'万';
					$list[] = $row;
				}
			}
		}
		return $list;
	}


	/**
	* 获取车系信息
	*/
	public function getSerieInfo($seriesid){
		$seriesid = intval($seriesid);
		$field = array('bseries_id','name','showname','brand_id','level');
		$where = array('bseries_id'=>$seriesid);
		$seriesinfo = $data = $this->field($field)->where($where)->find();
		return $seriesinfo;
	}
	
}