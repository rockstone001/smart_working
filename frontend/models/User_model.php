<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_Model extends Base_Model {
	
	const TABLE_NAME = 'users';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	public function get_user_by_openid($openid) {
		$sql = "select a.*, b.ID_photo1, b.ID_photo2, b.salary_photo1, b.salary_photo2 from users as a
				left join user_info as b on a.id = b.uid where a.openid = '$openid'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

}