<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_Info_Model extends Base_Model {
	
	const TABLE_NAME = 'user_info';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	public function get_users_by_lessonid($lesson_id)
	{
		$this->db->select('user_info.*, orders.city, orders.start_time, orders.address');
		$this->db->from('orders');
		$this->db->join('user_info', 'orders.uid = user_info.uid');
		$this->db->where([
			'orders.lesson_id' => $lesson_id,
			'orders.state' => 1
		]);
		$query = $this->db->get();
//		print_r($query->result_array());  die();
		return $query->result_array();
	}


}