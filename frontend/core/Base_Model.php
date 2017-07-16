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
        if ($res) {
            return $res->row_array();
        }
        return false;
    }

    /**
     * @param $data
     * @return mixed
     * @desc 添加记录
     */
    public function add($data)
    {
        $data = $this->append_data($data);
        $rtn = $this->db->insert(static::TABLE_NAME, $data);
        return $rtn;
    }

    /**
     * @desc 获取多条记录
     */
    public function get_list($column = '*', $where = [], $limit = 10, $offset = 0, $order_column = 'id', $order_type = 'desc')
    {
        return $this->db->order_by($order_column, $order_type)
            ->limit($limit, $offset)
            ->select($column)->get_where(
            static::TABLE_NAME,
            $where
        )->result_array();
    }
}
