<?php
/**
 * 扩展CI_Controller类, 目的是在处理请求逻辑之前统一为每个请求做处理
 * @author zhuang
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Base_Controller extends CI_Controller
{
    static $classFilter = array('home'); //免验证accessToken的类名
    static $actionFilter = [
        'login', 'logout'
    ]; //免验证accessToken的方法名
    protected $uid = 0;
    protected $username = '';

    public $desc = '网站描述';
    public $keywords = '关键字';
    public $title = 'Smart Working';

    public $left_side = 'left.php';

    protected $base_css_js = [
        'bootstrap-2.3.2/css/bootstrap.min.css',
        'bootstrap-2.3.2/css/bootstrap-responsive.min.css',
    ];

    protected $base_css_css = [
        'header.css', 'footer.css'
    ];
    protected $base_js = [
        'jquery.min.js',
        'bootstrap-2.3.2/js/bootstrap.min.js',
    ];

    public $css = [

    ];
    public $js = [

    ];

    public $action = '';

    public $actions_alloowed = [];

    protected $debug = true;

    public function __construct()
    {
//		header("Content-type: application/json");
        parent::__construct();
        $this->load->library('layout');
        $this->setLayout('main');
        $this->load->library('session');

        $this->verifySession();

        $this->action = $this->router->class . '/' . $this->router->method;

        /*验证通过之后 $_REQUEST['uid'] === $uid*/
//		$this->uid = $this->verifyAccessToken();
        //self::verifyUserAgent();
        //调用log方法记录统计API的调用情况
//		self::APIStat();;
//        echo $this->action;
        if (!in_array($this->action, [
            'home/login', 'home/logout'
        ])) {
            $this->get_actions_allowed();
            $this->check_permission();
        }

    }

    protected function view($view, $data = [], $return = false)
    {
        $data = array_merge($data, [
            'header_keywords' => $this->keywords,
            'header_desc' => $this->desc,
            'header_title' => $this->title,
            'js' => array_merge($this->get_full_link($this->base_js, config_item('js_url')), $this->get_full_link($this->js, config_item('js_url'))),
            'css' => array_merge($this->get_full_link($this->base_css_js, config_item('js_url')), $this->get_full_link($this->css, config_item('css_url')), $this->get_full_link($this->base_css_css, config_item('css_url'))),
            'uid' => $this->uid,
            'username' => $this->username,
            'left_side' => $this->left_side,
            'actions_alloowed' => $this->actions_alloowed
        ]);
        $this->layout->view($view, $data, $return);
    }

    protected function setLayout($layout)
    {
        $this->layout->setLayout($layout);
    }

    /**
     * 验证AccessToken是否有效及是否过期
     */
    public function verifyAccessToken()
    {
        $uid = '';
        $class = strtolower($this->router->class);
        $action = strtolower($this->router->method);
        if (!in_array($class, self::$classFilter) || !in_array($action, self::$actionFilter)) {
            /*需要验证accessToken的请求, 做验证处理*/
            $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';
            $this->getAccessTokenConfig($tokenConfig);
            $key = isset($tokenConfig['key']) ? $tokenConfig['key'] : '';
            $token = $this->parseAccessToken($token, $key); /*解析token*/
            if (!isset($token[0], $token[1], $token[2], $tokenConfig['sign_msg']) || !is_numeric($token[0]) || $tokenConfig['sign_msg'] != $token[2]) {
                /*token验证失败或者错误的token*/
                $this->_error(Message::INVALID_TOKEN['code'], Message::INVALID_TOKEN['msg']);
            } elseif (time() > $token[0]) {
                /*验证码过期*/
                $this->_error(Message::EXPIRED_TOKEN['code'], Message::EXPIRED_TOKEN['msg']);
            }
            $uid = $token[1];
        }
        //验证成功 不做处理, 返回uid 为兼容之前的代码
        return $uid;
    }


    protected function verifySession()
    {
        $uid = '';
        $class = strtolower($this->router->class);
        $action = strtolower($this->router->method);
        if (!in_array($class, self::$classFilter) || !in_array($action, self::$actionFilter)) {
            $username = $this->session->username;
            if (empty($username)) {
                $this->redirect(config_item('index_url') . '/home/login');
            } else {
                $this->uid = $this->session->uid;
                $this->username = $this->session->username;
            }
        }

    }

    /**
     * 检查请求来源并做相应阻截
     */
    public static function verifyUserAgent()
    {

    }

    /**
     * 生成accessToken
     * @param $id 标识用户的唯一id
     * @return array($accessToken, $timeout)
     */
    public function generateAccessToken($id)
    {
        if (!$this->getAccessTokenConfig($tokenConfig)) {
            /*获取本地token参数错误 返回空accessToken*/
            return '';
        }
        return [
            'token' => $this->encrypt(($tokenConfig['expire_time'] + time()) . ':' . $id . ':' . $tokenConfig['sign_msg'] . ':' . $tokenConfig['additional_msg'],
                $tokenConfig['key']),
            'expire_time' => date('Y-m-d H:i:s', date('U') + $tokenConfig['expire_time'])
        ];
    }

    /**
     * 解析accessToken
     * @param $token
     * @return Array(expireTime, id)
     */
    public function parseAccessToken($token, $key = '')
    {
        $token = $this->decrypt($token, $key);
        return explode(':', $token);
    }

    /**
     * 获取accessToken的配置参数
     * @param &$tokenConfig token参数配置(传递引用)
     * @return boolean
     */
    private function getAccessTokenConfig(&$tokenConfig)
    {
        if ($this->config->load('access_token', true)) {
            $tokenConfig = current($this->config->item('access_token'));
            return true;
        }
        return false;
    }

    /**
     * 加密字符串
     * @param $data 要加密的字符串
     * @param $key 加密秘钥, 如果不传参则从配置文件中取
     * @return String
     */
    private function encrypt($data, $key = '')
    {
        if ($key == '' && !$this->getAccessTokenConfig($tokenConfig)) {
            /*取本地配置出错返回空*/
            return '';
        }
        $key = ($key != '') ? $key : $tokenConfig['key'];
        $token = mcrypt_encrypt('tripledes', $key, $data, 'ecb');
        return $this->safe_b64encode($token);
    }

    /**
     * 解密字符串
     * @param $data 要解密的字符串
     * @param $key 解密秘钥, 如果不传参则从配置文件中取
     * @return String
     */
    private function decrypt($data, $key = '')
    {
        if (empty($data) || ($key == '' && !$this->getAccessTokenConfig($tokenConfig))) {
            /*$data为空或取本地配置出错时返回空*/
            return '';
        }
        $key = ($key != '') ? $key : $tokenConfig['key'];
        return mcrypt_decrypt('tripledes', $key, $this->safe_b64decode($data), 'ecb');
    }

    /**
     * 处理特殊字符
     * @param String $string
     * @return String
     */
    private function safe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }

    /**
     * 解析特殊字符
     * @param String $string
     * @return String
     */
    private function safe_b64decode($string)
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    /**
     * 获取字段映射
     * @param String $flag
     * @return String $column
     */
    public function getColumnMap($flag)
    {
        switch ($flag) {
            case 'qq':
                $column = 'QQID';
                break;
            case 'weixin':
                $column = 'WeiXinID';
                break;
            case 'weibo':
                $column = 'WeiBoID';
                break;
            case 'phonenum':
                $column = 'Phone';
                break;
            default:
                throw new exception(json_encode(array('result' => 'failed', 'reason' => "params error")));
        }
        return $column;
    }

    /**
     * 记录API的调用情况
     */
    private function APIStat()
    {
        $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;
        $requestURI = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null;
        $data = file_get_contents('php://input');

        $msg = $this->router->class . '::' . $this->router->method . " userAgent:$userAgent ip:$ip method:$method requestURI:$requestURI data:$data";
        $this->log->write_log('API_STAT', $msg);
    }

    /**
     * @desc 自定义json输出
     */
    protected function _json($data=[])
    {
        echo json_encode($data);
        exit();
    }

    /**
     * @param $msg
     * @desc 成功后的输出
     */
    protected function _success($msg = '')
    {
        echo json_encode([
            'code' => 0,
            'msg' => $msg
        ]);
        exit();
    }

    /**
     * @param $code
     * @param $msg
     * @desc 失败调用后的输出
     */
    protected function _error($code, $msg)
    {
        echo json_encode([
            'code' => $code,
            'msg' => $msg
        ]);
        exit();
    }

    /**
     * @param $params 参数
     * @param $types 参数类型
     * @desc 检查参数 如有不正确 立刻返回
     */
    protected function check_params($params, $types)
    {
        $index = 0;
        foreach ($params as $k => $v) {
            if (!call_user_func([
                'Tools',
                'is_' . $types[$index]
            ], $v)
            ) {
                $this->_error(Message::PARAM_ERROR['code'], sprintf(Message::PARAM_ERROR['msg'], $k));
            }
            $index++;
        }
    }

    protected function get_params($keys)
    {
        //获取参数
        $get = $this->input->get();
        $params = [];
        foreach ($keys as $k) {
            $params[$k] = isset($get[$k]) ? $get[$k] : '';
        }
        return $params;
    }

    protected function post_params($keys)
    {
        //获取参数
        $post = $get = $this->input->post();
        $params = [];
        foreach ($keys as $k) {
            $params[$k] = isset($post[$k]) ? $post[$k] : '';
        }
        return $params;
    }

    private function get_full_link($files = [], $link_prefix = '')
    {
        $data = [];
        foreach ($files as $v) {
            $data[] = $link_prefix . $v;
        }
        return $data;
    }


    protected function redirect($action)
    {
        header("Location: $action");
        exit();
    }

    protected function check_permission()
    {
        if ($this->debug) {
            return true;
        }
        if (!in_array($this->action, $this->actions_alloowed)) {
            $this->_error(Message::NO_PERMISSION['code'], Message::NO_PERMISSION['msg']);
        }
    }

    /**
     * @desc 获取用户所有可用权限的action
     */
    protected function get_actions_allowed()
    {
        if ($this->debug) {
            return $this->actions_alloowed = [
                'user/index', 'user/get_list', 'user/new_user', 'user/edit', 'user/remove', //用户管理
                'role/index', 'role/get_list', 'role/new_role', 'role/assign', 'role/edit', 'role/remove', //角色管理
                'privilege/index', 'privilege/', 'privilege/get_list', 'privilege/new_privilege', 'privilege/edit', 'privilege/remove', //权限管理
                'company/index', 'company/get_list', 'company/new_company', 'company/edit', 'company/remove', //公司管理
                'brand/index', //品牌管理
            ];
        }
        $this->load->model('User_model', 'user');
        $user = $this->user->get_one([
            'id' => $this->uid
        ]);
//        print_r($user);
        $this->load->model('Role_privilege_model', 'role_privilege');
        $this->actions_alloowed = $this->role_privilege->get_all_actions_by_role_id($user['role_id']);
//        print_r($this->actions_alloowed);
    }

    protected function has_permission($privilege)
    {
        if ($this->debug) {
            return true;
        }
        $this->load->model('User_model', 'user');
        $user = $this->user->get_one([
            'id' => $this->uid
        ]);
//        print_r($user);
        $this->load->model('Role_privilege_model', 'role_privilege');
        $privileges = $this->role_privilege->get_all_privileges_by_role_id($user['role_id']);
        return in_array($privilege, $privileges);
    }
}
