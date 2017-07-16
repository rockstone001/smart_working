<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category_Model extends Base_Model {
	
	const TABLE_NAME = 'category';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	public function get_cate_list($where = [], $limit = 10, $offset = 0, $like = '')
	{
		$query = $this->db->select('id, name, desc, list_style')
			->where($where)->like('name', $like)->limit($limit)->offset($offset)
			->get(self::TABLE_NAME);
		$rows = $query->result_array();
		empty($rows) && $rows = [];

		$list_style = config_item('list_style');
		foreach ($rows as &$row) {
			$row['list_style'] = $list_style[$row['list_style']];
		}

		$query = $this->db->select("count(*) as total")
			->where($where)->like('name', $like)
			->get(self::TABLE_NAME);
		$total = current($query->row_array());

		return [
			'total' => $total,
			'rows' => $rows
		];
	}

	public function get_all_category()
	{
		$query = $this->db->select('id, name')
			->where([
				'state' => 1
			])->get(self::TABLE_NAME);
		$rows = $query->result_array();
		$data[0] = '无分类';
		foreach ($rows as $v) {
			$data[$v['id']] = $v['name'];
		}
		return $data;
	}

	public function get_all_category_2()
	{
		$query = $this->db->select('id, name')
			->get(self::TABLE_NAME);
		$rows = $query->result_array();
		$data[0] = '无分类';
		foreach ($rows as $v) {
			$data[$v['id']] = $v['name'];
		}
		return $data;
	}

	public function get_all_available_cate_link()
	{
		$query = $this->db->select('id, name')->where([
			'state' => 1
		])->get(self::TABLE_NAME);
		$rows = $query->result_array();
		$links = [];
		foreach ($rows as $row) {
			$links[] = [
				'link' => '/category/' . $row['id'],
				'title' => $row['name']
			];
		}
		return $links;
	}

}