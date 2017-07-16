<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job extends Base_Controller {
    public $desc = '职位管理';

    public $js = [
    ];

    public $css = [
        'index.css',  'bootstrap-table.min.css'
    ];

	public function index()
	{
        $this->js = array_merge($this->js, ['bootstrap-table.min.js', 'bootstrap-table-zh-CN.min.js', 'job_list.js']);
        $this->view('job/index');
	}

    public function new_job()
    {
        $this->js = array_merge($this->js, ['job.js']);
        $this->css = array_merge($this->css, ['uniform.default.css',]);

        if(!isset($_POST['title'])) {
            $this->view('job/new_job', [
                'category' => $this->get_all_category()
            ]);
        } else {
            $data = $this->get_post_params();
            $this->load->model('Post_model', 'post');
            if ($this->post->add($data)) {
                $this->redirect(config_item('index_url') . '/job/index');
            } else {
                $this->_error(Message::ADD_RECORD_FAILED['code'], Message::ADD_RECORD_FAILED['msg']);
            }
        }
    }

    public function get_list()
    {
        $params = $this->get_params([
            'limit', 'offset', 'title'
        ]);

        $this->load->model('Post_model', 'post');
        $data = $this->post->get_post_list([
            'state' => 1,
            'tags' => '职位'
        ], $params['limit'], $params['offset'], $params['title']);

        $this->_json($this->format_data($data));
    }

    private function format_data($data)
    {
        $category = $this->get_all_category_2();;

        foreach ($data['rows'] as &$v) {
            $v['category'] = $category[$v['cate_id']];
        }
        return $data;
    }

    public function remove()
    {
        $params = $this->post_params([
            'post_ids'
        ]);
        $this->load->model('Post_model', 'post');
        if ($this->post->remove_batch($params['post_ids'])) {
            $this->_success();
        } else {
            $this->_error(Message::REMOVE_RECORD_FAILED['code'], Message::REMOVE_RECORD_FAILED['msg']);
        }
    }

    public function edit($id)
    {
        $this->js = array_merge($this->js, []);
        $this->css = array_merge($this->css, ['uniform.default.css',]);
        if(!isset($_POST['title'])) {
            $this->view('job/new_job', array_merge($this->get_post($id), [
                'category' => $this->get_all_category()
            ]));
        } else {
            $data = $this->get_post_params();
            $this->load->model('Post_model', 'post');
            if ($this->post->update($data, [
                'id' => $id
            ])) {
                $this->redirect(config_item('index_url') . '/job/index');
            } else {
                $this->_error(Message::UPDATE_RECORD_ERROR['code'], Message::UPDATE_RECORD_ERROR['msg']);
            }
        }
    }

    private function get_post_params()
    {
        $params = $this->post_params([
            'title', 'department', 'number', 'experience', 'degree', 'expire', 'description',
            'requirement', 'salary', 'link', 'sequence', 'cate_id'
        ]);

        $data = [
            'title' => $params['title'],
            'content' => json_encode($params),
            'tags' => '职位',
            'post_style' => 'post_style2',
            'cate_id' => $params['cate_id']
        ];
        return $data;
    }

    private function get_post($id)
    {
        $this->load->model('Post_model', 'post');
        $post = $this->post->get_one([
            'id' => $id,
        ]);
        if (!isset($post['id'])) {
            $this->_error(Message::NO_RECORD_ERROR['code'], Message::NO_RECORD_ERROR['msg']);
        }

        return array_merge([
            'id' => $id
        ], json_decode($post['content'], true));
    }

    private function get_all_category()
    {
        $this->load->model('Category_model', 'cate');
        return $this->cate->get_all_category();
    }

    private function get_all_category_2()
    {
        $this->load->model('Category_model', 'cate');
        return $this->cate->get_all_category_2();

    }
}
