<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends Base_Controller {
    public $desc = '公司管理';

    public $js = [
    ];

    public $css = [
        'index.css',  'bootstrap-table.min.css'
    ];

    public $left_side = 'left_user.php';

    public function index()
	{
        $this->js = array_merge($this->js, ['bootstrap-table.min.js', 'bootstrap-table-zh-CN.min.js', 'company_list.js?v=1.1']);
        $this->view('company/index');
	}

    public function new_company()
    {
        $this->js = array_merge($this->js, ['company.js']);

        if(!isset($_POST['name'])) {
            $this->view('company/new_company');
        } else {
            $data = $this->post_params([
                'name', 'desc', 'address', 'telephone'
            ]);
            $this->load->model('Company_model', 'company');
            $company = $this->company->get_one([
                'name' => $data['name'],
                'state' => 1
            ]);
            if (isset($company['id'])) {
                $this->_error('400001', '分公司名重复');
            }
            if ($this->company->add($data)) {
                $this->_success([
                    'link' => config_item('index_url') . '/company/index'
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

        $this->load->model('Company_model', 'company');
        $data = $this->company->get_list([
            'state' => 1
        ], $params['limit'], $params['offset'], $params['name'], 'id, name, desc', 'name');

        $this->_json($data);
    }


    public function remove()
    {
        $params = $this->post_params([
            'post_ids'
        ]);
        $this->load->model('Company_model', 'company');
        if ($this->company->remove_batch($params['post_ids'])) {
            $this->_success();
        } else {
            $this->_error(Message::REMOVE_RECORD_FAILED['code'], Message::REMOVE_RECORD_FAILED['msg']);
        }
    }

    public function edit($id)
    {
        $this->js = array_merge($this->js, ['company.js']);
        $this->load->model('Company_model', 'company');
        if(!isset($_POST['name'])) {
            $this->view('company/new_company', $this->company->get_one([
                'id' => $id
            ]));
        } else {
            $data = $this->post_params([
                'name', 'desc', 'address', 'telephone'
            ]);

            $company = $this->company->get_one([
                'name' => $data['name'],
                'id !=' => $id,
                'state' => 1
            ]);

            if (isset($company['id'])) {
                $this->_error(Message::ROLE_NAME_DUPLICATED['code'], Message::ROLE_NAME_DUPLICATED['msg']);
            }

            if ($this->company->update($data, [
                'id' => $id
            ])) {
                $this->_success([
                    'link' => config_item('index_url') . '/company/index'
                ]);
            } else {
                $this->_error(Message::UPDATE_RECORD_ERROR['code'], Message::UPDATE_RECORD_ERROR['msg']);
            }
        }
    }
}
