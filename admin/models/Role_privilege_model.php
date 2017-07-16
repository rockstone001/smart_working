<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Role_privilege_Model extends Base_Model {
	
	const TABLE_NAME = 'role_privilege';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	public function remove_all_privilege($role_id)
	{
		return $this->db->delete(static::TABLE_NAME, [
			'role_id' => $role_id
		]);
	}

	public function get_privilege_by_role_id($role_id) {
		$data = [];
		$query = $this->db->select('privilege_id')
			->where([
			'role_id' => $role_id
			])->get(self::TABLE_NAME);
		$res = $query->result_array();
		foreach ($res as $v) {
            $data [] = $v['privilege_id'];
        }
        return $data;
	}

    public function get_all_actions_by_role_id($role_id)
    {
        $sql = "select a.privilege_id, b.action from role_privilege as a
                left join `privileges` as b on a.privilege_id = b.id
                where a.role_id = $role_id";
        $query = $this->db->query($sql);
        $rows = $query->result_array();

        $data = [];
        foreach ($rows as $v) {
            $data[] = $v['action'];
        }
        return $data;
    }

	public function get_all_privileges_by_role_id($role_id)
	{
		$sql = "select a.privilege_id, b.name from role_privilege as a
                left join `privileges` as b on a.privilege_id = b.id
                where a.role_id = $role_id";
		$query = $this->db->query($sql);
		$rows = $query->result_array();

		$data = [];
		foreach ($rows as $v) {
			$data[] = $v['name'];
		}
		return $data;
	}
}