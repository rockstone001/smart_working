<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Base_Controller {
    public $desc = '用户管理';

    public $js = [
    ];

    public $css = [
        'index.css',  'bootstrap-table.min.css'
    ];

    public $left_side = 'left_user.php';

    public function index()
	{
        $this->js = array_merge($this->js, ['bootstrap-table.min.js', 'bootstrap-table-zh-CN.min.js', 'user_list.js?v=1.2']);
        $this->view('user/index');
	}

    public function new_user()
    {
        $this->js = array_merge($this->js, ['user.js?v=1.2']);
        $this->css = array_merge($this->css, ['uniform.default.css', 'wangEditor.min.css']);

        if(!isset($_POST['username'])) {
            $this->load->model('Role_model', 'role');
            $this->load->model('Company_model', 'company');
            $this->load->model('City_model', 'city');
            $this->load->model('Store_model', 'store');
            $this->store->get_company_city_store();
            $this->view('user/new_user', [
                'roles' => $this->role->get_all_role(),
                'companies' => $this->company->get_all_company(),
                'cities' => $this->city->get_all_city(),
                'stores' => $this->store->get_all_store(),
                'departments' => config_item('departments'),
                'positions' => config_item('positions'),
                'company_city_store' => $this->store->get_company_city_store(),
            ]);
        } else {
            $data = $this->post_params([
                'username', 'password', 'role_id', 'mobile', 'company_id', 'department', 'position', 'employee_id',
                'email', 'address'
            ]);
//            print_r($data); die();
            $this->load->model('User_model', 'user');
            $user = $this->user->get_one([
                'username' => $data['username'],
                'employee_id' => $data['employee_id'],
                'state' => 1
            ]);
            if (isset($user['id'])) {
                $this->_error(Message::USER_NAME_DUPLICATED['code'], Message::USER_NAME_DUPLICATED['msg']);
            }

            $data['password'] = $this->user->generate_password($data['password']);
            if ($this->user->add($data)) {
                $this->_success([
                    'link' => config_item('index_url') . '/user/index'
                ]);
            } else {
                $this->_error(Message::ADD_RECORD_FAILED['code'], Message::ADD_RECORD_FAILED['msg']);
            }
        }
    }

    public function get_list()
    {
        $params = $this->get_params([
            'limit', 'offset', 'user_name'
        ]);

        $this->load->model('User_model', 'user');
        $data = $this->user->get_user_list($params['limit'], $params['offset'], $params['user_name']);

        $this->_json($data);
    }


    public function remove()
    {
        $params = $this->post_params([
            'post_ids'
        ]);
        $this->load->model('User_model', 'user');
        if ($this->user->remove_batch($params['post_ids'])) {
            $this->_success();
        } else {
            $this->_error(Message::REMOVE_RECORD_FAILED['code'], Message::REMOVE_RECORD_FAILED['msg']);
        }
    }

    public function edit($id)
    {
        $this->js = array_merge($this->js, ['user.js?v=1.1']);
        $this->css = array_merge($this->css, ['uniform.default.css', 'wangEditor.min.css']);
        $this->load->model('User_model', 'user');
        if(!isset($_POST['username'])) {
            $this->load->model('Role_model', 'role');
            $this->load->model('Company_model', 'company');
            $this->load->model('City_model', 'city');
            $this->load->model('Store_model', 'store');
            $this->view('user/new_user', array_merge($this->user->get_user_by_id($id), [
                'roles' => $this->role->get_all_role(),
                'companies' => $this->company->get_all_company(),
                'cities' => $this->city->get_all_city(),
                'stores' => $this->store->get_all_store(),
                'departments' => config_item('departments'),
                'positions' => config_item('positions'),
                'company_city_store' => $this->store->get_company_city_store(),
            ]));
        } else {
            $data = $this->post_params([
                'username', 'password', 'role_id', 'mobile', 'company_id', 'department', 'position', 'employee_id',
                'email', 'address'
            ]);

            $user = $this->user->get_one([
                'username' => $data['username'],
                'id !=' => $id,
                'employee_id' => $data['employee_id'],
                'state' => 1
            ]);

            if (isset($user['id'])) {
                $this->_error(Message::USER_NAME_DUPLICATED['code'], Message::USER_NAME_DUPLICATED['msg']);
            }

            if (trim($data['password']) == '') {
                unset($data['password']);
            } else {
                $data['password'] = $this->user->generate_password($data['password']);
            }

            if ($this->user->update($data, [
                'id' => $id
            ])) {
                $this->_success([
                    'link' => config_item('index_url') . '/user/index'
                ]);
            } else {
                $this->_error(Message::UPDATE_RECORD_ERROR['code'], Message::UPDATE_RECORD_ERROR['msg']);
            }
        }
    }


    public function get_users()
    {
        $key = !empty($_GET['key']) ? $_GET['key'] : '';
        $users = [];
        if (!empty($key)) {
            $this->load->model('User_model', 'user');
            $users = $this->user->get_all_users($key);
        }
        echo json_encode($users);
    }

}
