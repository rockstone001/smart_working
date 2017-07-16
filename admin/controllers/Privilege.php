<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privilege extends Base_Controller {
    public $desc = '角色管理';

    public $js = [
    ];

    public $css = [
        'index.css',  'bootstrap-table.min.css'
    ];

    public $left_side = 'left_user.php';

    public function index()
	{
        $this->js = array_merge($this->js, ['bootstrap-table.min.js', 'bootstrap-table-zh-CN.min.js', 'privilege_list.js?v=1.0']);
        $this->view('privilege/index');
	}

    public function new_privilege()
    {
        $this->js = array_merge($this->js, ['privilege.js']);

        if(!isset($_POST['name'])) {
            $this->view('privilege/new_privilege');
        } else {
            $data = $this->post_params([
                'name', 'action', 'desc'
            ]);
            $this->load->model('Privilege_model', 'privilege');
            $privilege = $this->privilege->get_one([
                'name' => $data['name'],
                'state' => 1
            ]);
            if (isset($privilege['id'])) {
                $this->_error(Message::PRIVILEGE_NAME_DUPLICATED['code'], Message::PRIVILEGE_NAME_DUPLICATED['msg']);
            }
            if ($this->privilege->add($data)) {
                $this->_success([
                    'link' => config_item('index_url') . '/privilege/index'
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

        $this->load->model('Privilege_model', 'privilege');
        $data = $this->privilege->get_list([
            'state' => 1
        ], $params['limit'], $params['offset'], $params['name'], 'id, name, action, desc', 'name');

        $this->_json($data);
    }


    public function remove()
    {
        $params = $this->post_params([
            'post_ids'
        ]);
        $this->load->model('Privilege_model', 'privilege');
        if ($this->privilege->remove_batch($params['post_ids'])) {
            $this->_success();
        } else {
            $this->_error(Message::REMOVE_RECORD_FAILED['code'], Message::REMOVE_RECORD_FAILED['msg']);
        }
    }

    public function edit($id)
    {
        $this->js = array_merge($this->js, ['privilege.js?v=1.0']);
        $this->load->model('Privilege_model', 'privilege');
        if(!isset($_POST['name'])) {
            $this->view('privilege/new_privilege', $this->privilege->get_one([
                'id' => $id
            ]));
        } else {
            $data = $this->post_params([
                'name', 'action', 'desc'
            ]);

            $privilege = $this->privilege->get_one([
                'name' => $data['name'],
                'id !=' => $id,
                'state' => 1
            ]);

            if (isset($privilege['id'])) {
                $this->_error(Message::PRIVILEGE_NAME_DUPLICATED['code'], Message::PRIVILEGE_NAME_DUPLICATED['msg']);
            }

            if ($this->privilege->update($data, [
                'id' => $id
            ])) {
                $this->_success([
                    'link' => config_item('index_url') . '/privilege/index'
                ]);
            } else {
                $this->_error(Message::UPDATE_RECORD_ERROR['code'], Message::UPDATE_RECORD_ERROR['msg']);
            }
        }
    }




}
