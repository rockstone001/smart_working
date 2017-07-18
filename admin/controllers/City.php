<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class City extends Base_Controller {
    public $desc = '城市管理';

    public $js = [
    ];

    public $css = [
        'index.css',  'bootstrap-table.min.css'
    ];

    public $left_side = 'left_user.php';

    public function index()
	{
        $this->js = array_merge($this->js, ['bootstrap-table.min.js', 'bootstrap-table-zh-CN.min.js', 'city_list.js?v=1.1']);
        $this->view('city/index');
	}

    public function new_city()
    {
        $this->js = array_merge($this->js, ['city.js?v1.1']);

        if(!isset($_POST['name'])) {
            $this->load->model('Company_model', 'company');
            $this->view('city/new_city', [
                'companies' => $this->company->get_all_company(),
            ]);
        } else {
            $data = $this->post_params([
                'name', 'company_id'
            ]);
            $this->load->model('City_model', 'city');
            $city = $this->city->get_one([
                'name' => $data['name'],
                'state' => 1
            ]);
            if (isset($city['id'])) {
                $this->_error('400001', '城市名重复');
            }
            if ($this->city->add($data)) {
                $this->_success([
                    'link' => config_item('index_url') . '/city/index'
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

        $this->load->model('City_model', 'city');
        $data = $this->city->get_list([
            'state' => 1
        ], $params['limit'], $params['offset'], $params['name'], 'id, name, company_id', 'name');

        $this->load->model('Company_model', 'company');
        $companies = $this->company->get_all_company();
        foreach ($data['rows'] as &$v) {
            $v['company'] = $companies[$v['company_id']];
        }

        $this->_json($data);
    }


    public function remove()
    {
        $params = $this->post_params([
            'post_ids'
        ]);
        $this->load->model('City_model', 'city');
        if ($this->city->remove_batch($params['post_ids'])) {
            $this->_success();
        } else {
            $this->_error(Message::REMOVE_RECORD_FAILED['code'], Message::REMOVE_RECORD_FAILED['msg']);
        }
    }

    public function edit($id)
    {
        $this->js = array_merge($this->js, ['city.js']);
        $this->load->model('City_model', 'city');
        if(!isset($_POST['name'])) {
            $this->load->model('Company_model', 'company');
            $this->view('city/new_city', array_merge($this->city->get_one([
                'id' => $id
            ]), [
                'companies' => $this->company->get_all_company(),
            ]));
        } else {
            $data = $this->post_params([
                'name', 'company_id'
            ]);

            $city = $this->city->get_one([
                'name' => $data['name'],
                'id !=' => $id,
                'state' => 1
            ]);

            if (isset($city['id'])) {
                $this->_error('400001', '城市名重复');
            }

            if ($this->city->update($data, [
                'id' => $id
            ])) {
                $this->_success([
                    'link' => config_item('index_url') . '/city/index'
                ]);
            } else {
                $this->_error(Message::UPDATE_RECORD_ERROR['code'], Message::UPDATE_RECORD_ERROR['msg']);
            }
        }
    }
}
