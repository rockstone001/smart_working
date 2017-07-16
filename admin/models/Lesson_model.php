<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Lesson_Model extends Base_Model {
	
	const TABLE_NAME = 'lessons';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	public function check_remove($post_ids = [], $uid)
	{
//        print_r($post_ids);
        $query = $this->db->select("count(*) as total")->where_in('id', $post_ids)
            ->where(['created_uid' => $uid])
            ->get(static::TABLE_NAME);
        $rows = $query->row_array();
        return $rows['total'] == count($post_ids);

	}

    /**
     * @param array $post_ids
     * @desc 批量发布文章
     */
    public function publish_batch($post_ids = [])
    {
        $rtn = true;
        $this->db->trans_begin();
        try {
            foreach ($post_ids as $id) {
                if (!$this->db->update(static::TABLE_NAME, [
                    'state' => 1
                ], [
                    'id' => $id
                ])) {
                    throw new Exception('update post failed');
                }
            }
            $this->db->trans_commit();
        } catch (Exception $e) {
            $rtn = false;
            $this->db->trans_rollback();
        }
        return $rtn;
    }

    public function init_data()
    {
        $query = $this->db->select('*')
            ->get(static::TABLE_NAME);
        $rows = $query->result_array();

        foreach ($rows as &$row) {
            $row['start_times'] = json_encode([$row['start_time']]);
            $row['end_times'] = json_encode([$row['end_time']]);
            $row['cities'] = $row['city'];
            $row['addresses'] = json_encode([$row['address']]);
            $this->update($row, [
                'id' => $row['id']
            ]);
        }
    }

    public function get_available_lessons() {
        $sql = "select id, title from lessons where state = 1 and end_time > '" . date('Y-m-d H:i:s') . "' order by at_top desc, start_time asc";
//		echo $sql;
        $query = $this->db->query($sql);
        return $query->result_array();

    }

    public function update_limit_num($id)
    {
        $this->db->where([
            'id' => $id
        ]);
        $this->db->set('limit_num', 'limit_num - 1', FALSE);
        return $this->db->update(static::TABLE_NAME);
    }
}