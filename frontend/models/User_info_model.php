<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_Info_Model extends Base_Model {
	
	const TABLE_NAME = 'user_info';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	public function get_detail($id)
	{
		$this->db->select('user_info.*, lessons.title as lesson_title, lessons.start_time as lesson_start_time,
		lessons.end_time as lesson_end_time, lessons.city as lesson_city,
		lessons.charge, lessons.type as lesson_type, lessons.address as lesson_address, lessons.linkman, lessons.contract_number');
		$this->db->from('orders');
		$this->db->join('lessons', 'orders.lesson_id = lessons.id');
		$this->db->where([
			'orders.id' => $id
		]);
		$query = $this->db->get();
//		print_r($query->row_array());  die();
		return $query->row_array();
	}


}