<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Base_Controller {
    public $desc = '主页';

    public $js = [
        'jcityzen.js?v=1.0'
    ];

    public $css = [
        'index.css'
    ];

	public function index()
	{
		$this->view('home/index');
	}

    /**
     * 后台登录
     */
    public function login()
    {
        $this->setLayout('no_layout');
        $this->base_css_css = [];
        $this->css = ['login.css'];

        $params = $this->post_params([
            'user_login', 'user_pass'
        ]);


        if (empty($params['user_login']) && empty($params['user_pass'])) {
            $this->view('home/login');
        } else {
            //用户验证逻辑
            $this->load->model('User_model', 'user');
            $user = $this->user->get_one([
                'username' => $params['user_login'],
                'state' => 1
            ]);
            if (isset($user['password']) && $this->user->check_password($params['user_pass'], $user['password'])) {
                $this->session->set_userdata([
                    'username' => $user['username'],
                    'uid' => $user['id']
                ]);
//                die('hello');
                $this->redirect(config_item('index_url') . '/home/index');
            } else {
                $this->view('home/login', [
                    'error' => Message::PWD_WRONG_OR_USER['msg']
                ]);
            }
        }
    }

    public function logout()
    {
        $this->session->unset_userdata([
            'username', 'uid'
        ]);
        $this->redirect(config_item('index_url') . '/home/login');
    }
}
