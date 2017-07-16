<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Base_Controller {
    public $desc = '用户中心';

    public $js = [
        'home.js'
    ];

    public $css = [
        'index.css'
    ];

    public function login()
    {
        $redirect_url = $_GET['redirect_url'];
        if (isset($_GET['code'])) {
            $wechat = new WeChat();
            $rtn = $wechat->get_auth_access_token($_GET['code']);
            if (isset($rtn['access_token'])) {
                //成功
                $this->session->access_token = $rtn['access_token'];
                $this->session->expires_in = date('U') + $rtn['expires_in'];
                $this->session->openid = $rtn['openid'];
                $this->session->refresh_token = $rtn['refresh_token'];

                $this->load->model('User_model', 'user');
                $user = $this->user->get_one([
                    'openid' => $rtn['openid']
                ]);
                if (isset($user['id'])) {
                    //老用户更新用户信息
                    $userinfo = $wechat->get_user_info($rtn['access_token'], $rtn['openid']);
                    $data = [
                        'nickname' => $userinfo['nickname'],
                        'sex' => $userinfo['sex'],
                        'province' => $userinfo['province'],
                        'city' => $userinfo['city'],
                        'country' => $userinfo['country'],
                    ];
                    if (!$this->is_url($user['headimgurl'])) {
                        $data['headimgurl'] = $userinfo['headimgurl'];
                    }
                    if (isset($userinfo['openid']) && $this->user->update($data, [
                        'openid' => $user['openid']
                    ])) {
                        if (empty($redirect_url))
                            redirect('home/index');
                        else
                            redirect(urldecode($redirect_url));
                    }
                } else {
                    //新用户 进入员工绑定页面
                    redirect('user/valid');
//                    $user = $wechat->get_user_info($rtn['access_token'], $rtn['openid']);
//                    if (isset($user['openid']) && $this->user->add([
//                        'openid' => $user['openid'],
//                        'nickname' => $user['nickname'],
//                        'sex' => $user['sex'],
//                        'province' => $user['province'],
//                        'city' => $user['city'],
//                        'country' => $user['country'],
//                        'headimgurl' => $user['headimgurl'],
//                    ])) {
//                        if (empty($redirect_url))
//                            redirect('home/index');
//                        else
//                            redirect(urldecode($redirect_url));
//                    }
                }
            }
        }
        $this->_error('400001', '登录失败');
    }

    /**
     * @desc 员工验证并且绑定用户
     */
    public function valid()
    {
        $post = $this->post_params([
            'username', 'employee_id'
        ]);
        if (empty($post['username'])) {
            $this->css = array_merge($this->css, [
                'valid.css'
            ]);
            $this->view('user/valid');
        } else {
            $this->load->model('User_model', 'user');
            $user = $this->user->get_one([
                'username' => $post['username'],
                'employee_id' => $post['employee_id'],
            ]);
            if (!isset($user['id'])) {
                $this->_error('400001', '员工不存在');
            }
            if (!empty($user['openid'])) {
                $this->_error('400001', '该员工已经绑定');
            }
            $wechat = new WeChat();
            $userinfo = $wechat->get_user_info($this->session->access_token, $this->session->openid);
            if (isset($userinfo['openid']) && $this->user->update([
                    'nickname' => $userinfo['nickname'],
                    'sex' => $userinfo['sex'],
                    'province' => $userinfo['province'],
                    'city' => $userinfo['city'],
                    'country' => $userinfo['country'],
                    'headimgurl' => $userinfo['headimgurl'],
                    'openid' => $this->session->openid,
                ], [
                    'id' => $user['id']
                ])) {
                $this->_success('验证员工成功');
            } else {
                $this->_error('400001', '绑定员工失败');
            }
        }
    }

    public function index()
    {
        $this->load->model('User_model', 'user');
        $this->css = array_merge($this->css, [
            'user.css'
        ]);
        $user = $this->user->get_user_by_openid($this->session->openid);
        if (!empty($user['headimgurl'])) {
            if(!$this->is_url($user['headimgurl'])) {
                $user['headimgurl'] = '';
            }
        }

        $this->load->model('User_info_model', 'user_info');
        $userinfo = $this->user_info->get_one([
            'uid' => $user['id']
        ]);

        $this->view('user/index', [
            'user' => $user,
            'userinfo' => $userinfo,
        ]);
    }

    private function is_url($url) {
        if (strpos($url, 'http') !== false) {
            return true;
        }
        return false;
    }

    /**
     * @desc 保存个人信息的修改 用户上传的图片 要从微信服务器下载, 考虑到用户的友好性 将图片下载放到后台做
     */
    public function modify()
    {
        $userinfo = $this->post_params([
             'ID_photo1', 'ID_photo2', 'salary_photo1', 'salary_photo2', 'IDCard', 'salary_card',
        ]);
        $user = $this->post_params([
            'headimgurl', 'username', 'mobile', 'address', 'email'
        ]);
        $wechat = new WeChat();
        if (!empty($user['headimgurl'])) {
            $data = $wechat->getMedia($user['headimgurl']);
            if (($file = $this->save_image($data)) !== false) {
                $user['headimgurl'] = config_item('img_url') . date('Ymd') . '/' . $file;
            }
        } else {
            unset($user['headimgurl']);
        }
        $this->load->model('User_model', 'user');
        $this->user->update($user, [
            'openid' => $this->session->openid
        ]);
        //保存 userinfo
        if (!empty($userinfo['ID_photo1'])) {
            $data = $wechat->getMedia($userinfo['ID_photo1']);
            if (($file = $this->save_image($data)) !== false) {
                $userinfo['ID_photo1'] = config_item('img_url') . date('Ymd') . '/' . $file;
            }
        } else {
            unset($userinfo['ID_photo1']);
        }

        if (!empty($userinfo['ID_photo2'])) {
            $data = $wechat->getMedia($userinfo['ID_photo2']);
            if (($file = $this->save_image($data)) !== false) {
                $userinfo['ID_photo2'] = config_item('img_url') . date('Ymd') . '/' . $file;
            }
        } else {
            unset($userinfo['ID_photo2']);
        }

        if (!empty($userinfo['salary_photo1'])) {
            $data = $wechat->getMedia($userinfo['salary_photo1']);
            if (($file = $this->save_image($data)) !== false) {
                $userinfo['salary_photo1'] = config_item('img_url') . date('Ymd') . '/' . $file;
            }
        } else {
            unset($userinfo['salary_photo1']);
        }

        if (!empty($userinfo['salary_photo2'])) {
            $data = $wechat->getMedia($userinfo['salary_photo2']);
            if (($file = $this->save_image($data)) !== false) {
                $userinfo['salary_photo2'] = config_item('img_url') . date('Ymd') . '/' . $file;
            }
        } else {
            unset($userinfo['salary_photo2']);
        }

        $user = $this->user->get_one([
            'openid' => $this->session->openid
        ]);
        $this->load->model('User_info_model', 'user_info');
        $userinfo2 = $this->user_info->get_one([
            'uid' => $user['id']
        ]);
        if (isset($userinfo2['id'])) {
            $this->user_info->update($userinfo, [
                'uid' => $user['id']
            ]);
        } else {
            $userinfo['uid'] = $user['id'];
            $this->user_info->add($userinfo);
        }
        $this->_success('修改成功');
    }

    private function save_image($data)
    {
        $dir = dirname(__FILE__) . '/../images/' . date('Ymd');
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        $file = date('U') . rand(0, 1000000) . '.jpg';
//        $file = 'test1.php';
        if (file_put_contents($dir . '/' . $file, $data)) {
            return $file;
        }
        return false;
    }
}
