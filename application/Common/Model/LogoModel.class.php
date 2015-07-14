<?php
namespace Common\Model;
use Common\Model\CommonModel;

class LogoModel extends CommonModel{
	protected $tableName = 'logo';
	protected $pk             = 'id';
	public      $error;
	
	/**
	 * 获取品牌列表
	 */
	public function getLogoList(){
		$order = '`initial` ASC';
		$field = array('initial','signname as name','bitauto_logo_id as logo_id');
		$where = array('isshow' => 'yes' , 'initial' => array('NEQ',''));
		$data = $this->field($field)->where($where)->order($order)->select();
		foreach($data as &$row){
			$row['name'] = $row['initial'].'-'.$row['name'];
			$row['id'] = $row['logo_id'];
		}
		//echo $this->getLastSql();
		return $data;
	}

	/**
	*	获取品牌基本信息
	*/
	public function getLogoInfo($logo_id){
		$logo_id = intval($logo_id);
		$field = array('signname','initial','bitauto_logo_id','area','pinyin');
		$where = array('bitauto_logo_id'=>$logo_id);
		$logoinfo = $this->field($field)->where($where)->find();
		return $logoinfo;
	}
}