<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends Base_Controller {
    public $desc = '角色管理';

    public $js = [
    ];

    public $css = [
        'index.css',  'bootstrap-table.min.css'
    ];

    public $left_side = 'left_user.php';

    public function index()
	{
        $this->js = array_merge($this->js, ['bootstrap-table.min.js', 'bootstrap-table-zh-CN.min.js', 'role_list.js?v=1.0']);
        $this->view('role/index');
	}

    public function new_role()
    {
        $this->js = array_merge($this->js, ['role.js']);

        if(!isset($_POST['name'])) {
            $this->view('role/new_role');
        } else {
            $data = $this->post_params([
                'name', 'desc'
            ]);
            $this->load->model('Role_model', 'role');
            $role = $this->role->get_one([
                'name' => $data['name'],
                'state' => 1
            ]);
            if (isset($role['id'])) {
                $this->_error(Message::ROLE_NAME_DUPLICATED['code'], Message::ROLE_NAME_DUPLICATED['msg']);
            }
            if ($this->role->add($data)) {
                $this->_success([
                    'link' => config_item('index_url') . '/role/index'
                ]);
            } else {
                $this->_error(Message::ADD_RECORD_FAILED['code'], Message::ADD_RECORD_FAILED['msg']);
            }
        }
    }

    public function get_list()
    {
        $params = $this->get_params([
            'limit', 'offset', 'name'
        ]);

        $this->load->model('Role_model', 'role');
        $data = $this->role->get_list([
            'state' => 1
        ], $params['limit'], $params['offset'], $params['name'], 'id, name, desc', 'name');

        $this->_json($data);
    }


    public function remove()
    {
        $params = $this->post_params([
            'post_ids'
        ]);
        $this->load->model('Role_model', 'role');
        if ($this->role->remove_batch($params['post_ids'])) {
            $this->_success();
        } else {
            $this->_error(Message::REMOVE_RECORD_FAILED['code'], Message::REMOVE_RECORD_FAILED['msg']);
        }
    }

    public function edit($id)
    {
        $this->js = array_merge($this->js, ['role.js']);
        $this->load->model('Role_model', 'role');
        if(!isset($_POST['name'])) {
            $this->view('role/new_role', $this->role->get_one([
                'id' => $id
            ]));
        } else {
            $data = $this->post_params([
                'name', 'desc'
            ]);

            $role = $this->role->get_one([
                'name' => $data['name'],
                'id !=' => $id,
                'state' => 1
            ]);

            if (isset($role['id'])) {
                $this->_error(Message::ROLE_NAME_DUPLICATED['code'], Message::ROLE_NAME_DUPLICATED['msg']);
            }

            if ($this->role->update($data, [
                'id' => $id
            ])) {
                $this->_success([
                    'link' => config_item('index_url') . '/role/index'
                ]);
            } else {
                $this->_error(Message::UPDATE_RECORD_ERROR['code'], Message::UPDATE_RECORD_ERROR['msg']);
            }
        }
    }

    public function assign($id)
    {
        $this->load->model('Role_model', 'role');
        $this->load->model('Privilege_model', 'privilege');
        $this->load->model('Role_privilege_model', 'role_privilege');
        $if_show_tips = false;
        if (isset($_POST['privileges'])) {
            if ($this->role_privilege->remove_all_privilege($id)) {
                foreach ($_POST['privileges'] as $p) {
                    $this->role_privilege->add([
                        'role_id' => $id,
                        'privilege_id' => $p
                    ]);
                }
                $if_show_tips = true;
            }
        }
        $this->view('role/assign', [
            'id' => $id,
            'role' => $this->role->get_one([
                'id' => $id
            ]),
            'privileges' => $this->privilege->get_all_privileges(),
            'if_show_tips' => $if_show_tips,
            'privilege_selected' => $this->role_privilege->get_privilege_by_role_id($id)
        ]);
    }


}
