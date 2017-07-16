<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Base_Controller {
    public $desc = '主页';

    public $js = [
        'home.js'
    ];

    public $css = [
        'index.css'
    ];

	public function index()
	{
        $this->title = "活动报名";
		$this->view('home/index', $this->get_home_data());
	}

    public function mine()
    {
        $this->title = "我的活动";
//        $this->session->openid = 'o7PSLv0Wl3q2_K6FuBIbpN34aNwE';
        $this->view('home/mine', [
            'user' => $this->get_user()
        ]);
    }


    private function get_home_data()
    {
        $data = [];
        return $data;
    }

    public function wechat()
    {
        $wechat = new WeChat();
        $wechat->valid();
    }

    public function create_menu()
    {
        $wechat = new WeChat();
        $params = [
            'button' => [
                array(
                    'name' => '微课直播',
                    'key' => 'button-1-school',
                    'type' => 'click',
                    'sub_button' => array(
                        array(
                            'name' => '柳成刚讲伤寒',
                            'type' => 'view',
                            'url' => 'http://mp.weixin.qq.com/s/CP89KHcLdXIt1OWg_1SVnw'
                        )
                    )
                ),
                array(
                    'name' => '讲师团',
                    'key' => 'button-1-class',
                    'type' => 'click',
                    'sub_button' => array(
                        array(
                            'name' => '道生讲师团',
                            'type' => 'view',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MzIxMzUwMDk5OQ==&mid=2247483693&idx=2&sn=663616e13e122c610c173f348102616c&scene=18#wechat_redirect'
                        )
                    )
                ),
                [
                    'name' => '活动报名',
                    'url' => 'http://www.idaosh.com/php/longsha/lesson/index.php/home/',
                    'type' => 'view'
                ]
            ]
        ];

        var_dump($wechat->deleteMenu());
        echo '====';
        var_dump($wechat->createMenu(json_encode($params, JSON_UNESCAPED_UNICODE)));
    }

    /**
     * @desc 获取课程列表
     */
    public function get_list()
    {
        $where = [
            'end_time >' => date('Y-m-d', date('U') - 10 * 86400),
            'state' => '1',
        ];
        if (isset($_GET['city']) && $this->check_city_in_options($_GET['city'])) {
            $where['city'] = $_GET['city'];
        }
        if (isset($_GET['type']) && in_array($_GET['type'], config_item('lesson_type'))) {
            $where['type'] = $_GET['type'];
        }
        $time_type = config_item('time_type');
        if (isset($_GET['start_time']) && isset($time_type[$_GET['start_time']])) {
            $where['end_time <'] = date('Y-m-d H:i:s', $time_type[$_GET['start_time']]);
        }
        $this->load->model('Lesson_model', 'lesson');
        $this->_success($this->lesson->get_lessons('id, image, title, start_time', $where));
    }

    private function check_city_in_options($city)
    {
        $rtn = false;
        foreach (config_item('cities') as $v) {
            if ($v['name'] == $city) {
                $rtn = true;
                break;
            }
        }
        return $rtn;
    }

    /**
     * @param $id
     * @desc 获取课程详情
     */
    public function detail()
    {
        $this->css = array_merge($this->css, [
            'jquery-weui.min.css'
        ]);
        $this->js = array_merge($this->js, [
            'jquery-weui.min.js?v=1.0', 'fastclick.js', 'city-picker.min.js'
        ]);
        $id = $_GET['id'];
        $index = isset($_GET['index']) ? $_GET['index'] : 0;
        if (is_numeric($id) && is_numeric($index)) {
            $this->load->model('Lesson_model', 'lesson');
            $this->load->model('Teacher_model', 'teacher');
            $this->load->model('User_info_model', 'user_info');
            $user = $this->get_user();
            $userinfo = $this->user_info->get_one([
                'uid' => isset($user['id']) ? $user['id'] : 0
            ]);
            $has_userinfo = isset($userinfo['id']) ? 1 : 0;
//            $this->setLayout('blank');
            $lesson = $this->lesson->get_one([
                'id' => $id,
            ]);

            $this->view('home/detail', [
                'lesson' => $lesson,
                'teacher' => $this->teacher->get_teacher_by_lesson_id($id),
                'has_userinfo' => $has_userinfo,
                'id' => $id,
                'is_admin' => $user['is_admin'],
                'index' => $index
            ]);
      } else {
        $this->_error(400002, '参数错误');
        }
    }

    public function join()
    {
        $id = $_GET['id'];
        $index = isset($_GET['index']) ? $_GET['index'] : 0;
        if (is_numeric($id) && is_numeric($index)) {
            $this->load->model('Lesson_model', 'lesson');
            $lesson = $this->lesson->get_one([
                'id' => $id,
                'state' => 1
            ]);
            if (!isset($lesson['id'])) {
                $this->_error(400002, '参数错误');
            }

            $addresses = json_decode($lesson['addresses'], true);
            if (!isset($addresses[$index])) {
                $this->_error(400002, '参数错误');
            }
//            $this->setLayout('blank');
            $this->view('home/join', [
                'lesson' => $lesson,
                'index' => $index
            ]);
        } else {
            $this->_error(400002, '参数错误');
        }
    }

    /**
     * @desc 报名页面获取老师情况
     */
    public function get_teacher($lesson_id)
    {
        $this->load->model('Teacher_model', 'teacher');
        $rtn = $this->teacher->get_teacher_by_lesson_id($lesson_id);
        if (!$rtn) {
            $rtn = [];
        }
        $this->_success($rtn);
    }

    /**
     * @desc 提交订单
     * 订单重复提交 可以使用前端传递token的方式来防止
     * 在这里 我使用前端干掉click事件 后端3s内禁止 对同一商品下订单来防止重复订单
     */
    public function order()
    {
        $post = $this->get_params([
            'id'
        ]);
        $this->check_params($post, [
            'number'
        ]);

        $this->load->model('User_info_model', 'user_info');
        $user = $this->get_user();
        $userinfo = $this->user_info->get_one([
            'uid' => isset($user['id']) ? $user['id'] : 0
        ]);
        //, 'name', 'mobile', 'msg'
        $post['name'] = isset($userinfo['username']) ? $userinfo['username'] : '';
        $post['mobile'] = isset($userinfo['mobile']) ? $userinfo['mobile'] : '';
        $post['msg'] = '';

        if (!isset($user['id'])) {
            $this->_error('400003', '用户信息错误');
        }
        $this->load->model('Order_model', 'order');
        $order = $this->order->get_one([
            'uid' => $user['id'],
            'lesson_id' => $post['id'],
            'created_at >' => date('Y-m-d H:i:s', date('U') - 3)
        ]);
        if (isset($order['id'])) {
            $this->_error('400003', '重复订单');
        }

        $this->load->model('Lesson_model', 'lesson');
        $lesson = $this->lesson->get_one([
            'id' => $post['id']
        ]);
        if (!isset($lesson['id'])) {
            $this->_error('400003', '课程记录错误');
        }
        if (isset($lesson['limit_num']) && $lesson['limit_num'] <= 0) {
            $this->_error('400003', '报名人数已满');
        }
        //获取用户的时间 地点 城市的选择 2017-06-12
        $index = isset($_GET['index']) ? $_GET['index'] : 0;
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


        $order = $this->order->get_one([
            'uid' => $user['id'],
            'lesson_id' => $post['id'],
            'state' => 1,
            'city' => $city,
            'address' => $address,
            'start_time' => $start_time
        ]);

        if (isset($order['id'])) {
            $this->_error('400003', '重复报名');
        }


        $order_id = $user['id'] . '-' . $post['id'] . '-' . date('YmdHis');
        $data = [
            'uid' => $user['id'],
            'name' => $post['name'],
            'mobile' => $post['mobile'],
            'msg' => $post['msg'],
            'lesson_id' => $post['id'],
            'amount' => $lesson['charge'] * 100,
            'order_id' => $order_id,
            'city' => $city,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'address' => $address
        ];
        $this->load->model('Order_model', 'order');
        if (!$this->order->add_order($data)) {
            $this->_error('400003', '添加订单失败');
        }

        if (floatval($lesson['charge']) > 0) {
            $wepay = new WeixinPay();
            //统一下单
            $order = $wepay->unifiedorder($user['openid'], $data['order_id'], $data['amount']);
            if (!isset($order['prepay_id'])) {
                $this->_error('400003', '统一下单失败');
            }
            $jspay = new JsApiPay();
            $jsparams = $jspay->GetJsApiParameters($order);
            $sms = new SMS();

            $lesson['start_time'] = !empty($data['start_time']) ? $data['start_time'] : $lesson['start_time'];
            $lesson['address'] = !empty($data['address']) ? $data['address'] : $lesson['address'];

            $this->_json([
                'code' => '0',
                'jsparams' => json_decode($jsparams, true),
                'msg' => '',
                'tips' => $sms->get_msg($lesson['title'], date('Y-m-d H:i', strtotime($lesson['start_time'])), $lesson['address'])
            ]);
        } else {
            //免费逻辑
            $this->free_order($order_id);
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

            $this->_success($sms->get_msg($lesson['title'], date('Y-m-d H:i', strtotime($lesson['start_time'])), $lesson['address']));
        }
        $this->_error('400003', '更新订单失败');
    }

    public function profile()
    {
        $this->load->model('User_info_model', 'user_info');
        $this->title = "个人信息";
        $user = $this->get_user();
        $this->view('home/profile', [
            'user' => $user,
            'userinfo' => $this->user_info->get_one([
                'uid' => isset($user['id']) ? $user['id'] : 0
            ])
        ]);
    }

    public function profile_edit()
    {
        $lesson_id = isset($_GET['lesson_id']) ? $_GET['lesson_id'] : 0;
        $this->load->model('User_info_model', 'user_info');
        $this->title = "编辑个人信息";
        $this->css = array_merge($this->css, [
            'jquery-weui.min.css'
        ]);
        $this->js = array_merge($this->js, [
            'jquery-weui.min.js?v=1.0', 'fastclick.js', 'city-picker.min.js'
        ]);
        $user = $this->get_user();
        $this->view('home/profile_edit', [
            'user' => $user,
            'userinfo' => $this->user_info->get_one([
                'uid' => isset($user['id']) ? $user['id'] : 0
            ]),
            'lesson_id' => $lesson_id
        ]);
    }

    public function profile_save()
    {
        $post = $this->post_params([
            'username', 'gender', 'birthday', 'location', 'mobile', 'wechat', 'email', 'education', 'academy', 'major', 'type', 'years', 'lessons', 'msg', 'IDCard'
        ]);
        $post['birthday'] = trim($post['birthday']);
        $user = $this->get_user();

        if (empty($user['id'])) {
            $this->_error('400003', '用户不存在');
        }
        $post['uid'] = $user['id'];
        $this->load->model('User_info_model', 'user_info');
        $userinfo = $this->user_info->get_one([
            'uid' => $post['uid'],
        ]);
        if (isset($userinfo['id'])) {
            $rtn = $this->user_info->update($post, [
                'id' => $userinfo['id']
            ]);
        } else {
            $rtn = $this->user_info->add($post);
        }
        if (!$rtn) {
            $this->_error('400003', '保存失败');
        }
        $this->_success();
    }

    public function survey()
    {
        $this->title = "我的活动";
        $this->view('home/mine', [
            'user' => $this->get_user()
        ]);

    }

    public function qrcode()
    {
        $lesson_id = isset($_GET['lesson_id']) ? $_GET['lesson_id'] : 0;
        $this->load->model('Lesson_model', 'lesson');
        $lesson = $this->lesson->get_one([
            'id' => $lesson_id
        ]);
        $this->title = '签到';
        $this->js = [];

        $this->view('home/qrcode', [
            'lesson_title' => $lesson['title'],
            'lesson_id' => $lesson_id
        ]);
    }

    public function get_qrcode()
    {
        $lesson_id = isset($_GET['lesson_id']) ? $_GET['lesson_id'] : 0;
        $this->load->library('qr_code_lib');
        $this->qr_code_lib->jpg(config_item('index_url') . '/home/sign?lesson_id=' . $lesson_id);
    }

    public function sign()
    {
        $this->js = [];
        $lesson_id = isset($_GET['lesson_id']) ? $_GET['lesson_id'] : 0;
//        echo $lesson_id;
        $user = $this->get_user();
        $this->load->model('Order_model', 'order');

        $msg = '<a href="javascript:;" class="weui-btn weui-btn_primary" data-link="' . config_item('index_url') . '/home/index">签到成功, 点击返回首页</a>';
        try {
            $order = $this->order->get_one([
                'uid' => $user['id'],
                'lesson_id' => $lesson_id,
                'state' => 1
            ]);

            if (!isset($order['id'])) {
                throw new Exception('<a href="javascript:;" class="weui-btn weui-btn_primary" data-link="' . config_item('index_url') . '/home/join?id=' . $lesson_id . '">您还没有报名, 点击去报名</a>');
            }

            if ($order['is_signed']) {
                throw new Exception('<a href="javascript:;" class="weui-btn weui-btn_primary" data-link="' . config_item('index_url') . '/home/index">您已经签到, 点击返回首页</a>');
            }
            if (!$this->order->update([
                'is_signed' => 1
            ], [
                'id' => $order['id']
            ])) {
                throw new Exception('<a href="javascript:;" class="weui-btn weui-btn_primary" data-link="' . config_item('index_url') . '/home/sign?lesson_id=' . $lesson_id . '">签到失败, 点击再次尝试签到</a>');
            }
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }

        $this->load->model('Lesson_model', 'lesson');
        $lesson = $this->lesson->get_one([
            'id' => $lesson_id
        ]);

        $this->view('home/sign', [
            'msg' => $msg,
            'lesson_title' => $lesson['title'],
        ]);
    }

    public function sign_stat()
    {
        $this->js = [];
        $lesson_id = isset($_GET['lesson_id']) ? $_GET['lesson_id'] : 0;
        $user = $this->get_user();
        if (empty($user['is_admin'])) {
            echo '没有权限查看';
            exit();
        }

        $this->load->model('Lesson_model', 'lesson');
        $this->load->model('Order_model', 'order');
        $this->title = '签到统计';
        $lesson = $this->lesson->get_one([
            'id' => $lesson_id
        ]);

        $this->view('home/sign_stat', [
            'orders' => $this->order->get_order_list_for_stat([
                'orders.is_signed' => 1,
                'orders.lesson_id' => $lesson_id,
                'orders.state' => 1
            ], 1000),
            'lesson' => $lesson
        ]);
    }
}





