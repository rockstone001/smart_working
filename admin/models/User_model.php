<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_Model extends Base_Model {
	
	const TABLE_NAME = 'users';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

    /**
     * @param $pwd
     * @return string
     * @desc 生成密码
     */
    public function generate_password($pwd)
    {
        $hasher = new PasswordHash(8, true);

        return $hasher->HashPassword($pwd);
    }

    public function check_password($pwd, $pwd_stored)
    {
        $hasher = new PasswordHash(8, true);
        return $hasher->CheckPassword($pwd, $pwd_stored);
    }

    public function get_user_list($limit, $offset, $like='')
    {
        $sql = "select a.id, a.username, a.nickname, a.mobile, a.state, a.employee_id, a.address, a.email, b.name as role from users as a
				left join roles as b on a.role_id = b.id where a.state = 1
				and a.username like '%$like%' limit $limit offset $offset";

        $query = $this->db->query($sql);
        $rows = $query->result_array();
        empty($rows) && $rows = [];

        $query = $this->db->query("select count(*) from users as a
				left join roles as b on a.role_id = b.id where a.state = 1
				and a.username like '%$like%'");
        $total = current($query->row_array());

        return [
            'total' => $total,
            'rows' => $rows
        ];
    }

    public function get_all_users($like)
    {
        $sql = "select u.id, u.nickname, i.username from users as u left join user_info as i on u.id = i.uid where u.nickname like '%$like%' or i.username like '%$like%' order by u.id desc";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_user_by_id($id) {
        $sql = "select a.*, b.ID_photo1, b.ID_photo2, b.salary_photo1, b.salary_photo2 from users as a
				left join user_info as b on a.id = b.uid where a.id = $id";
        $query = $this->db->query($sql);
        return $query->row_array();
    }
}