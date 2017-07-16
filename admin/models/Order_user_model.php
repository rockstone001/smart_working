<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order_user_Model extends Base_Model {
	
	const TABLE_NAME = 'users';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

    public function get_users_by_nickname($nickname)
    {
        $query = $this->db->select('id')
            ->like('nickname', $nickname)
            ->get(static::TABLE_NAME);
        $rows = $query->result_array();
        print_r($rows);
    }

}