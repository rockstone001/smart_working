<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends Base_Controller {
    public $desc = '老师管理';

    public $js = [
    ];

    public $css = [
        'index.css',  'bootstrap-table.min.css'
    ];

	public function index()
	{
        $this->js = array_merge($this->js, ['bootstrap-table.min.js', 'bootstrap-table-zh-CN.min.js', 'teacher_list.js']);
        $this->view('teacher/index');
	}

    public function new_teacher()
    {
        $this->js = array_merge($this->js, ['wangEditor.min.js', 'post.js']);
        $this->css = array_merge($this->css, ['uniform.default.css', 'wangEditor.min.css']);

        if(!isset($_POST['name'])) {
            $this->view('teacher/new_teacher');
        } else {
            $data = $this->get_post_params();
            $this->load->model('Teacher_model', 'teacher');
            if ($this->teacher->add($data)) {
                $this->redirect(config_item('index_url') . '/teacher/index');
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

        $this->load->model('Teacher_model', 'teacher');
        $data = $this->teacher->get_list([
            'state' => 1
        ], $params['limit'], $params['offset'], $params['name'], 'id, name, sex, location, birthday', 'name');

        $this->_json($data);
    }

    public function remove()
    {
        $params = $this->post_params([
            'post_ids'
        ]);
        $this->load->model('Teacher_model', 'teacher');
        if ($this->teacher->remove_batch($params['post_ids'])) {
            $this->_success();
        } else {
            $this->_error(Message::REMOVE_RECORD_FAILED['code'], Message::REMOVE_RECORD_FAILED['msg']);
        }
    }

    public function edit($id)
    {
        $this->js = array_merge($this->js, ['wangEditor.min.js', 'post.js']);
        $this->css = array_merge($this->css, ['uniform.default.css', 'wangEditor.min.css']);
        $this->load->model('Teacher_model', 'teacher');
        if(!isset($_POST['name'])) {
            $this->view('teacher/new_teacher', $this->teacher->get_one([
                'id' => $id
            ]));
        } else {
            $data = $this->get_post_params();
            if ($this->teacher->update($data, [
                'id' => $id
            ])) {
                $this->redirect(config_item('index_url') . '/teacher/index');
            } else {
                $this->_error(Message::UPDATE_RECORD_ERROR['code'], Message::UPDATE_RECORD_ERROR['msg']);
            }
        }
    }

    private function get_post_params()
    {
        $params = $this->post_params([
            'name', 'sex', 'location', 'birthday', 'headimgurl', 'summary'
        ]);
        return $params;
    }
}
