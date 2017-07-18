<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class City_Model extends Base_Model {
	
	const TABLE_NAME = 'cities';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	public function get_all_city()
	{
		$query = $this->db->select('id, name')
			->where([
				'state' => 1,
			])->get(self::TABLE_NAME);
		$rows = $query->result_array();
		$data[0] = '无';
		foreach ($rows as $v) {
			$data[$v['id']] = $v['name'];
		}
		return $data;
	}
}