<?php
namespace Common\Model;
use Common\Model\CommonModel;

class MetaModel extends CommonModel{
	protected $tableName = 'meta';
	protected $pk             = 'id';
	public      $error;
	
	/**
	 * 按图片ID获取锚点列表
	 */
	public function getMetaListByPicid($photo_id){
		if(!$photo_id)return false;
		$order = '`id` DESC';
		$field = array('id','picid','metaname','posx','posy','listorder', 'addtime','adduser','description');

		$where = array('picid' => $photo_id);
		$data = $this->field($field)->where($where)->order($order)->select();
		//echo $this->getLastSql();
		return $data;
	}

	/**
	* 通过ID获取一条信息
	**/
	public function getMetaInfo($meta_id){
		if(!$meta_id)return false;
		$field = array('id','picid','metaname','posx','posy','addtime','listorder', 'adduser','description');

		$where = array('id' => $meta_id);
		$meta_info = $this->field($field)->where($where)->find();
		return $meta_info;
	}

}