<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NoOneKnows extends Base_Controller {

    public function send_msg()
    {
        $wechat = new WeChat();

        $to_users = [
            'o7PSLv0Wl3q2_K6FuBIbpN34aNwE',
        ];

        $lesson_id = 16;
        $this->load->model('Order_model', 'order');
        $rows = $this->order->get_openid_by_order($lesson_id);
        foreach ($rows as $v) {
            $to_users[] = $v['openid'];
        }

//        print_r($to_users);

        $text = '欢迎参加6月3日（明日）颊针交流会，时间13:30-16:30 地点：上海浦东新区博兴路95号沪东医院3号楼4楼';
        $wechat->sendMsg($to_users, $text);
    }
}





