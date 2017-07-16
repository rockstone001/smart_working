<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order_Model extends Base_Model {
	
	const TABLE_NAME = 'orders';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	public function get_order_list($where = [], $limit = 10, $offset = 0, $nickname = '')
	{
//		$ci = get_instance();
//		$ci->load->model('Order_user_Model', 'order_user');
//		$users = $ci->order_user->get_users_by_nickname($nickname);

		$query =  $this->db->order_by('orders.id', 'desc')
			->limit($limit, $offset)
			->select('orders.id, lessons.title, users.nickname, orders.order_id, orders.created_at, orders.time_end, orders.name, orders.mobile, orders.msg, orders.amount, orders.state, orders.transaction_id, orders.bank_type')
			->from('orders')->join('users', 'orders.uid = users.id')
			->join('lessons', 'lessons.id = orders.lesson_id')
			->where($where)
			->like('users.nickname', $nickname)->get();

		$rows = $query->result_array();
		empty($rows) && $rows = [];

		$query =  $this->db->order_by('orders.id', 'desc')
			->select("count(*) as total")
			->from('orders')->join('users', 'orders.uid = users.id')
			->join('lessons', 'lessons.id = orders.lesson_id')
			->where($where)
			->like('users.nickname', $nickname)->get();

		$total = current($query->row_array());

		return [
			'total' => $total,
			'rows' => $rows
		];
	}

	public function update_order($data, $where)
	{
		$ci = get_instance();
		$ci->load->model('Lesson_Model', 'lesson');
		$result = true;
		$this->db->trans_begin();
		try {
			$order = $this->get_one($where);
			if (!isset($order['lesson_id'])) {
				throw new Exception('no order');
			}

			//更新订单
			$rtn = $this->update($data, $where);
			if (!$rtn) {
				throw new Exception('update order failed');
			}
			//更新报名人数
			$lesson = $ci->lesson->get_one([
				'id' => $order['lesson_id']
			]);

			if (!isset($lesson['join_num'])) {
				throw new Exception('no lesson');
			}

			$rtn2 = $ci->lesson->update([
				'join_num' => $lesson['join_num'] + 1
			], [
				'id' => $order['lesson_id']
			]);
			if (!$rtn2) {
				throw new Exception('update lesson failed');
			}

			$this->db->trans_commit();
		} catch (Exception $e) {
			$result = false;
			$this->db->trans_rollback();
		}
		return $result;
	}

	public function add_order($data)
	{
		$ci = get_instance();
		$ci->load->model('Lesson_Model', 'lesson');
		$result = true;
		$this->db->trans_begin();
		try {
			if(!$this->add($data)) {
				throw new Exception('add order failed');
			}
			if(!$ci->lesson->update_limit_num($data['lesson_id'])) {
				throw new Exception('update lesson failed');
			}
			$this->db->trans_commit();
		} catch (Exception $e) {
			$result = false;
			$this->db->trans_rollback();
		}
		return $result;
	}
}