<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends Base_Controller {
    public $desc = '菜单管理';

    public $css = [
        'index.css',  'bootstrap-table.min.css'
    ];

	public function index()
	{
        $this->js = array_merge($this->js, ['bootstrap-table.min.js', 'bootstrap-table-zh-CN.min.js', 'menu_list.js']);
        $this->view('menu/index');
	}

    public function get_list()
    {
        $params = $this->get_params([
            'limit', 'offset', 'name'
        ]);

        $this->load->model('Menu_model', 'menu');
        $data = $this->menu->get_menu_list($params['name'], $params['limit'], $params['offset']);

        $this->_json($data);
    }

    public function new_menu()
    {
        if (!isset($_POST['name'])) {
            $this->css = array_merge($this->css, ['uniform.default.css']);
            $this->view('menu/new_menu', [
                'menu' => $this->get_all_menu(),
                'links' => $this->get_all_available_links()
            ]);
        } else {
            $this->load->model('Menu_model', 'menu');
            if ($this->menu->add($this->get_post_params())) {
                $this->redirect(config_item('index_url') . '/menu/index');
            } else {
                $this->_error(Message::ADD_RECORD_FAILED['code'], Message::ADD_RECORD_FAILED['msg']);
            }
        }
    }

    public function remove()
    {
        $params = $this->post_params([
            'menu_ids'
        ]);
        $this->load->model('Menu_model', 'menu');
        if ($this->menu->remove_batch($params['menu_ids'])) {
            $this->_success();
        } else {
            $this->_error(Message::REMOVE_RECORD_FAILED['code'], Message::REMOVE_RECORD_FAILED['msg']);
        }
    }

    public function edit($id)
    {
        $this->css = array_merge($this->css, ['uniform.default.css']);
        if(!isset($_POST['name'])) {
            $this->view('menu/new_menu', array_merge($this->get_menu($id), [
                'menu' => $this->get_all_menu(),
                'links' => $this->get_all_available_links()
            ]));
        } else {
            $data = $this->get_post_params();
            $this->load->model('Menu_model', 'menu');
            if ($this->menu->update($data, [
                'id' => $id
            ])) {
                $this->redirect(config_item('index_url') . '/menu/index');
            } else {
                $this->_error(Message::UPDATE_RECORD_ERROR['code'], Message::UPDATE_RECORD_ERROR['msg']);
            }
        }
    }

    private function get_menu($id)
    {
        $this->load->model('Menu_model', 'menu');
        $menu = $this->menu->get_one([
            'id' => $id,
        ]);
        if (!isset($menu['id'])) {
            $this->_error(Message::NO_RECORD_ERROR['code'], Message::NO_RECORD_ERROR['msg']);
        }
        $data = [
            'id' => $id,
            'name' => $menu['name'],
            'parent_id' => $menu['parent_id'],
            'link' => $menu['link'],
            'sequence' => $menu['sequence'],
            'custom_link' => $menu['custom_link'],
        ];
        return $data;
    }

    private function get_post_params()
    {
        return $this->post_params([
            'name', 'parent_id', 'link', 'sequence', 'custom_link'
        ]);
    }

    private function get_all_menu()
    {
        $this->load->model('Menu_model', 'menu');
        return $this->menu->get_all_menu();
    }

    private function get_all_available_links()
    {
        $this->load->model('Category_model', 'cate');
        $this->load->model('Post_model', 'post');
        return array_merge([[
            'link' => '',
            'title' => '首页'
        ]], $this->cate->get_all_available_cate_link(),
            $this->post->get_all_available_post_link());
    }
}
