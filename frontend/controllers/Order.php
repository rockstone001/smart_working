<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends Base_Controller {
    public $desc = '用户中心';

    public $js = [
    ];

    public $css = [
    ];

    public function mine()
    {
        $this->load->model('Order_model', 'order');
        $user = $this->get_user();
        $this->_success($this->order->get_order_list($user['id']));
    }

    public function detail($id)
    {
        if (is_numeric($id)) {
            $this->load->model('Order_model', 'order');
            $this->setLayout('blank');
            $this->view('home/order_detail', $this->order->get_detail($id));
        } else {
            $this->_error(400002, '参数错误');
        }

    }

    /**
     * @desc 订单继续支付
     */
    public function reorder()
    {
        $post = $this->get_params([
            'id'
        ]);
        $this->check_params($post, [
            'number'
        ]);
        $user = $this->get_user();

        if (!isset($user['id'])) {
            $this->_error('400003', '用户信息错误');
        }
        $this->load->model('Order_model', 'order');
        $order = $this->order->get_one([
            'id' => $post['id']
        ]);
        if (!isset($order['order_id'])) {
            $this->_error('400003', '没有该订单记录');
        }

        $this->load->model('Lesson_model', 'lesson');
        $lesson = $this->lesson->get_one([
            'id' => $order['lesson_id']
        ]);
        if (!isset($lesson['id'])) {
            $this->_error('400003', '课程记录错误');
        }

//        $wepay = new WeixinPay();
//        //统一下单
//        $order = $wepay->unifiedorder($user['openid'], $order['order_id'], $order['amount']);
//        if (!isset($order['prepay_id'])) {
//            $this->_error('400003', '统一下单失败');
//        }
//        $jspay = new JsApiPay();
//        $jsparams = $jspay->GetJsApiParameters($order);
//        $this->_echo($jsparams);


        if (floatval($lesson['charge']) > 0) {
            $wepay = new WeixinPay();
            //统一下单
            $order = $wepay->unifiedorder($user['openid'], $order['order_id'], $order['amount']);
            if (!isset($order['prepay_id'])) {
                $this->_error('400003', '统一下单失败');
            }
            $jspay = new JsApiPay();
            $jsparams = $jspay->GetJsApiParameters($order);
            $sms = new SMS();
            $this->_json([
                'code' => '0',
                'jsparams' => json_decode($jsparams, true),
                'msg' => '',
                'tips' => $sms->get_msg($lesson['title'], date('Y-m-d H:i', strtotime($lesson['start_time'])), $lesson['address'])
            ]);
        } else {
            //免费逻辑
            $this->free_order($order['order_id']);
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
            $sms->send($order['mobile'], $lesson['title'], date('Y-m-d H:i', strtotime($lesson['start_time'])), $lesson['address']);

            $this->_success($sms->get_msg($lesson['title'], date('Y-m-d H:i', strtotime($lesson['start_time'])), $lesson['address']));
        }
        $this->_error('400003', '更新订单失败');
    }
    /**
     * 微信支付的后台通知
     */
    public function notify()
    {
        $weixinpay = new WeixinPay();
        $weixinpay->notify($this);
    }

    public function sms()
    {
        exit();
        $this->load->model('Order_model', 'order');
        $trade_no = '1-2-20161224132236';
        $sms = new SMS();
        $order = $this->order->get_one([
            'order_id' => $trade_no
        ]);
        $this->load->model('Lesson_model', 'lesson');
        $lesson = $this->lesson->get_one([
            'id' => $order['lesson_id']
        ]);
        $sms->send($order['mobile'], $lesson['title'], date('Y-m-d H:i', strtotime($lesson['start_time'])), $lesson['address']);
    }

    public function check_order_expire()
    {
        $this->load->model('Order_model', 'order');
        $orders = $this->order->get_list('id, lesson_id', $where = [
            'state' => 0,
            'created_at <' => date('Y-m-d H:i:s', date('U') - 30*60)
        ], 1000, 0);
        foreach ($orders as $order) {
            $this->order->feidan($order['id'], $order['lesson_id']);
        }
    }
}

