<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Menu_Model extends Base_Model {
	
	const TABLE_NAME = 'menu';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	public function get_menu_list($namelike = '', $limit = 10, $offset = 0)
	{


        $sql = "select a.id, a.name, a.sequence, b.name as parent_name from menu as a
				left join menu as b on a.parent_id = b.id where a.state = 1
				and a.name like '%$namelike%' limit $limit offset $offset";

		$query = $this->db->query($sql);
		$rows = $query->result_array();
		empty($rows) && $rows = [];

		$query = $this->db->query("select count(*) as total from menu as a
				left join menu as b on a.parent_id = b.id where a.state = 1
				and a.name like '%$namelike%'");
		$total = current($query->row_array());

		return [
			'total' => $total,
			'rows' => $rows
		];
	}

	public function get_all_menu()
	{
		$query = $this->db->select('id, name')
			->where([
				'state' => 1,
                'parent_id' => 0,
                'link !=' => ''
			])->get(self::TABLE_NAME);
		$rows = $query->result_array();
		$data[0] = '无';
		foreach ($rows as $v) {
			$data[$v['id']] = $v['name'];
		}
		return $data;
	}
}