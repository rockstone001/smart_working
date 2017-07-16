<?php
/**
 * 扩展CI_Controller类, 目的是在处理请求逻辑之前统一为每个请求做处理
 * @author zhuang
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Base_Model extends CI_Model{
    const TABLE_NAME = '';

    /**
     * @param $data
     * @return mixed
     * @desc 统一为新纪录添加公用数据
     */
	protected function append_data($data)
    {
//        if (!isset($data['created_by'])) {
//            $data['created_by'] = Message::DEFAULT_CREATED_BY;
//        }
//        if (!isset($data['updated_by'])) {
//            $data['updated_by'] = Message::DEFAULT_UPDATED_BY;
//        }
        return $data;
    }

    /**
     * @param $data
     * @param $uid
     * @return mixed
     * @desc 更新用户信息
     */
    public function update($data, $where)
    {
        return $this->db->update(static::TABLE_NAME, $data, $where);
    }

    /**
     * @param $where
     * @return mixed
     * @desc 获取一条记录
     */
    public function get_one($where)
    {
        $res = $this->db->order_by('id', 'desc')->get_where(
            static::TABLE_NAME,
            $where,
            1
        );
        return $res->row_array();
    }

    /**
     * @param $data
     * @return mixed
     * @desc 添加记录
     */
    public function add($data)
    {
//        $data = $this->append_data($data);
        $rtn = $this->db->insert(static::TABLE_NAME, $data);
        return $rtn;
    }

    /**
     * @param array $post_ids
     * @desc 批量删除文章
     */
    public function remove_batch($post_ids = [])
    {
        $rtn = true;
        $this->db->trans_begin();
        try {
            foreach ($post_ids as $id) {
                if (!$this->db->update(static::TABLE_NAME, [
                    'state' => 0
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

    public function get_list($where = [], $limit = 10, $offset = 0, $like = '', $select = '*', $like_column='id')
    {
        $query = $this->db->order_by('id', 'desc')->select($select)
            ->where($where)->like($like_column, $like)->limit($limit)->offset($offset)
            ->get(static::TABLE_NAME);
        $rows = $query->result_array();
        empty($rows) && $rows = [];

        $query = $this->db->select("count(*) as total")
            ->where($where)->like($like_column, $like)
            ->get(static::TABLE_NAME);
        $total = current($query->row_array());

        return [
            'total' => $total,
            'rows' => $rows
        ];
    }

    /**
     * @desc 获取多条记录
     */
    public function get_list2($column = '*', $where = [], $limit = 10, $offset = 0, $order_column = 'id', $order_type = 'desc')
    {
        return $this->db->order_by($order_column, $order_type)
            ->limit($limit, $offset)
            ->select($column)->get_where(
                static::TABLE_NAME,
                $where
            )->result_array();
    }
}
