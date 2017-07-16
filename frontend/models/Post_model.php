<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Post_Model extends Base_Model {
	
	const TABLE_NAME = 'post';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	public function get_posts_by_cate_id($cate_id, $limit = 10, $offset = 0)
	{
		$query = $this->db->select('id, title, sub_title, pic, sub_pic, updated_at, summary')
			->where([
				'cate_id' => $cate_id,
				'state' => 1
			])->limit($limit)->offset($offset)
			->get(self::TABLE_NAME);
		return $query->result_array();
	}

	public function get_cateid_by_postid($id)
	{
		$query = $this->db->select('cate_id')
			->where([
				'id' => $id
			])
			->get(self::TABLE_NAME);
		return $query->result_row();
	}

	public function get_postid_by_cateid($cate_id)
	{
		$query = $this->db->select('id')
			->where([
				'cate_id' => $cate_id,
				'state' => 1
			])
			->get(self::TABLE_NAME);
		$res = $query->result_array();
		$data = [0];
		foreach ($res as $v) {
			$data[] = $v['id'];
		}
		return $data;
	}

	public function get_post_by_tag($tag='')
	{
		$query = $this->db->select('id, title, sub_title, pic, sub_pic, updated_at, summary')
			->where([
				'state' => 1
			])->like('tags', $tag)
			->get(self::TABLE_NAME);
		return $query->result_array();
	}

}