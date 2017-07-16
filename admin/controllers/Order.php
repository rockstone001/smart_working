<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends Base_Controller {
    public $desc = '订单管理';

    public $js = [
    ];

    public $css = [
        'index.css',  'bootstrap-table.min.css'
    ];

	public function index()
	{
        $this->js = array_merge($this->js, ['bootstrap-table.min.js', 'bootstrap-table-zh-CN.min.js', 'order_list.js?v=1.1']);
        $this->view('order/index');
	}

    public function get_list()
    {
        $params = $this->get_params([
            'limit',
            'offset',
            'nickname',
            'state'
        ]);
        $this->load->model('Order_model', 'order');
        $where = [];
        switch ($params['state']){
            case '0':
                $where = [
                    'orders.state' => 0
                ];
                break;
            case '1':
                $where = [
                    'orders.state' => 1
                ];
                break;
            case '2':
                $where = [
                    'orders.state' => 2
                ];
                break;
        }
        $data = $this->order->get_order_list($where, $params['limit'], $params['offset'], $params['nickname']);

        $this->_json($this->format_data($data));
    }

    private function format_data($data)
    {
        foreach ($data['rows'] as &$v) {
            $v['amount'] = $v['amount'] * 0.01;
            $v['state'] = $v['state'] == 1 ? '<span style="color:green;">已支付</span>' : ($v['state'] == 0 ? '<span style="color:red;">未支付</span>' : '<span style="color:gray;">已过期</span>');
            $v['time_end'] = date('Y-m-d H:i:s', strtotime($v['time_end']));
        }
        return $data;
    }

    public function detail($id)
    {
        $this->js = array_merge($this->js, ['wangEditor.min.js', 'post.js']);
        $this->css = array_merge($this->css, ['uniform.default.css', 'wangEditor.min.css']);
        if(!isset($_POST['title'])) {
            $this->view('post/new_post', array_merge($this->get_post($id), [
                'category' => $this->get_all_category(),
                'tag' => config_item('tags')
            ]));
        } else {
            $data = $this->get_post_params();
            $this->load->model('Post_model', 'post');
            if ($this->post->update($data, [
                'id' => $id
            ])) {
                $this->redirect(config_item('index_url') . '/post/index');
            } else {
                $this->_error(Message::UPDATE_RECORD_ERROR['code'], Message::UPDATE_RECORD_ERROR['msg']);
            }
        }
    }

    public function new_order()
    {
        $lesson_id = isset($_GET['lesson_id']) ? $_GET['lesson_id'] : 0;
//        $this->js = array_merge($this->js, ['bootstrap-select.js', 'i18n/defaults-zh_CN.min.js', 'order.js']);
//        $this->css = array_merge($this->css, ['bootstrap-select.css']);

        $this->load->model('Lesson_model', 'lesson');
        if(!$lesson_id) {
            $this->view('order/new_order', [
                'lessons' => $this->lesson->get_available_lessons(),
            ]);
        } else {
//            var_dump($_POST); die();
            if (empty($_POST['uid'])) {
//            $this->load->model('User_model', 'user');
                $this->view('order/new_order', [
                    'lesson' => $this->lesson->get_one([
                        'id' => $lesson_id
                    ]),
                    'lesson_id' => $lesson_id,
    //                'users' => $this->user->get_all_users(),
                ]);
            } else {
                $post = [];
                $uid = $_POST['uid'];
                $index = isset($_POST['index']) ? $_POST['index'] : 0;
                $post['charge'] = isset($_POST['price']) ? $_POST['price'] : 0;

                $this->load->model('User_info_model', 'user_info');
                $userinfo = $this->user_info->get_one([
                    'uid' => $uid,
                ]);
                if (!isset($userinfo['username'])) {
                    die('用户详细信息未录入');
                }

                $post['name'] = isset($userinfo['username']) ? $userinfo['username'] : '';
                $post['mobile'] = isset($userinfo['mobile']) ? $userinfo['mobile'] : '';
                $post['msg'] = '后台手工录入订单';

                $lesson = $this->lesson->get_one([
                    'id' => $lesson_id
                ]);
                if (isset($lesson['limit_num']) && $lesson['limit_num'] <= 0) {
//                    die('报名人数已满');
                }

                $start_times = json_decode($lesson['start_times'], true);
                $end_times = json_decode($lesson['end_times'], true);
                $cities = explode(',', $lesson['cities']);
                $start_time = '';
                $end_time = '';
                $city = '';
                if (isset($start_times[$index])) $start_time = $start_times[$index];
                if (isset($end_times[$index])) $end_time = $end_times[$index];
                $addresses = json_decode($lesson['addresses'], true);
                $address = '';
                if (isset($addresses[$index])) $address = $addresses[$index];
                if (isset($cities[$index])) $city = $cities[$index];

                $this->load->model('Order_model', 'order');
                $order = $this->order->get_one([
                    'uid' => $uid,
                    'lesson_id' => $lesson_id,
                    'state' => 1,
                    'city' => $city,
                    'address' => $address,
                    'start_time' => $start_time
                ]);

                if (isset($order['id'])) {
                    die('重复报名');
                }

                $order_id = $uid . '-' . $lesson_id . '-' . date('YmdHis');
                $data = [
                    'uid' => $uid,
                    'name' => $post['name'],
                    'mobile' => $post['mobile'],
                    'msg' => $post['msg'],
                    'lesson_id' => $lesson_id,
                    'amount' => $post['charge'] * 100,
                    'order_id' => $order_id,
                    'city' => $city,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'address' => $address
                ];
                $this->load->model('Order_model', 'order');
                if (!$this->order->add_order($data)) {
                    die('添加订单失败');
                }
                $this->free_order($order_id);
//                redirect(config_item('index_url') . '/order/index');
                $this->index();
            }
        }
    }

    private function free_order($order_id)
    {
        $this->load->model('Order_model', 'order');
        if ($this->order->update_order([
            'time_end' => date('YmdHis'),
            'state' => 1,
        ], [
            'order_id' => $order_id
        ])) {
            //更新成功
            //发送短信
            $sms = new SMS();
            $order = $this->order->get_one([
                'order_id' => $order_id
            ]);
            $this->load->model('Lesson_model', 'lesson');
            $lesson = $this->lesson->get_one([
                'id' => $order['lesson_id']
            ]);
            $lesson['start_time'] = !empty($order['start_time']) ? $order['start_time'] : $lesson['start_time'];
            $lesson['address'] = !empty($order['address']) ? $order['address'] : $lesson['address'];
            $sms->send($order['mobile'], $lesson['title'], date('Y-m-d H:i', strtotime($lesson['start_time'])), $lesson['address']);
            return true;
//            $this->_success($sms->get_msg($lesson['title'], date('Y-m-d H:i', strtotime($lesson['start_time'])), $lesson['address']));
        }
        return false;
    }

}
