<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends Base_Controller {
    public $desc = '卖场管理';

    public $js = [
    ];

    public $css = [
        'index.css',  'bootstrap-table.min.css'
    ];

    public $left_side = 'left_user.php';

    public function index()
	{
        $this->js = array_merge($this->js, ['bootstrap-table.min.js', 'bootstrap-table-zh-CN.min.js', 'store_list.js?v=1.1']);
        $this->view('store/index');
	}

    public function new_store()
    {
        $this->js = array_merge($this->js, ['store.js?v1.1']);

        if(!isset($_POST['name'])) {
            $this->load->model('City_model', 'city');
            $this->view('store/new_store', [
                'cities' => $this->city->get_all_city()
            ]);
        } else {
            $data = $this->post_params([
                'name', 'city_id', 'address', 'telephone'
            ]);
            $this->load->model('Store_model', 'store');
            $store = $this->store->get_one([
                'name' => $data['name'],
                'state' => 1
            ]);
            if (isset($store['id'])) {
                $this->_error('400001', '卖场名重复');
            }
            if ($this->store->add($data)) {
                $this->_success([
                    'link' => config_item('index_url') . '/store/index'
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

        $this->load->model('Store_model', 'store');
        $this->load->model('City_model', 'city');
        $data = $this->store->get_list([
            'state' => 1
        ], $params['limit'], $params['offset'], $params['name'], 'id, name, city_id', 'name');

        $city = $this->city->get_all_city();
        foreach ($data['rows'] as &$v) {
            $v['city'] = $city[$v['city_id']];
        }

        $this->_json($data);
    }


    public function remove()
    {
        $params = $this->post_params([
            'post_ids'
        ]);
        $this->load->model('Store_model', 'store');
        if ($this->store->remove_batch($params['post_ids'])) {
            $this->_success();
        } else {
            $this->_error(Message::REMOVE_RECORD_FAILED['code'], Message::REMOVE_RECORD_FAILED['msg']);
        }
    }

    public function edit($id)
    {
        $this->js = array_merge($this->js, ['store.js?v1.1']);
        $this->load->model('Store_model', 'store');
        if(!isset($_POST['name'])) {
            $this->load->model('City_model', 'city');
            $this->view('store/new_store', array_merge($this->store->get_one([
                'id' => $id
            ]), [
                'cities' => $this->city->get_all_city()
            ]));
        } else {
            $data = $this->post_params([
                'name', 'city_id', 'address', 'telephone'
            ]);

            $store = $this->store->get_one([
                'name' => $data['name'],
                'id !=' => $id,
                'state' => 1
            ]);

            if (isset($store['id'])) {
                $this->_error('400001', '卖场名重复');
            }

            if ($this->store->update($data, [
                'id' => $id
            ])) {
                $this->_success([
                    'link' => config_item('index_url') . '/store/index'
                ]);
            } else {
                $this->_error(Message::UPDATE_RECORD_ERROR['code'], Message::UPDATE_RECORD_ERROR['msg']);
            }
        }
    }
}
