<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Lesson_Model extends Base_Model {
	
	const TABLE_NAME = 'lessons';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	public function update_limit_num($id)
	{
		$this->db->where([
			'id' => $id
		]);
		$this->db->set('limit_num', 'limit_num - 1', FALSE);
		return $this->db->update(static::TABLE_NAME);
	}

	public function return_back_limit_num($id)
	{
		$this->db->where([
			'id' => $id
		]);
		$this->db->set('limit_num', 'limit_num + 1', FALSE);
		return $this->db->update(static::TABLE_NAME);
	}

	public function get_lessons($columns, $where=[])
	{
		$where_string = '1 = 1';
		foreach ($where as $k=>$v) {
			$where_string .= " and $k='$v'";
		}
		$sql = "select $columns from lessons where $where_string order by at_top desc, start_time asc limit 100 offset 0";
//		echo $sql;
		$query = $this->db->query($sql);
		return $query->result_array();

//		return $this->db->order_by($order_column, $order_type)
//			->limit($limit, $offset)
//			->select($column)->get_where(
//				static::TABLE_NAME,
//				$where
//			)->result_array();
	}

}