<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Company_Model extends Base_Model {
	
	const TABLE_NAME = 'companies';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	public function get_all_company()
	{
		$query = $this->db->select('id, name, desc')
			->where([
				'state' => 1,
			])->get(self::TABLE_NAME);
		$rows = $query->result_array();
		$data[0] = '无';
		foreach ($rows as $v) {
			$data[$v['id']] = $v['desc'];
		}
		return $data;
	}
}