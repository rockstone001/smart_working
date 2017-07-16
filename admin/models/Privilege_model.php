<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Privilege_Model extends Base_Model {
	
	const TABLE_NAME = 'privileges';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	public function get_all_privileges()
	{
		$query = $this->db->select('id, name, desc')->order_by('name', 'asc')
			->where([
				'state' => 1,
			])->get(self::TABLE_NAME);
		return $query->result_array();
	}

}