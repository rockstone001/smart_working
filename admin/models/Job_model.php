<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Post_Model extends Base_Model {
	
	const TABLE_NAME = 'post';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	public function get_post_list($where = [], $limit = 10, $offset = 0, $like = '')
	{
		$query = $this->db->select('id, title, cate_id')
			->where($where)->like('title', $like)->limit($limit)->offset($offset)
			->get(self::TABLE_NAME);
		$rows = $query->result_array();
		empty($rows) && $rows = [];

		$query = $this->db->select("count(*) as total")
			->where($where)->like('title', $like)
			->get(self::TABLE_NAME);
		$total = current($query->row_array());

		return [
			'total' => $total,
			'rows' => $rows
		];
	}

    public function get_all_available_post_link()
    {
        $query = $this->db->select('id, title')->where([
            'state' => 1
        ])->get(self::TABLE_NAME);
        $rows = $query->result_array();
        $links = [];
        foreach ($rows as $row) {
            $links[] = [
                'link' => '/post/' . $row['id'],
                'title' => $row['title']
            ];
        }
//        print_r($links);
        return $links;
    }
}