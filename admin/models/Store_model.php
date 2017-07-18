<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Store_Model extends Base_Model {
	
	const TABLE_NAME = 'stores';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	public function get_all_store()
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

    public function get_company_city_store()
    {
        $data = [];
        $sql = 'select c.id as company_id, c.name as company_name,
                city.id as city_id, city.name as city_name,
                s.id as store_id, s.name as store_name
                from companies as c
                left join cities as city on city.company_id = c.id
                left join stores as s on s.city_id = city.id
                where c.state = 1';
        $query = $this->db->query($sql);
        $rows = $query->result_array();
        foreach ($rows as $v) {
            $data[$v['company_id']]['company_name'] = $v['company_name'];
            if (isset($v['city_id'])) {
                $data[$v['company_id']]['city'][$v['city_id']]['name'] = $v['city_name'];
                if (isset($v['store_id'])) {
                    $data[$v['company_id']]['city'][$v['city_id']]['store'][$v['store_id']] = $v['store_name'];
                } else {
                    $data[$v['company_id']]['city'][$v['city_id']]['store'] = [];
                }
            } else {
                $data[$v['company_id']]['city'] = [];
            }
        }
//        echo json_encode($data);
//        print_r($data);
//        die();
        return $data;
    }
}







