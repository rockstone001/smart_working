<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Base_Controller {
    public $desc = '分类页';

    public $css = [
        'index.css',  'bootstrap-table.min.css'
    ];

	public function index()
	{
        $this->js = array_merge($this->js, ['bootstrap-table.min.js', 'bootstrap-table-zh-CN.min.js', 'cate_list.js?v=1.0']);
        $this->view('category/index');
	}

    public function get_list()
    {
        $params = $this->get_params([
            'limit', 'offset', 'name'
        ]);

        $this->load->model('Category_model', 'post');
        $data = $this->post->get_cate_list([
            'state' => 1
        ], $params['limit'], $params['offset'], $params['name']);

        $this->_json($data);
    }

    public function new_cate()
    {
        if (!isset($_POST['name'])) {
            $this->js = array_merge($this->js, ['wangEditor.min.js', 'cate.js']);
            $this->css = array_merge($this->css, ['uniform.default.css', 'wangEditor.min.css']);
            $this->view('category/new_post');
        } else {
            $this->load->model('Category_model', 'category');
            if ($this->category->add($this->get_post_params())) {
                $this->redirect(config_item('index_url') . '/category/index');
            } else {
                $this->_error(Message::ADD_RECORD_FAILED['code'], Message::ADD_RECORD_FAILED['msg']);
            }
        }
    }

    public function remove()
    {
        $params = $this->post_params([
            'cate_ids'
        ]);
        $this->load->model('Category_model', 'category');
        if ($this->category->remove_batch($params['cate_ids'])) {
            $this->_success();
        } else {
            $this->_error(Message::REMOVE_RECORD_FAILED['code'], Message::REMOVE_RECORD_FAILED['msg']);
        }
    }

    public function edit($id)
    {
        $this->js = array_merge($this->js, ['wangEditor.min.js', 'cate.js']);
        $this->css = array_merge($this->css, ['uniform.default.css', 'wangEditor.min.css']);
        if(!isset($_POST['name'])) {
            $this->view('category/new_post', $this->get_post($id));
        } else {
            $data = $this->get_post_params();
            $this->load->model('Category_model', 'category');
            if ($this->category->update($data, [
                'id' => $id
            ])) {
                $this->redirect(config_item('index_url') . '/category/index');
            } else {
                $this->_error(Message::UPDATE_RECORD_ERROR['code'], Message::UPDATE_RECORD_ERROR['msg']);
            }
        }
    }

    private function get_post($id)
    {
        $this->load->model('Category_model', 'category');
        $post = $this->category->get_one([
            'id' => $id,
        ]);
        if (!isset($post['id'])) {
            $this->_error(Message::NO_RECORD_ERROR['code'], Message::NO_RECORD_ERROR['msg']);
        }
        $data = [
            'id' => $id,
            'name' => $post['name'],
            'main_pic' => $post['pic'],
            'desc' => $post['desc'],
            'list_style' => $post['list_style'],
        ];
        return $data;
    }

    private function get_post_params()
    {
        $params = $this->post_params([
            'name', 'main_pic', 'desc', 'list_style'
        ]);
        $data = [
            'name' => $params['name'],
            'pic' => $params['main_pic'],
            'desc' => $params['desc'],
            'list_style' => $params['list_style']
        ];
        return $data;
    }
}
